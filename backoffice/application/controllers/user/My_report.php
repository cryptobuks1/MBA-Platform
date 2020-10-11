<?php

require_once 'Inf_Controller.php';

class My_report extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function unilevel_history() {
        $title = lang('unilevel_history');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "unilevel_history";
        $this->set("help_link", $help_link);
       // $this->url_permission('sponsor_commission_status');

        $this->HEADER_LANG['page_top_header'] = lang('unilevel_history');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('unilevel_history');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $unievel = array();
        $unilevel_histroy_levl = '';
        $user_id = $this->LOG_USER_ID;
        $level_value = 'all';
        if ($this->input->post('user_details')) {
            $level_value = $this->input->post('level', TRUE);
        }
        
        if ($user_id != 0) {
            $unievel = $this->my_report_model->getAllUnilevel($user_id);
            $level_arr = array();
            ///////////////////////////////////////////////////////////

            $lvl = array();
            foreach ($unievel as $key => $row) {
                $lvl[$key] = $row['level'];
            }
            array_multisort($lvl, SORT_ASC, $unievel);
            //////////////////////////////////////////////////
            foreach ($unievel as $level) {
                array_push($level_arr, $level['level']);
            }
            $level_arr = array_unique($level_arr, SORT_STRING);

            $this->set("level_arr", $level_arr);
            $unilevel_histroy_level = 'all';

            $level = $level_value;
            $this->set('level', $level);
            if ($level != 'all') {
                $index = 0;               
                foreach ($unievel as $user) {

                    if ($user['level'] != $level) {
                        unset($unievel[$index]);
                    }
                    $index++;
                }
            }
            $this->session->set_userdata("inf_unilevel_histroy_level", $level);
            $unilevel_histroy_level = $this->session->userdata('inf_unilevel_histroy_level');
//        -------------------pagination starts----------------------
            $base_url = base_url() . "user/my_report/unilevel_history";
            $config = $this->pagination->customize_style();
            $config['base_url'] = $base_url;
            $config['per_page'] = $this->PAGINATION_PER_PAGE;

            if ($this->uri->segment(4) != "")
                $page = $this->uri->segment(4) / $config['per_page'];
            else
                $page = 0;

            $total_rows = count($unievel);
            $config['total_rows'] = $total_rows;
            $this->pagination->initialize($config);
            $start = $page * $config['per_page'];
            $end = $page * $config['per_page'] + $config['per_page'];
            $unievel = array_slice($unievel, $start, $config['per_page']);
            $this->set('details_count', $total_rows);
            $result_per_page = $this->pagination->create_links();
            $this->set('result_per_page', $result_per_page);
            $this->set('start', $start);
        }

        $this->set("unievel", $unievel);
        $this->set('unilevel_histroy_level', $unilevel_histroy_level);

        ////////////////////////////////////////////////////////////////////////////////////


        $this->setView();
    }

    function binary_history($param = "") {

        $title = lang('downline_list');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "downline_list";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('downline_list');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('downline_list');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;
        $level_value = 'all';
        if ($this->input->post('user_details')) {
            $level_value = $this->input->post('level', TRUE);
        }

        $binary = array();
        $binary_level = '';

        if ($user_id != 0) {
            $binary = $this->my_report_model->getDownlineDetailsBinary($user_id);
            $bin = $binary;
            $level_arr = array();
            foreach ($binary as $level) {
                array_push($level_arr, $level['level']);
            }
            $level_arr = array_unique($level_arr, SORT_STRING);

            $this->set("level_arr", $level_arr);
            $base_url = base_url() . "user/my_report/binary_history";
             $config = $this->pagination->customize_style();
            $binary_level = 'all';
            $level = $level_value;
            $this->set('level', $level);
            $base_url = base_url() . "user/my_report/binary_history/?level=$level";
            if ($level != 'all') {
                $index = 0;
                foreach ($binary as $user) {
                    if ($user['level'] != $level) {
                        unset($binary[$index]);
                    }
                    $index++;
                }
            }

            $this->session->set_userdata("inf_binary_histroy_level", $level);
            $binary_level = $this->session->userdata('inf_binary_histroy_level');

            $base_url = base_url() . "user/my_report/binary_history";
            $config['base_url'] = $base_url;
            $config['per_page'] = $this->PAGINATION_PER_PAGE;

            if ($this->uri->segment(4) != "")
                $page = $this->uri->segment(4) / $config['per_page'];
            else
                $page = 0;

            $total_rows = count($binary);
            $config['total_rows'] = $total_rows;
            $this->pagination->initialize($config);
            $start = $page * $config['per_page'];
            $end = $page * $config['per_page'] + $config['per_page'];
            $binary = array_slice($binary, $start, $config['per_page']);
            $this->set('details_count', $total_rows);
            $result_per_page = $this->pagination->create_links();
            $this->set('result_per_page', $result_per_page);
            $this->set('start', $start);
        }
        $this->set('binary_level', $binary_level);
        $this->set("binary", $binary);
        
        $this->setView();
    }

}
