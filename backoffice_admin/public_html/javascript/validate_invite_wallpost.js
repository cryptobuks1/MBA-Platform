$(function ()
{
    validate_invite_wallpost.init();
    validate_invite_wallpost_fb.init();
});
var validate_invite_wallpost = function () {

    // function to initiate Validation Sample 1

    var runValidateInviteConfig = function () {
        var msg1 = $("#validate_msg1").html();
        var msg2 = $("#validate_msg2").html();
        var msg = $("#errmsg").html();
        var searchform = $('#soial_invite_email');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#soial_invite_email').validate({
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
                subject: {
                    minlength: 1,
                    required: true,
                    maxlength: 50

                },
                message: {
                    minlength: 1,
                    required:  function() 
                        {
                         CKEDITOR.instances.message.updateElement();
                        },
                    maxlength: 200    

                }
            },
            messages: {
                subject: {
                    required: msg1
                },
                message: {
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
            runValidateInviteConfig();
        }
    };
}();



var validate_invite_wallpost_fb = function () {

    // function to initiate Validation Sample 1
    var runValidateWallpost = function () {
        var msg1 = $("#validate_msg1").html();
        var msg2 = $("#validate_msg2").html();
        var msg = $("#errmsg").html();
        var searchform = $('#soial_invite_fb');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#soial_invite_fb').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                if ($(element).hasClass("date-picker")) {
                    error.insertAfter($(element).closest('.input-group'));
                } else if ($(element).hasClass("ckeditor")) {
                    error.insertAfter($('#cke_description'));
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
                caption: {
                    minlength: 1,
                    required: true,
                     maxlength: 50

                },
                description: {
                    minlength: 1,
                    required:  function() 
                        {
                         CKEDITOR.instances.description.updateElement();
                        },
                     maxlength: 200    

                }
            },
            messages: {
                caption: {
                    required: msg1
                },
                description: {
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
            runValidateWallpost();
        }
    };
}();


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
   
    function Sharer(id){
     var base_url = $('#base_url').val();
     var get_details = base_url + getUserType() + "/member/getSocialInviteData";
     $.post(get_details, { id: id }, function(data) {
         data = trim(data);
         if (data) {
             var fburl= '' ;
             var json = JSON.parse(data);
             subject= json["subject"];
             content= json["content"];
             type =  json["type"];
             if(type == "social_fb"){
                 var sharerURL = "http://www.facebook.com/sharer/sharer.php?s=100&p[url]=" + encodeURI(fburl) + "&p[title]=" + encodeURI(subject) + "&p[summary]=" + encodeURI(content);
             } else if(type == "social_google_plus") {
                 var sharerURL = "https://plus.google.com/share?url=" + encodeURI(fburl) + "&p[title]=" + encodeURI(subject) + "&p[summary]=" + encodeURI(content);
             } else if(type == "social_twitter"){
                 var sharerURL = "http://twitter.com/home?status=" + encodeURI(content);
             } else if(type == "social_instagram"){
                 var sharerURL = "http://instagram.com/share?text=" + encodeURI(content);
             }
             window.open(
            sharerURL,
            '', 
           'left=0,top=0,width=550,height=450,personalbar=0,toolbar=0,scrollbars=0,resizable=0'); 
          return  false;       
         }
     });
    }

    function trim(a) {
        return a.replace(/^\s+|\s+$/, '');
    }
