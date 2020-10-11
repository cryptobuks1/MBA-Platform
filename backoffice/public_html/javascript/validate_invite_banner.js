$(function () {
    var validate_invite_banner = function () {
        // function to initiate Validation Sample 1

        var runValidateInviteBanner = function () {
            var msg1 = $("#validate_msg1").html();
            var msg2 = $("#validate_msg2").html();
            var msg = $("#errmsg").html();
            var searchform = $('#product_form');
            var errorHandler1 = $('.errorHandler', searchform);
            $('#product_form').validate({
                errorElement: "span", // contain the error msg in a span tag
                errorClass: 'help-block',
                errorPlacement: function (error, element) { // render error placement for each input type
                    if ($(element).hasClass("date-picker")) {
                        error.insertAfter($(element).closest('.input-group'));
                    } else if ($(element).hasClass("ckeditor")) {
                        error.insertAfter($('#cke_mail_content'));
                    } else
                    {
                        error.insertAfter(element);
                    }
                    ;
                    //error.insertAfter(element);
                    // for other inputs, just perform default behavior
                },
                ignore: [],
                debug: false,
                rules: {
                    banner_name: {
                        minlength: 1,
                        maxlength: 32,
                        required: true
                    },
                    target_url: {
                        url: true
                    }
                },
                messages: {
                    banner_name: {
                        required: msg1
                    },
                    target_url: {
                        url: msg2
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
        };
        return {
            //main function to initiate template pages
            init: function () {
                runValidateInviteBanner();
            }
        };
    }();
    validate_invite_banner.init();
}());
$(".banner_inv").click(function () {
    var id = $(this).attr('id');
    var v = $("#" + id).val();
    var dummy = $('<input>').val(v).appendTo('body').select();

    try {
        document.execCommand("copy", false, null);
    } catch (e) {
        window.prompt("Copy to clipboard: Ctrl C, Enter", v);
    }
    dummy.remove();
    $('#banner_inv').fadeIn().delay(2000).fadeOut();
});