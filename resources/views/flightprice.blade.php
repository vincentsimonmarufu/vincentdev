@extends('layouts.app')
@section('content')
<style>
    .select2 {
    width: 100% !important; }
</style>
<main id="main">
    <!-- BreadCrumb Starts -->
    <section class="breadcrumb-main pb-0 pt-20" style="background: #000;">
     <div class="breadcrumb-outer">
         <div class="container">
             <div class="breadcrumb-content d-md-flex align-items-center pt-6">
                 <h1 class="mb-0">Flights-Details</h1>
                 <nav aria-label="breadcrumb">
                     <ul class="breadcrumb d-flex justify-content-center">
                         <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                         <li class="breadcrumb-item active" aria-current="page">Flight-details</li>
                     </ul>
                 </nav>
             </div>
         </div>
     </div>
     <div class="dot-overlay"></div>
     <br/>
   </section>
   <!-- BreadCrumb Ends --> 

   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   @include('layouts.flightpricewidget')    
    
@endsection