@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
@endsection
@section('content')
<main id="main">

 <!-- BreadCrumb Starts -->  
 <section class="breadcrumb-main pb-0 pt-20" style="background: #000;">
  <div class="breadcrumb-outer">
      <div class="container">
          <div class="breadcrumb-content d-md-flex align-items-center pt-6">
              <h1 class="mb-0">ABout Us</h1>
              <nav aria-label="breadcrumb">
                  <ul class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">About Us</li>
                  </ul>
              </nav>
          </div>
      </div>
  </div>
  <div class="dot-overlay"></div>
  <br/>
</section>
<!-- BreadCrumb Ends --> 

    <!-- ======= Features Section ======= -->
    <section id="features" class="features">
      <div class="container">

        <div class="section-title-f" data-aos="fade-up">
          <h2>About <strong>Us</strong></h2>
          <p>Join our team of diverse, forward-thinking people who constantly strive to deliver beyond expectations. We
            like to stretch ourselves,
            and to bring fresh perspectives that will challenge the conventional way of doing things. It makes this an
            inspiring environment,
            but not an intimidating one.
          </p>
        </div>

        <div class="row">
          <div class="col-lg-4 mb-5 mb-lg-0" data-aos="fade-right">
            <ul class="nav nav-tabs flex-column">
              <li class="nav-item">
                <a class="nav-link active show" data-toggle="tab" href="#tab-1">
                  <h4>Travel Easier.</h4>
                  <p>Belong anywhere, and get the opportunity to trully understand and experience the local culture
                    wherever you might be.</p>
                </a>
              </li>
              <li class="nav-item mt-2">
                <a class="nav-link" data-toggle="tab" href="#tab-2">
                  <h4>Airport Transfers.</h4>
                  <p>We offer convenient and reliable airport transfers from the Harare International Airport to any
                    carousel-cell of choice.</p>
                </a>
              </li>
              <li class="nav-item mt-2">
                <a class="nav-link" data-toggle="tab" href="#tab-3">
                  <h4>Visa Application</h4>
                  <p>We provide visa support for citizens of any country. Our experts will advise on all visa issues. We
                    also offer assistance
                    for UK Visa’s, American Visa’s, China Visa, and many more. We simplify the process and assist you
                    every step of the way.</p>
                </a>
              </li>
              <li class="nav-item mt-2">
                <a class="nav-link" data-toggle="tab" href="#tab-4">
                  <h4>Car Hire Services.</h4>
                  <p>Whether you’re ready to explore the coast and catch some sun in a sleek convertible, or looking for
                    a large-capacity vehicle
                    for a family road trip, we’ll find you the perfect Car. We aim to provide you an all-round service
                    that insures hassle free travelling.</p>
                </a>
              </li>
            </ul>
          </div>
          <div class="col-lg-7 ml-auto" data-aos="fade-left" data-aos-delay="100">
            <div class="tab-content">
              <div class="tab-pane active show" id="tab-1">
                <figure>
                  <img src="assets/img/features-1.png" alt="" class="img-fluid">
                </figure>
              </div>
              <div class="tab-pane" id="tab-2">
                <figure>
                  <img src="assets/img/features-2.png" alt="" class="img-fluid">
                </figure>
              </div>
              <div class="tab-pane" id="tab-3">
                <figure>
                  <img src="assets/img/features-3.png" alt="" class="img-fluid">
                </figure>
              </div>
              <div class="tab-pane" id="tab-4">
                <figure>
                  <img src="assets/img/features-4.png" alt="" class="img-fluid">
                </figure>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End Features Section -->

    <!-- ======= Popular Tours Section ======= -->
    <section id="tour" class="tour section-b4">
      <div class="main-carousel">
        <div class="carousel-title" data-aos="fade-up" data-aos-delay="50">
          <h2><strong>Tours</strong></h2>
        </div>

        <div class="carousel-cell" data-aos="fade-up" data-aos-delay="100">
          <div class=" carousel-cell-img">
            <img src="assets/img/tours/Dubai.jpg" class="img-fluid" alt="">
            <div class="text-block">
              <h1>$700</h1>
              <p>3 Days, 3 Nights</p>
              <div class="text-center"><a href="" class="btn-enquire">Enquire</a></div>
            </div>
          </div>
          <div class="carousel-cell-info">
            <h4>Jet Ski Tour of Dubai: Burj Al Arab</h4>
          </div>
        </div>

        <div class="carousel-cell" data-aos="fade-up" data-aos-delay="200">
          <div class="carousel-cell-img">
            <img src="assets/img/tours/India.jpg" class="img-fluid" alt="">
            <div class="text-block">
              <h1>$250</h1>
              <p>3 Days, 2 Nights</p>
              <div class="text-center"><a href="" class="btn-enquire">Enquire</a></div>
            </div>
          </div>
          <div class="carousel-cell-info">
            <h4>3 Day Golden Triangle Tour Delhi, India</h4>
          </div>
        </div>

        <div class="carousel-cell" data-aos="fade-up" data-aos-delay="300">
          <div class="carousel-cell-img">
            <img src="assets/img/tours/SA.jpg" class="img-fluid" alt="">
            <div class="text-block">
              <h1>$520</h1>
              <p>4 Nights</p>
              <div class="text-center"><a href="" class="btn-enquire">Enquire</a></div>
            </div>
          </div>
          <div class="carousel-cell-info">
            <h4>Garden Route Express, South Africa</h4>
          </div>
        </div>

        <div class="carousel-cell" data-aos="fade-up" data-aos-delay="400">
          <div class="carousel-cell-img">
            <img src="assets/img/tours/Thailand1.jpg" class="img-fluid" alt="">
            <div class="text-block">
              <h1>$545</h1>
              <p>6 Nights</p>
              <div class="text-center"><a href="" class="btn-enquire">Enquire</a></div>
            </div>
          </div>
          <div class="carousel-cell-info">
            <h4>Luxury Delights - Phuket, Krabi & Bangkok</h4>
          </div>
        </div>

        <div class="carousel-cell" data-aos="fade-up" data-aos-delay="400">
          <div class="carousel-cell-img">
            <img src="assets/img/tours/photo-of-person-beside-camel.jpg" class="img-fluid" alt="">
            <div class="text-block">
              <h1>$180</h1>
              <p>7 Nights</p>
              <div class="text-center"><a href="" class="btn-enquire">Enquire</a></div>
            </div>
          </div>
          <div class="carousel-cell-info">
            <h4>Sossusvlei, Swakopmund & Etosha- 7 Days</h4>
          </div>
        </div>

        <div class="carousel-cell" data-aos="fade-up" data-aos-delay="400">
          <div class="carousel-cell-img">
            <img src="assets/img/tours/photo-of-scenic-beach-resort.jpg" class="img-fluid" alt="">
            <div class="text-block">
              <h1>$300</h1>
              <p>3 days</p>
              <div class="text-center"><a href="" class="btn-enquire">Enquire</a></div>
            </div>
          </div>
          <div class="carousel-cell-info">
            <h4>Zanzibar beach Tour and vacation packages</h4>
          </div>
        </div>

        <div class="carousel-cell" data-aos="fade-up" data-aos-delay="400">
          <div class="carousel-cell-img">
            <img src="assets/img/tours/Victoria-Falls.jpg" class="img-fluid" alt="">
            <div class="text-block">
              <h1>$380</h1>
              <p>6 Nights</p>
              <div class="text-center"><a href="" class="btn-enquire">Enquire</a></div>
            </div>
          </div>
          <div class="carousel-cell-info">
            <h4>Victoria Falls and Chobe Package</h4>
          </div>
        </div>

        <div class="carousel-cell" data-aos="fade-up" data-aos-delay="400">
          <div class="carousel-cell-img">
            <img src="assets/img/tours/person-holding-white-and-blue-business-paper.jpg" class="img-fluid" alt="">
            <div class="text-block">
              <h1>$450</h1>
              <p>2 Nights</p>
              <div class="text-center"><a href="" class="btn-enquire">Enquire</a></div>
            </div>
          </div>
          <div class="carousel-cell-info">
            <h4>Corporate Incentive Travel Package</h4>
          </div>
        </div>
      </div>
    </section><!-- End Popular Tours Section -->

    <!-- ======= Our Team Section ======= -->
    <section id="team" class="team section-bg">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Our <strong>Team</strong></h2>
        </div>

        <div class="row">

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
            <div class="member" data-aos="fade-up">
              <div class="member-img">
                <img src="assets/img/team/team-1.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="bx bxl-twitter"></i></a>
                  <a href=""><i class="bx bxl-facebook"></i></a>
                  <a href=""><i class="bx bxl-instagram"></i></a>
                  <a href=""><i class="bx bxl-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>El Shaddai Sadomba</h4>
                <span>Graphic Designer</span>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
            <div class="member" data-aos="fade-up" data-aos-delay="100">
              <div class="member-img">
                <img src="assets/img/team/team-2.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="bx bxl-twitter"></i></a>
                  <a href=""><i class="bx bxl-facebook"></i></a>
                  <a href=""><i class="bx bxl-instagram"></i></a>
                  <a href=""><i class="bx bxl-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Gab Kante</h4>
                <span>Digital Marketing</span>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
            <div class="member" data-aos="fade-up" data-aos-delay="200">
              <div class="member-img">
                <img src="assets/img/team/team-3.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="bx bxl-twitter"></i></a>
                  <a href=""><i class="bx bxl-facebook"></i></a>
                  <a href=""><i class="bx bxl-instagram"></i></a>
                  <a href=""><i class="bx bxl-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Tom Kean</h4>
                <span>Customer Support</span>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
            <div class="member" data-aos="fade-up" data-aos-delay="300">
              <div class="member-img">
                <img src="assets/img/team/team-4.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="bx bxl-twitter"></i></a>
                  <a href=""><i class="bx bxl-facebook"></i></a>
                  <a href=""><i class="bx bxl-instagram"></i></a>
                  <a href=""><i class="bx bxl-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Kathy Banley</h4>
                <span>Travel Agent</span>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Our Team Section -->

    <!-- ======= Our Clients Section ======= -->
    <section id="clients" class="clients">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Our <strong>Partners</strong></h2>
        </div>

        <div class="row no-gutters clients-wrap clearfix" data-aos="fade-up">

          <div class="col-lg-3 col-md-4 col-xs-6">
            <div class="client-logo">
              <img src="assets/img/partners/globtorch_library.png" class="img-fluid" alt="">
            </div>
          </div>

          <div class="col-lg-3 col-md-4 col-xs-6">
            <div class="client-logo">
              <img src="assets/img/partners/gstorex.png" class="img-fluid" alt="">
            </div>
          </div>

          <div class="col-lg-3 col-md-4 col-xs-6">
            <div class="client-logo">
              <img src="assets/img/partners/globtorch.png" class="img-fluid" alt="">
            </div>
          </div>

          <div class="col-lg-3 col-md-4 col-xs-6">
            <div class="client-logo">
              <img src="assets/img/partners/Nlogo-01.png" class="img-fluid" alt="">
            </div>
          </div>
          <!--
          <div class="col-lg-3 col-md-4 col-xs-6">
            <div class="client-logo">
              <img src="assets/img/partners/Nlogo-01.png" class="img-fluid" alt="">
            </div>
          </div>

          <div class="col-lg-3 col-md-4 col-xs-6">
            <div class="client-logo">
              <img src="assets/img/partners/Nlogo-01.png" class="img-fluid" alt="">
            </div>
          </div>

          <div class="col-lg-3 col-md-4 col-xs-6">
            <div class="client-logo">
              <img src="assets/img/partners/Nlogo-01.png" class="img-fluid" alt="">
            </div>
          </div>

          <div class="col-lg-3 col-md-4 col-xs-6">
            <div class="client-logo">
              <img src="assets/img/partners/Nlogo-01.png" class="img-fluid" alt="">
            </div>
          </div>-->

        </div>

      </div>
    </section><!-- End Our Clients Section -->

  </main><!-- End #main -->
@endsection
