<?php

Class api_register_model extends Inf_Model {

    public function __construct() {

    }

    public function validateTablePrefix($admin_id, $table_prefix) {
        $dbprefix = $this->db->dbprefix;
        $this->db->set_dbprefix(NULL);
        $count = 0;
        $this->db->where('account_status !=', 'deleted');
        $this->db->where('id', $admin_id);
        $this->db->where('table_prefix', $table_prefix);
        $count = $this->db->count_all_results('infinite_mlm_user_detail');
        $this->db->set_dbprefix($dbprefix);
        return $count;
    }
}