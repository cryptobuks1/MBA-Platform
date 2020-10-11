$(document).ready(function () {
    //inactiviy logout setting
    var logout_time = $("#logout_time").val();
    var logout_time_ms = logout_time * 1000;
    var timer = setInterval(idleSessout, logout_time_ms); //assign timer to a variable

    $(window).bind('focus', function ()
    {
        clearInterval(timer); //clear interval
        timer = setInterval(idleSessout, logout_time_ms); //start it again
    //
    });
});

function idleSessout()
{
    var base_url = $("#base_url").val();
    //get the last page load time and current server time
    var post_path = base_url + "time/check_time_out";
    jQuery.post(post_path, {}, function (data)
    {
        if (data == "expired") {
            document.location.href = base_url + "login/auto_logout";
        }
    });
}