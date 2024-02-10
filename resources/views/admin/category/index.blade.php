@extends('layouts.backend.app')

@section('title')
<title>Category | {{Auth::user()->role->name}}</title>
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
                    <h4 class="mb-sm-0 font-size-18">Product Category</h4>
                    @if(Auth::user()->hasPermissionTo('category_add'))
                    <div class="page-title-right">
                        <a href="{{route('admin.product-category.create')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-plus"></i> Add New Category</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card border">
                    <div class="card-body">

                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="col-1">#</th>
                                    <th class="col-1">Icon</th>
                                    <th class="col-2">Category Name:</th>
                                    <th>Parent Category:</th>
                                    <th>Product Types</th>
                                    <th class="col-1">Created At</th>
                                    <th class="col-1">Published</th>
                                    <th class="col-1">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if($categories->count())
                                @foreach($categories as $key => $category)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td><img class="rounded avatar-sm me-1" src="{{asset('storage/category/'.$category->image)}}" alt="" /></td>

                                    <td class="text-wrap">{{$category->name}}</td>
                                    <td>{{$category->parentCategory->name??null}}</td>
                                    <td>{{$category->type->name??null}}</td>
                                    <td>{{date('d M Y | h:i A',strtotime($category->created_at))}}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.product-category.toggle', $category->id) }}">
                                            @csrf
                                            <button type="submit" class="square-switch btn btn-toggle">
                                                <input type="checkbox" id="square-switch{{$key}}" switch="status" name="status" {{ $category->status == 1 ? "checked" : "" }} />
                                                <label for="square-switch{{$key}}" data-on-label="Yes" data-off-label="No"></label>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        @if(Auth::user()->hasPermissionTo('category_edit'))
                                        <a href="{{ route('admin.product-category.edit', $category->id) }}" class="btn btn-soft-info btn-sm waves-effect waves-light"><i class="bx bx-pencil font-size-16"></i></a>
                                        @endif
                                        @if(Auth::user()->hasPermissionTo('category_delete'))
                                        <a href="javascript:void(0);" class="btn btn-soft-danger btn-sm waves-effect waves-light sa-delete" title="Delete Category" data-id="{{ $category->id }}" data-link="/admin/product/category/destroy/"><i class="bx bx-trash font-size-16"></i></a>
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
