<?php

Class oc_register_model extends inf_model {

    public function __construct() {
        parent::__construct();
        $this->load->model('calculation_model');
        if ($this->MLM_PLAN == 'Hyip' || $this->MLM_PLAN == 'X-Up') {
            $this->load->model('Unilevel_model', 'plan_model');
        }
        else {
            $this->load->model($this->MLM_PLAN . '_model', 'plan_model');
        }
    }

    public function confirmRegister($regr, $module_status) {
        $this->load->model('register_model');
        $status = $this->register_model->confirmRegister($regr, $module_status);
        return $status;
    }

    public function confirmRegisterReplica($regr, $module_status, $pending_signup_status = FALSE) {
        $this->load->model('register_model');
        $status = $this->register_model->confirmRegister($regr, $module_status, $pending_signup_status);
        //$user_id = $this->validation_model->userNameToID(status['user']);
//
//        if ($this->MODULE_STATUS['opencart_status'] == "yes" || $this->MODULE_STATUS['opencart_status_demo'] == "yes") {
//            $this->register_model->addToCustomerTables($user_id, $regr);
//        }
        return $status;
    }

    public function distributeRePurchaseCommission($order_details, $module_status) {
        $status = FALSE;
        $oc_order_id = $order_details['order_id'];
        $user_id = $order_details['user_id'];
        $ordered_products = $order_details['order_data'];

        $total_order_pv = 0;
        $product_id = 0;
        $total_order_price = 0;
        $total_quantitiy= 0;
        foreach ($ordered_products AS $order) {
            $product_id = $order['product_id'];
            $quantity = $order['quantity'];
            $pv = $order['pair_value'];
            $total_product_pv = $quantity * $pv;
            $total_order_pv += $total_product_pv;
            $total_order_price += $order['total'];
            $total_quantitiy += $quantity;
        }

        $mlm_plan = $module_status['mlm_plan'];
        $upline_details = $this->validation_model->getUserFTDetails($user_id);
        $upline_id = $upline_details['father_id'];
        $user_position = $upline_details['position'];

        $action = 'repurchase';
        $sponsor_id = $this->validation_model->getSponsorId($user_id);   
        if($mlm_plan == 'Matrix'){
            $upline_id = $sponsor_id;
        }
        $data = array();
        $data['sponsor_id'] = $sponsor_id;
        //CALCULATION SECTION STARTS//
        $status = $this->plan_model->runCalculation($action, $user_id, $product_id, $total_order_pv, $total_order_price, $oc_order_id, $upline_id, $total_quantitiy, $user_position, $data);
        //CALCULATION SECTION ENDS//
                           
        return $status;
    }

}
