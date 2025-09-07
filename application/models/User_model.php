<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Obtener todos los usuarios
    public function get_all_users() {
        $this->db->select('id, username, email, full_name, phone, role, status, created_at');
        $this->db->from('users');
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    // Obtener usuario por ID
    public function get_user_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        return $query->row();
    }

    // Obtener usuario por username
    public function get_user_by_username($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        return $query->row();
    }

    // Crear nuevo usuario
    public function create_user($data) {
        $data['password'] = sha1($data['password']);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['status'] = 'active';
        
        return $this->db->insert('users', $data);
    }

    // Actualizar usuario
    public function update_user($id, $data) {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = sha1($data['password']);
        } else {
            unset($data['password']);
        }
        
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    // Eliminar usuario
    public function delete_user($id) {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }

    // Cambiar estado del usuario
    public function change_user_status($id, $status) {
        $this->db->where('id', $id);
        return $this->db->update('users', ['status' => $status, 'updated_at' => date('Y-m-d H:i:s')]);
    }

    // Verificar credenciales de login
    public function verify_login($username, $password) {
        $this->db->where('username', $username);
        $this->db->where('status', 'active');
        $query = $this->db->get('users');
        
        if ($query->num_rows() == 1) {
            $user = $query->row();
            // Verificar usando sha1
            if ($user->password === sha1($password)) {
                return $user;
            }
        }
        return false;
    }

    // Obtener usuarios por rol
    public function get_users_by_role($role) {
        $this->db->where('role', $role);
        $this->db->where('status', 'active');
        $query = $this->db->get('users');
        return $query->result();
    }

    // Contar usuarios por rol
    public function count_users_by_role($role) {
        $this->db->where('role', $role);
        $this->db->where('status', 'active');
        return $this->db->count_all_results('users');
    }

    // Verificar si el username existe
    public function username_exists($username, $exclude_id = null) {
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        $this->db->where('username', $username);
        return $this->db->count_all_results('users') > 0;
    }

    // Verificar si el email existe
    public function email_exists($email, $exclude_id = null) {
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        $this->db->where('email', $email);
        return $this->db->count_all_results('users') > 0;
    }

    // Obtener estadísticas de usuarios
    public function get_user_stats() {
        $stats = [
            'total' => $this->db->count_all('users'),
            'active' => $this->db->where('status', 'active')->count_all_results('users'),
            'inactive' => $this->db->where('status', 'inactive')->count_all_results('users'),
            'admin' => $this->count_users_by_role('admin'),
            'supervisor' => $this->count_users_by_role('supervisor'),
            'vendedor' => $this->count_users_by_role('vendedor')
        ];
        
        return $stats;
    }
}
