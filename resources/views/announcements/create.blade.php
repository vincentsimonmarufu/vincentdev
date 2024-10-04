@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Create Announcement</h3>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                {!!Form::open(['action'=>'App\Http\Controllers\AnnouncementController@store'])!!}
                @csrf
                    <div class="mb-3">
                        {{Form::text('subject', null, ['class'=>'form-control', 'required', 'placeholder'=>'Subject'])}}
                    </div>
                    <div class="mb-3">
                        {{Form::text('introduction', null, ['class'=>'form-control', 'required', 'placeholder'=>'Introduction'])}}
                    </div>
                    <div class="mb-3">
                        {{Form::text('url_text', 'Visit Site', ['class'=>'form-control', 'required', 'placeholder'=>'Button Link Text/Caption'])}}
                    </div>
                    <div class="mb-3">
                        {{Form::text('url', 'https://abisiniya.com', ['class'=>'form-control', 'required', 'placeholder'=>'Button URL for redirection'])}}
                    </div>
                    <div class="mb-3">
                        {{Form::text('conclusion', null, ['class'=>'form-control', 'required', 'placeholder'=>'Conclusion'])}}
                    </div>
                    {{Form::submit('Send Announcement', ['class'=>'btn btn-primary'])}}
                {!!Form::close()!!} 
            </div>
        </div>
    </div>
</div>
@endsection