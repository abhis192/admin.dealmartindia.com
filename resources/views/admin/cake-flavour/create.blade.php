@extends('layouts.backend.app')

@section('title')
<title>Cake Flavour | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">Add Cake Flavour</h4>

                    <div class="page-title-right">
                        <!-- <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">All Users</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
                        </ol> -->
                        <a href="{{route('admin.cake-flavour')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-reply-all"></i> Back to list</a>
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-12">
                <form class="custom-form needs-validation"  method="POST" action="{{ route('admin.cake-flavour.store') }}" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="row">

                        <div class="col-lg-8">

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Cake Flavour Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Cake Flavour Name <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Your Name" value="{{ old('name') }}" onkeyup="slug_url(this.value,'init_slug')" required/>
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
                                                <label for="name" class="form-label fw-bold">Slug <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="input-group">
                                                    <div class="input-group-text">{{env('APP_URL')}}cake-flavour/</div>
                                                    <input type="text" class="form-control form-control-sm @error('slug') is-invalid @enderror" Placeholder="Enter Uniqe Slug." name="slug" value="{{ old('slug') }}" id="init_slug" required/>
                                                    <div class="valid-feedback">Looks good!</div>
                                                    <div class="invalid-feedback">This field is required. </div>
                                                    @error('slug')
                                                        <div class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="description" class="form-label fw-bold">Description:</label>
                                                <textarea class="summernote @error('description') is-invalid @enderror" name="description"></textarea>
                                                @error('description')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div>
                            <!-- end card -->

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">SEO Meta Tags</h4>
                                </div>
                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Meta Title:</label>
                                                <input type="text" class="form-control form-control-sm @error('meta_title') is-invalid @enderror" name="meta_title" value="{{old('meta_title')}}" />
                                                @error('meta_title')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="description" class="form-label">Meta Keywords:</label>
                                                <textarea class="form-control form-control-sm @error('meta_keywords') is-invalid @enderror" name="meta_keywords" placeholder=""></textarea>
                                                @error('meta_keywords')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="description" class="form-label">Meta Description:</label>
                                                <textarea class="form-control form-control-sm @error('meta_description') is-invalid @enderror" name="meta_description" placeholder=""></textarea>
                                                @error('meta_description')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
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

                                        <div class="col-lg-12 border-bottom mb-2">
                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                <label for="name" class="form-label fw-bold">Published <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="square-switch">
                                                    <input type="checkbox" id="square-switch1" name="status" switch="status" checked="">
                                                    <label for="square-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div>
                            <!-- end card -->

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Cake Flavour Images</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">Profile Image:</label>
                                                <input type="file" id="input-file-now" name="image" class="dropify" />
                                                <small class="text-muted"><b>Example::</b> image size - 500x500 </small>
                                                @error('image')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-label">
                                                <label class="form-label fw-bold">Profile Icon:</label>
                                                <input type="file" id="input-file-now" name="icon" class="dropify" />
                                                <small class="text-muted"><b>Example::</b> image size - 128x128 </small>
                                                @error('icon')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div>
                            <!-- end card -->

                        <div class="col-lg-12">
                            <div class="card action-btn text-end">
                                <div class="card-body p-2">
                                    <button type="reset" class="btn btn-warning waves-effect waves-light">Clear</button>
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
