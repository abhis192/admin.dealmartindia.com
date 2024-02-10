@extends('layouts.backend.app')

@section('title')
<title>View Profile | Admin</title>
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
                    <h4 class="mb-sm-0 font-size-18">View Seller Profile</h4>

                    <div class="page-title-right"> 
                        <a href="{{route('admin.unverified-sellers')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-reply-all"></i> Back to list</a>
                    </div>

                </div>
            </div>
        </div> 
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-xl-4">
                <div class="card overflow-hidden">
                    <div class="{{$user->seller_verified_at == null ? 'bg-danger' : 'bg-success'}} bg-soft">
                        <div class="row">
                            <div class="col-12 text-end">
                                <div class="p-3">
                                    <span class="badge badge-pill {{$user->seller_verified_at == null ? 'badge-soft-danger' : 'badge-soft-success'}} font-size-12 p-2 border w-md">
                                        {{$user->seller_verified_at == null ? 'Account is Not Verified' : 'Account is Verified'}}
                                    </span>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="card-header pt-0"> 
                        <div class="row">
                            <div class="col-3">
                                <div class="avatar-md profile-user-wid">
                                    <img src="{{asset('storage/user/'.$user->avatar)}}" alt="" class="img-thumbnail rounded-circle">
                                </div> 
                            </div>

                            <div class="col">
                                <div class="">  
                                    <h5 class="font-size-15 text-truncate m-0">{{$user->name}}</h5>
                                    <p class="text-muted mb-0 text-truncate">[{{$user->business}}]</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0"> 
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-striped m-0"> 
                                    <tbody>
                                        <tr>
                                            <td>Email Id</td>
                                            <td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                                        </tr> 
                                        <tr>
                                            <td>Contact Number</td>
                                            <td><a href="tel:{{$user->mobile}}">{{$user->mobile}}</a></td>
                                        </tr> 
                                        <tr>
                                            <td>DOB</td>
                                            <td>{{$user->dob}}</td>
                                        </tr>
                                        <tr>
                                            <td>Gender</td>
                                            <td>{{$user->gender}}</td>
                                        </tr> 
                                        <tr>
                                            <td>Address</td>
                                            <td>{{$user->address}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="col-xl-8">

                <div class="row">
                    <div class="col-md-6">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Total Earned Amount</p>
                                        <h4 class="mb-0"><i class="bx bx-rupee"></i>{{number_format($user->total_earned_amt,2)}}</h4>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                            <span class="avatar-title">
                                                <i class="bx bx-archive-in font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Remain Earned Amount</p>
                                        <h4 class="mb-0"><i class="bx bx-rupee"></i>{{number_format($user->wallet_balance,2)}}</h4>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                            <span class="avatar-title">
                                                <i class="bx bx-archive-in font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Total Withdraw Amount</p>
                                        <h4 class="mb-0"><i class="bx bx-rupee"></i>{{number_format($user->withdraw_amt,2)}}</h4>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center ">
                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="bx bx-copy-alt font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="col-md-6">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Requested Amount</p>
                                        <h4 class="mb-0"><i class="bx bx-rupee"></i>{{number_format($user->requested_amt,2)}}</h4>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center ">
                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="bx bx-copy-alt font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="col-md-12">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Total Sale Amount</p>
                                        <h4 class="mb-0"><i class="bx bx-rupee"></i>{{number_format($user->total_sale_amt,2)}}</h4>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                            <span class="avatar-title">
                                                <i class="bx bx-archive-in font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row --> 
                
                <!--[ Bank Account Details ] start --> 
                <div class="card border"> 
                    <div class="card-header"> 
                        <h4 class="card-title mb-0">Bank Account Details</h4> 
                    </div>
                    <div class="card-body">  
                        <div class="row"> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Account Holder Name:</label>
                                    <input type="text" class="form-control" value="{{$user->bank->holders_name??old('holders_name')}}" disabled/> 
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Account Number:</label>
                                    <input type="text" class="form-control" value="{{$user->bank->account_no??old('account_no')}}" disabled/>
                                </div>
                            </div> 

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="name" class="form-label">Bank Name:</label>
                                    <input type="text" class="form-control" value="{{$user->bank->bank_name??old('bank_name')}}" disabled/> 
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="name" class="form-label">IFSC Code:</label>
                                    <input type="text" class="form-control" value="{{$user->bank->ifsc_code??old('ifsc_code')}}" disabled/> 
                                </div>
                            </div> 
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="name" class="form-label">Branch Name:</label>
                                    <input type="text" class="form-control" value="{{$user->bank->branch_name??old('branch_name')}}" disabled/>
                                </div>
                            </div>
                        </div> 
                    </div> 
                </div> 
                
                <!--[ UPI Details ] start --> 
                <div class="card border"> 
                    <div class="card-header"> 
                        <h4 class="card-title mb-0">UPI Details</h4> 
                    </div>
                    <div class="card-body">  
                        <div class="row"> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">UPI Holder Name:</label>
                                    <input type="text" class="form-control" value="{{$user->upi->upi_name??old('upi_name')}}" disabled/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">UPI ID:</label>
                                    <input type="text" class="form-control" value="{{$user->upi->upi_id??old('upi_id')}}" disabled/>
                                </div>
                            </div>  
                        </div> 
                    </div>  
                </div> 

                <!--[ GST Details ] start --> 
                <div class="card border"> 
                    <div class="card-header"> 
                        <h4 class="card-title mb-0">GST Details</h4> 
                    </div>
                    <div class="card-body">  
                        <div class="row"> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">GST Registered Name:</label>
                                    <input type="text" class="form-control" value="{{$user->gst_name??old('gst_name')}}" disabled/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">GST Number:</label>
                                    <input type="text" class="form-control" value="{{$user->gst_no??old('gst_no')}}" disabled/>
                                </div>
                            </div>  
                        </div> 
                    </div>  
                </div> 

                <!--[ Legal Documents ] start --> 
                <div class="card border"> 
                    <div class="card-header"> 
                        <h4 class="card-title mb-0">Legal Documents</h4> 
                    </div>
                    <div class="card-body">  
                        <div class="row row-cols-2 row-cols-lg-3">
                            @foreach($user->legals as $legal)
                            <div class="col">
                                <div class="document-box border text-center"> 
                                    <a class="image-popup-no-margins" href="{{asset('storage/documents/'.$legal->image)}}" title="Document 1">
                                        <img class="img-fluid" src="{{asset('storage/documents/'.$legal->image)}}" /> 
                                    </a>
                                    <!-- <h5 class="content-title bg-gray p-2 m-0">GST</h5> -->
                                </div>
                            </div>
                            @endforeach
                        </div> 
                    </div>  
                </div> 

            </div>
        </div>
        <!-- end row -->
        
        
    </div>
    <!-- container-fluid -->
</div> 
@endsection

@section('script')
<!-- Magnific Popup-->
<script src="../assets/admin/libs/magnific-popup/jquery.magnific-popup.min.js"></script>

<!-- lightbox init js-->
<script src="../assets/admin/js/pages/lightbox.init.js"></script>
@endsection
