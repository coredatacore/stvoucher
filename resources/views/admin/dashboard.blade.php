@extends('layouts.app')

@section('header', 'Dashboard Overview')

@section('actions')
    <div class="dropdown d-inline-block">
        <button class="btn btn-primary dropdown-toggle shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-lightning-charge me-1"></i> Quick Actions
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
            <li><a class="dropdown-item py-2" href="{{ route('admin.sites.index') }}"><i class="bi bi-building me-2 text-muted"></i>Create Site</a></li>
            <li><a class="dropdown-item py-2" href="{{ route('admin.vouchers.index') }}"><i class="bi bi-ticket-perforated me-2 text-muted"></i>Generate Voucher</a></li>
            <li><a class="dropdown-item py-2" href="{{ route('admin.nas.index') }}"><i class="bi bi-hdd-network me-2 text-muted"></i>Add NAS</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-file-earmark-arrow-up me-2 text-muted"></i>Import CSV</a></li>
            <li><a class="dropdown-item py-2" href="{{ route('admin.reports.index') }}"><i class="bi bi-file-earmark-arrow-down me-2 text-muted"></i>Export Report</a></li>
            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-arrow-repeat me-2 text-muted"></i>Sync Controller</a></li>
        </ul>
    </div>
@endsection

@section('content')

<!-- Stat Cards Row 1 -->
<div class="row g-4 mb-4">
    <!-- Total Sites -->
    <div class="col-sm-6 col-lg-3">
        <div class="card card-hover h-100 border-0 bg-white position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 opacity-25">
                <i class="bi bi-building fs-1 text-danger"></i>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-3 me-3">
                        <i class="bi bi-building fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-0" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Sites</h6>
                    </div>
                </div>
                <h2 class="fw-black mb-0 text-dark counter">{{ $stats['total_sites'] }}</h2>
            </div>
            <div class="position-absolute bottom-0 start-0 w-100 bg-danger" style="height: 4px;"></div>
        </div>
    </div>

    <!-- Active Sessions (Replaced Groups) -->
    <div class="col-sm-6 col-lg-3">
        <div class="card card-hover h-100 border-0 bg-white position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 opacity-25">
                <i class="bi bi-activity fs-1 text-primary"></i>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                        <i class="bi bi-activity fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-0" style="font-size: 0.75rem; letter-spacing: 0.5px;">Active Sessions</h6>
                    </div>
                </div>
                <h2 class="fw-black mb-0 text-dark counter">{{ $stats['active_sessions'] ?? 0 }}</h2>
            </div>
            <div class="position-absolute bottom-0 start-0 w-100 bg-primary" style="height: 4px;"></div>
        </div>
    </div>

    <!-- Voucher Profiles -->
    <div class="col-sm-6 col-lg-3">
        <div class="card card-hover h-100 border-0 bg-white position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 opacity-25">
                <i class="bi bi-tags fs-1 text-danger"></i>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-3 me-3">
                        <i class="bi bi-tags fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-0" style="font-size: 0.75rem; letter-spacing: 0.5px;">Voucher Profiles</h6>
                    </div>
                </div>
                <h2 class="fw-black mb-0 text-dark counter">{{ $stats['total_profiles'] ?? 0 }}</h2>
            </div>
            <div class="position-absolute bottom-0 start-0 w-100 bg-danger" style="height: 4px;"></div>
        </div>
    </div>

    <!-- Total Vouchers -->
    <div class="col-sm-6 col-lg-3">
        <div class="card card-hover h-100 border-0 bg-white position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 opacity-25">
                <i class="bi bi-ticket-perforated fs-1 text-dark"></i>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-dark bg-opacity-10 text-dark rounded-3 p-3 me-3">
                        <i class="bi bi-ticket-perforated fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-0" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Vouchers</h6>
                    </div>
                </div>
                <h2 class="fw-black mb-0 text-dark counter">{{ $stats['total_vouchers'] }}</h2>
            </div>
            <div class="position-absolute bottom-0 start-0 w-100 bg-dark" style="height: 4px;"></div>
        </div>
    </div>
</div>

<!-- Stat Cards Row 2 -->
<div class="row g-4 mb-4">
    <!-- Online Users -->
    <div class="col-sm-6 col-lg-3">
        <div class="card card-hover h-100 border-0 bg-white position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 opacity-25">
                <i class="bi bi-people fs-1 text-success"></i>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-success bg-opacity-10 text-success rounded-3 p-3 me-3">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-0" style="font-size: 0.75rem; letter-spacing: 0.5px;">Online Users</h6>
                    </div>
                </div>
                <h2 class="fw-black mb-0 text-dark counter">{{ $stats['online_users'] ?? 0 }}</h2>
            </div>
            <div class="position-absolute bottom-0 start-0 w-100 bg-success" style="height: 4px;"></div>
        </div>
    </div>

    <!-- Unused Vouchers -->
    <div class="col-sm-6 col-lg-3">
        <div class="card card-hover h-100 border-0 bg-white position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 opacity-25">
                <i class="bi bi-inbox fs-1 text-warning"></i>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3 me-3">
                        <i class="bi bi-inbox fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-0" style="font-size: 0.75rem; letter-spacing: 0.5px;">Unused Vouchers</h6>
                    </div>
                </div>
                <h2 class="fw-black mb-0 text-dark counter">{{ $stats['unused_vouchers'] }}</h2>
            </div>
            <div class="position-absolute bottom-0 start-0 w-100 bg-warning" style="height: 4px;"></div>
        </div>
    </div>

    <!-- Used Vouchers -->
    <div class="col-sm-6 col-lg-3">
        <div class="card card-hover h-100 border-0 bg-white position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 opacity-25">
                <i class="bi bi-check-circle fs-1 text-info"></i>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-info bg-opacity-10 text-info rounded-3 p-3 me-3">
                        <i class="bi bi-check-circle fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-0" style="font-size: 0.75rem; letter-spacing: 0.5px;">Used Vouchers</h6>
                    </div>
                </div>
                <h2 class="fw-black mb-0 text-dark counter">{{ $stats['used_vouchers'] }}</h2>
            </div>
            <div class="position-absolute bottom-0 start-0 w-100 bg-info" style="height: 4px;"></div>
        </div>
    </div>
</div>

<!-- Stat Cards Row 3 -->
<div class="row g-4 mb-5">
    <!-- Expired Vouchers -->
    <div class="col-sm-6 col-lg-3">
        <div class="card card-hover h-100 border-0 bg-white position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 opacity-25">
                <i class="bi bi-x-circle fs-1 text-danger"></i>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-3 me-3">
                        <i class="bi bi-x-circle fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-0" style="font-size: 0.75rem; letter-spacing: 0.5px;">Expired Vouchers</h6>
                    </div>
                </div>
                <h2 class="fw-black mb-0 text-dark counter">{{ $stats['expired_vouchers'] }}</h2>
            </div>
            <div class="position-absolute bottom-0 start-0 w-100 bg-danger" style="height: 4px;"></div>
        </div>
    </div>

    <!-- Today's Revenue -->
    <div class="col-sm-6 col-lg-3">
        <div class="card card-hover h-100 border-0 bg-white position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 opacity-25">
                <i class="bi bi-cash fs-1 text-success"></i>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-success bg-opacity-10 text-success rounded-3 p-3 me-3">
                        <i class="bi bi-cash fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-0" style="font-size: 0.75rem; letter-spacing: 0.5px;">Today's Revenue</h6>
                    </div>
                </div>
                <h2 class="fw-black mb-0 text-dark">₱<span class="counter">{{ $stats['today_revenue'] ?? 0 }}</span></h2>
            </div>
            <div class="position-absolute bottom-0 start-0 w-100 bg-success" style="height: 4px;"></div>
        </div>
    </div>

    <!-- Monthly Revenue -->
    <div class="col-sm-6 col-lg-3">
        <div class="card card-hover h-100 border-0 bg-white position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 opacity-25">
                <i class="bi bi-graph-up-arrow fs-1 text-primary"></i>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                        <i class="bi bi-graph-up-arrow fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-0" style="font-size: 0.75rem; letter-spacing: 0.5px;">Monthly Revenue</h6>
                    </div>
                </div>
                <h2 class="fw-black mb-0 text-dark">₱<span class="counter">{{ $stats['monthly_revenue'] ?? 0 }}</span></h2>
            </div>
            <div class="position-absolute bottom-0 start-0 w-100 bg-primary" style="height: 4px;"></div>
        </div>
    </div>

    <!-- Data Usage -->
    <div class="col-sm-6 col-lg-3">
        <div class="card card-hover h-100 border-0 bg-white position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 opacity-25">
                <i class="bi bi-hdd-network fs-1 text-dark"></i>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-dark bg-opacity-10 text-dark rounded-3 p-3 me-3">
                        <i class="bi bi-hdd-network fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-0" style="font-size: 0.75rem; letter-spacing: 0.5px;">Data Usage</h6>
                    </div>
                </div>
                <h2 class="fw-black mb-0 text-dark">{{ $stats['total_data_usage'] }}</h2>
            </div>
            <div class="position-absolute bottom-0 start-0 w-100 bg-dark" style="height: 4px;"></div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Voucher Usage Chart -->
    <div class="col-lg-6">
        <div class="card border-0 bg-white p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Voucher Usage</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-light rounded-circle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><a class="dropdown-item" href="#">Refresh</a></li>
                    </ul>
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center h-100 pb-4">
                <canvas id="voucherChart" style="max-height: 250px;"
                    data-used="{{ $stats['used_vouchers'] }}" 
                    data-unused="{{ $stats['unused_vouchers'] }}" 
                    data-expired="{{ $stats['expired_vouchers'] }}">
                </canvas>
            </div>
        </div>
    </div>
    
    <!-- Quick Stats -->
    <div class="col-lg-6">
        <div class="card border-0 bg-white p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Quick Overview</h5>
            </div>
            <div class="row g-3">
                <div class="col-6">
                    <div class="p-3 bg-light rounded-3 border">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-ticket-perforated text-danger"></i>
                            <small class="text-muted">Total</small>
                        </div>
                        <h4 class="fw-bold mb-0">{{ $stats['total_vouchers'] ?? 0 }}</h4>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 bg-light rounded-3 border">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-check-circle text-success"></i>
                            <small class="text-muted">Used</small>
                        </div>
                        <h4 class="fw-bold mb-0">{{ $stats['used_vouchers'] ?? 0 }}</h4>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 bg-light rounded-3 border">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-inbox text-warning"></i>
                            <small class="text-muted">Unused</small>
                        </div>
                        <h4 class="fw-bold mb-0">{{ $stats['unused_vouchers'] ?? 0 }}</h4>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 bg-light rounded-3 border">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-x-circle text-danger"></i>
                            <small class="text-muted">Expired</small>
                        </div>
                        <h4 class="fw-bold mb-0">{{ $stats['expired_vouchers'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Widgets Row -->
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 bg-white p-4">
            <h5 class="fw-bold mb-4">System Status</h5>
            <div class="d-flex flex-column gap-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success bg-opacity-10 text-success p-2 rounded"><i class="bi bi-database"></i></div>
                        <div>
                            <h6 class="mb-0 fw-bold">Database Server</h6>
                            <small class="text-muted">MariaDB Local</small>
                        </div>
                    </div>
                    <span class="badge bg-success rounded-pill px-3">Online</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success bg-opacity-10 text-success p-2 rounded"><i class="bi bi-hdd-network"></i></div>
                        <div>
                            <h6 class="mb-0 fw-bold">FreeRADIUS</h6>
                            <small class="text-muted">Authentication Engine</small>
                        </div>
                    </div>
                    <span class="badge bg-success rounded-pill px-3">Online</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary bg-opacity-10 text-primary p-2 rounded"><i class="bi bi-cpu"></i></div>
                        <div>
                            <h6 class="mb-0 fw-bold">CPU Usage</h6>
                            <small class="text-muted">System Load</small>
                        </div>
                    </div>
                    <span class="fw-bold">12%</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-warning bg-opacity-10 text-warning p-2 rounded"><i class="bi bi-memory"></i></div>
                        <div>
                            <h6 class="mb-0 fw-bold">Memory Usage</h6>
                            <small class="text-muted">RAM Status</small>
                        </div>
                    </div>
                    <span class="fw-bold">48%</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card border-0 bg-white p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Recent Activities</h5>
                <a href="#" class="text-decoration-none text-danger fw-medium text-sm">View All</a>
            </div>
            <div class="position-relative border-start border-2 border-danger ms-3 ps-4 py-2">
                <div class="position-absolute top-0 start-0 translate-middle w-3 h-3 bg-danger rounded-circle border border-white border-2" style="width: 12px; height: 12px;"></div>
                <h6 class="fw-bold mb-1">New Voucher Group Created</h6>
                <p class="text-muted small mb-0">Admin generated "June 2026 Batch" for Site 1.</p>
                <small class="text-muted" style="font-size: 0.7rem;">10 mins ago</small>
            </div>
            <div class="position-relative border-start border-2 border-light ms-3 ps-4 py-2 mt-2">
                <div class="position-absolute top-0 start-0 translate-middle bg-secondary rounded-circle border border-white border-2" style="width: 12px; height: 12px;"></div>
                <h6 class="fw-bold mb-1">New Site Added</h6>
                <p class="text-muted small mb-0">Admin created site "Turno Piso WiFi".</p>
                <small class="text-muted" style="font-size: 0.7rem;">2 hours ago</small>
            </div>
            <div class="position-relative border-start border-2 border-light ms-3 ps-4 py-2 mt-2">
                <div class="position-absolute top-0 start-0 translate-middle bg-secondary rounded-circle border border-white border-2" style="width: 12px; height: 12px;"></div>
                <h6 class="fw-bold mb-1">System Update</h6>
                <p class="text-muted small mb-0">Database backup completed successfully.</p>
                <small class="text-muted" style="font-size: 0.7rem;">Yesterday</small>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Animated Counters
    const counters = document.querySelectorAll('.counter');
    const speed = 200;

    counters.forEach(counter => {
        const animate = () => {
            const value = +counter.innerText.replace(/,/g, '');
            const data = +counter.getAttribute('data-target') || value;
            
            if (!counter.getAttribute('data-target')) {
                counter.setAttribute('data-target', value);
                counter.innerText = '0';
            }

            const current = +counter.innerText.replace(/,/g, '');
            const inc = data / speed;

            if(current < data) {
                counter.innerText = Math.ceil(current + inc).toLocaleString();
                setTimeout(animate, 1);
            } else {
                counter.innerText = data.toLocaleString();
            }
        }
        animate();
    });

    // Chart.js initialization
    const voucherCanvas = document.getElementById('voucherChart');
    const ctx2 = voucherCanvas.getContext('2d');
    
    const usedVouchers = parseInt(voucherCanvas.dataset.used || '0', 10);
    const unusedVouchers = parseInt(voucherCanvas.dataset.unused || '0', 10);
    const expiredVouchers = parseInt(voucherCanvas.dataset.expired || '0', 10);

    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Used', 'Unused', 'Expired'],
            datasets: [{
                data: [usedVouchers, unusedVouchers, expiredVouchers],
                backgroundColor: ['#dc3545', '#0f0f0f', '#e9ecef'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 20, usePointStyle: true, pointStyle: 'circle' }
                }
            }
        }
    });

    // Theme update hook for charts
    window.updateChartsTheme = function(theme) {
        const textColor = theme === 'dark' ? '#e0e0e0' : '#6c757d';
        const gridColor = theme === 'dark' ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';
        
        Chart.instances.forEach(chart => {
            if (chart.options.scales.x) {
                chart.options.scales.x.ticks.color = textColor;
                chart.options.scales.y.ticks.color = textColor;
                chart.options.scales.y.grid.color = gridColor;
            }
            if (chart.options.plugins.legend) {
                chart.options.plugins.legend.labels.color = textColor;
            }
            chart.update();
        });
    };
</script>
@endpush