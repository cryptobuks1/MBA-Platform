
function deleteFaq(id)
{
    var ans = confirm('Do you want to delete this Question?');
    if (ans == true) {
        var base_url_id = $("#base_url").val();
        var current_url_full = 'admin/ticket_system/faq/';
        var action = 'delete'
        $(location).attr('href', base_url_id + current_url_full + action + '/' + id);
    }
}

var ValidateFAQ = function () {


    var Validatecategory = function () {
        var searchform = $('#faq');
        var msg1 = $("#error_msg1").html();
        var msg2 = $("#error_msg2").html();
        var msg3 = $("#error_msg3").html();
        var errorHandler1 = $('.errorHandler', searchform);
        $('#faq').validate({
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
                category: {
//                    maxlength: 40,
                    required: true
                },
                question: {
//                    maxlength: 40,
                    required: true
                },
                answer: {
//                    maxlength: 40,
                    required: true
                }


            },
            messages: {
                category: {
                    required: msg1,
                },
                question: {
                    required: msg2,
                },
                answer: {
                    required: msg3,
                },
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

            Validatecategory();

        }
    };
}();
$(function()
{
   ValidateFAQ.init();
});
