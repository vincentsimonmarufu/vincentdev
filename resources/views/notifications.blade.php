@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h1>All Notifications</h1>
         
                <a href="{{ route('read_all') }}" class="btn btn-success" role="button">Read
                    All ({{ count(auth()->user()->unreadNotifications) }} ) </a>
        </div>
        @if ($errors->any())
        <div class="alert alert-danger">
          <strong>Error!</strong>
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{$error}}</li>
            @endforeach
          </ul>
            </div>
          @endif
          @if ($message = Session::get('success'))
          <div class="alert alert-success alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <strong>{{ $message }}</strong>
          </div>
          @endif
        @php
        $notifications = auth()->user()->notifications;
    @endphp
        <div class="card-body col-12">
                <div class="table-responsive">
                    <table id="dtBasicExample" data-order='[[ 0, "desc" ]]' class="table table-bordered table-striped table-hover">
                        <thead>
                                <th>Date</th>
                                <th>Notification</th>
                                <th>status</th>
                                <th >Action</th>
                           
                        </thead>
                        <tbody>
                            @if( count($notifications) > 0)
                            @foreach ($notifications as $notification)
                            <tr >
                                <td @if ($notification->unread())
                                    class="alert alert-success" 
                                      @endif>{{ $notification->created_at }}</td>
                                <td @if ($notification->unread())
                                    class="alert alert-success" 
                                      @endif> {{ $notification->data['message'] }}</td>
                               
                                    <td>@if ($notification->unread())
                                        <span class="alert alert-success" >Unread</span>
                                        @else
                                        Read
                                          @endif
                                        </td>
                                  <td>  
                                    <a href="{{ route('notification_read', ['id' => $notification->id]) }}"
                                         class="btn 
                                         @if ($notification->unread())
                                   btn-success" 
                                    @else
                                    btn-primary 
                                      @endif
                                        
                                         btn-md"
                                         >View</a>
                                </td>
                            </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            
        </div>
    </div>
</div>
    
@section('scripts')
 <script type="text/javascript">
$(document).ready(function () {
$('#dtBasicExample').DataTable();
});
    </script>
@endsection
@endsection