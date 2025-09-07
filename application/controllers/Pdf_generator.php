<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_generator extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->load->library(['form_validation', 'session']);
        $this->load->model(['Quotation_model', 'Client_model', 'User_model']);
        
        // Verificar si está logueado
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    /**
     * Generar PDF de cotización
     */
    public function quotation($quotation_id) {
        // Obtener datos de la cotización
        $quotation = $this->Quotation_model->get_quotation_by_id($quotation_id);
        
        if (!$quotation) {
            show_404();
        }
        
        // Obtener items de la cotización
        $items = $this->Quotation_model->get_quotation_items($quotation_id);
        
        // Obtener datos del cliente
        $client = $this->Client_model->get_client_by_id($quotation->client_id);
        
        // Validar que el cliente existe
        if (!$client) {
            show_404();
        }
        
        // Asegurar que created_by_name esté definido
        if (!isset($quotation->created_by_name) || empty($quotation->created_by_name)) {
            $quotation->created_by_name = 'Usuario no disponible';
        }
        
        // Obtener datos del asesor (usuario que creó la cotización)
        $advisor = $this->User_model->get_user_by_id($quotation->created_by);
        if (!$advisor) {
            $advisor = (object) [
                'full_name' => 'Asesor no disponible',
                'phone' => '',
                'email' => ''
            ];
        }
        
        // Preparar datos para la vista
        $data = [
            'quotation' => $quotation,
            'client' => $client,
            'items' => $items,
            'advisor' => $advisor,
            'page_title' => 'Cotización PDF - ' . $quotation->quotation_number
        ];
        
        // Cargar la vista del PDF
        $this->load->view('pdf/quotation_template', $data);
    }

    /**
     * Generar PDF de cotización con datos de ejemplo (para testing)
     */
    public function test() {
        // Datos de ejemplo
        $data = [
            'quotation' => (object) [
                'id' => 1,
                'quotation_number' => 'G-080825-001',
                'quotation_date' => '2025-08-26',
                'validity_days' => 10,
                'currency' => 'DOLARES',
                'payment_terms' => 'CREDITO',
                'delivery_location' => 'SUS INSTALACIONES',
                'tax_rate' => 16,
                'subtotal' => 7960.00,
                'tax_amount' => 1273.60,
                'total' => 9233.60,
                'notes' => 'Comentarios de la cotización de ejemplo',
                'status' => 'draft',
                'created_at' => '2025-08-26 10:30:00',
                'created_by_name' => 'GISELLE@REPASE.MX'
            ],
            'client' => (object) [
                'id' => 1,
                'nombre' => 'Juan Pérez',
                'empresa' => 'Empresa Ejemplo S.A.',
                'contacto' => 'Juan Pérez',
                'email' => 'juan.perez@empresa.com',
                'telefono' => '(777) 123-4567'
            ],
            'advisor' => (object) [
                'full_name' => 'Giselle Repase',
                'phone' => '+52 777 123-4567',
                'email' => 'giselle@repase.mx'
            ],
            'items' => [
                (object) [
                    'item_number' => 1,
                    'description' => 'Lorem ipsum dolor sit amet consectetur',
                    'part_number' => '1234567890',
                    'quantity' => 2,
                    'unit_price' => 500.00,
                    'subtotal' => 1000.00,
                    'delivery_time' => '2 meses'
                ],
                (object) [
                    'item_number' => 2,
                    'description' => 'Producto/Servicio 2',
                    'part_number' => '1234567890',
                    'quantity' => 1,
                    'unit_price' => 750.00,
                    'subtotal' => 750.00,
                    'delivery_time' => '2 meses'
                ],
                (object) [
                    'item_number' => 3,
                    'description' => 'Producto/Servicio 3',
                    'part_number' => 'NP-0003',
                    'quantity' => 3,
                    'unit_price' => 200.00,
                    'subtotal' => 600.00,
                    'delivery_time' => '1 mes'
                ],
                (object) [
                    'item_number' => 4,
                    'description' => 'Producto/Servicio 4',
                    'part_number' => 'NP-0004',
                    'quantity' => 5,
                    'unit_price' => 100.00,
                    'subtotal' => 500.00,
                    'delivery_time' => '3 semanas'
                ],
                (object) [
                    'item_number' => 5,
                    'description' => 'Producto/Servicio 5',
                    'part_number' => 'NP-0005',
                    'quantity' => 4,
                    'unit_price' => 250.00,
                    'subtotal' => 1000.00,
                    'delivery_time' => '1 mes'
                ]
            ],
            'page_title' => 'Cotización PDF - G-080825-001'
        ];
        
        // Cargar la vista del PDF
        $this->load->view('pdf/quotation_template', $data);
    }
}
