@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    <h3>Shuttles belonging to: {{$shuttle->user->name}} {{$shuttle->user->surname}}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                          <tr>
                                <th>Name</th>
                                <td>{{$shuttle->name}}</td>
                            </tr>
                            <tr>
                                <th>Seater</th>
                                <td>{{$shuttle->seater}}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{$shuttle->address}}</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>{{$shuttle->city}}</td>
                            </tr>
                            <tr>
                                <th>Country</th>
                                <td>{{$shuttle->country}}</td>
                            </tr>
                            <tr>
                                <th>Make</th>
                                <td>{{$shuttle->make}}</td>
                            </tr>
                            <tr>
                                <th>Model</th>
                                <td>{{$shuttle->model}}</td>
                            </tr>
                            <tr>
                                <th>Year</th>
                                <td>{{$shuttle->year}}</td>
                            </tr>
                            <tr>
                                <th>Engine Size (CC)</th>
                                <td>{{$shuttle->engine_size}}</td>
                            </tr>
                            <tr>
                                <th>Fuel Type</th>
                                <td>{{$shuttle->fuel_type}}</td>
                            </tr>
                            <tr>
                                <th>Weight</th>
                                <td>{{$shuttle->weight}}</td>
                            </tr>
                            <tr>
                                <th>Color</th>
                                <td>{{$shuttle->color}}</td>
                            </tr>
                            <tr>
                                <th>Transmission</th>
                                <td>{{$shuttle->transmission}}</td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td>{{$shuttle->price}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <h3>shuttle images</h3>
                    @if ($shuttle->pictures->count() > 0)
                        <div class="row text-center">
                            @foreach ($shuttle->pictures as $picture)
                                <div class="col-sm-4">
                                    <img src="{{asset('storage/Shuttle/' . $picture->path)}}" class="img-fluid">
                                    {!!Form::open(['action'=>['ShuttlePictureController@destroy', $shuttle->id, $picture->id], 'method'=>'DELETE'])!!}
                                        {{Form::submit('Delete', ['class'=>'btn btn-danger'])}}
                                    {!!Form::close()!!}
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-info">There are no images on this shuttle</p>
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
                    {!!Form::open(['action'=>['ShuttlePictureController@store', $shuttle->id], 'files'=>true])!!}
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