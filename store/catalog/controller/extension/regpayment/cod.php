<?php
class ControllerExtensionRegPaymentCod extends Controller {
	public function index() {
		$data['button_confirm'] = $this->language->get('button_confirm');

		$data['text_loading'] = $this->language->get('text_loading');

		$data['continue'] = $this->url->link('register/success');

		return $this->load->view('extension/regpayment/cod', $data);
	}

	public function confirm() {
		if ($this->session->data['payment_method']['code'] == 'cod') {
			
            //Register Customer//
            $this->load->model('account/inf_register');
            if (!$this->model_account_inf_register->isRegistrationAllowed()) {
                $this->session->data['error_redirect'] = $this->language->get('registration_not_allowed');
                echo $this->url->link('common/home', '', true);
                exit();
            }
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

            $order_id = $this->session->data['order_id'];
            $customer_data = $this->model_account_inf_register->setCustomerData($step4_data);
            $customer_data['payment_type'] = 'Cash On Delivery';
            $reg_data = $this->model_account_inf_register->setRegistrationData($step1_data, $step2_data, $step3_data['registration_pack'], $step4_data, $order_id);
            $customer_data['reg_type']='customer';
            if(isset($this->session->data['inf_reg_data']['reg_type'])){ 
                 $customer_data['reg_type'] = $this->session->data['inf_reg_data']['reg_type']; 
            }
            
            $registration_details['customer_data'] = $customer_data;
            $registration_details['reg_data'] = $reg_data;
            $registration_details['position'] = $step1_data['position'];

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
