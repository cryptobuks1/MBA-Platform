<?php

class ControllerExtensionPaymentEpin extends Controller {

    public function index() {
        $this->load->language('extension/payment/epin');

        $this->load->model('extension/payment/epin');

        $data['cart_total'] = $this->model_extension_payment_epin->getOrderTotal($this->session->data['order_id']);

        $data['button_confirm'] = $this->language->get('button_express_confirm');
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
        $data['continue'] = $this->url->link('checkout/success');
        $data['link_confirm'] = $this->url->link('extension/payment/epin/confirm', '', TRUE);
        $data['link_pass_availability'] = $this->url->link('extension/payment/epin/pass_availability', '', TRUE);

        return $this->load->view('extension/payment/epin', $data);
    }

    public function confirm() {
        $this->load->model('extension/payment/epin');
        $this->load->model('account/inf_register');
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
            $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('epin_order_status_id'));
            
            $json['success'] = $this->url->link('checkout/success');
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
