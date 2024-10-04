@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Bus Stops/ Locations</h3>           
        </div>
        <div class="card-footer">
            <a class="btn btn-dark" href="{{ route('buses.addbusstop') }}">Add Bus stop</a>
        </div>


        <!-- Modal for displaying bus location details -->
        <div class="modal fade" id="buslocationModal" tabindex="-1" aria-labelledby="buslocationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="buslocationModalLabel">Bus Location Detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div><!-- Modal for displaying bus location details -->

<!-- Edit Bus Stop Modal -->
<div class="modal fade" id="editBusStopModal" tabindex="-1" role="dialog" aria-labelledby="editBusStopModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBusStopModalLabel">Edit Bus Stop</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateBusStopForm">
                    @csrf
                    <input type="hidden" id="buslocationId" name="buslocationId">
                    <div class="form-group">
                        <label for="buslocation">Bus Location</label>
                        <input type="text" class="form-control" id="buslocation" name="buslocation" required>
                    </div>                    
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

           
        <div class="card-body">
            <div class="table-reponsive">
                <table id="example2" data-order='[[ 0, "asc" ]]' class="table table-striped table-bordered table-hover">
                    <thead>
                        <th>Location(s)</th>                       
                    </thead>
                    <tbody>
                        @foreach ($busloc as $loc)
                        <tr>
                            <!-- <td>{{$loc->id}}</td>  -->
                            <td style="width: 70%; text-align:center">{{$loc->buslocation}}</td>                            
                            <td>
                                <a href="javascript:void(0);" class="btn btn-info btn-sm show_buslocation" data-id="{{$loc->id}}">View</a>
                                <a href="javascript:void(0);" class="btn btn-success btn-sm mt-1 edit_buslocation" data-id="{{$loc->id}}">Edit</a>
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm mt-1 drop_buslocation" data-id="{{$loc->id}}">Delete</a>                                                                                                                                      
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination svg offset-md-3">                     
                    {{ $busloc->onEachSide(1)->links('custom-pagination') }}                            
              </div>
            </div>

        </div>

    </div>
</div>

@section('scripts')

<!-- show bus location action  -->
<script>
    $(document).ready(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        
        // start show bus location operation          
        $('.show_buslocation').click(function() {
            var buslocationId = $(this).data('id');            
            //alert('Bus Location ID: ' + buslocationId);
            var targeturl = "{{ route('buses.showbusstop', ['id' => '__ID__']) }}".replace('__ID__', buslocationId);            
            $.ajax({
                url: targeturl,                              
                method: 'GET', 
                headers: {
                'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    // Handle success - display bus location details in a modal or div
                    $('#buslocationModal .modal-body').html(response);
                    $('#buslocationModal').modal('show');
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(error);
                    alert('An error occurred while fetching bus location details.');
                }
            });
        });
    // end show bus location operation
    
     // start drop bus location operation          
     $('.drop_buslocation').click(function() {
            var buslocationId = $(this).data('id');            
            //alert('Bus Location ID: ' + buslocationId);
            var targeturl = "{{ route('buses.dropbusstop', ['id' => '__ID__']) }}".replace('__ID__', buslocationId);            
            $.ajax({
                url: targeturl,                              
                method: 'GET', 
                headers: {
                'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {            
                  if (response.success) {  
                   alert(response.success);  
                   window.location.href = "{{ route('buses.busstops') }}";               
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
    // end drop bus location operation


// Handle edit button click
$('.edit_buslocation').click(function() {
    var buslocationId = $(this).data('id');
    var editUrl = "{{ route('buses.editbusstop', ['id' => '__ID__']) }}".replace('__ID__', buslocationId);
    
    $.ajax({
        url: editUrl,
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {            
            $('#editBusStopModal #buslocation').val(response.buslocation);           
            $('#editBusStopModal #buslocationId').val(buslocationId);
            $('#editBusStopModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error(error);
            alert('An error occurred while fetching bus location details.');
        }
    });
});

// Handle form submission for updating bus stop
$('#updateBusStopForm').submit(function(event) {
    event.preventDefault();
    
    var buslocationId = $('#editBusStopModal #buslocationId').val();
    var updateUrl = "{{ route('buses.updatebusstop', ['id' => '__ID__']) }}".replace('__ID__', buslocationId);
    var formData = $(this).serialize();

    $.ajax({
        url: updateUrl,
        method: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {
            if (response.success) {
                alert(response.success);
                $('#editBusStopModal').modal('hide');              
                location.reload(); 
            } else {
                alert('Update operation failed: ' + response.error);
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
            alert('An error occurred while updating bus location details.');
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