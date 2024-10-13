<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Assign Permissions to Role: <?php echo e($role->name); ?></h3>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('roles.permissions.update', $role->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="form-group mb-3">
                        <label for="permissions">Select Permissions</label>
                        <select id="permissions" name="permissions[]" class="form-control" multiple>
                            <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($permission->id); ?>"
                                    <?php echo e($role->hasPermissionTo($permission->name) ? 'selected' : ''); ?>>
                                    <?php echo e($permission->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Assign Permissions</button>
                    <a href="<?php echo e(route('roles.index')); ?>" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

<?php $__env->startSection('scripts'); ?>
    <script>
        // Optional: Initialize a select2 or similar plugin if you want nicer UI
        $(document).ready(function() {
            $('#permissions').select2({
                placeholder: "Select permissions",
                allowClear: true
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/roles/assign-permissions.blade.php ENDPATH**/ ?>