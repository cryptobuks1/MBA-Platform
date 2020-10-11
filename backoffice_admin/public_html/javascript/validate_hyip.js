$(function () {
    ValidateHolidayConfiguration.init();
});

var ValidateHolidayConfiguration = function () {
    $("#reason").focus();
    $('#holiday').attr('disabled', true);
    var runValidatorHolidayConfig = function () {


        var msg1 = $("#validate_msg1").html();
        var msg2 = $("#validate_msg2").html();
        var msg3 = $("#validate_msg3").html();
        var msg4 = $("#validate_msg4").html();
        var msg10 = $("#validate_msg10").html();

        var searchform = $('#holiday_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#holiday_form').validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            ignore: ':hidden',
            rules: {
                reason: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                },
                week_date2: {
                    required: true
                    //   todate_greaterthan_fromdate: true
                }
            },
            messages: {
                reason: {
                    required: msg2,
                    minlength: msg3,
//                    maxlength: msg4

                },
                week_date2: {
                    required: msg1
                    //      todate_greaterthan_fromdate: msg10
                }
            },

            invalidHandler: function (event, validator) {
                errorHandler1.show();
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');

            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            }
        });

    };

    return {
        //main function to initiate template pages
        init: function () {
            runValidatorHolidayConfig();
        }
    };
}();

function deleteconfig(id) {
    var path_root = $("#path_root").val();
    document.location.href = path_root + 'admin/configuration/holidays_settings/' + id + '/delete';
}

function getFormattedDate() {
    var date = new Date();
    var str = date.getFullYear() + "-" + getFormattedPartTime(date.getMonth() + 1) + "-" + getFormattedPartTime(date.getDate());
    return str;
}

function getFormattedPartTime(partTime) {
    if (partTime < 10)
        return "0" + partTime;
    return partTime;
}

function trim(a) {
    return a.replace(/^\s+|\s+$/, '');
}

function disable_next2() {
    $('#holiday').attr('disabled', true);
}

function enable_next2() {
    $('#holiday').attr('disabled', false);
}

$(document).ready(function () {
    var datepicker_options = {
        format: 'Y-m-d',
        readonly_element: false,
        default_position: 'below',
        icon_position: 'left',
        offset: [-28, 28],
        onSelect: function () {
            $(this).change();
        }
    };
    $('.date-picker-custom').Zebra_DatePicker(datepicker_options);
    var path_temp = $('#path_temp').val();
    var path_root = $('#path_root').val();
    var d = new Date();
    var newdate = getFormattedDate();
    $("#week_date2").on('change', function () {
        disable_next2();
        var error = 0;
        if ($("#week_date2").val() == '') {
            error = 1;

            $("#checkmsg").fadeTo(1000, 0.1, function () //start fading the messagebox

            {
                var msg;
                msg = $("#validate_msg72").html();

                //add message and change the class of the box and start fading

                $(this).removeClass();

                $(this).addClass('messageboxerror');

                $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(1000, 1);

                disable_next2();

            });
        }
        if (error != 1) {
            var date_availability = path_root + "admin/configuration/ajax_is_date_available";
            var msg = $("#validate_msg27").html();
            //remove all the class add the messagebox classes and start fading

            $("#checkmsg").removeClass();

            $("#checkmsg").addClass('messagebox');

            $("#checkmsg").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" /> ' + msg).show().fadeTo(1000, 1);

            $.post(date_availability, { week_date2: $('#week_date2').val() }, function (data) {

                if ($("#week_date2").val() < newdate) {
                    $("#checkmsg").fadeTo(1000, 0.1, function () //start fading the messagebox

                    {
                        var msg;
                        msg = $("#validate_msg10").html();
                        //add message and change the class of the box and start fading

                        $(this).removeClass();

                        $(this).addClass('messageboxerror');
                        
                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" /><span style="color: #a94442">' + msg + '</span>').show().fadeTo(1000, 1);
                        disable_next2();
                    });
                }
                else if (trim(data) == 'no') //if date not avaiable

                {

                    $("#checkmsg").fadeTo(1000, 0.1, function () //start fading the messagebox

                    {
                        var msg;
                        msg = $("#validate_msg28").html();
                        //add message and change the class of the box and start fading

                        $(this).removeClass();

                        $(this).addClass('messageboxerror');

                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(1000, 1);
                        disable_next2();
                    });

                }

                else {
                    $("#checkmsg").fadeTo(1000, 0.1, function ()  //start fading the messagebox

                    {
                        var msg = $("#validate_msg5").html();
                        $(this).removeClass();
                        $(this).addClass('messageboxok');
                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg).show().fadeTo(1000, 1);
                        enable_next2();
                        $(this).closest('.form-group').removeClass('has-error').addClass('ok');
                    });

                }

            });


        }

    });

});