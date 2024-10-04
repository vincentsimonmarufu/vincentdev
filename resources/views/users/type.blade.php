@extends('layouts.auth.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>{{$type}} owners</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" data-order='[[ 0, "asc" ]]' class="table table-striped table-bordered table-hover">
                        <thead>
                            <th>Surname</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->surname }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <a href="{{ route('users.verify', $user->id) }}" class="btn btn-success">Verify</a>
                                    @if ($type == 'property')
                                        <a href="{{route('users.apartments.index', $user->id)}}" class="btn btn-info">View</a>
                                    @elseif ($type == 'vehicle')
                                        <a href="{{route('users.vehicles.index', $user->id)}}" class="btn btn-info">View</a>
                                    @endif
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
    <script type="text/javascript">
   $(document).ready(function () {
   $('#dtBasicExample').DataTable();
   });
       </script>
   @endsection
@endsection