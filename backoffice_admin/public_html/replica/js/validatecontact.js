function validate_contact(feedback_add){ 
    
    var name = feedback_add.name.value;  
    var email = feedback_add.email.value;  
    var address = feedback_add.address.value;  
    var phone = feedback_add.phone.value;  
    var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;  
    if(name == "") {  
	inlineMsg('name','You must enter your name...',4);  
	return false;  
    }   
    if(email == "") {  
	inlineMsg('email','You must enter your email id...',4);  
	return false;  
    }  if(!email.match(emailRegex)) { 
	inlineMsg('email','You have entered an invalid email.',2);
	return false; 
    }    if(address == "") { 
	inlineMsg('address','You must enter your address...',4);
	return false; 
    }    
    if(phone == "") { 
	inlineMsg('phone','You must enter your phone number...',4); 
	return false; 
    }  
    return true;
}
