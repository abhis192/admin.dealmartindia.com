@extends('layouts.backend.app')

@section('title')
<title>Add Attribute value | {{Auth::user()->role->name}}</title>
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
                    <h4 class="mb-sm-0 font-size-18">Attribute Values</h4>

                    <div class="page-title-right">
                        <!-- <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">Attributes</li>
                        </ol> -->
                        <a href="{{route('admin.product-attribute')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-reply-all"></i> Back to list</a>
                    </div>

                </div>
            </div>
        </div> 
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-4"> 
                <div class="card border">
                    <form class="custom-form needs-validation" method="post" action="{{ route('admin.product-attribute-value.store', $attribute->id) }}" enctype="multipart/form-data" novalidate>
                    	@csrf
                        <div class="card-header"> 
                            <h4 class="card-title mb-0">Add New Attribute Value</h4>  
                        </div>
                        <div class="card-body">  
                            <div class="row"> 
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Attribute Name:</label>
                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Your Name" value="{{ old('name') }}" required/>
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
                                                <label for="name" class="form-label">Value Name <sup class="text-danger fs-5">*</sup> :</label>
                                                @if($attribute->type == "color")
                                                    <input type="text" name="value" class="form-control @error('value') is-invalid @enderror" placeholder="Enter Value" id="colorpicker-showinput-intial"/>
                                                @elseif($attribute->type == "text")
                                                    <input type="text" name="value" id="name" class="form-control @error('value') is-invalid @enderror" placeholder="Value Name"/>
                                                @elseif($attribute->type == "image")
                                                    <input name="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value') }}" type="file" id="formFile">
                                                @endif
                                                
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                
                                                @error('value')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Value Image <sup class="text-danger fs-5">*</sup> :</label>
                                                <input class="form-control" type="file" id="formFile">
                                            </div>
                                        </div>  -->

                                    </div> 
                                </div>
                            </div> 
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
                        </div> 
                    </form>
                </div>
                <!-- end card --> 
            </div> <!-- end col -->

            <div class="col-xl-8">
                <div class="card border"> 
                    <div class="card-body"> 

                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="col-1">#</th> 
                                    <th>Value Name</th> 
                                    <th>Value Image/Color</th> 
                                    <th class="col-1">Action</th>
                                </tr>
                            </thead>


                            <tbody>
                            	@foreach($attribute->attributeValues as $key => $attribute)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$attribute->name}}</td>  
                                    <td>
                                        @if($attribute->attribute->type == "color")
                                        <span class="badge rounded-circle" style="background:{{$attribute->value}};">&nbsp;&nbsp;&nbsp;</span>
                                        @elseif($attribute->attribute->type == "text")
                                        <span class="badge bg-primary">{{$attribute->value}}</span>
                                        @elseif($attribute->attribute->type == "image")
                                        <img class="rounded avatar-xs me-1" src="{{asset('storage/attribute/'.$attribute->value)}}" alt="{{$attribute->name}}">
                                        @endif
                                    </td>
                                    <td class="text-center">   
                                        <a href="{{route('admin.product-attribute.showEdit', $attribute->id)}}" class="btn btn-soft-info btn-sm waves-effect waves-light" title="Edit Attribute"><i class="bx bx-pencil font-size-16"></i></a>

                                        <a href="javascript:void(0);" class="btn btn-soft-danger btn-sm waves-effect waves-light sa-delete" title="Delete Attribute" data-id="{{ $attribute->id }}" data-link="/admin/product/attribute/show/destroy/"><i class="bx bx-trash font-size-16"></i></a>
                                    </td>
                                </tr> 
                                @endforeach
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div> <!-- end col -->

        </div> <!-- end row -->  
        
    </div>
    <!-- container-fluid -->
</div> 
@endsection