@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Create Bus stop</h3>
        </div>
        <div class="card-body">       
            <div class="col-lg-12">
                {!!Form::open(['action'=>['App\Http\Controllers\BusController@saveBusStop'], 'files'=>true])!!}
                <div class="mb-3">
                    <label class="form-label">Bus stop/ location Name</label>
                    {{Form::text('buslocation', null, ['class'=>'form-control', 'required', 'placeholder'=>'Enter Bus stop name'])}}
                </div>                
                {{Form::submit('Create', ['class'=>'btn btn-success btn-lg'])}}
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>
@endsection