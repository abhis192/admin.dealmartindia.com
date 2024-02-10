@extends('layouts.backend.app')

@section('title')
<title>City Edit | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">Shipping City</h4>

                    {{-- <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">Shipping City</li>
                        </ol>
                    </div> --}}
                    <div class="page-title-right">

                        {{-- <a href="javascript:void(0);" class="btn btn-soft-info waves-effect waves-light" title="Add Country" data-bs-toggle="modal" data-bs-target="#addData"><i class="fas fa-plus"></i> Add New City</a>  --}}

                        <a href="javascript:void(0);" class="btn btn-soft-success waves-effect waves-light" title="Import City" data-bs-toggle="modal" data-bs-target="#importData"><i class="fas fa-file"></i> Import City</a>

                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-4">
                <div class="card border">
                    <form class="custom-form needs-validation" method="post" action="{{ route('admin.city.update', $city->id) }}" novalidate>
                        @method('PATCH')
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">City Name <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Your Name" value="{{$city->name}}" required/>
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
                                                <label for="name" class="form-label">Choose State <sup class="text-danger fs-5">*</sup> :</label>
                                                <select class="form-control select2" name="state_id" required>
                                                    <option value="">Select</option>
                                                    @foreach($states as $state)
                                                    <option value="{{$state->id}}" {{ $state->id == $city->state_id ? "selected" : "" }}>{{$state->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('state_id')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="description" class="form-label">Description:</label>
                                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Write somthing...">{{ $city->description }}</textarea>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('description')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Set Area Wise Shipping Cost:</label>
                                                <input type="number" id="name" class="form-control" name="shipping_cost" placeholder="Enter Shipping Cost..." value="{{$city->shipping_cost}}" />
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('shipping_cost')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div> --}}


                                        {{-- shipping cost  --}}
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Set Delivery Option:</label>
                                                {{-- <input type="number" id="name" class="form-control" name="delivery_option" placeholder="Enter Shipping Cost..." /> --}}

                                                <select class="form-control select2 select2-multiple" name="delivery_option[]" multiple="multiple" data-placeholder="Enter Delivery Option..." >
                                                    {{-- <option value="2">badarpur</option>
                                                    <option value="3">Jaithpur</option>
                                                    <option value="4">Meethapur</option> --}}
                                                     {{-- <option value=""></option> --}}
                                                {{-- @if ($delivery_options->isNotEmpty()) --}}
                                                    {{-- @foreach ($delivery_options as $row) --}}
                                                        {{-- <option value="{{ $row->id }}">{{ $row->option_name }}</option> --}}
                                                        {{-- <option value="{{$row->id}}" {{ $row->id == $city_map->delivery_option ? "selected" : "" }}>{{$row->option_name}}</option> --}}
                                                    {{-- @endforeach --}}
                                                {{-- @endif --}}


                                                @foreach($delivery_options as $row)
                                                <option
                                                    value="{{$row->id}}"
                                                    @foreach($city->mappings as $prodCat)
                                                        @if($prodCat->delivery_option == $row->id)
                                                            selected
                                                        @endif
                                                    @endforeach
                                                    >
                                                    {{$row->option_name}}
                                                </option>
                                                @endforeach
                                                </select>




                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('shipping_cost')
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
                                                    <input type="checkbox" id="square-switch3" switch="status" name="status" {{ $city->status == 1 ? "checked" : "" }} />
                                                    <label for="square-switch3" data-on-label="Yes"
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
                            <button type="submit" class="btn btn-info waves-effect waves-light">Update Changes</button>
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
                                    <th>City Name</th>
                                    <th>Assign State</th>
                                    {{-- <th>Shipping Cost</th> --}}
                                    <th class="col-1">Published</th>
                                    <th class="col-1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cities as $key => $city)
                                <tr>
                                    <td>#{{$key+1}}.</td>
                                    <td>{{$city->name}}</td>
                                    <td>{{$city->state->name}}</td>
                                    {{-- <td>
                                        @if($city->shipping_cost)
                                        <b><i class="bx bx-rupee"></i>{{$city->shipping_cost}}.00</b>
                                        @endif
                                    </td> --}}
                                    <td class="text-center">
                                        <form method="POST" action="{{ route('admin.city.toggle', $city->id) }}">
                                            @csrf
                                            <button type="submit" class="square-switch btn btn-toggle">
                                                <input type="checkbox" id="square-switch{{$key+1}}" switch="status" name="status" {{ $city->status == 1 ? "checked" : "" }} />
                                                <label for="square-switch{{$key+1}}" data-on-label="Yes" data-off-label="No"></label>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.city.edit', $city->id) }}" class="btn btn-soft-info btn-sm waves-effect waves-light" title="Edit City"><i class="bx bx-pencil font-size-16"></i></a>

                                        <a href="javascript:void(0);" class="btn btn-soft-danger btn-sm waves-effect waves-light sa-delete" title="Delete City" data-id="{{ $city->id }}" data-link="/admin/city/destroy/"><i class="bx bx-trash font-size-16"></i></a>
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
 <div id="importData" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Import City</h5>
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
</div>
@endsection
@section('script')
{{-- <script src="{{asset('assets/admin/js/pages/form-advanced.init.js')}}"></script> --}}
@endsection
