<?php $__env->startSection('content'); ?>
    <main id="main">
 <!-- BreadCrumb Starts -->  
 <section class="breadcrumb-main pb-0 pt-20" style="background: #000;">
    <div class="breadcrumb-outer">
        <div class="container">
            <div class="breadcrumb-content d-md-flex align-items-center pt-6">
                <h1 class="mb-0">Login</h1>
                <nav aria-label="breadcrumb">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('welcome')); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Login</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="dot-overlay"></div>
    <br/>
</section>
<!-- BreadCrumb Ends --> 

        <!-- ======= LOG-IN Section ======= -->
        <section class="signin-page account">
            <div class="container ">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="block text-center shadow p-3 mb-5">
                            <a class="logo" href="#">
                                <img src="<?php echo e(asset('assets/img/logo.jpg')); ?>" class="img-fluid" width="150" alt="logo">
                            </a>
                            <!-- <?php if($errors->any()): ?>
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
                            <?php endif; ?> -->
                            <?php if(session('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo e(session('error')); ?>

                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>                               
                            <?php endif; ?>
                            <h2 class="text-center">Welcome Back</h2>
                            <?php echo Form::open(['route'=>'login', 'class' => 'text-left clearfix']); ?>

                            <?php echo csrf_field(); ?>
                                <div class="form-group">
                                    <?php echo e(Form::text('email_or_phone', null, ['class'=>'form-control', 'placeholder'=>'Email/Phone number'])); ?>

                                </div>
                                <div class="form-group">
                                    <?php echo e(Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password'])); ?>

                                </div>
                                <div class="text-center">
                                    <?php echo e(Form::submit('Login', ['class'=>'btn btn-success text-center'])); ?>

                                </div>
                            <?php echo Form::close(); ?>

                            <p class="mt-20">New to this site?<a href="<?php echo e(route('register')); ?>" style="color:rgb(14, 180, 14);"> Create New Account</a></p><br/>
                            <p><a href="<?php echo e(route('password.request')); ?>" class="text-danger"> Forgot your password?</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>




        

    </main><!-- End #main -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/auth/login.blade.php ENDPATH**/ ?>