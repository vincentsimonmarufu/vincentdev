@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>My Shuttles</h3>
            <div class="alert alert-warning" role="alert">
                We charge 10% for every approved shuttle or apartment booking
            </div>
        </div>
        <div class="card-footer">
            <a class="btn btn-dark" href="{{route('users.shuttle.create', auth()->user()->id)}}">Create</a>
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
                        @foreach ($user->shuttles as $shuttle)
                        <tr>
                            <td>{{$shuttle->address}},<br />
                                <small>{{$shuttle->city}},</small>
                                <small>{{$shuttle->country}}</small>
                            </td>
                            <td>{{$shuttle->make}}</td>
                            <td>{{$shuttle->model}}</td>
                            <td>{{$shuttle->seater}}</td>
                            <td>{{$shuttle->color}}</td>
                            <td>{{$shuttle->price}}</td>
                            <td>{{$shuttle->status}}</td>
                            <td>
                                <a href="{{route('shuttles.show', $shuttle->id)}}" class="btn btn-info btn-sm">View</a>
                                <a href="{{route('shuttles.edit', $shuttle->id)}}" class="btn btn-success btn-sm">Edit</a>

                                {!!Form::open(['action'=>['App\Http\Controllers\ShuttleController@destroy', $shuttle->id], 'method'=>'DELETE'])!!}
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