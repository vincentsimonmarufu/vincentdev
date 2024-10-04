<?php $__env->startSection('content'); ?>
<div class="container justify-content-center">
    <div class="row  mb-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header ">Dashboard</div>
                <?php if($apartments->count() > 0 || $vehicles->count() > 0): ?>
                <div class="alert alert-warning" role="alert">
                    We charge 10% for every approved vehicle or apartment booking
                </div>
                <?php endif; ?>
                <div class="card-body">
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
    <?php if($apartments->count() > 0): ?>
    <div class="mb-2">
        <h3>Your Apartments</h3>
        <div class="row">
            <?php $__currentLoopData = $apartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apartment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card col-lg-12">
                <div class="card-header">
                    <p>Owner: <?php echo e($apartment->name); ?></p>
                    <p>Address: <?php echo e($apartment->address); ?></p>
                    <p>City: <?php echo e($apartment->city); ?></p>
                </div>
                <div class="card-body">
                    <?php if($apartment->bookings->count() > 0): ?>
                    <table id="example" class="table table-bordered table-striped table-hover">
                        <thead>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $apartment->bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($booking->pivot->start_date); ?></td>
                                <td><?php echo e($booking->pivot->end_date); ?></td>
                                <td><?php echo e($booking->pivot->status); ?></td>
                                <td>
                                    <?php if($booking->pivot->status == 'Awaiting Approval'): ?>
                                    <a href="<?php echo e(route('bookable.status', [$booking->pivot->id, 'Approved'])); ?>" class="btn btn-primary">Approve</a>
                                    <a href="<?php echo e(route('bookable.status', [$booking->pivot->id, 'Decline'])); ?>" class="btn btn-danger btn-sm">Decline</a>
                                    <?php endif; ?>
                                    <?php if($booking->pivot->status == 'Approved'): ?>
                                    <a href="<?php echo e(route('bookable.status', [$booking->pivot->id, 'Checked In'])); ?>" class="btn btn-primary">Check In</a>
                                    <a href="<?php echo e(route('bookable.status', [$booking->pivot->id, 'Decline'])); ?>" class="btn btn-danger btn-sm">Unbook</a>
                                    <?php endif; ?>
                                    <?php if($booking->pivot->status == 'Checked In'): ?>
                                    <a href="<?php echo e(route('bookable.status', [$booking->pivot->id, 'Checked Out'])); ?>" class="btn btn-primary">Check Out</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <p class="text-info">There are no bookings yet!</p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if($vehicles->count() > 0): ?>
    <div class="mb-2">
        <h3>Your Vehicles</h3>
        <div class="row">
            <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card col-lg-12">
                <div class="card-header">
                    <p>Make: <?php echo e($vehicle->make); ?></p>
                    <p>Model: <?php echo e($vehicle->model); ?></p>
                    <p>Address: <?php echo e($vehicle->address); ?></p>
                    <p>City: <?php echo e($vehicle->city); ?></p>
                </div>
                <div class="card-body">
                    <?php if($vehicle->bookings->count() > 0): ?>
                    <table id="dtBasicExample" class="table table-bordered table-striped table-hover">

                        <thead>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $vehicle->bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($booking->pivot->start_date); ?></td>
                                <td><?php echo e($booking->pivot->end_date); ?></td>
                                <td><?php echo e($booking->pivot->status); ?></td>
                                <td>
                                    <?php if($booking->pivot->status == 'Awaiting Approval'): ?>
                                    <a href="<?php echo e(route('bookable.status', [$booking->pivot->id, 'Approved'])); ?>" class="btn btn-primary">Approve</a>
                                    <a href="<?php echo e(route('bookable.status', [$booking->pivot->id, 'Decline'])); ?>" class="btn btn-danger">Decline</a>
                                    <?php endif; ?>
                                    <?php if($booking->pivot->status == 'Approved'): ?>
                                    <a href="<?php echo e(route('bookable.status', [$booking->pivot->id, 'Checked In'])); ?>" class="btn btn-primary">Check In</a>
                                    <a href="<?php echo e(route('bookable.status', [$booking->pivot->id, 'Decline'])); ?>" class="btn btn-danger">Unbook</a>
                                    <?php endif; ?>
                                    <?php if($booking->pivot->status == 'Checked In'): ?>
                                    <a href="<?php echo e(route('bookable.status', [$booking->pivot->id, 'Checked Out'])); ?>" class="btn btn-primary">Check Out</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <p class="text-info">There are no bookings yet!</p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if($buses->count() > 0): ?>
    <div class="mb-2">
        <h3>Your Buses</h3>
        <div class="row">
            <?php $__currentLoopData = $buses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card col-lg-12">
                <div class="card-header">
                    <p>Make: <?php echo e($bus->make); ?></p>
                    <p>Model: <?php echo e($bus->model); ?></p>
                    <p>Address: <?php echo e($bus->address); ?></p>
                    <p>City: <?php echo e($bus->city); ?></p>
                </div>
                <div class="card-body">
                    <?php if($bus->bookings->count() > 0): ?>
                    <table id="dtBasicExample" class="table table-bordered table-striped table-hover">

                        <thead>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $bus->bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($booking->pivot->start_date); ?></td>
                                <td><?php echo e($booking->pivot->end_date); ?></td>
                                <td><?php echo e($booking->pivot->status); ?></td>
                                <td>
                                    <?php if($booking->pivot->status == 'Awaiting Approval'): ?>
                                    <a href="<?php echo e(route('bookable.status', [$booking->pivot->id, 'Approved'])); ?>" class="btn btn-primary">Approve</a>
                                    <a href="<?php echo e(route('bookable.status', [$booking->pivot->id, 'Decline'])); ?>" class="btn btn-danger">Decline</a>
                                    <?php endif; ?>
                                    <?php if($booking->pivot->status == 'Approved'): ?>
                                    <a href="<?php echo e(route('bookable.status', [$booking->pivot->id, 'Checked In'])); ?>" class="btn btn-primary">Check In</a>
                                    <a href="<?php echo e(route('bookable.status', [$booking->pivot->id, 'Decline'])); ?>" class="btn btn-danger">Unbook</a>
                                    <?php endif; ?>
                                    <?php if($booking->pivot->status == 'Checked In'): ?>
                                    <a href="<?php echo e(route('bookable.status', [$booking->pivot->id, 'Checked Out'])); ?>" class="btn btn-primary">Check Out</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <p class="text-info">There are no bookings yet!</p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
    <?php if($shuttles->count() > 0): ?>
    <div class="mb-2">
        <h3>Your Shuttles</h3>
        <div class="row">
            <?php $__currentLoopData = $shuttles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shuttle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card col-lg-12">
                <div class="card-header">
                    <p>Make: <?php echo e($shuttle->make); ?></p>
                    <p>Model: <?php echo e($shuttle->model); ?></p>
                    <p>Address: <?php echo e($shuttle->address); ?></p>
                    <p>City: <?php echo e($shuttle->city); ?></p>
                </div>
                <div class="card-body">
                    <?php if($shuttle->bookings->count() > 0): ?>
                    <table id="dtBasicExample" class="table table-bordered table-striped table-hover">

                        <thead>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $shuttle->bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($booking->pivot->start_date); ?></td>
                                <td><?php echo e($booking->pivot->end_date); ?></td>
                                <td><?php echo e($booking->pivot->status); ?></td>
                                <td>
                                    <?php if($booking->pivot->status == 'Awaiting Approval'): ?>
                                    <a href="<?php echo e(route('bookable.status', [$booking->pivot->id, 'Approved'])); ?>" class="btn btn-primary">Approve</a>
                                    <a href="<?php echo e(route('bookable.status', [$booking->pivot->id, 'Decline'])); ?>" class="btn btn-danger">Decline</a>
                                    <?php endif; ?>
                                    <?php if($booking->pivot->status == 'Approved'): ?>
                                    <a href="<?php echo e(route('bookable.status', [$booking->pivot->id, 'Checked In'])); ?>" class="btn btn-primary">Check In</a>
                                    <a href="<?php echo e(route('bookable.status', [$booking->pivot->id, 'Decline'])); ?>" class="btn btn-danger">Unbook</a>
                                    <?php endif; ?>
                                    <?php if($booking->pivot->status == 'Checked In'): ?>
                                    <a href="<?php echo e(route('bookable.status', [$booking->pivot->id, 'Checked Out'])); ?>" class="btn btn-primary">Check Out</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <p class="text-info">There are no bookings yet!</p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dtBasicExample').DataTable();

    });
</script>
<script type="text/javascript">
    $(document).ready(function() {

        $('#example').DataTable();
    });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/home.blade.php ENDPATH**/ ?>