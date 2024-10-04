<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Abisiniya</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta content="" name="descriptison">
    <meta content="" name="keywords">    
    <!-- Favicons -->
    <link href="<?php echo e(asset('assets/img/favicon.png')); ?>" rel="icon">
    <link href="<?php echo e(asset('assets/img/apple-touch-icon.png')); ?>" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Muli:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- custom css -->
    <link href="<?php echo e(asset('assets/vendor/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/>    

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous">

    

    <!-- Main CSS File -->
    <link href="<?php echo e(asset('style.css')); ?>" rel="stylesheet">

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

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-10868682870"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'AW-10868682870');  <!-- This line initializes Google Ads tracking -->
    </script>
</head>

<body style="background: #f6f6f6;">

    
    <!-- <div id="preloader"></div>-->

    <?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>
    <?php if(session()->has('status')): ?>
    <div class="alert alert-success">
        <ul>
            <li><?php echo e(session('status')); ?></li>
        </ul>
    </div>
    <?php endif; ?>
    <?php echo $__env->yieldContent('content'); ?>

    <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <script src="<?php echo e(asset('js/jquery-3.5.1.min.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- Bootstrap JavaScript Libraries -->
    

    <!-- Add these CDN links to your HTML -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Dial Code",
                theme: "classic",
                width: "resolve"
            });
        });
    </script>

    

    <?php echo $__env->yieldContent('scripts'); ?>

     <?php echo $__env->yieldContent('contactcontact'); ?>

    <!-- Add the phone snippet to the specific page where the phone number appears -->
    <?php if(Route::currentRouteName() == 'contact'): ?>
        <script>
            gtag('config', 'AW-10868682870/g1NYCO3J7MMZEPbgy74o', {
                'phone_conversion_number': '+27655326408'
            });
        </script>
    <?php endif; ?>   
    
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {};
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

        Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/655b1a38d600b968d3150b08/1hfltsrre';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
   
</body>

</html><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/layouts/app.blade.php ENDPATH**/ ?>