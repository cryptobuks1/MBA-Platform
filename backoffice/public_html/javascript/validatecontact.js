var ValidateUser = function() {
    // function to initiate Validation Sample 1
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#error_msg4").html();
    var msg5 = $("#error_msg5").html();
    var msg6 = $("#error_msg6").html();
    var msg7 = $("#error_msg7").html();
    var msg8 = $("#error_msg8").html();
    var msg9 = $("#error_msg9").html();
    var msg10 = $("#error_msg10").html();

    var runValidatorweeklySelection = function() {
        var searchform = $('#lcp_form');
        var errorHandler1 = $('.errorHandler', searchform);

        $.validator.addMethod("alpha_space", function(value, element) {
            return this.optional(element) || value == value.match(/^[a-zA-Z ]+$/);
        }, msg7);

        $('#lcp_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                first_name: {
                    required: true,
                    alpha_space: true,
                    minlength: 3,
                    maxlength: 32
                },
                last_name: {
                    required: true,
                    alpha_space: true,
                    minlength: 3,
                    maxlength: 32
                },
                email: {
                    minlength: 1,
                    required: true,
                    email: true
                },
                phone: {
                    required: true,
                    number: true
                },
                skype_id: {
                    minlength: 3,
                    maxlength: 32
                },
                comment:{
                     maxlength: 200
                }

            },
            messages: {
                first_name: {
                    required: msg1,
                    alpha_space: msg9,
                    minlength: msg7,
                    maxlength: msg8
                },
                last_name: {
                    required: msg5,
                    alpha_space: msg9,
                    minlength: msg7,
                    maxlength: msg8
                },
                email: {
                    required: msg2,
                    email: msg4
                },
                phone: {
                    required: msg6,
                    number: msg3
                },
                skype_id: {
                    minlength: msg7,
                    maxlength: msg8
                },
                comment:{
                     maxlength: msg10
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
$(function() {
    ValidateUser.init();
    $("#close_link").click(function() {
        $("#message_box").fadeOut(1000);
        $("#message_box").removeClass('ok');
    });
});

    function changeLCPDefaultLanguage(language_id) {
            var base_url = $("#base_url_id").val();
            $.ajax({
           
                type: 'GET',
                url: base_url + "lcp/change_lcp_default_lang/" + language_id + "/ajax",
             //  url: base_url + "lcp/change_lcp_default_lang",
             //  data:  JSON.stringify({language: language_id,inf_token: $('input[name="inf_token"]').val()}),
//                data: { 
//                    language: language_id,
//                    inf_token: $('input[name="inf_token"]').val()
//                },
               
                contentType: 'application/json',
                 dataType: 'JSON',
                
                success: function(data) {
                },
                complete: function() {
                  setTimeout(function () {
                            location.reload();
                            }, 500);
                }
            });
    }