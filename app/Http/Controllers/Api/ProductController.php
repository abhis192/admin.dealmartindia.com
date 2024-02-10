<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\PricingRule;
use App\Models\Category;
use Auth;

class ProductController extends Controller
{
    // show data of type table
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
                        $priceQ->where('final_price', '<=', 499);
                    });
                    break;
                case '500-999':
                    $query->whereHas('prices', function ($priceQ) {
                        $priceQ->where('final_price', '>=', 500)->where('final_price', '<=', 999);
                    });
                    break;
                case '1000-1500':
                    $query->whereHas('prices', function ($priceQ) {
                        $priceQ->where('final_price', '>=', 1000)->where('final_price', '<=', 1500);
                    });
                    break;
                case '1500-2500':
                    $query->whereHas('prices', function ($priceQ) {
                        $priceQ->where('final_price', '>=', 1500)->where('final_price', '<=', 2500);
                    });
                    break;
                case '2500 and above':
                    $query->whereHas('prices', function ($priceQ) {
                        $priceQ->where('final_price', '>=', 2500);
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
                        return $product->prices->min('final_price');
                    });
                    break;
                case 'high to low':
                    $products = $products->sortByDesc(function ($product) {
                        return $product->prices->min('final_price');
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

        return response()->json($transformedProducts);
    }

    public function listBycity(Request $request) {
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
                        $priceQ->where('final_price', '<=', 499);
                    });
                    break;
                case '500-999':
                    $query->whereHas('prices', function ($priceQ) {
                        $priceQ->where('final_price', '>=', 500)->where('final_price', '<=', 999);
                    });
                    break;
                case '1000-1500':
                    $query->whereHas('prices', function ($priceQ) {
                        $priceQ->where('final_price', '>=', 1000)->where('final_price', '<=', 1500);
                    });
                    break;
                case '1500-2500':
                    $query->whereHas('prices', function ($priceQ) {
                        $priceQ->where('final_price', '>=', 1500)->where('final_price', '<=', 2500);
                    });
                    break;
                case '2500 and above':
                    $query->whereHas('prices', function ($priceQ) {
                        $priceQ->where('final_price', '>=', 2500);
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
                        return $product->prices->min('final_price');
                    });
                    break;
                case 'high to low':
                    $products = $products->sortByDesc(function ($product) {
                        return $product->prices->min('final_price');
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

        $transformedProducts = $products->map(function ($product) use ($request) {
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

            $productPricing = PricingRule::whereProductId($product->id)->first();
            if ($request->has('city_id')) {
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
            } else {
                $product['pricing'] = $product->prices;
            }

            return $product;
        });

        return response()->json($transformedProducts);
    }

    public function productBySlug($slug)
    {
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
        }

        return response()->json($product);
    }



    public function addonlist()
    {
        $products = Product::whereAddon(1)->wherePublished(1)-> with('user:id,name', 'type:id,name', 'categories.category', 'categories.category.type', 'tags', 'prices', 'gallery', 'reviews')
            ->paginate(10);

        foreach ($products as $key => $product) {
            $products[$key]['image'] = '/storage/product/' . $product->image;

            foreach ($product->gallery as $galleryKey => $gallery) {
                $products[$key]['gallery'][$galleryKey]['image'] = '/storage/product/' . $gallery->image;
            }

            foreach ($product->categories as $categoryKey => $category) {
                $categoryImagePath = $category->category->image;
                $categoryIconPath = $category->category->icon;

                // Check if the path already contains '/storage/category/'
                if (strpos($categoryImagePath, '/storage/category/') !== 0) {
                    $products[$key]['categories'][$categoryKey]['category']['image'] = '/storage/category/' . $categoryImagePath;
                    $products[$key]['categories'][$categoryKey]['category']['icon'] = '/storage/category/' . $categoryIconPath;
                }

                $categoryImagePath = $category->category->type->image;
                $categoryIconPath = $category->category->type->icon;

                // Check if the path already contains '/storage/category/'
                if (strpos($categoryImagePath, '/storage/type/') !== 0) {
                $category->category->type->image = '/storage/type/' . $category->category->type->image;
                $category->category->type->icon = '/storage/type/' . $category->category->type->icon;
                }
            }
        }

        return response()->json($products);
    }

    public function addonlistByCity(Request $request)
    {
        $products = Product::whereAddon(1)->wherePublished(1)-> with('user:id,name', 'type:id,name', 'categories.category', 'categories.category.type', 'tags', 'gallery', 'reviews')
        ->paginate(10);

        foreach ($products as $key => $product) {
            $products[$key]['image'] = '/storage/product/' . $product->image;

            foreach ($product->gallery as $galleryKey => $gallery) {
                $products[$key]['gallery'][$galleryKey]['image'] = '/storage/product/' . $gallery->image;
            }

            foreach ($product->categories as $categoryKey => $category) {
                $categoryImagePath = $category->category->image;
                $categoryIconPath = $category->category->icon;

                // Check if the path already contains '/storage/category/'
                if (strpos($categoryImagePath, '/storage/category/') !== 0) {
                    $products[$key]['categories'][$categoryKey]['category']['image'] = '/storage/category/' . $categoryImagePath;
                    $products[$key]['categories'][$categoryKey]['category']['icon'] = '/storage/category/' . $categoryIconPath;
                }

                $categoryImagePath = $category->category->type->image;
                $categoryIconPath = $category->category->type->icon;

                // Check if the path already contains '/storage/category/'
                if (strpos($categoryImagePath, '/storage/type/') !== 0) {
                $category->category->type->image = '/storage/type/' . $category->category->type->image;
                $category->category->type->icon = '/storage/type/' . $category->category->type->icon;
                }
            }

            $productPricing = PricingRule::whereProductId($product->id)->first();

            if ($request->has('session_id')){
                $cart_prod = Cart::whereUserId($request->get('session_id'))->whereProductId($product->id)->count();
                $product['in_cart'] = $cart_prod;
            }else {
                $user = auth()->user();
                if ($user) {
                    $cart_prod = Cart::whereUserId($user->id)->whereProductId($product->id)->count();
                    $product['in_cart'] = $cart_prod;
                }
            }

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
        }

        return response()->json($products);
    }

    // public function relatedProducts($productId)
    // {

    // $product = Product::findOrFail($productId);
	// $products = Product::whereCategoryId($product->category_id)->inRandomOrder()->take(5)->get();


    // foreach ($products as $key => $product) {
    //     $products[$key]['image'] = '/storage/product/' . $product->image;
    // }
	// return $products;

    //     // $products = Product::whereAddon(1)->wherePublished(1)-> with('user:id,name', 'type:id,name', 'categories.category', 'categories.category.type', 'tags', 'prices', 'gallery', 'reviews')
    //     //     ->paginate(10);
    // }





    public function relatedProducts(Request $request, $productId)
    {
        $productc = Product::findOrFail($productId);
        $products = Product::whereCategoryId($productc->category_id)->inRandomOrder()->take(5)->wherePublished(1)-> with('user:id,name', 'type:id,name', 'categories.category', 'categories.category.type', 'tags', 'gallery', 'reviews')
        ->paginate(10);

        foreach ($products as $key => $product) {
            $products[$key]['image'] = '/storage/product/' . $product->image;

            foreach ($product->gallery as $galleryKey => $gallery) {
                $products[$key]['gallery'][$galleryKey]['image'] = '/storage/product/' . $gallery->image;
            }

            foreach ($product->categories as $categoryKey => $category) {
                $categoryImagePath = $category->category->image;
                $categoryIconPath = $category->category->icon;

                // Check if the path already contains '/storage/category/'
                if (strpos($categoryImagePath, '/storage/category/') !== 0) {
                    $products[$key]['categories'][$categoryKey]['category']['image'] = '/storage/category/' . $categoryImagePath;
                    $products[$key]['categories'][$categoryKey]['category']['icon'] = '/storage/category/' . $categoryIconPath;
                }

                $categoryImagePath = $category->category->type->image;
                $categoryIconPath = $category->category->type->icon;

                // Check if the path already contains '/storage/category/'
                if (strpos($categoryImagePath, '/storage/type/') !== 0) {
                $category->category->type->image = '/storage/type/' . $category->category->type->image;
                $category->category->type->icon = '/storage/type/' . $category->category->type->icon;
                }
            }

            $productPricing = PricingRule::whereProductId($product->id)->first();

            if ($request->has('session_id')){
                $cart_prod = Cart::whereUserId($request->get('session_id'))->whereProductId($product->id)->count();
                $product['in_cart'] = $cart_prod;
            }else {
                $user = auth()->user();
                if ($user) {
                    $cart_prod = Cart::whereUserId($user->id)->whereProductId($product->id)->count();
                    $product['in_cart'] = $cart_prod;
                }
            }

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
        }

        return response()->json($products);
    }
}
