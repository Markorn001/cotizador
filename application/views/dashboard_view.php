<?php
// Configuración del layout
$page_title = 'Dashboard';
$page_type = 'dashboard';
$active_menu = 'dashboard';
$page_header = 'Panel de Control';
$page_subtitle = 'Bienvenido al Sistema de Cotizador';
$page_icon = 'fas fa-tachometer-alt';

// Iniciar el buffer de salida
ob_start();
?>

    <!-- Welcome Section -->
    <section class="welcome-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="welcome-title mb-3">
                        <i class="fas fa-tachometer-alt me-3"></i>Dashboard
                    </h1>
                    <p class="lead mb-0">
                        Bienvenido, <strong><?php echo $this->session->userdata('full_name'); ?></strong> 
                        (<?php echo ucfirst($this->session->userdata('role')); ?>) al Sistema de Cotizador
                    </p>
                    <?php if(isset($user_role) && $user_role === 'vendedor'): ?>
                        <p class="text-muted mb-0">
                            <i class="fas fa-info-circle me-1"></i>
                            Las estadísticas y gráficas muestran solo tus cotizaciones
                        </p>
                    <?php elseif(isset($user_role) && $user_role === 'supervisor'): ?>
                        <p class="text-muted mb-0">
                            <i class="fas fa-eye me-1"></i>
                            Las estadísticas y gráficas muestran todas las cotizaciones del sistema
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Cards -->
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-2 mb-4">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <div class="stats-icon">
                            <i class="fas fa-file-invoice text-primary"></i>
                        </div>
                        <div class="stats-number"><?php echo $quotation_stats['total']; ?></div>
                        <div class="stats-label">Total</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-2 mb-4">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <div class="stats-icon">
                            <i class="fas fa-edit text-warning"></i>
                        </div>
                        <div class="stats-number"><?php echo $quotation_stats['draft']; ?></div>
                        <div class="stats-label">Borrador</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-2 mb-4">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <div class="stats-icon">
                            <i class="fas fa-paper-plane text-info"></i>
                        </div>
                        <div class="stats-number"><?php echo $quotation_stats['sent']; ?></div>
                        <div class="stats-label">Enviadas</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-2 mb-4">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <div class="stats-icon">
                            <i class="fas fa-check-circle text-success"></i>
                        </div>
                        <div class="stats-number"><?php echo $quotation_stats['approved']; ?></div>
                        <div class="stats-label">Aprobadas</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-2 mb-4">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <div class="stats-icon">
                            <i class="fas fa-times-circle text-danger"></i>
                        </div>
                        <div class="stats-number"><?php echo $quotation_stats['rejected']; ?></div>
                        <div class="stats-label">Rechazadas</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-2 mb-4">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <div class="stats-icon">
                            <i class="fas fa-clock text-secondary"></i>
                        </div>
                        <div class="stats-number"><?php echo $quotation_stats['expired']; ?></div>
                        <div class="stats-label">Expiradas</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chart-line me-2"></i>
                        <?php if(isset($user_role) && $user_role === 'vendedor'): ?>
                            Mis Cotizaciones Aprobadas por Mes
                        <?php else: ?>
                            Cotizaciones Aprobadas por Mes
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <canvas id="quotationsChart" width="400" height="100"></canvas>
                        <div id="quotationsChartError" class="text-center text-muted" style="display: none;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Error al cargar la gráfica de cotizaciones
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-dollar-sign me-2"></i>
                        <?php if(isset($user_role) && $user_role === 'vendedor'): ?>
                            Monto de Mis Cotizaciones Aprobadas por Mes
                        <?php else: ?>
                            Monto de Cotizaciones Aprobadas por Mes
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <canvas id="amountsChart" width="400" height="100"></canvas>
                        <div id="amountsChartError" class="text-center text-muted" style="display: none;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Error al cargar la gráfica de montos
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
// Obtener el contenido del buffer
$content = ob_get_clean();

// Scripts específicos de la página
$page_scripts = "
    <script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
    <script>
        // Datos para las gráficas
        const chartData = " . json_encode($quotation_chart_data) . ";
        
        // Variable para evitar múltiples inicializaciones
        let chartsInitialized = false;
        
        // Función para inicializar las gráficas
        function initCharts() {
            if (chartsInitialized) {
                console.log('Gráficas ya inicializadas');
                return;
            }
            
            if (typeof Chart === 'undefined') {
                console.error('Chart.js no está cargado');
                const quotationsError = document.getElementById('quotationsChartError');
                const amountsError = document.getElementById('amountsChartError');
                if (quotationsError) quotationsError.style.display = 'block';
                if (amountsError) amountsError.style.display = 'block';
                return;
            }
            
            console.log('Inicializando gráficas...');
            
            // Gráfica de cantidad de cotizaciones
            const quotationsCtx = document.getElementById('quotationsChart');
            if (quotationsCtx) {
                try {
                    new Chart(quotationsCtx.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: chartData.map(item => item.month),
                        datasets: [{
                            label: 'Cotizaciones Aprobadas',
                            data: chartData.map(item => item.count),
                            borderColor: '#007bff',
                            backgroundColor: 'rgba(0, 123, 255, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
                } catch (error) {
                    console.error('Error creando gráfica de cotizaciones:', error);
                    document.getElementById('quotationsChartError').style.display = 'block';
                }
            }
            
            // Gráfica de montos de cotizaciones
            const amountsCtx = document.getElementById('amountsChart');
            if (amountsCtx) {
                try {
                    new Chart(amountsCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: chartData.map(item => item.month),
                        datasets: [{
                            label: 'Monto Aprobado ($)',
                            data: chartData.map(item => parseFloat(item.amount)),
                            backgroundColor: 'rgba(40, 167, 69, 0.8)',
                            borderColor: '#28a745',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return '$' + value.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
                } catch (error) {
                    console.error('Error creando gráfica de montos:', error);
                    const amountsError = document.getElementById('amountsChartError');
                    if (amountsError) amountsError.style.display = 'block';
                }
            }
            
            chartsInitialized = true;
            console.log('Gráficas inicializadas correctamente');
        }
        
        // Función para cargar Chart.js y luego inicializar
        function loadChartJS() {
            if (typeof Chart !== 'undefined') {
                initCharts();
                return;
            }
            
            // Si Chart.js no está cargado, intentar cargarlo
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
            script.onload = function() {
                console.log('Chart.js cargado exitosamente');
                initCharts();
            };
            script.onerror = function() {
                console.error('Error cargando Chart.js');
                const quotationsError = document.getElementById('quotationsChartError');
                const amountsError = document.getElementById('amountsChartError');
                if (quotationsError) quotationsError.style.display = 'block';
                if (amountsError) amountsError.style.display = 'block';
            };
            document.head.appendChild(script);
        }
        
        // Inicializar cuando el DOM esté listo
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', loadChartJS);
        } else {
            loadChartJS();
        }
    </script>
";

// Cargar el layout principal
$this->load->view('layouts/main_layout', array(
    'page_title' => $page_title,
    'page_type' => $page_type,
    'active_menu' => $active_menu,
    'page_header' => $page_header,
    'page_subtitle' => $page_subtitle,
    'page_icon' => $page_icon,
    'page_scripts' => $page_scripts,
    'content' => $content
));
?>
