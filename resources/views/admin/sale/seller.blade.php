@extends('layouts.backend.app')

@section('title')
<title>Sales Report | Cake24x7</title>
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
                    <h4 class="mb-sm-0 font-size-18">All Order Sales Report</h4>

                    <div class="page-title-right">
                        <!-- <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">All Banner</li>
                        </ol> -->
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="col-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Orders</p>
                                    <h4 id="total_orders" class="mb-0">0</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-copy-alt font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Sales</p>
                                    <h4 class="mb-0">
                                        <b><i class="bx bx-rupee"></i> <span id="total_sale">0</span></b>
                                    </h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-archive-in font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                                <label for="orderid" class="form-label fw-bold">Order Id :</label>
                                <input type="text" class="form-control" id="orderid" placeholder="Eg: ORD-20220912" />
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">This field is required. </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="transaction_id" class="form-label fw-bold">Transaction Id :</label>
                                <input type="text" class="form-control" id="transaction_id" placeholder="Eg: pay_Mb4sgritRipLZz" />
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">This field is required. </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="DeliveryStatus" class="form-label fw-bold">Payment Status :</label>
                                <select class="form-control select2" id="DeliveryStatus" required>
                                    <option selected>All Payment Status</option>
                                    <option value="1">Paid</option>
                                    <option value="2">unPaid</option>
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

        <div class="row">
            <div class="col-xl-12">
                <div class="card border">
                    <div class="card-header">
                        <!-- Filter Area -->
                        <div class="filter-area">
                            <div class="row justify-content-start align-items-center">
                                <div class="col-lg-5">
                                    <form class="custom-form" method="POST" action="#">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <div class="form-group mb-0">
                                                    <select class="form-control select2">
                                                        <option value="">Select Category</option>
                                                        @foreach($categories as $category)
                                                        <option value="">Category 1</option>
                                                        @endforeach
                                                    </select>
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
                                    <th class="col-1">Order Id</th>
                                    <th>Transaction Id</th>
                                    <th>Assigned Kitchen</th>
                                    <th>Payment Method</th>
                                    <th>Payment Status</th>
                                    <th>Delivery Status</th>
                                    <th class="col-1">Order Date</th>
                                    {{-- <th>Product Name</th>
                                    <th>Category Name</th>
                                    <th class="col-1">Number Of Sale</th> --}}
                                </tr>
                            </thead>


                            <tbody>
                                {{-- @foreach($products as $key => $product)
                                @if($product->orderItems->count()) --}}
                                <tr>
                                    {{-- <td>{{$key+1}}</td>

                                    <td class="text-wrap">{{$product->name}}</td>
                                    <td>{{$product->category->name??''}}</td>
                                    <td><span class="badge badge-soft-success font-size-16">{{$product->orderItems->count()}}</span></td> --}}

                                        <td>ORD-20220912</td>
                                        <!-- <td>
                                            <p class="m-0">Shyam</p>
                                            <span class="badge badge-soft-info font-size-12 border-1">9999585812</span>
                                        </td> -->
                                        <td>pay_Mb4sgritRipLZz</td>
                                        <td>kitchen name</td>
                                        <td>COD</td>
                                        <td><span class="badge badge-soft-success font-size-12">Paid</span></td>
                                        <td><span class="badge badge-soft-success font-size-12">Delivered</span></td>
                                        <td>29th Sep 2023 | 06:10 PM</td>

                                </tr>
                                {{-- @endif
                                @endforeach --}}
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
