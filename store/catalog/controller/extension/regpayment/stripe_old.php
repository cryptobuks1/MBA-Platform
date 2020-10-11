<?php
class ControllerExtensionRegPaymentStripe extends Controller {

	public function index() {

		// load all language variables
		$data = $this->load->language('extension/payment/stripe');

		if ($this->request->server['HTTPS']) {
			$data['store_url'] = HTTPS_SERVER;
		} else {
			$data['store_url'] = HTTP_SERVER;
		}

		if($this->config->get('stripe_environment') == 'live') {
			$data['stripe_public_key'] = $this->config->get('stripe_live_public_key');
			$data['test_mode'] = false;
		} else {
			$data['stripe_public_key'] = $this->config->get('stripe_test_public_key');
			$data['test_mode'] = true;
		}
       	$stripe_secret_key = $this->config->get('stripe_test_secret_key');
        $data['key'] =$stripe_secret_key;
		// get order info
		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		// get order billing country
		$this->load->model('localisation/country');
  		$country_info = $this->model_localisation_country->getCountry($order_info['payment_country_id']);
		
		// we will use this owner info to send Stripe from client side
		$data['billing_details'] = array(
										'billing_details' => array(
											'name' => $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'],
											'email' => $order_info['email'],
											'address' => array(
												'line1'	=> $order_info['payment_address_1'],
												'line2'	=> $order_info['payment_address_2'],
												'city'	=> $order_info['payment_city'],
												'state'	=> $order_info['payment_zone'],
												'postal_code' => $order_info['payment_postcode'],
												'country' => $country_info['iso_code_2']
											)
										)
									);
        //$data['action'] = $this->url->link('extension/regpayment/authorizenet_aim/send', '', true);
        

        $stripe_key = $this->model_checkout_order->get_stripe_key();

        $data['stripe_key'] = $stripe_key;
        $data['months'] = array();

        for ($i = 1; $i <= 12; $i++) {
            $data['months'][] = array(
                'text' => strftime('%B', mktime(0, 0, 0, $i, 1, 2000)),
                'value' => sprintf('%02d', $i)
            );
        }

        $today = getdate();

        $data['year_expire'] = array();

        for ($i = $today['year']; $i < $today['year'] + 11; $i++) {
            $data['year_expire'][] = array(
                'text' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)),
                'value' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i))
            );
        }
		// handles the XHR request for client side
		$data['action'] = $this->url->link('extension/regpayment/stripe/confirm', '', true);

		return $this->load->view('extension/payment/stripe', $data);
	}

	public function confirm(){
	
		$json = array();
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        // load stripe libraries
		$this->initStripe();
        if ($this->request->post['stripeToken'] == '') {

                $data['error_warning'] = 'Payment unsuccessfull.Please verify the details.';// = 'Payment unsuccessfull.Please verify the details.';
            $this->log->write('Payment unsuccessfull.Please verify the details.');
            $this->response->redirect($this->url->link('common/home', $data, false));
        }

        $this->load->model('checkout/order');

        $this->load->model('account/inf_register');

        \Stripe\Stripe::setApiKey($this->model_checkout_order->get_stripe_secret_key());


        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        $charge = '';
        $webhook = '';
        $plan = '';
        $subscription = '';
        $comment = '';

        if (!isset($json['redirect'])) {
            $customer = '';
            $amount = $this->currency->format($order_info['total'], $order_info['currency_code'], 1.00000, false);
            $curl_data = ['amount' => $amount, 'order_id' => $this->session->data['order_id']];
            $cents = $this->to_pennies($amount);

            //Create Customer:
            // Charge the order:
            try {
                $customer = \Stripe\Customer::create([
                            "description" => "Customer for " . $this->customer->getEmail(),
                            'email' => $this->customer->getEmail(),
                                // "source" => $this->request->post['stripeToken'] // obtained with Stripe.js
                ]);
            } catch (Exception $ex) {

                $this->model_checkout_order->addStripResponse(serialize($curl_data), 'repurchase_strip order_id:' . $this->session->data['order_id'], json_encode(substr($ex, 0, 1000)));

                $json['error'] = 'Payment unsuccessfull.Please verify the details.';
            }

            // Charge the order:
            try {
                $charge = \Stripe\Charge::create([
                            "amount" => $cents,
                            "currency" => "usd",
                            "source" => $this->request->post['stripeToken'],
                            "description" => "Repurchase order Id:" . $order_info['order_id']
                ]);
            } catch (Exception $ex) {
               
                $this->model_checkout_order->addStripResponse(serialize($curl_data), 'repurchase_strip order_id:' . $this->session->data['order_id'], json_encode(substr($ex, 0, 1000)));

                $json['error'] = 'Payment unsuccessfull.Please verify the details.';

                $this->log->write('Payment unsuccessfull.Please verify the details.');
                //$json['redirect'] = $this->url->link('checkout/checkout', '', false);
                 $this->response->redirect($this->url->link('register/user', 'Payment unsuccessfull.Please verify the details.', false));
            }

            // Retrieve charge details
            $chargeJson = $charge->jsonSerialize();

            // Check whether the charge is successful
            if ($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1) {
                $this->model_checkout_order->addStripResponse(serialize($curl_data), 'Repuerchase_strip order_id:' . $this->session->data['order_id'], json_encode(substr($charge, 0, 1000)));               

                //reccuring
                $reccuring = '';
                $recurring_products = "";
                $product_details = $this->model_checkout_order->getOrderProduct($this->session->data['order_id']);
                 $item=array(
                            'product_id' => $product_details['product_id'],
                            'name' => 'rec1',
                            'quantity' => 1,
                                );
                        $item['recurring']['recurring_id']=1;
                        $item['recurring']['name']='rec1';
                        $item['recurring']['frequency']=1;
                        $item['recurring']['cycle']=1;
                        $item['recurring']['duration']=1;
                        $item['recurring']['price']=19.95;
                        $item['recurring']['trial']='1';
                        $item['recurring']['trial_frequency']='1';
                        $item['recurring']['trial_cycle']='1';
                        $item['recurring']['trial_duration']='1';
                        $item['recurring']['trial_price']='0';
               // $recurring_products = $this->cart->getRecurringProducts();
//
               // foreach ($recurring_products as $item) {
                    // Set your secret key: remember to change this to your live secret key in production
                    // See your keys here: https://dashboard.stripe.com/account/apikeys
                    try {
                        $token = \Stripe\Token::create([
                                    'card' => [
                                        'number' => $this->request->post['card_num'],
                                        'exp_month' => $this->request->post['exp_month'],
                                        'exp_year' => $this->request->post['exp_year'],
                                        'cvc' => $this->request->post['cvc'],
                                    ]
                        ]);
                    } catch (Exception $ex) {

                        $this->model_checkout_order->addStripResponse(serialize($curl_data), 'repurchase_strip order_id:' . $this->session->data['order_id'], json_encode(substr($ex, 0, 1000)));

                        $json['error'] = 'Payment unsuccessfull.Please verify the details.';

                        $this->log->write('Payment unsuccessfull.Please verify the details.');
                        //$json['redirect'] = $this->url->link('checkout/checkout', '', false);
                    }

                    try {
                        $customer = \Stripe\Customer::create([
                                    'source' => $token->id,
                                    "description" => "Customer for " . $this->customer->getEmail(),
                                    'email' => $this->customer->getEmail(),
                                        // "source" => $this->request->post['stripeToken'] // obtained with Stripe.js
                        ]);
                    } catch (Exception $ex) {

                        $this->model_checkout_order->addStripResponse(serialize($curl_data), 'repurchase_strip order_id:' . $this->session->data['order_id'], json_encode(substr($ex, 0, 1000)));

                        $json['error'] = 'Payment unsuccessfull.Please verify the details.';

                        $this->log->write('Payment unsuccessfull.Please verify the details.');
                        //$json['redirect'] = $this->url->link('checkout/checkout', '', false);
                    }
                    if($customer->id) {
                   $recurr_tran_id = $this->model_checkout_order->addSubscriptionDetails(serialize($curl_data), 'Repuerchase_reccuring_subcription_fadded order_id:' . $this->session->data['order_id'], $customer->id, $this->session->data['order_id'], $item, json_encode($customer));
                    }
                //}
                        
                    $this->load->language('extension/payment/bank_transfer');

                    //Register Customer//
                    $this->load->model('account/inf_register');

                    $this->load->model('checkout/order');

                    $comment .= "Stripe registration";

                    $this->load->model('account/customer');

                    $step1_data = $this->session->data['inf_reg_data']['step1'];
                    $step2_data = $this->session->data['inf_reg_data']['step2'];
                    $step3_data = $this->session->data['inf_reg_data']['step3'];
                    $step4_data = $this->session->data['inf_reg_data']['step4'];

                    if ($this->model_account_inf_register->isSponsorRequired() && $this->customer->getUserType() == 'user') {
                        if ($step1_data['sponsor_user_name'] != $this->customer->getUserName()) {
                            $this->session->data['error_redirect'] = $this->language->get('invalid_sponsor_name');
                            echo $this->url->link('common/home', '', true);
                            exit();
                        }
                    }
                    $customer_data = array();
                    if (isset($step4_data['customer_group_id'])) {
                        $customer_data['customer_group_id'] = $step4_data['customer_group_id'];
                    }
               
                    $customer_data['firstname'] = $step4_data['firstname'];
                    $customer_data['lastname'] = $step4_data['lastname'];
                    $customer_data['email'] = $step4_data['email'];
                    $customer_data['telephone'] = $step4_data['telephone'];
                    $customer_data['fax'] = $step4_data['fax'];

                    if (isset($step4_data['custom_field'])) {
                        $customer_data['custom_field'] = $step4_data['custom_field']['account'];
                    }

                    $customer_data['password'] = $step4_data['password'];
                    $customer_data['newsletter'] = $step4_data['newsletter'];
                    $customer_data['company'] = $step4_data['company'];
                    $customer_data['address_1'] = $step4_data['address_1'];
                    $customer_data['address_2'] = $step4_data['address_2'];
                    $customer_data['city'] = $step4_data['city'];
                    $customer_data['postcode'] = $step4_data['postcode'];
                    $customer_data['country_id'] = $step4_data['country_id'];
                    $customer_data['zone_id'] = $step4_data['zone_id'];
                    $customer_data['config_store_id'] = $this->config->get('config_store_id');
                    $customer_data['config_language_id'] = $this->config->get('config_language_id');
                    $customer_data['salt'] = token(9);
                    $customer_data['ip'] = $this->request->server['REMOTE_ADDR'];
                    $customer_data['order_id'] = $this->session->data['order_id'];
                    $customer_data['cod_order_status_id'] = $this->config->get('cod_order_status_id');
                    ;

                    // Clear any previous login attempts for unregistered accounts.
                    $this->model_account_customer->deleteLoginAttempts($step4_data['email']);

                    $reg_data = array();

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
                    $this->model_checkout_order->addOrderHistory($this->session->data['order_id'],5, $comment, true);
                    $reg_data['customer_id'] = $customer_id;
                    $this->model_checkout_order->updateRecurringCustID($customer_id,$recurr_tran_id);

                    //Add to MLM BackOffice//
                    if ($this->session->data['order_id']) {
                        $order_id = $this->session->data['order_id'];
                        $registered_user_id = 0;
                        $pending_id = 0;
                        $reg_data = $this->model_account_inf_register->setRegistrationData($step1_data, $step2_data, $step3_data['registration_pack'], $step4_data, $order_id);
                        $customer_data['reg_type']='customer';
                        if(isset($this->session->data['inf_reg_data']['reg_type'])){ 
                             $customer_data['reg_type'] = $this->session->data['inf_reg_data']['reg_type']; 
                             $reg_data['reg_type'] = $this->session->data['inf_reg_data']['reg_type']; 
                        }
                       /* if($this->model_account_inf_register->CheckPendingStatus($payment_method)) { 
                            
                            $registration_details['customer_data'] = $customer_data;
                            $registration_details['reg_data'] = $reg_data; 

                            $pending_id = $this->model_account_inf_register->addTemporaryToBackOffice($registration_details);
                        } else {*/
                            $this->model_account_inf_register->addToBackOffice($reg_data);

                            
                             $registered_user_id = $this->customer->userNameToID($reg_data['user_name_entry']);
                            $this->model_account_inf_register->updateCustomerId($registered_user_id, $customer_id);
                            $this->model_account_inf_register->UpdateConfimed($order_id);
                        //}
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
                        if (isset($this->session->data['inf_placement_array'])) {
                            unset($this->session->data['inf_placement_array']);
                        }
                        $this->cart->clear();
                    }
              
                //$json['redirect'] = $this->url->link('checkout/success', '', true);
            } else {
                $json['error'] = 'Payment unsuccessfull.Please verify the details.';

                $this->response->redirect($this->url->link('register/user', 'Register failed', false));
            }
        }

        $this->response->redirect($this->url->link('register/success', '', true));
        
    }

    function to_pennies($value) {
        return intval(
                strval(floatval(
                                preg_replace("/[^0-9.]/", "", $value)
                        ) * 100)
        );
    }

    public function getCustomerIdByOrderId($order_id) {
        $query = $this->db->query("SELECT `customer_id` FROM `" . DB_PREFIX . "order` WHERE `order_id` = '" . (int) $order_id . "'");

        if ($query->num_rows) {
            return $query->row['customer_id'];
        } else {
            return 0;
        }
    }


	/**
	 * this method charges the source and update order accordingly
	 * @returns boolean
	 */
	private function chargeAndUpdateOrder($intent, $order_info){

		if(isset($intent->id)) {

			// insert stripe order
			$message = 'Payment Intent ID: '.$intent->id. PHP_EOL .'Status: '. $intent->status;

			$this->load->model('checkout/order');

			// update order statatus & addOrderHistory
			// paid will be true if the charge succeeded, or was successfully authorized for later capture.
			if($intent->status == "succeeded") {
				$this->model_checkout_order->addOrderHistory($order_info['order_id'], 5, $message, false);
			} else {
				$this->model_checkout_order->addOrderHistory($order_info['order_id'], 5, $message, false);
			}

			
			// charge completed successfully
			return true;
		
		} else {
			// charge could not be completed
			return false;
		}
	}

	private function initStripe() {
		$this->load->library('stripe');
		if($this->config->get('stripe_environment') == 'live' || (isset($this->request->request['livemode']) && $this->request->request['livemode'] == "true")) {
			$stripe_secret_key = $this->config->get('stripe_live_secret_key');
		} else {
			$stripe_secret_key = $this->config->get('stripe_test_secret_key');
		}

		if($stripe_secret_key != '' && $stripe_secret_key != null) {
			\Stripe\Stripe::setApiKey($stripe_secret_key);
			return true;
		}

		$this->load->model('extension/payment/stripe');
		$this->model_extension_payment_stripe->log(__FILE__, __LINE__, "Unable to load stripe libraries");
		throw new Exception("Unable to load stripe libraries.");
		// return false;
	}
}