$(function()
{
    ValidateUser.init();
});

var ValidateUser = function () {
    var runValidateMemberSelection = function () {
        var msg = $("#error_msg1").html();
        var searchform = $('#search_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#search_form').validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
            },
            ignore: ':hidden',
            rules: {
                user_name: {
                    minlength: 1,
                    required: true
                }
            },
            messages: {
                user_name: msg
            },
            invalidHandler: function (event, validator) {
                errorHandler1.show();
            },
            highlight: function (element) {
                
                $(element).closest('.help-block').removeClass('valid');
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            success: function (label, element) {
                
                label.addClass('help-block valid');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            }
        });
    };
    return {
        init: function () {
            runValidateMemberSelection();
        }
    };
}();