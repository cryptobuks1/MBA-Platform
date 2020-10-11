<?php

require_once 'Inf_Controller.php';

class Select_report extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function admin_profile_report() {

        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('profile_reports');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('profile_reports');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('profile_reports');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $error_array = array();
        if ($this->session->userdata('inf_profile_report_view_error')) {
            $error_array = $this->session->userdata('inf_profile_report_view_error');
            $this->session->unset_userdata('inf_profile_report_view_error');
        }

        $error_array_count = array();
        if ($this->session->userdata('inf_profile_report_view_count_error')) {
            $error_array_count = $this->session->userdata('inf_profile_report_view_count_error');
            $this->session->unset_userdata('inf_profile_report_view_count_error');
        }

        $error_array_profile_count = array();
        if ($this->session->userdata('inf_profile_report_count_error')) {
            $error_array_profile_count = $this->session->userdata('inf_profile_report_count_error');

            $this->session->unset_userdata('inf_profile_report_count_error');
        }

        $this->set('error_array', $error_array);
        $this->set('error_count', count($error_array));

        $this->set('error_array_count', $error_array_count);
        $this->set('error_single_count', count($error_array_count));

        $this->set('error_array_profile_count', $error_array_profile_count);
        $this->set('error_profile_count', count($error_array_profile_count));

        $help_link = "member-profile-report";
        $this->set("help_link", $help_link);
        $this->setView();
    }

    function total_joining_report() {

        $title = lang('joining_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('joining_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('joining_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $error_array = array();
        if ($this->session->userdata('inf_total_joining_daily_error')) {
            $error_array = $this->session->userdata('inf_total_joining_daily_error');
            $this->session->unset_userdata('inf_total_joining_daily_error');
        }
        $error_array_weekely = array();
        if ($this->session->userdata('inf_total_joining_weekly_error')) {
            $error_array_weekely = $this->session->userdata('inf_total_joining_weekly_error');
            $this->session->unset_userdata('inf_total_joining_weekly_error');
        }

        $this->set('error_array', $error_array);
        $this->set('error_count', count($error_array));

        $this->set('error_array_weekly', $error_array_weekely);
        $this->set('error_count_weekly', count($error_array_weekely));

        $help_link = "joining-report";
        $this->set("help_link", $help_link);

        $this->setView();
    }

    function total_payout_report() {

        $title = lang('total_bonus_report');
        $this->set("title", $this->COMPANY_NAME . " | $title ");

        $this->HEADER_LANG['page_top_header'] = lang('total_bonus_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('total_bonus_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $error_array = array();
        if ($this->session->userdata('inf_weekly_payout_report_error')) {
            $error_array = $this->session->userdata('inf_weekly_payout_report_error');
            $this->session->unset_userdata('inf_weekly_payout_report_error');
        }

        $error_array_user = array();
        if ($this->session->userdata('inf_member_payout_report_error')) {
            $error_array_user = $this->session->userdata('inf_member_payout_report_error');
            $this->session->unset_userdata('inf_member_payout_report_error');
        }

        $this->set('error_array', $error_array);
        $this->set('error_count', count($error_array));

        $this->set('error_array_user', $error_array_user);
        $this->set('error_count_user', count($error_array_user));

        $help_link = "payout-report";
        $this->set("help_link", $help_link);

        $this->setView();
    }

    function payout_release_report() {

        $title = lang('payout_release_reports');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('payout_release_reports');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('payout_release_reports');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $error_array = array();
        if ($this->session->userdata('inf_payout_released_report_daily_error')) {
            $error_array = $this->session->userdata('inf_payout_released_report_daily_error');
            $this->session->unset_userdata('inf_payout_released_report_daily_error');
        }
        
        $this->set('error_array', $error_array);
        $this->set('error_count', count($error_array));

        $help_link = "payout-release-report";
        $this->set("help_link", $help_link);

        $this->setView();
    }
    
    function sales_report() {
        $title = lang('sales_report');
        $this->set("title", $this->COMPANY_NAME . " | $title ");
        $this->url_permission('product_status');

        $this->HEADER_LANG['page_top_header'] = lang('sales_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('sales_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $error_array = array();
        if ($this->session->userdata('inf_sales_report_view_error')) {
            $error_array = $this->session->userdata('inf_sales_report_view_error');
            $this->session->unset_userdata('inf_sales_report_view_error');
        }
        $error_array_sales = array();
        if ($this->session->userdata('inf_product_sales_report_error')) {
            $error_array_sales = $this->session->userdata('inf_product_sales_report_error');
            $this->session->unset_userdata('inf_product_sales_report_error');
        }
        $this->set('error_array_sales', $error_array_sales);
        $this->set('error_sales_count', count($error_array_sales));

        $this->set('error_array', $error_array);
        $this->set('error_count', count($error_array));

        $help_link = "sales-report";
        $this->set("help_link", $help_link);

        $this->load->model('register_model');
        $products = $this->select_report_model->getAllProducts("registration");
        $repurchase_products = $this->select_report_model->getAllProducts("repurchase");

        $this->set("repurchase_products", $this->security->xss_clean($repurchase_products));
        $this->set("products", $this->security->xss_clean($products));
        $this->setView();
    }

    function rank_achievers_report() {

        $title = lang('rank_achieve_report');
        $this->set("title", $this->COMPANY_NAME . " | $title ");

        $help_link = "rank-achievers-report";
        $this->set("help_link", $help_link);
        $this->url_permission('rank_status');

        $this->HEADER_LANG['page_top_header'] = lang('rank_achieve_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('rank_achieve_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $error_array = array();
        if ($this->session->userdata('inf_rank_achievers_report_error')) {
            $error_array = $this->session->userdata('inf_rank_achievers_report_error');
            $this->session->unset_userdata('inf_rank_achievers_report_error');
        }

        $rank_arr = array();
        $rank_arr = $this->select_report_model->getAllRank();

        $this->set("rank_arr", $rank_arr);
        $this->set('error_array', $error_array);
        $this->set('error_count', count($error_array));

        $this->setView();
    }

    function commission_report() {

        $title = lang('commission_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('commission_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('commission_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $error_array = array();
        if ($this->session->userdata('inf_commission_report_error')) {
            $error_array = $this->session->userdata('inf_commission_report_error');
            $this->session->unset_userdata('inf_commission_report_error');
        }

        $this->load->model('ewallet_model');
        $commission_types = $this->ewallet_model->getEnabledBonusList(); 
        $received_commission_types = $this->ewallet_model->getReceivedBonusList(); 
        $commission_types = array_unique(array_merge($commission_types, $received_commission_types));
        $count_commission = count($commission_types);

        $this->set('error_array', $error_array);
        $this->set('error_count', count($error_array));

        $help_link = "commission_report";
        $this->set("help_link", $help_link);
        $this->set("commission_types", $commission_types);
        $this->set("count_commission", $count_commission);
        $this->set("MLM_PLAN", $this->MLM_PLAN);

        $this->lang->load('amount_type', $this->LANG_NAME);

        $this->setView();
    }

    function epin_report() {

        $title = lang('epin_transfer_report');
        $this->set("title", $this->COMPANY_NAME . " | $title ");
        $this->url_permission('pin_status');

        $this->HEADER_LANG['page_top_header'] = lang('epin_transfer_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('epin_transfer_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $help_link = "payout-report";
        $this->set("help_link", $help_link);
        $this->setView();
    }

    function top_earners_report() {

        $title = lang('top_earners');
        $this->set("title", $this->COMPANY_NAME . " | $title ");

        $this->HEADER_LANG['page_top_header'] = lang('top_earners');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('top_earners');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        
        $base_url = base_url() . 'admin/select_report/top_earners_report';
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;

        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(4);
        } else {
            $page = 0;
        }
        
        $count = $this->select_report_model->getTopEarnersCount();
        $config['total_rows'] = $count;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();
            
        $top_earners = $this->select_report_model->getTopEarners($config['per_page'], $page);
        $help_link = "Top-earners";
        $this->set("help_link", $help_link);
        $this->set("top_earners", $top_earners);
        $this->set('result_per_page', $result_per_page);
        $this->set('page_id', $page);

        $this->setView();
    }

    function activate_deactivate_report() {

        $title = lang('activate_deactivate_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('activate_deactivate_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('activate_deactivate_report');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

        $error_array_actveInactive = array();
        if ($this->session->userdata('inf_total_active_deactive_error')) {
            $error_array_actveInactive = $this->session->userdata('inf_total_active_deactive_error');

            $this->session->unset_userdata('inf_total_active_deactive_error');
        }

        $this->set('error_array_actveInactive', $error_array_actveInactive);
        $this->set('error_count_activeInactive', count($error_array_actveInactive));

        $help_link = "activate_inactivate-report";
        $this->set("help_link", $help_link);

        $this->setView();
    }

    function ajax_users_auto($user_name = "") {
       // $letters = preg_replace("/[^a-z0-9 ]/si", "", $user_name);
        $user_detail = $this->select_report_model->selectUser($user_name);
        echo $user_detail;
    }

    function ajax_epin_auto($user_name = "") {
        $letters = preg_replace("/[^a-z0-9 ]/si", "", $user_name);
        $str = $this->select_report_model->selectEpin($letters);
        echo $str;
    }

    function repurchase_report() {
        $title = lang('repurchase_report');
        $this->set("title", $this->COMPANY_NAME . " | $title ");

        $this->HEADER_LANG['page_top_header'] = lang('repurchase_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('repurchase_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $error_array = array();
        if ($this->session->userdata('inf_repurchase_report_view_error')) {
            $error_array = $this->session->userdata('inf_repurchase_report_view_error');
            $this->session->unset_userdata('inf_repurchase_report_view_error');
        }
        $this->set('error_array', $error_array);
        $this->set('error_count', count($error_array));

        $help_link = "Purchase-report";
        $this->set("help_link", $help_link);

        $this->setView();
    }

    function stair_step_report() {
        
        $title = lang('stair_step_report');
        $this->set("title", $this->COMPANY_NAME . " | $title ");

        $this->HEADER_LANG['page_top_header'] = lang('stair_step_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('stair_step_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $error_array = array();
        if ($this->session->userdata('inf_stair_step_report_view_error')) {
            $error_array = $this->session->userdata('inf_stair_step_report_view_error');
            $this->session->unset_userdata('inf_stair_step_report_view_error');
        }
        $this->set('error_array', $error_array);
        $this->set('error_count', count($error_array));

        $help_link = "stair-step-report";
        $this->set("help_link", $help_link);

        $this->setView();
    }
    
    function override_report() {
        $title = lang('override_report');
        $this->set("title", $this->COMPANY_NAME . " | $title ");

        $this->HEADER_LANG['page_top_header'] = lang('override_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('override_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $error_array = array();
        if ($this->session->userdata('inf_override_report_view_error')) {
            $error_array = $this->session->userdata('inf_override_report_view_error');
            $this->session->unset_userdata('inf_override_report_view_error');
        }
        $this->set('error_array', $error_array);
        $this->set('error_count', count($error_array));

        $help_link = "override_report";
        $this->set("help_link", $help_link);

        $this->setView();
    }
//config change report    
    function config_changes_report() {
        $title = lang('config_history');
        $this->set("title", $this->COMPANY_NAME . " | $title ");

        $this->HEADER_LANG['page_top_header'] = lang('settings_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('settings_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $help_link = "configuration-history-report";
        $this->set("help_link", $help_link);
        $this->setView();
    }
            
    function rank_performance_report() {
        $full_name = '';
        $date = date("Y-m-d");
        $this->set("date", $date);
        
        $title = lang('rank_performance_report');
        $this->set("title", $this->COMPANY_NAME . " | $title ");
        $this->url_permission('rank_status');

        $this->HEADER_LANG['page_top_header'] = "Rank Performance Report";
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = "Rank Performance Report";
        $this->HEADER_LANG['page_small_header'] = '';
        $user_name = $this->LOG_USER_NAME;
        $user_id = $this->LOG_USER_ID;        
        $this->load_langauge_scripts();
        
        $base_url = base_url() . 'user/select_report/rank_performance_report';

        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(4);
        } else {
            $page = 0;
        }
        $user_details = $this->validation_model->getAllUserDetails($user_id);
        if(isset($user_details['user_detail_name'])){
            $full_name = $user_details['user_detail_name'];
        }
         
        $this->set('report_name', "");
        $help_link = "Top-earners";
        $this->set("report_date", '');
        $this->set("help_link", $help_link);

        $this->set("user_name", $user_name);
        $this->set("full_name", $full_name);

        $this->setView();
    }
    
     function roi_report() {
        $this->url_permission('roi_status');
        
        $title = lang('roi_report');
        $this->set("title", $this->COMPANY_NAME . " | $title ");

        $this->HEADER_LANG['page_top_header'] = lang('roi_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('roi_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $error_array = array();
        if ($this->session->userdata('inf_roi_report_view_error')) {
            $error_array = $this->session->userdata('inf_roi_report_view_error');
            $this->session->unset_userdata('inf_roi_report_view_error');
        }
        $this->set('error_array', $error_array);
        $this->set('error_count', count($error_array));

        $help_link = "ROI-report";
        $this->set("help_link", $help_link);

        $this->setView();
    }
    
    function stripe_monhtly_recurring_report() {

        $title = lang('stripe_monhtly_recurring_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('stripe_monhtly_recurring_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('stripe_monhtly_recurring_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $error_array = array();
        if ($this->session->userdata('inf_stripe_monhtly_recurring_report_error')) {
            $error_array = $this->session->userdata('inf_stripe_monhtly_recurring_report_error');
            $this->session->unset_userdata('inf_stripe_monhtly_recurring_report_error');
        }

        $this->set('error_array', $error_array);
        $this->set('error_count', count($error_array));

        $help_link = "stripe_monhtly_recurring_report";
        $this->set("help_link", $help_link);
        $this->set("MLM_PLAN", $this->MLM_PLAN);

        $this->setView();
    }

}
