function trim(a)
{

    return a.replace(/^\s+|\s+$/, '');
}

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

function getAllStates(country_id)
{
    if (country_id != '') {
        getPhoneCode(country_id);
        var root = document.form.path.value;
        var strURL = root + "replica/get_states/" + country_id;
        var req = getXMLHTTP();
        if (req) {
            req.onreadystatechange = function () {
                if (req.readyState == 4) {
                    if (req.status == 200) {
                        document.getElementById('state').innerHTML = trim(req.responseText);
                    } else {
                        alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("GET", strURL, true);
            req.send(null);
        }
    } else {
        var select_state = $("#select_state").html();
        document.getElementById('state').innerHTML = "<option value =''>" + select_state + "</option>";
    }
}
function getPhoneCode(country_id)
{
    if (country_id) {
        var root = document.form.path.value;
       // var strURL = root + "register/get_phone_code/" + country_id;
        var strURL = root + "home/get_phone_code/" + country_id;
        var req = getXMLHTTP();
        if (req) {
            req.onreadystatechange = function () {
                if (req.readyState == 4) {
                    if (req.status == 200) {
                        document.getElementById('mobile_code').value = trim(req.responseText);

                    } else {
                        alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("GET", strURL, true);
            req.send(null);
        }
    } else {
        document.getElementById('mobile_code').value = '';
    }
}

function getCity(countryId, stateId)
{
    var strURL = "findCity1.php?country=" + countryId + "&state=" + stateId;
    var req = getXMLHTTP();

    if (req) {

        req.onreadystatechange = function () {
            if (req.readyState == 4) {
                if (req.status == 200) {
                    document.getElementById('citydiv').innerHTML = req.responseText;
                } else {
                    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                }
            }
        }
        req.open("GET", strURL, true);
        req.send(null);
    }

}

function getUser(pin)
{
    var strURL = "ajax/getUser.php?pin=" + pin;
    var req = getXMLHTTP();

    if (req) {

        req.onreadystatechange = function () {
            if (req.readyState == 4) {
                if (req.status == 200) {
                    var user_name = trim(req.responseText);
                    document.form.username.value = user_name;
                } else {
                    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                }
            }
        }
        req.open("GET", strURL, true);
        req.send(null);
    }

}

function setSessionData(party_id)
{
    var path_root = $("#path_root").val();
    document.location.href = path_root + '/myparty/setSessionDataa/' + party_id;
}

function getAllStatess(country_code) {
    var root = $("#path_root").val();
    var strURL = root + "/party/get_states/" + country_code;
    var req = getXMLHTTP();

    if (req) {

        req.onreadystatechange = function () {
            if (req.readyState == 4) {
                if (req.status == 200) {
                    document.getElementById('state').innerHTML = trim(req.responseText);
                    document.getElementById('state').style.display = '';
                } else {
                    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                }
            }
        }
        req.open("GET", strURL, true);
        req.send(null);
    }
}

function getAllStates(country_id)
{
    if (country_id != '') {
        getPhoneCode(country_id);
        var root = document.form.path.value;
        //var strURL = root + "register/get_states/" + country_id;
        var strURL = root + "home/get_states/" + country_id;
        var req = getXMLHTTP();
        if (req) {
            req.onreadystatechange = function () {
                if (req.readyState == 4) {
                    if (req.status == 200) {
                        document.getElementById('state').innerHTML = trim(req.responseText);
                    } else {
                        alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("GET", strURL, true);
            req.send(null);
        }
    } else {
        var select_state = $("#select_state").html();
        document.getElementById('state').innerHTML = "<option value =''>" + select_state + "</option>";
    }
}



function getAllStatessNewAdd(country_code)
{
    var root = $("#path_root").val();
    var strURL = root + "/party/get_statesAdd/" + country_code;
    var req = getXMLHTTP();

    if (req) {

        req.onreadystatechange = function () {
            if (req.readyState == 4) {
                if (req.status == 200) {
                    document.getElementById('new_state').innerHTML = trim(req.responseText);
                    document.getElementById('new_state').style.display = '';
                } else {
                    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                }
            }
        }
        req.open("GET", strURL, true);
        req.send(null);
    }
}

function getCity(countryId, stateId)
{
    var strURL = "findCity1.php?country=" + countryId + "&state=" + stateId;
    var req = getXMLHTTP();

    if (req) {

        req.onreadystatechange = function () {
            if (req.readyState == 4) {
                if (req.status == 200) {
                    document.getElementById('citydiv').innerHTML = req.responseText;

                } else {
                    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                }
            }
        }
        req.open("GET", strURL, true);
        req.send(null);
    }

}


function getUser(pin)
{
    var strURL = "ajax/getUser.php?pin=" + pin;
    var req = getXMLHTTP();

    if (req) {

        req.onreadystatechange = function () {
            if (req.readyState == 4) {
                if (req.status == 200) {
                    var user_name = trim(req.responseText);
                    document.form.username.value = user_name;
                } else {
                    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                }
            }
        }
        req.open("GET", strURL, true);
        req.send(null);
    }

}
function getAllStatess(country_code)
{
    var root = $("#path_root").val();
    var strURL = root + "/party/get_states/" + country_code;
    var req = getXMLHTTP();

    if (req) {

        req.onreadystatechange = function () {
            if (req.readyState == 4) {
                if (req.status == 200) {
                    document.getElementById('state').innerHTML = trim(req.responseText);
                    document.getElementById('state').style.display = '';
                } else {
                    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                }
            }
        }
        req.open("GET", strURL, true);
        req.send(null);
    }
}