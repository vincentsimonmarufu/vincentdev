@extends('layouts.auth.app')
@section('content')
<style>

    .cbp_tmtimeline {
        margin: 0;
        padding: 0;
        list-style: none;
        position: relative
    }
    
    .cbp_tmtimeline:before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        width: 3px;
        background: #eee;
        left: 20%;
        margin-left: -6px
    }
    
    .cbp_tmtimeline>li {
        position: relative
    }
    
    .cbp_tmtimeline>li:first-child .cbp_tmtime span.large {
        color: #444;
        font-size: 17px !important;
        font-weight: 700
    }
    
    .cbp_tmtimeline>li:first-child .cbp_tmicon {
        background: #fff;
        color: #666
    }
    
    .cbp_tmtimeline>li:nth-child(odd) .cbp_tmtime span:last-child {
        color: #444;
        font-size: 13px
    }
    
    .cbp_tmtimeline>li:nth-child(odd) .cbp_tmlabel {
        background: #f0f1f3
    }
    
    .cbp_tmtimeline>li:nth-child(odd) .cbp_tmlabel:after {
        border-right-color: #f0f1f3
    }
    
    .cbp_tmtimeline>li .empty span {
        color: #777
    }
    
    .cbp_tmtimeline>li .cbp_tmtime {
        display: block;
        width: 23%;
        padding-right: 70px;
        position: absolute
    }
    
    .cbp_tmtimeline>li .cbp_tmtime span {
        display: block;
        text-align: right
    }
    
    .cbp_tmtimeline>li .cbp_tmtime span:first-child {
        font-size: 15px;
        color: #3d4c5a;
        font-weight: 700
    }
    
    .cbp_tmtimeline>li .cbp_tmtime span:last-child {
        font-size: 14px;
        color: #444
    }
    
    .cbp_tmtimeline>li .cbp_tmlabel {
        margin: 0 0 15px 25%;
        background: #f0f1f3;
        padding: 1.2em;
        position: relative;
        border-radius: 5px
    }
    
    .cbp_tmtimeline>li .cbp_tmlabel:after {
        right: 100%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-right-color: #f0f1f3;
        border-width: 10px;
        top: 10px
    }
    
    .cbp_tmtimeline>li .cbp_tmlabel blockquote {
        font-size: 16px
    }
    
    .cbp_tmtimeline>li .cbp_tmlabel .map-checkin {
        border: 5px solid rgba(235, 235, 235, 0.2);
        -moz-box-shadow: 0px 0px 0px 1px #ebebeb;
        -webkit-box-shadow: 0px 0px 0px 1px #ebebeb;
        box-shadow: 0px 0px 0px 1px #ebebeb;
        background: #fff !important
    }
    
    .cbp_tmtimeline>li .cbp_tmlabel h2 {
        margin: 0px;
        padding: 0 0 10px 0;
        line-height: 26px;
        font-size: 16px;
        font-weight: normal
    }
    
    .cbp_tmtimeline>li .cbp_tmlabel h2 a {
        font-size: 15px
    }
    
    .cbp_tmtimeline>li .cbp_tmlabel h2 a:hover {
        text-decoration: none
    }
    
    .cbp_tmtimeline>li .cbp_tmlabel h2 span {
        font-size: 15px
    }
    
    .cbp_tmtimeline>li .cbp_tmlabel p {
        color: #444
    }
    
    .cbp_tmtimeline>li .cbp_tmicon {
        width: 40px;
        height: 40px;
        speak: none;
        font-style: normal;
        font-weight: normal;
        font-variant: normal;
        text-transform: none;
        font-size: 1.4em;
        line-height: 40px;
        -webkit-font-smoothing: antialiased;
        position: absolute;
        color: #fff;
        background: #46a4da;
        border-radius: 50%;
        box-shadow: 0 0 0 5px #f5f5f6;
        text-align: center;
        left: 20%;
        top: 0;
        margin: 0 0 0 -25px
    }
    
    @media screen and (max-width: 992px) and (min-width: 768px) {
        .cbp_tmtimeline>li .cbp_tmtime {
            padding-right: 60px
        }
    }
    
    @media screen and (max-width: 65.375em) {
        .cbp_tmtimeline>li .cbp_tmtime span:last-child {
            font-size: 12px
        }
    }
    
    @media screen and (max-width: 47.2em) {
        .cbp_tmtimeline:before {
            display: none
        }
        .cbp_tmtimeline>li .cbp_tmtime {
            width: 100%;
            position: relative;
            padding: 0 0 20px 0
        }
        .cbp_tmtimeline>li .cbp_tmtime span {
            text-align: left
        }
        .cbp_tmtimeline>li .cbp_tmlabel {
            margin: 0 0 30px 0;
            padding: 1em;
            font-weight: 400;
            font-size: 95%
        }
        .cbp_tmtimeline>li .cbp_tmlabel:after {
            right: auto;
            left: 20px;
            border-right-color: transparent;
            border-bottom-color: #f5f5f6;
            top: -20px
        }
        .cbp_tmtimeline>li .cbp_tmicon {
            position: relative;
            float: right;
            left: auto;
            margin: -64px 5px 0 0px
        }
        .cbp_tmtimeline>li:nth-child(odd) .cbp_tmlabel:after {
            border-right-color: transparent;
            border-bottom-color: #f5f5f6
        }
    }
    
    .bg-green {
        background-color: #50d38a !important;
        color: #fff;
    }
    
    .bg-blush {
        background-color: #ff758e !important;
        color: #fff;
    }
    
    .bg-orange {
        background-color: #ffc323 !important;
        color: #fff;
    }
    
    .bg-info {
        background-color: #2CA8FF !important;
    }
    </style>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Booking - Ref: {{ $booking->reference }}</h3>
            @if ($apartmnts->count() > 0 || $vehicles->count() > 0)
            <div class="alert alert-warning" role="alert" >
                We charge 10% for every approved vehicle or apartment booking
            </div>
            @endif
                             
            <p>
                Fullname - {{ $booking->user->name }} {{ $booking->user->surname }}<br>
                Email - {{ $booking->user->email }} <br>
                Phone - {{ $booking->user->phone }}<br>
                Start Date - {{ $booking->start_date }}<br>
                End Date - {{ $booking->end_date }}<br>
                Payment Status - {{ $booking->status }}<br><br/>
                <!--
                @if($booking->status == 'Not Paid'  && $booking->user->id == Auth::user()->id)
                <a class="btn btn-success btn-sm" href="{{ route('invoices.booking', $booking->id) }}">Pay now</a>
                @endif
                -->
            </p>
        </div>
        <div class="card-body">
            @if ($booking->apartments->count() > 0)
                <h4>Apartments booked</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Owner</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Check in</th>
                            <th>Check out</th>
                            <th>Price</th>
                            <th>Status | Action</th>
                        </tr>
                        @foreach ($booking->apartments as $apartment)
                            <tr>
                                <td>{{$apartment->user->name .' '.$apartment->user->surname  }}<br/>
                                    <small>{{$apartment->user->email}}</small>
                                </td>
                                <td>{{$apartment->user->phone}}</td>
                                <td>{{ $apartment->address }}</td>
                                <td>{{ $apartment->city }}<br/>
                                <small>{{ $apartment->country }}</small>
                                </td>
                                <td>{{ $apartment->pivot->start_date }}</td>
                                <td>{{ $apartment->pivot->end_date }}</td>
                                <td>{{ $apartment->pivot->price }}</td>
                               
                               @if (Auth::user()->id == $apartment->user_id)
                               <td>
                                    @if ($apartment->pivot->status == 'Awaiting Approval')
                                        <a href="{{route('bookable.status', [$apartment->pivot->id, "Approved"])}}" class="btn btn-primary">Approve</a>
                                        <a href="{{route('bookable.status', [$apartment->pivot->id, "Decline"])}}" class="btn btn-danger btn-sm">Decline</a>
                                    @endif
                                    @if ($apartment->pivot->status == 'Approved')
                                        <a href="{{route('bookable.status', [$apartment->pivot->id, "Checked In"])}}" class="btn btn-primary">Check In</a>
                                        <a href="{{route('bookable.status', [$apartment->pivot->id, "Decline"])}}" class="btn btn-danger btn-sm">Unbook</a>
                                    @endif
                                    @if ($apartment->pivot->status == 'Checked In')
                                        <a href="{{route('bookable.status', [$apartment->pivot->id, "Checked Out"])}}" class="btn btn-primary">Check Out</a>
                                    @endif
                                </td>
                               @else
                                <td>{{ $apartment->pivot->status }}</td>
                               @endif
                                
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif
            @if ($booking->vehicles->count() > 0)
                <h4>Vehicles booked</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Owner</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Check in</th>
                            <th>Check out</th>
                            <th>Price</th>
                            <th>Status | Action</th>
                        </tr>
                        @foreach ($booking->vehicles as $vehicle)
                            <tr>
                                <td>{{$vehicle->user->name .' '.$vehicle->user->surname  }}<br/>
                                    <small> {{$vehicle->user->email}}</small>
                                 </td>
                                 <td>{{$vehicle->user->phone}}</td>
                                 <td>{{ $vehicle->address }}</td>
                                 <td>{{ $vehicle->city }}<br/>
                                     <small> {{$vehicle->country}}</small>
                                <td>{{ $vehicle->pivot->start_date }}</td>
                                <td>{{ $vehicle->pivot->end_date }}</td>
                                <td>{{ $vehicle->pivot->price }}</td>
                               
                                @if (Auth::user()->id == $vehicle->user_id)
                                <td>
                                     @if ($vehicle->pivot->status == 'Awaiting Approval')
                                         <a href="{{route('bookable.status', [$vehicle->pivot->id, "Approved"])}}" class="btn btn-primary">Approve</a>
                                         <a href="{{route('bookable.status', [$vehicle->pivot->id, "Decline"])}}" class="btn btn-danger btn-sm">Decline</a>
                                     @endif
                                     @if ($vehicle->pivot->status == 'Approved')
                                         <a href="{{route('bookable.status', [$vehicle->pivot->id, "Checked In"])}}" class="btn btn-primary">Check In</a>
                                         <a href="{{route('bookable.status', [$vehicle->pivot->id, "Decline"])}}" class="btn btn-danger btn-sm">Unbook</a>
                                     @endif
                                     @if ($vehicle->pivot->status == 'Checked In')
                                         <a href="{{route('bookable.status', [$vehicle->pivot->id, "Checked Out"])}}" class="btn btn-primary">Check Out</a>
                                     @endif
                                 </td>
                                @else
                                <td>{{ $vehicle->pivot->status }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif
            @if ($booking->buses->count() > 0)
                <h4>Buses booked</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Owner</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Check in</th>
                            <th>Check out</th>
                            <th>Price</th>
                            <th>Status | Action</th>
                        </tr>
                        @foreach ($booking->buses as $bus)
                            <tr>
                                <td>{{$bus->user->name .' '.$bus->user->surname  }}<br/>
                                <small> {{$bus->user->email}}</small>
                                </td>
                                <td>{{$bus->user->phone}}</td>
                                <td>{{ $bus->address }}</td>
                                <td>{{ $bus->city }}<br/>
                                    <small> {{$bus->country}}</small>
                                </td>
                                <td>{{ $bus->pivot->start_date }}</td>
                                <td>{{ $bus->pivot->end_date }}</td>
                                <td>{{ $bus->pivot->price }}</td>
                            
                                @if (Auth::user()->id == $bus->user_id)
                                <td>
                                    @if ($bus->pivot->status == 'Awaiting Approval')
                                        <a href="{{route('bookable.status', [$bus->pivot->id, "Approved"])}}" class="btn btn-success btn-sm">Approve</a>
                                        <a href="{{route('bookable.status', [$bus->pivot->id, "Decline"])}}" class="btn btn-danger btn-sm">Decline</a>
                                    @endif
                                    @if ($bus->pivot->status == 'Approved')
                                        <a href="{{route('bookable.status', [$bus->pivot->id, "Checked In"])}}" class="btn btn-success btn-sm">Check In</a>
                                        <a href="{{route('bookable.status', [$bus->pivot->id, "Decline"])}}" class="btn btn-danger btn-sm">Unbook</a>
                                    @endif
                                    @if ($bus->pivot->status == 'Checked In')
                                        <a href="{{route('bookable.status', [$bus->pivot->id, "Checked Out"])}}" class="btn btn-success btn-sm">Check Out</a>
                                    @endif
                                </td>
                                @else
                                <td>{{ $bus->pivot->status }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif
            @if ($booking->shuttles->count() > 0)
            <h4>Airport shuttles booked</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>Owner</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Check in</th>
                        <th>Check out</th>
                        <th>Price</th>
                        <th>Status | Action</th>
                    </tr>
                    @foreach ($booking->shuttles as $shuttle)
                        <tr>
                            <td>{{$shuttle->user->name .' '.$shuttle->user->surname  }}<br/>
                            <small> {{$shuttle->user->email}}</small>
                            </td>
                            <td>{{$shuttle->user->phone}}</td>
                            <td>{{ $shuttle->address }}</td>
                            <td>{{ $shuttle->city }}<br/>
                                <small> {{$shuttle->country}}</small>
                            </td>
                            <td>{{ $shuttle->pivot->start_date }}</td>
                            <td>{{ $shuttle->pivot->end_date }}</td>
                            <td>{{ $shuttle->pivot->price }}</td>
                        
                            @if (Auth::user()->id == $shuttle->user_id)
                            <td>
                                @if ($shuttle->pivot->status == 'Awaiting Approval')
                                    <a href="{{route('bookable.status', [$shuttle->pivot->id, "Approved"])}}" class="btn btn-success btn-sm">Approve</a>
                                    <a href="{{route('bookable.status', [$shuttle->pivot->id, "Decline"])}}" class="btn btn-danger btn-sm">Decline</a>
                                @endif
                                @if ($bus->pivot->status == 'Approved')
                                    <a href="{{route('bookable.status', [$shuttle->pivot->id, "Checked In"])}}" class="btn btn-success btn-sm">Check In</a>
                                    <a href="{{route('bookable.status', [$shuttle->pivot->id, "Decline"])}}" class="btn btn-danger btn-sm">Unbook</a>
                                @endif
                                @if ($bus->pivot->status == 'Checked In')
                                    <a href="{{route('bookable.status', [$shuttle->pivot->id, "Checked Out"])}}" class="btn btn-success btn-sm">Check Out</a>
                                @endif
                            </td>
                            @else
                            <td>{{ $shuttle->pivot->status }}</td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif
        </div>

        <br>
        <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Add Reply
      </button>
        <hr/>
    <div class="page-content container note-has-grid">
        
        <div class="tab-content bg-transparent">
    <div class="container bootstrap snippets bootdeys">
        
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="cbp_tmtimeline">
                    @if (count($responses)> 0)
                        @foreach  ($responses as $response)
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-04T03:45"><span>{{ $response->created_at }}</span>
                                <span>Date & Time</span></time>
                            @if(Auth::user()->id == $response->user_id)
                                <div class="cbp_tmicon bg-success">
                            @else
                                <div class="cbp_tmicon bg-danger">
                            @endif
                                <i class="zmdi zmdi-label"></i></div>
                            <div class="cbp_tmlabel">
                                <h2 class="text-info">{{ $response->user->name . ' ' . $response->user->surname}}</h2>
                                <p>{{ $response->reply}}  </p>
                                @if ( $response->image != " ")
                                <div class="row clearfix">
                                    <div class="col-lg-12">
                                        <div class="map m-t-10">
                                            <br/> 
                                            <img class="rounded-square" width="100%"
                                            src="{{asset('storage/responses/'.$response->image) }}" alt=""><br/>
                                        </div>
                                    </div>
                                </div>   
                                @endif
                            </div>
                        </li>
                        @endforeach
                        @else
                        <li class="text-danger"> <div class="cbp_tmlabel"> There are no replies yet, please add one</div></li>
                    @endif
                </ul>  
            </div>
        </div>
    </div>
    </div>
        </div>
    
        <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add a Reply</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('booking_add_reply') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group mb-3">
                        <label>Image (optional)</label>
                        <input name="booking_id" id="booking_id" class="form-control" type="hidden" value="{{ $booking->id }}" required/> 
                        <input name="image" id="image" class="form-control" type="file"
                        accept=".jpg, .jpeg, .png" /> 
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group mb-3">
                        <label>Reply</label>
                        <textarea name="reply" id="reply" class="form-control" row="20" required> </textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-primary" value="Send Reply" />
            </div>
        </form>
          </div>
        </div>
      </div>
        <!-- Modal  -->
    </div>
    <br/>
    </div>

</div>
@endsection