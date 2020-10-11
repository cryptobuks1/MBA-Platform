$(function () {
    
    var finish_lang = $('#finish_lang').text();
    var next_lang = $('#next_lang').text();
    var back_lang = $('#back_lang').text();
    
    $('html, body').animate({
        scrollTop: '0px'
    }, 1500);
    
    FormWizard.init();
    
    if ($("#sponsor_user_name").val()) {
        $("#sponsor_user_name").trigger('blur');
    }
    
    window.onload = function () {
        if (document.getElementById("page_container") && document.getElementsByClassName("main-navigation")) {
            document.getElementById("page_container").style.minHeight = $(".main-navigation").height() + "px";
        }
        if (document.getElementById("page_container") && document.getElementById("menu")) {
            document.getElementById("page_container").style.minHeight = $("#menu").height() + "px";
        }
    }

    // Step show event 
    $("#smartwizard").on("showStep", function (e, anchorObject, stepNumber, stepDirection, stepPosition) {

        var last_step_no = (anchorObject.prevObject.length) - 1;
        if (stepPosition === 'first') {
            $('.sw-btn-prev').hide();
            $('.sw-btn-next').show();
            $('.sw-btn-finish').hide();
        } else if (stepPosition === 'middle') {
            $('.sw-btn-prev').show();
            $('.sw-btn-next').show();
            $('.sw-btn-finish').hide();
        } else if (stepPosition === 'final') {
            $('.sw-btn-prev').show();
            $('.sw-btn-next').hide();
            $('#p-show').show();
            if ($('#free_join_status').val() == 'no') {
                $('.sw-btn-finish').hide();
            } else {
                $('.sw-btn-finish').show();
            }
        }

        if (stepPosition === "final" && stepNumber == last_step_no) {
            $("#prevbtn_custom_style").html("<style>button.btn.btn-default.sw-btn-prev { margin-left: 11px !important; }</style>");
        } else {
            $("#prevbtn_custom_style").html(" ");
        }
    });

    // Toolbar extra buttons
    var btnFinish = $('<button type="submit"></button>').text(finish_lang).addClass('btn btn-info sw-btn-finish dan');

    // Smart Wizard
    $('#smartwizard').smartWizard({
        selected: 0,
        keyNavigation: false,
        theme: 'arrows',
        transitionEffect: 'fade',
        showStepURLhash: false,
        toolbarSettings: {
            toolbarPosition: 'both',
            toolbarExtraButtons: [btnFinish]
        },
        anchorSettings: {
            anchorClickable: false, // Enable/Disable anchor navigation
        },
        lang: {
            next: next_lang,
            previous: back_lang
        }
    });

    $("#smartwizard").on("leaveStep", function (e, anchorObject, stepNumber, stepDirection) {

        if (stepDirection === 'forward') {
            var step_id = $($(anchorObject)[0]).attr('href');
            var valid = true;
            $(step_id + ' input, ' + step_id + ' select').not(':hidden').each(function () {
                if (!$(this).valid()) {
                    valid = false;
                }
            });
            return valid;
        }
        return true;
    });

    $('#form').submit(function () {
        if ($("#form").valid()) {
            $('.sw-btn-finish').button('loading');
        }
    });

});

function displayNone() {
    $("#alert_div").removeClass("alert");
    $('#alert_div').hide();
}