$(document).ready(function () {
    $("#datatable").DataTable(), $("#datatable-buttons").DataTable({
        lengthChange: false,
        buttons: ["copy", "excel", "pdf", "colvis"],
        order: [[0, "desc"]]
    }).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"), $(".dataTables_length select").addClass("form-select form-select-sm")
});
$(document).ready(function () {
    $("#datatable").DataTable(), $("#datatable-buttons-2").DataTable({
        lengthChange: false,
        order: [[0, "desc"]]
    }).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"), $(".dataTables_length select").addClass("form-select form-select-sm")
});