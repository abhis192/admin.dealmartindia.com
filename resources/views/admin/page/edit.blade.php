@extends('layouts.backend.app')

@section('title')
<title>Pages Edit | {{$page->name}}</title>
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
                    <h4 class="mb-sm-0 font-size-18">Add Page</h4>

                    <div class="page-title-right">
                        <a href="{{route('admin.pages')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-reply-all"></i> Back to list</a>
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-12">
                <form class="custom-form needs-validation" method="post" action="{{ route('admin.page.update',$page->id) }}" enctype="multipart/form-data" novalidate>
                    @method('PATCH')
                    @csrf
                    <div class="row">
                        <div class="col-lg-8">

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Page Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Page Name <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Page Name" value="{{ $page->name }}" required/>
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
                                                    <div class="input-group-text">{{env('APP_URL')}}</div>
                                                    <input type="text" class="form-control form-control-sm @error('slug') is-invalid @enderror" Placeholder="Enter Uniqe Slug." name="slug" value="{{ $page->slug }}" required/>
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
                                                <textarea class="summernote @error('description') is-invalid @enderror" name="description" id="editor1">{{$page->description}}</textarea>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
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
                                                <input type="text" id="title" name="meta_title" value="{{$page->meta_title}}" class="form-control @error('meta_title') is-invalid @enderror" placeholder="Enter meta title"/>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
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
                                                <textarea name="meta_keywords" id="meta_keywords" class="form-control @error('meta_keywords') is-invalid @enderror" placeholder="Write somthing...">{{$page->meta_keywords}}</textarea>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
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
                                                <textarea name="meta_description" id="meta_description" name="meta_description" class="form-control @error('meta_description') is-invalid @enderror" placeholder="Write somthing...">{{$page->meta_description}}</textarea>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
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
                                    <h4 class="card-title mb-0">Page Banner</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">Banner Images:</label>
                                                <input type="file" id="input-file-now" name="image" class="dropify" data-default-file="{{asset('storage/page/'.$page->image)}}" />
                                                <input type="hidden" name="hidden_image" value="{{ $page->image }}">
                                                <small class="text-muted"><b>Example::</b> image size - 1920x550 </small>
                                                @error('image')
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
