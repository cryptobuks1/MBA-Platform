var FormWizard = function() {
    var msg = $("#validate_msg14").html();
    var msg1 = $("#validate_msg15").html();
    var msg2 = $("#validate_msg18").html();
    var msg3 = $("#validate_msg12").html();
    var msg4 = $("#validate_msg21").html();
    var msg5 = $("#validate_msg19").html();
    var msg6 = $("#error_msg6").html();
    var msg7 = $("#error_msg7").html();
    var msg8 = $("#validate_msg25").html();
    var msg9 = $("#validate_msg26").html();
    var msg10 = $("#validate_msg13").html();
    var msg11 = $("#validate_msg30").html();
    var msg12 = $("#validate_msg31").html();
    var msg13 = $("#validate_msg32").html();
    var msg14 = $("#validate_msg33").html();
    var msg15 = $("#validate_msg34").html();
    var msg16 = $("#validate_msg35").html();
    var msg17 = $("#validate_msg16").html();
    var msg18 = $("#validate_msg17").html();
    var msg19 = $("#validate_msg36").html();
    var msg20 = $("#validate_msg37").html();
    var msg21 = $("#validate_msg38").html();
    var msg22 = $("#validate_msg39").html();
    var msg23 = $("#validate_msg40").html();
    var msg24 = $("#validate_msg41").html();
    var msg25 = $("#validate_msg42").html();
    var msg26 = $("#validate_msg43").html();
    var msg27 = $("#validate_msg44").html();
    var msg28 = $("#validate_msg45").html();
    var msg29 = $("#validate_msg46").html();
    var msg30 = $("#validate_msg47").html();
    var msg31 = $("#validate_msg48").html();
    var msg32 = $("#validate_msg52").html();
    var msg33 = $("#validate_msg53").html();
    var msg34 = $("#validate_msg23").html();
    var msg35 = $("#validate_msg58").html();
    var msg36 = $("#validate_msg59").html();
    var msg37 = $("#validate_msg8").html();
    var msg38 = $("#validate_msg65").html();
    var msg39 = $("#validate_msg66").html();
    var msg40 = $("#validate_msg67").html();
    var msg41 = $("#validate_msg69").html();
    var msg42 = $("#validate_msg70").html();
    var msg43 = $("#validate_msg73").html();
    var msg44 = $("#validate_msg74").html();
    var msg75 = $("#validate_msg75").html();
    var msg76 = $("#validate_msg76").html();
    var msg78 = $("#validate_msg78").html();
    var msg79 = $("#validate_msg79").html();
    var msg63 = $("#validate_msg63").html();
    var msg80 = $("#validate_msg80").html();
    var msg81 = $("#validate_msg81").html();
    var msg82 = $("#validate_msg82").html();
    var msg83 = $("#validate_msg83").html();
    var msg90 = $("#validate_msg90").html();
    var msg91 = $("#validate_msg91").html();
    var msg92 = $("#validate_msg92").html();
    msg90 = msg90.replace('%s', $('#age_limit').val());


    $.validator.addMethod("alpha_dash", function(value, element) {
        return this.optional(element) || /^[a-z0-9A-Z$@$!%*#?& _~\-!@#\$%\^&\*\(\)?,.:|\\+\\[\]{}''"";`~=]*$/i.test(value);
    }, msg31);

    $.validator.addMethod("alpha_numeric", function(value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z0-9]+$/);
    }, msg35);

    $.validator.addMethod("alpha_city", function(value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z0-9\s\,\-]+$/);
    }, msg78);

    $.validator.addMethod("alpha_address", function(value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z0-9\s\.\,]+$/);
    }, msg79);

    $.validator.addMethod("alpha_password", function(value, element) {
        return this.optional(element) || value == value.match(/^[0-9a-zA-Z\s\r\n@!#\$\^%&*()+=\-\[\]\\\';,\.\/\{\}\|\":<>\?\_\`\~]+$/);
    }, msg80);

    $.validator.addMethod("cardExpiry", function() {
        if ($("#card_expiry_mm").val() != "" && $("#card_expiry_yyyy").val() != "") {
            return true;
        } else {
            return false;
        }
    }, 'Please select a month and year');

    $.validator.addMethod("valid_value", function() {
        var limit = $('#p_scents p').size();
        for (var i = 0; i <= limit; i++) {
            if ($('#epin' + i).val() != "") {
                return true;
            } else {
                return false;
            }
        }
    }, msg33);

    $.validator.addMethod("alpha", function(value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z]+$/);
    }, msg35);

    $.validator.addMethod("alpha_space", function(value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z ]+$/);
    }, msg35);

    $.validator.addMethod("pan_format", function(value, element) {
        return this.optional(element) || value == value.match(/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/);
    }, msg36);

    $.validator.addMethod("valid_age", function(value, element) {
        var dob = $('#dob').val();
        var d = dob.split('-');
        var year = parseInt(d[0]);
        var month = parseInt(d[1]);
        var day = parseInt(d[2]);
        var age_limit = parseInt($('#age_limit').val());
        if (age_limit == 0) {
            return true;
        }
        var res = isAgeMoreThanOrEqualYear(year, age_limit);
        return res;
    });
    var regValidate = function() {
        $('#msform').validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                if (element.prop("type") == "checkbox") {
                    error.insertAfter(element.parent("label"));
                } else {
                    if ($(element).next('span').hasClass('combodate')) {
                        error.insertAfter($(element).parent('.form-date-group'));
                    } else if ($(element).attr('name') == 'day' || $(element).attr('name') == 'month' || $(element).attr('name') == 'year') {
                        error.insertAfter($(element).closest('.form-date-group'));
                    } else {
                        error.insertAfter(element);
                    }
                }
            },
            ignore: ':hidden',
            rules: {
                placement_user_name: {
                    required: true
                },
                placement_full_name: {
                    // required: true
                },
                sponsor_user_name: {
                    required: true
                },
                sponsor_full_name: {
                    // required: true
                },
                position: {
                    required: true
                },
                product_id: {
                    required: true
                },
                user_name_entry: {
                    required: true,
                    minlength: 6,
                    maxlength: 12,
                    alpha_numeric: true
                },
                pswd: {
                    minlength: 6,
                    maxlength: 32,
                    alpha_password: true,
                    required: true
                },
                cpswd: {
                    minlength: 6,
                    maxlength: 32,
                    required: true,
                    alpha_password: true,
                    equalTo: "#pswd"
                },
                first_name: {
                    minlength: 3,
                    maxlength: 32,
                    required: true,
                    alpha_space: true
                },
                last_name: {
                    minlength: 3,
                    maxlength: 32,
                    alpha_space: true
                },
                gender: {
                    required: true
                },
                dob: {
                    required: true,
                    valid_age: true
                        // {
                        //     depends: function (element) {
                        //         return $('#year').is(':visible') && $('#month').is(':visible') && $('#day').is(':visible') && $('#year').valid() && $('#month').valid() && $('#day').valid();
                        //     }
                        // }
                },
                year: {
                    required: true
                },
                month: {
                    required: true
                },
                day: {
                    required: true
                },
                address: {
                    minlength: 3,
                    maxlength: 32,
                    required: true
                },
                address_line2: {
                    minlength: 3,
                    maxlength: 32
                },
                pin: {
                    minlength: 3,
                    maxlength: 10,
                    digits: true
                },
                country: {
                    required: true
                },
                state: {

                },
                email: {
                    required: true,
                    email: true,
                    maxlength: 254
                },
                city: {
                    required: true,
                    minlength: 3,
                    maxlength: 32,
                    alpha_city: true
                },
                land_line: {
                    minlength: 5,
                    maxlength: 10,
                    digits: true
                },
                mobile: {
                    required: true,
                    minlength: 5,
                    maxlength: 10,
                    digits: true
                },
                bank_name: {
                    minlength: 3,
                    maxlength: 32,
                    alpha_space: true
                },
                bank_branch: {
                    minlength: 3,
                    maxlength: 32,
                    alpha_space: true
                },
                bank_acc_no: {
                    minlength: 3,
                    maxlength: 32,
                    alpha_numeric: true
                },
                acct_holder_name: {
                    minlength: 3,
                    maxlength: 32,
                    alpha_space: true
                },
                ifsc: {
                    minlength: 3,
                    maxlength: 32,
                    alpha_numeric: true
                },
                pan_no: {
                    minlength: 3,
                    maxlength: 32,
                    alpha_numeric: true
                },
                agree: {
                    required: true
                },
                card_number: {
                    required: true,
                    digits: true

                },
                total_amount: {
                    required: true,
                    number: true
                },
                pay_type: {
                    required: true
                },
                card_cvn: {
                    required: true,
                    digits: true
                },
                card_expiry_year: {
                    required: true
                },
                card_expiry_month: {
                    required: true
                },
                bill_to_forename: {
                    required: true,
                    alpha_space: true
                },
                bill_to_surname: {
                    required: true,
                    alpha_space: true
                },
                bill_to_email: {
                    required: true,
                    email: true
                },
                bill_to_phone: {
                    digits: true,
                    required: true
                },
                epin: {
                    required: true,
                    valid_value: true
                },
                user_name_ewallet: {
                    required: true
                },
                tran_pass_ewallet: {
                    required: true
                },
                bitcoin_address: {
                    required: true
                }
            },
            messages: {
                placement_user_name: msg37,
                placement_full_name: msg37,
                sponsor_user_name: msg37,
                sponsor_full_name: msg37,
                position: msg34,
                product_id: msg3,
                user_name_entry: {
                    required: msg21,
                    maxlength: msg76,
                    minlength: msg63,
                    alpha_numeric: msg75
                },
                pswd: {
                    required: msg1,
                    minlength: msg17,
                    alpha_password: msg80
                },
                cpswd: {
                    required: msg18,
                    minlength: msg17,
                    equalTo: msg2,
                    alpha_password: msg80
                },
                first_name: {
                    required: msg43,
                    alpha_space: msg91,
                    minlength: msg41
                },
                last_name: {
                    alpha_space: msg91,
                    minlength: msg41
                },
                gender: msg14,
                dob: {
                    required: msg5,
                    valid_age: msg90
                },
                year: {
                    required: msg13
                },
                month: {
                    required: msg12
                },
                day: {
                    required: msg11
                },
                address: {
                    required: msg24,
                    minlength: msg41
                },
                address_line2: {
                    minlength: msg41
                },
                country: msg15,
                email: {
                    required: msg23,
                    email: msg16,
                    maxlength: msg92
                },
                city: {
                    required: msg40,
                    alpha_city: msg78
                },
                mobile: {
                    required: msg8,
                    digits: msg20,
                    minlength: msg42
                },
                bank_name: {
                    alpha_space: msg91
                },
                bank_branch: {
                    alpha_space: msg91
                },
                acct_holder_name: {
                    alpha_space: msg91
                },
                mobile: {
                    digits: msg81
                },
                land_line: {
                    digits: msg81
                },
                bank_acc_no: {
                    alpha_numeric: msg75,
                },
                pan_no: {
                    alpha_numeric: msg75,
                },
                ifsc: {
                    alpha_numeric: msg75,
                },
                agree: msg9,
                card_number: {
                    required: msg25,
                    digits: msg20
                },
                total_amount: {
                    required: msg26,
                    number: msg20
                },
                pay_type: msg32,
                card_cvn: {
                    required: msg27,
                    digits: msg20
                },
                card_expiry_year: msg13,
                card_expiry_month: msg12,
                bill_to_forename: {
                    required: msg29,
                    alpha_space: msg91
                },
                bill_to_surname: {
                    required: msg29,
                    alpha_space: msg91
                },
                bill_to_email: {
                    required: msg23,
                    email: msg16
                },
                bill_to_phone: {
                    required: msg8,
                    digits: msg20,
                    minlength: msg19
                },
                epin: {
                    valid_value: msg33
                },
                pin: {
                    minlength: msg41,
                    digits: msg81
                },
                user_name_ewallet: {
                    required: msg21
                },
                tran_pass_ewallet: {
                    required: msg82
                },
                bitcoin_address: msg83
            },
            highlight: function(element) {
                if ($(element).closest('.combodate').length) {
                    $(element).closest('div').addClass('has-error');
                } else {
                    $(element).closest('.form-group').addClass('has-error');
                }
            },
            unhighlight: function(element) {
                if ($(element).closest('.combodate').length) {
                    $(element).closest('div').removeClass('has-error');
                } else {
                    $(element).closest('.form-group').removeClass('has-error');
                }
            },
            success: function(label) {
                if ($(label).attr('for') == 'dob') {
                    $(label).closest('.has-error').removeClass('has-error');
                }
            }
        });
    };
    regValidate();
}();

$("#msform").submit(function() {
    var pass = $("#pswd").val();
    var cpass = $("#cpswd").val();
    pass = encodeURIComponent(window.btoa(pass));
    cpass = encodeURIComponent(window.btoa(cpass));
    $("#pswd").val(pass);
    $("#cpswd").val(cpass);
    $("#tran_pass_ewallet").val(encodeURIComponent(window.btoa($("#tran_pass_ewallet").val())));
});

function isAgeMoreThanOrEqual(day, month, year, age) {
    return new Date(year + age, month - 1, day) <= new Date();
}

function isAgeMoreThanOrEqualYear(year, age_limit) {
    var d = new Date();
    var current_year = d.getFullYear();
    return (current_year - year) >= age_limit;
}

$(function() {
    var datepicker_options = {
        format: 'Y-m-d',
        readonly_element: true,
        default_position: 'below',
        view: 'years',
        icon_position: 'left',
        offset: [-28, 28],
        onSelect: function() {
            $(this).change();
        }
    };
    $('.date-picker-dob').Zebra_DatePicker(datepicker_options);

    $('#form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });
});