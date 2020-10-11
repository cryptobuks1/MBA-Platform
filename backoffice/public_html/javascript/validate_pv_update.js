$(function() {
    ValidatePvUpdate.init();
    
     $("#new_pv").keypress(function(e) {
        if (e.which == 0 || e.which == 8) {
         alert("111");
            return;
        }
        var regex = new RegExp("^[0-9]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        } else {
            var msg = $("#error_msg1").html();
            showErrorSpanOnKeyup(this, msg);
            return false;
        }
    });
});
var ValidatePvUpdate = function() {

    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();

    var runValidateProduct = function() {

    	var searchform = $('#update_pv');
    	var errorHandler1 = $('.errorHandler', searchform);
        $.validator.addMethod("non_zero", function(value, element) {
           return  /^[1-9]\d*$/.test(value);
        }, msg3);
    	$('#update_pv').validate({
    		errorElement: "span", 
    		errorClass: 'help-block',
    		errorId: 'err_prod',
    		errorPlacement: function(error, element) {
                    if($(element).parent('.input-group').length === 0) {
    			error.insertAfter(element);
                    }
                    else {
                        error.insertAfter($(element).closest('.input-group'));
                    }

    		},
    		ignore: ':hidden',
    		rules: {
    			new_pv: {
                            required: true,
                            number: true,
                            non_zero: true,
                            maxlength: 5
                        }
                    },
    		messages: {
    			new_pv: {
                            required: msg,
                            number: msg1,
                            maxlength: msg2
                        }
                },
    		invalidHandler: function(event, validator) { 
    			errorHandler1.show();
    		},
    		highlight: function(element) {
    			$(element).closest('.help-block').removeClass('valid');

    			$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');

    		},
    		unhighlight: function(element) { 
    			$(element).closest('.form-group').removeClass('has-error');
    		},
    		success: function(label, element) {
    			label.addClass('help-block valid');
    			$(element).closest('.form-group').removeClass('has-error').addClass('ok');
    		}
    	});
         };  
    return {
    	init: function() {
    		runValidateProduct();
    	}
    };
}();
function showErrorSpanOnKeyup(element, message) {
    var span = "<span id='err_keyup_" + element.name + "' class='keyup_error' style='color: #b94a48;'>" + message + "</span>";
    if ($(element).closest('.input-group').length) {
        $(element).closest('.input-group').next('span.keyup_error').remove();
        $(element).closest('.input-group').after(span);
        $(element).closest('.input-group').next('span:first').fadeOut(2000, 0);
    }
    else {
        $(element).next('span.keyup_error').remove();
        $(element).after(span);
        $(element).next('span:first').fadeOut(2000, 0);
    }
}

