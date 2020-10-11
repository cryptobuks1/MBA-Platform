function changeStatus(id) {

    var option = $('select#sel3').val();

    if (option != '') {
        var ans = confirm('Do you want to change this status?');
        if (ans == true) {

            var base_url_id = $("#base_url_id").val();
            var current_url = base_url_id + 'admin/ticket_system/status_change';


            $.post(current_url, { id: id, option: option },
                function(data) {
                    if (data != 'false')
                        $('#status_name').text(data);

                }, "html");


        } else {
            $("select#sel3").val('');
        }
    }
}

function changeCategory(id) {

    var option = $('select#sel2').val();

    if (option != '') {
        var ans = confirm('Do you want to change this category?');
        if (ans == true) {

            var base_url_id = $("#base_url_id").val();
            var current_url = base_url_id + 'admin/ticket_system/category_change';


            $.post(current_url, { id: id, option: option },
                function(data) {
                    if (data != 'false')
                        $('#category_name').text(data);

                }, "html");


        } else {
            $("select#sel2").val('');
        }
    }
}

function changePriority(id) {

    var option = $('select#sel1').val();

    if (option != '') {
        var ans = confirm('Do you want to change this priority?');
        if (ans == true) {

            var base_url_id = $("#base_url_id").val();
            var current_url = base_url_id + 'admin/ticket_system/priority_change';


            $.post(current_url, { id: id, option: option },
                function(data) {
                    if (data != 'false')
                        $('#priority_name').text(data);

                }, "html");


        } else {
            $("select#sel1").val('');
        }
    }
}

function changeAssignee(id) {

    var option = $('select#sel4').val();

    if (option != '') {
        var ans = confirm('Do you want to change Assignee?');
        if (ans == true) {

            var base_url_id = $("#base_url_id").val();
            var current_url = base_url_id + 'admin/ticket_system/assignee_change';


            $.post(current_url, { id: id, option: option },
                function(data) {
                    if (data != 'false')
                        $('#assignee_name').text(data);

                }, "html");


        } else {
            $("select#sel1").val('');
        }
    }
}

function addComments(id) {
    var msg = $('#err_msg').html();
    if ($('textarea#comments').val() == "" || $('textarea#comments').val() == undefined)
        return ($("#added").html(msg).show().fadeOut(1500, 0));
    var option = $('textarea#comments').val();
    var base_url_id = $("#base_url_id").val();
    var current_url = base_url_id + 'admin/ticket_system/add_comments';
    $.post(current_url, { id: id, option: option },
        function(data) {
            if (data != 'false')
                document.getElementById("comments").value = "";
            var msg = $('#cmnt_msg').html();
            $("#added").html(msg).show().fadeOut(1500, 0);
            $("#comments_box").load(" #comments_box > *");
        }, "html");
}

function updateTags(id) {
    var option = $('input#activate_tagator2').val();

    //    if (option != '') {
    //        var ans = confirm('Do you want to change this status?');
    //        if (ans == true) {
    $('button#btn-update').text('updating...');
    var base_url_id = $("#base_url_id").val();

    var current_url = base_url_id + 'admin/ticket_system/update_tag';

    $.post(current_url, { id: id, option: option },
        function(data) {
            if (data != 'false') {
                $('button#btn-update').text('update');
            }
            //                  $('#status_name').text(data);
        }, "html");
    //        } else {
    //            $("select#sel3").val('');
    //        }
    //    }
}


var ValidateMessage = function() {


    var Validatemess = function() {
        var searchform = $('#message');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#message').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type
                if ($(element).hasClass("date-picker")) {
                    error.insertAfter($(element).closest('.input-group'));
                } else {
                    error.insertAfter(element);
                };
                //error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                message: {
                    //                    maxlength: 40,
                    required: true
                },
            },
            messages: {
                message: {
                    required: 'You must enter message',
                }
            },
            invalidHandler: function(event, validator) { //display error alert on form submit
                errorHandler1.show();
            },
            highlight: function(element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function(element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function(label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                //$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            }
        });
    };

    return {
        //main function to initiate template pages
        init: function() {

            Validatemess();

        }
    };
}();
$(function() {
    ValidateMessage.init();
});