function share(caption, invite_id) {
caption = caption.replace(/\r?\n/g, '<br />');
        var base_url = $("#base_url").val();
        var invite_url = base_url + 'social_invites/facebook/' + invite_id;
        var appId = 464052483800327;
        var logo = document.getElementById('logo').value;
        FB.init({
        appId: appId,
                status: true,
                cookie: true,
                xfbml: true,
                version: 'v2.5'
        });
        FB.ui({
        method: 'feed',
                link: invite_url,
                caption: caption,
                picture: logo,
                message: 'Facebook Dialogs are easy!'
        }, function (response) {
        if (response && !response.post_id) {
        alert('Post was not published.');
        }
        });
        }



//var validate_invite = function () {
//
//    // function to initiate Validation Sample 1
//
//    var runValidateinvite = function () {
//        var msg1 = $("#validate_msg1").html();
//        var msg2 = $("#validate_msg2").html();
//        var msg3 = $("#validate_msg3").html();
//        var msg = $("#errmsg").html();
//        var searchform = $('#invite');
//        var errorHandler1 = $('.errorHandler', searchform);
//        $('#invite').validate({
//            errorElement: "span", // contain the error msg in a span tag
//            errorClass: 'help-block',
//            errorPlacement: function (error, element) { // render error placement for each input type
//                if ($(element).hasClass("date-picker")) {
//                    error.insertAfter($(element).closest('.input-group'));
//                } else if ($(element).hasClass("ckeditor")) {
//                    error.insertAfter($('#cke_message'));
//                } else
//                {
//                    error.insertAfter(element);
//                }
//
//
//
//                //error.insertAfter(element);
//                // for other inputs, just perform default behavior
//            },
//            ignore: [],
//            rules: {
//                to_mail_id: {
//                    minlength: 1,
//                    required: true
//
//                },
//                subject: {
//                    minlength: 1,
//                    required: true
//
//                },
//                message: {
//                    minlength: 1,
//                    required: true
//
//                }
//
//
//            },
//            messages: {
//                to_mail_id: msg1,
//                subject: msg2,
//                message: msg3,
//            },
//            invalidHandler: function (event, validator) { //display error alert on form submit
//                errorHandler1.show();
//            },
//            highlight: function (element) {
//                $(element).closest('.help-block').removeClass('valid');
//                // display OK icon
//                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
//                // add the Bootstrap error class to the control group
//            },
//            unhighlight: function (element) { // revert the change done by hightlight
//                $(element).closest('.form-group').removeClass('has-error');
//                // set error class to the control group
//            },
//            success: function (label, element) {
//                label.addClass('help-block valid');
//                // mark the current input as valid and display OK icon
//                //$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
//                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
//            }
//        });
//    };
//    return {
//        //main function to initiate template pages
//        init: function () {
//            runValidateinvite();
//        }
//    };
//}();




var validate_invite = function () {

// function to initiate Validation Sample 1
 var runValidateinvite = function () {
var msg1 = $("#validate_msg1").html();
        var msg2 = $("#validate_msg2").html();
        var msg3 = $("#validate_msg3").html();
        var msg = $("#errmsg").html();
        var searchform = $('#invite');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#invite').validate({
errorElement: "span", // contain the error msg in a span tag
        errorClass: 'help-block',
        errorPlacement: function (error, element) { // render error placement for each input type
        if ($(element).hasClass("date-picker")) {
        error.insertAfter($(element).closest('.input-group'));
        } else if ($(element).hasClass("ckeditor")) {
        error.insertAfter($('#cke_message'));
        } else
        {
        error.insertAfter(element);
        }
        ;
                //error.insertAfter(element);
                // for other inputs, just perform default behavior
        },
        ignore: [],
        rules: {
        to_mail_id: {
        minlength: 1,
                required: true

        },
                subject: {
                minlength: 1,
                        required: true

                },
        message: {
        minlength: 1,
                required: true

        }
        },
        messages: {
        to_mail_id: msg3,
                subject: msg1,
                message: msg2,
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
        runValidateinvite();
        }
        };
        }();