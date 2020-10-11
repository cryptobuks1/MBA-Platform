$(function()
{
   ValidateUploadNews.init();
   ValidateMaterialsUpload.init(); 
});
function edit_events(id, root)

{
    var confirm_msg = $('#confirm_msg1').html();
    if (confirm(confirm_msg))

    {

	document.location.href = root + 'news/event/edit/' + id;

    }



}

//Delete News

function delete_events(id, root)

{
    var confirm_msg = $('#confirm_msg2').html();
    if (confirm(confirm_msg))

    {

	document.location.href = root + 'news/event/delete/' + id;

    }



}
function edit_system(id, root)

{
    var confirm_msg = $('#confirm_msg1').html();
    if (confirm(confirm_msg))

    {

	document.location.href = root + 'news/system/edit/' + id;

    }



}

//Delete News

function delete_system(id, root)

{
    var confirm_msg = $('#confirm_msg2').html();
    if (confirm(confirm_msg))

    {

	document.location.href = root + 'news/system/delete/' + id;

    }



}
function edit_quote(id, root)

{
    var confirm_msg = $('#confirm_msg1').html();
    if (confirm(confirm_msg))

    {

	document.location.href = root + 'news/motivation/edit/' + id;

    }



}

//Delete News

function delete_quote(id, root)

{
    var confirm_msg = $('#confirm_msg2').html();
    if (confirm(confirm_msg))

    {

	document.location.href = root + 'news/motivation/delete/' + id;

    }



}

var ValidateUploadNews = function() {

    // function to initiate Validation Sample 1
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();

    var runValidatorweeklySelection = function() {
	var searchform = $('#upload_news');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#upload_news').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorId: 'err_news',
	    errorPlacement: function (error, element) { // render error placement for each input type
                if ($(element).hasClass("date-picker")) {
                    error.insertAfter($(element).closest('.input-group'));
                } else if ($(element).hasClass("ckeditor")) {
                    error.insertAfter($('#cke_news_desc'));
                } else
                {
                    error.insertAfter(element);
                }
                ;
                //error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
          ignore: [],
          debug:false,
	    rules: {
		news_title: {
		    minlength: 1,
		    required: true,
                    maxlength:50
		},
		news_desc:{
//		    required: function(){CKEDITOR.instances.news_desc.updateElement();},
                    required: true,
                    maxlength:200
		}
	    },
	    messages: {
		news_title: {
                    required: msg,
                    maxlength:msg2
                },
		news_desc: {
                    required: msg1,
                    maxlength:msg3
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

var ValidateMaterialsUpload = function() {

    // function to initiate Validation Sample 1
    var msg = $("#validate_msg1").html();
    var msg1 = $("#validate_msg2").html();
    var msg2 = $("#validate_msg3").html();
    var msg3 = $("#validate_msg4").html();
    var msg4 = $("#validate_msg5").html();
    var msg5 = $("#validate_msg6").html();
    var runValidateNewsUpload = function() {
	var searchform = $('#upload_materials');
	var errorHandler1 = $('.errorHandler', searchform);
        
        $.validator.addMethod('filesize', function (value, element, param) {
             return this.optional(element) || (element.files[0].size <= param)
            }, msg5);
	$('#upload_materials').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		file_title: {
		    minlength: 1,
		    required: true,
                    maxlength:50
		},
		file_desc: {
		    minlength: 1,
		    required: true,
                    maxlength:200
		},
		upload_doc: {
		    minlength: 1,
		    required: true,
                    filesize: 2097152
		},
		category: {
		    required: true
		}
	    },
	    messages: {
		file_title: {
                required: msg,
                maxlength:msg4
                },
		file_desc: {
                    required: msg2,
                    maxlength:msg3
                },
		upload_doc: {required:msg1,minlength:msg1}  
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
	    runValidateNewsUpload();

	}
    };
}();
$('#category').on('change', function () {
    var selectedValue = $(this).val();
    $(".ext").hide();
    $("#" + selectedValue).show();
});

