@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <!-- <h1>Flight Bookings</h1> -->
            @if(Auth::user()->role != 'admin')
            <a class="btn btn-success" href="{{route('flights.searching')}}">Book Flight</a>
           @endif
        </div>
        <div class="card-body col-12">
                <div class="table-responsive">
                    <table id="example2" data-order='[[ 0, "desc" ]]' class="table table-striped table-bordered table-hover">
                        <thead>
                                <th>Date</th>
                                <th>Reference</th>
                                <th>Fullname</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Airline</th>
                                <th>Travel Class</th>
                                <th>Flight Option</th>
                                <th>Status</th>
                                <th >Action</th>
                           
                        </thead>
                        <tbody>
                            @if($flightRequests->count() > 0)
                        @foreach ($flightRequests as $flightRequest)
                            <tr>
                                <td>{{  \Carbon\Carbon::parse($flightRequest->created_at)->format('d-m-Y') }}</td>
                                <td>{{ $flightRequest->reference }}</td>
                                <td>{{ $flightRequest->user->surname ?? 'Not found' }} {{ $flightRequest->user->name ?? "Not found" }}</td>
                                <td>{{ $flightRequest->departure }}</td>
                                <td>{{ $flightRequest->arrival }}</td>
                                <td>{{ $flightRequest->airline }}</td>
                                <td>{{ $flightRequest->travel_class }}</td>
                                <td>{{ $flightRequest->flight_option }}</td>
                                <td>{{ $flightRequest->status }}</td>
                                <td>
                                    <a href="{{route('view.flights', $flightRequest->reference)}}" class="btn btn-primary btn-md">View</a>
                                </td>
                            </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
           
        </div>
    </div>
</div>
    
@section('scripts')
<script type="text/javascript">
$(document).ready(function () {
    $('#dtBasicExample').DataTable({
        responsive: true
    });
});
    </script>
@endsection
@endsection