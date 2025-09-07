<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->load->library(['form_validation', 'session']);
        $this->load->model('User_model');
        
        // Verificar si está logueado
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        
        // Verificar si es administrador o supervisor
        $user_role = $this->session->userdata('role');
        if (!in_array($user_role, ['admin', 'supervisor'])) {
            $this->session->set_flashdata('error', 'No tienes permisos para acceder a esta sección');
            redirect('dashboard');
        }
    }

    public function index() {
        $data['users'] = $this->User_model->get_all_users();
        $data['stats'] = $this->User_model->get_user_stats();
        $data['title'] = 'Gestión de Usuarios';
        
        $this->load->view('users/index', $data);
    }

    public function create() {
        if ($this->input->method() === 'post') {
            // Validar formulario
            $this->form_validation->set_rules('username', 'Usuario', 'required|min_length[3]|max_length[20]|is_unique[users.username]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('full_name', 'Nombre Completo', 'required|min_length[3]|max_length[100]');
            $this->form_validation->set_rules('phone', 'Número de Contacto', 'max_length[20]');
            $this->form_validation->set_rules('password', 'Contraseña', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirmar Contraseña', 'required|matches[password]');
            $this->form_validation->set_rules('role', 'Rol', 'required|in_list[admin,supervisor,vendedor]');
            
            if ($this->form_validation->run() == FALSE) {
                $data['title'] = 'Crear Usuario';
                $this->load->view('users/create', $data);
            } else {
                $user_data = [
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
                    'full_name' => $this->input->post('full_name'),
                    'phone' => $this->input->post('phone'),
                    'password' => $this->input->post('password'),
                    'role' => $this->input->post('role')
                ];
                
                if ($this->User_model->create_user($user_data)) {
                    $this->session->set_flashdata('success', 'Usuario creado exitosamente');
                    redirect('users');
                } else {
                    $this->session->set_flashdata('error', 'Error al crear el usuario');
                    redirect('users/create');
                }
            }
        } else {
            $data['title'] = 'Crear Usuario';
            $this->load->view('users/create', $data);
        }
    }

    public function edit($id = null) {
        if (!$id) {
            redirect('users');
        }
        
        $user = $this->User_model->get_user_by_id($id);
        if (!$user) {
            $this->session->set_flashdata('error', 'Usuario no encontrado');
            redirect('users');
        }
        
        if ($this->input->method() === 'post') {
            // Validar formulario
            $this->form_validation->set_rules('username', 'Usuario', 'required|min_length[3]|max_length[20]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('full_name', 'Nombre Completo', 'required|min_length[3]|max_length[100]');
            $this->form_validation->set_rules('phone', 'Número de Contacto', 'max_length[20]');
            $this->form_validation->set_rules('password', 'Contraseña', 'min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirmar Contraseña', 'matches[password]');
            $this->form_validation->set_rules('role', 'Rol', 'required|in_list[admin,supervisor,vendedor]');
            
            // Validar username único (excluyendo el usuario actual)
            $username = $this->input->post('username');
            if ($username !== $user->username && $this->User_model->username_exists($username, $id)) {
                $this->form_validation->set_message('username_exists', 'El nombre de usuario ya existe');
                $this->form_validation->set_rules('username', 'Usuario', 'username_exists');
            }
            
            // Validar email único (excluyendo el usuario actual)
            $email = $this->input->post('email');
            if ($email !== $user->email && $this->User_model->email_exists($email, $id)) {
                $this->form_validation->set_message('email_exists', 'El email ya existe');
                $this->form_validation->set_rules('email', 'Email', 'email_exists');
            }
            
            if ($this->form_validation->run() == FALSE) {
                $data['user'] = $user;
                $data['title'] = 'Editar Usuario';
                $this->load->view('users/edit', $data);
            } else {
                $user_data = [
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
                    'full_name' => $this->input->post('full_name'),
                    'phone' => $this->input->post('phone'),
                    'role' => $this->input->post('role'),
                    'status' => $this->input->post('status')
                ];
                
                // Solo actualizar contraseña si se proporciona
                if ($this->input->post('password')) {
                    $user_data['password'] = $this->input->post('password');
                }
                
                if ($this->User_model->update_user($id, $user_data)) {
                    $this->session->set_flashdata('success', 'Usuario actualizado exitosamente');
                    redirect('users');
                } else {
                    $this->session->set_flashdata('error', 'Error al actualizar el usuario');
                    redirect('users/edit/' . $id);
                }
            }
        } else {
            $data['user'] = $user;
            $data['title'] = 'Editar Usuario';
            $this->load->view('users/edit', $data);
        }
    }

    public function delete($id = null) {
        if (!$id) {
            redirect('users');
        }
        
        // No permitir eliminar el propio usuario
        if ($id == $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'No puedes eliminar tu propia cuenta');
            redirect('users');
        }
        
        if ($this->User_model->delete_user($id)) {
            $this->session->set_flashdata('success', 'Usuario eliminado exitosamente');
        } else {
            $this->session->set_flashdata('error', 'Error al eliminar el usuario');
        }
        
        redirect('users');
    }

    public function change_status($id = null, $status = null) {
        if (!$id || !$status) {
            redirect('users');
        }
        
        // No permitir desactivar el propio usuario
        if ($id == $this->session->userdata('user_id') && $status == 'inactive') {
            $this->session->set_flashdata('error', 'No puedes desactivar tu propia cuenta');
            redirect('users');
        }
        
        if ($this->User_model->change_user_status($id, $status)) {
            $status_text = ($status == 'active') ? 'activado' : 'desactivado';
            $this->session->set_flashdata('success', "Usuario $status_text exitosamente");
        } else {
            $this->session->set_flashdata('error', 'Error al cambiar el estado del usuario');
        }
        
        redirect('users');
    }

    public function profile() {
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->get_user_by_id($user_id);
        $data['title'] = 'Mi Perfil';
        
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('full_name', 'Nombre Completo', 'required|min_length[3]|max_length[100]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('current_password', 'Contraseña Actual', 'required');
            $this->form_validation->set_rules('new_password', 'Nueva Contraseña', 'min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirmar Contraseña', 'matches[new_password]');
            
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('users/profile', $data);
            } else {
                // Verificar contraseña actual
                if (sha1($this->input->post('current_password')) !== $data['user']->password) {
                    $this->session->set_flashdata('error', 'La contraseña actual es incorrecta');
                    $this->load->view('users/profile', $data);
                    return;
                }
                
                $update_data = [
                    'full_name' => $this->input->post('full_name'),
                    'email' => $this->input->post('email')
                ];
                
                if ($this->input->post('new_password')) {
                    $update_data['password'] = $this->input->post('new_password');
                }
                
                if ($this->User_model->update_user($user_id, $update_data)) {
                    $this->session->set_flashdata('success', 'Perfil actualizado exitosamente');
                    redirect('users/profile');
                } else {
                    $this->session->set_flashdata('error', 'Error al actualizar el perfil');
                }
            }
        } else {
            $this->load->view('users/profile', $data);
        }
    }
}
