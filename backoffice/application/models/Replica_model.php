<?php

class replica_model extends inf_model {

    public function __construct() {
        parent::__construct();
        $this->load->model('validation_model');
        $this->load->model('product_model');
        $this->load->model('configuration_model');
    }

    public function selectBanner($prefix) {

        $det = array();

        $this->db->select('*');
        $this->db->from('replica_banners');
	$this->db->where("CASE WHEN subject ='top_banner' THEN user_id = $prefix ELSE subject !='' END");

        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $det[$i]['id'] = $row['id'];

            $det[$i]['content'] = $row['content'];
            $det[$i]['user_id'] = $row['user_id'];
            $det[$i]['subject'] = $row['subject'];
           $i++;
        }

        return $det;
    }

    public function insertDetails($owner_id, $name, $email, $address, $phone, $describe) {
        $this->db->set('contact_name', $name);
        $this->db->set('contact_email', $email);
        $this->db->set('contact_address', $address);
        $this->db->set('contact_phone', $phone);
        $this->db->set('contact_info', $describe);
        $this->db->set('owner_id', $owner_id);
        $this->db->set('mailadiddate', date("Y-m-d H:i:s"));
        $this->db->set('read_msg', 'no');
        $this->db->set('status', 'yes');
        $result = $this->db->insert('contacts');
        return $result;
    }

    function getPlacementUnilevel($placement_id) {
        $placement_array = [];
        $this->db->where('father_id', $placement_id);
        $count = $this->db->count_all_results('ft_individual');
        $position = $count + 1;
        $placement_array['id'] = $placement_id;
        $placement_array['position'] = $position;
        return $placement_array;
    }

    public function checkLeg($sponserleg, $sponser_user_name) {
        $binary_leg = $this->configuration_model->getSignupBinaryLeg();
        if ($binary_leg != 'any' && $binary_leg != $sponserleg) {
            return FALSE;
        }
        $sponserleg = ($sponserleg);
        $sponser_user_name = ($sponser_user_name);
        $sponserid = $this->validation_model->userNameToID($sponser_user_name);

        return $this->validation_model->isLegAvailable($sponserid, $sponserleg);
    }

    public function getProduct($product_id) {
        $product = array();
        $this->db->select('*');
        $this->db->from('package');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $product = $row;
        }
        return $product;
    }

    public function checkAllEpins($pin_details, $product_id, $product_status = "no",$sponsor_id = '' , $return_status = false) {
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
                        $pin_array["$i"]['amount'] = $epin_amount;
                        $pin_array["$i"]['balance_amount'] = $epin_balance_amount;
                        $pin_array["$i"]['reg_balance_amount'] = $total_reg_balance;
                        $pin_array["$i"]['epin_used_amount'] = $epin_used_amount;
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

    public function checkEPinValidity($epin, $sponsor_id ='') {

        $epin_arr = array();
        if (!empty($this->session->userdata('replica_user'))) {
            $replica_user = $this->session->userdata('replica_user');
            $user_id = $replica_user['user_id'];
            //$sponsor_user_name = $this->USER_DATA['user_name'];
        }
        //$admin_userid = $this->validation_model->getAdminId();
        $usertype = $this->validation_model->getUserType($user_id);

        $date = date('Y-m-d');
        $this->db->select('pin_numbers,pin_balance_amount');
        $this->db->from('pin_numbers');
        //$this->db->where('pin_numbers', $epin);
        $this->db->where("pin_numbers LIKE BINARY '$epin'", NULL, true);
        $this->db->where('pin_amount >', 0);
        $this->db->where('status', 'yes');
        $this->db->where('pin_expiry_date >=', $date);
        //$whr='(allocated_user_id='.$sponsor_id.' or allocated_user_id="NA" )';
        if($usertype == 'admin'){
           $whr='(allocated_user_id='.$user_id.' or allocated_user_id='.$sponsor_id.' or allocated_user_id IS NULL)';
        }else{
           $whr='(allocated_user_id='.$user_id.' or allocated_user_id='.$sponsor_id.')';
        }
        $this->db->where($whr);
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $epin_arr['pin_numbers'] = $row['pin_numbers'];
            $epin_arr['pin_amount'] = $row['pin_balance_amount'];
        }
        return $epin_arr;
    }

    public function getRegisterAmount() {
        $amount = 0;
        $this->db->select('reg_amount');
        $this->db->from('configuration');
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $amount = $row->reg_amount;
        }
        return $amount;
    }

    public function getProductAmount($product_id) {
        $product_amount = $this->product_model->getProductByProductid($product_id);
        return $product_amount;
    }

//Edited From here
    function getDefaultRepliRegDetails() {
        $default_user_data = array();
        $default_user_data['user_name_entry'] = "REPLI" . $this->getDynamicUserName();
        $default_user_data['first_name'] = "First Name";
        $default_user_data['last_name'] = "";
        $default_user_data['year'] = 1992;
        $default_user_data['month'] = 5;
        $default_user_data['day'] = 25;
        $default_user_data['email'] = "email@gmail.com";
        $default_user_data['mobile'] = 9961148729;
        $default_user_data['active_tab'] = "free_join";
        $default_user_data['mobile_code'] = "+91";
        $default_user_data['date_of_birth'] = $default_user_data['year'] . '-' . $default_user_data['month'] . '-' . $default_user_data['day'];
        return $default_user_data;
    }

    function getDynamicUserName() {
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        // Create username
        $username = '';
        for ($i = 0; $i < 4; $i++)
            $username .= $chars[(mt_rand(0, (strlen($chars) - 1)))];
        return $username;
    }

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

    public function get_leg_type($user_id) {
        $binary_leg = '';
        $this->db->select('binary_leg');
        $this->db->where("id =", $user_id);
        $this->db->limit(1);
        $query = $this->db->get('ft_individual');
        foreach ($query->result_array() AS $rows) {
                $binary_leg = $rows['binary_leg'];
        }
       return $binary_leg;

    }

    public function getLegLeftRightCount($user_id) {
        $total_left_count = $total_right_count = $total_left_carry = $total_right_carry = 0;
        $this->db->select('total_left_count,total_right_count');
        $this->db->select('total_left_carry,total_right_carry');
        $this->db->from('leg_details');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $total_left_count = $row->total_left_count;
            $total_right_count = $row->total_right_count;
            $total_left_carry = $row->total_left_carry;
            $total_right_carry = $row->total_right_carry;
        }
        $arr = array();
        $arr['total_left_count'] = $total_left_count;
        $arr['total_left_carry'] = $total_left_carry;
        $arr['total_right_count'] = $total_right_count;
        $arr['total_right_carry'] = $total_right_carry;
        return $arr;
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

   // validation
    public function insertUserActivity($login_id, $activity, $done_by = "admin", $done_by_type = '') {
        $date = date("Y-m-d H:i:s");
        $ip_adress = $_SERVER['REMOTE_ADDR'];
        $this->db->set('user_id', $login_id);
        $this->db->set('activity', $activity);
        $this->db->set('done_by', $done_by);
        $this->db->set('done_by_type', $done_by_type);
        $this->db->set('ip', $ip_adress);
        $this->db->set('date', $date);
        $result = $this->db->insert('activity_history');


        return $result;
    }

    public function getSignupBinaryLeg($user_id) {
        $this->db->select('binary_leg');
        $query = $this->db->get('signup_settings');
        $res = $query->row_array()['binary_leg'];
        if ($res == 'left') {
            $res = 'L';
        } elseif ($res == 'right') {
            $res = 'R';
        } else {
            $this->db->select('binary_leg');
            $this->db->where('id', $user_id);
            $query = $this->db->get('ft_individual');
            $res = $query->row_array()['binary_leg'];
            if ($res == 'left') {
                $res = 'L';
            } elseif ($res == 'right') {
                $res = 'R';
            } else {
                $res = 'any';
            }
        }
        return $res;
    }

    public function getAllProducts($status = '', $limit = '200', $page = '') {

        $product_details = array();
        $i = 0;
        $this->db->select('*');
        $this->db->from('package');
        $this->db->where('type_of_package', 'registration');
        if ($status != '') {
            $this->db->where('active', $status);
        }
        $this->db->limit($limit, $page);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $product_details[] = $row;
        }
        return $product_details;
    }

    public function getProductByProductid($product_id) {
        $amount = 0;

        $MODULE_STATUS = $this->trackModule();
        if ($MODULE_STATUS['opencart_status'] != "yes" || $MODULE_STATUS['opencart_status_demo'] != "yes") {
            $this->db->select('product_value');
            $this->db->from('package');
            $this->db->where('product_id', $product_id);
            $query = $this->db->get();
            foreach ($query->result_array() as $row) {
                $amount = $row['product_value'];
            }
        } else {
            $this->db->select('price AS product_value');
            $this->db->where('product_id', $product_id);
            $query = $this->db->get('oc_product');
            foreach ($query->result_array() as $row) {
                $amount = $row['product_value'];
            }
        }
        return $amount;
    }

}
