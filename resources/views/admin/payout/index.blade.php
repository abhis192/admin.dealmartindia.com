@extends('layouts.backend.app')

@section('title')
<title>Payouts | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">All Payouts</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">All Payouts</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card border">
                    <!-- <div class="card-header"></div> -->
                    <div class="card-body">

                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="col-1">#</th>
                                    <th>Kitchen Name/Mobile No.</th>
                                    <th>Amount</th>
                                    <th class="col-1">Created At</th>
                                    <th class="col-1">Payment Method</th>
                                    <th class="col-1">Status</th>
                                    <th class="col-1">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($payouts as $key => $payout)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>
                                        <p class="m-0"><b>{{$payout->user->name}}</b></p>
                                        <p class="m-0">[{{$payout->user->mobile}}]</p>
                                    </td>
                                    <td>
                                        <b><i class="bx bx-rupee"></i>{{$payout->total_amt}}</b>
                                    </td>
                                    <td>{{date('d M Y | h:i A',strtotime($payout->created_at))}}</td>
                                    <td>
                                        {{-- <span class="badge badge-pill badge-soft-success font-size-12 p-2 border w-md">Online</span> --}}
                                        @if($payout->payment_mode == "cash")
                                        <span class="badge badge-pill badge-soft-success font-size-12 p-2 border w-md">{{$payout->payment_mode}}</span>
                                        @elseif($payout->payment_mode == "bank")
                                        <span class="badge badge-pill badge-soft-success font-size-12 p-2 border w-md">{{$payout->payment_mode}}</span>
                                        @elseif($payout->payment_mode == "upi")
                                        <span class="badge badge-pill badge-soft-success font-size-12 p-2 border w-md">{{$payout->payment_mode}}</span>
                                        @else
                                        <span class="badge badge-pill badge-soft-success font-size-12 p-2 border w-md">{{$payout->payment_mode}}</span>
                                        @endif

                                    </td>
                                    <td>
                                        @if($payout->status == 'pending')
                                        <span class="badge badge-pill badge-soft-danger font-size-12 p-2 border w-md">Pending </span>
                                        @elseif($payout->status == 'success')
                                        <span class="badge badge-pill badge-soft-success font-size-12 p-2 border w-md">Success</span>
                                        @else
                                        <span class="badge badge-pill badge-soft-danger font-size-12 p-2 border w-md">Pending</span>
                                        @endif
                                        {{-- <span class="badge badge-pill badge-soft-danger font-size-12 p-2 border w-md">UnPaid</span> --}}
                                        {{-- <span class="badge badge-pill badge-soft-success font-size-12 p-2 border w-md">Paid</span> --}}
                                    </td>
                                    <td class="text-center">
                                        {{-- <a href="javascript:void(0);" class="btn btn-soft-info btn-sm waves-effect waves-light" title="Pay Now" data-bs-toggle="modal" data-bs-target="#payNow{{$key+1}}"><i class="bx bx-money font-size-16"></i></a> --}}

                                        {{-- <a href="javascript:void(0);" class="btn btn-soft-success btn-sm waves-effect waves-light" title="View Details" data-bs-toggle="modal" data-bs-target="#prView"><i class="mdi mdi-eye font-size-16"></i></a> --}}

                                        {{-- <a href="" class="btn btn-soft-warning btn-sm waves-effect waves-light" title="Payment History"><i class="bx bx-history font-size-16"></i></a> --}}

                                        @if($payout->status != 'success')
                                        <a href="javascript:void(0);" class="btn btn-soft-info btn-sm waves-effect waves-light" title="Pay Now" data-bs-toggle="modal" data-bs-target="#payNow{{$key+1}}"><i class="bx bx-money font-size-16"></i></a>
                                        @else
                                        <a href="javascript:void(0);" class="btn btn-soft-success btn-sm waves-effect waves-light" title="View Details" data-bs-toggle="modal" data-bs-target="#prView{{$key+1}}"><i class="mdi mdi-eye font-size-16"></i></a>
                                        <a href="{{route('admin.payout.invoice',$payout->id)}}" class="btn btn-soft-info btn-sm waves-effect waves-light" title="Download Invoice"><i class="bx bx-download font-size-16"></i></a>
                                        @endif
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



<!-- [ Pay Now Modal ] start -->
@foreach($payouts as $key => $payout)
<div id="payNow{{$key+1}}" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{route('admin.payout.payment',$payout->id)}}" method="POST" class="modal-content">
            @csrf
        {{-- <form class="modal-content" method="post" action="">
            @method('PATCH')
            @csrf --}}
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Pay to Kitchen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr class="table-success">
                                    <th colspan="2">UPI/Bank Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Holders Name</td>
                                    <td></td>
                                    {{-- <td>{{$payout->user->bank->holders_name??''}}</td> --}}
                                </tr>
                                <tr>
                                    <td>Bank Name</td>
                                    <td></td>
                                    {{-- <td>{{$payout->user->bank->bank_name??''}}</td> --}}
                                </tr>
                                <tr>
                                    <td>Bank Account Number</td>
                                    <td></td>
                                    {{-- <td>{{$payout->user->bank->account_no??''}}</td> --}}
                                </tr>
                                <tr>
                                    <td>IFSC Code</td>
                                    <td></td>
                                    {{-- <td>{{$payout->user->bank->ifsc_code??''}}</td> --}}
                                </tr>
                                <tr>
                                    <td>UPI Name</td>
                                    <td></td>
                                    {{-- <td>{{$payout->user->upi->upi_name??''}}</td> --}}
                                </tr>
                                <tr>
                                    <td>UPI Id</td>
                                    <td></td>
                                    {{-- <td>{{$payout->user->upi->upi_id??''}}</td> --}}
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label fw-bold" for="payment_option">Payment method <sup class="text-danger fs-5">*</sup> :</label>
                            <select name="payment_mode" id="payment_option" class="form-control" required>
                                <option value="" selected>Select Payment Method</option>
                                <option value="bank">Bank Payment</option>
                                <option value="upi">UPI</option>
                                <option value="cash">Cash</option>
                            </select>
                        </div>
                    </div>

                    {{-- <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label fw-bold" for="payment_option">Status <sup class="text-danger fs-5">*</sup> :</label>
                            <select name="payment_mode" id="payment_option" class="form-control" required>
                                <option value="" selected>Status</option>
                                <option value="unpaid">UnPaid</option>
                                <option value="paid">Paid</option>
                            </select>
                        </div>
                    </div> --}}

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="col-from-label" for="amount">Amount <sup class="text-danger fs-5">*</sup> :</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bx bx-rupee fs-3"></i></div>
                                <input type="number" lang="en" min="0" step="0.01" name="amount" id="amount" value="{{$payout->total_amt}}" class="form-control" required="" disabled/>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="col-from-label" for="amount">Description:</label>
                            <textarea name="description" class="form-control" rows="5" ></textarea>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success waves-effect waves-light">Pay</button>
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- [ Payout View Modal ] start -->
@foreach($payouts as $key => $payout)
<div id="prView{{$key+1}}" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Payout Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <th>Kitchen Name</th>
                                    {{-- <td>Amit</td> --}}
                                    <td>{{$payout->user->name}}</td>
                                </tr>
                                <tr>
                                    <th>Store Name</th>
                                    {{-- <td>cake4ever</td> --}}
                                    <td>{{$payout->user->business}}</td>
                                </tr>
                                <tr>
                                    <th>Amount</th>
                                    {{-- <td><i class="bx bx-rupee "></i>2000</td> --}}
                                    <td><i class="bx bx-rupee "></i>{{$payout->total_amt}}</td>
                                </tr>
                                <tr>
                                    <th>Payment Method</th>
                                    <td>{{$payout->payment_mode}}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{$payout->status}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="col-from-label" for="amount">Description:</label>
                            <textarea name="description" class="form-control" rows="5" disabled></textarea>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-success waves-effect waves-light">Pay</button> -->
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@endforeach
@endforeach

@endsection
