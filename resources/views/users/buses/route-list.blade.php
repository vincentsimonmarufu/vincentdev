@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Routes Details</h3>            
        </div>
        <div class="card-footer">            
                <a class="btn btn-dark" href="{{ route('buses.addbusroute') }}">Add Bus route</a>                                                
        </div>

        <!-- Modal for displaying bus route details -->
        <div class="modal fade" id="routedetailModal" tabindex="-1" aria-labelledby="routeDetailModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="routeDetailModalLabel">Bus Route Detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div><!-- Modal for displaying bus route details -->

        <div class="card-body">
            <div class="table-reponsive">
                <table id="example2" data-order='[[ 0, "asc" ]]' class="table table-striped table-bordered table-hover">
                    <thead>                                                                 
                        <th>Name</th>
                        <th>Total Locations</th>
                        <th>Travel Duration</th>
                        <th>Price($)</th>                        
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        @foreach ($data as $item) 
                                                    
                        <tr>                                                    
                            <td>
                                @php                            
                                $routeName = \App\Models\Route::findOrFail($item->routeid);
                                @endphp
                                {{$routeName->name}}
                            </td>                                                         
                            <td>
                                @php                              
                                $locidsCount = count(is_string($item['locids']) ? explode(', ', $item['locids']) : $item['locids'])                           
                                @endphp
                                {{ $locidsCount }}
                           </td>                                                     
                            <td>                             
                                @php
                                    $minutesArray = is_string($item['minutes']) ? explode(', ', $item['minutes']) : $item['minutes'];
                                    $minutesSum = array_sum($minutesArray);
                                    $hours = floor($minutesSum / 60);
                                    $minutes = $minutesSum % 60;
                                @endphp
                                <p>{{ $hours }}h : {{ $minutes }}min</p>
                            </td> 
                            <td>  
                                @php                                   
                                    $priceSum = array_sum(is_string($item['prices']) ? explode(', ', $item['prices']) : $item['prices'])                                
                                @endphp
                                {{  $priceSum }}     
                            </td>                                                                                       
                            <td>                               
                                <a href="javascript:void(0);" class="btn btn-info btn-sm show_routedetail" data-id="{{$item->id}}">View</a>
                                <a href="{{-- route('bus.pickuplocation', $route->id) --}}" class="btn btn-success btn-sm">Edit</a>                              
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm mt-1 drop_routedetail" data-id="{{$item->id}}">Delete</a>                            
                            </td>
                        </tr>                      
                        @endforeach  
                                                                                         
                    </tbody>
                </table>
            </div>            
        </div>

    </div>
</div>

@section('scripts')

<script>
$(document).ready(function(){

    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    // start of show bus route detail operation         
    $('.show_routedetail').click(function() {
            var buslocationId = $(this).data('id');            
            //alert('buslocationId: ' + buslocationId);
            var targeturl = "{{ route('buses.showroutedetail', ['id' => '__ID__']) }}".replace('__ID__', buslocationId);            
            $.ajax({
                url: targeturl,                              
                method: 'GET', 
                headers: {
                'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {                    
                    $('#routedetailModal .modal-body').html(response);
                    $('#routedetailModal').modal('show');
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(error);
                    alert('An error occurred while fetching bus route details.');
                }
            });
        });
    // end of show bus route detail operation

    // delete routedetail start
    $('.drop_routedetail').click(function() {
            var routeDetailId = $(this).data('id');            
            //alert('routeDetailId: ' + routeDetailId);
            var targeturl = "{{ route('buses.droproutedetail', ['id' => '__ID__']) }}".replace('__ID__', routeDetailId);            
            $.ajax({
                url: targeturl,                              
                method: 'GET', 
                headers: {
                'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {            
                  if (response.success) {  
                   alert(response.success);  
                   window.location.href = "{{ route('buses.routelist') }}";               
                  } else {
                  alert('Delete operation failed: ' + response.error);
                 }
               },
              error: function(xhr, status, error) {           
               console.error(error);
               alert('An error occurred while performing the delete operation.');
              }
            });
        });
    // delete routedetail end

    $('#addRouteForm').submit(function(e){      
        e.preventDefault(); // Prevent form submission and page refresh       
        // Serialize form data
        var formData = $(this).serialize();
        // Get CSRF token value
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        
        // Send AJAX request
        $.ajax({
            url: '{{ route("buses.savebusroute") }}', 
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
            },
            data: formData,
            dataType:'json',
            success: function(response){
                // Handle success response              
                $('.alert').remove(); // Remove existing alerts
                $('#addRouteForm').prepend('<div class="alert alert-success">Route added successfully</div>');

                // Clear form fields
                $('#viaCities').val('');
                $('#stepCost').val('');
                $('#date').val('{{ date("Y-m-d") }}');
                $('#time').val('{{ date("H:i") }}');

                //Print all responses
                $.each(response, function(key, value){
                    console.log(key + ': ' + value);                  
                });
                //onsole.log(response.message);
            },
            error: function(xhr, status, error){
                // Handle error response
                console.error(xhr.responseText);
            }
        });
    });
});
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dtBasicExample').DataTable();
    });
</script>

@endsection

@endsection

