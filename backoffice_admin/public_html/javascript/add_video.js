/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var searchform = $('#faq');
var msg2 = $("#error_msg2").html();
var msg3 = $("#error_msg3").html();
var msg4 = $("#error_msg4").html();
var msg5 = $("#error_msg5").html();
var msg6 = $("#error_msg6").html();
var msg7 = $("#error_msg8").html();
var msg8 = $("#error_msg9").html();
var errorHandler1 = $('.errorHandler', searchform);
$('#video').validate({
    errorElement: "span", // contain the error msg in a span tag
    errorClass: 'help-block',
    errorPlacement: function (error, element) { // render error placement for each input type
        if ($(element).hasClass("date-picker")) {
            error.insertAfter($(element).closest('.input-group'));
        } else {
            error.insertAfter(element);
        }
    },
    ignore: ':hidden',
    rules: {
        video_description: {
                required: true
        },
        video_title: {
                required: true
        },
        sort_order: {
                required: true,
                maxlength:5,
                greaterThanNum: 0
        }


    },
    messages: {
        video_description: {
            required: msg2,
            
        },
        video_title: {
            required: msg3,
        
        },
        sort_order: {
            required: msg6,
            maxlength:msg7,
            greaterThanNum: msg8
        }
    },
    invalidHandler: function (event, validator) { //display error alert on form submit
        errorHandler1.show();
    },
    highlight: function (element) {
        $('#checkmsg').hide();
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
function deleteFaq(element) {
    $(element).closest('.panel-heading').next('form').submit();
}
    $("#sort_order").keypress(function(e) {
        if (e.which == 0 || e.which == 8) {
            return;
        }
        var regex = new RegExp("^[0-9]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        } else {
            var msg = $("#error_msg7").html();
            showErrorSpanOnKeyup(this, msg);
            return false;
        }
    });
    
    function showErrorSpanOnKeyup(element, message) {
        var span = "<span id='err_keyup_" + element.name + "'  class='keyup_error' style='color:#b94a48;'>" + message + "</span>";
        $(element).next('span.keyup_error').remove();
        $(element).after(span);
        $(element).next('span:first').fadeOut(2000, 0);
    }
    
   function trim(a) {
        return a.replace(/^\s+|\s+$/, '');
    } 
    function enable_next2() {
        $('#submit').attr('disabled', false);
    }

    function disable_next2() {
        $('#submit').attr('disabled', true);
    }


    $(document).ready(function () {

        var path_temp = $('#path_temp').val();
        var path_root = $('#path_root').val();
        $("#sort_order").on('change', function () {
            disable_next2();
            if (!$(this).valid()) {
                $('#checkmsg').hide();
                return false;
            }
            var error = 0;
            if ($("#sort_order").val() == '' || $("#sort_order").val() == 0) {
                error = 1;
                $("#checkmsg").fadeTo(1000, 0, function () //start fading the messagebox
                {
                    var msg;
                    msg = $("#validate_msg72").html();
//                    //add message and change the class of the box and start fading
                    $(this).removeClass();
                    $(this).addClass('messageboxerror');
                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(1000, 1);
                    $(this).closest('.form-group').removeClass('has-error').addClass('ok');
                    disable_next2();
                });
                 $('#checkmsg').hide();
            }
            if (error != 1) {
                var date_availability = path_root + "admin/member/ajax_is_sortorder_available";
                var msg = $("#validate_msg27").html();
                //remove all the class add the messagebox classes and start fading
                $("#checkmsg").removeClass();
                $("#checkmsg").addClass('messagebox');
                $("#checkmsg").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" /> ' + msg).show().fadeTo(1000, 1);

                $.post(date_availability, { sort_order: $('#sort_order').val(),video_type: $('#video_type').val(),module_id: $('#package_type').val()}, function (data) {
                    if (trim(data) == 'no') //if date not avaiable
                    {
                        $("#checkmsg").fadeTo(1000, 0.1, function () //start fading the messagebox
                        {
                            var msg;
                            msg = $("#validate_msg28").html();
                            //add message and change the class of the box and start fading

                            $(this).removeClass();
                            $(this).addClass('messageboxerror');
                            $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(1000, 1);
                            disable_next2();
                        });
                    }
                    else {
                        $("#checkmsg").fadeTo(1000, 0.1, function ()  //start fading the messagebox
                        {
                            var msg = $("#validate_msg5").html();
                            $(this).removeClass();
                            $(this).addClass('messageboxok');
                            $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg).show().fadeTo(1000, 1);  
                        enable_next2();
                            $(this).closest('.form-group').removeClass('has-error').addClass('ok');
                        });
                    }
                });
            }
        });

    });    

//$(function () {
//    ValidateFAQ.init();
//}());
//var ValidateFAQ = function () {
//    var Validatecategory = function () {
//
//    };
//
//    return {
//        //main function to initiate template pages
//        init: function () {
//
//            Validatecategory();
//
//        }
//    };
//}();
