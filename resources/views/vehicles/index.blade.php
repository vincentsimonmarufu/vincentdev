@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">

        <div class="card-header">
            <h3>All vehicles</h3>
        </div>
        @if ( $vehicles->count() > 0)
        <div class="alert alert-warning" role="alert">
            We charge 10% for every approved vehicle or apartment booking
        </div>
        @endif
        <div class="card-footer">
            <a class="btn btn-dark" href="{{route('vehicles.create')}}">Create</a>
        </div>
        <div class="card-body">

            <div class="table-reponsive">
                <table id="example2" data-order='[[ 0, "asc" ]]' class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Fullname</th>
                            <th>Country</th>
                            <th>Make</th>
                            <th>Model</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($vehicles->count() > 0)
                        @foreach ($vehicles as $vehicle)
                        <tr>
                            <td>{{$vehicle->user->name .' '.$vehicle->user->surname  }}<br />
                                <small>{{$vehicle->user->email}} <br /> {{$vehicle->user->phone}}</small>
                            </td>
                            <td>{{$vehicle->country}}</td>
                            <td>{{$vehicle->make}}</td>
                            <td>{{$vehicle->model}}</td>
                            <td>{{$vehicle->price}}</td>
                            <td>{{$vehicle->status}}</td>
                            <td>
                                @if (Auth::user()->role == 'admin')
                                <a href="{{route('vehicle.activate', $vehicle->id)}}" class="btn btn-info">Activate</a>
                                @endif
                                <a href="{{route('vehicles.show', $vehicle->id)}}" class="btn btn-success btn-sm">View</a>
                                <a href="{{route('vehicles.edit', $vehicle->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                {!!Form::open(['action'=>['App\Http\Controllers\VehicleController@destroy', $vehicle->id], 'method'=>'DELETE'])!!}
                                {{Form::submit('Delete', ['class'=>'btn btn-danger btn-sm'])}}
                                {!!Form::close()!!}
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
    $(document).ready(function() {
        $('#dtBasicExample').DataTable();
    });
</script>

@endsection
@endsection