<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'Inf_Controller.php';

class Login extends Inf_Controller {

    function __construct() {
        parent::__construct();
         $this->load->model('configuration_model');
    }

    function index($url_user_name = "") {

        $title = lang('login');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "login";
        $this->set("help_link", $help_link);

        $this->load_langauge_scripts();

        $is_logged_in = $this->checkSession();
        if ($is_logged_in) {
            $this->redirect("", 'home', true);
        }
        if ($this->session->userdata('inf_user_invalid_count')) {
            if ($this->session->userdata('inf_user_invalid_count') >= 3) {
                $this->CAPTCHA_STATUS = 'yes';
            }
        }

        $url_user_name_decode = urldecode($url_user_name);
        $url_user_name_decode = str_replace("_", "/", $url_user_name_decode);
        $user_user_name = $this->encrypt->decode($url_user_name_decode);

        $isvalid = $this->login_model->isUsernameValid($user_user_name);
        if (!$isvalid) {
            $url_user_name = $user_user_name = '';
        }

        $this->set('url_user_name', $user_user_name);
        $this->set('CAPTCHA_STATUS', $this->CAPTCHA_STATUS);
        $this->setView();
    }

    function verifylogin() {
        $path = '';
        $module_status = [];

        $u_user_name = $this->input->post('user_username', TRUE);
        $captcha_user = $this->session->userdata('inf_captcha_user');
        $module_status = $this->inf_model->trackModule();
        
        if ($this->session->userdata('inf_user_invalid_count')) {
            $invalid_count = $this->session->userdata('inf_user_invalid_count');
        } else {
            $invalid_count = 0;
        }

        $captcha_status = $this->session->userdata('inf_user_invalid_count');
        $user_name_encode = $this->encrypt->encode($u_user_name);
        $user_name_encode = str_replace("/", "_", $user_name_encode);
        $user_name_encode = urlencode($user_name_encode);

        if (($this->MAINTENANCE_MODE || $this->BLOCK_LOGIN ) && ($u_user_name != $this->ADMIN_USER_NAME)) {
            $this->redirect(lang('you_can`t_login_system'), "login/index/$user_name_encode", false);
        }
        
//        if ($captcha_status >= 3 && $this->MODULE_STATUS['captcha_status'] == 'yes') {
        if ($captcha_status >= 3 && $module_status['captcha_status'] == 'yes') {
            if ((empty($captcha_user) || trim(strtolower($_REQUEST['captcha_user'])) != $captcha_user)) {
                $captcha_message = $this->lang->line('invalid_captcha');
                $this->redirect("$captcha_message", "login/index/$user_name_encode", false);
            }
        }

        $this->form_validation->set_rules('user_username', lang('user_name'), 'trim|required|strip_tags|min_length[3]|max_length[30]|htmlentities|callback_check_charaters');
        $this->form_validation->set_rules('user_password', lang('password'), 'trim|required|strip_tags|min_length[5]|max_length[30]|callback_check_database');
        $login_res = $this->form_validation->run();
        $bit_status = $this->validation_model->checkBitcoinStatus();
        $auth_status = $this->validation_model->getAuthStatus();

        if ($login_res) {
            $user_name = $this->input->post('user_username', TRUE);
            $user_id = $this->validation_model->userNameToID($user_name);
            $this->validation_model->updateForceLogout($user_id, 0);
            if ($bit_status == 'yes' && $this->configuration_model->getPaymentStatus('Payment Gateway')=='yes' && $auth_status == 'yes') {
                $user_name = $this->input->post('user_username', TRUE);
                $password = $this->input->post('user_password', TRUE);
                $login = $this->validation_model->loginForQr($user_name, $password, null);
                require_once dirname(FCPATH) . '/vendor/2fa/TwoFactorAuth.php';
                $tfa = new TwoFactorAuth($user_name, 6, 30);
                if ($this->session->userdata('last_logged_user')) {
                    if ($this->session->userdata('last_logged_user') != $user_name) {
                        $this->session->unset_userdata('show_qr_code');
                        $this->session->unset_userdata('auth_key');
                    }
                }
                if (!$this->session->userdata('show_qr_code')) {
                    $this->session->set_userdata('show_qr_code', 'show');
                }
                   
                $user_id = $this->validation_model->userNameToID($user_name);                
                $goc_key = $this->validation_model->getGocKey($user_id);
                if (!empty($goc_key)) {
                    $secret_key = $goc_key;
                } else {
                    $secret_key = $tfa->createSecret();
                }
                $qr_code_image = $tfa->getQRCodeImageAsDataUri($user_name, $secret_key);
                $this->session->set_userdata('auth_key', $secret_key);
                $this->session->set_flashdata('auth_qr_code', $qr_code_image);
                $this->session->set_flashdata('inf_pre_login', $login);
                $this->redirect('', "login/one_time_password", true);
            } else {
            $this->session->unset_userdata('inf_captcha_user');
            $this->session->unset_userdata('inf_user_invalid_count');
            if ($this->session->userdata("redirect_url")) {
                $redirect_url = $this->session->userdata("redirect_url");
                $this->session->unset_userdata("redirect_url");
                if (strcmp($redirect_url, "register/") >= 0) {
                    $this->redirect("", $redirect_url, true);
                } else {
                    $this->redirect("", $redirect_url, true);
                }
            } else {
                $this->redirect("", "home", true);
            }
        }
        } else {
            $invalid_count++;
            $this->session->set_userdata('inf_user_invalid_count', $invalid_count);
            $u_user_name = $this->input->post('user_username', TRUE);
             if (!$this->check_charaters($u_user_name))
                 $path = "login/index";
            $valid = $this->login_model->isUsernameValid($u_user_name);
            if ($valid) {
                $path = "login/index/$user_name_encode";
            }

            $msg = $this->lang->line('invalid_user_name_or_password');
            $this->redirect("$msg", "$path", false);
        }
    }

    function check_database($password) {
        $flag = false;

        $login_details = $this->input->post(NULL, TRUE);
        $login_details = $this->validation_model->stripTagsPostArray($login_details);

        $username = $login_details['user_username'];

        $login_result = $this->login_model->login($username, $password);
if (!$this->check_charaters($username)) {
                return $flag;
            }
        if ($login_result) {          
            $bit_status = $this->validation_model->checkBitcoinStatus();
            $auth_status = $this->validation_model->getAuthStatus();
            $payment_gateway_status = $this->configuration_model->getPaymentStatus('Payment Gateway');
            if ($bit_status == 'no' || $payment_gateway_status != 'yes' || $auth_status == 'no') {
                $this->login_model->setUserSessionDatas($login_result);
            }
            $flag = true;
        } else {
            $flag = false;
        }
        return $flag;
    }

    function login_employee($url_user_name = '') {
        $title = $this->lang->line('login');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $is_logged_in = $this->checkSession();
        if ($is_logged_in) {
            $this->redirect("", 'home', true);
        }

        $this->load_langauge_scripts();

        $url_user_name_decode = urldecode($url_user_name);
        $url_user_name_decode = str_replace("_", "/", $url_user_name_decode);
        $user_user_name = $this->encrypt->decode($url_user_name_decode);

        if (!$this->login_model->isValidEmployee($user_user_name)) {
            $user_user_name = '';
        }

        $this->set("employee_username", $user_user_name);

        $this->setView();
    }

    function verify_employee_login() {
        $login_details = $this->input->post(NULL, TRUE);
        $login_details = $this->validation_model->stripTagsPostArray($login_details);

        $employee_username = trim($login_details['user_username']);

        $this->form_validation->set_rules('user_username', lang('user_name'), 'trim|required|strip_tags|min_length[3]|max_length[30]|htmlentities|callback_check_charaters');
        $this->form_validation->set_rules('user_password', lang('password'), 'trim|required|strip_tags|min_length[5]|max_length[30]|callback_check_database_employee');
        $login_res = $this->form_validation->run();
        $bit_status = $this->validation_model->checkBitcoinStatus();
        $auth_status = $this->validation_model->getAuthStatus();

        if ($login_res) {
            
            if ($bit_status == 'yes' && $this->configuration_model->getPaymentStatus('Payment Gateway')=='yes' && $auth_status == 'yes') {
                $user_name = $this->input->post('user_username', TRUE);
                $password = $this->input->post('user_password', TRUE);
                $login = $this->validation_model->loginForQr($user_name, $password, $login_type='employee');
                require_once dirname(FCPATH) . '/vendor/2fa/TwoFactorAuth.php';
                $tfa = new TwoFactorAuth($user_name, 6, 30);
                if ($this->session->userdata('last_logged_user')) {
                    if ($this->session->userdata('last_logged_user') != $user_name) {
                        $this->session->unset_userdata('show_qr_code');
                        $this->session->unset_userdata('auth_key');
                    }
                }
                if (!$this->session->userdata('show_qr_code')) {
                    $this->session->set_userdata('show_qr_code', 'show');
                }
                    
                $user_id = $this->validation_model->userNameToID($user_name);                
                $goc_key = $this->validation_model->getGocKey($user_id);
                if (!empty($goc_key)) {
                    $secret_key = $goc_key;
                } else {
                    $secret_key = $tfa->createSecret();
                }
                $qr_code_image = $tfa->getQRCodeImageAsDataUri($user_name, $secret_key);
                $this->session->set_userdata('auth_key', $secret_key);
                $this->session->set_flashdata('auth_qr_code', $qr_code_image);
                $this->session->set_flashdata('inf_pre_login', $login);
                $this->redirect('', "login/one_time_password", true);
            } else {
                $this->load->model('employee_model');
                $user_id = $this->validation_model->employeeNameToID($this->input->post('user_username'));
                $redirect_page = $this->employee_model->getRedirectPageOnLogin($user_id);
                $this->redirect("", $redirect_page, true);
            }
        } else {
            $employee_username = urlencode(str_replace("/", "_", $employee_username));
           if (!$this->check_charaters($employee_username))
                $path = "login/login_employee";
            else          
            $path = "login/login_employee/$employee_username";
            $msg = $this->lang->line('invalid_user_name_or_password');
            $this->redirect("$msg", "$path", false);
        }
    }

    function check_database_employee($password) {
        $flag = false;

        $login_details = $this->input->post(NULL, TRUE);
        $login_details = $this->validation_model->stripTagsPostArray($login_details);

        $username = $login_details['user_username'];
if (!$this->check_charaters($username)) {
                return $flag;
            }
        $login_result = $this->login_model->login_employee($username, $password);
        if ($login_result) {
            $bit_status = $this->validation_model->checkBitcoinStatus();
            $payment_gateway_status = $this->configuration_model->getPaymentStatus('Payment Gateway');
            $auth_status = $this->validation_model->getAuthStatus();
            if ($bit_status == 'no' || $payment_gateway_status != 'yes' || $auth_status == 'no') {
                $this->login_model->setUserSessionDatasEmployee($login_result);
            }
            $flag = true;
        } else {
            $flag = false;
        }
        return $flag;
    }

    function logout() {
        $user_name_encode = '';
        $user_type = '';

        if ($this->checkSession()) {
            $user_name = $this->LOG_USER_NAME;
            $user_id = $this->LOG_USER_ID;
            $user_type = $this->LOG_USER_TYPE;

            $user_name_encode = $this->encrypt->encode($user_name);
            $user_name_encode = str_replace("/", "_", $user_name_encode);
            $user_name_encode = urlencode($user_name_encode);
            if ($this->LOG_USER_TYPE == 'employee') {
                $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'logout', 'logged out');
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'logged out', $this->LOG_USER_ID, $data = '', $user_type);
            } else {
                if ($user_id) {
                    $this->validation_model->insertUserActivity($user_id, 'Logout', $user_id, $data = '', $user_type);
                }
            }
        }
        foreach ($this->session->userdata as $key => $value) {
            if (strpos($key, 'inf_') === 0) {
                $this->session->unset_userdata($key);
            }
        }

        if ($this->MODULE_STATUS['opencart_status_demo'] == "yes" && $this->MODULE_STATUS['opencart_status'] == "yes") {
            $this->session->unset_userdata('customer_id');
            $this->unset_store_session_data();
        }

        $path = "login";
        if ($user_type == 'employee') {
            $path = "login/login_employee/$user_name_encode";
        } else {
            $path = "login/index/$user_name_encode";
        }

        $msg = $this->lang->line('successfully_logged_out');
        $this->redirect("$msg", $path, true);
    }

    function auto_logout() {
        $user_name_encode = '';
        $user_type = '';

        if ($this->checkSession()) {
            $user_name = $this->LOG_USER_NAME;
            $user_id = $this->LOG_USER_ID;
            $user_type = $this->LOG_USER_TYPE;

            $user_name_encode = $this->encrypt->encode($user_name);
            $user_name_encode = str_replace("/", "_", $user_name_encode);
            $user_name_encode = urlencode($user_name_encode);
        }
        foreach ($this->session->userdata as $key => $value) {
            if (strpos($key, 'inf_') === 0) {
                $this->session->unset_userdata($key);
            }
        }

        if ($this->MODULE_STATUS['opencart_status_demo'] == "yes" && $this->MODULE_STATUS['opencart_status'] == "yes") {
            $this->session->unset_userdata('customer_id');
            $this->unset_store_session_data();
        }
        if($user_type == 'employee'){
             $path = "login/login_employee";
        }
        else {
            $path = "login";
            if ($user_name_encode) {
                $path .= "/lock_screen/$user_name_encode";
            }
        }

        $msg = $this->lang->line('successfully_logged_out');
        $this->redirect("$msg", $path, true);
    }

    function lock_screen($url_user_name = "") {
        $title = lang('auto_login');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "login";
        $this->set("help_link", $help_link);

        $is_logged_in = $this->checkSession();
        if ($is_logged_in) {
            $this->redirect("", 'home', true);
        }

        $this->load_langauge_scripts();

        $url_user_name_decode = urldecode($url_user_name);
        $url_user_name_decode = str_replace("_", "/", $url_user_name_decode);
        $user_user_name = $this->encrypt->decode($url_user_name_decode);

        $user_photo = 'nophoto.jpg';
        $isvalid = $this->login_model->isUsernameValid($user_user_name);
        if (!$isvalid) {
            $this->redirect('', 'login', false);
        } else {
            $user_id = $this->validation_model->userNameToID($url_user_name);
            $user_photo = $this->validation_model->getProfilePicture($user_id);
        }

        $this->set('user_user_name', $user_user_name);
        $this->set('user_photo', $user_photo);
        $this->setView();
    }

    function validate_lock_screen() {

        if ($this->input->post('user_type') == 'employee') {
            $this->form_validation->set_rules('user_password', lang('password'), 'trim|required|strip_tags|min_length[6]|max_length[30]|callback_check_database_employee');
        } else {
            $this->form_validation->set_rules('user_password', lang('password'), 'trim|required|strip_tags|min_length[6]|max_length[30]|callback_check_database');
        }
        $login_res = $this->form_validation->run();
        if ($login_res) {
            $this->redirect("", "home", true);
        } else {
            $login_details = $this->input->post(NULL, TRUE);
            $login_details = $this->validation_model->stripTagsPostArray($login_details);
            $user_name = trim($login_details['user_username']);

            $user_name_encode = $this->encrypt->encode($user_name);
            $user_name_encode = str_replace("/", "_", $user_name_encode);
            $user_name_encode = urlencode($user_name_encode);

            $path = "login/lock_screen/$user_name_encode";
            $msg = $this->lang->line('invalid_password');
            $this->redirect($msg, "$path", false);
        }
    }

    function forgot_password() {
        if ($this->checkSession()) {
            $this->redirect("", 'home', true);
        }
        $this->set("title", $this->COMPANY_NAME . " | " . lang('forgot_password'));

        $this->load_langauge_scripts();

        if ($this->input->post("forgot_password_submit") && $this->validate_forgot_password()) {
            $user_name = $this->input->post("user_name", TRUE);
            $captcha = $this->session->userdata('inf_captcha');
            if ((empty($captcha) || trim(strtolower($_REQUEST['captcha'])) != $captcha)) {
                $captcha_message = lang("invalid_captcha");
                $this->redirect("$captcha_message", "login/forgot_password", false);
            } $user_id = $this->validation_model->userNameToID($user_name);
            $e_mail = $this->input->post("e_mail", TRUE);

            $check_result = $this->validation_model->checkEmail($user_id, $e_mail);
            if ($check_result) {
                $this->validation_model->sendEmail($user_id, $e_mail);

                $msg = $this->lang->line('your_request_has_been_accepted_we_will_send_you_confirmation_mail_please_follow_that_instruction');
                $this->redirect("$msg", "login", TRUE);
            } else {
                $msg = $this->lang->line('invalid_username_or_email');
                $this->redirect("$msg", "login/forgot_password", FALSE);
            }
        }
        $this->setView();
    }

    function validate_forgot_password() {
        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('e_mail', lang('email'), 'trim|required|strip_tags|valid_email');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function reset_password($resetkey = "") {
        if ($this->checkSession()) {
            $this->redirect("", 'home', true);
        }
        $this->set("title", $this->COMPANY_NAME . " | Reset Password");

        $this->load_langauge_scripts();
        $resetkey_original = $resetkey;

        $resetkey = urldecode($resetkey);
        $resetkey = str_replace("_", "/", $resetkey);
        $resetkey = $this->encrypt->decode($resetkey);

        if ($this->input->post("reset_password_submit") && $this->validate_reset_password()) {
            $user_name = $this->input->post("user_name", TRUE);
            $key = $this->input->post("key", TRUE);
            $captcha = $this->session->userdata('inf_captcha');
            if ((empty($captcha) || trim(strtolower($_REQUEST['captcha'])) != $captcha)) {
                $captcha_message = $this->lang->line('invalid_captcha');
                $this->redirect("$captcha_message", "login/reset_password/$resetkey_original", false);
            }
            $user_id = $this->validation_model->userNameToID($user_name);

            $pass_word = $this->input->post("pass", TRUE);
            $confirm_pass = $this->input->post("confirm_pass", TRUE);
            if ($pass_word == $confirm_pass) {
                $res = $this->validation_model->updatePasswordOut($user_id, $pass_word, $key);
                if ($res) {
                    $msg = $this->lang->line('password_updated_successfully');
                    $this->redirect("$msg", "login", true);
                } else {
                    $msg = $this->lang->line('error_on_reset_password');
                    $this->redirect("$msg", "login", FALSE);
                }
            }
        }
        else {
            $user_name = NULL;
            $id = NULL;
            if ($resetkey != "") {
                $user_arr = $this->validation_model->getUserDetailFromKey($resetkey);
                $id = $user_arr[0];
                if ($id == "") {
                    $msg = $this->lang->line('invalid_url');
                    $this->redirect("$msg", "login", FALSE);
                }
                $user_name = $user_arr[1];
            } else {
                $msg = $this->lang->line('invalid_url');
                $this->redirect("$msg", "login", FALSE);
            }
        }
        $this->set("user_id", $id);
        $this->set("key", $resetkey_original);
        $this->set("user_name", $user_name);
        $this->setView();
    }

    function validate_reset_password() {
        $valid = '';
        $path = '';

        $login_details = $this->input->post(NULL, TRUE);
        $login_details = $this->validation_model->stripTagsPostArray($login_details);

        if(isset($login_details['admin_username'])  && isset($login_details['user_username'])){
            $admin_name = trim($login_details['admin_username']);
            $u_user_name = trim($login_details['user_username']);
        }

        $this->form_validation->set_rules('pass', lang('password'), 'trim|required|strip_tags|min_length[6]');
        $this->form_validation->set_rules('confirm_pass', lang('confirm_password'), 'trim|required|strip_tags|matches[pass]');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }
    
     function check_charaters($user_name) {
        if (preg_match('/[^a-z0-9 _]+/i', $user_name)) {
            return false;
        } else {
            return true;
        }
    }

    public function get_user_type()
    {
        if($this->input->is_ajax_request()) {
            header("Content-Type: text/plain");
            $user_type = null;
            if($this->session->has_userdata('inf_logged_in')) {
                $user_type = $this->session->userdata('inf_logged_in')['user_type'];
                if ($user_type == 'employee') {
                    $user_type = 'admin';
                }
            }
            echo $user_type;
            exit();
        }
    }
    
    public function one_time_password() {
        if ($this->session->flashdata('auth_qr_code') && $this->session->userdata('auth_key') && $this->session->flashdata('inf_pre_login')) {
            $this->session->keep_flashdata('inf_pre_login');
            $login_details = $this->session->flashdata('inf_pre_login');
            $this->session->set_userdata('login_details', $login_details);
        } else { 
            $this->redirect('An error occured. Please try again!', "login/index", false);
        }

        $title = lang('enter_otp');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "login";
        $this->set("help_link", $help_link);
        $goc_status = 'not-verified';

        $this->set('qr_code', $this->session->flashdata('auth_qr_code'));
        $this->set('show_qr_code', $this->session->userdata('show_qr_code'));
        $this->load_langauge_scripts();

        $login_details = $this->session->flashdata('inf_pre_login');
        $user_id = $login_details[0]->id;
        $goc_key = $this->validation_model->getGocKey($user_id);
        if(!empty($goc_key)){
            $goc_status = 'verified';            
        }
        $secret_key = $this->session->userdata('auth_key');
        $this->set("secret_key", $secret_key);
        $this->set("goc_status", $goc_status);
        $this->setView();
    }

    public function verify_one_time_password() {
        $is_logged_in = $this->checkSession();
        if ($is_logged_in) {      
            $this->redirect("", 'home', true);
        }
        if ($this->session->userdata('auth_key') && $this->session->userdata('login_details')) {
            
        } else {
            $this->redirect('An error occured. Please try again!', "login/index", false);
        }

        if ($this->input->post('verify')) {
            $login_details = $this->session->userdata('login_details');
            $user_id = $login_details[0]->id;
            $one_time_password = $this->input->post('one_time_password', TRUE);

            require_once dirname(FCPATH) . '/vendor/2fa/TwoFactorAuth.php';
            $tfa = new TwoFactorAuth($login_details[0]->user_name, 6, 30);
            $result = $tfa->verifyCode($this->session->userdata('auth_key'), $one_time_password);
            if ($result === true) {
                $this->validation_model->setGocKey($user_id, $this->session->userdata('auth_key'));
                $this->session->set_userdata('show_qr_code', 'hidden');
                $this->login_model->setUserSessionDatas($login_details);
                $user_name = $login_details[0]->user_name;
                $this->session->set_userdata('last_logged_user', $user_name);
                $password = $login_details[0]->password;
                $this->session->set_userdata('password', $password);
                $this->session->unset_userdata('inf_captcha_user');
                $this->session->unset_userdata('inf_user_invalid_count');
                if ($this->session->userdata("redirect_url")) {
                    $redirect_url = $this->session->userdata("redirect_url");
                    $this->session->unset_userdata("redirect_url");
                    if (strcmp($redirect_url, "register/") >= 0) {
                        $this->redirect("", $redirect_url, true);
                    } else {
                        $this->redirect("", $redirect_url, true);
                    }
                } else {
                    $this->redirect("", "home", true);
                }
                $this->redirect("", 'home', true);
            } else {
                $msg = 'Invalid OTP. Please try again!';
                $this->redirect($msg, "login/index", false);
            }
        } else {
            $msg = 'An error occured. Please try again!';
            $this->redirect($msg, "login/index", false);
        }
    }
    
        public function backup_authentication() {

        if ($this->session->userdata('auth_key') && $this->session->userdata('login_details')) {
            
        } else {
            $this->redirect('An error occured. Please try again!', "login/index", false);
        }

        $title = lang('enter_authentication_key');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "login";
        $this->set("help_link", $help_link);
        $goc_status = 'not-verified';

        $this->set('qr_code', $this->session->flashdata('auth_qr_code'));
        $this->set('show_qr_code', $this->session->userdata('show_qr_code'));
        $this->load_langauge_scripts();

        $login_details = $this->session->userdata('login_details');
        $user_id = $login_details[0]->id;
        $goc_key = $this->validation_model->getGocKey($user_id);
        if(!empty($goc_key)){
            $goc_status = 'verified';            
        }

        $secret_key = $this->session->userdata('auth_key');

        $this->set("secret_key", $secret_key);
        $this->set("goc_status", $goc_status);
        $this->setView();
    }

    public function verify_backup_key() {

        $is_logged_in = $this->checkSession();
        if ($is_logged_in) {
            $this->redirect("", 'home', true);
        }

        if ($this->input->post('verify')) {
            $login_details = $this->session->userdata('login_details');
            $user_id = $login_details[0]->id;
            $auth_key = $this->input->post('one_time_password', TRUE);
            $secret_key = $this->session->userdata('auth_key');
            if ($secret_key == $auth_key) {
                $this->session->set_userdata('show_qr_code', 'hidden');
                $this->login_model->setUserSessionDatas($login_details);
                $user_name = $login_details[0]->user_name;
                $this->session->set_userdata('last_logged_user', $user_name);
                $password = $login_details[0]->password;
                $this->session->set_userdata('password', $password);
                $this->session->unset_userdata('inf_captcha_user');
                $this->session->unset_userdata('inf_user_invalid_count');
                if ($this->session->userdata("redirect_url")) {
                    $redirect_url = $this->session->userdata("redirect_url");
                    $this->session->unset_userdata("redirect_url");
                    if (strcmp($redirect_url, "register/") >= 0) {
                        $this->redirect("", $redirect_url, true);
                    } else {
                        $this->redirect("", $redirect_url, true);
                    }
                } else {
                    $this->redirect("", "home", true);
                }
                $this->redirect("", 'home', true);
            } else {
                $msg = 'Invalid OTP. Please try again!';
                $this->redirect($msg, "login/index", false);
            }
        } else {
            $msg = 'An error occured. Please try again!';
            $this->redirect($msg, "login/index", false);
        }
    }

    function reset_tran_password($resetkey = "") {
        $this->load->model('validation_model');
        $this->set("title", $this->COMPANY_NAME . " | Reset Transaction Password");
        $this->load->model('tran_pass_model');  

        $this->load_langauge_scripts();
        $resetkey_original = $resetkey;
        $admin_user_name = $this->uri->segments[4];
        $resetkey = urldecode($resetkey);
        $resetkey = str_replace("_", "/", $resetkey);
        $resetkey = $this->encrypt->decode($resetkey);

        if ($this->input->post("reset_password_submit") && $this->validate_reset_transaction_password()) {
            $user_name = $this->input->post("user_name", TRUE);
            $captcha = $this->session->userdata('inf_captcha');
            if ((empty($captcha) || trim(strtolower($_REQUEST['captcha'])) != $captcha)) {
                $captcha_message = $this->lang->line('invalid_captcha');
                $this->redirect("$captcha_message", "login/reset_tran_password/$resetkey_original/$admin_user_name", false);
            }
            $prefix = str_replace('_', '', $this->db->dbprefix);
            $user_id = $this->validation_model->UserNameToIdWitoutLogin($user_name,$prefix);
            $pass_word = $this->input->post("pass", TRUE);
            $confirm_pass = $this->input->post("confirm_pass", TRUE);
            if ($pass_word == $confirm_pass) {
                $res = $this->tran_pass_model->updatePasswordOut($user_id, $pass_word, $resetkey,$prefix);
                if ($res) {
                    $msg = $this->lang->line('tran_password_updated_successfully');
                    $this->redirect("$msg", "login", true);
                } else {
                    $msg = $this->lang->line('error_on_reset_tran_password');
                    $this->redirect("$msg", "login/reset_tran_password/$resetkey_original/$admin_user_name", FALSE);
                }
            }
        }
        else {
            $user_name = NULL;
            $id = NULL;
            if ($resetkey != "") {
                $prefix = str_replace('_', '', $this->db->dbprefix);
                $user_arr = $this->tran_pass_model->getUserDetailFromKey($resetkey,$prefix);
                $id = $user_arr[0];
                if ($id == "") {
                    $msg = $this->lang->line('invalid_url');
                    $this->redirect("$msg", "login", FALSE);
                }
                $user_name = $user_arr[1];
            } else {
                $msg = $this->lang->line('invalid_url');
                $this->redirect("$msg", "login", FALSE);
            }
        }
        $this->set("user_id", $id);
        $this->set("key", $resetkey_original);
        $this->set("user_name", $user_name);
        $this->SESS_STATUS = FALSE;
        $this->setView();
    }
    public function validate_reset_transaction_password() {
        $valid = '';
        $path = '';

        $login_details = $this->input->post(NULL, TRUE);
        $login_details = $this->validation_model->stripTagsPostArray($login_details);
        if(isset($login_details['admin_username'])  && isset($login_details['user_username'])){
        $admin_name = trim($login_details['admin_username']);
        $u_user_name = trim($login_details['user_username']);
        }

        $this->form_validation->set_rules('pass', lang('password'), 'trim|required|strip_tags|min_length[8]|max_length[32]');
        $this->form_validation->set_rules('confirm_pass', lang('confirm_password'), 'trim|required|strip_tags|matches[pass]|min_length[8]|max_length[32]');
        $this->form_validation->set_rules('captcha', lang('captcha'), 'required');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }
    public function time_check(){
      //  echo phpinfo();
        echo "time".date("Y-m-d H:i:s");
    }
}
