<?php

require_once 'Inf_Controller.php';

class tran_pass extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function change_passcode($t_open=null) {
        $title = lang('transaction_password');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = 'change-passcode';
        $this->set('help_link', $help_link);

        $this->load->model('captcha_model', '', TRUE);
        $this->load->model('login_model', '', TRUE);

        $this->HEADER_LANG['page_top_header'] = lang('transaction_password');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('transaction_password');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $tab1 = ' checked';
        $tab2 = '';

        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;
        $user_type = $this->LOG_USER_TYPE;

        if ($t_open == 'forgot') {
            $tab2 = 'checked';
            $tab1 = '';
            $tab3 = '';
        }

        $preset_demo = 'no';
        // UNCOMMENT FOLLOWING LINES OF CODE WHEN UPLOADING TO infinitemlmsoftware.com
//        $table_prefix = substr($this->db->dbprefix, 0, -1);
//        if ((DEMO_STATUS == 'yes') && (($table_prefix == 5552) || ($table_prefix == 5553) || ($table_prefix == 5554) || ($table_prefix == 5555) || ($table_prefix == 5556))) {
//            $preset_demo = 'yes';
//        }

        if ($this->input->post('change') && $this->validate_change_passcode()) {
            // UNCOMMENT FOLLOWING 3 LINES OF CODE WHEN UPLOADING TO infinitemlmsoftware.com
//            if ($preset_demo == 'yes' && (($user_name == 'INF750391') || ($user_name == 'INF823741') || ($user_name == 'INF792691') || ($user_name == 'INF793566') || ($user_name == 'INF867749'))) {
//                $msg = lang('this_option_is_not_available_for_preset_users');
//                $this->redirect($msg, 'tran_pass/change_passcode', FALSE);
//            }

            $post_arr = $this->input->post(NULL, TRUE);
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $new_passcode = $post_arr['new_passcode'];
            $old_passcode = $post_arr['old_passcode'];
            $passcode = $this->tran_pass_model->getUserPasscode($user_id);
            if (!password_verify($old_passcode, $passcode)) {
                $msg = lang('your_current_transaction_password_is_incorrect');
                $this->redirect($msg, "tran_pass/change_passcode", false);
            } else {
                $result = $this->tran_pass_model->updatePasscode($user_id, $new_passcode, $passcode);
                if ($result) {
                    $this->tran_pass_model->sentTransactionPasscode($user_id, $new_passcode, $user_name);
                    $this->validation_model->insertUserActivity($user_id, 'transaction password changed', $user_id);
                    $msg = lang('transaction_password_changed_successfully');
                    $this->redirect($msg, "tran_pass/change_passcode", true);
                } else {
                    $msg = lang('sorry_failed_to_update_try_again');
                    $this->redirect($msg, "tran_pass/change_passcode", false);
                }
            }
        }

        if ($this->input->post("forgot_password_submit")) {
        $tab1 = '';
        $tab2 = 'checked';
        $this->session->set_userdata('inf_tranpass_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2));
           $this->form_validation->set_rules('captcha', lang('captcha'), 'required');
           $validate_form = $this->form_validation->run();
           if($validate_form){
            $captcha = $this->session->userdata('inf_captcha');
            if ((empty($captcha) || trim(strtolower($_REQUEST['captcha'])) != $captcha)) {
                $captcha_message = lang("invalid_captcha");
                $this->redirect("$captcha_message", "tran_pass/change_passcode", false);
            }
            $user_id = $this->LOG_USER_ID;
            $e_mail = $this->validation_model->getUserEmailId($user_id);
            $check_result = $this->validation_model->checkEmail($user_id, $e_mail);
            if ($check_result) {
                $this->tran_pass_model->sendEmail($user_id, $e_mail);

                $msg = $this->lang->line('your_request_has_been_accepted_we_will_send_you_confirmation_mail_please_follow_that_instruction');
                $this->redirect("$msg", "tran_pass/change_passcode", TRUE);
            } else {
                $msg = $this->lang->line('invalid_username_or_email');
                $this->redirect("$msg", "tran_pass/change_passcode", FALSE);
            }
           }
        }

        if ($this->session->userdata('inf_tranpass_tab_active_arr')) {
            $tab_arr = $this->session->userdata('inf_tranpass_tab_active_arr');
            $tab1 = $tab_arr['tab1'];
            $tab2 = $tab_arr['tab2'];
            $this->session->unset_userdata("inf_tranpass_tab_active_arr");
        }

        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);
        $this->set('preset_demo', $preset_demo);
        $this->setView();
    }

    function validate_change_passcode() {
        $tab1 = 'checked';
        $tab2 = '';
        $this->session->set_userdata('inf_tranpass_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2));
        $this->form_validation->set_rules('old_passcode', lang('old_passcode'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('new_passcode', lang('new_password'), 'trim|required|strip_tags|min_length[8]|alpha_numeric');
        $this->form_validation->set_rules('re_new_passcode', lang('re_new_passcode'), 'trim|required|strip_tags|matches[new_passcode]');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }
}
