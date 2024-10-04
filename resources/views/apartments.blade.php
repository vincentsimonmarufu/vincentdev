@extends('layouts.app')
@section('content')
<style>
    .imagesize {
    width: 350px; 
    height: 200px; 
    margin: 0 auto; 
    overflow: hidden;
    }

    .imagesize img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .more-link {
        color: blue;
        cursor: pointer;
    }  
    </style>
<main id="main">
  <!-- BreadCrumb Starts -->  
  <section class="breadcrumb-main pb-0 pt-20" style="background: #000;">
    <div class="breadcrumb-outer">
        <div class="container">
            <div class="breadcrumb-content d-md-flex align-items-center pt-6">
                <h1 class="mb-0">Apartments</h1>
                <nav aria-label="breadcrumb">
                    <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Apartments</li>
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
          
      <!-- end of saerch bar -->
          <div class="trend-box">
              <div class="list-results d-flex align-items-center justify-content-between">
                  <div class="list-results-sort">
                    @if ($apartments->count() > 0)
                    <p class="m-0">Showing {{($apartments->currentpage()-1)*$apartments->perpage()+1}} to {{$apartments->currentpage()*$apartments->perpage()}}
                      of  {{$apartments->total()}} results</p>
                       @else 
                       <p class="m-0 text-danger">Showing 0 results</p>
                    @endif
                     
                  </div>
              </div>
              <div class="row">
                @foreach($apartments as $apartment)
                  <div class="target col-lg-4 col-md-6 mb-4"  id="target" >
                      <div class="trend-item box-shadow rounded" style="background: #ffffff; border-color: #ffffff; border:5em">
                          <div class="trend-image imagesize">
                            @if($apartment->pictures->first()!==null && $apartment->pictures->first()->path)
                            <a href="{{ route('apartments.view', $apartment->id) }}">
                              <img src="{{ asset('storage/Apartment/' . $apartment->pictures->first()->path) }}"  alt="{{ $apartment->address }}" loading="lazy">
                            @endif
                            </a>
                          </div>
                          <div class="trend-content p-4">
                              <h5 class="theme">{{ $apartment->city }}</h5>
                              <h4><a href="{{ route('apartments.view', $apartment->id) }}">{{ $apartment->name}}</a></h4>
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
                              {{-- <p class="mb-0">{{ $apartment->address }}</p> --}}
                              <p style="height: 40px !important;">             
                                        @if (strlen($apartment->address) > 50)
                                            @php
                                                $addressId = 'address_' . uniqid(); // Generate a unique ID for the address
                                            @endphp
                                            <span id="{{ $addressId }}" class="address-text">
                                                {{ substr($apartment->address, 0, 50) }}
                                                <span id="{{ $addressId }}_more_text" class="more-text" style="display: none;">{{ substr($apartment->address, 50) }}</span>
                                                <a href="#" class="more-link" data-toggle="more-less" data-target="{{ $addressId }}">More</a>
                                            </span>
                                            <script>
                                                // JavaScript to handle the "More" link toggle
                                                document.addEventListener('DOMContentLoaded', function () {
                                                    const moreLink = document.querySelector('[data-toggle="more-less"][data-target="{{ $addressId }}"]');
                                                    const moreText = document.getElementById('{{ $addressId }}_more_text');
                                                    const addressContainer = document.getElementById('{{ $addressId }}').parentElement;

                                                    if (moreLink && moreText) {
                                                        moreLink.addEventListener('click', function (e) {
                                                            e.preventDefault();
                                                            moreText.style.display = (moreText.style.display === 'none') ? 'inline' : 'none';
                                                            moreLink.textContent = (moreText.style.display === 'none') ? 'More' : 'Less';
                                                            
                                                            // Update height of parent <p> based on content visibility
                                                            if (moreText.style.display === 'none') {
                                                                addressContainer.style.height = '40px'; // Default height
                                                            } else {
                                                                addressContainer.style.height = 'auto'; // Expand to fit content
                                                            }
                                                        });
                                                    }
                                                });
                                            </script>
                                        @else
                                            <span class="address-text">{{ $apartment->address }}</span>
                                        @endif
                                    </p>
                              
                          </div>
                          <ul class="d-flex align-items-center justify-content-between  p-3 px-4" style="background: rgb(14, 135, 42)">
                              <li class="me-2"  style="color: rgb(226, 250, 232)"><i class="fa fa-eye"></i> {{ $apartment->bedroom }} Bedroom(s)</li>
                              <li class="me-2"  style="color: rgb(226, 250, 232)"><i class="fa fa-heart"></i> {{ $apartment->bathroom }} Bathroom(s)</li>
                          </ul>
                      </div>
                  </div>
                @endforeach  

              </div>              
              <div class="pagination svg offset-md-3">                     
                  {{ $apartments->onEachSide(1)->links('custom-pagination') }}                            
              </div>
          </div>
      </div>
  </div>
</section>
<!-- blog Ends -->  


</main><!-- End #main -->
@endsection
@section('scripts')
<script type="text/javascript">
  $('.testimonial-pics img').click(function () {
      $('.testimonial-pics img').removeClass("active");
      $(this).addClass("active");

      $(".testimonial").removeClass("active");
      $("#" + $(this).attr("alt")).addClass("active");
    });
</script>
<script>
 function myFunction() {
  var input = document.getElementById("Search");
  var filter = input.value.toLowerCase();
  var nodes = document.getElementsByClassName('target');

  for (i = 0; i < nodes.length; i++) {
    if (nodes[i].innerText.toLowerCase().includes(filter)) {
      nodes[i].style.display = "block";
    } else {
      nodes[i].style.display = "none";
    }
  }
}

</script>
@endsection