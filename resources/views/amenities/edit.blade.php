@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Update Amenity</h3>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                {!!Form::open(['action'=>['AmenityController@update', $amenity->id], 'method'=>'PUT'])!!}
                @csrf
                    <div class="mb-3">
                        {{Form::text('name', $amenity->name, ['class'=>'form-control', 'required', 'placeholder'=>'name'])}}
                    </div>
                    <div class="mb-3">
                        {{Form::text('icon', $amenity->icon, ['class'=>'form-control', 'required', 'placeholder'=>'icon html code'])}}
                    </div>
                    {{Form::submit('Update', ['class'=>'btn btn-primary'])}}
                {!!Form::close()!!} 
            </div>
        </div>
    </div>
</div>
@endsection