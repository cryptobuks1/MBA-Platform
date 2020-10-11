<?php

class ControllerApiRegister extends Controller {

    public function register_users() {
        
        if (isset($this->request->post['inf_token'])) {
            if($this->request->post['inf_token'] == 'f6f7369316c4928fdceaaed397356f5b') {
                $this->load->model('catalog/product');
                $this->load->model('account/inf_register');
                $this->load->model('extension/extension');
                $this->load->model('checkout/order');
                $this->load->model('account/customer');
                $this->load->model('account/activity');
                $this->load->model('register/user');
                $this->load->model('localisation/zone');
                $this->load->model('localisation/country');
                
                $order_data = array();
                $customer_data = array();
                $reg_data = array();
                
                $product_id = 28;
                $product_data = $this->model_catalog_product->getProduct($product_id);
                $product_data['quantity'] = 1;
                
                $totals = array();
                $taxes = $this->model_account_inf_register->getTaxes($product_data);
                $total = 0;
                
                $total_data = array(
                    'totals' => &$totals,
                    'taxes' => &$taxes,
                    'total' => &$total
                );
                
                $results = $this->model_extension_extension->getExtensions('total');
                foreach ($results as $result) {
                    if ($this->config->get($result['code'] . '_status')) {
                        $this->load->model('extension/total/' . $result['code']);
                        $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                    }
                }
                
                $order_data['totals'] = $totals;
                $order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
                $order_data['store_id'] = $this->config->get('config_store_id');
                $order_data['store_name'] = $this->config->get('config_name');
                if ($order_data['store_id']) {
                    $order_data['store_url'] = $this->config->get('config_url');
                } else {
                    if ($this->request->server['HTTPS']) {
                        $order_data['store_url'] = HTTPS_SERVER;
                    } else {
                        $order_data['store_url'] = HTTP_SERVER;
                    }
                }
                
                $order_data['customer_id'] = 0;
                $order_data['customer_group_id'] = $this->config->get('config_customer_group_id');
                $order_data['firstname'] = 'Your First Name';
                $order_data['lastname'] = 'Your Last Name';
                $order_data['telephone'] = '9876543210';
                $order_data['fax'] = '';
                $order_data['custom_field'] = '';
                
                $order_data['payment_firstname'] = $order_data['shipping_firstname'] = $order_data['firstname'];
                $order_data['payment_lastname'] = $order_data['shipping_lastname'] = $order_data['lastname'];
                $order_data['payment_company'] = $order_data['shipping_company'] = 'Your Company';
                $order_data['payment_address_1'] = $order_data['shipping_address_1'] = 'Your Address';
                $order_data['payment_address_2'] = $order_data['shipping_address_2'] = 'Your Address';
                $order_data['payment_city'] = $order_data['shipping_city'] = 'Your City';
                $order_data['payment_postcode'] = $order_data['shipping_postcode'] = '123456';
                $order_data['payment_zone'] = $order_data['shipping_zone'] = 'Aberdeen';
                $order_data['payment_zone_id'] = $order_data['shipping_zone_id'] = '3513';
                $order_data['payment_country'] = $order_data['shipping_country'] = 'United States';
                $order_data['payment_country_id'] = $order_data['shipping_country_id'] = '223';
                $order_data['payment_address_format'] = $order_data['shipping_address_format'] = '';
                $order_data['payment_custom_field'] = $order_data['shipping_custom_field'] = array();
                $order_data['payment_method'] = 'Bank Transfer';
                $order_data['payment_code'] = 'bank_transfer';
                $order_data['shipping_method'] = 'Flat Shipping Rate';
                $order_data['shipping_code'] = 'flat.flat';
                
                $order_data['products'] = array();
                $option_data = array();
                $download_data = array();
                $order_data['products'][] = array(
                    'product_id' => $product_data['product_id'],
                    'name' => $product_data['name'],
                    'model' => $product_data['model'],
                    'option' => $option_data,
                    'download' => $download_data,
                    'quantity' => $product_data['quantity'],
                    'subtract' => $product_data['subtract'],
                    'price' => $product_data['price'],
                    'total' => $product_data['price'],
                    'tax' => $this->tax->getTax($product_data['price'], $product_data['tax_class_id']),
                    'reward' => $product_data['reward']
                );
                $order_data['vouchers'] = array();
                $order_data['comment'] = '';
                $order_data['total'] = $total_data['total'];
                $order_data['affiliate_id'] = 0;
                $order_data['commission'] = 0;
                $order_data['marketing_id'] = 0;
                $order_data['tracking'] = '';
                $order_data['language_id'] = $this->config->get('config_language_id');
                $order_data['currency_code'] = 'USD';
                $order_data['currency_id'] = $this->currency->getId($order_data['currency_code']);
                $order_data['currency_value'] = $this->currency->getValue($order_data['currency_code']);
                $order_data['ip'] = $this->request->server['REMOTE_ADDR'];
                $order_data['forwarded_ip'] = '';
                $order_data['user_agent'] = '';
                $order_data['accept_language'] = '';
                
                $customer_data['customer_group_id'] = $order_data['customer_group_id'];
                $customer_data['firstname'] = $order_data['firstname'];
                $customer_data['lastname'] = $order_data['lastname'];
                $customer_data['telephone'] = $order_data['telephone'];
                $customer_data['fax'] = $order_data['fax'];
                $customer_data['custom_field'] = $order_data['custom_field'];
                $customer_data['password'] = '123456';
                $customer_data['newsletter'] = '';
                $customer_data['company'] = $order_data['payment_company'];
                $customer_data['address_1'] = $order_data['payment_address_1'];
                $customer_data['address_2'] = $order_data['payment_address_2'];
                $customer_data['city'] = $order_data['payment_city'];
                $customer_data['postcode'] = $order_data['payment_postcode'];
                $customer_data['country_id'] = $order_data['payment_country_id'];
                $customer_data['zone_id'] = $order_data['payment_zone_id'];
                
                $reg_data['sponsor_user_name'] = $this->model_account_inf_register->getAdminUsername($this->request->post['user_id']);
                $reg_data['width'] = $this->model_account_inf_register->getMlmConfiguration('width_ceiling');
                $reg_data['depth'] = $this->model_account_inf_register->getMlmConfiguration('depth_ceiling');
                
                if (MLM_PLAN == 'Matrix' || MLM_PLAN == 'Board' || MLM_PLAN == 'Table') {
                    $user_count = 0;
                    for ($pow = 1; $pow <= $reg_data['depth']; $pow++) {
                        $user_count += pow($reg_data['width'], $pow);
                    }
                } else {
                    $user_count = '25';
                }
                $j = 0;
                $registered_array = array();
                for ($i = 0; $i < $user_count; $i++) {
                    
                    $customer_data['user_name'] = 'mlmuser' . (($i > 0) ? $i : '');
                    $order_data['email'] = $customer_data['email'] = $customer_data['user_name'] . '@mail.com';
                    
                    if (MLM_PLAN == 'Binary') {
                        $registered_array[$i]['user_name'] = $customer_data['user_name'];
                        if ($i % 2 == 0) {
                            $reg_data['position'] = 'L';
                        } else {
                            $reg_data['position'] = 'R';
                        }
                        if ($i <= 1) {
                            $reg_data['sponsor_user_name'] = $reg_data['placement_user_name'] = $reg_data['sponsor_user_name'];
                        } else {
                            $j = $i - 2;
                            $j = (($j % 2) == 0) ? $j : ($j - 1);
                            $j = $j / 2;
                            $reg_data['sponsor_user_name'] = $reg_data['placement_user_name'] = $registered_array[$j]['user_name'];
                        }
                    } elseif (MLM_PLAN == 'Unilevel' || MLM_PLAN == 'Party') {
                        $registered_array[$i]['user_name'] = $customer_data['user_name'];
                        if ($i != 0 && ($i % 5) == 0) {
                            $reg_data['sponsor_user_name'] = $registered_array[$j]['user_name'];
                            $j++;
                        }
                        $reg_data['placement_user_name'] = $reg_data['sponsor_user_name'] = $reg_data['sponsor_user_name'];
                    } else {
                        $reg_data['placement_user_name'] = $reg_data['sponsor_user_name'] = $reg_data['sponsor_user_name'];
                    }
                    
                    $order_id = $this->model_checkout_order->addOrder($order_data);
                    $customer_id = $this->model_account_customer->addCustomer($customer_data);

                    $this->model_account_customer->deleteLoginAttempts($customer_data['email']);
                    
                    $activity_data = array(
                        'customer_id' => $customer_id,
                        'name' => $customer_data['firstname'] . ' ' . $customer_data['lastname']
                    );
                    $this->model_account_activity->addActivity('register', $activity_data);
                    
                    $this->model_register_user->updateOrderCustomerID($order_id, $customer_id);
                    
                    $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('bank_transfer_order_status_id'), $order_data['comment'], true);
                    
                    // Add to MLM BackOffice //
                    if ($customer_id && $order_id) {
                        $reg_data['user_name_entry'] = $customer_data['user_name'];
                        $reg_data['sponsor_id'] = $this->customer->userNameToID($reg_data['sponsor_user_name']);
                        $reg_data['by_using'] = 'opencart';
                        $reg_data['customer_id'] = $customer_id;
                        $reg_data['reg_from_tree'] = FALSE;
                        $reg_data['placement_full_name'] = '';
                        $reg_data['sponsor_full_name'] = '';
                        $reg_data['first_name'] = $customer_data['firstname'];
                        $reg_data['last_name'] = $customer_data['lastname'];
                        $reg_data['email'] = $customer_data['email'];
                        $reg_data['mobile'] = $customer_data['telephone'];
                        $reg_data['land_line'] = $customer_data['telephone'];
                        $reg_data['date_of_birth'] = '1990-01-01';
                        $reg_data['gender'] = 'M';
                        $reg_data['address'] = $customer_data['address_1'];
                        $reg_data['address_line2'] = $customer_data['address_2'];
                        $reg_data['city'] = $customer_data['city'];
                        $reg_data['pin'] = $customer_data['postcode'];
                        $zone_info = $this->model_localisation_zone->getZone($customer_data['zone_id']);
                        $reg_data['state'] = $zone_info['zone_id'];
                        $reg_data['state_name'] = $zone_info['name'];
                        $country_info = $this->model_localisation_country->getCountry($customer_data['country_id']);
                        $reg_data['country'] = $country_info['country_id'];
                        $reg_data['country_name'] = $country_info['name'];
                        $reg_data['user_name_type'] = 'static';
                        $reg_data['pswd'] = $customer_data['password'];
                        $reg_data['cpswd'] = $customer_data['password'];
                        $reg_data['mobile_code'] = '';
                        $reg_data['bank_name'] = '';
                        $reg_data['bank_branch'] = '';
                        $reg_data['bank_acc_no'] = '';
                        $reg_data['ifsc'] = '';
                        $reg_data['pan_no'] = '';
                        $order_info = $this->model_checkout_order->getOrder($order_id);
                        $reg_data['reg_amount'] = $order_info['total'];
                        $reg_data["order_id"] = $order_id;
                        $reg_data['product_id'] = $product_id;
                        
                        $this->model_account_inf_register->addToBackOffice($reg_data, $customer_id);
                    }
                }
            }
        }
    }

    public function get_registration_pack() {
        $this->load->model('account/api');
        $this->load->language('api/home');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $json = array();
        if ($api_info) {
            $this->load->model('register/data');
            $json["status"] = true;
            $base_url = $this->config->get('config_url');
            $json['data'] = $this->model_register_data->getRegistrationpack($base_url);
        } else {
            $json['error'] = $this->language->get('error_permission');
            $json['status'] = FALSE;
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function get_sponsor_information() {
        $this->load->model('account/api');
        $this->load->language('api/home');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $json = array();
        if ($api_info) {
            $post_array = $this->request->post;
            if (!isset($post_array['sponsor_user_name']) || $post_array['sponsor_user_name'] == '') {
                $json['status'] = false;
                $json['message'] = 'Sponsor is required';
            } elseif (!isset($post_array['position']) || $post_array['position'] == '') {
                $json['status'] = false;
                $json['message'] = 'Position is required';
            } else {
                $this->load->model('register/user');
                $sponsor_name = $post_array['sponsor_user_name'];
                $sponsor_id = $this->model_register_user->userNameToID($sponsor_name);
                if (!$sponsor_id) {
                    $json['status'] = false;
                    $json['message'] = 'Invalid Sponsor';
                } else {
                    $sponsor_full_name = $this->model_register_user->getSponsorFullName($sponsor_name);
                    $json['status'] = true;
                    $json['sponsor_name'] = $sponsor_full_name;
                }
            }
        } else {
            $json['error'] = $this->language->get('error_permission');
            $json['status'] = FALSE;
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function get_privacy_policy() {
        $this->load->model('account/api');
        $this->load->language('api/home');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $json = array();
        if ($api_info) {
            if ($this->config->get('config_account_id')) {
                $this->load->model('catalog/information');
                $json['status'] = true;
                $json['privacy_policy'] = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));
            }
        } else {
            $json['error'] = $this->language->get('error_permission');
            $json['status'] = FALSE;
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function get_country() {
        $this->load->model('account/api');
        $this->load->language('api/home');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $json = array();
        if ($api_info) {
            $this->load->model('localisation/country');
            $json['status'] = true;
            $json['countries'] = $this->model_localisation_country->getCountries();
        } else {
            $json['error'] = $this->language->get('error_permission');
            $json['status'] = FALSE;
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function get_zone() {
        $this->load->model('account/api');
        $this->load->language('api/home');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $json = array();
        if ($api_info) {
            $post_array = $this->request->post;
            if (!isset($post_array['country_id']) || $post_array['country_id'] == '') {
                $json['status'] = false;
                $json['message'] = 'Country is required';
            } else {
                $this->load->model('localisation/zone');
                $json['status'] = true;
                $json['zone'] = $this->model_localisation_zone->getZonesByCountryId($post_array['country_id']);
            }
        } else {
            $json['error'] = $this->language->get('error_permission');
            $json['status'] = FALSE;
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function get_payment_methods() {
        $this->load->model('account/api');
        $this->load->language('api/home');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $response = array();
        if ($api_info) {
            $json = array();

            $total = 0;

            $post_array = $this->request->post;
            if (!isset($post_array['zone_id']) || $post_array['zone_id'] == '') {
                $response['status'] = false;
                $response['message'] = 'Zone Id is required';
            }
            if (!isset($post_array['country_id']) || $post_array['country_id'] == '') {
                $response['status'] = false;
                $response['message'] = 'Country Id is required';
            }

            $this->load->model('extension/extension');

            if ($post_array['country_id'] && $post_array['zone_id']) {
                $results = $this->model_extension_extension->getExtensions('payment');

                foreach ($results as $result) {
                    if ($this->config->get($result['code'] . '_status')) {
                        if ($result['code'] == 'epin' || $result['code'] == 'free_checkout') {
                            continue;
                        }
                        $this->load->model('extension/payment/' . $result['code']);

                        $method = $this->{'model_extension_payment_' . $result['code']}->getMethod($post_array, $total);

                        if ($method) {
                            $json[$result['code']] = $method;
                        }
                    }
                }
                foreach ($json as $row) {
                    $response['data'][] = $row;
                }
                $response['status'] = true;
            }
        } else {
            $response['error'] = $this->language->get('error_permission');
            $response['status'] = FALSE;
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));
    }

    public function get_terms_and_conditons() {
        $this->load->model('account/api');
        $this->load->language('api/home');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $json = array();
        if ($api_info) {
            if ($this->config->get('config_checkout_id')) {
                $this->load->model('catalog/information');

                $json['terms'] = $this->model_catalog_information->getInformation($this->config->get('config_checkout_id'));
                $json['status'] = true;
            }
        } else {
            $json['error'] = $this->language->get('error_permission');
            $json['status'] = FALSE;
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function get_bank_info() {
        $this->load->model('account/api');
        $this->load->language('api/home');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $json = array();
        if ($api_info) {
            $this->load->model('register/data');
            $json['status'] = true;
            $json['bank'] = nl2br($this->config->get('bank_transfer_bank' . $this->config->get('config_language_id')));
        } else {
            $json['error'] = $this->language->get('error_permission');
            $json['status'] = FALSE;
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function bank_confirm() {

        $this->load->model('account/api');
        $this->load->language('api/home');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $json = array();
        if ($api_info) {
            $this->load->model('catalog/product');
            $this->load->model('account/inf_register');
            $this->load->model('extension/extension');
            $this->load->model('checkout/order');
            $this->load->model('account/customer');
            $this->load->model('account/activity');
            $this->load->model('register/user');
            $this->load->model('localisation/zone');
            $this->load->model('localisation/country');
            $this->load->model('register/data');

            $order_data = array();
            $customer_data = array();
            $reg_data = $this->request->post;

            $product_id = $reg_data['product_id'];
            $product_data = $this->model_register_data->getProduct($product_id);
            $product_data['quantity'] = 1;

            $total_amount = $product_data['price'];

            $totals = array();
            $taxes = $this->model_account_inf_register->getTaxes($product_data);
            $total = 0;

            $total_data = array(
                'totals' => &$totals,
                'taxes' => &$taxes,
                'total' => &$total
            );

            $results = $this->model_extension_extension->getExtensions('total');
            foreach ($results as $result) {
                if ($this->config->get($result['code'] . '_status')) {
                    $this->load->model('extension/total/' . $result['code']);
                    $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                }
            }

            $order_data['totals'] = $totals;
            $order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
            $order_data['store_id'] = $this->config->get('config_store_id');
            $order_data['store_name'] = $this->config->get('config_name');
            if ($order_data['store_id']) {
                $order_data['store_url'] = $this->config->get('config_url');
            } else {
                if ($this->request->server['HTTPS']) {
                    $order_data['store_url'] = HTTPS_SERVER;
                } else {
                    $order_data['store_url'] = HTTP_SERVER;
                }
            }
            $zone_info = $this->model_localisation_zone->getZone($reg_data['zone_id']);
            $country_info = $this->model_localisation_country->getCountry($reg_data['country_id']);

            $order_data['customer_id'] = 0;
            $order_data['customer_group_id'] = $this->config->get('config_customer_group_id');
            $order_data['firstname'] = $reg_data['firstname'];
            $order_data['lastname'] = $reg_data['lastname'];
            $order_data['telephone'] = $reg_data['telephone'];
            $order_data['fax'] = $reg_data['fax'];
            $order_data['custom_field'] = '';
            $order_data['email'] = $reg_data['email'];

            $order_data['payment_firstname'] = $order_data['shipping_firstname'] = $order_data['firstname'];
            $order_data['payment_lastname'] = $order_data['shipping_lastname'] = $order_data['lastname'];
            $order_data['payment_company'] = $order_data['shipping_company'] = '';
            $order_data['payment_address_1'] = $order_data['shipping_address_1'] = $reg_data['address_1'];
            $order_data['payment_address_2'] = $order_data['shipping_address_2'] = $reg_data['address_2'];
            $order_data['payment_city'] = $order_data['shipping_city'] = $reg_data['city'];
            $order_data['payment_postcode'] = $order_data['shipping_postcode'] = $reg_data['postcode'];
            $order_data['payment_zone'] = $order_data['shipping_zone'] = $zone_info['name'];
            $order_data['payment_zone_id'] = $order_data['shipping_zone_id'] = $reg_data['zone_id'];
            $order_data['payment_country'] = $order_data['shipping_country'] = $country_info['name'];
            $order_data['payment_country_id'] = $order_data['shipping_country_id'] = $reg_data['country_id'];
            $order_data['payment_address_format'] = $order_data['shipping_address_format'] = '';
            $order_data['payment_custom_field'] = $order_data['shipping_custom_field'] = array();
            if (!$reg_data['same_as']) {
                $order_data['shipping_firstname'] = $order_data['shipping_address_firstname'];
                $order_data['shipping_lastname'] = $order_data['shipping_address_lastname'];
                $order_data['shipping_company'] = '';
                $order_data['shipping_address_1'] = $reg_data['shipping_address_address_1'];
                $order_data['shipping_address_2'] = $reg_data['shipping_address_address_2'];
                $order_data['shipping_city'] = $reg_data['shipping_address_city'];
                $order_data['shipping_postcode'] = $reg_data['shipping_address_post_code'];
                $sh_zone_info = $this->model_localisation_zone->getZone($customer_data['shipping_address_zone_id']);
                $sh_country_info = $this->model_localisation_country->getCountry($customer_data['shipping_address_country_id']);
                $order_data['shipping_zone'] = $sh_zone_info['name'];
                $order_data['shipping_zone_id'] = $reg_data['shipping_address_zone_id'];
                $order_data['shipping_country'] = $sh_country_info['name'];
                $order_data['shipping_country_id'] = $reg_data['shipping_address_country_id'];
            }

            $order_data['payment_method'] = "Bank Transfer";
            $order_data['payment_code'] = $reg_data['payment_method'];
            $order_data['shipping_method'] = 'Flat Shipping Rate';
            $order_data['shipping_code'] = 'flat.flat';

            $order_data['products'] = array();
            $option_data = array();
            $download_data = array();
            $order_data['products'][] = array(
                'product_id' => $product_data['product_id'],
                'name' => $product_data['name'],
                'model' => $product_data['model'],
                'option' => $option_data,
                'download' => $download_data,
                'quantity' => $product_data['quantity'],
                'subtract' => $product_data['subtract'],
                'price' => $product_data['price'],
                'total' => $product_data['price'],
                'tax' => $this->tax->getTax($product_data['price'], $product_data['tax_class_id']),
                'reward' => ''
            );
            $order_data['vouchers'] = array();
            $order_data['comment'] = '';
            $order_data['total'] = $total_amount;
            $order_data['affiliate_id'] = 0;
            $order_data['commission'] = 0;
            $order_data['marketing_id'] = 0;
            $order_data['tracking'] = '';
            $order_data['language_id'] = $this->config->get('config_language_id');
            $order_data['currency_code'] = 'USD';
            $order_data['currency_id'] = $this->currency->getId($order_data['currency_code']);
            $order_data['currency_value'] = $this->currency->getValue($order_data['currency_code']);
            $order_data['ip'] = $this->request->server['REMOTE_ADDR'];
            $order_data['forwarded_ip'] = '';
            $order_data['user_agent'] = '';
            $order_data['accept_language'] = '';

            $customer_data['customer_group_id'] = $order_data['customer_group_id'];
            $customer_data['firstname'] = $order_data['firstname'];
            $customer_data['lastname'] = $order_data['lastname'];
            $customer_data['telephone'] = $order_data['telephone'];
            $customer_data['fax'] = $order_data['fax'];
            $customer_data['custom_field'] = $order_data['custom_field'];
            $customer_data['password'] = $reg_data['password'];
            $customer_data['newsletter'] = '';
            $customer_data['company'] = $order_data['payment_company'];
            $customer_data['address_1'] = $order_data['payment_address_1'];
            $customer_data['address_2'] = $order_data['payment_address_2'];
            $customer_data['city'] = $order_data['payment_city'];
            $customer_data['postcode'] = $order_data['payment_postcode'];
            $customer_data['country_id'] = $order_data['payment_country_id'];
            $customer_data['zone_id'] = $order_data['payment_zone_id'];
            $customer_data['email'] = $reg_data['email'];
            $customer_data['user_name'] = '';


            $reg_data['table_prefix'] = $table_prefix = 2137;
            //$reg_data['width'] = $this->model_account_inf_register->getMlmConfiguration('width_ceiling');
            // $reg_data['depth'] = $this->model_account_inf_register->getMlmConfiguration('depth_ceiling');

            if (MLM_PLAN == 'Matrix' || MLM_PLAN == 'Board' || MLM_PLAN == 'Table') {
                $user_count = 0;
                for ($pow = 1; $pow <= $reg_data['depth']; $pow++) {
                    $user_count += pow($reg_data['width'], $pow);
                }
            } else {
                $user_count = '1';
            }
            $i = 0;
            $registered_array = array();

            if (MLM_PLAN == 'Binary') {
                $reg_data['placement_user_name'] = $reg_data['sponsor_user_name'] = $reg_data['sponsor_user_name'];
            }

            $order_id = $this->model_checkout_order->addOrder($order_data);
            $customer_id = $this->model_account_customer->addCustomer($customer_data);

            $this->model_account_customer->deleteLoginAttempts($customer_data['email']);

            $activity_data = array(
                'customer_id' => $customer_id,
                'name' => $customer_data['firstname'] . ' ' . $customer_data['lastname']
            );
            $this->model_account_activity->addActivity('register', $activity_data);

            $this->model_register_user->updateOrderCustomerID($order_id, $customer_id);

            $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('bank_transfer_order_status_id'), $order_data['comment'], true);

            // Add to MLM BackOffice //
            if ($customer_id && $order_id) {
                $reg_data['user_name_entry'] = $customer_data['user_name'];
                $reg_data['sponsor_id'] = $this->customer->userNameToID($reg_data['sponsor_user_name']);
                $reg_data['by_using'] = 'opencart';
                $reg_data['customer_id'] = $customer_id;
                $reg_data['reg_from_tree'] = FALSE;
                $reg_data['placement_full_name'] = '';
                $reg_data['sponsor_full_name'] = '';
                $reg_data['first_name'] = $customer_data['firstname'];
                $reg_data['last_name'] = $customer_data['lastname'];
                $reg_data['email'] = $customer_data['email'];
                $reg_data['mobile'] = $customer_data['telephone'];
                $reg_data['land_line'] = $customer_data['telephone'];
                $reg_data['address'] = $customer_data['address_1'];
                $reg_data['address_line2'] = $customer_data['address_2'];
                $reg_data['city'] = $customer_data['city'];
                $reg_data['pin'] = $customer_data['postcode'];

                $reg_data['state'] = $zone_info['zone_id'];
                $reg_data['state_name'] = $zone_info['name'];

                $reg_data['country'] = $country_info['country_id'];
                $reg_data['country_name'] = $country_info['name'];
                $reg_data['user_name_type'] = 'static';
                $reg_data['pswd'] = $customer_data['password'];
                $reg_data['cpswd'] = $customer_data['password'];
                $reg_data['mobile_code'] = '';
                $reg_data['bank_name'] = '';
                $reg_data['bank_branch'] = '';
                $reg_data['bank_acc_no'] = '';
                $reg_data['ifsc'] = '';
                $reg_data['pan_no'] = '';
                $order_info = $this->model_checkout_order->getOrder($order_id);
                $reg_data['reg_amount'] = $total_amount;
                $reg_data["order_id"] = $order_id;
                $reg_data['product_id'] = $product_id;
                $reg_data['user_name_type'] = USERNAME_TYPE;
                if (USERNAME_TYPE == "static") {
                    $reg_data['user_name_entry'] = $reg_data['username'];
                } else {
                    $reg_data['user_name_entry'] = '';
                }
                $reg_data['pin'] = $reg_data['postcode'];

                $this->model_account_inf_register->addToBackOffice($reg_data, $customer_id);
                $json['status'] = TRUE;
            }
        } else {
            $json['error'] = $this->language->get('error_permission');
            $json['status'] = FALSE;
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function get_blockchain_address() {

ini_set('display_errors', 1);
error_reporting(E_ALL);
        $this->load->model('account/api');
        $this->load->language('api/home');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $json = array();
        if ($api_info) {
            $this->load->model('extension/payment/block_chain');
            $this->load->language('extension/payment/block_chain');
            $this->load->model('catalog/product');
            $this->load->model('account/inf_register');
            $this->load->model('extension/extension');
            $this->load->model('checkout/order');
            $this->load->model('account/customer');
            $this->load->model('account/activity');
            $this->load->model('register/user');
            $this->load->model('localisation/zone');
            $this->load->model('localisation/country');
            $this->load->model('register/data');

            $data['info'] = $this->language->get('info');


            $reg_data = $this->request->post;

            $product_id = $reg_data['product_id'];
            $product_data = $this->model_register_data->getProduct($product_id);
            $product_data['quantity'] = 1;

            $total_amount = $product_data['price'];

            $totals = array();
            $taxes = $this->model_account_inf_register->getTaxes($product_data);
            $total = 0;

            $total_data = array(
                'totals' => &$totals,
                'taxes' => &$taxes,
                'total' => &$total
            );

            $this->load->model('extension/extension');

            $sort_order = array();

            $results = $this->model_extension_extension->getExtensions('total');

            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
            }

            array_multisort($sort_order, SORT_ASC, $results);

            foreach ($results as $result) {
                if ($this->config->get($result['code'] . '_status')) {
                    $this->load->model('extension/total/' . $result['code']);

                    // We have to put the totals in an array so that they pass by reference.
                    $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                }
            }

            $product_id = $reg_data['product_id'];

            $order_data['totals'] = $totals;
            $order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
            $order_data['store_id'] = $this->config->get('config_store_id');
            $order_data['store_name'] = $this->config->get('config_name');
            if ($order_data['store_id']) {
                $order_data['store_url'] = $this->config->get('config_url');
            } else {
                if ($this->request->server['HTTPS']) {
                    $order_data['store_url'] = HTTPS_SERVER;
                } else {
                    $order_data['store_url'] = HTTP_SERVER;
                }
            }
            $zone_info = $this->model_localisation_zone->getZone($reg_data['zone_id']);
            $country_info = $this->model_localisation_country->getCountry($reg_data['country_id']);

            $order_data['customer_id'] = 0;
            $order_data['customer_group_id'] = $this->config->get('config_customer_group_id');
            $order_data['firstname'] = $reg_data['firstname'];
            $order_data['lastname'] = $reg_data['lastname'];
            $order_data['telephone'] = $reg_data['telephone'];
            $order_data['fax'] = $reg_data['fax'];
            $order_data['custom_field'] = '';
            $order_data['email'] = $reg_data['email'];

            $order_data['payment_firstname'] = $order_data['shipping_firstname'] = $order_data['firstname'];
            $order_data['payment_lastname'] = $order_data['shipping_lastname'] = $order_data['lastname'];
            $order_data['payment_company'] = $order_data['shipping_company'] = '';
            $order_data['payment_address_1'] = $order_data['shipping_address_1'] = $reg_data['address_1'];
            $order_data['payment_address_2'] = $order_data['shipping_address_2'] = $reg_data['address_2'];
            $order_data['payment_city'] = $order_data['shipping_city'] = $reg_data['city'];
            $order_data['payment_postcode'] = $order_data['shipping_postcode'] = $reg_data['postcode'];
            $order_data['payment_zone'] = $order_data['shipping_zone'] = $zone_info['name'];
            $order_data['payment_zone_id'] = $order_data['shipping_zone_id'] = $reg_data['zone_id'];
            $order_data['payment_country'] = $order_data['shipping_country'] = $country_info['name'];
            $order_data['payment_country_id'] = $order_data['shipping_country_id'] = $reg_data['country_id'];
            $order_data['payment_address_format'] = $order_data['shipping_address_format'] = '';
            $order_data['payment_custom_field'] = $order_data['shipping_custom_field'] = array();
            if (!$reg_data['same_as']) {
                $order_data['shipping_firstname'] = $order_data['shipping_address_firstname'];
                $order_data['shipping_lastname'] = $order_data['shipping_address_lastname'];
                $order_data['shipping_company'] = '';
                $order_data['shipping_address_1'] = $reg_data['shipping_address_address_1'];
                $order_data['shipping_address_2'] = $reg_data['shipping_address_address_2'];
                $order_data['shipping_city'] = $reg_data['shipping_address_city'];
                $order_data['shipping_postcode'] = $reg_data['shipping_address_post_code'];
                $sh_zone_info = $this->model_localisation_zone->getZone($customer_data['shipping_address_zone_id']);
                $sh_country_info = $this->model_localisation_country->getCountry($customer_data['shipping_address_country_id']);
                $order_data['shipping_zone'] = $sh_zone_info['name'];
                $order_data['shipping_zone_id'] = $reg_data['shipping_address_zone_id'];
                $order_data['shipping_country'] = $sh_country_info['name'];
                $order_data['shipping_country_id'] = $reg_data['shipping_address_country_id'];
            }

            $order_data['payment_method'] = "Bank Transfer";
            $order_data['payment_code'] = $reg_data['payment_method'];
            $order_data['shipping_method'] = 'Flat Shipping Rate';
            $order_data['shipping_code'] = 'flat.flat';

            $order_data['products'] = array();
            $option_data = array();
            $download_data = array();
            $order_data['products'][] = array(
                'product_id' => $product_data['product_id'],
                'name' => $product_data['name'],
                'model' => $product_data['model'],
                'option' => $option_data,
                'download' => $download_data,
                'quantity' => $product_data['quantity'],
                'subtract' => $product_data['subtract'],
                'price' => $product_data['price'],
                'total' => $product_data['price'],
                'tax' => $this->tax->getTax($product_data['price'], $product_data['tax_class_id']),
                'reward' => ''
            );
            $order_data['vouchers'] = array();
            $order_data['comment'] = '';
            $order_data['total'] = $total_amount;
            $order_data['affiliate_id'] = 0;
            $order_data['commission'] = 0;
            $order_data['marketing_id'] = 0;
            $order_data['tracking'] = '';
            $order_data['language_id'] = $this->config->get('config_language_id');
            $order_data['currency_code'] = 'USD';
            $order_data['currency_id'] = $this->currency->getId($order_data['currency_code']);
            $order_data['currency_value'] = $this->currency->getValue($order_data['currency_code']);
            $order_data['ip'] = $this->request->server['REMOTE_ADDR'];
            $order_data['forwarded_ip'] = '';
            $order_data['user_agent'] = '';
            $order_data['accept_language'] = '';

            $order_id = $this->model_checkout_order->addOrder($order_data);

            $currency = "USD";
            $blockchain_root = "https://blockchain.info/";
            $price_in_btc = $total_amount;
            $price_in_btc = file_get_contents($blockchain_root . "tobtc?currency=$currency&value=" . $total_amount);
            $invoice_id = time();

            $my_xpub = $this->config->get('block_chain_xPub');
            $my_api_key = $this->config->get('block_chain_api_key');
            $secret = $this->getToken(); // $this->config->get('block_chain_secret');

            $new_address = false;

            $this->load->model('extension/payment/block_chain');

            /* For Server
             *
             */

            /* if ($this->model_extension_payment_block_chain->getUnpaidAddressCount() >= 19 && $this->model_extension_payment_block_chain->getUnpaidAddress()) {
              $address = $this->model_extension_payment_block_chain->getUnpaidAddress();
              } else {
              $my_callback_url = $this->url->link('extension/regpayment/block_chain/blockchain_callback?invoice_id=' . $invoice_id . '&secret=' . $secret);

              $root_url = 'https://api.blockchain.info/v2/receive';

              $parameters = 'xpub=' . $my_xpub . '&callback=' . urlencode($my_callback_url) . '&key=' . $my_api_key;
              //  echo $root_url . '?' . $parameters;die;
              $response = file_get_contents($root_url . '?' . $parameters);

              $object = json_decode($response);

              $address = $object->address;
              $new_address = true;
              }
              $qr_code = 'https://api.qrserver.com/v1/create-qr-code/?data=' . $address;
              if ($address) {
              if ($new_address) {
              $this->model_extension_payment_block_chain->keepBitcoinAddress($address);
              }
              $regr = $reg_data;
              $this->model_extension_payment_block_chain->insertPaymentDetails($invoice_id, $address, $secret, $total_amount, $price_in_btc, $regr, 'register', $order_id);
              } else {

              $msg = '<b><p> Check blockchain payment Credentials!!</p></b>';
              return $msg;
              } */

            /* For Test
             *
             */


            if ($this->model_extension_payment_block_chain->getUnpaidAddressCount() >= 19 && $this->model_extension_payment_block_chain->getUnpaidAddress()) {
                $address = $this->model_extension_payment_block_chain->getUnpaidAddress();
            } else {
                $address = $this->generateNewAddress();
            }
            $qr_code = $this->generateBitcoinQrCode($address, $total_amount);
            if ($address) {
                $this->model_extension_payment_block_chain->insertPaymentDetails($invoice_id, $address, $secret, $total_amount, $price_in_btc, $reg_data, 'register', $order_id);
            } else {

                $msg = '<b><p> Blockchain payment available in live mode only!!</p></b>';
                return $msg;
            }

            $json['amount_in_btc'] = $price_in_btc;
            $json['total_amount'] = $total_amount;
            $json['invoice_id'] = $invoice_id;
            $json['address'] = $address;
            $json['order_id'] = $order_id;
            $json['status'] = true;
        } else {
            $json['error'] = $this->language->get('error_permission');
            $json['status'] = FALSE;
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/payment/block_chain')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    public function getToken($length = 32) {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[$this->crypto_rand_secure(0, strlen($codeAlphabet))];
        }
        return $token;
    }

    private function crypto_rand_secure($min, $max) {
        $range = $max - $min;
        if ($range < 0)
            return $min;
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1;
        $bits = (int) $log + 1;
        $filter = (int) (1 << $bits) - 1;
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter;
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    public function generateNewAddress() {
        $this->load->model('extension/payment/block_chain');
        $bitcoin_address = $this->model_extension_payment_block_chain->getAvailableAddress();
        if ($bitcoin_address == '') {
            $blockchain_info = $this->model_extension_payment_block_chain->getBlockchainInfo();
            $guid = $blockchain_info['my_api_key'];
            $main_password = $blockchain_info['main_password'];
            $second_password = $blockchain_info['second_password'];

            $url = "http://192.168.1.195:3000/merchant/$guid/new_address?password=$main_password&second_password=$second_password&label=user_id:$this->LOG_USER_ID";
            $data = $this->curl($url);
            $new_address = $data['address'];
            if ($new_address) {
                $this->model_extension_payment_block_chain->keepBitcoinAddress($new_address);
                return $new_address;
            }
        }
        return $bitcoin_address;
    }
    function curl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15"));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec ($ch);
        $this->logger('Post data: ' . print_r($this->request->post, 1));
        $this->logger('Request: ' . $url);
        $this->logger('Curl error #: ' . curl_errno($ch));
        $this->logger('Curl error text: ' . curl_error($ch));
        $this->logger('Curl response info: ' . print_r(curl_getinfo($ch), 1));
        $this->logger('Curl response: ' . $response);
        curl_close($ch);
        return $response;
     }
     public function logger($message) {

            $log = new Log('block_chain.log');
            $log->write($message);
    }

    function generateBitcoinQrCode($bitcoin_address = '', $btc_amount = '') {
        $qr_data = "bitcoin%3A$bitcoin_address%3Famount%3D$btc_amount";
        $qr_code = 'https://api.qrserver.com/v1/create-qr-code/?data=' . $qr_data;
        //  echo $qr_code;die();
        return $qr_code;
    }

    public function blockchain_payment_done() {
        $this->load->model('account/api');
        $this->load->language('api/home');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $json = array();
        if ($api_info) {
            $this->load->model('extension/payment/block_chain');
            $this->load->model('account/inf_register');
            $this->load->model('register/data');

            $reg_data = $this->request->post;
            $block_address = $reg_data['block_chain_address'];
            $invoice_id = $reg_data['invoice_id'];
            $paid_amount = $reg_data['amount_in_btc'];
            $reg_data['reg_from_tree'] = false;
            $json = array();
            $response = file_get_contents("https://blockchain.info/rawaddr/" . $block_address);

            $res_arr = json_decode($response, true);
            $response_amount = 0;

            foreach ($res_arr['txs'] as $key => $value) {
                $count = count($value['out']);
                for ($i = 0; $i < $count; $i++) {
                    if ($value['out'][$i]['addr'] == $block_address) {
                        $amount = $value['out'][$i]['value'];
                        $response_amount = $amount / 100000000;
                    }
                }
            }
            $this->model_extension_payment_block_chain->keepRowAddressReponse($block_address, $invoice_id, $res_arr, 'ocregister', 'purchase');
            $result = $this->model_extension_payment_block_chain->updateBitcoinAddress($block_address, 'yes');
            if ($response_amount > 0.00000001 && (round($response_amount, 8) >= round($paid_amount, 8)) && $result) {

                //Register Customer//
                $this->load->model('checkout/order');

                $this->load->model('account/customer');

                if (MLM_PLAN == 'Binary') {
                    if ($reg_data['reg_from_tree'] && $reg_data['placement_user_name']) {
                        $sponsor_id = $this->customer->userNameToID($reg_data['placement_user_name']);
                    } else {
                        $sponsor_id = $this->customer->userNameToID($reg_data['sponsor_user_name']);
                    }
                    $binary_leg = $this->model_account_inf_register->getAllowedBinaryLeg($sponsor_id, $this->customer->getUserType(), $this->customer->getUserId());
                    if (MLM_PLAN == 'Binary' && $binary_leg != 'any' && $binary_leg != $reg_data['position']) {
                        $json['error'] = $this->language->get('position_not_usable');
                        exit();
                    }
                }

                $customer_data = array();
//                if (isset($reg_data['customer_group_id'])) {
//                    $customer_data['customer_group_id'] = $reg_data['customer_group_id'];
//                }
                $customer_data['customer_group_id'] = 1;

                $customer_data['firstname'] = $reg_data['firstname'];
                $customer_data['lastname'] = $reg_data['lastname'];
                $customer_data['email'] = $reg_data['email'];
                $customer_data['telephone'] = $reg_data['telephone'];
                $customer_data['fax'] = $reg_data['fax'];

                if (isset($reg_data['custom_field'])) {
                    $customer_data['custom_field'] = $reg_data['custom_field']['account'];
                }

                $customer_data['password'] = $reg_data['password'];
                $customer_data['newsletter'] = $reg_data['newsletter'];
                $customer_data['company'] = $reg_data['company'];
                $customer_data['address_1'] = $reg_data['address_1'];
                $customer_data['address_2'] = $reg_data['address_2'];
                $customer_data['city'] = $reg_data['city'];
                $customer_data['postcode'] = $reg_data['postcode'];
                $customer_data['country_id'] = $reg_data['country_id'];
                $customer_data['zone_id'] = $reg_data['zone_id'];

                $customer_id = $this->model_account_customer->addCustomer($customer_data);

                // Clear any previous login attempts for unregistered accounts.
                $this->model_account_customer->deleteLoginAttempts($reg_data['email']);

                // Add to activity log
                $this->load->model('account/activity');

                $activity_data = array(
                    'customer_id' => $customer_id,
                    'name' => $reg_data['firstname'] . ' ' . $reg_data['lastname']
                );

                $this->model_account_activity->addActivity('register', $activity_data);

                $this->load->model('register/user');
                $this->model_register_user->updateOrderCustomerID($reg_data['order_id'], $customer_id);

                $message = "";
                $this->model_checkout_order->addOrderHistory($reg_data['order_id'], 5, $message, true);

                //Add to MLM BackOffice//
                if ($customer_id && $reg_data['order_id']) {

                    $order_id = $reg_data['order_id'];
                    $reg_data['by_using'] = 'opencart';
                    $reg_data['customer_id'] = $customer_id;
                    $reg_data['reg_from_tree'] = false;
                    $reg_data['placement_user_name'] = $reg_data['sponsor_user_name'];
                    $reg_data['placement_full_name'] = $reg_data['sponsor_name'];
                    $reg_data['sponsor_user_name'] = $reg_data['sponsor_user_name'];
                    $reg_data['sponsor_full_name'] = $reg_data['sponsor_name'];
                    $reg_data['sponsor_id'] = $this->customer->userNameToID($reg_data['sponsor_user_name']);
                    $reg_data['position'] = $reg_data['position'];
                    $reg_data['first_name'] = $reg_data['firstname'];
                    $reg_data['last_name'] = $reg_data['lastname'];
                    $reg_data['email'] = $reg_data['email'];
                    $reg_data['mobile'] = $reg_data['telephone'];
                    $reg_data['land_line'] = $reg_data['telephone'];
                    $reg_data['date_of_birth'] = $reg_data['date_of_birth'];
                    $reg_data['gender'] = $reg_data['gender'];
                    $reg_data['address'] = $reg_data['address_1'];
                    $reg_data['address_line2'] = $reg_data['address_2'];
                    $reg_data['city'] = $reg_data['city'];
                    $reg_data['pin'] = $reg_data['postcode'];
                    $reg_data['table_prefix'] = $table_prefix = 2137;

                    $this->load->model('localisation/zone');
                    $zone_info = $this->model_localisation_zone->getZone($reg_data['zone_id']);
                    $reg_data['state'] = $zone_info['zone_id'];
                    $reg_data['state_name'] = $zone_info['name'];

                    $this->load->model('localisation/country');
                    $country_info = $this->model_localisation_country->getCountry($reg_data['country_id']);
                    $reg_data['country'] = $country_info['country_id'];
                    $reg_data['country_name'] = $country_info['name'];
                    $reg_data['user_name_type'] = USERNAME_TYPE;
                    if (USERNAME_TYPE == "static") {
                        $reg_data['user_name_entry'] = $reg_data['username'];
                    } else {
                        $reg_data['user_name_entry'] = '';
                    }
                    $reg_data['pswd'] = $reg_data['password'];
                    $reg_data['cpswd'] = $reg_data['confirm'];
                    $reg_data['mobile_code'] = '';
                    $reg_data['bank_name'] = '';
                    $reg_data['bank_branch'] = '';
                    $reg_data['bank_acc_no'] = '';
                    $reg_data['ifsc'] = '';
                    $reg_data['pan_no'] = '';
                    $reg_data['wallet_address'] = $reg_data['wallet_address'];

                    $this->load->model('checkout/order');
                    $order_info = $this->model_checkout_order->getOrder($order_id);

                    $product_id = $reg_data['product_id'];
                    $product_data = $this->model_register_data->getProduct($product_id);
                    $product_data['quantity'] = 1;

                    $total_amount = $product_data['price'];
                    $reg_data['reg_amount'] = $total_amount;

                    $reg_data["order_id"] = $order_id;

                    $this->model_account_inf_register->addToBackOffice($reg_data, $customer_id);

                    $registered_user_id = $this->customer->getUserIdFromCustomerId($customer_id);
                }
                $json['status'] = true;
            } else {
                $json['error'] = $this->language->get('an_error_occured');
            }
        } else {
            $json['error'] = $this->language->get('error_permission');
            $json['status'] = FALSE;
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

}
