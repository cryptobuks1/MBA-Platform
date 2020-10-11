<?php

class ControllerRegisterNewsletter extends Controller {

    public function save() {

        $this->load->language('register/step4');

        $this->load->model('register/user');

        $json = array();

        if (!$json) {

            if ((utf8_strlen(trim($this->request->post['news_email'])) < 1)) {
                $json['error']['news_email'] = $this->language->get('error_email');
            }

            if ((utf8_strlen($this->request->post['news_email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['news_email'])) {
                $json['error']['news_email'] = $this->language->get('error_email');
            }


            if (!$json) {
                if (!$this->model_register_user->isEmailExist($this->request->post['news_email'])) {
                    $this->model_register_user->addToNewsLetter($this->request->post['news_email']);
                } else {
                    $json['error']['warning'] = 'You are Already Subscribed to Our NewsLetter Service.';
                }
            } else {
                $json['error']['warning'] = $this->language->get('error_email');
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

}
