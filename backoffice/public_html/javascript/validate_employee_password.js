var ValidateUser = function() {

    // function to initiate Validation Sample 1
    var msg = $("#error_msg1").html();
    var msg1 = $("#error_msg2").html();
    var msg2 = $("#error_msg3").html();
    var msg3 = $("#error_msg4").html();
    var msg4 = $("#error_msg5").html();
    var msg5 = $("#error_msg6").html();
    var msg6 = $("#error_msg7").html();
    var msg7 = $("#error_msg8").html();
    var runValidateChangePasswordUser = function() {
        var searchform = $('#change_pass');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#change_pass').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                //error.insertAfter(element);
                error.insertAfter(element);

                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                user_name: {
                    minlength: 1,
                    required: true
                },
                new_pwd: {
                    minlength: 6,
                    required: true
                },
                confirm_pwd: {
                    minlength: 6,
                    required: true,
                    equalTo:"#new_pwd"
                }
            },
            messages: {
                user_name: msg7,
                new_pwd: {
                    required: msg4,
                    minlength: msg1
                },
                confirm_pwd: {
                    required: msg5,
                    minlength: msg1,
                    equalTo: msg2
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
        });
    };

    return {
        //main function to initiate template pages
        init: function() {
            runValidateChangePasswordUser();
        }
    };
}();

