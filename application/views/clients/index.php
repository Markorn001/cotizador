<?php
// Configuración del layout
$page_title = isset($title) ? $title : 'Gestión de Clientes';
$page_type = 'tables';
$active_menu = 'clientes';
$page_header = isset($title) ? $title : 'Gestión de Clientes';
$page_subtitle = 'Administra la base de datos de clientes';
$page_icon = 'fas fa-users';

// CSS adicional específico para esta página
$additional_css = ['utilities.css'];

// JavaScript adicional
$additional_js = ['dataTables.bootstrap5.min.js', 'dataTables.responsive.min.js'];

// Iniciar el buffer de salida
ob_start();
?>

<div class="container mt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-users me-2"></i><?php echo $page_header; ?>
            </h1>
            <p class="text-muted mb-0"><?php echo $page_subtitle; ?></p>
        </div>
        <div>
            <a href="<?php echo base_url('clients/create'); ?>" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nuevo Cliente
            </a>
        </div>
    </div>

    <!-- Alertas -->
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

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="stats-card">
                <div class="stats-icon bg-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number"><?php echo $stats['total']; ?></h3>
                    <p class="stats-label">Total Clientes</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stats-card">
                <div class="stats-icon bg-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number"><?php echo $stats['active']; ?></h3>
                    <p class="stats-label">Activos</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stats-card">
                <div class="stats-icon bg-warning">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number"><?php echo $stats['with_company']; ?></h3>
                    <p class="stats-label">Con Empresa</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stats-card">
                <div class="stats-icon bg-info">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number"><?php echo $stats['with_email']; ?></h3>
                    <p class="stats-label">Con Email</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stats-card">
                <div class="stats-icon bg-success">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number"><?php echo $stats['whatsapp']; ?></h3>
                    <p class="stats-label">WhatsApp</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stats-card">
                <div class="stats-icon bg-secondary">
                    <i class="fas fa-pause-circle"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number"><?php echo $stats['inactive']; ?></h3>
                    <p class="stats-label">Inactivos</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Barra de búsqueda -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="<?php echo base_url('clients/search'); ?>" method="GET" class="row g-3">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control" name="q" placeholder="Buscar por nombre, empresa, email, contacto o observaciones..." value="">
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search me-2"></i>Buscar
                    </button>
                    <a href="<?php echo base_url('clients'); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-undo me-2"></i>Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de clientes -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-list me-2"></i>Lista de Clientes
            </h5>
        </div>
        <div class="card-body">
                <div class="table-responsive">
        <table class="table table-striped table-hover" id="clientsTable">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Empresa</th>
                            <th>Contacto</th>
                            <th>Email</th>
                            <th>Origen</th>
                            <th>Observaciones</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($clients as $client): ?>
                        <tr>
                            <td><?php echo $client->id; ?></td>
                            <td>
                                <strong><?php echo $client->nombre; ?></strong>
                            </td>
                            <td>
                                <?php if($client->empresa): ?>
                                    <a href="#" class="text-decoration-none" title="Ver empresa">
                                        <?php echo $client->empresa; ?>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($client->contacto): ?>
                                    <a href="tel:<?php echo $client->contacto; ?>" class="text-decoration-none">
                                        <i class="fas fa-phone me-1"></i><?php echo $client->contacto; ?>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($client->email): ?>
                                    <a href="mailto:<?php echo $client->email; ?>" class="text-decoration-none">
                                        <i class="fas fa-envelope me-1"></i><?php echo $client->email; ?>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($client->origen): ?>
                                    <?php if(strtolower($client->origen) == 'whatsapp'): ?>
                                        <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $client->contacto); ?>" 
                                           target="_blank" class="text-decoration-none text-success">
                                            <i class="fab fa-whatsapp me-1"></i><?php echo $client->origen; ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><?php echo $client->origen; ?></span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($client->observaciones): ?>
                                    <div class="text-truncate" style="max-width: 200px;" title="<?php echo htmlspecialchars($client->observaciones); ?>">
                                        <?php echo htmlspecialchars($client->observaciones); ?>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($client->status == 'active'): ?>
                                    <span class="badge bg-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?php echo base_url('clients/view/' . $client->id); ?>" 
                                       class="btn btn-sm btn-outline-info" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo base_url('clients/edit/' . $client->id); ?>" 
                                       class="btn btn-sm btn-outline-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if($client->status == 'active'): ?>
                                        <a href="<?php echo base_url('clients/change_status/' . $client->id . '/inactive'); ?>" 
                                           class="btn btn-sm btn-outline-secondary" title="Desactivar"
                                           onclick="return confirm('¿Estás seguro de desactivar este cliente?')">
                                            <i class="fas fa-pause"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?php echo base_url('clients/change_status/' . $client->id . '/active'); ?>" 
                                           class="btn btn-sm btn-outline-success" title="Activar">
                                            <i class="fas fa-play"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?php echo base_url('clients/delete/' . $client->id); ?>" 
                                       class="btn btn-sm btn-outline-danger" title="Eliminar"
                                       onclick="return confirm('¿Estás seguro de eliminar este cliente? Esta acción no se puede deshacer.')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
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
        $('#clientsTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            pageLength: 25,
            order: [[0, 'desc']],
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function(row) {
                            var data = row.data();
                            return 'Detalles de: ' + data[1];
                        }
                    }),
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll()
                }
            },
            columnDefs: [
                { targets: [0], width: '60px' },
                { targets: [1], width: '150px' },
                { targets: [2], width: '150px' },
                { targets: [3], width: '120px' },
                { targets: [4], width: '180px' },
                { targets: [5], width: '100px' },
                { targets: [6], width: '200px' },
                { targets: [7], width: '80px' },
                { targets: [8], width: '200px', orderable: false }
            ]
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
