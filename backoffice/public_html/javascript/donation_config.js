/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    var msg1 = $("#error_msg9").html();
    var msg2 = $("#error_msg10").html();
    var msg3 = $("#error_msg11").html();
    var msg4 = $("#error_msg12").html();
    var msg5 = $("#error_msg13").html();
    var msg6 = $("#error_msg14").html();
    var msg7 = $("#error_msg15").html();
    jQuery.validator.addMethod("notEqualToGroup", function (value, element, options) {
        // get all the elements passed here with the same class
        var elems = $(element).parents('form').find(options[0]);
        // the value of the current element
        var valueToCompare = value;
        // count
        var matchesFound = 0;
        // loop each element and compare its value with the current value
        // and increase the count every time we find one
        jQuery.each(elems, function () {
            thisVal = $(this).val();
            if (thisVal == valueToCompare) {
                matchesFound++;
            }
        });
        // count should be either 0 or 1 max
        if (this.optional(element) || matchesFound <= 1) {
            //elems.removeClass('error');
            return true;
        } else {
            //elems.addClass('error');
        }
    },jQuery.validator.format(msg4));
    $('#donation_form').validate({ // initialize the plugin

    });
    $('.level_name').each(function () {
        $(this).rules('add', {
            required: true,
            maxlength: 15,
            notEqualToGroup: ['.level_name'],
            messages: {
                required: msg1
            }
        });
    });
    $('.donation_rate').each(function () {
        $(this).rules('add', {
            required: true,
            number: true,
            maxlength: 10,
            messages: {
                required: msg2,
                maxlength: msg6
            }
        });
    });
    $('.donation_count').each(function () {
        $(this).rules('add', {
            required: true,
            maxlength: 5,
            number: true,
            messages: {
                required: msg3,
                maxlength: msg7
            }
        });
    });
    var msg = $("#error_msg7").html();
    $(".donation_rate").keypress(function (e)
    {
        if (e.which == 46) {
            if ($(this).val().indexOf('.') > 0) {
                $("#errmsgg9").html(msg).show().fadeOut(1200, 0);
                return false;
            }
        }

        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
        {
            $(this).next().html(msg).css('display', 'block').fadeOut(1200, 0);
            return false;
        }
    });
    $(".donation_count").keypress(function (e)
    {
        if (e.which == 46) {
            if ($(this).val().indexOf('.') > 0) {
                $("#errmsgg10").html(msg).show().fadeOut(1200, 0);
                return false;
            }
        }

        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
        {
            $(this).next().html(msg).css('display', 'block').fadeOut(1200, 0);
            return false;
        }
    });

}());
function activate_prod(id) {

        var confirm_msg = "Are you sure, you want to Approve this Donation ? There is NO undo! ??";
        var path_root = $("#path_root").val();
        if (confirm(confirm_msg))
        {
            document.location.href = path_root + 'admin/donation/accept_donation_admin/' + id;
        }

    }
