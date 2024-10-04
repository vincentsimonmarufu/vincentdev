@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">

        <div class="card-header">
            <h3>All shuttles</h3>
        </div>
        @if ( $shuttles->count() > 0)
        <div class="alert alert-warning" role="alert">
            We charge 10% for every approved shuttle or apartment booking
        </div>
        @endif
        <div class="card-footer">
            <a class="btn btn-dark" href="{{route('shuttles.create')}}">Create</a>
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
                        @if ($shuttles->count() > 0)
                        @foreach ($shuttles as $shuttle)
                        <tr>
                            <td>{{$shuttle->user->name .' '.$shuttle->user->surname  }}<br />
                                <small>{{$shuttle->user->email}} <br /> {{$shuttle->user->phone}}</small>
                            </td>
                            <td>{{$shuttle->country}}</td>
                            <td>{{$shuttle->make}}</td>
                            <td>{{$shuttle->model}}</td>
                            <td>{{$shuttle->seater}}</td>
                            <td>{{$shuttle->price}}</td>
                            <td>{{$shuttle->status}}</td>
                            <td>
                                @if (Auth::user()->role == 'admin')
                                <a href="{{route('shuttle.activate', $shuttle->id)}}" class="btn btn-info">Activate</a>
                                @endif
                                <a href="{{route('shuttles.show', $shuttle->id)}}" class="btn btn-success btn-sm">View</a>
                                <a href="{{route('shuttles.edit', $shuttle->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                {!!Form::open(['action'=>['App\Http\Controllers\ShuttleController@destroy', $shuttle->id], 'method'=>'DELETE'])!!}
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