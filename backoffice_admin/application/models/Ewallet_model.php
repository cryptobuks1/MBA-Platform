<?php

class ewallet_model extends inf_model {

    public function __construct() {
        $this->load->model('validation_model');
        $this->load->model('misc_model');

        $this->load->library('inf_phpmailer', NULL, 'phpmailer');
    }

    public function userNameToID($user_name) {
        $user_id = $this->validation_model->userNameToID($user_name);
        return $user_id;
    }

    public function getAllEwalletAmounts() {
        $i = 0;
        $amount_detail = array();
        $this->db->select('id,amount');
        $this->db->from('pin_amount_details');
        $this->db->order_by("amount", "asc");
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $amount_detail["details$i"]["id"] = $row['id'];
            $amount_detail["details$i"]["amount"] = $row['amount'];
            $i++;
        }
        return $amount_detail;
    }

    public function getBalanceAmount($user_id) {
        $this->db->select('balance_amount');
        $this->db->from('user_balance_amount');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row)
            return $row->balance_amount;
    }

    public function getTransactionFee() {
        $this->db->select('trans_fee');
        $this->db->from('configuration');
        $query = $this->db->get();
        foreach ($query->result() as $row)
            return $row->trans_fee;
    }

    public function getUserPassword($user_id) {
        $this->db->select('tran_password');
        $this->db->from('tran_password');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row)
            return $row->tran_password;
    }

    public function insertBalAmountDetails($from_user_id, $to_user_id, $trans_amount, $amount_type = '', $transaction_concept = '', $trans_fee = '', $transaction_id = '') {
        $date = date('Y-m-d H:i:s');

        if ($amount_type != '') {
            $data = array(
                'from_user_id' => $from_user_id,
                'to_user_id' => $to_user_id,
                'amount' => $trans_amount,
                'date' => $date,
                'amount_type' => $amount_type,
                'transaction_concept' => $transaction_concept,
                'trans_fee' => $trans_fee,
                'transaction_id' => $transaction_id
                );
            $query = $this->db->insert('fund_transfer_details', $data);
            $ewallet_id = $this->db->insert_id();
            $this->validation_model->addEwalletHistory($to_user_id, $from_user_id, $ewallet_id, 'fund_transfer', $trans_amount, $amount_type, ($amount_type == 'admin_debit') ? 'debit' : 'credit', $transaction_id, $transaction_concept, $trans_fee);
        } else {
            $data = array(
                'from_user_id' => $from_user_id,
                'to_user_id' => $to_user_id,
                'amount' => $trans_amount,
                'date' => $date,
                'amount_type' => 'user_credit',
                'transaction_concept' => $transaction_concept,
                'trans_fee' => $trans_fee,
                'transaction_id' => $transaction_id
                );
            $query = $this->db->insert('fund_transfer_details', $data);
            $ewallet_id = $this->db->insert_id();
            $this->validation_model->addEwalletHistory($to_user_id, $from_user_id, $ewallet_id, 'fund_transfer', $trans_amount, 'user_credit', 'credit', $transaction_id, $transaction_concept, $trans_fee);
            $data = array(
                'from_user_id' => $to_user_id,
                'to_user_id' => $from_user_id,
                'amount' => $trans_amount,
                'date' => $date,
                'amount_type' => 'user_debit',
                'transaction_concept' => $transaction_concept,
                'trans_fee' => $trans_fee,
                'transaction_id' => $transaction_id
                );
            $query = $this->db->insert('fund_transfer_details', $data);
            $ewallet_id = $this->db->insert_id();
            $this->validation_model->addEwalletHistory($from_user_id, $to_user_id, $ewallet_id, 'fund_transfer', $trans_amount, 'user_debit', 'debit', $transaction_id, $transaction_concept, $trans_fee);
        }
    }

    public function updateBalanceAmountDetailsFrom($from_user_id, $trans_amount) {
        $this->db->set('balance_amount', 'ROUND(balance_amount - ' . $trans_amount . ',8)', FALSE);
        $this->db->where('user_id', $from_user_id);
        $query = $this->db->update('user_balance_amount');
        return $query;
    }

    public function updateBalanceAmountDetailsTo($to_user_id, $trans_amount) {

        $this->db->set('balance_amount', 'ROUND(balance_amount + ' . $trans_amount . ',8)', FALSE);
        $this->db->where('user_id', $to_user_id);
        $query = $this->db->update('user_balance_amount');

        return $query;
    }

    public function getEpinAmount($amount_id) {
        $amount = 0;
        $this->db->select('amount');
        $this->db->from('pin_amount_details');
        $this->db->where('id', $amount_id);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $amount = $row['amount'];
        }
        return $amount;
    }

    public function updateBalanceAmount($user_id, $bal) {
        $bal = round($bal, 8);
        $data = array(
            'balance_amount' => $bal
            );
        $this->db->where('user_id', $user_id);
        $result = $this->db->update('user_balance_amount', $data);
        return $result;
    }

    public function getBalancePin($user_id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $pin_numbers = $this->table_prefix . "pin_numbers";

        $dbprefix = $this->db->dbprefix;
        $this->db->set_dbprefix('');
        $this->db->where('allocated_user_id', $user_id);
        $this->db->where('status', 'yes');
        $count = $this->db->count_all_results($pin_numbers);
        $this->db->set_dbprefix($dbprefix);
        $balance = intval($count);
        return $balance;
    }

    public function addUserBalanceAmount($to_userid, $amount) {
        $this->db->set('balance_amount', 'ROUND(balance_amount + ' . $amount . ',8)', FALSE);
        $this->db->where('user_id', $to_userid);
        $query = $this->db->update('user_balance_amount');
        return $query;
    }

    public function deductUserBalanceAmount($to_userid, $amount) {
        $this->db->set('balance_amount', 'ROUND(balance_amount - ' . $amount . ',8)', FALSE);
        $this->db->where('user_id', $to_userid);
        $query = $this->db->update('user_balance_amount');
        return $query;
    }

    public function getUserEwalletDetails($user_id, $from_date, $to_date, $page = '', $limit = '') {
        $details = array();
        $this->db->select('amount');
        $this->db->select('trans_fee');
        $this->db->select('date');
        $this->db->select('transaction_id');
        $this->db->select('amount_type');
        $this->db->select('transaction_concept');
        $this->db->select('to_user_id');
        $this->db->limit($limit, $page);
        $this->db->from('fund_transfer_details');
        if ($user_id != '') {
            $this->db->where('to_user_id', $user_id);
        }
        if ($from_date != '') {
            $this->db->where("date >=", $from_date);
        }
        if ($to_date != '') {
            $this->db->where("date <=", $to_date);
        }
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $details[$i]['total_amount'] = $row['amount'];
            $details[$i]['date'] = $row['date'];
            $details[$i]['amount_type'] = $row['amount_type'];
            $details[$i]['trans_fee'] = $row['trans_fee'];
            $details[$i]['transaction_id'] = $row['transaction_id'];
            $details[$i]['transaction_note'] = $row['transaction_concept'];
                $details[$i]['user_name'] = $this->validation_model->IdToUserName($row['to_user_id']);
            $i++;
        }
        return $details;
    }

    public function isUserNameAvailable($user_name) {
        $res = $this->validation_model->isUserNameAvailable($user_name);
        return $res;
    }

    public function getCommissionDetailsForMobile($user_id, $table_prefix, $from_date, $to_date, $product_status) {
        $i = 0;
        $details = array();
        $from_user_name = "";
        while ($from_date <= $to_date) {
            $start = $from_date . " 00:00:00";
            $end = $from_date . " 23:59:59";
            $this->db->select('amount_payable');
            $this->db->select('total_amount');
            $this->db->select('amount_type');
            $this->db->select('date_of_submission');
            $this->db->from($table_prefix . '_leg_amount');
            $this->db->where('user_id', $user_id);
            $this->db->where("date_of_submission BETWEEN '$start' AND '$end'");
            $this->db->order_by('date_of_submission');
            $res2 = $this->db->get();
            foreach ($res2->result_array() as $row2) {
                $details[$i]['total_amount'] = $row2['amount_payable'];
                $details[$i]['amount_type'] = $row2['amount_type'];
                $details[$i]['date'] = $from_date;
                $i++;
            }

            $this->db->select('amount as total_amount');
            $this->db->select('date');
            $this->db->select('amount_type');
            $this->db->select('from_user_id');
            $this->db->select('to_user_id');
            $this->db->from($table_prefix . '_fund_transfer_details');
            $this->db->where("to_user_id", $user_id);
            $this->db->where("date BETWEEN '$start' AND '$end'");
            $this->db->order_by('date');
            $res1 = $this->db->get();
            if ($res1->num_rows() != 0) {
                foreach ($res1->result_array() as $row1) {

                    $details[$i]['total_amount'] = $row1['total_amount'];
                    $details[$i]['amount_type'] = $row1['amount_type'];
                    $from_user_id = $row1['from_user_id'];
                    $from_user_name = $this->getName($from_user_id, $table_prefix . "_");
                    $details[$i]['from_user_name'] = $from_user_name;
                    $details[$i]['date'] = $from_date;
                    $i++;
                }
            }
            $pin_status = $this->getPinStatus($table_prefix . "_");
            $pro_status = $this->getProductStatus($table_prefix . "_");


            if ($pin_status) {
                $this->db->select('pin_uploded_date');
                $this->db->from($table_prefix . '_pin_numbers');
                $this->db->where('allocated_user_id', $user_id);
                $this->db->where('purchase_status', 'yes');
                $this->db->where("pin_alloc_date BETWEEN '$start' AND '$end'");
                $res3 = $this->db->get();
                foreach ($res3->result_array() as $row3) {
                    if ($pro_status) {

                    } else {
                        $pin_amount = $this->getPinAmountForMoblie($table_prefix);
                        $details[$i]['total_amount'] = $pin_amount;
                    }
                    $details[$i]['amount_type'] = "pin_purchased";
                    $details[$i]['date'] = $from_date;
                    $i++;
                }
            }

            $this->db->select('paid_amount');
            $this->db->from($table_prefix . '_amount_paid');
            $this->db->where('paid_user_id', $user_id);
            $this->db->where('paid_type', "released");
            $this->db->where("paid_date BETWEEN '$start' AND '$end'");
            $res4 = $this->db->get();
            foreach ($res4->result_array() as $row4) {
                $details[$i]['total_amount'] = $row4['paid_amount'];
                $details[$i]['amount_type'] = "payout_released";
                $details[$i]['date'] = $from_date;
                $i++;
            }


            $from_date = date('Y-m-d', strtotime('+1 days', strtotime($from_date)));
        }
        return $details;
    }

    public function getAdminEmailId() {
        $this->db->select('id');
        $this->db->from('ft_individual');
        $this->db->where('user_type', 'admin');
        $res1 = $this->db->get();
        foreach ($res1->result() as $row1) {
            $user_id = $row1->id;
        }
        $this->db->select('user_detail_email');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $res2 = $this->db->get();
        foreach ($res2->result() as $row2) {
            return $row2->user_detail_email;
        }
    }

    public function getTransactionPasscode($user_id) {
        //$tran_passcodes = $this->table_prefix . 'tran_password';
        $this->db->select('tran_password');
        $this->db->from('tran_password');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $passcode = $row->tran_password;
        }
        return $passcode;
    }

    public function getGrandTotalEwallet($user_id = '') {

        $grand_total = 0;
        if ($user_id == "") {
            $this->db->select_sum('balance_amount');
            $this->db->from('user_balance_amount');
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $grand_total = $row->balance_amount;
            }
        } else {
            $this->db->select('balance_amount');
            $this->db->from('user_balance_amount');
            $this->db->where("user_id", $user_id);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $grand_total = $row->balance_amount;
            }
        }
        return $grand_total;
    }

    public function generatePasscode($cnt, $status, $uploded_date, $amount, $expiry_date, $purchase_status, $amount_id, $user_id = '', $gen_user_id = '', $transaction_id = '') {
        $res = false;
        for ($i = 0; $i < $cnt; $i++) {
            $passcode = $this->misc_model->getRandStr(9, 9);
            if ($user_id == '') {
                $allocated_user = 'NA';
            } else {
                $allocated_user = $user_id;
            }
            $res = $this->insertPurchases($passcode, $status, $uploded_date, $gen_user_id, $allocated_user, $amount, $expiry_date, $purchase_status, $amount_id, $transaction_id);
        }
        return $res;
    }

    public function getMaxPinCount() {

        $OBJ_PIN = new pin_model();
        $maxpincount = $OBJ_PIN->getMaxPinCount();
        return $maxpincount;
    }

    public function getAllActivePinspage($purchase_status = '') {

        $OBJ_PIN = new pin_model();
        $num = $OBJ_PIN->getAllActivePinspage($purchase_status);
        return $num;
    }

    public function checkUser($user_name) {
        $flag = false;
        $user_name = ($user_name);
        $user_id = $this->validation_model->userNameToID($user_name);
        if ($user_id) {
            $flag = 1;
        }
        return $flag;
    }

    public function getTotalRequestAmount($user_id = "") {
        $req_amount = 0;
        $this->db->select_sum('requested_amount');
        $this->db->where('status', 'pending');
        if ($user_id != "")
            $this->db->where('requested_user_id', $user_id);
        $query = $this->db->get('payout_release_requests');
        foreach ($query->result() as $row) {
            $req_amount = $row->requested_amount;
        }
        return $req_amount;
    }

    public function getTotalReleasedAmount($user_id = "") {
        $released_amount = 0;
        $this->db->select_sum('paid_amount');
        $this->db->where('paid_type', 'released');
        if ($user_id != "")
            $this->db->where('paid_user_id', $user_id);
        $query = $this->db->get('amount_paid');
        foreach ($query->result() as $row) {
            $released_amount = $row->paid_amount;
        }
        return $released_amount;
    }

    public function insertPurchases($passcode, $status, $pin_uploded_date, $generated_user, $allocate_id, $pin_amount, $expiry_date, $purchase_status, $amount_id, $transaction_id) {

        $pin_alloc_date = $pin_uploded_date;
        $used_user = "";

        $array = array(
            'pin_numbers' => $passcode,
            'pin_alloc_date' => $pin_alloc_date,
            'status' => $status,
            'pin_uploded_date' => $pin_uploded_date,
            'generated_user_id' => $generated_user,
            'allocated_user_id' => $allocate_id,
            'pin_expiry_date' => $expiry_date,
            'pin_amount' => $pin_amount,
            'pin_balance_amount' => $pin_amount,
            'purchase_status' => $purchase_status,
            'transaction_id' => $transaction_id
            );

        $this->db->set($array);
        $res = $this->db->insert('pin_purchases');


        $this->db->set($array);
        $res = $this->db->insert('pin_numbers');

        $ewallet_id = $this->db->insert_id();
        $this->validation_model->addEwalletHistory($allocate_id, $generated_user, $ewallet_id, 'pin_purchase', $pin_amount, 'pin_purchase', 'debit', $transaction_id);

        return $res;
    }

    public function insertReleasedDetails($to_userid, $amount, $user_level, $transaction_id = '') {
        $date = date("Y/m/d");
        $paid_type = "admin_debit";
        $data = array(
            'paid_user_id' => $to_userid,
            'paid_amount' => $amount,
            'paid_date' => $date,
            'paid_type' => $paid_type,
            'transaction_id' => $transaction_id
            );
        $query = $this->db->insert('amount_paid', $data);
    }

    public function getUserLevel($to_userid) {
        $this->db->select('user_level');
        $this->db->from('ft_individual');
        $this->db->where('id', $to_userid);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $level = $row->user_level;
        }
        return $level;
    }

    public function getBusinessWalletDetails($from_date = '', $to_date = '')
    { 
        $wallet_details = [];
        $current_date = date('Y-m-d');
        $this->db->select_sum('total_amount');
       /* if ($type == 'month') {
            $this->db->where("MONTH(reg_date)=MONTH('{$current_date}')");
            $this->db->where("YEAR(reg_date)=YEAR('{$current_date}')");
        }
        if ($type == 'year') {
            $this->db->where("YEAR(reg_date)=YEAR('{$current_date}')");
        }*/
        if ($from_date != '') {
            $this->db->where("reg_date >=", $from_date);
        }
        if ($to_date != '') {
            $this->db->where("reg_date <=", $to_date);
        }
        $query = $this->db->get('infinite_user_registration_details');
        
        $joining_fee = $query->row_array()['total_amount'] ?? 0;

        $wallet_details['joining_fee'] = [
            'type' => 'credit',
            'amount' => $joining_fee
        ];

        if ($this->MODULE_STATUS['opencart_status'] == 'yes') {
            $this->db->select_sum('total');
           /* if ($type == 'month') {
                $this->db->where("MONTH(date_added)=MONTH('{$current_date}')");
                $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
            }
            if ($type == 'year') {
                $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
            }*/
            if ($from_date != '') {
            $this->db->where("confirm_date >=", $from_date);
            }
            if ($to_date != '') {
            $this->db->where("confirm_date <=", $to_date);
             }
            $this->db->where("order_status_id", 5);
            $this->db->where("customer_id !=", 0);
            $this->db->where('order_type','repurchase');
            $query = $this->db->get('oc_order');
            $purchase_amount = ($query->row_array()['total'] ?? 0);
            $wallet_details['repurchase'] = [
                'type' => 'credit',
                'amount' => $purchase_amount
            ];
        } else {
            if ($this->MODULE_STATUS['repurchase_status'] == 'yes') {
                $this->db->select_sum('total_amount');
                $this->db->where('order_status', 'confirmed');
               /* if ($type == 'month') {
                    $this->db->where("MONTH(order_date)=MONTH('{$current_date}')");
                    $this->db->where("YEAR(order_date)=YEAR('{$current_date}')");
                }
                if ($type == 'year') {
                    $this->db->where("YEAR(order_date)=YEAR('{$current_date}')");
                }*/
                if ($from_date != '') {
                $this->db->where("order_date >=", $from_date);
                 }
                if ($to_date != '') {
            $this->db->where("order_date <=", $to_date);
                }
                $query = $this->db->get('repurchase_order');
                $purchase_amount = $query->row_array()['total_amount'] ?? 0;

                $wallet_details['repurchase'] = [
                    'type' => 'credit',
                    'amount' => $purchase_amount
                ];
            }
            if ($this->MODULE_STATUS['package_upgrade'] == 'yes') {
                /*if ($type == 'month') {
                    $this->db->where("MONTH(date_added)=MONTH('{$current_date}')");
                    $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
                }
                if ($type == 'year') {
                    $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
                }*/
                if ($from_date != '') {
                    $this->db->where("date_added >=", $from_date);
                }
                if ($to_date != '') {
                    $this->db->where("date_added <=", $to_date);
                }
                $query = $this->db->get('upgrade_sales_order');
                $purchase_amount = $query->row_array()['amount'] ?? 0;

                $wallet_details['upgrade'] = [
                    'type' => 'credit',
                    'amount' => $purchase_amount
                ];
            }
            if ($this->MODULE_STATUS['product_validity'] == 'yes') {
                $this->db->select_sum('total_amount');
                /*if ($type == 'month') {
                    $this->db->where("MONTH(date_submitted)=MONTH('{$current_date}')");
                    $this->db->where("YEAR(date_submitted)=YEAR('{$current_date}')");
                }
                if ($type == 'year') {
                    $this->db->where("YEAR(date_submitted)=YEAR('{$current_date}')");
                }*/
                if ($from_date != '') {
                    $this->db->where("date_submitted >=", $from_date);
                }
                if ($to_date != '') {
                    $this->db->where("date_submitted <=", $to_date);
                }
                $query = $this->db->get('package_validity_extend_history');
                $membership_reactivation_amount = $query->row_array()['total_amount'] ?? 0;

                $wallet_details['membership_reactivation'] = [
                    'type' => 'credit',
                    'amount' => $membership_reactivation_amount
                ];
            }
        }

        if ($this->MODULE_STATUS['pin_status'] == 'yes') {
            $this->db->select_sum('pin_amount');
            $this->db->where('purchase_status', 'no');
            /*if ($type == 'month') {
                $this->db->where("MONTH(pin_uploded_date)=MONTH('{$current_date}')");
                $this->db->where("YEAR(pin_uploded_date)=YEAR('{$current_date}')");
            }
            if ($type == 'year') {
                $this->db->where("YEAR(pin_uploded_date)=YEAR('{$current_date}')");
            }*/
             if ($from_date != '') {
                $this->db->where("pin_uploded_date >=", $from_date);
            }
            if ($to_date != '') {
                $this->db->where("pin_uploded_date <=", $to_date);
            }
            $query = $this->db->get('pin_numbers');
            $epin_amount = $query->row_array()['pin_amount'] ?? 0;

            $wallet_details['epin_generated'] = [
                'type' => 'credit',
                'amount' => $epin_amount
            ];

            $this->db->select_sum('pin_amount');
            $this->db->where('purchase_status', 'yes');
            /*if ($type == 'month') {
                $this->db->where("MONTH(pin_uploded_date)=MONTH('{$current_date}')");
                $this->db->where("YEAR(pin_uploded_date)=YEAR('{$current_date}')");
            }
            if ($type == 'year') {
                $this->db->where("YEAR(pin_uploded_date)=YEAR('{$current_date}')");
            }*/
            if ($from_date != '') {
                $this->db->where("pin_uploded_date >=", $from_date);
            }
            if ($to_date != '') {
                $this->db->where("pin_uploded_date <=", $to_date);
            }
            $query = $this->db->get('pin_numbers');
            $epin_purchase_amount = $query->row_array()['pin_amount'] ?? 0;

            $wallet_details['epin_purchase'] = [
                'type' => 'credit',
                'amount' => $epin_purchase_amount
            ];

            $this->db->select_sum('amount');
            $this->db->where_in('amount_type', ['pin_purchase_refund', 'pin_purchase_delete']);
            /*if ($type == 'month') {
                $this->db->where("MONTH(date_added)=MONTH('{$current_date}')");
                $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
            }
            if ($type == 'year') {
                $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
            }*/
            if ($from_date != '') {
                $this->db->where("date_added >=", $from_date);
            }
            if ($to_date != '') {
                $this->db->where("date_added <=", $to_date);
            }

            $query = $this->db->get('ewallet_history');
            $epin_refund_amount = $query->row_array()['amount'] ?? 0;

            $wallet_details['pin_purchase_refund'] = [
                'type' => 'debit',
                'amount' => $epin_refund_amount
            ];
        }

        $this->db->select_sum('amount');
        $this->db->where('amount_type', 'admin_credit');
       /* if ($type == 'month') {
            $this->db->where("MONTH(date_added)=MONTH('{$current_date}')");
            $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
        }
        if ($type == 'year') {
            $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
        }*/
        if ($from_date != '') {
            $this->db->where("date_added >=", $from_date);
        }
        if ($to_date != '') {
            $this->db->where("date_added <=", $to_date);
        }
        $query = $this->db->get('ewallet_history');
        $admin_credit_amount = $query->row_array()['amount'] ?? 0;

        $wallet_details['admin_credit'] = [
            'type' => 'debit',
            'amount' => $admin_credit_amount
        ];

        $this->db->select_sum('amount');
        $this->db->where('amount_type', 'admin_debit');
        /*if ($type == 'month') {
            $this->db->where("MONTH(date_added)=MONTH('{$current_date}')");
            $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
        }
        if ($type == 'year') {
            $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
        }*/
        if ($from_date != '') {
            $this->db->where("date_added >=", $from_date);
        }
        if ($to_date != '') {
            $this->db->where("date_added <=", $to_date);
        }
        $query = $this->db->get('ewallet_history');
        $admin_debit_amount = $query->row_array()['amount'] ?? 0;

        $wallet_details['admin_debit'] = [
            'type' => 'credit',
            'amount' => $admin_debit_amount
        ];
        //renewal
                $this->db->select_sum('amount');
                $this->db->from('stripe_monhtly_recurring_history as mh');
                $this->db->join('oc_order_recurring_transaction as rt', 'mh.recurr_order_id = rt.order_recurring_id', 'left');
                /*if ($type == 'month') {
                    $this->db->where("MONTH(date_submitted)=MONTH('{$current_date}')");
                    $this->db->where("YEAR(date_submitted)=YEAR('{$current_date}')");
                }
                if ($type == 'year') {
                    $this->db->where("YEAR(date_submitted)=YEAR('{$current_date}')");
                }*/
                if ($from_date != '' ) {
                    $this->db->where("date >=", $from_date);
                }
               
               /* if ($from_date != '' && $to_date !='') {
                    $this->db->where("date >=", $from_date);
                }*/
                if ($to_date != '') {
                    $this->db->where("date <=", $to_date);
                }
                $this->db->where('mh.type !=','failed');
                $query=$this->db->get();//echo $this->db->last_query();die;
                $renewal_amount = $query->row_array()['amount'] ?? 0;

                $wallet_details['recurring_stripe'] = [
                    'type' => 'credit',
                    'amount' => $renewal_amount
                ];
//renewal
        $enabled_bonus_list = $this->getEnabledBonusList();
        foreach ($enabled_bonus_list as $bonus) {
            $wallet_details[$bonus] = [
                'type' => 'debit',
                'amount' => 0
            ];
        }
        $this->db->select('amount_type,SUM(total_amount) total');
        $this->db->group_by('amount_type');
        /*if ($type == 'month') {
            $this->db->where("MONTH(date_of_submission)=MONTH('{$current_date}')");
            $this->db->where("YEAR(date_of_submission)=YEAR('{$current_date}')");
        }
        if ($type == 'year') {
            $this->db->where("YEAR(date_of_submission)=YEAR('{$current_date}')");
        }*/
        if ($from_date != '') {
            $this->db->where("date_of_submission >=", $from_date);
        }
        if ($to_date != '') {
            $this->db->where("date_of_submission <=", $to_date);
        }
        $query = $this->db->get('leg_amount');
        foreach ($query->result_array() as $row) {
            $wallet_details[$row['amount_type']] = [
                'type' => 'debit',
                'amount' => $row['total'] ?? 0
            ];
        }
        if (isset($wallet_details['donation']) || isset($wallet_details['purchase_donation'])) {
            $wallet_details['donation_amount'] = [
                'type' => 'debit',
                'amount' => 0
            ];
            if (isset($wallet_details['donation'])) {
                $wallet_details['donation_amount']['amount'] += $wallet_details['donation']['amount'];
                unset($wallet_details['donation']);
            }
            if (isset($wallet_details['purchase_donation'])) {
                $wallet_details['donation_amount']['amount'] += $wallet_details['purchase_donation']['amount'];
                unset($wallet_details['purchase_donation']);
            }
        }
        return $wallet_details;
    }

    public function getReceivedBonusList()
    {
        $list = [];
        $this->db->select('amount_type');
        $this->db->group_by('amount_type');
        $query = $this->db->get('leg_amount');
        foreach ($query->result_array() as $row) {
            $list[] = $row['amount_type'];
        }
        return $list;
    }

    public function getEnabledBonusList()
    {
        $list = [];
        $level_commission_status = 'no';
        if (in_array($this->MLM_PLAN, ['Matrix', 'Unilevel', 'Donation']) || $this->MODULE_STATUS['sponsor_commission_status'] == 'yes') {
            $level_commission_status = 'yes';
        }
        $xup_commission_status = 'no';
        if ($this->MODULE_STATUS['xup_status'] == 'yes' && $level_commission_status == 'yes') {
            $xup_commission_status = 'yes';
            $level_commission_status = 'no';
        }
        if ($this->MODULE_STATUS['referal_status'] == 'yes' && false) {
            $list[] = 'referral';
        }
        if ($this->MODULE_STATUS['rank_status'] == 'yes' && false) {
            $list[] = 'rank_bonus';
        }
        if ($level_commission_status == 'yes') {
            $list[] = 'level_commission';
            if ($this->MODULE_STATUS['repurchase_status'] == 'yes' || $this->MODULE_STATUS['opencart_status'] == 'yes') {
                $list[] = 'repurchase_level_commission';
            }
            if ($this->MODULE_STATUS['package_upgrade'] == 'yes') {
                $list[] = 'upgrade_level_commission';
            }
        }
        if ($xup_commission_status == 'yes') {
            $list[] = 'xup_commission';
            if ($this->MODULE_STATUS['repurchase_status'] == 'yes' || $this->MODULE_STATUS['opencart_status'] == 'yes') {
                $list[] = 'xup_repurchase_level_commission';
            }
            if ($this->MODULE_STATUS['package_upgrade'] == 'yes') {
                $list[] = 'xup_upgrade_level_commission';
            }
        }
        if ($this->MLM_PLAN == 'Binary') {
            $list[] = 'leg';
            if ($this->MODULE_STATUS['repurchase_status'] == 'yes' || $this->MODULE_STATUS['opencart_status'] == 'yes' && false) {
                $list[] = 'repurchase_leg';
            }
            if ($this->MODULE_STATUS['package_upgrade'] == 'yes') {
                $list[] = 'upgrade_leg';
            }
        }
        if ($this->MLM_PLAN == 'Stair_Step') {
            $list[] = 'stair_step';
            $list[] = 'override_bonus';
        }
        if ($this->MLM_PLAN == 'Board') {
            $list[] = 'board_commission';
        }
        if ($this->MODULE_STATUS['roi_status'] == 'yes' || $this->MODULE_STATUS['hyip_status'] == 'yes') {
            $list[] = 'daily_investment';
        }
        if ($this->MLM_PLAN == 'Donation') {
            $list[] = 'donation';
            $list[] = 'purchase_donation';
        }
        $additional_bonus_status = $this->validation_model->getConfig(['matching_bonus', 'pool_bonus', 'fast_start_bonus', 'performance_bonus']);
        if ($additional_bonus_status['matching_bonus'] == 'yes') {
            $list[] = 'matching_bonus';
            if ($this->MODULE_STATUS['repurchase_status'] == 'yes' || $this->MODULE_STATUS['opencart_status'] == 'yes') {
                $list[] = 'matching_bonus_purchase';
            }
            if ($this->MODULE_STATUS['package_upgrade'] == 'yes') {
                $list[] = 'matching_bonus_upgrade';
            }
        }
        if ($additional_bonus_status['pool_bonus'] == 'yes') {
            $list[] = 'pool_bonus';
        }
        if ($additional_bonus_status['fast_start_bonus'] == 'yes') {
            $list[] = 'fast_start_bonus';
            if ($this->MODULE_STATUS['repurchase_status'] == 'yes' || $this->MODULE_STATUS['opencart_status'] == 'yes') {
                $list[] = 'repurchase_fast_start_bonus';
            }
        }
        
        if ($additional_bonus_status['performance_bonus'] == 'yes') {
            $performance_bonus_types = $this->getPerformanceBonusTypes();
            foreach ($performance_bonus_types as $v) {
                $list[] = $v;
            }
        }

        return $list;
    }

    public function getPerformanceBonusTypes()
    {
        $list = [];
        $this->db->select('bonus_name');
        $query = $this->db->get('performance_bonus');
        foreach ($query->result_array() as $row) {
            $list[] = $row['bonus_name'];
        }
        return $list;
    }

    /* public function getBusinessWalletDetails($module_status) {

        $j = 0;
        $i = 1;
        $wallet_details[$j]['type'] = 'joining_fee';
        $this->db->select_sum('total_amount');
        $this->db->where('sponsor_id', $this->LOG_USER_ID);
        $amount = $this->db->get('infinite_user_registration_details');
        $amount = $amount->result_array();
        $amount[0]['total_amount'] = ($amount[0]['total_amount'] != '') ? $amount[0]['total_amount'] : 0;
        $wallet_details[$j]['amount_credited'] = $amount[0]['total_amount'];
        $wallet_details[$j]['amount_debited'] = 0;
        $j++;

        if ($module_status['repurchase_status'] == 'yes') {
            $wallet_details[$j]['type'] = 'repurchase';
            $this->db->select_sum('total_amount');
            $amount = $this->db->get('repurchase_order');
            $amount = $amount->result_array();
            $amount[0]['total_amount'] = ($amount[0]['total_amount'] != '') ? $amount[0]['total_amount'] : 0;
            $wallet_details[$j]['amount_credited'] = $amount[0]['total_amount'];
            $wallet_details[$j]['amount_debited'] = 0;
            $i++;
            $j++;
        }

        if ($module_status['xup_status'] == 'yes') {
            $where = '(amount_type="xup_commission" or amount_type = "xup_repurchase_level_commission" or amount_type = "xup_upgrade_level_commission")';
            $wallet_details[$j]['type'] = 'xup_commission';
            $this->db->select_sum('total_amount');
            $this->db->where($where);
            $amount = $this->db->get('leg_amount');
            $amount = $amount->result_array();
            $amount[0]['total_amount'] = ($amount[0]['total_amount'] != '') ? $amount[0]['total_amount'] : 0;
            $wallet_details[$j]['amount_credited'] = 0;
            $wallet_details[$j]['amount_debited'] = round($amount[0]['total_amount'], 8);
            $i++;
            $j++;
        }

        if ($module_status['pin_status'] == 'yes') {
            $wallet_details[$j]['type'] = 'epin_generated';
            $this->db->select_sum('pin_amount');
            $amount = $this->db->get('pin_numbers');
            $amount = $amount->result_array();
            $amount[0]['pin_amount'] = ($amount[0]['pin_amount'] != '') ? $amount[0]['pin_amount'] : 0;
            $wallet_details[$j]['amount_credited'] = $amount[0]['pin_amount'];
            $wallet_details[$j]['amount_debited'] = 0;
            $i++;
            $j++;
        }

        if ($this->MLM_PLAN == 'Matrix' || $this->MLM_PLAN == 'Unilevel' || $this->MLM_PLAN == 'Donation' || $module_status['sponsor_commission_status'] == 'yes') {
            $amount_types[$j]['amount_type'] = 'level_commission';
            $amount_types[$j]['type'] = 'debit';
            $j++;
        }

        if (($this->MLM_PLAN == 'Matrix' || $this->MLM_PLAN == 'Unilevel' || $this->MLM_PLAN == 'Donation' || $module_status['sponsor_commission_status'] == 'yes') && $module_status['repurchase_status'] == 'yes') {
            $amount_types[$j]['amount_type'] = 'repurchase_level_commission';
            $amount_types[$j]['type'] = 'debit';
            $j++;
        }
        if ($this->MLM_PLAN == 'Donation') {
            $amount_types[$j]['amount_type'] = 'donation';
            $amount_types[$j]['type'] = 'debit';
            $j++;
        }

        if ($module_status['referal_status'] == 'yes') {
            $amount_types[$j]['amount_type'] = 'referral';
            $amount_types[$j]['type'] = 'debit';
            $j++;
        }

        if ($module_status['roi_status'] == 'yes') {
            $amount_types[$j]['amount_type'] = 'daily_investment';
            $amount_types[$j]['type'] = 'debit';
            $j++;
        }

        $matching_bonus = $this->validation_model->getConfig('matching_bonus');
        if ($matching_bonus == 'yes') {
            $amount_types[$j]['amount_type'] = 'matching_bonus';
            $amount_types[$j]['type'] = 'debit';
            $j++;
            if ($module_status['repurchase_status'] == 'yes') {
                $amount_types[$j]['amount_type'] = 'matching_bonus_purchase';
                $amount_types[$j]['type'] = 'debit';
                $j++;
            }
            if ($module_status['package_upgrade'] == 'yes') {
                $amount_types[$j]['amount_type'] = 'matching_bonus_upgrade';
                $amount_types[$j]['type'] = 'debit';
                $j++;
            }
        }

        if ($this->MLM_PLAN == 'Board') {
            $amount_types[$j]['amount_type'] = 'board_commission';
            $amount_types[$j]['type'] = 'debit';
            $j++;
        } else if ($this->MLM_PLAN == 'Binary') {
            $amount_types[$j]['amount_type'] = 'leg';
            $amount_types[$j]['type'] = 'debit';
            $j++;
            if ($module_status['repurchase_status'] == 'yes') {
                $amount_types[$j]['amount_type'] = 'repurchase_leg';
                $amount_types[$j]['type'] = 'debit';
                $j++;
            }
        }

        foreach ($amount_types as $type) {
            $wallet_details[$i]['type'] = $type['amount_type'];
            $this->db->select_sum('total_amount');
            $this->db->where('amount_type', $type['amount_type']);
            $amount = $this->db->get('leg_amount');
            $amount = $amount->result_array();
            $amount[0]['total_amount'] = ($amount[0]['total_amount'] != '') ? $amount[0]['total_amount'] : 0;
            if ($type['type'] == 'credit') {
                $wallet_details[$i]['amount_credited'] = round($amount[0]['total_amount'], 8);
                $wallet_details[$i]['amount_debited'] = 0;
            } else {
                $wallet_details[$i]['amount_credited'] = 0;
                $wallet_details[$i]['amount_debited'] = round($amount[0]['total_amount'], 8);
            }
                $i++;

        }

        return $wallet_details;
    } */

    public function getUniqueTransactionId() {
        $code = $this->getRandStr(9, 9);
        $this->db->set('transaction_id', $code);
        $this->db->insert('transaction_id');
        return $code;
    }

    public function getRandStr() {
        $key = "";
        $charset = "0123456789";
        $length = 10;
        for ($i = 0; $i < $length; $i++)
            $key .= $charset[(mt_rand(0, (strlen($charset) - 1)))];

        $randum_number = $key;
        $this->db->from('transaction_id');
        $this->db->where('transaction_id', $randum_number);
        $count = $this->db->count_all_results();
        if ($count > 0)
            $this->getRandStr();
        else
            return $key;
    }

    public function getEwalletHistoryCount($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->count_all_results('ewallet_history');
    }

    public function getEwalletHistory($user_id, $page, $limit) {
        $this->db->select('e.ewallet_type,e.amount,e.amount_type,e.type,e.date_added,e.transaction_id,e.transaction_note,e.transaction_fee,e.pending_id,IF(e.pending_id IS NULL, f.user_name, p.user_name) as from_user,e.purchase_wallet', false);
        $this->db->from('ewallet_history as e');
        $this->db->join('ft_individual as f', 'e.from_id = f.id', 'left');
        $this->db->join('pending_registration as p', 'e.pending_id = p.id', 'left');
        $this->db->where('e.user_id', $user_id);
        $this->db->limit($limit, $page);
        $this->db->order_by('e.id');
        $res = $this->db->get();
        return $res->result_array();
    }

    public function getPreviousEwalletBalance($user_id, $page) {
        if(!$page) {
            return 0;
        }

        $this->db->select('*');
        $this->db->from('ewallet_history as e');
        $this->db->where('e.user_id', $user_id);
        $this->db->limit($page, 0);
        $ewallet_data = $this->db->get_compiled_select();

        $this->db->select("SUM(IF(f.type = 'credit', f.amount, 0)) as credit", FALSE);
        $this->db->select("SUM(IF(f.type = 'credit', f.purchase_wallet, 0)) as pwallet", FALSE);
        $this->db->select("SUM(IF(f.type = 'debit' AND f.amount_type != 'payout_release', f.amount, 0)) as debit", FALSE);
        $this->db->select("SUM(IF(f.type = 'debit' AND f.amount_type != 'payout_release', f.transaction_fee, 0)) as transaction_fee", FALSE);
        $this->db->from("($ewallet_data) as f", FALSE);
        $res = $this->db->get();
        return ($res->row_array()['credit'] - $res->row_array()['debit'] - $res->row_array()['transaction_fee'] - $res->row_array()['pwallet']);
    }

    public function checkEwalletPassword($user_id, $password) {
        $flag = 'no';
        $this->db->select('tran_password');
        $this->db->where('user_id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get('tran_password');
        $password_hash = $query->row_array()['tran_password'];
        $password_matched = password_verify($password, $password_hash);
        if ($password_hash && $password_matched) {
            $flag = 'yes';
        }
        return $flag;
    }

    public function ewalletPayment($ewallet_user_id, $user_id, $used_amount, $amount_type) {
        $date = date('Y-m-d H:i:s');
        $transaction_id = $this->getUniqueTransactionId();
        $this->db->set('used_user_id', $ewallet_user_id);
        $this->db->set('used_amount', $used_amount);
        $this->db->set('user_id', $user_id);
        $this->db->set('used_for', $amount_type);
        $this->db->set('date', $date);
        $this->db->set('transaction_id', $transaction_id);
        $res1 = $this->db->insert('ewallet_payment_details');

        $ewallet_id = $this->db->insert_id();
        $res2 = $this->validation_model->addEwalletHistory($ewallet_user_id, $user_id, $ewallet_id, 'ewallet_payment', $used_amount, $amount_type, 'debit', $transaction_id, '', 0);

        $res3 = $this->deductUserBalanceAmount($ewallet_user_id, $used_amount);

        return $res1 && $res2 && $res3;
    }

    public function validateEwalletDetails($ewallet_username, $ewallet_password, $payment_amount, $upgrade_username)
    {
        $status = "";
        $user_id = $this->validation_model->userNameToID($ewallet_username);
        if ($this->LOG_USER_TYPE == 'admin' || $this->LOG_USER_TYPE == 'employee') {
            $admin_username = $this->validation_model->getAdminUsername();
            if ($ewallet_username != $admin_username && $ewallet_username != $upgrade_username) {
                $status = "invalid";
                return $status;
            }
        } else if ($this->LOG_USER_TYPE == 'user') {
            if ($ewallet_username != $this->LOG_USER_NAME) {
                $status = "invalid";
                return $status;
            }
        }
        if ($user_id) {
            $user_password = $this->checkEwalletPassword($user_id, $ewallet_password);
            if ($user_password == 'yes') {
                $user_balance_amount = $this->getBalanceAmount($user_id);
                if ($user_balance_amount > 0 && $user_balance_amount >= $payment_amount) {
                    $status = "yes";
                }
                else {
                    $status = "low_balance";
                }
            }
            else {
                $status = "invalid";
            }
        }
        else {
            $status = "invalid";
        }
        return $status;
    }
    public function getEwalletHistoryForMobile($user_id, $page, $limit) {
        $data = array();
        $this->db->select('e.ewallet_type,e.amount,e.amount_type,e.type,e.date_added,e.transaction_id,e.transaction_note,e.transaction_fee,f.user_name as from_user', false);
        $this->db->from('ewallet_history as e');
        $this->db->join('ft_individual as f', 'e.from_id = f.id', 'left');
        $this->db->where('e.user_id', $user_id);
        $this->db->limit($limit, $page);
        $this->db->order_by('e.id');
        $res = $this->db->get();
        // print_r($res->num_rows()); die;
        $i = 0;
        if($res->num_rows() > 0){
            foreach ($res->result_array() as $row) {
                $data[$i] = $row;
                if($row['ewallet_type'] == "fund_transfer"){
                    if($row['amount_type'] == "user_credit"){
                        $data[$i]['description'] = lang('transfer_from')." ".$row['from_user']." ".lang('transaction_id')." :".$row['transaction_id'];
                    }else if($row['amount_type'] == "user_debit"){
                       $data[$i]['description'] = lang('fund_transfer_to')." ".$row['from_user']." ".lang('transaction_id')." :".$row['transaction_id'];
                    }else if($row['amount_type'] == "admin_credit"){
                       $data[$i]['description'] = lang('admin_credit')." ".$row['from_user']." ".lang('transaction_id')." :".$row['transaction_id'];
                    }else if($row['amount_type'] == "admin_debit"){
                       $data[$i]['description'] = lang('deducted_by')." ".$row['from_user']." ".lang('transaction_id')." :".$row['transaction_id'];
                    }
                }else if ($row['ewallet_type'] == "commission"){
                    $data[$i]['description'] = lang($row['amount_type'])." from ".$row['from_user'];
                }else if ($row['ewallet_type'] == "ewallet_payment"){
                    if($row['amount_type'] == "registration"){
                        $data[$i]['description'] = lang('deducted_for_registration_of')." ".$row['from_user'];
                    }else if($row['amount_type'] == "repurchase"){
                       $data[$i]['description'] = lang('deducted_for_repurchase_by')." ".$row['from_user'];
                    }else if($row['amount_type'] == "package_validity"){
                       $data[$i]['description'] = lang('deducted_for_membership_renewal_of')." ".$row['from_user'];
                    }
                }else if ($row['ewallet_type'] == "payout"){
                    if($row['amount_type'] == "payout_request"){
                        $data[$i]['description'] = lang('deducted_for_payout_request');
                    }else if($row['amount_type'] == "payout_release"){
                       $data[$i]['description'] = lang('payout_released_for_request');
                    }else if($row['amount_type'] == "payout_delete"){
                       $data[$i]['description'] = lang('credited_for_payout_request_delete');
                    }else if($row['amount_type'] == "payout_release_manual"){
                       $data[$i]['description'] = lang('payout_released_by_manual');
                    }else if($row['amount_type'] == "withdrawal_cancel"){
                       $data[$i]['description'] = lang('credited_for_waiting_withdrawal_cancel');
                    }
                }else if ($row['ewallet_type'] == "pin_purchase"){
                    if($row['amount_type'] == "pin_purchase"){
                        $data[$i]['description'] = lang('deducted_for_pin_purchase');
                    }else if($row['amount_type'] == "pin_purchase_delete"){
                       $data[$i]['description'] = lang('credited_for_pin_purchase_delete');
                }
                }
                $i++;
            }
        }
        return $data;
    }
    public function getTotalCommission($user_id,$start_date,$end_date) {
        //print_r($start_date);die;
        $commission = 0;
        $this->db->select('*');
        $this->db->from('ewallet_history as e');
        if($user_id != "")
        $this->db->where('e.user_id', $user_id);
        if($start_date != '' && $end_date != ''){
            $where = "date_added between '$start_date' and '$end_date'";
            $this->db->where($where);
        }
        $ewallet_data = $this->db->get_compiled_select();

        $this->db->select("SUM(IF(f.type = 'credit' AND f.amount_type != 'donation', f.amount, 0)) as credit", FALSE);
        $this->db->select("SUM(IF(f.type = 'debit' AND f.amount_type != 'payout_release', f.amount, 0)) as debit", FALSE);
        $this->db->select("SUM(IF(f.type = 'debit' AND f.amount_type != 'payout_release', f.transaction_fee, 0)) as transaction_fee", FALSE);
        $this->db->from("($ewallet_data) as f", FALSE);
        $res = $this->db->get();

        return ($res->row_array()['credit'] - $res->row_array()['debit'] - $res->row_array()['transaction_fee']);
    }
    public function getTotalDonation($user_id,$start_date,$end_date) {

        $donation = 0;
        $this->db->select('*');
        $this->db->from('ewallet_history as e');
        if($user_id != "")
        $this->db->where('e.user_id', $user_id);
        if($start_date != "" && $end_date != ""){
            $where = "date_added between '$start_date' and '$end_date'";
            $this->db->where($where);
        }
        $ewallet_data = $this->db->get_compiled_select();

        $this->db->select("SUM(IF(f.type = 'credit' AND f.amount_type = 'donation'AND f.ewallet_type = 'commission', f.amount, 0)) as credit", FALSE);
        $this->db->select("SUM(IF(f.type = 'debit' AND f.amount_type = 'donation'AND f.ewallet_type = 'commission', f.transaction_fee, 0)) as transaction_fee", FALSE);
        $this->db->from("($ewallet_data) as f", FALSE);
        $res = $this->db->get();
        return ($res->row_array()['credit'] - $res->row_array()['transaction_fee']);
    }


    public function getTotalDailyInvestment($user_id='') {
        $amount = 0;
        $this->db->select('SUM(amount) - SUM(purchase_wallet) as total_amount', FALSE);
        $this->db->where('amount_type', 'daily_investment');
        $this->db->where('type', 'credit');
        $this->db->where('ewallet_type', 'commission');
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        $query = $this->db->get('ewallet_history');

        foreach ($query->result() as $row) {
            $amount = $row->total_amount;
        }
        return $amount;
    }
    public function getAllEwalletDetails($from_user_id, $from_date, $to_date,$recieved_userid = '') {
        $details = array();
        $this->db->select('amount');
        $this->db->select('trans_fee');
        $this->db->select('date');
        $this->db->select('transaction_id');
        $this->db->select('amount_type');
        $this->db->select('transaction_concept');
        $this->db->select('to_user_id');
        $this->db->select('from_user_id');
        $this->db->from('fund_transfer_details');
        if ($from_user_id != '') {
            $this->db->where("CASE WHEN amount_type = 'admin_debit' THEN to_user_id = '$from_user_id' ELSE from_user_id = '$from_user_id' END");
            $this->db->where('amount_type !=','user_debit');
        }
        if ($recieved_userid != '') {
            $this->db->where("CASE WHEN amount_type = 'admin_debit' THEN from_user_id = '$recieved_userid' ELSE to_user_id = '$recieved_userid' END");
        }

        if ($from_date != '') {
            $this->db->where("date >=", $from_date);
            $this->db->where('amount_type !=','user_debit');
        }
        if ($to_date != '') {
            $this->db->where("date <=", $to_date);
            $this->db->where('amount_type !=','user_debit');
        }
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $details[$i]['total_amount'] = $row['amount'];
            $details[$i]['date'] = $row['date'];
            $details[$i]['amount_type'] = $row['amount_type'];
            $details[$i]['trans_fee'] = $row['trans_fee'];
            $details[$i]['transaction_id'] = $row['transaction_id'];
            $details[$i]['transaction_note'] = $row['transaction_concept'];
            if($row['amount_type'] == 'admin_debit'){
                $details[$i]['user_name'] = $this->validation_model->IdToUserName($row['to_user_id']);
                $details[$i]['from_user_name'] = $this->validation_model->IdToUserName($row['from_user_id']);
            }else{
                $details[$i]['user_name'] = $this->validation_model->IdToUserName($row['from_user_id']);
                $details[$i]['from_user_name'] = $this->validation_model->IdToUserName($row['to_user_id']);
            }

            $i++;
        }
        return $details;
    }

//Purchase wallet starts
    public function getPreviousPurchasewalletBalance($user_id, $page) {
        if(!$page) {
            return 0;
        }

        $this->db->select('*');
        $this->db->from('purchase_wallet_history as e');
        $this->db->where('e.user_id', $user_id);
        $this->db->limit($page, 0);
        $ewallet_data = $this->db->get_compiled_select();

        $this->db->select("SUM(IF(f.type = 'credit', f.purchase_wallet, 0)) as credit", FALSE);
        $this->db->select("SUM(IF(f.type = 'debit' AND f.amount_type != 'payout_release', f.purchase_wallet, 0)) as debit", FALSE);
        $this->db->from("($ewallet_data) as f", FALSE);
        $res = $this->db->get();

        return ($res->row_array()['credit'] - $res->row_array()['debit']);
    }
    public function getPurchasewalletHistoryCount($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->count_all_results('purchase_wallet_history');
    }

    public function getPurchasewalletHistory($user_id, $page, $limit) {
        $this->db->select('e.purchase_wallet as amount,e.amount_type,e.type,e.date,f.user_name as from_user', false);
        $this->db->from('purchase_wallet_history as e');
        $this->db->join('ft_individual as f', 'e.from_user_id = f.id', 'left');
        $this->db->where('e.user_id', $user_id);
        $this->db->limit($limit, $page);
        $this->db->order_by('e.id');
        $res = $this->db->get();
        return $res->result_array();
    }

    public function deductFromPurchaseWallet($user_id, $total_amount) {
        $this->db->set('purchase_wallet', 'ROUND(purchase_wallet -' . $total_amount . ',8)', false);
        $this->db->where('user_id', $user_id);
        $this->db->limit(1);
        $res = $this->db->update('user_balance_amount');
        return $res;
    }

    public function addFundToPurchaseWallet($user_id, $amount, $type)
    {
        $this->db->set('purchase_wallet', "purchase_wallet + $amount", FALSE);
        $this->db->where('user_id', $user_id);
        $res = $this->db->update('user_balance_amount');
        if ($res) {
            $this->db->set('user_id', $user_id);
            $this->db->set('amount', 0);
            $this->db->set('purchase_wallet', $amount);
            $this->db->set('amount_type', $type);
            $this->db->set('tds', 0);
            $this->db->set('type', 'credit');
            $res = $this->db->insert('purchase_wallet_history');
        }
        return $res;
    }
    public function getRequestPendingAmount($user_id) {
        $req_amount = 0;
        $this->db->select_sum('requested_amount_balance');
        $this->db->where('requested_user_id', $user_id);
        $this->db->where('status', 'pending');
        $this->db->from('payout_release_requests');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            if($row->requested_amount_balance != ''){
                $req_amount = $row->requested_amount_balance;
            }else{
                $req_amount = 0;
            }
        }
        return $req_amount;
    }

public function getAllTransactionCount($user_id, $debit_credit, $category, $date)
    {
        $current_day = date('Y-m-d');
        $count = 0;
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        if (in_array($debit_credit, ['debit', 'credit'])) {

            if($debit_credit == 'debit'){
               $debit_credit = 'credit';
             }
             else if($debit_credit == 'credit')
             {
               $debit_credit = 'debit';
             }
             else{

             }
            $this->db->where('type', $debit_credit);
        }
        if ($category) {
            if (substr($category, 0, strlen('ewallet_payment')) === 'ewallet_payment') {
                $this->db->where("CONCAT(ewallet_type, '_', amount_type)='{$category}'");
            } elseif ($category == 'donation') {
                $this->db->where_in('amount_type', ['donation', 'purchase_donation']);
            }
             elseif ($category == 'pin_purchase_credit') {
                $this->db->where_in('amount_type', ['pin_purchase_delete', 'pin_purchase_refund']);
            } else {
                $this->db->where('amount_type', $category);
            }
        }
        if ($date == 'month') {
            $this->db->where("MONTH(date_added)=MONTH('{$current_day}')");
            $this->db->where("YEAR(date_added)=YEAR('{$current_day}')");
        }
        if ($date == 'year') {
            $this->db->where("YEAR(date_added)=YEAR('{$current_day}')");
        }
        //$this->db->where('amount_type !=', 'payout_release');
        $this->db->where('ewallet_type !=', 'payout');
        $this->db->where_not_in('amount_type',['user_credit', 'user_debit']);
        $this->db->where('ewallet_type !=', 'ewallet_payment');
        $count += $this->db->count_all_results('ewallet_history');

        if ($debit_credit != 'credit' && (!$category || $category == 'joining_fee')) {
            if ($user_id) {
                $this->db->where('user_id', $user_id);
            }
            if ($date == 'month') {
                $this->db->where("MONTH(reg_date)=MONTH('{$current_day}')");
                $this->db->where("YEAR(reg_date)=YEAR('{$current_day}')");
            }
            $count += $this->db->count_all_results('infinite_user_registration_details');
        }

        if ($this->MODULE_STATUS['opencart_status'] == 'yes') {
            if ($debit_credit != 'credit' && (!$category || $category == 'repurchase')) {
                $this->db->from('oc_order as e');
                $this->db->join('ft_individual as f', 'e.customer_id = f.oc_customer_ref_id');
                $this->db->where('e.order_type', 'purchase');
                $this->db->where('e.order_status_id >', 0);
                if ($user_id) {
                    $this->db->where('f.id', $user_id);
                }
                if ($date == 'month') {
                    $this->db->where("MONTH(e.date_added)=MONTH('{$current_day}')");
                    $this->db->where("YEAR(e.date_added)=YEAR('{$current_day}')");
                }
                if ($date == 'year') {
                    $this->db->where("YEAR(e.date_added)=YEAR('{$current_day}')");
                }
                $count += $this->db->count_all_results();
            }
        } else {
            if ($this->MODULE_STATUS['repurchase_status'] == 'yes') {
                if ($debit_credit != 'credit' && (!$category || $category == 'repurchase')) {
                    $this->db->where('order_status', 'confirmed');
                    if ($user_id) {
                        $this->db->where('user_id', $user_id);
                    }
                    if ($date == 'month') {
                        $this->db->where("MONTH(order_date)=MONTH('{$current_day}')");
                        $this->db->where("YEAR(order_date)=YEAR('{$current_day}')");
                    }
                    if ($date == 'year') {
                        $this->db->where("YEAR(order_date)=YEAR('{$current_day}')");
                    }
                    $count += $this->db->count_all_results('repurchase_order');
                }
            }
            if ($this->MODULE_STATUS['package_upgrade'] == 'yes') {
                if ($debit_credit != 'credit' && (!$category || $category == 'upgrade')) {
                    if ($user_id) {
                        $this->db->where('user_id', $user_id);
                    }
                    if ($date == 'month') {
                        $this->db->where("MONTH(date_added)=MONTH('{$current_day}')");
                        $this->db->where("YEAR(date_added)=YEAR('{$current_day}')");
                    }
                    if ($date == 'year') {
                        $this->db->where("YEAR(date_added)=YEAR('{$current_day}')");
                    }
                    $count += $this->db->count_all_results('upgrade_sales_order');
                }
            }
            if ($this->MODULE_STATUS['product_validity'] == 'yes') {
                if ($debit_credit != 'credit' && (!$category || $category == 'membership_reactivation')) {
                    if ($user_id) {
                        $this->db->where('user_id', $user_id);
                    }
                    if ($date == 'month') {
                        $this->db->where("MONTH(date_submitted)=MONTH('{$current_day}')");
                        $this->db->where("YEAR(date_submitted)=YEAR('{$current_day}')");
                    }
                    if ($date == 'year') {
                        $this->db->where("YEAR(date_submitted)=YEAR('{$current_day}')");
                    }
                    $count += $this->db->count_all_results('package_validity_extend_history');
                }
            }
        }
        if ($this->MODULE_STATUS['pin_status'] == 'yes') {
            if ($debit_credit != 'credit' && (!$category || $category == 'epin_generated')) {
                $this->db->where('purchase_status', 'no');
                if ($user_id) {
                    $this->db->where('allocated_user_id', $user_id);
                }
                if ($date == 'month') {
                    $this->db->where("MONTH(pin_uploded_date)=MONTH('{$current_day}')");
                    $this->db->where("YEAR(pin_uploded_date)=YEAR('{$current_day}')");
                }
                if ($date == 'year') {
                    $this->db->where("YEAR(pin_uploded_date)=YEAR('{$current_day}')");
                }
                $count += $this->db->count_all_results('pin_numbers');
            }
        }

        return $count;
    }

public function getAllTransaction($user_id, $debit_credit, $category, $date, $page, $limit)
    {
        $current_day = date('Y-m-d');
        $this->db->select("amount");
        $this->db->select("CASE WHEN amount_type = 'purchase_donation' THEN 'donation' WHEN ewallet_type = 'ewallet_payment' THEN CONCAT(ewallet_type, '_', amount_type)  ELSE amount_type END AS amount_type");
        $this->db->select("type,date_added,user_id,ewallet_type");
        $this->db->from('ewallet_history');
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        if (in_array($debit_credit, ['debit', 'credit'])) {

             if($debit_credit == 'debit'){
               $debit_credit = 'credit';
             }
             else if($debit_credit == 'credit')
             {
               $debit_credit = 'debit';
             }
             else{

             }
            $this->db->where('type', $debit_credit);
        }
        if ($category) {
            //print_r($category);die;
            if (substr($category, 0, strlen('ewallet_payment')) === 'ewallet_payment') {
                $this->db->where("CONCAT(ewallet_type, '_', amount_type)='{$category}'");
            }
            elseif ($category == 'donation') {
                $this->db->where_in('amount_type', ['donation', 'purchase_donation']);
            }
            elseif ($category == 'pin_purchase_credit') {
                $this->db->where_in('amount_type', ['pin_purchase_delete', 'pin_purchase_refund']);
            }
            elseif (in_array($category, ['joining_fee', 'repurchase', 'upgrade', 'membership_reactivation'])) {
                $this->db->where("1=0");
            }
            else {
                $this->db->where('amount_type', $category);
            }
        }
        if ($date == 'month') {
            $this->db->where("MONTH(date_added)=MONTH('{$current_day}')");
            $this->db->where("YEAR(date_added)=YEAR('{$current_day}')");
        }
        if ($date == 'year') {
            $this->db->where("YEAR(date_added)=YEAR('{$current_day}')");
        }
        //this->db->where('amount_type !=', 'payout_release');
        $this->db->where('ewallet_type !=', 'payout');
        $this->db->where_not_in('amount_type',['user_credit', 'user_debit']);
        $this->db->where('ewallet_type !=', 'ewallet_payment');
        $quey_set[] = $this->db->get_compiled_select();

        if ($debit_credit != 'credit' && (!$category || $category == 'joining_fee')) {
            $this->db->select("total_amount amount,'joining_fee' amount_type,'credit' type,reg_date date_added,user_id, 'joining_fee'", false);
            $this->db->from('infinite_user_registration_details');
            if ($user_id) {
                $this->db->where('user_id', $user_id);
            }
            if ($date == 'month') {
                $this->db->where("MONTH(reg_date)=MONTH('{$current_day}')");
                $this->db->where("YEAR(reg_date)=YEAR('{$current_day}')");
            }
            if ($date == 'year') {
                $this->db->where("YEAR(reg_date)=YEAR('{$current_day}')");
            }
            $quey_set[] = $this->db->get_compiled_select();
        }

        if ($this->MODULE_STATUS['opencart_status'] == 'yes') {
            if ($debit_credit != 'credit' && (!$category || $category == 'repurchase')) {
                $this->db->select("e.total amount,'repurchase' amount_type,'credit' type,e.date_added,f.id user_id, 'repurchase'", false);
                $this->db->from('oc_order as e');
                $this->db->join('ft_individual as f', 'e.customer_id = f.oc_customer_ref_id');
                $this->db->where('e.order_type', 'purchase');
                $this->db->where('e.order_status_id >', 0);
                if ($user_id) {
                    $this->db->where('f.id', $user_id);
                }
                if ($date == 'month') {
                    $this->db->where("MONTH(e.date_added)=MONTH('{$current_day}')");
                    $this->db->where("YEAR(e.date_added)=YEAR('{$current_day}')");
                }
                if ($date == 'year') {
                    $this->db->where("YEAR(e.date_added)=YEAR('{$current_day}')");
                }
                $quey_set[] = $this->db->get_compiled_select();
            }
        } else {
            if ($this->MODULE_STATUS['repurchase_status'] == 'yes') {
                if ($debit_credit != 'credit' && (!$category || $category == 'repurchase')) {
                    $this->db->select("total_amount amount,'repurchase' amount_type,'credit',order_date date_added,user_id, 'repurchase'", false);
                    $this->db->from('repurchase_order');
                    $this->db->where('order_status', 'confirmed');
                    if ($user_id) {
                        $this->db->where('user_id', $user_id);
                    }
                    if ($date == 'month') {
                        $this->db->where("MONTH(order_date)=MONTH('{$current_day}')");
                        $this->db->where("YEAR(order_date)=YEAR('{$current_day}')");
                    }
                    if ($date == 'year') {
                        $this->db->where("YEAR(order_date)=YEAR('{$current_day}')");
                    }
                    $quey_set[] = $this->db->get_compiled_select();
                }
            }
            if ($this->MODULE_STATUS['package_upgrade'] == 'yes') {
                if ($debit_credit != 'credit' && (!$category || $category == 'upgrade')) {
                    $this->db->select("amount,'upgrade' amount_type,'credit' type,date_added,user_id,'upgrade'", false);
                    $this->db->from('upgrade_sales_order');
                    if ($user_id) {
                        $this->db->where('user_id', $user_id);
                    }
                    if ($date == 'month') {
                        $this->db->where("MONTH(date_added)=MONTH('{$current_day}')");
                        $this->db->where("YEAR(date_added)=YEAR('{$current_day}')");
                    }
                    if ($date == 'year') {
                        $this->db->where("YEAR(date_added)=YEAR('{$current_day}')");
                    }
                    $quey_set[] = $this->db->get_compiled_select();
                }
            }
            if ($this->MODULE_STATUS['product_validity'] == 'yes') {
                if ($debit_credit != 'credit' && (!$category || $category == 'membership_reactivation')) {
                    $this->db->select("total_amount amount,'membership_reactivation' amount_type,'credit' type,date_submitted date_added,user_id,'membership_reactivation'", false);
                    $this->db->from('package_validity_extend_history');
                    if ($user_id) {
                        $this->db->where('user_id', $user_id);
                    }
                    if ($date == 'month') {
                        $this->db->where("MONTH(date_submitted)=MONTH('{$current_day}')");
                        $this->db->where("YEAR(date_submitted)=YEAR('{$current_day}')");
                    }
                    if ($date == 'year') {
                        $this->db->where("YEAR(date_submitted)=YEAR('{$current_day}')");
                    }
                    $quey_set[] = $this->db->get_compiled_select();
                }
            }
        }
        if ($this->MODULE_STATUS['pin_status'] == 'yes') {
            if ($debit_credit != 'credit' && (!$category || $category == 'epin_generated')) {
                $this->db->select("pin_amount amount,'epin_generated' amount_type,'credit' type,pin_uploded_date date_added,allocated_user_id user_id, 'epin_generated'", false);
                $this->db->from('pin_numbers');
                $this->db->where('purchase_status', 'no');
                if ($user_id) {
                    $this->db->where('allocated_user_id', $user_id);
                }
                if ($date == 'month') {
                    $this->db->where("MONTH(pin_uploded_date)=MONTH('{$current_day}')");
                    $this->db->where("YEAR(pin_uploded_date)=YEAR('{$current_day}')");
                }
                if ($date == 'year') {
                    $this->db->where("YEAR(pin_uploded_date)=YEAR('{$current_day}')");
                }
                $quey_set[] = $this->db->get_compiled_select();
            }
        }

        $query = implode(" UNION ALL ", $quey_set);
        //print_r($query);die;
        $dbprefix = $this->db->dbprefix;
        $res = $this->db->query("SELECT t.*,f.user_name FROM ({$query}) t LEFT JOIN {$dbprefix}ft_individual f ON (t.user_id = f.id) ORDER BY date_added LIMIT {$page}, {$limit}");
        //print_r($res->result_array());die;
        return [
            'categories' => $this->getEnabledCategories(),
            'data' => $res->result_array()
        ];
    }

    public function getEnabledCategories()
    {
        $list = [];
        $level_commission_status = 'no';
        if (in_array($this->MLM_PLAN, ['Matrix', 'Unilevel', 'Donation']) || $this->MODULE_STATUS['sponsor_commission_status'] == 'yes') {
            $level_commission_status = 'yes';
        }
        $xup_commission_status = 'no';
        if ($this->MODULE_STATUS['xup_status'] == 'yes' && $level_commission_status == 'yes') {
            $xup_commission_status = 'yes';
            $level_commission_status = 'no';
        }
        if ($this->MODULE_STATUS['referal_status'] == 'yes') {
            $list[] = 'referral';
        }
        if ($this->MODULE_STATUS['rank_status'] == 'yes') {
            $list[] = 'rank_bonus';
        }
        if ($level_commission_status == 'yes') {
            $list[] = 'level_commission';
            if ($this->MODULE_STATUS['repurchase_status'] == 'yes' || $this->MODULE_STATUS['opencart_status'] == 'yes') {
                $list[] = 'repurchase_level_commission';
            }
            if ($this->MODULE_STATUS['package_upgrade'] == 'yes') {
                $list[] = 'upgrade_level_commission';
            }
        }
        if ($xup_commission_status == 'yes') {
            $list[] = 'xup_commission';
            if ($this->MODULE_STATUS['repurchase_status'] == 'yes' || $this->MODULE_STATUS['opencart_status'] == 'yes') {
                $list[] = 'xup_repurchase_level_commission';
            }
            if ($this->MODULE_STATUS['package_upgrade'] == 'yes') {
                $list[] = 'xup_upgrade_level_commission';
            }
        }
        if ($this->MLM_PLAN == 'Binary') {
            $list[] = 'leg';
            if ($this->MODULE_STATUS['repurchase_status'] == 'yes' || $this->MODULE_STATUS['opencart_status'] == 'yes') {
                $list[] = 'repurchase_leg';
            }
            if ($this->MODULE_STATUS['package_upgrade'] == 'yes') {
                $list[] = 'upgrade_leg';
            }
        }
        if ($this->MLM_PLAN == 'Stair_Step') {
            $list[] = 'stair_step';
            $list[] = 'override_bonus';
        }
        if ($this->MLM_PLAN == 'Board') {
            $list[] = 'board_commission';
        }
        if ($this->MODULE_STATUS['roi_status'] == 'yes' || $this->MODULE_STATUS['hyip_status'] == 'yes') {
            $list[] = 'daily_investment';
        }
        if ($this->MLM_PLAN == 'Donation') {
            $list[] = 'donation';
        }
        $additional_bonus_status = $this->validation_model->getConfig(['matching_bonus', 'pool_bonus', 'fast_start_bonus', 'performance_bonus']);
        if ($additional_bonus_status['matching_bonus'] == 'yes') {
            $list[] = 'matching_bonus';
            if ($this->MODULE_STATUS['repurchase_status'] == 'yes' || $this->MODULE_STATUS['opencart_status'] == 'yes') {
                $list[] = 'matching_bonus_purchase';
            }
            if ($this->MODULE_STATUS['package_upgrade'] == 'yes') {
                $list[] = 'matching_bonus_upgrade';
            }
        }
        if ($additional_bonus_status['pool_bonus'] == 'yes') {
            $list[] = 'pool_bonus';
        }
        if ($additional_bonus_status['fast_start_bonus'] == 'yes') {
            $list[] = 'fast_start_bonus';
        }
        if ($additional_bonus_status['performance_bonus'] == 'yes') {
            $performance_bonus_types = $this->getPerformanceBonusTypes();
            foreach ($performance_bonus_types as $v) {
                $list[] = $v;
            }
        }

        $list[] = 'joining_fee';
        if ($this->MODULE_STATUS['opencart_status'] == 'yes') {
            $list[] = 'repurchase';
        } else {
            if ($this->MODULE_STATUS['repurchase_status'] == 'yes') {
                $list[] = 'repurchase';
            }
            if ($this->MODULE_STATUS['package_upgrade'] == 'yes') {
                $list[] = 'upgrade';
            }
            if ($this->MODULE_STATUS['product_validity'] == 'yes') {
                $list[] = 'membership_reactivation';
            }
        }
        if ($this->MODULE_STATUS['pin_status'] == 'yes') {
            $list[] = 'epin_generated';
            $list[] = 'pin_purchase';
            $list[] = 'pin_purchase_credit';
        }
        $list[] = 'admin_credit';
        $list[] = 'admin_debit';
        return $list;
    }

    public function getAllEwalletTransactionCount($user_id, $debit_credit, $category, $date)
    {
        $current_day = date('Y-m-d');
        $count = 0;
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        if (in_array($debit_credit, ['debit', 'credit'])) {
            $this->db->where('type', $debit_credit);
        }
        if ($category) {
            if (substr($category, 0, strlen('ewallet_payment')) === 'ewallet_payment') {
                $this->db->where("CONCAT(ewallet_type, '_', amount_type)='{$category}'");
            } elseif ($category == 'donation') {
                $this->db->where_in('amount_type', ['donation', 'purchase_donation']);
            } elseif ($category == 'fund_transfer') {
                $this->db->where_in('amount_type', ['user_credit', 'user_debit']);
            } elseif ($category == 'payout_release_request') {
                $this->db->where_in('amount_type', ['payout_request', 'payout_release_manual']);
            } elseif ($category == 'payout_cancel') {
                $this->db->where_in('amount_type', ['payout_delete', 'payout_inactive', 'withdrawal_cancel']);
            } elseif ($category == 'pin_purchase_credit') {
                $this->db->where_in('amount_type', ['pin_purchase_delete', 'pin_purchase_refund']);
            } else {
                $this->db->where('amount_type', $category);
            }
        }
        if ($date == 'month') {
            $this->db->where("MONTH(date_added)=MONTH('{$current_day}')");
            $this->db->where("YEAR(date_added)=YEAR('{$current_day}')");
        }
        if ($date == 'year') {
            $this->db->where("YEAR(date_added)=YEAR('{$current_day}')");
        }
        $this->db->where('amount_type !=', 'payout_release');
        $count += $this->db->count_all_results('ewallet_history');

        return $count;
    }

    public function getAllEwalletTransaction($user_id, $debit_credit, $category, $date, $page, $limit)
    {
        $current_day = date('Y-m-d');
        $this->db->select("amount");
        $this->db->select("CASE WHEN amount_type = 'purchase_donation' THEN 'donation' WHEN ewallet_type = 'ewallet_payment' THEN CONCAT(ewallet_type, '_', amount_type) WHEN amount_type = 'user_credit' OR amount_type = 'user_debit' THEN ewallet_type ELSE amount_type END AS amount_type");
        $this->db->select("type,date_added,user_id");
        $this->db->from('ewallet_history');
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        if (in_array($debit_credit, ['debit', 'credit'])) {
            $this->db->where('type', $debit_credit);
        }
        if ($category) {
            if (substr($category, 0, strlen('ewallet_payment')) === 'ewallet_payment') {
                $this->db->where("CONCAT(ewallet_type, '_', amount_type)='{$category}'");
            } elseif ($category == 'donation') {
                $this->db->where_in('amount_type', ['donation', 'purchase_donation']);
            } elseif ($category == 'fund_transfer') {
                $this->db->where_in('amount_type', ['user_credit', 'user_debit']);
            } elseif ($category == 'payout_release_request') {
                $this->db->where_in('amount_type', ['payout_request', 'payout_release_manual']);
            } elseif ($category == 'payout_cancel') {
                $this->db->where_in('amount_type', ['payout_delete', 'payout_inactive', 'withdrawal_cancel']);
            } elseif ($category == 'pin_purchase_credit') {
                $this->db->where_in('amount_type', ['pin_purchase_delete', 'pin_purchase_refund']);
            } else {
                $this->db->where('amount_type', $category);
            }
        }
        if ($date == 'month') {
            $this->db->where("MONTH(date_added)=MONTH('{$current_day}')");
            $this->db->where("YEAR(date_added)=YEAR('{$current_day}')");
        }
        if ($date == 'year') {
            $this->db->where("YEAR(date_added)=YEAR('{$current_day}')");
        }
        $this->db->where('amount_type !=', 'payout_release');
        $quey_set[] = $this->db->get_compiled_select();

        $query = implode(" UNION ALL ", $quey_set);
        $dbprefix = $this->db->dbprefix;
        $res = $this->db->query("SELECT t.*,f.user_name FROM ({$query}) t LEFT JOIN {$dbprefix}ft_individual f ON (t.user_id = f.id) ORDER BY date_added LIMIT {$page}, {$limit}");

        return [
            'categories' => $this->getEnabledEwalletCategories(),
            'data' => $res->result_array()
        ];
    }

    public function getEnabledEwalletCategories()
    {
        $list = [];
        $level_commission_status = 'no';
        if (in_array($this->MLM_PLAN, ['Matrix', 'Unilevel', 'Donation']) || $this->MODULE_STATUS['sponsor_commission_status'] == 'yes') {
            $level_commission_status = 'yes';
        }
        $xup_commission_status = 'no';
        if ($this->MODULE_STATUS['xup_status'] == 'yes' && $level_commission_status == 'yes') {
            $xup_commission_status = 'yes';
            $level_commission_status = 'no';
        }
        if ($this->MODULE_STATUS['referal_status'] == 'yes') {
            $list[] = 'referral';
        }
        if ($this->MODULE_STATUS['rank_status'] == 'yes') {
            $list[] = 'rank_bonus';
        }
        if ($level_commission_status == 'yes') {
            $list[] = 'level_commission';
            if ($this->MODULE_STATUS['repurchase_status'] == 'yes' || $this->MODULE_STATUS['opencart_status'] == 'yes') {
                $list[] = 'repurchase_level_commission';
            }
            if ($this->MODULE_STATUS['package_upgrade'] == 'yes') {
                $list[] = 'upgrade_level_commission';
            }
        }
        if ($xup_commission_status == 'yes') {
            $list[] = 'xup_commission';
            if ($this->MODULE_STATUS['repurchase_status'] == 'yes' || $this->MODULE_STATUS['opencart_status'] == 'yes') {
                $list[] = 'xup_repurchase_level_commission';
            }
            if ($this->MODULE_STATUS['package_upgrade'] == 'yes') {
                $list[] = 'xup_upgrade_level_commission';
            }
        }
        if ($this->MLM_PLAN == 'Binary') {
            $list[] = 'leg';
            if ($this->MODULE_STATUS['repurchase_status'] == 'yes' || $this->MODULE_STATUS['opencart_status'] == 'yes') {
                $list[] = 'repurchase_leg';
            }
            if ($this->MODULE_STATUS['package_upgrade'] == 'yes') {
                $list[] = 'upgrade_leg';
            }
        }
        if ($this->MLM_PLAN == 'Stair_Step') {
            $list[] = 'stair_step';
            $list[] = 'override_bonus';
        }
        if ($this->MLM_PLAN == 'Board') {
            $list[] = 'board_commission';
        }
        if ($this->MODULE_STATUS['roi_status'] == 'yes' || $this->MODULE_STATUS['hyip_status'] == 'yes') {
            $list[] = 'daily_investment';
        }
        if ($this->MLM_PLAN == 'Donation') {
            $list[] = 'donation';
        }
        $additional_bonus_status = $this->validation_model->getConfig(['matching_bonus', 'pool_bonus', 'fast_start_bonus', 'performance_bonus']);
        if ($additional_bonus_status['matching_bonus'] == 'yes') {
            $list[] = 'matching_bonus';
            if ($this->MODULE_STATUS['repurchase_status'] == 'yes' || $this->MODULE_STATUS['opencart_status'] == 'yes') {
                $list[] = 'matching_bonus_purchase';
            }
            if ($this->MODULE_STATUS['package_upgrade'] == 'yes') {
                $list[] = 'matching_bonus_upgrade';
            }
        }
        if ($additional_bonus_status['pool_bonus'] == 'yes') {
            $list[] = 'pool_bonus';
        }
        if ($additional_bonus_status['fast_start_bonus'] == 'yes') {
            $list[] = 'fast_start_bonus';
        }
        if ($additional_bonus_status['performance_bonus'] == 'yes') {
            $performance_bonus_types = $this->getPerformanceBonusTypes();
            foreach ($performance_bonus_types as $v) {
                $list[] = $v;
            }
        }

        if ($this->MODULE_STATUS['pin_status'] == 'yes') {
            $list[] = 'pin_purchase';
            $list[] = 'pin_purchase_credit';
        }
        $list[] = 'fund_transfer';
        $list[] = 'admin_credit';
        $list[] = 'admin_debit';

        $list[] = 'payout_release_request';
        $list[] = 'payout_cancel';

        $this->load->model('register_model');
        $ewallet_status = $this->register_model->getPaymentStatus('E-wallet');
        if ($ewallet_status == 'yes') {
            $list[] = 'ewallet_payment_registration';
            if ($this->MODULE_STATUS['opencart_status'] == 'yes') {
                $list[] = 'ewallet_payment_repurchase';
            } else {
                if ($this->MODULE_STATUS['repurchase_status'] == 'yes') {
                    $list[] = 'ewallet_payment_repurchase';
                }
                if ($this->MODULE_STATUS['package_upgrade'] == 'yes') {
                    $list[] = 'ewallet_payment_upgrade';
                }
                if ($this->MODULE_STATUS['product_validity'] == 'yes') {
                    $list[] = 'ewallet_payment_package_validity';
                }
            }
        }

        return $list;
    }

    public function getUserEwalletDetailsCount($user_id, $from_date, $to_date){

        $details = array();
        if ($user_id != '') {
            $this->db->where('to_user_id', $user_id);
        }
        if ($from_date != '') {
            $this->db->where("date >=", $from_date);
        }
        if ($to_date != '') {
            $this->db->where("date <=", $to_date);
        }
        return $this->db->count_all_results('fund_transfer_details');
    }

    public function getEwalletOutwardFundDetails($user_id, $category, $date, $page, $limit)
    {
        $current_day = date('Y-m-d');
        $this->db->select("amount");
        $this->db->select("CASE WHEN amount_type = 'purchase_donation' THEN 'donation' WHEN ewallet_type = 'ewallet_payment' THEN CONCAT(ewallet_type, '_', amount_type) WHEN amount_type = 'user_credit' OR amount_type = 'user_debit' THEN ewallet_type ELSE amount_type END AS amount_type");
        $this->db->select("type,date_added,user_id");
        $this->db->from('ewallet_history');
        $this->db->where('type', 'debit');
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }

        if ($category) {
            if (substr($category, 0, strlen('ewallet_payment')) === 'ewallet_payment') {
                $this->db->where("CONCAT(ewallet_type, '_', amount_type)='{$category}'");
            }
            elseif ($category == 'donation') {
                $this->db->where_in('amount_type', ['donation', 'purchase_donation']);
            }
            elseif ($category == 'fund_transfer') {
                $this->db->where('type', 'debit');
            }
            elseif ($category == 'payout_release_request') {
                $this->db->where_in('amount_type', ['payout_request', 'payout_release_manual']);
            }
            elseif ($category == 'payout_cancel') {
                $this->db->where_in('amount_type', ['payout_delete', 'payout_inactive', 'withdrawal_cancel']);
            }
            elseif ($category == 'pin_purchase_credit') {
                $this->db->where_in('amount_type', ['pin_purchase_delete', 'pin_purchase_refund']);
            }
            elseif (in_array($category, ['joining_fee', 'repurchase', 'upgrade', 'membership_reactivation'])) {
                $this->db->where("1=0");
            }
            else {
                $this->db->where('amount_type', $category);
            }
        }
        if ($date == 'month') {
            $this->db->where("MONTH(date_added)=MONTH('{$current_day}')");
            $this->db->where("YEAR(date_added)=YEAR('{$current_day}')");
        }
        $this->db->where('amount_type !=', 'payout_release');
        $quey_set[] = $this->db->get_compiled_select();

        $query = implode(" UNION ALL ", $quey_set);
        $dbprefix = $this->db->dbprefix;
        $res = $this->db->query("SELECT t.*,f.user_name FROM ({$query}) t LEFT JOIN {$dbprefix}ft_individual f ON (t.user_id = f.id) ORDER BY date_added LIMIT {$page}, {$limit}");

        return [
            'categories' => $this->getEnabledEwalletCategories(),
            'data' => $res->result_array()
        ];
    }

    public function getEwalletOutwardFundCount($user_id, $category, $date)
    {
        $current_day = date('Y-m-d');
        $count = 0;
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        $this->db->where('type', 'debit');
        if ($category) {
            if (substr($category, 0, strlen('ewallet_payment')) === 'ewallet_payment') {
                $this->db->where("CONCAT(ewallet_type, '_', amount_type)='{$category}'");
            } elseif ($category == 'donation') {
                $this->db->where_in('amount_type', ['donation', 'purchase_donation']);
            } elseif ($category == 'fund_transfer') {
                $this->db->where('type', 'debit');
            } elseif ($category == 'payout_release_request') {
                $this->db->where_in('amount_type', ['payout_request', 'payout_release_manual']);
            } elseif ($category == 'payout_cancel') {
                $this->db->where_in('amount_type', ['payout_delete', 'payout_inactive', 'withdrawal_cancel']);
            } elseif ($category == 'pin_purchase_credit') {
                $this->db->where_in('amount_type', ['pin_purchase_delete', 'pin_purchase_refund']);
            } else {
                $this->db->where('amount_type', $category);
            }
        }
        if ($date == 'month') {
            $this->db->where("MONTH(date_added)=MONTH('{$current_day}')");
            $this->db->where("YEAR(date_added)=YEAR('{$current_day}')");
        }
        if ($date == 'year') {
            $this->db->where("YEAR(date_added)=YEAR('{$current_day}')");
        }
        $this->db->where('amount_type !=', 'payout_release');
        $count += $this->db->count_all_results('ewallet_history');

        return $count;
    }

    public function getEwalletSummary($type = '',$user_id = '')
    {
        $wallet_details = [];
        $current_date = date('Y-m-d');

        if ($this->MODULE_STATUS['pin_status'] == 'yes') {
            $this->db->select_sum('pin_amount');
            $this->db->where('purchase_status', 'yes');
            if ($user_id != '') {
                $this->db->where('generated_user_id', $user_id);
            }
            if ($type == 'month') {
                $this->db->where("MONTH(pin_uploded_date)=MONTH('{$current_date}')");
                $this->db->where("YEAR(pin_uploded_date)=YEAR('{$current_date}')");
            }
            if ($type == 'year') {
                $this->db->where("YEAR(pin_uploded_date)=YEAR('{$current_date}')");
            }
            $query = $this->db->get('pin_numbers');
            $epin_purchase_amount = $query->row_array()['pin_amount'] ?? 0;

            $wallet_details['epin_purchase'] = [
                'type' => 'debit',
                'amount' => $epin_purchase_amount
            ];

            $this->db->select_sum('amount');
            $this->db->where_in('amount_type', ['pin_purchase_refund', 'pin_purchase_delete']);
            if ($user_id != '') {
                $this->db->where('user_id', $user_id);
            }
            if ($type == 'month') {
                $this->db->where("MONTH(date_added)=MONTH('{$current_date}')");
                $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
            }
            if ($type == 'year') {
                $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
            }
            $query = $this->db->get('ewallet_history');
            $epin_refund_amount = $query->row_array()['amount'] ?? 0;

            $wallet_details['pin_purchase_refund'] = [
                'type' => 'credit',
                'amount' => $epin_refund_amount
            ];
        }

        $this->db->select_sum('amount');
        $this->db->where('amount_type', 'admin_credit');
        if ($user_id != '') {
            $this->db->where('user_id', $user_id);
        }
        if ($type == 'month') {
            $this->db->where("MONTH(date_added)=MONTH('{$current_date}')");
            $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
        }
        if ($type == 'year') {
            $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
        }
        $query = $this->db->get('ewallet_history');
        $admin_credit_amount = $query->row_array()['amount'] ?? 0;

        $wallet_details['admin_credit'] = [
            'type' => 'credit',
            'amount' => $admin_credit_amount
        ];

        $this->db->select_sum('amount');
        $this->db->where('amount_type', 'admin_debit');
        if ($user_id != '') {
            $this->db->where('user_id', $user_id);
        }
        if ($type == 'month') {
            $this->db->where("MONTH(date_added)=MONTH('{$current_date}')");
            $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
        }
        if ($type == 'year') {
            $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
        }
        $query = $this->db->get('ewallet_history');
        $admin_debit_amount = $query->row_array()['amount'] ?? 0;

        $wallet_details['admin_debit'] = [
            'type' => 'debit',
            'amount' => $admin_debit_amount
        ];

        $this->db->select_sum('amount');
        $this->db->where_in('amount_type', ['payout_request', 'payout_release_manual']);
        if ($user_id != '') {
            $this->db->where('user_id', $user_id);
        }
        if ($type == 'month') {
            $this->db->where("MONTH(date_added)=MONTH('{$current_date}')");
            $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
        }
        if ($type == 'year') {
            $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
        }
        $query = $this->db->get('ewallet_history');
        $payout_amount = $query->row_array()['amount'] ?? 0;

        $wallet_details['payout_release_request'] = [
            'type' => 'debit',
            'amount' => $payout_amount
        ];

        $this->db->select_sum('amount');
        $this->db->where_in('amount_type', ['payout_delete', 'payout_inactive', 'withdrawal_cancel']);
        if ($user_id != '') {
            $this->db->where('user_id', $user_id);
        }
        if ($type == 'month') {
            $this->db->where("MONTH(date_added)=MONTH('{$current_date}')");
            $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
        }
        if ($type == 'year') {
            $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
        }
        $query = $this->db->get('ewallet_history');
        $payout_cancel_amount = $query->row_array()['amount'] ?? 0;

        $wallet_details['payout_cancel'] = [
            'type' => 'credit',
            'amount' => $payout_cancel_amount
        ];

        $this->load->model('register_model');
        $ewallet_status = $this->register_model->getPaymentStatus('E-wallet');
        if ($ewallet_status == 'yes') {
            $this->db->select_sum('amount');
            $this->db->where('amount_type', 'registration');
            $this->db->where('ewallet_type', 'ewallet_payment');
            if ($user_id != '') {
                $this->db->where('user_id', $user_id);
            }
            if ($type == 'month') {
                $this->db->where("MONTH(date_added)=MONTH('{$current_date}')");
                $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
            }
            if ($type == 'year') {
                $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
            }
            $query = $this->db->get('ewallet_history');
            $ewallet_payment_registration_amount = $query->row_array()['amount'] ?? 0;

            $wallet_details['ewallet_payment_registration'] = [
                'type' => 'debit',
                'amount' => $ewallet_payment_registration_amount
            ];

            if ($this->MODULE_STATUS['opencart_status'] == 'yes') {
                $this->db->select_sum('amount');
                $this->db->where('amount_type', 'repurchase');
                $this->db->where('ewallet_type', 'ewallet_payment');
                if ($user_id != '') {
                    $this->db->where('user_id', $user_id);
                }
                if ($type == 'month') {
                    $this->db->where("MONTH(date_added)=MONTH('{$current_date}')");
                    $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
                }
                if ($type == 'year') {
                    $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
                }
                $query = $this->db->get('ewallet_history');
                $ewallet_payment_repurchase_amount = $query->row_array()['amount'] ?? 0;

                $wallet_details['ewallet_payment_repurchase'] = [
                    'type' => 'debit',
                    'amount' => $ewallet_payment_repurchase_amount
                ];
            } else {
                if ($this->MODULE_STATUS['repurchase_status'] == 'yes') {
                    $this->db->select_sum('amount');
                    $this->db->where('amount_type', 'repurchase');
                    $this->db->where('ewallet_type', 'ewallet_payment');
                    if ($user_id != '') {
                        $this->db->where('user_id', $user_id);
                    }
                    if ($type == 'month') {
                        $this->db->where("MONTH(date_added)=MONTH('{$current_date}')");
                        $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
                    }
                    if ($type == 'year') {
                        $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
                    }
                    $query = $this->db->get('ewallet_history');
                    $ewallet_payment_repurchase_amount = $query->row_array()['amount'] ?? 0;

                    $wallet_details['ewallet_payment_repurchase'] = [
                        'type' => 'debit',
                        'amount' => $ewallet_payment_repurchase_amount
                    ];
                }
                if ($this->MODULE_STATUS['package_upgrade'] == 'yes') {
                    $this->db->select_sum('amount');
                    $this->db->where('amount_type', 'upgrade');
                    $this->db->where('ewallet_type', 'ewallet_payment');
                    if ($user_id != '') {
                        $this->db->where('user_id', $user_id);
                    }
                    if ($type == 'month') {
                        $this->db->where("MONTH(date_added)=MONTH('{$current_date}')");
                        $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
                    }
                    if ($type == 'year') {
                        $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
                    }
                    $query = $this->db->get('ewallet_history');
                    $ewallet_payment_upgrade_amount = $query->row_array()['amount'] ?? 0;

                    $wallet_details['ewallet_payment_upgrade'] = [
                        'type' => 'debit',
                        'amount' => $ewallet_payment_upgrade_amount
                    ];
                }
                if ($this->MODULE_STATUS['product_validity'] == 'yes') {
                    $this->db->select_sum('amount');
                    $this->db->where('amount_type', 'package_validity');
                    $this->db->where('ewallet_type', 'ewallet_payment');
                    if ($user_id != '') {
                        $this->db->where('user_id', $user_id);
                    }
                    if ($type == 'month') {
                        $this->db->where("MONTH(date_added)=MONTH('{$current_date}')");
                        $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
                    }
                    if ($type == 'year') {
                        $this->db->where("YEAR(date_added)=YEAR('{$current_date}')");
                    }
                    $query = $this->db->get('ewallet_history');
                    $ewallet_payment_package_validity_amount = $query->row_array()['amount'] ?? 0;

                    $wallet_details['ewallet_payment_package_validity'] = [
                        'type' => 'debit',
                        'amount' => $ewallet_payment_package_validity_amount
                    ];
                }
            }
        }

        $enabled_bonus_list = $this->getEnabledBonusList();
        foreach ($enabled_bonus_list as $bonus) {
            $wallet_details[$bonus] = [
                'type' => 'credit',
                'amount' => 0
            ];
        }
        $this->db->select('amount_type,SUM(total_amount) total');
        $this->db->group_by('amount_type');
        if ($user_id != '') {
            $this->db->where('user_id', $user_id);
        }
        if ($type == 'month') {
            $this->db->where("MONTH(date_of_submission)=MONTH('{$current_date}')");
            $this->db->where("YEAR(date_of_submission)=YEAR('{$current_date}')");
        }
        if ($type == 'year') {
            $this->db->where("YEAR(date_of_submission)=YEAR('{$current_date}')");
        }
        $query = $this->db->get('leg_amount');
        foreach ($query->result_array() as $row) {
            $wallet_details[$row['amount_type']] = [
                'type' => 'credit',
                'amount' => $row['total'] ?? 0
            ];
        }
        if (isset($wallet_details['donation']) || isset($wallet_details['purchase_donation'])) {
            $wallet_details['donation_amount'] = [
                'type' => 'credit',
                'amount' => 0
            ];
            if (isset($wallet_details['donation'])) {
                $wallet_details['donation_amount']['amount'] += $wallet_details['donation']['amount'];
                unset($wallet_details['donation']);
            }
            if (isset($wallet_details['purchase_donation'])) {
                $wallet_details['donation_amount']['amount'] += $wallet_details['purchase_donation']['amount'];
                unset($wallet_details['purchase_donation']);
            }
        }

        return $wallet_details;
    }

    public function getEwalletBalanceReport($page = '', $limit = '',$keyword = '')
    {
        $this->db->select("fi.user_name,CONCAT(ud.user_detail_name,' ',ud.user_detail_second_name) full_name,uba.balance_amount,fi2.user_name sponsor_name");
        $this->db->from("ft_individual as fi");
        $this->db->join("user_details as ud", "ud.user_detail_refid = fi.id");
        $this->db->join("user_balance_amount as uba", "uba.user_id = ud.user_detail_refid");
        $this->db->join("ft_individual as fi2", "fi.sponsor_id = fi2.id", 'left');
        if ($keyword != '') {
            $where = array('fi.user_name' => $keyword, 'ud.user_detail_name' => $keyword,'fi2.user_name' => $keyword);
             $this->db->group_start()
                        ->or_like($where)
                        ->or_like("CONCAT( ud.user_detail_name,' ',ud.user_detail_second_name)", $keyword)
                        ->group_end();
        }
        $this->db->limit($limit, $page);
        $res = $this->db->get();
        return $res->result_array();
    }

    public function getEwalletBalanceReportCount($keyword = '')
    {
        $this->db->select("fi.user_name,CONCAT(ud.user_detail_name,' ',ud.user_detail_second_name) full_name,uba.balance_amount,fi2.user_name sponsor_name");
        $this->db->from("ft_individual as fi");
        $this->db->join("user_details as ud", "ud.user_detail_refid = fi.id");
        $this->db->join("user_balance_amount as uba", "uba.user_id = ud.user_detail_refid");
        $this->db->join("ft_individual as fi2", "fi.sponsor_id = fi2.id", 'left');
        if($keyword != ''){
            $where = array('fi.user_name' => $keyword, 'ud.user_detail_name' => $keyword,'fi2.user_name' => $keyword);
            $this->db->group_start()
                    ->or_like($where)
                    ->or_like("CONCAT( ud.user_detail_name,' ',ud.user_detail_second_name)", $keyword)
                    ->group_end();
        }
        return $this->db->count_all_results();
    }
    
    public function getSubscriptionEndDate($user_id=''){
        $end_date = '';
        $this->db->select('subs_end_date');
        $this->db->where('user_type','user');
        $this->db->where('id',$user_id);
        $this->db->from('ft_individual');
        $result = $this->db->get();
        foreach($result->result() as $row){
            $end_date = $row->subs_end_date;
        }
        return $end_date;
    }
    
    public function getAllTransactionDetails($user_id, $debit_credit, $category, $date)
    {
        $current_day = date('Y-m-d');
        $this->db->select("amount");
        $this->db->select("CASE WHEN amount_type = 'purchase_donation' THEN 'donation' WHEN ewallet_type = 'ewallet_payment' THEN CONCAT(ewallet_type, '_', amount_type)  ELSE amount_type END AS amount_type");
        $this->db->select("type,date_added,user_id,ewallet_type");
        $this->db->from('ewallet_history');
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        if (in_array($debit_credit, ['debit', 'credit'])) {

             if($debit_credit == 'debit'){
               $debit_credit = 'credit';
             }
             else if($debit_credit == 'credit')
             {
               $debit_credit = 'debit';
             }
             else{

             }
            $this->db->where('type', $debit_credit);
        }
        if ($category) {
            //print_r($category);die;
            if (substr($category, 0, strlen('ewallet_payment')) === 'ewallet_payment') {
                $this->db->where("CONCAT(ewallet_type, '_', amount_type)='{$category}'");
            }
            elseif ($category == 'donation') {
                $this->db->where_in('amount_type', ['donation', 'purchase_donation']);
            }
            elseif ($category == 'pin_purchase_credit') {
                $this->db->where_in('amount_type', ['pin_purchase_delete', 'pin_purchase_refund']);
            }
            elseif (in_array($category, ['joining_fee', 'repurchase', 'upgrade', 'membership_reactivation'])) {
                $this->db->where("1=0");
            }
            else {
                $this->db->where('amount_type', $category);
            }
        }
        if ($date == 'month') {
            $this->db->where("MONTH(date_added)=MONTH('{$current_day}')");
            $this->db->where("YEAR(date_added)=YEAR('{$current_day}')");
        }
        if ($date == 'year') {
            $this->db->where("YEAR(date_added)=YEAR('{$current_day}')");
        }
        //this->db->where('amount_type !=', 'payout_release');
        $this->db->where('ewallet_type !=', 'payout');
        $this->db->where_not_in('amount_type',['user_credit', 'user_debit']);
        $this->db->where('ewallet_type !=', 'ewallet_payment');
        $quey_set[] = $this->db->get_compiled_select();

        if ($debit_credit != 'credit' && (!$category || $category == 'joining_fee')) {
            $this->db->select("total_amount amount,'joining_fee' amount_type,'credit' type,reg_date date_added,user_id, 'joining_fee'", false);
            $this->db->from('infinite_user_registration_details');
            if ($user_id) {
                $this->db->where('user_id', $user_id);
            }
            if ($date == 'month') {
                $this->db->where("MONTH(reg_date)=MONTH('{$current_day}')");
                $this->db->where("YEAR(reg_date)=YEAR('{$current_day}')");
            }
            if ($date == 'year') {
                $this->db->where("YEAR(reg_date)=YEAR('{$current_day}')");
            }
            $quey_set[] = $this->db->get_compiled_select();
        }

        if ($this->MODULE_STATUS['opencart_status'] == 'yes') {
            if ($debit_credit != 'credit' && (!$category || $category == 'repurchase')) {
                $this->db->select("e.total amount,'repurchase' amount_type,'credit' type,e.date_added,f.id user_id, 'repurchase'", false);
                $this->db->from('oc_order as e');
                $this->db->join('ft_individual as f', 'e.customer_id = f.oc_customer_ref_id');
                $this->db->where('e.order_type', 'purchase');
                $this->db->where('e.order_status_id >', 0);
                if ($user_id) {
                    $this->db->where('f.id', $user_id);
                }
                if ($date == 'month') {
                    $this->db->where("MONTH(e.date_added)=MONTH('{$current_day}')");
                    $this->db->where("YEAR(e.date_added)=YEAR('{$current_day}')");
                }
                if ($date == 'year') {
                    $this->db->where("YEAR(e.date_added)=YEAR('{$current_day}')");
                }
                $quey_set[] = $this->db->get_compiled_select();
            }
        } else {
            if ($this->MODULE_STATUS['repurchase_status'] == 'yes') {
                if ($debit_credit != 'credit' && (!$category || $category == 'repurchase')) {
                    $this->db->select("total_amount amount,'repurchase' amount_type,'credit',order_date date_added,user_id, 'repurchase'", false);
                    $this->db->from('repurchase_order');
                    $this->db->where('order_status', 'confirmed');
                    if ($user_id) {
                        $this->db->where('user_id', $user_id);
                    }
                    if ($date == 'month') {
                        $this->db->where("MONTH(order_date)=MONTH('{$current_day}')");
                        $this->db->where("YEAR(order_date)=YEAR('{$current_day}')");
                    }
                    if ($date == 'year') {
                        $this->db->where("YEAR(order_date)=YEAR('{$current_day}')");
                    }
                    $quey_set[] = $this->db->get_compiled_select();
                }
            }
            if ($this->MODULE_STATUS['package_upgrade'] == 'yes') {
                if ($debit_credit != 'credit' && (!$category || $category == 'upgrade')) {
                    $this->db->select("amount,'upgrade' amount_type,'credit' type,date_added,user_id,'upgrade'", false);
                    $this->db->from('upgrade_sales_order');
                    if ($user_id) {
                        $this->db->where('user_id', $user_id);
                    }
                    if ($date == 'month') {
                        $this->db->where("MONTH(date_added)=MONTH('{$current_day}')");
                        $this->db->where("YEAR(date_added)=YEAR('{$current_day}')");
                    }
                    if ($date == 'year') {
                        $this->db->where("YEAR(date_added)=YEAR('{$current_day}')");
                    }
                    $quey_set[] = $this->db->get_compiled_select();
                }
            }
            if ($this->MODULE_STATUS['product_validity'] == 'yes') {
                if ($debit_credit != 'credit' && (!$category || $category == 'membership_reactivation')) {
                    $this->db->select("total_amount amount,'membership_reactivation' amount_type,'credit' type,date_submitted date_added,user_id,'membership_reactivation'", false);
                    $this->db->from('package_validity_extend_history');
                    if ($user_id) {
                        $this->db->where('user_id', $user_id);
                    }
                    if ($date == 'month') {
                        $this->db->where("MONTH(date_submitted)=MONTH('{$current_day}')");
                        $this->db->where("YEAR(date_submitted)=YEAR('{$current_day}')");
                    }
                    if ($date == 'year') {
                        $this->db->where("YEAR(date_submitted)=YEAR('{$current_day}')");
                    }
                    $quey_set[] = $this->db->get_compiled_select();
                }
            }
        }
        if ($this->MODULE_STATUS['pin_status'] == 'yes') {
            if ($debit_credit != 'credit' && (!$category || $category == 'epin_generated')) {
                $this->db->select("pin_amount amount,'epin_generated' amount_type,'credit' type,pin_uploded_date date_added,allocated_user_id user_id, 'epin_generated'", false);
                $this->db->from('pin_numbers');
                $this->db->where('purchase_status', 'no');
                if ($user_id) {
                    $this->db->where('allocated_user_id', $user_id);
                }
                if ($date == 'month') {
                    $this->db->where("MONTH(pin_uploded_date)=MONTH('{$current_day}')");
                    $this->db->where("YEAR(pin_uploded_date)=YEAR('{$current_day}')");
                }
                if ($date == 'year') {
                    $this->db->where("YEAR(pin_uploded_date)=YEAR('{$current_day}')");
                }
                $quey_set[] = $this->db->get_compiled_select();
            }
        }

        $query = implode(" UNION ALL ", $quey_set);
        //print_r($query);die;
        $dbprefix = $this->db->dbprefix;
        $res = $this->db->query("SELECT t.*,f.user_name FROM ({$query}) t LEFT JOIN {$dbprefix}ft_individual f ON (t.user_id = f.id) ORDER BY date_added");
        //print_r($res->result_array());die;
        return [
            'categories' => $this->getEnabledCategories(),
            'data' => $res->result_array()
        ];
    }


}
