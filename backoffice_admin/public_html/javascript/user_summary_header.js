jQuery(document).ready(function() {
    var username = $("#username_val").html();
    var from_page = $("#from_page").val();
    var path = $("#page_path").html();
    if (from_page != 'link') {
        $("#user_account").load(path + "user_account/user_summary_header/" + username);
    }
});