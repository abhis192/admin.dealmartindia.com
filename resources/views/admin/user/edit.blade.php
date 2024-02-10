@extends('layouts.backend.app')

@section('title')
<title>Users Edit | {{Auth::user()->name}}</title>
@endsection

@section('css')
@endsection

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">

        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Edit User</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./"><i class="feather icon-home"></i></a></li>  
                            <li class="breadcrumb-item"><a href="{{route('admin.users')}}">Manage Users</a></li>
                            <li class="breadcrumb-item"><a href="">Edit User</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 text-md-right"> 
                        <a href="{{route('admin.users')}}" class="btn btn-success" title="Back to List"><i class="fas fa-reply-all"></i> Back to list</a> 
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start --> 
        <div class="row"> 
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <form class="custom-form" method="post" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <input name="avatar" type="file" data-allowed-file-extensions="png jpg gif jpeg" class="dropify" data-max-file-size="2M" data-default-file="{{asset($user->avatar)}}" />
                                    <input type="hidden" name="hidden_avatar" value="{{ $user->avatar }}">
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Full Name:</label>
                                                <input type="text" id="name" class="form-control form-control-sm @error('name') is-invalid @enderror" Placeholder="Enter Name." required value="{{ $user->name }}" name="name" />
                                                @error('name')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div> 
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Email Id:</label>
                                                <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" Placeholder="Enter Email." required name="email" value="{{ $user->email }}" />
                                                @error('email')
                                                    <span class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-form-label">Contact Number:</label>
                                                <input type="text" class="form-control form-control-sm" Placeholder="Enter Mobile Number." name="mobile" value="{{$user->mobile}}" />
                                                @error('mobile')
                                                    <span class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>   
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-form-label">Date of Birth:</label>
                                                <input type="date" name="dob" class="form-control form-control-sm" value="{{$user->dob}}"/>
                                                @error('dob')
                                                    <span class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-form-label">Gender:</label>
                                                <select name="gender" class="form-control form-control-sm" required>
                                                    <option value="">--Select Gender--</option>
                                                    <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                                                    <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
                                                </select>
                                                @error('gender')
                                                    <span class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group"> 
                                                <label class="col-form-label">Status:</label>
                                                <select name="status" class="form-control form-control-sm" required>
                                                    <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Enable</option>
                                                    <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Disable</option>
                                                </select> 
                                                @error('status')
                                                    <span class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                        
                                    </div>  
                                </div>
                            </div>   

                            <div class="row">
                                <div class="col-sm-12">
                                    <h5 class="mt-4">Current Password</h5>
                                    <hr class="mt-0">
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group"> 
                                        <input type="password" name="password" class="form-control form-control-sm @error('password') is-invalid @enderror" placeholder="Password" />
                                        @error('password')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>  
                                <div class="col-sm-4">
                                    <div class="form-group"> 
                                        <input type="password" name="password_confirmation" class="form-control form-control-sm" placeholder="Confirm Password" />
                                    </div>
                                </div>  
                            </div>
                            <div class="row"> 
                                <div class="col-sm-12 text-right">  
                                    <button type="submit" class="btn btn-success">Save Change</button>  
                                </div>
                            </div>  
                        </form>  
                    </div>
                </div>
            </div> 
        </div>

        </div> 
        <!-- [ Main Content ] end -->
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function(){ 
        $('.dropify').dropify();
    });
</script>
@endsection