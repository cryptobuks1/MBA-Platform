$(document).ready(function () {
    $("#purchase_wallet").keypress(function (e) {
        if (e.which == 0 || e.which == 8) {
            return;
        }
        var regex = new RegExp("^[0-9.]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        } else {
            return false;
        }
    });

    var label_field_is_required = $('#label_field_is_required').text();
    var label_enter_valid_field = $('#label_enter_valid_field').text();
    var label_field_greater_than_zero = $('#label_field_greater_than_zero').text();
    var label_amount = $('#label_amount').text();
    $('#purchase_wallet').validate({
        errorElement: 'span',
        errorClass: 'help-block error',
        errorId: 'err_pwallet_amount',
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        ignore: ':hidden',
        rules: {
            amount: {
                required: true,
                number: true,
                greaterThanNum: 0
            }
        },
        messages: {
            amount: {
                required: label_field_is_required.replace('%s', label_amount),
                number: label_enter_valid_field.replace('%s', label_amount),
                greaterThanNum: label_field_greater_than_zero.replace('%s', label_amount)
            }
        },
        invalidHandler: function (event, validator) {
            $('.errorHandler', '#purchase_wallet').show();
        },
        highlight: function (element) {
            $(element).closest('.help-block').removeClass('valid');
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        success: function (label, element) {
            label.addClass('help-block valid');
            $(element).closest('.form-group').removeClass('has-error').addClass('ok');
        }
    });
});