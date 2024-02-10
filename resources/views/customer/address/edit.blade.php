@extends('layouts.frontend.customerapp')

@section('title')
<title>Edit Address | {{env('APP_NAME')}}</title>
@endsection

@section('css')
@endsection

@section('content')
<section class="my-address-main">
    <div class="container pt-2">
        @include('layouts.frontend.partials.customerHeader')
        
        <div class="row mb-4 mb-lg-5 pb-lg-5">
            <div class="col-xl-3 col-lg-2 col-md-12 mb-4 mb-lg-0">
                @include('layouts.frontend.partials.customerSidebar')
            </div>

            <div class="col-xl-9 col-lg-10 col-md-12">
                <!-- [Address Main] Start -->
                <div class="dashboard-content p-0 border-0"> 
                    <div class="card user-address border"> 
                        <div class="card-header border-bottom">
                            <h3 class="mb-0">Edit Address</h3>
                            <p class="xs-fon-13 m-0">The following addresses will be used on the checkout page by default.</p>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{route('customer.address.update', $address->id)}}">
                                @method('PATCH')
                                @csrf
                                <div class="offcanvas-body">
                                    <div class="type-address">
                                        <h3 class="fs-md ft-bold">Type of address</h3>

                                        <div class="d-flex mb-2">
                                            <div class="me-3 d-flex align-items-center mb-2">
                                                <input class="radio_animated" type="radio" name="label" id="Home" value="home" {{ $address->label == 'home' ? "checked" : "" }}>
                                                <label for="Home" class="ms-2 mt-2">Home</label>
                                            </div>
                                            <div class="me-3 d-flex align-items-center mb-2">
                                                <input class="radio_animated" type="radio" name="label" id="office" value="office" {{ $address->label == 'office' ? "checked" : "" }}>
                                                <label for="office" class="ms-2 mt-2">Office</label>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input class="radio_animated" type="radio" name="label" id="others" value="others" {{ $address->label == 'others' ? "checked" : "" }}>
                                                <label for="others" class="ms-2 mt-2">Others</label>
                                            </div>
                                            @error('label')
                                                <div class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="m-0">
                                    <div class="clearfix" style="margin-bottom: 30px;"></div>
                                    <div class="row align-items-center justify-content-start">

                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="one" placeholder="Full Name" value="{{$address->name}}" required>
                                            </div>
                                            @error('name')
                                                <div class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <input name="mobile" type="number" class="form-control @error('mobile') is-invalid @enderror" id="two" placeholder="Mobile Number" value="{{$address->mobile}}" required>
                                            </div>
                                            @error('mobile')
                                                <div class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="three" placeholder="Email" value="{{$address->email}}" required>
                                            </div>
                                            @error('email')
                                                <div class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <input name="pincode" type="number" class="form-control @error('pincode') is-invalid @enderror" id="three" placeholder="Pin Code" value="{{$address->pincode}}" required>
                                            </div>
                                            @error('pincode')
                                                <div class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <input name="address" type="text" class="form-control @error('address') is-invalid @enderror" id="four" placeholder="flat, house No., building.." value="{{$address->address}}" required>
                                            </div>
                                            @error('address')
                                                <div class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <input name="landmark" type="text" class="form-control @error('landmark') is-invalid @enderror" id="six" placeholder="landmark" value="{{$address->address}}">
                                            </div>
                                            @error('landmark')
                                                <div class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <input name="city" type="text" class="form-control @error('city') is-invalid @enderror" id="seven" placeholder="town/city" value="{{$address->city}}" required>
                                            </div>
                                            @error('city')
                                                <div class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <select name="state" class="form-select @error('state') is-invalid @enderror" id="floatingSelect1" aria-label="Floating label select example" required>
                                                    <option value="delhi">Delhi</option>
                                                    <option value="up">UP</option>
                                                    <option value="mp">MP</option>
                                                </select>
                                            </div>
                                            @error('state')
                                                <div class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <select name="country" class="form-select @error('country') is-invalid @enderror" id="floatingSelect" aria-label="Floating label select example" required>
                                                    <option selected value="india">India</option>
                                                    <option value="austrlia">Austrlia</option>
                                                    <option value="new zealand">New Zealand</option>
                                                </select>
                                            </div>
                                            @error('country')
                                                <div class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-lg-12 form-floating">
                                            <div class="form-group mb-3 d-flex">
                                                <input id="b1" class="checkbox-custom" name="default" type="checkbox" {{ $address->default == 1 ? "checked" : "" }}>
                                                <label for="b1" class="checkbox-custom-label ms-2 mt-1">Mark as Default</label>
                                            </div>
                                            @error('default')
                                                <div class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-default text-capitalize w-40 w-lg-auto">Submit New Address</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End Address -->
                </div> 
            </div>
        </div>
        <!--End Main Content-->
    </div>
</section>
@endsection