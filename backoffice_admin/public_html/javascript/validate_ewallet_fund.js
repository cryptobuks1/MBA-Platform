//==================Ajax for getting Balance amount=========================================//

function trim(a) {

    return a.replace(/^\s+|\s+$/, '');
}

function getXMLHTTP() { //fuction to return the xml http object
    var xmlhttp = false;
    try {
        xmlhttp = new XMLHttpRequest();
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (e) {
            try {
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e1) {
                xmlhttp = false;
            }
        }
    }

    return xmlhttp;
}



function getAmountLeg() {

    var root = document.fund_form.path.value;
    var user_id = document.getElementById('user_name').value;
    if (user_id == null || user_id == "" || user_id == "/") {
        var user_id = 0;
    }
    if (user_id) {

        var strURL = root + "/ewallet/getLegAmount/" + user_id;
        var req = getXMLHTTP();
        if (req) {
            req.onreadystatechange = function() {
                if (req.readyState == 4) {
                    if (req.status == 200) {
                        document.getElementById('user_amount_div').innerHTML = trim(req.responseText);
                    } else {
                        alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("GET", strURL, true);
            //alert(strURL);
            req.send(null);
        }
    }
}
//===========================================================//


var ValidateFund = function() {

    // function to initiate Validation Sample 1
    var msg = $("#error_msg1").html();
    var msg_user = $("#error_msg_user").html();
    var msg1 = $("#error_msg2").html();
    var msg2 = $("#error_msg3").html();
    var msg3 = $("#error_msg4").html();
    var msg4 = $("#error_msg5").html();
    var msg5 = $("#error_msg6").html();
    var msg6 = $("#validate_msg17").html();
    var msg9 = $("#error_name").html();
    var msg10 = $("#error_msg11").html();
    var msg12 = $("#error_msg12").html();
    var msg13 = $("#error_msg").html();
    var msg14 = $("#error_amount").html();
    var runValidateFundSelection = function() {
        $.validator.addMethod("balance_check", function(value, element) {
            $flag = 0;
            if ($('#blnc').length != 0) {
                var balance = ($('#blnc').val());
                var tans_fee = ($('#tran_fees').val());
                var length = balance.toString().length;
                // if(getUserType() != 'user')
                // {
                // balance = balance.substr(1);
                // balance = balance.slice(0, -1);
                // }
                tot_val = Number(value) + Number(tans_fee);
                var balance2 = Number(balance);

                if (Number(tot_val) <= balance2) {
                    $flag = 1;
                }
            }
            return $flag;
        }, msg10);
        $.validator.addMethod("username_check", function(value, element) {
            var path_root = $('#base_url').val();
            if (value != "/" && value != ".") {
                $.ajax({
                    'url': path_root + getUserType() + "/ewallet/validate_username",
                    'type': "POST",
                    'data': { username: value },
                    'dataType': 'text',
                    'async': false,
                    'success': function(data) {
                        if (data == 'no') {
                            flag2 = false;
                        } else if (data == 'yes') {
                            flag2 = true;
                        }
                    },
                    'error': function(error) {},
                });
                return flag2;
            } else {
                return true;
            }
        }, msg9);

        var searchform = $('#fund_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#fund_form,#msform').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorId: 'fund_transfer',
            errorPlacement: function(error, element) { // render error placement for each input type

                if ($(element).parent('.input-group').length === 0) {
                    error.insertAfter(element);
                } else {
                    error.insertAfter($(element).closest('.input-group'));
                }
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                user_name: {
                    minlength: 1,
                    required: true,
                    username_check: true
                },
                avb_amount: {
                    minlength: 1,
                    required: true
                },
                pswd: {
                    minlength: 1,
                    required: true
                },
                to_user_name: {
                    minlength: 1,
                    required: true,
                    username_check: true
                },
                amount1: {
                    min: 0,
                    number: true,
                    required: true,
                    balance_check: true
                },
                tran_concept: {
                    required: true
                },
                amount: {
                    required: true
                },
                pin_count: {
                    minlength: 1,
                    required: true,
                    min: 1,
                    digits: true,
                    maxlength: 2
                }

            },
            messages: {
                user_name: {
                    required: msg,
                    username_check: msg9
                },
                avb_amount: msg,
                pswd: msg2,
                to_user_name: {
                    required: msg3,
                    username_check: msg9
                },
                amount1: {
                    required: msg4,
                    min: msg12,
                    number: msg12,
                    balance_check: msg10

                },
                tran_concept: msg6,
                amount: {
                    required: msg13
                },
                pin_count: {
                    required: msg14,
                    digits: msg,
                    maxlength: msg2
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
                $("#pswd").val(encodeURIComponent(window.btoa($("#pswd").val())));
                event.preventDefault();
                form.submit();
            }
        });
    };
    var runValidateTranPassword = function() {
        var searchform = $('#fund_transfer_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#fund_transfer_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {

                pswd: {
                    minlength: 1,
                    required: true
                }

            },
            messages: {

                pswd: msg2,

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
    var runValidateFundAdminSelection = function() {
        var searchform = $('#fund_admin');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#fund_admin').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                user_name: {
                    minlength: 1,
                    required: true
                },
                pswd: {
                    minlength: 1,
                    required: true
                },
                to_user_name: {
                    minlength: 1,
                    required: true
                },
                amount: {
                    minlength: 1,
                    required: true
                }

            },
            messages: {
                user_name: msg,
                pswd: msg1,
                to_user_name: msg2,
                amount: msg3

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
            runValidateFundSelection();
            runValidateFundAdminSelection();
            runValidateTranPassword();
        }
    };
}();

$(document).ready(function() {
    ValidateFund.init();
    $('#user_name').on('mouseleave', function() {
        getAmountLeg();
    });

    $("#amount1").keypress(function(e) {
        var flag = 0;
        var msg = $("#validate_msg1").html();
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
            $("#errmsg1").html("<font color= '#b94a48'>" + msg + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });

    return true;


});

$('#amount1').on('blur', function() {
    var currency = $("#DEFAULT_CURRENCY_VALUE").val();
    var precision = $("#precision").val();
    var path_root = $('#base_url').val();
    var DEFAULT_SYMBOL_LEFT = $('#DEFAULT_SYMBOL_LEFT').val();
    var DEFAULT_SYMBOL_RIGHT = $('#DEFAULT_SYMBOL_RIGHT').val();
    var $inputs = $('#step-1 :input');
    var a = 1;
    var values = {};
    $inputs.each(function() {
        values[this.name] = $(this).val();
    })

    $.ajax({
        type: "POST",
        url: path_root + getUserType() + '/ewallet/fund_transfer',
        dataType: 'json',
        data: values,
        beforeSend: function() {

        },
        success: function(data) {

            if (!data['error']) {
                $('.sw-btn-next').prop("disabled", false);

                var amount = (data['data']['amount'] * currency).toFixed(precision);
                var bal_amount = (data['data']['bal_amount'] * currency).toFixed(precision);
                $('#bal_amount').val(bal_amount);
                $('#transaction_not').text(data['data']['transaction_note']);
                $('#disp_amount').val(amount);
                $('#amount').val(amount);
                $('#from_user').val(data['data']['from_user']);
                $('#to_username').val(data['data']['to_user']);
                $('#receiver').val(data['data']['to_user']);
            } else if (data['error']) {
                $('#alert_div').contents().clone().addClass('alert-danger').append(data['message']).prependTo('#smartwizard');
                $('.sw-btn-next').attr('disabled', true);
                return false;
            }
        },
        error: function(data) {
            console.log(data);
        },
        complete: function() {

        }
    });
});