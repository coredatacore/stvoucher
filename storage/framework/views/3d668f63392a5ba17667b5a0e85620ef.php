<?php $__env->startSection('header', 'Voucher Groups'); ?>

<?php $__env->startSection('actions'); ?>
    <button class="btn btn-primary shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#createGroupModal"><i class="bi bi-plus-lg me-2"></i>Create Group</button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card border-0 bg-white p-4">
    <div class="table-responsive">
        <table class="table table-hover datatable align-middle mb-0 w-100">
            <thead>
                <tr>
                    <th>Group Name</th>
                    <th>Site</th>
                    <th>Batch Code</th>
                    <th>Profile</th>
                    <th>Qty</th>
                    <th>Date Generated</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="fw-bold text-dark">
                        <div class="d-flex align-items-center">
                            <div class="bg-dark bg-opacity-10 text-dark rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width:35px;height:35px;">
                                <i class="bi bi-collection"></i>
                            </div>
                            <?php echo e($group->group_name); ?>

                        </div>
                    </td>
                    <td><?php echo e($group->site->site_name ?? 'N/A'); ?></td>
                    <td class="font-monospace text-muted"><?php echo e($group->batch_code); ?></td>
                    <td><span class="badge bg-light text-dark border"><?php echo e($group->profile->profile_name ?? 'N/A'); ?></span></td>
                    <td><span class="badge bg-primary bg-opacity-10 text-primary px-2"><?php echo e($group->quantity); ?></span></td>
                    <td class="text-muted small"><?php echo e($group->created_at->format('M d, Y H:i')); ?></td>
                    <td class="text-end">
                        <form action="<?php echo e(route('admin.groups.destroy', $group->id)); ?>" method="POST" class="d-inline">
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
        <?php echo e($groups->links('pagination::bootstrap-5')); ?>

    </div>
</div>

<!-- Create Group Modal -->
<div class="modal fade" id="createGroupModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-collection me-2 text-danger"></i>Create Voucher Group</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin.groups.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Group Name</label>
                        <input type="text" name="group_name" class="form-control" placeholder="Enter group name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Site</label>
                        <select name="site_id" class="form-select" required>
                            <option value="">Select Site</option>
                            <?php $__currentLoopData = \App\Models\Site::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($site->id); ?>"><?php echo e($site->site_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Voucher Profile</label>
                        <select name="profile_id" class="form-select" required>
                            <option value="">Select Profile</option>
                            <?php $__currentLoopData = \App\Models\VoucherProfile::where('status','active')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($profile->id); ?>"><?php echo e($profile->profile_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Create Group</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\radiusserver\resources\views/admin/groups/index.blade.php ENDPATH**/ ?>