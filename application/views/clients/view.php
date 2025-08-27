<?php
// Configuración del layout
$page_title = isset($title) ? $title : 'Ver Cliente';
$page_type = 'dashboard';
$active_menu = 'clientes';
$page_header = isset($title) ? $title : 'Ver Cliente';
$page_subtitle = 'Información detallada del cliente';
$page_icon = 'fas fa-user';

// CSS adicional específico para esta página
$additional_css = ['utilities.css'];

// Iniciar el buffer de salida
ob_start();
?>

<div class="container mt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-user me-2"></i><?php echo $page_header; ?>
            </h1>
            <p class="text-muted mb-0"><?php echo $page_subtitle; ?></p>
        </div>
        <div>
            <a href="<?php echo base_url('clients/edit/' . $client->id); ?>" class="btn btn-warning me-2">
                <i class="fas fa-edit me-2"></i>Editar
            </a>
            <a href="<?php echo base_url('clients'); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver
            </a>
        </div>
    </div>

    <!-- Información del cliente -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Información del Cliente
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-user me-2"></i>Nombre Completo
                                </label>
                                <p class="form-control-plaintext"><?php echo $client->nombre; ?></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-building me-2"></i>Empresa
                                </label>
                                <p class="form-control-plaintext">
                                    <?php if($client->empresa): ?>
                                        <a href="#" class="text-decoration-none"><?php echo $client->empresa; ?></a>
                                    <?php else: ?>
                                        <span class="text-muted">No especificada</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-phone me-2"></i>Contacto
                                </label>
                                <p class="form-control-plaintext">
                                    <?php if($client->contacto): ?>
                                        <a href="tel:<?php echo $client->contacto; ?>" class="text-decoration-none">
                                            <i class="fas fa-phone me-1"></i><?php echo $client->contacto; ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">No especificado</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-envelope me-2"></i>Email
                                </label>
                                <p class="form-control-plaintext">
                                    <?php if($client->email): ?>
                                        <a href="mailto:<?php echo $client->email; ?>" class="text-decoration-none">
                                            <i class="fas fa-envelope me-1"></i><?php echo $client->email; ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">No especificado</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-tag me-2"></i>Origen
                                </label>
                                <p class="form-control-plaintext">
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
                                        <span class="text-muted">No especificado</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-toggle-on me-2"></i>Estado
                                </label>
                                <p class="form-control-plaintext">
                                    <?php if($client->status == 'active'): ?>
                                        <span class="badge bg-success">Activo</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactivo</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <?php if($client->observaciones): ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-sticky-note me-2"></i>Observaciones
                        </label>
                        <p class="form-control-plaintext"><?php echo nl2br($client->observaciones); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Información del sistema -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-cog me-2"></i>Información del Sistema
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-calendar-plus me-2"></i>Fecha de Creación
                        </label>
                        <p class="form-control-plaintext">
                            <?php echo date('d/m/Y H:i', strtotime($client->created_at)); ?>
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-edit me-2"></i>Última Actualización
                        </label>
                        <p class="form-control-plaintext">
                            <?php if($client->updated_at): ?>
                                <?php echo date('d/m/Y H:i', strtotime($client->updated_at)); ?>
                            <?php else: ?>
                                <span class="text-muted">Nunca</span>
                            <?php endif; ?>
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-hashtag me-2"></i>ID del Cliente
                        </label>
                        <p class="form-control-plaintext">#<?php echo $client->id; ?></p>
                    </div>
                </div>
            </div>

            <!-- Acciones rápidas -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>Acciones Rápidas
                    </h6>
                </div>
                <div class="card-body">
                    <?php if($client->contacto): ?>
                    <div class="d-grid gap-2 mb-2">
                        <a href="tel:<?php echo $client->contacto; ?>" class="btn btn-outline-primary">
                            <i class="fas fa-phone me-2"></i>Llamar
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($client->email): ?>
                    <div class="d-grid gap-2 mb-2">
                        <a href="mailto:<?php echo $client->email; ?>" class="btn btn-outline-info">
                            <i class="fas fa-envelope me-2"></i>Enviar Email
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($client->contacto && strtolower($client->origen) == 'whatsapp'): ?>
                    <div class="d-grid gap-2 mb-2">
                        <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $client->contacto); ?>" 
                           target="_blank" class="btn btn-outline-success">
                            <i class="fab fa-whatsapp me-2"></i>WhatsApp
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <div class="d-grid gap-2">
                        <a href="<?php echo base_url('clients/edit/' . $client->id); ?>" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Editar Cliente
                        </a>
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
    'additional_css' => $additional_css,
    'content' => $content
));
?>
