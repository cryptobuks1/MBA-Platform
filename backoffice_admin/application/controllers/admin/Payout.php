<?php

require_once 'Inf_Controller.php';
require "../vendor/autoload.php";

define("IN_WALLET", true);

use Blocktrail\SDK\BlocktrailSDK;

class Payout extends Inf_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('profile_model');
        $this->load->model('mail_model');
        $this->load->model('validation_model');
        $this->load->model('excel_model');
        $this->load->model('payout_class_model');
        $this->load->model('payout_optional_model');
        $this->config->set_item('csrf_exclude_uris', 'payout/bitgo_trans_approved');
    }

    function payout_release($action = '', $del_id = '', $user_name = '', $payout_type = '')
    {
        $title = $this->lang->line('payout_release');
        $this->set("title", $this->COMPANY_NAME . " | " . $title);

        $help_link = 'release-payout';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('payout_release');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('payout_release');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $payment_method = $this->payout_model->gatewayList();
        $payment_selected = "";

        if ($this->input->get('payment')){
            $payment_selected = $this->input->get('payment');
        }
        $this->set('payment', $payment_selected);

        if ($action == 'delete') {
            $user_id = $this->validation_model->userNameToID($user_name);
            $this->session->set_flashdata('user_payment_type', $payout_type);
            if (!$user_id) {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'payout/payout_release', false);
            }
            $res = $this->payout_model->deletePayoutRequest($del_id, $user_id);
            if ($res) {
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, lang('payout_request_deleted'), $this->LOG_USER_ID);
                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $user_id, 'delete_payout_request', 'Payout Request Deleted');
                }
                //

                $msg = lang('Payout_Request_Deleted_Successfully');
                $this->redirect($msg, 'payout/payout_release', true);
            } else {
                $msg = lang('Error_on_deleting_Payout_Request');
                $this->redirect($msg, 'payout/payout_release', false);
            }
        }
        //IMS-144 Payout release request changes
        if ($this->uri->segment(4) == "" || $this->uri->segment(4) == 'tab1') {
            $tab1 = ' active';
            $tab2 = null;
            $active_tab = 'tab1';
        } else {
            $tab2 = ' active';
            $tab1 = null;
            $active_tab = 'tab2';
        }
        //end
        $payout_release_type = $this->MODULE_STATUS['payout_release_status'];
        $payout_amount = 0;
        $tab_title = '';
        $payment_type = 'payeer';

        if ($this->session->flashdata('user_payment_type')) {
            $payment_type = $this->session->flashdata('user_payment_type');
        }

        if ($this->input->post('search')) {
            $payment_type = $this->input->post('payment_method');
        }
        //IMS-144 Payout release request changes
        if ($payout_release_type == 'both') {
            $pagination1 = new CI_Pagination();
            $base_url1 = base_url() . "admin/payout/payout_release/tab1/";
            $config1 = $pagination1->customize_style();
            $config1['base_url'] = $base_url1;
            $config1['per_page'] = $this->PAGINATION_PER_PAGE;

            $pagination2 = new CI_Pagination();
            $base_url2 = base_url() . "admin/payout/payout_release/tab2/";
            $config2 = $pagination1->customize_style();
            $config2['base_url'] = $base_url2;
            $config2['per_page'] = $this->PAGINATION_PER_PAGE;

            $payout_details1 = $this->payout_model->getPayoutDetails('from_ewallet', '', '', $payment_type);
            $payout_details2 = $this->payout_model->getPayoutDetails('ewallet_request', '', '', $payment_type);
            if ($payout_details2) {
                $this->payout_model->setPayoutViewed(1);
                $this->set_header_notification_box();
            }


            $total_rows1 = count($payout_details1);
            $config1['total_rows'] = $total_rows1;
            $config1["uri_segment"] = 5;
            $pagination1->initialize($config1);
            if ($this->uri->segment(4) == 'tab1') {
                $page1 = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
            } else {
                $page1 = 0;
            }
            $start1 = $page1;
            $end1 = $page1 * $config1['per_page'] + $config1['per_page'];
            $result_per_page1 = $pagination1->create_links();
            $this->set("result_per_page1", $result_per_page1);
            $this->set('start1', $start1 + 1);

            $total_rows2 = count($payout_details2);
            $config2['total_rows'] = $total_rows2;
            $config2["uri_segment"] = 5;
            $pagination2->initialize($config2);
            if ($this->uri->segment(4) == 'tab2') {
                $page2 = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
            } else {
                $page2 = 0;
            }
            $start2 = $page2;
            $end2 = $page2 * $config2['per_page'] + $config2['per_page'];
            $result_per_page2 = $pagination2->create_links();
            $this->set("result_per_page2", $result_per_page2);
            $this->set('start2', $start2 + 1);

            $payout_details1 = array_slice($payout_details1, $start1, $config1['per_page']);
            $payout_details2 = array_slice($payout_details2, $start2, $config2['per_page']);
        } else {
            $pagination = new CI_Pagination();
            $base_url = base_url() . "admin/payout/payout_release";
            $config = $pagination->customize_style();
            $config['base_url'] = $base_url;
            $config['per_page'] = $this->PAGINATION_PER_PAGE;

            $payout_details = $this->payout_model->getPayoutDetails($payout_release_type, '', '', $payment_type);
           
            // $array = array("binary_commission", "fast_start_bonus", "renewal_fast_start_bonus", "global_bonus");
            
            // $comms_array = $this->excel_model->getCommissionReport("2020-07-01", "2020-07-15", $array, "23334");

            // echo "ss<pre>";print_r($csv_array);die;

            // echo "ss<pre>";print_r($payout_details);die;

            $tab_title = lang('from_e_wallet');
            if ($payout_release_type == 'ewallet_request') {
                $this->payout_model->setPayoutViewed(1);
                $this->set_header_notification_box();
                $tab_title = lang('e_wallet_request');
            }
            $total_rows = count($payout_details);

            $config['total_rows'] = $total_rows;
            $config["uri_segment"] = 4;
            $pagination->initialize($config);
//            if ($this->uri->segment(4) != "")
//                $page = $this->uri->segment(4);
//            else
//                $page = 0;
            if ($this->uri->segment(4)) {
                $page =( ($this->uri->segment(4)) ? $this->uri->segment(4) : 0);
            } else {
                $page = 0;
            }
            $start = $page;
            $end = $page * $config['per_page'] + $config['per_page'];
            $result_per_page = $pagination->create_links();
            $this->set("result_per_page", $result_per_page);
            $this->set('start', $start + 1);
            $payout_details = array_slice($payout_details, $start, $config['per_page']);//echo $start."<pre>".$config['per_page'];print_r($payout_details);die;
        }

        $min_max_payout_amount = $this->payout_model->getMinimumMaximunPayoutAmount();

//Optimization Starts
//Optimization Starts


//Optimization Ends

        if ($this->session->userdata('inf_config_tab_active_arr')) {
            $tab_arr = $this->session->userdata('inf_config_tab_active_arr');
            $tab1 = $tab_arr['tab1'];
            $tab2 = $tab_arr['tab2'];
            $this->session->unset_userdata('inf_config_tab_active_arr');
        }
        if ($payout_release_type == 'both') {

            $count_details1 = count($payout_details1);
            $this->set('payout_details1', $payout_details1);
            $this->set('payout_amount1', $payout_amount);
            $this->set('count1', $count_details1);
            $count_details2 = count($payout_details2);
            $this->set('payout_details2', $payout_details2);
            $this->set('payout_amount2', $payout_amount);
            $this->set('count2', $count_details2);
        } else {
            $count_details = count($payout_details);
            $this->set('payout_details', $payout_details);
            $this->set('payout_amount', $payout_amount);
            $this->set('count', $count_details);
        }
        $this->set('gateway_list', $payment_method);
        $this->set('payment_type', $payment_type);
        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);
        $this->set('tab_title', $tab_title);
        //end
        $this->setView();
    }

    function my_income()
    {
        $title = lang('incentive');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'income-statement';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('released_income');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('released_income');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if ($this->input->post('user_name')) {
            $user_name = ($this->input->post('user_name', true));
            $user_id = $this->validation_model->userNameToID($user_name);
            if (!$user_id) {
                $this->session->unset_userdata('search_user_id');
                $msg = lang('Username_not_Exists');
                $this->redirect($msg, 'payout/my_income', false);
            }
            $this->session->set_userdata('search_user_id', $user_id);
        }

        if ($this->session->has_userdata('search_user_id')) {
            $user_id = $this->session->userdata('search_user_id');
            $user_name = $this->validation_model->IdToUserName($user_id);

            $base_url = base_url() . 'admin/payout/my_income';
            $config = $this->pagination->customize_style();
            $config['base_url'] = $base_url;
            $config['per_page'] = $this->PAGINATION_PER_PAGE;

            if ($this->uri->segment(4) != "") {
                $page = $this->uri->segment(4);
            } else {
                $page = 0;
            }

            $count = $this->payout_model->getIncomeStatementCount($user_id);
            $income_statement = $this->payout_model->getIncomeStatement($user_id, $page, $config['per_page']);

            $config['total_rows'] = $count;
            $this->pagination->initialize($config);
            $result_per_page = $this->pagination->create_links();

            $this->set('result_per_page', $result_per_page);
            $this->set('page_id', $page);
            $this->set('valid_user', true);
            $this->set('user_name', $user_name);
            $this->set('income_statement', $income_statement);
        } else {
            $this->set('valid_user', false);
        }

        $this->setView();
    }

    function validate_transation_password()
    {
        $this->form_validation->set_rules('payout_amount', lang('payout_amount'), 'trim|required|numeric');
        $this->form_validation->set_rules('transation_password', lang('transation_password'), 'required');
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    public function user_details($user_name = '')
    {
        $user_id = $this->validation_model->userNameToID($user_name);
        if (!$user_id) {
            exit();
        }
        $user_details = $this->payout_model->getUserDetails($user_id);
        $user_details = $this->security->xss_clean($user_details);

        $this->set('user_details', $user_details);

        $this->setView();
    }

    //mark as paid
    public function mark_paid()
    {
        $title = $this->lang->line('mark_as_paid');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $this->HEADER_LANG['page_top_header'] = lang('mark_as_paid');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('mark_as_paid');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $from1 = $this->session->userdata('inf_from1');
        $this->set('from1', $from1);
        $to1 = $this->session->userdata('inf_to1');
        $this->set('to1', $to1);


        $form_submit = false;
        // $result_per_page = 0;
        $session = false;


//        if (($this->input->post('submit_date')) && $this->validate_date_field()) {
        if (($this->input->post('submit_date'))) {

            $date_post_array = $this->input->post(null, true);
            $date_post_array = $this->validation_model->stripTagsPostArray($date_post_array);
            if (strtotime($date_post_array['start_date']) == '' && strtotime($date_post_array['end_date']) == '') {
                $msg = lang('please_select_either_from_or_to_date');
                $this->redirect($msg, 'payout/mark_paid', false);
            }
            if (strtotime($date_post_array['start_date']) != '' && strtotime($date_post_array['end_date']) != '' && strtotime($date_post_array['start_date']) > strtotime($date_post_array['end_date'])) {
                $msg = lang('from_date_greater_than_to_date');
                $this->redirect($msg, 'payout/mark_paid', false);
            } else {
                $form_submit = true;
                if ($date_post_array['start_date'] != '') {
                    $from_date = $date_post_array['start_date'] . ' 00:00:00';
                } else {
                    $from_date = '';
                }
                if ($date_post_array['end_date'] != '') {
                    $to_date = $date_post_array['end_date'] . ' 23:59:59';
                } else {
                    $to_date = '';
                }


                $this->session->set_userdata('from_date', $from_date);
                $this->session->set_userdata('to_date', $to_date);
            }
        }

        $base_url = base_url() . 'admin/payout/mark_paid';
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        if ($this->uri->segment(4) != "")
            $page = $this->uri->segment(4);
        else
            $page = 0;


        if (isset($this->session->userdata)) {
            $session = true;
            $from_date = $this->session->userdata('from_date');
            $to_date = $this->session->userdata('to_date');
        }

        $payout_details = $this->payout_model->getReleasedPayout($from_date, $to_date, $config['per_page'], $page);
        $payout_count = $this->payout_model->getPayoutCount($from_date, $to_date);


        $length = count($payout_details);
        $count = $payout_count;



        $config['total_rows'] = $count;


        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();


        if ($this->input->post('marksw')) {
            $result = false;
            $post_arr = $this->input->post(null, true);
            $marked = false;
            for ($i = 1; $i <= $length; $i++) {
                if (array_key_exists('mark_paid' . $i, $post_arr)) {
                    $data_array = null;
                    $marked = true;
                    $request_id = $post_arr['paid_id' . $i];
                    $paid_amount = $post_arr['paid_amount' . $i];
                    $user_name = $post_arr['user_name' . $i];
                    $user_id = $this->validation_model->userNameToID($user_name);

                    $result = $this->payout_model->updateBankTransactionStatus($request_id, $user_id, $paid_amount);
                    if ($result) {
                        $data_array['paid_id'] = $request_id;
                        $data_array['paid_amount'] = $paid_amount;
                        $data_array['user_name'] = $user_name;
                        $data_array['user_id'] = $user_id;
                        $data = serialize($data_array);

                        $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Payout marked as paid ', $this->LOG_USER_ID, $data);

                        // Employee Activity History
                        if ($this->LOG_USER_TYPE == 'employee') {
                            $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Payout marked as paid for ' . $user_name . ' and amount is ' . $paid_amount, 'Payout Marked as paid');
                        }
                    }
                }
            }
            if ($result) {

                $msg = lang('payout_marked_as_paid');
                $this->redirect($msg, 'payout/mark_paid', true);
            } else {
                if ($marked == false) {
                    $msg = lang('please_select_at_least_one_checkbox');
                    $this->redirect($msg, 'payout/mark_paid', false);
                } else {
                    $msg = lang('payout_marking_failed');
                    $this->redirect($msg, 'payout/mark_paid', false);
                }
            }
        }

        $this->set('result_per_page', $result_per_page);
        $this->set('page_id', $page);


        $this->set('length', $length);
        $this->set('payout_details', $payout_details);

        $this->set('form_submit', $form_submit);
        $this->set('session', $session);
        $this->setView();
    }

    function validate_date_field()
    {
        $this->form_validation->set_rules('start_date', lang('start_date'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('end_date', lang('end_date'), 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    //mark as paid ends

    /* Blockchain Payout Related Functions Begin */
    function get_rate_for_one_bitcoin()
    {
        $url = "https://blockchain.info/ticker";
        $data = $this->curl($url);
        return $data;
    }

    public function get_admin_wallet_balance($blockchain_details)
    {
        $guid = $blockchain_details['my_api_key'];
        $main_password = $blockchain_details['main_password'];
        $url = "http://localhost:3000/merchant/$guid/balance?password=$main_password";
        $data = $this->curl($url);
        return $data;
    }

    public function send_bitcoin($blockchain_details, $btc_send_amount, $address)
    {

        // $btc_send_amount=0.5;
        $amount = $btc_send_amount * 100000000;
        $guid = $blockchain_details['my_api_key'];
        $main_password = $blockchain_details['main_password'];
        $second_password = $blockchain_details['second_password'];
        $fee = $blockchain_details['fee'];
        $url = "http://localhost:3000/merchant/$guid/payment?password=$main_password&second_password=$second_password&to=$address&amount=$amount&from=0&fee=$fee";
        $data = $this->curl($url);
        return $data;
    }

    function curl($url)
    {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'bereal');
        $result = curl_exec($curl_handle);
        curl_close($curl_handle);
        $info = json_decode($result, true);
        return $info;
    }

    function encrypt_decrypt()
    {
        $data = "rishad";
        $encrypted_data = $this->encrypt->encode($data);
        echo "Encrypted Data : " . $encrypted_data;
        $decrypted_data = $this->encrypt->decode($encrypted_data);
        echo "</br>Decrypted Data : " . $decrypted_data;
        die();
    }

    public function test_blockchain()
    {
        $blockchain_details = $this->payout_optional_model->getBlockchainDetails();
        $data = $this->get_admin_wallet_balance($blockchain_details);
        print_r($data);
        die();
    }

    /* Blockchain Payout Related Functions Ends */

    /* Bitgo Payout Related Functions Begins */
    /*
      Run these commands :
      git clone https://github.com/BitGo/BitGoJS
      cd BitGoJS
      npm install
      sudo service apache2 restart
     */

    public function send_bitgo_bitcoin($btc_send_amount = 0, $address)
    {

        $bitgo_details = $this->payout_optional_model->getBitgoDetails();
        $wallet_id = $bitgo_details['wallet_id'];
        $token = $bitgo_details['token'];
        $pasphrase = $bitgo_details['passphrase'];

        /* $token = "v2x43f95c1c82db98d40fc72dfa01f93e2fa4abb0cd40596d417e0e0df2821582eb";
         * Test Tocken with transfer amount greater than zero
         *          */
        //test data{
        $btc_send_amount = 00010000;
        $address = "2N6dmW86GD2yeCGVU6Na1AS18daDgh7bBuR";
        //}

        $data['address'] = $address;
        $data['amount'] = $btc_send_amount;
        $data['walletPassphrase'] = $pasphrase;
        $field_string = json_encode($data);

        $ch = curl_init();
        $url = "http://localhost:3080/api/v1/wallet/$wallet_id/sendcoins";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $field_string);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $headers = array();
        $headers[] = "Authorization: Bearer $token";
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        $info = json_decode($result);
        curl_close($ch);

        return $result;
    }

    public function send_bitgo_mass_payout($recipients_arr = "")
    {

        $bitgo_details = $this->payout_optional_model->getBitgoDetails();
        $wallet_id = $bitgo_details['wallet_id'];
        $token = $bitgo_details['token'];
        $pasphrase = $bitgo_details['passphrase'];

        $recipients_arr['walletPassphrase'] = $pasphrase;
        $field_string = json_encode($recipients_arr);

        $ch = curl_init();
        $url = "http://localhost:3080/api/v1/wallet/$wallet_id/sendmany";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $field_string);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $headers = array();
        $headers[] = "Authorization: Bearer $token";
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        $info = json_decode($result, true);
        curl_close($ch);

        return $info;
    }

    public function bitgo_wallet_balance()
    {

        $data = $this->payout_optional_model->getBitgoDetails();
        $wallet_id = $data['wallet_id'];
        $token = $data['token'];
        if ($data['mode'] == 'test') {
            $url = "https://test.bitgo.com/api/v1/wallet/$wallet_id";
        } else {
            $url = "https://bitgo.com/api/v1/wallet/$wallet_id";
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $headers = array();
        $headers[] = "Authorization: Bearer $token";
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        $info = json_decode($result, true);
        curl_close($ch);
        $balance = $info['balance'] / 100000000;
        return $balance;
    }

    public function bitgo_service_status()
    {
        /*

         * After Install Bitgo-express
         * Open terminal
         * Locate : BitGoJS/bin
         * Run : "./bitgo-express --debug --port 3080 --env test --bind localhost"
         *
         *  Do not Close terminal
         */

        $ch = curl_init();
        $url = "http://localhost:3080/api/v1/ping";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $info = json_decode($result, true);
        curl_close($ch);
        if ($info['status'] == "service is ok!")
            return true;
        else
            return false;
    }

    public function bitgo_trans_approved()
    {
        /*

         * Login your bitgo account & Choose your Wallet.
         * Goto Settings->Developer options->Add Webhook
         * Create One with URL "https://yourdomain.com/{path}/bitgo_trans_approved"
         * Choose "Transaction" as event.
         *
         */
        //test data{
        $response = '{
  "type": "transaction",
  "walletId": "2MwLxgWaAGmMT9asT4nAdeewWzPEz3Sn5Eg",
  "hash": "fd60b6a7da6c56ddc7e55b94bf76f0df7ea34d6fbc07a232f82e2964b94a925e"
}';
        //}

        $decode_res = array();
        $decode_res = json_decode($response, true);
        $data = $this->payout_optional_model->updateTransactionStatus('', '', '', $decode_res['hash']);
    }

    /* Bitgo Payout Related Functions End */

    /* Blocktrail Related Function Begins */

    public function blocktrail_send($bitcoin_history_id, $data, $wallet)
    {
        $user_id = $data['user_id'];
        $amount_payable = $data['amount_payable'];
        $bitcoin_address = $data['bitcoin_address'];
        $sendAmount = $data['bitcoin_amount'];
        $user_name = $this->validation_model->IdToUserName($user_id);
        $failed_users = '';

        try {
            // Send bitcoins to our newly created address.
            // of course, our wallet would first needs to have a positive balance to be able to send :)

            list($confirmedBalance, $unconfirmedBalance) = $wallet->getBalance();

            $confirmedBalance = BlocktrailSDK::toBTC($confirmedBalance);
            $unconfirmedBalance = BlocktrailSDK::toBTC($unconfirmedBalance);
            if ($confirmedBalance >= $sendAmount) {
                $satoshi = BlocktrailSDK::toSatoshi($sendAmount);
                $txHash = $wallet->pay(array($bitcoin_address => $satoshi));
                if ($txHash) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            } else {
                $msg = lang('payout_release_failed');
                $msg1 = lang('low_balance');
                $this->redirect($msg . " \n" . $msg1, 'payout/payout_release', false);
            }
        } catch (Exception $e) {
            $date = date("Y-m-d H:i:s");
            $data = array(
                'bitcoin_history_id' => $bitcoin_history_id,
                'from_user' => $this->ADMIN_USER_ID,
                'to_user_id' => $user_id,
                'amount_payable' => $amount_payable,
                'error_reason' => $e->getMessage(),
                'date' => $date,
                'bitcoin_amount' => $sendAmount,
                'bitcoin_address' => $bitcoin_address
            );
            $this->db->insert('bitcoin_payout_release_error_report', $data);
            $flag = false;
            $failed_users .= $user_name . "  ";
            $this->session->set_userdata('failed_users', $failed_users);
            $this->session->set_userdata('reason', $e->getMessage());
            $msg = lang("{$e->getMessage()}");
            $this->redirect($msg, 'payout/payout_release', false);
            //print_r($e->getMessage());die();
            // print "Sending bitcoins failed because {$e->getMessage()}";
        }
        return $txHash;
    }

    public function blocktrail_amount_conversion()
    {

        $bitcoin_price = 1;
       // $currency = $this->DEFAULT_CURRENCY_CODE;
        $currency = 'USD';
        //echo $currency; die;
        if ($currency != "BTC") {
            $url = 'https://bitpay.com/api/rates/' . $currency;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15"));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 500);
            $result = curl_exec($ch);
            curl_close($ch);
            $info = json_decode($result, true);
            
            $bitcoin_price = $info['rate'];
            //echo $bitcoin_price; die;
        }
        return $bitcoin_price;
    }

    /* Blocktrail Related Function Ends */
    /* Optimization Starts */

    public function sendMailtouser($user_id, $type)
    {

        $send_details = array();
        $email = $this->validation_model->getUserEmailId($user_id);
        $send_details['full_name'] = $this->validation_model->getUserFullName($user_id);
        $send_details['email'] = $email;
        $send_details['first_name'] = $this->validation_model->getUserData($user_id, "user_detail_name");
        $send_details['last_name'] = $this->validation_model->getUserData($user_id, "user_detail_second_name");
        //$this->mail_model->sendAllEmails($type, $send_details);
        return true;
    }

    public function BlocktrailPayout($user_id, $payout_release_amount, $payout_release_type, $request_id, $bitcoin_price, $wallet, $release_req_type, $method)
    {
        $sendAmount = round($payout_release_amount / $bitcoin_price, 8);
        $bitcoin_address = $this->payout_model->getBitcoinAddress($user_id);
        if ($bitcoin_address == '' || $bitcoin_address == 'NA') {
            $msg = lang('invalid_bitcoin_address');
            $this->redirect($msg, 'payout/payout_release', false);
        }
        $data['user_id'] = $user_id;
        $data['amount_payable'] = $payout_release_amount;
        $data['from_user'] = $this->ADMIN_USER_ID;
        $data['bitcoin_address'] = $bitcoin_address;
        $data['bitcoin_price'] = $bitcoin_price;
        $data['bitcoin_amount'] = $sendAmount;
        $amount_payable = $payout_release_amount;
        $bitcoin_history_id = $this->register_model->bitcoinHistory($user_id, $data, 'payout_release');
        $txHash = $this->blocktrail_send($bitcoin_history_id, $data, $wallet);
        if ($txHash) {
            $return_address = $bitcoin_address;
            $update_status = $this->payout_model->updatePayoutReleaseRequest($user_id, $request_id, $payout_release_amount, $payout_release_type, $method, $txHash);
            $result = $this->register_model->insertInToBitcoinPaymentDetails($bitcoin_history_id, $user_id, 'payout_released', $payout_release_amount, $bitcoin_price, $sendAmount, $sendAmount, $bitcoin_address, $txHash, $return_address);
            if ($release_req_type == "from_ewallet")
                $result1 = $this->payout_model->updateUserBalanceAmount($user_id, $payout_release_amount);
            $this->payout_optional_model->updateTransactionStatus($request_id, $user_id, $payout_release_amount, $txHash);
            if ($result) {
                $result = $this->register_model->updateBitcoinHistory($user_id, $bitcoin_history_id, 'yes');
                return true;
            }
        }
        return false;
    }

    public function BlockchainPayout($user_id, $payout_release_amount, $request_id, $recent_bitcoin_rate, $blockchain_details, $btc_transaction_fee, $system_currency, $payout_release_type, $release_req_type, $admin_btc_balance)
    {
        $btc_send_amount = round($payout_release_amount / $recent_bitcoin_rate, 8);
        $user_bitcoin_address = $this->payout_optional_model->getUserBitcoinAddress($user_id);
        if ($user_bitcoin_address == '' || $user_bitcoin_address == 'NA') {
            $msg = lang('invalid_bitcoin_address');
            $this->redirect($msg, 'payout/payout_release', false);
        }
        $btc_send_response = $this->send_bitcoin($blockchain_details, $btc_send_amount, $user_bitcoin_address);
        if (isset($btc_send_response['success']) && $btc_send_response['success']) {
            $result = true;
            $this->payout_model->commit();
            $message = $btc_send_response['message'];
            $tx_hash = $btc_send_response['tx_hash'];
            $btc_admin_debit = $btc_send_amount + $btc_transaction_fee;
            $admin_btc_balance = $admin_btc_balance - $btc_admin_debit;
            $status = $this->payout_optional_model->insertIntoBitcoinPayoytReleaseHistory($btc_send_response['success'], $message, $user_id, $admin_btc_balance, $payout_release_amount, $system_currency, $recent_bitcoin_rate, $btc_send_amount, $user_bitcoin_address, $btc_send_response, $btc_transaction_fee, $btc_admin_debit, $tx_hash, $payout_release_type);

            if ($release_req_type == "from_ewallet")
                $result1 = $this->payout_model->updateUserBalanceAmount($user_id, $payout_release_amount);
            $this->payout_optional_model->updateTransactionStatus($request_id, $user_id, $payout_release_amount);
        } else {
            $this->payout_model->rollback();
            $message = $btc_send_response['error'];
            $status = $this->payout_optional_model->insertIntoBitcoinPayoytReleaseHistory(0, $message, $user_id, $admin_btc_balance, $payout_release_amount, $system_currency, $recent_bitcoin_rate, $btc_send_amount, $user_bitcoin_address, $btc_send_response, $btc_transaction_fee, '', '', $payout_release_type);
            $this->redirect($message, 'payout/payout_release', false);
        }
    }

    public function BitgoPayout($user_id, $payout_release, $total_amount, $bitgo_arr, $btc_transaction_fee, $request_id, $payout_release_type, $check_status, $type, $release_req_type, $method)
    {

        $count_pay_release = count($payout_release);
        if ($count_pay_release) {
            $bitgo_btc_send_response = $this->send_bitgo_mass_payout($payout_release);

            if (isset($bitgo_btc_send_response['status']) && $bitgo_btc_send_response['status'] == "accepted") {
                $result = true;
                $this->payout_model->commit();
                $count_bitgo_release = 0;
                $admin_btc_balance = $this->bitgo_wallet_balance();
                if ($admin_btc_balance < $total_amount) {
                    $message = lang('not_enough_balance_in_bitgo_wallet');
                    $this->redirect($message, 'payout/payout_release', false);
                }
                while ($count_bitgo_release < count($bitgo_arr)) {
                    $btc_admin_debit = $bitgo_arr[$count_bitgo_release]['amount'] + $btc_transaction_fee;
                    $admin_btc_balance = $admin_btc_balance - $btc_admin_debit;
                    $status = $this->payout_optional_model->insertIntoBitGoPayoutHistory($bitgo_btc_send_response, $bitgo_arr[$count_bitgo_release], $admin_btc_balance, $btc_transaction_fee, $btc_admin_debit);

                    if ($release_req_type == "from_ewallet")
                        $result1 = $this->payout_model->updateUserBalanceAmount($bitgo_arr[$count_bitgo_release]['user_id'], $bitgo_arr[$count_bitgo_release]['payout_release_amount']);
                    $result = $this->payout_model->updatePayoutReleaseRequest($request_id, $bitgo_arr[$count_bitgo_release]['user_id'], $bitgo_arr[$count_bitgo_release]['payout_release_amount'], $release_req_type, $method, $bitgo_btc_send_response['hash']);
                    $count_bitgo_release++;
                }
                $cnt = count($bitgo_arr);
                if ($cnt && $check_status == 'yes') {
                    for ($i = 0; $i < $cnt; $i++) {
                        $this->sendMailtouser($bitgo_arr[$i]['user_id'], $type);
                    }
                }
            } elseif (isset($bitgo_btc_send_response['error'])) {
                $this->payout_model->rollback();
                $data = array(
                    'bitcoin_history_id' => 0,
                    'from_user' => $this->ADMIN_USER_ID,
                    'to_user_id' => $user_id,
                    'amount_payable' => $payout_release[0]['amount_payable'],
                    'error_reason' => $bitgo_btc_send_response['message'],
                    'date' => date('Y-m-d h:i:s'),
                    'bitcoin_amount' => $payout_release[0]['amount'],
                    'bitcoin_address' => $payout_release[0]['address'],
                    'payment_type' => "Bitgo"
                );
                $this->db->insert('bitcoin_payout_release_error_report', $data);

                $message = lang('error_occurred') . $bitgo_btc_send_response['message'];
                $this->redirect($message, 'payout/payout_release', false);
            }
        }
    }

    public function PayPalPayout($payout_release, $total_amount, $base_call, $paypal_arr, $payout_release_arr, $check_status, $type)
    {
        $count_pay_release = count($payout_release);

        if ($count_pay_release) {
            $paypal_balance = $this->payout_optional_model->PayPalBalance();

            if ($paypal_balance < $total_amount) {
                $this->redirect(lang('not_enough_balance_in_paypal'), "payout/payout_release", false);
            } else {
                $result = $this->payout_optional_model->massPay($base_call, $payout_release, $total_amount);
                if ($result) {
                    $cnt = count($paypal_arr);
                    if ($cnt && $check_status == 'yes') {
                        for ($i = 0; $i < $cnt; $i++) {
                            $this->sendMailtouser($paypal_arr[$i]['user_id'], $type);
                        }
                    }
                    $this->payout_optional_model->massPayoutHistory($payout_release_arr);
                    return true;
                } else {
                    $this->redirect(lang('Payout_Release_Failed'), "payout/payout_release", false);
                }
            }
        }
    }

    /* Optimization Ends */

    public function post_payout_release()
    {
        if ($this->uri->segment(4) == "" || $this->uri->segment(4) == 'tab1') {
            $tab1 = ' active';
            $tab2 = null;
            $active_tab = 'tab1';
        } else {
            $tab2 = ' active';
            $tab1 = null;
            $active_tab = 'tab2';
        }

        $min_max_payout_amount = $this->payout_model->getMinimumMaximunPayoutAmount();

        if ($this->input->post()) {
            $post_arr = $this->input->post(null, true);
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $otp_stat = $this->getOtpStat(true);//print_r($post_arr); die;
            if ($otp_stat) {
                $otp = $post_arr['otp'] ?? false;
                if ($otp) {
                    if (!empty($this->session->userdata('payout_otp'))) {

                        if ($otp == $this->session->userdata('payout_otp')) {
                            $this->session->unset_userdata('payout_otp');
                        } else {
                            $msg = lang('invalid_otp');
                            $this->redirect($msg, 'payout/payout_release', false);
                        }
                    } else {
                        $msg = lang('otp_expired');
                        $this->redirect($msg, 'payout/payout_release', false);
                    }
                } else {
                    $msg = lang('otp_required');
                    $this->redirect($msg, 'payout/payout_release', false);
                }
            }
            $count = $post_arr['table_rows'];
            $payout_release_type = $this->MODULE_STATUS['payout_release_status'];
            $kyc_status = $this->MODULE_STATUS['kyc_status'];
            $result = false;
            if ($payout_release_type == "both") {
                $active_tab = $post_arr['current_tab'];
            }
            $this->session->set_userdata('inf_config_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2));

            $j = 0;
            $payout_release_arr = array();
            $payout_release = array();
            $paypal_arr = array();
            $base_call = '';
            $total_amount = 0;

            if ($post_arr['payment_method'] == "Blockchain" && $this->validate_payment_method()) {
                $blockchain_details = $this->payout_optional_model->getBlockchainDetails();
                $blockchain_details['main_password'] = null;
                $blockchain_details['second_password'] = null;
                $blockchain_details['main_password'] = $this->input->post('main_password', true);
                $blockchain_details['second_password'] = $this->input->post('second_password', true);
                if (empty($blockchain_details)) {
                    $msg = lang('please_fill_up_your_blockchain_details');
                    $this->redirect($msg, 'payout/payout_release', false);
                }
                $system_currency = $this->DEFAULT_CURRENCY_CODE;

                $all_bitcoin_rates = $this->get_rate_for_one_bitcoin();
                $system_bitcoin_rates = $all_bitcoin_rates['USD'];

                $recent_bitcoin_rate = $system_bitcoin_rates['last'];
                $btc_transaction_fee = $blockchain_details['fee'] / 100000000;
                $admin_wallet_balance = $this->get_admin_wallet_balance($blockchain_details);

                if (!$admin_wallet_balance) {
                    $msg = lang('please_start_blockchain_wallet_service');
                    $this->redirect($msg, 'payout/payout_release', false);

                    /* To Start Blockchain Wallet Service :
                     *  Open terminal
                     *  blockchain-wallet-service start --port 3000
                     *                      */
                }
                if (isset($admin_wallet_balance['error']) && $admin_wallet_balance['error'] == "Not found") {
                    $msg = lang('invalid_blockchain_wallet_config');
                    $this->redirect($msg, 'payout/payout_release', false);
                }
                $admin_btc_balance = $admin_wallet_balance['balance'] / 100000000;
            }

            if ($post_arr['payment_method'] == "Bitgo" && $this->validate_payment_method()) {
                $bitgo_details = $this->payout_optional_model->getBitgoDetails();
                $bitgo_details['wallet_id'] = null;
                $bitgo_details['passphrase'] = null;
                $bitgo_details['wallet_id'] = $this->input->post('wallet_id', true);
                $bitgo_details['passphrase'] = $this->input->post('passphrase', true);
                if (empty($bitgo_details)) {
                    $msg = lang('please_fill_up_your_bitgo_details');
                    $this->redirect($msg, 'payout/payout_release', false);
                }

                $service_status = $this->bitgo_service_status($bitgo_details);
                if (!$service_status) {
                    $msg = lang('please_start_bitgo_wallet_service');
                    $this->redirect($msg, 'payout/payout_release', false);

                    /* To Start BitGo Wallet Service :
                     *  Open terminal
                     *  cd BitGoJS
                     *  cd bin
                     *  ./bitgo-express --debug --port 3080 --env test --bind localhost
                     *                      */
                }

                $system_currency = $this->DEFAULT_CURRENCY_CODE;
                $all_bitcoin_rates = $this->get_rate_for_one_bitcoin();
                $system_bitcoin_rates = $all_bitcoin_rates['USD'];
                $bitgo_details['fee'] = 10;
                $recent_bitcoin_rate = $system_bitcoin_rates['last'];
                $btc_transaction_fee = $bitgo_details['fee'] / 100000000;
            }

            if ($post_arr['payment_method'] == "Bitcoin" && $this->validate_payment_method()) /* Blocktrail */ {
                $bitcoin_settings = $this->register_model->getBitcoinSettings();//print_r($bitcoin_settings); die;
                $myAPIKEY = $bitcoin_settings['api_key'];
                $myAPISECRET = $bitcoin_settings['api_secret_key'];
                $mode = $bitcoin_settings['mode'];

                if ($mode == 0) {
                    $testnet = true;
                    $walletIdent = $bitcoin_settings['test_wallet_name'];
                    $walletPassword = $bitcoin_settings['test_wallet_password'];
                } else {
                    $testnet = false;
                    $walletIdent = null;
                    $walletPassword = null;
                    $walletIdent = $this->input->post('wallet_name', true);
                    $walletPassword = $this->input->post('wallet_password', true);
                }
                $callbackURL = '';
                $bitcoin_price = $this->blocktrail_amount_conversion();

                try {
                    // Initialize the SDK
                    $client = new BlocktrailSDK($myAPIKEY, $myAPISECRET, "BTC", $testnet);
                } catch (Exception $e) {
                    //                       $msg = lang("Initializing the SDK failed because {$e->getMessage()}");
                    $msg = lang("initializing_wallet_failed_because") . $e->getMessage();
                    $this->redirect($msg, 'payout/payout_release', false);
                }

                try {
                    // Or you can initialize an already existing wallet
                    $wallet = $client->initWallet($walletIdent, $walletPassword);
                } catch (Exception $e) {
                    $msg = lang("initializing_wallet_failed_because") . $e->getMessage();
                    $this->redirect($msg, 'payout/payout_release', false);
                }
            }

            $type = 'payout_release';
            $check_status = $this->mail_model->checkMailStatus($type);

            $payout_release_tab = $this->input->post('release_payout');
            //echo $payout_release_tab;die;
            if ($payout_release_tab == 'release_payout_tab1') {
                $tab_key = "release_tab1";
            } else if ($payout_release_tab == 'release_payout_tab2') {
                $tab_key = "release_tab2";
            } else if ($payout_release_tab == 'release_payout') {
                $tab_key = "release";
                if ($payout_release_type == "ewallet_request")
                    $active_tab = "tab2";
            }

            for ($i = 0; $i < $count; $i++) {
                if (array_key_exists($tab_key . $i, $post_arr)) {
                    $request_id = $post_arr['request_id' . $i];
                    $user_name = $post_arr['user_name' . $i];
                    $user_id = $this->validation_model->userNameToID($user_name);
                    if (!$user_id) {
                        $msg = lang('invalid_user_name');
                        $this->redirect($msg, 'payout/payout_release/tab1', false);
                    }

                    if ($kyc_status == 'yes') {
                        $kyc_upload = $this->validation_model->checkKycUpload($user_id);
                        if ($kyc_upload != 'yes') {
                            $msg = lang('kyc_not_uploaded_for') . $user_name;
                            $this->redirect($msg, 'payout/payout_release/tab1', false);
                        }
                    }

                    $payout_release_amount = round((floatval($post_arr['payout' . $i]) / $this->DEFAULT_CURRENCY_VALUE), 8);
                    if ($payout_release_amount > $min_max_payout_amount['max_payout'] || $payout_release_amount < $min_max_payout_amount['min_payout']) {
                        $msg = lang('You_cant_release_this_amount_for') . ' ' . $user_name;
                        $this->redirect($msg, 'payout/payout_release/tab1', false);
                    }
                    if ($active_tab == 'tab1') {
                        $request_id = $user_id;
                        $release_req_type = "from_ewallet";
                        $balance_amount = $this->payout_model->getUserBalanceAmount($user_id);
                        if ($payout_release_amount > $balance_amount) {
                            $msg = lang('Payout_Release_Failed');
                            $msg1 = lang('Low_balance');
                            $this->redirect($msg . " \n" . $msg1, 'payout/payout_release/tab1', false);
                        }
                    }
                    if ($active_tab == 'tab2') {
                        $release_req_type = "ewallet_request";
                        $payout_request_balance_amount = $this->payout_model->getPayoutRequestAmount($request_id, $user_id);
                        if ($payout_release_amount > $payout_request_balance_amount) {
                            $msg = lang('You_cant_release_this_amount_for') . ' ' . $user_name;
                            $this->redirect($msg, 'payout/payout_release', false);
                        }
                    }

                    if ($post_arr['payment_method'] == "bank" && $release_req_type == "from_ewallet") {
                        $res = $this->payout_model->updateUserBalanceAmount($user_id, $payout_release_amount);
                    }
                    /* Payment Gateway Payout Begin */ elseif ($post_arr['payment_method'] == "Blockchain") {
                        $this->BlockchainPayout($user_id, $payout_release_amount, $request_id, $recent_bitcoin_rate, $blockchain_details, $btc_transaction_fee, $system_currency, $payout_release_type, $release_req_type, $admin_btc_balance);
                    } elseif ($post_arr['payment_method'] == "Bitcoin") {
                        $result = $this->BlocktrailPayout($user_id, $payout_release_amount, $payout_release_type, $request_id, $bitcoin_price, $wallet, $release_req_type, $post_arr['payment_method']);
                    } elseif ($post_arr['payment_method'] == "Bitgo") {
                        $btc_send_amount = round($payout_release_amount / $recent_bitcoin_rate, 8);
                        $user_bitgo_wallet_address = $this->payout_optional_model->getUserBitgoWalletAddress($user_id);
                        if ($user_bitgo_wallet_address == '' || $user_bitgo_wallet_address == 'NA') {
                            $msg = lang('invalid_bitgo_wallet_address');
                            $this->redirect($msg, 'payout/payout_release', false);
                        }

                        $requested_date = $post_arr['requested_date' . $i];
                        $total_amount = $total_amount + $btc_send_amount;
                        $bitgo_arr[$j]['amount'] = $btc_send_amount;
                        $bitgo_arr[$j]['amount_payable'] = $payout_release_amount;
                        $bitgo_arr[$j]['user_id'] = $user_id;
                        $bitgo_arr[$j]['payout_release_amount'] = $payout_release_amount;
                        $bitgo_arr[$j]['payout_release_type'] = $release_req_type;
                        $bitgo_arr[$j]['requested_date'] = $requested_date;
                        $bitgo_arr[$j]['req_id'] = $post_arr['request_id' . $i];
                        $bitgo_arr[$j]['address'] = $user_bitgo_wallet_address;

                        $payout_release['recipients'][$j]['address'] = $user_bitgo_wallet_address;
                        $payout_release['recipients'][$j]['amount'] = $btc_send_amount * 100000000;
                        $j = $j + 1;
                    } elseif ($post_arr['payment_method'] == "Paypal") {
                        $user_email = $this->payout_optional_model->getUserPayPalEmail($user_id);
                        if ($user_email == "NA" || $user_email == "NULL" || $user_email == "") {
                            $this->redirect("Pay email of $user_name not provided", "payout/payout_release", false);
                        } else {
                            $id = urlencode(2040);
                            $requested_date = $post_arr['requested_date' . $i];
                            $paypal_arr[$j]['user_id'] = $user_id;
                            array_push($payout_release_arr, $user_name);
                            array_push($payout_release_arr, $user_email);
                            array_push($payout_release_arr, $payout_release_amount);
                            $base_call .= "&L_EMAIL$j=" . urlencode($user_email) .
                                "&L_AMT$j=" . urlencode($payout_release_amount) .
                                "&L_UNIQUEID$j=" . urlencode($id) .
                                "&L_NOTE$j=" . urlencode('Payout Realease') .
                                "&EMAILSUBJECT$j=" . urlencode('Payout Realease') .
                                "&RECEIVERTYPE$j=" . urlencode('Payout Realease') .
                                "&CURRENCYCODE=" . 'USD';

                            $total_amount = $total_amount + $payout_release_amount;
                            $payout_release[$j]['user_id'] = $user_id;
                            $payout_release[$j]['payout_release_amount'] = $payout_release_amount;
                            $payout_release[$j]['payout_release_type'] = $release_req_type;
                            $payout_release[$j]['requested_date'] = $requested_date;
                            $payout_release[$j]['req_id'] = $request_id;
                            $j = $j + 1;
                        }
                    }
                     elseif ($post_arr['payment_method'] == "payeer") {
                        $user_email = $this->payout_optional_model->getPayeerDetails($user_id);
                      // $user_email='test@ads.asd';
                        if ($user_email == "NA" || $user_email == "NULL" || $user_email == "") {
                            $this->redirect("Pay email of $user_name not provided", "payout/payout_release", false);
                        } else {
                            $id = urlencode(2040);
                            $requested_date = $post_arr['requested_date' . $i];
                            $paypal_arr[$j]['user_id'] = $user_id;
                            array_push($payout_release_arr, $user_name);
                            array_push($payout_release_arr, $user_email);
                            array_push($payout_release_arr, $payout_release_amount);
                            $base_call .= "&L_EMAIL$j=" . urlencode($user_email) .
                                "&L_AMT$j=" . urlencode($payout_release_amount) .
                                "&L_UNIQUEID$j=" . urlencode($id) .
                                "&L_NOTE$j=" . urlencode('Payout Realease') .
                                "&EMAILSUBJECT$j=" . urlencode('Payout Realease') .
                                "&RECEIVERTYPE$j=" . urlencode('Payout Realease') .
                                "&CURRENCYCODE=" . 'USD';

                            $total_amount = $total_amount + $payout_release_amount;
                            $payout_release[$j]['user_id'] = $user_id;
                            $payout_release[$j]['payout_release_amount'] = $payout_release_amount;
                            $payout_release[$j]['payout_release_type'] = $release_req_type;
                            $payout_release[$j]['requested_date'] = $requested_date;
                            $payout_release[$j]['req_id'] = $request_id;
                            $j = $j + 1;
                        }
                    }
//echo $post_arr['payment_method'] ;die;
                    /* Payment Gateway Payout Ends */

                    if ($post_arr['payment_method'] != "Paypal" && $post_arr['payment_method'] != "payeer") {
                        $result = $this->payout_model->updatePayoutReleaseRequest($request_id, $user_id, $payout_release_amount, $release_req_type, $post_arr['payment_method']);
                        if ($check_status == 'yes') {
                            $this->sendMailtouser($user_id, $type);
                        }
                    }
                }
            }

            /* Paypal Payout Transfer Begin */
            if ($post_arr['payment_method'] == "Paypal") {
                $result = $this->PayPalPayout($payout_release, $total_amount, $base_call, $paypal_arr, $payout_release_arr, $check_status, $type, $release_req_type);
            }
            /* Paypal Payout Transfer Ends */
             /* Paypal Payout Transfer Begin */
            if ($post_arr['payment_method'] == "payeer") {
                $result = $this->PayeerPayouts($payout_release, $total_amount, $base_call, $paypal_arr, $payout_release_arr, $check_status, $type, $release_req_type);
            }
            /* Paypal Payout Transfer Ends */

            /* Bitgo Payout Continue */
            if ($post_arr['payment_method'] == "Bitgo") {
                $this->BitgoPayout($user_id, $payout_release, $total_amount, $bitgo_arr, $btc_transaction_fee, $request_id, $payout_release_type, $check_status, $type, $release_req_type, $post_arr['payment_method']);
            }
            /* Bitgo Payout Ends */

            if ($result) {
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($user_id, 'release payout', $login_id);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'payout_release', 'Payout Released');
                }
                //

                $msg = lang('Payout_Released_Successfully');
                $this->redirect($msg, 'payout/payout_release', true);
            } else {
                $msg = lang('Payout_Release_Failed');
                $this->redirect($msg, 'payout/payout_release', false);
            }
        }

//Optimization Ends
    }

    function validate_payment_method()
    {
        $res_val = false;
        $msg = "";
        $payment = '';
        if ($this->input->post('payment_method') == "Blockchain") {
            $payment = "Blockchain";
            $this->form_validation->set_rules('main_password', lang('main_password'), 'trim|required');
            $this->form_validation->set_rules('second_password', lang('second_password'), 'trim|required');
            $msg = lang('please_fill_up_your_blockchain_details');
        }
        if ($this->input->post('payment_method') == "Bitgo") {
            $payment = "Bitgo";
            $this->form_validation->set_rules('wallet_id', lang('wallet_id'), 'trim|required');
            $this->form_validation->set_rules('passphrase', lang('passphrase'), 'trim|required');
            $msg = lang('please_fill_up_your_bitgo_details');
        }
        if ($this->input->post('payment_method') == "Bitcoin") {
            $payment = "Bitcoin";
            $this->form_validation->set_rules('wallet_name', lang('wallet_name'), 'trim|required');
            $this->form_validation->set_rules('wallet_password', lang('wallet_password'), 'trim|required');
            $msg = lang('please_fill_up_your_blocktrail_details');
        }
        $res_val = $this->form_validation->run();

        if ($res_val)
            return $res_val;
        else {
            $this->redirect($msg, "payout/payout_release/?payment=$payment", false);
        }
    }

    public function payoutOtpModal()
    {
        $status = false;
        $otp = rand(pow(10, 4), pow(10, 5) - 1);
        if ($otp) {
            if (!empty($this->session->userdata('payout_otp')))
                $this->session->unset_userdata('payout_otp');
            $type = lang('payout_release');
            $this->mail_model->sendOtpMail($otp, $this->validation_model->getUserEmailId($this->validation_model->getAdminId()), $type);
            $this->session->set_userdata('payout_otp', $otp);
            echo $status = true;
            exit;
        } else {
            echo $status;
            exit;
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

        if ($this->session->flashdata('username')) {
            $user_name = $this->session->flashdata('username');
            $user_id = $this->validation_model->userNameToID($user_name);
        } else {
            $user_id = '';
        }

        $pagination1 = new CI_Pagination();
        $base_url1 = base_url() . "admin/payout/my_withdrawal_request/tab1";
        $config1 = $pagination1->customize_style();
        $config1['base_url'] = $base_url1;
        $config1['per_page'] = $this->PAGINATION_PER_PAGE;
        $total_rows1 = $this->payout_model->getPayoutWithdrawalCount($user_id, 'pending');
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
        $base_url2 = base_url() . "admin/payout/my_withdrawal_request/tab2/tab2";
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
        $base_url3 = base_url() . "admin/payout/my_withdrawal_request/tab3/tab3/tab3";
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
        $base_url4 = base_url() . "admin/payout/my_withdrawal_request/tab4/tab4/tab4/tab4";
        $config4 = $pagination4->customize_style();
        $config4['base_url'] = $base_url4;
        $config4['per_page'] = $this->PAGINATION_PER_PAGE;
        $total_rows4 = $this->payout_model->getPayoutWithdrawalCount($user_id, 'deleted');
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
        $waiting_requests = $this->payout_model->getReleasedWithdrawalDetails($user_id, 'approved_pending', $config2['per_page'], $page2);
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

    public function search_member_withdrawal()
    {
        if ($this->input->post('search_member_submit')) {
            $user_name = $this->input->post('user_name', true);
            $user_id = $this->validation_model->userNameToID($user_name);
            if ($user_id) {
                $this->session->set_flashdata('username', $user_name);
                $this->redirect('', 'payout/my_withdrawal_request', true);
            } else {
                $msg = lang('invalid_username');
                $this->redirect($msg, 'payout/my_withdrawal_request', false);
            }
        }
    }
    public function getOtpStat($flag = false)
    {
        if ($flag) {
            return ($this->validation_model->getModuleStatusByKey('otp_modal') == "yes") ? true : false;
        } else {
            echo $this->validation_model->getModuleStatusByKey('otp_modal');
            exit();
        }
    }
    
    public function payout_methods() {

        $title = lang('payout_methods');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        //$help_link = 'network-configuration ';
        //$this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('payout_methods');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('payout_methods');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();


        $payout_methods = $this->payout_model->gatewayListStatus();
        
        $this->set('payout_methods', $payout_methods);
        //$this->set('status', $status);
        $this->setView();
    }
    
    public function inactivate_payout($payout_id=''){
        
        $msg = '';
        $result = $this->payout_model->inactivate_payout($payout_id);
        
        if ($result) {
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Payout Deactivated', $this->LOG_USER_ID, $data = '');
            // Employee Activity History
            if ($this->LOG_USER_TYPE == 'employee') {
                $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'inactivate_payout', 'Payout Deactivated');
            }
            //
            
            $msg = $this->lang->line('payout_inactivated_successfully');
            $this->redirect($msg, 'payout/payout_methods', TRUE);
        } else {
            $msg = $this->lang->line('error_on_inactivating_payout');
            $this->redirect($msg, 'payout/payout_methods', FALSE);
        }
    }
    
    function activate_payout($payout_id = '')
    {
        $msg = '';
        $result = $this->payout_model->activate_payout($payout_id);
        if ($result) {
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Payout Activated', $this->LOG_USER_ID, $data = '');
            // Employee Activity History
            if ($this->LOG_USER_TYPE == 'employee') {
                $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'activate_rank', 'Payout Activated');
            }
            //
           
           $msg = $this->lang->line('payout_activated_successfully');
            $this->redirect($msg, 'payout/payout_methods', TRUE);
        } else {
            $msg = $this->lang->line('error_on_activating_payout');
            $this->redirect($msg, 'payout/payout_methods', FALSE);
        }
    }
    public function PayeerPayouts($payout_release, $total_amount, $base_call, $paypal_arr, $payout_release_arr, $check_status, $type)
    {
        $count_pay_release = count($payout_release);

        if ($count_pay_release) {
            $paypal_balance = $this->payout_optional_model->PayeerBalance();
          // $paypal_balance=$paypal_balance['balance']['USD']['BUDGET'];
           
//echo $paypal_balance."--".$total_amount;die;
            if ($paypal_balance < $total_amount) {
                $this->redirect(lang('not_enough_balance_in_payeer'), "payout/payout_release", false);
            } else {
                $result = $this->payout_optional_model->payeerPayout($base_call, $payout_release, $total_amount);
                if ($result) {
                    $cnt = count($paypal_arr);
                    if ($cnt && $check_status == 'yes') {
                        for ($i = 0; $i < $cnt; $i++) {
                            $this->sendMailtouser($paypal_arr[$i]['user_id'], $type);
                        }
                    }
                    $this->payout_optional_model->massPayoutHistory($payout_release_arr);
                    return true;
                } else {
                    $this->redirect(lang('Payout_Release_Failed'), "payout/payout_release", false);
                }
            }
        }
    }


}
