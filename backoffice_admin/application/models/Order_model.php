<?php

class order_model extends inf_model {

    public function __construct() {
        $this->load->model('validation_model');
        $this->oc_prefix = $this->db->ocprefix;
    }

    public function getCurrentOrderHistoryDetails($customer_id, $order_id = '') {
        $order_details = array();

        $this->db->select('o.*');
        $this->db->from("oc_order as o");
        $this->db->join("oc_order_history as oh", "o.order_id=oh.order_id ", "INNER");
        $this->db->where("oh.order_status_id >=", 1);
        $this->db->where("o.customer_id", $customer_id);
        if ($order_id != '') {
            $this->db->where("o.order_id", $order_id);
        }
        $this->db->group_by('o.order_id');
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $order_details[$i]['date_added'] = date('Y/m/d', strtotime($row['date_added']));
            $order_details[$i]['order_id'] = $row['order_id'];
            $order_details[$i]['order_id_with_prefix'] = str_pad($row['order_id'], 7, 0, STR_PAD_LEFT);
            $order_details[$i]['firstname'] = $row['firstname'];
            $order_details[$i]['lastname'] = $row['lastname'];
            $order_details[$i]['customer_name'] = $row['firstname'] . ' ' . $row['lastname'];
            $order_details[$i]['fullname'] = $row['firstname'] . ' ' . $row['lastname'];
            $order_details[$i]['total'] = $row['total'];

            $order_products = $this->getOrderProductDetails($row['order_id']);
            $order_details[$i]['products'] = $order_products;

            $quantity = '';
            $model = '';
            foreach ($order_products AS $product) {
                $quantity .= $product['quantity'] . "<br>";
                $model .= $product['model'] . "<br>";
            }
            $order_details[$i]['quantity'] = $quantity;
            $order_details[$i]['model'] = $model;

            $order_details[$i]['shipping_method'] = $row['shipping_method'];
            $order_details[$i]['shipping_firstname'] = $row['shipping_firstname'];
            $order_details[$i]['shipping_lastname'] = $row['shipping_lastname'];
            $order_details[$i]['shipping_address_1'] = $row['shipping_address_1'];
            $order_details[$i]['shipping_city'] = $row['shipping_city'];
            $order_details[$i]['shipping_zone'] = $row['shipping_zone'];
            $order_details[$i]['shipping_country'] = $row['shipping_country'];
            $order_details[$i]['payment_firstname'] = $row['payment_firstname'];
            $order_details[$i]['payment_lastname'] = $row['payment_lastname'];
            $order_details[$i]['payment_address_1'] = $row['payment_address_1'];
            $order_details[$i]['payment_city'] = $row['payment_city'];
            $order_details[$i]['payment_country'] = $row['payment_country'];
            $order_details[$i]['shipping_method'] = $row['shipping_method'];
            $order_details[$i]['payment_zone'] = $row['payment_zone'];

            $order_details[$i]['order_total'] = $this->getOrderTotalDetails($row['order_id']);
            $i = $i + 1;
        }

        return $order_details;
    }

    public function getOrderProductDetails($order_id) {
        $details = array();
        $i = 0;
        $this->db->from('oc_order_product');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $details[$i] = $row;
            $i++;
        }

        return $details;
    }

    public function getOrderTotalDetails($order_id) {
        $order_details = array();
        $this->db->select('title,code,value');
        $this->db->from('oc_order_total');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $order_details[$i]['code'] = $row['code'];
            $order_details[$i]['value'] = $row['value'];
            $order_details[$i]['title'] = $row['title'];
            $i = $i + 1;
        }
        return $order_details;
    }

    public function checkOrderExist($order_id) {
        $count = 0;
        $this->db->from('oc_order');
        $this->db->where('order_id', $order_id);
        $count = $this->db->count_all_results();
        if ($count > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getCustomerIdFromOrder($order_id) {
        $customer_id = 0;
        $this->db->select('customer_id');
        $this->db->from('oc_order');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $customer_id = $row->customer_id;
        }
        return $customer_id;
    }

    public function getOrderHistoryCount($customer_id = '') {
        $this->db->where("order_status_id >=", 1);
        if ($customer_id) {
            $this->db->where("customer_id", $customer_id);
        }
        return $this->db->count_all_results('oc_order');
    }

    public function getOrderDetails($page = '', $limit = '', $customer_id = '', $from_date='', $to_date='') {
        $order_details = array();

        $date = date("Y-m-d H:i:s");
         if (!isset($to_date) || trim($to_date) === '') {
            $to_date = $date;
        } else {
            if ($to_date != '') {
                $to_date = $to_date . " 23:59:59";
            }
        }
        if ($from_date != '') {
            $from_date = $from_date . " 00:00:00";
        } else {
            $from_date = '';
        }
        
        
        $this->db->select('o.*');
        $this->db->from("oc_order as o");
        $this->db->join("oc_order_history as oh", "o.order_id=oh.order_id ", "INNER");
        $this->db->where("oh.order_status_id >=", 1);
        if ($limit) {
            $this->db->limit($limit, $page);
        }
        if ($customer_id != '') {
            $this->db->where("o.customer_id", $customer_id);
        }
        if ($from_date != '') {
            $this->db->where("o.date_added >=", $from_date);
        }
        if ($to_date != '') {
            $this->db->where("o.date_added <=", $to_date);
        } 
        $this->db->group_by('o.order_id');
        $this->db->order_by('date_added', 'desc');
        $query = $this->db->get();//echo $this->db->last_query(); die;

        $i = 0;
        foreach ($query->result_array() as $row) {
            $order_details[$i]['date_added'] = date('Y/m/d', strtotime($row['date_added']));
            $order_details[$i]['order_id'] = $row['order_id'];
            $order_details[$i]['order_id_with_prefix'] = str_pad($row['order_id'], 7, 0, STR_PAD_LEFT);
            $order_details[$i]['firstname'] = $row['firstname'];
            $order_details[$i]['lastname'] = $row['lastname'];
            $order_details[$i]['customer_name'] = $row['firstname'] . ' ' . $row['lastname'];
            $order_details[$i]['total'] = $row['total'];
            $user_id = $this->validation_model->getUserIDFromCustomerID($row['customer_id']);
            $user_name = $this->validation_model->IdToUserName($user_id);
            $order_products = $this->getOrderProductDetails($row['order_id']);
            $order_details[$i]['products'] = $order_products;
            $order_details[$i]['user_name'] = $user_name;
            $quantity = '';
            $model = '';
            $pair_value = '';
            $total_pair_value = '';
            $price = array();
            $total_price = array();
            $j = 0;
            foreach ($order_products AS $product) {
                $quantity .= $product['quantity'] . "<br>";
                $model .= $product['model'] . "<br>";
                $pair_value .= $product['pair_value'] . "<br>";
                $total_pair_value .= $product['pair_value'] * $product['quantity'] . "<br>";
                $price[$j] = $product['price'] . "<br>";
                $total_price[$j] = $product['price'] * $product['quantity'] . "<br>";
                $j++;
            }
            $order_details[$i]['quantity'] = $quantity;
            $order_details[$i]['model'] = $model;
            $order_details[$i]['pair_value'] = $pair_value;
            $order_details[$i]['total_pair_value'] = $total_pair_value;
            $order_details[$i]['price'] = $price;
            $order_details[$i]['total_price'] = $total_price;
            if ($row['shipping_method'] != '') {
                $order_details[$i]['shipping_method'] = $row['shipping_method'];
            } else {
                $order_details[$i]['shipping_method'] = "NA";
            }
            $order_details[$i]['shipping_firstname'] = $row['shipping_firstname'];
            $order_details[$i]['shipping_lastname'] = $row['shipping_lastname'];
            $order_details[$i]['shipping_address_1'] = $row['shipping_address_1'];
            $order_details[$i]['shipping_address_1'] = $row['shipping_address_1'];
            $order_details[$i]['shipping_city'] = $row['shipping_city'];
            $order_details[$i]['shipping_zone'] = $row['shipping_zone'];
            $order_details[$i]['shipping_country'] = $row['shipping_country'];
            $order_details[$i]['payment_firstname'] = $row['payment_firstname'];
            $order_details[$i]['payment_lastname'] = $row['payment_lastname'];
            $order_details[$i]['payment_address_1'] = $row['payment_address_1'];
            $order_details[$i]['payment_city'] = $row['payment_city'];
            $order_details[$i]['payment_country'] = $row['payment_country'];
            $order_details[$i]['payment_zone'] = $row['payment_zone'];
            $order_details[$i]['order_total'] = $this->getOrderTotalDetails($row['order_id']);
            $i = $i + 1;
        }
        return $order_details;
    }

    function getPendingRegDetailsCount($user_id="") {
        $this->db->select('*');
        if($user_id){
            $this->db->where('user_id', $user_id);
        }
        $this->db->where('status', "pending");
        $res = $this->db->get('oc_temp_registration');
        return $res->num_rows();
    }

    function getPendingRegStatus($order_id) {
        $status = "";
        $this->db->select('status');
        $this->db->where('id', $order_id);
        $res = $this->db->get('oc_temp_registration');
        foreach ($res->result_array() as $row) {
            $status = $row['status'];
        }
        return $status;
    }

    function getPendingRegDetails($page, $limit=10, $user_id,$order_id="") {
        $details = array();

        $this->db->select('*');
        $this->db->limit($limit, $page);
        if($user_id){
            $this->db->where('user_id', $user_id);
        }
        if($order_id){
            $this->db->where('id', $order_id);
        }
        $this->db->where('status', "pending");
        $res = $this->db->get('oc_temp_registration');
        $this->load->model('product_model');
        foreach ($res->result_array() as $row) {
            $data = unserialize($row['reg_data']);
            $compained_data = array_merge($data['customer_data'],$data['reg_data']);
            $compained_data["row_id"] =  $row["id"];
            $compained_data["status"] =  $row["status"];
            $compained_data["date_added"] =  $row["date"];
            $product_detail =  $this->product_model->getProductDetails($compained_data["product_id"]);
            $compained_data["product_name"] =  $product_detail[0]["product_name"];
            $details[] = $compained_data;
        }
        return $details;
    }

    public function updateOrderCustomer($order_id, $customer_id) {
        $this->db->set('customer_id', $customer_id);
        $this->db->where('order_id', $order_id);
        return $this->db->update('oc_order');
    }

    public function getCustomerGroup($customer_group_id) {
        $this->db->distinct();
        $this->db->from('oc_customer_group cg');
        $this->db->join('oc_customer_group_description cgd', 'cg.customer_group_id = cgd.customer_group_id', 'left');
        $this->db->where('cg.customer_group_id', (int)$customer_group_id);
        $this->db->where('cgd.language_id', 1);
        $query = $this->db->get();

        $data = $query->result_array();
        if(count($data)){
            return $data[0];
        }else{
            $data=array();
            $data['customer_group_id']=1;
            $data['approval']=0;
            return $data; 
        }
    }

    public function addCustomer($data) {
        $customer_group_id = $data['customer_group_id'];


        $customer_group_info = $this->getCustomerGroup($customer_group_id);
        $salt = $data['salt'];
        $this->db->set('store_id', (int)$data['config_store_id']);
        $this->db->set('language_id', (int)$data['config_language_id']);
        $this->db->set('firstname', $data['firstname']);
        $this->db->set('lastname', $data['lastname']);
        $this->db->set('email', $data['email']);
        $this->db->set('telephone', $data['telephone']);
        $this->db->set('fax',  $data['fax']);
        $this->db->set('custom_field', isset($data['custom_field']['account']) ? json_encode($data['custom_field']['account']) : '');
        $this->db->set('salt',  $data['salt']);//
        $this->db->set('password',  sha1($salt . sha1($salt . sha1($data['password']))));//
        // $this->db->set('password',  md5($data['password']));//
        $this->db->set('newsletter', (isset($data['newsletter']) ? (int)$data['newsletter'] : 0));
        $this->db->set('ip',  $data['ip']);//
        $this->db->set('status', '1');
        $this->db->set('approved', (int)!$customer_group_info['approval']);
        $this->db->set('date_added', 'NOW()', FALSE);
        $this->db->insert('oc_customer');
        $customer_id = $this->db->insert_id();

        $this->db->set('customer_id', (int)$customer_id);
        $this->db->set('firstname', $data['firstname']);
        $this->db->set('lastname', $data['lastname']);
        $this->db->set('company', $data['company']);
        $this->db->set('address_1', $data['address_1']);
        $this->db->set('address_2', $data['address_2']);
        $this->db->set('city', $data['city']);
        $this->db->set('postcode', $data['postcode']);
        $this->db->set('country_id', (int)$data['country_id']);
        $this->db->set('zone_id', (int)$data['zone_id']);
        $this->db->set('custom_field', isset($data['custom_field']['address']) ? json_encode($data['custom_field']['address']) : '');
        $this->db->insert('oc_address');

        $address_id = $this->db->insert_id();

        $this->db->set('address_id', (int)$address_id);
        $this->db->where('customer_id', (int)$customer_id);
        $this->db->update('oc_customer');
        
        return $customer_id;

        $this->db->set('customer_id', (int)$customer_id);
        $this->db->where('order_id', (int)$data['order_id']);
        $this->db->update('oc_order');

    }

    public function addActivity($key, $data) {
        if (isset($data['customer_id'])) {
            $customer_id = $data['customer_id'];
        } else {
            $customer_id = 0;
        }

        $this->db->set('customer_id', (int)$customer_id);
        $this->db->set('key', $key);
        $this->db->set('data', json_encode($data));
        $this->db->set('ip', $data['ip']);
        $this->db->set('date_added', 'NOW()', FALSE);
        $this->db->insert('oc_customer_activity');
    }


    public function getCustomer($customer_id) {
        $query = array();
        $this->db->where('customer_id', (int)$customer_id);
        $querys = $this->db->get('oc_customer');
        foreach ($querys->result_array() as $row) {
            $query = $row;
        }
        return $query;
    }

    public function getAffiliate($affiliate_id) {
        $query = array();
        $this->db->where('affiliate_id', (int)$affiliate_id);
        $querys = $this->db->get('oc_affiliate');

        foreach ($querys->result_array() as $row) {
            $query = $row;
        }
        return $query;
    }
    public function addTransaction($affiliate_id, $amount = '', $order_id = 0) {
        $affiliate_info = $this->getAffiliate($affiliate_id);

        if ($affiliate_info) {
            $this->db->set('affiliate_id', (int)$affiliate_id);
            $this->db->set('order_id', (float)$order_id);
            $this->db->set('description', $this->language->get('text_order_id') . ' #' . $order_id);
            $this->db->set('amount', (float)$amount);
            $this->db->set('date_added', 'NOW()', FALSE);
            $this->db->insert('oc_affiliate_transaction');
            
            $affiliate_transaction_id = $this->db->insert_id();

            return $affiliate_transaction_id;
        }
    }

    public function getLanguage($language_id) {
        $this->db->where('language_id', (int)$language_id);
        $querys = $this->db->get('oc_language');

        foreach ($querys->result_array() as $row) {
            $query = $row;
        }
        return $query;
    }

    public function getConfig($key) {

        $this->db->where('key', $key);
        $configs_query = $this->db->get('oc_setting');

        foreach ($configs_query->result_array() as $row) {
            $config_query = $row;
        }

        if (!$config_query['serialized']) {
            $config_query['value'] = $result['value'];
        } else {
            $config_query['value'] = json_decode($config_query['value'], true);
        }
        return (($config_query["value"]) ? $config_query["value"] : null);
    }
    public function addOrderHistory($order_id, $order_status_id, $comment = '', $notify = false, $override = false) {
        $order_info = $this->getOrder($order_id);

        $customer_info = $this->getCustomer($order_info['customer_id']);

        if ($customer_info && $customer_info['safe']) {
            $safe = true;
        } else {
            $safe = false;
        }
    // If current order status is not processing or complete but new status is processing or complete then commence completing the order
        if (!in_array($order_info['order_status_id'], array_merge($this->getConfig('config_processing_status'), $this->getConfig('config_complete_status'))) && in_array($order_status_id, array_merge($this->getConfig('config_processing_status'), $this->getConfig('config_complete_status')))) {
                // Redeem coupon, vouchers and reward points
            
            $this->db->where('order_id', (int)$order_id);
            $this->db->order_by('sort_order', 'ASC');
            $order_total_query = $this->db->get('oc_order_total');

                // Add commission if sale is linked to affiliate referral.
            if ($order_info['affiliate_id'] && $this->getConfig('config_affiliate_auto')) { 
                $this->addTransaction($order_info['affiliate_id'], $order_info['commission'], $order_id);
            }

                // Stock subtraction
            $this->db->where('order_id', (int)$order_id);
            $orders_product_query = $this->db->get('oc_order_product');

            $order_product_query = array();
            foreach ($orders_product_query->result_array() as $row) {
                $order_product_query[] = $row;
            }

            foreach ($order_product_query as $order_product) {
                $this->db->set('quantity', 'quantity - ' . (int)$order_product['quantity'], FALSE);
                $this->db->where('product_id', (int)$order_product['product_id']);
                $this->db->where('subtract', '1');
                $this->db->update('oc_product');
                
                $this->db->where('order_id', (int)$order_id);
                $this->db->where('order_product_id', (int)$order_product['order_product_id']);
                $orders_option_query = $this->db->get('oc_order_option');
                
                $order_option_query = array();
                foreach ($orders_option_query->result_array() as $row) {
                    $order_option_query[] = $row;
                }
                foreach ($order_option_query as $option) {
                    $this->db->set('quantity', 'quantity - ' . (int)$order_product['quantity'], FALSE);
                    $this->db->where('product_option_value_id', (int)$option['product_option_value_id']);
                    $this->db->where('subtract', '1');
                    $this->db->update('oc_product_option_value');
                }
            }

            // Update the DB with the new statuses
              $this->db->set('confirm_date', 'NOW()', FALSE);
              $this->db->set('order_status', 'confirmed');
            $this->db->set('order_status_id', (int)$order_status_id);
            $this->db->set('view_status', 1);
            $this->db->set('date_modified', 'NOW()', FALSE);
            $this->db->where('order_id', (int)$order_id);
            $this->db->update('oc_order');
            
            $this->db->set('order_id', (int)$order_id);
            $this->db->set('order_status_id', (int)$order_status_id);
            $this->db->set('notify', (int)$notify);
            $this->db->set('comment', $comment);
            $this->db->set('date_added', 'NOW()', FALSE);
            $this->db->where('order_id', (int)$order_id);
            $this->db->update('oc_order_history');

            // If old order status is the processing or complete status but new status is not then commence restock, and remove coupon, voucher and reward history
            if (in_array($order_info['order_status_id'], array_merge($this->getConfig('config_processing_status'), $this->getConfig('config_complete_status'))) && !in_array($order_status_id, array_merge($this->getConfig('config_processing_status'), $this->getConfig('config_complete_status')))) {
                // Restock
                $this->db->where('order_id', (int)$order_id);
                $products_query = $this->db->get('oc_order_product');

                $product_query = array();
                foreach ($products_query->result_array() as $row) {
                    $product_query[] = $row;
                }

                foreach($product_query->rows as $product) {
                    $this->db->set('quantity', 'quantity + ' . (int)$product['quantity'], FALSE);
                    $this->db->where('product_id', (int)$product['product_id']);
                    $this->db->where('subtract', '1');
                    $this->db->update('oc_product');
                    
                    $this->db->where('order_id', (int)$order_id);
                    $this->db->where('order_product_id', (int)$product['order_product_id']);
                    $options_query = $this->db->get('oc_order_option');
                    
                    $option_query = array();
                    foreach ($options_query->result_array() as $row) {
                        $option_query[] = $row;
                    }

                    foreach ($option_query->rows as $option) {
                        
                        $this->db->set('quantity', 'quantity + ' . (int)$product['quantity'], FALSE);
                        $this->db->where('product_option_value_id', (int)$option['product_option_value_id']);
                        $this->db->where('subtract', '1');
                        $this->db->update('oc_product_option_value');
                    }
                }


                // Remove commission if sale is linked to affiliate referral.
                if ($order_info['affiliate_id']) { 

                    $this->model_affiliate_affiliate->deleteTransaction($order_id);
                }
            }
        }
    }

    public function deleteTransaction($order_id) {
        $this->db->query("DELETE FROM " . $this->oc_prefix . "affiliate_transaction WHERE order_id = '" . (int)$order_id . "'");
    }

    public function getOrder($order_id) {

        $this->db->select('o.*,os.name');
        $this->db->from('oc_order o');
        $this->db->join('oc_order_status os', 'o.order_status_id = os.order_status_id AND o.language_id = os.language_id');
        $this->db->where('o.order_id', (int)$order_id);
        $orders_query = $this->db->get();

        foreach ($orders_query->result_array() as $row) {
            $order_query = $row;
        }

        if ($orders_query->num_rows()) {
            $this->db->where('country_id', (int)$order_query['payment_country_id']);
            $countrys_query = $this->db->get('oc_country`');

            if ($countrys_query->num_rows()) {
                foreach ($countrys_query->result_array() as $row) {
                    $country_query = $row;
                }

                $payment_iso_code_2 = $country_query['iso_code_2'];
                $payment_iso_code_3 = $country_query['iso_code_3'];
            } else {
                $payment_iso_code_2 = '';
                $payment_iso_code_3 = '';
            }

            $this->db->where('zone_id', (int)$order_query['payment_zone_id']);
            $zones_query = $this->db->get('oc_zone`');

            if ($zones_query->num_rows()) {
                foreach ($zones_query->result_array() as $row) {
                    $zone_query = $row;
                }
                $payment_zone_code = $zone_query['code'];
            } else {
                $payment_zone_code = '';
            }


            $this->db->where('country_id', (int)$order_query['shipping_country_id']);
            $countrys_query = $this->db->get('oc_country`');

            if ($countrys_query->num_rows()) {
                foreach ($countrys_query->result_array() as $row) {
                    $country_query = $row;
                }
                $shipping_iso_code_2 = $country_query['iso_code_2'];
                $shipping_iso_code_3 = $country_query['iso_code_3'];
            } else {
                $shipping_iso_code_2 = '';
                $shipping_iso_code_3 = '';
            }

            $this->db->where('zone_id', (int)$order_query['shipping_zone_id']);
            $zones_query = $this->db->get('oc_zone`');

            if ($zones_query->num_rows()) {
                foreach ($zones_query->result_array() as $row) {
                    $zone_query = $row;
                }
                $shipping_zone_code = $zone_query['code'];
            } else {
                $shipping_zone_code = 'en_US';
            }


            $language_info = $this->getLanguage($order_query['language_id']);

            if ($language_info) {
                $language_code = $language_info['code'];
            } else {
                $language_code = 'en_US';
            }
            return array(
                'order_id'                => $order_query['order_id'],
                'invoice_no'              => $order_query['invoice_no'],
                'invoice_prefix'          => $order_query['invoice_prefix'],
                'store_id'                => $order_query['store_id'],
                'store_name'              => $order_query['store_name'],
                'store_url'               => $order_query['store_url'],
                'customer_id'             => $order_query['customer_id'],
                'firstname'               => $order_query['firstname'],
                'lastname'                => $order_query['lastname'],
                'email'                   => $order_query['email'],
                'telephone'               => $order_query['telephone'],
                'fax'                     => $order_query['fax'],
                'custom_field'            => json_decode($order_query['custom_field'], true),
                'payment_firstname'       => $order_query['payment_firstname'],
                'payment_lastname'        => $order_query['payment_lastname'],
                'payment_company'         => $order_query['payment_company'],
                'payment_address_1'       => $order_query['payment_address_1'],
                'payment_address_2'       => $order_query['payment_address_2'],
                'payment_postcode'        => $order_query['payment_postcode'],
                'payment_city'            => $order_query['payment_city'],
                'payment_zone_id'         => $order_query['payment_zone_id'],
                'payment_zone'            => $order_query['payment_zone'],
                'payment_zone_code'       => $payment_zone_code,
                'payment_country_id'      => $order_query['payment_country_id'],
                'payment_country'         => $order_query['payment_country'],
                'payment_iso_code_2'      => $payment_iso_code_2,
                'payment_iso_code_3'      => $payment_iso_code_3,
                'payment_address_format'  => $order_query['payment_address_format'],
                'payment_custom_field'    => json_decode($order_query['payment_custom_field'], true),
                'payment_method'          => $order_query['payment_method'],
                'payment_code'            => $order_query['payment_code'],
                'shipping_firstname'      => $order_query['shipping_firstname'],
                'shipping_lastname'       => $order_query['shipping_lastname'],
                'shipping_company'        => $order_query['shipping_company'],
                'shipping_address_1'      => $order_query['shipping_address_1'],
                'shipping_address_2'      => $order_query['shipping_address_2'],
                'shipping_postcode'       => $order_query['shipping_postcode'],
                'shipping_city'           => $order_query['shipping_city'],
                'shipping_zone_id'        => $order_query['shipping_zone_id'],
                'shipping_zone'           => $order_query['shipping_zone'],
                'shipping_zone_code'      => $shipping_zone_code,
                'shipping_country_id'     => $order_query['shipping_country_id'],
                'shipping_country'        => $order_query['shipping_country'],
                'shipping_iso_code_2'     => $shipping_iso_code_2,
                'shipping_iso_code_3'     => $shipping_iso_code_3,
                'shipping_address_format' => $order_query['shipping_address_format'],
                'shipping_custom_field'   => json_decode($order_query['shipping_custom_field'], true),
                'shipping_method'         => $order_query['shipping_method'],
                'shipping_code'           => $order_query['shipping_code'],
                'comment'                 => $order_query['comment'],
                'total'                   => $order_query['total'],
                'order_status_id'         => $order_query['order_status_id'],
        //      'order_status'            => $order_query['order_status'],
                'affiliate_id'            => $order_query['affiliate_id'],
                'commission'              => $order_query['commission'],
                'language_id'             => $order_query['language_id'],
                'language_code'           => $language_code,
                'currency_id'             => $order_query['currency_id'],
                'currency_code'           => $order_query['currency_code'],
                'currency_value'          => $order_query['currency_value'],
                'ip'                      => $order_query['ip'],
                'forwarded_ip'            => $order_query['forwarded_ip'],
                'user_agent'              => $order_query['user_agent'],
                'accept_language'         => $order_query['accept_language'],
                'date_added'              => $order_query['date_added'],
                'date_modified'           => $order_query['date_modified']
                );
        } else {
            return false;
        }
    }

    public function updateRegOrdeStatus($order_id, $status) {
        $this->db->set('status', $status);
        $this->db->where('id', $order_id);
        $query = $this->db->update("oc_temp_registration");
        return $query;
    }

    public function regOrderActivationHistory($user_id, $serialized_data,$action) {
        $date = date("Y-m-d H:i:s");
        $this->db->set('status', $action);
        $this->db->set('user_id', $user_id);
        $this->db->set('reg_data', $serialized_data);
        $this->db->set('date', $date);
        $query = $this->db->insert("oc_reg_order_activation_history");
        return $query;
    }

    public function getOrderNotificationCount() {
        $this->db->where("view_status", 1);
        return $this->db->count_all_results('oc_order');
    }

    public function getOrderNotification($page = '', $limit = '', $customer_id = '') {
        $order_details = array();

        $this->db->select('o.order_id,o.customer_id,o.date_added');
        $this->db->from("oc_order as o");
        $this->db->where("view_status", 1);
        if ($limit) {
            $this->db->limit($limit, $page);
        }
        if ($customer_id != '') {
            $this->db->where("o.customer_id", $customer_id);
        }
        $this->db->order_by('date_added', 'desc');
        $query = $this->db->get();

        $i = 0;
        foreach ($query->result_array() as $row) {
            $order_details[$i]['date_added'] = date("F j, g:i", strtotime($row['date_added']));
            $order_details[$i]['order_id'] = $row['order_id'];
            $user_id = $this->validation_model->getUserIDFromCustomerID($row['customer_id']);
            $user_name = $this->validation_model->IdToUserName($user_id);
            $order_details[$i]['user_name'] = $user_name;
            $i = $i + 1;
        }
        return $order_details;
    }

    public function setViewStatus($order_id = '') {
        $this->db->set('view_status', 0);
        if ($order_id)
            $this->db->where('order_id', $order_id);
        else
            $this->db->where('view_status', 1);
        $query = $this->db->update("oc_order");
        return $query;
    }

    public function updateCustomerId($user_id, $customer_id) {
        $this->db->set('oc_customer_ref_id', $customer_id);
        $this->db->where('id', $user_id);
        return $this->db->update('ft_individual');
    }

    public function updateRegPending($id, $user_id, $payment_method)
    {
        $res = true;
        switch ($payment_method) {
            case 'E-wallet':
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
            default:
                break;
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

        return $res && $res3;
    }
public function addorder($order_id){
     $this->db->set('order_id', (int)$order_id);
            $this->db->set('order_status_id', 5);
            $this->db->set('notify', 1);
            $this->db->set('comment', 'text_payment');
            $this->db->set('date_added', 'NOW()', FALSE);
            $this->db->insert('oc_order_history');
}
public function updateOrder($order_id,$cust_id){
            $this->db->set('customer_id',$cust_id);
            $this->db->set('order_status_id', 5);
            $this->db->where('order_id', $order_id);
            $res3 = $this->db->update('oc_order');
}

function getPendingPurchaseDetailsCount() {
    $payment_codes = array('cod','bank_transfer');
        $this->db->select('*');
	    $this->db->where('order_status_id',1);
	    $this->db->where('order_status','pending');
	    $this->db->where('order_type','purchase');
	    $this->db->where('customer_id !=',0);
	    $this->db->where_in('payment_code',$payment_codes);
        $res = $this->db->get('oc_order');
        return $res->num_rows();
    }
function getPendingPurchaseStatus($id) {
        $status='';
        $this->db->select('order_status_id');
        $this->db->where('order_id',$id);
        $res = $this->db->get('oc_order');
        foreach ($res->result_array() as $row) {
            $status = $row['order_status_id'];
        }
        return $status;
    }
     function getPendingPurchaseDetails($page, $limit=10,$id='') {
        $order_details = array();
        $payment_codes = array('cod','bank_transfer');
        $this->db->select('o.*');
        $this->db->from("oc_order as o");
        $this->db->join("oc_order_history as oh", "o.order_id=oh.order_id ", "INNER");
        $this->db->where("o.order_status_id =", 1);
        $this->db->where('o.order_status','pending');
        $this->db->where('o.order_type','purchase');
        $this->db->where('o.customer_id !=',0);
        $this->db->where_in('o.payment_code',$payment_codes);
        if ($limit) {
            $this->db->limit($limit, $page);
        }
        
        $this->db->group_by('o.order_id');
        $this->db->order_by('date_added', 'desc');
        $query = $this->db->get();

        $i = 0;
        foreach ($query->result_array() as $row) {
            $order_details[$i]['date_added'] = date('Y/m/d', strtotime($row['date_added']));
            $order_details[$i]['order_id'] = $row['order_id'];
            $order_details[$i]['order_id_with_prefix'] = str_pad($row['order_id'], 7, 0, STR_PAD_LEFT);
            $order_details[$i]['firstname'] = $row['firstname'];
            $order_details[$i]['lastname'] = $row['lastname'];
            $order_details[$i]['full_name'] = $row['firstname'] . ' ' . $row['lastname'];
            $order_details[$i]['total'] = $row['total'];
            $user_id = $this->validation_model->getUserIDFromCustomerID($row['customer_id']);
            $user_name = $this->validation_model->IdToUserName($user_id);
            $order_products = $this->getOrderProductDetails($row['order_id']);
            $order_details[$i]['user_id'] = $user_id;
            $order_details[$i]['products'] = $order_products;
            $order_details[$i]['user_name'] = $user_name;
            $quantity = '';
            $model = '';
            $pair_value = '';
            $total_pair_value = '';
            $price = array();
            $total_price = array();
            $j = 0;
            foreach ($order_products AS $product) {
                $quantity .= $product['quantity'] . "<br>";
                $model .= $product['model'] . "<br>";
                $pair_value .= $product['pair_value'] . "<br>";
                $total_pair_value .= $product['pair_value'] * $product['quantity'] . "<br>";
                $price[$j] = $product['price'] . "<br>";
                $total_price[$j] = $product['price'] * $product['quantity'] . "<br>";
                $j++;
            }
            $order_details[$i]['quantity'] = $quantity;
            $order_details[$i]['model'] = $model;
            $order_details[$i]['pair_value'] = $pair_value;
            $order_details[$i]['total_pair_value'] = $total_pair_value;
            $order_details[$i]['price'] = $price;
            $order_details[$i]['total_price'] = $total_price;
            if ($row['shipping_method'] != '') {
                $order_details[$i]['shipping_method'] = $row['shipping_method'];
            } else {
                $order_details[$i]['shipping_method'] = "NA";
            }
            $order_details[$i]['shipping_firstname'] = $row['shipping_firstname'];
            $order_details[$i]['shipping_lastname'] = $row['shipping_lastname'];
            $order_details[$i]['shipping_address_1'] = $row['shipping_address_1'];
            $order_details[$i]['shipping_address_1'] = $row['shipping_address_1'];
            $order_details[$i]['shipping_city'] = $row['shipping_city'];
            $order_details[$i]['shipping_zone'] = $row['shipping_zone'];
            $order_details[$i]['shipping_country'] = $row['shipping_country'];
            $order_details[$i]['payment_firstname'] = $row['payment_firstname'];
            $order_details[$i]['payment_lastname'] = $row['payment_lastname'];
            $order_details[$i]['payment_address_1'] = $row['payment_address_1'];
            $order_details[$i]['payment_city'] = $row['payment_city'];
            $order_details[$i]['payment_country'] = $row['payment_country'];
            $order_details[$i]['payment_zone'] = $row['payment_zone'];
            $order_details[$i]['order_total'] = $this->getOrderTotalDetails($row['order_id']);
            $i = $i + 1;
        }
        return $order_details;
    }
    
    public function setConfirmOrder($order_id) {
        $this->db->set('order_status_id', 5);
        $this->db->set('confirm_date', 'NOW()', FALSE);
        $this->db->set('order_status','complete');
        $this->db->where('order_id', $order_id);
        $res = $this->db->update('oc_order');
        if($res){
            $this->db->set('order_id', $order_id);
            $this->db->set('order_status_id',5);
            $this->db->set('date_added', 'NOW()', FALSE);
            $this->db->insert('oc_order_history');
        }
    }
}
