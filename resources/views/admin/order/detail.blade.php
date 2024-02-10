@extends('layouts.backend.app')

@section('title')
<title>Order Detail | Admin</title>
@endsection

@section('css')
@endsection

@section('content')

                <!--[ Page Content ] start -->
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- [ breadcrumb ] start -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <div class="page-title-left">
                                        <h4 class="mb-sm-0 font-size-18">ORD-{{$order->order_no}} <span class="badge badge-soft-danger font-size-14">{{$order->status->payment_status}}</span> <span class="badge badge-soft-primary font-size-14">{{$order->order_mode}} </span>  @if(!empty($order->source)) <span class="badge badge-soft-secondary font-size-14">{{$order->source}}</span> @endif </h4>
                                        <p class="m-0">{{\Carbon\Carbon::parse($order->date)->format('d M Y')}} at {{\Carbon\Carbon::parse($order->updated_at)->format('h:i A')}}</p>
                                    </div>
                                    <div class="page-title-right">
                                        <a href="{{route('admin.orders')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-reply-all"></i> Back to list</a>
                                        <a href="{{route('admin.order.invoice',$order->id)}}" class="btn btn-soft-primary waves-effect waves-light" title="Download Invoice"><i class="bx bx-download"></i> Download Invoice</a>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- [ Data ] start -->
                        <div class="row">
                            <div class="col-lg-8">

                                <!-- [ Ordered Products ] start -->
                                <div class="card border">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4 class="card-title mb-0">Ordered Products</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table border invoice-detail-table mb-0">
                                            <tbody>
                                                @foreach($order->orderItems as $item)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex">
                                                            @if($item->product!=null)
                                                            <img class="rounded avatar-sm me-1" src="{{asset('storage/product/'.$item->product->image)}}">
                                                            @else
                                                            <img class="rounded avatar-sm me-1" src="{{asset('storage/order/'.$item->image)}}">
                                                            @endif
                                                            {{-- <img class="rounded avatar-sm me-1" src="../assets/admin/images/product/1.jpg"> --}}
                                                            <div class="desc">
                                                                @if($item->product!=null)
                                                                {{-- <h6 class="m-0"><a href="{{route('product.detail', $item->product->slug)}}">{{$item->product->name}}</a></h6> --}}
                                                                <h6 class="m-0"><a href="#">{{$item->product->name}}</a></h6>
                                                                @else
                                                                <h6 class="m-0">{{$item->product_name}}</h6>
                                                                @endif

                                                                {{-- <span><b>500</b> G</span> --}}
                                                                <span><b>@if(!empty($item->qty_weight)) <span>{{$item->qty_weight}}</span>@endif <b>{{$item->qty_type}}</b></span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{$item->qty}}</td>
                                                    <td class="text-center">
                                                        @if($item->product!=null)
                                                        {{-- @if($item->discount > 0)
                                                        <del><i class="fas fa-rupee-sign"></i> {{$item->product->regular_price}}</del>
                                                        @else
                                                        <i class="fas fa-rupee-sign"></i> {{$item->product->regular_price}}
                                                        @endif --}}
                                                        {{-- <p class="text-decoration-line-through m-0"><i class="fas fa-rupee-sign"></i> {{$item->product->regular_price}}</p> --}}
                                                        <p class="text-decoration-line-through m-0"><i class="fas fa-rupee-sign"></i> {{($item->price) + ($item->discount)}}</p>
                                                        {{-- <p class="m-0"><i class="fas fa-rupee-sign"></i> {{$item->product->final_price}}</p> --}}
                                                        <p class="m-0"><i class="fas fa-rupee-sign"></i> {{$item->price}}</p>
                                                    @else
                                                        <p class="m-0"><i class="fas fa-rupee-sign"></i> {{$item->price}}</p>
                                                        @endif
                                                    </td>
                                                    @if($item->product!=null)
                                                    <td class="text-end"><i class="fas fa-rupee-sign"></i>{{$item->price}}</td>
                                                    @else
                                                    {{-- <td><i class="fas fa-rupee-sign"></i> 200.00</td> --}}
                                                    {{-- <td><i class="fas fa-rupee-sign"></i> {{orderSubTotal($order->orderItems) }}</td> --}}
                                                    <td class="text-end"><i class="fas fa-rupee-sign"></i> {{($item->price)*($item->qty)}}</td>
                                                    @endif
                                                </tr>

                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- <div class="card-footer text-end"></div>  -->
                                </div>

                                <!-- [ Payments ] start -->
                                <div class="card border">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4 class="card-title mb-0">Payments</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table border invoice-detail-table mb-0">
                                            <tfoot>
                                                {{-- @foreach($order->orderItems as $item) --}}
                                                <tr>
                                                    <th>Sub Total :</th>
                                                    <th></th>
                                                    {{-- <th class="text-end"><i class="fas fa-rupee-sign"></i> 500.00</th> --}}
                                                    <th class="text-end"><i class="fas fa-rupee-sign"></i> {{orderSubTotal($order->orderItems) - orderItemDiscount($order->orderItems) + orderItemsTax($order->orderItems)}}</th>
                                                </tr>

                                                <tr>
                                                    <th>Offer Discount :</th>
                                                    <th></th>
                                                    <th class="text-end text-warning"> - <i class="fas fa-rupee-sign"></i> {{orderItemDiscount($order->orderItems)}}</th>
                                                </tr>
                                                <tr>
                                                    <th>Coupon Discount :</th>
                                                    <th>[NY2023]</th>
                                                    <th class="text-end text-success"> - <i class="fas fa-rupee-sign"></i> {{orderItemCouponDiscount($order->orderItems)}}</th>
                                                </tr>
                                                <tr>
                                                    <th>Shipping Charges :</th>
                                                    <th>Early Morning Delivery(<i class="bx bx-rupee"></i>100.00)</th>
                                                    <th class="text-end text-danger">+ <i class="fas fa-rupee-sign"></i> {{$order->shipping_rate}}</th>
                                                </tr>
                                                <!-- <tr>
                                                    <th>Total Tax :</th>
                                                    <th colspan="1"></th>
                                                    <th class="text-danger"><i class="fas fa-rupee-sign"></i> 57.00</th>
                                                </tr> -->
                                                <tr class="text-info table-light">

                                                    <th>
                                                        <h5 class="text-primary mb-0">Grand Total :</h5>
                                                    </th>
                                                    <th colspan="1"></th>
                                                    <th>
                                                        <h5 class="text-end text-primary mb-0"><i class="fas fa-rupee-sign"></i> {{orderItemGrandTotal($order)}}</h5>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="card-footer text-center">
                                        <p class="text-success bold m-0">Inclusive of all taxes and Charges.</p>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-4">

                                <!-- [ Order Traking History ] start -->
                                <div class="card border">
                                    <form action="#">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="card-title mb-0">Order History</h4>
                                            <a href="javascript:void(0);" class="btn btn-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#addData">Change Status </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="order-traking-timeline">
                                                <ul class="verti-timeline list-unstyled">
                                                    <li class="event-list {{checkStatusProgressActive($order,'Delivered')}}">
                                                        <div class="event-timeline-dot">
                                                            <i class="bx bx-right-arrow-circle {{checkStatusProgressFade($order,'Delivered')}}"></i>
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1">
                                                                <div>
                                                                    <h5 class="m-0">Delivered</h5>
                                                                    <p class="mb-1">{{ checkStatusProgressDate($order,'Delivered')}}</p>
                                                                    {{-- <p class="text-muted">Sed ut perspiciatis unde omnis iste natus error sit voluptatem.</p> --}}
                                                                    <p class="text-muted">{{checkStatusProgressComment($order,'Delivered')}}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="event-list {{checkStatusProgressActive($order,'Out For Delivery')}}">
                                                        <div class="event-timeline-dot">
                                                            <i class="bx bx-right-arrow-circle {{checkStatusProgressFade($order,'Out For Delivery')}}"></i>
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1">
                                                                <div>
                                                                    <h5 class="m-0">Out for Delivery</h5>
                                                                    <p class="mb-1">{{ checkStatusProgressDate($order,'Out For Delivery')}}</p>
                                                                    <p class="text-muted">{{checkStatusProgressComment($order,'Out For Delivery')}}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="event-list {{checkStatusProgressActive($order,'Ready To Ship')}}">
                                                        <div class="event-timeline-dot">
                                                            <i class="bx bx-right-arrow-circle {{checkStatusProgressFade($order,'Ready To Ship')}}"></i>
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1">
                                                                <div>
                                                                    <h5 class="m-0">Ready to Ship</h5>
                                                                    <p class="mb-1">{{ checkStatusProgressDate($order,'Ready To Ship')}}</p>
                                                                    <p class="text-muted">{{checkStatusProgressComment($order,'Ready To Ship')}}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <li class="event-list {{checkStatusProgressActive($order,'In Progress')}}">
                                                        <div class="event-timeline-dot">
                                                            <i class="bx bx-right-arrow-circle {{checkStatusProgressFade($order,'In Progress')}}"></i>
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1">
                                                                <div>
                                                                    <h5 class="m-0">In Progress</h5>
                                                                    <p class="mb-1">{{ checkStatusProgressDate($order,'In Progress')}}</p>
                                                                    <p class="text-muted">{{checkStatusProgressComment($order,'In Progress')}}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <li class="event-list {{checkStatusProgressActive($order,'Pending')}}">
                                                        <div class="event-timeline-dot">
                                                            <i class="bx bx-right-arrow-circle {{checkStatusProgressFade($order,'Pending')}}"></i>
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1">
                                                                <div>
                                                                    <h5 class="m-0">Pending</h5>
                                                                    <p class="mb-1">{{ checkStatusProgressDate($order,'Pending')}}</p>
                                                                    <p class="text-muted">{{checkStatusProgressComment($order,'Pending')}}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end"></div>
                                    </form>
                                </div>

                                <!-- [ Billing Information ] start -->
                                @if(!empty($order->address))
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Billing Information</h4>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table class="table table-striped m-0">
                                                    <tbody>
                                                        <tr>
                                                            <th>Name:</th>
                                                            <td>{{$order->address->name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Email Id:</th>
                                                            <td>{{$order->address->email}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Contact Number:</th>
                                                            <td>{{$order->address->mobile}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Address:</th>
                                                            <td>{{$order->address->address}}. {{$order->address->landmark}}-{{$order->address->pincode}}, {{$order->address->city}},{{$order->address->state}} {{$order->address->country}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- [ Delivery Information ] start -->
                                @if(!empty($order->delivery_id))
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Delivery Information</h4>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table class="table table-striped m-0">
                                                    <tbody>
                                                        <tr>
                                                            <th>Delivery Date:</th>
                                                            <td>{{$order->delivery->delivery_date}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Delivery Type:</th>
                                                            <td>{{$order->delivery->delivery_type}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Delivery Time:</th>
                                                            <td>{{$order->delivery->delivery_time}}</td>
                                                        </tr>
                                                        {{-- <tr>
                                                            <th>Address:</th>
                                                            <td>{{$order->address->address}}. {{$order->address->landmark}}-{{$order->address->pincode}}, {{$order->address->city}},{{$order->address->state}} {{$order->address->country}}</td>
                                                        </tr> --}}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- [ Assign Kitchens ] start -->
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4 class="card-title mb-0">Assigned Kitchen</h4>
                                        <a href="javascript:void(0);" class="btn btn-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#assignKitchen" title="Assign Kitchen"> <i class="bx bx-user-plus"></i> Assign Kitchen</a>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table class="table table-striped m-0">
                                                    <tbody>
                                                        <tr>
                                                            <th>Kitchen Name:</th>
                                                            <td>
                                                                @if(!empty($order->orderItems->seller_id))
                                                                <p class="m-0">{{$order->orderItems->first()->seller->name}}</p>
                                                                {{-- <p class="m-0">[Aisha Bekary]</p> --}}
                                                                <p class="m-0">[{{$order->orderItems->first()->seller->business}}]</p>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <?php //include('include/footer.php'); ?>

            </div>
        </div>

        <!-- [ Add Data Modal ] start -->
        <div id="addData" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <form method="POST" action="{{route('admin.order.status',$order->id)}}">
                @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Change Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Payment Status:</label>
                                    <select class="form-control" name="payment_status" required>
                                        <option value="">Select</option>
                                        <option value="paid" {{$order->status->payment_status == 'paid' ? 'selected' : ''}}>Paid</option>
                                        <option value="unpaid" {{$order->status->payment_status == 'unpaid' ? 'selected' : ''}}>Unpaid</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Delivery Status:</label>
                                    <select class="form-control" name="order_status" required>
                                        <option value="">Select Delivery Status</option>
                                        <option value="Pending" {{$order->status->order_status == 'Pending' ? 'selected' : ''}}>Pending</option>
                                        <option value="In Progress" {{$order->status->order_status == 'In Progress' ? 'selected' : ''}}>In Progress</option>
                                        <option value="Ready To Ship" {{$order->status->order_status == 'Ready To Ship' ? 'selected' : ''}}>Ready To Ship</option>
                                        {{-- <option value="Dispatched" {{$order->status->order_status == 'Dispatched' ? 'selected' : ''}}>Dispatched</option> --}}
                                        <option value="Out For Delivery" {{$order->status->order_status == 'Out For Delivery' ? 'selected' : ''}}>Out For Delivery</option>
                                        <option value="Delivered" {{$order->status->order_status == 'Delivered' ? 'selected' : ''}}>Delivered</option>
                                        @if($order->status->order_status != 'Delivered')
                                            <option value="Cancelled By Admin" {{$order->status->order_status == 'Cancelled By Admin' ? 'selected' : ''}}>Cancelled By Admin</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Tracking Code (optional):</label>
                                    <input type="text" id="name" class="form-control" placeholder="Enter Tracking Code..." required/>
                                </div>
                            </div> --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="description" class="form-label">Description:</label>
                                    <textarea name="comment" id="description" class="form-control" placeholder="Write somthing..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                    <div class="modal-footer">
                        {{-- <button id="createBtn" type="button" class="btn btn-success waves-effect waves-light">Save Changes</button> --}}
                        <input type="submit" value="Save Changes" class="btn btn-success waves-effect waves-light" />
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

          <!-- [ Add Data Modal ] start -->
          <div id="assignKitchen" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <form method="POST" action="{{route('admin.order.seller',$orderItem->id)}}">
                @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel" >Assign Kitchen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Select Kitchen:</label>
                                    <select name="seller_id" class="form-control">
                                        <option>Choose Kitchen</option>
                                        @foreach($sellers as $seller)
                                            <option value="{{$seller->id}}">{{$seller->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button id="createBtn" type="button" class="btn btn-success waves-effect waves-light">Save Changes</button> --}}
                        <input type="submit" value="Save Changes" class="btn btn-success waves-effect waves-light" />
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        @endsection
        <?php //include('include/right-sidebar.php'); ?>
        <?php //include('include/script.php'); ?>


@section('script')
        <script>
            document.querySelector('.btn-print-invoice').addEventListener('click', function () {
                var link2 = document.createElement('link');
                link2.innerHTML =
                    '<style>@media print{*,::after,::before{text-shadow:none!important;box-shadow:none!important}.pcoded-main-container{margin-left:0px;}a:not(.btn){text-decoration:none}abbr[title]::after{content:" ("attr(title) ")"}pre{white-space:pre-wrap!important}blockquote,pre{border:1px solid #adb5bd;page-break-inside:avoid}thead{display:table-header-group}img,tr{page-break-inside:avoid}h2,h3,p{orphans:3;widows:3}h2,h3{page-break-after:avoid}@page{size:a3}body{min-width:992px!important}.container{min-width:992px!important}.page-header,.pc-sidebar,.pc-mob-header,.pc-header,.pct-customizer,.modal,.pcoded-navbar,.print-btn{display:none}.pc-container{top:0;}.invoice-contact{padding-top:0;}@page,.card-body,.card-header,body,.pcoded-content{padding:0;margin:0}.badge{border:1px solid #000}.table{border-collapse:collapse!important}.table td,.table th{background-color:#fff!important}.table-bordered td,.table-bordered th{border:1px solid #dee2e6!important}.table-dark{color:inherit}.table-dark tbody+tbody,.table-dark td,.table-dark th,.table-dark thead th{border-color:#dee2e6}.table .thead-dark th{color:inherit;border-color:#dee2e6}}</style>';

                document.getElementsByTagName('head')[0].appendChild(link2);
                window.print();
            })
        </script>

@endsection
    {{-- </body> --}}
