@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Update Property Type</h3>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                {!!Form::open(['action'=>['App\Http\Controllers\PropertyTypeController@update', $propertyType->id], 'files'=>true, 'method'=>'PUT'])!!}
                @csrf
                <div class="mb-3">
                    <label class="form-label">Property Type Name</label>
                    {{Form::text('name', $propertyType->name, ['class'=>'form-control', 'required', 'placeholder'=>'Property Type Name'])}}
                </div>
                {{Form::submit('Update', ['class'=>'btn btn-primary'])}}
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>
@endsection