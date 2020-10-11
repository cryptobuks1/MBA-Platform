<?php

require_once 'Inf_Controller.php';

class Password extends Inf_Controller
{

    function __construct()
    {
        parent::__construct();
//        $this->url_permission('password/change_password');
    }

    function change_password()
    {
        $title = lang('change_password');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'change-password';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('change_password');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('change_password');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        //Function start for change password
        $user_type = $this->LOG_USER_TYPE;
        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;
        $this->set('user_type', $user_type);

        $preset_demo = 'no';
        // UNCOMMENT FOLLOWING LINES OF CODE WHEN UPLOADING TO infinitemlmsoftware.com
//        $table_prefix = substr($this->db->dbprefix, 0, -1);
//        if ((DEMO_STATUS == 'yes') && (($table_prefix == 5552) || ($table_prefix == 5553) || ($table_prefix == 5554) || ($table_prefix == 5555) || ($table_prefix == 5556))) {
//            $preset_demo = 'yes';
//        }


        $this->set('preset_demo', $preset_demo);
        $this->setView();
    }

    function validate_change_password()
    {
        $user_id     = $this->LOG_USER_ID;
        $post_arr    = $this->input->post(null, true);
        $post_arr    = $this->validation_model->stripTagsPostArray($post_arr);
        $current_pwd = base64_decode(urldecode($post_arr['current_pwd_admin']));
        $new_pwd     = base64_decode(urldecode($post_arr['new_pwd_admin']));
        $cf_pwd      = base64_decode(urldecode($post_arr['confirm_pwd_admin']));
        $val         = $this->password_model->validatePswd($new_pwd);
        $dbpassword  = $this->password_model->selectPassword($user_id);

        if (!$current_pwd) {
            $msg = lang('you_must_enter_your_current_password');
            $this->redirect($msg, 'password/change_password', false);
        } elseif (!$new_pwd) {
            $msg = lang('you_must_enter_new_password');
            $this->redirect($msg, 'password/change_password', false);
        } elseif (!$val) {
            $msg = lang('special_chars_not_allowed');
            $this->redirect($msg, 'password/change_password', false);
        } elseif (!password_verify($current_pwd, $dbpassword) || strlen($new_pwd) < 6) {
            $msg = lang('your_current_password_is_incorrect_or_new_password_is_too_short');
            $this->redirect($msg, 'password/change_password', false);
        } elseif (strcmp($new_pwd, $cf_pwd) != 0) {
            $msg = lang('password_mismatch');
            $this->redirect($msg, 'password/change_password', false);
        } else
            return true;
    }

    function post_change_password()
    {
        $user_type = $this->LOG_USER_TYPE;
        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;
        if ($this->input->post('change_pass_button_admin') && $this->validate_change_password()) {
            // UNCOMMENT FOLLOWING 3 LINES OF CODE WHEN UPLOADING TO infinitemlmsoftware.com
//            if ($preset_demo == 'yes' && (($user_name == 'INF750391') || ($user_name == 'INF823741') || ($user_name == 'INF792691') || ($user_name == 'INF793566') || ($user_name == 'INF867749'))) {
//                $msg = lang('this_option_is_not_available_for_preset_users');
//                $this->redirect($msg, 'tran_pass/change_passcode', FALSE);
//            }
            $post_arr = $this->input->post(null, true);
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $new_pwd  = base64_decode(urldecode($post_arr['new_pwd_admin']));
            $new_pwd_md5 = password_hash($new_pwd, PASSWORD_DEFAULT);
            $admin_id = $this->validation_model->getAdminId();
            if (DEMO_STATUS == 'yes') {
                $preset_user = $this->validation_model->getPresetUser($admin_id);
                if ($preset_user == $user_name) {
                    $msg = 'You can\'t change preset user password';
                    $this->redirect($msg, "password/change_password", false);
                }
            }
            $update = $this->password_model->updatePassword($new_pwd_md5, $user_id, $user_type);
            if ($update) {

                if ($this->MODULE_STATUS['opencart_status_demo'] == "yes" && $this->MODULE_STATUS['opencart_status'] == "yes") {
                    $customer_id = $this->validation_model->getOcCustomerId($user_id);
                    $this->password_model->updateStorePassword($new_pwd, $customer_id);
                }
                $send_details = array();
                $type = 'change_password';
                $send_details['full_name'] = $this->validation_model->getUserFullName($user_id);
                $send_details['new_password'] = $new_pwd;
                $send_details['email'] = $this->validation_model->getUserEmailId($user_id);
                $send_details['first_name'] = $this->validation_model->getUserData($user_id, "user_detail_name");
                $send_details['last_name'] = $this->validation_model->getUserData($user_id, "user_detail_second_name");
                $result = $this->mail_model->sendAllEmails($type, $send_details);
                $this->validation_model->insertUserActivity($user_id, 'password changed', $user_id);
                $msg = lang('password_updated_successfully');
                $this->redirect($msg, 'password/change_password', true);
            } else {
                $msg = lang('error_on_password_updation');
                $this->redirect($msg, 'password/change_password', false);
            }
        }
    }

}
