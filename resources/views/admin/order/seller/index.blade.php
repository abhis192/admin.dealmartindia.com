@extends('layouts.backend.app')

@section('title')
<title>Seller Orders | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">Seller Orders</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">Seller Orders</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div> 
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-12">
                <div class="card border"> 
                    <div class="card-header"> 
                        <!-- Filter Area -->
                        <div class="filter-area">
                            <div class="row justify-content-start align-items-center">
                                <div class="col-lg-10">
                                    <form class="custom-form" method="POST" action="{{route('admin.order.filter')}}">
                                        @method('POST')
                                        @csrf
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <div class="form-group mb-0">
                                                    <select class="form-control select2" name="seller_id" required>
                                                        <option value="">Select Seller</option>
                                                        @foreach($sellers as $seller)
                                                        <option 
                                                        value="{{$seller->id}}" 
                                                        @if(isset($seller_id))
                                                            @if($seller->id == $seller_id)
                                                                selected
                                                            @endif
                                                        @endif
                                                        >{{$seller->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="input-group form-group mb-0">
                                                <label class="input-group-text form-control-sm">Start Date</label> 
                                                    <input type="date" class="form-control form-control-sm" name="start_date" value="{{$start_date??''}}" required/>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="input-group form-group mb-0">
                                                <label class="input-group-text form-control-sm">End Date</label> 
                                                    <input type="date" class="form-control form-control-sm" name="end_date" value="{{$end_date??''}}" required/>
                                                </div>
                                            </div>
                                            <div class="col-lg-2"> 
                                                <button type="submit" class="btn btn-success waves-effect waves-light">Filter</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body"> 

                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr> 
                                    <th>Order Id</th>
                                    <th>Customer</th>
                                    <th>Seller</th>
                                    <th>Amount</th>
                                    <th>Delivery Status</th>
                                    <th>Payment method</th> 
                                    <th>Refund</th> 
                                    <th>Order Date</th>
                                    <th class="col-1">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                            	@foreach($orders as $order)
                                <tr> 
                                    <td>#{{$order->order_no}}</td>
                                    <td>{{$order->user->name??'Guest user'}}</td>
                                    <td>{{$order->orderItems->first()->product->user->name}}</td>
                                    <td>
                                        <b><i class="bx bx-rupee"></i>{{orderSubTotal($order->orderItems) + orderItemsTax($order->orderItems) - orderItemDiscount($order->orderItems) + $order->shipping_rate - orderCouponCodeTotal($order->orderItems)}} </b>
                                    </td>
                                    <td><span class="badge badge-soft-success font-size-12">{{$order->order_status}}</span></td>
                                    <td>{{$order->order_mode}}</td> 
                                    <td>@if($order->refund) Refund Raised @else No Refund @endif</td>  
                                    <td>{{$order->date}}</td>
                                    <td class="text-center">  
                                        <a href="{{route('admin.order.detail',$order->id)}}" class="btn btn-soft-success btn-sm waves-effect waves-light" title="View Order"><i class="mdi mdi-eye font-size-16"></i></a>
                                        <a href="{{route('admin.order.invoice',$order->id)}}" class="btn btn-soft-info btn-sm waves-effect waves-light" title="Download Invoice"><i class="bx bx-download font-size-16"></i></a> 
                                    </td>
                                </tr> 
                                @endforeach
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
    <!-- container-fluid -->
</div> 
@endsection
