/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function updateClock( )
{
    var currentTime = new Date( );
    var currentHours = currentTime.getHours( );
    var currentMinutes = currentTime.getMinutes( );
    var currentSeconds = currentTime.getSeconds( );

    // Pad the minutes and seconds with leading zeros, if required
    currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
    currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;

    // Choose either "AM" or "PM" as appropriate
    var timeOfDay = (currentHours < 12) ? "AM" : "PM";

    // Convert the hours component to 12-hour format if needed
    currentHours = (currentHours > 12) ? currentHours - 12 : currentHours;

    // Convert an hours component of "0" to "12"
    currentHours = (currentHours == 0) ? 12 : currentHours;

    // Compose the string for display
    var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;

    $("#clock").html(currentTimeString);

    var day = getDayName(currentTime.getDay());
    var date = currentTime.getDate();
    var month = getMonthName(currentTime.getMonth());
    var year = currentTime.getFullYear();

    var currentDateString = day + ", " + month + " " + date + ", " + year;

    $("#date").html(currentDateString);

}

function getDayName(day) {
    var weekday = new Array(7);
    weekday[0] = "Sunday";
    weekday[1] = "Monday";
    weekday[2] = "Tuesday";
    weekday[3] = "Wednesday";
    weekday[4] = "Thursday";
    weekday[5] = "Friday";
    weekday[6] = "Saturday";
    var name = weekday[day];
    return name;
}
function getMonthName(month) {
    var month_array = new Array();
    month_array[0] = "January";
    month_array[1] = "February";
    month_array[2] = "March";
    month_array[3] = "April";
    month_array[4] = "May";
    month_array[5] = "June";
    month_array[6] = "July";
    month_array[7] = "August";
    month_array[8] = "September";
    month_array[9] = "October";
    month_array[10] = "November";
    month_array[11] = "December";
    var name = month_array[month];
    return name;
}

$(document).ready(function()
{
    setInterval('updateClock()', 1000);

    serverClock();
});

//**************SERVER TIME Begin****************************
function serverClock( )
{
    if (document.getElementById("serverClock_input")) {
        var strTime = document.getElementById("serverClock_input").value;
        var strDate = document.getElementById("serverDate_input").value;
        arr = strTime.split(':');
        var currentTime = new Date( );
        var currentHours = parseInt(arr[0]);
        var currentMinutes = parseInt(arr[1]);
        var currentSeconds = parseInt(arr[2]);

        setInterval(function() {
            if (currentSeconds < 59) {
                currentSeconds++;
            } else {
                currentSeconds = 00;
                if (currentMinutes < 59) {
                    currentMinutes++;
                } else {
                    currentMinutes = 00;
                    currentHours++;
                    if (currentHours >= 24) {
                        currentHours = 00;
                    }
                }
            }

            var currentHours1 = currentHours;
            var currentMinutes1;
            var currentSeconds1;
            var timeOfDay = (currentHours < 12) ? "AM" : "PM";

            if (currentHours > 12) {
                currentHours1 = currentHours - 12;
            }
            if (currentHours == 00) {
                currentHours1 = 12;
            }
            currentMinutes1 = (currentMinutes < 10 ? "0" : "") + currentMinutes;
            currentSeconds1 = (currentSeconds < 10 ? "0" : "") + currentSeconds;
            var server_date = "Server Time : " + strDate;
            var server_clock = currentHours1 + ":" + currentMinutes1 + ":" + currentSeconds1 + " " + timeOfDay;
            $("#server_date").html(server_date);
            $("#server_clock").html(server_clock);
        }
        , 1000);
    }
}
//**************SERVER TIME end****************************
