function validate_epin(total) {
    var path_temp = document.form.path_temp.value;
    var path_root = document.form.path_root.value;

    var pin_array = new Array();
    var epin_empty_flag = false;
    var epin_duplicate_flag = false;


    $('#p_scents > tbody > tr > td:nth-child(2)').find('input').each(function() {
        var epin_field_id = $(this).attr('id');
        var i = epin_field_id.substring(4);
        var epin_value = $(this).val();
        if (epin_value == "") {
            epin_empty_flag = false;
            epin_value = 'epin';
            document.getElementById("pin_amount" + i).value = 0;
            document.getElementById("balance_amount" + i).value = 0;
            document.getElementById("remaining_amount" + i).value = 0;  
            removeRaw(i);
            if ($("#p_scents > tbody > tr").length == 0){
                $("#p_scents").load(" #p_scents > *");
            }
        } else {
            if (isExistInEPinQue(pin_array, epin_value)) {
                var pass_str = { 'pin': epin_value, 'amount': 0, 'i' : i };
                pin_array.push(pass_str);
            } else {
                epin_duplicate_flag = true;
                $("#pin_box_" + i).fadeTo(2000, 0.1, function() {
                    var msg36 = $("#validate_msg71").html();
                    $(this).removeClass();
                    $(this).addClass('messageboxerror');
                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg36).show().fadeTo(1900, 1);
                    document.getElementById("pin_amount" + i).value = 0;
                    document.getElementById("balance_amount" + i).value = 0;
                    document.getElementById("remaining_amount" + i).value = 0;
                });
            }
        }
    });

    /*var limit = $('#p_scents p').size();
    var epin_field_id = "";
    for (var i = 1; i <= limit; i++)
    {
        epin_field_id = '#epin' + i;
        var epin_value = $(epin_field_id).val();

        if (epin_value == "")
        {
            epin_empty_flag = true;
            $("#pin_box_" + i).fadeTo(2000, 0.1, function()
            {
                var msg36 = $("#validate_msg9").html();
                $(this).removeClass();
                $(this).addClass('messageboxerror');
                $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg36).show().fadeTo(1900, 1);
                document.getElementById("pin_amount" + i).value = 0;
                document.getElementById("balance_amount" + i).value = 0;
                document.getElementById("remaining_amount" + i).value = 0;
            });

        } else {
            if (isExistInEPinQue(pin_array, epin_value)) {
                var pass_str = { 'pin': epin_value, 'amount': 0};
                pin_array.push(pass_str);
            } else {
                epin_duplicate_flag = true;
                $("#pin_box_" + i).fadeTo(2000, 0.1, function()
                {
                    var msg36 = $("#validate_msg71").html();
                    $(this).removeClass();
                    $(this).addClass('messageboxerror');
                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg36).show().fadeTo(1900, 1);
                    document.getElementById("pin_amount" + i).value = 0;
                    document.getElementById("balance_amount" + i).value = 0;
                    document.getElementById("remaining_amount" + i).value = 0;
                });
            }

        }
    }*/

    if (!epin_empty_flag) {
        var epin_available = path_root + "replica/check_epin_validity/";
        var JSON_data = JSON.stringify(pin_array);

        var epin = "";
        var amount = 0;
        var epin_used_amount = 0;
        var balance_amount = 0;
        var reg_balance_amount = 0;
        var total_epin_amount = 0;
        var i = 1;
        var j = 1;
        var product_id = $("#product_id").val();
        var sponsor_name = $("#sponsor_user_name").val();
        $.ajax({
            url: epin_available,
            type: 'POST',
            data: JSON.stringify({
                pin_array: pin_array,
                product_id: product_id,
                sponsor_name: sponsor_name,
                inf_token: $('input[name="inf_token"]').val()
            }),
            dataType: "json",
            contentType: "application/json",
            success: function(data) {
                $.each(data, function(k, v) {
                    i = v.i;
                    epin = v.pin;
                    amount = v.amount;
                    balance_amount = v.balance_amount;
                    reg_balance_amount = v.reg_balance_amount;
                    epin_used_amount = v.epin_used_amount;

                    if (epin == "nopin") {
                        if ($('#total_reg_amount').val() == total_epin_amount) {
                            removeRaw(i);
                        } else {
                            
                            $("#pin_box_" + j++).fadeTo(2000, 0.1, function() {
                                var msg36 = $("#validate_msg9").html();
                                $(this).removeClass();
                                $(this).addClass('messageboxerror');
                                $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg36).show().fadeTo(1900, 1);
                            });
                        }
                    } else {

                        if ($('#total_reg_amount').val() == total_epin_amount) {
                            removeRaw(i);
                        } else {
                            document.getElementById("pin_count").value = i;
                            document.getElementById("epin_count").value = parseFloat(i) + parseFloat(1);
                            document.getElementById("pin_amount" + i).value = amount;
                            document.getElementById("balance_amount" + i).value = reg_balance_amount;
                            document.getElementById("remaining_amount" + i).value = balance_amount;
                            total_epin_amount = parseFloat(total_epin_amount) + parseFloat(epin_used_amount);

                            $("#pin_box_" + j++).fadeTo(2000, 0.1, function() {
                                var msg37 = $("#validate_msg10").html();
                                $(this).removeClass();
                                $(this).addClass('messageboxok');
                                $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg37).show().fadeTo(1900, 1);

                            });
                        }

                    }
                });

                document.getElementById("epin_total_amount").value = total_epin_amount;

                if (epin != 'nopin' && !epin_empty_flag && !epin_duplicate_flag) {
                    if ($('#total_reg_amount').val() > total_epin_amount) {
                        addNewraw();
                    } else {
                        document.getElementById("pin_btn").disabled = true;
                        $('.sw-btn-finish').prop('disabled', false);
                    }
                }
            }
        });
    }

    function isExistInEPinQue(pass_arr, epin_value) {
        var i = 0;
        var j = 1;
        var arr_len = pass_arr.length;
        if (arr_len == 0) {
            j = 1;
        }
        if (arr_len > 0) {
            j = 0;
        }

        for (var i = j; i < arr_len; i++) {
            if (pass_arr[i].pin.toLowerCase() === epin_value.toLowerCase()) {
                return false;
            }
        }
        return true;
    }

}