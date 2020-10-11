<?php

require_once 'Inf_Controller.php';

class activity_history extends Inf_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('report_model', '', TRUE);
    }

    function activity_history_view() {
        $title = lang('activity_history');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'user-details';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('activity_history');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('activity_history');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $config = $this->pagination->customize_style();
        $base_url = base_url() . "admin/activity_history/activity_history_view";
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $from1 = $to1 = $from = $to = $user_name = $ipaddress = '';

        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(4);
        } else {
            $page = 0;
        }

        $activity_details = $this->activity_history_model->getActivityHistory($page, $config['per_page']);
        $total_rows = $this->activity_history_model->getActivityHistoryCount();

        // update session

        if (!$this->input->post() && !$page && !empty($this->session->userdata("set_session"))) {
            $this->session->unset_userdata('activity_history_user_name');
            $this->session->unset_userdata('activity_week_date1');
            $this->session->unset_userdata('activity_week_date2');
            $this->session->unset_userdata('activity_history_ipaddress');
            $this->session->unset_userdata('set_session');
        }
        //filtering
        if ($this->input->post('weekdate')) {
            $status = $this->validate_activity();

            $this->session->unset_userdata('activity_history_user_name');
            $this->session->unset_userdata('activity_week_date1');
            $this->session->unset_userdata('activity_week_date2');
            $this->session->unset_userdata('activity_history_ipaddress');
            $this->session->unset_userdata('set_session');
            if ($status == 1) {
                $from = (strip_tags($this->input->post('week_date1', TRUE)));
                $to = (strip_tags($this->input->post('week_date2', TRUE)));
                $user_name = (strip_tags($this->input->post('user_name', TRUE)));
                $ipaddress = (strip_tags($this->input->post('ip_address', TRUE)));
            } else {
                if ($status == 2) {
                    $msg = lang('Invalid_from_date');
                    $this->redirect($msg, "activity_history/activity_history_view", false);
                }
                if ($status == 3) {
                    $msg = lang('Invalid_to_date');
                    $this->redirect($msg, "activity_history/activity_history_view", false);
                }
                if ($status == 4) {
                    $msg = lang('Invalid_Username');
                    $this->redirect($msg, "activity_history/activity_history_view", false);
                }
                if ($status == 5) {
                    $msg = lang('Invalid_ip');
                    $this->redirect($msg, "activity_history/activity_history_view", false);
                }
                if ($status == 6) {
                    $msg = lang('to_date_grter');
                    $this->redirect($msg, "activity_history/activity_history_view", false);
                }
            }
            $this->session->set_userdata("activity_week_date1", $from);
            $this->session->set_userdata("activity_week_date2", $to);

            $this->session->set_userdata("activity_history_user_name", $user_name);
            $this->session->set_userdata("activity_history_ipaddress", $ipaddress);
            $this->session->set_userdata("set_session", 'set');
        }

        if (!empty($this->session->userdata("set_session"))) {
            $from1 = $this->session->userdata("activity_week_date1");
            $to1 = $this->session->userdata("activity_week_date2");

            if ($from1)
                $from1 = $from1 . " 00:00:00";
            if ($to1)
                $to1 = $to1 . " 23:59:59";
            $user_name = $this->session->userdata("activity_history_user_name");
            $ipaddress = $this->session->userdata("activity_history_ipaddress");

            $activity_details = $this->activity_history_model->getActivityHistory($page, $config['per_page'], $from1, $to1, $user_name, $ipaddress);
            $count = count($activity_details);
            $total_rows = $this->activity_history_model->getActivityHistoryCount($from1, $to1, $user_name, $ipaddress);
        }
        $config['total_rows'] = $total_rows;
        $this->set('details_count', $total_rows);
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();
        $this->set('result_per_page', $result_per_page);
        $this->set('page_id', $page);

        $this->set("from", $from);
        $this->set("to", $to);
        $this->set("user_name", $user_name);
        $this->set("ipaddress", $ipaddress);
        $this->set('activity_details', $this->security->xss_clean($activity_details));
        $this->setView();
    }

    function validate_activity() {
        if ($this->input->post('week_date1', TRUE)) {
            $this->form_validation->set_rules($this->input->post('week_date1', TRUE), lang('start_date'), 'trim|strip_tags');
            $validate_form = $this->form_validation->run();

            if (!$validate_form || !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $this->input->post('week_date1', TRUE))) {
                return 2;
            }
        }

        if ($this->input->post('week_date2', TRUE)) {
            $this->form_validation->set_rules($this->input->post('week_date2', TRUE), lang('end_date'), 'trim|strip_tags');
            $validate_form = $this->form_validation->run();

            if (!$validate_form || !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $this->input->post('week_date2', TRUE)))
                return 3;
        }

        if ($this->input->post('user_name', TRUE)) {
            $this->form_validation->set_rules($this->input->post('user_name', TRUE), lang('user_name'), 'trim|strip_tags');
            $validate_form = $this->form_validation->run();
            $user_id = $this->validation_model->userNameToID($this->input->post('user_name', TRUE));
            $is_valid_username = $this->validation_model->isUserAvailable($user_id);
            if (!$validate_form || !$is_valid_username)
                return 4;
        }
        if ($this->input->post('ip_address', TRUE)) {
            if (!filter_var($this->input->post('ip_address', TRUE), FILTER_VALIDATE_IP)) {
                return 5;
            }
        }
        if (($this->input->post('week_date1', TRUE) && $this->input->post('week_date2', TRUE)) && $this->input->post('week_date1', TRUE) > $this->input->post('week_date2', TRUE)) {
            return 6;
        }
        return 1;
    }

}
