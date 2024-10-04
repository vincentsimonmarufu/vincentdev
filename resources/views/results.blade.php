@extends('layouts.app')
@section('content')
<main id="main">
<!-- BreadCrumb Starts -->  
<section class="breadcrumb-main pb-0 pt-20" style="background: #000;">
  <div class="breadcrumb-outer">
      <div class="container">
          <div class="breadcrumb-content d-md-flex align-items-center pt-6">
              <h1 class="mb-0">Search Results</h1>
              <nav aria-label="breadcrumb">
                  <ul class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Search Results</li>
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
        
          <div class="trend-box">
              <div class="list-results d-flex align-items-center justify-content-between">
                  <div class="list-results-sort">
                    @if ($results->count() > 0)
                    <p class="m-0">Showing {{($results->currentpage()-1)*$results->perpage()+1}} to {{$results->currentpage()*$results->perpage()}}
                        of  {{$results->total()}} results</p>
                       @else 
                       <p class="m-0 text-danger">Showing 0 results</p>
                    @endif
                   
                  </div>
              </div>
            <!-- search bar -->
             @include('search_form')
            <br/> 

              <div class="row">
                @if ($type == 'bus')
                @foreach($results as $bus)
                    <div class="target col-lg-4 col-md-6 mb-4"  id="target" >
                    <div class="trend-item box-shadow rounded" style="background: #ffffff; border-color: #ffffff; border:5em">
                        <div class="trend-image">
                            <a href="{{route('bus_hire.view', $bus->id)}}">
                            <img src="{{ asset('storage/Bus/' . $bus->pictures->first()->path) }}"  alt="image" loading="lazy" >
                            </a>
                        </div>
                        <div class="trend-content p-4">
                            <h5 class="theme">{{ $bus->make }}</h5>
                            <h4><a href="{{route('bus_hire.view', $bus->id)}}">{{ $bus->name }}</a></h4>
                            <div class="entry-meta d-flex align-items-center justify-content-between border-b pb-1 mb-2">
                                <div class="entry-author">
                                    <p>Start From<span class="d-block theme fw-bold">${{ number_format($bus->price,2) }}/km</span></p>      
                                </div>
                                <div class="entry-metalist d-flex align-items-center">
                                    <ul>
                                        <a href="{{route('bus_hire.view', $bus->id)}}">
                                        <li class="me-2 btn btn-success">Hire Now</li></a>
                                    </ul>
                                </div>
                            </div>
                            <p class="mb-0">{{ $bus->year }} {{ $bus->model }}</p>
                            
                        </div>
                        <ul class="d-flex align-items-center justify-content-between p-3 px-4" style="background: rgb(14, 135, 42)">
                            <li class="me-2" style="color: rgb(226, 250, 232)"><i class="fa fa-eye"></i> {{ $bus->fuel_type }}</li>
                            <li class="me-2" style="color: rgb(226, 250, 232)"><i class="fa fa-heart"></i> {{ $bus->seater }} seater</li>
                        </ul>
                    </div>
                    </div>
                @endforeach 
           
                @elseif ($type == 'vehicle')
                    @foreach($results as $vehicle)
                        <div class="target col-lg-4 col-md-6 mb-4"  id="target" >
                        <div class="trend-item box-shadow rounded" style="background: #ffffff; border-color: #ffffff; border:5em">
                            <div class="trend-image">
                                <a href="{{route('car_hire.view', $vehicle->id)}}">
                                <img src="{{ asset('storage/Vehicle/' . $vehicle->pictures->first()->path) }}"  alt="image" loading="lazy" >
                                </a>
                            </div>
                            <div class="trend-content p-4">
                                <h5 class="theme">{{ $vehicle->make }}</h5>
                                <h4><a href="{{route('car_hire.view', $vehicle->id)}}">{{ $vehicle->name }}</a></h4>
                                <div class="entry-meta d-flex align-items-center justify-content-between border-b pb-1 mb-2">
                                    <div class="entry-author">
                                        <p>Start From<span class="d-block theme fw-bold">${{ number_format($vehicle->price,2) }}/Night</span></p>      
                                    </div>
                                    <div class="entry-metalist d-flex align-items-center">
                                        <ul>
                                            <a href="{{route('car_hire.view', $vehicle->id)}}">
                                            <li class="me-2 btn btn-success">Drive Now</li></a>
                                        </ul>
                                    </div>
                                </div>
                                <p class="mb-0">{{ $vehicle->year }} {{ $vehicle->model }}</p>
                                
                            </div>
                            <ul class="d-flex align-items-center justify-content-between p-3 px-4" style="background: rgb(14, 135, 42)">
                                <li class="me-2" style="color: rgb(226, 250, 232)"><i class="fa fa-eye"></i> {{ $vehicle->fuel_type }}</li>
                                <li class="me-2" style="color: rgb(226, 250, 232)"><i class="fa fa-heart"></i> {{ $vehicle->transmission }}s</li>
                            </ul>
                        </div>
                        </div>
                    @endforeach 
                
                    @else
                    @foreach($results as $apartment)
                        <div class="target col-lg-4 col-md-6 mb-4"  id="target" >
                            <div class="trend-item box-shadow rounded" style="background: #ffffff; border-color: #ffffff; border:5em">
                                <div class="trend-image">
                                    <a href="{{ route('apartments.view', $apartment->id) }}">
                                    <img src="{{ asset('storage/Apartment/' . $apartment->pictures->first()->path) }}"  alt="image" loading="lazy">
                                    </a>
                                </div>
                                <div class="trend-content p-4">
                                    <h5 class="theme">{{ $apartment->city }}</h5>
                                    <h4><a href="{{ route('apartments.view', $apartment->id) }}">{{ $apartment->name }}</a></h4>
                                    <div class="entry-meta d-flex align-items-center justify-content-between border-b pb-1 mb-2">
                                        <div class="entry-author">
                                            <p>Start From<span class="d-block theme fw-bold">${{ number_format($apartment->price,2) }}/Night</span></p>
                                            
                                        </div>
                                        <div class="entry-metalist d-flex align-items-center">
                                            <ul>
                                            <a href="{{ route('apartments.view', $apartment->id) }}">
                                                <li class="me-2 btn btn-success">Book Now</li></a>
                                            </ul>
                                        </div>
                                    </div>
                                    <p class="mb-0">{{ $apartment->address }}</p>
                                    
                                </div>
                                <ul class="d-flex align-items-center justify-content-between  p-3 px-4" style="background: rgb(14, 135, 42)">
                                    <li class="me-2"  style="color: rgb(226, 250, 232)"><i class="fa fa-eye"></i> {{ $apartment->bedroom }} Bedroom(s)</li>
                                    <li class="me-2"  style="color: rgb(226, 250, 232)"><i class="fa fa-heart"></i> {{ $apartment->bathroom }} Bathroom(s)</li>
                                </ul>
                            </div>
                        </div>
                    @endforeach  
                @endif
                

                </div>
            
                <div class="pagination-main text-center">
                    {{ $results->onEachSide(1)->links() }}
              </div>
          </div>
      </div>
  </div>
</section>

<!-- cars Ends -->  


</main><!-- End #main -->
@endsection