var input_group_hide = $('#input_group_hide').val();
var input_group_showed = $.isEmptyObject(input_group_hide.trim());
$(function() {
    ValidateConfiguration.init();
    $(".roi_packs").html("(%)");
    $('#period').on('change', function() {
        if ($(this).val() == "daily") {
            $('#skip_days').show();
        } else {
            $('#skip_days').hide();
        }
    });
  //  $('#sponsor_commission_type').trigger("change");
    $("#period").change();
});
var ValidateConfiguration = function() {

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

    var runValidateConfiguration = function() {
        var msg1 = $("#validate_msg1").html();
        var msg2 = $("#validate_msg2").html();
        var msg3 = $("#validate_msg3").html();
        var msg4 = $("#validate_msg4").html();

        var searchform = $('#roi_settings');
        var errorHandler1 = $('.errorHandler', searchform);

        $('#roi_settings').validate({
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
        $('.roi_pck').each(function() {
            var msg_label = $(this).data('lang');
            $(this).rules('add', {
                required: true,
                number: true,
                min: 0,
                max: 100,
                messages: {
                    required: msg_label,
                }
            });
        });
        $('.roi_days').each(function() {
            var msg_label = $(this).data('lang');
            $(this).rules('add', {
                required: true,
                number: true,
                min: 0,
                messages: {
                    required: msg_label,
                }
            });
        });
    };

    return {
        //main function to initiate template pages
        init: function() {
            runValidateConfiguration();
        }
    };
}();