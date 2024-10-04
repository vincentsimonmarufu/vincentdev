<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use App\Http\Controllers\ExchangeRateController;
use App\Models\Invoices;
use App\Models\BookingInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Apartment;
use App\Models\Bus;
use App\Models\Vehicle;
use App\Models\Shuttle;
use App\Models\Booking;
use App\Traits\ExchangeRateTrait;

class InvoicesController extends Controller
{
    use ExchangeRateTrait;
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $invoices = BookingInvoice::orderBy('id', 'Desc')->get();
        } else {
            $invoices = BookingInvoice::where('user_id', Auth::user()->id)
                ->orderBy('id', 'Desc')->get();
        }
        return view('payments.invoices', compact('invoices'));
    }
    public function requestpayment()
    {
        $invoices = Invoices::orderBy('id', 'Desc')->get();
        return view('payments.requestpayments', compact('invoices'));
    }
    public function show($id)
    {
        $invoice = Invoices::find($id);
        // route('invoices.show', ['id' => $invoice->id])
        $link =  route('invoices.show',  $invoice->id);

        /* $shareComponent = \Share::page($link,'Kindly pay for me'
        )
        ->whatsapp()
        ->facebook()
        ->twitter()
        ->linkedin()
        ->telegram(); */
        $shareComponent = "";
        return view('payments.initiate', compact('invoice', 'shareComponent'));
    }
    public function showbookinginvoice($id)
    {
        $booking = Booking::findOrFail($id);
        $shareComponent = "";

        $apartmnts = Apartment::with('bookings')
            ->where('user_id', Auth::id())
            ->get();

        $buses = Bus::with('bookings')
            ->where('user_id', Auth::id())
            ->get();

        $vehicles = Vehicle::with('bookings')
            ->where('user_id', Auth::id())
            ->get();
        $shuttles = Shuttle::with('bookings')
            ->where('user_id', Auth::id())
            ->get();

        $exchangerate = $this->getExchangeRate();
        return view('payments.paybookinginvoice', compact('exchangerate', 'booking', 'vehicles', 'apartmnts', 'buses', 'shuttles', 'shareComponent'));
    }
    public function create()
    {

        return view('payments.createinvoice');
    }
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
            $path = $request->file('file')->storeAs('public/invoices', $file_name_to_store);
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


        return redirect()->back()
            ->with('status', 'invoice uploaded successfully :  '  . $request->name);
    }
    public function download($id)
    {
        $invoice = Invoices::find($id);

        return response()->download(storage_path("app/public/public/invoices/" . $invoice->file_path, "Invoice"));
    }
}
