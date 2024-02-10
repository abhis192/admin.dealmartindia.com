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
                            <li class="breadcrumb-item"><a href="#">Subscriber</a></li>  
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
                                            <th>Subscriber</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subscribers as $index => $subscriber)
                                        <tr>
                                            <td>{{$index+1}}</td>  
                                            <td>{{$subscriber->email}}</td>
                                        </tr>
                                        @endforeach
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

@section('script')
<script>
    // DataTable start
    $('#report-table').DataTable();  
</script>
@endsection
