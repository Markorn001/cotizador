# Sistema de Generación de PDF para Cotizaciones

## Descripción
Este sistema permite generar cotizaciones en formato PDF utilizando el template HTML proporcionado. El sistema utiliza las librerías jsPDF y html2canvas para convertir el HTML a PDF directamente en el navegador.

## Características
- ✅ Generación de PDF desde template HTML
- ✅ Datos dinámicos de cotizaciones reales
- ✅ Diseño profesional con logo de la empresa
- ✅ Dos páginas: cotización principal y condiciones
- ✅ Compresión optimizada para archivos más pequeños
- ✅ Botón de descarga directa en el navegador

## Archivos Creados/Modificados

### Controlador
- `application/controllers/Pdf_generator.php` - Controlador principal para generar PDFs

### Vistas
- `application/views/pdf/quotation_template.php` - Template HTML para PDF con datos dinámicos

### Modelo
- `application/models/Quotation_model.php` - Agregado método `get_quotation_items()`

### Rutas
- `application/config/routes.php` - Rutas para el generador de PDF

### Vista de Cotizaciones
- `application/views/cotizaciones/index.php` - Agregado botón "Generar PDF"

## Uso

### 1. Generar PDF de Cotización Existente
```
URL: /pdf_generator/quotation/{id}
Ejemplo: /pdf_generator/quotation/1
```

### 2. Generar PDF de Prueba (con datos de ejemplo)
```
URL: /pdf_generator/test
```

### 3. Desde la Lista de Cotizaciones
- Ir a la lista de cotizaciones
- Hacer clic en el botón verde con icono de PDF
- Se abrirá una nueva pestaña con el PDF
- Hacer clic en "Descargar PDF" para guardar el archivo

## Estructura del PDF

### Página 1 - Cotización Principal
- **Encabezado**: Logo de la empresa y datos de contacto
- **Datos del Cliente**: Información del cliente y fecha
- **Datos de la Cotización**: Número, asesor, etc.
- **Tabla de Productos**: Items con descripción, cantidad, precios
- **Totales**: Subtotal, IVA y total
- **Información Adicional**: Moneda, forma de pago, ubicación de entrega
- **Comentarios**: Notas adicionales

### Página 2 - Condiciones
- **Condiciones Generales**: Términos y condiciones de la cotización
- **Marcas y Productos**: Lista de marcas disponibles
- **Información Importante**: Validez, garantías, etc.

## Datos Dinámicos

El sistema utiliza los siguientes datos de la base de datos:

### Cotización
- `quotation_number` - Número de cotización
- `quotation_date` - Fecha de la cotización
- `validity_days` - Días de validez
- `currency` - Moneda
- `payment_terms` - Forma de pago
- `delivery_location` - Ubicación de entrega
- `tax_rate` - Porcentaje de IVA
- `subtotal` - Subtotal
- `tax_amount` - Monto de IVA
- `total` - Total
- `notes` - Comentarios
- `created_by_name` - Nombre del asesor

### Cliente
- `nombre` - Nombre del cliente
- `empresa` - Empresa del cliente
- `contacto` - Persona de contacto
- `email` - Correo electrónico
- `telefono` - Teléfono

### Items de Cotización
- `item_number` - Número del item
- `description` - Descripción del producto/servicio
- `part_number` - Número de parte
- `quantity` - Cantidad
- `unit_price` - Precio unitario
- `subtotal` - Subtotal del item
- `delivery_time` - Tiempo de entrega

## Librerías Utilizadas

### Frontend
- **Bootstrap 5.3.2** - Framework CSS
- **Bootstrap Icons 1.11.1** - Iconos
- **jsPDF 2.5.1** - Generación de PDF
- **html2canvas 1.4.1** - Conversión HTML a Canvas

### Backend
- **CodeIgniter 3** - Framework PHP
- **MySQL** - Base de datos

## Optimizaciones

### Tamaño de Archivo
- Escala reducida a 1.5x (antes 2x)
- Compresión JPEG al 70% de calidad
- Compresión PDF habilitada
- Limpieza de contenedores temporales

### Rendimiento
- Logs deshabilitados en html2canvas
- Procesamiento asíncrono
- Indicadores de carga en la interfaz

## Personalización

### Colores de la Empresa
Los colores principales están definidos en CSS:
- **Primario**: #FEC422 (Amarillo)
- **Secundario**: #1D1D1B (Negro)
- **Fondo**: #FFFFFF (Blanco)

### Logo
El logo se carga desde: `assets/images/logos/logorepase.png`

### Información de Contacto
Los datos de contacto están hardcodeados en el template:
- Teléfonos: (777) 365-33-36, (777) 244-81-30
- WhatsApp: (777) 30-40-571
- Sitio web: www.repase.mx

## Solución de Problemas

### Error: "jsPDF no está disponible"
- Verificar que la librería se cargue correctamente
- Revisar la conexión a internet
- Verificar la consola del navegador

### Error: "html2canvas no está disponible"
- Verificar que la librería se cargue correctamente
- Revisar la conexión a internet
- Verificar la consola del navegador

### PDF no se genera
- Verificar que la cotización existe
- Verificar que el cliente existe
- Revisar los logs de error de PHP

### Imagen del logo no aparece
- Verificar que el archivo existe en `assets/images/logos/logorepase.png`
- Verificar permisos de lectura del archivo

## Próximas Mejoras

- [ ] Plantillas personalizables por cliente
- [ ] Múltiples formatos de PDF (A4, Letter, etc.)
- [ ] Envío automático por email
- [ ] Firma digital
- [ ] Códigos QR para validación
- [ ] Historial de versiones del PDF
