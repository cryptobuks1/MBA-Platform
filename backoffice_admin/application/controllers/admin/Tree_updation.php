<?php

require_once 'Inf_Controller.php';

class Tree_updation extends Inf_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('tree_model');
        
        if(DEMO_STATUS == 'yes') {
            $is_preset_demo = $this->validation_model->isPresetDemo($this->ADMIN_USER_ID);
            $this->set('preset_demo', $is_preset_demo);
            if($is_preset_demo) {
                $note = 'This functionality not available for Preset Demos...';
                if($this->input->post()) {
                    $this->redirect($note, 'home/index');
                }
                $this->set('demo_note', $note);
            }
        }
    }

    function index() {
        $this->redirect("", "home");
    }
    
    function delete_user() {

        $title = lang('delete_user');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'delete_user';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('delete_user');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('delete_user');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        
        if ($this->input->post('delete_user')) {
            $user_name = $this->input->post('user_name', TRUE);
            $user_id = $this->validation_model->userNameToID($user_name);
            if (!$user_id) {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'tree_updation/delete_user', FALSE);
            }
            if($user_id == $this->ADMIN_USER_ID) {
                $msg = lang('cant_delete_admin_user');
                $this->redirect($msg, 'tree_updation/delete_user', FALSE);
            }
            $has_child = $this->tree_updation_model->hasChildren($user_id);
            if($has_child) {
                $msg = lang('cant_delete_user_with_child');
                $this->redirect($msg, 'tree_updation/delete_user', FALSE);
            }
            $mlm_plan = $this->MODULE_STATUS['mlm_plan'];
            $opencart_status = 'no';
            if($this->MODULE_STATUS['opencart_status_demo'] == 'yes' && $this->MODULE_STATUS['opencart_status'] == 'yes') {
                $opencart_status = 'yes';
            }
            $res = $this->tree_updation_model->deleteUser($user_id, $mlm_plan, $opencart_status);
            if($res) {
                $msg = lang('success_delete_user');
                $this->redirect($msg, 'tree_updation/delete_user', TRUE);
            }
            else {
                $msg = lang('error_delete_user');
                $this->redirect($msg, 'tree_updation/delete_user', FALSE);
            }
        }

        $this->setView();
    }
    
    function change_sponsor() {
        
        $mlm_plan = $this->MODULE_STATUS['mlm_plan'];

        $title = lang('change_sponsor');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'change_sponsor';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('change_sponsor');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('change_sponsor');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        
        if ($this->input->post('change_sponsor')) {
            $user_name = $this->input->post('user_name', TRUE);
            $user_id = $this->validation_model->userNameToID($user_name);
            if (!$user_id) {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'tree_updation/change_sponsor', FALSE);
            }
            if($user_id == $this->ADMIN_USER_ID) {
                $msg = lang('cant_select_admin_user');
                $this->redirect($msg, 'tree_updation/change_sponsor', FALSE);
            }
            $new_sponsor_name = $this->input->post('new_sponsor', TRUE);
            $new_sponsor_id = $this->validation_model->userNameToID($new_sponsor_name);
            if (!$new_sponsor_id) {
                $msg = lang('invalid_sponsor_name');
                $this->redirect($msg, 'tree_updation/change_sponsor', FALSE);
            }
            if ($user_id == $new_sponsor_id) {
                $msg = lang('choose_another_sponsor');
                $this->redirect($msg, 'tree_updation/change_sponsor', FALSE);
            }
            $current_sponsor_id = $this->validation_model->getSponsorId($user_id);
            if($current_sponsor_id == $new_sponsor_id) {
                $msg = lang('choose_another_sponsor');
                $this->redirect($msg, 'tree_updation/change_sponsor', FALSE);
            }
            if(!$this->tree_updation_model->isUserOutsideTeam($user_id, $new_sponsor_id, 'sponsor_tree')) {
                $msg = lang('cant_select_downline_as_sponsor');
                $this->redirect($msg, 'tree_updation/change_sponsor', FALSE);
            }
            $res1 = $this->tree_updation_model->changeSponsor($user_id, $new_sponsor_id);
            $res2 = TRUE;
            if($mlm_plan == 'Unilevel') {
                $new_placement_id = $new_sponsor_id;
                $current_placement_id = $current_sponsor_id;
                $new_position = '';
                $current_position = $this->validation_model->getUserPosition($user_id);
                $res2 = $this->tree_updation_model->changePlacement($user_id, $new_placement_id, $current_placement_id, $mlm_plan, $new_position, $current_position);
            }
            if($res1 && $res2) {
                $msg = lang('success_change_sponsor');
                $this->redirect($msg, 'tree_updation/change_sponsor', TRUE);
            }
            else {
                $msg = lang('error_change_sponsor');
                $this->redirect($msg, 'tree_updation/change_sponsor', FALSE);
            }
        }

        $this->setView();
    }
    
    function change_placement() {
        
        $mlm_plan = $this->MODULE_STATUS['mlm_plan'];

        $title = lang('change_placement');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'change_placement';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('change_placement');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('change_placement');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        
        if ($this->input->post('change_placement')) {
            $user_name = $this->input->post('user_name', TRUE);
            $user_id = $this->validation_model->userNameToID($user_name);
            if (!$user_id) {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'tree_updation/change_placement', FALSE);
            }
            if($user_id == $this->ADMIN_USER_ID) {
                $msg = lang('cant_select_admin_user');
                $this->redirect($msg, 'tree_updation/change_placement', FALSE);
            }
            $new_placement_name = $this->input->post('new_placement', TRUE);
            $new_placement_id = $this->validation_model->userNameToID($new_placement_name);
            if (!$new_placement_id) {
                $msg = lang('invalid_placement_name');
                $this->redirect($msg, 'tree_updation/change_placement', FALSE);
            }
            if ($user_id == $new_placement_id) {
                $msg = lang('choose_another_placement');
                $this->redirect($msg, 'tree_updation/change_placement', FALSE);
            }
            $current_placement_id = $this->validation_model->getFatherId($user_id);
            if($current_placement_id == $new_placement_id && $mlm_plan != 'Binary') {
                $msg = lang('choose_another_placement');
                $this->redirect($msg, 'tree_updation/change_placement', FALSE);
            }
            if(!$this->tree_updation_model->isUserOutsideTeam($user_id, $new_placement_id, 'tree')) {
                $msg = lang('cant_select_downline_as_placement');
                $this->redirect($msg, 'tree_updation/change_placement', FALSE);
            }
            $new_position = '';
            $current_position = $this->validation_model->getUserPosition($user_id);
            if($mlm_plan == 'Binary') {
                $new_position = $this->input->post('new_position', TRUE);
                if(!$new_position) {
                    $msg = lang('must_select_position');
                    $this->redirect($msg, 'tree_updation/change_placement', FALSE);
                }
                if($current_placement_id == $new_placement_id && $current_position == $new_position) {
                    $msg = lang('choose_another_position');
                    $this->redirect($msg, 'tree_updation/change_placement', FALSE);
                }
            }
            $is_position_available = $this->tree_updation_model->isPositionAvailable($new_placement_id, $new_position, $mlm_plan);
            if(!$is_position_available) {
                $msg = lang('choose_another_position');
                $this->redirect($msg, 'tree_updation/change_placement', FALSE);
            }
            
            $res1 = $this->tree_updation_model->changePlacement($user_id, $new_placement_id, $current_placement_id, $mlm_plan, $new_position, $current_position);
            $res2 = TRUE;
            if($mlm_plan == 'Unilevel') {
                $new_sponsor_id = $new_placement_id;
                $res2 = $this->tree_updation_model->changeSponsor($user_id, $new_sponsor_id);
            }
            if($res1 && $res2) {
                $msg = lang('success_change_placement');
                $this->redirect($msg, 'tree_updation/change_placement', TRUE);
            }
            else {
                $msg = lang('error_change_placement');
                $this->redirect($msg, 'tree_updation/change_placement', FALSE);
            }
        }
        
        $this->set('mlm_plan', $mlm_plan);

        $this->setView();
    }
    
    
}
