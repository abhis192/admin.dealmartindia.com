<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\ProductAttribute;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Attribute;
use Auth;
use File;

class SellerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::whereNull('deleted_at')
                            ->WhereHas('user', function($q) {
                                $q->whereRoleId(2);
                            })->get();
        return view('admin.seller-product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::whereStatus(1)->whereNull('parent_category_id')->get();
        $brands = Brand::whereStatus(1)->get();
        $attributes = Attribute::whereStatus(1)->get();
        return view('admin.seller-product.create', compact('categories','brands','attributes'));
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
            'name' => 'required|string|min:3|max:255',
            'slug' => 'required|string|min:2|max:255',
            'sku' => 'required|string',
            'category_id' => 'nullable|integer',
            'brand_id' => 'nullable|integer',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'published'=>'nullable',
            'featured'=>'nullable',
            'cash_on_delivery'=>'nullable',
            'regular_price'=>'required',
            'sale_price'=>'nullable',
            'shipping_days'=>'nullable|integer',
            'in_stock' => 'nullable|integer',
            'stock_warning' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);
        $data = $request->all();
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

        $data['cash_on_delivery'] = 0;
        if (!empty($request->cash_on_delivery)) {
            $data['cash_on_delivery'] = 1;
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

        // Product Attribute
        $attributeData['product_id'] = $product->id;
        if(isset($data['attributes'])) {
            foreach ($data['attributes'] as $index => $value) {
                foreach ($data['attributeValues'] as $key => $attributeValueArray) {
                    if ($value == $key) {
                        foreach ($attributeValueArray as $val) {
                            $attributeData['attribute_id'] = $value;
                            $attributeData['attribute_values_id'] = $val;
                            ProductAttribute::create($attributeData);
                        }
                    }
                }
            }
        }
        return redirect('/admin/seller-product')->with('success','Product created successfully.');
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
        $categories = Category::whereStatus(1)->whereNull('parent_category_id')->get();
        $brands = Brand::whereStatus(1)->get();
        $attributes = Attribute::whereStatus(1)->get();
        return view('admin.seller-product.edit', compact('product','categories','brands','attributes'));
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
            'slug' => 'required|string|min:2|max:255',
            'sku' => 'required|string',
            'category_id' => 'nullable|integer',
            'brand_id' => 'nullable|integer',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'published'=>'nullable',
            'featured'=>'nullable',
            'cash_on_delivery'=>'nullable',
            'regular_price'=>'required',
            'sale_price'=>'nullable',
            'shipping_days'=>'nullable|integer',
            'in_stock' => 'nullable|integer',
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

        // Product Gallery
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

        // Product Attribute
        $product->attributes->each->delete();
        $attributeData['product_id'] = $product->id;
        if(isset($data['attributes'])) {
            foreach ($data['attributes'] as $index => $value) {
                foreach ($data['attributeValues'] as $key => $attributeValueArray) {
                    if ($value == $key) {
                        foreach ($attributeValueArray as $val) {
                            $attributeData['attribute_id'] = $value;
                            $attributeData['attribute_values_id'] = $val;
                            ProductAttribute::create($attributeData);
                        }
                    }
                }
            }
        }

        $image_name = $request->hidden_image;
        $image = $request->file('image');
        if($image != '') {
            if ($product->image != 'default-product-image.jpg') {
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

        $data['cash_on_delivery'] = 0;
        if (!empty($request->cash_on_delivery)) {
            $data['cash_on_delivery'] = 1;
        }

        $data['image'] = $image_name;
        $product->update($data);
        return redirect('admin/seller-product')->with('success', 'Product has been successfully updated.');
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
        if ($product->image != 'default-product-image.jpg') {
            File::delete(public_path('storage/product/').$product->image);
        }
        $product->gallery->each->delete();
        $product->attributes->each->delete();
        $product->delete();
        return redirect('/admin/seller-product')->with('success','Product deleted successfully.');
    }

    public function featuredToggle(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if (!empty($request->featured)) {
            $product->update(['featured'=>1]);
        } else {
            $product->update(['featured'=>0]);
        }
        return redirect('admin/seller-product')->with('success', 'Product has been upadted successfully.');
    }

    public function publishedToggle(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if (!empty($request->published)) {
            $product->update(['published'=>1]);
        } else {
            $product->update(['published'=>0]);
        }
        return redirect('admin/seller-product')->with('success', 'Product has been upadted successfully.');
    }
}
