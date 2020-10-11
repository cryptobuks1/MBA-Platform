$(function () {
    var input_group_hide = $('#input_group_hide').val();
    var input_group_showed = $.isEmptyObject(input_group_hide.trim());
    var product_status = $('#product_status').val();
    $('#calculation_criteria').on('change', function () {
        var type = this.value;
        if (type == 'fixed' && product_status == 'no') {
            $('#point_value').closest('.form-group').show();
        } else {
            $('#point_value').closest('.form-group').hide();
        }
    });
    $('#calculation_period').on('change', function () {
        var type = this.value;
        if (type == 'instant') {
            $('#carry_forward').closest('.form-group').hide();
        } else {
            $('#carry_forward').closest('.form-group').show();
        }
        $('#flush_out').change();
    });
    $('#commission_type').on('change', function () {
        var type = this.value;
        if (type == 'flat') {
            $('#pair_value').closest('.form-group').show();
            if (input_group_showed) {
                $('.span_percent').hide();
                $('.pair-commission').parent('.input-group').removeClass('input-group-hide');
            }

        } else {
            $('#pair_value').closest('.form-group').hide();
            if (input_group_showed) {
                $('.span_percent').show();
                $('.pair-commission').parent('.input-group').addClass('input-group-hide');
            }
        }
    });
    $('#flush_out').on('change', function () {
        if (this.checked) {
            $('#flush_out_limit').closest('.form-group').show();
            if ($('#calculation_period').val() == 'instant') {
                $('#flush_out_period').closest('.form-group').show();
            } else {
                $('#flush_out_period').closest('.form-group').hide();
            }
        } else {
            $('#flush_out_limit').closest('.form-group').hide();
            $('#flush_out_period').closest('.form-group').hide();
        }
    });
    ValidateConfiguration.init();
    $('#calculation_criteria,#commission_type,#calculation_period').change();
    $("#pair_value,#point_value,.pair-commission,#flush_out_limit").inputFilter(function (value) {
        return /^\d*[.]?\d*$/.test(value);
    });

});

function findProperty(obj, key) {
    if (typeof obj === "object") {
        if (key in obj) {
            return true;
        } else {
            return false;
        }
    }
    return false;
}

var ValidateConfiguration = function () {
    var runValidateConfiguration = function () {
        var msg17 = $("#validate_msg25").html();
        var msg26 = $("#validate_msg26").html();
        var msg30 = $("#validate_msg30").html();
        var pnt_val = $("#pnt_val").html();
        var pr_val = $("#pr_val").html();
        var fl_lmt = $("#fl_lmt").html();
        var pr_comm = $("#pr_comm").html();

        var searchform = $('#form_setting');
        var errorHandler1 = $('.errorHandler', searchform);

        $('#form_setting').validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorId: 'err_config',
            errorPlacement: function (error, element) {
                if ($(element).parent('.input-group').length === 0) {
                    error.insertAfter(element);
                } else {
                    error.insertAfter($(element).closest('.input-group'));
                }
            },
            ignore: ':hidden',
            rules: {
                point_value: {
                    required: true
                },
                pair_value: {
                    required: true,
                    greaterThanNum: 0
                },
                flush_out_limit: {
                    required: true,
                    greaterThanNum: 0
                }
            },
            messages: {
                point_value: {
                    required: msg26.replace('%s', pnt_val.toLowerCase())
                },
                pair_value: {
                    required: msg26.replace('%s', pr_val.toLowerCase()),
                    greaterThanNum: msg30
                },
                flush_out_limit: {
                    required: msg26.replace('%s', fl_lmt.toLowerCase()),
                    greaterThanNum: msg30
                }
            },
            invalidHandler: function () {
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
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

        $('.pair-commission').each(function () {
            $(this).rules('add', {
                required: true,
                messages: {
                    required: msg26.replace('%s', pr_comm.toLowerCase())
                }
            });
        });

        $('#commission_type').on('change', function () {
            var type = this.value;
            $('.pair-commission').each(function () {
                if (type == 'flat') {
                    var rules = $(this).rules();
                    if (findProperty(rules, 'max')) {
                        $(this).rules('remove', 'max');
                    }
                } else {
                    $(this).rules('add', {
                        max: 100,
                        messages: {
                            max: msg17
                        }
                    });
                }
            });
            if (type == 'flat') {
                $('#flush_out_limit').rules('add', {
                    digits: true,
                    messages: {
                        digits: msg30
                    }
                });
            } else {
                var rules = $('#flush_out_limit').rules();
                if (findProperty(rules, 'digits')) {
                    $('#flush_out_limit').rules('remove', 'digits');
                }
            }
        });
    };

    return {
        init: function () {
            runValidateConfiguration();
        }
    };
}();
