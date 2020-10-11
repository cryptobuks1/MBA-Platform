(function($) {
    var container = $("<div />");
    container.attr({id: "notificator"});
    $(function() {
        $("body").append(container);
    });
    $.notificator = function(string, count) {

        var tip = $("<div />").addClass("msg");
        tip.html('<div class="close_notification" id="close_notification' + count + '">&#10006;</div>' + string);
        container.append(tip);
        tip.show("drop", {
            direction: "up",
            distance: 50
        }, 120).
                delay(3500).
                fadeOut(400, function() {
                    $(this).remove();
                });
        $('#close_notification' + count).click(function() {
            $(this).parent().remove();
        });
        return tip;
    };

    $.remove_notificator = function() {
        $(".msg").remove();
    };
})(jQuery);