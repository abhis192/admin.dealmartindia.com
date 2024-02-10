<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Abhisan Technology" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('title')
    @include('layouts.backend.partials.style')
    @yield('css')
    <style type="text/css">
        .btn-toggle{--bs-btn-border-color: none !important;}
    </style>
</head>

<body data-sidebar="dark" data-layout-mode="light">

    <div id="layout-wrapper">

        @include('layouts.backend.partials.header')
        @include('layouts.backend.partials.sidenav')

        <!--[ Main Content ] start -->
        <div class="main-content">

            @yield('content')

            @include('layouts.backend.partials.footer')

        </div>
    </div>


    <!-- Remote Modals -->
    <div id="smRemoteModal" class="modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content"></div>
        </div>
    </div>
    <div id="remoteModal" class="modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <div id="lgRemoteModal" class="modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>
    <div id="xlRemoteModal" class="modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content"></div>
        </div>
    </div>


    @include('layouts.backend.partials.drawer')
    @include('layouts.backend.partials.script')

    <script type="text/javascript">
        function slug_url(get,id){
            var  data=$.trim(get);
            var string = data.replace(/[^A-Z0-9]/ig, '-')
                .replace(/\s+/g, '-') // collapse whitespace and replace by -
                .replace(/-+/g, '-'); // collapse dashes;
            var finalvalue=string.toLowerCase();
            document.getElementById(id).value=finalvalue;
        }

        setTimeout(function () {
            $(".alert").fadeOut();
        }, 3000);
    </script>

    @php
        $statusMessage = '';
        if (session()->get('success')) {
            $statusMessage=session()->get('success');
        } elseif (session()->get('error')) {
            $statusMessage=session()->get('error');
        } elseif (session()->get('failure')) {
            $statusMessage=session()->get('failure');
        }
    @endphp

    @if(session()->get('success'))
        <script>
            Command: toastr["success"]('<?php echo $statusMessage; ?>')

            toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": 300,
            "hideDuration": 1000,
            "timeOut": 5000,
            "extendedTimeOut": 1000,
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
            }
        </script>
    @endif
    @if (session('error') || session('failure'))
        <script>
            Command: toastr["error"]('<?php echo $statusMessage; ?>')

            toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": 300,
            "hideDuration": 1000,
            "timeOut": 5000,
            "extendedTimeOut": 1000,
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
            }

            $.extend(true, $.fn.dataTable.defaults, {
                    // scrollX: true,
                    // scrollCollapse: true,
                    // fixedColumns: true,
                    stateSave: true,
                    processing: true,
                    serverSide: true,
                    // dom: '<"container-fluid"<"row"<"col-1"l><"col"B><"col"f>>>rtip',
                    // buttons: ['csv', 'excel', 'pdf', 'colvis'],
                    lengthMenu: [ [10, 25, 50, 100], ['10 Rows', '25 Rows', '50 Rows', '100 Rows'] ],
                    language: {
                        url: '{{ url("assets/libs/datatables.net/language/english.json") }}',
                    },
                });

        </script>
    @endif
    @yield('script')
</body>
</html>
