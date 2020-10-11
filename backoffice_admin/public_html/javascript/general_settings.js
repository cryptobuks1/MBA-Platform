
$(function () {

    runValidateConfiguration();

});

var runValidateConfiguration = function () {

    var msg6 = $("#validate_msg13").html();
    var msg12 = $("#validate_msg20").html();
    var msg13 = $("#validate_msg21").html();
    var msg14 = $("#validate_msg22").html();
    var msg15 = $("#validate_msg23").html();
    var msg16 = $("#validate_msg24").html();
    var msg27 = $("#validate_msg27").html();
    var msg30 = $("#validate_msg30").html();
    var msg35 = $("#registration_amount_required").html();
    var msg36 = $("#trans_fee_required").html();
    var msg37 = $("#you_must_enter").html();
    var override_commission = $("#override_required").html();
    var purchase_income_perc = $("#purchase_income_perc_required").html();
    
    var msg38 = $("#greater_zero").html();
    var msg39 = $("#sus_fee_greater").html();
    var msg40 = $("#field_req").html();
    var msg41 = $('#upgrade_fee_req').html();
    var msg42 = $('#upgrade_fee_min').html();

    $.validator.addMethod("valid_taxes", function (value, element) {
        var tds = parseInt($('#tds').val());
        var service_charge = parseInt($('#service').val());
        var total_tax = tds + service_charge;
        if (total_tax == 0) {
            return true;
        }
        var res = checktaxes(tds, service_charge);
        if (res == true) {
            return true;
        } else {
            return false;
        }
    });

    var searchform = $('#form_general_setting');
    var errorHandler = $('.errorHandler', searchform);

    $('#form_general_setting').validate({
        errorElement: "span",
        errorClass: 'help-block',
        errorId: 'err_config',
        errorPlacement: function (error, element) {
            if ($(element).parent('.input-group').length === 0) {
                error.insertAfter(element);
            }
            else {
                error.insertAfter($(element).closest('.input-group'));
            }
        },
        ignore: ':hidden',
        rules: {
            reg_amount: {
                minlength: 1,
                number: true,
                min: 0,
                required: true
            },
            purchase_income_perc: {
                minlength: 1,
                digits: true,
                min: 0,
                max:100,
                required: true
            },
            service_charge: {
                minlength: 1,
                digits: true,
                required: true,
                min: 0,
                max: 100
            },
            trans_fee: {
                minlength: 1,
                digits: true,
                required: true
            },
            tds: {
                minlength: 1,
                digits: true,
                required: true,
                min: 0,
                max: 100,
                valid_taxes: true
            },
            subs_fee:{
                    required: true,
                    min: 0
                    
            },
            subs_referal_count:{
                required: true,
                min:0
            },
            upgrade_fee:{
                required :true,
                min:0
            }
        },
        messages: {
            service_charge: {
                required: msg12,
                digits: msg6,
                min: msg13,
                max: msg13
            },
            tds: {
                required: msg14,
                digits: msg6,
                min: msg15,
                max: msg15,
                valid_taxes: msg16
            },
            reg_amount: msg35,
            trans_fee: msg36,
            override_commission: {
                required: msg37 + ' ' + override_commission,
                min: msg27.replace('%s', override_commission),
                max: msg27.replace('%s', override_commission)
            },
            purchase_income_perc: {
                minlength: msg30,
                digits: msg30,
                min: msg27.replace('%s', purchase_income_perc),
                max:msg27.replace('%s', purchase_income_perc),
                required: msg37 + ' ' + purchase_income_perc
            },
            subs_fee:{
                    required: msg40,
                    min: msg39  
                    
            },
            subs_referal_count:{
                    required: msg40,
                    min:msg38
            },
             upgrade_fee:{
                required :msg41,
                min: msg42
            }
        },
        invalidHandler: function (event, validator) {
            errorHandler.show();
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
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
}

$(document).ready(function ()
{

    var msg2 = $("#validate_msg13").html();
    var msg3 = $("#validate_msg12").html();
    var msg4 = $("#validate_msg14").html();

    $("#reg_amount").keypress(function (e)
    {
        var flag = 0;
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                flag = 1;
            }
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
        {
            flag = 1;
        }
        if (flag == 1) {   //display error message
            $("#errmsg3").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });

    $("#referal_amount").keypress(function (e)
    {
        var flag = 0;
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                flag = 1;
            }
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
        {
            flag = 1;
        }
        if (flag == 1) {
            //display error message
            $("#errmsg6").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
            return false;
        }

    });

    $("#purchase_income_perc").keypress(function (e)
    {
        var flag = 0;
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                flag = 1;
            }
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
        {
            flag = 1;
        }
        if (flag == 1) {   //display error message
            $("#errmsg3").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });

    $("#trans_fee").keypress(function (e)
    {
        var flag = 0;
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                flag = 1;
            }
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
        {
            flag = 1;
        }
        if (flag == 1) {
            //display error message
            $("#errmsg7").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });
});

function checktaxes(tds, service_charge) {
    return ((tds + service_charge) <= 100);
}