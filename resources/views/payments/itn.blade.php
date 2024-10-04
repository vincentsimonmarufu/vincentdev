@extends('layouts.auth.app')
@section('content')
    <div class="container">
        <div class="card">
           
            <div class="card-header">
                <h3>All ITNS</h3>
            </div>
            <div class="card-body">
                    <div class="table-responsive">
                    <table id="example2" data-order='[[ 0, "desc" ]]' class="table table-striped table-bordered table-hover">
                            <thead>
                                <th>Date</th>
                                <th>Full name</th>
                                <th>Email</th>
                                <th>PF Payment</th>
                                <th>ID</th>
                                <th>Description</th>
                                <th>For</th>
                                <th>Merchant</th>
                                <th>Net</th>
                                <th>Fee</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </thead>
                        <tbody> 
                             @if ($itns->count() > 0)
                            @foreach ($itns as $itn)
                                <tr>
                                    <td>{{$itn->created_at}}</td>
                                    <td>{{$itn->name .' '.$itn->surname  }}</td>
                                    <td>{{$itn->email}}</td>
                                    <td>{{$itn->pf_payment_id}} </td>
                                    <td>{{$itn->item}}</td>
                                    <td>{{$itn->description}}</td>
                                    <td>{{$itn->for}}</td>
                                    <td>{{$itn->merchant_id}}</td>
                                    <td>{{$itn->net}}</td>
                                    <td>{{$itn->fee}}</td>
                                    <td>{{$itn->amount}}</td>
                                    <td>{{$itn->status}}</td>
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