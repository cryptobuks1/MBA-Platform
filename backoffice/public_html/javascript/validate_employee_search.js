var ValidateMember = function() {

    // function to initiate Validation Sample 1
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg5").html();
    var msg3 = $("#error_msg6").html();
    var msg4 = $('#error_msg7').html();
    var runValidateSearchEmployee = function() {
        var searchform = $('#search_mem');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#search_mem').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                //error.insertAfter(element);
                error.insertAfter(element);

                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                keyword: {
                    minlength: 1,
                    required: true
                }
            },
            messages: {
                keyword: msg,
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
    var runValidateEditEmployee = function() {
        //alert("fff");
        var searchform = $('#edit_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#edit_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                // for other inputs, just perform default behavior

            },
            ignore: ':hidden',
            rules: {
                mobile: {
                    required: true,
                    minlength: 5,
                    maxlength: 10,
                    number: true
                },
                full_name: {
                    minlength: 1,
                    required: true
                },
                email: {
                    minlength: 1,
                    required: true,
                    email: true

                }
            },
            messages: {
                mobile: msg2,
                full_name: msg1,
                email: {
                    required: msg3,
                    email: msg4
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
            runValidateSearchEmployee();
            runValidateEditEmployee();
        }
    };
}();