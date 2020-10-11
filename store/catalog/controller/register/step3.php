<?php

class ControllerRegisterStep3 extends Controller {

    public function index() {

        if (!isset($this->session->data['inf_reg_data']['step2'])) {
            $this->response->redirect($this->url->link('register/user', '', true));
        }

        if (!$this->cart->getProductsCount('registration')) {
            $this->response->redirect($this->url->link('register/packages', '', true));
        }

//        $this->document->addScript('catalog/view/javascript/cart_register.js');

        $this->load->language('register/step3');

        $data['text_select_registration_pack'] = $this->language->get('text_select_registration_pack');
        $data['entry_select_a_registration_pack'] = $this->language->get('entry_select_a_registration_pack');

        $data['button_back'] = $this->language->get('button_back');
        $data['button_continue'] = $this->language->get('button_continue');

        $data['registration_pack'] = $this->cart->getRegistrationProduct();


        //Get Registration Packs //       

        $this->load->language('product/category');
        $this->load->language('product/product');

        $data['text_refine'] = $this->language->get('text_refine');
        $data['text_empty'] = $this->language->get('text_empty');
        $data['text_quantity'] = $this->language->get('text_quantity');
        $data['text_manufacturer'] = $this->language->get('text_manufacturer');
        $data['text_model'] = $this->language->get('text_model');
        $data['text_price'] = $this->language->get('text_price');
        $data['text_tax'] = $this->language->get('text_tax');
        $data['text_points'] = $this->language->get('text_points');
        $data['text_added_to_cart'] = $this->language->get('text_added_to_cart');
        $data['text_change_package'] = $this->language->get('text_change_package');
        $data['change_package'] = $this->url->link('register/packages', 'from=reg', true);
        $data['text_product_pv_value'] = (MLM_PLAN == "Binary") ? $this->language->get('text_product_pv_value') : $this->language->get('text_product_bv_value');

        $data['button_cart'] = $this->language->get('button_cart');
        $data['button_continue'] = $this->language->get('button_continue');
        $data['button_list'] = $this->language->get('button_list');
        $data['button_grid'] = $this->language->get('button_grid');
        
        $data['button_cart_added'] = $this->language->get('button_cart_added');
        $data['text_added_to_cart'] = $this->language->get('text_added_to_cart');

        $this->load->model('catalog/category');

        $this->load->model('catalog/product');

        $this->load->model('tool/image');

        $data['products'] = array();
        $product_info = $this->model_catalog_product->getProduct($data['registration_pack']);
        if($product_info) {
            
            if ($product_info['image']) {
                $image = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
            } else {
                $image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
            }

            if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                $price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
            } else {
                $price = false;
            }

            if ((float) $product_info['special']) {
                $special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
            } else {
                $special = false;
            }

            if ($this->config->get('config_tax')) {
                $tax = $this->currency->format((float) $product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
            } else {
                $tax = false;
            }

            if ($this->config->get('config_review_status')) {
                $rating = (int) $product_info['rating'];
            } else {
                $rating = false;
            }

            $data['products'][] = array(
                'product_id' => $product_info['product_id'],
                'thumb' => $image,
                'name' => $product_info['name'],
                'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
                'price' => $price,
                'special' => $special,
                'tax' => $tax,
                'minimum' => $product_info['minimum'] > 0 ? $product_info['minimum'] : 1,
                'rating' => $product_info['rating'],
                'href' => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
                'pair_value' => $product_info['pair_value']
            );
            
        }

        $this->response->setOutput($this->load->view('register/step3', $data));
        
    }

    public function save() {

        $this->load->language('register/step3');

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
        } else {
            $registration_pack = $this->cart->getRegistrationProduct();
            $carted_products = $this->cart->getProducts();
            foreach ($carted_products AS $product) {
                if ($product['product_id'] == $registration_pack && $product['quantity'] > 1) {

                    $json['error']['warning'] = sprintf($this->language->get('error_registration_pack_quantity'),$this->url->link('register/packages', 'action=restart', true));
                 
                }
            }
        }

        if (!$json) {

            $this->session->data['inf_reg_data']['step3']['registration_pack'] = $this->cart->getRegistrationProduct();
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

}
