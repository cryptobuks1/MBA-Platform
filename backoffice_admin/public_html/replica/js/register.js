$(function() {
    var reg_count = $('#reg_count').val();
    var reg_count = $('#product_status').val();
    if (reg_count) {
        $("#position").trigger('change');
    }
    if (product_status == "yes") {
        $("#product_id").trigger('change');
    }
    $("#close_link").click(function() {
        $("#message_box").fadeOut(1000);
        $("#message_box").removeClass('ok');
    });

    $('#msform').submit(function() {
        if ($("#msform").valid()) {
            $('.sw-btn-finish').button('loading');
        }
    });

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
    $('.date-picker').Zebra_DatePicker(datepicker_options);
});

$(window).load(function() {
    $("#sponsor_user_name").trigger('blur');
});