@extends('layouts.backend.app')

@section('title')
<title>Edit Products | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">Add Product</h4>
                    <div class="page-title-right">
                        <a href="{{route('admin.product')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-reply-all"></i> Back to list</a>
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->


         <!-- [ Data ] start -->
         <div class="row">
            <div class="col-lg-12">
                <form class="custom-form needs-validation repeator" method="post" action="{{ route('admin.product.update',$product->id) }}" enctype="multipart/form-data" novalidate>
                    @method('PATCH')
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link d-flex active" data-bs-toggle="tab" href="#general" role="tab">
                                        <span class="me-1"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">General</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex" data-bs-toggle="tab" href="#price" role="tab">
                                        <span class="me-1"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">Price</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex" data-bs-toggle="tab" href="#seo" role="tab">
                                        <span class="me-1"><i class="fas fa-cog"></i></span>
                                        <span class="d-none d-sm-block">SEO</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex" data-bs-toggle="tab" href="#images" role="tab">
                                        <span class="me-1"><i class="fas fa-cog"></i></span>
                                        <span class="d-none d-sm-block">Images</span>
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content py-3 text-muted">
                                <div class="tab-pane active" id="general" role="tabpanel">

                                    <div class="row">
                                        <div class="col-lg-8">

                                            <!-- [ Product Information ] Start -->
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            {{-- <div class="form-group">
                                                                <label for="name" class="form-label fw-bold">Product Name <sup class="text-danger fs-5">*</sup> :</label>
                                                                <input type="text" id="name" class="form-control" placeholder="Enter Your Full Name" required/>
                                                                <div class="valid-feedback">Looks good!</div>
                                                                <div class="invalid-feedback">This field is required. </div>
                                                            </div> --}}
                                                            <div class="form-group">
                                                                <label for="name" class="form-label fw-bold">Product Name <sup class="text-danger fs-5">*</sup> :</label>
                                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Your Full Name" value="{{$product->name}}" onkeyup="slug_url(this.value,'init_slug')" required/>
                                                                <div class="valid-feedback">Looks good!</div>
                                                                <div class="invalid-feedback">This field is required. </div>
                                                                @error('name')
                                                                    <div class="text-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        {{-- <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="name" class="form-label fw-bold">Slug <sup class="text-danger fs-5">*</sup> :</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-text">https://cake24x7.com/product/</div>
                                                                    <input type="text" class="form-control" id="slug" />
                                                                </div>
                                                                <div class="valid-feedback">Looks good!</div>
                                                                <div class="invalid-feedback">This field is required. </div>
                                                            </div>
                                                        </div> --}}

                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="name" class="form-label fw-bold">Slug <sup class="text-danger fs-5">*</sup> :</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-text">{{env('APP_URL')}}product/</div>
                                                                    <input type="text" class="form-control form-control-sm @error('slug') is-invalid @enderror" Placeholder="Enter Uniqe Slug." name="slug" value="{{$product->slug}}" id="init_slug" required/>
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


                                                        {{-- <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="name" class="form-label fw-bold">Product Category<sup class="text-danger fs-5">*</sup> :</label>
                                                                <select class="form-control select2 select2-multiple" multiple="multiple" data-placeholder="Choose Category..." >
                                                                    <option value="1">All Category</option>
                                                                    <option value="2">Category 1</option>
                                                                    <option value="3">Category 2</option>
                                                                    <option value="4">Category 3</option>
                                                                </select>
                                                                <div class="valid-feedback">Looks good!</div>
                                                                <div class="invalid-feedback">This field is required. </div>
                                                            </div>
                                                        </div> --}}

                                                        {{-- <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="form-label fw-bold">Choose Type :</label>
                                                                <select class="form-control select2" name="type_id" required>
                                                                    <option value="">Select</option>
                                                                    @foreach($types as $type)
                                                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="valid-feedback">Looks good!</div>
                                                                <div class="invalid-feedback">This field is required. </div>
                                                                @error('brand_id')
                                                                    <div class="text-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div> --}}
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="name" class="form-label fw-bold">Choose Type :</label>
                                                                <select class="form-control select2" id="parentCategory" name="type_id" required>
                                                                    <option value="">Select</option>
                                                                    @foreach($types as $type)
                                                                        @if(!empty($product->type))
                                                                        <option value="{{$type->id}}" {{ $type->id == $product->type->id ? 'selected' : '' }}>{{$type->name}}</option>
                                                                        @else
                                                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                                <div class="valid-feedback">Looks good!</div>
                                                                <div class="invalid-feedback">This field is required. </div>
                                                                @error('type_id')
                                                                    <div class="text-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                       <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="sku" class="form-label fw-bold">SKU <sup class="text-danger fs-5">*</sup> :</label>
                                                            <input type="text" name="sku" id="sku" class="form-control" placeholder="Enter SKU Number" value="{{$product->sku}}" required/>
                                                            <div class="valid-feedback">Looks good!</div>
                                                            <div class="invalid-feedback">This field is required. </div>
                                                        </div>
                                                            @error('sku')
                                                                <div class="text-danger">
                                                                    <strong>{{ $message }}</strong>
                                                                </div>
                                                            @enderror
                                                        </div>

                                                        {{-- <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="name" class="form-label fw-bold">Product Category <sup class="text-danger fs-5">*</sup> :</label>
                                                                <select class="form-control select2" name="category_id[]" id="parentCategory" multiple required>
                                                                    <option value="">Select</option>
                                                                    @foreach($categories as $category)
                                                                        @if($category->subCategories->count())
                                                                        <optgroup label="{{$category->name}}">
                                                                            @foreach($category->subCategories as $subCategory)
                                                                            <option value="{{$subCategory->id}}">{{$subCategory->name}}</option>
                                                                            @endforeach
                                                                        </optgroup>
                                                                        @else
                                                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                                <div class="valid-feedback">Looks good!</div>
                                                                <div class="invalid-feedback">This field is required. </div>
                                                                @error('category_id')
                                                                    <div class="text-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div> --}}
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="name" class="form-label fw-bold">Product Category <sup class="text-danger fs-5">*</sup> :</label>
                                                                {{-- <select class="form-control select2" name="category_id[]" id="parentCategory" multiple required>
                                                                    <option value="">Select</option>
                                                                    @foreach($categories as $category)
                                                                        @if($category->subCategories->count())
                                                                        <optgroup label="{{$category->name}}">
                                                                            @foreach($category->subCategories as $subCategory)
                                                                            <option value="{{$subCategory->id}}">{{$subCategory->name}}</option>
                                                                            @endforeach
                                                                        </optgroup>
                                                                        @else
                                                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select> --}}
                                                                {{-- <select class="form-control select2" name="category_id[]" multiple required> --}}
                                                                    {{-- <option value="">Select</option>
                                                                    @foreach($categories as $category)
                                                                    <option value="{{$category->id}}" @if(in_array($category->id, explode(',',$product->category_id))) selected @endif>{{$category->name}}</option> --}}
                                                                    {{-- <option value="{{$slot->id}}" {{ $slot->id == $deliveryoption->time_slot_inside ? "selected" : "" }}>{{$slot->from}}-{{$slot->to}}</option> --}}
                                                                    {{-- @endforeach --}}
                                                                </select>

                                                                <select name="category_id[]" class="form-control select2 select2-multiple" multiple="multiple" data-placeholder="Choose Categories...">
                                                                    {{-- @foreach($categories as $category)
                                                                    <option value="{{$category->id}}"
                                                                        @foreach($product->categories as $prodCat)
                                                                            @if($prodCat->category_id)
                                                                                selected
                                                                            @endif
                                                                        @endforeach
                                                                        >
                                                                        {{$category->name}}
                                                                    </option>
                                                                    @endforeach --}}

                                                                    @foreach($categories as $category)
                                                                    <option
                                                                        value="{{$category->id}}"
                                                                        @foreach($product->categories as $prodCat)
                                                                            @if($prodCat->category_id == $category->id)
                                                                                selected
                                                                            @endif
                                                                        @endforeach
                                                                        >
                                                                        {{$category->name}}
                                                                    </option>
                                                                    @endforeach
                                                                 </select>

                                                                <div class="valid-feedback">Looks good!</div>
                                                                <div class="invalid-feedback">This field is required. </div>
                                                                @error('category_id')
                                                                    <div class="text-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="description" class="form-label fw-bold">Description:</label>
                                                                <textarea name="description" class="summernote">{{$product->description}}</textarea>
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

                                            {{-- <div class="card">
                                                <div class="card-header"><h4 class="card-title mb-0">Product Tag</h4></div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <!-- <label for="name" class="form-label fw-bold">Product Tag :</label> -->
                                                                <select class="form-control select2 select2-multiple-tag" name="tag[]" multiple="multiple" data-placeholder="Add Tags..." >
                                                                    <option value="Tag 1">Tag 1</option>
                                                                    <option value="Tag 2">Tag 2</option>
                                                                    <option value="Tag 3">Tag 3</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- <div class="card-footer"></div> -->
                                            </div> --}}



                                             <div class="card">
                                                <div class="card-header"><h4 class="card-title mb-0">Product Tag</h4></div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <!-- <label for="name" class="form-label fw-bold">Product Tag :</label> -->
                                                                <select class="form-control select2 select2-multiple-tag" name="tag[]" multiple="multiple" data-placeholder="Add Tags..." >

                                                                        <option value="">Select</option>

                                                                        {{-- @foreach($tags as $tag)
                                                                        <option value="{{$tag->tag}}" --}}
                                                                            {{-- @foreach($product->tags as $prodTag)
                                                                                @if($prodTag->tag == $attribute->id)
                                                                                    selected
                                                                                @endif
                                                                            @endforeach    --}}
                                                                        {{-- >{{$tag->tag}}</option> --}}

                                                                        {{-- @foreach($product as $productss)
                                                                       <option
                                                                        value="{{$tags->tag}}"
                                                                        @foreach($tags->tag as $prodCat)
                                                                            @if($prodCat->product_id == $product->id)
                                                                                selected
                                                                            @endif
                                                                        @endforeach
                                                                        >
                                                                        {{$tag->tag}} --}}

                                                                        <option value="">Select</option>
                                                                        @foreach($tags as $tag)
                                                                            {{-- @if(!empty($product->brand)) --}}
                                                                            <option value="{{$tag->tag}}" {{ $tag->product_id == $product->id ? 'selected' : '' }}>{{$tag->tag}}</option>
                                                                            {{-- @else --}}
                                                                            {{-- <option value="{{$brand->id}}">{{$brand->name}}</option>
                                                                            @endif --}}
                                                                        @endforeach


                                                                        {{-- <option value="{{$slot->id}}" {{ $slot->id == $deliveryoption->time_slot_inside ? "selected" : "" }}>{{$slot->from}}-{{$slot->to}}</option> --}}
                                                                        {{-- @endforeach --}}


                                                                    {{-- <option value="Tag 1">Tag 1</option>
                                                                    <option value="Tag 2">Tag 2</option>
                                                                    <option value="Tag 3">Tag 3</option> --}}
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- <div class="card-footer"></div> -->
                                            </div>

                                        </div>
                                        <div class="col-lg-4">

                                            <!-- [ Advance Configuration ] Start -->
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title mb-0">Advance Configuration</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">

                                                        {{-- <div class="col-lg-12">
                                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                                <label for="name" class="form-label fw-bold">Published :</label>
                                                                <div class="square-switch">
                                                                    <input type="checkbox" id="square-switch1" switch="status" checked/>
                                                                    <label for="square-switch1" data-on-label="Yes"
                                                                        data-off-label="No"></label>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                        <div class="col-lg-12">
                                                            {{-- <div class="form-group d-flex justify-content-between align-items-center">
                                                                <label for="name" class="form-label fw-bold">Published :</label>
                                                                <div class="square-switch">
                                                                    <input type="checkbox" id="square-switch1" name="published" switch="status" checked/>
                                                                    <label for="square-switch1" data-on-label="Yes"
                                                                        data-off-label="No"></label>
                                                                </div>
                                                                @error('published')
                                                                    <div class="text-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div> --}}
                                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                                <label for="name" class="form-label fw-bold">Published <sup class="text-danger fs-5">*</sup> :</label>
                                                                <div class="square-switch">
                                                                    <input type="checkbox" id="square-switch1" name="published" switch="status" {{ $product->published == 1 ? "checked" : "" }} />
                                                                    <label for="square-switch1" data-on-label="Yes"
                                                                        data-off-label="No"></label>
                                                                </div>
                                                                @error('published')
                                                                    <div class="text-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        {{-- <div class="col-lg-12">
                                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                                <label for="name" class="form-label fw-bold">Featured :</label>
                                                                <div class="square-switch">
                                                                    <input type="checkbox" id="square-switch2" switch="status" />
                                                                    <label for="square-switch2" data-on-label="Yes"
                                                                        data-off-label="No"></label>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                        <div class="col-lg-12">
                                                            {{-- <div class="form-group d-flex justify-content-between align-items-center">
                                                                <label for="name" class="form-label fw-bold">Featured :</label>
                                                                <div class="square-switch">
                                                                    <input type="checkbox" id="square-switch2" name="featured" switch="status" />
                                                                    <label for="square-switch2" data-on-label="Yes"
                                                                        data-off-label="No"></label>
                                                                </div>
                                                                @error('featured')
                                                                    <div class="text-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div> --}}
                                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                                <label for="name" class="form-label fw-bold">Featured :</label>
                                                                <div class="square-switch">
                                                                    <input type="checkbox" id="square-switch2" name="featured" switch="status" {{ $product->featured == 1 ? "checked" : "" }} />
                                                                    <label for="square-switch2" data-on-label="Yes"
                                                                        data-off-label="No"></label>
                                                                </div>
                                                                @error('featured')
                                                                    <div class="text-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        {{-- <div class="col-lg-12">
                                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                                <label for="name" class="form-label fw-bold">In Stock :</label>
                                                                <div class="square-switch">
                                                                    <input type="checkbox" id="square-switch3" switch="status" checked/>
                                                                    <label for="square-switch3" data-on-label="Yes"
                                                                        data-off-label="No"></label>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                        <div class="col-lg-12">
                                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                                <label for="name" class="form-label fw-bold">In Stock :</label>
                                                                <div class="square-switch">
                                                                    <input type="checkbox" id="square-switch3" name="in_stock" switch="status" {{ $product->in_stock == 1 ? "checked" : "" }} />
                                                                    <label for="square-switch3" data-on-label="Yes"
                                                                        data-off-label="No"></label>
                                                                </div>
                                                                @error('in_stock')
                                                                    <div class="text-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        {{-- <div class="col-lg-12">
                                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                                <label for="name" class="form-label fw-bold">Make it Addon :</label>
                                                                <div class="square-switch">
                                                                    <input type="checkbox" id="square-switch8" switch="status" />
                                                                    <label for="square-switch8" data-on-label="Yes"
                                                                        data-off-label="No"></label>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                        <div class="col-lg-12">
                                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                                <label for="name" class="form-label fw-bold">Make it Addon :</label>
                                                                <div class="square-switch">
                                                                    <input type="checkbox" id="square-switch4" name="addon" switch="status" {{ $product->addon == 1 ? "checked" : "" }} />
                                                                    <label for="square-switch4" data-on-label="Yes"
                                                                        data-off-label="No"></label>
                                                                </div>
                                                                @error('addon')
                                                                    <div class="text-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                                <label for="name" class="form-label fw-bold">Eggless :</label>
                                                                <div class="square-switch">
                                                                    <input type="checkbox" id="square-switch5" name="eggless" switch="status" {{ $product->eggless == 1 ? "checked" : "" }} />
                                                                    <label for="square-switch5" data-on-label="Yes"
                                                                        data-off-label="No"></label>
                                                                </div>
                                                                @error('eggless')
                                                                    <div class="text-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        {{-- <div class="col-lg-12">
                                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                                <label for="name" class="form-label fw-bold">Is this a Photo Cake? :</label>
                                                                <div class="square-switch">
                                                                    <input type="checkbox" id="square-switch5" switch="status" />
                                                                    <label for="square-switch5" data-on-label="Yes"
                                                                        data-off-label="No"></label>
                                                                </div>
                                                            </div>
                                                        </div> --}}

                                                        <div class="col-lg-12">
                                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                                <label for="name" class="form-label fw-bold">Is this a Photo Cake? :</label>
                                                                <div class="square-switch">
                                                                    <input type="checkbox" id="square-switch6" name="photo_cake" switch="status" {{ $product->photo_cake == 1 ? "checked" : "" }} />
                                                                    <label for="square-switch6" data-on-label="Yes"
                                                                        data-off-label="No"></label>
                                                                </div>
                                                                @error('photo_cake')
                                                                    <div class="text-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        {{-- <div class="col-lg-12">
                                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                                <label for="name" class="form-label fw-bold">Message on Cake :</label>
                                                                <div class="square-switch">
                                                                    <input type="checkbox" id="square-switch6" switch="status" />
                                                                    <label for="square-switch6" data-on-label="Yes"
                                                                        data-off-label="No"></label>
                                                                </div>
                                                            </div>
                                                        </div> --}}

                                                        <div class="col-lg-12">
                                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                                <label for="name" class="form-label fw-bold">Message on Cake :</label>
                                                                <div class="square-switch">
                                                                    <input type="checkbox" id="square-switch7" name="message" switch="status" {{ $product->message == 1 ? "checked" : "" }} />
                                                                    <label for="square-switch7" data-on-label="Yes"
                                                                        data-off-label="No"></label>
                                                                </div>
                                                                @error('message')
                                                                    <div class="text-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>


                                                        <div class="col-lg-12">
                                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                                <label for="cake_flavour" class="form-label fw-bold">Cake Flavour :</label>
                                                                <div class="square-switch">
                                                                    <input type="checkbox" id="square-switch9" name="cake_flavour" switch="status" {{ $product->cake_flavour == 1 ? "checked" : "" }} />
                                                                    <label for="square-switch9" data-on-label="Yes"
                                                                        data-off-label="No"></label>
                                                                </div>
                                                                @error('cake_flavour')
                                                                    <div class="text-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>


                                                        {{-- <div class="col-lg-12">
                                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                                <label for="name" class="form-label fw-bold">Heart Shape :</label>
                                                                <div class="square-switch">
                                                                    <input type="checkbox" id="square-switch7" switch="status" />
                                                                    <label for="square-switch7" data-on-label="Yes"
                                                                        data-off-label="No"></label>
                                                                </div>
                                                            </div>
                                                        </div> --}}

                                                        <div class="col-lg-12">
                                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                                <label for="name" class="form-label fw-bold">Heart Shape :</label>
                                                                <div class="square-switch">
                                                                    <input type="checkbox" id="square-switch8" name="heart_shape" switch="status" {{ $product->heart_shape == 1 ? "checked" : "" }} />
                                                                    <label for="square-switch8" data-on-label="Yes"
                                                                        data-off-label="No"></label>
                                                                </div>
                                                                @error('heart_shape')
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

                                            <!-- [ Product Images ] Start -->
                                            {{-- <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title mb-0">Product Thumbnail Image</h4>
                                                </div>
                                                <div class="card-body">

                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <input type="file" id="input-file-now" class="dropify" />
                                                                <small class="text-muted"><b>Example::</b> image size - 1000x1000.</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div> --}}
                                            {{-- <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title mb-0">Product Thumbnail Image</h4>
                                                </div>
                                                <div class="card-body">

                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <input type="file" id="input-file-now" name="image" class="dropify @error('image') is-invalid @enderror" />
                                                                <small class="text-muted"><b>Example::</b> image size - 1000x1000.</small>
                                                            </div>
                                                            @error('image')
                                                                <div class="text-danger">
                                                                    <strong>{{ $message }}</strong>
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>
                                            </div> --}}
                                            <!-- [ Product Images ] Start -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0">Product Thumbnail Image</h4>
                                        </div>
                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <input type="file" id="input-file-now" name="image" class="dropify @error('image') is-invalid @enderror" data-default-file="{{asset('storage/product/'.$product->image)}}"/>
                                                        <input type="hidden" name="hidden_image" value="{{ $product->image }}">
                                                        <small class="text-muted"><b>Example::</b> image size - 1000x1000.</small>
                                                    </div>
                                                    @error('image')
                                                        <div class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="tab-pane" id="data" role="tabpanel"> </div> -->
                                {{-- <div class="tab-pane" id="price" role="tabpanel">

                                    <!-- [ Product Price ] Start -->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12">

                                                    <table class="table table-bordered w-100 table-striped table-sm mb-3">
                                                        <thead>
                                                            <tr>
                                                                <th>Quantity Type</th>
                                                                <th>Quantity</th>
                                                                <th>Regular Price</th>
                                                                <th>Discount Type</th>
                                                                <th>Discount Value</th>
                                                                <th>Final/Sale Price</th>
                                                                <th class="col-1">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(@$product->getprice[0]->id)
                                                            @foreach($product->getprice as $key=>$idval)
                                                            <tr class="order-multiple">
                                                                <td>
                                                                    <select name="qty_type[]" class="form-control">
                                                                        <option value="">Select Qty</option>
                                                                        <option value="gram">Gram (G)</option>
                                                                        <option value="kg">Kilo Gram (KG)</option>
                                                                        <option value="litter">Liter (L)</option>
                                                                        <option value="ml">Milli Liter (ML)</option>
                                                                        <option value="piece">Piece (P)</option>
                                                                    </select>
                                                                    <div class="valid-feedback">Looks good!</div>
                                                                    <div class="invalid-feedback">This field is required. </div>
                                                                </td>

                                                                <td>
                                                                    <input type="text" name="qty[]" value="0" class="form-control" Placeholder="Eg: 100, 200, 500..." />
                                                                    <div class="valid-feedback">Looks good!</div>
                                                                    <div class="invalid-feedback">This field is required. </div>
                                                                </td>

                                                                <td>
                                                                    <input type="text" name="product_price[]" class="form-control" Placeholder="Eg: 100, 200, 500..." />
                                                                    <div class="valid-feedback">Looks good!</div>
                                                                    <div class="invalid-feedback">This field is required. </div>
                                                                </td>

                                                                <td>
                                                                    <select name="discount_type[]" class="form-control">
                                                                        <option value="">N/A</option>
                                                                        <option value="Flat">Flat Rate (Rs)</option>
                                                                        <option value="Percentage">Percentage (%)</option>
                                                                    </select>
                                                                    <div class="valid-feedback">Looks good!</div>
                                                                    <div class="invalid-feedback">This field is required. </div>
                                                                </td>

                                                                <td>
                                                                    <input type="text" name="discount_value[]" class="form-control" Placeholder="Eg: 100, 200, 500..." />
                                                                    <div class="valid-feedback">Looks good!</div>
                                                                    <div class="invalid-feedback">This field is required. </div>
                                                                </td>

                                                                <td>
                                                                    <input type="text" name="final_price[]" class="form-control"  readonly/>
                                                                    <div class="valid-feedback">Looks good!</div>
                                                                    <div class="invalid-feedback">This field is required. </div>
                                                                </td>

                                                                <td><button type="button" class="btn has-ripple btn-success btn-add"><i class="bx bx-plus"></i></button></td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="card-footer"></div> -->
                                    </div>
                                </div> --}}
                                {{-- <div class="tab-pane fade" id="price" role="tabpanel" aria-labelledby="price-tab"> --}}
                                  <div class="tab-pane fade" id="data" role="tabpanel" aria-labelledby="price-tab">
                                     <!-- [ Product Variation ] Start -->
                                     {{-- <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0">Product Variation</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Select Multiple Attributes:</label>
                                                        <div class="input-group">
                                                            <div class="input-group-text">Attributes</div>
                                                            <select id="choice_attributes" name="attributes[]" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose Attributes...">
                                                                @foreach($attributes as $attribute)
                                                                <option
                                                                    value="{{$attribute->id}}"
                                                                    @foreach($product->attributes as $prodAttr)
                                                                        @if($prodAttr->attribute_id == $attribute->id)
                                                                            selected
                                                                        @endif
                                                                    @endforeach
                                                                    >
                                                                    {{$attribute->name}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            <div class="valid-feedback">Looks good!</div>
                                                            <div class="invalid-feedback">This field is required. </div>
                                                        </div>
                                                        <small class="text-muted"><b>Note::</b> Choose the attributes of this product and then input values of each attribute. </small>
                                                    </div>
                                                </div>

                                                <!-- <div class="row customer_choice_options" id="customer_choice_options"></div> -->

                                                <div class="row customer_choice_options">
                                                    @foreach($attributes as $attribute)
                                                    <div class="col-lg-12 attributeScript-hide" id="attributeScript-{{$attribute->id}}" {{checkEditAttributeValues($attribute, $product)}}>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <div class="input-group-text">{{$attribute->name}}</div>
                                                                <select class="select2 form-control select2-multiple attributeValues" multiple="multiple" data-placeholder="Choose Values..." name="attributeValues[{{$attribute->id}}][]">
                                                                    @foreach($attribute->attributeValues as $value)
                                                                    <option
                                                                        value="{{$value->id}}"
                                                                        @foreach($product->attributes as $prodAttr)
                                                                            @if($prodAttr->attribute_values_id == $value->id)
                                                                                selected
                                                                            @endif
                                                                        @endforeach
                                                                        >
                                                                        {{$value->name}}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                        <div class="tab-pane" id="price" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                    {{-- <table class="table table-striped table-sm mb-3" width="100%"> --}}
                                        <table class="table table-bordered w-100 table-striped table-sm mb-3">
                                        <thead>
                                            <tr>
                                                <th>Qty Type</th>
                                                <th>Qty Weight</th>
                                                <th>Regular Price</th>
                                                <th>Discount Type</th>
                                                <th>Discount Value</th>
                                                <th>Final/Sale Price</th>
                                                <th class="col-1">Action</th>
                                            </tr>
                                        </thead>
                                            @if(@$product->getprice[0]->id)
                                        @foreach($product->getprice as $key=>$idval)
                                            <tr class="order-multiple">

                                                <td>
                                                    <select name="qty_type[]" class="form-control">
                                                        <!-- <option value="">Select Quantity</option>   -->
                                                        <option value="gram" @if($idval->qty_type=='gram') selected @endif>Gram (G)</option>
                                                        <option value="kg" @if($idval->qty_type=='kg') selected @endif>Kilo Gram (KG)</option>
                                                        <option value="liter" @if($idval->qty_type=='liter') selected @endif>Liter (L)</option>
                                                        <option value="ml" @if($idval->qty_type=='ml') selected @endif>ML</option>
                                                        <option value="piece" @if($idval->qty_type=='piece') selected @endif>Piece (P)</option>

                                                        {{-- <option value="CAP" @if($idval->qty_type=='CAP') selected @endif>CAP</option> --}}
                                                    </select>
                                                </td>

                                                <td><input type="text" name="qty_weight[]" value="{{ $idval->qty_weight}}" class="form-control" Placeholder="Eg: 100, 200, 500..." /></td>



                                                <td><input type="text" name="product_price[]" value="{{ $idval->product_price}}" class="form-control" Placeholder="Eg: 100, 200, 500..." /></td>

                                                <td>
                                                    <select name="discount_type[]" class="form-control">
                                                        <option value="">N/A</option>
                                                        <option value="Flat" @if($idval->discount_type=='Flat') selected @endif>Flat Rate (Rs)</option>
                                                        <option value="Percentage" @if($idval->discount_type=='Percentage') selected @endif>Percentage (%)</option>
                                                    </select>
                                                </td>

                                                <td><input type="text" name="discount_value[]" value="{{ $idval->discount_value}}" class="form-control" Placeholder="Eg: 100, 200, 500..." /></td>

                                                <td><input type="text" name="final_price[]" value="{{ $idval->final_price}}" class="form-control"  readonly/></td>

                                                <td class="d-none1">
                                                @if($loop->last)
                                                <button type="button" class="btn has-ripple btn-success btn-add"><i class="bx bx-plus"></i></button>
                                                @else
                                                <but-ton type="button" class="btn has-ripple btn-success btn-danger btn-remove"><i class="bx bx-minus"></i></button>
                                            @endif
                                            </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr class="order-multiple">
                                                <td class="d-none">
                                                    <select name="qty_type[]" class="form-control form-control-sm">
                                                        <option value="">Select Quantity</option>
                                                        <option value="Gram">Gram (G)</option>
                                                        <option value="Kilo Gram">Kilo Gram (KG)</option>
                                                        <option value="Litter">Litter (L)</option>
                                                        <option value="Piece">Piece (P)</option>
                                                        <option value="ML">ML</option>
                                                        <option value="CAP">CAP</option>
                                                    </select>
                                                </td>
                                                <td class="d-none"><input type="text" name="qty[]" class="form-control form-control-sm" Placeholder="Eg: 100, 200, 500..." /></td>
                                                <td class="d-none"><input type="text" name="business_value[]" class="form-control form-control-sm" Placeholder="Eg: 1, 10, 20, 30, 50..." /></td>
                                                <td> <input type="text" name="product_price[]" class="form-control form-control-sm" Placeholder="Eg: 100, 200, 500..." /></td>
                                                <td>
                                                    <select name="discount_type[]" class="form-control form-control-sm">
                                                        <option value="">Discount Type</option>
                                                        <option value="Flat">Flat Rate (Rs)</option>
                                                        <option value="Percentage">Percentage (%)</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="discount_value[]" class="form-control form-control-sm" Placeholder="Eg: 100, 200, 500..." /></td>
                                                <td class="d-none"><input type="text" name="final_price[]" class="form-control form-control-sm"  readonly/></td>
                                                <td class="d-none"><button type="button" class="btn has-ripple btn-success btn-add"><i class="feather icon-plus"></i></button></td>
                                            </tr>

                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                                </div>


                                <div class="tab-pane" id="seo" role="tabpanel">
                                    <!-- [ SEO Meta Tags ] Start -->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">

                                                {{-- <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="name" class="form-label">Meta Title:</label>
                                                        <input type="text" id="name" class="form-control" placeholder="Enter Your Full Name" />
                                                        <div class="valid-feedback">Looks good!</div>
                                                        <div class="invalid-feedback">This field is required. </div>
                                                    </div>
                                                </div> --}}
                                                <div class="col-lg-12">
                                                    {{-- <div class="form-group">
                                                        <label for="name" class="form-label">Meta Title:</label>
                                                        <input type="text" id="name" name="meta_title" value="{{old('meta_title')}}" class="form-control @error('meta_title') is-invalid @enderror" placeholder="Enter Your Full Name"/>
                                                        <div class="valid-feedback">Looks good!</div>
                                                        <div class="invalid-feedback">This field is required. </div>
                                                        @error('meta_title')
                                                            <div class="text-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror
                                                    </div> --}}
                                                    <div class="form-group">
                                                        <label for="name" class="form-label">Meta Title:</label>
                                                        <input type="text" id="name" name="meta_title" value="{{$product->meta_title}}" class="form-control @error('meta_title') is-invalid @enderror" placeholder="Enter Your Full Name"/>
                                                        <div class="valid-feedback">Looks good!</div>
                                                        <div class="invalid-feedback">This field is required. </div>
                                                        @error('meta_title')
                                                            <div class="text-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="description" class="form-label">Meta Keywords:</label>
                                                        <textarea name="" id="description" class="form-control" placeholder="Write somthing..."></textarea>
                                                        <div class="valid-feedback">Looks good!</div>
                                                        <div class="invalid-feedback">This field is required. </div>
                                                    </div>
                                                </div> --}}
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="description" class="form-label">Meta Keywords:</label>
                                                        <textarea name="meta_keywords" id="description" class="form-control @error('meta_keywords') is-invalid @enderror" placeholder="Write somthing...">{{$product->meta_keywords}}</textarea>
                                                        <div class="valid-feedback">Looks good!</div>
                                                        <div class="invalid-feedback">This field is required. </div>
                                                        @error('meta_keywords')
                                                            <div class="text-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="description" class="form-label">Meta Description:</label>
                                                        <textarea name="" id="description" class="form-control" placeholder="Write somthing..."></textarea>
                                                            <div class="valid-feedback">Looks good!</div>
                                                            <div class="invalid-feedback">This field is required. </div>
                                                    </div>
                                                </div> --}}
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="meta_description" class="form-label">Meta Description:</label>
                                                        <textarea id="meta_description" name="meta_description" class="form-control @error('meta_description') is-invalid @enderror" placeholder="Write somthing...">{{$product->meta_description}}</textarea>
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

                                </div>
                                <!-- <div class="tab-pane" id="policy" role="tabpanel"> </div> -->
                                <div class="tab-pane" id="images" role="tabpanel">

                                    {{-- <!-- [ Product Images Gallery ] Start -->
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    {{-- <div class="form-group">
                                                        <label class="form-label fw-bold">Images Gallery:</label>
                                                        <input type="file" id="input-file-now" class="dropify" multiple/>
                                                        <small class="text-muted"><b>Example::</b> image size - 1000x1000.</small>
                                                    </div> --}}
                                                    {{-- <div class="form-group">
                                                        <label class="form-label fw-bold">Images Gallery:</label>
                                                        <input type="file" name="gallery[]" id="input-file-now" class="dropify" multiple/>
                                                        <small class="text-muted"><b>Example::</b> image size - 1000x1000.</small>
                                                        @error('img')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                @enderror
                                                    </div>
                                                </div>
                                            </div> --}}

                                            {{-- <div class="row row-cols-2 row-cols-lg-4 mt-3">
                                                <div class="col">
                                                    <div class="document-box border text-center">
                                                        <div class="remove-doc">
                                                            <a href="#"><i class="fas fa-times"></i></a>
                                                        </div>
                                                        <a class="image-popup-no-margins" href="../assets/admin/images/small/img-1.jpg" title="Document 1">
                                                            <img class="img-fluid" src="../assets/admin/images/small/img-1.jpg">
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="col">
                                                    <div class="document-box border text-center">
                                                        <div class="remove-doc">
                                                            <a href="#"><i class="fas fa-times"></i></a>
                                                        </div>
                                                        <a class="image-popup-no-margins" href="../assets/admin/images/small/img-2.jpg" title="Document 1">
                                                            <img class="img-fluid" src="../assets/admin/images/small/img-2.jpg">
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="col">
                                                    <div class="document-box border text-center">
                                                        <div class="remove-doc">
                                                            <a href="#"><i class="fas fa-times"></i></a>
                                                        </div>
                                                        <a class="image-popup-no-margins" href="../assets/admin/images/small/img-3.jpg" title="Document 1">
                                                            <img class="img-fluid" src="../assets/admin/images/small/img-3.jpg">
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="col">
                                                    <div class="document-box border text-center">
                                                        <div class="remove-doc">
                                                            <a href="#"><i class="fas fa-times"></i></a>
                                                        </div>
                                                        <a class="image-popup-no-margins" href="../assets/admin/images/small/img-4.jpg" title="Document 1">
                                                            <img class="img-fluid" src="../assets/admin/images/small/img-4.jpg">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div> --}}

                                        {{-- </div>
                                    </div> --}}

                                    <!-- [ Product Images Gallery ] Start -->
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Product Images Gallery</h4>
                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">Images Gallery:</label>
                                                <input type="file" name="gallery[]" id="input-file-now" class="dropify" multiple/>
                                                <small class="text-muted"><b>Example::</b> image size - 1000x1000.</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row row-cols-2 row-cols-lg-4 mt-3">
                                        @foreach($product->gallery as $index => $gallery)
                                        <div class="col">
                                            <div class="document-box border text-center" id="image{{$index}}">
                                                <div class="remove-doc">
                                                    <div class="removeImage{{$index}} pointer"><i class="fas fa-times"></i></div>
                                                </div>
                                                <img class="img-fluid" src="{{asset('storage/product/'.$gallery->image)}}">
                                                <input type="hidden" name="gallery_images[]" value="{{$gallery->image}}">
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-end">
                            <button type="reset" class="btn btn-warning waves-effect waves-light">Clear</button>
                            <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <div class="row">
            <div class="col-xl-12">

                <form class="custom-form needs-validation" method="post" action="{{ route('admin.product.update',$product->id) }}" enctype="multipart/form-data" novalidate>
                    @method('PATCH')
                    @csrf
                    <div class="row">
                        <div class="col-lg-8">

                        </div>

                        <div class="col-lg-4">

                        </div>

                        <div class="col-lg-12">


                        </div>
                    </div>
                </form>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
    <!-- container-fluid -->
</div>
@endsection

@section('script')
{{-- <script src="{{asset('assets/admin/js/pages/form-advanced.init.js')}}"></script> --}}

<script>
    $(".select2-multiple-tag").select2({
        tags: true,
        tokenSeparators: [',', ' ']
    })

    $(function () {

        var addFormGroup = function (event) {
            event.preventDefault();

            var $formGroup = $(this).closest('.order-multiple');
            var $multipleFormGroup = $formGroup.closest('.multiple-form-group');
            var $formGroupClone = $formGroup.clone();

            $(this)
                .toggleClass('btn-add btn-danger btn-remove')
                .html('<i class="bx bx-minus"></i>');

            $formGroupClone.find('input').val('');
            $formGroupClone.insertAfter($formGroup);

            var $lastFormGroupLast = $multipleFormGroup.find('.order-multiple:last');
            if ($multipleFormGroup.data('max') <= countFormGroup($multipleFormGroup)) {
                $lastFormGroupLast.find('.btn-add').attr('disabled', true);
            }
        };

        var removeFormGroup = function (event) {
            event.preventDefault();

            var $formGroup = $(this).closest('.order-multiple');
            var $multipleFormGroup = $formGroup.closest('.multiple-form-group');

            var $lastFormGroupLast = $multipleFormGroup.find('.order-multiple:last');
            if ($multipleFormGroup.data('max') >= countFormGroup($multipleFormGroup)) {
                $lastFormGroupLast.find('.btn-add').attr('disabled', false);
            }

            $formGroup.remove();
        };

        var countFormGroup = function ($form) {
            return $form.find('.form-group').length;
        };

        $(document).on('click', '.btn-add', addFormGroup);
        $(document).on('click', '.btn-remove', removeFormGroup);

    });

</script>

@foreach($product->gallery as $index => $gallery)
<script>
    $(document).ready(function(){
        $(".removeImage{{$index}}").click(function(){
            $("#image{{$index}}").remove();
        });
    });
</script>
@endforeach


@endsection
