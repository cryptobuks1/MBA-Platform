<?php

require_once 'Inf_Controller.php';

class Password extends Inf_Controller
{

    function __construct()
    {
        parent::__construct();
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

        $user_type = $this->LOG_USER_TYPE;
        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;
        if ($user_type == 'employee') {
            $user_id = $this->validation_model->getAdminId();
            $tab2 = ' active';
            $tab1 = '';
        } else {
            $tab1 = ' active';
            $tab2 = '';
        }
        $table_prefix = $this->password_model->table_prefix;
        $user_ref_id = str_replace('_', '', $table_prefix);
        $this->set('user_type', $user_type);
        $msg = '';

        $preset_demo = 'no';

        if ($this->session->userdata('inf_pass_tab_active_arr')) {
            $tab_arr = $this->session->userdata('inf_pass_tab_active_arr');
            $tab1 = $tab_arr['tab1'];
            $tab2 = $tab_arr['tab2'];
            $this->session->unset_userdata('inf_pass_tab_active_arr');
        }

        $this->set('preset_demo', $preset_demo);
        $this->set('user_type', $user_type);
        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);
        $this->setView();
    }

    function validate_change_password_change_pass_admin()
    {

        $tab1 = ' active';
        $tab2 = '';
        $this->session->set_userdata('inf_pass_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2));

        $user_id     = $this->LOG_USER_ID;
        $post_arr    = $this->validation_model->stripTagsPostArray($this->input->post());
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

    function validate_change_password_change_pass_common()
    {
        $tab1 = '';
        $tab2 = ' active';
        $this->session->set_userdata('inf_pass_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2));

        $post_arr     = $this->validation_model->stripTagsPostArray($this->input->post());
        $name_user    = $post_arr['user_name_common'];
        $id_user      = $this->validation_model->userNameToID($name_user);
        $new_pwd_user = base64_decode(urldecode($post_arr['new_pwd_common']));
        $cf_pwd_user  = base64_decode(urldecode($post_arr['confirm_pwd_common']));
        $val          = $this->password_model->validatePswd($new_pwd_user);
        $admin_id     = $this->validation_model->getAdminId();

        if (!$name_user) {
            $msg = lang('You_must_enter_user_name');
            $this->redirect($msg, 'password/change_password', false);
        } elseif (!$this->password_model->isUserNameAvailable($name_user)) {
            $msg = lang('invalid_user_name');
            $this->redirect($msg, 'password/change_password', false);
        } elseif (!$new_pwd_user || !$cf_pwd_user) {
            $msg = lang('you_must_enter_new_password');
            $this->redirect($msg, 'password/change_password', false);
        } elseif (!$val) {
            $msg = lang('special_chars_not_allowed');
            $this->redirect($msg, 'password/change_password', false);
        } elseif (strlen($new_pwd_user) < 6) {
            $msg = lang('New_password_is_too_short');
            $this->redirect($msg, 'password/change_password', false);
        } elseif (strcmp($new_pwd_user, $cf_pwd_user) != 0) {
            $msg = lang('password_mismatch');
            $this->redirect($msg, 'password/change_password', false);
        } elseif ($admin_id == $id_user) {
            $msg = lang('You_cant_change_admin_password');
            $this->redirect($msg, 'password/change_password', false);
        } else
            return true;
    }

    function validate_username()
    {
        $username = ($this->input->post('username', true));
        if ($username != '') {
            $valid = 'no';
            if ($this->password_model->isUserNameAvailable($username)) {
                $valid = 'yes';
            }
            echo $valid;
            exit();
        }
    }
    function post_change_password()
    {
        $user_type = $this->LOG_USER_TYPE;
        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;
        if ($user_type == 'employee') {
            $user_id = $this->validation_model->getAdminId();
            $tab2 = ' active';
            $tab1 = '';
        } else {
            $tab1 = ' active';
            $tab2 = '';
        }
        $table_prefix = $this->password_model->table_prefix;
        $user_ref_id = str_replace('_', '', $table_prefix);
        $preset_demo = 'no';
        ///admin password......
        if ($this->input->post('change_pass_button_admin') && $this->validate_change_password_change_pass_admin()) {
//            if($preset_demo == 'yes') {
//                $msg = lang('this_option_is_not_available_in_preset_demos');
//                $this->redirect($msg, 'password/change_password', FALSE);
//            }
            $post_arr = $this->input->post(null, true);
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $new_pwd = base64_decode(urldecode($post_arr['new_pwd_admin']));
            $new_pwd_md5 = password_hash($new_pwd, PASSWORD_DEFAULT);
            if (DEMO_STATUS == 'yes') {
                $is_preset_demo = $this->validation_model->isPresetDemo($user_id);
                if ($is_preset_demo) {
                    $msg = 'You can\'t change preset admin password';
                    $this->redirect($msg, "password/change_password", false);
                }
            }
            $update = $this->password_model->updatePassword($new_pwd_md5, $user_id, $user_type, $user_ref_id);
            if ($update) {

                if ($this->MODULE_STATUS['opencart_status_demo'] == "yes" && $this->MODULE_STATUS['opencart_status'] == "yes") {
                    $customer_id = $this->validation_model->getOcCustomerId($user_id);
                    $this->password_model->updateStorePassword($new_pwd, $customer_id);
                }
                $send_details = array();
                $type = 'change_password';
                $email = $this->validation_model->getUserEmailId($user_id);
                $send_details['full_name'] = $this->validation_model->getUserFullName($user_id);
                $send_details['new_password'] = $new_pwd;
                $send_details['email'] = $email;
                $send_details['first_name'] = $this->validation_model->getUserData($user_id, "user_detail_name");
                $send_details['last_name'] = $this->validation_model->getUserData($user_id, "user_detail_second_name");

                $result = $this->mail_model->sendAllEmails($type, $send_details);

                $data = serialize($send_details);
                $this->validation_model->insertUserActivity($user_id, 'password changed', $user_id, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $user_id, 'change_password', 'Password Changed');
                }
                //

                $msg = lang('password_updated_successfully');
                $this->redirect($msg, 'password/change_password', true);
            } else {
                $msg = lang('error_on_password_updation');
                $this->redirect($msg, 'password/change_password', false);
            }
        }
        //admin passwod ends
    }
    function post_change_user_password()
    {
        $user_type = $this->LOG_USER_TYPE;
        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;
        if ($user_type == 'employee') {
            $user_id = $this->validation_model->getAdminId();
            $tab2 = ' active';
            $tab1 = '';
        } else {
            $tab1 = ' active';
            $tab2 = '';
        }
        $table_prefix = $this->password_model->table_prefix;
        $user_ref_id = str_replace('_', '', $table_prefix);
        $preset_demo = 'no';
        //user password in admin
        if ($this->input->post('change_pass_button_common') && $this->validate_change_password_change_pass_common()) {
            $post_arr = $this->input->post(null, true);
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);

            $name_user          = $post_arr['user_name_common'];
            $id_user            = $this->validation_model->userNameToID($name_user);
            $new_pwd_user       = base64_decode(urldecode($post_arr['new_pwd_common']));
            $new_pwd_user_md5   = password_hash($new_pwd_user, PASSWORD_DEFAULT);

            if ($preset_demo == 'yes' && (($name_user == 'INF750391') || ($name_user == 'INF823741') || ($name_user == 'INF792691') || ($name_user == 'INF793566') || ($name_user == 'INF867749'))) {
                $msg = lang('this_option_is_not_available_for_preset_users');
                $this->redirect($msg, 'password/change_password', false);
            }
            if (DEMO_STATUS == 'yes') {
                $preset_user = $this->validation_model->getPresetUser($user_id);
                if ($preset_user == $name_user) {
                    $msg = 'You can\'t change preset user password';
                    $this->redirect($msg, "password/change_password", false);
                }
            }
            $update = $this->password_model->updatePassword($new_pwd_user_md5, $id_user);
            if ($update) {
                if ($this->MODULE_STATUS['opencart_status_demo'] == "yes" && $this->MODULE_STATUS['opencart_status'] == "yes") {
                    $customer_id = $this->validation_model->getOcCustomerId($id_user);
                    $this->password_model->updateStorePassword($new_pwd_user, $customer_id);
                }
                $this->validation_model->updateForceLogout($id_user, 1);
                $send_details = array();
                $type = 'change_password';
                $email = $this->validation_model->getUserEmailId($id_user);
                $send_details['full_name'] = $this->validation_model->getUserFullName($id_user);
                $send_details['new_password'] = $new_pwd_user;
                $send_details['email'] = $email;
                $send_details['first_name'] = $this->validation_model->getUserData($user_id, "user_detail_name");
                $send_details['last_name'] = $this->validation_model->getUserData($user_id, "user_detail_second_name");

                $result = $this->mail_model->sendAllEmails($type, $send_details);

                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'password change', $this->LOG_USER_ID);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'change_password', 'Password Changed');
                }
                //

                $msg = lang('password_updated_successfully');
                $this->redirect($msg, 'password/change_password', true);
            } else {
                $msg = lang('error_on_password_updation');
                $this->redirect($msg, 'password/change_password', false);
            }
            //user password in admin end
        }
    }
    function getUsersList($user_name = "")
    {
       // $letters = preg_replace("/[^a-z0-9 ]/si", "", $user_name);
        $user_detail = $this->password_model->getUsersList($user_name);
        echo $user_detail;
    }
}
