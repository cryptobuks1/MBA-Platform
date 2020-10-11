$(document).ready( function() {
    new_no();
});

function new_no()

{

    //alert('new');



    document.send_sms.numbers.readOnly=false;



    document.send_sms.numbers.value="";



    document.send_sms.numbers.maxLength=10;

    document.send_sms.numbers.size=12;

    document.send_sms.numbers.style.display="block";

    document.send_sms.individual.style.display="none";

    document.send_sms.fromid.style.display="none";

    document.send_sms.toid.style.display="none";
	
	document.getElementById("phone_num_container").style.display = "block";

}

//validate show one

function showone()

{

//    alert('one');
    document.send_sms.numbers.style.display="none";
    document.send_sms.numbers.value="";

    document.send_sms.numbers.readOnly=true;

    document.send_sms.individual.options.selectedIndex=0;

    document.send_sms.individual.style.display="block";

    document.send_sms.fromid.style.display="none";

    document.send_sms.toid.style.display="none";
	
	document.getElementById("phone_num_container").style.display = "block";

}

//validate show id

function showids()

{

    //alert('new');
    document.send_sms.numbers.style.display="none";
    document.send_sms.numbers.value="";

    document.send_sms.numbers.readOnly=true;

    document.send_sms.fromid.options.selectedIndex=0;

    document.send_sms.toid.options.selectedIndex=0;

    document.send_sms.individual.style.display="none";

    document.send_sms.fromid.style.display="block";

    document.send_sms.toid.style.display="block";
	
	document.getElementById("phone_num_container").style.display = "block";
	

}

function validate_sms_val(send_sms)

{

    var numbers = send_sms.numbers.value;

    var word_count = send_sms.word_count.value;



    if(numbers == "") {
         var msg;
        msg=$("#validate_msg1").html();

        inlineMsg('numbers',msg,4);

        disablesms();

        return false;

    }
    
    
    return true;
}
function setLimit1() {
    document.send_sms.numbers.style.display="block";
    document.send_sms.numbers.maxLength=10;
    document.send_sms.numbers.size=12;
}
function setLimit2() {
    document.send_sms.numbers.style.display="block";
    document.send_sms.numbers.maxLength=400;
    document.send_sms.numbers.size=12;
}
function validate_sms1()
{



    var c_value = "";

    var individual=document.send_sms.individual.value;

    var fromid = document.send_sms.fromid.value;

    var toid = document.send_sms.toid.value;

    for (var i=0; i < document.send_sms.selectall.length; i++)

    {

            if (document.send_sms.selectall[i].checked)

            {
                c_value = c_value + document.send_sms.selectall[i].value + "\n";

            }

        }





    c_value = trim(c_value);



    individual== trim(individual);





    if(c_value == 'one')

    {

        if(individual == "Select")

        {
             var msg;
            msg=$("#validate_msg3").html();
            inlineMsg('select',msg,4);

            disablesms();

            return false;

        }

    }



    if(c_value == 'ids')

    {

        if(fromid == "Selectfirstid")

        {
             var msg;
             msg=$("#validate_msg4").html();
            inlineMsg('select',msg,4);

            disablesms();

            return false;

        }



        if(toid == "Selectlastid")

        {
             var msg;
           msg=$("#validate_msg5").html();
            inlineMsg('select',msg,4);

            disablesms();

            return false;

        }

    }



    enablesms();

    return true;

}

function disablesms()

{

    document.send_sms.send_sms_button.disabled=true;

    document.send_sms.send_sms_button.value="Please wait...";

}

function enablesms()

{

    document.send_sms.send_sms_button.disabled=false;

    document.send_sms.send_sms_button.value="Send SMS";

}








function showall()

{

//    alert('new');

    document.send_sms.numbers.readOnly=true;
    
    document.send_sms.numbers.maxLength=20;

    document.send_sms.numbers.style.display="block";

    document.send_sms.numbers.value="All Numbers";

    document.send_sms.individual.style.display="none";

    document.send_sms.fromid.style.display="none";

    document.send_sms.toid.style.display="none";

}

var ValidateUser = function () {
          var msg = $("#validate_msg4").html();
          var msg1 = $("#validate_msg5").html();
          var msg2 = $("#validate_msg6").html();
        var searchform = $('#send_sms');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#send_sms').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { 
                error.insertAfter(element);
                
            },
            ignore: ':hidden',
            rules: {
                
                word_count: {               
                    required: true,
                    minlength: 1
                },
                numbers:{
//                     required: true,
                     
                }
        
        
                
            },
            messages: {
                word_count:msg,
              
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
    
    
     var runValidatordailySelection = function() {
  
         var msg3=$("#error_msg4").html();
          
        var searchform = $('#upload');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#upload').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                userfile: {
                    minlength: 1,
                    required: true
                }
            },
            messages: {
                userfile:msg3
       
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
        init: function () {
           
            runValidatordailySelection();
           
        }
    };
}();
//===============
 