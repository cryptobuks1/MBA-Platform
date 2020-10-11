$(function()
{
   ValidateAddCrm.init();
   ValidateAddFollowup.init();
   ValidateEditFollowupDate.init();
});
var ValidateAddCrm = function() {
    var msg = $("#error_msg").html();
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
    var msg11 = $("#error_msg13").html();

    var runValidatorweeklySelection = function() {
        var searchform = $('#lead_register');
        var errorHandler1 = $('.errorHandler', searchform);
        
        var newdate = getFormattedDate();
        function getFormattedDate() {
            var date = new Date();
            var str = date.getFullYear() + "-" + getFormattedPartTime(date.getMonth() + 1) + "-" + getFormattedPartTime(date.getDate());
            return str;
        }
        function getFormattedPartTime(partTime) {
        if (partTime < 10)
            return "0" + partTime;
        return partTime;
        }
        jQuery.validator.addMethod('greater_than_today', function(ToDate) {
            if (ToDate < newdate) {
                return false;
            } else{
                return true;
            }
        }, "");
        
        $('#lead_register').validate({
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
                    minlength: 3,
                    maxlength: 32
                },
                last_name: {
                    minlength: 3,
                    maxlength: 32
                },
                email_id: {
                    email: true

                },
                mobile_no: {
                    digits: true,
                    minlength: 5,
                    maxlength: 10
                },
                description: {
                    required: true,
                    maxlength:200
                },
                followup_date: {
                    required: true,
                    greater_than_today: true
                }
              
            },
            messages: {
                first_name: {
		    required:msg1,
                    minlength:msg4,
                    maxlength:msg5
		},
                last_name: {
                    minlength: msg4,
                    maxlength: msg5  
                },
                email_id: {
                    email: msg6
                },
                mobile_no: {
                    digits: msg7,
                    minlength: msg8,
                    maxlength: msg9
                },
                description: {
		    required:msg2,
                    maxlength:msg10
		},
                followup_date:{
                    required:msg11,
                    greater_than_today: msg3
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

var ValidateAddFollowup = function() {
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#error_msg4").html();
    var msg5 = $("#error_msg5").html();
    var msg10 = $("#error_msg10").html();
    var msg11 = $("#error_msg11").html();
    var msg12 = $("#error_msg12").html();

    var runValidatorweeklySelection = function() {
        var searchform = $('#followup_form');
        var errorHandler1 = $('.errorHandler', searchform);
        
        var newdate = getFormattedDate();
        function getFormattedDate() {
            var date = new Date();
            var str = date.getFullYear() + "-" + getFormattedPartTime(date.getMonth() + 1) + "-" + getFormattedPartTime(date.getDate());
            return str;
        }
        function getFormattedPartTime(partTime) {
        if (partTime < 10)
            return "0" + partTime;
        return partTime;
        }
        jQuery.validator.addMethod('greater_than_today', function(ToDate) {
            if (ToDate < newdate) {
                return false;
            } else{
                return true;
            }
        }, "");
        
        $('#followup_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                 error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                lead_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 32
                },
                description: {
                    required: true,
                    maxlength: 200
                },
                followup_date: {
                    required: true,
                    greater_than_today: true

                }
              
            },
            messages: {
                lead_name: {
		    required:msg11,
                    minlength:msg4,
                    maxlength:msg5
		},
                description: {
		    required:msg2,
                    maxlength:msg10
		},
                followup_date: {
                    required: msg12,
                    greater_than_today: msg3
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
var ValidateEditFollowupDate = function() {
    var msg3 = $("#error_msg3").html();
    var msg12 = $("#error_msg12").html();

    var runValidatorweeklySelection = function() {
        var searchform = $('#followup_date_form');
        var errorHandler1 = $('.errorHandler', searchform);
        
        var newdate = getFormattedDate();
        function getFormattedDate() {
            var date = new Date();
            var str = date.getFullYear() + "-" + getFormattedPartTime(date.getMonth() + 1) + "-" + getFormattedPartTime(date.getDate());
            return str;
        }
        function getFormattedPartTime(partTime) {
        if (partTime < 10)
            return "0" + partTime;
        return partTime;
        }
        jQuery.validator.addMethod('greater_than_today', function(ToDate) {
            if (ToDate < newdate) {
                return false;
            } else{
                return true;
            }
        }, "");
        
        $('#followup_date_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                 error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                followup_date: {
                    required: true,
                    greater_than_today: true
                }
              
            },
            messages: {
                followup_date: {
                    required: msg12,
                    greater_than_today: msg3
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