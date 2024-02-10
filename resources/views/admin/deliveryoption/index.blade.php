@extends('layouts.backend.app')

@section('title')
<title>Delivery Option | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">Delivery Option</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">Delivery Option</li>
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
                    <form class="custom-form needs-validation" method="post" action="{{ route('admin.deliveryoption.store') }}" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Delivery Option Name <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" name="option_name" class="form-control @error('option_name') is-invalid @enderror" placeholder="Enter Your Full Name" value="{{ old('option_name') }}" required/>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('option_name')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>


                                            {{-- <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="name" class="form-label fw-bold">From <sup class="text-danger fs-5">*</sup> :</label>
                                                    <input class="form-control" name="from" type="time"  id="example-time-input" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="name" class="form-label fw-bold">To <sup class="text-danger fs-5">*</sup> :</label>
                                                    <input class="form-control" name="to" type="time"  id="example-time-input" required>
                                                </div>
                                            </div> --}}

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="name" class="form-label">Delivery Charge<sup class="text-danger fs-5">*</sup> :</label>
                                                    <input type="text" name="delivery_charge" class="form-control @error('delivery_charge') is-invalid @enderror" placeholder="Enter Your Full Name" value="{{ old('delivery_charge') }}" required/>
                                                    <div class="valid-feedback">Looks good!</div>
                                                    <div class="invalid-feedback">This field is required. </div>
                                                    @error('delivery_charge')
                                                        <div class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="name" class="form-label fw-bold">Time Slot List<sup class="text-danger fs-5">*</sup> :</label>
                                                    <select class="form-control" multiple required>
                                                        <option value="1">Select Time Slot</option>
                                                        <option value="2">06:00 AM - 08:00 AM</option>
                                                        <option value="3">08:00 AM - 10:00 AM</option>
                                                        <option value="4">10:00 AM - 12:00 PM</option>
                                                        <option value="5">12:00 PM - 02:00 PM</option>
                                                    </select>
                                                </div>
                                            </div> --}}

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">Time Slot List<sup class="text-danger fs-5">*</sup> :</label>
                                                    <select class="form-control select2" name="time_slot_inside[]" placeholder="Select Class" multiple required>
                                                        <option  value="">Select</option>
                                                    @foreach($slots as $slot)
                                                    <option  value="{{$slot->id}}">{{$slot->from}}-{{$slot->to}}</option>
                                                    @endforeach
                                                        {{-- <option value="">Select Class</option>
                                                        <option value="06:00 AM - 08:00 AM">06:00 AM - 08:00 AM</option>
                                                        <option value="08:00 AM - 10:00 AM">08:00 AM - 10:00 AM</option>
                                                        <option value="10:00 AM - 12:00 PM">10:00 AM - 12:00 PM</option>
                                                        <option value="12:00 PM - 02:00 PM">12:00 PM - 02:00 PM</option> --}}
                                                    </select>

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

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">Published <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="square-switch">
                                                    <input type="checkbox" id="square-switch3" name="status" switch="status" checked />
                                                    <label for="square-switch3" data-on-label="Yes"
                                                        data-off-label="No"></label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">COD <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="square-switch">
                                                    <input type="checkbox" id="square-switc4" name="cod" switch="status"/>
                                                    <label for="square-switc4" data-on-label="Yes"
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
                                    <th class="col-1">#</th>
                                    <th>Name</th>
                                    <th class="col-1">Charges</th>
                                    {{-- <th class="col-1">No. of Slot</th> --}}
                                    <th class="col-1">Published</th>
                                    <th class="col-1">Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach($deliveryoptions as $key => $deliveryoption)
                                <tr>
                                    <td>#{{$key+1}}.</td>
                                    <td>{{$deliveryoption->option_name}}</td>
                                    <td>₹ {{$deliveryoption->delivery_charge}}</td>
                                    {{-- <td>{{$deliveryoption->delivery_charge}}</td> --}}
                                    <td class="text-center">
                                        <form method="POST" action="{{ route('admin.deliveryoption.toggle', $deliveryoption->id) }}">
                                            @csrf
                                            <button type="submit" class="square-switch btn btn-toggle">
                                                <input type="checkbox" id="square-switch{{$key+1}}" switch="status" name="status" {{ $deliveryoption->status == 1 ? "checked" : "" }} />
                                                <label for="square-switch{{$key+1}}" data-on-label="Yes" data-off-label="No"></label>
                                            </button>

                                            {{-- <button type="submit" class="square-switch btn btn-toggle">
                                                <input type="checkbox" id="square-switch{{$key+1}}" switch="status" name="cod" {{ $deliveryoption->cod == 1 ? "checked" : "" }} />
                                                <label for="square-switch{{$key+1}}" data-on-label="Yes" data-off-label="No"></label>
                                            </button> --}}

                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0);" class="btn btn-soft-success btn-sm waves-effect waves-light" title="View Details" data-bs-toggle="modal" data-bs-target="#prView{{$key}}"> <i class="mdi mdi-eye font-size-16"></i></a>

                                        <a href="{{ route('admin.deliveryoption.edit', $deliveryoption->id) }}" class="btn btn-soft-info btn-sm waves-effect waves-light" title="Edit Country"><i class="bx bx-pencil font-size-16"></i></a>

                                        <a href="javascript:void(0);" class="btn btn-soft-danger btn-sm waves-effect waves-light sa-delete" title="Delete Country" data-id="{{ $deliveryoption->id }}" data-link="/admin/deliveryoption/destroy/"><i class="bx bx-trash font-size-16"></i></a>
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

@foreach($deliveryoptions as $key => $deliveryoption)
    <!-- [ Delivery View Modal ] start -->
    <div id="prView{{$key}}" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Payout Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{$deliveryoption->option_name}}</td>
                                    </tr>
                                    <tr>
                                        <th>Charges</th>
                                        <td>₹ {{$deliveryoption->delivery_charge}}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Time Slot List</th>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            @foreach($slots as $slot)
                                            {{-- <span class="btn btn-soft-success btn-sm waves-effect waves-light">{{$slot->from}}-{{$slot->to}}</span> --}}

                                                @if(in_array($slot->id, explode(',',$deliveryoption->time_slot_inside)))
                                                    <span class="btn btn-soft-success btn-sm waves-effect waves-light"> {{$slot->from}}-{{$slot->to}}
                                                    </span>
                                                @endif
                                            @endforeach


                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-success waves-effect waves-light">Pay</button> -->
                    {{-- <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cancel</button> --}}
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    @endforeach
@endsection
@section('script')
{{-- <script src="{{asset('assets/admin/js/pages/form-advanced.init.js')}}"></script> --}}
@endsection
