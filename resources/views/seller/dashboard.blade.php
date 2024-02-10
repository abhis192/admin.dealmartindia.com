@extends('layouts.backend.app')

@section('title')
<title>Dashboard</title>
@endsection

@section('css')
<style>
    .dt-buttons.btn-group.flex-wrap { display: none !important; }
</style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- [ breadcrumb ] start -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row"> 
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Total Customer</p>
                                        <h4 class="mb-0">1,235</h4>
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
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Total Seller</p>
                                        <h4 class="mb-0">1,235</h4>
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
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Total Seles</p>
                                        <h4 class="mb-0"><i class="bx bx-rupee"></i>35, 723</h4>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center ">
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
        </div>
        <!-- end row --> 

        <div class="row"> 
            <div class="col-xl-12"> 
                
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-4">Bar Chart</h4>

                        <div class="row text-center">
                            <div class="col-3">
                                <h5 class="mb-0">2541</h5>
                                <p class="text-muted text-truncate">Total Orders</p>
                            </div>
                            <div class="col-3">
                                <h5 class="mb-0">84845</h5>
                                <p class="text-muted text-truncate">Pending Orders</p>
                            </div>
                            <div class="col-3">
                                <h5 class="mb-0">12001</h5>
                                <p class="text-muted text-truncate">Delivered Orders</p>
                            </div>
                            <div class="col-3">
                                <h5 class="mb-0">12001</h5>
                                <p class="text-muted text-truncate">Returned Orders</p>
                            </div>
                        </div>

                        <canvas id="bar" data-colors='["--bs-success-rgb, 0.8", "--bs-success"]' height="300"></canvas>

                    </div>
                </div>
            </div>
        </div>
        <!-- end row --> 

        <div class="row">
            <div class="col-lg-12"> 
                <div class="card border"> 
                    <!-- <div class="card-header"></div> -->
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
                                </tr>
                            </thead>


                            <tbody>
                                <tr> 
                                    <td>#vre-123456</td>
                                    <td>
                                        <p class="m-0"><b>Shivan Kumar</b></p>
                                        <p class="m-0">[asd@gmail.com]</p>
                                    </td>
                                    <td>Amit Shah</td>
                                    <td>
                                        <b><i class="bx bx-rupee"></i>2450.00</b>
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-success font-size-12">Delivered</span>  
                                    </td>
                                    <td>COD</td>
                                    <td>No Refund</td>
                                    <td>10 Mearch 2023 | 10:33:22 AM</td> 
                                </tr> 
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
        </div>
        <!-- end row -->

    </div>
    <!-- container-fluid -->
</div>

@endsection

@section('script')
    <!-- Chart JS -->
    <script src="{{asset('assets/admin/libs/chart.js/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/pages/chartjs.init.js')}}"></script>  
@endsection   