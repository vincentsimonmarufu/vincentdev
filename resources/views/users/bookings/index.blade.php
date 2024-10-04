@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>{{$user->name}} {{$user->surname}} - Bookings</h3>
        </div>
        <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" data-order='[[ 0, "desc" ]]' class="table table-striped table-bordered table-hover">
                        <thead>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Check in</th>
                            <th>Check out</th>
                            <th>Reference</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach ($user->bookings as $booking)
                            <tr>
                                <td>{{$booking->created_at}}</td>
                                <td>
                                    @php
                                       if ($booking->apartments->count() > 0)
                                       {
                                        $type = "Apartment";
                                       }
                                       elseif ($booking->vehicles->count() > 0)
                                       {
                                        $type = "Vehicle";
                                       }
                                       elseif ($booking->buses->count() > 0)
                                       {
                                        $type = "Bus";
                                       }
                                       elseif ($booking->shuttles->count() > 0)
                                       {
                                        $type = "Shuttle";
                                       }
                                       else{
                                        $type = "N/A";
                                       }
                                    
                                    @endphp
                                    {{ $type }}</td>
                                <td>{{$booking->start_date}}</td>
                                <td>{{$booking->end_date}}</td>
                                <td>{{$booking->reference}}</td>
                                <td>{{$booking->status}}</td>
                                <td><a class="btn btn-success btn-sm" href="{{ route('bookings.show', $booking->id) }}">View</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            
        </div>
    </div>
</div>
@section('scripts')
 <script type="text/javascript">
$(document).ready(function () {
$('#dtBasicExample').DataTable();
});
    </script>
@endsection
@endsection