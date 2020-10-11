/*
 * 	Easy Tooltip 1.0 - jQuery plugin
 *	written by Alen Grakalic	
 *	https://cssglobe.com/post/4380/easy-tooltip--jquery-plugin
 *
 *	Copyright (c) 2009 Alen Grakalic (https://cssglobe.com)
 *	Dual licensed under the MIT (MIT-LICENSE.txt)
 *	and GPL (GPL-LICENSE.txt) licenses.
 *
 *	Built for jQuery library
 *	https://jquery.com
 *
 */

(function ($) {

    $.fn.easyTooltip = function (options) {

        // default configuration properties
        var defaults = {
            xOffset: 10,
            yOffset: -20,
            tooltipId: "easyTooltip",
            clickRemove: true,
            content: "",
            useElement: ""
        };

        var options = $.extend(defaults, options);
        var content;
        var tooltipWidth = 240;
        var tooltipX;
        var windowX;

        this.each(function () {
            var title = $(this).attr("title");
            $(this).hover(function (e) {
                tooltipX = e.pageX + options.xOffset;
                windowX = $(window).width();
                if (tooltipX + tooltipWidth > windowX) {
                    tooltipX = windowX - (tooltipWidth + options.xOffset);
                }

                content = (options.content != "") ? options.content : title;
                content = (options.useElement != "") ? $("#" + options.useElement).html() : content;
                $(this).attr("title", "");
                if (content != "" && content != undefined) {
                    $("body").append("<div id='" + options.tooltipId + "'>" + content + "</div>");
                    $("#" + options.tooltipId)
                            .css("position", "absolute")
                            .css("top", (e.pageY - options.yOffset) + "px")
                            .css("left", (tooltipX) + "px")
                            .css("display", "none")
                            .fadeIn("fast")
                }
            },
                    function () {
                        $("#" + options.tooltipId).remove();
                        $(this).attr("title", title);
                    });
            $(this).mousemove(function (e) {

                tooltipX = e.pageX + options.xOffset;
                windowX = $(window).width();
                if (tooltipX + tooltipWidth > windowX) {
                    tooltipX = windowX - (tooltipWidth + options.xOffset);
                }

                $("#" + options.tooltipId)
                        .css("top", (e.pageY - options.yOffset) + "px")

                        .css("left", (tooltipX) + "px")
            });
            if (options.clickRemove) {
                $(this).mousedown(function (e) {
                    $("#" + options.tooltipId).remove();
                    $(this).attr("title", title);
                });
            }
        });

    };

})(jQuery);
