var msg_wait = $('#msg_wait').val();
var bitcoin_address = $('#bitcoin_address').val();
var check_url = $('#check_url').val();
var public_url = $('#base_ulr').val() + 'public_html/';
var interval = setInterval('autoRefresh_div()', 5000); // refresh div after 5 secs
function autoRefresh_div() {
    $.ajax({
        type: 'post',
        url: check_url,
        data: {
            bitcoin_address: bitcoin_address
        },
        beforeSend: function () {
            $('#loading').html('<img src="' + public_url + 'images/loader.gif"> <br/> ' + msg_wait);

        },
        success: function (data) {
            if (data == 'yes') {
                window.location.href = $('#path_root').val() + "/bitcoin_registration";
                clearInterval(interval);
            } else if (data == 'no_post_data') {
                window.location.href = $('#path_root').val() + "/user_register";
            }
        },
        error: function () {
            $('.content').html('error');
        }
    });
}