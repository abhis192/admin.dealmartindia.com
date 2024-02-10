@extends('layouts.backend.app')

@section('title')
<title>Payouts | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">All Payouts</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">All Payouts</li>
                        </ol> 
                    </div>

                </div>
            </div>
        </div> 
        <!-- [ breadcrumb ] end -->
        <div class="row">  
            <div class="col-xl-12">
                <div class="card border"> 
                    <!-- <div class="card-header"></div> -->
                    <div class="card-body"> 

                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="col-1">#</th> 
                                    <th>Amount</th> 
                                    <th>Payment Method</th>
                                    <th>Created At</th>
                                </tr>
                            </thead> 
                            
                            <tbody>
                                @foreach($payouts as $key => $payout)
                                <tr> 
                                    <td>{{$key+1}}</td>
                                    <td>
                                        <b><i class="bx bx-rupee"></i>{{$payout->requested_amt}}.00</b>
                                    </td>  
                                    <td>
                                        @if($payout->status == "Pending")
                                        <span class="badge badge-soft-warning font-size-14">{{$payout->status}}</span>
                                        @elseif($payout->status == "Successful")
                                        <span class="badge badge-soft-success font-size-14">{{$payout->status}}</span>
                                        @else
                                        <span class="badge badge-soft-danger font-size-14">{{$payout->status}}</span>
                                        @endif
                                    </td>
                                    <td>{{$payout->created_at}}</td>
                                </tr> 
                                @endforeach 
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div> <!-- end col -->

        </div>
        
    </div>
    <!-- container-fluid -->
</div> 
@endsection
