<?php

class ControllerRegisterUser extends Controller {

    public function index() {
        $this->document->addScript('catalog/view/javascript/momentjs/moment.js');
        $this->document->addScript('catalog/view/javascript/combodate/combodate.js');
        $this->document->addScript('catalog/view/javascript/misc.js');

        if (!$this->cart->getProductsCount('registration')) {
            $this->response->redirect($this->url->link('register/packages', '', true));
        }

        $this->load->language('register/user');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('account/inf_register');
        $user_type = $this->customer->getUserType();
        if ($user_type != 'admin' && $this->model_account_inf_register->isRegistrationBlocked()) {
            $this->session->data['error_redirect'] = $this->language->get('error_registration_blocked');
            $this->response->redirect($this->url->link('common/home', '', true));
        }
        if (!$this->model_account_inf_register->isRegistrationAllowed()) {
            $this->session->data['error_redirect'] = $this->language->get('registration_not_allowed');
            $this->response->redirect($this->url->link('common/home', '', true));
        }
        
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_account'),
            'href' => $this->url->link('account/account', '', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_register'),
            'href' => $this->url->link('account/register', '', true)
        );

        $data['heading_title'] = $this->language->get('heading_title');
        $data['is_logged'] = $this->customer->isLogged();
        $data['shipping_required'] = $this->cart->hasShipping();

        $data['text_account_already'] = sprintf($this->language->get('text_account_already'), $this->url->link('account/login', '', true));
        $data['text_step1'] = sprintf($this->language->get('text_step1'), 1);
        $data['text_step2'] = sprintf($this->language->get('text_step2'), 2);
        $data['text_step3'] = sprintf($this->language->get('text_step3'), 3);
        $data['text_step4'] = sprintf($this->language->get('text_step4'), 4);
        if ($data['shipping_required']) {
            $data['text_step5'] = sprintf($this->language->get('text_step5'), 5);
            $data['text_step6'] = sprintf($this->language->get('text_step6'), 6);
            $data['text_step7'] = sprintf($this->language->get('text_step7'), 7);
            $data['text_step8'] = sprintf($this->language->get('text_step8'), 8);
        } else {
            $data['text_step7'] = sprintf($this->language->get('text_step7'), 5);
            $data['text_step8'] = sprintf($this->language->get('text_step8'), 6);
        }
        $data['text_denotes_required_field'] = $this->language->get('text_denotes_required_field');

        $data['text_wait'] = $this->language->get('text_wait');
        $data['text_loading'] = $this->language->get('text_loading');

        if (isset($this->session->data['error'])) {
            $data['error_warning'] = $this->session->data['error'];
            unset($this->session->data['error']);
        } else {
            $data['error_warning'] = '';
        }

        $data['BLOCK_ECOMMERCE'] = BLOCK_ECOMMERCE;
        $data['BLOCK_REGISTER'] = BLOCK_REGISTER;

        $load_step = '1';
        if (isset($this->request->get['step'])) {
            $load_step = ((int) $this->request->get['step'] > 0) ? (int) $this->request->get['step'] : 1;
            if ($data['shipping_required']) {
                $load_step = ($load_step <= 8) ? $load_step : 8;
            } else {
                $load_step = ($load_step <= 6) ? $load_step : 6;
            }
        }
        if ($load_step > 1) {
            for ($step = $load_step - 1; $step > 1; $step--) {
                if (!isset($this->session->data['inf_reg_data']['step' . $step])) {
                    $load_step = ($step - 1 > 0) ? $step - 1 : 1;
                    break;
                }
            }
        }

        $data['text_load_step'] = sprintf($this->language->get('text_step' . $load_step), $load_step);
        $data['load_step'] = $load_step;

        if (isset($this->session->data['inf_logged_in']['user_name'])) {
            $data['sponsorname'] = $this->customer->getUserName();
            $data['user_type'] = $this->customer->getUserType();
        } else {
            $data['sponsorname'] = "";
            $data['user_type'] = "admin";
        }

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');
        
        $this->response->setOutput($this->load->view('register/user', $data));

    }

    public function country() {
        $json = array();

        $this->load->model('localisation/country');

        $country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

        if ($country_info) {
            $this->load->model('localisation/zone');

            $json = array(
                'country_id' => $country_info['country_id'],
                'name' => $country_info['name'],
                'iso_code_2' => $country_info['iso_code_2'],
                'iso_code_3' => $country_info['iso_code_3'],
                'address_format' => $country_info['address_format'],
                'postcode_required' => $country_info['postcode_required'],
                'zone' => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
                'status' => $country_info['status']
            );
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function get_available_leg()
    {
        $this->load->model('account/inf_register');
        $user_name = $this->request->get['user_name'];
        $user_id = $this->customer->userNameToId($user_name);
        $response = $this->model_account_inf_register->getAllowedBinaryLeg($user_id, $this->customer->getUserType(), $this->customer->getUserId());
        echo $response;
        exit();
    }

    public function customfield() {
        $json = array();

        $this->load->model('account/custom_field');

        // Customer Group
        if (isset($this->request->get['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->get['customer_group_id'], $this->config->get('config_customer_group_display'))) {
            $customer_group_id = $this->request->get['customer_group_id'];
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }

        $custom_fields = $this->model_account_custom_field->getCustomFields($customer_group_id);

        foreach ($custom_fields as $custom_field) {
            $json[] = array(
                'custom_field_id' => $custom_field['custom_field_id'],
                'required' => $custom_field['required']
            );
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function cart_register() {

        $this->load->language('checkout/cart');
        $this->load->language('bossthemes/boss_add');


        $json = array();

        if (isset($this->request->post['product_id'])) {
            $product_id = (int) $this->request->post['product_id'];
        } else {
            $product_id = 0;
        }

        $this->load->model('catalog/product');

        $product_info = $this->model_catalog_product->getProduct($product_id);

        if ($product_info) {
            if (isset($this->request->post['quantity']) && ((int) $this->request->post['quantity'] >= $product_info['minimum'])) {
                $quantity = (int) $this->request->post['quantity'];
            } else {
                $quantity = 1;
            }

            if (isset($this->request->post['option'])) {
                $option = array_filter($this->request->post['option']);
            } else {
                $option = array();
            }

            $product_options = $this->model_catalog_product->getProductOptions($this->request->post['product_id']);

            foreach ($product_options as $product_option) {
                if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
                    $json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
                }
            }

            if (isset($this->request->post['recurring_id'])) {
                $recurring_id = $this->request->post['recurring_id'];
            } else {
                $recurring_id = 0;
            }

            $recurrings = $this->model_catalog_product->getProfiles($product_info['product_id']);

            if ($recurrings) {
                $recurring_ids = array();

                foreach ($recurrings as $recurring) {
                    $recurring_ids[] = $recurring['recurring_id'];
                }

                if (!in_array($recurring_id, $recurring_ids)) {
                    $json['error']['recurring'] = $this->language->get('error_recurring_required');
                }
            }

            if (!$json) {
                $this->cart->clear();
                $this->cart->add($this->request->post['product_id'], $quantity, $option, $recurring_id);
                $this->session->data['inf_reg_data']['step3']['registration_pack'] = $this->request->post['product_id'];

                $this->load->model('tool/image');
                //$image = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));

                $image = $this->model_tool_image->resize($product_info['image'], 80, 80);

                $json['title'] = $this->language->get('text_title_cart');
                $json['thumb'] = sprintf($this->language->get('text_thumb'), $image);

                $json['success'] = sprintf($this->language->get('text_success_cart'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('checkout/cart'));

                unset($this->session->data['shipping_method']);
                unset($this->session->data['shipping_methods']);
                unset($this->session->data['payment_method']);
                unset($this->session->data['payment_methods']);

                // Totals
                $this->load->model('extension/extension');

                $total_data = array();
                $total = 0;
                $taxes = $this->cart->getTaxes();

                // Display prices
                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                    $sort_order = array();

                    $results = $this->model_extension_extension->getExtensions('total');

                    foreach ($results as $key => $value) {
                        $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
                    }

                    array_multisort($sort_order, SORT_ASC, $results);

                    foreach ($results as $result) {
                        if ($this->config->get($result['code'] . '_status')) {
                            $this->load->model('total/' . $result['code']);

                            $this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
                        }
                    }

                    $sort_order = array();

                    foreach ($total_data as $key => $value) {
                        $sort_order[$key] = $value['sort_order'];
                    }

                    array_multisort($sort_order, SORT_ASC, $total_data);
                }

                $json['total'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total));
            } else {
                $json['redirect'] = str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']));
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

}
