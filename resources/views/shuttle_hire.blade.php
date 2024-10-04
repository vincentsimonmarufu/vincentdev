@extends('layouts.app')
@section('content')
<main id="main">
<!-- BreadCrumb Starts -->
<section class="breadcrumb-main pb-0 pt-20" style="background: #000;">
  <div class="breadcrumb-outer">
      <div class="container">
          <div class="breadcrumb-content d-md-flex align-items-center pt-6">
              <h1 class="mb-0">Shuttle Hire</h1>
              <nav aria-label="breadcrumb">
                  <ul class="breadcrumb d-flex justify-content-center">
                      <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Shuttle Hire</li>
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
        <!-- start saerch bar -->
        @include('shuttle_search_form')   
        <!-- end of saerch bar -->
          <div class="trend-box">
              <div class="list-results d-flex align-items-center justify-content-between">
                  <div class="list-results-sort">
                    @if ($shuttles->count() > 0)
                    <p class="m-0">Showing {{($shuttles->currentpage()-1)*$shuttles->perpage()+1}} to {{$shuttles->currentpage()*$shuttles->perpage()}}
                        of  {{$shuttles->total()}} results</p>
                       @else
                       <p class="m-0 text-danger">Showing 0 results</p>
                    @endif

                  </div>
              </div>
              <div class="row">
                @foreach($shuttles as $shuttle)
                <div class="target col-lg-4 col-md-6 mb-4"  id="target" >
                  <div class="trend-item box-shadow rounded" style="background: #ffffff; border-color: #ffffff; border:5em">
                      <div class="trend-image">
                      @if($shuttle->pictures->first()!==null && $shuttle->pictures->first()->path)
                        <a href="{{route('shuttle.view', $shuttle->id)}}">
                          <img src="{{ asset('storage/Shuttle/' . $shuttle->pictures->first()->path) }}" alt="{{ $shuttle->model }}" loading="lazy" >
                        </a>
                        @endif
                      </div>
                      <div class="trend-content p-4">
                          <h5 class="theme">{{ $shuttle->year }}  | {{ $shuttle->make }}</h5>
                          <h4><a href="{{route('shuttle.view', $shuttle->id)}}">{{ $shuttle->model }}</a></h4>
                          <div class="entry-meta d-flex align-items-center justify-content-between border-b pb-1 mb-2">
                              <div class="entry-author">
                                  <p>Start From<span class="d-block theme fw-bold">${{ number_format($shuttle->price,2) }}/km</span></p>
                              </div>
                              <div class="entry-metalist d-flex align-items-center">
                                  <ul>
                                    <a href="{{route('shuttle.view', $shuttle->id)}}">
                                      <li class="me-2 btn btn-success">Hire Now</li></a>
                                  </ul>
                              </div>
                          </div>
                          <p class="mb-0">{{ $shuttle->name }} </p>

                      </div>
                      <ul class="d-flex align-items-center justify-content-between p-3 px-4" style="background: rgb(14, 135, 42)">
                          <li class="me-2" style="color: rgb(226, 250, 232)"><i class="fa fa-eye"></i> {{ $shuttle->fuel_type }}</li>
                          <li class="me-2" style="color: rgb(226, 250, 232)"><i class="fa fa-heart"></i> {{ $shuttle->seater }} seater</li>
                      </ul>
                  </div>
              </div>
                  @endforeach

              </div>

              <div class="pagination-main text-center">

                    {{ $shuttles->onEachSide(1)->links() }}

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
