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
                    <h4 class="mb-sm-0 font-size-18">CREATE NEW ORDER</h4>

                    <div class="page-title-right">
                        <!-- <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">All Users</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
                        </ol> -->
                        <a href="{{route('admin.orders')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-reply-all"></i> Back to list</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Data ] start -->
        <div class="row">
            <div class="col-lg-12">
                {{-- <form action="#" class="needs-validation repeater" enctype="multipart/form-data" novalidate> --}}
                <form class="custom-form needs-validation repeater" method="post" action="{{ route('admin.order.store') }}" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- [ Product Price ] Start -->
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Product Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group m-0">
                                                <table class="table table-bordered w-100 table-striped table-sm mb-3">
                                                    <thead>
                                                        <tr><th class="col-4">Product Name</th>
                                                        <th>Qty Weight</th>
                                                        <th>Quantity</th>
                                                        <th>Product Price</th>
                                                        <th class="col-1">Action</th>
                                                    </tr></thead>
                                                    <tbody>
                                                        <tr class="order-multiple">
                                                            <td>
                                                                <input type="text" name="product_name[]" id="name" class="form-control" placeholder="Product Name" required="">
                                                                <div class="valid-feedback">Looks good!</div>
                                                                <div class="invalid-feedback">This field is required. </div>
                                                            </td>

                                                            <td>
                                                                <div class="input-group">
                                                                    <div class="input-group-text p-0">
                                                                        <select name="qty_type[]" class="form-control">
                                                                            <option value="">Qty</option>
                                                                            <option value="gram">G</option>
                                                                            <option value="kg">KG</option>
                                                                            <option value="liter">L</option>
                                                                            <option value="piece">P</option>
                                                                        </select>
                                                                    </div>
                                                                    <input type="text" name="qty_weight[]" class="form-control" placeholder="Eg: 1, 1.5">
                                                                </div>
                                                                <div class="valid-feedback">Looks good!</div>
                                                                <div class="invalid-feedback">This field is required. </div>
                                                            </td>
                                                            <td><input type="text" name="qty[]" class="form-control" placeholder="Eg: 1, 1.5"></td>
                                                            <td>
                                                                <input type="text" name="price[]" class="form-control" placeholder="Price" required="">
                                                                <div class="valid-feedback">Looks good!</div>
                                                                <div class="invalid-feedback">This field is required. </div>
                                                            </td>
                                                            <td><button type="button" class="btn has-ripple btn-success btn-add"><i class="bx bx-plus"></i></button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Billing Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Full Name <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter Your Full Name" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="email" class="form-label fw-bold">Eamil Id <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="bx bx-envelope"></i></div>
                                                    <input type="text" class="form-control" id="email" name="email" placeholder="eg: xyz@mail.com" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="mobile" class="form-label fw-bold">Mobile Number <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="bx bx-mobile"></i></div>
                                                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="eg: 9999888811" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="address" class="form-label fw-bold">Address <sup class="text-danger fs-5">*</sup> :</label>
                                                <textarea type="text" class="form-control" id="address" name="address" placeholder="flat, House No., Building.."></textarea>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="pincode" class="form-label fw-bold">Pincode <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" class="form-control" id="pincode" name="pincode" placeholder="eg: 110044" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="mobile" class="form-label fw-bold">Area <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" class="form-control" id="area" name="landmark" placeholder="eg: meethapur" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="city" class="form-label fw-bold">City <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" class="form-control" id="city" name="city" placeholder="eg: Noida" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="state" class="form-label fw-bold">State <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" class="form-control" id="state" name="state" placeholder="eg: Uttar Pradesh" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="country" class="form-label fw-bold">Country <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" class="form-control" id="country" name="country" placeholder="eg: India" readonly>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div>
                            <!-- end card -->

                        </div>

                        <div class="col-lg-4">

                            <!-- Personalize -->
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Personalize</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="ddate" class="form-label fw-bold">Delivery Date :</label>
                                                <input type="date" name="delivery_date" class="form-control" id="ddate" placeholder="India">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="dtype" class="form-label fw-bold">Delivery Type :</label>
                                                <select class="form-control select2" id="dtype" name="delivery_type" data-select2-id="dtype" tabindex="-1" aria-hidden="true">
                                                    <option data-select2-id="2">Select Type</option>
                                                    {{-- <option value="0">Standard Delivery</option>
                                                    <option value="1">Fixed Time Delivery</option>
                                                    <option value="2">Midnight Delivery</option> --}}
                                                    @foreach($deliveryoptions as $deliveryoption)
                                                    <option value="{{$deliveryoption->option_name}}">{{$deliveryoption->option_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="dtime" class="form-label fw-bold">Choose Delivery Time :</label>
                                                <select class="form-control select2" id="dtime" name="delivery_time" data-select2-id="dtime" tabindex="-1" aria-hidden="true">
                                                    <option data-select2-id="4">Choose Time</option>
                                                    {{-- <option value="0">6 PM - 10 PM</option>
                                                    <option value="1">9 PM - 10 PM</option>
                                                    <option value="2">11 PM - 11:59 PM</option> --}}
                                                    @foreach($slots as $slot)
                                                    <option value="{{$slot->from}}-{{$slot->to}}">{{$slot->from}}-{{$slot->to}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="shipping rate" class="form-label fw-bold">Shipping Rate <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" class="form-control" id="shipping" name="shipping_rate" placeholder="Shipping Rate">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div>

                            <!-- Advance Configuration -->
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Advance Configuration</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-lg-12">
                                            {{-- <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Assign Kitchen :</label>
                                                <select class="form-control select2 select2-hidden-accessible" id="parentCategory" data-select2-id="parentCategory" tabindex="-1" aria-hidden="true">
                                                    <option data-select2-id="6">Choose Kitchen</option>
                                                    <option value="0">Sanjay</option>
                                                    <option value="1">Ravi</option>
                                                    <option value="2">Kishan</option>
                                                    <option value="3">Ramu</option>
                                                    <option value="4">Ganesh</option>
                                                </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="5" style="width: 282.328px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-parentCategory-container"><span class="select2-selection__rendered" id="select2-parentCategory-container" role="textbox" aria-readonly="true" title="Choose Kitchen">Choose Kitchen</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                            </div> --}}
                                            <div class="form-group">
                                                <label class="form-label fw-bold">Assign Kitchen <sup class="text-danger fs-5">*</sup> :</label>
                                                <select class="form-control select2" name="seller_id" required>
                                                    <option value="">Select</option>
                                                    @foreach($sellers as $seller)
                                                        <option value="{{$seller->id}}">{{$seller->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('type_id')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">Choose Source <sup class="text-danger fs-5">*</sup> :</label>
                                                <select class="form-control select2" name="source" required>
                                                    <option value="">Select Source</option>
                                                        <option value="Winni">Winni</option>
                                                        <option value="Fnp">Fnp</option>
                                                        {{-- <option value="Ready To Ship" {{$order->status->order_status == 'Ready To Ship' ? 'selected' : ''}}>Ready To Ship</option>
                                                        <option value="Dispatched" {{$order->status->order_status == 'Dispatched' ? 'selected' : ''}}>Dispatched</option>
                                                        <option value="Out For Delivery" {{$order->status->order_status == 'Out For Delivery' ? 'selected' : ''}}>Out For Delivery</option>
                                                        <option value="Delivered" {{$order->status->order_status == 'Delivered' ? 'selected' : ''}}>Delivered</option>
                                                        @if($order->status->order_status != 'Delivered')
                                                        <option value="Cancelled by admin" {{$order->status->order_status == 'Cancled by admin' ? 'selected' : ''}}>Cancelled by admin</option>
                                                        @endif --}}
                                                </select>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('type_id')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">Choose Source <sup class="text-danger fs-5">*</sup> :</label>
                                                <select class="form-control select2" name="payment" required>
                                                    <option value="">Payment Method</option>
                                                        <option value="COD">COD</option>
                                                        <option value="Online">Online Pay</option>

                                                </select>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('type_id')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div>

                            <!-- Product Image -->
                            {{-- <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Product Image</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <!-- <label class="form-label fw-bold">Profile Image:</label> -->
                                                <div class="dropify-wrapper"><div class="dropify-message"><span class="file-icon"> <p>Drag and drop a file here or click</p></span><p class="dropify-error">Ooops, something wrong appended.</p></div><div class="dropify-loader"></div><div class="dropify-errors-container"><ul></ul></div><input type="file" id="input-file-now" class="dropify"><button type="button" class="dropify-clear">Remove</button><div class="dropify-preview"><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"><p class="dropify-filename"><span class="file-icon"></span> <span class="dropify-filename-inner"></span></p><p class="dropify-infos-message">Drag and drop or click to replace</p></div></div></div></div>
                                                <small class="text-muted"><b>Example::</b> image size - 500x500 </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div> --}}
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Product Thumbnail Image</h4>
                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <input type="file" id="input-file-now" name="image" class="dropify @error('image') is-invalid @enderror" />
                                                <small class="text-muted"><b>Example::</b> image size - 500x500.</small>
                                            </div>
                                            @error('image')
                                                <div class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="col-lg-12">
                            <div class="card action-btn text-end">
                                <div class="card-body p-2">
                                    <button type="reset" class="btn btn-warning waves-effect waves-light">Clear</button>
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- <div class="row">
            <div class="col-xl-12">
                <form class="custom-form needs-validation" method="post" action="{{ route('admin.product.store') }}" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-lg-8">

                            <!-- [ Product Information ] Start -->
                            <div class="card">
                                {{-- <div class="card-header">
                                    <h4 class="card-title mb-0">Product Information</h4>
                                </div> --}}
                                {{-- <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12"> --}}
                                            {{-- <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Product Name <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Your Name" value="{{ old('name') }}" onkeyup="slug_url(this.value,'init_slug')" required/>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('name')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div> --}}
                                        {{-- </div> --}}

                                        {{-- <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Slug <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="input-group">
                                                    <div class="input-group-text">{{env('APP_URL')}}product/</div>
                                                    <input type="text" class="form-control form-control-sm @error('slug') is-invalid @enderror" Placeholder="Enter Uniqe Slug." name="slug" value="{{ old('slug') }}" id="init_slug" required/>
                                                    <div class="valid-feedback">Looks good!</div>
                                                    <div class="invalid-feedback">This field is required. </div>
                                                    @error('slug')
                                                        <div class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div> --}}

                                        {{-- <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Choose Category <sup class="text-danger fs-5">*</sup> :</label>
                                                <select class="form-control select2" name="category_id" id="parentCategory" required>
                                                    <option value="">Select</option>
                                                    @foreach($categories as $category)
                                                        @if($category->subCategories->count())
                                                        <optgroup label="{{$category->name}}">
                                                            @foreach($category->subCategories as $subCategory)
                                                            <option value="{{$subCategory->id}}">{{$subCategory->name}}</option>
                                                            @endforeach
                                                        </optgroup>
                                                        @else
                                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                                        @endif
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
                                        </div> --}}

                                        {{-- <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">Choose Brands <sup class="text-danger fs-5">*</sup> :</label>
                                                <select class="form-control select2" name="brand_id" required>
                                                    <option value="">Select</option>
                                                    @foreach($brands as $brand)
                                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('brand_id')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div> --}}

                                        {{-- <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="sku" class="form-label fw-bold">SKU <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" name="sku" id="sku" class="form-control" value="{{old('sku')}}" placeholder="Enter SKU Number" required/>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                            </div>
                                            @error('sku')
                                                <div class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div> --}}

                                    {{-- </div>
                                </div> --}}
                                <!-- <div class="card-footer"></div> -->
                            {{-- </div> --}}

                            <!-- [ Product Description ] Start -->
                            {{-- <div class="card"> --}}
                                {{-- <div class="card-header">
                                    <h4 class="card-title mb-0">Product Description</h4>
                                </div> --}}
                                {{-- <div class="card-body">

                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="description" class="form-label fw-bold">Description:</label>
                                                <textarea name="description" class="summernote">{{old('description')}}</textarea>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('description')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div> --}}
                            {{-- </div> --}}

                            <!-- [ Product Images Gallery ] Start -->
                            {{-- <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Product Images Gallery</h4>
                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">Images Gallery:</label>
                                                <input type="file" name="gallery[]" id="input-file-now" class="dropify" multiple/>
                                                <small class="text-muted"><b>Example::</b> image size - 1000x1000.</small>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div> --}}

                            <!-- [ Product Variation ] Start -->
                            {{-- <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Product Variation</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-label">Select Multiple Attributes:</label>
                                                <div class="input-group">
                                                    <div class="input-group-text">Attributes</div>
                                                    <select id="choice_attributes" name="attributes[]" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose Attributes...">
                                                        @foreach($attributes as $attribute)
                                                        <option value="{{$attribute->id}}">{{$attribute->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="valid-feedback">Looks good!</div>
                                                    <div class="invalid-feedback">This field is required. </div>
                                                </div>
                                                <small class="text-muted"><b>Note::</b> Choose the attributes of this product and then input values of each attribute. </small>
                                            </div>
                                        </div>

                                        <!-- <div class="row customer_choice_options" id="customer_choice_options"></div> -->

                                        <div class="row customer_choice_options">
                                            @foreach($attributes as $attribute)
                                            <div class="col-lg-12 attributeScript-hide" id="attributeScript-{{$attribute->id}}" style="display: none;">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-text">{{$attribute->name}}</div>
                                                        <select class="select2 form-control select2-multiple attributeValues" multiple="multiple" data-placeholder="Choose Values..." name="attributeValues[{{$attribute->id}}][]">
                                                            @foreach($attribute->attributeValues as $value)
                                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            <!-- [ SEO Meta Tags ] Start -->
                            {{-- <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">SEO Meta Tags</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Meta Title:</label>
                                                <input type="text" id="name" name="meta_title" value="{{old('meta_title')}}" class="form-control @error('meta_title') is-invalid @enderror" placeholder="Enter Your Full Name"/>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('meta_title')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="description" class="form-label">Meta Keywords:</label>
                                                <textarea name="meta_keywords" id="description" class="form-control @error('meta_keywords') is-invalid @enderror" placeholder="Write somthing...">{{old('meta_keywords')}}</textarea>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('meta_keywords')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="meta_description" class="form-label">Meta Description:</label>
                                                <textarea name="meta_description" id="meta_description" class="form-control @error('meta_description') is-invalid @enderror" placeholder="Write somthing...">{{old('meta_description')}}</textarea>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('meta_description')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div> --}}

                        {{-- </div>

                        <div class="col-lg-4">

                            <!-- [ Advance Configuration ] Start -->
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Advance Configuration</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row"> --}}

                                        {{-- <div class="col-lg-12">
                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                <label for="name" class="form-label fw-bold">Published <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="square-switch">
                                                    <input type="checkbox" id="square-switch1" name="published" switch="status" checked/>
                                                    <label for="square-switch1" data-on-label="Yes"
                                                        data-off-label="No"></label>
                                                </div>
                                                @error('published')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div> --}}

                                        {{-- <div class="col-lg-12">
                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                <label for="name" class="form-label fw-bold">Featured <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="square-switch">
                                                    <input type="checkbox" id="square-switch2" name="featured" switch="status" />
                                                    <label for="square-switch2" data-on-label="Yes"
                                                        data-off-label="No"></label>
                                                </div>
                                                @error('featured')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div> --}}

                                        {{-- <div class="col-lg-12">
                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                <label for="name" class="form-label fw-bold">Cash On Delivery <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="square-switch">
                                                    <input type="checkbox" id="square-switch4" name="cash_on_delivery" switch="status" />
                                                    <label for="square-switch4" data-on-label="Yes"
                                                        data-off-label="No"></label>
                                                </div>
                                                @error('cash_on_delivery')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div> --}}

                                        {{-- <div class="col-lg-12">
                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                <label for="is_refundable" class="form-label fw-bold">Refundable :</label>
                                                <div class="square-switch">
                                                    <input type="checkbox" id="square-switch5" name="is_refundable" switch="status"/>
                                                    <label for="square-switch5" data-on-label="Yes"
                                                        data-off-label="No"></label>
                                                </div>
                                                @error('is_refundable')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div> --}}
{{--
                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div> --}}

                            <!-- [ Product Price ] Start -->
                            {{-- <div class="card">
                                {{-- <div class="card-header">
                                    <h4 class="card-title mb-0">Product Price</h4>
                                </div> --}}
                                {{-- <div class="card-body">
                                    <div class="row"> --}}

                                        {{-- <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Regular price <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="bx bx-rupee fs-4"></i></div>
                                                    <input type="text" id="name" name="regular_price" class="form-control @error('regular_price') is-invalid @enderror" value="{{old('regular_price')}}" placeholder="Enter Regular price..." required/>
                                                    <div class="valid-feedback">Looks good!</div>
                                                    <div class="invalid-feedback">This field is required. </div>
                                                </div>
                                                @error('regular_price')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                                <!-- <small class="text-muted"><b>Note::</b> Default Shipping is <b>3 Days</b>. </small> -->
                                            </div>
                                        </div> --}}

                                        {{-- <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Sale price:</label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="bx bx-rupee fs-4"></i></div>
                                                    <input type="text" id="name" name="sale_price" class="form-control @error('sale_price') is-invalid @enderror" value="{{old('sale_price')}}" placeholder="Enter Sale price..." />
                                                    <div class="valid-feedback">Looks good!</div>
                                                    <div class="invalid-feedback">This field is required. </div>
                                                </div>
                                                @error('sale_price')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                                <!-- <small class="text-muted"><b>Note::</b> Default Shipping is <b>3 Days</b>. </small> -->
                                            </div>
                                        </div> --}}
                                    {{-- </div>
                                </div> --}}
                                <!-- <div class="card-footer"></div> -->
                            {{-- </div> --}}

                            <!-- [ Product Images ] Start -->
                            {{-- <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Product Thumbnail Image</h4>
                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <input type="file" id="input-file-now" name="image" class="dropify @error('image') is-invalid @enderror" />
                                                <small class="text-muted"><b>Example::</b> image size - 1000x1000.</small>
                                            </div>
                                            @error('image')
                                                <div class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div> --}}

                            <!-- [ Estimate Shipping Time ] Start -->
                            {{-- <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Estimate Shipping Time</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Shipping Days:</label>
                                                <div class="input-group">
                                                    <input type="text" id="name" class="form-control @error('shipping_days') is-invalid @enderror" name="shipping_days" value="{{old('shipping_days')}}" placeholder="Enter Shipping Days"/>
                                                    <div class="input-group-text">days</div>
                                                    <div class="valid-feedback">Looks good!</div>
                                                    <div class="invalid-feedback">This field is required. </div>
                                                </div>
                                                @error('shipping_days')
	                                                <div class="text-danger">
	                                                    <strong>{{ $message }}</strong>
	                                                </div>
	                                            @enderror
                                                <small class="text-muted"><b>Note::</b> Default Shipping is <b>3 Days</b>. </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div> --}}

                            <!-- [ Stock Configuration ] Start -->
                            {{-- <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Stock Configuration</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Product Stock:</label>
                                                <input type="number" id="name" name="in_stock" value="{{old('in_stock')}}" min="0" class="form-control @error('in_stock') is-invalid @enderror" placeholder="Enter Stock" />
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('in_stock')
	                                                <div class="text-danger">
	                                                    <strong>{{ $message }}</strong>
	                                                </div>
	                                            @enderror
                                                <!-- <small class="text-muted"><b>Note::</b> Default Shipping is <b>3 Days</b>. </small> -->
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Low Stock Quantity Warning:</label>
                                                <input type="number" id="name" class="form-control @error('stock_warning') is-invalid @enderror" value="{{old('stock_warning')}}" min="1" name="stock_warning" placeholder="Enter Stock Warning" />
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('stock_warning')
	                                                <div class="text-danger">
	                                                    <strong>{{ $message }}</strong>
	                                                </div>
	                                            @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div> --}}

                            <!-- [ Refund Request Configuration ] Start -->
                            <!-- <div class="card d-none">

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="refundTime" class="form-label fw-bold">Set Time for sending Refund Request:</label>
                                                <div class="input-group">
                                                    <input type="text" name="refundable_day" class="form-control" id="refundTime" placeholder="Enter Refund Time..." />
                                                    <div class="input-group-text">Day</div>
                                                    <div class="valid-feedback">Looks good!</div>
                                                    <div class="invalid-feedback">This field is required. </div>
                                                </div>
                                                <small class="text-muted"><b>Note::</b> Default Refund Time is <b>7 Days</b>.</small>
                                                {{-- @error('refundable_day')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror --}}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>   -->

                        {{-- </div>

                        <div class="col-lg-12"> --}}

                            <!-- [ Action Button ] Start -->
                            {{-- <div class="card action-btn text-end">
                                <div class="card-body p-2">
                                    <button type="reset" class="btn btn-warning waves-effect waves-light">Clear</button>
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
                                </div>
                            </div> --}}
                        {{-- </div>

                    </div>
                </form>
            </div> <!-- end col -->
        </div> <!-- end row --> --}}


    {{-- </div> --}}
    <!-- container-fluid -->
{{-- </div> --}}
@endsection

@section('script')

<script type="text/javascript">
    $('#choice_attributes').on('change', function() {
        $('.attributeScript-hide').hide();
        $.each($('#choice_attributes').val(), function(key, value){
            var service_id = '#attributeScript-' + value;
            $(service_id).show();
        });
    });
</script>

<script>
    $('#pincode').on('blur', function() {
            var pincode = $(this).val();

            $.ajax({
                url: 'https://api.postalpincode.in/pincode/' + pincode,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data && data[0].Status === 'Success') {
                        var state = data[0].PostOffice[0].State;
                        var city = data[0].PostOffice[0].Block;
                        var country = data[0].PostOffice[0].Country;

                        $('#state').val(state);
                        $('#city').val(city);
                        $('#country').val(country);

                        $('.state').val(state);
                        $('.city').val(city);
                        $('.country').val(country);
                    } else {
                        $('#state').val('');
                        $('#city').val('');
                        $('#country').val('');
                    }
                },
                error: function() {
                    $('#state').val('');
                    $('#city').val('');
                    $('#country').val('');
                }
            });
        });
</script>
<script>
    $(".select2-multiple-tag").select2({
        tags: true,
        tokenSeparators: [',', ' ']
    })

    $(function () {

        var addFormGroup = function (event) {
            event.preventDefault();

            var $formGroup = $(this).closest('.order-multiple');
            var $multipleFormGroup = $formGroup.closest('.multiple-form-group');
            var $formGroupClone = $formGroup.clone();

            $(this)
                .toggleClass('btn-add btn-danger btn-remove')
                .html('<i class="bx bx-minus"></i>');

            $formGroupClone.find('input').val('');
            $formGroupClone.insertAfter($formGroup);

            var $lastFormGroupLast = $multipleFormGroup.find('.order-multiple:last');
            if ($multipleFormGroup.data('max') <= countFormGroup($multipleFormGroup)) {
                $lastFormGroupLast.find('.btn-add').attr('disabled', true);
            }
        };

        var removeFormGroup = function (event) {
            event.preventDefault();

            var $formGroup = $(this).closest('.order-multiple');
            var $multipleFormGroup = $formGroup.closest('.multiple-form-group');

            var $lastFormGroupLast = $multipleFormGroup.find('.order-multiple:last');
            if ($multipleFormGroup.data('max') >= countFormGroup($multipleFormGroup)) {
                $lastFormGroupLast.find('.btn-add').attr('disabled', false);
            }

            $formGroup.remove();
        };

        var countFormGroup = function ($form) {
            return $form.find('.form-group').length;
        };

        $(document).on('click', '.btn-add', addFormGroup);
        $(document).on('click', '.btn-remove', removeFormGroup);

    });

</script>

@endsection
