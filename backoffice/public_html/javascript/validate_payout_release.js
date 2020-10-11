//cancel waiting withrawal
function cancel_withdrawal(root) {
    var msg = $("#show_msg1").html();
    if (confirm(msg)) {
        document.location.href = root + 'payout/payout_release_request/cancel/';
    }
}
//ends
////Delete Payour Request
function delete_request(id, root, user_name, payout) {
    var msg = $("#show_msg1").html();
    if (confirm(msg)) {
        document.location.href = root + 'payout/payout_release/delete/' + id + '/' + user_name + '/' + payout;
    }
}

// Crowd fund functions
function delete_member_request(id, root, user_name, payout) {
    var msg = $("#show_msg1").html();
    if (confirm(msg)) {
        document.location.href = root + 'payout/payout_release_member/delete/' + id + '/' + user_name + '/' + payout;
    }
}
// End

var otp_stat = false;
var ValidateUser = function() {

    var msg = $("#error_msg").html();

    var runValidatorweeklySelection = function() {
        var searchform = $('#main_menu_chenge');
        var errorHandler1 = $('.errorHandler', searchform);

        $('#main_menu_chenge').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                week_date2: {
                    minlength: 1,
                    required: true
                }
            },
            messages: {
                week_date2: msg

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
            }
        });
    };

    return {
        //main function to initiate template pages
        init: function() {
            runValidatorweeklySelection();

        }
    };
}();
var ValidateDate = function() {
    // function to initiate Validation Sample 1
    var runValidatorweeklySelection = function() {
        var msg = $("#msg").html();
        var msg2 = $("#errmsg2").html();
        var msg3 = $("#errmsg3").html();
        var searchform = $('#date_submit');
        var checkboxes = $('.release');
        var checkbox_names = $.map(checkboxes, function(e, i) {
            return $(e).attr("name")
        }).join(" ");
        var errorHandler1 = $('.errorHandler', searchform);
        $('#date_submit').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorId: 'mark-paid',
            errorPlacement: function(error, element) { // render error placement for each input type

                //error.insertAfter(element);
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                start_date: {
                    minlength: 1,
                    required: true
                },
                end_date: {
                    minlength: 1,
                    required: true,
                    todate_greaterthan_fromdate: true
                }

            },
            messages: {
                start_date: msg2,
                end_date: {
                    required: msg3,
                    minlength: msg3,
                    todate_greaterthan_fromdate: msg
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
            }
        });
        jQuery.validator.addMethod('todate_greaterthan_fromdate', function(ToDate) {
            var FromDate = $("#start_date").val();
            if ($('#start_date').val() && $('#end_date').val()) {
                return (ToDate > FromDate);
            }
        });
    };
    return {
        //main function to initiate template pages
        init: function() {
            runValidatorweeklySelection();

        }
    };
}();
//=========validate checkbox===================//

var ValidatePayoutRelease = function() {

    // function to initiate Validation Sample 1
    var msg1 = $("#error_msg").html();
    var msg2 = $("#err_msg1").html();
    var msg3 = $("#err_msg2").html();
    var msg4 = $("#err_msg3").html();
    var msg5 = $("#err_msg4").html();
    var msg6 = $("#err_msg5").html();
    var msg7 = $("#err_msg6").html();
    ///////----for 'CHANGE USER PASSWORD' Tab - Begin/////////
    var runValidatorUserSelection = function() {

        /*jQuery.validator.addMethod("alpha_dash", function(value, element) {
         return this.optional(element) || /^[a-z0-9A-Z]*$/i.test(value);
         }, msg6);*/
        $.validator.addMethod('release', function(value) {
            return $('.release:checked').size() > 0;
        }, '<font color="red">' + msg1 + '</font>');
        var searchform = $('#ewallet_form_det');
        var checkboxes = $('.release');
        var checkbox_names = $.map(checkboxes, function(e, i) {
            return $(e).attr("name")
        }).join(" ");
        var errorHandler1 = $('.errorHandler', searchform);
        $('#ewallet_form_det').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorId: 'multiple',
            errorPlacement: function(error, element) { // render error placement for each input type
                if ($(element).next().is('i')) {
                    error.insertAfter($(element).next());
                } else {
                    error.insertAfter(element);
                    error.insertAfter($(element).closest('.input-group'));
                }
            },
            ignore: ':hidden',
            groups: {
                checks: checkbox_names
            },
            rules: {
                checkbox_name: {
                    required: true
                },
                main_password: {
                    required: true
                },
                second_password: {
                    required: true
                },
                wallet_id: {
                    required: true
                },
                passphrase: {
                    required: true
                },
                wallet_name: {
                    required: true
                },
                wallet_password: {
                    required: true
                }
            },
            messages: {
                checkbox_name: {
                    required: msg1
                },
                main_password: {
                    required: msg2
                },
                second_password: {
                    required: msg3
                },
                wallet_id: {
                    required: msg4
                },
                passphrase: {
                    required: msg5
                },
                wallet_name: {
                    required: msg6
                },
                wallet_password: {
                    required: msg7
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
                form.submit();
            }
        });
    };

    var runValidatorUserSelectionReq = function() {

        /*jQuery.validator.addMethod("alpha_dash", function(value, element) {
         return this.optional(element) || /^[a-z0-9A-Z]*$/i.test(value);
         }, msg6);*/
        $.validator.addMethod('release', function(value) {
            return $('.release:checked').size() > 0;
        }, '<font color="red">' + msg1 + '</font>');
        var searchform = $('#ewallet_form_det2');
        var checkboxes = $('.release');
        var checkbox_names = $.map(checkboxes, function(e, i) {
            return $(e).attr("name")
        }).join(" ");
        var errorHandler1 = $('.errorHandler', searchform);
        $('#ewallet_form_det2').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorId: 'single',
            errorPlacement: function(error, element) { // render error placement for each input type
                if ($(element).next().is('i')) {
                    error.insertAfter($(element).next());
                } else {
                    error.insertAfter(element);
                    error.insertAfter($(element).closest('.input-group'));
                }
            },
            ignore: ':hidden',
            groups: {
                checks: checkbox_names
            },
            rules: {
                checkbox_name: {
                    required: true
                },
                main_password: {
                    required: true
                },
                second_password: {
                    required: true
                },
                wallet_id: {
                    required: true
                },
                passphrase: {
                    required: true
                },
                wallet_name: {
                    required: true
                },
                wallet_password: {
                    required: true
                }
            },
            messages: {
                checkbox_name: {
                    required: msg1
                },
                main_password: {
                    required: msg2
                },
                second_password: {
                    required: msg3
                },
                wallet_id: {
                    required: msg4
                },
                passphrase: {
                    required: msg5
                },
                wallet_name: {
                    required: msg6
                },
                wallet_password: {
                    required: msg7
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
            submitHandler: function(form) {
                form.submit();
            }
        });
    };

    var payoutReleaseRequest = function() {
        var searchform = $('#payout_request');
        var errorHandler1 = $('.errorHandler', searchform);
        var msg1 = $("#error_msg1").html();
        var msg2 = $("#error_msg2").html();
        var msg3 = $("#error_msg3").html();
        var msg4 = $("#error_msg4").html();
        var msg5 = $("#error_msg5").html();
        var msg6 = $("#show_msg2").html();
        $.validator.addMethod('payout_amount', function(value) {
            return value > 0;
        }, "<font color='#b94a48'>" + msg6 + "</font>");
        $('#payout_request').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorId: 'request',
            errorPlacement: function(error, element) { // render error placement for each input type
                //error.insertAfter(element);
                if ($(element).closest('.input-group').length) {
                    error.insertAfter($(element).closest('.input-group'));
                } else {
                    error.insertAfter(element);
                }
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                payout_amount: {
                    required: true,
                    number: true,
                    payout_amount: true
                },
                transation_password: {
                    required: true,
                    minlength: 8
                }

            },
            messages: {
                payout_amount: {
                    required: msg3,
                    number: msg5
                },
                transation_password: {
                    required: msg1,
                    minlength: msg2
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
            submitHandler: function(form) {
                $("#transation_password").val(encodeURIComponent(window.btoa($("#transation_password").val())));
                event.preventDefault();
                form.submit();
            }
        });
    };

    var runValidatorConfirmTransfer = function() {

        /*jQuery.validator.addMethod("alpha_dash", function(value, element) {
         return this.optional(element) || /^[a-z0-9A-Z]*$/i.test(value);
         }, msg6);*/
        $.validator.addMethod('release', function(value) {
            return $('.release:checked').size() > 0;
        }, '<font color="red">' + msg1 + '</font>');
        var searchform = $('#mark_payout');
        var checkboxes = $('.release');
        var checkbox_names = $.map(checkboxes, function(e, i) {
            return $(e).attr("name")
        }).join(" ");
        var errorHandler1 = $('.errorHandler', searchform);
        $('#mark_payout').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorId: 'transfer',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            groups: {
                checks: checkbox_names
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
            submitHandler: function(form) {
                form.submit();
            }
        });
    };

    return {
        //main function to initiate template pages
        init: function() {
            runValidatorUserSelection();
            runValidatorUserSelectionReq();
            payoutReleaseRequest();
            runValidatorConfirmTransfer();

        }
    };
}();
$(function() {
    otp_stat = getOtpStat();
    ValidatePayoutRelease.init();
    ValidateDate.init();
    var payment_active = $(".pay").val();
    $('.f-' + payment_active).show();
    var payment_active2 = $(".pay2").val();
    $('.s-' + payment_active2).show();

    var msg1 = $("#show_msg2").html();
    $(".payout_amount").keypress(function(e) {
        var flag = 0;
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                flag = 1;
            }
        }


        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) {
            flag = 1;
        }
        if (flag == 1) {
            //display error message
            var span = "<span id='keyup_" +
                this.name + "' class='keyup_error' style='color:#b94a48';>" + msg1 + "</span>";
            $(this).closest("div").next('span.keyup_error').remove();
            $(this).closest("div").after(span);
            $(this).closest("div").next('span:first').fadeOut(2000, 0);
            return false;
        }
    });


    return true;


});

$('#ewallet_form_det').submit(function() {
    if ($('#ewallet_form_det').valid()) {
        if (otp_stat)
            $('<input />').attr('type', 'hidden')
            .attr('name', "otp")
            .attr('value', $('#one_time_password').val())
            .appendTo("#ewallet_form_det");
        $('#release_payout_tab1').button('loading');
    }
});

$('#ewallet_form_det2').submit(function() {
    if ($('#ewallet_form_det2').valid()) {
        if (otp_stat)
            $('<input />').attr('type', 'hidden')
            .attr('name', "otp")
            .attr('value', $('#one_time_password').val())
            .appendTo("#ewallet_form_det2");
        $('#release_payout_tab2').button('loading');
    }
});
$('.pay').on('change', function() {
    var selectedValue = $(this).val();
    $(".payment").hide();
    $('.f-' + selectedValue).show();
});
$('.pay2').on('change', function() {
    var selectedValue = $(this).val();
    $(".payment2").hide();
    $('.s-' + selectedValue).show();
});

// $('#check_all').on('click', function() {

//     var check = $('#checkAll').val();
//     if (check == 'Check All') {
//         $(".release").prop('checked', true);
//         $('#checkAll').val('Uncheck All');
//     } else {
//         $('.release').prop('checked', false);
//         $('#checkAll').val('Check All');
//     }
// });

/*$('#check_all_tab1').on('click', function () {
    //var script = $('#check_all_tab1').attr("onclick");
    if($(".release_tab1").is('checked')){
        //(".release_tab1").prop('checked', false);
        alert("aaaa");
    }else{
        $(".release_tab1").prop('checked', true);
    alert("bbbb");
    }
});*/
$('#check_all_tab1').on('click', function() {
    var check = $('#checkAll').val();
    if (check == 'Check All') {
        $('.release_tab1').prop('checked', true);
        $('#checkAll').val('Uncheck All');
    } else {
        $('.release_tab1').prop('checked', false);
        $('#checkAll').val('Check All');
    }
});

$('#check_all_tab2').on('click', function() {

    var check = $('#checkAll').val();
    if (check == 'Check All') {
        $(".release_tab2").prop('checked', true);
        $('#checkAll').val('Uncheck All');
    } else {
        $('.release_tab2').prop('checked', false);
        $('#checkAll').val('Check All');
    }
});

function checkAll() {
    $(".release").prop('checked', true);
    document.getElementById("uncheck_all").style.display = '-webkit-inline-box';
    document.getElementById("check_all").style.display = 'none';
}

function uncheckAll() {
    $(".release").prop('checked', false);
    document.getElementById("check_all").style.display = '-webkit-inline-box';
    document.getElementById("uncheck_all").style.display = 'none';
}
$('#payout_request').submit(function() {
    if ($("#payout_request").valid()) {
        $('#payout_request_submit').button('loading');
    }
});
$('#mark_payout').submit(function() {
    if ($("#mark_payout").valid()) {
        $('#mark_payout').button('loading');
    }
});
var load_otp = function(form) {
    var url = $("input[name='base_url']").val();
    $.ajax({
        type: 'POST',
        url: url + 'admin/payout/payoutOtpModal',
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
$('#release_payout_tab1,#release_payout_tab2,#release_payout').click(function() {
    if ($(this).closest('form').valid()) {
        if (otp_stat) {
            load_otp($(this).closest('form').attr('id'));
        } else {
            $(this).closest('form').submit();
        }
    }
});
$('#resend').click(function() {
    var resend = $(this).find('span');
    resend.addClass('fa-spin');
    setTimeout(function() {
        var url = $("input[name='base_url']").val();
        $.ajax({
            type: 'POST',
            url: url + 'admin/payout/payoutOtpModal',
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
  
    var user_type = getUserType();
    if (user_type != 'admin') {
        return flag;
    }
    var url = $("input[name='base_url']").val();
    $.ajax({
        async: false,
        type: 'POST',
        url: url + 'admin/payout/getOtpStat',
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
