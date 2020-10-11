<?php

class feedback_model extends inf_model {

    function __construct() {
        parent::__construct();
        $this->load->model('validation_model');
    }

    public function addFeedback($feedback_user, $feed_company, $feed_phone, $feed_time, $feed_email, $feed_comment) {
        $date = date('Y-m-d H:i:s');
        $this->db->set('feedback_user_id', $feedback_user);
        $this->db->set('feedback_company', $feed_company);
        $this->db->set('feedback_email', $feed_email);
        $this->db->set('feedback_phone', $feed_phone);
        $this->db->set('feedback_time', $feed_time);
        $this->db->set('feedback_remark', $feed_comment);
        $this->db->set('feedback_date', $date);
        $res = $this->db->insert('feedback');
        return $res;
    }

    public function getAllfeedback($user_id = '', $limit = '', $offset = '') {
        $this->db->select('f.*,u.user_name feedback_name');
        $this->db->from('feedback f');
        $this->db->join('ft_individual u', 'f.feedback_user_id = u.id');
        $this->db->order_by('feedback_date', 'desc');
        if ($user_id) {
            $this->db->where('feedback_user_id', $user_id);
        }
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAllfeedbackCount($user_id = '') {
        if ($user_id) {
            $this->db->where('feedback_user_id', $user_id);
        }
        return $this->db->count_all_results('feedback');
    }

    public function deleteFeedback($id) {
        $this->db->where('feedback_id', $id);
        $res = $this->db->delete('feedback');
        return $res;
    }

    public function getAllUnreadFeedbackCount() {
        $this->db->where('read_status', 0);
        return $this->db->count_all_results('feedback');
    }

    public function setFeedbackViewed() {
        $this->db->set('read_status', 1);
        $this->db->where('read_status', 0);
        $this->db->update('feedback');
        return;
    }

}
