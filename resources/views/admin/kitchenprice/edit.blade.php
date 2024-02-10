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
                    <h4 class="mb-sm-0 font-size-18">Add Kitchen Price</h4>

                    <div class="page-title-right">
                        <!-- <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">All Users</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
                        </ol> -->
                        <a href="{{route('admin.kitchen-price')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-reply-all"></i> Back to list</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Data ] start -->
        <div class="row">
            <div class="col-lg-12">
                <form class="custom-form needs-validation repeater" method="post" action="{{ route('admin.kitchen-price.store') }}" enctype="multipart/form-data" novalidate>
                    @csrf

                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h4 class="card-title mb-0">Kitchen Price</h4>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name" class="form-label fw-bold">Choose Kitchen</label>
                                        <select class="form-control select2" name="kitchen_id" required>
                                            <option value="">Select Kitchen</option>
                                            @foreach($user as $users)
                                                <option value="{{$users->id}}">{{$users->name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="valid-feedback">Looks good!</div>
                                        <div class="invalid-feedback">This field is required. </div>
                                        @error('kitchen_id')
                                            <div class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name" class="form-label fw-bold">Choose Product</label>
                                        <select class="form-control select2" name="product_id" id="productSelect"  required>
                                            <option value="">Select Product</option>
                                            @foreach($products as $product)
                                                <option value="{{$product->id}}">{{$product->name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="valid-feedback">Looks good!</div>
                                        <div class="invalid-feedback">This field is required.</div>
                                        @error('product_id')
                                            <div class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="row" id="priceFieldsContainer">
                                        <!-- Price fields will be dynamically added here using jQuery -->
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    <!-- container-fluid -->
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        // Trigger the change event on page load to populate the initial price fields
        $('#productSelect').trigger('change');

        // Handle product selection change
        $('#productSelect').on('change', function () {
            var productId = $(this).val();

            // AJAX request to fetch product prices based on the selected product
            $.ajax({
                url: '/get-product-prices/' + productId, // Replace with your route to fetch product prices
                type: 'GET',
                success: function (response) {
                    // Clear existing price fields
                    $('#priceFieldsContainer').empty();

                    // Create an array to store the prices
                    var pricesArray = [];

                    // Add new price fields based on the response
                    $.each(response.prices, function (index, price) {
                        var priceField = '<div class="col">' +
                            '<div class="form-group">' +
                            '<label for="name" class="form-label fw-bold">' + price.qty_weight + ' ' + price.qty_type + '</label>' +
                            '<input type="text" name="prod[' + index + '][price]" class="form-control" placeholder="Enter Price" value="" />' +
                            '<input type="hidden" name="prod[' + index + '][qty_weight]" value="' + price.qty_weight + '" />' +
                            '<input type="hidden" name="prod[' + index + '][qty_type]" value="' + price.qty_type + '" />' +
                            '</div>' +
                            '</div>';

                        // Append the price fields HTML
                        $('#priceFieldsContainer').append(priceField);

                        // Add the price details to the array
                        pricesArray.push({
                            price: price.price,
                            qty_weight: price.qty_weight,
                            qty_type: price.qty_type
                        });
                    });

                    // Now 'pricesArray' contains the desired structure
                    // Flatten the array structure within the 'prod' key
                    var flattenedArray = [].concat.apply([], pricesArray);

                    // Display the flattened array in the console
                    // console.log(flattenedArray);
                },
                error: function () {
                    console.log('Error fetching product prices.');
                }
            });
        });
    });
</script>

@endsection
