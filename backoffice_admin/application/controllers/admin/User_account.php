<?php

require_once 'Inf_Controller.php';

class User_Account extends Inf_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('profile_model');
        $this->profile = new profile_model();
    }

    function user_summary_header($username='') {
        $is_valid_username = $this->validation_model->isUserNameAvailable($username);
        $this->set('is_valid_user_name', $is_valid_username);
        $this->load_langauge_scripts();
        $details = array();
        if ($is_valid_username) {
            $user_id = $this->validation_model->userNameToID($username);
            $product_status = $this->MODULE_STATUS['product_status'];

            $profile_arr = $this->profile->getProfileDetails($user_id, $product_status);
            $details = $profile_arr['details'];
            $file_name = $this->profile->getUserPhoto($user_id);
            if (!file_exists(IMG_DIR.'profile_picture/' . $file_name)) {
                $file_name = 'nophoto.jpg';
            }

            $pin_status = $this->MODULE_STATUS['pin_status'];
            $ewallet_status = $this->MODULE_STATUS['ewallet_status'];
            $referal_status = $this->MODULE_STATUS['referal_status'];
            $mlm_plan = $this->MLM_PLAN;

            $this->set('file_name', $file_name);
            $this->set('user_name', $username);
            $this->set('user_id', $user_id);
            $this->set('user_detail', $details);
            $this->set('pin_status', $pin_status);
            $this->set('ewallet_status', $ewallet_status);
            $this->set('referal_status', $referal_status);
            $this->set('mlm_plan', $mlm_plan);
        }
        $this->setView();
    }

}
