
var year_id;
var month_id;
var day_id;

function initializeYearMonthDay(id_year, id_month, id_day) {
    year_id = id_year;
    month_id = id_month;
    day_id = id_day;
    
    $('#' + year_id).append($('<option value="">Year</option>'));
    for (i = new Date().getFullYear(); i > 1900; i--) {
        $('#' + year_id).append($('<option />').val(i).html(i));
    }
    
    $('#' + month_id).append($('<option value="">Month</option>'));
    for (i = 1; i < 13; i++) {
        $('#' + month_id).append($('<option />').val(i).html(i));
    }
    updateNumberOfDays();

    $('#' + year_id + ', #' + month_id).on("change", function () {
        updateNumberOfDays();
    });
}

function updateNumberOfDays() {
    $('#' + day_id).html('');
    month = $('#' + month_id).val();
    year = $('#' + year_id).val();
    days = daysInMonth(month, year);

    $('#' + day_id).append($('<option value="">Day</option>'));
    for (i = 1; i < days + 1; i++) {
        $('#' + day_id).append($('<option />').val(i).html(i));
    }
}

function daysInMonth(month, year) {
    return new Date(year, month, 0).getDate();
}