<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numberOfUsers = \DB::table('users')->count();
        $numberOfBanners = \DB::table('banners')->count();
        $numberOfTypes = \DB::table('types')->count();
        // $numberOfBrands = \DB::table('brands')->count();
        $numberOfCategories = \DB::table('categories')->count();
        $numberOfConfigShippings = \DB::table('config_shippings')->count();

        $numberOfPaymentGateways = \DB::table('payment_gateways')->count();

        $numberOfConfigGenerals = \DB::table('config_generals')->count();
        // $numberOfConfigCommissions = \DB::table('config_commissions')->count();
        // $numberOfConfigRefunds = \DB::table('config_refunds')->count();
        $numberOfHomePages = \DB::table('home_pages')->count();
        $numberOfConfigPayouts = \DB::table('config_payouts')->count();

        $numberOfCountries = \DB::table('countries')->count();
        $numberOfStates = \DB::table('states')->count();
        $numberOfCities = \DB::table('cities')->count();
        $numberOfPincodes = \DB::table('pincodes')->count();

        // user
        if($numberOfUsers == 0) {
            DB::table('users')->insert([
                'role_id' => '1',
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'mobile' => '1234567891',
                'password' => bcrypt('admin@123'),
                'avatar' => 'default.png',
                'email_verified_at' => carbon::now(),
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);

            DB::table('users')->insert([
                'role_id' => '2',
                'name' => 'Kitchen',
                'email' => 'kitchen@gmail.com',
                'mobile' => '1234567892',
                'password' => bcrypt('kitchen@123'),
                'avatar' => 'default.png',
                'business' => 'Shop Name',
                'email_verified_at' => carbon::now(),
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);

            DB::table('users')->insert([
                'role_id' => '3',
                'name' => 'Customer',
                'email' => 'customer@gmail.com',
                'mobile' => '1234567893',
                'password' => bcrypt('customer@123'),
                'avatar' => 'default.png',
                'email_verified_at' => carbon::now(),
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);
        }

        // banner
        if($numberOfBanners == 0) {
            DB::table('banners')->insert([
                'name' => 'Banner 1',
                'url' => '',
                'description' => null,
                'desktop' => 'default.jpg',
                'mobile' => 'default.jpg',
                'status' => 1,
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);
            DB::table('banners')->insert([
                'name' => 'Banner 2',
                'url' => '',
                'description' => '',
                'desktop' => 'default.jpg',
                'mobile' => 'default.jpg',
                'status' => 1,
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);
        }

        // type
        if($numberOfTypes == 0) {
            DB::table('types')->insert([
                'name' => 'Type 1',
                'slug' => 'type-1',
                'description' => null,
                'order' => 1,
                'image' => 'default.jpg',
                'icon' => 'default.png',
                'status' => 1,
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);
        }

        // Brand
        // if($numberOfBrands == 0) {
        //     DB::table('brands')->insert([
        //         'name' => 'Brand 1',
        //         'slug' => 'brand-1',
        //         'description' => null,
        //         'order' => 1,
        //         'image' => 'default-brand-image.jpg',
        //         'status' => 1,
        //         'created_at' => carbon::now(),
        //         'updated_at' => carbon::now()
        //     ]);
        // }

        // category
        if($numberOfCategories == 0) {
            DB::table('categories')->insert([
                'name' => 'Category 1',
                'slug' => 'category-1',
                'description' => null,
                'parent_category_id' => null,
                'type_id' => 1,
                'order' => 1,
                'image' => 'default.jpg',
                'icon' => 'default.png',
                'status' => 1,
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);
        }

        // ConfigShippings
        if($numberOfConfigShippings == 0) {
            DB::table('config_shippings')->insert([
                'free_shipping_status' => 1,
                'min_order_to_ship' => 499.00,
                'universal_ship_status' => 1,
                'universal_ship_cost' => 49.00,
                'universal_shipping_days'=> 1,
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);
        }

        // ConfigGeneral
        if($numberOfConfigGenerals == 0) {
            DB::table('config_generals')->insert([
                'site_name' => 'DealMartIndia',
                'site_email' => 'test@gmail.com',
                'email' => 'test@gmail.com',
                'mobile' => '8880008888',
                'address' => 'test address',
                'facebook' => null,
                'instagram' => null,
                'twitter' => null,
                'linkedin' => null,
                'meta_title' => null,
                'meta_keywords' => null,
                'meta_description' => null,
                'topbar_header' => 1,
                'logo' => 'logo.png',
                'icon' => 'favicon.png',
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);
        }

        // ConfigCommissions
        // if($numberOfConfigCommissions == 0) {
        //     DB::table('config_commissions')->insert([
        //         'seller_commission_status' => 1,
        //         'seller_commission' => 10,
        //         'min_seller_withdraw' => 2500,
        //         'created_at' => carbon::now(),
        //         'updated_at' => carbon::now()
        //     ]);
        // }

        // ConfigRefund
        // if($numberOfConfigRefunds == 0) {
        //     DB::table('config_refunds')->insert([
        //         'refund_time' => 7,
        //         'created_at' => carbon::now(),
        //         'updated_at' => carbon::now()
        //     ]);
        // }

        //Payment Gateways

        if($numberOfPaymentGateways == 0) {
            DB::table('payment_gateways')->insert([
                'name' => 'razorpay',
                'business_name' => null,
                'key' => 'rzp_test_0Ihgj1t3Jmwv3i',
                'secret' => 'piiprWZVvVrvufeEfTdBYWxW',
                'status'=> 1,
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);
        }
        // HomePages
        if($numberOfHomePages == 0) {
            DB::table('home_pages')->insert([
                'section_1' => 'default.jpg',
                'section_2' => '1',
                'section_3' => '1',
                'section_4' => 'default.jpg',
                'section_5' => 'default.jpg',
                'section_6' => '1',
                'section_7' => '1',
                'section_8' => 'default.jpg',
                'section_9' => 'default.jpg',
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);
        }


        if($numberOfConfigPayouts == 0) {
            DB::table('config_payouts')->insert([
                'payout_status' => '1',
                'payout_calculation_date' => '15',
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);
        }

        if($numberOfCountries == 0) {
            DB::table('countries')->insert([
                'name' => 'India',
                'status' => '1',
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);
        }

        if($numberOfStates == 0) {
            DB::table('states')->insert([
                'name' => 'Uttar Pradesh',
                'country_id' => '1',
                'status' => '1',
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);
        }

        if($numberOfCities == 0) {
            DB::table('cities')->insert([
                'name' => 'Noida',
                'state_id' => '1',
                'status' => '1',
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);
        }

        if($numberOfPincodes == 0) {
            DB::table('pincodes')->insert([
                'name' => '201010',
                'city_id' => '1',
                'status' => '1',
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);
        }
    }
}
