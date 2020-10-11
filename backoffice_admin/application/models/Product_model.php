<?php

class product_model extends inf_model {

    var $product_detail = Array();

    function __construct() {
        parent::__construct();
    }

    public function getAllProducts($status = '', $type_of_package = '', $limit = '200', $page = '') {

        $product_details = array();
        $MODULE_STATUS = $this->trackModule();
        if ($MODULE_STATUS['opencart_status'] != "yes" || $MODULE_STATUS['opencart_status_demo'] != "yes") {
            $i = 0;
            $this->db->select('*');
            $this->db->from('package');
            if ($status != '') {
                $this->db->where('active', $status);
            }
            if ($type_of_package != '') {
                $this->db->where('type_of_package', $type_of_package);
            }
            $this->db->limit($limit, $page);
            $query = $this->db->get();
            foreach ($query->result_array() as $row) {
                $product_details[] = $row;
            }
        } else {
            $i = 0;
            $this->db->select('*');
            $this->db->from("oc_product");
            if ($type_of_package != '') {
                $this->db->where('package_type', $type_of_package);
            }
            $this->db->limit($limit, $page);
            $query = $this->db->get();
            foreach ($query->result_array() as $row) {
                $product_details[$i]['product_id'] = $row['product_id'];
                $product_details[$i]['product_name'] = $row['model'];
                $product_details[$i]['active'] = 'yes';
                $product_details[$i]['date_of_insertion'] = $row['date_added'];
                $product_details[$i]['prod_id'] = $row['product_id'];
                $product_details[$i]['product_value'] = $row['price'];
                $product_details[$i]['bv_value'] = 0;
                $product_details[$i]['pair_value'] = $row['pair_value'];
                $product_details[$i]['product_qty'] = 0;
                $product_details[$i]['type_of_package'] = $row['package_type'];
                $i = $i + 1;
            }
        }
        return $product_details;
    }

    public function addProduct($prod_name, $product_amount, $pair_value, $bv_value, $type_of_package, $package_validity,$package_id, $referral_commission = 0, $pair_price = 0, $roi= 0, $days = 0, $img_name = '',$description = '',$category_id = '') {

        $date = date('Y-m-d H:i:s');
        $data = array(
            'product_name' => $prod_name,
            'type_of_package' => $type_of_package,
            'active' => 'yes',
            'date_of_insertion' => $date,
            'product_value' => $product_amount,
            'pair_value' => $pair_value,
            'bv_value' => $bv_value,
            'package_validity' => $package_validity,
            'prod_id' => $package_id,
            'referral_commission' => $referral_commission,
            'prod_img' => $img_name,
            'pair_price' => $pair_price,
            'roi' => $roi,
            'days' => $days,
            'description' => $description,
            'category_id' =>$category_id
        );
        $query = $this->db->insert("package", $data);
        return $query;
    }

    public function updateProduct($id, $prod_name, $product_amount, $pair_value, $bv_value, $type_of_package, $package_validity,$package_id, $img_name = '', $description = '', $category_id = '') {

        $product = 'package';
        $data = array(
            'product_name' => $prod_name,
            'type_of_package' => $type_of_package,
            'active' => 'yes',
            'product_value' => $product_amount,
            'pair_value' => $pair_value,
            'bv_value' => $bv_value,
            'package_validity' => $package_validity,
            'prod_img' => $img_name,
            'description' => $description,
            'category_id' =>$category_id

        );
        $this->db->where('product_id', $id);
        $query = $this->db->update($product, $data);
        return $query;
    }

    public function inactivateProduct($product_id) {

        $product = 'package';
        $this->db->set('active', 'no');
        $this->db->where('product_id', $product_id);
        $query = $this->db->update($product);
        return $query;
    }

    public function activateProduct($product_id) {

        $product = 'package';
        $this->db->set('active', 'yes');
        $this->db->where('product_id', $product_id);
        $query = $this->db->update($product);
        return $query;
    }

    public function getPrdocutName($product_id) {
        $product_name = '';
        $this->db->select('product_name');
        $this->db->from('package');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $product_name = $row->product_name;
        }
        return $product_name;
    }

    public function isProductAvailable($product_id, $type = '') {
        $count = 0;
        $flag = FALSE;
        $MODULE_STATUS = $this->trackModule();
        if ($MODULE_STATUS['opencart_status'] != "yes" || $MODULE_STATUS['opencart_status_demo'] != "yes") {
            $this->db->select('count(*) AS cnt');
            $this->db->from('package');
            $this->db->where('product_id', $product_id);
            $this->db->where('active', 'yes');
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $count = $row->cnt;
            }
        } else {
            $this->db->select('count(*) AS cnt');
            $this->db->from('oc_product');
            $this->db->where('product_id', $product_id);
            if ($type) {
                $this->db->where('package_type', $type);
            }
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $count = $row->cnt;
            }
        }
        if ($count > 0) {
            $flag = TRUE;
        }
        return $flag;
    }

    public function isProductPinAvailable($prodcutid, $prodcutpin) {
        $flag = 0;
        $this->db->select('count(*) AS cnt');
        $this->db->from('pin_numbers');
        $this->db->where('pin_numbers', $prodcutpin);
        $this->db->where('status', 'yes');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $count = $row->cnt;
        }
        if ($count > 0)
            $flag = 1;
        return $flag;
    }

    public function isPasscodeAvailable($product_pin, $active = 'yes') {

        $flag = 0;
        $this->db->select('count(*) AS cnt');
        $this->db->from('pin_numbers');
        $this->db->where('pin_numbers', $product_pin);
        $this->db->where('status', $active);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $count = $row->cnt;
        }
        if ($count > 0)
            $flag = 1;
        return $flag;
    }

    public function getProduct($product_id) {
        $amount = 0;

        $MODULE_STATUS = $this->trackModule();
        if ($MODULE_STATUS['opencart_status'] != "yes" || $MODULE_STATUS['opencart_status_demo'] != "yes") {
            $this->db->select('product_value');
            $this->db->from('package');
            $this->db->where('prod_id', $product_id);
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

    public function getProductDetails($product_id = '', $status = 'yes') {
        $product_details = array();

        $MODULE_STATUS = $this->trackModule();

        if ($MODULE_STATUS['opencart_status'] != "yes" || $MODULE_STATUS['opencart_status_demo'] != "yes") {
            $this->db->select('*');
            if ($product_id != '') {
                $this->db->where('product_id', $product_id);
            }
            if ($status != '') {
                $this->db->where('active', $status);
            }
            $query = $this->db->get('package');

            foreach ($query->result_array() as $row) {
                $product_details[] = $row;
            }
        } else {
            $this->db->select('product_id,model AS product_name,pair_value,price AS product_value');
            if ($product_id != '') {
                $this->db->where('product_id', $product_id);
            }
            $query = $this->db->get('oc_product');
            foreach ($query->result_array() as $row) {
                $product_details[] = $row;
            }
        }

        return $product_details;
    }

    public function getProductAmountAndPV($product_id) {
        $pair_value = 0;
        $product_value = 0;
        $MODULE_STATUS = $this->trackModule();

        if ($MODULE_STATUS['opencart_status'] == "no" || $MODULE_STATUS['opencart_status_demo'] == "no") {
            $this->db->select('pair_value');
            $this->db->select('product_value');
            $this->db->where('product_id', $product_id);
            $query = $this->db->get('package');
            foreach ($query->result() as $row) {
                $pair_value = $row->pair_value;
                $product_value = $row->product_value;
            }
        } else {
            $this->db->select('pair_value,price AS product_value');
            $this->db->where('product_id', $product_id);
            $query = $this->db->get('oc_product');
            foreach ($query->result() as $row) {
                $pair_value = $row->pair_value;
                $product_value = $row->product_value;
            }
        }

        $amount['pair_value'] = $pair_value;
        $amount['product_value'] = $product_value;
        return $amount;
    }

    public function deleteProduct($id) {
        $this->db->set('active', 'deleted');
        $this->db->where('product_id', $id);
        $query = $this->db->update('package');

        return $query;
    }
    public function calculateProductValidity($package_validity_in_months,$validity_date=''){
        if($validity_date =='')
        {
            $validity_date=date('Y-m-d H:i:s');
        }
        //$current_date_time = date('Y-m-d H:i:s');
        $month_validity = "+".$package_validity_in_months." month";
        $time = strtotime($validity_date);
        $product_validity = date("Y-m-d H:i:s", strtotime($month_validity, $time));
        return $product_validity;
    }
    public function getPackageValidityDate($package_id,$validity_date='') {
        if($validity_date!='')
        {
            $expiry_date = $validity_date;
        }
        else
        {
            $expiry_date = date('Y-m-d H:i:s');
        }
        $this->db->select('package_validity');
        $this->db->where('prod_id', $package_id);
        $query = $this->db->get('package');
        foreach ($query->result_array() as $value) {
            $expiry_date = $this->calculateProductValidity($value['package_validity'],$expiry_date);
        }

        return $expiry_date;
    }

    public function getPackageCount($package_type = '', $status = '') {
        if ($status) {
            $this->db->where('active', $status);
        }
        if ($package_type) {
            $this->db->where('type_of_package', $package_type);
        }
        $count = $this->db->count_all_results('package');
        return $count;
    }

    public function getPackageList($package_type = '', $status = '', $limit = '', $page = '') {
        $MODULE_STATUS = $this->trackModule();
        if ($package_type) {
            $this->db->where('type_of_package', $package_type);
        }
        if ($status) {
            $this->db->where('active', $status);
        }
        if ($limit) {
            $this->db->limit((int)$limit, (int)$page);
        }
        $query = $this->db->get('package');
        $product_details = $query->result_array();
        return $product_details;
    }

    public function getPackageDetails($id, $package_type = '') {
        $this->db->where('product_id', $id);
        if ($package_type) {
            $this->db->where('type_of_package', $package_type);
        }
        $query = $this->db->get('package');
        return $query->row_array();
    }

    public function packageIdAvailable($package_id, $package_type)
    {
        $this->db->where('prod_id', $package_id);
    //  $this->db->where('type_of_package', $package_type);
    //  $this->db->where('active !=', 'deleted');
        $count = $this->db->count_all_results('package');
        return ($count === 0);
    }

    public function packageNameAvailable($package_name, $package_type)
    {
        $this->db->where('product_name', $package_name);
        $this->db->where('type_of_package', $package_type);
        $this->db->where('active !=', 'deleted');
        $count = $this->db->count_all_results('package');
        return ($count === 0);
    }

    public function getPackageId($product_id, $package_type)
    {
        $this->db->select('prod_id');
        $this->db->where('product_id', $product_id);
        $this->db->where('type_of_package', $package_type);
        $query = $this->db->get('package');
        return $query->row_array()['prod_id'];
    }

    public function getPackageName($product_id, $package_type)
    {
        $this->db->select('product_name');
        $this->db->where('product_id', $product_id);
        $this->db->where('type_of_package', $package_type);
        $query = $this->db->get('package');
        return $query->row_array()['product_name'];
    }

    public function getProductPackageId($product_id, $module_status, $package_type)
    {
        if ($module_status['opencart_status'] == 'yes' && $module_status['opencart_status_demo'] == 'yes') {
            $this->db->select('package_id');
            $this->db->from('oc_product');
            $this->db->where('package_type', $package_type);
            $this->db->where('product_id', $product_id);
            $query = $this->db->get();
        }
        else {
            $this->db->select('prod_id package_id');
            $this->db->from('package');
            $this->db->where('type_of_package', $package_type);
            $this->db->where('product_id', $product_id);
            $query = $this->db->get();
        }
        return $query->row_array()['package_id'];
    }

    public function getPackageNameFromPackageId($package_id, $module_status, $package_type)
    {
        if ($module_status['opencart_status'] == 'yes' && $module_status['opencart_status_demo'] == 'yes') {
            $this->db->select('model product_name');
            $this->db->from('oc_product');
            $this->db->where('package_type', $package_type);
            $this->db->where('package_id', $package_id);
            $query = $this->db->get();
        }
        else {
            $this->db->select('product_name');
            $this->db->from('package');
            $this->db->where('type_of_package', $package_type);
            $this->db->where('prod_id', $package_id);
            $query = $this->db->get();
        }
        return $query->row_array()['product_name'];
    }

    public function getPackagePairPrice($package_id, $module_status, $package_type)
    {
        if ($module_status['opencart_status'] == 'yes' && $module_status['opencart_status_demo'] == 'yes') {
            $this->db->select('pair_price');
            $this->db->from('oc_product');
            $this->db->where('package_type', $package_type);
            $this->db->where('package_id', $package_id);
            $query = $this->db->get();
        }
        else {
            $this->db->select('pair_price');
            $this->db->from('package');
            $this->db->where('type_of_package', $package_type);
            $this->db->where('prod_id', $package_id);
            $this->db->where('active !=', 'deleted');
            $query = $this->db->get();
        }
        return $query->row_array()['pair_price'];
    }

    public function getPackageCountForProgressbar($package_type = '', $status = '') {
        $module_status = $this->trackModule();
        if ($module_status['opencart_status'] == 'yes' && $module_status['opencart_status_demo'] == 'yes') {
            if ($package_type) {
                $this->db->where('package_type', $package_type);
            }
            $this->db->where('status', 1);
            $count = $this->db->count_all_results('oc_product');
        } else {

            $this->db->select("prod_id");
            $this->db->from("package");
            if ($package_type) {
                $this->db->where('type_of_package', $package_type);
            }
            if ($status) {
                $this->db->where('active', $status);
            }else{
                $this->db->where('active', 'yes');
            }

            $query1 = $this->db->get_compiled_select();
            $this->db->select('pck.prod_id');
            $this->db->from('ft_individual as ft');
            $this->db->join('package as pck', 'pck.prod_id = ft.product_id');
            $this->db->where('ft.product_id !=', '');
            $this->db->distinct();

            $query2 = $this->db->get_compiled_select();

            $query = $this->db->query("(" . $query1 . ")" . " UNION " . "(" . $query2 . ")");
            $count = count($query->result_array());
        }
        return $count;
    }

    public function getPackageListForProgressbar($package_type = '', $status = '', $limit = '', $page = '') {
        $module_status = $this->trackModule();
        if ($module_status['opencart_status'] == 'yes' && $module_status['opencart_status_demo'] == 'yes') {
            $this->db->select('*,package_id as prod_id,package_type as type_of_package, model as product_name, date_available as package_validity, status as active');
            $this->db->where('status', 1);
            if ($package_type) {
                $this->db->where('package_type', $package_type);
            }
            if ($limit) {
                $this->db->limit((int) $limit, (int) $page);
            }
            $query = $this->db->get('oc_product');
        } else {
            $this->db->select("prod_id,product_name,package_validity,product_id,active,type_of_package");
            $this->db->from("package");
            if ($package_type) {
                $this->db->where('type_of_package', $package_type);
            }
            if ($status) {
                $this->db->where('active', $status);
            }else{
                $this->db->where('active', 'yes');
            }
            if ($limit) {
                $this->db->limit((int) $limit, (int) $page);
            }
            $query1 = $this->db->get_compiled_select();

            $this->db->select('pck.prod_id,pck.product_name,pck.package_validity,pck.product_id,pck.active,pck.type_of_package');
            $this->db->from('ft_individual as ft');
            $this->db->join('package as pck', 'pck.prod_id = ft.product_id');
            $this->db->where('ft.product_id !=', '');
            $this->db->distinct();
            if ($limit) {
                $this->db->limit((int) $limit, (int) $page);
            }
            $query2 = $this->db->get_compiled_select();
            $query = $this->db->query("(" . $query1 . ")" . " UNION " . "(" . $query2 . ")");

        }

        $product_details = $query->result_array();
        return $product_details;
    }

    public function getProdId($product_id, $module_status, $package_type)
    {
        if ($module_status['opencart_status'] == 'yes' && $module_status['opencart_status_demo'] == 'yes') {
            $this->db->select('package_id');
            $this->db->from('oc_product');
            $this->db->where('package_type', $package_type);
            $this->db->where('product_id', $product_id);
            $query = $this->db->get();
        }
        else {
            $this->db->select('product_id package_id');
            $this->db->from('package');
            $this->db->where('type_of_package', $package_type);
            $this->db->where('prod_id', $product_id);
            $query = $this->db->get();
        }
        return $query->row_array()['package_id'];
    }

    public function isActiveProduct($product_id, $type) {
        $this->db->where('active', 'yes');
        $this->db->where('type_of_package', $type);
        $this->db->where('product_id', $product_id);
        return $this->db->count_all_results('package');
    }

    public function getPackageInfoByColumns($product_id, $columns) {
        if (is_array($columns)) {
            $columns = implode(',', $columns);
        }
        $this->db->select($columns);
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('package');
        if ($query->num_fields() > 1) {
            return $query->row_array();
        }
        else {
            return $query->row_array()[$columns];
        }
    }

    public function getMembershipPackageListByColumns($columns) {
        if (is_array($columns)) {
            $columns = implode(',', $columns);
        }
        if ($this->MODULE_STATUS['opencart_status'] == "no") {
            $this->db->select($columns);
            $this->db->where('type_of_package', 'registration');
            $query = $this->db->get('package');
            return $query->result_array();
        } else {
            $this->db->select($columns);
            $this->db->where('package_type', 'registration');
            $query = $this->db->get('oc_product');
            return $query->result_array();
        }
    }
    
    public function addCategory($category_name) {
        $date = date('Y-m-d H:i:s');
        $data = array(
            'category_name' => $category_name,
            'status' => 'yes',
            'date_added' => $date
        );
        $query = $this->db->insert("repurchase_category", $data);
        return $query;
    }

    public function getCategoryName($category_id) {
        $this->db->select('category_name');
        $this->db->where('category_id', $category_id);
        $query = $this->db->get('repurchase_category');
        return $query->row_array()['category_name'];
    }

    public function categoryNameAvailable($category_name)
    {
        $this->db->where('category_name', $category_name);
        $this->db->where('status !=', 'deleted');
        $count = $this->db->count_all_results('repurchase_category');
        return ($count === 0);
    }

    public function getCategories() {
        $category_details = [];
        $this->db->select('category_id,category_name');
        $this->db->where('status', 'yes');
        $query = $this->db->get('repurchase_category');
       foreach ($query->result_array() as $row) {
                $category_details[] = $row;
            }
        return $category_details;
    }

    public function categoryChanges($category_id, $status) {
        $this->db->set('status', $status);
        $this->db->where('category_id', $category_id);
        $query = $this->db->update('repurchase_category');
        if($query){
            $this->db->set('active', $status);
            $this->db->where('category_id', $category_id);
            $query = $this->db->update('package');
        }
        return $query;
    }

    public function getCategoryCount($status = '') {
        if ($status) {
            $this->db->where('status', $status);
        }
        $count = $this->db->count_all_results('repurchase_category');
        return $count;
    }

    public function getCategoryList($status = '', $limit = '', $page = '') {

        if ($status) {
            $this->db->where('status', $status);
        }
        if ($limit) {
            $this->db->limit((int)$limit, (int)$page);
        }
        $query = $this->db->get('repurchase_category');
        return $query->result_array();
    }

    public function updateCategory($category_id, $category_name) {
        $product = 'repurchase_category';
        $data = array(
            'category_name' => $category_name
        );
        $this->db->where('category_id', $category_id);
        $query = $this->db->update($product, $data);
        return $query;
    }

    public function getCategoryDetails($category_id = '') {
        $this->db->where('category_id', $category_id);
        $query = $this->db->get('repurchase_category');
        return $query->row_array();
    }

    public function isActiveCategory($category_id) {
        $this->db->where('status', 'yes');
        $this->db->where('category_id', $category_id);
        return $this->db->count_all_results('repurchase_category');
    }
    public function insertPackageCommissions($prod_id) {
        $data =[];
        $this->db->select_max('level');
        $result = $this->db->get('level_commission_reg_pck');
        $max_level = $result->row()->level;
        for($i = 1;$i <= $max_level; $i++){
            $data[] = ['level' => $i, 'pck_id' => $prod_id, 'cmsn_reg_pck' => 0, 'cmsn_member_pck' => 0];
        }
        if($data){
            $result = $this->db->insert_batch('level_commission_reg_pck', $data);
        }
    }


    public function getProductPV($product_id)
    {
        if ($this->MODULE_STATUS['opencart_status'] == "no") {
            $this->db->select('pair_value');
            $this->db->where('product_id', $product_id);
            $query = $this->db->get('package');
            return $query->row_array()['pair_value'];
        } else {
            $this->db->select('pair_value');
            $this->db->where('product_id', $product_id);
            $query = $this->db->get('oc_product');
            return $query->row_array()['pair_value'];
        }
    }

    public function getProductPvByPackageId($package_id)
    {
        if ($this->MODULE_STATUS['opencart_status'] == "no") {
            $this->db->select('pair_value');
            $this->db->where('prod_id', $package_id);
            $query = $this->db->get('package');
            return $query->row_array()['pair_value'];
        } else {
            $this->db->select('pair_value');
            $this->db->where('package_id', $package_id);
            $query = $this->db->get('oc_product');
            return $query->row_array()['pair_value'];
        }
    }

    public function getAllRankNameAndId() {

        $this->db->select('rank_id,rank_name');
        $this->db->where('delete_status', 'yes');
        $this->db->where('rank_status', 'active');
        $query = $this->db->get('rank_details');
        return $query->result_array();
    }

    public function insertPackageLevelCommissions($prod_id, $post_arr, $max_level) {
        $data =[];
        for($i = 1;$i <= $max_level; $i++) {
            $data[] = ['level' => $i, 'pck_id' => $prod_id, 'cmsn_reg_pck' => isset($post_arr['level' . $i]) ? $post_arr['level' . $i] : 0, 'cmsn_member_pck' => isset($post_arr['level' . $i]) ? $post_arr['level' . $i] : 0];
        }
        if($data) {
            $result = $this->db->insert_batch('level_commission_reg_pck', $data);
        }
    }

    public function insertPackageSalesCommissions($prod_id, $post_arr, $max_level) {
        $data =[];
        for($i = 1;$i <= $max_level; $i++) {
            $data[] = ['level' => $i, 'pck_id' => $prod_id, 'sales' => isset($post_arr['sales_commission' . $i]) ? $post_arr['sales_commission' . $i] : 0];
        }
        if($data) {
            $result = $this->db->insert_batch('sales_commissions', $data);
        }
    }

    public function insertRankCommissions($prod_id, $post_arr, $downline_package_status, $joinee_package_status) {

        if($joinee_package_status) {
            $pck_rank = [
                'rank_id' => $post_arr['rank_name'],
                'package_id' => $prod_id
            ];
            $query = $this->db->insert("joinee_rank", $pck_rank);
        }

        if($downline_package_status) {
            $data =[];
            $rank_arr = $this->getAllRankNameAndId();
            foreach($rank_arr as $rank) {
                $rank_id = $rank['rank_id'];
                if (array_key_exists('rank_count' . $rank_id, $post_arr)) {
                    $data[] = ['rank_id' => $rank_id, 'package_id' => $prod_id, 'package_count' => $post_arr['rank_count'. $rank_id]]; 
                }
            }
            if($data) {
                $result = $this->db->insert_batch('purchase_rank', $data);
            }
        }
    }

    public function insertMatchingBonus($prod_id, $post_arr,$max_level) {
        $data =[];
        for($i = 1;$i <= $max_level; $i++) {
            $data[] = ['level' => $i, 'pck_id' => $prod_id, 'cmsn_member_pck' => isset($post_arr['matching_bonus' . $i]) ? $post_arr['matching_bonus' . $i] : 0];
        }
        if($data) {
            $result = $this->db->insert_batch('matching_commissions', $data);
        }
    }

}
