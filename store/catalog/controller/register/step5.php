<?php

class ControllerRegisterStep5 extends Controller {

    public function index() {
        if (!isset($this->session->data['inf_reg_data']['step4'])) {
            $this->response->redirect($this->url->link('register/user', '', true));
        }

        $this->load->language('register/step5');

        $data['text_your_delivery_details'] = $this->language->get('text_your_delivery_details');
        $data['text_same_as'] = $this->language->get('text_same_as');
        $data['text_select'] = $this->language->get('text_select');
        $data['text_none'] = $this->language->get('text_none');
        $data['text_loading'] = $this->language->get('text_loading');
        $data['entry_firstname'] = $this->language->get('entry_firstname');
        $data['entry_lastname'] = $this->language->get('entry_lastname');
        $data['entry_company'] = $this->language->get('entry_company');
        $data['entry_address_1'] = $this->language->get('entry_address_1');
        $data['entry_address_2'] = $this->language->get('entry_address_2');
        $data['entry_postcode'] = $this->language->get('entry_postcode');
        $data['entry_city'] = $this->language->get('entry_city');
        $data['entry_country'] = $this->language->get('entry_country');
        $data['entry_zone'] = $this->language->get('entry_zone');

        $data['button_back'] = $this->language->get('button_back');
        $data['button_continue'] = $this->language->get('button_continue');
        $data['error_digit_only'] = $this->language->get('error_digit_only');
        $data['error_only_char_num_some_specialchars'] = $this->language->get('error_only_char_num_some_specialchars');
        $data['error_only_chars'] = $this->language->get('error_only_chars');
        $data['error_only_chars_num_period_space'] = $this->language->get('error_only_chars_num_period_space');
        $data['error_only_chars_num_period_space_coma'] = $this->language->get('error_only_chars_num_period_space_coma');
        $data['error_invalid_postcode'] = $this->language->get('error_invalid_postcode');

        if (isset($this->session->data['inf_reg_data']['step5']['same_as'])) {
            $data['same_as'] = $this->session->data['inf_reg_data']['step5']['same_as'];
        } else {
            $data['same_as'] = '';
        }
        
        //Autofill Registration Data
        $auto_fill_data = array();
        if (DEMO_STATUS == "yes") {
            $this->load->model('register/user');
            $auto_fill_data = $this->model_register_user->getAutofillDetails();
        }

        if (isset($this->session->data['inf_reg_data']['step5']['firstname'])) {
            $data['firstname'] = $this->session->data['inf_reg_data']['step5']['firstname'];
        } else {
            $data['firstname'] = (DEMO_STATUS == "yes") ? $auto_fill_data['first_name'] : '';
        }

        if (isset($this->session->data['inf_reg_data']['step5']['lastname'])) {
            $data['lastname'] = $this->session->data['inf_reg_data']['step5']['lastname'];
        } else {
            $data['lastname'] = (DEMO_STATUS == "yes") ? $auto_fill_data['last_name'] : '';
        }

        if (isset($this->session->data['inf_reg_data']['step5']['company'])) {
            $data['company'] = $this->session->data['inf_reg_data']['step5']['company'];
        } else {
            $data['company'] = '';
        }
        if (isset($this->session->data['inf_reg_data']['step5']['address_1'])) {
            $data['address_1'] = $this->session->data['inf_reg_data']['step5']['address_1'];
        } else {
            $data['address_1'] = (DEMO_STATUS == "yes") ? $auto_fill_data['address'] : '';
        }

        if (isset($this->session->data['inf_reg_data']['step5']['address_2'])) {
            $data['address_2'] = $this->session->data['inf_reg_data']['step5']['address_2'];
        } else {
            $data['address_2'] = '';
        }

        if (isset($this->session->data['inf_reg_data']['step5']['postcode'])) {
            $data['postcode'] = $this->session->data['inf_reg_data']['step5']['postcode'];
        } elseif (isset($this->session->data['shipping_address']['postcode'])) {
            $data['postcode'] = $this->session->data['shipping_address']['postcode'];
        } else {
            $data['postcode'] = (DEMO_STATUS == "yes") ? $auto_fill_data['zip_code'] : '';
        }

        if (isset($this->session->data['inf_reg_data']['step5']['city'])) {
            $data['city'] = $this->session->data['inf_reg_data']['step5']['city'];
        } else {
            $data['city'] = (DEMO_STATUS == "yes") ? $auto_fill_data['city'] : '';
        }

        if (isset($this->session->data['inf_reg_data']['step5']['ship_country_id'])) {
            $data['ship_country_id'] = $this->session->data['inf_reg_data']['step5']['ship_country_id'];
        } elseif (isset($this->session->data['shipping_address']['country_id'])) {
            $data['ship_country_id'] = $this->session->data['shipping_address']['country_id'];
        } else {
            $data['ship_country_id'] = $this->config->get('config_country_id');
        }

        if (isset($this->session->data['inf_reg_data']['step5']['ship_zone_id'])) {
            $data['ship_zone_id'] = $this->session->data['inf_reg_data']['step5']['ship_zone_id'];
        } elseif (isset($this->session->data['shipping_address']['zone_id'])) {
            $data['ship_zone_id'] = $this->session->data['shipping_address']['zone_id'];
        } else {
            $data['ship_zone_id'] = $this->config->get('config_zone_id');
        }

        // Custom Fields
        $this->load->model('account/custom_field');

        $data['custom_fields'] = $this->model_account_custom_field->getCustomFields();

        if (isset($this->session->data['inf_reg_data']['step4']['custom_field'])) {
            if (isset($this->session->data['inf_reg_data']['step4']['custom_field']['account'])) {
                $account_custom_field = $this->session->data['inf_reg_data']['step4']['custom_field']['account'];
            } else {
                $account_custom_field = array();
            }

            if (isset($this->session->data['inf_reg_data']['step4']['custom_field']['address'])) {
                $address_custom_field = $this->session->data['inf_reg_data']['step4']['custom_field']['address'];
            } else {
                $address_custom_field = array();
            }

            $data['register_custom_field'] = $account_custom_field + $address_custom_field;
        } else {
            $data['register_custom_field'] = array();
        }



        $this->load->model('localisation/country');
        $data['countries'] = $this->model_localisation_country->getCountries();

        $this->response->setOutput($this->load->view('register/step5', $data));
    }

    public function save() {

        $this->load->language('register/step5');

        $this->load->model('register/user');
        
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
        }

        if (!$json) {
            $same_as = '';
            if (isset($this->request->post['same_as'])) {
                $same_as = trim($this->request->post['same_as']);
            }

            if (!$same_as) {
                if ((utf8_strlen(trim($this->request->post['firstname'])) < 3) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
                    $json['error']['firstname'] = $this->language->get('error_firstname');
                }

                if ((utf8_strlen(trim($this->request->post['lastname'])) < 3) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
                    $json['error']['lastname'] = $this->language->get('error_lastname');
                }

                if ((utf8_strlen(trim($this->request->post['address_1'])) < 3) || (utf8_strlen(trim($this->request->post['address_1'])) > 32)) {
                    $json['error']['address_1'] = $this->language->get('error_address_1');
                }

                if ((utf8_strlen(trim($this->request->post['city'])) < 3) || (utf8_strlen(trim($this->request->post['city'])) > 32)) {
                    $json['error']['city'] = $this->language->get('error_city');
                }

                $this->load->model('localisation/country');

                $country_info = $this->model_localisation_country->getCountry($this->request->post['ship_country_id']);

                if ($country_info && $country_info['postcode_required'] && (utf8_strlen(trim($this->request->post['postcode'])) < 3 || utf8_strlen(trim($this->request->post['postcode'])) > 10)) {
                    $json['error']['postcode'] = $this->language->get('error_postcode');
                }

                if ($this->request->post['ship_country_id'] == '') {
                    $json['error']['ship_country_id'] = $this->language->get('error_country');
                }

                if (!isset($this->request->post['ship_zone_id']) || $this->request->post['ship_zone_id'] == '') {
                    $json['error']['ship_zone_id'] = $this->language->get('error_zone');
                }

                // Custom field validation
                $this->load->model('account/custom_field');

                $custom_fields = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));

                foreach ($custom_fields as $custom_field) {
                    if (($custom_field['location'] == 'address') && $custom_field['required'] && empty($this->request->post['custom_field'][$custom_field['custom_field_id']])) {
                        $json['error']['custom_field' . $custom_field['custom_field_id']] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
                    }
                }
            }
        }

        if (!$json) {
            $step5_data = array();
            if ($same_as) {
                $step4_data = $this->session->data['inf_reg_data']['step4'];
                $step5_data['firstname'] = $step4_data['firstname'];
                $step5_data['lastname'] = $step4_data['lastname'];
                $step5_data['company'] = $step4_data['company'];
                $step5_data['address_1'] = $step4_data['address_1'];
                $step5_data['address_2'] = $step4_data['address_2'];
                $step5_data['city'] = $step4_data['city'];
                $step5_data['ship_country_id'] = $step4_data['country_id'];
                $step5_data['ship_zone_id'] = $step4_data['zone_id'];
                $step5_data['postcode'] = $step4_data['postcode'];
                $custom_fields_post = isset($step4_data['custom_field']) ? $step4_data['custom_field'] : '';
            } else {
                $step5_data = $this->request->post;
                if (!isset($step5_data['company'])) {
                $step5_data['company'] = '';
            }
                $custom_fields_post = isset($this->request->post['custom_field']) ? $this->request->post['custom_field'] : '';
            }
            $step5_data['same_as'] = $same_as;

            $country_id = $step5_data['ship_country_id'];
            $country_details = $this->model_register_user->getCountryDetails($country_id);
            $zone_id = $step5_data['ship_zone_id'];
            $zone_details = $this->model_register_user->getZoneDetails($zone_id);

            $address_data = array(
                'address_id' => '',
                'firstname' => $step5_data['firstname'],
                'lastname' => $step5_data['lastname'],
                'company' => $step5_data['company'],
                'address_1' => $step5_data['address_1'],
                'address_2' => $step5_data['address_2'],
                'postcode' => $step5_data['postcode'],
                'city' => $step5_data['city'],
                'zone_id' => $step5_data['ship_zone_id'],
                'zone' => $zone_details['zone'],
                'zone_code' => $zone_details['zone_code'],
                'country_id' => $step5_data['ship_country_id'],
                'country' => $country_details['country'],
                'iso_code_2' => $country_details['iso_code_2'],
                'iso_code_3' => $country_details['iso_code_3'],
                'address_format' => $country_details['address_format'],
                'custom_field' => $custom_fields_post);
            $this->session->data['shipping_address'] = $address_data;

            $this->session->data['inf_reg_data']['step5'] = $step5_data;
        } else {
            $json['error']['warning'] = $this->language->get('error_exists');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

}
