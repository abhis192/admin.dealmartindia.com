<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Admin Login | {{env('APP_NAME')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Abhisan Technology" />
    @include('layouts.backend.partials.style')
</head>

<body data-sidebar="dark" data-layout-mode="light">

    <div class="account-pages">
        <div class="container">
            <div class="row justify-content-center align-items-center h-100v">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Welcome Back !</h5>
                                        <p>Sign in with {{env('APP_NAME')}}.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{asset('backend/admin/images/profile-img.png')}}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="auth-logo">
                                <a href="./" class="auth-logo-light">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="{{asset('backend/admin/images/logo-light.svg')}}" alt="" class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>

                                <a href="./" class="auth-logo-dark">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="{{asset('backend/admin/images/logo.svg')}}" alt="" class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form method="POST" action="{{ route('admin.postLogin') }}" class="form-horizontal" action="#">
                                    @csrf
                                    <input type="hidden" name="_role"  value="admin" />

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Username</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" id="email" placeholder="Enter Email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" id="password" placeholder="Enter Password">
                                            <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="form-check-label" for="customCheck1">
                                            Remember me
                                        </label>
                                    </div>

                                    <div class="mt-3 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <a href="reset-password.php" class="text-muted"><i class="mdi mdi-lock me-1"></i> Forgot your password?</a>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="text-center">
                        <p class="m-0">Copyright © <script>document.write(new Date().getFullYear())</script> {{env('APP_NAME')}}.</p>
                        <p> Design & Develop by <a href="https://abhisan.com/" target="_blank">Abhisan Technology</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.backend.partials.script')
</body>
</html>
