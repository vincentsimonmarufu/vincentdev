<style>
    /* Add any custom styles here */
    .carousel-item {
        height: 95vh;
        /* Set carousel item height */
    }

    .carousel-item img {
        object-fit: cover;
        /* Cover image for responsive design */
        height: 95vh;
        /* Ensure images fill the height */
    }

    .form-rounded {
        border-radius: 1rem;
    }

    .form-control {
        position: relative;
    }

    .label {
        position: absolute;
        left: 10px;
        /* Position the label */
        top: -20px;
        /* Position above the input field */
        font-size: 0.75rem;
        /* Small font size */
        color: #000000;
        padding-left: 1rem;
        font-weight: bold;
        /* Color for label */
        opacity: 0;
        /* Initially hide the label */
        transition: opacity 0.3s;
        /* Transition for the opacity */
    }

    .form-control:hover + .label,
    .form-control:focus + .label {
        opacity: 1;
        /* Show label on hover and focus */
    }

    .input-container {
        position: relative;
    }

    #return-date {
        display: none;
        /* Initially hidden */
    }

    #multi-city {
        display: none;
        /* Initially hidden */
    }
</style>

<!-- Carousel with Static Text and Tabs -->
<div id="carouselExampleControls" class="carousel slide position-relative" data-ride="carousel"
     style="margin-top: 80px; height: 95vh;">
    <!-- Static Text Content -->
    <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center text-center"
         style="z-index: 10; ">
        <div class="container">
            <h1 class="text-white" style="font-size: 56px;"><span style="color: #08790c">Affordable Air Tickets</span>,
                Holiday Home, and Car
                Rental Services</h1>
            <p class="text-white">Your travel needs all in one place</p>

            <ul class="nav nav-tabs rounded-top" id="myTab" role="tablist">
                <li class="nav-item bg-white rounded-top mr-1">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                       aria-controls="home" aria-selected="true">Flights</a>
                </li>
                <li class="nav-item bg-white rounded-top mr-1">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                       aria-controls="profile" aria-selected="false">Apartments</a>
                </li>
                <li class="nav-item bg-white rounded-top">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                       aria-controls="contact" aria-selected="false">Vehicles</a>
                </li>
            </ul>
            <div class="tab-content border border-top-0 bg-white p-4 pb-0 rounded-bottom shadow-sm" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <form action="{{ route('flights.search') }}" method="POST">
                        @csrf
                        <div class="d-flex justify-content-start mb-3">
                            <div class="form-check mr-2">
                                <input class="form-check-input" type="radio" name="flight_option" id="oneway"
                                       value="one-way" checked onclick="toggleTripOptions()">
                                <label class="form-check-label" for="oneway">One way</label>
                            </div>
                            <div class="form-check mr-2">
                                <input class="form-check-input" type="radio" name="flight_option" id="return"
                                       value="return" onclick="toggleTripOptions()">
                                <label class="form-check-label" for="return">Return</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flight_option" id="multicity"
                                       value="multicity" onclick="toggleTripOptions()">
                                <label class="form-check-label" for="multicity">Multi City</label>
                            </div>
                        </div>

                        <div id="one-way">
                            <div class="row p-1">
                                <div class="col-md-3 pr-0 mb-1 input-container">
                                    <input type="text" name="origin_airport" class="form-control rounded oneway-input"
                                           placeholder="Where From"
                                           aria-label="From" id="airportInput">
                                    <label class="label">From</label>
                                    <!-- Add a hidden input field to store the selected IATA code -->
                                    <input type="hidden" name="origin" class="oneway-input" id="origin" />
                                </div>
                                <div class="col-md-3 pr-0 mb-1 input-container">
                                    <input type="text" name="destination_airport" class="form-control rounded oneway-input"
                                           placeholder="Where To"
                                           aria-label="To" id="airportTo">
                                    <label class="label">To</label>
                                    <!-- Add a hidden input field to store the selected IATA code -->
                                    <input type="hidden" name="destination" class="oneway-input" id="destination" />
                                </div>
                                <div class="col-md-2 pr-0 mb-1 input-container">
                                    <select name="cabin" id="" class="form-control rounded h-100 w-100 oneway-input"
                                    >
                                        <option value="ECONOMY">Economy</option>
                                        <option value="PREMIUM_ECONOMY">Premium Economy</option>
                                        <option value="BUSINESS">Business</option>
                                        <option value="FIRST">First Class</option>
                                    </select>
                                    <label class="label">Class</label>
                                </div>
                                <div class="col-md-2 pr-0 mb-1 input-container">
                                    <select name="currency" id="" class="form-control rounded h-100 w-100 oneway-input"
                                    >
                                        <option value="USD">USD 🇺🇸</option>
                                        <option value="ZAR">RANDS 🇿🇦</option>
                                    </select>
                                    <label class="label">Currency</label>
                                </div>
                                <div class="col-md-2 pr-0 mb-1 input-container">
                                    <input type="number" name="adults" class="form-control rounded oneway-input" title="Adults"
                                           placeholder="Adults" aria-label="Adults">
                                    <label class="label">No. of Adults</label>
                                </div>
                            </div>
                            <div class="row p-1 mt-1">
                                <?php
                                $currentDate = date('Y-m-d');
                                $oneYearLater = date('Y-m-d', strtotime('+1 year', strtotime($currentDate)));
                                ?>
                                <div class="col-md-2 pr-0 mb-1 input-container">
                                    <input type="number" name="children" class="form-control rounded oneway-input" title="Children"
                                           placeholder="Children" aria-label="Infants">
                                    <label class="label">No. of Children</label>
                                </div>
                                <div class="col-md-2 pr-0 mb-1 input-container">
                                    <input type="number" name="infants" class="form-control rounded oneway-input" title="Infants"
                                           placeholder="Infants" aria-label="Infants">
                                    <label class="label">No. of Infants</label>
                                </div>
                                <div class="col-md-3 pr-0 mb-1 input-container">
                                    <input type="date" name="departure_date" min="<?php echo $currentDate; ?>" max="<?php echo $oneYearLater; ?>" title="Departure Date" class="form-control oneway-input rounded"
                                           aria-label="Departure Date">
                                    <label class="label">Departure Date</label>
                                </div>
                                <div class="col-md-3 pr-0 mb-1 input-container" id="return-date">
                                    <input type="date" name="return_date" min="<?php echo $currentDate; ?>" max="<?php echo $oneYearLater; ?>" title="Return Date" class="form-control rounded oneway-input"
                                           aria-label="Return Date">
                                    <label class="label">Return Date</label>
                                </div>
                                <div class="col-md-2 pr-0 mb-1">
                                    <button type="submit" class="btn btn-success w-100" style="height: 100%">
                                        Search
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="multi-city">
                            <div class="row p-1">
                                <div class="col-md-3 pr-0 mb-1 input-container">
                                    <select name="cabin" id="" class="form-control multicity-input rounded h-100 w-100">
                                        <option value="ECONOMY">Economy</option>
                                        <option value="PREMIUM_ECONOMY">Premium Economy</option>
                                        <option value="BUSINESS">Business</option>
                                        <option value="FIRST">First Class</option>
                                    </select>
                                    <label class="label">Class</label>
                                </div>
                                <div class="col-md-3 pr-0 mb-1 input-container">
                                    <select name="currency" id="" class="form-control multicity-input rounded h-100 w-100"
                                    >
                                        <option value="USD">USD 🇺🇸</option>
                                        <option value="ZAR">RANDS 🇿🇦</option>
                                    </select>
                                    <label class="label">Currency</label>
                                </div>
                                <div class="col-md-2 pr-0 mb-1 input-container">
                                    <input type="number" name="adults" class="form-control multicity-input rounded" title="Adults"
                                           placeholder="Adults" aria-label="Adults">
                                    <label class="label">No. of Adults</label>
                                </div>
                                <div class="col-md-2 pr-0 mb-1 input-container">
                                    <input type="number" name="children" class="form-control multicity-input rounded" title="Children"
                                           placeholder="Children" aria-label="Infants">
                                    <label class="label">No. of Children</label>
                                </div>
                                <div class="col-md-2 pr-0 mb-1 input-container">
                                    <input type="number" name="infants" class="form-control multicity-input rounded" title="Infants"
                                           placeholder="Infants" aria-label="Infants">
                                    <label class="label">No. of Infants</label>
                                </div>
                            </div>
                            <div class="row p-1 mt-1">
                                <div class="col-md-4 pr-0 mb-1 input-container">
                                    <input type="text" name="origin_airport" id="airportInputM" class="form-control multicity-input rounded" placeholder="Where From"
                                           aria-label="From">
                                    <label class="label">Origin</label>
                                    <!-- Add a hidden input field to store the selected IATA code -->
                                    <input type="hidden" name="originM" class="multicity-input" id="originM" />
                                </div>
                                <div class="col-md-4 pr-0 mb-1 input-container">
                                    <input type="text" name="destination_airport" id="airportToM" class="form-control multicity-input rounded" placeholder="Where To"
                                           aria-label="To">
                                    <label class="label">Destination</label>
                                    <!-- Add a hidden input field to store the selected IATA code -->
                                    <input type="hidden" name="destinationM" class="multicity-input" id="destinationM" />
                                </div>
                                <div class="col-md-4 pr-0 mb-1 input-container">
                                    <input type="date" name="date" min="<?php echo $currentDate; ?>" max="<?php echo $oneYearLater; ?>" class="form-control multicity-input rounded" placeholder=""
                                           aria-label="To">
                                    <label class="label">Date</label>
                                </div>
                            </div>
                            <hr>
                            <div class="row w-100">
                                <div class="col text-left">
                                    <button class="btn btn-dark">Add Destination</button>
                                </div>
                                <div class="col text-right">
                                    <button type="submit" class="btn btn-success">Search</button>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <p>Pending implementation</p>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <p>Pending Data</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Carousel Images with Overlay -->
    <div class="carousel-inner h-100">
        <div class="carousel-item active">
            <img src="assets/img/slide/slide-2.jpg" class="d-block w-100" alt="Slide 1">
            <div class="position-absolute w-100 h-100"
                 style="top: 0; left: 0; background-color: rgba(51, 101, 53, 0.5);"></div>
        </div>
        <div class="carousel-item">
            <img src="assets/img/slide/slide-1.jpg" class="d-block w-100" alt="Slide 2">
            <div class="position-absolute w-100 h-100"
                 style="top: 0; left: 0; background-color: rgba(51, 101, 53, 0.5);"></div>
        </div>
        <div class="carousel-item">
            <img src="assets/img/slide/slide-3.jpg" class="d-block w-100" alt="Slide 3">
            <div class="position-absolute w-100 h-100"
                 style="top: 0; left: 0; background-color: rgba(51, 101, 53, 0.5);"></div>
        </div>
    </div>

    <!-- Carousel Controls -->
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev"
       style="z-index: 11;">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next"
       style="z-index: 11;">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<script>
    function toggleTripOptions() {
        const oneWay = document.getElementById('oneway').checked;
        const returnTrip = document.getElementById('return').checked;
        const multiCity = document.getElementById('multicity').checked;

        // Show/hide return date based on trip type
        document.getElementById('return-date').style.display = returnTrip ? 'block' : 'none';
        document.getElementById('multi-city').style.display = multiCity ? 'block' : 'none';
        document.getElementById('one-way').style.display = multiCity ? 'none' : 'block';

        // Toggle inputs based on selected trip type
        toggleForms();
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Set one-way form as active by default
        document.getElementById('oneway').checked = true;
        toggleTripOptions(); // Call the function to set the initial state

        // Listen to changes in the radio buttons
        document.getElementById('oneway').addEventListener('change', toggleTripOptions);
        document.getElementById('return').addEventListener('change', toggleTripOptions);
        document.getElementById('multicity').addEventListener('change', toggleTripOptions);
    });

    function toggleForms() {
        const isOneWay = document.getElementById('oneway').checked;
        const isReturn = document.getElementById('return').checked;

        if (isOneWay || isReturn) {
            // Enable one-way inputs and return date
            toggleInputFields('.oneway-input', true);
            toggleInputFields('.oneway-input[id="return-date"]', isReturn);
            toggleInputFields('.multicity-input', false);
        } else {
            // Enable multi-city inputs and disable one-way inputs
            toggleInputFields('.oneway-input', false);
            toggleInputFields('.multicity-input', true);
        }
    }

    // Helper function to enable/disable input fields
    function toggleInputFields(selector, enabled) {
        document.querySelectorAll(selector).forEach(input => {
            input.disabled = !enabled; // Disable/enable the input
        });
    }
</script>
