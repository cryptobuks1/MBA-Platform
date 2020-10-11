$(function() {
    ValidateUserDeactivateActivate.init();
});
var ValidateUser = function() {

    // function to initiate Validation Sample 1
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#error_msg4").html();
    //var msg5 = $("#error_msg5").html();
    var msg5 = 'Please Enter a Valid Date';

    var runValidatorweeklySelection = function() {
        var searchform = $('#daily');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#daily').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                //error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                date: {
                    minlength: 1,
                    required: true,
                    date: true
                }
            },
            messages: {
                date: {
                    required: msg3,
                    date: msg5,
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

        var searchform = $('#weekly_join');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#weekly_join').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                //error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                week_date1: {
                    minlength: 1,
                    //		    required: true,
                    date: true
                },
                week_date2: {
                    minlength: 1,
                    //		    required: true,
                    //		    todate_greaterthan_fromdate: true,
                    date: true
                }
            },
            messages: {
                week_date1: {
                    //                    required : msg,
                    date: msg5
                },
                week_date2: {
                    minlength: msg2,
                    //		    required: msg1,
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
    return {
        //main function to initiate template pages
        init: function() {
            runValidatorweeklySelection();
            runValidatordailySelection();
        }
    };
}();


var ValidateUserDeactivateActivate = function() {

    // function to initiate Validation Sample 1
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#error_msg4").html();

    var runValidatorweeklySelection = function() {
        var searchform = $('#daily');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#daily').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                date: {
                    minlength: 1,
                    required: true
                }
            },
            messages: {
                date: msg3


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

        var searchform = $('#weekly_join');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#weekly_join').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                week_date1: {
                    minlength: 1,
                    required: true
                },
                week_date2: {
                    minlength: 1,
                    required: true,
                    todate_greaterthan_fromdate: true
                }
            },
            messages: {
                week_date1: msg,
                week_date2: {
                    minlength: msg2,
                    required: msg1,
                    todate_greaterthan_fromdate: msg4
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
            var FromDate = $("#week_date1").val();
            return (ToDate >= FromDate);
        }, "");
    };
    return {
        //main function to initiate template pages
        init: function() {
            runValidatorweeklySelection();
            runValidatordailySelection();
        }
    };
}();




var ValidateCommissionReport = function() {

    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#error_msg4").html();
    //var msg5 = $("#error_msg5").html();
    var msg5 = 'Please Enter a Valid Date';
    var runValidateCommissionReport = function() {
        var searchform = $('#commision_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $.validator.addMethod("ip_address", function(value, element) {
            var ipformat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
            if (value == '') {
                return true;
            } else if (value.match(ipformat))
                return true;
            else
                return false;
        }, 'Please provide a valid ip address');
        $('#commision_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                from_date: {
                    //		    required: true,
                    date: true
                },
                to_date: {
                    //		    required: true,
                    //		    todate_greaterthan_fromdate: true,
                    date: true
                },
                ip_address: {
                    ip_address: true
                },
                "amount_type[]": {
                    //		    required: true
                }
            },
            messages: {
                from_date: {
                    required: msg,
                    date: msg5,
                },
                to_date: {
                    minlength: msg2,
                    required: msg1,
                    todate_greaterthan_fromdate: msg4,
                    date: msg5
                },
                "amount_type[]": msg3
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
            var FromDate = $("#from_date").val();
            return (ToDate >= FromDate);
        }, "");
    };
    return {
        //main function to initiate template pages
        init: function() {

            runValidateCommissionReport();
        }
    };

}();
$("#ip_address").keypress(function(e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
        //display error message
        var msg6 = $("#error_msg6").html();
        $("#ip_address_err").html('<font color="red">' + msg6 + '</font>').show().fadeOut(2500, 0);
        return false;
    }
    return true;
});

function validation() {

    if ($("#from_date").val() && $("#to_date").val()) {
        var FromDate = $("#from_date").val();
        var ToDate = $("#to_date").val();
        if (ToDate <= FromDate) {
            alert("From date greater than to date!!");
            return false;
        }
    }
}