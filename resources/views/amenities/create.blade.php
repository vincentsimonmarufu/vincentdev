@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Create Amenity</h3>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                {!!Form::open(['action'=>'AmenityController@store'])!!}
                @csrf
                    <div class="mb-3">
                        {{Form::text('name', null, ['class'=>'form-control', 'required', 'placeholder'=>'name'])}}
                    </div>
                    <div class="mb-3">
                        {{Form::text('icon', null, ['class'=>'form-control', 'required', 'placeholder'=>'icon html code'])}}
                    </div>
                    {{Form::submit('Save', ['class'=>'btn btn-primary'])}}
                {!!Form::close()!!} 
            </div>
        </div>
    </div>
</div>
@endsection