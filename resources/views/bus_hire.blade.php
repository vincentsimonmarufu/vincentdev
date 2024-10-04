@extends('layouts.app')
@section('content')
<main id="main">
<style>
    .imagesize {
    width: 350px; /* Set the desired width */
    height: 200px; /* Set the desired height */
    margin: 0 auto; /* Center the slider horizontally */
    }

    .imagesize img {
        width: 100%; /* Set the image width to fill the container */
        height: 100%; /* Set the image height to fill the container */
        object-fit: cover; /* Maintain aspect ratio while covering the container */
    }
</style>
    <!-- BreadCrumb Starts -->
    <section class="breadcrumb-main pb-0 pt-20" style="background: #000;">
        <div class="breadcrumb-outer">
            <div class="container">
                <div class="breadcrumb-content d-md-flex align-items-center pt-6">
                    <h1 class="mb-0">Bus Booking</h1>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb d-flex justify-content-center">
                            <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Bus Booking</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="dot-overlay"></div>
        <br />
    </section>
    <!-- BreadCrumb Ends -->
    <section class="blog trending">
        <div class="container">
            <div class="listing-main listing-main1">
                <!-- start saerch bar -->
                @include('bushire_search_form')          
                <!-- end of saerch bar -->
                <div class="trend-box">
                    <div class="list-results d-flex align-items-center justify-content-between">
                        <div class="list-results-sort">
                            @if ($buses->count() > 0)
                            <p class="m-0">Showing {{($buses->currentpage()-1)*$buses->perpage()+1}} to {{$buses->currentpage()*$buses->perpage()}}
                                of {{$buses->total()}} results</p>
                            @else
                            <p class="m-0 text-danger">Showing 0 results</p>
                            @endif

                        </div>
                    </div>
                    <div class="row">
                        @foreach($buses as $bus)
                        <div class="target col-lg-4 col-md-6 mb-4" id="target">
                            <div class="trend-item box-shadow rounded" style="background: #ffffff; border-color: #ffffff; border:5em">
                                <div class="trend-image imagesize">
                                    @foreach ($bus->pictures as $picture)
                                    <a href="{{route('bus_hire.view', $bus->id)}}">
                                        <img src="{{ asset('storage/Bus/' . $bus->pictures->first()->path) }}" alt="{{ $bus->model }}" loading="lazy">
                                    </a>
                                    @endforeach
                                </div>
                                <div class="trend-content p-4">
                                    <h5 class="theme">{{ $bus->year }} | {{ $bus->make }}</h5>
                                    <h4><a href="{{route('bus_hire.view', $bus->id)}}">{{ $bus->model }}</a></h4>
                                    <div class="entry-meta d-flex align-items-center justify-content-between border-b pb-1 mb-2">
                                        <div class="entry-author">
                                            <p>Start From<span class="d-block theme fw-bold">${{ number_format($bus->price,2) }}/km</span></p>

                                        </div>
                                        <div class="entry-metalist d-flex align-items-center">
                                            <ul>
                                                <a href="{{route('bus_hire.view', $bus->id)}}">
                                                    <li class="me-2 btn btn-success">Book Now</li>
                                                </a>
                                            </ul>
                                        </div>
                                    </div>
                                    <p class="mb-0">{{ $bus->name??'Travel'}} </p>

                                </div>
                                <ul class="d-flex align-items-center justify-content-between p-3 px-4" style="background: rgb(14, 135, 42)">
                                    <li class="me-2" style="color: rgb(226, 250, 232)"><i class="fa fa-eye"></i> {{ $bus->fuel_type }}</li>
                                    <li class="me-2" style="color: rgb(226, 250, 232)"><i class="fa fa-heart"></i> {{ $bus->seater }} seater</li>
                                </ul>
                            </div>
                        </div>
                        @endforeach

                    </div>

                    <div class="pagination-main text-center">

                        {{ $buses->onEachSide(1)->links('custom-pagination') }}

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- cars Ends -->


</main><!-- End #main -->
@endsection

@section('scripts')
<script>
        $(document).ready(function() {
            $('#mySelect1').select2();
            $('#mySelect2').select2();
        });
    </script>
@endsection