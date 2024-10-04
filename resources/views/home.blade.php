@extends('layouts.auth.app')

@section('content')
<div class="container justify-content-center">
    <div class="row  mb-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header ">Dashboard</div>
                @if ($apartments->count() > 0 || $vehicles->count() > 0)
                <div class="alert alert-warning" role="alert">
                    We charge 10% for every approved vehicle or apartment booking
                </div>
                @endif
                <div class="card-body">
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
    @if ($apartments->count() > 0)
    <div class="mb-2">
        <h3>Your Apartments</h3>
        <div class="row">
            @foreach($apartments as $apartment)
            <div class="card col-lg-12">
                <div class="card-header">
                    <p>Owner: {{$apartment->name}}</p>
                    <p>Address: {{$apartment->address}}</p>
                    <p>City: {{$apartment->city}}</p>
                </div>
                <div class="card-body">
                    @if ($apartment->bookings->count() > 0)
                    <table id="example" class="table table-bordered table-striped table-hover">
                        <thead>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            @foreach($apartment->bookings as $booking)
                            <tr>
                                <td>{{$booking->pivot->start_date}}</td>
                                <td>{{$booking->pivot->end_date}}</td>
                                <td>{{$booking->pivot->status}}</td>
                                <td>
                                    @if ($booking->pivot->status == 'Awaiting Approval')
                                    <a href="{{route('bookable.status', [$booking->pivot->id, 'Approved'])}}" class="btn btn-primary">Approve</a>
                                    <a href="{{route('bookable.status', [$booking->pivot->id, 'Decline'])}}" class="btn btn-danger btn-sm">Decline</a>
                                    @endif
                                    @if ($booking->pivot->status == 'Approved')
                                    <a href="{{route('bookable.status', [$booking->pivot->id, 'Checked In'])}}" class="btn btn-primary">Check In</a>
                                    <a href="{{route('bookable.status', [$booking->pivot->id, 'Decline'])}}" class="btn btn-danger btn-sm">Unbook</a>
                                    @endif
                                    @if ($booking->pivot->status == 'Checked In')
                                    <a href="{{route('bookable.status', [$booking->pivot->id, 'Checked Out'])}}" class="btn btn-primary">Check Out</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-info">There are no bookings yet!</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if ($vehicles->count() > 0)
    <div class="mb-2">
        <h3>Your Vehicles</h3>
        <div class="row">
            @foreach ($vehicles as $vehicle)
            <div class="card col-lg-12">
                <div class="card-header">
                    <p>Make: {{$vehicle->make}}</p>
                    <p>Model: {{$vehicle->model}}</p>
                    <p>Address: {{$vehicle->address}}</p>
                    <p>City: {{$vehicle->city}}</p>
                </div>
                <div class="card-body">
                    @if ($vehicle->bookings->count() > 0)
                    <table id="dtBasicExample" class="table table-bordered table-striped table-hover">

                        <thead>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($vehicle->bookings as $booking)
                            <tr>
                                <td>{{$booking->pivot->start_date}}</td>
                                <td>{{$booking->pivot->end_date}}</td>
                                <td>{{$booking->pivot->status}}</td>
                                <td>
                                    @if ($booking->pivot->status == 'Awaiting Approval')
                                    <a href="{{route('bookable.status', [$booking->pivot->id, 'Approved'])}}" class="btn btn-primary">Approve</a>
                                    <a href="{{route('bookable.status', [$booking->pivot->id, 'Decline'])}}" class="btn btn-danger">Decline</a>
                                    @endif
                                    @if ($booking->pivot->status == 'Approved')
                                    <a href="{{route('bookable.status', [$booking->pivot->id, 'Checked In'])}}" class="btn btn-primary">Check In</a>
                                    <a href="{{route('bookable.status', [$booking->pivot->id, 'Decline'])}}" class="btn btn-danger">Unbook</a>
                                    @endif
                                    @if ($booking->pivot->status == 'Checked In')
                                    <a href="{{route('bookable.status', [$booking->pivot->id, 'Checked Out'])}}" class="btn btn-primary">Check Out</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-info">There are no bookings yet!</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if ($buses->count() > 0)
    <div class="mb-2">
        <h3>Your Buses</h3>
        <div class="row">
            @foreach ($buses as $bus)
            <div class="card col-lg-12">
                <div class="card-header">
                    <p>Make: {{$bus->make}}</p>
                    <p>Model: {{$bus->model}}</p>
                    <p>Address: {{$bus->address}}</p>
                    <p>City: {{$bus->city}}</p>
                </div>
                <div class="card-body">
                    @if ($bus->bookings->count() > 0)
                    <table id="dtBasicExample" class="table table-bordered table-striped table-hover">

                        <thead>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($bus->bookings as $booking)
                            <tr>
                                <td>{{$booking->pivot->start_date}}</td>
                                <td>{{$booking->pivot->end_date}}</td>
                                <td>{{$booking->pivot->status}}</td>
                                <td>
                                    @if ($booking->pivot->status == 'Awaiting Approval')
                                    <a href="{{route('bookable.status', [$booking->pivot->id, 'Approved'])}}" class="btn btn-primary">Approve</a>
                                    <a href="{{route('bookable.status', [$booking->pivot->id, 'Decline'])}}" class="btn btn-danger">Decline</a>
                                    @endif
                                    @if ($booking->pivot->status == 'Approved')
                                    <a href="{{route('bookable.status', [$booking->pivot->id, 'Checked In'])}}" class="btn btn-primary">Check In</a>
                                    <a href="{{route('bookable.status', [$booking->pivot->id, 'Decline'])}}" class="btn btn-danger">Unbook</a>
                                    @endif
                                    @if ($booking->pivot->status == 'Checked In')
                                    <a href="{{route('bookable.status', [$booking->pivot->id, 'Checked Out'])}}" class="btn btn-primary">Check Out</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-info">There are no bookings yet!</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    @if ($shuttles->count() > 0)
    <div class="mb-2">
        <h3>Your Shuttles</h3>
        <div class="row">
            @foreach ($shuttles as $shuttle)
            <div class="card col-lg-12">
                <div class="card-header">
                    <p>Make: {{$shuttle->make}}</p>
                    <p>Model: {{$shuttle->model}}</p>
                    <p>Address: {{$shuttle->address}}</p>
                    <p>City: {{$shuttle->city}}</p>
                </div>
                <div class="card-body">
                    @if ($shuttle->bookings->count() > 0)
                    <table id="dtBasicExample" class="table table-bordered table-striped table-hover">

                        <thead>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($shuttle->bookings as $booking)
                            <tr>
                                <td>{{$booking->pivot->start_date}}</td>
                                <td>{{$booking->pivot->end_date}}</td>
                                <td>{{$booking->pivot->status}}</td>
                                <td>
                                    @if ($booking->pivot->status == 'Awaiting Approval')
                                    <a href="{{route('bookable.status', [$booking->pivot->id, 'Approved'])}}" class="btn btn-primary">Approve</a>
                                    <a href="{{route('bookable.status', [$booking->pivot->id, 'Decline'])}}" class="btn btn-danger">Decline</a>
                                    @endif
                                    @if ($booking->pivot->status == 'Approved')
                                    <a href="{{route('bookable.status', [$booking->pivot->id, 'Checked In'])}}" class="btn btn-primary">Check In</a>
                                    <a href="{{route('bookable.status', [$booking->pivot->id, 'Decline'])}}" class="btn btn-danger">Unbook</a>
                                    @endif
                                    @if ($booking->pivot->status == 'Checked In')
                                    <a href="{{route('bookable.status', [$booking->pivot->id, 'Checked Out'])}}" class="btn btn-primary">Check Out</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-info">There are no bookings yet!</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#dtBasicExample').DataTable();

    });
</script>
<script type="text/javascript">
    $(document).ready(function() {

        $('#example').DataTable();
    });
</script>
@endsection
@endsection