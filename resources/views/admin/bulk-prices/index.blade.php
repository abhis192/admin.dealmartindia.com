@extends('layouts.backend.app')

@section('title')
<title>All Bulk Prices | {{Auth::user()->role->name}}</title>
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
                    <h4 class="mb-sm-0 font-size-18">All Product Bulk Price</h4>

                    <div class="page-title-right">
                        <a href="{{route('admin.bulk-price.create')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-plus"></i> Create New Price</a>
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card border">
                    <div class="card-body">

                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="col-1">#</th>
                                    <th>Product Name</th>
                                    <th>City</th>
                                    <th>Qty W. & Price</th>
                                    <th class="col-1">Published</th>
                                    <th class="col-1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@if($prices->count())
                                @foreach($prices as $key => $price)
                                <tr>
                                    <td>1</td>
                                    <td class="text-wrap">
                                        <p class="m-0"><b>{{$price->product->name}}</b></p>
                                        {{-- <p class="m-0"><b>
                                            [{{$price->product->user->business}}] -
                                            @if($price->product->category)
                                            {{$price->product->category->name}}
                                            @endif
                                        </b></p> --}}
                                    </td>
                                    <td class="text-wrap">
                                        <p class="m-0">{{$price->city->name}}</p>
                                        {{-- @foreach($cities as $city)
                                            <span class="m-0">{{$price->city->name}}</span>,
                                        @endforeach --}}
                                    </td>

                                    <td class="text-wrap">
                                        <table class="table table-bordered table-sm border mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Qty W.</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $pricingRules = json_decode($price->pricing_rules, true);
                                                @endphp
                                                @if(is_array($pricingRules))
                                                    @foreach($pricingRules as $rule)
                                                        <tr>
                                                            <td>{{ $rule['qty_weight'] }}</td>
                                                            <td><i class="bx bx-rupee"></i>{{ $rule['final_price'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="2">No pricing rules available.</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.bulk-price.toggle', $price->id) }}">
                                            @csrf
                                            <button type="submit" class="square-switch btn btn-toggle">
                                                <input type="checkbox" id="square-switch{{$key}}" switch="status" name="status" {{ $price->status == 1 ? "checked" : "" }} />
                                                <label for="square-switch{{$key}}" data-on-label="Yes" data-off-label="No"></label>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        {{--@if(Auth::user()->hasPermissionTo('bulk-price_edit'))--}}
                                        <a href="{{ route('admin.bulk-price.edit', $price->id) }}" class="btn btn-soft-info btn-sm waves-effect waves-light"><i class="bx bx-pencil font-size-16"></i></a>
                                        {{--@endif
                                        @if(Auth::user()->hasPermissionTo('bulk-price_delete'))--}}
                                        <a href="javascript:void(0);" class="btn btn-soft-danger btn-sm waves-effect waves-light sa-delete" title="Delete Category" data-id="{{ $price->id }}" data-link="/admin/bulk-price/destroy/"><i class="bx bx-trash font-size-16"></i></a>
                                        {{--@endif--}}
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->

        </div>

    </div>
    <!-- container-fluid -->
</div>
@endsection
