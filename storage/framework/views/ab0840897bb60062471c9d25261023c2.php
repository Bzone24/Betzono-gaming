<?php $__env->startSection('panel'); ?>

    <div class="row gy-4">

        <div class="col-xxl-3 col-sm-6">

            <?php if (isset($component)) { $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget','data' => ['style' => '6','link' => ''.e(route('admin.users.all')).'','icon' => 'las la-users','title' => 'Total Users','value' => ''.e($widget['total_users']).'','bg' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => '6','link' => ''.e(route('admin.users.all')).'','icon' => 'las la-users','title' => 'Total Users','value' => ''.e($widget['total_users']).'','bg' => 'primary']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $attributes = $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $component = $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <?php if (isset($component)) { $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget','data' => ['style' => '6','link' => ''.e(route('admin.users.active')).'','icon' => 'las la-user-check','title' => 'Active Users','value' => ''.e($widget['verified_users']).'','bg' => 'success']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => '6','link' => ''.e(route('admin.users.active')).'','icon' => 'las la-user-check','title' => 'Active Users','value' => ''.e($widget['verified_users']).'','bg' => 'success']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $attributes = $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $component = $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <?php if (isset($component)) { $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget','data' => ['style' => '6','link' => ''.e(route('admin.users.email.unverified')).'','icon' => 'lar la-envelope','title' => 'Email Unverified Users','value' => ''.e($widget['email_unverified_users']).'','bg' => 'danger']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => '6','link' => ''.e(route('admin.users.email.unverified')).'','icon' => 'lar la-envelope','title' => 'Email Unverified Users','value' => ''.e($widget['email_unverified_users']).'','bg' => 'danger']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $attributes = $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $component = $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <?php if (isset($component)) { $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget','data' => ['style' => '6','link' => ''.e(route('admin.users.mobile.unverified')).'','icon' => 'las la-comment-slash','title' => 'Mobile Unverified Users','value' => ''.e($widget['mobile_unverified_users']).'','bg' => 'warning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => '6','link' => ''.e(route('admin.users.mobile.unverified')).'','icon' => 'las la-comment-slash','title' => 'Mobile Unverified Users','value' => ''.e($widget['mobile_unverified_users']).'','bg' => 'warning']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $attributes = $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $component = $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
        </div><!-- dashboard-w1 end -->
    </div><!-- row end-->

    <div class="row mt-2 gy-4">
        <div class="col-xxl-6">
            <div class="card box-shadow3 h-100">
                <div class="card-body">
                    <h5 class="card-title"><?php echo app('translator')->get('Deposits'); ?></h5>
                    <div class="widget-card-wrapper">

                        <div class="widget-card bg--success">
                            <a href="<?php echo e(route('admin.deposit.list')); ?>" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount"><?php echo e(showAmount($deposit['total_deposit_amount'])); ?></h6>
                                    <p class="widget-card-title"><?php echo app('translator')->get('Total Deposited'); ?></p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                        <div class="widget-card bg--warning">
                            <a href="<?php echo e(route('admin.deposit.pending')); ?>" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="fas fa-spinner"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount"><?php echo e($deposit['total_deposit_pending']); ?></h6>
                                    <p class="widget-card-title"><?php echo app('translator')->get('Pending Deposits'); ?></p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                        <div class="widget-card bg--danger">
                            <a href="<?php echo e(route('admin.deposit.rejected')); ?>" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="fas fa-ban"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount"><?php echo e($deposit['total_deposit_rejected']); ?></h6>
                                    <p class="widget-card-title"><?php echo app('translator')->get('Rejected Deposits'); ?></p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                        <div class="widget-card bg--primary">
                            <a href="<?php echo e(route('admin.deposit.list')); ?>" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="fas fa-percentage"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount"><?php echo e(showAmount($deposit['total_deposit_charge'])); ?></h6>
                                    <p class="widget-card-title"><?php echo app('translator')->get('Deposited Charge'); ?></p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6">
            <div class="card box-shadow3 h-100">
                <div class="card-body">
                    <h5 class="card-title"><?php echo app('translator')->get('Withdrawals'); ?></h5>
                    <div class="widget-card-wrapper">
                        <div class="widget-card bg--success">
                            <a href="<?php echo e(route('admin.withdraw.data.all')); ?>" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="lar la-credit-card"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount"><?php echo e(showAmount($withdrawals['total_withdraw_amount'])); ?></h6>
                                    <p class="widget-card-title"><?php echo app('translator')->get('Total Withdrawn'); ?></p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                        <div class="widget-card bg--warning">
                            <a href="<?php echo e(route('admin.withdraw.data.pending')); ?>" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="fas fa-spinner"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount"><?php echo e($withdrawals['total_withdraw_pending']); ?></h6>
                                    <p class="widget-card-title"><?php echo app('translator')->get('Pending Withdrawals'); ?></p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                        <div class="widget-card bg--danger">
                            <a href="<?php echo e(route('admin.withdraw.data.rejected')); ?>" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="las la-times-circle"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount"><?php echo e($withdrawals['total_withdraw_rejected']); ?></h6>
                                    <p class="widget-card-title"><?php echo app('translator')->get('Rejected Withdrawals'); ?></p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                        <div class="widget-card bg--primary">
                            <a href="<?php echo e(route('admin.withdraw.data.all')); ?>" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="las la-percent"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount"><?php echo e(showAmount($withdrawals['total_withdraw_charge'])); ?></h6>
                                    <p class="widget-card-title"><?php echo app('translator')->get('Withdrawal Charge'); ?></p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row gy-4 mt-2">
        <div class="col-xxl-3 col-lg-4 col-sm-6">
            <?php if (isset($component)) { $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget','data' => ['style' => '5','link' => ''.e(route('admin.report.lottery.ticket')).'','icon' => 'las la-money-bill','title' => 'Sold Tickets','value' => ''.e($widget['sold_ticket']).'','bg' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => '5','link' => ''.e(route('admin.report.lottery.ticket')).'','icon' => 'las la-money-bill','title' => 'Sold Tickets','value' => ''.e($widget['sold_ticket']).'','bg' => 'primary']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $attributes = $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $component = $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-lg-4 col-sm-6">
            <?php if (isset($component)) { $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget','data' => ['style' => '5','link' => '#','icon' => 'las la-money-bill-alt','title' => 'Sold Amounts','value' => ''.e(showAmount($widget['sold_amount'])).'','bg' => 'warning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => '5','link' => '#','icon' => 'las la-money-bill-alt','title' => 'Sold Amounts','value' => ''.e(showAmount($widget['sold_amount'])).'','bg' => 'warning']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $attributes = $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $component = $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-lg-4 col-sm-6">
            <?php if (isset($component)) { $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget','data' => ['style' => '5','link' => ''.e(route('admin.report.winners')).'','icon' => 'las la-medal','title' => 'Winners','value' => ''.e($widget['winners']).'','bg' => '2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => '5','link' => ''.e(route('admin.report.winners')).'','icon' => 'las la-medal','title' => 'Winners','value' => ''.e($widget['winners']).'','bg' => '2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $attributes = $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $component = $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-lg-4 col-sm-6">
            <?php if (isset($component)) { $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget','data' => ['style' => '5','link' => ''.e(route('admin.report.winners')).'','icon' => 'las la-dollar-sign','title' => 'Win Amounts','value' => ''.e(showAmount($widget['win_bonus'])).'','bg' => '3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => '5','link' => ''.e(route('admin.report.winners')).'','icon' => 'las la-dollar-sign','title' => 'Win Amounts','value' => ''.e(showAmount($widget['win_bonus'])).'','bg' => '3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $attributes = $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $component = $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
        </div><!-- dashboard-w1 end -->

    </div><!-- row end-->



    <div class="row mb-none-30 mt-30">
        <div class="col-xl-6 mb-30">
            <div class="card">
              <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between">
                    <h5 class="card-title"><?php echo app('translator')->get('Deposit & Withdraw Report'); ?></h5>

                    <div id="dwDatePicker" class="border p-1 cursor-pointer rounded">
                        <i class="la la-calendar"></i>&nbsp;
                        <span></span> <i class="la la-caret-down"></i>
                    </div>
                </div>
                <div id="dwChartArea"> </div>
              </div>
            </div>
          </div>
        <div class="col-xl-6 mb-30">
            <div class="card">
              <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between">
                    <h5 class="card-title"><?php echo app('translator')->get('Transactions Report'); ?></h5>

                    <div id="trxDatePicker" class="border p-1 cursor-pointer rounded">
                        <i class="la la-calendar"></i>&nbsp;
                        <span></span> <i class="la la-caret-down"></i>
                    </div>
                </div>

                <div id="transactionChartArea"></div>
              </div>
            </div>
        </div>
    </div>

    <div class="row mb-none-30 mt-5">
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <h5 class="card-title"><?php echo app('translator')->get('Login By Browser'); ?> (<?php echo app('translator')->get('Last 30 days'); ?>)</h5>
                    <canvas id="userBrowserChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo app('translator')->get('Login By OS'); ?> (<?php echo app('translator')->get('Last 30 days'); ?>)</h5>
                    <canvas id="userOsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo app('translator')->get('Login By Country'); ?> (<?php echo app('translator')->get('Last 30 days'); ?>)</h5>
                    <canvas id="userCountryChart"></canvas>
                </div>
            </div>
        </div>
    </div>



    <?php echo $__env->make('admin.partials.cron_modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('breadcrumb-plugins'); ?>
    <button class="btn btn-outline--primary btn-sm" data-bs-toggle="modal" data-bs-target="#cronModal">
        <i class="las la-server"></i><?php echo app('translator')->get('Cron Setup'); ?>
    </button>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/admin/js/vendor/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/js/vendor/chart.js.2.8.0.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/js/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/js/daterangepicker.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/js/charts.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/admin/css/daterangepicker.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";

        const start = moment().subtract(14, 'days');
        const end = moment();

        const dateRangeOptions = {
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 15 Days': [moment().subtract(14, 'days'), moment()],
                'Last 30 Days': [moment().subtract(30, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Last 6 Months': [moment().subtract(6, 'months').startOf('month'), moment().endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')],
            },
            maxDate: moment()
        }

        const changeDatePickerText = (element, startDate, endDate) => {
            $(element).html(startDate.format('MMMM D, YYYY') + ' - ' + endDate.format('MMMM D, YYYY'));
        }

        let dwChart = barChart(
            document.querySelector("#dwChartArea"),
            <?php echo json_encode(__(gs('cur_text')), 15, 512) ?>,
            [{
                    name: 'Deposited',
                    data: []
                },
                {
                    name: 'Withdrawn',
                    data: []
                }
            ],
            [],
        );

        let trxChart = lineChart(
            document.querySelector("#transactionChartArea"),
            [{
                    name: "Plus Transactions",
                    data: []
                },
                {
                    name: "Minus Transactions",
                    data: []
                }
            ],
            []
        );


        const depositWithdrawChart = (startDate, endDate) => {

            const data = {
                start_date: startDate.format('YYYY-MM-DD'),
                end_date: endDate.format('YYYY-MM-DD')
            }

            const url = <?php echo json_encode(route('admin.chart.deposit.withdraw'), 15, 512) ?>;

            $.get(url, data,
                function(data, status) {
                    if (status == 'success') {
                        dwChart.updateSeries(data.data);
                        dwChart.updateOptions({
                            xaxis: {
                                categories: data.created_on,
                            }
                        });
                    }
                }
            );
        }

        const transactionChart = (startDate, endDate) => {

            const data = {
                start_date: startDate.format('YYYY-MM-DD'),
                end_date: endDate.format('YYYY-MM-DD')
            }

            const url = <?php echo json_encode(route('admin.chart.transaction'), 15, 512) ?>;


            $.get(url, data,
                function(data, status) {
                    if (status == 'success') {


                        trxChart.updateSeries(data.data);
                        trxChart.updateOptions({
                            xaxis: {
                                categories: data.created_on,
                            }
                        });
                    }
                }
            );
        }



        $('#dwDatePicker').daterangepicker(dateRangeOptions, (start, end) => changeDatePickerText('#dwDatePicker span', start, end));
        $('#trxDatePicker').daterangepicker(dateRangeOptions, (start, end) => changeDatePickerText('#trxDatePicker span', start, end));

        changeDatePickerText('#dwDatePicker span', start, end);
        changeDatePickerText('#trxDatePicker span', start, end);

        depositWithdrawChart(start, end);
        transactionChart(start, end);

        $('#dwDatePicker').on('apply.daterangepicker', (event, picker) => depositWithdrawChart(picker.startDate, picker.endDate));
        $('#trxDatePicker').on('apply.daterangepicker', (event, picker) => transactionChart(picker.startDate, picker.endDate));

        piChart(
            document.getElementById('userBrowserChart'),
            <?php echo json_encode(@$chart['user_browser_counter']->keys(), 15, 512) ?>,
            <?php echo json_encode(@$chart['user_browser_counter']->flatten(), 15, 512) ?>
        );

        piChart(
            document.getElementById('userOsChart'),
            <?php echo json_encode(@$chart['user_os_counter']->keys(), 15, 512) ?>,
            <?php echo json_encode(@$chart['user_os_counter']->flatten(), 15, 512) ?>
        );

        piChart(
            document.getElementById('userCountryChart'),
            <?php echo json_encode(@$chart['user_country_counter']->keys(), 15, 512) ?>,
            <?php echo json_encode(@$chart['user_country_counter']->flatten(), 15, 512) ?>
        );
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('style'); ?>
    <style>
        .apexcharts-menu {
            min-width: 120px !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\betzono.com\core\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>