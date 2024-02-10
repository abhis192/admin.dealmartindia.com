@extends('layouts.backend.app')

@section('title')
<title>Payout Configuration | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">Payout Configuration</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">Payout Configuration</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-12">
                <form method="post" action="{{route('admin.payout-configuration.update',$data->id)}}">
                    @method('PATCH')
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">

                            <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h4 class="card-title mb-0">Payout Calculation Date</h4>
                                    <div class="square-switch">
                                        <input type="checkbox" name="payout_status" id="square-switch5" switch="status" {{ $data->payout_status == 1 ? "checked" : "" }}/>
                                        <label class="mb-0" for="square-switch5" data-on-label="Yes" data-off-label="No"></label>
                                        @error('payout_status')
                                            <div class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="refundTime" class="form-label fw-bold">Payout Calculation Date:</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control @error('payout_calculation_date') is-invalid @enderror" name="payout_calculation_date" id="refundTime" value="{{$data->payout_calculation_date}}"/>
                                                    <div class="input-group-text">Date</div>
                                                </div>
                                                <small class="text-muted"><b>Note::</b> Default Payout Calculation Time is <b>{{$data->payout_calculation_date}} Date</b>.</small>
                                                @error('payout_calculation_date')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
                                </div>
                            </div>
                            <!-- end card -->

                        </div>

                        {{-- <div class="col-lg-6">

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Withdraw Kitchen Amount</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="refundTime" class="form-label fw-bold">Minimum Kitchen Amount Withdraw:</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control @error('min_seller_withdraw') is-invalid @enderror" id="refundTime" placeholder="Enter minimum kitchen Amount withdraw..." name="min_seller_withdraw" value="{{$data->min_seller_withdraw}}" />
                                                    <div class="input-group-text"><i class="bx bx-rupee"></i></div>
                                                    @error('min_seller_withdraw')
                                                        <div class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                                <small class="text-muted"><b>Note::</b> Default Minimum Kitchen Amount Withdraw is <b><i class="bx bx-rupee"></i>2500</b>.</small>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
                                </div>
                            </div>
                            <!-- end card -->

                        </div> --}}

                        {{-- <div class="col-lg-6">

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Kitchen Commission Calculation Time in day</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="refundTime" class="form-label fw-bold">Kitchen Commission Calculation Time :</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="refundTime" placeholder="Enter Kitchen Commission Calculation Time ..." spellcheck="false" data-ms-editor="true" name="seller_commission_day" value="{{$data->seller_commission_day}}">
                                                    <div class="input-group-text">Day</div>
                                                </div>
                                                <small class="text-muted"><b>Note::</b> Default Kitchen Commission Calculation Time is <b>7 Day</b>.</small>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
                                </div>
                            </div>
                            <!-- end card -->

                        </div> --}}

                    </div>
                </form>
            </div> <!-- end col -->
        </div> <!-- end row -->


    </div>
    <!-- container-fluid -->
</div>
@endsection
