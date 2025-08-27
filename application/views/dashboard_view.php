<?php
// Configuración del layout
$page_title = 'Dashboard';
$page_type = 'dashboard';
$active_menu = 'dashboard';
$page_header = 'Panel de Control';
$page_subtitle = 'Bienvenido al Sistema de Cotizador';
$page_icon = 'fas fa-tachometer-alt';

// Iniciar el buffer de salida
ob_start();
?>

    <!-- Welcome Section -->
    <section class="welcome-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="welcome-title mb-3">
                        <i class="fas fa-tachometer-alt me-3"></i>Dashboard
                    </h1>
                    <p class="lead mb-0">
                        Bienvenido, <strong><?php echo $this->session->userdata('full_name'); ?></strong> 
                        (<?php echo ucfirst($this->session->userdata('role')); ?>) al Sistema de Cotizador
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Cards -->
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="stats-icon">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div class="stats-number">24</div>
                        <div class="stats-label">Cotizaciones</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="stats-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stats-number">156</div>
                        <div class="stats-label">Clientes</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="stats-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stats-number">$89K</div>
                        <div class="stats-label">Ingresos</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="stats-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stats-number">12%</div>
                        <div class="stats-label">Crecimiento</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-clock me-2"></i>Actividad Reciente
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-file-invoice text-success me-2"></i>
                                    Nueva cotización creada para Cliente ABC
                                </div>
                                <small class="text-muted">Hace 2 horas</small>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-user-plus text-primary me-2"></i>
                                    Nuevo cliente registrado: Empresa XYZ
                                </div>
                                <small class="text-muted">Hace 4 horas</small>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Cotización #001 aprobada por el cliente
                                </div>
                                <small class="text-muted">Hace 1 día</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-tasks me-2"></i>Tareas Pendientes
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Revisar cotización #002</span>
                                <span class="badge bg-warning text-dark">Pendiente</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Contactar cliente ABC</span>
                                <span class="badge bg-info">En proceso</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Actualizar precios</span>
                                <span class="badge bg-danger">Urgente</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
// Obtener el contenido del buffer
$content = ob_get_clean();

// Cargar el layout principal
$this->load->view('layouts/main_layout', array(
    'page_title' => $page_title,
    'page_type' => $page_type,
    'active_menu' => $active_menu,
    'page_header' => $page_header,
    'page_subtitle' => $page_subtitle,
    'page_icon' => $page_icon,
    'content' => $content
));
?>
