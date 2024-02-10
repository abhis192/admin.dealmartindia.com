@extends('layouts.backend.app')

@section('title')
<title>Seller | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">Add Kitchen</h4>

                    <div class="page-title-right">
                        <!-- <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">All Users</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
                        </ol> -->
                        <a href="{{route('admin.all-sellers')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-reply-all"></i> Back to list</a>
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-12">

                <form class="custom-form needs-validation" method="post" action="{{ route('admin.all-seller.store') }}" enctype="multipart/form-data" novalidate>
                {{-- @method('PATCH') --}}
                @csrf

                <!--[ Seller Information ] start -->
                <div class="card border">
                    
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Kitchen Information</h4>
                            {{-- @if('seller_verified_at' != null)
                            <span class="badge badge-pill badge-soft-success font-size-12 p-2 border w-md">Account is Verified </span>
                            @else
                            <span class="badge badge-pill badge-soft-danger font-size-12 p-2 border w-md">Account is Non Verified </span>
                            @endif --}}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                {{-- <div class="col-lg-3">
                                    <div class="profile-image">
                                        <img class="rounded-circle img-fluid" src="{{asset('storage/user/'.$user->avatar)}}" alt="">
                                    </div>
                                </div> --}}
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Seller Name <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Your Full Name" value="" required />
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
                                                <label for="name" class="form-label">Store Name <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" id="business" name="business" class="form-control @error('business') is-invalid @enderror" placeholder="Enter Your Business Name" value="" required/>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('business')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Email Id <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Your Email" value="" required />
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
                                                <label for="name" class="form-label">Mobile Number <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" id="mobile" name="mobile" class="form-control @error('mobile') is-invalid @enderror" placeholder="Enter Your Mobile no." value="" required/>
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
                                                <label for="name" class="form-label">DOB <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="date" id="dob" name="dob" class="form-control @error('dob') is-invalid @enderror" placeholder="Enter Your Date" value="" required/>
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
                                                <label for="name" class="form-label">Gender <sup class="text-danger fs-5">*</sup> :</label>
                                                <select class="form-select form-control form-control-sm @error('gender') is-invalid @enderror" name="gender" required>
                                                    <option value="">Select Gender</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
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
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="address" class="form-label">Address <sup class="text-danger fs-5">*</sup> :</label>
                                                <textarea name="address" id="address" class="form-control" required></textarea>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('address')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">Email Verify:</label>
                                                <div class="square-switch">
                                                    <input type="checkbox" id="square-switch1" name="email_verified_at" switch="bool"  />
                                                    <label for="square-switch1" data-on-label="Yes"
                                                        data-off-label="No"></label>
                                                    @error('email_verified_at')
                                                        <div class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">Account Verify:</label>
                                                <div class="square-switch">
                                                    <input type="checkbox" id="square-switch2" name="seller_verified_at" switch="bool" />
                                                    <label for="square-switch2" data-on-label="Yes"
                                                        data-off-label="No"></label>
                                                    @error('seller_verified_at')
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
                        </div>
                        <div class="card-footer text-end">
                            {{-- <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button> --}}
                        </div>
                    {{-- </form> --}}
                {{-- </div> --}}

                <!--[ Change Password ] start -->
                <div class="card border">
                    {{-- <form class="custom-form needs-validation" method="post" action="{{ route('admin.all-seller.store') }}" enctype="multipart/form-data" novalidate>
                        {{-- @method('PATCH') --}}
                        {{-- @csrf --}}
                        <div class="card-header">
                            <h4 class="card-title mb-0">Create Password</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Password:</label>
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
                            <div class="card-footer text-end">
                                <button type="reset" class="btn btn-warning waves-effect waves-light">Cancel</button>
                                <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
                            </div>
                            {{-- <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button> --}}
                        </div>
                </div>

                
                </form>

                <!--[ Change Password ] start -->
                {{-- <div class="card border"> --}}
                        {{-- <div class="card-header"></div>
                        <div class="card-body"></div> --}}
                        {{-- <div class="card-footer text-end">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
                        </div> --}}
                        {{-- <div class="card-footer text-end">
                            <button type="" class="btn btn-warning waves-effect waves-light">Cancel</button>
                            <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
                        </div> --}}
                    {{-- </form>
                </div> --}}

                <!--[ Legal Documents ] start -->
                {{-- <div class="card border">
                    <form action="#">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Legal Documents</h4>
                        </div>
                        <div class="card-body">
                            @if($user->legals->count())
                            <div class="row row-cols-2 row-cols-lg-4">
                                @foreach($user->legals as $legal)
                                <div class="col">
                                    <div class="document-box border text-center">
                                        <div class="remove-doc">
                                            <a href="#"><i class="fas fa-times"></i></a>
                                        </div>
                                        <a class="image-popup-no-margins" href="{{asset('storage/documents/'.$legal->image)}}" title="Document 1">
                                            <img class="img-fluid" src="{{asset('storage/documents/'.$legal->image)}}" />
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="row row-cols-2 row-cols-lg-4 text-danger">Documents not uploaded yet.</div>
                            @endif
                        </div>
                        <!-- <div class="card-footer text-end">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
                        </div>  -->
                    </form>
                </div> --}}

                <!--[ Bank Account Details ] start -->
                {{-- <div class="card border">
                    <form class="custom-form needs-validation" method="post" action="{{ route('admin.all-seller.bankUpdate', $user->id) }}" enctype="multipart/form-data" novalidate>
                        @method('PATCH')
                        @csrf
                        <div class="card-header">
                            <h4 class="card-title mb-0">Bank Account Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Account Holder Name:<sup class="text-danger fs-5">*</sup> :</label>
                                        <input type="text" name="holders_name" value="{{$user->bank->holders_name??old('holders_name')}}" class="form-control" placeholder="Enter Account Holder Name..." required />
                                        <div class="valid-feedback">Looks good!</div>
                                        <div class="invalid-feedback">This field is required. </div>
                                        @error('holders_name')
                                            <div class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Account Number:<sup class="text-danger fs-5">*</sup> :</label>
                                        <input type="text" class="form-control" name="account_no" value="{{$user->bank->account_no??old('account_no')}}" placeholder="Enter Account Number..." required />
                                        <div class="valid-feedback">Looks good!</div>
                                        <div class="invalid-feedback">This field is required. </div>
                                        @error('account_no')
                                            <div class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Bank Name:<sup class="text-danger fs-5">*</sup> :</label>
                                        <input type="text" class="form-control" name="bank_name" value="{{$user->bank->bank_name??old('bank_name')}}" placeholder="Enter Bank Name..." required />
                                        <div class="valid-feedback">Looks good!</div>
                                        <div class="invalid-feedback">This field is required. </div>
                                        @error('bank_name')
                                            <div class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="name" class="form-label">IFSC Code:<sup class="text-danger fs-5">*</sup> :</label>
                                        <input type="text" class="form-control" name="ifsc_code" value="{{$user->bank->ifsc_code??old('ifsc_code')}}" placeholder="Enter IFSC Code..." required />
                                        <div class="valid-feedback">Looks good!</div>
                                        <div class="invalid-feedback">This field is required. </div>
                                        @error('ifsc_code')
                                            <div class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Branch Name:<sup class="text-danger fs-5">*</sup> :</label>
                                        <input type="text" class="form-control" name="branch_name" value="{{$user->bank->branch_name??old('branch_name')}}" placeholder="Enter Branch Name..." required />
                                        <div class="valid-feedback">Looks good!</div>
                                        <div class="invalid-feedback">This field is required. </div>
                                        @error('branch_name')
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
                    </form>
                </div> --}}

                <!--[ UPI Details ] start -->
                {{-- <div class="card border">
                    <form class="custom-form needs-validation" method="post" action="{{ route('admin.all-seller.upiUpdate', $user->id) }}" enctype="multipart/form-data" novalidate>
                        @method('PATCH')
                        @csrf
                        <div class="card-header">
                            <h4 class="card-title mb-0">UPI Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">UPI Holder Name:<sup class="text-danger fs-5">*</sup> :</label>
                                        <input type="text" class="form-control" name="upi_name" value="{{$user->upi->upi_name??old('upi_name')}}" placeholder="Enter UPI Holder Name..." required/>
                                        <div class="valid-feedback">Looks good!</div>
                                        <div class="invalid-feedback">This field is required. </div>
                                        @error('upi_name')
                                            <div class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">UPI ID:<sup class="text-danger fs-5">*</sup> :</label>
                                        <input type="text" class="form-control" name="upi_id" value="{{$user->upi->upi_id??old('upi_id')}}" placeholder="Enter UPI id..." required/>
                                        <div class="valid-feedback">Looks good!</div>
                                        <div class="invalid-feedback">This field is required. </div>
                                        @error('upi_id')
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
                    </form>
                </div> --}}

                <!--[ GST Details ] start -->
                {{-- <div class="card border">
                    <form class="custom-form" method="post" action="{{ route('admin.all-seller.gstUpdate', $user->id) }}" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
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
                    </form>
                </div> --}}

                  <!--[ Area Mapping  ] start -->
                  {{-- <div class="card border">
                    <form class="custom-form" method="post" action="#" enctype="multipart/form-data">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Delivery Area Mapping</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <!-- <label for="name" class="form-label">Select Area:</label> -->
                                        <select class="form-control select2 select2-multiple" multiple="multiple" data-placeholder="Choose Area..." >
                                            <option value="2">badarpur</option>
                                            <option value="3">Jaithpur</option>
                                            <option value="4">Meethapur</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
                        </div>
                    </form>
                </div> --}}

            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- container-fluid -->
</div>
@endsection
