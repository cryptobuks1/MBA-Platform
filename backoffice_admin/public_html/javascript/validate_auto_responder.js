var validate_auto_responder = function () {

    // function to initiate Validation Sample 1

    var runValidateMemberSelection = function () {
        var msg1 = $("#validate_msg1").html();
        var msg2 = $("#validate_msg2").html();
        var msg3 = $("#validate_msg3").html();
        var msg4 = $("#validate_msg4").html();
        var msg = $("#errmsg").html();
        var searchform = $('#mail_auto_settings');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#mail_auto_settings').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                if ($(element).hasClass("date-picker")) {
                    error.insertAfter($(element).closest('.input-group'));
                } else if ($(element).hasClass("textarea")) {
                    error.insertAfter($('#err_mail_content'));
                } else {
                    error.insertAfter(element);
                }
            },
            ignore: ':hidden:not(.textarea)',
            rules: {
                subject: {
                    minlength: 1,
                    required: true

                },
                mail_content: {
                    minlength: 1,
                    required: true

                },
                date_to_send: {
                    minlength: 1,
                    required: true,
                }
            },
            messages: {
                subject:msg1,
                mail_content: msg2,
                date_to_send: msg4       
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
$(function(){
    validate_auto_responder.init();
    $(".textarea").wysihtml5();
});