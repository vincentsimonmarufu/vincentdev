<header class="main_header_area">
    <!-- Navigation Bar pb-0 pt-0-->
    <div class="header_menu" id="header_menu">

        <nav class="navbar navbar-expand-lg navbar-light  pb-1 pt-0 navbar-sticky"
            style="background-color: #fff !important">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?php echo e(route('welcome')); ?>">
                    <img src="<?php echo e(asset('logo.jpg')); ?>" alt="image" height="50px !important">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto  pb-1 pt-3">
                        <li class="nav-item <?php echo e(Route::currentRouteName() == 'welcome' ? 'active' : ''); ?>">
                            <a class="nav-link" href="<?php echo e(route('welcome')); ?>">Home</a>
                        </li>
                        <!-- <li class="nav-item  <?php echo e(Route::currentRouteName() == 'flight' ? 'active' : ''); ?>">
                            <a class="nav-link" href="<?php echo e(route('flight')); ?>">Flights</a>
                        </li> -->

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Flights
                            </a>
                            <div class="dropdown-menu   <?php echo e(Route::currentRouteName() == 'flight' ? 'active' : ''); ?>"
                                aria-labelledby="navbarDropdown">
                                <!-- <a class="dropdown-item" href="<?php echo e(route('flight')); ?>" >Flight Request</a> -->
                                <a class="dropdown-item" href="<?php echo e(route('flights.searching')); ?>">Book Flight</a>
                            </div>
                        </li>


                        <li class="nav-item  <?php echo e(Route::currentRouteName() == 'apartments.all' ? 'active' : ''); ?>">
                            <a class="nav-link" href="<?php echo e(route('apartments.all')); ?>">
                                Apartments</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Vehicle Hire
                            </a>
                            <div class="dropdown-menu   <?php echo e(Route::currentRouteName() == 'car_hire' ? 'active' : ''); ?>"
                                aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?php echo e(route('car_hire')); ?>">Car Hire</a>
                                <a class="dropdown-item" href="<?php echo e(route('bus_hire')); ?>">Bus Booking</a>
                            </div>
                        </li>

                        <li class="dropdown  <?php echo e(Route::currentRouteName() == 'shuttle_hire' ? 'active' : ''); ?>">
                            <a class="nav-link" href="<?php echo e(route('shuttle_hire')); ?>">
                                Airport Shuttle</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                List Property and Car
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?php echo e(route('apartments.create')); ?>">List Apartment</a>
                                <a class="dropdown-item" href="<?php echo e(route('vehicles.create')); ?>">List Car</a>
                                <a class="dropdown-item" href="<?php echo e(route('buses.create')); ?>">List Bus</a>
                                <a class="dropdown-item" href="<?php echo e(route('shuttles.create')); ?>">List Airport Shuttle</a>
                            </div>
                        </li>
                        <li
                            class="nav-item  <?php echo e(Route::currentRouteName() == 'corporatetravel.create' ? 'active' : ''); ?>">
                            <a class="nav-link" href="<?php echo e(route('corporatetravel.create')); ?>">
                                Corporate Travel</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('contact')); ?>">Contact Us</a></li>
                        </li>
                    </ul>
                    <div class="register-login d-flex align-items-center pb-1 pt-3">
                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(url('/home')); ?>" class="nir-btn white"> Dashboard</a>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="nir-btn white" style="background:#2db838 "> <i
                                    class="fa fa-user"></i>
                                Login/Register</a>

                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!-- Navigation Bar Ends -->
</header>
<!-- header ends -->
<style>
    .navbar-nav {
        margin-left: 3%;
    }

    .navbar-nav {
        margin-right: 1% !important;
    }

    .navbar-brand {
        margin-left: 7%;
    }
</style>
<?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/layouts/header.blade.php ENDPATH**/ ?>