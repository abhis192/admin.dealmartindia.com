<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="@bhis1">
    <title>Reset Password | {{env('APP_NAME')}}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    @include('layouts.partials.style')
</head>
<body>
    <!--Page Wrapper-->
    <div class="page-wrapper">
        @include('layouts.partials.header')

        <div id="page-content">
            <!--Breadcrumbs-->
            <div class="breadcrumbs-wrapper text-uppercase">
                <div class="container">
                    <div class="breadcrumbs"><a href="{{URL('/')}}" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">Reset Password</span></div>
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
                                    <div class="col-lg-12">
                                        <!-- Login Wrapper -->
                                        <div class="login-wrapper">
                                            <!-- Login Inner -->
                                            <div class="login-inner">
                                                <!-- Login Logo -->
                                                <a href="./" class="logo d-inline-block mb-4"><img src="{{asset('images/logo.png')}}" alt="logo" /></a>
                                                
                                                @if (session('status'))
                                                    <div class="alert alert-success" role="alert">
                                                        {{ session('status') }}
                                                    </div>
                                                @endif
                                                <div class="user-loginforms">
                                                    <form method="POST" action="{{ route('password.email') }}">
                                                    @csrf
                                                        <div class="row mb-3">
                                                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                                            <div class="col-md-6">
                                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                                                @error('email')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="row mb-0">
                                                            <div class="col-md-6 offset-md-4">
                                                                <button type="submit" class="btn btn-primary">
                                                                    {{ __('Send Password Reset Link') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
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

    @include('layouts.partials.footer')
    @include('layouts.partials.drawer')
    @include('layouts.partials.script')
</body>
</html>
