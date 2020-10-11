function validate_employee(employee_form)

{
    var name = employee_form.user1.value;
    var msg=$("#error_msg").html();
    //alert(name);
    if(name == "") {

        inlineMsg('user1',msg,2);

        return false;

    }

    return true;

}


var ValidateUser= function() {
    
    var msg1 = $("#error_msg1").html();  
    var runValidatorweeklySelection = function() {
        var searchform = $('#user_register');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#user_register').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

               if ($(element).hasClass("date-picker") ) {
				 error.insertAfter($(element).closest('.input-group'));
				}
				else
				{
				 error.insertAfter(element);
				};
				// error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                user1: {
                    minlength: 1,
                    required: true
                }
          
              
            },
            messages: {
                 user1: msg1
           
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
    var runValidatorSetPermission = function() {
        var searchform = $('#permission_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#permission_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

               if ($(element).hasClass("date-picker") ) {
				 error.insertAfter($(element).closest('.input-group'));
				}
				else
				{
				 error.insertAfter(element);
				};
				// error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                user_name: {
                    minlength: 1,
                    required: true
                }         
              
            },
            messages: {
                 user_name: msg1
           
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
            runValidatorSetPermission();
           
        }
    };
}();