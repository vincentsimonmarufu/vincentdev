@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Update Vehicle</h3>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                {!!Form::open(['action'=>['App\Http\Controllers\VehicleController@update', $vehicle->id], 'method' => 'PUT' , 'files'=>true])!!}
                @csrf
                <div class="mb-3">
                    {{Form::text('name', $vehicle->name, ['class'=>'form-control', 'required', 'placeholder'=>'Company Name / Owner Name'])}}
                </div>
                <div class="mb-3">
                    {{Form::textarea('address', $vehicle->address, ['class'=>'form-control', 'required', 'placeholder'=>'Address', 'rows'=>'3'])}}
                </div>
                <div class="mb-3">
                    {{Form::text('city', $vehicle->city, ['class'=>'form-control', 'required', 'placeholder'=>'city'])}}
                </div>
                <div class="mb-3">
                    {{Form::select('country', $countries,$vehicle->country, ['class'=>'form-control single-select', 'required', 'placeholder'=>'country'])}}
                </div>
                <div class="mb-3">
                    {{Form::text('make', $vehicle->make, ['class'=>'form-control', 'required', 'placeholder'=>'make'])}}
                </div>
                <div class="mb-3">
                    {{Form::text('model', $vehicle->model, ['class'=>'form-control', 'required', 'placeholder'=>'model'])}}
                </div>
                <div class="mb-3">
                    {{Form::number('year', $vehicle->year, ['class'=>'form-control', 'required', 'placeholder'=>'year'])}}
                </div>
                <div class="mb-3">
                    {{Form::number('engine_size', $vehicle->engine_size, ['class'=>'form-control', 'placeholder'=>'engine_size'])}}
                </div>
                <div class="mb-3">
                    {{Form::select('fuel_type', ['petrol'=>'petrol', 'diesel'=>'diesel', 'electric'=>'electric'] ,  $vehicle->fuel_type, ['class'=>'form-control', 'required', 'placeholder'=>'fuel type'])}}

                </div>
                <div class="mb-3">
                    {{Form::number('weight', $vehicle->weight, ['class'=>'form-control', 'placeholder'=>'weight'])}}
                </div>
                <div class="mb-3">
                    {{Form::text('color', $vehicle->color, ['class'=>'form-control', 'required', 'placeholder'=>'Color'])}}
                </div>
                <div class="mb-3">
                    {{Form::select('transmission', ['manual'=>'manual', 'automatic'=>'automatic'] , $vehicle->transmission, ['class'=>'form-control', 'required', 'placeholder'=>'Transmission'])}}
                </div>
                <div class="mb-3">
                    {{Form::number('price', $vehicle->price, ['class'=>'form-control', 'required', 'placeholder'=>'price', 'step'=>'0.01'])}}
                </div>
                @if (Auth::user()->role == 'admin')
                <div class="mb-3">
                    {{ Form::label('name', 'Status') }}
                    {{ Form::select('status',
                       array('active' => 'Active','inactive' => 'Inactive','pending' => 'pending'),
                       $vehicle->status,
                           ['class'=>'form-control', 'required', 'placeholder'=>'select status']
                        ) }}
                </div>
                @else
                <div class="mb-3">
                    {{ Form::label('name', 'Status') }}
                    {{ Form::select('status',
                   array('pending' => 'pending','inactive' => 'Inactive'),
                   $vehicle->status,
                       ['class'=>'form-control', 'required', 'placeholder'=>'select status']
                    ) }}
                </div>
                @endif

                {{Form::submit('Update', ['class'=>'btn btn-primary'])}}
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>
@endsection