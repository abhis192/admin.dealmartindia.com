@extends('layouts.backend.app')

@section('title')
<title>Reviews | Admin</title>
@endsection

@section('css')
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All Reviews</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">All Reviews & Rating</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card border">
                    <div class="card-body">

                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Customer</th>
                                    <th>No. Star</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                    <th class="col-1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reviews as $key => $review)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td class="text-wrap"><a href="#">{{$review->product->name}}</a></td>
                                    <td class="text-wrap">
                                        <p class="m-0">{{$review->user->name}}</p>
                                        <p class="m-0"><b>[{{$review->user->email}}]</b> </p>
                                    </td>
                                    <td>
                                        <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0 text-warning">
                                            @foreach(range(1, $review->stars) as $index)
                                            <i class="fas fa-star"></i>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>{{\Carbon\Carbon::parse($review->created_at)->format('d M, Y')}}</td>
                                    <td>
                                        @if($review->status == 1)
                                        <span class="badge badge-soft-success font-size-12">Approved</span>
                                        @else
                                        <span class="badge badge-soft-danger font-size-12">Not Approved</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0);" class="btn btn-soft-danger btn-sm waves-effect waves-light sa-review" title="Change Status" data-id="{{ $review->id }}" data-link="/admin/review/change/"><i class="bx bx-history font-size-16"></i></a>

                                        <a href="javascript:void(0);" class="btn btn-soft-warning btn-sm waves-effect waves-light" title="View Comment" data-bs-toggle="modal" data-bs-target="#viewReson{{$key+1}}"><i class="mdi mdi-eye font-size-16"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>

@foreach($reviews as $key => $review)
<!-- [ Payout View Modal ] start -->
<div id="viewReson{{$key+1}}" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Rating and Reviews</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <!-- <div class="col-lg-12">
                        <div class="form-group">
                            <label class="col-from-label" for="amount">Product Name:</label>
                            <input type="text" name="name" class="form-control" value="Air Conditioning" disabled />
                        </div>
                    </div> -->

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="col-from-label" for="amount">Review Content:</label>
                            <textarea name="description" class="form-control" rows="5" disabled>{{$review->content}}</textarea>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@endforeach
@endsection
