@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>{{ $user->name }} {{ $user->surname }} - Create Apartment</h3>
        </div>
        <div class="card-body">
            <span id="ip" style="display:none">{{ request()->ip() }}</span>
            <div class="col-lg-12">
                {!!Form::open(['action'=>['App\Http\Controllers\UserApartmentController@store', $user->id], 'files'=>true])!!}
                <div class="mb-3">
                    <label class="form-label">Company NAme or Owner Name</label>
                    {{Form::text('name', null, ['id'=>'name','class'=>'form-control', 'required', 'placeholder'=>'Company Name / Owner Name'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    {{Form::textarea('address', null, ['class'=>'form-control', 'required', 'placeholder'=>'Address', 'rows'=>'3'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">City</label>
                    {{Form::text('city', null, ['id'=>'city', 'class'=>'form-control', 'required', 'placeholder'=>'city'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Country</label>
                    {{Form::select('country', $countries, null, ['id'=>'country', 'class'=>'form-control single-select', 'required', 'placeholder'=>'country'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">MAx number of Guests</label>
                    {{Form::number('guest', null, ['class'=>'form-control', 'required', 'placeholder'=>'Max No. of Guests'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Bedrooms</label>
                    {{Form::number('bedroom', null, ['class'=>'form-control', 'required', 'placeholder'=>'bedrooms'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Bathrooms</label>
                    {{Form::number('bathroom', null, ['class'=>'form-control', 'required', 'placeholder'=>'bathrooms'])}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Price</label>
                    {{Form::number('price', null, ['class'=>'form-control', 'required', 'placeholder'=>'price', 'step'=>'0.01'])}}
                </div>
                <div class="mb-3 row">
                    {{Form::label('pictures[]', 'Pictures 300 * 300', ['class'=>'col-lg-12 col-form-label'])}}
                    {{Form::file('pictures[]', ['multiple', 'accept'=>'image/*', 'required'])}}
                </div>
                @if (Auth::user()->role == 'admin')
                <div class="mb-3">
                    {{Form::select('status', ['active'=>'active', 'inactive'=>'inactive'] , null, ['class'=>'form-control', 'required', 'placeholder'=>'select status'])}}
                </div>
                @else
                <input type="hidden" value="pending" name="status" id="status" class="form-control" required readonly />
                @endif
                {{Form::submit('Save', ['class'=>'btn btn-primary'])}}
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>
@endsection