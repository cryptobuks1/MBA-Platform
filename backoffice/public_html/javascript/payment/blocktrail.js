var interval = null;
var check_url = $('#check_url').val();
var success_url = $('#success_url').val();
var error_url = $('#error_url').val();
$(function () {
    interval = setInterval('autoRefresh_div()', 5000); // refresh div after 5 secs
});

function autoRefresh_div() {
    $.ajax({
        type: 'post',
        url: check_url,
        data: {
            bitcoin_address: $("#bitcoin_address").val()
        },
        beforeSend: function () {
            var img_src_path = $('#img_src_path').val();
            var msg1 = $('#msg1').text();
            $('#loading').html('<img src="' + img_src_path + 'images/loading_spinner.gif"> <br/> ' + msg1);

        },
        success: function (data) {
            if (data == 'yes') {
                window.location.href = success_url;
                clearInterval(interval);
            } else if (data == 'no_post_data') {
                window.location.href = error_url;
            }
        },
        error: function () {
            $('.content').html('error');
        }
    });
}