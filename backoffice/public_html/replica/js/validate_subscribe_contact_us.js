var ValidateSubscribe = function() {
    var msg11 = $("#validate_contact_msg11").html();
    var msg12 = $("#validate_contact_msg12").html();
    var msg21 = $("#validate_contact_msg21").html();
    var msg22 = $("#validate_contact_msg22").html();
    var msg31 = $("#validate_contact_msg31").html();
    var msg32 = $("#validate_contact_msg32").html();
    var msg41 = $("#validate_contact_msg41").html();
    var msg1 = $("#validate_msg1").html();
    var msg2 = $("#validate_msg2").html();
    var msg3 = $("#validate_msg3").html();
    msg1 = msg1.replace('%s', 15);
    msg2 = msg2.replace('%s', 5);
    msg3 = msg3.replace('%s', 32);

    var runValidateContact = function() {
        var searchform = $('#contact_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $.validator.addMethod("alpha_spec", function(value, element) {
            return this.optional(element) || value == value.match(/^[a-zA-Z ]+$/);
        }, msg12);
        $('#contact_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                //error.insertAfter(element);
                error.insertAfter($(element).closest('.form-control'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                name: {
                    required: true,
                    alpha_spec: true,
                    maxlength: 32
                },
                email: {
                    required: true,
                    email: true
                },
                phone: {
                    required: true,
                    number: true,
                    maxlength: 15,
                    minlength: 6
                },
                address: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: msg11,
                    alpha_spec: msg12,
                    maxlength: msg3
                },
                email: {
                    required: msg21,
                    email: msg22
                },
                phone: {
                    required: msg31,
                    number: msg32,
                    maxlength: msg1,
                    minlength: msg2,
                },
                address: {
                    required: msg41
                }


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
            runValidateContact();
        }
    };
}();
$(function() {
    ValidateSubscribe.init();
});