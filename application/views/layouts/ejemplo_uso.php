<?php
/**
 * EJEMPLO DE USO DEL SISTEMA DE LAYOUTS
 * 
 * Este archivo muestra cómo usar los layouts en las vistas del sistema
 */

// ========================================
// OPCIÓN 1: Layout Completo (main_layout.php)
// ========================================

// Configuración del layout
$page_title = 'Título de la Página';
$page_type = 'dashboard'; // dashboard, forms, tables
$active_menu = 'dashboard'; // dashboard, cotizaciones, clientes, usuarios, configuracion
$page_header = 'Encabezado de la Página';
$page_subtitle = 'Subtítulo descriptivo';
$page_icon = 'fas fa-icon-name';

// CSS adicional específico de la página
$additional_css = ['utilities.css', 'custom.css'];

// JavaScript adicional
$additional_js = ['jquery.min.js', 'custom.js'];

// Estilos específicos de la página
$page_styles = "
    .custom-class {
        color: var(--primary-yellow);
    }
";

// Scripts específicos de la página
$page_scripts = "
    console.log('Scripts específicos de la página');
    // Tu código JavaScript aquí
";

// Iniciar el buffer de salida
ob_start();
?>

<!-- CONTENIDO DE LA PÁGINA -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Contenido de la Página</h5>
            </div>
            <div class="card-body">
                <p>Este es el contenido específico de tu página.</p>
                <p>Puedes usar HTML, PHP, y todas las funcionalidades de CodeIgniter.</p>
            </div>
        </div>
    </div>
</div>

<?php
// Obtener el contenido del buffer
$content = ob_get_clean();

// Cargar el layout principal con todas las variables
$this->load->view('layouts/main_layout', array(
    'page_title' => $page_title,
    'page_type' => $page_type,
    'active_menu' => $active_menu,
    'page_header' => $page_header,
    'page_subtitle' => $page_subtitle,
    'page_icon' => $page_icon,
    'additional_css' => $additional_css,
    'additional_js' => $additional_js,
    'page_styles' => $page_styles,
    'page_scripts' => $page_scripts,
    'content' => $content,
    'show_footer' => true // Opcional: mostrar footer
));
?>

<!-- ========================================
     OPCIÓN 2: Layout Simplificado (simple_layout.php)
     ======================================== -->

<?php
// Para páginas más simples, usar simple_layout.php
$page_title = 'Página Simple';
$page_type = 'forms'; // Solo carga CSS básico + navbar + el tipo especificado

ob_start();
?>

<div class="container mt-4">
    <h1>Página Simple</h1>
    <p>Contenido de la página simple.</p>
</div>

<?php
$content = ob_get_clean();

// Cargar layout simplificado
$this->load->view('layouts/simple_layout', array(
    'page_title' => $page_title,
    'page_type' => $page_type,
    'content' => $content
));
?>

<!-- ========================================
     OPCIÓN 3: Solo el Menú (menu_view.php)
     ======================================== -->

<?php
// Para incluir solo el menú en páginas existentes
$active_menu = 'dashboard';

// Incluir solo el menú
$this->load->view('layouts/menu_view', array(
    'active_menu' => $active_menu
));
?>

<!-- Luego continuar con tu HTML normal -->
<!DOCTYPE html>
<html>
<head>
    <title>Mi Página</title>
    <!-- Tus CSS y JS aquí -->
</head>
<body>
    <!-- El menú ya está incluido arriba -->
    
    <div class="container">
        <h1>Mi Contenido</h1>
        <!-- Resto de tu contenido -->
    </div>
</body>
</html>
