function validate_cards()
{
    $('.alert-warning').remove();
    var is_invalid_pin = 0;
    var text_please_enter_epin = 0;
    var valid_index = 0;
    var invalid_index = 0;
    var pin_amount = 0;
    var valid_codes = new Array();
    var invalid_codes = new Array();
    var limit = $('#p_scents p').size();
    var pass_id = "";
    var pin_no = "";
    var pass_arr = new Array();
    var index = 0;
    var flag = false;

    for (var i = 1; i <= limit; i++)
    {
        pass_id = '#epin' + i;

        var epin_value = $(pass_id).val();
        if(epin_value == '') {
            flag = true;
            $("#reg_details").prepend('<div class="alert alert-warning" id="warning_div">' + $('#text_please_enter_epin').val() + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
        } else if (!isExistInEPinQue(pass_arr, epin_value)) {
            var pass_str = {'pin': epin_value, 'amount': 0};
            pass_arr.push(pass_str);
        }
        else
        {            
            flag = true;
            $("#reg_details").prepend('<div class="alert alert-warning" id="warning_div">' + $('#text_duplicate_epin_entry').val() + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
        }
    }
    if (!flag)
    {
        var pass_available = $('#link_pass_availability').val();
        var status = "";
        var amount = "";
        var toat_amount = 0;
        var i = 1;
        $.ajax({
            url: pass_available,
            type: 'POST',
            data: JSON.stringify({
                pin_array: pass_arr,
                total_amount: $('#input-cart_total').val()
            }),
            dataType: 'json',
            contentType: "application/json",
            success: function(data) {
                if (data['redirect']) {
                    location = data['redirect'];
                }
                $.each(data, function(k, v) {
                    epin = v.pin;
                    amount = v.amount;
                    balance_amount = v.balance_amount;
                    document.getElementById("pin_amount" + i).value = amount;
                    document.getElementById("balance_amount" + i).value = 0;
                    document.getElementById("remaining_amount" + i).value = 0;
                    if (epin == "nopin")
                    {
                        flag = true;
                        document.getElementById("balance_amount" + i).value = 0;
                        document.getElementById("remaining_amount" + i).value = 0;
                        i++; 
                        $("#reg_details").prepend('<div class="alert alert-warning" id="warning_div">' + $('#text_invalid_epin').val() + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                    }
                    else
                    {
                        document.getElementById('epin-submit-btn').style.display = "none";
                        toat_amount += parseFloat(amount);
                        $("#pass_box_" + i).fadeTo(1000, 0.1, function() //start fading the messagebox
                        {
                            //add message and change the class of the box and start fading
                            $('button[name=\'validate\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
                            $(this).html($('#text_epin_validated').val()).show().fadeTo(1900, 1);
                        });
                    
                        var reg_fee = Math.round($('#input-cart_total').val() * 100) / 100;
                        //var reg_fee = document.getElementById("#amount").value;
                        if (toat_amount > $('#input-cart_total').val())
                        {
                            bal_amount = toat_amount - reg_fee;
                            bal_amount = Math.round(bal_amount * 100) / 100;
                            new_amount = toat_amount - bal_amount;
                            new_amount = Math.round(new_amount * 100) / 100;
                            document.getElementById('ecard_amount').innerHTML = new_amount;
                            toat_amount = new_amount;
                            document.getElementById("remaining_amount" + i).value = bal_amount;
                        }
                        req_amount = reg_fee - toat_amount;
                        req_amount = Math.round(req_amount * 100) / 100;
                        document.getElementById("balance_amount" + i).value = req_amount;
                        i++;
                    }
                });
                if(epin != "nopin") {
                    if (epin != "nopin" && flag == false)
                    {
                        if ($('#input-cart_total').val() > toat_amount)
                        {
                            addNewraw();
                        }
                    }
                    document.getElementById('ecard_amount').innerHTML = toat_amount;


                    if (toat_amount == $('#input-cart_total').val())
                    {
                        $("#amountbox").fadeTo(1000, 0.1, function()  //start fading the messagebox
                        {
                            document.getElementById('input-epinno').value = i - 1;
                            document.getElementById('epin-submit-btn').style.display = "block";
                            document.getElementById('validate').style.display = "none";
                        });
                    } else
                    {
                        document.getElementById('epin-submit-btn').style.display = "none";
                        $("#amountbox").fadeTo(200, 0.1, function() //start fading the messagebox
                        {
                            $('button[name=\'validate\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
                            $(this).html($('#text_insufficient_amount').val()).show().fadeTo(1900, 1);
                        });
                    }
                }
            }
        });
    }
}

function isExistInEPinQue(pass_arr, epin_value) {
    var i = 0;
    var j = 1;
    var arr_len = pass_arr.length;
    if (arr_len == 0)
    {
        j = 1;
    }
    if (arr_len > 0)
    {
        j = 0;
    }

    for (var i = j; i < arr_len; i++) {
        if ((pass_arr[i].pin).toLowerCase() === epin_value.toLowerCase()) {
            return true;
        }
    }
    return false;
}

function addNewraw()
{
    var scntDiv = $('#p_scents');
    var j = $('#p_scents p').size() + 1;
    $('<tr   align="center" id = "epin_raw' + j + '" ><td>' + j + '</td> <td><div class="col-md-12"><p><input type="text" id="epin' + j + '" size="13" name="epin' + j + '" value="" autocomplete="off" class="form-control" onblur="hideConfirmButton();" /></p></div><span id ="pin_box_' + j + '"> </span></label></td><td><div class="col-md-12"><input type="text" id="pin_amount' + j + '" size="13" readonly="true" class="form-control"/></div></td><td><div class="col-md-12"><input type="text" id="remaining_amount' + j + '" size="13" readonly="true" class="form-control"/></div></td><div class="col-md-12"><td><div class="col-md-12"><input type="text" id="balance_amount' + j + '" size="13" readonly="true" class="form-control"/></div></div></td></tr>').appendTo(scntDiv);
    j++;
    return false;
}

function hideConfirmButton() {
    $("#amountbox").fadeTo(1000, 0.1, function()  //start fading the messagebox

    {
        document.getElementById('epin-submit-btn').style.display = "none";
        document.getElementById('validate').style.display = "block";

    });    
}


