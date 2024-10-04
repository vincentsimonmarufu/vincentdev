@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Create SMS Announcement</h3>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                {!!Form::open(['action'=>'App\Http\Controllers\AnnouncementController@postSendSMS'])!!}
                @csrf
                    <div class="mb-3">
                        {{Form::textarea('body', null, ['class'=>'form-control', 'required', 'placeholder'=>'Introduction', 'rows'=>'4', 'maxlength'=>'160'])}}
                    </div>
                    {{Form::submit('Send SMSes', ['class'=>'btn btn-primary'])}}
                {!!Form::close()!!} 
            </div>
        </div>
    </div>
</div>
@endsection