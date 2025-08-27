<?php
// Configuración del layout
$page_title = isset($title) ? $title : 'Crear Cliente';
$page_type = 'forms';
$active_menu = 'clientes';
$page_header = isset($title) ? $title : 'Crear Cliente';
$page_subtitle = 'Agregar un nuevo cliente a la base de datos';
$page_icon = 'fas fa-user-plus';

// CSS adicional específico para esta página
$additional_css = ['utilities.css'];

// Iniciar el buffer de salida
ob_start();
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-plus me-2"></i>Crear Nuevo Cliente
                </h5>
            </div>
            <div class="card-body">
                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <?php echo $this->session->flashdata('error'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php echo form_open('clients/create', ['id' => 'createClientForm']); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" 
                                       class="form-control <?php echo (form_error('nombre')) ? 'is-invalid' : ''; ?>" 
                                       id="nombre" 
                                       name="nombre" 
                                       value="<?php echo set_value('nombre'); ?>" 
                                       placeholder="Nombre Completo" 
                                       required>
                                <label for="nombre">
                                    <i class="fas fa-user me-2"></i>Nombre Completo *
                                </label>
                                <?php if(form_error('nombre')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('nombre'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" 
                                       class="form-control <?php echo (form_error('empresa')) ? 'is-invalid' : ''; ?>" 
                                       id="empresa" 
                                       name="empresa" 
                                       value="<?php echo set_value('empresa'); ?>" 
                                       placeholder="Nombre de la Empresa">
                                <label for="empresa">
                                    <i class="fas fa-building me-2"></i>Empresa
                                </label>
                                <?php if(form_error('empresa')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('empresa'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" 
                                       class="form-control <?php echo (form_error('contacto')) ? 'is-invalid' : ''; ?>" 
                                       id="contacto" 
                                       name="contacto" 
                                       value="<?php echo set_value('contacto'); ?>" 
                                       placeholder="Número de Teléfono">
                                <label for="contacto">
                                    <i class="fas fa-phone me-2"></i>Contacto
                                </label>
                                <?php if(form_error('contacto')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('contacto'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="email" 
                                       class="form-control <?php echo (form_error('email')) ? 'is-invalid' : ''; ?>" 
                                       id="email" 
                                       name="email" 
                                       value="<?php echo set_value('email'); ?>" 
                                       placeholder="Correo Electrónico">
                                <label for="email">
                                    <i class="fas fa-envelope me-2"></i>Email
                                </label>
                                <?php if(form_error('email')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('email'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select <?php echo (form_error('origen')) ? 'is-invalid' : ''; ?>" 
                                        id="origen" 
                                        name="origen">
                                    <option value="">Seleccionar Origen</option>
                                    <option value="WhatsApp" <?php echo set_select('origen', 'WhatsApp'); ?>>
                                        <i class="fab fa-whatsapp"></i> WhatsApp
                                    </option>
                                    <option value="Facebook" <?php echo set_select('origen', 'Facebook'); ?>>
                                        <i class="fab fa-facebook"></i> Facebook
                                    </option>
                                    <option value="Instagram" <?php echo set_select('origen', 'Instagram'); ?>>
                                        <i class="fab fa-instagram"></i> Instagram
                                    </option>
                                    <option value="Referido" <?php echo set_select('origen', 'Referido'); ?>>
                                        <i class="fas fa-user-friends"></i> Referido
                                    </option>
                                    <option value="Sitio Web" <?php echo set_select('origen', 'Sitio Web'); ?>>
                                        <i class="fas fa-globe"></i> Sitio Web
                                    </option>
                                    <option value="Otro" <?php echo set_select('origen', 'Otro'); ?>>
                                        <i class="fas fa-ellipsis-h"></i> Otro
                                    </option>
                                </select>
                                <label for="origen">
                                    <i class="fas fa-tag me-2"></i>Origen
                                </label>
                                <?php if(form_error('origen')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('origen'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" 
                                       class="form-control <?php echo (form_error('observaciones')) ? 'is-invalid' : ''; ?>" 
                                       id="observaciones" 
                                       name="observaciones" 
                                       value="<?php echo set_value('observaciones'); ?>" 
                                       placeholder="Observaciones adicionales">
                                <label for="observaciones">
                                    <i class="fas fa-sticky-note me-2"></i>Observaciones
                                </label>
                                <?php if(form_error('observaciones')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('observaciones'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="<?php echo base_url('clients'); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Volver
                        </a>
                        
                        <div>
                            <button type="reset" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-undo me-2"></i>Restablecer
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Crear Cliente
                            </button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?php
// Obtener el contenido del buffer
$content = ob_get_clean();

// Scripts específicos de la página
$page_scripts = "
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    // Validación del formulario
    document.getElementById('createClientForm').addEventListener('submit', function(e) {
        const nombre = document.getElementById('nombre').value.trim();
        const email = document.getElementById('email').value.trim();
        
        if (nombre.length < 3) {
            e.preventDefault();
            alert('El nombre debe tener al menos 3 caracteres');
            return false;
        }
        
        if (email && !isValidEmail(email)) {
            e.preventDefault();
            alert('Por favor ingresa un email válido');
            return false;
        }
    });
    
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
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
    'content' => $content
));
?>
