<?php

class ControllerRegisterAutoship extends Controller {

    public function index() {
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

            $this->load->model('register/user');

            $autoship_order_data_post = $this->request->post;
            $customer_id = $autoship_order_data_post['customer_id'];
            $product_id = $autoship_order_data_post['product_id'];
            $quantity = $autoship_order_data_post['quantity'];

            if ($customer_id && $product_id && $quantity) {

                $this->cart->clear_autoship();
                $product['product_id'] = (int) $product_id;
                $key = base64_encode(serialize($product));
                $this->cart->update_autoship($key, $quantity);

                $customer_group_id = $this->model_register_user->getCustomerGroupID($customer_id);
                $customer_details = $this->model_register_user->getCustomerInfo($customer_id);
                $this->session->data['autoship_customer_id'] = $customer_id;

                //payment_address
                $country_id = $customer_details['country_id'];
                $country_details = $this->model_register_user->getCountryDetails($country_id);
                $zone_id = $customer_details['zone_id'];
                $zone_details = $this->model_register_user->getZoneDetails($zone_id);

                $payment_address = array(
                    'address_id' => '',
                    'firstname' => $customer_details['firstname'],
                    'lastname' => $customer_details['lastname'],
                    'company' => '',
                    'address_1' => $customer_details['address'],
                    'address_2' => '',
                    'postcode' => $customer_details['postcode'],
                    'city' => $customer_details['city'],
                    'zone_id' => $customer_details['zone_id'],
                    'zone' => $zone_details['zone'],
                    'zone_code' => $zone_details['zone_code'],
                    'country_id' => $customer_details['country_id'],
                    'country' => $country_details['country'],
                    'iso_code_2' => $country_details['iso_code_2'],
                    'iso_code_3' => $country_details['iso_code_3'],
                    'address_format' => $country_details['address_format'],
                    'custom_field' => '');
                $this->session->data['payment_address'] = $payment_address;

                //shipping_address
                $country_id = $autoship_order_data_post['shipping_country_id'];
                $country_details = $this->model_register_user->getCountryDetails($country_id);
                $zone_id = $autoship_order_data_post['shipping_zone_id'];
                $zone_details = $this->model_register_user->getZoneDetails($zone_id);

                $shipping_address = array(
                    'address_id' => '',
                    'firstname' => $customer_details['firstname'],
                    'lastname' => $customer_details['lastname'],
                    'company' => '',
                    'address_1' => $autoship_order_data_post['shipping_address_1'],
                    'address_2' => '',
                    'postcode' => $autoship_order_data_post['shipping_postcode'],
                    'city' => $autoship_order_data_post['shipping_city'],
                    'zone_id' => $autoship_order_data_post['shipping_zone_id'],
                    'zone' => $zone_details['zone'],
                    'zone_code' => $zone_details['zone_code'],
                    'country_id' => $autoship_order_data_post['shipping_country_id'],
                    'country' => $country_details['country'],
                    'iso_code_2' => $country_details['iso_code_2'],
                    'iso_code_3' => $country_details['iso_code_3'],
                    'address_format' => $country_details['address_format'],
                    'custom_field' => '');

                $this->session->data['shipping_address'] = $shipping_address;


                //////get Shipping rate
                if (isset($this->session->data['shipping_address'])) {
                    // Shipping Methods
                    $method_data = array();
                    $code = 'flat';
                    if ($this->config->get($code . '_status')) {
                        $this->load->model('shipping/' . $code);

                        $quote = $this->{'model_shipping_' . $code}->getAutoshipQuote($this->session->data['shipping_address']);

                        if ($quote) {
                            $method_data[$code] = array(
                                'title' => $quote['title'],
                                'quote' => $quote['quote'],
                                'sort_order' => $quote['sort_order'],
                                'error' => $quote['error']
                            );
                            $this->session->data['autoship_shipping_method'] = $method_data[$code]['quote'][$code];
                        }
                    }
                }
                ////// 


                $autoship_order_data['customer_id'] = $customer_id;
                $autoship_order_data['customer_group_id'] = $customer_group_id;
                $autoship_order_data['firstname'] = $customer_details['firstname'];
                $autoship_order_data['lastname'] = $customer_details['lastname'];
                $autoship_order_data['email'] = $customer_details['email'];
                $autoship_order_data['telephone'] = $customer_details['cellphone'];
                $autoship_order_data['fax'] = '';
                $autoship_order_data['custom_field'] = array();

                $autoship_order_data['payment_firstname'] = $payment_address['firstname'];
                $autoship_order_data['payment_lastname'] = $payment_address['lastname'];
                $autoship_order_data['payment_company'] = $payment_address['company'];
                $autoship_order_data['payment_address_1'] = $payment_address['address_1'];
                $autoship_order_data['payment_address_2'] = $payment_address['address_2'];
                $autoship_order_data['payment_city'] = $payment_address['city'];
                $autoship_order_data['payment_postcode'] = $payment_address['postcode'];
                $autoship_order_data['payment_zone_id'] = $payment_address['zone_id'];
                $autoship_order_data['payment_zone'] = $payment_address['zone'];
                $autoship_order_data['payment_country_id'] = $payment_address['country_id'];
                $autoship_order_data['payment_country'] = $payment_address['country'];
                $autoship_order_data['payment_address_format'] = $payment_address['address_format'];
                $autoship_order_data['payment_custom_field'] = array();

                $payment_methods = $this->model_register_user->getPaymentMethods('pp_pro');
                $autoship_order_data['payment_method'] = $payment_methods['pp_pro']['title'];
                $autoship_order_data['payment_code'] = $payment_methods['pp_pro']['code'];

                $autoship_order_data['shipping_firstname'] = $shipping_address['firstname'];
                $autoship_order_data['shipping_lastname'] = $shipping_address['lastname'];
                $autoship_order_data['shipping_company'] = '';
                $autoship_order_data['shipping_address_1'] = $shipping_address['address_1'];
                $autoship_order_data['shipping_address_2'] = '';
                $autoship_order_data['shipping_city'] = $shipping_address['city'];
                $autoship_order_data['shipping_postcode'] = $shipping_address['postcode'];
                $autoship_order_data['shipping_zone_id'] = $shipping_address['zone_id'];
                $autoship_order_data['shipping_zone'] = $shipping_address['zone'];
                $autoship_order_data['shipping_country_id'] = $shipping_address['country_id'];
                $autoship_order_data['shipping_country'] = $shipping_address['country'];
                $autoship_order_data['shipping_address_format'] = $shipping_address['address_format'];
                $autoship_order_data['shipping_custom_field'] = array();

                $shipping_methods = $this->model_register_user->getShippingMethods('flat', $shipping_address);
                $autoship_order_data['shipping_method'] = $shipping_methods['flat']['title'];
                $autoship_order_data['shipping_code'] = $shipping_methods['flat']['quote']['flat']['code'];

                $autoship_order_data['autoship_quantity'] = $quantity;
                $autoship_order_data['autoship_day'] = $autoship_order_data_post['autoship_day'];
                $autoship_order_data['shipping'] = 'flat.flat';

                $autoship_order_data['totals'] = array();
                $total = 0;
                $taxes = $this->cart->getAutoshipTaxes();

                $this->load->model('extension/extension');

                $sort_order = array();

                $results = $this->model_extension_extension->getExtensions('total');

                foreach ($results as $key => $value) {
                    $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
                }

                array_multisort($sort_order, SORT_ASC, $results);

                foreach ($results as $result) {
                    if ($this->config->get($result['code'] . '_status')) {
                        $this->load->model('total/' . $result['code']);

                        $this->{'model_total_' . $result['code']}->getAutoshipTotal($autoship_order_data['totals'], $total, $taxes);
                    }
                }

                $sort_order = array();

                foreach ($autoship_order_data['totals'] as $key => $value) {
                    $sort_order[$key] = $value['sort_order'];
                }

                array_multisort($sort_order, SORT_ASC, $autoship_order_data['totals']);

                $this->load->language('checkout/checkout');

                $autoship_order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
                $autoship_order_data['store_id'] = $this->config->get('config_store_id');
                $autoship_order_data['store_name'] = $this->config->get('config_name');

                if ($autoship_order_data['store_id']) {
                    $autoship_order_data['store_url'] = $this->config->get('config_url');
                } else {
                    $autoship_order_data['store_url'] = HTTP_SERVER;
                }

                $autoship_order_data['products'] = array();

                foreach ($this->cart->getAutoshipProducts() as $product) {
                    $option_data = array();
                    $autoship_order_data['products'][] = array(
                        'product_id' => $product['product_id'],
                        'name' => $product['name'],
                        'model' => $product['model'],
                        'option' => $option_data,
                        'download' => $product['download'],
                        'quantity' => $product['quantity'],
                        'autoship_day' => $autoship_order_data['autoship_day'],
                        'shipping_method' => $autoship_order_data['shipping'],
                        'subtract' => $product['subtract'],
                        'price' => $product['price'],
                        'price_excluding_tax' => $product['price_excluding_tax'],
                        'distributor_price' => $product['distributor_price'],
                        'product_pv' => $product['product_pv'],
                        'customer_pv' => $product['customer_pv'],
                        'product_type' => $product['product_type'],
                        'total' => $product['total'],
                        'tax' => $this->tax->getAutoshipTax($product['price'], $product['tax_class_id']),
                        'reward' => $product['reward']
                    );
                }

                $autoship_order_data['vouchers'] = array();
                $autoship_order_data['comment'] = '';
                $autoship_order_data['total'] = $total;
                $autoship_order_data['affiliate_id'] = 0;
                $autoship_order_data['commission'] = 0;
                $autoship_order_data['marketing_id'] = 0;
                $autoship_order_data['tracking'] = '';
                $autoship_order_data['language_id'] = $this->config->get('config_language_id');
                $autoship_order_data['currency_id'] = $this->currency->getId();
                $autoship_order_data['currency_code'] = $this->currency->getCode();
                $autoship_order_data['currency_value'] = $this->currency->getValue($this->currency->getCode());
                $autoship_order_data['ip'] = $this->request->server['REMOTE_ADDR'];

                if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
                    $autoship_order_data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
                } elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
                    $autoship_order_data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
                } else {
                    $autoship_order_data['forwarded_ip'] = '';
                }

                if (isset($this->request->server['HTTP_USER_AGENT'])) {
                    $autoship_order_data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
                } else {
                    $autoship_order_data['user_agent'] = '';
                }

                if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
                    $autoship_order_data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
                } else {
                    $autoship_order_data['accept_language'] = '';
                }

                if (!$autoship_order_data_post['autoship_order_id']) {
                    $autoship_order_id = $this->model_register_user->addAutoshipOrder($autoship_order_data);
                } else {
                    $autoship_order_id = $autoship_order_data_post['autoship_order_id'];
                    $autoship_order_id = $this->model_register_user->updateAutoshipOrder($autoship_order_data, $autoship_order_id);
                }
                $this->model_register_user->addAutoshipOrderHistory($autoship_order_id, 1, 'autoship_reset', false);
                $this->model_register_user->updateAutoshipOrderCCDetails($autoship_order_id, $autoship_order_data_post);
                unset($this->session->data['autoship_customer_id']);
                $this->cart->clear_autoship();
                echo $autoship_order_id;
                exit();
            } else {
                echo 'Invalid Product/Quantity';
                exit();
            }
        }
    }

    public function add_monthly_autoship() {

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

            $autoship_order_data_post = $this->request->post;
            $customer_id = $autoship_order_data_post['customer_id'];
            $order_id = $autoship_order_data_post['order_id'];
            $product_id = $autoship_order_data_post['product_id'];
            $quantity = $autoship_order_data_post['quantity'];
            $price = $autoship_order_data_post['price'];
            $total = $autoship_order_data_post['total'];
            $tax = $autoship_order_data_post['tax'];

            if ($order_id && $product_id && $quantity) {

                $this->session->data['autoship_request_order_id'] = $order_id;
                $this->session->data['autoship_customer_id'] = $customer_id;

                $this->cart->clear();
                $this->cart->add($product_id, $quantity);

                $product['product_id'] = (int) $product_id;
                $key = base64_encode(serialize($product));

                $redirect = '';

                /*
                 * check stock available
                 * 
                 * $products = $this->cart->getProducts();

                  foreach ($products as $product) {
                  $product_total = 0;

                  foreach ($products as $product_2) {
                  if ($product_2['product_id'] == $product['product_id']) {
                  $product_total += $product_2['quantity'];
                  }
                  }

                  if ($product['minimum'] > $product_total) {
                  $redirect = $this->url->link('checkout/cart');
                  break;
                  }
                  } */

                if (!$redirect) {

                    $this->load->model('checkout/order');
                    $this->load->model('register/user');

                    $autoship_order_info = $this->model_register_user->getAutoshipOrder($order_id);

                    $order_data = array();
                    $payment_address = array();
                    $shipping_address = array();

                    $this->load->language('checkout/checkout');

                    $order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
                    $order_data['store_id'] = $this->config->get('config_store_id');
                    $order_data['store_name'] = $this->config->get('config_name');

                    if ($order_data['store_id']) {
                        $order_data['store_url'] = $this->config->get('config_url');
                    } else {
                        $order_data['store_url'] = HTTP_SERVER;
                    }

                    $this->load->model('account/customer');

                    $customer_info = $this->model_account_customer->getCustomer($customer_id);

                    $order_data['customer_id'] = $customer_id;
                    $order_data['customer_group_id'] = $customer_info['customer_group_id'];
                    $order_data['firstname'] = $customer_info['firstname'];
                    $order_data['lastname'] = $customer_info['lastname'];
                    $order_data['email'] = $customer_info['email'];
                    $order_data['telephone'] = $customer_info['telephone'];
                    $order_data['fax'] = $customer_info['fax'];
                    $order_data['custom_field'] = unserialize($customer_info['custom_field']);

                    $payment_address['firstname'] = $order_data['payment_firstname'] = $autoship_order_info['payment_firstname'];
                    $payment_address['lastname'] = $order_data['payment_lastname'] = $autoship_order_info['payment_lastname'];
                    $payment_address['company'] = $order_data['payment_company'] = $autoship_order_info['payment_company'];
                    $payment_address['address_1'] = $order_data['payment_address_1'] = $autoship_order_info['payment_address_1'];
                    $payment_address['address_2'] = $order_data['payment_address_2'] = $autoship_order_info['payment_address_2'];
                    $payment_address['city'] = $order_data['payment_city'] = $autoship_order_info['payment_city'];
                    $payment_address['postcode'] = $order_data['payment_postcode'] = $autoship_order_info['payment_postcode'];
                    $payment_address['zone'] = $order_data['payment_zone'] = $autoship_order_info['payment_zone'];
                    $payment_address['zone_id'] = $order_data['payment_zone_id'] = $autoship_order_info['payment_zone_id'];
                    $payment_address['country'] = $order_data['payment_country'] = $autoship_order_info['payment_country'];
                    $payment_address['country_id'] = $order_data['payment_country_id'] = $autoship_order_info['payment_country_id'];
                    $payment_address['address_format'] = $order_data['payment_address_format'] = $autoship_order_info['payment_address_format'];
                    $payment_address['custom_field'] = $order_data['payment_custom_field'] = (isset($autoship_order_info['payment_custom_field']) ? $autoship_order_info['payment_custom_field'] : array());
                    $this->session->data['payment_address'] = $payment_address;

                    $order_data['payment_method'] = $autoship_order_info['payment_method'];
                    $order_data['payment_code'] = $autoship_order_info['payment_code'];

                    $shipping_address['firstname'] = $order_data['shipping_firstname'] = $autoship_order_info['shipping_firstname'];
                    $shipping_address['lastname'] = $order_data['shipping_lastname'] = $autoship_order_info['shipping_lastname'];
                    $shipping_address['company'] = $order_data['shipping_company'] = $autoship_order_info['shipping_company'];
                    $shipping_address['address_1'] = $order_data['shipping_address_1'] = $autoship_order_info['shipping_address_1'];
                    $shipping_address['address_2'] = $order_data['shipping_address_2'] = $autoship_order_info['shipping_address_2'];
                    $shipping_address['city'] = $order_data['shipping_city'] = $autoship_order_info['shipping_city'];
                    $shipping_address['postcode'] = $order_data['shipping_postcode'] = $autoship_order_info['shipping_postcode'];
                    $shipping_address['zone'] = $order_data['shipping_zone'] = $autoship_order_info['shipping_zone'];
                    $shipping_address['zone_id'] = $order_data['shipping_zone_id'] = $autoship_order_info['shipping_zone_id'];
                    $shipping_address['country'] = $order_data['shipping_country'] = $autoship_order_info['shipping_country'];
                    $shipping_address['country_id'] = $order_data['shipping_country_id'] = $autoship_order_info['shipping_country_id'];
                    $shipping_address['address_format'] = $order_data['shipping_address_format'] = $autoship_order_info['shipping_address_format'];
                    $shipping_address['custom_field'] = $order_data['shipping_custom_field'] = (isset($autoship_order_info['shipping_custom_field']) ? $autoship_order_info['shipping_custom_field'] : array());
                    $this->session->data['shipping_address'] = $shipping_address;

                    $order_data['shipping_method'] = $autoship_order_info['shipping_method'];
                    $order_data['shipping_code'] = $autoship_order_info['shipping_code'];

                    //////get Shipping rate
                    if (isset($this->session->data['shipping_address'])) {
                        // Shipping Methods
                        $method_data = array();

                        $shipping = explode('.', $autoship_order_info['shipping_code']);

                        $code = $shipping[0];
                        if ($this->config->get($code . '_status')) {
                            $this->load->model('shipping/' . $code);

                            $quote = $this->{'model_shipping_' . $code}->getQuote($this->session->data['shipping_address']);

                            if ($quote) {
                                $method_data[$code] = array(
                                    'title' => $quote['title'],
                                    'quote' => $quote['quote'],
                                    'sort_order' => $quote['sort_order'],
                                    'error' => $quote['error']
                                );

                                $this->session->data['shipping_method'] = $method_data[$code]['quote'][$shipping[1]];
                            }
                        }
                    }
                    ////// 


                    $total = 0;
                    $taxes = $this->cart->getTaxes();

                    $this->load->model('extension/extension');

                    $sort_order = array();

                    $results = $this->model_extension_extension->getExtensions('total');

                    foreach ($results as $key => $value) {
                        $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
                    }

                    array_multisort($sort_order, SORT_ASC, $results);

                    foreach ($results as $result) {
                        if ($this->config->get($result['code'] . '_status')) {
                            $this->load->model('total/' . $result['code']);
                            $this->{'model_total_' . $result['code']}->getTotal($order_data['totals'], $total, $taxes);
                        }
                    }

                    $sort_order = array();

                    foreach ($order_data['totals'] as $key => $value) {
                        $sort_order[$key] = $value['sort_order'];
                    }

                    array_multisort($sort_order, SORT_ASC, $order_data['totals']);


                    $order_data['products'] = array();

                    foreach ($this->cart->getProducts() as $product) {
                        $option_data = array();

                        foreach ($product['option'] as $option) {
                            $option_data[] = array(
                                'product_option_id' => $option['product_option_id'],
                                'product_option_value_id' => $option['product_option_value_id'],
                                'option_id' => $option['option_id'],
                                'option_value_id' => $option['option_value_id'],
                                'name' => $option['name'],
                                'value' => $option['value'],
                                'type' => $option['type']
                            );
                        }

                        $order_data['products'][] = array(
                            'faststart_bonus' => $product['faststart_bonus'],
                            'faststart_bonus_points' => $product['faststart_bonus_points'],
                            'autoship_status' => $product['autoship_status'],
                            'cart_autoship_status' => $product['cart_autoship_status'],
                            'product_id' => $product['product_id'],
                            'name' => $product['name'],
                            'model' => $product['model'],
                            'option' => $option_data,
                            'download' => $product['download'],
                            'quantity' => $product['quantity'],
                            'subtract' => $product['subtract'],
                            'price' => $product['price'],
                            'total' => $product['total'],
                            'tax' => $this->tax->getTax($product['price'], $product['tax_class_id']),
                            'reward' => $product['reward']
                        );
                    }

                    // Gift Voucher
                    $order_data['vouchers'] = array();

                    $order_data['comment'] = '';
                    $order_data['total'] = $total;

                    if (isset($this->request->cookie['tracking'])) {
                        $order_data['tracking'] = $this->request->cookie['tracking'];

                        $subtotal = $this->cart->getSubTotal();

                        // Affiliate
                        $this->load->model('affiliate/affiliate');

                        $affiliate_info = $this->model_affiliate_affiliate->getAffiliateByCode($this->request->cookie['tracking']);

                        if ($affiliate_info) {
                            $order_data['affiliate_id'] = $affiliate_info['affiliate_id'];
                            $order_data['commission'] = ($subtotal / 100) * $affiliate_info['commission'];
                        } else {
                            $order_data['affiliate_id'] = 0;
                            $order_data['commission'] = 0;
                        }

                        // Marketing
                        $this->load->model('checkout/marketing');

                        $marketing_info = $this->model_checkout_marketing->getMarketingByCode($this->request->cookie['tracking']);

                        if ($marketing_info) {
                            $order_data['marketing_id'] = $marketing_info['marketing_id'];
                        } else {
                            $order_data['marketing_id'] = 0;
                        }
                    } else {
                        $order_data['affiliate_id'] = 0;
                        $order_data['commission'] = 0;
                        $order_data['marketing_id'] = 0;
                        $order_data['tracking'] = '';
                    }

                    $order_data['language_id'] = $this->config->get('config_language_id');
                    $order_data['currency_id'] = $this->currency->getId();
                    $order_data['currency_code'] = $this->currency->getCode();
                    $order_data['currency_value'] = $this->currency->getValue($this->currency->getCode());
                    $order_data['ip'] = $this->request->server['REMOTE_ADDR'];

                    if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
                        $order_data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
                    } elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
                        $order_data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
                    } else {
                        $order_data['forwarded_ip'] = '';
                    }

                    if (isset($this->request->server['HTTP_USER_AGENT'])) {
                        $order_data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
                    } else {
                        $order_data['user_agent'] = '';
                    }

                    if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
                        $order_data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
                    } else {
                        $order_data['accept_language'] = '';
                    }

                    $order_data['type'] = 'monthly';

                    $this->session->data['order_id'] = $this->model_checkout_order->addOrder($order_data);
                    $autoship_order_id = $this->session->data['order_id'];

                    $Payment_response = $this->pay_autoship_fee();
                    $Payment_response_split = explode(":", $Payment_response);
                    $Payment_status = $Payment_response_split[0];
                    $message = $Payment_response_split[1];

                    if ($Payment_status == 'success') {
                        $this->load->model('checkout/order');
                        $order_type = 'autoship';


                        $this->model_checkout_order->addOrderHistory($autoship_order_id, $this->config->get('pp_pro_order_status_id'), $message, false, $order_type);
                        $this->load->model('register/user');
                        $this->model_register_user->calculateUserRepurchase($autoship_order_id, $customer_id);

                        $this->cart->clear();
                        unset($this->session->data['autoship_customer_id']);
                        unset($this->session->data['autoship_request_order_id']);
                        unset($this->session->data['order_id']);
                        echo $autoship_order_id;
                        exit();
                    } else {
                        $this->model_register_user->addFailedOrderHistory($customer_id, $order_id, $autoship_order_id, $message);
                        unset($this->session->data['autoship_request_order_id']);
                        unset($this->session->data['autoship_customer_id']);
                        unset($this->session->data['order_id']);
                        $this->cart->clear();
                        echo 'payment_failed';
                        exit();
                    }
                }
            } else {
                echo 'Invalid Product/Quantity';
                exit();
            }
            return $result;
        }
    }

    public function pay_autoship_fee() {

        if (!$this->config->get('pp_pro_transaction')) {
            $payment_type = 'Authorization';
        } else {
            $payment_type = 'Sale';
        }

        $this->load->model('register/user');
        $autoship_order_info = $this->model_register_user->getAutoshipOrder($this->session->data['autoship_request_order_id']);

        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        $request = 'METHOD=DoDirectPayment';
        $request .= '&VERSION=51.0';
        $request .= '&USER=' . urlencode($this->config->get('pp_pro_username'));
        $request .= '&PWD=' . urlencode($this->config->get('pp_pro_password'));
        $request .= '&SIGNATURE=' . urlencode($this->config->get('pp_pro_signature'));
        $request .= '&CUSTREF=' . (int) $order_info['order_id'];
        $request .= '&PAYMENTACTION=' . $payment_type;
        $request .= '&AMT=' . $this->currency->format($order_info['total'], $order_info['currency_code'], false, false);
        $request .= '&CREDITCARDTYPE=' . $autoship_order_info['cc_type'];
        $request .= '&ACCT=' . urlencode(str_replace(' ', '', $autoship_order_info['cc_number']));
        $request .= '&CARDSTART=' . urlencode('' . '');
        $request .= '&EXPDATE=' . urlencode($autoship_order_info['cc_expire_date_month'] . $autoship_order_info['cc_expire_date_year']);
        $request .= '&CVV2=' . urlencode($autoship_order_info['cc_cvv2']);

        if ($autoship_order_info['cc_type'] == 'SWITCH' || $autoship_order_info['cc_type'] == 'SOLO') {
            $request .= '&CARDISSUE=' . urlencode($autoship_order_info['cc_issue']);
        }

        $request .= '&FIRSTNAME=' . urlencode($order_info['payment_firstname']);
        $request .= '&LASTNAME=' . urlencode($order_info['payment_lastname']);
        $request .= '&EMAIL=' . urlencode($order_info['email']);
        $request .= '&PHONENUM=' . urlencode($order_info['telephone']);
        $request .= '&IPADDRESS=' . urlencode($this->request->server['REMOTE_ADDR']);
        $request .= '&STREET=' . urlencode($order_info['payment_address_1']);
        $request .= '&CITY=' . urlencode($order_info['payment_city']);
        $request .= '&STATE=' . urlencode(($order_info['payment_iso_code_2'] != 'US') ? $order_info['payment_zone'] : $order_info['payment_zone_code']);
        $request .= '&ZIP=' . urlencode($order_info['payment_postcode']);
        $request .= '&COUNTRYCODE=' . urlencode($order_info['payment_iso_code_2']);
        $request .= '&CURRENCYCODE=' . urlencode($order_info['currency_code']);

        if ($this->cart->hasShipping()) {
            $request .= '&SHIPTONAME=' . urlencode($order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname']);
            $request .= '&SHIPTOSTREET=' . urlencode($order_info['shipping_address_1']);
            $request .= '&SHIPTOCITY=' . urlencode($order_info['shipping_city']);
            $request .= '&SHIPTOSTATE=' . urlencode(($order_info['shipping_iso_code_2'] != 'US') ? $order_info['shipping_zone'] : $order_info['shipping_zone_code']);
            $request .= '&SHIPTOCOUNTRYCODE=' . urlencode($order_info['shipping_iso_code_2']);
            $request .= '&SHIPTOZIP=' . urlencode($order_info['shipping_postcode']);
        } else {
            $request .= '&SHIPTONAME=' . urlencode($order_info['payment_firstname'] . ' ' . $order_info['payment_lastname']);
            $request .= '&SHIPTOSTREET=' . urlencode($order_info['payment_address_1']);
            $request .= '&SHIPTOCITY=' . urlencode($order_info['payment_city']);
            $request .= '&SHIPTOSTATE=' . urlencode(($order_info['payment_iso_code_2'] != 'US') ? $order_info['payment_zone'] : $order_info['payment_zone_code']);
            $request .= '&SHIPTOCOUNTRYCODE=' . urlencode($order_info['payment_iso_code_2']);
            $request .= '&SHIPTOZIP=' . urlencode($order_info['payment_postcode']);
        }

        $pp_pro_history_id = $this->model_register_user->insertPP_PROHistory($request, $this->session->data['order_id'], $order_info['customer_id'], 'autoship_order');

        if (!$this->config->get('pp_pro_test')) {
            $curl = curl_init('https://api-3t.paypal.com/nvp');
        } else {
            $curl = curl_init('https://api-3t.sandbox.paypal.com/nvp');
        }

        curl_setopt($curl, CURLOPT_PORT, 443);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
        $response = curl_exec($curl);
        curl_close($curl);

        if (!$response) {
            $this->log->write('DoDirectPayment failed: ' . curl_error($curl) . '(' . curl_errno($curl) . ')');
        }

        $response_info = array();

        parse_str($response, $response_info);

        $this->model_register_user->updatePP_PROHistory($pp_pro_history_id, $response_info, $this->session->data['order_id'], $order_info['customer_id']);


        if (($response_info['ACK'] == 'Success') || ($response_info['ACK'] == 'SuccessWithWarning')) {

            $message = '';

            if (isset($response_info['AVSCODE'])) {
                $message .= 'AVSCODE: ' . $response_info['AVSCODE'] . "\n";
            }

            if (isset($response_info['CVV2MATCH'])) {
                $message .= 'CVV2MATCH: ' . $response_info['CVV2MATCH'] . "\n";
            }

            if (isset($response_info['TRANSACTIONID'])) {
                $message .= 'TRANSACTIONID: ' . $response_info['TRANSACTIONID'] . "\n";
            }

            return 'success:' . $message;
        } else {
            return 'error:' . $response_info['L_LONGMESSAGE0'];
        }
    }

    public function add_monthly_autoship_old() {
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

            $autoship_order_data_post = $this->request->post;
            $product_id = $autoship_order_data_post['product_id'];
            $quantity = $autoship_order_data_post['quantity'];
            if ($product_id && $quantity) {
                $this->cart->clear_autoship();
                $product['product_id'] = (int) $product_id;
                $key = base64_encode(serialize($product));
                $this->cart->update_autoship($key, $quantity);

                $this->load->model('register/user');

                $customer_id = $autoship_order_data_post['customer_id'];
                $customer_group_id = $this->model_register_user->getCustomerGroupID($customer_id);
                $customer_details = $this->model_register_user->getCustomerInfo($customer_id);
                $this->session->data['autoship_customer_id'] = $customer_id;

                //payment_address
                $payment_address = array(
                    'address_id' => '',
                    'firstname' => $autoship_order_data_post['payment_firstname'],
                    'lastname' => $autoship_order_data_post['payment_lastname'],
                    'company' => $autoship_order_data_post['payment_company'],
                    'address_1' => $autoship_order_data_post['payment_address_1'],
                    'address_2' => $autoship_order_data_post['payment_address_2'],
                    'postcode' => $autoship_order_data_post['payment_postcode'],
                    'city' => $autoship_order_data_post['payment_city'],
                    'zone_id' => $autoship_order_data_post['payment_zone_id'],
                    'zone' => $autoship_order_data_post['payment_zone'],
                    'zone_code' => $autoship_order_data_post['payment_zone_code'],
                    'country_id' => $autoship_order_data_post['payment_country_id'],
                    'country' => $autoship_order_data_post['payment_country'],
                    'iso_code_2' => $autoship_order_data_post['payment_iso_code_2'],
                    'iso_code_3' => $autoship_order_data_post['payment_iso_code_3'],
                    'address_format' => $autoship_order_data_post['payment_address_format'],
                    'custom_field' => $autoship_order_data_post['payment_custom_field']);
                $this->session->data['payment_address'] = $payment_address;

                //shipping_address
                $shipping_address = array(
                    'address_id' => '',
                    'firstname' => $autoship_order_data_post['shipping_firstname'],
                    'lastname' => $autoship_order_data_post['shipping_lastname'],
                    'company' => $autoship_order_data_post['shipping_company'],
                    'address_1' => $autoship_order_data_post['shipping_address_1'],
                    'address_2' => $autoship_order_data_post['shipping_address_2'],
                    'postcode' => $autoship_order_data_post['shipping_postcode'],
                    'city' => $autoship_order_data_post['shipping_city'],
                    'zone_id' => $autoship_order_data_post['shipping_zone_id'],
                    'zone' => $autoship_order_data_post['shipping_zone'],
                    'zone_code' => $autoship_order_data_post['shipping_zone_code'],
                    'country_id' => $autoship_order_data_post['shipping_country_id'],
                    'country' => $autoship_order_data_post['shipping_country'],
                    'iso_code_2' => $autoship_order_data_post['shipping_iso_code_2'],
                    'iso_code_3' => $autoship_order_data_post['shipping_iso_code_3'],
                    'address_format' => $autoship_order_data_post['shipping_address_format'],
                    'custom_field' => $autoship_order_data_post['shipping_custom_field']);

                $this->session->data['shipping_address'] = $shipping_address;


                //////get Shipping rate
                if (isset($this->session->data['shipping_address'])) {
                    // Shipping Methods
                    $method_data = array();
                    $code = 'flat';
                    if ($this->config->get($code . '_status')) {
                        $this->load->model('shipping/' . $code);

                        $quote = $this->{'model_shipping_' . $code}->getAutoshipQuote($this->session->data['shipping_address']);

                        if ($quote) {
                            $method_data[$code] = array(
                                'title' => $quote['title'],
                                'quote' => $quote['quote'],
                                'sort_order' => $quote['sort_order'],
                                'error' => $quote['error']
                            );
                            $this->session->data['autoship_shipping_method'] = $method_data[$code]['quote'][$code];
                        }
                    }
                }
                ////// 

                $autoship_order_data['customer_id'] = $customer_id;
                $autoship_order_data['customer_group_id'] = $customer_group_id;
                $autoship_order_data['firstname'] = $customer_details['firstname'];
                $autoship_order_data['lastname'] = $customer_details['lastname'];
                $autoship_order_data['email'] = $customer_details['email'];
                $autoship_order_data['telephone'] = $customer_details['cellphone'];
                $autoship_order_data['fax'] = '';
                $autoship_order_data['custom_field'] = array();

                $autoship_order_data['payment_firstname'] = $payment_address['firstname'];
                $autoship_order_data['payment_lastname'] = $payment_address['lastname'];
                $autoship_order_data['payment_company'] = $payment_address['company'];
                $autoship_order_data['payment_address_1'] = $payment_address['address_1'];
                $autoship_order_data['payment_address_2'] = $payment_address['address_2'];
                $autoship_order_data['payment_city'] = $payment_address['city'];
                $autoship_order_data['payment_postcode'] = $payment_address['postcode'];
                $autoship_order_data['payment_zone_id'] = $payment_address['zone_id'];
                $autoship_order_data['payment_zone'] = $payment_address['zone'];
                $autoship_order_data['payment_country_id'] = $payment_address['country_id'];
                $autoship_order_data['payment_country'] = $payment_address['country'];
                $autoship_order_data['payment_address_format'] = $payment_address['address_format'];
                $autoship_order_data['payment_custom_field'] = array();

                $payment_methods = $this->model_register_user->getPaymentMethods('pp_pro');
                $autoship_order_data['payment_method'] = $payment_methods['pp_pro']['title'];
                $autoship_order_data['payment_code'] = $payment_methods['pp_pro']['code'];

                $autoship_order_data['shipping_firstname'] = $shipping_address['firstname'];
                $autoship_order_data['shipping_lastname'] = $shipping_address['lastname'];
                $autoship_order_data['shipping_company'] = $shipping_address['company'];
                $autoship_order_data['shipping_address_1'] = $shipping_address['address_1'];
                $autoship_order_data['shipping_address_2'] = $shipping_address['address_2'];
                $autoship_order_data['shipping_city'] = $shipping_address['city'];
                $autoship_order_data['shipping_postcode'] = $shipping_address['postcode'];
                $autoship_order_data['shipping_zone_id'] = $shipping_address['zone_id'];
                $autoship_order_data['shipping_zone'] = $shipping_address['zone'];
                $autoship_order_data['shipping_country_id'] = $shipping_address['country_id'];
                $autoship_order_data['shipping_country'] = $shipping_address['country'];
                $autoship_order_data['shipping_address_format'] = $shipping_address['address_format'];
                $autoship_order_data['shipping_custom_field'] = array();

                $shipping_methods = $this->model_register_user->getShippingMethods('flat', $shipping_address);
                $autoship_order_data['shipping_method'] = $shipping_methods['flat']['title'];
                $autoship_order_data['shipping_code'] = $shipping_methods['flat']['quote']['flat']['code'];

                $autoship_order_data['autoship_quantity'] = $quantity;
                $autoship_order_data['autoship_day'] = $autoship_order_data_post['autoship_day'];
                $autoship_order_data['shipping'] = 'flat.flat';

                $autoship_order_data['totals'] = array();
                $total = 0;
                $taxes = $this->cart->getAutoshipTaxes();

                $this->load->model('extension/extension');

                $sort_order = array();

                $results = $this->model_extension_extension->getExtensions('total');

                foreach ($results as $key => $value) {
                    $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
                }

                array_multisort($sort_order, SORT_ASC, $results);

                foreach ($results as $result) {
                    if ($this->config->get($result['code'] . '_status')) {
                        $this->load->model('total/' . $result['code']);

                        $this->{'model_total_' . $result['code']}->getAutoshipTotal($autoship_order_data['totals'], $total, $taxes);
                    }
                }

                $sort_order = array();

                foreach ($autoship_order_data['totals'] as $key => $value) {
                    $sort_order[$key] = $value['sort_order'];
                }

                array_multisort($sort_order, SORT_ASC, $autoship_order_data['totals']);

                $this->load->language('checkout/checkout');

                $autoship_order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
                $autoship_order_data['store_id'] = $this->config->get('config_store_id');
                $autoship_order_data['store_name'] = $this->config->get('config_name');

                if ($autoship_order_data['store_id']) {
                    $autoship_order_data['store_url'] = $this->config->get('config_url');
                } else {
                    $autoship_order_data['store_url'] = HTTP_SERVER;
                }

                $autoship_order_data['products'] = array();

                foreach ($this->cart->getAutoshipProducts() as $product) {
                    $option_data = array();
                    $autoship_order_data['products'][] = array(
                        'product_id' => $product['product_id'],
                        'name' => $product['name'],
                        'model' => $product['model'],
                        'option' => $option_data,
                        'download' => $product['download'],
                        'quantity' => $product['quantity'],
                        'autoship_day' => $autoship_order_data['autoship_day'],
                        'shipping_method' => $autoship_order_data['shipping'],
                        'subtract' => $product['subtract'],
                        'price' => $product['price'],
                        'price_excluding_tax' => $product['price_excluding_tax'],
                        'distributor_price' => $product['distributor_price'],
                        'product_pv' => $product['product_pv'],
                        'customer_pv' => $product['customer_pv'],
                        'product_type' => $product['product_type'],
                        'total' => $product['total'],
                        'tax' => $this->tax->getTax($product['price'], $product['tax_class_id']),
                        'reward' => $product['reward'],
                        'autoship_status' => 'yes'
                    );
                }

                $autoship_order_data['vouchers'] = array();
                $autoship_order_data['comment'] = '';
                $autoship_order_data['total'] = $total;
                $autoship_order_data['affiliate_id'] = 0;
                $autoship_order_data['commission'] = 0;
                $autoship_order_data['marketing_id'] = 0;
                $autoship_order_data['tracking'] = '';
                $autoship_order_data['language_id'] = $this->config->get('config_language_id');
                $autoship_order_data['currency_id'] = $this->currency->getId();
                $autoship_order_data['currency_code'] = $this->currency->getCode();
                $autoship_order_data['currency_value'] = $this->currency->getValue($this->currency->getCode());
                $autoship_order_data['ip'] = $this->request->server['REMOTE_ADDR'];

                if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
                    $autoship_order_data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
                } elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
                    $autoship_order_data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
                } else {
                    $autoship_order_data['forwarded_ip'] = '';
                }

                if (isset($this->request->server['HTTP_USER_AGENT'])) {
                    $autoship_order_data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
                } else {
                    $autoship_order_data['user_agent'] = '';
                }

                if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
                    $autoship_order_data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
                } else {
                    $autoship_order_data['accept_language'] = '';
                }

                $this->load->model('checkout/order');

                $order_id = $this->model_checkout_order->addOrder($autoship_order_data);

                //PP PRO Payment
                if (!$this->config->get('pp_pro_transaction')) {
                    $payment_type = 'Authorization';
                } else {
                    $payment_type = 'Sale';
                }

                $order_info = $this->model_checkout_order->getOrder($order_id);
                //$total_amount = $this->cart->getAutoshipTotal();
                $total_amount = $order_info['total'];

                $request = 'METHOD=DoDirectPayment';
                $request .= '&VERSION=51.0';
                $request .= '&USER=' . urlencode($this->config->get('pp_pro_username'));
                $request .= '&PWD=' . urlencode($this->config->get('pp_pro_password'));
                $request .= '&SIGNATURE=' . urlencode($this->config->get('pp_pro_signature'));
                $request .= '&CUSTREF=' . (int) $order_info['order_id'];
                $request .= '&PAYMENTACTION=' . $payment_type;
                $request .= '&AMT=' . $this->currency->format($total_amount, $order_info['currency_code'], false, false);
                $request .= '&CREDITCARDTYPE=' . $autoship_order_data_post['cc_type'];
                $request .= '&ACCT=' . urlencode(str_replace(' ', '', $autoship_order_data_post['cc_number']));

                $request .= '&EXPDATE=' . urlencode($autoship_order_data_post['cc_expire_date_month'] . $autoship_order_data_post['cc_expire_date_year']);
                $request .= '&CVV2=' . urlencode($autoship_order_data_post['cc_cvv2']);

                if ($autoship_order_data_post['cc_type'] == 'SWITCH' || $autoship_order_data_post['cc_type'] == 'SOLO') {
                    $request .= '&ISSUENUMBER=' . urlencode($autoship_order_data_post['cc_issue']);
                }
                $request .= '&FIRSTNAME=' . urlencode($order_info['payment_firstname']);
                $request .= '&LASTNAME=' . urlencode($order_info['payment_lastname']);
                $request .= '&EMAIL=' . urlencode($order_info['email']);
                $request .= '&PHONENUM=' . urlencode($order_info['telephone']);
                $request .= '&IPADDRESS=' . urlencode($this->request->server['REMOTE_ADDR']);
                $request .= '&STREET=' . urlencode($order_info['payment_address_1']);
                $request .= '&CITY=' . urlencode($order_info['payment_city']);
                $request .= '&STATE=' . urlencode(($order_info['payment_iso_code_2'] != 'US') ? $order_info['payment_zone'] : $order_info['payment_zone_code']);
                $request .= '&ZIP=' . urlencode($order_info['payment_postcode']);
                $request .= '&COUNTRYCODE=' . urlencode($order_info['payment_iso_code_2']);
                $request .= '&CURRENCYCODE=' . urlencode($order_info['currency_code']);
                $request .= '&BUTTONSOURCE=' . urlencode('OpenCart_2.0_WPP');


                $request .= '&SHIPTONAME=' . urlencode($order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname']);
                $request .= '&SHIPTOSTREET=' . urlencode($order_info['shipping_address_1']);
                $request .= '&SHIPTOCITY=' . urlencode($order_info['shipping_city']);
                $request .= '&SHIPTOSTATE=' . urlencode(($order_info['shipping_iso_code_2'] != 'US') ? $order_info['shipping_zone'] : $order_info['shipping_zone_code']);
                $request .= '&SHIPTOCOUNTRYCODE=' . urlencode($order_info['shipping_iso_code_2']);
                $request .= '&SHIPTOZIP=' . urlencode($order_info['shipping_postcode']);

                $pp_pro_history_id = $this->model_register_user->insertPP_PROHistory($request, $order_id, $customer_id, 'autoship_order');

                if (!$this->config->get('pp_pro_test')) {
                    $curl = curl_init('https://api-3t.paypal.com/nvp');
                } else {
                    $curl = curl_init('https://api-3t.sandbox.paypal.com/nvp');
                }

                curl_setopt($curl, CURLOPT_PORT, 443);
                curl_setopt($curl, CURLOPT_HEADER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
                curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $request);

                $response = curl_exec($curl);

                curl_close($curl);


                if (!$response) {
                    $this->log->write('DoDirectPayment failed: ' . curl_error($curl) . '(' . curl_errno($curl) . ')');
                }

                $response_info = array();

                parse_str($response, $response_info);


                $this->model_register_user->updatePP_PROHistory($pp_pro_history_id, $response_info, $order_id, $customer_id);
                
                if (($response_info['ACK'] == 'Success') || ($response_info['ACK'] == 'SuccessWithWarning')) {
                    $message = '';

                    if (isset($response_info['AVSCODE'])) {
                        $message .= 'AVSCODE: ' . $response_info['AVSCODE'] . "\n";
                    }

                    if (isset($response_info['CVV2MATCH'])) {
                        $message .= 'CVV2MATCH: ' . $response_info['CVV2MATCH'] . "\n";
                    }

                    if (isset($response_info['TRANSACTIONID'])) {
                        $message .= 'TRANSACTIONID: ' . $response_info['TRANSACTIONID'] . "\n";
                    }

                    $this->load->model('checkout/order');
                    $order_type = 'autoship';
                    $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('pp_pro_order_status_id'), $message, false, $order_type);
                    $this->load->model('register/user');
                    $this->model_register_user->calculateUserRepurchase($order_id, $customer_id);

                    $this->cart->clear_autoship();
                    echo $order_id;
                    exit();
                } else {
                    $this->cart->clear_autoship();
                    echo 'payment_failed';
                    exit();
                }
            } else {
                echo 'Invalid Product/Quantity';
                exit();
            }
        }
    }

    public function upgrade_customer_order() {
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

            $autoship_order_data_post = $this->request->post;
            $product_id = $autoship_order_data_post['product_id'];
            $quantity = 1;
            if ($product_id && $quantity) {
                $this->cart->clear();
                $product['product_id'] = (int) $product_id;
                $key = base64_encode(serialize($product));
                $this->cart->update_purchase($key, $quantity);

                $this->load->model('register/user');

                $customer_id = $autoship_order_data_post['customer_id'];
                $customer_group_id = $this->model_register_user->getCustomerGroupID($customer_id);
                $customer_details = $this->model_register_user->getCustomerInfo($customer_id);
                $this->session->data['autoship_customer_id'] = $customer_id;


                //payment_address
                $country_id = $customer_details['country_id'];
                $country_details = $this->model_register_user->getCountryDetails($country_id);
                $zone_id = $customer_details['zone_id'];
                $zone_details = $this->model_register_user->getZoneDetails($zone_id);

                $address_data = array(
                    'address_id' => '',
                    'firstname' => $customer_details['firstname'],
                    'lastname' => $customer_details['lastname'],
                    'company' => '',
                    'address_1' => $customer_details['address'],
                    'address_2' => '',
                    'postcode' => $customer_details['postcode'],
                    'city' => $customer_details['city'],
                    'zone_id' => $customer_details['zone_id'],
                    'zone' => $zone_details['zone'],
                    'zone_code' => $zone_details['zone_code'],
                    'country_id' => $customer_details['country_id'],
                    'country' => $country_details['country'],
                    'iso_code_2' => $country_details['iso_code_2'],
                    'iso_code_3' => $country_details['iso_code_3'],
                    'address_format' => $country_details['address_format'],
                    'custom_field' => '');
                $this->session->data['payment_address'] = $address_data;

                //shipping_address
                $country_id = $customer_details['ship_country_id'];
                $country_details = $this->model_register_user->getCountryDetails($country_id);
                $zone_id = $customer_details['ship_zone_id'];
                $zone_details = $this->model_register_user->getZoneDetails($zone_id);

                $shipping_address = array(
                    'address_id' => '',
                    'firstname' => $customer_details['firstname'],
                    'lastname' => $customer_details['lastname'],
                    'company' => '',
                    'address_1' => $customer_details['ship_address'],
                    'address_2' => '',
                    'postcode' => $customer_details['ship_postcode'],
                    'city' => $customer_details['ship_city'],
                    'zone_id' => $customer_details['ship_zone_id'],
                    'zone' => $zone_details['zone'],
                    'zone_code' => $zone_details['zone_code'],
                    'country_id' => $customer_details['ship_country_id'],
                    'country' => $country_details['country'],
                    'iso_code_2' => $country_details['iso_code_2'],
                    'iso_code_3' => $country_details['iso_code_3'],
                    'address_format' => $country_details['address_format'],
                    'custom_field' => '');

                $this->session->data['shipping_address'] = $shipping_address;


                //////get Shipping rate
                if (isset($this->session->data['shipping_address'])) {
                    // Shipping Methods
                    $method_data = array();
                    $code = 'flat';
                    if ($this->config->get($code . '_status')) {
                        $this->load->model('shipping/' . $code);

                        $quote = $this->{'model_shipping_' . $code}->getAutoshipQuote($this->session->data['shipping_address']);

                        if ($quote) {
                            $method_data[$code] = array(
                                'title' => $quote['title'],
                                'quote' => $quote['quote'],
                                'sort_order' => $quote['sort_order'],
                                'error' => $quote['error']
                            );
                            $this->session->data['shipping_method'] = $method_data[$code]['quote'][$code];
                        }
                    }
                }
                ////// 

                $autoship_order_data['customer_id'] = $customer_id;
                $autoship_order_data['customer_group_id'] = $customer_group_id;
                $autoship_order_data['firstname'] = $customer_details['firstname'];
                $autoship_order_data['lastname'] = $customer_details['lastname'];
                $autoship_order_data['email'] = $customer_details['email'];
                $autoship_order_data['telephone'] = $customer_details['cellphone'];
                $autoship_order_data['fax'] = '';
                $autoship_order_data['custom_field'] = array();

                $autoship_order_data['payment_firstname'] = $customer_details['firstname'];
                $autoship_order_data['payment_lastname'] = $customer_details['lastname'];
                $autoship_order_data['payment_company'] = $customer_details['company'];
                $autoship_order_data['payment_address_1'] = $customer_details['address'];
                $autoship_order_data['payment_address_2'] = '';
                $autoship_order_data['payment_city'] = $customer_details['city'];
                $autoship_order_data['payment_postcode'] = $customer_details['postcode'];

                $autoship_order_data['payment_zone_id'] = $customer_details['zone_id'];
                $zone_details = $this->model_register_user->getZoneDetails($customer_details['zone_id']);
                $autoship_order_data['payment_zone'] = $zone_details['zone'];

                $autoship_order_data['payment_country_id'] = $customer_details['country_id'];
                $country_details = $this->model_register_user->getCountryDetails($customer_details['country_id']);
                $autoship_order_data['payment_country'] = $country_details['country'];
                $autoship_order_data['payment_address_format'] = $country_details['address_format'];
                $autoship_order_data['payment_custom_field'] = array();

                $payment_methods = $this->model_register_user->getPaymentMethods('pp_pro');
                $autoship_order_data['payment_method'] = $payment_methods['pp_pro']['title'];
                $autoship_order_data['payment_code'] = $payment_methods['pp_pro']['code'];

                $autoship_order_data['shipping_firstname'] = $customer_details['firstname'];
                $autoship_order_data['shipping_lastname'] = $customer_details['lastname'];
                $autoship_order_data['shipping_company'] = '';
                $autoship_order_data['shipping_address_1'] = $customer_details['ship_address'];
                $autoship_order_data['shipping_address_2'] = '';
                $autoship_order_data['shipping_city'] = $customer_details['ship_city'];
                $autoship_order_data['shipping_postcode'] = $customer_details['ship_postcode'];

                $autoship_order_data['shipping_zone_id'] = $customer_details['ship_zone_id'];
                $shipzone_details = $this->model_register_user->getZoneDetails($customer_details['ship_zone_id']);
                $autoship_order_data['shipping_zone'] = $shipzone_details['zone'];

                $autoship_order_data['shipping_country_id'] = $customer_details['ship_country_id'];
                $shipcountry_details = $this->model_register_user->getCountryDetails($customer_details['ship_country_id']);
                $autoship_order_data['shipping_country'] = $country_details['country'];

                $autoship_order_data['shipping_address_format'] = $shipcountry_details['address_format'];
                $autoship_order_data['shipping_custom_field'] = array();

                $shipping_methods = $this->model_register_user->getShippingMethods('flat', $shipping_address);
                $autoship_order_data['shipping_method'] = $shipping_methods['flat']['title'];
                $autoship_order_data['shipping_code'] = $shipping_methods['flat']['quote']['flat']['code'];

                $autoship_order_data['autoship_quantity'] = $quantity;
                $autoship_order_data['autoship_day'] = '';
                $autoship_order_data['shipping'] = 'flat.flat';

                $autoship_order_data['totals'] = array();
                $total = 0;
                $taxes = $this->cart->getTaxes();

                $this->load->model('extension/extension');

                $sort_order = array();

                $results = $this->model_extension_extension->getExtensions('total');

                foreach ($results as $key => $value) {
                    $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
                }

                array_multisort($sort_order, SORT_ASC, $results);

                foreach ($results as $result) {
                    if ($this->config->get($result['code'] . '_status')) {
                        $this->load->model('total/' . $result['code']);

                        $this->{'model_total_' . $result['code']}->getTotal($autoship_order_data['totals'], $total, $taxes);
                    }
                }

                $sort_order = array();

                foreach ($autoship_order_data['totals'] as $key => $value) {
                    $sort_order[$key] = $value['sort_order'];
                }

                array_multisort($sort_order, SORT_ASC, $autoship_order_data['totals']);

                $this->load->language('checkout/checkout');

                $autoship_order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
                $autoship_order_data['store_id'] = $this->config->get('config_store_id');
                $autoship_order_data['store_name'] = $this->config->get('config_name');

                if ($autoship_order_data['store_id']) {
                    $autoship_order_data['store_url'] = $this->config->get('config_url');
                } else {
                    $autoship_order_data['store_url'] = HTTP_SERVER;
                }

                $autoship_order_data['products'] = array();

                foreach ($this->cart->getProducts() as $product) {
                    $option_data = array();
                    $autoship_order_data['products'][] = array(
                        'product_id' => $product['product_id'],
                        'name' => $product['name'],
                        'model' => $product['model'],
                        'option' => $option_data,
                        'download' => $product['download'],
                        'quantity' => $product['quantity'],
                        'autoship_day' => $autoship_order_data['autoship_day'],
                        'shipping_method' => $autoship_order_data['shipping'],
                        'subtract' => $product['subtract'],
                        'price' => $product['price'],
                        'price_excluding_tax' => $product['price_excluding_tax'],
                        'distributor_price' => $product['distributor_price'],
                        'product_pv' => $product['product_pv'],
                        'customer_pv' => $product['customer_pv'],
                        'product_type' => $product['product_type'],
                        'total' => $product['total'],
                        'tax' => $this->tax->getTax($product['price'], $product['tax_class_id']),
                        'reward' => $product['reward'],
                        'autoship_status' => 'yes'
                    );
                }

                $autoship_order_data['vouchers'] = array();
                $autoship_order_data['comment'] = '';
                $autoship_order_data['total'] = $total;
                $autoship_order_data['affiliate_id'] = 0;
                $autoship_order_data['commission'] = 0;
                $autoship_order_data['marketing_id'] = 0;
                $autoship_order_data['tracking'] = '';
                $autoship_order_data['language_id'] = $this->config->get('config_language_id');
                $autoship_order_data['currency_id'] = $this->currency->getId();
                $autoship_order_data['currency_code'] = $this->currency->getCode();
                $autoship_order_data['currency_value'] = $this->currency->getValue($this->currency->getCode());
                $autoship_order_data['ip'] = $this->request->server['REMOTE_ADDR'];

                if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
                    $autoship_order_data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
                } elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
                    $autoship_order_data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
                } else {
                    $autoship_order_data['forwarded_ip'] = '';
                }

                if (isset($this->request->server['HTTP_USER_AGENT'])) {
                    $autoship_order_data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
                } else {
                    $autoship_order_data['user_agent'] = '';
                }

                if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
                    $autoship_order_data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
                } else {
                    $autoship_order_data['accept_language'] = '';
                }

                $this->load->model('checkout/order');

                $order_id = $this->model_checkout_order->addOrder($autoship_order_data);

                //PP PRO Payment
                if (!$this->config->get('pp_pro_transaction')) {
                    $payment_type = 'Authorization';
                } else {
                    $payment_type = 'Sale';
                }

                $order_info = $this->model_checkout_order->getOrder($order_id);
                //$total_amount = $this->cart->getTotal();
                $total_amount = $order_info['total'];


                $request = 'METHOD=DoDirectPayment';
                $request .= '&VERSION=51.0';
                $request .= '&USER=' . urlencode($this->config->get('pp_pro_username'));
                $request .= '&PWD=' . urlencode($this->config->get('pp_pro_password'));
                $request .= '&SIGNATURE=' . urlencode($this->config->get('pp_pro_signature'));
                $request .= '&CUSTREF=' . (int) $order_info['order_id'];
                $request .= '&PAYMENTACTION=' . $payment_type;
                $request .= '&AMT=' . $this->currency->format($total_amount, $order_info['currency_code'], false, false);
                $request .= '&CREDITCARDTYPE=' . $autoship_order_data_post['cc_type'];
                $request .= '&ACCT=' . urlencode(str_replace(' ', '', $autoship_order_data_post['cc_number']));

                $request .= '&EXPDATE=' . urlencode($autoship_order_data_post['cc_expire_date_month'] . $autoship_order_data_post['cc_expire_date_year']);
                $request .= '&CVV2=' . urlencode($autoship_order_data_post['cc_cvv2']);

                if ($autoship_order_data_post['cc_type'] == 'SWITCH' || $autoship_order_data_post['cc_type'] == 'SOLO') {
                    $request .= '&ISSUENUMBER=' . urlencode($autoship_order_data_post['cc_issue']);
                }
                $request .= '&FIRSTNAME=' . urlencode($autoship_order_data_post['cc_firstname']);
                $request .= '&LASTNAME=' . urlencode($autoship_order_data_post['cc_lastname']);
                $request .= '&EMAIL=' . urlencode($order_info['email']);
                $request .= '&PHONENUM=' . urlencode($order_info['telephone']);
                $request .= '&IPADDRESS=' . urlencode($this->request->server['REMOTE_ADDR']);
                $request .= '&STREET=' . urlencode($order_info['payment_address_1']);
                $request .= '&CITY=' . urlencode($order_info['payment_city']);
                $request .= '&STATE=' . urlencode(($order_info['payment_iso_code_2'] != 'US') ? $order_info['payment_zone'] : $order_info['payment_zone_code']);
                $request .= '&ZIP=' . urlencode($order_info['payment_postcode']);
                $request .= '&COUNTRYCODE=' . urlencode($order_info['payment_iso_code_2']);
                $request .= '&CURRENCYCODE=' . urlencode($order_info['currency_code']);
                $request .= '&BUTTONSOURCE=' . urlencode('OpenCart_2.0_WPP');


                $request .= '&SHIPTONAME=' . urlencode($order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname']);
                $request .= '&SHIPTOSTREET=' . urlencode($order_info['shipping_address_1']);
                $request .= '&SHIPTOCITY=' . urlencode($order_info['shipping_city']);
                $request .= '&SHIPTOSTATE=' . urlencode(($order_info['shipping_iso_code_2'] != 'US') ? $order_info['shipping_zone'] : $order_info['shipping_zone_code']);
                $request .= '&SHIPTOCOUNTRYCODE=' . urlencode($order_info['shipping_iso_code_2']);
                $request .= '&SHIPTOZIP=' . urlencode($order_info['shipping_postcode']);

                $pp_pro_history_id = $this->model_register_user->insertPP_PROHistory($request, $order_id, $customer_id, 'upgrade_customer');

                if (!$this->config->get('pp_pro_test')) {
                    $curl = curl_init('https://api-3t.paypal.com/nvp');
                } else {
                    $curl = curl_init('https://api-3t.sandbox.paypal.com/nvp');
                }

                curl_setopt($curl, CURLOPT_PORT, 443);
                curl_setopt($curl, CURLOPT_HEADER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
                curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $request);

                $response = curl_exec($curl);

                curl_close($curl);


                if (!$response) {
                    $this->log->write('DoDirectPayment failed: ' . curl_error($curl) . '(' . curl_errno($curl) . ')');
                }

                $response_info = array();

                parse_str($response, $response_info);

                $this->model_register_user->updatePP_PROHistory($pp_pro_history_id, $response_info, $order_id, $customer_id);

                if (($response_info['ACK'] == 'Success') || ($response_info['ACK'] == 'SuccessWithWarning')) {
                    $message = '';

                    if (isset($response_info['AVSCODE'])) {
                        $message .= 'AVSCODE: ' . $response_info['AVSCODE'] . "\n";
                    }

                    if (isset($response_info['CVV2MATCH'])) {
                        $message .= 'CVV2MATCH: ' . $response_info['CVV2MATCH'] . "\n";
                    }

                    if (isset($response_info['TRANSACTIONID'])) {
                        $message .= 'TRANSACTIONID: ' . $response_info['TRANSACTIONID'] . "\n";
                    }

                    $this->load->model('checkout/order');
                    $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('pp_pro_order_status_id'), $message, false);
                }

                $this->cart->clear();
                echo $order_id;
                exit();
            } else {
                echo 'Invalid Product/Quantity';
                exit();
            }
        }
    }

}
