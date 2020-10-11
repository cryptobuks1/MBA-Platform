<?php

class Repurchase_model extends Inf_model {
    public $upline_sponsor_arr;

    function __construct() {
        parent::__construct();
        $this->upline_sponsor_arr = array();
        $this->load->model('validation_model');
        $this->load->model('register_model');
        $this->load->model('calculation_model');
        if ($this->MLM_PLAN == 'Hyip' || $this->MLM_PLAN == 'X-Up') {
            $this->load->model('Unilevel_model', 'plan_model');
        }
        else {
            $this->load->model($this->MLM_PLAN . '_model', 'plan_model');
        }
    }

    function getAllRepurchaseProducts($product_id = "") {
        $this->db->select("*");
        $this->db->from("package");
        $this->db->where('type_of_package', "repurchase");
        $this->db->where('active', "yes");
        if ($product_id) {
            $this->db->where('product_id', $product_id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function validateAllEpins($epin_array, $total_amount, $user_id, $upgrade_user_id='')
    {
        $result = [];
        foreach ($epin_array as $key => $value) {
            $epin = $value['pin'];
            $epin_details = $this->getEpinDetails($epin, $user_id, $upgrade_user_id);
            if ($epin_details) {
                $epin_amount = $epin_details['pin_amount'];
                $epin_used_amount = min($epin_amount, $total_amount);
                $epin_balance_amount = $epin_amount - $epin_used_amount;
                $total_amount = $total_amount - $epin_used_amount;
                $result[$key] = array(
                    'pin' => $epin,
                    'amount' => $epin_amount,
                    'balance_amount' => $epin_balance_amount,
                    'reg_balance_amount' => $total_amount,
                    'epin_used_amount' => $epin_used_amount
                );
            }
            else {
                $result[$key] = array(
                    'pin' => 'nopin',
                    'amount' => 0,
                    'balance_amount' => 0,
                    'reg_balance_amount' => 0,
                    'epin_used_amount' => 0
                );
            }
        }
        return $result;
    }

    public function getEpinDetails($epin, $user_id, $upgrade_user_id='')
    {
        $date = date('Y-m-d');
        $admin_userid = $this->validation_model->getAdminId();
        $this->db->select('pin_numbers,pin_balance_amount pin_amount,allocated_user_id');
        //$this->db->where('pin_numbers', $epin);
        $this->db->where("pin_numbers LIKE BINARY '$epin'", NULL, true);
        if ($this->LOG_USER_TYPE == 'admin' || $this->LOG_USER_TYPE == 'employee') {
            if ($upgrade_user_id != '') {
                $whr='(allocated_user_id='.$user_id.' or allocated_user_id='.$admin_userid.' or allocated_user_id='.$upgrade_user_id.' or allocated_user_id IS NULL )';
            } else {
                $whr='(allocated_user_id='.$user_id.' or allocated_user_id IS NULL )';
            }
        }else{
         $whr='(allocated_user_id='.$user_id.')';
        }
        $this->db->where($whr);
        $this->db->where('pin_amount >', 0);
        $this->db->where('status', 'yes');
        $this->db->where('pin_expiry_date >=', $date);
        $this->db->limit(1);
        $query = $this->db->get('pin_numbers');
        $res = $query->row_array();
        if ($res) {
            if ($res['allocated_user_id'] == 'NA' || $res['allocated_user_id'] == $user_id || $res['allocated_user_id'] == $upgrade_user_id || $res['allocated_user_id'] == $admin_userid) {
                return $res;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    public function addCheckoutAddress($address) {
        $res1 = $res2 = false;
        $this->begin();

        $this->db->set('default_address', 0);
        $res1 = $this->db->update('repurchase_address');

        $date = date('Y-m-d');
        $this->db->set('user_id', $address['user_id']);
        $this->db->set('name', $address['full_name']);
        $this->db->set('address', $address['address']);
        $this->db->set('pin', $address['pin_no']);
        $this->db->set('town', $address['city']);
        $this->db->set('mobile', $address['phone']);
        $this->db->set('default_address', '1');
        $this->db->insert('repurchase_address');
        $res2 = $this->db->insert_id();

        if ($res1 && $res2) {
            $this->commit();
            return $res2;
        } else {
            $this->rollBack();
            return false;
        }
    }

    public function updateDefualtAddress($user_id, $address_id) {
        $res1 = $res2 = false;
        $this->begin();

        $this->db->set('default_address', 0);
        $res1 = $this->db->update('repurchase_address');

        $this->db->where('id', $address_id);
        $this->db->where('user_id', $user_id);
        $this->db->set('default_address', '1');
        $res2 = $this->db->update('repurchase_address');
        if ($res1 && $res2) {
            $this->commit();
            return true;
        } else {
            $this->rollBack();
            return false;
        }
    }

    public function getUserPurchaseAddress($user_id) {
        $address_array = array();
        $this->db->select('*');
        $this->db->from('repurchase_address');
        $this->db->where('user_id', $user_id);
        $this->db->where('delete_status', 'yes');
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $address_array[$i]['id'] = $row['id'];
            $address_array[$i]['user_id'] = $row['user_id'];
            $address_array[$i]['name'] = $row['name'];
            $address_array[$i]['address'] = $row['address'];
            $address_array[$i]['pin'] = $row['pin'];
            $address_array[$i]['town'] = $row['town'];
            $address_array[$i]['mobile'] = $row['mobile'];
            $i++;
        }
        return $address_array;
    }

    public function getUserRepurchaseDefualtAddress($user_id) {
        $address_array = array();
        $this->db->select('*');
        $this->db->from('repurchase_address');
        $this->db->where('user_id', $user_id);
        $this->db->where('default_address', '1');
        $this->db->where('delete_status', 'yes');
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $address_array['id'] = $row['id'];
            $address_array['user_id'] = $row['user_id'];
            $address_array['name'] = $row['name'];
            $address_array['address'] = $row['address'];
            $address_array['pin'] = $row['pin'];
            $address_array['town'] = $row['town'];
            $address_array['mobile'] = $row['mobile'];
        }
        return $address_array;
    }

    public function removePurchaseAddress($address_id) {
        $this->db->set('delete_status', 'no');
        $this->db->where('id', $address_id);
        return $this->db->update('repurchase_address');
    }

    public function insertIntoSalesOrder($user_id, $product_id, $payment_method = "") {
        $date = date('Y-m-d H:i:s');
        $last_inserted_id = $this->getMaxSalesOrderId();
        $invoice_no = 1000 + $last_inserted_id;
        $product_details = $this->getProduct($product_id);
        $amount = $product_details['product_value'];

        $this->db->set('invoice_no', $invoice_no);
        $this->db->set('prod_id', $product_id);
        $this->db->set('user_id', $user_id);
        $this->db->set('amount', round($amount, 8));
        $this->db->set('date_submission', $date);
        $this->db->set('payment_method', $payment_method);
        $res = $this->db->insert('sales_order');
        return $res;
    }

    public function insertIntoRepuchaseOrder($purchase_data) {
        $date = date('Y-m-d H:i:s');
        $data = array(
            'order_id' => 0,
            'invoice_no' => 0
        );
        $last_inserted_id = $this->getMaxRepurchaseOrderId();
        $invoice_no = 1000 + $last_inserted_id;
        $invoice_no = "RPCHSE" . $invoice_no;

        $this->db->set('invoice_no', $invoice_no);
        $this->db->set('user_id', $purchase_data['user_id']);
        $this->db->set('total_amount', round($purchase_data['total_amount'], 8));
        $this->db->set('order_status', $purchase_data['status']);
        $this->db->set('payment_method', $purchase_data['payment_type']);
        $this->db->set('order_address_id', $purchase_data['order_address_id']);
        $this->db->set('order_date', $date);
        $res = $this->db->insert('repurchase_order');
        $insert_id = $this->db->insert_id();
        $data['order_id'] = $insert_id;
        $data['invoice_no'] = $invoice_no;
        return $data;
    }

    public function getMaxRepurchaseOrderId() {
        $max_id = 0;
        $this->db->select_max('order_id');
        $this->db->from('repurchase_order');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $max_id = $row->order_id;
        }
        return $max_id;
    }

    public function insertRepurchaseOrderDetails($product_details, $orders_id, $order_status) {

        $this->db->set('order_id', $orders_id);
        $this->db->set('product_id', $product_details['id']);
        $this->db->set('prod_id', $this->validation_model->getProdIDFromProductid($product_details['id']));
        $this->db->set('quantity', $product_details['qty']);
        $this->db->set('amount', $product_details['price']);
        $this->db->set('product_pv', $product_details['pv']);
        $this->db->set('order_status', $order_status);
        $res = $this->db->insert('repurchase_order_details');
        return $res;
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

    public function getRpurchaseInvoiceDetails($invoice_order_id) {
        $details = array();
        $this->load->model('product_model');

        $this->db->select('rod.*,ro.*');
        $this->db->from('repurchase_order_details rod');
        $this->db->join('repurchase_order ro', 'rod.order_id = ro.order_id');
        $this->db->where("rod.order_id", $invoice_order_id);
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $module_status = $this->trackModule();
            $package_id = $this->product_model->getProductPackageId($row['product_id'], $module_status, 'repurchase');
            $invoice_no = $row['invoice_no'];
            $user_id = $row['user_id'];
            $address_id = $row['order_address_id'];
            $details['product_details'][$i]["product_name"] = $this->validation_model->getPrdocutName($row['product_id']);
            $details['product_details'][$i]["product_amount"] = $this->product_model->getProduct($package_id);
            $details['product_details'][$i]["quantity"] = $row['quantity'];
            $details['product_details'][$i]["amount"] = $row['amount'];

            $order_date = $row['order_date'];
            $i++;
        }
        $details['order_date'] = $order_date;
        $details['invoice_no'] = $invoice_no;
        $details['address'] = $this->getUserRepurchaseAddress($user_id, $address_id);
        return $details;
    }

    public function getUserRepurchaseAddress($user_id, $address_id) {
        $details = array();
        $this->db->select('*');
        $this->db->from('repurchase_address');
        $this->db->where("user_id", $user_id);
        $this->db->where("id", $address_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $details["id"] = $row['id'];
            $details["user_id"] = $row['user_id'];
            $details["name"] = $row['name'];
            $details["address"] = $row['address'];
            $details["pin"] = $row['pin'];
            $details["town"] = $row['town'];
            $details["mobile"] = $row['mobile'];
        }
        return $details;
    }

    public function updateUserPv($cart_products, $purchase_details, $module_status) {
        $mlm_plan = $module_status['mlm_plan'];
        $this->load->model('product_model');
        $update_pv = TRUE;
        $upline_id = $this->validation_model->getFatherId($purchase_details['user_id']);
        $position = $this->validation_model->getUserPosition($purchase_details['user_id']);

        $product_pair_value = 0;
        $product_amount = 0;
        $quantity = 0;
        foreach ($cart_products as $value) {
            $product_details = $this->product_model->getProductAmountAndPV($value['id']);
            $product_pv = $product_details['pair_value'] * $value['qty'];
            $product_pair_value += $product_pv;
            $quantity += $value['qty'];
            $product_amount += $product_details['product_value'] * $value['qty'];
        }
        $oc_order_id = 0;
        $action = 'repurchase';

        $sponsor_id = $this->validation_model->getSponsorId($purchase_details['user_id']);
        if($mlm_plan == 'Matrix'){
            $upline_id = $sponsor_id;
        }
        $data = array();
        $data['sponsor_id'] = $sponsor_id;
        //CALCULATION SECTION STARTS//

        $update_pv = $this->plan_model->runCalculation($action, $purchase_details['user_id'], $value['id'], $product_pair_value, $product_amount, $oc_order_id, $upline_id, 0, $position, $data);

        //CALCULATION SECTION ENDS//

        if (!$update_pv) {
                return false;
        }
        return $update_pv;
    }

    public function getCheckoutAddressId() {
        $this->db->select_max('id');
        $res = $this->db->get('repurchase_address');
        foreach ($res->result() as $row) {
            return $row->id;
        }

    }

    function getCategoryName($category_id) {
        $this->db->select("category_name");
        $this->db->where('status', "yes");
        $this->db->where('category_id', $category_id);
        $res = $this->db->get('repurchase_category');
        foreach ($res->result() as $row) {
            return $row->category_name;
        }
    }

    public function getPendingOrders($order_id= '', $page= '', $limit= '') {

        $details = [];
        $this->db->select('*');
        $this->db->from('repurchase_order');
        $this->db->where('order_status', 'pending');
        if($order_id) {
            $this->db->where('order_id', $order_id);
        }
        if ($limit) {
            $this->db->limit($limit, $page);
        }
        $query = $this->db->get();

        $i = 0; $j = 0;
        foreach ($query->result_array() as $row) {
            $j = 0;
            $this->db->select('*');
            $this->db->from('repurchase_order_details');
            $this->db->where('order_id', $row['order_id']);
            $result = $this->db->get();

            $details["$i"]["product_count"] = count($result->result_array());

            foreach ($result->result_array() as  $product_data) {

               $this->db->select('product_name');
               $this->db->from('package');
               $this->db->where('prod_id',$product_data['prod_id']);
               $this->db->limit(1);
               $query = $this->db->get();
               foreach ($query->result() as $prod_name) {
                $prod_name = $prod_name->product_name;
               }
               $details["$i"]["product_details"]["$j"]["unite_price"] = $product_data['amount'];
               $details["$i"]["product_details"]["$j"]["quantity"] = $product_data['quantity'];
               $details["$i"]["product_details"]["$j"]["prod_id"] = $product_data['prod_id'];
               $details["$i"]["product_details"]["$j"]["prod_name"] = $prod_name;
               $details["$i"]["product_details"]["$j"]["total"] = ($product_data['amount'] * $product_data['quantity']) ;
               $j++;
            }

            $details["$i"]["id"] = $row['order_id'];
            $details["$i"]["user_name"] = $this->validation_model->IdToUserName($row['user_id']);
            $details["$i"]["full_name"] = $this->validation_model->getUserFullName($row['user_id']);
            $details["$i"]["user_id"] = $row['user_id'];

            $details["$i"]["invoice_no"] = $row['invoice_no'];
            $details["$i"]["order_date"] = $row['order_date'];
            $details["$i"]["amount"] = $row['total_amount'];
            $details["$i"]["payment_method"] = ucfirst($row['payment_method']);
            if ($row['payment_method'] == 'bank_transfer') {
                $details["$i"]['reciept'] = $this->getPaymentReciept($row['order_id']);
            }
            $details["$i"]["encrypt_order_id"] = $this->validation_model->encrypt($row['order_id']);
            $i++;
        }

        return $details;
    }
        public function updatePendingOrder($order_id) {

        $this->db->set('order_status', 'confirmed');
        $this->db->where('order_id', $order_id);
        $res1 = $this->db->update('repurchase_order');

        $this->db->set('order_status', 'confirmed');
        $this->db->where('order_id', $order_id);
        $res2 = $this->db->update('repurchase_order_details');

        if ($res1 && $res2) {
            return true;
        } else {
            return false;
        }
    }

    public function getPendingorderCount()
    {
        $this->db->where('order_status', 'pending');
        return $this->db->count_all_results('repurchase_order');
    }


    public function insertPaymentReciept($user_id, $orders_id, $doc_name) {

        $this->db->set('user_name', $this->validation_model->IdToUserName($user_id));
        $this->db->set('uploaded_date', date('Y-m-d H:i:s'));
        $this->db->set('reciept_name', $doc_name);
        $this->db->set('type', 'repurchase');
        $this->db->set('order_id', $orders_id);
        $res = $this->db->insert('payment_receipt');
        return $res;
    }

    public function getPaymentReciept($order_id)
    {
        $reciept = '';
        $this->db->select('reciept_name');
        $this->db->where('order_id', $order_id);
        $this->db->where('type', 'repurchase');
        $this->db->limit(1);
        $query = $this->db->get('payment_receipt');
        foreach ($query->result_array() as $row) {
            $reciept = $row['reciept_name'];
        }

        return $reciept;
    }

     public function getOrderDetailsById($order_id)
    {
        $details = [];
        $this->db->select('*');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get('repurchase_order_details');
         $i = 0;
        foreach ($query->result_array() as $row) {
            $details["$i"]["id"] = $row['product_id'];
            $details["$i"]["qty"] = $row['quantity'];
            $i++;
        }

        return $details;
    }

    public function updateRepurchaseOrderPV($order_id, $pv)
    {
        $this->db->set('total_pv', $pv);
        $this->db->where('order_id', $order_id);
        return $this->db->update('repurchase_order');
    }

}
