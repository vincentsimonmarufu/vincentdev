@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
       
        <div class="card-header">
            <h3>All Booking Invoices or Quotations</h3>
        </div>
        <div class="card-body">
                <div class="table-responsive">
                    <table id="dtBasicExample" data-order='[[ 0, "desc" ]]' class="table table-bordered table-hover">
                        <thead>
                            <th>Date</th>
                            <th>Booking Reference</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        
                        <tbody>
                        @foreach ($invoices as $payment)
                            <tr>
                                <td>{{ $payment->created_at }}</td>
                                <td>{{ $payment->booking->reference }}</td>
                                <td>{{ $payment->amount }}</td>
                                <td>{{ $payment->status }}</td>
                                <td>
                                <a class="btn btn-info btn-sm" href="{{ route('bookings.show', $payment->booking_id) }}">View</a>
                                @if($payment->booking->status == 'Not Paid' || $payment->booking->status == 'Not Paid')
                                        <a class="btn btn-success btn-sm" href="{{ route('invoices.booking', $payment->booking->id) }}">Pay now</a>
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