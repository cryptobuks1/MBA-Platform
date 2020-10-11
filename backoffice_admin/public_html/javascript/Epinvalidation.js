var ValidateUser = function() {


    // function to initiate Validation Sample 1
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#error_msg4").html();
    var msg5 = $("#error_msg5").html();
    var msg6 = $("#error_msg6").html();
    var msg7 = $("#error_msg7").html();
    var msg8 = $("#error_msg8").html();
    // var msg9 = $("#error_msg9").html();
    var msg10 = $("#error_msg10").html();
    var msg9 = 'Please Enter a Valid Date';
    var msg11 = $("#error_msg11").html();
    var msg12 = $("#error_name").html();
    var msg13 = $("#err_msg_count").html();
    var msg14 = $("#err_msg_amount").html();
    var runValidatorweeklySelection = function() {
        var searchform = $('#user_select_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $.validator.addMethod("dateCheck", function() {
            var selectedDate = $('#date').datepicker('getDate');
            var now = new Date();

            var twoDigitMonth1 = selectedDate.getMonth() + 1 + "";
            if (twoDigitMonth1.length == 1)
                twoDigitMonth1 = "0" + twoDigitMonth1;
            var twoDigitDate1 = selectedDate.getDate() + "";
            if (twoDigitDate1.length == 1)
                twoDigitDate1 = "0" + twoDigitDate1;


            var twoDigitMonth2 = now.getMonth() + 1 + "";
            if (twoDigitMonth2.length == 1)
                twoDigitMonth2 = "0" + twoDigitMonth2;
            var twoDigitDate2 = now.getDate() + "";
            if (twoDigitDate2.length == 1)
                twoDigitDate2 = "0" + twoDigitDate2;



            var todayStr = now.getFullYear() + "-" + (twoDigitMonth2) + "-" + twoDigitDate2 + " " + now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();
            var selectedStr = selectedDate.getFullYear() + "-" + (twoDigitMonth1) + "-" + twoDigitDate1 + " " + now.getHours() + ':' + (now.getMinutes() + 1) + ':' + now.getSeconds();
            //            console.log('selectedStr: ' + selectedStr + ' today : ' + todayStr);
            if (selectedStr >= todayStr) {
                return true;
            } else if (selectedStr === todayStr) {
                return true;
            } else {
                return false;
            }

        });

        $('#user_select_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                error.insertAfter($(element).closest('.info_block'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                user_name: {
                    minlength: 1,
                    required: true,
                    username_check: true
                },
                count: {
                    minlength: 1,
                    required: true,
                    min: 1,
                    digits: true,
                    maxlength: 2
                },
                date: {
                    minlength: 1,
                    required: true,
                    //    dateCheck: true,
                    todate_greaterthan_fromdate: true,
                    date: true
                },
                amount1: {
                    minlength: 1,
                    required: true

                }

            },
            messages: {
                user_name: {
                    required: msg2,
                    username_check: msg12
                },
                count: {
                    required: msg13,
                    min: msg1,
                    digits: msg1,
                    maxlength: msg11
                },
                date: {
                    required: msg6,
                    //      dateCheck: msg7,
                    todate_greaterthan_fromdate: msg10,
                    date: msg9
                },
                amount1: {
                    required: msg8
                },
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
        jQuery.validator.addMethod('todate_greaterthan_fromdate', function(ExpireDate1) {
            var ExpireDate = new Date(ExpireDate1);
            var CurrentDate = new Date();
            CurrentDate.setHours(0, 0, 0, 0);
            ExpireDate.setHours(0, 0, 0, 0);
            return (ExpireDate >= CurrentDate);
        }, "");
        $.validator.addMethod("username_check", function(value, element) {
            var path_root = $('#base_url').val();
            if (value != "/" && value != ".") {
                $.ajax({
                    'url': path_root + getUserType() + "/ewallet/validate_username",
                    'type': "POST",
                    'data': { username: value },
                    'dataType': 'text',
                    'async': false,
                    'success': function(data) {
                        if (data == 'no') {
                            flag2 = false;
                        } else if (data == 'yes') {
                            flag2 = true;
                        }
                    },
                    'error': function(error) {},
                });
                return flag2;
            } else {
                return true;
            }
        }, msg12);
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


var ValidateUserr = function() {


    // function to initiate Validation Sample 1
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#error_msg4").html();
    var msg5 = $("#error_msg5").html();
    var msg6 = $("#error_msg6").html();
    var runValidatorweeklySelection = function() {
        var searchform = $('#user_select_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#user_select_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                //error.insertAfter(element);
                error.insertAfter($(element).closest('.info_block'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                week_date1: {
                    minlength: 1,
                    //                    required: true
                },
                week_date2: {
                    minlength: 1,
                    //                    required: true,
                    //                    todate_greaterthan_fromdate: true
                }

            },
            messages: {
                week_date1: msg1,
                week_date2: {
                    minlength: msg2,
                    required: msg1,
                    todate_greaterthan_fromdate: msg6
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
        jQuery.validator.addMethod('todate_greaterthan_fromdate', function(ToDate) {
            var FromDate = $("#week_date1").val();
            if ($('#week_date1').val() && $('#week_date2').val()) {
                return (ToDate > FromDate);
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
$("#count").keypress(function(e) {
    var msg = $("#error_msg9").html();
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        $("#count_err").html(msg).show().fadeOut(1200, 0);
        return false;
    }
});
var flag = false;
var epin_msg = $("#select_epin").html();
$("#from_user_name").click(function() {
    var data = "<option value='default'>" + epin_msg + "</option>";
    flag = true;
    $('#epin').html(data);
});

$("#epin").click(function() {
    var user = $('#from_user_name').val();
    var base_url = $("#base_url").val();
    if (flag == true) {
        $.ajax({
            url: base_url + "admin/epin/epin_dynamic_list/" + user + "/",
            type: 'POST',
            dataType: "JSON",
            success: function(data) {
                $('#epin').html(data);
            }
        });
        flag = false;
    }
});

$('.delete').click(function() {
    var delete_status = confirm('Do you want to delete this Epin request?');
    if (delete_status) {
        $(this).closest('form').submit();
    }
});

$('#check_all').click(function() {
    var checkBoxes = $(".request_list");
    var title = $('#check_all').html();
    checkBoxes.prop("checked", !checkBoxes.prop("checked"));
});

function deleteTask() {
    var confirm_msg = $('#confirm_msg').html();
    if (confirm(confirm_msg)) {
        $(this).closest('form').submit();
    } else {
        return false;
    }
}