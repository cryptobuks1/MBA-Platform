<?php

require_once 'Inf_Controller.php';

class Ewallet extends Inf_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('profile_model');
        $this->url_permission('ewallet_status');
    }

    function fund_transfer()
    {

        $title = lang('fund_transfer');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);
        $this->set('action_page', $this->CURRENT_URL);

        $help_link = 'fund-transfer';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('fund_transfer');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('fund_transfer');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $msg = '';
        $this->set('transaction_note', '');
        $this->set('amount', '');
        $this->set('to_user', '');
        $this->set('bal_amount', '');
        $this->set('from_user', '');
        $this->set('total_req_amount', 0);
        $this->set("step1", '');
        $this->set("step2", ' none');
        $trans_fee = $this->ewallet_model->getTransactionFee();
        $this->set('trans_fee', $trans_fee);
        $response['error'] = false;
        if ((!$this->input->post('dotransfer')) && $this->input->post('transfer')) {

            $this->post_fund_transfer();
        }
        if ($this->input->post('dotransfer')) {

            $post_arr = $this->input->post(null, true);
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);

            $from_user = $post_arr['user_name'];
            $from_user_id = $this->ewallet_model->userNameToID($from_user);
            $bal_amount = $this->ewallet_model->getBalanceAmount($from_user_id);

            $to_user = $post_arr['to_user_name'];
            $to_user_id = $this->ewallet_model->userNameToID($to_user);
            $trans_amount = round($post_arr['amount1'] / $this->DEFAULT_CURRENCY_VALUE, 8);

            $total_req_amount = $trans_amount + $trans_fee;

            $transaction_note = $post_arr['tran_concept'];

            $data = [
                "transaction_note" => $transaction_note,
                "bal_amount" => $bal_amount,
                "to_user" => $to_user,
                "amount" => $trans_amount,
                "from_user" => $from_user,
                "total_req_amount" => $total_req_amount,
            ];
            $response['data'] = $data;
            echo json_encode($response);
            exit();
        }

        $this->setView();
    }

    public function validate_transfer()
    {
        $this->form_validation->set_rules('user_name', 'lang:user_name', 'trim|required|user_exists');
        $this->form_validation->set_rules('to_user_name', 'lang:user_name', 'trim|required|user_exists|differs[user_name]', ['differs' => lang('invalid_user_selection')]);
        $this->form_validation->set_rules('amount1', 'lang:amount', 'trim|required|greater_than[0]');
        $this->form_validation->set_rules('tran_concept', 'lang:transaction_note', 'trim|required');
        $validate_form = $this->form_validation->run_with_redirect('ewallet/fund_transfer');
        return $validate_form;
    }

    function getLegAmount($user_name = '')
    {
        $text = '';
        $span = '';
        $span2 = '';
        if ($user_name != '' && strcmp($user_name, "/") > 0) {
            $user = $this->ewallet_model->userNameToID($user_name);
            if ($user) {
                $bal_amount = $this->ewallet_model->getBalanceAmount($user);
                $balance_amount = lang('balance_amount');
                if ($this->DEFAULT_SYMBOL_LEFT) {
                    $span = '<span class="input-group-addon">' . $this->DEFAULT_SYMBOL_LEFT . '</span>';
                }
                if ($this->DEFAULT_SYMBOL_RIGHT) {
                    $span2 = '<span class="input-group-addon">' . $this->DEFAULT_SYMBOL_RIGHT . '</span>';
                }
                $text = '<label">' .
                    $balance_amount .
                    '</label>
                <div class="input-group m-b">' . $span . '
                    ' . '<input class="form-control" type="text" id="blnc" name="blnc" value=' . round($bal_amount * $this->DEFAULT_CURRENCY_VALUE, $this->PRECISION) . ' readonly />' . $span2 .
                    '</div>';
            }
        }
        echo $text;
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

        $amount_details = $this->ewallet_model->getAllEwalletAmounts();
        $msg = '';
        if ($this->input->post('transfer') && $this->validate_ewallet_pin_purchase()) {
            $post_arr = $this->input->post(null, true);
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);

            $user_name = $post_arr['user_name'];
            $pin_count = $post_arr['pin_count'];
            $amount_id = $post_arr['amount'];
            $user_id = $this->validation_model->userNameToId($user_name);
            if ($user_id == $this->ADMIN_USER_ID) {
                $msg = lang('you_cant_use_admin_account');
                $this->redirect($msg, 'ewallet/ewallet_pin_purchase', false);
            }

            if ($user_id != $this->ADMIN_USER_ID) {
                $balamount = $this->ewallet_model->getBalanceAmount($user_id);

                if ($pin_count > 0 && $amount_id != '' && is_numeric($pin_count)) {

                    $amount = $this->ewallet_model->getEpinAmount($amount_id);
                    $tot_avb_amt = $amount * $pin_count;

                    if ($tot_avb_amt <= $balamount) {

                        $uploded_date = date('Y-m-d H:i:s');
                        $expiry_date = date('Y-m-d', strtotime('+6 months', strtotime($uploded_date)));
                        $purchase_status = 'yes';
                        $status = 'yes';
                        $res = false;

                        $max_active_pincount = $this->ewallet_model->getMaxPinCount();
                        $current_active_pin_count = $this->ewallet_model->getAllActivePinspage($purchase_status);
                        if ($current_active_pin_count < $max_active_pincount) {
                            $balance_count = $max_active_pincount - $current_active_pin_count;
                            if ($pin_count <= $balance_count) {

                                $this->ewallet_model->begin();

                                $transaction_id = $this->ewallet_model->getUniqueTransactionId();
                                $res = $this->ewallet_model->generatePasscode($pin_count, $status, $uploded_date, $amount, $expiry_date, $purchase_status, $amount_id, $user_id, $this->ADMIN_USER_ID, $transaction_id);

                                if ($res) {
                                    $bal = round($balamount - $tot_avb_amt, 8);
                                    $update = $this->ewallet_model->updateBalanceAmount($user_id, $bal);
                                    if ($update) {
                                        $this->ewallet_model->commit();
                                        $data = serialize($post_arr);
                                        $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'epin purchased using ewallet', $this->LOG_USER_ID, $data);

                                        // Employee Activity History
                                        if ($this->LOG_USER_TYPE == 'employee') {
                                            $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'purchase_epin_by_ewallet', 'EPIN Purchased Using E-Wallet By ' . $user_name);
                                        }
                                        //

                                        $msg = lang('epin_purchased_successfully');
                                        $this->redirect($msg, 'ewallet/ewallet_pin_purchase', true);
                                    } else {
                                        $this->ewallet_model->rollback();
                                        $msg = lang('error_on_epin_purchase');
                                        $this->redirect($msg, 'ewallet/ewallet_pin_purchase', false);
                                    }
                                } else {
                                    $this->ewallet_model->rollback();
                                    $msg = lang('error_on_epin_purchase');
                                    $this->redirect($msg, 'ewallet/ewallet_pin_purchase', false);
                                }
                            } else {
                                $msg = sprintf(lang('only_few_epins_can_be_generated'), $balance_count);
                                $this->redirect($msg, 'ewallet/ewallet_pin_purchase', false);
                            }
                        } else {
                            $msg1 = lang('already');
                            $msg2 = lang('epin_present');
                            $this->redirect($msg1 . $current_active_pin_count . $msg2, 'ewallet/ewallet_pin_purchase', false);
                        }
                    } else {
                        $msg = lang('no_sufficient_balance_amount');
                        $this->redirect($msg, 'ewallet/ewallet_pin_purchase', false);
                    }
                } else {
                    $msg = lang('error_on_purchasing_epin_please_try_again');
                    $this->redirect($msg, 'ewallet/ewallet_pin_purchase', false);
                }
            }
        }

        $this->set('amount_details', $amount_details);
        $this->setView();
    }

    public function validate_ewallet_pin_purchase()
    {
        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|callback_valid_user');
        $this->form_validation->set_rules('amount', lang('amount'), 'trim|required|greater_than[0]');
        $this->form_validation->set_rules('pin_count', lang('epin_count'), 'trim|required|integer|greater_than[0]');

        $validate_form = $this->form_validation->run();
        return $validate_form;
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

    function fund_management()
    {
        $this->set('action_page', $this->CURRENT_URL);
        $title = lang('ewallet_fund_management');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);
        $help_link = 'add-deduct-fund';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('ewallet_fund_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('ewallet_fund_management');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $msg = '';

        $this->setView();
    }

    public function validate_fund_management()
    {
        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|callback_valid_user');
        $this->form_validation->set_rules('amount', lang('amount'), 'trim|required|greater_than[0]|max_length[5]');
        $this->form_validation->set_rules('tran_concept', lang('transaction_note'), 'trim|required');
        $this->form_validation->set_message('max_length', lang('maximum_five_digit'));
        $validate_form = $this->form_validation->run_with_redirect('ewallet/fund_management');
        return $validate_form;
    }

    function my_transfer_details()
    {
        $title = lang('transfer_details');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);
        $help_link = 'my-transfer';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('transfer_details');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('transfer_details');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $weekdate = $this->input->post('weekdate', true);
        $daily = $this->input->post('daily', true);
        $this->set('weekdate', $weekdate);
        $this->set('daily', $daily);
//        if ($this->input->post('weekdate') && $this->validate_my_transfer_details_weekdate()) {
        if ($this->input->post('weekdate')) {
            $post_arr = $this->input->post(null, true);
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $user_name = $post_arr['user_name'];
            $recieved_user_name = $post_arr['recieved_user_name'];
            if ($user_name == '' && $recieved_user_name == '' && $post_arr['week_date1'] == '' && $post_arr['week_date2'] == '') {
                $msg = lang('Please select atleast one criteria.');
                $this->redirect($msg, 'ewallet/my_transfer_details', false);
            }
            if ($user_name != '') {
                $user_id = $this->ewallet_model->userNameToID($user_name);
                if (!$user_id) {
                    $msg = lang('invalid_user_name');
                    $this->redirect($msg, 'ewallet/my_transfer_details', false);
                } else {
                    $user_id = $user_id;
                }
            } else {
                $user_id = '';
            }
            if ($recieved_user_name != '') {
                $recieved_user_id = $this->ewallet_model->userNameToID($recieved_user_name);
                if (!$recieved_user_id) {
                    $msg = lang('invalid_user_name');
                    $this->redirect($msg, 'ewallet/my_transfer_details', false);
                } else {
                    $recieved_user_id = $recieved_user_id;
                }
            } else {
                $recieved_user_id = '';
            }
            if ($post_arr['week_date1'] != '') {
                $from_date = $post_arr['week_date1'] . ' 00:00:00';
            } else {
                $from_date = '';
            }
            if ($post_arr['week_date2'] != '') {
                $to_date = $post_arr['week_date2'] . ' 23:59:59';
            } else {
                $to_date = '';
            }
            $details = $this->ewallet_model->getAllEwalletDetails($user_id, $from_date, $to_date, $recieved_user_id);
            $this->set('details', $this->security->xss_clean($details));
//            $this->set('user_name', $user_name);
            $details_count = count($details);
            $this->set('details_count', $details_count);
        }
//        if ($this->input->post('daily') && $this->validate_my_transfer_details_daily()) {
        if ($this->input->post('daily')) {
            $post_arr = $this->input->post(null, true);
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            if ($post_arr['week_date3'] == '') {
                $msg = lang('please_select_date');
                $this->redirect($msg, 'ewallet/my_transfer_details', false);
            }
            if ($post_arr['user_name1'] != '') {
                $user_name = $post_arr['user_name1'];
                $user_id = $this->ewallet_model->userNameToID($user_name);
                if (!$user_id) {
                    $msg = lang('invalid_user_name');
                    $this->redirect($msg, 'ewallet/my_transfer_details', false);
                } else {
                    $user_id = $user_id;
                }
            } else {
                $user_id = '';
            }
            if ($post_arr['recieved_user_name1'] != '') {
                $recieved_user_id = $this->ewallet_model->userNameToID($post_arr['recieved_user_name1']);
                if (!$recieved_user_id) {
                    $msg = lang('invalid_user_name');
                    $this->redirect($msg, 'ewallet/my_transfer_details', false);
                } else {
                    $recieved_user_id = $recieved_user_id;
                }
            } else {
                $recieved_user_id = '';
            }
            if ($post_arr['week_date3'] != '') {
                $from_date = $post_arr['week_date3'] . ' 00:00:00';
            } else {
                $from_date = '';
            }
            if ($post_arr['week_date3'] != '') {
                $to_date = $post_arr['week_date3'] . ' 23:59:59';
            } else {
                $to_date = '';
            }
            $details = $this->ewallet_model->getAllEwalletDetails($user_id, $from_date, $to_date, $recieved_user_id);
            $this->set('details', $this->security->xss_clean($details));
//            $this->set('user_name', $user_name);
            $details_count = count($details);
            $this->set(
                'details_count',
                $details_count
            );
        }
        $this->setView();
    }

    function my_ewallet()
    {

        $title = lang('transfer_details');
        $this->set('title', $this->COMPANY_NAME . ' |' . $title);

        $help_link = 'my-e-wallet';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('ewallet_details');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('ewallet_details');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        if ($this->input->get('user_name') && $this->input->get('from_report')) {
            $user_name = ($this->input->get('user_name', true));
            $user_id = $this->validation_model->userNameToID($user_name);
            if (!$user_id) {
                $this->session->unset_userdata('inf_search_user_id');
                $msg = lang('Username_not_Exists');
                $this->redirect($msg, 'ewallet/my_ewallet', false);
            }
            $this->session->set_userdata('inf_search_user_id', $user_id);
            $top_earners = ($this->input->get('from_report', true));
            $this->session->set_userdata('from_report', $top_earners);
        } elseif ($this->input->post('user_name')) {
            $user_name = ($this->input->post('user_name', true));
            $user_id = $this->validation_model->userNameToID($user_name);
            if (!$user_id) {
                $this->session->unset_userdata('inf_search_user_id');
                $msg = lang('Username_not_Exists');
                $this->redirect($msg, 'ewallet/my_ewallet', false);
            }
            $this->session->set_userdata('inf_search_user_id', $user_id);
            if ($this->session->has_userdata('from_report')) {
                $this->session->unset_userdata('from_report');
            }
        } elseif (!$this->session->userdata('inf_search_user_id')) {
            $this->session->set_userdata('inf_search_user_id', $this->validation_model->getAdminId());
        }
        if ($this->session->has_userdata('inf_search_user_id')) {
            $user_id = $this->session->userdata('inf_search_user_id');
            $user_name = $this->validation_model->IdToUserName($user_id);

            $base_url = base_url() . 'admin/ewallet/my_ewallet';
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
            $this->set('valid_user', true);
            $this->set('user_name', $user_name);
            $this->set('ewallet_details', $this->security->xss_clean($ewallet_details));
            $this->set('previous_ewallet_balance', $previous_ewallet_balance);
            $this->set('ewallet_balance', $ewallet_balance);
            if ($this->session->has_userdata('from_report')) {
                $this->set('from_report', true);
            } else {
                $this->set('from_report', false);
            }
        } else {
            $this->set('valid_user', false);
            $this->set('from_report', false);
        }

        if($this->input->post('overview_disp')) {
            $this->set('overview_disp', true);
        } else {
            $this->set('overview_disp', false);
        }

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

    function business_wallet()
    {
        $title = lang('business_wallet');
        $this->set('title', $this->COMPANY_NAME . ' |' . $title);
        $help_link = 'my-e-wallet';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('business_wallet');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('business_wallet');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id = '';
        $user_name = '';
        if ($this->input->post('user_name')) {
            $user_name = ($this->input->post('user_name', true));
            $user_id = $this->validation_model->userNameToID($user_name);
            if (!$user_id) {
                $msg = lang('Username_not_Exists');
                $this->redirect($msg, 'ewallet/business_wallet', false);
            }
        }

        $details = $this->ewallet_model->getEwalletSummary("",$user_id);
        $detail_in_year = $this->ewallet_model->getEwalletSummary('year',$user_id);
        $detail_in_month = $this->ewallet_model->getEwalletSummary('month',$user_id);

        $this->set('details', $details);
        $this->set('year_details',$detail_in_year);
        $this->set('month_details',$detail_in_month);
        $this->set('user_name', $user_name);

        $this->lang->load('amount_type', $this->LANG_NAME);
        $this->setView();
    }

    function post_fund_transfer()
    {

        if ($this->input->post() && $this->validate_transfer()) {
            $transfer_post_array = $this->input->post(null, true);
            $transfer_post_array = $this->validation_model->stripTagsPostArray($transfer_post_array);
            $otp_stat = $this->getOtpStat(true);
            if ($otp_stat) {
                $otp = $transfer_post_array['otp'] ?? false;
                if ($otp) {
                    if (!empty($this->session->userdata('fund_otp'))) {
                        if ($otp == $this->session->userdata('fund_otp')) {
                            $this->session->unset_userdata('fund_otp');
                        } else {
                            $msg = lang('invalid_otp');
                            $this->redirect($msg, 'ewallet/fund_transfer', false);
                        }
                    } else {
                        $msg = lang('otp_expired');
                        $this->redirect($msg, 'ewallet/fund_transfer', false);
                    }
                } else {
                    $msg = lang('otp_required');
                    $this->redirect($msg, 'ewallet/fund_transfer', false);
                }
            }
            $userid = $this->LOG_USER_ID;
            $trans_fee = $this->ewallet_model->getTransactionFee();
            $tran_pswd = base64_decode(urldecode($transfer_post_array['pswd']));
            $from_user = $transfer_post_array['from_user'];
            $from_user_id = $this->ewallet_model->userNameToID($from_user);
            $to_user_name = $transfer_post_array['to_username'];
            $to_user_id = $this->ewallet_model->userNameToID($to_user_name);
            $trans_amount = $transfer_post_array['amount1'];
            $trans_amount = round($trans_amount / $this->DEFAULT_CURRENCY_VALUE, 8);
            $transaction_concept = $this->validation_model->textAreaLineBreaker($transfer_post_array['transaction_note']);
            $total_req_amount = $trans_amount + $trans_fee;
            $pass = $this->ewallet_model->getUserPassword($from_user_id);
            $balamount = $this->ewallet_model->getBalanceAmount($from_user_id);
            if ($total_req_amount <= $balamount) {
                if (password_verify($tran_pswd, $pass)) {
                    $this->ewallet_model->begin();
                    $transaction_id = $this->ewallet_model->getUniqueTransactionId();

                    $up_date1 = $this->ewallet_model->updateBalanceAmountDetailsFrom($from_user_id, round($total_req_amount, 8));
                    $up_date2 = $this->ewallet_model->updateBalanceAmountDetailsTo($to_user_id, round($trans_amount, 8));
                    $this->ewallet_model->insertBalAmountDetails($from_user_id, $to_user_id, round($trans_amount, 8), $amount_type = '', $transaction_concept, $trans_fee, $transaction_id);
                    if ($up_date1 && $up_date2) {
                        $this->ewallet_model->commit();
                        $login_user_type = $this->LOG_USER_TYPE;
                        $data = serialize($transfer_post_array);
                        $this->validation_model->insertUserActivity($from_user_id, 'fund transferred', $this->LOG_USER_ID, $data);

                        // Employee Activity History
                        if ($this->LOG_USER_TYPE == 'employee') {
                            $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'transfer_fund', 'Fund Transferred');
                        }
                        //

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

    public function post_fund_management()
    {
        $post_arr = $this->input->post(null, true);
        $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
        $userid = $this->LOG_USER_ID;
        $to_user = $post_arr['user_name'];
        $user_type = $this->LOG_USER_TYPE;
        $transaction_concept = $this->validation_model->textAreaLineBreaker($post_arr['tran_concept']);
        $user = $this->validation_model->userNameToID($to_user);
        $to_userid = $this->ewallet_model->userNameToID($to_user);
        $amount = $post_arr['amount'] * (1 / $this->DEFAULT_CURRENCY_VALUE);
        $user_exists = $this->ewallet_model->isUserNameAvailable($to_user);
        $default_currency_left_symbol = ($this->DEFAULT_SYMBOL_LEFT != '') ? $this->DEFAULT_SYMBOL_LEFT : "";
        if ($this->input->post('add_amount') && $this->validate_fund_management()) {
            if ($user_exists) {
                if (is_numeric($amount) && $amount > 0) {
                    $this->ewallet_model->begin();
                    $transaction_id = $this->ewallet_model->getUniqueTransactionId();
                    $up_date = $this->ewallet_model->addUserBalanceAmount($to_userid, round($amount, 8));
                    $this->ewallet_model->insertBalAmountDetails($userid, $to_userid, round($amount, 8), 'admin_credit', $transaction_concept, '0', $transaction_id);
                    if ($up_date) {
                        $this->ewallet_model->commit();
                        $data = serialize($post_arr);
                        $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Fund added to ' . $to_user . '`s e-wallet ' . $post_arr['amount'], $this->LOG_USER_ID, $data);

                        // Employee Activity History
                        if ($this->LOG_USER_TYPE == 'employee') {
                            $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'add_fund', 'Fund added to e-wallet');
                        }
                        //

                        $msg = lang('fund_credited_successfully');
                        $this->redirect($msg, 'ewallet/fund_management', true);
                    } else {
                        $this->ewallet_model->rollback();
                        $msg = lang('error_on_crediting_fund');
                        $this->redirect($msg, 'ewallet/fund_management', false);
                    }
                } else {
                    $msg = lang('error_on_crediting_fund_please_check_the_amount');
                    $this->redirect($msg, 'ewallet/fund_management', false);
                }
            } else {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'ewallet/fund_management', false);
            }
        } else if ($this->input->post('deduct_amount') && $this->validate_fund_management()) {
            if ($user_exists) {
                $bal_amount = $this->ewallet_model->getBalanceAmount($to_userid);
                if (is_numeric($amount) && $amount > 0 && $bal_amount >= $amount) {
                    $this->ewallet_model->begin();
                    $transaction_id = $this->ewallet_model->getUniqueTransactionId();
                    $up_date = $this->ewallet_model->deductUserBalanceAmount($to_userid, round($amount, 8));
                    $this->ewallet_model->insertBalAmountDetails($userid, $to_userid, round($amount, 8), 'admin_debit', $transaction_concept, ' ', $transaction_id);
                    $user_level = $this->ewallet_model->getUserLevel($to_userid);
                    //$this->ewallet_model->insertReleasedDetails($to_userid, $amount, $user_level, $transaction_id);

                    if ($up_date) {
                        $this->ewallet_model->commit();
                        $data = serialize($post_arr);
                        $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Fund deducted from ' . $to_user . '`s  E-Wallet ' . $amount, $this->LOG_USER_ID, $data);

                        // Employee Activity History
                        if ($this->LOG_USER_TYPE == 'employee') {
                            $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'deduct_fund', 'Fund deducted from E-Wallet');
                        }
                        //

                        $msg = lang('fund_deducted_successfully');
                        $this->redirect($msg, 'ewallet/fund_management', true);
                    } else {
                        $this->ewallet_model->rollback();
                        $msg = lang('error_on_deducting_fund');
                        $this->redirect($msg, 'ewallet/fund_management', false);
                    }
                } else {
                    $msg = lang('error_on_deducting_fund_please_check_the_amount');
                    $this->redirect($msg, 'ewallet/fund_management', false);
                }
            } else {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'ewallet/fund_management', false);
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
    public function fundOtpModal()
    {
        $status = false;
        $otp = rand(pow(10, 4), pow(10, 5) - 1);
        if ($otp) {
            if (!empty($this->session->userdata('fund_otp')))
                $this->session->unset_userdata('fund_otp');
            $type = lang('fund_tranfer');
            $this->mail_model->sendOtpMail($otp, $this->validation_model->getUserEmailId($this->validation_model->getAdminId()), $type);
            $this->session->set_userdata('fund_otp', $otp);
            echo $status = true;
            exit;
        } else {
            echo $status;
            exit;
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

//For Purchase Wallet Starts
function purchase_wallet() {

        $title = lang('transfer_details');
        $this->set('title', $this->COMPANY_NAME . ' |' . $title);

        $help_link = 'purchase-wallet';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('purchase_wallet_details');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('purchase_wallet_details');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->url_permission('purchase_wallet');
        $this->load_langauge_scripts();
        if ($this->input->get('user_name') && $this->input->get('from_report')) {
            $user_name = ($this->input->get('user_name', true));
            $user_id = $this->validation_model->userNameToID($user_name);
            if (!$user_id) {
                $this->session->unset_userdata('inf_psearch_user_id');
                $msg = lang('Username_not_Exists');
                $this->redirect($msg, 'ewallet/purchase_wallet', false);
            }
            $this->session->set_userdata('inf_psearch_user_id', $user_id);
            $top_earners = ($this->input->get('from_report', true));
            $this->session->set_userdata('from_report', $top_earners);
        } elseif ($this->input->post('user_name')) {
            $user_name = ($this->input->post('user_name', true));
            $user_id = $this->validation_model->userNameToID($user_name);
            if (!$user_id) {
                $this->session->unset_userdata('inf_psearch_user_id');
                $msg = lang('Username_not_Exists');
                $this->redirect($msg, 'ewallet/purchase_wallet', false);
            }
            $this->session->set_userdata('inf_psearch_user_id', $user_id);
            if ($this->session->has_userdata('from_report')) {
                $this->session->unset_userdata('from_report');
            }
        } elseif (!$this->session->userdata('inf_psearch_user_id')) {
            $this->session->set_userdata('inf_psearch_user_id', $this->validation_model->getAdminId());
        }

        if ($this->session->has_userdata('inf_psearch_user_id')) {
            $user_id = $this->session->userdata('inf_psearch_user_id');
            $user_name = $this->validation_model->IdToUserName($user_id);

            $base_url = base_url() . 'admin/ewallet/purchase_wallet';
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
            $this->set('valid_user', true);
            $this->set('user_name', $user_name);
            $this->set('ewallet_details', $this->security->xss_clean($ewallet_details));
            $this->set('previous_ewallet_balance', $previous_ewallet_balance);
            $this->set('ewallet_balance', $ewallet_balance);
            if ($this->session->has_userdata('from_report')) {
                $this->set('from_report', true);
            } else {
                $this->set('from_report', false);
            }
        } else {
            $this->set('valid_user', false);
            $this->set('from_report', false);
        }

        if($this->input->post('overview_disp')) {
            $this->set('overview_disp', true);
        } else {
            $this->set('overview_disp', false);
        }

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
//For Purchase Wallet Ends

    function all_transactions()
    {

        $title = lang('all_transactions');
        $this->set('title', $this->COMPANY_NAME . ' |' . $title);

        $help_link = 'all-transactions';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('all_transactions');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('all_transactions');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id = '';
        $user_name = '';
        $filter_debit_credit = '';
        $filter_category = '';
        $filter_date = '';
        if ($this->input->post('user_name')) {
            $user_name = ($this->input->post('user_name', true));
            $user_id = $this->validation_model->userNameToID($user_name);
            if (!$user_id) {
                $this->session->unset_userdata('inf_all_trans_user');
                $msg = lang('Username_not_Exists');
                $this->redirect($msg, 'ewallet/all_transactions', false);
            }
            $this->session->set_userdata('inf_all_trans_user', $user_id);
        }
        if ($this->input->post('filter')) {
            $post_data = $this->input->post();
            if (isset($post_data['debit_credit'])) {
                $filter_debit_credit = $this->input->post('debit_credit');
                $this->session->set_userdata('inf_all_trans_debit_credit', $filter_debit_credit);
            }
            if (isset($post_data['category'])) {
                $filter_category = $this->input->post('category');
                $this->session->set_userdata('inf_all_trans_category', $filter_category);
            }
            if (isset($post_data['date'])) {
                $filter_date = $this->input->post('date');
                $this->session->set_userdata('inf_all_trans_date', $filter_date);
            }
            if (isset($post_data['clear'])) {
                $this->session->unset_userdata('inf_all_trans_user');
                $this->session->unset_userdata('inf_all_trans_debit_credit');
                $this->session->unset_userdata('inf_all_trans_category');
                $this->session->unset_userdata('inf_all_trans_date');
            }
            exit();
        }
        if ($this->session->has_userdata('inf_all_trans_user')) {
            $user_id = $this->session->userdata('inf_all_trans_user');
            $user_name = $this->validation_model->IdToUserName($user_id);
        }
        if ($this->session->has_userdata('inf_all_trans_debit_credit')) {
            $filter_debit_credit = $this->session->userdata('inf_all_trans_debit_credit');
        }
        if ($this->session->has_userdata('inf_all_trans_category')) {
            $filter_category = $this->session->userdata('inf_all_trans_category');
        }
        if ($this->session->has_userdata('inf_all_trans_date')) {
            $filter_date = $this->session->userdata('inf_all_trans_date');
        }

        $base_url = base_url() . 'admin/ewallet/all_transactions';
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        // $config['per_page'] = 50;
        $page = $this->uri->segment(4) ?: 0;

        $count = $this->ewallet_model->getAllEwalletTransactionCount($user_id, $filter_debit_credit, $filter_category, $filter_date);
        $all_transaction = $this->ewallet_model->getAllEwalletTransaction($user_id, $filter_debit_credit, $filter_category, $filter_date, $page, $config['per_page']);
        $config['total_rows'] = $count;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();

        $this->set('result_per_page', $result_per_page);
        $this->set('page_id', $page);
        $this->set('user_name', $user_name);
        $this->set('debit_credit', $filter_debit_credit);
        $this->set('category', $filter_category);
        $this->set('date', $filter_date);
        $this->set('all_transaction', $this->security->xss_clean($all_transaction['data']));
        $this->set('categories', $all_transaction['categories']);

        $this->lang->load('amount_type', $this->LANG_NAME);

        $this->setView();
    }

    function outward_funds() {

        $title = lang('withdrawal_outward_fund');
        $this->set('title', $this->COMPANY_NAME . ' |' . $title);

        $help_link = 'withdrawal_outward_fund';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('withdrawal_outward_fund');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('withdrawal_outward_fund');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id = '';
        $user_name = '';
        $filter_category = '';
        $filter_date = '';
        if ($this->input->post('user_name')) {
            $user_name = ($this->input->post('user_name', true));
            $user_id = $this->validation_model->userNameToID($user_name);
            if (!$user_id) {
                $this->session->unset_userdata('inf_outward_user');
                $msg = lang('Username_not_Exists');
                $this->redirect($msg, 'ewallet/outward_funds', false);
            }
            $this->session->set_userdata('inf_outward_user', $user_id);
        }
        if ($this->input->post('filter')) {
            $post_data = $this->input->post();
            if (isset($post_data['category'])) {
                $filter_category = $this->input->post('category');
                $this->session->set_userdata('inf_outward_category', $filter_category);
            }
            if (isset($post_data['date'])) {
                $filter_date = $this->input->post('date');
                $this->session->set_userdata('inf_outward_date', $filter_date);
            }
            if (isset($post_data['clear'])) {
                $this->session->unset_userdata('inf_outward_user');
                $this->session->unset_userdata('inf_outward_category');
                $this->session->unset_userdata('inf_outward_date');
            }
            exit();
        }
        if ($this->session->has_userdata('inf_outward_user')) {
            $user_id = $this->session->userdata('inf_outward_user');
            $user_name = $this->validation_model->IdToUserName($user_id);
        }
        if ($this->session->has_userdata('inf_outward_category')) {
            $filter_category = $this->session->userdata('inf_outward_category');
        }
        if ($this->session->has_userdata('inf_outward_date')) {
            $filter_date = $this->session->userdata('inf_outward_date');
        }

        $base_url = base_url() . 'admin/ewallet/outward_funds';
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $page = $this->uri->segment(4) ?: 0;

        $count = $this->ewallet_model->getEwalletOutwardFundCount($user_id, $filter_category, $filter_date);
        $all_transaction = $this->ewallet_model->getEwalletOutwardFundDetails($user_id, $filter_category, $filter_date, $page, $config['per_page']);
        $config['total_rows'] = $count;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();

        $this->set('result_per_page', $result_per_page);
        $this->set('page_id', $page);
        $this->set('user_name', $user_name);
        $this->set('category', $filter_category);
        $this->set('date', $filter_date);
        $this->set('all_transaction', $this->security->xss_clean($all_transaction['data']));
        $this->set('categories', $all_transaction['categories']);

        $this->lang->load('amount_type', $this->LANG_NAME);

        $this->setView();

    }

    function business_summary()
    {
        $title = lang('business_summary');
        $this->set('title', $this->COMPANY_NAME . ' |' . $title);
        $help_link = 'business-summary';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('business_summary');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('business_summary');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $from_date='';
        $to_date='';
        
        if ($this->input->post('submit')) {
            if (($this->input->post('week_date1') != '') && ($this->input->post('week_date2') != '')) {
                if (($this->input->post('week_date1')) > ($this->input->post('week_date2'))) {
                    $msg = lang('To-Date should be greater than From-Date');
                    $this->redirect($msg, 'ewallet/business_summary', FALSE);
                }
            }

            $from_date = (strip_tags($this->input->post("week_date1", TRUE)));
            $to_date = (strip_tags($this->input->post("week_date2", TRUE)));
            $from_date .=" 00:00:00";
            if($from_date !='' && $to_date == ''){
                    $to_date=(strip_tags($this->input->post("week_date1", TRUE)))." 23:59:59";
                      $report_date = lang('from') . "\t" . $from_date;
                }else{
            $to_date .= " 23:59:59";
            if ($from_date != '' && $to_date != '') {
                $report_date = lang('from') . "\t" . $from_date . "\t" . lang('to') . "\t" . $to_date;
            } else if ($from_date != '') {
                $report_date = lang('from') . "\t" . $from_date;
            }  else if($from_date !='' && (strip_tags($this->input->post("week_date2", TRUE))) == ''){
                    $to_date=(strip_tags($this->input->post("week_date1", TRUE)))." 23:59:59";
                }else if ($to_date != '') {
                $report_date = lang('to') . "\t" . $to_date;
            } else {
                $report_date = '';
            }
                }
            $this->session->set_userdata("inf_commision_week_date1", $from_date);
            $this->session->set_userdata("inf_commision_week_date2", $to_date);
        }
        $details = $this->ewallet_model->getBusinessWalletDetails($from_date, $to_date);
      //  print_r($details);die;
        $detail_in_year = $this->ewallet_model->getBusinessWalletDetails('year');
        $detail_in_month = $this->ewallet_model->getBusinessWalletDetails('month');

        $this->set('details', $details);
        $this->set('year_details', $detail_in_year);
        $this->set('month_details', $detail_in_month);

        $this->lang->load('amount_type', $this->LANG_NAME);
        $this->setView();
    }

    public function business_transactions()
    {
     $title = lang('business_transactions');
        $this->set('title', $this->COMPANY_NAME . ' |' . $title);

        $help_link = 'business-transactions';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('business_transactions');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('business_transactions');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id = '';
        $user_name = '';
        $filter_debit_credit = '';
        $filter_category = '';
        $filter_date = '';
        if ($this->input->post('user_name')) {
            $user_name = ($this->input->post('user_name', true));
            $user_id = $this->validation_model->userNameToID($user_name);
            if (!$user_id) {
                $this->session->unset_userdata('inf_business_trans_user');
                $msg = lang('Username_not_Exists');
                $this->redirect($msg, 'ewallet/business_transactions', false);
            }
            $this->session->set_userdata('inf_business_trans_user', $user_id);
        }
        if ($this->input->post('filter')) {
            $post_data = $this->input->post();
            if (isset($post_data['debit_credit'])) {
                $filter_debit_credit = $this->input->post('debit_credit');
                $this->session->set_userdata('inf_business_trans_debit_credit', $filter_debit_credit);
            }
            if (isset($post_data['category'])) {
                $filter_category = $this->input->post('category');
                $this->session->set_userdata('inf_business_trans_category', $filter_category);
            }
            if (isset($post_data['date'])) {
                $filter_date = $this->input->post('date');
                $this->session->set_userdata('inf_business_trans_date', $filter_date);
            }
            if (isset($post_data['clear'])) {
                $this->session->unset_userdata('inf_business_trans_user');
                $this->session->unset_userdata('inf_business_trans_debit_credit');
                $this->session->unset_userdata('inf_business_trans_category');
                $this->session->unset_userdata('inf_business_trans_date');
            }
            exit();
        }
        if ($this->session->has_userdata('inf_business_trans_user')) {
            $user_id = $this->session->userdata('inf_business_trans_user');
            $user_name = $this->validation_model->IdToUserName($user_id);
        }
        if ($this->session->has_userdata('inf_business_trans_debit_credit')) {
            $filter_debit_credit = $this->session->userdata('inf_business_trans_debit_credit');
        }
        if ($this->session->has_userdata('inf_business_trans_category')) {
            $filter_category = $this->session->userdata('inf_business_trans_category');
        }
        if ($this->session->has_userdata('inf_business_trans_date')) {
            $filter_date = $this->session->userdata('inf_business_trans_date');
        }

        $base_url = base_url() . 'admin/ewallet/business_transactions';
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        // $config['per_page'] = 50;
        $page = $this->uri->segment(4) ?: 0;
        $count = $this->ewallet_model->getAllTransactionCount($user_id, $filter_debit_credit, $filter_category, $filter_date);
        $all_transaction = $this->ewallet_model->getAllTransaction($user_id, $filter_debit_credit, $filter_category, $filter_date, $page, $config['per_page']);
        //print_r($all_transaction); die;
        $config['total_rows'] = $count;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();

        $this->set('result_per_page', $result_per_page);
        $this->set('page_id', $page);
        $this->set('user_name', $user_name);
        $this->set('debit_credit', $filter_debit_credit);
        $this->set('category', $filter_category);
        $this->set('date', $filter_date);
        $this->set('all_transaction', $this->security->xss_clean($all_transaction['data']));
        $this->set('categories', $all_transaction['categories']);

        $this->lang->load('amount_type', $this->LANG_NAME);

        $this->setView();
    }

    public function balance_report()
    {
        $title = lang('ewallet_balance_report');
        $this->set('title', $this->COMPANY_NAME . ' |' . $title);
        $help_link = 'business-summary';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('ewallet_balance_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('ewallet_balance_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if ($this->input->post('reset')) {
            $this->session->set_userdata('inf_ser_keyword', '');
        } else if ($this->input->post('search_member') && $this->validate_member()) {
            $post_arr = $this->validation_model->stripTagsPostArray($this->input->post(null, true));
            $keyword = $post_arr['keyword'];
            if ($keyword != "" && $keyword != "'") {
                if (!$this->ewallet_model->getEwalletBalanceReportCount($keyword)) {
                    $this->session->unset_userdata('inf_ser_keyword');
                    $msg = lang('no_details_found');
                    $this->redirect($msg, "member/balance_report", false);
                }
                $this->session->set_userdata('inf_ser_keyword', $keyword);
            }
        } elseif (!$this->session->userdata('inf_ser_keyword')) {
            $this->session->set_userdata('inf_ser_keyword', '');
        }

        $base_url = base_url() . 'admin/balance_report';
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $config['total_rows'] = $this->ewallet_model->getEwalletBalanceReportCount($this->session->userdata('inf_ser_keyword'));

        if ($this->uri->segment(3) != "") {
            $page = $this->uri->segment(3);
        } else {
            $page = 0;
        }

        $reportData = $this->ewallet_model->getEwalletBalanceReport($page, $config['per_page'],$this->session->userdata('inf_ser_keyword'));
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();

        $this->set('page_id', $page);
        $this->set('result_per_page', $result_per_page);
        $this->set('report_data', $reportData);
        $this->set('search_key', $this->session->userdata('inf_ser_keyword'));
        $this->setView();
    }
    public function validate_member()
    {
        $this->form_validation->set_rules('keyword', lang('keyword'), 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }
}
