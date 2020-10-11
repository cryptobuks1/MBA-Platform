/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    var msg = $("#error").html();
    $('.disabled').on('click', function () {
        alert(msg);
    });
    $(':checkbox:disabled').next().click(function () {
        alert(msg);
    });

    $('td.has_sub').on('click', function () {
        var id = $(this).attr('id');
        $(this).find('i').toggleClass("clip-chevron-right");
        $(this).find('i').toggleClass("fa fa-angle-double-down");
        $('.sub_' + id).fadeToggle();
    });

    $('.menu_status').on('click', function () {
        $(this).closest('.panel').prev('.alert').remove();
        var id = $(this).data('id');
        var status = $(this).is(':checked');
        var attr = $(this).attr('name');
        var element = $(this);
        var path = "admin/configuration/update_menu_permission";
        change_menu_config(id, status, attr, element, path);
    });

    $('.submenu_status').on('click', function () {
        $(this).closest('.panel').prev('.alert').remove();
        var id = $(this).data('id');
        var status = $(this).is(':checked');
        var attr = $(this).attr('name');
        var element = $(this);
        var path = "admin/configuration/update_sub_menu_permission";
        change_menu_config(id, status, attr, element, path);
    });
});
function change_menu_config(id, status, attr, element, path) {
    var base_url = $('#base_url').val();
    $.ajax({
        'url': base_url + path,
        'type': "POST",
        'data': {id: id, status: status, attr: attr},
        'dataType': 'json',
        'beforeSend': function () {
            var img_url = $('#base_url').val() + 'public_html/images/loading.gif';
            var img = '<img style="margin: 5px 0 0 10px;" src="' + img_url + '"/>';
            $(element).closest('.switch').after(img);
        },
        'success': function (data) {
            if (data.response) {
                var box = $('#success-box').clone();
                $(box).css('display', 'block');
                $(box).attr('id', '');
                $(element).closest('.panel').before(box);

            }
            else {
                $(element).prop('checked', !status);
                var box = $('#error-box').clone();
                $(box).css('display', 'block');
                $(box).attr('id', '');
                $(element).closest('.panel').before(box);

            }
        },
        'error': function (error) {
            $(element).prop('checked', !status);
            var box = $('#error-box').clone();
            $(box).css('display', 'block');
            $(box).attr('id', '');
            $(element).closest('.panel').before(box);
        },
        'complete': function () {
            setTimeout(function () {
                $(element).closest('.switch').next('img').remove();
                location.reload(true);
            }, 500);
        }
    });
}

