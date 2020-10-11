<?php

require_once 'Inf_Controller.php';

class Payout extends Inf_Controller
{

    function __construct()
    {
        parent::__construct();
    }
    //edited for cancel waiting withrawal
    function payout_release_request($action = '', $withdrawed_amount = '')
    {

        $payout_type = $this->configuration_model->getPayOutTypes();
        if ($payout_type == 'from_ewallet') {
            $msg = lang('you_dont_have_permission_to_access_this_page');
            $this->redirect($msg, 'home', FALSE);
        }

        $this->url_permission('ewallet_status');
        $title = lang('Request_Payout_Release');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'payout-release-request';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('Request_Payout_Release');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('Request_Payout_Release');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $this->load->model('ewallet_model');

        $user_id = $this->LOG_USER_ID;
        $minimum_payout_amount = $this->payout_model->getMinimumPayoutAmount();
        $maximum_payout_amount = $this->payout_model->getMaximumPayoutAmount();
        $balance_amount = $this->payout_model->getUserBalanceAmount($user_id);
        $req_amount = $this->payout_model->getRequestPendingAmount($user_id);
        $total_amount = $this->ewallet_model->getTotalReleasedAmount($user_id);
        $config_details = $this->configuration_model->getSettings();
        //$payout_method = $this->payout_model->getUserPayoutType($user_id);

        if ($balance_amount <= $maximum_payout_amount) {
            $available_max_payout = $balance_amount;
        } else {
            $available_max_payout = $maximum_payout_amount;
        }

        if ($action == 'cancel') {

            $res = $this->payout_model->deletePayoutWithdrawed($user_id);
            if ($res) {
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, lang('cancelled_waiting_withdrawal'), $this->LOG_USER_ID);
                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $user_id, 'cancelled_waiting_withdrawal', 'Waiting Withdrawal Cancel');
                }
                //

                $msg = lang('withdrawal_canceled_successfully');
                $this->redirect($msg, 'payout/payout_release_request', TRUE);
            } else {
                $msg = lang('Error_on_deleting_withdrawal');
                $this->redirect($msg, 'payout/payout_release_request', FALSE);
            }
        }
        //ends
        if ($this->MODULE_STATUS['payout_release_status'] == 'ewallet_request') {
            $this->payout_model->setPayoutViewed(0);
            $this->set_header_notification_box();
        }
        
        $bitcoin_details = $this->payout_model->getBitcoinDetails($user_id);
        $this->load->model('Payout_optional_model');
        $payeer_details = $this->validation_model->getPayeerConfig($user_id);
        if ($bitcoin_details != NULL && $payeer_details != NULL) {
            $payout_method = $this->payout_model->gatewayList();
        } elseif ($bitcoin_details == NULL && $payeer_details == NULL) {
            $payout_method = $this->payout_model->getDetails('Payeer', 'Bitcoin');
        } elseif ($payeer_details == NULL) {
            $payout_method = $this->payout_model->getPaymentMethodDetails('Payeer');
        } else {
            $payout_method = $this->payout_model->getPaymentMethodDetails('Bitcoin');
        }

        $this->set('balance_amount', $balance_amount);
        $this->set('req_amount', $req_amount);
        $this->set('total_amount', $total_amount);
        $this->set('min_payout', $minimum_payout_amount);
        $this->set('max_payout', $maximum_payout_amount);
        $this->set('config_details', $config_details);
        $this->set('available_max_payout', $available_max_payout);
        $this->set('payout_method', $payout_method);

        $this->setView();
    }

    function validate_transation_password()
    {
        $this->form_validation->set_rules('payout_amount', lang('payout_amount'), 'trim|required|numeric');
        $this->form_validation->set_rules('transation_password', lang('transaction_password'), 'required');
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    function my_income()
    {

        $title = $this->lang->line('income');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);
        $help_link = 'income-statement';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('income');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('income');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_name = $this->LOG_USER_NAME;
        $this->set('user_name', $user_name);

        $base_url = base_url() . "user/payout/my_income";
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $total_rows = $this->payout_model->getIncomeStatementCount($this->LOG_USER_ID);
        $config['total_rows'] = $total_rows;
        $config["uri_segment"] = 4;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $result_per_page = $this->pagination->create_links();
        $this->set("result_per_page", $result_per_page);
        $this->set("page", $page);

        $binary = $this->payout_model->getIncomeStatement($this->LOG_USER_ID, $page, $config['per_page']);
        $this->set('binary', $binary);

        $this->setView();
    }

    public function validate_payout_request()
    {
        $this->form_validation->set_rules('payout_amount', 'lang:amount', 'trim|required|greater_than[0]');
        $this->form_validation->set_rules('transation_password', 'lang:transaction_password', 'trim|required');
        $validate_form = $this->form_validation->run_with_redirect('payout/payout_release_request');
        return $validate_form;
    }

    function post_payout_release_request()
    {

        if ($this->input->post('payout_request_submit') && $this->validate_payout_request()) {
            $user_id = $this->LOG_USER_ID;

            $kyc_status = $this->MODULE_STATUS['kyc_status'];
            if ($kyc_status == 'yes') {
                $kyc_upload = $this->validation_model->checkKycUpload($user_id);
                if ($kyc_upload != 'yes') {
                    $msg = lang('kyc_not_uploaded');
                    $this->redirect("$msg", 'payout/payout_release_request', FALSE);
                }
            }

            $minimum_payout_amount = $this->payout_model->getMinimumPayoutAmount();
            $maximum_payout_amount = $this->payout_model->getMaximumPayoutAmount();
            $balance_amount = $this->payout_model->getUserBalanceAmount($user_id);
            $req_amount = $this->payout_model->getRequestPendingAmount($user_id);
            $total_amount = $this->payout_model->getReleasedPayoutTotal($user_id);
            $min_payout = $this->configuration_model->getMinPayout();
            $transation_password = base64_decode(urldecode((strip_tags($this->input->post('transation_password', TRUE)))));
            $password_flag = $this->payout_model->checkTransactionPassword($user_id, $transation_password);
            if ($password_flag) {
                $payout_amount = round(($this->input->post('payout_amount', TRUE)) / $this->DEFAULT_CURRENCY_VALUE, 8);
                $request_date = date('Y-m-d H:i:s');
                $balance_amount = $this->payout_model->getUserBalanceAmount($user_id);
                $payout_option = (strip_tags($this->input->post('payment_method', TRUE))); 
                if ($balance_amount >= $payout_amount && $payout_amount >= $minimum_payout_amount && $payout_amount <= $maximum_payout_amount) {
                    $res = $this->payout_model->insertPayoutReleaseRequest($user_id, $payout_amount, $request_date, 'pending',$payout_option);
                    if ($res) {
                        $this->payout_model->updateUserBalanceAmount($user_id, $payout_amount);
                        $data_array = array();
                        $data_array['tran_pass'] = $transation_password;
                        $data_array['payout_amount'] = $payout_amount;
                        $data_array['balance_amount'] = $balance_amount;
                        $data = serialize($data_array);
                        $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Payout request sent ', $this->LOG_USER_ID, $data);

                        $mail_arr['payout_amount'] = $payout_amount;
                        $mail_arr['username'] = $this->LOG_USER_NAME;
                        $mail_arr['email'] = $this->validation_model->getUserEmailId($this->ADMIN_USER_ID);
                        $mail_arr['first_name'] = '';
                        $mail_arr['last_name'] = '';
                        $this->mail_model->sendAllEmails('payout_request', $mail_arr);
                        $msg = $this->lang->line('payout_request_sent_successfully');
                        $this->redirect("$msg", 'payout/payout_release_request', TRUE);
                    } else {
                        $msg = $this->lang->line('payout_request_sending_failed');
                        $this->redirect("$msg", 'payout/payout_release_request', FALSE);
                    }
                } else if ($payout_amount > $balance_amount) {
                    $msg = $this->lang->line('insufficient_balance');
                    $this->redirect($msg, 'payout/payout_release_request', FALSE);
                } else if ($payout_amount <= $minimum_payout_amount) {
                    $default_currency_left_symbol = ($this->DEFAULT_SYMBOL_LEFT != '') ? $this->DEFAULT_SYMBOL_LEFT : "$";
                    $minimum_payout_amount = round(($minimum_payout_amount) * $this->DEFAULT_CURRENCY_VALUE, 8);
                    $msg = $this->lang->line('minimum_amount') . $default_currency_left_symbol . round($minimum_payout_amount);
                    $this->redirect($msg, 'payout/payout_release_request', FALSE);
                } else {
                    $default_currency_left_symbol = ($this->DEFAULT_SYMBOL_LEFT != '') ? $this->DEFAULT_SYMBOL_LEFT : "$";
                    $maximum_payout_amount = round(($maximum_payout_amount) * $this->DEFAULT_CURRENCY_VALUE, 8);
                    $msg = $this->lang->line('maximum_amount') . $default_currency_left_symbol . round($maximum_payout_amount);
                    $this->redirect($msg, 'payout/payout_release_request', FALSE);
                }
            } else {
                $msg = $this->lang->line('invalid_transaction_password');
                $this->redirect($msg, 'payout/payout_release_request', FALSE);
            }
        }
    }

    public function my_withdrawal_request($tab = 'tab1')
    {
        $tab1 = $tab2 = $tab3 = $tab4 = '';
        switch ($tab) {
            case 'tab1':
                $tab1 = ' checked';
                break;
            case 'tab2':
                $tab2 = ' checked';
                break;
            case 'tab3':
                $tab3 = ' checked';
                break;
            case 'tab4':
                $tab4 = ' checked';
                break;
            default:
                $tab1 = ' checked';
        }

        $title = lang('my_withdrawal_status');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('my_withdrawal_status');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('my_withdrawal_status');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = "my_withdrawal_status";
        $this->set("help_link", $help_link);


        $user_id = $this->LOG_USER_ID;

        $pagination1 = new CI_Pagination();
        $base_url1 = base_url() . "user/payout/my_withdrawal_request/tab1";
        $config1 = $pagination1->customize_style();
        $config1['base_url'] = $base_url1;
        $config1['per_page'] = $this->PAGINATION_PER_PAGE;
        $total_rows1 =  $this->payout_model->getPayoutWithdrawalCount($user_id, 'pending');
        $config1['total_rows'] = $total_rows1;
        $config1["uri_segment"] = 5;
        $pagination1->initialize($config1);
        if ($tab == 'tab1') {
            $page1 = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        } else {
            $page1 = 0;
        }
        $result_per_page1 = $pagination1->create_links();
        $this->set("result_per_page1", $result_per_page1);
        $this->set("page1", $page1);

        $pagination2 = new CI_Pagination();
        $base_url2 = base_url() . "user/payout/my_withdrawal_request/tab2/tab2";
        $config2 = $pagination2->customize_style();
        $config2['base_url'] = $base_url2;
        $config2['per_page'] = $this->PAGINATION_PER_PAGE;
        $total_rows2 = $this->payout_model->getReleasedWithdrawalCount($user_id, 'approved_pending');
        $config2['total_rows'] = $total_rows2;
        $config2["uri_segment"] = 6;
        $pagination2->initialize($config2);
        if ($tab == 'tab2') {
            $page2 = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
        } else {
            $page2 = 0;
        }
        $result_per_page2 = $pagination2->create_links();
        $this->set("result_per_page2", $result_per_page2);
        $this->set("page2", $page2);

        $pagination3 = new CI_Pagination();
        $base_url3 = base_url() . "user/payout/my_withdrawal_request/tab3/tab3/tab3";
        $config3 = $pagination3->customize_style();
        $config3['base_url'] = $base_url3;
        $config3['per_page'] = $this->PAGINATION_PER_PAGE;
        $total_rows3 = $this->payout_model->getReleasedWithdrawalCount($user_id, 'approved_paid');
        $config3['total_rows'] = $total_rows3;
        $config3["uri_segment"] = 7;
        $pagination3->initialize($config3);
        if ($tab == 'tab3') {
            $page3 = ($this->uri->segment(7)) ? $this->uri->segment(7) : 0;
        } else {
            $page3 = 0;
        }
        $result_per_page3 = $pagination3->create_links();
        $this->set("result_per_page3", $result_per_page3);
        $this->set("page3", $page3);

        $pagination4 = new CI_Pagination();
        $base_url4 = base_url() . "user/payout/my_withdrawal_request/tab4/tab4/tab4/tab4";
        $config4 = $pagination4->customize_style();
        $config4['base_url'] = $base_url4;
        $config4['per_page'] = $this->PAGINATION_PER_PAGE;
        $total_rows4 =  $this->payout_model->getPayoutWithdrawalCount($user_id, 'deleted');
        $config4['total_rows'] = $total_rows4;
        $config4["uri_segment"] = 8;
        $pagination4->initialize($config4);
        if ($tab == 'tab4') {
            $page4 = ($this->uri->segment(8)) ? $this->uri->segment(8) : 0;
        } else {
            $page4 = 0;
        }
        $result_per_page4 = $pagination4->create_links();
        $this->set("result_per_page4", $result_per_page4);
        $this->set("page4", $page4);

        $active_requests = $this->payout_model->getPayoutWithdrawalDetails($user_id, 'pending', $config1['per_page'], $page1);
        $waiting_requests =   $this->payout_model->getReleasedWithdrawalDetails($user_id, 'approved_pending', $config2['per_page'], $page2);
        $paid_requests = $this->payout_model->getReleasedWithdrawalDetails($user_id, 'approved_paid', $config3['per_page'], $page3);
        $rejected_requests = $this->payout_model->getPayoutWithdrawalDetails($user_id, 'deleted', $config4['per_page'], $page4);

        $this->set("base_url", $this->BASE_URL);

        $this->set("active_requests", $this->security->xss_clean($active_requests));
        $this->set("waiting_requests", $this->security->xss_clean($waiting_requests));
        $this->set("paid_requests", $this->security->xss_clean($paid_requests));
        $this->set("rejected_requests", $this->security->xss_clean($rejected_requests));

        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);
        $this->set('tab3', $tab3);
        $this->set('tab4', $tab4);

        $this->setView();
    }
}
