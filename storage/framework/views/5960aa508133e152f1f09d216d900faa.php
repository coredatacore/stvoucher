<?php $__env->startSection('content'); ?>
<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md text-center">
    <div class="mb-6">
        <!-- Placeholder for Logo -->
        <div class="mx-auto w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mb-4">
            <span class="text-red-600 font-bold text-2xl">ST</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">ST Voucher Solution</h1>
        <p class="text-gray-500 text-sm mt-2">Enter your voucher code to access the internet.</p>
    </div>

    <?php if($errors->any()): ?>
        <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-4 text-sm">
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('portal.authenticate')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <!-- Hidden Omada parameters -->
        <?php $__currentLoopData = $params ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="mb-6">
            <input type="text" name="voucher_code" placeholder="Voucher Code" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 text-center font-mono text-lg uppercase"
                autocomplete="off">
        </div>
        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-lg transition shadow-md">
            Connect
        </button>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.portal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\radiusserver\resources\views/portal/index.blade.php ENDPATH**/ ?>