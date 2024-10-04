@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            @if (auth()->user()->id == $user->id)
            <h3>My apartments</h3>
            <div class="alert alert-warning" role="alert">
                We charge 10% for every approved vehicle or apartment booking
            </div>
            @else
            <h3>{{ $user->name }} {{ $user->suranme }} - Apartments</h3>
            @endif
        </div>
        <div class="card-footer">
            <a class="btn btn-dark" href="{{route('users.apartments.create', auth()->user()->id)}}">Create</a>
        </div>
        <div class="card-body">
            <div class="table-reponsive">
                <table id="example2" data-order='[[ 0, "asc" ]]' class="table table-striped table-bordered table-hover">
                    <thead>
                        <th>Address</th>
                        <th>Guest</th>
                        <th>Beds</th>
                        <th>Baths</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($user->apartments as $apartment)
                        <tr>
                            <td>{{$apartment->address}},<br />
                                <small>{{$apartment->city}},</small>
                                <small>{{$apartment->country}}</small>
                            </td>
                            <td>{{$apartment->guest}}</td>
                            <td>{{$apartment->bedroom}}</td>
                            <td>{{$apartment->bathroom}}</td>
                            <td>{{$apartment->price}}</td>
                            <td>{{$apartment->status}}</td>
                            <td>
                                <a href="{{route('apartments.show', $apartment->id)}}" class="btn btn-info btn-sm">View</a>
                                <a href="{{route('apartments.edit', $apartment->id)}}" class="btn btn-success btn-sm">Edit</a>

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