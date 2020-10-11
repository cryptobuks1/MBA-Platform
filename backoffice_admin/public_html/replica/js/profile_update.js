
function change_day(e)
{
    var dob = document.form.date_of_birth.value;
    var day = e.value;
    var new_dob = dob.substr(0, 7);
    document.form.date_of_birth.value = new_dob + "-" + day;
}

function change_month(e)
{
    var dob = document.form.date_of_birth.value;
    var month = e.value;
    var year = dob.substr(0, 4);
    var day = dob.substr(7, 3);
    document.form.date_of_birth.value = year + "-" + month + day;
}

function change_year(e)
{

    var dob = document.form.date_of_birth.value;
    var year = e.value;
    var new_dob = dob.substr(4, 10);
    document.form.date_of_birth.value = year + new_dob;
}

function day_month(e) {
    var day = document.form.day.value;
    var year = document.form.year.value;
    var i = 1;
    var month = e.value;
    var month_day = new Array();
    var option = "";
    var j = 28;

    var d = new Date();
    var current_month = d.getMonth();
    var current_year = d.getFullYear();
    var current_day = d.getDate();
    option = option + "<option value=''>DD</option>";

    if (month == current_month)
    {
        for (i = current_day; i >= 1; i--) {
            var option_value = (i < 10) ? ("0" + i) : i;
            option = option + "<option value=" + option_value;
            if (day != "" && option_value == day)
            {
                option = option + " selected ";
            }
            option = option + ">" + option_value + "</option>";
        }
        document.getElementById('day').innerHTML = option;

    }
    else {
        if (month == '4' || month == '6' || month == '8' || month == '10' || month == '12' || month == '04' || month == '06' || month == '08')
        {

            for (i = 1; i <= 30; i++) {
                var option_value = (i < 10) ? ("0" + i) : i;
                option = option + "<option value=" + option_value;
                if (day != "" && option_value == day)
                    option = option + " selected ";
                option = option + ">" + option_value + "</option>";
            }
            document.getElementById('day').innerHTML = option;
        }
        else if (month == '2' || month == '02')
        {

            if (year % 4 == '0')
            {
                j = 29;
            }
            for (i = 1; i <= j; i++) {
                var option_value = (i < 10) ? ("0" + i) : i;
                option = option + "<option value=" + option_value;
                if (day != "" && option_value == day)
                    option = option + " selected ";
                option = option + ">" + option_value + "</option>";
            }
            document.getElementById('day').innerHTML = option;
        }
        else
        {

            for (i = 1; i <= 31; i++) {
                var option_value = (i < 10) ? ("0" + i) : i;
                option = option + "<option value=" + option_value;
                if (day != "" && option_value == day)
                    option = option + " selected ";
                option = option + ">" + option_value + "</option>";
            }
            document.getElementById('day').innerHTML = option;
        }


    }

}
function day_year(e) {
    var day = document.form.day.value;
    var month = document.form.month.value;
    var i = 1;
    var year = e.value;
    var month_day = new Array();
    var option = "";
    var option1 = "";
    var j = 28;
    var d = new Date();
    var current_month = d.getMonth();
    var current_year = d.getFullYear();
    var current_day = d.getDay();
    option = option + "<option value=''>DD</option>";
    option1 = option1 + "<option value=''>MM</option>";
    if (year == current_year)
    {
        for (i = current_month; i >= 1; i--) {
            var option_value = (i < 10) ? ("0" + i) : i;
            option1 = option1 + "<option value=" + option_value;
            if (day != "" && option_value == day)
                option1 = option1 + " selected ";
            option1 = option1 + ">" + option_value + "</option>";
        }

        document.getElementById('month').innerHTML = option1;
    }

    else {
        for (i = 1; i <= 12; i++) {
            var option_value = (i < 10) ? ("0" + i) : i;
            option1 = option1 + "<option value=" + option_value;
            if (day != "" && option_value == day)
                option1 = option1 + " selected ";
            option1 = option1 + ">" + option_value + "</option>";
        }
        document.getElementById('month').innerHTML = option1;
    }
    if (month == '04' || month == '06' || month == '09' || month == '11')
    {
        for (i = 1; i <= 30; i++) {
            var option_value = (i < 10) ? ("0" + i) : i;
            option = option + "<option value=" + option_value;
            if (day != "" && option_value == day)
                option = option + " selected ";
            option = option + ">" + option_value + "</option>";
        }
        document.getElementById('day').innerHTML = option;
    }
    else if (month == '02')
    {

        if (year % 4 == '0')
        {
            j = 29;
        }
        for (i = 1; i <= j; i++) {
            var option_value = (i < 10) ? ("0" + i) : i;
            option = option + "<option value=" + option_value;
            if (day != "" && option_value == day)
                option = option + " selected ";
            option = option + ">" + option_value + "</option>";
        }
        document.getElementById('day').innerHTML = option;
    }
    else
    {
        for (i = 1; i <= 31; i++) {
            var option_value = (i < 10) ? ("0" + i) : i;
            option = option + "<option value=" + i;
            if (day != "" && i == day)
                option = option + " selected ";
            option = option + ">" + i + "</option>";
        }
        document.getElementById('day').innerHTML = option;
    }

}

//validate crd
function expiry_month(e)
{
    var exm = document.form.card_expiry_date.value;
    month = e.value;
    var year = exm.substr(0, 4);
    //var day = dob.substr(7,3);
    document.form.card_expiry_date.value = year + "-" + month;


}

function expiry_year(e)
{
    var exm = document.form.card_expiry_date.value;
    year = e.value;
    var new_exm = exm.substr(4, 10);
    document.form.card_expiry_date.value = year + new_exm;

}