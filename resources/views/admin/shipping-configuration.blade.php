@extends('layouts.backend.app')

@section('title')
<title>Shipping Configuration | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">Shipping Configuration</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">Shipping Configuration</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div> 
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-12">  

                <form class="custom-form needs-validation" action="{{route('admin.shipping-configuration.update',$data->id)}}" method="post" novalidate>
                	@method('PATCH')
                	@csrf
                    <div class="row"> 
                        <div class="col-lg-6">

                            <div class="card">
                                <div class="card-header"> 
                                    <!-- <h4 class="card-title mb-0">Free Shipping</h4>  -->
                                    <div class="form-group d-flex justify-content-between align-items-center m-0">
                                        <label for="name" class="form-label fw-bold fs-5">Enable Free Shipping</label>
                                        <div class="square-switch">
                                            <input type="checkbox" name="free_shipping_status" id="square-switch1" switch="status" {{ $data->free_shipping_status == 1 ? "checked" : "" }}>
                                            <label for="square-switch1" data-on-label="Yes" data-off-label="No"></label>
                                        </div>
                                        @error('free_shipping_status')
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
                                                <label for="refundTime" class="form-label fw-bold">Set Minimum Order Amount for Free Shipping  <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="bx bx-rupee fs-4"></i></div>
                                                    <input type="text" class="form-control @error('min_order_to_ship') is-invalid @enderror" name="min_order_to_ship" id="refundTime" placeholder="Enter Minimum Order Amount for Free Shipping..." value="{{$data->min_order_to_ship}}" required/>
                                                    <div class="valid-feedback">Looks good!</div>
                                                    <div class="invalid-feedback">This field is required. </div>
                                                    @error('min_order_to_ship')
	                                                    <div class="text-danger">
	                                                        <strong>{{ $message }}</strong>
	                                                    </div>
	                                                @enderror
                                                </div>
                                                <small class="text-muted"><b>Note::</b> Default Minimum Order Amount for Free Shipping is <b><i class="bx bx-rupee"></i>499.00</b>.</small>
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
                        <div class="col-lg-6"> 

                            <div class="card">
                                <div class="card-header"> 
                                    <!-- <h4 class="card-title mb-0">Free Shipping</h4>  -->
                                    <div class="form-group d-flex justify-content-between align-items-center m-0">
                                        <label for="name" class="form-label fw-bold fs-5">Univaseral Shipping Cost</label>
                                        <div class="square-switch">
                                            <input type="checkbox" name="universal_ship_status" id="square-switch2" switch="status" {{ $data->universal_ship_status == 1 ? "checked" : "" }}>
                                            <label for="square-switch2" data-on-label="Yes" data-off-label="No"></label>
                                        </div> 
                                        @error('universal_ship_status')
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
                                                <label for="refundTime" class="form-label fw-bold">Set Univaseral Shipping Cost <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="bx bx-rupee fs-4"></i></div>
                                                    <input type="text" name="universal_ship_cost" class="form-control" id="refundTime" placeholder="Enter Minimum Order Amount for Free Shipping..." value="{{$data->universal_ship_cost}}" required/>
                                                    <div class="valid-feedback">Looks good!</div>
                                                    <div class="invalid-feedback">This field is required. </div>
                                                    @error('universal_ship_cost')
			                                            <div class="text-danger">
			                                                <strong>{{ $message }}</strong>
			                                            </div>
			                                        @enderror 
                                                </div>
                                                <small class="text-muted"><b>Note::</b> Default Minimum Order Amount for Free Shipping is <b><i class="bx bx-rupee"></i>49.00</b>.</small>
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

                        <div class="col-lg-6"> 

                            <div class="card">
                                <div class="card-header"> 
                                    <!-- <h4 class="card-title mb-0">Free Shipping</h4>  -->
                                    <div class="form-group d-flex justify-content-between align-items-center m-0">
                                        <label for="name" class="form-label fw-bold fs-5">Universal Shipping Days</label> 
                                    </div>

                                </div>
                                <div class="card-body">  
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="refundTime" class="form-label fw-bold">Set Univaseral Shipping Days <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="input-group">
                                                    <div class="input-group-text">Day</div>
                                                    <input type="text" name="universal_shipping_days" class="form-control" id="refundTime" placeholder="Enter Minimum days for Free Shipping..." value="{{$data->universal_shipping_days}}" required/>
                                                    <div class="valid-feedback">Looks good!</div>
                                                    <div class="invalid-feedback">This field is required. </div>
                                                    @error('universal_shipping_days')
                                                        <div class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror 
                                                </div>
                                                <small class="text-muted"><b>Note::</b> Default Minimum days for Free Shipping is <b><i class="bx bx-rupee"></i>4 days</b>.</small>
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

                    </div>
                     
                </form>

            </div> <!-- end col --> 
        </div> <!-- end row -->  
        
        
    </div>
    <!-- container-fluid -->
</div>
@endsection