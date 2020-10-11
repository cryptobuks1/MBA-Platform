<?php

require_once 'Inf_Controller.php';

class activate extends Inf_Controller {

    function activate_deactivate() {
        $title = lang('bolck_unblock');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('block_unblock');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('block_unblock');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = 'block_unblock';
        $this->set("help_link", $help_link);

        $this->form_validation->set_rules('user_name', lang('user_name'), 'required');

        $flag = "";
        $admin_user_name = $this->ADMIN_USER_NAME;

        if ($this->uri->segment(3) == "" || $this->uri->segment(3) == 'tab1') {
            $tab1 = ' active';
            $tab2 = null;
        } else {
            $tab2 = ' active';
            $tab1 = null;
        }

        if ($this->input->post('user_name')) {
            $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required');
            if ($this->form_validation->run()) {
                $user_name = (strip_tags($this->input->post('user_name', TRUE)));
                $user_id = $this->validation_model->userNameToID($user_name);
                if ($user_id == 0) {
                    $msg = lang('invalid_username');
                    $this->redirect($msg, "activate_deactivate", false);
                }

                $user_details = $this->activate_model->getUserInformation($user_id);
                $this->set("user_details", $user_details);
                $this->set("user_name", $user_name);
                $flag = "true";
            } else {
                $msg = lang('you_must_enter_username');
                $this->redirect($msg, "activate_deactivate", false);
            }
        } else {

            $pagination1 = new CI_Pagination();
            $base_url1 = base_url() . "admin/activate_deactivate/tab1/";
            $config1 = $pagination1->customize_style();
            $config1['base_url'] = $base_url1;
             $config1['per_page'] = $this->PAGINATION_PER_PAGE;
          //  $config1['per_page'] = 2;

            $pagination2 = new CI_Pagination();
            $base_url2 = base_url() . "admin/activate_deactivate/tab2/";
            $config2 = $pagination1->customize_style();
            $config2['base_url'] = $base_url2;
            // $config2['per_page'] = $this->PAGINATION_PER_PAGE;
            $config2['per_page'] = 2;

            $user_details1 = $this->activate_model->getUserInformation('', '', '','yes');
            $user_details2 = $this->activate_model->getUserInformation('', '', '','no');

            $total_rows1 = count($user_details1);
            $config1['total_rows'] = $total_rows1;
            $config1["uri_segment"] = 4;
            if ($this->uri->segment(3) == 'tab1') {
                $page1 = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
                $config1["cur_page"] = $page1;
            } else {
                $page1 = 0;
                $config1["cur_page"] = 1;
            }
            $pagination1->initialize($config1);
            $start1 = $page1;
            $end1 = $page1 * $config1['per_page'] + $config1['per_page'];
            $result_per_page1 = $pagination1->create_links();
            $this->set("result_per_page1", $result_per_page1);
            $this->set('start1', $start1 + 1);

            $total_rows2 = count($user_details2);
            $config2['total_rows'] = $total_rows2;
            $config2["uri_segment"] = 4;
            if ($this->uri->segment(3) == 'tab2') {
                $page2 = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
                $config2["cur_page"] = $page2;
            } else {
                $page2 = 0;
                $config2["cur_page"] = 1;
            }
            $pagination2->initialize($config2);
            $start2 = $page2;
            $end2 = $page2 * $config2['per_page'] + $config2['per_page'];
            $result_per_page2 = $pagination2->create_links();
            $this->set("result_per_page2", $result_per_page2);
            $this->set('start2', $start2 + 1);

            $user_details1 = array_slice($user_details1, $start1, $config1['per_page']);
            $user_details2 = array_slice($user_details2, $start2, $config2['per_page']);

            $this->set("user_details1", $user_details1);
            $this->set("user_details2", $user_details2);
            $this->set('tab1', $tab1);
            $this->set('tab2', $tab2);
        }
        $this->set("flag", $flag);
        $this->set("admin_user_name", $admin_user_name);

        $this->setView();
    }

    function deactivate_user() {

        $post_arr = $this->input->post(NULL, TRUE);
        $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
        $user_name = $post_arr['user_name'];
        $user_id = $this->validation_model->userNameToID($user_name);
        if (!$user_id) {
            $msg = lang('invalid_user_name');
            $this->redirect($msg, 'activate_deactivate', FALSE);
        }
        $admin_user_id = $this->validation_model->getAdminId();
        if($admin_user_id == $user_id) {
            $msg = 'You can\'t deactivate admin user';
            $this->redirect($msg, "activate_deactivate", false);
        }
        if(DEMO_STATUS == 'yes') {
            $preset_user = $this->validation_model->getPresetUser($admin_user_id);
            if($preset_user == $user_name) {
                $msg = 'You can\'t deactivate preset user';
                $this->redirect($msg, "activate_deactivate", false);
            }
        }
        $result = $this->activate_model->inactivateAccount($user_id, 'admin');

        if ($result) {
            $data = serialize($post_arr);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, $user_name.' User Deactivated', $this->LOG_USER_ID, $data);

            // Employee Activity History
            if ($this->LOG_USER_TYPE == 'employee') {
                $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'deactivate_user', $user_name.' User Deactivated');
            }
            //

            $msg = lang('user_deactivated');
            $this->redirect($msg, "activate_deactivate", true);
        } else {
            $msg = lang('user_not_deactivated');
            $this->redirect($msg, "activate_deactivate", false);
        }
    }

    function activate_user() {
        $post_arr = $this->input->post(NULL, TRUE);
        $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
        $user_name = $post_arr['user_name'];
        $user_id = $this->validation_model->userNameToID($user_name);
        if (!$user_id) {
            $msg = lang('invalid_user_name');
            $this->redirect($msg, 'activate_deactivate', FALSE);
        }
        $admin_user_id = $this->validation_model->getAdminId();
        if($admin_user_id == $user_id) {
            $msg = 'You can\'t activate admin user';
            $this->redirect($msg, "activate_deactivate", false);
        }
        if(DEMO_STATUS == 'yes') {
            $preset_user = $this->validation_model->getPresetUser($admin_user_id);
            if($preset_user == $user_name) {
                $msg = 'You can\'t activate preset user';
                $this->redirect($msg, "activate_deactivate", false);
            }
        }
        $result = $this->activate_model->activateAccount($user_id, 'admin');
        if ($result) {
            $data = serialize($post_arr);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, $user_name.' User Activated', $this->LOG_USER_ID, $data);

            // Employee Activity History
            if ($this->LOG_USER_TYPE == 'employee') {
                $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'activate_user', $user_name.' User Activated');
            }
            //

            $msg = lang('user_activated');
            $this->redirect($msg, "activate_deactivate", true);
        } else {
            $msg = lang('user_not_activated');
            $this->redirect($msg, "activate_deactivate", false);
        }
    }

}
