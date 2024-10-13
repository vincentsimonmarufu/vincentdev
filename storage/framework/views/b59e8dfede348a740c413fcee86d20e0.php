<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Add Permission</h3>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('permissions.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group mb-3">
                        <label for="name">Permission Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Permission</button>
                    <a href="<?php echo e(route('permissions.index')); ?>" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/permissions/create.blade.php ENDPATH**/ ?>