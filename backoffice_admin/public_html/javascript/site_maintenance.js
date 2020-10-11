/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    $(function () {
        $('#status').change();
        show_site_data($("#error").val());
    }());

    function show_site_data(status) {
        if (status == 1) {
            $("#site_data").show();
            $("#site_data2").hide();
        } else {
            $("#site_data").hide();
            $("#site_data2").show();
        }
    }

