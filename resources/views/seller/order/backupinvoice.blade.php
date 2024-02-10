@extends('layouts.backend.app')

@section('title')
<title>Order Invoice | {{env('APP_NAME')}}</title>
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
                    <h4 class="mb-sm-0 font-size-18">Order invoice</h4>

                    <div class="page-title-right">
                        <!-- <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">All Users</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
                        </ol> -->
                        <a href="{{route('seller.orders')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-reply-all"></i> Back to list</a>
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-lg-12" id="printTable">
                <!-- [ Invoice ] start -->
                <div>
                    <div class="card">
                        <div class="row invoice-contact border-bottom pt-3">
                            <div class="col-md-8">
                                <div class="invoice-box row">
                                    <div class="col-sm-12">
                                        <table class="table table-responsive invoice-table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td><a href="{{URL('/')}}" class="b-brand">
                                                            <img class="img-fluid" width="200px" src="{{asset('assets/admin/images/logo-dark.png')}}" alt="Logo" />
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h5>{{$order->orderItems->first()->seller->business}}</h5>
                                                        <p class="m-0"><b>Address:</b>
                                                            @if($order->orderItems->first()->seller->role_id == 1)
                                                            {{$order->orderItems->first()->seller->address??adminAddress()}}
                                                            @else
                                                            {{$order->orderItems->first()->seller->address}}
                                                            @endif
                                                        </p>
                                                        <p class="m-0"><b>Email Id:</b>{{$order->orderItems->first()->seller->email}}</p>
                                                        <p class="m-0"><b>Mobile No:</b>{{$order->orderItems->first()->seller->mobile}}</p>
                                                        @if($order->orderItems->first()->seller->gst_name != null)
                                                        <p class="m-0"><b>GST Details:</b>{{$order->orderItems->first()->seller->gst_name}}[{{$order->orderItems->first()->seller->gst_no}}]</p>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="invoice-box row">
                                    <div class="col-sm-12">
                                        <table class="table table-responsive invoice-table table-borderless text-end">
                                            <tbody>
                                                <tr><td><h3>Invoice</h3></td></tr>
                                                <tr>
                                                    <td>
                                                        <h5><b>Order ID:</b> {{$order->order_no}}</h5>
                                                        <p class="m-0"><b>Order date:</b> {{$order->date}}</p>
                                                        <p class="m-0"><b>Payment method:</b> {{$order->order_mode}}</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row invoive-info">
                                <div class="col-md-12 col-xs-12 invoice-client-info">
                                    <h5><b>Bill to :</b></h5>
                                    <p class="m-0"><b>Name:</b> {{$order->address->name}}</p>
                                    <p class="m-0"><b>Address:</b>1065 Mandan Road, Columbia MO, Missouri. {{$order->address->pincode}}</p>
                                    <p class="m-0"><b>Email Id:</b>{{$order->address->email}}</p>
                                    <p class="m-0"><b>Mobile No:</b>{{$order->address->mobile}}</p>
                                    @if($order->user != null && $order->user->gst_name != null)
                                    <p class="m-0"><b>GST Details:</b>{{$order->user->gst_name}}[{{$order->user->gst_no}}]</p>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table border invoice-detail-table mt-4">
                                            <thead class="table-light">
                                                <tr class="thead-default">
                                                    <th class="col-8">Description</th>
                                                    <th>Quantity</th>
                                                    <th>Amount</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->orderItems as $item)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex">
                                                            <img class="rounded avatar-sm me-1" src="{{asset('storage/product/'.$item->product->image)}}">
                                                            <div class="desc">
                                                                <h6 class="m-0"><a href="{{route('product.detail', $item->product->slug)}}">{{$item->product->name}}</a></h6>
                                                                @foreach($item->orderItemAttributes as $attribute)
                                                                <span><b>{{$attribute->name}}:</b> {{$attribute->value}}</span> |
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{$item->qty}}</td>
                                                    <td>
                                                        @if($item->discount > 0)
                                                        <del><i class="fas fa-rupee-sign"></i> {{$item->product->regular_price}}</del>
                                                        @else
                                                        <i class="fas fa-rupee-sign"></i> {{$item->product->regular_price}}
                                                        @endif
                                                    </td>
                                                    <td><i class="fas fa-rupee-sign"></i> {{$item->product->sale_price??$item->product->regular_price *$item->qty}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="2"></th>
                                                    <th>Sub Total :</th>
                                                    <th><i class="fas fa-rupee-sign"></i> {{orderSubTotal($order->orderItems) - orderItemDiscount($order->orderItems) + orderItemsTax($order->orderItems)}}</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="2"></th>
                                                    <th>Offer Discount :</th>
                                                    <th class="text-success"> - <i class="fas fa-rupee-sign"></i> {{orderItemDiscount($order->orderItems)}}</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="2"></th>
                                                    <th>Coupon Discount :</th>
                                                    <th class="text-success"> - <i class="fas fa-rupee-sign"></i> {{orderItemCouponDiscount($order->orderItems)}}</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="2"></th>
                                                    <th>Delivery Charge :</th>
                                                    <th class="text-danger">+ <i class="fas fa-rupee-sign"></i> {{$order->shipping_rate}}</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="2"></th>
                                                    <th>GST:</th>
                                                    <th><i class="fas fa-rupee-sign"></i> {{orderItemsTax($order->orderItems)}}</th>
                                                </tr>
                                                <tr class="text-info table-light">
                                                    <th colspan="2"></th>
                                                    <th>
                                                        <h5 class="text-primary">Grand Total :</h5>
                                                    </th>
                                                    <th>
                                                        <h5 class="text-primary"><i class="fas fa-rupee-sign"></i> {{orderItemGrandTotal($order)}}</h5>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <h6>Terms and Condition :</h6>
                                    <p>lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                        laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-sm-12 invoice-btn-group text-center">
                            <button type="button" class="btn waves-effect waves-light btn-primary btn-print-invoice m-b-10">Print</button>
                            <!-- <button type="button" class="btn waves-effect waves-light btn-secondary m-b-10 ">Cancel</button> -->
                        </div>
                    </div>
                </div>
                <!-- [ Invoice ] end -->
            </div>
        </div>

    </div>
    <!-- container-fluid -->
</div>
@endsection

@section('script')
<script>
    document.querySelector('.btn-print-invoice').addEventListener('click', function () {
        var link2 = document.createElement('link');
        link2.innerHTML =
            '<style>@media print{*,::after,::before{text-shadow:none!important;box-shadow:none!important}.pcoded-main-container{margin-left:0px;}a:not(.btn){text-decoration:none}abbr[title]::after{content:" ("attr(title) ")"}pre{white-space:pre-wrap!important}blockquote,pre{border:1px solid #adb5bd;page-break-inside:avoid}thead{display:table-header-group}img,tr{page-break-inside:avoid}h2,h3,p{orphans:3;widows:3}h2,h3{page-break-after:avoid}@page{size:a3}body{min-width:992px!important}.container{min-width:992px!important}.page-header,.pc-sidebar,.pc-mob-header,.pc-header,.pct-customizer,.modal,.pcoded-navbar,.print-btn{display:none}.pc-container{top:0;}.invoice-contact{padding-top:0;}@page,.card-body,.card-header,body,.pcoded-content{padding:0;margin:0}.badge{border:1px solid #000}.table{border-collapse:collapse!important}.table td,.table th{background-color:#fff!important}.table-bordered td,.table-bordered th{border:1px solid #dee2e6!important}.table-dark{color:inherit}.table-dark tbody+tbody,.table-dark td,.table-dark th,.table-dark thead th{border-color:#dee2e6}.table .thead-dark th{color:inherit;border-color:#dee2e6}..table tfoot{borbackgroundder-color:#B9B9B9}</style>';

        document.getElementsByTagName('head')[0].appendChild(link2);
        window.print();
    })
</script>
@endsection
