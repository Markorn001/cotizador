<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Cotizador</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-dark: #1D1D1B;
            --primary-yellow: #FEC422;
            --primary-white: #FFFFFF;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: var(--primary-dark) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            color: var(--primary-yellow) !important;
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .navbar-nav .nav-link {
            color: var(--primary-white) !important;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover {
            color: var(--primary-yellow) !important;
        }
        
        .btn-logout {
            background: var(--primary-yellow);
            color: var(--primary-dark);
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-logout:hover {
            background: #e6b31e;
            transform: translateY(-1px);
        }
        
        .welcome-section {
            background: linear-gradient(135deg, var(--primary-dark) 0%, #2a2a28 100%);
            color: var(--primary-white);
            padding: 60px 0;
            margin-bottom: 40px;
        }
        
        .welcome-title {
            color: var(--primary-yellow);
            font-weight: 700;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .card-header {
            background: var(--primary-yellow);
            color: var(--primary-dark);
            border-radius: 15px 15px 0 0 !important;
            font-weight: 600;
            border: none;
        }
        
        .stats-card {
            text-align: center;
            padding: 30px 20px;
        }
        
        .stats-icon {
            font-size: 3rem;
            color: var(--primary-yellow);
            margin-bottom: 20px;
        }
        
        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 10px;
        }
        
        .stats-label {
            color: #6c757d;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-calculator me-2"></i>Cotizador
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-home me-1"></i>Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-file-invoice me-1"></i>Cotizaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-users me-1"></i>Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-cog me-1"></i>Configuración</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="<?php echo base_url('login/logout'); ?>" class="btn btn-logout">
                            <i class="fas fa-sign-out-alt me-1"></i>Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Welcome Section -->
    <section class="welcome-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="welcome-title mb-3">
                        <i class="fas fa-tachometer-alt me-3"></i>Dashboard
                    </h1>
                    <p class="lead mb-0">
                        Bienvenido, <strong><?php echo $username; ?></strong> al Sistema de Cotizador
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
