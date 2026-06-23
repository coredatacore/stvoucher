<?php $__env->startSection('header', 'Authentication Logs'); ?>

<?php $__env->startSection('content'); ?>
<div class="card border-0 bg-white p-4">
    <div class="table-responsive">
        <table class="table table-hover datatable align-middle mb-0 w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Reply</th>
                    <th>Auth Date</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="text-muted">#<?php echo e($log->id); ?></td>
                    <td class="font-monospace fw-bold text-dark"><?php echo e($log->username); ?></td>
                    <td>
                        <?php
                            $badgeClass = $log->reply == 'Access-Accept' ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger';
                            $iconClass = $log->reply == 'Access-Accept' ? 'bi-check-circle' : 'bi-x-circle';
                        ?>
                        <span class="badge rounded-pill <?php echo e($badgeClass); ?> px-3 py-2">
                            <i class="bi <?php echo e($iconClass); ?> me-1"></i><?php echo e($log->reply); ?>

                        </span>
                    </td>
                    <td class="text-muted small"><i class="bi bi-calendar me-1"></i><?php echo e($log->authdate); ?></td>
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\radiusserver\resources\views/admin/logs/auth.blade.php ENDPATH**/ ?>