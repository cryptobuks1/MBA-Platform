$(function(){
    $('.more > a').on('click', function () {
        $(this).parent('.more').hide();
        $(this).parent('.more').next('.less').show();
    });
    $('.less > a').on('click', function () {
        $(this).parent('.less').hide();
        $(this).parent('.less').prev('.more').show();
    });
});
function trim(a)
{

    return a.replace(/^\s+|\s+$/, '');
}

function getXMLHTTP() { //fuction to return the xml http object
    var xmlhttp = false;
    try {
        xmlhttp = new XMLHttpRequest();
    }
    catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (e) {
            try {
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
            }
            catch (e1) {
                xmlhttp = false;
            }
        }
    }

    return xmlhttp;
}
function deleteMessage(id, row, type, path_root)
{
    var confirm_msg = $("#confirm_msg").html();
    if (confirm(confirm_msg))
    {
        document.location.href = path_root + "/mail/deleteMessage/" + id + "/" + type;
    }
}
function deleteSentMessage(id, row, type, path_root)
{
    var confirm_msg = $("#confirm_msg").html();
    if (confirm(confirm_msg))
    {
        document.location.href = path_root + "/mail/deleteSentMessage/" + id + "/" + type;
    }
}
function deleteDownlineMessages(id, row, type, path_root)
{
    
    var confirm_msg = $("#confirm_msg").html();
    if (confirm(confirm_msg))
    {
        document.location.href = path_root + "/mail/deleteDownlineSendMessage/" + id + "/" + type;
    }
}
function deleteFromMessage(id, row, type, path_root)
{
   
    var confirm_msg = $("#confirm_msg").html();
    if (confirm(confirm_msg))
    {
        document.location.href = path_root + "/mail/deleteDownlineFromMessage/" + id + "/" + type;
    }
}


function getOneMessage(msg_id, user_id, type, path_root)
{
    // alert(path_root);
    //var path_root=document.path.value;
    var strURL = path_root + "/mail/getMessage/" + msg_id + "/" + user_id + "/" + type;
//alert(strURL);
    var req = getXMLHTTP();
    if (req) {

        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                // only if "OK"			
                if (req.status == 200)
                {

                    // document.getElementById('text_message').innerHTML=trim(req.responseText);
                    document.getElementById('username' + msg_id).style.color = "#C48189";
                    document.getElementById('suject' + msg_id).style.color = "#C48189";
                    document.getElementById('date' + msg_id).style.color = "#C48189";
                }
                else
                {
                    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                }
            }
        }
        req.open("GET", strURL, true);
        //alert(strURL);
        req.send(null);
    }

}

function view_popup(user_name, row, type, path_root)
{

    var strURL = path_root + 'payout/user_details/' + user_name;

    var req = getXMLHTTP();
    if (req) {

        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                // only if "OK"	

                if (req.status == 200)
                {

                    document.getElementById('div1').innerHTML = trim(req.responseText);

                    document.getElementById('transaction').style.visibility = 'visible';


                }
                else
                {
                    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                }
            }
        }
        req.open("GET", strURL, true);
        //alert(strURL);
        req.send(null);
    }
}


function getleadetails(id)
{
   // document.getElementById('fade').style.display="none";
   // document.getElementById("popuprel").style.marginTop = "0px";
   // document.getElementById("popuprel").style.marginLeft = "0px";
    
    $.ajax({
            type: 'POST',
            url: $("#baseURL").val() + "member/getleads",
            data: {
                id: id },
            success: function (msg) {
                $('#text_message').html(msg);
                //$('#modaltitle').html('Lead details');
               // $('#popuprel').css('width', '');
               // $('#popuprel').css('left', '');
               // $('#popuprel').modal('show');
               $('#squarespaceModal').modal('show');

               
            },
            error: function (msg) {
                alert("Error Occured!");
            }
        });
}

var ValidateUser = function() {

    // function to initiate Validation Sample 1
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#error_msg4").html();
    var msg5 = $("#error_msg5").html();
    var runValidatorweeklySelection = function() {
        var searchform = $('#compose_admin');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#compose_admin').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
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
                subject: msg,
                message: msg1

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
    /*   var runValidatordailySelection = function() {
     var searchform = $('#change_pass_common');
     var errorHandler1 = $('.errorHandler', searchform);
     $('#change_pass_common').validate({
     errorElement: "span", // contain the error msg in a span tag
     errorClass: 'help-block',
     errorPlacement: function(error, element) { // render error placement for each input type
     
     error.insertAfter(element);
     // for other inputs, just perform default behavior
     },
     ignore: ':hidden',
     rules: {
     user_name_common: {
     minlength: 1,
     required: true
     },
     new_pwd_common: {
     minlength: 1,
     required: true
     },
     confirm_pwd_common: {
     minlength: 1,
     required: true,
     equalTo: "#new_pwd_common"
     }
     },
     messages: {
     user_name_common: msg5,
     new_pwd_common: msg1,
     confirm_pwd_common: msg3
     
     
     
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
     };*/
    return {
        //main function to initiate template pages
        init: function() {
            runValidatorweeklySelection();

        }
    };
}();
function readMessage(id, row, type, path_root) {
        //alert('asd');
        var user_available = path_root + "/mail/readMessage";
        $.post(user_available, {
            id: id,
            type: type,
        }, function (data) {
            var status = trim(data);
            if (data >= 0) {
                $("#mailcount").html(data);
                $("#usernam" + id).css("color", "#C48189");
                $("#sbjct" + id).css("color", "#C48189");
                $("#addate" + id).css("color", "#C48189");
            }
        });
    }
    var runModuleTools = function () {
        $('.panel-tools .panel-refresh').bind('click', function (e) {
            var el = $(this).parents(".panel");
            el.block({
                overlayCSS: {
                    backgroundColor: '#fff'
                },
                message: '<img src="'+base_url+'/public_html/images/loading.gif" /> Just a moment...',
                css: {
                    border: 'none',
                    color: '#333',
                    background: 'none'
                }
            });
            window.setTimeout(function () {
                el.unblock();
            }, 1000);
            e.preventDefault();
        });
        return {
        //main function to initiate template pages
        init: function () {
            runModuleTools();
        }
    };
    };