@extends('layouts.auth.app')
@section('content')
Payment Requested Details:
<table class="table table-striped table-bordered">
    <tr>
        <th>Fulname</th>
        <td>{{$invoice->name}}</td>
    </tr>
    <tr>
        <th>Email</th>
        <td>{{$invoice->email}}</td>
    </tr>
    <tr>
        <th>Invoice / Quotation No.</th>
        <td>{{$invoice->invoice_id}}</td>
    </tr>
    <tr>
        <th>Description</th>
        <td>{{$invoice->description}}</td>
    </tr>
    <tr>
        <th>Download file</th>
        <td>
            <a href="{{ route('invoice.download',[ 'id' =>$invoice->id]) }}" class="btn btn-success" target="_blank">
                Download file</a><br/><br/>
            
        </td>
    </tr>
    <tr>
        <th>Amount (RANDS)</th>
        <td>R{{$invoice->amount}}</td>
    </tr>
    <tr>
        <th>Status</th>
        <td>{{$invoice->status}}</td>
    </tr>
</table>
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
    $notify_url = 'https://www.staging.abisiniya.com/notify-payment';
@endphp
@csrf
    <input required type="hidden" name="cmd" value="_paynow">
    <input required type="hidden" name="receiver" pattern="[0-9]" value="21817361">
    <input type="hidden" name="return_url" value="{{ $return_url }}">
    <input type="hidden" name="cancel_url" value="{{ $cancel_url }}">
    <input type="hidden" name="notify_url" value="{{ $notify_url }}">
    <input required type="hidden" name="amount" value="{{ $invoice->amount }}">
     <input required type="hidden" name="m_payment_id" maxlength="255" value="{{ $invoice->id }}">
    <input required type="hidden" name="item_name" maxlength="255" value="Abisiniya Payment">
    <input type="hidden" name="item_description" maxlength="255" value="{{ $invoice->description }}">
    <input id="name_first" name="name_first" value="{{ $invoice->name }}" type="hidden">
    <input id="name_last" name="name_last" value="{{ $invoice->surname }}" type="hidden">
    <input id="email_address" name="email_address" value="{{ $invoice->email }}" type="hidden" readonly>
   <br/>

   @if ( $invoice->status == 'paid')
       <h1 class="bg-success"> Invoice has already been paid</h1>
   @else
        <input type="submit"  alt="Buy Now" value="Pay Now with Payfast" class="btn btn-success">
   @endif
   
  
    </form>
<br/>
@if ( $invoice->status != 'paid')
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