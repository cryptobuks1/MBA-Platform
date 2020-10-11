<?php

require_once 'Inf_Controller.php';

class Income_Details extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function income($page_id='') {

        $title = lang('income_details');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'income-details';
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('income_details');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('income_details');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $from_page = 'link';
        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;
        $is_valid_username = false;
        $amount = array();
        $numrows = $result_per_page = 0;
        $amount_type = "";
        $filter_date = '';
        if ($this->input->post('from_page')) {
            $from_page = 'user_account';
            $this->session->set_userdata('inf_profile_from_page', $from_page);
        } else if ($this->session->userdata('inf_profile_from_page')) {
            $from_page = $this->session->userdata('inf_profile_from_page');
           // $this->session->unset_userdata('inf_profile_from_page');
        }
        if ($this->input->post('user_name')) {
            if ($this->session->userdata('amountType')) {
            $this->session->unset_userdata("amountType");
            }
            $user_name = ($this->input->post('user_name', TRUE));
            $is_valid_username = $this->validation_model->isUserNameAvailable($user_name);
            if (!$is_valid_username) {
                $this->session->unset_userdata("inf_is_valid_username");
                $msg = lang('Username_not_Exists');
                $this->redirect($msg, 'income_details/income', false);
            }

            if ($this->validate_income()) {
                $this->session->set_userdata("inf_is_valid_username", $user_name);
            } else {
                $this->session->unset_userdata("inf_is_valid_username");
            }
        } elseif (!$this->session->userdata('inf_is_valid_username')) {
            $this->session->set_userdata('inf_is_valid_username', $this->validation_model->getAdminUsername());
        }
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
        $user_name = $this->session->userdata("inf_is_valid_username");
        $user_id = $this->validation_model->userNameToID($user_name);
        $all_amount_type = $this->validation_model->getAllAmountType();
        $count_amount_type = count($all_amount_type);

        $is_valid_username = $user_name;
        $base_url = base_url() . 'admin/income_details/income';
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        if ($this->uri->segment(4) != "")
            $page = $this->uri->segment(4);
        else
            $page = 0;

        if ($this->session->userdata('amountType')) {
        $amount = $this->income_details_model->add_income($user_id, $page, $config['per_page'] ,$this->session->userdata("amountType"),$filter_date);
        $numrows = $this->income_details_model->getCountIncomeDetails($user_id);
        } else {
        $amount = $this->income_details_model->add_income($user_id, $page, $config['per_page'], $amount_type,$filter_date);
        $numrows = $this->income_details_model->getCountIncomeDetails($user_id);
        }

        if ($this->input->post('search_amountype_submit')) {
            $filter_date = '';
            $this->session->unset_userdata('inf_all_trans_date');
            $amount_type = $this->input->post('amount_type', TRUE);
            if ($amount_type != 'all') {
                $this->session->set_userdata("amountType", $amount_type);
                $amount = $this->income_details_model->add_income($user_id,'', $config['per_page'], $amount_type);
                $numrows = $this->income_details_model->getCountIncomeDetails($user_id);
            }
            if ($amount_type == 'all') {
                $this->session->unset_userdata("amountType");
                $amount = $this->income_details_model->add_income($user_id,'', $config['per_page']);
                $numrows = $this->income_details_model->getCountIncomeDetails($user_id);
            }
        }
        //print_r($amount); die;

        if($this->input->post('overview_disp')) {
            $this->set('overview_disp', true);
        } else {
            $this->set('overview_disp', false);
        }

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

        $this->set('count_amount_type', $count_amount_type);
        $this->set('all_amount_type', $all_amount_type);
        $this->set('result_per_page', $result_per_page);
        $this->set('count', $numrows);
        $this->set('is_valid_username', $is_valid_username);
        $this->set('amount', $amount);
        $this->set('user_name', $user_name);
        $this->set('page_id', $page_id);
        $this->set('date', $filter_date);
        $this->set('from_page', $from_page);
        $this->set('amount_type', $this->session->userdata("amountType"));

        $this->lang->load('amount_type', $this->LANG_NAME);

        $this->setView();
    }

    function validate_income() {
        $this->form_validation->set_rules('user_name', lang("user_name"), 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

}
