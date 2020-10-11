<?php

require_once 'Inf_Controller.php';

class Auto_Register extends Inf_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('configuration_model', '', TRUE);
        $this->lang->load('register', $this->LANG_NAME);
    }

    function user_register($placement_id_encrypted = "", $position = "") {

        $sponsor_user_name = $this->LOG_USER_NAME;
        $user_id = $this->LOG_USER_ID;

        $reg_from_tree = 0;
        $placement_id = '';
        $placement_user_name = '';
        $placement_full_name = '';
        if ($placement_id_encrypted != '') {
            $reg_from_tree = 1;
            $placement_id_decoded = urldecode($placement_id_encrypted);
            $placement_id_replaced = str_replace("_", "/", $placement_id_decoded);
            $placement_id = $this->encrypt->decode($placement_id_replaced);
            if (!$this->validation_model->idToUserName($placement_id)) {
                $this->redirect("Invalid Placement", "tree/genology_tree", FALSE);
            } else {
                $placement_user_name = $this->validation_model->IdToUserName($placement_id);
                $placement_full_name = $this->validation_model->getFullName($placement_id);
            }
        } else {
            $placement_user_name = $this->validation_model->IdToUserName($user_id);
            $placement_full_name = $this->validation_model->getFullName($user_id);
        }
        /* if ($this->MODULE_STATUS['opencart_status_demo'] == "yes" || $this->MODULE_STATUS['opencart_status'] == "yes") {
          $this->session->set_userdata("inf_placement_array", array("reg_from_tree" => $reg_from_tree, "placement_user_name" => $placement_user_name, "placement_full_name" => $placement_full_name, "position" => $position, "mlm_plan" => $this->MLM_PLAN));

          if (isset($this->session->userdata['inf_reg_data'])) {
          $this->session->unset_userdata('inf_reg_data');
          }

          $table_prefix = str_replace("_", "", $this->table_prefix);
          $store_path = "../../store/index.php?route=register/packages&id=$table_prefix";
          if (DEMO_STATUS == "no") {
          $store_path = "../../store/index.php?route=register/packages";
          }
          $this->redirect("", $store_path);
          } */

        $title = lang('new_user_signup');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = "register_downline";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('new_user_signup');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('new_user_signup');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $countries = $this->country_state_model->viewCountry();
        $states = '';
        $products = '';
        if ($this->MODULE_STATUS['product_status'] == "yes") {
            $products = $this->register_model->viewProducts();
        }

        $reg_post_array = array();
        $reg_count = 0;
        $pin_count = 0;
        if ($this->session->userdata("inf_reg_post_array")) {
            $reg_post_array = $this->session->userdata("inf_reg_post_array");
            $reg_from_tree = $reg_post_array['reg_from_tree'];
            $pin_count = $reg_post_array['pin_count'];
            $sponsor_user_name = $reg_post_array['sponsor_user_name'];
            $placement_user_name = $reg_post_array['placement_user_name'];
            $placement_full_name = $reg_post_array['placement_full_name'];
            $reg_count = count($this->session->userdata("inf_reg_post_array"));
            $countries = $this->country_state_model->viewCountry($reg_post_array['country']);
            $states = $this->country_state_model->viewState($reg_post_array['country'], $reg_post_array['state']);
            if ($this->MODULE_STATUS['product_status'] == "yes") {
                $products = $this->register_model->viewProducts($reg_post_array['product_id']);
            }
            $this->session->unset_userdata("inf_reg_post_array");
        }

        $is_product_added = "";
        if ($this->MODULE_STATUS['product_status'] == "yes") {
            $is_product_added = $this->register_model->isProductAdded();
        }

        $is_pin_added = "";
        if ($this->MODULE_STATUS['pin_status'] == "yes") {
            $is_pin_added = $this->register_model->isPinAdded();
        }

        if ($this->session->userdata('inf_error')) {
            $error = $this->session->userdata('inf_error');
            //print_r($eprint_rrror);die();
            $this->set('error', $error);
            $this->session->unset_userdata('inf_error');
        }

        $payment_methods_tab = false;
        $payment_gateway_array = array();
        $payment_module_status_array = array();
        $registration_fee = $this->register_model->getRegisterAmount();
        if ($registration_fee || $this->MODULE_STATUS ['product_status'] == 'yes') {
            $payment_methods_tab = TRUE;
            $payment_gateway_array = $this->register_model->getPaymentGatewayStatus();
            $payment_module_status_array = $this->register_model->getPaymentModuleStatus();
        }

        $termsconditions = $this->register_model->getTermsConditions($this->LANG_ID);
        $username_config = $this->configuration_model->getUsernameConfig();
        $user_name_type = $username_config["type"];

        $this->set('reg_from_tree', $reg_from_tree);
        $this->set('pin_count', $pin_count);
        $this->set('reg_post_array', $reg_post_array);
        $this->set('reg_count', $reg_count);
        $this->set("sponsor_user_name", $sponsor_user_name);
        $this->set("user_id", $user_id);
        $this->set('position', $position);
        $this->set("placement_full_name", $placement_full_name);
        $this->set("placement_user_name", $placement_user_name);
        $this->set('user_name_type', $user_name_type);
        $this->set('payment_methods_tab', $payment_methods_tab);
        $this->set('payment_gateway_array', $payment_gateway_array);
        $this->set('payment_module_status_array', $payment_module_status_array);
        $this->set("registration_fee", $registration_fee);
        $this->set('termsconditions', $termsconditions);
        $this->set('countries', $countries);
        $this->set("states", $states);
        $this->set("products", $products);
        $this->set("is_pin_added", $is_pin_added);
        $this->set('is_product_added', $is_product_added);

        $this->setView();
    }

    function register_submit() {
        $regr = array();

        $reg_post_array = $this->input->post(NULL, TRUE);
        $this->session->set_userdata('inf_reg_post_array', $reg_post_array);

        if ($this->validate_register_submit()) {
            
            $payment_status = false;
            $payment_type = 'free_join';

            $module_status = $this->MODULE_STATUS;
            $product_status = $this->MODULE_STATUS['product_status'];
            $username_config = $this->configuration_model->getUsernameConfig();
           
            $reg_post_array = $this->validation_model->stripTagsPostArray($reg_post_array);
            
            $user_count = $reg_post_array['user_count'];
         
            if (is_numeric($user_count) && $user_count > 0) {

                for ($i = 0; $i < $user_count; $i++) {

                    $reg_from_tree = $reg_post_array['reg_from_tree'];
                    $active_tab = $reg_post_array['active_tab'];

                    $regr = $reg_post_array;

                    $regr['position'] = "";

                    if ($this->LOG_USER_TYPE != "admin" && $this->LOG_USER_TYPE != "employee") {
                        $regr['placement_user_name'] = $regr["sponsor_user_name"] = $this->LOG_USER_NAME;
                        $regr['placement_full_name'] = $regr["sponsor_full_name"] = $this->validation_model->getUserFullName($this->LOG_USER_ID);
                    }

                    if ($this->MLM_PLAN == "Binary") {
                        $regr['position'] = $reg_post_array["position"];
                    } elseif ($this->MLM_PLAN == "Unilevel") {
                        $regr['placement_user_name'] = $reg_post_array["sponsor_user_name"];
                        $regr['placement_full_name'] = $reg_post_array["sponsor_full_name"];
                    }

                    if ($reg_from_tree && $this->MLM_PLAN != "Unilevel") {
                        $regr['placement_user_name'] = $reg_post_array["placement_user_name"];
                        $regr['placement_full_name'] = $reg_post_array["placement_full_name"];
                        $regr['position'] = $regr["position"];
                    }

                    $regr['reg_amount'] = $this->register_model->getRegisterAmount();
                                      
                    $product_id = 0;
                    $product_name = 'NA';
                    $product_pv = '0';
                    $product_amount = '0';
                    $product_validity = "0000-00-00 00:00:00";
                    if ($product_status == "yes") {
                        $product_id = ($reg_post_array['product_id']);
                        $this->load->model('product_model');
                        $product_details = $this->product_model->getProductDetails($product_id, 'yes');
                        $product_name = $product_details[0]['product_name'];
                        $product_pv = $product_details[0]['pair_value'];
                        $product_amount = $product_details[0]['product_value'];
                        if ($this->MODULE_STATUS['product_validity'] == "yes") {
                            $product_validity = $this->product_model->calculateProductValidity($product_details[0]['package_validity']);
                        }
                    }
                    $regr['product_status'] = $product_status;
                    $regr['product_id'] = $product_id;
                    $regr['product_name'] = $product_name;
                    $regr['product_pv'] = $product_pv;
                    $regr['product_amount'] = $product_amount;
                    $regr['product_validity'] = $product_validity;
                    $regr['total_amount'] = $regr['reg_amount'] + $regr['product_amount'];

                    $regr['country_name'] = $this->country_state_model->getCountryNameFromID($regr['country']);
                    $regr['state_name'] = $this->country_state_model->getStateNameFromId($regr['state']);

                    $regr['user_name_type'] = $username_config["type"];
                    $regr['user_name_entry'] = $reg_post_array['user_name_entry'] . (($i > 0) ? $i : '');
                    $regr['joining_date'] = date('Y-m-d H:i:s');
                    $regr['active_tab'] = $active_tab;
                    $regr['reg_from_tree'] = $reg_from_tree;

                    $regr['sponsor_id'] = $this->validation_model->userNameToID($regr['sponsor_user_name']);
                    $regr['placement_id'] = $this->validation_model->userNameToID($regr['placement_user_name']);
                    $regr['product_name'] = $this->register_model->getProductName($regr['product_id']);

                    $regr['payment_type'] = $payment_type;
                    $regr['by_using'] = 'free join';
                    $this->register_model->begin();
                    $status = $this->register_model->confirmRegister($regr, $module_status);
                    if ($status['status']) {
                        $payment_status = true;
                    }

                    $msg = '';
                    if ($payment_status) {
                        $user = $status['user'];
                        $pass = $status['pwd'];
                        $encr_id = $status['id'];
                        $tran_code = $status['tran'];

                        if ($product_status == "yes") {
                            $user_id = $this->validation_model->userNameToID($user);
                            $insert_into_sales = $this->register_model->insertIntoSalesOrder($user_id, $regr['product_id'], $payment_type);
                        }

                        if ($this->MODULE_STATUS['opencart_status'] == "yes" && $this->MODULE_STATUS['opencart_status_demo'] == "yes") {
                            $this->register_model->addToCustomerTables($user_id, $regr);
                        }


                        $this->register_model->commit();
                    } else {
                        $this->register_model->rollback();
                        $msg = lang('registration_failed') . "$i";
                        $this->redirect($msg, 'auto_register/user_register', false);
                    }
                }

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'auto_register', 'Bulk Users Registered');
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Bulk Users Registered', $this->LOG_USER_ID);
                }
                //
                
                $this->redirect("Registration successful", "auto_register/user_register", true);
            } else {
                $error = $this->form_validation->error_array();
                $this->session->set_userdata('inf_error', $error);

                $msg = "Enter a valid count";
                $this->redirect($msg, "auto_register/user_register", FALSE);
            }
        } else {
            $error = $this->form_validation->error_array();
            $this->session->set_userdata('inf_error', $error);

            $msg = $this->lang->line('errors_check');
            $this->redirect($msg, "auto_register/user_register", FALSE);
        }
    }

    public function validate_register_submit() {
        $product_status = $this->MODULE_STATUS['product_status'];
        $username_config = $this->configuration_model->getUsernameConfig();
        $user_name_type = $username_config["type"];

        $active_tab = $this->input->post('active_tab', TRUE);
        $reg_from_tree = $this->input->post('reg_from_tree', TRUE);
        $pin_count = $this->input->post('pin_count', TRUE);

        if ($reg_from_tree) {
            $this->form_validation->set_rules('placement_user_name', lang('placement_user_name'), 'required|callback_validate_username|trim');
            $this->form_validation->set_rules('placement_full_name', lang('placement_full_name'), 'required|trim');
        }
        $this->form_validation->set_rules('sponsor_user_name', lang('sponsor_user_name'), 'required|callback_validate_username|trim');
//        $this->form_validation->set_rules('sponsor_full_name', lang('sponsor_full_name'), 'required|trim');

        if ($this->MLM_PLAN == 'Binary') {
            $this->form_validation->set_rules('position', lang('position'), 'trim|required');
        }

        if ($product_status == "yes") {
            $this->form_validation->set_rules('product_id', lang('product'), 'trim|required');
        }

        if ($user_name_type == 'static') {
            $this->form_validation->set_rules('user_name_entry', lang('User_Name'), 'trim|required|alpha_numeric|min_length[6]|callback_is_username_available');
        }
        $this->form_validation->set_rules('pswd', lang('password'), 'trim|required|alpha_dash|matches[cpswd]|min_length[6]');
        $this->form_validation->set_rules('cpswd', lang('confirm_password'), 'trim|required|alpha_dash');

        $this->form_validation->set_rules('first_name', lang('first_name'), 'trim|required|callback__alpha_dash_space');
        $this->form_validation->set_rules('last_name', lang('last_name'), 'trim|required|callback__alpha_dash_space');
        $this->form_validation->set_rules('gender', lang('gender'), 'trim|required');
        $this->form_validation->set_rules('year', lang('date_of_birth'), 'trim|required|callback_validate_age');
        $this->form_validation->set_message('validate_age','You should be atleast 18 years old!');
        $this->form_validation->set_rules('month', lang('date_of_birth'), 'trim|required|callback_validate_age');
        $this->form_validation->set_message('validate_age','You should be atleast 18 years old!');
        $this->form_validation->set_rules('day', lang('date_of_birth'), 'trim|required|callback_validate_age');
        $this->form_validation->set_message('validate_age','You should be atleast 18 years old!');
        $this->form_validation->set_rules('address', lang('adress_line1'), 'required');
        $this->form_validation->set_rules('address_line2', lang('adress_line2'), 'trim');
        $this->form_validation->set_rules('country', lang('country'), 'trim|required');
        $this->form_validation->set_rules('city', lang('city'), 'trim|required');
        $this->form_validation->set_rules('mobile', lang('mobile_no'), 'trim|required|numeric');
        $this->form_validation->set_rules('email', lang('email'), 'trim|required|valid_email');

        if ($active_tab == "credit_card_tab") {
            $this->form_validation->set_rules('card_number', lang('card_number'), 'trim|required|numeric');
            $this->form_validation->set_rules('credit_currency', lang('credit_currency'), 'trim|required');
            $this->form_validation->set_rules('credit_card_type', lang('credit_card_type'), 'trim|required');
            $this->form_validation->set_rules('card_cvn', lang('cvn_number'), 'trim|required|numeric');
            $this->form_validation->set_rules('card_expiry_date', lang('credit_card_expiry_date'), 'trim|required');
            $this->form_validation->set_rules('bill_to_forename', lang('account_holder_first_name'), 'trim|required');
            $this->form_validation->set_rules('bill_to_surname', lang('account_holder_last_name'), 'trim|required');
            $this->form_validation->set_rules('bill_to_email', lang('account_holder_email'), 'trim|required|valid_email');
            $this->form_validation->set_rules('bill_to_phone', lang('account_holder_phone'), 'trim|required|numeric');
        }
        if ($active_tab == 'epin_tab') {
            $temp_pin_array = "";
            $this->session->set_userdata("inf_temp_pin_array", $temp_pin_array);
            for ($i = 1; $i <= $pin_count; $i++) {
                if ($this->input->post("epin$i")) {
                    $this->form_validation->set_rules("epin$i", lang('epin') . $i, " trim|required|callback_has_match");
                }
            }
            $this->session->unset_userdata("inf_temp_pin_array");
        }
        if ($active_tab == 'ewallet_tab') {
            $this->form_validation->set_rules('user_name_ewallet', lang('ewallet_user_name'), 'trim|required');
            $this->form_validation->set_rules('tran_pass_ewallet', lang('transaction_password'), 'trim|required');
        }

        $this->form_validation->set_message('exact_length', lang('the_%s_field_must_be_exactly_10_digit'));
        $this->form_validation->set_message('validate_username', lang('the_sponsor_username_is_not_available'));
        $this->form_validation->set_message('check_username_availability', lang('the_username_is_not_available'));
        $this->form_validation->set_message('is_username_available', lang('the_username_is_not_available'));

        $validation_status = $this->form_validation->run();

        return $validation_status;
    }

    function validate_username($ref_user = '') {
        if ($ref_user != '') {
            $flag = false;
            if ($this->register_model->isUserAvailable($ref_user)) {
                $flag = TRUE;
            }
            return $flag;
        } else {
            $echo = 'no';
            $username = ($this->input->post('username', TRUE));
            if ($this->register_model->isUserAvailable($username)) {
                $echo = "yes";
            }
            echo $echo;
            exit();
        }
    }

    function check_username_availability($user = '') {
        if ($user != '') {
            $flag = false;
            if (!$this->register_model->isUserAvailable($user)) {
                $flag = TRUE;
            }
            return $flag;
        } else {
            $echo = 'no';
            if ($this->register_model->checkUser($this->input->post('user_name'))) {
                $echo = "yes";
            }
            echo $echo;
            exit();
        }
    }
    
    function preview($user_name = "", $pass = "", $id = "") {

        $title = lang('letter_preview');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = "register_downline";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('letter_preview');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('letter_preview');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $userid = urldecode($user_name);
        $id_decode = str_replace("_", "/", $userid);
        $user_name = $this->encrypt->decode($id_decode);
        $user_id = $this->validation_model->userNameToID($user_name);
        if (!$user_id) {
            $this->redirect("Invalid User Details.", "home", FALSE);
        }

        $session_data = $this->session->userdata('inf_logged_in');
        $user_type = $this->LOG_USER_TYPE;
        if ($this->MODULE_STATUS['footer_demo_status'] == "yes") {
            $admin_user_name = $session_data['admin_user_name'];
            $this->set("admin_user_name", $admin_user_name);
        }
        if ($user_type != "admin") {
            $user_type = 'user';
        }

        $date = date('Y-m-d H:i:s');
        $lang_id = $this->LANG_ID;
        $letter_arr = $this->configuration_model->getLetterSetting($lang_id);
        $product_status = $this->MODULE_STATUS['product_status'];
        $referal_status = $this->MODULE_STATUS['referal_status'];

        $father_id = $this->validation_model->getFatherId($user_id);
        $product_id = $this->validation_model->getProductId($user_id);
        $reg_amount = $this->register_model->getRegisterAmount();
        if ($product_status == "yes") {
            $product_details = $this->register_model->getProduct($product_id);
            $this->set("product_details", $product_details);
            $this->set("product_status", $product_status);
        }
        $user_registration_details = $this->register_model->getUserRegistrationDetails($user_id);

        $user_details = $this->register_model->getUserDetails($user_id);
        $user_details['user_details_ref_user_id'] = $this->validation_model->getSponsorId($user_id);

        $user_details_ref_user_id = $user_details['user_details_ref_user_id'];
        if ($referal_status == "yes") {
            $sponsorname = $this->validation_model->IdToUserName($user_details_ref_user_id);
            $this->set("sponsorname", $sponsorname);
            $this->set("referal_status", $referal_status);
        }
        $adjusted_id = $this->validation_model->IdToUserName($father_id);

        $this->set("date", $date);
        $this->set("pass", $pass);
        $this->set("id", $id);
        $this->set("user_name", $user_name);
        $this->set("user_type", $user_type);
        $this->set("letter_arr", $letter_arr);
        $this->set("reg_amount", $reg_amount);
        $this->set("product_status", $product_status);
        $this->set("adjusted_id", $adjusted_id);
        $this->set("referal_status", $referal_status);
        $this->set("user_details", $user_details);
        $this->set("user_registration_details", $user_registration_details);

        $this->setView();
    }
    
    /* form validation rule* 
     *    Method is used to validate strings to allow alpha
     *    numeric spaces underscores and dashes ONLY.
     *    @param $str    String    The item to be validated.
     *    @return BOOLEAN   True if passed validation false if otherwise.
     */

    function _alpha_dash_space($str_in = '') {
        if ($str_in!='' &&!preg_match("/^([-a-z0-9_ ])+$/i", $str_in)) {
            $this->form_validation->set_message('_alpha_dash_space', lang('the_%s_field_may_only_contain_alpha-numeric_characters_spaces_underscores_and_dashes'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function has_match($post_epin) {
        $flag = false;
        $temp_pin_array = $this->session->userdata("inf_temp_pin_array");
        $split_arr = explode("==", $temp_pin_array);

        if (!in_array($post_epin, $split_arr)) {
            $temp_pin_array.="==$post_epin";
            $this->session->set_userdata("inf_temp_pin_array", $temp_pin_array);
            $flag = true;
        }

        return $flag;
    }
    
    public function validate_age($age) {
        $post_arr = $this->input->post(NULL, TRUE);
        $year = $post_arr['year'];
        $month = $post_arr['month'];
        $day = $post_arr['day'];
        $current_year = date('Y');
        $current_month = date('m');
        $current_day = date('d');
        if ($current_year - $age < 18) {
            return false;
        } else if ($year == ($current_year - 18)) {
            if ($current_month < $month) {
                return false;
            } else if ($current_month == $month) {
                if ($current_day < $day) {
                   return false;
                }
            }
        }
        return true;
    }

    public function is_username_available($user_name)
    {
        if (!$user_name) {
            return FALSE;
        }
        $is_username_exists = $this->validation_model->isUsernameExists($user_name);
        if ($is_username_exists) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function user_register_new($placement_id_encrypted = "", $position = "") {

        $sponsor_user_name = $this->LOG_USER_NAME;
        $user_id = $this->LOG_USER_ID;

        $reg_from_tree = 0;
        $placement_id = '';
        $placement_user_name = '';
        $placement_full_name = '';
        if ($placement_id_encrypted != '') {
            $reg_from_tree = 1;
            $placement_id_decoded = urldecode($placement_id_encrypted);
            $placement_id_replaced = str_replace("_", "/", $placement_id_decoded);
            $placement_id = $this->encrypt->decode($placement_id_replaced);
            if (!$this->validation_model->idToUserName($placement_id)) {
                $this->redirect("Invalid Placement", "tree/genology_tree", FALSE);
            } else {
                $placement_user_name = $this->validation_model->IdToUserName($placement_id);
                $placement_full_name = $this->validation_model->getFullName($placement_id);
            }
        } else {
            $placement_user_name = $this->validation_model->IdToUserName($user_id);
            $placement_full_name = $this->validation_model->getFullName($user_id);
        }
        /* if ($this->MODULE_STATUS['opencart_status_demo'] == "yes" || $this->MODULE_STATUS['opencart_status'] == "yes") {
          $this->session->set_userdata("inf_placement_array", array("reg_from_tree" => $reg_from_tree, "placement_user_name" => $placement_user_name, "placement_full_name" => $placement_full_name, "position" => $position, "mlm_plan" => $this->MLM_PLAN));

          if (isset($this->session->userdata['inf_reg_data'])) {
          $this->session->unset_userdata('inf_reg_data');
          }

          $table_prefix = str_replace("_", "", $this->table_prefix);
          $store_path = "../../store/index.php?route=register/packages&id=$table_prefix";
          if (DEMO_STATUS == "no") {
          $store_path = "../../store/index.php?route=register/packages";
          }
          $this->redirect("", $store_path);
          } */

        $title = lang('new_user_signup');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = "register_downline";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('new_user_signup');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('new_user_signup');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $countries = $this->country_state_model->viewCountry();
        $states = '';
        $products = '';
        if ($this->MODULE_STATUS['product_status'] == "yes") {
            $products = $this->register_model->viewProducts();
        }

        $reg_post_array = array();
        $reg_count = 0;
        $pin_count = 0;
        if ($this->session->userdata("inf_reg_post_array")) {
            $reg_post_array = $this->session->userdata("inf_reg_post_array");
            $reg_from_tree = $reg_post_array['reg_from_tree'];
            $pin_count = $reg_post_array['pin_count'];
            $sponsor_user_name = $reg_post_array['sponsor_user_name'];
            $placement_user_name = $reg_post_array['placement_user_name'];
            $placement_full_name = $reg_post_array['placement_full_name'];
            $reg_count = count($this->session->userdata("inf_reg_post_array"));
            $countries = $this->country_state_model->viewCountry($reg_post_array['country']);
            $states = $this->country_state_model->viewState($reg_post_array['country'], $reg_post_array['state']);
            if ($this->MODULE_STATUS['product_status'] == "yes") {
                $products = $this->register_model->viewProducts($reg_post_array['product_id']);
            }
            $this->session->unset_userdata("inf_reg_post_array");
        }

        $is_product_added = "";
        if ($this->MODULE_STATUS['product_status'] == "yes") {
            $is_product_added = $this->register_model->isProductAdded();
        }

        $is_pin_added = "";
        if ($this->MODULE_STATUS['pin_status'] == "yes") {
            $is_pin_added = $this->register_model->isPinAdded();
        }

        if ($this->session->userdata('inf_error')) {
            $error = $this->session->userdata('inf_error');
            //print_r($eprint_rrror);die();
            $this->set('error', $error);
            $this->session->unset_userdata('inf_error');
        }

        $payment_methods_tab = false;
        $payment_gateway_array = array();
        $payment_module_status_array = array();
        $registration_fee = $this->register_model->getRegisterAmount();
        if ($registration_fee || $this->MODULE_STATUS ['product_status'] == 'yes') {
            $payment_methods_tab = TRUE;
            $payment_gateway_array = $this->register_model->getPaymentGatewayStatus();
            $payment_module_status_array = $this->register_model->getPaymentModuleStatus();
        }

        $termsconditions = $this->register_model->getTermsConditions($this->LANG_ID);
        $username_config = $this->configuration_model->getUsernameConfig();
        $user_name_type = $username_config["type"];

        $this->set('reg_from_tree', $reg_from_tree);
        $this->set('pin_count', $pin_count);
        $this->set('reg_post_array', $reg_post_array);
        $this->set('reg_count', $reg_count);
        $this->set("sponsor_user_name", $sponsor_user_name);
        $this->set("user_id", $user_id);
        $this->set('position', $position);
        $this->set("placement_full_name", $placement_full_name);
        $this->set("placement_user_name", $placement_user_name);
        $this->set('user_name_type', $user_name_type);
        $this->set('payment_methods_tab', $payment_methods_tab);
        $this->set('payment_gateway_array', $payment_gateway_array);
        $this->set('payment_module_status_array', $payment_module_status_array);
        $this->set("registration_fee", $registration_fee);
        $this->set('termsconditions', $termsconditions);
        $this->set('countries', $countries);
        $this->set("states", $states);
        $this->set("products", $products);
        $this->set("is_pin_added", $is_pin_added);
        $this->set('is_product_added', $is_product_added);

        $this->setView();
    }
        function register_submit_new() {
        $regr = array();

        $reg_post_array = $this->input->post(NULL, TRUE);
        $this->session->set_userdata('inf_reg_post_array', $reg_post_array);

        if ($this->validate_register_submit()) {
            
            $payment_status = false;
            $payment_type = 'free_join';

            $module_status = $this->MODULE_STATUS;
            $product_status = $this->MODULE_STATUS['product_status'];
            $username_config = $this->configuration_model->getUsernameConfig();
           
            $reg_post_array = $this->validation_model->stripTagsPostArray($reg_post_array);
            
            $user_count = $reg_post_array['user_count'];
            $user_details = $this->validation_model->getAutoUserDetails();
            if (is_numeric($user_count) && $user_count > 0) {

                for ($i = 0; $i < $user_count; $i++) {
                    $reg_from_tree = $reg_post_array['reg_from_tree'];
                    $active_tab = $reg_post_array['active_tab'];

                    $regr = $reg_post_array;
                    $regr['first_name'] = $user_details[$i]['first_name'];
                    $regr['last_name'] = $user_details[$i]['last_name'];
                    $regr['gender'] = $user_details[$i]['gender'];
                    $regr['date_of_birth'] = $user_details[$i]['dob'];
                    $regr['address'] = $user_details[$i]['address'];
                    $regr['country'] = $user_details[$i]['country'];
                    $regr['city'] = $user_details[$i]['city'];
                    $regr['email'] = $user_details[$i]['email'];
                    $regr['mobile'] = $user_details[$i]['mobile'];
                    $regr['position'] = "";
                    if ($this->LOG_USER_TYPE != "admin" && $this->LOG_USER_TYPE != "employee") {
                        $regr['placement_user_name'] = $regr["sponsor_user_name"] = $this->LOG_USER_NAME;
                        $regr['placement_full_name'] = $regr["sponsor_full_name"] = $this->validation_model->getUserFullName($this->LOG_USER_ID);
                    }

                    if ($this->MLM_PLAN == "Binary") {
                        $regr['position'] = $reg_post_array["position"];
                    } elseif ($this->MLM_PLAN == "Unilevel") {
                        $regr['placement_user_name'] = $reg_post_array["sponsor_user_name"];
                        $regr['placement_full_name'] = $reg_post_array["sponsor_full_name"];
                    }

                    if ($reg_from_tree && $this->MLM_PLAN != "Unilevel") {
                        $regr['placement_user_name'] = $reg_post_array["placement_user_name"];
                        $regr['placement_full_name'] = $reg_post_array["placement_full_name"];
                        $regr['position'] = $regr["position"];
                    }

                    $regr['reg_amount'] = $this->register_model->getRegisterAmount();
                                      
                    $product_id = 0;
                    $product_name = 'NA';
                    $product_pv = '0';
                    $product_amount = '0';
                    $product_validity = "0000-00-00 00:00:00";
                    if ($product_status == "yes") {
                        $product_id = ($reg_post_array['product_id']);
                        $this->load->model('product_model');
                        $product_details = $this->product_model->getProductDetails($product_id, 'yes');
                        $product_name = $product_details[0]['product_name'];
                        $product_pv = $product_details[0]['pair_value'];
                        $product_amount = $product_details[0]['product_value'];
                        if ($this->MODULE_STATUS['product_validity'] == "yes") {
                            $product_validity = $this->product_model->calculateProductValidity($product_details[0]['package_validity']);
                        }
                    }
                    $regr['product_status'] = $product_status;
                    $regr['product_id'] = $product_id;
                    $regr['product_name'] = $product_name;
                    $regr['product_pv'] = $product_pv;
                    $regr['product_amount'] = $product_amount;
                    $regr['product_validity'] = $product_validity;
                    $regr['total_amount'] = $regr['reg_amount'] + $regr['product_amount'];

                    $regr['country_name'] = $this->country_state_model->getCountryNameFromID($regr['country']);
                    $regr['state_name'] = $this->country_state_model->getStateNameFromId($regr['state']);

                    $regr['user_name_type'] = $username_config["type"];
                    $regr['user_name_entry'] = $reg_post_array['user_name_entry'] . (($i > 0) ? $i : '');
                    $regr['joining_date'] = date('Y-m-d H:i:s');
                    $regr['active_tab'] = $active_tab;
                    $regr['reg_from_tree'] = $reg_from_tree;

                    $regr['sponsor_id'] = $this->validation_model->userNameToID($regr['sponsor_user_name']);
                    $regr['placement_id'] = $this->validation_model->userNameToID($regr['placement_user_name']);
                    $regr['product_name'] = $this->register_model->getProductName($regr['product_id']);

                    $regr['payment_type'] = $payment_type;
                    $regr['by_using'] = 'free join';
                    $this->register_model->begin();
                    $status = $this->register_model->confirmRegister($regr, $module_status);
                    if ($status['status']) {
                        $payment_status = true;
                    }

                    $msg = '';
                    if ($payment_status) {
                        $user = $status['user'];
                        $pass = $status['pwd'];
                        $encr_id = $status['id'];
                        $tran_code = $status['tran'];

                        if ($product_status == "yes") {
                            $user_id = $this->validation_model->userNameToID($user);
                            $insert_into_sales = $this->register_model->insertIntoSalesOrder($user_id, $regr['product_id'], $payment_type);
                        }

                        if ($this->MODULE_STATUS['opencart_status'] == "yes" && $this->MODULE_STATUS['opencart_status_demo'] == "yes") {
                            $this->register_model->addToCustomerTables($user_id, $regr);
                        }


                        $this->register_model->commit();
                    } else {
                        $this->register_model->rollback();
                        $msg = lang('registration_failed') . "$i";
                        $this->redirect($msg, 'auto_register/user_register_new', false);
                    }
                }

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'auto_register', 'Bulk Users Registered');
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Bulk Users Registered', $this->LOG_USER_ID);

                }
                //
                
                $this->redirect("Registration successful", "auto_register/user_register_new", true);
            } else {
                $error = $this->form_validation->error_array();
                $this->session->set_userdata('inf_error', $error);

                $msg = "Enter a valid count";
                $this->redirect($msg, "auto_register/user_register", FALSE);
            }
        } else {
            $error = $this->form_validation->error_array();
            $this->session->set_userdata('inf_error', $error);

            $msg = $this->lang->line('errors_check');
            $this->redirect($msg, "auto_register/user_register", FALSE);
        }
    }

}
