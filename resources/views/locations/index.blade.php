@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>All locations</h3>
        </div>
        <div class="card-body">
            @if ($locations->count() > 0)
                <div class="table-reponsive">
                    <table id="example2" data-order='[[ 0, "asc" ]]' class="table table-striped table-bordered table-hover">
                        <thead>
                            <th>name</th>
                            <th>Description</th>
                            <th >Action</th>
                        </thead>
                        <tbody>
                        @foreach ($locations as $location)
                            <tr>
                                <td>{{$location->name}}</td>
                                <td>{{$location->description}}</td>
                                <td><a href="{{route('locations.activities.index', $location->id)}}" class="btn btn-primary">Activities</a>
                                <a href="{{route('locations.show', $location->id)}}", class="btn btn-primary">View</a>
                                <a href="{{route('locations.edit', $location->id)}}" class="btn btn-primary">Edit</a>
                                    {!!Form::open(['action'=>['LocationController@destroy', $location->id], 'method'=>'DELETE'])!!}
                                        {{Form::submit('Delete', ['class'=>'btn btn-danger'])}}
                                    {!!Form::close()!!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-info">There are no locations yet</p>
            @endif
        </div>
        <div class="card-footer">
            <a class="btn btn-primary" href="{{route('locations.create')}}">Create</a>
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