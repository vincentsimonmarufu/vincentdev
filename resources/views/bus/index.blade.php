@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">

        <div class="card-header">
            <h3>All buses</h3>
        </div>
        @if ( $buses->count() > 0)
        <div class="alert alert-warning" role="alert">
            We charge 10% for every approved bus or apartment booking
        </div>
        @endif
        <div class="card-footer">
            <a class="btn btn-dark" href="{{route('buses.create')}}">Create</a>
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
                            <th>Seats</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($buses->count() > 0)
                        @foreach ($buses as $bus)
                        <tr>
                            <td>{{$bus->user->name .' '.$bus->user->surname  }}<br />
                                <small>{{$bus->user->email}} <br /> {{$bus->user->phone}}</small>
                            </td>
                            <td>{{$bus->country}}</td>
                            <td>{{$bus->make}}</td>
                            <td>{{$bus->model}}</td>
                            <td>{{$bus->seater}}</td>
                            <td>{{$bus->price}}</td>
                            <td>{{$bus->status}}</td>
                            <td>
                                @if (Auth::user()->role == 'admin')
                                <a href="{{route('bus.activate', $bus->id)}}" class="btn btn-info">Activate</a>
                                @endif
                                <a href="{{route('buses.show', $bus->id)}}" class="btn btn-success btn-sm">View</a>
                                <a href="{{route('buses.edit', $bus->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                {!!Form::open(['action'=>['App\Http\Controllers\BusController@destroy', $bus->id], 'method'=>'DELETE'])!!}
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