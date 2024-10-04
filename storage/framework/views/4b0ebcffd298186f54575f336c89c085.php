<?php $__env->startSection('content'); ?>
<link href="<?php echo e(asset('assets/css/flights.css')); ?>" rel="stylesheet" />
<main id="main">
    <style>
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            /* Add other styles as needed */
        }
        
        .ui-menu-item {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            cursor: pointer;
        }
        
        .ui-menu-item a {
            color: red;
            font-weight: bold;
            text-decoration: none;
            display: block;
        }
        
        .ui-menu-item a:hover {
            background-color: #f5f5f5;
            /* Add other hover styles as needed */
        }
        
    </style>
    <!-- BreadCrumb Starts -->  
    <section class="breadcrumb-main pb-0 pt-20" style="background: #000;">
        <div class="breadcrumb-outer">
            <div class="container">
                <div class="breadcrumb-content d-md-flex align-items-center pt-6">
                    <h1 class="mb-0">Book Flight </h1>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb" style="display: inline-flex !important;">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('welcome')); ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Book Flight</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="dot-overlay"></div>
     <br/>
   </section>
   <!-- BreadCrumb Ends --> 
   

  <!-- Flight Search Area -->
  <?php echo $__env->make('layouts.flightsearchwidget', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <!-- Flight Search Area -->
</main>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <!-- Add these CDN links to your HTML -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $(document).ready(function () {
            $('#flightOption').change(function () {
                if ($(this).val() === 'multi-city') {
                    // Redirect to the multicity route
                    window.location.href = '<?php echo e(route("multicity")); ?>';
                }
            });        
       
        const airports = [
            <?php $__currentLoopData = $airports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $airport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                {
                    label: " 🛫 <?php echo e($airport['name']); ?>  (<?php echo e($airport['iata']); ?>) | <?php echo e($airport['city']); ?>, <?php echo e($airport['country']); ?> ",
                    name: " <?php echo e($airport['name']); ?> ",
                    value: "<?php echo e($airport['iata']); ?>",
                    latitude: "<?php echo e($airport['lat']); ?>",
                    longitude: "<?php echo e($airport['lon']); ?>",
                },
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        ];

        $(function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
            }

            function successCallback(position) {
                const userLatitude = position.coords.latitude;
                const userLongitude = position.coords.longitude;
                // Calculate the closest airport
                const closestAirport = findClosestAirport(userLatitude, userLongitude);

                // Set the closest airport as selected
                $("#airportInput").val(closestAirport.name);
                $("#origin").val(closestAirport.value);               
            }

            function errorCallback(error) {
                console.error(`Geolocation error: ${error.message}`);
            }

            function findClosestAirport(userLatitude, userLongitude) {
                let closestAirport = null;
                let closestDistance = Infinity;

                airports.forEach(airport => {
                    const distance = calculateDistance(userLatitude, userLongitude, airport.latitude, airport.longitude);

                    if (distance < closestDistance) {
                        closestDistance = distance;
                        closestAirport = airport;
                    }
                });

                return closestAirport;
            }
            function calculateDistance(lat1, lon1, lat2, lon2) {
                // Implement the Haversine formula or any other distance calculation method
                const R = 6371; // Radius of the Earth in kilometers
                const dLat = deg2rad(lat2 - lat1);
                const dLon = deg2rad(lon2 - lon1);

                const a =
                    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);

                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                const distance = R * c; // Distance in kilometers

                // Round the distance to 2 decimal places (adjust as needed)
                return Math.round(distance * 100) / 100;
            }

            function deg2rad(deg) {
                return deg * (Math.PI / 180);
            }


            $("#airportInput").autocomplete({
                source: airports,
                select: function (event, ui) {
                    $("#airportInput").val(ui.item.name);
                    $("#origin").val(ui.item.value);
                    event.preventDefault();
                }
            });

            $("#airportTo").autocomplete({
                source: airports,
                select: function (event, ui) {
                    $("#airportTo").val(ui.item.name);
                    $("#destination").val(ui.item.value);
                    event.preventDefault();
                }
            });
            
        });
 
    });

    // function submitForm(formId) {
    //         document.getElementById(formId).submit();
    // }
</script>
<script src="<?php echo e(asset('assets/js/flights.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/amadeus/search.blade.php ENDPATH**/ ?>