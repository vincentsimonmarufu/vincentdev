@extends('layouts.app')
@section('content')
<main id="main">
  <!-- BreadCrumb Starts -->
  <section class="breadcrumb-main pb-0 pt-20" style="background: #000;">
    <div class="breadcrumb-outer">
      <div class="container">
        <div class="breadcrumb-content d-md-flex align-items-center pt-6">
          <h1 class="mb-0">Shuttle Details</h1>
          <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">shuttle Details</li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
    <div class="dot-overlay"></div>
    <br />
  </section>
  <!-- BreadCrumb Ends -->
  </section>
  <!-- blog starts -->
  <section class="blog">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="detail-maintitle border-b pb-4 mb-4">
            <div class="row align-items-center justify-content-between">
              <div class="col-lg-8">
                <div class="detail-maintitle-in">
                  <h2 class="mb-1">{{ $shuttle->make }}</h2>
                  <p><i class="fa fa-map-marker-alt me-2"></i>{{ $shuttle->model }} {{ $shuttle->year }}</p>
                  <p><i class="fa fa-map-marker-alt me-2"></i>{{ $shuttle->seater }} seater</p>

                </div>
              </div>
              <div class="col-lg-4">
                <div class="entry-price text-lg-end text-start">
                  <h3 class="mb-0"><span class="d-block theme fs-5 fw-normal">Start From</span> ${{number_format($shuttle->price,2)}} </h3>/km
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="blog-single">
            <div class="bigyapan mb-4">
              <div>
                <div class="sidebar-item mb-4 box-shadow p-4">
                  <h3>Listed By</h3>
                  <div class="author-news-content d-flex align-items-center">
                    <div class="author-content w-75 ps-4">
                      <h4 class="title mb-1"><a href="#">{{ $shuttle->user->name . ' '. $shuttle->user->surname}}</a></h4>
                      <!-- <p class="mb-1">{{ $shuttle->user->phone }}<br>{{ $shuttle->user->email }}</p>-->
                    </div>
                  </div>
                </div>
                @foreach ($shuttle->pictures as $picture)
                <img src="{{ asset('storage/shuttle/' . $picture->path) }}" class="img-fluid" alt="shuttle picture">
                @endforeach


              </div>
            </div>
          </div>
        </div>

        <!-- sidebar starts -->
        <div class="col-lg-4 col-md-12">
          <div class="sidebar-sticky">
            <div class="list-sidebar">

              <div class="sidebar-item mb-4 box-shadow p-4 text-centerb">
                <h3><b>Information</b></h3>
                <h4>{{ $shuttle->name }}</h4>
                <ul>
                  <li><strong>Category</strong>: Transport</li>
                  <li><strong>Address</strong>: {{ $shuttle->address }}</li>
                  <li><strong>Location</strong>: {{ $shuttle->city }}, {{ $shuttle->country }}</li>
                  <li><strong>Price</strong>: $<span id="price">{{ $shuttle->price }}</span> / km</li>
                  <li><strong>Seater</strong>: <span id="price">{{ $shuttle->seater }}</span> </li>
                  <li><strong>Specs & Utilities</strong>:
                    <ul>
                      <li>Transmission: {{ $shuttle->transmission }}</li>
                      <li>Fuel Type: {{ $shuttle->fuel_type }}</li>
                    </ul>
                  </li>
                </ul>

                <p class="text-info">Book now for ${{$shuttle->price}}/km</p>
                <p class="text-center">
                  @if ($errors->any())
                <div class="alert alert-danger">
                  <strong>Error!</strong>
                  <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
                @endif
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  <strong>{{ $message }}</strong>
                </div>
                @endif
                {!!Form::open(['action'=>['App\Http\Controllers\UserBookingController@store', '1']])!!}
                @csrf
                @if (auth()->user() == null)
                <p>This will automatically create a new account for you. If you already have an account please <a href="{{route('login.redirect', url()->full())}}">login here.</a></p>
                <div class="form-group">
                  {{Form::text('name', null, ['class'=>'form-control', 'placeholder' => 'First Name', 'required'])}}
                </div>
                <div class="form-group">
                  {{Form::text('surname', null, ['class'=>'form-control', 'placeholder'=>'Last Name', 'required'])}}
                </div>
                <div class="form-group">
                  {{Form::text('phone', null, ['class'=>'form-control', 'placeholder'=>'Phone Number'])}}
                </div>
                <div class="form-group">
                  {{Form::email('email', null, ['class'=>'form-control', 'placeholder'=>'Email'])}}
                </div>
                <div class="form-group">
                  {{Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password', 'required'])}}
                </div>
                <div class="form-group">
                  {{Form::password('password_confirmation', ['class'=>'form-control', 'placeholder'=>'Confirm Password', 'required'])}}
                </div>
                @endif
                <p class="text-info">Booking Details</p>
                {{Form::hidden('bookable_type', 'Shuttle')}}
                {{Form::hidden('bookable_id', $shuttle->id)}}
                <?php               
                $date = date('Y-m-d');
                $maxDate = date('Y-m-d', strtotime('+1 year'));
                ?>
                <div class="form-group row">
                  {{Form::label('km', 'km', ['class'=>'form-label col-sm-12 booking_date'])}}
                  {{Form::number('km', 10, ['id'=>'km', 'min'=>1 ,'class'=>'form-control col-sm-6 booking_date', 'required', 'placeholder'=>'km (to-from)'])}}
                </div>
                <div class="form-group row">
                  {{Form::label('start_date', 'From', ['class'=>'form-label col-sm-12 booking_date'])}}
                  {{Form::date('start_date', null, ['id'=>'start_date', 'min'=>$date,'max'=>$maxDate , 'class'=>'form-control col-sm-6 booking_date', 'required', 'placeholder'=>'start date'])}}
                </div>
                <div class="form-group row">
                  {{Form::label('end_date', 'To', ['class'=>'form-label col-sm-12 booking_date'])}}
                  {{Form::date('end_date', null, ['id'=>'end_date', 'min'=>$date,'max'=>$maxDate ,'class'=>'form-control col-sm-6 booking_date', 'required', 'placeholder'=>'end date'])}}
                </div>

                <p class="text-success" id="total_price"></p>
                {{Form::submit('Book Now', ['class'=>'btn btn-primary'])}}
                {!!Form::close()!!}
                </p>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- blog Ends -->

</main>

@endsection
@section('scripts')
<script>
  $(document).ready(function() {

    $(".booking_date").change(function() {
      var start_date = $("#start_date").val();
      var end_date = $("#end_date").val();
      var km = $("#km").val();

      if (start_date == "" || end_date == "" || km == "") {
        return false;
      }
      var dt1 = new Date(start_date);
      var dt2 = new Date(end_date);

      var time_difference = dt2.getTime() - dt1.getTime();
      var days = time_difference / (1000 * 60 * 60 * 24);
      var total_price = $("#price").text() * km;
      $("#total_price").text("You are booking for " + km + " km. Total Price is $" + total_price);
    });
  });
</script>
@endsection