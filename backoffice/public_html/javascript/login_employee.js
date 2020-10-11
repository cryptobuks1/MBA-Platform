function trim(s) {
    return s.replace(/^\s+|\s+$/, '');
}
var ValidateEmployeeLogin = function() {

    // function to initiate Validation Sample 1
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    ///////----for 'CHANGE USER PASSWORD' Tab - Begin/////////
    var runValidatorUserSelection = function() {
        var searchform = $('#login_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#login_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                user_name: {
                    required: true
                },
                password: {
                    required: true
                }
            },
            messages: {
                user_name: msg1,
                password: msg2
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
                var pass = $("#password").val();
                pass = encodeURIComponent(window.btoa(pass));
                $("#password").val(pass);
                event.preventDefault();
                form.submit();
            }
        });
    };
    return {
        //main function to initiate template pages
        init: function() {
            runValidatorUserSelection();
        }
    };
}();
var ValidateEmployee = function() {
    // function to initiate Validation Sample 1
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg4 = $("#error_msg4").html();
    ///////----for 'CHANGE USER PASSWORD' Tab - Begin/////////
    var runValidatorUserSelection = function() {
        var searchform = $('#login_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#login_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                admin_username: {
                    required: true
                },
                user_username: {
                    required: true
                },
                user_password: {
                    required: true
                }
            },
            messages: {
                admin_username: msg1,
                user_username: msg2,
                user_password: msg4,
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
                var pass = $("#employee_password").val();
                pass = encodeURIComponent(window.btoa(pass));
                $("#employee_password").val(pass);
                event.preventDefault();
                form.submit();
            }
        });
    };
    return {
        //main function to initiate template pages
        init: function() {
            runValidatorUserSelection();
        }
    };
}();
var ValidateEmployeeRegister = function() {
    // function to initiate Validation Sample 1
    var msg1 = $("#error_employee_msg1").html();
    var msg2 = $("#error_employee_msg2").html();
    ///////----for 'CHANGE USER PASSWORD' Tab - Begin/////////
    var runValidatorUserSelection = function() {
        var searchform = $('#login_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#login_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                employee_username: {
                    required: true
                },
                employee_password: {
                    required: true
                }
            },
            messages: {
                employee_username: msg1,
                employee_password: msg2,
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
                var pass = $("#employee_password").val();
                pass = encodeURIComponent(window.btoa(pass));
                $("#employee_password").val(pass);
                event.preventDefault();
                form.submit();
            }
        });
    };
    return {
        //main function to initiate template pages
        init: function() {
            runValidatorUserSelection();
        }
    };
}();

function getSwitchLanguage(lang) {
    var url = "";
    var base_url = $("#base_url").val();
    var current_url = $("#current_url").val();
    var current_url_full = $("#current_url_full").val();

    if (current_url != current_url_full) {
        url = current_url_full;
    } else {
        url = current_url;
    }
    var redirect_url = base_url;

    redirect_url = base_url + lang + "/" + url;
    document.location.href = redirect_url;
}

$(function() {
    ValidateEmployee.init();

    $('#admin_username').keydown(function(e) {
        if (e.keyCode == 32) // 32 is the ASCII value for a space
            e.preventDefault();
    });

    $('#employee_username').keydown(function(e) {
        if (e.keyCode == 32) // 32 is the ASCII value for a space
            e.preventDefault();
    });

    $('#employee_password').keydown(function(e) {
        if (e.keyCode == 32) // 32 is the ASCII value for a space
            e.preventDefault();
    });
});