@extends('layouts.auth.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>All Booking Commisions</h3>
                <div class="alert alert-warning" role="alert" >
                    We charge 10% for every approved vehicle, apartments, airport shuttle, buses booking
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dtBasicExample" data-order='[[ 0, "desc" ]]' class="table table-bordered table-hover">
                        <thead>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Reference</th>
                            <th>Commission</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        
                        <tbody>
                        @foreach ($payments as $payment)
                            <tr>
                                <td>{{ $payment->created_at }}</td>
                                <td>{{ $payment->user->name }} {{ $payment->user->surname }}</td>
                               <td> <small>{{ $payment->user->email }}</br>
                                {{ $payment->user->phone }}</small>
                                </td>
                                <td>{{ $payment->booking->reference }}</td>
                                <td>{{ $payment->amount }}</td>
                                <td>{{ $payment->status }}</td>
                                <td>
                                <a class="btn btn-info btn-sm" href="{{ route('bookings.show', $payment->booking_id) }}">View</a>
                                     @if(Auth::user()->role == 'admin')
                                    <a href="{{ route('payments.status', $payment->id) }}" class="btn btn-success btn-sm">Mark as Paid</a>
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