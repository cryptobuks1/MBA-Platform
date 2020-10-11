$(function() {
    ValidateEpinRequest.init();
});

function validate_date() {
    var date1 = upload.date.value;
    alert(date1);
}


//=========validate checkbox===================//

var ValidateEpinRequest = function() {


    // function to initiate Validation Sample 1
    var msg1 = $("#error_msg6").html();
    var msg2 = $("#err_msg1").html();
    var msg3 = $("#err_msg2").html();
    ///////----for 'CHANGE USER PASSWORD' Tab - Begin/////////
    var runValidatorUserSelection = function() {

        /*jQuery.validator.addMethod("alpha_dash", function(value, element) {
         return this.optional(element) || /^[a-z0-9A-Z]*$/i.test(value);
         }, msg6);*/
        $.validator.addMethod('active', function(value) {
            return $('.active:checked').size() > 0;
        }, '<font color= "red">' + msg1 + '</font>');
        $.validator.addMethod('count', function(value) {
            return value > 0;
        }, '<font color= "red">' + msg2 + '</font>');
        var searchform = $('#view_request_form');
        var checkboxes = $('.active');
        var checkbox_names = $.map(checkboxes, function(e, i) {
            return $(e).attr("name")
        }).join(" ");
        var errorHandler1 = $('.errorHandler', searchform);
        $('#view_request_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                if ($(element).next().is('i')) {
                    error.insertAfter($(element).next());
                } else {
                    error.insertAfter(element);
                    error.insertAfter($(element).closest('.input-group'));
                }
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            groups: {
                checks: checkbox_names
            },
            rules: {
                active: {
                    required: true
                },
                count: {
                    digits: true,
                    count: true
                }
            },
            messages: {
                active: { required: msg1 },
                count: { digits: msg2 }

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
        $('.count').each(function() {
            $(this).rules('add', {
                required: true,
                messages: {
                    required: msg3
                }
            });
        });
    };

    return {
        //main function to initiate template pages
        init: function() {
            runValidatorUserSelection();

        }
    };
}();


var ValidateUser = function() {


    // function to initiate Validation Sample 1
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#error_msg4").html();
    var msg5 = $("#error_msg4").html();
    var msg6 = $("#error_msg6").html();
    var msg7 = $("#error_msg7").html();
    var msg8 = $("#err_msg_count").html();
    var msg9 = $("#err_msg_amount").html();
    var msg10 = $("#error_msg11").html();

    var runValidatorweeklySelection = function() {
        var searchform = $('#generate_epin');
        var errorHandler1 = $('.errorHandler', searchform);
        $.validator.addMethod("dateCheck", function(ExpireDate1) {
            var ExpireDate = new Date(ExpireDate1);
            var CurrentDate = new Date();
            CurrentDate.setHours(0, 0, 0, 0);
            ExpireDate.setHours(0, 0, 0, 0);
            return (ExpireDate >= CurrentDate);

        });


        $("#generate_epin").validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type
                if ($(element).hasClass("date-picker")) {
                    error.insertAfter($(element).closest('.Zebra_DatePicker_Icon_Wrapper'));
                } else {
                    error.insertAfter(element);
                };
                //error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            submitHandler: function(form) {
                SubmittingForm();
            },
            rules: {
                amount1: {
                    minlength: 1,
                    required: true
                },
                count: {
                    minlength: 1,
                    required: true,
                    digits: true,
                    maxlength: 2
                },
                date: {
                    minlength: 1,
                    required: true,
                    dateCheck: true
                }

            },
            messages: {
                amount1: {
                    required: msg
                },
                count: {
                    required: msg8,
                    digits: msg1,
                    maxlength: msg10
                },
                date: {
                    required: msg6,
                    dateCheck: msg7
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
    var runValidatordailySelection = function() {
        var searchform = $('#search_epin');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#search_epin').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                amount: {
                    minlength: 1,
                    required: true
                },
                keyword: {
                    minlength: 1,
                    required: true
                }

            },
            messages: {
                amount: msg5,
                keyword: msg5
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

    var runValidatorweeklySelectionm = function() {

        var searchform = $('#search_pin_amount');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#search_pin_amount').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                amount: {
                    minlength: 1,
                    required: true
                }

            },
            messages: {
                amount: {
                    required: msg9
                },
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
    var runValidatorViewPinUser = function() {
        var searchform = $('#view_pin_user');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#view_pin_user').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                user_name: {
                    minlength: 1,
                    required: true
                }

            },
            messages: {
                user_name: msg2,
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
            runValidatordailySelection();
            runValidatorweeklySelectionm();
            runValidatorViewPinUser();


        }
    };
}();

function copyEpinToClipboard(element) {
    var selection = window.getSelection(), //Get the window selection
        selectData = document.createRange(); //Create a range

    selection.removeAllRanges(); //Clear any currently selected text.
    selectData.selectNodeContents(element); //Add the desired element to the range you want to select.
    selection.addRange(selectData); //Highlight the element (this is the same as dragging your cursor over an element)
    var copyResult = document.execCommand("copy"); //Execute the copy.

    if (copyResult) //was the copy successful?
        selection.removeAllRanges(); //Clear the highlight.
    else
        alert("Your browser does not support clipboard commands, press ctrl+c");
}