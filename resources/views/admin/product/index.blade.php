@extends('layouts.backend.app')

@section('title')
<title>Products | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">All Products</h4>
                    @if(Auth::user()->hasPermissionTo('product_add'))
                    <div class="page-title-right">
                        <a href="{{route('admin.product.create')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-plus"></i> Add New Product</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-12">
                <div class="card border">
                    <div class="card-body">

                        <table
                        @if(Auth::user()->hasPermissionTo('product_add'))
                        id="datatable-buttons"
                        @else
                        id="datatable-buttons-2"
                        @endif
                        class="table table-bordered dt-responsive nowrap w-100"
                        >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Images</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    {{-- <th>Price</th> --}}
                                    <th class="col-1">Featured</th>
                                    <th class="col-1">Published</th>
                                    <th class="col-1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@if($products->count())
                            	@foreach($products as $key => $product)
                                <tr>
                                    <td>
                                        {{$key+1}}
                                    </td>
                                    <td class="text-wrap">
                                        <div class="d-flex align-items-start">
                                            <div class="product-image">
                                                <img class="rounded avatar-sm me-1" src="{{asset('storage/product/'.$product->image)}}" alt="" />
                                            </div>

                                            {{-- <div class="content m-0 p-0">
                                                <p class="m-0"><b>{{$product->name}}</b></p>
                                                <p class="m-0"><b>
                                                    @if($product->category)
                                                    [{{$product->category->name}}]
                                                    @endif
                                                    </b>
                                                </p>
                                            </div> --}}
                                        </div>
                                    </td>
                                    <td><div class="content m-0 p-0">
                                        <p class="m-0"><b>{{$product->name}}</b></p>
                                        {{-- <p class="m-0"><b>
                                            @if($product->category)
                                            [{{$product->category->name}}]
                                            @endif
                                            </b>
                                        </p> --}}
                                    </div></td>

                                    <td>
                                        {{-- <ul class="list-group">
                                            <!-- <li class="list-group-item border-0 p-0"><b>Num of Sale:</b> 1 times</li> -->
                                            <li class="list-group-item border-0 p-0 text-danger"><b>Regular price (<i class="bx bx-rupee"></i>):</b> {{$product->regular_price}}</li>
                                            @if($product->sale_price)
                                            <li class="list-group-item border-0 p-0 text-success"><b>Sale price (<i class="bx bx-rupee"></i>):</b> {{$product->sale_price}}</li>
                                            @endif
                                        </ul> --}}
                                        <p class="m-0"><b>
                                            @if($product->category)
                                            {{$product->category->name}}

                                            @endif
                                            </b>
                                        </p>
                                    </td>

                                    {{-- <td><ul class="list-group">
                                        <!-- <li class="list-group-item border-0 p-0"><b>Num of Sale:</b> 1 times</li> -->
                                        <li class="list-group-item border-0 p-0 text-danger"><b>Regular price (<i class="bx bx-rupee"></i>):</b> {{$product->regular_price}}</li>
                                        @if($product->sale_price)
                                        <li class="list-group-item border-0 p-0 text-success"><b>Sale price (<i class="bx bx-rupee"></i>):</b> {{$product->sale_price}}</li>
                                        @endif
                                    </ul></td> --}}
                                    {{-- <td>{{$product->user->name}}</td> --}}
                                    <td>
                                        <form method="POST" action="{{ route('admin.product.featuredToggle', $product->id) }}">
                                            @csrf
                                            <button type="submit" class="square-switch btn btn-toggle">
                                                <input type="checkbox" id="square-switch-feature{{$key}}" switch="bool" name="featured" {{ $product->featured == 1 ? "checked" : "" }} />
                                                <label for="square-switch-feature{{$key}}" data-on-label="Yes"
                                                    data-off-label="No"></label>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.product.publishedToggle', $product->id) }}">
                                            @csrf
                                            <button type="submit" class="square-switch btn btn-toggle">
                                                <input type="checkbox" id="square-switch-publish{{$key}}" name="published" switch="bool" {{ $product->published == 1 ? "checked" : "" }} />
                                                <label for="square-switch-publish{{$key}}" data-on-label="Yes"
                                                    data-off-label="No"></label>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        @if(Auth::user()->hasPermissionTo('product_edit'))
                                        <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-soft-info btn-sm waves-effect waves-light"><i class="bx bx-pencil font-size-16"></i></a>
                                        @endif
                                        @if(Auth::user()->hasPermissionTo('product_delete'))
                                        <a href="javascript:void(0);" class="btn btn-soft-danger btn-sm waves-effect waves-light sa-delete" title="Delete Product" data-id="{{ $product->id }}" data-link="/admin/product/destroy/"><i class="bx bx-trash font-size-16"></i></a>
                                        @endif
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

@section('script')
<!-- <script>
window.onload = function() {
    $('body').addClass("sidebar-enable vertical-collpsed");
};
</script> -->
@endsection
