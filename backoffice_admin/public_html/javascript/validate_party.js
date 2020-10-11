$(function()
{
   validateParty.init();
});
function show_new()
{
    document.getElementById('new_host').style.display = "";
    document.getElementById('select_host').style.display = "none";
}
function hide_new()
{
    document.getElementById('new_host').style.display = "none";
    document.getElementById('select_host').style.display = "none";
}
function show_exist()
{
    document.getElementById('new_host').style.display = "none";
    document.getElementById('select_host').style.display = "";
}

function show_new_address()
{
    document.getElementById('new_address').style.display = "";
}
function hide_new_address()
{
    document.getElementById('new_address').style.display = "none";
}
//function getAllStatessSetup(country_code)
//{
//    var root = document.setup_party.path_root.value
//    var strURL = root + "/party_setup/get_states/" + country_code;
//    var req = getXMLHTTP();
//
//    if (req) {
//
//        req.onreadystatechange = function() {
//            if (req.readyState == 4) {
//                // only if "OK"
//                if (req.status == 200) {
//                    document.getElementById('state').innerHTML = trim(req.responseText);
//                    document.getElementById('state').style.display = '';
//                } else {
//                    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
//                }
//            }
//        }
//        req.open("GET", strURL, true);
//        req.send(null);
//    }
//}

function getAllStatessSetup(country_code)
{

    var root = $("#path_root").val();
    var strURL = root + "/party/get_statesAdd/" + country_code;
    var req = getXMLHTTP();

    if (req) {

        req.onreadystatechange = function () {
            if (req.readyState == 4) {
                if (req.status == 200) {
                    document.getElementById('state').innerHTML = trim(req.responseText);
                    document.getElementById('state').style.display = '';
                } else {
                    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                }
            }
        }
        req.open("GET", strURL, true);
        req.send(null);
    }
}




function setSessionPartyId(party_id)
{

    var path_root = $("#path_root").val();
    document.location.href = path_root + '/myparty/setSessionPartyId/' + party_id;
}
function partyStartEnddateDisplay()
{

        document.getElementById('party_start_end_date').style.display = "block";
}

function viewAllStepsParty()
{
    
    document.getElementById('party_details').style.display = "block";
      
}

function confirmClose(close_party)
{
    var confirm_msg = $("#confirm_msg_delete").html();
    var path_root = $("#path_root").val();


    if (confirm(confirm_msg))
    {
        document.location.href = path_root + '/myparty/delete_party/' + close_party;

    }

}
function select_product(id, root)
{
    document.location.href = root + 'party_guest_order/select_product/' + id;
}
function edit_order(id, root)
{
    document.location.href = root + 'party_guest_order/edit_order/' + id;
}
function delete_product_order(id, p_id, root)
{
    var msg=$("#validate_msg17").html();
    if (confirm(msg))
    {
        document.location.href = root + 'party_guest_order/delete_product_order/' + id + '/' + p_id;
    }
}



var validateParty = function () {

    var runValidatorweeklySelection = function () {
        var msg1 = $("#error_msg1").html();
        var msg2 = $("#error_msg2").html();
        var msg3 = $("#error_msg3").html();
        var msg4 = $("#error_msg4").html();
        var msg5 = $("#error_msg5").html();
        var msg6 = $("#error_msg6").html();
        var msg7 = $("#error_msg7").html();
        var msg8 = $("#error_msg8").html();
        var msg9 = $("#error_msg9").html();
        var msg10 = $("#error_msg10").html();
        var msg11 = $("#error_msg11").html();
        var msg12 = $("#error_msg12").html();
        var date = $("#error_msg13").html();
        var time = $("#error_msg14").html();

        var searchform = $('#setup_party');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#setup_party').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                if ($(element).hasClass("date-picker") || $(element).hasClass("time-picker")) {
                    error.insertAfter($(element).closest('.input-group'));
                }
                else if ($(element).hasClass("true")) {
                    error.insertAfter($(element).closest('.user-edit-image-buttons'));
                }
                else
                {

                    error.insertAfter(element);
                }
                ;
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                party_name: {
                    minlength: 1,
                    required: true
                },
                host_id: {minlength: 1,
                    required: true,
                },
                host_country: {
                    minlength: 1,
                    required: true
                },
                first_name: {
                    minlength: 1,
                    required: true
                },
                last_name: {minlength: 1,
                    required: true},
                host_address: {
                    minlength: 3,
                    required: true
                },
                host_city: {
                    minlength: 1,
                    required: true
                },
                host_zip: {
                    minlength: 1,
                    required: true,
                    number: true
                },
                host_phone: {
                    minlength: 10,
                    required: true,
                    number: true},
                host_email: {
                    minlength: 1,
                    required: true,
                    email: true
                },
                from_date: {
                    minlength: 1,
                    required: true
                },
                from_time: {minlength: 1,
                    required: true},
                to_date: {minlength: 1,
                    required: true},
                to_time: {minlength: 1,
                    required: true},
                address_new: {
                    minlength: 1,
                    required: true
                },
                city: {
                    minlength: 1,
                    required: true
                },
                country: {
                    minlength: 1,
                    required: true
                },
                zip: {
                    minlength: 1,
                    required: true,
                    number: true
                },
                phone: {minlength: 10,
                    required: true,
                    number: true,
                },
                email: {
                    minlength: 1,
                    required: true,
                    email: true
                }
            },
            messages: {
                party_name: msg1,
                host_id: msg3,
                host_country: msg4,
                first_name: msg5,
                last_name: msg6,
                host_address: msg7,
                host_city: msg8,
                host_zip: msg10,
                host_phone: msg11,
                host_email: {minlength: msg12,
                    required: msg12,
                    email: "eg: example@gmail.com"},
                from_date: date,
                from_time: time,
                to_date: date,
                to_time: time,
                address_new: msg7,
                city: msg8,
                country: msg4,
                zip: msg10,
                phone: msg11,
                email: {minlength: msg12,
                    required: msg12,
                    email: "eg: example@gmail.com"},
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
            runValidatorweeklySelection();

        }
    };
}();

$(document).ready(function ()
{
    $("#address_new").keypress(function (e)
    {
       
       
        //if the letter is not digit then display error and don't type anything

       if (e.which != 44 && e.which != 46 && e.which != 32 &&  e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122))

        {
            //display error message            

            $("#errormsg4").html("Alpha numeric values only").show().fadeOut(1200, 0);

            return false;
        }

    });

    $("#city").keypress(function (e)
    {
        //if the letter is not digit then display error and don't type anything

        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122))

        {
            //display error message            

            $("#errormsg5").html("Alpha numeric values only").show().fadeOut(1200, 0);

            return false;
        }

    });


    $("#host_address").keypress(function (e)
    {
   
        //if the letter is not digit then display error and don't type anything
  var msg2 = $("#validate_msg15").html();
        if (e.which != 44 && e.which != 46 && e.which != 32 &&  e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122))

        {
            //display error message            

            $("#errormsg6").html(msg2).show().fadeOut(1200, 0);

            return false;
        }

    });
    $("#host_city").keypress(function (e)
    {
        //if the letter is not digit then display error and don't type anything
 var msg2 = $("#validate_msg15").html();
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122))

        {
            //display error message            

            $("#errormsg7").html(msg2).show().fadeOut(1200, 0);

            return false;
        }

    });
    $("#first_name").keypress(function (e)
    {
        //if the letter is not digit then display error and don't type anything
 var msg2 = $("#validate_msg15").html();
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122))

        {
            //display error message            

            $("#errormsg8").html(msg2).show().fadeOut(1200, 0);

            return false;
        }

    });
    $("#last_name").keypress(function (e)
    {
        var msg2 = $("#validate_msg15").html();
        //if the letter is not digit then display error and don't type anything

        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122))

        {
            //display error message            

            $("#errormsg9").html(msg2).show().fadeOut(1200, 0);

            return false;
        }

    });
   
    
        $("#host_zip").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            //display error message
            $("#errormsg10").html("Digits only").show().fadeOut(1200, 0);
            return false;
        }
        return true;
    });
        $("#zip").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            //display error message
             $("#errormsg11").html("Digits only").show().fadeOut(1200, 0);
            return false;
        }
        return true;
    });
    
   
    $("#phone").keypress(function (e)
    {
        //if the letter is not digit then display error and don't type anything

        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))

        {
            //display error message            

            $("#errormsg12").html("Digits only").show().fadeOut(1200, 0);

            return false;
        }

    });
    $("#host_phone").keypress(function (e)
    {
        //if the letter is not digit then display error and don't type anything

         if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))

        {
            //display error message            

            $("#errormsg13").html("Digits only").show().fadeOut(1200, 0);

            return false;
        }

    });
  
});
