<?php $__env->startSection('content'); ?>
<main id="main">
  <!-- BreadCrumb Starts -->
  <section class="breadcrumb-main pb-0 pt-20" style="background: #000;">
    <div class="breadcrumb-outer">
      <div class="container">
        <div class="breadcrumb-content d-md-flex align-items-center pt-6">
          <h1 class="mb-0">Apartment Details</h1>
          <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?php echo e(route('welcome')); ?>">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Apartment Details</li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
    <div class="dot-overlay"></div>
    <br />
  </section>
  <!-- BreadCrumb Ends -->
  </section>
  <!-- blog starts -->
  <section class="blog">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="detail-maintitle border-b pb-4 mb-4">
            <div class="row align-items-center justify-content-between">
              <div class="col-lg-8">
                <div class="detail-maintitle-in">
                  <h2 class="mb-1"><?php echo e($apartment->name); ?></h2>
                  <p><i class="fa fa-map-marker-alt me-2"></i><?php echo e($apartment->address); ?></p>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="entry-price text-lg-end text-start">
                  <h3 class="mb-0"><span class="d-block theme fs-5 fw-normal">Start From</span> $<?php echo e(number_format($apartment->price,2)); ?></h3>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="blog-single">
            <div class="bigyapan mb-4">
              <div>
                <div class="sidebar-item mb-4 box-shadow p-4">
                  <h3>Listed By</h3>
                  <div class="author-news-content d-flex align-items-center">
                    <div class="author-content w-75 ps-4">
                      <h4 class="title mb-1"><a href="#"><?php echo e($apartment->user->name . ' '. $apartment->user->surname); ?></a></h4>
                      <!--<p class="mb-1"><?php echo e($apartment->user->phone); ?><br><?php echo e($apartment->user->email); ?></p>-->
                    </div>
                  </div>
                </div>

                <?php $__currentLoopData = $apartment->pictures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $picture): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <img src="<?php echo e(asset('storage/Apartment/' . $picture->path)); ?>" class="img-fluid" alt="Acommodation picture" style="margin-bottom: 10px !important;">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
          </div>
        </div>

        <!-- sidebar starts -->
        <div class="col-lg-4 col-md-12">
          <div class="sidebar-sticky">
            <div class="list-sidebar">

              <div class="sidebar-item mb-4 box-shadow p-4 text-centerb">
                <h3><b>Information</b></h3>
                <h4><?php echo e($apartment->name); ?></h4>
                <ul>
                  <li><strong>Category</strong>: Accommodation</li>
                  <li><strong>Address</strong>: <?php echo e($apartment->address); ?></li>
                  <li><strong>Location</strong>: <?php echo e($apartment->city); ?>, <?php echo e($apartment->country); ?></li>
                  <li><strong>Price</strong>: <span id="price"><?php echo e($apartment->price); ?></span>/night</li>
                  <li><strong>Specs & Utilities</strong>:
                    <ul>
                      <li><i class='bx bx-bath'></i><?php echo e($apartment->bathroom); ?> Bath</li>
                      <li><i class='bx bx-bed'></i><?php echo e($apartment->bedroom); ?> Bedroom</li>
                    </ul>
                  </li>
                </ul>

                <p class="text-center"><br>
                  <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                  <strong>Error!</strong>
                  <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </ul>
                </div>
                <?php endif; ?>
                <?php if($message = Session::get('success')): ?>
                <div class="alert alert-success alert-block">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  <strong><?php echo e($message); ?></strong>
                </div>
                <?php endif; ?>
                <?php echo Form::open(['action'=>['App\Http\Controllers\UserBookingController@store', '1']]); ?>

                <?php echo csrf_field(); ?>
                <?php if(auth()->user() == null): ?>
                <p>This will automatically create a new account for you. If you already have an account please <a href="<?php echo e(route('login.redirect', url()->full())); ?>">login here.</a></p>
                <div class="form-group">
                  <?php echo e(Form::text('name', null, ['class'=>'form-control', 'placeholder' => 'First Name', 'required'])); ?>

                </div>
                <div class="form-group">
                  <?php echo e(Form::text('surname', null, ['class'=>'form-control', 'placeholder'=>'Last Name', 'required'])); ?>

                </div>
                <div class="form-group">
                  <?php echo e(Form::text('phone', null, ['class'=>'form-control', 'placeholder'=>'Phone Number'])); ?>

                </div>
                <div class="form-group">
                  <?php echo e(Form::email('email', null, ['class'=>'form-control', 'placeholder'=>'Email'])); ?>

                </div>
                <div class="form-group">
                  <?php echo e(Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password', 'required'])); ?>

                </div>
                <div class="form-group">
                  <?php echo e(Form::password('password_confirmation', ['class'=>'form-control', 'placeholder'=>'Confirm Password', 'required'])); ?>

                </div>
                <?php endif; ?>
                <p class="text-info">Booking Details</p>
                <?php echo e(Form::hidden('bookable_type', 'Apartment')); ?>

                <?php echo e(Form::hidden('bookable_id', $apartment->id)); ?>

                <?php
                 $date = date('Y-m-d');
                 $maxDate = date('Y-m-d', strtotime('+1 year'));
                ?>
                <div class="form-group row">
                  <?php echo e(Form::label('start_date', 'From', ['class'=>'form-label col-sm-6 booking_date'])); ?>

                  <?php echo e(Form::date('start_date', null, ['id'=>'start_date', 'min'=>$date, 'max'=>'2025-01-01' ,'class'=>'form-control col-sm-6 booking_date', 'required', 'placeholder'=>'start date'])); ?>

                </div>
                <div class="form-group row">
                  <?php echo e(Form::label('end_date', 'To', ['class'=>'form-label col-sm-6 booking_date'])); ?>

                  <?php echo e(Form::date('end_date', null, ['id'=>'end_date', 'min'=>$date,'max'=>$maxDate , 'class'=>'form-control col-sm-6 booking_date', 'required', 'placeholder'=>'end date'])); ?>

                </div>
                <p class="text-success" id="total_price"></p>
                <?php echo e(Form::submit('Book Now', ['class'=>'btn btn-primary'])); ?>

                <?php echo Form::close(); ?>

                </p>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- blog Ends -->

</main>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
  $(document).ready(function() {
    $(".booking_date").change(function() {
      var start_date = $("#start_date").val();
      var end_date = $("#end_date").val();

      if (start_date == "" || end_date == "") {
        return false;
      }
      var dt1 = new Date(start_date);
      var dt2 = new Date(end_date);

      var time_difference = dt2.getTime() - dt1.getTime();
      var days = time_difference / (1000 * 60 * 60 * 24);
      var total_price = $("#price").text() * days;
      $("#total_price").text("You have selected " + days + " nights. Total Price is $" + total_price);
    });
  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/single-apartment.blade.php ENDPATH**/ ?>