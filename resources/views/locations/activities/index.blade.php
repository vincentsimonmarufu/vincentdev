@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>{{$location->name}} - Activities</h3>
        </div>
        <div class="card-body">
            @if ($location->activities()->count() > 0)
                <div class="table-reponsive">
                    <table id="example2" data-order='[[ 0, "asc" ]]' class="table table-striped table-bordered table-hover">
                        <thead>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th >Action</th>
                        </thead>
                        <tbody>
                        @foreach ($location->activities as $activity)
                            <tr>
                                <td>{{$activity->name}}</td>
                                <td>{{$activity->description}}</td>
                                <td>{{$activity->price}}</td>
                                <td><a href="{{route('locations.activities.show', [$location->id, $activity->id])}}" class="btn btn-primary">View</a>
                                <a href="{{route('locations.activities.edit', [$location->id, $activity->id])}}" class="btn btn-primary">Edit</a>
                                
                                    {!!Form::open(['action'=>['LocationActivityController@destroy', $location->id, $activity->id], 'method'=>'DELETE'])!!}
                                        {{Form::submit('Delete', ['class'=>'btn btn-danger'])}}
                                    {!!Form::close()!!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-info">There are no activities yet</p>
            @endif
        </div>
        <div class="card-footer">
            <a class="btn btn-primary" href="{{route('locations.activities.create', $location->id)}}">Create</a>
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