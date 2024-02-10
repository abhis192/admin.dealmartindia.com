@extends('layouts.backend.app')

@section('title')
<title>Pincode | Admin</title>
@endsection

@section('css')
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">All Pincodes</h4>
                    <div class="page-title-right">
                        <a href="javascript:void(0);" data-href="{{ route('admin.pincode.create.index') }}" class="btn btn-primary waves-effect waves-light open-remote-modal">
                            <i class="fas fa-plus"></i> Add New Pincode
                        </a>
                        <a href="javascript:void(0);" class="btn btn-soft-success waves-effect waves-light" title="Import Pincode" data-bs-toggle="modal" data-bs-target="#importCSV"><i class="fas fa-file"></i> Import Pincode</a>
                    </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border">
                <div class="card-body">
                    <table id="data-table" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Pincode</th>
                                {{-- <th>Country</th> --}}
                                {{-- <th>State</th> --}}
                                <th>city</th>
                                <th width="180px;">Status</th>
                                <th width="180px;">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- container-fluid -->
</div>

<!-- [ Import CSV Modal ] start -->
<div id="importCSV" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.import.pincode.csv.process') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Import State</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-12 mb-2">
                            Choose CSV File <a href="{{ route('admin.pincode.import.csv.download.sample') }}" download>Download sample csv</a>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{-- <label class="col-from-label" for="amount">Product Name:</label> --}}
                                <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success waves-effect" type="submit">Import CSV</button>
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script type="text/javascript">
        $(function() {

            $('#data-table').on('change', '.change-status', function (e) {
                e.preventDefault();
                const { id } = $(this).data();
                $(this).prop('disabled', true);
                $.get(`{{ route("admin.pin_codes.change.status") }}/${id}`, () => reloadTable('data-table'));
            });

            $('#data-table').DataTable({
                ajax: '{{ route("admin.pincode.list") }}',
                stateSave: true, // Enable state saving

                dom: DT_DOM_OPTION,
                buttons: DT_BUTTONS_OPTION,

                columns: [
                    { data: 'pincode' },
                    { data: 'city', name: 'cities.name' },
                    {
                        data: null,
                        name: 'status',
                        className: 'text-center',
                        mRender: (data, type, row) => {
                            return `
                                <div class="square-switch">
                                    <input type="checkbox" id="status-switch-${row.id}" class="change-status" switch="status" data-id="${row.id}" ${row.status === 1 ? 'checked' : ''} />
                                    <label for="status-switch-${row.id}" data-on-label="Yes" data-off-label="No"></label>
                                </div>`;
                        }
                    },
                    {
                        data: null,
                        className: 'text-center',
                        mRender: (data, type, row) => {
                            return `
                                <a href="javascript:void(0);" data-href="{{ route('admin.pin_codes.update.index') }}/${row.id}" class="btn btn-soft-info btn-sm waves-effect waves-light open-remote-modal"><i class="bx bx-pencil font-size-16"></i></a>
                                <button type="button" class="btn btn-soft-danger btn-sm waves-effect waves-light delete-entry" data-href="{{ route("admin.pin_codes.delete") }}/${row.id}" data-tbl="data"><i class="bx bx-trash font-size-16"></i></button>`;
                        },
                        orderable: false,
                        searchable: false
                    }
                ],
            });
        });
    </script>

    <script>
        const DT_DOM_OPTION = '<"container-fluid"<"row"<"col-2"l><"col"B><"col"f>>>rtip';
        const DT_BUTTONS_OPTION = ['csv', 'excel', 'pdf', 'colvis'];

        // Default Datatables Options
        $.extend(true, $.fn.dataTable.defaults, {
            // scrollX: true,
            // scrollCollapse: true,
            // fixedColumns: true,
            stateSave: true,
            processing: true,
            serverSide: true,
            // dom: '<"container-fluid"<"row"<"col-1"l><"col"B><"col"f>>>rtip',
            // buttons: ['csv', 'excel', 'pdf', 'colvis'],
            lengthMenu: [ [10, 25, 50, 100, 500], ['10 Rows', '25 Rows', '50 Rows', '100 Rows', '500 Rows','1000 Rows'] ],
            // language: {
            //     url: '{{ url("assets/libs/datatables.net/language/english.json") }}',
            // },
        });

        // Http Errors
        const ajax_errors = {
            http_not_connected: "Not connected. Please verify your network connection.",
            request_forbidden: "Forbidden resource can not be accessed.",
            not_found_request: "Requested page not found. [404]",
            session_expire: "Session expired, please reload the page and try again.",
            service_unavailable: "Service unavailable.",
            parser_error: "Error.Parsing JSON Request failed.",
            request_timeout: "Request Time out",
            request_abort: "Request was aborted by the server."
        };

        $(document).on('click', 'a.open-remote-modal', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const target = $($(this).data('target') ?? '#remoteModal');

            target.modal('show');
            target.find('.modal-content')
                .html(`<div class="modal-body"><h4 style="margin: 0;"><i class="fa fa-spinner fa-pulse"></i> Please wait...</h4></div>`)
                .load($(this).data('href'));
        });

        $('#smRemoteModal, #remoteModal, #lgRemoteModal, #xlRemoteModal').on('hidden.bs.modal', () => toastr.remove());

        $('#data-table').on('click', '.delete-entry', async function(e) {
            e.preventDefault();
            const message = $(this).data('message') ?? 'Are you sure?';

            if (await confirmAlert(message)) {
                const href = $(this).data('href');
                const tbl = $(this).data('tbl');
                $.get( href, () => reloadTable(`${tbl}-table`));
            }
        });

        // await confirmAlert()
        async function confirmAlert(text = 'Are you sure?') {
            const { value: isAccepted } = await Swal.fire({
                text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-check"></i> Yes',
                cancelButtonText: '<i class="fa fa-times"></i> Cancel',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            });
            return isAccepted === true;
        }

        async function infoAlert(msg, icon = 'warning') {
            await Swal.fire({
                text: msg,
                icon, // warning, error, success, info, and question
                showCancelButton: false,
                confirmButtonText: '<i class="fa fa-check"></i> Okay',
                confirmButtonColor: '#3085d6',
            });
        }


        function showToastr(type = 'info', content = '<i class="fa fa-spinner fa-pulse"></i> Please wait...', title = '') {
            // type: warning, success, error, success

            const options = {
                closeButton: (type == 'info' ? false : true),
                progressBar: (type == 'info' ? false : true),
                newestOnTop: false,
                preventDuplicates: true,
                tapToDismiss: false,
                showDuration: 0,
                hideDuration: 300,
                timeOut: (type == 'info' ? 0 : 5000),
                extendedTimeOut: 5000,
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                positionClass: "toast-top-right",
                onclick: null,
                debug: false,
            };

            // toastr.clear();
            toastr.remove();

            eval(`toastr.${type}(content, title, options)`);
        }
    </script>
@endsection
