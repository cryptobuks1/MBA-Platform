function trim(a) {
    return a.replace(/^\s+|\s+$/, '');
}

function disable_next1() {
    $('.next').attr('disabled', true);
}

function enable_next1() {
    $('.next').attr('disabled', false);
}
function disable_next2() {
    $('.next2').attr('disabled', true);
}

function enable_next2() {
    $('.next2').attr('disabled', false);
}

function check_step1(a, b, c) {
    if (a == 1 && b == 1 && c == 1) {
        enable_next1();
    } else {
        disable_next1();
    }
}

$(document).ready(function () {
    var path_temp = document.form.path_temp.value;
    var path_root = document.form.path_root.value;
    var product_status = document.form.product_status.value;
    var mlm_plan = document.form.mlm_plan.value;
    var reg_from_tree = document.form.reg_from_tree.value;
    var username_type = document.form.username_type.value;

    var sponsor_ok = 0;
    var position_ok = 0;
    var product_ok = 0;

    if (mlm_plan != "Binary" || reg_from_tree) {
        position_ok = 1;
    }
    if (product_status == "no") {
        product_ok = 1;
    }
    disable_next1();

    $("#sponsor_user_name").blur(function () {
        disable_next1();
        var error = 0;
        var referral_name = $('#sponsor_user_name').val();
        if (referral_name == '') {
            error = 1;
            $("#referral_box").fadeTo(1000, 0.1, function () //start fading the messagebox
            {
                //add message and change the class of the box and start fading
                var msg = $("#validate_msg8").html();
                $(this).removeClass();
                $(this).addClass('messageboxerror');
                $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(1000, 1);
                document.getElementById('referal_div').style.display = "none";
                sponsor_ok = 0;
                check_step1(sponsor_ok, position_ok, product_ok);
            });

            $("#errormsg2").fadeTo(1000, 0.1, function () //start fading the messagebox
            {
                var msg = $("#validate_msg5").html();
                //add message and change the class of the box and start fading
                $(this).removeClass();
                $(this).addClass('messageboxerror');
                $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(1000, 1);
            });

        }

        if (error != 1) {
            var ref_user_availability = path_root + "replica/validate_username";
            var msg = $("#validate_msg7").html();
            $("#referral_box").removeClass();
            $("#referral_box").addClass('messagebox');
            $("#referral_box").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" /> ' + msg).show().fadeTo(1000, 1);

            //check the username exists or not from ajax
            $.post(ref_user_availability, { username: $('#sponsor_user_name').val() }, function (data) {
                if (trim(data) == 'no') //if username not avaiable
                {
                    $("#referral_box").fadeTo(1000, 0.1, function () //start fading the messagebox
                    {
                        //add message and change the class of the box and start fading
                        msg = $("#validate_msg8").html();
                        $(this).removeClass();
                        $(this).addClass('messageboxerror');
                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(1000, 1);
                        document.getElementById('referal_div').style.display = "none";
                        sponsor_ok = 0;
                        check_step1(sponsor_ok, position_ok, product_ok);
                    });
                    $("#errormsg2").fadeTo(1000, 0.1, function () //start fading the messagebox
                    {
                        var msg = $("#validate_msg5").html();
                        //add message and change the class of the box and start fading
                        $(this).removeClass();
                        $(this).addClass('messageboxerror');
                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(1000, 1);

                    });


                } else {
                    $("#referral_box").fadeTo(1000, 0.1, function ()  //start fading the messagebox
                    {
                        //add message and change the class of the box and start fading
                        msg = $("#validate_msg6").html();
                        $(this).removeClass();
                        $(this).addClass('messageboxok');
                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg).show().fadeTo(1000, 1);
                        get_referral_name(referral_name);
                        if ($('#product_id').val() != '') {
                            $("#product_id").trigger("change");
                        }
                        sponsor_ok = 1;
                        check_step1(sponsor_ok, position_ok, product_ok);
                        if (mlm_plan == 'Binary') {
                            if (reg_from_tree == "1") {
                                $('#position').change();
                            } else {
                                $.ajax({
                                    url: $('#base_url').val() + 'replica/get_available_leg',
                                    type: 'GET',
                                    data: {
                                        user_name: $('#sponsor_user_name').val()
                                    },
                                    dataType: 'text',
                                    success: function(data) {
                                        $('#position').empty();
                                        if (data == 'any') {
                                            $('#position').append($('#div_pos').contents().clone());
                                        } else if (data == 'L') {
                                            $('#position').append($('#div_pos').contents('option[value="L"]').clone());
                                        } else if (data == 'R') {
                                            $('#position').append($('#div_pos').contents('option[value="R"]').clone());
                                        }
                                        $('#position').change();
                                    }
                                });
                            }
                        }
                    });

                }
            });
        }
    });

    $("#position").change(function () {
        disable_next1();
        if (mlm_plan == "Binary") {
            var error = 0;
            if ($('#position').val() == '' || $('#sponsor_user_name').val() == '') {
                error = 1;
                $("#errormsg2").fadeTo(1000, 0.1, function () //start fading the messagebox
                {
                    var msg = $("#validate_msg5").html();
                    //add message and change the class of the box and start fading
                    $(this).removeClass();
                    $(this).addClass('messageboxerror');
                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(1000, 1);
                    position_ok = 0;
                    check_step1(sponsor_ok, position_ok, product_ok);
                });
            }

            if (error != 1) {
                var leg_availability = path_root + "replica/check_leg_availability";
                var msg = $("#validate_msg3").html();
                //remove all the class add the messagebox classes and start fading
                $("#errormsg2").removeClass();
                $("#errormsg2").addClass('messagebox');
                $("#errormsg2").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" /> ' + msg).show().fadeTo(1000, 1);
                //check the username exists or not from ajax
                $.post(leg_availability, {
                    sponsor_leg: $('#position').val(),
                    sponsor_user_name: $('#sponsor_user_name').val()
                }, function (data) {
                    if (trim(data) == 'no') //if username not avaiable
                    {
                        $("#errormsg2").fadeTo(1000, 0.1, function () //start fading the messagebox
                        {
                            var msg = $("#validate_msg5").html();
                            //add message and change the class of the box and start fading
                            $(this).removeClass();
                            $(this).addClass('messageboxerror');
                            $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(1000, 1);
                            position_ok = 0;
                            check_step1(sponsor_ok, position_ok, product_ok);
                        });
                    } else {
                        $("#errormsg2").fadeTo(1000, 0.1, function () {
                            var msg = $("#validate_msg4").html();
                            $(this).removeClass();
                            $(this).addClass('messageboxok');
                            $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg).show().fadeTo(1000, 1);
                            position_ok = 1;
                            check_step1(sponsor_ok, position_ok, product_ok);
                        });
                    }
                });
            }
        } else {
            position_ok = 1;
            check_step1(sponsor_ok, position_ok, product_ok);
        }
    });

    $("#product_id").change(function () {
        var currency_symbol_left = $("#DEFAULT_SYMBOL_LEFT").val();
        var currency_symbol_right = $("#DEFAULT_SYMBOL_RIGHT").val();

        if (product_status == "yes") {
            var error = 0;
            if ($('#product_id').val() == '') {
                error = 1;
                $("#error_product").fadeTo(1000, 0.1, function () //start fading the messagebox
                {
                    var msg = "Invalid Product";
                    //add message and change the class of the box and start fading
                    $(this).removeClass();
                    $(this).addClass('messageboxerror');
                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(1000, 1);
                    product_ok = 0;
                    check_step1(sponsor_ok, position_ok, product_ok);
                });
            }

            if (error != 1) {
                $("#error_product").removeClass();
                $("#error_product").html("");

                var product_id = $('#product_id').val();
                var total_reg_fee = path_root + "replica/get_total_registration_fee";
                $.post(total_reg_fee, { product_id: product_id }, function (data) {
                    var split_array = data.split("==");
                    var reg_amount = split_array[0];
                    var product_amount = split_array[1];
                    var total_reg_amount = split_array[2];
                    var default_currency_val = 1;
                    var converted_val = (parseFloat(total_reg_amount / default_currency_val)).toFixed(2);

                    $('span#total_product_amount').html("<b>" + currency_symbol_left + converted_val + currency_symbol_right + "</b>");
                    $('#registration_fee').val(reg_amount);
                    $('#product_amount').val(product_amount);
                    $('#total_reg_amount').val(total_reg_amount);
                    $('#total_product_amount').val(total_reg_amount);
                });
                product_ok = 1;
                check_step1(sponsor_ok, position_ok, product_ok);
            }
        } else {
            product_ok = 1;
            check_step1(sponsor_ok, position_ok, product_ok);
        }
    });

    $("#user_name_entry").blur(function () {
        disable_next2();
        if (!$(this).valid()) {
            $('#errormsg3').hide();
            return false;
        }
        if (username_type == "static") {
            var error = 0;
            if ($("#user_name_entry").val() == '') {
                error = 1;
                $("#errormsg3").fadeTo(1000, 0.1, function () //start fading the messagebox
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
                var length = $('#user_name_entry').val().length;
                if (length >= 6) {
                    var user_name_availability = path_root + "replica/ajax_is_username_available"
                    var msg = $("#validate_msg27").html();
                    //remove all the class add the messagebox classes and start fading
                    $("#errormsg3").removeClass();
                    $("#errormsg3").addClass('messagebox');
                    $("#errormsg3").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" /> ' + msg).show().fadeTo(1000, 1);
                    //check the username exists or not from ajax
                    $.post(user_name_availability, { user_name: $('#user_name_entry').val() }, function (data) {
                        if (trim(data) == 'no') //if username not avaiable
                        {
                            $("#errormsg3").fadeTo(1000, 0.1, function () //start fading the messagebox
                            {
                                var msg;
                                msg = $("#validate_msg28").html();
                                //add message and change the class of the box and start fading
                                $(this).removeClass();
                                $(this).addClass('messageboxerror');
                                $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(1000, 1);
                            });
                        } else {
                            $("#errormsg3").fadeTo(1000, 0.1, function ()  //start fading the messagebox
                            {
                                var msg = $("#validate_msg29").html();
                                $(this).removeClass();
                                $(this).addClass('messageboxok');
                                $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg).show().fadeTo(1000, 1);
                                enable_next2();
                            });
                        }
                    });
                }
                else {
                    $("#errormsg3").fadeTo(1000, 0.1, function ()  //start fading the messagebox
                    {
                        msg = $("#validate_msg63").html();
                        $(this).removeClass();
                        $(this).addClass('messageboxerror');
                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(1000, 1);
                        disable_next2();
                    });
                }
            }
        }
    });

    $("#user_count").keypress(function (e) {
        var regex = new RegExp("^[0-9]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        else {
            return false;
        }
    });

    $("#user_name_entry,#ifsc,#pan_no,#bank_acc_no").keypress(function (e) {
        if (e.which == 0 || e.which == 8) {
            return;
        }
        var regex = new RegExp("^[a-zA-Z0-9]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        else {
            var msg = $("#validate_msg75").html();
            showErrorSpanOnKeyup(this, msg);
            return false;
        }
    });

    $("#first_name,#last_name,#bank_name,#bank_branch,#acct_holder_name").keypress(function (e) {
        if (e.which == 0 || e.which == 8) {
            return;
        }
        var regex = new RegExp("^[a-zA-Z ]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        else {
            var msg = $("#validate_msg91").html();
            showErrorSpanOnKeyup(this, msg);
            return false;
        }
    });

    $("#pin,#mobile,#land_line").keypress(function (e) {
        if (e.which == 0 || e.which == 8) {
            return;
        }
        var regex = new RegExp("^[0-9]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        else {
            var msg = $("#validate_msg37").html();
            showErrorSpanOnKeyup(this, msg);
            return false;
        }
    });

});

function get_referral_name(referral_name) {
    var html;
    var msg = $("#validate_msg68").html();
    var get_referral_name_url = document.form.path_root.value + "replica/get_sponsor_full_name";
    $.post(get_referral_name_url, { sponsor_user_name: referral_name }, function (data) {
        data = trim(data);
        html = "<label for='sponsor_full_name'>" + msg + "</label><input tabindex='2' type='text' name='sponsor_full_name' id='sponsor_full_name' autocomplete='Off' value='" + data + "' readonly='true' class='form-control'/>";
        document.getElementById('referal_div').innerHTML = html;
        document.getElementById('referal_div').style.display = "";
    });
}

function showErrorSpanOnKeyup(element, message) {
    var span = "<span class='keyup_error'>" + message + "</span>";
    $(element).next('span.keyup_error').remove();
    $(element).after(span);
    $(element).next('span:first').fadeOut(2000, 0);
}

