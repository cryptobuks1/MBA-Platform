function getXMLHTTP() { //fuction to return the xml http object
    var xmlhttp = false;
    try {
        xmlhttp = new XMLHttpRequest();
    }
    catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (e) {
            try {
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
            }
            catch (e1) {
                xmlhttp = false;
            }
        }
    }

    return xmlhttp;
}
function switchCurrency(id) {
    var base_url = $("#base_url").val();
    var user_type = getUserType();
    var directory = (user_type == "user") ? "user" : "admin";
    var strURL = base_url + directory + "/currency/change_currency/" + id;
    var req = getXMLHTTP();
    if (req) {

        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                if (req.status == 200)
                {
                    location.reload();
                }
                else
                {

                }
            }
        }
        req.open("GET", strURL, true);
        req.send(null);
    }

}
function getThemeUrl(folder_name) {
    var baseurl = $("#baseurlhidden").val();
    var image = baseurl + "public_html/images/themes/" + folder_name + "/theme.png";
    $('#admin_theme').attr('src', image);
}
function getUserThemeUrl(folder_name) {
    var baseurl = $("#baseurlhidden").val();
    var image = baseurl + "public_html/images/themes/" + folder_name + "/usertheme.png";
    $('#user_theme').attr('src', image);
}

$('#symbol_type').on('change', function() {
    $('#symbol_div').show();
});
