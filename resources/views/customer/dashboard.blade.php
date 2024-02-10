@extends('layouts.frontend.customerapp')

@section('title')
<title>My Account | {{env('APP_NAME')}}</title>
@endsection

@section('css')
@endsection

@section('content')
<div id="page-content">

    <!-- [ Breadcrumbs ] start -->
    <div class="breadcrumbs-wrapper text-uppercase">
        <div class="container">
            <div class="breadcrumbs">
            <a href="{{URL('/')}}" title="Back to the home page">Home</a><span>|</span>
                <a href="">Dashboard</a><span>|</span>
                <span class="fw-bold">My Orders</span>
            </div>
        </div>
    </div>

    <!-- [ Main Content ] start -->
    <section class="my-account-main">
        <div class="container pt-2">
            {{-- @include('layouts.frontend.partials.customerHeader') --}}

            <div class="row mb-4 mb-lg-5 pb-lg-5">
                <div class="col-xl-3 col-lg-2 col-md-12 mb-4 mb-lg-0 d-none d-lg-block">
                    <!-- Nav tabs -->
                    @include('layouts.frontend.partials.customerSidebar')
                    <!-- End Nav tabs -->
                </div>

                <div class="col-xl-9 col-lg-10 col-md-12">
                    <div class="dashboard-content p-0 border-0">

                        <!-- Orders -->
                        <div class="card product-order border">
                            <div class="card-header border-bottom">
                                <h3 class="m-0">My Orders</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    @if($orders->count())
                                    <div class="col-lg-12">
                                        <ul class="list-group order-listing p-0">
                                            @foreach($orders as $order)
                                            <li class="list-group-item order-item border p-0 mb-3">
                                                <div class="order-box card m-0">
                                                    <div class="card-header">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center justify-content-start">
                                                                <img src="{{asset('storage/product/'.$order->orderItems->first()->product->image)}}" class="img-fluid rounded-circle shadow" width="40px">
                                                                <div class="media-body ms-2">
                                                                    <p class="mb-0 ft-medium">#{{$order->order_no}}</p>
                                                                    <h6 class="mb-0 ft-medium">
                                                                        @foreach($order->orderItems as $key => $item)
                                                                            {{$item->product->name}}{{ $key !== count($order->orderItems) - 1 ? ',' : '' }}
                                                                        @endforeach
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                            <div class="delv_status">
                                                                <span
                                                                class="ft-medium small
                                                                @if($order->order_status == 'Pending')
                                                                    text-warning
                                                                @elseif($order->order_status == 'Delivered')
                                                                    text-success
                                                                @elseif($order->order_status == 'Cancelled by admin')
                                                                    text-danger
                                                                @elseif($order->order_status == 'Cancelled by seller')
                                                                    text-danger
                                                                @else
                                                                    text-info
                                                                @endif
                                                                bg-white rounded px-2 py-1 border">
                                                                    {{$order->order_status}}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <p class="m-0"><small><b>Order Placed on:</b> {{\Carbon\Carbon::parse($order->date)->format('d M, Y')}}</small></p>
                                                        <p class="m-0"><small><b>Delivered by:</b> {{\Carbon\Carbon::parse($order->date)->addDays(4)->format('d M, Y')}}</small></p>
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="more-links text-end">
                                                            <a href="{{route('customer.order.show',$order->id)}}"><small>View Order</small></a>
                                                            @if($order->order_status == 'Delivered' || $order->order_status == 'Cancelled by seller' || $order->order_status == 'Cancelled by admin' || $order->order_status == 'Cancelled' || $order->order_status == 'Refund Initiated' || $order->order_status == 'Refund Completed')
                                                            @else
                                                            <span class="px-1">|</span>
                                                            <a href="{{route('customer.order.cancel',$order->id)}}"><small>Cancel Order</small></a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @else
                                    <div class="col-lg-12">
                                        <h3 class="text-danger pb-3">No Order Found!!</h3>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer py-3" align="center">
                                {{ $orders->links() }}
                            </div>
                            <!-- <div class="card-footer">
                                <div class="row justify-content-center align-items-center text-center">
                                    <div class="col-6">
                                        <div id="loadOrder" class="btn btn-success btn-xs remain_products rounded"> Load More</div>
                                    </div>
                                </div>
                            </div> -->
                        </div>

                    </div>
                    <!-- End Tab panes -->
                </div>
            </div>
            <!--End Main Content-->
        </div>
    </section>

</div>
@endsection
