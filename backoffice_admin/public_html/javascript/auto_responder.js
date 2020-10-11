function edit_auto_respnder(id)
{
    var confirm_msg = $("#validate_msg5").html();
    var path_root = $("#path_root").val();
//    if (confirm(confirm_msg))
//
//    {

        document.location.href = path_root + 'auto_responder/auto_responder_settings/edit/' + id;

//    }

}
function delete_auto_respnder(id)

{
//alert('4444');
    var confirm_msg = $("#validate_msg6").html();
    var path_root = $("#path_root").val();
    if (confirm(confirm_msg))

    {

        document.location.href = path_root + 'auto_responder/auto_responder_settings/delete/' + id;

    }



}

function auto_respnder_details(id)

{
//alert('4444');
    var confirm_msg = $("#validate_msg6").html();
    var path_root = $("#path_root").val();    

        document.location.href = path_root + 'auto_responder/read_mail/' + id;

}

function edit_getting_started(id)

{
//alert('4444');
    var confirm_msg =  $("#validate_msg5").html();
    var path_root = $("#path_root").val();
    if (confirm(confirm_msg))

    {

        document.location.href = path_root + 'configuration/getting_started/edit/' + id;

    }



}
function delete_getting_started(id)

{
//alert('4444');
    var confirm_msg =$("#validate_msg6").html();
    var path_root = $("#path_root").val();
    if (confirm(confirm_msg))

    {

        document.location.href = path_root + 'configuration/getting_started/delete/' + id;

    }



}