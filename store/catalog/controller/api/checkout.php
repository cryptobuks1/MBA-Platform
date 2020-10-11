<?php

class ControllerApiCheckout extends Controller {

    public function checkout() {
        $this->load->language('api/checkout');
        $this->load->model('account/api');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $json = array();
        if ($api_info) {
            $json['status'] = TRUE;
            $this->load->model('catalog/product');         
            if (isset($this->request->post['product_id0'])&&isset($this->request->post['count'])) {
                
                for($i=0;$i<$this->request->post['count'];$i++){
                    $json['products'][$i]=$this->model_catalog_product->getProduct($this->request->post['product_id'.$i]);
                }
             
                if(!$json['products']){
                     $json['status']=FALSE;
                }
                
            }
        } else {
            $json['error']['key'] = $this->language->get('error_key');
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
    
    public function confirm() {
    
        $apiproducts = TRUE;
        $this->load->language('api/checkout');
        $this->load->model('account/api');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $json = array();
        if ($api_info) {
            $json['status'] = TRUE;
             if(isset($this->request->post['customer_id'])){
                
             //$customer_id = $this->model_account_customer->userIDToCustomerId($this->request->post['user_id']);
             $customer_id = $this->request->post['customer_id'];
            $this->session->data['customer_id']= $customer_id;
            $this->customer->setId($customer_id);
            }
            
            if (isset($this->request->post['product_id0'])&&isset($this->request->post['count'])) {                
                for($i=0;$i<$this->request->post['count'];$i++){
                    //$products[$i]=$this->model_catalog_product->getProduct($this->request->post['product_id'.$i]);
                    $products[$i]['product_id']=$this->request->post['product_id'.$i];
                    $products[$i]['product_id']=$this->request->post['product_id'.$i];
                    $products[$i]['quantity']=$this->request->post['qty'.$i];      
                    if(isset($this->request->post['product_option_id'.$i])){
                $a=array($this->request->post['product_option_id'.$i] => $this->request->post['product_option_value_id'.$i]);
                $products[$i]['option'] = json_encode($a);
                    }
                    else{
                        $a=array();
                        $products[$i]['option']=json_encode($a);
                    }
                    $products[$i]['recurring_id'] = 0;
                }                           
            }
          
           
            $this->session->data['apiproducts'] = $products;
            
            $this->load->model('catalog/product');  
            
            $this->session->data['payment_address'] = array(
                'firstname' => $this->request->post['payment_address_firstname'],
                'lastname' => $this->request->post['payment_address_lastname'],
                'company' => $this->request->post['payment_address_company'],
                'address_1' => $this->request->post['payment_address_address_1'],
                'address_2' => $this->request->post['payment_address_address_2'],
                'city' => $this->request->post['payment_address_city'],
                'postcode' => $this->request->post['payment_address_postcode'],
                'zone' => $this->request->post['payment_address_zone'],
                'zone_id' => $this->request->post['payment_address_zone_id'],
                'country' => $this->request->post['payment_address_country'],
                'country_id' => $this->request->post['payment_address_country_id'],
                'address_format' => $this->request->post['payment_address_address_format'],
            );
            if (isset($this->request->post['payment_address_custom_field']))
                $this->session->data['payment_address']['custom_field'] = $this->request->post['payment_address_custom_field'];
            if (isset($this->request->post['payment_method_title'])) {
                $this->session->data['payment_method']['title'] = $this->request->post['payment_method_title'];
            }
            if (isset($this->request->post['payment_method_code'])) {
                $this->session->data['payment_method']['code'] = $this->request->post['payment_method_code'];
            }
            $this->session->data['shipping_address'] = array(
                'firstname' => $this->request->post['shipping_address_firstname'],
                'lastname' => $this->request->post['shipping_address_lastname'],
                'company' => $this->request->post['shipping_address_company'],
                'address_1' => $this->request->post['shipping_address_address_1'],
                'address_2' => $this->request->post['shipping_address_address_2'],
                'city' => $this->request->post['shipping_address_city'],
                'postcode' => $this->request->post['shipping_address_postcode'],
                'zone' => $this->request->post['shipping_address_zone'],
                'zone_id' => $this->request->post['shipping_address_zone_id'],
                'country' => $this->request->post['shipping_address_country'],
                'country_id' => $this->request->post['shipping_address_country_id'],
                'address_format' => $this->request->post['shipping_address_address_format'],
            );
            if (isset($this->request->post['shipping_address_custom_field']))
                $this->session->data['shipping_address']['custom_field'] = $this->request->post['shipping_address_custom_field'];
            //$this->session->data['shipping_method'] =array();


            $this->session->data['shipping_method'] = 'flat.flat';
            // $this->session->data['shipping_method'] = $this->session->data['comment'] = $this->request->post['comment'];
            $this->session->data['currency'] = $this->request->post['currency'];

            if (isset($this->session->data['shipping_address'])) {
                // Shipping Methods
                $method_data = array();

                $this->load->model('extension/extension');

                $results = $this->model_extension_extension->getExtensions('shipping');

                foreach ($results as $result) {
                    if ($this->config->get($result['code'] . '_status')) {
                        $this->load->model('extension/shipping/' . $result['code']);

                        $quote = $this->{'model_extension_shipping_' . $result['code']}->getQuote($this->session->data['shipping_address']);

                        if ($quote) {
                            $method_data[$result['code']] = array(
                                'title' => $quote['title'],
                                'quote' => $quote['quote'],
                                'sort_order' => $quote['sort_order'],
                                'error' => $quote['error']
                            );
                        }
                    }
                }

                $sort_order = array();

                foreach ($method_data as $key => $value) {
                    $sort_order[$key] = $value['sort_order'];
                }

                array_multisort($sort_order, SORT_ASC, $method_data);

                $this->session->data['shipping_methods'] = $method_data;
            }
            $warning = 0;
            if (!isset($this->session->data['shipping_method'])) {
                $warning = $this->language->get('error_shipping');
            } else {
                $shipping = explode('.', $this->session->data['shipping_method']);

                if (!isset($shipping[0]) || !isset($shipping[1]) || !isset($this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]])) {
                    $warning = $this->language->get('error_shipping');
                }
            }

            if (!$warning) {
                $this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];

                $this->session->data['comment'] = strip_tags($this->request->post['comment']);
            }




            
            
            
            
            
           
            $order_data = array();

            $totals = array();
            $taxes = $this->cart->getTaxes();
            $total = 0;
            $total_bv = 0;

            // Because __call can not keep var references so we put them into an array.
            $total_data = array(
                'totals' => &$totals,
                'taxes' => &$taxes,
                'total' => &$total,
                'total_bv' => &$total_bv
            );
            $this->load->model('extension/extension');

            $sort_order = array();

            $results = $this->model_extension_extension->getExtensions('total');

            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
            }

            array_multisort($sort_order, SORT_ASC, $results);
//print_r($results);die;
            foreach ($results as $result) { 
                if ($this->config->get($result['code'] . '_status')) {
                    if($this->request->post['payment_method_code'] == 'store_pick_up' && $result['code'] == 'shipping'){
                        continue;
                    }
                    $this->load->model('extension/total/' . $result['code']);

                    // We have to put the totals in an array so that they pass by reference.
                    $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                }
            }
//print_r($total_data);die;
            $sort_order = array();

            foreach ($totals as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $totals);
            $order_data['totals'] = $totals;
            //print_r($total_data);die;
            $this->load->language('checkout/checkout');

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

            if (isset($this->customer->request->post['customer_id'])) {
                $this->load->model('account/customer');

                $customer_info = $this->model_account_customer->getCustomer($this->customer->request->post['customer_id']);

                $order_data['customer_id'] = $this->customer->request->post['customer_id'];
                $order_data['customer_group_id'] = $customer_info['customer_group_id'];
                $order_data['firstname'] = $customer_info['firstname'];
                $order_data['lastname'] = $customer_info['lastname'];
                $order_data['email'] = $customer_info['email'];
                $order_data['telephone'] = $customer_info['telephone'];
                $order_data['fax'] = $customer_info['fax'];
                $order_data['custom_field'] = json_decode($customer_info['custom_field'], true);
            }

            $order_data['payment_firstname'] = $this->request->post['payment_address_firstname'];
            $order_data['payment_lastname'] = $this->request->post['payment_address_lastname'];
            $order_data['payment_company'] = $this->request->post['payment_address_company'];
            $order_data['payment_address_1'] = $this->request->post['payment_address_address_1'];
            $order_data['payment_address_2'] = $this->request->post['payment_address_address_2'];
            $order_data['payment_city'] = $this->request->post['payment_address_city'];
            $order_data['payment_postcode'] = $this->request->post['payment_address_postcode'];
            $order_data['payment_zone'] = $this->request->post['payment_address_zone'];
            $order_data['payment_zone_id'] = $this->request->post['payment_address_zone_id'];
            $order_data['payment_country'] = $this->request->post['payment_address_country'];
            $order_data['payment_country_id'] = $this->request->post['payment_address_country_id'];
            $order_data['payment_address_format'] = $this->request->post['payment_address_address_format'];
            $order_data['payment_custom_field'] = (isset($this->request->post['payment_address_custom_field']) ? $this->request->post['payment_address_custom_field'] : array());

            if (isset($this->request->post['payment_method_title'])) {
                $order_data['payment_method'] = $this->request->post['payment_method_title'];
            } else {
                $order_data['payment_method'] = '';
            }

            if (isset($this->request->post['payment_method_code'])) {
                $order_data['payment_code'] = $this->request->post['payment_method_code'];
            } else {
                $order_data['payment_code'] = '';
            }

            if ($this->cart->hasShipping()) {
                $order_data['shipping_firstname'] = $this->request->post['shipping_address_firstname'];
                $order_data['shipping_lastname'] = $this->request->post['shipping_address_lastname'];
                $order_data['shipping_company'] = $this->request->post['shipping_address_company'];
                $order_data['shipping_address_1'] = $this->request->post['shipping_address_address_1'];
                $order_data['shipping_address_2'] = $this->request->post['shipping_address_address_2'];
                $order_data['shipping_city'] = $this->request->post['shipping_address_city'];
                $order_data['shipping_postcode'] = $this->request->post['shipping_address_postcode'];
                $order_data['shipping_zone'] = $this->request->post['shipping_address_zone'];
                $order_data['shipping_zone_id'] = $this->request->post['shipping_address_zone_id'];
                $order_data['shipping_country'] = $this->request->post['shipping_address_country'];
                $order_data['shipping_country_id'] = $this->request->post['shipping_address_country_id'];
                $order_data['shipping_address_format'] = $this->request->post['shipping_address_address_format'];
                $order_data['shipping_custom_field'] = (isset($this->request->post['shipping_address_custom_field']) ? $this->request->post['shipping_address_custom_field'] : array());

                if (isset($this->request->post['shipping_method_title'])) {
                    $order_data['shipping_method'] = $this->request->post['shipping_method_title'];
                } else {
                    $order_data['shipping_method'] = '';
                }

                if (isset($this->request->post['shipping_method_code'])) {
                    $order_data['shipping_code'] = $this->request->post['shipping_method_code'];
                } else {
                    $order_data['shipping_code'] = '';
                }
            } else {
                $order_data['shipping_firstname'] = '';
                $order_data['shipping_lastname'] = '';
                $order_data['shipping_company'] = '';
                $order_data['shipping_address_1'] = '';
                $order_data['shipping_address_2'] = '';
                $order_data['shipping_city'] = '';
                $order_data['shipping_postcode'] = '';
                $order_data['shipping_zone'] = '';
                $order_data['shipping_zone_id'] = '';
                $order_data['shipping_country'] = '';
                $order_data['shipping_country_id'] = '';
                $order_data['shipping_address_format'] = '';
                $order_data['shipping_custom_field'] = array();
                $order_data['shipping_method'] = '';
                $order_data['shipping_code'] = '';
            }

            $order_data['products'] = array();
$this->load->model('account/customer');
$customerdetails = $this->model_account_customer->getCustomer($this->request->post['customer_id']);
            foreach ($this->cart->getProducts() as $product) {
                //print_r($product);die;
                $retail_amount = 0;
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
                //code add for retail profit
                
                    $this->load->model('account/customer');
                    $retail_profit = array();
                    $retail_profit['user_type'] =$customerdetails['customer_type'];
                    if ($retail_profit['user_type'] == "privileged") {
                        $retail_profit['customer_id'] = $this->model_account_customer->userIDToCustomerId($this->model_account_customer->getPrivilegeSponsorID($this->request->post['customer_id']));
                        $retail_profit['percentage'] = $product['mlm_retail_privilege']; //10%
                        $orderdetails['benificiary_id'] = $this->model_account_customer->userIDToCustomerId($this->model_account_customer->getPrivilegeSponsorID($this->request->post['customer_id']));
                        $orderdetails['order_type'] = "normal";
                    } elseif ($retail_profit['user_type'] == "distributor" || $retail_profit['user_type'] == "phygistore" || $retail_profit['user_type'] == "admin") {
                        $retail_profit['customer_id'] = $this->customer->getId();
                        $retail_profit['percentage'] = $product['mlm_marketting_affiliate'];
                        $orderdetails['benificiary_id'] = $this->customer->getId();
                        $orderdetails['order_type'] = "normal";
                    }

                    $retail_amount = $retail_amount + ( $product['quantity'] * $retail_profit['percentage'] );
                    $nrv = $product['quantity'] * $retail_profit['percentage'];
                    $order_status = 'pending';
                    $order_data['order_status'] = $order_status;
                    $order_data['order_type'] = $orderdetails['order_type'];
                    $order_data['benificiary_id'] = $orderdetails['benificiary_id'];
                    $retail_profit_user = $retail_profit['customer_id'];
                    $retail_profit_user_type = $retail_profit['user_type'];
                
                //code add for retail profit
                $order_data['products'][] = array(
                    'product_id' => $product['product_id'],
                    'name' => $product['name'],
                    'model' => $product['model'],
                    'option' => $option_data,
                    'download' => $product['download'],
                    'quantity' => $product['quantity'],
                    'subtract' => $product['subtract'],
                    'price' => $product['price'],
                    'total' => $product['total'],
                    'nrv' => $nrv,
                    'product_bv' => $product['mlm_total_bv'],
                    'order_status' => 6,
                    'retail_profit_user' => $retail_profit_user,
                    'retail_profit_user_type' => $retail_profit_user_type,
                    'tax' => $this->tax->getTax($product['price'], $product['tax_class_id'],$product['product_id']),
                    'reward' => $product['reward'],
                    'cgst_tax' => $this->tax->getGstRate($product['price'],88,$product['product_id'],$product['quantity']),
                    'sgst_tax' => $this->tax->getGstRate($product['price'],89,$product['product_id'],$product['quantity'])
                );
            }
 
            // Gift Voucher
            $order_data['vouchers'] = array();

            if (!empty($this->session->data['vouchers'])) {
                foreach ($this->session->data['vouchers'] as $voucher) {
                    $order_data['vouchers'][] = array(
                        'description' => $voucher['description'],
                        'code' => token(10),
                        'to_name' => $voucher['to_name'],
                        'to_email' => $voucher['to_email'],
                        'from_name' => $voucher['from_name'],
                        'from_email' => $voucher['from_email'],
                        'voucher_theme_id' => $voucher['voucher_theme_id'],
                        'message' => $voucher['message'],
                        'amount' => $voucher['amount']
                    );
                }
            }

            $order_data['comment'] = $this->request->post['comment'];
            $order_data['total'] = $total_data['total'];
            $order_data['total_bv'] = $total_data['total_bv'];
            $this->load->model('checkout/order');
            $bv_confif = $this->model_checkout_order->getBvConfig();
            $order_data['bv_converter'] = $bv_confif['product_bv'];
            //print_r($bv_confif['product_bv']);die;
            //print_r($order_data);die;
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
            $order_data['currency_id'] = $this->currency->getId($this->request->post['currency']);
            $order_data['currency_code'] = $this->request->post['currency'];
            $order_data['currency_value'] = $this->currency->getValue($this->request->post['currency']);
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
            
            $order_code = $this->model_checkout_order->GetOrderCode();
               $order_data['order_code'] = $order_code;

            $json['order_id'] = $this->session->data['order_id'] = $this->model_checkout_order->addOrder($order_data);

            $data['text_recurring_item'] = $this->language->get('text_recurring_item');
            $data['text_payment_recurring'] = $this->language->get('text_payment_recurring');

            $data['column_name'] = $this->language->get('column_name');
            $data['column_model'] = $this->language->get('column_model');
            $data['column_quantity'] = $this->language->get('column_quantity');
            $data['column_price'] = $this->language->get('column_price');
            $data['column_total'] = $this->language->get('column_total');
			$json['column_name'] = $data['column_name'] = $this->language->get('column_name');
			$json['column_model'] = $data['column_model'] = $this->language->get('column_model');
			$json['column_quantity'] = $data['column_quantity'] = $this->language->get('column_quantity');
			$json['column_price'] = $data['column_price'] = $this->language->get('column_price');
			$json['column_bv'] = $data['column_bv'] = $this->language->get('product_bv');
			$json['column_total'] = $data['column_total'] = $this->language->get('column_total');

            $this->load->model('tool/upload');

            $data['products'] = array();

            foreach ($this->cart->getProducts() as $product) {
                $option_data = array();
                //print_r($product);die;
                foreach ($product['option'] as $option) {
                    if ($option['type'] != 'file') {
                        $value = $option['value'];
                    } else {
                        $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

                        if ($upload_info) {
                            $value = $upload_info['name'];
                        } else {
                            $value = '';
                        }
                    }

                    $option_data[] = array(
                        'name' => $option['name'],
                        'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
                    );
                }

                $recurring = '';

                if ($product['recurring']) {
                    $frequencies = array(
                        'day' => $this->language->get('text_day'),
                        'week' => $this->language->get('text_week'),
                        'semi_month' => $this->language->get('text_semi_month'),
                        'month' => $this->language->get('text_month'),
                        'year' => $this->language->get('text_year'),
                    );

                    if ($product['recurring']['trial']) {
                        $recurring = sprintf($this->language->get('text_trial_description'), $this->currency->format($this->tax->calculate($product['recurring']['trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax'),$product['product_id']), $this->request->post['currency']), $product['recurring']['trial_cycle'], $frequencies[$product['recurring']['trial_frequency']], $product['recurring']['trial_duration']) . ' ';
                    }

                    if ($product['recurring']['duration']) {
                        $recurring .= sprintf($this->language->get('text_payment_description'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax'),$product['product_id']), $this->request->post['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
                    } else {
                        $recurring .= sprintf($this->language->get('text_payment_cancel'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax'),$product['product_id']), $this->request->post['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
                    }
                }

                $json['products'][] = $data['products'][] = array(
                   // 'cart_id' => $product['cart_id'],
                    'product_id' => $product['product_id'],
                    'name' => $product['name'],
                    'model' => $product['model'],
                    'option' => $option_data,
                    'recurring' => $recurring,
                    'quantity' => $product['quantity'],
                    'subtract' => $product['subtract'],
                    'mlm_total_bv'=>$product['mlm_total_bv'],
                    'price' => $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'),$product['product_id']),
                    'total' => $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'),$product['product_id']) * $product['quantity'],
                    'href' => $this->url->link('product/product', 'product_id=' . $product['product_id']),
                    'cgst_tax' => $this->tax->getGstRate($product['price'],88,$product['product_id'],$product['quantity']),
                    'sgst_tax' => $this->tax->getGstRate($product['price'],89,$product['product_id'],$product['quantity']),
                );
                
            }
	
            // Gift Voucher
            $data['vouchers'] = array();

            if (!empty($this->session->data['vouchers'])) {
                foreach ($this->session->data['vouchers'] as $voucher) {
                    $data['vouchers'][] = array(
                        'description' => $voucher['description'],
                        'amount' => $this->currency->format($voucher['amount'], $this->request->post['currency'])
                    );
                }
            }

            $data['totals'] = array();

           /* foreach ($order_data['totals'] as $total) {
                $json['totals'][] = $data['totals'][] = array(
                    'title' => $total['title'],
                    'text' => $this->currency->format($total['value'], $this->request->post['currency'])
                );
            }*/
            
            foreach ($order_data['totals'] as $total) {
               $js[] = $data['totals'][] = array(
                     $total['title'] => $total['value'],
                );
            }
            foreach( $js as $d){
                $json['totals'][key($d)] = $d[key($d)];
            }
            
            

            $json['payment'] = $data['payment'] = $this->load->controller('extension/payment/' . $this->request->post['payment_method_code']);
            $this->session->data['apiproducts']=NULL;
        } else {
            $json['error']['key'] = $this->language->get('error_key');
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
    
    public function test() {
        $this->load->language('api/checkout');
        $this->load->model('account/api');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $json = array();
        if ($api_info) {
            $json['status'] = TRUE;
         
            $json['payment'] = $data['payment'] = $this->load->controller('extension/payment/cod');
        } else {
            $json['error']['key'] = $this->language->get('error_key');
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
    
    public function getlastorderid() {
        $this->load->language('api/checkout');
        $this->load->model('account/api');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $json = array();
        if ($api_info) {
            $json['status'] = TRUE;
         	$this->load->model('checkout/order');
            $json['orderid'] = $this->model_checkout_order->getlastorderid($this->request->post['customer_id']);
        } else {
            $json['error']['key'] = $this->language->get('error_key');
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

    
}
