<?php

require_once 'Inf_Controller.php';

class Leg_Count extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function view_leg_count() {

        /////////////////////  CODE ADDED BY JIJI  //////////////////////////
        $title = lang('leg_count');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $product_status = $this->MODULE_STATUS['product_status'];
        $this->leg_count_model->initialize($product_status);

        $user_id = $this->LOG_USER_ID;
        $user_type = $this->LOG_USER_TYPE;

        $help_link = "leg_count";
        $this->set("help_link", $help_link);
        $user_leg_detail = $numrows = $result_per_page = 0;

        $this->HEADER_LANG['page_top_header'] = lang('leg_count');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('leg_count');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $base_url = base_url() . 'user/leg_count/view_leg_count';
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        if ($this->uri->segment(4) != "")
            $page = $this->uri->segment(4);
        else
            $page = 0;

        $user_leg_detail = $this->leg_count_model->getUserLegDetails($user_id, $page, $config['per_page'], $user_type);
        $numrows = $this->leg_count_model->getCountLegDetails($user_id, $user_type);
     
        $config['total_rows'] = $numrows;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();
        
        $this->set("user_leg_detail", $user_leg_detail);
        $this->set("count", $numrows);
        $result_per_page = $this->pagination->create_links();
        $this->set("result_per_page", $result_per_page);
        $this->setView();
    }

}
