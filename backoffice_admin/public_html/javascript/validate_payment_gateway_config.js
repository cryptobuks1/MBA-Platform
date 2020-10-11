$(function()
{
   ValidateUpation.init(); 
});
var ValidateUpation = function () {

    var runValidatorUpdation = function () {

        var msg4 = $("#validate_msg1").html();
        var msg5 = $("#validate_msg2").html();
        var msg6 = $("#error_msg3").html();
        var searchform = $('#payment_status_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $.validator.addMethod('sort_order', function(value) {
            return value > 0;
        }, msg6);

        $('#payment_status_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                sort_order: {
                    minlength: 1,
                    digits: true,
                    sort_order:true,
                    required: true
                },
                transaction_key: {
                    minlength: 1,
                    required: true
                }
            },
            messages: {
                sort_order: {
                    digits : msg6
                },
               merchant_log_id: msg5,
                transaction_key: msg4
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
            runValidatorUpdation();
        }
    };
}();


function change_payment_status(path_root, id, module_status)
{
    var set_module_status = path_root + "configuration/change_payment_status";
    $.post(set_module_status, {id: id, module_status: module_status}, function (data)
    {
        location.reload();
    });
}

function change_credit_card_status(path_root, id, module_status)
{
    var set_module_status = path_root + "configuration/change_credit_card_status";
    $.post(set_module_status, {id: id, module_status: module_status}, function (data)
    {
        location.reload();
    });
}

function change_module_status(path_temp, path_root, module_name, module_status)
{
    var set_module_status = path_root + "configuration/change_module_status";
    var msg = $("#load_msg").html();
    $("#" + module_name).removeClass();
    $("#" + module_name).addClass('messagebox');
    $("#" + module_name).html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" />' + msg).show().fadeTo(1900, 1);
    $.post(set_module_status, {module_name: module_name, module_status: module_status}, function (data)
    {
        location.reload();
    });
}

$('.payment_status').on('click', function () {
    var base_url = $('#base_url').val();
    $(this).closest('.panel').prev('.alert').remove();
    var id = $(this).data('id');
    var status = $(this).data('status');
    var element = $(this);
    $.ajax({
        'url': base_url + "admin/configuration/change_payment_status",
        'type': "POST",
        'data': {id: id, module_status: status},
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

$('.google_auth_status').on('click', function () {
    var base_url = $('#base_url').val();
    $(this).closest('.panel').prev('.alert').remove();
    var module_status = $(this).data('status');
    var module_name = 'google_auth_status';
    var element = $(this);
    $.ajax({
        'url': base_url + "admin/configuration/change_module_status",
        'type': "POST",
        'data': {module_name: module_name, module_status: module_status},
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
$('.paypal_status').on('click', function () {
    var base_url = $('#base_url').val();
    $(this).closest('.panel').prev('.alert').remove();
    var id = $(this).data('id');
    var status = $(this).data('status');

    var element = $(this);
    $.ajax({
        'url': base_url + "admin/configuration/change_credit_card_status",
        'type': "POST",
        'data': {id: id, module_status: status},
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
$('.payment_avilable').on('click', function () {
    var base_url = $('#base_url').val();
    $(this).closest('.panel').prev('.alert').remove();
    var id = $(this).data('id');
    var status = $(this).is(':checked');
    var attr = $(this).attr('name');
    var element = $(this);
    $.ajax({
        'url': base_url + "admin/configuration/change_payment_available",
        'type': "POST",
        'data': {id: id, status: status, attr: attr},
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
            }
            else {
                $(element).prop('checked', !status);
                var box = $('#error-box').clone();
                $(box).css('display', 'block');
                $(box).attr('id', '');
                $(element).closest('.panel').before(box);
            }
        },
        'error': function (error) {
            $(element).prop('checked', !status);
            var box = $('#error-box').clone();
            $(box).css('display', 'block');
            $(box).attr('id', '');
            $(element).closest('.panel').before(box);
        },
        'complete': function () {
            setTimeout(function () {
                $(element).closest('.switch').next('img').remove();
                location.reload();
            }, 500);
        }
    });
});

$('.payment_status').on('click', function () {
        $(this).closest('.panel').prev('.alert').remove();
        var id = $(this).data('id');
        var status = $(this).is(':checked');
        var attr = 'status';
        var sub_id = 61;
        var sub_cart_id = 46;
        var attr1 = 'perm_admin';

        if (status == true){
            var anti_status = false;
        } else{
            var anti_status = true;
        }
        if(id == 5){
           change_cart_menu_config(sub_id, status, attr);
           change_cart_menu_config(sub_cart_id, anti_status, attr1);
        }
    });
    
    function change_cart_menu_config(id, status, attr) {
        var base_url = $('#base_url').val();
        $.ajax({
            url: base_url + "admin/configuration/update_cart_menu_perm",
            type: "POST",
            data: {
                id: id, status: status, attr: attr
            },
            dataType: 'text',
                complete: function () {
                        setTimeout(function () {
                        location.reload();
                        }, 500);
                }
        });
    }


