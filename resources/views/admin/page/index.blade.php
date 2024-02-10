@extends('layouts.backend.app')

@section('title')
<title>Pages | {{Auth::user()->role->name}}</title>
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
                    <h4 class="mb-sm-0 font-size-18">All Pages</h4>

                    <div class="page-title-right">
                        <!-- <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">All Pages</li>
                        </ol> -->
                        <a href="{{route('admin.page.create')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-plus"></i> Add New Page</a>
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
                                    <th>Page Name</th>
                                    <th>Page Url</th>
                                    <th class="col-1">Status</th>
                                    <th class="col-1">Created At</th>
                                    <th class="col-1">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($pages as $key => $page)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td class="text-wrap">{{$page->name}}</td>
                                    <td><a href="{{env('APP_URL')}}{{$page->slug}}">{{env('APP_URL')}}{{$page->slug}}</a></td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.page.toggle', $page->id) }}">
                                            @csrf
                                            <button type="submit" class="square-switch btn btn-toggle">
                                                <input type="checkbox" id="square-switch{{$key}}" switch="status" name="status" {{ $page->status == 1 ? "checked" : "" }} />
                                                <label for="square-switch{{$key}}" data-on-label="Yes" data-off-label="No"></label>
                                            </button>
                                        </form>
                                    </td>
                                    <td>{{date('d M Y | h:i A',strtotime($page->created_at))}}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.page.edit', $page->id) }}" class="btn btn-soft-info btn-sm waves-effect waves-light"><i class="bx bx-pencil font-size-16"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-soft-danger btn-sm waves-effect waves-light sa-delete" title="Delete Category" data-id="{{ $page->id }}" data-link="/admin/page/destroy/"><i class="bx bx-trash font-size-16"></i></a>
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
