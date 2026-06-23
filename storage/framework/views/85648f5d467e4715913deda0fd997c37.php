<?php $__env->startSection('header', 'Active Sessions'); ?>

<?php $__env->startSection('content'); ?>
<div class="card border-0 bg-white p-4">
    <div class="table-responsive">
        <table class="table table-hover datatable align-middle mb-0 w-100">
            <thead>
                <tr>
                    <th>Username / Voucher</th>
                    <th>IP Address</th>
                    <th>MAC Address</th>
                    <th>Session Time</th>
                    <th>Downloaded</th>
                    <th>Uploaded</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="font-monospace fw-bold text-dark">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width:35px;height:35px;">
                                <i class="bi bi-person"></i>
                            </div>
                            <?php echo e($session->username); ?>

                        </div>
                    </td>
                    <td><?php echo e($session->framedipaddress); ?></td>
                    <td class="font-monospace text-muted small"><?php echo e($session->callingstationid); ?></td>
                    <td><span class="badge bg-light text-dark border"><i class="bi bi-clock me-1"></i><?php echo e(gmdate("H:i:s", $session->acctsessiontime)); ?></span></td>
                    <td class="text-success"><i class="bi bi-arrow-down-circle me-1"></i><?php echo e(round($session->acctoutputoctets / 1048576, 2)); ?> MB</td>
                    <td class="text-primary"><i class="bi bi-arrow-up-circle me-1"></i><?php echo e(round($session->acctinputoctets / 1048576, 2)); ?> MB</td>
                    <td class="text-end">
                        <form action="<?php echo e(route('admin.sessions.disconnect', $session->username)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" data-bs-toggle="tooltip" title="Disconnect User via CoA">
                                <i class="bi bi-plug me-1"></i>Disconnect
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\radiusserver\resources\views/admin/sessions/index.blade.php ENDPATH**/ ?>