@extends('layouts.backend.app')

@section('title')
<title>Order Detail | {{env('APP_NAME')}}</title>
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
                    <h4 class="mb-sm-0 font-size-18">Order Detail</h4>

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
            <div class="col-xl-12">
                <div class="card border">
                    <form method="POST" action="{{route('seller.order.status',$order->id)}}">
                        @csrf
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Update Order</h4>
                        </div>
                        <div class="card-body">
                            <!-- Filter Area -->
                            <div class="filter-area">
                                <div class="row justify-content-start align-items-center">
                                    <div class="col-lg-12">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Payment Status:</label>
                                                    <select class="form-control" name="payment_status" required>
                                                        <option value="">Select</option>
                                                        <option value="paid" {{$order->status->payment_status == 'paid' ? 'selected' : ''}}>Paid</option>
                                                        <option value="unpaid" {{$order->status->payment_status == 'unpaid' ? 'selected' : ''}}>Unpaid</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Delivery Status:</label>
                                                    <select class="form-control" name="order_status" required>
                                                        <option value="">Select Delivery Status</option>
                                                        <option value="Pending" {{$order->status->order_status == 'Pending' ? 'selected' : ''}}>Pending</option>
                                                        <option value="Ready To Ship" {{$order->status->order_status == 'Ready To Ship' ? 'selected' : ''}}>Ready To Ship</option>
                                                        <option value="Dispatched" {{$order->status->order_status == 'Dispatched' ? 'selected' : ''}}>Dispatched</option>
                                                        <option value="Out For Delivery" {{$order->status->order_status == 'Out For Delivery' ? 'selected' : ''}}>Out For Delivery</option>
                                                        <option value="Delivered" {{$order->status->order_status == 'Delivered' ? 'selected' : ''}}>Delivered</option>
                                                        @if($order->status->order_status != 'Delivered')
                                                        <option value="Cancelled by seller" {{$order->status->order_status == 'Cancled by seller' ? 'selected' : ''}}>Cancelled by seller</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Tracking Code (optional):</label>
                                                    <input name="comment" type="text" id="name" class="form-control" placeholder="Enter Tracking Code..." value="{{$order->status->comment}}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
                        </div>
                    </form>
                </div>
                <!-- end card -->

            </div>
        </div> <!-- end row -->

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
                                    <p class="m-0"><b>Address:</b>{{$order->address->address}}. {{$order->address->landmark}}-{{$order->address->pincode}}, {{$order->address->city}},{{$order->address->state}} {{$order->address->country}}</p>
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
                                                    <th>GST :</th>
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
                </div>
                <!-- [ Invoice ] end -->
            </div>
        </div> <!-- end row -->
    </div>
    <!-- container-fluid -->
</div>
@endsection
