<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lcp extends Core_Inf_Controller {

    function __construct() {
        parent::__construct();

        $this->check_lcp_session();
        
        if (DEMO_STATUS == "yes") {
            $this->check_demo_id();
        } else {
            $this->check_lcp_id();
        }
        
        $this->set_lcp_user_data();
                
        $this->set_module_status_array();
        
        $this->set_flash_message();

        $this->set_site_information();

        $this->set_public_variables();
        
        $this->load_default_language();
        
        $this->check_maintenance_mode();
        
        $this->load->model('lcp_model', '', true);
    }

     public function check_demo_id() {

        $uri_segment = trim($this->input->server('PATH_INFO'), '/');
        $uri_segment  = (explode('/', $uri_segment));

        if (isset($uri_segment[1]) && strlen($uri_segment[1]) > 2 && strlen($uri_segment[0]) > 2 && $uri_segment[1] != "home") {

            if(isset($uri_segment[2]) && strlen($uri_segment[1]) > 2) {
                $lcp_user = $uri_segment[2];
                $lcp_admin = $uri_segment[1];
                $admin_user_id = $this->inf_model->getDemoId($lcp_admin);
            } else {
                $lcp_user = $uri_segment[1];
                $admin_user_id = $this->inf_model->getDemoId($lcp_user);
            }           

    //        $backoffice_session = $this->inf_model->getBackofficeSessionFromFile();
    //        if (isset($backoffice_session['inf_logged_in']['admin_user_id'])) {
    //            $admin_user_id = $backoffice_session['inf_logged_in']['admin_user_id'];
    //        }

            $is_valid_demo = $this->inf_model->isValidDemoUser($lcp_user, $admin_user_id);

            if ($is_valid_demo['status']) {
                $table_prefix = $is_valid_demo['table_prefix'] . "_";

                if (!$this->inf_model->checkLCPStatus($table_prefix)) {
                    $this->session->unset_userdata('lcp_session');
                    echo "<script>alert('Lead Capture is not enabled in your demo!!!');</script>";
                    echo "<script>document.location.href ='" . SITE_URL . "';</script>";
                } else {
                    $this->inf_model->setDBPrefix($table_prefix);
                    $account_status = $this->inf_model->getDemoActiveStatus();
                    if($account_status == 'blocked') {
                        echo "<script>alert('Your demo has been blocked.');</script>";
                        echo "<script>document.location.href ='" . SITE_URL . "';</script>";
                    }
                    $lcp_id = $this->validation_model->userNameToID($lcp_user);
                    $this->session->set_userdata('lcp_session', array("table_prefix" => $table_prefix, "user_id" => $lcp_id, "user_name" => $lcp_user));
                }
            } else {
                echo "<script>alert('Demo User doesn\'t exist in our System!!!');</script>";
                echo "<script>document.location.href ='" . SITE_URL . "';</script>";
            }
        } else if ($this->check_lcp_session()) {
            $lcp_session = $this->session->userdata('lcp_session');
            $table_prefix = $lcp_session['table_prefix'];
            $this->inf_model->setDBPrefix($table_prefix);
        } else {
            $this->session->unset_userdata("lcp_session");
            echo "<script>alert('Invalid URL!!!');</script>";
            echo "<script>document.location.href ='" . SITE_URL . "';</script>";
        }
    }
    
    public function check_lcp_id() {

        $uri_segment = trim($this->input->server('PATH_INFO'), '/');
        $uri_segment  = (explode('/', $uri_segment));

        if (isset($uri_segment[1]) && $uri_segment[1] != "home" && strlen($uri_segment[1]) > 2 && strlen($uri_segment[0]) > 2) {
            $lcp_user = $uri_segment[1];
             $is_valid_demo = $this->validation_model->userNameToId($lcp_user);

            if ($is_valid_demo) {
                $lcp_id = $this->validation_model->userNameToId($lcp_user);
                $table_prefix = $this->db->dbprefix;
                if (!$this->inf_model->checkLCPStatus($table_prefix)) {
                    $this->session->unset_userdata('lcp_session');
                    echo "<script>alert('Lead Capture is not enabled in your demo!!!');</script>";
                    echo "<script>document.location.href ='" . SITE_URL . "';</script>";
                } else {
                    $this->inf_model->setDBPrefix($table_prefix);
                    $lcp_user = $this->validation_model->idToUserName($lcp_id);
                    $this->session->set_userdata('lcp_session', array("table_prefix" => $table_prefix, "user_id" => $lcp_id, "user_name" => $lcp_user));
                }
            } else {
                $this->session->unset_userdata('lcp_session');
                echo "<script>alert('Demo User doesn\'t exist in our System!!!');</script>";
                echo "<script>document.location.href ='" . SITE_URL . "';</script>";
            }
        } else if ($this->check_lcp_session()) {
            $lcp_session = $this->session->userdata('lcp_session');
            $table_prefix = $lcp_session['table_prefix'];
            $this->inf_model->setDBPrefix($table_prefix);
        } else {
            echo "<script>alert('Invalid URL!!!');</script>";
            echo "<script>document.location.href ='" . SITE_URL . "';</script>";
        }
    }

    public function check_lcp_session() {
        $flag = !empty($this->session->userdata('lcp_session')) ? true : false;
        return $flag;
    }

    public function set_lcp_user_data() {
        $lcp_session = $this->session->userdata('lcp_session');
        $lcp_id = $lcp_session['user_id'];
        $this->USER_DATA = $this->inf_model->getAllUserDetails($lcp_id);
        if (!$this->USER_DATA) {
            echo "<script>alert('User doesn\'t exist in our System!!!');</script>";
            echo "<script>document.location.href ='" . SITE_URL . "';</script>";
        }
    }
    
    function check_maintenance_mode() {  
        if (DEMO_STATUS == 'no' || (DEMO_STATUS == 'yes' && $this->check_lcp_session())) {
            if ($this->inf_model->checkMaintanenceMode()) {
                $this->MAINTENANCE_MODE = TRUE;
                $this->set("title", $this->COMPANY_NAME);
            }
            $this->MAINTENANCE_DATA = $this->inf_model->getMaintanenceData();
        }
    }
    
    function load_lcp_language() {
        $this->LANG_ARR = $this->inf_model->getAllLanguages();
        $lang_arr_count = count($this->LANG_ARR);
        $uri_lang_code = $this->uri->segment(1);
        $this->LANG_ID = NULL;

            if ($this->check_lcp_session() && !empty($this->session->userdata('lcp_lang'))) {
                $this->LANG_ID = $this->session->userdata('lcp_lang');
                $this->LANG_NAME = $this->inf_model->getLanguageName($this->LANG_ID);
                $this->session->set_userdata("inf_language", array("lang_id" => $this->LANG_ID, "lang_name_in_english" => $this->LANG_NAME));
            }
        if (!$this->LANG_ID) {
            if ($this->session->userdata("inf_language")) {
                $language_array = $this->session->userdata("inf_language");
                $this->LANG_ID = $language_array['lang_id'];
                $this->LANG_NAME = $language_array['lang_name_in_english'];
            } else {
                $default_language_array = $this->inf_model->getProjectDefaultLang();
                $this->LANG_ID = $default_language_array['lang_id'];
                $this->LANG_NAME = $default_language_array['lang_name_in_english'];
                $this->session->set_userdata("inf_language", array("lang_id" => $this->LANG_ID, "lang_name_in_english" => $this->LANG_NAME));
            }
        }
        $this->lang->load('common', $this->LANG_NAME);
        if (!in_array($this->CURRENT_CTRL, $this->NO_TRANSLATION_PAGES)) {
            if (in_array($this->CURRENT_CTRL, $this->COMMON_PAGES)) {
                $this->lang->load($this->CURRENT_CTRL, $this->LANG_NAME);
            } else {
                $this->lang->load($this->CURRENT_CTRL, $this->LANG_NAME);
                }
            }            
        }
        
        function set_module_status_array() {
        $set_module = false;
        if (DEMO_STATUS == "yes") {
            if ($this->check_lcp_session()) {
                $set_module = TRUE;
            }
        } else {
            $set_module = TRUE;
        }

        if ($set_module) {

            $this->MODULE_STATUS = $this->inf_model->trackModule();

            $this->set("LANG_STATUS", $this->MODULE_STATUS ['lang_status']);
            $this->set("HELP_STATUS", $this->MODULE_STATUS ['help_status']);
            $this->set("STATCOUNTER_STATUS", $this->MODULE_STATUS ['statcounter_status']);
            $this->set("FOOTER_DEMO_STATUS", $this->MODULE_STATUS ['footer_demo_status']);
            $this->set("CAPTCHA_STATUS", $this->MODULE_STATUS ['captcha_status']);
            $this->set("LIVECHAT_STATUS", $this->MODULE_STATUS ['live_chat_status']);
        } else {
            $this->set("LANG_STATUS", 'yes');
            $this->set("HELP_STATUS", 'yes');
            $this->set("STATCOUNTER_STATUS", 'yes');
            $this->set("FOOTER_DEMO_STATUS", 'yes');
            $this->set("CAPTCHA_STATUS", 'yes');
            $this->set("LIVECHAT_STATUS", 'yes');
        }
    }
    
    public function set_live_chat_code() {
        return true;
    }

    public function set_session_time_out() {
        return true;
    }
    
    public function check_demo_installed() {
        return true;
    }
    
    public function set_public_url_values() {
        return true;
    }
    
    public function set_logged_user_data() {
        return true;
    }


    function home() {

        $title = lang('Lead_Capture_Page');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->load_langauge_scripts();

        $lcp_error = array();
        $lcp_post_array = array();
        $country_id = '';
        if ($this->session->userdata('lcp_error')) {
            $lcp_post_array = $this->session->userdata('lcp_post_array');
            $lcp_error = $this->session->userdata('lcp_error');
            $this->session->unset_userdata('lcp_post_array');
            $this->session->unset_userdata('lcp_error');
        }
        $countries = $this->country_state_model->viewCountry($country_id);
        if($this->input->post('add_lcp')) {
            $lcp_session = $this->session->userdata('lcp_session');
            $client_name = $lcp_session['user_name'];

            $capture_details = $this->validation_model->stripTagsPostArray($this->input->post(null, true));
            $capture_details['user_id'] = $lcp_session['user_id'];

            if ($this->validate_lead()) {
                $res_crm = $this->lcp_model->InsertCrmLead($capture_details);
                if ($res_crm) {
                    $msg = sprintf(lang('thanks_for_your_interest'), $client_name);
                    $this->redirect($msg, "lcp/home", true);
                } else {
                    $msg = $this->lang->line('Lead_not_Added');
                    $this->redirect($msg, "lcp/home", FALSE);
                }
            } else {
                $error = $this->form_validation->error_array();
                $this->session->set_userdata('lcp_error', $error);
                $this->session->set_userdata('lcp_post_array', $capture_details);
                $msg = $this->lang->line('Please_Check_The_Fields');
                $this->redirect($msg, "lcp/home", FALSE);
            }
        }

        $this->set('countries', $countries);
        $this->set("lcp_post_array", $lcp_post_array);
        $this->set("lcp_error", $lcp_error);
        $this->setView();
    }

    public function validate_lead() {

        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('phone', 'telephone', 'required|numeric');
        $validation_status = $this->form_validation->run();
        return $validation_status;
    }
    
    function load_default_language() {

        $this->LANG_ARR = $this->inf_model->getAllLanguages();
        $lang_arr_count = count($this->LANG_ARR);
        $uri_lang_code = $this->uri->segment(1);

        if (strlen($uri_lang_code) == 2) {
            $lang_active = false;
            for ($i = 0; $i < $lang_arr_count; $i++) {
                if ($uri_lang_code == $this->LANG_ARR[$i]['lang_code']) {
                    $lang_active = true;
                    $this->LANG_ID = $this->LANG_ARR[$i]['lang_id'];
                    $this->LANG_NAME = $this->LANG_ARR[$i]['lang_name_in_english'];
                    $this->session->set_userdata("lcp_language", array("lang_id" => $this->LANG_ID, "lang_name_in_english" => $this->LANG_NAME));
                }
            }
            if (!$lang_active) {
                $default_language_array = $this->inf_model->getProjectDefaultLang();
                $this->LANG_ID = $default_language_array['lang_id'];
                $this->LANG_NAME = $default_language_array['lang_name_in_english'];
                $this->session->set_userdata("lcp_language", array("lang_id" => $this->LANG_ID, "lang_name_in_english" => $this->LANG_NAME));
            }
        } else {
             $this->load->model('login_model');
            if ($this->session->userdata("lcp_language")) {
                $language_array = $this->session->userdata("lcp_language");
                $this->LANG_ID = $language_array['lang_id'];
                $this->LANG_NAME = $language_array['lang_name_in_english'];
            } else if ($this->check_lcp_session()) {
                $lcp_session = $this->session->userdata('lcp_session');
                $user_id = $lcp_session['user_id'];
                $this->LANG_ID = $this->login_model->getDefaultLang($user_id);
                $this->LANG_NAME = $this->login_model->getLanguageName($this->LANG_ID);
                $this->session->set_userdata("lcp_language", array("lang_id" => $this->LANG_ID, "lang_name_in_english" => $this->LANG_NAME));
            } else {
                $default_language_array = $this->inf_model->getProjectDefaultLang();
                $this->LANG_ID = $default_language_array['lang_id'];
                $this->LANG_NAME = $default_language_array['lang_name_in_english'];
                $this->session->set_userdata("lcp_language", array("lang_id" => $this->LANG_ID, "lang_name_in_english" => $this->LANG_NAME));
            }
        }

        $this->lang->load('common', $this->LANG_NAME);

        if (!in_array($this->CURRENT_CTRL, $this->NO_TRANSLATION_PAGES)) {
            $this->lang->load($this->CURRENT_CTRL, $this->LANG_NAME);
        }
    }

}

