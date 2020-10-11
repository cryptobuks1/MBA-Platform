
$(document).ready(function()

{
    var msg = "";
    var msg1 = $("#error_msg17").html();
    var msg2 = $("#error_msg18").html();
    var msg3 = $("#error_msg19").html();
    $("#pin").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            //display error message
            // msg = $("#validate_msg").html();
            $("#errmsg4").html(msg1).show().fadeOut(1200, 0);
            return false;
        }
        return true;
    });
    $("#mobile").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            //display error message
            msg = $("#validate_msg").html();
            $("#errmsg3").html(msg).show().fadeOut(1200, 0);
            return false;
        }
        return true;
    });
    $("#land_line").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            //display error message
            // msg = $("#validate_msg").html();
            $("#errmsg5").html(msg1).show().fadeOut(1200, 0);
            return false;
        }
        return true;
    });
    $("#full_name").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which >= 48 && e.which <= 57))
        {
            //display error message
            // msg = $("#validate_msg").html();
            $("#errmsg5").html(msg2).show().fadeOut(1200, 0);
            return false;
        }
        return true;
    });
});

function trim(a)

{

    return a.replace(/^\s+|\s+$/, '');

}

function disable()

{

    document.user_register.register.disabled = true;

}

function enable()
{

    document.user_register.register.disabled = false;

}
function check_username_availability(username) {
    var error = 0;
    var path_temp = document.user_register.path_temp.value;
    var path_root = document.user_register.path_root.value;

    if (username == "" || username.length < 6)

    {
        var msg = "";
        $("#username_box").removeClass();

        $("#username_box").addClass('messagebox');

        msg = $("#error_msg12").html();

        $("#username_box").html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + '<font color="#a94442">' + msg + '</font>').show().fadeTo(1900, 1);

        error = 1;

        disable();

    }
    if (username == "" || username.length > 12) {
        error = 1;

        disable();
    }

    if (error != 1)

    {
        var msg = "";
        disable();

        var username_available = path_root + "admin/employee/employee_username_availability";
        //remove all the class add the messagebox classes and start fading

        $("#username_box").removeClass();

        $("#username_box").addClass('messagebox');

        msg = $("#error_msg13").html();
        
        $("#username_box").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" /> ' + msg).show().fadeTo(1900, 1);

        //check the username exists or not from ajax
        $.post(username_available, {
            user_name: username
        }, function(data)

        {

            if (trim(data) == 'yes') //if username not avaiable

            {

                $("#username_box").fadeTo(200, 0.1, function()  //start fading the messagebox

                {

                    //add message and change the class of the box and start fading

                    $(this).removeClass();

                    $(this).addClass('messageboxok');

                    msg = $("#error_msg14").html();
                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" /> ' + msg).show().fadeTo(1900, 1);

                    enable();

                });

            }

            else

            {

                $("#username_box").fadeTo(200, 0.1, function() //start fading the messagebox

                {

                    //add message and change the class of the box and start fading

                    $(this).removeClass();

                    $(this).addClass('messageboxerror');

                    msg = $("#error_msg12").html();
                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" /> ' + '<font color="#a94442">' + msg + '</font>').show().fadeTo(1900, 1);

                    disable();

                });

            }

        });

    }
}

function validate_registration_employee(user_register)
{
    var numberRegex = /^[0-9]+/;

    var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;

    var full_name = user_register.full_name.value;

    var ref_username = user_register.ref_username.value;

    var pswd = user_register.pswd.value;

    var cpswd = user_register.cpswd.value;

    var mobile = user_register.mobile.value;

    var email = user_register.email.value;

    var msg = "";

    if (full_name == "")
    {
        msg = $("#error_msg1").html();
        inlineMsg('full_name', msg, 2);
        return false;
    }

    if (ref_username == "")
    {
        msg = $("#error_msg2").html();
        inlineMsg('ref_username', msg, 2);
        return false;
    }

    if (pswd == "")
    {
        msg = $("#error_msg3").html();
        inlineMsg('pswd', msg, 2);
        return false;
    }

    if (pswd.length < 6)
    {
        msg = $("#error_msg5").html();
        inlineMsg('pswd', msg, 2);
        return false;
    }

    if (cpswd == "")
    {
        msg = $("#error_msg4").html();
        inlineMsg('cpswd', msg, 2);
        return false;
    }

    if (pswd != cpswd)
    {
        msg = $("#error_msg6").html();
        inlineMsg('pswd', msg, 2);
        return false;
    }

    if (mobile == "")
    {
        msg = $("#error_msg7").html();
        inlineMsg('mobile', msg, 2);
        return false;
    }

    if (!mobile.match(numberRegex))
    {
        msg = $("#error_msg8").html();
        inlineMsg('mobile', msg, 2);
        return false;
    }

    if (mobile.length < 10)
    {
        msg = $("#error_msg11").html();
        inlineMsg('mobile', msg, 2);
        return false;
    }

    if (email == "")
    {
        msg = $("#error_msg9").html();
        inlineMsg('email', msg, 2);
        return false;
    }

    if (!email.match(emailRegex))
    {
        msg = $("#error_msg10").html();
        inlineMsg('email', msg, 2);
        return false;
    }

    return true;
}





/*
 var ValidateUser= function() {
 
 //alert('fgdf');
 // function to initiate Validation Sample 1
 var msg = $("#error_msg").html();
 var msg1 = $("#error_msg1").html();
 var msg2 = $("#error_msg2").html();
 var msg3 = $("#error_msg3").html();
 var msg4 = $("#error_msg4").html();
 var msg5 = $("#error_msg5").html();
 var runValidatorweeklySelection = function() {
 var searchform = $('#user_register');
 var errorHandler1 = $('.errorHandler', searchform);
 $('#user_register').validate({
 errorElement: "span", // contain the error msg in a span tag
 errorClass: 'help-block',
 errorPlacement: function(error, element) { // render error placement for each input type
 
 //error.insertAfter(element);
 error.insertAfter($(element).closest('.input-group'));
 // for other inputs, just perform default behavior
 },
 ignore: ':hidden',
 rules: {
 mobile: {
 minlength: 10,
 required: true
 },
 full_name: {
 minlength: 1,
 required: true
 },
 ref_username: {
 minlength: 1,
 required: true
 },
 pswd: {
 minlength: 6,
 required: true
 },
 cpswd: {
 minlength: 6,
 required: true,
 equalTo: "#pswd"
 },
 
 email:{
 minlength: 1,
 required: true,
 email: true
 
 }
 },
 messages: {
 mobile: msg5,
 full_name:msg,
 ref_username: msg1,
 pswd:msg2,
 cpswd: msg3,
 email: {
 required: msg4,
 email: "Your email address must be in the format of name@domain.com"
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
 };
 
 return {
 //main function to initiate template pages
 init: function() {
 runValidatorweeklySelection();
 
 }
 };
 }();
 
 */
////=============================================edited by amrutha
// $(document).ready(function() {
//    var msg = $("#error_msg").html();
//    var msg1 = $("#error_msg1").html();
//    var msg2 = $("#error_msg2").html();
//    var msg3 = $("#error_msg3").html();
//    var msg4 = $("#error_msg4").html();
//    var msg5 = $("#error_msg5").html();
//        $("#user_register").validate({
//            submitHandler:function(form) {
//                SubmittingForm();
//            },
//            rules: {
//                full_name: {
//                    minlength: 1,
//                    required: true
//                },
//                ref_username: {
//                    minlength: 1,
//                    required: true
//                },
//               
//                pswd:{
//                     minlength: 6,
//                    required: true
//                },
//                cpswd: {
//                    minlength: 6,
//                    required: true,
//                    equalTo: "#pswd"
//                },
//                mobile: {
//                    minlength: 10,
//                    required: true
//                },
//                email: {               
//                    required: true,
//                    email: true,
//                    minlength: 1
//                },
//                
//            },
//            messages: {
//                full_name: msg,//"Please enter your name",
//                ref_username:msg1,//"Enter your username",
//                pswd:msg2,//"enter pass",
//                cpswd:msg3,//"confirm pass",
//                mobile:msg5, //"Please enter your phone",
//                email:msg4 //"Please enter valid email adress",
//                
//            }
//        });
//    });
//=============================================


//************************************************edited by amrutha

var ValidateUser = function() {


    // function to initiate Validation Sample 1
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#error_msg4").html();
    var msg5 = $("#error_msg5").html();
    var msg6 = $("#error_msg6").html();
    var msg7 = $("#error_msg7").html();
    var msg8 = $("#error_msg8").html();
    var msg9 = $("#error_msg16").html();
    var msg10 = $("#error_msg19").html();
    var msg11 = $("#error_msg20").html();
    var msg12 = $("#error_msg21").html();
    var msg13 = $("#error_msg23").html();
    var msg14 = $("#error_msg24").html();
    
    var runValidatorweeklySelection = function() {
        var searchform = $('#user_register');
        $.validator.addMethod("alpha_num", function(value, element) {
            return this.optional(element) || value == value.match(/^[A-Za-z0-9]+$/);
        }, msg10);
        var errorHandler1 = $('.errorHandler', searchform);
        $('#user_register').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                 error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                mobile_no: {
                    digits: true,
                    minlength: 5,
                    maxlength:10,
                    required: true
                },
                first_name: {
                    minlength: 3,
                    maxlength: 32,
                    required: true,
		    alpha_num: true
                },
                last_name: {
                    minlength: 2,
                    maxlength: 32,
                    required: true,
		    alpha_num: true
                },
                ref_username: {
                    minlength: 6,
                    maxlength: 12,
                    required: true,
                    alpha_num: true
                },
                pswd: {
                    minlength: 6,
                    required: true
                },
                cpswd: {
                    minlength: 6,
                    required: true,
                    equalTo: "#pswd"
                },
                email: {
                    minlength: 1,
                    required: true,
                    email: true

                }
              
            },
            messages: {
                first_name: {
		    required:msg7
		},
                last_name: {
		    required:msg8
		},
                ref_username: {required: msg1,minlength:msg9
                },
                mobile_no: {required: msg5,minlength:msg12
                },
                pswd:{ 
                    required:msg2,
                    minlength:msg13
                },
                cpswd:{ 
                    required:msg3,
                    minlength:msg13,
                    equalTo:msg14
                },
                email: {
                    required: msg4,
                    email: msg6
                },
              date_of_birth:{
                     required: msg11
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
    };

    return {
        //main function to initiate template pages
        init: function() {
            runValidatorweeklySelection();

        }
    };
}();