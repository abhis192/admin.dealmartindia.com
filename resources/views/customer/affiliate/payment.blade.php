@extends('layouts.frontend.customerapp')

@section('title')
<title>Payment History | {{env('APP_NAME')}}</title>
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
                <span class="fw-bold">Payment History</span>
            </div>
        </div>
    </div>

    <section class="my-address-main">
        <div class="container pt-2">

            <div class="row mb-4 mb-lg-5 pb-lg-5">
                <div class="col-xl-3 col-lg-2 col-md-12 mb-4 mb-lg-0 d-none d-lg-block">
                    @include('layouts.frontend.partials.customerSidebar')
                </div>

                <div class="col-xl-9 col-lg-10 col-md-12">
                    <!-- [Main] Start -->
                    <div class="dashboard-content p-0 border-0">

                        {{-- Payment History Section --}}
                        <div class="card border">
                            <div class="card-header border-bottom">
                                <h3 class="mb-0">Payment History</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th class="col-1">#</th>
                                                    <th>Amount</th>
                                                    <th>Payment method</th>
                                                    <th>Created At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>#1</td>
                                                    <td><i class="bx bx-rupee"></i>100</td>
                                                    <td>Bank Transfer</td>
                                                    <td>2022-07-25 22:28:19</td>
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
