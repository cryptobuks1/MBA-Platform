<?php
require_once 'Inf_Controller.php';

class Ticket extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }


    function ticket_system() {
        if ($this->MODULE_STATUS['ticket_system_status'] == "yes" && $this->MODULE_STATUS['ticket_system_status_demo'] == "yes") {
            $table_prefix = $this->table_prefix;
            $admin_id = $this->ADMIN_USER_ID;
            header("Location: " . base_url() . "admin/ticket_system/admin_home_page");
        } else {
            $message = lang('ticket_system_not_enabled');
            $this->redirect($message, 'home', FALSE);
        }
    }
}


