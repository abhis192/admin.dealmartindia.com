@extends('layouts.backend.app')

@section('title')
<title>Customer | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">All Customers</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="">Home</a></li>
                            <li class="breadcrumb-item active">All Customers</li>
                        </ol>
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
                                    <th>Name</th>
                                    <th>Email Id</th>
                                    <th>Phone No.</th>
                                    <th>Registerd Date</th>
                                    <th class="col-1 text-center">User Verify</th>
                                    <th class="col-1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@if($customers->count())
                                @foreach($customers as $index => $customer)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$customer->name}}</td>
                                    <td>{{$customer->email}}</td>
                                    <td>{{$customer->mobile}}</td>
                                    <td>{{date('d M Y | h:i A',strtotime($customer->created_at))}}</td>
                                    <td class="text-center">
                                        @if($customer->email_verified_at == null)
                                        <a href="{{ route('admin.user.activate', $customer->id) }}" class="btn btn-danger btn-sm waves-effect waves-light"><i class="bx bxs-user-check font-size-18"></i></a>
                                        @else
                                        <a href="{{ route('admin.user.deactivate', $customer->id) }}" class="btn btn-success btn-sm waves-effect waves-light"><i class="bx bxs-user-check font-size-18"></i></a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical font-size-18"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                {{-- <li><a href="{{route('admin.all-seller.show', $seller->id)}}" class="dropdown-item"><i class="mdi mdi-account-box font-size-16 text-info me-1"></i> Profile</a></li> --}}
                                                {{-- <li><a href="" class="dropdown-item"><i class="mdi mdi-clipboard-list font-size-16 text-default me-1"></i> Payment History</a></li> --}}
                                                @if(Auth::user()->hasPermissionTo('customer_edit'))
                                                <li><a href="{{ route('admin.customer.edit', $customer->id) }}" class="dropdown-item"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit</a></li>
                                                @endif

                                                {{-- <li><a href="#" class="dropdown-item"><i class="bx bx-log-in-circle font-size-16 text-info me-1"></i> Log in as this Kitchen </a></li> --}}

                                                @if(Auth::user()->hasPermissionTo('customer_delete'))
                                                <li><a href="javascript:void(0);" class="dropdown-item sa-delete" data-id="{{ $customer->id }}" data-link="/admin/user/destroy/"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                                @endif
                                            </ul>
                                        </div>

                                        {{-- @if(Auth::user()->hasPermissionTo('customer_edit'))
                                        <a href="{{ route('admin.customer.edit', $customer->id) }}" class="btn btn-soft-info btn-sm waves-effect waves-light" title="Edit"><i class="bx bx-pencil font-size-16"></i></a>
                                        @endif
                                        @if(Auth::user()->hasPermissionTo('customer_delete'))
                                        <a href="javascript:void(0);" class="btn btn-soft-danger btn-sm waves-effect waves-light sa-delete" title="Delete Customer" data-id="{{ $customer->id }}" data-link="/admin/user/destroy/"><i class="bx bx-trash font-size-16"></i></a>
                                        @endif --}}
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
