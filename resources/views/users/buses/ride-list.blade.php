@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Rides Details</h3>          
        </div>
        <div class="card-footer">
            <a class="btn btn-dark" href="{{ route('buses.busrideform') }}">Create</a>
        </div>

         <!-- Modal for displaying bus ride details -->
         <div class="modal fade" id="ridedetailModal" tabindex="-1" aria-labelledby="rideDetailModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rideDetailModalLabel">Ride detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div><!-- Modal for displaying bus ride details -->

        

           
        <div class="card-body">
            <div class="table-reponsive">
                <table id="example2" data-order='[[ 0, "asc" ]]' class="table table-striped table-bordered table-hover">
                    <thead>
                        <th>Routes</th>
                        <th>Bus</th>                         
                        <th>Departure time</th>    
                        <th>Departure date</th>                   
                        <th>Action</th>
                    </thead>
                    <tbody>
                    @foreach ($rides as $ride) 
                    <tr>                                                    
                        <td>                            
                            @php                            
                                $routeObj = \App\Models\Route::findOrFail($ride->route_id);
                            @endphp
                            {{$routeObj->name}}
                        </td>                                                         
                        <td>                            
                            @php                            
                                $busObj = \App\Models\Bus::findOrFail($ride->bus_id);
                            @endphp
                            {{$busObj->name}}                                                       
                        </td>                                                     
                        <td>
                            {{$ride->departure_time}}                                                          
                        </td> 
                        <td>   
                            {{$ride->ride_date}}                                                    
                        </td> 
                        <td> 
                            <a href="javascript:void(0);" class="btn btn-info btn-sm show_ridedetail" data-id="{{$ride->id}}">View</a>
                            <a href="javascript:void(0);" class="btn btn-success btn-sm mt-1 edit_ridedetail" data-id="{{$ride->id}}">Edit</a>                              
                            <a href="javascript:void(0);" class="btn btn-danger btn-sm mt-1 drop_ridedetail" data-id="{{$ride->id}}">Delete</a>
                        <td>                                                 
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
    $('.show_ridedetail').click(function() {
            var buslocationId = $(this).data('id');            
            //alert('buslocationId: ' + buslocationId);
            var targeturl = "{{ route('buses.showridedetail', ['id' => '__ID__']) }}".replace('__ID__', buslocationId);            
            $.ajax({
                url: targeturl,                              
                method: 'GET', 
                headers: {
                'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {                    
                    $('#ridedetailModal .modal-body').html(response);
                    $('#ridedetailModal').modal('show');
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
    $('.drop_ridedetail').click(function() {
            var routeDetailId = $(this).data('id');            
            //alert('routeDetailId: ' + routeDetailId);
            var targeturl = "{{ route('buses.dropridedetail', ['id' => '__ID__']) }}".replace('__ID__', routeDetailId);            
            $.ajax({
                url: targeturl,                              
                method: 'GET', 
                headers: {
                'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {            
                  if (response.success) {  
                   alert(response.success);  
                   window.location.href = "{{ route('buses.ridelist') }}";               
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

    $('#addRideForm').submit(function(e){      
        e.preventDefault(); // Prevent form submission and page refresh       
        // Serialize form data
        var formData = $(this).serialize();
        // Get CSRF token value
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        
        // Send AJAX request
        $.ajax({
            url: '{{ route("buses.savebusride") }}', 
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
            },
            data: formData,
            dataType:'json',
            success: function(response){
                // Handle success response              
                $('.alert').remove(); // Remove existing alerts
                $('#addRideForm').prepend('<div class="alert alert-success">Added successfully</div>');

                // Clear form fields
                // $('#viaCities').val('');
                // $('#stepCost').val('');
                // $('#date').val('{{ date("Y-m-d") }}');
                // $('#time').val('{{ date("H:i") }}');

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
