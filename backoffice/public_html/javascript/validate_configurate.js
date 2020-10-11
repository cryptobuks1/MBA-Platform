/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function ValidateleadUrl() {


    var lead_url = document.site_config.lead_url.value;


    var matches = '%^((https?://)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i';

    if (lead_url.match(matches))
    {
        alert("matchayiii");

    } else {
        alert("ply");
    }
}
var ValidateUser = function () {

    var msg1 = $("#validate_msg1").html();
    var msg2 = $("#validate_msg2").html();
    var msg3 = $("#validate_msg6").html();
    var msg4 = $("#validate_msg4").html();
    var msg5 = $("#validate_msg5").html();
    var msg6 = $("#validate_msg8").html();
    var msg7 = $("#validate_msg9").html();
    var msg9 = $("#validate_msg10").html();
    var msg8 = $("#validate_msg11").html();
    var msg10 = $("#validate_msg12").html();
    var msg11 = $("#validate_msg13").html();
    var msg12 = $("#validate_msg14").html();
    var msg13 = $("#validate_msg20").html();
    var msg14 = $("#validate_msg16").html();
    var msg15 = $("#validate_msg17").html();
    var msg16 = $("#validate_msg18").html();
    var msg17 = $("#validate_msg19").html();
    var msg18 = $("#validate_msg21").html();
    var msg19 = $("#validate_msg22").html();
    var msg20 = $("#validate_msg7").html();
    var msg21 = $("#validate_msg23").html();
    var msg22 = $("#validate_msg24").html();
    var msg23 = $("#validate_msg25").html();
    var msg24 = $("#validate_msg26").html();
    var msg25 = $("#validate_msg27").html();
    var msg26 = $("#validate_msg28").html();
    var msg27 = $("#validate_msg29").html();
    var msg28 = $("#validate_msg30").html();
    var msg29 = $("#validate_msg31").html();

    var runValidateLetterConfig = function () {

        var searchform = $('#site_config');
        var errorHandler1 = $('.errorHandler', searchform);
        //  var successHandler1 = $('.successHandler', form_setting);

        $('#site_config').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            ignore: ':hidden',
            rules: {
                co_name: {
                    minlength: 1,
                    required: true
                },
                company_address: {
                    minlength: 1,
                    maxlength: 100,
                    required: true


                },
//                favicon: {
//                    minlength: 1,
//                    required: true
//                },
//                img_logo: {
//                    minlength: 1,
//                    required: true
//                },
                email: {
                    minlength: 1,
                    required: true,
                    email: true
                },
                phone: {
                    minlength: 5,
                    maxlength: 10,
                    digits: true,
                    required: true
                },
                lead_url: {
                    minlength: 3,
                    required: true
                }
            },
            messages: {
                co_name: msg1,
                company_address: {
                    required: msg6,
                    minlength: msg6,
                    maxlength: msg19
                },
//               favicon: msg2,
//                img_logo: msg4,
                email:
                        {
                            required: msg5,
                            email: msg7
                        },
                lead_url:
                        {
                            required: msg5,
                            lead_url: msg8
                        },
                phone: {
                    required: msg20,
                    digits: msg3,
                    minlength: jQuery.format(msg21),
                    maxlength: jQuery.format(msg18),
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
    var runValidateLinkConfig = function () {
        $.validator.addMethod("facebook_check", function (value, element) {
            return  this.optional(element) || /^http(s)?:\/\/(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/.test(value);
        }, msg14);
        $.validator.addMethod("insta_check", function (value, element) {
            return  this.optional(element) || /http(s)?:\/\/(www\.)?instagram\.com\/([A-Za-z0-9_](?:(?:[A-Za-z0-9_]|(?:\.(?!\.))){0,28}(?:[A-Za-z0-9_]))?)/.test(value);
        }, msg16);
        $.validator.addMethod("twitter_check", function (value, element) {
            return  this.optional(element) || /http(s)?:\/\/(?:www\.)?twitter\.com\/([a-zA-Z0-9_]+)/.test(value);
        }, msg15);
        $.validator.addMethod("google_check", function (value, element) {
            return  this.optional(element) || /http(s)?:\/\/(www[.])?plus\.google\.com\/.?\/?.?\/?([0-9]*)/.test(value);
        }, msg17);

        var searchform = $('#link_config');
        var errorHandler1 = $('.errorHandler', searchform);
        //  var successHandler1 = $('.successHandler', form_setting);

        $('#link_config').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            ignore: ':hidden',
            rules: {
                fb_link: {
                    required: true,
                    facebook_check: true,
                },
                twitter_link: {
                    required: true,
                    twitter_check: true,

                },
                inst_link: {
                    required: true,
                    insta_check: true,
                },
                gplus_link: {
                    required: true,
                    google_check: true,
                },
                fb_count: {
                    required:true,
                    digits:true
                },
                twitter_count: {
                    required:true,
                    digits:true
                },
                inst_count: {
                    required:true,
                    digits:true
                },
                gplus_count: {
                    required:true,
                    digits:true
                }
            },
            messages: {
                fb_link: {
                    required: msg26,
                    facebook_check: msg14,
                },
                twitter_link: {
                     required: msg27,
                    twitter_check: msg15,
                },
                inst_link: {
                     required: msg28,
                    insta_check: msg16,
                },
                gplus_link: {
                     required: msg29,
                    google_check: msg17,
                },
                fb_count:{
                    required: msg22,
                    digits:msg8
                },
                twitter_count:{
                    required: msg23,
                    digits:msg8
                },
                inst_count:{
                    required: msg24,
                    digits:msg8
                },
                gplus_count:{
                    required: msg25,
                    digits:msg8
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
            runValidateLetterConfig();
            runValidateLinkConfig();

        }
    };

}();

$(document).ready(function ()
{
    ValidateUser.init();
    var msg1 = $("#validate_msg11").html();

    $("#phone").keypress(function (e)
    {

        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 43)
        {
            //display error message
            $("#errmsg1").html("<font color= '#b94a48'>"+msg1+"</font>").show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#pin_maxcount").keypress(function (e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            //display error message
            $("#errmsg2").html("<font color= '#b94a48'>"+msg1+"</font>").show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#length").keypress(function (e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            //display error message
            $("#errmsg1").html("<font color= '#b94a48'>"+msg1+"</font>").show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#payout_amount").keypress(function (e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            //display error message
            $("#errmessage1").html("<font color= '#b94a48'>"+msg1+"</font>").show().fadeOut(1200, 0);
            return false;
        }
    });
//    $('#inst_link,#fb_link,#twitter_link,#gplus_link').on('focus', function () {
//        $(this).valid();
//    });

    $("#form_setting").validate({
        submitHandler: function (form) {
            SubmittingForm();
        },
        rules: {
            content: "required",
        },
        messages: {
            content: "Content is empty!!",
        }
    });
});
