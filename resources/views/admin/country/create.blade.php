@extends('layouts.backend.app')

@section('title')
<title>Country Create</title>
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
                            <h5 class="m-b-10">Create Country</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.country')}}">Manage Country</a></li>
                            <li class="breadcrumb-item"><a href="">Add Country</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 text-md-right">
                        <a href="{{route('admin.country')}}" class="btn btn-success" title="Back to List"><i class="fas fa-reply-all"></i> Back to list</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <form class="custom-form" method="POST" action="{{ route('admin.country.store') }}">
                        @csrf
                        <div class="card-header"></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group fill">
                                        <label class="control-label">Country Name<span>*</span></label>
                                        <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" placeholder="Enter Name..." name="name" value="{{ old('name') }}" required/>
                                        @error('name')
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
