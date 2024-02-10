@extends('layouts.frontend.customerapp')

@section('title')
<title>Address | {{env('APP_NAME')}}</title>
@endsection

@section('css')
@endsection

@section('content')
<div id="page-content">

    <!-- [ Breadcrumbs ] start -->
    <div class="breadcrumbs-wrapper text-uppercase">
        <div class="container">
            <div class="breadcrumbs">
            <a href="{{URL('/')}}" title="Back to the home page">Home</a><span>|</span>
                <a href="">Dashboard</a><span>|</span>
                <span class="fw-bold">My Orders</span>
            </div>
        </div>
    </div>

    <section class="my-address-main">
        <div class="container pt-2">
            {{-- @include('layouts.frontend.partials.customerHeader') --}}

            <div class="row mb-4 mb-lg-5 pb-lg-5">
                <div class="col-xl-3 col-lg-2 col-md-12 mb-4 mb-lg-0 d-none d-lg-block">
                    @include('layouts.frontend.partials.customerSidebar')
                </div>

                <div class="col-xl-9 col-lg-10 col-md-12">
                    <!-- [Address Main] Start -->
                    <div class="dashboard-content p-0 border-0">
                        <div class="card user-address border">
                            <div class="card-header border-bottom">
                                <h3 class="mb-0">Address</h3>
                                <p class="xs-fon-13 m-0">The following addresses will be used on the checkout page by default.</p>
                            </div>
                            <div class="card-body">
                                @if($addresses->count())
                                    <div class="row row-cols-1 row-cols-lg-2">
                                        @foreach($addresses as $address)
                                        <div class="col">
                                            <div class="card-wrap border rounded mb-4">
                                                <div class="card-header px-3 py-2 br-bottom d-flex align-items-center justify-content-between">
                                                    <div class="card-header-flex d-flex align-items-center">
                                                        <h4 class="fs-md ft-bold mb-0">
                                                            <label for="pa1" class="radio-custom-label mb-0">{{$address->label}}</label>
                                                        </h4>
                                                        @if($address->default == 1)
                                                        <p class="m-0 p-1"><span class="text-success bg-success bg-opacity-25 px-2 py-1">Primary Account</span></p>
                                                        @endif
                                                    </div>
                                                    <div class="card-head-last-flex">
                                                        <a class="text-primary bg-primary bg-opacity-25 p-3 d-inline-flex align-items-center justify-content-center" data-bs-toggle="offcanvas" data-bs-target="#updateAddress{{$address->id}}" aria-controls="updateAddress" data-address-id="{{ $address->id }}"><i class="bi bi-pencil-square position-absolute"></i></a>

                                                        <a href="javascript:void(0);" class="text-danger bg-danger bg-opacity-25 p-3 d-inline-flex align-items-center justify-content-center sa-delete" title="Delete Address" data-id="{{ $address->id }}" data-link="/customer/address/destroy/"><i class="bi bi-x-lg position-absolute"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card-wrap-body px-3 py-3">
                                                    <h5 class="ft-medium mb-1">{{$address->name}}</h5>
                                                    <p class="text-muted">{{$address->address}}<br>{{$address->city}}, {{$address->pincode}}<br>{{$address->country}}</p>
                                                    <p class="lh-1 mt-2 text-muted"><span class="text-dark ft-medium">Email:</span> {{$address->email}}</p>
                                                    <p class="text-muted mt-2"><span class="text-dark ft-medium">Call:</span> {{$address->mobile}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col">
                                            <h3 class="text-danger pb-3">No Address Found!!</h3>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary w-100" type="button" data-bs-toggle="offcanvas" data-bs-target="#addAddress" aria-controls="addAddress"><i class="bi bi-plus me-2"></i>Add New Address</button>
                            </div>
                        </div>
                        <!-- End Address -->
                    </div>
                </div>
            </div>
            <!--End Main Content-->
        </div>
    </section>

</div>
@endsection
