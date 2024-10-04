@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    <h3>Vehicles belonging to: {{$vehicle->user->name}} {{$vehicle->user->surname}}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>Name</th>
                                <td>{{$vehicle->name}}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{$vehicle->address}}</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>{{$vehicle->city}}</td>
                            </tr>
                            <tr>
                                <th>Country</th>
                                <td>{{$vehicle->country}}</td>
                            </tr>
                            <tr>
                                <th>Make</th>
                                <td>{{$vehicle->make}}</td>
                            </tr>
                            <tr>
                                <th>Model</th>
                                <td>{{$vehicle->model}}</td>
                            </tr>
                            <tr>
                                <th>Year</th>
                                <td>{{$vehicle->year}}</td>
                            </tr>
                            <tr>
                                <th>Engine Size (CC)</th>
                                <td>{{$vehicle->engine_size}}</td>
                            </tr>
                            <tr>
                                <th>Fuel Type</th>
                                <td>{{$vehicle->fuel_type}}</td>
                            </tr>
                            <tr>
                                <th>Weight</th>
                                <td>{{$vehicle->weight}}</td>
                            </tr>
                            <tr>
                                <th>Color</th>
                                <td>{{$vehicle->color}}</td>
                            </tr>
                            <tr>
                                <th>Transmission</th>
                                <td>{{$vehicle->transmission}}</td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td>{{$vehicle->price}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <h3>Vehicle images</h3>
                    @if ($vehicle->pictures->count() > 0)
                    <div class="row text-center">
                        @foreach ($vehicle->pictures as $picture)
                        <div class="col-sm-4">
                            <img src="{{asset('storage/Vehicle/' . $picture->path)}}" class="img-fluid">
                            {!!Form::open(['action'=>['App\Http\Controllers\VehiclePictureController@destroy', $vehicle->id, $picture->id], 'method'=>'DELETE'])!!}
                            {{Form::submit('Delete', ['class'=>'btn btn-danger'])}}
                            {!!Form::close()!!}
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-info">There are no images on this vehicle</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    Add More Pictures
                </div>
                <div class="card-body">
                    {!!Form::open(['action'=>['App\Http\Controllers\VehiclePictureController@store', $vehicle->id], 'files'=>true])!!}
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
</div>
@endsection