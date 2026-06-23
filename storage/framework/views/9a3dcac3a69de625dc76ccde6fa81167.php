<?php $__env->startSection('body_class', 'theme-default'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .theme-default {
        background-color: #080000;
        /* Hexagon pattern + Red glowing effects */
        background-image: 
            radial-gradient(ellipse at bottom, rgba(200, 0, 0, 0.4) 0%, transparent 45%),
            radial-gradient(circle at 50% 25%, rgba(200, 0, 0, 0.4) 0%, transparent 60%),
            url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='138.56' viewBox='0 0 80 138.56'%3E%3Cpolygon points='40,0 80,23.09 80,69.28 40,92.37 0,69.28 0,23.09' fill='none' stroke='rgba(255,255,255,0.06)' stroke-width='1.5'/%3E%3Cpolygon points='40,138.56 80,115.47 80,69.28 40,92.37 0,69.28 0,115.47' fill='none' stroke='rgba(255,255,255,0.06)' stroke-width='1.5'/%3E%3C/svg%3E");
        color: white;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
        padding: 0;
    }

    .wrapper {
        width: 100%;
        max-width: 380px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    /* Main Logo Image */
    .main-logo-container {
        text-align: center;
        margin-bottom: -60px;
        position: relative;
        z-index: 10;
        filter: drop-shadow(0 5px 15px rgba(200, 0, 0, 0.5));
        transition: transform 0.3s ease;
    }
    .main-logo-container:hover {
        transform: scale(1.05);
        filter: drop-shadow(0 5px 25px rgba(204, 0, 0, 0.8));
    }
    .main-logo {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #0f0f0f;
        background-color: #0f0f0f;
    }

    /* Main Card */
    .card {
        width: 100%;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.6), 0 0 20px rgba(200,0,0,0.2);
        overflow: hidden;
        margin-bottom: 40px;
        backdrop-filter: blur(10px);
        background: rgba(15, 15, 15, 0.95);
        transition: all 0.3s ease;
    }

    /* Card Header */
    .card-header {
        background-color: transparent;
        padding: 70px 20px 18px 20px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        border-bottom: 2px solid rgba(204, 0, 0, 0.5);
        position: relative;
    }
    .card-header::after {
        content: '';
        position: absolute;
        bottom: -2px; left: 0; width: 100%; height: 2px;
        background: #cc0000;
        box-shadow: 0 0 10px #cc0000;
    }
    .header-left {
        text-align: left;
    }
    .greeting {
        font-size: 16px;
        font-weight: bold;
        color: #fff;
    }
    .day {
        font-size: 11px;
        color: #aaa;
        margin-top: 3px;
    }
    .time {
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        letter-spacing: 1px;
        text-shadow: 0 0 8px rgba(255,255,255,0.5);
    }

    /* Card Body */
    .card-body {
        background-color: #ffffff;
        padding: 25px 20px;
    }

    /* Form Elements */
    .input-wrapper {
        position: relative;
        margin-bottom: 15px;
    }
    .form-control {
        width: 100%;
        padding: 14px 20px 14px 45px;
        border: 1px solid #e0e0e0;
        border-radius: 25px;
        font-size: 14px;
        color: #333;
        outline: none;
        box-shadow: inset 0 2px 5px rgba(0,0,0,0.02);
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        border-color: #cc0000;
        box-shadow: 0 0 10px rgba(204, 0, 0, 0.2);
        transform: translateY(-1px);
    }
    .form-control::placeholder {
        color: #aaa;
        font-weight: 400;
    }
    .input-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        opacity: 0.6;
        transition: opacity 0.3s;
    }
    .form-control:focus + .input-icon {
        opacity: 1;
        fill: #cc0000;
    }

    /* Buttons */
    .btn {
        width: 100%;
        padding: 15px;
        border: none;
        border-radius: 25px;
        font-size: 15px;
        font-weight: 800;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }
    .btn:active {
        transform: scale(0.98);
    }
    .btn-connect {
        background-color: #cc0000;
        color: white;
        margin-top: 10px;
        box-shadow: 0 4px 15px rgba(204, 0, 0, 0.4);
    }
    .btn-connect:hover {
        background-color: #ff1a1a;
        box-shadow: 0 6px 20px rgba(204, 0, 0, 0.6);
    }

    /* Footer */
    .footer-text {
        text-align: center;
        font-weight: 700;
        letter-spacing: 1px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.8);
    }
    .footer-text p:first-child {
        color: #ffcccc;
        font-size: 13px;
        margin-bottom: 5px;
    }
    .footer-text p:last-child {
        color: #ffffff;
        font-size: 11px;
        opacity: 0.8;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="wrapper">
    <!-- Main Logo -->
    <div class="main-logo-container">
        <img src="<?php echo e(asset('image/logo.png')); ?>" alt="ST Voucher WiFi Logo" class="main-logo" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'120\' height=\'120\' viewBox=\'0 0 120 120\'%3E%3Crect width=\'120\' height=\'120\' fill=\'%23cc0000\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' fill=\'white\' font-size=\'40\' font-family=\'sans-serif\' font-weight=\'bold\'%3EST%3C/text%3E%3C/svg%3E'">
    </div>

    <!-- Main Card -->
    <div class="card">
        <!-- Dynamic Header -->
        <div class="card-header">
            <div class="header-left">
                <div id="greeting" class="greeting">Good Morning</div>
                <div id="day" class="day">Today is Tuesday</div>
            </div>
            <div id="time" class="time">10:57:30</div>
        </div>
        
        <!-- Card Body / Form -->
        <div class="card-body">
            <?php if($errors->any()): ?>
                <div style="background-color: #ffe6e6; color: #cc0000; padding: 10px; border-radius: 8px; margin-bottom: 15px; font-size: 13px; text-align: center; border: 1px solid #ffcccc;">
                    <?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('portal.authenticate')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php $__currentLoopData = $params ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <!-- Voucher Section -->
                <div id="voucher-section">
                    <div class="input-wrapper">
                        <!-- Ticket Icon -->
                        <svg class="input-icon" viewBox="0 0 24 24" fill="#999"><path d="M22 10V6c0-1.1-.9-2-2-2H4c-1.1 0-1.99.9-1.99 2v4c1.1 0 1.99.9 1.99 2s-.89 2-2 2v4c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2v-4c-1.1 0-2-.9-2-2s.9-2 2-2zm-2-1.46c-1.19.69-2 1.99-2 3.46s.81 2.77 2 3.46V18H4v-2.54c1.19-.69 2-1.99 2-3.46s-.81-2.77-2-3.46V6h16v2.54zM11 15h2v2h-2zm0-4h2v2h-2zm0-4h2v2h-2z"/></svg>
                        <input type="text" name="voucher_code" id="voucher-code" class="form-control" placeholder="Voucher Code" required autocomplete="off" style="text-transform: uppercase;">
                    </div>
                </div>

                <!-- Action Buttons -->
                <button type="submit" class="btn btn-connect" id="btn-connect">
                    <span id="btn-text">CONNECT</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer-text">
        <p>ENJOY UNLIMITED WIFI</p>
        <p>ST VOUCHER WIFI. <?php echo e(date('Y')); ?></p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Real-time clock and dynamic greeting
    function updateTime() {
        const now = new Date();
        const hours = now.getHours();
        
        let greeting = "Good Evening";
        if (hours < 12) greeting = "Good Morning";
        else if (hours < 18) greeting = "Good Afternoon";
        
        const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        
        document.getElementById('greeting').innerText = greeting;
        document.getElementById('day').innerText = "Today is " + days[now.getDay()];
        
        let h = hours;
        let m = now.getMinutes();
        let s = now.getSeconds();
        let ampm = h >= 12 ? 'PM' : 'AM';
        
        h = h % 12;
        h = h ? h : 12; // the hour '0' should be '12'
        h = h < 10 ? '0' + h : h;
        m = m < 10 ? '0' + m : m;
        s = s < 10 ? '0' + s : s;
        
        document.getElementById('time').innerText = h + ':' + m + ':' + s + ' ' + ampm;
    }
    setInterval(updateTime, 1000);
    updateTime(); // initial call
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.portal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\radiusserver\resources\views/portal/themes/default/index.blade.php ENDPATH**/ ?>