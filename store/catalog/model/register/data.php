<?php

class ModelRegisterData extends Model {

    private $data = array();

    public function getRegistrationpack($base_url) {
        $i = 0;
        $data = array();
        $this->load->model('tool/image');
        $query = $this->db->query("SELECT oc.*, ocp.* FROM " . DB_PREFIX . "product  AS oc JOIN " . DB_PREFIX . "product_description as ocp ON oc.product_id = ocp.product_id WHERE oc.package_type = 'registration' AND oc.quantity > '0' AND ocp.language_id = '1'");
        foreach ($query->rows as $row) {
            $data[$i] = $row;
            $data[$i]['image'] = $this->model_tool_image->resize($row['image'], 270, 270);
            $i++;
        }
        return $data;
    }

    public function getBankInfo() {
        $i = 0;
        $data = array();
        $query = $this->db->query("SELECT ud.user_detail_nbank,ud.user_detail_ifsc,ud.user_detail_acnumber,ud.user_detail_nbranch FROM " . MLM_DB_PREFIX . "user_details  AS ud limit 1");
        return $query->rows;
    }

    public function getProduct($product_id) {
        $i = 0;
        $data = array();
        $this->load->model('tool/image');
        $query = $this->db->query("SELECT oc.*, ocp.* FROM " . DB_PREFIX . "product  AS oc JOIN " . DB_PREFIX . "product_description as ocp ON oc.product_id = ocp.product_id WHERE oc.product_id = '$product_id' AND oc.quantity > '0' AND ocp.language_id = '1'");
        return $query->rows[0];
    }

    public function getProductByCategory($base_url, $category_id) {
        $i = 0;
        $data = array();
        $this->load->model('tool/image');
        $query = $this->db->query("SELECT oc.*, ocp.* FROM " . DB_PREFIX . "product  AS oc JOIN " . DB_PREFIX . "product_description as ocp ON oc.product_id = ocp.product_id JOIN " . DB_PREFIX . "product_to_category as occ ON oc.product_id = occ.product_id AND oc.quantity > '0' AND ocp.language_id = '1' AND occ.category_id='$category_id'");
        foreach ($query->rows as $row) {
            $data[$i] = $row;
            $data[$i]['image'] = $this->model_tool_image->resize($row['image'], 270, 270);
            $i++;
        }
        return $data;
    }

    public function getProductByKeyword($base_url, $key_word) {
        $i = 0;
        $data = array();
        $this->load->model('tool/image');
        $query = $this->db->query("SELECT oc.image,ocp.* FROM " . DB_PREFIX . "product  AS oc JOIN " . DB_PREFIX . "product_description as ocp ON oc.product_id = ocp.product_id WHERE ocp.name LIKE '%$key_word%' AND oc.quantity > '0' AND ocp.language_id = '1'");
        foreach ($query->rows as $row) {
            $data[$i] = $row;
            $data[$i]['image'] = $this->model_tool_image->resize($row['image'], 270, 270);
            $i++;
        }
        return $data;
    }

    public function getProductById($base_url, $product_id) {
        $i = 0;
        $data = array();
        $this->load->model('tool/image');
        $query = $this->db->query("SELECT oc.*,ocp.* FROM " . DB_PREFIX . "product  AS oc JOIN " . DB_PREFIX . "product_description as ocp ON oc.product_id = ocp.product_id WHERE oc.product_id='$product_id' AND oc.quantity > '0' AND ocp.language_id = '1'");
        foreach ($query->rows as $row) {
            $data = $row;
            $data['image'] = $this->model_tool_image->resize($row['image'], 270, 270);
            $i++;
        }
        return $data;
    }

    public function getRandInf() {

        $key = "";
        $charset = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for ($i = 0; $i < 15; $i++) {
            $key .= $charset[(mt_rand(0, (strlen($charset) - 1)))];
        }
        if (!$key) {
            $this->getRandInf();
        }
        $randum_id = $key;
        $query = $this->db->query("SELECT ft.* FROM " . MLM_DB_PREFIX . "ft_individual  AS ft  WHERE ft.inf_token='$randum_id'");
        $count = count($query->rows);
        if ($count) {
            $this->getRandInf();
        } else {
            return $randum_id;
        }
    }

    public function updateInfToken($customer_id, $inf_tkn) {
        $query = $this->db->query("UPDATE " . MLM_DB_PREFIX . "ft_individual SET inf_token = '" . $inf_tkn . "' WHERE oc_customer_ref_id = '" . (int) $customer_id . "'");
        return $query;
    }

    public function getCustomerByToken($token) {
        $query = $this->db->query("SELECT ft.*,cus.* FROM " . MLM_DB_PREFIX . "ft_individual as ft JOIN " . DB_PREFIX . "customer as cus ON ft.oc_customer_ref_id=cus.customer_id WHERE ft.inf_token = '" . $this->db->escape($token) . "' AND ft.inf_token != ''");
        return $query->row;
    }

    public function getCustomerById($customer_id) {
        $query = $this->db->query("SELECT ft.*,cus.* FROM " . MLM_DB_PREFIX . "ft_individual as ft JOIN " . DB_PREFIX . "customer as cus ON ft.oc_customer_ref_id=cus.customer_id WHERE cus.customer_id = '" . $this->db->escape($customer_id) . "'");
        return $query->row;
    }

    public function getOrderByCustomer($customer_id) {
        $query = $this->db->query("SELECT oc.order_id,oc.firstname,oc.lastname,oc.date_added,ocp.quantity,ocp.total ,occ.name as status FROM " . DB_PREFIX . "order as oc JOIN " . DB_PREFIX . "order_product as ocp ON oc.order_id=ocp.order_id JOIN " . DB_PREFIX . "order_status as occ ON oc.order_status_id = occ.order_status_id WHERE oc.customer_id = '" . $this->db->escape($customer_id) . "' AND occ.language_id = '1'");
        return $query->rows;
    }

    public function getOrderByOrder($order_id) {
        $query = $this->db->query("SELECT oc.*,ocp.* FROM " . DB_PREFIX . "order as oc JOIN " . DB_PREFIX . "order_product as ocp ON oc.order_id=ocp.order_id WHERE oc.order_id = '" . $this->db->escape($order_id) . "'");
        return $query->row;
    }

}
