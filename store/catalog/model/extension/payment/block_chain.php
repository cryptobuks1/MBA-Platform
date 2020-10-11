<?php

class ModelExtensionPaymentBlockchain extends Model {

	
        public function getBlockchainInfo(){
           
            $query = $this->db->query("SELECT * FROM " . MLM_DB_PREFIX . "blockchain_config");
            if($query->row){
                return $query->row;
            }
        }
        
        
	 public function getMethod($address, $total) {
          
        $this->load->language('extension/payment/block_chain');

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int) $this->config->get('block_chain_geo_zone_id') . "' AND country_id = '" . (int) $address['country_id'] . "' AND (zone_id = '" . (int) $address['zone_id'] . "' OR zone_id = '0')");

       
        $status = true;

        $method_data = array();

        if ($status) {
            $method_data = array(
                'code' => 'block_chain',
                'title' => $this->language->get('text_title'),
                'terms' => '',
                'sort_order' => $this->config->get('block_chain_sort_order')
            );
        }
        
        return $method_data;
    }
    
    public function bitcoinHistory($user_id, $data, $purpose = '') {
        $date = date('Y-m-d H:i:s');
        $this->db->query("INSERT INTO " . MLM_DB_PREFIX . "bitcoin_history SET user_id = '" . $user_id . "', data = '" . json_encode($data) . "', purpose = '" . $purpose . "', status = 'no', date = '" . $date . "'");
        
        return $this->db->getLastId();
        
    }
    
     public function insertInToBitcoinPaymentDetails($bitcoin_id, $user_id, $purpose, $amount, $current_bitcoin_value, $paid_amount, $response_amount, $bitcoin_address, $transaction, $return_address, $pending_status = FALSE,$order_id) {
         
         $key = 'qwercvt132435@gfhfghvrt565';    
        $bitcoin_address_enc = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $bitcoin_address, MCRYPT_MODE_CBC, md5(md5($key))));
         $this->db->query("INSERT INTO " . MLM_DB_PREFIX . "bitcoin_payment_details SET bitcoin_history_id = '" . (int)$bitcoin_id . "', user_id = '" . $user_id . "', purpose = '" . $purpose . "', `amount` = '" . $amount . "', bitcoin_rate = '" . $current_bitcoin_value . "', bitcoin_amount_to_be_paid = '" . $paid_amount . "', paid_bitcoin_amount = '" . $response_amount. "', bitcoin_address = '" . $bitcoin_address_enc . "', transaction = '" . $transaction . "', return_address = '" . $return_address . "', pending_status = '" . $pending_status . "', date = '" .date('Y-m-d H:i:s'). "', order_id = '" .$order_id ."'");
      
        return $this->db->getLastId();
    }
    
     public function insertInToBitcoinPaymentProcessDetails($regr_data, $reason, $registrer) {
         
         $this->db->query("INSERT INTO " . MLM_DB_PREFIX . "bitcoin_payment_process_details SET registrer = '" . (int)$registrer . "', user_name = '" . $regr_data['user_name_entry'] . "', regr_data = '" . json_encode($regr_data) . "', reason = '" . $reason . "', date = '" . date('Y-m-d H:i:s') . "'");
        return $this->db->getLastId();
    }
    
    public function updateBitcoinHistory($user_id, $id, $status){
        	$res = $this->db->query("UPDATE `" . MLM_DB_PREFIX . "bitcoin_history` SET user_id = '" .$user_id . "', status = '" . $status . "' WHERE id = '" . $id . "'");
                return $res;
                
               
    }
    
    
    public function getUnpaidAddressCount() {
        $query = $this->db->query("SELECT `bitcoin_address` FROM `" . MLM_DB_PREFIX . "bitcoin_addresses` WHERE paid_status = 'no'");
        $count = count($query->row);
        return $count;
    }
    public function getUnpaidAddress() {
        $address = "";
        $query = $this->db->query("SELECT bitcoin_address FROM `" . MLM_DB_PREFIX . "bitcoin_addresses` WHERE paid_status='no' ORDER BY 'id' LIMIT 1");
        if ($query->row)
            $address = $query->row['bitcoin_address'];
        return $address;
    }
    public function getAvailableAddress() {
        $address = "";
        $query = $this->db->query("SELECT bitcoin_address FROM `" . MLM_DB_PREFIX . "bitcoin_addresses` WHERE paid_status='no' AND current_status = 'no' ORDER BY 'date'DESC LIMIT 1");
        if ($query->row)
            $address = $query->row['bitcoin_address'];
        return $address;
    }
    public function keepBitcoinAddress($address) {
        $date = date('Y-m-d H:i:s');
        $res = $this->db->query("INSERT INTO `" . MLM_DB_PREFIX . "bitcoin_addresses` (bitcoin_address,date) VALUES ('" . $address . "','" . $date . "')");
        return $res;
    }
    public function insertPaymentDetails($invoice_id, $address, $secret, $total_amount, $price_in_btc, $regr, $used_for = "",$order_id) {
        $date = date('Y-m-d H:i:s');
        $res = $this->db->query("INSERT INTO `" . MLM_DB_PREFIX . "blockchain_history` (invoice_id, payment_address, product_id, secret, amount_to_pay,total_btc,date_added,post_data,used_for) VALUES ('" . $invoice_id . "', '" . $address . "', '" . $order_id . "', '" . $secret . "', '" . $total_amount . "', '" . $price_in_btc . "', '" . $date . "', '" . json_encode($regr) . "', '" . $used_for . "')");
        return $res;
    }

    public function updateCallbackError($invoice_id, $error) {
        $res = $this->db->query("UPDATE `" . MLM_DB_PREFIX . "blockchain_history` SET call_back_error='" . $error . "' WHERE invoice_id='" . $invoice_id . "'");
        return $res;
    }
    
    public function getTransaction($invoice_id, $transaction_hash) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blockchain_history WHERE invoice_id = '" . $invoice_id . "' AND transaction_hash = '" . $transaction_hash . "'");

		return count($query->rows);
    }

    public function updateTransaction($invoice_id, $transaction_hash, $confirmations) {
        $res = $this->db->query("UPDATE `" . MLM_DB_PREFIX . "blockchain_history` SET confirmations='" . $confirmations . "' WHERE invoice_id='" . $invoice_id . "' AND transaction_hash = '" . $transaction_hash . "'");
        return $res;
    }
    public function addTransaction($invoice_id, $transaction_hash, $value, $confirmations, $response) {
        $res = $this->db->query("UPDATE `" . MLM_DB_PREFIX . "blockchain_history` SET value='" . $value . "',transaction_hash='" . $transaction_hash . "',json_response='" . $response . "' WHERE invoice_id='" . $invoice_id . "'");
        return $res;
    }
    public function keepRowAddressReponse($address, $invoice_id, $response, $hash, $used_for) {
        $date = date('Y-m-d H:i:s');
        $res = $this->db->query("INSERT INTO `" . MLM_DB_PREFIX . "rawaddr_response` (address, invoice_id, txn_hash, response, date,used_for) VALUES ('" . $address . "', '" . $invoice_id . "', '" . $hash . "', '" . json_encode($response) . "', '" . $date . "', '" . $used_for . "')");
        return $res;
    }
    public function updateBitcoinAddress($address, $status = "yes") {
        $res = $this->db->query("UPDATE `" . MLM_DB_PREFIX . "bitcoin_addresses` SET paid_status='" . $status . "' WHERE bitcoin_address='" . $address . "'");
        return $res;
    }
    public function getPaymentInfo($invoice_id) {
       $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blockchain_history WHERE invoice_id = '" . $invoice_id . "'");

		return $query->rows;
    }
    /*Blockchain Payment Method Ends*/
    public function getOrderTotal($order_id) {
        $query = $this->db->query("SELECT value FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int) $order_id . "' AND code = 'total'");

        return $query->row['value'];
    }
}
