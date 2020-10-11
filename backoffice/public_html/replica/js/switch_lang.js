function getSwitchLanguage(lang) {

    var site_url = $("#site_url").val();
    var current_url = $("#current_url").val();
    var url = current_url;
    var redirect_url = site_url + lang + "/" + url;

    document.location.href = redirect_url;

}