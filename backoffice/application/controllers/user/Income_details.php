<?php

require_once 'Inf_Controller.php';

class Income_Details extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function income() {

        $title = lang('income_details');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'income_details';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('income_details');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('income_details');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;

        $arr = array();
        $numrows = $result_per_page = 0;
        $filter_date = '';

        if($this->input->post('filter')){

            $post_data = $this->input->post();

            if (isset($post_data['date'])) {
                $filter_date = $this->input->post('date');
                $this->session->set_userdata('inf_all_trans_date', $filter_date);
            }
            if (isset($post_data['clear'])) {
                $this->session->unset_userdata('inf_all_trans_date');
            }


        }
        if ($this->session->has_userdata('inf_all_trans_date')) {
            $filter_date = $this->session->userdata('inf_all_trans_date');
        }

        $base_url = base_url() . 'user/income_details/income';
          $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        if ($this->uri->segment(4) != "")
            $page = $this->uri->segment(4);
        else
            $page = 0;

        $arr = $this->income_details_model->add_income($user_id, $page, $config['per_page'],'',$filter_date);
        $numrows = $this->income_details_model->getCountIncomeDetails($user_id);
        $config['total_rows'] = $numrows;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();

        $level_based_amount_type = [
            'level_commission',
            'repurchase_level_commission',
            'upgrade_level_commission',
            'xup_commission',
            'xup_repurchase_level_commission',
            'xup_upgrade_level_commission',
            'matching_bonus',
            'matching_bonus_purchase',
            'matching_bonus_upgrade',
            'sales_commission',
        ];
        $this->set('level_based_amount_type', $level_based_amount_type);

        $from_user_amount_types = [
            'referral',
            'level_commission',
            'repurchase_level_commission',
            'upgrade_level_commission',
            'xup_commission',
            'xup_repurchase_level_commission',
            'xup_upgrade_level_commission',
            'matching_bonus',
            'matching_bonus_purchase',
            'matching_bonus_upgrade',
            'sales_commission',
        ];
        $this->set('from_user_amount_types', $from_user_amount_types);

        $this->set('result_per_page', $result_per_page);
        $this->set('count', $numrows);
        $this->set('page', $page);
        $this->set('date', $filter_date);
        $this->set("amount", $arr);

        $this->lang->load('amount_type', $this->LANG_NAME);

        $this->setView();
    }

}

