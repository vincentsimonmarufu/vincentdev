<div class="container">
    <div class=" p-5" style="background: #fff">
        <h3 class="">Flight Details</h3>
        <ul class="list-group">
            <li class="list-group-item"><b>Price:</b> 
                @if ($data->flightOffers[0]->price->currency == 'ZAR')
                    R 
                @else
                    $
                @endif {{ $data->flightOffers[0]->price->grandTotal }} </li>
            <li class="list-group-item"><b>Currency:</b> {{ $data->flightOffers[0]->price->currency }}</li>  
            <li class="list-group-item"><b>Last Ticketing Date:</b> {{ $data->flightOffers[0]->lastTicketingDate }}</li>
            <li class="list-group-item"><b>Flight Option:</b> {{ $flight_option }}</li>  
            <li class="list-group-item"><b>Cabin:</b> {{ $data->flightOffers[0]->travelerPricings[0]->fareDetailsBySegment[0]->cabin }}</li>  
            <li class="list-group-item"><b> Number of Travellers:</b> {{ count($data->flightOffers[0]->travelerPricings) }}</li>
        </ul>

        <h4 class=" mt-5">Itinerary Details</h4>
        <ul class="list-group">
            @foreach($data->flightOffers[0]->itineraries as $index => $itinerary)
                @if($flight_option == "multi-city")
                    <h4 class=" mt-5"> Trip  {{ $index + 1 }}</h4>
                @endif
                    @foreach($itinerary->segments as  $segment)

                        @php
                            $airlineCode = $segment->carrierCode;
                            // $imageUrl = "https://www.gstatic.com/flights/airline_logos/70px/dark/{$airlineCode}.png";
                            $imageUrl = "https://images.kiwi.com/airlines/32x32/{$airlineCode}.png?default=airline.png";

                            //$accessTokenController = app('App\Http\Controllers\AmadeusController');
                            $accessTokenController = app('App\Http\Controllers\WelcomeController');
                            $name = $accessTokenController->airlineName($airlineCode);

                            //$accessTokenController = app('App\Http\Controllers\WelcomeController');
                            $departure = $accessTokenController->airportName( $segment->departure->iataCode);
                            $arrival = $accessTokenController->airportName( $segment->arrival->iataCode);
                        @endphp

                        <li class="list-group-item"> <img src="{{ $imageUrl }}" alt="Airline Logo"> &nbsp; &nbsp; {{ $name }}</li>
                        <li class="list-group-item"> <b>Departure: </b> {{ $departure ?? ''}} ({{ $segment->departure->iataCode }}) </li>
                        <li class="list-group-item"><b> At: </b> {{ \Carbon\Carbon::parse($segment->departure->at)->format('Y-m-d H:i:s') }}</li>
                        <li class="list-group-item"><b>Arrival: </b> {{ $arrival ?? ''}} ({{ $segment->arrival->iataCode }} )</li>
                        <li class="list-group-item"><b> At: </b> {{ \Carbon\Carbon::parse($segment->arrival->at)->format('Y-m-d H:i:s') }}</li>
                        <li class="list-group-item"><b>Duration: </b> {{ formatDuration( $segment->duration) }}</li>
                        <li class="list-group-item"><b>Number Of Stops: </b> {{  $segment->numberOfStops }}</li>
                        <li class="list-group-item"> <b>Cabin Class: </b> {{ $segment->co2Emissions[0]->cabin }}</li>
                        <br/>  
                    @endforeach
        
            @endforeach
        </ul>

        <h4 class="mt-2">Baggage Allowance (Checked baggage permitted)</h4>
            <ul class="list-group">
                @if(isset($data->flightOffers[0]->travelerPricings[0]->fareDetailsBySegment[0]->includedCheckedBags->quantity))
                    <li class="list-group-item" style="border-bottom:none;padding-bottom:0px;">
                        <b>Quantity:</b> {{ $data->flightOffers[0]->travelerPricings[0]->fareDetailsBySegment[0]->includedCheckedBags->quantity }} piece(s) per person
                    </li>
                @elseif(isset($data->flightOffers[0]->travelerPricings[0]->fareDetailsBySegment[0]->includedCheckedBags->weight))
                    <li class="list-group-item" style="border-bottom:none;padding-bottom:0px;">
                        <b>Weight:</b> {{ $data->flightOffers[0]->travelerPricings[0]->fareDetailsBySegment[0]->includedCheckedBags->weight }} kg per person
                    </li>
                @endif
                <li class="list-group-item" style="border-bottom:none;padding-bottom:0px;">
                    <b>Ticketing:</b> Within 2 hours after payment
                </li>
                <li class="list-group-item">
                    <b><a href="#" title="View details about baggage allowances and policy information.">Baggage & Policy details</a></b>
                </li>
            </ul>

        <h4 class=" mt-3">Booking Requirements</h4>

        <form action="{{ route('flightbooking') }}" method="post" enctype="multipart/form-data">
            @csrf
            @for ($i = 0; $i < count($data->flightOffers[0]->travelerPricings); $i++)
                <h4>Passenger {{ $i + 1 }}</h4>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-12">
                        <div class="mb-3">
                            <label for="first_name_{{ $i }}">First Name</label>
                            <input type="hidden" name="passengers[{{ $i }}][id]" id="id_{{ $i }}" value="{{ $i + 1 }}" class="form-control" required>
                            <input type="text" name="passengers[{{ $i }}][name][firstName]" id="first_name_{{ $i }}" class="form-control" placeholder="First Name" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12 col-12">
                        <div class="mb-3">
                            <label for="last_name_{{ $i }}">Last Name</label>
                            <input type="text" name="passengers[{{ $i }}][name][lastName]" id="last_name_{{ $i }}" class="form-control" placeholder="Last Name" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12 col-12">
                        <div class="mb-3">
                            <label for="dob_{{ $i }}">Date of Birth <small>(2000-01-30)(year-month-date)</small></label>
                            <input type="text" name="passengers[{{ $i }}][dob]" id="dob_{{ $i }}" class="form-control" placeholder="2000-01-30" pattern="\d{4}-\d{2}-\d{2}" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12 col-12">
                        <div class="mb-3">
                            <label for="gender_{{ $i }}">Gender</label>
                            <select style="height: 50px;border-radius: 0px !important;" name="passengers[{{ $i }}][gender]" id="gender_{{ $i }}" class="form-control" required>
                                <option value="MALE">Male</option>
                                <option value="FEMALE">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12 col-12">
                        <div class="mb-3">
                            <label for="email_{{ $i }}">Email</label>
                            <input type="email" name="passengers[{{ $i }}][contact][emailAddress]" id="email_{{ $i }}" class="form-control" placeholder="Email" required>
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-12 col-12">
                        <div class="mb-3">
                            <label for="phone_{{ $i }}">Dial Code</label>
                            <div class="input-group">
                                <select name="passengers[{{ $i }}][contact][phones][0][countryCallingCode]" id="phone_country_{{ $i }}" class="form-control select2" required>
                                    <option value="" selected disabled>Dial Code</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->dial_code }}">{{ $country->dial_code }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-12 col-12">
                        <div class="mb-3">
                            <label for="phone_{{ $i }}">Phone Number</label>
                            <div class="input-group">
                                <input type="number" name="passengers[{{ $i }}][contact][phones][0][number]" id="phone_number_{{ $i }}" class="form-control" placeholder="Phone Number" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="mb-3">
                            <label for="passport_{{ $i }}">Passport Photo</label>
                            <input type="file" name="passengers[{{ $i }}][passport]" id="passport_{{ $i }}" class="form-control">
                        </div>
                    </div>
                </div>                
            @endfor

            <input type="hidden" name="data" value="{{ json_encode($data) }}" />
            <input type="hidden" name="departure" value="{{ $departure }}" />
            <input type="hidden" name="arrival" value="{{ $arrival }}" />
            <input type="hidden" name="price" value="{{ $data->flightOffers[0]->price->grandTotal }}" />
            <input type="hidden" name="currency" value="{{ $data->flightOffers[0]->price->currency }}" />
            <input type="hidden" name="flight_option" value="{{ $flight_option }}" />
            <input type="hidden" name="airline" value="{{ $name }}" />

            @if (auth()->user() != null)
                <!-- Show the BOOK NOW button if the user is logged in -->
                <button class="btn btn-success form-control" id="bookNowButton" type="submit">BOOK NOW</button>
                @else
                <!-- Code to execute when there is no authenticated user -->
                <p id="accountpanel">
                    Please
                    <a href="#" id="loginLink" data-toggle="modal" data-target="#loginModal"><b>LOGIN</b></a>
                    or
                    <a href="#" id="registerLink" data-toggle="modal" data-target="#registerModal"><b>CREATE</b></a>
                    an account to proceed.<br />
                    <small class="text-danger"></small>
                </p>
            @endif
            <div id="mybutton"></div>
        </form>       
    </div>
</div>

@include('layouts.login_modal')
@include('layouts.register_modal')


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
                url: "{{ route('modal-login') }}",             
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
                url: "{{ route('modal-register') }}",             
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
