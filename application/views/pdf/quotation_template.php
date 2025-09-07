<?php
// Función para formatear números de teléfono
function format_phone_number($phone) {
    // Si está vacío, usar número por defecto
    if (empty($phone)) {
        return '(777) 30-40-571';
    }
    
    // Elimina todo excepto números
    $digits = preg_replace('/\D/', '', $phone);
    
    // Si tiene exactamente 10 dígitos, formatear
    if (strlen($digits) === 10) {
        $area = substr($digits, 0, 3);
        $first = substr($digits, 3, 2);
        $second = substr($digits, 5, 2);
        $third = substr($digits, 7, 3);
        return "($area) $first-$second-$third";
    }
    
    // Si no es de 10 dígitos, regresa el original o el por defecto
    return !empty($phone) ? $phone : '(777) 30-40-571';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $page_title; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <style>
    body {
      background-color: #1D1D1B;
    }
    .invoice {
      background: #FFFFFF;
      padding: 40px;
      margin: 50px auto;
      max-width: 900px;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(29, 29, 27, 0.3);
    }
    .invoice-header {
      border-bottom: 2px solid #FEC422;
      margin-bottom: 20px;
      padding-bottom: 10px;
    }
    .invoice-footer {
      text-align: center;
      font-size: 0.9rem;
      color: #1D1D1B;
      margin-top: 40px;
      border-top: 2px solid #FEC422;
      padding-top: 15px;
    }
    .btn-action {
      margin-right: 10px;
    }
    .text-primary {
      color: #FEC422 !important;
    }
    .text-secondary {
      color: #1D1D1B !important;
    }
    .table-primary {
      background-color: #FEC422 !important;
      color: #1D1D1B !important;
    }
    .table-primary th {
      background-color: #FEC422 !important;
      color: #1D1D1B !important;
      border-color: #1D1D1B !important;
    }
    .table-success {
      background-color: #FEC422 !important;
      color: #1D1D1B !important;
    }
    .table-success th {
      background-color: #FEC422 !important;
      color: #1D1D1B !important;
      border-color: #1D1D1B !important;
    }
    .btn-primary {
      background-color: #FEC422 !important;
      border-color: #FEC422 !important;
      color: #1D1D1B !important;
    }
    .btn-primary:hover {
      background-color: #e6b01e !important;
      border-color: #e6b01e !important;
      color: #1D1D1B !important;
    }
    .btn-success {
      background-color: #1D1D1B !important;
      border-color: #1D1D1B !important;
      color: #FFFFFF !important;
    }
    .btn-success:hover {
      background-color: #2a2a28 !important;
      border-color: #2a2a28 !important;
      color: #FFFFFF !important;
    }
    h2, h4, h5 {
      color: #1D1D1B;
    }
    p, td, th {
      color: #1D1D1B;
    }
    .table {
      color: #1D1D1B;
    }
    .table th {
      color: #1D1D1B;
    }
    .table td {
      color: #1D1D1B;
    }
    .no-print {
      display: block;
    }
    @media print {
      .no-print {
        display: none !important;
      }
      body {
        background: white !important;
        margin: 0 !important;
        padding: 0 !important;
      }
      .invoice {
        box-shadow: none !important;
        border-radius: 0 !important;
        margin: 0 !important;
        padding: 20px !important;
      }
    }
  </style>
</head>
<body>
  <!-- Botones -->
  <div class="d-flex justify-content-center mb-4 no-print" style="margin-top: 30px;">
    <div class="btn-group" role="group" aria-label="Acciones PDF/Impresión">
      <button class="btn btn-primary btn-action" style="font-size:1.1em; padding: 0.75em 2em; border-radius: 0 8px 8px 0;" onclick="generarPDF()">
        <i class="bi bi-download me-2"></i>Descargar PDF
      </button>
    </div>
  </div>

<div class="invoice" id="invoice">
  <!-- Encabezado -->
  <div class="row invoice-header align-items-center">
    <div class="col-md-6">
      <img src="<?php echo base_url('assets/images/logos/logorepase.png'); ?>" alt="Logo de la Empresa" style="max-height: 100px;">
    </div>
    <div class="col-md-6 text-md-end" style="display: flex; flex-direction: column; align-items: flex-end; justify-content: center; height: 100%;">
      <div style="display: flex; align-items: flex-start; gap: 10px; margin-bottom: 8px;">
        <i class="bi bi-telephone-fill" style="font-size: 2em; color: #1D1D1B;"></i>
        <div style="text-align: left;">
          <div style="font-size: 1.1em; color: #1D1D1B;">(777) 365-33-36</div>
          <div style="font-size: 1.1em; color: #1D1D1B;">(777) 244-81-30</div>
        </div>
      </div>
      <div style="display: flex; align-items: center; gap: 10px;">
        <a href="https://www.repase.mx" target="_blank" title="Ir al sitio web">
          <i class="bi bi-globe2" style="font-size: 2em; color: #1D1D1B;"></i>
        </a>
        <span style="font-size: 1.1em; color: #1D1D1B; font-weight: 500;">WWW.REPASE.MX</span>
      </div>
    </div>
  </div>

  <!-- Cliente y Vendedor -->
  <div class="row mb-4">
    <div class="col-md-6">
      <h5>Cliente:</h5>
      <p style="font-family: 'Century Gothic', Arial, sans-serif;">
        <strong>Fecha:</strong> <?php echo date('d/m/Y', strtotime($quotation->quotation_date)); ?><br>
        <strong>Empresa:</strong> <?php echo $client->empresa; ?><br>
        <strong>Contacto:</strong> <?php echo $client->contacto; ?><br>
        <strong>Correo:</strong> <?php echo $client->email; ?>
      </p>
    </div>
    <div class="col-md-6 text-md-end">   
      <p style="font-family: 'Century Gothic', Arial, sans-serif;">
        <strong>Cotización:</strong> <?php echo $quotation->quotation_number; ?><br>
        <strong>Asesor:</strong> <?php echo $quotation->created_by_name; ?><br>
        <strong>Tel Asesor:</strong> <i class="bi bi-whatsapp" style="color: #25D366; font-size: 1.3em; vertical-align: middle;"></i>
        <span style="vertical-align: middle;"><?php echo format_phone_number($advisor->phone ?? ''); ?></span><br>
      </p>      
    </div>
  </div>
    
  <!-- Tabla de productos/servicios -->
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead class="table-primary">
        <tr>
          <th>#</th>
          <th>DESCRIPCION</th>
          <th>NP</th>
          <th class="text-end">QTY</th>
          <th class="text-end">P UNITARIO</th>
          <th class="text-end">Subtotal</th>
          <th class="text-end">T. ENTREGA</th>
        </tr>
      </thead>
      <tbody>
        <?php if(isset($items) && !empty($items)): ?>
          <?php foreach($items as $item): ?>
            <tr>
              <td><?php echo $item->item_number; ?></td>
              <td><?php echo $item->description; ?></td>
              <td><?php echo $item->part_number; ?></td>
              <td class="text-end"><?php echo $item->quantity; ?></td>
              <td class="text-end">$<?php echo number_format($item->unit_price, 2); ?></td>
              <td class="text-end">$<?php echo number_format($item->subtotal, 2); ?></td>
              <td class="text-end"><?php echo $item->delivery_time; ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" class="text-center">No hay items en esta cotización</td>
          </tr>
        <?php endif; ?>
      </tbody>
      <tfoot>
        <tr>
          <th class="text-end"></th>
          <th class="text-end"></th>
          <th colspan="4" class="text-end">Subtotal</th>
          <th class="text-end">$<?php echo number_format($quotation->subtotal, 2); ?></th>
        </tr>
        <tr>
          <th class="text-end"></th>
          <th class="text-end"></th>
          <th colspan="4" class="text-end">IVA (<?php echo $quotation->tax_rate; ?>%)</th>
          <th class="text-end">$<?php echo number_format($quotation->tax_amount, 2); ?></th>
        </tr>
        <tr class="table-success">
          <th class="text-end"></th>
          <th class="text-end"></th>
          <th colspan="4" class="text-end">Total</th>
          <th class="text-end">$<?php echo number_format($quotation->total, 2); ?></th>
        </tr>
      </tfoot>
    </table>
  </div>

  <!-- Notas -->
  <div class="row mt-4">
    <div class="col-12">
      <div class="row">
        <!-- Datos de la cotización -->
        <div class="col-md-7">
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <tbody>
                <tr></tr>
                <tr>
                  <td style="font-weight:bold; letter-spacing:2px; color:#1D1D1B; font-size:0.95em;">Marca</td>
                  <td>EXAMPLE</td>
                </tr>
                <tr>
                  <td style="font-weight:bold; letter-spacing:2px; color:#1D1D1B; font-size:0.95em;">Moneda</td>
                  <td style="color:#1D1D1B; font-size:0.95em;"><?php echo $quotation->currency; ?></td>
                </tr>
                <tr>
                  <td style="font-weight:bold; letter-spacing:2px; color:#1D1D1B; font-size:0.95em;">LAB</td>
                  <td style="color:#1D1D1B; font-size:0.95em;"><?php echo $quotation->delivery_location; ?></td>
                </tr>
                <tr>
                  <td style="font-weight:bold; letter-spacing:2px; color:#1D1D1B; font-size:0.95em;">Forma de pago</td>
                  <td style="color:#1D1D1B; font-size:0.95em;"><?php echo $quotation->payment_terms; ?></td>
                </tr>               
              </tbody>
            </table>
          </div>
        </div>
        <!-- Cuadro de comentarios a la derecha -->
        <div class="col-md-5">
          <div style="border: 2px solid #FEC422; border-radius: 10px; padding: 18px 20px; background: #fffbe6; min-height: 180px;">
            <h6 style="font-weight:bold; color:#1D1D1B; letter-spacing:1px; margin-bottom:10px;">Comentarios</h6>
            <p style="color:#1D1D1B; font-size:0.97em; margin-bottom:0;">
              <?php echo $quotation->notes ? $quotation->notes : 'Sin comentarios adicionales'; ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Segunda página - Condiciones de la cotización -->
<div class="invoice" id="pagina-condiciones" style="page-break-before: always; margin-top: 0;">
  <!-- Encabezado de la segunda página -->
  <div class="row invoice-header align-items-center">
    <div class="col-md-12 text-center">
      <h4 style="color: #1D1D1B;">CONDICIONES DE LA COTIZACIÓN PRESENTADA</h4>
    </div>
  </div>

  <!-- Información de la empresa -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="text-center">
        <h4 style="color: #1D1D1B; margin-bottom: 10px;">Refacciones partes y servicios para grúas industriales S.A de C.V</h4>
        <h4 style="color: #1D1D1B; margin-bottom: 10px;">Comercializadora RGI S.A de C.V</h4>
        <h4 style="color: #1D1D1B; margin-bottom: 10px;">REPASE NO tiene más Razones sociales de las mencionadas</h4>
      </div>
    </div>
  </div>

  <!-- Condiciones principales -->
  <div class="row mb-4">
    <div class="col-12">
      <h6 style="color: #1D1D1B; font-weight: bold; margin-bottom: 15px; border-bottom: 2px solid #FEC422; padding-bottom: 5px;">CONDICIONES GENERALES:</h6>
      
      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td style="width: 30px; vertical-align: top; font-weight: bold; color: #1D1D1B;">A.</td>
                  <td style="color: #1D1D1B; font-size: 0.9em;">
                    Los precios están basados en las cantidades solicitadas. Cualquier cambio en las cantidades requerirá revisión de la oferta. 
                    Para embarques consolidados se requiere pago por adelantado.
                  </td>
                </tr>
                <tr>
                  <td style="width: 30px; vertical-align: top; font-weight: bold; color: #1D1D1B;">B.</td>
                  <td style="color: #1D1D1B; font-size: 0.9em;">
                    Los artículos de importación son NO CANCELABLES y NO DEVOLUBLES, excepto cuando se requiera autorización expresa de GRUPO REPASE.
                  </td>
                </tr>
                <tr>
                  <td style="width: 30px; vertical-align: top; font-weight: bold; color: #1D1D1B;">C.</td>
                  <td style="color: #1D1D1B; font-size: 0.9em;">
                    "LAB" significa que los gastos de transporte corren por cuenta del comprador desde el punto de embarque o destino.
                  </td>
                </tr>
                <tr>
                  <td style="width: 30px; vertical-align: top; font-weight: bold; color: #1D1D1B;">D.</td>
                  <td style="color: #1D1D1B; font-size: 0.9em;">
                    No se aceptan pedidos menores a $100.00 USD o su equivalente en moneda nacional.
                  </td>
                </tr>
                <tr>
                  <td style="width: 30px; vertical-align: top; font-weight: bold; color: #1D1D1B;">E.</td>
                  <td style="color: #1D1D1B; font-size: 0.9em;">
                    Verificar medidas y características del producto para evitar problemas de instalación.
                  </td>
                </tr>
                <tr>
                  <td style="width: 30px; vertical-align: top; font-weight: bold; color: #1D1D1B;">F.</td>
                  <td style="color: #1D1D1B; font-size: 0.9em;">
                    Los tiempos de entrega son aproximados y la disponibilidad del producto puede variar según cantidades y ventas previas.
                  </td>
                </tr>
                <tr>
                  <td style="width: 30px; vertical-align: top; font-weight: bold; color: #1D1D1B;">G.</td>
                  <td style="color: #1D1D1B; font-size: 0.9em;">
                    Si el pago es en moneda nacional y la cotización está en dólares americanos, utilizar el tipo de cambio interbancario 
                    disponible en <a href="https://www.banxico.org.mx/tipcamb/main.do?page=tip&idioma=sp" target="_blank" style="color: #0082fb;">https://www.banxico.org.mx/tipcamb/main.do?page=tip&idioma=sp</a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Marcas disponibles -->
  <div class="row mb-4">
    <div class="col-12">
      <h6 style="color: #1D1D1B; font-weight: bold; margin-bottom: 15px; border-bottom: 2px solid #FEC422; padding-bottom: 5px;">MARCAS Y PRODUCTOS:</h6>
      
      <div class="row">
        <div class="col-md-6">
          <ul style="color: #1D1D1B; font-size: 0.9em; columns: 2; column-gap: 20px;">
            <li>LINK BELT</li>
            <li>TEREX</li>
            <li>CLARK</li>
            <li>NATIONAL</li>
            <li>ZF</li>
            <li>CARRARO</li>
            <li>TADANO</li>
            <li>P&H</li>
            <li>KALMAR</li>
            <li>BRODERSON</li>
          </ul>
        </div>
        <div class="col-md-6">
          <ul style="color: #1D1D1B; font-size: 0.9em; columns: 2; column-gap: 20px;">
            <li>DEMAG</li>
            <li>SISTEMAS DE SEGURIDAD</li>
            <li>TRANSMISIONES</li>
            <li>MANITOWOC</li>
            <li>KONECRANES</li>
            <li>PETTIBONE</li>
            <li>YALE</li>
            <li>TWIN DISC</li>
            <li>WABCO</li>
            <li>AMERICAN</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Información adicional -->
  <div class="row mb-4">
    <div class="col-12">
      <div style="background-color: #fffbe6; border: 2px solid #FEC422; border-radius: 10px; padding: 20px;">
        <h6 style="color: #1D1D1B; font-weight: bold; margin-bottom: 15px; text-align: center;">INFORMACIÓN IMPORTANTE</h6>
        <div class="row">
          <div class="col-md-6">
            <p style="color: #1D1D1B; font-size: 0.9em; margin-bottom: 8px;">
              <strong>•</strong> Todos los precios están sujetos a cambio sin previo aviso.
            </p>
            <p style="color: #1D1D1B; font-size: 0.9em; margin-bottom: 8px;">
              <strong>•</strong> La cotización es válida por <?php echo $quotation->validity_days; ?> días hábiles.
            </p>
            <p style="color: #1D1D1B; font-size: 0.9em; margin-bottom: 8px;">
              <strong>•</strong> Los términos de pago se establecen al momento de la orden.
            </p>
          </div>
          <div class="col-md-6">
            <p style="color: #1D1D1B; font-size: 0.9em; margin-bottom: 8px;">
              <strong>•</strong> Garantía según especificaciones del fabricante.
            </p>
            <p style="color: #1D1D1B; font-size: 0.9em; margin-bottom: 8px;">
              <strong>•</strong> Certificados de calidad disponibles bajo solicitud.
            </p>
            <p style="color: #1D1D1B; font-size: 0.9em; margin-bottom: 0;">
              <strong>•</strong> Sin número de parte no hay cambios ni garantías.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pie de página de la segunda página -->
  <div class="invoice-footer">
    <p style="font-size: 0.8em; color: #666;">Para más información, contacte a nuestro departamento de ventas</p>
  </div>
</div>

<script>
// Función para generar PDF usando jsPDF
async function generarPDF() {
  try {
    // Mostrar indicador de carga en el botón
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Generando PDF...';
    button.disabled = true;

    // Obtener ambos elementos
    const cotizacion = document.getElementById('invoice');
    const paginaCondiciones = document.getElementById('pagina-condiciones');
    
    // Configuración para html2canvas - Optimizada para menor tamaño
    const canvas1 = await html2canvas(cotizacion, {
      scale: 1.5,
      useCORS: true,
      allowTaint: true,
      backgroundColor: '#ffffff',
      width: cotizacion.offsetWidth,
      height: cotizacion.offsetHeight,
      scrollX: 0,
      scrollY: 0,
      logging: false,
      removeContainer: true
    });

    const canvas2 = await html2canvas(paginaCondiciones, {
      scale: 1.5,
      useCORS: true,
      allowTaint: true,
      backgroundColor: '#ffffff',
      width: paginaCondiciones.offsetWidth,
      height: paginaCondiciones.offsetHeight,
      scrollX: 0,
      scrollY: 0,
      logging: false,
      removeContainer: true
    });

    // Convertir canvas a imagen con compresión JPEG para menor tamaño
    const imgData1 = canvas1.toDataURL('image/jpeg', 0.7);
    const imgData2 = canvas2.toDataURL('image/jpeg', 0.7);

    // Crear nuevo documento PDF con compresión
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF({
      orientation: 'portrait',
      unit: 'mm',
      format: 'a4',
      compress: true
    });
    
    // Obtener dimensiones del PDF
    const pdfWidth = pdf.internal.pageSize.getWidth();
    const pdfHeight = pdf.internal.pageSize.getHeight();
    
    // Calcular dimensiones de las imágenes
    const imgWidth1 = pdfWidth;
    const imgHeight1 = (canvas1.height * imgWidth1) / canvas1.width;

    const imgWidth2 = pdfWidth;
    const imgHeight2 = (canvas2.height * imgWidth2) / canvas2.width;

    // Agregar primera página
    if (imgHeight1 <= pdfHeight) {
      pdf.addImage(imgData1, 'JPEG', 0, 0, imgWidth1, imgHeight1);
    } else {
      let heightLeft = imgHeight1;
      let position = 0;

      pdf.addImage(imgData1, 'JPEG', 0, position, imgWidth1, imgHeight1);
      heightLeft -= pdfHeight;

      while (heightLeft >= pdfHeight) {
        position -= pdfHeight;
        pdf.addPage();
        pdf.addImage(imgData1, 'JPEG', 0, position, imgWidth1, imgHeight1);
        heightLeft -= pdfHeight;
      }

      if (heightLeft > 0) {
        position -= pdfHeight;
        pdf.addPage();
        pdf.addImage(imgData1, 'JPEG', 0, position, imgWidth1, imgHeight1);
      }
    }

    // Agregar segunda página (condiciones)
    pdf.addPage();
    if (imgHeight2 <= pdfHeight) {
      pdf.addImage(imgData2, 'JPEG', 0, 0, imgWidth2, imgHeight2);
    } else {
      let heightLeft = imgHeight2;
      let position = 0;

      pdf.addImage(imgData2, 'JPEG', 0, position, imgWidth2, imgHeight2);
      heightLeft -= pdfHeight;

      while (heightLeft >= pdfHeight) {
        position -= pdfHeight;
        pdf.addPage();
        pdf.addImage(imgData2, 'JPEG', 0, position, imgWidth2, imgHeight2);
        heightLeft -= pdfHeight;
      }

      if (heightLeft > 0) {
        position -= pdfHeight;
        pdf.addPage();
        pdf.addImage(imgData2, 'JPEG', 0, position, imgWidth2, imgHeight2);
      }
    }

    // Generar nombre del archivo con fecha
    const fecha = new Date();
    const dia = fecha.getDate().toString().padStart(2, '0');
    const mes = fecha.getMonth() + 1;
    const año = fecha.getFullYear();
    const nombreArchivo = `cotizacion_<?php echo $quotation->quotation_number; ?>_${dia}-${mes}-${año}.pdf`;

    // Descargar el PDF
    pdf.save(nombreArchivo);

    // Restaurar el botón
    button.innerHTML = originalText;
    button.disabled = false;

    // Mostrar mensaje de éxito
    mostrarNotificacion('PDF generado exitosamente', 'success');

  } catch (error) {
    console.error('Error al generar PDF:', error);
    
    // Restaurar el botón en caso de error
    const button = event.target;
    button.innerHTML = originalText;
    button.disabled = false;
    
    // Mostrar mensaje de error
    mostrarNotificacion('Error al generar PDF: ' + error.message, 'error');
  }
}

// Función para mostrar notificaciones
function mostrarNotificacion(mensaje, tipo) {
  const notificacion = document.createElement('div');
  notificacion.className = `alert alert-${tipo === 'success' ? 'success' : 'danger'} position-fixed`;
  notificacion.style.cssText = `
    top: 20px; 
    right: 20px; 
    z-index: 9999; 
    min-width: 300px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    border: none;
    border-radius: 8px;
  `;
  
  const icono = tipo === 'success' ? 'check-circle' : 'exclamation-circle';
  const color = tipo === 'success' ? '#28a745' : '#dc3545';
  
  notificacion.innerHTML = `
    <div style="display: flex; align-items: center; gap: 10px;">
      <i class="bi bi-${icono}" style="color: ${color}; font-size: 1.2em;"></i>
      <span>${mensaje}</span>
      <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
    </div>
  `;
  
  document.body.appendChild(notificacion);
  
  setTimeout(() => {
    if (notificacion.parentElement) {
      notificacion.remove();
    }
  }, 5000);
}

// Verificar que las librerías estén cargadas
document.addEventListener('DOMContentLoaded', function() {
  if (typeof window.jspdf === 'undefined') {
    console.error('jsPDF no está cargado');
    mostrarNotificacion('Error: jsPDF no está disponible', 'error');
  }
  
  if (typeof html2canvas === 'undefined') {
    console.error('html2canvas no está cargado');
    mostrarNotificacion('Error: html2canvas no está disponible', 'error');
  }
});
</script>

</body>
</html>
