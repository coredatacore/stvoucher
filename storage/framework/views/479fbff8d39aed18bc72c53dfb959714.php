<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ST Voucher Solution - Admin Login</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .login-card {
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            border: none;
        }
        .login-icon {
            width: 60px;
            height: 60px;
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 8px;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
            border-color: #dc3545;
        }
        .btn-dark {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            background-color: #0f0f0f;
        }
        .btn-dark:hover {
            background-color: #212529;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card login-card p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="login-icon">
                            <i class="bi bi-wifi fs-1"></i>
                        </div>
                        <h3 class="fw-bold text-dark">Admin Login</h3>
                        <p class="text-muted small">ST Voucher Solution Management</p>
                    </div>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-3 p-3 text-center small fw-semibold mb-4">
                            <?php echo e($errors->first()); ?>

                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('admin.login.submit')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small">Email Address</label>
                            <input type="email" name="email" value="<?php echo e(old('email')); ?>" required class="form-control bg-light" placeholder="admin@stvoucher.local">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small">Password</label>
                            <input type="password" name="password" required class="form-control bg-light" placeholder="••••••••">
                        </div>
                        <button type="submit" class="btn btn-dark w-100 shadow-sm">
                            Sign In
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\radiusserver\resources\views/admin/login.blade.php ENDPATH**/ ?>