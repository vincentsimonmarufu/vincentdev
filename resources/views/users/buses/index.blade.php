@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>My Buses</h3>
            <div class="alert alert-warning" role="alert">
                We charge 10% for every approved bus or apartment booking
            </div>
        </div>
        <div class="card-footer">
            <a class="btn btn-dark" href="{{route('users.bus.create', auth()->user()->id)}}">Create</a>
        </div>
           
        <div class="card-body">
            <div class="table-reponsive">
                <table id="example2" data-order='[[ 0, "asc" ]]' class="table table-striped table-bordered table-hover">
                    <thead>
                        <th>Address</th>
                        <th>Make</th>
                        <th>Model</th>
                        <th>Seater</th>
                        <th>Color</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($user->buses as $bus)
                        <tr>
                            <td>{{$bus->address}},<br />
                                <small>{{$bus->city}},</small>
                                <small>{{$bus->country}}</small>
                            </td>
                            <td>{{$bus->make}}</td>
                            <td>{{$bus->model}}</td>
                            <td>{{$bus->seater}}</td>
                            <td>{{$bus->color}}</td>
                            <td>{{$bus->price}}</td>
                            <td>{{$bus->status}}</td>
                            <td>
                                <a href="{{route('buses.show', $bus->id)}}" class="btn btn-info btn-sm">View</a>
                                <a href="{{route('buses.edit', $bus->id)}}" class="btn btn-success btn-sm mt-1">Edit</a>

                                {!!Form::open(['action'=>['App\Http\Controllers\BusController@destroy', $bus->id], 'method'=>'DELETE'])!!}
                                {{Form::submit('Delete', ['class'=>'btn btn-danger btn-sm'])}}
                                {!!Form::close()!!}                                  
                                {{-- <a class="btn btn-dark mt-1" href="{{route('buses.addbusroute', $bus->id)}}">Add Bus route</a> --}}                                                                                                                
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