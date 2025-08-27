<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - Cotizador</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/navbar.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/cards.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/forms.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/utilities.css'); ?>">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo base_url('dashboard'); ?>">
                <i class="fas fa-calculator me-2"></i>Cotizador
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('dashboard'); ?>">
                            <i class="fas fa-home me-1"></i>Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('users'); ?>">
                            <i class="fas fa-users me-1"></i>Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('users/profile'); ?>">
                            <i class="fas fa-user me-1"></i>Mi Perfil
                        </a>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="<?php echo base_url('login/logout'); ?>" class="btn btn-outline-light">
                            <i class="fas fa-sign-out-alt me-1"></i>Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-user-plus me-2"></i><?php echo $title; ?>
            </h1>
            <a href="<?php echo base_url('users'); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver
            </a>
        </div>

        <!-- Form Card -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-user-plus me-2"></i>Información del Usuario
                    </div>
                    <div class="card-body">
                        <?php if(validation_errors()): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Error:</strong> Por favor, corrige los siguientes errores:
                                <ul class="mb-0 mt-2">
                                    <?php echo validation_errors('<li>', '</li>'); ?>
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php echo form_open('users/create', ['id' => 'createUserForm']); ?>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="username" class="form-label required-field">Usuario</label>
                                    <input type="text" class="form-control" id="username" name="username" 
                                           value="<?php echo set_value('username'); ?>" 
                                           placeholder="Ingrese nombre de usuario" required>
                                    <div class="form-text">Mínimo 3 caracteres, máximo 20</div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label required-field">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?php echo set_value('email'); ?>" 
                                           placeholder="usuario@ejemplo.com" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="full_name" class="form-label required-field">Nombre Completo</label>
                                    <input type="text" class="form-control" id="full_name" name="full_name" 
                                           value="<?php echo set_value('full_name'); ?>" 
                                           placeholder="Ingrese nombre completo" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="role" class="form-label required-field">Rol</label>
                                    <select class="form-select" id="role" name="role" required>
                                        <option value="">Seleccione un rol</option>
                                        <option value="admin" <?php echo set_select('role', 'admin'); ?>>Administrador</option>
                                        <option value="supervisor" <?php echo set_select('role', 'supervisor'); ?>>Supervisor</option>
                                        <option value="vendedor" <?php echo set_select('role', 'vendedor'); ?>>Vendedor</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label required-field">Contraseña</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" 
                                               placeholder="Ingrese contraseña" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-text">Mínimo 6 caracteres</div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="confirm_password" class="form-label required-field">Confirmar Contraseña</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                               placeholder="Confirme la contraseña" required>
                                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Información:</strong>
                                        <ul class="mb-0 mt-2">
                                            <li><strong>Administrador:</strong> Acceso completo al sistema</li>
                                            <li><strong>Supervisor:</strong> Puede gestionar usuarios y ver reportes</li>
                                            <li><strong>Vendedor:</strong> Acceso limitado a cotizaciones y clientes</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                                <a href="<?php echo base_url('users'); ?>" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Crear Usuario
                                </button>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const password = document.getElementById('confirm_password');
            const icon = this.querySelector('i');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Form validation
        document.getElementById('createUserForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
                return false;
            }
            
            if (password.length < 6) {
                e.preventDefault();
                alert('La contraseña debe tener al menos 6 caracteres');
                return false;
            }
        });
    </script>
</body>
</html>
