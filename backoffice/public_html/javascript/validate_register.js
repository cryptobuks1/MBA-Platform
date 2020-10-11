function changeActiveTab(tab) {
    var demo_status = $("#demo_status").val();
    $('.sw-btn-finish').prop('disabled', false);
    if (tab == 'epin_tab' || tab == 'ewallet_tab' || tab == 'bank_transfer' || (tab == 'blockchain_tab' && demo_status == 'yes') || (tab == 'sofort_tab' && demo_status == 'yes') || (tab == 'payeer_tab' && demo_status == 'yes') || tab == 'purchase_wallet_tab' || (tab == 'bitcoin_tab' && demo_status == 'yes')) {
        $('.sw-btn-finish').prop('disabled', true);
    }
    document.getElementById("active_tab").value = tab;
}

$('#myTab3 a').click(function(e) {
    e.preventDefault();
    $('#myTab a:first').tab('show')
});

function addNewraw() {
    var scntDiv = $('#p_scents');
    var j = $('#epin_count').val();
    $('<tr id = "epin_raw' + j + '" ><td class="center">' + j + '</td> <td  class="center"><div class=""><input type="text" id="epin' + j + '" size="13" name="epin' + j + '" value="" placeholder="PIN"  autocomplete="off" class="form-control" onblur="check_epin_submit();"/></div><span id ="pin_box_' + j + '"> </span> </td><td class="center"><div class=""><input type="text" id="pin_amount' + j + '" size="13" readonly="true" class="form-control"/></div></td><td class="center"><div class=""><input type="text" id="remaining_amount' + j + '" size="13" readonly="true" class="form-control"/></div></td><div class=""><td class="center"><div class=""><input type="text" id="balance_amount' + j + '" size="13" readonly="true" class="form-control"/></div></div></td></tr>').appendTo(scntDiv);
    j++;
    return false;
}

function removeRaw(i) {
    var epin_id = "#epin_raw" + i;
    $(epin_id).remove();
}

function addFinishButn() {
    var finButtDiv = $('#finButtn');
    $(' <div class="col-sm-2 col-sm-offset-8"><button  tabindex="48" class="btn btn-blue btn-block" id ="pin_ok" name= "pin_ok"   style="float: right;" >Finish <i class="fa fa-arrow-circle-right"></i></button ></div></div>').appendTo(finButtDiv);

    return true;
}

function validate_page() {
    ValidateUser.init();
}

function check_epin_submit() {
    document.getElementById("pin_btn").disabled = false;
    // document.getElementById("epin_submit").disabled = true;
}

function disable_ewallet() {
    $("input.sw-btn-finish").attr("disabled", true);
    // document.form.ewallet_submit.disabled = true;
}

function enable_ewallet() {
    $('.sw-btn-finish').prop('disabled', false);
    // document.form.ewallet_submit.disabled = false;
    $('#ewallet_submit').prop('disabled', false);
}

function disable_bank_transfer() {
    $('.sw-btn-finish').prop('disabled', true);
}

function enable_bank_transfer() {
    $('.sw-btn-finish').prop('disabled', false);
}

$('#user_name_ewallet').blur(function() {
    var ewallet_username = $('#user_name_ewallet').val();
    var ewallet_password = $('#tran_pass_ewallet').val();
    if (ewallet_username != "" && ewallet_password != "") {
        validate_ewallet();
    }
});

$('#tran_pass_ewallet').blur(function() {
    var ewallet_username = $('#user_name_ewallet').val();
    var ewallet_password = $('#tran_pass_ewallet').val();
    if (ewallet_username != "" && ewallet_password != "") {
        validate_ewallet();
    }
});

function validate_ewallet() {

    var path_temp = document.form.path_temp.value;
    var path_root = document.form.path_root.value;
    var ewallet_username = $('#user_name_ewallet').val();
    var ewallet_password = $('#tran_pass_ewallet').val();
    var sponsor_user_name = $('#sponsor_user_name').val();
    var product_id = $('#product_id').val();
    var mode_of_operation = $('#ewallet_cheking_type').val();
    var upgrade_user_name = $('#upgrade_user_name').val();

    disable_ewallet();

    if (ewallet_username == "" || ewallet_password == "") {

        $("#tran_pass_ewallet_box").fadeTo("fast", 1, function() //start fading the messagebox
            {
                var msg37 = $("#validate_msg61").html();
                $(this).removeClass();
                $(this).addClass('messageboxerror');
                $(this).html('<i style="color: red;" class="fa fa-times-circle"></i>' + msg37).show().fadeTo("fast", 1);
                disable_ewallet();
            });
    } else {
        var repruchase_amount = 0;
        if (mode_of_operation == "register") {
            var ewallet_available = path_root + "register/check_ewallet_balance";
        } else if (mode_of_operation == "repurchase") {
            repruchase_amount = $("#total_amount").val();
            var ewallet_available = path_root + "repurchase/check_ewallet_balance";
        }

        var msg = $("#validate_msg60").html();
        $("#tran_pass_ewallet_box").removeClass();
        $("#tran_pass_ewallet_box").addClass('messagebox');
        $("#tran_pass_ewallet_box").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" /> ' + msg).show().fadeTo("fast", 1);

        $.post(ewallet_available, {
            user_name: ewallet_username,
            ewallet: ewallet_password,
            product_id: product_id,
            repruchase_amount: repruchase_amount,
            sponsor_username: sponsor_user_name,
            upgrade_username: upgrade_user_name,

        }, function(data) {
            if (data == "yes") {
                $("#tran_pass_ewallet_box").fadeTo("fast", 1, function() {
                    var msg39 = $("#validate_msg62").html();
                    $(this).removeClass();
                    $(this).addClass('messageboxok');
                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg39).show().fadeTo("fast", 1);
                    document.getElementById("ewallet_btn").style.display = "none";
                    enable_ewallet();
                });
            } else if (data == "invalid") {
                $("#tran_pass_ewallet_box").fadeTo("fast", 1, function() {
                    var msg37 = $("#validate_msg61").html();
                    $(this).removeClass();
                    $(this).addClass('messageboxerror');
                    $(this).html('<i style="color: red;" class="fa fa-times-circle"></i>' + msg37).show().fadeTo("fast", 1);
                    disable_ewallet();
                });
            } else {
                $("#tran_pass_ewallet_box").fadeTo("fast", 1, function() {
                    var msg37 = $("#validate_msg50").html();
                    $(this).removeClass();
                    $(this).addClass('messageboxerror');
                    $(this).html('<i style="color: red;" class="fa fa-times-circle"></i>' + msg37).show().fadeTo("fast", 1);
                    disable_ewallet();
                });
            }
        });
    }
}

// RECIEPT UPLOAD

$('#edit_profile_image').on('click', function() {
    var uname = document.getElementById("user_name_entry").value;
    document.getElementById("uname").value = uname;
    $('#profile_image').hide();
    $('#upload_profile_image').show();
    $('#cancel_personal_info,#cancel_contact_info,#cancel_bank_info,#cancel_social_info').click();
});

$('#update_profile_image').on('click', function() {
    $(this).closest('.panel').prev('.alert').remove();
    var file_data = $('#userfile').prop('files')[0];
    var uname = document.getElementById("user_name_entry").value;
    var form_data = new FormData();
    form_data.append('file', file_data);
    form_data.append('inf_token', $('input[name="inf_token"]').val());
    form_data.append('user_name', uname);
    $.ajax({
        url: base_url + 'register/upload_payment_reciept',
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        type: 'post',
        data: form_data,
        beforeSend: function() {
            $('#update_profile_image').attr('disabled', true);
        },
        success: function(data) {
            if (data["error"] == true) {
                $('.bank').find('#err_reciept').remove();
                $('#alert_div').contents().clone().addClass('alert-danger').append(data['message']).prependTo('.bank');

            } else if (data['success'] == true) {
                $('.bank').find('#err_reciept').remove();
                $('#alert_div').contents().clone().addClass('alert-success').append(data['message']).prependTo('.bank');
                enable_bank_transfer();
            }
        },
        error: function(data) {
            console.log(data);

        },
        complete: function() {
            $('#update_profile_image').attr('disabled', false);
        }
    });
});

$('#remove_id').on('click', function() {
    $("#userfile").val('');
    $('#img_prev').attr('src', '');
    $('#remove_id').hide();
    var reset_url = base_url + "register/reset_file_type";
    $.post(reset_url, {

    }, function(data) {
        if (data) {
            disable_bank_transfer();
        }
    });
});

$('#userfile').change(function() {
    if ($(this).val()) {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#img_prev').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
        $('#remove_id').show();
    }
});