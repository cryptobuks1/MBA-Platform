$(function() {
    ValidateUser.init();
    defaultAddressClick();
    addres_lenght = $('.payment-wizard li #pricing_table_example1 .pricing-table').length;
    if (addres_lenght <= 0) {
        $('#pricing_table_example1').parent().find('.btn-success.done').prop('disabled', true);
    }
    $('#address_div').hide();
    if ($(".addr:visible").length <= 0) {
        $('#continue_address').attr('disabled', true);
    }
    $('body').on('click', '.payment-wizard li.completed .wizard-heading', function() {
        var me = $(this).parent();
        me.addClass('active').find('.wizard-content').slideDown().parent().siblings('li').removeClass('active').find('.wizard-content').slideUp();
    });

    if ($('#address_count').val() > 0) {
        $('#continue_address').prop('disabled', false)
    } else {
        $('#continue_address').prop('disabled', true)
    }
    $('.qntty').each(function() {
        var oldVal = null;
        var element = $(this);
        element.bind("keydown keyup", function(e) {
            if (e.which != 8 && e.which != 0 && !((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105))) {
                //display error message
                $(element.closest('.form-group').find('span')).html($('#digits_only').text()).show().fadeOut(1200, 0);
                return false;
            }
            if (Number(element.val()) > Number(element.attr('max')) &&
                element.keyCode != 46 // delete
                &&
                element.keyCode != 8 // backspace
            ) {
                e.preventDefault();
                //$(element.closest(".form-group").nextAll('span:first')).html($('#digits_only').text()).show().fadeOut(1200, 0);
                element.val(oldVal);
            } else {
                oldVal = Number(element.val());
            }
        });
    });

    $("#add_address_button").on('click', function() {
        if (!$('#add_address').valid()) {
            return;
        }

        var inf_token = $('input[name="inf_token"]').val();
        var phone_no = $(this).closest("form").find("input[id='phone']").val();
        var name = $(this).closest("form").find("input[id='full_name']").val();
        var address = $(this).closest("form").find("textarea[id='address']").val();
        var pinno = $(this).closest("form").find("input[id='pin_no']").val();
        var city = $(this).closest("form").find("input[id='city']").val();
        var default_id = $('#default_address_id').val();

        $.ajax({
            type: "POST",
            url: BASE_URL + "repurchase/add_checkout_address",
            data: {
                "inf_token": inf_token,
                "phone": phone_no,
                "full_name": name,
                "address": address,
                "pin_no": pinno,
                "city": city
            },
            dataType: 'json',
            beforeSend: function() {
                $('#add-new-address').find('.alert').remove();
                $('#add-new-address input,textarea').next('span.help-block').remove();
                $('#add_address_button').attr('disabled', true);
            },
            success: function(data) {
                if (!data['error']) {
                    data = data['address_id'];
                    id = 'address_' + data;
                    $('#continue_address').prop('disabled', false);
                    $('#add-new-address').modal('toggle');
                    $('#add-new-address').find("input,textarea,select").val('').end();
                    $('#add_address_button').attr('disabled', false);
                    var address_div = $('#address_div').contents().clone();
                    address_div.attr('id', id);
                    address_div.find('.name .text').text(name);
                    address_div.find('.address_details1').text(address);
                    address_div.find('.address_details2').text(city);
                    address_div.find('.address_details3').text(pinno);
                    address_div.find('.phone_no_field').html(phone_no);
                    address_div.find('#default_field').val(data);
                    address_div.find('.name > a').attr("href", "javascript:delete_addres(" + data + ")");
                    address_div.appendTo("#pricing_table_example1");
                    $(address_div).find('.make_default').attr('disabled', true);
                    $('.make_default').not($(address_div).find('.make_default')).attr('disabled', false);
                    $(address_div).show();
                    defaultAddressClick();
                } else {
                    $('#add_address_button').attr('disabled', false);
                    $('#alert_div').contents().clone().addClass('alert-danger').append(data['message']).prependTo('#add-new-address .modal-body');
                    if (data['form_error']) {
                        $.each(data['form_error'], function(i, v) {
                            if (v) {
                                var error_span = '<span class="help-block text-danger" for="' + i + '">' + v + '</span>';
                                $('#' + i).after(error_span);
                            }
                        });
                    } else {

                    }
                }
            },
            error: function(data) {
                $('#add_address_button').attr('disabled', false);

            },
        });
    });

});

function defaultAddressClick() {
    $('.make_default').on('click', function() {
        user_name = $('#logged_user_name').val();
        var me = $(this);
        $.ajax({
            url: BASE_URL + 'repurchase/change_default_address',
            type: 'POST',
            data: { addres_id: me.val(), user_name: user_name },
            beforeSend: function() {
                me.closest('.payment-wizard li.active').find('.btn-success.done').prop('disabled', true);
            },
            complete: function() {
                me.closest('.payment-wizard li.active').find('.btn-success.done').prop('disabled', false);
            },
            success: function(data) {
                if (data == 1) {
                    $(function() {
                        $(".make_default").attr("disabled", false);
                    });
                    me.prop('disabled', true);
                    me.closest('.payment-wizard li.active').find('.btn-success.done').prop('disabled', false);
                } else {
                    me.closest('.payment-wizard li.active').find('.btn-success.done').prop('disabled', true);
                }

            }
        });
    });
}

$(window).load(function() {
    $(".done").click(function() {
        var this_li_ind = $(this).parent().parent("li").index();
        if ($('.payment-wizard li').hasClass("jump-here")) {
            $(this).parent().parent("li").removeClass("active").addClass("completed");
            $(this).parent(".wizard-content").slideUp();
            $('.payment-wizard li.jump-here').removeClass("jump-here");
        } else {
            $(this).parent().parent("li").removeClass("active").addClass("completed");
            $(this).parent(".wizard-content").slideUp();
            $(this).parent().parent("li").next("li").addClass('active').children('.wizard-content').slideDown();
        }
    });
});

function delete_addres(product_id) {
    id = '#address_' + product_id;

    $.ajax({
        type: "POST",
        url: BASE_URL + "repurchase/removeAdress",
        data: { "product_id": product_id },
        dataType: 'text',
        success: function(data) {
            $(id).remove();
            if ($('.addr:visible').length <= 0) {
                $('#continue_address').attr('disabled', true);
            }
        },
        error: function(data) {
            window.location.reload();
            console.log(data);
        }
    });
}

//Purchase Wallet
$('#uname_pwallet').blur(function() {
    var ewallet_username = $('#uname_pwallet').val();
    var ewallet_password = $('#tran_pass_pwallet').val();
    if (ewallet_username != "" && ewallet_password != "") {
        validate_pwallet();
    }
});

$('#tran_pass_pwallet').blur(function() {
    var ewallet_username = $('#uname_pwallet').val();
    var ewallet_password = $('#tran_pass_pwallet').val();
    if (ewallet_username != "" && ewallet_password != "") {
        validate_pwallet();
    }
});

function disable_pwallet()
{
    $("input.sw-btn-finish").attr("disabled", true);
    // document.form.ewallet_submit.disabled = true;
}

function validate_pwallet() {
    
    var path_temp = document.form.path_temp.value;
    var path_root = document.form.path_root.value;
    var ewallet_username = $('#uname_pwallet').val();
    var ewallet_password = $('#tran_pass_pwallet').val();
    var sponsor_user_name = $('#sponsor_user_name').val();
    var product_id = $('#product_id').val();
    var mode_of_operation = $('#ewallet_cheking_type').val();
    var upgrade_user_name = $('#upgrade_user_name').val();

    disable_pwallet();

    if (ewallet_username == "" || ewallet_password == "") {

        $("#tran_pass_pwallet_box").fadeTo("fast", 1, function() //start fading the messagebox
        {
            var msg37 = $("#validate_msg61").html();
            $(this).removeClass();
            $(this).addClass('messageboxerror');
            $(this).html('<i style="color: red;" class="fa fa-times-circle"></i>' + msg37).show().fadeTo("fast", 1);
            disable_pwallet();
        });
    } else {
        var repruchase_amount = 0;        
        repruchase_amount = $("#total_amount").val();
        var ewallet_available = path_root + "/repurchase/check_pwallet_balance";
        
        var msg = $("#validate_msg60").html();
        $("#tran_pass_pwallet_box").removeClass();
        $("#tran_pass_pwallet_box").addClass('messagebox');
        $("#tran_pass_pwallet_box").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" /> ' + msg).show().fadeTo("fast", 1);

        $.post(ewallet_available, {
            user_name: ewallet_username,
            ewallet: ewallet_password,
            product_id: product_id,
            repruchase_amount: repruchase_amount,
            sponsor_username: sponsor_user_name,
            upgrade_username: upgrade_user_name,

        }, function(data) {
            if (data == "yes") {
                $("#tran_pass_pwallet_box").fadeTo("fast", 1, function()
                {
                    var msg39 = $("#validate_msg62").html();
                    $(this).removeClass();
                    $(this).addClass('messageboxok');
                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg39).show().fadeTo("fast", 1);
                    document.getElementById("pwallet_btn").style.display = "none";
                    enable_ewallet();
                });
            } else if (data == "invalid") {
                $("#tran_pass_pwallet_box").fadeTo("fast", 1, function() {
                    var msg37 = $("#validate_msg61").html();
                    $(this).removeClass();
                    $(this).addClass('messageboxerror');
                    $(this).html('<i style="color: red;" class="fa fa-times-circle"></i>' + msg37).show().fadeTo("fast", 1);
                    disable_pwallet();
                });
            } else {
                $("#tran_pass_pwallet_box").fadeTo("fast", 1, function() {
                    var msg37 = $("#validate_msg50").html();
                    $(this).removeClass();
                    $(this).addClass('messageboxerror');
                    $(this).html('<i style="color: red;" class="fa fa-times-circle"></i>' + msg37).show().fadeTo("fast", 1);
                    disable_pwallet();
                });
            }
        });
    }
}