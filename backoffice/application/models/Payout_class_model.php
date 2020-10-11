<?php

class payout_class_model extends inf_model {

    public $all_payout_details;
    public $member_payout_details;

    public function __construct() {

        $this->load->model('settings_model');
        $this->load->model('validation_model');
    }

    public function getTotalPayout($from_date = '', $to_date = '') {
        $this->load->model('leg_class_model');
        if ($from_date == '' AND $to_date == '') {

            $this->db->select_sum('leg_amount.total_leg', 'total_leg');
            $this->db->select_sum('leg_amount.total_amount', 'total_amount');
            $this->db->select_sum('leg_amount.amount_payable', 'amount_payable');
            $this->db->select_sum('leg_amount.tds', 'tds');
            $this->db->select_sum('leg_amount.service_charge', 'service_charge');
            $this->db->select('leg_amount.user_id');
            $this->db->from('leg_amount ');
            $this->db->join('ft_individual', 'leg_amount.user_id=ft_individual.id', 'INNER');
            $this->db->where('ft_individual.active', 'yes');
            $this->db->group_by('leg_amount.user_id');
        } else {


            $this->db->select_sum('leg_amount.total_leg', 'total_leg');
            $this->db->select_sum('leg_amount.total_amount', 'total_amount');
            $this->db->select_sum('leg_amount.amount_payable', 'amount_payable');
            $this->db->select_sum('leg_amount.tds', 'tds');
            $this->db->select_sum('leg_amount.service_charge', 'service_charge');
            $this->db->select('leg_amount.user_id');
            $this->db->from('leg_amount ');
            $this->db->join('ft_individual', 'leg_amount.user_id=ft_individual.id', 'INNER');
            $this->db->where('ft_individual.active', 'yes');
            $where = "leg_amount.date_of_submission BETWEEN '$from_date' AND '$to_date'";
            $this->db->where($where);
            $this->db->group_by('leg_amount.user_id');
        }

        $this->db->select('user.user_detail_acnumber,user.user_detail_nbank,user.user_detail_nbranch,user.user_detail_pan,user.user_detail_address');
        $this->db->join('user_details as user', 'user.user_detail_refid=leg_amount.user_id', 'INNER');

        $all_payout_details = array();
        $i = 0;
        $query = $this->db->get();
        $row = $query->result_array();
        foreach ($query->result_array() as $row) {
            $all_payout_details['detail' . $i]['user_id'] = $row['user_id'];
            $all_payout_details['detail' . $i]['full_name'] = $this->validation_model->getFullName($row['user_id']);
            $all_payout_details['detail' . $i]['user_name'] = $this->validation_model->IdToUserName($row['user_id']);
            $all_payout_details['detail' . $i]['left_leg'] = $this->leg_class_model->getLeftLegCount($row['user_id']);
            $all_payout_details['detail' . $i]['right_leg'] = $this->leg_class_model->getRightLegCount($row['user_id']);
            $all_payout_details['detail' . $i]['total_leg'] = $row['total_leg'];
            $all_payout_details['detail' . $i]['total_amount'] = $row['total_amount'];
            $all_payout_details['detail' . $i]['amount_payable'] = round($row['amount_payable'], 8);
            $all_payout_details['detail' . $i]['tds'] = round($row['tds'], 8);
            $all_payout_details['detail' . $i]['service_charge'] = round($row['service_charge'], 8);
            $all_payout_details['detail' . $i]['user_pan'] = $row['user_detail_pan'];
            if ($row['user_detail_acnumber'])
                $all_payout_details['detail' . $i]['acc_number'] = $row['user_detail_acnumber'];
            else
                $all_payout_details['detail' . $i]['acc_number'] = 'NA';
            if ($row['user_detail_nbank'])
                $all_payout_details['detail' . $i]['user_bank'] = $row['user_detail_nbank'];
            else
                $all_payout_details['detail' . $i]['user_bank'] = 'NA';

            if ($row['user_detail_address'])
                $all_payout_details['detail' . $i]['user_address'] = $row['user_detail_address'];
            else
                $all_payout_details['detail' . $i]['user_address'] = 'NA';
            $i++;
        }

        return $all_payout_details;
    }

    public function getMemberPayout($user_mob_name) {
        $this->load->model('leg_class_model');
        if ($this->table_prefix == '') {
            $this->table_prefix = $this->session->userdata('inf_table_prefix');
        }
        $user_id = $this->validation_model->userNameToID($user_mob_name);
        $leg_amount = $this->table_prefix . 'leg_amount';

        $this->db->select_sum('total_leg', 'total_leg');
        $this->db->select_sum('total_amount', 'total_amount');
        $this->db->select_sum('amount_payable', 'amount_payable');
        $this->db->select_sum('tds', 'tds');
        $this->db->select_sum('service_charge', 'service_charge');
        $this->db->select('user_id');
        $this->db->from($leg_amount);
        $where = "date_of_submission BETWEEN '$from_date' AND '$to_date'";
        $this->db->where($where);
        $this->db->group_by(user_id);
        $query = $this->db->get();
        $row = $query->result_array();
        $member_payout_details['user_id'] = $row['user_id'];
        $member_payout_details['user_name'] = $this->validation_model->IdToUserName($row['user_id']);
        $member_payout_details['user_id'] = $row['user_id'];
        $member_payout_details['full_name'] = $this->validation_model->getFullName($row['user_id']);
        $member_payout_details['left_leg'] = $this->leg_class_model->getLeftLegCount($row['user_id']);
        $member_payout_details['right_leg'] = $this->leg_class_model->getRightLegCount($row['user_id']);
        $member_payout_details['total_leg'] = $row['total_leg'];
        $member_payout_details['total_amount'] = $row['total_amount'];
        $member_payout_details['amount_payable'] = round($row['amount_payable'], 8);
        $member_payout_details['tds'] = round($row['tds'], 8);
        $member_payout_details['service_charge'] = round($row['service_charge'], 8);


        return $member_payout_details;
    }
    
}
