@extends('layouts.backend.app')

@section('title')
<title>All Staff Permissions | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">All Staff Permissions</h4>

                    <div class="page-title-right">
                        <a href="{{route('admin.staff-permission.create')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-plus"></i> Add New Staff Permissions</a>
                    </div>

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
                                    <th>Role Name</th>
                                    {{-- <th>Slug</th>    --}}
                                    <th class="col-1">Action</th>
                                </tr>
                            </thead>


                            <tbody>
                            	@foreach($roles as $key => $role)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$role->name}}</td>
                                    {{-- <td>{{$role->slug}}</td>  --}}
                                    <td class="text-center">
                                        <a href="{{route('admin.staff-permission.edit', $role->id)}}" class="btn btn-soft-info btn-sm waves-effect waves-light"><i class="bx bx-pencil font-size-16"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-soft-danger btn-sm waves-effect waves-light sa-delete" title="Delete Category" data-id="{{ $role->id }}" data-link="/admin/staff-permission/destroy/"><i class="bx bx-trash font-size-16"></i></a>
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
