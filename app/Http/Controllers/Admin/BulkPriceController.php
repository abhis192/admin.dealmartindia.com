<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PricingRule;
use App\Models\Product;
use App\Models\City;

class BulkPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prices = PricingRule::all();
        $cities = City::all();
        return view('admin.bulk-prices.index', compact('prices','cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        $cities = City::all();
        return view('admin.bulk-prices.create', compact('products','cities'));
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
            'product_id' => 'required|integer|exists:products,id|unique:pricing_rules,product_id',
            'status' => 'nullable', // Assuming 'status' is a boolean field
        ]);

        $pricingRules = $request->get('pricing_rules');

        foreach ($pricingRules as $key => $val) {
            if ($val['discount_type'] == 'Flat') {
                $val['final_price'] = $val['product_price'] - $val['discount_value'];
            } else {
                $get_value = $val['discount_value'] * $val['product_price'] / 100;
                $val['final_price'] = $val['product_price'] - $get_value;
            }
            $pricingRules[$key] = $val;
        }
        $pricingRulesJson = json_encode($pricingRules);

        // Create a new PricingRule record with the JSON data
        $city_id = implode(", ", $request->city_id);
        PricingRule::create([
            'product_id' => $request->get('product_id'),
            'city_id' =>   $city_id,
            'pricing_rules' => $pricingRulesJson,
            'status' => $request->has('status') ? 1 : 0, // Set status based on checkbox
        ]);



        return redirect('/admin/bulk-prices')->with('success', 'Bulk pricing rules added successfully');
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
        $price = PricingRule::findOrFail($id);
        $products = Product::all();
        $cities = City::all();
        return view('admin.bulk-prices.edit', compact('price','products','cities'));
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
            'product_id' => 'required|integer|exists:products,id|unique:pricing_rules,product_id,' . $id, // Exclude the current record from the unique check
            'pricing_rules' => 'required|array', // Ensure that the pricing rules are provided as an array
            // 'pricing_rules.*.min_quantity' => 'required|integer',
            // 'pricing_rules.*.price' => 'required|numeric',
            'status' => 'nullable', // Assuming 'status' is a boolean field
        ]);

        // Retrieve the pricing rules from the request and convert to JSON
        $pricingRules = $request->get('pricing_rules');

        foreach ($pricingRules as $key => $val) {
            if ($val['discount_type'] == 'Flat') {
                $val['final_price'] = $val['product_price'] - $val['discount_value'];
            } else {
                $get_value = $val['discount_value'] * $val['product_price'] / 100;
                $val['final_price'] = $val['product_price'] - $get_value;
            }
            $pricingRules[$key] = $val;
        }
        $pricingRulesJson = json_encode($pricingRules);

        // Update the existing PricingRule record with the new data

        $city_id = implode(", ", $request->city_id);
        $pricingRule = PricingRule::findOrFail($id);
        $pricingRule->product_id = $request->get('product_id');
        $pricingRule->city_id = $city_id;
        $pricingRule->pricing_rules = $pricingRulesJson;
        $pricingRule->status = $request->has('status') ? 1 : 0; // Set status based on checkbox
        $pricingRule->save();

        return redirect('/admin/bulk-prices')->with('success', 'Bulk pricing rules updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pricingRule = PricingRule::findOrFail($id);
        $pricingRule->delete();
        return redirect('/admin/bulk-prices')->with('success', 'Bulk pricing rule deleted successfully.');
    }

    // Acttive
    public function toggle(Request $request, $id)
    {
        $price = PricingRule::findOrFail($id);
        if (!empty($request->status)) {
            $price->update(['status'=>1]);
        } else {
            $price->update(['status'=>0]);
        }
        return redirect('/admin/bulk-prices')->with('success', 'Status has been upadted successfully.');
    }
}
