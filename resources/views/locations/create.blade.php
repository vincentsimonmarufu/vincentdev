@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Create Location</h3>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                {!!Form::open(['action'=>'LocationController@store', 'files'=>true])!!}
                @csrf
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        {{Form::text('name', null, ['class'=>'form-control', 'required', 'placeholder'=>'name'])}}
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        {{Form::textarea('description', null, ['class'=>'form-control', 'required', 'placeholder'=>'description'])}}
                    </div>
                    <div class="mb-3 row">
                        {{Form::label('pictures[]', 'Pictures', ['class'=>'col-lg-12 col-form-label'])}}
                        {{Form::file('pictures[]', ['multiple', 'accept'=>'image/*', 'required'])}}
                    </div> 
                    {{Form::submit('Save', ['class'=>'btn btn-primary'])}}
                {!!Form::close()!!} 
            </div>
        </div>
    </div>
</div>
@endsection