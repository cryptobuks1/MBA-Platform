<?php

require "../vendor/autoload.php";

use Blocktrail\SDK\BlocktrailSDK;

class ControllerExtensionPaymentBlockchain extends Controller {

    private $error = array();

    public function index() { 
        
        
        $this->load->model('extension/payment/block_chain');
        $this->load->language('extension/payment/block_chain');

        $data['info'] = $this->language->get('info');
        
        
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
        
        $currency = "USD";
        $blockchain_root = "https://blockchain.info/";
        $price_in_btc = $total_amount;
        $price_in_btc = file_get_contents($blockchain_root . "tobtc?currency=$currency&value=" . $total_amount);

        $invoice_id = time();
        
        $my_xpub = $this->config->get('block_chain_xPub');
        $my_api_key = $this->config->get('block_chain_my_api_key');
        $secret = $this->getToken(); // $this->config->get('block_chain_secret');
      
        $new_address = false;
        
        /* For Server
         * 
         */
        
        /*if ($this->model_extension_payment_block_chain->getUnpaidAddressCount() >= 19 && $this->model_extension_payment_block_chain->getUnpaidAddress()) {
            $address = $this->model_extension_payment_block_chain->getUnpaidAddress();
        } else { 
            $my_callback_url = $this->url->link('extension/payment/blockt_chain/blockchain_callback?invoice_id='.$invoice_id.'&secret='. $secret);

            $root_url = 'https://api.blockchain.info/v2/receive';

            $parameters = 'xpub=' . $my_xpub . '&callback=' . urlencode($my_callback_url) . '&key=' . $my_api_key;
            //  echo $root_url . '?' . $parameters;die;
            $response = file_get_contents($root_url . '?' . $parameters);

            $object = json_decode($response);

            $address = $object->address;
            $new_address = true;
        }
        $qr_code = 'https://api.qrserver.com/v1/create-qr-code/?data=' . $address;
        if ($address) {
            if ($new_address) {
                $this->model_extension_payment_block_chain->keepBitcoinAddress($address);
            }
        if (isset($this->session->data['inf_regr'])){
                
                $regr = $this->session->data['inf_regr'];
                
            }else{
                $regr = "";
        }
            $this->model_extension_payment_block_chain->insertPaymentDetails($invoice_id, $address, $secret, $total_amount, $price_in_btc, $regr, 'register',$this->session->data['order_id']);
        } else {
                $msg = '<b><p> Check blockchain payment Credentials!!</p></b>';
                return $msg;
        }*/
        
        /* For Test
         * 
         */
        
        if ($this->model_extension_payment_block_chain->getUnpaidAddressCount() >= 19 && $this->model_extension_payment_block_chain->getUnpaidAddress()) {
            $address = $this->model_extension_payment_block_chain->getUnpaidAddress();
        } else {
            $address = $this->generateNewAddress();
        }
        $qr_code = $this->generateBitcoinQrCode($address, $total_amount);
        if ($address) {
            if (isset($this->session->data['inf_regr'])) {

                $regr = $this->session->data['inf_regr'];
            } else {
                $regr = "";
            }
            $this->model_extension_payment_block_chain->insertPaymentDetails($invoice_id, $address, $secret, $total_amount, $price_in_btc, $regr, 'register',$this->session->data['order_id']);
        } else {
            
                $msg = '<b><p> Blockchain payment available in live mode only!!</p></b>';
                return $msg;
        }
        
        $data['text_instruction'] = $this->language->get('text_instruction');
        $data['text_loading']     = $this->language->get('text_loading');
        $data['text_description'] = sprintf($this->language->get('text_description'),
                                            $price_in_btc);

        $data['button_confirm']   = $this->language->get('button_confirm');
        $data['continue']         = $this->url->link('checkout/success');
        $data['address'] = $address;
        $data['qr'] = $qr_code;
        $data['amount'] = $total_amount;
        $data['amount_in_btc'] = $price_in_btc;
        $data['invoice_id'] = $invoice_id;
        $this->session->data['amount_in_btc'] = $price_in_btc;
        $this->session->data['total_amount'] = $total_amount;

        return $this->load->view('extension/payment/block_chain', $data);
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/payment/block_chain')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

     public function getToken($length = 32) {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[$this->crypto_rand_secure(0, strlen($codeAlphabet))];
        }
        return $token;
    }
    private function crypto_rand_secure($min, $max) {
        $range = $max - $min;
        if ($range < 0)
            return $min;
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1;
        $bits = (int) $log + 1;
        $filter = (int) (1 << $bits) - 1;
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter;
        } while ($rnd >= $range);
        return $min + $rnd;
    }
    public function blockchain_callback() {
        $this->load->model('extension/payment/block_chain');
        $response = $_GET; //file_get_contents("php://input");

        if (isset($response['invoice_id'])) {
            $invoice_id = (int) $response['invoice_id'];
        } else {
            echo "*error*";
            return;
        }

        if (!isset($response['address']) || !isset($response['secret']) || !isset($response['confirmations'])) {
            log_message('error', "IP:{$_SERVER['REMOTE_ADDR']}: Does not look like a valid callback at all");
            $this->model_extension_payment_block_chain->updateCallbackError($invoice_id, "IP:{$_SERVER['REMOTE_ADDR']}: Does not look like a valid callback at all");
            echo "*error*";
            return;
        }

        $payment_info = $this->model_extension_payment_block_chain->getPaymentInfo($invoice_id);

        if ($response['address'] != $payment_info['payment_address']) {
            log_message('error', "IP:{$_SERVER['REMOTE_ADDR']}: Incorrect Receiving Address");
            $this->model_extension_payment_block_chain->updateCallbackError($invoice_id, "IP:{$_SERVER['REMOTE_ADDR']}: Incorrect Receiving Address");
            echo "*error*";
            return;
        }

        if ($response['secret'] != $payment_info['secret']) {
            log_message('error', "IP:{$_SERVER['REMOTE_ADDR']}: Secret Mismatch");
            $this->model_extension_payment_block_chain->updateCallbackError($invoice_id, "IP:{$_SERVER['REMOTE_ADDR']}: Secret Mismatch");
            echo "*error*";
            return;
        }

        if ($this->model_extension_payment_block_chain->getTransaction($invoice_id, $response['transaction_hash'])) {
            $this->model_extension_payment_block_chain->updateTransaction($invoice_id, $response['transaction_hash'], $response['confirmations']);
        } else {
            $this->model_extension_payment_block_chain->addTransaction($invoice_id, $response['transaction_hash'], $response['value'], $response['confirmations'], json_encode($response));
        }
        echo "*ok*";
    }

    public function blockchain_payment_done() {
        
            $block_address = $this->request->post['address'];
            $invoice_id = $this->request->post['invoice_id'];
            $paid_amount = $this->session->data['total_amount'];
            $json = array();
            
            $response = file_get_contents("https://blockchain.info/rawaddr/" . $block_address);
            
            $res_arr = json_decode($response, true);
            $response_amount = 0;
            foreach ($res_arr['txs'] as $key => $value) {
                $count = count($value['out']);
                for ($i = 0; $i < $count; $i++) {
                    if ($value['out'][$i]['addr'] == $block_address) {
                        $amount = $value['out'][$i]['value'];
                        $response_amount = $amount / 100000000;
                    }
                }
            }
            
            $this->model_extension_payment_block_chain->keepRowAddressReponse($block_address, $invoice_id, $res_arr, 'ocregister');
            $result = $this->model_extension_payment_block_chain->updateBitcoinAddress($block_address, 'yes');

            if ($response_amount > 0.00000001 && (round($response_amount, 8) >= round($paid_amount, 8)) && $result ) {
                    $this->load->model('checkout/order');
                    $comment = $this->language->get('text_title') . "\n\n";
                    
                    $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('config_order_status_id'), $comment, true);

                    unset($this->session->data['amount_in_btc']);
                    unset($this->session->data['total_amount']);
                    
                    $json['success'] = $this->url->link('checkout/success');
                
            } else {
                    $json['error'] = $this->language->get('an_error_occured');
                }
          
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));    
        }
    /* Test Blockchain code */
    
        public function get_admin_wallet_balance() {
        $this->load->model('extension/payment/block_chain');
        $blockchain_info = $this->model_extension_payment_block_chain->getBlockchainInfo();
        $guid = $blockchain_info['my_api_key'];
        $main_password = $blockchain_info['main_password'];
        $url = "http://localhost:3000/merchant/$guid/balance?password=$main_password";
        $data = $this->curl($url);

        return $data;
    }

    public function generateNewAddress() {
        $this->load->model('extension/payment/block_chain');
        $bitcoin_address = $this->model_extension_payment_block_chain->getAvailableAddress();
        if ($bitcoin_address == '') {
            $blockchain_info = $this->model_extension_payment_block_chain->getBlockchainInfo();
            $guid = $blockchain_info['my_api_key'];
            $main_password = $blockchain_info['main_password'];
            $second_password = $blockchain_info['second_password'];

            $url = "http://192.168.1.195:3000/merchant/$guid/new_address?password=$main_password&second_password=$second_password&label=user_id:$this->LOG_USER_ID";
            $data = $this->curl($url);
            $new_address = $data['address'];
            if ($new_address) {
                $this->model_extension_payment_block_chain->keepBitcoinAddress($new_address);
                return $new_address;
            }
        }
        return $bitcoin_address;
    }

    function getAccountList() {
        $this->load->model('extension/payment/block_chain');
        $blockchain_info = $this->model_extension_payment_block_chain->getBlockchainInfo();
        $guid = $blockchain_info['my_api_key'];
        $main_password = $blockchain_info['main_password'];
        $second_password = $blockchain_info['second_password'];

        $url = "http://localhost:3000/merchant/$guid/accounts?password=$main_password&second_password=$second_password";
        $data = $this->curl($url);

        print_r($data);
        return $data;
    }

    function gettingBalanceOfAnAddress($address = '') {
        $this->load->model('extension/payment/block_chain');
        $blockchain_info = $this->model_extension_payment_block_chain->getBlockchainInfo();
        $guid = $blockchain_info['my_api_key'];
        $main_password = $blockchain_info['main_password'];
        $second_password = $blockchain_info['second_password'];

        $address = '1P7JUGJ54TjkdCSwWxdWrxK1mKaySHx1ac';
        $url = "http://192.168.1.195:3000/merchant/$guid/address_balance?password=$main_password&address=$address";
        $data = $this->curl($url);

        return $data;
    }

    function generateBitcoinQrCode($bitcoin_address = '', $btc_amount = '') {
        $qr_data = "bitcoin%3A$bitcoin_address%3Famount%3D$btc_amount";
        $qr_code = 'https://api.qrserver.com/v1/create-qr-code/?data=' . $qr_data;
        //  echo $qr_code;die();
        return $qr_code;
    }
    function curl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15"));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec ($ch);
        $this->logger('Post data: ' . print_r($this->request->post, 1));
        $this->logger('Request: ' . $url);
        $this->logger('Curl error #: ' . curl_errno($ch));
        $this->logger('Curl error text: ' . curl_error($ch));
        $this->logger('Curl response info: ' . print_r(curl_getinfo($ch), 1));
        $this->logger('Curl response: ' . $response);
        curl_close($ch);
        return $response;
    }

    /* Using Without Domain Registration 
     * <--Ends--> */
    /* Blockchain Payment Method Ends */
    public function logger($message) {
		
			$log = new Log('block_chain.log');
			$log->write($message);
	}

}
