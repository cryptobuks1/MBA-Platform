function trim(a)
{

    return a.replace(/^\s+|\s+$/, '');
}

function getXMLHTTP() { //fuction to return the xml http object
    var xmlhttp = false;
    try {
        xmlhttp = new XMLHttpRequest();
    }
    catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (e) {
            try {
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
            }
            catch (e1) {
                xmlhttp = false;
            }
        }
    }

    return xmlhttp;
}

function getAmountLeg()
{
    var root = document.fund_form.path.value;
    var user_name = document.getElementById('user_name').value;

    if (user_name && user_name != '/') {
        var strURL = root + "/ewallet/getLegAmount/" + user_name;
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
            req.send(null);
        }
    }
}
function getBalanceEPinNum(user_id)
{
    var root = document.fund_form.path.value;
    var strURL = root + "Ewallet/getBalance_EPin/user:" + user_id;
    var req = getXMLHTTP();
    if (req) {

        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                // only if "OK"
                if (req.status == 200) {
                    //alert(trim(req.responseText));
                    document.getElementById('fund1').innerHTML = trim(req.responseText);
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
function getPasswordMd(pswd)
{
    var root = document.fund_form.path.value;
    var strURL = root + "/ewallet/getPassWordInmd/" + pswd;
    var req = getXMLHTTP();
    if (req) {

        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                // only if "OK"
                if (req.status == 200) {
                    //alert(trim(req.responseText));
                    document.getElementById('hid_pass').innerHTML = trim(req.responseText);
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



$(document).ready(function()
{
    var msg = "";
    $("#amount").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
        {
            msg = $("#validate_msg1").html();
            //display error message
            $("#errmsg3").html(msg).show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#pin_count").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            msg = $("#validate_msg1").html();
            //display error message
            $("#errmsg3").html(msg).show().fadeOut(1200, 0);
            return false;
        }
    });

    $("#count").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            msg = $("#validate_msg1").html();
            //display error message
            $("#errmsg3").html(msg).show().fadeOut(1200, 0);
            return false;
        }
    });
});


var ValidateAdminEwallet = function() {
    // function to initiate Validation Sample 1
    var error_msg_user = $("#error_msg_user").html();
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var runValidateAdminEwallet = function() {
        var searchform = $('#fund_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#fund_form').validate({
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
                amount: {
                    minlength: 1,
                    required: true
                },
                pin_count: {
                    minlength: 1,
                    digits: true,
                    required: true,
                    maxlength: 2
                }
            },
            messages: {
                user_name: error_msg_user,
                amount: msg,
                pin_count: { 
                    minlength: msg1,
                    required: msg1,
                    digits: msg1,
                    maxlength: msg3 
                },

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
            runValidateAdminEwallet();

        }
    };
}();

var ValidateUserEwallet = function() {
    // function to initiate Validation Sample 1
    var error_msg_user = $("#error_msg_user").html();
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var runValidateUserEwallet = function() {
        var searchform = $('#searchform');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#searchform').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                amount: {
                    required: true
                },
                pin_count: {
                    minlength: 1,
                    digits: true,
                    required: true
                },
                passcode:{
                    required: true
                }
            },
            messages: {
                amount:msg,
                pin_count:{ 
                    required:msg1,
                    digits:msg3
                },
                passcode: msg2
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
            runValidateUserEwallet();

        }
    };
}();


$("#pin_count").keypress(function (e)
{
    var msg = $("#error_msg3").html();
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
    {
        $("#pin_count_err").html(msg).show().fadeOut(1200, 0);
        return false;
    }
});
$(function()
{
    ValidateUserEwallet.init();
    ValidateAdminEwallet.init(); 
});