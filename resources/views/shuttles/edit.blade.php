@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Update shuttle</h3>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                {!!Form::open(['action'=>['App\Http\Controllers\ShuttleController@update', $shuttle->id], 'method' => 'PUT' , 'files'=>true])!!}
                @csrf
                <div class="mb-3">
                    <label class="form-label">Company Name / Owner Name</label>
                    {{Form::text('name', $shuttle->name, ['class'=>'form-control', 'required', 'placeholder'=>'Company Name / Owner Name'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Number of Seats</label>
                    {{Form::text('seater', $shuttle->seater, ['class'=>'form-control', 'required', 'placeholder'=>'Number of seats'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    {{Form::textarea('address', $shuttle->address, ['class'=>'form-control', 'required', 'placeholder'=>'Address', 'rows'=>'3'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">City</label>
                    {{Form::text('city', $shuttle->city, ['class'=>'form-control', 'required', 'placeholder'=>'city'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Country</label>
                    {{Form::select('country', $countries,$shuttle->country, ['class'=>'form-control single-select', 'required', 'placeholder'=>'country'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Make</label>
                    {{Form::text('make', $shuttle->make, ['class'=>'form-control', 'required', 'placeholder'=>'make'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Model</label>
                    {{Form::text('model', $shuttle->model, ['class'=>'form-control', 'required', 'placeholder'=>'model'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Year</label>
                    {{Form::number('year', $shuttle->year, ['class'=>'form-control', 'required', 'placeholder'=>'year'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Engine Size</label>
                    {{Form::number('engine_size', $shuttle->engine_size, ['class'=>'form-control', 'placeholder'=>'engine_size'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Fuel Type</label>
                    {{Form::select('fuel_type', ['petrol'=>'petrol', 'diesel'=>'diesel', 'electric'=>'electric'] ,  $shuttle->fuel_type, ['class'=>'form-control', 'required', 'placeholder'=>'fuel type'])}}

                </div>
                <div class="mb-3">
                    <label class="form-label">Weight</label>
                    {{Form::number('weight', $shuttle->weight, ['class'=>'form-control', 'placeholder'=>'weight'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Color</label>
                    {{Form::text('color', $shuttle->color, ['class'=>'form-control', 'required', 'placeholder'=>'Color'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Transmission</label>
                    {{Form::select('transmission', ['manual'=>'manual', 'automatic'=>'automatic'] , $shuttle->transmission, ['class'=>'form-control', 'required', 'placeholder'=>'Transmission'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Price</label>
                    {{Form::number('price', $shuttle->price, ['class'=>'form-control', 'required', 'placeholder'=>'price', 'step'=>'0.01'])}}
                </div>
                @if (Auth::user()->role == 'admin')
                <div class="mb-3">
                    {{ Form::label('name', 'Status') }}
                    {{ Form::select('status',
                       array('active' => 'Active','inactive' => 'Inactive','pending' => 'pending'),
                       $shuttle->status,
                           ['class'=>'form-control', 'required', 'placeholder'=>'select status']
                        ) }}
                </div>
                @else
                <div class="mb-3">
                    {{ Form::label('name', 'Status') }}
                    {{ Form::select('status',
                   array('pending' => 'pending','inactive' => 'Inactive'),
                   $shuttle->status,
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