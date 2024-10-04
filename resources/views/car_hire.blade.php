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
              <h1 class="mb-0">Car Hire</h1>
              <nav aria-label="breadcrumb">
                  <ul class="breadcrumb d-flex justify-content-center">
                      <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Car Hire</li>
                  </ul>
              </nav>
          </div>
      </div>
  </div>
  <div class="dot-overlay"></div>
  <br/>
</section>
<!-- BreadCrumb Ends -->
<section class="blog trending">
  <div class="container">
      <div class="listing-main listing-main1">
        @include('search_form')
           <!-- search bar -->
         <!--  <div class="col-lg-12 col-md-6 searchbar">
            <input type="text" id="Search" onkeyup="myFunction()" placeholder="Please enter a search term.." title="Type in a name" class="form-control"><br/>
          </div><br/> -->
      <!-- end of saerch bar -->
          <div class="trend-box">
              <div class="list-results d-flex align-items-center justify-content-between">
                  <div class="list-results-sort">
                    @if ($vehicles->count() > 0)
                    <p class="m-0">Showing {{($vehicles->currentpage()-1)*$vehicles->perpage()+1}} to {{$vehicles->currentpage()*$vehicles->perpage()}}
                        of  {{$vehicles->total()}} results</p>
                       @else
                       <p class="m-0 text-danger">Showing 0 results</p>
                    @endif

                  </div>
              </div>
              <div class="row">
                @foreach($vehicles as $vehicle)
                <div class="target col-lg-4 col-md-6 mb-4"  id="target" >
                  <div class="trend-item box-shadow rounded" style="background: #ffffff; border-color: #ffffff; border:5em">
                      <div class="trend-image imagesize">
                      @if($vehicle->pictures->first()!==null && $vehicle->pictures->first()->path)
                        <a href="{{route('car_hire.view', $vehicle->id)}}">
                          <img src="{{ asset('storage/Vehicle/' . $vehicle->pictures->first()->path) }}" alt="{{ $vehicle->model }}" loading="lazy" >
                        </a>
                        @endif
                      </div>
                      <div class="trend-content p-4">
                          <h5 class="theme">{{ $vehicle->year }}  | {{ $vehicle->make }}</h5>
                          <h4><a href="{{route('car_hire.view', $vehicle->id)}}">{{ $vehicle->model }}</a></h4>
                          <div class="entry-meta d-flex align-items-center justify-content-between border-b pb-1 mb-2">
                              <div class="entry-author">
                                  <p>Start From<span class="d-block theme fw-bold">${{ number_format($vehicle->price,2) }}/Day</span></p>

                              </div>
                              <div class="entry-metalist d-flex align-items-center">
                                  <ul>
                                    <a href="{{route('car_hire.view', $vehicle->id)}}">
                                      <li class="me-2 btn btn-success">Drive Now</li></a>
                                  </ul>
                              </div>
                          </div>
                          <p class="mb-0">{{ $vehicle->name }} </p>

                      </div>
                      <ul class="d-flex align-items-center justify-content-between p-3 px-4" style="background: rgb(14, 135, 42)">
                          <li class="me-2" style="color: rgb(226, 250, 232)"><i class="fa fa-eye"></i> {{ $vehicle->fuel_type }}</li>
                          <li class="me-2" style="color: rgb(226, 250, 232)"><i class="fa fa-heart"></i> {{ $vehicle->transmission }}</li>
                      </ul>
                  </div>
              </div>
                  @endforeach

              </div>

              <div class="pagination-main text-center">

                    {{ $vehicles->onEachSide(1)->links('custom-pagination') }}

              </div>
          </div>
      </div>
  </div>
</section>

<!-- cars Ends -->


</main><!-- End #main -->
@endsection
