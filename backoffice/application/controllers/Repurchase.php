<?php

require_once 'Inf_Controller.php';
require "../vendor/autoload.php";

use Blocktrail\SDK\BlocktrailSDK;

class Repurchase extends Inf_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('cart');
        $this->load->model('configuration_model', '', true);
        $this->load->model('register_model', '', true);
        $this->load->model('product_model');
        if ($this->MODULE_STATUS['repurchase_status'] == 'no') {
            $msg = lang('repurchase_is_not_enabled_in_your_demo');
            $this->redirect($msg, 'home', false);
        }
    }

    function repurchase_product()
    {

        if ($this->MLM_PLAN == 'Unilevel' && $this->MODULE_STATUS['hyip_status'] == 'yes') {
            $title = lang('deposit');
        } else {
            $title = lang('cart');
        }
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $repurchase_details = $this->repurchase_model->getAllRepurchaseProducts();
            for ($i = 0; $i < count($repurchase_details); $i++) {
                $prod_enc_id = $this->encrypt->encode($repurchase_details[$i]['product_id']);
                $prod_enc_id = str_replace("/", "_", $prod_enc_id);
                $prod_enc_id = rawurlencode($prod_enc_id);
                $repurchase_details[$i]['prod_enc_id'] = $prod_enc_id;
                $category_name = $this->repurchase_model->getCategoryName($repurchase_details[$i]['category_id']);
                $repurchase_details[$i]['category_name'] = $category_name;
                if (!file_exists(IMG_DIR . 'product_img/' . $repurchase_details[$i]['prod_img'])) {
                    $repurchase_details[$i]['prod_img'] = null;
                }
            }
        $this->set('repurchase_detail', $this->security->xss_clean($repurchase_details));
        $this->set('product_name', lang('product_name'));
        $this->set('product_price', lang('product_price'));
        //$this->set('prod_enc_id', $prod_enc_id);

        $this->set('cart_count', count($this->cart->contents()));
        $this->set('cart_content', $this->cart->contents());

        $cart_total_amount = $this->cart->total();
        $this->set('cart_total_amount', $cart_total_amount);

        $this->setView();
    }

    function quick_view()
    {

        $details = array();
        $product_info = $this->repurchase_model->getProduct($this->input->post('product_id'));

        if ($product_info) {
            $details['heading_title'] = $product_info[0]['product_name'];

            $details['model'] = $product_info[0]['product_name'];
            $details['reward'] = $product_info[0]['product_name'];
            $details['points'] = $product_info[0]['product_value'];

            $details['quantity'] = 1;
        }
        $this->set('heading_title', $details['heading_title']);
        $this->set('price', $details['points']);
        $this->set('details', $details);
        $this->setView();

        echo json_encode($details);
    }

    function add_to_cart($type = "cart")
    {
        $flag = true;
        $product_id = $this->input->post('product_id');
        $flag = $this->product_model->isProductAvailable($product_id);
        if (!$flag) {
            $message = lang('this_product_not_available');
            $this->redirect($message, 'repurchase/repurchase_product', false);
        }
        if ($type == "cart") {
            $qty = 1;
        } elseif ($type == "from_product") {
            $qty = $this->input->post('product_qty', true);

            $this->form_validation->set_rules('product_qty', lang('Quantity_Is_required'), 'trim|required|greater_than[0]');
            if (!$this->form_validation->run()) {
                $message = lang('error_on_updation_to_cart');
                $this->redirect($message, 'repurchase/repurchase_product', false);
            }
        }
        if ($this->cart->in_cart($product_id)) {
            $cart = $this->cart->contents();
            $rowid = $quantity = 0;
            foreach ($cart as $item) {
                if ($item['id'] == $product_id) {
                    $rowid = $item['rowid'];
                    $quantity = $item['qty'] + $qty;
                }
            }
            $this->updateItem($rowid, $quantity, $type);
        }
        $product_details = $this->product_model->getPackageInfoByColumns($product_id, ['product_name', 'product_value', 'prod_img']);
        $insert_data = [
            'id' => $product_id,
            'name' => $product_details['product_name'],
            'price' => $product_details['product_value'],
            'prod_img' => $product_details['prod_img'],
            'qty' => $qty
        ];

        $this->cart->insert($insert_data);
        $message = $insert_data['name'] . " " . lang('It_has_been_added_to_the_cart');
        $this->redirect($message, 'repurchase/repurchase_product', true);
    }

    function checkout_product()
    {
        $title = lang('checkout_product');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $payment_methods_tab = false;
        $payment_gateway_array = array();
        $payment_module_status_array = array();

        if ($this->MODULE_STATUS['product_status'] == 'yes') {
            $payment_methods_tab = true;
            $payment_gateway_array = $this->register_model->getPaymentGatewayStatus("repurchase");
            $payment_module_status_array = $this->register_model->getPaymentModuleStatus();
        }
        $this->set('payment_methods_tab', $payment_methods_tab);
        $this->set('payment_gateway_array', $payment_gateway_array);
        $this->set('payment_module_status_array', $payment_module_status_array);


        $pin_count = 0;
        if ($this->session->userdata("inf_repurchase_post_array")) {
            $repurchase_post_array = $this->session->userdata("inf_repurchase_post_array");
            $pin_count = $repurchase_post_array['pin_count'];
            $this->session->unset_userdata("inf_repurchase_post_array");
        }
        $this->set('pin_count', $pin_count);

        $cart_products = $this->cart->contents();
        $cart_empty = false;
        if (empty($cart_products)) {
            $cart_empty = true;
        }
        $cart_total_amount = $this->cart->total();
        $this->set('cart_products', $cart_products);
        $this->set('cart_total_amount', $cart_total_amount);
        $this->set('cart_empty', $cart_empty);

        $user_id = $this->LOG_USER_ID;
        $user_address = $this->repurchase_model->getUserPurchaseAddress($user_id);
        $default_address = $this->repurchase_model->getUserRepurchaseDefualtAddress($user_id);

        $default_address['id'] = isset($default_address['id']) ? $default_address['id'] : 0;

        $this->set('user_address', $this->security->xss_clean($user_address));
        $this->set('logged_user_name', $this->LOG_USER_NAME);
        $this->set('default_address', $default_address['id']);
        $this->setView();
    }

    function check_epin_validity()
    {
        $pin_details = $this->input->post('pin_array', true);
        $upgrade_user_name = $this->input->post('upgrade_user_name', true);
        $upgrade_user_id = $this->validation_model->userNameToID($upgrade_user_name);
        $pin_data = [];
        $i = 0;
        foreach ($pin_details as $v) {
            $pin_data[$i]['pin'] = $v;
            $pin_data[$i]['pin_amount'] = 0;
            $i++;
        }
        $total_amount = $this->input->post('repurchase_amount', true);
        $pin_array = $this->repurchase_model->validateAllEpins($pin_data, $total_amount, $this->LOG_USER_ID, $upgrade_user_id);
        $value = json_encode($pin_array);
        echo $value;
        exit();
    }

    function check_ewallet_balance()
    {
        $status = "no";
        $ewallet_user = $this->input->post('user_name', true);
        $ewallet_pass = $this->input->post('ewallet', true);
        $total_amount = $this->input->post('repruchase_amount', true);
        if ($this->LOG_USER_TYPE == 'admin' || $this->LOG_USER_TYPE == 'employee') {
            $admin_username = $this->validation_model->getAdminUsername();
            if ($ewallet_user != $admin_username) {
                $status = "invalid";
                echo $status;
                exit();
            }
        }
        if ($this->LOG_USER_TYPE == 'user') {
            if ($ewallet_user != $this->LOG_USER_NAME) {
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

    function removeItem($rowid)
    {

        if ($rowid === "all") {
            $this->cart->destroy();
        } else {
            $data = array(
                'rowid' => $rowid,
                'qty' => 0
            );
            $this->cart->update($data);
        }
        $msg = lang("item_successfully_removed");
        $this->redirect($msg, 'repurchase/checkout_product', true);
    }

    function updateItem($rowid, $quantity = 0, $type = "cart")
    {

        if ($type == "cart") {
            $path = 'repurchase/checkout_product';
        } else {
            $path = 'repurchase/repurchase_product';
        }

        if ($quantity < 1) {
            $msg = lang("Quantity_bust_be_atleast_one");
            $this->redirect($msg, $path, false);
        }
        if (!filter_var($quantity, FILTER_VALIDATE_INT)) {
            $message = lang('quantity_must_be_an_integer');
            $this->redirect($message, $path, false);
        }
        $data = $this->cart->update(array(
            'rowid' => $rowid,
            'qty' => $quantity
        ));

        $this->cart->update($data);
        $msg = lang("Quantity_Is_updated");
        $this->redirect($msg, $path, true);
    }

    public function add_checkout_address()
    {
        if ($this->input->is_ajax_request()) {
            $response = array();
            $response['error'] = false;
            $address = $this->input->post(null, true);
            if ($this->validate_checkout_address()) {
                $address['user_id'] = $this->LOG_USER_ID;
                $response['address_id'] = $this->repurchase_model->addCheckoutAddress($address);
                if (!$response['address_id']) {
                    $response['error'] = true;
                }
                $response['message'] = lang('Error_on_adding_address');
            } else {
                $response['error'] = true;
                $response['message'] = lang('errors_check');
                foreach ($address as $key => $value) {
                    $response['form_error'][$key] = form_error($key);
                }
            }
            echo json_encode($response);
            exit();
        }
    }

    public function validate_checkout_address()
    {
        $this->form_validation->set_rules('full_name', lang('name'), 'trim|required|min_length[3]|max_length[32]|callback__alpha_space');
        $this->form_validation->set_rules('address', lang('address'), 'trim|required|min_length[3]|max_length[32]');
        $this->form_validation->set_rules('pin_no', lang('pin_number'), 'trim|required|min_length[3]|max_length[10]|is_natural');
        $this->form_validation->set_rules('city', lang('city'), 'trim|required|min_length[3]|max_length[32]|callback__alpha_city_address');
        $this->form_validation->set_rules('phone', lang('phone_number'), 'trim|required|is_natural|min_length[5]|max_length[10]');

        $validation_status = $this->form_validation->run();
        return $validation_status;
    }

    function _alpha_space($str = '')
    {
        if (!$str) {
            return true;
        }
        $res = (bool)preg_match('/^[A-Z ]*$/i', $str);
        if (!$res) {
            $this->lang->load('register');
            $this->form_validation->set_message('_alpha_space', lang('only_alpha_space'));
        }
        return $res;
    }

    function _alpha_city_address($str_in = '')
    {
        if (!preg_match("/^([a-zA-Z0-9\s\.\,\-])*$/i", $str_in)) {
            $this->lang->load('register');
            $this->form_validation->set_message('_alpha_city_address', lang('city_field_characters'));
            return false;
        } else {
            return true;
        }
    }

    function removeAdress()
    {

        $address_id = $this->input->post(null, true);
        $deleted = $this->repurchase_model->removePurchaseAddress($address_id['product_id']);
        if ($deleted) {
            echo $deleted;
        } else {
            echo 'failure';
        }
    }

    function repurchase_submit()
    {
        $repurchase_post = $this->input->post(null, true);
        $cart_products = $this->cart->contents();
        $purchase['total_amount'] = $this->cart->total();
        $payment_gateway_array = $this->register_model->getPaymentGatewayStatus("repurchase");

        if ($this->input->post('active_tab') != 'bank_transfer') {
            $this->session->unset_userdata('file');
        }

        if ($this->input->post('active_tab') == 'bank_transfer' && empty($this->session->userdata('file'))) {
            $msg = $this->lang->line('upload_reciepts');
            $this->redirect($msg, "repurchase/checkout_product", false);
        }

        $module_status = $this->MODULE_STATUS;
        $is_pin_ok = false;
        $is_ewallet_ok = false;
        $is_pwallet_ok = false;
        $is_paypal_ok = false;
        $is_authorize_ok = false;
        $is_blocktrail_ok = false;
        $is_blockchain_ok = false;
        $is_bitgo_ok = false;
        $is_payeer_ok = false;
        $is_sofort_ok = false;
        $is_squareup_ok = false;
        $is_bank_transfer_ok = false;

        $purchase['user_id'] = $this->LOG_USER_ID;

        $purchase['order_address_id'] = $this->validation_model->getUserPurchaseDefaultAddressId($purchase['user_id']);

        if (!$purchase['order_address_id']) {
            $msg = $this->lang->line('You_must_select_address');
            $this->redirect($msg, "repurchase/checkout_product", false);
        }

        if (!empty($cart_products)) {
            if ($repurchase_post['active_tab'] == "epin_tab") {
                $payment_type = 'epin';
                $pin_count = count($repurchase_post['epin']);
                $pin_details = $repurchase_post['epin'];
                $pin_data = [];
                $i = 1;
                foreach ($pin_details as $v) {
                    $pin_data[$i]['pin'] = $v;
                    $pin_data[$i]['pin_amount'] = 0;
                    $i++;
                }

                $pin_array = $this->repurchase_model->validateAllEpins($pin_data, $purchase['total_amount'], $this->LOG_USER_ID);

                $is_pin_ok = !(in_array('nopin', array_column($pin_array, 'pin')));
                if (!$is_pin_ok) {
                    $msg = $this->lang->line('invalid_e_pin');
                    $this->redirect($msg, "repurchase/checkout_product", false);
                }
                $is_pin_duplicate = (count(array_column($pin_array, 'pin')) != count(array_unique(array_column($pin_array, 'pin'))));
                if ($is_pin_duplicate) {
                    $msg = $this->lang->line('duplicate_epin');
                    $this->redirect($msg, "repurchase/checkout_product", false);
                }
            } elseif ($repurchase_post['active_tab'] == "ewallet_tab") {

                $payment_type = 'ewallet';
                $used_amount = $purchase['total_amount'];
                $ewallet_user = $repurchase_post['user_name_ewallet'];
                $ewallet_trans_password = base64_decode(urldecode($repurchase_post['tran_pass_ewallet']));
                if ($ewallet_user != "") {
                    if ($this->LOG_USER_TYPE == 'admin' || $this->LOG_USER_TYPE == 'employee') {
                        $admin_username = $this->validation_model->getAdminUsername();
                        if ($ewallet_user != $admin_username) {
                            $msg = $this->lang->line('invalid_user_name_ewallet_tab');
                            $this->redirect($msg, "repurchase/checkout_product", false);
                        }
                    } else if ($this->LOG_USER_TYPE == 'user') {
                        if ($ewallet_user != $this->LOG_USER_NAME) {
                            $msg = $this->lang->line('invalid_user_name_ewallet_tab');
                            $this->redirect($msg, "repurchase/checkout_product", false);
                        }
                    }
                    $ewallet_user_id = $this->validation_model->userNameToID($ewallet_user);

                    $user_available = $this->validation_model->isUserAvailable($ewallet_user_id);
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
                                    $this->redirect($msg, "repurchase/checkout_product", false);
                                }
                            } else {
                                $msg = $this->lang->line('invalid_transaction_password_ewallet_tab');
                                $this->redirect($msg, "repurchase/checkout_product", false);
                            }
                        } else {
                            $msg = $this->lang->line('invalid_transaction_password_ewallet_tab');
                            $this->redirect($msg, "repurchase/checkout_product", false);
                        }
                    } else {
                        $msg = $this->lang->line('invalid_user_name_ewallet_tab');
                        $this->redirect($msg, "repurchase/checkout_product", false);
                    }
                } else {
                    $msg = $this->lang->line('invalid_user_name_ewallet_tab');
                    $this->redirect($msg, "repurchase/checkout_product", false);
                }
            } elseif ($repurchase_post['active_tab'] == "purchase_wallet_tab") {

                $payment_type = 'purchase wallet';
                $used_amount = $purchase['total_amount'];
                $pwallet_user = $repurchase_post['uname_pwallet'];
                $pwallet_trans_password = base64_decode(urldecode($repurchase_post['tran_pass_pwallet']));
                if ($pwallet_user != "") {
                    if ($this->LOG_USER_TYPE == 'admin' || $this->LOG_USER_TYPE == 'employee') {
                        $admin_username = $this->validation_model->getAdminUsername();
                        if ($pwallet_user != $admin_username) {
                            $msg = $this->lang->line('invalid_trans_details');
                            $this->redirect($msg, "repurchase/checkout_product", false);
                        }
                    } else if ($this->LOG_USER_TYPE == 'user') {
                        if ($pwallet_user != $this->LOG_USER_NAME) {
                            $msg = $this->lang->line('invalid_trans_details');
                            $this->redirect($msg, "repurchase/checkout_product", false);
                        }
                    }
                    $pwallet_user_id = $this->validation_model->userNameToID($pwallet_user);

                    $user_available = $this->validation_model->isUserAvailable($pwallet_user_id);
                    if ($user_available) {
                        if ($pwallet_trans_password != "") {
                            $pwallet_user_id = $this->validation_model->userNameToID($pwallet_user);
                            $trans_pass_available = $this->register_model->checkEwalletPassword($pwallet_user_id, $pwallet_trans_password);
                            if ($trans_pass_available == 'yes') {

                                $pwallet_balance_amount = $this->validation_model->getPurchaseWalletAmount($pwallet_user_id);
                                if ($pwallet_balance_amount >= $used_amount) {
                                    $is_pwallet_ok = true;
                                } else {
                                    $msg = $this->lang->line('insuff_bal');
                                    $this->redirect($msg, "repurchase/checkout_product", false);
                                }
                            } else {
                                $msg = $this->lang->line('invalid_trans_details');
                                $this->redirect($msg, "repurchase/checkout_product", false);
                            }
                        } else {
                            $msg = $this->lang->line('invalid_trans_details');
                            $this->redirect($msg, "repurchase/checkout_product", false);
                        }
                    } else {
                        $msg = $this->lang->line('invalid_trans_details');
                        $this->redirect($msg, "repurchase/checkout_product", false);
                    }
                } else {
                    $msg = $this->lang->line('invalid_trans_details');
                    $this->redirect($msg, "repurchase/checkout_product", false);
                }
            } elseif (($repurchase_post['active_tab'] == "paypal_tab")) {
                if ($payment_gateway_array['paypal_status'] == "no") {
                    $msg = lang('payment_method_not_available');
                    $this->redirect($msg, "repurchase/checkout_product", false);
                }
                $payment_type = 'paypal';
                $is_paypal_ok = true;
            } else if (($repurchase_post['active_tab'] == "authorize_tab")) {
                if ($payment_gateway_array['authorize_status'] == "no") {
                    $msg = lang('payment_method_not_available');
                    $this->redirect($msg, "repurchase/checkout_product", false);
                }
                $payment_type = 'Athurize.Net';
                $is_authorize_ok = true;
            } else if (($repurchase_post['active_tab'] == "bitcoin_tab")) {
                if ($payment_gateway_array['bitcoin_status'] == "no") {
                    $msg = lang('payment_method_not_available');
                    $this->redirect($msg, "repurchase/checkout_product", false);
                }
                $payment_type = 'blocktrail';
                $is_blocktrail_ok = true;
            } else if (($repurchase_post['active_tab'] == "blockchain_tab")) {
                if ($payment_gateway_array['blockchain_status'] == "no") {
                    $msg = lang('payment_method_not_available');
                    $this->redirect($msg, "repurchase/checkout_product", false);
                }
                $payment_type = 'blockchain';
                $is_blockchain_ok = true;
            } else if (($repurchase_post['active_tab'] == "bitgo_tab")) {
                if ($payment_gateway_array['bitgo_status'] == "no") {
                    $msg = lang('payment_method_not_available');
                    $this->redirect($msg, "repurchase/checkout_product", false);
                }
                $payment_type = 'bitgo';
                $is_bitgo_ok = true;
            } else if (($repurchase_post['active_tab'] == "sofort_tab")) {
                if ($payment_gateway_array['sofort_status'] == "no") {
                    $msg = lang('payment_method_not_available');
                    $this->redirect($msg, "repurchase/checkout_product", false);
                }
                $payment_type = 'sofort';
                $is_sofort_ok = true;
            } else if (($repurchase_post['active_tab'] == "payeer_tab")) {
                if ($payment_gateway_array['payeer_status'] == "no") {
                    $msg = lang('payment_method_not_available');
                    $this->redirect($msg, "repurchase/checkout_product", false);
                }
                $payment_type = 'payeer';
                $is_payeer_ok = true;
            } else if (($repurchase_post['active_tab'] == "squareup_tab")) {
                if ($payment_gateway_array['squareup_status'] == "no") {
                    $msg = lang('payment_method_not_available');
                    $this->redirect($msg, "repurchase/checkout_product", false);
                }
                $payment_type = 'squareup';
                $is_squareup_ok = true;

            } else if (($repurchase_post['active_tab'] == "bank_transfer")) {
                $bank_transfer_status = $this->configuration_model->getPaymentStatus('Bank Transfer');
                 if ($bank_transfer_status == "no") {
                    $msg = lang('payment_method_not_available');
                    $this->redirect($msg, "repurchase/checkout_product", false);
                }
                $payment_type = 'bank_transfer';
                $is_bank_transfer_ok = true;

            } else if(($repurchase_post['active_tab'] == "free_purchase")){
                $payment_type = 'free_purchase';
                $is_free_join_ok = true;
            }
            else {
                $msg = lang('payment_method_not_available');
                $this->redirect($msg, "repurchase/checkout_product", false);
            }

            $purchase['payment_type'] = $payment_type;
            $pending_status = false;

            if($payment_type == 'bank_transfer') {
                $purchase['status'] = 'pending';
            } else {
                $purchase['status'] = 'confirmed';
            }
            if ($is_pin_ok) {
                $this->repurchase_model->begin();
                $purchase['by_using'] = 'pin';

                $pin_array['user_id'] = $purchase['user_id'];
                $res = $this->register_model->UpdateUsedEpin($pin_array, $pin_count, 'repurchase');
                if ($res) {
                    $this->register_model->insertUsedPin($pin_array, $pin_count, false, 'repurchase');
                    $payment_status = true;
                }
            } elseif ($is_ewallet_ok) {
                $this->repurchase_model->begin();
                $purchase['by_using'] = 'ewallet';
                $user_id = $purchase['user_id'];
                $used_user_id = $this->validation_model->userNameToID($ewallet_user);
                $transaction_id = $this->repurchase_model->getUniqueTransactionId();
                $res1 = $this->register_model->insertUsedEwallet($used_user_id, $user_id, $used_amount, $transaction_id, false, "repurchase");
                if ($res1) {
                    $res2 = $this->register_model->deductFromBalanceAmount($used_user_id, $used_amount);
                    if ($res2) {
                        $payment_status = true;
                    }
                }
            } elseif ($is_pwallet_ok) {
                $this->repurchase_model->begin();
                $purchase['by_using'] = 'purchase wallet';
                $user_id = $purchase['user_id'];
                $used_user_id = $this->validation_model->userNameToID($pwallet_user);
                $transaction_id = $this->repurchase_model->getUniqueTransactionId();
                $res1 = $this->validation_model->insertPurchasewalletHistory($used_user_id, $user_id, $used_amount, $used_amount, "repurchase", 'debit', 0, $transaction_id);
                if ($res1) {
                    $res2 = $this->ewallet_model->deductFromPurchaseWallet($used_user_id, $used_amount);
                    if ($res2) {
                        $payment_status = true;
                    }
                }
            } elseif ($is_paypal_ok) {
                $purchase['by_using'] = 'paypal';
                $this->session->set_userdata('inf_repurchase', $purchase);
                $msg = "";
                $this->payNow($cart_products, $purchase);
            } elseif ($is_authorize_ok) {
                $purchase['by_using'] = 'Authorize.Net';
                $this->session->set_userdata('inf_repurchase', $purchase);
                $msg = "";
                $this->redirect($msg, "repurchase/authorizeRepurchase", false);
            } elseif ($is_blocktrail_ok) {
                $purchase['by_using'] = 'Blocktrail';
                $this->session->set_userdata('inf_repurchase', $purchase);
                $msg = "";
                $this->redirect($msg, "repurchase/blocktrailRepurchase", false);
            } elseif ($is_blockchain_ok) {
                $purchase['by_using'] = 'Blockchain';
                $this->session->set_userdata('inf_repurchase', $purchase);
                $msg = "";
                $this->redirect($msg, "repurchase/blockchainRepurchase", false);
            } elseif ($is_bitgo_ok) {
                $purchase['by_using'] = 'Bitgo';
                $this->session->set_userdata('inf_repurchase', $purchase);
                $this->session->set_userdata('is_new', 'yes');
                $msg = "";
                $this->redirect($msg, "repurchase/bitgoRepurchase", false);
            } elseif ($is_sofort_ok) {
                $purchase['by_using'] = 'sofort';
                $this->session->set_userdata('inf_repurchase', $purchase);
                $msg = "";
                $this->redirect($msg, "repurchase/sofort_repurchase", false);
            } elseif ($is_payeer_ok) {
                $purchase['by_using'] = 'payeer';
                $this->session->set_userdata('inf_repurchase', $purchase);
                $msg = "";
                $this->redirect($msg, "repurchase/payeer_repurchase", false);
            } elseif ($is_squareup_ok) {
                $purchase['by_using'] = 'squareup';
                $this->session->set_userdata('inf_repurchase', $purchase);
                $msg = "";
                $this->redirect($msg, "repurchase/squareupRepurchase", false);
            } elseif ($is_bank_transfer_ok) {
                $purchase['by_using'] = 'bank_transfer';
                $this->repurchase_model->begin();
                $payment_status = true;
                $pending_status = true;
            } else {
                $purchase['by_using'] = 'free join';
                $this->repurchase_model->begin();
                $payment_status = true;
            }
            if ($payment_status) {

                $insert_into_sales = $this->insertIntoRepuchase($cart_products, $purchase);

                if(!$pending_status) {
                    $this->repurchase_model->updateUserPv($cart_products, $purchase, $this->MODULE_STATUS);
                }
                if (!empty($insert_into_sales)) {

                    $module_status = $this->MODULE_STATUS;
                    $rank_status = $module_status['rank_status'];
                    if ($rank_status == "yes" && !$pending_status) {
                        $this->load->model('rank_model');
                        $this->rank_model->updateUplineRank($purchase['user_id']);
                    }

                    $this->repurchase_model->commit();
                    $this->cart->destroy();
                    $this->session->unset_userdata('inf_repurchase');
                    $this->session->unset_userdata('repurchase_post_array');
                    $this->session->unset_userdata('inf_repurchase_post_array');
                    $msg = lang('repurchase_completed_successfully');
                    $your_order_is = lang('your_order_is') . $insert_into_sales['invoice_no'];
                    $enc_order_id = $this->validation_model->encrypt($insert_into_sales['order_id']);

                    if ($pending_status) {
                        $msg = lang('repurchase_completed_successfully_pending');
                        $this->redirect("<span><b>$msg </b>  $your_order_is </span>", "repurchase/repurchase_invoice/$enc_order_id", true);
                    } else{
                        $this->redirect("<span><b>$msg </b>  $your_order_is </span>", "repurchase/repurchase_invoice/$enc_order_id", true);
                    }

                } else {
                    $this->repurchase_model->rollback();
                    $msg = lang('repurchase_failed');
                    $this->redirect($msg, 'repurchase/checkout_product', false);
                }
            } else {
                $this->repurchase_model->rollback();
                $msg = lang('repurchase_failed');
                $this->redirect($msg, 'repurchase/checkout_product', false);
            }
        } else {
            $error = $this->form_validation->error_array();
            $this->session->set_userdata('inf_error', $error);

            $msg = $this->lang->line('there_is_no_product_in_your_cart');
            $this->redirect($msg, "repurchase/checkout_product", false);
        }
    }

    public function insertIntoRepuchase($cart_products, $purchase_details)
    {

        $orders_details = $this->repurchase_model->insertIntoRepuchaseOrder($purchase_details);
        $order_status = $purchase_details['status'];
        $orders_id = $orders_details['order_id'];
        if ($purchase_details['by_using'] == 'bank_transfer' && !empty($this->session->userdata('reciept_name'))){
            $user_id = $purchase_details['user_id'];
            $this->repurchase_model->insertPaymentReciept($user_id, $orders_id, $this->session->userdata('reciept_name'));
        }
        if ($orders_id) {
            $total_pv = 0;
            foreach ($cart_products as $key => $value) {
                $value['pv'] = $this->product_model->getProductPV($value['id']);
                $total_pv += $value['pv'];
                $order_details = $this->repurchase_model->insertRepurchaseOrderDetails($value, $orders_id, $order_status);
                if (!$order_details) {
                    return false;
                }
            }
            $this->repurchase_model->updateRepurchaseOrderPV($orders_id, $total_pv);
        }
        return $orders_details;
    }

    function payNow($cart_products, $purchase_details)
    {
        require_once 'Paypal.php';
        $paypal = new Paypal;
        $paypal_details = $this->configuration_model->getPaypalConfigDetails();

        $paypal_currency_code = "USD";
        $paypal_currency_left_symbol = "$";
        $paypal_currency_right_symbol = "";

        $default_currency_code = ($this->DEFAULT_CURRENCY_CODE != '') ? $this->DEFAULT_CURRENCY_CODE : "USD";
        $default_currency_left_symbol = ($this->DEFAULT_SYMBOL_LEFT != '') ? $this->DEFAULT_SYMBOL_LEFT : "$";
        $default_currency_right_symbol = ($this->DEFAULT_SYMBOL_RIGHT != '') ? $this->DEFAULT_SYMBOL_RIGHT : "";

        //$usd_conevrsion_rate = $this->currency_model->getCurrencyConversionRate($default_currency_code, $paypal_currency_code);
        $usd_conevrsion_rate = 1;
        $total_amount = round($purchase_details['total_amount'] * $usd_conevrsion_rate, 8);
        $this->session->set_userdata('cart_products', $cart_products);

        $description = "Package Repurchase " . $this->COMPANY_NAME;
        $description .= "\nPackage Amount : $paypal_currency_left_symbol $total_amount $paypal_currency_right_symbol";
        $product_status = $this->MODULE_STATUS['product_status'];

        $base_url = base_url();
        $params = array(
            'amount' => $total_amount,
            'item' => "Package Repuchase",
            'description' => $description,
            'currency' => $paypal_currency_code,
            'return_url' => $base_url . $paypal_details['repurchase_return_url'],
            'cancel_url' => $base_url . $paypal_details['repurchase_cancel_url']
        );
        $response = $paypal->initilize($params);
    }

    function payment_success()
    {
        require_once 'Paypal.php';
        $paypal = new Paypal;
        $paypal_currency_code = "USD";
        $paypal_currency_left_symbol = "$";
        $paypal_currency_right_symbol = "";
        $default_currency_code = ($this->DEFAULT_CURRENCY_CODE != '') ? $this->DEFAULT_CURRENCY_CODE : "USD";
        $default_currency_left_symbol = ($this->DEFAULT_SYMBOL_LEFT != '') ? $this->DEFAULT_SYMBOL_LEFT : "$";
        $default_currency_right_symbol = ($this->DEFAULT_SYMBOL_RIGHT != '') ? $this->DEFAULT_SYMBOL_RIGHT : "";

        //$usd_conevrsion_rate = $this->currency_model->getCurrencyConversionRate($default_currency_code, $paypal_currency_code);
        $usd_conevrsion_rate = 1;
        $purchase = $this->session->userdata('inf_repurchase');
        $total_amount = round($purchase['total_amount'] * $usd_conevrsion_rate, 8);

        $paypal_details = $this->configuration_model->getPaypalConfigDetails();

        $base_url = base_url();
        $params = array(
            'amount' => $total_amount,
            'currency' => $paypal_details['currency'],
            'return_url' => $base_url . $paypal_details['repurchase_return_url'],
            'cancel_url' => $base_url . $paypal_details['repurchase_cancel_url']
        );

        $response = $paypal->callback($params);
        if ($response->success()) {
            $paypal_output = $this->input->get();

            $user_id = $purchase["user_id"];
            $payment_details = array(
                'payment_method' => 'paypal',
                'token_id' => $paypal_output['token'],
                'currency' => $paypal_details['currency'],
                'amount' => $total_amount,
                'acceptance' => '',
                'payer_id' => $paypal_output['PayerID'],
                'user_id' => $user_id,
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
            $purchase['by_using'] = 'paypal';
            $this->repurchase_model->begin();
            $cart_products = $this->session->userdata('cart_products');

            $insert_into_sales = $this->insertIntoRepuchase($cart_products, $purchase);

            if ($this->MLM_PLAN == "Stair_Step") {
                $this->repurchase_model->updateUserPv($cart_products, $purchase);
            }

            if (!empty($insert_into_sales)) {
                $this->repurchase_model->commit();
                $this->cart->destroy();
                $this->session->unset_userdata('inf_repurchase');
                $this->session->unset_userdata('repurchase_post_array');
                $this->session->unset_userdata('inf_repurchase_post_array');
                $msg = lang('repurchase_completed_successfully');
                $your_order_is = lang('your_order_is') . $insert_into_sales['invoice_no'];
                $enc_order_id = $this->validation_model->encrypt($insert_into_sales['order_id']);
                $this->redirect("<span><b>$msg </b>  $your_order_is </span>", "repurchase/repurchase_invoice/$enc_order_id", true);
            } else {
                $this->repurchase_model->rollback();
                $msg = lang('repurchase_failed');
                $this->redirect($msg, 'repurchase/checkout_product', false);
            }
        } else {
            $msg = 'Payment Failed';
            $this->redirect($msg, 'repurchase/checkout_product', false);
        }
    }

    function authorizeNetPayment()
    {

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
        $purchase_details = $this->session->userdata('inf_repurchase');
        $total_amount = $purchase_details['total_amount'];

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

    function payment_done()
    {
        $this->load->model('authorizeNetPayment_model');
        $response = $this->input->post(null, true);

        $purchase_details = $this->session->userdata('inf_repurchase');

        $product_status = $this->MODULE_STATUS['product_status'];

        $module_status = $this->MODULE_STATUS;

        $insert_id = $this->authorizeNetPayment_model->insertAuthorizeNetPayment($response);


        $purchase_details['by_using'] = 'authorizenet';
        $this->repurchase_model->begin();
        $cart_products = $this->cart->contents();

        $insert_into_sales = $this->insertIntoRepuchase($cart_products, $purchase_details);

        if ($this->MLM_PLAN == "Stair_Step") {
            $this->repurchase_model->updateUserPv($cart_products, $purchase_details, $module_status);
        }

        if (!empty($insert_into_sales)) {
            $this->repurchase_model->commit();
            $this->cart->destroy();
            $this->session->unset_userdata('inf_repurchase');
            $this->session->unset_userdata('repurchase_post_array');
            $this->session->unset_userdata('inf_repurchase_post_array');
            $msg = lang('repurchase_completed_successfully');
            $your_order_is = lang('your_order_is') . $insert_into_sales['invoice_no'];
            $enc_order_id = $this->validation_model->encrypt($insert_into_sales['order_id']);
            $this->redirect("<span><b>$msg </b>  $your_order_is </span>", "repurchase/repurchase_invoice/$enc_order_id", true);
        } else {
            $this->repurchase_model->rollback();
            $msg = lang('repurchase_failed');
            $this->redirect($msg, 'repurchase/checkout_product', false);
        }
    }

    function repurchase_invoice($enc_invoice_order_id = '')
    {
        $title = lang('Invoice');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $invoice_details = array();
        $invoice_order_id = $this->validation_model->decrypt($enc_invoice_order_id);
        $this->report_header();
        if (!$invoice_order_id) {
            $msg = lang("invalid_invoice_id");
            $this->redirect($msg, 'select_report/repurchase_report', false);
        } else {
            $invoice_details = $this->repurchase_model->getRpurchaseInvoiceDetails($invoice_order_id);
        }

        $report_name = '';
        $this->set('report_name', "$report_name");
        $help_link = "Invoice";
        $this->set("help_link", $help_link);
        $date = date("Y-m-d");
        $this->set("date", $date);
        $this->set("count", count($invoice_details));
        $this->set("invoice_details", $this->security->xss_clean($invoice_details));
        $this->set("report_date", '');
        $this->setView();
    }

    function change_default_address()
    {
        $address_id = $this->input->post('addres_id', true);
        $user_name = $this->input->post('user_name', true);
        $user_id = $this->validation_model->userNameToID($user_name);
        if (!$user_id || $user_id != $this->LOG_USER_ID) {
            echo false;
            exit();
        }
        echo $res = $this->repurchase_model->updateDefualtAddress($user_id, $address_id);
        exit();
    }

    function product_details($product_enc_id)
    {
        $title = lang('product_details');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $product_id = urldecode($product_enc_id);
        $product_id = str_replace("_", "/", $product_id);
        $product_id = $this->encrypt->decode($product_id);
        $products = array();
        $products_details = $this->repurchase_model->getAllRepurchaseProducts($product_id);

        foreach ($products_details as $key => $value) {
            $category_name = $this->repurchase_model->getCategoryName($value['category_id']);
            $value['category_name'] = $category_name;
            $products = $value;
        }

        $cart_details = array(
            'quantity' => 0,
            'rowid' => ""
        );
        $base_url = base_url();
        $ACTION_URL = base_url() . "repurchase/add_to_cart/from_product";
        $button_name = lang('add_to_cart');
        $button_type = "submit";


        foreach ($this->cart->contents() as $item) {
            if ($item['id'] == $product_id) {
                $cart_details['quantity'] = $item['qty'];
                $cart_details['rowid'] = $item['rowid'];
                $ACTION_URL = base_url() . "repurchase/add_to_cart/from_product";
                $button_name = lang('update_cart');
                $button_type = "button";
            }
        }

        $this->set("products", $this->security->xss_clean($products));
        $this->set("cart_details", $cart_details);
        $this->set("ACTION_URL", $ACTION_URL);
        $this->set("button_name", $button_name);
        $this->set("button_type", $button_type);

        $help_link = "repurcahse";
        $this->set("help_link", $help_link);
        $this->setView();
    }

    function package_update_payment_done()
    {
        $this->load->model("member_model");
        $response = $this->input->post(null, true);

        $this->load->model('authorizeNetPayment_model');
        $purchase = $this->session->userdata('inf_package_validity');

        $product_status = $this->MODULE_STATUS['product_status'];
        $module_status = $this->MODULE_STATUS;

        $insert_id = $this->authorizeNetPayment_model->insertAuthorizeNetPayment($response);

        $purchase['by_using'] = 'authorizenet';
        $this->repurchase_model->begin();

        $expired_users = $this->member_model->getPackageExpiredUsers($this->ADMIN_USER_ID, $purchase['user_id']);
        $package_details[0]['id'] = $expired_users[0]['product_id'];
        $invoice_no = $this->member_model->packageValidityUpgrade($package_details, $purchase);

        if ($this->MLM_PLAN == "Stair_Step") {
            $this->repurchase_model->updateUserPv($package_details, $purchase);
        }

        if ($this->LOG_USER_TYPE == "admin") {
            $link = "member/package_validity";
        } else {
            $link = "member/upgrade_package_validity";
        }

        if ($invoice_no) {
            $this->repurchase_model->commit();
            $this->session->unset_userdata('package_validity_upgrade_array');
            $this->session->unset_userdata('inf_package_validity_upgrade_array');
            $msg = lang('package_successfully_updated');
            $enc_order_id = $this->validation_model->encrypt($invoice_no);

            $this->redirect("<span><b>$msg </b> :  $invoice_no </span>", $link, true);
        } else {
            $this->repurchase_model->rollback();
            $msg = lang('package_updation_error');
            $this->redirect($msg, $link, false);
        }
    }

    function report_header()
    {

        $this->set("tran_Welcome_to", $this->lang->line('Welcome_to'));
        $this->set("tran_O", $this->lang->line('O'));
        $this->set("tran_I", $this->lang->line('I'));
        $this->set("tran_Floor", $this->lang->line('Floor'));
        $this->set("tran_em", $this->lang->line('em'));
        $this->set("tran_addr", $this->lang->line('addr'));
        $this->set("tran_comp", $this->lang->line('comp'));
        $this->set("tran_ph", $this->lang->line('ph'));
        $this->set("tran_nfinite", $this->lang->line('nfinite'));
        $this->set("tran_pen", $this->lang->line('pen'));
        $this->set("tran_ource", $this->lang->line('ource'));
        $this->set("tran_olutions", $this->lang->line('olutions'));
        $this->set("tran_S", $this->lang->line('S'));
        $this->set("tran_Date", $this->lang->line('Date'));
        $this->set("tran_email", $this->lang->line('email'));
        $this->set("tran_address", $this->lang->line('address'));
        $this->set("tran_phone", $this->lang->line('phone'));
        $this->set("tran_click_here_print", $this->lang->line('click_here_print'));
    }

//Blocktrail Payment gateway Starts

    public function blocktrail_payment()
    {
        require_once 'Blocktrail.php';
        $blocktrail = new Blocktrail;
        $session_data = $this->session->userdata('inf_repurchase');
        if ($session_data) {
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
            $currency = ($this->DEFAULT_CURRENCY_CODE != '') ? $this->DEFAULT_CURRENCY_CODE : "USD";
            $bitcoin_price = $blocktrail->bitcoinRate($currency);
            $this->session->set_userdata('bitcoin_price', $bitcoin_price);
            //end-----amount conversion

            $bitcoin_id = $this->register_model->bitcoinHistory($session_data['user_id'], $session_data, 'repurchase');
            $this->session->set_userdata('bitcoin_id', $bitcoin_id);

            $bitcoin_amount = $session_data['total_amount'] / $bitcoin_price;

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
                $this->redirect($msg, 'repurchase/checkout_product', false);
            }
        }
    }

    public function ajax_blocktrail_callback()
    {
        require_once 'Blocktrail.php';
        $blocktrail = new Blocktrail;
        $session_data = $this->session->userdata('inf_repurchase');
        if ($session_data) {
            $session_data['user_name_entry'] = $session_data['user_id'];

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
                        $this->register_model->insertInToBitcoinPaymentProcessDetails($session_data, "Amount Paid", $this->LOG_USER_ID);
                        $status = "yes";
                    } else {
                        $status = "no";
                    }
                } else {
                    $status = "no";
                }
            } else {
                $this->register_model->insertInToBitcoinPaymentProcessDetails($session_data, "No Post Data", $this->LOG_USER_ID);
                $status = "no_post_data";
            }
            echo $status;
            exit();
        }
    }

    public function blocktrail_done()
    {
        require_once 'Blocktrail.php';
        $blocktrail = new Blocktrail;
        $session_data = $this->session->userdata('inf_repurchase');
        if ($session_data) {
            $session_data['user_name_entry'] = $session_data['user_id'];
            $satoshi = "";
            $bitcoin_address = $this->session->userdata('bitcoin_address');
            $paid_amount = $this->session->userdata('bitcoin_amount');
            $response = $blocktrail->getResponse($bitcoin_address);

            if ($response['data']) {
                foreach ($response['data'][0]['outputs'] as $value) {
                    if ($value['address'] == $bitcoin_address) {
                        $satoshi = $value['value'];
                    }
                }
                $user_id = $session_data['user_id'];
                $transaction = $response['data'][0]['hash'];
                $return_address = $response['data'][0]['outputs'][0]['address'];
                $response_amount = number_format(($satoshi) * (pow(10, -8)), 8, '.', '');

                if (round($response_amount, 8) >= round($paid_amount, 8)) {
                    $current_bitcoin_value = $this->session->userdata('bitcoin_price');
                    $bitcoin_id = $this->session->userdata('bitcoin_id');
                    $total_amount = $session_data['total_amount'];
                    $session_data['by_using'] = 'blocktrail';
                    $insert_into_sales = false;

                    $this->register_model->insertInToBitcoinPaymentDetails($bitcoin_id, $user_id, 'repurchase', $total_amount, $current_bitcoin_value, $paid_amount, $response_amount, $bitcoin_address, $transaction, $return_address);
                    $this->register_model->updateBitcoinHistory($user_id, $bitcoin_id, 'yes');

                    $this->repurchase_model->begin();
                    $cart_products = $this->cart->contents();
                    $insert_into_sales = $this->insertIntoRepuchase($cart_products, $session_data);
                    if ($this->MLM_PLAN == "Stair_Step") {
                        $this->repurchase_model->updateUserPv($cart_products, $session_data, $this->MODULE_STATUS);
                    }

                    if (!empty($insert_into_sales)) {
                        $this->repurchase_model->commit();
                        $this->cart->destroy();
                        $this->session->unset_userdata('inf_repurchase');
                        $this->session->unset_userdata('repurchase_post_array');
                        $this->session->unset_userdata('inf_repurchase_post_array');
                        $your_order_is = lang('your_order_is') . $insert_into_sales['invoice_no'];
                        $enc_order_id = $this->validation_model->encrypt($insert_into_sales['order_id']);
                        $msg = lang('repurchase_completed_successfully');

                        $this->redirect("<span><b>$msg </b>  $your_order_is </span>", "repurchase/repurchase_invoice/$enc_order_id", true);
                    } else {
                        $this->repurchase_model->rollback();
                        $msg = lang('blocktrail_payment_error');
                        $this->redirect($msg, 'repurchase/checkout_product', false);
                    }
                } else {
                    $result = $this->register_model->insertInToBitcoinPaymentProcessDetails($session_data, "Amount Missmatch", $this->LOG_USER_ID);
                    $this->redirect("Amount Missmatch!!", 'repurchase/checkout_product', false);
                }
            } else {
                $result = $this->register_model->insertInToBitcoinPaymentProcessDetails($session_data, "No Response", $this->LOG_USER_ID);
                $msg = lang('repurchase_failed');
                $this->redirect($msg, 'repurchase/checkout_product', false);
            }
        }
    }

//Blocktrail Payment gateway Ends
//Blockchain Payment gateway Starts

    public function blockchain_payment()
    {

        require_once 'Blockchain.php';
        $blockchain = new Blockchain;

        $session_data = $this->session->userdata('inf_repurchase');
        if ($session_data) {
            $title = lang('blockchain_gateway');
            $this->set("title", $this->COMPANY_NAME . " | $title");

            $this->HEADER_LANG['page_top_header'] = lang('blockchain_gateway');
            $this->HEADER_LANG['page_top_small_header'] = '';
            $this->HEADER_LANG['page_header'] = lang('blockchain_gateway');
            $this->HEADER_LANG['page_small_header'] = '';

            $this->load_langauge_scripts();

            $base_url = base_url();
            $date = date("Y-m-d H:i:s");
            $invoice_id = time();
            $total_amount = $session_data['total_amount'];
            $currency = ($this->DEFAULT_CURRENCY_CODE != '') ? $this->DEFAULT_CURRENCY_CODE : "USD";
            $blockchain_root = "https://blockchain.info/";
            $price_in_btc = $total_amount;
            $price_in_btc = file_get_contents($blockchain_root . "tobtc?currency=$currency&value=" . $total_amount);
            $secret = $blockchain->getToken();
            $address = "";
            $new_address = false;

            if ($this->register_model->getUnpaidAddressCount() >= 19) {
                if ($address = ($this->register_model->getUnpaidAddress()) ? : false) {
                } else {
                    if ($this->LOG_USER_TYPE == 'admin') {
                        $this->redirect(lang('you_have_reached_maximum_unpaid_address'), 'repurchase/checkout_product', false);
                    } else {
                        $this->redirect(lang('payment_not_available_now'), 'repurchase/checkout_product', false);
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
                $session_data['product_id'] = $session_data['order_address_id'];
                $this->register_model->insertPaymentDetails($invoice_id, $address, $secret, $total_amount, $price_in_btc, $date, $session_data, 'purchase');
            } else {
                $this->redirect(lang('repurchase_failed'), 'repurchase/blockchain_payment', false);
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
    }

    public function blockchain_payment_done()
    {
        require_once 'Blockchain.php';
        $blockchain = new Blockchain;
        $session_data = $this->session->userdata('inf_repurchase');
        if ($this->session->userdata('block_address') && $this->session->userdata('price_in_btc') && $session_data) {

            $response_amount = 0;
            $block_address = $this->session->userdata('block_address');
            $paid_amount = $this->session->userdata('price_in_btc');

            $res_arr = $blockchain->getResponse($block_address);

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
            $this->register_model->keepRowAddressReponse($block_address, $invoice_id, $res_arr, 'purchase');
            $this->register_model->updateBitcoinAddress($block_address, 'yes');

            if ($response_amount > 0.00000001 && (round($response_amount, 8) >= round($paid_amount, 8))) {

                $insert_into_sales = false;
                $session_data['by_using'] = 'blockchain';

                $this->repurchase_model->begin();
                $cart_products = $this->cart->contents();
                $insert_into_sales = $this->insertIntoRepuchase($cart_products, $session_data);
                if ($this->MLM_PLAN == "Stair_Step") {
                    $this->repurchase_model->updateUserPv($cart_products, $session_data, $this->MODULE_STATUS);
                }

                if (!empty($insert_into_sales)) {
                    $this->repurchase_model->commit();
                    $this->cart->destroy();
                    $this->session->unset_userdata('inf_repurchase');
                    $this->session->unset_userdata('repurchase_post_array');
                    $this->session->unset_userdata('inf_repurchase_post_array');
                    $your_order_is = lang('your_order_is') . $insert_into_sales['invoice_no'];
                    $enc_order_id = $this->validation_model->encrypt($insert_into_sales['order_id']);
                    $msg = lang('repurchase_completed_successfully');

                    $this->redirect("<span><b>$msg </b>  $your_order_is </span>", "repurchase/repurchase_invoice/$enc_order_id", true);
                } else {
                    $this->repurchase_model->rollback();
                    $msg = lang('blockchain_payment_error');
                    $this->redirect($msg, 'repurchase/checkout_product', false);
                }
            } else {
                $msg = lang('repurchase_failed');
                $this->redirect($msg, 'repurchase/checkout_product', false);
            }
        }
    }

//Blockchain Payment gateway Ends

//BitGo Payment gateway Starts
    public function bitgo_payment()
    {

        require_once 'Bitgo.php';
        $bitgo = new Bitgo;

        $session_data = $this->session->userdata('inf_repurchase');
        if ($session_data) {
            $title = lang('bitgo_gateway');
            $this->set("title", $this->COMPANY_NAME . " | $title");

            $help_link = "";
            $this->set("help_link", $help_link);

            $this->HEADER_LANG['page_top_header'] = lang('bitgo_gateway');
            $this->HEADER_LANG['page_top_small_header'] = '';
            $this->HEADER_LANG['page_header'] = lang('bitgo_gateway');
            $this->HEADER_LANG['page_small_header'] = '';

            $this->load_langauge_scripts();

            $total_amount = $session_data['total_amount'];
            if (!empty($this->session->userdata('bitcoin_session')) && $this->session->userdata('is_new') == "no") {
                $btc_sess = $this->session->userdata('bitcoin_session');
                $pay_address = $btc_sess['bitcoin_address'];
                $sendAmount  = $btc_sess['send_amount'];
            } else {

                try {
                $address = $bitgo->bitgo_gateway();
                } catch (Exception $e) {
                    $msg = $e->getMessage();
                    $this->redirect($msg, 'repurchase/checkout_product', false);
                }

                $currency = ($this->DEFAULT_CURRENCY_CODE != '') ? $this->DEFAULT_CURRENCY_CODE : "USD";
                $btc_amount = $this->currency_model->currencyToBtc($currency, $total_amount);
                $sendAmount = $btc_amount['btc_amount'];
                $user_id = $session_data['user_id'];
                $product_id = $session_data['order_address_id'];
                $pay_address = $address->address;
                $wallet_id = $address->wallet;
                $bitgo_hid = $this->register_model->insertIntoBitGoPaymentHistory($user_id, serialize($session_data), $product_id, $btc_amount['btc_amount'], $pay_address, serialize($address), $wallet_id, 'purchase');

                $bitcoin_session = array(
                    'bitcoin_address' => $pay_address,
                    'send_amount' => $btc_amount['btc_amount'],
                    'bitgo_hid' => $bitgo_hid,
                    'wallet_id' => $wallet_id
                );
                $this->session->set_userdata('bitcoin_session', $bitcoin_session);
                $this->session->userdata('is_new', 'no');
            }

            $btc_amount = round($sendAmount, 8);
            $qr_code = $bitgo->generateBitcoinQrCode($pay_address, $btc_amount);

            $this->set('pay_address', $pay_address);
            $this->set('amount', $btc_amount);
            $this->set('qr_code', $qr_code);
            $this->setView();
        }
    }

    public function ajax_bitgo_payment_verify()
    {
        require_once 'Bitgo.php';
        $bitgo = new Bitgo;

        $response = [];
        $session_data = $this->session->userdata('inf_repurchase');
        if ($session_data) {
            $session_data['by_using'] = 'bitgo';
            $total_amount = $session_data['total_amount'];

            if (!empty($this->session->userdata('bitcoin_session'))) {
                $bitcoin_address_array = $this->session->userdata('bitcoin_session');
                $bitcoin_address = $bitcoin_address_array['bitcoin_address'];
                $btc_amount = $bitcoin_address_array['send_amount'];
                $bitgo_hid = $bitcoin_address_array['bitgo_hid'];
                $wallet_id = $bitcoin_address_array['wallet_id'];
                $bitcoin_status = $bitgo->checkBitcoinPaymentStatus($bitcoin_address, $btc_amount, $bitgo_hid, $wallet_id);

                $bitgo_session = array(
                    'msg' => '',
                    'order_id' => 0,
                    'status' => false
                );
                if ($bitcoin_status['status']) {

                    $insert_into_sales = false;

                    $this->repurchase_model->begin();
                    $cart_products = $this->cart->contents();
                    $insert_into_sales = $this->insertIntoRepuchase($cart_products, $session_data);
                    if ($this->MLM_PLAN == "Stair_Step") {
                        $this->repurchase_model->updateUserPv($cart_products, $session_data, $this->MODULE_STATUS);
                    }

                    if (!empty($insert_into_sales)) {
                        $this->repurchase_model->commit();
                        $this->cart->destroy();
                        $your_order_is = lang('your_order_is') . $insert_into_sales['invoice_no'];
                        $enc_order_id = $this->validation_model->encrypt($insert_into_sales['order_id']);
                        $msg = "<span><b>" . lang('repurchase_completed_successfully') . "</b>  $your_order_is </span>";

                        $bitgo_session['msg'] = $msg;
                        $bitgo_session['order_id'] = $enc_order_id;
                        $bitgo_session['status'] = true;
                    } else {
                        $this->repurchase_model->rollback();
                        $bitgo_session['msg'] = lang('bitgo_payment_error');
                        $bitgo_session['status'] = false;
                    }
                    $this->session->set_userdata('bitgo_session', $bitgo_session);
                    echo json_encode($bitgo_session);
                    exit();
                } else {
                    echo json_encode($bitcoin_status);
                    exit();
                }
            } else {
                $response['status'] = "Failed";
                echo json_encode($response);
                exit();
            }
        }
    }

    function btc_confirm()
    {
        if (!empty($this->session->userdata('bitgo_session'))) {
            $data = $this->session->userdata('bitgo_session');
            $msg = $data['msg'];
            $status = $data['status'];
            $order_id = $data['order_id'];
            if ($status) {
                $this->session->unset_userdata('bitgo_session');
                $this->session->unset_userdata('inf_repurchase');
                $this->session->unset_userdata('repurchase_post_array');
                $this->session->unset_userdata('inf_repurchase_post_array');
                $this->redirect($msg, "repurchase/repurchase_invoice/$order_id", true);
            } else {
                $msg = lang('repurchase_failed');
                $this->redirect($msg, 'repurchase/checkout_product', false);
            }
        }
    }

//BitGo Payment gateway Ends

// Sofort Payment gateway
    public function sofort_repurchase()
    {
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

        if ($this->session->userdata('inf_repurchase')) {
            $purchase_details = $this->session->userdata('inf_repurchase');
            $payment_amount = $purchase_details['total_amount'];

//          $eur_conevrsion_rate = $this->currency_model->getCurrencyConversionRate('USD', "EUR");
            $eur_conevrsion_rate = 0.87;
            $amount = round($payment_amount * $eur_conevrsion_rate, 8);

            $total_amount = round((floatval($amount) / $this->DEFAULT_CURRENCY_VALUE), 8);
            $currency = 'EUR';
            $comment = "Package Repurchase ";
            $this->set('comment', $comment);
            $this->set('amount', $total_amount);
            $this->set('currency', $currency);
            $this->setView();

        }
    }

    public function sofort_response() {

        require_once 'SofortPay.php';
        $sofort = new SofortPay;

        $this->load->model("payment_model");
        $input = array();
        $input = $this->input->post(NULL, TRUE);
        $result = $sofort->sofortResponse($input);
        if(!$result['status']){
            $result = $this->payment_model->insertInToSofortProcessDetails($this->session->userdata('inf_repurchase'), $result['msg'], $this->LOG_USER_ID);
            $this->session->unset_userdata('inf_repurchase');
            $msg = lang('sofort_payment_error');
            $this->redirect($msg, 'repurchase/checkout_product', FALSE);
        }
    }

    public function sofort_payment_success()
    {
        $this->load->model("payment_model");
        if ($this->session->userdata('inf_repurchase')) {
            $transaction_id = $this->session->userdata('transactionid');
            $purchase_details = $this->session->userdata('inf_repurchase');
            $total_amount = $purchase_details['total_amount'];
            $user_id = $purchase_details['user_id'];

            $payment_details = [
                'user_id' => $user_id,
                'type' => 'Package Repurchase',
                'status'=> 'success',
                'total_amount' => $total_amount,
                'transaction_id' => $transaction_id
            ];
            $result = $this->payment_model->insertIntoSofortPaymentHistory($payment_details);
            $insert_into_sales = false;
            $this->repurchase_model->begin();
            $cart_products = $this->cart->contents();
            $insert_into_sales = $this->insertIntoRepuchase($cart_products, $purchase_details);

            $this->repurchase_model->updateUserPv($cart_products, $purchase_details, $this->MODULE_STATUS);

            if (!empty($insert_into_sales)) {
                $this->repurchase_model->commit();
                $this->cart->destroy();
                $this->session->unset_userdata('inf_repurchase');
                $this->session->unset_userdata('repurchase_post_array');
                $this->session->unset_userdata('inf_repurchase_post_array');
                $your_order_is = lang('your_order_is') . $insert_into_sales['invoice_no'];
                $enc_order_id = $this->validation_model->encrypt($insert_into_sales['order_id']);
                $msg = lang('repurchase_completed_successfully');

                $this->redirect("<span><b>$msg </b>  $your_order_is </span>", "repurchase/repurchase_invoice/$enc_order_id", true);
            } else {
                $this->repurchase_model->rollback();
                $msg = lang('sofort_payment_error');
                $this->redirect($msg, 'repurchase/checkout_product', false);
            }
        } else {
                $error_data['user_name_entry'] = '';
                $result = $this->payment_model->insertInToSofortProcessDetails($error_data, "No Session", $this->LOG_USER_ID);
                $msg = lang('repurchase_failed');
                $this->redirect($msg, 'repurchase/checkout_product', false);
        }
    }

    public function payeer_repurchase()
    {
        $title = lang('payeer');
        $this->load->model("member_model");
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('payeer');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('payeer');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
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
            $this->setView('repurchase/payeer_repurchase');
        } else {
            $msg = "repurchase_failed";
            $this->redirect($msg, 'repurchase/checkout_product', false);
        }
    }

    public function payeer_success()
    {
        $purchase_details = $this->session->userdata('inf_repurchase');
        $this->load->model("payment_model");
        if ($this->session->userdata('inf_repurchase')) {

            $purchase_details = $this->session->userdata('inf_repurchase');
            $total_amount = $purchase_details['total_amount'];
            $user_id = $purchase_details['user_id'];
            $cart_products = $this->cart->contents();

            $payment_details = array(
                'user_id' => $user_id,
                'purpose' => 'Repurchase',
                'amount' => $total_amount,
                'product_id' => $cart_products[0]['id'],
                'status' => 'success',
                'currency' => 'EUR',
                'invoice_number' => '',
                'date' => date('Y-m-d H:i:s')
            );
            $this->register_model->insertIntoPayeerOrderHistory($payment_details);

            $payeer_settings = $this->configuration_model->getPayeerConfigurationDetails();
            $project_pass = $sofort_settings['project_pass'];
            $hash = $_GET['invoice'] . $project_pass;
            if ($this->session->userdata('payeer_data')) {
                $insert_into_sales = false;
                $this->repurchase_model->begin();

                $insert_into_sales = $this->insertIntoRepuchase($cart_products, $purchase_details);

                if ($this->MLM_PLAN == "Stair_Step") {
                    $this->repurchase_model->updateUserPv($cart_products, $purchase_details, $this->MODULE_STATUS);
                }

                if (!empty($insert_into_sales)) {
                    $this->repurchase_model->commit();
                    $this->cart->destroy();
                    $this->session->unset_userdata('inf_repurchase');
                    $this->session->unset_userdata('repurchase_post_array');
                    $this->session->unset_userdata('inf_repurchase_post_array');
                    $your_order_is = lang('your_order_is') . $insert_into_sales['invoice_no'];
                    $enc_order_id = $this->validation_model->encrypt($insert_into_sales['order_id']);
                    $msg = lang('repurchase_completed_successfully');

                    $this->redirect("<span><b>$msg </b>  $your_order_is </span>", "repurchase/repurchase_invoice/$enc_order_id", true);
                } else {
                    $this->repurchase_model->rollback();
                    $msg = lang('repurchase_failed');
                    $this->redirect($msg, 'repurchase/checkout_product', false);
                }
            } else {
                $this->repurchase_model->rollback();
                $msg = lang('payeer_payment_error');
                $this->redirect($msg, 'repurchase/checkout_product', false);
            }
        }
    }

    public function payeer_failure()
    {
        $this->register_model->rollback();
        $msg = lang('payeer_payment_error');
        $this->redirect($msg, 'repurchase/checkout_product', false);
    }

//Purchase wallet starts
function check_pwallet_balance() {
    $this->load->model('register_model');
    $status = "no";
    $ewallet_user = $this->input->post('user_name', TRUE);
    $ewallet_pass = $this->input->post('ewallet', TRUE);
    $total_amount = $this->input->post('repruchase_amount', TRUE);
    $upgrade_username = $this->input->post('upgrade_username', TRUE);
    if ($this->LOG_USER_TYPE == 'admin' || $this->LOG_USER_TYPE == 'employee') {
        $admin_username = $this->validation_model->getAdminUsername();
        if ($ewallet_user != $admin_username && $ewallet_user != $upgrade_username) {
            $status = "invalid";
            echo $status;
            exit();
        }
    }
    if ($this->LOG_USER_TYPE == 'user') {
        if ($ewallet_user != $this->LOG_USER_NAME) {
            $status = "invalid";
            echo $status;
            exit();
        }
    }
    $user_id = $this->validation_model->userNameToID($ewallet_user);
    if ($user_id) {
        $user_password = $this->register_model->checkEwalletPassword($user_id, $ewallet_pass);
        if ($user_password == 'yes') {
            $user_bal_amount = $this->validation_model->getPurchaseWalletAmount($user_id);
            if ($user_bal_amount > 0) {
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
//Purchase wallet ends

    public function squareup_gateway() {
        $title = lang('squareup_payment');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('squareup_payment');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('squareup_payment');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if (empty($this->session->userdata('inf_repurchase'))) {
        $msg = lang('repurchase_failed');
        $this->redirect($msg, 'repurchase/checkout_product', false);
        }
        $merchant_details = $this->configuration_model->getSquareUpConfigDetails();
        $application_id = $merchant_details['application_id'];
        $location_id = $merchant_details['location_id'];

        $purchase_details = $this->session->userdata('inf_repurchase');
        $payment_amount = $purchase_details['total_amount'];
        $total_amount = $payment_amount * 100; //USD in Cents

        $this->session->set_userdata('total_amount', $total_amount);

        $this->set('application_id', $application_id);
        $this->set('location_id', $location_id);

        $this->setView();

    }

    public function squareup_payment() {

        require_once 'Squareup.php';
        $squareup = new SquareUp;
        $this->load->model('payment_model');
        if (empty($this->session->userdata('inf_repurchase'))) {
           $msg = lang('repurchase_failed');
           $this->redirect($msg, 'repurchase/checkout_product', false);
        }

        $total_amount = $this->session->userdata('total_amount');

        $merchant_details = $this->configuration_model->getSquareUpConfigDetails();
        $location_id = $merchant_details['location_id'];

        $nonce = $_POST['nonce'];
        if (is_null($nonce)) {
            $this->payment_model->insertSquareUpResponse($this->session->userdata('inf_repurchase'), "Invalid card data", $this->LOG_USER_ID);
            $this->session->unset_userdata('inf_repurchase');
            $msg = lang('invalid_card_data');
            $this->redirect($msg, 'repurchase/checkout_product', false);
        }

        $request_body = array (
            "card_nonce" => $nonce,
            # This amount is in cents. It's also hard-coded for $1.00, which isn't very useful.
            "amount_money" => array (
            "amount" => $total_amount,
            "currency" => "USD"
            ),
            "idempotency_key" => uniqid()
        );
        $response = $squareup->squareResponse($request_body, $location_id);

        if($response['status']){
            $transaction_id = $response['transaction_id'];

            $purchase_details = $this->session->userdata('inf_repurchase');
            $user_id = $purchase_details['user_id'];
            $user_name = $this->validation_model->IdToUserName($user_id);
            $insert_id = $this->payment_model->insertSquareUpPaymentDetails($user_id, $user_name, $request_body, 'repurchase', $transaction_id, 'success');
            $insert_into_sales = false;
            $this->repurchase_model->begin();
            $cart_products = $this->cart->contents();
            $insert_into_sales = $this->insertIntoRepuchase($cart_products, $purchase_details);

            $this->repurchase_model->updateUserPv($cart_products, $purchase_details, $this->MODULE_STATUS);

            if (!empty($insert_into_sales)) {
                $this->repurchase_model->commit();
                $this->cart->destroy();
                $this->session->unset_userdata('inf_repurchase');
                $this->session->unset_userdata('repurchase_post_array');
                $this->session->unset_userdata('inf_repurchase_post_array');
                $your_order_is = lang('your_order_is') . $insert_into_sales['invoice_no'];
                $enc_order_id = $this->validation_model->encrypt($insert_into_sales['order_id']);
                $msg = lang('repurchase_completed_successfully');

                $this->redirect("<span><b>$msg </b>  $your_order_is </span>", "repurchase/repurchase_invoice/$enc_order_id", true);
            } else {
                $this->payment_model->insertSquareUpResponse($this->session->userdata('inf_repurchase'), 'repurchase Failed', $this->LOG_USER_ID);
                $this->repurchase_model->rollback();
                $msg = lang('squareup_payment_error');
                $this->redirect($msg, 'repurchase/checkout_product', false);
            }
        } else{
                $this->payment_model->insertSquareUpResponse($this->session->userdata('inf_repurchase'), $response['msg'], $this->LOG_USER_ID);
                $this->session->unset_userdata('inf_repurchase');
                $this->session->unset_userdata('inf_repurchase_post_array');
                $msg = $response['msg'];
                $this->redirect($msg, 'repurchase/checkout_product', false);
        }

    }

    function upload_payment_reciept()
    {
        if ($this->input->is_ajax_request()) {
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
                    $this->session->set_userdata('reciept_name', $doc_file_name);
                    $this->validation_model->updateUploadCount($this->LOG_USER_ID);
                    if ($this->session->userdata('reciept_name')) {
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

}
