@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
       
        <div class="card-header">
            <h3>All Payment Requests</h3>
        </div>
        <div class="card-footer">
            <a class="btn btn-success" href="{{route('invoices.create')}}">Create Request Payment</a>
        </div>
        <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" data-order='[[ 0, "desc" ]]' class="table table-striped table-bordered table-hover">
                        <thead>
                            <th>Date</th>
                            <th>Full name</th>
                            <th>Invoice No.</th>
                            <th>Amount (RANDS)</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                    <tbody> 
                         @if ($invoices->count() > 0)
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{$invoice->created_at}}</td>
                                <td>{{$invoice->name .' '.$invoice->surname  }}</br>
                                <small>{{$invoice->email}}</small>
                                </td>
                                <td>{{$invoice->invoice_id}} </td>
                                <td>{{$invoice->amount}}</td>
                                <td>{{$invoice->status}}</td>
                                <td>
                                    @if ( $invoice->status == 'paid')
                                PAID
                                @else
                                <a href="{{ route('invoices.show', ['id' => $invoice->id]) }}" class="btn btn-success btn-sm">
                                    Pay Now </a>
                                @endif
                                   
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