<!-- resources/views/search.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Search Results</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
<style>



.flight-card{
  width:805px;
  height: 610px;
  margin: 100px auto;
  border-radius: 50px;
  overflow:hidden;
box-shadow: 0px 0px 5px rgba(0,0,0,0.2);
  .flight-card-header{
    height: 250px;
    width: 100%;
    background: linear-gradient(to bottom, #264b76 0%,#002c5f 100%);
    padding: 30px 50px;
    border-bottom: 7px solid #6DBE47;
    position: relative;
    .flight-logo{
      height: 110px;
      width:100%;
        img{
          width: 150px;
        }
    }
    .flight-data{
      height:auto;
      border-top: 2px solid #3E5177;
      padding-top: 1em;
      display: grid;
      grid-template-columns: 2fr 1fr 1fr;
      text-align: left;
      span{
        display:block;
      }
      .title{
          color: #838EA8;
        font-size: 16px;
        }
      .detail{
        font-size: 18px;
        padding-top: 3px;
        color: white;
      }
     
    }
  }
  
  
  .flight-card-content{
    width: 100%;
    height: auto;
    display: inline-block;
    .flight-row{
      width: 100%;
      padding: 50px 50px;
      display:grid;
      grid-template-columns: 1fr 1fr 1fr;
      .plane{
        text-align: center;
        position: relative;
        img{
        width: 90px;
        }
        &:before{
          content: '';
  width: 135px;
  height: 3px;
  background: #efefef;
  position: absolute;
  top: 45px;
  left: -75px;
        }
        &:after{
          content: '';
          width: 135px;
          height: 3px;
          background-color: #efefef;
          position:absolute;
          top: 45px;
          right: -75px;
          
        }
        }
      }
    .flight-from{
      text-align: left;
      float:left;
    }
    .flight-to{
      text-align: right;
      float:right;
    }
      .flight-from,.flight-to{
        span{
          display:block;
        }
        .from-code, .to-code{
          font-size: 60px;
          color: #002C5F;
          font-weight:200;
        }
        .from-city, .to-city{
            font-size: 18px;
          color: #002C5F;
          font-weight:400;
        }
      }
    .flight-details-row{
      width:100%;
      display:grid;
      padding: 30px 50px;
      grid-template-columns: 1fr 1fr 1fr; 
      span{
        display:block;
      }
      .title{
          color:#6a8597;
        font-size:16px;
        letter-spacing: 3px;
       }
      .detail{
        margin-top:.2em;
        color:#002C5F;
        font-size:18px;
      }
      .flight-operator{
        text-align:left;
        float:left;
      }
      .flight-class{
        float:right;
        text-align:right;
      }
      .flight-number{
        padding-left:80px;
      }
    }
    }
  }
  
    </style>
</head>
<body>
          
   <div>
     <div class="container mt-4">
        <h1 class="mb-4">Flight Search Results</h1>
        <div id="flight-list" class="row">
            <!-- Flight results will be displayed here -->
            @foreach ($flights as $flight)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            {{ $flight['cityFrom'] }} ({{ $flight['flyFrom'] }}) to {{ $flight['cityTo'] }} ({{ $flight['flyTo'] }})
                        </h5>
                            <p><strong>Airlines on the Route</strong>
                            @if (count($flight['airlines']) > 0)
                                <ul>
                                    @foreach ($flight['airlines'] as $airline)
                                        <li>{{ $airline }}</li>
                                    @endforeach
                                </ul>
                            @else
                                No information about airlines available for this route.
                            @endif
                        </p>
                        @php
                            $local_departure = \Carbon\Carbon::parse($flight['local_departure'])->format('Y-m-d H:i:s');
                            $local_arrival = \Carbon\Carbon::parse($flight['local_arrival'])->format('Y-m-d H:i:s');
                            

                            $seconds = $flight['duration']['total'];
                            $hours = floor($seconds / 3600);
                            $minutes = floor(($seconds % 3600) / 60);

                            // Format the duration as HH:MM
                            $durationInHours = sprintf('%02d:%02d', $hours, $minutes);

                        @endphp
                        <p class="card-text"><strong> Price: </strong>{{ $flight['price'] }} USD</p>
                        <p><strong>Technical Stops:</strong>  {{ $flight['technical_stops'] }} stop(s)</p>
                        <p><strong>Departure:</strong> {{ $local_departure }} ({{ $flight['cityFrom'] }})</p>
                        <p><strong>Duration:</strong>  {{ $durationInHours }} hrs</p>
                        <p><strong>Arrival:</strong> {{ $local_arrival }} ({{ $flight['cityTo'] }})</p>
                       
                        <p><strong>Number of Available Seats:</strong> 
                            @if (isset($flight['availability']['seats']))
                                   {{ $flight['availability']['seats'] }}
                            @else
                               Information Not Available
                                @endif
                        </p>
                        @foreach ($flight['route']  as $segment)
                        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 20px;">
                                <p><strong>Airline:</strong> {{ $segment['airline'] }}</p>
                                <p><strong>Flight Number:</strong> {{ $segment['flight_no'] }}</p>
                                <p><strong>Fare Category:</strong> 
                                    @if ($segment['fare_category'] == 'M')
                                    Economy Class (M)
                                @elseif ($segment['fare_category'] == 'W')
                                    Premium Economy Class (W)
                                @elseif ($segment['fare_category'] == 'C')
                                    Business Class (C)
                                @elseif ($segment['fare_category'] == 'F')
                                    First Class (F)
                                @else
                                    Unknown Class ( {{ $segment['fare_category']}})
                                @endif
                                </p>
                                @php
                                $departureDateTime = \Carbon\Carbon::parse($segment['local_departure']);
                                $arrivalDateTime = \Carbon\Carbon::parse($segment['local_arrival']);
                                $travelTime = $arrivalDateTime->diffForHumans($departureDateTime, [
                                    'parts' => 2,
                                    'short' => true,
                                ]);
                            @endphp
                                <p><strong>Departure:</strong> {{ $departureDateTime }} ({{ $segment['cityFrom'] }})</p>
                                @if (isset($segment['local_arrival']) && isset($segment['local_departure']))
                                <p><strong>Travel Time:</strong> {{ $travelTime }}</p>
                            @endif
                                <p><strong>Arrival:</strong> {{ $travelTime }} ({{ $segment['cityTo'] }})</p>                              
                                <p><strong>Connection:</strong> {{ $segment['vi_connection'] ? 'Yes' : 'No' }}</p>
                                <p><strong>Bags Recheck Required:</strong> {{ $segment['bags_recheck_required'] ? 'Yes' : 'No' }}</p>
                                <!-- Add more details as needed -->
                        </div>
                        @endforeach
                        
                    </div>
                </div>
            </div>
        @endforeach
        
        
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js (required for Bootstrap dropdowns, modals, etc.) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        // Function to format duration in hours, minutes, and seconds
        function formatDuration(totalSeconds) {
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;

            return `${hours} hrs ${minutes} mins ${seconds} secs`;
        }
    </script>
</body>
</html>
