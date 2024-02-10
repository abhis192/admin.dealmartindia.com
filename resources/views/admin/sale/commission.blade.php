@extends('layouts.backend.app')

@section('title')
<title>All Commission History | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">All Commission History</h4>

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

        <div class="row">
            <div class="col-xl-12">
                <div class="card border">
                    <div class="card-header">
                        <!-- Filter Area -->
                        <!-- <div class="filter-area">
                            <div class="row justify-content-start align-items-center">
                                <div class="col-lg-10">
                                    <form class="custom-form" method="POST" action="#">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <div class="form-group mb-0">
                                                    <select class="form-control select2">
                                                        <option>Select Seller</option>
                                                        <option value="">Amit Singh</option>
                                                        <option value="">Sanjay Kumar</option>
                                                        <option value="">Shiv Sinha</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="input-group form-group mb-0">
                                                <label class="input-group-text form-control-sm">Start Date</label>
                                                    <input type="date" class="form-control form-control-sm" required/>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="input-group form-group mb-0">
                                                <label class="input-group-text form-control-sm">End Date</label>
                                                    <input type="date" class="form-control form-control-sm" required/>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <button type="submit" class="btn btn-success waves-effect waves-light">Filter</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="card-body">

                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="col-1">#</th>
                                    <th>Order Id</th>
                                    {{-- <th>Seller</th>   --}}
                                    <th>Total Order Price</th>
                                    <th>Commission (%)</th>
                                    <th>Admin Commission</th>
                                    <th>Kitchen Earning</th>
                                    <th class="col-1">Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commissions as $key => $commission)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>#{{$commission->orderItem->order->order_no}}</td>
                                    {{-- <td>{{$commission->seller->name}}</td> --}}
                                    <td>
                                        <b><i class="bx bx-rupee"></i>{{$commission->order_total}}</b>
                                    </td>
                                    <td>
                                        <b>{{$commission->commission_rate}}%</b>
                                    </td>
                                    <td>
                                        <b><i class="bx bx-rupee"></i>{{$commission->admin_commission}}</b>
                                    </td>
                                    <td>
                                        <b><i class="bx bx-rupee"></i>{{$commission->seller_earning}}</b>
                                    </td>
                                    <td>{{$commission->created_at}}</td>
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
