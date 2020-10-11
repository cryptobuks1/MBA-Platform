$(function () {
    $('#full-nav').on('click', function () {
        if ($('#sidebar').is(':visible')) {
            $('#sidebar').animate({
                'width': '0px'
            }, 'slow', function () {
                $('#sidebar').hide();
            });
            $('.dashboard-wrapper').animate({
                'margin-left': '0px'
            }, 'slow');
        } else {
            $('#sidebar').show();
            $('#sidebar').animate({
                'width': '220px'
            }, 'slow');
            $('.dashboard-wrapper').animate({
                'margin-left': '220px'
            }, 'slow');
        }
    });
});