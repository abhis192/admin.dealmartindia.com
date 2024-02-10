@extends('layouts.backend.app')

@section('title')
<title>Payout Request | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">Payout Request</h4>

                    <div class="page-title-right">
                        <!-- <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">Payout Request</li>
                        </ol>  -->
                        <a href="#" class="btn btn-primary waves-effect waves-light" title="Withdraw Amount" data-bs-toggle="modal" data-bs-target="#withdrawAmount"><i class="bx bx-money font-size-16"></i> Withdraw Amount</a>
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card border">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Seller Withdraw Request</h4>
                    </div>
                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="col-1">#</th>
                                    <th>Requested Amount</th>
                                    <th>Total Amount to Pay</th>
                                    <th class="col-1">Created At</th>
                                    <th class="col-1">Status</th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach($payouts as $key => $payout)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>
                                        <b><i class="bx bx-rupee"></i>{{$payout->requested_amt}}.00</b>
                                    </td>
                                    <td>
                                        <b><i class="bx bx-rupee"></i>{{$payout->total_amt}}.00</b>
                                    </td>
                                    <td>{{$payout->created_at}}</td>
                                    <td>
                                        @if($payout->status == "Pending")
                                        <span class="badge badge-soft-warning font-size-14">{{$payout->status}}</span>
                                        @elseif($payout->status == "Successful")
                                        <span class="badge badge-soft-success font-size-14">{{$payout->status}}</span>
                                        @else
                                        <span class="badge badge-soft-danger font-size-14">{{$payout->status}}</span>
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

<!-- [ Withdraw Amount Request Modal ] start -->
<div id="withdrawAmount" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="post" action="{{route('seller.payout.store')}}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Withdraw Amount Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <th>Remaining Amounts</th>
                                    <td><i class="bx bx-rupee "></i>{{Auth::user()->wallet_balance}}</td>
                                    <input type="hidden" name="total_amt" value="{{Auth::user()->wallet_balance}}">
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="col-from-label" for="amount">Request Amount <sup class="text-danger fs-5">*</sup> :</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bx bx-rupee fs-3"></i></div>
                                <input type="number" lang="en" min="{{$payout_commission->min_seller_withdraw}}" step="1" name="amount" id="amount" value="10" class="form-control" required/>
                            </div>
                            <small class="text-muted"><b>Note::</b> Minimum withdraw amount is <b><i class="bx bx-rupee"></i>{{$payout_commission->min_seller_withdraw}}</b>. </small>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="col-from-label" for="amount">Description:</label>
                            <textarea name="description" class="form-control" rows="5"></textarea>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success waves-effect waves-light">Submit</button>
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@endsection
