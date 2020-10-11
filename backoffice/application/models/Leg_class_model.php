<?php

Class leg_class_model extends inf_model {

    var $user_leg_det = Array();
    var $total_user_leg_det = Array();
    public $user_arr = null;
    public $table_prefix = "";
    public $total_user_det = Array();

    public function __construct() {
        $this->load->model('validation_model');
    }

    public function getLeftLegCount($id) {
        $this->user_arr = null;
        $left_leg_count = 0;
        $id_left = $this->validation_model->getLeftNodeId($id);
        if ($id_left > 0) {
            $this->user_arr[] = $id_left;
            $arr[] = $id_left;
            $arr = $this->getUserArray($arr);

            $left_leg_count = count($this->user_arr);
        }

        return $left_leg_count;
    }

    public function getRightLegCount($id) {
        $this->user_arr = null;
        $right_leg_count = 0;
        $id_right = $this->validation_model->geRighttNodeId($id);
        if ($id_right > 0) {
            $this->user_arr[] = $id_right;
            $arr[] = $id_right;

            $arr = $this->getUserArray($arr);

            $right_leg_count = count($this->user_arr);
        }
        return $right_leg_count;
    }

    public function getUserArray($arr) {
        $user_id_temp = null;
        $user_id = $arr;
        $select_users = "";
        $sql = "";
        $count_id = count($user_id);
        $flag = 0;
        if (count($user_id) > 0) {
            for ($i = 0; $i < $count_id; $i++) {
                if ($i !== 0) {
                    $flag = 1;
                    $sql .= " OR  father_id='$user_id[$i]'";
                } else {



                    $this->db->select('id');
                    $this->db->from('ft_individual');
                    $this->db->where('active', 'yes');
                    $this->db->where('father_id', $user_id[$i]);
                    $query = $this->db->get();

                }
            }
            $as = "";
            if ($i > 0) {
                $as = " )";
                $select_users.=$sql . " )";
            } else {
                $select_users.=$sql;
            }
            //echo "<br>$flag ".$select_users;
            //$res1 = $this->selectData($select_users);
            foreach ($query->result_array() as $row) {

                $this->user_arr[] = $row['id'];
                $user_id[] = $row['id'];
                $user_id_temp[] = $row['id'];
            }
        }

        $count = count($user_id_temp);
        if ($count > 0) {
            if ($count >= 8) {
                $input_array = $user_id_temp;
                $split_arr = array_chunk($input_array, intval($count / 4));
                for ($i = 0; $i < count($split_arr); $i++) {
                    $this->getUserArray($split_arr[$i]);
                }
            } else {

                $this->getUserArray($user_id_temp);
            }
        }
        return $user_id_temp;
    }
    
}
