$(function() {
    ValidatePlanConfiguration.init();
    compensationsConfig();
});
var ValidatePlanConfiguration = function() {

    var runValidatePlanConfiguration = function() {

        var msg34 = $("#depth_ceiling_required").html();
        var msg37 = $("#you_must_enter").html();
        var msg38 = $("#width_ceiling_required").html();
        var board1_name = $("#board1_name").html();
        var board1_width = $("#board1_width").html();
        var board1_depth = $("#board1_depth").html();
        var table_name = $("#table_name").html();
        var table_width = $("#table_width").html();
        var table_depth = $("#table_depth").html();
        var msg17 = $("#validate_msg25").html();
        var msg26 = $("#validate_msg26").html();
        var msg30 = $("#validate_msg30").html();
        var pnt_val = $("#pnt_val").html();
        var pr_val = $("#pr_val").html();
        var fl_lmt = $("#fl_lmt").html();

        var searchform = $('#plan_setting');
        var errorHandler1 = $('.errorHandler', searchform);

        $('#plan_setting').validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorId: 'err_config',
            errorPlacement: function(error, element) {
                if ($(element).parent('.input-group').length === 0) {
                    error.insertAfter(element);
                } else {
                    error.insertAfter($(element).closest('.input-group'));
                }
            },
            ignore: ':hidden, .tab-content .tab-pane:not(.active) :input',
            rules: {

                depth_ceiling: {
                    minlength: 1,
                    digits: true,
                    required: true
                },
                width_ceiling: {
                    minlength: 1,
                    digits: true,
                    required: true
                },
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

                depth_ceiling: msg34,
                width_ceiling: msg38,
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
                var demo_status = $('#demo_status').val();
                if (document.getElementById('cleanup_flag').value == 1 && demo_status == 'yes') {
                    if (confirm($("#update_plan_confirm_msg").html())) {
                        $("#cleanup_flag").val("do_clean");
                        form.submit();
                    }
                } else {
                    form.submit();
                }
            }
        });
        $('.board_name').each(function() {
            var level = $(this).data('level');
            var label = board1_name.replace('%s', level);
            var msg_required = msg37 + ' ' + label;
            $(this).rules('add', {
                required: true,
                maxlength: 15,
                messages: {
                    required: msg_required
                }
            });
        });
        $('.board_width').each(function() {
            var level = $(this).data('level');
            var label = board1_width.replace('%s', level);
            var msg_required = msg37 + ' ' + label;
            $(this).rules('add', {
                required: true,
                maxlength: 1,
                messages: {
                    required: msg_required
                }
            });
        });
        $('.board_depth').each(function() {
            var level = $(this).data('level');
            var label = board1_depth.replace('%s', level);
            var msg_required = msg37 + ' ' + label;
            $(this).rules('add', {
                required: true,
                maxlength: 1,
                messages: {
                    required: msg_required
                }
            });
        });
        $('.table_name').each(function() {
            var level = $(this).data('level');
            var label = table_name.replace('%s', level);
            var msg_required = msg37 + ' ' + label;
            $(this).rules('add', {
                required: true,
                maxlength: 15,
                messages: {
                    required: msg_required
                }
            });
        });
        $('.table_width').each(function() {
            var level = $(this).data('level');
            var label = table_width.replace('%s', level);
            var msg_required = msg37 + ' ' + label;
            $(this).rules('add', {
                required: true,
                maxlength: 1,
                messages: {
                    required: msg_required
                }
            });
        });
        $('.table_depth').each(function() {
            var level = $(this).data('level');
            var label = table_depth.replace('%s', level);
            var msg_required = msg37 + ' ' + label;
            $(this).rules('add', {
                required: true,
                maxlength: 1,
                messages: {
                    required: msg_required
                }
            });
        });
        $('#commission_type').on('change', function() {
            var type = this.value;
            $('.pair-commission').each(function() {
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
        //main function to initiate template pages
        init: function() {
            runValidatePlanConfiguration();
        }
    };
}();

$(document).ready(function() {
    var msg = $("#error_msg3").html();
    var msg1 = $("#validate_msg4").html();
    var msg2 = $("#validate_msg13").html();
    var msg3 = $("#validate_msg12").html();
    var msg4 = $("#validate_msg14").html();

    $("#depth_ceiling").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#errmsg10").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#width_ceiling").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#errmsg12").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });

    $("#sort_order").keypress(function(e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            var msg = $("#validate_msg13").html();
            $("#errmsg1").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });
    var board_count = $("#board_count").val();
    for (var i = 0; i < board_count; i++) {
        $("#board" + i + "_width").keypress(function(e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                $(this).next().html(msg2).show().fadeOut(1200, 0);
                return false;
            }
        });

        $("#board" + i + "_depth").keypress(function(e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                $(this).next().html(msg2).show().fadeOut(1200, 0);
                return false;
            }
        });

        $("#board" + i + "_name").keypress(function(e) {
            var flag = /[a-z0-9 ]/i.test(
                String.fromCharCode(e.charCode || e.keyCode)
            ) || !e.charCode && e.keyCode < 48;
            if (!flag) {
                $(this).next().html(msg4).show().fadeOut(1200, 0);
                return false;
            }
        });
    }
});

function changeBoardVisibility(status, num) {
    var board_count = $("#board_count").val();
    if (status == 'no') {
        for (var i = num + 1; i < board_count; i++) {
            document.getElementById('board' + i).style.display = "none";
        }
    } else {
        num += 1;
        document.getElementById('board' + num).style.display = "block";
    }
}

function set_cleanup_flag(current_value, new_value) {
    var cleanup_flag = document.getElementById('cleanup_flag').value;
    if (current_value != new_value && cleanup_flag != 1) {
        $("#cleanup_flag").val("1");
    }
}

function compensationsConfig() {
    var base_url = $('#base_url').val();
    $('.compensations').on('click', function() {
        $(this).closest('table').prev('.alert').remove();
        var bonus_name = $(this).data('name');
        var status = $(this).is(':checked');
        var element = $(this);
        $.ajax({
            'url': base_url + "admin/configuration/update_compensations",
            'type': "POST",
            'data': { bonus_name: bonus_name, status: status },
            'dataType': 'json',
            'beforeSend': function() {

            },
            'success': function(data) {
                if (data.response) {
                    var box = $('#success-box').clone();
                    $(box).css('display', 'block');
                    $(element).closest('table').before(box);
                    setTimeout(function() {
                        location.reload();
                    }, 500)
                } else {
                    $(element).prop('checked', !status);
                    var box = $('#error-box').clone();
                    $(box).css('display', 'block');
                    $(element).closest('table').before(box);
                }
            },
            'error': function(error) {
                $(element).prop('checked', !status);
                var box = $('#error-box').clone();
                $(box).css('display', 'block');
                $(element).closest('table').before(box);
            },
            'complete': function(jqXHR, textStatus) {
                if (textStatus == 'parsererror') {
                    location.reload();
                }
            }
        });
    });
}