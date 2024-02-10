@extends('layouts.backend.app')

@section('title')
<title>Coupon | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">All Coupons</h4>

                    <div class="page-title-right">
                        <!-- <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">All Brands</li>
                        </ol> -->
                        @if(Auth::user()->hasPermissionTo('coupon_add'))
                        <a href="{{route('admin.coupon.create')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-plus"></i> Add New Coupon</a>
                        @endif
                    </div>

                </div>
            </div>
        </div> 
        <!-- [ breadcrumb ] end -->

        <div class="row">  
            <div class="col-xl-12">
                <div class="card border"> 
                    <div class="card-body"> 

                        <table 
                        @if(Auth::user()->hasPermissionTo('coupon_add'))
                        id="datatable-buttons" 
                        @else
                        id="datatable-buttons-2" 
                        @endif
                        class="table table-bordered dt-responsive nowrap w-100"
                        >
                            <thead>
                                <tr>
                                    <th class="col-1">#</th> 
                                    <th>Coupon Name/Code</th> 
                                    <th>Price Min/Max</th> 
                                    <th>No. of Use</th> 
                                    <th>Discount</th> 
                                    <th>Coupon From-To Date</th> 
                                    <th class="col-1">Published</th>
                                    <th class="col-1">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($coupons as $key => $coupon)
                                <tr> 
                                    <td>{{$key+1}}</td>
                                    <td class="text-wrap">
                                        <p class="m-0">{{$coupon->name}}</p>
                                        <p class="m-0 fw-bold">[{{$coupon->code}}]</p>
                                    </td>
                                    <td class="text-wrap">
                                        <p class="m-0">₹{{$coupon->min_price}} @if($coupon->max_price) - {{$coupon->max_price}} @endif </p> 
                                    </td>
                                    <td>{{$coupon->use}} Time</td>
                                    <td class="text-wrap">
                                        <p class="m-0">{{$coupon->type}}</p>
                                        <p class="m-0 fw-bold">[₹{{$coupon->discount}}]</p>
                                    </td>
                                    <td class="text-wrap">
                                        <p class="m-0"><b>Start: </b>{{\Carbon\Carbon::parse($coupon->start_date)->format('d M, Y')}}</p> 
                                        <p class="m-0"><b>End: </b>{{\Carbon\Carbon::parse($coupon->end_date)->format('d M, Y')}}</p> 
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.coupon.toggle', $coupon->id) }}">
                                            @csrf
                                            <button type="submit" class="square-switch btn btn-toggle">
                                                <input type="checkbox" id="square-switch{{$key}}" switch="status" name="status" {{ $coupon->status == 1 ? "checked" : "" }} />
                                                <label for="square-switch{{$key}}" data-on-label="Yes" data-off-label="No"></label>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center">  
                                        <a href="{{ route('admin.coupon.edit', $coupon->id) }}" class="btn btn-soft-info btn-sm waves-effect waves-light"><i class="bx bx-pencil font-size-16"></i></a> 

                                        <a href="javascript:void(0);" class="btn btn-soft-danger btn-sm waves-effect waves-light sa-delete" title="Delete Coupon" data-id="{{ $coupon->id }}" data-link="/admin/coupon/destroy/"><i class="bx bx-trash font-size-16"></i></a>
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