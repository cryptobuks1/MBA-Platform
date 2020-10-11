
var ValidatePendingRepurchase = function() {
// function to initiate Validation Sample 1
    var msg1 = $("#error_msg").html();
    ///////----for 'CHANGE USER PASSWORD' Tab - Begin/////////
    var runValidatorUserSelection = function() {

        /*jQuery.validator.addMethod("alpha_dash", function(value, element) {
         return this.optional(element) || /^[a-z0-9A-Z]*$/i.test(value);
         }, msg6);*/
        $.validator.addMethod('approval', function(value) {
            return $('.approval:checked').size() > 0;
        }, '<font color="red">' + msg1 + '</font>');
        var searchform = $('#pending_order');
        var checkboxes = $('.approval');
        var checkbox_names = $.map(checkboxes, function(e, i) {
            return $(e).attr("name")
        }).join(" ");
        var errorHandler1 = $('.errorHandler', searchform);
        $('#pending_order').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter($(element).closest('.checkbox'));
//                error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            groups: {
                checks: checkbox_names
            },
            rules: {
                checkbox_name: {
                    required: true
                }
            },
            messages: {
                checkbox_name: {required: msg1}

            },
            invalidHandler: function(event, validator) { //display error alert on form submit
                errorHandler1.show();
            },
            highlight: function(element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function(element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function(label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                //$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            }
        });
    };
    
        return {
        //main function to initiate template pages
        init: function() {
            runValidatorUserSelection();
        }
    };
}();
$(function () {
    ValidatePendingRepurchase.init();
});
function mym(image){
        document.getElementById("im").src = image;
        $("#EnSureModal").modal();
}

$('#check_all').click (function () {
        var checkBoxes = $(".approval");
        var title = $('#check_all').html();
        checkBoxes.prop("checked", !checkBoxes.prop("checked"));        
});
$('.approve').on('click', function (e) {
        e.preventDefault();
        var status = confirm($('#msg1').text());
        if (status) {
            $(this).closest('form').submit();
        }
    }); 