$(function () {
    var verify_url = $('#bitgo_verify_url').val();
    var error_url = $('#bitgo_error_url').val();
    $('#btc_confirm').hide();
    setInterval(function () {
        $.ajax({
            type: "GET",
            url: verify_url,
            dataType: 'json',
            success: function (data) {
                if (data['status'] === true) {
                    $('#btc_confirm').trigger('click');
                } else if (data['status'] === false) {
                    $('#payment_response').html(data['msg']);
                } else if (data['error'] != null) {
                    alert(data['error']);
                    window.location.href = error_url;
                }
            }
        });
    }, 1000 * 60 * .2);
});