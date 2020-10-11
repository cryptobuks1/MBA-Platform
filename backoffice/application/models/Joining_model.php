<?php

class joining_model extends inf_model {

    public function __construct() {
        $this->load->model('joining_class_model');
    }

    public function todaysJoining($today, $page, $limit) {

        $arr = $this->joining_class_model->todaysJoining($today, $page, $limit);
        for ($i = 0; $i < count($arr); $i++) {
            $father_id = $arr["detail$i"]["father_id"];
            $arr["detail$i"]["father_user"] = $this->joining_class_model->getUserName($father_id);
        }
        return $arr;
    }

    public function todaysJoiningCount($date) {

        return $this->joining_class_model->todaysJoiningCount($date);
    }

    public function weeklyJoining($from, $to, $page, $limit) {

        $arr = $this->joining_class_model->weeklyJoining($from, $to, $page, $limit);
        for ($i = 0; $i < count($arr); $i++) {
            $father_id = $arr["detail$i"]["father_id"];
            $arr["detail$i"]["father_user"] = $this->joining_class_model->getUserName($father_id);
        }
        return $arr;
    }

    public function allJoiningpage($from, $to) {

        return $this->joining_class_model->allJoiningpage($from, $to);
    }

    public function totalJoiningUsers($user_id = '') {
        $numrows = 0;
        if ($user_id == "") {
            $this->db->select('id');
            $this->db->from("ft_individual");
            $this->db->not_like('user_type', 'admin');
            $numrows = $this->db->count_all_results(); // Number of rows returned from above query.
        } else {
            $this->db->select('id');
            $this->db->from("ft_individual");
            $this->db->where('sponsor_id', $user_id);
            $numrows = $this->db->count_all_results(); // Number of rows returned from above query. 
        }
        return $numrows;
    }

    public function getJoiningDetailsperMonth($user_id = '') {
        $details = array();
        $month_start_end_dates = array();
        $month = "";
        $start_date = "";
        $end_date = "";
        $count = 0;
        $yr = "";
        $date = "";
        for ($i = 1; $i <= 12; $i++) {
            $yr = date("Y");
            $date = date("Y-m-d", strtotime("$yr-$i-01"));
            $month_start_end_dates = $this->getCurrentMonthStartEndDates($date);
            $start_date = $month_start_end_dates["month_first_date"] . " 00:00:00";
            $end_date = $month_start_end_dates["month_end_date"] . " 23:59:59";
            $count = $this->getJoiningCountPerMonth($start_date, $end_date, $user_id);

            switch ($i) {
                case 1:
                    $month = "Jan";
                    break;
                case 2:
                    $month = "Feb";
                    break;
                case 3:
                    $month = "Mar";
                    break;
                case 4:
                    $month = "Apr";
                    break;
                case 5:
                    $month = "May";
                    break;
                case 6:
                    $month = "Jun";
                    break;
                case 7:
                    $month = "Jul";
                    break;
                case 8:
                    $month = "Aug";
                    break;
                case 9:
                    $month = "Sep";
                    break;
                case 10:
                    $month = "Oct";
                    break;
                case 11:
                    $month = "Nov";
                    break;
                case 12:
                    $month = "Dec";
                    break;
            }
            $details[$i]["country"] = "United States";
            $details[$i]["month"] = $month;
            $details[$i]["joining"] = $count;
        }
        return $details;
    }

    public function getJoiningCountPerMonth($start_date, $end_date, $user_id = '') {

        $count = 0;
        if ($user_id == "") {

            $this->db->from('ft_individual');
            $this->db->where("date_of_joining >=", $start_date);
            $this->db->where("date_of_joining <=", $end_date);
            $this->db->not_like('user_type', 'admin');
            $count = $this->db->count_all_results();
        } else {
            $this->db->from("ft_individual");
            $this->db->where('sponsor_id', $user_id);
            $this->db->where("date_of_joining >=", $start_date);
            $this->db->where("date_of_joining <=", $end_date);
            $count = $this->db->count_all_results();
        }
        return $count;
    }

    public function getCurrentMonthStartEndDates($current_date) {

        $start_date = '';
        $end_date = '';
        $date = $current_date;

        list($yr, $mo, $da) = explode('-', $date);

        $start_date = date('Y-m-d', mktime(0, 0, 0, $mo, 1, $yr));
        $i = 2;

        list($yr, $mo, $da) = explode('-', $start_date);

        while (date('d', mktime(0, 0, 0, $mo, $i, $yr)) > 1) {
            $end_date = date('Y-m-d', mktime(0, 0, 0, $mo, $i, $yr));
            $i++;
        }

        $ret_arr["month_first_date"] = $start_date;
        $ret_arr["month_end_date"] = $end_date;
        return $ret_arr;
    }

    public function userFullName($user_id) {
        $user_full_name = '';
        $this->db->select('user_detail_name,user_detail_second_name');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', "$user_id");
        $query = $this->db->get();
        foreach ($query->result() as $user_name) {
            $user_full_name = $user_name->user_detail_name;
            $user_full_name .= " " . $user_name->user_detail_second_name;
        }
        return $user_full_name;
    }

    public function placementJoiningUsers($user_id = '') {
        $total_user_details = $this->tree_model->getUserDownlineTreeDetails($user_id);
        return count($total_user_details);
    }

    public function getJoiningDetailsperMonthLeftRight($user_id = '') {
        $details = array();
        $month_start_end_dates = array();
        $month = "";
        $start_date = "";
        $end_date = "";
        $left_count = 0;
        $right_count = 0;
        $yr = "";
        $date = "";

        for ($i = 1; $i <= 12; $i++) {
            $yr = date("Y");
            $date = date("Y-m-d", strtotime("$yr-$i-01"));
            $month_start_end_dates = $this->getCurrentMonthStartEndDates($date);
            $start_date = $month_start_end_dates["month_first_date"] . " 00:00:00";
            $end_date = $month_start_end_dates["month_end_date"] . " 23:59:59";
            $left_user_id = $this->getLeftNodeId($user_id);
            if ($left_user_id) {
                $left_count = $this->tree_model->getLeftRightDownlineUsersCount($left_user_id, "father", $start_date, $end_date);
            }
            $right_user_id = $this->geRighttNodeId($user_id);
            if ($right_user_id) {
                $right_count = $this->tree_model->getLeftRightDownlineUsersCount($right_user_id, "father", $start_date, $end_date);
            }

            switch ($i) {
                case 1:
                    $month = "Jan";
                    break;
                case 2:
                    $month = "Feb";
                    break;
                case 3:
                    $month = "Mar";
                    break;
                case 4:
                    $month = "Apr";
                    break;
                case 5:
                    $month = "May";
                    break;
                case 6:
                    $month = "Jun";
                    break;
                case 7:
                    $month = "Jul";
                    break;
                case 8:
                    $month = "Aug";
                    break;
                case 9:
                    $month = "Sep";
                    break;
                case 10:
                    $month = "Oct";
                    break;
                case 11:
                    $month = "Nov";
                    break;
                case 12:
                    $month = "Dec";
                    break;
            }
            $details[$i]["country"] = "United States";
            $details[$i]["month"] = $month;
            $details[$i]["joining"] = $left_count;
            $details[$i]["joining_right"] = $right_count;
        }
        return $details;
    }

    public function getLeftNodeId($father_id) {
        $user_id_left = NULL;
        $this->db->select("id");
        $this->db->from("ft_individual");
        $this->db->where("father_id", $father_id);
        $this->db->where("position", 'L');
        $rs = $this->db->get();
        foreach ($rs->result() as $id_left) {

            $user_id_left = $id_left->id;
        }
        return $user_id_left;
    }

    public function geRighttNodeId($father_id) {
        $user_id_right = NULL;
        $this->db->select("id");
        $this->db->from("ft_individual");
        $this->db->where("father_id", $father_id);
        $this->db->where("position", 'R');
        $rs = $this->db->get();
        foreach ($rs->result() as $id_right) {
            $user_id_right = $id_right->id;
        }
        return $user_id_right;
    }

    public function getJoiningDetailsForBinaryLeftRight($user_id = '', $start_date = '', $end_date = '') {
        $details = array();
        $left_count = 0;
        $right_count = 0;

        $left_user_id = $this->getLeftNodeId($user_id);
        if ($left_user_id) {
            $left_count = $this->tree_model->getLeftRightDownlineUsersCount($left_user_id, "father", $start_date, $end_date);
        }
        $right_user_id = $this->geRighttNodeId($user_id);
        if ($right_user_id) {
            $right_count = $this->tree_model->getLeftRightDownlineUsersCount($right_user_id, "father", $start_date, $end_date);
        }
        $details["joining"] = $left_count;
        $details["joining_right"] = $right_count;
        return $details;
    }

}
