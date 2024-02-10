@extends('layouts.backend.app')

@section('title')
<title>Coupon Edit | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">Edit Coupon</h4>

                    <div class="page-title-right"> 
                        <a href="{{route('admin.coupons')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-reply-all"></i> Back to list</a>
                    </div>

                </div>
            </div>
        </div> 
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-12">
                <form class="needs-validation" method="post" novalidate action="{{ route('admin.coupon.update',$coupon->id) }}" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="row"> 
                        <div class="col-lg-12">

                            <div class="card">
                                <div class="card-header"> 
                                    <h4 class="card-title mb-0">Edit Coupon Information</h4> 
                                </div>
                                <div class="card-body">  

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Coupon Name <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter Your Coupon Name" value="{{$coupon->name}}" required/>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('name')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>   

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="code" class="form-label fw-bold">Coupon Code <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" id="code" name="code" class="form-control" placeholder="Enter Coupon Code..." value="{{$coupon->code}}" required/>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('code')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>   

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="use" class="form-label fw-bold">Number of Use:</label>
                                                <input type="text" id="use" name="use" class="form-control" placeholder="Eg:: 1, 2, 5 etc." value="{{$coupon->use}}" required/>
                                                <small class="text-muted"><b>Note::</b> If bank then use unlimited time. </small>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                            </div>
                                        </div>   

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="discountType" class="form-label fw-bold">Discount Type <sup class="text-danger fs-5">*</sup> :</label>
                                                <select class="form-control select2" id="discountType" name="type" required> 
                                                    <option value="fixed" {{$coupon->type == 'fixed' ? 'selected' : ''}}>Fixed</option>
                                                    <option value="percentage" {{$coupon->type == 'percentage' ? 'selected' : ''}}>Percentage</option> 
                                                </select>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                            </div>
                                        </div>   

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="discount" class="form-label fw-bold">Discount <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" id="discount" name="discount" class="form-control" placeholder="Enter Discount..." value="{{$coupon->discount}}" required/>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                            </div>
                                        </div>   

                                    </div>
                                     
                                    <div class="row mt-5">  
                                        <div class="col-lg-12 border-bottom mb-2">
                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                <label for="name" class="form-label fw-bold fs-5">Product Base Coupon: </label>
                                                <div class="square-switch">
                                                    <input type="checkbox" id="Product_base_coupon_btn" name="product_based" switch="status" {{$coupon->product_based == 1 ? 'checked' : ''}}/>
                                                    <label for="Product_base_coupon_btn" data-on-label="On" data-off-label="Off"></label>
                                                </div>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="row only_product_base">  
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Product Category<sup class="text-danger fs-5">*</sup> :</label>
                                                <select class="form-control select2 select2-multiple" multiple="multiple" data-placeholder="Choose Category..." name="category_id[]"> 
                                                    <option value="all" @if(in_array('all', explode(',', $coupon->category_id)))selected @endif>All Category</option>
                                                    @foreach($categories as $c_val) 
                                                    <option 
                                                    value="{{$c_val->id}}" 
                                                    @php
                                                        $category = explode(',',$coupon->category_id);
                                                    @endphp
                                                    @foreach($category as $val)
                                                        @if($val == $c_val->id)selected @endif
                                                    @endforeach
                                                    >{{$c_val->name}}</option> 
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
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Choose Products<sup class="text-danger fs-5">*</sup> :</label> 
                                                <select class="form-control select2 select2-multiple" name="product_id[]" multiple="multiple" data-placeholder="Choose Products..."> 
                                                    <option value="all" @if(in_array('all', explode(',', $coupon->product_id)))selected @endif>All Products</option>
                                                    @foreach($products as $pval)
                                                    <option 
                                                        value="{{$pval->id}}"
                                                        @php
                                                            $product = explode(',',$coupon->product_id);
                                                        @endphp
                                                        @foreach($product as $val)
                                                            @if($val == $pval->id)selected @endif
                                                        @endforeach
                                                    >
                                                        {{$pval->name}}
                                                    </option> 
                                                    @endforeach  
                                                </select>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('product_id')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="row"> 
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Minimum Price <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" id="name" name="min_price" class="form-control" placeholder="Enter Minimum Price..." value="{{$coupon->min_price}}" required/>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('min_price')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>  
                                        <div class="col-lg-6 only_product_base">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Maximum Price <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" id="name" name="max_price" class="form-control" placeholder="Enter Maximum Price..." value="{{$coupon->max_price}}" />
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('max_price')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div> 
                                    </div> 

                                    <div class="row">  
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Start Date <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="input-group" id="datepicker2">
                                                    <input type="date" class="form-control" placeholder="dd M, yyyy" name="start_date" 
                                                        data-date-format="dd M, yyyy" data-date-container='#datepicker2' data-provide="datepicker"
                                                        data-date-autoclose="true" value="{{$coupon->start_date}}" required>

                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                        
                                                    <div class="valid-feedback">Looks good!</div>
                                                    <div class="invalid-feedback">This field is required. </div>
                                                    @error('start_date')
                                                        <div class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div> 
                                            </div>
                                        </div> 
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">End Date <sup class="text-danger fs-5">*</sup> :</label> 
                                                <div class="input-group" id="datepicker2">
                                                    <input type="date" class="form-control" placeholder="dd M, yyyy" name="end_date" 
                                                        data-date-format="dd M, yyyy" data-date-container='#datepicker2' data-provide="datepicker"
                                                        data-date-autoclose="true" value="{{$coupon->end_date}}" required>

                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                        
                                                    <div class="valid-feedback">Looks good!</div>
                                                    <div class="invalid-feedback">This field is required. </div>
                                                    @error('end_date')
                                                        <div class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div> 
                                            </div>
                                        </div>  
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="statuss" class="form-label fw-bold">Status <sup class="text-danger fs-5">*</sup> :</label>
                                                <select class="form-control select2" name="status" id="statuss">
                                                    <option value="0" {{ $coupon->status == 0 ? 'selected' : '' }}>Disable</option>  
                                                    <option value="1" {{ $coupon->status == 1 ? 'selected' : '' }}>Enable</option>
                                                </select>
                                            </div>
                                        </div>  
                                    </div> 

                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div>
                            <!-- end card -->  
                    
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

            </div> <!-- end col --> 
        </div> <!-- end row -->  
        
        
    </div>
    <!-- container-fluid -->
</div> 
@endsection

@section('script')
<script>
    @if($coupon->product_based == 0)
        $(".only_product_base").hide();
    @else
        $(".only_product_base").show();
    @endif
    $("#Product_base_coupon_btn").click(function() {
        if($(this).is(":checked")) {
            $(".only_product_base").show(300);
        } else {
            $(".only_product_base").hide(300);
        }
    });
</script>
@endsection
