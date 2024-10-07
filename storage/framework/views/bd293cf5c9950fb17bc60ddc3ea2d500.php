<?php if(!isset($flights)): ?>
    <style>
        .message {
            color: red;
            display: none;
        }
    </style>
    <section id="flight_search" class="card">
        <div class="container">
            <div class="flight_header">
                <h3>
                    Book flight
                </h3>
            </div>
            <?php if(session('message')): ?>
                <div class="alert alert-warning">
                    <?php echo e(session('message')); ?>

                </div>
            <?php endif; ?>


            <?php if(session('userMessage')): ?>
                <div class="alert alert-warning" id="userMessage">
                    <?php echo e(session('userMessage')); ?>

                </div>
            <?php endif; ?>

            <?php if(count($errors) > 0): ?>
                <div class="container card">
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-danger">
                                An error occurred while searching for a flight. <br/>
                                Please ensure that you have entered the correct details:
                                <ul>
                                    <li>1. Ensure accurate information for the departure and destination fields,
                                        selecting from the provided autocomplete suggestions.
                                    </li>
                                    <li>2. Make sure the selected date is in the future.</li>
                                </ul>
                                <br/>
                                If the issue persists, please review the error details below:<br/>
                                <strong>Error:</strong> <?php echo e($errors->first('exception')); ?>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="search_field_box">
                <form action="<?php echo e(route('flights.search')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="flight_options d-flex flex-wrap">
                                <div class="col-md-4 mt-3">
                                    <select class="form-select form-select-sm" name="flight_option" id="flightOption">
                                        <option value="one-way" selected>One Way</option>
                                        <option value="return">Return</option>
                                        <option value="multi-city">Multi City</option>
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

                    <div class="row gx-3">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="mt-3">
                                        <div class="input-icon">
                                            <!--<i class="bi bi-crosshair"></i>-->
                                            From
                                            <input type="text" class="form-control " placeholder="Where From"
                                                   name="origin_airport" id="airportInput" required>
                                            <!-- Add a hidden input field to store the selected IATA code -->
                                            <input type="hidden" name="origin" id="origin"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="mt-3">
                                        <div class="input-icon">
                                            <!--<i class="bi bi-geo"></i>-->
                                            Destination
                                            <input type="text" class="form-control " style="width: 100%;"
                                                   placeholder="Where To" name="destination_airport" id="airportTo"
                                                   required>
                                            <!-- Add a hidden input field to store the selected IATA code -->
                                            <input type="hidden" name="destination" id="destination"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-12">
                                    <div class="mt-3">
                                        <div class="input-icon">
                                            Adults (12 years and older)
                                            <input type="number" min="0" value="1" class="form-control" name="adults"
                                                   id="adults-input" required>
                                            <div id="adult-message" class="message" style="display:none;">At least one
                                                adult must be selected
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-12">
                                    <div class="mt-3">
                                        <div class="input-icon">
                                            Children (2 to 11 years old)
                                            <input type="number" min="0" value="0" class="form-control" name="children"
                                                   id="children-input">
                                            <div id="children-message" class="message" style="display:none;">Maximum 5
                                                children allowed
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-12">
                                    <div class="mt-3">
                                        <div class="input-icon">
                                            Infants (Under 2 years old)
                                            <input type="number" value="0" min="0" class="form-control" name="infants"
                                                   id="infants-input">
                                            <div id="infant-message" class="message" style="display:none;"></div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        const adultsInput = document.getElementById('adults-input');
                                        const childrenInput = document.getElementById('children-input');
                                        const infantsInput = document.getElementById('infants-input');

                                        // Set default value for adults if it's not already set
                                        if (!adultsInput.value) {
                                            adultsInput.value = 1;
                                        }

                                        function validateInputs() {
                                            let adults = parseInt(adultsInput.value) || 1; // Default to 1 if empty or invalid
                                            let children = parseInt(childrenInput.value) || 0;
                                            let infants = parseInt(infantsInput.value) || 0;

                                            // Validate adults can't be less than 1
                                            if (adults < 1) {
                                                adults = 1;
                                                adultsInput.value = 1;
                                                showMessage('adult-message', 'Adults cannot be less than 1.');
                                            } else {
                                                hideMessage('adult-message');
                                            }

                                            // Validate children can't be more than 5
                                            if (children > 5) {
                                                children = 5;
                                                childrenInput.value = 5;
                                                showMessage('children-message', 'Children cannot exceed 5.');
                                            } else {
                                                hideMessage('children-message');
                                            }

                                            // Validate infants can't be greater than adults
                                            if (infants > adults) {
                                                infants = adults;
                                                infantsInput.value = adults;
                                                showMessage('infant-message', 'Infants cannot be more than the number of adults.');
                                            } else {
                                                hideMessage('infant-message');
                                            }

                                            // Validate total number of passengers (adults + children + infants) can't exceed 9
                                            if (adults + children + infants > 9) {
                                                const maxPassengers = 9 - adults - infants;
                                                //childrenInput.value = maxPassengers > 5 ? 5 : maxPassengers;
                                                childrenInput.value = maxPassengers > 5 ? 5 : 0;
                                                showMessage('total-message', 'Total passengers (adults, children, and infants) cannot exceed 9.');
                                            } else {
                                                hideMessage('total-message');
                                            }
                                        }

                                        function showMessage(elementId, message) {
                                            const element = document.getElementById(elementId);
                                            element.style.display = 'block';
                                            element.textContent = message;
                                        }

                                        function hideMessage(elementId) {
                                            const element = document.getElementById(elementId);
                                            element.style.display = 'none';
                                        }

                                        adultsInput.addEventListener('input', validateInputs);
                                        childrenInput.addEventListener('input', validateInputs);
                                        infantsInput.addEventListener('input', validateInputs);
                                    });
                                </script>

                                <span id="adult-infant-message" class="text-center"
                                      style="display:none; color:red; text-align: left; margin-left: 33.33%;"></span>
                                <span id="adult-child-message" class="text-center"
                                      style="display:none; color:red; text-align: left; margin-left: 33.33%;"></span>
                                <span id="total-message" class="text-center"
                                      style="display:none; color:red; text-align: left; margin-left: 33.33%;"></span>

                            </div>
                                <?php
                                $currentDate = date('Y-m-d');
                                $oneYearLater = date('Y-m-d', strtotime('+1 year', strtotime($currentDate)));
                                ?>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="mt-3">
                                        <div class="input-icon">
                                            Departure Date
                                            <input type="date" min="<?php echo $currentDate; ?>"
                                                   max="<?php echo $oneYearLater; ?>" class="form-control" id=""
                                                   placeholder="Select Departure Date" name="departure_date" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="mt-3">
                                        <div class="input-icon">
                                            Return Date
                                            <input type="date" min="<?php echo $currentDate; ?>"
                                                   max="<?php echo $oneYearLater; ?>" class="form-control" id=""
                                                   placeholder="Select Return Date" name="return_date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="flight-sub text-right">
                                <button type="submit" class="btn btn-success btn-lg">
                                    Search
                                </button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if(isset($flights)): ?>
    <section class="flight_list" style="padding-top: -30">
        <p class=" alert alert-success text-center text-dark"><br/>
            <?php echo e($flight_option); ?> Search &nbsp;&nbsp; ✈️ <br/>
            <?php echo e(count($flights)); ?> Results found<br/></p>
        <?php if( count($flights) > 0): ?>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?php $__currentLoopData = $flights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $flight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($flight_option == 'return'): ?>
                                <div class="row">
                                    <div class="col-12">
                                        <?php
                                            $segments = $flight->itineraries[0]->segments;
                                            $firstSegment = reset($segments);

                                            $accessTokenController = app('App\Http\Controllers\WelcomeController');
                                            $departure = $accessTokenController->airportName($firstSegment->departure->iataCode);

                                            // Get the last segment
                                            $lastSegment = end($segments);
                                            $arrival = $accessTokenController->airportName($lastSegment->arrival->iataCode);

                                            $airlineCode = $firstSegment->carrierCode;
                                            // $imageUrl = "https://www.gstatic.com/flights/airline_logos/70px/dark/{$airlineCode}.png";
                                            $imageUrl = "https://images.kiwi.com/airlines/32x32/{$airlineCode}.png?default=airline.png";

                                            //second segment return flight
                                            $second_segments = $flight->itineraries[1]->segments;
                                            // Get the first segment
                                            $second_firstSegment = reset($second_segments);
                                            // Get the last segment
                                            $second_lastSegment = end($second_segments);
                                            $second_airlineCode = $second_firstSegment->carrierCode;
                                            // $imageUrl = "https://www.gstatic.com/flights/airline_logos/70px/dark/{$airlineCode}.png";
                                            $second_imageUrl = "https://images.kiwi.com/airlines/32x32/{$second_airlineCode}.png?default=airline.png";

                                        ?>
                                        <div class="my-3">
                                            <div class="flight_card">
                                                <div class="upper_card">
                                                    <p class="text-muted mb-1"><small>Departing Flight</small>
                                                        <small
                                                            class="ms-1">(<?php echo e(\Carbon\Carbon::parse($firstSegment->departure->at)->format('d-m-Y')); ?>

                                                            )</small>
                                                    </p>
                                                </div>
                                                <div class="split_cards">
                                                    <div class="card_one">
                                                        <p>
                                                            <small><?php echo e(\Carbon\Carbon::parse($firstSegment->departure->at)->format('H:i')); ?></small>
                                                        </p>
                                                        <p>
                                                            <small><?php echo e(formatDuration( $flight->itineraries[0]->duration)); ?></small>
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
                                                            <small><?php echo e($departure); ?>

                                                                (<?php echo e($firstSegment->departure->iataCode); ?>)</small>
                                                        </p>
                                                        <p>
                                                            <small><img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($airlineCode); ?>"
                                                                        title="<?php echo e($airlineCode); ?>"
                                                                        height="20px"></small>
                                                            <small
                                                                class="ms-1"> <?php echo e($flight->travelerPricings[0]->fareDetailsBySegment[0]->cabin); ?></small>
                                                        </p>
                                                        <p>
                                                            <small><?php echo e($arrival); ?>

                                                                (<?php echo e($lastSegment->arrival->iataCode); ?>)</small>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="upper_card">
                                                    <p class="text-muted mb-1">
                                                        <small><?php echo e(\App\Models\Airline::where('code', $firstSegment->carrierCode)->first()->name); ?></small>
                                                        <small class="ms-1">(<?php echo e($firstSegment->carrierCode); ?>)</small>
                                                    </p>
                                                </div>
                                                <div class="line"></div>
                                                <hr/>
                                                <!-------- return flight-->
                                                <div class="upper_card">
                                                    <p class="text-muted mb-1"><small>Returning Flight</small>
                                                        <small
                                                            class="ms-1">(<?php echo e(\Carbon\Carbon::parse($second_firstSegment->departure->at)->format('d-m-Y')); ?>

                                                            )</small>
                                                    </p>
                                                </div>
                                                <div class="split_cards">
                                                    <div class="card_one">
                                                        <p>
                                                            <small><?php echo e(\Carbon\Carbon::parse($second_firstSegment->departure->at)->format('H:i')); ?></small>
                                                        </p>
                                                        <p>
                                                            <small><?php echo e(formatDuration( $flight->itineraries[1]->duration)); ?></small>
                                                        </p>
                                                        <p>
                                                            <small><?php echo e(\Carbon\Carbon::parse($second_lastSegment->arrival->at)->format('H:i')); ?> </small>
                                                        </p>
                                                    </div>
                                                    <div class="card_two">
                                                        <div class="line"></div>
                                                        <i class="bi bi-airplane-fill"></i>
                                                        <div class="line"></div>
                                                    </div>
                                                    <div class="card_one">
                                                        <p>
                                                            <small><?php echo e($arrival); ?>

                                                                (<?php echo e($second_firstSegment->departure->iataCode); ?>

                                                                )</small>
                                                        </p>
                                                        <p>
                                                            <small><img src="<?php echo e($second_imageUrl); ?>"
                                                                        alt="<?php echo e($second_airlineCode); ?>"
                                                                        title="<?php echo e($second_airlineCode); ?>" height="20px"></small>
                                                            <small
                                                                class="ms-1"> <?php echo e($flight->travelerPricings[0]->fareDetailsBySegment[0]->cabin); ?></small>
                                                        </p>
                                                        <p>
                                                            <small><?php echo e($departure); ?>

                                                                (<?php echo e($second_lastSegment->arrival->iataCode); ?>)</small>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="upper_card">
                                                    <p class="text-muted mb-1">
                                                        <small><?php echo e(\App\Models\Airline::where('code', $firstSegment->carrierCode)->first()->name); ?></small>
                                                        <small class="ms-1">(<?php echo e($firstSegment->carrierCode); ?>)</small>
                                                    </p>
                                                </div>

                                                <div class="line"></div>
                                                <hr/>
                                                <div class="lower_card h-100">

                                                    <h3 class="mb-0">

                                                    </h3>

                                                    <form action="<?php echo e(route('flight-price')); ?>"
                                                          id="form<?php echo e($flight->id); ?>" method="GET" class="form">
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="flight"
                                                               value="<?php echo e(json_encode($flight)); ?>"/>
                                                        <input type="hidden" name="flightofferid"
                                                               value="<?php echo e($flight->id); ?>"/>
                                                        <input type="hidden" name="departure" value="<?php echo e($departure); ?>"/>
                                                        <input type="hidden" name="arrival" value="<?php echo e($arrival); ?>"/>
                                                        <input type="hidden" name="flight_option"
                                                               value="<?php echo e($flight_option); ?>"/>
                                                        <button type="submit" class="btn btn-primary">Select</button>
                                                    </form>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php else: ?>
                                <?php
                                    $segments = $flight->itineraries[0]->segments;
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
                                <div class="my-3">
                                    <div class="flight_card">
                                        <div class="upper_card">
                                            <p class="text-muted mb-1"><small>Departing Flight </small>
                                                <small
                                                    class="ms-1">(<?php echo e(\Carbon\Carbon::parse($firstSegment->departure->at)->format('d-m-Y')); ?>

                                                    )</small>
                                            </p>
                                        </div>
                                        <div class="split_cards">
                                            <div class="card_one">
                                                <p>
                                                    <small><?php echo e(\Carbon\Carbon::parse($firstSegment->departure->at)->format('H:i')); ?></small>
                                                </p>
                                                <p>
                                                    <small><?php echo e(formatDuration( $flight->itineraries[0]->duration)); ?></small>
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
                                                    <small><?php echo e($departure); ?> (<?php echo e($firstSegment->departure->iataCode); ?>

                                                        )</small>
                                                </p>
                                                <p>
                                                    &nbsp;
                                                    <small><img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($airlineCode); ?>"
                                                                title="<?php echo e($airlineCode); ?>" height="20px"></small>
                                                    <small
                                                        class="ms-1"> <?php echo e($flight->travelerPricings[0]->fareDetailsBySegment[0]->cabin); ?></small>
                                                    Seats : <?php echo e($flight->numberOfBookableSeats); ?>

                                                </p>
                                                <p>
                                                    <small>
                                                        <?php echo e($arrival); ?> (<?php echo e($lastSegment->arrival->iataCode); ?>)
                                                    </small>
                                                </p>

                                            </div>
                                            <div class="card_two" style="margin-left: 20px;margin-right: 50px;">
                                                <div class="line"></div>
                                                <i class="bi bi-airplane-fill"></i>
                                                <div class="line"></div>
                                            </div>
                                            <div>
                                                <?php if($flight->price->currency == 'ZAR'): ?>
                                                    ZAR
                                                <?php else: ?>
                                                    USD
                                                <?php endif; ?>
                                                <?php echo e($flight->price->total); ?>


                                            </div>
                                            
                                        </div>
                                        <div
                                            class="upper_card">
                                            <?php
                                                $airline = \App\Models\Airline::where('code', $firstSegment->carrierCode)->first();
                                            ?>
                                            <p class="text-muted mb-1">
                                                <small><?php echo e($airline ? $airline->name : 'Unknown Airline'); ?></small>
                                                <small class="ms-1">(<?php echo e($firstSegment->carrierCode); ?>)</small>
                                            </p>
                                        </div>

                                        <div class="line"></div>
                                        <hr/>
                                        <div class="lower_card h-100">

                                            <h3 class="mb-0" style="font-weight:190;">
                                                <style>
                                                    .details {
                                                        display: none;
                                                    }
                                                </style>
                                                <a href="#" class="toggle-details" data-flight-id="<?php echo e($flight->id); ?>">
                                                    <i class="fas fa-chevron-down"></i> <span>More Detail</span>
                                                </a>

                                                <div class="details" id="details-<?php echo e($flight->id); ?>">
                                                    <p>Will add more detail about flight like stops.....</p>
                                                </div>

                                            </h3>

                                            <form action="<?php echo e(route('flight-seat-map')); ?>" id="form<?php echo e($flight->id); ?>"
                                                  method="POST" class="form">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="flight"
                                                       value="<?php echo e(json_encode($flight) ?? ''); ?>"/>
                                                <input type="hidden" name="departure" value="<?php echo e($departure ?? ''); ?>"/>
                                                <input type="hidden" name="flight_option"
                                                       value="<?php echo e($flight_option ?? ''); ?>"/>
                                                <input type="hidden" name="arrival" value="<?php echo e($arrival ?? ''); ?>"/>
                                                <input type="hidden" name="offerId" value="<?php echo e($flight->id ?? ''); ?>"/>
                                                <button type="submit" class="btn btn-primary">Select</button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>
<?php endif; ?>

<script src="<?php echo e(asset('js/jquery-3.5.1.min.js')); ?>"></script>
<script>
    $(document).ready(function () {
        $('.toggle-details').on('click', function (event) {
            event.preventDefault(); // Prevent the default action of the link

            // Get the flight ID from the data attribute
            var flightId = $(this).data('flight-id');
            // Find the corresponding details section by ID
            var $details = $('#details-' + flightId);
            var $icon = $(this).find('i');
            var $text = $(this).find('span');

            if ($details.is(':visible')) {
                // Hide details
                $details.hide();
                $text.text('More Detail');
                $icon.removeClass('fa-chevron-up').addClass('fa-chevron-down'); // Revert icon
            } else {
                // Show details
                $details.show();
                $text.text('Less Detail');
                $icon.removeClass('fa-chevron-down').addClass('fa-chevron-up'); // Change icon
            }

            // Debugging
            console.log('Flight ID:', flightId);
            console.log('Details Display:', $details.css('display'));
            console.log('Icon Class:', $icon.attr('class'));
            console.log('Text Content:', $text.text());
        });
    });

</script>

<script>
    // Function to clear input fields
    function clearInputs() {
        var airportTo = document.getElementById('airportTo');
        var destination = document.getElementById('destination');

        if (airportTo) airportTo.value = '';
        if (destination) destination.value = '';
    }

    // Clear inputs on page load
    window.onload = clearInputs;

    // Clear inputs when the page is shown from the back-forward cache
    window.addEventListener('pageshow', function (event) {
        if (event.persisted) {
            clearInputs();
        }
    });

    // document.addEventListener('DOMContentLoaded', function() {
    //             var userMessageElement = document.getElementById('userMessage');
    //                 if (userMessageElement) {
    //                     setTimeout(function() {
    //                         userMessageElement.style.display = 'none';
    //                     }, 30000); // 5000 milliseconds = 5 seconds
    //                 }
    //             });
</script>





<?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/layouts/flightsearchwidget.blade.php ENDPATH**/ ?>