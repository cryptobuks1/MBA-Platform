window.onload = function() {

    if (document.getElementById("page_container") && document.getElementsByClassName("main-navigation")) {
        document.getElementById("page_container").style.height = $(".main-navigation").height() + "px";
    }
    if (document.getElementById("page_container") && document.getElementById("menu")) {
        document.getElementById("page_container").style.height = $("#menu").height() + "px";
    }
}
var otp_stat = false;
$(function() {
    otp_stat = getOtpStat();
    $('.next').on('click', function(e) {
        var rcvr = $('#to_user_name').val();
        var tran_concept = $('#tran_concept').val();
        var user_name = $('#user_name').val();
        var amt = $('#amount').val();
        $('#receiver').val(rcvr);
        $('#transaction_not').val(tran_concept);
        $('#transaction_note').val(tran_concept);
        $('#from_user').val(user_name);
        $('#amount').val(amt);
        $(".no-display").removeAttr("style").hide();
    });
    $('.submit').on('click', function() {
        if ($(this).closest('form').valid()) {
            if (otp_stat) {
                load_otp($(this).closest('form').attr('id'));
            } else {
                $(this).closest('form').submit();
            }
        };
    });

    $('#fund_form,#msform').submit(function() {
        if ($("#fund_form,#msform").valid()) {
            if (otp_stat) {
                $('<input />').attr('type', 'hidden')
                    .attr('name', "otp")
                    .attr('value', $('#one_time_password').val())
                    .appendTo("#fund_form,#msform");
            }
            $('.sw-btn-finish').button('loading');
        }
    });
    $('.sw-btn-cancel').on('click', function() {
        $(this).closest('form').submit();
    });
});
var load_otp = function(form) {
    var url = $("input[name='base_url']").val();
    $.ajax({
        type: 'POST',
        url: url + 'admin/ewallet/fundOtpModal',
        success: function(msg) {
            $("input[name='submit_form']").text(form);
            $("#otp-modal").modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#otp-modal').on('show.bs.modal', function(e) {
                $('#one_time_password').focus();
            });
            $('#otp-modal').modal('show');
            ValidateOtp.init();
        },
        error: function(msg) {
            alert("Error Occured!");
        }
    });
};
var ValidateOtp = function() {
    // function to initiate Validation Sample 1
    var msg1 = $("#otp_err1").html();
    var msg2 = $("#otp_err2").html();
    ///////----for 'CHANGE USER PASSWORD' Tab - Begin/////////
    var runValidateOtpForm = function() {

        var searchform = $('#otp_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#otp_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                one_time_password: {
                    required: true,
                    number: true,
                }
            },
            messages: {
                one_time_password: {
                    required: msg1,
                    number: msg2
                }
            },
            invalidHandler: function(event, validator) { //display error alert on form submit
                errorHandler1.show();
            },
            highlight: function(element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function(element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function(label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                //$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            },
            submitHandler: function(form, event) {
                event.preventDefault();
                var release = $("input[name='submit_form']").text();
                if ($('#' + release).valid()) {
                    $('#' + release).submit();
                }
            }
        });
    };
    return {
        //main function to initiate template pages
        init: function() {
            runValidateOtpForm();
        }
    };
}();
$('#resend').click(function() {
    var resend = $(this).find('span');
    resend.addClass('fa-spin');
    setTimeout(function() {
        var url = $("input[name='base_url']").val();
        $.ajax({
            type: 'POST',
            url: url + 'admin/ewallet/fundOtpModal',
            success: function(msg) {},
            error: function(msg) {
                $(this).find('span').removeClass('fa-spin');
                alert("Error Occured!");
            }
        });
        resend.removeClass('fa-spin');
    }, 3000);
});
var getOtpStat = function() {
    var flag = false;
    var url = $("input[name='base_url']").val();
    $.ajax({
        async: false,
        type: 'POST',
        url: url + 'admin/ewallet/getOtpStat',
        success: function(i) {
            if (i == "yes") {
                flag = true;
            }
        },
        error: function() {
            alert("Error Occured!");
        }
    });
    return flag;
};