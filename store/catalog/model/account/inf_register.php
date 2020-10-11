<?php

class ModelAccountInfRegister extends Model {

    public function addToBackOffice($customer_details) {
        $customer_details['table_prefix'] = MLM_DB_PREFIX;
        $customer_details['log_user_type'] = $this->customer->getUserType();

        $url = OFFICE_PATH . 'oc_register/opencart_user_register';

        $this->runMLMCURL($url, $customer_details, 'oc_register');
    }

    public function addTemporaryToBackOffice($customer_details) {

        $this->db->query("INSERT INTO " . DB_PREFIX . "temp_registration SET   reg_data  = '" . $this->db->escape(serialize($customer_details)) . "', date = NOW(), status ='pending',user_name = '".$this->db->escape($customer_details['reg_data']['user_name_entry'])."', order_id=" . $customer_details['reg_data']['order_id'] . "");

        $reg_id = $this->db->getLastId();
        return $reg_id;
    }

    public function runMLMCURL($url, $curl_data, $type = 'register') {

        $curl_data["from_store"] = true;
        $curl_data["inf_token"] = "f6f7369316c4928fdceaaed397356f5b";

        $curl_id = $this->insertCURLHistory($curl_data, $url, $type);

        $field_string = http_build_query($curl_data);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $field_string);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $curl_result = curl_exec($curl);

        $this->updateCURLHistory($curl_id, $curl_result);

        curl_close($curl);
    }

    public function insertCURLHistory($curl_data, $url, $curl_type = 'register') {
        $this->db->query("INSERT INTO " . MLM_DB_PREFIX . "mlm_curl_history SET curl_url  = '" . $url . "', curl_type = '" . $curl_type . "',  curl_data  = '" . $this->db->escape(serialize($curl_data)) . "', curl_date = NOW()");

        $curl_id = $this->db->getLastId();
        return $curl_id;
    }

    public function updateCURLHistory($curl_id, $curl_result) {
        $this->db->query("UPDATE " . MLM_DB_PREFIX . "mlm_curl_history SET curl_result ='" . $this->db->escape(serialize($curl_result)) . "' , curl_date = NOW() WHERE curl_id ='" . $curl_id . "'");
    }

    public function validateUsername($username) {
        $status = false;
        $query = $this->db->query("SELECT id FROM " . MLM_DB_PREFIX . "ft_individual WHERE user_name = '$username'");
        $query1 = $this->db->query("SELECT id FROM " . MLM_DB_PREFIX . "oc_temp_registration WHERE user_name = '$username' AND status = 'pending'");

        if ($query->num_rows) {
            $status = true;
        }
        if ($query1->num_rows) {
            $status = true;
        }
        return $status;
    }

    public function officeLogin($username) {

        $customer_login_query = $this->db->query("SELECT * FROM " . MLM_DB_PREFIX . "ft_individual WHERE user_name = '" . $username . "'");

        if ($customer_login_query->num_rows) {
            $this->session->data['inf_logged_in']["user_id"] = $customer_login_query->row["id"];
            $this->session->data['inf_logged_in']["user_name"] = $customer_login_query->row["user_name"];
            $this->session->data['inf_logged_in']["user_type"] = $customer_login_query->row["user_type"];
            $this->session->data['inf_logged_in']["table_prefix"] = MLM_DB_PREFIX;
            $this->session->data['inf_logged_in']["is_logged_in"] = true;
            $this->session->data["mlm_plan"] = MLM_PLAN;
        }
    }

    public function validatePassword($username, $password) {
        $query = $this->db->query("SELECT * FROM `" . MLM_DB_PREFIX . "ft_individual` where user_name ='" . $this->db->escape($username) . "' and password='" . $this->db->escape(md5($password)) . "'");
        if ($query->row) {
            return true;
        } else {
            return false;
        }
    }

    public function checkTransactionPass($username, $tranpass) {
        $user_id = $this->userNameToId($username);
        $query = $this->db->query("SELECT `tran_password` FROM `" . MLM_DB_PREFIX . "tran_password` WHERE user_id = '$user_id' AND tran_password='$tranpass'");
        if ($query->row) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getOrderProducts($order_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int) $order_id . "'");

        return $query->rows;
    }

    public function validateEpin($epin) {
        $query = $this->db->query("SELECT pin_numbers FROM `" . MLM_DB_PREFIX . "pin_numbers` WHERE pin_numbers = '" . $this->db->escape(utf8_strtolower($epin)) . "' and status = 'yes' ");

        return count($query->row);
    }

    public function getEvoucherAmount($evoucher) {

        $query = $this->db->query("SELECT pin_balance_amount FROM `" . MLM_DB_PREFIX . "pin_numbers` WHERE pin_numbers = '" . $this->db->escape(utf8_strtolower($evoucher)) . "' and status = 'yes' ");
        if ($query->num_rows) {
            return array(
                'epin_amount' => $query->row['pin_balance_amount'],
                );
        } else {
            return false;
        }
    }

    public function getRegistrationPackages() {
        $product_query = $this->db->query("SELECT * FROM " . MLM_DB_PREFIX . "package WHERE active='yes'");
        return $product_query->rows;
    }

    public function calculateUserRepurchaseCommissions($order_id, $customer_id, $user_id) {
        if ($customer_id && $order_id && $user_id) {
            $ordered_products_data = $this->getOrderProducts($order_id);
            if (count($ordered_products_data)) {
                $order_details['customer_id'] = $customer_id;
                $order_details['user_id'] = $user_id;
                $order_details['order_data'] = $ordered_products_data;
                $order_details['order_id'] = $order_id;
                $order_details['table_prefix'] = MLM_DB_PREFIX;

                $url = OFFICE_PATH . 'oc_register/opencart_repurchase_commission';

                $this->runMLMCURL($url, $order_details, 'oc_repurchase');
            }
        }
    }

    public function getTaxes($product_data) {
        $tax_data = array();
        if ($product_data['tax_class_id']) {
            $tax_rates = $this->tax->getRates($product_data['price'], $product_data['tax_class_id']);
            foreach ($tax_rates as $tax_rate) {
                if (!isset($tax_data[$tax_rate['tax_rate_id']])) {
                    $tax_data[$tax_rate['tax_rate_id']] = ($tax_rate['amount'] * $product_data['quantity']);
                } else {
                    $tax_data[$tax_rate['tax_rate_id']] += ($tax_rate['amount'] * $product_data['quantity']);
                }
            }
        }
        return $tax_data;
    }

    public function getMlmConfiguration($key) {
        $query = $this->db->query("SELECT `{$key}` FROM " . MLM_DB_PREFIX . "configuration LIMIT 1");
        if ($query->num_rows) {
            return $query->row["{$key}"];
        }
    }

    public function getAdminUsername($admin_id) {
        $query = $this->db->query("SELECT `user_name` FROM " . MLM_DB_PREFIX . "ft_individual WHERE `id` = " . $admin_id);
        if ($query->num_rows) {
            return $query->row["user_name"];
        }
    }

    public function isRegistrationAllowed() {
        $user_type = $this->customer->getUserType();
        if ($user_type == 'admin') {
            return TRUE;
        }
        $query = $this->db->query("SELECT `registration_allowed` FROM " . MLM_DB_PREFIX . "signup_settings");
        if ($query->num_rows) {
            $res = $query->row["registration_allowed"];
            return ($res == 'yes');
        }
    }

    public function getSignupBinaryLeg() {
        $query = $this->db->query("SELECT `binary_leg` FROM " . MLM_DB_PREFIX . "signup_settings");
        if ($query->num_rows) {
            $res = $query->row["binary_leg"];
            if ($res == 'left') {
                $res = 'L';
            }
            elseif ($res == 'right') {
                $res = 'R';
            }
            else {
                $res = 'any';
            }
            return $res;
        }
    }

    public function getAgeLimitSetting() {
        $query = $this->db->query("SELECT `age_limit` FROM " . MLM_DB_PREFIX . "signup_settings");
        if ($query->num_rows) {
            $res = $query->row["age_limit"];
            return $res;
        }
    }

    public function isLoginBlocked() {
        $site_maintenance_status = $this->customer->getSiteMaintenanceStatus();
        if ($site_maintenance_status == 'no') {
            return FALSE;
        }
        $query = $this->db->query("SELECT `block_login` FROM " . MLM_DB_PREFIX . "site_maintenance");
        if ($query->num_rows) {
            $res = $query->row["block_login"];
            return $res;
        }
    }

    public function isRegistrationBlocked() {
        $site_maintenance_status = $this->customer->getSiteMaintenanceStatus();
        if ($site_maintenance_status == 'no') {
            return FALSE;
        }
        $query = $this->db->query("SELECT `block_register` FROM " . MLM_DB_PREFIX . "site_maintenance");
        if ($query->num_rows) {
            $res = $query->row["block_register"];
            return $res;
        }
    }

    public function isRepurchaseBlocked() {
        $site_maintenance_status = $this->customer->getSiteMaintenanceStatus();
        if ($site_maintenance_status == 'no') {
            return FALSE;
        }
        $query = $this->db->query("SELECT `block_ecommerce` FROM " . MLM_DB_PREFIX . "site_maintenance");
        if ($query->num_rows) {
            $res = $query->row["block_ecommerce"];
            return $res;
        }
    }

    public function isSponsorRequired() {
        $user_type = $this->customer->getUserType();
        if ($user_type == 'admin' || $user_type == 'employee') {
            return TRUE;
        }
        $query = $this->db->query("SELECT `sponsor_required` FROM " . MLM_DB_PREFIX . "signup_settings");
        if ($query->num_rows) {
            $res = $query->row["sponsor_required"];
            return ($res == 'yes');
        }
    }

    public function getUserTypeByUsername($user_name) {
        $query = $this->db->query("SELECT `user_type` FROM " . MLM_DB_PREFIX . "ft_individual WHERE `user_name` = '" . $user_name . "'");
        if ($query->num_rows) {
            $res = $query->row["user_type"];
            return $res;
        }
    }

    public function getUserWiseSignupBinaryLeg($user_id)
    {
        $query = $this->db->query("SELECT `binary_leg` FROM " . MLM_DB_PREFIX . "ft_individual WHERE `id` = {$user_id}");
        if ($query->num_rows) {
            $res = $query->row["binary_leg"];
            if ($res == 'left') {
                $res = 'L';
            }
            elseif ($res == 'right') {
                $res = 'R';
            }
            elseif ($res == 'weak_leg') {
                $query1 = $this->db->query("SELECT total_left_count AS `left`,total_right_count AS `right` FROM " . MLM_DB_PREFIX . "leg_details WHERE `id` = {$user_id}");
                if ($query->num_rows) {
                    $leg_details = $query1->row;
                    if ($leg_details['left'] == $leg_details['right']) {
                        $res = 'any';
                    }
                    elseif ($leg_details['left'] < $leg_details['right']) {
                        $res = 'L';
                    }
                    elseif ($leg_details['left'] > $leg_details['right']) {
                        $res = 'R';
                    }
                }
            }
            else {
                $res = 'any';
            }
        }
        return $res;
    }

    public function getUserLeftRightNode($user_id, $tree_type = 'tree') {
        if ($tree_type == 'tree') {
            $query = $this->db->query("SELECT left_father AS `left`,right_father AS `right` FROM " . MLM_DB_PREFIX . "tree_parser WHERE `ft_id` = {$user_id}");
        }
        elseif ($tree_type == 'sponsor_tree') {
            $query = $this->db->query("SELECT left_sponsor AS `left`,right_sponsor AS `right` FROM " . MLM_DB_PREFIX . "tree_parser WHERE `ft_id` = {$user_id}");
        }
        if ($query->num_rows) {
            return $query->row;
        }
    }

    public function getUserPositionFromParent($user_id, $parent_id)
    {

        $user_node = $this->getUserLeftRightNode($user_id, 'tree');

        $query1 = $this->db->query("SELECT tp.left_father AS `left`,tp.right_father AS `right` FROM " . MLM_DB_PREFIX . "ft_individual ft LEFT JOIN " . MLM_DB_PREFIX . "tree_parser tp ON (ft.id = tp.ft_id) WHERE ft.father_id = {$parent_id}");
        if ($query1->num_rows) {
            $parent_child_node = $query1->rows;
        }

        $condition = '';
        if ($parent_child_node) {
            $condition .= "AND (";
            foreach ($parent_child_node as $k => $v) {
                if ($k === 1) {
                    $condition .= " OR ";
                }
                $condition .= "(tp.left_father = {$v['left']} AND tp.right_father = {$v['right']})";
            }
            $condition .= ")";
        }
        $query2 = $this->db->query("SELECT position FROM " . MLM_DB_PREFIX . "ft_individual ft LEFT JOIN " . MLM_DB_PREFIX . "tree_parser tp ON (ft.id = tp.ft_id) WHERE tp.left_father <= {$user_node['left']} AND tp.right_father >= {$user_node['right']} {$condition}");

        if ($query2->num_rows) {
            return $query2->row['position'];
        }
    }

    public function getAllowedBinaryLeg($user_id, $log_user_type, $log_user_id)
    {
        if (!$log_user_type) {
            return 'any';
        }
        $admin_id = $this->customer->getAdminUserId();
        if ($log_user_type == 'employee') {
            $log_user_id = $admin_id;
        }
        $binary_leg = $this->getSignupBinaryLeg();
        if ($binary_leg == 'any') {
            if ($log_user_type == 'admin' || $log_user_type == 'employee') {
                return 'any';
            }
            else {
                $user_binary_leg = $this->getUserWiseSignupBinaryLeg($log_user_id);
                if ($user_binary_leg == 'any') {
                    return 'any';
                }
                else {
                    $sponsor_required = $this->isSponsorRequired();
                    if ($sponsor_required) {
                        $parent_id = $log_user_id;
                    }
                    else {
                        $parent_id = $admin_id;
                    }
                    if ($parent_id == $user_id) {
                        return $user_binary_leg;
                    }
                    else {
                        $position_from_parent = $this->getUserPositionFromParent($user_id, $parent_id);
                        if ($position_from_parent == $user_binary_leg) {
                            return 'any';
                        }
                        else {
                            return '';
                        }
                    }
                }
            }
        }
        else {
            $parent_id = $admin_id;
            if ($parent_id == $user_id) {
                return $binary_leg;
            }
            else {
                $position_from_parent = $this->getUserPositionFromParent($user_id, $parent_id);
                if ($position_from_parent == $binary_leg) {
                    return 'any';
                }
                else {
                    return '';
                }
            }
        }
    }

    public function CheckPendingStatus($method) {
        $query = $this->db->query("SELECT `status` FROM `" . MLM_DB_PREFIX . "pending_signup_config` WHERE payment_method = '$method'");
        if ($query->num_rows) {
            $res = $query->row["status"];
            return ($res == 1);
        }
    }

    public function getUsername() {
        $query = $this->db->query("SELECT * FROM " . MLM_DB_PREFIX . "username_config");
        if ($query->num_rows) {
            $res = $query->row;
        }
            $u_name = $this->getRandId($res);
            return $u_name;
    }

    public function getRandId($config) {

        $key = "";
        $charset = "0123456789";
        for ($i = 0; $i < $config['length']; $i++){
            $key .= $charset[(mt_rand(0, (strlen($charset) - 1)))];
        }
        if(!$key){
            $this->getRandId($config);
        }
        $randum_id = $key;
        if ($config["prefix_status"] == "yes") {
            $prefix = $config["prefix"];
            $randum_id = $prefix . $randum_id;
        }
        $query = $this->db->query("SELECT `id` FROM " . MLM_DB_PREFIX . "ft_individual WHERE `user_name` = '$randum_id'");

        $count= count($query->row);
        if ($count){
            $this->getRandId($config);
        }
        else{
            return $randum_id;
        }

    }

    public function updateCustomerId($user_id, $customer_id) {
        $this->db->query("UPDATE " . MLM_DB_PREFIX . "ft_individual SET oc_customer_ref_id ='" . $customer_id . "' WHERE id ='" . $user_id . "'");
    }

    public function setCustomerData($data) {

        $customer_data = [];
        $customer_data['customer_group_id'] = isset($data['customer_group_id']) ? $data['customer_group_id'] : 0;
        $customer_data['firstname'] = $data['firstname'];
        $customer_data['lastname'] = $data['lastname'];
        $customer_data['email'] = $data['email'];
        $customer_data['telephone'] = $data['telephone'];
        $customer_data['fax'] = $data['fax'];
        $customer_data['custom_field'] = isset($data['custom_field']) ? $data['custom_field']['account'] : '';
        $customer_data['password'] = $data['password'];
        $customer_data['newsletter'] = $data['newsletter'];
        $customer_data['company'] = $data['company'];
        $customer_data['address_1'] = $data['address_1'];
        $customer_data['address_2'] = $data['address_2'];
        $customer_data['city'] = $data['city'];
        $customer_data['postcode'] = $data['postcode'];
        $customer_data['country_id'] = $data['country_id'];
        $customer_data['zone_id'] = $data['zone_id'];
        $customer_data['config_store_id'] = $this->config->get('config_store_id');
        $customer_data['config_language_id'] = $this->config->get('config_language_id');
        $customer_data['salt'] = token(9);
        $customer_data['ip'] = $this->request->server['REMOTE_ADDR'];
        $customer_data['order_id'] = $this->session->data['order_id'];
        $customer_data['cod_order_status_id'] = $this->config->get('cod_order_status_id');;

        return $customer_data;

    }

    public function setRegistrationData($step1_data, $step2_data, $reg_pack, $step4_data, $order_id) {

        $reg_data = [];
        $reg_data['by_using'] = 'opencart';
        $reg_data['reg_from_tree'] = $step1_data["reg_from_tree"];
        $reg_data['placement_user_name'] = $step1_data["placement_user_name"];
        $reg_data['placement_full_name'] = $step1_data["placement_full_name"];
        $reg_data['sponsor_user_name'] = $step1_data['sponsor_user_name'];
        $reg_data['sponsor_full_name'] = $step2_data['sponsor_name'];
        $reg_data['sponsor_id'] = $this->customer->userNameToID($reg_data['sponsor_user_name']);
        $reg_data['position'] = $step1_data['position'];
        $reg_data['first_name'] = $step4_data['firstname'];
        $reg_data['last_name'] = $step4_data['lastname'];
        $reg_data['email'] = $step4_data['email'];
        $reg_data['mobile'] = $step4_data['telephone'];
        $reg_data['land_line'] = $step4_data['telephone'];
        $reg_data['date_of_birth'] = $step4_data['date_of_birth'];
        $reg_data['gender'] = $step4_data['gender'];
        $reg_data['address'] = $step4_data['address_1'];
        $reg_data['address_line2'] = $step4_data['address_2'];
        $reg_data['city'] = $step4_data['city'];
        $reg_data['pin'] = $step4_data['postcode'];

        $this->load->model('localisation/zone');
        $zone_info = $this->model_localisation_zone->getZone($step4_data['zone_id']);
        $reg_data['state'] = $zone_info['zone_id'];
        $reg_data['state_name'] = $zone_info['name'];

        $this->load->model('localisation/country');
        $country_info = $this->model_localisation_country->getCountry($step4_data['country_id']);
        $reg_data['country'] = $country_info['country_id'];
        $reg_data['country_name'] = $country_info['name'];
        $reg_data['user_name_type'] = USERNAME_TYPE;
        if (USERNAME_TYPE == "static") {
            $reg_data['user_name_entry'] = $step4_data['username'];
        } else {
            $reg_data['user_name_entry'] = $this->getUsername();
        }
        $reg_data['pswd'] = $step4_data['password'];
        $reg_data['cpswd'] = $step4_data['confirm'];
        $reg_data['mobile_code'] = '';
        $reg_data['bank_name'] = '';
        $reg_data['bank_branch'] = '';
        $reg_data['bank_acc_no'] = '';
        $reg_data['ifsc'] = '';
        $reg_data['pan_no'] = '';

        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($order_id);
        $reg_data['reg_amount'] = $order_info['total'];
        $reg_data["order_id"] = $order_id;

        $reg_data['product_id'] = $reg_pack;

        return $reg_data;

    }
    
    
     function getUserId($customer_id){
        $user_id = 0;
        $query1 = $this->db->query("SELECT id  FROM " . MLM_DB_PREFIX . "ft_individual WHERE `oc_customer_ref_id` = {$customer_id}");
        if ($query1->num_rows) {
            $user_id   =  $query1->row['id'];
        }
        return $user_id;
    }
    
      public function UpdateConfimed($order_id){
  	$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status = 'complete', confirm_date = NOW() WHERE order_id = '" . (int)$order_id . "'");
  }	

}