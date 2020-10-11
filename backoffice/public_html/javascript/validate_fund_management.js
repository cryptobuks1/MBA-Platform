var ValidateUser = function() {

    // function to initiate Validation Sample 1
    var msg = $("#error_msg1").html();
    var msg1 = $("#error_msg2").html();
    var msg2 = $("#validate_msg1").html();
    var msg9 = $("#error_name").html();
    var msg4 = $("#validate_msg15").html();
    var msg5 = $("#validate_msg16").html();
    var msg6 = $("#validate_msg17").html();
    var runValidatorweeklySelection = function() {
        var searchform = $('#fund_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $.validator.addMethod("username_check", function(value, element) {
            var path_root = $('#base_url').val();
            if (value != "/" && value != ".") {
                $.ajax({
                    'url': path_root + getUserType() + "/ewallet/validate_username",
                    'type': "POST",
                    'data': { username: value },
                    'dataType': 'text',
                    'async': false,
                    'success': function(data) {
                        if (data == 'no') {
                            flag2 = false;
                        } else if (data == 'yes') {
                            flag2 = true;
                        }
                    },
                    'error': function(error) {},
                });
                return flag2;
            } else {
                return true;
            }
        }, msg9);
        $('#fund_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorId: 'fund_form',
            errorPlacement: function(error, element) { // render error placement for each input type
                if ($(element).parent('.input-group').length === 0) {
                    error.insertAfter(element);
                } else {
                    error.insertAfter($(element).closest('.input-group'));
                }
            },
            ignore: ':hidden',
            rules: {
                user_name: {
                    minlength: 1,
                    required: true,
                    username_check: true
                },
                amount: {
                    min: 0,
                    required: true,
                    number: true
                },
                tran_concept: {
                    required: true
                }
            },
            messages: {
                user_name: {
                    required: msg,
                    username_check: msg9
                },
                amount: {
                    min: msg2,
                    required: msg1,
                    number: msg2
                },
                tran_concept: {
                    required: msg6
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
            runValidatorweeklySelection();

        }
    };


}();
window.clicked_button = null;
$('#add_amount, #deduct_amount').click(function() {
    window.clicked_button = {
        name: $(this).attr('name'),
        value: $(this).val()
    }
});

$('#fund_form').submit(function(e) {
    $('#add_amount').attr('disabled', true);
    $('#deduct_amount').attr('disabled', true);
    if ($("#fund_form").valid()) {
        $('#fund_form').append(`<input type="hidden" name="${window.clicked_button.name}" value="${window.clicked_button.value}"/>`);
        $('#add_amount').button('loading');
        $('#deduct_amount').button('loading');  
    } else {
        $('#add_amount').attr('disabled', false);
        $('#deduct_amount').attr('disabled', false);
    }
});