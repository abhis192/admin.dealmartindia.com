@extends('layouts.backend.app')

@section('title')
<title>Add Products | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">Kitchen Price config</h4>

                    <div class="page-title-right">
                        <!-- <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">All Users</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
                        </ol> -->
                        <!-- <a href="{{route('seller.price-list')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-reply-all"></i> Back to list</a> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Filter by ] Start -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Filter by</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="customer" class="form-label fw-bold">Products <sup class="text-danger fs-5">*</sup> :</label>
                                    <select class="form-control select2" id="customer" required>
                                        <option value="all" selected>All Products</option>
                                        <option value="1">Product Name 1</option>
                                        <option value="2">Product Name 2</option>
                                        <option value="3">Product Name 3</option>
                                    </select>
                                    <div class="valid-feedback">Looks good!</div>
                                    <div class="invalid-feedback">This field is required. </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="kitchen" class="form-label fw-bold">Categories <sup class="text-danger fs-5">*</sup> :</label>
                                    <select class="form-control select2" id="kitchen" required>
                                        <option value="all" selected>All Categories</option>
                                        <option value="1">Birthday Cake</option>
                                        <option value="2">Anniversary Cake</option>
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
        </div>

        <!-- [ Data ] start -->
        <div class="row">
            <div class="col-lg-12">
                {{-- <form action="#" class="needs-validation repeater" enctype="multipart/form-data" novalidate> --}}
                <form class="custom-form needs-validation repeater" method="post" action="{{ route('admin.kitchenPrice.store') }}" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h4 class="card-title mb-0">Kitchen Price Configuration</h4>
                        </div>

                        <div class="card-body">
                            @if($products->count())
                            @foreach($products as $key => $product)
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" required="" name="products[{{ $product->id }}][name]" value="{{ $product->name }}" readonly />
                                                    <input type="hidden" name="products[{{ $product->id }}][product_id]" value="{{ $product->id }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    @foreach($product->prices as $index => $price)
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="name" class="form-label fw-bold">{{ $price->qty_weight }} {{ $price->qty_type }}</label>
                                                                <input type="hidden" name="products[{{ $product->id }}][prices][{{ $index }}][qty_type]" value="{{ $price->qty_type }}">
                                                                <input type="hidden" name="products[{{ $product->id }}][prices][{{ $index }}][qty_weight]" value="{{ $price->qty_weight }}">

                                                                <input type="text" name="products[{{ $product->id }}][prices][{{ $index }}][price]" class="form-control" placeholder="Enter Price" value="{{ productConfigKitchenPrice($product->id, $index) }}" readonly/>

                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @endif
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-success waves-effect waves-light" disabled>Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <!-- container-fluid -->
</div>
@endsection

@section('script')
@endsection
