$(document).ready(function () {
    getNotifications();
    
    var timer = setInterval(getNotifications, 5000); //assign timer to a variable
    
    $("form").submit(function () {
        clearInterval(timer);
    });
    
    $(window).bind('focus', function ()
    {
        clearInterval(timer); //clear interval
        timer = setInterval(getNotifications, 5000); //start it again
    });   
});

function getNotifications() {

    var base_url = $("#base_url").val();

    $.ajax({
        url: base_url + "admin/home/get_notifications",
        dataType: "json",
        contentType: "application/json",
        success: function (notifications) {
            if (notifications) {
                $.remove_notificator();

                $.each(notifications, function (k, v) {
                    var message = v.message;
                    $.notificator(message, k);
                });
            }
        }
    });
}
