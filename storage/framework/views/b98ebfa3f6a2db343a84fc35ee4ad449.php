<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ST Voucher Solution</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="<?php echo $__env->yieldContent('body_class', 'bg-gray-100 flex items-center justify-center h-screen font-sans'); ?>">
    <?php echo $__env->yieldContent('content'); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\laragon\www\radiusserver\resources\views/layouts/portal.blade.php ENDPATH**/ ?>