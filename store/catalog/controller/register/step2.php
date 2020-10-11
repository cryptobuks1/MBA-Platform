<?php

class ControllerRegisterStep2 extends Controller {

    public function index() {
        $this->load->language('register/step2');

        $data['entry_sponsor_name'] = $this->language->get('entry_sponsor_name');
        $data['text_sponsor_name_description'] = $this->language->get('text_sponsor_name_description');

        $data['button_back'] = $this->language->get('button_back');
        $data['button_continue'] = $this->language->get('button_continue');

        if (isset($this->session->data['inf_reg_data']['step1'])) {

            $sponsor_user_name = $this->session->data['inf_reg_data']['step1']['sponsor_user_name'];

            $this->load->model('register/user');

            $sponsor_name = $this->model_register_user->getSponsorFullName($sponsor_user_name);

            $data['sponsor_name'] = $this->session->data['inf_reg_data']['step2']['sponsor_name'] = $sponsor_name;
        } else {
            $this->response->redirect($this->url->link('register/user', '', true));
        }

        $this->response->setOutput($this->load->view('register/step2', $data));
        
    }

    public function save() {

        $this->load->language('register/step1');

        $json = array();

        $this->load->model('account/inf_register');
        if (!$this->model_account_inf_register->isRegistrationAllowed()) {
            $this->session->data['error_redirect'] = $this->language->get('registration_not_allowed');
            $json['redirect'] = $this->url->link('common/home', '', true);
            echo json_encode($json);
            exit();
        }
        
        if (!$this->cart->getProductsCount('registration')) {
            $json['redirect'] = $this->url->link('register/user', '', true);
        } elseif (!isset($this->session->data['inf_reg_data']['step2'])) {
            $json['redirect'] = $this->url->link('register/user', '', true);
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

}
