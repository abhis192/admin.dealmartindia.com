@extends('layouts.backend.app')

@section('title')
<title>Razorpay</title>
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
                            <h5 class="m-b-10">Edit Page</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="feather icon-home"></i></a></li>  
                            <li class="breadcrumb-item"><a href="{{route('admin.razorpay')}}">Manage Razorpay</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->  
        <div class="row"> 
            <div class="col-sm-12">
                <div class="card"> 
                    <form class="custom-form" method="post" action="{{ route('admin.razorpay.update', $cred->id) }}">
                        @method('PATCH')
                        @csrf
                        <div class="card-header"></div>
                        <div class="card-body">
                            <div class="row">   
                                <div class="col-sm-6">
                                    <div class="form-group fill">  
                                        <label class="control-label">Razorpay Key<span>*</span></label>
                                        <input type="text" class="form-control form-control-sm @error('key') is-invalid @enderror" placeholder="Enter key..." name="key" value="{{ $cred->key }}" required/>
                                        @error('key')
                                            <div class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group fill">  
                                        <label class="control-label">Razorpay Secret Key<span>*</span></label>
                                        <input type="text" class="form-control form-control-sm @error('secret_key') is-invalid @enderror" placeholder="Enter Secret Key..." name="secret_key" value="{{ $cred->secret_key }}" required/>
                                        @error('secret_key')
                                            <div class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <div class="card-footer text-right"> 
                            <button type="" class="btn btn-warning">Cancel</button>
                            <button type="submit" class="btn btn-success m-0">Submit</button>
                        </div>
                    </form>  
                </div>
            </div> 
        </div> 
        <!-- [ Main Content ] end -->
    </div>
</div>
@endsection
