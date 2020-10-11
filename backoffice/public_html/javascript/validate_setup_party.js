function validate_setup_party(setup_party) {
    var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
    if (setup_party.party_name.value == "") {
        inlineMsg('party_name', 'Enter the Party Name', 4);
        return false;
    }
    if (document.setup_party.host) {

    }
    if (document.getElementById('host1').checked) {
        if (setup_party.host_name.value == "") {
            inlineMsg('host_name', 'Select the Host Name', 4);
            return false;
        }
    } else if (document.getElementById('host').checked) {
        if (setup_party.host_country.value == "") {
            inlineMsg('host_country', 'Select the Country', 4);
            return false;
        }
        if (setup_party.first_name.value == "") {
            inlineMsg('first_name', 'Enter the First Name', 4);
            return false;
        }
        if (setup_party.last_name.value == "") {
            inlineMsg('last_name', 'Enter the last Name', 4);
            return false;
        }
        //           if(setup_party.company_name.value=="")
        //           {
        //              inlineMsg('company_name','Enter the Company Name',4);
        //              return false;
        //           }
        if (setup_party.host_address.value == "") {
            inlineMsg('host_address', 'Enter the Address', 4);
            return false;
        }

        if (setup_party.host_city.value == "") {
            inlineMsg('host_city', 'Enter the City', 4);
            return false;
        }
        if (setup_party.state.value == "") {
            inlineMsg('state', 'Select the State', 4);
            return false;
        }
        if (setup_party.host_zip.value == "") {
            inlineMsg('host_zip', 'Enter the Zip code', 4);
            return false;
        }
        if (setup_party.host_phone.value == "") {
            inlineMsg('host_phone', 'Enter the Phone Number', 4);
            return false;
        }
        if (setup_party.host_email.value == "") {
            inlineMsg('host_email', 'Enter the Email', 4);
            return false;
        }
        if (!setup_party.host_email.value.match(emailRegex)) {
            inlineMsg('host_email', 'You have entered an invalid  email...', 4);
            return false;
        }
    }

    if (setup_party.party_date.value == "") {
        inlineMsg('party_date', 'Enter the Start Date of Party', 4);
        return false;
    }
    if (setup_party.timepicker1.value == "") {
        inlineMsg('timepicker1', 'Enter the Start Time of Party', 4);
        return false;
    }
    if (setup_party.party_dateto.value == "") {
        inlineMsg('party_dateto', 'Enter the End Date of Party', 4);
        return false;
    }
    if (setup_party.party_dateto.value < setup_party.party_date.value) {
        inlineMsg('party_dateto', 'Please Select Correct from date and to date ', 4);
        return false;
    }
    if (setup_party.timepicker2.value == "") {
        inlineMsg('timepicker2', 'Enter the End Time of Party', 4);
        return false;
    }
    if (!document.getElementById('address1').checked && !document.getElementById('address2').checked && !document.getElementById('address3').checked) {
        inlineMsg('add', 'Select the Party Venue Address', 4);
        return false;
    } else if (document.getElementById('address3').checked) {
        if (setup_party.address_new.value == "") {
            inlineMsg('address_new', 'Enter the Address', 4);
            return false;
        }

        if (setup_party.city.value == "") {
            inlineMsg('city', 'Enter the City', 4);
            return false;
        }
        if (setup_party.country.value == "") {
            inlineMsg('country', 'Select the Country', 4);
            return false;
        }
        if (setup_party.state1.value == "") {
            inlineMsg('state1', 'Select the State', 4);
            return false;
        }

        if (setup_party.zip.value == "") {
            inlineMsg('zip', 'Enter the Zip code', 4);
            return false;
        }
        if (setup_party.phone.value == "") {
            inlineMsg('phone', 'Enter the Phone Number', 4);
            return false;
        }
        if (setup_party.email.value == "") {
            inlineMsg('email', 'Enter the Email Address', 4);
            return false;
        }
        if (!setup_party.email.value.match(emailRegex)) {
            inlineMsg('email', 'You have entered an invalid  email...', 4);
            return false;
        }
    }
}

function select_product(id, root) {
    document.location.href = root + 'party_guest_order/select_product/' + id;
}

function order_product(select_product) {
    var max = document.getElementById('grid').rows.length - 2;
    var amount;
    for (var i = 1; i <= max; i++) {
        amount = document.getElementById('amount' + i).value;
        if (amount != "" && isNaN(amount)) {
            inlineMsg('amount' + i, 'Enter a Valid Number', 4);
            return false;
        }
    }
    document.location.href = root + 'party_guest_order/select_product/' + '';
}

function delete_order(id, root) {
    if (confirm("Are you sure, you want to Delete ? There is NO undo! ?")) {
        document.location.href = root + 'party_guest_order/delete_order/' + id;
    }
}

function edit_order(id, root) {

    document.location.href = root + 'party_guest_order/edit_order/' + id;
}

function delete_product_order(id, p_id, root, qty) {
    var msg = $("#confirm_msg_inactivate").html();
    if (confirm(msg)) {
        document.location.href = root + 'party_guest_order/delete_product_order/' + id + '/' + p_id + '/' + qty;
    }
}

function validate_update(edit_order) {
    var msg = $("#msg_amount").html();
    var msg1 = $("#msg_num").html();
    var max = document.getElementById("grid").rows.length - 1;
    console.log(max);
    for (var i = 1; i <= max; i++) {
        var amt = document.getElementById('amount' + i).value;
        if (amt == "") {
            inlineMsg('amount' + i, msg, 4);
            return false;
        } else if (isNaN(amt)) {
            inlineMsg('amount' + i, msg1, 4);
            return false;
        }
    }
}
    var ValidateEditOrder = function () {
    // function to initiate Validation Sample 1
    var msg1 = $("#msg_quantity").html();
    var msg2 = $("#msg_num").html();
    var msg3 = $("#msg_digit").html();

    var runValidateCreateHost = function () {
        var searchform = $('#edit_order');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#edit_order').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                if ($(element).hasClass("date-picker")) {
                    error.insertAfter($(element).closest('.input-group'));
                }
                else
                {
                    error.insertAfter(element);
                }
                ;
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            invalidHandler: function (event, validator) { //display error alert on form submit
                errorHandler1.show();
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                //$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            }
        });
        $('.nqty').each(function () {
            $(this).rules('add', {
                number: true,
                min: 1,
                required: true,
                messages: {
                    number: msg3,
                    required: msg1,
                    min:msg2
                }
            });
        });
    };    
    return {
        //main function to initiate template pages
        init: function () {
            runValidateCreateHost();

        }
    };
}();
$(document).ready(function()

    {
        ValidateEditOrder.init();
        $("#host_phone").keypress(function(e)

            {


                //if the letter is not digit then display error and don't type anything

                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))

                {

                    //display error message

                    $("#errmsg1").html("Digits Only ").show().fadeOut(1200, 0);

                    return false;

                }

            });
        $("#host_zip").keypress(function(e)

            {


                //if the letter is not digit then display error and don't type anything

                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))

                {

                    //display error message

                    $("#errmsg2").html("Digits Only ").show().fadeOut(1200, 0);

                    return false;

                }

            });
        $("#phone").keypress(function(e)

            {


                //if the letter is not digit then display error and don't type anything

                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))

                {

                    //display error message

                    $("#errmsg1").html("Digits Only ").show().fadeOut(1200, 0);

                    return false;

                }

            });
        $("#zip").keypress(function(e)

            {


                //if the letter is not digit then display error and don't type anything

                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))

                {

                    //display error message

                    $("#errmsg2").html("Digits Only ").show().fadeOut(1200, 0);

                    return false;

                }

            });
    });

