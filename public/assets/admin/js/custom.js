
// For Product Type Field Js
$(document).ready(function(){
    $("#parentCategory").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
                $("#productType").hide();
                $("#typeId").removeAttr("required");
            } else{
                $("#productType").show();
                $("#typeId").attr('required', 'required');
            }
        });
    }).change();
});

// For dropify Js
$(document).ready(function(){
    $('.dropify').dropify();
});

// For summernote text editor Js
$(document).ready(function() {
    $('.summernote').summernote();
});

// For Meta Field Js
// $(document).ready(function(){
//     $("#chkMeta").click(function () {
//         if ($(this).is(":checked")) {
//             $("#metaInputs").show();
//         } else {
//             $("#metaInputs").hide();
//         }
//     });
// });
$(document).ready(function (e) {
    if ($('.select2-class').length > 0) {
        initSelect2();
    }
    if ($('.select2-class2').length > 0) {
        initSelect2Custom();
    }

    if ($('.date-picker').length > 0) {
        $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });
    }

    if ($('.dob-picker').length > 0) {
        $('.dob-picker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
            endDate: new Date()
        });
    }

    if ($('.alpha-num-text').length > 0) {
        $('.alpha-num-text').keyup(function () {
            var yourInput = $(this).val();
            re = /[`~!@#$%^&*()_|+\-=?;'"<>\{\}\[\]\\\/]/gi;
            var isSplChar = re.test(yourInput);
            if (isSplChar) {
                var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;'"<>\{\}\[\]\\\/]/gi, '');
                $(this).val(no_spl_char);
            }
        });
    }

    $(".custom-positive-integer").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
            // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});
function initSelect2(target = '.select2-class', dropdownParent = 'body') {
    $(target).select2({
        width: '100%',
        dropdownParent: $(dropdownParent)
    });
}
