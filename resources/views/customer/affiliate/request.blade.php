@extends('layouts.frontend.customerapp')

@section('title')
<title>Affiliate Withdraw Request | {{env('APP_NAME')}}</title>
@endsection

@section('css')
<!-- DataTables -->
<link href="{{asset('assets/admin/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{asset('assets/admin/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div id="page-content">

    <!-- [ Breadcrumbs ] start -->
    <div class="breadcrumbs-wrapper text-uppercase">
        <div class="container">
            <div class="breadcrumbs">
            <a href="{{URL('/')}}" title="Back to the home page">Home</a><span>|</span>
                <a href="">Dashboard</a><span>|</span>
                <span class="fw-bold">Affiliate Withdraw Request</span>
            </div>
        </div>
    </div>

    <section class="my-address-main">
        <div class="container pt-2">
            {{-- @include('layouts.frontend.partials.customerHeader') --}}

            <div class="row mb-4 mb-lg-5 pb-lg-5">
                <div class="col-xl-3 col-lg-2 col-md-12 mb-4 mb-lg-0 d-none d-lg-block">
                    @include('layouts.frontend.partials.customerSidebar')
                </div>

                <div class="col-xl-9 col-lg-10 col-md-12">
                    <!-- [Main] Start -->
                    <div class="dashboard-content p-0 border-0">

                        {{-- Affiliate Info Section --}}
                        <div class="card border">
                            <div class="card-header border-bottom">
                                <h3 class="mb-0">Affiliate Withdraw Request</h3>
                            </div>
                            <div class="card-body">
                                <div class="row row-cols-1 row-cols-lg-3 p-2">
                                    <div class="col card border rounded text-center bg-success">
                                        <div class="card-body">
                                            <h1 class=" text-white"><i class="bi bi-currency-rupee"></i></h1>
                                            <p class=" text-white">Affiliate Balance</p>
                                            <h1 class=" text-white"><i class="bi bi-currency-rupee"></i>1000.00</h1>
                                        </div>
                                    </div>
                                    <div class="col card border rounded text-center bg-dark">
                                        <div class="card-body">
                                            <h1 class=" text-white"><i class="bi bi-currency-rupee"></i></h1>
                                            <p class=" text-white">Total Requested Balance</p>
                                            <h1 class=" text-white"><i class="bi bi-currency-rupee"></i>100.00</h1>
                                        </div>
                                    </div>
                                    <div class="col card border rounded text-center bg-gray">
                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#awrModal">
                                        <div class="card-body">
                                            <h1 class="fs-1"><i class="bi bi-plus-circle-fill"></i></h1>
                                            <p>Affiliate Withdraw Request</p>
                                        </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="card-footer"></div> --}}
                        </div>

                        {{-- Affiliate Earning History Section --}}
                        <div class="card border">
                            <div class="card-header border-bottom">
                                <h3 class="mb-0">Affiliate Withdraw History</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th class="col-1">#</th>
                                                    <th>Request Amount</th>
                                                    <th>Created At</th>
                                                    <th class="col-1">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>#1</td>
                                                    <td><i class="bx bx-rupee"></i>100</td>
                                                    <td>2022-07-25 22:28:19</td>
                                                    <td><span class="badge text-bg-warning">pending</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="card-footer"></div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <!--End Main Content-->
        </div>
    </section>

</div>
@endsection


@section('script')

<!-- Required datatable js -->
<script src="{{asset('assets/admin/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/admin/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>

<!-- Responsive examples -->
<script src="{{asset('assets/admin/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/admin/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

<!-- init js -->
<script src="{{asset('assets/admin/js/pages/datatables.init.js')}}"></script>

@endsection
