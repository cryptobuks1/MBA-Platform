<?php

require_once 'Inf_Controller.php';

class Report extends Inf_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('select_report_model', '', TRUE);
        $this->load->model('activity_history_model');
        $this->load->model('profile_model');
    }

    function profile_report_view() {

        $title = lang('report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('profile_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('profile_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $date = date("Y-m-d");
        $this->set("date", $date);

        if (($this->input->post('profile_view')) && $this->validate_profile_report_view()) {
            $user_name = (strip_tags($this->input->post('user_name', TRUE)));
            $user_id = $this->report_model->userNameToID($user_name);
            if ($user_id) {
                $this->session->set_userdata("inf_profile_report_view_user_name", $user_name);
            } else {
                $msg = lang('Invalid_Username');
                $this->redirect($msg, "select_report/admin_profile_report", false);
            }
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/admin_profile_report');
        }

        if (!empty($this->session->userdata("inf_profile_report_view_user_name"))) {
            $user_name = $this->session->userdata("inf_profile_report_view_user_name");
            $profile_arr = $this->report_model->getProfileDetails($user_name);
            $this->set("details", $this->security->xss_clean($profile_arr['details']));
            $this->set("user_name", $user_name);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/admin_profile_report');
        }
        $help_link = "report";
        $this->set("help_link", $help_link);
        $this->set("report_date", '');
        $this->setView();
    }

    function validate_profile_report_view() {
        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function profile_report() {
        $title = lang('profile_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);
        $this->HEADER_LANG['page_top_header'] = lang('profile_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('profile_report');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();


        if ($this->input->post('profile') && $this->validate_profile_report_single_count()) {
            $count = (strip_tags($this->input->post('count', TRUE)));
            if ($count > 0) {
                $this->session->set_userdata('inf_profile_count', $count);
                $this->session->set_userdata("inf_profile_type", "one_count");
            } else {
                $msg = lang('invalid_entry');
                $this->redirect($msg, "select_report/admin_profile_report", FALSE);
            }
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_count_error', $error_array);
            redirect('admin/select_report/admin_profile_report');
        }
        if (!empty($this->session->userdata("inf_profile_count"))) {
            $profile_count = $this->session->userdata("inf_profile_count");
            $profile_arr = $this->report_model->profileReport($profile_count);
            $this->set("profile_arr", $this->security->xss_clean($profile_arr));
            $count = count($profile_arr);
            $this->set("count", $count);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/admin_profile_report');
        }
        $help_link = "profile_report";
        $this->set("report_date", '');
        $this->set("help_link", $help_link);
        $this->setView();
    }

    function validate_profile_report_single_count() {
        $this->form_validation->set_rules('count', lang('count'), 'trim|required|greater_than[0]|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function profile_report_multiple_count() {
        $title = lang('profile_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);
        $this->HEADER_LANG['page_top_header'] = lang('profile_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('profile_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if ($this->input->post('profile_from') && $this->validate_profile_report()) {
            $count_from = (strip_tags($this->input->post('count_from', TRUE)));
            $count_to = (strip_tags($this->input->post('count_to', TRUE)));
            if ($count_from > 0 && $count_to > 0) {
                $this->session->set_userdata("inf_profile_type", "two_count");
                $this->session->set_userdata('inf_count_from', $count_from);
                $this->session->set_userdata('inf_count_to', $count_to);
            } else {
                $msg = lang('invalid_entry');
                $this->redirect($msg, "select_report/admin_profile_report", FALSE);
            }
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_count_error', $error_array);
            redirect('admin/select_report/admin_profile_report');
        }
        if (!empty($this->session->userdata("inf_profile_type"))) {
            $count_from = $this->session->userdata("inf_count_from");
            $count_to = $this->session->userdata("inf_count_to");
            $profile_arr = $this->report_model->profileReportFromTo($count_to, $count_from);
            $this->set("profile_arr", $this->security->xss_clean($profile_arr));

            $count = count($profile_arr);
            $this->set("count", $count);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/admin_profile_report');
        }

        $help_link = "report";
        $this->set("report_date", '');
        $this->set("help_link", $help_link);
        $this->setView();
    }

    function validate_profile_report() {
        $this->form_validation->set_rules('count_from', lang('count_from'), 'trim|required|greater_than[0]|strip_tags');
        $this->form_validation->set_rules('count_to', lang('count_to'), 'trim|required|greater_than[0]|strip_tags');
        $validate_form = $this->form_validation->run();

        return $validate_form;
    }

    function total_joining_daily() {

        $title = lang('user_joining_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $report_date = '';
        $this->set("date", $date);

        $this->HEADER_LANG['page_top_header'] = lang('user_joining_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('user_joining_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $this->report_header();


        if ($this->input->post('dailydate') && $this->validate_total_joining_daily()) {
            $today = (strip_tags($this->input->post('date', TRUE)));
            $this->session->set_userdata("inf_total_joining_daily", $today);
            $report_date = $today;
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_total_joining_daily_error', $error_array);
            redirect('admin/select_report/total_joining_report');
        }
        if (!empty($this->session->userdata("inf_total_joining_daily"))) {
            $today = $this->session->userdata("inf_total_joining_daily");
            $report_date = $today;
            $todays_join = $this->report_model->getTodaysJoining($today);
            $count = count($todays_join);
            $this->set("count", $count);
            $this->set("todays_join", $todays_join);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/total_joining_report');
        }
        $help_link = "downlaod_document";
        $this->set("help_link", $help_link);
        $this->set("report_date", $report_date);
        $this->setView();
    }

    function validate_total_joining_daily() {
        $this->form_validation->set_rules('date', lang('date'), 'trim|required|strip_tags');

        $validate_form = $this->form_validation->run();

        return $validate_form;
    }

    function total_joining_weekly() {

        $title = lang('user_joining_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->HEADER_LANG['page_top_header'] = lang('user_joining_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('user_joining_report');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->report_header();

        $this->load_langauge_scripts();


        $date = date("Y-m-d");
        $report_date = '';
        $this->set("date", $date);
        if ($this->input->post('weekdate') && $this->validate_total_joining_weekly()) {
            if (!($this->input->post('week_date1')) && !($this->input->post('week_date2'))) {
                $msg = lang('You_must_select_a_date');
                $this->redirect($msg, 'select_report/total_joining_report', FALSE);
            }
            if (($this->input->post('week_date1') != '') && ($this->input->post('week_date2') != '')) {
                if (($this->input->post('week_date1')) > ($this->input->post('week_date2'))) {
                    $msg = lang('To-Date should be greater than From-Date');
                    $this->redirect($msg, 'select_report/total_joining_report', FALSE);
                }
            }
            $from = (strip_tags($this->input->post('week_date1', TRUE)));
            $to = (strip_tags($this->input->post('week_date2', TRUE)));
            $report_date = lang('from') . "\t" . $from . "\t" . lang('to') . "\t" . $to;
            if ($from)
                $from = $from . " 00:00:00";
            if ($to)
                $to = $to . " 23:59:59";

            $this->session->set_userdata("inf_week_date1", $from);
            $this->session->set_userdata("inf_week_date2", $to);
        } else {
            $error_array_weekely = $this->form_validation->error_array();
            $this->session->set_userdata('inf_total_joining_weekly_error', $error_array_weekely);
            redirect('admin/select_report/total_joining_report');
        }

        if (!empty($this->session->userdata("inf_week_date1")) || !empty($this->session->userdata("inf_week_date1"))) {
            $from = $this->session->userdata("inf_week_date1");
            $to = $this->session->userdata("inf_week_date2");
            $week_join = $this->report_model->getWeeklyJoining($from, $to);
            $count = count($week_join);
            $this->set("count", $count);
            $this->set("week_join", $week_join);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/total_joining_report');
        }
        $help_link = "downlaod_document";
        $this->set("help_link", $help_link);
        $this->set("report_date", $report_date);
        $this->setView();
    }

    function validate_total_joining_weekly() {
        $this->form_validation->set_rules('week_date1', lang('start_date'), 'trim|strip_tags');
        $this->form_validation->set_rules('week_date2', lang('end_date'), 'trim|strip_tags');

        $validate_form = $this->form_validation->run();

        return $validate_form;
    }

    function total_payout_report_view() {

        $title = lang('total_bonus_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('total_bonus_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('total_bonus_report');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

        $this->report_header();


        $date = date("Y-m-d");
        $this->set("date", $date);

        $total_payout = $this->report_model->getTotalPayout();
        $count = count($total_payout);
        $this->set("count", $count);
        $this->set("total_payout", $this->security->xss_clean($total_payout));

        $help_link = "report";
        $this->set("report_date", '');
        $this->set("help_link", $help_link);

        $this->setview();
    }

    function member_payout_report() {

        $title = lang('member_wise_bonus_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('member_wise_bonus_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('member_wise_bonus_report');
        $this->HEADER_LANG['page_small_header'] = '';


        $this->load_langauge_scripts();

        $this->report_header();

        $date = date("Y-m-d");
        $this->set("date", $date);
        $is_valid_username = false;

        if ($this->input->post('user_submit') && $this->validate_member_payout_report()) {
            $user_mob_name = ($this->input->post('user_name', TRUE));
            $this->session->set_userdata("is_valid_user_name", $user_mob_name);
            $user_id = $this->validation_model->userNameToID($user_mob_name);
            $is_valid_username = $this->validation_model->isUserAvailable($user_id);
            if (!$is_valid_username) {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'select_report/total_payout_report', FALSE);
            }
            $this->session->set_userdata("inf_user_name_payout", $user_mob_name);
        } else {
            $error_array_user = $this->form_validation->error_array();
            $this->session->set_userdata('inf_member_payout_report_error', $error_array_user);
            redirect('admin/select_report/total_payout_report');
        }
        if (!empty($this->session->userdata("inf_user_name_payout"))) {
            $user_mob_name = $this->session->userdata("inf_user_name_payout");
            $member_payout = $this->report_model->getMemberPayout($user_mob_name);
            $count = count($member_payout);
            $this->set("count", $count);
            $this->set("member_payout", $this->security->xss_clean($member_payout));
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/total_payout_report');
        }

        $help_link = "report";
        $this->set("report_date", '');
        $this->set("help_link", $help_link);
        $this->setView();
    }

    function validate_member_payout_report() {
        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function weekly_payout_report() {

        $title = lang('week_wise_bonus_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->HEADER_LANG['page_top_header'] = lang('week_wise_bonus_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('week_wise_bonus_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $this->report_header();

        $date = date("Y-m-d");
        $report_date = '';
        $this->set("date", $date);
        if ($this->input->post('weekdate') && $this->validate_weekly_payout_report()) {
            if (!($this->input->post('week_date1')) && !($this->input->post('week_date2'))) {
                $msg = lang('You_must_select_a_date');
                $this->redirect($msg, 'select_report/total_payout_report', FALSE);
            }
            if (($this->input->post('week_date1') != '') && ($this->input->post('week_date2') != '')) {
                if (($this->input->post('week_date1')) > ($this->input->post('week_date2'))) {
                    $msg = lang('To-Date should be greater than From-Date');
                    $this->redirect($msg, 'select_report/total_payout_report', FALSE);
                }
            }
            $from_date = (strip_tags($this->input->post('week_date1', TRUE)));
            $to_date = (strip_tags($this->input->post('week_date2', TRUE)));
            if ($from_date != '' && $to_date != '') {
                $report_date = lang('from') . "\t" . $from_date . "\t" . lang('to') . "\t" . $to_date;
            } else if ($from_date != '') {
                $report_date = lang('from') . "\t" . $from_date;
            } else if ($to_date != '') {
                $report_date = lang('to') . "\t" . $to_date;
            } else {
                $report_date = '';
            }
            if ($from_date)
                $from_date = $from_date . " 00:00:00";
            if ($to_date)
                $to_date = $to_date . " 23:59:59";
            $this->session->set_userdata("inf_week_date1", $from_date);
            $this->session->set_userdata("inf_week_date2", $to_date);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_weekly_payout_report_error', $error_array);
            redirect('admin/select_report/total_payout_report');
        }
        if (!empty($this->session->userdata("inf_week_date1")) || !empty($this->session->userdata("inf_week_date2"))) {
            $from_date = $this->session->userdata("inf_week_date1");
            $to_date = $this->session->userdata("inf_week_date2");
            $weekly_payout = $this->report_model->getTotalPayout($from_date, $to_date);
            $count = count($weekly_payout);
            $this->set("count", $count);
            $this->set("weekly_payout", $this->security->xss_clean($weekly_payout));
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/total_payout_report');
        }

        $help_link = "report";
        $this->set("report_date", $report_date);
        $this->set("help_link", $help_link);
        $this->setView();
    }

    function validate_weekly_payout_report() {
        $this->form_validation->set_rules('week_date1', lang('start_date'), 'trim|strip_tags');
        $this->form_validation->set_rules('week_date2', lang('end_date'), 'trim|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function payout_released_report_daily() {

        $title = lang('payout_release_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('payout_release_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('payout_release_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();


        $date = date("Y-m-d");
        $from_date = '';
        $this->set("date", $date);

        if (($this->input->post('payout_released')) && $this->validate_payout_released_report_daily()) {

            $from_date = (strip_tags($this->input->post('week_date1', TRUE)));
            $this->session->set_userdata("inf_released_report_daily", $from_date);
            $ewallt_req_details = $this->report_model->getDailyReleasedPayoutDetails($from_date);
            $count = count($ewallt_req_details);
            $this->set("binary_details", $ewallt_req_details);
            $this->set("count", $count);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_payout_released_report_daily_error', $error_array);
            redirect('admin/select_report/payout_release_report');
        }

        $help_link = "downlaod_document";
        $this->set("help_link", $help_link);
        $this->set('report_date', $from_date);
        $this->setView();
    }

    function validate_payout_released_report_daily() {
        $this->form_validation->set_rules('week_date1', lang('date'), 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function payout_released_report_weekly() {

        $title = lang('payout_release_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('payout_release_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('payout_release_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();


        $date = date("Y-m-d");
        $report_date = '';
        $this->set("date", $date);

        if (($this->input->post('payout_released')) && $this->validate_payout_released_report_weekly()) {
            if (!($this->input->post('from_date_weekly')) && !($this->input->post('to_date_weekly'))) {
                $msg = lang('You_must_select_a_date');
                $this->redirect($msg, 'select_report/payout_release_report', FALSE);
            }
            if (($this->input->post('from_date_weekly') != '') && ($this->input->post('to_date_weekly') != '')) {
                if (($this->input->post('from_date_weekly')) > ($this->input->post('to_date_weekly'))) {
                    $msg = lang('To-Date should be greater than From-Date');
                    $this->redirect($msg, 'select_report/payout_release_report', FALSE);
                }
            }

            $from_date = (strip_tags($this->input->post('from_date_weekly', TRUE)));
            $to_date = (strip_tags($this->input->post('to_date_weekly', TRUE)));
            $this->session->set_userdata("inf_released_report_from_date", $from_date);
            $this->session->set_userdata("inf_released_report_to_date", $to_date);
            $report_date = lang('from') . "\t" . $from_date . "\t" . lang('to') . "\t" . $to_date;
            $ewallt_req_details = $this->report_model->getReleasedPayoutDetails($from_date, $to_date);
            $count = count($ewallt_req_details);
            $this->set("binary_details", $ewallt_req_details);
            $this->set("count", $count);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_payout_released_report_daily_error', $error_array);
            redirect('admin/select_report/payout_release_report');
        }
        $this->set("report_date", $report_date);
        $this->setView();
    }

    function validate_payout_released_report_weekly() {
        $this->form_validation->set_rules('from_date_weekly', lang('date'), 'trim|strip_tags');
        $this->form_validation->set_rules('to_date_weekly', lang('date'), 'trim|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function payout_pending_report_weekly() {
        $title = lang('payout_pending_report');
        $this->set("title", $title);

        $date = date("Y-m-d");
        $report_date = '';
        $this->set("date", $date);

        $this->load_langauge_scripts();

        $this->report_header();

        if (($this->input->post('payout_released')) && $this->validate_payout_pending_report_weekly()) {

            if (!($this->input->post('from_date_pending')) && !($this->input->post('to_date_pending'))) {
                $msg = lang('You_must_select_a_date');
                $this->redirect($msg, 'select_report/payout_release_report', FALSE);
            }
            if (($this->input->post('from_date_pending') != '') && ($this->input->post('to_date_pending') != '')) {
                if (($this->input->post('from_date_pending')) > ($this->input->post('to_date_pending'))) {
                    $msg = lang('To-Date should be greater than From-Date');
                    $this->redirect($msg, 'select_report/payout_release_report', FALSE);
                }
            }
            $from_date = (strip_tags($this->input->post('from_date_pending', TRUE)));
            $to_date = (strip_tags($this->input->post('to_date_pending', TRUE)));
            $this->session->set_userdata("inf_pending_report_from_date", $from_date);
            $this->session->set_userdata("inf_pending_report_to_date", $to_date);
            if ($from_date != '' && $to_date != '') {
                $report_date = lang('from') . "\t" . $from_date . "\t" . lang('to') . "\t" . $to_date;
            } else if ($from_date != '') {
                $report_date = lang('from') . "\t" . $from_date;
            } else if ($to_date != '') {
                $report_date = lang('to') . "\t" . $to_date;
            } else {
                $report_date = '';
            }
            $ewallt_req_details = $this->report_model->getPayoutPendingDetails($from_date, $to_date);
            $count = count($ewallt_req_details);
            $this->set("binary_details", $ewallt_req_details);
            $this->set("count", $count);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_payout_released_report_daily_error', $error_array);
            redirect('admin/select_report/payout_release_report');
        }
        $this->set("report_name", lang('payout_pending_report'));
        $this->set("report_date", $report_date);
        $this->setview();
    }

    function validate_payout_pending_report_weekly() {

        $this->form_validation->set_rules('from_date_pending', lang('date'), 'trim|strip_tags');
        $this->form_validation->set_rules('to_date_pending', lang('date'), 'trim|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function sales_report_view() {

        $title = lang('report');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->url_permission('product_status');

        $this->HEADER_LANG['page_top_header'] = lang('sales_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('sales_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $this->set("date_submission", lang('date_submission'));

        $report_name = lang('sales_report');
        $this->set('report_name', "$report_name");


        $date = date("Y-m-d");
        $report_date = '';
        $product_type = '';
        $this->set("date", $date);

        if (($this->input->post('weekdate')) && $this->validate_sales_report_view()) {
//            if (($this->input->post('week_date1') == '') && ($this->input->post('week_date2') == '')){
//              $msg = lang('You_must_select_a_date');
//              $this->redirect($msg, 'select_report/sales_report', FALSE);
//            }
            if (($this->input->post('week_date1') != '') && ($this->input->post('week_date2') != '')) {
                if (($this->input->post('week_date1')) > ($this->input->post('week_date2'))) {
                    $msg = lang('To-Date should be greater than From-Date');
                    $this->redirect($msg, 'select_report/sales_report', FALSE);
                }
            }
            $from_date = (strip_tags($this->input->post('week_date1', TRUE)));
            $to_date = (strip_tags($this->input->post('week_date2', TRUE)));
            if ($from_date != '' && $to_date != '') {
                $report_date = lang('from') . "\t" . $from_date . "\t" . lang('to') . "\t" . $to_date;
            } else if ($from_date != '') {
                $report_date = lang('from') . "\t" . $from_date;
            } else if ($to_date != '') {
                $report_date = lang('to') . "\t" . $to_date;
            } else {
                $report_date = '';
            }

            $this->session->set_userdata("inf_week_date1", $from_date);
            $this->session->set_userdata("inf_week_date2", $to_date);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_sales_report_view_error', $error_array);
            redirect('admin/select_report/sales_report');
        }
        if (!empty($this->session->userdata("inf_week_date1")) || !empty($this->session->userdata("inf_week_date1"))) {

            if ($from_date != '') {
                $from_date = $from_date . " 00:00:00";
            } else {
                $from_date = '';
            }
            if ($to_date != '') {
                $to_date = $to_date . " 23:59:59";
            } else {
                $to_date = '';
            }
            $from_date = $this->session->userdata("inf_week_date1");
            $to_date = $this->session->userdata("inf_week_date2");
            if ($this->input->post('product_id') == "repurchase") {
                $report_arr = $this->report_model->productRepurchaseSalesReport("all", $from_date, $to_date);
            } else {
                $report_arr = $this->report_model->salesReport($from_date, $to_date);
            }
            $product_type = $this->input->post('product_id', TRUE);
            $count = count($report_arr);
            $this->set('report_arr', $this->security->xss_clean($report_arr));
            $this->set('count', $count);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/sales_report');
        }
        $help_link = "report";
        $this->set("product_type", $product_type);
        $this->set("help_link", $help_link);
        $this->set("report_date", $report_date);
        $this->setView();
    }

    function validate_sales_report_view() {

        $this->form_validation->set_rules('week_date1', lang('date'), 'trim|strip_tags');
        $this->form_validation->set_rules('week_date2', lang('date'), 'trim|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function product_sales_report() {

        $title = lang('report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('sales_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('sales_report');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();


        $this->set("date_submission", lang('date_submission'));
        $this->set("payment_method", lang('Payment_method'));
        $report_name = lang('sales_report');
        $this->set('report_name', "$report_name");


        $date = date("Y-m-d");
        $this->set("date", $date);
        $product_type = "register";

        if (($this->input->post('user_submit')) && $this->validate_product_sales_report()) {
            $prod_id = (strip_tags($this->input->post('product_id', TRUE)));
            $this->session->set_userdata("inf_product_sales_id", $prod_id);
        } elseif (($this->input->post('user_submit_repurchase')) && $this->validate_product_sales_report()) {
            $prod_id = (strip_tags($this->input->post('product_id', TRUE)));
            $this->session->set_userdata("inf_product_sales_id", $prod_id);
            $product_type = "repurchase";
        } else {
            $error_array_sales = $this->form_validation->error_array();
            $this->session->set_userdata('inf_product_sales_report_error', $error_array_sales);
            redirect('admin/select_report/sales_report');
        }
        ///////////////////////////////////
        if (!empty($this->session->userdata("inf_product_sales_id"))) {
            $prod_id = $this->session->userdata("inf_product_sales_id");
            if ($product_type == "repurchase")
                $sales_report_arr = $this->report_model->productRepurchaseSalesReport($prod_id);
            else
                $sales_report_arr = $this->report_model->productSalesReport($prod_id);
            $count = count($sales_report_arr);
            $this->set('sales_report_arr', $this->security->xss_clean($sales_report_arr));
            $this->set('count', $count);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/sales_report');
        }
        $help_link = "report";
        $this->set("report_date", '');
        $this->set("product_type", $product_type);
        $this->set("help_link", $help_link);
        $this->setView();
    }

    function validate_product_sales_report() {

        $this->form_validation->set_rules("product_id", lang('product'), 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function report_header() {

        $this->set("tran_Welcome_to", $this->lang->line('Welcome_to'));
        $this->set("tran_O", $this->lang->line('O'));
        $this->set("tran_I", $this->lang->line('I'));
        $this->set("tran_Floor", $this->lang->line('Floor'));
        $this->set("tran_em", $this->lang->line('em'));
        $this->set("tran_addr", $this->lang->line('addr'));
        $this->set("tran_comp", $this->lang->line('comp'));
        $this->set("tran_ph", $this->lang->line('ph'));
        $this->set("tran_nfinite", $this->lang->line('nfinite'));
        $this->set("tran_pen", $this->lang->line('pen'));
        $this->set("tran_ource", $this->lang->line('ource'));
        $this->set("tran_olutions", $this->lang->line('olutions'));
        $this->set("tran_S", $this->lang->line('S'));
        $this->set("tran_Date", $this->lang->line('Date'));
        $this->set("tran_email", $this->lang->line('email'));
        $this->set("tran_address", $this->lang->line('address'));
        $this->set("tran_phone", $this->lang->line('phone'));
        $this->set("tran_click_here_print", $this->lang->line('click_here_print'));
    }

    function rank_achievers_report_view() {

        $title = lang('report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('rank_achieve_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('rank_achieve_report');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();


        $report_name = $this->lang->line('rank_achieve_report');
        $this->set('report_name', "$report_name");

        $date = date("Y-m-d");
        $report_date = '';
        $this->set("date", $date);
        $rank = array();
        if ($this->input->post('weekdate') && $this->validate_rank_achievers_report_view()) {
            if (!($this->input->post('week_date1')) && !($this->input->post('week_date2')) && !($this->input->post('ranks'))) {
                $msg = lang('Please select atleast one criteria.');
                $this->redirect($msg, 'select_report/rank_achievers_report', FALSE);
            }
            if (($this->input->post('week_date1') != '') && ($this->input->post('week_date2') != '')) {
                if (($this->input->post('week_date1')) > ($this->input->post('week_date2'))) {
                    $msg = lang('To-Date should be greater than From-Date');
                    $this->redirect($msg, 'select_report/rank_achievers_report', FALSE);
                }
            }
            $from_date = (strip_tags($this->input->post('week_date1', TRUE)));
            $to_date = (strip_tags($this->input->post('week_date2', TRUE)));
            if ($from_date != '' && $to_date != '') {
                $report_date = lang('from') . "\t" . $from_date . "\t" . lang('to') . "\t" . $to_date;
            } else if ($from_date != '') {
                $report_date = lang('from') . "\t" . $from_date;
            } else if ($to_date != '') {
                $report_date = lang('to') . "\t" . $to_date;
            } else {
                $report_date = '';
            }
            $ranks = $this->input->post('ranks', TRUE);
            if ($from_date != '') {
                $from_date = $from_date . " 00:00:00";
            } else {
                $from_date = '';
            }
            if ($to_date != '') {
                $to_date = $to_date . " 23:59:59";
            } else {
                $to_date = '';
            }
            $this->session->set_userdata("inf_rank_week_date1", $from_date);
            $this->session->set_userdata("inf_rank_week_date2", $to_date);
            $this->session->set_userdata("inf_ranks", $ranks);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_rank_achievers_report_error', $error_array);
            redirect('admin/select_report/rank_achievers_report');
        }
        if (!empty($this->session->userdata("inf_rank_week_date1")) || !empty($this->session->userdata("inf_rank_week_date2"))) {
            $from_date = $this->session->userdata("inf_rank_week_date1");
            $to_date = $this->session->userdata("inf_rank_week_date2");
            $ranks = $this->session->userdata("inf_ranks");
            $ranked_user_details = array();
            $ranked_user_details = $this->report_model->rankedUsers($ranks, $from_date, $to_date);
            $count = count($ranked_user_details);
            $this->set('report_arr', $ranked_user_details);
            $this->set('count', $count);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/rank_achievers_report');
        }
        $help_link = "report";
        $this->set("report_date", $report_date);
        $this->set("help_link", $help_link);
        $this->setView();
    }

    function validate_rank_achievers_report_view() {

        $this->form_validation->set_rules('week_date1', lang('start_date'), 'trim|strip_tags');
        $this->form_validation->set_rules('week_date2', lang('end_date'), 'trim|strip_tags');
        $this->form_validation->set_rules('ranks[]', lang('rank'), 'trim|strip_tags');
        $validate_form = $this->form_validation->run();

        return $validate_form;
    }

    function commission_report_view() {


        $title = lang('commission_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->HEADER_LANG['page_top_header'] = lang('commission_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('commission_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $type = "";
        $date = date("Y-m-d");
        $report_date = '';
        $this->set("date", $date);
        $date1 = date('Y-m-d:H:i:s');
        $user_id = "";
        $user_name = "";
        if ($this->input->post('commision') && $this->validate_commission_report_view()) {
//            if (!($this->input->post('from_date')) && !($this->input->post('to_date'))){
//              $msg = lang('You_must_select_a_date');
//              $this->redirect($msg, 'select_report/commission_report', FALSE);
//            }
            if ($this->input->post('amount_type') == '' && $this->input->post('user_name') == '' && $this->input->post('from_date') == '' && $this->input->post('to_date') == '') {
                $msg = lang('Please Select Atleast One Criteria.');
                $this->redirect($msg, 'select_report/commission_report', FALSE);
            }
            if (($this->input->post('from_date') != '') && ($this->input->post('to_date') != '')) {
                if (($this->input->post('from_date')) > ($this->input->post('to_date'))) {
                    $msg = lang('To-Date should be greater than From-Date');
                    $this->redirect($msg, 'select_report/commission_report', FALSE);
                }
            }
            if ($this->input->post("amount_type") != '') {
                $type = $this->input->post("amount_type", TRUE);
                $i = 0;
                foreach ($type as $t) {
                    if ($type[$i] == 'table_fill_commission') {
                        if ($this->MODULE_STATUS['table_status'] == "yes" || $this->MODULE_STATUS['mlm_plan'] == "Board") {
                            $type[$i] = 'board_commission';
                        }
                    }
                    $i++;
                }
            } else {
                $type = '';
            }

            if ($this->input->post("user_name")) {
                $user_name = $this->input->post("user_name", TRUE);
                $user_id = $this->report_model->userNameToID($user_name);
                if (!$user_id) {
                    $msg = lang('invalid_username');
                    $this->redirect($msg, 'select_report/commission_report', FALSE);
                }
            }
            $this->set('user_name', $user_name);
            $from_date = (strip_tags($this->input->post("from_date", TRUE)));
            $to_date = (strip_tags($this->input->post("to_date", TRUE)));
            if ($from_date != '' && $to_date != '') {
                $report_date = lang('from') . "\t" . $from_date . "\t" . lang('to') . "\t" . $to_date;
            } else if ($from_date != '') {
                $report_date = lang('from') . "\t" . $from_date;
            } else if ($to_date != '') {
                $report_date = lang('to') . "\t" . $to_date;
            } else {
                $report_date = '';
            }
            $this->session->set_userdata("inf_commision_week_date1", $from_date);
            $this->session->set_userdata("inf_commision_week_date2", $to_date);
            $this->session->set_userdata("inf_commision_type", $type);
            $this->session->set_userdata("inf_user_id", $user_id);
//            if ($type == '') {
//                $msg = lang('enter_amount_type');
//                $this->redirect($msg, 'select_report/commission_report', false);
//            }
            $details = $this->report_model->getCommisionDetails($type, $from_date, $to_date, $user_id);
            $count = count($details);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_commission_report_error', $error_array);
            redirect('admin/select_report/commission_report');
        }

        if (!empty($this->session->userdata("inf_commision_type"))) {
            $from_date = $this->session->userdata("inf_commision_week_date1");
            $to_date = $this->session->userdata("inf_commision_week_date2");
            $type = $this->session->userdata("inf_commision_type");
            $user_id = $this->session->userdata("inf_user_id");
            $details = $this->report_model->getCommisionDetails($type, $from_date, $to_date, $user_id);
            $count = count($details);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/commission_report');
        }
        $this->report_header();


        $total_amount = 0;
        $total_amount_payable = 0;
        foreach($details as $detail) {
            $total_amount += $detail['total_amount'];
            $total_amount_payable += $detail['amount_payable'];
        }
        // echo $total_amount; exit;
        $this->set('total_amount', number_format((float)$total_amount, 2, '.', ''));
        $this->set('total_amount_payable', number_format((float)$total_amount_payable, 2, '.', ''));
        $this->set('details', $details);
        $this->set('count', $count);
        $this->set('date1', $date1);
        $this->set('type', $type);
        $help_link = "report";
        $this->set("help_link", $help_link);
        $this->set("report_date", $report_date);
        $this->setView();
    }

    function validate_commission_report_view() {

        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|strip_tags');
        $this->form_validation->set_rules('from_date', lang('from_date'), 'trim|strip_tags');
        $this->form_validation->set_rules('to_date', lang('to_date'), 'trim|strip_tags');
        $this->form_validation->set_rules('amount_type[]', lang('amoun_type'), 'trim|strip_tags');
        $validate_form = $this->form_validation->run();

        return $validate_form;
    }

    function epin_report_view() {

        $title = lang('epin_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->url_permission('pin_status');

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->HEADER_LANG['page_top_header'] = lang('epin_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('epin_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();


        $date = date("Y-m-d");
        $this->set("date", $date);
        $pin_details = $this->report_model->getUsedPin();
        $count = count($pin_details);
        $this->set("count", $count);
        $this->set("pin_details", $pin_details);
        $help_link = "report";
        $this->set("report_date", '');
        $this->set("help_link", $help_link);
        $this->setview();
    }

    function activate_deactivate_report_view() {

        $title = lang('activate_deactivate_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->HEADER_LANG['page_top_header'] = lang('activate_deactivate_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('activate_deactivate_report');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->report_header();

        $this->load_langauge_scripts();

        $date = date("Y-m-d");
        $this->set("date", $date);
        if ($this->input->post('submit_active_deactive') && $this->validate_activate_deactivate_report_view()) {
            $from = (strip_tags($this->input->post('week_date1', TRUE))) . " 00:00:00";
            $to = (strip_tags($this->input->post('week_date2', TRUE))) . " 23:59:59";
            $this->session->set_userdata("inf_week_date1", $from);
            $this->session->set_userdata("inf_week_date2", $to);
        } else {
            $error_array_active_deactive = $this->form_validation->error_array();
            $this->session->set_userdata('inf_total_active_deactive_error', $error_array_active_deactive);
            redirect('admin/select_report/activate_deactivate_report');
        }
        $report_date = '';
        if (!empty($this->session->userdata("inf_week_date1"))) {
            $start_date = $this->session->userdata("inf_week_date1");
            $to_date = $this->session->userdata("inf_week_date2");
            if ($start_date != '' && $to_date != '') {
                $report_date = lang('from') . "\t" . date("d-m-Y", strtotime($start_date)) . "\t" . lang('to') . "\t" . date("d-m-Y", strtotime($to_date));
            } else if ($start_date != '') {
                $report_date = lang('from') . "\t" . date("d-m-Y", strtotime($start_date));
            } else if ($to_date != '') {
                $report_date = lang('to') . "\t" . date("d-m-Y", strtotime($to_date));
            } else {
                $report_date = '';
            }
            $activate_deactive = $this->report_model->getAciveDeactiveUserDetails($start_date, $to_date);
            $count = count($activate_deactive);
            $this->set("count", $count);
            $this->set("activate_deactive", $activate_deactive);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/activate_deactivate_report');
        }
        $help_link = "downlaod_document";
        $this->set("help_link", $help_link);
        $this->set("report_date", $report_date);
        $this->setView();
    }

    function validate_activate_deactivate_report_view() {

        $this->form_validation->set_rules('week_date1', lang('start_date'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('week_date2', lang('end_date'), 'trim|required|strip_tags');

        $validate_form = $this->form_validation->run();

        return $validate_form;
    }

    function activate_deactivate_daily() {

        $title = lang('activate_deactivate_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->HEADER_LANG['page_top_header'] = lang('activate_deactivate_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('activate_deactivate_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $this->report_header();

        if ($this->input->post('dailydate') && $this->validate_active_inactive_daily()) {

            $today = (strip_tags($this->input->post('date', TRUE)));
            $this->session->set_userdata("inf_date1", $today);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_total_active_deactive_error', $error_array);
            redirect('admin/select_report/activate_deactivate_report');
        }
        $report_date = '';
        if (!empty($this->session->userdata("inf_date1"))) {
            $report_date = "$today";
            $today = $this->session->userdata("inf_date1");
            $todays_active_deactive = $this->report_model->getDailyActivateDeactivateReport($today);
            $count = count($todays_active_deactive);
            $this->set("count", $count);
            $this->set("todays_active_deactive", $todays_active_deactive);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/activate_deactivate_report');
        }
        $help_link = "downlaod_document";
        $this->set("help_link", $help_link);
        $this->set("report_date", $report_date);
        $this->setView();
    }

    function validate_active_inactive_daily() {
        $this->form_validation->set_rules('date', lang('date'), 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function repurchase_report_view() {

        $title = lang('repurchase_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->HEADER_LANG['page_top_header'] = lang('repurchase_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('repurchase_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $this->report_header();

        if ($this->input->post('submit') && $this->validate_repurcahse()) {

//            if (!($this->input->post('week_date1')) && !($this->input->post('week_date2'))){
//              $msg = lang('You_must_select_a_date');
//              $this->redirect($msg, 'select_report/repurchase_report', FALSE);
//            }
            if ($this->input->post('week_date1') == '' && $this->input->post('week_date2') == '' && $this->input->post('user_name') == '') {
                $msg = lang('Please Select Atleast One Criteria.');
                $this->redirect($msg, 'select_report/repurchase_report', FALSE);
            }
            if (($this->input->post('week_date1') != '') && ($this->input->post('week_date2') != '')) {
                if (($this->input->post('week_date1')) > ($this->input->post('week_date2'))) {
                    $msg = lang('To-Date should be greater than From-Date');
                    $this->redirect($msg, 'select_report/repurchase_report', FALSE);
                }
            }
            $week_date1 = strip_tags($this->input->post('week_date1'));
            $this->session->set_userdata("inf_date1", $week_date1);

            $week_date2 = strip_tags($this->input->post('week_date2'));
            $this->session->set_userdata("inf_date2", $week_date2);

            $user_name = strip_tags($this->input->post('user_name'));
            $this->session->set_userdata("inf_user_name", $user_name);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_repurchase_report_view_error', $error_array);
            redirect('admin/select_report/repurchase_report');
        }
        $report_date = '';
        if (!empty($this->session->userdata("inf_date1")) || !empty($this->session->userdata("inf_date2"))) {
            $report_date = date("Y-m-d H:i:s");

            $user_name = $this->session->userdata("inf_user_name");
            $user_id = $this->report_model->userNameToID($user_name);

            $week_date1 = $this->session->userdata("inf_date1");
            $week_date2 = $this->session->userdata("inf_date2");

            $purcahse_details = $this->report_model->getRepurchaseDetails($week_date1, $week_date2, $user_id);
            $count = count($purcahse_details);
            $this->set("count", $count);
            $this->set("purcahse_details", $purcahse_details);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_repurchase_report_view_error', $error_array);
            redirect('admin/select_report/repurchase_report');
        }

        $help_link = "repurcahse_report_view";
        $this->set("help_link", $help_link);
        $this->set("report_date", $report_date);
        $this->setView();
    }

    function validate_repurcahse() {
        $this->form_validation->set_rules('week_date1', lang('from_date'), 'trim|strip_tags');
        $this->form_validation->set_rules('week_date2', lang('to_date'), 'trim|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function product_invoice($enc_invoice_order_id) {

        $title = lang('invoice_details');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->HEADER_LANG['page_top_header'] = lang('invoice_details');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('invoice_details');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $this->report_header();
        $report_date = date("Y-m-d");

        if (!$enc_invoice_order_id) {
            redirect('admin/select_report/repurchase_report');
        } else {
            $invoice_order_id = $this->validation_model->decrypt($enc_invoice_order_id);

            if (!$invoice_order_id) {
                $this->redirect(lang('invalid_invoice_id'), "select_report/repurchase_report", FALSE);
            }
            $invoice_details = $this->report_model->getRpurchaseInvoiceDetails($invoice_order_id);
            $this->set("count", count($invoice_details));
            $this->set("invoice_details", $invoice_details);
        }

        $help_link = "invoice_details";
        $this->set("help_link", $help_link);
        $this->set("report_date", $report_date);

        $this->setView();
    }

    function stair_step_report_view() {

        $title = lang('stair_step_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->HEADER_LANG['page_top_header'] = lang('stair_step_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('stair_step_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $this->report_header();

        if ($this->input->post('submit') && $this->validate_repurcahse()) {

            $week_date1 = strip_tags($this->input->post('week_date1'));
            $this->session->set_userdata("inf_date1", $week_date1);

            $week_date2 = strip_tags($this->input->post('week_date2'));
            $this->session->set_userdata("inf_date2", $week_date2);

            $user_name = strip_tags($this->input->post('user_name'));
            $this->session->set_userdata("inf_user_name", $user_name);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_stair_step_report_view_error', $error_array);
            redirect('admin/select_report/stair_step_report');
        }
        $report_date = '';
        if (!empty($this->session->userdata("inf_date1")) && !empty($this->session->userdata("inf_date2"))) {
            $report_date = date("Y-m-d H:i:s");

            $user_name = $this->session->userdata("inf_user_name");
            $leader_id = $this->report_model->userNameToID($user_name);

            $week_date1 = $this->session->userdata("inf_date1");
            $week_date2 = $this->session->userdata("inf_date2");

            $purcahse_details = $this->report_model->getStairStepDetails($week_date1, $week_date2, $leader_id);
            $count = count($purcahse_details);
            $this->set("count", $count);
            $this->set("purcahse_details", $purcahse_details);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_stair_step_report_view_error', $error_array);
            redirect('admin/select_report/stair_step_report');
        }

        $help_link = "stair_step_view";
        $this->set("help_link", $help_link);
        $this->set("report_date", $report_date);
        $this->setView();
    }

    function override_report_view() {

        $title = lang('override_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->HEADER_LANG['page_top_header'] = lang('override_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('override_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $this->report_header();

        if ($this->input->post('submit') && $this->validate_repurcahse()) {

            $week_date1 = strip_tags($this->input->post('week_date1'));
            $this->session->set_userdata("inf_date1", $week_date1);

            $week_date2 = strip_tags($this->input->post('week_date2'));
            $this->session->set_userdata("inf_date2", $week_date2);

            $user_name = strip_tags($this->input->post('user_name'));
            $this->session->set_userdata("inf_user_name", $user_name);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_override_report_view_error', $error_array);
            redirect('admin/select_report/override_report');
        }
        $report_date = '';
        if (!empty($this->session->userdata("inf_date1")) && !empty($this->session->userdata("inf_date2"))) {
            $report_date = date("Y-m-d H:i:s");

            $user_name = $this->session->userdata("inf_user_name");
            $leader_id = $this->report_model->userNameToID($user_name);

            $week_date1 = $this->session->userdata("inf_date1");
            $week_date2 = $this->session->userdata("inf_date2");

            $purcahse_details = $this->report_model->getOverRideDetails($week_date1, $week_date2, $leader_id);
            $count = count($purcahse_details);
            $this->set("count", $count);
            $this->set("purcahse_details", $purcahse_details);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_override_report_view_error', $error_array);
            redirect('admin/select_report/override_report_view');
        }

        $help_link = "override_report_view";
        $this->set("help_link", $help_link);
        $this->set("report_date", $report_date);
        $this->setView();
    }

    //config change report
    function config_changes_report_view() {

        $title = lang('settings_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->HEADER_LANG['page_top_header'] = lang('settings_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('settings_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $form_submit = FALSE;

        $help_link = "report";
        $this->set("report_date", '');
        $this->set("help_link", $help_link);

        if ($this->input->post('submit_date')) {

            $date_post_array = $this->input->post(NULL, TRUE);
            $date_post_array = $this->validation_model->stripTagsPostArray($date_post_array);

            if (($date_post_array['from_date'] == '') && ( $date_post_array['to_date'] == '')) {
                $msg = lang('Please Select Atleast One Criteria.');
                $this->redirect($msg, 'select_report/config_changes_report', FALSE);
            }
            if ($date_post_array['from_date'] != '' && $date_post_array['to_date'] != '') {
                if (strtotime($date_post_array['from_date']) > strtotime($date_post_array['to_date'])) {
                    $msg = lang('To-Date should be greater than From-Date');
                    $this->redirect($msg, 'select_report/config_changes_report', FALSE);
                }
            }
            $form_submit = TRUE;
            if ($date_post_array['from_date'] != '') {
                $from_date = $date_post_array['from_date'] . " 00:00:00";
            } else {
                $from_date = '';
            }
            if ($date_post_array['to_date'] != '') {
                $to_date = $date_post_array['to_date'] . " 23:59:59";
            } else {
                $to_date = '';
            }
            $ip_address = $date_post_array['ip_address'];


            $this->session->set_userdata('from_date', $from_date);
            $this->session->set_userdata('to_date', $to_date);
            $this->session->set_userdata('ip_address', $ip_address);
            $config_details = $this->report_model->getConfigChanges($from_date, $to_date, $ip_address);
            $count = count($config_details);
            $this->set("count", $count);
            $this->set("from_date", $from_date);
            $this->set("to_date", $to_date);
            $this->set("config_details", $this->security->xss_clean($config_details));
        } else {
            redirect('admin/select_report/config_changes_report');
        }

        $this->setview();
    }

    //
    //E-pin Transfer History Report
    function epin_transfer_report_view() {

        $title = lang('epin_transfer_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->HEADER_LANG['page_top_header'] = lang('epin_transfer_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('epin_transfer_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $user_id = null;

        if ($this->input->post('submit')) {

            if (!($this->input->post('week_date1')) && !($this->input->post('week_date2')) && !($this->input->post('user_name')) && !($this->input->post('to_user_name'))) {
                $msg = lang('please_select_one_option');
                $this->redirect($msg, 'select_report/epin_report', FALSE);
            }

            $user_name = strip_tags($this->input->post('user_name', TRUE));
            if (!empty($user_name)) {
                if (!($this->report_model->userNameToID($user_name))) {
                    $msg = lang('invalid_user_name');
                    $this->redirect($msg, "select_report/epin_report", FALSE);
                }
            }
            $this->session->set_userdata("inf_user_name", $user_name);

            $to_user_name = strip_tags($this->input->post('to_user_name', TRUE));
            if (!empty($to_user_name)) {
                if (!($this->report_model->userNameToID($to_user_name))) {
                    $msg = lang('invalid_user_name');
                    $this->redirect($msg, "select_report/epin_report", FALSE);
                }
            }
            $this->session->set_userdata("inf_to_user_name", $to_user_name);

            $week_date1 = strip_tags($this->input->post('week_date1'));
            $this->session->set_userdata("inf_date1", $week_date1);

            $week_date2 = strip_tags($this->input->post('week_date2'));
            $this->session->set_userdata("inf_date2", $week_date2);
        }
        $report_date = date("Y-m-d H:i:s");
        if ($week_date1) {
            if ($week_date2) {
                $report_date = lang('from') . "\t" . $week_date1 . "\t" . lang('to') . "\t" . $week_date2;
            } else {
                $report_date = $week_date1;
            }
        } elseif ($week_date2) {
            $report_date = $week_date2;
        }

        if (!empty($this->session->userdata("inf_date1")) || !empty($this->session->userdata("inf_date2")) || !empty($this->session->userdata("inf_user_name")) || !empty($this->session->userdata("inf_to_user_name"))) {

            $user_name = $this->session->userdata("inf_user_name");
            $user_id = $this->report_model->userNameToID($user_name);

            $to_user_name = $this->session->userdata("inf_to_user_name");
            $to_user_id = $this->report_model->userNameToID($to_user_name);

            $week_date1 = $this->session->userdata("inf_date1");
            $week_date2 = $this->session->userdata("inf_date2");

            $transfer_details = $this->report_model->getEpinTransferDetails($week_date1, $week_date2, $user_id, $to_user_id);
            $count = count($transfer_details);
            $this->set("count", $count);
            $this->set("transfer_details", $transfer_details);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_epin_report_view_error', $error_array);
            redirect('admin/select_report/epin_report');
        }
        $date = date("Y-m-d");
        $this->set("date", $date);
        $this->set("report_date", $report_date);
        $help_link = "report";
        $this->set("help_link", $help_link);
        $this->setview();
    }

    function rank_performance_report() {

        $title = lang('rank_performance_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = "Rank Performance Report";
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = "Rank Performance Report";
        $this->HEADER_LANG['page_small_header'] = '';


        $this->load_langauge_scripts();

        $this->report_header();

        $date = date("Y-m-d");
        $this->set("date", $date);
        $is_valid_username = false;

        if ($this->input->post('user_submit') && $this->validate_performance_report()) {

            $user_mob_name = ($this->input->post('user_name', TRUE));

            $this->session->set_userdata("is_valid_user_name", $user_mob_name);
            $user_id = $this->validation_model->userNameToID($user_mob_name);
            $is_valid_username = $this->validation_model->isUserAvailable($user_id);

            if (!$is_valid_username) {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'select_report/rank_performance_report', FALSE);
            }

            $this->session->set_userdata("inf_user_name_payout", $user_mob_name);
            $user_details = $this->validation_model->getAllUserDetails($user_id);

            $full_name = $user_details['user_detail_name'];

            $this->load->model('rank_model');
            $rank_achievement = $this->rank_model->getRankCriteria($user_id);//print_r($rank_achievement);die;
        } else {
            $error_array_user = $this->form_validation->error_array();
            $this->session->set_userdata('inf_member_payout_report_error', $error_array_user);
            redirect('admin/select_report/rank_performance_report');
        }
        if (!empty($this->session->userdata("inf_user_name_payout"))) {
            $user_mob_name = $this->session->userdata("inf_user_name_payout");
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/rank_performance_report');
        }

        $report_name = lang('rank_details');

        $this->set('report_name', $report_name);
        $help_link = "Top-earners";
        $this->set("report_date", '');
        $help_link = "report";
        $this->set("rank_achievement", $rank_achievement);
        $this->set("user_name", $user_mob_name);
        $this->set("full_name", $full_name);
        $this->set("help_link", $help_link);
        $this->setView();
    }

    function validate_performance_report() {
        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function get_rank_performance_detail($user_id) {

        $details = array();
        $rank_details = array();
        $referal_count = 0;
        $current_rank = 0;
        $next_ran = 0;
        $next_rank = '';
        $referal_count = $this->validation_model->getReferalCount($user_id);

        $current_rank = $this->validation_model->getUserRank($user_id);
        $personal_pv = $this->validation_model->getPersnlPv($user_id);

        if ($current_rank != '') {
            $rank_details = $this->select_report_model->selectRankDetails($current_rank);
            $ref_count = $rank_details['referal_count'];
        } else {
            $ref_count = 0;
        }

        if (!$personal_pv) {
            $personal_pv = 0;
        }

        $group_pv = $this->validation_model->getGrpPv($user_id);
        if (!$group_pv) {
            $group_pv = 0;
        }

        $next_rank = $this->select_report_model->getNextRank($ref_count);

        if ($current_rank != 0) {
            $rank_details = $this->select_report_model->selectRankDetails($current_rank);
            $current_rank = $rank_details['rank_name'];
        } else {
            $current_rank = 'NA';
        }

        if ($next_rank) {
            if ($next_rank[0]->referal_count > $referal_count) {
                $balance_referal_count = $next_rank[0]->referal_count - $referal_count;
            } else {
                $balance_referal_count = 0;
            }
            if ($next_rank[0]->personal_pv > $personal_pv) {
                $balance_personal_pv = $next_rank[0]->personal_pv - $personal_pv;
            } else {
                $balance_personal_pv = 0;
            }
            if ($next_rank[0]->gpv > $group_pv) {
                $balance_gpv = $next_rank[0]->gpv - $group_pv;
            } else {
                $balance_gpv = 0;
            }

            $next_ran = $next_rank[0]->rank_name;
            $next_referal_count = $next_rank[0]->referal_count;
            $next_pers_pv = $next_rank[0]->personal_pv;
            $next_grp_pv = $next_rank[0]->gpv;
        } else {
            $balance_referal_count = 'NA';
            $next_ran = 'NA';
            $next_referal_count = 'NA';
            $next_pers_pv = 'NA';
            $next_grp_pv = 'NA';
            $balance_gpv = 'NA';
            $balance_personal_pv = 'NA';
        }
        $details ['referal_count'] = $referal_count;
        $details ['personal_pv'] = $personal_pv;
        $details ['group_pv'] = $group_pv;
        $details ['current_rank'] = $current_rank;
        $details ['next_rank'] = $next_ran;
        $details ['balance_referal_count'] = $balance_referal_count;
        $details ['balance_pers_pv'] = $balance_personal_pv;
        $details ['balance_grp_pv'] = $balance_gpv;
        $details ['next_referal_count'] = $next_referal_count;
        $details ['next_pers_pv'] = $next_pers_pv;
        $details ['next_grp_pv'] = $next_grp_pv;

        return $details;
    }

    function roi_report_view() {

        $title = lang('roi_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->HEADER_LANG['page_top_header'] = lang('roi_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('roi_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $date = date("Y-m-d");
        $report_date = '';
        $this->set("date", $date);
        $date1 = date('Y-m-d:H:i:s');
        $user_id = "";
        $user_name = "";
        if ($this->input->post('submit') && $this->validate_roi()) {
            if ($this->input->post('user_name') == '' && $this->input->post('week_date1') == '' && $this->input->post('week_date2') == '') {
                $msg = lang('you_must_select_atleast_one_criteria');
                $this->redirect($msg, 'select_report/roi_report', FALSE);
            }
            if (($this->input->post('week_date1') != '') && ($this->input->post('week_date2') != '')) {
                if (($this->input->post('week_date1')) > ($this->input->post('week_date2'))) {
                    $msg = lang('to_date_should_be_greater_than_or_equal_to_from_date');
                    $this->redirect($msg, 'select_report/roi_report', FALSE);
                }
            }

            if ($this->input->post("user_name")) {
                $user_name = $this->input->post("user_name", TRUE);
                $user_id = $this->report_model->userNameToID($user_name);
                if (!$user_id) {
                    $msg = lang('invalid_username');
                    $this->redirect($msg, 'select_report/roi_report', FALSE);
                }
            }
            $this->set('user_name', $user_name);
            $from_date = (strip_tags($this->input->post("week_date1", TRUE)));
            $to_date = (strip_tags($this->input->post("week_date2", TRUE)));
            if ($from_date != '' && $to_date != '') {
                $report_date = lang('from') . "\t" . $from_date . "\t" . lang('to') . "\t" . $to_date;
            } else if ($from_date != '') {
                $report_date = lang('from') . "\t" . $from_date;
            } else if ($to_date != '') {
                $report_date = lang('to') . "\t" . $to_date;
            } else {
                $report_date = '';
            }
            $this->session->set_userdata("inf_roi_week_date1", $from_date);
            $this->session->set_userdata("inf_roi_week_date2", $to_date);
            $this->session->set_userdata("inf_user_id", $user_id);
            $roi_details = $this->report_model->getroiDetails($from_date, $to_date, $user_id);
            $count = count($roi_details);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_roi_report_error', $error_array);
            redirect('admin/select_report/roi_report');
        }

        if (!empty($this->session->userdata("inf_roi_week_date1")) || !empty($this->session->userdata("inf_roi_week_date2")) || !empty($this->session->userdata("inf_user_id"))) {
            $from_date = $this->session->userdata("inf_roi_week_date1");
            $to_date = $this->session->userdata("inf_roi_week_date2");
            $user_id = $this->session->userdata("inf_user_id");
            $roi_details = $this->report_model->getroiDetails($from_date, $to_date, $user_id);
            $count = count($roi_details);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/roi_report');
        }
        $this->report_header();


        $this->set('roi_details', $this->security->xss_clean($roi_details));
        $this->set('count', $count);
        $this->set('date1', $date1);
        $help_link = "report";
        $this->set("help_link", $help_link);
        $this->set("report_date", $report_date);
        $this->setView();
    }

    function validate_roi() {
        $this->form_validation->set_rules('week_date1', lang('from_date'), 'trim|strip_tags');
        $this->form_validation->set_rules('week_date2', lang('to_date'), 'trim|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function personal_data_export() {

        $title = lang('personal_data_export');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('personal_data_export');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('personal_data_export');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $date = date("Y-m-d");
        $this->set("date", $date);

        $user_name = $this->LOG_USER_NAME;
        $profile_arr = $this->report_model->getGdprDetails($user_name);

        $config = $this->pagination->customize_style();
        $base_url = base_url() . "admin/report/personal_data_export";
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;

        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(4);
        } else {
            $page = 0;
        }

        $activity_details = $this->activity_history_model->getActivityHistory($page, $config['per_page'], '', '', $user_name);
        $profile_arr['activity'] = $activity_details;
        $total_rows = $this->activity_history_model->getActivityHistoryCount('', '', $user_name);
        $config['total_rows'] = $total_rows;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();
        $this->set('result_per_page', $result_per_page);
        $this->set('page_id', $page);

        $this->set("details", $this->security->xss_clean($profile_arr));

        $help_link = "personal_data_export";
        $this->set("help_link", $help_link);
        $this->set("report_date", $date);
        $this->setView();
    }

    function revenue_report() {
        $title = lang('monthly_revenue_report');
        $this->set('title', $this->COMPANY_NAME . ' |' . $title);
        $help_link = 'my-e-wallet';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('monthly_revenue_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('monthly_revenue_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();


        $date = $this->session->userdata('inavlid_date') ? $this->session->userdata('inavlid_date') : date("Y-m");
        $this->session->userdata('inavlid_date') ? $this->session->unset_userdata('inavlid_date') : '';
        $details = $this->report_model->getRevenueReportDetails($this->MODULE_STATUS, $date);

        if ($this->input->post('new_expense') && $this->validate_expense()) {
            $post_arr = $this->security->xss_clean($this->input->post(NULL, TRUE));
            $result = $this->report_model->addNewExpense($post_arr);
            if ($result) {
                $msg = lang("expense_added_successfully");
                $this->redirect($msg, 'report/revenue_report', TRUE);
            } else {
                $msg = lang("error_on_adding_expense");
                $this->redirect($msg, 'report/revenue_report', FALSE);
            }
        }
        if ($this->input->post('submit') && $this->validate_date()) {
            $post_arr = $this->security->xss_clean($this->input->post(NULL, TRUE));
            $date = $post_arr['weekdate'];
            $curdate = strtotime(date("Y-m"));
            $mydate = strtotime($date);
            if ($mydate > $curdate) {
                $this->session->set_userdata('inavlid_date', $date);
                $msg = lang('Date should be less than or equal to current date');
                $this->redirect($msg, 'report/revenue_report', FALSE);
            }
            $details = $this->report_model->getRevenueReportDetails($this->MODULE_STATUS, $date);
        }
        $this->set('details', $details);

        $this->setView();
    }

    function validate_expense() {
        $this->form_validation->set_rules('amount', lang('amount'), 'trim|required|xss_clean|numeric|strip_tags');
        $this->form_validation->set_rules('description', lang('description'), 'trim|required|xss_clean|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function validate_date() {
        $this->form_validation->set_rules('weekdate', lang('month'), 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function transaction_errors() {
        $title = lang('transaction_errors');
        $this->set('title', $this->COMPANY_NAME . ' |' . $title);
        $help_link = 'my-e-wallet';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('transaction_errors');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('transaction_errors');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $details = array();
        $post_status = false;

        if ($this->input->post('weekdate') && $this->validate_transaction_errors()) {
            $post_arr = $this->security->xss_clean($this->input->post(NULL, TRUE));
            $from_date = $post_arr['week_date1'];
            $to_date = $post_arr['week_date2'];
            $details = $this->report_model->getTranasactionErrorDetails($from_date, $to_date);
            $post_status = true;
        }
        $this->set('details', $details);
        $this->set('post_status', $post_status);

        $this->setView();
    }

    function validate_transaction_errors() {
        $this->form_validation->set_rules('week_date1', lang('from_date'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('week_date2', lang('to_date'), 'trim|required|strip_tags');

        $validate_form = $this->form_validation->run();

        return $validate_form;
    }
    
    public function user_upgrade_report(){
        
        $title = lang('user_upgrade_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('user_upgrade_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('user_upgrade_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
           
        $date = $this->session->userdata('inavlid_date') ? $this->session->userdata('inavlid_date') : date("Y-m");
        $this->session->userdata('inavlid_date') ? $this->session->unset_userdata('inavlid_date') : '';
        
          
            
        $help_link = lang('user_upgrade_report');
        $this->set("help_link", $help_link);
        $this->set('action_page', $this->CURRENT_URL);
        
        $config = $this->pagination->customize_style();
        $base_url = base_url() . "admin/report/user_upgrade_report";
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        
      
        $date = date("Y-m-d");
        $report_date = '';
        $this->set("date", $date);
        $date1 = date('Y-m-d:H:i:s');
        $user_id = "";
        $user_name = "";
        $count=0;
        if ($this->input->post('submit')) {
            if (($this->input->post('week_date1') != '') && ($this->input->post('week_date2') != '')) {
                if (($this->input->post('week_date1')) > ($this->input->post('week_date2'))) {
                    $msg = lang('To-Date should be greater than From-Date');
                    $this->redirect($msg, 'report/user_upgrade_report', FALSE);
                }
            }
            
           /* if ($this->input->post("user_name")) {
                $user_name = $this->input->post("user_name", TRUE);
                //$user_id = $this->report_model->userNameToID($user_name);
                $user_id = $this->validation_model->userNameToID($user_name);
                if (!$user_id) {
                    $msg = lang('invalid_username');
                    $this->redirect($msg, 'report/user_upgrade_report', FALSE);
                }
            }*/
            $this->set('user_name', $user_name);
            $from_date = (strip_tags($this->input->post("week_date1", TRUE)));
            $to_date = (strip_tags($this->input->post("week_date2", TRUE)));
            if ($from_date != '' && $to_date != '') {
                $report_date = lang('from') . "\t" . $from_date . "\t" . lang('to') . "\t" . $to_date;
            } else if ($from_date != '') {
                $report_date = lang('from') . "\t" . $from_date;
            } else if ($to_date != '') {
                $report_date = lang('to') . "\t" . $to_date;
            } else {
                $report_date = '';
            }
            $this->session->set_userdata("inf_commision_week_date1", $from_date);
            $this->session->set_userdata("inf_commision_week_date2", $to_date);
            $this->session->set_userdata("inf_user_id", $user_id);

           /* if(empty($this->input->post("user_name"))){
                 $msg = lang('select_atleast');
                 $this->redirect($msg, 'report/user_upgrade_report', FALSE);
            }*/
            $details = $this->report_model->getUserUpgradeDetails($from_date, $to_date);//print_r($details);die;
            $count = count($details);
             $this->set('details',$details);
        }
        
        $this->set('count', $count);
       
            
            $this->setView();
        }
        
        
        function monthly_payment_report(){
         $title = lang('weekly_payment_report');
        $this->set('title', $this->COMPANY_NAME . ' |' . $title);
        
        $this->HEADER_LANG['page_top_header'] = lang('monthly_payment_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('monthly_payment_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        
        $help_link = lang('monthly_payment_report');
        $this->set("help_link", $help_link);
        $this->set('action_page', $this->CURRENT_URL);
        
        $config = $this->pagination->customize_style();
        $base_url = base_url() . "admin/report/monthly_payment_report";
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        
      
        $date = date("Y-m-d");
        $report_date = '';
        $this->set("date", $date);
        //$date1 = date('Y-m-d:H:i:s');
        $user_id = "";
        $user_name = "";
        $count=0;
        $type='';
       // $details = $this->report_model->getPaymentDetails($from_date='', $to_date='', $user_id='',$type='');
        // $count = count($details);
        if ($this->input->post('search_member_submit')) {
            if (($this->input->post('week_date1') != '') && ($this->input->post('week_date2') != '')) {
                if (($this->input->post('week_date1')) > ($this->input->post('week_date2'))) {
                    $msg = lang('To-Date should be greater than From-Date');
                    $this->redirect($msg, 'report/monthly_payment_report', FALSE);
                }
            }
            
            if ($this->input->post("user_name")) {
                $user_name = $this->input->post("user_name", TRUE);
                $user_id = $this->report_model->userNameToID($user_name);
                if (!$user_id) {
                    $msg = lang('invalid_username');
                    $this->redirect($msg, 'report/monthly_payment_report', FALSE);
                }
            }
            $this->set('user_name', $user_name);
            $from_date = (strip_tags($this->input->post("week_date1", TRUE)));
            $to_date = (strip_tags($this->input->post("week_date2", TRUE)));
            if ($from_date != '' && $to_date != '') {
                $report_date = lang('from') . "\t" . $from_date . "\t" . lang('to') . "\t" . $to_date;
            } else if ($from_date != '') {
                $report_date = lang('from') . "\t" . $from_date;
            } else if ($to_date != '') {
                $report_date = lang('to') . "\t" . $to_date;
            } else {
                $report_date = '';
            }
            
            if($this->input->post("subscription_mode")){
                $type = $this->input->post("subscription_mode",TRUE);
                
            }
            $this->session->set_userdata("inf_commision_week_date1", $from_date);
            $this->session->set_userdata("inf_commision_week_date2", $to_date);
            $this->session->set_userdata("inf_user_id", $user_id);
            $this->session->set_userdata("inf_subscription_mode", $type);
            
          
          
            $details = $this->report_model->getPaymentDetails($from_date, $to_date, $user_id, $type);
            $count = count($details);
             $this->set('details',$details);
        }
        
        
        //$this->set('details',$details);
        $this->set('count', $count);
       
        $this->setView();
    }
    
    public function reward_report() {

        $title = lang('reward_report');
        $this->set('title', $this->COMPANY_NAME . ' |' . $title);

        $this->HEADER_LANG['page_top_header'] = lang('reward_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('reward_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = lang('reward_report');
        $this->set("help_link", $help_link);
        $this->set('action_page', $this->CURRENT_URL);

        $user_id = '';
        $user_name='';
        $this->set('user_name',$user_name);
        $base_url = base_url() . 'admin/report/reward_report';
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
         if ($this->uri->segment(4) != "")
            $page = $this->uri->segment(4);
        else
            $page = 0;


        $config['total_rows'] = $this->profile_model->getTotalRankCount($user_id);
        $reward_details = $this->report_model->getRankDetails($config['per_page'], $page, $user_id, $from_date = '', $to_date = '');

        if ($this->input->post('search_member_submit')) {
            if ($this->input->post('user_name')) {
                $u_name = $this->input->post('user_name', true);
                $this->set('user_name',$u_name);
                $this->session->set_userdata('u_name', $u_name);
                
                $user_id = $this->validation_model->userNameToID($u_name);
                if (!$user_id) {
                    $this->session->set_userdata('u_name', '');
                    $msg = lang('invalid_user');
                    $this->redirect($msg, 'report/reward_report', false);
                }
            }

            if (($this->input->post('week_date1') != '') && ($this->input->post('week_date2') != '')) {
                if (($this->input->post('week_date1')) > ($this->input->post('week_date2'))) {
                    $msg = lang('To-Date should be greater than From-Date');
                    $this->redirect($msg, 'report/reward_report', FALSE);
                }
            }
            $from_date = (strip_tags($this->input->post("week_date1", TRUE)));
            $to_date = (strip_tags($this->input->post("week_date2", TRUE)));

            if ($from_date != '' && $to_date != '') {
                $report_date = lang('from') . "\t" . $from_date . "\t" . lang('to') . "\t" . $to_date;
            } else if ($from_date != '') {
                $report_date = lang('from') . "\t" . $from_date;
            } else if ($to_date != '') {
                $report_date = lang('to') . "\t" . $to_date;
            } else {
                $report_date = '';
            }
            $this->session->set_userdata("inf_commision_week_date1", $from_date);
            $this->session->set_userdata("inf_commision_week_date2", $to_date);
            $this->session->set_userdata("inf_user_id", $user_id);


            $config['total_rows'] = $this->profile_model->getTotalRankCount($user_id);
            $reward_details = $this->report_model->getRankDetails($config['per_page'], $page, $user_id, $from_date, $to_date);
        }


        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();

        $this->set('result_per_page', $result_per_page);
        $this->set('details', $reward_details);
        $this->set('user_id', $user_id);

        $this->setView();
    }

    function stripe_monhtly_recurring_report_view() {
        
        $title = lang('stripe_monhtly_recurring_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->HEADER_LANG['page_top_header'] = lang('stripe_monhtly_recurring_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('stripe_monhtly_recurring_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $type = "";
        $date = date("Y-m-d");
        $report_date = '';
        $this->set("date", $date);
        $date1 = date('Y-m-d:H:i:s');
        $user_id = "";
        $user_name = "";
        if ($this->input->post('stripe_monhtly_recurring') && $this->validate_stripe_monhtly_recurring_report_view()) {
            
            if ($this->input->post('status') == '' && $this->input->post('user_name') == '' && $this->input->post('from_date') == '' && $this->input->post('to_date') == '') {
                $msg = lang('Please Select Atleast One Criteria.');
                $this->redirect($msg, 'select_report/stripe_monhtly_recurring_report', FALSE);
            }
            if (($this->input->post('from_date') != '') && ($this->input->post('to_date') != '')) {
                if (($this->input->post('from_date')) > ($this->input->post('to_date'))) {
                    $msg = lang('To-Date should be greater than From-Date');
                    $this->redirect($msg, 'select_report/stripe_monhtly_recurring_report', FALSE);
                }
            }
            if ($this->input->post("status") != '') {
                $type = $this->input->post("status", TRUE);
                // $i = 0;
                // foreach ($type as $t) {
                //     if ($type[$i] == 'table_fill_commission') {
                //         if ($this->MODULE_STATUS['table_status'] == "yes" || $this->MODULE_STATUS['mlm_plan'] == "Board") {
                //             $type[$i] = 'board_commission';
                //         }
                //     }
                //     $i++;
                // }
            } else {
                $type = array(0 => 'active ', 1 => 'pending');
            }

            if ($this->input->post("user_name")) {
                $user_name = $this->input->post("user_name", TRUE);
                $user_id = $this->report_model->userNameToID($user_name);
                if (!$user_id) {
                    $msg = lang('invalid_username');
                    $this->redirect($msg, 'select_report/stripe_monhtly_recurring_report', FALSE);
                }
            }
            $this->set('user_name', $user_name);
            $from_date = (strip_tags($this->input->post("from_date", TRUE)));
            $to_date = (strip_tags($this->input->post("to_date", TRUE)));
            if ($from_date != '' && $to_date != '') {
                $report_date = lang('from') . "\t" . $from_date . "\t" . lang('to') . "\t" . $to_date;
            } else if ($from_date != '') {
                $report_date = lang('from') . "\t" . $from_date;
            } else if ($to_date != '') {
                $report_date = lang('to') . "\t" . $to_date;
            } else {
                $report_date = '';
            }
            $this->session->set_userdata("inf_commision_week_date1", $from_date);
            $this->session->set_userdata("inf_commision_week_date2", $to_date);
            $this->session->set_userdata("inf_commision_type", $type);
            $this->session->set_userdata("inf_user_id", $user_id);
            
            $details = $this->report_model->getStripeMonhtlyRecurringDetails($type, $from_date, $to_date, $user_id);
            $count = count($details);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_stripe_monhtly_recurring_report_error', $error_array);
            redirect('admin/select_report/stripe_monhtly_recurring_report');
        }

        if (!empty($this->session->userdata("inf_commision_type"))||!empty($this->session->userdata("inf_user_id"))) {
            $from_date = $this->session->userdata("inf_commision_week_date1");
            $to_date = $this->session->userdata("inf_commision_week_date2");
            $type = $this->session->userdata("inf_commision_type");
            $user_id = $this->session->userdata("inf_user_id");
            $details = $this->report_model->getStripeMonhtlyRecurringDetails($type, $from_date, $to_date, $user_id);
            $count = count($details);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/stripe_monhtly_recurring_report');
        }
        $this->report_header();
        
        $this->set('details', $details);
        $this->set('count', $count);
        $this->set('date1', $date1);
        $this->set('type', $type);
        $help_link = "report";
        $this->set("help_link", $help_link);
        $this->set("report_date", $report_date);
        $this->setView();
    }

    function validate_stripe_monhtly_recurring_report_view() {

        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|strip_tags');
        $this->form_validation->set_rules('from_date', lang('from_date'), 'trim|strip_tags');
        $this->form_validation->set_rules('to_date', lang('to_date'), 'trim|strip_tags');
        $this->form_validation->set_rules('status[]', lang('status'), 'trim|strip_tags');
        $validate_form = $this->form_validation->run();

        return $validate_form;
    }

}
