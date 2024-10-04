<!-- In your Blade template file -->
<style>    
    .search-form {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #cccccc;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        flex: 1;
        margin-right: 10px;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        transition: border-color 0.3s ease-in-out;
        height: calc(2.0em + 0.75rem + 2px) !important;
    }

    .form-control:focus {
        border-color: #03a84e;
        outline: none;
    }

    .btn-primary {
        margin-top: 15px;
        padding: 9px 20px;
        border: none;
        border-radius: 0px;
        background-color: #0a1c1f;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #03a84e;
    }

    .search-icon {
        display: flex;
        align-items: center;
    }

    .search-icon i {
        margin-right: 5px;
    }
</style>
<style>
        /* Custom height for Select2 container */
        .select2-container .select2-selection--single {
            height: 44px !important; /* Set the height to 45px */
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 44px !important; /* Center the text vertically */
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 44px !important; /* Adjust the arrow height */
        }
    </style>

<form action="{{ route('bussearch') }}" method="GET" class="search-form">    
    <div class="form-group">
        <label for="start_location">Pickup Location</label>
        <select id="mySelect1" name="start_location" class="pickup">
            @foreach($locations as $location)
                <option value="{{ $location }}">{{ $location }}</option>
            @endforeach 
        </select>
    </div>

    <div class="form-group">
        <label for="destination_location">Destination</label>
        <select id="mySelect2" name="end_locationn" class="destination">
            @foreach($locations as $location)
                <option value="{{ $location }}">{{ $location }}</option>
            @endforeach  
        </select>
    </div>
    <?php               
        $date = date('Y-m-d');
        $maxDate = date('Y-m-d', strtotime('+1 year'));
    ?>

    <div class="form-group">
        <label for="travel_date">Travel Date</label>
        <input type="date" style="border-radius: 4px !important;" class="form-control" id="travel_date" name="travel_date" min="{{$date}}" max="{{$maxDate}}" required>
    </div>

    <div class="form-group">
        <label for="return_date">Return Date (Optional)</label>
        <input type="date" style="border-radius: 4px !important;" class="form-control" id="return_date" name="return_date" min="{{$date}}" max="{{$maxDate}}">
    </div>

    <button type="submit" class="btn btn-primary">
        <span class="search-icon"><i class="fas fa-search"></i> Search</span>
    </button>
</form>

