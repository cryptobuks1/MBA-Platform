<?php

class payout_optional_model extends inf_model {

    public $credentials;

    function __construct() {


        parent::__construct();

        $this->load->model('payout_class_model');
        $this->load->model('payout_model');
        $this->load->model('validation_model');
        $this->load->model('register_model');
        $this->load->model('settings_model');

        $pay_pal = $this->getPaypalConfigDetails();

        $this->credentials['API_USERNAME'] = $pay_pal['api_username'];
        $this->credentials['API_PASSWORD'] = $pay_pal['api_password'];
        $this->credentials['API_SIGNATURE'] = $pay_pal['api_signature'];
        if ($pay_pal['mode'] == 'test') {
            $this->credentials['API_ENDPOINT'] = 'https://api-3t.sandbox.paypal.com/nvp';
        } else {
            $this->credentials['API_ENDPOINT'] = 'https://api-3t.paypal.com/nvp';
        }
    }
    
        
    public function encryptDecrypt($value, $type){        
        $key = $this->config->item('encryption_key'); 
        if($type == "encryption"){
            $rs = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $value, MCRYPT_MODE_CBC, md5(md5($key))));
        }
        if($type == "decryption"){
            $rs = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($value), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
        }
        return $rs;
    }
    
    //Paypal Payout Starts
    
    function getUserPayPalEmail($user_id) {
        $user_paypal_email = "";
        $this->db->select('user_detail_paypal');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            if (!empty($query->row('user_detail_paypal'))) {
                $user_paypal_email = $this->encryptDecrypt($row->user_detail_paypal,"decryption");
            }
        }
        return $user_paypal_email;
    }

    function PayPalBalance() {
        require_once APPPATH . 'third_party/Paypal/PayPal_CallerService.php';
        $PayPal = new PayPal_CallerService($this->credentials);
        $balance = $PayPal->callPayPal("GetBalance", '');
        $balance['L_AMT0'];
        return $balance['L_AMT0'];
    }

    function massPay($base_call, $payout_release, $amount) {
        require_once APPPATH . 'third_party/Paypal/PayPal_CallerService.php';
        $PayPal = new PayPal_CallerService($this->credentials);
        $balance = $PayPal->callPayPal("GetBalance", '');
        if ($balance['L_AMT0'] > $amount) {
            $status = $PayPal->callPayPal("MassPay", $base_call);
            if ($status['ACK'] == "Success") {

                $count = count($payout_release);
                for ($i = 0; $i < $count; $i++) {
                    $user_id = $payout_release[$i]['user_id'];
                    $payout_release_amount = $payout_release[$i]['payout_release_amount'];
                    $payout_release_type = $payout_release[$i]['payout_release_type'];
                    $requested_date = $payout_release[$i]['requested_date'];
                    $req_id = $payout_release[$i]['req_id'];
                    $res = $this->payout_model->updatePayoutReleaseRequest($req_id, $user_id, $payout_release_amount, $payout_release_type,$hash="");
                    if ($payout_release_type == "from_ewallet")
                        $this->payout_model->updateUserBalanceAmount($user_id, $payout_release_amount);
                }
                return $res;
            } else
                return 0;
        } else {
            return 0;
        }
    }

    public function massPayoutHistory($payout_arr) {
        $json = json_encode($payout_arr);
        $data = array(
            'mass_payout_details' => $json,
            'date' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('mass_payout_history', $data);
    }

    public function getPaypalConfigDetails($id = 1) {

        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->from('paypal_config');
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $details['api_username'] = $row->api_username;
            $details['api_password'] = $row->api_password;
            $details['api_signature'] = $row->api_signature;
            $details['mode'] = $row->mode;
            $details['currency'] = $row->currency;
            $details['return_url'] = $row->return_url;
            $details['cancel_url'] = $row->return_url;
        }
        if ($query->num_rows()) {
            return $details;
        }
    }

    //Paypal Payout Ends
    
        
    /*Blockchain Payout Begin*/
    public function getUserBitcoinAddress($user_id, $admin_req = "") {
        $bitcoin_address = '';

        $this->db->select('user_detail_blockchain_wallet_id');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $query = $this->db->get();
        if (!empty($query->row('user_detail_blockchain_wallet_id'))) {
            $enc_bitcoin_address = $query->row('user_detail_blockchain_wallet_id');
            $bitcoin_address = $this->encryptDecrypt($enc_bitcoin_address,"decryption");
        }

        return $bitcoin_address;
    }

    public function getBlockchainDetails() {
        $blockchain_details = array();
        $this->db->select('*');
        $this->db->from('blockchain_config');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $blockchain_details['main_password'] = $this->encrypt->decode($row['main_password']);
            $blockchain_details['second_password'] = $this->encrypt->decode($row['second_password']);
            $blockchain_details['my_api_key'] = $this->encrypt->decode($row['my_api_key']);
            $blockchain_details['fee'] = $row['fee'];
        }

        return $blockchain_details;
    }
        
    public function insertIntoBitcoinPayoytReleaseHistory($status, $message = "NA", $user_id, $admin_btc_balance, $payout_release_amount, $system_currency, $recent_bitcoin_rate, $btc_send_amount = '', $user_bitcoin_address = '', $btc_send_response = array(), $btc_transaction_fee = '', $btc_admin_debit = '', $tx_hash = '', $account_type = '') {
        $this->db->set('user_id', $user_id);
        $this->db->set('status', $status);
        $this->db->set('message', $message);
        $this->db->set('admin_btc_balance', $admin_btc_balance);
        $this->db->set('response', serialize($btc_send_response));
        $this->db->set('payout_release_amount', $payout_release_amount);
        $this->db->set('system_currency', $system_currency);
        $this->db->set('recent_bitcoin_rate', $recent_bitcoin_rate);
        $this->db->set('btc_send_amount', $btc_send_amount);
        $this->db->set('btc_transaction_fee', $btc_transaction_fee);
        $this->db->set('btc_admin_debit', $btc_admin_debit);
        $this->db->set('bitcoin_address', $user_bitcoin_address);
        $this->db->set('tx_hash', $tx_hash);
        $this->db->set('account_type', $account_type);
        $this->db->set('date', date('Y-m-d H:i:s'));
        $result = $this->db->insert('blockchain_payout_release_history');
        return $result;
    }
        
    public function updateTransactionStatus($request_id,$user_id, $paid_amount,$hash="")
    {
        $this->db->set('paid_status','yes');
        $this->db->where('paid_type  =', 'released');
        $this->db->where('paid_status  !=', 'yes');
        if(empty($hash)){        
            $this->db->where('paid_amount  =', $paid_amount);
            $this->db->where('paid_id  =', $request_id);
            $this->db->where('paid_user_id', $user_id);
        }else{
            $this->db->where('transaction_id  =', $hash);
        }
       
        return $this->db->update("amount_paid") ;
    }
    /*Blockchain Payout Ends*/

    /*Bitgo Payout Starts*/
    public function getUserBitgoWalletAddress($user_id, $admin_req = "") {
        $bitcoin_address = '';

        $this->db->select('user_detail_bitgo_wallet_id');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $query = $this->db->get();
        if (!empty($query->row('user_detail_bitgo_wallet_id'))) {
            $enc_bitcoin_address = $query->row('user_detail_bitgo_wallet_id');
            $bitcoin_address = $this->encryptDecrypt($enc_bitcoin_address,"decryption");
        }

        return $bitcoin_address;
    }
        
    public function getBitgoDetails() {
        $bitgo_details = array();
        $this->db->select('bc.wallet_id, bc.token, bc.mode,bc.wallet_passphrase');
        $this->db->from('bitgo_configuration bc');
        $this->db->join("payment_gateway_config pg", "bc.mode=pg.mode", 'INNER');
        $this->db->where("pg.gateway_name", "bitgo");
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $bitgo_details['wallet_id'] = $row['wallet_id'];
            $bitgo_details['token']     = $row['token'];
            $bitgo_details['mode']      = $row['mode'];
            $bitgo_details['passphrase'] = $this->encryptDecrypt($row['wallet_passphrase'], "decryption");
        }

        return $bitgo_details;
    }
            
    public function insertIntoBitGoPayoutHistory($response=array(), $details=array(),$admin_btc_balance=0,$btc_transaction_fee=0,$btc_admin_debit=0) {
        $this->db->set('user_id', $details['user_id']);
        $this->db->set('tx_id', $response['tx']);
        $this->db->set('hash', $response['hash']);
        $this->db->set('status', $response['status']);
        $this->db->set('admin_btc_balance', $admin_btc_balance);
        $this->db->set('payout_release_amount', $details['payout_release_amount']);
        $this->db->set('btc_send_amount', $details['amount']);
        $this->db->set('btc_transaction_fee', $btc_transaction_fee);
        $this->db->set('btc_admin_debit', $btc_admin_debit);
        $this->db->set('bitcoin_address', $details['address']);
        $this->db->set('date', date('Y-m-d H:i:s'));
        $this->db->set('response', serialize($response));
        $this->db->set('release', serialize($details));
        $result = $this->db->insert('bitgo_payout_release_history');
        return $result;
        
    }
public function getPayeerDetails($user_id) {

        $this->db->select('payeer_address');
        $this->db->where('user_detail_refid', $user_id);
        $this->db->from('user_details');
        $res = $this->db->get();
        $payeer = null;
        foreach ($res->result() as $row) {
            $payeer = $row->payeer_address;
        }
        if ($payeer != null) {
            return $payeer;
        }  else {
            return null;
        }
    }
    public function getPayeerConfig($user_id) {

        $this->db->select('*');
        $this->db->from('payeer_details');
        $res = $this->db->get();
        
        return $res->result_array()[0];
    }
    /*Bitgo Payout Ends*/
    function PayeerBalance() {
        //require_once APPPATH . 'third_party/Paypal/PayPal_CallerService.php';
        require_once APPPATH . 'third_party/Payeer/cpayeer.php';
        $payeer_details= $this->getPayeerConfig($this->ADMIN_USER_ID);
        $accountNumber = $payeer_details['acc_no'];
        $apiId =  $payeer_details['api_id'];
        $apiKey =  $payeer_details['api_key'];
        $payeer = new CPayeer($accountNumber, $apiId, $apiKey);
        if ($payeer->isAuth())
        {
        	$arBalance = $payeer->getBalance();
        	$arBalance =$arBalance['balance']['USD']['BUDGET'];
        	return $arBalance;
        //	echo '<pre>'.print_r($arBalance, true).'</pre>';die;
        }
        else
        {
            return 0;
    //	echo '<pre>'.print_r($payeer->getErrors(), true).'</pre>';die;
        }
    }
    function payeerPayout($base_call, $payout_release, $amount) {
        $res=0;
        require_once APPPATH . 'third_party/Payeer/cpayeer.php';
        
      /*  $balance = $PayPal->callPayPal("GetBalance", '');
        if ($balance['L_AMT0'] > $amount) { */
           $payeer_details= $this->getPayeerConfig($this->ADMIN_USER_ID);
        $accountNumber = $payeer_details['acc_no'];
        $apiId =  $payeer_details['api_id'];
        $apiKey =  $payeer_details['api_key'];
        $payeer = new CPayeer($accountNumber, $apiId, $apiKey);
        if ($payeer->isAuth())
        {  

                $count = count($payout_release);
                for ($i = 0; $i < $count; $i++) {
                    $user_id = $payout_release[$i]['user_id'];
                    $payout_release_amount = $payout_release[$i]['payout_release_amount'];
                    $payout_release_type = $payout_release[$i]['payout_release_type'];
                    $requested_date = $payout_release[$i]['requested_date'];
                    $req_id = $payout_release[$i]['req_id'];
                    $result=$this->sendPayeerPayout($user_id,$payout_release_amount);
                    if($result){
                        $res = $this->payout_model->updatePayoutReleaseRequest($req_id, $user_id, $payout_release_amount, $payout_release_type,'Payeer',$hash="");
                        if ($payout_release_type == "from_ewallet")
                            $this->payout_model->updateUserBalanceAmount($user_id, $payout_release_amount);
                    }
                }
                return $res;
        }
       /* } else {
            return 0;
        }*/
    }
    function sendPayeerPayout($user_id,$payout_release_amount){
         require_once APPPATH . 'third_party/Payeer/cpayeer.php';
         $payeer_details= $this->getPayeerConfig($this->ADMIN_USER_ID);
        $accountNumber = $payeer_details['acc_no'];
        $apiId =  $payeer_details['api_id'];
        $apiKey =  $payeer_details['api_key'];
        $payeer = new CPayeer($accountNumber, $apiId, $apiKey);
        if ($payeer->isAuth())
        {
        $payeer_address= $this->getPayeerDetails($user_id);
       $arr=array(
    		'ps' => '1136053', //payout method code
    		//'sumIn' => 1,
    		'curIn' => 'USD',
    		'sumOut' => $payout_release_amount,
    		'curOut' => 'USD',
    		'param_ACCOUNT_NUMBER' => $payeer_address//'P32667428'
    	);
    	$initOutput = $payeer->initOutput(array(
    		'ps' => '1136053', //payout method code
    		//'sumIn' => 1,
    		'curIn' => 'USD',
    		'sumOut' => $payout_release_amount,
    		'curOut' => 'USD',
    		'param_ACCOUNT_NUMBER' => $payeer_address//'P32667428'
    	));
    
    	if ($initOutput)
    	{
    	    $insert_id = $this->insertPayeerPayoutHistory(serialize($arr),$user_id);
    		$historyId = $payeer->output();
    		if ($historyId > 0)
    		{
    		   $this->updatePayeerPayoutHistory($insert_id,$historyId,'');
    		//	echo "Payout is successful";
    			return 1;
    		}
    		else
    		{ 
    		    $error = serialize($payeer->getErrors());
    		    $this->updatePayeerPayoutHistory($insert_id,'',$error);
    		    return 0;
    		//	echo '<pre>'.print_r($payeer->getErrors(), true).'</pre>';die;
    		   // $this->redirect(lang('Payeer Error'), "payout/payout_release", false);
    		}
    	}
    	else
    	{       
    	        $error = serialize($payeer->getErrors());
    		    $this->updatePayeerPayoutHistory($insert_id,'',$error);
    	    return 0;
    	//	echo '<pre>'.print_r($payeer->getErrors(), true).'</pre>';die;
    		
    		//$this->redirect(lang('Payeer Error'), "payout/payout_release", false);
    	}
        }else{
                $error = 'Payeer Auth Error';
    		    $this->updatePayeerPayoutHistory($insert_id,'',$error);
            return 0;
            $this->redirect(lang('Payeer Auth Error'), "payout/payout_release", false);
        }
    
        }
        public function insertPayeerPayoutHistory($data,$user_id){
            $this->db->set('user_id',$user_id);
            $this->db->set('req_data',$data);
            $this->db->set('date',date("Y-m-d H:i:s"));
            $this->db->insert('payeer_payout_history');
            $id = $this->db->insert_id();
            return $id;
        }
        public function updatePayeerPayoutHistory($id,$success='',$error=''){
            $this->db->set('success',$success);
            $this->db->set('error',$error);
            $this->db->where('id',$id);
            return $this->db->update('payeer_payout_history');
        }

}
