<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\PricingRule;
use App\Models\Category;
use App\Models\Wishlist;
use Auth;

class ProductController extends Controller
{
    // products list with low to high, price range
    public function list(Request $request)
    {
        $search = $request->input('search');
        $priceRange = $request->input('price_range');
        $sortBy = $request->input('sort_by');

        $query = Product::wherePublished(1)
        ->with('user:id,name', 'type:id,name', 'categories.category', 'categories.category.type', 'tags', 'prices', 'gallery', 'reviews');

        if ($search) {
            $category = Category::where('slug', $search)->first();

            if ($category) {
                $query->whereHas('categories.category', function ($categoryQ) use ($search) {
                    $categoryQ->where('slug', $search);
                });
            } else {
                // If no matching category, search by product name, slug, or description
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('slug', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%");
                });
            }
        }

        if ($priceRange) {
            switch ($priceRange) {
                case '499 and below':
                    $query->whereHas('prices', function ($priceQ) {
                        $priceQ->where('sale_price', '<=', 499);
                    });
                    break;
                case '500-999':
                    $query->whereHas('prices', function ($priceQ) {
                        $priceQ->where('sale_price', '>=', 500)->where('sale_price', '<=', 999);
                    });
                    break;
                case '1000-1500':
                    $query->whereHas('prices', function ($priceQ) {
                        $priceQ->where('sale_price', '>=', 1000)->where('sale_price', '<=', 1500);
                    });
                    break;
                case '1500-2500':
                    $query->whereHas('prices', function ($priceQ) {
                        $priceQ->where('sale_price', '>=', 1500)->where('sale_price', '<=', 2500);
                    });
                    break;
                case '2500 and above':
                    $query->whereHas('prices', function ($priceQ) {
                        $priceQ->where('sale_price', '>=', 2500);
                    });
                    break;
                default:
                    break;
            }
        }

        $products = $query->get();

        if ($sortBy) {
            $direction = strtolower($sortBy);

            switch ($direction) {
                case 'low to high':
                    $products = $products->sortBy(function ($product) {
                        return $product->prices->min('sale_price');
                    });
                    break;
                case 'high to low':
                    $products = $products->sortByDesc(function ($product) {
                        return $product->prices->min('sale_price');
                    });
                    break;
                case 'featured':
                    $products = $products->sortByDesc('is_featured');
                    break;
                default:
                    break;
            }
            $products = $products->values();
        }

        $transformedProducts = $products->map(function ($product) {
            $product['image'] = '/storage/product/' . $product->image;

            foreach ($product->gallery as $galleryKey => $gallery) {
                $product['gallery'][$galleryKey]['image'] = '/storage/product/' . $gallery->image;
            }

            foreach ($product->categories as $categoryKey => $category) {
                $categoryImagePath = $category->category->image;
                $categoryIconPath = $category->category->icon;

                // Check if the path already contains '/storage/category/'
                if (strpos($categoryImagePath, '/storage/category/') !== 0) {
                    $product['categories'][$categoryKey]['category']['image'] = '/storage/category/' . $categoryImagePath;
                    $product['categories'][$categoryKey]['category']['icon'] = '/storage/category/' . $categoryIconPath;
                }

                $categoryImagePath = $category->category->type->image;
                $categoryIconPath = $category->category->type->icon;

                // Check if the path already contains '/storage/type/'
                if (strpos($categoryImagePath, '/storage/type/') !== 0) {
                    $category->category->type->image = '/storage/type/' . $category->category->type->image;
                    $category->category->type->icon = '/storage/type/' . $category->category->type->icon;
                }
            }

            return $product;
        });
        $data['products']=$transformedProducts;

        $response = [
            'success' => true,
            'message' => 'Product list',
            'data' => $data,
        ];

        return response()->json($response,200);
        // return response()->json($transformedProducts);
    }

    //product by slugs
    public function productBySlug($slug)
    {
        $user_id = auth()->user()->id;
        $product = Product::wherePublished(1)->whereSlug($slug)
            ->with('user:id,name', 'type:id,name', 'categories:product_id,category_id', 'categories.category', 'categories.category.type', 'tags', 'prices', 'gallery', 'reviews')
            ->first(); // Use first() instead of get() to get a single model instance

        if ($product) {
            // Modify the image paths for the product
            $product->image = '/storage/product/' . $product->image;

            foreach ($product->categories as $category) {
                $category->category->image = '/storage/category/' . $category->category->image;
                $category->category->icon = '/storage/category/' . $category->category->icon;

                // // Modify the image and icon paths for the nested type relationship
                // $category->category->type->image = '/storage/type/' . $category->category->type->image;
                // $category->category->type->icon = '/storage/type/' . $category->category->type->icon;
            }

               // Modify the image and icon paths for the nested type relationship
               $category->category->type->image = '/storage/type/' . $category->category->type->image;
               $category->category->type->icon = '/storage/type/' . $category->category->type->icon;

            foreach($product->gallery as $galleries){
                $galleries->image='/storage/product/' .$galleries->image;
            }
        // }
        $product['wishlistId'] = $this->wishlistProduct($product->id, $user_id);
        $data['product']=$product;

        $response = [
            'success' => true,
            'message' => 'Product detail',
            'data' => $data,
        ];

        return response()->json($response,200);
    }else{
    $response = [
        'success' => true,
        'message' => 'Product not available',
        'data' => '',
    ];

    return response()->json($response,200);
}
}
    //related products
    public function relatedProducts(Request $request, $productId)
    {
        $productc = Product::findOrFail($productId);
        $products = Product::whereCategoryId($productc->category_id)->inRandomOrder()->take(5)->wherePublished(1)-> with('user:id,name', 'type:id,name', 'categories.category', 'categories.category.type', 'tags', 'gallery', 'reviews')
        ->get();

        $transformedProducts = $products->map(function ($product) {
            $product['image'] = '/storage/product/' . $product->image;

            foreach ($product->gallery as $galleryKey => $gallery) {
                $product['gallery'][$galleryKey]['image'] = '/storage/product/' . $gallery->image;
            }

            foreach ($product->categories as $categoryKey => $category) {
                $categoryImagePath = $category->category->image;
                $categoryIconPath = $category->category->icon;

                // Check if the path already contains '/storage/category/'
                if (strpos($categoryImagePath, '/storage/category/') !== 0) {
                    $product['categories'][$categoryKey]['category']['image'] = '/storage/category/' . $categoryImagePath;
                    $product['categories'][$categoryKey]['category']['icon'] = '/storage/category/' . $categoryIconPath;
                }

                $categoryImagePath = $category->category->type->image;
                $categoryIconPath = $category->category->type->icon;

                // Check if the path already contains '/storage/type/'
                if (strpos($categoryImagePath, '/storage/type/') !== 0) {
                    $category->category->type->image = '/storage/type/' . $category->category->type->image;
                    $category->category->type->icon = '/storage/type/' . $category->category->type->icon;
                }
            }

            return $product;
        });
        $data['products']=$transformedProducts;

        $response = [
            'success' => true,
            'message' => 'Product list',
            'data' => $data,
        ];

        return response()->json($response,200);
    }

    public function wishlistProduct($productId, $userId) {
        $wishlist = Wishlist::whereUserId($userId)->whereProductId($productId)->first();
        if ($wishlist) {
            return $wishlist->id;
        }
        return null;
    }
}
