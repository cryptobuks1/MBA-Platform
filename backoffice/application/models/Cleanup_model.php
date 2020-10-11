<?php

class cleanup_model extends inf_model {

    public function __construct() {
        parent::__construct();
    }

    public function clean($module_status = array()) {

        $this->db->query("SET FOREIGN_KEY_CHECKS=0;");

        $this->load->model('registersubmit_model');
        $dbprefix = $this->db->dbprefix;
        $ocprefix = $this->db->ocprefix;
        $MODULE_STATUS = $this->trackModule();
        $mlm_plan = $MODULE_STATUS["mlm_plan"];
        $admin_id = $this->validation_model->getAdminId();
        $admin_pass = $this->validation_model->getAdminPassword();
        $user_details = $this->getUserDetails($admin_id);
        $user_name = $this->validation_model->getAdminUsername();
        $current_date = date("Y-m-d H:i:s");

        $this->begin();

        $cleanup_tables = $this->getCleanupTables();

        foreach ($cleanup_tables['common'] as $table) {
            $this->cleanupTable($dbprefix, $table);
        }

        if ($this->db->table_exists('package') && DEMO_STATUS == 'yes') {
            $this->cleanupTable($dbprefix, 'package');

            for ($i=1; $i <= 3; $i++) {
                $package_details = [
                    'product_id' => $i,
                    'product_name' => "Membership Pack {$i}",
                    'type_of_package' => 'registration',
                    'active' => "yes",
                    'date_of_insertion' => date('Y-m-d'),
                    'prod_id' => "pck{$i}",
                    'bv_value' => 50*$i,
                    'pair_value' => 50*$i,
                    'product_value' => 100*$i,
                    'pair_price' => 5*$i,
                    'package_validity' => 4*$i,
                    'referral_commission' => 5*$i,
                    'product_qty' => 1,
                    'prod_img' => 'no',
                    'roi'      =>10*$i,
                    'days'     =>5*$i
                ];
                $this->db->insert('package', $package_details);

                $j = $i + 3;
                $package_details = [
                    'product_id' => $j,
                    'product_name' => "Purchase Pack {$i}",
                    'type_of_package' => 'repurchase',
                    'active' => "yes",
                    'date_of_insertion' => date('Y-m-d'),
                    'prod_id' => "cart{$i}",
                    'bv_value' => 50*$i,
                    'pair_value' => 50*$i,
                    'product_value' => 100*$i,
                    'pair_price' => 5*$i,
                    'package_validity' => 4*$i,
                    'referral_commission' => 5*$i,
                    'product_qty' => 1,
                    'prod_img' => 'no',
                    'roi'      =>10*$i,
                    'days'     =>5*$i,
                    'category_id' => $i
                ];
                $this->db->insert('package', $package_details);
            }
        }

        if ($this->db->table_exists('repurchase_category') && DEMO_STATUS == 'yes') {
            $this->cleanupTable($dbprefix, 'repurchase_category');

            for ($i=1; $i <= 3; $i++) {
                $category_details = [
                    'category_id' => $i,
                    'category_name' => "Repurchase Category {$i}",
                    'image' => 'no',
                    'status' => "yes",
                    'date_added' => date('Y-m-d'),
                ];
                $this->db->insert('repurchase_category', $category_details);
            }
        }

        if ($this->db->table_exists('ft_individual')) {
            $this->setTableAutoIncrement($dbprefix, 'ft_individual', $admin_id);

            $package_id = $this->getMinPackageId($MODULE_STATUS);
            $ft_details = [
                'id' => $admin_id,
                'position' => '',
                'user_type' => "admin",
                'user_name' => $user_name,
                'password' => $admin_pass,
                'active' => 'yes',
                'date_of_joining' => $current_date,
                'product_id' => $package_id ? $package_id : ''
            ];
            $this->db->insert('ft_individual', $ft_details);
        }
        if ($this->db->table_exists('tree_parser')) {

            $tree_details = [
                'ft_id' => $admin_id,
                'left_father' => '1',
                'right_father' => '2',
                'left_sponsor' => '1',
                'right_sponsor' => '2'
            ];
            $this->db->insert('tree_parser', $tree_details);
        }

        if ($this->db->table_exists('user_details')) {
            $user_details['join_date'] = $current_date;
            $this->db->insert('user_details', $user_details);
        }

        if ($this->db->table_exists('leg_amount')) {
            $this->setTableAutoIncrement($dbprefix, 'leg_amount', $admin_id);
        }

        if ($this->db->table_exists('user_balance_amount')) {
            $user_balance_details = [
                'user_id' => $admin_id,
                'balance_amount' => '0',
                'purchase_wallet' => '0'
            ];
            $this->db->insert('user_balance_amount', $user_balance_details);
        }

        if ($this->db->table_exists('tran_password')) {
            $tran_password_details = [
                'user_id' => $admin_id,
                'tran_password' => password_hash('12345678', PASSWORD_DEFAULT)
            ];
            $this->db->insert('tran_password', $tran_password_details);

        }

        if ($mlm_plan == 'Party') {
            foreach ($cleanup_tables['party'] as $table) {
                $this->cleanupTable($dbprefix, $table);
            }
        }
        elseif ($mlm_plan == "Binary") {
            foreach ($cleanup_tables['binary'] as $table) {
                $this->cleanupTable($dbprefix, $table);
            }

            if ($this->db->table_exists('leg_details')) {
                $leg_details = [
                    'id' => $admin_id
                ];
                $this->db->insert('leg_details', $leg_details);
            }
        }
        elseif ($mlm_plan == "Board") {
            foreach ($cleanup_tables['board'] as $table) {
                $this->cleanupTable($dbprefix, $table);
            }

            if ($this->db->table_exists('auto_board_1')) {
                $this->setTableAutoIncrement($dbprefix, 'auto_board_1', $admin_id);

                $auto_board_det = [
                    "user_ref_id" => $admin_id,
                    "user_name" => "STARTER$user_name",
                    "position" => '',
                    "active" => 'yes',
                    "father_id" => '0',
                    "date_of_joining" => $current_date,
                    "user_level" => '0'
                ];
                $this->db->insert('auto_board_1', $auto_board_det);
            }

            if ($this->db->table_exists('auto_board_2')) {
                $this->setTableAutoIncrement($dbprefix, 'auto_board_2', $admin_id);

                $auto_board_det = [
                    "user_ref_id" => $admin_id,
                    "user_name" => "VIP$user_name",
                    "position" => '',
                    "active" => 'yes',
                    "father_id" => '0',
                    "date_of_joining" => $current_date,
                    "user_level" => '0'
                ];
                $this->db->insert('auto_board_2', $auto_board_det);
            }

            if ($this->db->table_exists('board_view')) {
                $board_view_det = [
                    "board_top_id" => $admin_id,
                    "board_table_name" => '1',
                    "board_no" => '1',
                    "board_view_status" => 'yes',
                    "board_split_status" => 'no',
                    "date_of_join" => $current_date
                ];
                $this->db->insert('board_view', $board_view_det);

                $board_view_det = [
                    "board_top_id" => $admin_id,
                    "board_table_name" => '2',
                    "board_no" => '1',
                    "board_view_status" => 'yes',
                    "board_split_status" => 'no',
                    "date_of_join" => $current_date
                ];
                $this->db->insert('board_view', $board_view_det);
            }

            if ($this->db->table_exists('board_user_detail')) {
                $board_user_details = [
                    "board_table_name" => '1',
                    "user_id" => $admin_id,
                    "board_serial_no" => '1',
                    "date_of_join" => $current_date
                ];
                $this->db->insert('board_user_detail', $board_user_details);

                $board_user_details = [
                    "board_table_name" => '2',
                    "user_id" => $admin_id,
                    "board_serial_no" => '1',
                    "date_of_join" => $current_date
                ];
                $this->db->insert('board_user_detail', $board_user_details);
            }
        }
        elseif ($mlm_plan == 'Stair_Step'){
            foreach ($cleanup_tables['stairstep'] as $table) {
                $this->cleanupTable($dbprefix, $table);
            }

            if ($this->db->table_exists('stair_step')) {
                $step_id = $this->validation_model->getStairStepMaxId();
                $this->db->set('step_id', $step_id);
                $this->db->set('breakaway_status', "no");
                $this->db->set('leader_id', 0);
                $this->db->set('user_id', $admin_id);
                $result = $this->db->insert('stair_step');
            }

            if ($this->db->table_exists('user_pv_details')) {
                $this->db->set('total_pv', '0');
                $this->db->set('user_id', $admin_id);
                $result = $this->db->insert('user_pv_details');
            }
        }
        elseif ($mlm_plan == 'Donation'){
            $this->updateFTAdminCurrentLevel($admin_id);
            foreach ($cleanup_tables['donation'] as $table) {
                $this->cleanupTable($dbprefix, $table);
            }
        }

        $opencart_status = $module_status['opencart_status'];
        $opencart_status_demo = $module_status['opencart_status_demo'];
        if ($opencart_status == 'yes' && $opencart_status_demo == 'yes') {
            $customer_id = 0;
            $ip_adress = $_SERVER['REMOTE_ADDR'];
            $this->db->set_dbprefix($ocprefix);
            $this->db->set_ocprefix($ocprefix);
            $admin_oc_details = $this->getADMINOCDetails();
            $admin_oc_address_det = $this->getADMINOCAddressDetails();
            $user_det = $this->getStoreUserDetails();

            foreach ($cleanup_tables['store'] as $table) {
                $this->cleanupTable($ocprefix, $table);
            }

            if ($this->db->table_exists('customer')) {
                if (!$admin_oc_details) {
                    $admin_oc_details = [
                        "customer_group_id" => 1,
                        "store_id" => 0,
                        "firstname" => $user_details['user_detail_name'],
                        "lastname" => $user_details['user_detail_second_name'],
                        "email" => $user_details['user_detail_email'],
                        "telephone" => $user_details['user_detail_land'],
                        "fax" => '',
                        "password" => $admin_pass,
                        "salt" => '',
                        "address_id" => 1,
                        "ip" => $ip_adress,
                        "status" => 1,
                        "approved" => 1,
                        "date_added" => $current_date
                    ];
                }
                $this->db->insert('customer', $admin_oc_details);
                $customer_id = $this->db->insert_id();
            }

            if ($this->db->table_exists('address')) {
                if (!$admin_oc_address_det) {
                    $admin_oc_address_det = [
                        "firstname" => $user_details['user_detail_name'],
                        "lastname" => $user_details['user_detail_second_name'],
                        "address_1" => $user_details['user_detail_address'],
                        "address_2" => $user_details['user_detail_address2'],
                        "city" => $user_details['user_detail_city'],
                        "postcode" => $user_details['user_detail_pin']
                    ];
                }
                $admin_oc_address_det['customer_id'] = $customer_id;
                $this->db->insert('address', $admin_oc_address_det);
            }

            if ($this->db->table_exists('customer_ip')) {
                $customer_ip_det = [
                    "customer_id" => $customer_id,
                    "ip" => "$ip_adress",
                    "date_added" => "$current_date"
                ];
                $this->db->insert('customer_ip', $customer_ip_det);
            }

            if ($this->db->table_exists('user')) {
                if (!$user_det) {
                    $user_det[] = [
                        'user_id' => 1,
                        'user_group_id' => 1,
                        'username' => $user_name,
                        'password' => '93d73816952f63a4a4d744ff6572e38c116a1e14',
                        'salt' => '3bb59db46',
                        "firstname" => $user_details['user_detail_name'],
                        "lastname" => $user_details['user_detail_second_name'],
                        "email" => $user_details['user_detail_email'],
                        'image' => '',
                        'code' => '',
                        'ip' => $ip_adress,
                        'status' => 1,
                        'date_added' => $current_date,
                    ];
                }
                foreach ($user_det AS $user) {
                    $this->db->insert('user', $user);
                }
            }

            $this->db->set_dbprefix($dbprefix);
            $this->db->set_ocprefix($ocprefix);
            $this->updateFTAdminCustomerRefID($customer_id, $user_name);
        }

        $ticket_system_status = $module_status['ticket_system_status_demo'];
        if ($ticket_system_status == 'yes') {
            foreach ($cleanup_tables['ticket'] as $table) {
                $this->cleanupTable($dbprefix, $table);
            }

            if ($this->db->table_exists('ticket_categories')) {
                $this->db->set('ticket_count', 0);
                $this->db->set('status', 1);
                $this->db->set('assignee_id', 0);
                $this->db->update('ticket_categories');
            }
        }

        $repurchase_status = $module_status['repurchase_status'];
        if ($repurchase_status == 'yes') {
            foreach ($cleanup_tables['repurchase'] as $table) {
                $this->cleanupTable($dbprefix, $table);
            }
        }

        if($this->db->table_exists('level_commission_reg_pck')){
            $data = [];
            $level = $this->validation_model->getConfig('commission_upto_level');
            $this->load->model('configuration_model');
            $arr_pck = $this->configuration_model->getLevelCommissionPackages();
            $result = false;
                for ($j = 1, $k = $level; $j <= $level; $j++, $k--) {
                    foreach ($arr_pck as $pack) {
                        $data[] = ['level' => $j, 'pck_id' => $pack['prod_id'], 'cmsn_reg_pck' => $k, 'cmsn_member_pck' => $k];
                    }
                }
                $this->db->empty_table('level_commission_reg_pck');
                $result = $this->db->insert_batch('level_commission_reg_pck', $data);
                $this->db->truncate('level_commision');
                if ($this->MLM_PLAN == "Donation") {
                    for ($j = 1, $i = $level; $j <= $level; $j++, $i--) {
                        $this->db->set('level_no', $j);
                        $query = $this->db->insert('level_commision');
                    }
                } else {
                    for ($j = 1, $i = $level; $j <= $level; $j++, $i--) {
                        $this->db->set('level_no', $j);
                        $this->db->set('level_percentage', $i);
                        $query = $this->db->insert('level_commision');
                    }
                }
        }

        if($this->db->table_exists('sales_commissions')) {
            $data = [];
            $level = $this->validation_model->getConfig('sales_level');
            $this->load->model('configuration_model');
            $arr_pck = $this->configuration_model->getLevelCommissionPackages();
            $result = false;
                for ($j = 1, $k = $level; $j <= $level; $j++, $k--) {
                    foreach ($arr_pck as $pack) {
                        $data[] = ['level' => $j, 'pck_id' => $pack['prod_id'], 'sales' => $k];
                    }
                }
                $this->db->empty_table('sales_commissions');
                $result = $this->db->insert_batch('sales_commissions', $data);
                $this->db->truncate('sales_level_commision');
                    for ($j = 1, $i = $level; $j <= $level; $j++, $i--) {
                        $this->db->set('level_no', $j);
                        $this->db->set('level_percentage', $i);
                        $query = $this->db->insert('sales_level_commision');
                    }
        }

        if($this->db->table_exists('sales_commissions')) {
            $data = [];
            $level = $this->validation_model->getConfig('matching_upto_level');
            $this->load->model('configuration_model');
            $arr_pck = $this->configuration_model->getLevelCommissionPackages();
            $result = false;
                for ($j = 1, $k = $level; $j <= $level; $j++, $k--) {
                    foreach ($arr_pck as $pack) {
                        $data[] = ['level' => $j, 'pck_id' => $pack['prod_id'], 'cmsn_member_pck' => $k];
                    }
                }
                $this->db->empty_table('matching_commissions');
                $result = $this->db->insert_batch('matching_commissions', $data);
                $this->db->truncate('matching_level_commision');
                    for ($j = 1, $i = $level; $j <= $level; $j++, $i--) {
                        $this->db->set('level_no', $j);
                        $this->db->set('level_percentage', $i);
                        $query = $this->db->insert('matching_level_commision');
                    }
        }

        $response = TRUE;
        if (DEMO_STATUS == "yes") {
            $temp_prefix = $this->db->dbprefix;
            $this->db->set_dbprefix('');

            $this->db->where('admin_id', $admin_id);
            $query = $this->db->get('inf_preset_demo_users');
            $preset_demo = $query->row_array();

            $this->db->set_dbprefix($temp_prefix);

            if ($preset_demo) {
                $reg_from_tree = 0;
                $sponsor_id = $preset_demo['admin_id'];
                $preset_prefix = $preset_demo['admin_id'] . "_";
                $reg_post_array = $this->register_model->getDefaultData();
                $reg_post_array['user_name_entry'] = $preset_demo['user_name'];
                $regr = $reg_post_array;
                $regr['position'] = "";
                $regr['placement_user_name'] = $regr["sponsor_user_name"] = $this->LOG_USER_NAME;
                $regr['placement_full_name'] = $regr["sponsor_full_name"] = $this->validation_model->getUserFullName($this->LOG_USER_ID);

                if ($this->MLM_PLAN == "Binary") {
                    $regr['position'] = "L";
                } elseif ($this->MLM_PLAN == "Unilevel") {
                    $regr['placement_user_name'] = $user_name;
                    $regr['placement_full_name'] = $user_details["user_detail_name"];
                }

                $regr['reg_amount'] = $this->register_model->getRegisterAmount();

                $product_id = 0;
                $product_name = 'NA';
                $product_pv = '0';
                $product_amount = '0';
                $product_validity = date('Y-m-d H:i:s', strtotime('+12 months'));

                $product_status = $MODULE_STATUS['product_status'];
                if ($product_status == "yes") {
                    $product_id = $this->getMinProductId($MODULE_STATUS['opencart_status'], $MODULE_STATUS['opencart_status_demo']);
                    $this->load->model('product_model');
                    $product_details = $this->product_model->getProductDetails($product_id, 'yes');
                    $product_name = $product_details[0]['product_name'];
                    $product_pv = $product_details[0]['pair_value'];
                    $product_amount = $product_details[0]['product_value'];
                    if ($MODULE_STATUS['opencart_status'] == 'no') {
                        $product_validity = $this->product_model->calculateProductValidity($product_details[0]['package_validity']);
                    }
                }

                $regr['product_status'] = $product_status;
                $regr['product_id'] = $product_id;
                $regr['product_name'] = $product_name;
                $regr['product_pv'] = $product_pv;
                $regr['product_amount'] = $product_amount;
                $regr['product_validity'] = $product_validity;
                $regr['total_amount'] = $regr['reg_amount'] + $regr['product_amount'];
                $regr['country'] = 99;
                $regr['state'] = 1490;

                $this->load->model('country_state_model');
                $regr['country_name'] = $this->country_state_model->getCountryNameFromID($regr['country']);
                $regr['state_name'] = $this->country_state_model->getStateNameFromId($regr['state']);

                $regr['user_name_type'] = "static";
                $regr['joining_date'] = date('Y-m-d H:i:s');
                $regr['active_tab'] = "free_join";
                $regr['reg_from_tree'] = $reg_from_tree;

                $regr['sponsor_id'] = $this->validation_model->userNameToID($regr['sponsor_user_name']);
                $regr['placement_id'] = $this->validation_model->userNameToID($regr['placement_user_name']);
                $regr['product_name'] = $this->register_model->getProductName($regr['product_id']);
                $regr['payment_type'] = $regr['active_tab'];
                $regr['by_using'] = 'free join';

                $regr['pswd'] = $preset_demo['password'];
                $regr['address_line2'] = "";
                $regr['pin'] = "";
                $regr['registration_fee'] = $regr['reg_amount'];

                $status = $this->register_model->confirmRegister($regr, $MODULE_STATUS);

                $update_tran = $this->updateTranPassword($status['id'], password_hash($preset_demo['trans_password'], PASSWORD_DEFAULT));
                if ($status['status'] && $update_tran) {
                    $response = TRUE;
                }
                else {
                    $response = FALSE;
                }
            }

        }

        if ($response) {
            $this->commit();
        }
        else {
            $this->rollBack();
        }

        $this->db->query("SET FOREIGN_KEY_CHECKS=1;");

        return $response;
    }

    function getUserDetails($id) {
        $user_details = array();
        $this->db->select("*");
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $id);
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $user_details = $row;
        }
        return $user_details;
    }

    public function getADMINOCDetails() {
        $password_det = array();
        $this->db->from("customer");
        $this->db->where("customer_id", '1');
        $this->db->limit(1);
        $res = $this->db->get();

        foreach ($res->result_array() as $row) {
            $password_det = $row;
        }
        return $password_det;
    }

    public function getADMINOCAddressDetails() {
        $password_det = array();
        $this->db->from("address");
        $this->db->where("customer_id", '1');
        $this->db->limit(1);
        $res = $this->db->get();

        foreach ($res->result_array() as $row) {
            $password_det = $row;
        }
        return $password_det;
    }

    public function getStoreUserDetails() {
        $user_det = array();
        $this->db->select("*");
        $this->db->from("user");
        $this->db->where('username', 'admin');
        $this->db->or_where('username', 'store_admin');
        $res = $this->db->get();

        foreach ($res->result_array() as $row) {
            $user_det[] = $row;
        }
        return $user_det;
    }

    public function updateFTAdminCustomerRefID($customer_id, $user_name) {
        $this->db->set("oc_customer_ref_id", $customer_id);
        $this->db->where("user_name", $user_name);
        $this->db->update("ft_individual");
    }

    public function getMinProductId($opencart_status, $opencart_status_demo) {
        $product_id = 1;
        if ($opencart_status == 'yes' && $opencart_status_demo == 'yes') {
            $table = 'oc_product';
        }
        else {
            $table = 'package';
        }
        $this->db->select_min("product_id");
        // $this->db->where('active', "yes");
        $res = $this->db->get("{$table}");
        foreach ($res->result() as $row) {
            $product_id = $row->product_id;
        }
        return $product_id;
    }

    public function getMinPackageId($module_status)
    {
        if ($module_status['opencart_status'] == 'yes' && $module_status['opencart_status_demo'] == 'yes') {
            $this->db->select('package_id');
            $this->db->where('status', 1);
            $this->db->where('package_type', 'registration');
            $this->db->order_by('product_id');
            $this->db->limit(1);
            $query = $this->db->get('oc_product');
            return $query->row_array()['package_id'];
        }
        else {
            $this->db->select('prod_id');
            $this->db->where('active', 'yes');
            $this->db->where('type_of_package', 'registration');
            $this->db->order_by('product_id');
            $this->db->limit(1);
            $query = $this->db->get('package');
            return $query->row_array()['prod_id'];
        }
    }

    public function updateTranPassword($user_id, $trans_password) {
        $this->db->set("tran_password", $trans_password);
        $this->db->where("user_id", $user_id);
        return $this->db->update("tran_password");
    }

    public function updateFTAdminCurrentLevel($admin_id) {
        $this->db->set("current_level", 4);
        $this->db->where("id", $admin_id);
        $this->db->update("ft_individual");
    }

    public function cleanupTable($dbprefix, $table_name) {
        if ($this->db->table_exists($table_name)) {
            $this->db->empty_table($table_name);
            $this->setTableAutoIncrement($dbprefix, $table_name);
        }
    }

    public function setTableAutoIncrement($dbprefix, $table_name, $auto_increment = 1) {
        $this->db->query("ALTER TABLE {$dbprefix}{$table_name} AUTO_INCREMENT {$auto_increment}");
    }

    public function getCleanupTables() {
        $common_table_list = [
            'ft_individual',
            'user_details',
            'infinite_user_registration_details',
            'ewallet_history',
            'purchase_wallet_history',
            'leg_amount',
            'user_balance_amount',
            'tran_password',
            'login_employee',
            'amount_paid',
            'ticket_complaint_query_table',
            'ticket_complaint_ticket_table',
            'feedback',
            'fund_transfer_details',
            'mailtoadmin',
            'mailtouser',
            'news',
            'password_reset_table',
            'pin_numbers',
            'pin_request',
            'payout_release_requests',
            'sms_history',
            'to_do_list',
            'product_image_table',
            'rank_history',
            'sales_order',
            'activity_history',
            'user_deletion_history',
            'sponsor_change_history',
            'placement_change_history',
            'ewallet_payment_details',
            'pin_used',
            'payment_registration_details',
            'authorize_payment_details',
            'employee_details',
            'mailtouser_cumulativ',
            'mail_from_lead',
            'mail_from_lead_cumulative',
            'pin_purchases',
            'crm_leads',
            'invite_history',
            'invites_configuration',
            'user_activation_deactivation_history',
            'mlm_curl_history',
            'bitcoin_history',
            'bitcoin_payment_details',
            'bitcoin_payment_process_details',
            'bitcoin_payout_release_error_report',
            'pending_registration',
            'epin_transfer_history',
            'rawaddr_response',
            'blockchain_history',
            'bitgo_payment_history',
            'mass_payout_history',
            'blockchain_payout_release_history',
            'bitgo_payout_release_history',
            'configuration_change_history',
            'upgrade_sales_order',
            'package_upgrade_history',
            'replica_banners',
            'contacts',
            'employee_activity',
            'roi_order',
            'public_holidays',
            'kyc_docs',
            'kyc_category',
            'package_validity_extend_history',
            'payment_receipt',
            'purchase_rank',
            'other_expenses',
            'manual_pv_update_history',
            'crm_followups',
            'sofort_payment_history',
            'sofort_payment_response',
            'squareup_payment_history',
            'squareup_payment_response',
            'documents',
            'tree_parser',
            'cron_history',
            'joinee_rank',
            'binary_bonus_history',
            'upgradation_history',
            'subscription_payment_detail',
            'latest_uploads',
            'user_upgrade_strip_history',
            'video_settings'
            
        ];
        $party_table_list = [
            'party',
            'party_guest',
            'party_guest_invited',
            'party_guest_orders',
            'party_host',
        ];
        $binary_table_list = [
            'business_volume',
            'leg_details',
        ];
        $board_table_list = [
            'auto_board_1',
            'auto_board_2',
            'board_view',
            'board_user_detail',
        ];
        $stairstep_table_list = [
            'stair_step',
            'user_pv_details',
            'stair_step_history',
        ];
        $donation_table_list = [
            'donation_transfer_details',
            'donation_history',
            'user_upgrade_history',
        ];
        $store_table_list = [
            'customer',
            'address',
            'customer_activity',
            'reg_order_activation_history',
            'temp_registration',
            'customer_ip',
            'coupon',
            'coupon_history',
            'order',
            'order_history',
            'order_total',
            'order_product',
            'cart',
            'store',
            'user',
        ];
        $ticket_table_list = [
            'ticket_employee_activity',
            'ticket_activity',
            'ticket_employee_faq',
            'ticket_replies',
            'ticket_tickets',
            'ticket_tag',
            'ticket_attachments',
            'ticket_comments',
        ];
        $repurchase_table_list = [
            'repurchase_address',
            'repurchase_order',
            'repurchase_order_details',
        ];

        return [
            'common' => $common_table_list,
            'party' => $party_table_list,
            'binary' => $binary_table_list,
            'board' => $board_table_list,
            'stairstep' => $stairstep_table_list,
            'donation' => $donation_table_list,
            'store' => $store_table_list,
            'ticket' => $ticket_table_list,
            'repurchase' => $repurchase_table_list,
        ];
    }

}
