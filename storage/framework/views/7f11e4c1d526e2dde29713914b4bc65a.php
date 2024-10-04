<?php $__env->startSection('content'); ?>
<link href="<?php echo e(asset('assets/css/flights.css')); ?>" rel="stylesheet" />
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
    
    .select2 {
    width: 100% !important; }
</style>
<main id="main">
    <!-- BreadCrumb Starts -->
    <section class="breadcrumb-main pb-0 pt-20" style="background: #000;">
     <div class="breadcrumb-outer">
         <div class="container">
             <div class="breadcrumb-content d-md-flex align-items-center pt-6">
                 <h1 class="mb-0">Multi-City Search</h1>
                 <nav aria-label="breadcrumb">
                     <ul class="breadcrumb d-flex justify-content-center">
                         <li class="breadcrumb-item"><a href="<?php echo e(route('welcome')); ?>">Home</a></li>
                         <li class="breadcrumb-item active" aria-current="page">Multi-City Search</li>
                     </ul>
                 </nav>
             </div>
         </div>
     </div>
     <div class="dot-overlay"></div>
     <br/>
   </section>
   <!-- BreadCrumb Ends -->
  
 <!-- multicity -->
 <?php if(!isset($flights)): ?>
<section id="flight_search" class="card" >
    <div class="container">
        <form action="<?php echo e(route('multicity-search')); ?>" method="POST" id="multicity">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="multiCityModalLabel">Multi City Details</h5>
                </div>
                <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <?php endif; ?>
                <div class="modal-body">
                    <section id="flight_search" class="p-0">
                        <div class="search_field_box">
                            <div class="col-12" id="multi_city_container">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="flight_options d-flex flex-wrap">
                                            <div class="col-md-4 mt-3">
                                                <select class="form-select form-select-sm" name="flight_option" id="flightOption">
                                                    <option value="multi-city" selected>Multi City</option>
                                                    <option value="one-way" >One Way</option>
                                                    <option value="return">Return</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mt-3">
                                                <select class="form-select form-select-sm" name="cabin" id="" required>
                                                    <option value="ECONOMY">Economy</option>
                                                    <option value="PREMIUM_ECONOMY">Premium Economy</option>
                                                    <option value="BUSINESS">Business</option>
                                                    <option value="FIRST">First Class</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mt-3">
                                                <select class="form-select form-select-sm" name="currency" id="currency">
                                                    <option value="USD" selected>USD 🇺🇸</option>
                                                    <option value="ZAR">RANDS 🇿🇦</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-12">
                                        <div class="mt-3">
                                            <div class="input-icon">
                                                <!--<i class="bi bi-crosshair"></i>-->
                                                <strong>Adults</strong>
                                                <input type="number" min="0" value="1" class="form-control" name="adults" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-12">
                                        <div class="mt-3">
                                            <div class="input-icon">
                                                <!--<i class="bi bi-geo"></i>-->
                                                <strong>Children</strong>
                                                <input type="number" min="0" value="0" class="form-control" name="children">  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-12">
                                        <div class="mt-3">
                                            <div class="input-icon">
                                                <!--<i class="bi bi-geo"></i>-->
                                                <strong>Infants</strong>
                                                <input type="number" value="0" min="0" max="2" class="form-control" name="infants">  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center gx-3 multi-city-row">
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="mt-3">
                                            <div class="input-icon">
                                                <strong>Origin</strong>
                                                <input type="text" class="form-control airport-autocomplete" name="origin[]" placeholder="Where From" required>
                                                <!-- Add a hidden input field to store the selected IATA code -->
                                                <input type="hidden" name="originLocationCodes[]" class="airport-iata"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="mt-3">
                                            <div class="input-icon">
                                                <strong> Destination</strong>                                              
                                                <input type="text" class="form-control airport-autocomplete" name="destination[]" placeholder="Where To" required>
                                                <!-- Add a hidden input field to store the selected IATA code -->
                                                <input type="hidden" name="destinationLocationCodes[]" class="airport-iata"/>
                                            </div>
                                        </div>
                                    </div>
                                        <?php                                  
                                        $currentDate = date('Y-m-d');                                   
                                        $oneYearLater = date('Y-m-d', strtotime('+1 year', strtotime($currentDate)));
                                        ?>
                                    <div class="col-md-3 col-sm-6 col-12">
                                        <div class="mt-3">
                                            <div class="input-icon">
                                                <strong>Date</strong>
                                                <input type="date" min="<?php echo $currentDate; ?>" max="<?php echo $oneYearLater; ?>" class="form-control dateInputDeparture" name="departureDateRanges[]" placeholder="Select Departure Date" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-1 col-sm-6 col-12">
                                        <div class="mt-3">
                                            &nbsp;
                                            <button type="button" class="btn btn-danger close_btn btn-sm btn-block remove_destination">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div>
                        <button type="button" class="btn btn-primary add_depart btn-sm add_destination">Add Destination</button>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success btn-md search_now">Search</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
 </section>
<?php endif; ?>
  
  <?php if(isset($flights)): ?>
  <section class="flight_list" style="padding-top: -30">
      <p class=" alert alert-success text-center text-dark"><br/>
         Multi City Search &nbsp; &nbsp; ✈️   &nbsp; &nbsp; <br/>
          <?php echo e(count($flights)); ?> Results found<br/></p>
      <?php if( count($flights) > 0): ?>
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <?php $__currentLoopData = $flights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $flight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                 
                      <div class="my-3">
                          <div class="flight_card">

                            <?php $__currentLoopData = $flight->itineraries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itineraries): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                 $segments = $itineraries->segments;
                                 // Get the first segment
                                 $firstSegment = reset($segments);
                                 $accessTokenController = app('App\Http\Controllers\WelcomeController');
                                 $departure = $accessTokenController->airportName($firstSegment->departure->iataCode);
                                 // Get the last segment
                                 $lastSegment = end($segments);
                                 $arrival = $accessTokenController->airportName($lastSegment->arrival->iataCode);

                                 $airlineCode = $firstSegment->carrierCode;
                             // $imageUrl = "https://www.gstatic.com/flights/airline_logos/70px/dark/{$airlineCode}.png";
                             $imageUrl = "https://images.kiwi.com/airlines/32x32/{$airlineCode}.png?default=airline.png";
                             ?>
                                  <div class="upper_card">
                                      <p class="text-muted mb-1"><small>Departing Flight </small>
                                          <small class="ms-1">(<?php echo e(\Carbon\Carbon::parse($firstSegment->departure->at)->format('d-m-Y')); ?>)</small>
                                      </p>
                                  </div>
                                  <div class="split_cards">
                                      <div class="card_one">
                                          <p>
                                              <small><?php echo e(\Carbon\Carbon::parse($firstSegment->departure->at)->format('H:i')); ?></small>
                                          </p>
                                          <p>
                                              <small><?php echo e(formatDuration( $itineraries->duration)); ?></small>
                                          </p>
                                          <p>
                                              <small><?php echo e(\Carbon\Carbon::parse($lastSegment->arrival->at)->format('H:i')); ?> </small>
                                          </p>
                                      </div>
                                      <div class="card_two">
                                          <div class="line"></div>
                                          <i class="bi bi-airplane-fill"></i>
                                          <div class="line"></div>
                                      </div>
                                      <div class="card_one">
                                          <p>
                                              <small><?php echo e($departure); ?>  (<?php echo e($firstSegment->departure->iataCode); ?>)</small>
                                          </p>
                                          <p>
                                              &nbsp;
                                          
                                              <small><img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($airlineCode); ?>" title="<?php echo e($airlineCode); ?>" height="20px"></small>
                                              <small class="ms-1"> <?php echo e($flight->travelerPricings[0]->fareDetailsBySegment[0]->cabin); ?></small> 
                                              Seats : <?php echo e($flight->numberOfBookableSeats); ?>

                                          </p>
                                          <p>    
                                          <small>
                                              <?php echo e($arrival); ?>  (<?php echo e($lastSegment->arrival->iataCode); ?>)
                                          </small>
                                          </p>
                                      </div>
                                  </div>
                                  <div class="upper_card">
                                                        <p class="text-muted mb-1"><small><?php echo e(\App\Models\Airline::where('code', $firstSegment->carrierCode)->first()->name); ?></small>
                                                            <small class="ms-1">(<?php echo e($firstSegment->carrierCode); ?>)</small>                                            
                                                        </p>
                                                    </div>
                                  <hr/>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  <div class="line"></div>
                                  <div class="lower_card h-100">
                                      <h3 class="mb-0">
                                          <?php if($flight->price->currency == 'ZAR'): ?>
                                              R 
                                          <?php else: ?>
                                      $
                                          <?php endif; ?>
                                          <?php echo e($flight->price->total); ?> 
                                      </h3>                                     
                                      <form action="/flight-price" id="form<?php echo e($flight->id); ?>" method="POST" class="form">
                                          <?php echo csrf_field(); ?>                                          
                                          <input type="hidden" name="flight" value="<?php echo e(json_encode($flight)); ?>" />
                                          <input type="hidden" name="departure" value="<?php echo e($departure); ?>" />
                                          <input type="hidden" name="flight_option" value="multi-city" />
                                          <input type="hidden" name="arrival" value="<?php echo e($arrival); ?>" />                                        
                                          <button type="button" class="btn btn-primary" onclick="submitForm('form<?php echo e($flight->id); ?>')">Select</button>
                                      </form>
                                  </div>

                          </div>
                      </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
          </div>
      </div>
      <?php endif; ?>
  </section>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
  <!-- Add these CDN links to your HTML -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    $(document).ready(function () {
        $('#flightOption').change(function () {
            if ($(this).val() === 'one-way' || $(this).val() === 'return' ) {
                        // Redirect to the multicity route
                        window.location.href = '<?php echo e(route("flights.searching")); ?>';
                }
        });
  
        const airports = [
            <?php $__currentLoopData = $airports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $airport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                {
                    label: " 🛫 <?php echo e($airport['name']); ?>  (<?php echo e($airport['iata']); ?>) | <?php echo e($airport['city']); ?>, <?php echo e($airport['country']); ?> ",
                    name: " <?php echo e($airport['name']); ?> (<?php echo e($airport['iata']); ?>) ",
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
                //$(".airport-autocomplete").val(closestAirport.name);
                //$(".airport-iata").val(closestAirport.value);
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

            function initializeAutocomplete(row) {
                row.find('.airport-autocomplete').autocomplete({
                    source: airports,
                    select: function (event, ui) {
                        $(this).val(ui.item.name);
                        $(this).closest('.input-icon').find('.airport-iata').val(ui.item.value);
                        event.preventDefault();
                    }
                });
            }
        
            // Add Destination Button Click
            $('.add_destination').click(function () {
                var newRow = $('#multi_city_container .multi-city-row:first').clone();
                newRow.find('input').val(''); // Clear input values in the new row
                newRow.find('.airport-iata').val(''); // Clear IATA code in the new row
                newRow.appendTo('#multi_city_container');

                // Initialize autocomplete for the new row
                initializeAutocomplete(newRow);
            });

            // Remove Destination Button Click
            $('#multi_city_container').on('click', '.remove_destination', function () {
                var rowCount = $('#multi_city_container .multi-city-row').length;
                if (rowCount > 1) {
                    $(this).closest('.multi-city-row').remove();
                } else {
                    alert('At least one row is required.');
                }
            });

            // Initialize autocomplete for existing rows
            $('#multi_city_container .multi-city-row').each(function () {
                initializeAutocomplete($(this));
            });
        
        });
      
    });
    
    function submitForm(formId) {
        document.getElementById(formId).submit();
    }
 </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/amadeus/multicity.blade.php ENDPATH**/ ?>