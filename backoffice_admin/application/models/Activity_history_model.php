<?php

Class activity_history_model extends inf_model {

    public function __construct() {
        parent::__construct();
    }

    public function getActivityHistory($page, $limit, $from = '', $to = '', $user_name = '', $ip = '') {
        $employee_status = $this->validation_model->getModuleStatusByKey('employee_status');
        $this->db->select('a.done_by,a.user_id,a.date,a.ip,a.activity,u1.user_name username_done,u2.user_name username');
        $this->db->from('activity_history a');
        $this->db->join('ft_individual u1', 'u1.id = a.done_by', 'left');
        $this->db->join('ft_individual u2', 'u2.id = a.user_id', 'left');

        if ($from)
            $this->db->where('a.date >=', $from);

        if ($to)
            $this->db->where('a.date <=', $to);

        if ($user_name) {
//            $where = '(u1.user_name = "' . $user_name . '" or u2.user_name = "' . $user_name . '")';
            $where = '(u1.user_name = "' . $user_name . '")';
            $this->db->where($where);
        }

        if ($ip)
            $this->db->where('a.ip', $ip);

        $this->db->order_by('date', 'desc');
        $this->db->limit($limit, $page);
        $query = $this->db->get();
        $details = Array();
        $i=0;
        foreach ($query->result_array() as $row) {
            $details[$i] = $row;
            if($row['username'] == NULL && $employee_status == 'yes'){
                $user_name = $this->validation_model->EmployeeIdToUserName($row['user_id']);
                $details[$i]['username'] = $user_name;
                $details[$i]['username_done'] = $user_name;
            }
            $i++;
        }
        // print_r($details); die;
        return $details;
    }

    public function getActivityHistoryCount($from = '', $to = '', $user_name = '', $ip = '') {
        if ($from)
            $this->db->where('a.date >=', $from);

        if ($to)
            $this->db->where('a.date <=', $to);

        if ($user_name) {
            $where = '(u1.user_name="' . $user_name.'")';
            $this->db->where($where);
        }

        if ($ip)
            $this->db->where('a.ip', $ip);

        $this->db->from("activity_history a");
        $this->db->join('ft_individual u1', 'u1.id = a.done_by', 'left');
        $this->db->join('ft_individual u2', 'u2.id = a.user_id', 'left');
        return $this->db->count_all_results();
    }
}
