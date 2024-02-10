@extends('layouts.frontend.customerapp')

@section('title')
<title>My Account | {{env('APP_NAME')}}</title>
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
                <span class="fw-bold">My Acoount</span>
            </div>
        </div>
    </div>

    <!-- [ Main Content ] start -->
    <section class="my-account-main">
        <div class="container pt-2">
            {{-- @include('layouts.frontend.partials.customerHeader') --}}

            <div class="row justify-content-center mt-3">
                <div class="col-lg-4">
                    <!-- Nav tabs -->
                    @include('layouts.frontend.partials.customerSidebar')
                    <!-- End Nav tabs -->
                </div>
            </div>
            <!--End Main Content-->
        </div>
    </section>

</div>
@endsection
