@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Update Location</h3>
        </div>
        <div class="card-body">
            <div class="col-lg-6">
                {!!Form::open(['action'=>['LocationController@update', $location->id], 'method' => 'PUT'])!!}
                @csrf
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        {{Form::text('name', $location->name, ['class'=>'form-control', 'required', 'placeholder'=>'name'])}}
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        {{Form::textarea('description', $location->description, ['class'=>'form-control', 'required', 'placeholder'=>'description'])}}
                    </div>
                    {{Form::submit('Update', ['class'=>'btn btn-primary'])}}
                {!!Form::close()!!} 
            </div>
        </div>
    </div>
</div>
@endsection