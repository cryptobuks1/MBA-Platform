<?php

class ModelExtensionPaymentBlocktrail extends Model {

    private $bitpay;

    

        public function getBlockTrailConfig(){
           
            $query = $this->db->query("SELECT * FROM " . MLM_DB_PREFIX . "bitcoin_configuration");
            if($query->num_rows){
                return $query->row;
            }
        }
        
        
     public function getMethod($address, $total) {
          
        $this->load->language('extension/payment/blocktrail');

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int) $this->config->get('blocktrail_geo_zone_id') . "' AND country_id = '" . (int) $address['country_id'] . "' AND (zone_id = '" . (int) $address['zone_id'] . "' OR zone_id = '0')");

        if ($this->config->get('blocktrail_total') > 0 && $this->config->get('blocktrail_total') > $total) {
            $status = false;
        } elseif (!$this->config->get('blocktrail_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }

        $method_data = array();

        if ($status) {
            $method_data = array(
                'code' => 'blocktrail',
                'title' => $this->language->get('text_title'),
                'terms' => '',
                'sort_order' => $this->config->get('blocktrail_sort_order')
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
         $pending_id = 'NULL';
        $bitcoin_address_enc = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $bitcoin_address, MCRYPT_MODE_CBC, md5(md5($key))));
         $this->db->query("INSERT INTO " . MLM_DB_PREFIX . "bitcoin_payment_details SET bitcoin_history_id = '" . (int)$bitcoin_id . "', user_id = '" . $user_id . "', purpose = '" . $purpose . "', `amount` = '" . $amount . "', bitcoin_rate = '" . $current_bitcoin_value . "', bitcoin_amount_to_be_paid = '" . $paid_amount . "', paid_bitcoin_amount = '" . $response_amount. "', bitcoin_address = '" . $bitcoin_address_enc . "', transaction = '" . $transaction . "', return_address = '" . $return_address . "', pending_id = " . $pending_id . ", date = '" .date('Y-m-d H:i:s'). "', order_id = '" .$order_id ."'");
      
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
}