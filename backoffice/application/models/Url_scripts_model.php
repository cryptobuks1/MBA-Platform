<?php

class url_scripts_model extends inf_model {

    public function __construct() {
        parent::__construct();
    }

    public function getURLScripts($url_id) {

        $script_arr = array();
        if ($url_id == 1) {
            $script_arr[0]['name'] = "validate_forgot_reset.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 2) {
            $script_arr[0]['name'] = "tabs.css";
            $script_arr[0]['type'] = "css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "cookie-based-jquery-tabs.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "jquery.cookie.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "validate_login.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }

        if ($url_id == 3) {
            $script_arr[1]['name'] = "login_employee.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
        }

        if ($url_id == 5) {
            $script_arr[0]['name'] = "validate_reset_pass.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 6) {
            $script_arr[0]['name'] = "validate_email.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 7) {
            $script_arr[4]['name'] = "copy_to_clip_board.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "ajax-dynamic-dashboard.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[10]['name'] = "date_time_picker.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
        }

        if ($url_id == 8) {
            $script_arr[0]['name'] = "validate_configuration.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 9) {
            $script_arr[0]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";

            $script_arr[2]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";

            $script_arr[8]['name'] = "validate_content_management.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";

            $script_arr[15]['name'] = "validate_configurate.js";
            $script_arr[15]['type'] = "js";
            $script_arr[15]['loc'] = "footer";

            $script_arr[16]['name'] = "validate_email_config.js";
            $script_arr[16]['type'] = "js";
            $script_arr[16]['loc'] = "footer";

            $script_arr[18]['name'] = "validate_social_profile.js";
            $script_arr[18]['type'] = "js";
            $script_arr[18]['loc'] = "footer";
        }

        if ($url_id == 10) {
            $script_arr[0]['name'] = "validate_mail_settings.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[12]['name'] = "validate_mail.js";
            $script_arr[12]['type'] = "js";
            $script_arr[12]['loc'] = "footer";
        }

        if ($url_id == 11) {
            $script_arr[9]['name'] = "user_summary_header.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "validate_select_user.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
        }

        if ($url_id == 12) {
            $script_arr[3]['name'] = "validate_select_user.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "user_summary_header.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
        }

        if ($url_id == 13) {
            $script_arr[0]['name'] = "validate_epin_configuration.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[5]['name'] = "validate_feed.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[9]['name'] = "misc.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
        }

        if ($url_id == 14) {
            $script_arr[2]['name'] = "misc.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";

            $script_arr[9]['name'] = "validate_rank_configuration.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
        }

        if ($url_id == 15) {
            // $script_arr[0]['name'] = "validate_configuration.js";
            // $script_arr[0]['type'] = "js";
            // $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 16) {
            $script_arr[0]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";

            $script_arr[2]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";

            $script_arr[4]['name'] = "jquery-ui.min.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "validate_configurate.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
        }

        if ($url_id == 17) {
            $script_arr[1]['name'] = "validate_mail_settings.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
        }

        if ($url_id == 19) {
            $script_arr[0]['name'] = "validate_register.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "state.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "calendar-win2k-cold-1.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[6]['name'] = "style-popup.css";
            $script_arr[6]['type'] = "css";
            $script_arr[6]['loc'] = "header";
            $script_arr[7]['name'] = "momentjs/moment.js";
            $script_arr[7]['type'] = "plugins/js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "combodate/combodate.js";
            $script_arr[8]['type'] = "plugins/js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "form-wizard.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "register_link.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[11]['type'] = "plugins/css";
            $script_arr[11]['loc'] = "header";
            $script_arr[12]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[12]['type'] = "plugins/js";
            $script_arr[12]['loc'] = "footer";
        }

        if ($url_id == 21) {
            $script_arr[3]['name'] = "validate_change_username.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }

        if ($url_id == 22) {
            $script_arr[3]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[3]['type'] = "plugins/css";
            $script_arr[3]['loc'] = "header";

            $script_arr[5]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";

            $script_arr[7]['name'] = "stateprof.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "momentjs/moment.js";
            $script_arr[8]['type'] = "plugins/js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "combodate/combodate.js";
            $script_arr[9]['type'] = "plugins/js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "profile_update.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "user_summary_header.js";
            $script_arr[11]['type'] = "js";
            $script_arr[11]['loc'] = "footer";
        }

        if ($url_id == 23) {
            $script_arr[3]['name'] = "validate_select_user.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "user_summary_header.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
        }

        if ($url_id == 24) {
            $script_arr[3]['name'] = "validate_change_password.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }

        if ($url_id == 25 || $url_id == 275) {
            $script_arr[3]['name'] = "validate_member.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }

        if ($url_id == 26) {
            $script_arr[6]['name'] = "jquery-ui.min.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[12]['name'] = "Epinvalidation.js";
            $script_arr[12]['type'] = "js";
            $script_arr[12]['loc'] = "footer";
            $script_arr[13]['name'] = "date_time_picker.js";
            $script_arr[13]['type'] = "js";
            $script_arr[13]['loc'] = "footer";
        }

        if ($url_id == 27) {
            $script_arr[1]['name'] = "messages.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "header";
            $script_arr[4]['name'] = "misc.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";

            $script_arr[12]['name'] = "validate_epin.js";
            $script_arr[12]['type'] = "js";
            $script_arr[12]['loc'] = "footer";
            $script_arr[14]['name'] = "datepicker/css/datepicker.css";
            $script_arr[14]['type'] = "plugins/css";
            $script_arr[14]['loc'] = "header";
            $script_arr[15]['name'] = "bootstrap-timepicker/css/bootstrap-timepicker.min.css";
            $script_arr[15]['type'] = "plugins/css";
            $script_arr[15]['loc'] = "header";
            $script_arr[16]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[16]['type'] = "plugins/js";
            $script_arr[16]['loc'] = "footer";
            $script_arr[17]['name'] = "bootstrap-timepicker/js/bootstrap-timepicker.min.js";
            $script_arr[17]['type'] = "plugins/js";
            $script_arr[17]['loc'] = "footer";
        }

        if ($url_id == 28) {
            
        }

        if ($url_id == 29) {
            $script_arr[0]['name'] = "validation_pin_request.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 30) {
            $script_arr[7]['name'] = "jquery-ui.min.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "validate_epin.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
        }

        if ($url_id == 32) {
            $script_arr[3]['name'] = "validate_ewallet_fund.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "ewallet.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
        }

        if ($url_id == 33) {
            $script_arr[3]['name'] = "validate_fund_management.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }

        if ($url_id == 34) {
            $script_arr[3]['name'] = "validate_ewallet_fund.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }

        if ($url_id == 35) {
            $script_arr[9]['name'] = "user_summary_header.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "validate_select_user.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
        }

        if ($url_id == 36) {
            $script_arr[7]['name'] = "date_time_picker.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";

            $script_arr[9]['name'] = "validate_ewallet_mytransfer.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
        }

        if ($url_id == 38) {
            $script_arr[3]['name'] = "validate_select_user.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";

            $script_arr[10]['name'] = "user_summary_header.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
        }

        if ($url_id == 39) {

            $script_arr[6]['name'] = "validate_payout_release.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "MailBox.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
        }

        if ($url_id == 40) {
            $script_arr[0]['name'] = "validate_payout_release.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 41) {
            $script_arr[2]['name'] = "validate_employee_password.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
        }

        if ($url_id == 42) {
            $script_arr[1]['name'] = "messages.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "header";
            $script_arr[4]['name'] = "style.css";
            $script_arr[4]['type'] = "css";
            $script_arr[4]['loc'] = "header";

            $script_arr[9]['name'] = "date_time_picker.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "employee_register.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
        }

        if ($url_id == 43) {
            $script_arr[0]['name'] = "validate_employee_search.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";

            $script_arr[2]['name'] = "misc.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";

            $script_arr[8]['name'] = "date_time_picker.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[9]['type'] = "plugins/css";
            $script_arr[9]['loc'] = "header";

            $script_arr[10]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[10]['type'] = "plugins/js";
            $script_arr[10]['loc'] = "footer";

            $script_arr[11]['name'] = "validate_employee_view.js";
            $script_arr[11]['type'] = "js";
            $script_arr[11]['loc'] = "footer";
        }

        if ($url_id == 44) {
            $script_arr[3]['name'] = "validate_employee.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }

        if ($url_id == 45) {
            $script_arr[3]['name'] = "validate_admin_profile.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }

        if ($url_id == 46) {
            $script_arr[0]['name'] = "misc.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";

            $script_arr[5]['name'] = "date_time_picker.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "validate_joining.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
        }

        if ($url_id == 47) {
            $script_arr[7]['name'] = "date_time_picker.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "validate_epin_transfer_report.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
        }

        if ($url_id == 49) {

            $script_arr[4]['name'] = "date_time_picker.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "validate_sales.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
        }

        if ($url_id == 50) {

            $script_arr[4]['name'] = "date_time_picker.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "validate_sales.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
        }

        if ($url_id == 51) {
            $script_arr[0]['name'] = "validate_joining.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";

            $script_arr[5]['name'] = "date_time_picker.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
        }

        if ($url_id == 52) {
            $script_arr[7]['name'] = "date_time_picker.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "validate_payoutt.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
        }

        if ($url_id == 53) {
            $script_arr[0]['name'] = "validate_mail.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[4]['name'] = "MailBox.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "custom.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "style-popup.css";
            $script_arr[6]['type'] = "css";
            $script_arr[6]['loc'] = "header";
            $script_arr[7]['name'] = "validate_mail_management.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "bootstrap3-wysihtml5.min.css";
            $script_arr[8]['type'] = "css";
            $script_arr[8]['loc'] = "header";
            $script_arr[9]['name'] = "blue.css";
            $script_arr[9]['type'] = "css";
            $script_arr[9]['loc'] = "header";
            $script_arr[10]['name'] = "mail_box.css";
            $script_arr[10]['type'] = "css";
            $script_arr[10]['loc'] = "header";
            $script_arr[11]['name'] = "bootstrap3-wysihtml5.all.min.js";
            $script_arr[11]['type'] = "js";
            $script_arr[11]['loc'] = "footer";
            $script_arr[12]['name'] = "icheck.min.js";
            $script_arr[12]['type'] = "js";
            $script_arr[12]['loc'] = "footer";
        }

        if ($url_id == 54) {
            $script_arr[0]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";

            $script_arr[2]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";

            $script_arr[5]['name'] = "jquery-ui.min.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "validate_sms.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "send_sms.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "jquery.wordcount.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
        }

        if ($url_id == 55) {
            $script_arr[0]['name'] = "validate_sms.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 56) {
            $script_arr[3]['name'] = "validate_select_user.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[9]['name'] = "user_summary_header.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
        }

        if ($url_id == 57) {
            $script_arr[1]['name'] = "messages.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "header";
            $script_arr[4]['name'] = "style.css";
            $script_arr[4]['type'] = "css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "style_pop_up.css";
            $script_arr[5]['type'] = "css";
            $script_arr[5]['loc'] = "header";
            $script_arr[6]['name'] = "top_up-min.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[8]['name'] = "jquery-ui.min.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[15]['name'] = "validate_select_user.js";
            $script_arr[15]['type'] = "js";
            $script_arr[15]['loc'] = "footer";
        }

        if ($url_id == 58 || $url_id == 161) {
            $script_arr[3]['name'] = "validate_select_user.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[6]['name'] = "tree/zoom.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
        }

        if ($url_id == 59) {
            $script_arr[8]['name'] = "validate_select_user.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
        }

        if ($url_id == 61) {
            $script_arr[3]['name'] = "validate_select_user.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[6]['name'] = "tree/zoom.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
        }

        if ($url_id == 62) {
            $script_arr[2]['name'] = "misc.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[2]['name'] = "validate_feed.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "misc.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }

        if ($url_id == 63) {
            $script_arr[0]['name'] = "validate_income.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";

            $script_arr[10]['name'] = "user_summary_header.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
        }

        if ($url_id == 64) {
            $script_arr[0]['name'] = "misc.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[4]['name'] = "validate_news.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
        }

        if ($url_id == 65) {
            $script_arr[0]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";

            $script_arr[2]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";

            $script_arr[5]['name'] = "jquery-ui.min.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "validate_news.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "misc.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
        }

        if ($url_id == 66) {
            
        }

        if ($url_id == 67) {
            $script_arr[3]['name'] = "validate_change_passcode.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }

        if ($url_id == 69) {
            $script_arr[0]['name'] = "user_summary_header.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[10]['name'] = "jquery-ui.min.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "misc.js";
            $script_arr[11]['type'] = "js";
            $script_arr[11]['loc'] = "footer";
            $script_arr[12]['name'] = "messages.css";
            $script_arr[12]['type'] = "css";
            $script_arr[12]['loc'] = "header";
            $script_arr[13]['name'] = "validate_epin.js";
            $script_arr[13]['type'] = "js";
            $script_arr[13]['loc'] = "footer";
        }

        if ($url_id == 70) {
            $script_arr[0]['name'] = "validate_payment_gateway_config.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 71) {
            $script_arr[0]['name'] = "misc.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";

            $script_arr[11]['name'] = "date_time_picker.js";
            $script_arr[11]['type'] = "js";
            $script_arr[11]['loc'] = "footer";
            $script_arr[12]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[12]['type'] = "plugins/css";
            $script_arr[12]['loc'] = "header";

            $script_arr[14]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[14]['type'] = "plugins/js";
            $script_arr[14]['loc'] = "footer";

            $script_arr[16]['name'] = "validate_employee_view.js";
            $script_arr[16]['type'] = "js";
            $script_arr[16]['loc'] = "footer";
        }

        if ($url_id == 74) {
            $script_arr[0]['name'] = "validate_payment_gateway_config.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 77) {
            $script_arr[0]['name'] = "MailBox.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            // $script_arr[1]['name'] = "custom.js";
            // $script_arr[1]['type'] = "js";
            // $script_arr[1]['loc'] = "footer";
            // $script_arr[2]['name'] = "style-popup.css";
            // $script_arr[2]['type'] = "css";
            // $script_arr[2]['loc'] = "header";
            // $script_arr[9]['name'] = "misc.js";
            // $script_arr[9]['type'] = "js";
            // $script_arr[9]['loc'] = "footer";
            // $script_arr[13]['name'] = "jquery-ui.min.js";
            // $script_arr[13]['type'] = "js";
            // $script_arr[13]['loc'] = "footer";
        }

        if ($url_id == 78) {
            
        }

        if ($url_id == 79) {
            
        }

        if ($url_id == 81) {
            $script_arr[0]['name'] = "validate_multy_currency.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 82) {
            $script_arr[0]['name'] = "validate_multy_currency.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 84) {
            $script_arr[4]['name'] = "validate_mail.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[7]['name'] = "editor/text_area_toolbar.css";
            $script_arr[7]['type'] = "css";
            $script_arr[7]['loc'] = "header";
            $script_arr[8]['name'] = "editor/jHtmlArea.css";
            $script_arr[8]['type'] = "css";
            $script_arr[8]['loc'] = "header";
            $script_arr[14]['name'] = "validate_mail_management.js";
            $script_arr[14]['type'] = "js";
            $script_arr[14]['loc'] = "footer";
            $script_arr[15]['name'] = "MailBox.js";
            $script_arr[15]['type'] = "js";
            $script_arr[15]['loc'] = "footer";
            $script_arr[16]['name'] = "bootstrap3-wysihtml5.min.css";
            $script_arr[16]['type'] = "css";
            $script_arr[16]['loc'] = "header";
            $script_arr[17]['name'] = "bootstrap3-wysihtml5.all.min.js";
            $script_arr[17]['type'] = "js";
            $script_arr[17]['loc'] = "footer";
        }

        if ($url_id == 85) {
            $script_arr[3]['name'] = "MailBox.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "custom.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "style-popup.css";
            $script_arr[5]['type'] = "css";
            $script_arr[5]['loc'] = "header";
        }

        if ($url_id == 86) {
            $script_arr[0]['name'] = "validate_multy_language.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }
        if ($url_id == 87) {
            $script_arr[0]['name'] = "validate_ticket.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";

            $script_arr[1]['name'] = "misc.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";

            $script_arr[2]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[2]['type'] = "plugins/css";
            $script_arr[2]['loc'] = "header";

            $script_arr[3]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";

            $script_arr[4]['name'] = "tagging-ticket.css";
            $script_arr[4]['type'] = "css";
            $script_arr[4]['loc'] = "header";
        }

        if ($url_id == 88) {
            
        }

        if ($url_id == 89) {
            $script_arr[0]['name'] = "jquery-ui.min.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[2]['name'] = "jquery.dataTables";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[11]['name'] = "validate_invite.js";
            $script_arr[11]['type'] = "js";
            $script_arr[11]['loc'] = "footer";
            $script_arr[14]['name'] = "invites.js";
            $script_arr[14]['type'] = "js";
            $script_arr[14]['loc'] = "footer";
        }

        if ($url_id == 90) {
            $script_arr[8]['name'] = "validate_invite_config.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
        }

        if ($url_id == 91) {
            $script_arr[0]['name'] = "validate_invite_config.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 92) {
            $script_arr[0]['name'] = "validate_invite_wallpost.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 93) {
            $script_arr[0]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";

            $script_arr[2]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
        }

        if ($url_id == 95) {
            $script_arr[0]['name'] = "MailBox.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 96) {
            $script_arr[1]['name'] = "validate_mail.js";
            $script_arr[1]['type'] = "plugins/js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "MailBox.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
        }

        if ($url_id == 97) {
            
        }

        if ($url_id == 101) {
            $script_arr[0]['name'] = "misc.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "validate_board_configuration.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
        }

        if ($url_id == 103) {
            $script_arr[1]['name'] = "validate_party.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";

            $script_arr[6]['name'] = "date_time_picker.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "state.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[8]['type'] = "plugins/css";
            $script_arr[8]['loc'] = "header";

            $script_arr[10]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[10]['type'] = "plugins/js";
            $script_arr[10]['loc'] = "footer";
        }

        if ($url_id == 104) {
            
        }

        if ($url_id == 105) {
            $script_arr[1]['name'] = "validate_party.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
        }

        if ($url_id == 106) {
            $script_arr[4]['name'] = "jquery-ui.min.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "host.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "validate_create_host.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
        }

        if ($url_id == 107) {
            $script_arr[0]['name'] = "validate_create_host.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "host.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "misc.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "state.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "validate_party.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
        }

        if ($url_id == 108) {
            $script_arr[4]['name'] = "jquery-ui.min.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "host.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "validate_create_host.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "validate_setup_party.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
        }

        if ($url_id == 109) {
            $script_arr[4]['name'] = "jquery-ui.min.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "host.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "validate_create_host.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "validate_setup_party.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
        }

        if ($url_id == 110) {
            $script_arr[4]['name'] = "jquery-ui.min.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "host.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "validate_create_host.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "validate_setup_party.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
        }

        if ($url_id == 111) {
            $script_arr[4]['name'] = "jquery-ui.min.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "host.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "validate_create_host.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "validate_setup_party.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
        }

        if ($url_id == 112) {
            $script_arr[8]['name'] = "jquery-ui.min.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "host.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "validate_create_host.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "state.js";
            $script_arr[11]['type'] = "js";
            $script_arr[11]['loc'] = "footer";
            $script_arr[12]['name'] = "misc.js";
            $script_arr[12]['type'] = "js";
            $script_arr[12]['loc'] = "footer";
        }

        if ($url_id == 113) {
            $script_arr[0]['name'] = "validate_create_host.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "host.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "misc.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "state.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "validate_party.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
        }

        if ($url_id == 114) {
            $script_arr[0]['name'] = "validate_create_host.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "state.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "misc.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";

            $script_arr[13]['name'] = "jquery-ui.min.js";
            $script_arr[13]['type'] = "js";
            $script_arr[13]['loc'] = "footer";
            $script_arr[14]['name'] = "host.js";
            $script_arr[14]['type'] = "js";
            $script_arr[14]['loc'] = "footer";
        }

        if ($url_id == 115) {
            $script_arr[0]['name'] = "validate_create_host.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "state.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "misc.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[13]['name'] = "jquery-ui.min.js";
            $script_arr[13]['type'] = "js";
            $script_arr[13]['loc'] = "footer";
            $script_arr[14]['name'] = "host.js";
            $script_arr[14]['type'] = "js";
            $script_arr[14]['loc'] = "footer";
        }

        if ($url_id == 116) {
            $script_arr[3]['name'] = "validate_activate_deactivate.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }

        if ($url_id == 120) {
            $script_arr[3]['name'] = "tree/zoom.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }
        if ($url_id == 121) {
            $script_arr[1]['name'] = "login_employee.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "validate_payout_config.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
        }
        if ($url_id == 122) {
            $script_arr[3]['name'] = "validate_member.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "MailBox.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[8]['name'] = "bootstrap3-wysihtml5.min.css";
            $script_arr[8]['type'] = "css";
            $script_arr[8]['loc'] = "header";
            $script_arr[11]['name'] = "bootstrap3-wysihtml5.all.min.js";
            $script_arr[11]['type'] = "js";
            $script_arr[11]['loc'] = "footer";
        }
        if ($url_id == 123) {

            $script_arr[0]['name'] = "validate_joining.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";

            $script_arr[5]['name'] = "date_time_picker.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
        }
        if ($url_id == 124) {
            $script_arr[3]['name'] = "validate_member.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }
        if ($url_id == 125 || $url_id == 218) {
            $script_arr[7]['name'] = "date_time_picker.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
        }

        if ($url_id == 131) {
            $script_arr[4]['name'] = "send_feedback_validation.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
        }

        if ($url_id == 133) {
            $script_arr[7]['name'] = "date_time_picker.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "validate_payoutt.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
        }

        if ($url_id == 136) {
            $script_arr[0]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[0]['type'] = "plugins/js";
            $script_arr[0]['loc'] = "footer";

            $script_arr[1]['name'] = "bootstrap-timepicker/js/bootstrap-timepicker.min.js";
            $script_arr[1]['type'] = "plugins/js";
            $script_arr[1]['loc'] = "footer";
        } else if ($url_id == 137) {
            $script_arr[5]['name'] = "date_time_picker.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
        } else if ($url_id == 138) {
            $script_arr[0]['name'] = "tooltip/standalone.css";
            $script_arr[0]['type'] = "css";
            $script_arr[0]['loc'] = "header";

            $script_arr[1]['name'] = "tooltip/tooltip-generic.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "header";

            $script_arr[2]['name'] = "flot/jquery.flot.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";

            $script_arr[3]['name'] = "flot/jquery.flot.time.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";

            $script_arr[4]['name'] = "flot/jquery.flot.orderBars.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";

            $script_arr[5]['name'] = "flot/bar-chart.css";
            $script_arr[5]['type'] = "plugins/css";
            $script_arr[5]['loc'] = "header";
        } else if ($url_id == 140) {
            $script_arr[0]['name'] = "timeline/flexslider.css?o1v85y";
            $script_arr[0]['type'] = "css";
            $script_arr[0]['loc'] = "header";

            $script_arr[1]['name'] = "timeline/owl.carousel.css?o1v85y";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "header";

            $script_arr[2]['name'] = "timeline/prettyPhoto.css?o1v85y";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";

            $script_arr[3]['name'] = "timeline/YTPlayer.css?o1v85y";
            $script_arr[3]['type'] = "css";
            $script_arr[3]['loc'] = "header";

            $script_arr[4]['name'] = "timeline/style.css?o1v85y";
            $script_arr[4]['type'] = "css";
            $script_arr[4]['loc'] = "header";

            $script_arr[5]['name'] = "timeline/responsive.css?o1v85y";
            $script_arr[5]['type'] = "css";
            $script_arr[5]['loc'] = "header";
        } else if ($url_id == 141) {
            $script_arr[3]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";

            $script_arr[4]['name'] = "bootstrap-timepicker/js/bootstrap-timepicker.min.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
        } else if ($url_id == 142) {
            $script_arr[3]['name'] = "date_time_picker.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        } else if ($url_id == 143) {
            $script_arr[3]['name'] = "register_link.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }
        if ($url_id == 145) {
            $script_arr[7]["name"] = "date_time_picker.js";
            $script_arr[7]["type"] = "js";
            $script_arr[7]["loc"] = "footer";

            $script_arr[8]["name"] = "validate_search.js";
            $script_arr[8]["type"] = "js";
            $script_arr[8]["loc"] = "footer";

            $script_arr[9]["name"] = "misc.js";
            $script_arr[9]["type"] = "js";
            $script_arr[9]["loc"] = "footer";
        }
        if ($url_id == 146) {
            $script_arr[1]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";

            $script_arr[2]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
        }
        if ($url_id == 147) {
            $script_arr[1]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";

            $script_arr[2]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";

            $script_arr[4]["name"] = "ticket_message.js";
            $script_arr[4]["type"] = "js";
            $script_arr[4]["loc"] = "footer";

            $script_arr[5]["name"] = "tagging-ticket.css";
            $script_arr[5]["type"] = "css";
            $script_arr[5]["loc"] = "header";

            $script_arr[6]["name"] = "tag-ticket.js";
            $script_arr[6]["type"] = "js";
            $script_arr[6]["loc"] = "footer";

            $script_arr[7]["name"] = "ticket_message.js";
            $script_arr[7]["type"] = "js";
            $script_arr[7]["loc"] = "footer";
        }
        if ($url_id == 148) {
            $script_arr[1]["name"] = "tick_category.js";
            $script_arr[1]["type"] = "js";
            $script_arr[1]["loc"] = "footer";
        } elseif ($url_id == 149) {
            $script_arr[1]["name"] = "tick_category.js";
            $script_arr[1]["type"] = "js";
            $script_arr[1]["loc"] = "footer";
        } elseif ($url_id == 150) {
            $script_arr[1]["name"] = "misc.js";
            $script_arr[1]["type"] = "js";
            $script_arr[1]["loc"] = "footer";

            $script_arr[4]["name"] = "validate_ticket_assign.js";
            $script_arr[4]["type"] = "js";
            $script_arr[4]["loc"] = "footer";
        } elseif ($url_id == 151) {
            $script_arr[1]["name"] = "misc.js";
            $script_arr[1]["type"] = "js";
            $script_arr[1]["loc"] = "footer";

            $script_arr[4]["name"] = "validate_ticket_assign.js";
            $script_arr[4]["type"] = "js";
            $script_arr[4]["loc"] = "footer";
        } elseif ($url_id == 152) {
            $script_arr[1]["name"] = "tick_faq.js";
            $script_arr[1]["type"] = "js";
            $script_arr[1]["loc"] = "footer";
        } else if ($url_id == 153) {
            $script_arr[4]['name'] = "validate_product.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";

            $script_arr[5]['name'] = "validate_register.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";

            $script_arr[6]['name'] = "repurchase_product.css";
            $script_arr[6]['type'] = "css";
            $script_arr[6]['loc'] = "header";
        } elseif ($url_id == 154) {

            $script_arr[0]['name'] = "validate_register.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";

            $script_arr[1]['name'] = "misc.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";

            $script_arr[2]['name'] = "bootstrap-modal/css/bootstrap-modal-bs3patch.css";
            $script_arr[2]['type'] = "plugins/css";
            $script_arr[2]['loc'] = "header";

            $script_arr[3]['name'] = "bootstrap-modal/css/bootstrap-modal.css";
            $script_arr[3]['type'] = "plugins/css";
            $script_arr[3]['loc'] = "header";

            $script_arr[4]['name'] = "bootstrap-modal/js/bootstrap-modal.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";

            $script_arr[5]['name'] = "bootstrap-modal/js/bootstrap-modalmanager.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";

            $script_arr[7]['name'] = "repurchase_product.css";
            $script_arr[7]['type'] = "css";
            $script_arr[7]['loc'] = "header";

            $script_arr[8]['name'] = "validate_repurchase.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
        } else if ($url_id == 155 || $url_id == 159 || $url_id == 160 || $url_id == 207) {
            $script_arr[3]['name'] = "validate_repurchase.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";

            $script_arr[8]['name'] = "date_time_picker.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
        } elseif ($url_id == 156) {
            $script_arr[3]['name'] = "validate_employee_activity.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        } elseif ($url_id == 157) {
            $script_arr[3]['name'] = "validate_select_user.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "user_summary_header.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
        } elseif ($url_id == 158) {
            $script_arr[0]['name'] = "misc.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";

            $script_arr[1]['name'] = "validate_configuration.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
        } else if ($url_id == 162) {
            $script_arr[3]['name'] = "validate_profile_user.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        } else if ($url_id == 163) {

            $script_arr[0]['name'] = "validate_register.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";

            $script_arr[1]['name'] = "register_link.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";

            $script_arr[2]['name'] = "validate_repurchase.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
        } else if ($url_id == 164) {
            
        } else if ($url_id == 165) {
            
        } else if ($url_id == 166) {
            
        } else if ($url_id == 169) {
            $script_arr[0]['name'] = "misc.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";

            $script_arr[7]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[7]['type'] = "plugins/css";
            $script_arr[7]['loc'] = "header";

            $script_arr[9]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[9]['type'] = "plugins/js";
            $script_arr[9]['loc'] = "footer";

            $script_arr[12]['name'] = "jquery-ui.min.js";
            $script_arr[12]['type'] = "js";
            $script_arr[12]['loc'] = "footer";
            $script_arr[13]['name'] = "validate_product.js";
            $script_arr[13]['type'] = "js";
            $script_arr[13]['loc'] = "footer";
        }
        if ($url_id == 170) {
            $script_arr[2]['name'] = "misc.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";

            $script_arr[9]['name'] = "validate_rank.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
        }
        if ($url_id == 171) {
            $script_arr[0]['name'] = "validate_multy_currency.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }
        if ($url_id == 172) {
            $script_arr[0]['name'] = "validate_invite_config.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }
        if ($url_id == 173) {
            $script_arr[1]['name'] = "messages.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "header";
            $script_arr[4]['name'] = "misc.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[12]['name'] = "validate_epin.js";
            $script_arr[12]['type'] = "js";
            $script_arr[12]['loc'] = "footer";

            $script_arr[18]['name'] = "date_time_picker.js";
            $script_arr[18]['type'] = "js";
            $script_arr[18]['loc'] = "footer";
        }
        if ($url_id == 174) {
            $script_arr[0]['name'] = "misc.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[4]['name'] = "validate_news.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
        }
        if ($url_id == 175) {
            $script_arr[0]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";

            $script_arr[2]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";

            $script_arr[5]['name'] = "jquery-ui.min.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "validate_news.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "misc.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
        }
        if ($url_id == 176) {
            $script_arr[8]['name'] = "validate_invite_config.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
        }
        if ($url_id == 177) {
            $script_arr[0]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";

            $script_arr[2]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "validate_invite_banner.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }
        if ($url_id == 178) {
            $script_arr[0]['name'] = "validate_invite_wallpost.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }
        if ($url_id == 179) {
            $script_arr[0]['name'] = "validate_invite_wallpost.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }
        if ($url_id == 180) {
            $script_arr[5]['name'] = "validate_epin.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
        }
        if ($url_id == 181) {
            $script_arr[0]['name'] = "signup_settings.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";

            $script_arr[1]['name'] = "validate_username_config.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
        }
        if ($url_id == 182) {
            $script_arr[0]['name'] = "pending_registration.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }
        if ($url_id == 187) {
            $script_arr[0]['name'] = "validate_product.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }
        if ($url_id == 188) {
            $script_arr[0]['name'] = "validate_product.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }
        if ($url_id == 189) {
            $script_arr[0]['name'] = "validate_product.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }
        if ($url_id == 190) {
            $script_arr[0]['name'] = "validate_product.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
        }
        if ($url_id == 191) {
            $script_arr[0]['name'] = "validate_product.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }
        if ($url_id == 192) {
            $script_arr[0]['name'] = "validate_product.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
        }

        //replication site config 
        if ($url_id == 185) {
            $script_arr[0]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";

            $script_arr[2]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";

            $script_arr[14]['name'] = "validate_social_profile.js";
            $script_arr[14]['type'] = "js";
            $script_arr[14]['loc'] = "footer";
        }
        if ($url_id == 184 || $url_id == 231) {

            $script_arr[13]['name'] = "date_time_picker.js";
            $script_arr[13]['type'] = "js";
            $script_arr[13]['loc'] = "footer";
            $script_arr[14]['name'] = "validate_joining.js";
            $script_arr[14]['type'] = "js";
            $script_arr[14]['loc'] = "footer";
        }
        //
        //E-pin Transfer
        if ($url_id == 193) {
            $script_arr[3]['name'] = "validate_epin_transfer.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }
        //mark as paid
        if ($url_id == 195) {

            $script_arr[8]['name'] = "validate_payout_release.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";

            $script_arr[13]['name'] = "date_time_picker.js";
            $script_arr[13]['type'] = "js";
            $script_arr[13]['loc'] = "footer";
        }

        if ($url_id == 183) {
            $script_arr[3]['name'] = "validate_admin_profile.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }
        if ($url_id == 196) {
            $script_arr[0]['name'] = "package_upgrade.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }
        if ($url_id == 199) {
            $script_arr[7]["name"] = "date_time_picker.js";
            $script_arr[7]["type"] = "js";
            $script_arr[7]["loc"] = "footer";

            $script_arr[8]["name"] = "validate_search.js";
            $script_arr[8]["type"] = "js";
            $script_arr[8]["loc"] = "footer";

            $script_arr[9]["name"] = "misc.js";
            $script_arr[9]["type"] = "js";
            $script_arr[9]["loc"] = "footer";
        }

        if ($url_id == 200) {
            $script_arr[0]['name'] = "validate_auto_responder.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "auto_responder.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
        }

        if ($url_id == 127) {
            $script_arr[7]['name'] = "date_time_picker.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
        }

        if ($url_id == 201) {
            $script_arr[4]['name'] = "Epinvalidation.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";

            $script_arr[6]['name'] = "jquery-ui.min.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
        }
        if ($url_id == 212 || $url_id == 213 || $url_id == 205 || $url_id == 206 || $url_id == 219) {
            $script_arr[4]['name'] = "Epinvalidation.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";

            $script_arr[6]['name'] = "jquery-ui.min.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
        }
        if ($url_id == 217) {
            $script_arr[7]['name'] = "date_time_picker.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "validate_epin_transfer_report.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
        }

        if ($url_id == 223) {
            $script_arr[0]['name'] = "validate_configuration.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 224) {
            $script_arr[3]['name'] = "upgrade_package.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }

        if ($url_id == 225) {
            $script_arr[3]['name'] = "upgrade_package.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "bootbox.min.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
        }

        if ($url_id == 227) {
            
        }
        if ($url_id == 229) {
            $script_arr[0]['name'] = "validate_monthly_expense.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "date_time_picker.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
        }
        if ($url_id == 228 || $url_id == 239 || $url_id == 240) {
            $script_arr[0]['name'] = "validate_product.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
        }

        if ($url_id == 259) {
            $script_arr[0]['name'] = "validate_register.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "state.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "calendar-win2k-cold-1.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "register_link.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "jscalendar/calendar.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "jscalendar/calendar-setup.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "jscalendar/lang/calendar-en.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "style-popup.css";
            $script_arr[7]['type'] = "css";
            $script_arr[7]['loc'] = "header";
            $script_arr[8]['name'] = "momentjs/moment.js";
            $script_arr[8]['type'] = "plugins/js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "combodate/combodate.js";
            $script_arr[9]['type'] = "plugins/js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "form-wizard.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[11]['type'] = "plugins/css";
            $script_arr[11]['loc'] = "header";
            $script_arr[12]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[12]['type'] = "plugins/js";
            $script_arr[12]['loc'] = "footer";
        }

        if ($url_id == 260) {
            $script_arr[0]['name'] = "jquery-validation/dist/jquery.validate.min.js";
            $script_arr[0]['type'] = "plugins/js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "validate_subscribe_contact_us.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
        }

        if ($url_id == 276 || $url_id == 278  || $url_id == 277 || $url_id == 281) {
            $script_arr[1]['name'] = "validate_select_user.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
        }
        if ($url_id == 286) {
            $script_arr[3]['name'] = "validate_rank_configuration.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }
        
        return $script_arr;
    }

}
