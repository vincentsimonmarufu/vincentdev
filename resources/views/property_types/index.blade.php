@extends('layouts.auth.app')
@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>All Property Types</h3>
            <a class="btn btn-dark" href="{{route('property_types.create')}}">Create</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="example2" class="table table-striped table-bordered table-hover">
                    <thead>
                        <th>Name</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($propertyTypes as $propertyType)
                        <tr>
                            <td>{{$propertyType->name}}</td>
                            <td>
                                <a href="{{route('property_types.edit', $propertyType->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                &nbsp;<br /><br />
                                {!!Form::open(['action'=>['App\Http\Controllers\PropertyTypeController@destroy', $propertyType->id], 'method'=>'DELETE'])!!}
                                {{Form::submit('Delete', ['class'=>'btn btn-danger btn-sm'])}}
                                {!!Form::close()!!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        <div class="card-footer">
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