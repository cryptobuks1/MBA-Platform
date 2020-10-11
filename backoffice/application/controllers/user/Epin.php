<?php

require_once 'Inf_Controller.php';

class Epin extends Inf_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->url_permission('pin_status');
    }

    function request_epin()
    {

        $title = lang('request_e_pin');
        $this->set("title", $this->COMPANY_NAME . " | $title ");

        $help_link = "request-pin";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('request_e_pin');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('request_e_pin');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $pro_status = $this->MODULE_STATUS['product_status'];
        $amount_details = $this->epin_model->getAllEwalletAmounts();
        $this->set("amount_details", $amount_details);

        $success = lang('pin_request_send_successfully');
        $error = lang('error_on_pin_request');

        if ($this->input->post('reqpasscode') && $this->validate_request_epin()) {
            $request_date = date('Y-m-d H:i:s');
            $post_arr = $this->input->post(NULL, TRUE);
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $cnt = $post_arr['count'];
            $pin_amount = $post_arr['amount1'];
            $expiry_date = date('Y-m-d', strtotime('+6 months'));  //pin valid for 6 months
            $req_user = $this->LOG_USER_ID;
            $res = $this->epin_model->insertPinRequest($req_user, $cnt, $request_date, $expiry_date, $pin_amount);
            if ($res) {
                $loggin_id = $this->LOG_USER_ID;
                $admin_id = $this->ADMIN_USER_ID;
                $this->validation_model->insertUserActivity($loggin_id, 'epin requested', $admin_id);
                $this->redirect($success, "epin/request_epin", TRUE);
            } else {
                $this->redirect($error, "epin/request_epin", FALSE);
            }
        }
        if ($pro_status == "yes") {
            $produc_details = $this->epin_model->getAllProducts('yes');
            $this->set("produc_details", $produc_details);
        }
        $this->set("pro_status", $pro_status);

        $this->setView();
    }

    function validate_request_epin()
    {
        $this->form_validation->set_rules('amount1', lang('amount'), 'trim|required|greater_than[0]');
        $this->form_validation->set_rules('count', lang('count'), 'trim|required|integer|greater_than[0]|max_length[5]');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    public function my_epin($page = "", $limit = "")
    {

        $title = lang('my_e_pin');
        $this->set("title", $this->COMPANY_NAME . " | $title ");

        $help_link = "view-my-pin";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('my_e_pin');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('my_e_pin');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $pro_status = $this->MODULE_STATUS['product_status'];
        $pin_count = $this->epin_model->getUserFreePinCount();
        $config = $this->pagination->customize_style();
        $config['total_rows'] = $pin_count;
        $base_url = base_url() . "user/my_epin";
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $config['uri_segment'] = 3;
        $config['num_links'] = 5;
        $page = 0;
        if ($this->uri->segment(3) != "") {
            $page = $this->uri->segment(3);
        }

        $pin_details = $this->epin_model->pinSelector($page, $config['per_page'], "generate");
        if (($this->MODULE_STATUS['pin_status'] == "yes") && ($this->epin_model->getUserPinRequestCount($this->LOG_USER_ID, 'no', 1) > 0)) {
            $this->epin_model->setEpinViewed(0); //status 1 for admin read
            $this->set_header_notification_box();
        }
        $this->set('start_id', $page);
        $this->pagination->initialize($config);
        $page_footer = $this->pagination->create_links();
        $pin_numbers = $pin_details["pin_numbers"];

        $this->set("pin_numbers", $pin_numbers);
        $this->set("page_footer", $page_footer);
        $this->set("pro_status", $pro_status);
        $this->load_langauge_scripts();
        $this->setView();
    }

    function epin_transfer()
    {
        $title = lang('epin_transfer');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'allocate-pin-to-user';
        $this->set('help_link', $help_link);
        $login_id = $this->LOG_USER_ID;

        $this->HEADER_LANG['page_top_header'] = lang('epin_transfer');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('epin_transfer');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $pin_details = $this->epin_model->getEpinList($login_id);
        if ($this->input->post('transfer') && $this->validate_epin_transfer()) {
            $post_arr = $this->input->post(NULL, TRUE);
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $user = strip_tags($this->validation_model->userNameToID($post_arr['user_name']));

            $verified_epin = $this->epin_model->CheckEpinBelongsTouser($login_id, $post_arr['epin']);
            if ($verified_epin) {
                $res = $this->epin_model->epinAllocation($user, $post_arr['epin']);
            } else {
                $res = FALSE;
            }

            if ($res) {
                $user_type = $this->LOG_USER_TYPE;
                if ($user_type == 'employee') {
                    $login_id = $this->validation_model->getAdminId();
                }
                $data = serialize($post_arr);
                $this->validation_model->insertUserActivity($login_id, 'Epin transferred', $user, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $user, 'transfer_epin', 'EPIN transferred');
                }
                //
                // Epin Transfer History
                $this->epin_model->insertEpinTransferHistory($login_id, 'Epin transferred', $user, $login_id, $post_arr['epin'], $data);

                $msg = lang('epin_transferred_successfully');
                $this->redirect($msg, 'epin/epin_transfer', TRUE);
            } else {
                $msg = lang('error_on_epin_allocation');
                $this->redirect($msg, 'epin/epin_transfer', FALSE);
            }
        }

        $config = $this->pagination->customize_style();
        $base_url = base_url() . "user/epin/my_epin";
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $config['uri_segment'] = 4;
        $config['num_links'] = 5;
        $page = 0;
        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(4);
        }

        $pin_detailss = $this->epin_model->pinSelector($page, $config['per_page'], "defualt");
        $pin_count = $pin_detailss["numrows"];
        $config['total_rows'] = $pin_count;

        if (($this->MODULE_STATUS['pin_status'] == "yes") && ($this->epin_model->getUserPinRequestCount($this->LOG_USER_ID, 'no', 1) > 0)) {
            $this->epin_model->setEpinViewed(0); //status 1 for admin read
            $this->set_header_notification_box();
        }
        $this->set('start_id', $page);
        $this->pagination->initialize($config);
        $page_footer = $this->pagination->create_links();
        $pin_numbers = $pin_detailss["pin_numbers"];

        $this->set("pin_numbers", $pin_numbers);
        $this->set("page_footer", $page_footer);
        $this->set('epin_details', $pin_details);
        $this->setView();
    }

    function validate_epin_transfer()
    {
        $this->form_validation->set_rules('epin', lang('epin'), 'trim|required');
        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|callback_valid_user|callback_check_match');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function valid_user($user_name)
    {
        $user_id = $this->validation_model->userNameToID($user_name);
        if (!$user_id) {
            $this->form_validation->set_message('valid_user', lang('invalid_username'));
            return FALSE;
        }
        return TRUE;
    }

    function check_match($user_name)
    {
        if ($this->validation_model->userNameToID($user_name) == $this->LOG_USER_ID) {
            $this->form_validation->set_message('check_match', lang('can_not_transfer_to_same_user'));
            return FALSE;
        }
        if ($this->validation_model->userNameToID($user_name) == $this->validation_model->getAdminId()) {
            $this->form_validation->set_message('check_match', lang('can_not_transfer_to_admin'));
            return FALSE;
        }
        return TRUE;
    }

    function refund_epin($action = '', $delete_id = '')
    {
        $result = '';
        if ($action == 'refund') {
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

                $msg = lang('epin_refunded_successfully');
                $this->redirect($msg, 'epin/my_epin', TRUE);
            } else {
                $msg = lang('error_on_refunding_epin');
                $this->redirect($msg, 'epin/my_epin', FALSE);
            }
        }
    }
}
