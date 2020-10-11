<?php

class income_details_model extends inf_model {

    function __construct() {
        parent::__construct();
        $this->load->model('validation_model');
    }

    public function add_income($id, $page = '', $limit = '', $amountType = '', $date = '') {
        $current_day = date('Y-m-d');
        $this->db->select('l.amount_type,l.amount_payable,l.user_level,f.user_name from_user');
        $this->db->from('leg_amount l');
        $this->db->join('ft_individual f', 'f.id=l.from_id', 'left');
        if ($date == 'month') {
        $this->db->where("MONTH(l.date_of_submission)=MONTH('{$current_day}')");
        $this->db->where("YEAR(l.date_of_submission)=YEAR('{$current_day}')");
        }
        if ($date == 'year') {
        $this->db->where("YEAR(l.date_of_submission)=YEAR('{$current_day}')");
        }
        $this->db->where('user_id', $id);
        if (!empty($amountType)) {
            $this->db->where('amount_type', $amountType);
        }
        $this->db->limit($limit, $page);
        $query = $this->db->get();
        
        return $query->result_array();
    }

    public function getCountIncomeDetails($user_id) {
        $amountType = $this->session->userdata("amountType");
        $this->db->where("user_id", $user_id);
        if (!empty($amountType)) {
            $this->db->where('amount_type', $amountType);
        }
        $count_incime_details = $this->db->count_all_results('leg_amount');
        return $count_incime_details;
    }

}
