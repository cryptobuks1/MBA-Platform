function delete_pin(id, root) {
    var confirm_msg = $("#error_msg_delete").html();
    if (confirm(confirm_msg)) {
        document.location.href = root + 'epin/delete_epin/delete/' + id;
    }
}

function delete_all_epin(root, pin_status, page) {
    var confirm_msg = $("#error_msg_delete_all").html();
    if (confirm(confirm_msg)) {
        document.location.href = root + 'epin/delete_all_epin/delete/' + pin_status + '/' + page;
    }
}

function block_pin(id, root) {
    var confirm_msg = $("#error_msg_block").html();
    if (confirm(confirm_msg)) {
        document.location.href = root + 'epin/active_epin/block/' + id;
    }
}

function activate_pin(id, root) {
    var confirm_msg = $("#error_msg_activate").html();
    if (confirm(confirm_msg)) {
        document.location.href = root + 'epin/inactive_epin/activate/' + id;
    }
}

function edit_news(id, root) {
    document.location.href = root + 'news/add_new_news/edit/' + id;
}

function delete_pin_admin(id, root) {
    var confirm_msg = $("#error_msg6").html();
    if (confirm(confirm_msg)) {
        document.location.href = root + 'epin/delete/' + id;
    }
}

function edit_rank(id, root) {
    var confirm_msg = $('#confirm_msg_edit').html();
    document.location.href = root + 'configuration/add_new_rank/edit/' + id;
}

function edit_board(id, root) {
    document.location.href = root + 'configuration/board_configuration/edit/' + id;
}

function edit_stairstep(id, root) {
    var confirm_msg = $('#confirm_msg_edit').html();
    if (confirm(confirm_msg)) {
        document.location.href = root + 'configuration/stairstep_configuration/edit/' + id;
    }
}

function delete_employee(id, root) {
    if (confirm("Sure you want to Delete? There is NO undo!")) {
        document.location.href = root + 'employee/view_all_employee/delete/' + id;
    }
}

function edit_employee(id, root) {
    document.location.href = root + 'employee/view_all_employee/edit/' + id;
}

function search_edit_employee(id, root) {
    document.location.href = root + 'employee/search_employee/edit/' + id;
}

function search_delete_employee(id, root) {
    if (confirm("Sure you want to Delete? There is NO undo!")) {
        document.location.href = root + 'employee/search_employee/delete/' + id;
    }

}

function show_timeline(id) {
    var path_root = $("#path_root").val();
    document.location.href = path_root + 'admin/ticket_time_line/' + id;
}

function show_more() {
    document.getElementById('more_search_type').style.display = "";
    document.getElementById('less_option').style.display = "";
    document.getElementById('more_option').style.display = "none";
}

function show_less() {
    document.getElementById('more_search_type').style.display = "none";
    document.getElementById('less_option').style.display = "none";
    document.getElementById('more_option').style.display = "";
    document.getElementById('s_my').value = "";
    document.getElementById('s_ot').value = "";
    document.getElementById('s_un').value = "";
    document.getElementById('archive').value = "";
    document.getElementById('tckt_category').value = "";
    document.getElementById('week_date').value = "";
}

function remove_cart_item(id) {
    var confirm_msg = $("#confirm_msg_remove").html();
    var path_root = $("#path_root").val();
    if (confirm(confirm_msg)) {
        document.location.href = path_root + 'repurchase/removeItem/' + id;
    }
}

function update_cart_item(id, e) {
    var confirm_msg = $("#confirm_msg_update").html();
    var path_root = $("#path_root").val();
    var qnty = $(e).closest('tr').find('td:nth-child(3) input').val();
    if (confirm(confirm_msg)) {
        document.location.href = path_root + 'repurchase/updateItem/' + id + "/" + qnty;
    }
}

function reopen_ticket(id) {
    var confirm_msg = $("#confirm_msg1").html();
    var path_root = $("#path_root").val();
    if (confirm(confirm_msg)) {
        document.location.href = path_root + 'user/ticket/ticket_system/tab4/reopen/' + id;
    }
}

function show_timeline_for_user(id) {
    var path_root = $("#path_root").val();
    document.location.href = path_root + 'user/ticket/ticket_time_line/' + id;
}

function allocate_user(id, root) {
    document.location.href = root + 'epin/allocate_user/' + id;
}

function view_earnings(id, from, root) {
    document.location.href = root + 'ewallet/my_ewallet?user_name=' + id + '&from_report=' + from;
}

function refund_pin(id, root) {
    document.location.href = root + 'epin/refund_epin/refund/' + id;
}