@extends('layouts.backend.app')

@section('title')
<title>Orders | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">All Orders</h4>

                    <div class="page-title-right">
                        <a href="{{route('admin.order.create')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-plus"></i> Create Self Order</a>
                        {{-- <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">All Orders</li>
                        </ol> --}}
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            {{-- <div class="col-12"> --}}
                {{-- <div class="card border"> --}}
                    {{-- <div class="card-header">
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
                    </div> --}}
                    <div class="col-12">
                        <!-- [ Filter by ] Start -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Filter by</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="customer" class="form-label fw-bold">Customer <sup class="text-danger fs-5">*</sup> :</label>
                                            <select class="form-control select2" id="customer" required>
                                                <option value="">All Customer</option>
                                                <option value="1">Amit-(9999585858)</option>
                                                <option value="2">Kishan-(9999585858)</option>
                                                <option value="3">Pradeep-(9999585858)</option>
                                            </select>
                                            <div class="valid-feedback">Looks good!</div>
                                            <div class="invalid-feedback">This field is required. </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="kitchen" class="form-label fw-bold">Kitchen <sup class="text-danger fs-5">*</sup> :</label>
                                            <select class="form-control select2" id="kitchen" required>
                                                <option value="">All Kitchen</option>
                                                <option value="1">foody Kitchen -(9999585858)</option>
                                            </select>
                                            <div class="valid-feedback">Looks good!</div>
                                            <div class="invalid-feedback">This field is required. </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="DeliveryStatus" class="form-label fw-bold">Delivery Status <sup class="text-danger fs-5">*</sup> :</label>
                                            <select class="form-control select2" id="DeliveryStatus" required>
                                                <option value="">All Delivery Status</option>
                                                <option value="1">Pending</option>
                                                <option value="1">Prepare Order</option>
                                                <option value="1">Out fot Delivery</option>
                                                <option value="1">Delivered</option>
                                                <option value="2">Returned</option>
                                            </select>
                                            <div class="valid-feedback">Looks good!</div>
                                            <div class="invalid-feedback">This field is required. </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="dmy" class="form-label fw-bold">Date/Month/Year <sup class="text-danger fs-5">*</sup> :</label>
                                            <select class="form-control select2" id="dmy" required>
                                                <option value="">All Date/Month/Year</option>
                                                <option value="1">Today</option>
                                                <option value="2">Yesterday</option>
                                                <option value="1">Last 7 Days</option>
                                                <option value="2">Last 15 Days</option>
                                                <option value="3">This Month</option>
                                                <option value="4">Last Month</option>
                                                <option value="8">Custom</option>
                                            </select>
                                            <div class="valid-feedback">Looks good!</div>
                                            <div class="invalid-feedback">This field is required. </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button id="filter-btn" type="button" class="btn btn-primary waves-effect waves-light"><i class="fa fa-search"></i> Search</button>&nbsp;
                                <button id="reset-filter-btn" type="button" class="btn btn-light waves-effect waves-light"><i class="fa fa-undo"></i> Reset</button>
                            </div>
                        </div>
                    </div>

            <div class="col-12">
                <div class="card border">
                    <div class="card-body">

                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Order Id</th>
                                    <th>Customer</th>
                                    <th>Assigned Kitchen</th>
                                    <th>Amount</th>

                                    <th>P mod</th>
                                    {{-- <th>Refund</th> --}}
                                    <th>Order Date</th>
                                    <th>Delivery Status</th>
                                    <th class="col-1">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                            	@foreach($orders as $order)
                                <tr>
                                    <td>#{{$order->order_no}}</td>
                                    <td>{{$order->user->name??'Guest user'}}</td>
                                    <td>{{$order->orderItems->first()->seller->name??null}}</td>
                                    <td>
                                        <b><i class="bx bx-rupee"></i>{{orderSubTotal($order->orderItems) + orderItemsTax($order->orderItems) - orderItemDiscount($order->orderItems) + $order->shipping_rate - orderCouponCodeTotal($order->orderItems)}} </b>
                                    </td>
                                    {{-- <td><span class="badge badge-soft-success font-size-12">{{$order->order_status}}</span></td> --}}
                                    <td>{{$order->order_mode}}</td>
                                    {{-- <td>@if($order->refund) Refund Raised @else No Refund @endif</td> --}}
                                    <td>{{$order->date}}</td>
                                    <td><span class="badge badge-soft-success font-size-12">{{$order->order_status}}</span></td>
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
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
    <!-- container-fluid -->
</div>
@endsection
