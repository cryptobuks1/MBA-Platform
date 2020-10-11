$("#followup_form").submit(function (e) {
  if($(this).valid()){
    e.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: BASE_URL + 'crm/validate_add_followup',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function () {
            $('#add_followup').button('loading');
        },
        complete: function () {
            $('#add_followup').button('reset');
        },
        success: function (json) {
            $('.alert, .text-danger').remove();
            $('.has-error').removeClass('has-error');
            if (json['success']) {
                $('#follow_up').prepend('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                document.getElementById('input-description').value = '';
                document.getElementById('input-followup_date').value = '';

            } else if (json['error']) {
                if (json['error']['warning']) {
                    $('#follow_up').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
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
  }
});

$("#followup_date_form").submit(function (e) {
  if($(this).valid()){
    e.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: BASE_URL + 'crm/validate_edit_followup_date',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function () {
            $('#update_followup_date').button('loading');
        },
        complete: function () {
            $('#update_followup_date').button('reset');
        },
        success: function (json) {
            $('.alert, .text-danger').remove();
            $('.has-error').removeClass('has-error');
            if (json['success']) {
                $('#follow_up_date').prepend('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                document.getElementById('input-followup_date').value = '';
                document.getElementById('current_follow_up').value = json['new'];

            } else if (json['error']) {
                if (json['error']['warning']) {
                    $('#follow_up_date').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
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
  }
});

$("#lead_register").submit(function (e) {
  if($(this).valid()){
    e.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: BASE_URL + 'crm/validate_edit_lead',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function () {
            $('#update_lead').button('loading');
        },
        complete: function () {
            $('#update_lead').button('reset');
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
  }
});

function loadModal(id, title, path) {
    $.ajax({
        type: 'POST',
        url: BASE_URL + path,
        data: {id: id, from: 'lead/view_lead'},
        success: function(msg) {
            $('#reservation_detail_model_body').html(msg);
            $('#modaltitle').html(title);
            $('#reservation_detail_model').css('width', '');
            $('#reservation_detail_model').css('left', '');
            $('#reservation_detail_model').modal('show');
            $('#reservation_detail_model').on('show.bs.modal', function (e) {

            });
        },
        error: function(msg) {
            alert("Error Occured!");
        }
    });
}
function changeNewStatus(status) {
    var url = BASE_URL + "crm/change_new_status";
    $.post(url, { lead_status: status }, function (data) {
        document.getElementById('count_span_' + status).innerHTML = '0';
    });
}

function showStatusChangeDateField(new_status) {
    current_status = document.getElementById('current_status').value;
    if (current_status != new_status) {
        document.getElementById('status_change_date_div').style.display = 'block';
    } else {
        document.getElementById('status_change_date_div').style.display = 'none';
    }
}

function showStatusChangeDates(status) {
    if (status == 'Accepted' || status == 'Rejected') {
        document.getElementById('status_change_date_div').style.display = 'block';
    } else {
        document.getElementById('status_change_date_div').style.display = 'none';
    }
}