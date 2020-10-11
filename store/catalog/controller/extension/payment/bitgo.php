<?php

define("IN_WALLET", true);
require "../vendor/autoload.php";

use Blocktrail\SDK\BlocktrailSDK;


class ControllerExtensionPaymentBitgo extends Controller {

    private $error = array();
    
    public function index() {
        $this->load->model('extension/payment/bitgo');
        $this->load->language('extension/payment/bitgo');
        
        
        $totals = array();
			$taxes = $this->cart->getTaxes();
			$total = 0;

			// Because __call can not keep var references so we put them into an array.
			$total_data = array(
				'totals' => &$totals,
				'taxes'  => &$taxes,
				'total'  => &$total
			);

			$this->load->model('extension/extension');

			$sort_order = array();

			$results = $this->model_extension_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('extension/total/' . $result['code']);

					// We have to put the totals in an array so that they pass by reference.
					$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
				}
			}
        $total_amount = $total_data['total'];
        $bitgo_status = $this->config->get('bitgo_mode');
        $bitgo_configurtation = $this->model_extension_payment_bitgo->getBitgoConfiguration($bitgo_status);
        $token = $this->config->get('bitgo_token');
        
        $data['info'] = $this->language->get('info');
        $currency = "USD";
        if ($bitgo_status == 'test') { 
            $wallet_curl_url = "https://test.bitgo.com/api/v2/tbtc/wallet";
        } else {
            $wallet_curl_url = "https://www.bitgo.com/api/v2/btc/wallet";
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $wallet_curl_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $headers = array();
        $headers[] = "Authorization: Bearer $token";
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $this->logger('Post data: ' . print_r($this->request->post, 1));
        $this->logger('Request: ' . $wallet_curl_url);
        $this->logger('Curl error #: ' . curl_errno($ch));
        $this->logger('Curl error text: ' . curl_error($ch));
        $this->logger('Curl response info: ' . print_r(curl_getinfo($ch), 1));
        $this->logger('Curl response: ' . $result);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        $info = json_decode($result);
        curl_close($ch);
        $wallet_id = $info->wallets['0']->id;
        if (isset($this->session->data['bitcoin_session']) && $this->session->data['inf_regr']['is_new'] == "no") {
            
            $pay_address = $this->session->data['bitcoin_session']['bitcoin_address'];
            $sendAmount = $this->session->data['bitcoin_session']['send_amount'];
            $bitgo_hid = $this->session->data['bitcoin_session']['bitgo_hid'];
        } else {
            
            $this->session->data['inf_regr']['is_new'] = "no";
            
            if ($bitgo_status == 'test') { 
                
                $address_curl_url = "https://test.bitgo.com/api/v2/tbtc/wallet/" . $wallet_id . "/address";
            } else {
                $address_curl_url = "https://www.bitgo.com/api/v2/btc/wallet/" . $wallet_id . "/address";
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $address_curl_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);

            $headers = array();
            $headers[] = "Authorization: Bearer " . $token;
            $headers[] = "Content-Type: application/json";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            $this->logger('Post data: ' . print_r($this->request->post, 1));
            $this->logger('Request: ' . $address_curl_url);
            $this->logger('Curl error #: ' . curl_errno($ch));
            $this->logger('Curl error text: ' . curl_error($ch));
            $this->logger('Curl response info: ' . print_r(curl_getinfo($ch), 1));
            $this->logger('Curl response: ' . $result);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            $address = json_decode($result);
            
             //-----amount conversion
            $currency = 'USD';
            $url = 'https://bitpay.com/api/rates/' . $currency;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, Array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15"));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            curl_close($ch);
            $info = json_decode($result, true);
            $bitcoin_price = $info['rate'];
            
            $bitcoin_amount =round( $total_amount / $bitcoin_price ,8);
            
            
            $sendAmount = $bitcoin_amount;
            if (isset($this->session->data['inf_regr'])){
                
                $regr = $this->session->data['inf_regr'];
                
            }else{
                $regr = "";
            }
            $order_id = $this->session->data['order_id'];
            $user_id = $this->customer->getUserId();
            $pay_address = $address->address;
            $bitgo_hid = $this->model_extension_payment_bitgo->insertIntoBitGoPaymentHistory($user_id, serialize($regr), $order_id, $bitcoin_amount, $pay_address, serialize($address), $wallet_id);

            $bitcoin_session = array(
                'bitcoin_address' => $pay_address,
                'send_amount' => $sendAmount,
                'bitgo_hid' => $bitgo_hid,
                'wallet_id' => $wallet_id
            );
            $this->session->data['bitcoin_session'] = $bitcoin_session;
        }
        $btc_amount = $sendAmount;

        $qr_code = $this->generateBitcoinQrCode($pay_address, $btc_amount);
        
        $data['text_instruction'] = $this->language->get('text_instruction');
        $data['text_loading']     = $this->language->get('text_loading');
        $data['text_description'] = sprintf($this->language->get('text_description'),
                                            $btc_amount);

        $data['button_confirm']   = $this->language->get('button_confirm');
        $data['continue']         = $this->url->link('checkout/success');
        $data['qr_code'] = $qr_code;
        $data['bitcoin_address'] = $pay_address;
        $data['qr_btc_amount'] = $btc_amount;
        $data['bitgo_hid'] = $bitgo_hid;
        $data['wallet_id'] = $wallet_id;
        return $this->load->view('extension/payment/bitgo', $data);
        
    }
    public function checkBitcoinPaymentStatus($bitcoin_address, $btc_amount, $bitgo_hid, $wallet_id) {

        //$bitcoin_settings = $this->config->get('authorizenet_aim_login');
        $this->load->model('extension/payment/bitgo');
        $this->load->language('extension/payment/bitgo');

        $data['info'] = $this->language->get('info');
        $status = "no";
        
            $bitgo_status = $this->config->get('bitgo_mode');

            $bitgo_configurtation = $this->model_extension_payment_bitgo->getBitgoConfiguration($bitgo_status);
            
            $token = $this->config->get('bitgo_token');
            
            if ($bitgo_status == 'test') {

            $single_address_check_url = "https://test.bitgo.com/api/v2/tbtc/wallet/" . $wallet_id . "/transfer";
            $bitcoin_payment['status'] = false;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $single_address_check_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

            $headers = array();
            $headers[] = "Authorization: Bearer $token";
            $headers[] = "Content-Type: application/json";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            $info = json_decode($result);
            if (!empty($info)) {
                $paid_amount = 0;
                foreach ($info->transfers as $key => $value) {
                    $count = count($value->entries);
                    $value = get_object_vars($value);
                    for ($i = 0; $i < $count; $i++) {
                        if ($value['entries'][$i]->address == $bitcoin_address) {
                            $paid_amount = $value['entries'][$i]->value;
                            $paid_amount = $paid_amount / 100000000;
                        }
                    }
                }
                if ($btc_amount <= $paid_amount) {

                    $bitcoin_payment['status'] = true;
                    $this->model_extension_payment_bitgo->upateBitGoStatus($bitgo_hid, 'success');

                    $this->model_extension_payment_bitgo->upateRecievedResult($bitgo_hid, serialize($info), $paid_amount, serialize($bitcoin_payment));
                    $status = "yes";
                }
            }
        }  else { 
            $single_address_check_url = "https://blockchain.info/rawaddr/" . $bitcoin_address;
            $bitcoin_payment['status'] = false;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $single_address_check_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

            $headers = array();
            $headers[] = "Content-Type: application/json";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            $info = json_decode($result);
            if (!empty($info)) {

                $paid_amount = 0;
                foreach ($info['txs'] as $key => $value) {
                    $count = count($value['out']);
                    for ($i = 0; $i < $count; $i++) {
                        if ($value['out'][$i]['addr'] == $bitcoin_address) {
                            $paid_amount = $value['out'][$i]['value'];
                            $paid_amount = $paid_amount / 100000000;
                        }
                    }
                }
                if ($btc_amount <= $paid_amount) {

                    $bitcoin_payment['status'] = true;
                    $this->model_extension_payment_bitgo->upateBitGoStatus($bitgo_hid, 'success');

                    $this->model_extension_payment_bitgo->upateRecievedResult($bitgo_hid, serialize($info), $paid_amount, serialize($bitcoin_payment));
                    $status = "yes";
                }
            }
        }

        return($status);
    }
    function generateBitcoinQrCode($bitcoin_address = '', $btc_amount = '') {
        $qr_data = "bitcoin%3A$bitcoin_address%3Famount%3D$btc_amount";
        $qr_code = 'https://api.qrserver.com/v1/create-qr-code/?data=' . $qr_data;
        //  echo $qr_code;die();
        return $qr_code;
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/payment/blocktrail')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

   public function ajaxBitgoPaymentVerify() {
       $status = 'no';
       if (isset($this->session->data['bitcoin_session'])) {

            
            $bitcoin_address_array = $this->session->data['bitcoin_session'];
            $bitcoin_address = $bitcoin_address_array['bitcoin_address'];
            $btc_amount = $bitcoin_address_array['send_amount'];
            $bitgo_hid = $bitcoin_address_array['bitgo_hid'];
            $wallet_id = $bitcoin_address_array['wallet_id'];
            $bitcoin_status = $this->checkBitcoinPaymentStatus($bitcoin_address, $btc_amount, $bitgo_hid, $wallet_id);

            if ($bitcoin_status == "yes") {
                $status = 'yes';
            }
        }
        echo json_encode($status);
        exit();
    }
    public function logger($message) {
		
			$log = new Log('bitgo.log');
			$log->write($message);
	}
    function bitgoSuccess(){
         
         $this->load->model('extension/payment/bitgo');
         if (isset($this->session->data['bitcoin_session'])) {

            
            $bitcoin_address_array = $this->session->data['bitcoin_session'];
            $bitcoin_address = $bitcoin_address_array['bitcoin_address'];
            $btc_amount = $bitcoin_address_array['send_amount'];
            $bitgo_hid = $bitcoin_address_array['bitgo_hid'];
            $wallet_id = $bitcoin_address_array['wallet_id'];
        }
        else {
               
                $json['error'] = $this->language->get('an_error_occured');
        }
        if($wallet_id){
        $user_id = $this->customer->getUserId();
         
        $bitcoin_payment_status = $this->model_extension_payment_bitgo->getPaymentInfo($user_id,$this->session->data['order_id'],$wallet_id);
           $this->load->model('checkout/order');
           if($bitcoin_payment_status){
               $message = "";
               $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], 5, $message, false);
                unset($this->session->data['bitcoin_session']);
                $json['success'] = $this->url->link('checkout/success', '', true);  
                
           }else {
               $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('config_order_status_id'));
               
                 $json['error'] = $this->language->get('an_error_occured');
         
	  }
        }
        else {
               
                $json['error'] = $this->language->get('an_error_occured');
        }
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));  
    }     

}
