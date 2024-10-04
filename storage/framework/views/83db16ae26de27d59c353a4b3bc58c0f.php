<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create Your Account</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h4 class="text-center">Register</h4>
            <!-- Placeholder for success message -->
            <div id="successMessage" class="alert alert-success d-none" role="alert"></div>
            <?php echo Form::open([ 'route' => 'modal-register', 'id' => 'registerForm','method' => 'POST', 'class' => 'text-left clearfix']); ?>

            
                <div class="form-group">
                    <?php echo e(Form::text('name', null, ['class'=>'form-control', 'placeholder' => 'First Name', 'required'])); ?>

                </div>
                <div class="form-group">
                    <?php echo e(Form::text('surname', null, ['class'=>'form-control', 'placeholder'=>'Last Name', 'required'])); ?>

                </div>
                <div class="form-group tel_edit">
                    <input  name="phone" type="tel" class="form-control" id="phone"   placeholder="772123123" style="width: 100%" required>
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
                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" id="" readonly checked>
                        <label class="form-check-label" for="">
                            I agree to the 
                            <a target="he_openit" href="<?php echo e(route('privacy')); ?>" 
                            class="" style="color: #2db838;">Terms of Service and Privacy Policy</a>
                        </label>
                    </div>               
                </div>                
        </div>
        <div class="modal-footer">
            <?php echo e(Form::submit('Register', ['class' => 'btn btn-success text-center'])); ?>

            <?php echo Form::close(); ?>

        </div>
      </div>
    </div>
  </div><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/layouts/register_modal.blade.php ENDPATH**/ ?>