<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->load->library(['form_validation', 'session']);
        $this->load->model('Client_model');
        
        // Verificar si está logueado
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index() {
        $data['clients'] = $this->Client_model->get_all_clients();
        $data['stats'] = $this->Client_model->get_client_stats();
        $data['title'] = 'Gestión de Clientes';
        
        $this->load->view('clients/index', $data);
    }

    public function create() {
        if ($this->input->method() === 'post') {
            // Validar formulario
            $this->form_validation->set_rules('nombre', 'Nombre', 'required|min_length[3]|max_length[100]');
            $this->form_validation->set_rules('empresa', 'Empresa', 'max_length[150]');
            $this->form_validation->set_rules('contacto', 'Contacto', 'max_length[20]');
            $this->form_validation->set_rules('email', 'Email', 'valid_email|max_length[100]');
            $this->form_validation->set_rules('origen', 'Origen', 'max_length[50]');
            $this->form_validation->set_rules('observaciones', 'Observaciones', 'max_length[500]');
            
            if ($this->form_validation->run() == FALSE) {
                $data['title'] = 'Crear Cliente';
                $this->load->view('clients/create', $data);
            } else {
                $client_data = [
                    'nombre' => $this->input->post('nombre'),
                    'empresa' => $this->input->post('empresa'),
                    'contacto' => $this->input->post('contacto'),
                    'email' => $this->input->post('email'),
                    'origen' => $this->input->post('origen'),
                    'observaciones' => $this->input->post('observaciones')
                ];
                
                if ($this->Client_model->create_client($client_data)) {
                    $this->session->set_flashdata('success', 'Cliente creado exitosamente');
                    redirect('clients');
                } else {
                    $this->session->set_flashdata('error', 'Error al crear el cliente');
                    redirect('clients/create');
                }
            }
        } else {
            $data['title'] = 'Crear Cliente';
            $this->load->view('clients/create', $data);
        }
    }

    public function edit($id = null) {
        if (!$id) {
            redirect('clients');
        }
        
        $client = $this->Client_model->get_client_by_id($id);
        if (!$client) {
            $this->session->set_flashdata('error', 'Cliente no encontrado');
            redirect('clients');
        }
        
        if ($this->input->method() === 'post') {
            // Validar formulario
            $this->form_validation->set_rules('nombre', 'Nombre', 'required|min_length[3]|max_length[100]');
            $this->form_validation->set_rules('empresa', 'Empresa', 'max_length[150]');
            $this->form_validation->set_rules('contacto', 'Contacto', 'max_length[20]');
            $this->form_validation->set_rules('email', 'Email', 'valid_email|max_length[100]');
            $this->form_validation->set_rules('origen', 'Origen', 'max_length[50]');
            $this->form_validation->set_rules('observaciones', 'Observaciones', 'max_length[500]');
            
            // Validar email único (excluyendo el cliente actual)
            $email = $this->input->post('email');
            if ($email && $email !== $client->email && $this->Client_model->email_exists($email, $id)) {
                $this->form_validation->set_message('email_exists', 'El email ya existe');
                $this->form_validation->set_rules('email', 'Email', 'email_exists');
            }
            
            if ($this->form_validation->run() == FALSE) {
                $data['client'] = $client;
                $data['title'] = 'Editar Cliente';
                $this->load->view('clients/edit', $data);
            } else {
                $client_data = [
                    'nombre' => $this->input->post('nombre'),
                    'empresa' => $this->input->post('empresa'),
                    'contacto' => $this->input->post('contacto'),
                    'email' => $this->input->post('email'),
                    'origen' => $this->input->post('origen'),
                    'observaciones' => $this->input->post('observaciones'),
                    'status' => $this->input->post('status')
                ];
                
                if ($this->Client_model->update_client($id, $client_data)) {
                    $this->session->set_flashdata('success', 'Cliente actualizado exitosamente');
                    redirect('clients');
                } else {
                    $this->session->set_flashdata('error', 'Error al actualizar el cliente');
                    redirect('clients/edit/' . $id);
                }
            }
        } else {
            $data['client'] = $client;
            $data['title'] = 'Editar Cliente';
            $this->load->view('clients/edit', $data);
        }
    }

    public function delete($id = null) {
        if (!$id) {
            redirect('clients');
        }
        
        if ($this->Client_model->delete_client($id)) {
            $this->session->set_flashdata('success', 'Cliente eliminado exitosamente');
        } else {
            $this->session->set_flashdata('error', 'Error al eliminar el cliente');
        }
        
        redirect('clients');
    }

    public function change_status($id = null, $status = null) {
        if (!$id || !$status) {
            redirect('clients');
        }
        
        if ($this->Client_model->change_client_status($id, $status)) {
            $status_text = ($status == 'active') ? 'activado' : 'desactivado';
            $this->session->set_flashdata('success', "Cliente $status_text exitosamente");
        } else {
            $this->session->set_flashdata('error', 'Error al cambiar el estado del cliente');
        }
        
        redirect('clients');
    }

    public function search() {
        $search_term = $this->input->get('q');
        
        if ($search_term) {
            $data['clients'] = $this->Client_model->search_clients($search_term);
            $data['search_term'] = $search_term;
        } else {
            $data['clients'] = $this->Client_model->get_all_clients();
            $data['search_term'] = '';
        }
        
        $data['stats'] = $this->Client_model->get_client_stats();
        $data['title'] = 'Búsqueda de Clientes';
        
        $this->load->view('clients/search', $data);
    }

    public function view($id = null) {
        if (!$id) {
            redirect('clients');
        }
        
        $client = $this->Client_model->get_client_by_id($id);
        if (!$client) {
            $this->session->set_flashdata('error', 'Cliente no encontrado');
            redirect('clients');
        }
        
        $data['client'] = $client;
        $data['title'] = 'Ver Cliente';
        
        $this->load->view('clients/view', $data);
    }
}
