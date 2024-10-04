@extends('layouts.auth.app')
@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .message {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h1 {
            color: #dc3545;
        }
    </style>
    <div class="message">
        <h1>Payment Cancelled</h1>
        <p>Your payment was cancelled. Please try again.</p>
        <a href="{{ url('/') }}">Return to Home</a>
    </div>
@endsection