@extends('layouts.auth.app')
@section('styles')
<style>
    .heading {
        font-size: 25px;
        margin-right: 25px;
    }

    /* Three column layout */
    .side {
        float: left;
        width: 15%;
        margin-top: 10px;
    }

    .middle {
        float: left;
        width: 70%;
        margin-top: 10px;
    }

    /* Place text to the right */
    .right {
        text-align: right;
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    /* The bar container */
    .bar-container {
        width: 100%;
        background-color: #f1f1f1;
        text-align: center;
        color: white;
    }

    /* Individual bars */
    .bar-5 {
        height: 18px;
        background-color: #4CAF50;
    }

    .bar-4 {
        height: 18px;
        background-color: #2196F3;
    }

    .bar-3 {
        height: 18px;
        background-color: #00bcd4;
    }

    .bar-2 {
        height: 18px;
        background-color: #ff9800;
    }

    .bar-1 {
        height: 18px;
        background-color: #f44336;
    }

    /* Responsive layout - make the columns stack on top of each other instead of next to each other */
    @media (max-width: 400px) {

        .side,
        .middle {
            width: 100%;
        }

        /* Hide the right column on small screens */
        .right {
            display: none;
        }
    }

    .bigger-star {
        font-size: 25px;
    }
</style>
@endsection
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Book Now for $<span id="price">{{$vehicle->price}}</span>/day</h3>
        </div>
        <?php
        // Set the new timezone
        // date_default_timezone_set('Asia/Kolkata');
        //$date = date('Y-m-d');
        $date = date('d-m-Y');
        ?>
        <div class="card-body">
            @if (auth()->user() != null)
            {!!Form::open(['action'=>['App\Http\Controllers\UserBookingController@store', auth()->user()->id]])!!}
            {{Form::hidden('bookable_type', 'Vehicle')}}
            {{Form::hidden('bookable_id', $vehicle->id)}}
            <div class="mb-3 row">
                {{Form::date('start_date', null, ['id'=>'start_date', 'min'=>$date,'max'=>'2025-01-01' ,'class'=>'form-control col-sm-12 mb-3  booking_date', 'required', 'placeholder'=>'start date'])}}
                {{Form::date('end_date', null, ['id'=>'end_date', 'min'=>$date,'max'=>'2025-01-01' ,'class'=>'form-control col-sm-12 mb-3  booking_date', 'required', 'placeholder'=>'end date'])}}
            </div>
            <p class="text-info" id="booked"></p>
            <p class="text-danger" id="total_price"></p>
            {{Form::submit('Book Now', ['class'=>'btn btn-primary'])}}
            {!!Form::close()!!}
            @else
            <p>Please <a href="{{route('login')}}">login</a> or <a href="{{route('register')}}">sign up</a> to book</p>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    <h3>Vehicle belonging to:<br />
                        {{$vehicle->user->name}} {{$vehicle->user->surname}}<br />
                        {{$vehicle->user->email}}<br />
                        {{$vehicle->user->phone}}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>Name</th>
                                <td>{{$vehicle->name}}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{$vehicle->address}}</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>{{$vehicle->city}}</td>
                            </tr>
                            <tr>
                                <th>Country</th>
                                <td>{{$vehicle->country}}</td>
                            </tr>
                            <tr>
                                <th>Make</th>
                                <td>{{$vehicle->make}}</td>
                            </tr>
                            <tr>
                                <th>Model</th>
                                <td>{{$vehicle->model}}</td>
                            </tr>
                            <tr>
                                <th>Year</th>
                                <td>{{$vehicle->year}}</td>
                            </tr>
                            <tr>
                                <th>Engine Size (CC)</th>
                                <td>{{$vehicle->engine_size}}</td>
                            </tr>
                            <tr>
                                <th>Fuel Type</th>
                                <td>{{$vehicle->fuel_type}}</td>
                            </tr>
                            <tr>
                                <th>Weight</th>
                                <td>{{$vehicle->weight}}</td>
                            </tr>
                            <tr>
                                <th>Color</th>
                                <td>{{$vehicle->color}}</td>
                            </tr>
                            <tr>
                                <th>Transmission</th>
                                <td>{{$vehicle->transmission}}</td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td>{{$vehicle->price}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <h3>Vehicle images</h3>
                    @if ($vehicle->pictures->count() > 0)
                    @if($vehicle->pictures->count() > 1)
                    <div id="demo" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($vehicle->pictures as $key => $picture)
                            @if ($loop->first)
                            <div class="carousel-item active" style="height:400px">
                                <img style="position:absolute; top:50%; right:50%; transform:translate(50%,-50%)" class="img-fluid" src="{{asset('storage/Vehicle/' . $picture->path)}}" alt="Vehicle Picture">
                            </div>
                            @else
                            <div class="carousel-item" style="height:400px">
                                <img style="position:absolute; top:50%; right:50%; transform:translate(50%,-50%)" class="img-fluid" src="{{asset('storage/Vehicle/' . $picture->path)}}" alt="Vehicle Picture">
                            </div>
                            @endif
                            @endforeach
                        </div>

                        <a class="carousel-control-prev text-primary" href="#demo" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#demo" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>
                    </div>
                    <div>
                        @foreach ($vehicle->pictures as $key => $picture)
                        <img width="{{ 50/$vehicle->pictures->count() }}%" src="{{asset('storage/Vehicle/' . $picture->path)}}" alt="Vehicle Picture" data-target="#demo" data-slide-to="{{ $key }}">
                        @endforeach
                    </div>
                    @else
                    <img src="{{asset('storage/Vehicle/' . $vehicle->pictures->first()->path)}}" class="img-fluid">
                    @endif
                    @else
                    <p class="text-info">There are no images on this vehicle</p>
                    @endif
                </div>
                <a href="{{route('vehicles.pictures.index', $vehicle->id)}}" class="btn btn-primary mt-2">Manage Pictures</a>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <span class="heading">User Rating</span><br />
                    @if ($vehicle->ratings->count() > 0)
                    @for ($i = 0; $i < 5; $i++) @if ($i < $averageRating) <i class="fas fa-star text-warning bigger-star"></i>
                        @else
                        <i class="fas fa-star bigger-star"></i>
                        @endif
                        @endfor
                        <p>{{round($averageRating,1)}} average based on <span id="totalRatings">{{$vehicle->ratings->count()}}</span> reviews.</p>
                        <hr style="border:3px solid #f1f1f1">

                        <div class="row">
                            <div class="side">
                                <div>5 star</div>
                            </div>
                            <div class="middle">
                                <div class="bar-container">
                                    <div class="bar-5"></div>
                                </div>
                            </div>
                            <div class="side right">
                                <div id="ratings5">{{$vehicle->ratings->where('score',5)->count()}}</div>
                            </div>
                            <div class="side">
                                <div>4 star</div>
                            </div>
                            <div class="middle">
                                <div class="bar-container">
                                    <div class="bar-4"></div>
                                </div>
                            </div>
                            <div class="side right">
                                <div id="ratings4">{{$vehicle->ratings->where('score',4)->count()}}</div>
                            </div>
                            <div class="side">
                                <div>3 star</div>
                            </div>
                            <div class="middle">
                                <div class="bar-container">
                                    <div class="bar-3"></div>
                                </div>
                            </div>
                            <div class="side right">
                                <div id="ratings3">{{$vehicle->ratings->where('score',3)->count()}}</div>
                            </div>
                            <div class="side">
                                <div>2 star</div>
                            </div>
                            <div class="middle">
                                <div class="bar-container">
                                    <div class="bar-2"></div>
                                </div>
                            </div>
                            <div class="side right">
                                <div id="ratings2">{{$vehicle->ratings->where('score',2)->count()}}</div>
                            </div>
                            <div class="side">
                                <div>1 star</div>
                            </div>
                            <div class="middle">
                                <div class="bar-container">
                                    <div class="bar-1"></div>
                                </div>
                            </div>
                            <div class="side right">
                                <div id="ratings1">{{$vehicle->ratings->where('score',1)->count()}}</div>
                            </div>
                        </div>
                        @else
                        <p class="text-info">There are no ratings yet! Be the first to leave a review</p>
                        @endif
                </div>
                <div class="card-body">
                    <h3>Leave your review</h3>
                    {!!Form::open(['action'=>'App\Http\Controllers\RatingController@store'])!!}
                    {{Form::hidden('rating_type', 'App\\Models\\Vehicle')}}
                    {{Form::hidden('rating_id', $vehicle->id)}}
                    {{Form::hidden('score', null, ['id'=>'score'])}}
                    <div class="mb-3">
                        <i id="star0" class="far fa-star bigger-star"></i>
                        <i id="star1" class="far fa-star bigger-star"></i>
                        <i id="star2" class="far fa-star bigger-star"></i>
                        <i id="star3" class="far fa-star bigger-star"></i>
                        <i id="star4" class="far fa-star bigger-star"></i>
                    </div>
                    <div class="mb-3">
                        {{Form::textarea('comment', null, ['class'=>'form-control', 'required', 'placeholder'=>'Please tell us about your experience', 'rows'=>'3', 'max'=>'255'])}}
                    </div>
                    {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
                    {!!Form::close()!!}
                </div>
                @if ($vehicle->ratings->count() > 0)
                <div class="card-footer">
                    @foreach ($vehicle->ratings->sortByDesc('created_at') as $rating)
                    <p>
                        {{$rating->user->name}} {{$rating->user->surname}}<br />
                        @for ($i = 0; $i < 5; $i++) @if ($i < $rating->score)
                            <i class="fas fa-star text-warning"></i>
                            @else
                            <i class="far fa-star"></i>
                            @endif
                            @endfor
                            <small>{{$rating->created_at->format('d-m-Y')}}</small>
                            <br />
                            {{$rating->comment}}
                    </p>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        //handle the event of a rating star being hovered
        $(".fa-star").mouseenter(function() {
            var selected = $(this).attr('id').substr(4, 1);
            for (let index = 0; index < 5; index++) {
                if (index <= selected) {
                    $("#star" + index).removeClass('far');
                    $("#star" + index).addClass('fas');
                    $("#star" + index).addClass('text-warning');
                } else {
                    $("#star" + index).addClass('far');
                    $("#star" + index).removeClass('fas');
                    $("#star" + index).removeClass('text-warning');
                }
            }
            $("#score").val(parseInt(selected) + 1);
        });

        var totalRatings = parseInt($("#totalRatings").text());
        for (let index = 1; index < 6; index++) {
            rating = parseInt($("#ratings" + index).text());
            $(".bar-" + index).css("width", rating * 100 / totalRatings + '%');
        }
    });
</script>
<script>
    $(document).ready(function() {

        $(".booking_date").change(function() {
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();

            if (start_date == "" || end_date == "") {
                return false;
            }
            var dt1 = new Date(start_date);
            var dt2 = new Date(end_date);

            var time_difference = dt2.getTime() - dt1.getTime();
            var days = time_difference / (1000 * 60 * 60 * 24);
            var total_price = $("#price").text() * days;
            $("#total_price").text("You are booking for " + days + " days. Total Price is $" + total_price);
        });
    });
</script>
@endsection