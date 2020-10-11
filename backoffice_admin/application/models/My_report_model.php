<?php

class my_report_model extends inf_model
{

    public $referals;
    public $obj_cal;

    public function __construct()
    {
        parent::__construct();
        $this->referals = array();
        $this->load->model('validation_model');
    }

    public function getAllUnilevel($id, $limit = '', $page = '', $level_value = '')
    {
        $arr = $this->getDownlineUsersForHistory($id, 'left_sponsor', 'right_sponsor', $limit, $page, 'unilevel', $level_value);
        return $arr;
    }

    public function getDownlineDetailsBinary($id, $limit = '', $page = '', $level_value = '',$rank_id,$type = '')
    {
        $arr = $this->getDownlineBinary($id, 'left_father', 'right_father', $limit, $page, 'binary', $level_value,$rank_id,$type);
        return $arr;
    }

    public function findUserlevel($id, $logged_user, $level = 1, $plan)
    {

        $table = "ft_individual";
        if ($plan == 'unilevel') {

            $this->db->select('sponsor_id');
            $this->db->where('id', $id);
            $this->db->limit(1);
            $res = $this->db->get($table);
            foreach ($res->result() as $row) {

                if ($logged_user == $row->sponsor_id) {

                    return $level;
                } else {
                    $ret_level = $this->findUserlevel($row->sponsor_id, $logged_user, $level + 1, $plan);

                    return $ret_level;
                }
            }
        } else {
            $this->db->select('father_id');
            $this->db->where('id', $id);
            $this->db->limit(1);
            $res = $this->db->get($table);
            foreach ($res->result() as $row) {

                if ($logged_user == $row->father_id) {

                    return $level;
                } else {
                    $ret_level = $this->findUserlevel($row->father_id, $logged_user, $level + 1, $plan);

                    return $ret_level;
                }
            }
        }
    }

    public function getDownlineUsersForHistory($user_id, $left_field, $right_field, $limit, $page = 0, $plan = 'binary', $level_value = '')
    {
        $this->load->model('country_state_model');
        $this->db->select("$left_field, $right_field");
        $this->db->where('ft_id', $user_id);
        $root = $this->db->get('tree_parser');
        $root = $root->result_array();
        $left = $root[0]["$left_field"];
        $right = $root[0]["$right_field"];

        $this->db->select('ft.id,ft.user_name,ft.date_of_joining,ft.user_rank_id,ft.active,ud.user_detail_name,ud.user_detail_second_name,ud.user_detail_city,ud.user_detail_country,ud.user_detail_state,ud.user_photo');
        // $this->db->select("*");
        $this->db->from('ft_individual AS ft');
        $this->db->join('tree_parser t', 't.ft_id = ft.id', 'LEFT');
        $this->db->join('user_details AS ud', 'ft.id = ud.user_detail_refid');
        $this->db->where("t.$left_field >", $left);
        $this->db->where("t.$right_field <", $right);
        if ($level_value != '' && $plan == 'unilevel') {
            $this->db->where("ft.sponsor_level", $level_value);
        } else if ($level_value != '' && $plan == 'binary') {
            $this->db->where("ft.user_level", $level_value);
        }
        $this->db->order_by("ft.sponsor_level", "asc");
        $this->db->limit($limit, $page);
        $res = $this->db->get();
        $i = 0;
        $referrals = array();
        foreach ($res->result_array() as $row) {
            $id_encode = $this->encrypt->encode($row['id']);
            $id_encode = str_replace("/", "_", $id_encode);
            $id_encode = str_replace("+", "-", $id_encode);
            $encrypt_id = urlencode($id_encode);
            $referrals[$i]['id'] = $encrypt_id;
            $referrals[$i]['date_of_joining'] = $row['date_of_joining'];
            $referrals[$i]['name'] = $row['user_detail_name'];
            $referrals[$i]['name'] .= " " . $row['user_detail_second_name'];
            $referrals[$i]['username'] = $row['user_name'];
            $referrals[$i]['active'] = $row['active'];
            if ($this->MODULE_STATUS['rank_status'] == 'yes') {

                $referrals[$i]['rank'] = $this->validation_model->getRankName($row['user_rank_id']);
                $referrals[$i]['rank_color'] = $this->validation_model->getRankColor($row['user_rank_id']);
            }

            $username_encode = $this->encrypt->encode($row['user_name']);
            $username_encode = str_replace("/", "_", $username_encode);
            $username_encode = urlencode($username_encode);
            $referrals[$i]['username_enc'] = $username_encode;

            if ($row['user_detail_state'] == "") {
                $referrals[$i]['state'] = "NA";
            } else {
                $referrals[$i]['state'] = $this->country_state_model->getStateNameFromId($row['user_detail_state']);
            }
            if ($row['user_detail_city'] == "0") {
                $referrals[$i]['city'] = "NA";
            } else {
                $referrals[$i]['city'] = $row['user_detail_city'];
            }
            $referrals[$i]['country'] = $this->country_state_model->getCountryNameFromId($row['user_detail_country']);
            $referrals[$i]['level'] = $level = $this->findUserlevel($row['id'], $user_id, 1, $plan);
            $i++;
        }
        if (count($referrals) > 0) {
            foreach ($referrals as $key => $row) {
                $arr[$key] = $row['level'];
            }
            array_multisort($arr, SORT_ASC, $referrals);
        }
        return $referrals;
    }
    public function getTotalDownlineUsersForHistory($user_id, $left_field, $right_field, $plan = 'binary', $level_value = '')
    {

        $this->load->model('country_state_model');
        $this->db->select("$left_field, $right_field");
        $this->db->where('ft_id', $user_id);
        $root = $this->db->get('tree_parser');
        $root = $root->result_array();
        $left = $root[0]["$left_field"];
        $right = $root[0]["$right_field"];

        $this->db->select('ft.id,ft.user_name,ft.date_of_joining,ud.user_detail_name,ud.user_detail_second_name,ud.user_detail_city,ud.user_detail_country,ud.user_detail_state,ud.user_photo');
        $this->db->from('ft_individual AS ft');
        $this->db->join('tree_parser t', 't.ft_id = ft.id', 'LEFT');
        $this->db->join('user_details AS ud', 'ft.id = ud.user_detail_refid');
        $this->db->where("t.$left_field >", $left);
        $this->db->where("t.$right_field <", $right);
        if ($level_value != '') {
            $this->db->where("ft.sponsor_level", $level_value);
        }
        $res = $this->db->get();
        $count = count($res->result_array());

        $i = 0;
        $referrals = array();
        foreach ($res->result_array() as $row) {
            $referrals[$i]['level'] = $level = $this->findUserlevel($row['id'], $user_id, 1, $plan);
            $i++;
        }
        if (count($referrals) > 0) {
            foreach ($referrals as $key => $row) {
                $arr[$key] = $row['level'];
            }
            array_multisort($arr, SORT_ASC, $referrals);
        }
        $referrals['count'] = $count;
        return $referrals;
    }
    public function getMaxLevelUser($user_id, $left_field, $right_field) {
        $this->db->select("$left_field, $right_field");
        $this->db->where('ft_id', $user_id);
        $root = $this->db->get('tree_parser');
        $root = $root->result_array();
        $left = $root[0]["$left_field"];
        $right = $root[0]["$right_field"];

        $this->db->select_max('user_level');
        $this->db->from('ft_individual AS ft');
        $this->db->join('tree_parser t', 't.ft_id = ft.id', 'LEFT');
        $this->db->where("t.$left_field >", $left);
        $this->db->where("t.$right_field <", $right);
        $result = $this->db->get()->row();//echo $this->db->last_query(); die;
        return $result->user_level;
    }
    public function getDownlineBinary($user_id, $left_field, $right_field, $limit, $page = 0, $plan = 'binary', $level_value = '',$rank_id='',$type = '')
    {
        $level = $this->validation_model->getUserLevel($user_id);

        $this->load->model('country_state_model');
        $this->db->select("$left_field, $right_field");
        $this->db->where('ft_id', $user_id);
        $root = $this->db->get('tree_parser');
        $root = $root->result_array();
        $left = $root[0]["$left_field"];
        $right = $root[0]["$right_field"];

        $this->db->select("ft.user_level - {$level} as ref_level,ft.id,ft.user_name,ft.date_of_joining,ft.user_rank_id,ft.active,ud.user_detail_name,ud.user_detail_second_name,ud.user_detail_city,ud.user_detail_country,ud.user_detail_state,ud.user_photo", false);
        $this->db->from('ft_individual AS ft');
        $this->db->join('tree_parser t', 't.ft_id = ft.id', 'LEFT');
        $this->db->join('user_details AS ud', 'ft.id = ud.user_detail_refid');
        $this->db->where("t.$left_field >", $left);
        $this->db->where("t.$right_field <", $right);
        if ($level_value != '' && $plan == 'unilevel') {
            $this->db->where("ft.sponsor_level", $level_value);
        } else if ($level_value != '' && $plan == 'binary') {
            $this->db->where("ft.user_level", $level_value);
        }
        if($rank_id){
             $this->db->where("ft.user_rank_id", $rank_id);
        }
        if($type != '' && $type != 'all'){
             $this->db->where("ft.join_type", $type);
        }
        $this->db->order_by("ref_level", "asc");
        $this->db->limit($limit, $page);
        $res = $this->db->get();
        $i = 0;
        $referrals = array();
        foreach ($res->result_array() as $row) {
            $id_encode = $this->encrypt->encode($row['id']);
            $id_encode = str_replace("/", "_", $id_encode);
            $id_encode = str_replace("+", "-", $id_encode);
            $encrypt_id = urlencode($id_encode);
            $referrals[$i]['id'] = $encrypt_id;
            $referrals[$i]['date_of_joining'] = $row['date_of_joining'];
            $referrals[$i]['name'] = $row['user_detail_name'];
            $referrals[$i]['name'] .= " " . $row['user_detail_second_name'];
            $referrals[$i]['username'] = $row['user_name'];
            $referrals[$i]['active'] = $row['active'];
            if ($this->MODULE_STATUS['rank_status'] == 'yes') {

                $referrals[$i]['rank'] = $this->validation_model->getRankName($row['user_rank_id']);
                $referrals[$i]['rank_color'] = $this->validation_model->getRankColor($row['user_rank_id']);
            }

            $username_encode = $this->encrypt->encode($row['user_name']);
            $username_encode = str_replace("/", "_", $username_encode);
            $username_encode = urlencode($username_encode);
            $referrals[$i]['username_enc'] = $username_encode;

            if ($row['user_detail_state'] == "") {
                $referrals[$i]['state'] = "NA";
            } else {
                $referrals[$i]['state'] = $this->country_state_model->getStateNameFromId($row['user_detail_state']);
            }
            if ($row['user_detail_city'] == "0") {
                $referrals[$i]['city'] = "NA";
            } else {
                $referrals[$i]['city'] = $row['user_detail_city'];
            }
            $referrals[$i]['country'] = $this->country_state_model->getCountryNameFromId($row['user_detail_country']);
            $referrals[$i]['level'] =  $row['ref_level'];
            $i++;
        }
        return $referrals;
    }
    public function getTotalDownlineUsersBinary($user_id, $left_field, $right_field, $plan = 'binary', $level_value = '',$rank_id='',$type = '')
    {

        $this->db->select("$left_field, $right_field");
        $this->db->where('ft_id', $user_id);
        $root = $this->db->get('tree_parser');
        $root = $root->result_array();
        $left = $root[0]["$left_field"];
        $right = $root[0]["$right_field"];

        $this->db->select('count(*) count');
        $this->db->from('ft_individual AS ft');
        $this->db->join('tree_parser t', 't.ft_id = ft.id', 'LEFT');
        $this->db->join('user_details AS ud', 'ft.id = ud.user_detail_refid');
        $this->db->where("t.$left_field >", $left);
        $this->db->where("t.$right_field <", $right);
        if ($level_value != '') {
            $this->db->where("ft.user_level", $level_value);
        }
        if($rank_id){
             $this->db->where("ft.user_rank_id", $rank_id);
        }
        if($type != '' && $type != 'all'){
             $this->db->where("ft.join_type", $type);
        }
        $res = $this->db->get();
        $count = $res->row()->count;
       // echo $count; die;
        return $count;
    }
}
