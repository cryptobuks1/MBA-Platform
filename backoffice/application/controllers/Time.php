<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'Inf_Controller.php';

class Time extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function check_time_out() {
        $status = "";
        if ($this->session->userdata("inf_user_page_load_time")) {
            $current_time = time();
            $page_load_time = $this->session->userdata("inf_user_page_load_time");
            //inactiviy logout setting
            $time = $this->configuration_model->selectLogoutTime();

            if ($current_time - $page_load_time >= $time) { //time in seconds
                $status = "expired";
            }
            //
        } else {
            $status = "expired";
        }
        echo $status;
        exit();
    }

}
