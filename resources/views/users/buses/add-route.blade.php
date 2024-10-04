@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Add Route Detail</h3>            
        </div>
        <form action="{{ action('App\Http\Controllers\BusController@saveBusRoute') }}" method="POST" enctype="multipart/form-data">
            <div class="card-body"> 
                @csrf                      
                <div class="form-group">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Route Name</label>                   
                        <input type="text" id="route-name" name="name" class="form-control" placeholder="Enter routes names separated by commas" required>
                    </div> 
                </div>
                <div id="routes-container">                    
                </div>
                <button type="submit" class="btn btn-lg btn-primary btn-block mt-2">
                    Add
                </button>                      
            </div>
        </form> 
    </div>
</div>

@section('scripts')
    <script>
        $(document).ready(function() {
            // Get locations data from a variable passed from the controller
            var locations = @json($locations);

            // Function to add a new route input row
            function addRoute() {
                var options = '<option value="">--select location--</option>';
                locations.forEach(function(location) {
                    options += '<option value="' + location.id + '">' + location.buslocation + '</option>';
                });

                var newRoute = `
                    <div class="form-group add-route-container">
                        <select name="locids[]" class="location-select form-control" style="width: calc(33% - 20px); display: inline-block;">
                            ${options}
                        </select>
                        <input type="number" name="minutes[]" class="minutes-input form-control" placeholder="Minutes" style="width: calc(33% - 20px); display: inline-block;">
                        <input type="number" name="prices[]" class="price-input form-control" placeholder="Price" style="width: calc(33% - 20px); display: inline-block;">
                        <span class="remove-route text-danger ml-2" style="cursor: pointer;"><i class="fas fa-minus"></i></span>
                        <span class="add-route text-success ml-2" style="cursor: pointer;"><i class="fas fa-plus"></i></span>
                    </div>`;
                $('#routes-container').append(newRoute);
            }

            // Add new route row on clicking the add button
            $(document).on('click', '.add-route', function() {
                addRoute();
            });

            // Remove route row on clicking the remove button
            $(document).on('click', '.remove-route', function() { 
                $(this).closest('.add-route-container').remove();
            });

            // Add initial route row
            addRoute();
        });
    </script>
@endsection
@endsection

