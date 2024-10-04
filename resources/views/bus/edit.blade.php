@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Update Bus</h3>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                {!!Form::open(['action'=>['App\Http\Controllers\BusController@update', $bus->id], 'method' => 'PUT' , 'files'=>true])!!}
                @csrf
                <div class="mb-3">
                    <label class="form-label">Company Name / Owner Name</label>
                    {{Form::text('name', $bus->name, ['class'=>'form-control', 'required', 'placeholder'=>'Company Name / Owner Name'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Number of Seats</label>
                    {{Form::text('seater', $bus->seater, ['class'=>'form-control', 'required', 'placeholder'=>'Number of seats'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    {{Form::textarea('address', $bus->address, ['class'=>'form-control', 'required', 'placeholder'=>'Address', 'rows'=>'3'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">City</label>
                    {{Form::text('city', $bus->city, ['class'=>'form-control', 'required', 'placeholder'=>'city'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Country</label>
                    {{Form::select('country', $countries,$bus->country, ['class'=>'form-control single-select', 'required', 'placeholder'=>'country'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Make</label>
                    {{Form::text('make', $bus->make, ['class'=>'form-control', 'required', 'placeholder'=>'make'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Model</label>
                    {{Form::text('model', $bus->model, ['class'=>'form-control', 'required', 'placeholder'=>'model'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Year</label>
                    {{Form::number('year', $bus->year, ['class'=>'form-control', 'required', 'placeholder'=>'year'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Engine Size</label>
                    {{Form::number('engine_size', $bus->engine_size, ['class'=>'form-control', 'placeholder'=>'engine_size'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Fuel Type</label>
                    {{Form::select('fuel_type', ['petrol'=>'petrol', 'diesel'=>'diesel', 'electric'=>'electric'] ,  $bus->fuel_type, ['class'=>'form-control', 'required', 'placeholder'=>'fuel type'])}}

                </div>
                <div class="mb-3">
                    <label class="form-label">Weight</label>
                    {{Form::number('weight', $bus->weight, ['class'=>'form-control', 'placeholder'=>'weight'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Color</label>
                    {{Form::text('color', $bus->color, ['class'=>'form-control', 'required', 'placeholder'=>'Color'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Transmission</label>
                    {{Form::select('transmission', ['manual'=>'manual', 'automatic'=>'automatic'] , $bus->transmission, ['class'=>'form-control', 'required', 'placeholder'=>'Transmission'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Price</label>
                    {{Form::number('price', $bus->price, ['class'=>'form-control', 'required', 'placeholder'=>'price', 'step'=>'0.01'])}}
                </div>
                @if (Auth::user()->role == 'admin')
                <div class="mb-3">
                    {{ Form::label('name', 'Status') }}
                    {{ Form::select('status',
                       array('active' => 'Active','inactive' => 'Inactive','pending' => 'pending'),
                       $bus->status,
                           ['class'=>'form-control', 'required', 'placeholder'=>'select status']
                        ) }}
                </div>
                @else
                <div class="mb-3">
                    {{ Form::label('name', 'Status') }}
                    {{ Form::select('status',
                   array('pending' => 'pending','inactive' => 'Inactive'),
                   $bus->status,
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