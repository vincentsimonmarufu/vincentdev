<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/css/intlTelInput.css"></link>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/js/intlTelInput.min.js"></script>
<main id="main">
        
 <!-- BreadCrumb Starts -->  
 <section class="breadcrumb-main pb-0 pt-20" style="background: #000;">
    <div class="breadcrumb-outer">
        <div class="container">
            <div class="breadcrumb-content d-md-flex align-items-center pt-6">
                <h1 class="mb-0">Register</h1>
                <nav aria-label="breadcrumb">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('welcome')); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Register</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="dot-overlay"></div>
    <br/>
</section>
<!-- BreadCrumb Ends --> 

        <!-- ======= SIGN-UP Section ======= -->
        <section class="signin-page account">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="block text-center shadow p-3 mb-5">
                            <a class="logo" href="#">
                                <img src="<?php echo e(asset('assets/img/logo.jpg')); ?>" class="img-fluid" width="150" alt="logo">
                            </a>
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
                            <h2 class="text-center">Create Your Account</h2>
                            <?php echo Form::open(['route'=>'register', 'class'=>'text-left clearfix']); ?>

                            <?php echo csrf_field(); ?>
                                <div class="form-group">
                                    <?php echo e(Form::text('name', null, ['class'=>'form-control', 'placeholder' => 'First Name', 'required'])); ?>

                                </div>
                                <div class="form-group">
                                    <?php echo e(Form::text('surname', null, ['class'=>'form-control', 'placeholder'=>'Last Name', 'required'])); ?>

                                </div>
                                <div class="form-group iti">
                                    <div class="iti__flag-container">                                       
                                    </div>                                  
                                    <input type="tel" name="phone_number" class="form-control" id="phone_number" placeholder="Phone number" style="margin-left:91px; width:145% !important"> 
                                    <input type="hidden" id="phone" name="phone">
                                    <input type="hidden" id="code" name="code">
                                </div> 
                                <div class="form-group">
                                    <?php echo e(Form::email('email', null, ['class'=>'form-control', 'placeholder'=>'Email', 'required'])); ?>

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
                                            <a target="_blank" href="<?php echo e(route('privacy')); ?>" 
                                            class="" style="color: #2db838;">Terms of Service and Privacy Policy</a>
                                        </label>
                                    </div>
                               
                                </div>
                                <div class="text-center">
                                    <?php echo e(Form::submit('Register', ['class'=>'btn btn-success text-center'])); ?>

                                </div>
                            <?php echo Form::close(); ?>

                            <p class="mt-20">Already have an account ?<a href="<?php echo e(route('login')); ?>" style="color:rgb(14, 180, 14);"> Login</a></p>
                            <p><a href="<?php echo e(route('password.request')); ?>" class="text-danger"> Forgot your password?</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
   
    <script>

        document.addEventListener("DOMContentLoaded", function() {
            const phoneInputField = document.querySelector("#phone_number");
            const phoneInput = window.intlTelInput(phoneInputField, {
                formatOnInit: true,
                separateDialCode: true,
                initialCountry: "zw",
                hiddenInput: "phone",
                geoIpLookup: function(callback) {
                    $.get('https://ipinfo.io', function() {}, "json").always(function(resp) {
                        var countryCode = (resp && resp.country) ? resp.country : "tr";
                        callback(countryCode);
                    });
                },
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/js/utils.min.js"
            });

            // Update hidden fields on form submission
            document.querySelector("form").addEventListener("submit", function() {
                const fullPhoneNumber = phoneInput.getNumber(); 
                const dialCode = phoneInput.getSelectedCountryData().dialCode;
                const phoneNumber = fullPhoneNumber.replace('+' + dialCode, ''); 

                document.querySelector("#code").value = '+' + dialCode; 
                document.querySelector("#phone").value = phoneNumber; 
            });

            // Adjust the width of the phone input container
            const widthChange = document.querySelector('.iti');
            if (widthChange) {
                console.log("Element with class 'iti' found");
                widthChange.style.width = "100%";
            } else {
                console.log("Element with class 'iti' not found");
            }
        });

   
    </script>
   
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/auth/register.blade.php ENDPATH**/ ?>