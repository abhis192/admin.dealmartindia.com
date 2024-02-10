@extends('layouts.backend.app')

@section('title')
<title>Upload City | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">upload City</h4>

                    <div class="page-title-right">
                        <!-- <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">All Users</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
                        </ol> -->
                        <a href="{{route('admin.city')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-reply-all"></i> Back to list</a>
                    </div>
                </div>
            </div>
        </div> 
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-12">
            	<a href="{{ asset('cities.csv') }}" download>Download sample csv</a>
                <form class="pt-4" action="{{ route('admin.import.city.csv.process') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                    <button class="btn btn-info" type="submit">Import CSV</button>
                </form>
            </div> <!-- end col --> 
        </div> <!-- end row -->  
    </div>
    <!-- container-fluid -->
</div> 
@endsection
