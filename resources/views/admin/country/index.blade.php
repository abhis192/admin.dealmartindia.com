@extends('layouts.backend.app')

@section('title')
<title>Country | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">Shipping Countries</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">Shipping Countries</li>
                        </ol>
                    </div>
                    {{-- <div class="page-title-right">

                        <a href="javascript:void(0);" class="btn btn-soft-info waves-effect waves-light" title="Add Country" data-bs-toggle="modal" data-bs-target="#addData"><i class="fas fa-plus"></i> Add New Country</a>

                        <!-- <a href="javascript:void(0);" class="btn btn-soft-success waves-effect waves-light" title="Import Country" data-bs-toggle="modal" data-bs-target="#importData"><i class="fas fa-file"></i> Import States</a>   -->

                    </div> --}}

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-4">
                <div class="card border">
                    <form class="custom-form needs-validation" method="post" action="{{ route('admin.country.store') }}" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Country Name <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Your Name" value="{{ old('name') }}" required/>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('name')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="description" class="form-label">Description:</label>
                                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Write somthing...">{{ old('description') }}</textarea>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('description')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Published <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="square-switch">
                                                    <input type="checkbox" id="square-switch3" name="status" switch="status" checked />
                                                    <label for="square-switch3" data-on-label="Yes"
                                                        data-off-label="No"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
                        </div>
                    </form>
                </div>
                <!-- end card -->
            </div> <!-- end col -->

            <div class="col-xl-8">
                <div class="card border">
                    <div class="card-body">

                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="col-1">Sr. No.</th>
                                    <th>Country Name</th>
                                    <th class="col-1">Published</th>
                                    <th class="col-1">Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach($countries as $key => $country)
                                <tr>
                                    <td>#{{$key+1}}.</td>
                                    <td>{{$country->name}}</td>
                                    <td class="text-center">
                                        <form method="POST" action="{{ route('admin.country.toggle', $country->id) }}">
                                            @csrf
                                            <button type="submit" class="square-switch btn btn-toggle">
                                                <input type="checkbox" id="square-switch{{$key+1}}" switch="status" name="status" {{ $country->status == 1 ? "checked" : "" }} />
                                                <label for="square-switch{{$key+1}}" data-on-label="Yes" data-off-label="No"></label>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.country.edit', $country->id) }}" class="btn btn-soft-info btn-sm waves-effect waves-light" title="Edit Country"><i class="bx bx-pencil font-size-16"></i></a>

                                        <a href="javascript:void(0);" class="btn btn-soft-danger btn-sm waves-effect waves-light sa-delete" title="Delete Country" data-id="{{ $country->id }}" data-link="/admin/country/destroy/"><i class="bx bx-trash font-size-16"></i></a>
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
