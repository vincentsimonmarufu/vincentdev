@extends('layouts.auth.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Create Request Payment</h3>
            <p class="text-danger">All payment requests to be generated in RANDS</p>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                {!!Form::open(['action'=>'App\Http\Controllers\InvoicesController@store', 'files'=>true])!!}
                @csrf
                <div class="mb-3">
                    {{Form::text('name', null, ['id'=>'name', 'class'=>'form-control', 'required', 'placeholder'=>'Customer Name'])}}
                </div>
                <div class="mb-3">
                    {{Form::text('surname', null, ['id'=>'surname', 'class'=>'form-control', 'required', 'placeholder'=>'Customer Surname'])}}
                </div>
                <div class="mb-3">
                    {{Form::text('email', null, ['id'=>'email', 'class'=>'form-control', 'required', 'placeholder'=>'Customer email'])}}
                </div>
                <div class="mb-3">
                    {{Form::textarea('description', null, ['id'=>'description', 'class'=>'form-control', 'required', 'placeholder'=>'Description', 'rows'=>'3'])}}
                </div>
                <div class="mb-3">
                    {{Form::text('invoice_id', null, ['id'=>'invoice_id', 'class'=>'form-control', 'required', 'placeholder'=>'Invoice / Quotation Number'])}}
                </div>

                <div class="mb-3">
                    {{Form::number('amount', null, ['id'=>'amount', 'class'=>'form-control', 'required', 'placeholder'=>'amount ', 'step'=>'0.01'])}}
                </div>
                <div class="mb-3 row">
                    {{Form::label('file', 'Invoice / Quotation PDF', ['class'=>'col-lg-4 col-form-label'])}}
                    {{Form::file('file', ['multiple', 'accept'=>'.pdf', 'required'])}}
                </div>
                <div class="mb-3 row">
                    {{Form::select('status', ['pending'=>'pending', 'paid'=>'paid'] , null, ['class'=>'form-control', 'required', 'placeholder'=>'select status'])}}
                </div>
                {{Form::submit('Save', ['class'=>'btn btn-success btn-lg'])}}
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>
@endsection