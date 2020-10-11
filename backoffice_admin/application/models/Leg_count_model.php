<?php

class leg_count_model extends inf_model {

    private $obj_leg;

    public function initialize($product_status) {
        if ($product_status == 'yes') {
            require_once 'Leg_with_product_model.php';
        } else {
            require_once 'Leg_without_product_model.php';
        }
        $this->obj_leg = new leg_model();
    }

    public function getUserLegDetails($user_id, $page, $limit, $user_type, $table_prefix = '',$mobile='') {
        $this->obj_leg->setTablePrefix($table_prefix);
        if($mobile == 1){
            $user_leg_detail = $this->obj_leg->getUserLegDetailsForMobile($user_id, $page, $limit, $user_type);    
        }else{
            $user_leg_detail = $this->obj_leg->getUserLegDetails($user_id, $page, $limit, $user_type);
        }
        return $user_leg_detail;
    }

    public function getCountUserLegDetails($user_id, $user_type) {
        return $this->obj_leg->getCountUserLegDetails($user_id, $user_type);
    }

    public function getUserIdFromUserName($usr, $table_prefix = '') {
        $this->db->select('id');
        $this->db->select('user_name');
        $this->db->select('user_type');
        $this->db->from($table_prefix . "ft_individual");
        $this->db->where('user_name', $usr);
        $result = $this->db->get();
        foreach ($result->result_array() as $row) {
            $users['user_id'] = $row['id'];
            $users['user_type'] = $row['user_type'];
            $users['user_name'] = $row['user_name'];
        }
        return $users;
    }

    public function getCountLegDetails($user_id) {
        $this->db->from('leg_details');
        $this->db->where('id', $user_id);
        $count = $this->db->count_all_results();
        return $count;
    }

}
