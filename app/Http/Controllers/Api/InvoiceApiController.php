<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoicesResource;
use Illuminate\Http\Request;
use App\Models\Invoices;

class InvoiceApiController extends ResponseController
{
    // invoice list
    public function index()
    {
        try {
            $invoices = Invoices::orderBy('created_at', 'DESC')->get();
            $invoiceResource = InvoicesResource::collection($invoices);
            return $this->sendResponse($invoiceResource, 'Invoices');
        } catch (\Exception $th) {
            return $this->sendError($th->getMessage());
        }
    }


    // create invoice API
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required',
            'description' => 'required',
            'amount' => 'required',
            'invoice_id' => 'required',
            'file' => 'required',
            'status' => 'required',
        ]);

        if ($request->hasFile('file')) {

            $full_file_name = $request->file('file')->getClientOriginalName();
            $name = pathinfo($full_file_name, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $file_name_to_store = $name . '_' . time() . '.' . $extension;
            $request->file('file')->storeAs('public/invoices/', $file_name_to_store);
        } else {
            $file_name_to_store = 'file.pdf';
        }

        $content = new Invoices();
        $content->name = $request->name;
        $content->surname = $request->surname;
        $content->email = $request->email;
        $content->invoice_id = $request->invoice_id;
        $content->description = $request->description;
        $content->amount = $request->amount;
        $content->status = $request->status;
        $content->file_path = $file_name_to_store;
        $content->save();

        if ($content) {
            return $this->sendResponse('', 'Created');
        } else {
            return $this->sendError('Not created');
        }
    }

    // show invoice detail
    public function show($id)
    {
        try {
            $invoiceDetail = Invoices::findOrFail($id);
            return $this->sendResponse(new InvoicesResource($invoiceDetail), 'Invoice Detail');
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage());
        }
    }
}
