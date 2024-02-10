@extends('layouts.backend.app')

@section('title')
<title>Edit Staff | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">Edit Staff</h4>

                    <div class="page-title-right"> 
                        <a href="{{route('admin.staffs')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-reply-all"></i> Back to list</a>
                    </div>

                </div>
            </div>
        </div> 
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-12">  

                <form action="{{route('admin.staff.update',$user->id)}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="row"> 
                        <div class="col-lg-12">

                            <div class="card">
                                <div class="card-header"> 
                                    <h4 class="card-title mb-0">Staff Information</h4> 
                                </div>
                                <div class="card-body">  
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Staff Name <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter your full name..." value="{{$user->name}}" required/>
                                                @error('name')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div> 

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="email" class="form-label fw-bold">Eamil Id <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" name="email" id="email" class="form-control" placeholder="Enter your email id..." value="{{$user->email}}" required/>
                                                @error('email')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div> 

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="mobile" class="form-label fw-bold">Contact Number <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Enter your phone number..." value="{{$user->mobile}}" required/>
                                                @error('mobile')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div> 

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Choose Role <sup class="text-danger fs-5">*</sup>:</label>
                                                <select class="form-control select2" name="role_id">
                                                    <option>Select</option> 
                                                    @foreach($roles as $role)
                                                    <option value="{{$role->id}}" {{ $user->role->id == $role->id ? 'selected' : '' }}>{{$role->name}}</option>
                                                    @endforeach 
                                                </select>
                                                @error('role_id')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div> 

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                            <label for="name" class="form-label fw-bold">Published <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="square-switch">
                                                    <input type="checkbox" name="email_verified_at" id="square-switch3" switch="status" {{ $user->email_verified_at != null ? 'checked' : '' }} />
                                                    <label for="square-switch3" data-on-label="Yes"
                                                        data-off-label="No"></label>
                                                    @error('email_verified_at')
                                                        <div class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>   
                                            </div>
                                        </div>   

                                    </div> 
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div>
                            <!-- end card --> 

                            <div class="card">
                                <div class="card-header"> 
                                    <h4 class="card-title mb-0">Staff Login Password</h4> 
                                </div>
                                <div class="card-body">  
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="password" class="form-label fw-bold">Password <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" id="password" name="password" class="form-control" placeholder="Enter your email id..."/>
                                                @error('password')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div> 

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="password_confirmation" class="form-label fw-bold">Confirm Password<sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Enter your email id..."/>
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
                                    <!-- <button type="reset" class="btn btn-warning waves-effect waves-light">Clear</button> -->
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
