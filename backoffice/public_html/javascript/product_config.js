$('.panel-default').find('.next_button').on("click", function() {
   if (!$('#form').valid()) return false;

   $('.panel.add_prod:last').find('.next_button').attr('type', 'submit');
    $('.panel.add_prod:last').find('.next_button').text($("#confirm").html()); 

    var element = $(this).closest('.panel');
    element.next().show();
    $('html, body').animate({
        scrollTop: (element.offset().top + element.outerHeight() - 50)
    },500);
});

$('.panel-default').find('.previous_button').on("click", function() {
    var element = $(this).closest('.panel');
    $('html, body').animate({
        scrollTop: (element.prev().offset().top - 70)
    },500);
});