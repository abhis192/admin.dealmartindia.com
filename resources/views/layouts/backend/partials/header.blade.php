<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex align-items-center">
            <!--[ Logo ] start -->
            <div class="navbar-brand-box">
                <a href="{{route('admin.dashboard')}}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{asset('assets/admin/images/logo.svg')}}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('assets/admin/images/logo-dark.png')}}" alt="" height="32">
                    </span>
                </a>

                <a href="{{route('admin.dashboard')}}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{asset('assets/admin/images/logo-light.svg')}}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('assets/admin/images/logo-light.png')}}" alt="" height="32">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
            <!-- <div class="clear-cache">
                <a href="#" class="btn btn-md btn-soft-danger waves-effect waves-light" id="vertical-menu-btn">
                    <i class="bx bx-hdd"></i> Clear Cache
                </a>
            </div> -->
        </div>

        <div class="d-flex">

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <a href="{{URL('/')}}" class="btn header-item noti-icon waves-effect d-flex align-items-center" target="_blank">
                    <i class="bx bx-globe"></i>
                </a>
            </div>

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="bx bx-fullscreen"></i>
                </button>
            </div>

            <!-- <div class="dropdown d-inline-block d-none">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-bell bx-tada"></i>
                    <span class="badge bg-danger rounded-pill">3</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0" key="t-notifications"> Notifications </h6>
                            </div>
                            <div class="col-auto">
                                <a href="#!" class="small" key="t-view-all"> View All</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        <a href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                        <i class="bx bx-cart"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1" key="t-your-order">Your order is placed</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1" key="t-grammer">If several languages coalesce the grammar</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago">3 min ago</span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title bg-success rounded-circle font-size-16">
                                        <i class="bx bx-badge-check"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1" key="t-shipped">Your item is shipped</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1" key="t-grammer">If several languages coalesce the grammar</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago">3 min ago</span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                            <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View More..</span>
                        </a>
                    </div>
                </div>
            </div> -->

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{asset('assets/admin/images/avatar.png')}}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ Auth::user()->name }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    @if(Auth::user()->role_id == 1)
                        <a class="dropdown-item" href="{{route('admin.profile')}}"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
                    @else
                        <a class="dropdown-item" href="{{route('seller.profile')}}"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
                    @endif
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="bx bx-cog bx-spin"></i>
                </button>
            </div>

        </div>
    </div>
</header>
