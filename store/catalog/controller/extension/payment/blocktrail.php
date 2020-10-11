<?php


require "../vendor/autoload.php";

use Blocktrail\SDK\BlocktrailSDK;

class ControllerExtensionPaymentBlocktrail extends Controller {

    private $error = array();

    public function index() {

        //$bitcoin_settings = $this->config->get('authorizenet_aim_login');
        $this->load->model('extension/payment/blocktrail');
        $this->load->language('extension/payment/blocktrail');

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

        $myAPIKEY = $this->config->get('blocktrail_api');
        $myAPISECRET = $this->config->get('blocktrail_api_secret');
        $mode = $this->config->get('blocktrail_mode');
        $json = array();
        

        if ($mode == "test") {
            $testnet = true;
            $walletIdent = $this->config->get('blocktrail_wallet_name');
            $walletPassword = $this->config->get('blocktrail_wallet_password');
        } else {
            $testnet = false;
            $walletIdent = $this->config->get('blocktrail_wallet_name');
            $walletPassword = $this->config->get('blocktrail_wallet_password');
        }
        $callbackURL = '';
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
       
       
        
        /*
         *  Comment For live
         */
        $total_amount = 1;
        
        
        $bitcoin_amount =round( $total_amount / $bitcoin_price ,8);
        $user_id = $this->customer->getUserId();
       
        $qr_btc_amount =  $bitcoin_amount ;


        try {
            // Initialize the SDK
            $client = new BlocktrailSDK($myAPIKEY, $myAPISECRET, "BTC", $testnet);
           
        } catch (Exception $e) {
            $json['error'] = $e->getMessage();
        }

        try {
            // Create a wallet

            list($wallet, $primaryMnemonic, $backupMnemonic, $blocktrailPublicKeys) = $client->createNewWallet($walletIdent, $walletPassword);
        } catch (Exception $e) {

            $json['error'] = $e->getMessage();
            // print "Creating a wallet failed because {$e->getMessage()}";
        }
        $wallet = '';
        try {
            // Or you can initialize an already existing wallet
            $wallet = $client->initWallet($walletIdent, $walletPassword);
        } catch (Exception $e) {
            $json['error'] = $e->getMessage();
        }

        try {
            // Setup transaction notifications for all addresses in this wallet 
            $wallet->setupWebhook($callbackURL);
        } catch (Exception $e) {
            // print "Setting up webhooks failed because {$e->getMessage()}";
        }
        try {
            // Create a new bitcoin address for this $wallet
            $bitcoin_address = $wallet->getNewAddress();
            $this->session->data['bitcoin_address'] = $bitcoin_address;
            // $this->session->set_userdata('bitcoin_address', $bitcoin_address);
            $qr_data = "bitcoin%3A$bitcoin_address%3Famount%3D$qr_btc_amount";
            $qr_code = 'https://api.qrserver.com/v1/create-qr-code/?data=' . $qr_data;

            
            $data['text_instruction'] = $this->language->get('text_instruction');
            $data['text_loading']     = $this->language->get('text_loading');
            $data['text_description'] = sprintf($this->language->get('text_description'),
                                            $qr_btc_amount);
            
            $data['user_name'] = $this->session->data['inf_logged_in']['user_name'];
            $data['button_confirm']   = $this->language->get('button_confirm');
            $data['continue']         = $this->url->link('checkout/success');
            $data['qr_code'] = $qr_code;
            $data['bitcoin_address'] = $bitcoin_address;
            $data['qr_btc_amount'] = $qr_btc_amount;
            $this->session->data['bitcoin_amount'] = $bitcoin_amount;
            $this->session->data['total_amount'] = $total_amount;
            $this->session->data['current_btc'] = $bitcoin_price;
            $bitcoin_id = $this->model_extension_payment_blocktrail->bitcoinHistory($data['user_name'], $data, 'repurchase');
            $this->session->data['bitcoin_id'] = $bitcoin_id;

        } catch (Exception $e) {
            $json['error'] = $e->getMessage();
        }
//        echo "<pre>";
//        print_R($data);die;

        return $this->load->view('extension/payment/blocktrail', $data);
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/payment/blocktrail')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    public function bitcoin_response() {
        error_reporting(E_ALL);
         ini_set('display_errors', '1');
   $this->load->model('extension/payment/blocktrail');
  
        $bitcoin_settings = $this->model_extension_payment_blocktrail->getBlockTrailConfig();
        $myAPIKEY = $this->config->get('blocktrail_api');
        $myAPISECRET = $this->config->get('blocktrail_api_secret');
        $mode = $this->config->get('blocktrail_mode');
        if ($mode == "test") {
            $testnet = true;
        } else {
            $testnet = false;
        }
        $callbackURL = '';
        $status = "no";

       // $regr = $this->session->userdata('inf_package_validity');
        $user_id = $this->customer->getUserId();
        $regr['user_name_entry'] = $this->session->data['inf_logged_in']['user_name'];

        $client = new BlocktrailSDK($myAPIKEY, $myAPISECRET, "BTC", $testnet);

        if (isset($_POST)) {
            $bitcoin_address = $_POST['bitcoin_address'];
            $response = $client->addressTransactions($bitcoin_address);
            $regr['bitcoin_address'] = $bitcoin_address;
            $regr['response'] = $response;
            if ($response['data']) {
                foreach ($response['data'][0]['outputs'] as $value) {
                    if ($value['address'] == $bitcoin_address) {
                        $satoshi = $value['value'];
                    }
                }
                if ($satoshi > 0) {
                    $response_amount = number_format(($satoshi) * (pow(10, -8)), 8, '.', '');
                    $bitcoin_price =  $this->session->data['current_btc'];
                    $amout_paid = round( $response_amount * $bitcoin_price ,2);
                    
                    if ($amout_paid >= $this->session->data['total_amount']) {    
                        $this->model_extension_payment_blocktrail->insertInToBitcoinPaymentProcessDetails($regr, "Amount Paid", $user_id);
                        $status = "yes";
                    }
                } else {
                    $status = "no";
                }
            } else {
                $status = "no";
            }
        } else {
            $this->model_extension_payment_blocktrail->insertInToBitcoinPaymentProcessDetails($regr, "No Post Data", $user_id);
            $status = "no_post_data";
        }
       // $this->response->setOutput(json_encode($status));
        echo json_encode($status);
        exit();
    }
    
    function blocktrail_success(){
         error_reporting(E_ALL);
         ini_set('display_errors', '1');
         $this->load->model('extension/payment/blocktrail');
         $bitcoin_settings = $this->model_extension_payment_blocktrail->getBlockTrailConfig();
        $bitcoin_address = $this->session->data['bitcoin_address'];
       
        $myAPIKEY = $this->config->get('blocktrail_api');
        $myAPISECRET = $this->config->get('blocktrail_api_secret');
        $mode = $this->config->get('blocktrail_mode');
        if ($mode == "test") {
            $testnet = true;
            $walletIdent = $this->config->get('blocktrail_wallet_name');
            $walletPassword = $this->config->get('blocktrail_wallet_password');
        } else {
            $testnet = false;
            $walletIdent = $this->config->get('blocktrail_wallet_name');
            $walletPassword = $this->config->get('blocktrail_wallet_password');
        }
        
        try {
            // Initialize the SDK
            $client = new BlocktrailSDK($myAPIKEY, $myAPISECRET, "BTC", $testnet);
            $response = $client->addressTransactions($bitcoin_address);
            if ($response['data']) {
                foreach ($response['data'][0]['outputs'] as $value) {
                    if ($value['address'] == $bitcoin_address) {
                        $satoshi = $value['value'];
                    }
                }
            }
            $transaction = $response['data'][0]['hash'];
            $return_address = $response['data'][0]['outputs'][0]['address'];
            $response_amount = number_format(($satoshi) * (pow(10, -8)), 8, '.', '');
        } catch (Exception $e) {
            $json['error'] = $e->getMessage();
        }
        $bitcoin_id = $this->session->data['bitcoin_id'];
        $total_amount =  $this->session->data['total_amount'];
        $bitcoin_price =  $this->session->data['current_btc'];
        $bitcoin_amount =  $this->session->data['bitcoin_amount'];
        $purpose = 'repurchase';
        $user_id = $this->customer->getUserId();
        if ($response_amount >= $bitcoin_amount) {
        $bitcoin_payment_details = $this->model_extension_payment_blocktrail->insertInToBitcoinPaymentDetails($bitcoin_id, $user_id, $purpose, $total_amount, $bitcoin_price, $bitcoin_amount, $response_amount, $bitcoin_address, $transaction, $return_address, $pending_status = FALSE,$this->session->data['order_id']);
           $result = $this->model_extension_payment_blocktrail->updateBitcoinHistory($user_id, $bitcoin_id, 'yes');
           $this->load->model('checkout/order');
           if($bitcoin_payment_details && $result ){
               $message = $return_address;
               $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], 5, $message, false);
                $json['success'] = $this->url->link('checkout/success', '', true);  
                
           }else {
               $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('config_order_status_id'));
               
                 $json['error'] = $this->language->get('an_error_occured');
         
	  }
        }else{
            $json['error'] = $this->language->get('an_error_occured');
        }
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));  
    }

}
