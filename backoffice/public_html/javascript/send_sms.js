$(document).ready(function()
    {

        //var path_temp = $("#path_temp").val();
        var path_root =$("#path_root").val();
	
        $("#individual").change(function()
        {
			
            //check the username exists or not from ajax
            $.post(path_root+"sms/find_number",{
                id:$(this).val()
            } ,function(data)
{
                document.getElementById('numbers').value=trim(data);	
            });

        });
	
        $("#fromid").change(function()
        {

            //check the username exists or not from ajax
            $.post(path_root+"sms/find_numbers",{
                from:$('#fromid').val(),
                to:$('#toid').val(),
                rand:Math.random()
            } ,function(data)
{
                document.getElementById('numbers').value=trim(data);	
            });

        });
	
        $("#toid").change(function()
        {

            //check the username exists or not from ajax
            $.post(path_root+"sms/find_numbers",{
                from:$('#fromid').val(),
                to:$('#toid').val(),
                rand:Math.random()
            } ,function(data)
{
                document.getElementById('numbers').value=trim(data);	
            });

        });
	
	
	
        $("#send_sms").submit(function()
        {
            var c_value = "";
            var numbers = $("#numbers").val();
            var word_count = $("#word_count").val();
		
            var error=1;
            if(numbers == "") {
                var msg;
                msg=$("#validate_msg7").html();
                inlineMsg('numbers',msg,4);
                error=0;
            }
            if(word_count == "") {
                var msg;
                msg=$("#validate_msg6").html();
                inlineMsg('word_count',msg,4);
                error=0;
            }
  
            for (var i=0; i < document.send_sms.selectall.length; i++)

            {

                    if (document.send_sms.selectall[i].checked)

                    {
                        c_value = c_value + document.send_sms.selectall[i].value + "\n";

                    }

                }



            if(!c_value)

            {
                
                var msg;
                msg=$("#validate_msg2").html();
                inlineMsg('distributor',msg,4);

        

                return false;

            }

  
            if(error==1)
            {	
                $("#sendmsg").removeClass().addClass('messageboxsms').text('Initiating....').fadeIn(1000);
                //check the username exists or not from ajax
                disablesms();
                $.post(path_root+"sms/ajax_sms",{
                    numbers:$('#numbers').val(), 
                    sms_count:$('#sms_count').val(), 
                    word_count:$('#word_count').val(),
                    rand:Math.random()
                } ,function(data)
{
                    //$sent_count=substr($sms,4,(strlen($sms)-4));
                    //$sent_status=substr($sms,0,3);
                    data=trim(data);
                    var len=data.length;
                    var sent_count =data.substring(4,(len-4));
                    var sent_status=data.substring(0,3);
                    if(trim(sent_status)==402) //if correct login detail
                    {
                        $("#sendmsg").fadeTo(200,0.1,function()  //start fading the messagebox
                        {  
                            var msg = $("#error_msg13").html();
                            //add message and change the class of the box and start fading
                            $(this).html(msg).addClass('messageboxsmsok').fadeTo(900,1,
                                function()
                                { 
                                    enablesms();
                                    //redirect to secure page
                                    alert(msg);
                                    document.location='index.php';
                                });
			  
                        });
                    }
                    else if(trim(sent_status)==401)
                    {
                        $("#sendmsg").fadeTo(200,0.1,function() //start fading the messagebox
                        { 
                            var msg = $("#error_msg12").html();
                            //add message and change the class of the box and start fading
                            $(this).html(msg).addClass('messageboxsmserror').fadeTo(900,1);
                            enablesms();
                            //redirect to secure page
                            alert(msg);
                            document.location='index.php';
                        });		
                    }
                    else if(trim(sent_status)==405)
                    {
                        $("#sendmsg").fadeTo(200,0.1,function() //start fading the messagebox
                        { 
                             var msg = $("#error_msg11").html();
                            //add message and change the class of the box and start fading
                            $(this).html(msg).addClass('messageboxsmserror').fadeTo(900,1);
                            enablesms();
                            //redirect to secure page
                            alert(msg);
                            document.location='index.php';
                        });		
                    }
                    else if(trim(sent_status)==406)
                    {
                        $("#sendmsg").fadeTo(200,0.1,function() //start fading the messagebox
                        { 
                            var msg = $("#error_msg10").html();
                            //add message and change the class of the box and start fading
                            $(this).html(msg).addClass('messageboxsmserror').fadeTo(900,1);
                            enablesms();
                            //redirect to secure page
                            alert(msg);
                            document.location='index.php';
                        });		
                    }
                    else if(trim(sent_status)==407)
                    {
                        $("#sendmsg").fadeTo(200,0.1,function() //start fading the messagebox
                        { 
                            var msg = $("#error_msg9").html();
                            //add message and change the class of the box and start fading
                            $(this).html(msg).addClass('messageboxsmserror').fadeTo(900,1);
                            enablesms();
                            //redirect to secure page
                            alert(msg);
                            document.location='index.php';
                        });		
                    }
                    else if(trim(sent_status)==403)
                    {
                        $("#sendmsg").fadeTo(200,0.1,function() //start fading the messagebox
                        { 
                            var msg = $("#error_msg8").html();

                            //add message and change the class of the box and start fading
                            $(this).html(msg).addClass('messageboxsmserror').fadeTo(900,1);
                            enablesms();
                            //redirect to secure page
                            alert(msg);
                            document.location='../';
                        });		
                    }
                    else if(trim(sent_status)==413)
                    {
                        $("#sendmsg").fadeTo(200,0.1,function() //start fading the messagebox
                        { 
                             var msg = $("#error_msg7").html();
                            //add message and change the class of the box and start fading
                            $(this).html(msg).addClass('messageboxsmserror').fadeTo(900,1);
                            enablesms();
                            //redirect to secure page
                            alert(msg);
                            document.location='index.php';
                        });		
                    }
				
                    else if(trim(sent_status)==404)
                    {
                        $("#sendmsg").fadeTo(200,0.1,function() //start fading the messagebox
                        { 
                            var msg = $("#error_msg6").html();
                            //add message and change the class of the box and start fading
                            $(this).html(msg).addClass('messageboxsmserror').fadeTo(900,1);
                            enablesms();
                            //redirect to secure page
                            alert(msg);
                            document.location='index.php';
                        });		
                    }
                });
		
            }
            else
            {
                return false;
            }
		
		
            //	}
            return false; //not to post the  form physically
        });
	
	
	
	
        $('#word_count').wordCount();
        //alternatively you can use the below method to display count in element with id word_counter  
        //$('#word_count').wordCount({counterElement:"word_counter"});

	
	
        $("#numbers").keypress(function (e)  
        {
            var msg = $("#error_msg5").html();
            //if the letter is not digit then display error and don't type anything
            if( e.which!=8 && e.which!=0 &&  (e.which<48 || e.which>57))
            {
                //display error message
                $("#errmsg").html(msg).show().fadeOut(1200,0); 
                return false;
            }	
        });


   
    });


	
function trim(s)
{
    return s.replace(/^\s+|\s+$/,'');
}
	
	
	
 
