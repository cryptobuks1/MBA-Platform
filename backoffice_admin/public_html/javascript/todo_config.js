    var user_type = getUserType();
    $(function () {
        new ClipboardJS('#copy_link_replica');
        new ClipboardJS('#copy_link_lcp');
        loadDatePicker();
        loadTimePicker();
        $(".core-box").addClass("slideUp");
        $(".badge").addClass("fadeIn");
        $('[data-toggle="tooltip"]').tooltip();
        setTimeout(function () {
            $('#demoModal').modal();
        }, 1500);
    }());
    var base_url = $('#base_url').val();
    // $('#input-task_date').datepicker();
    // $('#input-task_time').timepicker();

    $("#add_lead_form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
      
        $.ajax({
            url: base_url + user_type + '/home/validate_addlist',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function() {
                $('#add_list').button('loading');
            },
            complete: function() {
                $('#add_list').button('reset');
            },
            success: function(json) {
                $('.alert, .text-danger').remove();
                $('.has-error').removeClass('has-error');
                if (json['success']) {
                    $('#edit_lead_div').prepend('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                    $("#input-task").val('');
                    $("#input-task_date").val('');
                    $("#input-task_time").val('');
                    
                } else if (json['error']) {
                    if (json['error']['warning']) {
                        $('#edit_lead_div').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                    }

                    for (i in json['error']) {
                        var element = $('#input-' + i);
                        if ($(element).parent().hasClass('input-group') || $(element).parent().hasClass('checkbox') || $(element).parent().hasClass('radio')) {
                            $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
                        } else {
                            $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
                        }
                    }
                    // Highlight any found errors
                    $('.text-danger').each(function() {
                        $(this).parents('.form-group').first().addClass('has-error');
                    });
                } else {
                    alert('Error!!!');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });
$("#edit_lead_form").submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this);      
    $.ajax({
        url: base_url + user_type + '/home/validate_edit_todo',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function () {
            $('#add_list').button('loading');
        },
        complete: function () {
            $('#add_list').button('reset');
        },
        success: function (json) {
            $('.alert, .text-danger').remove();
            $('.has-error').removeClass('has-error');
            if (json['success']) {
                $('#edit_lead_div').prepend('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

            } else if (json['error']) {
                if (json['error']['warning']) {
                    $('#edit_lead_div').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

                for (i in json['error']) {
                    var element = $('#input-' + i);
                    if ($(element).parent().hasClass('input-group') || $(element).parent().hasClass('checkbox') || $(element).parent().hasClass('radio')) {
                        $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
                    } else {
                        $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
                    }
                }
                // Highlight any found errors
                $('.text-danger').each(function () {
                    $(this).parents('.form-group').first().addClass('has-error');
                });
            } else {
                alert('Error!!!');
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
    $(".date-picker,.time-picker").keypress(function(e) {
    if (e.which == 0 || e.which == 8) {
            return;
        }
        var regex = new RegExp("^[0-9\-]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        else {
            return false;
        }
    });
$('#reservation_detail_model').on('hidden.bs.modal', function () {
        location.reload();
    })


    function statusChange(id, t) {
        if (t.is(':checked')) {
            $.ajax({
                type: "POST",
                url: base_url + user_type + "/home/change_todo",
                data: {
                    id: id,
                    status: 'completed',
                },
            });
        } else {
            $.ajax({
                type: "POST",
                url: base_url + user_type + "/home/change_todo",
                data: {
                    id: id,
                    status: 'not_started',
                },
            });
        }
        ;
    }

    function hidealert() {
        $("#alert2").hide();
    }
    function loadModal(id, title, path) {
        $.ajax({
            type: 'POST',
            url: base_url + path,
            data: {
                id: id,
                from: 'home/index'},
            success: function (msg) {
                $('#reservation_detail_model_body').html(msg);
                $('#modaltitle').html(title);
                $('#reservation_detail_model').css('width', '');
                $('#reservation_detail_model').css('left', '');
                $('#reservation_detail_model').modal('show');
                $('#reservation_detail_model').on('show.bs.modal', function (e) {
                });
            },
            error: function (msg) {
                alert("Error Occured!");
            }
        });
    }
    $('.chk_toggle').change(function () {
        $(this).parent().closest('label').toggleClass("selected");

    });

    function deleteTask()
    {
        var confirm_msg = $('#confirm_msg').html();
        if (confirm(confirm_msg))
        {
            document.location.href = base_url + user_type + '/home/delete_todo';
        } else {
            return false;
        }
    }
    function twittershare(url) {

        // Opens a pop-up with twitter sharing dialog
        window.open('http://twitter.com/share?url=' + encodeURIComponent(url), '', 'left=0,top=0,width=550,height=450,personalbar=0,toolbar=0,scrollbars=0,resizable=0');
    }

    function googlePlusShare(url) {
        var url1 = encodeURIComponent(url);

        window.open('https://plus.google.com/share?url=' + url1, '', 'left=0,top=0,width=550,height=450,personalbar=0,toolbar=0,scrollbars=0,resizable=0');

    }
    
    function facebookShare(url) {
        window.open(url, '', 'left=0,top=0,width=550,height=450,personalbar=0,toolbar=0,scrollbars=0,resizable=0');

    }
