<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryOption;
use App\Models\Slot;

class DeliveryOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveryoptions = DeliveryOption::all();
        $slots = Slot::all();
        return view('admin.deliveryoption.index', compact('deliveryoptions','slots'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([


            // 'name' => 'required|string|unique:slots',
            // // 'description' => 'nullable|string',
            // 'from' => 'required|string',
            // 'to' => 'required|string',
            // 'status' => 'nullable'
        ]);

        // $deliveryoptions=new DeliveryOption;
        // $get_time_slot_inside = implode(", ", $request->time_slot_inside);
        // $deliveryoptions->time_slot_inside = $get_time_slot_inside;



        $data = $request->all();

        $time_slot_inside=$data['time_slot_inside'];
        $data['time_slot_inside']=implode(',',$time_slot_inside);

        $data['status'] = 0;
        if (!empty($request->status)) {
            $data['status'] = 1;
        }

        $data['cod'] = 0;
        if (!empty($request->status)) {
            $data['cod'] = 1;
        }

        DeliveryOption::create($data);
        return redirect('/admin/deliveryoption')->with('success','DeliveryOption created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $deliveryoption = DeliveryOption::findOrFail($id);
        $deliveryoptions = DeliveryOption::all();
        $slots = Slot::all();
        return view('admin.deliveryoption.edit', compact('deliveryoption','deliveryoptions','slots'));
    }


    //view section
    public function view($id)
    {
        $deliveryoption = DeliveryOption::findOrFail($id);
        $deliveryoptions = DeliveryOption::all();
        $slots = Slot::all();
        return view('admin.deliveryoption.view', compact('deliveryoption','deliveryoptions','slots'));
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
            // 'name' => 'required|string',
            // // 'description' => 'nullable|string',
            // 'from' => 'required|string',
            // 'to' => 'required|string',
            // 'status' => 'nullable'
        ]);
        $deliveryoption = DeliveryOption::findOrFail($id);
        $data = $request->all();

        $time_slot_inside=$data['time_slot_inside'];
        $data['time_slot_inside']=implode(',',$time_slot_inside);

        $data['status'] = 0;
        if (!empty($request->status)) {
            $data['status'] = 1;
        }

        $data['cod'] = 0;
        if (!empty($request->cod)) {
            $data['cod'] = 1;
        }

        $deliveryoption->update($data);
        return redirect('/admin/deliveryoption')->with('success','Delivery Option updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deliveryoption = DeliveryOption::findOrFail($id);
        // $slot->cities->each->delete();
        $deliveryoption->delete();
        return redirect('/admin/deliveryoption')->with('success', 'Delivery Option has been deleted successfully.');
    }

    // Toggle
    public function toggle(Request $request, $id)
    {
        $deliveryoption = DeliveryOption::findOrFail($id);
        if (!empty($request->status)) {
            $deliveryoption->update(['status'=>1]);
        } else {
            $deliveryoption->update(['status'=>0]);
        }
        return redirect('/admin/deliveryoption')->with('success', 'Delivery Option has been upadted successfully.');
    }
}
