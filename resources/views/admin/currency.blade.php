@extends('layouts.backend.app')

@section('title')
<title>Currency</title>
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
                            <li class="breadcrumb-item"><a href="">Manage Currency</a></li>
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
                    <form class="custom-form" method="POST" action="{{ route('admin.currency.update') }}">
                        @csrf
                        <div class="card-header"></div>
                        <div class="card-body">                    
                            <div class="table-responsive">
                                <table id="report-table" class="table table-sm table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th class="col-1">SR.No.</th>   
                                            <th>Currency Name</th> 
                                            <th>Currency Symbol</th> 
                                            <th class="col-1">status</th> 
                                            <th class="col-1">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        @if($currency->count())
                                        @foreach($currency as $index => $row)
                                        <tr>
                                            <td>{{$index+1}}.</td>  
                                            <td>{{$row->currency_code}}</td>
                                            <td>{{$row->currency_symbol}}</td>
                                            <td>
                                                @if($row->default == 1)
                                                <a class="btn btn-success font-weight-bold btn-xs btn-block has-ripple text-white">Primary</a>
                                                @else
                                                <a href="{{ route('admin.subscribers.default', $row->id) }}" class="btn btn-danger font-weight-bold btn-xs btn-block has-ripple text-white">Non Primary</a>
                                                @endif
                                                <!-- <button class="btn btn-success font-weight-bold btn-xs btn-block" disabled>Primary</button>  -->
                                            </td>
                                            <td>
                                                @if($row->status == 1)
                                                <a href="{{ route('admin.subscribers.deactivate', $row->id) }}" class="btn btn-success font-weight-bold btn-xs btn-block has-ripple text-white">Enabled</a>
                                                @else
                                                <a href="{{ route('admin.subscribers.activate', $row->id) }}" class="btn btn-danger font-weight-bold btn-xs btn-block has-ripple text-white">Disabled</a>
                                                @endif
                                            </td>
                                        </tr> 
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>  
                </div>
            </div> 
        </div>  
        <!-- [ Main Content ] end -->
    </div>
</div>
@endsection
