<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
class ControllerRegisterStep4 extends Controller {

    public function index() {

        if (!isset($this->session->data['inf_reg_data']['step3'])) {
            $this->response->redirect($this->url->link('register/user', '', true));
        }
        
        $mlm_plan = MLM_PLAN;
        $reg_from_tree = 0;
        $placement_user_name = '';
        $placement_full_name = '';
        $position = '';
        if (isset($this->session->data['placement_array'])) {
            $placement_array = $this->session->data['placement_array'];
            $reg_from_tree = $placement_array['reg_from_tree'];
            $placement_user_name = $placement_array['placement_user_name'];
            $placement_full_name = $placement_array['placement_full_name'];
            $position = $placement_array['position'];
        }
        $data['reg_from_tree'] = $reg_from_tree;
        $data['placement_user_name'] = $placement_user_name;
        $data['placement_full_name'] = $placement_full_name;
        $data['mlm_plan'] = $mlm_plan;
        $data['position'] = $position;
        $data['USERNAME_TYPE'] = USERNAME_TYPE;

        $this->load->language('register/step4');
        $data['text_your_details'] = $this->language->get('text_your_details');
        $data['text_your_address'] = $this->language->get('text_your_address');
        $data['text_your_password'] = $this->language->get('text_your_password');
        $data['text_select'] = $this->language->get('text_select');
        $data['text_none'] = $this->language->get('text_none');
        $data['text_loading'] = $this->language->get('text_loading');

        $data['entry_username'] = $this->language->get('entry_username');
        $data['entry_password'] = $this->language->get('entry_password');
        $data['entry_password_min_six'] = $this->language->get('entry_password_min_six');
        $data['entry_confirm'] = $this->language->get('entry_confirm');
        $data['entry_customer_group'] = $this->language->get('entry_customer_group');
        $data['entry_firstname'] = $this->language->get('entry_firstname');
        $data['entry_lastname'] = $this->language->get('entry_lastname');
        $data['entry_dob'] = $this->language->get('entry_dob');
        $data['entry_year'] = $this->language->get('entry_year');
        $data['entry_month'] = $this->language->get('entry_month');
        $data['entry_day'] = $this->language->get('entry_day');
        $data['entry_gender'] = $this->language->get('entry_gender');
        $data['entry_select_gender'] = $this->language->get('entry_select_gender');
        $data['entry_male'] = $this->language->get('entry_male');
        $data['entry_female'] = $this->language->get('entry_female');
        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_telephone'] = $this->language->get('entry_telephone');
        $data['entry_fax'] = $this->language->get('entry_fax');
        $data['entry_company'] = $this->language->get('entry_company');
        $data['entry_address_1'] = $this->language->get('entry_address_1');
        $data['entry_address_2'] = $this->language->get('entry_address_2');
        $data['entry_postcode'] = $this->language->get('entry_postcode');
        $data['entry_city'] = $this->language->get('entry_city');
        $data['entry_country'] = $this->language->get('entry_country');
        $data['entry_zone'] = $this->language->get('entry_zone');

        $data['button_continue'] = $this->language->get('button_continue');
        $data['button_upload'] = $this->language->get('button_upload');
        $data['button_back'] = $this->language->get('button_back');

        //AJAX Validation
        $data['user_name_type'] = USERNAME_TYPE;
        $data['load_image_path'] = OFFICE_PATH . "public_html/";
        $data['text_checking_username_availability'] = $this->language->get('text_checking_username_availability');
        $data['text_username_already_exists'] = $this->language->get('text_username_already_exists');
        $data['error_user_name_cannot_be_null'] = $this->language->get('error_user_name_cannot_be_null');
        $data['error_user_name_not_available'] = $this->language->get('error_user_name_not_available');
        $data['space_not_allowed'] = $this->language->get('space_not_allowed');
        $data['text_user_name_available'] = $this->language->get('text_user_name_available');
        $data['error_username_more_than_6_charactors'] = $this->language->get('error_username_more_than_6_charactors');
        $data['error_username_less_than_twelve'] = $this->language->get('error_username_less_than_twelve');
        $data['error_only_alphanumerals'] = $this->language->get('error_only_alphanumerals');
        $data['error_digit_only'] = $this->language->get('error_digit_only');
        $data['error_only_char_num_some_specialchars'] = $this->language->get('error_only_char_num_some_specialchars');
        $data['error_only_chars'] = $this->language->get('error_only_chars');
        $data['error_only_chars_num_period_space'] = $this->language->get('error_only_chars_num_period_space');
        $data['error_only_chars_num_period_space_coma'] = $this->language->get('error_only_chars_num_period_space_coma');
        $data['error_password_mismatch'] = $this->language->get('error_password_mismatch');
        $data['error_mail_format'] = $this->language->get('error_mail_format');
        $data['error_only_chars_num_period_at'] = $this->language->get('error_only_chars_num_period_at');
        $data['error_invalid_postcode'] = $this->language->get('error_invalid_postcode');
        $data['error_invalid_phone'] = $this->language->get('error_invalid_phone');

        $data['customer_groups'] = array();

        if (is_array($this->config->get('config_customer_group_display'))) {
            $this->load->model('account/customer_group');

            $customer_groups = $this->model_account_customer_group->getCustomerGroups();

            foreach ($customer_groups as $customer_group) {
                if (in_array($customer_group['customer_group_id'], $this->config->get('config_customer_group_display'))) {
                    $data['customer_groups'][] = $customer_group;
                }
            }
        }

        //Autofill Registration Data
        $auto_fill_data = array();
        if (DEMO_STATUS == "yes") {
            $this->load->model('register/user');
            $auto_fill_data = $this->model_register_user->getAutofillDetails();
        }

        if (isset($this->session->data['inf_reg_data']['step4']['username'])) {
            $data['username'] = $this->session->data['inf_reg_data']['step4']['username'];
        } else {
            if (DEMO_STATUS == "yes") {
                $data['username'] = $auto_fill_data['user_name'];
            } else {
                $data['username'] = '';
            }
        }
        if (isset($this->session->data['inf_reg_data']['step4']['password'])) {
            $data['password'] = $this->session->data['inf_reg_data']['step4']['password'];
        } else {

            $data['password'] = '';
        }

        if (isset($this->session->data['inf_reg_data']['step4']['confirm'])) {
            $data['confirm'] = $this->session->data['inf_reg_data']['step4']['confirm'];
        } else {

            $data['confirm'] = '';
        }
        
        if (isset($this->session->data['inf_reg_data']['step4']['customer_group_id'])) {
            $data['customer_group_id'] = $this->session->data['inf_reg_data']['step4']['customer_group_id'];
        } else {
            $data['customer_group_id'] = $this->config->get('config_customer_group_id');
        }

        if (isset($this->session->data['inf_reg_data']['step4']['firstname'])) {
            $data['firstname'] = $this->session->data['inf_reg_data']['step4']['firstname'];
        } else {
            if (DEMO_STATUS == "yes") {
                $data['firstname'] = $auto_fill_data['first_name'];
            } else {
                $data['firstname'] = '';
            }
        }

        if (isset($this->session->data['inf_reg_data']['step4']['lastname'])) {
            $data['lastname'] = $this->session->data['inf_reg_data']['step4']['lastname'];
        } else {
            if (DEMO_STATUS == "yes") {
                $data['lastname'] = $auto_fill_data['last_name'];
            } else {
                $data['lastname'] = '';
            }
        }

        if (isset($this->session->data['inf_reg_data']['step4']['year'])) {
            $data['year'] = $this->session->data['inf_reg_data']['step4']['year'];
        } else {
            if (DEMO_STATUS == "yes") {
                $data['year'] = $auto_fill_data['year'];
            } else {
                $data['year'] = '';
            }
        }
        if (isset($this->session->data['inf_reg_data']['step4']['month'])) {
            $data['month'] = $this->session->data['inf_reg_data']['step4']['month'];
        } else {
            if (DEMO_STATUS == "yes") {
                $data['month'] = $auto_fill_data['month'];
            } else {
                $data['month'] = '';
            }
        }
        if (isset($this->session->data['inf_reg_data']['step4']['day'])) {
            $data['day'] = $this->session->data['inf_reg_data']['step4']['day'];
        } else {
            if (DEMO_STATUS == "yes") {
                $data['day'] = $auto_fill_data['day'];
            } else {
                $data['day'] = '';
            }
        }
        if (isset($this->session->data['inf_reg_data']['step4']['gender'])) {
            $data['gender'] = $this->session->data['inf_reg_data']['step4']['gender'];
        } else {
            if (DEMO_STATUS == "yes") {
                $data['gender'] = $auto_fill_data['gender'];
            } else {
                $data['gender'] = '';
            }
        }

        if (isset($this->session->data['inf_reg_data']['step4']['email'])) {
            $data['email'] = $this->session->data['inf_reg_data']['step4']['email'];
        } else {
            if (DEMO_STATUS == "yes") {
                $data['email'] = $auto_fill_data['email'];
            } else {
                $data['email'] = '';
            }
        }

        if (isset($this->session->data['inf_reg_data']['step4']['telephone'])) {
            $data['telephone'] = $this->session->data['inf_reg_data']['step4']['telephone'];
        } else {
            if (DEMO_STATUS == "yes") {
                $data['telephone'] = $auto_fill_data['mobile'];
            } else {
                $data['telephone'] = '';
            }
        }

        if (isset($this->session->data['inf_reg_data']['step4']['fax'])) {
            $data['fax'] = $this->session->data['inf_reg_data']['step4']['fax'];
        } else {
            if (DEMO_STATUS == "yes") {
                $data['fax'] = $auto_fill_data['fax'];
            } else {
                $data['fax'] = '';
            }
        }

        if (isset($this->session->data['inf_reg_data']['step4']['company'])) {
            $data['company'] = $this->session->data['inf_reg_data']['step4']['company'];
        } else {
            $data['company'] = '';
        }

        if (isset($this->session->data['inf_reg_data']['step4']['address_1'])) {
            $data['address_1'] = $this->session->data['inf_reg_data']['step4']['address_1'];
        } else {
            if (DEMO_STATUS == "yes") {
                $data['address_1'] = $auto_fill_data['address'];
            } else {
                $data['address_1'] = '';
            }
        }

        if (isset($this->session->data['inf_reg_data']['step4']['address_2'])) {
            $data['address_2'] = $this->session->data['inf_reg_data']['step4']['address_2'];
        } else {
            $data['address_2'] = '';
        }

        if (isset($this->session->data['inf_reg_data']['step4']['postcode'])) {
            $data['postcode'] = $this->session->data['inf_reg_data']['step4']['postcode'];
        } elseif (isset($this->session->data['shipping_address']['postcode'])) {
            $data['postcode'] = $this->session->data['shipping_address']['postcode'];
        } else {
            $data['postcode'] = '';
        }

        if (isset($this->session->data['inf_reg_data']['step4']['city'])) {
            $data['city'] = $this->session->data['inf_reg_data']['step4']['city'];
        } else {
            if (DEMO_STATUS == "yes") {
                $data['city'] = $auto_fill_data['city'];
            } else {
                $data['city'] = '';
            }
        }

        if (isset($this->session->data['inf_reg_data']['step4']['country_id'])) {
            $data['country_id'] = $this->session->data['inf_reg_data']['step4']['country_id'];
        } else {
            $data['country_id'] = $this->config->get('config_country_id');
        }

        if (isset($this->session->data['inf_reg_data']['step4']['zone_id'])) {
            $data['zone_id'] = $this->session->data['inf_reg_data']['step4']['zone_id'];
        } else {
            $data['zone_id'] = $this->config->get('config_zone_id');
        }

        $this->load->model('localisation/country');

        $data['countries'] = $this->model_localisation_country->getCountries();

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

        if (isset($this->session->data['inf_reg_data']['step4']['agree'])) {
            $data['agree'] = $this->session->data['inf_reg_data']['step4']['agree'];
        } else {
            $data['agree'] = false;
        }

        if ($this->config->get('config_account_id')) {
            $this->load->model('catalog/information');

            $information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));

            if ($information_info) {
                $data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information/agree', 'information_id=' . $this->config->get('config_account_id'), true), $information_info['title'], $information_info['title']);
            } else {
                $data['text_agree'] = '';
            }
        } else {
            $data['text_agree'] = '';
        }

        $this->response->setOutput($this->load->view('register/step4', $data));
    }

    public function save() {

        $this->load->language('register/step4');

        $this->load->model('register/user');
        $this->load->model('account/customer');
        $this->load->model('account/inf_register');

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
        } elseif (!isset($this->session->data['inf_reg_data']['step3'])) {
            $json['redirect'] = $this->url->link('register/user', '', true);
        }
$products = $this->cart->getProducts();
  unset($this->session->data['inf_reg_data']['reg_type']);
 if($products[0]['product_id']==28){
     $this->session->data['inf_reg_data']['reg_type']='customer';
 }else{
     $this->session->data['inf_reg_data']['reg_type']='business';
 }
        if (!$json) {
            if (USERNAME_TYPE == "static") {
                if ((utf8_strlen(trim($this->request->post['username'])) < 6)) {
                    $json['error']['warning'] = $this->language->get('error_username_more_than_six');
                    $json['error']['username'] = $this->language->get('error_username_more_than_six');
                }
                if ((utf8_strlen(trim($this->request->post['username'])) > 12)) {
                    $json['error']['warning'] = $this->language->get('error_username_less_than_twelve');
                    $json['error']['username'] = $this->language->get('error_username_less_than_twelve');
                }
                if (!preg_match("/^[a-zA-Z0-9]{6,15}$/", $this->request->post['username'])){
                    $json['error']['warning'] = $this->language->get('space_not_allowed');
                    $json['error']['username'] = $this->language->get('space_not_allowed');
                }                
                $validate_username = $this->model_account_inf_register->validateUsername($this->request->post['username']);

                if ($validate_username) {
                    $json['error']['warning'] = $this->language->get('error_username_exist');
                    $json['error']['username'] = $this->language->get('error_username_exist');
                }
            }

            if ((utf8_strlen($this->request->post['password']) < 6)) {
                $json['error']['password'] = $this->language->get('error_password_min_six');
            }
            if ((utf8_strlen($this->request->post['password']) > 32)) {
                $json['error']['password'] = $this->language->get('error_password_max');
            }
            if ((utf8_strlen($this->request->post['confirm']) < 6)) {
                $json['error']['password'] = $this->language->get('error_password_min_six');
            }
            if ((utf8_strlen($this->request->post['confirm']) > 32)) {
                $json['error']['password'] = $this->language->get('error_password_max');
            }

            if ($this->request->post['confirm'] != $this->request->post['password']) {
                $json['error']['confirm'] = $this->language->get('error_confirm');
            }

            if ((utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
                $json['error']['firstname'] = $this->language->get('error_firstname_max');
            }
            if ((utf8_strlen(trim($this->request->post['firstname'])) < 3)) {
                $json['error']['firstname'] = $this->language->get('error_firstname_min');
            }
            if ((utf8_strlen(trim($this->request->post['firstname'])) <= 0)) {
                $json['error']['firstname'] = $this->language->get('error_firstname_enter');
            }
            if ((utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
                $json['error']['lastname'] = $this->language->get('error_lastname_max');
            }//sahla
            if ((utf8_strlen(trim($this->request->post['lastname'])) <= 0)) {
                $json['error']['lastname'] = $this->language->get('error_lastname_enter');
            }
            if ($this->request->post['lastname'] != '') {
                if ((utf8_strlen(trim($this->request->post['lastname'])) < 3)) {
                    $json['error']['lastname'] = $this->language->get('error_firstname_min');
                }
            }

            if (isset($this->request->post['year']) && $this->request->post['year'] == "") {
                $json['error']['year'] = $this->language->get('error_year');
            }
            if (isset($this->request->post['month']) && $this->request->post['month'] == "") {
                $json['error']['month'] = $this->language->get('error_month');
            }
            if (isset($this->request->post['day']) && $this->request->post['day'] == "") {
                $json['error']['day'] = $this->language->get('error_day');
            }
            $age_limit = $this->model_account_inf_register->getAgeLimitSetting();

            // age validation based on year, month and day
            /*if (!$this->validate_age($this->request->post['date_of_birth'], $age_limit)) {
                $json['error']['date_of_birth'] = sprintf($this->language->get('error_invalid_age'), $age_limit);
            }*/

            // age validation based on year
            if (!$this->validate_age_year($this->request->post['date_of_birth'], $age_limit)) {
                $json['error']['date_of_birth'] = sprintf($this->language->get('error_invalid_age'), $age_limit);
            }
            if ($this->request->post['gender'] == "") {
                $json['error']['gender'] = $this->language->get('error_gender');
            }
//            if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
//                $json['error']['email'] = $this->language->get('error_mail_format');
//            }
            if (!filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
               $json['error']['email'] = $this->language->get('error_email'); 
            } 
            if (utf8_strlen($this->request->post['email']) > 256) {
               $json['error']['email'] = $this->language->get('error_email_length'); 
            }
//            if (!preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._!#$%^&*()+=;,:-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $this->request->post['email'])) {
//                $json['error']['email'] = $this->language->get('error_mail_format');
//            }

            if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
                $json['error']['warning'] = $this->language->get('error_exists');
                $json['error']['email'] = $this->language->get('error_exists');
            }
            if ((utf8_strlen($this->request->post['telephone']) < 5)) {
                $json['error']['telephone'] = $this->language->get('error_telephone_min');
            }
            if ((utf8_strlen($this->request->post['telephone']) > 14)) {
                $json['error']['telephone'] = $this->language->get('error_telephone_max');
            }
            if ($this->request->post['telephone'] <= 0) {
                $json['error']['telephone'] = $this->language->get('error_invalid_phone');
            }
            if ((utf8_strlen(trim($this->request->post['address_1'])) < 3)) {
                $json['error']['address_1'] = $this->language->get('error_address_1_min');
            }
            if ((utf8_strlen(trim($this->request->post['address_1'])) > 32)) {
                $json['error']['address_1'] = $this->language->get('error_address_1_max');
            }
            if ($this->request->post['address_2'] != '') {
                if ((utf8_strlen(trim($this->request->post['address_2'])) < 3)) {
                    $json['error']['address_2'] = $this->language->get('error_address_1_min');
                }
                if ((utf8_strlen(trim($this->request->post['address_2'])) > 32)) {
                    $json['error']['address_2'] = $this->language->get('error_address_2_max');
                }
            }

            if ((utf8_strlen(trim($this->request->post['city'])) < 3)) {
                $json['error']['city'] = $this->language->get('error_address_1_min');
            }
            if ((utf8_strlen(trim($this->request->post['city'])) > 32)) {
                $json['error']['city'] = $this->language->get('error_city_max');
            }

            $this->load->model('localisation/country');

            $country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);
            if ((utf8_strlen(trim($this->request->post['postcode'])) > 0) && (utf8_strlen(trim($this->request->post['postcode'])) < 3))
                $json['error']['postcode'] = $this->language->get('error_postcode_min');
            if ($country_info && $country_info['postcode_required'] && ( utf8_strlen(trim($this->request->post['postcode'])) > 10)) {
                $json['error']['postcode'] = $this->language->get('error_postcode_max');
            }

            if ($this->request->post['country_id'] == '') {
                $json['error']['country'] = $this->language->get('error_country');
            }

            if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
                $json['error']['zone'] = $this->language->get('error_zone');
            }

            // Customer Group
            if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
                $customer_group_id = $this->request->post['customer_group_id'];
            } else {
                $customer_group_id = $this->config->get('config_customer_group_id');
            }
$customer_group_id=1;
            // Custom field validation
            $this->load->model('account/custom_field');

            $custom_fields = $this->model_account_custom_field->getCustomFields($customer_group_id);

            foreach ($custom_fields as $custom_field) {
                if ($custom_field['required'] && empty($this->request->post['custom_field'][$custom_field['location']][$custom_field['custom_field_id']])) {
                    $json['error']['custom_field'][$custom_field['custom_field_id']] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
                }
            }

            // Agree to terms
            if ($this->config->get('config_account_id')) {
                $this->load->model('catalog/information');

                $information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));

                if ($information_info && !isset($this->request->post['agree'])) {
                    $json['error']['agree'] = sprintf($this->language->get('error_agree'), $information_info['title']);
                    $json['error']['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
                }
            }
        }

        if (!$json) {
            $step4_data = $this->request->post;
            if (!isset($step4_data['fax'])) {
                $step4_data['fax'] = '';
            }

            if (!isset($step4_data['company'])) {
                $step4_data['company'] = '';
            }
            $step4_data['customer_group_id'] = $customer_group_id;
            $custom_fields_post = isset($this->request->post['custom_field']) ? $this->request->post['custom_field'] : '';
            $this->session->data['inf_reg_data']['step4'] = $step4_data;

            $country_id = $step4_data['country_id'];
            $country_details = $this->model_register_user->getCountryDetails($country_id);
            $zone_id = $step4_data['zone_id'];
            $zone_details = $this->model_register_user->getZoneDetails($zone_id);

            $address_data = array(
                'address_id' => '',
                'firstname' => $step4_data['firstname'],
                'lastname' => $step4_data['lastname'],
                'company' => $step4_data['company'],
                'address_1' => $step4_data['address_1'],
                'address_2' => $step4_data['address_2'],
                'postcode' => $step4_data['postcode'],
                'city' => $step4_data['city'],
                'zone_id' => $step4_data['zone_id'],
                'zone' => $zone_details['zone'],
                'zone_code' => $zone_details['zone_code'],
                'country_id' => $step4_data['country_id'],
                'country' => $country_details['country'],
                'iso_code_2' => $country_details['iso_code_2'],
                'iso_code_3' => $country_details['iso_code_3'],
                'address_format' => $country_details['address_format'],
                'custom_field' => $custom_fields_post);
            $this->session->data['payment_address'] = $address_data;
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    function check_username_availability() {
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $echo = "no";
            $user_name = $this->request->post['user_name'];
            $this->load->model('account/inf_register');
            if ($user_name != '') {
                $validate_username = $this->model_account_inf_register->validateUsername($user_name);
                if ($validate_username) {
                    $echo = "no";
                } else {
                    $echo = "yes";
                }
            }
        } else {
            $echo = "Access Denied";
        }
        echo $echo;
        exit();
    }

    function validate_age($dob, $age_limit) {
        if (!$this->request->post['year'] || !$this->request->post['month'] || !$this->request->post['day']) {
            return TRUE;
        }

        if ($age_limit == 0) {
            return TRUE;
        }
        $date1 = new DateTime($dob);
        $date1->add(new DateInterval("P{$age_limit}Y"));
        $date2 = new DateTime();
        if ($date1 <= $date2) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    function validate_age_year($dob, $age_limit) {
        if (!$this->request->post['year'] || !$this->request->post['month'] || !$this->request->post['day']) {
            return TRUE;
        }

        if ($age_limit == 0) {
            return TRUE;
        }
        $year = date('Y', strtotime($dob));
        $current_year = date('Y');
        if (($current_year - $year) >= $age_limit) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

}
