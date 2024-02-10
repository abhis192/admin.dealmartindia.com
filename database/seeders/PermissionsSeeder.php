<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve the 'admin' role
        $adminRole = Role::where('slug', 'admin')->first();

        // Define permissions
        $permissions = [
            ['name' => 'Customer List', 'slug' => 'customer_list'],
            ['name' => 'Customer Edit', 'slug' => 'customer_edit'],
            ['name' => 'Customer Delete', 'slug' => 'customer_delete'],
            ['name' => 'Seller List', 'slug' => 'seller_list'],
            ['name' => 'Seller Edit', 'slug' => 'seller_edit'],
            ['name' => 'Seller Delete', 'slug' => 'seller_delete'],
            ['name' => 'Product List', 'slug' => 'product_list'],
            ['name' => 'Product Add', 'slug' => 'product_add'],
            ['name' => 'Product Edit', 'slug' => 'product_edit'],
            ['name' => 'Product Delete', 'slug' => 'product_delete'],            
            ['name' => 'Category List', 'slug' => 'category_list'],
            ['name' => 'Category Add', 'slug' => 'category_add'],
            ['name' => 'Category Edit', 'slug' => 'category_edit'],
            ['name' => 'Category Delete', 'slug' => 'category_delete'],
            ['name' => 'Type List', 'slug' => 'type_list'],
            ['name' => 'Type Add', 'slug' => 'type_add'],
            ['name' => 'Type Edit', 'slug' => 'type_edit'],
            ['name' => 'Type Delete', 'slug' => 'type_delete'],
            ['name' => 'Brands List', 'slug' => 'brands_list'],
            ['name' => 'Brands Add', 'slug' => 'brands_add'],
            ['name' => 'Brands Edit', 'slug' => 'brands_edit'],
            ['name' => 'Brands Delete', 'slug' => 'brands_delete'],
            ['name' => 'Attribute List', 'slug' => 'attributes_list'],
            ['name' => 'Attribute Add', 'slug' => 'attributes_add'],
            ['name' => 'Attribute Edit', 'slug' => 'attributes_edit'],
            ['name' => 'Attribute Delete', 'slug' => 'attributes_delete'],
            ['name' => 'Coupon List', 'slug' => 'coupon_list'],
            ['name' => 'Coupon Add', 'slug' => 'coupon_add'],
            ['name' => 'Coupon Edit', 'slug' => 'coupon_edit'],
            ['name' => 'Coupon Delete', 'slug' => 'coupon_delete'],

            ['name' => 'Shipping List', 'slug' => 'shipping_list'],
            ['name' => 'Shipping Add', 'slug' => 'shipping_add'],
            ['name' => 'Shipping Edit', 'slug' => 'shipping_edit'],
            ['name' => 'Shipping Delete', 'slug' => 'shipping_delete'],
            ['name' => 'Order List', 'slug' => 'order_list'],
            ['name' => 'Order Add', 'slug' => 'order_add'],
            ['name' => 'Order Edit', 'slug' => 'order_edit'],
            ['name' => 'Order Delete', 'slug' => 'order_delete'],
            ['name' => 'Refund List', 'slug' => 'refund_list'],
            ['name' => 'Refund Add', 'slug' => 'refund_add'],
            ['name' => 'Refund Edit', 'slug' => 'refund_edit'],
            ['name' => 'Refund Delete', 'slug' => 'refund_delete'],
            ['name' => 'Banner List', 'slug' => 'banner_list'],
            ['name' => 'Banner Add', 'slug' => 'banner_add'],
            ['name' => 'Banner Edit', 'slug' => 'banner_edit'],
            ['name' => 'Banner Delete', 'slug' => 'banner_delete'],
            ['name' => 'Testimonial List', 'slug' => 'testimonial_list'],
            ['name' => 'Testimonial Add', 'slug' => 'testimonial_add'],
            ['name' => 'Testimonial Edit', 'slug' => 'testimonial_edit'],
            ['name' => 'Testimonial Delete', 'slug' => 'testimonial_delete'],
            ['name' => 'Page List', 'slug' => 'page_list'],
            ['name' => 'Page Add', 'slug' => 'page_add'],
            ['name' => 'Page Edit', 'slug' => 'page_edit'],
            ['name' => 'Page Delete', 'slug' => 'page_delete'],
            ['name' => 'Payout List', 'slug' => 'payout_list'],
            ['name' => 'Payout Add', 'slug' => 'payout_add'],
            ['name' => 'Payout Edit', 'slug' => 'payout_edit'],
            ['name' => 'Payout Delete', 'slug' => 'payout_delete'],
            ['name' => 'Report List', 'slug' => 'report_list'],
            ['name' => 'Report Add', 'slug' => 'report_add'],
            ['name' => 'Report Edit', 'slug' => 'report_edit'],
            ['name' => 'Report Delete', 'slug' => 'report_delete'],
            ['name' => 'Staff List', 'slug' => 'staff_list'],
            ['name' => 'Staff Add', 'slug' => 'staff_add'],
            ['name' => 'Staff Edit', 'slug' => 'staff_edit'],
            ['name' => 'Staff Delete', 'slug' => 'staff_delete'],
            ['name' => 'Review List', 'slug' => 'review_list'],
            ['name' => 'Review Add', 'slug' => 'review_add'],
            ['name' => 'Review Edit', 'slug' => 'review_edit'],
            ['name' => 'Review Delete', 'slug' => 'review_delete'],
            ['name' => 'General List', 'slug' => 'general_list'],
            ['name' => 'General Add', 'slug' => 'general_add'],
            ['name' => 'General Edit', 'slug' => 'general_edit'],
            ['name' => 'General Delete', 'slug' => 'general_delete'],
            ['name' => 'Tax List', 'slug' => 'tax_list'],
            ['name' => 'Tax Add', 'slug' => 'tax_add'],
            ['name' => 'Tax Edit', 'slug' => 'tax_edit'],
            ['name' => 'Tax Delete', 'slug' => 'tax_delete'],
            ['name' => 'Payment List', 'slug' => 'payment_list'],
            ['name' => 'Payment Add', 'slug' => 'payment_add'],
            ['name' => 'Payment Edit', 'slug' => 'payment_edit'],
            ['name' => 'Payment Delete', 'slug' => 'payment_delete'],
        ];

        foreach ($permissions as $permissionData) {
            // Create permission
            $permission = Permission::create($permissionData);

            // Attach permission to 'admin' role
            $adminRole->permissions()->attach($permission);
        }
    }
}
