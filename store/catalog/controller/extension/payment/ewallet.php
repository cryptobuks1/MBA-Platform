<?php

class ControllerExtensionPaymentEwallet extends Controller {

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
        $data['logged_user_name'] = $this->session->data['inf_logged_in']['user_name'];

        return $this->load->view('extension/payment/ewallet', $data);
    }

    public function confirm() {
        $this->load->language('checkout/checkout');
        $this->load->language('extension/payment/ewallet');
        $this->load->model('extension/payment/ewallet');

        $total_amount = $this->model_extension_payment_ewallet->getOrderTotal($this->session->data['order_id']);
        $username = $this->request->post['username'];
        $tran_password = $this->request->post['tran_pswd'];
        $user_id = $this->customer->userNameToID($username);
        $used_user_id = $this->session->data['inf_logged_in']['user_id'];
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
                $transaction_id = $this->model_extension_payment_ewallet->getUniqueTransactionId();
               $res2 = $this->model_extension_payment_ewallet->insertUsedEwallet($user_id, $used_user_id, $total_amount, 'repurchase');                       
              //  $res3 = $this->model_extension_payment_ewallet->addEwalletHistory($user_id,$used_user_id,$res2,'ewallet_payment',$total_amount,'repurchase','debit',$transaction_id);
                if ($res1 && $res2) {
                    $this->load->model('checkout/order');
                    $comment = $this->language->get('text_instruction') . "\n\n";
                    $comment .= $this->config->get('bank_transfer_bank' . $this->config->get('config_language_id')) . "\n\n";
                    $comment .= $this->language->get('text_payment');

                    $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('bank_transfer_order_status_id'), $comment, true);

                    $json['success'] = $this->url->link('checkout/success');
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
