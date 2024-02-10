@extends('layouts.backend.app')

@section('title')
<title>Users | {{Auth::user()->role->name}}</title>
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
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">All User</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./"><i class="feather icon-home"></i></a></li>  
                            <li class="breadcrumb-item"><a href="#!">Manage Users</a></li>
                            <li class="breadcrumb-item"><a href="#!">User List</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start --> 
        <div class="row"> 
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body"> 
                        <div class="table-responsive">
                            <table id="report-table" class="table table-sm table-bordered table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th class="col-1">SR.No.</th> 
                                        <th>User Name</th>  
                                        <th>Email Id</th> 
                                        <th>Phone No.</th>  
                                        <th class="col-1">Status</th> 
                                        <th class="col-1">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($users->count())
                                    @foreach($users as $index => $user)
                                    <tr>
                                        <td>{{$index+1}}.</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->mobile}}</td>
                                        <td>
                                            @if($user->email_verified_at != null)
                                            <a href="{{ route('admin.users.deactivate', $user->id) }}" class="btn btn-success font-weight-bold btn-xs btn-block has-ripple text-white">Active</a>
                                            @else
                                            <a href="{{ route('admin.users.activate', $user->id) }}" class="btn btn-danger font-weight-bold btn-xs btn-block has-ripple text-white">Not Verified</a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.users.edit',$user->id)}}" class="btn btn-info btn-xs"  title="Edit"><i class="feather icon-edit"></i></a>
                                            <button class="btn btn-danger btn-xs sweet-multiple" title="Delete"><i class="feather icon-trash-2"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-gray"></div>
                </div>
            </div>
        </div> 
        <!-- [ Main Content ] end -->
    </div>
</div>
@endsection

@section('script')
<script>
    // DataTable start
    $('#report-table').DataTable();  
</script>
@endsection