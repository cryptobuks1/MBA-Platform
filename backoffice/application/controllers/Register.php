<?php

define("IN_WALLET", true);
require "../vendor/autoload.php";
require_once 'Inf_Controller.php';

use Blocktrail\SDK\BlocktrailSDK;

class Register extends Inf_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('configuration_model', '', true);
        $this->load->model('ewallet_model', '', true);
        $this->load->model('tree_model', '', true);
        $this->MLM_PLAN = $this->validation_model->getMLMPlan();
        $this->load->model('member_model', '', true);
    }

    function user_register($placement_id_encrypted = "", $position = "")
    {

        $signup_settings = $this->configuration_model->getGeneralSignupConfig();
        $get_leg_type = '';
        if ($signup_settings['registration_allowed'] == 'no' && $this->LOG_USER_TYPE != 'admin' && $this->LOG_USER_TYPE != 'employee') {
            $msg = lang('registration_not_allowed');
            // $this->redirect($msg, 'home', false);
            $this->redirect($msg, 'latest_updates', false);
        }

        $sponsor_user_name = $this->LOG_USER_NAME;
        $user_id = $this->LOG_USER_ID;

        if ($this->LOG_USER_TYPE == 'employee') {
            $sponsor_user_name = $this->ADMIN_USER_NAME;
            $user_id = $this->ADMIN_USER_ID;
        }

        if (!empty($this->session->userdata('from_replica'))) {
            $this->session->unset_userdata('from_replica');
        }

        $replica = FALSE;
        if(uri_string() == 'replica_register') {
            $this->session->set_userdata('from_replica', 'yes');
            $replica_session = $this->session->userdata('replica_user');
            if($replica_session) {
                $sponsor_user_name = $replica_session['user_name'];
                $user_id = $replica_session['user_id'];
                $replica = TRUE;
            }
            $replica_lang = $this->session->userdata('replica_language');
            if($replica_lang) {
                $lang_name_in_english = $replica_lang['lang_name_in_english'];
                $this->lang->load($this->CURRENT_CTRL, $lang_name_in_english);
            }
        }

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
                $this->redirect("Invalid Placement", "tree/genology_tree", false);
            } else {
                $placement_user_name = $this->validation_model->IdToUserName($placement_id);
                $placement_full_name = $this->validation_model->getFullName($placement_id);
                if (($this->MLM_PLAN == "Unilevel" || $this->MLM_PLAN == "Stair_Step") && $this->LOG_USER_ID == $this->ADMIN_USER_ID) {

                    $sponsor_user_name = $placement_user_name;
                    $user_id = $placement_id;
                }
            }
        } else {
            $placement_user_name = $this->validation_model->IdToUserName($user_id);
            $placement_full_name = $this->validation_model->getFullName($user_id);
        }
        if ($signup_settings['sponsor_required'] == 'no' && $this->LOG_USER_TYPE != 'admin' && $this->LOG_USER_TYPE != 'employee' && empty($this->session->userdata('replica_user'))) {
            $user_id = $this->validation_model->getAdminId();
            $sponsor_user_name = $this->validation_model->getAdminUsername();
        }
        $sponsor_full_name = $this->validation_model->getFullName($user_id);

        if ($this->MODULE_STATUS['opencart_status_demo'] == "yes" && $this->MODULE_STATUS['opencart_status'] == "yes") {
            $this->session->set_userdata("inf_placement_array", array("reg_from_tree" => $reg_from_tree, "sponsor_user_name" => $sponsor_user_name, "sponsor_full_name" => $sponsor_full_name, "placement_user_name" => $placement_user_name, "placement_full_name" => $placement_full_name, "position" => $position, "mlm_plan" => $this->MLM_PLAN));

            if (!empty($this->session->userdata('inf_reg_data'))) {
                $this->session->unset_userdata('inf_reg_data');
            }

            $table_prefix = str_replace("_", "", $this->table_prefix);
            $store_path = STORE_URL . "/index.php?route=register/packages";
            if (DEMO_STATUS == "no") {
                $store_path = STORE_URL . "/index.php?route=register/packages";
            }
            redirect($store_path);
        }

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

        if ($signup_settings['default_country']) {
            $countries = $this->country_state_model->viewCountry($signup_settings['default_country']);
            $states = $this->country_state_model->viewState($signup_settings['default_country']);
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
        } else
            if (DEMO_STATUS == "yes") {
            $reg_post_array = $this->register_model->getDefaultData();
            $reg_count = count($reg_post_array);
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
            $this->set('error', $error);
            $this->session->unset_userdata('inf_error');
        }

        $payment_methods_tab = false;
        $payment_gateway_array = array();
        $payment_module_status_array = array();
        $registration_fee = $this->register_model->getRegisterAmount();
        $registration_fee1 = round($registration_fee * $this->DEFAULT_CURRENCY_VALUE, 8);

        if ($registration_fee || $this->MODULE_STATUS['product_status'] == 'yes') {
            $payment_methods_tab = true;
            $payment_gateway_array = $this->register_model->getPaymentGatewayStatus("registration");
            $payment_module_status_array = $this->register_model->getPaymentModuleStatus();
        }

        $termsconditions = $this->register_model->getTermsConditions($this->LANG_ID);
        $username_config = $this->configuration_model->getUsernameConfig();
        $user_name_type = $username_config["type"];
        $contact_fields = $this->register_model->getContactInfoFields();
        $is_logged_in = $this->checkSession();
        
        $this->set('is_logged_in', $is_logged_in);
        $this->set('signup_settings', $signup_settings);
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
        $this->set("registration_fee1", $registration_fee1);
        $this->set('termsconditions', $this->security->xss_clean($termsconditions));
        $this->set("products", $this->security->xss_clean($products));
        $this->set("is_pin_added", $is_pin_added);
        $this->set('is_product_added', $is_product_added);
        $this->set('from_replica', $replica);
        $this->set('countries', $countries);
        $this->set("states", $states);
        $this->set('fields', $contact_fields);

        $this->setView();
    }

    function register_submit()
    {
        $by_replica = false;
        if(isset($this->session->userdata['from_replica'])) {
            $redirect_url = "register/replica_register";
            $by_replica = true;
        } else {
            $redirect_url = "register/user_register";
        }

        if ($this->BLOCK_REGISTER && $this->LOG_USER_TYPE != 'admin' && $this->LOG_USER_TYPE != 'employee') {
            $this->redirect(lang('you_cant_access_page_due_to_block_status'), 'home', false);
        }

        $signup_settings = $this->configuration_model->getGeneralSignupConfig();
        if ($signup_settings['registration_allowed'] == 'no' && $this->LOG_USER_TYPE != 'admin' && $this->LOG_USER_TYPE != 'employee' && !$by_replica) {
            $msg = lang('registration_not_allowed');
            $this->redirect($msg, 'home', false);
        }

        $by_replica = false;
        if(!empty($this->session->userdata('from_replica'))) {
            $redirect_url = "register/replica_register";
            $by_replica = true;
        } else {
            $redirect_url = "register/user_register";
        }

        $regr = array();
        $reg_post_array = $this->input->post(null, true);
        $payment_module_status_array = $this->register_model->getPaymentModuleStatus();
        $payment_gateway_array = $this->register_model->getPaymentGatewayStatus("registration");
        if ($reg_post_array['active_tab'] == 'free_join_tab' && $payment_module_status_array['free_joining_type'] == 'no') {
            $msg = lang('please_choose_a_payment_method');
            $this->redirect($msg, $redirect_url, false);
        }
        if ($signup_settings['sponsor_required'] == 'yes' && $this->LOG_USER_TYPE == 'user' && !$by_replica) {
            if ($reg_post_array['sponsor_user_name'] != $this->LOG_USER_NAME) {
                $msg = lang('invalid_sponser_user_name');
                $this->redirect($msg, $redirect_url, false);
            }
        }
        if ($signup_settings['sponsor_required'] == 'no' && $this->LOG_USER_TYPE == 'user' && !$by_replica) {
            if ($reg_post_array['sponsor_user_name'] != $this->ADMIN_USER_NAME) {
                $msg = lang('invalid_sponser_user_name');
                $this->redirect($msg, $redirect_url, false);
            }
        }
        $sponsor = $this->validation_model->userNameToID($reg_post_array['sponsor_user_name']);

        $this->session->set_userdata('inf_reg_post_array', $reg_post_array);

        if ($signup_settings['sponsor_required'] == 'no' && $this->LOG_USER_TYPE != 'admin' && $this->LOG_USER_TYPE != 'employee' && !$by_replica) {
            $reg_post_array['sponsor_user_name'] = $this->ADMIN_USER_NAME;
            $reg_post_array['sponsor_full_name'] = $this->validation_model->getFullName($this->ADMIN_USER_ID);
        }

        if ($this->MLM_PLAN == 'Binary') {
            $this->load->model('tree_model');
            if ($reg_post_array['reg_from_tree']) {
                $placement_id = $this->validation_model->userNameToID($reg_post_array['placement_user_name']);
            } else {
                $placement_id = $this->validation_model->userNameToID($reg_post_array['sponsor_user_name']);
            }

            $binary_leg_allowed = $this->tree_model->getAllowedBinaryLeg($placement_id, $this->LOG_USER_TYPE, $this->LOG_USER_ID);
            if ($binary_leg_allowed != 'any' && $binary_leg_allowed != $reg_post_array['position']) {
                $msg = lang('position_not_useable');
                $this->redirect($msg, $redirect_url, false);
            }
        }

        if ($this->input->post('active_tab') != 'bank_transfer') {
            $this->session->unset_userdata('file');
        }
        if ($this->validate_register_submit()) {
            if ($this->input->post('active_tab') == 'bank_transfer' && empty($this->session->userdata('file'))) {
                $msg = $this->lang->line('upload_reciepts..');
                $this->redirect($msg, $redirect_url, false);
            }

            $payment_status = false;
            $payment_type = 'free_join';
            $is_free_join_ok = false;
            $is_pin_ok = false;
            $is_ewallet_ok = false;
            $is_paypal_ok = false;
            $is_authorize_ok = false;
            $is_blockchain_ok = false;
            $is_bitgo_ok = false;
            $is_bitcoin_ok = false;
            $is_bank_transfer_ok = false;
            $is_payeer_ok = false;
            $is_sofort_ok = false;
            $is_squareup_ok = false;

            $module_status = $this->MODULE_STATUS;
            $product_status = $this->MODULE_STATUS['product_status'];
            $username_config = $this->configuration_model->getUsernameConfig();

            $reg_post_array = $this->validation_model->stripTagsPostArray($reg_post_array);

            $reg_from_tree = $reg_post_array['reg_from_tree'];
            $active_tab = $reg_post_array['active_tab'];

            $regr = $reg_post_array;

            if ($this->MLM_PLAN == "Unilevel" || $this->MLM_PLAN == "Stair_Step") {
                $regr['placement_user_name'] = $reg_post_array["sponsor_user_name"];
            }

            $regr['reg_amount'] = $this->register_model->getRegisterAmount();

            $product_id = 0;
            $product_name = 'NA';
            $product_pv = '0';
            $product_amount = '0';
            $product_validity = "";

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

            $regr['user_name_type'] = $username_config["type"];
            $regr['joining_date'] = date('Y-m-d H:i:s');
            $regr['active_tab'] = $active_tab;
            $regr['reg_from_tree'] = $reg_from_tree;

            $regr['sponsor_id'] = $this->validation_model->userNameToID($regr['sponsor_user_name']);
            $regr['placement_id'] = $this->validation_model->userNameToID($regr['placement_user_name']);
            $regr['product_name'] = $this->register_model->getProductName($regr['product_id']);
//print_r($active_tab);die;
            if ($active_tab == 'epin_tab') {
                $payment_type = 'epin';
                $pin_count = $reg_post_array['pin_count'];
                $pin_details = array();
                $j = 0;
                for ($i = 1; $i <= $pin_count; $i++) {
                    if (isset($reg_post_array["epin$i"])) {
                        $j++;
                        $pin_number = $reg_post_array["epin$i"];
                        $pin_details[$j]['pin'] = $pin_number;
                        $pin_details[$j]['i'] = $i;
                    }
                }
                $pin_count = $j;
                $pin_array = $this->register_model->checkAllEpins($pin_details, $product_id, $product_status, $regr['sponsor_id'], true);

                $is_pin_ok = $pin_array["is_pin_ok"];
                if (!$is_pin_ok) {
                    $msg = $this->lang->line('Invalid_Epins');
                    $this->redirect($msg, $redirect_url, false);
                }
            } elseif ($active_tab == 'ewallet_tab') {
                $payment_type = 'ewallet';
                $used_amount = $regr['total_amount'];
                $ewallet_user = $reg_post_array['user_name_ewallet'];
                $ewallet_trans_password = base64_decode(urldecode($reg_post_array['tran_pass_ewallet']));
                $admin_username = $this->validation_model->getAdminUsername();
                if ($ewallet_user != "") {
                    if ($this->LOG_USER_TYPE == 'admin' || $this->LOG_USER_TYPE == 'employee') {
                        if ($ewallet_user != $admin_username && $ewallet_user != $regr['sponsor_user_name']) {
                            $msg = $this->lang->line('invalid_user_name_ewallet_tab');
                            $this->redirect($msg, $redirect_url, false);
                        }
                    } else
                        if ($this->LOG_USER_TYPE == 'user') {
                        if ($ewallet_user != $regr['sponsor_user_name'] || $ewallet_user != $this->LOG_USER_NAME) {
                            $msg = $this->lang->line('invalid_user_name_ewallet_tab');
                            $this->redirect($msg, $redirect_url, false);
                        }
                    }
                    $user_available = $this->register_model->isUserAvailable($ewallet_user);
                    if ($user_available) {
                        if ($ewallet_trans_password != "") {
                            $ewallet_user_id = $this->validation_model->userNameToID($ewallet_user);
                            $trans_pass_available = $this->register_model->checkEwalletPassword($ewallet_user_id, $ewallet_trans_password);
                            if ($trans_pass_available == 'yes') {

                                $ewallet_balance_amount = $this->register_model->getBalanceAmount($ewallet_user_id);
                                if ($ewallet_balance_amount >= $used_amount) {
                                    $is_ewallet_ok = true;
                                } else {
                                    $msg = $this->lang->line('insuff_bal');
                                    $this->redirect($msg, $redirect_url, false);
                                }
                            } else {
                                $msg = $this->lang->line('invalid_transaction_password_ewallet_tab');
                                $this->redirect($msg, $redirect_url, false);
                            }
                        } else {
                            $msg = $this->lang->line('invalid_transaction_password_ewallet_tab');
                            $this->redirect($msg,$redirect_url, false);
                        }
                    } else {
                        $msg = $this->lang->line('invalid_user_name_ewallet_tab');
                        $this->redirect($msg, $redirect_url, false);
                    }
                } else {
                    $msg = $this->lang->line('invalid_user_name_ewallet_tab');
                    $this->redirect($msg, $redirect_url, false);
                }
            } elseif (($active_tab == "paypal_tab")) {
                if ($payment_gateway_array['paypal_status'] == "no") {
                    $msg = lang('payment_method_not_available');
                    $this->redirect($msg, $redirect_url, false);
                }
                $payment_type = 'paypal';
                $is_paypal_ok = true;
            } else
                if (($active_tab == "authorize_tab")) {
                if ($payment_gateway_array['authorize_status'] == "no") {
                    $msg = lang('payment_method_not_available');
                    $this->redirect($msg, $redirect_url, false);
                }
                $payment_type = 'authorize.net';
                $is_authorize_ok = true;
            } else
                if (($active_tab == "blockchain_tab")) {
                if ($payment_gateway_array['blockchain_status'] == "no") {
                    $msg = lang('payment_method_not_available');
                    $this->redirect($msg, $redirect_url, false);
                }
                $payment_type = 'blockchain';
                $is_blockchain_ok = true;
            } elseif (($active_tab == "bitgo_tab")) {
                if ($payment_gateway_array['bitgo_status'] == "no") {
                    $msg = lang('payment_method_not_available');
                    $this->redirect($msg, $redirect_url, false);
                }
                $payment_type = 'bitgo';
                $is_bitgo_ok = true;
            } else
                if (($active_tab == "bitcoin_tab")) {
                if ($payment_gateway_array['bitcoin_status'] == "no") {
                    $msg = lang('payment_method_not_available');
                    $this->redirect($msg, $redirect_url, false);
                }
                $payment_type = 'bitcoin';
                $is_bitcoin_ok = true;
            } else
                if (($active_tab == "bank_transfer")) {
                $payment_type = 'bank_transfer';
                $is_bank_transfer_ok = true;
            } else
                if ($active_tab == "payeer_tab") {
                if ($payment_gateway_array['payeer_status'] == "no") {
                    $msg = lang('payment_method_not_available');
                    $this->redirect($msg, $redirect_url, false);
                }
                $payment_type = 'payeer';
                $is_payeer_ok = true;
            } else
                if ($active_tab == "sofort_tab") {
                if ($payment_gateway_array['sofort_status'] == "no") {
                    $msg = lang('payment_method_not_available');
                    $this->redirect($msg, $redirect_url, false);
                }
                $payment_type = 'sofort';
                $is_sofort_ok = true;
            } else
                if ($active_tab == "squareup_tab") {
                if ($payment_gateway_array['squareup_status'] == "no") {
                    $msg = lang('payment_method_not_available');
                    $this->redirect($msg, $redirect_url, false);
                }
                $payment_type = 'squareup';
                $is_squareup_ok = true;
            } else
                if ($active_tab == "free_join_tab") {
                $payment_type = 'free_join';
                $is_free_join_ok = true;
            } else {
                $msg = lang('please_choose_a_payment_method');
                $this->redirect($msg, $redirect_url, false);
            }

            $regr['payment_type'] = $payment_type;

            $pending_signup_status = $this->configuration_model->getPendingSignupStatus($payment_type);

            if ($is_pin_ok) {
                $this->register_model->begin();
                $regr['by_using'] = 'pin';
                $res = $this->register_model->UpdateUsedUserEpin($pin_array, $pin_count);
                $status = $this->register_model->confirmRegister($regr, $module_status, $pending_signup_status);
                if ($status['status']) {
                    $pin_array['user_id'] = $status['id'];
                    $res = $this->register_model->UpdateUsedEpin($pin_array, $pin_count);
                    if ($res) {
                        $this->register_model->insertUsedPin($pin_array, $pin_count, $pending_signup_status);
                        $payment_status = true;
                    }
                }
            } elseif ($is_ewallet_ok) {
                $this->register_model->begin();
                $regr['by_using'] = 'ewallet';
                $status = $this->register_model->confirmRegister($regr, $module_status, $pending_signup_status);
                if ($status['status']) {
                    $user_id = $status['id'];
                    $used_user_id = $this->validation_model->userNameToID($ewallet_user);
                    $transaction_id = $this->ewallet_model->getUniqueTransactionId();
                    $res1 = $this->register_model->insertUsedEwallet($used_user_id, $user_id, $used_amount, $transaction_id, $pending_signup_status);
                    if ($res1) {
                        $res2 = $this->register_model->deductFromBalanceAmount($used_user_id, $used_amount);
                        if ($res2) {
                            $payment_status = true;
                        }
                    }
                }
            } elseif ($is_paypal_ok) {
                $regr['by_using'] = 'paypal';
                $this->session->set_userdata('inf_regr', $regr);
                $msg = "";
                if($by_replica) {
                    $link  = 'register/replica_pay_now';
                } else {
                    $link  = 'register/pay_now';
                }
                $this->redirect($msg, $link, false);
            } elseif ($is_authorize_ok) {
                $regr['by_using'] = 'Authorize.Net';
                $this->session->set_userdata('inf_regr', $regr);
                $msg = "";
                if($by_replica) {
                    $link  = 'register/replica_authorizeNetPayment';
                } else {
                    $link  = 'register/authorizeNetPayment';
                }
                $this->redirect($msg, $link, false);
            } elseif ($is_blockchain_ok) {
                $regr['by_using'] = 'blockchain';
                $this->session->set_userdata('inf_regr', $regr);
                $msg = "";
                if($by_replica) {
                    $link  = 'register/replica_blockchain';
                } else {
                    $link  = 'register/blockchain';
                }
                $this->redirect($msg, "register/blockchain", false);
            } elseif ($is_bitgo_ok) {
                $regr['by_using'] = 'bitgo';
                $regr['is_new'] = 'yes';
                $this->session->set_userdata('inf_regr', $regr);
                $msg = "";
                if($by_replica) {
                    $link  = 'register/replica_bitgo_gateway';
                } else {
                    $link  = 'register/bitgo_gateway';
                }
                $this->redirect($msg, $link, false);
            } elseif ($is_bitcoin_ok) {
                $regr['by_using'] = 'bitcoin';
                $this->session->set_userdata('inf_regr', $regr);
                $msg = "";
                if($by_replica) {
                    $link  = 'register/replica_bitcoin_payment';
                } else {
                    $link  = 'register/bitcoin_payment';
                }
                $this->redirect($msg, $link, false);
            } elseif ($is_payeer_ok) {
                $regr['by_using'] = 'payeer';
                $data = array(
                    'user_id' => $this->LOG_USER_ID,
                    'product_id' => $product_id,
                    'product_name' => $product_name,
                    'product_amount' => $product_amount,
                    'currency' => 'EUR',
                );
                $msg = "";
                $this->session->set_userdata('payeer_data', $data);
                if($by_replica) {
                    $link  = 'register/replica_payeer';
                } else {
                    $link  = 'register/payeer';
                }
                $this->redirect($msg, $link, false);
            } elseif ($is_sofort_ok) {
                $regr['by_using'] = 'sofort';
                $this->session->set_userdata('inf_regr', $regr);
                $msg = "";
                if($by_replica) {
                    $link  = 'register/replica_sofort_payment';
                } else {
                    $link  = 'register/sofort_payment';
                }
                $this->redirect($msg, $link, false);
            } elseif ($is_squareup_ok) {
                $regr['by_using'] = 'squareup';
                $this->session->set_userdata('inf_regr', $regr);
                $msg = "";
                if($by_replica) {
                    $link  = 'register/replica_squareup_gateway';
                } else {
                    $link  = 'register/squareup_gateway';
                }
                $this->redirect($msg, $link, false);
            } elseif ($is_bank_transfer_ok) {

                $regr['by_using'] = 'bank_transfer';
                $this->register_model->begin();

                $status = $this->register_model->confirmRegister($regr, $module_status, $pending_signup_status);
                if ($status['status']) {
                    $payment_status = true;
                }
            } else {
                $regr['by_using'] = 'free join';

                $this->register_model->begin();
                $status = $this->register_model->confirmRegister($regr, $module_status, $pending_signup_status);  ;
                if ($status['status']) {
                 
                    $payment_status = true;
                }
            }

            $msg = '';
            if ($payment_status) {
                $user_name = $status['user_name'];
                $user_id = $status['user_id'];
                $transaction_password = $pending_signup_status ? '' : $status['transaction_password'];

                if ($product_status == "yes") {
                    $insert_into_sales = $this->register_model->insertIntoSalesOrder($user_id, $regr['product_id'], $payment_type, $pending_signup_status);
                }

                $this->register_model->commit();

                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'New user registered', $user_id);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'user_register', 'New user registered', $pending_signup_status);
                }
                //

                $this->session->unset_userdata(['inf_regr','inf_reg_post_array','from_replica']);

                $id_encode = $this->encrypt->encode($user_name);
                $id_encode = str_replace("/", "_", $id_encode);
                $user_name_encrypt = urlencode($id_encode);
                if ($pending_signup_status) {

                    $this->session->unset_userdata('file');

                    $msg = "<span><b>" . lang('registration_completed_successfully_pending') . "!</b> " . lang("User_Name") . ": {$user_name}";
                } else {
                    $this->session->unset_userdata('file');
                    $msg = "<span><b>" . lang('registration_completed_successfully') . "!</b> " . lang("User_Name") . ": {$user_name} " . lang("transaction_password") . ": {$transaction_password}</span>";
                }

                if($redirect_url == 'register/replica_register') {
                    $this->redirect($msg, "register/replica_preview/{$user_name_encrypt}", true);
                } else {
                    $this->redirect($msg, "register/preview/{$user_name_encrypt}", true);
                }

            } else {
                $this->register_model->rollback();
                if (isset($status['error'])) {
                    $msg = $status['error'];
                } else {
                    $msg = lang('registration_failed');
                }
                $this->session->unset_userdata(['inf_regr','inf_reg_post_array','file','from_replica']);
                $this->redirect($msg, $redirect_url, false);
            }
        } else {
            $this->session->unset_userdata(['inf_regr','inf_reg_post_array','file','from_replica']);
            $error = $this->form_validation->error_array();
            $this->session->set_userdata('inf_error', $error);

            $msg = $this->lang->line('errors_check');
            $this->redirect($msg, $redirect_url, false);
        }
    }

    function validate_register_submit()
    {
        $product_status = $this->MODULE_STATUS['product_status'];
        $username_config = $this->configuration_model->getUsernameConfig();
        $user_name_type = $username_config["type"];

        $active_tab = $this->input->post('active_tab', true);
        $reg_from_tree = $this->input->post('reg_from_tree', true);
        $pin_count = $this->input->post('pin_count', true);

        $contact_fields = $this->register_model->getSignUpAllFieldStatus();

        $plan_array = array("Unilevel", "Stair_Step");
        if ($reg_from_tree && !in_array($this->MLM_PLAN, $plan_array)) {
            $this->form_validation->set_rules('placement_user_name', lang('placement_user_name'), 'required|callback_validate_username|trim');
        }
        $this->form_validation->set_rules('sponsor_user_name', lang('sponsor_user_name'), 'required|callback_validate_username|trim');

        if ($this->MLM_PLAN == 'Binary') {
            $this->form_validation->set_rules('position', lang('position'), 'trim|required|in_list[L,R]', ['in_list' => lang('you_must_select_your_position')]);
        }

        if ($product_status == "yes") {
            $this->form_validation->set_rules('product_id', lang('product'), 'trim|required|callback_valid_product[registration]');
        }

        if ($user_name_type == 'static') {
            $this->form_validation->set_rules('user_name_entry', lang('User_Name'), 'trim|required|alpha_numeric|min_length[6]|max_length[12]|callback_is_username_available');
        }

        $this->form_validation->set_rules('pswd', lang('password'), 'trim|required|min_length[6]|max_length[32]|callback__alpha_password|matches[cpswd]');
        $this->form_validation->set_rules('cpswd', lang('confirm_password'), 'trim|required|min_length[6]|max_length[32]|callback__alpha_password');

        $this->form_validation->set_rules('first_name', lang('first_name'), 'trim|required|min_length[3]|max_length[32]|callback__alpha_space');
        if ($contact_fields['last_name'] == "yes") {
            $this->form_validation->set_rules('last_name', lang('last_name'), 'trim|min_length[3]|max_length[32]|callback__alpha_space|callback_check_required[last_name]');
        }
        // $this->form_validation->set_rules('year', lang('year'), 'trim|required');
        // $this->form_validation->set_rules('month', lang('month'), 'trim|required');
        // $this->form_validation->set_rules('day', lang('day'), 'trim|required');
        if ($contact_fields['date_of_birth'] == "yes") {
            $this->form_validation->set_rules('date_of_birth', lang('date_of_birth'), 'trim|callback_validate_age_year|callback_check_required[date_of_birth]');
        }
        $this->form_validation->set_rules('email', lang('email'), 'trim|required|valid_email');
        $this->form_validation->set_rules('mobile', lang('mobile_no'), 'trim|required|is_natural|min_length[5]|max_length[10]');
        if ($contact_fields['gender'] == "yes") {
            $this->form_validation->set_rules('gender', lang('gender'), 'trim|callback_check_required[gender]|in_list[M,F]', ['in_list' => lang('You_must_select_gender')]);
        }
        if ($contact_fields['adress_line1'] == "yes") {
            $this->form_validation->set_rules('adress_line1', lang('adress_line1'), 'trim|min_length[3]|max_length[32]|callback_check_required[adress_line1]');
        }
        if ($contact_fields['adress_line2'] == "yes") {
            $this->form_validation->set_rules('adress_line2', lang('adress_line2'), 'trim|min_length[3]|max_length[32]|callback_check_required[adress_line2]');
        }
        if ($contact_fields['country'] == "yes") {
            $this->form_validation->set_rules('country', lang('country'), 'trim|callback_check_required[country]');
        }
        if ($contact_fields['state'] == "yes") {
            $this->form_validation->set_rules('state', lang('state'), 'trim|callback_check_required[state]');
        }
        if ($contact_fields['city'] == "yes") {
            $this->form_validation->set_rules('city', lang('city'), 'trim|required|min_length[3]|max_length[32]|callback__alpha_city_address|callback_check_required[city]');
        }
        if ($contact_fields['pin'] == "yes") {
            $this->form_validation->set_rules('pin', lang('pin'), 'trim|min_length[3]|max_length[10]|is_natural|callback_check_required[pin]');
        }
        if ($contact_fields['land_line'] == "yes") {
            $this->form_validation->set_rules('land_line', lang('land_line'), 'trim|is_natural|min_length[5]|max_length[10]|callback_check_required[land_line]');
        }

        $this->form_validation->set_rules('agree', lang('terms_conditions'), 'trim|required');
        // $this->form_validation->set_message('check_required', lang('the_%s_field_must_be_exactly_10_digit'));
        if ($active_tab == 'epin_tab') {
            $temp_pin_array = "";
            $this->session->set_userdata("inf_temp_pin_array", $temp_pin_array);
            for ($i = 1; $i <= $pin_count; $i++) {
                if ($this->input->post("epin$i")) {
                    $this->form_validation->set_rules("epin$i", lang('epin') . $i, 'trim|required|callback_has_match');
                }
            }
            $this->session->unset_userdata("inf_temp_pin_array");
        }
        if ($active_tab == 'ewallet_tab') {
            $this->form_validation->set_rules('user_name_ewallet', lang('ewallet_user_name'), 'trim|required');
            $this->form_validation->set_rules('tran_pass_ewallet', lang('transaction_password'), 'trim|required');
        }
        if ($active_tab == "bitcoin_tab") {
            $this->form_validation->set_rules('bitcoin_address', lang('bitcoin_address'), 'trim|required|xss_clean');
            //$this->form_validation->set_message('validate_bitcoin', lang('invalid_bitcoin_address'));
        }

        $this->form_validation->set_message('exact_length', lang('the_%s_field_must_be_exactly_10_digit'));
        $this->form_validation->set_message('validate_username', lang('the_sponsor_username_is_not_available'));
        $this->form_validation->set_message('is_username_available', lang('the_username_is_not_available'));

        $validation_status = $this->form_validation->run();
        return $validation_status;
    }

    function valid_product($product_id, $type)
    {
        $res = $this->product_model->isActiveProduct($product_id, $type);
        $this->form_validation->set_message('valid_product', lang('you_must_select_product'));
        return ($res > 0);
    }

    function validate_username($ref_user = '')
    {
        $crowd_stat = ($this->validation_model->getModuleStatusByKey('crowd_fund') == "yes") ? true : false;
        if ($ref_user != '') {
            $flag = false;
            if ($this->register_model->isUserAvailable($ref_user)) {
                $flag = true;
                return $flag;
            }

            if ($crowd_stat) {
                $flag = $this->validation_model->isMemberAvailable($ref_user);
            }
            return $flag;
        } else {
            $echo = 'no';
            $username = ($this->input->post('username', true));

            if ($this->register_model->isUserAvailable($username)) {
                $echo = "yes";
            }

            if ($crowd_stat) {
                if ($this->validation_model->isMemberAvailable($username)) {
                    $echo = "yes";
                }
            }
            echo $echo;
            exit();
        }
    }

    function check_leg_availability()
    {
        $echo = 'no';
        if ($this->input->post('sponsor_leg') && $this->input->post('sponsor_user_name')) {
            if ($this->register_model->checkLeg($this->input->post('sponsor_leg'), $this->input->post('sponsor_user_name'), $this->LOG_USER_TYPE, $this->LOG_USER_ID)) {
                $echo = "yes";
            }
        }
        echo $echo;
        exit();
    }

    function get_sponsor_full_name()
    {
        $username = ($this->input->post('sponsor_user_name', true));
        $user_id = $this->validation_model->userNameToID($username);
        $referral_name = $this->register_model->getReferralName($user_id);
        $crowd_stat = ($this->validation_model->getModuleStatusByKey('crowd_fund') == "yes") ? true : false;
        if ($crowd_stat && !$referral_name) {
            $user_id = $this->validation_model->memberUserNameToID($username);
            $referral_name = $this->validation_model->getReferralNameMember($user_id);
        }
        echo $referral_name;
        exit();
    }

    function get_total_registration_fee()
    {
        $product_id = $this->input->post('product_id', true);
        $product_amount = 0;
        if ($product_id) {
            $product_amount = $this->register_model->getProductAmount($product_id);
        }
        $registration_fee = $this->register_model->getRegisterAmount();

        $total_fee = $product_amount + $registration_fee;

        echo "$registration_fee==$product_amount==$total_fee";
        exit();
    }

    function checkPassAvailability()
    {

        if ($this->register_model->checkPassCode($this->input->post('prodcutpin'), $this->input->post('prodcutid'))) {
            echo "yes";
            exit();
        } else {
            echo "no";
            exit();
        }
    }

    function checkSponsorAvailability()
    {

        if ($this->register_model->checkSponser($this->input->post('sponser_name'), $this->input->post('user_id'))) {
            echo "yes";
            exit();
        } else {
            echo "no";
            exit();
        }
    }

    function get_states($country_id)
    {
        $state_select = '';

        $state_string = $this->country_state_model->viewState($country_id);
        if ($state_string != '') {
            $state_select .= "<option value =''>" . $this->lang->line('select_state') . "</option>";
            $state_select .= $state_string;
        } else {
            $state_select .= "<option value='0'>" . $this->lang->line('no_data_available') . "</option>";
        }
        $state_select .= '</select></div>';
        echo $state_select;
        exit();
    }

    function get_phone_code($country_id)
    {
        $country_telephone_code = $this->country_state_model->getCountryTelephoneCode($country_id);
        echo "+$country_telephone_code";
    }

    function preview($user_name = "")
    {

        $from_replica = FALSE;
        if ($this->uri->segment(1) == 'replica_preview') {
            $from_replica = TRUE;
            $replica_lang = $this->session->userdata('replica_language');
            if($replica_lang) {
                $this->lang->load($this->CURRENT_CTRL, $replica_lang['lang_name_in_english']);
            }
        }

        $title = lang('letter_preview');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = "register_downline";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('letter_preview');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('letter_preview');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_name = urldecode($user_name);
        $user_name = str_replace("_", "/", $user_name);
        $user_name = $this->encrypt->decode($user_name);
        $user_id = $this->validation_model->userNameToID($user_name);
        $is_pending_registration = $this->validation_model->isPendingUserRegistration($user_name);
        if (!$user_id && !$is_pending_registration) {
            $this->redirect("Invalid User Details.", "home", false);
        }

        if (DEMO_STATUS == 'no' && $this->check_replica_user()) {
            $replica_session = $this->inf_model->getReplicaSessionFromFile();
            $replica_user = $replica_session['replica_user'];
            $sponsor_user_name = $replica_user['user_name'];
            $this->set("sponsor_user_name", $sponsor_user_name);
        }

        $user_type = $this->LOG_USER_TYPE;
        if ($this->MODULE_STATUS['footer_demo_status'] == "yes") {
            $admin_user_name = $this->ADMIN_USER_NAME;
            $this->set("admin_user_name", $admin_user_name);
        }
        if ($user_type == "employee") {
            $user_type = 'admin';
        }

        $date = date('Y-m-d H:i:s');
        $lang_id = $this->LANG_ID;
        $letter_arr = $this->configuration_model->getLetterSetting($lang_id);
        $site_configuration = $this->validation_model->getSiteInformation();
        $product_status = $this->MODULE_STATUS['product_status'];
        $referal_status = $this->MODULE_STATUS['referal_status'];

        if ($is_pending_registration) {
            $user_registration_details = $this->register_model->getUserRegistrationDetailsForPreview(0, $user_name);
            $product_id = $user_registration_details['product_id'];
        } else {
            $user_registration_details = $this->register_model->getUserRegistrationDetailsForPreview($user_id);
            $father_id = $this->validation_model->getFatherId($user_id);
            $product_id = $this->validation_model->getProductId($user_id);
            $placement_user_name = $this->validation_model->IdToUserName($father_id);
            $this->set("placement_user_name", $placement_user_name);
        }

        $reg_amount = $this->register_model->getRegisterAmount();
        if ($product_status == "yes") {
            $product_details = $this->register_model->getProduct($product_id);
            $this->set("product_details", $product_details);
            $this->set("product_status", $product_status);
        }

        if ($referal_status == "yes") {
            $sponsor_id = $user_registration_details['sponsor_id'];
            $sponsorname = $this->validation_model->IdToUserName($sponsor_id);
            $this->set("sponsorname", $sponsorname);
            $this->set("referal_status", $referal_status);
        }

        $user_name_encrypt = $this->encrypt->encode($user_name);
        $user_name_encrypt_replace = str_replace("/", "_", $user_name_encrypt);
        $user_name_encrypted = urlencode($user_name_encrypt_replace);

        $pdf_file_to_download = $user_name . ".pdf";

        $this->set("date", $date);
        $this->set("user_name", $user_name);
        $this->set("user_name_encrypted", $user_name_encrypted);
        $this->set("user_type", $user_type);
        $this->set("letter_arr", $letter_arr);
        $this->set("site_configuration", $site_configuration);
        $this->set("reg_amount", $reg_amount);
        $this->set("product_status", $product_status);
        $this->set("referal_status", $referal_status);
        $this->set("user_registration_details", $this->security->xss_clean($user_registration_details));
        $this->set("pdf_file_to_download", $pdf_file_to_download);
        $this->set("is_pending_registration", $is_pending_registration);
        $this->set("from_replica", $from_replica);
        $this->setView();
    }

    function checkBalanceAvailable()
    {
        $ewallet_user = $this->input->post('user_name', true);
        $balance = $this->input->post('balance', true);
        $user_name_ewallet = $this->validation_model->userNameToID($ewallet_user);
        $user_bal_amount = $this->register_model->getBalanceAmount($user_name_ewallet, $balance);
        echo $user_bal_amount;
    }

    function check_ewallet_balance()
    {
        $status = "no";
        $ewallet_user = $this->input->post('user_name', true);
        $ewallet_pass = $this->input->post('ewallet', true);
        $product_id = $this->input->post('product_id', true);
        $sponsor_user_name = $this->input->post('sponsor_username', true);
        $admin_username = $this->validation_model->getAdminUsername();
        if ($this->LOG_USER_TYPE == 'admin' || $this->LOG_USER_TYPE == 'employee') {
            if ($ewallet_user != $admin_username && $ewallet_user != $sponsor_user_name) {
                $status = "invalid";
                echo $status;
                exit();
            }
        }
        if ($this->LOG_USER_TYPE == 'user') {
            if ($ewallet_user != $sponsor_user_name && $ewallet_user != $this->LOG_USER_NAME) {
                $status = "invalid";
                echo $status;
                exit();
            }
        }
        $user_id = $this->validation_model->userNameToID($ewallet_user);
        if ($user_id) {
            $user_password = $this->register_model->checkEwalletPassword($user_id, $ewallet_pass);

            if ($user_password == 'yes') {
                $user_bal_amount = $this->register_model->getBalanceAmount($user_id);
                if ($user_bal_amount > 0) {
                    $reg_amount = $this->register_model->getRegisterAmount();
                    $product_amount = 0;
                    $product_status = $this->MODULE_STATUS['product_status'];
                    if ($product_status == "yes") {
                        $product_details = $this->register_model->getProduct($product_id);
                        $product_amount = $product_details["product_value"];
                    }
                    $total_amount = $reg_amount + $product_amount;

                    if ($user_bal_amount >= $total_amount) {
                        $status = "yes";
                    }
                }
            } else {
                $status = "invalid";
            }
        } else {
            $status = "invalid";
        }
        echo $status;
        exit();
    }

    function getRegisterAmount()
    {
        $res = $this->register_model->getRegisterAmount();
        echo $res;
    }

    /* form validation rule*
     *    Method is used to validate strings to allow alpha
     *    numeric spaces underscores and dashes ONLY.
     *    @param $str    String    The item to be validated.
     *    @return BOOLEAN   True if passed validation false if otherwise.
     */

    public function _alpha_space($str = '')
    {
        if (!$str) {
            return true;
        }
        $res = (bool)preg_match('/^[A-Z ]*$/i', $str);
        if (!$res) {
            $this->form_validation->set_message('_alpha_space', lang('only_alpha_space'));
        }
        return $res;
    }

    function has_match($post_epin)
    {
        $flag = false;
        $temp_pin_array = $this->session->userdata("inf_temp_pin_array");
        $split_arr = explode("==", $temp_pin_array);

        if (!in_array($post_epin, $split_arr)) {
            $temp_pin_array .= "==$post_epin";
            $this->session->set_userdata("inf_temp_pin_array", $temp_pin_array);
            $flag = true;
        }

        return $flag;
    }

    function _alpha_city_address($str_in = '')
    {
        if (!preg_match("/^([a-zA-Z0-9\s\.\,\-])*$/i", $str_in)) {
            $this->form_validation->set_message('_alpha_city_address', lang('city_field_characters'));
            return false;
        } else {
            return true;
        }
    }

    function _alpha_password($str_in = '')
    {
        if (!preg_match("/^[0-9a-zA-Z\s\r\n@!#\$\^%&*()+=\-\[\]\\\';,\.\/\{\}\|\":<>\?\_\`\~]+$/i", $str_in)) {
            $this->form_validation->set_message('_alpha_password', lang('password_characters_allowed'));
            return false;
        } else {
            return true;
        }
    }

    public function validate_age($dob)
    {
        if (!$this->input->post('year') || $this->input->post('month') < 0 || !$this->input->post('day')) {
            return true;
        }
        $age_limit = $this->configuration_model->getAgeLimitSetting();
        if ($age_limit == 0) {
            return true;
        }
        $date1 = new DateTime($dob);
        $date1->add(new DateInterval("P{$age_limit}Y"));
        $date2 = new DateTime();
        if ($date1 <= $date2) {
            return true;
        } else {
            $this->form_validation->set_message('validate_age', sprintf(lang('You_should_be_atleast_n_years_old'), $age_limit));
            return false;
        }
    }

    public function check_required($field_value, $field_name)
    {
        $status = $this->register_model->getRequiredStatus($field_name);
        if ($status == 'yes') {
            if($field_value =='') {
                $this->form_validation->set_message('check_required', sprintf(lang('the_n_field_is_required'), lang($field_name)));
                return false;
            }
            else
                return true;
        } else {
            return true;
        }
    }

    public function validate_age_year($dob)
    {
        if (!$this->input->post('year') || $this->input->post('month') < 0 || !$this->input->post('day')) {
            return true;
        }
        $age_limit = $this->configuration_model->getAgeLimitSetting();
        if ($age_limit == 0) {
            return true;
        }
        $year = date('Y', strtotime($dob));
        $current_year = date('Y');
        if (($current_year - $year) >= $age_limit) {
            return true;
        } else {
            $this->form_validation->set_message('validate_age_year', sprintf(lang('You_should_be_atleast_n_years_old'), $age_limit));
            return false;
        }
    }

    public function ajax_is_username_available()
    {
        $user_name = $this->input->post('user_name', true);
        if (!$user_name) {
            echo 'no';
            exit();
        }
        $is_username_exists = $this->validation_model->isUsernameExists($user_name);
        if ($is_username_exists) {
            echo 'no';
            exit();
        } else {
            echo 'yes';
            exit();
        }
    }

    public function is_username_available($user_name)
    {
        if (!$user_name) {
            return false;
        }
        $is_username_exists = $this->validation_model->isUsernameExists($user_name);
        if ($is_username_exists) {
            return false;
        } else {
            return true;
        }
    }

    //////////code for ADD ON////////////////////////////////////////////////////

    function pay_now()
    {
        require_once 'Paypal.php';
        $paypal = new Paypal;
        $regr = $this->session->userdata("inf_regr");

        $product_status = $regr["product_status"];
        $product_name = $regr["product_name"];
        $product_amount = round($regr["product_amount"]);
        $reg_amount = $regr["reg_amount"];

        $paypal_details = $this->configuration_model->getPaypalConfigDetails();
        //$paypal_currency_code = $paypal_details['currency'];
        $paypal_currency_code = "USD";
        $paypal_currency_left_symbol = "$";
        $paypal_currency_right_symbol = "";

        $default_currency_code = ($this->DEFAULT_CURRENCY_CODE != '') ? $this->DEFAULT_CURRENCY_CODE : "USD";
        $default_currency_left_symbol = ($this->DEFAULT_SYMBOL_LEFT != '') ? $this->DEFAULT_SYMBOL_LEFT : "$";
        $default_currency_right_symbol = ($this->DEFAULT_SYMBOL_RIGHT != '') ? $this->DEFAULT_SYMBOL_RIGHT : "";

        // $product_amount = round($product_amount * $this->DEFAULT_CURRENCY_VALUE, 8);
        // $reg_amount = round($reg_amount * $this->DEFAULT_CURRENCY_VALUE, 8);


        //        $usd_conevrsion_rate = $this->currency_model->getCurrencyConversionRate($default_currency_code, $paypal_currency_code);
        $usd_conevrsion_rate = 1;
        $product_amount = round($product_amount * $usd_conevrsion_rate, 8);
        $reg_amount = round($reg_amount * $usd_conevrsion_rate, 8);
        $total_amount = round($product_amount + $reg_amount, 8);

        $description = "New Membership to " . $this->COMPANY_NAME;
        $description .= "\nMembership Fee : $paypal_currency_left_symbol $reg_amount $paypal_currency_right_symbol";
        if ($product_status == "yes") {
            $description .= ", $product_name : $paypal_currency_left_symbol $product_amount $paypal_currency_right_symbol";
        }
        $base_url = base_url();
        $params = array(
            'amount' => $total_amount,
            'item' => "New Membership",
            'description' => $description,
            'currency' => $paypal_currency_code,
            'return_url' => $base_url . $paypal_details['return_url'],
            'cancel_url' => $base_url . $paypal_details['cancel_url']
        );
        $response = $paypal->initilize($params);
    }

    function payment_success()
    {
        require_once 'Paypal.php';
        $paypal = new Paypal;
        $pending_signup_status = $this->configuration_model->getPendingSignupStatus('paypal');
        $inf_reg = $this->session->userdata("inf_regr");
        $p_id = $inf_reg["product_id"];

        if(!empty($this->session->userdata('from_replica'))) {
            $redirect_url = "replica/replica_register";
        } else {
            $redirect_url = "register/user_register";
        }

        $product_amount = $this->register_model->getProductAmount($p_id);
        $register_amount = $this->register_model->getRegisterAmount();
        $product_amount = round($product_amount * $this->DEFAULT_CURRENCY_VALUE, 8);
        $register_amount = round($register_amount * $this->DEFAULT_CURRENCY_VALUE, 8);

        $paypal_currency_code = "USD";
        $paypal_currency_left_symbol = "$";
        $paypal_currency_right_symbol = "";

        $default_currency_code = ($this->DEFAULT_CURRENCY_CODE != '') ? $this->DEFAULT_CURRENCY_CODE : "USD";
        $default_currency_left_symbol = ($this->DEFAULT_SYMBOL_LEFT != '') ? $this->DEFAULT_SYMBOL_LEFT : "$";
        $default_currency_right_symbol = ($this->DEFAULT_SYMBOL_RIGHT != '') ? $this->DEFAULT_SYMBOL_RIGHT : "";

        //$usd_conevrsion_rate = $this->currency_model->getCurrencyConversionRate($default_currency_code, $paypal_currency_code);
        $usd_conevrsion_rate = 1;
        $product_amount = round($product_amount * $usd_conevrsion_rate, 8);
        $register_amount = round($register_amount * $usd_conevrsion_rate, 8);

        $total_amount = round($product_amount + $register_amount);

        $paypal_details = $this->configuration_model->getPaypalConfigDetails();
        $base_url = base_url();
        $params = array(
            'amount' => $total_amount,
            'currency' => $paypal_details['currency'],
            'return_url' => $base_url . $paypal_details['return_url'],
            'cancel_url' => $base_url . $paypal_details['cancel_url']
        );
        $response = $paypal->callback($params);
        if ($response->success()) {
            $paypal_output = $this->input->get();
            $regr = $this->session->userdata('inf_regr');
            $referral_id = $regr["sponsor_id"];
            $payment_details = array(
                'payment_method' => 'paypal',
                'token_id' => $paypal_output['token'],
                'currency' => $paypal_details['currency'],
                'amount' => $total_amount,
                'acceptance' => '',
                'payer_id' => $paypal_output['PayerID'],
                'user_id' => $referral_id,
                'status' => '',
                'card_number' => '',
                'ED' => '',
                'card_holder_name' => '',
                'submit_date' => date("Y-m-d H:i:s"),
                'pay_id' => '',
                'error_status' => '',
                'brand' => ''
            );

            $this->register_model->insertintoPaymentDetails($payment_details);
            $module_status = $this->MODULE_STATUS;
            $regr['by_using'] = 'paypal';

            $this->register_model->begin();
            $status = $this->register_model->confirmRegister($regr, $module_status, $pending_signup_status);

            $msg = '';
            if ($status['status']) {
                $user_name = $status['user_name'];
                $user_id = $status['user_id'];
                $transaction_password = $pending_signup_status ? '' : $status['transaction_password'];

                $payment_method = "paypal";
                $product_status = $this->MODULE_STATUS['product_status'];
                if ($product_status == "yes") {
                    $insert_into_sales = $this->register_model->insertIntoSalesOrder($user_id, $regr['product_id'], $payment_method, $pending_signup_status);
                }

                $this->register_model->commit();

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'user_register', 'New User Registered', $pending_signup_status);
                }
                //
                $this->session->unset_userdata(['inf_regr','inf_reg_post_array','from_replica']);

                $id_encode = $this->encrypt->encode($user_name);
                $id_encode = str_replace("/", "_", $id_encode);
                $user_name_encrypt = urlencode($id_encode);
                if ($pending_signup_status) {
                    $msg = "<span><b>" . lang('registration_completed_successfully_pending') . "!</b> " . lang("User_Name") . ": {$user_name}";
                } else {
                    $msg = "<span><b>" . lang('registration_completed_successfully') . "!</b> " . lang("User_Name") . ": {$user_name} " . lang("transaction_password") . ": {$transaction_password}</span>";
                }

                $this->redirect($msg, "register/preview/{$user_name_encrypt}", true);
            } else {
                $this->register_model->rollback();
                $msg = lang('registration_failed');
                $this->redirect($msg, $redirect_url, false);
            }
        } else {
            $msg = 'Payment Failed';
            $this->redirect($msg, $redirect_url, false);
        }
    }

    function check_epin_validity()
    {
        $input = file_get_contents('php://input');
        $jsonData = json_decode($input, true);
        $product_id = $jsonData['product_id'];
        $pin_details = $jsonData['pin_array'];
        $product_status = $this->MODULE_STATUS["product_status"];
        $sponsor_name = $jsonData['sponsor_name'];
        $sponsor_id = $this->validation_model->userNameToID($sponsor_name);
        $flag = false;
        if ($sponsor_name != '') {
            if ($this->register_model->isUserAvailable($sponsor_name)) {
                $flag = true;
            }
        }
        if ($flag) {
            $pin_array = $this->register_model->checkAllEpins($pin_details, $product_id, $product_status, $sponsor_id);
            $value = json_encode($pin_array);
            echo $value;
            exit();
        }
    }

    function authorizeNetPayment()
    {
        if (!empty($this->session->userdata('replica_language'))) {
            $replica_lang = $this->session->userdata('replica_language');
            $this->lang->load($this->CURRENT_CTRL, $replica_lang['lang_name_in_english']);
        }

        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('authorize_authentication');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('authorize_authentication');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('authorize_authentication');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $inf_regr = $this->session->userdata("inf_regr");
        $p_id = $inf_regr["product_id"];
        $product_amount = $this->register_model->getProductAmount($p_id);
        $register_amount = $this->register_model->getRegisterAmount();
        $total_amount = $product_amount + $register_amount;

        $this->load->model('authorizeNetPayment_model');
        $merchant_details = $this->authorizeNetPayment_model->getAuthorizeDetails();
        $api_login_id = $merchant_details['merchant_id'];
        $transaction_key = $merchant_details['transaction_key'];
        $fp_timestamp = time();
        $fp_sequence = "123" . time(); // Enter an invoice or other unique number.
        $fingerprint = $this->authorizeNetPayment_model->authorizePay($api_login_id, $transaction_key, $total_amount, $fp_sequence, $fp_timestamp);

        $this->set('user_type', $this->LOG_USER_TYPE);
        $this->set('api_login_id', $api_login_id);
        $this->set('transaction_key', $transaction_key);
        $this->set('amount', $total_amount);
        $this->set('fp_timestamp', $fp_timestamp);
        $this->set('fingerprint', $fingerprint);
        $this->set('fp_sequence', $fp_sequence);

        $this->setView();
    }

    public function bitcoin_payment()
    {
        /*
         * Install these libraries :
         sudo apt-get install libgmp-dev
         sudo apt-get install php5-gmp
         sudo service apache2 restart
         */
        require_once 'Blocktrail.php';
        $blocktrail = new Blocktrail;

        if(!empty($this->session->userdata('from_replica'))) {
            $replica_lang = $this->session->userdata('replica_language');
            if($replica_lang) {
                $this->lang->load($this->CURRENT_CTRL, $replica_lang['lang_name_in_english']);
            }
            $redirect_url = "register/replica_register";
        } else {
            $redirect_url = "register/user_register";
        }

        if (empty($this->session->userdata('inf_regr'))) {
            $msg = lang('you_cant_go_to_payment_page_directly_without_filling_all_registration_fields');
            $this->redirect($msg, $redirect_url, false);
        }
        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('blocktrail_payment');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "blocktrail_payment";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('blocktrail_payment');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('blocktrail_payment');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        //-----amount conversion
        $currency = 'USD';
        $bitcoin_price = $blocktrail->bitcoinRate($currency);
        $this->session->set_userdata('bitcoin_price', $bitcoin_price);
        //end-----amount conversion

        $regr_data = $this->session->userdata('inf_regr');
        $bitcoin_id = $this->register_model->bitcoinHistory($regr_data['user_name_entry'], $regr_data, 'registration');
        $this->session->set_userdata('bitcoin_id', $bitcoin_id);

        $inf_regr =  $this->session->userdata("inf_regr");
        $product_id = $inf_regr["product_id"];
        $product_amount = $this->register_model->getProductAmount($product_id);
        $register_amount = $this->register_model->getRegisterAmount();
        //$total_amount = round((floatval($product_amount + $register_amount) / $this->DEFAULT_CURRENCY_VALUE), 8);
        $total_amount = 1;
        $this->session->set_userdata('total_amount', $total_amount);

        $bitcoin_amount = $total_amount / $bitcoin_price;

        $this->session->set_userdata('bitcoin_amount', $bitcoin_amount);
        $this->set('bitcoin_amount', round($bitcoin_amount, 8));
        $qr_btc_amount = round($bitcoin_amount, 8);

        $data = $blocktrail->generateAddress($qr_btc_amount);
        if ($data['status']) {
            $this->set('bitcoin_address', $data['bitcoin_address']);
            $this->set('qr_code', $data['qr_code']);
            $this->setView();
        } else {
            $msg = $data['msg'];
            $this->redirect($msg, $redirect_url, false);
        }
    }

    public function bitcoin_response()
    {
        require_once 'Blocktrail.php';
        $blocktrail = new Blocktrail;
        $status = "no";

        if (isset($_POST)) {
            $bitcoin_address = $_POST['bitcoin_address'];
            $response = $blocktrail->getResponse($bitcoin_address);
            if ($response['data']) {
                foreach ($response['data'][0]['outputs'] as $value) {
                    if ($value['address'] == $bitcoin_address) {
                        $satoshi = $value['value'];
                    }
                }
                if ($satoshi > 0) {
                    $this->register_model->insertInToBitcoinPaymentProcessDetails($this->session->userdata('inf_regr'), "Amount Paid", $this->LOG_USER_ID);
                    $status = "yes";
                } else {
                    $status = "no";
                }
            } else {
                $status = "no";
            }
        } else {
            $this->register_model->insertInToBitcoinPaymentProcessDetails($this->session->userdata('inf_regr'), "No Post Data", $this->LOG_USER_ID);
            $status = "no_post_data";
        }
        echo $status;
        exit();
    }

    public function bitcoin_registration()
    {
        require_once 'Blocktrail.php';
        $blocktrail = new Blocktrail;
        $pending_signup_status = $this->configuration_model->getPendingSignupStatus('bitcoin');
        $satoshi = "";
        $bitcoin_address = $this->session->userdata('bitcoin_address');
        $paid_amount = $this->session->userdata('bitcoin_amount');
        $response = $blocktrail->getResponse($bitcoin_address);

        if(!empty($this->session->userdata('from_replica'))) {
            $redirect_url = "register/replica_register";
        } else {
            $redirect_url = "register/user_register";
        }

        if ($response['data']) {
            foreach ($response['data'][0]['outputs'] as $value) {
                if ($value['address'] == $bitcoin_address) {
                    $satoshi = $value['value'];
                }
            }
            $transaction = $response['data'][0]['hash'];
            $return_address = $response['data'][0]['outputs'][0]['address'];
            $response_amount = number_format(($satoshi) * (pow(10, -8)), 8, '.', '');
            if (round($response_amount, 8) >= round($paid_amount, 8)) {
                if ($this->session->userdata('inf_regr')) {

                    $regr = $this->session->userdata('inf_regr');
                    $product_status = $this->MODULE_STATUS['product_status'];
                    $module_status = $this->MODULE_STATUS;

                    $this->register_model->begin();
                    $status = $this->register_model->confirmRegister($regr, $module_status, $pending_signup_status);

                    if ($status['status']) {

                        $this->register_model->commit();

                        $user_name = $status['user_name'];
                        $user_id = $status['user_id'];
                        $transaction_password = $pending_signup_status ? '' : $status['transaction_password'];
                        $payment_method = 'bitcoin';

                        $total_amount = $this->session->userdata('total_amount');
                        $bitcoin_id = $this->session->userdata('bitcoin_id');
                        $current_bitcoin_value = $this->session->userdata('bitcoin_price');
                        $result = $this->register_model->insertInToBitcoinPaymentDetails($bitcoin_id, $user_id, 'registration', $total_amount, $current_bitcoin_value, $paid_amount, $response_amount, $bitcoin_address, $transaction, $return_address, $pending_signup_status);
                        $result = $this->register_model->updateBitcoinHistory($user_id, $bitcoin_id, 'yes');

                        $this->session->unset_userdata('bitcoin_id');

                        if ($product_status == "yes") {
                            $insert_into_sales = $this->register_model->insertIntoSalesOrder($user_id, $regr['product_id'], $payment_method, $pending_signup_status);
                        }

                        // Employee Activity History
                        if ($this->LOG_USER_TYPE == 'employee') {
                            $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'user_register', 'New User Registered', $pending_signup_status);
                        }
                        //
                         $this->session->unset_userdata(['inf_regr','inf_reg_post_array','from_replica']);

                        $id_encode = $this->encrypt->encode($user_name);
                        $id_encode = str_replace("/", "_", $id_encode);
                        $user_name_encrypt = urlencode($id_encode);
                        if ($pending_signup_status) {
                            $msg = "<span><b>" . lang('registration_completed_successfully_pending') . "!</b> " . lang("User_Name") . ": {$user_name}";
                        } else {
                            $msg = "<span><b>" . lang('registration_completed_successfully') . "!</b> " . lang("User_Name") . ": {$user_name} " . lang("transaction_password") . ": {$transaction_password}</span>";
                        }

                        $this->redirect($msg, "register/preview/{$user_name_encrypt}", true);
                    } else {
                        $this->register_model->rollback();
                        $result = $this->register_model->insertInToBitcoinPaymentProcessDetails($this->session->userdata('inf_regr'), "confirmRegister failed", $this->LOG_USER_ID);
                        $msg = lang('registration_failed');
                        $this->redirect($msg, $redirect_url, false);
                    }
                } else {
                    $error_data['user_name_entry'] = '';
                    $result = $this->register_model->insertInToBitcoinPaymentProcessDetails($error_data, "No Session Data", $this->LOG_USER_ID);
                    $msg = lang('registration_failed');
                    $this->redirect($msg, $redirect_url, false);
                }
            } else {
                $result = $this->register_model->insertInToBitcoinPaymentProcessDetails($this->session->userdata('inf_regr'), "Amount Missmatch", $this->LOG_USER_ID);
                $this->redirect("Amount Missmatch!!", 'register/bitcoin_payment', false);
            }
        } else {
            $result = $this->register_model->insertInToBitcoinPaymentProcessDetails($this->session->userdata('inf_regr'), "No Response", $this->LOG_USER_ID);
            $msg = lang('registration_failed');
            $this->redirect($msg, $redirect_url, false);
        }
    }

    function payment_done()
    {

        $pending_signup_status = $this->configuration_model->getPendingSignupStatus('authorize.net');

        $response = $this->input->post(null, true);
        $regr = $this->session->userdata('inf_regr');

        if(!empty($this->session->userdata('from_replica'))) {
            $redirect_url = "register/replica_register";
        } else {
            $redirect_url = "register/user_register";
        }

        $product_status = $this->MODULE_STATUS['product_status'];
        $module_status = $this->MODULE_STATUS;
        $this->load->model('authorizeNetPayment_model');
        $insert_id = $this->authorizeNetPayment_model->insertAuthorizeNetPayment($response);

        $this->register_model->begin();
        $status = $this->register_model->ConfirmRegister($regr, $module_status, $pending_signup_status);

        if ($status['status']) {

            $user_name = $status['user_name'];
            $user_id = $status['user_id'];
            $transaction_password = $pending_signup_status ? '' : $status['transaction_password'];
            $payment_method = 'authorize.net';

            $this->authorizeNetPayment_model->updateAuthorizeNetPayment($insert_id, $user_id, $pending_signup_status);

            if ($product_status == "yes") {
                $insert_into_sales = $this->register_model->insertIntoSalesOrder($user_id, $regr['product_id'], $payment_method, $pending_signup_status);
            }

            $this->register_model->commit();
            // Employee Activity History
            if ($this->LOG_USER_TYPE == 'employee') {
                $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'user_register', 'New User Registered', $pending_signup_status);
            }
            //

            $this->session->unset_userdata(['inf_regr','inf_reg_post_array','from_replica']);

            $id_encode = $this->encrypt->encode($user_name);
            $id_encode = str_replace("/", "_", $id_encode);
            $user_name_encrypt = urlencode($id_encode);
            if ($pending_signup_status) {
                $msg = "<span><b>" . lang('registration_completed_successfully_pending') . "!</b> " . lang("User_Name") . ": {$user_name}";
            } else {
                $msg = "<span><b>" . lang('registration_completed_successfully') . "!</b> " . lang("User_Name") . ": {$user_name} " . lang("transaction_password") . ": {$transaction_password}</span>";
            }

            $this->redirect($msg, "register/preview/{$user_name_encrypt}", true);
        } else {
            $this->register_model->rollback();
            $msg = lang('registration_failed');
            $this->redirect($msg, $redirect_url, false);
        }
    }

    /* Blockchain Payment Method Starts */

    function blockchain()
    {

        require_once 'Blockchain.php';
        $blockchain = new Blockchain;

        if (!empty($this->session->userdata('replica_language'))) {
            $replica_lang = $this->session->userdata('replica_language');
            $this->lang->load($this->CURRENT_CTRL, $replica_lang['lang_name_in_english']);
        }

        $title = lang('blockchain');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('blockchain');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('blockchain');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if(!empty($this->session->userdata('from_replica'))) {
            $redirect_url = "register/replica_register";
        } else {
            $redirect_url = "register/user_register";
        }

        $base_url = base_url();
        $date = date("Y-m-d H:i:s");
        $invoice_id = time();
        $secret = $blockchain->getToken();
        if (empty($this->session->userdata("inf_regr"))) {
            $this->redirect("", $redirect_url, false);
        }
        $inf_reg = $this->session->userdata("inf_regr");
        $p_id = $inf_reg["product_id"];
        $product_amount = $this->register_model->getProductAmount($p_id);
        $register_amount = $this->register_model->getRegisterAmount();
        $total_amount = $product_amount + $register_amount;

        $currency = "USD";
        $blockchain_root = "https://blockchain.info/";
        // $price_in_btc = $total_amount;
        $price_in_btc = file_get_contents($blockchain_root . "tobtc?currency=$currency&value=" . $total_amount);
        // $blockchain_info['secret'];

        $new_address = false;
        if ($this->register_model->getUnpaidAddressCount() <= 19) {
            if ($address = ($this->register_model->getUnpaidAddress()) ?: false) { } else {
                if ($this->LOG_USER_TYPE == 'admin') {
                    $this->redirect(lang('you_have_reached_maximum_unpaid_address'), $redirect_url, false);
                } else {
                    $this->redirect(lang('payment_not_available_now'), $redirect_url, false);
                }
            }
        } else {
            $address = $blockchain->generateAddress();
            $new_address = true;
        }
        $qr_code = $blockchain->generateQr($address);
        if ($address) {
            if ($new_address) {
                $this->register_model->keepBitcoinAddress($address);
            } else {
                $this->register_model->updateAddressDate($address);
            }
            $regr = $this->session->userdata("inf_regr");
            $this->register_model->insertPaymentDetails($invoice_id, $address, $secret, $total_amount, $price_in_btc, $date, $regr, 'register');
        } else {
            $this->redirect("Something wrong", $redirect_url, false);
        }

        $this->set('address', $address);
        $this->set('qr_code', $qr_code);
        $this->set('amount', $total_amount);
        $this->set('amount_in_btc', $price_in_btc);
        $this->set('invoice_id', $invoice_id);
        $this->session->set_userdata('block_address', $address);
        $this->session->set_userdata('price_in_btc', $price_in_btc);
        $this->session->set_userdata('invoice_id', $invoice_id);


        $this->setView();
    }

    public function blockchain_payment_done()
    {
        require_once 'Blockchain.php';
        $blockchain = new Blockchain;

        if(!empty($this->session->userdata('from_replica'))) {
            $redirect_url = "register/replica_register";
        } else {
            $redirect_url = "register/user_register";
        }

        if ($this->session->userdata('block_address') && $this->session->userdata('price_in_btc')) {
            $block_address = $this->session->userdata('block_address');
            $paid_amount = $this->session->userdata('price_in_btc');
            $inf_reg = $this->session->userdata("inf_regr");
            $p_id = $inf_reg["product_id"];
            $product_amount = $this->register_model->getProductAmount($p_id);
            $register_amount = $this->register_model->getRegisterAmount();
            $total_amount = $product_amount + $register_amount;

            $res_arr = $blockchain->getResponse($block_address);
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
            $invoice_id = $this->session->userdata('invoice_id');
            $this->register_model->keepRowAddressReponse($block_address, $invoice_id, $res_arr, 'register');
            $this->register_model->updateBitcoinAddress($block_address, 'yes');

            if ($response_amount > 0.00000001 && (round($response_amount, 8) >= round($paid_amount, 8))) {

                $regr = $this->session->userdata('inf_regr');
                $referral_id = $regr["sponsor_id"];
                $module_status = $this->MODULE_STATUS;
                $pending_signup_status = $this->configuration_model->getPendingSignupStatus("blockchain");
                $regr['by_using'] = 'blockchain';

                $this->register_model->begin();
                $status = $this->register_model->confirmRegister($regr, $module_status, $pending_signup_status);

                $msg = '';
                if ($status['status']) {
                    $this->register_model->commit();
                    if ($pending_signup_status) {
                        $user = $status['user_name'];
                        $user_id = $status['user_id'];
                        $tran_code = "";
                        $pass = "";
                    } else {
                        $user = $status['user'];
                        $pass = $status['pwd'];
                        $tran_code = $status['tran'];
                    }

                    $product_status = $this->MODULE_STATUS['product_status'];
                    $payment_method = "blockchain";
                    //                    if ($product_status == "yes") {
                    //                        $user_id = $this->validation_model->userNameToID($user);
                    //                        $insert_into_sales = $this->register_model->insertIntoSalesOrder($user_id, $regr['product_id'], $payment_method,$pending_signup_status);
                    //                    }

                    $id_encode = $this->encrypt->encode($user);
                    $id_encode = str_replace("/", "_", $id_encode);
                    $user1 = urlencode($id_encode);

                    $this->session->unset_userdata(['inf_regr','inf_reg_post_array','from_replica']);

                    $this->session->unset_userdata('block_address');
                    $this->session->unset_userdata('price_in_btc');
                    $this->session->unset_userdata('invoice_id');
                    $msg = lang('registration_completed_successfully');
                    $this->redirect("<span><b>$msg!</b>  Username : $user &nbsp;&nbsp; Password : $pass &nbsp; Transaction Password : $tran_code</span>", "register/preview/" . $user1, true);
                    exit();
                } else {
                    $this->register_model->rollback();
                    $msg = lang('registration_failed');
                    $this->redirect($msg, $redirect_url, false);
                }
                //unset all session
            } else {
                $msg = "Invalid Operation !! " . lang('registration_failed');
                $this->redirect($msg, $redirect_url, false);
            }
        }
    }
    /* Blockchain Payment Method End */

    /* Bitgo Payment Method Starts */

    public function bitgo_gateway()
    {
        require_once 'Bitgo.php';
        $bitgo = new Bitgo;
        $error = '';
        $this->set("action_page", $this->CURRENT_URL);

        if (!empty($this->session->userdata('replica_language'))) {
            $replica_lang = $this->session->userdata('replica_language');
            $this->lang->load($this->CURRENT_CTRL, $replica_lang['lang_name_in_english']);
        }

        $title = lang('bitgo_gateway');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('bitgo_gateway');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('bitgo_gateway');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if(!empty($this->session->userdata('from_replica'))) {
            $redirect_url = "register/replica_register";
        } else {
            $redirect_url = "register/user_register";
        }

        $regr = $this->session->userdata('inf_regr');
        $p_id = $regr['product_id'];
        $product_amount = $regr['product_amount'];
        $register_amount = $this->register_model->getRegisterAmount();

        $total_amount = $product_amount + $register_amount;
        $total_amount = $product_amount;
        if (!empty($this->session->userdata('bitcoin_session')) && $regr['is_new'] == "no") {
            $bitcoin_sess = $this->session->userdata('bitcoin_session');
            $pay_address = $bitcoin_sess['bitcoin_address'];
            $sendAmount = $bitcoin_sess['send_amount'];
        } else {
            try {
                $address = $bitgo->bitgo_gateway();
            } catch (Exception $e) {
                $msg = $e->getMessage();
                $this->redirect($msg, $redirect_url, false);
            }

            $btc_amount = $this->currency_model->currencyToBtc('USD', $total_amount);
            $sendAmount = $btc_amount['btc_amount'];
            $regr = $this->session->userdata('inf_regr');
            $p_id = $regr['product_id'];
            $user_id = $this->LOG_USER_ID;
            $pay_address = $address->address;
            $wallet_id = $address->wallet;
            $bitgo_hid = $this->register_model->insertIntoBitGoPaymentHistory($user_id, serialize($regr), $p_id, $btc_amount['btc_amount'], $pay_address, serialize($address), $wallet_id);

            $bitcoin_session = array(
                'bitcoin_address' => $pay_address,
                'send_amount' => $btc_amount['btc_amount'],
                'bitgo_hid' => $bitgo_hid,
                'wallet_id' => $wallet_id
            );
            $this->session->set_userdata('bitcoin_session', $bitcoin_session);
            $_SESSION['inf_regr']['is_new'] = "no";
        }

        $btc_amount = round($sendAmount, 8);
        $qr_code = $bitgo->generateBitcoinQrCode($pay_address, $btc_amount);

        $this->set('pay_address', $pay_address);
        $this->set('amount', $btc_amount);
        $this->set('qr_code', $qr_code);
        $this->set('error', $error);
        $this->setView();
    }

    public function ajax_bitgo_payment_verify()
    {
        require_once 'Bitgo.php';
        $bitgo = new Bitgo;
        if (!empty($this->session->userdata('bitcoin_session'))) {

            $rs_arr = array();
            $bitcoin_address_array = $this->session->userdata('bitcoin_session');
            $bitcoin_address = $bitcoin_address_array['bitcoin_address'];
            $btc_amount = $bitcoin_address_array['send_amount'];
            $bitgo_hid = $bitcoin_address_array['bitgo_hid'];
            $wallet_id = $bitcoin_address_array['wallet_id'];
            $bitcoin_status = $bitgo->checkBitcoinPaymentStatus($bitcoin_address, $btc_amount, $bitgo_hid, $wallet_id);

            if ($bitcoin_status['status']) {
                if ($this->session->userdata('inf_regr')) {
                    $regr = $this->session->userdata('inf_regr');
                    $product_status = $this->MODULE_STATUS['product_status'];
                    $module_status = $this->MODULE_STATUS;
                    $pending_signup_status = $this->configuration_model->getPendingSignupStatus('bitgo');

                    $this->register_model->begin();
                    $status = $this->register_model->confirmRegister($regr, $module_status, $pending_signup_status);

                    if ($status['status']) {
                        $this->register_model->commit();

                        if ($pending_signup_status) {
                            $user = $status['user_name'];
                            $user_id = $status['user_id'];
                            $tran_code = "";
                            $pass = "";
                        } else {
                            $user = $status['user'];
                            $pass = $status['pwd'];
                            $tran_code = $status['tran'];
                            $user_id = $this->validation_model->userNameToID($user);
                        }
                        $payment_method = 'bitgo';
                        if ($product_status == "yes") {
                            $this->register_model->insertIntoSalesOrder($user_id, $regr['product_id'], $payment_method, $pending_signup_status);
                        }
                        $id_encode = $this->encrypt->encode($user);
                        $id_encode = str_replace("/", "_", $id_encode);
                        $user1 = urlencode($id_encode);

                        $bitgo_session = array(
                            'bitgo_resp_user' => $user,
                            'bitgo_resp_user1' => $user1,
                            'bitgo_resp_tran_code' => $tran_code,
                            'bitgo_resp_pass' => $pass,
                            'bitgo_pending_signup_status' => $pending_signup_status
                        );
                        $this->session->set_userdata('bitgo_session', $bitgo_session);
                        $rs_arr['status'] = $status['status'];
                    } else {
                        $this->register_model->rollback();
                        $rs_arr['status'] = $status['status'];
                    }
                    echo json_encode($rs_arr);
                }
            } else {
                $rs_arr['status'] = "Failed";
                echo json_encode($bitcoin_status);
            }
        } else {
            $rs_arr['status'] = "Failed";
            echo json_encode($rs_arr);
        }
    }

    function btc_confirm()
    {
        if(!empty($this->session->userdata('from_replica'))) {
            $redirect_url = "register/replica_register";
        } else {
            $redirect_url = "register/user_register";
        }

        if (!empty($this->session->userdata('bitgo_session'))) {
            $bitgo_address_array = $this->session->userdata('bitgo_session');
            $user = $bitgo_address_array['bitgo_resp_user'];
            $user1 = $bitgo_address_array['bitgo_resp_user1'];

            if ($bitgo_address_array['bitgo_pending_signup_status']) {
                $msg1 = "<span><b>" . lang('registration_completed_successfully_pending') . "!</b> " . lang("User_Name") . ": {$user}";
            } else {
                $tran_code = $bitgo_address_array['bitgo_resp_tran_code'];
                $pass = $bitgo_address_array['bitgo_resp_pass'];
                $msg = lang('registration_completed_successfully');
                $msg1 = "<span><b>$msg!</b>  " . lang("User_Name") . " : $user &nbsp;&nbsp; " . lang("password") . " : $pass &nbsp; " . lang('transaction_password') . " : $tran_code</span>";
            }
            $this->session->unset_userdata(['inf_regr','inf_reg_post_array','from_replica']);
            $this->session->unset_userdata('bitcoin_session');
            $this->session->unset_userdata('bitgo_session');

            $this->redirect($msg1, "register/preview/" . $user1, true);
        } else {
            $msg = lang('registration_failed');
            $this->redirect($msg, $redirect_url, false);
        }
    }

    function upload_payment_reciept()
    {
        if ($this->input->is_ajax_request()) {
            $user_name = $this->input->post('user_name', true);
            $this->load->library('upload');
            $base_url = base_url();
            $response = array();
            $response['error'] = false;
            if (!isset($_FILES['file'])) {
                $response['error'] = true;
                $response['message'] = lang('select_payment_reciept');
                echo json_encode($response);
                exit();
            }
            if (!empty($_FILES['file'])) {
                $upload_config = $this->validation_model->getUploadConfig();
                $upload_count = $this->validation_model->getUploadCount($this->LOG_USER_ID);
                if ($upload_count >= $upload_config) {
                    $msg = lang('you_have_reached_max_upload_limit');
                    $response['error'] = true;
                    $response['message'] = $msg;
                    echo json_encode($response);
                    exit();
                }
            }
            if ($_FILES['file']['error'] != 4) {
                $this->session->set_userdata('file', 'file');
                $random_number = floor(2048 * rand(1000, 9999));
                $config['file_name'] = "bank_" . $random_number;
                $config['upload_path'] = IMG_DIR . 'reciepts';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size'] = '2048';
                $config['max_width'] = '3000';
                $config['max_height'] = '3000';
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('file')) {
                    $msg = $this->upload->display_errors();
                    $msg = strip_tags($msg);
                    $response['error'] = true;
                    $response['message'] = $msg;
                } else {
                    $result = '';

                    $data = array('upload_data' => $this->upload->data());
                    $doc_file_name = $data['upload_data']['file_name'];
                    $result = $this->register_model->addReciept($user_name, $doc_file_name);
                    $this->validation_model->updateUploadCount($this->LOG_USER_ID);
                    if ($result) {
                        $data_array['file_name'] = $doc_file_name;
                        $data = serialize($data_array);

                        // Employee Activity History
                        if ($this->LOG_USER_TYPE == 'employee') {
                            $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'upload_material', 'Payment Receipt Uploaded');
                        }
                        $msg = lang('payment_receipt_ploaded_successfully');
                        $response['success'] = true;
                        $response['message'] = $msg;
                        $response['file_name'] = $doc_file_name;
                    } else {
                        $msg = lang('payment_receipt_upload_error');
                        $response['error'] = true;
                        $response['message'] = $msg;
                    }
                }
                echo json_encode($response);
                exit();
            }
        }
    }

    /* Bank Transfer Payment Method Ends */

    public function get_available_leg()
    {
        $this->load->model('tree_model');
        $user_name = $this->input->get('user_name');
        $user_id = $this->validation_model->userNameToID($user_name);
        $response = $this->tree_model->getAllowedBinaryLeg($user_id, $this->LOG_USER_TYPE, $this->LOG_USER_ID);
        echo $response;
        exit();
    }
    public function getTicketCount()
    {
        $new_ticket = 0;
        $this->load->model('ticket_system_model');
        $new_ticket = $this->ticket_system_model->getNewTickets();
        echo $new_ticket;
        exit();
    }

    public function reset_file_type()
    {
        $data = false;
        if (!empty($this->session->userdata('file'))) {
            $this->session->unset_userdata('file');
            $data = true;
        }
        echo $data;
        exit();
    }

    function validate_sponsorfullname()
    {
        $sponsorname = '';
        $username = $this->input->post('username');
        if ($username != '') {
            $sponsorname = $this->register_model->isSponsornameExist($username);
            echo $sponsorname;
            exit();
        } else {
            $flag = false;
            $user_name = ($this->input->post('sponsor_user_name', true));
            $sponsor_fullname = ($this->input->post('sponsor_full_name', true));
            $sponsorname = $this->register_model->isSponsornameExist($user_name);
            if ($sponsorname == $sponsor_fullname) {
                $flag = true;
            }
            return $flag;
        }
    }

    public function payeer()
    {
        if (!empty($this->session->userdata('replica_language'))) {
            $replica_lang = $this->session->userdata('replica_language');
            $this->lang->load($this->CURRENT_CTRL, $replica_lang['lang_name_in_english']);
        }

        $title = lang('payeer');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('payeer');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('payeer');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if(!empty($this->session->userdata('from_replica'))) {
            $redirect_url = "register/replica_register";
        } else {
            $redirect_url = "register/user_register";
        }

        if ($this->session->userdata('payeer_data')) {
            $data = $this->session->userdata('payeer_data');
            $setting = $this->member_model->getPayeerSettings();
            $m_shop = $setting['merchant_id'];   //   merchant   ID
            $m_curr = $data['currency'];   //   invoice   currency
            $m_orderid = ''; //   invoice   number   in   the   merchant's   invoicing   system
            $m_amount = number_format($data['product_amount'], 2, '.', '');   //   invoice   amount   with   two   decimal   places following   a   period
            $m_desc = '';   //   invoice   description   encoded   using   a   base64 algorithm
            $m_key = $setting['merchant_key']; //   Forming   an   array   for   signature   generation
            $arHash = array($m_shop, $m_orderid, $m_amount, $m_curr, $m_desc); //   Forming   an   array   for   additional   parameters
            // $arParams   =   array('success_url'   =>   'https://dev.bizmo.world/backoffice/user/member/payeer_success',
            //                         'fail_url'   =>  'https://dev.bizmo.world/backoffice/user/member/payeer_failure',
            //                         'status_url'   =>   'https://dev.bizmo.world/backoffice/register/payeer_status',
            //                         //   Forming   an   array   for   additional   fields
            //                         'reference'   =>   array('var1'   =>   $data['product_id'],
            //                     ),
            //                     //'submerchant'   =>   'mail.com',
            //                 );
            // //   Forming   a   key   for   encryption
            // $key   =   md5($setting['encryption_key'].$m_orderid);//   Encrypting   additional   parameters
            // $m_params = urlencode(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256,$key, json_encode($arParams), MCRYPT_MODE_ECB)));
            // //   Encrypting   additional   parameters   using   AES-256-CBC   (for   >=   PHP   7)
            // //
            // $m_params   =   urlencode(base64_encode(openssl_encrypt(json_encode($arParams),'AES-256-CBC',$key,OPENSSL_RAW_DATA)));
            // //   Adding   parameters   to   the   signature-formation   array
            // $arHash[]   =   $m_params;
            //  //   Adding   the   secret   key   to   the   signature-formation   array
            // $arHash[]   =   $m_key;
            // //   Forming   a   signature
            // $sign = strtoupper(hash('sha256', implode(':', $arHash)));
            if (isset($m_params)) {
                $arHash[] = $m_params;
            }
            // Adding the secret key
            $arHash[] = $m_key;
            // Forming a signature
            $sign = strtoupper(hash('sha256', implode(":", $arHash)));
            $new_package_name = $this->register_model->getProductName($data['product_id']);
            $comment = "Payment for the Product $new_package_name";
            $this->set('m_shop', $m_shop);
            $this->set('m_orderid', $m_orderid);
            $this->set('m_amount', $m_amount);
            $this->set('m_curr', $m_curr);
            $this->set('m_desc', $m_desc);
            $this->set('sign', $sign);
            $this->set('type', $comment);
            $this->setView('register/payeer');
        } else {
            $msg = "registration_failed";
            $this->session->unset_userdata('from_replica');
            $this->redirect($msg, $redirect_url, false);
        }
    }

    public function payeer_success()
    {
        $pending_signup_status = $this->configuration_model->getPendingSignupStatus('payeer');
        $inf_reg = $this->session->userdata("inf_regr");
        $p_id = $inf_reg["product_id"];

        if(!empty($this->session->userdata('from_replica'))) {
            $redirect_url = "register/replica_register";
        } else {
            $redirect_url = "register/user_register";
        }

        $product_amount = $this->register_model->getProductAmount($p_id);
        $register_amount = $this->register_model->getRegisterAmount();
        $product_amount = round($product_amount * $this->DEFAULT_CURRENCY_VALUE, 8);
        $register_amount = round($register_amount * $this->DEFAULT_CURRENCY_VALUE, 8);

        $payeer_currency_code = "EUR";
        $payeer_currency_left_symbol = "€";
        $payeer_currency_right_symbol = "";

        $default_currency_code = ($this->DEFAULT_CURRENCY_CODE != '') ? $this->DEFAULT_CURRENCY_CODE : "EUR";
        $default_currency_left_symbol = ($this->DEFAULT_SYMBOL_LEFT != '') ? $this->DEFAULT_SYMBOL_LEFT : "€";
        $default_currency_right_symbol = ($this->DEFAULT_SYMBOL_RIGHT != '') ? $this->DEFAULT_SYMBOL_RIGHT : "";

        $total_amount = round($product_amount + $register_amount);

        $payeer_details = $this->configuration_model->getPayeerConfigurationDetails();
        $base_url = base_url();
        $regr = $this->session->userdata('inf_regr');
        $referral_id = $regr["sponsor_id"];
        $payment_details = array(
            'user_id' => $this->LOG_USER_ID,
            'purpose' => 'Registration',
            'amount' => $product_amount,
            'product_id' => $p_id,
            'status' => 'success',
            'currency' => $default_currency_code,
            'invoice_number' => '',
            'date' => date('Y-m-d H:i:s')
        );
        $this->register_model->insertIntoPayeerOrderHistory($payment_details);
        $module_status = $this->MODULE_STATUS;
        $regr['by_using'] = 'payeer';
        $this->register_model->begin();
        $status = $this->register_model->confirmRegister($regr, $module_status, $pending_signup_status);
        $msg = '';
        if ($status['status']) {
            $user_name = $status['user_name'];
            $user_id = $status['user_id'];
            $transaction_password = $pending_signup_status ? '' : $status['transaction_password'];

            $payment_method = "payeer";
            $product_status = $this->MODULE_STATUS['product_status'];
            if ($product_status == "yes") {
                $insert_into_sales = $this->register_model->insertIntoSalesOrder($user_id, $regr['product_id'], $payment_method, $pending_signup_status);
            }
            $this->register_model->commit();
            // Employee Activity History
            if ($this->LOG_USER_TYPE == 'employee') {
                $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'user_register', 'New User Registered', $pending_signup_status);
            }
            //
            $this->session->unset_userdata(['inf_regr','inf_reg_post_array','from_replica']);

            $id_encode = $this->encrypt->encode($user_name);
            $id_encode = str_replace("/", "_", $id_encode);
            $user_name_encrypt = urlencode($id_encode);
            if ($pending_signup_status) {
                $msg = "<span><b>" . lang('registration_completed_successfully_pending') . "!</b> " . lang("User_Name") . ": {$user_name}";
            } else {
                $msg = "<span><b>" . lang('registration_completed_successfully') . "!</b> " . lang("User_Name") . ": {$user_name} " . lang("transaction_password") . ": {$transaction_password}</span>";
            }
            $this->redirect($msg, "register/preview/{$user_name_encrypt}", true);
        } else {
            $this->register_model->rollback();
            $msg = lang('registration_failed');
            $this->redirect($msg, $redirect_url, false);
        }
    }

    public function payeer_failure()
    {
        $this->register_model->rollback();
        $msg = lang('registration_failed');

        if(!empty($this->session->userdata('from_replica'))) {
            $redirect_url = "register/replica_register";
        } else {
            $redirect_url = "register/user_register";
        }

        $this->redirect($msg, $redirect_url, false);
    }

    function sofort_payment()
    {
        if (!empty($this->session->userdata('replica_language'))) {
            $replica_lang = $this->session->userdata('replica_language');
            $this->lang->load($this->CURRENT_CTRL, $replica_lang['lang_name_in_english']);
        }

        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('sofort');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('sofort');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('sofort');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if ($this->session->userdata('inf_regr')) {

            $regr = $this->session->userdata('inf_regr');
            $p_id = $regr['product_id'];
            $product_amount = $regr['product_amount'];
            $register_amount = $this->register_model->getRegisterAmount();

            //          $eur_conevrsion_rate = $this->currency_model->getCurrencyConversionRate('USD', "EUR");
            $eur_conevrsion_rate = 0.87;
            $product_amount = round($product_amount * $eur_conevrsion_rate, 8);
            $register_amount = round($register_amount * $eur_conevrsion_rate, 8);

            $total_amount = $product_amount + $register_amount;

            $currency = 'EUR';
            $package_name = $this->register_model->getProductName($p_id);

            $comment = "Payment for the Product $package_name";
            $this->set('comment', $comment);
            $this->set('amount', $total_amount);
            $this->set('currency', $currency);
            $this->setView();
        }
    }

    public function sofort_response()
    {

        require_once 'SofortPay.php';
        $sofort = new SofortPay;

        if(!empty($this->session->userdata('from_replica'))) {
            $redirect_url = "register/replica_register";
        } else {
            $redirect_url = "register/user_register";
        }

        $this->load->model("payment_model");
        $input = array();
        $input = $this->input->post(null, true);

        $result = $sofort->sofortResponse($input);
        if (!$result['status']) {
            $result = $this->payment_model->insertInToSofortProcessDetails($this->session->userdata('inf_regr'), $result['msg'], $this->LOG_USER_ID);
            $msg = lang('registration_failed');
            $this->redirect($msg, $redirect_url, false);
        }
    }
    public function sofort_success()
    {

        $this->load->model("payment_model");
        if(!empty($this->session->userdata('from_replica'))) {
            $redirect_url = "register/replica_register";
        } else {
            $redirect_url = "register/user_register";
        }

        if ($this->session->userdata('inf_regr')) {
            $transaction_id = $this->session->userdata('transactionid');
            $pending_signup_status = $this->configuration_model->getPendingSignupStatus('sofort');
            $regr = $this->session->userdata('inf_regr');
            $module_status = $this->MODULE_STATUS;
            $product_status = $module_status['product_status'];
            $this->register_model->begin();
            $status = $this->register_model->confirmRegister($regr, $module_status, $pending_signup_status);
            if ($status['status']) {
                $this->register_model->commit();
                $user_name = $status['user_name'];
                $user_id = $status['user_id'];
                $transaction_password = $pending_signup_status ? '' : $status['transaction_password'];
                $payment_method = 'sofort';

                $p_id = $regr["product_id"];
                $product_amount = $this->register_model->getProductAmount($p_id);
                $register_amount = $this->register_model->getRegisterAmount();
                $total_amount = $product_amount + $register_amount;

                $payment_details = [
                    'user_id' => $user_id,
                    'type' => 'Registration',
                    's tatus' => 'success',
                    'total_amount' => $total_amount,
                    'transaction_id' => $transaction_id
                ];

                $result = $this->payment_model->insertIntoSofortPaymentHistory($payment_details);

                if ($product_status == "yes") {
                    $insert_into_sales = $this->register_model->insertIntoSalesOrder($user_id, $regr['product_id'], $payment_method, $pending_signup_status);
                }

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'user_register', 'New User Registered', $pending_signup_status);
                }
                //
                $this->session->unset_userdata(['inf_regr','inf_reg_post_array','from_replica']);
                $this->session->unset_userdata('transactionid');

                $id_encode = $this->encrypt->encode($user_name);
                $id_encode = str_replace("/", "_", $id_encode);
                $user_name_encrypt = urlencode($id_encode);
                if ($pending_signup_status) {
                    $msg = "<span><b>" . lang('registration_completed_successfully_pending') . "!</b> " . lang("User_Name") . ": {$user_name}";
                } else {
                    $msg = "<span><b>" . lang('registration_completed_successfully') . "!</b> " . lang("User_Name") . ": {$user_name} " . lang("transaction_password") . ": {$transaction_password}</span>";
                }

                $this->redirect($msg, "register/preview/{$user_name_encrypt}", true);
            } else {
                $this->register_model->rollback();
                $result = $this->payment_model->insertInToSofortProcessDetails($this->session->userdata('inf_regr'), "confirmRegister failed", $this->LOG_USER_ID);
                $msg = lang('registration_failed');
                $this->redirect($msg, $redirect_url, false);
            }
        } else {
            $error_data['user_name_entry'] = '';
            $result = $this->payment_model->insertInToSofortProcessDetails($error_data, "No Session Data", $this->LOG_USER_ID);
            $msg = lang('registration_failed');
            $this->redirect($msg, $redirect_url, false);
        }
    }

    public function squareup_gateway()
    {

        $title = lang('squareup_payment');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('squareup_payment');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('squareup_payment');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if(!empty($this->session->userdata('from_replica'))) {
            $redirect_url = "register/replica_register";
        } else {
            $redirect_url = "register/user_register";
        }

        if (empty($this->session->userdata('inf_regr'))) {
            $msg = lang('you_cant_go_to_payment_page_directly_without_filling_all_registration_fields');
            $this->redirect($msg, $redirect_url, false);
        }

        $merchant_details = $this->configuration_model->getSquareUpConfigDetails();
        $application_id = $merchant_details['application_id'];
        $location_id = $merchant_details['location_id'];
        $inf_reg = $this->session->userdata("inf_regr");
        $product_id = $inf_reg["product_id"];
        $product_amount = $this->register_model->getProductAmount($product_id);
        $register_amount = $this->register_model->getRegisterAmount();
        $total_amount = round((floatval($product_amount + $register_amount) / $this->DEFAULT_CURRENCY_VALUE), 8);

        $total_amount = $total_amount * 100; //USD in Cents
        $this->session->set_userdata('total_amount', $total_amount);

        $this->set('application_id', $application_id);
        $this->set('location_id', $location_id);

        $this->setView();
    }

    public function squareup_payment()
    {

        require_once 'Squareup.php';
        $squareup = new SquareUp;
        $this->load->model('payment_model');

        if(!empty($this->session->userdata('from_replica'))) {
            $redirect_url = "register/replica_register";
        } else {
            $redirect_url = "register/user_register";
        }

        if (empty($this->session->userdata('inf_regr'))) {
            $msg = lang('you_cant_go_to_payment_page_directly_without_filling_all_registration_fields');
            $this->redirect($msg, $redirect_url, false);
        }

        $regr_data = $this->session->userdata('inf_regr');
        $total_amount = $this->session->userdata('total_amount');

        $merchant_details = $this->configuration_model->getSquareUpConfigDetails();
        $location_id = $merchant_details['location_id'];

        $nonce = $_POST['nonce'];
        if (is_null($nonce)) {
            $this->payment_model->insertSquareUpResponse($regr_data, "Invalid card data", $this->LOG_USER_ID);
            $this->session->unset_userdata(['inf_regr','inf_reg_post_array','from_replica']);
            $msg = lang('invalid_card_data');
            $this->redirect($msg, $redirect_url, false);
        }

        $request_body = array(
            "card_nonce" => $nonce,
            # This amount is in cents. It's also hard-coded for $1.00, which isn't very useful.
            "amount_money" => array(
                "amount" => $total_amount,
                "currency" => "USD"
            ),
            "idempotency_key" => uniqid()
        );
        $response = $squareup->squareResponse($request_body, $location_id);

        if ($response['status']) {
            $transaction_id = $response['transaction_id'];
            $pending_signup_status = $this->configuration_model->getPendingSignupStatus('squareup');
            $regr = $this->session->userdata('inf_regr');
            $module_status = $this->MODULE_STATUS;
            $product_status = $module_status['product_status'];
            $this->register_model->begin();
            $status = $this->register_model->confirmRegister($regr, $module_status, $pending_signup_status);
            if ($status['status']) {
                $this->register_model->commit();
                $user_name = $status['user_name'];
                $user_id = $status['user_id'];
                $insert_id = $this->payment_model->insertSquareUpPaymentDetails($user_id, $user_name, $request_body, 'register', $transaction_id, 'success');
                $transaction_password = $pending_signup_status ? '' : $status['transaction_password'];
                $payment_method = 'squareup';

                $p_id = $regr["product_id"];
                $product_amount = $this->register_model->getProductAmount($p_id);
                $register_amount = $this->register_model->getRegisterAmount();
                $total_amount = $product_amount + $register_amount;

                if ($product_status == "yes") {
                    $insert_into_sales = $this->register_model->insertIntoSalesOrder($user_id, $regr['product_id'], $payment_method, $pending_signup_status);
                }
                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'user_register', 'New User Registered', $pending_signup_status);
                }

                 $this->session->unset_userdata(['inf_regr','inf_reg_post_array','from_replica']);

                $id_encode = $this->encrypt->encode($user_name);
                $id_encode = str_replace("/", "_", $id_encode);
                $user_name_encrypt = urlencode($id_encode);
                if ($pending_signup_status) {
                    $msg = "<span><b>" . lang('registration_completed_successfully_pending') . "!</b> " . lang("User_Name") . ": {$user_name}";
                } else {
                    $msg = "<span><b>" . lang('registration_completed_successfully') . "!</b> " . lang("User_Name") . ": {$user_name} " . lang("transaction_password") . ": {$transaction_password}</span>";
                }

                $this->redirect($msg, "register/preview/{$user_name_encrypt}", true);
            } else {
                $this->payment_model->insertSquareUpResponse($this->session->userdata('inf_regr'), 'Confirm Register Failed', $this->LOG_USER_ID);
                $this->register_model->rollback();
                $msg = lang('registration_failed');
                $this->redirect($msg, $redirect_url, false);
            }
        } else {
            $this->payment_model->insertSquareUpResponse($this->session->userdata('inf_regr'), $response['msg'], $this->LOG_USER_ID);
             $this->session->unset_userdata(['inf_regr','inf_reg_post_array','from_replica']);
            $msg = $response['msg'];
            $this->redirect($msg, $redirect_url, false);
        }
    }
}
