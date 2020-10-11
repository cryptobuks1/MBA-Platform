<?php

require_once 'Inf_Controller.php';

class tran_pass extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function change_passcode() {
        $title = lang('transaction_password');
        $this->set('title', $this->COMPANY_NAME . " | $title");
        $this->load->model('captcha_model', '', TRUE);
        $this->load->model('login_model', '', TRUE);

        $help_link = 'change-passcode';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('transaction_password');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('transaction_password');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $tab1 = ' checked';
        $tab2 = '';
        $tab3 = '';
        $user_name = $this->LOG_USER_NAME;
        $user_id = $this->LOG_USER_ID;
        $user_type = $this->LOG_USER_TYPE;

        if ($user_type == 'employee') {
            $tab2 = ' checked';
            $tab1 = '';
            $tab3 = '';
        }

        $preset_demo = 'no';
        if ($this->input->post('change_tran') && $this->validate_change_passcode()) {
//            if ($preset_demo == 'yes') {
//                $msg = lang('this_option_is_not_available_in_preset_demos');
//                $this->redirect($msg, 'tran_pass/change_passcode', FALSE);
//            }
            $old_passcode = ($this->input->post('old_passcode', TRUE));
            $new_passcode = ($this->input->post('new_passcode', TRUE));
            $passcode = $this->tran_pass_model->getUserPasscode($user_id);

            if (!password_verify($old_passcode, $passcode)) {
                $msg = lang('your_current_transaction_password_is_incorrect');
                $this->redirect($msg, "tran_pass/change_passcode", FALSE);
            } else {
                $result = $this->tran_pass_model->updatePasscode($user_id, $new_passcode, $passcode);
                if ($result) {
                    $this->tran_pass_model->sentTransactionPasscode($user_id, $new_passcode, $user_name);
                    $data_array['user_id'] = $user_id;
                    $data_array['new_tran_password'] = $new_passcode;
                    $data = serialize($data_array);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'transaction password changed', $user_id, $data);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $user_id, 'change_transaction_password', 'Transaction Password Changed');
                    }
                    //

                    $msg = lang('transaction_password_updated_successfully');
                    $this->redirect($msg, "tran_pass/change_passcode", TRUE);
                } else {
                    $msg = lang('sorry_failed_to_update_try_again');
                    $this->redirect($msg, "tran_pass/change_passcode", FALSE);
                }
            }
        }

        if ($this->input->post('change_user') && $this->validate_change_passcode_user()) {
            $user_name_submit = ($this->input->post('user_name', TRUE));
            $user_id_submit = $this->validation_model->userNameToID($user_name_submit);
            if ($user_id_submit) {
                $user_type_submit = $this->validation_model->getUserType($user_id_submit);
                if ($user_type_submit == 'admin') {
                    $msg = lang('You_cant_change_admin_transaction_password');
                    $this->redirect($msg, "tran_pass/change_passcode", FALSE);
                } else {
                    $new_passcode_user = ($this->input->post('new_passcode_user', TRUE));
                    $result = $this->tran_pass_model->updatePasscode($user_id_submit, $new_passcode_user);
                    if ($result) {
                        $this->tran_pass_model->sentTransactionPasscode($user_id_submit, $new_passcode_user, $user_name_submit);
                        $data_array['user_id'] = $user_id_submit;
                        $data_array['new_tran_password'] = $new_passcode_user;
                        $data = serialize($data_array);
                        $this->validation_model->insertUserActivity($user_id_submit, $user_name_submit."'s transaction password changed", $this->LOG_USER_ID, $data);
                        if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, $user_name_submit."'s Transaction password changed", $user_name_submit."'s Transaction password changed");
                         }
                        $msg = lang('transaction_password_updated_successfully');
                        $this->redirect($msg, "tran_pass/change_passcode", true);
                    } else {
                        $msg = lang('sorry_failed_to_update_try_again');
                        $this->redirect($msg, "tran_pass/change_passcode", FALSE);
                    }
                }
            } else {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'tran_pass/change_passcode', FALSE);
            }
        }

        if ($this->input->post("forgot_password_submit") && $this->validate_forgot_trans_password()) {
            $user_name = $this->input->post("user_name", TRUE);
            $captcha = $this->session->userdata('inf_captcha');
            $admin_user_name = $this->ADMIN_USER_NAME;
            $user_id = $this->validation_model->userNameToID($user_name);
            $e_mail = $this->input->post("e_mail", TRUE);

            $check_result = $this->validation_model->checkEmail($user_id, $e_mail);
            if(!$check_result && trim(strtolower($_REQUEST['captcha'])) == $captcha){
                $msg = $this->lang->line('invalid_username_or_email');
                $this->redirect("$msg", "tran_pass/change_passcode", FALSE);
            }
            if ((empty($captcha) || trim(strtolower($_REQUEST['captcha'])) != $captcha)) {
                $captcha_message = lang("invalid_captcha");
                $this->redirect("$captcha_message", "tran_pass/change_passcode", false);
            }
//            echo $check_result;die();
            if ($check_result) {
                $this->tran_pass_model->sendEmail($user_id, $e_mail,$admin_user_name);

                $msg = $this->lang->line('your_request_has_been_accepted_we_will_send_you_confirmation_mail_please_follow_that_instruction');
                $this->redirect("$msg", "tran_pass/change_passcode", TRUE);
            } else {
                $msg = $this->lang->line('invalid_username_or_email');
                $this->redirect("$msg", "tran_pass/change_passcode", FALSE);
            }
        }

        if ($this->session->userdata('inf_tranpass_tab_active_arr')) {
            $tab_arr = $this->session->userdata('inf_tranpass_tab_active_arr');
            $tab1 = $tab_arr['tab1'];
            $tab2 = $tab_arr['tab2'];
            $tab3 = $tab_arr['tab3'];
            $this->session->unset_userdata("inf_tranpass_tab_active_arr");
        }

        $this->set('preset_demo', $preset_demo);
        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);
        $this->set('tab3', $tab3);

        $this->setView();
    }

    function validate_change_passcode() {
        $tab1 = 'checked';
        $tab2 = '';
        $tab3 = '';
        $this->session->set_userdata('inf_tranpass_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3));

        $this->form_validation->set_rules('old_passcode', lang('old_passcode'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('new_passcode', lang('new_password'), 'trim|required|strip_tags|min_length[8]|alpha_numeric');
        $this->form_validation->set_rules('re_new_passcode', lang('re_new_passcode'), 'trim|required|strip_tags|matches[new_passcode]');
        $validate_form = $this->form_validation->run();

        return $validate_form;
    }

    function validate_change_passcode_user() {
        $tab1 = '';
        $tab2 = 'checked';
        $tab3 = '';
        $this->session->set_userdata('inf_tranpass_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3));

        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|user_exists|strip_tags');
        $this->form_validation->set_rules('new_passcode_user', lang('new_password'), 'trim|required|strip_tags|min_length[8]|alpha_numeric');
        $this->form_validation->set_rules('re_new_passcode_user', lang('re_new_passcode'), 'trim|required|strip_tags|matches[new_passcode_user]');
        $validate_form = $this->form_validation->run();

        return $validate_form;
    }
    function validate_forgot_trans_password() {
        $tab1 = '';
        $tab2 = '';
        $tab3 = 'checked';
        $this->session->set_userdata('inf_tranpass_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3));
        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|user_exists|strip_tags');
        $this->form_validation->set_rules('e_mail', lang('email'), 'trim|required|strip_tags|valid_email');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }
    function get_email($user_name = '') {
        if ($user_name != '') {
            $flag = false;
            return $flag;
        } else {
            $echo = 'no';
            $username = ($this->input->post('user_name', TRUE));
            $user_id = $this->validation_model->userNameToID($username);
            if ($user_id) {
                $email = $this->validation_model->getUserEmailId($user_id);
                $echo = $email;
            }
            echo $echo;
            exit();
        }
    }

}
