@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">

        <div class="card-header">
            <h3>All apartments</h3>
        </div>
        @if ($apartments->count() > 0)
        <div class="alert alert-warning" role="alert">
            We charge 10% for every approved vehicle or apartment booking
        </div>
        @endif
        <div class="card-footer">
            <a class="btn btn-dark" href="{{route('apartments.create')}}">Create</a>
        </div>
        <div class="card-body">
            <div class="table-reponsive">
                <table id="example2" data-order='[[ 0, "asc" ]]' class="table table-striped table-bordered table-hover">
                    <thead>
                        <th>Fullname</th>
                        <th>City</th>
                        <th>Beds</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($apartments as $apartment)
                        <tr>
                            <td>{{$apartment->user->name .' '.$apartment->user->surname  }}<br />
                                <small>{{$apartment->user->phone}} <br /> {{$apartment->user->email}}</small>
                            </td>
                            <td>{{$apartment->city}}<br />
                                <small>{{$apartment->country}}</small>
                            </td>
                            <td>{{$apartment->bedroom}}</td>
                            <td>{{number_format($apartment->price,2)}}</td>
                            <td>{{$apartment->status}}</td>
                            <td>
                                @if (Auth::user()->role == 'admin')
                                <a href="{{route('apartment.activate', $apartment->id)}}" class="btn btn-success btn-sm">Activate</a>
                                @endif
                                <a href="{{route('apartments.show', $apartment->id)}}" class="btn btn-info btn-sm">View</a>
                                <a href="{{route('apartments.edit', $apartment->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                {!!Form::open(['action'=>['App\Http\Controllers\ApartmentController@destroy', $apartment->id], 'method'=>'DELETE'])!!}
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