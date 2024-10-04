<!-- resources/views/search.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Search Results</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Blade view: flightapi.rapidresults.blade.php -->

<div>
    <div class="container mt-4">
        <h1 class="mb-4">Flight Search Results</h1>
        <div id="flight-list" class="row card-body">
@if ($flights['status'])
    <p>Status: {{ $flights['message'] }}</p><br/>

    @foreach ($flights['data']['aggregation']['airlines'] as $airline)
    <p>Airline: {{ $airline['name'] }}</br>
    Logo: <img src="{{ $airline['logoUrl'] }}" alt="{{ $airline['name'] }} Logo"></br>
        IATA Code: {{ $airline['iataCode'] }}</br>
            Count: {{ $airline['count'] }}</br>
            Min Price: {{ $airline['minPrice']['currencyCode'] }} {{ $airline['minPrice']['units'] }}.{{ $airline['minPrice']['nanos'] }}</p>
        @endforeach
    @forelse ($flights['data']['flightOffers'] as $index => $flightOffer)
        <div class="flight-option">
            <h2>Option {{ $index + 1 }}</h2>
            <!-- Displaying additional details -->
            <p>Trip Type: {{ $flightOffer['tripType'] }}</p>
            <p>Price: {{ $flightOffer['priceBreakdown']['total']['currencyCode'] }} {{ $flightOffer['priceBreakdown']['total']['units'] }}.{{ $flightOffer['priceBreakdown']['total']['nanos'] }}</p>
            <p>Departure Airport: {{ $flightOffer['segments'][0]['legs'][0]['departureAirport']['name'] }} ({{ $flightOffer['segments'][0]['legs'][0]['departureAirport']['code'] }})</p>
            <p> flight Number: {{ $flightOffer['segments'][0]['legs'][0]['flightInfo']['flightNumber'] }})</p>

            @dd( $flightOffer['segments'][0]['legs'][0]['flightInfo']['carrierInfo'] )
            <p>Arrival Airport: {{ $flightOffer['segments'][0]['legs'][0]['arrivalAirport']['name'] }} ({{ $flightOffer['segments'][0]['legs'][0]['arrivalAirport']['code'] }})</p>
            <p>Departure Time: {{ $flightOffer['segments'][0]['departureTime'] }}</p>
            <p>Arrival Time: {{ $flightOffer['segments'][0]['arrivalTime'] }}</p>
            <p>Stops: {{ $flightOffer['segments'][0]['legs'][0]['flightStops'] ? count($flightOffer['segments'][0]['legs'][0]['flightStops']) : 'Direct' }}</p>
            <p>Class: {{ $flightOffer['segments'][0]['legs'][0]['cabinClass'] }}</p>
            <!-- Add more details as needed -->
            <p>
                <a href="#">Select this flight</a>
            </p>
        </div>
    @empty
        <p>No flight options available.</p>
    @endforelse

@else
    <p>Sorry, no flight information available at the moment.</p>
@endif
</div>
    </div>
</div>
</body>
</html>
