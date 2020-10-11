$(function()
{
    ValidateDate.init();
    ValidateContentManagement.init(); 
});
var ValidateContentManagement = function () {

    // function to initiate Validation Sample 1
    var msg1 = $("#error_main_matter1").html();
    var msg2 = $("#error_language").html();
    var msg3 = $("#error_terms_and_condition").html();

    var runValidateContentManagementWelcomeLetter = function () {
        var searchform = $('#letter_config');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#letter_config').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            ignore: [],
            rules: {
                txtDefaultHtmlArea: {
                    required: function ()
                    {
                        CKEDITOR.instances.txtDefaultHtmlArea.updateElement();
                    }
                },
                lang_selector: {
                    required: true
                }
            },
            messages: {
                txtDefaultHtmlArea: {
                    required: msg1
                },
                lang_selector: {
                    required: msg2
                }
            },
            invalidHandler: function (event, validator) {
                errorHandler1.show();
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                //$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            }
        });
    };

    var runValidateContentManagementTermsAndConditions = function () {
        var searchform = $('#terms_config');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#terms_config').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            ignore: [],
            rules: {
                txtDefaultHtmlArea1: {
                    required: function ()
                    {
                        CKEDITOR.instances.txtDefaultHtmlArea1.updateElement();
                    }
                },
                lang_selector: {
                    required: true
                }
            },
            messages: {
                txtDefaultHtmlArea1: {
                    required: msg3
                },
                lang_selector: {
                    required: msg2
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                errorHandler1.show();
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                //$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            }
        });
    };

    return {
        //main function to initiate template pages
        init: function () {
            runValidateContentManagementWelcomeLetter();
            runValidateContentManagementTermsAndConditions();

        }
    };
}();



var ValidateDate = function () {


    // function to initiate Validation Sample 1
    var runValidatorweeklySelection = function () {
        var msg = $("#msg").html();
        var msg2 = $("#errmsg2").html();
        var msg3 = $("#errmsg3").html();
        
        var searchform = $('#date_submit');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#date_submit').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            ignore: ':hidden',
            rules: {
                start_date: {
                    minlength: 1,
                    required: true
                },
                end_date: {
                    minlength: 1,
                    required: true,
                    todate_greaterthan_fromdate: true
                }

            },
            messages: {
                start_date: msg2,
                end_date: {
                    required: msg3,
                    minlength: msg3,
                    todate_greaterthan_fromdate: msg
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                errorHandler1.show();
            },
            highlight: function (element) {

                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function (label, element) {

                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                //$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            }
        });
        jQuery.validator.addMethod('todate_greaterthan_fromdate', function (ToDate) {
            var FromDate = $("#start_date").val();
            if ($('#start_date').val() && $('#end_date').val()) {
                return (ToDate > FromDate);
            }
        });
    };
    return {
        //main function to initiate template pages
        init: function () {
            runValidatorweeklySelection();

        }
    };
}();
function set_language_id(new_lang_id, type) {
    document.getElementById('lang_id').value = new_lang_id;
    var base_url = document.getElementById('base_url').value;
    if (type == 'terms')
        document.location.href = base_url + "admin/configuration/content_management/" + new_lang_id + "/tabs-2";
    else if (type == 'letter')
        document.location.href = base_url + "admin/configuration/content_management/" + new_lang_id + "/tabs-1";

}
function checkAll() {
    $(".release").prop('checked', true);
    document.getElementById("uncheck_all").style.display = '-webkit-inline-box';
    document.getElementById("check_all").style.display = 'none';
}
function uncheckAll() {
    $(".release").prop('checked', false);
    document.getElementById("check_all").style.display = '-webkit-inline-box';
    document.getElementById("uncheck_all").style.display = 'none';
}