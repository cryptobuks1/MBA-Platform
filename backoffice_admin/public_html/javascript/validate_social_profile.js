var ValidateSocialProfile = function () {

    // function to initiate Validation Sample 1
    var msg1 = $("#msg1").html();
    var msg2 = $("#msg2").html();
    var msg3 = $("#msg3").html();
    var msg4 = $("#msg4").html();
    var msg5 = $("#msg5").html();
    var msg6 = $("#msg6").html();
    var msg7 = $("#msg7").html();
    var msg8 = $("#msg8").html();
    var msg9 = $("#msg9").html();
    var msg10 = $("#msg10").html();
    var msg11 = $("#msg11").html();
    var msg12 = $("#msg12").html();

    var runValidateSocialProfiles = function () {
        $.validator.addMethod("youtube_check", function(value, element) {
           return  this.optional(element)|| /^http(s)?:\/\/(www\.)?(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/.test(value);
        }, msg7);
        $.validator.addMethod("facebook_check", function(value, element) {
           return  this.optional(element)|| /^http(s)?:\/\/(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/.test(value);
        }, msg8);
        $.validator.addMethod("linkedin_check", function(value, element) {
           return  this.optional(element)|| /http(s)?:\/\/((www|\w\w)\.)?linkedin.com\/(\w+:{0,1}\w*@)?(\S+)(:([0-9])+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/.test(value);
        }, msg10);
        $.validator.addMethod("insta_check", function(value, element) {
           return  this.optional(element)|| /http(s)?:\/\/(www\.)?instagram\.com\/([A-Za-z0-9_](?:(?:[A-Za-z0-9_]|(?:\.(?!\.))){0,28}(?:[A-Za-z0-9_]))?)/.test(value);
        }, msg12);
        $.validator.addMethod("twitter_check", function(value, element) {
           return  this.optional(element)|| /http(s)?:\/\/(?:www\.)?twitter\.com\/([a-zA-Z0-9_]+)/.test(value);
        }, msg11);
        $.validator.addMethod("google_check", function(value, element) {
           return  this.optional(element)|| /http(s)?:\/\/(www[.])?plus\.google\.com\/.?\/?.?\/?([0-9]*)[a-zA-Z0-9(\.\?)?]/.test(value);
        }, msg9);
        
        var searchform = $('#socail_profile11');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#socail_profile11').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            ignore: [],
            rules: {
                facebook: {
                     facebook_check: true
                },
                twitter: {
                    twitter_check: true
                },
                youtube: {
                    youtube_check: true
                },
                instagram: {
                    insta_check: true
                },
                linkedin: {
                    linkedin_check: true
                },
                google_plus: {
                    google_check: true
                },
            },
            messages: {
                facebook: {
                    // required: msg1
                },
                twitter: {
                    // required: msg2
                },
                youtube: {
                    // required: msg3
                },
                instagram: {
                    // required: msg4
                },
                linkedin: {
                    // required: msg5
                },
                google_plus: {
                    // required: msg6
                },       
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

    

    return {
        //main function to initiate template pages
        init: function () {
            runValidateSocialProfiles();
            

        }
    };
}();
var ValidateYoutube = function () {

    // function to initiate Validation Sample 1
    var msg7 = $("#msg7").html();
    var msg3 = $("#msg3").html();
    var runValidateYoutube = function () {
        $.validator.addMethod("link_check", function(value, element) {
           return  /^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/.test(value);
        }, msg7);
        
        var searchform = $('#youtube_profile');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#youtube_profile').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            ignore: [],
            rules: {
                banner_link: {
                     required: true,
                     link_check: true
                }
            },
            messages: {
                banner_link: {
                    required: msg3,    
                    link_check: msg7
                },       
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

    

    return {
        //main function to initiate template pages
        init: function () {
            runValidateYoutube();
            

        }
    };
}();

var ValidateTerms = function () {

    // function to initiate Validation Sample 1
    var msg13 = $("#msg13").html();
   
    var runValidateTerms = function () {
        
        var searchform = $('#terms_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#terms_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if ($(element).hasClass('ckeditor')) {
                    var element_id = $(element).attr('id');
                    error.insertAfter($('#cke_' + element_id));
                }
                else if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                }
                else {
                    error.insertAfter(element);
                }
            },
            ignore: [],
            rules: {
                content_terms: {
                    required: function () {
                        CKEDITOR.instances.content_terms.updateElement();
                    }     
                },
            },
            messages: {
                content_terms: {
                    required: msg13     
                },
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

    

    return {
        //main function to initiate template pages
        init: function () {
            runValidateTerms();
            

        }
    };
}();
var ValidatePolicy = function () {

    // function to initiate Validation Sample 1
    var msg13 = $("#msg13").html();

    var runValidatePolicy = function () {
        
        var searchform = $('#policy_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#policy_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if ($(element).hasClass('ckeditor')) {
                    var element_id = $(element).attr('id');
                    error.insertAfter($('#cke_' + element_id));
                }
                else if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                }
                else {
                    error.insertAfter(element);
                }
            },
            ignore: [],
            rules: {
                content_policy: {
                    required: function () {
                        CKEDITOR.instances.content_policy.updateElement();
                    }     
                },
            },
            messages: {
                content_policy: {
                    required: msg13     
                },
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

    

    return {
        //main function to initiate template pages
        init: function () {
            runValidatePolicy();
            

        }
    };
}();
var ValidateAbout = function () {

    // function to initiate Validation Sample 1
    var msg13 = $("#msg13").html();

    var runValidateAbout = function () {
        
        var searchform = $('#about_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#about_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if ($(element).hasClass('ckeditor')) {
                    var element_id = $(element).attr('id');
                    error.insertAfter($('#cke_' + element_id));
                }
                else if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                }
                else {
                    error.insertAfter(element);
                }
            },
            ignore: [],
            rules: {
                content_about: {
                    required: function () {
                        CKEDITOR.instances.content_about.updateElement();
                    }     
                },
            },
            messages: {
                content_about: {
                    required: msg13     
                },
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

    

    return {
        //main function to initiate template pages
        init: function () {
            runValidateAbout();
            

        }
    };
}();
var ValidateAddress = function () {

    // function to initiate Validation Sample 1
    var msg15 = $("#msg15").html();

    var runValidateAddress = function () {
        
        var searchform = $('#address_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#address_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if ($(element).hasClass('ckeditor')) {
                    var element_id = $(element).attr('id');
                    error.insertAfter($('#cke_' + element_id));
                }
                else if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                }
                else {
                    error.insertAfter(element);
                }
            },
            ignore: [],
            rules: {
                address: {
                    required: function () {
                        CKEDITOR.instances.address.updateElement();
                    }     
                },
            },
            messages: {
                address: {
                    required: msg15     
                },
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

    

    return {
        //main function to initiate template pages
        init: function () {
            runValidateAddress();
            

        }
    };
}();
var ValidateContent = function () {

    // function to initiate Validation Sample 1
    var msg13 = $("#msg13").html();
    var msg14 = $("#msg14").html();


    var runValidateContent = function () {
        
        var searchform = $('#content_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#content_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if ($(element).hasClass('ckeditor')) {
                    error.insertAfter($('#cke_replica_content_main'));
                }
                else {
                    error.insertAfter(element);
                }
            },
            ignore: [],
            rules: {
                subtitle: {
                    required: true     
                },
                replica_content_main: {
                    required: function () {
                        CKEDITOR.instances.replica_content_main.updateElement();
                    }     
                },
            },
            messages: {
                 subtitle: {
                    required: msg14     
                },
                 replica_content_main: {
                    required: msg13     
                },
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

    

    return {
        //main function to initiate template pages
        init: function () {
            runValidateContent();
            

        }
    };
}();
$(function(){     
        ValidateSocialProfile.init();
        ValidateTerms.init();
        ValidateAbout.init();
        ValidateContent.init();
        ValidatePolicy.init();
        ValidateAddress.init();
        ValidateYoutube.init();
        $(".toggle-accordion-clps").on("click", function() {
            var accordionId = $(this).attr("accordion-id"),
            numPanelOpen = $(accordionId + ' .collapse.in').length;
    
            $(this).toggleClass("active");

            if (numPanelOpen == 0) {
                openAllPanels(accordionId);
            } else {
                closeAllPanels(accordionId);
            }
        });

        openAllPanels = function(aId) {
            console.log("setAllPanelOpen");
            $(aId + ' .panel-collapse:not(".in")').collapse('show');
        }
        closeAllPanels = function(aId) {
            console.log("setAllPanelclose");
            $(aId + ' .panel-collapse.in').collapse('hide');
        }
    
}());
$(".panel-title-clps").on("click", function() {
    //$(this).find(':first-child').
    var aexpnd=$(this).find('a[aria-expanded]:first-child').attr('aria-expanded');
    if(aexpnd=="true"){
        $(this).find('a[aria-expanded]:first-child').attr('aria-expanded',false);
    }else{
        $(this).find('a[aria-expanded]:first-child').attr('aria-expanded',true);
   }  
});