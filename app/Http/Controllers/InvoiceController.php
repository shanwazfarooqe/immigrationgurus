<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Lead;
use App\PaymentRecord;
use App\Service;
use App\User;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($lead)
    {
        $lead = base64_decode($lead);
        $invoices = Invoice::where('lead_id',$lead)->latest('id')->get();
        return view('invoices',compact('invoices','lead'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($lead_id)
    {
        $lead_id = base64_decode($lead_id);
        $lead = Lead::find($lead_id);
        return view('create-invoice',compact('lead'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Invoice;
        $data->user_id = auth()->id();
        $data->lead_id = $request->lead_id;
        $data->invoice_no = $request->invoice_no;
        $data->po_so_no = $request->po_so_no;
        $data->invoice_date = $request->invoice_date;
        $data->payment_duedate = $request->payment_duedate;
        $data->content = $request->content;
        $data->save();

        $name = $request->name;
        $description = $request->description;
        $hrs = $request->hrs;
        $rate = $request->rate;

        if(!empty($name))
        {
            foreach ($name as $key => $value) {
                $data2arr = array(
                    'invoice_id' => $data->id,
                    'name' => $name[$key],
                    'description' => $description[$key],
                    'hrs' => $hrs[$key],
                    'rate' => $rate[$key]
                );
                Service::create($data2arr);
            }
        }

        return redirect()->route('invoices.index',base64_encode($request->lead_id))->with('status', 'Invoice has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($lead, $id)
    {
        $lead = Lead::find(base64_decode($lead));
        $company = User::find($this->getCompany());
        $invoice = Invoice::find(base64_decode($id));
        return view('show-invoice',compact('invoice','lead','company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function record(Request $request)
    {
        PaymentRecord::create($request->except('_token'));
        return redirect()->back()->with('status', 'Payment record has been created');
    }
}
