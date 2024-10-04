<!DOCTYPE html>
<html>
<head>
    <title>Pay Now</title>
</head>
<body>
    <form action="{{ route('payment.initiate') }}" method="POST">
        @csrf
        <button type="submit">Pay Now</button>
    </form>
</body>
</html>
