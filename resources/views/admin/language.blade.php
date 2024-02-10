@extends('layouts.backend.app')

@section('title')
<title>Language</title>
@endsection

@section('css')
@endsection

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">

        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Edit Page</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="feather icon-home"></i></a></li>  
                            <li class="breadcrumb-item"><a href="">Manage Language</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->  
        <div class="row"> 
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">                    
                        <div class="table-responsive">
                            <table id="report-table" class="table table-sm table-bordered table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th class="col-1">SR.No.</th>   
                                        <th>Name</th> 
                                        <th>Code</th> 
                                        <th class="col-1">status</th> 
                                        <th class="col-1">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($languages->count())
                                    @foreach($languages as $index => $row)
                                    <tr>
                                        <td>{{$index+1}}</td>  
                                        <td>{{$row->name}}</td>
                                        <td>{{$row->code}}</td>
                                        <td>
                                            @if($row->default == 1)
                                            <a class="btn btn-success font-weight-bold btn-xs btn-block has-ripple text-white">Primary</a>
                                            @else
                                            <a href="{{ route('admin.language.default', $row->id) }}" class="btn btn-danger font-weight-bold btn-xs btn-block has-ripple text-white">Non Primary</a>
                                            @endif
                                            <!-- <button class="btn btn-success font-weight-bold btn-xs btn-block" disabled>Primary</button>  -->
                                        </td>
                                        <td>
                                            @if($row->status == 1)
                                            <a href="{{ route('admin.language.deactivate', $row->id) }}" class="btn btn-success font-weight-bold btn-xs btn-block has-ripple text-white">Enabled</a>
                                            @else
                                            <a href="{{ route('admin.language.activate', $row->id) }}" class="btn btn-danger font-weight-bold btn-xs btn-block has-ripple text-white">Disabled</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
        </div>  
        <!-- [ Main Content ] end -->
    </div>
</div>
@endsection

