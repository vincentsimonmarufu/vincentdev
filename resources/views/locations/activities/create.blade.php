@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>{{$location->name}} - Create Activity</h3>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                {!!Form::open(['action'=>['LocationActivityController@store', $location->id], 'files'=>true])!!}
                @csrf
                    <div class="mb-3">
                        {{Form::text('name', null, ['class'=>'form-control', 'required', 'placeholder'=>'name', 'max'=>'255'])}}
                    </div>
                    <div class="mb-3">
                        {{Form::textarea('description', null, ['class'=>'form-control', 'required', 'placeholder'=>'description', 'max'=>'255'])}}
                    </div>
                    <div class="mb-3">
                        {{Form::number('price', null, ['class'=>'form-control', 'required', 'placeholder'=>'price', 'step'=>'0.01', 'min'=>'0'])}}
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