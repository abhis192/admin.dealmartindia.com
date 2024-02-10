@extends('layouts.backend.app')

@section('title')
<title>Add Staff Permissions | Admin</title>
@endsection

@section('css')
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- [ breadcrumb ] start -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Add Staff Permission</h4>

                    <div class="page-title-right">
                        <a href="{{route('admin.staff-permissions')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-reply-all"></i> Back to list</a>
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-12">

                <form action="{{route('admin.staff-permission.store')}}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Staff Permission Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Staff Permission Name <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter your full name..." required/>
                                            </div>
                                            @error('name')
                                                <div class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div>
                            <!-- end card -->

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Set Staff Permission</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table id="" class="table table-bordered nowrap w-100">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Menu</th>
                                                        <th class="col-1">List</th>
                                                        <th class="col-1">Add</th>
                                                        <th class="col-1">Edit</th>
                                                        <th class="col-1">Delete</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr>
                                                        <td>Customers</td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="customer_list" id="customers-switch1" switch="status" checked/>
                                                                <label for="customers-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td> </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="customer_edit" id="customers-switch2" switch="status" checked/>
                                                                <label for="customers-switch2" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="customer_delete" id="customers-switch3" switch="status" checked/>
                                                                <label for="customers-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Seller</td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="seller_list" id="seller-switch1" switch="status" checked/>
                                                                <label for="seller-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td> </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="seller_edit" id="seller-switch2" switch="status" checked/>
                                                                <label for="seller-switch2" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="seller_delete" id="seller-switch3" switch="status"  checked/>
                                                                <label for="seller-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    {{-- <tr>
                                                        <td>Shipping</td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="shipping_list" id="shipping-switch1" switch="status" checked/>
                                                                <label for="shipping-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="shipping_add" id="shipping-switch2" switch="status" checked />
                                                                <label for="shipping-switch2" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="shipping_edit" id="shipping-switch3" switch="status" checked/>
                                                                <label for="shipping-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="shipping_delete" id="shipping-switch4" switch="status" checked />
                                                                <label for="shipping-switch4" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                    </tr>    --}}
                                                    {{-- <tr>
                                                        <td>Order</td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="order_list" id="order-switch1" switch="status" checked/>
                                                                <label for="order-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="order_add" id="order-switch2" switch="status" checked />
                                                                <label for="order-switch2" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="order_edit" id="order-switch3" switch="status" checked/>
                                                                <label for="order-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="order_delete" id="order-switch4" switch="status" checked />
                                                                <label for="order-switch4" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                    </tr> --}}
                                                    {{-- <tr>
                                                        <td>Refund</td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="refund_list" id="refund-switch1" switch="status" checked/>
                                                                <label for="refund-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="refund_add" id="refund-switch2" switch="status" checked />
                                                                <label for="refund-switch2" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="refund_edit" id="refund-switch3" switch="status" checked/>
                                                                <label for="refund-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="refund_delete" id="refund-switch4" switch="status" checked />
                                                                <label for="refund-switch4" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                    </tr> --}}

                                                    {{-- <tr>
                                                        <td>Payout</td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="payout_list" id="payout-switch1" switch="status" checked/>
                                                                <label for="payout-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="payout_add" id="payout-switch2" switch="status" checked />
                                                                <label for="payout-switch2" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="payout_edit" id="payout-switch3" switch="status" checked/>
                                                                <label for="payout-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="payout_delete" id="payout-switch4" switch="status" checked />
                                                                <label for="payout-switch4" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                    </tr> --}}
                                                    {{-- <tr>
                                                        <td>Report</td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="report_list" id="report-switch1" switch="status" checked/>
                                                                <label for="report-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="report_add" id="report-switch2" switch="status" checked />
                                                                <label for="report-switch2" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="report_edit" id="report-switch3" switch="status" checked/>
                                                                <label for="report-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="report_delete" id="report-switch4" switch="status" checked />
                                                                <label for="report-switch4" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                    </tr> --}}
                                                    {{-- <tr>
                                                        <td>Staff</td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="staff_list" id="staff-switch1" switch="status" checked/>
                                                                <label for="staff-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="staff_add" id="staff-switch2" switch="status" checked />
                                                                <label for="staff-switch2" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="staff_edit" id="staff-switch3" switch="status" checked/>
                                                                <label for="staff-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="staff_delete" id="staff-switch4" switch="status" checked />
                                                                <label for="staff-switch4" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                    </tr> --}}
                                                    {{-- <tr>
                                                        <td>Review</td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="review_list" id="review-switch1" switch="status" checked/>
                                                                <label for="review-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="review_add" id="review-switch2" switch="status" checked />
                                                                <label for="review-switch2" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="review_edit" id="review-switch3" switch="status" checked/>
                                                                <label for="review-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="review_delete" id="review-switch4" switch="status" checked />
                                                                <label for="review-switch4" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                    </tr> --}}

                                                    <tr class="table-light">
                                                        <th colspan="5">Manage Store</th>
                                                    </tr>
                                                    <tr>
                                                        <td>Products</td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="product_list" id="product-switch1" switch="status" checked/>
                                                                <label for="product-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="product_add" id="product-switch2" switch="status" checked/>
                                                                <label for="product-switch2" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="product_edit" id="product-switch3" switch="status"checked/>
                                                                <label for="product-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="product_delete" id="product-switch4" switch="status" checked/>
                                                                <label for="product-switch4" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Product Category</td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="category_list" id="category-switch1" switch="status" checked/>
                                                                <label for="category-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="category_add" id="category-switch2" switch="status"  checked/>
                                                                <label for="category-switch2" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="category_edit" id="category-switch3" switch="status" checked/>
                                                                <label for="category-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="category_delete" id="category-switch4" switch="status"  checked/>
                                                                <label for="category-switch4" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Product Type</td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="type_list" id="type-switch1" switch="status" checked/>
                                                                <label for="type-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="type_add" id="type-switch2" switch="status"  checked/>
                                                                <label for="type-switch2" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="type_edit" id="type-switch3" switch="status" checked/>
                                                                <label for="type-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="type_delete" id="type-switch4" switch="status"  checked/>
                                                                <label for="type-switch4" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    {{-- <tr>
                                                        <td>Brands</td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="brands_list" id="brand-switch1" switch="status" checked/>
                                                                <label for="brand-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="brands_add" id="brand-switch2" switch="status"  checked/>
                                                                <label for="brand-switch2" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="brands_edit" id="brand-switch3" switch="status" checked/>
                                                                <label for="brand-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="brands_delete" id="brand-switch4" switch="status"  checked/>
                                                                <label for="brand-switch4" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                    </tr> --}}
                                                    {{-- <tr>
                                                        <td>Attributes</td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="attributes_list" id="attribute-switch1" switch="status" checked/>
                                                                <label for="attribute-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="attributes_add" id="attribute-switch2" switch="status" checked/>
                                                                <label for="attribute-switch2" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="attributes_edit" id="attribute-switch3" switch="status" checked/>
                                                                <label for="attribute-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="attributes_delete" id="attribute-switch4" switch="status" checked />
                                                                <label for="attribute-switch4" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                    </tr> --}}
                                                    <tr>
                                                        <td>Coupon</td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="coupon_list" id="coupon-switch1" switch="status" checked/>
                                                                <label for="coupon-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="coupon_add" id="coupon-switch2" switch="status" checked />
                                                                <label for="coupon-switch2" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="coupon_edit" id="coupon-switch3" switch="status" checked/>
                                                                <label for="coupon-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="coupon_delete" id="coupon-switch4" switch="status" checked />
                                                                <label for="coupon-switch4" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="table-light">
                                                        <th colspan="5">Appearance</th>
                                                    </tr>
                                                    <tr>
                                                        <td>Banner</td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="banner_list" id="banner-switch1" switch="status" checked/>
                                                                <label for="banner-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="banner_add" id="banner-switch2" switch="status" checked />
                                                                <label for="banner-switch2" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="banner_edit" id="banner-switch3" switch="status" checked/>
                                                                <label for="banner-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="banner_delete" id="banner-switch4" switch="status" checked />
                                                                <label for="banner-switch4" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Testimonial</td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="testimonial_list" id="testimonial-switch1" switch="status" checked/>
                                                                <label for="testimonial-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="testimonial_add" id="testimonial-switch2" switch="status" checked />
                                                                <label for="testimonial-switch2" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="testimonial_edit" id="testimonial-switch3" switch="status" checked/>
                                                                <label for="testimonial-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="testimonial_delete" id="testimonial-switch4" switch="status" checked />
                                                                <label for="testimonial-switch4" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Page</td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="page_list" id="page-switch1" switch="status" checked/>
                                                                <label for="page-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="page_add" id="page-switch2" switch="status" checked />
                                                                <label for="page-switch2" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="page_edit" id="page-switch3" switch="status" checked/>
                                                                <label for="page-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="page_delete" id="page-switch4" switch="status" checked />
                                                                <label for="page-switch4" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="table-light">
                                                        <th colspan="5">Setting</th>
                                                    </tr>
                                                    <tr>
                                                        <td>General</td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="general_list" id="general-switch1" switch="status" checked/>
                                                                <label for="general-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="general_add" id="general-switch2" switch="status" checked/>
                                                                <label for="general-switch2" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="general_edit" id="general-switch3" switch="status" checked />
                                                                <label for="general-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="general_delete" id="general-switch4" switch="status" checked />
                                                                <label for="general-switch4" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tax</td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="tax_list" id="tax-switch1" switch="status" checked/>
                                                                <label for="tax-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="tax_add" id="tax-switch2" switch="status" checked/>
                                                                <label for="tax-switch2" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="tax_edit" id="tax-switch3" switch="status" checked />
                                                                <label for="tax-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="tax_delete" id="tax-switch4" switch="status" checked />
                                                                <label for="tax-switch4" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Payment</td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="payment_list" id="payment-switch1" switch="status" checked/>
                                                                <label for="payment-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="payment_add" id="payment-switch2" switch="status" checked/>
                                                                <label for="payment-switch2" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="payment_edit" id="payment-switch3" switch="status" checked/>
                                                                <label for="payment-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="square-switch">
                                                                <input type="checkbox" name="payment_delete" id="payment-switch4" switch="status" checked/>
                                                                <label for="payment-switch4" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card -->

                        </div>

                        <div class="col-lg-12">
                            <div class="card action-btn text-end">
                                <div class="card-body p-2">
                                    <!-- <button type="reset" class="btn btn-warning waves-effect waves-light">Clear</button> -->
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>

            </div> <!-- end col -->
        </div> <!-- end row -->


    </div>
    <!-- container-fluid -->
</div>
@endsection
