@extends('layouts.backend.app')

@section('title')
<title>Home Page | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">Home Page</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">Home Page</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-12">

                <form class="custom-form needs-validation" method="post" action="{{route('admin.home-page.update',$homePage->id)}}" enctype="multipart/form-data" novalidate>
                    @method('PATCH')
                    @csrf

                    <div class="row">

                        <div class="col-lg-12">

                            <!-- Section 01 -->


                            <!-- Section 01 - 03 -->
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Section 01 - 03</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="typeId" class="form-label fw-bold">Select Type:</label>
                                                <select class="form-control select2" id="typeId" name="section_1" required="required">
                                                  <option value="">Select Type</option>
                                                    @foreach($types as $type)
                                                    <option value="{{$type->id}}"
                                                        @if ($homePage->section_1==$type->id) selected @endif>
                                                        {{$type->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="typeId" class="form-label fw-bold">Select Type:</label>
                                                <select class="form-control select2" id="typeId" name="section_2" required="required">
                                                    <option value="">Select Type</option>
                                                    @foreach($types as $type)
                                                    <option value="{{$type->id}}"
                                                        @if ($homePage->section_2==$type->id) selected @endif>
                                                        {{$type->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="typeId" class="form-label fw-bold">Select Type:</label>
                                                <select class="form-control select2" id="typeId" name="section_3" required="required">
                                                  <option value="">Select Type</option>
                                                    @foreach($types as $type)
                                                    <option value="{{$type->id}}"
                                                        @if ($homePage->section_3==$type->id) selected @endif>
                                                        {{$type->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">This field is required. </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div>

                            <!-- Section 04 -->
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Section 04</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                {{-- <label class="form-label fw-bold">Logo:</label> --}}
                                                <input type="file" id="input-file-now" name="section_4" class="dropify @error('image') is-invalid @enderror" data-default-file="{{asset('storage/banner/'.$homePage->section_4)}}"/>
                                                <input type="hidden" name="hidden_section_4" value="{{ $homePage->section_4 }}">
                                                <small class="text-muted"><b>Example::</b> image size - 500x500 </small>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- <div class="card-footer"></div> -->
                            </div>



                        </div>

                        <div class="col-lg-12">
                            <div class="card action-btn text-end">
                                <div class="card-body p-2">
                                    <!-- <button type="reset" class="btn btn-warning waves-effect waves-light">Clear</button> -->
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>

            </div> <!-- end col -->
        </div> <!-- end row -->


    </div>
    <!-- container-fluid -->
</div>
@endsection
