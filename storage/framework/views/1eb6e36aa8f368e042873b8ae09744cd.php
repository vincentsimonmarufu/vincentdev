    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
          <div class="modal-content">

            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Welcome Back</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
                <h4 class="text-center">LOGIN</h4>                
                <div id="loginMessage" class="alert alert-success d-none" role="alert"></div>               
                <?php echo Form::open(['route' => 'modal-login', 'id' => 'loginForm','method' => 'POST', 'class' => 'text-left clearfix']); ?>

                
                    <div class="form-group">
                        <?php echo e(Form::text('email', null, ['class'=>'form-control', 'placeholder'=>'Email/Phone number'])); ?>

                    </div>
                    <div class="form-group">
                        <?php echo e(Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password'])); ?>

                    </div>
            </div>

            <div class="modal-footer">
                <?php echo e(Form::submit('Login', ['class' => 'btn btn-success text-center'])); ?>

                <?php echo Form::close(); ?>

            </div>

         </div>
        </div>
  </div><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/layouts/login_modal.blade.php ENDPATH**/ ?>