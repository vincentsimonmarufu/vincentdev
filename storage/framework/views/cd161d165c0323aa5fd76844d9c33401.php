<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="card">
        <div class="card-header">
            <?php if(auth()->user()->id == $user->id): ?>
            <h3>My apartments</h3>
            <div class="alert alert-warning" role="alert">
                We charge 10% for every approved vehicle or apartment booking
            </div>
            <?php else: ?>
            <h3><?php echo e($user->name); ?> <?php echo e($user->suranme); ?> - Apartments</h3>
            <?php endif; ?>
        </div>
        <div class="card-footer">
            <a class="btn btn-dark" href="<?php echo e(route('users.apartments.create', auth()->user()->id)); ?>">Create</a>
        </div>
        <div class="card-body">
            <div class="table-reponsive">
                <table id="example2" data-order='[[ 0, "asc" ]]' class="table table-striped table-bordered table-hover">
                    <thead>
                        <th>Address</th>
                        <th>Guest</th>
                        <th>Beds</th>
                        <th>Baths</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $user->apartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apartment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($apartment->address); ?>,<br />
                                <small><?php echo e($apartment->city); ?>,</small>
                                <small><?php echo e($apartment->country); ?></small>
                            </td>
                            <td><?php echo e($apartment->guest); ?></td>
                            <td><?php echo e($apartment->bedroom); ?></td>
                            <td><?php echo e($apartment->bathroom); ?></td>
                            <td><?php echo e($apartment->price); ?></td>
                            <td><?php echo e($apartment->status); ?></td>
                            <td>
                                <a href="<?php echo e(route('apartments.show', $apartment->id)); ?>" class="btn btn-info btn-sm">View</a>
                                <a href="<?php echo e(route('apartments.edit', $apartment->id)); ?>" class="btn btn-success btn-sm">Edit</a>

                                <?php echo Form::open(['action'=>['App\Http\Controllers\ApartmentController@destroy', $apartment->id], 'method'=>'DELETE']); ?>

                                <?php echo e(Form::submit('Delete', ['class'=>'btn btn-danger btn-sm'])); ?>

                                <?php echo Form::close(); ?>

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
    $(document).ready(function() {
        $('#dtBasicExample').DataTable();
    });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/users/apartments/index.blade.php ENDPATH**/ ?>