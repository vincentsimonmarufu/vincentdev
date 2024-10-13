<?php $__env->startSection('content'); ?>

<main id="main">
  <style>
    nav > div > span .relative{
      display: none;
    }
  </style>
  <style>
    .imagesize {
    width: 350px; /* Set the desired width */
    height: 200px; /* Set the desired height */
    margin: 0 auto; /* Center the slider horizontally */
    }

    .imagesize img {
        width: 100%; /* Set the image width to fill the container */
        height: 100%; /* Set the image height to fill the container */
        object-fit: cover; /* Maintain aspect ratio while covering the container */
    }
</style>

  <!-- banner starts -->
  <section class="banner overflow-hidden">

    <div class="slider">
      <div class="swiper-container">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="slide-inner">
              <div class="slide-image" style="background-image:url(assets/img/banner2.webp)"></div>
              <div class="swiper-content">

                <?php echo $__env->make('flashnews', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('search_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

              </div>
              <div class="overlay"></div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- Add Arrows -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>

  </section>
  <!-- banner ends -->


  <!-- property Starts -->
  <section class="trending">
    <div class="container">
      <div class="section-title mb-6 pb-1 w-75 mx-auto text-center">
        <h2 class="m-0">More Featured <span>Properties</span></h2>
        <p>Wide range of properties.</p>
      </div>
      <div class="trend-box">
        <div class="row">
          <?php $__currentLoopData = $apartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apartment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

          <div class="col-lg-6 mb-4">
            <div class="trend-item box-shadow p-3" style="background: #ffffff;">
              <div class="row">
                <div class="col-lg-4 col-md-4 pe-0">
                  <div class="trend-image1">
                    <?php if($apartment->pictures->first()!==null && $apartment->pictures->first()->path): ?>
                    <a href="<?php echo e(route('apartments.view', $apartment->id)); ?>" style="background-image: url(<?php echo e(asset('storage/Apartment/' . $apartment->pictures->first()->path)); ?>);" alt="<?php echo e($apartment->address); ?>" loading="lazy"></a>                    
                    <?php endif; ?>                    
                  </div>
                </div>
                <div class="col-lg-8 col-md-8">
                  <div class="trend-content">
                    <h5 class="theme"><?php echo e($apartment->city); ?></h5>
                    <h4><a href="<?php echo e(route('apartments.view', $apartment->id)); ?>"><?php echo e($apartment->address); ?></a></h4>
                    <div class="entry-meta d-flex align-items-center justify-content-between pb-1">
                      <div class="entry-author">
                        <p>Start From<span class="d-block theme fw-bold">$<?php echo e(number_format($apartment->price,2)); ?>/Night</span></p>

                      </div>
                      <div class="entry-metalist d-flex align-items-center">
                        <ul>
                          <a href="<?php echo e(route('apartments.view', $apartment->id)); ?>">
                            <li class="me-2 btn btn-success">Book Now</li>
                          </a>
                        </ul>
                      </div>
                    </div>
                    <ul class="d-flex align-items-center justify-content-between border-t pt-2">
                      <li class="me-2"><i class="fa fa-eye"></i> <?php echo e($apartment->bedroom); ?> Bedroom(s)</li>
                      <li class="me-2"><i class="fa fa-heart"></i> <?php echo e($apartment->bathroom); ?> Bathroom(s)</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

          <div class="col-lg-12 text-center">
            <a href="<?php echo e(route('apartments.all')); ?>" class="nir-btn">Load More</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- property ends -->
  <br />
  <!-- CTA start -->
  <div class="content-line">
    <div class="container">
      <div class="content-line-inner bg-theme pb-6 pt-6 p-5">
        <div class="row d-md-flex align-items-center justify-content-between text-lg-start text-center">
          <div class="col-lg-9">
            <h2 class="mb-0 white">
              Looking for a holiday home?
            </h2>
            <p class="white">Are you looking for the best holiday home</p>
          </div>
          <div class="col-lg-3">
            <a href="<?php echo e(route('apartments.all')); ?>" class="nir-btn-black float-none float-lg-end">Find More Properties</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- CTA ends -->
  <!-- ======= cars Section ======= -->
  <?php if($vehicles->count() > 0): ?>
  <section class="blog trending">
    <div class="container">
      <div class="section-title mb-6 pb-1 w-75 mx-auto text-center">
        <h2 class="m-0">More Featured <span>Cars</span></h2>
        <p>Trusted by thousands</p>
      </div>
      <div class="listing-main listing-main1">
        <!-- end of saerch bar -->
        <div class="trend-box">
          <div class="row">
            <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="target col-lg-4 col-md-6 mb-4" id="target">
              <div class="trend-item box-shadow rounded" style="background: #ffffff; border-color: #ffffff; border:5em">
                <div class="trend-image imagesize">
                  <?php if($vehicle->pictures->first()!==null && $vehicle->pictures->first()->path): ?>
                  <a href="<?php echo e(route('car_hire.view', $vehicle->id)); ?>">
                    <img src="<?php echo e(asset('storage/Vehicle/' . $vehicle->pictures->first()->path)); ?>" alt="<?php echo e($vehicle->model); ?>" alt="image" loading="lazy">
                  </a>                 
                  <?php endif; ?>
                </div>
                <div class="trend-content p-4">
                  <h5 class="theme"> <a href="<?php echo e(route('car_hire.view', $vehicle->id)); ?>"><?php echo e($vehicle->name); ?>, <?php echo e($vehicle->make); ?></a></h5>
                  <h4><a href="<?php echo e(route('car_hire.view', $vehicle->id)); ?>"><?php echo e($vehicle->year); ?> <?php echo e($vehicle->model); ?> </a></h4>
                  <div class="entry-meta d-flex align-items-center justify-content-between border-b pb-1 mb-2">
                    <div class="entry-author">
                      <p>Start From<span class="d-block theme fw-bold">$<?php echo e(number_format($vehicle->price,2)); ?>/Day</span></p>

                    </div>
                    <div class="entry-metalist d-flex align-items-center">
                      <ul>
                        <a href="<?php echo e(route('car_hire.view', $vehicle->id)); ?>">
                          <li class="me-2 btn btn-success">Drive Now</li>
                        </a>
                      </ul>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="col-lg-12 text-center">
              <a href="<?php echo e(route('car_hire')); ?>" class="nir-btn">Load More</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php endif; ?>
  <!-- End cars Section -->
  <!-- flight action starts -->
  <section class="discount-action discount-action1 pb-0 pt-0">
    <div class="container">
      <div class="call-banner" style="background-image:url(assets/img/banner.webp);">
        <div class="row d-flex align-items-center">
          <div class="col-lg-7 col-md-8 p-0">
            <div class="call-banner-inner bg-theme1">
              <div class="trend-content-main">
                <div class="trend-content p-5">
                  <h5 class="mb-1 white">Wanna travel safely?</h5>
                  <h2 class="mb-4 white">Book a Flight, Save Time and Money with US!</h2>
                  <div class="section-btns d-flex align-items-center">
                    <a href="<?php echo e(route('flight')); ?>" class="nir-btn">Book a Flight <i class="fa fa-arrow-right white pl-1"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-5 col-md-4 p-0"></div>
        </div>
      </div>
    </div>
  </section>

  <br />
  <!-- ======= Our Clients Section ======= -->
  <section id="clients" class="clients" style="padding-top: 0px!important">
    <div class="container">

      <div class="section-title mb-6 pb-1 w-75 mx-auto text-center">
        <h2 class="m-0">Popular Airlines</h2>
        <p>Popular Airlines we are affiliated with.</p>
      </div>

      <div class="row no-gutters clients-wrap clearfix">

        <div class="col-lg-3 col-md-4 col-xs-6">
          <div class="client-logo">
            <img src="<?php echo e(asset('assets/img/partners/toppng.com-logo-iata-980x312.png')); ?>" class="img-fluid" alt="Emirates" loading="lazy">
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-xs-6">
          <div class="client-logo">
            <img src="assets/img/airlines/1.png" class="img-fluid" alt="Emirates" loading="lazy">
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-xs-6">
          <div class="client-logo">
            <img src="assets/img/airlines/2.png" class="img-fluid" alt="SAA" loading="lazy">
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-xs-6">
          <div class="client-logo">
            <img src="assets/img/airlines/3.png" class="img-fluid" alt="RwanAir" loading="lazy" loading="lazy">
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-xs-6">
          <div class="client-logo">
            <img src="assets/img/airlines/4.png" class="img-fluid" alt="Air Mauritius" loading="lazy">
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-xs-6">
          <div class="client-logo">
            <img src="assets/img/airlines/5.png" class="img-fluid" alt="Kenya Airways" loading="lazy">
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-xs-6">
          <div class="client-logo">
            <img src="assets/img/airlines/6.png" class="img-fluid" alt="Fastjet" loading="lazy">
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-xs-6">
          <div class="client-logo">
            <img src="assets/img/airlines/7.png" class="img-fluid" alt="Ethiopean Airways" loading="lazy">
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-xs-6">
          <div class="client-logo">
            <img src="assets/img/airlines/8.png" class="img-fluid" alt="Air Namibia" loading="lazy">
          </div>
        </div>

      </div>

    </div>
  </section>
  <!-- End Our Clients Section -->
  <!-- testomonial start -->
  <!--  <section class="testimonial pb-6 pt-9" style="background: #f6f6f6;">
      <div class="container">
          <div class="section-title mb-4 pb-1 w-75 mx-auto text-center">
              <h2 class="m-0">Good Reviews By <span>Clients</span></h2>
              <p>What our clients say about us:</p>
          </div>
          <div class="row review-slider">
              <div class="col-sm-4 item">
                  <div class="testimonial-item1 text-center">
                      <div class="details">
                          <p class="m-0">Easy to drive, all worked well, a/c very good. Since we rent for a month and need a large car,
                            we're happy each year to have a vehicle large enough for all our luggage.</p>
                      </div>
                      <div class="author-info mt-2">
                          <div class="author-title">
                              <h4 class="m-0 theme2">Jared </h4>
                              <span>Supervisor</span>
                          </div>
                      </div>
                      <i class="fa fa-quote-left mb-2"></i>
                  </div>
              </div>
              <div class="col-sm-4 item">
                  <div class="testimonial-item1 text-center">
                      <div class="details">
                          <p class="m-0">Great car, lovely helpful staff! So happy to be able to drop the car near my hotel instead of
                            having to go to the airport. Highly recommended company! Thank you!</p>
                      </div>
                      <div class="author-info mt-2">
                          <div class="author-title">
                              <h4 class="m-0 theme2">Clive</h4>
                              <span>Sr. Consultant</span>
                          </div>
                      </div>
                      <i class="fa fa-quote-left mb-2"></i>
                  </div>
              </div>
              <div class="col-sm-4 item">
                  <div class="testimonial-item1 text-center">
                      <div class="details">
                          <p class="m-0">Very satisfied with this rental. The representatives were professional and helpful.
                            The care rental area was easy to navigate and convenient to the terminal</p>
                      </div>
                      <div class="author-info mt-2">
                          <div class="author-title">
                              <h4 class="m-0 theme2">Jonathan </h4>
                              <span>Sales Manager</span>
                          </div>
                      </div>
                      <i class="fa fa-quote-left mb-2"></i>
                  </div>
              </div>
          </div>
      </div>
  </section>-->
  <!-- testimonial ends -->
</main><!-- End #main -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/welcome.blade.php ENDPATH**/ ?>