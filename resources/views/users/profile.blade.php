@extends('layouts.auth.app')
@section('content')
<div class="card">
    <div class="card-header">
        <h1>Edit Profile</h1>
    </div>
        <div class="card-body">
            {!! Form::open(['action' => 'App\Http\Controllers\UserController@updateProfile', 'class' => 'text-left clearfix', 'method' => 'POST']) !!}
            
            {{-- Method Spoofing for PUT --}}
            @method('PUT')
            
            <div class="form-group">
                {{ Form::text('name', $user->name, ['class'=>'form-control', 'placeholder' => 'First Name', 'required']) }}
            </div>
            <div class="form-group">
                {{ Form::text('surname', $user->surname, ['class'=>'form-control', 'placeholder'=>'Last Name', 'required']) }}
            </div>
            <div class="form-group">
                {{ Form::text('phone', $user->phone, ['class'=>'form-control', 'placeholder'=>'Phone Number']) }}
            </div>
            <div class="form-group">
                {{ Form::email('email', $user->email, ['class'=>'form-control', 'placeholder'=>'Email']) }}
            </div>
            <div class="form-group">
                {{ Form::textarea('address', $user->address, ['class'=>'form-control', 'placeholder'=>'Address', 'rows'=>'3']) }}
            </div>
            <div class="form-group">
                {{ Form::select('country', $countries, $user->country, ['class'=>'form-control', 'placeholder'=>'Select Country ...']) }}
            </div><br><br>
            <div class="text-center">
                {{ Form::submit('Update', ['class'=>'btn btn-success text-center']) }}
            </div>
            {!! Form::close() !!}
        </div>
</div>
@endsection