<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Abisiniya development team">
 <!-- Favicons -->
 <link href="<?php echo e(asset('assets/img/favicon.png')); ?>" rel="icon">
 <link href="<?php echo e(asset('assets/img/apple-touch-icon.png')); ?>" rel="apple-touch-icon">
  <title><?php echo e(config('app.name', 'Abisiniya')); ?> - Dashboard</title>
  <!-- CSRF Token -->
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

 <!-- loader-->
  <link href="<?php echo e(asset('admin/assets/css/pace.min.css')); ?>" rel="stylesheet" />
 <!--  Bootstrap Icons -->
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
 <!-- Font Awesome Icons -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <script src="<?php echo e(asset('admin/assets/js/pace.min.js')); ?>"></script>

  <!--plugins-->
  <link href="<?php echo e(asset('admin/assets/plugins/simplebar/css/simplebar.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('admin/assets/plugins/metismenu/css/metisMenu.min.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('admin/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')); ?>" rel="stylesheet" />
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/> 

  <!-- CSS Files -->
  <link href="<?php echo e(asset('admin/assets/css/bootstrap.min.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('admin/assets/css/bootstrap-extended.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('admin/assets/css/style.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('admin/assets/css/icons.css')); ?>" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

  <!--Theme Styles-->
  <link href="<?php echo e(asset('admin/assets/css/dark-theme.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('admin/assets/css/semi-dark.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('admin/assets/css/header-colors.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('admin/vendor/fontawesome-free/css/all.min.css')); ?>" rel="stylesheet" type="text/css">

   
  <?php echo $__env->yieldContent('styles'); ?>
  
   <style>
        .select2-container--classic .select2-selection--single {
            height: 50px !important;
            border-radius: 0px !important;
            padding-top: 10px !important;
        }
        .select2-container--classic .select2-selection--single .select2-selection__arrow {
            height: 50px !important;
        }      
     
    </style>  

</head>

<body>


  <!--start wrapper-->
  <div class="wrapper">
    <?php echo $__env->make('layouts.auth.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.auth.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- start page content wrapper-->
    <div class="page-content-wrapper">
      <!-- start page content-->
      <div class="page-content">
  
        <div class="container-fluid">
          <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li style="list-style: none;"><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
          <?php endif; ?>
          <?php if(session()->has('status')): ?>
            <div class="alert alert-success">
                <ul>
                    <li style="list-style: none;"><?php echo e(session('status')); ?></li>
                </ul>
            </div>
          <?php endif; ?>
         
          <?php echo $__env->yieldContent('content'); ?>
          
        </div>
    </div>
      <!-- end page content-->
    </div>
    <!--end page content wrapper-->


    <!--start footer-->
    <!--<footer class="footer">
      <div class="footer-text">
       Copyright &copy; Abisiniya Travel <?php echo e(date('Y')); ?>

      </div>
    </footer>-->
    <!--end footer-->


    <!--Start Back To Top Button-->
    <a href="javaScript:;" class="back-to-top">
      <ion-icon name="arrow-up-outline"></ion-icon>
    </a>
    <!--End Back To Top Button-->

  </div>
  
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


    <!--start overlay-->
    <div class="overlay nav-toggle-icon"></div>
    <!--end overlay-->

  </div>
  <!--end wrapper-->
  
  <!-- JS Files-->
 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo e(asset('admin/assets/plugins/simplebar/js/simplebar.min.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/assets/plugins/metismenu/js/metisMenu.min.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/assets/js/bootstrap.bundle.min.js')); ?>"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <!--plugins-->
  
  
  <script src="<?php echo e(asset('admin/assets/plugins/datatable/js/jquery.dataTables.min.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/assets/js/table-datatable.js')); ?>"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <!-- Main JS-->
  <script src="https://www.google.com/recaptcha/enterprise.js?render=6Len-SMqAAAAAPYCN2ZeWqb3HV4a85PBWi25hmEo"></script>
  <script>
  function onClick(e) {
    e.preventDefault();
    grecaptcha.enterprise.ready(async () => {
      const token = await grecaptcha.enterprise.execute('6Len-SMqAAAAAPYCN2ZeWqb3HV4a85PBWi25hmEo', {action: 'LOGIN'});
    });
  }
</script>
<script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Dial Code",
                theme: "classic",
                width: "resolve"
            });
        });
    </script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
  var Tawk_API=Tawk_API||{};
  
    //customize position
    Tawk_API.customStyle = {
                visibility : {
                    desktop : {
                        position : 'bl',
                        xOffset : 0,
                        yOffset : 0
                    },
                    mobile : {
                        position : 'bl',
                        xOffset : 0,
                        yOffset : 0
                    },
                    bubble : {
                        rotate : '0deg',
                        xOffset : -20,
                        yOffset : 0
                    }
                }
	        };// end customize position

  Tawk_LoadStart=new Date();
  (function(){
  var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
  s1.async=true;
  s1.src='https://embed.tawk.to/655b1a38d600b968d3150b08/1hfltsrre';
  s1.charset='UTF-8';
  s1.setAttribute('crossorigin','*');
  s0.parentNode.insertBefore(s1,s0);
  })();
  </script>
  
  <!--End of Tawk.to Script-->
  <script src="<?php echo e(asset('admin/assets/js/main.js')); ?>"></script>
  <?php echo $__env->yieldContent('scripts'); ?>

</body>

</html><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/layouts/auth/app.blade.php ENDPATH**/ ?>