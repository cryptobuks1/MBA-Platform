var ValidateUser = function() {

    var err_name_required = $("#err_name_required").html();
    var err_name_alpha_spec = $("#err_name_alpha_spec").html();
    var err_name_minlength = $("#err_name_minlength").html();
    var err_second_name_required = $("#err_second_name_required").html();
    var err_second_name_alpha_spec = $("#err_second_name_alpha_spec").html();
    var err_second_name_minlength = $("#err_second_name_minlength").html();
    var err_gender_required = $("#err_gender_required").html();
    var err_address_required = $("#err_address_required").html();
    var err_address_alpha_num = $("#err_address_alpha_num").html();
    var err_address_line2_required = $("#err_address_line2_required").html();
    var err_address_line2_alpha_num = $("#err_address_line2_alpha_num").html();
    var err_email_required = $("#err_email_required").html();
    var err_email_format = $("#err_email_format").html();
    var err_city_required = $("#err_city_required").html();
    var err_city_alpha_num = $("#err_city_alpha_num").html();
    var err_mobile_required = $("#err_mobile_required").html();
    var err_mobile_digits = $("#err_mobile_digits").html();
    var err_mobile_minlength = $("#err_mobile_minlength").html();
    var err_pan_incorrect_format = $("#err_pan_incorrect_format").html();
    var err_user_name_required = $("#err_user_name_required").html();
    var err_pin_maxlength = $("#err_pin_maxlength").html();
    var err_pin_minlength = $("#err_pin_minlength").html();

    var runValidatorweeklySelection = function() {
        var searchform = $('#user_register');
        var errorHandler1 = $('.errorHandler', searchform);

        $('#user_register').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type
                if ($(element).hasClass("date-picker")) {
                    error.insertAfter($(element).closest('.input-group'));
                }
                else
                {
                    error.insertAfter(element);
                }
                ;
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                gender: {
                    minlength: 1,
                    required: true
                },
                name: {
                    minlength: 3,
                    maxlength: 32,
                    required: true,
                    alpha_spec: true
                },
                email: {
                    required: true,
                    email: true
                },
                address: {
                    minlength: 3,
                    maxlength: 35,
                    required: true,
                    alpha_num: true
                },
                address_line2: {
                    minlength: 3,
                    maxlength: 32,
                    alpha_num: true
                },
                city: {
                    minlength: 1,
                    required: true,
                    alpha_num: true
                },
                second_name: {
                    minlength: 3,
                    maxlength: 32,
                    required: true,
                    alpha_spec: true
                },
                mobile: {
                    minlength: 5,
                    required: true,
                    number: true,
                },
                pan_no: {
                    panFormat: true

                },
                land_line: {
                    number: true
                },
                bank_name: {
                    alpha_spec: true
                },
                bank_branch: {
                    alpha_spec: true
                },
                bank_acc_no: {
                    number: true
                },
                ifsc: {
                    alpha_spec: true
                },
                pin: {
                    minlength: 3,
                    maxlength: 10
                }
            },
            messages: {
                name: {
                    required: err_name_required,
                    alpha_spec: err_name_alpha_spec,
                    minlength: err_name_minlength},
                second_name: {
                    required: err_second_name_required,
                    alpha_spec: err_second_name_alpha_spec,
                    minlength: err_second_name_minlength},
                gender: err_gender_required,
                address: {
                    required: err_address_required,
                    alpha_num: err_address_alpha_num
                },
                address_line2: {
                    required: err_address_line2_required,
                    alpha_num: err_address_line2_alpha_num
                },
                email: {
                    required: err_email_required,
                    email: err_email_format
                },
                pan_no: err_pan_incorrect_format,
                city: {
                    required: err_city_required,
                    alpha_num: err_city_alpha_num
                },
                pin: {
                    minlength: err_pin_minlength,
                    maxlength: err_pin_maxlength
                },
                mobile: {
                    required: err_mobile_required,
                    digits: err_mobile_digits,
                    minlength: err_mobile_minlength
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
        jQuery.validator.addMethod("FullDate", function() {
            //if all values are selected
            if (($("#day").val() != "" || $("#day").val() == "00") && ($("#month").val() != "" || $("#month").val() != "00") && ($("#year").val() != "" || $("#year").val() != "0000")) {
                return true;
            } else {
                return false;
            }
        }, 'Please select a date ');
        jQuery.validator.addMethod("panFormat", function(value, element) {

            if (value == 'NA') {
                return true
            } else {
                return this.optional(element) || value == value.match(/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/);
            }
        });
    };
    var runValidatorUserSelection = function() {
        var err_user_name_required = $("#errmsg1").html();
        var searchform = $('#searchform');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#searchform').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type
                if ($(element).hasClass("date-picker")) {
                    error.insertAfter($(element).closest('.input-group'));
                }
                else
                {
                    error.insertAfter(element);
                }
                ;
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                user_name: {
                    required: true
                }
            },
            messages: {
                user_name: err_user_name_required
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
            runValidatorUserSelection();

        }
    };
}();