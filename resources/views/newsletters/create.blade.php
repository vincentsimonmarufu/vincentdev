@extends('layouts.auth.app')
@section('content')
<div class="card">
    <div class="card-header">
        <h1>Send Newsletter</h1>
    </div>
    <div class="card-body">
        {!!Form::open(['action'=>'App\Http\Controllers\NewsletterController@send', 'files'=>true])!!}
        @csrf
        <div class="mb-3">
            {{Form::textarea('message', null, ['class'=>'form-control', 'required', 'placeholder'=>'Message'])}}
        </div>
        {{Form::submit('Send', ['class'=>'btn btn-primary'])}}
        {!!Form::close()!!}
    </div>
</div>
@endsection