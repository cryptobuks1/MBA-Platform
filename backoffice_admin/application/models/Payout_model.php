<?php

class payout_model extends inf_model {

    function __construct() {

        parent::__construct();

        $this->load->model('payout_class_model');
        $this->load->model('validation_model');
        $this->load->model('register_model');
        $this->load->model('settings_model');
    }

    public function payoutWeeklyTotal($limit, $page, $from, $to, $user_id = '') {
        $row1 = array();
        if ($user_id == '') {
            $this->db->select_sum('leg_amount.total_leg', 'total_leg');
            $this->db->select_sum('total_amount', 'total_amount');
            $this->db->select_sum('amount_payable', 'amount_payable');
            $this->db->select_sum('tds', 'tds');
            $this->db->select_sum('service_charge', 'service_charge');
            $this->db->select_sum('leg_amount_carry', 'leg_amount_carry');
            $this->db->select('user_id');
            $this->db->from('leg_amount');
            $this->db->join('ft_individual AS ft', 'ft.id = leg_amount.user_id', 'INNER');
            $this->db->where("date_of_submission >=", $from);
            $this->db->where("date_of_submission <=", $to);
            $this->db->where('ft.active', 'yes');
            $this->db->group_by('user_id');
            $this->db->limit($limit, $page);

            $query = $this->db->get();
        } else {
            $this->db->select_sum('leg_amount.total_leg', 'total_leg');
            $this->db->select_sum('total_amount', 'total_amount');
            $this->db->select_sum('amount_payable', 'amount_payable');
            $this->db->select_sum('tds', 'tds');
            $this->db->select_sum('service_charge', 'service_charge');
            $this->db->select_sum('leg_amount_carry', 'leg_amount_carry');
            $this->db->select('user_id');
            $this->db->from('leg_amount');
            $this->db->join('ft_individual AS ft', 'ft.id = leg_amount.user_id', 'INNER');
            $this->db->where("date_of_submission >=", $from);
            $this->db->where("date_of_submission <=", $to);
            $this->db->where('user_id', $user_id);
            $this->db->where('ft.active', 'yes');
            $this->db->group_by('user_id');
            $this->db->limit($limit, $page);
            $query = $this->db->get();
        }
        $i = 0;
        $row1 = array();
        foreach ($query->result_array() as $row) {
            $row1[$i]['user_id'] = $row['user_id'];
            $row1[$i]['total_leg'] = $row['total_leg'];
            $row1[$i]['total_amount'] = round($row['total_amount'], 8);
            $row1[$i]['leg_amount_carry'] = $row['leg_amount_carry'];
            $row1[$i]['user_name'] = $this->validation_model->IdToUserName($row['user_id']);
            $row1[$i]['full_name'] = $this->validation_model->getUserFullName($row['user_id']);
            $row1[$i]['amount_payable'] = round($row['amount_payable'], 8);
            $row1[$i]['tds'] = round($row['tds'], 8);
            $row1[$i]['service_charge'] = round($row['service_charge'], 8);
            $i++;
        }
        return $row1;
    }

    public function getIncomeStatement($user_id, $page, $limit) {
        $this->db->select('paid_user_id,paid_date,paid_type,paid_amount');
        $this->db->where('paid_date !=', '0000-00-00');
        $this->db->where('paid_user_id', $user_id);
        $this->db->limit($limit, $page);
        $res = $this->db->get('amount_paid');
        return $res->result_array();
    }
    
    public function getIncomeStatementCount($user_id) {
        $this->db->where('paid_date !=', '0000-00-00');
        $this->db->where('paid_user_id', $user_id);
        return $this->db->count_all_results('amount_paid');
    }

    public function getPayoutUserDetails($previous_pyout_date, $date_sub) {

        $payout_type = $this->getPayoutType();
        if ($payout_type == 'daily') {
            $this->db->select('a.user_name');
            $this->db->select('b.user_id ');
            $this->db->select_sum('total_amount');
            $this->db->select_sum('amount_payable');
            $this->db->select('b.amount_type ');
            $this->db->select('c.user_detail_name');
            $this->db->select('c.user_detail_address');
            $this->db->select('c.user_detail_mobile');
            $this->db->select('c.user_detail_nbank');
            $this->db->select('c.user_detail_nbranch');
            $this->db->select('c.user_detail_acnumber');
            $this->db->select(' c.user_detail_ifsc');
            $this->db->from('ft_individual AS a');
            $this->db->join('leg_amount AS b', 'a.id = b.user_id', 'inner');
            $this->db->join('user_details AS c', 'a.id = c.user_detail_refid', 'inner');
            $this->db->like('date_of_submission', $date_sub, 'after');
            $this->db->where('active', 'yes');
            $this->db->group_by('a . id');
            $query = $this->db->get();
        } else {
            $this->db->select('a.user_name');
            $this->db->select('b.user_id ');
            $this->db->select_sum('total_amount');
            $this->db->select_sum('amount_payable');
            $this->db->select('b.amount_type ');
            $this->db->select('c.user_detail_name');
            $this->db->select('c.user_detail_address');
            $this->db->select('c.user_detail_mobile');
            $this->db->select('c.user_detail_nbank');
            $this->db->select('c.user_detail_nbranch');
            $this->db->select('c.user_detail_acnumber');
            $this->db->select(' c.user_detail_ifsc');
            $this->db->from('ft_individual AS a');
            $this->db->join('leg_amount AS b', 'a.id = b.user_id', 'inner');
            $this->db->join('user_details AS c', 'a.id = c.user_detail_refid', 'inner');
            $this->db->where('released_date', $date_sub);
            $this->db->where('active', 'yes');
            $this->db->group_by('a . id');
            $query = $this->db->get();
        }

        $release = array();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $release[$i]['name'] = $row['user_name'];
            $release[$i]['uid'] = $row['user_id'];
            $release[$i]['total_amount'] = $row['total_amount'];
            $release[$i]['amount_payable'] = $row['amount_payable'];
            $release[$i]['type'] = $row['amount_type'];
            $release[$i]['user_name'] = $row['user_detail_name'];
            $release[$i]['address'] = $row['user_detail_address'];
            $release[$i]['mobile'] = $row['user_detail_mobile'];
            $release[$i]['bank'] = $row['user_detail_nbank'];
            $release[$i]['branch'] = $row['user_detail_nbranch'];
            $release[$i]['acc'] = $row['user_detail_acnumber'];
            $release[$i]['ifsc'] = $row['user_detail_ifsc'];
            $i++;
        }

        return $release;
    }

    public function getPayoutReleasePercentages($user_id = '') {

        $payout_details = array();


        $released_payouts = $this->getReleasedPayoutCount($user_id);
        $pending_payouts = $this->getPendingPayoutCount($user_id);
        $total_payouts = $pending_payouts + $released_payouts;
        if ($total_payouts > 0) {
            $released_payouts_percentage = ($released_payouts / $total_payouts) * 100;
            $pending_payouts_percentage = ($pending_payouts / $total_payouts) * 100;
        } else {
            $released_payouts_percentage = 100;
            $pending_payouts_percentage = 0;
        }

        $payout_details['released'] = $released_payouts_percentage;
        $payout_details['pending'] = $pending_payouts_percentage;

        return $payout_details;
    }

    public function getReleasedPayoutCount($user_id = '') {

        $count = 0;
        if ($user_id == '') {
            $this->db->select('*');
            $this->db->from('leg_amount');
            $count = $this->db->count_all_results();
        } else {
            $this->db->select('*');
            $this->db->from('leg_amount');
            $this->db->where('user_id', $user_id);
            $count = $this->db->count_all_results();
        }
        return $count;
    }

    public function getPendingPayoutCount($user_id = '') {
        $count = 0;
        if ($user_id == '') {
            $this->db->select('*');
            $this->db->from('leg_amount');
            $count = $this->db->count_all_results();
        } else {
            $this->db->select('*');
            $this->db->from('leg_amount');
            $this->db->where('user_id', $user_id);
            $count = $this->db->count_all_results();
        }
        return $count;
    }

    public function getPayoutDetails($payout_release_type, $amount = '', $read_status='',$payment_type='') {
        $payout_details = array();
        if ($amount == '') {
            $amount = $this->getMinimumPayoutAmount();
        }
        $current_date = date('Y-m-d H:i:s');
        if ($payout_release_type == 'ewallet_request') {
            $req_validity = $this->getPayoutRequestValidity();
            $this->db->select('pr.req_id,pr.requested_user_id,pr.requested_date,pr.requested_amount_balance,ft.user_name,ud.user_detail_name,ud.user_detail_second_name,ud.payout_type,pr.payment_method');
            $this->db->from('payout_release_requests AS pr');
            $this->db->join('ft_individual AS ft', 'ft.id = pr.requested_user_id', 'INNER');
            $this->db->join('user_details AS ud', 'ud.user_detail_refid = ft.id', 'INNER');
            $this->db->where('ft.active', 'yes');
            $this->db->where('ft.user_type !=', 'admin');
            if($read_status)
                $this->db->where('pr.read_status', $read_status);
            $this->db->where('pr.requested_amount >=', $amount);
            $this->db->where('pr.status', "pending");
            if($payment_type)
                $this->db->where('pr.payment_method', $payment_type);
            $this->db->order_by('pr.requested_date', 'DESC');
            $query = $this->db->get();
            $i = 0;
            foreach ($query->result_array() as $row) {
                $requested_date = $row['requested_date'];
                $req_id = $row['req_id'];
                $requested_user_id = $row['requested_user_id'];
                $diff = abs(strtotime($requested_date) - strtotime($current_date));
                $days = floor(($diff) / (60 * 60 * 24));
                $balance_amount = $this->getUserBalanceAmount($row['requested_user_id']);
                $requested_amount = $row['requested_amount_balance'];
                if ($days > $req_validity) {
                    $this->deletePayoutRequest($req_id, $requested_user_id, $status = 'inactive');
                } else {
                    $payout_details[$i]['req_id'] = $row['req_id'];
                    $payout_details[$i]['user_id'] = $requested_user_id;
                    $payout_details[$i]['user_name'] = $row['user_name'];
                    $payout_details[$i]['full_name'] = $row['user_detail_name'] . " " . ($row['user_detail_second_name'] ? $row['user_detail_second_name'] : "");
                    $payout_details[$i]['user_detail_name'] = $row['user_detail_name'];
                    $payout_details[$i]['balance_amount'] = $balance_amount;
                    $payout_details[$i]['payout_amount'] = $requested_amount;
                    $payout_details[$i]['requested_date'] = $row['requested_date']; 
                    $payout_details[$i]['payout_type'] = ($row['payment_method']== 'Bitcoin')? "Blocktrail" : $row['payment_method']; 

                    $array = array("binary_commission", "fast_start_bonus", "renewal_fast_start_bonus", "global_bonus", "leg");
                    $comms_array = $this->excel_model->getCommissionReport("2020-08-16", "2020-08-31", $array, $requested_user_id);
                    $payout_details[$i]['commision_details'] = end($comms_array)[5];


                    $user_payeer = "FALSE";
                    if ($this->payout_optional_model->getPayeerDetails($row['user_id'])) {
                        $user_payeer = "TRUE";
                    }
                    $payout_details[$i]['valid_payeer_account'] = $user_payeer;
                    $i++;
                }
            }
        } else {
            $this->db->select('usr.user_id,usr.balance_amount,ft.user_name,ud.user_detail_name,ud.user_detail_second_name,ud.payout_type');
            $this->db->from('user_balance_amount AS usr');
            $this->db->join('ft_individual AS ft', 'ft.id = usr.user_id', 'INNER');
            $this->db->join('user_details AS ud', 'ud.user_detail_refid = usr.user_id', 'INNER');
            $this->db->where('ft.active', 'yes');
            $this->db->where('ft.user_type !=', 'admin');
            $this->db->where('usr.balance_amount >=', $amount);
            $this->db->where('payout_type', $payment_type);
            $this->db->order_by('usr.balance_amount', 'DESC');
            $query = $this->db->get(); //echo $this->db->last_query();die;
            $i = 0;
            foreach ($query->result_array() as $row) {
                $payout_details[$i]['req_id'] = $row['user_name'];
                $payout_details[$i]['user_id'] = $row['user_id'];
                $payout_details[$i]['user_name'] = $row['user_name'];
                $payout_details[$i]['full_name'] = $row['user_detail_name'] . " " . ($row['user_detail_second_name'] ? $row['user_detail_second_name'] : "");
                $payout_details[$i]['user_detail_name'] = $row['user_detail_name'];
                $payout_details[$i]['balance_amount'] = $row['balance_amount'];
                $payout_details[$i]['payout_amount'] = $amount;
                $payout_details[$i]['requested_date'] = $current_date;
                $payout_details[$i]['payout_type'] = ($row['payout_type']== 'Bitcoin')? "Blocktrail" : $row['payout_type']; 


                $array = array("binary_commission", "fast_start_bonus", "renewal_fast_start_bonus", "global_bonus", "leg");
                $comms_array = $this->excel_model->getCommissionReport("2020-08-16", "2020-08-31", $array, $row['user_id']);
                $payout_details[$i]['commision_details'] = end($comms_array)[5];

                $user_payeer = "FALSE";
                if ($this->payout_optional_model->getPayeerDetails($row['user_id'])) {
                    $user_payeer = "TRUE";
                }
                $payout_details[$i]['valid_payeer_account'] = $user_payeer;
                $i++;
            }
        }
        return $payout_details;
    }

    public function getMinimumPayoutAmount() {
        $amount = 0;
        $this->db->select('min_payout');
        $this->db->from('configuration');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $amount = $row->min_payout;
        }
        return $amount;
    }

    public function getMaximumPayoutAmount() {
        $amount = 0;
        $this->db->select('max_payout');
        $this->db->from('configuration');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $amount = $row->max_payout;
        }
        return $amount;
    }

    public function checkTransactionPassword($user_id, $transation_password) {
        $this->db->select('tran_password');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('tran_password');
        $password_hash = $query->row_array()['tran_password'];
        $password_matched = password_verify($transation_password, $password_hash);
        if ($password_hash && $password_matched) {
            return true;
        }
        else {
            return false;
        }
    }

    public function getPayoutRequestValidity() {
        $request_validity = 0;
        $this->db->select('payout_request_validity');
        $this->db->from('configuration');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $request_validity = $row->payout_request_validity;
        }
        return $request_validity;
    }

    public function getUserBalanceAmount($user_id) {
        $user_balance = 0;
        $this->db->select('balance_amount');
        $this->db->from('user_balance_amount');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $user_balance = round($row->balance_amount, 8);
        }
        return $user_balance;
    }

    public function updateUserBalanceAmount($user_id, $payout_release_amount) {
        $res = 0;
        $balance_amount = $this->getUserBalanceAmount($user_id);
        if ($balance_amount >= $payout_release_amount && $payout_release_amount > 0) {
            $this->db->set('balance_amount', 'ROUND(balance_amount - ' . $payout_release_amount . ',8)', FALSE);
            $this->db->where('user_id', $user_id);
            $res = $this->db->update('user_balance_amount');
        }

        return $res;
    }

    public function insertPayoutReleaseRequest($user_id, $payout_amount, $request_date, $status = 'pending') {

        $payout_method = $this->validation_model->getUserData($user_id, "payout_type");
        $data = array(
            'requested_user_id' => $user_id,
            'requested_amount' => $payout_amount,
            'requested_amount_balance' => $payout_amount,
            'requested_date' => $request_date,
            'status' => $status,
            'payment_method'=>$payout_method,
            'updated_date' => $request_date,
            );
        $res = $this->db->insert('payout_release_requests', $data);
        
        $ewallet_id = $this->db->insert_id();
        $this->validation_model->addEwalletHistory($user_id, 0, $ewallet_id, 'payout', $payout_amount, 'payout_request', 'debit', $ewallet_id);
        
        return $res;
    }

    public function getReleasedPayoutTotal($user_id) {
        $total_amount = '';
        if ($release_payout_status = 'released') { 
            $this->db->select_sum('requested_amount');
            $this->db->where('requested_user_id', $user_id);
            $this->db->where('status', 'released');
            $this->db->from('payout_release_requests');
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $total_amount = $row->requested_amount;
            }
            $this->db->select_sum('requested_amount');
            $this->db->select_sum('requested_amount_balance');
            $this->db->where('requested_user_id', $user_id);
            $this->db->where_in('status', array('deleted','pending'));
            $this->db->from('payout_release_requests');
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $total_amount1 = $row->requested_amount;
                $total_amount2 = $row->requested_amount_balance;
                $final_amount = $total_amount1 - $total_amount2;
            }
        }
        return ($total_amount + $final_amount);
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

    public function deletePayoutRequest($del_id, $user_id, $status = 'deleted') {
        $date = date('Y-m-d H:i:s');
        $this->db->set('status', $status);
        $this->db->set('updated_date', $date);
        $this->db->where('req_id', $del_id);
        $this->db->where('requested_user_id', $user_id);
        $res = $this->db->update('payout_release_requests');
        if ($res) {
            $requested_amount = $this->getPayoutRequestAmount($del_id, $user_id);

            $data = array(
                'paid_user_id' => $user_id,
                'paid_amount' => $requested_amount,
                'paid_date' => $date,
                'paid_type' => $status . '_payout_release',
                'transaction_id' => 0
                );
            $result = $this->db->insert('amount_paid', $data);
            
            $ewallet_id = $del_id;
            $this->validation_model->addEwalletHistory($user_id, 0, $ewallet_id, 'payout', $requested_amount, ($status == 'deleted') ? 'payout_delete' : 'payout_inactive', 'credit', $del_id);

            if ($requested_amount && $result) {
                $this->addUserBalanceAmount($user_id, $requested_amount);
            }
        }
        return $res;
    }

    public function getPayoutRequestAmount($del_id, $user_id) {
        $requested_amount = 0;
        $this->db->select('requested_amount_balance');
        $this->db->where('req_id', $del_id);
        $this->db->where('requested_user_id', $user_id);
        $query = $this->db->get('payout_release_requests');
        foreach ($query->result_array()AS $row) {
            $requested_amount = $row["requested_amount_balance"];
        }
        return $requested_amount;
    }

    public function addUserBalanceAmount($user_id, $amount) {
        $res = 0;
        $balance_amount = $this->getUserBalanceAmount($user_id);
        if ($amount > 0) {
            $this->db->set('balance_amount', 'ROUND(balance_amount + ' . $amount . ',8)', FALSE);
            $this->db->where('user_id', $user_id);
            $res = $this->db->update('user_balance_amount');
        }
        return $res;
    }

    public function getUserDetails($user_id) {
        $this->load->model('country_state_model');
        $this->db->select('*');
        $this->db->where('user_detail_refid', $user_id);
        $this->db->from('user_details');
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $result[$i]['name'] = $row['user_detail_name'] . " " . ($row['user_detail_second_name'] ? $row['user_detail_second_name'] : "");
            $result[$i]['address'] = $row['user_detail_address'];
            $result[$i]['pin'] = $row['user_detail_pin'];
            $result[$i]['email'] = $row['user_detail_email'];
            $result[$i]['user_name'] = $this->validation_model->IdToUserName($user_id);
            $result[$i]['mobile'] = $row['user_detail_mobile'];
            $result[$i]['country'] = $this->country_state_model->getCountryNameFromId($row['user_detail_country']);
            $result[$i]['dob'] = $row['user_detail_dob'];
            if ($row['user_detail_gender'] == 'M')
                $result[$i]['gender'] = 'Male';
            else
                $result[$i]['gender'] = 'Female';
            $result[$i]['pan'] = $row['user_detail_pan'];
            $result[$i]['acc'] = $row['user_detail_acnumber'];
            $result[$i]['bank'] = $row['user_detail_nbank'];
            $result[$i]['branch'] = $row['user_detail_nbranch'];
            $i++;
        }
        return $result;
    }

    public function updatePayoutReleaseRequest($request_id, $user_id, $payout_release_amount, $payout_release_type,$release_method,$hash="") {
        $result = false;
        if ($payout_release_amount > 0) {
            $update_request = false;
            if ($payout_release_type == 'ewallet_request') {
                if ($this->isPayoutRequestPending($request_id, $user_id)) {
                    $this->db->set('status', "IF((requested_amount_balance - {$payout_release_amount}) <= 0, 'released', status)", FALSE);
                    $this->db->set('updated_date', date("Y-m-d H:i:s"));
                    $this->db->set('requested_amount_balance', 'ROUND(requested_amount_balance + ' . -$payout_release_amount . ',8)', FALSE);
                    $this->db->set('payment_method',$release_method);
                    $this->db->where('requested_user_id', $user_id);
                    $this->db->where('req_id', $request_id);
                    $this->db->where('status', 'pending');
                    $update_request = $this->db->update('payout_release_requests');
                }
            } else {
                $update_request = true;
            }
            if ($update_request) {
                $date = date('Y-m-d H:i:s');
                $data = array(
                    'paid_user_id' => $user_id,
                    'paid_amount' => $payout_release_amount,
                    'paid_date' => $date,
                    'transaction_id' => $hash,
                    'paid_type' => 'released',
                    'payment_method'=>$release_method
                    );
                if ($payout_release_type == 'ewallet_request') {
                    $data['request_id'] = $request_id;
                }
                $result = $this->db->insert('amount_paid', $data);
                
                if ($payout_release_type == 'ewallet_request') {
                    $ewallet_id = $request_id;
                    $release_type = 'payout_release';
                    $transaction_id = $request_id;
                } else {
                    $ewallet_id = $this->db->insert_id();
                    $release_type = 'payout_release_manual';
                    $transaction_id = '';
                }
                $this->validation_model->addEwalletHistory($user_id, 0, $ewallet_id, 'payout', $payout_release_amount, $release_type, 'debit', $transaction_id);
                
            }
        }
        return $result;
    }

    public function isPayoutRequestPending($request_id, $user_id) {
        $this->db->where('requested_user_id', $user_id);
        $this->db->where('req_id', $request_id);
        $this->db->where('status', 'pending');
        $count = $this->db->count_all_results('payout_release_requests');
        return $count;
    }

    public function getMinimumMaximunPayoutAmount() {
        $details = array();
        $this->db->select('min_payout,max_payout');
        $this->db->from('configuration');
        $this->db->where('id', 1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $details['min_payout'] = $row->min_payout;
            $details['max_payout'] = $row->max_payout;
        }
        return $details;
    }

    public function getBitcoinAddress($user_id) {
        $bitcoin_address = '';
        $this->db->select('bitcoin_address');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $query = $this->db->get();
        if (!empty($query->row('bitcoin_address'))) {
            $encoded_addr = $query->row('bitcoin_address');
            $key = $this->config->item('encryption_key');
            $bitcoin_address = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encoded_addr), MCRYPT_MODE_CBC, md5(md5($key))), "\0");  
        }
        return $bitcoin_address;
    }
    
    public function setPayoutViewed($to_read_status){  
        $this->db->set('read_status',$to_read_status++);
        $this->db->where('read_status',$to_read_status);
        $this->db->update('payout_release_requests');
        return;
    }
     //mark as paid 
    public function getReleasedPayout($from, $to , $limit = '',$page='') {
        $income_arr = array();
        $this->db->select('paid_id,paid_user_id,paid_date,paid_amount, ft.user_name');
         
        $this->db->where('paid_type  =', 'released');
        $this->db->where('paid_status  !=', 'yes');
        $this->db->where('payment_method','bank');
        if($from != '' && $to != '')
        {
        $this->db->where('paid_date  >=', $from);
        $this->db->where('paid_date  <=', $to);
        } else if ($from != '') {
            $this->db->where('paid_date  >=', $from);
        } else if ($to != '') {
            $this->db->where('paid_date  <=', $to);
        }
        $this->db->limit($limit, $page);
        $this->db->from("amount_paid");
        $this->db->join('ft_individual AS ft', 'ft.id = amount_paid.paid_user_id', 'INNER');
        $query = $this->db->get();
        $i = 0;
        
        foreach ($query->result_array() as $row) {

            $row_paid_date_split = explode(" ", $row['paid_date']);
            $row['paid_date'] = $row_paid_date_split[0];
           
            $income_arr["detail$i"]["paid_date"] = $row['paid_date'];
            $income_arr["detail$i"]["paid_id"] = $row['paid_id'];
            $income_arr["detail$i"]["paid_user_id"] = $row['paid_user_id'];
            $income_arr["detail$i"]["user_name"] = $row['user_name'];
            $income_arr["detail$i"]["paid_amount"] = $row['paid_amount'];
            $i++;
        }
        return $income_arr;
    }
    
    public function updateBankTransactionStatus($request_id,$user_id, $paid_amount)
    {
        $this->db->set('paid_status','yes');
        $this->db->where('paid_id  =', $request_id);
        $this->db->where('paid_type  =', 'released');
        $this->db->where('paid_status  !=', 'yes');
        $this->db->where('paid_amount  =', $paid_amount);
        $this->db->where('paid_user_id', $user_id);
       
        return $this->db->update("amount_paid") ;
    }
    
    public function getPayoutCount($from, $to) {

            $this->db->where('paid_type  =', 'released');
            $this->db->where('paid_status  !=', 'yes');
            if($from != '' && $to != '')
            {
            $this->db->where('paid_date  >=', $from);
            $this->db->where('paid_date  <=', $to);
            }
           
            $this->db->from("amount_paid");
            $count = $this->db->count_all_results();
       
        return $count;
    }
    //mark as paid ends
   
    //cancel waiting withrawal
    public function deletePayoutWithdrawed($user_id)
    {
        $result = false;
        $update_request = "";
        
                $this->db->select('req_id,requested_amount,requested_amount_balance,requested_user_id,status');
               // $this->db->select_sum('requested_amount_balance',  'amount_cancelled');
                $this->db->where('requested_user_id', $user_id);
                $this->db->where('status', 'pending');
                $details = $this->db->from('payout_release_requests');
                $query = $this->db->get();
                $count = $this->db->count_all_results();
                
                $amount_cancelled = 0;
                if($count > 0)
                {
                    foreach ($query->result_array() as $row)
                    {
                        
                    $amount_released = $row['requested_amount'] - $row['requested_amount_balance']; 
                      
                    $amount_cancelled +=  $row['requested_amount_balance'];
                    if(($row['requested_amount'] -($amount_released + $row['requested_amount_balance'])) == 0 )
                    {
                        $this->db->set('status',  'cancelled');
                     
                        $this->db->set('updated_date', date("Y-m-d H:i:s"));
                        $this->db->set('requested_amount', 'ROUND('.$row['requested_amount'].' +'  . -$row['requested_amount_balance'] . ',8)', FALSE);
                        $this->db->set('requested_amount_balance', '0' );
                        $this->db->where('req_id', $row['req_id'] );
                        $this->db->where('requested_amount',$row['requested_amount']);
                        $this->db->where('status', 'pending');
                        $update_request = $this->db->update('payout_release_requests');

                         $ewallet_id =  $row['req_id'];
                         
                        $this->db->set('balance_amount', 'ROUND(balance_amount  +' . $row['requested_amount_balance'] . ',8)', FALSE);
                        $this->db->where('user_id', $user_id);
                        $res1 = $this->db->update('user_balance_amount');
                       
                         
                     }
                    }
                    if($amount_cancelled)
                        $this->validation_model->addEwalletHistory($user_id, 0, $ewallet_id, 'payout',$amount_cancelled, 'withdrawal_cancel', 'credit', $ewallet_id);
                    
                     
                }
        
        else {
            $update_request = "";
        }
        
        return $update_request;
    }
         //ends 
    
    public function gatewayList(){
        $this->db->select('gateway_name');
        $this->db->where('payout_status', "yes");
        $this->db->order_by('payout_sort_order', "ASC");
        $this->db->from('payment_gateway_config');
        $res = $this->db->get();
        
        return $res->result_array();
    }

    public function userPayoutRequestCount($user_id, $status="released", $date="", $read_status='') {
        $this->db->where('requested_user_id', $user_id);
        $this->db->where('status', $status);
        if($date){
            $this->db->where('updated_date >=', $date);
        }
        if($read_status){
            $this->db->where('read_status', $read_status);
        }
        $count = $this->db->count_all_results('payout_release_requests');
        return $count;
    }
    
    public function getUserPayoutType($user_id){  
        
        $type = NULL;
        $this->db->select('payout_type');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $type = $row['payout_type'];
        }
        return $type;
    }

    public function getPayoutWithdrawalDetails($user_id ='', $status, $limit, $page) {
        $payout_details = array();
        $current_date = date('Y-m-d H:i:s');
            $req_validity = $this->getPayoutRequestValidity();
            $this->db->select('pr.req_id,pr.requested_user_id,pr.requested_date,pr.updated_date,pr.requested_amount_balance,pr.payment_method,ft.user_name,ud.user_detail_name,ud.user_detail_second_name');
            $this->db->from('payout_release_requests AS pr');
            $this->db->join('ft_individual AS ft', 'ft.id = pr.requested_user_id', 'INNER');
            $this->db->join('user_details AS ud', 'ud.user_detail_refid = ft.id', 'INNER');
            if($user_id!= NULL){
            $this->db->where('pr.requested_user_id', $user_id);
            }
            $this->db->where('ft.active', 'yes');
            $this->db->where('pr.status', $status);
            $this->db->limit($limit, $page);
            $this->db->order_by('pr.requested_date', 'DESC');
            $query = $this->db->get();
            $i = 0;
            foreach ($query->result_array() as $row) {
                $requested_date = $row['requested_date'];
                $req_id = $row['req_id'];
                $requested_user_id = $row['requested_user_id'];
                $diff = abs(strtotime($requested_date) - strtotime($current_date));
                $days = floor(($diff) / (60 * 60 * 24));
                $balance_amount = $this->getUserBalanceAmount($row['requested_user_id']);
                $requested_amount = $row['requested_amount_balance'];
                if ($days > $req_validity) {
                    $this->deletePayoutRequest($req_id, $requested_user_id, $status = 'inactive');
                } else {
                    $payout_details[$i]['req_id'] = $row['req_id'];
                    $payout_details[$i]['user_id'] = $requested_user_id;
                    $payout_details[$i]['user_name'] = $row['user_name'];
                    $payout_details[$i]['full_name'] = $row['user_detail_name'] . " " . ($row['user_detail_second_name'] ? $row['user_detail_second_name'] : "");
                    $payout_details[$i]['user_detail_name'] = $row['user_detail_name'];
                    $payout_details[$i]['balance_amount'] = $balance_amount;
                    $payout_details[$i]['payout_amount'] = $requested_amount;
                    $payout_details[$i]['requested_date'] = $row['requested_date']; 
                    $payout_details[$i]['payout_type'] = ($row['payment_method']== 'Bitcoin')? "Blocktrail" : $row['payment_method']; 
                    $payout_details[$i]['updated_date'] = $row['updated_date']; 
                    $i++;
                }
            }
        return $payout_details;
    }

    public function getReleasedWithdrawalDetails($user_id = '',$paid_status, $limit, $page) {
        $income_arr = array();
        $this->db->select('ap.paid_date,ap.paid_amount,ap.payment_method,ft.user_name,ud.user_detail_name');
        if($user_id!= NULL){
        $this->db->where('paid_user_id', $user_id);
        }
        $this->db->where('paid_type  =', 'released');
        if($paid_status == 'approved_pending'){
            $this->db->where('paid_status  !=', 'yes');
            $this->db->where('ap.payment_method =','bank');
        }elseif ($paid_status == 'approved_paid') {
            $this->db->where("CASE WHEN ap.payment_method = 'bank' THEN paid_status = 'yes' ELSE paid_status != 'yes' END");   
        }
        $this->db->limit($limit, $page);
        $this->db->from("amount_paid AS ap");
        $this->db->join('ft_individual AS ft', 'ft.id = ap.paid_user_id', 'INNER');
        $this->db->join('user_details AS ud', 'ud.user_detail_refid = ft.id', 'INNER');
        $this->db->order_by('ap.paid_date', 'DESC');
        $query = $this->db->get();

        $i = 0;
        
        foreach ($query->result_array() as $row) {
           
            $income_arr[$i]["paid_date"] = $row['paid_date'];
            $income_arr[$i]["user_name"] = $row['user_name'];
            $income_arr[$i]["user_detail_name"] = $row['user_detail_name'];
            $income_arr[$i]["paid_amount"] = $row['paid_amount'];
            $income_arr[$i]["payment_method"] = $row['payment_method'];
            $i++;
        }
        return $income_arr;
    } 
    
    public function getPayoutWithdrawalCount($user_id = '', $status) {
        if($user_id!= NULL){
                $this->db->where('pr.requested_user_id', $user_id);
        }
        $this->db->where('ft.active', 'yes');
        $this->db->where('pr.status', $status);
        $this->db->from('payout_release_requests AS pr');
        $this->db->join('ft_individual AS ft', 'ft.id = pr.requested_user_id', 'INNER');
        $this->db->join('user_details AS ud', 'ud.user_detail_refid = ft.id', 'INNER');
        return $this->db->count_all_results();
    }
    
    public function getReleasedWithdrawalCount($user_id = '',$paid_status) {
        
        if($user_id!= NULL){
        $this->db->where('paid_user_id', $user_id);
        }
        $this->db->where('paid_type  =', 'released');
        if($paid_status == 'approved_pending'){
            $this->db->where('paid_status  !=', 'yes');
            $this->db->where('ap.payment_method =','bank');
        }elseif ($paid_status == 'approved_paid') {
            $this->db->where("CASE WHEN ap.payment_method = 'bank' THEN paid_status = 'yes' END");   
        }
        $this->db->from("amount_paid AS ap");
        $this->db->join('ft_individual AS ft', 'ft.id = ap.paid_user_id', 'INNER');
        return $this->db->count_all_results();
        
    } 
    
    public function gatewayListStatus() {
        $this->db->select('id,gateway_name,payout_status,logo');
        //$this->db->where('payout_status', "yes");
        $this->db->order_by('payout_sort_order', "ASC");
        $this->db->from('payment_gateway_config');
        $res = $this->db->get();

        return $res->result_array();
    }

    public function inactivate_payout($id) {

        $this->db->set('payout_status', 'no');
        $this->db->where('id', $id);
        return $this->db->update('payment_gateway_config');
    }

    public function activate_payout($id){
        $this->db->set('payout_status', 'yes');
        $this->db->where('id', $id);
        return $this->db->update('payment_gateway_config');
    }
    
    
    
}
