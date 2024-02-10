@extends('layouts.backend.app')

@section('title')
<title>General Configuration | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">General Configuration</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li> 
                            <li class="breadcrumb-item active">Website Configuration</li>
                        </ol> 
                    </div>

                </div>
            </div>
        </div> 
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-12">  
 
                <form class="custom-form needs-validation" method="post" action="{{route('admin.general-configuration.update',$data->id)}}" novalidate>
                    @method('PATCH')
                    @csrf
                    <div class="row"> 
                        <div class="col-lg-12">

                            <div class="card">
                                <div class="card-header"> 
                                    <h4 class="card-title mb-0">TAX Settings</h4> 
                                </div>
                                <div class="card-body">  
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="tax" class="form-label fw-bold">Default tax rate<sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="number" id="tax" name="tax" class="form-control" placeholder="Enter tax rate..." value="{{$data->tax}}" step="0.01" required/>
                                                <input type="hidden" name="hidden_logo" value="{{ $data->logo }}">
                                                <input type="hidden" name="hidden_icon" value="{{ $data->icon }}">
                                                <input type="hidden" name="topbar_header" value="{{ $data->topbar_header == 1 ? '1' : '0' }}" />
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                            </div>
                                            <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
                                        </div>

                                    </div> 
                                </div>
                                <!-- <div class="card-footer"></div> -->
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