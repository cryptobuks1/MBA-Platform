// global variables
var base_url = $("#base_url").val();
BASE_URL = base_url;
var exclsub = {
    'admin/my_referal': 'admin/user_account',
    'admin/configuration/my_referal': 'admin/user_account',
    'admin/view_leg_count': 'admin/user_account',
    'admin/configuration/view_leg_count': 'admin/user_account',
    'admin/view_pin_user': 'admin/user_account',
    'admin/epin/view_pin_user': 'admin/user_account',
    'admin/my_income': 'admin/user_account',
    'admin/payout/my_income': 'admin/user_account',
    'admin/business_volume': 'admin/user_account',
    'admin/profile/business_volume': 'admin/user_account',
    'admin/add_new_epin': 'admin/epin_management',
    'admin/epin/add_new_epin': 'admin/epin_management',
    'admin/epin/allocate_user': 'admin/epin_management',
    'admin/edit_profile': 'admin/profile_view',
    'admin/profile/edit_profile': 'admin/profile_view',
    'product_details': 'repurchase_product',
    'repurchase/product_details': 'repurchase_product',
    'checkout_product': 'repurchase_product',
    'repurchase/checkout_product': 'repurchase_product',
    'admin/add_membership_package': 'admin/membership_package',
    'admin/product/add_membership_package': 'admin/membership_package',
    'admin/edit_membership_package': 'admin/membership_package',
    'admin/product/edit_membership_package': 'admin/membership_package',
    'admin/add_repurchase_package': 'admin/repurchase_package',
    'admin/product/add_repurchase_package': 'admin/repurchase_package',
    'admin/edit_repurchase_package': 'admin/repurchase_package',
    'admin/product/edit_repurchase_package': 'admin/repurchase_package',
    'admin/add_repurchase_category': 'admin/repurchase_category',
    'admin/product/add_repurchase_category': 'admin/repurchase_category',
    'admin/edit_repurchase_category': 'admin/repurchase_category',
    'admin/product/edit_repurchase_category': 'admin/repurchase_category',
    'admin/add_text_invite': 'admin/text_invite_configuration',
    'admin/member/add_text_invite': 'admin/text_invite_configuration',
    'admin/edit_invite_text': 'admin/text_invite_configuration',
    'admin/member/edit_invite_text': 'admin/text_invite_configuration',
    'admin/add_banner_invite': 'admin/invite_banner_config',
    'admin/member/add_banner_invite': 'admin/invite_banner_config',
    'admin/edit_invite_wallpost': 'admin/invite_wallpost_config',
    'admin/member/edit_invite_wallpost': 'admin/invite_wallpost_config',
    'admin/add_email_invite': 'admin/invite_wallpost_config',
    'admin/member/add_email_invite': 'admin/invite_wallpost_config',
    'admin/add_facebook_invite': 'admin/invite_wallpost_config',
    'admin/member/add_facebook_invite': 'admin/invite_wallpost_config',
    'admin/add_social_invite': 'admin/invite_wallpost_config',
    'admin/member/add_social_invite': 'admin/invite_wallpost_config',
    'admin/auto_responder_settings': 'admin/auto_responder_details',
    'admin/auto_responder/auto_responder_settings': 'admin/auto_responder_details',
    'admin/upload_new_material': 'admin/upload_materials',
    'admin/news/upload_new_material': 'admin/upload_materials',
    'admin/add_new_news': 'admin/add_news',
    'admin/news/add_new_news': 'admin/add_news',
    'admin/dashboard_config': 'admin/set_employee_permission',
    'admin/employee/dashboard_config': 'admin/set_employee_permission',
    'admin/view_all_employee': 'admin/search_employee',
    'admin/employee/view_all_employee': 'admin/search_employee',
    'admin/compose_mail': 'admin/mail_management',
    'admin/mail/compose_mail': 'admin/mail_management',
    'admin/mail_sent': 'admin/mail_management',
    'admin/mail/mail_sent': 'admin/mail_management',
    'admin/compensation_settings': 'admin/general_setting',
    'admin/configuration/compensation_settings': 'admin/general_setting',
    'admin/level_commissions': 'admin/general_setting',
    'admin/configuration/level_commissions': 'admin/general_setting',
    'admin/binary_bonus_config': 'admin/general_setting',
    'admin/configuration/binary_bonus': 'admin/general_setting',
    'admin/rank_configuration': 'admin/general_setting',
    'admin/configuration/rank_configuration': 'admin/general_setting',
    'admin/add_new_rank': 'admin/general_setting',
    'admin/configuration/add_new_rank': 'admin/general_setting',
    'admin/referal_commissions': 'admin/general_setting',
    'admin/configuration/referal_commissions': 'admin/general_setting',
    'admin/matching_bonus': 'admin/general_setting',
    'admin/configuration/matching_bonus': 'admin/general_setting',
    'admin/pool_bonus_config': 'admin/general_setting',
    'admin/configuration/pool_bonus': 'admin/general_setting',
    'admin/fast_start_bonus_config': 'admin/general_setting',
    'admin/configuration/fast_start_bonus': 'admin/general_setting',
    'admin/performance_bonus': 'admin/general_setting',
    'admin/configuration/performance_bonus': 'admin/general_setting',
    'admin/sales_commission': 'admin/general_setting',
    'admin/configuration/sales_commission': 'admin/general_setting',
    'admin/plan_settings': 'admin/general_setting',
    'admin/configuration/plan_settings': 'admin/general_setting',
    'admin/board_bonus_config': 'admin/general_setting',
    'admin/configuration/board_bonus': 'admin/general_setting',
    'admin/stairstep_configuration': 'admin/general_setting',
    'admin/configuration/stairstep_configuration': 'admin/general_setting',
    'admin/donation_configuration': 'admin/general_setting',
    'admin/configuration/donation_configuration': 'admin/general_setting',
    'admin/roi_commission': 'admin/general_setting',
    'admin/configuration/roi_commission': 'admin/general_setting',
};

$(function(obj) {
    $.each(obj, function(key, value) {
        if (window.location.pathname.indexOf(key) > -1) {
            $('#aside').find("a[href*='" + value + "']").closest('li').addClass('active');
        }
    });
}(exclsub));

var ValidateSearchMember = function() {
    var error_message = $('#search_member_error').val();
    var error_message2 = $('#search_member_error2').val();
    var initValidator = function() {
        $.validator.addMethod("username_check", function(value, element) {
            var path_root = $('#base_url').val();
            var flag2 = false;
            if (value != "/" && value != ".") {
                $.ajax({
                    'url': path_root + getUserType() + "/profile/validate_username",
                    'type': "POST",
                    'data': {
                        username: value
                    },
                    'dataType': 'text',
                    'async': false,
                    'success': function(data) {
                        if (data == 'no') {
                            flag2 = false;
                        } else if (data == 'yes') {
                            flag2 = true;
                        }
                    },
                    'error': function(error) {},
                });
                return flag2;
            } else {
                return true;
            }
        }, error_message2);
        var searchform = $('#search_member');
        var errorHandler = $('.errorHandler', searchform);
        $(searchform).validate({
            errorElement: 'span',
            errorClass: 'help-block error',
            errorId: 'err_search',
            errorPlacement: function(error, element) {
                error.insertAfter(element);
                //                error.insertAfter($(element).parent('.form-group').next('.form-group'));
            },
            ignore: ':hidden',
            rules: {
                user_name: {
                    required: true,
                    username_check: true
                }
            },
            messages: {
                user_name: {
                    required: error_message,
                    username_check: error_message2,
                },
            },
            onkeyup: false,
            onfocusout: function(element) {
                $(element).valid();
            },
            invalidHandler: function(event, validator) {
                errorHandler.show();
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
            initValidator();
        }
    };
}();

function getUserType() {
    var userType = false;
    $.ajax({
        type: 'GET',
        url: $('#base_url').val() + 'login/get_user_type',
        dataType: 'text',
        async: false,
        success: function(data) {
            userType = (data == '') ? false : data;
        },
        error: function() {
            userType = false;
        }
    });
    return userType;
}
var ValidateForget = function() {
    var error_message = $('#search_member_error').val();
    var error_message2 = $('#search_member_error2').val();
    var initValidator = function() {
        $.validator.addMethod("username_check", function(value, element) {
            var path_root = $('#base_url').val();
            var flag2 = false;
            if (value != "/" && value != ".") {
                $.ajax({
                    'url': path_root + getUserType() + "/ewallet/validate_username",
                    'type': "POST",
                    'data': {
                        username: value
                    },
                    'dataType': 'text',
                    'async': false,
                    'success': function(data) {
                        if (data == 'no') {
                            flag2 = false;
                        } else if (data == 'yes') {
                            flag2 = true;
                        }
                    },
                    'error': function(error) {},
                });
                return flag2;
            } else {
                return true;
            }
        }, error_message2);
    };

    return {
        init: function() {
            initValidator();
        }
    };
}();


$(function() {
    $('ul.nav.nav-sub > li.active').parent('ul').parent('li').addClass('active');

    $("form").attr('autocomplete', 'off');

    $(window).on('shown.bs.modal', function() {
        $('input').attr('autocomplete', 'off');
    });

    setJQueryValidationDefaults();

    setJQueryInputFilter();

    loadDatePicker();
    loadTimePicker();
    loadDateTimePicker();

    loadUserAutoList();
    loadUserAutoListExceptAdmin();
    loadUserDownlineAutoList();
    loadEpinAutoList();
    loadEmployeeAutoList();

    $(".date-picker").keypress(function(e) {
        if (e.which == 0 || e.which == 8) {
            return;
        }
        var regex = new RegExp("^[0-9\-]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        } else {
            return false;
        }
    });

});

function setJQueryInputFilter() {
    $.fn.inputFilter = function (inputFilter) {
        return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function () {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            }
        });
    };
}

function setJQueryValidationDefaults() {
    jQuery.validator.setDefaults({
        errorPlacement: function(error, element) {
            if ($(element).hasClass('ckeditor')) {
                var element_id = $(element).attr('id');
                error.insertAfter($('#cke_' + element_id));
            } else if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });

    jQuery.validator.addMethod("greaterThanEqual",
        function(value, element, param) {
            var otherElementVal = $(param).val();
            if (!value || !otherElementVal) {
                return true;
            }
            return parseFloat(value) >= parseFloat(otherElementVal);
        }
    );

    jQuery.validator.addMethod('greaterThanNum', function (value, el, param) {
        return value > param;
    });

}

function dateValidation() {
    if ($("#week_date1").val() && $("#week_date2").val()) {
        var FromDate = $("#week_date1").val();
        var ToDate = $("#week_date2").val();
        if (ToDate < FromDate) {
            vis = "block";
            document.getElementById("error").style.display = vis;
            return false;
        }
    }

    if ($("#ip_address").val()) {
        value = $("#ip_address").val();

        var split = value.split('.');

        if (split.length != 4) {
            vis = "block";
            document.getElementById("ip_err").style.display = vis;
            return false;
        }

        for (var i = 0; i < split.length; i++) {
            var s = split[i];
            if (s.length == 0 || isNaN(s) || s < 0 || s > 255) {
                vis = "block";
                document.getElementById("ip_err").style.display = vis;
                return false;
            }
        }
    }
}

function print_report() {
    var myPrintContent = document.getElementById('print_area');
    var myPrintWindow = window.open("", "Print Report", 'left=300,top=100,width=700,height=500', '_blank');
    myPrintWindow.document.write(myPrintContent.innerHTML);
    myPrintWindow.document.close();
    myPrintWindow.focus();
    myPrintWindow.print();
    myPrintWindow.close();
    return false;
}

function scrollTop() {
    $("html, body").animate({ scrollTop: 0 }, "slow");
}

function loadDatePicker() {
    var datepicker_options = {
        format: 'Y-m-d',
        readonly_element: true,
        default_position: 'below',
        icon_position: 'left',
        offset: [-28, 28],
        onSelect: function() {
            $(this).change();
        }
    };
    $('.date-picker').Zebra_DatePicker(datepicker_options);
}

function loadTimePicker() {
    var timepicker_options = {
        format: 'H:i A',
        readonly_element: true,
        default_position: 'below',
        icon_position: 'left',
        offset: [-28, 28],
        onSelect: function() {
            $(this).change();
        },
        onOpen: function() {
            $('.Zebra_DatePicker').not('.dp_hidden').css('width', '200px');
            $('.Zebra_DatePicker').not('.dp_hidden').find('.dp_timepicker.dp_body').css('height', '150px');
        }
    };
    $('.time-picker').Zebra_DatePicker(timepicker_options);
}

function loadDateTimePicker() {
    var datetimepicker_options = {
        format: 'Y-m-d H:i',
        readonly_element: true,
        default_position: 'below',
        icon_position: 'left',
        offset: [-28, 28],
        onSelect: function() {
            $(this).change();
        }
    };
    $('.datetime-picker').Zebra_DatePicker(datetimepicker_options);
}

function loadUserAutoList() {
    $('.user_autolist').autocomplete({
        minLength: 1,
        appendMethod: 'replace',
        highlight: false,
        showHint: false,
        visibleLimit: 10,
        filter: function(items, query, source) {
            var results = [],
                value = '';
            for (var i in items) {
                value = items[i][this.valueKey];
                results.push(items[i]);
            }
            return results;
        },
        source: [
            function(q, add) {
                if (q == '/' || q == '.') {
                    var keyword = null;
                } else {
                    var keyword = q;
                }
                if (q == '' || q == null) {
                    add([]);
                } else {
                    $.ajax({
                        method: "POST",
                        url: base_url + 'admin/home/ajax_users_autolist',
                        data: { keyword: keyword },
                        dataType: 'json',
                        success: function(data) {
                            add(data);
                        }
                    });
                }
            }
        ]
    });
}

function loadUserAutoListExceptAdmin() {
    $('.autolist_except_admin').autocomplete({
        minLength: 1,
        appendMethod: 'replace',
        highlight: false,
        showHint: false,
        visibleLimit: 10,
        filter: function(items, query, source) {
            var results = [],
                value = '';
            for (var i in items) {
                value = items[i][this.valueKey];
                results.push(items[i]);
            }
            return results;
        },
        source: [
            function(q, add) {
                if (q == '/' || q == '.') {
                    var keyword = null;
                } else {
                    var keyword = q;
                }
                if (q == '' || q == null) {
                    add([]);
                } else {
                    $.ajax({
                        method: "POST",
                        url: base_url + 'admin/home/ajax_except_admin_autolist',
                        data: { keyword: keyword },
                        dataType: 'json',
                        success: function(data) {
                            add(data);
                        }
                    });
                }
            }
        ]
    });
}

function loadUserDownlineAutoList() {
    $('.user_downline_autolist').autocomplete({
        minLength: 1,
        appendMethod: 'replace',
        highlight: false,
        showHint: false,
        visibleLimit: 10,
        filter: function(items, query, source) {
            var results = [],
                value = '';
            for (var i in items) {
                value = items[i][this.valueKey];
                results.push(items[i]);
            }
            return results;
        },
        source: [
            function(q, add) {
                if (q == '/' || q == '.') {
                    var keyword = null;
                } else {
                    var keyword = q;
                }
                if (q == '' || q == null) {
                    add([]);
                } else {
                    $.ajax({
                        method: "POST",
                        url: base_url + 'user/home/ajax_user_downline_autolist',
                        data: { keyword: keyword },
                        dataType: 'json',
                        success: function(data) {
                            add(data);
                        }
                    });
                }
            }
        ]
    });
}

function loadEpinAutoList() {
    $('.epin_autolist').autocomplete({
        minLength: 1,
        appendMethod: 'replace',
        highlight: false,
        showHint: false,
        visibleLimit: 10,
        filter: function(items, query, source) {
            var results = [],
                value = '';
            for (var i in items) {
                value = items[i][this.valueKey];
                results.push(items[i]);
            }
            return results;
        },
        source: [
            function(q, add) {
                if (q == '/' || q == '.') {
                    var keyword = null;
                } else {
                    var keyword = q;
                }
                if (q == '' || q == null) {
                    add([]);
                } else {
                    $.ajax({
                        method: "POST",
                        url: base_url + 'admin/epin/ajax_epin_autolist',
                        data: { keyword: keyword },
                        dataType: 'json',
                        success: function(data) {
                            add(data);
                        }
                    });
                }
            }
        ]
    });
}

function loadEmployeeAutoList() {
    $('.employee_autolist').autocomplete({
        minLength: 1,
        appendMethod: 'replace',
        highlight: false,
        showHint: false,
        visibleLimit: 10,
        filter: function(items, query, source) {
            var results = [],
                value = '';
            for (var i in items) {
                value = items[i][this.valueKey];
                results.push(items[i]);
            }
            return results;
        },
        source: [
            function(q, add) {
                if (q == '/' || q == '.') {
                    var keyword = null;
                } else {
                    var keyword = q;
                }
                if (q == '' || q == null) {
                    add([]);
                } else {
                    $.ajax({
                        method: "POST",
                        url: base_url + 'admin/employee/ajax_employee_autolist',
                        data: { keyword: keyword },
                        dataType: 'json',
                        success: function(data) {
                            add(data);
                        }
                    });
                }
            }
        ]
    });
}

function changeDefaultLanguage(language_id) {
    var user_type = getUserType();
    if (user_type == 'admin' || user_type == 'user') {
        $.ajax({
            url: base_url + getUserType() + '/home/change_default_language',
            data: { language: language_id },
            type: 'post',
            beforeSend: function() {

            },
            success: function(data) {
                if (data == 'yes') {
                    location.reload();
                }
            },
            error: function() {

            },
            complete: function() {
                $('#update_language_info').attr('disabled', false);
            }
        });

    }
}

function confirmAction(message) {
    return confirm($('#' + message).text());
}