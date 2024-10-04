<div class="container">
    <div class=" p-5" style="background: #fff">
        <h3 class="">Flight Details</h3>
        <ul class="list-group">
            <li class="list-group-item"><b>Price:</b> 
                <?php if($data->flightOffers[0]->price->currency == 'ZAR'): ?>
                    R 
                <?php else: ?>
                    $
                <?php endif; ?> <?php echo e($data->flightOffers[0]->price->grandTotal); ?> </li>
            <li class="list-group-item"><b>Currency:</b> <?php echo e($data->flightOffers[0]->price->currency); ?></li>  
            <li class="list-group-item"><b>Last Ticketing Date:</b> <?php echo e($data->flightOffers[0]->lastTicketingDate); ?></li>
            <li class="list-group-item"><b>Flight Option:</b> <?php echo e($flight_option); ?></li>  
            <li class="list-group-item"><b>Cabin:</b> <?php echo e($data->flightOffers[0]->travelerPricings[0]->fareDetailsBySegment[0]->cabin); ?></li>  
            <li class="list-group-item"><b> Number of Travellers:</b> <?php echo e(count($data->flightOffers[0]->travelerPricings)); ?></li>
        </ul>

        <h4 class=" mt-5">Itinerary Details</h4>
        <ul class="list-group">
            <?php $__currentLoopData = $data->flightOffers[0]->itineraries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $itinerary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($flight_option == "multi-city"): ?>
                    <h4 class=" mt-5"> Trip  <?php echo e($index + 1); ?></h4>
                <?php endif; ?>
                    <?php $__currentLoopData = $itinerary->segments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $segment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <?php
                            $airlineCode = $segment->carrierCode;
                            // $imageUrl = "https://www.gstatic.com/flights/airline_logos/70px/dark/{$airlineCode}.png";
                            $imageUrl = "https://images.kiwi.com/airlines/32x32/{$airlineCode}.png?default=airline.png";

                            //$accessTokenController = app('App\Http\Controllers\AmadeusController');
                            $accessTokenController = app('App\Http\Controllers\WelcomeController');
                            $name = $accessTokenController->airlineName($airlineCode);

                            //$accessTokenController = app('App\Http\Controllers\WelcomeController');
                            $departure = $accessTokenController->airportName( $segment->departure->iataCode);
                            $arrival = $accessTokenController->airportName( $segment->arrival->iataCode);
                        ?>

                        <li class="list-group-item"> <img src="<?php echo e($imageUrl); ?>" alt="Airline Logo"> &nbsp; &nbsp; <?php echo e($name); ?></li>
                        <li class="list-group-item"> <b>Departure: </b> <?php echo e($departure ?? ''); ?> (<?php echo e($segment->departure->iataCode); ?>) </li>
                        <li class="list-group-item"><b> At: </b> <?php echo e(\Carbon\Carbon::parse($segment->departure->at)->format('Y-m-d H:i:s')); ?></li>
                        <li class="list-group-item"><b>Arrival: </b> <?php echo e($arrival ?? ''); ?> (<?php echo e($segment->arrival->iataCode); ?> )</li>
                        <li class="list-group-item"><b> At: </b> <?php echo e(\Carbon\Carbon::parse($segment->arrival->at)->format('Y-m-d H:i:s')); ?></li>
                        <li class="list-group-item"><b>Duration: </b> <?php echo e(formatDuration( $segment->duration)); ?></li>
                        <li class="list-group-item"><b>Number Of Stops: </b> <?php echo e($segment->numberOfStops); ?></li>
                        <li class="list-group-item"> <b>Cabin Class: </b> <?php echo e($segment->co2Emissions[0]->cabin); ?></li>
                        <br/>  
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>

        <h4 class="mt-2">Baggage Allowance (Checked baggage permitted)</h4>
            <ul class="list-group">
                <?php if(isset($data->flightOffers[0]->travelerPricings[0]->fareDetailsBySegment[0]->includedCheckedBags->quantity)): ?>
                    <li class="list-group-item" style="border-bottom:none;padding-bottom:0px;">
                        <b>Quantity:</b> <?php echo e($data->flightOffers[0]->travelerPricings[0]->fareDetailsBySegment[0]->includedCheckedBags->quantity); ?> piece(s) per person
                    </li>
                <?php elseif(isset($data->flightOffers[0]->travelerPricings[0]->fareDetailsBySegment[0]->includedCheckedBags->weight)): ?>
                    <li class="list-group-item" style="border-bottom:none;padding-bottom:0px;">
                        <b>Weight:</b> <?php echo e($data->flightOffers[0]->travelerPricings[0]->fareDetailsBySegment[0]->includedCheckedBags->weight); ?> kg per person
                    </li>
                <?php endif; ?>
                <li class="list-group-item" style="border-bottom:none;padding-bottom:0px;">
                    <b>Ticketing:</b> Within 2 hours after payment
                </li>
                <li class="list-group-item">
                    <b><a href="#" title="View details about baggage allowances and policy information.">Baggage & Policy details</a></b>
                </li>
            </ul>

        <h4 class=" mt-3">Booking Requirements</h4>

        <form action="<?php echo e(route('flightbooking')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php for($i = 0; $i < count($data->flightOffers[0]->travelerPricings); $i++): ?>
                <h4>Passenger <?php echo e($i + 1); ?></h4>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-12">
                        <div class="mb-3">
                            <label for="first_name_<?php echo e($i); ?>">First Name</label>
                            <input type="hidden" name="passengers[<?php echo e($i); ?>][id]" id="id_<?php echo e($i); ?>" value="<?php echo e($i + 1); ?>" class="form-control" required>
                            <input type="text" name="passengers[<?php echo e($i); ?>][name][firstName]" id="first_name_<?php echo e($i); ?>" class="form-control" placeholder="First Name" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12 col-12">
                        <div class="mb-3">
                            <label for="last_name_<?php echo e($i); ?>">Last Name</label>
                            <input type="text" name="passengers[<?php echo e($i); ?>][name][lastName]" id="last_name_<?php echo e($i); ?>" class="form-control" placeholder="Last Name" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12 col-12">
                        <div class="mb-3">
                            <label for="dob_<?php echo e($i); ?>">Date of Birth <small>(2000-01-30)(year-month-date)</small></label>
                            <input type="text" name="passengers[<?php echo e($i); ?>][dob]" id="dob_<?php echo e($i); ?>" class="form-control" placeholder="2000-01-30" pattern="\d{4}-\d{2}-\d{2}" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12 col-12">
                        <div class="mb-3">
                            <label for="gender_<?php echo e($i); ?>">Gender</label>
                            <select style="height: 50px;border-radius: 0px !important;" name="passengers[<?php echo e($i); ?>][gender]" id="gender_<?php echo e($i); ?>" class="form-control" required>
                                <option value="MALE">Male</option>
                                <option value="FEMALE">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12 col-12">
                        <div class="mb-3">
                            <label for="email_<?php echo e($i); ?>">Email</label>
                            <input type="email" name="passengers[<?php echo e($i); ?>][contact][emailAddress]" id="email_<?php echo e($i); ?>" class="form-control" placeholder="Email" required>
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-12 col-12">
                        <div class="mb-3">
                            <label for="phone_<?php echo e($i); ?>">Dial Code</label>
                            <div class="input-group">
                                <select name="passengers[<?php echo e($i); ?>][contact][phones][0][countryCallingCode]" id="phone_country_<?php echo e($i); ?>" class="form-control select2" required>
                                    <option value="" selected disabled>Dial Code</option>
                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($country->dial_code); ?>"><?php echo e($country->dial_code); ?> </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-12 col-12">
                        <div class="mb-3">
                            <label for="phone_<?php echo e($i); ?>">Phone Number</label>
                            <div class="input-group">
                                <input type="number" name="passengers[<?php echo e($i); ?>][contact][phones][0][number]" id="phone_number_<?php echo e($i); ?>" class="form-control" placeholder="Phone Number" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="mb-3">
                            <label for="passport_<?php echo e($i); ?>">Passport Photo</label>
                            <input type="file" name="passengers[<?php echo e($i); ?>][passport]" id="passport_<?php echo e($i); ?>" class="form-control">
                        </div>
                    </div>
                </div>                
            <?php endfor; ?>

            <input type="hidden" name="data" value="<?php echo e(json_encode($data)); ?>" />
            <input type="hidden" name="departure" value="<?php echo e($departure); ?>" />
            <input type="hidden" name="arrival" value="<?php echo e($arrival); ?>" />
            <input type="hidden" name="price" value="<?php echo e($data->flightOffers[0]->price->grandTotal); ?>" />
            <input type="hidden" name="currency" value="<?php echo e($data->flightOffers[0]->price->currency); ?>" />
            <input type="hidden" name="flight_option" value="<?php echo e($flight_option); ?>" />
            <input type="hidden" name="airline" value="<?php echo e($name); ?>" />

            <?php if(auth()->user() != null): ?>
                <!-- Show the BOOK NOW button if the user is logged in -->
                <button class="btn btn-success form-control" id="bookNowButton" type="submit">BOOK NOW</button>
                <?php else: ?>
                <!-- Code to execute when there is no authenticated user -->
                <p id="accountpanel">
                    Please
                    <a href="#" id="loginLink" data-toggle="modal" data-target="#loginModal"><b>LOGIN</b></a>
                    or
                    <a href="#" id="registerLink" data-toggle="modal" data-target="#registerModal"><b>CREATE</b></a>
                    an account to proceed.<br />
                    <small class="text-danger"></small>
                </p>
            <?php endif; ?>
            <div id="mybutton"></div>
        </form>       
    </div>
</div>

<?php echo $__env->make('layouts.login_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.register_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<script type="text/javascript">
    $(document).ready(function() {       

        // select2
        $('.select2').select2(
            {
            placeholder: "Dial Code",
            theme: "classic",
            width: "resolve"
        });      

        // calling login modal
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();           
            // Serialize the form data
            var formData = $(this).serialize();
    
            $.ajax({                
                url: "<?php echo e(route('modal-login')); ?>",             
                method: 'POST',
                data: formData,
                success: function(response) {                           
                    $('#loginMessage').text('Login successful!').removeClass('d-none');                  
                    setTimeout(function() {
                        $("#mybutton").html('<button class="btn btn-success form-control" id="bookNowButton" type="submit">BOOK NOW</button>');
                        $('#loginModal').modal('hide');
                        $('#accountpanel').hide();
                        $('#bookNowButton').show();
                    }, 3000); 
                },
                error: function(xhr, status, error) {    
                    //alert('Message from server: ' + response.message);              
                var errorMessage = xhr.responseJSON && xhr.responseJSON.message
                    ? 'Login failed. ' + xhr.responseJSON.message
                    : 'Login failed. Please try again.';
                    
                $('#loginMessage').text(errorMessage).removeClass('d-none'); 
                
               
                setTimeout(function() {
                    $('#loginMessage').addClass('d-none');
                }, 2000); 
                }
            });
        });

        
        // calling for registration model
        $('#registerForm').on('submit', function(e) {
            e.preventDefault();           
            // Serialize the form data
            var formData = $(this).serialize();
    
            $.ajax({                
                url: "<?php echo e(route('modal-register')); ?>",             
                method: 'POST',
                data: formData,
                success: function(response) {                      
                    $('#successMessage').text('Registration successful!').removeClass('d-none');                  
                    setTimeout(function() {
                        $("#mybutton").html('<button class="btn btn-success form-control" id="bookNowButton" type="submit">BOOK NOW</button>');
                        $('#registerModal').modal('hide');
                        $('#accountpanel').hide();
                        $('#bookNowButton').show();
                    }, 2000); // 3 seconds delay
                },
                error: function(xhr, status, error) {              
                var errorMessage = xhr.responseJSON && xhr.responseJSON.message
                    ? 'Registration failed. ' + xhr.responseJSON.message
                    : 'Registration failed. Please try again.';
                    
                $('#successMessage').text(errorMessage).removeClass('d-none'); 
                
               
                setTimeout(function() {
                    $('#successMessage').addClass('d-none');
                }, 2000); 
                }
            });
        });


    });
</script>
<?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/layouts/flightpricewidget.blade.php ENDPATH**/ ?>