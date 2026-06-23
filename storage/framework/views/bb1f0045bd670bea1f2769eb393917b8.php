<?php $__env->startSection('header', 'Reports'); ?>

<?php $__env->startSection('actions'); ?>
    <button class="btn btn-outline-secondary shadow-sm px-4"><i class="bi bi-cloud-download me-2"></i>Export</button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card border-0 bg-white p-4 mb-4">
    <h5 class="fw-bold mb-4">Report Filters</h5>
    <div class="row g-3">
        <div class="col-12 col-md-3">
            <label class="form-label text-muted fw-bold small text-uppercase mb-1">Site</label>
            <select class="form-select form-select-sm">
                <option value="">All Sites</option>
            </select>
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label text-muted fw-bold small text-uppercase mb-1">Voucher Group</label>
            <select class="form-select form-select-sm">
                <option value="">All Groups</option>
            </select>
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label text-muted fw-bold small text-uppercase mb-1">Profile</label>
            <select class="form-select form-select-sm">
                <option value="">All Profiles</option>
            </select>
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label text-muted fw-bold small text-uppercase mb-1">Date Range</label>
            <input type="date" class="form-control form-control-sm">
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-md-4">
        <div class="card card-hover h-100 border-0 bg-white position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 opacity-25">
                <i class="bi bi-calendar-day fs-1 text-danger"></i>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-3 me-3">
                        <i class="bi bi-calendar-day fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-0" style="font-size: 0.75rem; letter-spacing: 0.5px;">Daily Sales</h6>
                    </div>
                </div>
                <h2 class="fw-black mb-0 text-dark">₱<?php echo e(number_format($dailySales, 2)); ?></h2>
            </div>
            <div class="position-absolute bottom-0 start-0 w-100 bg-danger" style="height: 4px;"></div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card card-hover h-100 border-0 bg-white position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 opacity-25">
                <i class="bi bi-calendar-week fs-1 text-dark"></i>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-dark bg-opacity-10 text-dark rounded-3 p-3 me-3">
                        <i class="bi bi-calendar-week fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-0" style="font-size: 0.75rem; letter-spacing: 0.5px;">Weekly Sales</h6>
                    </div>
                </div>
                <h2 class="fw-black mb-0 text-dark">₱<?php echo e(number_format($weeklySales, 2)); ?></h2>
            </div>
            <div class="position-absolute bottom-0 start-0 w-100 bg-dark" style="height: 4px;"></div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card card-hover h-100 border-0 bg-white position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 opacity-25">
                <i class="bi bi-calendar-month fs-1 text-danger"></i>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-3 me-3">
                        <i class="bi bi-calendar-month fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-0" style="font-size: 0.75rem; letter-spacing: 0.5px;">Monthly Sales</h6>
                    </div>
                </div>
                <h2 class="fw-black mb-0 text-dark">₱<?php echo e(number_format($monthlySales, 2)); ?></h2>
            </div>
            <div class="position-absolute bottom-0 start-0 w-100 bg-danger" style="height: 4px;"></div>
        </div>
    </div>
</div>

<div class="card border-0 bg-white p-4">
    <h5 class="fw-bold mb-4">Export Data</h5>
    <p class="text-muted mb-4">Select the report you want to export.</p>
    <div class="d-flex flex-wrap gap-3">
        <button class="btn btn-dark px-4"><i class="bi bi-filetype-csv me-2"></i>Export Voucher Sales (CSV)</button>
        <button class="btn btn-danger px-4"><i class="bi bi-filetype-pdf me-2"></i>Export Accounting Logs (PDF)</button>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\radiusserver\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>