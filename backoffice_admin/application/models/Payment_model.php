<?php

class payment_model extends inf_model {

    public function __construct() {
        parent::__construct();
        $this->load->model('configuration_model');
        $this->load->model('currency_model');
        $this->load->model('register_model');
    }


    public function getPaypalPaymentConfig($total_amount, $default_currency_code, $description, $return_url, $cancel_url)
    {
        $paypal_details = $this->configuration_model->getPaypalConfigDetails();
        $paypal_currency_code = "USD";
        $paypal_currency_left_symbol = "$";
        $paypal_currency_right_symbol = "";

        $default_currency_code = ($default_currency_code != '') ? $default_currency_code : $paypal_currency_code;
        
        $conversion_rate = $this->currency_model->getCurrencyConversionRate($default_currency_code, $paypal_currency_code);

        $payment_amount = round($total_amount * $conversion_rate, 8);

        $test_mode = FALSE;
        if ($paypal_details['mode'] == 'test') {
            $test_mode = TRUE;
        }

        $settings = array(
            'username' => $paypal_details['api_username'],
            'password' => $paypal_details['api_password'],
            'signature' => $paypal_details['api_signature'],
            'test_mode' => $test_mode
        );

        $params = array(
            'amount' => $payment_amount,
            'item' => "Membership Upgrade",
            'description' => $description,
            'currency' => $paypal_currency_code,
            'return_url' => $return_url,
            'cancel_url' => $cancel_url
        );

        return array('settings' => $settings, 'params' => $params);
    }

    public function getPaypalReturnConfig($total_amount, $default_currency_code, $return_url, $cancel_url)
    {
        $paypal_details = $this->configuration_model->getPaypalConfigDetails();
        $paypal_currency_code = "USD";
        $paypal_currency_left_symbol = "$";
        $paypal_currency_right_symbol = "";

        $default_currency_code = ($default_currency_code != '') ? $default_currency_code : $paypal_currency_code;
        
        $conversion_rate = $this->currency_model->getCurrencyConversionRate($default_currency_code, $paypal_currency_code);

        $payment_amount = round($total_amount * $conversion_rate, 8);
        
        $test_mode = FALSE;
        if ($paypal_details['mode'] == 'test') {
            $test_mode = TRUE;
        }

        $settings = array(
            'username' => $paypal_details['api_username'],
            'password' => $paypal_details['api_password'],
            'signature' => $paypal_details['api_signature'],
            'test_mode' => $test_mode
        );
        
        $params = array(
            'amount' => $payment_amount,
            'currency' => $paypal_currency_code,
            'return_url' => $return_url,
            'cancel_url' => $cancel_url
        );

        return array('settings' => $settings, 'params' => $params, 'payment_amount' => $payment_amount, 'currency' => $paypal_currency_code);
    }

    function generateBitcoinQrCode($bitcoin_address = '', $btc_amount = '') {
        $qr_data = "bitcoin%3A$bitcoin_address%3Famount%3D$btc_amount";
        $qr_code = '<img src="https://api.qrserver.com/v1/create-qr-code/?data=' . $qr_data . '&amp;size=300x100" alt="" title="Bitcoin Address : ' . $bitcoin_address . ',BTC Amount : ' . $btc_amount . '" >';
        return $qr_code;
    }
        
    function insertIntoSofortPaymentHistory($payment_details) {
        $this->db->set('user_id',$payment_details['user_id']);
        $this->db->set('purpose',$payment_details['type']);
        $this->db->set('amount',$payment_details['total_amount']);
        $this->db->set('status',$payment_details['status']);
        $this->db->set('date',date('Y-m-d H:i:s'));
        $this->db->set('transaction_id',$payment_details['transaction_id']);
        $res = $this->db->insert('sofort_payment_history');
        return $this->db->insert_id();
    }
    
    function getSofortTransactionDetails($invoice,$id){
        $this->db->select('*');
        $this->db->where('invoice_number',$invoice);
        $this->db->where('id',$id);
        $this->db->from('sofort_payment_history');
        $result=$this->db->get();
        return $result->result_array();
    }
    
    public function insertInToSofortProcessDetails($regr_data, $reason, $registrer)
    {
        $this->db->set('registrar', $registrer);
        $this->db->set('regr_data', json_encode($regr_data));
        $this->db->set('reason', $reason);
        $this->db->set('date', date('Y-m-d H:i:s'));
        $result = $this->db->insert('sofort_payment_response');
        return $result;
    }

    public function isPaypalEnabled()
    {
        $status = FALSE;
        $this->db->where('payment_type', 'Payment Gateway');
        $this->db->where('status', 'yes');
        $status1 = $this->db->count_all_results('payment_methods');

        if ($status1 > 0) {
            $this->db->where('gateway_name', 'Paypal');
            $this->db->where('status', 'yes');
            $status2 = $this->db->count_all_results('payment_gateway_config');

            if ($status2 > 0) {
                return TRUE;
            }
        }

        return $status;
    }
    
    function insertSquareUpPaymentDetails($user_id, $name, $response, $purpose, $transaction_id, $status) {
        
        $data = [
            'user_id'          => $user_id,
            'name'             => $name,
            'purpose'          => $purpose,
            'amount'           => $response['amount_money']['amount'],
            'currency'         => $response['amount_money']['currency'],
            'idempotency_key'  => $response['idempotency_key'],
            'transaction_id'  =>  $transaction_id,
            'status'           => $status,
            'date'             => date('Y-m-d H:i:s')  
        ];
        $result = $this->db->insert('squareup_payment_history', $data);
        return $this->db->insert_id();
    }
    
    public function insertSquareUpResponse($regr_data, $reason, $registrer)
    {
        $this->db->set('registrar', $registrer);
        $this->db->set('regr_data', json_encode($regr_data));
        $this->db->set('reason', $reason);
        $this->db->set('date', date('Y-m-d H:i:s'));
        $result = $this->db->insert('squareup_payment_response');
        return $result;
    }
    
}