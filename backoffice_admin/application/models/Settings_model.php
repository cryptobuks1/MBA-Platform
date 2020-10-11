<?php

/*
 * You can modify this class
 */

/**
 * Description of Settings Class
  Contain the fuctions for seeting the configurations of Infinite MLM Software
 *
 * @author Abdul Majeed.P
  CSA Of IOSS
  www.ioss.in
 */
Class settings_model extends inf_model {

    public function __construct() {

        /*  if ($this->table_prefix == "") {
          $this->session->userdata('inf_table_prefix');
          } */
    }

    public function getSettings() {
        $obj_arr = array();
        $this->db->select("*");
        $this->db->from("configuration");
        $res = $this->db->get();

        foreach ($res->result_array() as $row) {
            $obj_arr = $row;
        }

        return $obj_arr;
    }

    public function getLevelOnePercetage($level_no) {
        $level_per = "";
        $this->db->select('level_percentage');
        $this->db->from('level_commision');
        $this->db->where('level_no', $level_no);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $level_per = $row->level_percentage;
        }
        return $level_per;
    }

    public function getDepthCieling() {
        $obj_arr = $this->getMatrixSettings();
        $depth_cieling = $obj_arr["depth_ceiling"];
        return $depth_cieling;
    }

    public function getMatrixSettings() {
        $obj_arr = array();
        $this->db->select("*");
        $this->db->from("configuration");
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $obj_arr["id"] = $row['id'];
            $obj_arr["tds"] = $row['tds'];
            $obj_arr["service_charge"] = $row['service_charge'];
            $obj_arr["width_ceiling"] = $row['width_ceiling'];
            $obj_arr["depth_ceiling"] = $row['depth_ceiling'];
            $obj_arr["startDate"] = $row['start_date'];
            $obj_arr["endDate"] = $row['end_date'];
            $obj_arr["sms_status"] = $row['sms_status'];
            $obj_arr["payout_release"] = $row['payout_release'];
            $obj_arr["reg_amount"] = $row['reg_amount'];
            $obj_arr["referal_amount"] = $row['referal_amount'];
        }
        return $obj_arr;
    }
    public function getLevelPercetageDonation($level_no,$grade) {
        $level_per = "";
        $this->db->select('donation_'.$grade);
        $this->db->from('level_commision');
        $this->db->where('level_no', $level_no);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $level_per = $row['donation_'.$grade];
        }
        return $level_per;
    }

    public function getLevelConfig() {
        $config = [];
        $this->db->select('level_no,level_percentage');
        $query = $this->db->get('level_commision');
        foreach ($query->result_array() as $row) {
            $config[$row['level_no']] = $row['level_percentage'];
        }
        return $config;
    }

    public function getDonationLevelConfig() {
        $config = [];
        $this->db->select('level_no,donation_1,donation_2,donation_3,donation_4');
        $query = $this->db->get('level_commision');
        foreach ($query->result_array() as $row) {
            $config[$row['level_no']] = [
                'donation_1' => $row['donation_1'],
                'donation_2' => $row['donation_2'],
                'donation_3' => $row['donation_3'],
                'donation_4' => $row['donation_4']
            ];
        }
        return $config;
    }
    public function getPackageLevelConfig($level,$pck,$type) {
        $level_per = 0;
        $this->db->select($type);
        $this->db->from('level_commission_reg_pck');
        $this->db->where('level', $level);
        $this->db->where('pck_id', $pck);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $level_per = $row->$type;
        }
        return $level_per;
    }
    public function getMatchingLevelConfig($level,$pck,$type) {
        $level_per = 0;
        $this->db->select($type);
        $this->db->from('matching_commissions');
        $this->db->where('level', $level);
        $this->db->where('pck_id', $pck);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $level_per = $row->$type;
        }
        return $level_per;
    }
    public function getMatchingBonusConfig()
    {
        $config = [];
        $this->db->select('level_no,level_percentage');
        $query = $this->db->get('matching_level_commision');
        foreach ($query->result_array() as $row) {
            $config[$row['level_no']] = $row['level_percentage'];
        }
        return $config;
    }
    public function getSalesLevelConfig()
    {
        $config = [];
        $this->db->select('level_no,level_percentage');
        $query = $this->db->get('sales_level_commision');
        foreach ($query->result_array() as $row) {
            $config[$row['level_no']] = $row['level_percentage'];
        }
        return $config;
    }
    public function getSalesPackConfig($level,$pck,$type) {
        $level_per = 0;
        $this->db->select($type);
        $this->db->from('sales_commissions');
        $this->db->where('level', $level);
        $this->db->where('pck_id', $pck);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $level_per = $row->$type;
        }
        return $level_per;
    }
    public function getSalesRankConfig($level,$rank,$type) {
        $level_per = 0;
        $this->db->select($type);
        $this->db->from('sales_rank_commissions');
        $this->db->where('level', $level);
        $this->db->where('rank_id', $rank);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $level_per = $row->$type;
        }
        return $level_per;
    }
}
