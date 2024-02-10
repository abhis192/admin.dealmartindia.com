@extends('layouts.backend.app')

@section('title')
<title>Payent Methods | Admin</title>
@endsection

@section('css')
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Payent Methods</h4>

                    <div class="page-title-right">
                        <!-- <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">All Banner</li>
                        </ol> -->
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">

                <form action="{{route('admin.gateway.update',$razorpay->id)}}" method="POST" class="needs-validation" novalidate="">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h4 class="card-title mb-0">RazorPay</h4>
                                    <div class="square-switch">
                                        <input type="checkbox" id="square-switch{{$razorpay->id}}" switch="status" name="status" {{ $razorpay->status == 1 ? "checked" : "" }}>
                                        <label class="mb-0" for="square-switch{{$razorpay->id}}" data-on-label="Yes" data-off-label="No"></label>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="refundTime" class="form-label fw-bold">Business Name <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" class="form-control" id="refundTime" placeholder="Enter Refund Time..." required="" spellcheck="false" data-ms-editor="true" name="business_name" value="{{$razorpay->name}}">
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="refundTime" class="form-label fw-bold">Key Id: <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" class="form-control" id="refundTime" placeholder="Enter Refund Time..." required="" spellcheck="false" data-ms-editor="true" name="key" value="{{$razorpay->key}}">
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="refundTime" class="form-label fw-bold">Key Secret: <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" class="form-control" id="refundTime" placeholder="Enter Refund Time..." required="" spellcheck="false" data-ms-editor="true" name="secret" value="{{$razorpay->secret}}">
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
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
                        {{-- <div class="col-lg-12">

                            <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h4 class="card-title mb-0">PayTm</h4>
                                    <div class="square-switch">
                                        <input type="checkbox" id="square-switch5" switch="status" />
                                        <label class="mb-0" for="square-switch5" data-on-label="Yes" data-off-label="No"></label>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="refundTime" class="form-label fw-bold">Business Name <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" class="form-control" id="refundTime" placeholder="Enter Refund Time..." required/>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="refundTime" class="form-label fw-bold">Key Id: <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" class="form-control" id="refundTime" placeholder="Enter Refund Time..." required/>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="refundTime" class="form-label fw-bold">Key Secret: <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" class="form-control" id="refundTime" placeholder="Enter Refund Time..." required/>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
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
        </div>

    </div>
</div>
@endsection
