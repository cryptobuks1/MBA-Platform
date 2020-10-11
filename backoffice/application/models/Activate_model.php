<?php

class activate_model extends inf_model {

    public function __construct() {
        $this->load->model('validation_model');
        $this->load->model('registersubmit_model');
    }

    public function inactivateAccount($user_id, $type = 'auto') {
        $result = FALSE;
        $this->db->set('active', 'no');
        $this->db->where('id', $user_id);
        $res = $this->db->update('ft_individual');
        if ($res) {
            $result = $this->usertActivationDeactivationHistory($user_id, $type, 'deactivated');
        }
        return $result;
    }

    public function usertActivationDeactivationHistory($user_id, $type, $status = '') {
        $this->db->set('user_id', $user_id);
        $this->db->set('type', $type);
        $this->db->set('status', $status);
        $result = $this->db->insert('user_activation_deactivation_history');
        return $result;
    }

    public function activateAccount($user_id, $type = 'auto') {
        $result = FALSE;
        $this->db->set('active', 'yes');
        $this->db->where('id', $user_id);
        $res = $this->db->update('ft_individual');
        if ($res) {
            $result = $this->usertActivationDeactivationHistory($user_id, $type, 'activated');
        }
        return $result;
    }

    public function checkUsernameExist($user_name) {
        $this->db->from("ft_individual");
        $this->db->where('user_name', $user_name);
        $count = $this->db->count_all_results();
        return $count;
    }

    public function getPosition($user_id) {
        $position = '';
        $this->db->select('position');
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $position = $row->position;
        }
        return $position;
    }

    public function deleteEmptyLeg($new_user_id, $position = '') {
        $this->db->set('father_id', 0);
        $this->db->where('id', $new_user_id);
        $this->db->where('position', $position);
        $this->db->limit(1);
        $result = $this->db->update('ft_individual');
        return $result;
    }

    public function replaceUserEmpty($new_user_id, $user_id, $position) {
        $this->db->set('father_id', $new_user_id);
        $this->db->set('position', $position);
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $result = $this->db->update('ft_individual');
        return $result;
    }

    public function getReplaceChildId($new_user_id, $position) {
        $replace_child_id = 0;
        $this->db->select('id');
        $this->db->from('ft_individual');
        $this->db->where('father_id', $new_user_id);
        $this->db->where('position', $position);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $replace_child_id = $row->id;
        }
        return $replace_child_id;
    }

    public function getLastuserId($user_id, $position) {
        $this->db->select('id');
        $this->db->select('active');
        $this->db->from('ft_individual');
        $this->db->where('father_id', $user_id);
        $this->db->where('position', $position);
        $result = $this->db->get();
        foreach ($result->result() as $row) {
            $user_id = $this->getLastuserId($row->id, $position);
            return $user_id;
        }
        return $user_id;
    }

    public function updateFatherId($father_id, $new_user_id) {
        $this->db->set('father_id', $father_id);
        $this->db->where('id', $new_user_id);
        $result = $this->db->update('ft_individual');
        return $result;
    }

    public function getCountOfEmptyLegs($new_user_father_id, $position) {
        $this->db->from('ft_individual');
        $this->db->where('father_id', $new_user_father_id);
        $this->db->where('position', $position);
        $count = $this->db->count_all_results();
        return $count;
    }

    public function getUserInformation($user_id = '', $page = '', $limit = '',$active = '')
    {
        $this->db->select("f.user_name,f.active,CONCAT(u.user_detail_name,' ',u.user_detail_second_name) full_name,u.user_detail_mobile mobile_no,u.user_detail_address address,CONCAT(u2.user_detail_name,' ',u2.user_detail_second_name) sponsor_full_name");
        $this->db->from('ft_individual f');
        $this->db->join('user_details u', 'f.id=u.user_detail_refid');
        $this->db->join('user_details u2', 'f.sponsor_id=u2.user_detail_refid', 'left');
        $this->db->where("f.user_type !=", 'admin');
        if (empty($user_id)) {
            $this->db->limit($limit, $page);
        }
        else {
            $this->db->where('f.id', $user_id);
        }
        if ($active != '') {
            $this->db->where("f.active =", $active);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getUserInformationCount()
    {
        $this->db->where("user_type !=", 'admin');
        return $this->db->count_all_results('ft_individual');
    }

}
