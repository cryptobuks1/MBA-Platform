$(function () {
    DEFAULT_SYMBOL_LEFT = $('#DEFAULT_SYMBOL_LEFT').val();
    DEFAULT_SYMBOL_RIGHT = $('#DEFAULT_SYMBOL_RIGHT').val();
    DEFAULT_CURRENCY_VALUE = $('#DEFAULT_CURRENCY_VALUE').val();
    PRECISION = $('#PRECISION').val();

    ValidateFund.init();

//    // Step show event 
//    $('.sw-btn-finish').hide();
//    $("#smartwizard").on("showStep", function (e, anchorObject, stepNumber, stepDirection, stepPosition) {
//        if (stepPosition === 'first') {
//            $('.sw-btn-prev').hide();
//            $('.sw-btn-next').show();
//            $('.sw-btn-finish').hide();
//        } else if (stepPosition === 'middle') {
//            $('.sw-btn-prev').show();
//            $('.sw-btn-next').show();
//            $('.sw-btn-finish').hide();
//        } else if (stepPosition === 'final') {
//            $('.sw-btn-prev').show();
//            $('.sw-btn-next').hide();
//            $('.sw-btn-finish').show();
//        }
//
//    });
//
//    $('#fund_form').submit(function () {
//        if ($("#fund_form").valid()) {
//            $('.sw-btn-finish').button('loading');
//        }
//    });
//
//    $("#smartwizard").on("leaveStep", function (e, anchorObject, stepNumber, stepDirection) {
//
//        if (stepDirection === 'forward') {
//            $(".no-display").removeAttr("style").hide();
//            var amt = $('#amount').val();
//            var rcvr = $('#to_user_name').val();
//            var tran_concept = $('#tran_concept').val();
//            $('#transaction_note').val(tran_concept);
//            $('#to_username').val(rcvr);
//            $('#receiver').html(rcvr);
//            $('#amount').val(amt);
//            return $('#fund_form').valid();
//        }
//        return true;
//    });
//
//    // Toolbar extra buttons
//    var btnFinish = $('<button type="submit" id="transfer" name="transfer" value="Submit"></button>').text('Finish').addClass('btn btn-info sw-btn-finish');
//
//    // Smart Wizard
//    $('#smartwizard').smartWizard({
//        selected: 0,
//        theme: 'arrows',
//        transitionEffect: 'fade',
//        showStepURLhash: false,
//        keyNavigation: false,
//        toolbarSettings: {
//            toolbarPosition: 'both',
//            toolbarExtraButtons: [btnFinish]
//        },
//        anchorSettings: {
//            anchorClickable: false, // Enable/Disable anchor navigation
//        },
//    });
//
//    $('.sw-btn-finish').on('click', function () {
//        $(this).closest('form').submit();
//    });
//    $('.sw-btn-cancel').on('click', function () {
//        $(this).closest('form').submit();
//    });
//    $('#amount1').on('blur', function () {
//        var $inputs = $('#step-1 :input');
//        var a = 1;
//        var values = {};
//        $inputs.each(function () {
//            values[this.name] = $(this).val();
//        })
//
//        $.ajax({
//            type: "POST",
//            url: BASE_URL + 'user/ewallet/fund_transfer',
//            dataType: 'json',
//            data: values,
//            beforeSend: function () {
//
//            },
//            success: function (data) {
//
//                if (!data['error']) {
//
//                    $('.sw-btn-next').prop("disabled", false);
//                    var currency = DEFAULT_CURRENCY_VALUE;
//                    var precision = PRECISION;
//                    var amount = (data['data']['amount'] * currency).toFixed(precision);
//                    var bal_amount = (data['data']['bal_amount'] * currency).toFixed(precision);
//                    $('#balnc_amt').html('' + DEFAULT_SYMBOL_LEFT + bal_amount + DEFAULT_SYMBOL_RIGHT);
//                    $('#transaction_note').html(data['data']['transaction_note']);
//                    $('#amount').val(amount);
//
//                    $('#disp_amount').html('' + DEFAULT_SYMBOL_LEFT + amount + DEFAULT_SYMBOL_RIGHT);
//                    $('#to_username').val(data['data']['to_user']);
//                    $('#tot_req_amount').val(data['data']['total_req_amount']);
//
//                    $('#receiver').html(data['data']['to_user']);
//                } else if (data['error']) {
//                    $('#alert_div').contents().clone().addClass('alert-danger').append(data['message']).prependTo('#smartwizard');
//                    $('.sw-btn-next').attr('disabled', true);
//                    return false;
//                }
//            },
//            error: function (data) {
//                
//
//            },
//            complete: function () {
//                
//            }
//        });
//    });

$('#next').click(function () {
        var $inputs = $('#step-1 :input');
        var a = 1;
        var values = {};
        $inputs.each(function () {
            values[this.name] = $(this).val();
        })
        $.ajax({
            type: "POST",
            url: BASE_URL + 'user/ewallet/fund_transfer',
            dataType: 'json',
            data: values,
            beforeSend: function () {

            },
            success: function (data) {
                if (!data['error']) {

                    $('.sw-btn-next').prop("disabled", false);
                    var currency = DEFAULT_CURRENCY_VALUE;
                    var precision = PRECISION;
                    var amount = (data['data']['amount'] * currency).toFixed(precision);
                    var bal_amount = (data['data']['bal_amount'] * currency).toFixed(precision);
                    $('#balnc_amt').html('' + DEFAULT_SYMBOL_LEFT + bal_amount + DEFAULT_SYMBOL_RIGHT);
                    $('#transaction_note').html(data['data']['transaction_note']);
                    $('#amount').val(amount);

                    $('#disp_amount').html('' + DEFAULT_SYMBOL_LEFT + amount + DEFAULT_SYMBOL_RIGHT);
                    $('#to_username').val(data['data']['to_user']);
                    $('#tot_req_amount').val(data['data']['total_req_amount']);

                    $('#receiver').html(data['data']['to_user']);
                } else if (data['error']) {
                    $(this).attr('disabled', true);
                    return false;
                }
            },
            error: function (data) {
               
            },
            complete: function () {
                
            }
        });
    });

});

window.onload = function () {

    if (document.getElementById("page_container") && document.getElementsByClassName("main-navigation")) {
        document.getElementById("page_container").style.height = $(".main-navigation").height() + "px";
    }
    if (document.getElementById("page_container") && document.getElementById("menu")) {
        document.getElementById("page_container").style.height = $("#menu").height() + "px";
    }
}

