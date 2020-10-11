<?php

class register_model extends inf_model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('validation_model');
        $this->load->model('product_model');
        $this->load->model('configuration_model');
        $this->load->model('registersubmit_model');
        $this->load->model('mail_model');
        
        if (!$this->LOG_USER_ID) {
            $this->MLM_PLAN = $this->validation_model->getMLMPlan();
        }
        if ($this->MLM_PLAN == 'Hyip' || $this->MLM_PLAN == 'X-Up') {
            $this->load->model('Unilevel_model', 'plan_model');
        }
        else {
            $this->load->model($this->MLM_PLAN . '_model', 'plan_model');
        }
    }

    public function confirmRegister($regr, $module_status, $pending_signup_status = false)
    {

        if ($pending_signup_status) {
            $res = $this->addPendingRegistration($regr['payment_type'], $regr);
            return $res;
        }


        $msg = ['user' => '', 'pwd' => '', 'id' => '', 'status' => false, 'tran' => ''];

        $sponsor_id = $regr['sponsor_id'];
        $reg_from_tree = $regr['reg_from_tree'];
        $mlm_plan = $module_status['mlm_plan'];
        if (!in_array($mlm_plan, ['Binary', 'Matrix'])) {
            $reg_from_tree = false;
        }
        $regr['product_status'] = $module_status['product_status'];
        $position = $regr['position'];
        
        //USER PLACEMENT SECTION STARTS//
        $placement_details = $this->plan_model->getPlacementAndPosition($sponsor_id, $position, $reg_from_tree);

        if ($placement_details) {
            $regr['placement_id'] = $placement_details['id'];
            $regr['position'] = $placement_details['position'];
        } else {
            if (!$reg_from_tree) {
                $msg['error'] = "Unexpected error occured. Please conatct Admin";
                return $msg;
            }
        } 
        //USER PLACEMENT SECTION ENDS//

        if ($regr['user_name_type'] == 'dynamic') {
            $regr['username'] = $this->registersubmit_model->getUsername();
        } else {
            $regr['username'] = $regr['user_name_entry'];
        }

        if ($this->validation_model->isUserNameAvailable($regr['username'])) {
            if ($regr['by_using'] === "opencart") {
                $msg['error'] = "Username Not Available";
            } else {
                $msg['error'] = $this->lang->line('user_name_not_available');
            }
            return $msg;
        }
        if (!$this->validation_model->isLegAvailable($regr['placement_id'], $regr['position'], true)) {
            if ($regr['by_using'] === "opencart") {
                $msg['error'] = "Leg Not Available";
            } else {
                $msg['error'] = $this->lang->line('user_already_registered');
            }
            return $msg;
        }
        if ($module_status['product_status'] == 'yes') {
            if (!$this->product_model->isProductAvailable($regr['product_id'], 'registration')) {
                if ($regr['by_using'] === "opencart") {
                    $msg['error'] = "Product Not Available";
                } else {
                    $msg['error'] = $this->lang->line('product_not_available');
                }
                return $msg;
            }
        }

        if ($reg_from_tree) {
            $this->load->model('tree_model');
            $placement_id = $regr['placement_id'];
            $sponsor_left_right = $this->tree_model->getUserLeftAndRight($sponsor_id, 'father');
            $placement_left_right = $this->tree_model->getUserLeftAndRight($placement_id, 'father');
            if (($placement_left_right['left_father'] < $sponsor_left_right['left_father']) || ($placement_left_right['right_father'] > $sponsor_left_right['right_father'])) {
                $msg['error'] = lang('invalid_placement');
                return $msg;
            }
        }

        $regr['package_id'] = $this->product_model->getProductPackageId($regr['product_id'], $module_status, 'registration');

        $reg_status = $this->registersubmit_model->registerUser($regr, $module_status);
        
        if (isset($reg_status['status']) && $reg_status['status']) {
            $user_id = $regr['userid'] = $reg_status['user_id'];
            $regr['tran_password'] = $reg_status['transaction_password'];

            $msg['user_name'] = $msg['user'] = $regr['username'];
            $msg['password'] = $msg['pwd'] = $regr['pswd'];
            $msg['user_id'] = $msg['id'] = $user_id;
            $msg['user_id_encrypt'] = $msg['encr_id'] = $this->getEncrypt($user_id);
            $msg['transaction_password'] = $msg['tran'] = $regr['tran_password'];
            $msg['status'] = true;
            
            // PLAN SPECIFIC FUNCTION
            $this->plan_model->addBySpecificPlan($user_id, $regr['sponsor_id']);
            
            // PLAN SPECIFIC FUNCTION ENDS

            $rank_status = $module_status['rank_status'];
            $product_status = $module_status['product_status'];
            $referal_status = $module_status['referal_status'];
            $basic_demo_status = $module_status['basic_demo_status'];
            $balance_amount = 0;

            $product_id = 0;
            $product_amount = $regr['reg_amount'];
            $product_pv = $regr['reg_amount']; //if there is no product, level commissions are based on the registration fee
            if ($product_status == "yes") {
                $product_id = $regr['product_id'];
                $product_details = $this->product_model->getProductAmountAndPV($product_id);
                $product_pv = $product_details['pair_value'];
                $product_amount = $product_details['product_value'];
            }

            $oc_order_id = $regr['order_id'] ?? 0;

            if ($mlm_plan == 'Matrix') {
                $upline_id = $regr['sponsor_id'];
            } else {
                $upline_id = $regr['placement_id'];
            }
            $data = [
                'username' => $regr['username'],
                'sponsor_id' => $regr['sponsor_id'],
                'product_amount' => $regr['product_amount']
            ];

            $action = 'register';
            //CALCULATION SECTION STARTS//
            $this->plan_model->runCalculation($action, $user_id, $product_id, $product_pv, $product_amount, $oc_order_id, $upline_id, 0, $position, $data);          
           
            //CALCULATION SECTION ENDS//

            $this->load->model('calculation_model');            

            // Fast start bonus
          //  $this->calculation_model->calculateFastStartBonus($regr['sponsor_id']);

            // Rank commission
            if ($rank_status == 'yes' && $regr['reg_type']!='customer') {
                $this->load->model('rank_model');
                $obj_arr = $this->configuration_model->getRankConfiguration();
                $this->rank_model->updateDefaultRank($user_id, $obj_arr['default_rank_id']);
               // $this->rank_model->updateUplineRank($user_id);
            }

            // Referral commission
            $referal_commission_status = $this->validation_model->getCompensationConfig(['referal_commission_status']);
            if ($referal_commission_status == "yes") {
                $this->calculation_model->calculateReferralCommission($regr['sponsor_id'], $user_id);
            }

            if (($regr['email'] != "") && ($regr['email'] != null) && DEMO_STATUS == 'no') {
                $type = 'registration';
                $mail_status = $this->configuration_model->getSignupMailSendStatus();

                if ($mail_status == 'yes') {
                    $this->mail_model->sendAllEmails($type, $regr);
                }
            }

            if (ANDROID_APP_STATUS == 'yes') {
                $data = array("message" => lang('registration_completed_successfully'));
                $api_key = $this->getIndividualApiId($regr['sponsor_id']);
                $this->validation_model->sendGoogleCloudMessage($data, $api_key);
            }
        }

        return $msg;
    }

    public function addPendingRegistration($payment_method, $details)
    {
        $response = [];

        if ($details['user_name_type'] == 'dynamic') {
            $details['user_name_entry'] = $this->registersubmit_model->getUsername();
            if ($payment_method == 'bank_transfer') {

                $this->db->select_max('id');
                $this->db->from('payment_receipt');
                $query = $this->db->get();
                foreach ($query->result() as $row) {
                    $max_id = $row->id;
                }
                $this->db->set('user_name', $details['user_name_entry']);
                $this->db->where('id', $max_id);
                $result = $this->db->update('payment_receipt');

            }
        }

        $this->db->set('user_name', $details['user_name_entry']);
        $this->db->set('payment_method', $payment_method);
        $this->db->set('data', json_encode($details));
        $response['status'] = $this->db->insert('pending_registration');
        $response['user_id'] = $response['id'] = $this->db->insert_id();
        $response['user_name'] = $details['user_name_entry'];

        return $response;
    }

    public function getUserRegistrationDetails($user_id)
    {
        $registration_details = array();
        $get_data = array(
            "user_id" => $user_id
        );
        $this->db->limit(1);
        $result = $this->db->get_where('infinite_user_registration_details', $get_data);
        foreach ($result->result_array() as $row) {
            $registration_details = $row;
        }
        return $registration_details;
    }

    public function viewProducts($product_id = '', $status = 'yes')
    {
        $type_of_package = "registration";
        $product_array = $this->product_model->getAllProducts($status, $type_of_package);
        $lang_product = $this->lang->line('select_product');
        $products = '<option value="">' . $lang_product . '</option>';
        for ($i = 0; $i < count($product_array); $i++) {
            $id = $product_array[$i]['product_id'];
            $product_name = $product_array[$i]['product_name'];
            $product_value = $product_array[$i]['product_value'];
            $options = "$product_name ( " . $this->DEFAULT_SYMBOL_LEFT . round($product_value * $this->DEFAULT_CURRENCY_VALUE, $this->PRECISION) . $this->DEFAULT_SYMBOL_RIGHT . " )";
            $selected = '';
            if ($id == $product_id) {
                $selected = 'selected';
            }
            $products .= '<option value="' . $id . '"' . $selected . ' >' . $options . '</option>';
        }
        return $products;
    }

    public function isProductAdded()
    {

        $flag = 'no';

        $this->db->select('COUNT(*) AS cnt');
        $this->db->from('package');
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $count = $row->cnt;
        }

        if ($count > 0)
            $flag = 'yes';

        return $flag;
    }

    public function isPinAdded()
    {
        $flag = 'no';

        $this->db->select('COUNT(*) AS cnt');
        $this->db->from('pin_numbers');
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $count = $row->cnt;
        }

        if ($count > 0)
            $flag = 'yes';

        return $flag;
    }

    public function checkPassCode($prodcutpin, $prodcutid = "")
    {
        $prodcutpin = ($prodcutpin);
        if ($this->product_model->isProductPinAvailable($prodcutid, $prodcutpin))
            return $this->product_model->isPasscodeAvailable($prodcutpin);
    }

    public function checkSponser($sponser_full_name, $user_id)
    {
        $flag = false;
        $sponser_full_name = ($sponser_full_name);
        $sponser_user_name = ($user_id);

        $sponser_user_id = $this->validation_model->userNameToID($sponser_user_name);
        $sponser_full_name = $this->validation_model->getUserFullName($sponser_user_id);

        if ($sponser_user_id > 0) {

            $this->db->select('COUNT(*) AS cnt');
            $this->db->from('user_details');
            $this->db->where('user_detail_refid', $sponser_user_id);
            $this->db->where('user_detail_name', $sponser_full_name);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $count = $row->cnt;
            }
            if ($count > 0) {
                $flag = true;
            }
        }
        return $flag;
    }

    public function checkLeg($sponserleg, $sponser_user_name, $log_user_type, $log_user_id)
    {
        $this->load->model('tree_model');
        $sponserid = $this->validation_model->userNameToID($sponser_user_name);

        $binary_leg_allowed = $this->tree_model->getAllowedBinaryLeg($sponserid, $log_user_type, $log_user_id);
        if ($binary_leg_allowed != 'any' && $binary_leg_allowed != $sponserleg) {
            return false;
        }

        return $this->validation_model->isLegAvailable($sponserid, $sponserleg);
    }

    public function checkUser($user_name)
    {
        $flag = true;
        if ($user_name == "") {
            $flag = false;
            return $flag;
        }

        $this->db->select('COUNT(*) AS cnt');
        $this->db->from('ft_individual');
        $this->db->where('user_name', $user_name);

        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $count = $row->cnt;
        }
        if ($count > 0) {
            $flag = false;
        }
        return $flag;
    }

    function getEncrypt($string)
    {
        $key = "EASY1055MLM!@#$";
        $result = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) + ord($keychar));
            $result .= $char;
        }
        return base64_encode($result);
    }

    public function isUserAvailable($user_name)
    {
        $this->db->select("COUNT(id) as count");
        $this->db->from("ft_individual");
        $this->db->where('user_name', $user_name);
        $this->db->where('active', 'yes');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $count = $row->count;
        }

        return $count;
    }

    public function getTermsConditions($lang_id = '')
    {
        $terms_con = "";
        $this->db->select('terms_conditions');
        $this->db->from('terms_conditions');
        if ($lang_id != '')
            $this->db->where('lang_ref_id', $lang_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $terms_con = $row->terms_conditions;
        }
        return stripslashes($terms_con);
    }

    public function getUserDetails($uid)
    {
        $user_details = array();

        $this->db->select('*');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $uid);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $user_details = $row;
        }
        return $this->replaceNullFromArray($user_details, 'NA');
    }

    public function replaceNullFromArray($user_detail, $replace = '')
    {

        if ($replace == '') {
            $replace = "NA";
        }

        $len = count($user_detail);
        $key_up_arr = array_keys($user_detail);

        for ($i = 0; $i < $len; $i++) {

            $key_field = $key_up_arr[$i];
            if ($user_detail["$key_field"] == "") {
                $user_detail["$key_field"] = $replace;
            }
        }
        return $user_detail;
    }

    public function getProduct($product_id)
    {
        $MODULE_STATUS = $this->trackModule();
        if ($MODULE_STATUS['opencart_status'] != "yes" || $MODULE_STATUS['opencart_status_demo'] != "yes") {
            $this->db->select('*');
            $this->db->from('package');
            $this->db->where('product_id', $product_id);
            $query = $this->db->get();
        } else {
            $this->db->select("product_id,model as product_name,'yes' as active,date_added as date_of_insertion,package_id as prod_id,price as product_value,pair_value,0 as bv_value,0 as product_qty", false);
            $this->db->from("oc_product");
            $this->db->where('product_id', $product_id);
            $query = $this->db->get();
        }
        return $query->row_array();
    }

    public function getReferralName($user_id)
    {
        $user_detail_name = null;
        $this->db->select('user_detail_name,user_detail_second_name');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $user_detail_name = $row->user_detail_name;
            if ($row->user_detail_second_name != "NA")
                $user_detail_name .= " " . $row->user_detail_second_name;
        }
        return $user_detail_name;
    }

    public function checkMailStatus()
    {
        $status = null;
        $this->db->select('from_name');
        $this->db->select('reg_mail_status');
        $this->db->from('mail_settings');
        $this->db->where('id', 1);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $status = $row;
        }
        return $status;
    }

    public function insertIntoSalesOrder($user_id, $product_id, $payment_method = "", $pending_status = false)
    {
        $date = date('Y-m-d H:i:s');
        $last_inserted_id = $this->getMaxSalesOrderId();
        $invoice_no = 1000 + $last_inserted_id;
        $product_details = $this->getProduct($product_id);
        $amount = $product_details['product_value'];
        $product_pv = $this->product_model->getProductPV($product_id);
        $pending_id = 'NULL';
        if ($pending_status) {
            $pending_id = $user_id;
            $user_id = 'NULL';
        }

        $this->db->set('invoice_no', $invoice_no);
        $this->db->set('prod_id', $product_details['prod_id']);
        $this->db->set('user_id', $user_id, false);
        $this->db->set('amount', round($amount, 2));
        $this->db->set('product_pv', $product_pv);
        $this->db->set('date_submission', $date);
        $this->db->set('payment_method', $payment_method);
        $this->db->set('pending_id', $pending_id, false);
        $res = $this->db->insert('sales_order');

        if ($this->MODULE_STATUS['roi_status'] == 'yes' && ($this->MODULE_STATUS['opencart_status'] == "no" || $this->MODULE_STATUS['opencart_status_demo'] == "no")) {
            $this->db->set('prod_id', $product_details['prod_id']);
            $this->db->set('user_id', $user_id);
            $this->db->set('amount', round($amount, 2));
            $this->db->set('date_submission', $date);
            $this->db->set('payment_method', $payment_method);
            $this->db->set('pending_status', $pending_id);
            $this->db->set('roi', $product_details['roi']);
            $this->db->set('days', $product_details['days']);
            $res1 = $this->db->insert('roi_order');
        }
        return $res;
    }

    public function checkEPinValidity($epin, $sponsor_id)
    {
        $epin_arr = array();
        $session_data = $this->session->userdata('inf_logged_in');
        $user_id = $session_data['user_id'];
        $admin_userid = $this->validation_model->getAdminId();

        $date = date('Y-m-d');
        $this->db->select('pin_numbers,pin_balance_amount');
        $this->db->from('pin_numbers');
        //$this->db->where('pin_numbers', $epin);
        $this->db->where("pin_numbers LIKE BINARY '$epin'", NULL, true);
        if ($this->LOG_USER_TYPE == 'admin' || $this->LOG_USER_TYPE == 'employee') {
            $whr = '(allocated_user_id=' . $user_id . ' or allocated_user_id=' . $sponsor_id . ' or allocated_user_id=' . $admin_userid . ' or allocated_user_id IS NULL )';
        } else {
            $whr = '(allocated_user_id=' . $user_id . ' or allocated_user_id=' . $sponsor_id . ')';
        }

        $this->db->where($whr);
        $this->db->where('pin_amount >', 0);
        $this->db->where('status', 'yes');
        $this->db->where('pin_expiry_date >=', $date);
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $epin_arr['pin_numbers'] = $row['pin_numbers'];
            $epin_arr['pin_amount'] = $row['pin_balance_amount'];
        }
        return $epin_arr;
    }

    public function UpdateUsedEpin($pin_det, $pin_count)
    {
        $user_id = $pin_det['user_id'];

        for ($i = 1; $i <= $pin_count; $i++) {
            $pin_no = $pin_det["$i"]['pin'];
            $pin_balnce = $pin_det["$i"]['balance_amount'];
            if ($pin_balnce == 0) {
                $this->db->set('status', "no");
            }
            $pin_balnce = round($pin_balnce / $this->DEFAULT_CURRENCY_VALUE, 2);
            $this->db->set('used_user', $user_id);
            $this->db->set('pin_balance_amount', round($pin_balnce, 2));
            $this->db->where('pin_numbers', $pin_no);
            $this->db->where('status', "yes");
            $result = $this->db->update('pin_numbers');
        }
        return $result;
    }

    public function UpdateUsedUserEpin($pin_det, $pin_count)
    {
        for ($i = 1; $i <= $pin_count; $i++) {
            $pin_no = $pin_det["$i"]['pin'];
            $pin_balnce = $pin_det["$i"]['balance_amount'];
            if ($pin_balnce == 0) {
                $this->db->set('status', "no");
            }
            $pin_balnce = round($pin_balnce / $this->DEFAULT_CURRENCY_VALUE, 2);
            $this->db->set('pin_balance_amount', round($pin_balnce, 2));
            $this->db->where('pin_numbers', $pin_no);
            $this->db->where('status', "yes");
            $result = $this->db->update('pin_numbers');
        }
        return $result;
    }

    public function insertUsedPin($epin_det, $pin_count, $pending_status = false, $type = 'register')
    {
        $user_id = $epin_det['user_id'];
        $date = date('Y-m-d H:m:s');
        $pending_id = 'NULL';
        if ($pending_status) {
            $pending_id = $user_id;
            $user_id = 'NULL';
        }

        for ($i = 1; $i <= $pin_count; $i++) {
            $pin_no = $epin_det["$i"]['pin'];
            $pin_balnce = $epin_det["$i"]['balance_amount'];
            $pin_amount = $epin_det["$i"]['amount'];
            $status = "yes";
            if ($pin_balnce == 0) {
                $status = "no";
            }
            $this->db->set('status', $status);
            $this->db->set('pin_number', $pin_no);
            $this->db->set('used_user', $user_id, false);
            $this->db->set('pin_alloc_date', $date);
            $this->db->set('pending_id', $pending_id, false);
            $this->db->set('pin_amount', round($pin_amount, 2));
            $this->db->set('pin_balance_amount', round($pin_balnce, 2));
            $res = $this->db->insert('pin_used');
        }
        return $res;
    }

    public function getProductAmount($product_id)
    {
        $product_details = $this->product_model->getProductAmountAndPV($product_id);
        $product_amount = $product_details['product_value'];
        return $product_amount;
    }

    public function getBalanceAmount($user_id, $balance = '')
    {
        $user_balance = 0;
        $this->db->select('balance_amount');
        $this->db->select('user_id');
        $this->db->where('user_id', $user_id);
        if ($balance != '') {
            $this->db->where('balance_amount >', $balance);
        }
        $this->db->from('user_balance_amount');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $user_balance = $row['balance_amount'];
        }
        return $user_balance;
    }

    public function checkEwalletPassword($user_id, $password)
    {
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

    public function insertUsedEwallet($user_ref_id, $user_id, $used_amount, $transaction_id, $pending_status = false, $amount_type = "registration")
    {
        $date = date('Y-m-d H:i:s');
        $pending_id = 'NULL';
        if ($pending_status) {
            $pending_id = $user_id;
            $user_id = 'NULL';
        }
        $this->db->set('used_user_id', $user_ref_id);
        $this->db->set('used_amount', round($used_amount, 2));
        $this->db->set('user_id', $user_id, false);
        $this->db->set('used_for', $amount_type);
        $this->db->set('date', $date);
        $this->db->set('pending_id', $pending_id, false);
        $this->db->set('transaction_id', $transaction_id);
        $res = $this->db->insert('ewallet_payment_details');

        $ewallet_id = $this->db->insert_id();
        $this->validation_model->addEwalletHistory($user_ref_id, $user_id, $ewallet_id, 'ewallet_payment', $used_amount, $amount_type, 'debit', $transaction_id, '', 0, $pending_id);

        return $res;
    }

    public function updateUsedEwallet($ewallet_user, $ewallet_bal, $up_bal = '')
    {
        if ($up_bal == '') {
            $user_id = $this->validation_model->userNameToID($ewallet_user);
        } else {
            $user_id = $ewallet_user;
        }
        $this->db->set('balance_amount', round($ewallet_bal, 8));
        $this->db->where('user_id', $user_id);
        $res = $this->db->update('user_balance_amount');
        return $res;
    }

    public function getPaymentGatewayStatus($page = '')
    {

        if ($page != '') {
            $details['paypal_status'] = $this->getGatewayStatus('Paypal', $page);
            $details['creditcard_status'] = $this->getGatewayStatus('Creditcard', $page);
            $details['authorize_status'] = $this->getGatewayStatus('Authorize.net', $page);
            $details['bitcoin_status'] = $this->getGatewayStatus('Bitcoin', $page);
            $details['blockchain_status'] = $this->getGatewayStatus('Blockchain', $page);
            $details['bitgo_status'] = $this->getGatewayStatus('bitgo', $page);
            $details['payeer_status'] = $this->getGatewayStatus('Payeer', $page);
            $details['sofort_status'] = $this->getGatewayStatus('Sofort', $page);
            $details['squareup_status'] = $this->getGatewayStatus('SquareUp', $page);
        } else {
            $details['paypal_status'] = $this->getGatewayStatus('Paypal');
            $details['creditcard_status'] = $this->getGatewayStatus('Creditcard');
            $details['authorize_status'] = $this->getGatewayStatus('Authorize.net');
            $details['bitcoin_status'] = $this->getGatewayStatus('Bitcoin');
            $details['blockchain_status'] = $this->getGatewayStatus('Blockchain');
            $details['bitgo_status'] = $this->getGatewayStatus('bitgo');
            $details['payeer_status'] = $this->getGatewayStatus('Payeer');
            $details['sofort_status'] = $this->getGatewayStatus('Sofort');
            $details['squareup_status'] = $this->getGatewayStatus('SquareUp');
        }
        return $details;
    }

    public function getGatewayStatus($gateway, $page = '')
    {
        $status = "no";
        $this->db->select('status');
        $this->db->like('gateway_name', $gateway);
        $this->db->from('payment_gateway_config');
        if ($page != '')
            $this->db->where($page, 1);
        $this->db->limit(1);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $status = $row->status;
        }
        return $status;
    }

    public function getPaymentStatus($type)
    {
        $status = '';
        $this->db->select('status');
        $this->db->like('payment_type', $type);
        $this->db->from('payment_methods');
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $status = $row->status;
        }
        return $status;
    }

    public function getPaymentModuleStatus()
    {

        $details = array();
        $details['gateway_type'] = $this->getPaymentStatus('Payment Gateway');
        $details['epin_type'] = $this->getPaymentStatus('E-pin');
        $details['free_joining_type'] = $this->getPaymentStatus('Free Joining');
        $details['ewallet_type'] = $this->getPaymentStatus('E-wallet');
        $details['bank_transfer'] = $this->getPaymentStatus('Bank Transfer');
        return $details;
    }

    public function insertintoPaymentDetails($payment_details)
    {

        $data = array(
            'type' => $payment_details['payment_method'],
            'user_id' => $payment_details['user_id'],
            'acceptance' => $payment_details['acceptance'],
            'payer_id' => $payment_details['payer_id'],
            'order_id' => $payment_details['token_id'],
            'amount' => $payment_details['amount'],
            'currency' => $payment_details['currency'],
            'status' => $payment_details['status'],
            'card_number' => $payment_details['card_number'],
            'ED' => $payment_details['ED'],
            'card_holder_name' => $payment_details['card_holder_name'],
            'date_of_submission' => $payment_details['submit_date'],
            'pay_id' => $payment_details['pay_id'],
            'error_status' => $payment_details['error_status'],
            'brand' => $payment_details['brand']
        );
        $res = $this->db->insert('payment_registration_details', $data);
        return $res;
    }

    public function getRegisterAmount()
    {
        $amount = 0;
        $this->db->select('reg_amount');
        $this->db->from('configuration');
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $amount = $row->reg_amount;
        }
        return $amount;
    }

    public function getProductName($product_id)
    {
        return $this->product_model->getPrdocutName($product_id);
    }

    // public function generateOrderid($name, $type) {
    //     $order_id = null;
    //     $date = date('Y-m-d H:i:s');
    //     $this->db->set('firstname', $name);
    //     $this->db->set('status', $type);
    //     $this->db->set('date_added', $date);
    //     $res = $this->db->insert('epdq_payment_order');
    //     $order_id = $this->db->insert_id();
    //     return $order_id;
    // }
    public function getWidthCieling()
    {

        $obj_arr = $this->getSettings();
        $width_cieling = $obj_arr["width_ceiling"];
        return $width_cieling;
    }

    public function getSettings()
    {
        $obj_arr = array();
        $this->db->select("*");
        $this->db->from("configuration");
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $obj_arr["id"] = $row['id'];
            $obj_arr["tds"] = $row['tds'];
            $obj_arr["pair_price"] = $row['pair_price'];
            $obj_arr["pair_ceiling"] = $row['pair_ceiling'];
            $obj_arr["service_charge"] = $row['service_charge'];
            $obj_arr["product_point_value"] = $row['product_point_value'];
            $obj_arr["pair_value"] = $row['pair_value'];
            $obj_arr["startDate"] = $row['start_date'];
            $obj_arr["endDate"] = $row['end_date'];
            $obj_arr["sms_status"] = $row['sms_status'];
            $obj_arr["payout_release"] = $row['payout_release'];
            $obj_arr["referal_amount"] = $row['referal_amount'];
            $obj_arr["level_commission_type"] = $row['level_commission_type'];
            $obj_arr["pair_commission_type"] = $row['pair_commission_type'];
            $obj_arr["depth_ceiling"] = $row['depth_ceiling'];
            $obj_arr["width_ceiling"] = $row['width_ceiling'];
        }


        return $obj_arr;
    }

    public function getPlacementBoard($sponsor_id)
    {
        $user["0"] = $sponsor_id;
        $sponser_arr = $this->checkPosition($user);
        return $sponser_arr;
    }


    public function checkPosition($downlineuser)
    {

        $p = 0;
        $child_arr = "";
        for ($i = 0; $i < count($downlineuser); $i++) {
            $placement_id = $downlineuser["$i"];
            $this->db->select("id");
            $this->db->select("position");
            $this->db->from("ft_individual");
            $this->db->where('father_id', $placement_id);
            $res = $this->db->get();
            $row_count = $res->num_rows();
            if ($row_count > 0) {
                foreach ($res->result_array() as $row) {
                    $width_ceiling = $this->getWidthCieling();
                    if ($row_count < $width_ceiling) {
                        $placement['id'] = $placement_id;
                        $placement['position'] = $row_count + 1;
                        return $placement;
                    } else {
                        $child_arr[$p] = $row["id"];
                        $p++;
                    }
                }
            } else {
                $placement['id'] = $placement_id;
                $placement['position'] = 1;
                return $placement;
            }
        }

        if (count($child_arr) > 0) {
            $position = $this->checkPosition($child_arr);
            return $position;
        }
    }

    public function getProdAndJoiningDetails($user_id)
    {

        $details = array();
        $this->db->select('*');
        $this->db->where('id', $user_id);
        $query = $this->db->get('ft_individual');

        foreach ($query->result() as $row) {

            $details['product_id'] = $row->product_id;
            $details['date_of_joining'] = date('Y-m-d', strtotime($row->date_of_joining));
        }

        return $details;
    }

    public function getTotalPurchase($user_name, $from_date = '', $to_date = '')
    {

        $amount = 0;
        $this->db->select('order_id');
        $this->db->where('sponsor', $user_name);
        if ($from_date != '') {
            $from_date = $from_date . " " . "00:00:00";
            $to_date = $to_date . ' ' . "23:59:59";
            $this->db->where("date_added >=", $from_date);
            $this->db->where("date_added <=", $to_date);
        } else {
            $this->db->like('date_added', date('Y-m'), 'after');
        }

        $query = $this->db->get('order');

        foreach ($query->result() as $row) {

            $order_id = $row->order_id;
            $amount += $this->getAmount($order_id);
        }

        return $amount;
    }

    public function getDownlineDetailsAll($id)
    {
        $arr1[] = $id;
        unset($this->referals);
        $this->referals = array();
        $arr = $this->getReferralCount($arr1, $i = 0);
        return $arr;
    }

    public function getReferralCount($user_id_arr, $i)
    {
        $temp_user_id_arr = array();
        $qr = $this->createQuerys($user_id_arr);
        $res = $this->selectData($qr, "Error On Selecting 157894512345");
        while ($row = mysql_fetch_array($res)) {
            $this->referals[$i] = $row['id'];
            $temp_user_id_arr[] = $row['id'];
            $i++;
        }
        if (count($temp_user_id_arr) > 0) {
            $this->getReferralCount($temp_user_id_arr, $i);
        }
        return $this->referals;
    }

    public function createQuerys($user_id_arr)
    {

        if ($this->table_prefix == "") {
            $_SESSION['table_prefix'] = '57_';
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $ft_individual = $this->table_prefix . "ft_individual";
        $arr_len = count($user_id_arr);
        if ($arr_len == 1)
            $where_qr = " father_id = '$user_id_arr[0]'";
        else {
            $where_qr = " father_id = '$user_id_arr[0]'";
            for ($i = 1; $i < $arr_len; $i++) {
                $user_id = $user_id_arr[$i];
                $where_qr .= " OR father_id = '$user_id'";
            }
        }


        //  if (count($this->referals) == 0)
        $qr = "Select id from $ft_individual where ($where_qr)";


        return $qr;
    }

    public function getClosedPartyId($user_id, $from_date = '', $to_date = '')
    {

        $i = 0;
        $details = array();
        $this->db->select('*');
        $this->db->where('added_by', $user_id);
        if ($from_date != '') {
            $from_date = $from_date . " " . "00:00:00";
            $to_date = $to_date . ' ' . "23:59:59";
            $this->db->where("from_date >=", $from_date);
            $this->db->where("from_date <=", $to_date);
        } else {
            $this->db->like('from_date', date('Y-m'), 'after');
        }

        $this->db->where('status', 'closed');
        $query = $this->db->get('party');

        foreach ($query->result() as $row) {

            $details[$i] = $row->id;
            $i++;
        }
        return $details;
    }

    public function totalProductAmountGetFromParty($party_id, $from_date = '', $to_date = '')
    {

        $amount = 0;
        $this->db->select_sum('total_amount');
        $this->db->where('party_id', $party_id);

        if ($from_date != '') {
            $from_date = $from_date . " " . "00:00:00";
            $to_date = $to_date . ' ' . "23:59:59";
            $this->db->where("date >=", $from_date);
            $this->db->where("date <=", $to_date);
        } else {
            $this->db->like('date', date('Y-m'), 'after');
        }

        $query = $this->db->get('party_guest_orders');

        foreach ($query->result() as $row) {

            $amount = $row->total_amount;
        }

        return $amount;
    }

    public function deductFromBalanceAmount($user_id, $total_amount)
    {
        $this->db->set('balance_amount', 'ROUND(balance_amount -' . $total_amount . ',8)', false);
        $this->db->where('user_id', $user_id);
        $this->db->limit(1);
        $res = $this->db->update('user_balance_amount');
        return $res;
    }

    public function checkAllEpins($pin_details, $product_id, $product_status = "no", $sponsor_id, $return_status = false)
    {
        $is_pin_ok = false;
        $pin_array = array();
        $reg_amount = $this->getRegisterAmount();
        $product_amount = 0;
        if ($product_status == "yes" && $product_id != "") {
            $product_details = $this->product_model->getProductDetails($product_id, 'yes');
            $product_amount = $product_details[0]['product_value'];
        }

        $total_reg_amount = $product_amount + $reg_amount;
        $total_reg_balance = $total_reg_amount;
        $arr_length = count($pin_details);

        if ($arr_length) {
            for ($i = 0; $i <= $arr_length; $i++) {
                if (isset($pin_details[$i])) {
                    $epin_value = ($pin_details[$i]['pin']);
                    $epin_details = $this->checkEPinValidity($epin_value, $sponsor_id);
                    if ($epin_details) {
                        $epin_amount = $epin_details['pin_amount'];
                        $epin_balance_amount = $epin_details['pin_amount'];
                        $epin_used_amount = $epin_details['pin_amount'];
                        if ($total_reg_balance) {
                            if ($epin_amount == $total_reg_balance) {
                                $epin_balance_amount = 0;
                                $total_reg_balance = 0;
                            } else {
                                if ($epin_amount > $total_reg_balance) {
                                    $epin_balance_amount = $epin_amount - $total_reg_balance;
                                    $epin_used_amount = $total_reg_balance;
                                    $total_reg_balance = 0;
                                } else {
                                    $epin_balance_amount = 0;
                                    $reg_balance = $total_reg_balance - $epin_amount;
                                    $total_reg_balance = ($reg_balance >= 0) ? $reg_balance : 0;
                                }
                            }
                            if ($total_reg_balance == 0) {
                                $is_pin_ok = true;
                            }
                        } else {
                            $epin_used_amount = 0;
                        }
                        $pin_array["$i"]['pin'] = $epin_details['pin_numbers'];
                        $pin_array["$i"]['amount'] = round($epin_amount * $this->DEFAULT_CURRENCY_VALUE, $this->PRECISION);
                        $pin_array["$i"]['balance_amount'] = round($epin_balance_amount * $this->DEFAULT_CURRENCY_VALUE, $this->PRECISION);
                        $pin_array["$i"]['reg_balance_amount'] = round($total_reg_balance * $this->DEFAULT_CURRENCY_VALUE, $this->PRECISION);
                        $pin_array["$i"]['epin_used_amount'] = round($epin_used_amount * $this->DEFAULT_CURRENCY_VALUE, $this->PRECISION);
                        $pin_array["$i"]['i'] = $pin_details[$i]['i'];
                    } else {
                        $pin_array["$i"]['pin'] = 'nopin';
                        $pin_array["$i"]['amount'] = '0';
                        $pin_array["$i"]['balance_amount'] = '0';
                        $pin_array["$i"]['reg_balance_amount'] = '0';
                        $pin_array["$i"]['epin_used_amount'] = '0';
                        $pin_array["$i"]['i'] = '1';
                    }
                }
            }
        } else {
            $pin_array["0"]['pin'] = 'nopin';
            $pin_array["0"]['amount'] = '0';
            $pin_array["0"]['balance_amount'] = '0';
            $pin_array["0"]['reg_balance_amount'] = '0';
            $pin_array["0"]['epin_used_amount'] = '0';
        }
        if ($return_status) {
            $pin_array['is_pin_ok'] = $is_pin_ok;
        }
        return $pin_array;
    }

    public function getUserSponsorTreeLevel($user_id, $from_id, $level = 0)
    {
        $this->db->select('sponsor_id');
        $this->db->where('id', $from_id);
        $this->db->limit(1);
        $query = $this->db->get('ft_individual');

        foreach ($query->result() as $row) {
            $father_id = $row->sponsor_id;
            $level++;
            if ($father_id && $father_id < $user_id) {
                $level = $this->getUserSponsorTreeLevel($user_id, $father_id, $level);
            }
        }

        return $level;
    }

    public function getMaxSalesOrderId()
    {
        $max_id = 0;
        $this->db->select_max('id');
        $this->db->from('sales_order');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $max_id = $row->id;
        }
        return $max_id;
    }

    public function getDefaultData()
    {
        $default_user_data = array();
        $default_user_data['user_name_entry'] = "DEMO" . $this->getDynamicUserName();
        $default_user_data['position'] = "L";
        $default_user_data['product_id'] = "1";
        $default_user_data['first_name'] = "Your First Name";
        $default_user_data['last_name'] = "";
        $default_user_data['year'] = 1992;
        $default_user_data['month'] = 5;
        $default_user_data['day'] = 25;
        $default_user_data['date_of_birth'] = $default_user_data['year'] . '-' . $default_user_data['month'] . '-' . $default_user_data['day'];
        $default_user_data['active_tab'] = "free_join_tab";
        $default_user_data['free_joining_status'] = "yes";
        $default_user_data['epin_type'] = "no";
        $default_user_data['ewallet_type'] = "no";
        $default_user_data['gateway_type'] = "no";
        $default_user_data['paypal_status'] = "no";
        $default_user_data['authorize_status'] = "no";
        $default_user_data['email'] = "iossmlm@gmail.com";
        $default_user_data['mobile'] = 9961148729;
        $default_user_data['mobile_code'] = "+91";

        $default_user_data['gender'] = "M";
        $default_user_data['address'] = "Your Address";
        $default_user_data['country'] = "India";
        $default_user_data['country_id'] = 99;
        $default_user_data['state'] = "Kerala";
        $default_user_data['state_id'] = 1490;
        $default_user_data['city'] = "City";
        $default_user_data['land_line'] = "";
        return $default_user_data;
    }

    function getDynamicUserName()
    {
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $username = '';
        for ($i = 0; $i < 3; $i++)
            $username .= $chars[(mt_rand(0, (strlen($chars) - 1)))];
        return $username;
    }

    public function addToCustomerTables($user_id, $regr)
    {
        $dbprefix = $this->db->dbprefix;
        $this->db->set_dbprefix('');

        $first_name = $regr['first_name'];
        $last_name = $regr['last_name'];
        $email = $regr['email'];
        $phone = $regr['mobile'];
        $password = $regr['pswd'];
        $address1 = $regr['address'];
        $address2 = $regr['address_line2'];
        $city = $regr['city'];
        $pin = $regr['pin'];
        $join_date = $regr['joining_date'];
        $ip = $_SERVER['REMOTE_ADDR'];

        $customer = $this->db->dbprefix . "oc_customer";
        $this->db->set('customer_group_id', 1);
        $this->db->set('store_id', 0);
        $this->db->set('language_id', 1);
        $this->db->set('firstname', $first_name);
        $this->db->set('lastname', $last_name);
        $this->db->set('email', $email);
        $this->db->set('telephone', $phone);
        $this->db->set('fax', '');
        $this->db->set('password', $password);
        $this->db->set('salt', '');
        $this->db->set('cart', null);
        $this->db->set('wishlist', null);
        $this->db->set('newsletter', 0);
        $this->db->set('address_id', 1);
        $this->db->set('custom_field', '');
        $this->db->set('ip', $ip);
        $this->db->set('status', 1);
        $this->db->set('approved', 1);
        $this->db->set('safe', 0);
        $this->db->set('token', '');
        $this->db->set('code', '');
        $this->db->set('date_added', $join_date);
        $this->db->insert($customer);

        $customer_id = $this->db->insert_id();

        $address = $this->db->dbprefix . "oc_address";
        $this->db->set('customer_id', $customer_id);
        $this->db->set('firstname', $first_name);
        $this->db->set('lastname', $last_name);
        $this->db->set('company', '');
        $this->db->set('address_1', $address1);
        $this->db->set('address_2', $address2);
        $this->db->set('city', $city);
        $this->db->set('postcode', $pin);
        $this->db->set('country_id', 0);
        $this->db->set('zone_id', 0);
        $this->db->set('custom_field', '');
        $this->db->insert($address);

        $address_id = $this->db->insert_id();

        $this->db->set('address_id', $address_id);
        $this->db->where('customer_id', $customer_id);
        $this->db->update($customer);

        $ft_individual = $this->db->dbprefix . 'ft_individual';
        $this->db->set('oc_customer_ref_id', $customer_id);
        $this->db->where('id', $user_id);
        $this->db->update($ft_individual);

        $this->db->set_dbprefix($dbprefix);
    }

    function getIndividualApiId($user_id)
    {
        $this->db->select("api_key");
        $this->db->from("ft_individual");
        $this->db->where("id", $user_id);
        $query = $this->db->get();
        return $query->row()->api_key;
    }

    function getUserStatus($user_id)
    {
        $status = null;
        $this->db->select("active");
        $this->db->from("ft_individual");
        $this->db->where("id", $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $status = $row->active;
        }
        return $status;
    }

    public function getBitcoinSettings()
    {
        $settings = array();
        $query = $this->db->get('bitcoin_configuration');
        if ($query->num_rows() > 0) {
            $settings = $query->result_array()[0];
        }
        return $settings;
    }

    public function bitcoinHistory($user_id, $data, $purpose = '')
    {
        $date = date('Y-m-d H:i:s');
        $this->db->set('user_id', $user_id);
        $this->db->set('data', json_encode($data));
        $this->db->set('purpose', $purpose);
        $this->db->set('status', 'no');
        $this->db->set('date', $date);
        $result = $this->db->insert('bitcoin_history');
        return $this->db->insert_id();
    }

    public function insertInToBitcoinPaymentProcessDetails($regr_data, $reason, $registrer)
    {
        $this->db->set('registrer', $registrer);
        $this->db->set('user_name', $regr_data['user_name_entry']);
        $this->db->set('regr_data', json_encode($regr_data));
        $this->db->set('reason', $reason);
        $this->db->set('date', date('Y-m-d H:i:s'));
        $result = $this->db->insert('bitcoin_payment_process_details');
        return $result;
    }

    public function insertInToBitcoinPaymentDetails($bitcoin_id, $user_id, $purpose, $amount, $current_bitcoin_value, $paid_amount, $response_amount, $bitcoin_address, $transaction, $return_address, $pending_status = false)
    {
        $key = $this->config->item('encryption_key');
        $bitcoin_address_enc = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $bitcoin_address, MCRYPT_MODE_CBC, md5(md5($key))));
        $pending_id = 'NULL';
        if ($pending_status) {
            $pending_id = $user_id;
            $user_id = 'NULL';
        }
        $this->db->set('bitcoin_history_id', $bitcoin_id);
        $this->db->set('user_id', $user_id, false);
        $this->db->set('purpose', $purpose);
        $this->db->set('amount', $amount);
        $this->db->set('bitcoin_rate', $current_bitcoin_value);
        $this->db->set('bitcoin_amount_to_be_paid', $paid_amount);
        $this->db->set('paid_bitcoin_amount', $response_amount);
        $this->db->set('bitcoin_address', $bitcoin_address_enc);
        $this->db->set('transaction', $transaction);
        $this->db->set('return_address', $return_address);
        $this->db->set('pending_id', $pending_id, false);
        $this->db->set('date', date('Y-m-d H:i:s'));
        $result = $this->db->insert('bitcoin_payment_details');
        return $result;
    }

    public function updateBitcoinHistory($user_id, $id, $status)
    {
        $this->db->set('user_id', $user_id);
        $this->db->set('status', $status);
        $this->db->where('id', $id);
        $result = $this->db->update('bitcoin_history');
        return $result;
    }

    public function getUserRegistrationDetailsForPreview($user_id, $user_name = '')
    {
        if ($user_id) {
            $this->db->select('sponsor_id,user_name,first_name,last_name,address,address_line2,state_name,country_name,mobile,email,reg_date,reg_amount,product_name,product_amount');
            $this->db->where('user_id', $user_id);
            $query = $this->db->get('infinite_user_registration_details');
            $details = $query->row_array();
        } else {
            $this->db->select('data');
            $this->db->where('user_name', $user_name);
            $this->db->where('status', 'pending');
            $query = $this->db->get('pending_registration');
            $details = json_decode($query->row_array()['data'],true);
            $details['user_name'] = $details['user_name_entry'];
            $details['reg_date'] = $details['joining_date'];
        }
        return $details;
    }

    public function getPendingRegistrations($page, $limit)
    {
        $this->load->model('country_state_model');
        $this->load->model('product_model');

        $this->db->select('id,user_name,data,payment_method,date_added');
        $this->db->where('status', 'pending');
        $this->db->limit($limit, $page);
        $query = $this->db->get('pending_registration');
        $details = $query->result_array();
        foreach ($details as $k => $v) {
            if ($v['payment_method'] == 'bank_transfer') {
                $details[$k]['reciept'] = $this->getPaymentReciept($v['user_name']);
            }

            $unserialized_data = json_decode($v['data'], true);

            unset($details[$k]['data']);
            $details[$k] = array_merge($details[$k], $unserialized_data);
            $details[$k]['sponsor_user_name'] = $this->validation_model->IdToUserName($unserialized_data['sponsor_id']);
            $details[$k]['sponsor_full_name'] = $this->validation_model->getUserFullName($unserialized_data['sponsor_id']);
       //   $details[$k]['country_name'] = $this->country_state_model->getCountryNameFromId($unserialized_data['country']);
       //   $details[$k]['state_name'] = $this->country_state_model->getStateNameFromId($unserialized_data['state']);
            $details[$k]['package_name'] = $this->product_model->getPrdocutName($unserialized_data['product_id']);
        }
        return $details;
    }

    public function getPaymentReciept($username)
    {
        $reciept = '';
        $this->db->select('reciept_name');
        $this->db->where('user_name', $username);
        $this->db->where('type', 'register');
        $this->db->limit(1);
        $query = $this->db->get('payment_receipt');
        foreach ($query->result_array() as $row) {
            $reciept = $row['reciept_name'];
        }

        return $reciept;
    }

    public function getPendingRegistrationsCount()
    {
        $this->db->where('status', 'pending');
        return $this->db->count_all_results('pending_registration');
    }

    public function getPendingRegistrationDetailsByUsername($user_name)
    {
        $this->db->select('id,user_name,data,payment_method');
        $this->db->where('status', 'pending');
        $this->db->where('user_name', $user_name);
        $query = $this->db->get('pending_registration');
        $details = $query->row_array();
        $unserialized_data = json_decode($details['data'],true);
        unset($details['data']);
        $details['data'] = $unserialized_data;
        return $details;
    }

    public function updatePendingRegistration($id, $user_id, $user_name, $payment_method, $data)
    {
        $MODULE_STATUS = $this->trackModule();
        $res = true;
        switch ($payment_method) {
            case 'ewallet':
                $this->db->set('user_id', $user_id);
                $this->db->set('pending_id', 'NULL', false);
                $this->db->where('pending_id', $id);
                $this->db->where('user_id IS NULL');
                $res1 = $this->db->update('ewallet_payment_details');
                $this->db->set('from_id', $user_id);
                $this->db->set('pending_id', 'NULL', false);
                $this->db->where('ewallet_type', 'ewallet_payment');
                $this->db->where('from_id IS NULL');
                $this->db->where('pending_id', $id);
                $res2 = $this->db->update('ewallet_history');
                $res = $res1 && $res2;
                break;
            case 'epin':
                $this->db->set('pending_id', 'NULL', false);
                $this->db->set('used_user', $user_id);
                $this->db->where('pending_id', $id);
                $this->db->where('used_user IS NULL');
                $res = $this->db->update('pin_used');
                break;
            case 'authorize.net':
                $this->db->set('user_id', $user_id);
                $this->db->set('pending_id', 'NULL', false);
                $this->db->where('pending_id', $id);
                $this->db->where('user_id IS NULL');
                $res = $this->db->update('authorize_payment_details');
                break;
            case 'paypal':
                break;
            case 'bitcoin':
                $this->db->set('user_id', $user_id);
                $this->db->set('pending_id', 'NULL', false);
                $this->db->where('pending_id', $id);
                $this->db->where('user_id IS NULL');
                $res = $this->db->update('bitcoin_payment_details');
                break;
            case 'free_join':
                break;
            default:
                break;
        }
        $this->db->set('user_id', $user_id);
        $this->db->set('pending_id', 'NULL', false);
        $this->db->where('pending_id', $id);
        $this->db->where('user_id IS NULL');
        $res2 = $this->db->update('sales_order');

        if ($this->MODULE_STATUS['roi_status'] == 'yes' && ($this->MODULE_STATUS['opencart_status'] == "no" || $this->MODULE_STATUS['opencart_status_demo'] == "no")) {
            $this->db->set('user_id', $user_id);
            $this->db->set('pending_status', 0);
            $this->db->where('pending_status', $id);
            $this->db->where('user_id', 0);
            $this->db->update('roi_order');
        }

        if ($this->LOG_USER_TYPE == 'employee') {
            $this->db->set('user_id', $user_id);
            $this->db->set('pending_status', 0);
            $this->db->where('user_id', $id);
            $this->db->where('pending_status', 1);
            $res3 = $this->db->update('employee_activity');

        } else {
            $res3 = true;
        }
        $this->db->set('updated_id', $user_id);
        $this->db->set('status', 'approved');
        $this->db->set('date_modified', date('Y-m-d H:i:s'));
        $this->db->where('id', $id);
        $this->db->where('status', 'pending');
        $res4 = $this->db->update('pending_registration');

        return $res && $res2 && $res3 && $res4;
    }

    
    /*Blockchain Payment Method Starts*/
    public function getBlockchainInfo()
    {
        $query = $this->db->select('*')
            ->from('blockchain_config')
            ->get();
        foreach ($query->result_array() as $row) {
            $row['my_xpub'] = $this->encrypt->decode($row['my_xpub']);
            $row['my_api_key'] = $this->encrypt->decode($row['my_api_key']);
            $row['main_password'] = $this->encrypt->decode($row['main_password']);
            $row['second_password'] = $this->encrypt->decode($row['second_password']);
            return $row;
        }
    }

    public function getUnpaidAddressCount()
    {
        $count = $this->db->select('bitcoin_address')
            ->from('bitcoin_addresses')
            ->where('paid_status', 'no')
            ->count_all_results();
        return $count;
    }

    public function getUnpaidAddress()
    {
        $address = "";
        $query = $this->db->select('bitcoin_address')
            ->from('bitcoin_addresses')
            ->where('paid_status', 'no')
            ->where("TIMESTAMPDIFF(MINUTE,date,NOW()) > 30")
            ->order_by('id')
            ->limit(1)
            ->get();
        foreach ($query->result_array() as $row) {
            $address = $row['bitcoin_address'];
        }
        return $address;
    }

    public function getAvailableAddress()
    {
        $address = "";
        $query = $this->db->select('bitcoin_address')
            ->from('bitcoin_addresses')
            ->where('paid_status', 'no')
            ->where('current_status', 'no')
            ->order_by('date', 'desc')
            ->limit(1)
            ->get();
        foreach ($query->result_array() as $row) {
            $address = $row['bitcoin_address'];
        }
        return $address;
    }

    public function keepBitcoinAddress($address)
    {
        return $this->db->set('bitcoin_address', $address)
            ->set('date', date('Y-m-d H:i:s'))
            ->insert('bitcoin_addresses');
    }
    public function insertPaymentDetails($invoice_id, $address, $secret, $total_amount, $price_in_btc, $date, $regr, $used_for = "")
    {

        $this->db->set('invoice_id', $invoice_id)
            ->set('payment_address', $address)
            ->set('product_id', $regr['product_id'])
            ->set('secret', $secret)
            ->set('amount_to_pay', $total_amount)
            ->set('total_btc', $price_in_btc)
            ->set('date_added', $date)
            ->set('post_data', json_encode($regr))
            ->set('used_for', $used_for)
            ->insert('blockchain_history');

        return $this->db->insert_id();
    }

    public function updateCallbackError($invoice_id, $error)
    {
        $this->db->set('call_back_error', $error)
            ->where('invoice_id', $invoice_id)
            ->update('blockchain_history');
    }
    public function getTransaction($invoice_id, $transaction_hash)
    {
        $count = $this->db->select('*')
            ->from('blockchain_history')
            ->where('invoice_id', $invoice_id)
            ->where('transaction_hash', $transaction_hash)
            ->count_all_results();
        return $count;
    }

    public function updateTransaction($invoice_id, $transaction_hash, $confirmations)
    {
        $this->db->set('confirmations', $confirmations)
            ->where('invoice_id', $invoice_id)
            ->where('transaction_hash', $transaction_hash)
            ->update('blockchain_history');
    }

    public function addTransaction($invoice_id, $transaction_hash, $value, $confirmations, $response)
    {
        $this->db->set('confirmations', $confirmations)
            ->set('value', $value)
            ->set('transaction_hash', $transaction_hash)
            ->set('json_response', $response)
            ->where('invoice_id', $invoice_id)
            ->update('blockchain_history');
    }

    public function keepRowAddressReponse($address, $invoice_id, $response, $used_for)
    {
        $this->db->set('address', $address)
            ->set('invoice_id', $invoice_id)
            ->set('txn_hash', $response['hash160'])
            ->set('response', json_encode($response))
            ->set('date', date("Y-m-d H:i:s"))
            ->set('used_for', $used_for)
            ->insert('rawaddr_response');
    }

    public function updateBitcoinAddress($address, $status = "yes")
    {
        $this->db->set('paid_status', $status)
            ->where('bitcoin_address', $address)
            ->update('bitcoin_addresses');
    }

    public function getPaymentInfo($invoice_id)
    {
        $query = $this->db->select('*')
            ->from('blockchain_history')
            ->where('invoice_id', $invoice_id)
            ->get();
        foreach ($query->result_array() as $row) {
            return $row;
        }
    }
    /*Blockchain Payment Method Ends*/
 
    
    /*Bitgo Payment Method Starts*/
    public function getBitgoStatus()
    {
        $query = $this->db->select('mode')->where('gateway_name', 'bitgo')->get('payment_gateway_config');
        foreach ($query->result() as $row) {
            return $row->mode;
        }
    }

    public function getBitgoConfiguration($mode)
    {
        $query = $this->db->select()->where('mode', $mode)->get('bitgo_configuration')->result_array();

        return $query;
    }

    public function insertIntoBitGoPaymentHistory($user_id, $regr, $p_id, $send_amount, $pay_address, $address_result, $wallet_id, $type = 'backoffice_registration')
    {
        $data = array(
            'user_id' => $user_id,
            'regr' => $regr,
            'product_id' => $p_id,
            'send_amount' => $send_amount,
            'pay_address' => $pay_address,
            'address_result' => $address_result,
            'date' => date('Y-m-d H:i:s'),
            'type' => $type,
            'wallet_id' => $wallet_id
        );
        $this->db->insert('bitgo_payment_history', $data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    public function upateRecievedResult($h_id, $result_arry, $recieved_amount, $bitcoin_payment)
    {
        $this->db->set('recieved_result', $result_arry);
        $this->db->set('recieved_amount', $recieved_amount);
        $this->db->set('bitcoin_payment', $bitcoin_payment);
        $this->db->where('id', $h_id);
        $this->db->update('bitgo_payment_history');
    }

    public function upateBitGoStatus($h_id, $status)
    {
        $this->db->set('status', $status);
        $this->db->where('id', $h_id);
        $this->db->update('bitgo_payment_history');
    }
    /*Bitgo Payment Method Ends*/

//    Bank Transfer Payment Method

    public function addReciept($user_name, $doc_file_name)
    {
        $date = date('Y-m-d H:i:s');
        $query = $this->db->select('*')->where('user_name', $user_name)->get('payment_receipt');

        $row_count = $query->num_rows();
        if ($row_count > 0) {
            $this->db->set('uploaded_date', $date);
            $this->db->set('reciept_name', $doc_file_name);
            $this->db->where('user_name', $user_name);
            $result = $this->db->update('payment_receipt');
        } else {
            $this->db->set('user_name', $user_name);
            $this->db->set('uploaded_date', $date);
            $this->db->set('reciept_name', $doc_file_name);
            $result = $this->db->insert('payment_receipt');
        }
        return $result;
    }

    public function isSponsornameExist($user_name)
    {
        $sponsorname = '';
        $user_id = $this->validation_model->userNameToID($user_name);
        if ($user_id != '') {
            $sponsorname = $this->register_model->getReferralName($user_id);
            $sponsorname = trim($sponsorname);
        }
        return $sponsorname;
    }
    public function updateAddressDate($address)
    {
        return $this->db->set('date', date('Y-m-d H:i:s'))
            ->where('bitcoin_address', $address)
            ->update('bitcoin_addresses');
    }
    
    public function insertIntoPayeerOrderHistory($payment_details) {
        $this->db->set('user_id', $payment_details['user_id']);
        $this->db->set('purpose', $payment_details['purpose']);
        $this->db->set('amount', $payment_details['amount']);
        $this->db->set('product_id', $payment_details['product_id']);
        $this->db->set('status', $payment_details['status']);
        $this->db->set('currency', $payment_details['currency']);
        $this->db->set('invoice_number', $payment_details['invoice_number']);
        $this->db->set('date', $payment_details['date']);
        $res = $this->db->insert('payeer_order_history');
        return $res;
    }

    public function getContactInfoFields()
    { 
        $query = $this->db->select('*')
                      ->from('signup_fields')
                      ->where('status', 'yes')
                      ->order_by('sort_order')
                      ->get();
        return $query->result_array();
    }

    public function getRequiredStatus($field_name)
    { 
        $query = $this->db->select('required')
                      ->from('signup_fields')
                      ->where('status', 'yes')
                      ->where('field_name', $field_name)
                      ->get();
        return $query->result_array()[0]['required'];
    }

    public function getSignUpAllFieldStatus()
    {

        $details = array();
        $details['last_name'] = $this->getSignUpFieldStatus('last_name');
        $details['date_of_birth'] = $this->getSignUpFieldStatus('date_of_birth');
        $details['gender'] = $this->getSignUpFieldStatus('gender');
        $details['adress_line1'] = $this->getSignUpFieldStatus('adress_line1');
        $details['adress_line2'] = $this->getSignUpFieldStatus('adress_line2');
        $details['country'] = $this->getSignUpFieldStatus('country');
        $details['state'] = $this->getSignUpFieldStatus('state');
        $details['city'] = $this->getSignUpFieldStatus('city');
        $details['pin'] = $this->getSignUpFieldStatus('pin');
        $details['land_line'] = $this->getSignUpFieldStatus('land_line');
        return $details;
    }

    public function getSignUpFieldStatus($type)
    {
        $status = '';
        $this->db->select('status');
        $this->db->where('field_name', $type);
        $this->db->from('signup_fields');
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $status = $row->status;
        }
        return $status;
    }

}
