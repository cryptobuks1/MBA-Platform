function getSwitchLanguage(lang) {
    var url = "";
    var base_url = $("#base_url").val();
    var current_url = $("#current_url").val();
    var current_url_full = $("#current_url_full").val();

    if (current_url != current_url_full) {
        url = current_url_full;
    } else {
        url = current_url;
    }
    var redirect_url = base_url;

    redirect_url = base_url + lang + "/" + url;

    document.location.href = redirect_url;
}