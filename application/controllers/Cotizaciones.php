<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cotizaciones extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->load->library(['form_validation', 'session']);
        $this->load->model(['Quotation_model', 'Client_model']);
        
        // Verificar si está logueado
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index() {
        // Parámetros de búsqueda y paginación
        $search = $this->input->get('search');
        $status_filter = $this->input->get('status');
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $page = $this->input->get('page') ? $this->input->get('page') : 1;
        $per_page = 20; // Elementos por página
        
        // Obtener información del usuario actual
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');
        
        // Obtener cotizaciones con filtros y paginación (incluyendo filtro por rol)
        $data['quotations'] = $this->Quotation_model->get_quotations_with_filters($search, $status_filter, $date_from, $date_to, $page, $per_page, $user_id, $user_role);
        $data['total_quotations'] = $this->Quotation_model->count_quotations_with_filters($search, $status_filter, $date_from, $date_to, $user_id, $user_role);
        $data['total_pages'] = ceil($data['total_quotations'] / $per_page);
        $data['current_page'] = $page;
        $data['per_page'] = $per_page;
        
        // Parámetros de búsqueda para mantener en la paginación
        $data['search_params'] = [
            'search' => $search,
            'status' => $status_filter,
            'date_from' => $date_from,
            'date_to' => $date_to
        ];
        
        $data['title'] = 'Gestión de Cotizaciones';
        
        $this->load->view('cotizaciones/index', $data);
    }

    public function create() {
        if ($this->input->method() === 'post') {
            // Validar formulario
            $this->form_validation->set_rules('client_id', 'Cliente', 'required|numeric');
            $this->form_validation->set_rules('quotation_date', 'Fecha de Cotización', 'required');
            $this->form_validation->set_rules('validity_days', 'Días de Vigencia', 'required|numeric');
            $this->form_validation->set_rules('currency', 'Moneda', 'required');
            $this->form_validation->set_rules('payment_terms', 'Condiciones de Pago', 'required');
            $this->form_validation->set_rules('delivery_location', 'Lugar de Entrega', 'required');
            $this->form_validation->set_rules('tax_rate', 'Tasa de Impuesto', 'required|numeric');
            
            if ($this->form_validation->run() == FALSE) {
                $data['clients'] = $this->Client_model->get_active_clients();
                $data['title'] = 'Crear Cotización';
                $this->load->view('cotizaciones/create', $data);
            } else {
                // Obtener datos del cliente
                $client = $this->Client_model->get_client_by_id($this->input->post('client_id'));
                
                // Preparar datos de la cotización
                $quotation_data = [
                    'client_id' => $this->input->post('client_id'),
                    'client_name' => $client->nombre,
                    'client_company' => $client->empresa,
                    'client_contact' => $client->contacto,
                    'client_email' => $client->email,
                    'quotation_date' => $this->input->post('quotation_date'),
                    'validity_days' => $this->input->post('validity_days'),
                    'currency' => $this->input->post('currency'),
                    'payment_terms' => $this->input->post('payment_terms'),
                    'delivery_location' => $this->input->post('delivery_location'),
                    'tax_rate' => $this->input->post('tax_rate'),
                    'notes' => $this->input->post('notes'),
                    'status' => 'draft',
                    'created_by' => $this->session->userdata('user_id')
                ];
                
                // Procesar items
                $items = [];
                $item_descriptions = $this->input->post('item_description');
                $item_part_numbers = $this->input->post('item_part_number');
                $item_quantities = $this->input->post('item_quantity');
                $item_unit_prices = $this->input->post('item_unit_price');
                $item_delivery_times = $this->input->post('item_delivery_time');
                
                if (is_array($item_descriptions)) {
                    for ($i = 0; $i < count($item_descriptions); $i++) {
                        if (!empty($item_descriptions[$i])) {
                            $quantity = floatval($item_quantities[$i]);
                            $unit_price = floatval($item_unit_prices[$i]);
                            $subtotal = $quantity * $unit_price;
                            
                            $items[] = [
                                'item_number' => $i + 1,
                                'description' => $item_descriptions[$i],
                                'part_number' => $item_part_numbers[$i],
                                'quantity' => $quantity,
                                'unit_price' => $unit_price,
                                'subtotal' => $subtotal,
                                'delivery_time' => $item_delivery_times[$i]
                            ];
                        }
                    }
                }
                
                $quotation_data['items'] = $items;
                
                if ($this->Quotation_model->create_quotation($quotation_data)) {
                    $this->session->set_flashdata('success', 'Cotización creada exitosamente');
                    redirect('cotizaciones');
                } else {
                    $this->session->set_flashdata('error', 'Error al crear la cotización');
                    redirect('cotizaciones/create');
                }
            }
        } else {
            $data['clients'] = $this->Client_model->get_active_clients();
            $data['title'] = 'Crear Cotización';
            $this->load->view('cotizaciones/create', $data);
        }
    }

    public function view($id) {
        $quotation = $this->Quotation_model->get_quotation_by_id($id);
        if (!$quotation) {
            $this->session->set_flashdata('error', 'Cotización no encontrada');
            redirect('cotizaciones');
        }
        
        $data['quotation'] = $quotation;
        $data['quotation_items'] = $this->Quotation_model->get_quotation_items($id);
        $data['client'] = $this->Client_model->get_client_by_id($quotation->client_id);
        $data['title'] = 'Ver Cotización';
        
        $this->load->view('cotizaciones/view', $data);
    }

    public function edit($id) {
        $quotation = $this->Quotation_model->get_quotation_by_id($id);
        if (!$quotation) {
            $this->session->set_flashdata('error', 'Cotización no encontrada');
            redirect('cotizaciones');
        }
        
        if ($this->input->method() === 'post') {
            // Validar formulario
            $this->form_validation->set_rules('client_id', 'Cliente', 'required|numeric');
            $this->form_validation->set_rules('quotation_date', 'Fecha de Cotización', 'required');
            $this->form_validation->set_rules('validity_days', 'Días de Vigencia', 'required|numeric');
            $this->form_validation->set_rules('currency', 'Moneda', 'required');
            $this->form_validation->set_rules('payment_terms', 'Condiciones de Pago', 'required');
            $this->form_validation->set_rules('delivery_location', 'Lugar de Entrega', 'required');
            $this->form_validation->set_rules('tax_rate', 'Tasa de Impuesto', 'required|numeric');
            
            if ($this->form_validation->run() == FALSE) {
                $data['quotation'] = $quotation;
                $data['quotation_items'] = $this->Quotation_model->get_quotation_items($id);
                $data['clients'] = $this->Client_model->get_active_clients();
                $data['title'] = 'Editar Cotización';
                $this->load->view('cotizaciones/edit', $data);
            } else {
                // Obtener datos del cliente
                $client = $this->Client_model->get_client_by_id($this->input->post('client_id'));
                
                // Preparar datos de la cotización
                $quotation_data = [
                    'client_id' => $this->input->post('client_id'),
                    'client_name' => $client->nombre,
                    'client_company' => $client->empresa,
                    'client_contact' => $client->contacto,
                    'client_email' => $client->email,
                    'quotation_date' => $this->input->post('quotation_date'),
                    'validity_days' => $this->input->post('validity_days'),
                    'currency' => $this->input->post('currency'),
                    'payment_terms' => $this->input->post('payment_terms'),
                    'delivery_location' => $this->input->post('delivery_location'),
                    'tax_rate' => $this->input->post('tax_rate'),
                    'notes' => $this->input->post('notes')
                ];
                
                // Procesar items
                $items = [];
                $item_descriptions = $this->input->post('item_description');
                $item_part_numbers = $this->input->post('item_part_number');
                $item_quantities = $this->input->post('item_quantity');
                $item_unit_prices = $this->input->post('item_unit_price');
                $item_delivery_times = $this->input->post('item_delivery_time');
                
                if (is_array($item_descriptions)) {
                    for ($i = 0; $i < count($item_descriptions); $i++) {
                        if (!empty($item_descriptions[$i])) {
                            $quantity = floatval($item_quantities[$i]);
                            $unit_price = floatval($item_unit_prices[$i]);
                            $subtotal = $quantity * $unit_price;
                            
                            $items[] = [
                                'item_number' => $i + 1,
                                'description' => $item_descriptions[$i],
                                'part_number' => $item_part_numbers[$i],
                                'quantity' => $quantity,
                                'unit_price' => $unit_price,
                                'subtotal' => $subtotal,
                                'delivery_time' => $item_delivery_times[$i]
                            ];
                        }
                    }
                }
                
                $quotation_data['items'] = $items;
                
                if ($this->Quotation_model->update_quotation($id, $quotation_data)) {
                    $this->session->set_flashdata('success', 'Cotización actualizada exitosamente');
                    redirect('cotizaciones');
                } else {
                    $this->session->set_flashdata('error', 'Error al actualizar la cotización');
                    redirect('cotizaciones/edit/'.$id);
                }
            }
        } else {
            $data['quotation'] = $quotation;
            $data['quotation_items'] = $this->Quotation_model->get_quotation_items($id);
            $data['clients'] = $this->Client_model->get_active_clients();
            $data['title'] = 'Editar Cotización';
            $this->load->view('cotizaciones/edit', $data);
        }
    }

    public function print($id) {
        $quotation = $this->Quotation_model->get_quotation_by_id($id);
        if (!$quotation) {
            $this->session->set_flashdata('error', 'Cotización no encontrada');
            redirect('cotizaciones');
        }
        
        $data['quotation'] = $quotation;
        $data['quotation_items'] = $this->Quotation_model->get_quotation_items($id);
        $data['client'] = $this->Client_model->get_client_by_id($quotation->client_id);
        
        $this->load->view('cotizaciones/print', $data);
    }
    
    public function change_status($id, $status) {
        if (!$id || !$status) {
            $this->session->set_flashdata('error', 'Parámetros inválidos');
            redirect('cotizaciones');
        }
        
        // Validar que el estado sea válido
        $valid_statuses = ['draft', 'sent', 'approved', 'rejected', 'expired'];
        if (!in_array($status, $valid_statuses)) {
            $this->session->set_flashdata('error', 'Estado inválido');
            redirect('cotizaciones');
        }
        
        // Verificar que la cotización existe
        $quotation = $this->Quotation_model->get_quotation_by_id($id);
        if (!$quotation) {
            $this->session->set_flashdata('error', 'Cotización no encontrada');
            redirect('cotizaciones');
        }
        
        // Cambiar el estado
        if ($this->Quotation_model->change_quotation_status($id, $status)) {
            $status_texts = [
                'draft' => 'Borrador',
                'sent' => 'Enviada',
                'approved' => 'Aprobada',
                'rejected' => 'Rechazada',
                'expired' => 'Expirada'
            ];
            
            $status_text = $status_texts[$status] ?? $status;
            $this->session->set_flashdata('success', "Cotización #{$quotation->quotation_number} actualizada a estado: {$status_text}");
        } else {
            $this->session->set_flashdata('error', 'Error al cambiar el estado de la cotización');
        }
        
        redirect('cotizaciones');
    }
}
