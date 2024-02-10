@extends('layouts.backend.app')

@section('title')
<title>Product Sales Report | {{env('APP_NAME')}}</title>
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
                    <h4 class="mb-sm-0 font-size-18">Product Sales Report</h4>

                    <div class="page-title-right">
                        <!-- <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">All Banner</li>
                        </ol> -->
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card border">
                    <div class="card-header">
                        <!-- Filter Area -->
                        <div class="filter-area">
                            <div class="row justify-content-start align-items-center">
                                <div class="col-lg-10">
                                    <form class="custom-form" method="POST" action="#">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <div class="input-group form-group mb-0">
                                                <label class="input-group-text form-control-sm">Start Date</label>
                                                    <input type="date" class="form-control form-control-sm" required/>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="input-group form-group mb-0">
                                                <label class="input-group-text form-control-sm">End Date</label>
                                                    <input type="date" class="form-control form-control-sm" required/>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <button type="submit" class="btn btn-success waves-effect waves-light">Filter</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="col-1">#</th>
                                    <th>Product Name</th>
                                    <th>Category Name</th>
                                    <th class="col-1">Number Of Sale</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($products as $key => $product)
                                @if($product->orderItems->count())
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td class="text-wrap">{{$product->name}}</td>
                                    <td>{{$product->category->name??''}}</td>
                                    <td><span class="badge badge-soft-success font-size-16">{{$product->orderItems->count()}}</span></td>
                                </tr>
                                @endif
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
