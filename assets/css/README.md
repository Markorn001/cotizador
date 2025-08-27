# Sistema CSS del Cotizador

## 📁 Estructura de Archivos

```
assets/css/
├── main.css           # Variables CSS y estilos base
├── navbar.css         # Estilos de navegación
├── cards.css          # Estilos de tarjetas y componentes
├── forms.css          # Estilos de formularios
├── tables.css         # Estilos de tablas y badges
├── utilities.css      # Utilidades y alertas
├── index.css          # Archivo principal que importa todo
└── README.md          # Esta documentación
```

## 🎨 Archivos CSS Principales

### 1. `main.css` - Estilos Base
- **Variables CSS**: Colores principales, sombras, transiciones
- **Estilos base**: Reset, body, tipografía
- **Utilidades básicas**: Clases de color y fondo
- **Animaciones**: Keyframes principales
- **Breakpoints responsive**: Media queries base

**Variables principales:**
```css
:root {
    --primary-dark: #1D1D1B;
    --primary-yellow: #FEC422;
    --primary-white: #FFFFFF;
    --primary-yellow-hover: #e6b31e;
    --border-radius: 15px;
    --transition: all 0.3s ease;
}
```

### 2. `navbar.css` - Navegación
- **Navbar principal**: Estilos del menú superior
- **Brand/Logo**: Estilos del nombre de la aplicación
- **Enlaces de navegación**: Hover effects y estados activos
- **Botón de logout**: Estilos personalizados
- **Responsive**: Adaptaciones para móviles

### 3. `cards.css` - Tarjetas y Componentes
- **Tarjetas generales**: Estilos base para cards
- **Tarjetas de estadísticas**: Diseño especial para métricas
- **Sección de bienvenida**: Header principal del dashboard
- **Efectos hover**: Animaciones y transiciones
- **Responsive**: Adaptaciones para diferentes tamaños

### 4. `forms.css` - Formularios
- **Controles de formulario**: Inputs, selects, textareas
- **Labels y texto**: Estilos para etiquetas y ayuda
- **Validación**: Estados de éxito y error
- **Botones**: Estilos personalizados para botones
- **Input groups**: Combinaciones de inputs
- **Responsive**: Adaptaciones móviles

### 5. `tables.css` - Tablas y Badges
- **Tablas**: Estilos base para tablas
- **Headers**: Estilos para encabezados
- **Filas**: Hover effects y striped rows
- **Badges**: Estilos para roles y estados
- **Botones de acción**: Estilos para acciones en tablas
- **DataTables**: Mejoras para DataTables.js
- **Responsive**: Tablas adaptativas

### 6. `utilities.css` - Utilidades y Alertas
- **Alertas**: Estilos para mensajes del sistema
- **Espaciado**: Clases de margin y padding
- **Texto**: Alineación, transformaciones, tamaños
- **Display**: Clases de visibilidad y flexbox
- **Bordes**: Clases de bordes y radios
- **Sombras**: Clases de box-shadow
- **Posicionamiento**: Clases de position
- **Responsive**: Utilidades adaptativas

### 7. `index.css` - Archivo Principal
- **Importaciones**: Incluye todos los archivos CSS
- **Estilos adicionales**: Componentes específicos del sistema
- **Animaciones**: Efectos especiales
- **Componentes**: Estilos para login, dashboard, perfil
- **Utilidades avanzadas**: Tooltips, modales, paginación

## 🚀 Uso de los Archivos CSS

### Opción 1: Archivo Principal (Recomendado para desarrollo)
```html
<link rel="stylesheet" href="<?php echo base_url('assets/css/index.css'); ?>">
```

### Opción 2: Archivos Individuales (Recomendado para producción)
```html
<!-- Solo los archivos necesarios -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/navbar.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/cards.css'); ?>">
```

### Opción 3: Archivos Específicos por Vista
```html
<!-- Dashboard -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/navbar.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/cards.css'); ?>">

<!-- Formularios -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/forms.css'); ?>">

<!-- Tablas -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/tables.css'); ?>">
```

## 🎯 Clases CSS Principales

### Colores y Fondos
```css
.text-primary-yellow    /* Texto amarillo */
.text-primary-dark      /* Texto oscuro */
.bg-primary-yellow      /* Fondo amarillo */
.bg-primary-dark        /* Fondo oscuro */
```

### Espaciado
```css
.mt-1, .mt-2, .mt-3    /* Margin top */
.mb-1, .mb-2, .mb-3    /* Margin bottom */
.pt-1, .pt-2, .pt-3    /* Padding top */
.pb-1, .pb-2, .pb-3    /* Padding bottom */
```

### Display y Flexbox
```css
.d-flex                /* Display flex */
.d-none                /* Display none */
.justify-content-center /* Centrar horizontalmente */
.align-items-center     /* Centrar verticalmente */
```

### Responsive
```css
.d-sm-none             /* Ocultar en pantallas pequeñas */
.d-md-block            /* Mostrar en pantallas medianas */
.text-xs-center        /* Centrar texto en móviles */
```

## 📱 Breakpoints Responsive

```css
/* Extra small devices (phones, 576px and down) */
@media (max-width: 576px) { }

/* Small devices (landscape phones, 576px and up) */
@media (min-width: 576px) { }

/* Medium devices (tablets, 768px and up) */
@media (min-width: 768px) { }

/* Large devices (desktops, 992px and up) */
@media (min-width: 992px) { }

/* Extra large devices (large desktops, 1200px and up) */
@media (min-width: 1200px) { }
```

## 🔧 Personalización

### Cambiar Colores Principales
Edita las variables en `main.css`:
```css
:root {
    --primary-dark: #1D1D1B;      /* Color principal oscuro */
    --primary-yellow: #FEC422;    /* Color principal amarillo */
    --primary-white: #FFFFFF;     /* Color principal blanco */
}
```

### Agregar Nuevos Componentes
1. Crea un nuevo archivo CSS específico
2. Importa las variables desde `main.css`
3. Agrega el archivo a `index.css`
4. Incluye el archivo en las vistas que lo necesiten

### Modificar Estilos Existentes
- **No edites** directamente los archivos CSS principales
- **Crea un archivo personalizado** que sobrescriba los estilos
- **Usa especificidad CSS** para asegurar que tus cambios se apliquen

## 📋 Checklist de Implementación

- [x] Crear estructura de directorios CSS
- [x] Separar estilos por funcionalidad
- [x] Crear variables CSS centralizadas
- [x] Implementar sistema responsive
- [x] Crear utilidades CSS
- [x] Actualizar vistas para usar archivos separados
- [x] Crear archivo índice principal
- [x] Documentar estructura y uso

## 🚨 Consideraciones Importantes

### Rendimiento
- **Desarrollo**: Usa `index.css` para facilitar el desarrollo
- **Producción**: Incluye solo los archivos necesarios por vista
- **Minificación**: Considera minificar los archivos CSS en producción

### Mantenimiento
- **No edites** los archivos CSS principales directamente
- **Crea archivos personalizados** para modificaciones específicas
- **Documenta** cualquier cambio o adición

### Compatibilidad
- **Navegadores**: Compatible con navegadores modernos
- **Dispositivos**: Responsive para móviles, tablets y desktop
- **CSS**: Utiliza CSS3 con fallbacks para navegadores antiguos

## 🔍 Solución de Problemas

### Los estilos no se aplican
1. Verifica que la ruta del archivo CSS sea correcta
2. Asegúrate de que `base_url()` esté configurado
3. Revisa la consola del navegador para errores 404

### Conflictos de estilos
1. Usa clases más específicas
2. Agrega `!important` solo cuando sea necesario
3. Revisa el orden de carga de los archivos CSS

### Problemas responsive
1. Verifica que los media queries estén correctos
2. Asegúrate de que el viewport esté configurado
3. Prueba en diferentes dispositivos y tamaños

## 📚 Recursos Adicionales

- **Bootstrap 5**: Framework base del sistema
- **Font Awesome**: Iconos del sistema
- **DataTables**: Mejoras para tablas
- **CSS Variables**: Sistema de variables CSS
- **Flexbox**: Layout moderno del sistema

---

**Desarrollado para el Sistema de Cotizador**  
**Versión**: 1.0  
**Última actualización**: Diciembre 2024
