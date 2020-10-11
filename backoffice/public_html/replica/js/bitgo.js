$(document).ready(function () {
    var base_url = $('#base_url').val();
    $('#btc_confirm').hide();
    setInterval(function () {
        $.ajax({
            type: "GET",
            url: base_url + "replica/ajax_bitgo_payment_verify/",
            dataType: 'json',
            success: function (data) {
                if (data['status'] === true) {
                    $('#btc_confirm').trigger('click');
                } else if (data['status'] === false) {
                    $('#payment_response').html(data['msg']);
                    // window.location.href = '{$BASE_URL}/register/register_submit';
                } else if (data['error'] != null) {
                    alert(data['error']);
                    window.location.href = base_url + 'replica/register_submit';
                }
            }
        });
    }, 1000 * 60 * .1);
    //Default time intervel is 10seconds..
});