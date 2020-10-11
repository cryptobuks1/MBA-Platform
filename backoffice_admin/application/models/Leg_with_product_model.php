<?php

Class leg_model extends inf_model {

    var $user_leg_det = Array();
    var $total_user_leg_det = Array();
    public $user_arr = null;
    public $table_prefix = "";

    public function setTablePrefix($table_prefix) {
        $this->table_prefix = $table_prefix;
    }

    public function __construct() {
        $this->load->model('validation_model');

        if ($this->table_prefix == "") {
            $this->table_prefix = $this->session->userdata('inf_table_prefix');
        }
    }

    public function getUserLegDetails($user_id, $page, $limit, $user_type) {

        /////////////////////  CODE EDITED BY JIJI  //////////////////////////
        //echo $page.'/'.$limit;
        $user_leg_det=array();
        $this->db->select('lg.*');
        $this->db->from('leg_details as lg');
        $this->db->join("ft_individual as ft", "ft.id = lg.id");
        if ($user_type != 'admin')
            $this->db->where('lg.id', $user_id);
        $this->db->limit($limit, $page);
        $query = $this->db->get();
        $j = 0;
        foreach ($query->result_array() as $row) {
            $user_leg_det["detail$j"]["user"] = $this->validation_model->IdToUserName($row['id']);
            $user_leg_det["detail$j"]["detail"] = $this->validation_model->getUserFullName($row['id']);
            $user_leg_det["detail$j"]["left"] = $row['total_left_count'];
            $user_leg_det["detail$j"]["right"] = $row['total_right_count'];
            $user_leg_det["detail$j"]["left_carry"] = $row['total_left_carry'];
            $user_leg_det["detail$j"]["right_carry"] = $row['total_right_carry'];
            $total_leg_arr = $this->getTotalLegTotalAmount($row['id']);
            $tot_leg = $total_leg_arr['total_leg'];
            $tot_amount = $total_leg_arr['total_amount'];
            $user_leg_det["detail$j"]["total_leg"] = $tot_leg;
            $user_leg_det["detail$j"]["total_amount"] = round($tot_amount, 8);
            $j = $j + 1;
        }
        return $user_leg_det;
    }

    public function getUserStatus($user_id) {
        $status = "0";

        $this->db->select('active');
        $this->db->from("ft_individual");
        $this->db->where("id", $user_id);
        $qry = $this->db->get();
        foreach ($qry->result() as $row) {
            return $row->active;
        }
    }

/////////code ends    
    public function getCountUserLegDetails($user_id, $user_type) {

        /////////////////////  CODE EDITED BY JIJI  //////////////////////////

        $count_leg_details = 0;
        if ($user_type == 'admin') {

            $this->db->select("id,user_name");
            $this->db->from($this->table_prefix . "ft_individual");
            $this->db->where("active", "yes");
            $count_leg_details = $this->db->count_all_results();
        } else {

            $this->db->select("id,user_name");
            $this->db->from($this->table_prefix . "ft_individual");
            $this->db->where("active", "yes");
            $this->db->where("id", "$user_id");

            $count_leg_details = $this->db->count_all_results();
        }
        return $count_leg_details;
    }

    public function getTotalLegTotalAmount($user_id) {
        $this->db->select_sum("total_leg");
        $this->db->select_sum("total_amount");
        $this->db->from($this->table_prefix . "leg_amount");
        $this->db->where("user_id", "$user_id");
        $this->db->where_in('amount_type', array('leg', 'repurchase_leg'));
        $query = $this->db->get();
        foreach ($query->result() as $row) {

            if ($row->total_leg == "") {
                $tot_arr['total_leg'] = '0';
            } else {
                $tot_arr['total_leg'] = $row->total_leg;
            }
            if ($row->total_amount == "") {
                $tot_arr['total_amount'] = '0';
            } else
            $tot_arr['total_amount'] = $row->total_amount;
        }
        return $tot_arr;
    }
    
    public function getUserLegDetailsForMobile($user_id, $page, $limit, $user_type) {

        /////////////////////  CODE EDITED BY JIJI  //////////////////////////
        //echo $page.'/'.$limit;
        $user_leg_det=array();
        $this->db->select('lg.*');
        $this->db->from('leg_details as lg');
        $this->db->join("ft_individual as ft", "ft.id = lg.id");
        if ($user_type != 'admin')
            $this->db->where('lg.id', $user_id);
        $this->db->limit($limit, $page);
        $query = $this->db->get();
        $j = 0;
        foreach ($query->result_array() as $row) {
            $user_leg_det["$j"]["user"] = $this->validation_model->IdToUserName($row['id']);
            $user_leg_det["$j"]["detail"] = $this->validation_model->getUserFullName($row['id']);
            $user_leg_det["$j"]["left"] = $row['total_left_count'];
            $user_leg_det["$j"]["right"] = $row['total_right_count'];
            $user_leg_det["$j"]["left_carry"] = $row['total_left_carry'];
            $user_leg_det["$j"]["right_carry"] = $row['total_right_carry'];
            $total_leg_arr = $this->getTotalLegTotalAmount($row['id']);
            $tot_leg = $total_leg_arr['total_leg'];
            $tot_amount = $total_leg_arr['total_amount'];
            $user_leg_det["$j"]["total_leg"] = $tot_leg;
            $user_leg_det["$j"]["total_amount"] = round($tot_amount, 8);
            $j = $j + 1;
        }
        return $user_leg_det;
    }


}
