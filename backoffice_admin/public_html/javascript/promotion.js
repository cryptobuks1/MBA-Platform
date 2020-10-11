$(function () {
    $(".banner_inv").click(function () {
        var id = $(this).attr('id');
        var v = $("#banner" + id).val();
        var dummy = $('<input>').val(v).appendTo('body').select();

        try {
            document.execCommand("copy", false, null);
        } catch (e) {
            window.prompt("Copy to clipboard: Ctrl C, Enter", v);
        }
        dummy.remove();
        $('#banner_inv').fadeIn().delay(2000).fadeOut();
    });
    $(".text_inv").click(function () {
        var id = $(this).attr('id');
        var v = $("#text" + id).val();
        var dummy = $('<input>').val(v).appendTo('body').select();
        try {
            document.execCommand("copy", false, null);
        } catch (e) {
            window.prompt("Copy to clipboard: Ctrl C, Enter", v);
        }
        dummy.remove();
        $('#text_inv').fadeIn().delay(2000).fadeOut();
    });
});