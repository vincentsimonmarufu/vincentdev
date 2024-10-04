@extends('layouts.auth.app')
@section('content')
    <div class="card p-5">
        <h2 class="text-center">Search Flights</h2>
        <form action="/searching" class="mt-3" method="POST">
            @csrf

            <div class="row">
                <div class="form-group col-6">
                    <input type="text" class="form-control" placeholder="From" name="from" required>
                </div>

                <div class="form-group col-6">
                    <input type="text" class="form-control" placeholder="To" name="to" required>
                </div>

                <div class="form-group col-6 mt-3">
                    <input type="date" class="form-control" placeholder="Departure Date" name="date" required>
                </div>

                <div class="form-group col-6 mt-3">
                    <input type="number" class="form-control" placeholder="Passengers" name="passengers" required>
                </div>

                <div class="form-group col-12 mt-3">
                    <button class="btn btn-primary form-control" type="submit">Search</button>
                </div>
            </div>
        </form>
        <br/>
   <h2>HRE - JNB example (2023-12-28)</h2>
   click the table row to view full detail
   <br/>
        @if(isset($flights) && count($flights) > 0)

            <h2 class="text-center mt-5">{{ count($flights) }} Results</h2>
            <table id="table" data-order='[[ 1, "asc" ]]' class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Departure</th>
                    <th scope="col">Duration</th>
                    <th scope="col">Arrival</th>
                    <th scope="col">Price </th>
                </tr>
                </thead>
                <tbody>
                    @foreach($flights as $flight) 
                        <tr onclick="document.getElementById('{{ 'form'.$flight->id }}').submit()">
                            <td scope="row">
                                @php
                                $airlineCode = $flight->itineraries[0]->segments[0]->carrierCode;
                                $imageUrl = "https://www.gstatic.com/flights/airline_logos/70px/dark/{$airlineCode}.png";
                                $accessTokenController = app('App\Http\Controllers\AmadeusController');
                                //$name = $accessTokenController->getName($airlineCode);
                            @endphp
                                &nbsp;<img src="{{ $imageUrl }}" alt="Airline Logo">
                               
                            </td>
                            <td> {{  \Carbon\Carbon::parse($flight->itineraries[0]->segments[0]->departure->at)->format('Y-m-d H:i:s') }}</td>
                            <td> {{ formatDuration( $flight->itineraries[0]->duration) }}</td>
                            <td> {{  \Carbon\Carbon::parse($flight->itineraries[0]->segments[0]->arrival->at)->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $flight->price->total }} {{ $flight->price->currency }}</td>
                        </tr>

                        <form action="/price" hidden id="{{ 'form' . $flight->id }}" method="POST">
                            @csrf

                            <input type="hidden" name="flight" value="{{ json_encode($flight) }}">
                        </form>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
