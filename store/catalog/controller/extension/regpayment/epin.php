<?php

class ControllerExtensionRegPaymentEpin extends Controller {

    public function index() {
        $this->load->language('extension/payment/epin');

        $this->load->model('extension/payment/epin');

        $data['cart_total'] = $this->model_extension_payment_epin->getOrderTotal($this->session->data['order_id']);

        $data['button_confirm'] = $this->language->get('button_confirm');
        $data['text_wait'] = $this->language->get('text_wait');
        $data['text_no'] = $this->language->get('text_no');
        $data['text_epin'] = $this->language->get('text_epin');
        $data['text_duplicate_epin_entry'] = $this->language->get('text_duplicate_epin_entry');
        $data['text_please_enter_epin'] = $this->language->get('text_please_enter_epin');
        $data['text_invalid_epin'] = $this->language->get('text_invalid_epin');
        $data['text_epin_validated'] = $this->language->get('text_epin_validated');
        $data['text_insufficient_amount'] = $this->language->get('text_insufficient_amount');
        $data['text_epin_amount'] = $this->language->get('text_epin_amount');
        $data['text_required_amount'] = $this->language->get('text_required_amount');
        $data['text_epin_balance'] = $this->language->get('text_epin_balance');
        $data['text_checkout_epin_details'] = $this->language->get('text_checkout_epin_details');
        $data['continue'] = $this->url->link('register/success');
        $data['link_confirm'] = $this->url->link('extension/regpayment/epin/confirm', '', TRUE);
        $data['link_pass_availability'] = $this->url->link('extension/regpayment/epin/pass_availability', '', TRUE);

        return $this->load->view('extension/regpayment/epin', $data);
    }

    public function confirm() {
        $this->load->model('account/inf_register');
        if (!$this->model_account_inf_register->isRegistrationAllowed()) {
            $this->session->data['error_redirect'] = $this->language->get('registration_not_allowed');
            $json['redirect'] = $this->url->link('common/home', '', true);
            echo json_encode($json);
            exit();
        }
        $this->load->model('extension/payment/epin');
        $this->load->model('checkout/order');
       
        $input = file_get_contents('php://input');
        $jsonData = json_decode($input, TRUE);
        $total_amount = $jsonData['total_amount'];
        $pin_array = $jsonData['pin_array'];
        $json = array();
        
        $customer_id = $this->customer->getId();
        $order_id = $this->session->data['order_id'];

        $pin_count = count($pin_array);
        $amount = $total_amount;
        $ft_user_id = $this->customer->getUserId();

        $pin_details = $this->model_extension_payment_epin->checkAllEpins($pin_array, $total_amount);
        $error_epin = $pin_details['error'] ?? false;
        if ($error_epin) {
            $res1 = $res2 = false;
        }
        else {
            $res1 = $this->model_extension_payment_epin->updateUsedEpin($pin_details, $pin_count, $ft_user_id);
            $res2 = $this->model_extension_payment_epin->insertToUsedPin($pin_details, $pin_count, $ft_user_id);
        }

        if ($res1 && $res2) {
            
            //Register Customer//
            $this->load->model('checkout/order');

            $comment = '';

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

            $payment_method = 'E-pin';
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
                    $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('epin_order_status_id'), $comment, true);

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
                if (isset($this->session->data['inf_placement_array'])) {
                    unset($this->session->data['inf_placement_array']);
                }
                $this->cart->clear();

            }
            $json['success'] = $this->url->link('register/success');
        } else {
            $json['error'] = $this->language->get('error_processing');
        }
        
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function pass_availability() {
        $input = file_get_contents('php://input');
        $jsonData = json_decode($input, TRUE);
        $total_amount = $jsonData['total_amount'];
        $pin_details = $jsonData['pin_array'];
        $this->load->model('extension/payment/epin');
        $pin_array = $this->model_extension_payment_epin->checkAllEpins($pin_details, $total_amount);
        $value = json_encode($pin_array);
        echo $value;
        exit();
    }

}
