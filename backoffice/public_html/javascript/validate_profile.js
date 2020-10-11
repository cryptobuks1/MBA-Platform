function trim(a)
{
    return a.replace(/^\s+|\s+$/,'');
}

function validate_profile_report(searchform)
{
    var user_name = searchform.user_name.value;

    var msg = "";
    if(user_name=="")
    {
        msg = $("#error_msg").html();
        inlineMsg('user_name',msg,2);
        return false;
    }
    return true;
  
}
function validate_profile_reports(searchform)
{	
    var week_date1 = searchform.week_date1.value;
    var msg = "";
	
    if(week_date1=="")
    {
        msg = $("#error_msg1").html();
        inlineMsg('week_date1',msg,2);
        return false;
    }
	
    return true;
}	
function validate_profile_reports_ewallet_request1(searchform)
{	
    
    var week_date1 = searchform.week_date1.value;
    var week_date2 = searchform.week_date2.value;
    var msg = "";
	
    if(week_date1=="")
    {
        msg = $("#error_msg1").html();
        inlineMsg('week_date1',msg,2);
        return false;
    }
    if(week_date2=="")
    {
        msg = $("#error_msg1").html();
        inlineMsg('week_date2',msg,2);
        return false;
    }
	
    if(week_date1 > week_date2) 
    {
        msg=$("#errmsg4").html();
        inlineMsg('jscal_trigger_Month1',msg,2);
        return false;
    }
    return true;
}	

function validate_profile_reportss(searchform)
{	
    var week_date2 = searchform.week_date2.value;
    var msg = "";
    if(week_date2=="")
    {
        msg = $("#error_msg1").html();
        inlineMsg('week_date2',msg,2);
        return false;
    }
	
    return true; 
}
function validate_profile_reports_ewallet_request2(searchform)
{	
    var week_date3 = searchform.week_date3.value;
    var week_date4 = searchform.week_date4.value;
    var msg = "";
	
    if(week_date3=="")
    {
        msg = $("#error_msg1").html();
        inlineMsg('week_date3',msg,2);
        return false;
    }
    if(week_date4=="")
    {
        msg = $("#error_msg1").html();
        inlineMsg('week_date4',msg,2);
        return false;
    }
    if(week_date3 > week_date4) 
    {
        msg=$("#errmsg4").html();
        inlineMsg('jscal_trigger_Month3',msg,2);
        return false;
    }
    return true;
}

function validate_weekly_transfer(weekly_payout)
{
    if(document.weekly_payout.user_name)
    {
        var user_name = weekly_payout.user_name.value;
    }
    var week_date1 = weekly_payout.week_date1.value;
    var week_date2 = weekly_payout.week_date2.value;
    var msg = "";
    
    if(user_name=="")
    {
        msg = $("#error_msg1").html();
        inlineMsg('user_name',msg,2);
        return false;
    }
    
    if(week_date1=="")
    {
        msg = $("#error_msg2").html();
        inlineMsg('jscal_trigger_Month1',msg,2);
        return false;
    }
    
    if(week_date2=="")
    {
        msg = $("#error_msg2").html();
        inlineMsg('jscal_trigger_Month2',msg,2);
        return false;
    }
	
    if(week_date2 < week_date1)
    {
        msg = $("#error_msg3").html();
        inlineMsg('jscal_trigger_Month2',msg,2);
        return false;
    }
    return true; 
}

function validate_daily_transfer(daily_transfer)
{
    if(document.daily_transfer.user_name1)
    {
        var user_name1 = daily_transfer.user_name1.value;
    }
    var week_date3 = daily_transfer.week_date3.value;	  
    var msg = "";
    if(user_name1=="")
    {
        msg = $("#error_msg1").html();
        inlineMsg('user_name1',msg,2);
        return false;
    }
    
    if(week_date3=="")
    {
        msg = $("#error_msg2").html();
        inlineMsg('jscal_trigger_Month3',msg,2);
        return false;
    }	
    return true;
}
function validate_profile_report2(from_to_form)
{
    var numberRegex = /^[0-9]+/;
    var count_from = from_to_form.count_from.value;
    var count_to = from_to_form.count_to.value;
    var msg = "";
    if(count_from=="")
    {
        msg = $("#error_msg4").html();
        inlineMsg('count_from',msg,2);
        return false;
    }
    if(!count_from.match(numberRegex))
    {       
        msg = $("#error_msg9").html();
        inlineMsg('count_from',msg,4);
        return false;
    }
    if(count_to=="")
    {
        msg = $("#error_msg5").html();
        inlineMsg('count_to',msg,2);
        return false;
    }
    if(!count_to.match(numberRegex))
    {
        msg = $("#error_msg9").html();
        inlineMsg('count_to',msg,4);
        return false;
    }
    return true;
}
function validate_profile_report1(searchform1)
{
    var numberRegex = /^[0-9]+/;
    var count = searchform1.count.value;
    var msg = "";
    if(count=="")
    {
        msg = $("#error_msg3").html();
        inlineMsg('count',msg,2);
        return false;
    }
    if(!count.match(numberRegex))
    {
        msg = $("#error_msg9").html();
        inlineMsg('count',msg,4);
        return false;
    }
    return true;
}
	
