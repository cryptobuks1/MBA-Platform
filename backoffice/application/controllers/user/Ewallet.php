<?php

require_once 'Inf_Controller.php';

class Ewallet extends Inf_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->url_permission('ewallet_status');
        $this->load->model('configuration_model');
    }

    function fund_transfer()
    {

        $this->set('action_page', $this->CURRENT_URL);
        $title = lang('fund_transfer');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'fund-transfer';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('fund_transfer');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('fund_transfer');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $userid = $this->LOG_USER_ID;
        $balamount = $this->ewallet_model->getBalanceAmount($userid);
        $trans_fee = $this->ewallet_model->getTransactionFee();

        $this->set('trans_fee', $trans_fee);
        $pass = $this->ewallet_model->getUserPassword($userid);

        $msg = '';
        $this->set('transaction_note', '');
        $this->set('amount', '');
        $this->set('to_user', '');
        $this->set('bal_amount', '');
        $this->set('from_user', '');
        $this->set('total_req_amount', 0);
        $this->set("step1", '');
        $this->set("step2", ' none');

        if ((!$this->input->post('dotransfer')) && $this->input->post('transfer')) {
            $this->post_fund_transfer();
        }
        $response['error'] = false;
        if ($this->input->post('dotransfer')) {
            $response['error'] = false;
            $post_arr = $this->input->post(null, true);
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);

            if (array_key_exists('to_user_name', $post_arr)) {
                $touser = $post_arr['to_user_name'];
            }
            if (array_key_exists('amount1', $post_arr)) {
                $trans_amt = round($post_arr['amount1'] / $this->DEFAULT_CURRENCY_VALUE, 8);
                $total_req_amount = $trans_amt + $trans_fee;
            }
            $to_userid = $this->ewallet_model->userNameToID($touser);

            $transaction_note = $this->validation_model->textAreaLineBreaker($post_arr['tran_concept']);

            $response['error'] = false;
            $data = [
                "transaction_note" => $transaction_note,
                "bal_amount" => $balamount,
                "to_user" => $touser,
                "amount" => $trans_amt,
                "total_req_amount" => $total_req_amount,
            ];
            $response['data'] = $data;

            echo json_encode($response);
            exit();
        }
        $request_amount = $this->ewallet_model->getRequestPendingAmount($userid);

        $this->set('request_amount', round($request_amount, 8));
        $this->set('balamount', round($balamount, 8));
        $this->set('pass', $pass);
        $this->setView();
    }

    public function validate_transfer()
    {
        $user_name = $this->LOG_USER_NAME;
        $this->form_validation->set_rules('to_user_name', 'lang:user_name', "trim|required|not_equals[{$user_name}]|user_exists|differs[user_name]", ['differs' => lang('invalid_user_selection'), 'not_equals' => lang('invalid_user_selection')]);
        $this->form_validation->set_rules('amount1', 'lang:amount', 'trim|required|greater_than[0]');
        $this->form_validation->set_rules('tran_concept', 'lang:transaction_note', 'trim|required');
        $validate_form = $this->form_validation->run_with_redirect('ewallet/fund_transfer');
        return $validate_form;
    }

    public function validate_transfer1()
    {
        $userid = $this->LOG_USER_ID;

        $to_user = $this->input->post('to_user_name', true);
        $to_userid = $this->ewallet_model->userNameToID($to_user);
        $user_exists = $this->ewallet_model->isUserNameAvailable($to_user);
        $bal_amount = $this->ewallet_model->getBalanceAmount($userid);

        if (!$this->input->post('to_user_name')) {
            $msg = lang('Please_type_To_User_name');
            $this->redirect($msg, 'ewallet/fund_transfer', false);
        }

        if ($user_exists && $userid != $to_userid) {

            if (!$this->input->post('amount1')) {
                $msg = lang('Please_type_Amount');
                $this->redirect($msg, 'ewallet/fund_transfer', false);
            }

            if (!$this->input->post('tran_concept')) {
                $msg = lang('Please_type_transaction_note');
                $this->redirect($msg, 'ewallet/fund_transfer', false);
            }

            if (!$this->input->post('pswd')) {
                $msg = lang('Please_type_transaction_password');
                $this->redirect($msg, 'ewallet/fund_transfer', false);
            }
            if (!is_numeric($this->input->post('tot_req_amount'))) {
                $msg = lang('invalid_amount_please_try_again');
                $this->redirect($msg, 'ewallet/fund_transfer', false);
            }
            if ($this->input->post('tot_req_amount') < 0 || $this->input->post('tot_req_amount') > $bal_amount) {
                $msg = lang('invalid_amount_please_try_again');
                $this->redirect($msg, 'ewallet/fund_transfer', false);
            }
        } else {
            $msg = lang('invalid_user_selection');
            $this->redirect($msg, 'ewallet/fund_transfer', false);
        }
        return true;
    }

    function getLegAmount($user_name)
    {
        $this->AJAX_STATUS = true;
        $user = $this->ewallet_model->userNameToID($user_name);
        $bal_amount = $this->ewallet_model->getBalanceAmount($user);
        echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Balance Amount:</b></td><td><input type="text" name="bal"  id="bal" readonly="true" value=' . $bal_amount . ' ></td>';
    }

    function getBalance_EPin()
    {
        $this->AJAX_STATUS = true;
        $user = $this->URL['user'];
        $bal_epin = $this->Ewallet->getBalancePin($user);
        $pwd1 = $this->Ewallet->getUserPassword($user);
        echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Balance E-pin Count</b></td><td><input type='text' name='balance'  readonly='true' id='balance' value=" . $bal_epin . " ></td><input type='hidden' id='u_pwd' name='u_pwd' value=" . $pwd1 . "  /></td>";
    }

    function getPassWordInmd($pswdm)
    {
        $this->AJAX_STATUS = true;
        $mdpsw = md5($pswdm);
        echo '<td><input type="hidden" id="md_psd" name="md_psd" value=' . $mdpsw . '  /></td>';
    }

    function ewallet_pin_purchase()
    {

        $title = lang('e_pin_purchase');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'pin-purchase';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('e_pin_purchase');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('e_pin_purchase');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;
        $balamount = $this->ewallet_model->getBalanceAmount($user_id);
        $amount_details = $this->ewallet_model->getAllEwalletAmounts();
        $msg = '';
        if ($this->input->post('transfer') && $this->validate_ewallet_pin_purchase()) {

            $pin_post_array = $this->input->post(null, true);
            $pin_post_array = $this->validation_model->stripTagsPostArray($pin_post_array);

            $pin_count = $pin_post_array['pin_count'];
            $amount_id = $pin_post_array['amount'];

            if ($pin_count > 0 && $amount_id != '' && is_numeric($pin_count)) {
                $tran_pass = $pin_post_array['passcode'];
                $dbpass = $this->ewallet_model->getTransactionPasscode($user_id);
                if (password_verify($tran_pass, $dbpass)) {
                    $amount = $this->ewallet_model->getEpinAmount($amount_id);
                    $tot_avb_amt = $amount * $pin_count;
                    if ($tot_avb_amt <= $balamount) {
                        $uploded_date = date('Y-m-d H:i:s');
                        $expiry_date = date('Y-m-d', strtotime('+6 months', strtotime($uploded_date)));
                        $purchase_status = 'yes';
                        $status = 'yes';
                        $this->ewallet_model->begin();

                        $max_pincount = $this->ewallet_model->getMaxPinCount();
                        $rec = $this->ewallet_model->getAllActivePinspage($purchase_status);
                        if ($rec < $max_pincount) {
                            $errorcount = $max_pincount - $rec;
                            if ($pin_count <= $errorcount) {
                                $transaction_id = $this->ewallet_model->getUniqueTransactionId();
                                $res = $this->ewallet_model->generatePasscode($pin_count, $status, $uploded_date, $amount, $expiry_date, $purchase_status, $amount_id, $user_id, $user_id, $transaction_id);
                            }
                        } else {
                            $msg1 = lang('already');
                            $msg2 = lang('epin_present');
                            $this->redirect($msg1 . $rec . $msg2, 'epin/generate_epin', false);
                        }

                        if ($res) {

                            $bal = round($balamount - $tot_avb_amt, 8);
                            $update = $this->ewallet_model->updateBalanceAmount($user_id, $bal);
                            if ($res && $update) {
                                $this->ewallet_model->commit();
                                $loggin_id = $this->LOG_USER_ID;
                                $data_array = array();
                                $data_array['pin_post_array'] = $pin_post_array;
                                $data = serialize($data_array);
                                $this->validation_model->insertUserActivity($loggin_id, 'epin purchased', $loggin_id, $data);

                                $msg = lang('epin_purchased_successfully');
                                $this->redirect($msg, 'ewallet/ewallet_pin_purchase', true);
                            } else {
                                $this->ewallet_model->rollback();
                                $msg = lang('error_on_epin_purchase');
                                $this->redirect($msg, 'ewallet/ewallet_pin_purchase', false);
                            }
                        } else {
                            $this->ewallet_model->rollback();
                            $mail = $this->ewallet_model->getAdminEmailId();
                            $mailBodyDetails = '<html>
							<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
							
							</head>
							<body >
							<table id="Table_01" width="600"   border="0" cellpadding="0" cellspacing="0">
							<tr><td><br />Dear Admin,<br /></td></tr>
							<tr><td>There is no active E-pin for the product in your company. Please generate new E-pin.</td></tr>
							<tr><td>Thanks,<br />World Class Reward</td></tr>
							</table>
							</body></html>';
                            $res = $this->validation_model->sendEmail($mailBodyDetails, $user_id, '');
                            $msg = lang('no_epin_found_please_contact_administrator');
                            $this->redirect($msg, 'ewallet/ewallet_pin_purchase', false);
                        }
                    } else {
                        $msg = lang('no_sufficient_balance_amount');
                        $this->redirect($msg, 'ewallet/ewallet_pin_purchase', false);
                    }
                } else {
                    $msg = lang('invalid_transaction_password');
                    $this->redirect($msg, 'ewallet/ewallet_pin_purchase', false);
                }
            } else {
                $msg = lang('error_on_purchasing_epin_please_try_again');
                $this->redirect($msg, 'ewallet/ewallet_pin_purchase', false);
            }
        }

        $this->set('balamount', $balamount);
        $this->set('amount_details', $amount_details);
        $this->setView();
    }

    public function validate_ewallet_pin_purchase()
    {
        $this->form_validation->set_rules('passcode', lang('transaction_password'), 'trim|required');
        $this->form_validation->set_rules('amount', lang('amount'), 'trim|required|greater_than[0]');
        $this->form_validation->set_rules('pin_count', lang('epin_count'), 'trim|required|integer|greater_than[0]');

        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function my_transfer_details()
    {

        $title = $this->lang->line('transfer_details');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'my-transfer';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('transfer_details');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('transfer_details');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $weekdate = (strip_tags($this->input->post('weekdate', true)));
        $daily = (strip_tags($this->input->post('daily', true)));
        $this->set('weekdate', $weekdate);
        $this->set('daily', $daily);

        $weekly_session = 0;
        $daily_session = 0;


        if (($this->input->post('weekdate')) || ($this->session->userdata('inf_my_transfer_details_weekly'))) {


            $this->session->unset_userdata('inf_my_transfer_details_daily');

            $user_name = $this->LOG_USER_NAME;
            $user_id = $this->ewallet_model->userNameToID($user_name);

            $weekly_session = 1;
            if($this->input->post('weekdate') && $this->validate_my_transfer_details_weekdate()){

             $post_arr = $this->input->post(NULL, TRUE);
             $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
             $from_date = $post_arr['week_date1'];
              $to_date = $post_arr['week_date2'];
               if ($from_date != '') {
                $from_date = $from_date . ' 00:00:00';
               } else {
                $from_date = '';
               }
               if ($to_date != '') {
                $to_date = $to_date . ' 23:59:59';
               } else {
                $to_date = '';
               }
            }
            else{
             $from_date = $this->session->userdata('inf_my_transfer_details_from_data');
             $to_date = $this->session->userdata('inf_my_transfer_details_to_data');

            }

            $this->session->set_userdata('inf_my_transfer_details_weekly',$user_name);
            $this->session->set_userdata('inf_my_transfer_details_from_data', $from_date);
            $this->session->set_userdata('inf_my_transfer_details_to_data', $to_date);

            $count = $this->ewallet_model->getUserEwalletDetailsCount($user_id, $from_date, $to_date);

            $base_url = base_url() . 'user/ewallet/my_transfer_details/';
            $config = $this->pagination->customize_style();
            $config['base_url'] = $base_url;
             //$config['use_page_numbers'] = TRUE;
            $config['per_page'] = $this->PAGINATION_PER_PAGE;
            $page = ($this->uri->segment(4) != "") ? $this->uri->segment(4) : 0;
            $config['total_rows'] = $count;
            $this->pagination->initialize($config);
            $result_per_page = $this->pagination->create_links();

            $details = $this->ewallet_model->getUserEwalletDetails($user_id, $from_date, $to_date,$page,$config['per_page']);
            $this->set('details', $this->security->xss_clean($details));
            $this->set('user_name', $user_name);
            $details_count = count($details);
            $this->set('details_count', $details_count);
            $this->set('result_per_page',$result_per_page);
            $this->set('page',$page);
        }
        if (($this->input->post('daily')) || ($this->session->userdata('inf_my_transfer_details_daily'))) {

            $this->session->unset_userdata('inf_my_transfer_details_weekly');
            $user_name = $this->LOG_USER_NAME;
            $user_id = $this->ewallet_model->userNameToID($user_name);

            $daily_session = 1;

            if($this->input->post('daily') && $this->validate_my_transfer_details_daily()){

             $post_arr = $this->input->post(NULL, TRUE);
             $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
             $from_date = $post_arr['week_date3'] . ' 00:00:00';
             $to_date = $post_arr['week_date3'] . ' 23:59:59';
            }
            else{
             $from_date = $this->session->userdata('inf_my_transfer_details_from_data');
             $to_date = $this->session->userdata('inf_my_transfer_details_to_data');

            }

            $this->session->set_userdata('inf_my_transfer_details_daily',$user_name);
            $this->session->set_userdata('inf_my_transfer_details_from_data', $from_date);
            $this->session->set_userdata('inf_my_transfer_details_to_data', $to_date);
            $count = $this->ewallet_model->getUserEwalletDetailsCount($user_id, $from_date, $to_date);
            $base_url = base_url() . 'user/ewallet/my_transfer_details/';
            $config = $this->pagination->customize_style();
            $config['base_url'] = $base_url;
             //$config['use_page_numbers'] = TRUE;
            $config['per_page'] = $this->PAGINATION_PER_PAGE;
            $page = ($this->uri->segment(4) != "") ? $this->uri->segment(4) : 0;
            $config['total_rows'] = $count;
            $this->pagination->initialize($config);
            $result_per_page = $this->pagination->create_links();

            $details = $this->ewallet_model->getUserEwalletDetails($user_id, $from_date, $to_date,$page,$config['per_page']);
            $this->set('details', $this->security->xss_clean($details));
            $this->set('user_name', $user_name);
            $details_count = count($details);
            $this->set('details_count', $details_count);
            $this->set('result_per_page',$result_per_page);
            $this->set('page',$page);
        }
        $this->set('daily_session',$daily_session);
        $this->set('weekly_session',$weekly_session);
        $this->setView();
    }

    public function validate_my_transfer_details_weekdate()
    {
        $post_arr = $this->validation_model->stripTagsPostArray($this->input->post());

        //        if (!$post_arr['week_date1']) {
        //            $msg = lang('please_select_from_date');
        //            $this->redirect($msg, 'ewallet/my_transfer_details', FALSE);
        //        }
        //        if (!$post_arr['week_date2']) {
        //            $msg = lang('please_select_to_date');
        //            $this->redirect($msg, 'ewallet/my_transfer_details', FALSE);
        //        }

        if (!$post_arr['week_date1'] && !$post_arr['week_date2']) {
            $msg = lang('Please select atleast one criteria.');
            $this->redirect($msg, 'ewallet/my_transfer_details', false);
        }
        if ($post_arr['week_date1'] > $post_arr['week_date2']) {
            $msg = lang('to_date_should_greater_than_or_equal_to_from_date');
            $this->redirect($msg, 'ewallet/my_transfer_details', false);
        }
        return true;
    }

    public function validate_my_transfer_details_daily()
    {
        $post_arr = $this->validation_model->stripTagsPostArray($this->input->post());

        if (!$post_arr['week_date3']) {
            $msg = lang('please_select_date');
            $this->redirect($msg, 'ewallet/my_transfer_details', false);
        }

        return true;
    }

    function my_ewallet()
    {

        $help_link = 'my-e-wallet';
        $this->set('help_link', $help_link);

        if ($this->MLM_PLAN == 'Unilevel' && $this->MODULE_STATUS['hyip_status'] == 'yes') {
            $title = lang('hyip_details');
        } else {
            $title = $this->lang->line('ewallet_details');
        }

        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);
        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;

        $base_url = base_url() . 'user/ewallet/my_ewallet';
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;

        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(4);
        } else {
            $page = 0;
        }

        $count = $this->ewallet_model->getEwalletHistoryCount($user_id);
        $ewallet_details = $this->ewallet_model->getEwalletHistory($user_id, $page, $config['per_page']);
        $previous_ewallet_balance = $this->ewallet_model->getPreviousEwalletBalance($user_id, $page);
        $ewallet_balance = $this->ewallet_model->getBalanceAmount($user_id);
        $config['total_rows'] = $count;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();

        $this->set('result_per_page', $result_per_page);
        $this->set('page_id', $page);
        $this->set('user_name', $user_name);
        $this->set('ewallet_details', $this->security->xss_clean($ewallet_details));
        $this->set('previous_ewallet_balance', $previous_ewallet_balance);
        $this->set('ewallet_balance', $ewallet_balance);
        // print_r($ewallet_details);
        // die;
        $from_user_amount_types = [
            'referral',
            'level_commission',
            'repurchase_level_commission',
            'upgrade_level_commission',
            'xup_commission',
            'xup_repurchase_level_commission',
            'xup_upgrade_level_commission',
            'matching_bonus',
            'matching_bonus_purchase',
            'matching_bonus_upgrade',
            'sales_commission',
        ];
        $this->set('from_user_amount_types', $from_user_amount_types);

        $this->lang->load('amount_type', $this->LANG_NAME);

        $this->setView();
    }

    public function user_availability()
    {
        if ($this->ewallet_model->checkUser((strip_tags($this->input->post('user_name', true))))) {
            echo "yes";
            exit();
        } else {
            echo "no";
            exit();
        }
    }

    function post_fund_transfer()
    {

        if ($this->input->post('transfer') && $this->validate_transfer()) {

            $transfer_post_array = $this->input->post(null, true);

            $transfer_post_array = $this->validation_model->stripTagsPostArray($transfer_post_array);
            $userid = $this->LOG_USER_ID;
            $balamount = $this->ewallet_model->getBalanceAmount($userid);
            $trans_fee = $this->ewallet_model->getTransactionFee();
            $pass = $this->ewallet_model->getUserPassword($userid);
            $tran_pass = base64_decode(urldecode($transfer_post_array['pswd']));
            $to_user_name = $transfer_post_array['to_username'];
            $to_user_id = $this->ewallet_model->userNameToID($to_user_name);
            $trans_amt = $transfer_post_array['amount1'];
            $trans_amt = round($trans_amt / $this->DEFAULT_CURRENCY_VALUE, 8);
            $transaction_concept = $this->validation_model->textAreaLineBreaker($transfer_post_array['tran_concept']);
            $total_req_amount = $trans_amt + $trans_fee;
            if ($total_req_amount <= $balamount) {
                if (password_verify($tran_pass, $pass)) {
                    $this->ewallet_model->begin();
                    $transaction_id = $this->ewallet_model->getUniqueTransactionId();
                    $up_date1 = $this->ewallet_model->updateBalanceAmountDetailsFrom($userid, round($total_req_amount, 8));
                    $up_date2 = $this->ewallet_model->updateBalanceAmountDetailsTo($to_user_id, round($trans_amt, 8));
                    $this->ewallet_model->insertBalAmountDetails($userid, $to_user_id, round($trans_amt, 8), $amount_type = '', $transaction_concept, $trans_fee, $transaction_id);
                    if ($up_date1 && $up_date2) {
                        $this->ewallet_model->commit();
                        $login_id = $this->LOG_USER_ID;
                        $data_array = array();
                        $data_array['transfer_post_array'] = $transfer_post_array;
                        $data = serialize($data_array);
                        $this->validation_model->insertUserActivity($login_id, 'fund transferred', $to_user_id, $data);
                        $msg = lang('fund_transfered_successfully');
                        $this->redirect($msg, 'ewallet/fund_transfer', true);
                    } else {
                        $this->ewallet_model->rollback();
                        $msg = lang('error_on_fund_transfer');
                        $this->redirect($msg, 'ewallet/fund_transfer', false);
                    }
                } else {
                    $msg = lang('invalid_transaction_password');
                    $this->redirect($msg, 'ewallet/fund_transfer', false);
                }
            } else {
                $msg = lang('low_balance_please_try_again');
                $this->redirect($msg, 'ewallet/fund_transfer', false);
            }
        }
    }

    function validate_username($ref_user = '')
    {
        if ($ref_user != '') {
            $flag = false;
            if ($this->validation_model->isUserNameAvailable($ref_user)) {
                $flag = true;
            }
            return $flag;
        } else {
            $echo = 'no';
            $username = ($this->input->post('username', true));

            if ($this->validation_model->isUserNameAvailable($username)) {
                $echo = "yes";
            }
            echo $echo;
            exit();
        }
    }
    public function purchase_wallet()
    {
        $this->url_permission('purchase_wallet');

        $title = lang('purchase_wallet');
        $this->set("title", $this->COMPANY_NAME . " | $title ");

        $help_link = "purchase-wallet";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('purchase_wallet');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('purchase_wallet');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;
        $base_url = base_url() . 'user/ewallet/purchase_wallet';
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;

        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(4);
        } else {
            $page = 0;
        }

        $count = $this->ewallet_model->getPurchasewalletHistoryCount($user_id);
        $ewallet_details = $this->ewallet_model->getPurchasewalletHistory($user_id, $page, $config['per_page']);
        $previous_ewallet_balance = $this->ewallet_model->getPreviousPurchasewalletBalance($user_id, $page);
        $ewallet_balance = $this->validation_model->getPurchaseWalletAmount($user_id);

        $config['total_rows'] = $count;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();

        $this->set('result_per_page', $result_per_page);
        $this->set('page_id', $page);
        $this->set('ewallet_details', $this->security->xss_clean($ewallet_details));
        $this->set('previous_ewallet_balance', $previous_ewallet_balance);
        $this->set('ewallet_balance', $ewallet_balance);
        $from_user_amount_types = [
            'referral',
            'level_commission',
            'repurchase_level_commission',
            'upgrade_level_commission',
            'xup_commission',
            'xup_repurchase_level_commission',
            'xup_upgrade_level_commission',
            'matching_bonus',
            'matching_bonus_purchase',
            'matching_bonus_upgrade',
            'sales_commission',
        ];
        $this->set('from_user_amount_types', $from_user_amount_types);
        $this->lang->load('amount_type', $this->LANG_NAME);

        $this->setView();
    }

    public function add_purchase_wallet_amount()
    {
        $this->url_permission('purchase_wallet');
        if ($this->input->post('add_fund')) {
            $this->form_validation->set_rules('amount', 'lang:amount', "trim|required|greater_than[0]");
            $validate_form = $this->form_validation->run_with_redirect('ewallet/purchase_wallet');
            if ($validate_form) {
                $payment_amount = $this->input->post('amount', TRUE);
                $this->load->model('payment_model');
                if ($this->payment_model->isPaypalEnabled()) {
                    $session_data = array(
                        'user_id' => $this->LOG_USER_ID,
                        'payment_amount' => $payment_amount
                    );
                    $this->session->set_userdata('purchase_wallet_payment', $session_data);
                    require_once dirname(__DIR__) . '/Paypal.php';
                    $paypal = new Paypal;
                    $paypal_currency_code = "USD";
                    $paypal_currency_left_symbol = "$";
                    $paypal_currency_right_symbol = "";
                    $payment_amount = round($payment_amount / $this->DEFAULT_CURRENCY_VALUE, 8);
                    $usd_conevrsion_rate = 1;
                    $payment_amount = round($payment_amount / $usd_conevrsion_rate, 8);
                    $description = "Fund deposit to purchase wallet - " . $this->COMPANY_NAME;
                    $description .= "\nAmount : $paypal_currency_left_symbol $payment_amount $paypal_currency_right_symbol";
                    $params = array(
                        'amount' => $payment_amount,
                        'item' => "Fund deposit to purchase wallet",
                        'description' => $description,
                        'currency' => $paypal_currency_code,
                        'return_url' => BASE_URL . "/user/ewallet/paypal_purchase_wallet_success",
                        'cancel_url' => BASE_URL . "/user/ewallet/purchase_wallet"
                    );

                    $response = $paypal->initilize($params);
                    if (!$response->success()) {
                        $this->redirect(lang('paypal_payment_error'), 'ewallet/purchase_wallet', FALSE);
                    }
                } else {
                    $this->redirect(lang('paypal_disabled'), 'ewallet/purchase_wallet', FALSE);
                }
            }
        }
    }

    public function paypal_purchase_wallet_success()
    {
        require_once dirname(__DIR__) . '/Paypal.php';
        $paypal = new Paypal;
        $payment_data = $this->session->userdata('purchase_wallet_payment');
        $payment_amount = $payment_data['payment_amount'];
        $paypal_currency_code = "USD";
        $paypal_currency_left_symbol = "$";
        $paypal_currency_right_symbol = "";
        $payment_amount = $ewallet_amount = round($payment_amount / $this->DEFAULT_CURRENCY_VALUE, 8);
        $usd_conevrsion_rate = 1;
        $payment_amount = round($payment_amount / $usd_conevrsion_rate, 8);
        $params = array(
            'amount' => $payment_amount,
            'currency' => $paypal_currency_code,
            'return_url' => BASE_URL . "/user/ewallet/paypal_purchase_wallet_success",
            'cancel_url' => BASE_URL . "/user/ewallet/purchase_wallet"
        );
        $response = $paypal->callback($params);
        if ($response->success()) {
            $payment_res = TRUE;
            $this->load->model('register_model');
            $paypal_output = $this->input->get();
            $payment_details = [
                'payment_method' => 'paypal',
                'token_id' => $paypal_output['token'],
                'currency' => $paypal_currency_code,
                'amount' => $payment_amount,
                'acceptance' => '',
                'payer_id' => $paypal_output['PayerID'],
                'user_id' => $this->LOG_USER_ID,
                'status' => '',
                'card_number' => '',
                'ED' => '',
                'card_holder_name' => '',
                'submit_date' => date("Y-m-d H:i:s"),
                'pay_id' => '',
                'error_status' => '',
                'brand' => ''
            ];
            $this->register_model->insertintoPaymentDetails($payment_details);
        } else {
            $payment_res = FALSE;
        }

        $this->session->unset_userdata('purchase_wallet_payment');
        if ($payment_res) {
            $this->inf_model->begin();
            $res = $this->ewallet_model->addFundToPurchaseWallet($this->LOG_USER_ID, $ewallet_amount, 'fund_deposit_paypal');
            if ($res) {
                $this->inf_model->commit();
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, sprintf(lang('purchase_wallet_fund_deposit_paypal'), $this->DEFAULT_SYMBOL_LEFT . $ewallet_amount . $this->DEFAULT_SYMBOL_RIGHT), $this->LOG_USER_ID, serialize([]));
                $this->redirect(lang('add_fund_success'), 'ewallet/purchase_wallet', true);
            } else {
                $this->inf_model->rollback();
                $this->redirect(lang('add_fund_error'), 'ewallet/purchase_wallet', false);
            }
        } else {
            $this->redirect(lang('paypal_payment_error'), 'ewallet/purchase_wallet', false);
        }
    }
    
     function customer_upgrade(){
        
        $title = lang('customer_upgrade');
        $this->set("title", $this->COMPANY_NAME . " | $title ");

        $help_link = "customer_upgrade-wallet";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('customer_upgrade');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('customer_upgrade');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        
        $user_id = $this->LOG_USER_ID;
        $user_name =$this->LOG_USER_NAME;
        $date = date("Y-m-d H:i:s");
        
        $conf_details = $this->configuration_model->getSettings();
        $balamount = $this->ewallet_model->getBalanceAmount($user_id);
        $join_type = $this->ewallet_model->getUserJoinType($user_id);
        $term_cond = $this->ewallet_model->getUpgradeTermsConditions($this->LANG_ID);
       
        $this->set('user_bal',$balamount);
        $this->set('user_id',$user_id);
        $this->set('upgrade_details', $conf_details);
        $this->set('join_type',$join_type);
        $this->set('termsconditions',$term_cond);
        $this->setView();
    }
    
        
     function customer_upgrade_view(){
        
        $title = lang('customer_upgrade_view');
        $this->set("title", $this->COMPANY_NAME . " | $title ");

        $help_link = "customer_upgrade-wallet";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('customer_upgrade');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('customer_upgrade');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        
        $user_id = $this->LOG_USER_ID;
        $user_name =$this->LOG_USER_NAME;
        $date = date("Y-m-d H:i:s");
        
        $conf_details = $this->configuration_model->getSettings();
        $balamount = $this->ewallet_model->getBalanceAmount($user_id);
        $join_type = $this->ewallet_model->getUserJoinType($user_id);
        $term_cond = $this->ewallet_model->getUpgradeTermsConditions($this->LANG_ID);
        
        $upgrade_note = $this->ewallet_model->getUpgradationNote();
        
        $this->set('user_bal',$balamount);
        $this->set('user_id',$user_id);
        $this->set('upgrade_details', $conf_details);
        $this->set('join_type',$join_type);
        $this->set('termsconditions',$term_cond);
        $this->set('upgrade_note',$upgrade_note);
        $this->setView();
    }
    
    
    public function upgrade_customer($user_id=''){
        
        $user_id = $this->LOG_USER_ID;
        $user_name =$this->LOG_USER_NAME;
        $conf_details = $this->configuration_model->getSettings();
        $up_fee = $conf_details['upgrade_amount'];
        $trans_fee = $conf_details['trans_fee'];
        $req_amount = $up_fee + $trans_fee;
        
        $date = date("Y-m-d H:i:s");
        
        $balamount = $this->ewallet_model->getBalanceAmount($user_id);
        $join_type = $this->ewallet_model->getUserJoinType($user_id);
        if( $this->validate_conditions()){
        if($join_type == 'customer'){
            
            if($req_amount<=$balamount){
            
            $result = $this->ewallet_model->upgradeJoinType($user_id);
            if($result){
                $rank_status = $this->MODULE_STATUS['rank_status'];
                if ($rank_status == 'yes') {
                    $this->load->model('rank_model');
                    $obj_arr = $this->configuration_model->getRankConfiguration();
                    $this->rank_model->updateDefaultRank($user_id, $obj_arr['default_rank_id']);
                }
                $update_bal = $this->ewallet_model->updateBalanceAmountDetailsFrom($user_id, $req_amount);
                $history = $this->ewallet_model->insertUpgradeHistory($user_id, $req_amount, $date,'by_ewallet');
                $this->ewallet_model->updateFtPack('pck2',$user_id);
                
                $msg = lang('success_upgrade');
                $this->redirect($msg, 'user/home', true);
            }else{
                $msg = lang('error_upgrade');
                $this->redirect($msg, 'user/home', false);
            }
            
            
        } else{
            $msg = lang('low_balance_please_try_again');
            $this->redirect($msg, 'user/home', false);
        }
        }else{
            $msg = lang('already_affiliate');
            $this->redirect($msg, 'user/home', false);
        }
        }else{
            $msg = lang('must_agree');
            $this->redirect($msg, 'user/customer_upgrade', false);
        }
       
    }
   function validate_conditions(){
       
       $this->form_validation->set_rules('agree', lang('agree'), 'required');

        $validate_form = $this->form_validation->run();
        return $validate_form;
    }
    
    function monthly_payment(){
        
        $title = $this->lang->line('monthly_payment');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('monthly_payment');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('monthly_payment');
        $this->HEADER_LANG['page_small_header'] = lang('');
        $this->load_langauge_scripts();
         
        $userid = $this->LOG_USER_ID;
        $balamount = $this->ewallet_model->getBalanceAmount($userid);
        $monthly_fee= $this->ewallet_model->getMonthlyFee();
        $end_date=$this->ewallet_model->getSubscriptionEndDate($userid);
        $current_date= date('Y-m-d H:i:s');
        $msg = '';
        if($end_date>$current_date){
            $msg="Subscription is active";
            $this->redirect($msg, 'user/home', false);
        }
        require_once('application/libraries/stripe-php/init.php');
        
        $config = $this->validation_model->getSettings();
        $key = $config['stripe_key'];//echo $key;die;
        $join_type = $this->validation_model->getUserJoinType($userid);
        /*if($join_type=='affiliate'){
            $is_upgraded = $this->validation_model->isUpgradedUser($userid);
            if($is_upgraded){
                $this->load->model('register_model');
                $upgrade_fee = $this->register_model->getRegisterAmount();
                $monthly_fee=$monthly_fee+$upgrade_fee;
            }
        }*/
        $this->set('key', $key);
        $this->set('monthly_fee',$monthly_fee);
        $this->set('balamount', round($balamount, 8));

        $this->set('current_date',$current_date); 
        $this->set('subscription_end_date',$end_date);
      
         $this->setView();
    }
    
    

    public function monthly_pay_post(){
          ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
        $transfer_post_array = $this->input->post(null, true);

          $userid=$this->LOG_USER_ID;
            $balamount = $this->ewallet_model->getBalanceAmount($userid);
            $monthly_fee= $this->ewallet_model->getMonthlyFee();
            $join_type = $this->validation_model->getUserJoinType($userid);
           /* if($join_type=='affiliate'){
                $is_upgraded = $this->validation_model->isUpgradedUser($userid);
                if($is_upgraded){
                    $this->load->model('register_model');
                    $upgrade_fee = $this->register_model->getRegisterAmount();
                    $monthly_fee=$monthly_fee+$upgrade_fee;
                }
            }*/
            $user_email = $this->validation_model->getUserDetails($userid)['user_detail_email'];
             require_once('application/libraries/stripe-php/init.php');
             $date = date('Y-m-d H:i:s');
              $config = $this->validation_model->getSettings();
             \Stripe\Stripe::setApiKey($config['stripe_secret']);

                        /*$this->ewallet_model->begin();
                        $transaction_id = $this->ewallet_model->getUniqueTransactionId();
                        
                        $up_date1 = $this->ewallet_model->updateBalanceAmountDetailsFrom($userid, round($trans_amt, 8));
                        $previous_endDate=$this->ewallet_model->getSubscriptionEndDate($userid);
                        
                        $this->ewallet_model->insertPaymentDetails($userid, $trans_amt, $transaction_id,$paid_type='',$paid_status='',$payment_method='');
                       
                        $update_endDate=$this->ewallet_model->updateSubscriptionEndDate($userid, $month);
                        if ($up_date1){
                            $this->ewallet_model->commit();
                            
                             $login_id = $this->LOG_USER_ID;
                            $data_array = array();
                        $data_array['transfer_post_array'] = $transfer_post_array;
                        $data = serialize($data_array);
                        $this->validation_model->insertUserActivity($login_id, 'subscription payment',  $data);
                        $msg = lang('monthly_payment_success');
                        $this->redirect($msg, 'user/index', true);
                        }
                         else {
                        $this->ewallet_model->rollback();
                        $msg = lang('monthly_payment_failed');
                        $this->redirect($msg, 'user/index', false);
                    }*/
                   
                    \Stripe\Stripe::setApiKey($this->validation_model->get_stripe_secret_key());
                    $amount=$monthly_fee;
                    if (!$_POST) {
                        $_POST = $_GET;
                    }
                    $row = $this->validation_model->getPreviousStripeDetails($this->LOG_USER_ID);
                    
                      if(count($row)>0){
                        $cust_id=$row['ref'];
                        $order_id = $row['order_id'];
                         $order_recurring_id = $row['order_recurring_id'];
                    }else{
                        
                        $row['ref']=0;
                        $row['order_id']=0;
                        $row['order_recurring_id']=0;
                        $cust_id=$row['ref'];
                        $order_id = $row['order_id'];
                        $order_recurring_id = $row['order_recurring_id'];
                    }
                         $row['recurr_amount']=$amount;
                        
                        $user_id=$this->LOG_USER_ID;
                       
                         $row['prev_end_date']= $this->validation_model->getPreviousEndDate($user_id);
                        $row['user_id']= $user_id;
                        $oc_customer_id = $this->validation_model->getOcCustomerId($user_id);
                        $row['customer_id']= $oc_customer_id;
                        
                        
                   
                         try{
                $customer = \Stripe\Customer::create(array(
                        'email' => $user_email,
                        'source' => $_POST['stripeToken']
            )); 
             }catch (\Stripe\Error\Card $e) {

                $body = $e->getJsonBody();
                $err = $body['error'];
                $error = $err['message'];
                $this->session->set_flashdata('success', $error);
                redirect('/monthly_payment', 'refresh');
            }
            
                        
             if($customer->id) {
                 $item=array(
                            'product_id' => 1,
                            'name' => 'rec1',
                            'quantity' => 1,
                                );
                        $item['recurring']['recurring_id']=1;
                        $item['recurring']['name']='rec1';
                        $item['recurring']['frequency']=1;
                        $item['recurring']['cycle']=1;
                        $item['recurring']['duration']=1;
                        $item['recurring']['price']=$amount;
                        $item['recurring']['trial']='1';
                        $item['recurring']['trial_frequency']='1';
                        $item['recurring']['trial_cycle']='1';
                        $item['recurring']['trial_duration']='1';
                        $item['recurring']['trial_price']='0';
                    $this->ewallet_model->addSubscriptionDetails(serialize($row), 'Repuerchase_reccuring_subcription_fadded from manual restart', $customer->id,0, $item, json_encode($customer),$oc_customer_id);
                    }
                    $curl = new \Stripe\HttpClient\CurlClient();
                    $curl->setEnableHttp2(false);
                    \Stripe\ApiRequestor::setHttpClient($curl);
                     require_once('application/libraries/stripe-php/init.php');
                    \Stripe\Stripe::setApiKey($this->validation_model->get_stripe_secret_key());
                    $ref_id=$customer->id;
                    $ref_id =$this->ewallet_model->getRefFromCustomerId($oc_customer_id);     
                         try {
                        $charge = \Stripe\Charge::create([
                                    'amount' => $amount * 100, // $15.00 this time
                                    'currency' => 'usd',
                                    'customer' => $ref_id, // Previously stored, then retrieved
                        ]);
                        } catch (Exception $exc) {
                             $row['text']= "failed";
                           // $this->addStripResponse($user_id,$order_id, 'Monthly reccuring failed order_id:' . $order_id, json_encode(substr($ex, 0, 1000)));
                            $this->validation_model->addMonthlyRecurringHistory($row, 'Manual Monthly reccuring failed', json_encode(substr($exc, 0, 1000)),'fail');
                            $this->validation_model->reccuringfailHistory($row,json_encode(substr($exc, 0, 1000)));
                            $msg = lang('Subscription renewal failed');
                            $this->redirect($msg, 'user/home', false);
                            //  echo $exc->getTraceAsString();
                        }
            
                        // Retrieve charge details
                        $chargeJson = $charge->jsonSerialize();
                        // Check whether the charge is successful
                        if ($chargeJson['paid'] == 1 && $chargeJson['captured'] == 1) {//$chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && 
                            $pack_type = '';
                             $row['text']= "Manual Stripe Recurring";
                            $this->validation_model->addsubscriptionHistory($row);
                            
                            //$this->addStripResponse($user_id,$order_id,'Monthly reccuring order_id:' . $order_id, json_encode(substr($charge, 0, 1000)));
                            $this->validation_model->updateReccuring($order_recurring_id,$user_id);
                           
                            $this->validation_model->addMonthlyRecurringHistory($row,'Manual Monthly reccuring', json_encode(substr($charge, 0, 1000)),'success');
                            
                            //CALCULATION SECTION STARTS// 
                            $action = 'renewal';
                            $this->load->model('product_model');
                            $this->load->model('binary_model');
                            $oc_order_id=$order_recurring_id;
                            $product_pv=round($amount/2);
                            $product_id=0;
                            $upline_id =$this->validation_model->getFatherId($user_id);
                            $sponsor_id = $this->validation_model->getSponsorId($user_id);
                            $product_amount=$amount;
                            $data['sponsor_id'] =$sponsor_id;
                            $type='renewal';
                            $position=$this->validation_model->getUserPosition($user_id);
                            $this->binary_model->runCalculation($action, $user_id, $product_id, $product_pv, $product_amount, $oc_order_id, $upline_id, 0, $position, $data,$type);
                            
                             $msg = lang('Successfully Restarted Subscription');
                        $this->redirect($msg, 'user/home', true);
                            
                           
                        }
                    
    }
    
    function strip_payment(){
        
        $title = $this->lang->line('monthly_payment');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('monthly_payment');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('monthly_payment');
        $this->HEADER_LANG['page_small_header'] = lang('');
        $this->load_langauge_scripts();
         
        $userid = $this->LOG_USER_ID;
        $msg = '';
        require_once('application/libraries/stripe-php/init.php');
        $config = $this->validation_model->getSettings();
        $key = $config['stripe_key'];//echo $key;die;
        $join_type = $this->validation_model->getUserJoinType($userid);
        $this->set('key', $key);
         $this->setView();
    }
    
       public function strip_pay_post(){
            $user_id = $this->LOG_USER_ID;
            $transfer_post_array = $this->input->post(null, true);
            $userid=$this->LOG_USER_ID;
            $balamount = $this->ewallet_model->getBalanceAmount($userid);
            $monthly_fee= $this->ewallet_model->getMonthlyFee();
            $join_type = $this->validation_model->getUserJoinType($userid);
            $conf_details = $this->configuration_model->getSettings();
            $up_fee = $conf_details['upgrade_amount'];
            $trans_fee = $conf_details['trans_fee']; 
            $join_type = $this->ewallet_model->getUserJoinType($user_id);
            if($join_type == 'customer'){
   
            $user_email = $this->validation_model->getUserDetails($userid)['user_detail_email'];
              
             require_once('application/libraries/stripe-php/init.php');
             $date = date('Y-m-d H:i:s');
              $config = $this->validation_model->getSettings();
             // print_r($config); die;
             $cust_id=0;
             \Stripe\Stripe::setApiKey($config['stripe_secret']);
                    \Stripe\Stripe::setApiKey($this->validation_model->get_stripe_secret_key());
                    $amount=$up_fee;
                    if (!$_POST) {
                        $_POST = $_GET;
                    }
                    
                    $row = $this->validation_model->getPreviousStripeDetails($this->LOG_USER_ID);
                         $row['recurr_amount']=$amount;
                         if(count($row)>0){
                        $cust_id=$row['ref'];
                        $order_id = $row['order_id'];
                         $order_recurring_id = $row['order_recurring_id'];
                    }else{
                        
                        $row['ref']=0;
                        $row['order_id']=0;
                        $row['order_recurring_id']=0;
                        $cust_id=$row['ref'];
                        $order_id = $row['order_id'];
                        $order_recurring_id = $row['order_recurring_id'];
                    }
                        $user_id=$this->LOG_USER_ID;
                        $first_name = $this->validation_model->getUserData($user_id, "user_detail_name");
                        $last_name  = $this->validation_model->getUserData($user_id, "user_detail_second_name");
                        $email      =$this->validation_model->getUserEmailId($user_id); 
                        $row['prev_end_date']= $this->validation_model->getPreviousEndDate($user_id);
                        $row['user_id']= $user_id;
                        $oc_customer_id = $this->validation_model->getOcCustomerId($user_id);
                        $row['customer_id']= $oc_customer_id;
                        if($cust_id){
                             try{
                                $customer = \Stripe\Customer::create(array(
                                'email' => $user_email,
                                'source' => $_POST['stripeToken']
                                )); 
                             }catch (\Stripe\Error\Card $e) {
                                $body = $e->getJsonBody();
                                $err = $body['error'];
                                $error = $err['message'];
                                $this->session->set_flashdata('success', $error);
                                redirect('/strip_payment', 'refresh');
                            }
                        }
                    $curl = new \Stripe\HttpClient\CurlClient();
                    $curl->setEnableHttp2(false);
                    \Stripe\ApiRequestor::setHttpClient($curl);
                     require_once('application/libraries/stripe-php/init.php');
                    \Stripe\Stripe::setApiKey($this->validation_model->get_stripe_secret_key());
                    
                         try {
                              if($cust_id){
                                    $charge = \Stripe\Charge::create([
                                                'amount' => $amount * 100, // $15.00 this time
                                                'currency' => 'usd',
                                                'customer' => $cust_id, // Previously stored, then retrieved
                                                "description" => "upgraded to IBO",
                                                "metadata" => ["first_name" => $first_name,"last_name" => $last_name,"email" =>$email],
                                    ]);
                              }else{
                                    $charge = \Stripe\Charge::create([
                                                'amount' => $amount * 100, // $15.00 this time
                                                'currency' => 'usd',
                                                'customer' => $customer->id, // new customer, then retrieved
                                                "description" => "upgraded to IBO",
                                                "metadata" => ["first_name" => $first_name,"last_name" => $last_name,"email" =>$email],
                                    ]);
                              }
                        } catch (Exception $exc) {
                             $row['text']= "failed";
                             $this->validation_model->add_strip_paymentRecurringHistory($row, 'Manual Monthly reccuring failed', json_encode(substr($exc, 0, 1000)),'fail','payment_fail');
                        }
                        $chargeJson = $charge->jsonSerialize();
                        // Check whether the charge is successful
                        if ($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1) {
                            $pack_type = '';
                             $row['text']= "Manual Stripe Recurring";
                             $this->validation_model->add_strip_paymentRecurringHistory($row,'Manual Monthly reccuring', json_encode(substr($charge, 0, 1000)),'success','payment_success');
                             $result = $this->ewallet_model->upgradeJoinType($user_id);
                            if($result){
                                $rank_status = $this->MODULE_STATUS['rank_status'];
                                if ($rank_status == 'yes') {
                                        $this->load->model('rank_model');
                                        $obj_arr = $this->configuration_model->getRankConfiguration();
                                         $this->rank_model->updateDefaultRank($user_id, $obj_arr['default_rank_id']);
                                 }
                                $history = $this->ewallet_model->insertUpgradeHistory($user_id, $amount, $date,'stripe');
                                
                                $this->ewallet_model->updateFtPack('pck2',$user_id);
                                $msg = lang('success_upgrade');
                                $this->redirect($msg, 'user/home', true);
                            }else{
                                $msg = lang('error_upgrade');
                                $this->redirect($msg, 'user/home', false);
                            }
                        }

 }
            else{
            $msg = lang('already_affiliate');
            $this->redirect($msg, 'user/home', false);
        }
                    
    }
}
