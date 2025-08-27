<?php
// Configuración del layout
$page_title = isset($title) ? $title : 'Gestión de cliente';
$page_type = 'tables';
$active_menu = 'usuarios';
$page_header = isset($title) ? $title : 'Gestión de cliente';
$page_subtitle = 'Administra los usuarios del sistemas';
$page_icon = 'fas fa-user-cog';

// CSS adicional específico para esta página
$additional_css = ['utilities.css'];

// JavaScript adicional
$additional_js = ['dataTables.bootstrap5.min.js'];

// Iniciar el buffer de salida
ob_start();
?>

    <div class="container mt-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-users me-2"></i><?php echo $title; ?>
            </h1>
            <a href="<?php echo base_url('users/create'); ?>" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nuevo Usuario
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-2">
                <div class="card stats-card bg-primary text-white">
                    <div class="stats-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-number"><?php echo $stats['total']; ?></div>
                    <div class="stats-label">Total</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card stats-card bg-success text-white">
                    <div class="stats-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stats-number"><?php echo $stats['active']; ?></div>
                    <div class="stats-label">Activos</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card stats-card bg-warning text-dark">
                    <div class="stats-icon">
                        <i class="fas fa-pause-circle"></i>
                    </div>
                    <div class="stats-number"><?php echo $stats['inactive']; ?></div>
                    <div class="stats-label">Inactivos</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card stats-card bg-danger text-white">
                    <div class="stats-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="stats-number"><?php echo $stats['admin']; ?></div>
                    <div class="stats-label">Admin</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card stats-card bg-info text-white">
                    <div class="stats-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="stats-number"><?php echo $stats['supervisor']; ?></div>
                    <div class="stats-label">Supervisor</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card stats-card bg-secondary text-white">
                    <div class="stats-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="stats-number"><?php echo $stats['vendedor']; ?></div>
                    <div class="stats-label">Vendedor</div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-list me-2"></i>Lista de Usuarios
            </div>
            <div class="card-body">
                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?php echo $this->session->flashdata('success'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <?php echo $this->session->flashdata('error'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table id="usersTable" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Fecha Creación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($users as $user): ?>
                            <tr>
                                <td><?php echo $user->id; ?></td>
                                <td>
                                    <strong><?php echo $user->username; ?></strong>
                                </td>
                                <td><?php echo $user->full_name; ?></td>
                                <td><?php echo $user->email; ?></td>
                                <td>
                                    <?php
                                    $role_class = '';
                                    switch($user->role) {
                                        case 'admin':
                                            $role_class = 'badge-admin';
                                            break;
                                        case 'supervisor':
                                            $role_class = 'badge-supervisor';
                                            break;
                                        case 'vendedor':
                                            $role_class = 'badge-vendedor';
                                            break;
                                    }
                                    ?>
                                    <span class="badge badge-role <?php echo $role_class; ?>">
                                        <?php echo ucfirst($user->role); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if($user->status == 'active'): ?>
                                        <span class="badge bg-success badge-status">Activo</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary badge-status">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($user->created_at)); ?></td>
                                <td>
                                    <a href="<?php echo base_url('users/edit/' . $user->id); ?>" 
                                       class="btn btn-sm btn-outline-primary btn-action" 
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <?php if($user->status == 'active'): ?>
                                        <a href="<?php echo base_url('users/change_status/' . $user->id . '/inactive'); ?>" 
                                           class="btn btn-sm btn-outline-warning btn-action" 
                                           title="Desactivar"
                                           onclick="return confirm('¿Estás seguro de desactivar este usuario?')">
                                            <i class="fas fa-pause"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?php echo base_url('users/change_status/' . $user->id . '/active'); ?>" 
                                           class="btn btn-sm btn-outline-success btn-action" 
                                           title="Activar">
                                            <i class="fas fa-play"></i>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <a href="<?php echo base_url('users/delete/' . $user->id); ?>" 
                                       class="btn btn-sm btn-outline-danger btn-action" 
                                       title="Eliminar"
                                       onclick="return confirm('¿Estás seguro de eliminar este usuario? Esta acción no se puede deshacer.')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php
// Obtener el contenido del buffer
$content = ob_get_clean();

// Scripts específicos de la página
$page_scripts = "
    $(document).ready(function() {
        $('#usersTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            pageLength: 25,
            order: [[0, 'desc']],
            responsive: true
        });
    });
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
";

// Cargar el layout principal
$this->load->view('layouts/main_layout', array(
    'page_title' => $page_title,
    'page_type' => $page_type,
    'active_menu' => $active_menu,
    'page_header' => $page_header,
    'page_subtitle' => $page_subtitle,
    'page_icon' => $page_icon,
    'additional_css' => $additional_css,
    'additional_js' => $additional_js,
    'page_scripts' => $page_scripts,
    'content' => $content
));
?>
