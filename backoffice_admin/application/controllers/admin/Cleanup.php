<?php

require_once 'Inf_Controller.php';

class Cleanup extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function clean_up() {
die('Cleanup not allowed.');
        $title = $this->lang->line('clean_up');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        
        if(DEMO_STATUS == 'yes') {
            $is_preset_demo = $this->validation_model->isPresetDemo($this->ADMIN_USER_ID);
            if($is_preset_demo) {
                $msg = '<strong>Warning!</strong> Cleanup not allowed for Preset Demos.';
                $this->redirect($msg, "home/index", false);
            }
        }

       // $res = $this->cleanup_model->clean($this->MODULE_STATUS);

        if ($res) {
            $msg = $this->lang->line('Cleanup_done_successfully');
            $this->redirect($msg, "home/index", true);
        } else {
            $msg = $this->lang->line('Clean_up_failed_try_again');
            $this->redirect($msg, "home/index", false);
        }
    }

}
