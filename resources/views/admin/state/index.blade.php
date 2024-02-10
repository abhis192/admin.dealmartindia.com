@extends('layouts.backend.app')

@section('title')
<title>State | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">Shipping State</h4>

                    {{-- <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">Shipping State</li>
                        </ol>
                    </div> --}}
                    <div class="page-title-right">

                        {{-- <a href="javascript:void(0);" class="btn btn-soft-info waves-effect waves-light" title="Add State" data-bs-toggle="modal" data-bs-target="#addData"><i class="fas fa-plus"></i> Add New States</a> --}}

                        <a href="javascript:void(0);" class="btn btn-soft-success waves-effect waves-light" title="Import State" data-bs-toggle="modal" data-bs-target="#importCSV"><i class="fas fa-file"></i> Import States</a>
                        {{-- <a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light mx-3" title="View Comment" data-bs-toggle="modal" data-bs-target="#importCSV"><i class="fas fa-file"></i> Import CSV</a> --}}
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-4">
                <div class="card border">
                    <form class="custom-form needs-validation" method="post" action="{{ route('admin.state.store') }}" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">State Name <sup class="text-danger fs-5">*</sup> :</label>
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
                                                <label for="name" class="form-label">Choose Country <sup class="text-danger fs-5">*</sup> :</label>
                                                <select class="form-control select2" name="country_id" required>
                                                    <option value="">Select</option>
                                                    @foreach($countries as $country)
                                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('country_id')
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
                                                    <input type="checkbox" id="square-switch0" switch="status" name="status" checked />
                                                    <label for="square-switch0" data-on-label="Yes"
                                                        data-off-label="No"></label>
                                                    @error('status')
                                                        <div class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
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
                                    <th class="col-1">#</th>
                                    <th>State Name</th>
                                    <th>Assign Country</th>
                                    <th class="col-1">Published</th>
                                    <th class="col-1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($states as $key => $state)
                                <tr>
                                    <td>#{{$key+1}}.</td>
                                    <td>{{$state->name}}</td>
                                    <td>{{$state->country->name}}</td>
                                    <td class="text-center">
                                        <form method="POST" action="{{ route('admin.state.toggle', $state->id) }}">
                                            @csrf
                                            <button type="submit" class="square-switch btn btn-toggle">
                                                <input type="checkbox" id="square-switch{{$key+1}}" switch="status" name="status" {{ $state->status == 1 ? "checked" : "" }} />
                                                <label for="square-switch{{$key+1}}" data-on-label="Yes" data-off-label="No"></label>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.state.edit', $state->id) }}" class="btn btn-soft-info btn-sm waves-effect waves-light" title="Edit State"><i class="bx bx-pencil font-size-16"></i></a>

                                        <a href="javascript:void(0);" class="btn btn-soft-danger btn-sm waves-effect waves-light sa-delete" title="Delete State" data-id="{{ $state->id }}" data-link="/admin/state/destroy/"><i class="bx bx-trash font-size-16"></i></a>
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
<!-- [ Import Data Modal ] start -->
{{-- <div id="importData" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Import State</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="csvFrm">
                    <input type="hidden" name="_token" value="QenwqYUQeC50H3g3gpo5J0C62lhEEOV3uoam5bkI">            <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="name" class="form-label">Choose CSV File <a href="http://vre-crm.starklikes.com/public/states/import-csv/download/sample" class="btn btn-sm btn-link">(Download CSV)</a></label>
                                <div>
                                    <input type="file" name="csv_file">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="importBtn" type="button" class="btn btn-success waves-effect waves-light">Import CSV</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> --}}

<!-- [ Import CSV Modal ] start -->
<div id="importCSV" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.import.state.csv.process') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Import State</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-12 mb-2">
                            Choose CSV File <a href="{{ asset('states.csv') }}" download>Download sample csv</a>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{-- <label class="col-from-label" for="amount">Product Name:</label> --}}
                                <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success waves-effect" type="submit">Import CSV</button>
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
