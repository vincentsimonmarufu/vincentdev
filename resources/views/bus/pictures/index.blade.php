@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    <h3>Buses belonging to: {{$Bus->user->name}} {{$Bus->user->surname}}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>Name</th>
                                <td>{{$Bus->name}}</td>
                            </tr>
                            <tr>
                                <th>Seater</th>
                                <td>{{$Bus->seater}}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{$Bus->address}}</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>{{$Bus->city}}</td>
                            </tr>
                            <tr>
                                <th>Country</th>
                                <td>{{$Bus->country}}</td>
                            </tr>
                            <tr>
                                <th>Make</th>
                                <td>{{$Bus->make}}</td>
                            </tr>
                            <tr>
                                <th>Model</th>
                                <td>{{$Bus->model}}</td>
                            </tr>
                            <tr>
                                <th>Year</th>
                                <td>{{$Bus->year}}</td>
                            </tr>
                            <tr>
                                <th>Engine Size (CC)</th>
                                <td>{{$Bus->engine_size}}</td>
                            </tr>
                            <tr>
                                <th>Fuel Type</th>
                                <td>{{$Bus->fuel_type}}</td>
                            </tr>
                            <tr>
                                <th>Weight</th>
                                <td>{{$Bus->weight}}</td>
                            </tr>
                            <tr>
                                <th>Color</th>
                                <td>{{$Bus->color}}</td>
                            </tr>
                            <tr>
                                <th>Transmission</th>
                                <td>{{$Bus->transmission}}</td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td>{{$Bus->price}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <h3>Bus images</h3>
                    @if ($Bus->pictures->count() > 0)
                    <div class="row text-center">
                        @foreach ($Bus->pictures as $picture)
                        <div class="col-sm-4">
                            <img src="{{asset('storage/Bus/' . $picture->path)}}" class="img-fluid">
                            {!!Form::open(['action'=>['App\Http\Controllers\BusPictureController@destroy', $Bus->id, $picture->id], 'method'=>'DELETE'])!!}
                            {{Form::submit('Delete', ['class'=>'btn btn-danger'])}}
                            {!!Form::close()!!}
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-info">There are no images on this Bus</p>
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
                    {!!Form::open(['action'=>['App\Http\Controllers\BusPictureController@store', $Bus->id], 'files'=>true])!!}
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