@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Create Apartment</h3>
        </div>
        <div class="card-body">
            {!!Form::open(['action'=>['App\Http\Controllers\ApartmentController@update', $apartment->id], 'method'=>'PUT'])!!}
            @csrf
            <div class="mb-3">
                {{ Form::label('name', 'Company Name / Owner Name') }}
                {{Form::text('name', $apartment->name, ['class'=>'form-control', 'required', 'placeholder'=>'Company Name / Owner Name'])}}
            </div>
            <div class="mb-3">
                {{ Form::label('name', 'Address') }}
                {{Form::textarea('address', $apartment->address, ['class'=>'form-control', 'required', 'placeholder'=>'Address', 'rows'=>'3'])}}
            </div>
            <div class="mb-3">
                {{ Form::label('name', 'City') }}
                {{Form::text('city', $apartment->city, ['class'=>'form-control', 'required', 'placeholder'=>'city'])}}
            </div>
            <div class="mb-3">
                {{ Form::label('name', 'Country') }}
                {{Form::select('country', $countries, $apartment->country, ['class'=>'form-control single-select', 'required', 'placeholder'=>'country'])}}
            </div>
            <div class="mb-3">
                {{ Form::label('name', 'No. of guests') }}
                {{Form::number('guest', $apartment->guest, ['class'=>'form-control', 'required', 'placeholder'=>'No. of Guests'])}}
            </div>
            <div class="mb-3">
                {{ Form::label('name', 'Bedrooms') }}
                {{Form::number('bedroom', $apartment->bedroom, ['class'=>'form-control', 'required', 'placeholder'=>'bedrooms'])}}
            </div>
            <div class="mb-3">
                {{ Form::label('name', 'Bathrooms') }}
                {{Form::number('bathroom', $apartment->bathroom, ['class'=>'form-control', 'required', 'placeholder'=>'bathrooms'])}}
            </div>
            <div class="mb-3">
                {{ Form::label('name', 'Price') }}
                {{Form::text('price', $apartment->price, ['class'=>'form-control', 'required', 'placeholder'=>'price'])}}
            </div>
            @if (Auth::user()->role == 'admin')
            <div class="mb-3">
                {{ Form::label('name', 'Status') }}
                {{ Form::select('status',
                       array('active' => 'Active','inactive' => 'Inactive','pending' => 'pending'),
                       $apartment->status,
                           ['class'=>'form-control', 'required', 'placeholder'=>'select status']
                        ) }}
            </div>
            @else
            <div class="mb-3">
                {{ Form::label('name', 'Status') }}
                {{ Form::select('status',
                   array('pending' => 'pending','inactive' => 'Inactive'),
                   $apartment->status,
                       ['class'=>'form-control', 'required', 'placeholder'=>'select status']
                    ) }}
            </div>
            @endif

            {{Form::submit('Update', ['class'=>'btn btn-primary'])}}
            {!!Form::close()!!}
        </div>
    </div>
</div>
@endsection