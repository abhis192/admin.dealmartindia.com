<div id="create-pincode-wrapper">
    <div class="modal-header">
        <h5 class="modal-title">Add Pincode</h5>
        <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form id="addFrm">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="name" class="form-label">Pincode <sup class="text-danger fs-5">*</sup> :</label>
                        <input type="text" name="pincode" id="name" class="form-control" placeholder="Enter Pincode"/>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="city" class="form-label">City <sup class="text-danger fs-5">*</sup> :</label>
                        <select class="form-control" name="city" id="city" data-placeholder="Choose city">
                            <option value=""></option>
                            @if ($cities->isNotEmpty())
                                @foreach ($cities as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="name" class="form-label fw-bold">Status <sup class="text-danger fs-5">*</sup> :</label>
                        <div class="square-switch">
                            <input type="checkbox" id="square-status" switch="status" name="status" value="1" checked />
                            <label for="square-status" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer text-right">
        <button id="createBtn" type="button" class="btn btn-success waves-effect waves-light">Save Changes</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</div>

<script>
    initSelect2Custom('#create-pincode-wrapper [name="city"]', '#create-pincode-wrapper');

    $('#create-pincode-wrapper').on('click', '#createBtn', function (e) {
        e.preventDefault();
        const $btn = $(this);

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: "{{ route('admin.pincode.create') }}",
            data: $('#addFrm').serialize(),
            beforeSend: () => {
                $btn.attr('disabled', true);
                showToastr();
            },
            error: (jqXHR, exception) => {
                $btn.attr('disabled', false);
                showToastr('error', formatErrorMessage(jqXHR, exception));
            },
            success: response => {
                $btn.attr('disabled', false);
                showToastr('success', response.message);
                reloadTable('data-table');
                $('#create-pincode-wrapper .close').click();
            }
        });
    });
</script>
