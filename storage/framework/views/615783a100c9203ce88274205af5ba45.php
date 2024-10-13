<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>All Roles</h3>
                <a href="<?php echo e(route('roles.create')); ?>" class="btn btn-primary">Add Role</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" data-order='[[ 0, "asc" ]]' class="table table-striped table-bordered table-hover">
                        <thead>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Date Created</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($role->id); ?></td>
                                    <td><?php echo e($role->name); ?></td>
                                    <td><?php echo e($role->created_at); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('roles.permissions.edit', $role->id)); ?>"
                                            class="btn btn-info">Assign Permissions</a>
                                        <a href="<?php echo e(route('roles.edit', $role->id)); ?>" class="btn btn-success">Edit</a>
                                        <form action="<?php echo e(route('roles.destroy', $role->id)); ?>" method="POST"
                                            style="display: inline;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this role: <?php echo e($role->name); ?>?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/roles/index.blade.php ENDPATH**/ ?>