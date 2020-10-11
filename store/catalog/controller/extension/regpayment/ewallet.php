<?php

class ControllerExtensionRegPaymentEwallet extends Controller {

    public function index() {
        $this->load->language('extension/payment/ewallet');
        $data['entry_username'] = $this->language->get('entry_username');
        $data['entry_tran_password'] = $this->language->get('entry_tran_password');
        $data['entry_password'] = $this->language->get('entry_password');
        $data['button_confirm'] = $this->language->get('button_confirm');
        $data['ewallet_text_title'] = $this->language->get('ewallet_text_title');
        $data['username_verified'] = $this->language->get('username_verified');
        $data['invalid_username'] = $this->language->get('invalid_username');
        $data['verifying_username'] = $this->language->get('verifying_username');
        $data['logged_user_name'] = isset($this->session->data['inf_logged_in']['user_name']) ? $this->session->data['inf_logged_in']['user_name'] : '';

        return $this->load->view('extension/regpayment/ewallet', $data);
    }

    public function confirm() {
        $this->load->model('account/inf_register');
        if (!$this->model_account_inf_register->isRegistrationAllowed()) {
            $this->session->data['error_redirect'] = $this->language->get('registration_not_allowed');
            $json['redirect'] = $this->url->link('common/home', '', true);
            echo json_encode($json);
            exit();
        }

        $this->load->language('checkout/checkout');
        $this->load->language('extension/payment/ewallet');
        $this->load->model('extension/payment/ewallet');

        $total_amount = $this->model_extension_payment_ewallet->getOrderTotal($this->session->data['order_id']);
        $username = $this->request->post['username'];
        $tran_password = $this->request->post['tran_pswd'];
        $user_id = $this->customer->userNameToID($username);
        $json = array();

        if($username == '') {
            $json['warning'] = $this->language->get('please_enter_username');
        } else if($tran_password == '') {
            $json['warning'] = $this->language->get('please_enter_tran_password');
        } else if (!$this->model_extension_payment_ewallet->validateUsername($username)) {
            $json['warning'] = $this->language->get('invalid_username');
        } else if (!$this->model_extension_payment_ewallet->validateTranPassword($user_id, $tran_password)) {
            $json['warning'] = $this->language->get('invalid_tran_password');
        } else {

            $user_id = $this->customer->userNameToID($username);
            $user_balance_amount = $this->model_extension_payment_ewallet->getUserBalanceAmount($user_id);
            if ($user_balance_amount < $total_amount) {
                $json['warning'] = $this->language->get('not_enough_balance');
            } else {
                $res1 = $this->model_extension_payment_ewallet->updateUserbalanceAmount($user_id, $total_amount);
                if ($res1) {
                    
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

                    $payment_method = 'E-wallet';
                    // Clear any previous login attempts for unregistered accounts.
                    $this->model_account_customer->deleteLoginAttempts($step4_data['email']);

                    $customer_data = $this->model_account_inf_register->setCustomerData($step4_data);
                    $customer_data['payment_type'] = $payment_method;

                    //Add to MLM BackOffice//
                    if ($this->session->data['order_id']) {

                        $order_id = $this->session->data['order_id'];
                        $registered_user_id = 0;
                        $pending_id = 0;
                        $reg_data = $this->model_account_inf_register->setRegistrationData($step1_data, $step2_data, $step3_data['registration_pack'], $step4_data, $order_id);

                        if($this->model_account_inf_register->CheckPendingStatus($payment_method)) { 
                            $registration_details['customer_data'] = $customer_data;
                            $registration_details['reg_data'] = $reg_data; 

                            $pending_id = $this->model_account_inf_register->addTemporaryToBackOffice($registration_details);
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

//                      $amount_type_id = $this->model_extension_payment_ewallet->amountTypeToId('registration');
                        $res2 = $this->model_extension_payment_ewallet->insertUsedEwallet($user_id, $registered_user_id, $total_amount, 'registration', $pending_id);

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
                    $json['error'] = $this->language->get('an_error_occured');
                }
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function validateUsername() {
        $this->load->model('extension/payment/ewallet');
        $username = $this->request->post['user_name'];
        echo $this->model_extension_payment_ewallet->validateUsername($username);
    }

}
