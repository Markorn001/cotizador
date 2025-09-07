<?php
// Configuración del layout
$page_title = isset($title) ? $title : 'Crear Cotización';
$page_type = 'forms';
$active_menu = 'cotizaciones';
$page_header = isset($title) ? $title : 'Crear Cotización';
$page_subtitle = 'Crear una nueva cotización';
$page_icon = 'fas fa-plus';

// CSS adicional específico para esta página
$additional_css = ['utilities.css'];

// Iniciar el buffer de salida
ob_start();
?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-plus me-2"></i>Crear Nueva Cotización
                </h5>
            </div>
            <div class="card-body">
                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <?php echo $this->session->flashdata('error'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php echo form_open('cotizaciones/create', ['id' => 'createQuotationForm']); ?>
                    
                    <!-- Información del Cliente -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary border-bottom pb-2">
                                <i class="fas fa-user me-2"></i>Información del Cliente
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select <?php echo (form_error('client_id')) ? 'is-invalid' : ''; ?>" 
                                        id="client_id" 
                                        name="client_id" 
                                        required>
                                    <option value="">Seleccionar Cliente</option>
                                    <?php foreach($clients as $client): ?>
                                        <option value="<?php echo $client->id; ?>" 
                                                <?php echo set_select('client_id', $client->id); ?>>
                                            <?php echo $client->nombre; ?>
                                            <?php if($client->empresa): ?>
                                                - <?php echo $client->empresa; ?>
                                            <?php endif; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="client_id">
                                    <i class="fas fa-user me-2"></i>Cliente *
                                </label>
                                <?php if(form_error('client_id')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('client_id'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="date" 
                                       class="form-control <?php echo (form_error('quotation_date')) ? 'is-invalid' : ''; ?>" 
                                       id="quotation_date" 
                                       name="quotation_date" 
                                       value="<?php echo set_value('quotation_date', date('Y-m-d')); ?>" 
                                       required>
                                <label for="quotation_date">
                                    <i class="fas fa-calendar me-2"></i>Fecha de Cotización *
                                </label>
                                <?php if(form_error('quotation_date')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('quotation_date'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Configuración de la Cotización -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary border-bottom pb-2">
                                <i class="fas fa-cog me-2"></i>Configuración de la Cotización
                            </h6>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating mb-3">
                                <input type="number" 
                                       class="form-control <?php echo (form_error('validity_days')) ? 'is-invalid' : ''; ?>" 
                                       id="validity_days" 
                                       name="validity_days" 
                                       value="<?php echo set_value('validity_days', 10); ?>" 
                                       min="1" 
                                       max="365" 
                                       required>
                                <label for="validity_days">
                                    <i class="fas fa-clock me-2"></i>Días de Vigencia *
                                </label>
                                <?php if(form_error('validity_days')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('validity_days'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating mb-3">
                                <select class="form-select <?php echo (form_error('currency')) ? 'is-invalid' : ''; ?>" 
                                        id="currency" 
                                        name="currency" 
                                        required>
                                    <option value="MXN" <?php echo set_select('currency', 'MXN'); ?>>MXN - Peso Mexicano</option>
                                    <option value="USD" <?php echo set_select('currency', 'USD'); ?>>USD - Dólar Estadounidense</option>
                                    <option value="EUR" <?php echo set_select('currency', 'EUR'); ?>>EUR - Euro</option>
                                </select>
                                <label for="currency">
                                    <i class="fas fa-money-bill me-2"></i>Moneda *
                                </label>
                                <?php if(form_error('currency')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('currency'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating mb-3">
                                <select class="form-select <?php echo (form_error('payment_terms')) ? 'is-invalid' : ''; ?>" 
                                        id="payment_terms" 
                                        name="payment_terms" 
                                        required>
                                    <option value="CREDITO" <?php echo set_select('payment_terms', 'CREDITO'); ?>>CREDITO</option>
                                    <option value="CONTADO" <?php echo set_select('payment_terms', 'CONTADO'); ?>>CONTADO</option>
                                    <option value="30 DIAS" <?php echo set_select('payment_terms', '30 DIAS'); ?>>30 DÍAS</option>
                                    <option value="60 DIAS" <?php echo set_select('payment_terms', '60 DIAS'); ?>>60 DÍAS</option>
                                    <option value="50% anticipo 50% aviso contra entrega" <?php echo set_select('payment_terms', '50% anticipo 50%aviso contra entrega'); ?>>50% anticipo 50%aviso contra entrega</option>
                                    <option value="por cordinar" <?php echo set_select('payment_terms', 'por cordinar'); ?>>por cordinar</option>
                                </select>
                                <label for="payment_terms">
                                    <i class="fas fa-credit-card me-2"></i>Condiciones de Pago *
                                </label>
                                <?php if(form_error('payment_terms')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('payment_terms'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating mb-3">
                                <input type="text" 
                                       class="form-control <?php echo (form_error('delivery_location')) ? 'is-invalid' : ''; ?>" 
                                       id="delivery_location" 
                                       name="delivery_location" 
                                       value="<?php echo set_value('delivery_location', 'SUS INSTALACIONES'); ?>" 
                                       required>
                                <label for="delivery_location">
                                    <i class="fas fa-map-marker-alt me-2"></i>Lugar de Entrega *
                                </label>
                                <?php if(form_error('delivery_location')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('delivery_location'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Tasa de Impuesto -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="form-floating mb-3">
                                <input type="number" 
                                       class="form-control <?php echo (form_error('tax_rate')) ? 'is-invalid' : ''; ?>" 
                                       id="tax_rate" 
                                       name="tax_rate" 
                                       value="<?php echo set_value('tax_rate', 16.00); ?>" 
                                       step="0.01" 
                                       min="0" 
                                       max="100" 
                                       required>
                                <label for="tax_rate">
                                    <i class="fas fa-percentage me-2"></i>Tasa de Impuesto (%) *
                                </label>
                                <?php if(form_error('tax_rate')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('tax_rate'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Items de la Cotización -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary border-bottom pb-2">
                                <i class="fas fa-list me-2"></i>Items de la Cotización
                            </h6>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="itemsTable">
                                    <thead class="table-primary">
                                        <tr>
                                            <th width="5%" class="text-center">#</th>
                                            <th width="30%">Descripción *</th>
                                            <th width="12%">Número de Parte</th>
                                            <th width="8%" class="text-center">Cantidad *</th>
                                            <th width="12%" class="text-end">Precio Unitario *</th>
                                            <th width="10%" class="text-end">Subtotal</th>
                                            <th width="13%">Tiempo de Entrega</th>
                                            <th width="10%" class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsTableBody">
                                        <!-- Los items se agregarán dinámicamente aquí -->
                                    </tbody>
                                </table>
                            </div>
                                                         <div class="text-center mt-3">
                                 <button type="button" class="btn btn-success" id="addItemBtn">
                                     <i class="fas fa-plus me-2"></i>Agregar Item
                                 </button>
                             </div>
                        </div>
                    </div>

                    <!-- Totales -->
                    <div class="row mb-4">
                        <div class="col-md-6 offset-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-8 text-end">
                                            <strong>Subtotal:</strong>
                                        </div>
                                        <div class="col-4 text-end">
                                            <span id="subtotalDisplay">$0.00</span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-8 text-end">
                                            <strong>IVA (<span id="taxRateDisplay">16</span>%):</strong>
                                        </div>
                                        <div class="col-4 text-end">
                                            <span id="taxAmountDisplay">$0.00</span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-8 text-end">
                                            <strong>Total:</strong>
                                        </div>
                                        <div class="col-4 text-end">
                                            <span id="totalDisplay" class="h5 text-primary">$0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notas -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <textarea class="form-control" 
                                          id="notes" 
                                          name="notes" 
                                          placeholder="Notas adicionales" 
                                          style="height: 100px"><?php echo set_value('notes'); ?></textarea>
                                <label for="notes">
                                    <i class="fas fa-sticky-note me-2"></i>Notas Adicionales
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="<?php echo base_url('cotizaciones'); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Volver
                        </a>
                        
                        <div>
                            <button type="reset" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-undo me-2"></i>Restablecer
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Crear Cotización
                            </button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>


<!-- Estilos personalizados para la tabla de items -->
<style>
.item-row:hover {
    background-color: #f8f9fa !important;
}

.item-description,
.item-part-number {
    resize: vertical;
    min-height: 60px;
}

.item-quantity {
    font-weight: bold;
}

.item-unit-price {
    font-weight: bold;
}

.item-subtotal {
    font-size: 1.1em;
}

#itemsTable th {
    font-weight: 600;
    font-size: 0.9em;
}

#itemsTable td {
    vertical-align: middle;
    padding: 8px;
}

.form-control-sm {
    font-size: 0.875rem;
}

.input-group-sm .input-group-text {
    font-size: 0.875rem;
    padding: 0.25rem 0.5rem;
}

</style>

<!-- JavaScript para la funcionalidad de items -->
<script>
let itemCounter = 0;
let items = [];

// Función para inicializar el formulario
function initializeQuotationForm() {
    console.log('Inicializando formulario de cotización...');
    
    // Verificar que jQuery esté funcionando
    if (typeof jQuery === 'undefined') {
        console.error('jQuery no está disponible en initializeQuotationForm');
        return;
    }
    
    // Verificar que jQuery esté completamente cargado
    if (typeof jQuery.fn === 'undefined' || typeof jQuery.fn.jquery === 'undefined') {
        console.error('jQuery no está completamente cargado');
        return;
    }
    
    console.log('jQuery está funcionando correctamente, versión:', jQuery.fn.jquery);
    
    // Agregar primer item por defecto
    addItem();
    
    // Event listeners
    const addItemBtn = jQuery('#addItemBtn');
    console.log('Botón Agregar Item encontrado:', addItemBtn.length > 0);
    
    if (addItemBtn.length > 0) {
        addItemBtn.on('click', function() {
            console.log('Botón Agregar Item clickeado');
            addItem();
        });
    } else {
        console.error('Botón Agregar Item NO encontrado!');
    }
    
    jQuery('#tax_rate').on('input', calculateTotals);
    
    // Prevenir envío del formulario con Enter
    jQuery('#createQuotationForm').on('keypress', function(e) {
        if (e.which === 13) { // 13 es el código de Enter
            e.preventDefault();
            return false;
        }
    });
    
    // Prevenir envío del formulario con Enter en todos los inputs
    jQuery('#createQuotationForm input, #createQuotationForm textarea, #createQuotationForm select').on('keypress', function(e) {
        if (e.which === 13) { // 13 es el código de Enter
            e.preventDefault();
            return false;
        }
    });
    
    // Validación del formulario
    jQuery('#createQuotationForm').submit(function(e) {
        if (items.length === 0) {
            e.preventDefault();
            alert('Debes agregar al menos un item a la cotización');
            return false;
        }
        
        // Validar que todos los campos requeridos estén llenos
        let valid = true;
        items.forEach(function(item, index) {
            if (!item.description || !item.quantity || !item.unit_price) {
                valid = false;
                alert('Por favor completa todos los campos requeridos del item ' + (index + 1));
                return false;
            }
        });
        
        if (!valid) {
            e.preventDefault();
            return false;
        }
        
        // Crear campos ocultos para enviar los items
        createHiddenFields();
    });
    
    console.log('Formulario inicializado correctamente');
}

// Función para verificar y cargar jQuery si es necesario
function ensureJQuery() {
    if (typeof jQuery === 'undefined') {
        console.log('jQuery no está disponible, intentando cargar desde CDN...');
        
        // Crear script tag para jQuery
        const script = document.createElement('script');
        script.src = 'https://code.jquery.com/jquery-3.7.1.min.js';
        script.integrity = 'sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=';
        script.crossOrigin = 'anonymous';
        
        script.onload = function() {
            console.log('jQuery cargado exitosamente desde CDN');
            initializeAfterJQuery();
        };
        
        script.onerror = function() {
            console.error('Error cargando jQuery desde CDN');
            alert('Error: No se pudo cargar jQuery. Por favor verifica tu conexión a internet y recarga la página.');
        };
        
        document.head.appendChild(script);
    } else {
        console.log('jQuery ya está disponible, versión:', jQuery.fn.jquery);
        initializeAfterJQuery();
    }
}

// Función para inicializar después de que jQuery esté disponible
function initializeAfterJQuery() {
    // Esperar a que jQuery esté disponible y el DOM esté listo
    jQuery(document).ready(function() {
        console.log('jQuery está listo, inicializando formulario...');
        console.log('jQuery version:', jQuery.fn.jquery);
        initializeQuotationForm();
    });
}

// Iniciar el proceso
ensureJQuery();

function addItem() {
    console.log('Función addItem ejecutada');
    itemCounter++;
    const item = {
        id: itemCounter,
        description: '',
        part_number: '',
        quantity: 1,
        unit_price: 0,
        delivery_time: '',
        subtotal: 0
    };
    
    console.log('Item creado:', item);
    items.push(item);
    console.log('Items totales:', items.length);
    
    renderItems();
    updateItemNumbers();
}

function removeItem(itemId) {
    if (items.length <= 1) {
        alert('Debe haber al menos un item en la cotización');
        return;
    }
    
    items = items.filter(item => item.id !== itemId);
    renderItems();
    updateItemNumbers();
    calculateTotals();
}

function renderItems() {
    console.log('Función renderItems ejecutada');
    const tbody = jQuery('#itemsTableBody');
    console.log('Tbody encontrado:', tbody.length > 0);
    
    tbody.empty();
    
    items.forEach(function(item) {
        const row = `
            <tr data-item-id="${item.id}" class="item-row">
                <td class="text-center align-middle">
                    <span class="badge bg-primary">${item.item_number}</span>
                </td>
                <td>
                    <textarea class="form-control form-control-sm item-description" 
                              rows="2" 
                              placeholder="Descripción detallada del producto/servicio"
                              onchange="updateItem(${item.id}, 'description', this.value)"
                              required>${item.description}</textarea>
                </td>
                <td>
                    <textarea class="form-control form-control-sm item-part-number" 
                              rows="2" 
                              placeholder="Código/SKU o número de parte"
                              onchange="updateItem(${item.id}, 'part_number', this.value)">${item.part_number}</textarea>
                </td>
                <td class="text-center">
                    <input type="number" 
                           class="form-control form-control-sm text-center item-quantity" 
                           value="${item.quantity}" 
                           min="1" 
                           step="1"
                           onchange="updateItem(${item.id}, 'quantity', parseInt(this.value))"
                           required>
                </td>
                <td>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">$</span>
                        <input type="number" 
                               class="form-control text-end item-unit-price" 
                               value="${item.unit_price}" 
                               min="0" 
                               step="0.01"
                               onchange="updateItem(${item.id}, 'unit_price', parseFloat(this.value))"
                               required>
                    </div>
                </td>
                <td class="text-end align-middle">
                    <span class="item-subtotal fw-bold text-success">$${item.subtotal.toFixed(2)}</span>
                </td>
                <td>
                    <input type="text" 
                           class="form-control form-control-sm item-delivery-time" 
                           value="${item.delivery_time}" 
                           placeholder="Ej: 15 días"
                           onchange="updateItem(${item.id}, 'delivery_time', this.value)">
                </td>
                <td class="text-center align-middle">
                    <button type="button" 
                            class="btn btn-sm btn-outline-danger" 
                            onclick="removeItem(${item.id})"
                            title="Eliminar item">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        tbody.append(row);
    });
    
    console.log('Items renderizados:', items.length);
    calculateTotals();
}

function updateItem(itemId, field, value) {
    const item = items.find(item => item.id === itemId);
    if (item) {
        item[field] = value;
        if (field === 'quantity' || field === 'unit_price') {
            item.subtotal = item.quantity * item.unit_price;
            updateItemSubtotal(itemId);
            calculateTotals();
        }
    }
}

function updateItemSubtotal(itemId) {
    const item = items.find(item => item.id === itemId);
    if (item) {
        const row = jQuery(`[data-item-id="${itemId}"]`);
        row.find('.item-subtotal').text('$' + item.subtotal.toFixed(2));
    }
}

function updateItemNumbers() {
    items.forEach(function(item, index) {
        item.item_number = index + 1;
    });
    renderItems();
}

function calculateTotals() {
    let subtotal = 0;
    items.forEach(function(item) {
        subtotal += item.quantity * item.unit_price;
    });
    
    const taxRate = parseFloat(jQuery('#tax_rate').val()) || 0;
    const taxAmount = (subtotal * taxRate) / 100;
    const total = subtotal + taxAmount;
    
    jQuery('#subtotalDisplay').text('$' + subtotal.toFixed(2));
    jQuery('#taxRateDisplay').text(taxRate);
    jQuery('#taxAmountDisplay').text('$' + taxAmount.toFixed(2));
    jQuery('#totalDisplay').text('$' + total.toFixed(2));
}

function createHiddenFields() {
    // Remover campos ocultos existentes
    jQuery('.item-hidden-field').remove();
    
    // Crear campos ocultos para cada item
    items.forEach(function(item, index) {
        const form = jQuery('#createQuotationForm');
        
        // Descripción
        form.append('<input type="hidden" class="item-hidden-field" name="item_description[]" value="' + item.description + '">');
        
        // Número de parte
        form.append('<input type="hidden" class="item-hidden-field" name="item_part_number[]" value="' + item.part_number + '">');
        
        // Cantidad
        form.append('<input type="hidden" class="item-hidden-field" name="item_quantity[]" value="' + item.quantity + '">');
        
        // Precio unitario
        form.append('<input type="hidden" class="item-hidden-field" name="item_unit_price[]" value="' + item.unit_price + '">');
        
        // Tiempo de entrega
        form.append('<input type="hidden" class="item-hidden-field" name="item_delivery_time[]" value="' + item.delivery_time + '">');
    });
}


// Auto-hide alerts after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<?php
// Obtener el contenido del buffer
$content = ob_get_clean();

// Scripts específicos de la página
$page_scripts = "";

// Cargar el layout principal
$this->load->view('layouts/main_layout', array(
    'page_title' => $page_title,
    'page_type' => $page_type,
    'active_menu' => $active_menu,
    'page_header' => $page_header,
    'page_subtitle' => $page_subtitle,
    'page_icon' => $page_icon,
    'additional_css' => $additional_css,
    'page_scripts' => $page_scripts,
    'content' => $content
));
?>
