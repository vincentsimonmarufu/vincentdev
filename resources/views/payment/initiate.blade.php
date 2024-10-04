@extends('layouts.auth.app')
@section('content')
    <form action="{{ route('payment.initiate') }}" method="POST">
        @csrf
        <button type="submit">Pay Now</button>
    </form>
@endsection