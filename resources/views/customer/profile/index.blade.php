@extends('layouts.frontend.customerapp')

@section('title')
<title>Profile | {{env('APP_NAME')}}</title>
@endsection

@section('css')
@endsection

@section('content')
<div id="page-content">
    <!--Breadcrumbs-->
    <div class="breadcrumbs-wrapper text-uppercase">
        <div class="container">
            <div class="breadcrumbs">
                <a href="{{URL('/')}}" title="Back to the home page">Home</a><span>|</span>
                <a href="#">Dashboard</a><span>|</span>
                <span class="fw-bold">Profile Info</span>
            </div>
        </div>
    </div>
    <!--End Breadcrumbs-->

    <!--Main Content-->
    <section class="my-profile-info">
        <div class="container pt-2">
            {{-- @include('layouts.frontend.partials.customerHeader') --}}

            <div class="row mb-4 mb-lg-5 pb-lg-5">
                <div class="col-xl-3 col-lg-2 col-md-12 mb-4 mb-lg-0 d-none d-lg-block">
                    <!-- Nav tabs -->
                    @include('layouts.frontend.partials.customerSidebar')
                </div>

                <div class="col-xl-9 col-lg-10 col-md-12">
                    <div class="dashboard-content p-0 border-0">

                        <!-- Profile Info -->
                        <div class="card profile-info">
                            <div class="card-header">
                                <h3 class="m-0">Account details </h3>
                            </div>
                            <div class="card-body account-login-form bg-light-gray padding-20px-all">
                                <form class="custom-form" method="post" action="{{ route('customer.profile.update', $user->id) }}" enctype="multipart/form-data">
		                            @method('PATCH')
		                            @csrf
                                    <fieldset>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="avatar" class="form-label">Profile Image</label>
                                                    <input type="file" id="avatar" name="image" class="@error('image') is-invalid @enderror" />
                                                    <input type="hidden" name="hidden_image" value="{{ $user->avatar }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="input-firstname" class="form-label">First Name <span class="required-f">*</span></label>
                                                    <input type="text" id="name" class="form-control form-control-sm @error('name') is-invalid @enderror" Placeholder="Enter Name." required value="{{ $user->name }}" name="name" />
                                                    @error('name')
                                                        <div class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="input-email" class="form-label">Email Id <span class="required-f">*</span></label>
                                                    <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" Placeholder="Enter Email." required name="email" value="{{ $user->email }}" />
                                                    @error('email')
                                                        <span class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="input-telephone" class="form-label">Mobile <span class="required-f">*</span></label>
                                                    <input type="text" class="form-control form-control-sm @error('mobile') is-invalid @enderror" Placeholder="Enter Mobile Number." name="mobile" value="{{$user->mobile}}" />
                                                    @error('mobile')
                                                        <span class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">Date of Birth<span class="required-f">*</span></label>
                                                    <input type="date" class="form-control form-control-sm @error('dob') is-invalid @enderror" Placeholder="Enter DOB." name="dob" value="{{$user->dob}}" />
                                                    @error('dob')
                                                        <span class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">Gender<span class="required-f">*</span></label>
                                                    <select class="form-control @error('gender') is-invalid @enderror" name="gender">
                                                        <option>Select</option>
                                                        <option value="male" {{$user->gender == "male" ? 'selected' : ''}}>Male</option>
                                                        <option value="female" {{$user->gender == "female" ? 'selected' : ''}}>Female</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                    @error('gender')
                                                        <span class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>



                                            <div class="col-lg-12">
                                                <p class="fs-6 mb-0 mt-3"><b>GST Details</b></p>
                                                <hr class="mt-0">
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">GST registered Name</label>
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
                                        <!-- <div class="row mb-4">
                                            <div class="col-md-12 col-lg-12 col-xl-12">
                                                <div class="customCheckbox clearfix mb-2">
                                                    <input id="offers" name="offers" type="checkbox" />
                                                    <label for="offers">Receive offers from our partners</label>
                                                </div>
                                                <div class="customCheckbox clearfix">
                                                    <input id="newsletter" name="newsletter" type="checkbox" />
                                                    <label for="newsletter">Sign up for our newsletter</label>
                                                </div>
                                            </div>
                                        </div> -->
                                    </fieldset>
                                    <button type="submit" class="btn btn-primary rounded">Save</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--End Main Content-->
        </div>
    </section>
    <!--End Container-->
</div>
@endsection
