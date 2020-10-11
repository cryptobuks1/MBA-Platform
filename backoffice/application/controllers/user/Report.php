<?php

require_once 'Inf_Controller.php';

class Report extends Inf_Controller {

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

    function validate_repurcahse() {
        $this->form_validation->set_rules('week_date1', lang('from_date'), 'trim|strip_tags');
        $this->form_validation->set_rules('week_date2', lang('to_date'), 'trim|strip_tags');
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

            $week_date1 = strip_tags($this->input->post('week_date1'));
            $this->session->set_userdata("inf_date1", $week_date1);

            $week_date2 = strip_tags($this->input->post('week_date2'));
            $this->session->set_userdata("inf_date2", $week_date2);

            if ($week_date1 == '' && $week_date2 == '') {
                $msg = lang('Please select atleast one criteria');
                $this->redirect($msg, 'select_report/repurchase_report', FALSE);
            }
            if ($week_date1 && $week_date2 && $week_date1 > $week_date2) {
                $msg = lang('TO date must be greater than or equal to the FROM date');
                $this->redirect($msg, 'select_report/repurchase_report', FALSE);
            }

            $user_name = $this->LOG_USER_NAME;
            $this->session->set_userdata("inf_user_name", $user_name);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_repurchase_report_view_error', $error_array);
            redirect('user/select_report/repurchase_report');
        }
        $report_date = '';
        if (!empty($this->session->userdata("inf_date1")) && !empty($this->session->userdata("inf_date2"))) {
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
            redirect('user/select_report/repurchase_report');
        }

        $help_link = "repurcahse_report_view";
        $this->set("help_link", $help_link);
        $this->set("report_date", $report_date);
        $this->setView();
    }

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
        $user_id = $this->LOG_USER_ID;

        if ($this->input->post('submit')) {

            if (!($this->input->post('week_date1')) && !($this->input->post('week_date2')) && !($this->input->post('user_name'))) {
                $msg = lang('please_select_date');
                $this->redirect($msg, 'select_report/epin_report', FALSE);
            }

            $to_user_name = strip_tags($this->input->post('user_name', TRUE));
            if (!empty($to_user_name)) {
                if (!($this->report_model->userNameToID($to_user_name))) {
                    $msg = lang('invalid_user_name');
                    $this->redirect($msg, "select_report/epin_report", FALSE);
                }
            }
            $this->session->set_userdata("inf_to_user_name", $to_user_name);

            $user_name = $this->validation_model->IdToUserName($user_id);
            $this->session->set_userdata("inf_user_name", $user_name);

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
        if (!empty($this->session->userdata("inf_date1")) || !empty($this->session->userdata("inf_date2")) || !empty($this->session->userdata("inf_to_user_name"))) {

            $user_name = $this->session->userdata("inf_user_name");

            $to_user_name = $this->session->userdata("inf_to_user_name");
            $to_user_id = $this->report_model->userNameToID($to_user_name);

            $week_date1 = $this->session->userdata("inf_date1");
            $week_date2 = $this->session->userdata("inf_date2");

            $transfer_details = $this->report_model->getEpinTransferDetailsForUser($week_date1, $week_date2, $user_id, $to_user_id);
            $count = count($transfer_details);
            $this->set("count", $count);
            $this->set("transfer_details", $transfer_details);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_epin_report_view_error', $error_array);
            redirect('select_report/epin_report');
        }
        $date = date("Y-m-d");
        $this->set("date", $date);
        $this->set("report_date", $report_date);
        $help_link = "report";
        $this->set("help_link", $help_link);
        $this->setview();
    }

    function personal_data_export() {
        $this->load->model('activity_history_model');

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
        $base_url = base_url() . "user/report/personal_data_export";
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
            redirect('user/select_report/sales_report');
        }
        if (isset($this->session->userdata["inf_week_date1"]) || isset($this->session->userdata["inf_week_date1"])) {

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
            $from_date = $this->session->userdata["inf_week_date1"];
            $to_date = $this->session->userdata["inf_week_date2"];
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
            redirect('user/select_report/sales_report');
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
            redirect('user/select_report/sales_report');
        }
        ///////////////////////////////////
        if ($this->session->userdata("inf_product_sales_id")) {
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
            redirect('user/select_report/sales_report');
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

            $user_name = $this->LOG_USER_NAME;
            $user_id = $this->LOG_USER_ID;
                
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

        if (isset($this->session->userdata["inf_commision_type"])) {
            $from_date = $this->session->userdata["inf_commision_week_date1"];
            $to_date = $this->session->userdata["inf_commision_week_date2"];
            $type = $this->session->userdata["inf_commision_type"];
            $user_id = $this->session->userdata["inf_user_id"];
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
    
    function monthly_payment_report(){
         $title = lang('monthly_payment_report');
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
        $date1 = date('Y-m-d:H:i:s');
        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;
        $count=0;
        if ($this->input->post('search_member_submit')) {
            if (($this->input->post('week_date1') != '') && ($this->input->post('week_date2') != '')) {
                if (($this->input->post('week_date1')) > ($this->input->post('week_date2'))) {
                    $msg = lang('To-Date should be greater than From-Date');
                    $this->redirect($msg, 'report/monthly_payment_report', FALSE);
                }
            }
            
           /* if ($this->input->post("user_name")) {
                $user_name = $this->input->post("user_name", TRUE);
                $user_id = $this->report_model->userNameToID($user_name);
                if (!$user_id) {
                    $msg = lang('invalid_username');
                    $this->redirect($msg, 'report/monthly_payment_report', FALSE);
                }
            }*/
           // $this->set('user_name', $user_name);
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
           // $this->session->set_userdata("inf_user_id", $user_id);
//            if ($type == '') {
//                $msg = lang('enter_amount_type');
//                $this->redirect($msg, 'select_report/commission_report', false);
//            }
           if(empty($this->input->post("week_date1")) && empty($this->input->post("week_date2"))){
                 $msg = lang('select_atleast');
                 $this->redirect($msg, 'report/monthly_payment_report', FALSE);
            }
            $details = $this->report_model->getPaymentDetails($from_date, $to_date, $user_id);
            $count = count($details);
             $this->set('details',$details);
        }
        
        $this->set('count', $count);
       
        $this->setView();
    }
    
    
    public function reward_report() {
        $this->load->model('profile_model');
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

        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;

        $base_url = base_url() . 'user/report/reward_report';
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
            $this->session->set_userdata("inf_user_id", $user_id);
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
        $this->set('user_name', $user_name);
        $this->setView();
    }
}
