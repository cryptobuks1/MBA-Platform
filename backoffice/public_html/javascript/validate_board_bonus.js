$(function () {
	ValidateConfiguration.init();
});

var ValidateConfiguration = function () {
    var runValidateConfiguration = function () {
    	var msg37 = $("#you_must_enter").html();
        var board1_commission = $("#board1_commission").html();
        var table1_commission = $("#table1_commission").html();

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

        $('.board_comm').each(function () {
            var level = $(this).data('level');
            var label = board1_commission.replace('%s', level);
            var msg_required = msg37 + ' ' + label;
            $(this).rules('add', {
                required: true,
                maxlength: 5,
                digits: true,
                messages: {
                    required: msg_required,
                    maxlength: $("#max_5").html()
                }
            });
        });

        $('.table_comm').each(function () {
            var level = $(this).data('level');
            var label = table1_commission.replace('%s', level);
            var msg_required = msg37 + ' ' + label;
            $(this).rules('add', {
                required: true,
                maxlength: 5,
                digits: true,
                messages: {
                    required: msg_required,
                    maxlength: $("#max_5").html()
                }
            });
        });
    };

    return {
        init: function () {
            runValidateConfiguration();
        }
    };
}();