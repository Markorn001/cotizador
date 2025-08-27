<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cotizador</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/forms.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/utilities.css'); ?>">
    
    <!-- Estilos específicos del login -->
    <style>
        body {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-dark-light) 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-card {
            background: var(--primary-white);
            border-radius: var(--border-radius);
            box-shadow: 0 20px 40px var(--shadow-heavy);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
            animation: slideUp 0.6s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-header {
            background: var(--primary-yellow);
            padding: 30px 20px;
            text-align: center;
            position: relative;
        }
        
        .login-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, var(--primary-yellow), #ffd700);
            opacity: 0.9;
        }
        
        .login-header h2 {
            color: var(--primary-dark);
            font-weight: 700;
            margin: 0;
            position: relative;
            z-index: 1;
            font-size: 2rem;
        }
        
        .login-header p {
            color: var(--primary-dark);
            margin: 10px 0 0 0;
            position: relative;
            z-index: 1;
            opacity: 0.8;
        }
        
        .logo-container {
            text-align: center;
            position: relative;
            z-index: 1;
        }
        
        .login-logo {
            max-width: 120px;
            height: auto;
            border-radius: var(--border-radius-small);
            box-shadow: 0 4px 15px var(--shadow-light);
            transition: var(--transition);
        }
        
        .login-logo:hover {
            transform: scale(1.05);
        }
        
        .login-body {
            padding: 40px 30px;
        }
        
        .form-floating {
            margin-bottom: 20px;
        }
        
        .btn-login {
            background: var(--primary-yellow);
            border: none;
            color: var(--primary-dark);
            padding: 15px;
            border-radius: var(--border-radius-small);
            font-weight: 600;
            font-size: 16px;
            width: 100%;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-login:hover {
            background: var(--primary-yellow-hover);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(254, 196, 34, 0.4);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .input-group-text {
            background: var(--primary-dark);
            border: 2px solid var(--primary-dark);
            color: var(--primary-white);
            border-radius: var(--border-radius-small) 0 0 var(--border-radius-small);
        }
        
        .input-group .form-control {
            border-left: none;
            border-radius: 0 var(--border-radius-small) var(--border-radius-small) 0;
        }
        
        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }
        
        .forgot-password a {
            color: var(--primary-dark);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .forgot-password a:hover {
            color: var(--primary-yellow);
        }
        
        /* Responsive adjustments */
        @media (max-width: 576px) {
            .login-card {
                margin: 10px;
                border-radius: var(--border-radius-small);
            }
            
            .login-header {
                padding: 25px 15px;
            }
            
            .login-header h2 {
                font-size: 1.75rem;
            }
            
            .login-body {
                padding: 30px 20px;
            }
            
            .login-logo {
                max-width: 100px;
            }
        }
        
        @media (max-width: 400px) {
            .login-container {
                padding: 10px;
            }
            
            .login-card {
                margin: 5px;
            }
            
            .login-logo {
                max-width: 80px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-container mb-3">
                    <img src="<?php echo base_url('assets/images/logos/logorepase.png'); ?>" alt="Logo Cotizador" class="login-logo">
                </div>
                <h2><i class="fas fa-user-lock me-2"></i>Login Repase</h2>
                <p>Sistema de Cotizador</p>
            </div>
            
            <div class="login-body">
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
                
                <?php echo form_open('login/authenticate', ['id' => 'loginForm']); ?>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Usuario" required>
                        <label for="username"><i class="fas fa-user me-2"></i>Usuario</label>
                    </div>
                    
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                        <label for="password"><i class="fas fa-lock me-2"></i>Contraseña</label>
                    </div>
                    
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                    </button>
                <?php echo form_close(); ?>
                
                <div class="forgot-password">
                    <a href="#"><i class="fas fa-question-circle me-1"></i>¿Olvidaste tu contraseña?</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // Form validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            
            if (!username || !password) {
                e.preventDefault();
                alert('Por favor, completa todos los campos');
                return false;
            }
        });
    </script>
</body>
</html>
