@extends('layouts.auth.app')
@section('content')
<style>


.bg-blue {
  background: blue;
}

.dotted-line {
  border: 1px dashed green;
}

.img-fluid {
  width: 114px;
  height: auto;
}

.bg-top {
  background: #ffffff;
}
.btn-light:hover {
            background-color: orange;
            color: #fff; /* Set text color to white or any other contrasting color */
        }
</style>
     
<div class="row">
    @foreach($flightOffers as $flightOffer)
    @php
    $airlineCode = $flightOffer->getValidatingAirlineCodes()[0];
    $imageUrl = "https://www.gstatic.com/flights/airline_logos/70px/dark/{$airlineCode}.png";
    @endphp
            <div class="col-12">
                <div class="card ">
                    <div class="card-body d-flex flex-column justify-content-between text-dark p-0">
                        <div class="p-4 bg-top">
                            <div class="d-flex flex-row justify-content-between">
                                <div class="d-flex flex-column justify-content-between align-items-center">
                                    <h1>{{ $flightOffer->getItineraries()[0]->getSegments()[0]->getDeparture()->getIataCode() }}</h1>
                                    <span class="mb-2">Indianapolis</span>
                                    <span>{{ \Carbon\Carbon::parse($flightOffer->getItineraries()[0]->getSegments()[0]->getDeparture()->getAt())->format('Y-m-d') }}</div>
                                <div class="d-flex flex-column justify-content-center">
                                     <img src="{{ $imageUrl }}" alt="Airline Logo">
                                     {{ formatDuration($flightOffer->getItineraries()[0]->getDuration()) }}
                                     <small>{{ $flightOffer->getItineraries()[0]->getSegments()[0]->getNumberOfStops() }} stop(s)</small>

                                    <!--<i class="fa fa-plane fa-3x"></i>-->
                                </div>
                                <div class="d-flex flex-column justify-content-between align-items-center">
                                    <h1>{{ $flightOffer->getItineraries()[0]->getSegments()[0]->getArrival()->getIataCode() }}</h1><span class="mb-2">Paris</span>
                                    <span>{{ \Carbon\Carbon::parse($flightOffer->getItineraries()[0]->getSegments()[0]->getArrival()->getAt())->format('Y-m-d') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-success p-4">
                            <div class="d-flex flex-column justify-content-between">
                                <div class="d-flex flex-row justify-content-between text-center">
                                    <div><span class="d-block font-weight-bold">Class</span><span>{{ $flightOffer->getTravelerPricings()[0]->getFareDetailsBySegment()[0]->getCabin() }}</span></div>
                                    <div><span class="d-block font-weight-bold">Seats</span><span>{{ $flightOffer->getNumberOfBookableSeats() }}</span></div>
                                    <div><span class="d-block font-weight-bold">Boarding Time</span><span>{{ \Carbon\Carbon::parse($flightOffer->getItineraries()[0]->getSegments()[0]->getDeparture()->getAt())->format('h:i A') }}</span></div>
                                    <div><span class="d-block font-weight-bold">Arrival Time</span><span>{{ \Carbon\Carbon::parse($flightOffer->getItineraries()[0]->getSegments()[0]->getArrival()->getAt())->format('h:i A') }}</span></div>
                                </div>
                                <div class="doted-lines">
                                    <hr class="dotted-line">
                                </div>
                                <div class="d-flex flex-row justify-content-between">
                                    <div class="d-flex flex-column">
                                        <div><span class="d-block font-weight-bold">{{ $flightOffer->getTravelerPricings()[0]->getPrice()->getTotal() }}</span><span>PRICE ( {{ $flightOffer->getTravelerPricings()[0]->getPrice()->getCurrency() }})</span></div>
                                    </div>
                                    <div class="d-flex flex-column justify-content-between">
                                        <a href="#" class="btn btn-light btn-lg">Book Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @endforeach
</div>
@endsection
