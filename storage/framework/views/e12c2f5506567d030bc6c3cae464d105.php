<form action="<?php echo e(route('search')); ?>" method="POST" class=" form-find d-lg-flex justify-content-between search_custom  borderall mb-4" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
      <div class="form-group me-2 ">
          <div class="input-box">
            <input class="form-control" type="text" name="keyword" placeholder="Search keyword here ..." required/>
          </div>
      </div>
      <div class="form-group me-2">
          <div class="input-box">
              <select class="niceSelect fw-bold" name="type">
                  <option selected disabled>Select type here</option>
                  <option value="apartment" >Apartment</option>
                  <option value="vehicle">Car</option>
                  <option value="bus" >Bus</option>
                  <option value="shuttle" >Shuttle</option>
                  <option value="flight">Flight</option>
              </select>
          </div>
      </div>

      <div class="form-group text-center w-100">
          <input type="submit" class="nir-btn w-100" id="submit3" value="Search">
      </div>
</form>
<?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/search_form.blade.php ENDPATH**/ ?>