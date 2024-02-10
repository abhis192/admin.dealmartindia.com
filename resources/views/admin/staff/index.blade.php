@extends('layouts.backend.app')

@section('title')
<title>All Staff | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">All Staff</h4>

                    <div class="page-title-right">
                        <a href="{{route('admin.staff.create')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-plus"></i> Add New Staff</a>
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
                                    <th>Name/Email Id</th>
                                    <th>Role</th>
                                    <th class="col-1">Published</th>
                                    <th class="col-1">Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach($users as $key => $user)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>
                                        <p class="m-0"><b>{{$user->name}}</b></p>
                                        <p class="m-0">{{$user->email}}</p>
                                    </td>
                                    <td>{{$user->role->name}}</td>
                                     {{-- <td>
                                        <div class="square-switch">
                                            <input type="checkbox" id="square-switch{{$key}}" switch="status" {{ $user->email_verified_at != null ? 'checked' : '' }}>
                                            <label for="square-switch{{$key}}" data-on-label="Yes" data-off-label="No"></label>
                                        </div>
                                    </td> --}}
                                    <td class="text-center">
                                        @if($user->email_verified_at == null)
                                         <a href="{{ route('admin.user.activate', $user->id) }}" class="btn btn-danger btn-sm waves-effect waves-light"><i class="bx bxs-user-check font-size-18"></i></a>
                                        @else
                                        <a href="{{ route('admin.user.deactivate', $user->id) }}" class="btn btn-success btn-sm waves-effect waves-light"><i class="bx bxs-user-check font-size-18"></i></a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{route('admin.staff.edit',$user->id)}}" class="btn btn-soft-info btn-sm waves-effect waves-light"><i class="bx bx-pencil font-size-16"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-soft-danger btn-sm waves-effect waves-light sa-delete" title="Delete Customer" data-id="{{ $user->id }}" data-link="/admin/user/destroy/"><i class="bx bx-trash font-size-16"></i></a>
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
