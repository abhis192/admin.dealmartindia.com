<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slot;

class SlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slots = Slot::all();
        return view('admin.slot.index', compact('slots'));
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
            'name' => 'required|string|unique:slots',
            // 'description' => 'nullable|string',
            'from' => 'required|string',
            'to' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'nullable'
        ]);
        $data = $request->all();

        $data['status'] = 1;
        if (!empty($request->status)) {
            $data['status'] = 0;
        }

        Slot::create($data);
        return redirect('/admin/slot')->with('success','Slot created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slot = Slot::findOrFail($id);
        $slots = Slot::all();
        return view('admin.slot.edit', compact('slot','slots'));
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
            'name' => 'required|string',
            // 'description' => 'nullable|string',
            'from' => 'required|string',
            'to' => 'required|string',
            'status' => 'nullable'
        ]);
        $slot = Slot::findOrFail($id);
        $data = $request->all();

        $data['status'] = 1;
        if (!empty($request->status)) {
            $data['status'] = 0;
        }

        $slot->update($data);
        return redirect('/admin/slot')->with('success','Slot updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slot = Slot::findOrFail($id);
        // $slot->cities->each->delete();
        $slot->delete();
        return redirect('/admin/slot')->with('success', 'Slot has been deleted successfully.');
    }

    // Toggle
    // public function toggle(Request $request, $id)
    // {
    //     $slot = Slot::findOrFail($id);
    //     if (!empty($request->status)) {
    //         $slot->update(['status'=>1]);
    //     } else {
    //         $slot->update(['status'=>0]);
    //     }
    //     return redirect('/admin/slot')->with('success', 'Slot has been upadted successfully.');
    // }
}
