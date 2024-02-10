@extends('layouts.frontend.customerapp')

@section('title')
<title>Seller Register | {{env('APP_NAME')}}</title>
@endsection

@section('css')
@endsection

@section('content') 
<div id="page-content">
    <!--Breadcrumbs-->
    <div class="breadcrumbs-wrapper text-uppercase">
        <div class="container">
            <div class="breadcrumbs"><a href="{{URL('/')}}" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">Become a Seller</span></div>
        </div>
    </div>
    <!--End Breadcrumbs-->

    <!-- [ Register Main Content ] start-->
    <section class="login-main">
        <div class="container">
            <!--Main Content-->
            <div class="mainlogin-sliding my-5 py-0 py-lg-4">
                <div class="row">
                    <div class="col-12 col-sm-10 col-md-10 col-lg-10 col-xl-10 mx-auto">
                        <div class="row g-0 form-slider">
                            <div class="col-lg-6 login-img-bg" style="background-image: url({{asset('assets/images/login-bg.jpg')}});"></div>
                            <div class="col-lg-6">
                                <!-- Register Wrapper -->
                                <div class="login-wrapper">
                                    <!-- Register Inner -->
                                    <div class="login-inner">
                                        <!-- Register Logo -->
                                        <a href="{{URL('/')}}" class="logo d-inline-block mb-4"><img src="{{asset('assets/images/logo.png')}}" alt="logo" /></a>
                                        <!-- End Register Logo -->
                                        <!-- User Form -->
                                        <div class="user-loginforms">
                                            <form method="post" action="{{route('seller.registerUser')}}" accept-charset="UTF-8" class="customer-form">
                                                @method('POST')
                                                @csrf
                                                <h4 class="text-start mb-3">Become a Seller</h4>    
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="CustomerName" class="d-none">Name <span class="required">*</span></label>
                                                            <input id="CustomerName" class="@error('name') is-invalid @enderror" value="{{ old('name') }}" type="text" name="name" placeholder="Name" required="">
                                                        </div>
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="BusinessName" class="d-none">Business Name <span class="required">*</span></label>
                                                            <input id="BusinessName" type="text" name="business" placeholder="Business Name..." required/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="CustomerLastName" class="d-none">Choose Product Category <span class="required">*</span></label> 
                                                            <select id="CustomerLastName" name="category_id" required>
                                                                <option value="">Select Category</option>
                                                                @foreach(allCategories() as $category)
                                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="CustomerMobile" class="d-none">Mobile Number <span class="required">*</span></label>
                                                            <input id="CustomerMobile" type="text" name="mobile" placeholder="Mobile" class="@error('mobile') is-invalid @enderror" value="{{ old('mobile') }}" required="">
                                                        </div>
                                                        @error('mobile')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div> 
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="CustomerEmail" class="d-none">Email Address <span class="required">*</span></label>
                                                            <input id="CustomerEmail" type="email" name="email" placeholder="email" class="@error('email') is-invalid @enderror" value="{{ old('email') }}" required="">
                                                        </div>
                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div> 

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="CustomerPassword" class="d-none">Password <span class="required">*</span></label>
                                                            <input id="CustomerPassword" type="password" name="password" placeholder="Password" class="@error('password') is-invalid @enderror" value="{{ old('password') }}" required="">
                                                        </div>
                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="CustomerConfirmPassword" class="d-none">Confirm Password <span class="required">*</span></label>
                                                            <input id="CustomerConfirmPassword" type="Password" name="password_confirmation" placeholder="Confirm Password" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group w-100">
                                                        <div class="customCheckbox cart_tearm">
                                                            <input type="checkbox" class="form-check-input" id="agree" value="">
                                                            <label for="agree">I agree the Terms and Conditions</label>
                                                        </div>
                                                    </div>
                                                </div> 
                                                     
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <button type="submit" class="btn btn-primary rounded w-100 register-link">Register</button>
                                                    </div> 
                                                    <div class="col-lg-12 text-center mt-2">
                                                        Already have an account?<a href="{{route('seller.login')}}" class="fw-500 ms-1 btn-link back-to-login">Sign In</a>
                                                    </div>
                                                </div>  

                                            </form>
                                        </div>
                                        <!-- End User Form -->
                                    </div>
                                    <!-- End Login Inner -->
                                </div>
                                <!-- End Login Wrapper -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--[ End Main Content ] -->
        </div>
    </section>
    <!-- [ End Register Container ] -->

</div>
@endsection
