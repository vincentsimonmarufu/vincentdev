@extends('layouts.auth.app')
@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Create Vehicles</h3>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                {!!Form::open(['action'=>'App\Http\Controllers\VehicleController@store', 'files'=>true])!!}
                @csrf
                <div class="mb-3">
                    {{Form::text('name', null, ['id'=>'name', 'class'=>'form-control', 'required', 'placeholder'=>'Company Name / Owner Name'])}}

                </div>
                <div class="mb-3">
                    {{Form::textarea('address', null, ['class'=>'form-control', 'required', 'placeholder'=>'Address', 'rows'=>'3'])}}
                </div>
                <div class="mb-3">
                    {{Form::text('city', null, ['id'=>'city', 'class'=>'form-control', 'required', 'placeholder'=>'city'])}}
                </div>
                <div class="mb-3">
                    {{Form::select('country', $countries , null, ['id'=>'country', 'class'=>'form-control single-select', 'required', 'placeholder'=>'country'])}}
                </div>
                <div class="mb-3">
                    {{Form::text('make', null, ['class'=>'form-control', 'required', 'placeholder'=>'make'])}}
                </div>
                <div class="mb-3">
                    {{Form::text('model', null, ['class'=>'form-control', 'required', 'placeholder'=>'model'])}}
                </div>
                <div class="mb-3">
                    {{Form::number('year', null, ['class'=>'form-control', 'required', 'placeholder'=>'year', 'min' => '1000'])}}
                </div>
                <div class="mb-3">
                    {{Form::number('engine_size', null, ['class'=>'form-control', 'placeholder'=>'engine_size'])}}
                </div>
                <div class="mb-3">
                    {{Form::select('fuel_type', ['petrol'=>'petrol', 'diesel'=>'diesel', 'electric'=>'electric'] , null, ['class'=>'form-control', 'required', 'placeholder'=>'fuel type'])}}
                </div>
                <div class="mb-3">
                    {{Form::number('weight', null, ['class'=>'form-control', 'placeholder'=>'weight'])}}
                </div>
                <div class="mb-3">
                    {{Form::text('color', null, ['class'=>'form-control', 'required', 'placeholder'=>'Color'])}}
                </div>
                <div class="mb-3">
                    {{Form::select('transmission', ['manual'=>'manual', 'automatic'=>'automatic'] , null, ['class'=>'form-control', 'required', 'placeholder'=>'Transmission'])}}
                </div>
                <div class="mb-3">
                    {{Form::number('price', null, ['class'=>'form-control', 'required', 'placeholder'=>'price', 'step'=>'0.01'])}}
                </div>
                <div class="mb-3 row">
                    {{Form::label('pictures[]', 'Pictures 300 * 300', ['class'=>'col-lg-12 col-form-label'])}}
                    {{Form::file('pictures[]', ['multiple', 'accept'=>'image/*', 'required'])}}<br>
                </div>
                <!--  <input type="file" name="pictures[]" id="file" accept="image/*" multiple />                    
                    </div> 
                    <input type="text" id="post_img_data" name="image_data_url[]"  accept="image/*" multiple>
                    <div class="img-preview"></div>
                    <div id="galleryImages"></div>
                    <div id="cropper">
                        <button type="button" class="cropImageBtn btn btn-danger" style="display:none;" id="cropImageBtn">Select and Crop Image</button>
    
                        <canvas id="cropperImg" width="0" height="0"></canvas>
                    </div>
                    <div id="imageValidate" class="text-danger"></div>-->
                @if (Auth::user()->role == 'admin')
                <div class="mb-3">
                    {{Form::select('status', ['active'=>'active', 'inactive'=>'inactive'] , null, ['class'=>'form-control', 'required', 'placeholder'=>'select status'])}}
                </div>
                @else
                {{Form::select('status', ['pending'=>'pending', 'inactive'=>'inactive'] , null, ['class'=>'form-control', 'required', 'placeholder'=>'select status'])}}
                @endif
                {{Form::submit('Save', ['class'=>'btn btn-primary'])}}
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>



@endsection