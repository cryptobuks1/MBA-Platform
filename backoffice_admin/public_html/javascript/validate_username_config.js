$(function () {
    $('select[name="user_name_type"]').on('change', function () {
        var user_name_type = this.value;
        if (user_name_type == 'static') {
            $('#length_div').hide();
            $('#prefix_status_div').hide();
            $('#prefix_div').hide();
        }
        if (user_name_type == 'dynamic') {
            $('#length_div').show();
            $('#prefix_status_div').show();
            $('#prefix_div').show();
            $('input[name="prefix_status"]').change();
        }
    });
    $('input[name="prefix_status"]').on('change', function () {
        var prefix_status = this.checked;
        if (prefix_status) {
            $('#prefix_div').show();
        } else {
            $('#prefix_div').hide();
        }
    });
});

//===================for username configuration
$(document).ready(function () {
    var msg1 = $("#validate_msg4").html();
    $("#username_config_form").validate({
        submitHandler: function (form) {
            SubmittingForm();
        },
        rules: {
            prefix: {
                minlength: 1,
                required: true
            }
        },
        messages: {
            prefix: msg1,
        }
    });
});

$(document).ready(function ()
{

    if ($('#Dynamic').attr('checked')) {

        $("#user_type_div").show();
        $("#user_type_div1").show();

    }
    $("#Dynamic").click(function () {
        $("#user_type_div").show();
        $("#user_type_div1").show();

        if ($('#yes').attr('checked')) {

            var prefix_val = $('#user_name_config').html();

            var html;
            html = "<td>Username Prefix:<font color='#ff0000'>*</font></strong></td><td><input type='text' class='form-control' name ='prefix' id ='prefix' value='' maxlength='19' tabindex='8' title='This is the prefix of user name. It should contain 3 to 15 characters.'><span id='errmsg1'></span></td>";
            document.getElementById('prefix_div').innerHTML = html;
            $('#prefix').val(prefix_val);
            $("#prefix_div").show();
        }
    });
    $("#Static").click(function () {
        $("#user_type_div").hide("fast");
        $("#user_type_div1").hide("fast");
        $("#prefix_div").hide("fast");

    });

    if ($('#yes').attr('checked')) {

        var prefix_val = $('#user_name_config').html();

        var html;
        html = "<td>Username Prefix:<font color='#ff0000'>*</font></strong></td><td><input type='text' class='form-control' name ='prefix' id ='prefix' value='' minlength='2' maxlength='5' tabindex='8' title='This is the prefix of user name. It should contain 2 to 5 characters.'><span id='errmsg1'></span></td>";
        document.getElementById('prefix_div').innerHTML = html;
        $('#prefix').val(prefix_val);
        $("#prefix_div").show();


    }
    $("#yes").click(function () {
        var prefix_val = $('#user_name_config').html();
        html = "<td>Username Prefix:<font color='#ff0000'>*</font></strong></td><td><input type='text' class='form-control' name ='prefix' id ='prefix' value='' minlength='2' maxlength='5' tabindex='8' title='This is the prefix of user name. It should contain 2 to 5 characters.'><span id='errmsg1'></span></td>";
        document.getElementById('prefix_div').innerHTML = html;
        $('#prefix').val(prefix_val);
        $("#prefix_div").show();

    });
    $("#no").click(function () {
        $("#prefix_div").hide("fast");

    });
});


function show_prefix()
{
    var html;
    html = "<td>Username Prefix:<font color='#ff0000'>*</font></strong></td><td><input type='text' class='form-control' name ='prefix' id ='prefix' maxlength='19' tabindex='6' title='This is the prefix of user name. It should contain 3 to 15 characters.'><span id='errmsg1'></span></td>";
    document.getElementById('prefix_div').innerHTML = html;
    document.getElementById('prefix_div').style.display = "";
}

function hide_prefix()
{
    document.getElementById('prefix_div').style.display = "none";
}


function getUsernamePrefix()
{
    var html;
    var path_root = document.username_config_form.path_root.value;
    var getUsernamePrefix = path_root + "admin/configuration/getUsernamePrefix";
    $.post(getUsernamePrefix, function (data)
    {
        data = trim(data);
        if (data != "")
        {
            html = "<td>Username Prefix:<font color='#ff0000'>*</font></strong></td><td><input type='text' class='form-control' name ='prefix' id ='prefix' maxlength='19' value='" + data + "'title='This is the prefix of user name. It should contain 3 to 15 characters.'><span id='errmsg1'></span></td>";
            document.getElementById('prefix_div').innerHTML = html;
            document.getElementById('prefix_div').style.display = "";
        }
    });
}