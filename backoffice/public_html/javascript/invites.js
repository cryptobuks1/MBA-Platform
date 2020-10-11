  
    
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
    
    
    
    function getMessage(message_id,path_root)
{  
    
    getSubject(message_id,path_root);
    
	var strURL = path_root + "user/member/get_message/" + message_id ;
	var req = getXMLHTTP();

	if (req) {

	    req.onreadystatechange = function() {
                
		if (req.readyState == 4) {
		    // only if "OK"                  
		    if (req.status == 200) {                        
			document.getElementById('message').innerHTML = req.responseText;
			
		    } else {
			alert("There was a problem while using XMLHTTP:\n" + req.statusText);
		    }
		}
	    }
	    req.open("GET", strURL, true);
	    req.send(null);
	}
    
}

function getSubject(message_id,path_root)
{
    
    var strURL = path_root + "user/member/get_subject/" + message_id;
    var req = getXMLHTTP();

    if (req) {

	req.onreadystatechange = function() {
	    if (req.readyState == 4) {

		if (req.status == 200) {
		    document.getElementById('subject').value = trim(req.responseText);
		} else {
		    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
		}
	    }
	}
	req.open("GET", strURL, true);
	req.send(null);
    }
}