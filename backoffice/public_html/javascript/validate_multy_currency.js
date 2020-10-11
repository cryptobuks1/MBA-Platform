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
function change_conversion_status(status, path_root) {


    var strURL = path_root + "admin/currency/change_conversion_status/" + status;

    var req = getXMLHTTP();
    if (req) {

        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                // only if "OK"			
                if (req.status == 200)
                {
                    location.reload();

                }
                else
                {

                }
            }
        }
        req.open("GET", strURL, true);

        req.send(null);
    }
}
$(function(){
    var validate_multy_currency = function () {

        // function to initiate Validation Sample 1

        var runValidateCurrencySelection = function () {
            var msg1 = $("#validate_msg1").html();
            var msg2 = $("#validate_msg2").html();
            var msg3 = $("#validate_msg3").html();
            var msg4 = $("#validate_msg4").html();
            var msg5 = $("#validate_msg5").html();
            var msg6 = $("#validate_msg6").html();
            var msg7 = $("#validate_msg7").html();
            var msg08 = $("#validate_msg8").html();
            var msg = $("#errmsg").html();
            var msg8 = $("#error_msg10").html();
            var msg9 = $("#error_msg11").html();
            var searchform = $('#currency_entry');
            var errorHandler1 = $('.errorHandler', searchform);
            $('#currency_entry').validate({
                errorElement: "span", // contain the error msg in a span tag
                errorClass: 'help-block',
                errorPlacement: function (error, element) { // render error placement for each input type
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
                    currency_title: {
                        minlength: 1,
                        maxlength: 32,
                        required: true

                    },
                    currency_code: {
                        minlength: 1,
                        required: true

                    },
                    currency_value: {
                        required: true,
                        number: true,
                        min: 0.00001

                    },
                    decimal: {
                        minlength: 1,
                        required: true

                    },
                    status: {
                        minlength: 1,
                        required: true
                    },
                    symbol_type: {
                        minlength: 1,
                        required: true
                    },
                    symbol: {
                        minlength: 1,
                        required: true
                    },
                },
                messages: {
                    currency_title: {
                        required: msg1,
                    },
                    currency_code: msg2,
                    currency_value: {
                        required: msg3,
                        number: msg8,
                        min: msg9
                    },
                    decimal: msg6,
                    status: msg7,
                    symbol_type: msg4,
                    symbol: msg08,


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
                runValidateCurrencySelection();
            }
        };
    }();
    validate_multy_currency.init();
}());


function delete_currency(id)

{
    var path_root = $("#path_root").val();
    var confirm_msg = $("#error_msg6").html();
    if (confirm(confirm_msg))

    {
        document.location.href = path_root + 'admin/currency/delete/' + id;
    }
}
function edit_currency(id, default_id)

{
    var path_root = $("#path_root").val();
    var confirm_msg = $("#error_msg7").html();
//    if (confirm(confirm_msg))
//
//    {
        document.location.href = path_root + 'admin/currency/edit_currency/' + id + '/' + default_id;
//    }
}
function setdefault_currency(id)

{
    var path_root = $("#path_root").val();
    var confirm_msg = $("#error_msg8").html();
    if (confirm(confirm_msg))

    {
        document.location.href = path_root + 'admin/currency/set_default_currency/' + id;
    }
}
$(document).ready(function()
{
    
        var msg=$("#error_msg9").html();
        var msg1=$("#error_msg10").html();
    $("#currency_title").keypress(function(e)
    {
        var flag=0;
        if(e.which == 46){
            if($(this).val().indexOf('.') != -1){
                flag=1;
            }
        }


        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122))
        {
          flag=1;  
        }  
        if( flag==1){
            //display error message
            $("#errmsg1").html("<font color='red'>" + msg + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#currency_code").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122))
        {
            //display error message
            $("#errmsg2").html("<font color='red'>" + msg + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });


   // return true;


});
