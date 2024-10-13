<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Create Vehicles</h3>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                <?php echo Form::open(['action'=>'App\Http\Controllers\VehicleController@store', 'files'=>true]); ?>

                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <?php echo e(Form::text('name', null, ['id'=>'name', 'class'=>'form-control', 'required', 'placeholder'=>'Company Name / Owner Name'])); ?>


                </div>
                <div class="mb-3">
                    <?php echo e(Form::textarea('address', null, ['class'=>'form-control', 'required', 'placeholder'=>'Address', 'rows'=>'3'])); ?>

                </div>
                <div class="mb-3">
                    <?php echo e(Form::text('city', null, ['id'=>'city', 'class'=>'form-control', 'required', 'placeholder'=>'city'])); ?>

                </div>
                <div class="mb-3">
                    <?php echo e(Form::select('country', $countries , null, ['id'=>'country', 'class'=>'form-control single-select', 'required', 'placeholder'=>'country'])); ?>

                </div>
                <div class="mb-3">
                    <?php echo e(Form::text('make', null, ['class'=>'form-control', 'required', 'placeholder'=>'make'])); ?>

                </div>
                <div class="mb-3">
                    <?php echo e(Form::text('model', null, ['class'=>'form-control', 'required', 'placeholder'=>'model'])); ?>

                </div>
                <div class="mb-3">
                    <?php echo e(Form::number('year', null, ['class'=>'form-control', 'required', 'placeholder'=>'year', 'min' => '1000'])); ?>

                </div>
                <div class="mb-3">
                    <?php echo e(Form::number('engine_size', null, ['class'=>'form-control', 'placeholder'=>'engine_size'])); ?>

                </div>
                <div class="mb-3">
                    <?php echo e(Form::select('fuel_type', ['petrol'=>'petrol', 'diesel'=>'diesel', 'electric'=>'electric'] , null, ['class'=>'form-control', 'required', 'placeholder'=>'fuel type'])); ?>

                </div>
                <div class="mb-3">
                    <?php echo e(Form::number('weight', null, ['class'=>'form-control', 'placeholder'=>'weight'])); ?>

                </div>
                <div class="mb-3">
                    <?php echo e(Form::text('color', null, ['class'=>'form-control', 'required', 'placeholder'=>'Color'])); ?>

                </div>
                <div class="mb-3">
                    <?php echo e(Form::select('transmission', ['manual'=>'manual', 'automatic'=>'automatic'] , null, ['class'=>'form-control', 'required', 'placeholder'=>'Transmission'])); ?>

                </div>
                <div class="mb-3">
                    <?php echo e(Form::number('price', null, ['class'=>'form-control', 'required', 'placeholder'=>'price', 'step'=>'0.01'])); ?>

                </div>
                <div class="mb-3 row">
                    <?php echo e(Form::label('pictures[]', 'Pictures 300 * 300', ['class'=>'col-lg-12 col-form-label'])); ?>

                    <?php echo e(Form::file('pictures[]', ['multiple', 'accept'=>'image/*', 'required'])); ?><br>
                </div>
                <!--  <input type="file" name="pictures[]" id="file" accept="image/*" multiple />                    
                    </div> 
                    <input type="text" id="post_img_data" name="image_data_url[]"  accept="image/*" multiple>
                    <div class="img-preview"></div>
                    <div id="galleryImages"></div>
                    <div id="cropper">
                        <button type="button" class="cropImageBtn btn btn-danger" style="display:none;" id="cropImageBtn">Select and Crop Image</button>
    
                        <canvas id="cropperImg" width="0" height="0"></canvas>
                    </div>
                    <div id="imageValidate" class="text-danger"></div>-->
                <?php if(Auth::user()->role == 'admin'): ?>
                <div class="mb-3">
                    <?php echo e(Form::select('status', ['active'=>'active', 'inactive'=>'inactive'] , null, ['class'=>'form-control', 'required', 'placeholder'=>'select status'])); ?>

                </div>
                <?php else: ?>
                <?php echo e(Form::select('status', ['pending'=>'pending', 'inactive'=>'inactive'] , null, ['class'=>'form-control', 'required', 'placeholder'=>'select status'])); ?>

                <?php endif; ?>
                <?php echo e(Form::submit('Save', ['class'=>'btn btn-primary'])); ?>

                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
</div>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/vehicles/create.blade.php ENDPATH**/ ?>