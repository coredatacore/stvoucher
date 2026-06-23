<?php $__env->startSection('header', 'Voucher Profiles'); ?>

<?php $__env->startSection('actions'); ?>
    <button class="btn btn-primary shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#createProfileModal"><i class="bi bi-plus-lg me-2"></i>Create Profile</button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card border-0 bg-white p-4">
    <div class="table-responsive">
        <table class="table table-hover datatable align-middle mb-0 w-100">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $profiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="fw-bold text-dark">
                        <div class="d-flex align-items-center">
                            <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width:35px;height:35px;">
                                <i class="bi bi-tag"></i>
                            </div>
                            <?php echo e($profile->profile_name); ?>

                        </div>
                    </td>
                    <td class="text-success fw-bold">₱<?php echo e(number_format($profile->price, 2)); ?></td>
                    <td><span class="badge bg-light text-dark border"><i class="bi bi-clock me-1"></i><?php echo e($profile->duration); ?> <?php echo e($profile->duration_unit); ?></span></td>
                    <td>
                        <span class="badge rounded-pill <?php echo e($profile->status == 'active' ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger'); ?> px-3 py-2">
                            <i class="bi <?php echo e($profile->status == 'active' ? 'bi-check-circle' : 'bi-x-circle'); ?> me-1"></i><?php echo e(ucfirst($profile->status)); ?>

                        </span>
                    </td>
                    <td class="text-end">
                        <form action="<?php echo e(route('admin.profiles.destroy', $profile->id)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-light text-danger rounded-circle" data-bs-toggle="tooltip" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4 d-flex justify-content-end">
        <?php echo e($profiles->links('pagination::bootstrap-5')); ?>

    </div>
</div>

<!-- Create Profile Modal -->
<div class="modal fade" id="createProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-tags me-2 text-danger"></i>Create Voucher Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin.profiles.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="max_simultaneous_use" value="1">
                <input type="hidden" name="expiration_type" value="after_login">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Profile Name</label>
                        <input type="text" name="profile_name" class="form-control" placeholder="e.g., 1 Hour Access" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted d-block">Price Type</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="price_type" id="priceFree" value="free" checked onchange="togglePriceField()">
                            <label class="form-check-label" for="priceFree">No Price (Free)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="price_type" id="pricePaid" value="paid" onchange="togglePriceField()">
                            <label class="form-check-label" for="pricePaid">With Price</label>
                        </div>
                    </div>
                    <div class="row" id="priceFieldRow" style="display: none;">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-uppercase text-muted">Price (₱)</label>
                            <input type="number" name="price" id="priceInput" class="form-control" placeholder="0.00" step="0.01" value="0">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-uppercase text-muted">Status</label>
                            <select name="status" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-uppercase text-muted">Duration</label>
                            <input type="number" name="duration" class="form-control" placeholder="e.g., 1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-uppercase text-muted">Unit</label>
                            <select name="duration_unit" class="form-select">
                                <option value="Minutes">Minutes</option>
                                <option value="Hours">Hours</option>
                                <option value="Days">Days</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Description</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Optional description"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Create Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function togglePriceField() {
    const pricePaid = document.getElementById('pricePaid');
    const priceFieldRow = document.getElementById('priceFieldRow');
    const priceInput = document.getElementById('priceInput');

    if (pricePaid.checked) {
        priceFieldRow.style.display = 'flex';
        priceInput.setAttribute('required', 'required');
    } else {
        priceFieldRow.style.display = 'none';
        priceInput.removeAttribute('required');
        priceInput.value = '0';
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\radiusserver\resources\views/admin/profiles/index.blade.php ENDPATH**/ ?>