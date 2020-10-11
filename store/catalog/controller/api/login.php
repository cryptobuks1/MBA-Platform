<?php
class ControllerApiLogin extends Controller {

    private $error = array();

    public function index_old() {
        $this->load->language('api/login');

        $json = array();

        $this->load->model('account/api');

        // Login with API Key
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);

        if ($api_info) {
            // Check if IP is allowed
            $ip_data = array();

            $results = $this->model_account_api->getApiIps($api_info['api_id']);

            foreach ($results as $result) {
                $ip_data[] = trim($result['ip']);
            }

            if (!in_array($this->request->server['REMOTE_ADDR'], $ip_data)) {
                $json['error']['ip'] = sprintf($this->language->get('error_ip'), $this->request->server['REMOTE_ADDR']);
            }

            if (!$json) {
                $json['success'] = $this->language->get('text_success');

                // We want to create a seperate session so changes do not interfere with the admin user.
                $session_id_old = $this->session->getId();

                $session_id_new = $this->session->createId();

                $this->session->start('api', $session_id_new);

                $this->session->data['api_id'] = $api_info['api_id'];

                // Close and write the new session.
                //$session->close();

                $this->session->start('default');

                // Create Token
                $json['token'] = $this->model_account_api->addApiSession($api_info['api_id'], $session_id_new, $this->request->server['REMOTE_ADDR']);
            } else {
                $json['error']['key'] = $this->language->get('error_key');
            }
        }

        if (isset($this->request->server['HTTP_ORIGIN'])) {
            $this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
            $this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
            $this->response->addHeader('Access-Control-Max-Age: 1000');
            $this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function index() {
        $this->load->model('account/customer');
        $this->load->model('register/data');

        // Login override for admin users
        $json['status'] = false;
        $this->load->model('account/api');
        $this->load->language('api/home');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        if ($api_info) {
            if (isset($this->request->post['inf_token'])) {
                if (!empty($this->request->post['inf_token'])) {

                    $customer_info = $this->model_register_data->getCustomerByToken($this->request->post['inf_token']);
                    if ($customer_info && $this->customer->login($customer_info['email'], '', true)) {
                        $json['status'] = true;
                        $json['customer_info'] = $customer_info;
                        // Default Addresses
                        $this->load->model('account/address');

                        if ($this->config->get('config_tax_customer') == 'payment') {
                            $json['data']['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
                        }

                        if ($this->config->get('config_tax_customer') == 'shipping') {
                            $json['data']['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
                        }
                    }
                }
            }
            $this->load->language('account/login');
            if (!$json['status'] && (isset($this->request->post['email']) && isset($this->request->post['password']))) {
                if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
                    $json['status'] = true;
                    // Default Shipping Address
                    $this->load->model('account/address');
                    if ($this->config->get('config_tax_customer') == 'payment') {
                        $json['data']['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
                    }

                    if ($this->config->get('config_tax_customer') == 'shipping') {
                        $json['data']['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
                    }

                    $customer_id = $this->customer->getId();
                    $customer_info = $this->model_register_data->getCustomerById($customer_id);
                    $json['customer_info'] = $customer_info;
                    $inf_token = $this->model_register_data->getRandInf();
                    $res = $this->model_register_data->updateInfToken($customer_id, $inf_token);
                    if ($res) {
                        $json['inf_token'] = $inf_token;
                    }

                    if ($this->config->get('config_customer_activity')) {
                        $this->load->model('account/activity');
                        $activity_data = array(
                            'customer_id' => $customer_id,
                            'name' => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
                        );

                        $this->model_account_activity->addActivity('login', $activity_data);
                    }
                } else {
                    $json['error'] = $this->error['warning'];
                    $json['status'] = FALSE;
                }
            } elseif (!$json['status']) {
                $json['error'] = "Invalid Credentials";
                $json['status'] = FALSE;
            }
        } else {
            $json['error'] = $this->language->get('error_permission');
            $json['status'] = FALSE;
        }
        if (isset($this->request->server['HTTP_ORIGIN'])) {
            $this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
            $this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
            $this->response->addHeader('Access-Control-Max-Age: 1000');
            $this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    protected function validate() {
        // Check how many login attempts have been made.
        $this->load->language('api/login');

        $login_info = $this->model_account_customer->getLoginAttempts($this->request->post['email']);
        if ($login_info && ($login_info['total'] >= $this->config->get('config_login_attempts')) && strtotime('-1 hour') < strtotime($login_info['date_modified'])) {
            $this->error['warning'] = $this->language->get('error_attempts');
        }

        // Check if customer has been approved.
        $customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);
        if ($customer_info && !$customer_info['approved']) {
            $this->error['warning'] = $this->language->get('error_approved');
        }
        if (!$this->error) {
            if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
                $this->error['warning'] = $this->language->get('error_login');

                $this->model_account_customer->addLoginAttempt($this->request->post['email']);
            } else {
                $this->model_account_customer->deleteLoginAttempts($this->request->post['email']);
            }
        }
        return !$this->error;
    }

}
