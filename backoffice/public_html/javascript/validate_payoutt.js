var ValidateUser = function() {
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg4 = $("#error_msg4").html();
    //var msg5 = $("#error_msg5").html();
    var msg5 = 'Please Enter a Valid Date';

    var runValidateDailyReleaseReport = function() {
        var searchform = $('#searchform');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#searchform').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                if (element.parent('.input-group').length) {
                    error.insertAfter($(element).closest('.input-group'));
                } else {
                    error.insertAfter(element);
                }
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                week_date1: {
                    minlength: 1,
                    required: true,
                    date: true
                }
            },
            messages: {
                week_date1: {
                    required: msg1,
                    date: msg5
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

    var runValidateReleasePayoutweekly = function() {
        var searchform = $('#searchform2');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#searchform2').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type
                if (element.parent('.input-group').length) {
                    error.insertAfter($(element).closest('.input-group'));
                } else {
                    error.insertAfter(element);
                }
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                from_date_weekly: {
                    minlength: 1,
                    //                    required: true,
                    date: true
                },
                to_date_weekly: {
                    minlength: 1,
                    //                    required: true,
                    //                    to_date_weekly_greaterthan_from_date_weekly: true,
                    date: true
                }
            },
            messages: {
                from_date_weekly: {
                    //                    required : msg,
                    date: msg5
                },
                to_date_weekly: {
                    minlength: msg2,
                    //                    required: msg1,
                    to_date_weekly_greaterthan_from_date_weekly: msg4,
                    date: msg5
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
        jQuery.validator.addMethod('to_date_weekly_greaterthan_from_date_weekly', function(ToDate) {

            if ($("#from_date_weekly").val() && $("#to_date_weekly").val()) {
                var FromDate = $("#from_date_weekly").val();
                return (ToDate >= FromDate);
            }
        }, "");
    };

    var runValidatePendingPayoutweekly = function() {
        var searchform = $('#searchform1');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#searchform1').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type
                //error.insertAfter(element);
                if (element.parent('.input-group').length) {
                    error.insertAfter($(element).closest('.input-group'));
                } else {
                    error.insertAfter(element);
                }
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                from_date_pending: {
                    minlength: 1,
                    //                    required: true,
                    date: true
                },
                to_date_pending: {
                    minlength: 1,
                    //                    required: true,
                    //                    to_date_pending_greaterthan_from_date_pending: true,
                    date: true
                }
            },
            messages: {
                from_date_pending: {
                    //                    required :msg,
                    date: msg5
                },
                to_date_pending: {
                    minlength: msg2,
                    //                    required: msg1,
                    to_date_pending_greaterthan_from_date_pending: msg4,
                    date: msg5
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
        jQuery.validator.addMethod('to_date_pending_greaterthan_from_date_pending', function(ToDate) {
            if ($("#from_date_pending").val() && $("#to_date_pending").val()) {
                var FromDate = $("#from_date_pending").val();
                return (ToDate >= FromDate);
            }
        }, "");
    };


    var runValidatorweeklySelection = function() {

        var searchform = $('#weekly_payout');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#weekly_payout').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                if (element.parent('.input-group').length) {
                    error.insertAfter($(element).closest('.input-group'));
                } else {
                    error.insertAfter(element);
                }
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                week_date1: {
                    minlength: 1,
                    //                    required: true,
                    date: true
                },
                week_date2: {
                    minlength: 1,
                    //                    required: true,
                    //                    todate_greaterthan_fromdate: true,
                    date: true
                }
            },
            messages: {
                week_date1: {
                    //                    required:msg,
                    date: msg5,
                },
                week_date2: {
                    minlength: msg2,
                    //                    required: msg1,
                    todate_greaterthan_fromdate: msg4,
                    date: msg5
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
        jQuery.validator.addMethod('todate_greaterthan_fromdate', function(ToDate) {

            if ($("#week_date1").val() && $("#week_date2").val()) {
                var FromDate = $("#week_date1").val();
                return (ToDate >= FromDate);
            }
        }, "");
    };
    var runValidatordailySelection = function() {

        var searchform = $('#user');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#user').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                if (element.parent('.input-group').length) {
                    error.insertAfter($(element).closest('.input-group'));
                } else {
                    error.insertAfter(element);
                }
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
                user_name: msg2


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
            runValidateDailyReleaseReport();
            runValidateReleasePayoutweekly();
            runValidatePendingPayoutweekly();
            runValidatorweeklySelection();
            runValidatordailySelection();
        }
    };
}();