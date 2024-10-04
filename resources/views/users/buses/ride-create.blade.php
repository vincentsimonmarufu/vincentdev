@extends('layouts.auth.app')
@section('content')
<div class="container">
<div class="card">
        <div class="card-header">
            <h3>Create rides</h3>
        </div>
        <div class="card-body">       
            <div class="col-lg-12">
            {!! Form::open(['action' => ['App\Http\Controllers\BusController@saveBusRide']]) !!}
            <div class="mb-3">
                <label class="form-label" for="route-select">Route Name</label>
                {{ Form::select('route_name', $routes, null, ['id' => 'route-select', 'class' => 'form-control single-select', 'required', 'placeholder' => '-- Select Route Name --']) }}
            </div> 
            <div class="mb-3">
                <label class="form-label" for="bus-select">Bus Name</label>
                {{ Form::select('bus_name', $buses, null, ['id' => 'bus-select', 'class' => 'form-control single-select', 'required', 'placeholder' => '-- Select Bus Name --']) }}
            </div> 
            <?php
                $minTime = '00:00';
                $maxTime = '23:59';            
                $date = date('Y-m-d');
                $maxDate = date('Y-m-d', strtotime('+1 year'));
            ?>
            <div class="mb-3"> 
            <label class="form-label" for="bus-select">Departure time</label>                 
            {{ Form::input('time', 'depart_time', null, ['id' => 'depart_time', 'min' => $minTime, 'max' => $maxTime, 'class' => 'form-control col-sm-6 booking_date', 'required', 'placeholder' => 'Select Time']) }}
            </div>
            <div class="mb-3">
                <label class="form-label" for="bus-select">Departure date</label>                
                {{Form::date('depart_date', null, ['id'=>'depart_date', 'min'=>$date,'max'=> $maxDate, 'class'=>'form-control col-sm-6', 'required', 'placeholder'=>'Select date'])}}
            </div>           
                {{ Form::submit('Create', ['class' => 'btn btn-success btn-lg']) }}
            {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection