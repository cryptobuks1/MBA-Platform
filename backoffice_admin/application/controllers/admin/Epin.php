<?php

require_once 'Inf_Controller.php';

class Epin extends Inf_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->url_permission('pin_status');
    }

    function epin_management()
    {
        $title = lang('new_epin');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'e-pin-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('new_epin');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('new_epin');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $pin_status = 'active';
        $empty_msg = lang('your_account_have_no_active_epin');

        if ($this->input->post('view_pin_active')) {
            $pin_status = 'active';
            $this->session->set_userdata('inf_pin_status', $pin_status);
        }
        if ($this->input->post('view_pin_inactive')) {
            $pin_status = 'inactive';
            $this->session->set_userdata('inf_pin_status', $pin_status);
        }
        if ($this->session->userdata('inf_pin_status')) {
            $pin_status = $this->session->userdata('inf_pin_status');
            if ($pin_status == 'inactive') {
                $empty_msg = $this->lang->line('no_inactive_pin_found');
            }
            $this->session->unset_userdata('inf_pin_status');
        }

        $base_url = base_url() . 'admin/epin_management';
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $page = 0;
        if ($this->uri->segment(3) != '') {
            $page = $this->uri->segment(3);
        }
        $pin_details = $this->epin_model->pinSelector($page, $config['per_page'], $pin_status);
        $pin_numbers = $pin_details['pin_numbers'];
        $num_rows = $pin_details['numrows'];
        $config['total_rows'] = $num_rows;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();

        $this->set('pin_numbers', $pin_numbers);
        $this->set('count', count($pin_numbers));
        $this->set('result_per_page', $result_per_page);
        $this->set('page', $page);
        $this->set('display', 'no-display');
        $this->set('empty_msg', $empty_msg);
        $this->set('status_pin', $pin_status);

        $this->setView();
    }

    function search_epin()
    {
        $title = lang('view_epin');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'e-pin-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('view_epin');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('view_epin');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $amount_details = $this->epin_model->getAllEwalletAmounts();
        $search_pin_details = array();
        $amount = ($this->input->get('key') && is_numeric($this->input->get('key'))) ? $this->input->get('key') : '';

        if ($this->input->post('search_pin') && $this->validate_search_epin()) {
            $pin_number = strip_tags($this->input->post('keyword'));
            $search_pin_details = $this->epin_model->getPinDetails($pin_number, 'yes');
            if (count($search_pin_details) == 0) {
                $this->session->unset_userdata('epin_search_type');
                $msg = lang('no_epin_found');
                $this->redirect($msg, 'epin/search_epin', false);
            }
            $this->session->set_userdata('epin_search_type', 'pin_number');
        }

        if ($this->input->post('search_pin_pro') && $this->validate_search_pin_amount()) {
            $amount = strip_tags($this->input->post('amount'));
            $this->session->set_userdata('epin_search_type', 'pin_amount');
            $this->session->set_userdata('epin_amount', $amount);
        }

        $epin_search_type = '';
        if ($this->session->has_userdata('epin_search_type')) {
            if ($this->session->userdata('epin_search_type') == 'pin_number') {
                $epin_search_type = 'pin_number';
            }
            if ($this->session->userdata('epin_search_type') == 'pin_amount') {
                $epin_search_type = 'pin_amount';
                if (!$amount) {
                    $this->session->unset_userdata('epin_search_type');
                    $this->redirect("", "epin/search_epin", false);
                }
                if ($amount != '')
                    $base_url = base_url() . "admin/epin/search_pin";
                else
                    $base_url = base_url() . "admin/epin/search_epin";
                $config = $this->pagination->customize_style();
                $config['base_url'] = $base_url;
                $config['per_page'] = $this->PAGINATION_PER_PAGE;
                $page = 0;
                if ($this->uri->segment(3) != '') {
                    $page = $this->uri->segment(3);
                }
                $search_pin_details = $this->epin_model->getPinSearch($amount, 'yes', $page, $config['per_page']);
                $search_pin_count = $this->epin_model->getPinSearchCount($amount, 'yes');
                if (count($search_pin_details) == 0) {
                    $this->session->unset_userdata('epin_search_type');
                    $msg = lang('no_epin_available');
                    $this->redirect($msg, "epin/search_epin?key=$amount", false);
                }
                $num_rows = $search_pin_count;
                $config['total_rows'] = $num_rows;
                $this->pagination->initialize($config);
                $result_per_page = $this->pagination->create_links();
                $this->set('result_per_page', $result_per_page);
                $this->set('page', $page);
            }
        }
        if (empty($search_pin_details)) {

            $epin_search_type = 'pin_amount';
            $base_url = base_url() . "admin/search_epin";
            $config = $this->pagination->customize_style();
            $config['base_url'] = $base_url;
            $config['per_page'] = $this->PAGINATION_PER_PAGE;
            $page = 0;
            if ($this->uri->segment(3) != '') {
                $page = $this->uri->segment(3);
            }
            $search_pin_details = $this->epin_model->getPinSearch('', 'yes', $page, $config['per_page']);
            $search_pin_count = $this->epin_model->getPinSearchCount('', 'yes');
            $num_rows = $search_pin_count;
            $config['total_rows'] = $num_rows;
            $this->pagination->initialize($config);
            $result_per_page = $this->pagination->create_links();
            $this->set('result_per_page', $result_per_page);
            $this->set('page', $page);
        }
        $this->set('epin_search_type', $epin_search_type);
        $this->set('amount_details', $amount_details);
        $this->set('search_pin_count', count($search_pin_details));
        $this->set('search_pin_details', $search_pin_details);
        $this->set('amount', $amount);
        $this->setView();
    }
    function search_pin()
    {
        $pin_amount = '';
        if ($this->session->has_userdata('epin_amount') && $this->session->userdata('epin_search_type')) {
            $pin_amount = $this->session->userdata('epin_amount');
        }
        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(4);
        } else {
            $page = 0;
        }
        $this->redirect("", "epin/search_epin/$page/?key=$pin_amount", false);
    }

    function view_epin_request()
    {
        $title = lang('epin_request');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'view-pin-request';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('epin_request');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('epin_request');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $pro_status = $this->MODULE_STATUS['product_status'];
        if ($this->input->post('allocate')) {
            $pin_post_array = $this->input->post(null, true);
            $pin_post_array = $this->validation_model->stripTagsPostArray($pin_post_array);
            $total_count = $pin_post_array['total_count'];
            $admin_id = $this->LOG_USER_ID;
            $user_type = $this->LOG_USER_TYPE;
            if ($user_type == 'employee') {
                $admin_id = $this->validation_model->getAdminId();
            }
            $uploded_date = date('Y-m-d H:i:s');
            $pin_alloc_date = date('Y-m-d H:i:s');
            $status = 'yes';
            $res = true;
            $flag = false;
            $flag1 = true;
            $flag2 = true;
            $pin_post_array['checked'] = 'no';
            for ($i = 1; $i < $total_count; $i++) {
                if ($pin_post_array['count' . $i] < 0) {
                    $flag1 = false;
                }
                if ($pin_post_array['count' . $i] == '') {
                    $flag2 = false;
                }
                if (isset($pin_post_array['active' . $i])) {
                    $pin_post_array['checked'] = 'yes';
                    $flag = true;
                }
            }
            if (!$flag) {
                $msg = lang('please_select_checkbox');
                $this->redirect($msg, 'epin/view_epin_request', false);
            }
            if (!$flag1) {
                $msg = lang('you_must_enter_a_positive_value');
                $this->redirect($msg, 'epin/view_epin_request', false);
            }
            if (!$flag2) {
                $msg = lang('count_field_is_required');
                $this->redirect($msg, 'epin/view_epin_request', false);
            }
            $this->epin_model->begin();
            for ($i = 1; $i < $total_count; $i++) {
                if (isset($pin_post_array['active' . $i])) {
                    $id = $pin_post_array['id' . $i];
                    $pin_count = $pin_post_array['count' . $i];
                    $allocate_id = $pin_post_array['user_id' . $i];
                    $rem_count = $pin_post_array['rem_count' . $i];
                    $expiry_date = $pin_post_array['expiry_date' . $i];
                    $amount = $pin_post_array['amount' . $i];
                    if ($pin_post_array['checked'] == 'yes') {
                        $flag = 1;
                        if ($pin_count <= $rem_count) {

                            $res = $this->epin_model->ifChecked($id, $pin_count, $pin_alloc_date, $status, $uploded_date, $admin_id, $allocate_id, $rem_count, $amount, $expiry_date);
                            if (!$res) {
                                $res = false;
                                $msg = lang('error_on_epin_allocation');
                                break;
                            }
                        } else {
                            $res = false;
                            $msg = lang('epin_count_should_less_req_count');
                            break;
                        }
                    }
                }
            }
            if ($res) {
                $this->epin_model->commit();
                $data = serialize($pin_post_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'epin requests granted', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'grant_epin_request', 'EPIN Request Granted');
                }
                $msg = lang('epin_allocated_successfully');
                $this->redirect($msg, 'epin/view_epin_request', true);
            } else {
                $this->epin_model->rollback();
                $this->redirect($msg, 'epin/view_epin_request', false);
            }
        } elseif ($this->input->post('delete_req')) {
            $pin_post_array = $this->input->post(null, true);
            $pin_post_array = $this->validation_model->stripTagsPostArray($pin_post_array);
            $total_count = $pin_post_array['total_count'];
            $flag = false;
            for ($i = 1; $i < $total_count; $i++) {
                if (isset($pin_post_array['active' . $i])) {
                    $delete_id = $pin_post_array['id' . $i];
                    $result = $this->epin_model->deleteRequestedEpin($delete_id, "remark $delete_id");
                    $flag = true;
                }
            }
            if (!$flag) {
                $msg = lang('please_select_checkbox');
                $this->redirect($msg, 'epin/view_epin_request', false);
            }
            if ($result) {
                $msg = lang('requested_epin_deleted_sucessfully');
                $this->redirect($msg, 'epin/view_epin_request', true);
            } else {
                $msg = lang('error_on_requested_epin_deletion');
                $this->redirect($msg, 'epin/view_epin_request', false);
            }
        } else {
            if ($this->input->post('delete_id') != '') {
                $delete_id = $this->input->post('delete_id', true);
                $remark = $this->input->post('remark' . $delete_id);
                $result = $this->epin_model->deleteRequestedEpin($delete_id, $remark);
                if ($result) {
                    $msg = lang('requested_epin_deleted_sucessfully');
                    $this->redirect($msg, 'epin/view_epin_request', true);
                } else {
                    $msg = lang('error_on_requested_epin_deletion');
                    $this->redirect($msg, 'epin/view_epin_request', false);
                }
            }
        }
        /*         * ***********pagination************ */

        $base_url = base_url() . 'admin/epin/view_epin_request';
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;

        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $config['uri_segment'] = 4;
        $config['num_links'] = 5;
        if ($this->uri->segment(4) != '') {
            $page = $this->uri->segment(4);
        } else
            $page = 0;
        $tot_rows = $this->epin_model->getAllPinRequestCount();
        $config['total_rows'] = $tot_rows;
        $this->pagination->initialize($config);
        /*         * ***********pagination************ */
        //set
        if (($this->MODULE_STATUS['pin_status'] == "yes") && ($this->epin_model->getAllPinRequestCount(2) > 0)) {
            $this->epin_model->setEpinViewed(1); //status 1 for admin read
            $this->set_header_notification_box();
        }
        $pin_detail_arr = $this->epin_model->viewEPinRequest($pro_status, $config['per_page'], $page);
        $result_per_page = $this->pagination->create_links();
        $this->set('result_per_page', $result_per_page);
        $this->set('page_id', $page);

        $this->set('pin_detail_arr', $pin_detail_arr);
        $this->set('pro_status', $pro_status);
        $this->setView();
    }

    function allocate_pin_user()
    {
        $title = lang('epin_allocation');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'allocate-pin-to-user';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('epin_allocation');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('epin_allocation');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $amount_details = $this->epin_model->getAllEwalletAmounts();
        if ($this->input->post('insert') && $this->validate_allocate_pin_user()) {
            $post_arr = $this->input->post(null, true);
            $date = $post_arr['date'];
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            if ($date < date("Y-m-d")) {
                $msg = lang('exp_date_not_be_less_than_curnt_date');
                $this->redirect($msg, 'epin/allocate_pin_user', false);
            }
            $user = strip_tags($this->validation_model->userNameToID($post_arr['user_name']));
            $res = $this->epin_model->generateEpin($post_arr['user_name'], $post_arr['amount1'], $post_arr['count'], $post_arr['date']);
            if ($res) {
                $login_id = $this->LOG_USER_ID;
                $user_type = $this->LOG_USER_TYPE;
                if ($user_type == 'employee') {
                    $login_id = $this->validation_model->getAdminId();
                }
                $data = serialize($post_arr);
                $this->validation_model->insertUserActivity($login_id, 'epin allocated', $user, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $user, 'allocate_epin', 'EPIN Allocated');
                }
                //

                $msg = lang('epin_allocated_successfully');
                $this->redirect($msg, 'epin/allocate_pin_user', true);
            } else {
                $msg = lang('error_on_epin_allocation');
                $this->redirect($msg, 'epin/allocate_pin_user', false);
            }
        }
        $this->set('amount_details', $amount_details);
        $this->setView();
    }

    function valid_user($user_name)
    {
        $user_id = $this->validation_model->userNameToID($user_name);
        if (!$user_id) {
            $this->form_validation->set_message('valid_user', lang('invalid_username'));
            return false;
        }
        return true;
    }

    function validate_allocate_pin_user()
    {
        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|callback_valid_user');
        $this->form_validation->set_rules('amount1', lang('amount'), 'trim|required|greater_than[0]');
        $this->form_validation->set_rules('count', lang('count'), 'trim|required|integer|greater_than[0]');
        $this->form_validation->set_rules('date', lang('date'), 'trim|required');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function view_pin_user($page_id = '')
    {

        $title = lang('user_wise_epin');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'view-user-pin';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('user_wise_epin');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('user_wise_epin');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $mlm_plan = $this->MLM_PLAN;
        $flag = false;
        $base_url = base_url() . 'admin/epin/view_pin_user';
        $config = $this->pagination->customize_style();
        $product_status = $this->MODULE_STATUS['product_status'];
        $path_root = base_url() . 'admin/';

        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        if ($this->uri->segment(4) != '') {
            $page = $this->uri->segment(4);
            $flag = true;
        } else {
            $page = 0;
        }
        $is_valid_username = '';
        if ($this->input->post('user_name')) {
            $user_name = ($this->input->post('user_name', true));
            $is_valid_username = $this->validation_model->isUserNameAvailable($user_name);
            if (!$is_valid_username) {
                $this->session->unset_userdata("is_valid_username");
                $msg = lang('Username_not_Exists');
                $this->redirect($msg, 'epin/view_pin_user', false);
            }

            if ($this->validate_view_pin_user()) {
                $this->session->set_userdata("is_valid_username", $user_name);
            } else {
                $this->session->unset_userdata("is_valid_username");
            }
        }
        $user_name = $this->session->userdata("is_valid_username");
        $total_rows = $this->epin_model->getPinDetailsForUser11Count($user_name);
        $pin_arr = $this->epin_model->getPinDetailsForUser11($user_name, $config['per_page'], $page);
        $flag = true;
        $config['total_rows'] = $total_rows;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();
        $is_valid_username = $user_name;

        $this->set('mlm_plan', $mlm_plan);
        $this->set('root', $path_root);
        $this->set('product_status', $product_status);
        $this->set('view', $this->input->post('view'));
        $this->set('is_valid_username', $is_valid_username);
        $this->set('username', $user_name);
        $this->set('pin_arr', $pin_arr);
        $this->set('result_per_page', $result_per_page);
        $this->set('flag', $flag);
        $this->set('user_name', $user_name);
        $this->set('page_id', $page_id);
        $this->set('count', $total_rows);

        $this->setView();
    }

    function validate_view_pin_user()
    {
        if (!$this->input->post('user_name')) {
            $msg = lang('you_must_enter_user_name');
            $this->redirect($msg, 'epin/view_pin_user', false);
        } else {
            $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|strip_tags');
            $validate_form = $this->form_validation->run();
            return $validate_form;
        }
    }

    function delete($delete_id = '')
    {

        $result = $this->epin_model->deleteEPin($delete_id);
        if ($result) {
            $data_array['delete_id'] = $delete_id;
            $data = serialize($data_array);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'epin deleted', $this->LOG_USER_ID, $data);
            if ($this->LOG_USER_TYPE == 'employee') {
                $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'epin deleted', 'EPIN Deleted');
            }
            $msg = lang('epin_deleted_successfully');
            $this->redirect($msg, 'profile/view_pin_user', true);
        } else {
            $msg = lang('error_on_deleting_epin');
            $this->redirect($msg, 'profile/view_pin_user', false);
        }
    }

    function validate_generate_epin()
    {

        if ($this->input->post('addpasscode')) {
            $tab1 = 'active';
            $tab2 = '';
            $this->session->set_userdata('inf_epin_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2));
            $this->form_validation->set_rules('amount1', lang('amount'), 'trim|required|greater_than[0]');
            $this->form_validation->set_rules('count', lang('count'), 'trim|required|integer|greater_than[0]');
            $this->form_validation->set_rules('date', lang('date'), 'required');
            $val = $this->form_validation->run();
            if ($val) {
                $exp = $this->input->post('date', true);
                if ($exp < date("Y-m-d")) {
                    $msg1 = lang('old_date');
                    $this->redirect($msg1, 'epin/add_new_epin', false);
                }
                $cnt = $this->input->post('count', true);
                $max_pincount = $this->epin_model->getMaxPinCount();
                $rec = $this->epin_model->getAllActivePinspage();
                if ($rec < $max_pincount) {
                    $errorcount = $max_pincount - $rec;
                    if ($cnt <= $errorcount) {
                        return true;
                    } else {
                        $msg1 = lang('you_are_permitted_to_add');
                        $msg2 = lang('epin_only');
                        $this->redirect($msg1 . ' ' . $errorcount . ' ' . $msg2, 'epin/add_new_epin', false);
                    }
                } else {
                    $msg1 = lang('already');
                    $msg2 = lang('epin_present');
                    $this->redirect($msg1 . ' ' . $rec . ' ' . $msg2, 'epin/add_new_epin', false);
                }
            } else {
                $error = $this->form_validation->error_array();
                if (isset($error['amount1'])) {
                    $this->redirect($error['amount1'], 'epin/add_new_epin', false);
                } elseif (isset($error['count'])) {
                    $this->redirect($error['count'], 'epin/add_new_epin', false);
                } elseif (isset($error['date'])) {
                    $this->redirect($error['date'], 'epin/add_new_epin', false);
                }
            }
        }
    }

    function validate_search_epin()
    {
        if ($this->input->post('search_pin')) {
            $this->form_validation->set_rules('keyword', lang('epin'), 'trim|required');
            $val = $this->form_validation->run();
            if ($val) {
                return true;
            } else {
                $this->session->unset_userdata('epin_search_type');
                $error = $this->form_validation->error_array();
                if (isset($error['keyword'])) {
                    $this->redirect($error['keyword'], 'epin/search_epin');
                }
            }
        }
    }

    function validate_search_pin_amount()
    {
        if ($this->input->post('search_pin_pro')) {
            $this->form_validation->set_rules('amount', lang('amount'), 'trim|required');
            $val = $this->form_validation->run();
            if ($val) {
                return true;
            } else {
                $this->session->unset_userdata('epin_search_type');
                $error = $this->form_validation->error_array();
                if (isset($error['amount'])) {
                    $this->redirect($error['amount'], 'epin/search_epin');
                }
            }
        }
    }

    function active_epin($action = '', $delete_id = '')
    {

        if ($action == 'block') {
            $result = $this->epin_model->updateEPin($delete_id, 'no');
            if ($result) {
                $data_array['delete_id'] = $delete_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'epin deactivated', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'deactivate_epin', 'EPIN Deactivated');
                }
                //

                $msg = lang('epin_deactivated_successfully');
                $this->redirect($msg, 'epin/epin_management', true);
            } else {
                $msg = lang('error_on_updating_epin');
                $this->redirect($msg, 'epin/epin_management', false);
            }
        }
    }

    function delete_epin($action = '', $delete_id = '')
    {

        if ($action == 'delete') {
            $result = $this->epin_model->deleteEPin($delete_id);
            if ($result) {
                $data_array['delete_id'] = $delete_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'epin deleted', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'delete_epin', 'EPIN Deleted');
                }
                //

                $msg = lang('epin_deleted_successfully');
                $this->redirect($msg, 'epin/epin_management', true);
            } else {
                $msg = lang('error_on_deleting_epin');
                $this->redirect($msg, 'epin/epin_management', false);
            }
        }
    }

    function inactive_epin($action = '', $delete_id = '')
    {

        if ($action == 'activate') {
            $result = $this->epin_model->updateEPin($delete_id, 'yes');
            if ($result) {
                $data_array['delete_id'] = $delete_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'epin activated', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'activate_epin', 'EPIN Activated');
                }
                //

                $msg = lang('epin_activated_successfully');
                $this->redirect($msg, 'epin/epin_management', true);
            } else {
                $msg = lang('error_on_updating_epin');
                $this->redirect($msg, 'epin/epin_management', false);
            }
        }
    }

    function delete_all_epin($action = '', $pin_status = 'active', $page = '')
    {
        if ($action == 'delete') {
            $limit = $this->PAGINATION_PER_PAGE;
            if ($page == '') {
                $page = 0;
            }
            $result = $this->epin_model->deleteAllEPin($pin_status, $page, $limit);
            if ($result) {
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'All EPIN Deleted', $this->LOG_USER_ID, $data = '');
                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'delete_all_epin', 'All EPIN Deleted');
                }
                //

                $msg = lang('epin_deleted_successfully');
                $this->redirect($msg, 'epin/epin_management', true);
            } else {
                $msg = lang('error_on_deleting_epin');
                $this->redirect($msg, 'epin/epin_management', false);
            }
        }
    }

    public function add_new_epin()
    {
        $title = lang('add_new_epin');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'e-pin-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('add_new_epin');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('add_new_epin');
        $this->HEADER_LANG['page_small_header'] = '';

        $link_id = $this->inf_model->getURLID('epin/epin_management');
        if ($link_id) {
            $url_perm = $this->inf_model->checkUrlPermitted($link_id, 'perm_admin');
            if (!$url_perm) {
                $msg = lang('permission_denied');
                $this->redirect($msg, 'home/index', false);
            }
        }

        if ($this->input->post('addpasscode') && $this->validate_generate_epin()) {
            $add_post_array = $this->input->post(null, true);
            $add_post_array = $this->validation_model->stripTagsPostArray($add_post_array);

            $uploded_date = date('Y-m-d H:i:s');
            $pin_alloc_date = date('Y-m-d H:i:s');
            $status = 'yes';
            $cnt = $add_post_array['count'];
            $pin_amount = $add_post_array['amount1'];
            $expiry_date = $add_post_array['date'];
            $res = $this->epin_model->generatePasscode($cnt, $status, $uploded_date, $pin_amount, $expiry_date, $pin_alloc_date);
            if ($res) {
                $login_id = $this->LOG_USER_ID;
                $user_type = $this->LOG_USER_TYPE;
                if ($user_type == 'employee') {
                    $login_id = $this->validation_model->getAdminId();
                }
                $data = serialize($add_post_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'epin added', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'add_epin', 'EPIN Added');
                }
                //

                $msg = lang('epin_added_successfully');
                $this->redirect($msg, 'epin/epin_management', true);
            } else {
                $msg = lang('error_on_adding_epin');
                $this->redirect($msg, 'epin/epin_management', false);
            }
        }
        $amount_details = $this->epin_model->getAllEwalletAmounts();
        $total_pin = $this->epin_model->getUnallocatedPinCount();
        $this->load_langauge_scripts();
        $this->set('un_allocated_pin', $total_pin);
        $this->set('amount_details', $amount_details);
        $this->setView();
    }

    function epin_transfer()
    {
        $title = lang('epin_transfer');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'allocate-pin-to-user';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('epin_transfer');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('epin_transfer');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if ($this->input->post('allocate') && $this->validate_epin_transfer()) {
            $post_arr = $this->input->post(null, true);
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $user = strip_tags($this->validation_model->userNameToID($post_arr['user_name']));
            $from_user = strip_tags($this->validation_model->userNameToID($post_arr['from_user_name']));
            $res = $this->epin_model->epinAllocation($user, $post_arr['epin']);
            if ($res) {
                $login_id = $this->LOG_USER_ID;
                $user_type = $this->LOG_USER_TYPE;
                if ($user_type == 'employee') {
                    $login_id = $this->validation_model->getAdminId();
                }
                $data = serialize($post_arr);
                $this->validation_model->insertUserActivity($user, 'Epin transferred to ' . $post_arr['user_name'], $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'transfer_epin', 'EPIN transferred to ' . $post_arr['user_name']);
                }
                //
                // Epin Transfer History
                $this->epin_model->insertEpinTransferHistory($login_id, 'Epin transferred', $user, $from_user, $post_arr['epin'], $data);
                $msg = lang('epin_transferred_successfully');
                $this->redirect($msg, 'epin/epin_transfer', true);
            } else {
                $msg = lang('error_please_try_again');
                $this->redirect($msg, 'epin/epin_transfer', false);
            }
        }
        $this->setView();
    }

    function validate_epin_transfer()
    {
        $this->form_validation->set_rules('epin', lang('epin'), 'trim|required|callback_valid_epin');
        $this->form_validation->set_rules('from_user_name', lang('from_user_name'), 'trim|required|callback_valid_user');
        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|callback_valid_user|callback_check_match[' . $this->input->post('from_user_name') . ']');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function check_match($to_user_name, $from_user_name)
    {
        if ($from_user_name == $to_user_name) {
            $this->form_validation->set_message('check_match', lang('can_not_transfer_to_same_user'));
            return false;
        }
        return true;
    }

    function valid_epin($epin)
    {
        if ($epin == 'default') {
            $this->form_validation->set_message('valid_epin', lang('select_epin'));
            return false;
        }
        return true;
    }

    public function epin_dynamic_list($username = '')
    {
        $result_html = "<option value='default'>" . lang('select_epin') . "</option>";
        if ($this->valid_user($username)) {
            $result_arr = $this->epin_model->getEpinList($this->validation_model->userNameToID($username));
            foreach ($result_arr as $result) {
                $result_html .= '<option value=' . $result["pin_id"] . '>' . $result["pin_numbers"];
            }
        }
        echo json_encode($result_html);
    }

    public function allocate_user($pin_id = "")
    {

        $title = lang('epin_allocation');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'allocate-pin-to-user';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('epin_allocation');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('epin_allocation');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $epin = $this->epin_model->EpinIdtoName($pin_id);

        if ($this->input->post() && $this->validate_allocate_user()) {
            $post_arr = $this->input->post(null, true);
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $user_name = $this->input->post('user_name', true);
            $user_id = $this->validation_model->userNameToID($user_name);
            $result = $this->epin_model->allocateEPinToUser($pin_id, $user_id);
            if ($result) {
                $data = serialize($post_arr);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Epin allocated to ' . $user_name, $this->LOG_USER_ID, $data);
                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'allocate_epin', 'EPIN Allocated');
                }
                //
                $msg = lang('epin_allocated_successfully');
                $this->redirect($msg, 'epin/epin_management', true);
            } else {
                $msg = lang('error_on_epin_allocation');
                $this->redirect($msg, 'epin/epin_management', false);
            }
        }

        $this->set('epin', $epin);
        $this->setView();
    }

    function validate_allocate_user()
    {
        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|callback_valid_user');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function refund_epin($action = '', $delete_id = '')
    {
        $result = '';
        if ($action == 'refund') {
            if ($this->session->userdata('epin_search_type')) {
                $this->session->unset_userdata('epin_search_type');
            }
            $is_active_pin = $this->epin_model->isActivePin($delete_id);
            if ($is_active_pin > 0) {
                $result = $this->epin_model->deleteEPin($delete_id, $action);
            }
            if ($result) {
                $data_array['refund_id'] = $delete_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'epin refunded', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'refund_epin', 'EPIN Refunded');
                }
                //
                $msg = lang('epin_refunded_successfully');
                $this->redirect($msg, 'epin/search_epin', true);
            } else {
                $msg = lang('error_on_refunding_epin');
                $this->redirect($msg, 'epin/search_epin', false);
            }
        }
    }

    public function ajax_epin_autolist()
    {
        if ($this->input->is_ajax_request()) {
            $keyword = $this->input->post('keyword', true);
            $data = $this->epin_model->getEPinsByKeyword($keyword);
            echo json_encode($data);
            exit();
        }
    }

}
