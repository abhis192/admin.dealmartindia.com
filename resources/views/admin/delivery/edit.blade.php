@extends('layouts.backend.app')

@section('title')
<title>Edit Products | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">Add Product</h4>

                    <div class="page-title-right">
                        <!-- <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">All Users</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
                        </ol> -->
                        <a href="{{route('admin.product')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-reply-all"></i> Back to list</a>
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-12">

                <form class="custom-form needs-validation" method="post" action="{{ route('admin.product.update',$product->id) }}" enctype="multipart/form-data" novalidate>
                    @method('PATCH')
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
                                                <label for="name" class="form-label fw-bold">Product Name <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Your Banner..." value="{{$product->name}}" required />
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('name')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Slug <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="input-group">
                                                    <div class="input-group-text">{{env('APP_URL')}}product/</div>
                                                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{$product->slug}}" id="slug" required />
                                                    <div class="valid-feedback">Looks good!</div>
                                                    <div class="invalid-feedback">This field is required. </div>
                                                    @error('slug')
	                                                    <div class="text-danger">
	                                                        <strong>{{ $message }}</strong>
	                                                    </div>
	                                                @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Choose Category <sup class="text-danger fs-5">*</sup> :</label>
                                                <select class="form-control select2" id="parentCategory" name="category_id" required>
                                                    <option value="">Select</option>
                                                    @foreach($categories as $category)
                                                        @if(!empty($product->category))
                                                            @if($category->subCategories->count())
                                                            <optgroup label="{{$category->name}}">
                                                                @foreach($category->subCategories as $subCategory)
                                                                <option value="{{$subCategory->id}}" {{ $subCategory->id == $product->category->id ? 'selected' : '' }}>{{$subCategory->name}}</option>
                                                                @endforeach
                                                            </optgroup>
                                                            @else
                                                            <option value="{{$category->id}}" {{ $category->id == $product->category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                                            @endif
                                                        @else
                                                            @if($category->subCategories->count())
                                                            <optgroup label="{{$category->name}}">
                                                                @foreach($category->subCategories as $subCategory)
                                                                <option value="{{$subCategory->id}}">{{$subCategory->name}}</option>
                                                                @endforeach
                                                            </optgroup>
                                                            @else
                                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                                            @endif
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
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Choose Brands <sup class="text-danger fs-5">*</sup> :</label>
                                                <select class="form-control select2" id="parentCategory" name="brand_id" required>
                                                    <option value="">Select</option>
                                                    @foreach($brands as $brand)
                                                        @if(!empty($product->brand))
                                                        <option value="{{$brand->id}}" {{ $brand->id == $product->brand->id ? 'selected' : '' }}>{{$brand->name}}</option>
                                                        @else
                                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                                        @endif
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
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="sku" class="form-label fw-bold">SKU <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" name="sku" id="sku" class="form-control" placeholder="Enter SKU Number" value="{{$product->sku}}" required/>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                            </div>
                                            @error('sku')
                                                <div class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div>

                            <!-- [ Product Description ] Start -->
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Product Description</h4>
                                </div>
                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="description" class="form-label fw-bold">Description:</label>
                                                <textarea name="description" class="summernote">{{$product->description}}</textarea>
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
                                </div>
                            </div>

                            <!-- [ Product Images Gallery ] Start -->
                            <div class="card">
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

                                    <div class="row row-cols-2 row-cols-lg-4 mt-3">
                                        @foreach($product->gallery as $index => $gallery)
                                        <div class="col">
                                            <div class="document-box border text-center" id="image{{$index}}">
                                                <div class="remove-doc">
                                                    <div class="removeImage{{$index}} pointer"><i class="fas fa-times"></i></div>
                                                </div>
                                                <img class="img-fluid" src="{{asset('storage/product/'.$gallery->image)}}">
                                                <input type="hidden" name="gallery_images[]" value="{{$gallery->image}}">
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- [ Product Variation ] Start -->
                            <div class="card">
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
                                                        <option
                                                            value="{{$attribute->id}}"
                                                            @foreach($product->attributes as $prodAttr)
                                                                @if($prodAttr->attribute_id == $attribute->id)
                                                                    selected
                                                                @endif
                                                            @endforeach
                                                            >
                                                            {{$attribute->name}}
                                                        </option>
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
                                            <div class="col-lg-12 attributeScript-hide" id="attributeScript-{{$attribute->id}}" {{checkEditAttributeValues($attribute, $product)}}>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-text">{{$attribute->name}}</div>
                                                        <select class="select2 form-control select2-multiple attributeValues" multiple="multiple" data-placeholder="Choose Values..." name="attributeValues[{{$attribute->id}}][]">
                                                            @foreach($attribute->attributeValues as $value)
                                                            <option
                                                                value="{{$value->id}}"
                                                                @foreach($product->attributes as $prodAttr)
                                                                    @if($prodAttr->attribute_values_id == $value->id)
                                                                        selected
                                                                    @endif
                                                                @endforeach
                                                                >
                                                                {{$value->name}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- [ SEO Meta Tags ] Start -->
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">SEO Meta Tags</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Meta Title:</label>
                                                <input type="text" id="name" name="meta_title" value="{{$product->meta_title}}" class="form-control @error('meta_title') is-invalid @enderror" placeholder="Enter Your Full Name"/>
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
                                                <textarea name="meta_keywords" id="description" class="form-control @error('meta_keywords') is-invalid @enderror" placeholder="Write somthing...">{{$product->meta_keywords}}</textarea>
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
                                                <textarea id="meta_description" name="meta_description" class="form-control @error('meta_description') is-invalid @enderror" placeholder="Write somthing...">{{$product->meta_description}}</textarea>
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
                            </div>

                        </div>

                        <div class="col-lg-4">

                            <!-- [ Advance Configuration ] Start -->
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
                                                    <input type="checkbox" id="square-switch1" name="published" switch="status" {{ $product->published == 1 ? "checked" : "" }} />
                                                    <label for="square-switch1" data-on-label="Yes"
                                                        data-off-label="No"></label>
                                                </div>
                                                @error('published')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                <label for="name" class="form-label fw-bold">Featured <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="square-switch">
                                                    <input type="checkbox" id="square-switch2" name="featured" switch="status" {{ $product->featured == 1 ? "checked" : "" }} />
                                                    <label for="square-switch2" data-on-label="Yes"
                                                        data-off-label="No"></label>
                                                </div>
                                                @error('featured')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                <label for="name" class="form-label fw-bold">Cash On Delivery <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="square-switch">
                                                    <input type="checkbox" id="square-switch4" name="cash_on_delivery" switch="status" {{ $product->cash_on_delivery == 1 ? "checked" : "" }} />
                                                    <label for="square-switch4" data-on-label="Yes"
                                                        data-off-label="No"></label>
                                                </div>
                                                @error('cash_on_delivery')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                <label for="is_refundable" class="form-label fw-bold">Refundable :</label>
                                                <div class="square-switch">
                                                    <input type="checkbox" id="square-switch5" name="is_refundable" switch="status" {{ $product->is_refundable == 1 ? "checked" : "" }} />
                                                    <label for="square-switch5" data-on-label="Yes"
                                                        data-off-label="No"></label>
                                                </div>
                                                @error('is_refundable')
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

                            <!-- [ Product Price ] Start -->
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Product Price</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Regular price <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="bx bx-rupee fs-4"></i></div>
                                                    <input type="text" id="name" name="regular_price" class="form-control @error('regular_price') is-invalid @enderror" value="{{$product->regular_price}}" placeholder="Enter Regular price..." required/>
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
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Sale price:</label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="bx bx-rupee fs-4"></i></div>
                                                    <input type="text" id="name" name="sale_price" class="form-control @error('sale_price') is-invalid @enderror" value="{{$product->sale_price}}" placeholder="Enter Sale price..." />
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
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div>

                            <!-- [ Product Images ] Start -->
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Product Thumbnail Image</h4>
                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <input type="file" id="input-file-now" name="image" class="dropify @error('image') is-invalid @enderror" data-default-file="{{asset('storage/product/'.$product->image)}}"/>
                                                <input type="hidden" name="hidden_image" value="{{ $product->image }}">
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
                            </div>

                            <!-- [ Estimate Shipping Time ] Start -->
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Estimate Shipping Time</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Shipping Days:</label>
                                                <div class="input-group">
                                                    <input type="text" id="name" class="form-control @error('shipping_days') is-invalid @enderror" name="shipping_days" value="{{$product->shipping_days}}" placeholder="Enter Shipping Days"/>
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
                            </div>

                            <!-- [ Stock Configuration ] Start -->
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Stock Configuration</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="in_stock" class="form-label fw-bold">Product Stock:</label>
                                                <input type="number" id="in_stock" name="in_stock" value="{{$product->in_stock}}" min="0" class="form-control @error('in_stock') is-invalid @enderror" placeholder="Enter Stock" />
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
                                                <input type="number" id="name" class="form-control @error('stock_warning') is-invalid @enderror" value="{{$product->stock_warning}}" min="1" name="stock_warning" placeholder="Enter Stock Warning" />
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
                            </div>

                            <!-- [ Refund Request Configuration ] Start -->
                            <!-- <div class="card">

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="refundTime" class="form-label fw-bold">Set Time for sending Refund Request:</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="refundable_day" id="refundTime" placeholder="Enter Refund Time..." value="{{$product->refundable_day}}" />
                                                    <div class="input-group-text">Day</div>
                                                    <div class="valid-feedback">Looks good!</div>
                                                    <div class="invalid-feedback">This field is required. </div>
                                                </div>
                                                <small class="text-muted"><b>Note::</b> Default Refund Time is <b>7 Days</b>.</small>
                                            </div>
                                        </div>
                                        @error('refundable_day')
                                            <div class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>   -->

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
<script type="text/javascript">
    $('#choice_attributes').on('change', function() {
        $('.attributeScript-hide').hide();
        $.each($('#choice_attributes').val(), function(key, value){
            var service_id = '#attributeScript-' + value;
            $(service_id).show();
        });
    });
</script>

@foreach($product->gallery as $index => $gallery)
<script>
    $(document).ready(function(){
        $(".removeImage{{$index}}").click(function(){
            $("#image{{$index}}").remove();
        });
    });
</script>
@endforeach
@endsection
