 $(function () {
     // Lead month Graph
    var data_day = [
        {
            label: "Accepted ",
            data: accepted_leads_day,
            points: { show: true, radius: 4},
            splines: { show: true, tension: 0.45, lineWidth: 3, fill: 0  }
        },
        {
            label: "Rejected ",
            data: rejected_leads_day,
            points: { show: true, radius: 4},
            splines: { show: true, tension: 0.45, lineWidth: 3, fill: 0  }
        },
        {
            label: "Ongoing ",
            data: ongoing_leads_day,
            points: { show: true, radius: 4}, 
            splines: { show: true, tension: 0.45, lineWidth: 3, fill: 0 }
        }
    ];
    var lead_month = $('#lead_month');
                
        var lead_month_options = [
            data_day,
            {
                colors: [ '#fad733','#7266ba','#23b7e5' ],
                series: { shadowSize: 2 },
                xaxis:{ font: { color: '#ccc' } },
                yaxis:{ font: { color: '#ccc' } },
                grid: { hoverable: true, clickable: true, borderWidth: 0, color: '#ccc' },
                tooltip: true,
                tooltipOpts: { content: '%s on %x is %y.1',  defaultTheme: false, shifts: { x: 0, y: 20 } }
              }
        ];
         uiLoad.load(jp_config['plot']).then(function () {
            lead_month['plot'].apply(lead_month, lead_month_options);
        });

// Lead year Graph
    var lead_year_data = [
        {
            label: "Accepted ",
            data: accepted_leads_month, 
            points: { show: true, radius: 4 } 
        },
        {
            label: "Rejected ",
            data: rejected_leads_month,
            points: { show: true, radius: 4}
        },
        {
            label: 'Ongoing ', 
            data: ongoing_leads_month,
            points: { show: true, radius:4 }, lines: { show: true, fill: true, fillColor: { colors: [{ opacity: 0.1 }, { opacity: 0.1}] } } 
        }
    ];
       var lead_year = $('#lead_year');
                
        var lead_year_options = [
            lead_year_data,
            {
              colors: ['#fad733','#7266ba','#23b7e5'],
                series: { shadowSize: 3 },
                xaxis:{ 
                  font: { color: '#ccc' },
                  position: 'bottom',
                  ticks: [
                    [ 1, 'Jan' ], [ 2, 'Feb' ], [ 3, 'Mar' ], [ 4, 'Apr' ], [ 5, 'May' ], [ 6, 'Jun' ], [ 7, 'Jul' ], [ 8, 'Aug' ], [ 9, 'Sep' ], [ 10, 'Oct' ], [ 11, 'Nov' ], [ 12, 'Dec' ]
                  ]
                },
                yaxis:{ font: { color: '#ccc' } },
                grid: { hoverable: true, clickable: true, borderWidth: 0, color: '#ccc' },
                tooltip: true,
                tooltipOpts: { 
                    content : getTooltip,  defaultTheme: false, shifts: { x: 0, y: 20 } 
                 }
                }   
        ];
        uiLoad.load(jp_config['plot']).then(function () {
            lead_year['plot'].apply(lead_year, lead_year_options);
        });
});

    function getTooltip(label, x, y) {
                    if (x == 1) {
                        month = "Jan";
                    } else if (x == 2) {
                        month = "Feb";
                    } else if (x == 3) {
                        month = "Mar";
                    } else if (x == 4) {
                        month = "Apr";
                    } else if (x == 5) {
                        month = "May";
                    } else if (x == 6) {
                        month = "Jun";
                    } else if (x == 7) {
                        month = "Jul";
                    } else if (x == 8) {
                        month = "Aug";
                    } else if (x == 9) {
                        month = "Sep";
                    } else if (x == 10) {
                        month = "Oct";
                    } else if (x == 11) {
                        month = "Nov";
                    } else if (x == 12) {
                        month = "Dec";
                    }
                return "%s on "+month+" is  %y.1"; 
    }