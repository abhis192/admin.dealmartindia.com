<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="@bhis1">
    <title>Login | {{env('APP_NAME')}}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    {{--@include('layouts.frontend.partials.style')--}}
    @include('layouts.backend.partials.style')
</head>
<body>
    <!--Page Wrapper-->
    <div class="page-wrapper">
        {{--@include('layouts.frontend.partials.header')--}}

        <div id="page-content">
            <!--Breadcrumbs-->
            <div class="breadcrumbs-wrapper text-uppercase">
                <div class="container">
                    <div class="breadcrumbs"><a href="{{URL('/')}}" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">Login</span></div>
                </div>
            </div>
            <!--End Breadcrumbs-->

            <!--Main Content-->
            <section class="login-main">
                <div class="container">
                    <!--Main Content-->
                    <div class="mainlogin-sliding my-5 py-0 py-lg-4">
                        <div class="row">
                            <div class="col-12 col-sm-10 col-md-10 col-lg-10 col-xl-10 mx-auto">
                                <div class="row g-0 form-slider">
                                    <div class="col-lg-6 login-img-bg" style="background-image: url({{asset('assets/images/login-bg.jpg')}});"></div>
                                    <div class="col-lg-6">
                                        <!-- Login Wrapper -->
                                        <div class="login-wrapper">
                                            <!-- Login Inner -->
                                            <div class="login-inner">
                                                <!-- Login Logo -->
                                                <a href="./" class="logo d-inline-block mb-4"><img src="{{asset('assets/images/logo.png')}}" alt="logo" /></a>
                                                <!-- End Login Logo -->
                                                <!-- User Form -->
                                                <div class="user-loginforms">
                                                    <!-- Login Form -->
                                                    <form method="POST" action="{{ route('login') }}" class="form-horizontal" action="#">
                                                        @csrf
                                                        <h4>Login to your account</h4>
                                                        <div class="form-row">
                                                            <div class="form-group w-100">
                                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" id="email" placeholder="Enter Email" autofocus>
                                                                @error('email')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group w-100">
                                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" id="password" placeholder="Enter Password">
                                                                @error('password')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>

                                                            <div class="row justify-content-between">
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <div class="customCheckbox cart_tearm">
                                                                            <input type="checkbox" class="form-check-input" id="agree" />
                                                                            <label for="agree">Remember</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 text-end">
                                                                    @if (Route::has('password.request'))
                                                                        <a class="btn-link fw-500 forgotpass-link" id="forgot" href="{{ route('password.request') }}">
                                                                            {{ __('Forgot Password?') }}
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <button type="submit" class="btn btn-primary rounded w-100 register-link">Sign In</button>
                                                                </div>
                                                                <div class="col-lg-12 text-center mt-2">
                                                                    Not registered? <a href="{{route('register')}}" class="fw-500 ms-1 btn-link signup-link">Create an account</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <!-- End Login Form -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Login Wrapper -->
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
    </div>

    {{--@include('layouts.frontend.partials.footer')
    @include('layouts.frontend.partials.drawer')
    @include('layouts.frontend.partials.script')--}}
    @include('layouts.backend.partials.script')
    @php
        $statusMessage = '';
        if (session()->get('success')) {
            $statusMessage=session()->get('success');
        } elseif (session()->get('error')) {
            $statusMessage=session()->get('error');
        } elseif (session()->get('failure')) {
            $statusMessage=session()->get('failure');
        }
    @endphp
    @if(session()->get('success'))
    <script>
        Command: toastr["success"]('<?php echo $statusMessage; ?>')

        toastr.options = {
          "closeButton": true,
          "debug": false,
          "newestOnTop": false,
          "progressBar": true,
          "positionClass": "toast-top-right",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": 300,
          "hideDuration": 1000,
          "timeOut": 5000,
          "extendedTimeOut": 1000,
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }
    </script>
    @endif
    @if (session('error') || session('failure'))
    <script>
        Command: toastr["error"]('<?php echo $statusMessage; ?>')

        toastr.options = {
          "closeButton": true,
          "debug": false,
          "newestOnTop": false,
          "progressBar": true,
          "positionClass": "toast-top-right",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": 300,
          "hideDuration": 1000,
          "timeOut": 5000,
          "extendedTimeOut": 1000,
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }
    </script>
    @endif
</body>
</html>

