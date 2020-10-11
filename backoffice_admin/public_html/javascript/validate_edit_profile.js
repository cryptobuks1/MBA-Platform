$(function() {
    var base_url = $("#base_url").val();
    $.ajax({
        url: base_url + getUserType() + '/profile/getEditImages',
        dataType: 'json',
        cache: false,
        type: 'post',
        success: function(data) {
            if (data) {
                $('#fileLabel1').text(data.user_banner);
                if (data.user_image != 'na') {
                    $('#fileLabel2').text(data.user_image);
                }
            }
        },
        error: function(data) {
            console.log(data);

        }
    });
    $("#file1,#file2").change(function() {
        if (this.value == "") {
            return;
        } else {
            var theSplit = this.value.split('\\');
            $(this).next('label').text(theSplit[theSplit.length - 1]);
        }
    });
});