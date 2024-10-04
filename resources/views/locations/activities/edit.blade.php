@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>{{$location->name}} - Update Activity</h3>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                {!!Form::open(['action'=>['LocationActivityController@update', $location->id, $activity->id], 'method' => 'PUT'])!!}
                @csrf
                    <div class="mb-3">
                        {{Form::text('name', $activity->name, ['class'=>'form-control', 'required', 'placeholder'=>'name', 'max'=>'255'])}}
                    </div>
                    <div class="mb-3">
                        {{Form::textarea('description', $activity->description, ['class'=>'form-control', 'required', 'placeholder'=>'description', 'max'=>'255'])}}
                    </div>
                    <div class="mb-3">
                        {{Form::number('price', $activity->price, ['class'=>'form-control', 'required', 'placeholder'=>'price', 'step'=>'0.01', 'min'=>'0'])}}
                    </div>
                    {{Form::submit('Update', ['class'=>'btn btn-primary'])}}
                {!!Form::close()!!} 
            </div>
        </div>
    </div>
</div>
@endsection