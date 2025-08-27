<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Cotizador</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/navbar.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/cards.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/forms.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/tables.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/utilities.css'); ?>">
    
    <!-- CSS adicional específico de la página -->
    <?php if(isset($additional_css)): ?>
        <?php foreach($additional_css as $css_file): ?>
            <link rel="stylesheet" href="<?php echo base_url('assets/css/' . $css_file); ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Estilos específicos de la página -->
    <?php if(isset($page_styles)): ?>
        <style>
            <?php echo $page_styles; ?>
        </style>
    <?php endif; ?>
</head>
<body>
    <!-- Incluir el menú de navegación -->
    <?php $this->load->view('layouts/menu_view'); ?>
    
    <!-- Contenido principal de la página -->
    <main class="main-content">
        <?php if(isset($page_header)): ?>
            <div class="page-header">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="page-title">
                                <?php if(isset($page_icon)): ?>
                                    <i class="<?php echo $page_icon; ?> me-2"></i>
                                <?php endif; ?>
                                <?php echo $page_header; ?>
                            </h1>
                            <?php if(isset($page_subtitle)): ?>
                                <p class="page-subtitle"><?php echo $page_subtitle; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Contenido específico de la página -->
        <div class="page-content">
            <div class="container">
                <?php if(isset($content)): ?>
                    <?php echo $content; ?>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        No se ha definido el contenido de la página.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    
    <!-- Footer (opcional) -->
    <?php if(isset($show_footer) && $show_footer): ?>
        <footer class="footer mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <p>&copy; <?php echo date('Y'); ?> Sistema de Cotizador. Todos los derechos reservados.</p>
                    </div>
                </div>
            </div>
        </footer>
    <?php endif; ?>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- JavaScript adicional específico de la página -->
    <?php if(isset($additional_js)): ?>
        <?php foreach($additional_js as $js_file): ?>
            <script src="<?php echo base_url('assets/js/' . $js_file); ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Scripts específicos de la página -->
    <?php if(isset($page_scripts)): ?>
        <script>
            <?php echo $page_scripts; ?>
        </script>
    <?php endif; ?>
</body>
</html>
