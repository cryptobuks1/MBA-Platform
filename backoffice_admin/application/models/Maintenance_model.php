<?php

class maintenance_model extends inf_model {

    function __construct() {
        parent::__construct();
    }

    public function getSitemaintanenceConfig() {
        $arr_data = array();
        $this->db->select("*");
        $this->db->from('site_maintenance');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $arr_data = $row;
        }
        return $arr_data;
    }

    public function updateSiteMaintanence($data) {
        $this->db->set("status", $data['status']);
        if ($data['status']) {
            $this->db->set("title", $data['title']);
            $this->db->set("description", trim($data['description']));
            $this->db->set("date_of_availability", $data['date_available']);
        }
        $this->db->set("block_login", $data['block_login']);
        $this->db->set("block_register", $data['block_register']);
        $this->db->set("block_ecommerce", $data['block_ecommerce']);
        $this->db->where('id', 1);
        $query = $this->db->update('site_maintenance');

        if ($query) {
            $MODULE_STATUS = $this->trackModule();
            if ($MODULE_STATUS['opencart_status_demo'] == "yes" && $MODULE_STATUS['opencart_status'] == "yes") {
                $this->db->set('value', $data['status']);
                $this->db->where('code', 'config');
                $this->db->where('key', 'config_maintenance');
                $this->db->where('store_id', '0');
                $this->db->update('oc_setting');
            }
        }

        return $query;
    }

}
