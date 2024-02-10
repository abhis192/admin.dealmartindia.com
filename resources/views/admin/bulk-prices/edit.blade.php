@extends('layouts.backend.app')

@section('title')
    <title>Edit Bulk Price</title>
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
                    <h4 class="mb-sm-0 font-size-18">Edit Bulk Price</h4>

                    <div class="page-title-right">
                        <a href="{{ route('admin.bulk-prices') }}" class="btn btn-primary waves-effect waves-light">
                            <i class="fas fa-reply-all"></i> Back to list
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-12">
                <form class="custom-form needs-validation repeater" method="post" action="{{ route('admin.bulk-price.update', $price->id) }}" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PATCH')

                    <div class="row">

                        <div class="col-lg-12">



                             <!-- [ Product Information ] Start -->
                             <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Product Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="selectProduct" class="form-label fw-bold">Choose Product <sup class="text-danger fs-5">*</sup> :</label>
                                                <select class="form-control select2" id="selectProduct" name="product_id" required>
                                                    <option value="">Select Product</option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}" @if($price->product_id == $product->id) selected @endif>{{ $product->name }}</option>
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

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Select Multiple Cities <sup class="text-danger fs-5">*</sup> :</label>
                                                <select class="form-control select2" name="city_id[]" id="parentCategory" multiple required>
                                                    <option value="">Select</option>
                                                    @foreach($cities as $city)

                                                    <option value="{{$city->id}}" @if(in_array($city->id, explode(',',$price->city_id))) selected @endif>{{$city->name}}</option>

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


                                        {{-- <div class="col-lg-12">
                                            <div class="form-group m-0">
                                                <label for="selectProduct" class="form-label fw-bold">Setup Price <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="repeater-box">
                                                    <div data-repeater-list="pricing_rules">
                                                        <div data-repeater-item class="row">
                                                            <div class="mb-3 col-lg-5">
                                                                <label for="minqty">Qty type<sup class="text-danger fs-5">*</sup></label>

                                                                <td>
                                                                    <select name="qty_type" class="form-control">
                                                                        <option value="">Select Qty</option>
                                                                        <option value="gram">Gram (G)</option>
                                                                        <option value="kg">Kilo Gram (KG)</option>
                                                                        <option value="liter">Liter (L)</option>
                                                                        <option value="ml">Milli Liter (ML)</option>
                                                                        <option value="piece">Piece (P)</option>
                                                                    </select>
                                                                    <div class="valid-feedback">Looks good!</div>
                                                                    <div class="invalid-feedback">This field is required. </div>
                                                                </td>
                                                            </div>
                                                            <div class="mb-3 col-lg-5">
                                                                <label for="pp">Qty<sup class="text-danger fs-5">*</sup></label>
                                                                <input type="text" name="qty" value="0" class="form-control" Placeholder="Eg: 100, 200, 500..." />
                                                            </div>
                                                            <div class="mb-3 col-lg-5">
                                                                <label for="pp">Regular Price<sup class="text-danger fs-5">*</sup></label>
                                                                <input type="text" name="product_price" class="form-control" Placeholder="Eg: 100, 200, 500..." />
                                                            </div>
                                                            <div class="mb-3 col-lg-5">
                                                                <label for="pp">Discount Type<sup class="text-danger fs-5">*</sup></label>
                                                                <td>
                                                                    <select name="discount_type" class="form-control">
                                                                        <option value="">N/A</option>
                                                                        <option value="Flat">Flat Rate (Rs)</option>
                                                                        <option value="Percentage">Percentage (%)</option>
                                                                    </select>
                                                                    <div class="valid-feedback">Looks good!</div>
                                                                    <div class="invalid-feedback">This field is required. </div>
                                                                </td>
                                                            </div>
                                                            <div class="mb-3 col-lg-5">
                                                                <label for="pp">Discount Value<sup class="text-danger fs-5">*</sup></label>
                                                                <input type="text" name="discount_value" class="form-control" Placeholder="Eg: 100, 200, 500..." />
                                                            </div>
                                                            <div class="mb-3 col-lg-5">
                                                                <label for="pp">Final/Sale Price<sup class="text-danger fs-5">*</sup></label>
                                                                <input type="text" name="final_price" class="form-control"  readonly/>
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
                                        </div> --}}


                                        <div class="col-lg-12">
                                            <div class="form-group">
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

                            <!-- [ Product Price ] Start -->
                            {{-- <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Product Price</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">

                                            <table class="table table-bordered w-100 table-striped table-sm mb-3">
                                                <thead>
                                                    <tr>
                                                        <th>Qty Type</th>
                                                        <th>Quantity</th>
                                                        <th>Regular Price</th>
                                                        <th>Dis. Type</th>
                                                        <th>Dis. Value</th>
                                                        <th>Final Price</th>
                                                        <th class="col-1">Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    <tr class="order-multiple">

                                                        <td>
                                                            <select name="qty_type[]" class="form-control">
                                                                <option value="">Qty</option>
                                                                <option value="gram">Gram (G)</option>
                                                                <option value="kg">Kilo Gram (KG)</option>
                                                                <option value="liter">Liter (L)</option>
                                                                <option value="ml">Milli Liter (ML)</option>
                                                                <option value="piece">Piece (P)</option>
                                                            </select>
                                                            <div class="valid-feedback">Looks good!</div>
                                                            <div class="invalid-feedback">This field is required. </div>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="qty[]" value="0"  class="form-control" Placeholder="Eg: 100, 200, 500..." />
                                                            <div class="valid-feedback">Looks good!</div>
                                                            <div class="invalid-feedback">This field is required. </div>
                                                        </td>


                                                        <td>
                                                            @foreach(json_decode($price->pricing_rules) as $rule)
                                                            <input type="text" name="product_price[]" class="form-control"
                                                            value="{{ $rule->product_price }}" Placeholder="Eg: 100, 200, 500..." />
                                                            <div class="valid-feedback">Looks good!</div>
                                                            <div class="invalid-feedback">This field is required. </div>
                                                        </td>

                                                        <td>
                                                            <select name="discount_type[]" class="form-control">
                                                                <option value="">N/A</option>
                                                                <option value="Flat">Flat Rate (Rs)</option>
                                                                <option value="Percentage">Percentage (%)</option>
                                                            </select>
                                                            <div class="valid-feedback">Looks good!</div>
                                                            <div class="invalid-feedback">This field is required. </div>
                                                        </td>

                                                        <td>
                                                            <input type="text" name="discount_value[]" class="form-control" Placeholder="Eg: 100, 200, 500..." />
                                                            <div class="valid-feedback">Looks good!</div>
                                                            <div class="invalid-feedback">This field is required. </div>
                                                        </td>

                                                        <td>
                                                            <input type="text" name="final_price[]" class="form-control"  readonly/>
                                                            <div class="valid-feedback">Looks good!</div>
                                                            <div class="invalid-feedback">This field is required. </div>
                                                        </td>
                                                         @endforeach
                                                        <td><button type="button" class="btn has-ripple btn-success btn-add"><i class="bx bx-plus"></i></button></td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div> --}}
                            {{-- <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Product Price</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">

                                            <div class="repeater-box">
                                                <div data-repeater-list="pricing_rules">
                                                    @foreach(json_decode($price->pricing_rules) as $rule)
                                                    <div data-repeater-item class="row">
                                                        <div class="mb-3 col-lg-2">
                                                            <label for="minqty">Qty type<sup class="text-danger fs-5">*</sup></label>

                                                            <td>
                                                                <select name="qty_type" class="form-control">
                                                                    <!-- <option value="">Select Quantity</option>   -->
                                                                    <option value="gram" @if($rule->qty_type=='gram') selected @endif>Gram (G)</option>
                                                                    <option value="kg" @if($rule->qty_type=='kg') selected @endif>Kilo Gram (KG)</option>
                                                                    <option value="liter" @if($rule->qty_type=='liter') selected @endif>Liter (L)</option>
                                                                    <option value="ml" @if($rule->qty_type=='ml') selected @endif>ML</option>
                                                                    <option value="piece" @if($rule->qty_type=='piece') selected @endif>Piece (P)</option>

                                                                    {{-- <option value="CAP" @if($idval->qty_type=='CAP') selected @endif>CAP</option> --}}
                                                                </select>
                                                            </td>
                                                        {{-- </div>
                                                        <div class="mb-3 col-lg-2">
                                                            <label for="pp">Qty<sup class="text-danger fs-5">*</sup></label>
                                                            <input type="text" name="qty"  value="{{ $rule->qty }}" class="form-control" Placeholder="Eg: 100, 200, 500..." />
                                                        </div>
                                                        <div class="mb-3 col-lg-2">
                                                            <label for="pp">RRP<sup class="text-danger fs-5">*</sup></label>
                                                            <input type="text" name="product_price" value="{{ $rule->product_price }}" class="form-control" Placeholder="Eg: 100, 200, 500..." />
                                                        </div>
                                                        <div class="mb-3 col-lg-2">
                                                            <label for="pp">Dis. Type<sup class="text-danger fs-5">*</sup></label>
                                                            <td>
                                                                <select name="discount_type" class="form-control">
                                                                    <option value="">N/A</option>
                                                                    <option value="Flat" @if($rule->discount_type=='Flat') selected @endif>Flat Rate (Rs)</option>
                                                                    <option value="Percentage" @if($rule->discount_type=='Percentage') selected @endif>Percentage (%)</option>
                                                                </select>
                                                            </td>
                                                        </div>
                                                        <div class="mb-3 col-lg-2">
                                                            <label for="pp">Dis. Value<sup class="text-danger fs-5">*</sup></label>
                                                            <input type="text" name="discount_value" value="{{ $rule->discount_value }}" class="form-control" Placeholder="Eg: 100, 200, 500..." />
                                                        </div>
                                                        <div class="mb-3 col-lg-2">
                                                            <label for="pp">Final Price<sup class="text-danger fs-5">*</sup></label>
                                                            <input type="text" name="final_price" value="{{ $rule->final_price }}" class="form-control"  readonly/>
                                                        </div>
                                                        <div class="mb-3 mt-4 col-lg-2 align-self-center">
                                                            <div class="d-grid">
                                                                <input data-repeater-delete type="button" class="btn btn-danger" value="Delete"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <input data-repeater-create type="button" class="btn btn-success mt-3 mt-lg-0" value="Add"/>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div> --}}

                        {{-- </div> --}}

                        {{-- <div class="col-lg-4">

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
                                                        <option value="{{ $product->id }}" @if($price->product_id == $product->id) selected @endif>{{ $product->name }} - [₹ {{$product->sale_price??$product->regular_price}}]</option>
                                                    @endforeach
                                                </select>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Select Multiple Cities <sup class="text-danger fs-5">*</sup> :</label>
                                                <select class="form-control select2" name="city_id[]" id="parentCategory" multiple required>
                                                    <option value="">Select</option>
                                                    @foreach($cities as $city)
                                                    <option value="{{$city->id}}" @if(in_array($city->id, explode(',',$price->city_id))) selected @endif>{{$city->name}}</option>
                                                    {{-- <option value="{{$slot->id}}" {{ $slot->id == $deliveryoption->time_slot_inside ? "selected" : "" }}>{{$slot->from}}-{{$slot->to}}</option> --}}
                                                    {{-- @endforeach --}}
                                                    {{-- @foreach($cities as $city)
                                                    <option
                                                        value="{{$city->id}}"
                                                        @foreach($price->cities as $prodCat)
                                                            @if($prodCat->city_id == $city->id)
                                                                selected
                                                            @endif
                                                        @endforeach
                                                        >
                                                        {{$category->name}}
                                                    </option>
                                                    @endforeach --}}


                                                    {{-- @foreach($cities as $city)
                                                    <option value="{{ $city->id }}" @if($price->city_id == $city->id) selected @endif>{{ $city->name }}</option>
                                                    @endforeach --}}
                                                    {{-- @foreach($cities as $city)

                                                        <option value="{{$city->id}}">{{$city->name}}</option>

                                                    @endforeach --}}
                                                {{-- </select>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('category_id')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- <div class="col-lg-12">
                                            <div class="form-group m-0">
                                                <label for="selectProduct" class="form-label fw-bold">Setup Price <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="repeater-box">
                                                    <div data-repeater-list="pricing_rules">
                                                        @foreach(json_decode($price->pricing_rules) as $rule)
                                                        <div data-repeater-item class="row">
                                                            <div class="mb-3 col-lg-5">
                                                                <label for="minqty">Min Qty<sup class="text-danger fs-5">*</sup></label>
                                                                <input type="text" id="minqty" class="form-control" placeholder="Min Qty..." name="min_quantity" value="{{ $rule->min_quantity }}" />
                                                            </div>
                                                            <div class="mb-3 col-lg-5">
                                                                <label for="pp">Price/product<sup class="text-danger fs-5">*</sup></label>
                                                                <input type="text" id="pp" class="form-control" placeholder="Price/product..." name="price" value="{{ $rule->price }}" />
                                                            </div>
                                                            <div class="mb-3 mt-4 col-lg-2 align-self-center">
                                                                <div class="d-grid">
                                                                    <input data-repeater-delete type="button" class="btn btn-danger" value="Delete"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    <input data-repeater-create type="button" class="btn btn-success mt-3 mt-lg-0" value="Add"/>
                                                </div>
                                            </div>
                                        </div> --}}
                                    {{-- </div> --}}

                                {{-- </div> --}}
                                <!-- <div class="card-footer"></div> -->
                            {{-- </div> --}}

                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Product Price</h4>
                                    {{-- <input data-repeater-create type="button" class="btn btn-success" value="Add"/> --}}
                                    <button data-repeater-create type="button" class="btn btn-success" value="Add"><i class="fa fa-plus"></i> Add</button>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">

                                            <div class="repeater-box">
                                                <div data-repeater-list="pricing_rules">
                                                    @foreach(json_decode($price->pricing_rules) as $rule)
                                                    <div data-repeater-item class="row">
                                                        <div class="mb-3 col-lg-2">
                                                            <label for="minqty">Qty type<sup class="text-danger fs-5">*</sup></label>

                                                            <td>
                                                                <select name="qty_type" class="form-control">
                                                                    <!-- <option value="">Select Quantity</option>   -->
                                                                    <option value="gram" @if($rule->qty_type=='gram') selected @endif>Gram (G)</option>
                                                                    <option value="kg" @if($rule->qty_type=='kg') selected @endif>Kilo Gram (KG)</option>
                                                                    <option value="liter" @if($rule->qty_type=='liter') selected @endif>Liter (L)</option>
                                                                    <option value="ml" @if($rule->qty_type=='ml') selected @endif>ML</option>
                                                                    <option value="piece" @if($rule->qty_type=='piece') selected @endif>Piece (P)</option>

                                                                    {{-- <option value="CAP" @if($idval->qty_type=='CAP') selected @endif>CAP</option> --}}
                                                                </select>
                                                            </td>
                                                        </div>
                                                        <div class="mb-3 col-lg-1">
                                                            <label for="pp">Qty W.<sup class="text-danger fs-5">*</sup></label>
                                                            <input type="text" name="qty_weight" value="{{ $rule->qty_weight }}" class="form-control" Placeholder="Eg: 100, 200, 500..." />
                                                        </div>
                                                        <div class="mb-3 col-lg-2">
                                                            <label for="pp">Regular Price<sup class="text-danger fs-5">*</sup></label>
                                                            <input type="text" name="product_price"  value="{{ $rule->product_price }}" class="form-control" Placeholder="Eg: 100, 200, 500..." />
                                                        </div>
                                                        <div class="mb-3 col-lg-2">
                                                            <label for="pp">Dis. Type<sup class="text-danger fs-5">*</sup></label>
                                                            <td>
                                                                <select name="discount_type" class="form-control">
                                                                    <option value="">N/A</option>
                                                                    <option value="Flat" @if($rule->discount_type=='Flat') selected @endif>Flat Rate (Rs)</option>
                                                                    <option value="Percentage" @if($rule->discount_type=='Percentage') selected @endif>Percentage (%)</option>
                                                                </select>
                                                            </td>
                                                        </div>
                                                        <div class="mb-3 col-lg-2">
                                                            <label for="pp">Dis. Value<sup class="text-danger fs-5">*</sup></label>
                                                            <input type="text" name="discount_value" value="{{ $rule->discount_value }}" class="form-control" Placeholder="Eg: 100, 200, 500..." />
                                                        </div>
                                                        <div class="mb-3 col-lg-2">
                                                            <label for="pp">Final Price</label>
                                                            <input type="text" name="final_price" value="{{ $rule->final_price }}" class="form-control"  readonly/>
                                                        </div>

                                                        <div class="mb-3 mt-4 col-lg-1 align-self-center">
                                                            <div class="d-grid">
                                                                {{-- <input data-repeater-delete type="button" class="btn btn-danger" value="Delete"/> --}}

                                                                <button data-repeater-delete type="button" class="btn btn-danger delete-product" value="Delete"><i class="fa fa-trash"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div>

                            <!-- [ Advance Configuration ] Start -->
                            {{-- <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Advance Configuration</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                <label for="name" class="form-label fw-bold">Published <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="square-switch">
                                                    <input type="checkbox" id="square-switch1" switch="status" {{ $price->status == 1 ? 'checked' : '' }} name="status">
                                                    <label for="square-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div> --}}


                        {{-- </div> --}}


                        {{-- <div class="col-lg-4">

                        </div> --}}

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
<script src="{{asset('assets/admin/js/pages/form-advanced.init.js')}}"></script>
<!-- form repeater js -->
<script src="{{asset('assets/admin/libs/jquery.repeater/jquery.repeater.min.js')}}"></script>
<script src="{{asset('assets/admin/js/pages/form-repeater.int.js')}}"></script>
@endsection
