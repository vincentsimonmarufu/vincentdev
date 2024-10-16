<?php $__env->startSection('content'); ?>
<main id="main">
<!-- BreadCrumb Starts -->
<section class="breadcrumb-main pb-0 pt-20" style="background: #000;">
  <div class="breadcrumb-outer">
      <div class="container">
          <div class="breadcrumb-content d-md-flex align-items-center pt-6">
              <h1 class="mb-0">Shuttle Hire</h1>
              <nav aria-label="breadcrumb">
                  <ul class="breadcrumb d-flex justify-content-center">
                      <li class="breadcrumb-item"><a href="<?php echo e(route('welcome')); ?>">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Shuttle Hire</li>
                  </ul>
              </nav>
          </div>
      </div>
  </div>
  <div class="dot-overlay"></div>
  <br/>
</section>
<!-- BreadCrumb Ends -->
<section class="blog trending">
  <div class="container">
      <div class="listing-main listing-main1">
        <!-- start saerch bar -->
        <?php echo $__env->make('shuttle_search_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>   
        <!-- end of saerch bar -->
          <div class="trend-box">
              <div class="list-results d-flex align-items-center justify-content-between">
                  <div class="list-results-sort">
                    <?php if($shuttles->count() > 0): ?>
                    <p class="m-0">Showing <?php echo e(($shuttles->currentpage()-1)*$shuttles->perpage()+1); ?> to <?php echo e($shuttles->currentpage()*$shuttles->perpage()); ?>

                        of  <?php echo e($shuttles->total()); ?> results</p>
                       <?php else: ?>
                       <p class="m-0 text-danger">Showing 0 results</p>
                    <?php endif; ?>

                  </div>
              </div>
              <div class="row">
                <?php $__currentLoopData = $shuttles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shuttle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="target col-lg-4 col-md-6 mb-4"  id="target" >
                  <div class="trend-item box-shadow rounded" style="background: #ffffff; border-color: #ffffff; border:5em">
                      <div class="trend-image">
                      <?php if($shuttle->pictures->first()!==null && $shuttle->pictures->first()->path): ?>
                        <a href="<?php echo e(route('shuttle.view', $shuttle->id)); ?>">
                          <img src="<?php echo e(asset('storage/Shuttle/' . $shuttle->pictures->first()->path)); ?>" alt="<?php echo e($shuttle->model); ?>" loading="lazy" >
                        </a>
                        <?php endif; ?>
                      </div>
                      <div class="trend-content p-4">
                          <h5 class="theme"><?php echo e($shuttle->year); ?>  | <?php echo e($shuttle->make); ?></h5>
                          <h4><a href="<?php echo e(route('shuttle.view', $shuttle->id)); ?>"><?php echo e($shuttle->model); ?></a></h4>
                          <div class="entry-meta d-flex align-items-center justify-content-between border-b pb-1 mb-2">
                              <div class="entry-author">
                                  <p>Start From<span class="d-block theme fw-bold">$<?php echo e(number_format($shuttle->price,2)); ?>/km</span></p>
                              </div>
                              <div class="entry-metalist d-flex align-items-center">
                                  <ul>
                                    <a href="<?php echo e(route('shuttle.view', $shuttle->id)); ?>">
                                      <li class="me-2 btn btn-success">Hire Now</li></a>
                                  </ul>
                              </div>
                          </div>
                          <p class="mb-0"><?php echo e($shuttle->name); ?> </p>

                      </div>
                      <ul class="d-flex align-items-center justify-content-between p-3 px-4" style="background: rgb(14, 135, 42)">
                          <li class="me-2" style="color: rgb(226, 250, 232)"><i class="fa fa-eye"></i> <?php echo e($shuttle->fuel_type); ?></li>
                          <li class="me-2" style="color: rgb(226, 250, 232)"><i class="fa fa-heart"></i> <?php echo e($shuttle->seater); ?> seater</li>
                      </ul>
                  </div>
              </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

              </div>

              <div class="pagination-main text-center">

                    <?php echo e($shuttles->onEachSide(1)->links()); ?>


              </div>
          </div>
      </div>
  </div>
</section>

<!-- cars Ends -->


</main><!-- End #main -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
        $(document).ready(function() {
            $('#mySelect1').select2();
            $('#mySelect2').select2();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/shuttle_hire.blade.php ENDPATH**/ ?>