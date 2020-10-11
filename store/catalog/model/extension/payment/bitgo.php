<?php

class ModelExtensionPaymentBitgo extends Model {

	
        public function getBitgoConfiguration(){
           
            $query = $this->db->query("SELECT * FROM " . MLM_DB_PREFIX . "bitgo_configuration WHERE mode = 'test'");
            if($query->num_rows){
                return $query->row;
            }
        }
        
        
	 public function getMethod($address, $total) {
          
        $this->load->language('extension/payment/bitgo');

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int) $this->config->get('blocktrail_geo_zone_id') . "' AND country_id = '" . (int) $address['country_id'] . "' AND (zone_id = '" . (int) $address['zone_id'] . "' OR zone_id = '0')");

        $status = true;

        $method_data = array();

        if ($status) {
            $method_data = array(
                'code' => 'bitgo',
                'title' => $this->language->get('text_title'),
                'terms' => '',
                'sort_order' => ''
            );
        }

        return $method_data;
    }
    public function upateBitGoStatus($h_id, $status) {
        $res = $this->db->query("UPDATE `" . MLM_DB_PREFIX . "bitgo_payment_history` SET status = '" . $status . "' WHERE id = '" . $h_id . "'");
                return $res;
    }
    public function upateRecievedResult($h_id, $result_arry, $recieved_amount, $bitcoin_payment) {
        $res = $this->db->query("UPDATE `" . MLM_DB_PREFIX . "bitgo_payment_history` SET recieved_result = '" . $result_arry . "', recieved_amount = '" . $recieved_amount . "', bitcoin_payment = '" . $bitcoin_payment . "' WHERE id = '" . $h_id . "'");
                return $res;
    }
    public function insertIntoBitGoPaymentHistory($user_id, $regr, $p_id, $send_amount, $pay_address, $address_result,$wallet_id, $type = 'opencart_purchase') {
        
        $this->db->query("INSERT INTO " . MLM_DB_PREFIX . "bitgo_payment_history SET user_id = '" . $user_id . "', regr = '" . $regr . "', product_id = '" . $p_id . "', send_amount = '" . $send_amount . "', pay_address = '" . $pay_address . "', address_result = '" . $address_result . "', date = '" . date('Y-m-d H:i:s') . "', type = '" . $type . "', wallet_id = '" . $wallet_id . "'");
        return $this->db->getLastId();
    }
    public function getPaymentInfo($user_id, $p_id,$wallet_id) {
    
        $query = $this->db->query("SELECT * FROM `" . MLM_DB_PREFIX . "bitgo_payment_history` WHERE user_id='" . $user_id . "' AND product_id = '" . $p_id . "' AND wallet_id = '" . $wallet_id . "' LIMIT 1");
        return $query;
    }
}