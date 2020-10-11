<?php


require "../vendor/autoload.php";

use Blocktrail\SDK\BlocktrailSDK;

class ControllerExtensionRegPaymentBlocktrail extends Controller {

    private $error = array();

    public function index() {

        //$bitcoin_settings = $this->config->get('authorizenet_aim_login');
        $this->load->model('extension/payment/blocktrail');
        $this->load->language('extension/payment/blocktrail');

        $data['info'] = $this->language->get('info');
        
        //$bitcoin_settings = $this->model_extension_payment_blocktrail->getBlockTrailConfig();
                
            $this->load->model('account/inf_register');
            if (!$this->model_account_inf_register->isRegistrationAllowed()) {
                $this->session->data['error_redirect'] = $this->language->get('registration_not_allowed');
                echo $this->url->link('common/home', '', true);
                exit();
            }
        
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
       
        //  $this->session->set_userdata('bitcoin_price', $bitcoin_price);
        $bitcoin_amount =round( $total_amount / $bitcoin_price ,8);
        
        if($this->customer->isLogged())
            $user_id = $this->customer->getUserId();
        else
            $user_id = $this->customer->getAdminUserId();
        
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
            
            $data['user_name'] = isset($this->session->data['inf_logged_in']['user_name']) ? $this->session->data['inf_logged_in']['user_name'] : '';
            $data['button_confirm']   = $this->language->get('button_confirm');
            $data['continue']         = $this->url->link('checkout/success');
            $data['qr_code'] = $qr_code;
            $data['bitcoin_address'] = $bitcoin_address;
            $data['qr_btc_amount'] = $qr_btc_amount;
             $this->session->data['bitcoin_amount'] = $bitcoin_amount;
             $this->session->data['total_amount'] = $total_amount;
             $this->session->data['current_btc'] = $bitcoin_price;
             $bitcoin_id = $this->model_extension_payment_blocktrail->bitcoinHistory($data['user_name'], $data, 'register');
              $this->session->data['bitcoin_id'] = $bitcoin_id;

        } catch (Exception $e) {
            $json['error'] = $e->getMessage();
        }

        
        return $this->load->view('extension/regpayment/blocktrail', $data);
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
  
        //$bitcoin_settings = $this->model_extension_payment_blocktrail->getBlockTrailConfig();
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
        if ($this->customer->isLogged()){
            $user_id = $this->customer->getUserId();
            $regr['user_name_entry'] = $this->session->data['inf_logged_in']['user_name'];
        } else {
            $user_id = $this->customer->getAdminUserId();
            $regr['user_name_entry'] = $this->customer->idToUserName($user_id) ;
        }
        

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
         $this->load->model('account/inf_register');
         //$bitcoin_settings = $this->model_extension_payment_blocktrail->getBlockTrailConfig();
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
        $purpose = 'Opencaert Register';
        
        if($this->customer->isLogged())
        $user_id = $this->customer->getUserId();
        else
        $user_id = $this->customer->getAdminUserId();
        
        if ($response_amount >= $bitcoin_amount) {
        $bitcoin_payment_details = $this->model_extension_payment_blocktrail->insertInToBitcoinPaymentDetails($bitcoin_id, $user_id, $purpose, $total_amount, $bitcoin_price, $bitcoin_amount, $response_amount, $bitcoin_address, $transaction, $return_address, $pending_status = FALSE,$this->session->data['order_id']);
           $result = $this->model_extension_payment_blocktrail->updateBitcoinHistory($user_id, $bitcoin_id, 'yes');
           $this->load->model('checkout/order');
           if ($bitcoin_payment_details && $result ) {
                //Register Customer//
                $this->load->model('checkout/order');

                $comment = $this->language->get('text_instruction') . "\n\n";
                $comment .= $this->config->get('bank_transfer_bank' . $this->config->get('config_language_id')) . "\n\n";
                $comment .= $this->language->get('text_payment');

                $this->load->model('account/customer');

                $step1_data = $this->session->data['inf_reg_data']['step1'];
                $step2_data = $this->session->data['inf_reg_data']['step2'];
                $step3_data = $this->session->data['inf_reg_data']['step3'];
                $step4_data = $this->session->data['inf_reg_data']['step4'];

                if (MLM_PLAN == 'Binary') {
                    if ($step1_data['reg_from_tree'] && $step1_data['placement_user_name']) {
                        $sponsor_name = $step1_data['placement_user_name'];
                    } else {
                        $sponsor_name = $step1_data['sponsor_user_name'];
                    }
                    $sponsor_id = $this->customer->userNameToID($sponsor_name);
                    $binary_leg = $this->model_account_inf_register->getAllowedBinaryLeg($sponsor_id, $this->customer->getUserType(), $this->customer->getUserId());
                    if (MLM_PLAN == 'Binary' && $binary_leg != 'any' && $binary_leg != $step1_data['position']) {
                        $this->session->data['error_redirect'] = $this->language->get('position_not_usable');
                        echo $this->url->link('common/home', '', true);
                        exit();
                    }
                }

                if ($this->model_account_inf_register->isSponsorRequired() && $this->customer->getUserType() == 'user') {
                    if ($step1_data['sponsor_user_name'] != $this->customer->getUserName()) {
                        $this->session->data['error_redirect'] = $this->language->get('invalid_sponsor_name');
                        echo $this->url->link('common/home', '', true);
                        exit();
                    }
                }

                $payment_method = 'Bitcoin';
                // Clear any previous login attempts for unregistered accounts.
                $this->model_account_customer->deleteLoginAttempts($step4_data['email']);

                $customer_data = $this->model_account_inf_register->setCustomerData($step4_data);
                $customer_data['payment_type'] = $payment_method;

                //Add to MLM BackOffice//
                if ($this->session->data['order_id']) {

                    $order_id = $this->session->data['order_id'];
                    $reg_data = $this->model_account_inf_register->setRegistrationData($step1_data, $step2_data, $step3_data['registration_pack'], $step4_data, $order_id);

                    if($this->model_account_inf_register->CheckPendingStatus($payment_method)) {
                        $registration_details['customer_data'] = $customer_data;
                        $registration_details['reg_data'] = $reg_data;

                        $this->model_account_inf_register->addTemporaryToBackOffice($registration_details);
                    } else {
                        $this->model_account_inf_register->addToBackOffice($reg_data);
                    
                        $customer_id = $this->model_account_customer->addCustomer($customer_data);
                        // Add to activity log
                        $this->load->model('account/activity');
                        $activity_data = array(
                            'customer_id' => $customer_id,
                            'name' => $step4_data['firstname'] . ' ' . $step4_data['lastname']
                        );
                        $this->model_account_activity->addActivity('register', $activity_data);
        
                        $this->load->model('register/user');
                        $this->model_register_user->updateOrderCustomerID($this->session->data['order_id'], $customer_id);

                        $message = $return_address;
                        $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], 5, $message, true);
                        
                        $registered_user_id = $this->customer->userNameToID($reg_data['user_name_entry']);
                        $this->model_account_inf_register->updateCustomerId($registered_user_id, $customer_id);
                        $this->model_account_inf_register->UpdateConfimed($order_id);
                    }

                    unset($this->session->data['inf_reg_data']);
                    unset($this->session->data['shipping_method']);
                    unset($this->session->data['shipping_methods']);
                    unset($this->session->data['payment_method']);
                    unset($this->session->data['payment_methods']);
                    unset($this->session->data['guest']);
                    unset($this->session->data['comment']);
                    unset($this->session->data['order_id']);
                    unset($this->session->data['coupon']);
                    unset($this->session->data['reward']);
                    unset($this->session->data['voucher']);
                    unset($this->session->data['vouchers']);
                    unset($this->session->data['totals']);
                    unset($this->session->data['bitcoin_address']);
                    unset($this->session->data['bitcoin_id']);
                    unset($this->session->data['current_btc']);
                    unset($this->session->data['bitcoin_amount']);
                    unset($this->session->data['total_amount']);

                    if (isset($this->session->data['inf_placement_array'])) {
                        unset($this->session->data['inf_placement_array']);
                    }
                    $this->cart->clear();
                }
                $json['success'] = $this->url->link('register/success');
            } else {

                $json['error'] = $this->language->get('payment_not_initilised');
            }
        } else{
                  $json['error'] = $this->language->get('an_error_occured');
            }
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));  
    }

}
