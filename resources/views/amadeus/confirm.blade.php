@extends('layouts.auth.app')
@section('content')

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <a href="javascript:history.go(-1)" class="btn btn-success">Return back</a>

    </div>
    @else
    <div class="card p-3">
        <h3 class="text-right">Your Order Details</h3>
        <!-- <p class="alert alert-success bg-success">Sucessfully booked flight</p> -->        
        <ul class="list-group">
                <li class="list-group-item">
                    <b>ID</b>: {{ $flight->id }}<br/>              
                    <b>Queuing Office Id</b>: JNBZA2195<br/>            
                        @foreach ($flight->associatedRecords as $associatedRecords)
                            <b>Reference</b>:  {{ $associatedRecords->reference}}<br/>
                        @endforeach
                </li>
                <h6 class="text-right mt-2 mb-1"> Travelers Details</h6>
                <li class="list-group-item">
                    @foreach ($flight->travelers as $index => $traveler)
                    <h4>Passenger {{ $index + 1 }}</h4>
                    <b>Fullname</b>:  {{ $traveler->name->firstName}}  {{ $traveler->name->lastName}}<br/>
                    <b>Date of birth</b>:  {{ $traveler->dateOfBirth}}<br/>
                    <b>Gender</b>:  {{ $traveler->gender}}<br/><br/>               
                    @endforeach
                </li>
            <h6 class="text-right mt-2 mb-1"> Price Details</h6>
                <li class="list-group-item">
                    @foreach ($flight->flightOffers as $flightOffer)
                        <b>Price</b>:  {{ $flightOffer->price->grandTotal}}<br/>
                        <b>Currency</b>:  {{ $flightOffer->price->currency}}<br/>
                    @endforeach
                </li>
                <h6 class="text-right mt-2 mb-1">Itenary Details</h6>
                @foreach($flight->flightOffers[0]->itineraries as $itinerary)
                    @foreach($itinerary->segments as $segment)
                        @php
                        $airlineCode = $segment->carrierCode;
                        $imageUrl = "https://www.gstatic.com/flights/airline_logos/70px/dark/{$airlineCode}.png";
                        $accessTokenController = app('App\Http\Controllers\AmadeusController');
                        //$name = $accessTokenController->getName($airlineCode);
                        $name = \App\Models\Airline::where('code', $airlineCode)->first()->name
                        @endphp
                        <li class="list-group-item"> <img src="{{ $imageUrl }}" alt="Airline Logo"> &nbsp; &nbsp; {{ $name }}</br>
                            <b>Departure:</b>  {{ $segment->departure->iataCode }}  at {{ \Carbon\Carbon::parse($segment->departure->at)->format('Y-m-d H:i:s') }}</br>
                            <b>Arrival:</b> {{ $segment->arrival->iataCode }} at {{ \Carbon\Carbon::parse($segment->arrival->at)->format('Y-m-d H:i:s') }}</br>
                            <b>Duration:</b> {{ formatDuration( $segment->duration) }}</br>
                            <b>Number Of Stops:</b> {{  $segment->numberOfStops }}</br>
                            <b>Cabin Class:</b> {{ $segment->co2Emissions[0]->cabin }} </br> 
                        </li>                 
                    @endforeach
                @endforeach         
        </ul><br>

            <!-- Seat Selection Modal -->
            <div class="modal fade" id="seatSelectionModal" tabindex="-1" role="dialog" aria-labelledby="seatSelectionModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="seatSelectionModalLabel">Select Your Seat</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Seat Map content goes here -->   
                            @php
                                $flightId = $flight->id;
                            @endphp
                            <p>Flight ID: {{ $flightId }}</p>
                                   
                            <div id="seatMap"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="confirmSeatSelection">Confirm Selection</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{ $flight->id }}" id="selectSeat">
                <label class="form-check-label mb-1" for="selectSeat">
                    <b>Select Seat </b>(If you would like to prioritize seat selection, please select)
                </label>
            </div>

        <button class="btn btn-success form-control" type="button" id="bookNowButton"  data-flightOrderId="{{ $flight->id }}">Pay</button>
    </div>
 @endif

 <script>
    $(document).ready(function() {

        $('#bookNowButton').on('click', function() {
     
            if ($('#selectSeat').is(':checked')) {               
                var flightOrderId = $(this).attr('data-flightOrderId');                            
                $('#seatSelectionModal').modal('show');
            } else {               
                var flightOrderId = $(this).attr('data-flightOrderId');
                alert(flightOrderId); 
                // var confirmBooking = confirm("Are you sure you want to pay?");
                // if (confirmBooking) {
                //     var flightOrderId = $(this).data('flightOrderId');
                //     alert(flightOrderId);                    
                //     //$('#bookingForm').submit();
                // }
            }
        });

        $('#confirmSeatSelection').on('click', function() {           
            $('#seatSelectionModal').modal('hide');
            $('#bookingForm').submit();
        });

        // Fetch and display the seat map
        $('#seatSelectionModal').on('show.bs.modal', function() {
            // Get the value of the checkbox with ID 'selectSeat'
            var seatValue = $('#selectSeat').val();
            // Log the value for debugging (optional)
            console.log('Selected Seat Value:', seatValue);
            $.ajax({
                url: '/seats/select', 
                method: 'GET',
                data: { flightOrderId: seatValue }, 
                success: function(response) {                    
                    $('#seatMap').html(response);
                },
                error: function(xhr, status, error) {               
                    $('#seatMap').html('<p>Failed to load seat map. Please try again later.</p>');
                }
            });
        });

    });
   </script>
  


@endsection

