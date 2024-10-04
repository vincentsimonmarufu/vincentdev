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

    <div class="card">
        <div class="card-header">
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
            <h1>{{$flightRequest->user->name}} {{$flightRequest->user->surname}}</h1>
            <p>
                Phone number: {{ $flightRequest->user->phone }}
                Email: {{ $flightRequest->user->email }}
            </p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <tr>
                        <th>Departure Date</th>
                        <td>{{$flightRequest->created_at}}</td>
                    </tr>
                    <tr>
                        <th>Return Date</th>
                        <td>{{$flightRequest->return_date??'No data'}}</td>
                    </tr>
                    <tr>
                        <th>Reference</th>
                        <td>{{$flightRequest->reference}}</td>
                    </tr>
                    <tr>
                        <th>To</th>
                        <td>{{$flightRequest->arrival}}</td>
                    </tr>
                    <tr>
                        <th>From</th>
                        <td>{{$flightRequest->departure}}</td>
                    </tr>
                    <tr>
                        <th>Airline</th>
                        <td>{{$flightRequest->airline}}</td>
                    </tr>
                    
                    <tr>
                        <th>Travel Class</th>
                        <td>{{$flightRequest->travel_class}}</td>
                    </tr>
                    <tr>
                        <th>Trip Option</th>
                        <td>{{$flightRequest->flight_option}}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{$flightRequest->status}}</td>
                    </tr>
                </table>
            </div>
        </div>
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
            <form action="{{ route('add_reply') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="mb-3 mb-3">
                    <label>Image (optional)</label>
                    <input name="flightrequest_id" id="flightrequest_id" class="form-control" type="hidden" value="{{ $flightRequest->id }}" required/> 
                    <input name="image" id="image" class="form-control" type="file"
                    accept=".jpg, .jpeg, .png" /> 
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="mb-3 mb-3">
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
@section('scripts')
 <script type="text/javascript">
    $(document).ready(function () {
    $('#example').DataTable();
});
    </script>
@endsection
@endsection