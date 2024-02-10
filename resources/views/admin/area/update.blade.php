<div id="update-area-wrapper">
    <div class="modal-header">
        <h5 class="modal-title">Edit Pincode</h5>
        <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form id="updateFrm">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="name" class="form-label">Area <sup class="text-danger fs-5">*</sup> :</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Area" value="{{ $area->name }}" />
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="country" class="form-label">Country <sup class="text-danger fs-5">*</sup> :</label>
                        <select class="form-control" name="country" id="country" data-placeholder="Choose Country">
                            <option value=""></option>
                            @if ($countries->isNotEmpty())
                                @foreach ($countries as $row)
                                    <option value="{{ $row->id }}" {{ $area->country_id == $row->id ? 'selected' : '' }}>{{ $row->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="state" class="form-label">State <sup class="text-danger fs-5">*</sup> :</label>
                        <select class="form-control" name="state" id="state" data-placeholder="Choose State">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="city" class="form-label">City <sup class="text-danger fs-5">*</sup> :</label>
                        <select class="form-control" name="city" id="city" data-placeholder="Choose City">
                            <option value=""></option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="pincode" class="form-label">Pincode <sup class="text-danger fs-5">*</sup> :</label>
                        <select class="form-control" name="pincode" id="pincode" data-placeholder="Choose Pincode">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="name" class="form-label fw-bold">Status <sup class="text-danger fs-5">*</sup> :</label>
                        <div class="square-switch">
                            <input type="checkbox" id="square-status" switch="status" name="status" value="1" {{ $area->status ? 'checked' : '' }} />
                            <label for="square-status" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer text-right">
        <button id="updateBtn" type="button" class="btn btn-success waves-effect waves-light">Save Changes</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</div>

<script>
    var state_id = '{{ $area->state_id }}';
    var city_id = '{{ $area->city_id }}';
    var pincode_id = '{{ $area->pincode_id }}';

    initSelect2Custom('#update-area-wrapper [name="country"]', '#update-area-wrapper');
    initSelect2Custom('#update-area-wrapper [name="state"]', '#update-area-wrapper');
    initSelect2Custom('#update-area-wrapper [name="city"]', '#update-area-wrapper');
    initSelect2Custom('#update-area-wrapper [name="pincode"]', '#update-area-wrapper');

    $('#update-area-wrapper').on('change', '[name="country"]', function (e) {
        let val = $(this).val();
        $('#update-area-wrapper [name="state"]').html('<option value=""></option>').trigger('change');
        $('#update-area-wrapper [name="city"]').html('<option value=""></option>').trigger('change');
        $('#update-area-wrapper [name="pincode"]').html('<option value=""></option>').trigger('change');

        if (val == '') {
            return false;
        }

        $.get(`{{ route("admin.states.country_wise.list") }}/${val}`, response => {
            let html = '<option value=""></option>';
            response.forEach(el => html += `<option value="${el.id}" ${el.id == state_id ? 'selected' : ''}>${el.name}</option>`);
            $('#update-area-wrapper [name="state"]').html(html).trigger('change');
            state_id = null;
        }, 'json');
    });
    $('#update-area-wrapper [name="country"]').change();

    $('#update-area-wrapper').on('change', '[name="state"]', function (e) {
        let val = $(this).val();
        $('#update-area-wrapper [name="city"]').html('<option value=""></option>').trigger('change');

        if (val == '') {
            return false;
        }

        $.get(`{{ route("admin.cities.state_wise.list") }}/${val}`, response => {
            let html = '<option value=""></option>';
            response.forEach(el => html += `<option value="${el.id}" ${el.id == city_id ? 'selected' : ''}>${el.name}</option>`);
            $('#update-area-wrapper [name="city"]').html(html).trigger('change');
            city_id = null;
        }, 'json');
    });

    $('#update-area-wrapper').on('change', '[name="city"]', function (e) {
        let val = $(this).val();
        $('#update-area-wrapper [name="pincode"]').html('<option value=""></option>').trigger('change');

        if (val == '') {
            return false;
        }

        $.get(`{{ route("admin.pincodes.city_wise.list") }}/${val}`, response => {
            let html = '<option value=""></option>';
            response.forEach(el => html += `<option value="${el.id}" ${el.id == pincode_id ? 'selected' : ''}>${el.pincode}</option>`);
            $('#update-area-wrapper [name="pincode"]').html(html).trigger('change');
            city_id = null;
        }, 'json');
    });

    $('#update-area-wrapper').on('click', '#updateBtn', function (e) {
        e.preventDefault();
        const $btn = $(this);

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: "{{ route('admin.area.update', $area->id) }}",
            data: $('#updateFrm').serialize(),
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
                $('#update-area-wrapper .close').click();
            }
        });
    });
</script>
