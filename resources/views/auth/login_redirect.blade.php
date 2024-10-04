@extends('layouts.app')
@section('content')
    <main id="main">

 <!-- BreadCrumb Starts -->  
 <section class="breadcrumb-main pb-0 pt-20" style="background: #000;">
    <div class="breadcrumb-outer">
        <div class="container">
            <div class="breadcrumb-content d-md-flex align-items-center pt-6">
                <h1 class="mb-0">Already have an Account</h1>
                <nav aria-label="breadcrumb">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Login</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="dot-overlay"></div>
    <br/>
</section>
<!-- BreadCrumb Ends --> 

        <!-- ======= LOG-IN Section ======= -->
        <section class="signin-page account">
            <div class="container ">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="block text-center shadow p-3 mb-5">
                            <a class="logo" href="index.html">
                                <img src="{{ asset('assets/img/logo.jpg') }}" class="img-fluid" width="150" alt="logo">
                            </a>
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Error!</strong>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                            <h2 class="text-center">Welcome Back</h2>
                            {!!Form::open(['action'=>'App\Http\Controllers\WelcomeController@postLoginRoute', 'class' => 'text-left clearfix'])!!}
                            @csrf
                                {{Form::hidden('redirectPath', $redirectPath)}}
                                <div class="form-group">
                                    {{Form::text('email', null, ['class'=>'form-control', 'placeholder'=>'Email/Phone number'])}}
                                </div>
                                <div class="form-group">
                                    {{Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password'])}}
                                </div>
                                <div class="text-center">
                                    {{Form::submit('Login', ['class'=>'btn btn-success text-center'])}}
                                </div>
                            {!! Form::close() !!}
                            <p class="mt-20">New to this site?<a href="{{route('register')}}" style="color:rgb(14, 180, 14);"> Create New Account</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>




        

    </main><!-- End #main -->
@endsection