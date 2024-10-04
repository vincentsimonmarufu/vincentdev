<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payfast Payment</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        .payment-form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 500px;           
        }

        h1 {
            text-align: center;
            color: #333333;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
            color: #555555;
        }

        input[type="text"], input[type="hidden"] {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;            
        }

        input[type="text"]:focus {
            border-color: #66afe9;
            box-shadow: 0 0 8px rgba(102, 175, 233, 0.6);
            outline: none;
        }

        button {
            width: 100%;
            padding: 15px;
            margin-top: 20px;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            color: #ffffff;
            font-size: 18px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(40, 167, 69, 0.4);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        button:hover {
            background-color: #218838;
            box-shadow: 0 6px 8px rgba(40, 167, 69, 0.6);
        }

        button:active {
            background-color: #1e7e34;
            box-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);
        }
    </style>
</head>
<body>
    <div class="payment-form">   
        <form action="https://www.payfast.co.za/eng/process" method="POST">
            @csrf
            @foreach ($payfastData as $key => $value)  
                   
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach 

            <button type="submit">Pay Now</button>
        </form>
    </div>    
</body>
</html>
