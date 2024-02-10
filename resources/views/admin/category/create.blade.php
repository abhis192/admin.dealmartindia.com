@extends('layouts.backend.app')

@section('title')
<title>Category Create</title>
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
                    <h4 class="mb-sm-0 font-size-18">Add Product Category</h4>

                    <div class="page-title-right">
                        <!-- <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">All Users</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
                        </ol> -->
                        <a href="{{route('admin.product-category')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-reply-all"></i> Back to list</a>
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-12">
                <form class="custom-form needs-validation" method="post" action="{{ route('admin.product-category.store') }}" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-lg-8">

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Product Category Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Category Name <sup class="text-danger fs-5">*</sup> :</label>
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
                                                    <div class="input-group-text">{{env('APP_URL')}}category/</div>
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
                                                <label for="parentCategory" class="form-label fw-bold">Choose Parent Category :</label>
                                                <select class="form-control select2" name="parent_category_id" id="parentCategory">
                                                    <option value="">Select</option>
                                                    @foreach($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-12" id="productType">
                                            <div class="form-group">
                                                <label for="typeId" class="form-label fw-bold">Choose Type:</label>
                                                <select class="form-control select2" id="typeId" name="type_id" required="required">
                                                    <option value="">Select</option>
                                                    @foreach($types as $type)
                                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="description" class="form-label fw-bold">Description:</label>
                                                <textarea class="summernote @error('description') is-invalid @enderror" name="description">{{old('description')}}</textarea>
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
                                                <label for="title" class="form-label">Meta Title:</label>
                                                <input type="text" id="title" name="meta_title" value="{{old('meta_title')}}" class="form-control @error('meta_title') is-invalid @enderror" placeholder="Enter meta title"/>
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
                                                <label for="meta_keywords" class="form-label">Meta Keywords:</label>
                                                <textarea name="meta_keywords" id="meta_keywords" class="form-control @error('meta_keywords') is-invalid @enderror" placeholder="Write somthing...">{{old('meta_keywords')}}</textarea>
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
                                                <label for="meta_description" class="form-label">Meta Description:</label>
                                                <textarea name="meta_description" id="meta_description" name="meta_description" class="form-control @error('meta_description') is-invalid @enderror" placeholder="Write somthing...">{{old('meta_description')}}</textarea>
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
                                                    <input type="checkbox" id="square-switch1" name="status" switch="status" checked>
                                                    <label for="square-switch1" data-on-label="Yes" data-off-label="No"></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="order" class="form-label fw-bold">Ordering Number:</label>
                                                <input type="number" min="0" id="order" value="{{ old('order') }}" name="order" class="form-control" placeholder="Enter Order Lavel"/>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                <small class="text-muted"><b>Note::</b> Higher number has high priority </small>
                                                @error('order')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="delay" class="form-label fw-bold">Delay:</label>
                                                <input type="number" id="delay" value="{{ old('delay') }}" name="delay" class="form-control" placeholder="Enter Delay Hours"/>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                {{-- <small class="text-muted"><b>Note::</b> Higher number has high priority </small> --}}
                                                @error('delay')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Filtering Attributes:</label>
                                                <select class="form-control select2 select2-multiple" multiple="multiple" data-placeholder="Choose ...">
                                                    <option>Select</option>
                                                    <option value="AK">Size</option>
                                                    <option value="HI">Color</option>
                                                    <option value="HI">Sleeve</option>
                                                    <option value="HI">Fabric</option>
                                                </select>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div>
                            <!-- end card -->

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Category Images</h4>
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
                                                <label class="form-label fw-bold">Profile Icon Image:</label>
                                                <input type="file" id="input-file-now" name="icon" class="dropify" />
                                                <small class="text-muted"><b>Example::</b> icon size - 128x128 </small>
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
