<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>All Booking Commisions</h3>
                <div class="alert alert-warning" role="alert" >
                    We charge 10% for every approved vehicle, apartments, airport shuttle, buses booking
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dtBasicExample" data-order='[[ 0, "desc" ]]' class="table table-bordered table-hover">
                        <thead>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Reference</th>
                            <th>Commission</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        
                        <tbody>
                        <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($payment->created_at); ?></td>
                                <td><?php echo e($payment->user->name); ?> <?php echo e($payment->user->surname); ?></td>
                               <td> <small><?php echo e($payment->user->email); ?></br>
                                <?php echo e($payment->user->phone); ?></small>
                                </td>
                                <td><?php echo e($payment->booking->reference); ?></td>
                                <td><?php echo e($payment->amount); ?></td>
                                <td><?php echo e($payment->status); ?></td>
                                <td>
                                <a class="btn btn-info btn-sm" href="<?php echo e(route('bookings.show', $payment->booking_id)); ?>">View</a>
                                     <?php if(Auth::user()->role == 'admin'): ?>
                                    <a href="<?php echo e(route('payments.status', $payment->id)); ?>" class="btn btn-success btn-sm">Mark as Paid</a>
                                    <?php endif; ?>
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
<?php echo $__env->make('layouts.auth.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/payments/index.blade.php ENDPATH**/ ?>