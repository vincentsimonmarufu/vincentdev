@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>All amenities</h3>
        </div>
        <div class="card-body">
            @if ($amenities->count() > 0)
                <div class="table-reponsive">
                    <table id="example2" data-order='[[ 0, "asc" ]]' class="table table-striped table-bordered table-hover">
                        <thead>
                            <th>name</th>
                            <th>icon</th>
                            <th >Action</th>
                        </thead>
                        <tbody>
                        @foreach ($amenities as $amenity)
                            <tr>
                                <td>{{$amenity->name}}</td>
                                <td>{!!$amenity->icon!!}</td>
                                <td><a href="{{route('amenities.show', $amenity->id)}}" class="btn btn-primary">View</a>
                                <a href="{{route('amenities.edit', $amenity->id)}}" class="btn btn-primary">Edit</a>
                                    {!!Form::open(['action'=>['AmenityController@destroy', $amenity->id], 'method'=>'DELETE'])!!}
                                        {{Form::submit('Delete', ['class'=>'btn btn-danger'])}}
                                    {!!Form::close()!!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-info">There are no amenities yet</p>
            @endif
        </div>
        <div class="card-footer">
            <a class="btn btn-primary" href="{{route('amenities.create')}}">Create</a>
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