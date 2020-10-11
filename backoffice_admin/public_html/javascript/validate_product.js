$(function() {
    ValidateProduct.init();
    ValidateCategory.init();
    var colspan = $('#tr-empty').parent('tbody').siblings('thead').find('tr > th').length;
    $('#tr-empty > td:first').attr('colspan', colspan);
    $('.inactivate_membership_package').on('click', function () {
        var confirm_msg = $("#confirm_msg_inactivate").html();
        if (confirm(confirm_msg)) {
            $(this).closest('form').submit();
        }
    });
    $('.delete_membership_package').on('click', function () {
        var confirm_msg = $("#confirm_msg_delete").html();
        if (confirm(confirm_msg)) {
            $(this).closest('form').submit();
        }
    });
    $('.activate_membership_package').on('click', function () {
        var confirm_msg = $("#confirm_msg_activate").html();
        if (confirm(confirm_msg)) {
            $(this).closest('form').submit();
        }
    });

    $('.inactivate_repurchase_package').on('click', function () {
        var confirm_msg = $("#confirm_msg_inactivate").html();
        if (confirm(confirm_msg)) {
            $(this).closest('form').submit();
        }
    });
    $('.delete_repurchase_package').on('click', function () {
        var confirm_msg = $("#confirm_msg_delete").html();
        if (confirm(confirm_msg)) {
            $(this).closest('form').submit();
        }
    });
    $('.activate_repurchase_package').on('click', function () {
        var confirm_msg = $("#confirm_msg_activate").html();
        if (confirm(confirm_msg)) {
            $(this).closest('form').submit();
        }
    });
    
    $('.delete_repurchase_category').on('click', function () {
        var confirm_msg = $("#confirm_msg_delete_category").html();
        if (confirm(confirm_msg)) {
            $(this).closest('form').submit();
        }
    });
    $('.activate_repurchase_category').on('click', function () {
        var confirm_msg = $("#confirm_msg_activate_category").html();
        if (confirm(confirm_msg)) {
            $(this).closest('form').submit();
        }
    });
    $('.inactivate_repurchase_category').on('click', function () {
        var confirm_msg = $("#confirm_msg_inactivate_category").html();
        if (confirm(confirm_msg)) {
            $(this).closest('form').submit();
        }
    });
    $("#product_amount,#pair_value,#pair_price,#package_validity").keypress(function(e) {
        if (e.which == 0 || e.which == 8) {
            return;
        }
        var regex = new RegExp("^[0-9]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        else {
            var msg = $("#validate_msg1").html();
            showErrorSpanOnKeyup(this, msg);
            return false;
        }
    });
    $("#package_id").keypress(function(e) {
        if (e.which == 0 || e.which == 8) {
            return;
        }
        var regex = new RegExp("^[a-zA-Z0-9]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        else {
            var msg = $("#validate_msg14").html();
            showErrorSpanOnKeyup(this, msg);
            return false;
        }
    });

});

function showErrorSpanOnKeyup(element, message) {
    var span = "<span id='err_keyup_" + element.name + "' class='keyup_error' style='color: #b94a48;'>" + message + "</span>";
    if ($(element).closest('.input-group').length) {
        $(element).closest('.input-group').next('span.keyup_error').remove();
        $(element).closest('.input-group').after(span);
        $(element).closest('.input-group').next('span:first').fadeOut(2000, 0);
    }
    else {
        $(element).next('span.keyup_error').remove();
        $(element).after(span);
        $(element).next('span:first').fadeOut(2000, 0);
    }
}

var ValidateProduct = function() {

    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#validate_msg_img2").html();
    var msg5 = $("#validate_msg_img1").html();
    var msg6 = $("#error_msg4").html();
    var msg8 = $("#validate_msg8").html();
    var msg9 = $("#validate_msg9").html();
    var msg10 = $("#error_msg5").html();
    var msg11 = $("#validate_msg11").html();
    var msg12 = $("#validate_msg12").html();
    var msg13 = $("#validate_msg13").html();
    var msg14 = $("#validate_msg14").html();
    var msg15 = $("#validate_msg15").html();
    var msg16 = $("#validate_msg16").html();
    var msg17 = $("#validate_msg17").html();
    var msg18 = $("#validate_msg18").html();
    var msg19 = $("#validate_msg19").html();
    var msg20 = $("#validate_msg20").html();
    var msg21 = $("#validate_msg1").html();
    var msg22 = $("#validate_msg22").html();
    var msg23 = $("#validate_msg23").html();
    var msg24 = $("#validate_msg24").html();
    var msg25 = $("#validate_msg21").html();
    var msg26 = $("#validate_msg25").html();
    var msg27 = $("#validate_msg26").html();

    var msg28 = $("#validate_msg28").html();
    var msg29 = $("#validate_msg29").html();
    var msg30 = $("#validate_msg30").html();
    var msg31 = $("#validate_msg31").html();
    var msg32 = $("#validate_msg32").html();
    var msg33 = $("#validate_msg33").html();


    var amount_greater_than_zero = $("#amount_greater_than_zero").html();

    var runValidateProduct = function() {

    	var searchform = $('#form');
    	var errorHandler1 = $('.errorHandler', searchform);
        $.validator.addMethod("non_zero", function(value, element) {
           return  /^[1-9]\d*$/.test(value);
        }, msg19);
        $.validator.addMethod("alpha_num", function(value, element) {
            return this.optional(element) || value == value.match(/^[A-Za-z0-9]+$/);
        }, msg10);
    	$('#form').validate({
    		errorElement: "span", 
    		errorClass: 'help-block',
    		errorId: 'err_prod',
    		errorPlacement: function(error, element) { 
                    if($(element).parent('.input-group').length === 0) {
    			error.insertAfter(element);
                    }
                    else {
                        error.insertAfter($(element).closest('.input-group'));
                    }

    		},
    		ignore: ':hidden',
    		rules: {
    			prod_name: {
                    required: true,
                    maxlength: 32,
    			},
    			product_id: {
                    required: true
    			},
    			product_amount: {
                    required: true,
                    number: true,
                    greaterThanNum: 0,
                    maxlength: 5
    			},
                roi: {
                    required: true,
                    number: true,
                    min: 0.1,
                    max: 100
    			},
                days: {
                    required: true,
                    number: true,
                    min: 1,
                    digits: true,
                    maxlength: 5
    			},
    			pair_value: {
                    required: true,
                    digits: true,
                    maxlength: 5
                },
                pair_price: {
                    required: true,
                    number: true,
                    min: 0,
                    maxlength: 5
    			},
                package_id: {
    				required: true,
                    maxlength: 6,
                    alpha_num:true
    			},
    			bv_value: {
    				required: true,
                    maxlength: 5
    			},
    			package_validity: {
    				required: true,
    				digits: true,
                    non_zero: true,
                    maxlength: 5
    			},
                referral_commission: {
                    required: true,
                    digits: true,
                    min: 0,
                    // max: 100
                },
                joinee_referral_commission: {
                    required: true,
                    digits: true,
                    min: 0,
                    // max: 100
                },
                category: {
                    minlength: 1,
                    required: true,
                    check_dfault_option:true
                },
                description:{
                    required: true,
                    minlength: 1
                },
                rank_name: {
                    // required: true,
                    // maxlength: 32,
                },
                rank_color: {
                    required: true
                }
                },
    		messages: {
    			prod_name: {
                    required: msg
                },
    			product_id: msg1,
    			product_amount: {
                    required: msg3,
                    greaterThanNum: amount_greater_than_zero,
                    number:msg9,
                    maxlength: msg20
                },
    			pair_value: {
                    required: msg6,
                    digits: msg9,
                    maxlength: msg20
                },
    			pair_price: {
                    required: msg11,
                    min: msg9,
                    number:msg9,
                    maxlength: msg20
                },
    			package_id: { 
                    required: msg10,
                    alpha_num:msg14
                },
    			package_validity: {
    				required: msg8,
    				digits: msg9,
                    maxlength: msg20
    			},
                referral_commission: {
                    required: msg12,
                    digits: msg21,
                    min: msg13,
                    // max: msg13
                },
                joinee_referral_commission: {
                    required: msg22,
                    digits: msg9,
                    min: msg24,
                    // max: msg24
                },
                roi: {
                    required: msg15,
                    number:msg9,
                    min: msg18,
                    max: msg17
                },
                days: {
                    required: msg16,
                    number:msg9,
                    min: msg18,
                    maxlength: msg20
                },
                bv_value: {
                    required: msg25,
                    maxlength: msg20
    			},
                description:msg27,
                category:msg26,
                rank_name: {
                    required: msg30
                },
                rank_color: {
                    required: msg31
                }
                },
    		invalidHandler: function(event, validator) { 
    			errorHandler1.show();
    		},
    		highlight: function(element) {
    			$(element).closest('.help-block').removeClass('valid');

    			$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');

    		},
    		unhighlight: function(element) { 
    			$(element).closest('.form-group').removeClass('has-error');
    		},
    		success: function(label, element) {
    			label.addClass('help-block valid');
    			$(element).closest('.form-group').removeClass('has-error').addClass('ok');
    		}
        });

        $('.level_com').each(function() {
            var msg_label = $(this).data('lang');
            $(this).rules('add', {
                required: true,
                number: true,
                min: 0,
                messages: {
                    number: msg21,
                    required: msg_label
                }
            });
            if ($("#level_commission_type").val() === 'percentage') {
                $('.level_com').each(function() {
                    $(this).rules('add', {
                        max: 100,
                        messages: {
                            max: msg29
                        }
                    });
                });
            }
        });

        $('.pkg_count').each(function () {
            $(this).rules("add", {
                required: true,
                    minlength: 1,
                    min: 1,
                    digits:true,
                    maxlength: 5,
                messages: {
                    digits:msg4,
                    min: msg31,
                    required: $(this).data('lang')
                }
            });
        });

        $('.match_bonus').each(function () {
            $(this).rules("add", {
                    required: true,
                    digits:true,
                    minlength: 1,
                    max: 100,
                    maxlength: 5,
                messages: {
                    digits:msg21,
                    max: msg32,
                    required: $(this).data('lang')
                }
            });
        });
        $('.sales_commission').each(function () {
            $(this).rules("add", {
                    required: true,
                    digits:true,
                    minlength: 1,
                    max: 100,
                    maxlength: 5,
                messages: {
                    digits:msg21,
                    max: msg33,
                    required: $(this).data('lang')
                }
            });
        });
         };
         
        jQuery.validator.addMethod('check_dfault_option', function(ToDate) {
            if($("#category").val() == 'default') {
                return false;            
            }else
                return true;
            }, "");
         
    return {
    	init: function() {
    		runValidateProduct();
    	}
    };
}();

function edit_membership_package(id) {
//    var confirm_msg = $("#confirm_msg_edit").html();
//    if (confirm(confirm_msg)) {
        document.location.href = $('#base_url').val() + 'admin/product/edit_membership_package/' + id;
//    }
}

function edit_repurchase_package(id) {
//    var confirm_msg = $("#confirm_msg_edit").html();
//    if (confirm(confirm_msg)) {
        document.location.href = $('#base_url').val() + 'admin/product/edit_repurchase_package/' + id;
//    }
}

function edit_repurchase_category(id) {
//    var confirm_msg = $("#confirm_msg_edit").html();
//    if (confirm(confirm_msg)) {
        document.location.href = $('#base_url').val() + 'admin/product/edit_repurchase_category/' + id;
//    }
}

var ValidateCategory = function() {
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();

    var runValidateCategory = function() {

    	var searchform = $('#category_form');
    	var errorHandler1 = $('.errorHandler', searchform);
    	$('#category_form').validate({
    		errorElement: "span", 
    		errorClass: 'help-block',
    		errorId: 'err_prod',
    		errorPlacement: function(error, element) { 
                    if($(element).parent('.input-group').length === 0) {
    			error.insertAfter(element);
                    }
                    else {
                        error.insertAfter($(element).closest('.input-group'));
                    }

    		},
    		ignore: ':hidden',
    		rules: {
    			category_name: {
                            required: true,
                            maxlength: 32,
                        } 
                    },
    		messages: {
    			category_name: {
                            required: msg
    			}
                },
    		invalidHandler: function(event, validator) { 
    			errorHandler1.show();
    		},
    		highlight: function(element) {
    			$(element).closest('.help-block').removeClass('valid');

    			$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');

    		},
    		unhighlight: function(element) { 
    			$(element).closest('.form-group').removeClass('has-error');
    		},
    		success: function(label, element) {
    			label.addClass('help-block valid');
    			$(element).closest('.form-group').removeClass('has-error').addClass('ok');
    		}
    	});
         };
         
    return {
    	init: function() {
    		runValidateCategory();
    	}
    };
}();
