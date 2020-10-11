/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    $(function()
    { 
        var path_url = $('#base_url').val();
        $("#mode").change(function() 
        {            
            var mode = $("#mode").val();
            $.ajax({
                type : "GET",
                url  : path_url + "/admin/configuration/ajax_bitgo_config/"+ mode,
                dataType: 'json',
                success: function(data) 
                {
                    $("#wallet_id").html(data['wallet_id']);
                    $("#token").html(data['token']);
                    $("#passphrase").html(data['wallet_passphrase']);
                }
            });
        });
    });
    var msg38 = $("#validate_api_key").html();
    var msg39 = $("#validate_api_secret_key").html();
    var msg40 = $("#validate_mode").html();
    var msg41 = $("#validate_live_wallet_name").html();
    var msg42 = $("#validate_live_wallet_password").html();
    var msg43 = $("#validate_test_wallet_name").html();
    var msg44 = $("#validate_test_wallet_password").html();
    var searchform = $('#bitcoin_configuration_form');
    var errorHandler1 = $('.errorHandler', searchform);
    $('#bitcoin_configuration_form').validate({
        errorElement: "span", 
        errorClass: 'help-block',
        errorId: 'err_config',
        errorPlacement: function (error, element) { 
            if($(element).parent('.input-group').length === 0) {
                error.insertAfter(element);
            }
            else {
                error.insertAfter($(element).closest('.input-group'));
            }
        },
        ignore: ':hidden, .tab-content .tab-pane:not(.active) :input',
        rules: {
            api_key: {
                required: true
            },
            api_secret_key: {
                required: true
            },
            mode: {
                required: true
            },
            live_wallet_name: {
                required: true
            },
            live_wallet_password: {
                required: true
            },
            test_wallet_name: {
                required: true
            },
            test_wallet_password: {
                required: true
            },
        },
        messages: {
            api_key: {
                required: msg38
            },
            api_secret_key: {
                required: msg39
            },
            live_wallet_name: {
                required: msg41
            },
            live_wallet_password: {
                required: msg42
            },
            test_wallet_name: {
                required: msg43
            },
            test_wallet_password: {
                required: msg44
            },
            mode: {
                required: msg40
            },
        },
        invalidHandler: function (event, validator) { 
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
    });
    var msg45 = $("#xpub_required").html();
    var msg46 = $("#api_key_required").html();
    var msg47 = $("#secret_required").html();
    var msg48 = $("#main_password_required").html();
    var msg49 = $("#second_password_required").html();
    var msg50 = $("#fee_required").html();
    var searchform = $('#blockchain_configuration_form');
    var errorHandler1 = $('.errorHandler', searchform);
    $('#blockchain_configuration_form').validate({
        errorElement: "span", 
        errorClass: 'help-block',
        errorId: 'err_config',
        errorPlacement: function (error, element) { 
            if($(element).parent('.input-group').length === 0) {
                error.insertAfter(element);
            }
            else {
                error.insertAfter($(element).closest('.input-group'));
            }
        },
        ignore: ':hidden, .tab-content .tab-pane:not(.active) :input',
        rules: {
            my_api_key: {
                required: true
            },
            main_password: {
                required: true
            },
            second_password: {
                required: true
            },
            secret: {
                required: true
            },
            fee: {
                required: true
            },
            my_xpub: {
                required: true
            },
        },
        messages: {
            my_api_key: {
                required: msg46
            },
            main_password: {
                required: msg48
            },
            second_password: {
                required: msg49
            },
            secret: {
                required: msg47
            },
            fee: {
                required: msg50
            },
            my_xpub: {
                required: msg45
            },
        },
        invalidHandler: function (event, validator) { 
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
    });
    var msg51 = $("#validate_msg1").html();
    var msg52 = $("#validate_msg2").html();
    var searchform = $('#authorize_status_form');
    var errorHandler1 = $('.errorHandler', searchform);
    $('#authorize_status_form').validate({
        errorElement: "span", 
        errorClass: 'help-block',
        errorId: 'err_config',
        errorPlacement: function (error, element) { 
            if($(element).parent('.input-group').length === 0) {
                error.insertAfter(element);
            }
            else {
                error.insertAfter($(element).closest('.input-group'));
            }
        },
        ignore: ':hidden, .tab-content .tab-pane:not(.active) :input',
        rules: {
            transaction_key: {
                required: true
            },
            merchant_log_id: {
                required: true
            },
        },
        messages: {
            transaction_key: {
                required: msg52
            },
            merchant_log_id: {
                required: msg51
            },
        },
        invalidHandler: function (event, validator) { 
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
    });
    
    var msg60 = $("#validate_msg1").html();
    var msg61 = $("#validate_msg2").html();
    var msg62 = $("#validate_msg3").html();
    var searchform = $('#sofort_status_form');
    var errorHandler1 = $('.errorHandler', searchform);
    $('#sofort_status_form').validate({
        errorElement: "span", 
        errorClass: 'help-block',
        errorId: 'err_config',
        errorPlacement: function (error, element) { 
            if($(element).parent('.input-group').length === 0) {
                error.insertAfter(element);
            }
            else {
                error.insertAfter($(element).closest('.input-group'));
            }
        },
        ignore: ':hidden, .tab-content .tab-pane:not(.active) :input',
        rules: {
            project_id: {
                required: true
            },
            customer_id: {
                required: true
            },
            project_pass: {
                required: true
            }
        },
        messages: {
            project_id: {
                required: msg60
            },
            customer_id: {
                required: msg61
            },
            project_pass: {
                required: msg62
            }
        },
        invalidHandler: function (event, validator) { 
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
    });
    
    var msg70 = $("#validate_msg1").html();
    var msg71 = $("#validate_msg2").html();
    var msg72 = $("#validate_msg3").html();
    var searchform = $('#squareup_status_form');
    var errorHandler1 = $('.errorHandler', searchform);
    $('#squareup_status_form').validate({
        errorElement: "span", 
        errorClass: 'help-block',
        errorId: 'err_config',
        errorPlacement: function (error, element) { 
            if($(element).parent('.input-group').length === 0) {
                error.insertAfter(element);
            }
            else {
                error.insertAfter($(element).closest('.input-group'));
            }
        },
        ignore: ':hidden, .tab-content .tab-pane:not(.active) :input',
        rules: {
            access_token: {
                required: true
            },
            application_id: {
                required: true
            },
            location_id: {
                required: true
            }
        },
        messages: {
            access_token: {
                required: msg70
            },
            application_id: {
                required: msg72
            },
            location_id: {
                required: msg71
            }
        },
        invalidHandler: function (event, validator) { 
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
    });

