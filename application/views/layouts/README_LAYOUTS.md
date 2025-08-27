# 🏗️ Sistema de Layouts - Cotizador

## 📋 Descripción General

El sistema de layouts permite reutilizar la estructura HTML común (menú, CSS, JavaScript) en todas las páginas del sistema, manteniendo consistencia visual y facilitando el mantenimiento.

## 🗂️ Archivos del Sistema

### 1. `menu_view.php` - Menú de Navegación
- **Propósito**: Menú de navegación reutilizable
- **Uso**: Incluir solo el menú en páginas existentes
- **Variables**: `$active_menu` (opcional)

### 2. `main_layout.php` - Layout Completo
- **Propósito**: Layout completo con header, contenido y footer
- **Uso**: Páginas principales del sistema
- **Características**: Incluye todo el HTML, CSS y JavaScript base

### 3. `simple_layout.php` - Layout Simplificado
- **Propósito**: Layout básico solo con menú y contenido
- **Uso**: Páginas simples sin header complejo
- **Características**: Carga CSS según el tipo de página

## 🚀 Cómo Usar los Layouts

### Opción 1: Layout Completo (Recomendado)

```php
<?php
// Configuración del layout
$page_title = 'Mi Página';
$page_type = 'dashboard';
$active_menu = 'dashboard';
$page_header = 'Título de la Página';
$page_subtitle = 'Subtítulo descriptivo';
$page_icon = 'fas fa-icon-name';

// Iniciar buffer de salida
ob_start();
?>

<!-- CONTENIDO DE LA PÁGINA -->
<div class="card">
    <div class="card-body">
        <h5>Mi Contenido</h5>
        <p>Aquí va el contenido específico de la página.</p>
    </div>
</div>

<?php
// Obtener contenido y cargar layout
$content = ob_get_clean();

$this->load->view('layouts/main_layout', array(
    'page_title' => $page_title,
    'page_type' => $page_type,
    'active_menu' => $active_menu,
    'page_header' => $page_header,
    'page_subtitle' => $page_subtitle,
    'page_icon' => $page_icon,
    'content' => $content
));
?>
```

### Opción 2: Layout Simplificado

```php
<?php
$page_title = 'Página Simple';
$page_type = 'forms';
$active_menu = 'configuracion';

ob_start();
?>

<div class="container mt-4">
    <h1>Mi Página Simple</h1>
    <p>Contenido de la página.</p>
</div>

<?php
$content = ob_get_clean();

$this->load->view('layouts/simple_layout', array(
    'page_title' => $page_title,
    'page_type' => $page_type,
    'active_menu' => $active_menu,
    'content' => $content
));
?>
```

### Opción 3: Solo el Menú

```php
<?php
// Incluir solo el menú
$this->load->view('layouts/menu_view', array(
    'active_menu' => 'dashboard'
));
?>

<!-- Continuar con HTML normal -->
<!DOCTYPE html>
<html>
<head>
    <title>Mi Página</title>
    <!-- CSS y JS aquí -->
</head>
<body>
    <!-- El menú ya está incluido arriba -->
    <div class="container">
        <h1>Mi Contenido</h1>
    </div>
</body>
</html>
```

## 🎯 Variables Disponibles

### Variables Principales
- **`$page_title`**: Título de la página (aparece en `<title>`)
- **`$page_type`**: Tipo de página (dashboard, forms, tables)
- **`$active_menu`**: Menú activo para resaltar
- **`$page_header`**: Encabezado principal de la página
- **`$page_subtitle`**: Subtítulo descriptivo
- **`$page_icon`**: Icono de Font Awesome para el header

### Variables de Recursos
- **`$additional_css`**: Array de archivos CSS adicionales
- **`$additional_js`**: Array de archivos JavaScript adicionales
- **`$page_styles`**: CSS inline específico de la página
- **`$page_scripts`**: JavaScript inline específico de la página

### Variables de Configuración
- **`$show_footer`**: Mostrar/ocultar footer (boolean)
- **`$content`**: Contenido principal de la página (obligatorio)

## 📱 Tipos de Página (`$page_type`)

### `dashboard`
- Carga: `main.css`, `navbar.css`, `cards.css`
- Uso: Páginas principales, dashboards, paneles de control

### `forms`
- Carga: `main.css`, `navbar.css`, `forms.css`
- Uso: Formularios, creación, edición

### `tables`
- Carga: `main.css`, `navbar.css`, `tables.css`
- Uso: Listas, tablas, gestión de datos

## 🧭 Menús Disponibles (`$active_menu`)

- **`dashboard`**: Página de inicio
- **`cotizaciones`**: Gestión de cotizaciones
- **`clientes`**: Gestión de clientes
- **`usuarios`**: Gestión de usuarios (solo admin/supervisor)
- **`configuracion`**: Configuración del sistema

## 🔧 Funcionalidades del Layout

### Header Automático
- Título con icono
- Subtítulo descriptivo
- Navegación de breadcrumbs (opcional)

### CSS Inteligente
- Carga automática según tipo de página
- CSS adicional personalizable
- Estilos inline específicos

### JavaScript Modular
- Bootstrap incluido automáticamente
- JavaScript adicional personalizable
- Scripts inline específicos

### Menú Responsive
- Adaptación automática a móviles
- Menú activo resaltado
- Control de acceso por roles

## 📋 Checklist de Implementación

### Para Nueva Página
- [ ] Definir variables del layout
- [ ] Iniciar buffer de salida (`ob_start()`)
- [ ] Escribir contenido HTML
- [ ] Obtener contenido (`ob_get_clean()`)
- [ ] Cargar layout con variables
- [ ] Probar en diferentes dispositivos

### Para Página Existente
- [ ] Identificar tipo de página
- [ ] Extraer contenido HTML
- [ ] Configurar variables del layout
- [ ] Implementar buffer de salida
- [ ] Cargar layout apropiado
- [ ] Verificar funcionalidad

## 🚨 Consideraciones Importantes

### Rendimiento
- **Buffer de salida**: Siempre usar `ob_start()` y `ob_get_clean()`
- **CSS condicional**: Solo cargar archivos necesarios
- **JavaScript**: Agrupar scripts relacionados

### Mantenimiento
- **Variables**: Definir todas las variables antes de usar
- **Contenido**: El contenido debe estar en `$content`
- **Layout**: Usar el layout apropiado para cada caso

### Compatibilidad
- **Navegadores**: Compatible con navegadores modernos
- **Dispositivos**: Responsive automático
- **CodeIgniter**: Compatible con versión 3.x

## 🔍 Solución de Problemas

### Error: "Undefined variable: content"
- **Causa**: No se pasó `$content` al layout
- **Solución**: Asegurar que `$content` esté definida

### Error: "Layout not found"
- **Causa**: Ruta incorrecta del layout
- **Solución**: Verificar que el archivo existe en `views/layouts/`

### CSS no se aplica
- **Causa**: `$page_type` incorrecto o CSS no encontrado
- **Solución**: Verificar tipo de página y archivos CSS

### Menú no funciona
- **Causa**: `$active_menu` no definido o incorrecto
- **Solución**: Verificar valor de `$active_menu`

## 📚 Ejemplos Prácticos

### Dashboard
```php
$page_type = 'dashboard';
$active_menu = 'dashboard';
$page_header = 'Panel de Control';
```

### Formulario de Usuario
```php
$page_type = 'forms';
$active_menu = 'usuarios';
$page_header = 'Crear Usuario';
```

### Lista de Clientes
```php
$page_type = 'tables';
$active_menu = 'clientes';
$page_header = 'Gestión de Clientes';
```

## 🎉 Beneficios del Sistema

1. **Consistencia**: Mismo diseño en todas las páginas
2. **Mantenimiento**: Cambios centralizados en layouts
3. **Desarrollo**: Crear páginas más rápido
4. **Organización**: Estructura clara y modular
5. **Responsive**: Adaptación automática a dispositivos
6. **Accesibilidad**: Navegación consistente y clara

---

**Desarrollado para el Sistema de Cotizador**  
**Versión**: 1.0  
**Última actualización**: Diciembre 2024
