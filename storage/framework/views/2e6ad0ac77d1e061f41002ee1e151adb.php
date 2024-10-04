<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h1>My Flight(s)</h1>
            <?php if(Auth::user()->role != 'admin'): ?>
            <a class="btn btn-success" href="<?php echo e(route('flights.searching')); ?>">Book Flight</a>           
            <?php endif; ?>
        </div>
        <div class="card-body col-12">
            <div class="table-responsive">
                <table id="example2" data-order='[[ 0, "desc" ]]' class="table table-striped table-bordered table-hover">
                    <thead>
                        <th>Date</th>
                        <th>ID</th>
                        <th>Fullname</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Airline</th>
                        <th>Travel Class</th>
                        <th>Action</th>

                    </thead>
                    <tbody>
                        <?php if($flightRequests->count() > 0): ?>
                        <?php $__currentLoopData = $flightRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $flightRequest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($flightRequest->created_at); ?></td>
                            <td><?php echo e($flightRequest->id); ?></td>
                            <td><?php echo e($flightRequest->user->surname ?? 'Not found'); ?> <?php echo e($flightRequest->user->name ?? "Not found"); ?></td>
                            <td><?php echo e($flightRequest->departure); ?></td>
                            <td><?php echo e($flightRequest->arrival); ?></td>
                            <td><?php echo e($flightRequest->airline); ?></td>
                            <td><?php echo e($flightRequest->travel_class); ?></td>
                            <td>
                                <a href="<?php echo e(route('flightrequests.show', $flightRequest->id)); ?>" class="btn btn-primary btn-md">View</a>
                                &nbsp;
                                <?php if(Auth::user()->email == 'johnasegid@gmail.com'): ?>
                                <?php echo Form::open(['action'=>['App\Http\Controllers\FlightRequestController@destroy', $flightRequest->id], 'method'=>'DELETE']); ?>

                                <?php echo e(Form::submit('Delete', ['class'=>'btn btn-danger btn-sm'])); ?>

                                <?php echo Form::close(); ?>

                                <?php endif; ?>

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
<?php echo $__env->make('layouts.auth.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/flight_requests/index.blade.php ENDPATH**/ ?>