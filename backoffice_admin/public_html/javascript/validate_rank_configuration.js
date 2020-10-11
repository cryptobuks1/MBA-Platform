function inactivate_rank(id, root)
{
    var confirm_msg = $('#confirm_msg_inactivate').html();
    if (confirm(confirm_msg))
    {
        document.location.href = root + 'configuration/inactivate_rank/' + id;
    }
}
function activate_rank(id, root)
{
    var confirm_msg = $('#confirm_msg_activate').html();
    if (confirm(confirm_msg))
    {
        document.location.href = root + 'configuration/activate_rank/' + id;
    }
}
function delete_rank(id, root)
{
    var msg= $("#error_msg6").html();
    var confirm_msg = $('#confirm_msg_delete').html();
    if (confirm(msg))
    {
        document.location.href = root + 'configuration/rank_configuration/delete_rank/' + id;
    }
}
function add_rank(id)
{
    var confirm_msg = $("#confirm_msg_edit").html();
    var confirm_msg = $("#error_msg7").html();
    var path_root = $("#path_root").val();
    if (confirm(confirm_msg))
    {
        document.location.href = path_root + 'admin/configuration/rank/add/' + id;
    }
}
function inactivate_image(id, root){//alert('scd');
    var confirm_msg = $("#confirm_inactivate").html();
    
    
    if (confirm(confirm_msg))
    {//alert(root + 'home/inactivate_image/' + id);
        document.location.href = root + 'home/inactivate_image/' + id;
    }
}

function activate_image(id, root){//alert('scd');
    var confirm_msg = $("#confirm_activate").html();
    
    
    if (confirm(confirm_msg))
    {//alert(root + 'home/inactivate_image/' + id);
        document.location.href = root + 'home/activate_image/' + id;
    }
}

function edit_video(id, root)
{
    
    var confirm_msg = $('#confirm_msg_edit_video').html();
    if (confirm(confirm_msg))
    {
    
        document.location.href = root + 'member/edit_video/' + id;
    }
}

    $('input[name="group_pv"]').on('click', function () {
        $(this).closest('.panel').prev('.alert').remove();
        var status = $(this).is(':checked');
        var element = $(this);
        var key = 'group_pv';
        var value = status ? 'yes' : 'no';
        updateRankSettings(key, value, element);
    });
    $('input[name="personal_pv"]').on('click', function () {
        $(this).closest('.panel').prev('.alert').remove();
        var status = $(this).is(':checked');
        var element = $(this);
        var key = 'personal_pv';
        var value = status ? 'yes' : 'no';
        updateRankSettings(key, value, element);
    });
    $('input[name="downline_count"]').on('click', function () {
        $(this).closest('.panel').prev('.alert').remove();
        var status = $(this).is(':checked');
        var element = $(this);
        var key = 'downline_count';
        var value = status ? 'yes' : 'no';
        updateRankSettings(key, value, element);
    });
    $('input[name="downline_purchase"]').on('click', function () {
        $(this).closest('.panel').prev('.alert').remove();
        var status = $(this).is(':checked');
        var element = $(this);
        var key = 'downline_purchase';
        var value = status ? 'yes' : 'no';
        updateRankSettings(key, value, element);
    });
    function updateRankSettings(key, value, element) {
        data={};
        data[key]=value;
        var base_url = $('#base_url').val();
        var switch_elements = ['group_pv', 'personal_pv','downline_count','downline_purchase'];
        $.ajax({
            'url': base_url + "admin/configuration/update_rank_pv_option",
            'type': "POST",
            'data': data,
            'dataType': 'json',
            'beforeSend': function () {
                var img_url = $('#base_url').val() + 'public_html/images/loading.gif';
                if ($.inArray(key, switch_elements) === -1) {
                    var img = '<img style="margin: 10px 0 0 10px;height: max-content;" src="' + img_url + '"/>';
                    $(element).next('button').after(img);
                } else {
                    var img = '<img style="margin: 5px 0 0 10px;" src="' + img_url + '"/>';
                    $(element).closest('.switch').after(img);
                }
            },
            'success': function (data) {
                if (data.response) {
                    $("#success-box").fadeTo(2000, 300).slideUp(300, function () {
                        $("#success-box").slideUp(300);
                    });
                } else {
                    if ($.inArray(key, switch_elements) !== -1) {
                        $(element).prop('checked', !$(element).is(':checked'));
                    }
                    $("#error-box").fadeTo(2000, 500).slideUp(500, function () {
                        $("#error-box").slideUp(500);
                    });
                }
            },
            'error': function (error) {
                if ($.inArray(key, switch_elements) !== -1) {
                    $(element).prop('checked', !element.is(':checked'));
                }
                $("#error-box").fadeTo(2000, 500).slideUp(500, function () {
                    $("#error-box").slideUp(500);
                });
            },
            'complete': function () {
                setTimeout(function () {
                    if ($.inArray(key, switch_elements) === -1) {
                        $(element).closest('td').find('img').remove();
                    } else {
                        $(element).closest('.switch').next('img').remove();
                    }
                }, 500);
                location.reload();
            }
        });
    }
