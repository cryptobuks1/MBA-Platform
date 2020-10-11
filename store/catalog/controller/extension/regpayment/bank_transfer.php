<?php
class ControllerExtensionRegPaymentBankTransfer extends Controller {
	public function index() {
		$this->load->language('extension/payment/bank_transfer');

		$data['text_instruction'] = $this->language->get('text_instruction');
		$data['text_description'] = $this->language->get('text_description');
		$data['text_payment'] = $this->language->get('text_payment');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['button_confirm'] = $this->language->get('button_confirm');

		$data['bank'] = nl2br($this->config->get('bank_transfer_bank' . $this->config->get('config_language_id')));

		$data['continue'] = $this->url->link('register/success');

		return $this->load->view('extension/regpayment/bank_transfer', $data);
	}

	public function confirm() {
		if ($this->session->data['payment_method']['code'] == 'bank_transfer') {
			$this->load->language('extension/payment/bank_transfer');

            //Register Customer//
            $this->load->model('account/inf_register');
            if (!$this->model_account_inf_register->isRegistrationAllowed()) {
                $this->session->data['error_redirect'] = $this->language->get('registration_not_allowed');
                echo $this->url->link('common/home', '', true);
                exit();
            }
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

            // Clear any previous login attempts for unregistered accounts.
            $this->model_account_customer->deleteLoginAttempts($step4_data['email']);

            $customer_data = $this->model_account_inf_register->setCustomerData($step4_data);
            $customer_data['payment_type'] = 'Bank Transfer';
 
            //Add to MLM BackOffice//
            if ($this->session->data['order_id']) {

                $order_id = $this->session->data['order_id'];
                $reg_data = $this->model_account_inf_register->setRegistrationData($step1_data, $step2_data, $step3_data['registration_pack'], $step4_data, $order_id);
                 $customer_data['reg_type']='customer';
                        if(isset($this->session->data['inf_reg_data']['reg_type'])){ 
                             $customer_data['reg_type'] = $this->session->data['inf_reg_data']['reg_type']; 
                             $reg_data['reg_type'] = $this->session->data['inf_reg_data']['reg_type']; 
                        }
                $mlm_session = $this->customer->getMlmSession();
                if (!isset($mlm_session['replica_user'])) {
                    if (!$this->model_account_inf_register->isSponsorRequired()) {
                        $read_only = true;
                        $reg_data['sponsor_user_name'] = ADMIN_USER_NAME;
                    }
                }

                $registration_details['customer_data'] = $customer_data;
                $registration_details['reg_data'] = $reg_data; 
                $this->model_account_inf_register->addTemporaryToBackOffice($registration_details);

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
                echo $this->url->link('register/success');
                exit();
            }
                }
	}
}