<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3><?php echo e($user->name); ?> <?php echo e($user->surname); ?></h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Phone</th>
                            <th><?php echo e($user->phone); ?></th>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <th><?php echo e($user->email); ?></th>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <th><?php echo e($user->address); ?></th>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <th><?php echo e($user->country); ?></th>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <th><?php echo e($user->role); ?></th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/users/show.blade.php ENDPATH**/ ?>