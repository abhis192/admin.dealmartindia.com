@extends('layouts.backend.app')

@section('title')
<title>Seller | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">All Kitchens</h4>

                    {{-- <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">All Sellers</li>
                        </ol>
                    </div> --}}

                    <div class="page-title-right">
                        <a href="{{route('admin.all-seller.create')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-plus"></i> Add New Kitchen</a>
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-12">
                <div class="card border">
                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="col-1">#</th>
                                    <th>Name/Kitchen</th>
                                    <th>Phone No./Email Id</th>
                                    {{-- <th>Phone No.</th> --}}
                                    <th>Registerd Date</th>
                                    <th class="col-1 text-center">Account Status</th>
                                    <th class="col-1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($sellers->count())
                                @foreach($sellers as $index => $seller)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td class="text-wrap">
                                        <p class="m-0">{{$seller->name}}</p>
                                        <p class="m-0"><b>[{{$seller->business}}]</b></p>
                                    </td>
                                    <td> <p class="m-0">{{$seller->mobile}}</p>
                                        <p class="m-0">[{{$seller->email}}]</p></td>
                                    {{-- <td>{{$seller->mobile}}</td> --}}
                                    <td>{{date('d M Y | h:i A',strtotime($seller->created_at))}}</td>
                                    <td class="text-center">
                                        @if($seller->seller_verified_at == null)
                                        <span class="badge badge-pill badge-soft-danger font-size-12 p-2 border w-md">Non Verified </span>
                                        @else
                                        <span class="badge badge-pill badge-soft-success font-size-12 p-2 border w-md">Verified</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical font-size-18"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a href="{{route('admin.all-seller.show', $seller->id)}}" class="dropdown-item"><i class="mdi mdi-account-box font-size-16 text-info me-1"></i> Profile</a></li>
                                                <li><a href="#" class="dropdown-item"><i class="bx bx-log-in-circle font-size-16 text-info me-1"></i> Log in as this Kitchen </a></li>
                                                <li><a href="#" class="dropdown-item"><i class="bx bx-shopping-bag font-size-16 text-warning me-1"></i> Order History</a></li>
                                                <li><a href="" class="dropdown-item"><i class="mdi mdi-clipboard-list font-size-16 text-default me-1"></i> Payment History</a></li>
                                                @if(Auth::user()->hasPermissionTo('seller_edit'))
                                                <li><a href="{{ route('admin.all-seller.edit', $seller->id) }}" class="dropdown-item"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit</a></li>
                                                @endif
                                                @if(Auth::user()->hasPermissionTo('seller_delete'))
                                                <li><a href="javascript:void(0);" class="dropdown-item sa-delete" data-id="{{ $seller->id }}" data-link="/admin/user/destroy/"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                                @endif
                                            </ul>
                                        </div>
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
