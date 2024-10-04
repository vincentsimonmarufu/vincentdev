@extends('layouts.app')
@section('content')
<style>	
		#message {  padding: 0px 40px 0px 0px; }
		#mail-status {
			padding: 12px 20px;
			width: 100%;
			display:none; 
			font-size: 1em;
			font-family: "Georgia", Times, serif;
			color: rgb(40, 40, 40);
		}
	  .error{background-color: #F7902D;  margin-bottom: 40px;}
	  .success{background-color: #48e0a4; }
		.g-recaptcha {margin: 0 0 25px 0;}	  
	</style>		
<script src='https://www.google.com/recaptcha/api.js'></script>	
<main id="main">
    <!-- BreadCrumb Starts -->
    <section class="breadcrumb-main pb-0 pt-20" style="background: #000;">
        <div class="breadcrumb-outer">
            <div class="container">
                <div class="breadcrumb-content d-md-flex align-items-center pt-6">
                    <h1 class="mb-0">Contact Us</h1>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb d-flex justify-content-center">
                            <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="dot-overlay"></div>
        <br />
    </section>
    <!-- BreadCrumb Ends -->
    <!-- contact starts -->
    <section class="contact-main pt-0 pb-10 bg-grey">
        <div class="container-fluid">          
           
            <div>
                <div class="map">
                    <div style="width: 100%">
                        <iframe style="border:0; width: 100%; height: 400px;" src="https://maps.google.com/maps?q=globtorch&t=&z=17&ie=UTF8&iwloc=&output=embed" frameborder="0" allowfullscreen></iframe>

                    </div>
                </div>
                <div class="container">
                    <div class="contact-info-main">
                        <div class="row">
                            <div class="col-lg-12 col-offset-lg-1 mx-auto">
                                <div class="contact-info bg-white pt-10 pb-10 px-5">
                                    <div class="contact-info-title text-center mb-4 px-5">
                                        <h3 class="mb-1">INFORMATION ABOUT US</h3>
                                    </div>
                                    <div class="contact-info-content row mb-1">
                                        <div class="col-lg-4 col-md-6 mb-4">
                                            <div class="info-item bg-lgrey px-4 py-5 border-all text-center">
                                                <div class="info-icon mb-2">
                                                    <i class="fa fa-map-marker"></i>
                                                </div>
                                                <div class="info-content">
                                                    <p class="m-2">Cnr Prince Edward and Lezard, Milton park, Harare Zimbabwe</p>
                                                    <p class="m-2">Add 28 Mint Road, 3rd Floor, Fordsburg, Johannesburg, South Africa</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 mb-4">
                                            <div class="info-item bg-lgrey px-4 py-5 border-all text-center">
                                                <div class="info-icon mb-2">
                                                    <i class="fa fa-phone"></i>
                                                </div>
                                                <div class="info-content">
                                                    <p class="m-0">+263 777 223 158</p>                                                    
                                                    <p class="m-0">+27 65 532 6408</p>
                                                    <p class="m-0">+27 78 846 1005</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12 mb-4">
                                            <div class="info-item bg-lgrey px-4 py-5 border-all text-center">
                                                <div class="info-icon mb-2">
                                                    <i class="fa fa-envelope"></i>
                                                </div>
                                                <div class="info-content ps-4">
                                                    <p class="m-0">info@abisiniya.com</p>                                                 
                                                    <p class="m-0">abisiniya.sa.consultant@gmail.com</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="contact-form1" class="contact-form px-5">
                                        <div class="contact-info-title text-center mb-4 px-5">
                                            <h3 class="mb-1">Keep in Touch</h3>
                                        </div>

                                        <div id="contactform-error-msg"></div>

                                        @if ($errors->any())
                                        <div class="alert alert-danger" id="error-alert">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif
                                        @if (session()->has('error'))
                                        <div class="alert alert-danger" id="error-alert">
                                            <ul>
                                                <li>{{ session('error') }}</li>
                                            </ul>
                                        </div>
                                        @endif
                                        @if (session()->has('status'))
                                        <div class="alert alert-success" id="success-alert">
                                            <ul>
                                                <li>{{ session('status') }}</li>
                                            </ul>
                                        </div>
                                        @endif
                                        
                                        {!! Form::open(['action'=>'App\Http\Controllers\WelcomeController@contactUs', 'method' => 'POST', 'class' => 'contact-us-form']) !!}
                                        @csrf
                                        <div class="form-row">
                                            <div class="col-md-6 form-group" style="padding: 0px 5px !important;">
                                                {{ Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Your Name', 'required']) }}
                                            </div>
                                            <div class="col-md-6 form-group" style="padding: 0px 5px !important;">
                                                {{ Form::email('email', null, ['class'=>'form-control', 'placeholder'=>'Your Email', 'required']) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {{ Form::text('subject', null, ['class'=>'form-control', 'placeholder'=>'Phone']) }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::textarea('message', null, ['class'=>'form-control', 'rows'=>'5', 'required', 'placeholder'=>'Message']) }}
                                        </div>

                                        <div class="g-recaptcha" data-sitekey="<?php echo env('RECAPTCHA_SITEKEY'); ?>"></div>

			                            <div id="mail-status"></div>
                                        <!-- <input type="submit" class="nir-btn text-center" id="send-message" value="Send Message"> -->
                                        <button type="Submit" id="send-message" style="clear:both;" class="nir-btn text-center">Send Message</button>

                                        {!!Form::close()!!}                             
                                        <div id="loader-icon" style="display:none;"><img src="img/loader.gif" /></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                
                </div>
    </section>
    <!-- contact Ends -->

</main><!-- End #main -->

@section('contactcontact')
<script>

    $(document).ready(function (e){

        // contact form 
		$("#frmContact").on('submit', function (e) {
        e.preventDefault();

        $("#mail-status").hide();
        $('#send-message').hide();
        $('#loader-icon').show();

            $.ajax({
                url: "{{ route('contact-us') }}",
                method: "POST",
                dataType: 'json',
                data: {
                    "_token": $('input[name="_token"]').val(),
                    "name": $('input[name="name"]').val(),
                    "email": $('input[name="email"]').val(),
                    "subject": $('input[name="subject"]').val(),
                    "message": $('textarea[name="message"]').val(),
                    "g-recaptcha-response": grecaptcha.getResponse()
                },
                success: function (response) {
                    $("#mail-status").show();
                    $('#loader-icon').hide();
                    if (response.type == "error") {
                        $('#send-message').show();
                        $("#mail-status").attr("class", "error");
                    } else if (response.type == "message") {
                        $('#send-message').hide();
                        $("#mail-status").attr("class", "success");
                        // Clear form fields on success
                        $('#frmContact')[0].reset();
                        grecaptcha.reset(); // Reset reCAPTCHA
                    }
                    $("#mail-status").html(response.text);
                },
                error: function () {}
            });
        });
	});

    function hideAlerts() {
            setTimeout(function() {
                $('#error-alert, #success-alert').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 3000); 
    }
    
    $(document).ready(function() {
        hideAlerts();
    });


    
</script>
@endsection
@endsection
