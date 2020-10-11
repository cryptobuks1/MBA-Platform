$(function() {
    ValidateConfiguration.init();
    var base_url = $('#base_url').val();
	$('.pending_status').on('click', function () {
        $(this).closest('.panel').prev('.alert').remove();
        var id = $(this).data('id');
        var status = $(this).is(':checked');
        var element = $(this);
        $.ajax({
            'url': base_url + "admin/configuration/update_pending_signup_option",
            'type': "POST",
            'data': { id: id, status: status },
            'dataType': 'json',
            'beforeSend': function () {
                var img_url = $('#base_url').val() + 'public_html/images/loading.gif';
                var img = '<img style="margin: 5px 0 0 10px;" src="' + img_url + '"/>';
                $(element).closest('.switch').after(img);
            },
            'success': function (data) {
                if(data.response) {
                    var box = $('#success-box').clone();
                    $(box).css('display', 'block');
                    $(box).attr('id', '');
                    $(element).closest('.panel').before(box);
                    // $('html,body').animate({scrollTop: 0}, 1000);
                }
                else {
                    $(element).prop('checked', !status);
                    var box = $('#error-box').clone();
                    $(box).css('display', 'block');
                    $(box).attr('id', '');
                    $(element).closest('.panel').before(box);
                    // $('html,body').animate({scrollTop: 0}, 1000);
                }
            },
            'error': function(error) {
                $(element).prop('checked', !status);
                var box = $('#error-box').clone();
                $(box).css('display', 'block');
                $(box).attr('id', '');
                $(element).closest('.panel').before(box);
                // $('html,body').animate({scrollTop: 0}, 1000);
            },
            'complete': function (jqXHR, textStatus) {
                if (textStatus =='parsererror') {
                    location.reload();
                }
                setTimeout(function () {
                    $(element).closest('.switch').next('img').remove();
                }, 500);
            }
        });
    });

    $('input[name="registration_allowed"]').on('click', function () {
        return;
        $(this).closest('.panel').prev('.alert').remove();
        var status = $(this).is(':checked');
        var element = $(this);
        var key = 'registration_allowed';
        var value = status ? 'yes' : 'no';
        updateSignupSettings(key, value, element);
    });

    $('input[name="sponsor_required"]').on('click', function () {
        return;
        $(this).closest('.panel').prev('.alert').remove();
        var status = $(this).is(':checked');
        var element = $(this);
        var key = 'sponsor_required';
        var value = status ? 'yes' : 'no';
        updateSignupSettings(key, value, element);
    });

    $('input[name="bank_info_required"]').on('click', function () {
        return;
        $(this).closest('.panel').prev('.alert').remove();
        var status = $(this).is(':checked');
        var element = $(this);
        var key = 'bank_info_required';
        var value = status ? 'yes' : 'no';
        updateSignupSettings(key, value, element);
    });

    $('input[name="referral_status"]').on('click', function () {
        return;
        $(this).closest('.panel').prev('.alert').remove();
        var status = $(this).is(':checked');
        var element = $(this);
        var key = 'referral_status';
        var value = status ? 'yes' : 'no';
        updateSignupSettings(key, value, element);
    });

    $('input[name="mail_notification"]').on('click', function () {
        return;
        $(this).closest('.panel').prev('.alert').remove();
        var status = $(this).is(':checked');
        var element = $(this);
        var key = 'mail_notification';
        var value = status ? 'yes' : 'no';
        updateSignupSettings(key, value, element);
    });

    $('#update_binary_leg').on('click', function () {
        return;
        $(this).closest('.panel').prev('.alert').remove();
        var value = $('select[name="binary_leg"]').val();
        var element = $('select[name="binary_leg"]');
        var key = 'binary_leg';
        updateSignupSettings(key, value, element);
    });

    $('#update_age_limit').on('click', function () {
        return;
        $(this).closest('.panel').prev('.alert').remove();
        var value = $('input[name="age_limit"]').val();
        var element = $('input[name="age_limit"]');
        var key = 'age_limit';
        updateSignupSettings(key, value, element);
    });

    $('#update_country').on('click', function () {
        return;
        $(this).closest('.panel').prev('.alert').remove();
        var value = $('select[name="country"]').val();
        var element = $('select[name="country"]');
        var key = 'country';
        updateSignupSettings(key, value, element);
    });
    
    $('input[name="compression_commission"]').on('click', function () {
        return;
        $(this).closest('.panel').prev('.alert').remove();
        var status = $(this).is(':checked');
        var element = $(this);
        var key = 'compression_commission';
        var value = status ? 'yes' : 'no';
        updateSignupSettings(key, value, element);
    });
    ValidateSortorder.init(); 
    signupFieldConfig();
    
    $('input[name="binary_leg_status"]').on('change', function () {
        if (this.checked) {
            $('select[name="binary_leg"]').closest('.form-group').show();
        } else {
            $('select[name="binary_leg"]').closest('.form-group').hide();
        }
    });

    $('input[name="binary_leg_status"]').change();
    
    $('input[name="age_limit_status"]').on('change', function () {
        if (this.checked) {
            $('input[name="age_limit"]').closest('.form-group').show();
        } else {
            $('input[name="age_limit"]').closest('.form-group').hide();
        }
    });

    $('input[name="age_limit_status"]').change();

    $("input[name='age_limit']").inputFilter(function (value) {
        return /^\d*$/.test(value) && (value === "" || parseInt(value) >= 1);
    });
});

var ValidateSortorder = function () {
    var runValidatorUpdation = function () {

        var msg4 = $("#validate_msg1").html();
        var msg5 = $("#validate_msg2").html();
        var msg6 = $("#digit_only").html();
        var searchform = $('#signup_field_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $.validator.addMethod('sort_order', function(value) {
            return value > 0;
        }, msg6);

        $('#signup_field_form').validate({
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
                    sort_order:true
                },
            },
            messages: {
                sort_order: {
                    digits : msg6
                },
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

function updateSignupSettings(key, value, element) {
    return;
    var base_url = $('#base_url').val();
    var switch_elements = ['registration_allowed', 'sponsor_required', 'referral_status', 'mail_notification','compression_commission']
    $.ajax({
        'url': base_url + "admin/configuration/update_signup_settings",
        'type': "POST",
        'data': { [key]: value },
        'dataType': 'json',
        'beforeSend': function () {
        //   var img_url = $('#base_url').val() + 'public_html/images/loading.gif';
        //    if ($.inArray(key, switch_elements) === -1) {
        //         var img = '<img style="margin: 10px 0 0 10px;height: max-content;" src="' + img_url + '"/>';
        //         $(element).next('button').after(img);
        //     }
        //     else {
        //         var img = '<img style="margin: 5px 0 0 10px;" src="' + img_url + '"/>';
        //         $(element).closest('.switch').after(img);
        //     }
        },
        'success': function (data) {
            if(data.response) {
                var box = $('#success-box').clone();
                $(box).css('display', 'block');
                $(box).attr('id', '');
                $(element).closest('.panel').before(box);
//                location.reload();
                // $('html,body').animate({scrollTop: 0}, 1000);
            }
            else {
                if ($.inArray(key, switch_elements) !== -1) {
                    $(element).prop('checked', !$(element).is(':checked'));
                }
                var box = $('#error-box').clone();
                $(box).css('display', 'block');
                $(box).attr('id', '');
                $(element).closest('.panel').before(box);
                // $('html,body').animate({scrollTop: 0}, 1000);
            }
        },
        'error': function(error) {
            if ($.inArray(key, switch_elements) !== -1) {
                $(element).prop('checked', !element.is(':checked'));
            }
            var box = $('#error-box').clone();
            $(box).css('display', 'block');
            $(box).attr('id', '');
            $(element).closest('.panel').before(box);
            // $('html,body').animate({scrollTop: 0}, 1000);
        },
        'complete': function (jqXHR, textStatus) {
            if (textStatus =='parsererror') {
                location.reload();
            }
  
                setTimeout(function () {
                if ($.inArray(key, switch_elements) === -1) {
                    $(element).closest('td').find('img').remove();
                }
                else {
                    $(element).closest('.switch').next('img').remove();
                }
            }, 500);
        }
    });
}

function change_signup_settings(path_root, id, status)
{
    var set_change_path = path_root + "configuration/update_pending_signup_option";
    $.post(set_change_path, {id: id, status: status}, function (data)
    {
        location.reload();
    });
}

var msg11 = $('#user_name_length').html();
var msg12 = $('#user_name_prefix').html();
var msg13 = $('#digit_only').html();
var searchform = $('#signup_settings_form');
var errorHandler1 = $('.errorHandler', searchform);
$('#signup_settings_form').validate({
    errorElement: "span", // contain the error msg in a span tag
    errorClass: 'help-block',
    errorPlacement: function (error, element) {
        if($(element).parent('.input-group').length === 0) {
            error.insertAfter(element);
        }
        else {
            error.insertAfter($(element).closest('.input-group'));
        }
    },
    ignore: ':hidden',
    rules: {
        length: {
            required: true,
            digits:true
        },
        prefix: {
            required: true,
        }
    },
    messages: {
        length: {
          required: msg11,  
          digits: msg13
        }, 
        prefix: {
            required: msg12, 
        }
    },
    invalidHandler: function (event, validator) {
        errorHandler1.show();
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

function signupFieldConfig() {
    var base_url = $('#base_url').val();
    $('.signup_field').on('click', function () {
        
        $(this).closest('table').prev('.alert').remove();
        var id = $(this).data('id');
        var attr = $(this).attr('name');
        var status = $(this).is(':checked');
        var element = $(this);
        $.ajax({
            'url': base_url + "admin/configuration/update_signup_field_config",
            'type': "POST",
            'data': { id: id, status: status, attr: attr },
            'dataType': 'json',
            'beforeSend': function () {
                
            },
            'success': function (data) {
                if (data.response) {
                    var box = $('#success-box').clone();
                    $(box).css('display', 'block');
                    $(box).attr('id', '');
                    $(element).closest('table').before(box);
                    setTimeout(function() {
                        location.reload();
                    }, 500)
                }
                else {
                    $(element).prop('checked', !status);
                    var box = $('#error-box').clone();
                    $(box).css('display', 'block');
                    $(box).attr('id', '');
                    $(element).closest('table').before(box);
                }
            },
            'error': function (error) {
                $(element).prop('checked', !status);
                var box = $('#error-box').clone();
                $(box).css('display', 'block');
                $(box).attr('id', '');
                $(element).closest('table').before(box);
            },
            'complete': function (jqXHR, textStatus) {
                if (textStatus == 'parsererror') {
                    location.reload();
                }
            }
        });
    });
}

var ValidateConfiguration = function () {
    var runValidateConfiguration = function () {
        var msg26 = $("#validate_msg26").html();
        var msg30 = $("#validate_msg30").html();
        var age = $("#lang_age").html();

        var searchform = $('#signup_form');
        var errorHandler1 = $('.errorHandler', searchform);

        $('#signup_form').validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorId: 'err_config',
            errorPlacement: function (error, element) {
                if ($(element).parent('.input-group').length === 0) {
                    error.insertAfter(element);
                } else {
                    error.insertAfter($(element).closest('.input-group'));
                }
            },
            ignore: ':hidden',
            rules: {
                age_limit: {
                    required: true,
                    digits: true,
                    min: 1
                }
            },
            messages: {
                age_limit: {
                    required: msg26.replace('%s', age),
                    digits: msg30,
                    min: msg30
                }
            },
            invalidHandler: function () {
                errorHandler1.show();
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
    };

    return {
        init: function () {
            runValidateConfiguration();
        }
    };
}();
