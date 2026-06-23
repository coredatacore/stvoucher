<?php $__env->startSection('header', 'Accounting Logs'); ?>

<?php $__env->startSection('content'); ?>
<div class="card border-0 bg-white p-4">
    <div class="table-responsive">
        <table class="table table-hover datatable align-middle mb-0 w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Start Time</th>
                    <th>Stop Time</th>
                    <th>Session Time</th>
                    <th>Terminate Cause</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="text-muted">#<?php echo e($log->radacctid); ?></td>
                    <td class="font-monospace fw-bold text-dark"><?php echo e($log->username); ?></td>
                    <td><i class="bi bi-play-circle text-success me-1"></i><?php echo e($log->acctstarttime); ?></td>
                    <td>
                        <?php if($log->acctstoptime): ?>
                            <i class="bi bi-stop-circle text-danger me-1"></i><?php echo e($log->acctstoptime); ?>

                        <?php else: ?>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill"><i class="bi bi-broadcast me-1"></i>Active</span>
                        <?php endif; ?>
                    </td>
                    <td><span class="badge bg-light text-dark border"><?php echo e(gmdate("H:i:s", $log->acctsessiontime)); ?></span></td>
                    <td class="small text-muted"><?php echo e($log->acctterminatecause ?? '-'); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4 d-flex justify-content-end">
        <?php echo e($logs->links('pagination::bootstrap-5')); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\radiusserver\resources\views/admin/logs/accounting.blade.php ENDPATH**/ ?>