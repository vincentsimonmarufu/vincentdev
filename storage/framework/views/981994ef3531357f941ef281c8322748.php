<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="card">

        <div class="card-header">
            <h3>All vehicles</h3>
        </div>
        <?php if( $vehicles->count() > 0): ?>
        <div class="alert alert-warning" role="alert">
            We charge 10% for every approved vehicle or apartment booking
        </div>
        <?php endif; ?>
        <div class="card-footer">
            <a class="btn btn-dark" href="<?php echo e(route('vehicles.create')); ?>">Create</a>
        </div>
        <div class="card-body">

            <div class="table-reponsive">
                <table id="example2" data-order='[[ 0, "asc" ]]' class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Fullname</th>
                            <th>Country</th>
                            <th>Make</th>
                            <th>Model</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($vehicles->count() > 0): ?>
                        <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($vehicle->user->name .' '.$vehicle->user->surname); ?><br />
                                <small><?php echo e($vehicle->user->email); ?> <br /> <?php echo e($vehicle->user->phone); ?></small>
                            </td>
                            <td><?php echo e($vehicle->country); ?></td>
                            <td><?php echo e($vehicle->make); ?></td>
                            <td><?php echo e($vehicle->model); ?></td>
                            <td><?php echo e($vehicle->price); ?></td>
                            <td><?php echo e($vehicle->status); ?></td>
                            <td>
                                <?php if(Auth::user()->role == 'admin'): ?>
                                <a href="<?php echo e(route('vehicle.activate', $vehicle->id)); ?>" class="btn btn-info">Activate</a>
                                <?php endif; ?>
                                <a href="<?php echo e(route('vehicles.show', $vehicle->id)); ?>" class="btn btn-success btn-sm">View</a>
                                <a href="<?php echo e(route('vehicles.edit', $vehicle->id)); ?>" class="btn btn-primary btn-sm">Edit</a>
                                <?php echo Form::open(['action'=>['App\Http\Controllers\VehicleController@destroy', $vehicle->id], 'method'=>'DELETE']); ?>

                                <?php echo e(Form::submit('Delete', ['class'=>'btn btn-danger btn-sm'])); ?>

                                <?php echo Form::close(); ?>

                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
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
<?php echo $__env->make('layouts.auth.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/vehicles/index.blade.php ENDPATH**/ ?>