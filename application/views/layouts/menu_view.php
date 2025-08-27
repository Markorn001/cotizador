<?php
/**
 * Layout del Menú de Navegación
 * Archivo reutilizable para todas las páginas del sistema
 * 
 * Variables esperadas:
 * - $page_title: Título de la página actual
 * - $active_menu: Menú activo (opcional)
 */
?>
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
                    <a class="nav-link <?php echo (isset($active_menu) && $active_menu == 'dashboard') ? 'active' : ''; ?>" 
                       href="<?php echo base_url('dashboard'); ?>">
                        <i class="fas fa-home me-1"></i>Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (isset($active_menu) && $active_menu == 'cotizaciones') ? 'active' : ''; ?>" 
                       href="<?php echo base_url('cotizaciones'); ?>">
                        <i class="fas fa-file-invoice me-1"></i>Cotizaciones
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (isset($active_menu) && $active_menu == 'clientes') ? 'active' : ''; ?>" 
                       href="<?php echo base_url('clients'); ?>">
                        <i class="fas fa-users me-1"></i>Clientes
                    </a>
                </li>
                <?php if(in_array($this->session->userdata('role'), ['admin', 'supervisor'])): ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo (isset($active_menu) && $active_menu == 'usuarios') ? 'active' : ''; ?>" 
                       href="<?php echo base_url('users'); ?>">
                        <i class="fas fa-user-cog me-1"></i>Usuarios
                    </a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo (isset($active_menu) && $active_menu == 'configuracion') ? 'active' : ''; ?>" 
                       href="<?php echo base_url('configuracion'); ?>">
                        <i class="fas fa-cog me-1"></i>Configuración
                    </a>
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
