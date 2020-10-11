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

        $this->HEADER_LANG['page_top_header'] = lang('unilevel_history');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('unilevel_history');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $flag = false;

        $unievel = array();
        $unilevel_histroy_level = '';
        $level_value = 'all';
        if ($this->input->post('user_details')) {
            $flag = true;
            $user_name = (strip_tags($this->input->post('user_name', TRUE)));
            $level_value = $this->input->post('level', TRUE);
            $user_id = $this->validation_model->userNameToID($user_name);
            if ($user_id == 0) {
                $msg = lang('please_enter_a_valid_username');
                $this->redirect($msg, 'my_report/unilevel_history', false);
            }
            $this->session->set_userdata('inf_unilevel_user', $user_name);
        } else if ($this->session->userdata('inf_unilevel_user') != NULL) {
            $user_name = $this->session->userdata('inf_unilevel_user');
            $user_id = $this->validation_model->userNameToID($user_name);
        } else if ($this->LOG_USER_TYPE != 'employee') {
            $user_id = $this->LOG_USER_ID;
            $user_name = $this->LOG_USER_NAME;
        } else if ($this->LOG_USER_TYPE == 'employee') {
            $user_id = $this->ADMIN_USER_ID;
            $user_name = $this->ADMIN_USER_NAME;
        } else {
            $user_id = 0;
        }
        if ($user_id != 0) {
            $level_arr = array();
            ///////////////////////////////////////////////////////////

            //        -------------------pagination starts----------------------
            $config = $this->pagination->customize_style();
            $base_url = base_url() . "admin/my_report/unilevel_history";
            $config['base_url'] = $base_url;
            $config['per_page'] = $this->PAGINATION_PER_PAGE;

            if ($this->uri->segment(4) != "" && !$flag)
                $page = $this->uri->segment(4) ;
            else
                $page = 0;

            $level_arr_list = $this->my_report_model->getTotalDownlineUsersForHistory($user_id, 'left_sponsor', 'right_sponsor','unilevel');
            if ($level_value != 'all') {
                $unilevel_histroy_level = $level_value;
                $level_arr_rs = $this->my_report_model->getTotalDownlineUsersForHistory($user_id, 'left_sponsor', 'right_sponsor','unilevel',$level_value);
                $level_value = $this->validation_model->getUserLevel($user_id) + $level_value;
                $unievel = $this->my_report_model->getAllUnilevel($user_id, $config['per_page'], $page, $level_value);
            }else{
                $level_arr_rs = $this->my_report_model->getTotalDownlineUsersForHistory($user_id, 'left_sponsor', 'right_sponsor','unilevel');
                $unievel = $this->my_report_model->getAllUnilevel($user_id,$config['per_page'],$page);
                $unilevel_histroy_level = 'all';
            }

            $config['total_rows'] = $level_arr_rs['count'];
            $this->pagination->initialize($config);
 
            $this->set('details_count', $level_arr_rs['count']);
            $result_per_page = $this->pagination->create_links();
            $this->set('result_per_page', $result_per_page);
            $this->set('start', $page);
            $this->set("username", $user_name);
            $this->set('level', $level_value);

            unset($level_arr_rs['count']);
            unset($level_arr_list['count']);
            foreach ($level_arr_list as $level) {
                array_push($level_arr, $level['level']);
            }
            $level_arr = array_unique($level_arr, SORT_STRING);
            $this->set("level_arr", $level_arr);
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
        $flag = false;
        $level_value = $type = 'all';
        $rank_name = '';
        $rank_id='';
        if ($this->input->post('user_details')) {
            $flag = true;
            $user_name = (strip_tags($this->input->post('user_name')));
            $level_value = $this->input->post('level', TRUE);
            $user_id = $this->validation_model->userNameToID($user_name);
            if ($user_id == 0) {
                $msg = lang('please_enter_a_valid_username');
                $this->redirect($msg, 'my_report/binary_history', false);
            }
            $this->session->set_userdata('inf_binary_user', $user_name);
        } else if ($this->session->userdata('inf_binary_user') != NULL) {
            $user_name = $this->session->userdata('inf_binary_user');
            $user_id = $this->validation_model->userNameToID($user_name);
        } else if ($this->LOG_USER_TYPE != 'employee') {
            $user_id = $this->LOG_USER_ID;
            $user_name = $this->LOG_USER_NAME;
        } else if ($this->LOG_USER_TYPE == 'employee') {
            $user_id = $this->ADMIN_USER_ID;
            $user_name = $this->ADMIN_USER_NAME;
        } else {
            $user_id = 0;
        }

        $binary = array();
        // $level_arr = array();
        $binary_level = '';

        if ($user_id != 0) {

            $base_url = base_url() . "admin/my_report/binary_history";
            $config = $this->pagination->customize_style();
            $config['base_url'] = $base_url;
            $config['per_page'] = $this->PAGINATION_PER_PAGE;

            if ($this->uri->segment(4) != "" && !$flag)
                $page = $this->uri->segment(4);
            else
                $page = 0;
            
            if($this->input->post('rank_name')!=''){
                $rank_name = $this->input->post('rank_name');
                $rank_id = $this->validation_model->getRankIdFromRankname($rank_name);
                //$_SESSION['select_rank'] = $rank_id;
                 $this->session->set_userdata('rank_name', $rank_name);
            }
             if ($this->session->userdata('rank_name') != NULL) {
                $rank_name =$this->session->userdata('rank_name');
            }else{
                $this->session->unset_userdata('rank_name') ;
                $rank_id='';
            }
            
            if($this->input->post('type')!=''){
                $type = $this->input->post('type');
                 $this->session->set_userdata('select_type', $type);
            }
             if ($this->session->userdata('select_type') != '') {
                $type =$this->session->userdata('select_type');
            }else{
                $this->session->unset_userdata('select_type') ;
                $type = 'all';
            }
            
            // if(isset($_SESSION['select_rank'])){
            //     $rank_id = $_SESSION['select_rank'];
            // }
           
            
            $level_arr = $this->my_report_model->getMaxLevelUser($user_id, 'left_father', 'right_father');
            if ($level_value != 'all') {
                $binary_level = $level_value;
                $level_arr_rs = $this->my_report_model->getTotalDownlineUsersBinary($user_id, 'left_father', 'right_father','binary',$level_value, $rank_id,$type);
                $level_value = $this->validation_model->getUserLevel($user_id) + $level_value;
                $binary = $this->my_report_model->getDownlineDetailsBinary($user_id, $config['per_page'], $page, $level_value,$rank_id,$type);
            }else{
                $level_arr_rs = $this->my_report_model->getTotalDownlineUsersBinary($user_id, 'left_father', 'right_father','','',$rank_id,$type);
                $binary = $this->my_report_model->getDownlineDetailsBinary($user_id,$config['per_page'],$page,'',$rank_id,$type);
                $binary_level = 'all';
            }
            
            

            $config['total_rows'] = $level_arr_rs;//print_r($config); die;
            $this->pagination->initialize($config);
            $result_per_page = $this->pagination->create_links();
            $this->set('result_per_page', $result_per_page);
            $this->set("level_arr", $binary);
            $this->set('level', $level_value);
            
            if($this->input->post('rank_name')!=''){
                $rank_name = $this->input->post('rank_name');
                $this->session->set_userdata('rank_name', $rank_name);
            }else{
                $this->session->unset_userdata('rank_name') ;
                $rank_name='';
            }
           
            
            $base_url = base_url() . "user/my_report/binary_history/?level=$level_value";
             $this->set('rank_name', $rank_name);
            $this->set('rank_id', $rank_id);
            $this->set("level_arr", $level_arr);
            $this->set('start', $page);
            $this->set('type', $type);
            $this->set("username", $user_name);
        }
        $this->set('binary_level', $binary_level);
        $this->set("binary", $binary);

        $this->setView();
    }
    public function url_permission_menu($url) {
        $perm = $user_id = $this->validation_model->getUrlPerm($url,$this->LOG_USER_TYPE);
        if($perm == 0){
            $msg = lang('permission_denied');
            $this->redirect($msg, 'home/index', FALSE);
        }
    }

}
