var ValidateUser = function() {


    // function to initiate Validation Sample 1
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg6 = $("#error_msg8").html();
    var msg7 = $("#validate_msg18").html();
    var msg8 = $("#validate_msg19").html();
    var msg9 = $("#validate_msg20").html();
    var msg10 = $("#validate_msg17").html();

    ///////----for 'CHANGE USER PASSWORD' Tab - Begin/////////
    var runValidatorUserSelection = function() {

        jQuery.validator.addMethod("alpha_dash", function(value, element) {
            return this.optional(element) || /^[a-z0-9A-Z]*$/i.test(value);
        }, msg3);
        var searchform = $('#searchform');
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
        }, $("#validate_msg9").html());
        $('#searchform').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorId: 'err_change',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                user_name: {
                    required: true,
                    username_check:true
                },
                new_username: {
                    required: true,
                    minlength: 6,
                    maxlength: 12,
                    alpha_dash: true
                }
            },
            messages: {
                user_name: {required: msg10},
                new_username: {
                    required: msg2,
                    minlength: msg8,
                    maxlength: msg7,
                    alpha_dash: msg9


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
            runValidatorUserSelection();

        }
    };
}();
$("#new_username").keypress(function(e)
{
    var msg = $("#validate_msg15").html();
    //if the letter is not digit then display error and don't type anything

    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122))

    {
        //display error message            

        $("#errormsg3").html('<font color="red">' + msg + '</font>').show().fadeOut(2200, 0);

        return false;
    }

});
$("#user_name").keypress(function(e)
{
    //if the letter is not digit then display error and don't type anything
    var msg = $("#validate_msg15").html();
    if (e.which != 8 && e.which != 0 && (e.which < 47 || e.which > 57) && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122))

    {
        //display error message            

        $("#error_user_name").html('<font color="red">' + msg + '</font>').show().fadeOut(2200, 0);

        return false;
    }

});
function trim(a)
{
    return a.replace(/^\s+|\s+$/, '');
}

    function validateUsername()
    {
        var flag1 = false;
        var validated = '';
        //var flag2 = false;
        var path_root = $('#base_url').val();
        var path_temp = $('#img_src_path').val();
        var error = 0;
        var referral_name = $('#user_name').val();
        document.getElementById('change_username').disabled = 'TRUE';

        var ref_user_availability = path_root + "admin/profile/validate_username";
        var msg1 = $("#validate_msg9").html();
        var msg2 = $("#validate_msg10").html();
        var msg3 = $("#validate_msg11").html();
        var msg4 = $("#validate_msg17").html();
        $("#referral_box").removeClass();

        $("#error_user_name").addClass('messagebox');
        $("#error_user_name").removeClass();

        $("#error_user_name").addClass('messagebox');

        $("#error_user_name").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" /> ' + msg3).show().fadeTo(2200, 1);
        if ($("#user_name").val() == '') {
            error = 1;
            $("#error_user_name").fadeTo(2200, 1, function() //start fading the messagebox

            {


                //add message and change the class of the box and start fading

                $(this).removeClass();

                $(this).addClass('messageboxerror');

                $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg4).show().fadeTo(2200, 1);

                document.getElementById('change_username').disabled = 'TRUE';


            });
        }

        if (error != 1)

        {
            $.post(ref_user_availability, {username: $('#user_name').val()}, function(data)
            {
                if (trim(data) == 'no') //if username not avaiable
                {
                    $("#error_user_name").fadeTo(2200, 0.1, function() //start fading the messagebox
                    {
                        //add message and change the class of the box and start fading
                        $(this).removeClass();
                        $(this).addClass('messageboxerror');
                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg1).show().fadeTo(2200, 1);
                        //document.getElementById('referal_div').style.display = "none";
                        sponsor_ok = 0;
                        valid = 'validated';
                        flag1 = false;
                    });


                }
                else {
                    $("#error_user_name").fadeTo(2200, 0.1, function()  //start fading the messagebox
                    {
                        //add message and change the class of the box and start fading
                        $(this).removeClass();
                        $(this).addClass('messageboxok');
                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg2).show().fadeTo(2200, 1);
                        flag1 = true;
                        sponsor_ok = 1;
                        valid = 'validated';
                        flag1 = true;
                    });

                }
            });
        }
        if(validated == 'validated') {
            return flag1;
        }
    }
$(document).ready(function()
{
//    var flag1 = false;
    var flag2 = false;
    var path_root = $('#base_url').val();
    var path_temp = $('#img_src_path').val();
    //$("#user_name").blur(function()



    $("#new_username").blur(function()

    {
        //validateUsername();
        var msg1 = $("#validate_msg12").html();
        var msg2 = $("#validate_msg13").html();
        var msg3 = $("#validate_msg14").html();
        var msg4 = $("#validate_msg16").html();
        var msg5 = $("#validate_msg17").html();
        var msg6 = $("#validate_msg18").html();
        var msg7 = $("#validate_msg20").html();
        document.getElementById('change_username').disabled = 'TRUE';
        // if (username_type == "static") {
        var error = 0;

//        if ($("#new_username").val() == '') {
//            error = 1;
//
//            $("#errormsg3").fadeTo(2200, 0.1, function() //start fading the messagebox
//
//            {
//
//                //add message and change the class of the box and start fading
//
//                $(this).removeClass();
//
//                $(this).addClass('messageboxerror');
//
//                $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg5).show().fadeTo(2200, 1);
//
//                document.getElementById('change_username').disabled = 'TRUE';
//
//            });
//        }
        if (!(/^[a-zA-Z0-9]+$/.test($("#new_username").val()))) {
            error = 1;

            $("#errormsg3").fadeTo(2200, 0.1, function() //start fading the messagebox

            {

                //add message and change the class of the box and start fading

                $(this).removeClass();

                $(this).addClass('messageboxerror');

                $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg7).show().fadeTo(2200, 1);

                document.getElementById('change_username').disabled = 'TRUE';

            });
        }
        
        if (error != 1)

        {
            var length = $('#new_username').val().length;

            if (length >= 6 && length <=12)
            {
                var user_name_availability = path_root + "admin/profile/ajax_is_username_available"
                var msg = $("#validate_msg27").html();

                //remove all the class add the messagebox classes and start fading

                $("#errormsg3").removeClass();

                $("#errormsg3").addClass('messagebox');

                $("#errormsg3").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" /> ' +$("#validate_msg21").html()).show().fadeTo(2200, 1);

                //check the username exists or not from ajax

                $.post(user_name_availability, {user_name: $('#new_username').val()}, function(data)

                {

                    if (trim(data) == 'no') //if username not avaiable

                    {

                        $("#errormsg3").fadeTo(2200, 0.1, function() //start fading the messagebox

                        {
                            var msg;
                            msg = $("#validate_msg28").html();

                            //add message and change the class of the box and start fading

                            $(this).removeClass();

                            $(this).addClass('messageboxerror');

                            $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg2).show().fadeTo(2200, 1);

                            document.getElementById('change_username').disabled = 'TRUE';

                        });

                    }

                    else

                    {

                        $("#errormsg3").fadeTo(2200, 0.1, function()  //start fading the messagebox

                        {


                            $(this).removeClass();

                            $(this).addClass('messageboxok');

                            $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg3).show().fadeTo(2200, 1);

                                document.getElementById("change_username").removeAttribute("disabled");

                        });

                    }

                });
            }
            else if (length < 6) {
                $("#errormsg3").fadeTo(2200, 0.1, function()  //start fading the messagebox

                {
                    msg = $("#validate_msg63").html();

                    $(this).removeClass();

                    $(this).addClass('messageboxerror');

                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg4).show().fadeTo(2200, 1);

                    document.getElementById('change_username').disabled = 'TRUE';
                });
            } 
            
            else if (/^[a-zA-Z]+$/.test($("#new_username").val()) == 0) {
                $("#errormsg3").fadeTo(2200, 0.1, function ()  //start fading the messagebox
                {
                    $(this).removeClass();

                    $(this).addClass('messageboxerror');

                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + 'dgfgh').show().fadeTo(2200, 1);

                    document.getElementById('change_username').disabled = 'TRUE';
                });
            }
        }
    });
});


