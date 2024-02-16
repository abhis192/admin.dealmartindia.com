<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductGallery;
use App\Models\ProductAttribute;
use App\Models\ConfigRefund;
use App\Models\Category;
use App\Models\ProductCategory;
use App\Models\ProductTag;
use App\Models\Type;
// use App\Models\Brand;
use App\Models\Attribute;
use Exception;
use Auth;
use File;

class ProductController extends Controller
{
    public function getProductPrices($productId)
    {
        // Fetch the product by ID
        $product = Product::findOrFail($productId);

        // Get the prices associated with the product
        $prices = $product->prices;

        return response()->json(['prices' => $prices]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::whereStatus(1)->whereNull('parent_category_id')->get();
        // $brands = Brand::whereStatus(1)->get();
        // $attributes = Attribute::whereStatus(1)->get();
        $types = Type::whereStatus(1)->get();
        $tags = ProductTag::all();
        return view('admin.product.create', compact('categories','types','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|min:3|max:255',
                'slug' => 'required|string|min:2|max:255|unique:products',
                'sku' => 'required|string|max:255|unique:products',
                // 'category_id' => 'nullable|string',
                // 'brand_id' => 'nullable|integer',
                'description' => 'nullable|string',
                'meta_title' => 'nullable|string',
                'meta_keywords' => 'nullable|string',
                'meta_description' => 'nullable|string',
                'published'=>'nullable',
                'featured'=>'nullable',
                'cash_on_delivery'=>'nullable',
                'is_refundable' => 'nullable',
                // 'regular_price'=>'required',
                'sale_price'=>'nullable',
                'shipping_days'=>'nullable|integer',
                'in_stock' => 'nullable',
                'addon' => 'nullable',
                'stock_warning' => 'nullable|integer',
                'image' => 'nullable|image|mimes:jpeg,png,jpg',
            ]);

            $data = $request->all();

            $category_id=$data['category_id'];
            $data['category_id']=implode(',',$category_id);

            $data['user_id'] = Auth::user()->id;

            if($request->hasFile('image')){
                $fileImage = $request->file('image');
                $fileImageName = rand() . '.' . $fileImage->getClientOriginalName();
                $fileImage->storeAs('public/product/',$fileImageName);
                $data['image'] = $fileImageName;
            }

            $data['published'] = 0;
            if (!empty($request->published)) {
                $data['published'] = 1;
            }

            $data['featured'] = 0;
            if (!empty($request->featured)) {
                $data['featured'] = 1;
            }

            $data['in_stock'] = 0;
            if (!empty($request->in_stock)) {
                $data['in_stock'] = 1;
            }

            $data['is_refundable'] = 0;
            if (!empty($request->is_refundable)) {
                $data['is_refundable'] = 1;
                $data['refundable_day'] = ConfigRefund::first()->refund_time;
            }

            $product = Product::create($data);

            // Product Gallery
            $galleryData['product_id'] = $product->id;
            if($request->hasfile('gallery')) {
                foreach ($request->file('gallery') as $key => $value) {
                    $valueName = rand() . '.' . $value->getClientOriginalName();
                    $value->storeAs('public/product/',$valueName);
                    $galleryData['image'] = $valueName;
                    $productGallery = ProductGallery::create($galleryData);
                }
            }

            // Product Price

            foreach ($request->qty_type as $key => $val) {
                if ($request->discount_type[$key] == 'Flat') {
                    $sale_price = $request->regular_price[$key] - $request->discount_value[$key];
                } else {
                    $get_value = $request->discount_value[$key] * $request->regular_price[$key] / 100;
                    $sale_price = $request->regular_price[$key] - $get_value;
                }
                $priceData['product_id'] = $product->id;
                $priceData['qty_type'] = $val;
                $priceData['qty_weight'] = $request->qty_weight[$key];
                $priceData['regular_price'] = $request->regular_price[$key];
                $priceData['discount_type'] = $request->discount_type[$key];
                $priceData['discount_value'] = $request->discount_value[$key];
                $priceData['sale_price'] = $sale_price;
                $productPrice = ProductPrice::create($priceData);

            }
            foreach ($request->category_id as $key => $val) {
            $categoryData['product_id'] = $product->id;
            $categoryData['category_id'] = $val;
            $productCategory = ProductCategory::create($categoryData);
            }
            if(!empty($request->tag)) {
            foreach ($request->tag as $key => $val) {
                $tagData['product_id'] = $product->id;
                $tagData['tag'] = $val;
                $productTag = ProductTag::create($tagData);
                }
            }

            // Product Attribute
            // $attributeData['product_id'] = $product->id;
            // if(isset($data['attributes'])) {
            //     foreach ($data['attributes'] as $index => $value) {
            //         foreach ($data['attributeValues'] as $key => $attributeValueArray) {
            //             if ($value == $key) {
            //                 foreach ($attributeValueArray as $val) {
            //                     $attributeData['attribute_id'] = $value;
            //                     $attributeData['attribute_values_id'] = $val;
            //                     ProductAttribute::create($attributeData);
            //                 }
            //             }
            //         }
            //     }
            // }

            return redirect('/admin/product')->with('success','Product created successfully.');
        } catch (Exception $e){
            dd($e->getMessage());
            return redirect()->back()->with('failure', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        //$categories = Category::whereStatus(1)->whereNull('parent_category_id')->get();
        $categories = Category::whereStatus(1)->whereNull('parent_category_id')->get();
        $types = Type::whereStatus(1)->get();
        $tags = ProductTag::all();
        // $brands = Brand::whereStatus(1)->get();
        // $attributes = Attribute::whereStatus(1)->get();
        return view('admin.product.edit', compact('product','categories','types','tags'));
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
            'name' => 'required|string|min:3|max:255',
            'slug' => 'required|string|min:2|max:255|unique:products,slug,'.$id,
            'sku' => 'required|string|max:255|unique:products,sku,'.$id,
            // 'category_id' => 'nullable|integer',
            // 'brand_id' => 'nullable|integer',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'published'=>'nullable',
            'featured'=>'nullable',
            'cash_on_delivery'=>'nullable',
            'is_refundable' => 'nullable',
            // 'regular_price'=>'required',
            'sale_price'=>'nullable',
            'shipping_days'=>'nullable|integer',
            // 'in_stock' => 'nullable|integer',
            'stock_warning' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'hidden_image' => 'required|string',
            'gallery' => 'nullable',
            'gallery.*' => 'mimes:jpg,png,jpeg,gif,svg',
            'gallery_images'=>'nullable',
            'gallery_images.*'=>'nullable|string'
        ]);

        $product = Product::findOrFail($id);
        $data = $request->all();


        $category_id=$data['category_id'];
        $data['category_id']=implode(',',$category_id);
        // Product Gallery

        foreach($product->gallery as $img) {
            File::delete(public_path('storage/product/'). $img->image);
        }
        $product->gallery->each->delete();
        $galleryData['product_id'] = $product->id;
        if (!empty($request->gallery_images)) {
            foreach ($request->gallery_images as $key => $value) {
                $galleryData['image'] = $value;
                $productGallery = ProductGallery::create($galleryData);
            }
        }

        if($request->hasfile('gallery')) {
            foreach ($request->file('gallery') as $key => $value) {
                $valueName = rand() . '.' . $value->getClientOriginalName();
                $value->storeAs('public/product/',$valueName);
                $galleryData['image'] = $valueName;
                $productGallery = ProductGallery::create($galleryData);
            }
        }

        $product->categories->each->delete();
        foreach ($request->category_id as $key => $val) {
            $categoryData['product_id'] = $product->id;
            $categoryData['category_id'] = $val;
            $productCategory = ProductCategory::create($categoryData);
        }

        // Product Attribute
        // $product->attributes->each->delete();
        // $attributeData['product_id'] = $product->id;
        // if(isset($data['attributes'])) {
        //     foreach ($data['attributes'] as $index => $value) {
        //         foreach ($data['attributeValues'] as $key => $attributeValueArray) {
        //             if ($value == $key) {
        //                 foreach ($attributeValueArray as $val) {
        //                     $attributeData['attribute_id'] = $value;
        //                     $attributeData['attribute_values_id'] = $val;
        //                     ProductAttribute::create($attributeData);
        //                 }
        //             }
        //         }
        //     }
        // }

        $product->getprice->each->delete();
        foreach ($request->qty_type as $key => $val) {
            if ($request->discount_type[$key] == 'Flat') {
                $sale_price = $request->regular_price[$key] - $request->discount_value[$key];
            } else {
                $get_value = $request->discount_value[$key] * $request->regular_price[$key] / 100;
                $sale_price = $request->regular_price[$key] - $get_value;
            }

            // $priceData['product_id'] = $product->id;
            $priceData['product_id'] = $product->id;
            $priceData['qty_type'] = $val;
            $priceData['qty_weight'] = $request->qty_weight[$key];
            $priceData['regular_price'] = $request->regular_price[$key];
            $priceData['discount_type'] = $request->discount_type[$key];
            $priceData['discount_value'] = $request->discount_value[$key];
            $priceData['sale_price'] = $sale_price;
            $productPrice = ProductPrice::create($priceData);

        }
        // foreach ($request->category_id as $key => $val) {
        // $categoryData['product_id'] = $product->id;
        // $categoryData['category_id'] = $val;
        // $productCategory = ProductCategory::create($categoryData);
        // }
        // $product->tags->each->delete();
        if(!empty($request->tag)) {
            $product->tags->each->delete();
        foreach ($request->tag as $key => $val) {
            $tagData['product_id'] = $product->id;
            $tagData['tag'] = $val;
            $productTag = ProductTag::create($tagData);
            }
        }


        $image_name = $request->hidden_image;
        $image = $request->file('image');
        if($image != '') {
            if ($product->image != 'default.jpg') {
                File::delete(public_path('storage/product/'). $product->image);
            }
            $image_name = rand() . '.' . $image->getClientOriginalName();
            $image->move(public_path('storage/product/'), $image_name);
            $image_name = $image_name;
        }

        $data['published'] = 0;
        if (!empty($request->published)) {
            $data['published'] = 1;
        }

        $data['featured'] = 0;
        if (!empty($request->featured)) {
            $data['featured'] = 1;
        }

        $data['in_stock'] = 0;
        if (!empty($request->in_stock)) {
            $data['in_stock'] = 1;
        }

        $data['addon'] = 0;
        if (!empty($request->addon)) {
            $data['addon'] = 1;
        }
        $data['eggless'] = 0;
        if (!empty($request->eggless)) {
            $data['eggless'] = 1;
        }

        $data['photo_cake'] = 0;
            if (!empty($request->photo_cake)) {
                $data['photo_cake'] = 1;
            }

            $data['message'] = 0;
            if (!empty($request->message)) {
                $data['message'] = 1;
            }

            $data['cake_flavour'] = 0;
            if (!empty($request->cake_flavour)) {
                $data['cake_flavour'] = 1;
            }

            $data['heart_shape'] = 0;
            if (!empty($request->heart_shape)) {
                $data['heart_shape'] = 1;
            }


        $data['is_refundable'] = 0;
        if (!empty($request->is_refundable)) {
            $data['is_refundable'] = 1;
            $data['refundable_day'] = ConfigRefund::first()->refund_time;
        } else {
            $data['refundable_day'] = null;
        }

        $data['image'] = $image_name;
        $product->update($data);
        return redirect('admin/product')->with('success', 'Product has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image != 'default.jpg') {
            File::delete(public_path('storage/product/').$product->image);
        }
        $product->gallery->each->delete();
        $product->gallery->each->delete();
        // $product->attributes->each->delete();

        $product->getprice->each->delete();
        $product->categories->each->delete();
        $product->tags->each->delete();

        $product->delete();
        return redirect('/admin/product')->with('success','Product deleted successfully.');
    }

    public function featuredToggle(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if (!empty($request->featured)) {
            $product->update(['featured'=>1]);
        } else {
            $product->update(['featured'=>0]);
        }
        return redirect('admin/product')->with('success', 'Product has been upadted successfully.');
    }

    public function publishedToggle(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if (!empty($request->published)) {
            $product->update(['published'=>1]);
        } else {
            $product->update(['published'=>0]);
        }
        return redirect('admin/product')->with('success', 'Product has been upadted successfully.');
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'csv_file' => 'required|file|mimes:csv,txt',
            ]);

            if ($request->hasFile('csv_file')) {
                $path = $request->file('csv_file')->getRealPath();
                $data = array_map('str_getcsv', file($path));

                foreach ($data as $key => $row) {
                    if ($key != 0) {
                        $product = new Product();
                        $product->name = $row[0];
                        $product->slug = $row[1];
                        $product->category_id = Category::whereSlug($row[2])->first()->id??null;
                        // $product->brand_id = Brand::whereSlug($row[3])->first()->id??null;
                        // $product->sku = $row[4];
                        $product->description = $row[5];
                        $product->meta_title = $row[6]??null;
                        $product->meta_keywords = $row[7]??null;
                        $product->meta_description = $row[8]??null;
                        $product->published = $row[9]??0;
                        $product->featured = $row[10]??0;
                        $product->cash_on_delivery = $row[11]??0;
                        // $product->regular_price = $row[12];
                        if ($row[13]) {
                            $sale_price = $row[13];
                        } else {
                            $sale_price = null;
                        }
                        $product->sale_price = $sale_price; //here
                        if ($row[14]) {
                            $shipping_days = $row[14];
                        } else {
                            $shipping_days = null;
                        }
                        $product->shipping_days = $shipping_days; //here
                        $product->in_stock = $row[15]??1;
                        if ($row[16]) {
                            $stock_warning = $row[16];
                        } else {
                            $stock_warning = null;
                        }
                        $product->stock_warning = $stock_warning;
                        if ($row[17]) {
                            $is_refundable = $row[17];
                        } else {
                            $is_refundable = null;
                        }
                        $product->is_refundable = $is_refundable;
                        $product->user_id = Auth::user()->id;

                        $product->save();
                    }
                }
            }
            return redirect()->back()->with('success', 'CSV imported successfully.');
        } catch (Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('failure', "Please check all the fields and use unique SKU");
        }
    }
}
