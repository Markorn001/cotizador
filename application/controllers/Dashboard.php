<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(['url']);
        $this->load->library(['session']);
        $this->load->model(['Quotation_model', 'Client_model', 'User_model']);
        
        // Verificar si está logueado
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index() {
        // Obtener información del usuario actual
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');
        
        // Obtener estadísticas de cotizaciones (filtradas por rol)
        $data['quotation_stats'] = $this->get_quotation_stats($user_id, $user_role);
        $data['quotation_chart_data'] = $this->get_quotation_chart_data($user_id, $user_role);
        $data['username'] = $this->session->userdata('username');
        $data['user_role'] = $user_role;
        
        $this->load->view('dashboard_view', $data);
    }
    
    /**
     * Obtener estadísticas de cotizaciones por estado
     */
    private function get_quotation_stats($user_id = null, $user_role = null) {
        $stats = [];
        $statuses = ['draft', 'sent', 'approved', 'rejected', 'expired'];
        
        foreach ($statuses as $status) {
            $count = $this->Quotation_model->count_quotations_by_status($status, $user_id, $user_role);
            $stats[$status] = $count;
        }
        
        // Total de cotizaciones
        $stats['total'] = array_sum($stats);
        
        return $stats;
    }
    
    /**
     * Obtener datos para gráfica de cotizaciones por mes
     */
    private function get_quotation_chart_data($user_id = null, $user_role = null) {
        $chart_data = [];
        
        // Obtener datos de los últimos 12 meses
        for ($i = 11; $i >= 0; $i--) {
            $date = date('Y-m', strtotime("-$i months"));
            $year = date('Y', strtotime("-$i months"));
            $month = date('m', strtotime("-$i months"));
            
            // Contar cotizaciones aprobadas del mes (filtradas por rol)
            $approved_count = $this->Quotation_model->count_approved_quotations_by_month($year, $month, $user_id, $user_role);
            
            // Sumar montos de cotizaciones aprobadas del mes (filtradas por rol)
            $approved_amount = $this->Quotation_model->sum_approved_quotations_by_month($year, $month, $user_id, $user_role);
            
            $chart_data[] = [
                'month' => date('M Y', strtotime("-$i months")),
                'count' => $approved_count,
                'amount' => $approved_amount
            ];
        }
        
        return $chart_data;
    }
}
