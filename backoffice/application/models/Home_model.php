<?php

Class home_model extends inf_model {

    public function __construct() {

        $this->load->model('validation_model');
        $this->load->model('joining_class_model');
        $this->load->model('joining_model');
        $this->load->model('mail_model');
        if ($this->LOG_USER_ID && $this->MODULE_STATUS['pin_status'] == 'yes') {
            $this->load->model('epin_model');
        }
        $this->load->model('ewallet_model');
        $this->load->model('payout_model');
        $this->load->model('tree_model');
        $this->load->model('configuration_model');
    }

    public function todaysJoiningCount($user_id = '') {
        $date = date("Y-m-d");
        return $this->joining_class_model->todaysJoiningCount($date, $user_id);
    }

    public function totalJoiningUsers($user_id = '') {
        return $this->joining_model->totalJoiningUsers($user_id);
    }

    public function getAllReadMessages($type) {
        return $this->mail_model->getAllReadMessages($type);
    }

    public function getAllUnreadMessages($type) {
        return $this->mail_model->getAllUnreadMessages($type);
    }

    public function getAllMessagesToday($type) {
        return $this->mail_model->getAllMessagesToday($type);
    }

    public function getGrandTotalEwallet($user_id = '') {
        return $this->ewallet_model->getGrandTotalEwallet($user_id);
    }

    public function getTotalRequestAmount($user_id = '') {
        return $this->ewallet_model->getTotalRequestAmount($user_id);
    }

    public function getTotalReleasedAmount($user_id = '') {
        return $this->ewallet_model->getTotalReleasedAmount($user_id);
    }

    public function getJoiningDetailsperMonth($user_id = '') {
        return $this->joining_model->getJoiningDetailsperMonth($user_id);
    }
    public function getTotalCommission($user_id = '',$start_date = '',$end_date = '') {
        return $this->ewallet_model->getTotalCommission($user_id,$start_date,$end_date);
    }
    public function getTotalDonation($user_id = '',$start_date = '',$end_date = '') {
        return $this->ewallet_model->getTotalDonation($user_id,$start_date,$end_date);
    }

    public function getNotifications() {
        $notifications = array();

        $date = date("Y-m-d H:i:s", time() - 30);

        $this->db->select('id,user_id,done_by,ip,activity');
        $this->db->from('activity_history');
        $this->db->where('date >', $date);
        $this->db->where('notification_status', 0);
        $this->db->where('done_by_type !=', 'admin');
        $this->db->where('done_by !=', '');
        $this->db->order_by('date', 'DESC');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(5);
        $query = $this->db->get();

        foreach ($query->result_array() as $row) {

            $doneby_user_name = $this->validation_model->idToUserName($row['done_by']);
            $user_name = $this->validation_model->idToUserName($row['user_id']);
            $ip = $row['ip'];
            $activity = 'user_' . $row['activity'];
            $message = sprintf(lang($activity), $doneby_user_name, $ip);
            if ($message == '') {
                $message = "$doneby_user_name" . $this->lang->line('performed') . "'$activity'";
            }
            $row["message"] = $message;
            $notifications [] = $row;

            $this->db->set("notification_status", 1);
            $this->db->where("id", $row["id"]);
            $this->db->update("activity_history");
        }
        return $notifications;
    }

    public function getTopRecruters($count = 5, $sponsor_id = "") {
        $details = array();
        $sponsor_left = '';
        $sponsor_right = '';
        if ($sponsor_id) {
            $sponsor_left_right = $this->validation_model->getUserLeftAndRight($sponsor_id, "sponsor");
            $sponsor_left = $sponsor_left_right['left_sponsor'];
            $sponsor_right = $sponsor_left_right['right_sponsor'];
        }
        $this->db->select('count(f1.sponsor_id) as count,f2.user_name,u.user_photo as profile_picture');
        $this->db->from('ft_individual as f1');
        $this->db->join('tree_parser t', 't.ft_id = f1.id', 'LEFT');
        $this->db->where('f1.sponsor_id !=', 0);
        $this->db->where('f1.sponsor_id !=', $sponsor_id);
        $this->db->where("t.left_sponsor >", $sponsor_left);
        $this->db->where("t.right_sponsor <", $sponsor_right);
        $this->db->join("ft_individual as f2", "f1.sponsor_id = f2.id");
        $this->db->join("user_details as u", "u.user_detail_refid = f2.id");

        $this->db->group_by('f1.sponsor_id');
        $this->db->order_by('count', 'DESC');
        $this->db->limit($count);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getTopEarners($count = 5, $sponsor_id = "") {
        $details = array();

        if ($sponsor_id) {
            $sponsor_left_right = $this->validation_model->getUserLeftAndRight($sponsor_id, "sponsor");
            $sponsor_left = $sponsor_left_right['left_sponsor'];
            $sponsor_right = $sponsor_left_right['right_sponsor'];
            $downlines = $this->validation_model->getDownlineUsers($sponsor_left, $sponsor_right, "sponsor");
            array_push($downlines, $sponsor_id);
            $this->db->where_in('sponsor_id', $downlines);
        }

        $this->db->select('sum(leg.amount_payable) as balance_amount,ft.user_name as user_name,ft.id');
        $this->db->from('ft_individual as ft');
        $this->db->where('sponsor_id !=', 0);
        $this->db->where('amount_payable !=', 0);
        $this->db->join("leg_amount as leg", "leg.user_id = ft.id");
        $this->db->group_by('ft.id');
        $this->db->order_by('sum(amount_payable)', 'DESC');
        $this->db->limit($count);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function todaysPlacementJoiningCount($user_id = '') {
        $date = date("Y-m-d");
        $total_user_details = $this->tree_model->getUserDownlineTreeDetails($user_id);
        $count = 0;
        $i = 0;
        foreach ($total_user_details as $row) {
            $join = date('Y-m-d', strtotime($row['join_date']));

            if ($date === $join) {
                $i++;
            }
        }
        return $i;
    }

    public function placementJoiningUsers($user_id = '') {
        return $this->joining_model->placementJoiningUsers($user_id);
    }

    /* Ajax function Starts */

    public function getMailCount($type, $start_date, $end_date, $read_status, $all = "notall") {
        $inf_sess = $this->session->userdata('inf_logged_in');
        $user_name = $inf_sess['user_name'];
        $id = $this->validation_model->userNameToID($user_name);
        $numrows = 0;
        if ($type == "admin") {
            $mail = 'mailtoadmin';
            $this->db->select('mailadid');
            $where = "mailadiddate between '$start_date' and '$end_date'";
        } else if ($type == "user") {
            $mail = 'mailtouser';
            $this->db->select('mailtousid');
            $this->db->where('mailtoususer', $id);
            $where = "mailtousdate between '$start_date' and '$end_date'";
        }
        $this->db->where('status', 'yes');
        if ($all != "all") {
            if ($read_status) {
                $this->db->where('read_msg', $read_status);
            }
            $this->db->where($where);
        }
        $this->db->from($mail);
        $numrows = $this->db->count_all_results(); // Number of rows returned from above query.
        return $numrows;
    }

    /* Ajax function  End */

    public function getSocialMediaInfo() {
        $this->db->select('fb_link,twitter_link,inst_link,gplus_link,fb_count,twitter_count,inst_count,gplus_count');
        $res = $this->db->get('site_information');
        return $res->row_array();
    }

    public function getSocialmediaFollowers() {
        return $this->configuration_model->getSocialMediaFollowersCount();
    }

    /* Ajax For Dynamic Box in Second row Begins */

    public function getSocialmediaLinks() {
        return $this->configuration_model->getSocialMediaLinks();
    }

    /* Ajax For Dynamic Box in Second row Ends */

    public function getCountToDoList($user_id = '') {

        $this->db->select('task_id,task,time,user_id');
        $this->db->where('user_id', $user_id);
        $this->db->from("to_do_list");
        $numrows = $this->db->count_all_results(); // Number of rows returned from above query.
        return $numrows;
    }

    public function getToDoList($user_id = '', $id = '', $emp_id = '') {
        $this->db->select("DATEDIFF(CURDATE(),time) as days");
        $this->db->select('task_id,task,time,status,user_id');
        if ($user_id != '') {
        $this->db->where('user_id', $user_id);
        }
        if ($id != '') {
            $this->db->where('task_id =', $id);
        }
        if ($emp_id != '') {
            $this->db->or_where('user_id', $emp_id);
        }
        //$this->db->where("DATEDIFF(NOW(), time) BETWEEN 30 AND 60");
        $this->db->from("to_do_list");

        $this->db->order_by("time", "asc");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function addToDoList($task, $task_time, $user_id) {

        $this->db->set('task', $task);
        $this->db->set('time', $task_time);
        $this->db->set('user_id', $user_id);
        $this->db->set('status', 'not_started');
        return $this->db->insert("to_do_list");
    }

    public function updateToDoList($task, $task_time, $user_id = '', $task_id) {

        $this->db->set('task', $task);
        $this->db->set('time', $task_time);
        if ($user_id != '') {
        $this->db->where('user_id', $user_id);
        }
        $this->db->where('task_id', $task_id);
        return $this->db->update("to_do_list");
    }

    public function deleteToDoList($user_id, $task_id) {

        $this->db->where('user_id =', $user_id);
        $this->db->where('task_id =', $task_id);
        return $query = $this->db->delete('to_do_list');
    }

    public function ChangeToDoStatus($user_id, $task_id, $status) {
        $this->db->set('status', $status);
        $this->db->where('user_id', $user_id);
        $this->db->where('task_id', $task_id);
        return $this->db->update("to_do_list");
    }

    public function getCountryMapdata($user_id = '') {
        $data = array();
        $this->db->select('c.country_code,COUNT(u.user_detail_id) as count');
        $this->db->from("infinite_countries as c");
        if ($user_id != "") {
            $join_condition = "c.country_id=u.user_detail_country and u.user_details_ref_user_id=$user_id";
        } else {
            $join_condition = "c.country_id=u.user_detail_country and u.user_detail_refid!= $this->ADMIN_USER_ID";
        }
        $this->db->join('user_details as u', $join_condition, 'left');
        $this->db->group_by('c.country_id');
        $result = $this->db->get();
        foreach ($result->result_array() as $row) {
            $data[strtoupper($row["country_code"])] = $row["count"];
        }
        return json_encode($data);
    }

    public function getLatestJoinees($user_type = '') {
        $data = array();
        $from_date = date('Y-m-d');
        $to_date = date('Y-m-d', strtotime($from_date . '-7 days'));
        $this->db->select('id,user_name,active,date_of_joining');
        $this->db->from("ft_individual");
        $this->db->where('user_type !=', 'admin');
        $this->db->where('active !=', 'terminated');
        $this->db->where('active !=', 'no');
        $this->db->where('id !=', $this->LOG_USER_ID);
        $this->db->limit(10);
        if ($user_type == 'user') {
            $this->db->where('sponsor_id', $this->LOG_USER_ID);
        }
        $this->db->order_by("date_of_joining", "desc");
        $query = $this->db->get();
        $result = $query->result_array();
        $cnt = $query->num_rows();
        if ($cnt > 0) {
            $i = 0;
            foreach ($result as $search_latest) {
                $data[$i]["id"] = $search_latest['id'];
                $data[$i]["user_name"] = $search_latest['user_name'];
                $data[$i]["active"] = $search_latest['active'];
                if (date("Y-m-d", strtotime($search_latest['date_of_joining'])) == $from_date) {
                    $data[$i]["date_of_joining"] = 'Today';
                } else if (date("Y-m-d", strtotime($search_latest['date_of_joining'])) == date('Y-m-d', strtotime($from_date . '-1 days'))) {
                    $data[$i]["date_of_joining"] = 'Yesterday';
                } else {
                    $data[$i]["date_of_joining"] = date("Y-m-d", strtotime($search_latest['date_of_joining']));
                }
                $data[$i]["user_full_name"] = $this->joining_class_model->userFullName($search_latest['id']);
                $data[$i]["profile_pic"] = $this->validation_model->getProfilePicture($search_latest['id']);
                $i++;
            }
        }
        return $data;
    }

    public function getPackageProgressData($limit = 4, $user_id = '') {
        $i = 0;
        $total = 0;
        $data = [];
        $MODULE_STATUS = $this->trackModule();
        if ($MODULE_STATUS['opencart_status'] == 'yes' && $MODULE_STATUS['opencart_status_demo'] == 'yes') {
            $this->db->select('COUNT(ft.id) as count,ft.product_id');
            $this->db->from('ft_individual as ft');
            $this->db->join('oc_product as oc', 'oc.package_id = ft.product_id');
            $this->db->where('oc.status !=', 0);
            $this->db->where('ft.product_id !=', '');
            if ($user_id)
                $this->db->where('ft.sponsor_id', $user_id);
            else
                $this->db->where('ft.id!=', $this->ADMIN_USER_ID);
            $this->db->group_by('ft.product_id');
            $this->db->order_by('count', 'DESC');
            $this->db->limit($limit);
            $query = $this->db->get();
        } else{
            $this->db->select('COUNT(ft.id) as count,ft.product_id');
            $this->db->from('ft_individual as ft');
            $this->db->join('package as pck', 'pck.prod_id = ft.product_id');
            $this->db->where('ft.product_id !=', '');
            if ($user_id)
                $this->db->where('ft.sponsor_id', $user_id);
            else
                $this->db->where('ft.id!=', $this->ADMIN_USER_ID);
            $this->db->group_by('ft.product_id');
            $this->db->order_by('count', 'DESC');
            $this->db->limit($limit);
            $query = $this->db->get();
        }
        foreach ($query->result_array() as $row) {
            $data[$i]['joining_count'] = $row['count'];
            $data[$i]['package_name'] = $this->getPackageNameFromPackageId($row['product_id'], $MODULE_STATUS);
            $total += $row['count'];
            $data[0]['perc'] = 100 / $total;
            $i = $i + 1;
        }
        if ($i < 4) {
            $default_list = $this->getDefaultProducts('yes', 'registration', $data,4-$i);
            foreach (range(0, 4) as $v) {
                if (isset($default_list[$v])) {
                    $data[] = ["package_name" => $default_list[$v]['product_name'], "joining_count" => 0, "perc" => 0];
                }
            }
        }
        return $data;
    }

    public function getPackageNameFromPackageId($package_id, $module_status) {
        if ($module_status['opencart_status'] == 'yes' && $module_status['opencart_status_demo'] == 'yes') {
            $this->db->select('model product_name');
            $this->db->from('oc_product');
            $this->db->where('package_id', $package_id);
        } else {
            $this->db->select('product_name');
            $this->db->from('package');
            $this->db->where('prod_id', $package_id);
            $this->db->where('type_of_package', "registration");
        }
        $query = $this->db->get();
        return $query->row_array()['product_name'];
    }

    public function getPackageCount($product_id, $user_id = '') {
        $i = 0;
        $count = 0;
        $this->db->select('COUNT(id) as count');
        $this->db->from('ft_individual');
        $this->db->where('product_id', $product_id);
        if ($user_id)
            $this->db->where('sponsor_id', $user_id);
        else
            $this->db->where('id!=', $this->ADMIN_USER_ID);
        $this->db->group_by('product_id');
        $this->db->order_by('count', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0)
            $count = $query->result_array()[0]['count'];
        return $count;
    }

    public function getTotalPackageCount($user_id = '') {
        $i = 0;
        $total = 0;
        $this->db->select('COUNT(id) as count');
        $this->db->from('ft_individual');
        $this->db->where('product_id!=', '');
        if ($user_id)
            $this->db->where('sponsor_id', $user_id);
        else
            $this->db->where('id!=', $this->ADMIN_USER_ID);
        $this->db->group_by('product_id');
        $this->db->order_by('count', 'DESC');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $total += $row['count'];
            $i = $i + 1;
        }
        if ($total > 0)
            return (100 / $total);
        else
            return 0;
    }

    public function getTodyCntctMsg() {
        $date = date("Y-m-d");
        $this->db->select('*');
        $this->db->from('contacts');
        $this->db->where('owner_id', $this->LOG_USER_ID);
        $this->db->where('status', 'yes');
        $this->db->like('mailadiddate', $date);
        $cntct_mail_cnt = $this->db->count_all_results();
        return $cntct_mail_cnt;
    }

    public function getAllTodayMessages($type) {
        $mailcnt = $this->mail_model->getAllMessagesToday($type);
        //Get All Todays Contact Messages
        $contantcnt = $this->getTodyCntctMsg();
        $totalcnt = $mailcnt + $contantcnt;
        return $totalcnt;
    }

    public function getTotaMailCount($type, $start_date, $end_date, $read_status, $all = "notall") {
        $inf_sess =  $this->session->userdata('inf_logged_in');
        $user_name = $inf_sess['user_name'];
        $id = $this->validation_model->userNameToID($user_name);
        $numrows = 0;
        if ($type == "admin") {
            $mail = 'mailtoadmin';
            $this->db->select('mailadid');
            $where = "mailadiddate between '$start_date' and '$end_date'";
        } else if ($type == "user") {
            $mail = 'mailtouser';
            $this->db->select('mailtousid');
            $this->db->where('mailtoususer', $id);
            $where = "mailtousdate between '$start_date' and '$end_date'";
        }
        $this->db->where('status', 'yes');
        if ($all != "all") {
            if ($read_status) {
                $this->db->where('read_msg', $read_status);
            }
            $this->db->where($where);
        }
        $this->db->from($mail);
        $numrows = $this->db->count_all_results(); // Number of rows returned from above query.
        //Get contact mailcount
        $this->db->select('*');
        $this->db->from('contacts');
        $this->db->where('owner_id', $this->LOG_USER_ID);
        $this->db->where('status', 'yes');
        $this->db->order_by('mailadiddate', 'desc');
        $cntct_mail_cnt = $this->db->count_all_results();

        $total = $numrows + $cntct_mail_cnt;
        return $total;
    }

    public function getDefaultProducts($status = '', $type_of_package = '', $data,$limit = 4) {

        $product_details = array();
        $MODULE_STATUS = $this->trackModule();
        if ($MODULE_STATUS['opencart_status'] != "yes" || $MODULE_STATUS['opencart_status_demo'] != "yes") {
            $i = 0;
            $this->db->select('product_name,active,prod_id');
            $this->db->from('package');
            if ($status != '') {
                $this->db->where('active', $status);
            }
            if ($type_of_package != '') {
                $this->db->where('type_of_package', $type_of_package);
            }
            $this->db->limit($limit);
            if (!empty($data))
                $this->db->where_not_in('product_name', array_column($data, 'package_name'));
            $query = $this->db->get();
            foreach ($query->result_array() as $row) {
                $product_details[] = $row;
            }
        } else {
            $i = 0;
            $this->db->select('model,product_id,package_type');
            $this->db->from("oc_product");
            $this->db->where('status',1);
            if ($type_of_package != '') {
                $this->db->where('package_type', $type_of_package);
            }
            $this->db->limit($limit);
            if (!empty($data))
                $this->db->where_not_in('model', array_column($data, 'package_name'));
            $query = $this->db->get();
            foreach ($query->result_array() as $row) {
                $product_details[$i]['product_name'] = $row['model'];
                $product_details[$i]['prod_id'] = $row['product_id'];
                $product_details[$i]['type_of_package'] = $row['package_type'];
                $i = $i + 1;
            }
        }
        return $product_details;
    }

    /* Ajax Functon For Payout Tile Starts */

    public function getPayoutDetails($from_date = '', $to_date = '', $user_id = '') {

        $this->load->model('leg_class_model');
        $total_amount = 0;

        $this->db->select_sum('paid_amount');
        $this->db->from('amount_paid ');
        $this->db->where('paid_type', 'released');
        if ($from_date != '' AND $to_date != '') {
            $where = "paid_date BETWEEN '$from_date' AND '$to_date'";
            $this->db->where($where);
        }
        if ($user_id != '') {
            $this->db->where('paid_user_id', $user_id);
        }

        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $total_amount += $row['paid_amount'];
        }
        return $total_amount;
    }

    /* Ajax Functon For Payout Tile Ends */

    /* Ajax Functon For Sales Tile Ends */

    public function getSalesCount($from_date = '', $to_date = '', $user_id = '') {

        $total_sales = 0;
        $MODULE_STATUS = $this->trackModule();
        if ($MODULE_STATUS['repurchase_status'] == 'yes') {
            $this->db->select('COUNT(*) as count');
            $this->db->from('repurchase_order');
            $this->db->where('order_status', "confirmed");
            if ($from_date && $to_date) {
                $this->db->where('order_date >=', $from_date);
                $this->db->where('order_date <=', $to_date);
            }
            if ($user_id != '') {
                $this->db->where('user_id', $user_id);
            }
            $query = $this->db->get();
            $total_sales = $query->result_array()[0]['count'];
        }
        if ($MODULE_STATUS['product_status'] == 'yes' && $MODULE_STATUS['opencart_status'] != 'yes' && $MODULE_STATUS['opencart_status_demo'] != 'yes') {
            $this->db->select('COUNT(*) as count');
            $this->db->from('sales_order');
                $this->db->where('pending_id', NULL);
            if ($from_date && $to_date) {
                $this->db->where('date_submission >=', $from_date);
                $this->db->where('date_submission <=', $to_date);
            }
            if ($user_id != '') {
                $this->db->where('user_id', $user_id);
            }
            $query = $this->db->get();
            $total_sales_register = $query->result_array()[0]['count'];
            $total_sales = $total_sales + $total_sales_register;
        }

        if ($MODULE_STATUS['opencart_status'] == "yes" || $MODULE_STATUS['opencart_status_demo'] == "yes") {
            if ($user_id != '') {
                $customer_id = $this->validation_model->getOcCustomerId($user_id);
            }
            $this->db->select('COUNT(*) as count');
            $this->db->from('oc_order as o');
            $this->db->join("oc_order_history as oh", "o.order_id=oh.order_id ", "INNER");
            $this->db->where("oh.order_status_id >", 1);
            if ($from_date && $to_date) {
                $this->db->where('o.date_added >=', $from_date);
                $this->db->where('o.date_added <=', $to_date);
            }
            if ($user_id != '') {
                $this->db->where('o.customer_id', $customer_id);
            }
            $query = $this->db->get();//echo $this->db->last_query(); die;
            $total_sales_order = $query->result_array()[0]['count'];
            $total_sales = $total_sales + $total_sales_order;
        }
       $total_sales = $this->validation_model->getReferalCount($user_id);
        return $total_sales;
    }

    /* Ajax Functon For Sales Tile Ends */

    public function getUnreadMessages($type, $user_id) {
        $result = array();
        $result1 = array();
        if ($type == "admin" || $type == "employee") {
            $tbl = 'mailtoadmin';
            $this->db->select('*');
            $where1 = array('status' => 'yes', 'read_msg' => 'no');
            $where2 = array('status' => 'no', 'deleted_by != ' => $user_id,'read_msg' => 'no','deleted_by !=' => 'both');
            $this->db->group_start()
                ->where($where1)
                ->or_group_start()
                ->where($where2)
                ->group_end()
                ->group_end();
            // $this->db->where('status', 'yes');
            // $this->db->where('read_msg', 'no');
            $this->db->order_by("mailadiddate", "desc");
            $this->db->from($tbl);
            $query = $this->db->get();
            $i = 0;
            foreach ($query->result_array() as $rows) {
                $result[$i] = $rows;
                $result[$i]['username'] = $this->validation_model->IdToUserName($rows['mailaduser']);
                $mail_userid = $this->validation_model->userNameToID($result[$i]['username']);
                $result[$i]['image'] = $this->validation_model->getProfilePicture($mail_userid);
                $result[$i]['mailadiddate'] = date("F j, g:i", strtotime($rows['mailadiddate']));
                $i++;
            }
            $this->db->select('*');
            $this->db->from('contacts');
            $this->db->where('owner_id', $user_id);
            $this->db->where('status', 'yes');
            $this->db->where('read_msg', 'no');
            $this->db->order_by('mailadiddate', 'desc');
            $query = $this->db->get();
            $i = 0;
            foreach ($query->result_array() as $rows) {
                $result1[$i] = $rows;
                $result1[$i]['username'] = $rows['contact_name'];
                $result1[$i]['image'] = 'nophoto.jpg';
                $result1[$i]['mailadsubject'] = $rows['contact_info'];
                $result1[$i]['mailadiddate'] = date("F j, g:i", strtotime($rows['mailadiddate']));
                $i++;
            }
            $res = array_merge($result, $result1);
            return $res;
        } else {

            $tbl = 'mailtouser';
            $this->db->select('*');
            // $this->db->where('status', 'yes');
            // $this->db->where('read_msg', 'no');
            $where1 = array('status' => 'yes','mailtoususer' => $user_id ,'read_msg' => 'no');
            $where2 = array('status' => 'no', 'deleted_by != ' => $user_id,'mailtoususer' => $user_id,'read_msg' => 'no','deleted_by !=' => 'both');
            $this->db->group_start()
                ->where($where1)
                ->or_group_start()
                ->where($where2)
                ->group_end()
                ->group_end();
            $this->db->order_by("mailtousdate", "desc");
            $this->db->from($tbl);
            $query = $this->db->get();
            // print_r($query->result_array());die;
            $i = 0;
            foreach ($query->result_array() as $rows) {

                $result[$i]["mailaduser"] = $rows["mailtoususer"];
                $result[$i]["mailadsubject"] = $rows["mailtoussub"];
                $result[$i]["mailadiddate"] = date("F j, g:i", strtotime($rows['mailtousdate']));

                if ($rows['mailfromuser'] != 'admin') {
                    $result[$i]['username'] = $this->validation_model->idToUserName($rows['mailfromuser']);
                } else {
                    $result[$i]['username'] = $this->ADMIN_USER_NAME;
                }

                $mail_userid = $this->validation_model->userNameToID($result[$i]['username']);
                $result[$i]['image'] = $this->validation_model->getProfilePicture($mail_userid);
                $i++;
            }
            $this->db->select('*');
            $this->db->from('contacts');
            $this->db->where('owner_id', $user_id);
            $this->db->where('status', 'yes');
            $this->db->where('read_msg', 'no');
            $this->db->order_by('mailadiddate', 'desc');
            $query = $this->db->get();
            $i = 0;
            foreach ($query->result_array() as $rows) {
                $result1[$i] = $rows;
                $result1[$i]['username'] = $rows['contact_name'];
                $result1[$i]['image'] = 'nophoto.jpg';
                $result1[$i]['mailadsubject'] = $rows['contact_info'];
                $result1[$i]['mailadiddate'] = date("F j, g:i", strtotime($rows['mailadiddate']));
                $i++;
            }
            // print_r($result); die;
            $res = array_merge($result, $result1);
            return $res;
        }
    }

    public function getCountLegamount($user_id,$prod_id) {
        $product_id =  $this->getProductDetails($prod_id);
        $cntct_mail_cnt = 0;
        $this->db->select('*');
        $this->db->from('leg_amount');
        $this->db->where('user_id', $user_id);
        $this->db->where('product_id', $product_id);
        $this->db->where('amount_type', 'daily_investment');

        $cntct_mail_cnt = $this->db->count_all_results();
        return $cntct_mail_cnt;
    }

    public function getProdName($prod_id) {
        $product_name = '';
        $this->db->select('product_name');
        $this->db->from('package');
        $this->db->where('prod_id', $prod_id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $product_name = $row->product_name;
        }
        return $product_name;
    }

    public function getProductDetails($prod_id) {
        $this->db->select('product_id');
        $this->db->from('package');
        $this->db->where('prod_id', $prod_id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $product_id = $row->product_id;
        }
        return $product_id;
    }

    public function getReturnInvestmentDetailsCount($user_id = '') {
        $this->db->from('leg_amount');
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        $this->db->where("amount_type", 'daily_investment');
        return $this->db->count_all_results();

    }

    public function getHyipTotalLegAmount($user_id ='') {
        return $this->ewallet_model->getTotalDailyInvestment($user_id);
     }

    public function getHyipTotalLegAmountDetails($page='', $limit='',$user_id='') {
        $array = array();
        $tot_amount = 0;
        $this->db->select('amount_payable,user_id,from_id,product_id,date_of_submission');
        $this->db->from('leg_amount');
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        $this->db->where("amount_type", 'daily_investment');
        $this->db->limit($limit, $page);
        $query = $this->db->get();
        $i = 1;
        foreach ($query->result_array() as $row) {
            $array[$i]["amount_payable"] = $row["amount_payable"];
            if ($row["from_id"]) {
                $array[$i]["from_id"] = $this->validation_model->IdToUserName($row["from_id"]);
            } else {
                $array[$i]["from_id"] = "NA";
            }
            $tot_amount+=$array[$i]["amount_payable"];
            $array[$i]['tot_amount'] = $tot_amount;
            $prod_id   = $this->getPackageId($row['product_id']);
            $prod_name = $this->getProdName($prod_id);
            $array[$i]['package'] = $prod_name;
            $array[$i]['date_of_submission'] = $row["date_of_submission"];
            $i++;
        }
        return $array;
    }

    public function getPackageId($product_id) {
        $this->db->select('prod_id');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('package');
        return $query->row_array()['prod_id'];
    }

    public function getActiveDeposit($user_id ='') {
        $this->db->select('ro.user_id,ro.prod_id,ro.days,leg.amount_payable,leg.user_id,leg.product_id,leg.date_of_submission');
        $this->db->from('roi_order AS ro');
        $this->db->join('package as pck', 'pck.prod_id = ro.prod_id');
        $this->db->join('leg_amount as leg', 'leg.user_id = ro.user_id and leg.product_id = pck.product_id');
        $this->db->where('leg.amount_type', 'daily_investment');
        $this->db->where('ro.pending_status', 0);
        if ($user_id) {
            $this->db->where('ro.user_id', $user_id);
        }
        $query = $this->db->get();
        $i = 0;
        $j = 0;
        $tot_amount = 0;
        foreach ($query->result_array() as $row) {
            $count_leg_amount            = $this->getCountLegamount($row['user_id'],$row['prod_id']);
            $expiry                      = $row['days'] - $count_leg_amount;
            if($expiry > 0){
            $tot_amount+=$row["amount_payable"];
            }
            $i++;
        }

        if($this->MODULE_STATUS['purchase_wallet'] == 'yes' && $tot_amount > 0) {
            $amount = 0;
            $this->db->select('SUM(purchase_wallet) as total_amount', FALSE);
            $this->db->where('amount_type', 'daily_investment');
            $this->db->where('type', 'credit');
            $this->db->where('ewallet_type', 'commission');
            if ($user_id) {
                $this->db->where('user_id', $user_id);
            }
            $query = $this->db->get('ewallet_history');
            foreach ($query->result() as $row) {
                $amount = $row->total_amount;
            }
            $tot_amount-=$amount;
        }

        return $tot_amount;
     }

    public function getActiveDepositDetails($user_id ='') {
        $array = array();
        $this->db->select('amount_payable,user_id,from_id,product_id,date_of_submission');
        $this->db->from('leg_amount as leg');
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        $this->db->where('amount_type', 'daily_investment');
        $query = $this->db->get();
        $i = 0;
        $j = 0;
        $tot_amount = 0;
        foreach ($query->result_array() as $row) {
            $prod_id                     = $this->getPackageId($row['product_id']);
            $count_leg_amount            = $this->getCountLegamount($row['user_id'],$prod_id);
            $days                        =  $this->getRoiDays($row['user_id'],$prod_id);
            $expiry                      = $days - $count_leg_amount;
            if($expiry > 0){
            $array[$j]["amount_payable"] = $row["amount_payable"];
            if ($row["from_id"]) {
                $array[$j]["from_id"] = $this->validation_model->IdToUserName($row["from_id"]);
            } else {
                $array[$j]["from_id"] = "NA";
            }
            $tot_amount+=$array[$j]["amount_payable"];
            $array[$j]['tot_amount'] = $tot_amount;
            $prod_id   = $this->getPackageId($row['product_id']);
            $prod_name = $this->getProdName($prod_id);
            $array[$j]['package'] = $prod_name;
            $array[$j]['date_of_submission'] = $row["date_of_submission"];
            $array[$j]['user_id'] = $row['user_id'];
            $j++;
            }
            $i++;
        }
        return $array;
     }

    public function getMaturedDepositDetails($user_id ='') {
        $array = array();
        $this->db->select('amount_payable,user_id,from_id,product_id,date_of_submission');
        $this->db->from('leg_amount as leg');
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        $this->db->where('amount_type', 'daily_investment');
        $query = $this->db->get();
        $i = 0;
        $j = 0;
        $tot_amount = 0;
        foreach ($query->result_array() as $row) {
            $prod_id                     = $this->getPackageId($row['product_id']);
            $count_leg_amount            = $this->getCountLegamount($row['user_id'],$prod_id);
            $days                        =  $this->getRoiDays($row['user_id'],$prod_id);
            $expiry                      = $days - $count_leg_amount;
            if($expiry == 0){
            $array[$j]["amount_payable"] = $row["amount_payable"];
            if ($row["from_id"]) {
                $array[$j]["from_id"] = $this->validation_model->IdToUserName($row["from_id"]);
            } else {
                $array[$j]["from_id"] = "NA";
            }
            $tot_amount+=$array[$j]["amount_payable"];
            $array[$j]['tot_amount'] = $tot_amount;
            $prod_id   = $this->getPackageId($row['product_id']);
            $prod_name = $this->getProdName($prod_id);
            $array[$j]['package'] = $prod_name;
            $array[$j]['date_of_submission'] = $row["date_of_submission"];
            $j++;
            }
            $i++;
        }
        return $array;
    }

    public function getRoiDays($user_id,$prod_id) {
        $this->db->select('days');
        $this->db->from('roi_order');
        $this->db->where('user_id', $user_id);
        $this->db->where('prod_id', $prod_id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $days = $row->days;
        }
        return $days;
    }

    public function getUsersByKeyword($keyword, $type = '') {
        $this->db->select('user_name');
        $this->db->like('user_name', $keyword, 'after');
        if($type != ''){
            $this->db->where('user_type !=', $type);
        }
        $this->db->order_by('id');
        $this->db->limit(500);
        $query = $this->db->get('ft_individual');
        $response = [];
        foreach ($query->result_array() as $row) {
            $response[] = $row['user_name'];
        }
        return $response;
    }

    public function getDownlineUsersByKeyword($log_user_id, $keyword) {
        $this->load->model('tree_model');
        $left_right = $this->tree_model->getUserLeftRightNode($log_user_id);
        $this->db->select('f.user_name');
        $this->db->from('ft_individual f');
        $this->db->join('tree_parser t', 't.ft_id = f.id', 'LEFT');
        $this->db->like('f.user_name', $keyword, 'after');
        $this->db->where("t.left_father >=", $left_right['left']);
        $this->db->where("t.left_father <=", $left_right['right']);
        $this->db->order_by('t.left_father');
        $this->db->order_by('f.id');
        $this->db->limit(500);
        $query = $this->db->get();
        $response = [];
        foreach ($query->result_array() as $row) {
            $response[] = $row['user_name'];
        }
        return $response;
    }
    
    public function getLatestUploadsCount(){
        
        $this->db->from('latest_uploads');
        $this->db->where("type",'image');
        return $this->db->count_all_results();
        
    }
    
        public function getBannerCount(){
        $this->db->from('latest_uploads');
        $this->db->where("type",'banner');
        return $this->db->count_all_results();
        
    }
    
    public function getImages(){
        $img_det=array();
        $this->db->select('*');
        $this->db->order_by('date', 'DESC');
        $this->db->where('status','active');
        $this->db->where('type','image');
        $this->db->from('latest_uploads');
        $query =$this->db->get();
        $i=0;
        foreach ($query->result_array() as $row) {
           $img_det[$i]['image_name']=$row['image_name'];
           $img_det[$i]['url']=$row['url'];
           $img_det[$i]['date']=$row['date'];
           $i++;
        }//print_r($img_det); die;
        return $img_det;
    }
    
        public function getBanner(){
        $img_det=array();
        $this->db->select('*');
        $this->db->order_by('date', 'DESC');
        $this->db->where('status','active');
        $this->db->where('type','banner');
        $this->db->from('latest_uploads');
        $query =$this->db->get();
        $i=0;
        foreach ($query->result_array() as $row) {
           $img_det[$i]['image_name']=$row['image_name'];
           $img_det[$i]['url']=$row['url'];
           $img_det[$i]['date']=$row['date'];
           $i++;
        }//print_r($img_det); die;
        return $img_det;
    }
    
    public function getTotalAmountPayable($user_id){
        
        $this->db->select_sum('amount_payable');
        $this->db->where('user_id',$user_id);
        $this->db->from('leg_amount');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
           $total_commission = $row->amount_payable;
        }
        return $total_commission;
    }
    
    public function getLastWeekEarnedIncome($user_id){
        
        $date = date('Y-m-d'); 
        $last_week = date('Y-m-d', strtotime($date ."-1week"));
        $date = $date." 23:59:59";
        $last_week=$last_week." 00:00:00";
        $this->db->select_sum('amount_payable');
        $this->db->where('user_id',$user_id);
        $this->db->where('date_of_submission >=',$last_week);
        $this->db->where('date_of_submission <=',$date);
        $this->db->from('leg_amount');
        $query = $this->db->get();//echo $this->db->last_query(); die;
        foreach ($query->result() as $row) {
           $last_week_earnings = $row->amount_payable;
        }//print_r($last_week_earnings); die;
        return $last_week_earnings;
    }
    
    public function getLastMonthEarnedIncome($user_id){
        
        $date = date('Y-m-d'); 
        $date=$date." 23:59:59";
        $last_month = date('Y-m-d', strtotime($date ."-1month"));
        $last_month=$last_month." 00:00:00";
        $this->db->select_sum('amount_payable');
        $this->db->where('user_id',$user_id);
        $this->db->where('date_of_submission >=',$last_month);
        $this->db->where('date_of_submission <=',$date);
        $this->db->from('leg_amount');
        $query = $this->db->get();//echo $this->db->last_query(); die;
        foreach ($query->result() as $row) {
           $last_month_earnings = $row->amount_payable;
        }
        return $last_month_earnings;
    }
    
    public function getAverageEarnings($user_id){
        
        $this->db->select_avg('amount_payable');
        $this->db->where('user_id',$user_id);
        $this->db->from('leg_amount');
        $query = $this->db->get();//echo $this->db->last_query(); die;
        foreach ($query->result() as $row) {
           $avg_earnings = $row->amount_payable;
        }
        return $avg_earnings;
    }
    
    public function getYearEarnings($user_id){
        
        $date = date('Y'); 
        
        
        $this->db->select_sum('amount_payable');
        $this->db->where('user_id',$user_id);
        $this->db->like('date_of_submission',$date);
        
        $this->db->from('leg_amount');
        $query = $this->db->get();//echo $this->db->last_query(); die;
        foreach ($query->result() as $row) {
           $year_earnings = $row->amount_payable;
        }
        return $year_earnings;
    }
    public function getLeftUSerCount($user_id){
    $left_father= $this->validation_model->getFtData($user_id,'left_father');
    $right_father= $this->validation_model->getFtData($user_id,'right_father');
    $user_count=0;
    $this->db->select('id');
    $this->db->where('left_father >',$left_father);
    $this->db->where('$right_father <',$right_father);
        $this->db->from('tree_parser');
        $query = $this->db->get();
}

    public function getLeftRightCountPV($user_id,$position){
        
        $left_right_id = $this->getLeftRightUser($user_id, $position);
        if($left_right_id>0){
        $father_left_right = $this->validation_model->getUserLeftAndRight($left_right_id, "father");
        $father_left = $father_left_right['left_father'];
        $father_right = $father_left_right['right_father'];
        $pv = $this->validation_model->getPersnlPv($left_right_id);
        $downlines = $this->validation_model->getDownlineUsersCount($father_left, $father_right, "father",$pv);
        }else{
            $downlines['count']=0;
            $downlines['total_pv']=0;
            
        }
        return $downlines;
    }
    
    public function getLeftRightUser($user_id,$position){
        $id=0;
        $this->db->select('id');
        $this->db->where('position',$position);
        $this->db->where('father_id',$user_id);
        $this->db->from('ft_individual');
        $query=$this->db->get();
        foreach ($query->result() as $row) {
            $id = $row->id;
        }
        return $id;
    }
    


}
