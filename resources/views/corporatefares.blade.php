@extends('layouts.app')
@section('content')
<main id="main">
<style>      
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 12px;
            margin-bottom: 2px;
            font-weight: bold;
            color: #34495E;
            
        }
        input, textarea, select {
            margin-bottom: 20px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 15px;
            font-size: 16px;
            background-color: #27AE60;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #219150;
        }
        .terms {
            font-size: 14px;
            margin-bottom: 20px;
        }
        .contact-info {
            margin-top: 20px;
            font-size: 14px;
            color: #2C3E50;
        }
        .contact-info p {
            margin: 5px 0;
        }

        .success-message {
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .failure-message {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
<!-- BreadCrumb Starts -->
<section class="breadcrumb-main pb-0 pt-20" style="background: #000;">
  <div class="breadcrumb-outer">
      <div class="container">
          <div class="breadcrumb-content d-md-flex align-items-center pt-6">
              <h1 class="mb-0">Corporate Travel</h1>
              <nav aria-label="breadcrumb">
                  <ul class="breadcrumb d-flex justify-content-center">
                      <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Corporate Travel</li>
                  </ul>
              </nav>
          </div>
      </div>
  </div>
  <div class="dot-overlay"></div>
  <br/>
</section>
<!-- BreadCrumb Ends -->
<section>
  <div class="container">   
  @if(session('success'))
            <div id="success-message" class="success-message">
                {{ session('success') }}
            </div>
        @endif
        @if(session('failure'))
            <div id="failure-message" class="failure-message">
                {{ session('failure') }}
            </div>
        @endif
    <p>Get 5% to 10% on Plus 5 Free Economy Domestic Tickets Per Year</p>
    <h3>Discounted Corporate Travel</h3>    
   
    <form action="{{route('corporatetravel.save')}}" method="post">
        @csrf
        <label for="company">Name of Company/Organization</label>
        <input type="text" id="company" name="company"  placeholder='Enter name of company/organization' required>

        <label for="industry">Industry</label>
        <input type="text" id="industry" name="industry" placeholder="Enter Industry" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter email" required>

        <label for="phone">Phone</label>
        <input type="tel" id="phone" name="phone" placeholder="Enter phone" required>

        <label for="address">Address</label>
        <textarea id="address" name="address" rows="3" placeholder="Enter address" required></textarea>

        <label for="budget">Estimated Travel Budget</label>
        <input type="number" id="budget" name="budget" placeholder="Enter travel budget" required>

        <label for="trips">Number of Trips</label> 
        <input type="number" id="trips" name="trips" placeholder="Enter number of trips" required>

        <label for="authorized_person">Name of Authorized Person</label>
        <input type="text" id="authorized_person" name="authorized_person" placeholder="Enter name of authorized person" required>

        <div class="terms">
            <input type="checkbox" id="terms" name="terms" required>
            <label for="terms">I agree to the <a href="#">terms and policies</a></label>
        </div>

        <button type="submit">Submit</button>
    </form>   
</div>  
</section>

<!-- cars Ends -->


</main><!-- End #main -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 2000); 
        }
        
        var failureMessage = document.getElementById('failure-message');
        if (failureMessage) {
            setTimeout(function() {
                failureMessage.style.display = 'none';
            }, 5000); // 5000 milliseconds = 5 seconds
        }
    });
</script>
@endsection

