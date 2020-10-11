function getAllStatess(country_code)
{
    //alert(country_code);
    var root =document.create_host.path_root.value
    //var lang_id =document.create_host.lang_id.value
    //alert(root);
    var strURL=root+"/party/get_states/"+country_code;
    var req = getXMLHTTP();
		
    if (req) {
			
        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                // only if "OK"
                if (req.status == 200) {
                    //alert(trim(req.responseText));
                    document.getElementById('state1').innerHTML=trim(req.responseText);
                    document.getElementById('state1').style.display='';
                } else {
                    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                }
            }				
        }			
        req.open("GET", strURL, true);
        //alert(strURL);
        req.send(null);
    }		
}


function edit_host(id) {
    var confirm_msg = "Sure, You want to edit this host?";
    var path_root = $("#path_root").val();
    if (confirm(confirm_msg)) {

        document.location.href = path_root + '/party/create_host/edit/' + id;

    }
}

function delete_host(id){

    var confirm_msg="Sure, You want to delete this host? ";
     var path_root=$("#path_root").val();
         if(confirm(confirm_msg)) {

        document.location.href=path_root+'/party/delete_host/delete/'+id;

    }

}

function edit_guest(id){
    var confirm_msg="Sure, You want to edit this guest?";
   var path_root=$("#path_root").val();
    if(confirm(confirm_msg))
    {

        document.location.href=path_root+'/party/create_guest/edit/'+id;

    }
}


function delete_guest(id)
{

    var confirm_msg="Sure, You want to delete this guest? ";
     var path_root=$("#path_root").val();
    if(confirm(confirm_msg))

    {

        document.location.href=path_root+'/party/delete_guest/delete/'+id;

    }
}


