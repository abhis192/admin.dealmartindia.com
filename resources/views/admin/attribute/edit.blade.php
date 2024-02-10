@extends('layouts.backend.app')

@section('title')
<title>Attribute | {{Auth::user()->role->name}}</title>
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
                    <h4 class="mb-sm-0 font-size-18">Attributes</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">Attributes</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div> 
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-4"> 
                <div class="card border">
                    <form class="custom-form needs-validation" method="post" action="{{ route('admin.product-attribute.update', $attribute->id) }}" novalidate>
                    	@method('PATCH')
                        @csrf
                        <div class="card-header"> 
                            <h4 class="card-title mb-0">Add Attribute</h4>  
                        </div>
                        <div class="card-body">  
                            <div class="row"> 
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Attribute Name:</label>
                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Your Name" value="{{$attribute->name}}" required/>
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
                                                <label for="name" class="form-label">Attribute types:</label>
                                                <select class="form-control" name="type" required>
                                                    <option value="">Select</option> 
                                                    <option value="text" {{ $attribute->type == "text" ? "selected" : "" }}>Text</option>
                                                    <option value="image" {{ $attribute->type == "image" ? "selected" : "" }}>Image</option> 
                                                    <option value="color" {{ $attribute->type == "color" ? "selected" : "" }}>Color</option> 
                                                </select>                                                
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>

                                                @error('type')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="description" class="form-label">Description:</label>
                                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description">{{$attribute->description}}</textarea>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('description')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div> 

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Published:</label>
                                                <div class="square-switch">
                                                    <input type="checkbox" id="square-switch0" name="status" switch="status" {{ $attribute->status == 1 ? "checked" : "" }} />
                                                    <label for="square-switch0" data-on-label="Yes"
                                                        data-off-label="No"></label>
                                                </div>   
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div> 
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-info waves-effect waves-light">Update Changes</button>
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
                                    <th>Attribute Name</th> 
                                    <th>Type</th>
                                    <th>Values</th> 
                                    <th class="col-1">Published</th>
                                    <th class="col-1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@if($attributes->count())
                            	@foreach($attributes as $key => $attribute)
                                <tr>
                                    <td>{{$attribute->name}}</td>
                                    <td>{{$attribute->type}}</td> 
                                    <td>
                                    	@if($attribute->type == "color")
                                    		@if($attribute->attributeValues->count())
	                                        @foreach($attribute->attributeValues as $value)
	                                        <span class="badge rounded-circle" style="background:{{$value->value}};">&nbsp;&nbsp;</span>
	                                        @endforeach
	                                        @endif
                                        @elseif($attribute->type == "text")
                                        	@if($attribute->attributeValues->count())
                                        	@foreach($attribute->attributeValues as $value)
                                        	<span class="badge bg-primary">{{$value->value}}</span>
                                        	@endforeach
	                                        @endif
                                        @elseif($attribute->type == "image")
                                        	@if($attribute->attributeValues->count())
                                        	@foreach($attribute->attributeValues as $value)
                                        	<img class="rounded avatar-xs me-1" src="{{asset('storage/attribute/'.$value->value)}}" alt="{{$value->name}}">
                                        	@endforeach
		                                    @endif
                                        @endif
                                    </td>  
                                    <td class="text-center">
                                        <form method="POST" action="{{ route('admin.product-attribute.toggle', $attribute->id) }}">
                                            @csrf
                                            <button type="submit" class="square-switch btn btn-toggle">
                                                <input type="checkbox" id="square-switch{{$key+1}}" switch="status" name="status" {{ $attribute->status == 1 ? "checked" : "" }} />
                                                <label for="square-switch{{$key+1}}" data-on-label="Yes" data-off-label="No"></label>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center">  
                                        <a href="{{ route('admin.product-attribute.show', $attribute->id) }}" class="btn btn-soft-success btn-sm waves-effect waves-light" title="Add Attribute values"><i class="bx bx-cog font-size-16"></i></a>

                                        <a href="{{ route('admin.product-attribute.edit', $attribute->id) }}" class="btn btn-soft-info btn-sm waves-effect waves-light" title="Edit Attribute"><i class="bx bx-pencil font-size-16"></i></a> 

                                        <form method="POST" class="" action="{{ route('admin.product-attribute.destroy', $attribute->id) }}">
                                            @csrf
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button type="submit" class="btn btn-soft-danger btn-sm waves-effect waves-light show_confirm" data-toggle="tooltip" title='Delete'><i class="bx bx-trash font-size-16"></i></button>
                                        </form>
                                    </td>
                                </tr> 
                                @endforeach
                                @endif
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