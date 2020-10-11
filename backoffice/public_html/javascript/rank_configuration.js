
    $(function() {
        $('#joinee_pck').on('change', function() {
            var check = $('#joinee_pck').val();
            if (this.checked) {
                $('.disable_check').prop('checked', false);
                $('#joinee_rank_view').show();
                 $("#rank_criteria,#rank_criteria1").hide();
            } else {
                 $("#rank_criteria,#rank_criteria1").show();
                 $('#joinee_rank_view').hide();
            }
        });
        $("#joinee_pck").change();
        $('.colorpik').colorpicker();
       
    });