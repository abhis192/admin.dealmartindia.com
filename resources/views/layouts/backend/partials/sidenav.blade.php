<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                @if(Request::is('admin*'))
                <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <a href="{{route('admin.dashboard')}}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-chat">Dashboard</span>
                    </a>
                </li>
                @if(Auth::user()->hasPermissionTo('customer_list'))
                <li class="{{ Request::is('admin/customers') ? 'active' : '' }}">
                    <a href="{{route('admin.customers')}}" class="waves-effect">
                        <i class="bx bx-user"></i>
                        <span key="t-chat">Customers</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->hasPermissionTo('seller_list'))
                <li>
                    {{-- "javascript: void(0);" --}}
                    <a href= "{{route('admin.all-sellers')}}" class=" waves-effect">
                        <i class="bx bx-restaurant"></i>
                        <span key="t-dashboards" >Kitchen</span>
                    </a>
                    {{-- <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.all-sellers')}}">All Seller</a></li>
                        <li><a href="{{route('admin.verified-sellers')}}">Verified Seller</a></li>
                        <li><a href="{{route('admin.unverified-sellers')}}">Unverified Seller</a></li>
                    </ul> --}}
                </li>
                @endif
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-shopping-bag"></i>
                        <span key="t-dashboards">Manage Store</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @if(Auth::user()->hasPermissionTo('product_list'))
                        <li><a href="{{route('admin.product')}}">All Product</a></li>
                        {{-- <li><a href="{{route('admin.inhouse-product')}}">In House Products</a></li> --}}
                        {{-- <li><a href="{{route('admin.seller-product')}}">Seller Products</a></li> --}}
                        @endif
                        <li><a href="{{route('admin.bulk-prices')}}">Bulk Price Setup</a></li>
                        @if(Auth::user()->hasPermissionTo('category_list'))
                        <li><a href="{{route('admin.product-category')}}">Product Category</a></li>
                        @endif
                        @if(Auth::user()->hasPermissionTo('type_list'))
                        <li><a href="{{route('admin.product-type')}}">Product Type</a></li>
                        @endif

                        @if(Auth::user()->hasPermissionTo('type_list'))
                        <li><a href="{{route('admin.cake-flavour')}}">Cake Flavour</a></li>
                        @endif
                        {{-- @if(Auth::user()->hasPermissionTo('brands_list'))
                        <li><a href="{{route('admin.product-brand')}}">Brands</a></li>
                        @endif --}}
                        @if(Auth::user()->hasPermissionTo('attributes_list'))
                        <li class="d-none"><a href="{{route('admin.product-attribute')}}">Attribute</a></li>
                        @endif
                        @if(Auth::user()->hasPermissionTo('coupon_list'))
                        <li><a href="{{route('admin.coupons')}}">Coupons</a></li>
                        @endif
                    </ul>
                </li>


                @if(Auth::user()->hasPermissionTo('shipping_list'))
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-truck"></i>
                        <span key="t-dashboards">Manage Delivery Opt</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.deliveryoption')}}">Delivery Option</a></li>
                        <li><a href="{{route('admin.slot')}}">Time Slot</a></li>
                        {{-- <li><a href="{{route('admin.city')}}">Cities</a></li> --}}
                        {{-- <li><a href="{{route('admin.pincode')}}">PIN Code</a></li> --}}
                        {{-- <li><a href="{{route('admin.area')}}">Area</a></li> --}}
                        {{-- <li><a href="{{route('admin.shipping-configuration')}}">Shipping Configuration</a></li> --}}
                    </ul>
                </li>
                @endif

                @if(Auth::user()->hasPermissionTo('shipping_list'))
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-map"></i>
                        <span key="t-dashboards">Location</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.country')}}">Countries</a></li>
                        <li><a href="{{route('admin.state')}}">States</a></li>
                        <li><a href="{{route('admin.city')}}">Cities</a></li>
                        <li><a href="{{route('admin.pincode')}}">PIN Code</a></li>
                        <li><a href="{{route('admin.area')}}">Area</a></li>
                        {{-- <li><a href="{{route('admin.shipping-configuration')}}">Shipping Configuration</a></li> --}}
                    </ul>
                </li>
                @endif
                @if(Auth::user()->hasPermissionTo('order_list'))
                <li>
                    {{-- <a href="javascript: void(0);" class="has-arrow waves-effect"> --}}
                    <a href="{{route('admin.orders')}}" class=" waves-effect">
                        <i class="bx bx-shopping-bag"></i>
                        <span key="t-dashboards">Manage Orders</span>
                    </a>
                    {{-- <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.orders')}}">All Orders</a></li>
                        <li><a href="{{route('admin.inhouse-orders')}}">Inhouse orders</a></li>
                        <li><a href="{{route('admin.seller-orders')}}">Seller orders</a></li>
                    </ul> --}}
                </li>
                @endif
                {{-- @if(Auth::user()->hasPermissionTo('refund_list'))
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-transfer-alt"></i>
                        <span key="t-dashboards">Refunds</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.refunds')}}">Refund Requests</a></li>
                        <li><a href="{{route('admin.approved-refunds')}}">Approved Refunds</a></li>
                        <li><a href="{{route('admin.rejected-refunds')}}">Rejected Refunds</a></li>
                        <li><a href="{{route('admin.refund-configuration')}}">Refund Configuration</a></li>
                    </ul>
                </li>
                @endif --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-globe"></i>
                        <span key="t-dashboards">Appearance</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @if(Auth::user()->hasPermissionTo('page_list'))
                        <li><a href="{{route('admin.pages')}}">Pages</a></li>
                        @endif
                        @if(Auth::user()->hasPermissionTo('page_list'))
                        <li><a href="{{route('admin.home-page')}}">Home Page</a></li>
                        @endif
                        @if(Auth::user()->hasPermissionTo('banner_list'))
                        <li><a href="{{route('admin.banners')}}">Home Banner</a></li>
                        @endif
                        @if(Auth::user()->hasPermissionTo('testimonial_list'))
                        <li><a href="{{route('admin.testimonial')}}">Testimonials</a></li>
                        @endif

                    </ul>
                </li>
                @if(Auth::user()->hasPermissionTo('payout_list'))
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-money"></i>
                        <span key="t-dashboards">Payout</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.payouts')}}">All Payouts</a></li>
                        {{-- <li><a href="{{route('admin.payout-request')}}">Payout Requests</a></li> --}}
                        {{-- <li><a href="{{route('admin.commission-configuration')}}">Commission Config</a></li> --}}
                        <li><a href="{{route('admin.payout-configuration')}}">Payout Config</a></li>
                    </ul>
                </li>
                @endif
                @if(Auth::user()->hasPermissionTo('report_list'))
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-file"></i>
                        <span key="t-dashboards">Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        {{-- <li><a href="{{route('admin.inhouse-product-sale')}}">In House Product Sale</a></li> --}}
                        {{-- <li><a href="{{route('admin.seller-product-sale')}}">Seller Product Sale</a></li> --}}
                        <li><a href="{{route('admin.seller-product-sale')}}">Order Sales Report</a></li>
                        {{-- <li><a href="{{route('admin.commission-history')}}">Commission History</a></li> --}}
                    </ul>
                </li>
                @endif
                @if(Auth::user()->hasPermissionTo('staff_list'))
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-dashboards">Staff</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.staffs')}}">All Staff</a></li>
                        <li><a href="{{route('admin.staff-permissions')}}">Staff Permissions</a></li>
                    </ul>
                </li>
                @endif
                @if(Auth::user()->hasPermissionTo('review_list'))
                <li>
                    <a href="{{route('admin.reviews')}}" class="waves-effect">
                        <i class="bx bx-star"></i>
                        @if(dashboardReviewCount() > 1)
                        <span class="badge rounded-pill bg-danger float-end">{{dashboardReviewCount()}}</span>
                        @endif
                        <span key="t-chat">Reviews</span>
                    </a>
                </li>
                @endif
                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-link"></i>
                        <span key="t-dashboards">Affiliate System</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.affiliate-users')}}">Affiliate Users</a></li>
                        <li><a href="{{route('admin.referral-users')}}">Refferal Users</a></li>
                        <li><a href="{{route('admin.affiliate-log')}}">Affiliate Logs</a></li>
                        <li><a href="{{route('admin.affiliate-configuration')}}">Affiliate Configurations</a></li>
                        <li><a href="{{route('admin.affiliate-request')}}">Affiliate Withdraw Requests</a></li>
                    </ul>
                </li>  --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-cog"></i>
                        <span key="t-dashboards">System Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.general-configuration')}}">General Settings</a></li>
                        {{-- <li><a href="{{route('admin.tax')}}">Tax Settings</a></li> --}}
                        <!-- <li><a href="#">Vat & TAX</a></li>    -->
                        <li><a href="{{route('admin.gateways')}}">Payment Gateway</a></li>

                        <li><a href="{{route('admin.kitchen-price')}}">Kitchen Price</a></li>

                        <li><a href="{{route('admin.kitchenPrice-Config')}}">Kitchen Price Config</a></li>

                        <!-- <li><a href="#">Order Configuration</a></li>
                        <li><a href="#">Login Configuration</a></li>    -->
                    </ul>
                </li>
                @endif



                @if(Request::is('seller*'))
                <li class="{{ Request::is('seller/dashboard') ? 'active' : '' }}">
                    <a href="{{route('seller.dashboard')}}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-chat">Dashboard</span>
                    </a>
                </li>
                <li class="{{ Request::is('seller/profile') ? 'active' : '' }}">
                    <a href="{{route('seller.profile')}}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-chat">Profile</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-shopping-bag"></i>
                        <span key="t-dashboards">Manage Store</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('seller.product')}}">All Product</a></li>
                        @if(Auth::user()->seller_verified_at)
                        <li><a href="{{route('seller.product.create')}}">Add New Product</a></li>
                        @endif
                    </ul>
                </li> --}}

                <li class="{{ Request::is('seller/order') ? 'active' : '' }}">
                    <a href="{{route('seller.orders')}}" class="waves-effect">
                        <i class="bx bx-shopping-bag"></i>
                        <!-- <span class="badge rounded-pill bg-success float-end">3</span> -->
                        <span key="t-chat">Manage Orders</span>
                    </a>
                </li>
                {{-- <li><a href="{{route('seller.kitchenPrice-List')}}">Price List</a></li> --}}
                <li class="{{ Request::is('seller/order') ? 'active' : '' }}">
                    <a href="{{route('seller.price-list')}}" class="waves-effect">
                        <i class="bx bx-shopping-bag"></i>
                        <!-- <span class="badge rounded-pill bg-success float-end">3</span> -->
                        <span key="t-chat">Price List</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-transfer-alt"></i>
                        <span key="t-dashboards">Refunds</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">

                        <li><a href="{{route('seller.refunds')}}">Refund Requests <span class="badge rounded-pill bg-danger float-end">1</span></a></li>
                        <li><a href="{{route('seller.approved-refunds')}}">Approved Refunds</a></li>
                        <li><a href="{{route('seller.rejected-refunds')}}">Rejected Refunds</a></li>
                    </ul>
                </li> --}}

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-money"></i>
                        <span key="t-dashboards">Payout</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('seller.payouts')}}">All Payouts</a></li>
                        {{-- <li><a href="{{route('seller.payout-request')}}">Withdraw Amount</a></li> --}}
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-file"></i>
                        <span key="t-dashboards">Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        {{-- <li><a href="{{route('seller.product-sales-report')}}">Product Sale Report</a></li> --}}
                        {{-- <li><a href="{{route('seller.commission-history')}}">Commission History</a></li> --}}
                    </ul>
                </li>

                {{-- <!-- <li class="{{ Request::is('seller/reviews') ? 'active' : '' }}"> --}}
                    {{-- <a href="{{route('seller.reviews')}}" class="waves-effect"> --}}
                        {{-- <i class="bx bx-star"></i>
                        <span class="badge rounded-pill bg-danger float-end">3</span>
                        <span key="t-chat">Reviews</span>
                    </a>
                </li>  --> --}}

                <li class="{{ Request::is('seller/support') ? 'active' : '' }}">
                    <a href="{{route('seller.support')}}" class="waves-effect">
                        <i class="bx bx-support"></i>
                        <span key="t-chat">Support</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="bx bx-power-off"></i> <span key="t-logout">Logout</span>
                    </a>
                </li>
                @endif

                @if(Request::is('customer*'))
                @endif
            </ul>
        </div>
    </div>
</div>
