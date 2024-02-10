@extends('layouts.backend.app')

@section('title')
<title>Product Type | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">Product Type</h4>
                    @if(Auth::user()->hasPermissionTo('type_add'))
                    <div class="page-title-right">
                        <a href="{{route('admin.cake-flavour.create')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-plus"></i> Add New Cake Flavour</a>
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
                                    <th class="col-1">Icon</th>
                                    <th>Cake Flavour Name</th>
                                    <th>Created At</th>
                                    <th class="col-1">Published</th>
                                    <th class="col-1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@if($flavours->count())
                            	@foreach($flavours as $key => $flavour)
                                <tr>
                                    <td><img class="rounded avatar-sm me-1" src="{{asset('storage/flavour/'.$flavour->icon)}}" alt="" /></td>
                                    <td class="text-wrap">{{$flavour->name}}</td>
                                    <td>{{date('d M Y | h:i A',strtotime($flavour->created_at))}}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.cake-flavour.toggle', $flavour->id) }}">
                                            @csrf
                                            <button type="submit" class="square-switch btn btn-toggle">
                                                <input type="checkbox" id="square-switch{{$key}}" switch="status" name="status" {{ $flavour->status == 1 ? "checked" : "" }} />
                                                <label for="square-switch{{$key}}" data-on-label="Yes" data-off-label="No"></label>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        @if(Auth::user()->hasPermissionTo('type_edit'))
                                        <a href="{{ route('admin.cake-flavour.edit', $flavour->id) }}" class="btn btn-soft-info btn-sm waves-effect waves-light"><i class="bx bx-pencil font-size-16"></i></a>
                                        @endif
                                        @if(Auth::user()->hasPermissionTo('type_delete'))
                                        <a href="javascript:void(0);" class="btn btn-soft-danger btn-sm waves-effect waves-light sa-delete" title="Delete Type" data-id="{{ $flavour->id }}" data-link="/admin/product/cake-flavour/destroy/"><i class="bx bx-trash font-size-16"></i></a>
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
