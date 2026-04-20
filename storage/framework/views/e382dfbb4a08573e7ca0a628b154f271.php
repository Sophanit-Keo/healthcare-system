<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Healthcare</title>

    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/owl-carousel/css/owl.carousel.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/owl-carousel/css/owl.theme.default.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/animate/animate.min.css')); ?>">

    <?php echo $__env->yieldPushContent('style'); ?>
</head>

<body>
    
    <?php echo $__env->make('layout.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <?php echo $__env->make('layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <script src="<?php echo e(asset('assets/vendor/jquery/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/owl-carousel/js/owl.carousel.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/wow/wow.min.js')); ?>"></script>
    
    
    <?php if(file_exists(public_path('js/app.js'))): ?>
        <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    <?php endif; ?>

    <?php echo $__env->yieldPushContent('app'); ?>
</body>
</html>
<?php /**PATH C:\Users\REACH\Desktop\Laravel assignment\resources\views/layout/main.blade.php ENDPATH**/ ?>