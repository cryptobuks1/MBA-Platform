<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
define("IN_WALLET", true);

require "../vendor/autoload.php";
require_once 'Inf_Controller.php';

class Replica extends Core_Inf_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->set_session_time_out();

        if (DEMO_STATUS == "yes") {
            $this->check_demo_id();
        } else {
            $this->check_replica_id();
        }

        $this->set_replicated_user_data();

        $this->check_maintenance_mode();

        $this->get_plan_details();

        $this->load_default_language();

        $this->load_default_currency();

        $this->set_module_status_array();

        $this->set_site_information();

        $this->set_flash_message();

        $this->set_live_chat_code();

        $this->load_top_banner();

        $this->load->model('configuration_model', '', true);
        $this->load->model('register_model', '', true);
        $this->load->model('replica_model', '', true);
    }

    public function check_demo_id()
    {
        $uri_segment = trim($this->input->server('PATH_INFO'), '/');
        $uri_segment  = (explode('/', $uri_segment));

        if (isset($uri_segment[1]) && strlen($uri_segment[0]) > 2 && !in_array($uri_segment[1], $this->REPLICA_CONTROLLERS)) {
            if(isset($uri_segment[2]) && strlen($uri_segment[1]) > 2) {
                $replica_user = $uri_segment[2];
                $replica_admin = $uri_segment[1];
                $admin_user_id = $this->inf_model->getDemoId($replica_admin);
            } else {
                $replica_user = $uri_segment[1];
                $admin_user_id = $this->inf_model->getDemoId($replica_user);
            }

            // $backoffice_session = $this->inf_model->getBackofficeSessionFromFile();
            // if (isset($backoffice_session['inf_logged_in']['admin_user_id'])) {
            //     $admin_user_id = $backoffice_session['inf_logged_in']['admin_user_id'];
            // }

            $is_valid_demo = $this->inf_model->isValidDemoUser($replica_user, $admin_user_id);
            if ($is_valid_demo['status']) {
                $table_prefix = $is_valid_demo['table_prefix'] . "_";
                if (!$this->inf_model->checkReplicaStatus($table_prefix)) {
                    $this->session->unset_userdata("replica_user");
                    echo "<script>alert('Replication is not enabled in your demo!!!');</script>";
                    echo "<script>document.location.href ='" . SITE_URL . "';</script>";
                } else {
                    $this->inf_model->setDBPrefix($table_prefix);
                    $account_status = $this->inf_model->getDemoActiveStatus();
                    if ($account_status == 'blocked') {
                        echo "<script>alert('Your demo has been blocked.');</script>";
                        echo "<script>document.location.href ='" . SITE_URL . "';</script>";
                    }
                    $replica_id = $this->validation_model->userNameToID($replica_user);
                    $replica_user_array = array("table_prefix" => $table_prefix, "user_id" => $replica_id, "user_name" => $replica_user);
                    $this->session->set_userdata("replica_user", $replica_user_array);
                }
            } else {
                echo "<script>alert('Demo User doesn\'t exist in our System!!!');</script>";
                echo "<script>document.location.href ='" . SITE_URL . "';</script>";
            }
        } elseif ($this->check_replica_user()) {
            $replica_user = $this->session->userdata("replica_user");
            $table_prefix = $replica_user['table_prefix'];
            $this->inf_model->setDBPrefix($table_prefix);
        } else {
            $this->session->unset_userdata("replica_user");
            echo "<script>alert('Invalid URL!!!');</script>";
            echo "<script>document.location.href ='" . SITE_URL . "';</script>";
        }
    }

    public function check_replica_id()
    {
        $uri_segment = trim($this->input->server('PATH_INFO'), '/');
        $uri_segment  = (explode('/', $uri_segment));

        if (isset($uri_segment[1]) && strlen($uri_segment[0]) > 2 && !in_array($uri_segment[1], $this->REPLICA_CONTROLLERS)) {
            $replica_user = $uri_segment[1];
            $is_valid_demo = $this->validation_model->userNameToId($replica_user);
            if ($is_valid_demo) {
                $replica_id = $this->validation_model->userNameToId($replica_user);
                $table_prefix = $this->db->dbprefix;
                if (!$this->inf_model->checkReplicaStatus($table_prefix)) {
                    $this->session->unset_userdata("replica_user");
                    echo "<script>alert('Replication is not enabled in your demo!!!');</script>";
                    echo "<script>document.location.href ='" . SITE_URL . "';</script>";
                } else {
                    $replica_user = $this->validation_model->idToUserName($replica_id);
                    $replica_user = array("table_prefix" => $table_prefix, "user_id" => $replica_id, "user_name" => $replica_user);
                    $this->session->set_userdata("replica_user", $replica_user);
                    $this->session->set_userdata("replica_ok", "1");
                }
            } else {
                $this->session->unset_userdata("replica_user");
                echo "<script>alert('Demo User doesn\'t exist in our System!!!');</script>";
                echo "<script>document.location.href ='" . SITE_URL . "';</script>";
            }
        } else if ($this->check_replica_user()) {
            $replica_user = $this->session->userdata('replica_user');
            $table_prefix = $replica_user['table_prefix'];
        } else {
            $this->session->unset_userdata("replica_user");
            echo "<script>alert('Invalid URL!!!');</script>";
            echo "<script>document.location.href ='" . SITE_URL . "';</script>";
        }
    }

    public function check_replica_user()
    {
        $flag = !empty($this->session->userdata("replica_user")) ? true : false;
        return $flag;
    }

    public function set_replicated_user_data()
    {
        $replica_user = $this->session->userdata('replica_user');
        $replica_id = $replica_user['user_id'];
        $this->USER_DATA = $this->inf_model->getAllUserDetails($replica_id);
        if (!$this->USER_DATA) {
            echo "<script>alert('User doesn\'t exist in our System!!!');</script>";
            echo "<script>document.location.href ='" . SITE_URL . "';</script>";
        }
        if ($this->session->userdata("replica_message")) {
            $errorr_email = $this->session->userdata("replica_message");
            $this->set("email_message", $errorr_email['message']);
            $this->set("email_messagetype", $errorr_email['type']);
            $this->session->unset_userdata("replica_message");
        }
    }

    function set_session_time_out()
    {
        if ($this->CURRENT_CTRL != "time") {
            $this->session->set_userdata("replica_user_page_load_time", time());
        }
    }

    public function get_plan_details()
    {
        $replica_user = $this->session->userdata('replica_user');
        $replica_id = $replica_user['user_id'];
        $this->REPLICA_DATA = $this->inf_model->getAllUserDetails($replica_id);
        $this->MLM_PLAN = $this->REPLICA_DATA['mlm_plan'];
    }

    function check_maintenance_mode()
    {
        if (DEMO_STATUS == 'no' || (DEMO_STATUS == 'yes' && $this->check_replica_user())) {
            if ($this->inf_model->checkMaintanenceMode()) {
                $this->MAINTENANCE_MODE = TRUE;
                $this->set("title", $this->COMPANY_NAME);
            }
            $this->MAINTENANCE_DATA = $this->inf_model->getMaintanenceData();
            $this->BLOCK_LOGIN = $this->MAINTENANCE_DATA['block_login'];
            $this->BLOCK_REGISTER = $this->MAINTENANCE_DATA['block_register'];
            $this->BLOCK_ECOMMERCE = $this->MAINTENANCE_DATA['block_ecommerce'];
        }
    }

    function load_default_currency()
    {
        if ($this->check_replica_user()) {
            $replica_user = $this->session->userdata('replica_user');
            $user_id = $replica_user['user_id'];
            if ($user_id) {
                $multy_currency_status = $this->currency_model->getMultyCurrencyStatus();
                $default_admin_currency = $this->currency_model->getProjectDefaultCurrencyDetails();
                if ($multy_currency_status) {
                    $conversion_status = $this->currency_model->getConversionStatus();
                    if ($conversion_status == 'automatic') {
                        if ($default_admin_currency['last_modified'] < date("Y-m-d")) {
                            $this->currency_model->automaticCurrencyUpdate($default_admin_currency['code']);
                        }
                    }
                    $currency_details = $this->currency_model->getUserDefaultCurrencyDetails($user_id);
                    if (!$currency_details) {
                        $currency_details = $default_admin_currency;
                    }
                    $this->DEFAULT_CURRENCY_VALUE = $currency_details['value'];
                    $this->DEFAULT_CURRENCY_CODE = $currency_details['code'];
                    $this->DEFAULT_SYMBOL_LEFT = $currency_details['symbol_left'];
                    $this->DEFAULT_SYMBOL_RIGHT = $currency_details['symbol_right'];
                    if ($this->DEFAULT_CURRENCY_CODE == 'BTC') {
                        $this->PRECISION = $this->PRECISION > 8 ? $this->PRECISION : 8 ;
                    } else {
                        $this->PRECISION = $this->PRECISION;;
                    }
                } else {
                    $this->DEFAULT_CURRENCY_VALUE = 1;
                    $this->DEFAULT_CURRENCY_CODE = '';
                    $this->DEFAULT_SYMBOL_LEFT = '';
                    $this->DEFAULT_SYMBOL_RIGHT = '';
                }
                $this->CURRENCY_ARR = $this->currency_model->getAllCurrency();
            }
        }
    }

    function load_default_language()
    {

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
                    if ($this->check_replica_user()) {
                        $replica_user = $this->session->userdata('replica_user');
                        $replica_id = $replica_user['user_id'];
                        $this->inf_model->setDefaultLang($this->LANG_ID, $replica_id);
                    }
                    $this->session->set_userdata("replica_language", array("lang_id" => $this->LANG_ID, "lang_name_in_english" => $this->LANG_NAME));
                }
            }
            if (!$lang_active) {
                $default_language_array = $this->inf_model->getProjectDefaultLang();
                $this->LANG_ID = $default_language_array['lang_id'];
                $this->LANG_NAME = $default_language_array['lang_name_in_english'];
                $this->session->set_userdata("replica_language", array("lang_id" => $this->LANG_ID, "lang_name_in_english" => $this->LANG_NAME));
            }
        } else {
            $this->load->model('login_model');
            if (empty($this->session->userdata('replica_language')) && $this->check_replica_user()) {
                $replica_user = $this->session->userdata('replica_user');
                $replica_id = $replica_user['user_id'];
                $this->LANG_ID = $this->login_model->getDefaultLang($replica_id);
                $this->LANG_NAME = $this->login_model->getLanguageName($this->LANG_ID);
                $this->session->set_userdata("replica_language", array("lang_id" => $this->LANG_ID, "lang_name_in_english" => $this->LANG_NAME));
            } else {
                if ($this->session->userdata("replica_language")) {
                    $language_array = $this->session->userdata("replica_language");
                    $this->LANG_ID = $language_array['lang_id'];
                    $this->LANG_NAME = $language_array['lang_name_in_english'];
                } else {
                    $default_language_array = $this->inf_model->getProjectDefaultLang();
                    $this->LANG_ID = $default_language_array['lang_id'];
                    $this->LANG_NAME = $default_language_array['lang_name_in_english'];
                    $this->session->set_userdata("replica_language", array("lang_id" => $this->LANG_ID, "lang_name_in_english" => $this->LANG_NAME));
                }
            }
        }

        $this->lang->load('common', $this->LANG_NAME);

        if (!in_array($this->CURRENT_CTRL, $this->NO_TRANSLATION_PAGES)) {
            $this->lang->load($this->CURRENT_CTRL, $this->LANG_NAME);
        }
    }


    function set_module_status_array()
    {
        $set_module = false;
        if (DEMO_STATUS == "yes") {
            if ($this->check_replica_user()) {
                $set_module = TRUE;
            }
        } else {
            $set_module = TRUE;
        }


        if ($set_module) {

            $this->MODULE_STATUS = $this->inf_model->trackModule();

            if ($this->MODULE_STATUS['mlm_plan'] == "Board") {
                $this->SHUFFLE_STATUS = $this->MODULE_STATUS['shuffle_status'];
            }
            $this->set("LANG_STATUS", $this->MODULE_STATUS['lang_status']);
            $this->set("HELP_STATUS", $this->MODULE_STATUS['help_status']);
            $this->set("STATCOUNTER_STATUS", $this->MODULE_STATUS['statcounter_status']);
            $this->set("FOOTER_DEMO_STATUS", $this->MODULE_STATUS['footer_demo_status']);
            $this->set("CAPTCHA_STATUS", $this->MODULE_STATUS['captcha_status']);
            $this->set("LIVECHAT_STATUS", $this->MODULE_STATUS['live_chat_status']);
        } else {
            $this->set("LANG_STATUS", 'yes');
            $this->set("HELP_STATUS", 'yes');
            $this->set("STATCOUNTER_STATUS", 'yes');
            $this->set("FOOTER_DEMO_STATUS", 'yes');
            $this->set("CAPTCHA_STATUS", 'yes');
            $this->set("LIVECHAT_STATUS", 'yes');
        }
    }

    public function check_demo_installed()
    {
        return true;
    }

    public function set_public_url_values()
    {
        return true;
    }

    public function set_logged_user_data()
    {
        return true;
    }

    function set_live_chat_code()
    {
        $CHAT_CODE = '';
        if ($this->check_replica_user() && $this->MODULE_STATUS['live_chat_status'] == 'yes') {
            $CHAT_CODE = ' <!--Start of Tawk.to Script-->
                                <script type="text/javascript">
                                    var Tawk_API=Tawk_API||{ }, Tawk_LoadStart=new Date();
                                    (function(){
                                    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                                    s1.async=true;
                                    s1.src="https://embed.tawk.to/5465a1c8eebdcbe3576a5f8f/default";
                                    s1.charset="UTF-8";
                                    s1.setAttribute("crossorigin","*");
                                    s0.parentNode.insertBefore(s1,s0);
                                    })();
                                </script>
                            <!--End of Tawk.to Script-->';
        }
        $this->set("CHAT_CODE", $CHAT_CODE);
    }

    function home()
    {

        $title = lang('Home');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->load_langauge_scripts();
        //replication site config
        $replica_user = $this->session->userdata('replica_user');
        $replica_id = $replica_user['user_id'];
        $flag = TRUE;
        $type = array();
        $content = '';

        $banners = $this->replica_model->selectBanner($replica_id);
        $banners = $this->security->xss_clean($banners);
        $this->set("banners", $banners);
        $comapny_name = $this->configuration_model->getSiteName();
        $this->set("company_name", strtoupper($comapny_name));
        $i = 0;

        foreach ($banners as $rows) {

            $type[$i] = $rows['subject'];
            $content[$rows['subject']] = $rows['content'];
            $i++;
        }
        if (isset($content['video'])) {
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $content['video'], $match);
            $content['video'] = $match[1];
        }
        if (in_array('content', $type)) {
            $val = json_decode($content['content'], TRUE);
            if ($val) {
                $sub_title = $val['sub_title'];
                $description = $val['content'];
            }
        } else {
            $sub_title = lang('tile_here');
            $description = lang('no_description');
        }

        $this->set('subtitle', $sub_title);
        $this->set('description', $description);
        $this->set('flag', $flag);
        $this->set('content', $content);
        $this->set('type', $type);
        //
        $this->set('OPTIONAL_MODULE', true);

        $this->setView();
    }

    function about_us()
    {

        $title = lang('About_Us');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->load->model('configuration_model', '', TRUE);
        $this->load_langauge_scripts();
        $replica_user = $this->session->userdata('replica_user');
        $replica_id = $replica_user['user_id'];
        $flag = TRUE;
        $type = array();
        $content = '';

        $banners = $this->replica_model->selectBanner($replica_id);
        $banners = $this->security->xss_clean($banners);
        $this->set("banners", $banners);
        $i = 0;
        $comapny_name = $this->configuration_model->getSiteName();
        $this->set("company_name", strtoupper($comapny_name));

        foreach ($banners as $rows) {

            $type[$i] = $rows['subject'];
            $content[$rows['subject']] = $rows['content'];
            $i++;
        }
        if (in_array('content', $type)) {
            $val = json_decode($content['content'], TRUE);
            if ($val) {
                $sub_title = $val['sub_title'];
                $description = $val['content'];
            }
        } else {
            $sub_title = lang('no_title');
            $description = lang('no_description');
        }

        $this->set('subtitle', $sub_title);
        $this->set('description', $description);
        $this->set('flag', $flag);
        $this->set('content', $content);
        $this->set('type', $type);
        //
        $this->setView();
    }

    function contact()
    {

        $title = lang('Contact_Me');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->load->model('configuration_model', '', TRUE);
        $this->load_langauge_scripts();

        $replica_user = $this->session->userdata('replica_user');
        $replica_id = $replica_user['user_id'];
        $flag = TRUE;
        $type = array();
        $contact_error = array();
        $contact_post_array = array();
        if ($this->session->userdata('replica_contact_error')) {
            $contact_post_array = $this->session->userdata('replica_contact_post_array');
            $contact_error = $this->session->userdata('replica_contact_error');
            $this->session->unset_userdata('replica_contact_post_array');
            $this->session->unset_userdata('replica_contact_error');
        }
        $this->set("contact_post_array", $contact_post_array);
        $this->set("contact_error", $contact_error);

        if ($this->input->post('submit')) {

            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('address', 'Address', 'trim|required');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required|numeric');

            $res_val = $this->form_validation->run();

            $contact_post_array = $this->input->post(NULL, TRUE);
            if ($res_val) {
                $replica_user = $this->session->userdata('replica_user');
                $replica_id = $replica_user['user_id'];
                $name = $this->input->post('name', TRUE);
                $email = $this->input->post('email', TRUE);
                $address = $this->input->post('address', TRUE);
                $phone = $this->input->post('phone', TRUE);
                $describe = $this->input->post('describe', TRUE);

                $res = $this->replica_model->insertDetails($replica_id, $name, $email, $address, $phone, $describe);
                if ($res) {
                    $msg = $this->lang->line('will_contact_you_shortly');
                    $this->redirect($msg, "replica/contact", TRUE);
                } else {
                    $msg = $this->lang->line('error_occured_try_again_later');
                    $this->redirect($msg, "replica/contact", FALSE);
                }
            } else {
                $error = $this->form_validation->error_array();
                $this->session->set_userdata('replica_contact_error', $error);
                $this->session->set_userdata('replica_contact_post_array', $contact_post_array);
                $msg = $this->lang->line('Please_Check_The_Fields');
                $this->redirect($msg, "replica/contact", FALSE);
            }
        }
        $content = '';

        $banners = $this->replica_model->selectBanner($replica_id);
        $banners = $this->security->xss_clean($banners);
        $this->set("banners", $banners);
        $i = 0;
        $comapny_name = $this->configuration_model->getSiteName();
        $this->set("company_name", strtoupper($comapny_name));

        foreach ($banners as $rows) {

            $type[$i] = $rows['subject'];
            $content[$rows['subject']] = $rows['content'];
            $i++;
        }
        if (in_array('content', $type)) {
            $val = json_decode($content['content'], TRUE);
            if ($val) {
                $sub_title = $val['sub_title'];
                $description = $val['content'];
            }
        } else {
            $sub_title = lang('no_title');
            $description = lang('no_description');
        }

        $this->set('subtitle', $sub_title);
        $this->set('description', $description);
        $this->set('flag', $flag);
        $this->set('content', $content);
        $this->set('type', $type);
        $this->setView();
    }

    function load_top_banner()
    {
        if ($this->check_replica_user()) {
            $replica_user = $this->session->userdata('replica_user');
            $replica_id = $replica_user['user_id'];
            $this->load->model('replica_model');
            $this->load->model('replica_model');
            $this->load->model('replica_model');
            $banners = $this->replica_model->selectBanner($replica_id);
            $banners = $this->security->xss_clean($banners);
            $i = 0;
            $content = '';
            foreach ($banners as $rows) {
                $content[$rows['subject']] = $rows['content'];
                $i++;
            }
            $this->set('content', $content);
        }
    }

    function policy()
    {
        $title = lang('Policy');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->load_langauge_scripts();
        $this->load->model('home_model', '', TRUE);
        $this->load->model('configuration_model', '', TRUE);
        $contact_error = array();
        $replica_user = $this->session->userdata('replica_user');
        $replica_id = $replica_user['user_id'];
        $flag = TRUE;
        $type = array();
        $content = '';

        $banners = $this->replica_model->selectBanner($replica_id);
        $banners = $this->security->xss_clean($banners);
        $this->set("banners", $banners);
        $i = 0;

        $comapny_name = $this->configuration_model->getSiteName();
        $this->set("company_name", strtoupper($comapny_name));

        foreach ($banners as $rows) {

            $type[$i] = $rows['subject'];
            $content[$rows['subject']] = $rows['content'];
            $i++;
        }
        if (in_array('content', $type)) {
            $val = json_decode($content['content'], TRUE);
            if ($val) {
                $sub_title = $val['sub_title'];
                $description = $val['content'];
            }
        } else {
            $sub_title = lang('no_title');
            $description = lang('no_description');
        }

        $this->set('subtitle', $sub_title);
        $this->set('description', $description);
        $this->set('flag', $flag);
        $this->set('content', $content);
        $this->set('type', $type);
        //
        $this->setView();
    }

    function terms()
    {
        $title = lang('Terms');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->load_langauge_scripts();
        $this->load->model('home_model', '', TRUE);
        $this->load->model('configuration_model', '', TRUE);
        $contact_error = array();
        $replica_user = $this->session->userdata('replica_user');
        $replica_id = $replica_user['user_id'];
        $flag = TRUE;
        $type = array();
        $content = '';

        $banners = $this->replica_model->selectBanner($replica_id);
        $banners = $this->security->xss_clean($banners);
        $this->set("banners", $banners);
        $i = 0;
        $comapny_name = $this->configuration_model->getSiteName();
        $this->set("company_name", strtoupper($comapny_name));

        foreach ($banners as $rows) {

            $type[$i] = $rows['subject'];
            $content[$rows['subject']] = $rows['content'];
            $i++;
        }
        if (in_array('content', $type)) {
            $val = json_decode($content['content'], TRUE);
            if ($val) {
                $sub_title = $val['sub_title'];
                $description = $val['content'];
            }
        } else {
            $sub_title = lang('no_title');
            $description = lang('no_description');
        }

        $this->set('subtitle', $sub_title);
        $this->set('description', $description);
        $this->set('flag', $flag);
        $this->set('content', $content);
        $this->set('type', $type);
        $this->setView();
    }
}

