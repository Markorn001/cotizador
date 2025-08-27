<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Obtener todos los clientes
    public function get_all_clients() {
        $this->db->select('id, nombre, empresa, contacto, email, origen, observaciones, status, created_at, updated_at');
        $this->db->from('clients');
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    // Obtener cliente por ID
    public function get_client_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('clients');
        return $query->row();
    }

    // Obtener cliente por nombre
    public function get_client_by_name($nombre) {
        $this->db->like('nombre', $nombre);
        $query = $this->db->get('clients');
        return $query->result();
    }

    // Obtener cliente por empresa
    public function get_client_by_company($empresa) {
        $this->db->like('empresa', $empresa);
        $query = $this->db->get('clients');
        return $query->result();
    }

    // Crear nuevo cliente
    public function create_client($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['status'] = 'active';
        
        return $this->db->insert('clients', $data);
    }

    // Actualizar cliente
    public function update_client($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        return $this->db->update('clients', $data);
    }

    // Eliminar cliente
    public function delete_client($id) {
        $this->db->where('id', $id);
        return $this->db->delete('clients');
    }

    // Cambiar estado del cliente
    public function change_client_status($id, $status) {
        $this->db->where('id', $id);
        return $this->db->update('clients', ['status' => $status, 'updated_at' => date('Y-m-d H:i:s')]);
    }

    // Buscar clientes
    public function search_clients($search_term) {
        $this->db->like('nombre', $search_term);
        $this->db->or_like('empresa', $search_term);
        $this->db->or_like('email', $search_term);
        $this->db->or_like('contacto', $search_term);
        $this->db->or_like('observaciones', $search_term);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('clients');
        return $query->result();
    }

    // Obtener clientes por origen
    public function get_clients_by_origin($origen) {
        $this->db->where('origen', $origen);
        $this->db->where('status', 'active');
        $query = $this->db->get('clients');
        return $query->result();
    }

    // Obtener estadísticas de clientes
    public function get_client_stats() {
        $stats = [
            'total' => $this->db->count_all('clients'),
            'active' => $this->db->where('status', 'active')->count_all_results('clients'),
            'inactive' => $this->db->where('status', 'inactive')->count_all_results('clients'),
            'with_company' => $this->db->where('empresa IS NOT NULL')->where('empresa !=', '')->count_all_results('clients'),
            'with_email' => $this->db->where('email IS NOT NULL')->where('email !=', '')->count_all_results('clients'),
            'whatsapp' => $this->db->where('origen', 'WhatsApp')->count_all_results('clients')
        ];
        
        return $stats;
    }

    // Verificar si el email existe
    public function email_exists($email, $exclude_id = null) {
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        $this->db->where('email', $email);
        return $this->db->count_all_results('clients') > 0;
    }

    // Obtener clientes activos
    public function get_active_clients() {
        $this->db->where('status', 'active');
        $this->db->order_by('nombre', 'ASC');
        $query = $this->db->get('clients');
        return $query->result();
    }
}
