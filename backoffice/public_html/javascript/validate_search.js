$(function()
{
   ValidateSearch.init();
   ValidateShowTicket.init();
});
var ValidateSearch = function () {

    var runValidatorTicketStatus = function () {
        var msg1 = $("#error_msg1").html();
        var searchform = $('#search_ticket_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#search_ticket_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                if ($(element).hasClass("date-picker")) {
                    error.insertAfter($(element).closest('.input-group'));
                } else
                {
                    error.insertAfter(element);
                }
                ;
                //error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                search_text: {
                    minlength: 1,
                    required: true
                }


            },
            messages: {
                search_text: msg1


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
            runValidatorTicketStatus();


        }
    };
}();

var ValidateShowTicket = function () {
    var runValidatorShowTicket = function () {
        var msg1 = $("#error_msg2").html();
        var searchform = $('#show_ticket');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#show_ticket').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                if ($(element).hasClass("date-picker")) {
                    error.insertAfter($(element).closest('.input-group'));
                } else
                {
                    error.insertAfter(element);
                }
                ;
                //error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                category_name: {
                    oneoftworequired: true
                }

            },
            messages: {
                category_name: {
                    oneoftworequired: msg1
                }

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
        jQuery.validator.addMethod('oneoftworequired', function (category) {
            var tag_name = $("#tag_name").val();
            if (tag_name || category) {
                return true;
            } else
            {
                return false;
            }

        });
    };



    return {
        //main function to initiate template pages
        init: function () {
            runValidatorShowTicket();


        }
    };
}();
