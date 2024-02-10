@extends('layouts.backend.app')

@section('title')
<title>Profile | {{Auth::user()->role->name}}</title>
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
                    <h4 class="mb-sm-0 font-size-18">Admin Profile</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Admin Profile</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-12">
            	<form class="custom-form needs-validation" method="post" action="{{ route('admin.profile.update', Auth::user()->id) }}" enctype="multipart/form-data" novalidate>
                @method('PATCH')
                @csrf
	                <div class="card border">
	                    <div class="card-header d-flex justify-content-between align-items-center">
	                        <h4 class="card-title mb-0">Admin Profile Information</h4>
	                    </div>
	                    <div class="card-body">
	                        <div class="row">
	                            <div class="col-lg-4">
	                                <div class="profile-image">
	                                    <img class="rounded-circle" src="{{asset('storage/user/'.Auth::user()->avatar)}}" alt="">
	                                </div>
	                            </div>
	                            <div class="col-lg-8">
	                                <div class="row">
	                                    <div class="col-lg-12">
	                                        <div class="form-group">
	                                            <label for="name" class="form-label">Name:<sup class="text-danger fs-5">*</sup> :</label>
	                                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Your Full Name" value="{{Auth::user()->name}}" required />
	                                            <div class="valid-feedback">Looks good!</div>
	                                            <div class="invalid-feedback">This field is required. </div>
	                                            @error('name')
	                                                <div class="text-danger">
	                                                    <strong>{{ $message }}</strong>
	                                                </div>
	                                            @enderror
	                                        </div>
	                                    </div>

	                                    <div class="col-lg-6">
	                                        <div class="form-group">
	                                        	<label for="email" class="form-label">Email Id:<sup class="text-danger fs-5">*</sup> :</label>
	                                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Your Email" value="{{Auth::user()->email}}" required />
	                                            <div class="valid-feedback">Looks good!</div>
	                                            <div class="invalid-feedback">This field is required. </div>
	                                            @error('email')
	                                                <div class="text-danger">
	                                                    <strong>{{ $message }}</strong>
	                                                </div>
	                                            @enderror
	                                        </div>
	                                    </div>
	                                    <div class="col-lg-6">
	                                        <div class="form-group">
	                                            <label for="name" class="form-label">Mobile Number:</label>
	                                            <input type="text" id="mobile" name="mobile" class="form-control @error('mobile') is-invalid @enderror" placeholder="Enter Your Full Name" value="{{Auth::user()->mobile}}" required />
	                                            <div class="valid-feedback">Looks good!</div>
	                                            <div class="invalid-feedback">This field is required. </div>
	                                            @error('mobile')
	                                                <div class="text-danger">
	                                                    <strong>{{ $message }}</strong>
	                                                </div>
	                                            @enderror
	                                        </div>
	                                    </div>

	                                    <div class="col-lg-6">
	                                        <div class="form-group">
	                                            <label for="name" class="form-label">DOB:</label>
	                                            <input type="date" id="dob" name="dob" class="form-control  @error('dob') is-invalid @enderror" placeholder="Enter Your Full Name" value="{{Auth::user()->dob}}" />
	                                            <div class="valid-feedback">Looks good!</div>
	                                            <div class="invalid-feedback">This field is required. </div>
	                                            @error('dob')
	                                                <div class="text-danger">
	                                                    <strong>{{ $message }}</strong>
	                                                </div>
	                                            @enderror
	                                        </div>
	                                    </div>
	                                    <div class="col-lg-6">
	                                        <div class="form-group">
	                                            <label for="name" class="form-label">Gender:</label>
	                                            <select class="form-select form-control form-control-sm @error('gender') is-invalid @enderror" name="gender">
	                                                <option value="male" {{Auth::user()->gender == "male" ? 'selected' : ''}}>Male</option>
	                                                <option value="female" {{Auth::user()->gender == "female" ? 'selected' : ''}}>Female</option>
	                                            </select>
	                                            <div class="valid-feedback">Looks good!</div>
	                                            <div class="invalid-feedback">This field is required. </div>
	                                            @error('gender')
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
	                    <div class="card-footer text-end">
	                        <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
	                    </div>
	                </div>
	                <!-- end card -->

	                <div class="card border">
	                    <div class="card-header">
	                        <h4 class="card-title mb-0">Change Password</h4>
	                    </div>
	                    <div class="card-body">
	                        <div class="row">
	                            <div class="col-lg-6">
	                                <div class="form-group">
	                                    <label for="name" class="form-label">New Password:</label>
	                                    <div class="input-group auth-pass-inputgroup">
	                                        <input type="password" class="form-control" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon" name="password">
	                                        <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
	                                        <div class="valid-feedback">Looks good!</div>
	                                        <div class="invalid-feedback">This field is required. </div>
	                                    </div>
	                                    @error('password')
	                                        <div class="text-danger">
	                                            <strong>{{ $message }}</strong>
	                                        </div>
	                                    @enderror
	                                </div>
	                            </div>
	                            <div class="col-lg-6">
	                                <div class="form-group">
	                                    <label for="name" class="form-label">Confirm Password:</label>
	                                    <div class="input-group auth-pass-inputgroup">
	                                        <input type="password" class="form-control" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon" name="password_confirmation">
	                                        <button class="btn btn-light " type="button" id="password-addon1"><i class="mdi mdi-eye-outline"></i></button>
	                                        <div class="valid-feedback">Looks good!</div>
	                                        <div class="invalid-feedback">This field is required. </div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="card-footer text-end">
	                        <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
	                    </div>
	                </div>

	                <!--[ GST Details ] start -->
	                <div class="card border">
                        <div class="card-header">
                            <h4 class="card-title mb-0">GST Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">GST registered Name:</label>
                                        <input type="text" class="form-control" name="gst_name" value="{{$user->gst_name??old('gst_name')}}" placeholder="Enter GST Business Name..." />
                                        @error('gst_name')
                                            <div class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">GST Number:</label>
                                        <input type="text" class="form-control" name="gst_no" value="{{$user->gst_no??old('gst_no')}}" placeholder="Enter GST No..." />
                                        @error('gst_no')
                                            <div class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
                        </div>
	                </div>
	            </form>
                <!-- end card -->
            </div>
        </div>
        <!-- end row -->


    </div>
    <!-- container-fluid -->
</div>
@endsection
