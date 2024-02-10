<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PricingRule;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Auth;

class BulkPriceApiController extends Controller
{
    public function pricingByCityId($cityId) {
        $pricings = PricingRule::whereStatus(1)->whereCityId($cityId)->with('city')->paginate(10);
        foreach ($pricings as $key => $pricing) {
            $pricings[$key]['pricing_rules'] = json_decode($pricing->pricing_rules);
        }
        return response()->json($pricings);
    }

    public function list(){
        $bulkprices = PricingRule::whereStatus(1)->get();
        foreach ($bulkprices as $key => $bulkprice) {
            $bulkprices[$key]['pricing_rules'] = json_decode($bulkprice->pricing_rules);
        }
        return $bulkprices;
    }

    public function productDetailByCity($slug, Request $request)
    {
        $user_id = auth()->user()->id ?? 0;
        if ($request->has('city_id')) {
            $product = Product::wherePublished(1)->whereSlug($slug)
                ->with('user:id,name', 'type:id,name', 'categories:product_id,category_id', 'categories.category', 'categories.category.type', 'tags', 'gallery', 'reviews')
                ->first();

            if ($product) {
                $product->image = '/storage/product/' . $product->image;
                foreach ($product->categories as $category) {
                    $category->category->image = '/storage/category/' . $category->category->image;
                    $category->category->icon = '/storage/category/' . $category->category->icon;
                }
                $category->category->type->image = '/storage/type/' . $category->category->type->image;
                $category->category->type->icon = '/storage/type/' . $category->category->type->icon;
                foreach($product->gallery as $galleries){
                    $galleries->image='/storage/product/' .$galleries->image;
                }
                $productPricing = PricingRule::whereStatus(1)->whereProductId($product->id)->first();

                if ($productPricing) {
                    $city_ids_array = explode(', ', $productPricing->city_id);
                    if (in_array($request->get('city_id'), $city_ids_array)) {
                        // $product['product_id'] = ($productPricing->product_id);
                        $product['pricing'] = json_decode($productPricing->pricing_rules);

                        $newPricing = [];
                        foreach ($product['pricing'] as $key => $value) {
                            $pricingArray = (array) $value;
                            $pricingArray['id'] = $key;
                            $newPricing[] = (object) $pricingArray;
                        }

                        $product['pricing'] = $newPricing;

                    } else {
                        $product['pricing'] = $product->prices;
                    }
                } else {
                    $product['pricing'] = $product->prices;
                }

                $product['wishlistId'] = $this->wishlistProduct($product->id, $user_id);
                unset($product['prices']);
                return response()->json($product);
            }
            // else{

            //     $response = [
            //         'success' => false,
            //         'data' => '',
            //         'message' => 'Product does not exist'
            //     ];
            //     return response()->json($response,200);

            // }
        } else {
            $product = Product::wherePublished(1)->whereSlug($slug)
                ->with('user:id,name', 'type:id,name', 'categories:product_id,category_id', 'categories.category', 'categories.category.type', 'tags', 'prices', 'gallery', 'reviews')
                ->first();

            if ($product) {
                $product->image = '/storage/product/' . $product->image;

                foreach ($product->categories as $category) {
                    $category->category->image = '/storage/category/' . $category->category->image;
                    $category->category->icon = '/storage/category/' . $category->category->icon;
                }

                $category->category->type->image = '/storage/type/' . $category->category->type->image;
                $category->category->type->icon = '/storage/type/' . $category->category->type->icon;

                foreach($product->gallery as $galleries){
                    $galleries->image='/storage/product/' .$galleries->image;
                }

                $product['wishlistId'] = $this->wishlistProduct($product->id, $user_id);
                $product['pricing'] = $product->prices;
                unset($product['prices']);
            }
            // else{

            //     $response = [
            //         'success' => false,
            //         'data' => '',
            //         'message' => 'Product does not exist'
            //     ];
            //     return response()->json($response,200);

            // }
        }
        return response()->json($product);
    }

    public function wishlistProduct($productId, $userId) {
        $wishlist = Wishlist::whereUserId($userId)->whereProductId($productId)->first();

        if ($wishlist) {
            return $wishlist->id;
        }
        return null;
    }
}
