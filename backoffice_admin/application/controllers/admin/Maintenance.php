<?php

require_once 'Inf_Controller.php';

class maintenance extends Inf_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('maintenance_model');
        $this->load->model('validation_model');
    }

    public function site_maintenance_mode() {
        $title = lang('site_maintance_mode');
        $this->set("title", $this->COMPANY_NAME . "|" . $title);

        $this->HEADER_LANG['page_top_header'] = lang('site_maintance_mode');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('site_maintance_mode');
        $this->HEADER_LANG['page_small_header'] = lang('');
        $this->load_langauge_scripts();

        $maintenance_mode = $this->maintenance_model->getSitemaintanenceConfig();
        $this->set('maintenance_mode', $maintenance_mode);

        if ($this->session->userdata('inf_error')) {
            $error = $this->session->userdata('inf_error');
            $this->session->unset_userdata('inf_error');
            $this->set('error', $error);
        }

        $this->setView();
    }

   public function site_maintenance() {
        if ($this->input->post('site_submit') && $this->validate_submit_data($this->input->post('status'))) {
            
            $site_post_array = $this->input->post(NULL, TRUE);
            $site_post_array = $this->validation_model->stripTagsPostArray($site_post_array);
            $site_post_array = $this->validation_model->escapeStringPostArray($site_post_array);

            $site_post_array['description'] = $this->validation_model->stripTagTextArea($this->input->post('description'));
            $today_date = date("Y-m-d H:i:s");

            if (!isset($site_post_array['block_login'])) {
                $site_post_array['block_login'] = 0;
            }
            if (!isset($site_post_array['block_register'])) {
                $site_post_array['block_register'] = 0;
            }
            if (!isset($site_post_array['block_ecommerce'])) {
                $site_post_array['block_ecommerce'] = 0;
            }

            if ($site_post_array['status']) {
                $site_post_array['block_login'] = 0;
                $site_post_array['block_register'] = 0;
                $site_post_array['block_ecommerce'] = 0;
            }

            if ($site_post_array['status'] && $today_date > $site_post_array['date_available']) {
               
                $this->redirect(lang('date_always_greater_than_today'), "maintenance/site_maintenance_mode", FALSE);
            }

            $result = $this->maintenance_model->updateSiteMaintanence($site_post_array);

            if ($result) {
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Site Maintenance Updated', $this->LOG_USER_ID, $data = '');
                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_site_maintenance', 'Site Maintenance Updated');
                }
                //

                $this->redirect(lang('update_site_miantanence_details_successfully'), "maintenance/site_maintenance_mode", TRUE);
                die();
                
            } else {
                $this->redirect(lang('update_failed'), "maintenance/site_maintenance_mode", FALSE);
            }
        } else {
            
            
            $error = $this->form_validation->error_array();
            $this->session->set_userdata('inf_error', $error);
            $msg = "Your Form Have Some Errors!Please Check";
            $this->redirect($msg, "maintenance/site_maintenance_mode", FALSE);
        }
    }

    function validate_submit_data($mode) {
        $result = false;
        if ($mode) {
            $this->form_validation->set_rules("title", lang('site_title'), "trim|required");
            $this->form_validation->set_rules("description", lang('site_description'), "trim|required");
            $this->form_validation->set_rules("date_available", lang('Date'), "trim|required");
            $result = $this->form_validation->run();
        } else {
            $result = true;
        }
        return $result;
    }

}
