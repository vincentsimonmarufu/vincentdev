@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    <h3>Apartment belonging to: {{$apartment->user->name}} {{$apartment->user->surname}}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>Name</th>
                                <td>{{$apartment->name}}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{$apartment->address}}</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>{{$apartment->city}}</td>
                            </tr>
                            <tr>
                                <th>Country</th>
                                <td>{{$apartment->country}}</td>
                            </tr>
                            <tr>
                                <th>No. Guests</th>
                                <td>{{$apartment->guest}}</td>
                            </tr>
                            <tr>
                                <th>Bedroom</th>
                                <td>{{$apartment->bedroom}}</td>
                            </tr>
                            <tr>
                                <th>Bathroom</th>
                                <td>{{$apartment->bathroom}}</td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td>{{$apartment->price}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <h3>Property images</h3>
                    @if ($apartment->pictures->count() > 0)
                    <div class="row text-center">
                        @foreach ($apartment->pictures as $picture)
                        <div class="col-sm-4">
                            <img src="{{asset('storage/Apartment/' . $picture->path)}}" class="img-fluid">
                            {!!Form::open(['action'=>['App\Http\Controllers\ApartmentPictureController@destroy', $apartment->id, $picture->id], 'method'=>'DELETE'])!!}
                            {{Form::submit('Delete', ['class'=>'btn btn-danger'])}}
                            {!!Form::close()!!}
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-info">There are no images on this apartment</p>
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
                    {!!Form::open(['action'=>['App\Http\Controllers\ApartmentPictureController@store', $apartment->id], 'files'=>true])!!}
                    <div class="form-group row">
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