var $border_color = "#efefef";
var $grid_color = "#ddd";
var $default_black = "#666";
var $primary = "#575348";
var $secondary = "#A4DB79";
var $orange = "#F38733";

// Dropdown Menu
// $( document ).ready(function() {
	// $('#menu > ul > li > a').click(function() {
		// $('#menu li').removeClass('active');
		// $(this).closest('li').addClass('active'); 
		// var checkElement = $(this).next();
		// if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
			// $(this).closest('li').removeClass('active');
			// checkElement.slideUp('normal');
		// }
		// if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
			// $('#menu ul ul:visible').slideUp('normal');
			// checkElement.slideDown('normal');
		// }
		// if($(this).closest('li').find('ul').children().length == 0) {
			// return true;
		// } else {
			// return false; 
		// }   
	// });
// });



// Menu alternative function

$(function() {
  $('#has-sub.active .sub-menu').slideDown();
  $('.main-container').css('min-height', $('#menu').height());

  $('#has-sub > a').click(function() {
    $(this).parent().find('.sub-menu').slideToggle('slow');
    $(this).parent().toggleClass('active').removeClass('highlight').siblings().removeClass('active').find('.sub-menu').slideUp('slow');
    setTimeout(function () {
      $('.main-container').css('min-height', $('#menu').height());
    }, 1000);
  });
});



// Mobile Nav
$('#mob-nav').click(function(){
	if($('aside.open').length > 0){
		$( "aside" ).animate({left: "-320px" }, 500 ).removeClass('open');
	} else {
		$( "aside" ).animate({left: "0px" }, 500 ).addClass('open');
	}
});

// Tooltips
// $('a').tooltip('hide');

// Slide Bars
$(function() {
  $(document).ready(function() {
    //$.slidebars();//unc
  });
});

//Date Range Picker
$(document).ready(function() {
  $('.reportrange').daterangepicker({
    startDate: moment().subtract('days', 29),
    endDate: moment(),
    minDate: '01/01/2010',
    maxDate: '12/31/2015',
    dateLimit: { days: 60 },
    showDropdowns: true,
    showWeekNumbers: true,
    timePicker: false,
    timePickerIncrement: 1,
    timePicker12Hour: true,
    ranges: {
      'Today': [moment(), moment()],
      'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
      'Last 7 Days': [moment().subtract('days', 6), moment()],
      'Last 30 Days': [moment().subtract('days', 29), moment()],
      'This Month': [moment().startOf('month'), moment().endOf('month')],
      'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
    },
    opens: 'left',
    buttonClasses: ['btn btn-success'],
    applyClass: 'btn-small btn-default',
    cancelClass: 'btn-small',
    format: 'MM/DD/YYYY',
    separator: ' to ',
    locale: {
      applyLabel: 'Submit',
      fromLabel: 'From',
      toLabel: 'To',
      customRangeLabel: 'Custom Range',
      daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
      monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      firstDay: 1
    }
  },
  function(start, end) {
    console.log("Callback has been called!");
    $('.reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  });
  //Set the initial state of the picker label
  $('.reportrange span').html(moment().subtract('days', 29).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
});
