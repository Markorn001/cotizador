<?php
// Configuración del layout
$page_title = isset($title) ? $title : 'Gestión de Cotizaciones';
$page_type = 'tables';
$active_menu = 'cotizaciones';
$page_header = isset($title) ? $title : 'Gestión de Cotizaciones';
$page_subtitle = 'Lista de todas las cotizaciones';
$page_icon = 'fas fa-file-invoice';

// CSS adicional específico para esta página
$additional_css = ['utilities.css'];

// CSS personalizado para el select de estado
$custom_css = "
<style>
.status-select {
    font-size: 0.875rem;
    padding: 0.25rem 0.5rem;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    background-color: #fff;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.status-select:focus {
    border-color: #86b7fe;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.status-select option {
    padding: 0.5rem;
}

/* Asegurar que el select se vea bien en la tabla */
.table td .status-select {
    margin: 0;
    vertical-align: middle;
    display: inline-block;
}

/* Estilo específico para la columna de estado */
.table td:nth-child(6) {
    text-align: center;
    vertical-align: middle;
}

/* Hacer que el select se centre en la celda */
.table td .status-select {
    margin: 0 auto;
}
</style>
";

// Iniciar el buffer de salida
ob_start();
?>

<div class="row">
    <div class="col-12">
        <!-- Mensajes de éxito/error -->
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

        <!-- Botón Crear Nueva Cotización -->
        <div class="text-end mb-3">
            <a href="<?php echo base_url('cotizaciones/create'); ?>" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Crear Nueva Cotización
            </a>
        </div>

        <!-- Formulario de Búsqueda -->
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-search me-2"></i>Filtros de Búsqueda
                </h6>
            </div>
            <div class="card-body">
                <form method="GET" action="<?php echo base_url('cotizaciones'); ?>" class="row g-3">
                    <div class="col-md-3">
                        <label for="search" class="form-label">Buscar</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               placeholder="Número, cliente, empresa..." 
                               value="<?php echo isset($search_params['search']) ? htmlspecialchars($search_params['search']) : ''; ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="status" class="form-label">Estado</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Todos</option>
                            <option value="draft" <?php echo (isset($search_params['status']) && $search_params['status'] == 'draft') ? 'selected' : ''; ?>>Borrador</option>
                            <option value="sent" <?php echo (isset($search_params['status']) && $search_params['status'] == 'sent') ? 'selected' : ''; ?>>Enviada</option>
                            <option value="approved" <?php echo (isset($search_params['status']) && $search_params['status'] == 'approved') ? 'selected' : ''; ?>>Aprobada</option>
                            <option value="rejected" <?php echo (isset($search_params['status']) && $search_params['status'] == 'rejected') ? 'selected' : ''; ?>>Rechazada</option>
                            <option value="expired" <?php echo (isset($search_params['status']) && $search_params['status'] == 'expired') ? 'selected' : ''; ?>>Expirada</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="date_from" class="form-label">Desde</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" 
                               value="<?php echo isset($search_params['date_from']) ? $search_params['date_from'] : ''; ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="date_to" class="form-label">Hasta</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" 
                               value="<?php echo isset($search_params['date_to']) ? $search_params['date_to'] : ''; ?>">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search me-1"></i>Buscar
                        </button>
                        <a href="<?php echo base_url('cotizaciones'); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Limpiar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Información de resultados -->
        <?php if(isset($search_params['search']) || isset($search_params['status']) || isset($search_params['date_from']) || isset($search_params['date_to'])): ?>
            <div class="alert alert-info mb-3">
                <i class="fas fa-info-circle me-2"></i>
                Mostrando <?php echo count($quotations); ?> de <?php echo $total_quotations; ?> cotizaciones
                <?php if(isset($search_params['search']) && !empty($search_params['search'])): ?>
                    para "<strong><?php echo htmlspecialchars($search_params['search']); ?></strong>"
                <?php endif; ?>
                <?php if(isset($search_params['status']) && !empty($search_params['status'])): ?>
                    con estado "<strong><?php echo $search_params['status']; ?></strong>"
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <!-- Información de permisos por rol -->
        <?php 
        $user_role = $this->session->userdata('role');
        if($user_role === 'vendedor'): ?>
            <div class="alert alert-warning mb-3">
                <i class="fas fa-user me-2"></i>
                <strong>Vista de Vendedor:</strong> Solo puedes ver las cotizaciones que has creado.
            </div>
        <?php elseif($user_role === 'supervisor'): ?>
            <div class="alert alert-success mb-3">
                <i class="fas fa-eye me-2"></i>
                <strong>Vista de Supervisor:</strong> Puedes ver todas las cotizaciones del sistema.
            </div>
        <?php endif; ?>

        <!-- Tabla de cotizaciones -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>
                    <?php 
                    $user_role = $this->session->userdata('role');
                    if($user_role === 'vendedor'): 
                        echo 'Mis Cotizaciones';
                    else: 
                        echo 'Lista de Cotizaciones';
                    endif; 
                    ?>
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="cotizacionesTable">
                        <thead class="table-dark">
                            <tr>
                                <th>Número</th>
                                <th>Cliente</th>
                                <th>Empresa</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Creado por</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($quotations && count($quotations) > 0): ?>
                                <?php foreach($quotations as $quotation): ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo $quotation->quotation_number; ?></strong>
                                        </td>
                                        <td>
                                            <strong><?php echo $quotation->client_name; ?></strong>
                                            <?php if($quotation->client_contact): ?>
                                                <br><small class="text-muted">
                                                    <i class="fas fa-phone me-1"></i><?php echo $quotation->client_contact; ?>
                                                </small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($quotation->client_company): ?>
                                                <span class="text-decoration-none"><?php echo $quotation->client_company; ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo date('d/m/Y', strtotime($quotation->quotation_date)); ?>
                                            <br><small class="text-muted">
                                                <?php echo $quotation->validity_days; ?> días
                                            </small>
                                        </td>
                                        <td>
                                            <strong>$<?php echo number_format($quotation->total, 2); ?></strong>
                                            <br><small class="text-muted"><?php echo $quotation->currency; ?></small>
                                        </td>
                                        <td>
                                            <select class="form-select form-select-sm status-select" 
                                                    data-quotation-id="<?php echo $quotation->id; ?>" 
                                                    title="Cambiar Estado"
                                                    style="width: auto; min-width: 120px;">
                                                <option value="draft" <?php echo $quotation->status == 'draft' ? 'selected' : ''; ?>>
                                                    📝 Borrador
                                                </option>
                                                <option value="sent" <?php echo $quotation->status == 'sent' ? 'selected' : ''; ?>>
                                                    📤 Enviada
                                                </option>
                                                <option value="approved" <?php echo $quotation->status == 'approved' ? 'selected' : ''; ?>>
                                                    ✅ Aprobada
                                                </option>
                                                <option value="rejected" <?php echo $quotation->status == 'rejected' ? 'selected' : ''; ?>>
                                                    ❌ Rechazada
                                                </option>
                                                <option value="expired" <?php echo $quotation->status == 'expired' ? 'selected' : ''; ?>>
                                                    ⏰ Expirada
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <small class="text-muted"><?php echo $quotation->created_by_name; ?></small>
                                            <br><small class="text-muted">
                                                <?php echo date('d/m/Y H:i', strtotime($quotation->created_at)); ?>
                                            </small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo base_url('cotizaciones/edit/' . $quotation->id); ?>" 
                                                   class="btn btn-sm btn-outline-primary" title="Editar Cotización">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?php echo base_url('pdf_generator/quotation/' . $quotation->id); ?>" 
                                                   class="btn btn-sm btn-outline-success" title="Generar PDF" target="_blank">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                                <a href="<?php echo base_url('cotizaciones/delete/' . $quotation->id); ?>" 
                                                   class="btn btn-sm btn-outline-danger" title="Eliminar"
                                                   onclick="return confirm('¿Estás seguro de eliminar esta cotización? Esta acción no se puede deshacer.')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        <i class="fas fa-info-circle me-2"></i>No hay cotizaciones registradas
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                <?php if($total_pages > 1): ?>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Mostrando <?php echo (($current_page - 1) * $per_page) + 1; ?> a 
                            <?php echo min($current_page * $per_page, $total_quotations); ?> de 
                            <?php echo $total_quotations; ?> resultados
                        </div>
                        
                        <nav aria-label="Paginación de cotizaciones">
                            <ul class="pagination pagination-sm mb-0">
                                <!-- Botón Anterior -->
                                <?php if($current_page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo base_url('cotizaciones?' . http_build_query(array_merge($search_params, ['page' => $current_page - 1]))); ?>">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                                    </li>
                                <?php endif; ?>
                                
                                <!-- Números de página -->
                                <?php
                                $start_page = max(1, $current_page - 2);
                                $end_page = min($total_pages, $current_page + 2);
                                
                                // Mostrar primera página si no está en el rango
                                if($start_page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo base_url('cotizaciones?' . http_build_query(array_merge($search_params, ['page' => 1]))); ?>">1</a>
                                    </li>
                                    <?php if($start_page > 2): ?>
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                                
                                <?php for($i = $start_page; $i <= $end_page; $i++): ?>
                                    <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                                        <a class="page-link" href="<?php echo base_url('cotizaciones?' . http_build_query(array_merge($search_params, ['page' => $i]))); ?>">
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                                
                                <!-- Mostrar última página si no está en el rango -->
                                <?php if($end_page < $total_pages): ?>
                                    <?php if($end_page < $total_pages - 1): ?>
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    <?php endif; ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo base_url('cotizaciones?' . http_build_query(array_merge($search_params, ['page' => $total_pages]))); ?>">
                                            <?php echo $total_pages; ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                
                                <!-- Botón Siguiente -->
                                <?php if($current_page < $total_pages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo base_url('cotizaciones?' . http_build_query(array_merge($search_params, ['page' => $current_page + 1]))); ?>">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                <?php endif; ?>
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
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // Manejo del cambio de estado con select
        $('.status-select').on('change', function() {
            const quotationId = $(this).data('quotation-id');
            const newStatus = $(this).val();
            const currentStatus = $(this).closest('tr').find('.badge').text().trim();
            const select = $(this);
            
            // Obtener el texto del estado seleccionado
            const statusTexts = {
                'draft': 'Borrador',
                'sent': 'Enviada', 
                'approved': 'Aprobada',
                'rejected': 'Rechazada',
                'expired': 'Expirada'
            };
            
            const newStatusText = statusTexts[newStatus] || newStatus;
            
            if (currentStatus === newStatusText) {
                return; // No hacer nada si es el mismo estado
            }
            
            if (confirm('¿Estás seguro de cambiar el estado de esta cotización a \"' + newStatusText + '\"?')) {
                // Hacer la petición AJAX
                $.ajax({
                    url: '" . base_url("cotizaciones/change_status/") . "' + quotationId + '/' + newStatus,
                    type: 'GET',
                    success: function(response) {
                        // Recargar la página para mostrar el cambio
                        location.reload();
                    },
                    error: function() {
                        alert('Error al cambiar el estado. Por favor intenta de nuevo.');
                        // Restaurar el valor anterior
                        select.val(select.data('original-value'));
                    }
                });
            } else {
                // Restaurar el valor anterior si cancela
                select.val(select.data('original-value'));
            }
        });
        
        // Guardar el valor original al cargar
        $('.status-select').each(function() {
            $(this).data('original-value', $(this).val());
        });
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
    'page_scripts' => $page_scripts,
    'content' => $content . $custom_css
));
?>
