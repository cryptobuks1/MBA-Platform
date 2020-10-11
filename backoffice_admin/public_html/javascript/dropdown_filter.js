(function ($) {
    $.fn.dropdownFilter = function (options) {
        var settings = $.extend({
            remote: false,
            remote_url: null,
            clear: true,
            clear_txt: null
        }, options);
        settings.remoteCall = function (data) {
            if (settings.remote) {
                data['filter'] = 'yes';
                $.ajax({
                    'url': settings.remote_url,
                    'type': "POST",
                    'data': data,
                    'dataType': 'text',
                    'success': function (data) {},
                    'error': function (error) {},
                    'complete': function () {
                        window.location = settings.remote_url;
                    }
                });
            }
        };
        $(this).hide();
        this.each(function () {
            var $this = $(this);
            if ($this.is('select')) {
                var $name = $this.attr('name');
                var $title = $this.data('title');
                var $value = $this.data('value');
                var $text_selected = $this.find("option[value='" + $value + "']").text();
                var $icon = $this.data('icon');
                var $element = $('<div/>', {
                    class: 'btn-group dropdown_filter_' + $name
                });
                var $button = "<button class='btn btn-sm btn-default' data-toggle='dropdown'><i class='" + $icon + "'></i> <b>" + $text_selected + " (" + $title + ")</b> <span class='caret'></span></button>";
                var $ul = $('<ul/>', {
                    class: 'dropdown-menu'
                });
                var $li = '';
                $this.find('option').each(function () {
                    var $li_target = '';
                    if ($(this).is('[target-id]')) {
                        var target = $(this).attr('target-id');
                        $li_target = "target-id='" + target + "'";
                    }
                    var $li_value = $(this).val();
                    var $li_text = $(this).text();
                    $li_active = '';
                    if ($li_value == $value) {
                        $li_active = 'active';
                    }
                    $li += "<li class='" + $li_active + "' " + $li_target + "><a data-value='" + $li_value + "'><span>" + $li_text + "</span></a></li>";
                });
                $ul.append($li);
                $element.append($button);
                $element.append($ul);
                $element.insertAfter($this);
                $element.find('ul li a').on('click', function () {
                    $element.find('ul li').removeClass('active');
                    $(this).parent().addClass('active');
                    $element.find('button b').text($(this).find('span').text() + ' (' + $title + ')');
                    if ($(this).parent().is('[target-id]')) {
                        var target = $(this).parent().attr('target-id');
                        $('#' + target).addClass('show');
                        $(this).parent().siblings().each(function () {
                            var target = $(this).attr('target-id');
                            $('#' + target).removeClass('show');
                        });
                        
                        var target = $(this).parent().attr('target-id');

                    }
                    if (settings.remote) {
                        var filter = {};
                        filter[$name] = $(this).data('value');
                        settings.remoteCall(filter);
                    }
                });
            }
        });
        if (settings.clear) {
            var $clear_btn = $("<div class='btn-group'><button class='btn btn-sm btn-default'><i class='fa fa-circle-o-notch'></i> <b>" + settings.clear_txt + "</b></button></div>");
            $(this).closest('.section-dropdown-filter').append($clear_btn);
            $clear_btn.on('click', function () {
                var filter = {};
                filter['clear'] = 'yes';
                settings.remoteCall(filter);
            });
        }
    };

})(jQuery);