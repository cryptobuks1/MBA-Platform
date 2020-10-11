var ValidatePayoutRelease = function() {
// function to initiate Validation Sample 1
    var msg1 = $("#error_msg").html();
    ///////----for 'CHANGE USER PASSWORD' Tab - Begin/////////
    var runValidatorUserSelection = function() {

        /*jQuery.validator.addMethod("alpha_dash", function(value, element) {
         return this.optional(element) || /^[a-z0-9A-Z]*$/i.test(value);
         }, msg6);*/
        $.validator.addMethod('release', function(value) {
            return $('.release:checked').size() > 0;
        }, '<font color="red">' + msg1 + '</font>');
        var searchform = $('#pending_reg');
        var checkboxes = $('.release');
        var checkbox_names = $.map(checkboxes, function(e, i) {
            return $(e).attr("name")
        }).join(" ");
        var errorHandler1 = $('.errorHandler', searchform);
        $('#pending_reg').validate({
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
        var details = $.parseJSON($('#details').val());
// function to initiate Validation Sample 1
	$('#user_detail_modal').on('shown.bs.modal', function (e) {
            
        var key = $(e.relatedTarget).data('key');
        setText('.user_name', details[key].user_name);
        setText('.sponsor_user_name', details[key].sponsor_user_name);
        setText('.sponsor_full_name', details[key].sponsor_full_name);
        setText('.package', details[key].package_name);
        setText('.first_name', details[key].first_name);
        setText('.last_name', details[key].last_name);
        setText('.gender', details[key].gender == 'M' ? 'Male' : 'Female');
        setText('.date_of_birth', details[key].date_of_birth);
        setText('.address_line1', details[key].address);
        setText('.address_line2', details[key].address_line2);
        setText('.country', details[key].country_name);
        setText('.state', details[key].state_name);
        setText('.city', details[key].city);
        setText('.zip_code', details[key].pin);
        setText('.email', details[key].email);
        setText('.mobile', details[key].mobile);
        setText('.landline', details[key].land_line);
        setText('.account_holder', details[key].acct_holder_name);
        setText('.bank_name', details[key].bank_name);
        setText('.branch_name', details[key].bank_branch);
        setText('.account_number', details[key].bank_acc_no);
        setText('.ifsc_code', details[key].ifsc);
        setText('.pan', details[key].pan_no);
    });

    $('.approve').on('click', function (e) {
        e.preventDefault();
        var status = confirm($('#msg1').text());
        if (status) {
            $(this).closest('form').submit();
        }
    });
    ValidatePayoutRelease.init();
});

function setText(element, value) {
    var text = value;
    if (!value) {
        text = 'NA';
    }
    $(element).text(text);
}   
function mym(image){
        document.getElementById("im").src = image;
        $("#EnSureModal").modal();
}

$('#check_all').click (function () {
        var checkBoxes = $(".release");
        var title = $('#check_all').html();
        checkBoxes.prop("checked", !checkBoxes.prop("checked"));        
});