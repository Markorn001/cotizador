<?php
// Configuración del layout
$page_title = isset($title) ? $title : 'Editar Usuario';
$page_type = 'forms';
$active_menu = 'usuarios';
$page_header = isset($title) ? $title : 'Editar Usuario';
$page_subtitle = 'Modifica la información del usuario';
$page_icon = 'fas fa-user-edit';

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
                    <i class="fas fa-user-edit me-2"></i>Editar Usuario
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
                
                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?php echo $this->session->flashdata('success'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php echo form_open('users/edit/' . $user->id, ['id' => 'editUserForm']); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" 
                                       class="form-control <?php echo (form_error('username')) ? 'is-invalid' : ''; ?>" 
                                       id="username" 
                                       name="username" 
                                       value="<?php echo set_value('username', $user->username); ?>" 
                                       placeholder="Usuario" 
                                       required>
                                <label for="username">
                                    <i class="fas fa-user me-2"></i>Usuario
                                </label>
                                <?php if(form_error('username')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('username'); ?>
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
                                       value="<?php echo set_value('email', $user->email); ?>" 
                                       placeholder="Email" 
                                       required>
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

                    <div class="form-floating mb-3">
                        <input type="text" 
                               class="form-control <?php echo (form_error('full_name')) ? 'is-invalid' : ''; ?>" 
                               id="full_name" 
                               name="full_name" 
                               value="<?php echo set_value('full_name', $user->full_name); ?>" 
                               placeholder="Nombre Completo" 
                               required>
                        <label for="full_name">
                            <i class="fas fa-id-card me-2"></i>Nombre Completo
                        </label>
                        <?php if(form_error('full_name')): ?>
                            <div class="invalid-feedback">
                                <?php echo form_error('full_name'); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="tel" 
                               class="form-control <?php echo (form_error('phone')) ? 'is-invalid' : ''; ?>" 
                               id="phone" 
                               name="phone" 
                               value="<?php echo set_value('phone', isset($user->phone) ? $user->phone : ''); ?>" 
                               placeholder="Número de Contacto">
                        <label for="phone">
                            <i class="fas fa-phone me-2"></i>Número de Contacto
                        </label>
                        <div class="form-text">
                            <small>Ejemplo: +52 55 1234 5678 o 55-1234-5678</small>
                        </div>
                        <?php if(form_error('phone')): ?>
                            <div class="invalid-feedback">
                                <?php echo form_error('phone'); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select <?php echo (form_error('role')) ? 'is-invalid' : ''; ?>" 
                                        id="role" 
                                        name="role" 
                                        required>
                                    <option value="">Seleccionar Rol</option>
                                    <option value="admin" <?php echo set_select('role', 'admin', ($user->role == 'admin')); ?>>
                                        <i class="fas fa-user-shield"></i> Administrador
                                    </option>
                                    <option value="supervisor" <?php echo set_select('role', 'supervisor', ($user->role == 'supervisor')); ?>>
                                        <i class="fas fa-user-tie"></i> Supervisor
                                    </option>
                                    <option value="vendedor" <?php echo set_select('role', 'vendedor', ($user->role == 'vendedor')); ?>>
                                        <i class="fas fa-user"></i> Vendedor
                                    </option>
                                </select>
                                <label for="role">
                                    <i class="fas fa-user-tag me-2"></i>Rol
                                </label>
                                <?php if(form_error('role')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('role'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="status" name="status">
                                    <option value="active" <?php echo ($user->status == 'active') ? 'selected' : ''; ?>>
                                        Activo
                                    </option>
                                    <option value="inactive" <?php echo ($user->status == 'inactive') ? 'selected' : ''; ?>>
                                        Inactivo
                                    </option>
                                </select>
                                <label for="status">
                                    <i class="fas fa-toggle-on me-2"></i>Estado
                                </label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="password" 
                                       class="form-control <?php echo (form_error('password')) ? 'is-invalid' : ''; ?>" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Nueva Contraseña">
                                <label for="password">
                                    <i class="fas fa-lock me-2"></i>Nueva Contraseña
                                </label>
                                <div class="form-text">
                                    <small>Deja en blanco para mantener la contraseña actual</small>
                                </div>
                                <?php if(form_error('password')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('password'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="password" 
                                       class="form-control <?php echo (form_error('confirm_password')) ? 'is-invalid' : ''; ?>" 
                                       id="confirm_password" 
                                       name="confirm_password" 
                                       placeholder="Confirmar Contraseña">
                                <label for="confirm_password">
                                    <i class="fas fa-lock me-2"></i>Confirmar Contraseña
                                </label>
                                <?php if(form_error('confirm_password')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('confirm_password'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" 
                                       class="form-control" 
                                       id="created_at" 
                                       value="<?php echo date('d/m/Y H:i', strtotime($user->created_at)); ?>" 
                                       readonly>
                                <label for="created_at">
                                    <i class="fas fa-calendar-plus me-2"></i>Fecha de Creación
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" 
                                       class="form-control" 
                                       id="updated_at" 
                                       value="<?php echo ($user->updated_at) ? date('d/m/Y H:i', strtotime($user->updated_at)) : 'Nunca'; ?>" 
                                       readonly>
                                <label for="updated_at">
                                    <i class="fas fa-edit me-2"></i>Última Actualización
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="<?php echo base_url('users'); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Volver
                        </a>
                        
                        <div>
                            <button type="reset" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-undo me-2"></i>Restablecer
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Cambios
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
    // Validación del formulario
    document.getElementById('editUserForm').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        
        if (password && password !== confirmPassword) {
            e.preventDefault();
            alert('Las contraseñas no coinciden');
            return false;
        }
        
        if (password && password.length < 6) {
            e.preventDefault();
            alert('La contraseña debe tener al menos 6 caracteres');
            return false;
        }
    });
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
    
    // Mostrar/ocultar campos de contraseña según necesidad
    document.getElementById('password').addEventListener('input', function() {
        const confirmPassword = document.getElementById('confirm_password');
        if (this.value) {
            confirmPassword.required = true;
            confirmPassword.parentElement.classList.add('required');
        } else {
            confirmPassword.required = false;
            confirmPassword.parentElement.classList.remove('required');
            confirmPassword.value = '';
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
    'page_scripts' => $page_scripts,
    'content' => $content
));
?>
