<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>All users</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" data-order='[[ 0, "asc" ]]' class="table table-striped table-bordered table-hover">
                        <thead>
                            <th>Surname</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($user->surname); ?></td>
                                <td><?php echo e($user->name); ?></td>
                                <td><?php echo e($user->phone); ?></td>
                                <td><?php echo e($user->email); ?></td>
                                <td><?php echo e($user->role); ?></td>
                                <td>
                                    <a href="<?php echo e(route('users.verify', $user->id)); ?>" class="btn btn-success">Verify</a>
                                    <a href="<?php echo e(route('users.show', $user->id)); ?>" class="btn btn-info">View</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->startSection('scripts'); ?>
 <script type="text/javascript">
$(document).ready(function () {
$('#dtBasicExample').DataTable();
});
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/users/index.blade.php ENDPATH**/ ?>