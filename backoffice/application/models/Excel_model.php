<?php

class excel_model extends inf_model {

    private $obj_xml;
    private $symbol_left;
    private $symbol_right;

    public function __construct() {
        parent::__construct();
        $this->load->model('validation_model');
        require_once 'excel/class-excel-xml.inc.php';
        $this->obj_xml = new Excel_XML();
        $this->load->model('payout_model');
        $this->load->model('report_model');
        $this->load->model('select_report_model');

        $this->setUTFCurrencySymbol();
    }

    public function setUTFCurrencySymbol() {
        $this->symbol_left = $this->DEFAULT_SYMBOL_LEFT;
        $this->symbol_right = $this->DEFAULT_SYMBOL_RIGHT;
        if ($this->DEFAULT_SYMBOL_LEFT != '$') {
            $this->symbol_left = '';
        }
        if ($this->DEFAULT_SYMBOL_RIGHT != '$') {
            $this->symbol_right = '';
        }
    }

    public function writeToExcel($doc_arr, $file_name) {
        $this->obj_xml->addArray($doc_arr);
        $this->obj_xml->generateXML("$file_name");
    }

    public function getProfiles($cnt) {
        $excel_array = array();
        $details_arr = $this->report_model->profileReport($cnt);
        $detail_count = count($details_arr);
        $excel_array[1] = array(lang('full_name'), lang('user_name'),
            lang('sponsor_name'), lang('address'), lang('pincode'),
            lang('mobile_no'), lang('email'), lang('bank'), lang('branch'),
            lang('account_no'), lang('pan_no'),lang('date_of_joining'));
        for ($i = 2; $i <= $detail_count + 1; $i++) {
            $excel_array[$i][0] = $details_arr[$i - 2]["user_detail_name"];
            $excel_array[$i][1] = $details_arr[$i - 2]['uname'];
            $excel_array[$i][2] = $details_arr[$i - 2]['sponser_name'];
            $excel_array[$i][3] = $details_arr[$i - 2]["user_detail_address"];
            $excel_array[$i][4] = $details_arr[$i - 2]["user_detail_pin"];
            $excel_array[$i][5] = $details_arr[$i - 2]["user_detail_mobile"];
            $excel_array[$i][6] = $details_arr[$i - 2]["user_detail_email"];
            $excel_array[$i][7] = $details_arr[$i - 2]["user_detail_nbank"];
            $excel_array[$i][8] = $details_arr[$i - 2]["user_detail_nbranch"];
            $excel_array[$i][9] = $details_arr[$i - 2]["user_detail_acnumber"];
            $excel_array[$i][10] = $details_arr[$i - 2]["user_detail_pan"];
            $excel_array[$i][11] = date('Y/m/d', strtotime($details_arr[$i - 2]["join_date"]));
        }
        return $excel_array;
    }

    public function getProfilesFrom($count_from, $count_to) {
        $excel_array = array();
        $details_arr = $this->report_model->profileReportFromTo($count_to, $count_from);
        $detail_count = count($details_arr);
        $excel_array[1] = array(lang('full_name'), lang('user_name'), lang('sponsor_name'), lang('address'), lang('pincode'), lang('mobile_no'), lang('email'), lang('bank'), lang('branch'), lang('account_no'), lang('pan_no'), lang('ifsc'), lang('date_of_joining'));
        for ($i = 2; $i <= $detail_count + 1; $i++) {
            $excel_array[$i][0] = $details_arr[$i - 2]["user_detail_name"];
            $excel_array[$i][1] = $details_arr[$i - 2]['uname'];
            $excel_array[$i][2] = $details_arr[$i - 2]['sponser_name'];
            $excel_array[$i][3] = $details_arr[$i - 2]["user_detail_address"];
            $excel_array[$i][4] = $details_arr[$i - 2]["user_detail_pin"];
            $excel_array[$i][5] = $details_arr[$i - 2]["user_detail_mobile"];
            $excel_array[$i][6] = $details_arr[$i - 2]["user_detail_email"];
            $excel_array[$i][7] = $details_arr[$i - 2]["user_detail_nbank"];
            $excel_array[$i][8] = $details_arr[$i - 2]["user_detail_nbranch"];
            $excel_array[$i][9] = $details_arr[$i - 2]["user_detail_acnumber"];
            $excel_array[$i][10] = $details_arr[$i - 2]["user_detail_pan"];
            $excel_array[$i][11] = $details_arr[$i - 2]["user_detail_ifsc"];
            $excel_array[$i][12] = $details_arr[$i - 2]["join_date"];
        }
        return $excel_array;
    }

    public function getJoiningReportDaily($date) {
        $joinings_arr = $this->report_model->getTodaysJoining($date);
        $count = count($joinings_arr);
        $excel_array[1] = array(lang('user_name'), lang('full_name'), lang('upline_name'), lang('sponsor_name'), lang('status'), lang('date_of_joining'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $j = $i - 2;
            $excel_array[$i][0] = $joinings_arr["detail$j"]["user_name"];
            $excel_array[$i][1] = $joinings_arr["detail$j"]["user_full_name"];
            $excel_array[$i][2] = $joinings_arr["detail$j"]["father_user"];
            $excel_array[$i][3] = $joinings_arr["detail$j"]["sponsor_name"];
            if ($joinings_arr["detail$j"]['active'] == 'yes') {
                $excel_array[$i][4] = 'ACTIVE';
            } else {
                $excel_array[$i][4] = 'BLOCKED';
            }
            $excel_array[$i][5] = date('Y/m/d', strtotime($joinings_arr["detail$j"]["date_of_joining"]));
        }
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }

    public function getJoiningReportWeekly($from_date, $to_date) {
        $joinings_arr = $this->report_model->getWeeklyJoining($from_date, $to_date);
        $count = count($joinings_arr);
        $excel_array[1] = array(lang('user_name'), lang('full_name'), lang('upline_name'), lang('sponsor_name'), lang('status'), lang('date_of_joining'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $j = $i - 2;
            $excel_array[$i][0] = $joinings_arr["detail$j"]["user_name"];
            $excel_array[$i][1] = $joinings_arr["detail$j"]["user_full_name"];
            $excel_array[$i][2] = $joinings_arr["detail$j"]["father_user"];
            $excel_array[$i][3] = $joinings_arr["detail$j"]["sponsor_name"];
            if ($joinings_arr["detail$j"]['active'] == 'yes') {
                $excel_array[$i][4] = 'ACTIVE';
            } else {
                $excel_array[$i][4] = 'BLOCKED';
            }
            $excel_array[$i][5] = date('Y/m/d', strtotime($joinings_arr["detail$j"]["date_of_joining"]));
        }
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }

    public function getTotalPayoutReport($from_date = '', $to_date = '') {
        if ($from_date == '' && $to_date == '') {
            $total_payout_array = $this->report_model->getTotalPayout();
        } else {
            $total_payout_array = $this->report_model->getTotalPayout($from_date, $to_date);
        }
        $count = count($total_payout_array);
        $excel_array[1] = array(lang('full_name'), lang('user_name'), lang('address'), lang('bank'), lang('account_no'), lang('total_amount'), lang('tds'), lang('service_charge'), lang('amount_payable'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $j = $i - 2;
            $excel_array[$i][0] = $total_payout_array["detail$j"]["full_name"];
            $excel_array[$i][1] = $total_payout_array["detail$j"]["user_name"];
            $excel_array[$i][2] = $total_payout_array["detail$j"]["user_address"];
            $excel_array[$i][3] = $total_payout_array["detail$j"]["user_bank"];
            $excel_array[$i][4] = $total_payout_array["detail$j"]["acc_number"];
            $excel_array[$i][5] = round($total_payout_array["detail$j"]["total_amount"] * $this->DEFAULT_CURRENCY_VALUE, 8);
            $excel_array[$i][6] = round($total_payout_array["detail$j"]["tds"] * $this->DEFAULT_CURRENCY_VALUE, 8) ;
            $excel_array[$i][7] =  round($total_payout_array["detail$j"]["service_charge"] * $this->DEFAULT_CURRENCY_VALUE, 8) ;
            $excel_array[$i][8] = round($total_payout_array["detail$j"]["amount_payable"] * $this->DEFAULT_CURRENCY_VALUE, 8);
        }
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }

    public function getRankAchieversReport($from_date, $to_date, $ranks) {
        $ranked_users_array = $this->report_model->rankedUsers($ranks, $from_date, $to_date);
        $count = count($ranked_users_array);
        $excel_array[1] = array(lang('new_rank'), lang('user_name'), lang('full_name'), lang('rank_achieved_date'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $excel_array[$i][0] = $ranked_users_array[$i - 2]["rank_name"];
            $excel_array[$i][1] = $ranked_users_array[$i - 2]["user_name"];
            $excel_array[$i][2] = $ranked_users_array[$i - 2]["user_detail_name"];
            $excel_array[$i][3] = $ranked_users_array[$i - 2]["date"];
        }
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }

    public function getCommissionReport($from_date, $to_date, $type, $user_id) {
        $sum1 = 0;
        $sum2 = 0;
        $commission_details_array = $this->report_model->getCommisionDetails($type, $from_date, $to_date, $user_id);
        $count = count($commission_details_array);
        $excel_array[1] = array(lang('user_name'), lang('full_name'),lang('from_user'), lang('amount_type'), lang('date'), lang('total_amount'), lang('amount_payable'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $excel_array[$i][0] = $commission_details_array[$i - 2]["user_name"];
            $excel_array[$i][1] = $commission_details_array[$i - 2]["full_name"];
            $excel_array[$i][2] = $commission_details_array[$i - 2]["from_user"];
            $excel_array[$i][3] = $commission_details_array[$i - 2]["view_amt"];
            $excel_array[$i][4] = date('Y/m/d', strtotime($commission_details_array[$i - 2]["date"]));
            $excel_array[$i][5] = round($commission_details_array[$i - 2]["total_amount"] * $this->DEFAULT_CURRENCY_VALUE, 8);
            $excel_array[$i][6] =  round($commission_details_array[$i - 2]["amount_payable"] * $this->DEFAULT_CURRENCY_VALUE, 8);
            $sum1 = $sum1 + round($commission_details_array[$i - 2]["total_amount"] * $this->DEFAULT_CURRENCY_VALUE, 8);
            $sum2 = $sum2 + round($commission_details_array[$i - 2]["amount_payable"] * $this->DEFAULT_CURRENCY_VALUE, 8);
        }
        $excel_array[$i+1][0] = ' ';
        $excel_array[$i+1][1] = ' ';
        $excel_array[$i+1][2] = ' ';
        $excel_array[$i+1][3] = 'Total';
        $excel_array[$i+1][4] = round($sum1, 5);
        $excel_array[$i+1][5] = round($sum2, 5);
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }

    public function getEpinReport() {
        $epin_details_array = $this->report_model->getUsedPin();
        $count = count($epin_details_array);
        $excel_array[1] = array(lang('used_user'), lang('epin'), lang('pin_uploaded_date'), lang('pin_amount'), lang('pin_balance_amount'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $excel_array[$i][0] = $epin_details_array[$i - 2]["used_user"];
            $excel_array[$i][1] = $epin_details_array[$i - 2]["pin_number"];
            $excel_array[$i][2] = $epin_details_array[$i - 2]["pin_alloc_date"];
            $excel_array[$i][3] = round($epin_details_array[$i - 2]["pin_amount"] * $this->DEFAULT_CURRENCY_VALUE, 8);
            $excel_array[$i][4] = round($epin_details_array[$i - 2]["pin_balance_amount"] * $this->DEFAULT_CURRENCY_VALUE, 8);
        }
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }

    public function getTopEarnersReport() {
        $top_earners_array = $this->select_report_model->getTopEarners();
        $count = count($top_earners_array);
        $excel_array[1] = array(lang('full_name'), lang('user_name'), lang('current_balance'), lang('total_earnings'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $j = $i - 2;
            $excel_array[$i][0] = $top_earners_array["details$j"]["name"];
            $excel_array[$i][1] = $top_earners_array["details$j"]["user_name"];
            $excel_array[$i][2] = round($top_earners_array["details$j"]["current_balance"] * $this->DEFAULT_CURRENCY_VALUE, 8);
            $excel_array[$i][3] = round($top_earners_array["details$j"]["total_earnings"] * $this->DEFAULT_CURRENCY_VALUE, 8) . $this->symbol_right;
        }
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }

    public function getProfileViewReport($user_name) {
        $profile_details_array = $this->report_model->getProfileDetails($user_name);
        $excel_array[1][0] = lang('full_name');
        $excel_array[1][1] = $profile_details_array["details"][0]['user_detail_name'];

//        $excel_array[2][0] = lang('epin');
//        $excel_array[2][1] = $profile_details_array["details"][0]['user_detail_pin'];

        $excel_array[2][0] = lang('user_name');
        $excel_array[2][1] = $user_name;

        $excel_array[3][0] = lang('sponsor_name');
        $excel_array[3][1] = $profile_details_array["details"][0]['user_name'];

        $excel_array[4][0] = lang('address');
        $excel_array[4][1] = $profile_details_array["details"][0]['user_detail_address'];

        $excel_array[5][0] = lang('pincode');
        $excel_array[5][1] = $profile_details_array["details"][0]['user_detail_pin'];

        $excel_array[6][0] = lang('country');
        $excel_array[6][1] = $profile_details_array["details"][0]['user_detail_country'];

        $excel_array[7][0] = lang('state');
        $excel_array[7][1] = $profile_details_array["details"][0]['user_detail_state'];

        $excel_array[8][0] = lang('mobile_no');
        $excel_array[8][1] = $profile_details_array["details"][0]['user_detail_mobile'];

        $excel_array[9][0] = lang('land_line_no');
        $excel_array[9][1] = $profile_details_array["details"][0]['user_detail_land'];

        $excel_array[10][0] = lang('email');
        $excel_array[10][1] = $profile_details_array["details"][0]['user_detail_email'];

        $excel_array[11][0] = lang('date_of_birth');
        $excel_array[11][1] = $profile_details_array["details"][0]['user_detail_dob'];

        $excel_array[12][0] = lang('gender');
        if($profile_details_array["details"][0]['user_detail_gender'] == 'M'){
            $gender = lang('male');
        }else{
            $gender = lang('female'); 
        }
        $excel_array[12][1] = $gender;

        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }

    public function getSalesReport($from_date, $to_date,$product_type) {
        $sum = 0;
        if($product_type=="repurchase")
            $sales_report_array = $this->report_model->productRepurchaseSalesReport("all",$from_date, $to_date);
        else    
            $sales_report_array = $this->report_model->salesReport($from_date, $to_date);
        
        $count = count($sales_report_array);
        $excel_array[1] = array(lang('invoice_no'), lang('prod_name'), lang('user_name'), lang('payment_method'), lang('amount'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $excel_array[$i][0] = $sales_report_array[$i - 2]["invoice_no"];
            $excel_array[$i][1] = $sales_report_array[$i - 2]["prod_id"];
            $excel_array[$i][2] = $sales_report_array[$i - 2]["user_id"];
            $excel_array[$i][3] = lang($sales_report_array[$i - 2]["payment_method"]);
            $excel_array[$i][4] = round($sales_report_array[$i - 2]["amount"] * $this->DEFAULT_CURRENCY_VALUE, 8);
            $sum = $sum + round($sales_report_array[$i - 2]["amount"] * $this->DEFAULT_CURRENCY_VALUE, 8);
        }
        $excel_array[$i+1][0] = ' ';
        $excel_array[$i+1][1] = ' ';
        $excel_array[$i+1][2] = ' ';
        $excel_array[$i+1][3] = 'Total';
        $excel_array[$i+1][4] = $sum;
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }

    public function productSalesReport($prod_id,$product_type="register") {
        $sum = 0;
        if($product_type == "repurchase")
            $sales_report_array = $this->report_model->productRepurchaseSalesReport($prod_id);
        else
            $sales_report_array = $this->report_model->productSalesReport($prod_id);
        $count = count($sales_report_array);
        $excel_array[1] = array(lang('invoice_no'), lang('prod_name'), lang('user_name'), lang('payment_method'), lang('amount'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $excel_array[$i][0] = $sales_report_array[$i - 2]["invoice_no"];
            $excel_array[$i][1] = $sales_report_array[$i - 2]["prod_id"];
            $excel_array[$i][2] = $sales_report_array[$i - 2]["user_id"];
            $excel_array[$i][3] = lang($sales_report_array[$i - 2]["payment_method"]);
            $excel_array[$i][4] = round($sales_report_array[$i - 2]["amount"] * $this->DEFAULT_CURRENCY_VALUE, 8) ;
            $sum = $sum + round($sales_report_array[$i - 2]["amount"] * $this->DEFAULT_CURRENCY_VALUE, 8);
        }
        $excel_array[$i+1][0] = ' ';
        $excel_array[$i+1][1] = ' ';
        $excel_array[$i+1][2] = ' ';
        $excel_array[$i+1][3] = 'Total';
        $excel_array[$i+1][4] = $sum;
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }

    public function getMemberPayoutReport($user_name) {
        $member_payout_array = $this->report_model->getMemberPayout($user_name);
        $excel_array[1][0] = lang('user_name');
        $excel_array[1][1] = $member_payout_array['user_name'];

        $excel_array[2][0] = lang('user_full_name');
        $excel_array[2][1] = $member_payout_array['full_name'];

        $excel_array[3][0] = lang('address');
        $excel_array[3][1] = $member_payout_array['user_address'];

        $excel_array[4][0] = lang('bank');
        $excel_array[4][1] = $member_payout_array['user_bank'];

        $excel_array[5][0] = lang('account_no');
        $excel_array[5][1] = $member_payout_array['acc_number'];

        $excel_array[6][0] = lang('total_amount');
        $excel_array[6][1] = round($member_payout_array['total_amount'] * $this->DEFAULT_CURRENCY_VALUE, 8);
        $excel_array[7][0] = lang('tds');
        $excel_array[7][1] = round($member_payout_array['tds'] * $this->DEFAULT_CURRENCY_VALUE, 8);

        $excel_array[8][0] = lang('service_charge');
        $excel_array[8][1] = round($member_payout_array['service_charge'] * $this->DEFAULT_CURRENCY_VALUE, 8);

        $excel_array[9][0] = lang('amount_payable');
        $excel_array[9][1] = round($member_payout_array['amount_payable'] * $this->DEFAULT_CURRENCY_VALUE, 8);

        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }

    public function replaceNullFromArray($user_detail, $replace = '') {
        if ($replace == '') {
            $replace = "NA";
        }

        $len = count($user_detail);
        $key_up_arr = array_keys($user_detail);
        for ($i = 1; $i <= $len; $i++) {
            $k = $i - 1;
            $fild = $key_up_arr[$k];
            $arr_key = array_keys($user_detail["$fild"]);
            $key_len = count($arr_key);
            for ($j = 0; $j < $key_len; $j++) {
                $key_field = $arr_key[$j];
                if ($user_detail["$fild"]["$key_field"] == "") {
                    $user_detail["$fild"]["$key_field"] = $replace;
                }
            }
        }
        return $user_detail;
    }

    public function getActiveInactiveReport($from_date, $to_date) {
        $active_deactive_arr = $this->report_model->getAciveDeactiveUserDetails($from_date, $to_date);
        $count = count($active_deactive_arr);
        $excel_array[1] = array(lang('user_name'), lang('full_name'), lang('status'), lang('active_deactive_date'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $j = $i - 2;
            $excel_array[$i][0] = $active_deactive_arr["$j"]["user_name"];
            $excel_array[$i][1] = $active_deactive_arr["$j"]["full_name"];
            $excel_array[$i][2] = $active_deactive_arr["$j"]["status"];
            $excel_array[$i][3] = $active_deactive_arr["$j"]["date"];
        }
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }
    public function getRepurchaseReport($from_date, $to_date, $user_id="") {
        $total_amount = 0;
        $repurchase_arr = $this->report_model->getRepurchaseDetails($from_date, $to_date, $user_id);
        $count = count($repurchase_arr); 
        $excel_array[1] = array(lang('invoice_no'), lang('user_name'), lang('full_name'), lang('date_submission'), lang('payment_method'), lang('total_amount'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $j = $i - 2;
            $excel_array[$i][0] = $repurchase_arr["$j"]["invoice_no"];
            $excel_array[$i][1] = $repurchase_arr["$j"]["user_name"];
            $excel_array[$i][2] = $repurchase_arr["$j"]["full_name"];
            $excel_array[$i][3] = $repurchase_arr["$j"]["order_date"];
            $excel_array[$i][4] = lang($repurchase_arr["$j"]["payment_method"]);
            $excel_array[$i][5] = $repurchase_arr["$j"]["amount"];
            $total_amount += $repurchase_arr["$j"]["amount"];
        }
        $j = $i - 2;
        $excel_array[$i][0] = ' ';
        $excel_array[$i][1] = ' ';
        $excel_array[$i][2] = ' ';
        $excel_array[$i][3] = ' ';
        $excel_array[$i][4] = 'Total';
        $excel_array[$i][5] = $total_amount;
        
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }

    public function getStairStepDetails($week_date1, $week_date2, $leader_id="") {
        $details = array();
        $start_date = $week_date1 . " 00:00:00";
        $to_date = $week_date2 . " 23:59:59";
        $this->db->select('*');
        $this->db->from('leg_amount');
        $this->db->where('date_of_submission >=', $start_date);
        $this->db->where('date_of_submission <=', $to_date);
        $this->db->where("amount_type", 'stair_step');

        if($leader_id){
            $this->db->where("user_id", $leader_id);
        }

        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $details["$i"]["user_name"] = $this->validation_model->IdToUserName($row['user_id']);
            $details["$i"]["full_name"] = $this->validation_model->getUserFullName($row['user_id']);
 
            $details["$i"]["date_of_submission"] = $row['date_of_submission'];
            $details["$i"]["amount"] = $row['amount_payable'];
            $details["$i"]["paid_step"] = $row['user_level'];
            $details["$i"]["personal_volume"] = $row['pair_value'];
            $i++;
        }

        $count = count($details);
        $excel_array[1] = array(lang('user_name'), lang('full_name'), lang('date_submission'), lang('paid_step'), lang('personal_volume'), lang('amount'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $excel_array[$i][0] = $details[$i - 2]["user_name"];
            $excel_array[$i][1] = $details[$i - 2]["full_name"];
            $excel_array[$i][2] = $details[$i - 2]["date_of_submission"];
            $excel_array[$i][3] = $details[$i - 2]["paid_step"];
            $excel_array[$i][4] = $details[$i - 2]["personal_volume"]; 
            $excel_array[$i][5] = $details[$i - 2]["amount"];
        }
        $excel_array = $this->replaceNullFromArray($excel_array);

        return $excel_array;
    }

    public function getOverRideDetails($week_date1, $week_date2, $leader_id="") {
        $details = array();
        $start_date = $week_date1 . " 00:00:00";
        $to_date = $week_date2 . " 23:59:59";
        $this->db->select('*');
        $this->db->from('leg_amount');
        $this->db->where('date_of_submission >=', $start_date);
        $this->db->where('date_of_submission <=', $to_date);
        $this->db->where("amount_type", 'override_bonus');

        if($leader_id){
            $this->db->where("user_id", $leader_id);
        }

        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $details["$i"]["user_name"] = $this->validation_model->IdToUserName($row['user_id']);
            $details["$i"]["full_name"] = $this->validation_model->getUserFullName($row['user_id']);
 
            $details["$i"]["date_of_submission"] = $row['date_of_submission'];
            $details["$i"]["amount"] = $row['amount_payable'];
            $details["$i"]["paid_step"] = $row['user_level'];
            $details["$i"]["personal_volume"] = $row['pair_value'];
            $i++;
        }
        $count = count($details);
        $excel_array[1] = array(lang('user_name'), lang('full_name'), lang('date_submission'), lang('paid_step'), lang('personal_volume'), lang('amount'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $excel_array[$i][0] = $details[$i - 2]["user_name"];
            $excel_array[$i][1] = $details[$i - 2]["full_name"];
            $excel_array[$i][2] = $details[$i - 2]["date_of_submission"];
            $excel_array[$i][3] = $details[$i - 2]["paid_step"];
            $excel_array[$i][4] = $details[$i - 2]["personal_volume"]; 
            $excel_array[$i][5] = $details[$i - 2]["amount"];
        }
        $excel_array = $this->replaceNullFromArray($excel_array);

        return $excel_array;
    }

    //Added
    public function getReleasedPayoutReport($from_date= '', $to_date= '') {
        $released_payout_arr = $this->report_model->getReleasedPayoutDetails($from_date,$to_date);
        $count = count($released_payout_arr);        
        $excel_array[1] = array(lang('user_name'), lang('full_name'), lang('total_account'), lang('date'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $j = $i - 2;
            $excel_array[$i][0] = $released_payout_arr["detail$j"]["paid_user_id"];
            $excel_array[$i][1] = $released_payout_arr["detail$j"]["full_name"];
            $excel_array[$i][2] = round($released_payout_arr["detail$j"]["paid_amount"]*$this->DEFAULT_CURRENCY_VALUE,8);
            $excel_array[$i][3] = $released_payout_arr["detail$j"]["paid_date"];            
        }
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }
    
    public function getPendingPayoutReport($from_date= '', $to_date= '') {
        $released_payout_arr = $this->report_model->getPayoutPendingDetails($from_date,$to_date); 
        $count = count($released_payout_arr);        
        $excel_array[1] = array(lang('user_name'), lang('full_name'), lang('total_account'), lang('date'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $j = $i - 2;
            $excel_array[$i][0] = $released_payout_arr["$j"]["paid_user_id"];
            $excel_array[$i][1] = $released_payout_arr["$j"]["full_name"];
            $excel_array[$i][2] = round($released_payout_arr["$j"]["paid_amount"]*$this->DEFAULT_CURRENCY_VALUE,8);
            $excel_array[$i][3] = $released_payout_arr["$j"]["paid_date"];            
        }
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }
    
    public function getEpinTransferDetails($from_date, $to_date, $user_id="") {
        $total_amount = 0;
        $transfer_arr = $this->report_model->getEpinTransferDetails($from_date, $to_date, $user_id);
        $count = count($transfer_arr); 
        $excel_array[1] = array( lang('from_user'), lang('to_user'), lang('epin'), lang('transfer_date'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $j = $i - 2;
            $excel_array[$i][0] = $transfer_arr["$j"]["from_full_name"];
            $excel_array[$i][1] = $transfer_arr["$j"]["to_full_name"];
            $excel_array[$i][2] = $transfer_arr["$j"]["epin"];
            $excel_array[$i][3] = $transfer_arr["$j"]["transfer_date"];
        }
        
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }
    
    public function getEpinTransferDetailsForUser($from_date, $to_date, $user_id="") {
        $total_amount = 0;
        $transfer_arr = $this->report_model->getEpinTransferDetailsForUser($from_date, $to_date, $user_id);
        $count = count($transfer_arr); 
        $excel_array[1] = array( lang('user'), lang('epin'), lang('transfer_date'),lang('send')."/". lang('received'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $j = $i - 2;
            $excel_array[$i][0] = $transfer_arr["$j"]["user_full_name"];
            $excel_array[$i][1] = $transfer_arr["$j"]["epin"];
            $excel_array[$i][2] = $transfer_arr["$j"]["transfer_date"];
            $excel_array[$i][3] = $transfer_arr["$j"]["type"];
        }
        
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }
     
    function getConfigChangesReport($from_date,$to_date) {
        $i = 0;
        $detail = array();
        $config_details = $this->report_model->getConfigChanges($from_date,$to_date);
        $count = count($config_details);
     
        $excel_array[1] = array(lang('sl_no'), lang('updated_by'), lang('activity'), lang('description'), lang('date'), lang('ip'));
        for ($i = 2; $i <= $count + 1; $i++) {
      
            $excel_array[$i][0] = $i - 1;
            $excel_array[$i][1] = $config_details[$i - 2]["user_name"];
            $excel_array[$i][2] = $config_details[$i - 2]["activity"];
            $excel_array[$i][3] = $config_details[$i - 2]["desc"];
            $excel_array[$i][4] = $config_details[$i - 2]["date"];
            $excel_array[$i][5] = $config_details[$i - 2]["ip"];
            
            }
            
       $excel_array = $this->replaceNullFromArray($excel_array);
       return $excel_array;
    }
    
    public function getroiReport($from_date, $to_date, $user_id="") {
        $total_amount = 0;
        $roi_arr = $this->report_model->getroiDetails($from_date, $to_date, $user_id);

        $count = count($roi_arr); 
        $excel_array[1] = array(lang('username'), lang('package'), lang('date_of_submission'), lang('total_amount'));
        for ($i = 3; $i <= $count + 2; $i++) {
            $j = $i - 2;
            $excel_array[$i][0] = $roi_arr["det$j"]["from_id"];
            $excel_array[$i][1] = $roi_arr["det$j"]["package"];
            $date_of_submission = $roi_arr["det$j"]["date_of_submission"];
            $excel_array[$i][2] = date('Y/m/d', strtotime($date_of_submission));
            $excel_array[$i][3] = $roi_arr["det$j"]["amount_payable"];
            $total_amount += $roi_arr["det$j"]["amount_payable"];
        }
        $j = $i - 2;
        $excel_array[$i][0] = ' ';
        $excel_array[$i][1] = ' ';
        $excel_array[$i][2] = 'Total';
        $excel_array[$i][3] = $total_amount;
        
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }
    public function getPersonalDta($user_name) {
        $total_amount = 0;
        $this->load->model('activity_history_model');
        $gdpr_arr = $this->report_model->getGdprDetails($user_name);
        $activity_details = $this->activity_history_model->getActivityHistory('','','','',$user_name);
        $excel_array[1] = array(lang('about'));
        $i = 3;
        foreach ($gdpr_arr['about'] as $key => $value) {
            $excel_array[$i][0] = lang($key);
            $excel_array[$i][1] = $value;
            $i++;
        }
        $excel_array[$i++] = array();
        $count = count($gdpr_arr['commission']);
        if($count){
            $excel_array[$i++] = array(lang('commission_details'));
            $excel_array[$i++] = array(lang('amount_type'), lang('total_amount'));
            for ($k = 1,$j=0; $k <= $count; $k++,$j++) {
               /*if($gdpr_arr['commission'][$j]['amount_type'] == "board_commission"){
                    if ($this->MODULE_STATUS['table_status'] == 'yes' && $this->MODULE_STATUS['mlm_plan'] == 'Board')
                        $gdpr_arr['commission'][$j]['amount_type'] = 'table_commission';
                        
               }*/
               $excel_array[$i][0] = lang($gdpr_arr['commission'][$j]['amount_type']);
               $excel_array[$i][1] = round($gdpr_arr['commission'][$j]['total_amount']*$this->DEFAULT_CURRENCY_VALUE,8);
               $total_amount += $gdpr_arr['commission'][$j]['total_amount'];
               $i++;
            }
            $excel_array[$i][0] = lang('total');
            $excel_array[$i][1] = round($total_amount*$this->DEFAULT_CURRENCY_VALUE,8);
            $i++;
        }
        $excel_array[$i++] = array();
        $excel_array[$i++] = array(lang('activities'));
        $count = count($activity_details);
        $excel_array[$i++] = array(lang('date'), lang('ip_address'), lang('activity'));
        for ($k = 1,$j=0; $k <= $count; $k++,$j++) {
           $excel_array[$i][0] = date('Y-m-d', strtotime($activity_details[$j]["date"]));
           $excel_array[$i][1] = $activity_details[$j]["ip"];
           $excel_array[$i][2] = $activity_details[$j]["activity"];
           $i++;
        }
        return $excel_array;
    }
    
    public function getRankDetails($user_id, $from_date, $to_date) {

        $reward_array = $this->report_model->getRankDetails('', '', $user_id, $from_date, $to_date);
        /*   print_r($reward_array);
          die; */
        $count = count($reward_array);
        $excel_array[1] = array(lang('user_name'), lang('rank'), lang('rewards'), lang('date'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $j = $i - 2;
            $excel_array[$i][0] = $reward_array[$j]["user_name"];
            $excel_array[$i][1] = $reward_array[$j]["rank_name"];
            $excel_array[$i][2] = $reward_array[$j]["reward"];
            $excel_array[$i][3] = $reward_array[$j]["date"];
        }

        $excel_array = $this->replaceNullFromArray($excel_array);
        //print_r($excel_array); die;
        return $excel_array;
    }
}
