/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


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

function getAllStates(country_id, user_type) {
    getPhoneCode(country_id);
    var base_url = document.getElementById('base_url').value;
    var root = base_url + user_type;
    var strURL = root + "/profile/get_states/" + country_id;
    var req = getXMLHTTP();

    if (req) {

        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                if (req.status == 200) {
                    document.getElementById('prof_state_div').innerHTML = trim(req.responseText);
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

        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                // only if "OK"
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

        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                // only if "OK"

                if (req.status == 200) {


                    var user_name = trim(req.responseText);

                    document.user_register.username.value = user_name;
                } else {
                    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                }
            }
        }
        req.open("GET", strURL, true);
        req.send(null);
    }

}
//window.onload = function() {
//    var country = document.searchform.cur_country.value;
//    if (country == "India")
//    {
//        // document.getElementById('state_div').style.display='';
//        //     document.getElementById('statediv1').style.display='';
//        //  document.getElementById('locationdiv').style.display='none';
//    }
//    else
//    {
//        //  document.getElementById('state_div').style.display='none';
//        //  document.getElementById('statediv1').style.display='none';
//        //  document.getElementById('locationdiv').style.display='';
//    }
//}

function getPhoneCode(country_id)
{
    if (country_id) {
        var base_url = document.getElementById('base_url').value;
        var strURL = base_url + "register/get_phone_code/" + country_id;
        var req = getXMLHTTP();
        if (req) {
            req.onreadystatechange = function() {
                if (req.readyState == 4) {
                    if (req.status == 200) {
                        document.getElementById('mobile_code').value = trim(req.responseText);
                        $('#mcode').text($('#mobile_code').val());
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
