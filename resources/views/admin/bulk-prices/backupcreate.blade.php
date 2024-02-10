@extends('layouts.backend.app')

@section('title')
<title>Create New Price</title>
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
                    <h4 class="mb-sm-0 font-size-18">Add New Bulk Price</h4>

                    <div class="page-title-right">
                        <a href="{{route('admin.bulk-prices')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-reply-all"></i> Back to list</a>
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-12">
                <form class="custom-form needs-validation repeater" method="post" action="{{ route('admin.bulk-price.store') }}" enctype="multipart/form-data" novalidate>
                    @csrf

                    <div class="row">
                        <div class="col-lg-8">

                            <!-- [ Product Information ] Start -->
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Product Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="selectProduct" class="form-label fw-bold">Choose Product <sup class="text-danger fs-5">*</sup> :</label>
                                                <select class="form-control select2" id="selectProduct" name="product_id" required>
                                                    <option value="">Select Product</option>
                                                    @foreach($products as $product)
                                                    <option value="{{$product->id}}">{{$product->name}} - [₹ {{$product->sale_price??$product->regular_price}}]</option>
                                                    @endforeach
                                                </select>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                            </div>
                                        </div>

                                        {{-- <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="selectProduct" class="form-label fw-bold">Choose City <sup class="text-danger fs-5">*</sup> :</label>
                                                <select class="form-control select2" id="selectProduct" name="city_id" required>
                                                    <option value="">Select Product</option>
                                                    @foreach($cities as $city)
                                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                            </div>
                                        </div> --}}

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Select Multiple Cities <sup class="text-danger fs-5">*</sup> :</label>
                                                <select class="form-control select2" name="city_id[]" id="parentCategory" multiple required>
                                                    <option value="">Select</option>
                                                    @foreach($cities as $city)

                                                        <option value="{{$city->id}}">{{$city->name}}</option>

                                                    @endforeach
                                                </select>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('category_id')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group m-0">
                                                <label for="selectProduct" class="form-label fw-bold">Setup Price <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="repeater-box">
                                                    <div data-repeater-list="pricing_rules">
                                                        <div data-repeater-item class="row">
                                                            <div class="mb-3 col-lg-5">
                                                                <label for="minqty">Min Qty<sup class="text-danger fs-5">*</sup></label>
                                                                <input type="text" id="minqty" class="form-control" placeholder="Min Qty..." name="min_quantity" />
                                                            </div>
                                                            <div class="mb-3 col-lg-5">
                                                                <label for="pp">Price/product<sup class="text-danger fs-5">*</sup></label>
                                                                <input type="text" id="pp" class="form-control" placeholder="Price/product..." name="price" />
                                                            </div>
                                                            <div class="mb-3 mt-4 col-lg-2 align-self-center">
                                                                <div class="d-grid">
                                                                    <input data-repeater-delete type="button" class="btn btn-danger" value="Delete"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input data-repeater-create type="button" class="btn btn-success mt-3 mt-lg-0" value="Add"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div>

                        </div>


                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Advance Configuration</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                <label for="name" class="form-label fw-bold">Published <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="square-switch">
                                                    <input type="checkbox" id="square-switch1" switch="status" checked="" name="status">
                                                    <label for="square-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div>

                        </div>

                        <div class="col-lg-12">

                            <!-- [ Action Button ] Start -->
                            <div class="card action-btn text-end">
                                <div class="card-body p-2">
                                    <button type="reset" class="btn btn-warning waves-effect waves-light">Clear</button>
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>

            </div> <!-- end col -->
        </div> <!-- end row -->

    </div>
    <!-- container-fluid -->
</div>
@endsection

@section('script')
<!-- form repeater js -->
<script src="{{asset('assets/admin/libs/jquery.repeater/jquery.repeater.min.js')}}"></script>
<script src="{{asset('assets/admin/js/pages/form-repeater.int.js')}}"></script>
@endsection
