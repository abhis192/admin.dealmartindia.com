<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\AttributeValues;
use Storage;
use File;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributes = Attribute::all();
        return view('admin.attribute.index', compact('attributes'));
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
            'name' => 'required|string',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'nullable'
        ]);
        $data = $request->all();

        $data['status'] = 0;
        if (!empty($request->status)) {
            $data['status'] = 1;
        }

        Attribute::create($data);
        return redirect('/admin/product/attribute')->with('success','Attribute created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $attribute = Attribute::findOrFail($id);
        return view('admin.attribute.show', compact('attribute'));
    }

    public function valueStore(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'value' => 'required',
        ]);
        $data = $request->all();
        $data['attribute_id'] = $id;

        if($request->hasFile('value')){
            $fileImage = $request->file('value');
            $fileImageName = rand() . '.' . $fileImage->getClientOriginalName();
            $fileImage->storeAs('public/attribute/',$fileImageName);
            $data['value'] = $fileImageName;
        }

        AttributeValues::create($data);
        return redirect('/admin/product/attribute/show/'.$id)->with('success','Attribute Values created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attribute = Attribute::findOrFail($id);
        $attributes = Attribute::all();
        return view('admin.attribute.edit', compact('attribute','attributes'));
    }

    public function showEdit($id)
    {
        $attributeValues = AttributeValues::findOrFail($id);
        $attribute = Attribute::findOrFail($attributeValues->attribute_id);
        return view('admin.attribute.showEdit', compact('attributeValues','attribute'));
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
            'type' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'nullable'
        ]);
        $attribute = Attribute::findOrFail($id);
        $data = $request->all();

        $data['status'] = 0;
        if (!empty($request->status)) {
            $data['status'] = 1;
        }

        $attribute->update($data);
        return redirect('/admin/product/attribute')->with('success','Attribute updated successfully.');
    }

    public function showUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'value' => 'required|string'
        ]);
        $attributeValue = AttributeValues::findOrFail($id);
        $data = $request->all();

        $attributeValue->update($data);
        return redirect('/admin/product/attribute/show/'.$id.'/edit')->with('success','Attribute updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->attributeValues->each->delete();
        $attribute->delete();
        return redirect('/admin/product/attribute')->with('success', 'Attribute has been deleted successfully.');
    }

    public function showDestroy($id)
    {
        $attributeValue = AttributeValues::findOrFail($id);
        $attendeeId = $attributeValue->attribute_id;
        $attributeValue->delete();
        return redirect('/admin/product/attribute/show/'.$attendeeId)->with('success','Attribute value deleted successfully.');
    }

    // Acttive
    public function toggle(Request $request, $id)
    {
        $attribute = Attribute::findOrFail($id);
        if (!empty($request->status)) {
            $attribute->update(['status'=>1]);
        } else {
            $attribute->update(['status'=>0]);
        }
        return redirect('/admin/product/attribute')->with('success', 'Attribute has been upadted successfully.');
    }
}
