@extends('layouts.auth.app')
@section('content')
<h2>Booking Details:</h2>
<table class="table table-striped table-bordered">
    <tr>
        <th>Booking - Reference</th>
        <td>{{ $booking->reference }}</td>
    </tr>      
    <tr>
        <th>Fulname</th>
        <td>{{ $booking->user->name }} {{ $booking->user->surname }}</td>
    </tr>
    <tr>
        <th>Contact</th>
        <td> {{ $booking->user->email }} <br/>
            <small>{{ $booking->user->phone }}</small>
        </td>
    </tr>
    <tr>
        <th>Start Date</th>
        <td>{{ $booking->start_date }}</td>
    </tr>
    <tr>
        <th>End Date</th>
        <td>{{ $booking->end_date }}</td>
    </tr>
    <tr>
        <th>Payment Status</th>
        <td>{{ $booking->status }}</td>
    </tr>
    <tr>
        <th>Exchange Rate (RANDS)</th>
        <td>{{ number_format($exchangerate,2) }}</td>
    </tr>
</table>
<div class="card-body">
    @if ($booking->apartments->count() > 0)
        <h4>Apartments booked</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <tr>
                    <th>Owner</th>
                    <th>Address</th>
                    <th>Check in</th>
                    <th>Check out</th>
                    <th>Price(USD)</th>
                    <th>Price(RANDS)</th>
                    <th>Booking Status </th>
                </tr>
                @foreach ($booking->apartments as $apartment)
                @php 
                $amount = $apartment->pivot->price;
                @endphp
                    <tr>
                        <td>{{$apartment->user->name .' '.$apartment->user->surname  }}<br/>
                            <small>{{$apartment->user->email}}</small><br/>
                            <small>{{$apartment->user->phone}}</small>
                        </td>
                        <td>{{ $apartment->address }},<br/>
                        <small>{{ $apartment->city }},</small><br/>
                        <small>{{ $apartment->country }}</small>
                        </td>
                        <td>{{ $apartment->pivot->start_date }}</td>
                        <td>{{ $apartment->pivot->end_date }}</td>
                        <td>{{ $apartment->pivot->price }}</td>
                        <td>{{ number_format($amount * number_format($exchangerate,2),2) }}</td>
                        <td>{{ $apartment->pivot->status }}</td>
                        
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
                    <th>Address</th>
                    <th>Check in</th>
                    <th>Check out</th>
                    <th>Price(USD)</th>
                    <th>Price(RANDS)</th>
                    <th>Booking Status </th>
                </tr>
                @foreach ($booking->vehicles as $vehicle)
                @php 
                $amount = $vehicle->pivot->price;
                @endphp
                    <tr>
                        <td>{{$vehicle->user->name .' '.$vehicle->user->surname  }}<br/>
                            <small> {{$vehicle->user->email}}</small><br/>
                            <small>{{$vehicle->user->phone}}</small>
                         </td>
                         <td>{{ $vehicle->address }},<br/>
                            <small> {{$vehicle->city}},</small><br/>
                            <small> {{$vehicle->country}}</small>
                         </td>
                        <td>{{ $vehicle->pivot->start_date }}</td>
                        <td>{{ $vehicle->pivot->end_date }}</td>
                        <td>{{ $vehicle->pivot->price }}</td>
                        <td>{{ number_format($amount * number_format($exchangerate,2),2) }}</td>
                        <td>{{ $vehicle->pivot->status }}</td>
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
                    <th>Address</th>
                    <th>Check in</th>
                    <th>Check out</th>
                    <th>Price(USD)</th>
                    <th>Price(RANDS)</th>
                    <th>Booking Status </th>
                </tr>
                @foreach ($booking->buses as $bus)
                @php 
                $amount = $bus->pivot->price;
                @endphp
                    <tr>
                        <td>{{$bus->user->name .' '.$bus->user->surname  }}<br/>
                        <small> {{$bus->user->email}}</small>
                        <br/>
                        <small>{{$bus->user->phone}}</small>
                        </td>
                        <td>{{ $bus->address }},<br/>
                            <small> {{ $bus->city }},</small>
                        <br/>
                            <small> {{$bus->country}}</small>
                        </td>
                        <td>{{ $bus->pivot->start_date }}</td>
                        <td>{{ $bus->pivot->end_date }}</td>
                        <td>{{ $bus->pivot->price }}</td>
                        <td>{{ number_format($amount * number_format($exchangerate,2),2) }}</td>
                        <td>{{ $bus->pivot->status }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif
    @if ($booking->shuttles->count() > 0)
        <h4>Shuttles booked</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <tr>
                    <th>Owner</th>
                    <th>Address</th>
                    <th>Check in</th>
                    <th>Check out</th>
                    <th>Price(USD)</th>
                    <th>Price(RANDS)</th>
                    <th>Booking Status </th>
                </tr>
                @foreach ($booking->shuttles as $shuttle)
                @php 
                $amount = $shuttle->pivot->price;
                @endphp
                    <tr>
                        <td>{{$shuttle->user->name .' '.$shuttle->user->surname  }}<br/>
                        <small> {{$shuttle->user->email}}</small>
                        <br/>
                        <small>{{$shuttle->user->phone}}</small>
                        </td>
                        <td>{{ $shuttle->address }},<br/>
                            <small> {{ $shuttle->city }},</small>
                        <br/>
                            <small> {{$shuttle->country}}</small>
                        </td>
                        <td>{{ $shuttle->pivot->start_date }}</td>
                        <td>{{ $shuttle->pivot->end_date }}</td>
                        <td>{{ $shuttle->pivot->price }}</td>
                        <td>{{ number_format($amount * number_format($exchangerate,2),2) }}</td>
                        <td>{{ $shuttle->pivot->status }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif
</div>
<p class="text-danger"> All payments are converted to RANDS for our bank to be able to collect payment, 
    but you can pay using your own currency, it will be converted using bank rates</p>
@php
$siteurl = url('/');
// If in testing mode make use of either sandbox.payfast.co.za or www.payfast.co.za
$testingMode = false;
$pfHost = $testingMode ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
//input the address for action
$htmlForm = '<form name="PayFastPayNowForm" action="https://'.$pfHost.'/eng/process" method="post">';
//<form name="PayFastPayNowForm" action="{{ route('payfast.payPayfast') }}" method="post">
 echo $htmlForm  ;

    $return_url = $siteurl . '/return-payment';
    $cancel_url = $siteurl . '/cancel-payment';
    $notify_url = 'https://www.abisiniya.com/notify-booking-payment';
    $exchange = number_format($exchangerate,2);
    $amount =  $amount * $exchange;
@endphp
@csrf
    <input required type="hidden" name="cmd" value="_paynow">
    <input required type="hidden" name="receiver" pattern="[0-9]" value="21817361">
    <input type="hidden" name="return_url" value="{{ $return_url }}">
    <input type="hidden" name="cancel_url" value="{{ $cancel_url }}">
    <input type="hidden" name="notify_url" value="{{ $notify_url }}">
    <input required type="hidden" name="amount" value="{{ $amount }}">
     <input required type="hidden" name="m_payment_id" maxlength="255" value="{{ $booking->reference }}">
    <input required type="hidden" name="item_name" maxlength="255" value="Abisiniya Payment">
    <input type="hidden" name="item_description" maxlength="255" value="Booking Invoice Payment">
    <input id="name_first" name="name_first" value="{{ $booking->user->name }}" type="hidden">
    <input id="name_last" name="name_last" value="{{ $booking->user->surname }}" type="hidden">
    <input id="email_address" name="email_address" value="{{ $booking->user->email  }}" type="hidden" readonly>
   <br/>

   @if ( $booking->status == 'paid')
       <h1 class="bg-success"> Invoice has already been paid</h1>
   @else
        <input type="submit"  alt="Buy Now" value="Pay Now with Payfast" class="btn btn-success">
   @endif
   
  
    </form>
<br/>
@if ( $booking->status != 'paid')
    <button onclick="copyToClipboard()" class="btn btn-info">Copy Link and Share</button>
    @endif
    @section('scripts')
    <script>
        function copyToClipboard(text) {
        var inputc = document.body.appendChild(document.createElement("input"));
        inputc.value = window.location.href;
        inputc.focus();
        inputc.select();
        document.execCommand('copy');
        inputc.parentNode.removeChild(inputc);
        alert("URL Copied.");
        }
        </script>
      @endsection  
@endsection