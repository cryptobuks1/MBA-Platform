$(function (){
    ValidatePassword.init();
    $('body').on('click', '#ajax_listOfOptions > div', function () {
        var username = $(this).text();
        var path_root = $('#base_url').val();
        $.post(path_root, {username: username}, uservaliditycheck(username)

                );
    });

    $('body').on('keypress keydown keyup', 'input#user_name_common', function (e) {
        var path_root = $('#base_url').val();
        if ($('#ajax_listOfOptions').is(':visible')) {
            if (e.which == 13 || e.which == 9) {
                e.preventDefault();
                e.stopPropagation();
                var username = $('.optionDivSelected').text();
                $.post(path_root, {username: username}, uservaliditycheck(username));

            }
        }
    });
});
var ValidatePassword = function () {


    // function to initiate Validation Sample 1
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#error_msg6").html();
    var msg5 = $("#error_msg6").html();
    var msg6 = $("#error_msg8").html();
    var msg7 = $("#validate_msg14").html();
    var msg8 = $("#validate_msg15").html();
    var msg9 = $("#error_msg4").html();
    var msg16 = $("#validate_msg16").html();
    ///////----for 'CHANGE USER PASSWORD' Tab - Begin/////////
    var runValidatorUserSelection = function () {

        $.validator.addMethod("alpha_password", function (value, element) {
            return this.optional(element) || value == value.match(/^[0-9a-zA-Z\s\r\n@!#\$\^%&*()+=\-\[\]\\\';,\.\/\{\}\|\":<>\?\_\`\~]+$/);
        }, msg6);
        var searchform = $('#change_pass_common');
        var errorHandler1 = $('.errorHandler', searchform);
        $.validator.addMethod("username_check", function(value, element) {
            var path_root = $('#base_url').val();
            var flag2 = false;
            if (value != "/" && value != ".") {
                $.ajax({
                    'url': path_root + getUserType() + "/profile/validate_username",
                    'type': "POST",
                    'data': {
                        username: value
                    },
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
        }, $("#validate_msg10").html());
        $('#change_pass_common').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorId: 'err_change',
            errorPlacement: function (error, element) { // render error placement for each input type

                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                user_name_common: {
                    minlength: 1,
                    required: true,
                    username_check:true
                },
                new_pwd_common: {
                    minlength: 6,
                    maxlength: 32,
                    required: true,
                    alpha_password: true
                },
                confirm_pwd_common: {
                    minlength: 6,
                    maxlength: 32,
                    required: true,
                    equalTo: "#new_pwd_common",
                    alpha_password: true
                }
            },
            messages: {
                user_name_common: {required: msg7,minlength: msg2,maxlength:msg16,},
                new_pwd_common: {required: msg5,
                    minlength: msg2,maxlength:msg16,
                    alpha_password: msg6
                },
                confirm_pwd_common: {required: msg9,
                    minlength: msg2,maxlength:msg16,
                    equalTo: msg3,
                    alpha_password: msg6}

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
            },
            submitHandler: function(form) {
                var pass = $("#new_pwd_common").val();
                var cpass = $("#confirm_pwd_common").val();
                pass = encodeURIComponent(window.btoa(pass));
                cpass = encodeURIComponent(window.btoa(cpass));
                $("#new_pwd_common").val(pass);
                $("#confirm_pwd_common").val(cpass);
                event.preventDefault();
                form.submit();
            }
        });
    };
    var runValidatorAdminSelection = function () {
        $.validator.addMethod("alpha_password", function (value, element) {
            return this.optional(element) || value == value.match(/^[0-9a-zA-Z\s\r\n@!#\$\^%&*()+=\-\[\]\\\';,\.\/\{\}\|\":<>\?\_\`\~]+$/);
        }, msg6);
        var searchform = $('#change_pass_admin');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#change_pass_admin').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorId: 'err_admin',
            errorPlacement: function (error, element) { // render error placement for each input type

                error.insertAfter(element);
                // for other inputs, just perform default behavior

            },
            ignore: ':hidden',
            rules: {
                current_pwd_admin: {
                    required: true,
                    minlength: 6,
                    maxlength: 32,
                    alpha_password: true
                },
                new_pwd_admin: {
                    required: true,
                    minlength: 6,
                    maxlength: 32,
                    alpha_password: true
                },
                confirm_pwd_admin: {
                    alpha_password: true,
                    required: true,
                    minlength: 6,
                    maxlength: 32,
                    equalTo: "#new_pwd_admin"
                }


            },
            messages: {
                current_pwd_admin: {required: msg1,
                    minlength: msg2,maxlength:msg16,
                    alpha_password: msg6},
                new_pwd_admin: {required: msg5,
                    minlength: msg2,maxlength:msg16,
                    alpha_password: msg6},
                confirm_pwd_admin: {required: msg9,
                    minlength: msg2,maxlength:msg16,
                    equalTo: msg3,
                    alpha_password: msg6}
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
            },
            submitHandler: function(form) {
                var opass = $("#current_pwd_admin").val();
                var pass = $("#new_pwd_admin").val();
                var cpass = $("#confirm_pwd_admin").val();
                opass = encodeURIComponent(window.btoa(opass));
                pass = encodeURIComponent(window.btoa(pass));
                cpass = encodeURIComponent(window.btoa(cpass));
                $("#current_pwd_admin").val(opass);
                $("#new_pwd_admin").val(pass);
                $("#confirm_pwd_admin").val(cpass);
                event.preventDefault();
                form.submit();
            }
        });
    };



    return {
        //main function to initiate template pages
        init: function () {
            runValidatorUserSelection();
            runValidatorAdminSelection();
        }
    };
}();
function trim(a)
{
    return a.replace(/^\s+|\s+$/, '');
}
function uservaliditycheck(username)
{
    document.getElementById('change_pass_button_common').disabled = 'TRUE';
    var error = 0;

    var path_root = $('#base_url').val();
    var path_temp = $('#path_temp').val();
    var ref_user_availability = path_root + "admin/password/validate_username";
    var msg1 = $("#validate_msg12").html();
    var msg2 = $("#validate_msg10").html();
    var msg3 = $("#validate_msg11").html();
    var msg4 = $("#validate_msg13").html();
    var msg5 = $("#validate_msg14").html();
    $("#referral_box").removeClass();

    $("#erro_user_name").addClass('messagebox');
    $("#erro_user_name").removeClass();

    $("#erro_user_name").addClass('messagebox');
    $("#erro_user_name").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" /> ' + msg1).show().fadeTo(2200, 1);
    if (username == '') {
        error = 1;
        $("#erro_user_name").fadeTo(2200, 0.1, function () //start fading the messagebox

        {


            //add message and change the class of the box and start fading

            $(this).removeClass();

            $(this).addClass('messageboxerror');

            $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg5).show().fadeTo(2200, 1);

        });
    }

    if (error != 1)

    {
        $.post(ref_user_availability, {username: username}, function (data)
        {
            if (trim(data) == 'no') //if username not avaiable
            {
                //$("#erro_user_name").html(msg7).show().fadeOut(2200, 0);
                $("#erro_user_name").fadeTo(2200, 0.1, function () //start fading the messagebox
                {
                    //add message and change the class of the box and start fading
                    $(this).removeClass();
                    $(this).addClass('messageboxerror');
                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg2).show().fadeTo(2200, 1);
                    document.getElementById('referal_div').style.display = "none";
                    sponsor_ok = 0;
                    //check_step1(sponsor_ok, position_ok, product_ok);
                });
            } else {
                $("#erro_user_name").fadeTo(2200, 0.1, function ()  //start fading the messagebox
                {
                    //add message and change the class of the box and start fading
                    $(this).removeClass();
                    $(this).addClass('messageboxok');
                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg3).show().fadeTo(2200, 1);
                    //get_referral_name(referral_name);
                    sponsor_ok = 1;
                    //enable_change_pass_button_common();
                    document.getElementById("change_pass_button_common").removeAttribute("disabled");
                    //check_step1(sponsor_ok, position_ok, product_ok);
                });

            }
        });
    }
}

