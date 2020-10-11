function trim(a)
{

    return a.replace(/^\s+|\s+$/, '');
}

var ValidateMember = function () {
    // function to initiate Validation Sample 1

    var runValidateMemberSelection = function () {
        var msg = $("#errmsg").html();
        var searchform = $('#search_mem');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#search_mem').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block error',
            errorId: 'search_err',
            ignore: ':hidden',
            rules: {
                keyword: {
                    minlength: 1,
                    required: true
                }
            },
            messages: {
                keyword: msg
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
            runValidateMemberSelection();
        }
    };
}();
var ValidateManageMembers = function () {
    // function to initiate Validation Sample 1

    var runValidateMemberSelection = function () {
        var msg = $("#errmsg").html();
        var searchform = $('#manage_members');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#manage_members').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block error',
            errorId: 'search_err',
            errorPlacement: function (error, element) { // render error placement for each input type

                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                user_name: {
                    minlength: 1,
                    required: true
                },
            },
            messages: {
                user_name: msg
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
            runValidateMemberSelection();
        }
    };
}();
var ValidateChangeSponsorName = function () {
    // function to initiate Validation Sample 1

    var runValidateMemberSelection = function () {
        var msg = $("#error_msg1").html();
        var msg1 = $("#error_msg2").html();
        var searchform = $('#change_sponsor');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#change_sponsor').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type

                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                user_name: {
                    minlength: 1,
                    required: true
                },
                sponsor_user_name: {
                    minlength: 1,
                    required: true
                }
            },
            messages: {
                user_name: msg,
                sponsor_user_name: msg1
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
            runValidateMemberSelection();
        }
    };
}();
var ValidateChangePlacement = function () {
    // function to initiate Validation Sample 1

    var runValidateMemberSelection = function () {
        var msg = $("#error_msg1").html();
        var msg1 = $("#error_msg2").html();
        var msg2 = $("#error_msg3").html();
        var searchform = $('#change_placement');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#change_placement').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type

                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                user_name: {
                    minlength: 1,
                    required: true
                },
                new_user_name: {
                    minlength: 1,
                    required: true
                },
                position: {
                    minlength: 1,
                    required: true
                }
            },
            messages: {
                user_name: msg,
                new_user_name: msg1,
                position: msg2
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
            runValidateMemberSelection();
        }
    };
}();






var ValidateUpgradeMember = function () {
    // function to initiate Validation Sample 1

    var runValidateUpgradeMember = function () {
        var msg = $("#errmsg").html();
        var msg1 = $("#errmsg1").html();
        var searchform = $('#search_mem');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#search_mem').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type

                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                user_name: {
                    minlength: 1,
                    required: true
                },
                remarks: {
                    minlength: 1,
                    required: true
                }
            },
            messages: {
                user_name: msg,
                remarks: msg1
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
            runValidateUpgradeMember();
        }
    };
}();
var ValidateUpgradeMemberUser = function () {
    // function to initiate Validation Sample 1

    var runValidateUpgradeMemberUser = function () {
        var msg = $("#errmsg").html();
        var searchform = $('#search_mem');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#search_mem').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type

                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                transaction_password: {
                    minlength: 1,
                    required: true
                }
            },
            messages: {
                transaction_password: msg
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
            runValidateUpgradeMemberUser();
        }
    };
}();


function getSponsorName()
{
    var root = document.change_sponsor.path.value;
    var user_name = document.getElementById('user_name').value;

    if (user_name && user_name != '/') {
        var strURL = root + "/activate/getCurrentSponsor/" + user_name;
        var req = getXMLHTTP();
        if (req) {
            req.onreadystatechange = function () {
                if (req.readyState == 4) {
                    if (req.status == 200) {
                        document.getElementById('sponsor_name_div').innerHTML = trim(req.responseText);
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

function getPosition()
{
    var path_root = document.getElementById('path_root').value;
    var path_temp = document.getElementById('path_temp').value;
    var user_name_availability = path_root + "admin/activate/checkUserNameAvailability";
    $("#error_box").removeClass();
    $("#error_box").addClass('messagebox');
    $("#error_box").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" /> checking username availability..').show().fadeTo(1900, 1);

    $.post(user_name_availability, {user_name: $('#user_name').val()}, function (data)
    {
        var user_name = document.getElementById('user_name').value;

        if (trim(data) == 'no')
        {
            $("#error_box").fadeTo(200, 0.1, function ()
            {
                $("#error_box").removeClass();

                $("#error_box").addClass('messageboxerror');

                $("#error_box").html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" /> username does not exist..').show().fadeTo(1900, 1);



                document.getElementById('palcement_div').style.display = "none";

            });
        }
        else
        {
            $("#error_box").fadeTo(200, 0.1, function ()
            {
                $("#error_box").removeClass();

                $("#error_box").addClass('messageboxok');

                $("#error_box").html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" /> Username available..').show().fadeTo(1900, 1);
// document.getElementById('columns').style.display = "block";
                document.getElementById('palcement_div').style.display = "block";



                if (user_name && user_name != '/') {
                    var strURL = path_root + "admin/activate/getCurrentPlacementDetails/" + user_name;
                    var req = getXMLHTTP();
                    if (req) {
                        req.onreadystatechange = function () {
                            if (req.readyState == 4) {
                                if (req.status == 200) {
                                    document.getElementById('sponsor_name_div').innerHTML = trim(req.responseText);
                                } else {
                                    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                                }
                            }
                        }
                        req.open("GET", strURL, true);
                        req.send(null);
                    }
                }



            });
        }
    });
}

function highlightSearchKey(key) {
    var searchData = document.getElementsByClassName('search_data');
    for(var i = 0; i < searchData.length; i++) {
        searchData[i].innerHTML = searchData[i].innerHTML.replace(key, "<span>" + key + "</span>")
    }
}