$(function () {
    ValidateUpation.init();
});

//Payment Gateway Config For Payout

var ValidateUpation = function () {

    var msg2 = $("#error_msg5").html();
    $(".sort_order1").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#errmsg1").html(msg2).show().fadeOut(2200, 0);
            return false;
        }
    });

    $(".sort_order2").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#errmsg2").html(msg2).show().fadeOut(2200, 0);
            return false;
        }
    });

    $(".sort_order3").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 49 || e.which > 57)) {
            //display error message
            $("#errmsg3").html(msg2).show().fadeOut(2200, 0);
            return false;
        }
    });

    $(".sort_order4").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#errmsg4").html(msg2).show().fadeOut(2200, 0);
            return false;
        }
    });

    var runPayoutValidation = function () {
        var msg1 = $("#error_msg3").html();
        var msg2 = $("#error_msg4").html();
        var msg3 = $("#error_msg5").html();
        var msg4 = $("#error_msg6").html();
        var msg5 = $("#error_msg7").html();
        var msg6 = $("#error_msg8").html();
        var searchform = $('#payout_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $.validator.addMethod('minStrict', function (value, el, param) {
            return value > param;
        });
        $('#payout_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorId: 'err_payout',
            errorPlacement: function (error, element) { // render error placement for each input type
                if ($(element).parent('.input-group').length === 0) {
                    error.insertAfter(element);
                }
                else {
                    error.insertAfter($(element).closest('.input-group'));
                }
            },
            ignore: ':hidden',
            rules: {
                min_payout: {
                    number: true,
                    minStrict: 0,
                    required:true
                },
                max_payout: {
                    number: true,
                    min: 0,
                    required:true
                },
                payout_validity: {
                    digits: true,
                    maxlength: 5,
                    required:true
                }
            },
            messages: {
                min_payout: {
                    number: msg1,
                    minStrict: msg3,
                    required:msg4
                },
                max_payout: {
                    number: msg1,
                    minStrict: msg3,
                    required:msg5
                },
                payout_validity: {
                    digits: msg1,
                    maxlength: msg2,
                    required: msg6
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                errorHandler1.show();
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                //$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            }
        });
    };
    return {
        //main function to initiate template pages
        init: function () {
            runPayoutValidation();
        }
    };
}();

$('.paypal_status').on('click', function () {
    var base_url = $('#base_url').val();
    $(this).closest('.panel').prev('.alert').remove();
    var id = $(this).data('id');
    var status = $(this).data('status');
    var element = $(this);
    $.ajax({
        'url': base_url + "admin/configuration/change_credit_card_status_for_payout",
        'type': "POST",
        'data': { id: id, module_status: status },
        'dataType': 'json',
        'beforeSend': function () {
            var img_url = $('#base_url').val() + 'public_html/images/loading.gif';
            var img = '<img style="margin: 5px 0 0 10px;" src="' + img_url + '"/>';
            $(element).closest('.switch').after(img);
        },
        'success': function (data) {
            if (data.response) {
                var box = $('#success-box').clone();
                $(box).css('display', 'block');
                $(box).attr('id', '');
                $(element).closest('.panel').before(box);
                location.reload();
                // $('html,body').animate({scrollTop: 0}, 1000);
            } else {
                $(element).prop('checked', !status);
                var box = $('#error-box').clone();
                $(box).css('display', 'block');
                $(box).attr('id', '');
                $(element).closest('.panel').before(box);
                // $('html,body').animate({scrollTop: 0}, 1000);
            }
        },
        'error': function (error) {
            $(element).prop('checked', !status);
            var box = $('#error-box').clone();
            $(box).css('display', 'block');
            $(box).attr('id', '');
            $(element).closest('.panel').before(box);
            location.reload();
            // $('html,body').animate({scrollTop: 0}, 1000);
        },
        'complete': function () {
            setTimeout(function () {
                $(element).closest('.switch').next('img').remove();
            }, 500);
        }
    });
});