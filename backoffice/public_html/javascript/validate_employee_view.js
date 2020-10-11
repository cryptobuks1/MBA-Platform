$(function()
{
   ValidateEmployeeView.init();
});
var ValidateEmployeeView = function() {
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
    var msg22 = $("#error_msg22").html();
    var msg23 = $("#error_msg23").html();

    var runValidatorweeklySelection = function() {
        var searchform = $('#edit_form');
        $.validator.addMethod("alpha_num", function(value, element) {
            return this.optional(element) || value == value.match(/^[A-Za-z0-9]+$/);
        }, msg22);
        $.validator.addMethod("alpha_space", function(value, element) {
            return this.optional(element) || value == value.match(/^[a-zA-Z ]+$/);
        }, msg1);
        var errorHandler1 = $('.errorHandler', searchform);
        $('#edit_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                 error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                mobile: {
                    digits: true,
                    minlength: 5,
                    maxlength: 10,
                    required: true
                },
                first_name: {
                    minlength: 3,
                    maxlength: 32,
                    required: true,
		    alpha_space: true
                },
                last_name: {
                    minlength: 3,
                    maxlength: 32,
                    required: true,
		    alpha_space: true
                },
                email: {
                    minlength: 1,
                    required: true,
                    email: true

                }
              
            },
            messages: {
                first_name: {
		    required:msg1,
                    alpha_space:msg22,
                    minlength:msg23
		},
                last_name: {
		    required:msg8,
                    alpha_space:msg22,
                    minlength:msg23
		},
                mobile: {required: msg5,minlength:msg12
                },
                email: {
                    required: msg4,
                    email: msg6
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
            runValidatorweeklySelection();

        }
    };
}();
//$("#first_name").keypress(function (e)
//{
//    var err_firstname_msg = $("#error_msg22").html();
//    //if the letter is a digit then display error and don't type anything
//    if (e.which != 8 && e.which != 0 && (e.which >= 48 && e.which <= 57))
//    {
//        //display error message
//        $("#err_first_name").html(err_firstname_msg).show().fadeOut(1200, 0);
//        return false;
//    }
//});
$("#mobile").keypress(function (e)
{
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
    {
        //display error message
        var err_mobile_msg = $("#error_msg17").html();
        $("#err_mobile").html(err_mobile_msg).show().fadeOut(1200, 0);
        return false;
    }
    return true;
});
$("#first_name,#last_name").keypress(function (e) {
    var err_lastname_msg = $("#error_msg22").html();
    if (e.which == 0 || e.which == 8) {
        return;
    }
    var regex = new RegExp("^[a-zA-Z ]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    } else {
        showErrorSpanOnKeyup(this, err_lastname_msg);
        return false;
    }
});
function showErrorSpanOnKeyup(element, message) {
    var span = "<span class='keyup_error' style='color:#b94a48';>" + message + "</span>";
    $(element).next('span.keyup_error').remove();
    $(element).after(span);
    $(element).next('span:first').fadeOut(2000, 0);
}
