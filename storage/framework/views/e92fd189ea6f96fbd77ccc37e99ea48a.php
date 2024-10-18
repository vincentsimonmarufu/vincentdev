<?php $__env->startSection('content'); ?>
<style>
    .imagesize {
    width: 350px; 
    height: 200px; 
    margin: 0 auto; 
    overflow: hidden;
    }

    .imagesize img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .more-link {
        color: blue;
        cursor: pointer;
    }  
    </style>
<main id="main">
  <!-- BreadCrumb Starts -->  
  <section class="breadcrumb-main pb-0 pt-20" style="background: #000;">
    <div class="breadcrumb-outer">
        <div class="container">
            <div class="breadcrumb-content d-md-flex align-items-center pt-6">
                <h1 class="mb-0">Apartments</h1>
                <nav aria-label="breadcrumb">
                    <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('welcome')); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Apartments</li>
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
        <?php echo $__env->make('search_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          
      <!-- end of saerch bar -->
          <div class="trend-box">
              <div class="list-results d-flex align-items-center justify-content-between">
                  <div class="list-results-sort">
                    <?php if($apartments->count() > 0): ?>
                    <p class="m-0">Showing <?php echo e(($apartments->currentpage()-1)*$apartments->perpage()+1); ?> to <?php echo e($apartments->currentpage()*$apartments->perpage()); ?>

                      of  <?php echo e($apartments->total()); ?> results</p>
                       <?php else: ?> 
                       <p class="m-0 text-danger">Showing 0 results</p>
                    <?php endif; ?>
                     
                  </div>
              </div>
              <div class="row">
                <?php $__currentLoopData = $apartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apartment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="target col-lg-4 col-md-6 mb-4"  id="target" >
                      <div class="trend-item box-shadow rounded" style="background: #ffffff; border-color: #ffffff; border:5em">
                          <div class="trend-image imagesize">
                            <?php if($apartment->pictures->first()!==null && $apartment->pictures->first()->path): ?>
                            <a href="<?php echo e(route('apartments.view', $apartment->id)); ?>">
                              <img src="<?php echo e(asset('storage/Apartment/' . $apartment->pictures->first()->path)); ?>"  alt="<?php echo e($apartment->address); ?>" loading="lazy">
                            <?php endif; ?>
                            </a>
                          </div>
                          <div class="trend-content p-4">
                              <h5 class="theme"><?php echo e($apartment->city); ?></h5>
                              <h4><a href="<?php echo e(route('apartments.view', $apartment->id)); ?>"><?php echo e($apartment->name); ?></a></h4>
                              <div class="entry-meta d-flex align-items-center justify-content-between border-b pb-1 mb-2">
                                  <div class="entry-author">
                                      <p>Start From<span class="d-block theme fw-bold">$<?php echo e(number_format($apartment->price,2)); ?>/Night</span></p>
                                      
                                  </div>
                                  <div class="entry-metalist d-flex align-items-center">
                                      <ul>
                                        <a href="<?php echo e(route('apartments.view', $apartment->id)); ?>">
                                          <li class="me-2 btn btn-success">Book Now</li></a>
                                      </ul>
                                  </div>
                              </div>
                              
                              <p style="height: 40px !important;">             
                                        <?php if(strlen($apartment->address) > 50): ?>
                                            <?php
                                                $addressId = 'address_' . uniqid(); // Generate a unique ID for the address
                                            ?>
                                            <span id="<?php echo e($addressId); ?>" class="address-text">
                                                <?php echo e(substr($apartment->address, 0, 50)); ?>

                                                <span id="<?php echo e($addressId); ?>_more_text" class="more-text" style="display: none;"><?php echo e(substr($apartment->address, 50)); ?></span>
                                                <a href="#" class="more-link" data-toggle="more-less" data-target="<?php echo e($addressId); ?>">More</a>
                                            </span>
                                            <script>
                                                // JavaScript to handle the "More" link toggle
                                                document.addEventListener('DOMContentLoaded', function () {
                                                    const moreLink = document.querySelector('[data-toggle="more-less"][data-target="<?php echo e($addressId); ?>"]');
                                                    const moreText = document.getElementById('<?php echo e($addressId); ?>_more_text');
                                                    const addressContainer = document.getElementById('<?php echo e($addressId); ?>').parentElement;

                                                    if (moreLink && moreText) {
                                                        moreLink.addEventListener('click', function (e) {
                                                            e.preventDefault();
                                                            moreText.style.display = (moreText.style.display === 'none') ? 'inline' : 'none';
                                                            moreLink.textContent = (moreText.style.display === 'none') ? 'More' : 'Less';
                                                            
                                                            // Update height of parent <p> based on content visibility
                                                            if (moreText.style.display === 'none') {
                                                                addressContainer.style.height = '40px'; // Default height
                                                            } else {
                                                                addressContainer.style.height = 'auto'; // Expand to fit content
                                                            }
                                                        });
                                                    }
                                                });
                                            </script>
                                        <?php else: ?>
                                            <span class="address-text"><?php echo e($apartment->address); ?></span>
                                        <?php endif; ?>
                                    </p>
                              
                          </div>
                          <ul class="d-flex align-items-center justify-content-between  p-3 px-4" style="background: rgb(14, 135, 42)">
                              <li class="me-2"  style="color: rgb(226, 250, 232)"><i class="fa fa-eye"></i> <?php echo e($apartment->bedroom); ?> Bedroom(s)</li>
                              <li class="me-2"  style="color: rgb(226, 250, 232)"><i class="fa fa-heart"></i> <?php echo e($apartment->bathroom); ?> Bathroom(s)</li>
                          </ul>
                      </div>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  

              </div>              
              <div class="pagination svg offset-md-3">                     
                  <?php echo e($apartments->onEachSide(1)->links('custom-pagination')); ?>                            
              </div>
          </div>
      </div>
  </div>
</section>
<!-- blog Ends -->  


</main><!-- End #main -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
  $('.testimonial-pics img').click(function () {
      $('.testimonial-pics img').removeClass("active");
      $(this).addClass("active");

      $(".testimonial").removeClass("active");
      $("#" + $(this).attr("alt")).addClass("active");
    });
</script>
<script>
 function myFunction() {
  var input = document.getElementById("Search");
  var filter = input.value.toLowerCase();
  var nodes = document.getElementsByClassName('target');

  for (i = 0; i < nodes.length; i++) {
    if (nodes[i].innerText.toLowerCase().includes(filter)) {
      nodes[i].style.display = "block";
    } else {
      nodes[i].style.display = "none";
    }
  }
}

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/apartments.blade.php ENDPATH**/ ?>