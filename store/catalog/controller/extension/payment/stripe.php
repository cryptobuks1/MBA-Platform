<?php
class ControllerExtensionPaymentStripe extends Controller {

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
		$data['action'] = $this->url->link('extension/payment/stripe/confirm', '', true);

		return $this->load->view('extension/payment/stripe', $data);
	}

	public function confirm(){
		ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

        // load stripe libraries
		$this->initStripe();
		$this->load->model('extension/payment/stripe');
		$json = array('error' => 'Server did not get valid request to process');

	
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

            // Charge the order:
            $first_name='';
            $last_name='';
            $this->load->model('account/inf_register');
            
                $first_name = $this->customer->getFirstName();
                $last_name =$this->customer->getLastName();
            $email=$this->customer->getEmail();
            try {
                $charge = \Stripe\Charge::create([
                            "customer"    => $customer->id,
                            "amount" => $cents,
                            "currency" => "usd",
                            //"source" => $this->request->post['stripeToken'],
                            "description" => "Repurchase order Id:" . $order_info['order_id'],
                            "metadata" => ["first_name" => $first_name,"last_name" => $last_name,"email" =>$email],
                ]);
            } catch (Exception $ex) {
               
                $this->model_checkout_order->addStripResponse(serialize($curl_data), 'repurchase_strip order_id:' . $this->session->data['order_id'], json_encode(substr($ex, 0, 1000)));

                $json['error'] = 'Payment unsuccessfull.Please verify the details.'.substr($ex, 0, 1000);

                $this->log->write('Payment unsuccessfull.Please verify the details.');
                $json['redirect'] = $this->url->link('checkout/checkout', '', false);
                  $this->response->redirect($this->url->link('checkout/checkout', 'Repurchase Failed', false));
            }

            // Retrieve charge details
            $chargeJson = $charge->jsonSerialize();

            // Check whether the charge is successful
            if ($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1) {
                    $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], 5, $comment, true);
                    $this->load->model('account/inf_register');
                    $customer_id = $this->customer->getId();
                    $user_id = $this->customer->getUserId();
                    $this->model_account_inf_register->calculateUserRepurchaseCommissions($this->session->data['order_id'], $customer_id, $user_id);
                    $this->response->redirect($this->url->link('checkout/success', 'success', true));
            } else {
                $json['error'] = 'Payment unsuccessfull.Please verify the details.';

                $this->response->redirect($this->url->link('checkout/checkout', 'Register failed', false));
            }
        }
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		return;
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
				$this->model_checkout_order->addOrderHistory($order_info['order_id'], $this->config->get('stripe_order_success_status_id'), $message, false);
			} else {
				$this->model_checkout_order->addOrderHistory($order_info['order_id'], $this->config->get('stripe_order_failed_status_id'), $message, false);
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
	function to_pennies($value) {
        return intval(
                strval(floatval(
                                preg_replace("/[^0-9.]/", "", $value)
                        ) * 100)
        );
    }
}