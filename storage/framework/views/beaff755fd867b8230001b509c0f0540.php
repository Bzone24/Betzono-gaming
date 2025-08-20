<?php $__env->startSection('content'); ?>
<?php
    $sidenav = file_get_contents(resource_path('views/admin/partials/sidenav.json'));
    
?>
    <!-- page-wrapper start -->
    <div class="page-wrapper default-version">
        <?php echo $__env->make('admin.partials.sidenav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('admin.partials.topnav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="container-fluid px-3 px-sm-0">
            <div class="body-wrapper">
                <div class="bodywrapper__inner">

                    <?php echo $__env->yieldPushContent('topBar'); ?>
                    <?php echo $__env->make('admin.partials.breadcrumb', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                    <?php echo $__env->yieldContent('panel'); ?>

                </div><!-- bodywrapper__inner end -->
            </div><!-- body-wrapper end -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\betzono.com\core\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>