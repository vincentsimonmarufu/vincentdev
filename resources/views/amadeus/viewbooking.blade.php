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
    /*speak: none;*/
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
<div class="card p-1">
    @if ($errors->any())
    <div class="alert alert-danger">
      <strong>Error!</strong>
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{$error}}</li>
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
    <div class="card">
        <h3 class=" mt-3">Flight booking details</h3>
        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <tr>
                    <th>PNR</th>
                    <td>{{ $flightRequest->reference }}</td>
                </tr>
                <tr>
                    <th>Queing Office ID</th>
                    <td>{{ $flightRequest->queuingOfficeId }}</td>
                </tr>
                <tr>
                    <th>Departure</th>
                    <td>{{ $flightRequest->departure }}</td>
                </tr>
                <tr>
                    <th>Arrival</th>
                    <td>{{ $flightRequest->arrival }}</td>
                </tr>
                <!-- <tr>
                    <th>Airline</th>
                    <td>{{ $flightRequest->airline }}</td>
                </tr>
                <tr>
                    <th>Carrier Code </th>
                    <td>{{$flightRequest->carrierCode}}</td>
                </tr> -->
                <tr>
                    <th>Cabin</th>
                    <td>{{$flightRequest->travel_class}}</td>
                </tr>
                <tr>
                    <th>Flight Option</th>
                    <td>{{$flightRequest->flight_option}}</td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td><strong>{{$flightRequest->price}}</strong> {{$flightRequest->currency}}</td>
                </tr>
                <!-- <tr>
                    <th>Currency</th>
                    <td>{{$flightRequest->currency}}</td>
                </tr> -->
                <!-- <tr>
                    <th>Departure Date </th>
                    <td>{{ \Carbon\Carbon::parse($flightRequest->created_at)->format('Y-m-d H:i:s') }}</td>
                </tr> -->
                <tr>
                    <th>Status</th>
                    <td>{{$flightRequest->status}}</td>
                </tr>                            
            </table>           
            <p>      
            @php
                // Base64 encode, then replace unsafe characters and remove padding '='
                $encodedPnrId = rtrim(Str::replace(['+', '/', '='], ['-', '_', ''], base64_encode($flightRequest->reference)), '=');
            @endphp
            <strong>Ticket issuance: <a href="{{ route('ticketissuance', ['pnrId' => $encodedPnrId]) }}">Download</a> </strong>                   
            </p>
            <hr>
            <table class="table table-striped table-bordered" style="width:100%">
            <h5 class=" mt-1">Itineraries details</h5>
            <hr>
                <tr>
                    <td>
                        <ul class = "list-unstyled">
                            @php 
                                $i = 1;                               
                                $segmentCount = count($segments);
                            @endphp
                            @foreach($segments as $segment)                               
                                <li>
                                    <strong>Flight Number: {{ $segment->carrier_code }}{{ $segment->flight_number }} </strong> <br>
                                    <strong>Departure:</strong> {{ airportName($segment->departure_iata) }}(<strong>{{$segment->departure_iata}}</strong>) from Terminal ({{ $segment->departure_terminal }}) at {{ $segment->departure_date_time }} <br>
                                    <strong>Arrival:</strong> {{ airportName($segment->arrival_iata) }}(<strong>{{$segment->arrival_iata}}</strong>) from Terminal ({{ $segment->arrival_terminal }}) at {{ $segment->arrival_date_time }} <br>
                                    <strong>Carrier:</strong> {{ airlineName($segment->carrier_code) }} <br>
                                    <strong>Aircraft:</strong> {{ $segment->aircraft_number }} <br>
                                    <strong> Duration:</strong> {{ $segment->duration }} <br>
                                    <strong>Stops:</strong> {{ $segment->number_of_stops }} <br><br>                                
                                </li>
                                @if($segmentCount > $i)
                                    <strong>Connecting flight </strong> - {{$i}}
                                @endif
                                @php $i++; @endphp                        
                            @endforeach                               
                              
                        </ul>
                    </td>                
                </tr>               
            </table>            
        </div>
    </div>
    @if(isset($passengers) && count($passengers) > 0)
    <h2 class=" mt-2">Passengers</h2>
    <table id="dtBasicExample" data-order='[[ 1, "asc" ]]' class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th >Fullname</th>
            <th >Gender</th>
            <th >Date of Birth</th>
            <th >Email</th>
            <th >Phone </th>
            <th >Passport </th>
        </tr>
        </thead>
        <tbody>
            @foreach($passengers as $passenger) 
                <tr>
                    <td> {{  $passenger->name }} {{ $passenger->surname  }}</td>
                    <td>{{ $passenger->gender  }}</td>
                    <td> {{  $passenger->dob  }}</td>
                    <td>{{ $passenger->email  }}</td>
                    <td> ({{ $passenger->code  }})  {{  $passenger->phone  }}</td>
                    <td>
                        <!-- <a href="{{asset('storage/passports/'.$passenger->file_path) }}" class="btn btn-info" target="he_openit"> View Passport</a> -->                      
                        <button type="button" class="btn btn-info">View Passport</button>
                    </td>
                </tr>

            @endforeach
        </tbody>
    </table>
    @endif
<br/><br/>
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
        <!-- replies-->
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
                    <form action="{{ route('flight.add_reply') }}" method="post" enctype="multipart/form-data">
                        <div class="modal-body">                
                            @csrf
                                {{--<div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="mb-3 mb-3">
                                        <label>Image (optional)</label>
                                        <input name="flight_booking_id" id="flight_booking_id" class="form-control" type="hidden" value="{{ $flightRequest->id }}" required/> 
                                        <input name="image" id="image" class="form-control" type="file"
                                        accept=".jpg, .jpeg, .png" /> 
                                    </div>
                                </div>--}}
                                <input type="hidden" name="flight_booking_id" id="flight_booking_id" class="form-control" type="hidden" value="{{ $flightRequest->id }}" required/>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="mb-3 mb-3">
                                        <label>Message</label>
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

@section('scripts')
 <script type="text/javascript">
$(document).ready(function () {
$('#dtBasicExample').DataTable();
});
    </script>
@endsection
@endsection