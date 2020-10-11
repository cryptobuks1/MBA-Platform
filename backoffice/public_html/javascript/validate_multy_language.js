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

function change_language_status(lang_id, status)
{
    var path_root = $("#base_url").val();
    var path_temp = $("#base_url").val() + "public_html/";

    var set_module_status = path_root + "admin/configuration/change_language_status";
    var msg = " Loading....";
    $("#" + lang_id + "_status_message").removeClass();
    $("#" + lang_id + "_status_message").addClass('messagebox');
    $("#" + lang_id + "_status_message").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" />' + msg).show().fadeTo(1900, 1);

    $.post(set_module_status, {lang_id: lang_id, status: status}, function(data)
    {
        location.reload();
    });
}

function set_default_language(lang_id)
{
    var path_root = $("#base_url").val();
    var path_temp = $("#base_url").val() + "public_html/";
    var set_default_language = path_root + 'admin/multi_language/set_default_language';
    var msg = " Loading....";
    $("#" + lang_id + "_message").removeClass();
    $("#" + lang_id + "_message").addClass('messagebox');
    $("#" + lang_id + "_message").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" />' + msg).show().fadeTo(1900, 1);

    $.post(set_default_language, {lang_id: lang_id}, function(data)
    {
        location.reload();
    });
}

function delete_language(id)
{
    var path_root = $("#path_root").val();
    var confirm_msg = $("#error_msg6").html();
    if (confirm(confirm_msg))
    {
        alert(path_root + 'admin/multi_language/delete/' + id);
        document.location.href = path_root + 'admin/multi_language/delete/' + id;
    }
}

function edit_language(id)
{
    var path_root = $("#path_root").val();
    var confirm_msg = $("#error_msg7").html();
//    if (confirm(confirm_msg))
//
//    {
        document.location.href = path_root + 'admin/multi_language/edit_language/' + id;
//    }
}

var validate_multy_language = function() {

    // function to initiate Validation Sample 1

    var runValidateLanguageSelection = function() {
        var msg1 = $("#validate_msg1").html();
        var msg2 = $("#validate_msg2").html();
        var msg3 = $("#validate_msg3").html();
        var msg4 = $("#validate_msg4").html();
        var msg5 = $("#validate_msg5").html();
        var msg6 = $("#validate_msg6").html();
        var msg7 = $("#validate_msg7").html();
        var msg = $("#errmsg").html();
        var searchform = $('#language_entry');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#language_entry').validate({
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
                //error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                lang_code: {
                    minlength: 1,
                    required: true

                },
                lang_name: {
                    minlength: 1,
                    required: true

                },
                lang_name_in_english: {
                    minlength: 1,
                    required: true

                },
                status: {
                    minlength: 1,
                    required: true

                }

            },
            messages: {
                lang_code: msg1,
                lang_name: msg2,
                lang_name_in_english: msg3,
                status: msg7


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
            runValidateLanguageSelection();
        }
    };
}();