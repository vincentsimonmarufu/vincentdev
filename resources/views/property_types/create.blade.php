@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Create Property Type</h3>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                {!!Form::open(['action'=>'App\Http\Controllers\PropertyTypeController@store', 'files'=>true])!!}
                @csrf
                <div class="mb-3">
                    <label class="form-label">Property Type Name</label>
                    {{Form::text('name', null, ['class'=>'form-control', 'required', 'placeholder'=>'Property Type Name'])}}
                </div>
                {{Form::submit('Save', ['class'=>'btn btn-primary'])}}
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>
@endsection