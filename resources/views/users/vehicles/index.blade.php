@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>My vehicles</h3>
            <div class="alert alert-warning" role="alert">
                We charge 10% for every approved vehicle or apartment booking
            </div>
        </div>
        <div class="card-footer">
            <a class="btn btn-dark" href="{{route('users.vehicles.create', auth()->user()->id)}}">Create</a>
        </div>
        <div class="card-body">
            <div class="table-reponsive">
                <table id="example2" data-order='[[ 0, "asc" ]]' class="table table-striped table-bordered table-hover">
                    <thead>
                        <th>Address</th>
                        <th>Make</th>
                        <th>Model</th>
                        <th>Color</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($user->vehicles as $vehicle)
                        <tr>
                            <td>{{$vehicle->address}},<br />
                                <small>{{$vehicle->city}},</small>
                                <small>{{$vehicle->country}}</small>
                            </td>
                            <td>{{$vehicle->make}}</td>
                            <td>{{$vehicle->model}}</td>
                            <td>{{$vehicle->color}}</td>
                            <td>{{$vehicle->price}}</td>
                            <td>{{$vehicle->status}}</td>
                            <td>
                                <a href="{{route('vehicles.show', $vehicle->id)}}" class="btn btn-info btn-sm">View</a>
                                <a href="{{route('vehicles.edit', $vehicle->id)}}" class="btn btn-success btn-sm">Edit</a>

                                {!!Form::open(['action'=>['App\Http\Controllers\VehicleController@destroy', $vehicle->id], 'method'=>'DELETE'])!!}
                                {{Form::submit('Delete', ['class'=>'btn btn-danger btn-sm'])}}
                                {!!Form::close()!!}
                            </td>
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
    $(document).ready(function() {
        $('#dtBasicExample').DataTable();
    });
</script>
@endsection
@endsection