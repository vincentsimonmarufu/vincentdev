@extends('layouts.auth.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>{{$location->name}}</h3>
            </div>
            <div class="card-body">
                <p>{{$location->description}}</p>
            </div>
            <div class="card-footer">
                <h3>Location images</h3>
                @if ($location->pictures->count() > 0)
                    @foreach ($location->pictures as $picture)
                        <img src="{{asset('storage/Location/' . $picture->path)}}" class="img-fluid">
                    @endforeach
                @else
                    <p class="text-info">There are no images on this location</p>
                @endif
            </div>
        </div>
    </div>
@endsection