<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Edit Permission</h3>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('permissions.update', $permission->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="form-group mb-3">
                        <label for="name">Permission Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo e($permission->name); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Update Permission</button>
                    <a href="<?php echo e(route('permissions.index')); ?>" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/permissions/edit.blade.php ENDPATH**/ ?>