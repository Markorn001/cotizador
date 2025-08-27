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
    
    <!-- CSS adicional según la página -->
    <?php if(isset($page_type)): ?>
        <?php if($page_type == 'dashboard'): ?>
            <link rel="stylesheet" href="<?php echo base_url('assets/css/cards.css'); ?>">
        <?php elseif($page_type == 'forms'): ?>
            <link rel="stylesheet" href="<?php echo base_url('assets/css/forms.css'); ?>">
        <?php elseif($page_type == 'tables'): ?>
            <link rel="stylesheet" href="<?php echo base_url('assets/css/tables.css'); ?>">
        <?php endif; ?>
    <?php endif; ?>
    
    <!-- CSS adicional específico -->
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
    
    <!-- Contenido específico de la página -->
    <?php echo $content; ?>
    
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
