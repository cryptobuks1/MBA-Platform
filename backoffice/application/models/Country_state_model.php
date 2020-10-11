<?php

class country_state_model extends inf_model {

    public function __construct() {
        parent::__construct();
    }

    public function getCountries($country_id = '223') {
        $detail = array();
        $this->db->select('*');
        $this->db->from('infinite_countries');
        if ($country_id != '') {
            $this->db->where('country_id', $country_id);
        }
        $this->db->order_by('country_name', "ASC");
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $detail[] = $row;
        }
        return $detail;
    }

    public function viewCountry($country_id = '') {
        $country_detail = '';
        $this->db->select('*');
        $this->db->from('infinite_countries');
        $this->db->order_by('country_name', 'ASC');
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $selected = '';
            if ($country_id != '' && $row['country_id'] == $country_id) {
                $selected = 'selected';
            }
            $country_detail .= "<option value='" . $row['country_id'] . "' $selected>" . $row['country_name'] . "</option>";
        }
        return $country_detail;
    }

    public function getCountryTelephoneCode($country_id) {
        $phone_code = '00';
        $this->db->select('phone_code')->where('country_id', $country_id)->limit(1)->from('infinite_countries');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $phone_code = $row->phone_code;
        }
        return $phone_code;
    }

    public function getCountryNameFromId($country_id) {
        $country_name = 'NA';
        $this->db->select('country_name');
        $this->db->from('infinite_countries');
        $this->db->where('country_id', $country_id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $country_name = $row->country_name;
        }
        return $country_name;
    }

    public function getCountryIDFromName($name) {
        $country_id = 0;
        $this->db->select('country_id');
        $this->db->from('infinite_countries');
        $this->db->where('country_name', $name);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $country_id = $row->country_id;
        }
        return $country_id;
    }

    public function getStates($country_id, $State_Id = '') {
        $state_array = array();
        $this->db->select('*');
        $this->db->where('country_id', $country_id);
        if ($State_Id != '') {
            $this->db->where('state_id', $State_Id);
        }
        $this->db->order_by('state_name', "ASC");
        $this->db->from('infinite_states');
        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            $state_array[] = $row;
        }
        return $state_array;
    }

    public function viewState($country_id, $state_id = '') {
        $state = '';
        $this->db->select('*');
        $this->db->where('country_id', $country_id);
        $this->db->order_by('state_name', "ASC");
        $this->db->from('infinite_states');
        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            $State_Id = $row['state_id'];
            $State_Name = $row['state_name'];
            $selected = '';
            if ($state_id != '' && $State_Id == $state_id) {
                $selected = 'selected';
            }
            $state .= "<option value='$State_Id' $selected>$State_Name</option>";
        } 
        return $state;
      
    }

    public function getStateNameFromId($state_id) {
        $State_Name = "NA";
        $this->db->select("state_name");
        $this->db->from("infinite_states");
        $this->db->where('state_id', $state_id);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $State_Name = $row->state_name;
        }
        return $State_Name;
    }

    public function getStateIDFromName($state_name) {
        $state_id = 0;
        $this->db->select('state_id');
        $this->db->from('infinite_states');
        $this->db->where('state_name', $state_name);
        $grpres = $this->db->get();
        foreach ($grpres->result() as $row) {
            $state_id = $row->state_id;
        }
        return $state_id;
    }
    public function getAllCountries(){
        $detail = array();
        $this->db->select('country_id as id,country_name as name,phone_code');
        $this->db->from('infinite_countries');
        $this->db->order_by('country_name', "ASC");
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $detail[] = $row;
        }
        return $detail;
    }
    public function getStatesFromCountry($country_id) {
        $state_array = array();
        $this->db->select('state_id as id, state_name as name');
        $this->db->where('country_id', $country_id);
        $this->db->order_by('state_name', "ASC");
        $this->db->from('infinite_states');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $state_array[] = $row;
        }
        return $state_array;
    }

}
