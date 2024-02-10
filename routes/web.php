<?php

use Illuminate\Support\Facades\Route;
use App\Models\Page;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);



    // Admin
    Route::get('', [App\Http\Controllers\Admin\LoginController::class, 'adminLogin'])->name('admin.login');
    // Route::get('/login', [App\Http\Controllers\Admin\LoginController::class, 'adminLogin'])->name('admin.login');
    Route::get('admin', [App\Http\Controllers\Admin\LoginController::class, 'adminLogin'])->name('admin.login');
    Route::get('admin/login', [App\Http\Controllers\Admin\LoginController::class, 'adminLogin'])->name('admin.login');
    Route::post('admin/start', [App\Http\Controllers\Admin\LoginController::class, 'postLogin'])->name('admin.postLogin');
    Route::get('/get-product-prices/{productId}', [App\Http\Controllers\Admin\ProductController::class, 'getProductPrices'])->name('get-product-prices');


    Route::group(['as'=>'admin.','prefix'=>'admin','namespace'=>'Admin','middleware'=>['auth','admin']], function(){

        // Dashboard
        Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // profile
        Route::get('profile', [App\Http\Controllers\Admin\UserController::class, 'profileIndex'])->name('profile');
        Route::patch('profile/{id}', [App\Http\Controllers\Admin\UserController::class, 'profileUpdate'])->name('profile.update');

        // customer
        Route::get('customers', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('customers');
        Route::get('customer/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('customer.edit');
        Route::patch('customer/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('customer.update');

        // All sellers
        Route::get('all-seller/create', [App\Http\Controllers\Admin\UserController::class, 'allSellerCreate'])->name('all-seller.create');
        Route::post('all-seller/store', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('all-seller.store');

        Route::get('all-sellers', [App\Http\Controllers\Admin\UserController::class, 'allSellerIndex'])->name('all-sellers');
        Route::get('all-seller/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'allSellerEdit'])->name('all-seller.edit');
        Route::get('all-seller/show/{id}', [App\Http\Controllers\Admin\UserController::class, 'allSellerShow'])->name('all-seller.show');
        Route::patch('all-seller/{id}', [App\Http\Controllers\Admin\UserController::class, 'allSellerUpdate'])->name('all-seller.update');
        Route::patch('all-seller/password/{id}', [App\Http\Controllers\Admin\UserController::class, 'allSellerPassUpdate'])->name('all-seller.passwordUpdate');
        Route::patch('all-seller/bank/{id}', [App\Http\Controllers\Admin\UserController::class, 'bankUpdate'])->name('all-seller.bankUpdate');
        Route::patch('all-seller/upi/{id}', [App\Http\Controllers\Admin\UserController::class, 'upiUpdate'])->name('all-seller.upiUpdate');

        Route::patch('all-seller/mapping/{id}', [App\Http\Controllers\Admin\UserController::class, 'mappingUpdate'])->name('all-seller.mappingUpdate');

        Route::patch('all-seller/gst/{id}', [App\Http\Controllers\Admin\UserController::class, 'gstUpdate'])->name('all-seller.gstUpdate');

        // verified-Seller
        Route::get('verified-sellers', [App\Http\Controllers\Admin\UserController::class, 'verifiedSellerIndex'])->name('verified-sellers');
        Route::get('verified-seller/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'verifiedSellerEdit'])->name('verified-seller.edit');
        Route::patch('verified-seller/{id}', [App\Http\Controllers\Admin\UserController::class, 'verifiedSellerUpdate'])->name('verified-seller.update');
        Route::get('verified-seller/show/{id}', [App\Http\Controllers\Admin\UserController::class, 'verifiedSellerShow'])->name('verified-seller.show');

        // unverified-Seller
        Route::get('unverified-sellers', [App\Http\Controllers\Admin\UserController::class, 'unverifiedSellerIndex'])->name('unverified-sellers');
        Route::get('unverified-seller/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'unverifiedSellerEdit'])->name('unverified-seller.edit');
        Route::patch('unverified-sellers/{id}', [App\Http\Controllers\Admin\UserController::class, 'unverifiedSellerUpdate'])->name('unverified-seller.update');
        Route::get('unverified-seller/show/{id}', [App\Http\Controllers\Admin\UserController::class, 'unverifiedSellerShow'])->name('unverified-seller.show');


        // kitchenPrice
        Route::get('kitchen-price', [App\Http\Controllers\Admin\UserController::class, 'kitchenPriceIndex'])->name('kitchen-price');
        Route::get('kitchen-price/create', [App\Http\Controllers\Admin\UserController::class, 'kitchenPricecreate'])->name('kitchen-price.create');
        Route::post('kitchen-price/store', [App\Http\Controllers\Admin\UserController::class, 'kitchenPricestore'])->name('kitchen-price.store');
        Route::get('kitchen-price/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'kitchenPriceedit'])->name('kitchen-price.edit');
        // Route::patch('product/type/{id}', [App\Http\Controllers\Admin\TypeController::class, 'update'])->name('product-type.update');

        // kitchenPrice-Config
        Route::get('kitchenPrice-Config', [App\Http\Controllers\Admin\UserController::class, 'kitchenPriceConfig'])->name('kitchenPrice-Config');
        Route::post('kitchenPrice-Config/store', [App\Http\Controllers\Admin\UserController::class, 'kitchenPriceStoreConfig'])->name('kitchenPrice.store');

        // common users
        Route::get('user/destroy/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('user.destroy');
        Route::get('user/activate/{id}', [App\Http\Controllers\Admin\UserController::class, 'activate'])->name('user.activate');
        Route::get('user/deactivate/{id}', [App\Http\Controllers\Admin\UserController::class, 'deactivate'])->name('user.deactivate');

        // Banner
        Route::get('banners', [App\Http\Controllers\Admin\BannerController::class, 'index'])->name('banners');
        Route::get('banner/create', [App\Http\Controllers\Admin\BannerController::class, 'create'])->name('banner.create');
        Route::post('banner/store', [App\Http\Controllers\Admin\BannerController::class, 'store'])->name('banner.store');
        Route::get('banner/{id}/edit', [App\Http\Controllers\Admin\BannerController::class, 'edit'])->name('banner.edit');
        Route::patch('banner/{id}', [App\Http\Controllers\Admin\BannerController::class, 'update'])->name('banner.update');
        Route::get('banner/destroy/{id}', [App\Http\Controllers\Admin\BannerController::class, 'destroy'])->name('banner.destroy');
        Route::post('banner/toggle/{id}', [App\Http\Controllers\Admin\BannerController::class, 'toggle'])->name('banner.toggle');

        // Pages
        Route::get('pages', [App\Http\Controllers\Admin\PageController::class, 'index'])->name('pages');
        Route::get('page/create', [App\Http\Controllers\Admin\PageController::class, 'create'])->name('page.create');
        Route::post('page/store', [App\Http\Controllers\Admin\PageController::class, 'store'])->name('page.store');
        Route::get('page/{id}/edit', [App\Http\Controllers\Admin\PageController::class, 'edit'])->name('page.edit');
        Route::patch('page/{id}', [App\Http\Controllers\Admin\PageController::class, 'update'])->name('page.update');
        Route::get('page/destroy/{id}', [App\Http\Controllers\Admin\PageController::class, 'destroy'])->name('page.destroy');
        Route::post('page/toggle/{id}', [App\Http\Controllers\Admin\PageController::class, 'toggle'])->name('page.toggle');

        // Home Page
        Route::get('home-page', [App\Http\Controllers\Admin\HomePageController::class, 'index'])->name('home-page');
        Route::patch('home-page/{id}', [App\Http\Controllers\Admin\HomePageController::class, 'homePageUpdate'])->name('home-page.update');

        // Import product
        Route::post('/import-csv', [App\Http\Controllers\Admin\ProductController::class, 'import'])->name('import.csv.process');

        // Import state
        Route::post('/import-state-csv', [App\Http\Controllers\Admin\StateController::class, 'import'])->name('import.state.csv.process');
         // Import city
         Route::post('/import-city-csv', [App\Http\Controllers\Admin\CityController::class, 'import'])->name('import.city.csv.process');

        // Import city
        // Route::post('/import-areas-csv', [App\Http\Controllers\Admin\AreaController::class, 'import'])->name('import.area.csv.process');

        // Import pincode


        Route::get('pincode', [App\Http\Controllers\Admin\PincodeController::class, 'getIndex'])->name('pincode');
        // Route::get('pincode', [App\Http\Controllers\Admin\PincodeController::class, 'index'])->name('pincode');
        Route::get('pincode/list', [App\Http\Controllers\Admin\PincodeController::class, 'getList'])->name('pincode.list');
        Route::get('pincode/search/pincode', [App\Http\Controllers\Admin\PincodeController::class, 'getLocationViaPinCode'])->name('pincode.search.pincode');
        Route::get('pincode/create', [App\Http\Controllers\Admin\PincodeController::class, 'getCreate'])->name('pincode.create.index');
        Route::post('pincode/create', [App\Http\Controllers\Admin\PincodeController::class, 'postCreate'])->name('pincode.create');
        Route::get('pin_codes/update/{id?}', [App\Http\Controllers\Admin\PincodeController::class, 'getUpdate'])->name('pin_codes.update.index');
        Route::post('pin_codes/update/{id?}', [App\Http\Controllers\Admin\PincodeController::class, 'postUpdate'])->name('pin_codes.update');
        Route::get('pin_codes/change/status/{id?}', [App\Http\Controllers\Admin\PincodeController::class, 'getChangeStatus'])->name('pin_codes.change.status');
        Route::get('pin_codes/delete/{id?}', [App\Http\Controllers\Admin\PincodeController::class, 'getDelete'])->name('pin_codes.delete');

        Route::get('pin_codes/import-csv', [App\Http\Controllers\Admin\PincodeController::class, 'getCsvImport'])->name('pin_codes.import.csv.index');


        Route::post('/import-pincode-csv', [App\Http\Controllers\Admin\PincodeController::class, 'import'])->name('import.pincode.csv.process');
        Route::get('pincode/import-csv', [App\Http\Controllers\Admin\PincodeController::class, 'getCsvImportSampleDownload'])->name('pincode.import.csv.download.sample');


        // Route::post('pin_codes/import-csv', [App\Http\Controllers\Admin\PincodeController::class, 'postCsvImport'])->name('pin_codes.import.csv.data');

        // Route::prefix('pin_codes')
        //  ->name('pin_codes.')
        //  ->group(function () {
        //      Route::get('/', 'PincodeController@getIndex')->name('index');
        //      Route::get('list', 'PincodeController@getList')->name('list');
        //      Route::get('search/pin_code', 'PincodeController@getLocationViaPinCode')->name('search.pin_code');
        //      Route::get('create', 'PincodeController@getCreate')->name('create.index');
        //      Route::post('create', 'PincodeController@postCreate')->name('create');
        //      Route::get('update/{id?}', 'PincodeController@getUpdate')->name('update.index');
        //      Route::post('update/{id?}', 'PincodeController@postUpdate')->name('update');
        //      Route::get('delete/{id?}', 'PincodeController@getDelete')->name('delete');
        //      Route::get('change/status/{id?}', 'PincodeController@getChangeStatus')->name('change.status');

        //      Route::prefix('import-csv')
        //          ->name('import.csv.')
        //          ->group(function () {
        //              Route::get('/', 'PincodeController@getCsvImport')->name('index');
        //              Route::get('download/sample', 'PincodeController@getCsvImportSampleDownload')->name('download.sample');
        //              Route::post('/', 'PincodeController@postCsvImport')->name('data');
        //          });
        //  });




        // Product // Type
        Route::get('product/type', [App\Http\Controllers\Admin\TypeController::class, 'index'])->name('product-type');
        Route::get('product/type/create', [App\Http\Controllers\Admin\TypeController::class, 'create'])->name('product-type.create');
        Route::post('product/type/store', [App\Http\Controllers\Admin\TypeController::class, 'store'])->name('product-type.store');
        Route::get('product/type/{id}/edit', [App\Http\Controllers\Admin\TypeController::class, 'edit'])->name('product-type.edit');
        Route::patch('product/type/{id}', [App\Http\Controllers\Admin\TypeController::class, 'update'])->name('product-type.update');
        Route::get('product/type/destroy/{id}', [App\Http\Controllers\Admin\TypeController::class, 'destroy'])->name('product-type.destroy');
        Route::post('product/type/toggle/{id}', [App\Http\Controllers\Admin\TypeController::class, 'toggle'])->name('product-type.toggle');
        // Product // Type
        Route::get('product/cake-flavour', [App\Http\Controllers\Admin\CakeFlavourController::class, 'index'])->name('cake-flavour');
        Route::get('product/cake-flavour/create', [App\Http\Controllers\Admin\CakeFlavourController::class, 'create'])->name('cake-flavour.create');
        Route::post('product/cake-flavour/store', [App\Http\Controllers\Admin\CakeFlavourController::class, 'store'])->name('cake-flavour.store');
        Route::get('product/cake-flavour/{id}/edit', [App\Http\Controllers\Admin\CakeFlavourController::class, 'edit'])->name('cake-flavour.edit');
        Route::patch('product/cake-flavour/{id}', [App\Http\Controllers\Admin\CakeFlavourController::class, 'update'])->name('cake-flavour.update');
        Route::get('product/cake-flavour/destroy/{id}', [App\Http\Controllers\Admin\CakeFlavourController::class, 'destroy'])->name('cake-flavour.destroy');
        Route::post('product/cake-flavour/toggle/{id}', [App\Http\Controllers\Admin\CakeFlavourController::class, 'toggle'])->name('cake-flavour.toggle');

        // Product // Brand
        // Route::get('product/brand', [App\Http\Controllers\Admin\BrandController::class, 'index'])->name('product-brand');
        // Route::get('product/brand/create', [App\Http\Controllers\Admin\BrandController::class, 'create'])->name('product-brand.create');
        // Route::post('product/brand/store', [App\Http\Controllers\Admin\BrandController::class, 'store'])->name('product-brand.store');
        // Route::get('product/brand/{id}/edit', [App\Http\Controllers\Admin\BrandController::class, 'edit'])->name('product-brand.edit');
        // Route::patch('product/brand/{id}', [App\Http\Controllers\Admin\BrandController::class, 'update'])->name('product-brand.update');
        // Route::get('product/brand/destroy/{id}', [App\Http\Controllers\Admin\BrandController::class, 'destroy'])->name('product-brand.destroy');
        // Route::post('product/brand/toggle/{id}', [App\Http\Controllers\Admin\BrandController::class, 'toggle'])->name('product-brand.toggle');

        // Product // Attribute
        Route::get('product/attribute', [App\Http\Controllers\Admin\AttributeController::class, 'index'])->name('product-attribute');
        Route::get('product/attribute/show/{id}', [App\Http\Controllers\Admin\AttributeController::class, 'show'])->name('product-attribute.show');
        Route::post('product/attribute/store', [App\Http\Controllers\Admin\AttributeController::class, 'store'])->name('product-attribute.store');
        Route::post('product/attribute-value/store/{id}', [App\Http\Controllers\Admin\AttributeController::class, 'valueStore'])->name('product-attribute-value.store');
        Route::get('product/attribute/{id}/edit', [App\Http\Controllers\Admin\AttributeController::class, 'edit'])->name('product-attribute.edit');
        Route::patch('product/attribute/{id}', [App\Http\Controllers\Admin\AttributeController::class, 'update'])->name('product-attribute.update');
        Route::get('product/attribute/destroy/{id}', [App\Http\Controllers\Admin\AttributeController::class, 'destroy'])->name('product-attribute.destroy');
        Route::post('product/attribute/toggle/{id}', [App\Http\Controllers\Admin\AttributeController::class, 'toggle'])->name('product-attribute.toggle');
        Route::get('product/attribute/show/{id}/edit', [App\Http\Controllers\Admin\AttributeController::class, 'showEdit'])->name('product-attribute.showEdit');
        Route::patch('product/attribute/show/update/{id}', [App\Http\Controllers\Admin\AttributeController::class, 'showUpdate'])->name('product-attribute-value.showUpdate');
        Route::get('product/attribute/show/destroy/{id}', [App\Http\Controllers\Admin\AttributeController::class, 'showDestroy'])->name('product-attribute-value.destroy');

        // Product // Category
        Route::get('product/category', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('product-category');
        Route::get('product/category/create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('product-category.create');
        Route::post('product/category/store', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('product-category.store');
        Route::get('product/category/{id}/edit', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('product-category.edit');
        Route::patch('product/category/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('product-category.update');
        Route::get('product/category/destroy/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('product-category.destroy');
        Route::post('product/category/toggle/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'toggle'])->name('product-category.toggle');

        // All Product
        Route::get('product', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('product');
        Route::get('product/create', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('product.create');
        Route::post('product/store', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('product.store');
        Route::get('product/{id}/edit', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('product.edit');
        Route::patch('product/{id}', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('product.update');
        Route::get('product/destroy/{id}', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('product.destroy');
        Route::post('product/featuredToggle/{id}', [App\Http\Controllers\Admin\ProductController::class, 'featuredToggle'])->name('product.featuredToggle');
        Route::post('product/publishedToggle/{id}', [App\Http\Controllers\Admin\ProductController::class, 'publishedToggle'])->name('product.publishedToggle');


        // Bulk Price
        Route::get('bulk-prices', [App\Http\Controllers\Admin\BulkPriceController::class, 'index'])->name('bulk-prices');
        Route::get('bulk-price/create', [App\Http\Controllers\Admin\BulkPriceController::class, 'create'])->name('bulk-price.create');
        Route::post('bulk-price/store', [App\Http\Controllers\Admin\BulkPriceController::class, 'store'])->name('bulk-price.store');
        Route::get('bulk-price/{id}/edit', [App\Http\Controllers\Admin\BulkPriceController::class, 'edit'])->name('bulk-price.edit');
        Route::patch('bulk-price/{id}', [App\Http\Controllers\Admin\BulkPriceController::class, 'update'])->name('bulk-price.update');
        Route::get('bulk-price/destroy/{id}', [App\Http\Controllers\Admin\BulkPriceController::class, 'destroy'])->name('bulk-price.destroy');
        Route::post('bulk-price/toggle/{id}', [App\Http\Controllers\Admin\BulkPriceController::class, 'toggle'])->name('bulk-price.toggle');

        //Delivery // Slot
        Route::get('slot', [App\Http\Controllers\Admin\SlotController::class, 'index'])->name('slot');
        Route::post('slot/store', [App\Http\Controllers\Admin\SlotController::class, 'store'])->name('slot.store');
        Route::get('slot/{id}/edit', [App\Http\Controllers\Admin\SlotController::class, 'edit'])->name('slot.edit');
        Route::patch('slot/{id}', [App\Http\Controllers\Admin\SlotController::class, 'update'])->name('slot.update');
        Route::get('slot/destroy/{id}', [App\Http\Controllers\Admin\SlotController::class, 'destroy'])->name('slot.destroy');
        Route::post('slot/toggle/{id}', [App\Http\Controllers\Admin\SlotController::class, 'toggle'])->name('slot.toggle');

        //Delivery // Delivery Options
        Route::get('deliveryoption', [App\Http\Controllers\Admin\DeliveryOptionController::class, 'index'])->name('deliveryoption');
        Route::post('deliveryoption/store', [App\Http\Controllers\Admin\DeliveryOptionController::class, 'store'])->name('deliveryoption.store');
        Route::get('deliveryoption/{id}/edit', [App\Http\Controllers\Admin\DeliveryOptionController::class, 'edit'])->name('deliveryoption.edit');
        Route::patch('deliveryoption/{id}', [App\Http\Controllers\Admin\DeliveryOptionController::class, 'update'])->name('deliveryoption.update');
        Route::get('deliveryoption/destroy/{id}', [App\Http\Controllers\Admin\DeliveryOptionController::class, 'destroy'])->name('deliveryoption.destroy');
        Route::post('deliveryoption/toggle/{id}', [App\Http\Controllers\Admin\DeliveryOptionController::class, 'toggle'])->name('deliveryoption.toggle');

        Route::get('deliveryoption/{id}/view', [App\Http\Controllers\Admin\DeliveryOptionController::class, 'view'])->name('deliveryoption.view');
        //    Route::patch('deliveryoption/{id}', [App\Http\Controllers\Admin\DeliveryOptionController::class, 'update'])->name('deliveryoption.update');

        // Country
        Route::get('country', [App\Http\Controllers\Admin\CountryController::class, 'index'])->name('country');
        Route::post('country/store', [App\Http\Controllers\Admin\CountryController::class, 'store'])->name('country.store');
        Route::get('country/{id}/edit', [App\Http\Controllers\Admin\CountryController::class, 'edit'])->name('country.edit');
        Route::patch('country/{id}', [App\Http\Controllers\Admin\CountryController::class, 'update'])->name('country.update');
        Route::get('country/destroy/{id}', [App\Http\Controllers\Admin\CountryController::class, 'destroy'])->name('country.destroy');
        Route::post('country/toggle/{id}', [App\Http\Controllers\Admin\CountryController::class, 'toggle'])->name('country.toggle');

        // State
        // Route::get('state', [App\Http\Controllers\Admin\StateController::class, 'index'])->name('state');
        // Route::post('state/store', [App\Http\Controllers\Admin\StateController::class, 'store'])->name('state.store');
        // Route::get('state/{id}/edit', [App\Http\Controllers\Admin\StateController::class, 'edit'])->name('state.edit');
        // Route::patch('state/{id}', [App\Http\Controllers\Admin\StateController::class, 'update'])->name('state.update');
        // Route::get('state/destroy/{id}', [App\Http\Controllers\Admin\StateController::class, 'destroy'])->name('state.destroy');
        // Route::post('state/toggle/{id}', [App\Http\Controllers\Admin\StateController::class, 'toggle'])->name('state.toggle');
        // Route::get('state/upload', [App\Http\Controllers\Admin\StateController::class, 'upload'])->name('state.upload');

        // State New Way
        // Area Routes
        Route::get('state',[App\Http\Controllers\Admin\StateController::class, 'getIndex'])->name('state');
        Route::get('state/list',[App\Http\Controllers\Admin\StateController::class, 'getList'])->name('state.list');
        Route::get('state/create',[App\Http\Controllers\Admin\StateController::class, 'getCreate'])->name('state.create.index');
        Route::post('state/create',[App\Http\Controllers\Admin\StateController::class, 'postCreate'])->name('state.create');
        Route::get('state/update/{id?}',[App\Http\Controllers\Admin\StateController::class, 'getUpdate'])->name('state.update.index');
        Route::post('state/update/{id?}',[App\Http\Controllers\Admin\StateController::class, 'postUpdate'])->name('state.update');
        Route::get('state/delete/{id?}',[App\Http\Controllers\Admin\StateController::class, 'getDelete'])->name('state.delete');
        Route::get('state/change/status/{id?}',[App\Http\Controllers\Admin\StateController::class, 'getChangeStatus'])->name('state.change.status');
            //Area Imports
        Route::get('state/import-csv/',[App\Http\Controllers\Admin\StateController::class, 'getCsvImport'])->name('state.import.csv.index');
        Route::get('state/import-csv/download/sample',[App\Http\Controllers\Admin\StateController::class, 'getCsvImportSampleDownload'])->name('state.import.csv.download.sample');
        Route::post('state/import-csv/',[App\Http\Controllers\Admin\StateController::class, 'postCsvImport'])->name('import.state.csv.process');
        // Route::post('area/import-csv/',[App\Http\Controllers\Admin\AreaController::class, 'postCsvImport'])->name('area.import.csv.data');


        // City
        Route::get('city', [App\Http\Controllers\Admin\CityController::class, 'index'])->name('city');
        Route::post('city/store', [App\Http\Controllers\Admin\CityController::class, 'store'])->name('city.store');
        Route::get('city/{id}/edit', [App\Http\Controllers\Admin\CityController::class, 'edit'])->name('city.edit');
        Route::patch('city/{id}', [App\Http\Controllers\Admin\CityController::class, 'update'])->name('city.update');
        Route::get('city/destroy/{id}', [App\Http\Controllers\Admin\CityController::class, 'destroy'])->name('city.destroy');
        Route::post('city/toggle/{id}', [App\Http\Controllers\Admin\CityController::class, 'toggle'])->name('city.toggle');
        Route::get('city/upload', [App\Http\Controllers\Admin\CityController::class, 'upload'])->name('city.upload');

        // Pincode
        // Route::get('pincode', [App\Http\Controllers\Admin\PincodeController::class, 'index'])->name('pincode');
        Route::post('pincode/store', [App\Http\Controllers\Admin\PincodeController::class, 'store'])->name('pincode.store');
        Route::get('pincode/{id}/edit', [App\Http\Controllers\Admin\PincodeController::class, 'edit'])->name('pincode.edit');
        Route::patch('pincode/{id}', [App\Http\Controllers\Admin\PincodeController::class, 'update'])->name('pincode.update');
        Route::get('pincode/destroy/{id}', [App\Http\Controllers\Admin\PincodeController::class, 'destroy'])->name('pincode.destroy');
        Route::post('pincode/toggle/{id}', [App\Http\Controllers\Admin\PincodeController::class, 'toggle'])->name('pincode.toggle');
        Route::get('pincode/upload', [App\Http\Controllers\Admin\PincodeController::class, 'upload'])->name('pincode.upload');

        // Area Routes
        Route::get('area',[App\Http\Controllers\Admin\AreaController::class, 'getIndex'])->name('area');
        Route::get('area/list',[App\Http\Controllers\Admin\AreaController::class, 'getList'])->name('area.list');
        Route::get('area/create',[App\Http\Controllers\Admin\AreaController::class, 'getCreate'])->name('area.create.index');
        Route::post('area/create',[App\Http\Controllers\Admin\AreaController::class, 'postCreate'])->name('area.create');
        Route::get('area/update/{id?}',[App\Http\Controllers\Admin\AreaController::class, 'getUpdate'])->name('area.update.index');
        Route::post('area/update/{id?}',[App\Http\Controllers\Admin\AreaController::class, 'postUpdate'])->name('area.update');
        Route::get('area/delete/{id?}',[App\Http\Controllers\Admin\AreaController::class, 'getDelete'])->name('area.delete');
        Route::get('area/change/status/{id?}',[App\Http\Controllers\Admin\AreaController::class, 'getChangeStatus'])->name('area.change.status');
        //Area Imports
        Route::get('area/import-csv/',[App\Http\Controllers\Admin\AreaController::class, 'getCsvImport'])->name('area.import.csv.index');
        Route::get('area/import-csv/download/sample',[App\Http\Controllers\Admin\AreaController::class, 'getCsvImportSampleDownload'])->name('area.import.csv.download.sample');
        Route::post('area/import-csv/',[App\Http\Controllers\Admin\AreaController::class, 'postCsvImport'])->name('import.area.csv.process');
        // Route::post('area/import-csv/',[App\Http\Controllers\Admin\AreaController::class, 'postCsvImport'])->name('area.import.csv.data');

        Route::get('states/list/country_wise/{country_id?}',[App\Http\Controllers\Admin\AreaController::class, 'getCountryWiseList'])->name('states.country_wise.list');
        Route::get('cities/list/state_wise/{state_id?}',[App\Http\Controllers\Admin\AreaController::class, 'getStateWiseList'])->name('cities.state_wise.list');
        Route::get('pincodes/list/city_wise/{city_id?}',[App\Http\Controllers\Admin\AreaController::class, 'getCityWiseList'])->name('pincodes.city_wise.list');



        // Shipping Configuration
        Route::get('shipping-configuration', [App\Http\Controllers\HomeController::class, 'shippingConfig'])->name('shipping-configuration');
        Route::patch('shipping-configuration/{id}', [App\Http\Controllers\HomeController::class, 'shippingConfigUpdate'])->name('shipping-configuration.update');

        // General Configuration
        Route::get('general-configuration', [App\Http\Controllers\HomeController::class, 'generalConfig'])->name('general-configuration');
        Route::patch('general-configuration/{id}', [App\Http\Controllers\HomeController::class, 'generalConfigUpdate'])->name('general-configuration.update');

        // Payout Configuration
        Route::get('payout-configuration', [App\Http\Controllers\HomeController::class, 'payoutConfig'])->name('payout-configuration');
        Route::patch('payout-configuration/{id}', [App\Http\Controllers\HomeController::class, 'payoutConfigUpdate'])->name('payout-configuration.update');


        // tax
        // Route::get('tax', [App\Http\Controllers\HomeController::class, 'tax'])->name('tax');

        // Commission Configuration
        // Route::get('commission-configuration', [App\Http\Controllers\HomeController::class, 'commissionConfig'])->name('commission-configuration');
        // Route::patch('commission-configuration/{id}', [App\Http\Controllers\HomeController::class, 'commissionConfigUpdate'])->name('commission-configuration.update');

        // payouts
        Route::get('payouts', [App\Http\Controllers\Admin\PayoutController::class, 'index'])->name('payouts');
        Route::get('payouts/invoice/{id}', [App\Http\Controllers\Admin\PayoutController::class, 'invoice'])->name('payout.invoice');
        // payout request
        Route::get('payout-request', [App\Http\Controllers\Admin\PayoutController::class, 'payoutRequest'])->name('payout-request');
        Route::patch('payout-request/{id}', [App\Http\Controllers\Admin\PayoutController::class, 'update'])->name('payout-request.update');

        Route::post('payout/payment/{id}', [App\Http\Controllers\Admin\PayoutController::class, 'payment'])->name('payout.payment');


        // Sale
        Route::get('inhouse-product-sale', [App\Http\Controllers\Admin\SalesController::class, 'index'])->name('inhouse-product-sale');
        Route::get('seller-product-sale', [App\Http\Controllers\Admin\SalesController::class, 'sellerIndex'])->name('seller-product-sale');
        Route::get('commission-history', [App\Http\Controllers\Admin\SalesController::class, 'commissionHistory'])->name('commission-history');

        // testimonial
        Route::get('testimonial', [App\Http\Controllers\Admin\TestimonialController::class, 'index'])->name('testimonial');
        Route::get('testimonial/create', [App\Http\Controllers\Admin\TestimonialController::class, 'create'])->name('testimonial.create');
        Route::post('testimonial/store', [App\Http\Controllers\Admin\TestimonialController::class, 'store'])->name('testimonial.store');
        Route::get('testimonial/{id}/edit', [App\Http\Controllers\Admin\TestimonialController::class, 'edit'])->name('testimonial.edit');
        Route::patch('testimonial/{id}', [App\Http\Controllers\Admin\TestimonialController::class, 'update'])->name('testimonial.update');
        Route::get('testimonial/destroy/{id}', [App\Http\Controllers\Admin\TestimonialController::class, 'destroy'])->name('testimonial.destroy');
        Route::post('testimonial/toggle/{id}', [App\Http\Controllers\Admin\TestimonialController::class, 'toggle'])->name('testimonial.toggle');

        // Order
        Route::get('orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders');
        Route::get('order/detail/{id}', [App\Http\Controllers\Admin\OrderController::class, 'detail'])->name('order.detail');
        Route::get('order/invoice/{id}', [App\Http\Controllers\Admin\OrderController::class, 'invoice'])->name('order.invoice');
        Route::any('orders/filter', [App\Http\Controllers\Admin\OrderController::class, 'orderFilter'])->name('order.filter');
        Route::post('orders/status/{id}', [App\Http\Controllers\Admin\OrderController::class, 'orderStatus'])->name('order.status');
        //change kitchen in orderdetail
        Route::post('orders/seller/{id}', [App\Http\Controllers\Admin\OrderController::class, 'productPrice'])->name('order.seller');
        // Inhouse Order
        Route::get('inhouse-orders', [App\Http\Controllers\Admin\OrderController::class, 'inhouseIndex'])->name('inhouse-orders');

        // Seller Order
        Route::get('seller-orders', [App\Http\Controllers\Admin\OrderController::class, 'sellerIndex'])->name('seller-orders');


        // All Product
        // Route::get('product', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('product');
        Route::get('order/create', [App\Http\Controllers\Admin\OrderController::class, 'create'])->name('order.create');
        Route::post('order/store', [App\Http\Controllers\Admin\OrderController::class, 'store'])->name('order.store');
        Route::get('product/{id}/edit', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('product.edit');
        Route::patch('product/{id}', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('product.update');
        Route::get('product/destroy/{id}', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('product.destroy');
        Route::post('product/featuredToggle/{id}', [App\Http\Controllers\Admin\ProductController::class, 'featuredToggle'])->name('product.featuredToggle');
        Route::post('product/publishedToggle/{id}', [App\Http\Controllers\Admin\ProductController::class, 'publishedToggle'])->name('product.publishedToggle');

        // Review
        Route::get('reviews', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews');
        Route::get('review/change/{id}', [App\Http\Controllers\Admin\ReviewController::class, 'changeStatus'])->name('review.change');

        // Refund
        // Route::get('refunds', [App\Http\Controllers\Admin\RefundController::class, 'index'])->name('refunds');
        // Route::any('refunds/filter', [App\Http\Controllers\Admin\RefundController::class, 'refundsFilter'])->name('refunds.filter');
        // Route::get('refund/accept/{id}', [App\Http\Controllers\Admin\RefundController::class, 'accept'])->name('refund.accept');
        // Route::get('refund/reject/{id}', [App\Http\Controllers\Admin\RefundController::class, 'reject'])->name('refund.reject');

        // approved refund
        // Route::get('approved-refunds', [App\Http\Controllers\Admin\RefundController::class, 'approvedIndex'])->name('approved-refunds');

        // rejected refund
        // Route::get('rejected-refunds', [App\Http\Controllers\Admin\RefundController::class, 'rejectedIndex'])->name('rejected-refunds');

        // Refund Configuration
        // Route::get('refund-configuration', [App\Http\Controllers\HomeController::class, 'refundConfig'])->name('refund-configuration');
        // Route::patch('refund-configuration/{id}', [App\Http\Controllers\HomeController::class, 'refundConfigUpdate'])->name('refund-configuration.update');

        // Coupon
        Route::get('coupons', [App\Http\Controllers\Admin\CouponController::class, 'index'])->name('coupons');
        Route::get('coupon/create', [App\Http\Controllers\Admin\CouponController::class, 'create'])->name('coupon.create');
        Route::post('coupon/store', [App\Http\Controllers\Admin\CouponController::class, 'store'])->name('coupon.store');
        Route::get('coupon/{id}/edit', [App\Http\Controllers\Admin\CouponController::class, 'edit'])->name('coupon.edit');
        Route::patch('coupon/{id}', [App\Http\Controllers\Admin\CouponController::class, 'update'])->name('coupon.update');
        Route::get('coupon/destroy/{id}', [App\Http\Controllers\Admin\CouponController::class, 'destroy'])->name('coupon.destroy');
        Route::post('coupon/toggle/{id}', [App\Http\Controllers\Admin\CouponController::class, 'toggle'])->name('coupon.toggle');

        // Staff
        Route::get('staffs', [App\Http\Controllers\Admin\UserController::class, 'staffIndex'])->name('staffs');
        Route::get('staff/create', [App\Http\Controllers\Admin\UserController::class, 'staffCreate'])->name('staff.create');
        Route::post('staff/store', [App\Http\Controllers\Admin\UserController::class, 'staffStore'])->name('staff.store');
        Route::get('staff/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'staffEdit'])->name('staff.edit');
        Route::patch('staff/{id}', [App\Http\Controllers\Admin\UserController::class, 'staffUpdate'])->name('staff.update');

        // Route::get('seller-product-sale', [App\Http\Controllers\Admin\SalesController::class, 'sellerIndex'])->name('seller-product-sale');
        // Route::get('commission-history', [App\Http\Controllers\Admin\SalesController::class, 'commissionHistory'])->name('commission-history');

        // Permissions
        Route::get('staff-permissions', [App\Http\Controllers\Admin\UserController::class, 'staffPermissionIndex'])->name('staff-permissions');
        Route::get('staff-permission/create', [App\Http\Controllers\Admin\UserController::class, 'staffPermissionCreate'])->name('staff-permission.create');
        Route::post('staff-permission/store', [App\Http\Controllers\Admin\UserController::class, 'staffPermissionStore'])->name('staff-permission.store');
        Route::get('staff-permission/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'staffPermissionEdit'])->name('staff-permission.edit');
        Route::patch('staff-permission/{id}', [App\Http\Controllers\Admin\UserController::class, 'staffPermissionUpdate'])->name('staff-permission.update');
        Route::get('staff-permission/destroy/{id}', [App\Http\Controllers\Admin\UserController::class, 'staffPermissionDestroy'])->name('staff-permission.destroy');

        // Payment Gateway
        Route::get('gateways', [App\Http\Controllers\Admin\PaymentGatewayController::class, 'index'])->name('gateways');
        Route::patch('gateway/{id}', [App\Http\Controllers\Admin\PaymentGatewayController::class, 'update'])->name('gateway.update');



    });


// Seller
    Route::get('seller', [App\Http\Controllers\Seller\LoginController::class, 'sellerLogin'])->name('seller.login');
    Route::get('seller/login', [App\Http\Controllers\Seller\LoginController::class, 'sellerLogin'])->name('seller.login');
    Route::get('seller/register', [App\Http\Controllers\Seller\LoginController::class, 'sellerRegister'])->name('seller.register');

    Route::post('seller/registerUser', [App\Http\Controllers\Seller\LoginController::class, 'sellerRegisterUser'])->name('seller.registerUser');
    Route::post('seller/start', [App\Http\Controllers\Seller\LoginController::class, 'postLogin'])->name('seller.postLogin');

    Route::group(['as'=>'seller.','prefix'=>'seller','namespace'=>'Seller','middleware'=>['auth','seller']], function(){
        // Dashboard
        Route::get('dashboard', [App\Http\Controllers\Seller\DashboardController::class, 'index'])->name('dashboard');

        // Profile
        Route::get('profile', [App\Http\Controllers\Seller\UserController::class, 'index'])->name('profile');
        Route::get('profile/{id}/edit', [App\Http\Controllers\Seller\UserController::class, 'edit'])->name('profile.edit');
        Route::patch('profile/{id}', [App\Http\Controllers\Seller\UserController::class, 'allSellerUpdate'])->name('profile.update');
        Route::patch('profile/password/{id}', [App\Http\Controllers\Seller\UserController::class, 'allSellerPassUpdate'])->name('profile.passwordUpdate');
        Route::patch('profile/bank/{id}', [App\Http\Controllers\Seller\UserController::class, 'bankUpdate'])->name('profile.bankUpdate');
        Route::patch('profile/upi/{id}', [App\Http\Controllers\Seller\UserController::class, 'upiUpdate'])->name('profile.upiUpdate');
        Route::patch('profile/legal/{id}', [App\Http\Controllers\Seller\UserController::class, 'legalDocuments'])->name('profile.legalDocuments');
        Route::patch('profile/gst/{id}', [App\Http\Controllers\Seller\UserController::class, 'gstUpdate'])->name('profile.gstUpdate');

        // Product
        // Route::get('product', [App\Http\Controllers\Seller\ProductController::class, 'index'])->name('product');
        // Route::get('product/create', [App\Http\Controllers\Seller\ProductController::class, 'create'])->name('product.create');
        // Route::post('product/store', [App\Http\Controllers\Seller\ProductController::class, 'store'])->name('product.store');
        // Route::get('product/{id}/edit', [App\Http\Controllers\Seller\ProductController::class, 'edit'])->name('product.edit');
        // Route::patch('product/{id}', [App\Http\Controllers\Seller\ProductController::class, 'update'])->name('product.update');
        // Route::get('product/destroy/{id}', [App\Http\Controllers\Seller\ProductController::class, 'destroy'])->name('product.destroy');
        // Route::post('product/featuredToggle/{id}', [App\Http\Controllers\Seller\ProductController::class, 'featuredToggle'])->name('product.featuredToggle');
        // Route::post('product/publishedToggle/{id}', [App\Http\Controllers\Seller\ProductController::class, 'publishedToggle'])->name('product.publishedToggle');

        // Order
        Route::get('orders', [App\Http\Controllers\Seller\OrderController::class, 'index'])->name('orders');
        Route::get('order/detail/{id}', [App\Http\Controllers\Seller\OrderController::class, 'detail'])->name('order.detail');
        Route::get('order/invoice/{id}', [App\Http\Controllers\Seller\OrderController::class, 'invoice'])->name('order.invoice');
        Route::any('orders/filter', [App\Http\Controllers\Seller\OrderController::class, 'orderFilter'])->name('order.filter');
        Route::post('orders/status/{id}', [App\Http\Controllers\Seller\OrderController::class, 'orderStatus'])->name('order.status');

        // refund
        // Route::get('refunds', [App\Http\Controllers\Seller\RefundController::class, 'index'])->name('refunds');
        // Route::any('refunds/filter', [App\Http\Controllers\Seller\RefundController::class, 'refundsFilter'])->name('refunds.filter');
        // Route::get('refund/accept/{id}', [App\Http\Controllers\Seller\RefundController::class, 'accept'])->name('refund.accept');
        // Route::get('refund/reject/{id}', [App\Http\Controllers\Seller\RefundController::class, 'reject'])->name('refund.reject');

        // // approved refund
        // Route::get('approved-refunds', [App\Http\Controllers\Seller\RefundController::class, 'approvedIndex'])->name('approved-refunds');

        // // rejected refund
        // Route::get('rejected-refunds', [App\Http\Controllers\Seller\RefundController::class, 'rejectedIndex'])->name('rejected-refunds');

        // Sale
        Route::get('product-sales-report', [App\Http\Controllers\Seller\SalesController::class, 'index'])->name('product-sales-report');
        Route::get('commission-history', [App\Http\Controllers\Seller\SalesController::class, 'commissionHistory'])->name('commission-history');

        // payouts
        Route::get('payouts', [App\Http\Controllers\Seller\PayoutController::class, 'index'])->name('payouts');

        // payout request
        Route::get('payout-request', [App\Http\Controllers\Seller\PayoutController::class, 'payoutRequest'])->name('payout-request');
        Route::post('payout-request/store', [App\Http\Controllers\Seller\PayoutController::class, 'store'])->name('payout.store');

        // Review
        // Route::get('reviews', [App\Http\Controllers\Seller\ReviewController::class, 'index'])->name('reviews');

        // Support
        Route::get('support', function () {return view('seller.support.index');})->name('support');


        // Price-List
         Route::get('price-list', [App\Http\Controllers\Seller\UserController::class, 'kitchenPriceList'])->name('price-list');
    });

// Customer
    Route::group(['as'=>'customer.','prefix'=>'customer','namespace'=>'Customer','middleware'=>['auth','customer']], function(){
        // Accounts
        Route::get('account', [App\Http\Controllers\Customer\UserController::class, 'account'])->name('account');

        // Dashboard
        Route::get('dashboard', [App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('dashboard');
        // Order
        Route::get('order/show/{id}', [App\Http\Controllers\Customer\DashboardController::class, 'show'])->name('order.show');
        Route::get('order/cancel/{id}', [App\Http\Controllers\Customer\DashboardController::class, 'cancel'])->name('order.cancel');
        Route::get('order/cancelRefund/{id}', [App\Http\Controllers\Customer\DashboardController::class, 'cancelRefund'])->name('order.cancelRefund');
        Route::post('order/review/{id}', [App\Http\Controllers\Customer\DashboardController::class, 'review'])->name('order.review');
        Route::post('order/refund/{id}', [App\Http\Controllers\Customer\DashboardController::class, 'refund'])->name('order.refund');
        // profile
        Route::get('profile', [App\Http\Controllers\Customer\UserController::class, 'index'])->name('profile');
        Route::patch('profile/{id}', [App\Http\Controllers\Customer\UserController::class, 'update'])->name('profile.update');
        // address
        Route::get('address', [App\Http\Controllers\Customer\AddressController::class, 'index'])->name('address');
        Route::get('address/{id}/edit', [App\Http\Controllers\Customer\AddressController::class, 'edit'])->name('address.edit');
        Route::patch('address/{id}', [App\Http\Controllers\Customer\AddressController::class, 'update'])->name('address.update');
        Route::get('address/destroy/{id}', [App\Http\Controllers\Customer\AddressController::class, 'destroy'])->name('address.destroy');

        // Affiliate System
        Route::get('affiliate', [App\Http\Controllers\Customer\AffiliateController::class, 'index'])->name('affiliate.index');
        Route::get('affiliate/payment-history', [App\Http\Controllers\Customer\AffiliateController::class, 'paymentHistory'])->name('affiliate.payment');
        Route::get('affiliate/withdraw-request-history', [App\Http\Controllers\Customer\AffiliateController::class, 'withdrawRequest'])->name('affiliate.request');
    });
