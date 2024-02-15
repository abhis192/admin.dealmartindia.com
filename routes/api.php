<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::controller(AuthController::class)->group(function(){
//     Route::post('register', 'register');
//     Route::post('login', 'login');
// });

//AuthController //RegisterCustomer
// Route::post('register', [App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('login', [App\Http\Controllers\Api\AuthController::class, 'login']);
// Route::post('login-with-otp', [App\Http\Controllers\Api\AuthController::class, 'loginWithOtp']);
// Route::post('register-with-otp', [App\Http\Controllers\Api\AuthController::class, 'registerWithOtp']);

Route::post('generate-otp', [App\Http\Controllers\Api\AuthController::class, 'generateOtp']);
Route::post('otp-login', [App\Http\Controllers\Api\AuthController::class, 'verifyOtp']);

Route::post('login-via-otp', [App\Http\Controllers\Api\AuthController::class, 'loginViaOtp']);

//login with google
Route::get('auth/google', [App\Http\Controllers\Api\AuthController::class, 'googleLogin']);
Route::any('auth/google/callback', [App\Http\Controllers\Api\AuthController::class, 'callbackFromGoogle'])->name('callback');
// suraj
Route::post('login/google', [App\Http\Controllers\Api\AuthController::class, 'loginWithGoogle']);

 //ProductController API
 Route::post('products', [App\Http\Controllers\Api\ProductController::class, 'list']);
 Route::post('productsByCity', [App\Http\Controllers\Api\ProductController::class, 'listBycity']);


 Route::post('related/products/{productId}', [App\Http\Controllers\Api\ProductController::class, 'relatedProducts']);

 Route::get('product/addons', [App\Http\Controllers\Api\ProductController::class, 'addonlist']);

 //CategoryController API
 Route::get('categories', [App\Http\Controllers\Api\CategoryController::class, 'list']);
 Route::get('productCategory/{id}', [App\Http\Controllers\Api\CategoryController::class, 'categoryById']);
 Route::get('productsByCategorySlug/{slug}', [App\Http\Controllers\Api\CategoryController::class, 'productsByCategorySlug']);

 Route::get('navMenu', [App\Http\Controllers\Api\MenuController::class, 'navMenu']);


//TypeController API
Route::get('types', [App\Http\Controllers\Api\TypeController::class, 'list']);
Route::get('categoryByType/{id}', [App\Http\Controllers\Api\TypeController::class, 'typeById']);
Route::get('categoryByTypeSlug/{slug}', [App\Http\Controllers\Api\TypeController::class, 'categoryByTypeSlug']);

//CouponController API
Route::get('coupons', [App\Http\Controllers\Api\CouponController::class, 'list']);
Route::post('applyCoupon', [App\Http\Controllers\Api\CouponController::class, 'applyCoupon']);

//DeliveryOptionController API
Route::get('deliveryoptions', [App\Http\Controllers\Api\DeliveryOptionApiController::class, 'list']);
Route::post('deliveryOptionsBycity', [App\Http\Controllers\Api\DeliveryOptionApiController::class, 'deliveryOptionsBycity']);

 //CountryAPIController API
 Route::get('countries', [App\Http\Controllers\Api\CountryApiController::class, 'list']);

 //StateAPIController API
 Route::get('states', [App\Http\Controllers\Api\StateApiController::class, 'list']);

 //CityAPIController API
 Route::get('cities', [App\Http\Controllers\Api\CityApiController::class, 'list']);

 //PincodeAPIController API
 Route::get('pincodes', [App\Http\Controllers\Api\PincodeApiController::class, 'list']);
 Route::post('checkPincode', [App\Http\Controllers\Api\PincodeApiController::class, 'check']);
 Route::get('locations/{id}', [App\Http\Controllers\Api\PincodeApiController::class, 'location']);

 //AreaAPIController API
 Route::get('areas', [App\Http\Controllers\Api\AreaApiController::class, 'list']);
 Route::get('locations', [App\Http\Controllers\Api\AreaApiController::class, 'locations']);
//  Route::get('locations/{id}', [App\Http\Controllers\Api\AreaApiController::class, 'location']);

//TestimonialAPIController API
Route::get('testimonials', [App\Http\Controllers\Api\TestimonialApiController::class, 'list']);

 //BulkPriceAPIController API
//  Route::get('bulk-prices', [App\Http\Controllers\Api\BulkPriceApiController::class, 'list']);
//  Route::get('pricingByCityId/{cityId}', [App\Http\Controllers\Api\BulkPriceApiController::class, 'pricingByCityId']);

//BannerAPIController API
Route::get('banners', [App\Http\Controllers\Api\BannerApiController::class, 'list']);

//ConfigurationAPIController API
Route::get('settings', [App\Http\Controllers\Api\ConfigurationApiController::class, 'list']);

//PageAPIController API
Route::get('pages', [App\Http\Controllers\Api\PageApiController::class, 'list']);
Route::get('page/{slug}', [App\Http\Controllers\Api\PageApiController::class, 'pagesBySlug']);

 // Add on
 Route::post('product/addonsByCity', [App\Http\Controllers\Api\ProductController::class, 'addonlistByCity']);

//cake-flavour
Route::get('cake-flavours', [App\Http\Controllers\Api\CakeFlavourController::class, 'list']);

//home-page
Route::get('homePage', [App\Http\Controllers\Api\HomePageController::class, 'list']);

Route::middleware('auth:sanctum')->group( function () {
    //user logout
    Route::post('logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);

    //user update
    Route::get('userDetail/', [App\Http\Controllers\Api\UserController::class, 'view']);
    Route::post('user/update/{id}', [App\Http\Controllers\Api\AuthController::class, 'update']);
    Route::post('user/profileupdate/{id}', [App\Http\Controllers\Api\AuthController::class, 'updateProfile']);

    //UserController
    Route::get('user/addresses', [App\Http\Controllers\Api\UserController::class, 'index']);
    Route::post('user/add/address', [App\Http\Controllers\Api\UserController::class, 'store']);
    Route::put('user/update/address/{id}', [App\Http\Controllers\Api\UserController::class, 'update']);
    Route::delete('user/address/{id}', [App\Http\Controllers\Api\UserController::class, 'destroy']);

    Route::put('update/password', [App\Http\Controllers\Api\UserController::class, 'updatePassword']);

    //PaymentAPIController API
    Route::get('paymentGateways', [App\Http\Controllers\Api\PaymentApiController::class, 'list']);

    //WishlistAPIController API
    Route::get('wishlists', [App\Http\Controllers\Api\WishlistApiController::class, 'list']);
    Route::post('wishlist/add/{productId}', [App\Http\Controllers\Api\WishlistApiController::class, 'wishlistAdd']);
    Route::post('wishlist/store', [App\Http\Controllers\Api\WishlistApiController::class, 'store']);
    Route::delete('wishlist/delete/{id}', [App\Http\Controllers\Api\WishlistApiController::class, 'destroy']);
    Route::get('wishlists/move-to-cart/{id}', [App\Http\Controllers\Api\WishlistApiController::class, 'wishlistMoveToCart']);

    // order
    Route::get('user/orders', [App\Http\Controllers\Api\OrderController::class, 'index']);
    Route::post('user/place-order', [App\Http\Controllers\Api\OrderController::class, 'placeOrder']);
    Route::get('user/cancel-order/{orderId}', [App\Http\Controllers\Api\OrderController::class, 'cancelOrder']);
    Route::get('user/show-order/{orderId}', [App\Http\Controllers\Api\OrderController::class, 'showOrder']);

    // Cart routes for authenticated users
    Route::get('user/cart/items', [App\Http\Controllers\Api\CartController::class, 'cart']);
    Route::post('user/add/cart', [App\Http\Controllers\Api\CartController::class, 'addcart']);
    Route::put('user/update/cart/{id}', [App\Http\Controllers\Api\CartController::class, 'updatecart']);
    Route::delete('user/cart/delete/{id}', [App\Http\Controllers\Api\CartController::class, 'destroycart']);

    Route::get('user/cartitems', [App\Http\Controllers\Api\CartController::class, 'cartItems']);
    Route::delete('user/clear/cart', [App\Http\Controllers\Api\CartController::class, 'clearCart']);

    Route::post('user/productDetailByCity/{slug}', [App\Http\Controllers\Api\ProductController::class, 'productDetailByCity']);

    // coupon
    Route::post('applyCoupon', [App\Http\Controllers\Api\CouponController::class, 'applyCoupon']);

    Route::get('productDetail/{slug}', [App\Http\Controllers\Api\ProductController::class, 'productBySlug']);

    //ReviewAPIController API
    Route::get('reviews', [App\Http\Controllers\Api\ReviewApiController::class, 'list']);
    Route::post('review/store', [App\Http\Controllers\Api\ReviewApiController::class, 'store']);
    Route::get('reviewByProduct/{id}', [App\Http\Controllers\Api\ReviewApiController::class, 'reviewByProductId']);
});
