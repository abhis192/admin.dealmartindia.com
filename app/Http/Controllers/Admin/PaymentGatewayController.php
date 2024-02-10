<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;

class PaymentGatewayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gateways = PaymentGateway::all();
        $razorpay = PaymentGateway::whereName('razorpay')->first();
        return view('admin.gateway.index', compact('gateways','razorpay'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.gateway.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gateway = PaymentGateway::findOrFail($id);
        return view('admin.gateway.edit', compact('gateway'));
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
        $request->validate([
            'business_name' => 'required|string',
            'key' => 'required|string',
            'secret' => 'required|string',
            'status' => 'nullable',
        ]);
        
        $gateway = PaymentGateway::findOrFail($id);
        $data = $request->all();

        $data['status'] = 0;
        if (!empty($request->status)) {
            $data['status'] = 1;
        }

        $gateway->update($data);
        return redirect('/admin/gateways')->with('success','Payment gateway updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gateway = PaymentGateway::findOrFail($id);
        $gateway->delete();
    }
}
