<section class="newsletter p-0 position-relative">
    <div class="newsletter-main bg-theme2 p-5 pb-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-2">
                    <div class="newsletter-content">
                        <h2 class="mb-0 white text-lg-start text-center">
                            Do You Need Help With Anything?
                        </h2>
                        <p class="mb-0 white">Receive updates, hot deals, discounts sent straignt in your inbox every month</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-2">
                    <div id="message"></div>
                    <div class="newsletter-form_avoid w-100">
                        <form id="subscribe-form">
                            @csrf
                            <input type="text" name="fullname" id="fullname" placeholder="Full Name" required>
                            <input type="email" name="email" id="email" placeholder="Email Address" required>
                            <button type="submit" class="nir-btn-black">Subscribe</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- footer starts -->
<footer class="pt-10 footermain">
    <div class="footer-upper pb-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-6 col-sm-12 mb-4">
                    <div class="footer-about">
                        <h3 class="white">About</h3>
                        <p class="mt-3 mb-3 white">We pride ourselves on our outstanding customer service.
                            Let us take you across the world in easier and affordable ways.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="footer-about">
                        <h3 class="white">Zimbabwe</h3>
                        <ul>
                            <li class="white"><strong>Phone:</strong> +263 777 223 158</li>
                            <li class="white"><strong>New Office Address:</strong> Cnr Prince Edward and Lezard, Milton park</li>
                            <li class="white"><strong>Location:</strong> Harare, Zimbabwe</li>
                            <li class="white"><strong>Email:</strong> info@abisiniya.com</li>
                            <li class="white"><strong>Website:</strong> www.abisiniya.com</li>                           
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="footer-about">
                        <h3 class="white">South Africa</h3>
                        <ul>
                            <li class="white"><strong>Phone:</strong> +27 65 532 6408</li>
                            <li class="white"><strong>Location:</strong> 28 Mint Road, 3rd Floor, Fordsburg, Johannesburg, South Africa</li>
                            <li class="white"><strong>Email:</strong> info@abisiniya.com</li>
                            <li class="white"><strong>Website:</strong> www.abisiniya.com</li>                          
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12 mb-4">
                    <div class="footer-links">
                        <h3 class="white">Our Services</h3>
                        <div class="tagcloud">
                            <a class="tag-cloud-link bg-white black p-2 mb-1" href="{{ route('flight') }}">Flight Booking</a>
                            <a class="tag-cloud-link bg-white black p-2 mb-1" href="{{ route('car_hire') }}">Car Hire</a>
                            <a class="tag-cloud-link bg-white black p-2 mb-1" href="{{ route('apartments.all') }}">Accomodation</a>
                            <a class="tag-cloud-link bg-white black p-2 mb-1" href="#">VISA</a>
                            <a class="tag-cloud-link bg-white black p-2 mb-1" href="#">Airport Shuttle</a>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-md-10 offset-md-5">           
            @php
                {{ $visitorCount = \App\Models\Visitor::count(); }}
            @endphp
            <style>
    #visitorCountDisplay {
        font-weight: bold;
        text-transform: uppercase;
        font-size: 20px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        padding: 1px 1px; 
        background-color: #f2f2f2; 
        border: 1px solid #ccc;
        border-radius: 8px; 
        display: inline-block; 
        color: #333; 
        margin: 20px; 
        position: relative;
        box-shadow: 
        0 4px 8px rgba(0, 0, 0, 0.1), 
        0 0 0 4px #fff, 
        0 0 0 8px #ccc; 
    }
</style>

        <span id="visitorCountDisplay"><strong>Visitor No:</strong> {{ 11000+$visitorCount }}</span>
                
        </div>         
        </div>
        
    </div>    
    <div class="footer-copyright pt-2 pb-2">
        <div class="container">
            <div class="copyright-inner d-md-flex align-items-center justify-content-between">
                <div class="copyright-text">
                    <p class="m-0 white"> <a href="abisiniya.com">2023 Abisiniya. All rights reserved.</a></p>
                </div>

            </div>
        </div>
    </div>
</footer>
<!-- footer ends -->


<div id="back-to-top">
    <a href="#"></a>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        $('#subscribe-form').submit(function(e) {
            e.preventDefault();
            var fullname = $('#fullname').val();
            var email = $('#email').val();
            $.ajax({
                type: 'POST',
                url: '{{ route("newsletters.subscibe") }}',
                data: {
                    fullname: fullname,
                    email: email,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#message').html('<p>' + response.message + '</p>');
                    $('#fullname').val(''); 
                    $('#email').val('');                    
                    setTimeout(function() {
                        $('#message').empty(); 
                    }, 3000); 
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseJSON.message;
                    $('#message').html('<p>' + errorMessage + '</p>');
                    $('#fullname').val('');
                    $('#email').val(''); 
                    setTimeout(function() {
                        $('#message').empty(); 
                    }, 3000); 
                }
            });
        });
    });
</script>
@endsection