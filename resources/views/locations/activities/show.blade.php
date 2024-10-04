@extends('layouts.auth.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>{{$location->name}} - {{$activity->name}}</h3>
            </div>
            <div class="card-body">
                <p>Description: {{$activity->description}}</p>
                <p>Price: {{$activity->price}}</p>
            </div>
            <div class="card-footer">
                <h3>Activity images</h3>
                @if ($activity->pictures->count() > 0)
                    @foreach ($activity->pictures as $picture)
                        <img height="100px" src="{{asset('storage/Activity/' . $picture->path)}}">
                    @endforeach
                @else
                    <p class="text-info">There are no images on this activity</p>
                @endif
            </div>
        </div>
    </div>
@endsection