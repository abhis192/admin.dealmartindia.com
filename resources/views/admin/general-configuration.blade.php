@extends('layouts.backend.app')

@section('title')
<title>General Configuration | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">General Configuration</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">Website Configuration</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-12">

                <form class="custom-form needs-validation" method="post" action="{{route('admin.general-configuration.update',$data->id)}}" novalidate>
                    @method('PATCH')
                    @csrf
                    <div class="row">
                        <div class="col-lg-8">

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">General Settings</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Site Name <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" id="name" name="site_name" class="form-control" placeholder="Enter Your Website Name..." value="{{$data->site_name}}" required/>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Site Email Id: <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="email" id="name" name="site_email" class="form-control" placeholder="Enter Your Website Slogan..." value="{{$data->site_email}}" required/>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div>
                            <!-- end card -->

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Contact Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Email Id:</label>
                                                <input type="email" id="name" name="email" class="form-control" placeholder="Enter Your Website Name..." value="{{$data->email}}" />
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Contact Number:</label>
                                                <input type="text" id="name" name="mobile" class="form-control" placeholder="Enter Your Website Name..." value="{{$data->mobile}}" />
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Address:</label>
                                                <textarea id="name" name="address" class="form-control" placeholder="Enter Your Website Name...">{{$data->address}}</textarea>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Social Icons:</label>
                                                <input type="text" name="facebook" value="{{$data->facebook}}" class="form-control mb-2" placeholder="Enter Facebook link..." />
                                                <input type="text" name="instagram" value="{{$data->instagram}}" class="form-control mb-2" placeholder="Enter Instagram link..." />
                                                <input type="text" name="twitter" value="{{$data->twitter}}" class="form-control mb-2" placeholder="Enter Twitter link..." />
                                                <input type="text" name="linkedin" value="{{$data->linkedin}}" class="form-control mb-2" placeholder="Enter Linkedin link..." />
                                                <input type="text" name="youtube" value="{{$data->youtube}}" class="form-control mb-2" placeholder="Enter YouTube link..." />
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div>
                            <!-- end card -->

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Global SEO Meta Tags</h4>
                                </div>
                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Meta Title:</label>
                                                <input type="text" id="name" name="meta_title" class="form-control" placeholder="Enter Your Full Name" value="{{$data->meta_title}}"/>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="description" class="form-label">Meta Keywords:</label>
                                                <textarea name="meta_keywords" id="description" class="form-control" placeholder="Write somthing..."> {{$data->meta_keywords}} </textarea>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="description" class="form-label">Meta Description:</label>
                                                <textarea name="meta_description" id="description" class="form-control" placeholder="Write somthing...">{{$data->meta_description}}</textarea>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div>
                            <!-- end card -->

                        </div>

                        <div class="col-lg-4">

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Advance Configuration</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="form-group d-flex justify-content-between align-itema-center">
                                                <label for="name" class="form-label fw-bold">Show Topbar Header <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="square-switch">
                                                    <input type="checkbox" name="topbar_header" id="square-switch3" switch="status" {{ $data->topbar_header == 1 ? "checked" : "" }} />
                                                    <label for="square-switch3" data-on-label="Yes"
                                                        data-off-label="No"></label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- end card -->

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Website Logo</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12l">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">Logo:</label>
                                                <input type="file" id="input-file-now" name="logo" class="dropify" data-default-file="{{asset('storage/setting/'.$data->logo)}}" />
                                                <input type="hidden" name="hidden_logo" value="{{ $data->logo }}">
                                                <small class="text-muted"><b>Example::</b> image size - 500x500 </small>
                                            </div>
                                        </div>
                                        <!-- <div class="col-sm-6">
                                            <div class="form-label">
                                                <label class="form-label fw-bold">Light Logo:</label>
                                                <input type="file" id="input-file-now" class="dropify" />
                                                <small class="text-muted"><b>Example::</b> image size - 500x500 </small>
                                            </div>
                                        </div>  -->
                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div>
                            <!-- end card -->

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Website Icon</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">Site Icon:</label>
                                                <input type="file" id="input-file-now" name="icon" class="dropify" data-default-file="{{asset('storage/setting/'.$data->icon)}}"/>
                                                <input type="hidden" name="hidden_icon" value="{{ $data->icon }}">
                                                <small class="text-muted"><b>Example::</b> image size - 128x128 </small>
                                            </div>
                                        </div>
                                        <!-- <div class="col-sm-6">
                                            <div class="form-label">
                                                <label class="form-label fw-bold">Light Site Icon:</label>
                                                <input type="file" id="input-file-now" class="dropify" />
                                                <small class="text-muted"><b>Example::</b> image size - 128x128 </small>
                                            </div>
                                        </div>  -->
                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div>
                            <!-- end card -->

                        </div>

                        <div class="col-lg-12">
                            <div class="card action-btn text-end">
                                <div class="card-body p-2">
                                    <!-- <button type="reset" class="btn btn-warning waves-effect waves-light">Clear</button> -->
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>

            </div> <!-- end col -->
        </div> <!-- end row -->


    </div>
    <!-- container-fluid -->
</div>
@endsection
