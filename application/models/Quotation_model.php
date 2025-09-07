<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quotation_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'quotations';
    }

    /**
     * Obtener todas las cotizaciones
     */
    public function get_all_quotations() {
        $this->db->select('q.*, u.username as created_by_name');
        $this->db->from($this->table . ' q');
        $this->db->join('users u', 'u.id = q.created_by', 'left');
        $this->db->order_by('q.created_at', 'DESC');
        
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Obtener cotizaciones con filtros y paginación
     */
    public function get_quotations_with_filters($search = '', $status = '', $date_from = '', $date_to = '', $page = 1, $per_page = 20, $user_id = null, $user_role = null) {
        $this->db->select('q.*, u.username as created_by_name');
        $this->db->from($this->table . ' q');
        $this->db->join('users u', 'u.id = q.created_by', 'left');
        
        // Aplicar filtro por rol de usuario
        if ($user_role === 'vendedor' && $user_id) {
            // Los vendedores solo ven sus propias cotizaciones
            $this->db->where('q.created_by', $user_id);
        }
        // Los supervisores y administradores ven todas las cotizaciones (no se aplica filtro adicional)
        
        // Aplicar filtros
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('q.quotation_number', $search);
            $this->db->or_like('q.client_name', $search);
            $this->db->or_like('q.client_company', $search);
            $this->db->or_like('q.client_contact', $search);
            $this->db->group_end();
        }
        
        if (!empty($status)) {
            $this->db->where('q.status', $status);
        }
        
        if (!empty($date_from)) {
            $this->db->where('q.quotation_date >=', $date_from);
        }
        
        if (!empty($date_to)) {
            $this->db->where('q.quotation_date <=', $date_to);
        }
        
        // Ordenar por fecha de creación descendente
        $this->db->order_by('q.created_at', 'DESC');
        
        // Aplicar paginación
        $offset = ($page - 1) * $per_page;
        $this->db->limit($per_page, $offset);
        
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Contar cotizaciones con filtros
     */
    public function count_quotations_with_filters($search = '', $status = '', $date_from = '', $date_to = '', $user_id = null, $user_role = null) {
        $this->db->from($this->table . ' q');
        $this->db->join('users u', 'u.id = q.created_by', 'left');
        
        // Aplicar filtro por rol de usuario
        if ($user_role === 'vendedor' && $user_id) {
            // Los vendedores solo ven sus propias cotizaciones
            $this->db->where('q.created_by', $user_id);
        }
        // Los supervisores y administradores ven todas las cotizaciones (no se aplica filtro adicional)
        
        // Aplicar filtros
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('q.quotation_number', $search);
            $this->db->or_like('q.client_name', $search);
            $this->db->or_like('q.client_company', $search);
            $this->db->or_like('q.client_contact', $search);
            $this->db->group_end();
        }
        
        if (!empty($status)) {
            $this->db->where('q.status', $status);
        }
        
        if (!empty($date_from)) {
            $this->db->where('q.quotation_date >=', $date_from);
        }
        
        if (!empty($date_to)) {
            $this->db->where('q.quotation_date <=', $date_to);
        }
        
        return $this->db->count_all_results();
    }

    /**
     * Obtener cotización por ID
     */
    public function get_quotation_by_id($id) {
        $this->db->select('q.*, u.username as created_by_name');
        $this->db->from($this->table . ' q');
        $this->db->join('users u', 'u.id = q.created_by', 'left');
        $this->db->where('q.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * Obtener items de una cotización
     */
    public function get_quotation_items($quotation_id) {
        $this->db->where('quotation_id', $quotation_id);
        $this->db->order_by('item_number', 'ASC');
        $query = $this->db->get('quotation_items');
        return $query->result();
    }

    /**
     * Crear nueva cotización
     */
    public function create_quotation($data) {
        $this->db->trans_start();
        
        try {
            // Generar número de cotización automático
            $data['quotation_number'] = $this->generate_quotation_number();
            
            // Calcular totales
            $subtotal = 0;
            if (isset($data['items']) && is_array($data['items'])) {
                foreach ($data['items'] as $item) {
                    $subtotal += $item['subtotal'];
                }
            }
            
            $data['subtotal'] = $subtotal;
            $data['tax_amount'] = ($subtotal * $data['tax_rate']) / 100;
            $data['total'] = $subtotal + $data['tax_amount'];
            
            // Remover items del array principal
            $items = $data['items'];
            unset($data['items']);
            
            // Insertar cotización
            $this->db->insert($this->table, $data);
            $quotation_id = $this->db->insert_id();
            
            // Insertar items
            if (!empty($items)) {
                foreach ($items as $item) {
                    $item['quotation_id'] = $quotation_id;
                    $this->db->insert('quotation_items', $item);
                }
            }
            
            $this->db->trans_complete();
            return $this->db->trans_status();
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Error creating quotation: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Generar número de cotización automático
     */
    private function generate_quotation_number() {
        $prefix = 'G-';
        $date = date('mdY');
        $suffix = '001';
        
        // Buscar la última cotización del día
        $this->db->where('quotation_number LIKE', $prefix . $date . '-%');
        $this->db->order_by('quotation_number', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        
        if ($query->num_rows() > 0) {
            $last_number = $query->row()->quotation_number;
            $last_suffix = intval(substr($last_number, -3));
            $suffix = str_pad($last_suffix + 1, 3, '0', STR_PAD_LEFT);
        }
        
        return $prefix . $date . '-' . $suffix;
    }

    /**
     * Actualizar cotización existente
     */
    public function update_quotation($id, $data) {
        $this->db->trans_start();
        
        try {
            // Calcular totales
            $subtotal = 0;
            if (isset($data['items']) && is_array($data['items'])) {
                foreach ($data['items'] as $item) {
                    $subtotal += $item['subtotal'];
                }
            }
            
            $data['subtotal'] = $subtotal;
            $data['tax_amount'] = ($subtotal * $data['tax_rate']) / 100;
            $data['total'] = $subtotal + $data['tax_amount'];
            $data['updated_at'] = date('Y-m-d H:i:s');
            
            // Remover items del array principal
            $items = $data['items'];
            unset($data['items']);
            
            // Actualizar cotización
            $this->db->where('id', $id);
            $this->db->update($this->table, $data);
            
            // Eliminar items existentes
            $this->db->where('quotation_id', $id);
            $this->db->delete('quotation_items');
            
            // Insertar nuevos items
            if (!empty($items)) {
                foreach ($items as $item) {
                    $item['quotation_id'] = $id;
                    $this->db->insert('quotation_items', $item);
                }
            }
            
            $this->db->trans_complete();
            return $this->db->trans_status();
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Error updating quotation: ' . $e->getMessage());
            return false;
        }
    }
    
    // Contar cotizaciones por estado
    public function count_quotations_by_status($status, $user_id = null, $user_role = null) {
        $this->db->where('status', $status);
        
        // Aplicar filtro por rol de usuario
        if ($user_role === 'vendedor' && $user_id) {
            $this->db->where('created_by', $user_id);
        }
        // Los supervisores y administradores ven todas las cotizaciones (no se aplica filtro adicional)
        
        return $this->db->count_all_results($this->table);
    }
    
    // Contar cotizaciones aprobadas por mes
    public function count_approved_quotations_by_month($year, $month, $user_id = null, $user_role = null) {
        $this->db->where('status', 'approved');
        $this->db->where('YEAR(quotation_date)', $year);
        $this->db->where('MONTH(quotation_date)', $month);
        
        // Aplicar filtro por rol de usuario
        if ($user_role === 'vendedor' && $user_id) {
            $this->db->where('created_by', $user_id);
        }
        // Los supervisores y administradores ven todas las cotizaciones (no se aplica filtro adicional)
        
        return $this->db->count_all_results($this->table);
    }
    
    // Sumar montos de cotizaciones aprobadas por mes
    public function sum_approved_quotations_by_month($year, $month, $user_id = null, $user_role = null) {
        $this->db->select('SUM(total) as total_amount');
        $this->db->where('status', 'approved');
        $this->db->where('YEAR(quotation_date)', $year);
        $this->db->where('MONTH(quotation_date)', $month);
        
        // Aplicar filtro por rol de usuario
        if ($user_role === 'vendedor' && $user_id) {
            $this->db->where('created_by', $user_id);
        }
        // Los supervisores y administradores ven todas las cotizaciones (no se aplica filtro adicional)
        
        $query = $this->db->get($this->table);
        $result = $query->row();
        return $result ? $result->total_amount : 0;
    }
    
    // Cambiar estado de una cotización
    public function change_quotation_status($id, $status) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
