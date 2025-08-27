<?php
// Configuración del layout
$page_title = isset($title) ? $title : 'Búsqueda de Clientes';
$page_type = 'tables';
$active_menu = 'clientes';
$page_header = isset($title) ? $title : 'Búsqueda de Clientes';
$page_subtitle = 'Resultados de la búsqueda';
$page_icon = 'fas fa-search';

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
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-search me-2"></i><?php echo $page_header; ?>
            </h1>
            <p class="text-muted mb-0"><?php echo $page_subtitle; ?></p>
        </div>
        <div>
            <a href="<?php echo base_url('clients/create'); ?>" class="btn btn-primary me-2">
                <i class="fas fa-plus me-2"></i>Nuevo Cliente
            </a>
            <a href="<?php echo base_url('clients'); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver
            </a>
        </div>
    </div>

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
                        <input type="text" class="form-control" name="q" placeholder="Buscar por nombre, empresa, email, contacto o observaciones..." value="<?php echo $search_term; ?>">
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

    <!-- Resultados de búsqueda -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-list me-2"></i>Resultados de Búsqueda
                <?php if($search_term): ?>
                    <span class="badge bg-primary ms-2"><?php echo count($clients); ?> resultado(s)</span>
                <?php endif; ?>
            </h5>
        </div>
        <div class="card-body">
            <?php if(empty($clients)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No se encontraron resultados</h5>
                    <p class="text-muted">
                        <?php if($search_term): ?>
                            No se encontraron clientes que coincidan con "<strong><?php echo $search_term; ?></strong>"
                        <?php else: ?>
                            No hay clientes en la base de datos
                        <?php endif; ?>
                    </p>
                    <?php if($search_term): ?>
                        <a href="<?php echo base_url('clients'); ?>" class="btn btn-primary">
                            <i class="fas fa-undo me-2"></i>Ver todos los clientes
                        </a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="searchResultsTable">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Empresa</th>
                                <th>Contacto</th>
                                <th>Email</th>
                                <th>Origen</th>
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
                                    <?php if($client->observaciones): ?>
                                        <br><small class="text-muted"><?php echo substr($client->observaciones, 0, 50); ?>...</small>
                                    <?php endif; ?>
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
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
// Obtener el contenido del buffer
$content = ob_get_clean();

// Scripts específicos de la página
$page_scripts = "
    $(document).ready(function() {
        if (document.getElementById('searchResultsTable')) {
            $('#searchResultsTable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                pageLength: 25,
                order: [[0, 'desc']],
                responsive: true,
                columnDefs: [
                    { targets: [0], width: '60px' },
                    { targets: [7], width: '200px', orderable: false }
                ]
            });
        }
    });
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
