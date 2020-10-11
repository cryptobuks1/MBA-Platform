$(function() {
    ValidateUser.init();
});
var ValidateUser = function() {

    // function to initiate Validation Sample 1
    var msg = $("#error_msg").html();
    var msg4 = $("#errmsg4").html();

    var runValidatordailySelection = function() {

        var searchform = $('#epin_report');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#epin_report').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                week_date1: {
                    date: true
                },
                week_date2: {
                    todate_greaterthan_fromdate: true,
                    date: true
                }
            },
            messages: {
                week_date2: {
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

            if ($('#week_date1').val() && $('#week_date2').val()) {
                return (ToDate >= FromDate);

            } else
                return true;
        }, "");
    };
    return {
        //main function to initiate template pages
        init: function() {
            runValidatordailySelection();
        }
    };
}();