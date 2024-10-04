@extends('layouts.app')
@section('content')
<main id="main">
 <!-- BreadCrumb Starts -->
 <section class="breadcrumb-main pb-0 pt-20" style="background: #000;">
    <div class="breadcrumb-outer">
        <div class="container">
            <div class="breadcrumb-content d-md-flex align-items-center pt-6">
                <h1 class="mb-0">Gallery</h1>
                <nav aria-label="breadcrumb">
                    <ul class="breadcrumb d-flex justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Gallery</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="dot-overlay"></div>
    <br/>
</section>
<!-- BreadCrumb Ends -->

    <!-- ======= Gallery Section ======= -->
    <section id="gallery" class="gallery">
        <div class="container">
            <div class="section-title" >
                <h2>Your Adventure Begins With Us <br/><strong>Share Your Experience.</strong></h2>
                <p>If you would like to contribute your experiences and the impromptu moments to this site, we would
                    love to share and also inspire & empowered others. Travel has a way of teaching you about the
                    world
                    and yourself. Few experiences offer the chance for self-discovery the way traveling does. We at
                    Abisiniya not only do we get to your holiday, business destination and back, we also aim to
                    invite
                    people into your story and experiences.
                </p>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="box" >
                        <div class="imgBox">
                            <img src="./assets/img/portfolio/gallery/man-sitting-on-a-cave.jpg" class="img-fluid">
                        </div>
                        <div class="content">
                            <h2>Cave Dwelling</h2>
                            <p>Phraya Nakhon Cave in Thailand.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box"  >
                        <div class="imgBox">
                            <img src="./assets/img/portfolio/gallery/colorful-hot-air-balloons-festival.jpg"
                                class="img-fluid">
                        </div>
                        <div class="content">
                            <h2>Hot Air Baloons</h2>
                            <p>"Look down at the region’s vineyards, forests, and fields as the sun casts its first
                                light over
                                the landscape."</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box"  >
                        <div class="imgBox">
                            <img src="./assets/img/portfolio/gallery/group-of-people-walking-beside-train-rail.jpg"
                                class="img-fluid">
                        </div>
                        <div class="content">
                            <h2>Circumnavigation</h2>
                            <p>Walking & Hiking Tour- Walking. Sometimes it’s the only way to see the world. Come
                                within a
                                hair’s breadth of an orang-utan on a rainforest trail.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box"  >
                        <div class="imgBox">
                            <img src="./assets/img/portfolio/gallery/person-standing-on-top-of-rock.jpg"
                                class="img-fluid">
                        </div>
                        <div class="content">
                            <h2>On Top Of The World</h2>
                            <p>"Active travel is, at its heart, a way of connecting more authentically with the
                                world."</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box" >
                        <div class="imgBox">
                            <img src="./assets/img/portfolio/gallery/people-on-road-under-blue-sky-3041345.jpg"
                                class="img-fluid">
                        </div>
                        <div class="content">
                            <h2>Ocean Of Grit And Sand</h2>
                            <p>"I think people overuse ‘the once in a lifetime experience’, but this trip earns".
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box" >
                        <div class="imgBox">
                            <img src="./assets/img/portfolio/gallery/person-feeding-giraffe.jpg" class="img-fluid">
                        </div>
                        <div class="content">
                            <h2>Feeding Girrafes</h2>
                            <p>"Amazing piece of paradise. Interaction with animals included feeding the giraffes".
                            </p>
                        </div>
                    </div>
                </div>
            </div>
    </section>

</main><!-- End #main -->
@endsection
