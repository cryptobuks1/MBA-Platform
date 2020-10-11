var ValidateUser = function() {
    var runValidatorweeklySelection = function() {

        var msg1 = $("#error_msg1").html();
        var msg2 = $("#error_msg2").html();
        var msg3 = $("#error_msg3").html();
        var msg4 = $("#error_msg4").html();
        var msg5 = $("#error_msg5").html();
        var msg6 = $("#error_msg6").html();
        var msg7 = $("#error_msg7").html();
        var msg8 = $("#error_msg8").html();
        var msg_alpha_spec = $("#error_alpha_spec").html();
        var msg_alpha_city = $("#error_alpha_city").html();

        $.validator.addMethod("alpha_spec", function(value, element) {
            return this.optional(element) || value == value.match(/^[a-zA-Z ]+$/);
        }, msg_alpha_spec);
        $.validator.addMethod("alpha_city", function(value, element) {
            return this.optional(element) || value == value.match(/^[a-zA-Z0-9\s\.\,]+$/);
        }, msg_alpha_city);

        var searchform = $('#add_address');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#add_address').validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorId: 'shipping',
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            },
            ignore: ':hidden',
            rules: {
                full_name: {
                    required: true,
                    alpha_spec: true,
                    minlength: 3,
                    maxlength: 32
                },
                address: {
                    required: true,
                    minlength: 5,
                    maxlength: 32
                },
                pin_no: {
                    required: true,
                    digits: true,
                    minlength: 3,
                    maxlength: 6
                },
                city: {
                    required: true,
                    alpha_city: true,
                    minlength: 2,
                    maxlength: 32
                },
                phone: {
                    required: true,
                    digits: true,
                    minlength: 5,
                    maxlength: 10
                }

            },
            messages: {
                full_name: {
                    required: msg1,
                    alpha_spec: msg_alpha_spec
                },
                address: {
                    required: msg2
                },
                pin_no: {
                    required: msg3,
                    digit: msg4
                },
                city: {
                    required: msg5,
                    alpha_city: msg_alpha_city
                },
                phone: {
                    digit: msg7,
                    required: msg6,
                    maxlength: msg8
                }

            },
            invalidHandler: function(event, validator) {
                errorHandler1.show();
            },
            highlight: function(element) {

                $(element).closest('.help-block').removeClass('valid');
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');

            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');

            },
            success: function(label, element) {

                label.addClass('help-block valid');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            }
        });
    };

    var runValidatorProductAdding = function() {
        var msg1 = $("#error_msg1").html();
        var msg2 = $("#error_msg2").html();
        var msg3 = $("#error_msg3").html();
        var msg4 = $("#error_msg4").html();

        var searchform = $('#request');
        var errorHandler1 = $('.errorHandler', searchform);


        $('#request').validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorId: 'cart',
            errorPlacement: function(error, element) {
                if ($(element).parent('.input-group').length === 0) {
                    error.insertAfter(element);
                } else {
                    error.insertAfter($(element).closest('.input-group'));
                }
            },
            ignore: ':hidden',
            rules: {
                product_qty: {
                    minlength: 1,
                    required: true,
                    number: true,
                    digits: true,
                    min: 1,
                    max: 100
                }

            },
            messages: {
                product_qty: {
                    required: msg1,
                    min: msg2,
                    number: msg3,
                    digits: msg4
                }

            },
            invalidHandler: function(event, validator) {
                errorHandler1.show();
            },
            highlight: function(element) {

                $(element).closest('.help-block').removeClass('valid');
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');

            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');

            },
            success: function(label, element) {

                label.addClass('help-block valid');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            }
        });
    };
    var runValidatorReportDate = function() {
        var msg1 = $("#error_msg1").html();
        var msg2 = $("#error_msg2").html();
        var msg4 = $("#error_msg3").html();
        var msg3 = $("#error_msg10").html();
        var searchform = $('#repurchase_report');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#repurchase_report').validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            ignore: ':hidden',
            rules: {
                week_date1: {
                    required: true,
                    minlength: 1,
                    date: true
                },
                week_date2: {
                    required: true,
                    minlength: 1,
                    to_date_greaterthan_from_date: true,
                    date: true
                }
            },
            messages: {
                week_date1: {
                    required: msg1,
                    date: msg3
                },
                week_date2: {
                    required: msg2,
                    to_date_greaterthan_from_date: msg4,
                    date: msg3
                }

            },
            invalidHandler: function(event, validator) {
                errorHandler1.show();
            },
            highlight: function(element) {

                $(element).closest('.help-block').removeClass('valid');
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');

            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');

            },
            success: function(label, element) {

                label.addClass('help-block valid');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            }
        });
        jQuery.validator.addMethod('to_date_greaterthan_from_date', function(ToDate) {
            if ($("#week_date1").val() && $("#week_date2").val()) {
                var FromDate = $("#week_date1").val();
                return (ToDate >= FromDate);
            }
        }, "");
    };
    var runValidatorEwallet = function() {

        var msg1 = $("#validate_msg72").html();
        var msg2 = $("#validate_msg73").html();
        var msg3 = $("#err_qnt").html();
        var msg4 = $("#digits_only").html();

        var searchform = $('#form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#form').validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorId: 'shipping',
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            },
            ignore: ':hidden',
            rules: {
                user_name_ewallet: {
                    required: true,
                    // minlength: 3,
                    // maxlength: 32
                },
                tran_pass_ewallet: {
                    required: true,
                    // minlength: 5,
                    // maxlength: 32
                }
            },
            messages: {
                user_name_ewallet: {
                    required: msg1
                },
                tran_pass_ewallet: {
                    required: msg2
                }
            },
            invalidHandler: function(event, validator) {
                errorHandler1.show();
            },
            highlight: function(element) {

                $(element).closest('.help-block').removeClass('valid');
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');

            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');

            },
            success: function(label, element) {

                label.addClass('help-block valid');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            },
            submitHandler: function(form) {
                $("#tran_pass_ewallet").val(encodeURIComponent(window.btoa($("#tran_pass_ewallet").val())));
                event.preventDefault();
                form.submit();
            }
        });
        $('.quantity').each(function() {
            $(this).rules('add', {
                required: true,
                digits: true,
                minlength: 1,
                maxlength: 100,
                messages: {
                    required: msg3,
                    digits: msg4
                }
            });
        });
    };
    return {
        init: function() {
            runValidatorweeklySelection();
            runValidatorProductAdding();
            runValidatorReportDate();
            runValidatorEwallet();

        }
    };
}();

function loadEpinBlur() {
    $('#epin_submit,.sw-btn-finish').attr('disabled', true);
}

$(function() {
    ValidateUser.init();
    $('table#p_scents > tbody > tr > td:eq(1) .epin_input').on('blur', function() {
        $('#epin_submit,.sw-btn-finish').attr('disabled', true);
    });

    function invalid_span(i) {
        i = i || false;
        if (i) {
            var id = 'id =repurchase_pin_invalid' + i;
            var invalid_span = '<span ' + id + ' ><i style="color: red;" class="fa fa-times-circle"></i>&nbsp;Invalid E-Pin</span>';
        } else {
            var invalid_span = '<span id="repurchase_pin_invalid"><i style="color: red;" class="fa fa-times-circle"></i>&nbsp;Invalid E-Pin</span>';
        }
        return invalid_span;
    }

    function valid_span(i) {
        i = i || false;
        if (i) {
            var id = 'id =repurchase_pin_valid' + i;
            var valid_span = '<span ' + id + ' ><i style="color: green;" class="fa fa-check-circle"></i>&nbsp;Valid E-Pin</span>';
        } else {
            var valid_span = '<span id="repurchase_pin_valid"><i style="color: green;" class="fa fa-check-circle"></i>&nbsp;Valid E-Pin</span>';
        }
        return valid_span;
    }

    function dupilcate_span(i) {
        i = i || false;
        if (i) {
            var id = 'id =repurchase_pin_invalid' + i;
            var dupilcate_span = '<span ' + id + ' ><i style="color: red;" class="fa fa-times-circle"></i>&nbsp;Duplicate E-Pin</span>';
        } else {
            var dupilcate_span = '<span id="repurchase_pin_invalid"><i style="color: red;" class="fa fa-times-circle"></i>&nbsp;Duplicate E-Pin</span>';
        }
        return dupilcate_span;
    }
    $('#validate_epin_div > input').on('click', function() {
        var status;
        $('table#p_scents > tbody > tr > td:nth-child(2) input').next('span').remove();
        var epin_array = [];
        $('table#p_scents > tbody > tr > td:nth-child(2) input').each(function(i) {
            var epin = this.value;
            epin = epin.trim();
            //epin = epin.toUpperCase();
            var epin_exists = ($.inArray(epin, epin_array) !== -1);
            if (!epin || epin_exists) {
                //$(this).closest('tr').remove();
                status = false;
                $('table#p_scents > tbody > tr:eq(' + i + ')').find('td:nth-child(2) > span').remove();
                $('table#p_scents > tbody > tr:eq(' + i + ')').find('td:nth-child(2) input').after(dupilcate_span(i));
            } else {
                epin_array.push(epin);
            }
        });
        if (!$.isEmptyObject(epin_array)) {
            var total_amount = $('#total_amount').val();
            var upgrade_user_name = $('#upgrade_user_name').val();
            $.ajax({
                async: false,
                url: $('#base_url').val() + getUserType() + '/member/check_epin_validity',
                type: 'POST',
                data: {
                    pin_array: epin_array,
                    repurchase_amount: total_amount,
                    upgrade_user_name: upgrade_user_name
                },
                dataType: 'json',
                success: function(data) {
                    var amount_reached = 0;
                    if (status != false) {
                        status = true;
                    }
                    $.each(data, function(i, v) {
                        if (v.pin == 'nopin') {
                            status = false;
                            $('table#p_scents > tbody > tr:eq(' + i + ')').find('td:nth-child(2) > span').remove();
                            $('table#p_scents > tbody > tr:eq(' + i + ')').find('td:nth-child(2) input').after(invalid_span(i));
                        } else {
                            amount_reached += Number(v.epin_used_amount);
                            $('table#p_scents > tbody > tr:eq(' + i + ')').find('td:nth-child(2) > span').remove();
                            $('table#p_scents > tbody > tr:eq(' + i + ')').find('td:nth-child(2) input').after(valid_span(i));
                            $('table#p_scents > tbody > tr:eq(' + i + ')').find('td:nth-child(3) input').val(v.amount);
                            $('table#p_scents > tbody > tr:eq(' + i + ')').find('td:nth-child(4) input').val(v.balance_amount);
                            $('table#p_scents > tbody > tr:eq(' + i + ')').find('td:nth-child(5) input').val(v.reg_balance_amount);
                            if (v.reg_balance_amount == 0) {
                                $('table#p_scents > tbody > tr:gt(' + i + ')').remove();
                                return false;
                            }
                        }
                    });
                    $('#epin_total_amount').val(amount_reached);
                    if (status && amount_reached == total_amount) {
                        $('#epin_submit,.sw-btn-finish').attr('disabled', false);
                    } else {
                        $('#epin_submit,.sw-btn-finish').attr('disabled', true);
                    }
                    if (amount_reached < total_amount && status) {
                        var epin_row = $('#epin_row > table > tbody').contents().clone();
                        $('table#p_scents > tbody').append(epin_row);
                    }
                }
            });
        }
        var epin_row = $('#epin_row > table > tbody').contents().clone();
        var rows = $('table#p_scents > tbody > tr').length;
        if (rows == 0) {
            $('table#p_scents > tbody').append(epin_row);
        }
        var sl_no = 1;
        $('table#p_scents > tbody > tr').each(function() {
            $(this).find('td:first').text(sl_no);
            sl_no++;
        });
    });

    $('#ewallet_btn').on('click', function() {
        if ($(this.form).valid()) {
            validate_ewallet();
        } else {
            return false;
        }
    });

    $('#upload_reciept').on('click', function() {
        $(this).closest('.panel').prev('.alert').remove();
        var file_data = $('#userfile').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('inf_token', $('input[name="inf_token"]').val());
        $.ajax({
            url: base_url + 'repurchase/upload_payment_reciept',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            type: 'post',
            data: form_data,
            beforeSend: function() {
                $('#upload_reciept').attr('disabled', true);
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
                $('#upload_reciept').attr('disabled', false);
            }
        });
    });
});