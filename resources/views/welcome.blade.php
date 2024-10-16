@extends('layouts.app')

@section('styles')
    <style>
        /* Additional responsive styling */
        .nav-tabs .nav-link.active {
            background-color: #2db838;
            color: white;
            border-color: #2db838 #2db838 #fff;
        }

        .nav-tabs .nav-link {
            color: #000;
        }

        .nav-tabs .nav-link:hover {
            color: #000;
        }

        @media (max-width: 768px) {
            .banner {
                height: auto;
                padding: 20px 0;
            }

            .nav-tabs .nav-item {
                flex-grow: 1;
                text-align: center;
            }

            .nav-tabs .nav-link {
                font-size: 14px;
            }
        }
    </style>
@endsection
@section('content')

    <main id="main">
        <!-- banner starts -->
        <section class="banner position-relative text-white d-flex align-items-center justify-content-center"
            style="background-image: url('assets/img/slide/slide_2.jpg'); background-size: cover; background-position: center; height: 95vh; margin-top: 80px;">
            <!-- Adjusted the top margin to account for the navbar height -->
            <div class="overlay position-absolute w-100 h-100" style="background-color: rgba(51, 101, 53, 0.5);"></div>
            <div class="container position-relative">
                <h1 class="mb-3 text-white mt-5"><span>Affordable Air Tickets</span>,<br />
                    Holiday Home and Car Rental Services
                </h1>

                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs rounded-top " id="bookingTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="airplane-tab" data-toggle="tab" data-target="#airplane"
                            type="button" role="tab" aria-controls="airplane" aria-selected="true">Affordable Air
                            Tickets</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="hotel-tab" data-toggle="tab" data-target="#hotel" type="button"
                            role="tab" aria-controls="hotel" aria-selected="false">Holiday Home</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tour-tab" data-toggle="tab" data-target="#tour" type="button"
                            role="tab" aria-controls="tour" aria-selected="false">Car Rental Services</button>
                    </li>
                </ul>

                <!-- Tabs Content -->
                <div class="tab-content border border-top-0 bg-white p-4 rounded-bottom shadow-sm" id="bookingTabsContent">
                    <!-- Airplane Ticket Tab -->
                    <div class="tab-pane fade show active" id="airplane" role="tabpanel" aria-labelledby="airplane-tab">
                        <form>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="from" class="form-label">From</label>
                                    <input type="text" class="form-control" id="from" placeholder="e.g., Jakarta">
                                </div>
                                <div class="col-md-4">
                                    <label for="to" class="form-label">To</label>
                                    <input type="text" class="form-control" id="to" placeholder="e.g., New York">
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary"
                                        style="background-color: #2db838; border: none;">Search</button>
                                </div>
                            </div>

                        </form>
                    </div>

                    <!-- Hotel Tab -->
                    <div class="tab-pane fade" id="hotel" role="tabpanel" aria-labelledby="hotel-tab">
                        <p class="text-dark">Here 2</p>
                    </div>

                    <!-- Tour Tab -->
                    <div class="tab-pane fade" id="tour" role="tabpanel" aria-labelledby="tour-tab">
                        <p class="text-dark">Here 3</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- banner ends -->
        <!-- property Starts -->
        <section class="trending">
            <div class="container">
                <div class="section-title mb-6 pb-1 w-75 mx-auto text-center">
                    <h2 class="m-0">More Featured <span>Properties</span></h2>
                    <p>Wide range of properties.</p>
                </div>
                <div class="trend-box">
                    <div class="row">
                        @foreach ($apartments as $apartment)
                            <div class="col-lg-6 mb-4">
                                <div class="trend-item box-shadow p-3" style="background: #ffffff;">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 pe-0">
                                            <div class="trend-image1">
                                                @if ($apartment->pictures->first() !== null && $apartment->pictures->first()->path)
                                                    <a href="{{ route('apartments.view', $apartment->id) }}"
                                                        style="background-image: url({{ asset('storage/Apartment/' . $apartment->pictures->first()->path) }});"
                                                        alt="{{ $apartment->address }}" loading="lazy"></a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-8 col-md-8">
                                            <div class="trend-content">
                                                <h5 class="theme">{{ $apartment->city }}</h5>
                                                <h4><a
                                                        href="{{ route('apartments.view', $apartment->id) }}">{{ $apartment->address }}</a>
                                                </h4>
                                                <div
                                                    class="entry-meta d-flex align-items-center justify-content-between pb-1">
                                                    <div class="entry-author">
                                                        <p>Start From<span
                                                                class="d-block theme fw-bold">${{ number_format($apartment->price, 2) }}/Night</span>
                                                        </p>

                                                    </div>
                                                    <div class="entry-metalist d-flex align-items-center">
                                                        <ul>
                                                            <a href="{{ route('apartments.view', $apartment->id) }}">
                                                                <li class="me-2 btn btn-success">Book Now</li>
                                                            </a>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <ul
                                                    class="d-flex align-items-center justify-content-between border-t pt-2">
                                                    <li class="me-2"><i class="fa fa-eye"></i> {{ $apartment->bedroom }}
                                                        Bedroom(s)</li>
                                                    <li class="me-2"><i class="fa fa-heart"></i>
                                                        {{ $apartment->bathroom }} Bathroom(s)</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="col-lg-12 text-center">
                            <a href="{{ route('apartments.all') }}" class="nir-btn">Load More</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- property ends -->
        <br />
        <!-- CTA start -->
        <div class="content-line">
            <div class="container">
                <div class="content-line-inner bg-theme pb-6 pt-6 p-5">
                    <div class="row d-md-flex align-items-center justify-content-between text-lg-start text-center">
                        <div class="col-lg-9">
                            <h2 class="mb-0 white">
                                Looking for a holiday home?
                            </h2>
                            <p class="white">Are you looking for the best holiday home</p>
                        </div>
                        <div class="col-lg-3">
                            <a href="{{ route('apartments.all') }}" class="nir-btn-black float-none float-lg-end">Find
                                More
                                Properties</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- CTA ends -->
        <!-- ======= cars Section ======= -->
        @if ($vehicles->count() > 0)
            <section class="blog trending">
                <div class="container">
                    <div class="section-title mb-6 pb-1 w-75 mx-auto text-center">
                        <h2 class="m-0">More Featured <span>Cars</span></h2>
                        <p>Trusted by thousands</p>
                    </div>
                    <div class="listing-main listing-main1">
                        <!-- end of saerch bar -->
                        <div class="trend-box">
                            <div class="row">
                                @foreach ($vehicles as $vehicle)
                                    <div class="target col-lg-4 col-md-6 mb-4" id="target">
                                        <div class="trend-item box-shadow rounded"
                                            style="background: #ffffff; border-color: #ffffff; border:5em">
                                            <div class="trend-image imagesize">
                                                @if ($vehicle->pictures->first() !== null && $vehicle->pictures->first()->path)
                                                    <a href="{{ route('car_hire.view', $vehicle->id) }}">
                                                        <img src="{{ asset('storage/Vehicle/' . $vehicle->pictures->first()->path) }}"
                                                            alt="{{ $vehicle->model }}" alt="image" loading="lazy">
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="trend-content p-4">
                                                <h5 class="theme"> <a
                                                        href="{{ route('car_hire.view', $vehicle->id) }}">{{ $vehicle->name }},
                                                        {{ $vehicle->make }}</a></h5>
                                                <h4><a href="{{ route('car_hire.view', $vehicle->id) }}">{{ $vehicle->year }}
                                                        {{ $vehicle->model }} </a></h4>
                                                <div
                                                    class="entry-meta d-flex align-items-center justify-content-between border-b pb-1 mb-2">
                                                    <div class="entry-author">
                                                        <p>Start From<span
                                                                class="d-block theme fw-bold">${{ number_format($vehicle->price, 2) }}/Day</span>
                                                        </p>

                                                    </div>
                                                    <div class="entry-metalist d-flex align-items-center">
                                                        <ul>
                                                            <a href="{{ route('car_hire.view', $vehicle->id) }}">
                                                                <li class="me-2 btn btn-success">Drive Now</li>
                                                            </a>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach

                                <div class="col-lg-12 text-center">
                                    <a href="{{ route('car_hire') }}" class="nir-btn">Load More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        <!-- End cars Section -->
        <!-- flight action starts -->
        <section class="discount-action discount-action1 pb-0 pt-0">
            <div class="container">
                <div class="call-banner" style="background-image:url(assets/img/banner.webp);">
                    <div class="row d-flex align-items-center">
                        <div class="col-lg-7 col-md-8 p-0">
                            <div class="call-banner-inner bg-theme1">
                                <div class="trend-content-main">
                                    <div class="trend-content p-5">
                                        <h5 class="mb-1 white">Wanna travel safely?</h5>
                                        <h2 class="mb-4 white">Book a Flight, Save Time and Money with US!</h2>
                                        <div class="section-btns d-flex align-items-center">
                                            <a href="{{ route('flight') }}" class="nir-btn">Book a Flight <i
                                                    class="fa fa-arrow-right white pl-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-4 p-0"></div>
                    </div>
                </div>
            </div>
        </section>

        <br />
        <!-- ======= Our Clients Section ======= -->
        <section id="clients" class="clients" style="padding-top: 0px!important">
            <div class="container">

                <div class="section-title mb-6 pb-1 w-75 mx-auto text-center">
                    <h2 class="m-0">Popular Airlines</h2>
                    <p>Popular Airlines we are affiliated with.</p>
                </div>

                <div class="row no-gutters clients-wrap clearfix">

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="client-logo">
                            <img src="{{ asset('assets/img/partners/toppng.com-logo-iata-980x312.png') }}"
                                class="img-fluid" alt="Emirates" loading="lazy">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="client-logo">
                            <img src="assets/img/airlines/1.png" class="img-fluid" alt="Emirates" loading="lazy">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="client-logo">
                            <img src="assets/img/airlines/2.png" class="img-fluid" alt="SAA" loading="lazy">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="client-logo">
                            <img src="assets/img/airlines/3.png" class="img-fluid" alt="RwanAir" loading="lazy"
                                loading="lazy">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="client-logo">
                            <img src="assets/img/airlines/4.png" class="img-fluid" alt="Air Mauritius" loading="lazy">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="client-logo">
                            <img src="assets/img/airlines/5.png" class="img-fluid" alt="Kenya Airways" loading="lazy">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="client-logo">
                            <img src="assets/img/airlines/6.png" class="img-fluid" alt="Fastjet" loading="lazy">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="client-logo">
                            <img src="assets/img/airlines/7.png" class="img-fluid" alt="Ethiopean Airways"
                                loading="lazy">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="client-logo">
                            <img src="assets/img/airlines/8.png" class="img-fluid" alt="Air Namibia" loading="lazy">
                        </div>
                    </div>

                </div>

            </div>
        </section>
        <!-- End Our Clients Section -->
        <div class="container">
            <div class="section-title mb-4 pb-1 w-75 mx-auto text-center">
                <h2 class="m-0">Good Reviews By <span>Clients</span></h2>
                <p>What our clients say about us:</p>
            </div>
            <div class="row review-slider">
                <div class="col-sm-4 item">
                    <div class="testimonial-item1 text-center">
                        <div class="details">
                            <p class="m-0">Easy to drive, all worked well, a/c very good. Since we rent for a month and
                                need a large car,
                                we're happy each year to have a vehicle large enough for all our luggage.</p>
                        </div>
                        <div class="author-info mt-2">
                            <div class="author-title">
                                <h4 class="m-0 theme2">Jared </h4>
                                <span>Supervisor</span>
                            </div>
                        </div>
                        <i class="fa fa-quote-left mb-2"></i>
                    </div>
                </div>
                <div class="col-sm-4 item">
                    <div class="testimonial-item1 text-center">
                        <div class="details">
                            <p class="m-0">Great car, lovely helpful staff! So happy to be able to drop the car near my
                                hotel instead of
                                having to go to the airport. Highly recommended company! Thank you!</p>
                        </div>
                        <div class="author-info mt-2">
                            <div class="author-title">
                                <h4 class="m-0 theme2">Clive</h4>
                                <span>Sr. Consultant</span>
                            </div>
                        </div>
                        <i class="fa fa-quote-left mb-2"></i>
                    </div>
                </div>
                <div class="col-sm-4 item">
                    <div class="testimonial-item1 text-center">
                        <div class="details">
                            <p class="m-0">Very satisfied with this rental. The representatives were professional and
                                helpful.
                                The care rental area was easy to navigate and convenient to the terminal</p>
                        </div>
                        <div class="author-info mt-2">
                            <div class="author-title">
                                <h4 class="m-0 theme2">Jonathan </h4>
                                <span>Sales Manager</span>
                            </div>
                        </div>
                        <i class="fa fa-quote-left mb-2"></i>
                    </div>
                </div>
            </div>
        </div>
        </section>-->
        <!-- testimonial ends -->
    </main><!-- End #main -->
@endsection
