@extends('layouts.frontend.customerapp')

@section('title')
<title>My Account | {{env('APP_NAME')}}</title>
@endsection

@section('css')
<style>
    /*---------------- Submit Reviews -----------------*/
    .submit-rating{
        direction: rtl;
        display: inline-flex;
        padding:0px
    }
    .submit-rating input[type=radio] {
        display: none
    }
    .submit-rating label {
        color: #bbb;
        font-size: 18px;
        padding: 0;
        cursor: pointer;
        -webkit-transition: all .3s ease-in-out;
        transition: all .3s ease-in-out
    }
    .submit-rating label:hover,
    .submit-rating label:hover ~ label,
    .submit-rating input[type=radio]:checked ~ label {
        color: #f2b600
    }
    .submit-rating [type="radio"]:checked + label:before, .submit-rating [type="radio"]:not(:checked) + label:before {
        display:none;
    }
    .submit-rating [type="radio"]:checked + label:after, .submit-rating [type="radio"]:not(:checked) + label:after {
        display:none;
    }
    .submit-rating [type="radio"]:checked + label, .submit-rating [type="radio"]:not(:checked) + label {
       padding-left:5px;
       line-height:1;
       font-size: 12px;
    }
</style>
@endsection

@section('content')
<div id="page-content">
    <!-- [ Breadcrumbs ] start -->
    <div class="breadcrumbs-wrapper text-uppercase">
        <div class="container">
            <div class="breadcrumbs"><a href="{{URL('/')}}" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">Track Order</span></div>
        </div>
    </div> 

    <!-- [ Main Content ] start -->
    <section class="view-order-main">
        <!--Main Content-->
        <div class="container">
            <div class="row row-cols-1 row-cols-lg-3 mb-5 justify-content-center"> 
                @foreach($order->orderItems as $item)
                <div class="col">
                    <div class="card my-account-card border rounded mb-4">
                        @if($order->order_status == "Cancelled")
                        <div class="product-labels return-labels text-danger"><span class="lbl on-sale">Cancelled</span></div>
                        @elseif($order->order_status == "Cancelled by admin" || $order->order_status == "Cancelled by seller")
                        <div class="product-labels return-labels text-danger"><span class="lbl on-sale">{{$order->order_status}}</span></div>
                        @elseif($item->refund_status === 1)
                        <div class="product-labels return-labels"><span class="lbl on-sale">Retuned</span></div>
                        @elseif($item->refund_status === 2)
                        <div class="product-labels return-labels"><span class="lbl on-sale">Refunded</span></div>
                        @endif
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="image me-2">
                                    <a href="{{route('product.detail', $item->product->slug)}}">
                                        <img src="{{asset('storage/product/'.$item->product->image)}}" class="img-fluid" width="90px" alt="...">
                                    </a>
                                </div>
                                <div class="details">
                                    <div class="cart_single_caption pl-2">
                                        <h4 class="product_title fs-md ft-medium mb-1">{{$item->product->name}}</h4>
                                        <div class="cart_attributes mb-2">
                                            @foreach($item->orderItemAttributes as $attribute)                                            
                                            <span class="text-success bg-success bg-opacity-25 px-2 me-1">{{$attribute->name}}: {{$attribute->value}}</span>
                                            @endforeach
                                        </div>
                                        <div class="product-price">
                                            <span class="price">
                                                ₹ 
                                                @if($item->discount > 0)
                                                    (<del>{{$item->price + $item->tax + $item->discount}}</del> {{$item->price + $item->tax}})
                                                @else
                                                    ({{$item->price + $item->tax}})
                                                @endif

                                                 x {{$item->qty}}
                                            </span>
                                        </div>
                                        <div class="expact-delivery">
                                            <p><b>Expected Delivery::</b> <span class="text-success">{{\Carbon\Carbon::parse($order->date)->addDays($product->shipping_days??4)->format('d F, Y')}}</span></p> 
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="card-footer bg-white p-2 d-flex align-items-center justify-content-between">
                            @if($item->review)
                            <div class="product-ratingsContainer text-success bg-success bg-opacity-25 px-2 rounded">
                                <span>{{$item->review->stars}}</span>
                                <span><i class="bi bi-star-fill"></i></span>
                            </div>
                            @else
                            @if($order->order_status == 'Delivered')
                            <a class="text-success me-3" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#reviewForm{{$item->id}}"><i class="bi bi-star-fill"></i> Review Now</a> 
                            @endif
                            @endif

                            @if($item->product->refundable_day)
                            @if($order->order_status == 'Delivered' && $order->created_at->addDays($item->product->refundable_day??refundDays()) > now())
                            <a class="text-danger me-3" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#returnForm{{$item->id}}"><i class="bi bi-arrow-return-left"></i> Return Product</a>
                            @endif
                            @endif

                            @if($item->refund_status === 1)
                                <div class="text-danger">Refund Initiated</div>
                                <div class="text-primary">
                                    <a href="{{route('customer.order.cancelRefund',$item->refund->id)}}">Cancel Refund</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <hr>

            <!--Cart Page-->
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-7 main-col mb-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <h3 class="text-dark ft-medium mb-4">Track Order</h3>
                            <div><strong>Tracking no:</strong> {{$order->status->comment??''}}</div>
                            @if($order->order_status != "Cancled by admin" || $order->order_status != "Cancled by seller")
                            <div class="order-track px-15">
                                <div class="order-track-step {{ checkStatusProgress($order,'Delivered')}}">
                                    <div class="order-track-status">
                                        <span class="order-track-status-dot">
                                            <img src="assets/svg/check.svg" class="img-fluid" alt="">
                                        </span>
                                        <span class="order-track-status-line"></span>
                                    </div>
                                    <div class="order-track-text">
                                        <p class="order-track-text-stat">Delivered</p>
                                        <span class="order-track-text-sub">
                                            {{ checkStatusProgressDate($order,'Delivered')}}
                                        </span>
                                    </div>
                                </div>
                                <div class="order-track-step {{ checkStatusProgress($order,'Out For Delivery')}}">
                                    <div class="order-track-status">
                                        <span class="order-track-status-dot">
                                            <img src="assets/svg/check.svg" class="img-fluid" alt="">
                                        </span>
                                        <span class="order-track-status-line"></span>
                                    </div>
                                    <div class="order-track-text">
                                        <p class="order-track-text-stat">Out For Delivery</p>
                                        <span class="order-track-text-sub">
                                            {{ checkStatusProgressDate($order,'Out For Delivery')}}
                                        </span>
                                    </div>
                                </div>
                                <div class="order-track-step {{ checkStatusProgress($order,'Dispatched')}}">
                                    <div class="order-track-status">
                                        <span class="order-track-status-dot">
                                            <img src="assets/svg/check.svg" class="img-fluid" alt="">
                                        </span>
                                        <span class="order-track-status-line"></span>
                                    </div>
                                    <div class="order-track-text">
                                        <p class="order-track-text-stat"> Dispatched</p>
                                        <span class="order-track-text-sub">
                                            {{ checkStatusProgressDate($order,'Dispatched')}}
                                        </span>
                                    </div>
                                </div>
                                <div class="order-track-step {{ checkStatusProgress($order,'Ready To Ship')}}">
                                    <div class="order-track-status">
                                        <span class="order-track-status-dot">
                                            <img src="assets/svg/check.svg" class="img-fluid" alt="">
                                        </span>
                                        <span class="order-track-status-line"></span>
                                    </div>
                                    <div class="order-track-text">
                                        <p class="order-track-text-stat"> Ready To Ship</p>
                                        <span class="order-track-text-sub">
                                            {{ checkStatusProgressDate($order,'Ready To Ship')}}
                                        </span>
                                    </div>
                                </div>
                                <div class="order-track-step {{ checkStatusProgress($order,'Pending')}}">
                                    <div class="order-track-status">
                                        <span class="order-track-status-dot">
                                            <img src="assets/svg/check.svg" class="img-fluid" alt="">
                                        </span>
                                        <span class="order-track-status-line"></span>
                                    </div>
                                    <div class="order-track-text">
                                        <p class="order-track-text-stat"> Ordered</p>
                                        <span class="order-track-text-sub">
                                            {{\Carbon\Carbon::parse($order->updated_at)->format('H:i a')}}, {{\Carbon\Carbon::parse($order->date)->format('d/m/Y')}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-5">
                    <div class="shipping-detail-box mb-4">
                        <p class="m-0 fw-500 ft-medium fs-sm mb-2">Order Id - #{{$order->order_no}}</p>
                        <h3 class="text-dark ft-medium mb-4">Shipping Details</h3>

                        <p class="m-0 text-dark ft-medium fs-sm">{{$order->address->name}}</p>
                        <p class="m-0 ft-medium fs-sm"><b>Delivery Address :</b> {{$order->address->address}}, {{$order->address->landmark}}, {{$order->address->city}}, {{$order->address->state}}, {{$order->address->country}} - {{$order->address->pincode}}</p>
                        <p class="m-0 fs-sm"><b>Email Id :</b> {{$order->address->email}} </p>
                        <p class="m-0 fs-sm"><b>Phone No:</b> {{$order->address->mobile}}</p>
                        <p class="m-0 fs-sm"><b>Payment:</b> {{$order->order_mode}}</p>
                    </div>
                    <div class="cart_info border p-0">
                        <div class="card mb-4 p-0">
                            <div class="card-body p-0">
                                <ul class="list-group list-group-sm list-group-flush-y list-group-flush border-0">
                                    <li class="list-group-item d-flex justify-content-between text-dark fs-sm ">
                                        <span>Bag Total</span> <span class="ml-auto text-dark text-detail">₹ 
                                            {{customerOrderItemTotal($order->orderItems)}}
                                        </span>
                                    </li>
                                    <!-- <li class="list-group-item d-flex justify-content-between text-dark fs-sm ">
                                        <span>Sub Total</span> <span class="ml-auto text-dark text-detail">₹ 
                                            {{orderSubTotal($order->orderItems)}}
                                        </span>
                                    </li> -->
                                    <li class="list-group-item d-flex justify-content-between text-dark fs-sm ft-regular">
                                        <span>Offer Discount</span> <span class="text-success ml-auto text-detail">- ₹ 
                                            {{orderItemDiscount($order->orderItems)}}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between text-dark fs-sm ft-regular">
                                        <span>Coupon Discount</span> <span class="text-success ml-auto text-detail">- ₹ {{orderItemCouponDiscount($order->orderItems)}}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between text-dark fs-sm ft-regular">
                                        <span>Delivery Charge</span> <span class="text-danger ml-auto text-detail">+ ₹ {{$order->shipping_rate}}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between text-dark fs-sm ft-regular">
                                        <span>GST</span> <span class="ml-auto text-detail"> ₹ {{orderItemsTax($order->orderItems)}}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between text-dark fs-sm ft-regular">
                                        <span>Total Amount</span> <span class="ml-auto text-dark text-detail"><strong>₹ 
                                            {{orderItemGrandTotal($order)}}
                                        </strong></span>
                                    </li>
                                    <li class="list-group-item fs-sm text-center"> Inclusive of all taxes and Charges. * </li>
                                </ul>
                            </div>
                        </div>

                        <div class="cart-action-btn text-center p-2 d-none d-lg-block">
                            <a href="{{route('customer.dashboard')}}" class="btn btn--small-wide rounded checkout w-100 d-none d-lg-block">Back to Order</a>
                            <a href="{{route('shop')}}" class="d-flex justify-content-center align-items-center d-none d-lg-block">
                                <i class="me-1 icon an an-angle-left-l"></i> Continue shopping
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

@foreach($order->orderItems as $item)
<!-- Return Modal -->
<div class="modal fade" id="returnForm{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="returnFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Return Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('customer.order.refund',$item->id)}}" method="post">
                    @method('POST')
                    @csrf
                    <div class="row">
                        <div class="form-group mb-4 col-9">
                            <label for="orderedProducts">Reason Of Return Product*</label>
                            <select class="form-control" name="reason" id="orderedProducts" required>
                                <option value="">Choose Reason</option>
                                <option value="Size Issue">Size Issue</option>
                                <option value="Other">Other</option>
                            </select>                        
                        </div>
                        <div class="form-group mb-4 col-3">
                            <label for="qty">Reason quantity*</label>
                            <select class="form-control" name="qty" id="qty" required>
                                <option value="">Choose Qty</option>
                                @for ($i = 1; $i <= $item->qty; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>                        
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mb-4 col-5">
                            <label for="name" class="form-label">Account Holder Name:</label>
                            <input type="text" name="holders_name" value="{{Auth::user()->bank->holders_name??old('holders_name')}}" class="form-control" placeholder="Enter Account Holder Name..." required />
                            @error('holders_name')
                                <div class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-7">
                            <label for="name" class="form-label">Account Number:</label>
                            <input type="text" class="form-control" name="account_no" value="{{Auth::user()->bank->account_no??old('account_no')}}" placeholder="Enter Account Number..." required /> 
                            @error('account_no')
                                <div class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label for="name" class="form-label">Bank Name:</label>
                            <input type="text" class="form-control" name="bank_name" value="{{Auth::user()->bank->bank_name??old('bank_name')}}" placeholder="Enter Bank Name..." required /> 
                            @error('bank_name')
                                <div class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label for="name" class="form-label">IFSC Code:</label>
                            <input type="text" class="form-control" name="ifsc_code" value="{{Auth::user()->bank->ifsc_code??old('ifsc_code')}}" placeholder="Enter IFSC Code..." required /> 
                            @error('ifsc_code')
                                <div class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label for="name" class="form-label">Branch Name:</label>
                            <input type="text" class="form-control" name="branch_name" value="{{Auth::user()->bank->branch_name??old('branch_name')}}" placeholder="Enter Branch Name..." required /> 
                            @error('branch_name')
                                <div class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comment" class="form-label">Comment*:</label>
                        <textarea class="form-control" name="comment">{{old('comment')}}</textarea> 
                        @error('comment')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Submit Return</button>
                </form>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Submit Return</button>
            </div> -->
        </div>
    </div>
</div>

<!-- Reviews & Rating Modal -->
<div class="modal fade" id="reviewForm{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="reviewFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Reviews & Rating</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('customer.order.review',$item->id)}}" method="post">
                    @method('POST')
                    @csrf 
                    <div class="reviews_rate"> 
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="revie_stars d-flex align-items-center justify-content-between px-2 py-2 bg-gray rounded mb-2 mt-1">
                                    <div class="srt_013">
                                        <div class="submit-rating">
                                            <input id="star-5" type="radio" name="stars" value="5">
                                            <label for="star-5" title="5 stars">
                                                <i class="bi bi-star-fill"></i>
                                            </label>
                                            <input id="star-4" type="radio" name="stars" value="4">
                                            <label for="star-4" title="4 stars">
                                                <i class="bi bi-star-fill"></i>
                                            </label>
                                            <input id="star-3" type="radio" name="stars" value="3">
                                            <label for="star-3" title="3 stars">
                                                <i class="bi bi-star-fill"></i>
                                            </label>
                                            <input id="star-2" type="radio" name="stars" value="2">
                                            <label for="star-2" title="2 stars">
                                                <i class="bi bi-star-fill"></i>
                                            </label>
                                            <input id="star-1" type="radio" name="stars" value="1">
                                            <label for="star-1" title="1 star">
                                                <i class="bi bi-star-fill"></i>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="srt_014">
                                        <h6 class="mb-0">5 Star</h6>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-floating mb-4">
                                    <textarea class="form-control" name="content" id="Comments" placeholder="Wright something..." required></textarea>
                                    <label for="Comments">Comments*</label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-dark w-100">Submit Reviews</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection