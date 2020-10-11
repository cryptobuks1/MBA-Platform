$(function() {
        ValidateSearchMember.init();
        var from_page = $('#from_page').val();
        if(from_page != "link"){
            $(document).find("a[href*='income_details/income']").closest('li').removeClass('active open');
            $(document).find("a[href*='income_details/income']").closest('li').closest('ul').closest('li').removeClass('active open');
         $(document).find("a[href*='profile/user_account']").closest('li').addClass('active');
        }
});
var ValidateUser = function() {

    // function to initiate Validation Sample 1

    var msg = $("#error_msg").html();
    var runValidatorweeklySelection = function() {
	var searchform = $('#searchform');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#searchform').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		user_name: {
		    minlength: 1,
		    required: true
		},
	    },
	    messages: {
		user_name: msg,
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
	var searchform = $('#upload');
	var errorHandler1 = $('.errorHandler', searchform);
        var msg= $("#username_msg").html();
	$('#upload').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		ir_id_no: {
		    minlength: 1,
		    required: true
		},
	    },
	    messages: {
		ir_id_no: msg,
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
	    runValidatordailySelection();
	}
    };
}();


function check_new_placement_available()
{


    // document.upload.register.disabled = true;
    //document.getElementById('referal_div').style.display = "none";

    var path_temp = document.upload.path_temp.value;

    var path_root = document.upload.path_root.value;

    var error = 0;
    var ir_id_no = $('#ir_id_no').val();

//    if ($('#ir_id_no').val() == "") {
//      
//        inlineMsg("ir_id_no", "Enter IM ID Here", 2);
//        return false;
//    }
    if (error != 1)

    {

	var ref_user_availability = path_root + "admin/member/placement_availability"
	//remove all the class add the messagebox classes and start fading

	$("#referral_box").removeClass();

	$("#referral_box").addClass('messagebox');

	$("#referral_box").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" /> Checking sponsor username...').show().fadeTo(1900, 1);

	//check the username exists or not from ajax



	$.post(ref_user_availability, {
	    ir_id_no: $('#ir_id_no').val(),
	    change_userid: $('#user_id').val()
	}, function(data)

	{

//alert("00000000"+trim(data));
//alert("11111"+data);

	    if (data == 'no') //if username not avaiable

	    {

		$("#errormsg").fadeTo(200, 0.1, function() //start fading the messagebox

		{

		    //add message and change the class of the box and start fading

		    $(this).removeClass();

		    $(this).addClass('messageboxerror');

		    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" /> Invalid Sponsor username ...').show().fadeTo(1900, 1);
		    // document.getElementById('referal_div').style.display = "none";
		    //get_tc_count_allocate("none");
		    // disable();

		});

	    }

	    else

	    {

		$("#errormsg").fadeTo(200, 0.1, function()  //start fading the messagebox

		{

		    //add message and change the class of the box and start fading

		    $(this).removeClass();

		    $(this).addClass('messageboxok');

		    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />Sponsor username validated...').show().fadeTo(1900, 1);

		    // getreferralname(ir_id_no);
		    //  get_tc_count_allocate(ir_id_no);
		    //enable();


		});

	    }



	});

    }


}
