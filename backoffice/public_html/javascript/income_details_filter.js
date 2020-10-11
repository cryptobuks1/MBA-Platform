$(function(){
    
    $('.filter_date li a').on( 'click', function(){
        
        var filter = {
            
            date: $(this).data('value')
        };
        submit_with_filter(filter);
    });
    $('.filter_clear button').on('click', function () {
        var filter = {
            clear: 'yes'
        };
        submit_with_filter(filter);
    });
    
})
function submit_with_filter(filter) {
    filter['filter'] = 'yes';
    $.ajax({
        
        'url': $('#filter_submit_url').val(),
        'type': "POST",
        'data': filter,
        'dataType': 'text',
        'success': function (data) {},
        'error': function (error) {},
        'complete': function () {
            window.location = $('#filter_submit_url').val();
        }
        
    });

}

