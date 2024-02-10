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
                    <form class="custom-form needs-validation" method="post" action="{{ route('admin.deliveryoption.update',$deliveryoption->id) }}" novalidate>
                        @method('PATCH')
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Delivery Option Name <sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="text" name="option_name" class="form-control @error('option_name') is-invalid @enderror" placeholder="Enter Your Full Name" value="{{$deliveryoption->option_name}}" required/>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('option_name')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Delivery Charge<sup class="text-danger fs-5">*</sup> :</label>
                                                <input type="number" name="delivery_charge" class="form-control @error('delivery_charge') is-invalid @enderror" placeholder="Enter Your Full Name" value="{{$deliveryoption->delivery_charge}}" required/>
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

                                        {{-- <div class="col-sm-12">
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




                                        {{-- <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="description" class="form-label">Description:</label>
                                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Write somthing...">{{$slot->description}}</textarea>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                                @error('description')
                                                    <div class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div> --}}

                                        {{-- <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">From <sup class="text-danger fs-5">*</sup> :</label>
                                                <input class="form-control" name="from" value="{{$slot->from}}" type="time"  id="example-time-input" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">To <sup class="text-danger fs-5">*</sup> :</label>
                                                <input class="form-control" name="to" value="{{$slot->to}}" type="time"  id="example-time-input" required>
                                            </div>
                                        </div> --}}


                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Time Slot List <sup class="text-danger fs-5">*</sup> :</label>
                                                <select class="form-control select2" name="time_slot_inside[]" multiple required>
                                                    <option value="">Select</option>
                                                    @foreach($slots as $slot)
                                                    <option value="{{$slot->id}}" @if(in_array($slot->id, explode(',',$deliveryoption->time_slot_inside))) selected @endif>{{$slot->from}}-{{$slot->to}}</option>
                                                    {{-- <option value="{{$slot->id}}" {{ $slot->id == $deliveryoption->time_slot_inside ? "selected" : "" }}>{{$slot->from}}-{{$slot->to}}</option> --}}
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
                                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Write somthing...">{{ $deliveryoption->description }}</textarea>
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
                                                    <input type="checkbox" id="square-switch3" name="status" switch="status" {{ $deliveryoption->status == 1 ? "checked" : "" }} />
                                                    <label for="square-switch3" data-on-label="Yes"
                                                        data-off-label="No"></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label fw-bold">COD <sup class="text-danger fs-5">*</sup> :</label>
                                                <div class="square-switch">
                                                    <input type="checkbox" id="square-switc4" name="cod" switch="status" {{ $deliveryoption->cod == 1 ? "checked" : "" }}/>
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
                                        </form>
                                    </td>
                                    <td class="text-center">
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
@endsection
@section('script')
{{-- <script src="{{asset('assets/admin/js/pages/form-advanced.init.js')}}"></script> --}}
@endsection
