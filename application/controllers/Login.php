<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Cargar helpers necesarios
        $this->load->helper(['url', 'form']);
        $this->load->library(['form_validation', 'session']);
    }

    public function index() {
        // Si ya está logueado, redirigir al dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        
        $this->load->view('login_view');
    }

    public function authenticate() {
        // Validar formulario
        $this->form_validation->set_rules('username', 'Usuario', 'required|trim');
        $this->form_validation->set_rules('password', 'Contraseña', 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login_view');
        } else {
            // Aquí iría la lógica de autenticación
            // Por ahora solo simulamos el login
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            
            // Validación simple (en producción usarías base de datos)
            if ($username === 'admin' && $password === 'admin') {
                $this->session->set_userdata('logged_in', true);
                $this->session->set_userdata('username', $username);
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Usuario o contraseña incorrectos');
                redirect('login');
            }
        }
    }

    public function logout() {
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('username');
        $this->session->sess_destroy();
        redirect('login');
    }
}
