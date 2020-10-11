<?php

class document_model extends inf_model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getAllDocuments($limit, $offset)
    {
        $this->db->order_by("uploaded_date", "desc");
        $this->db->select('*');
        $this->db->limit($limit, $offset);
        $query = $this->db->get('documents');
        return $query->result_array();
    }

    public function getAllDocumentsCount()
    {
        return $this->db->count_all_results('documents');
    }

    public function getDocumentsCount($date = "")
    {
        $count = 0;
        if ($date) {
            $this->db->where("uploaded_date >=", $date);
        }
        $this->db->from('documents');
        $count = $this->db->count_all_results();

        return $count;
    }

    public function getUnreadDocumentsCount($user_id)
    {
        $count = 0;
        $this->db->select("read_doc_count");
        $this->db->where("user_detail_refid", $user_id);
        $r_count = $this->db->get('user_details')->row()->read_doc_count;
        $d_count = $this->getAllDocumentsCount();
        if ($d_count > $r_count) {
            return $d_count - $r_count;
        }
        return $count;
    }

    public function setDocumentViewed($user_id)
    {
        $this->db->set('read_doc_count', $this->getAllDocumentsCount());
        $this->db->where('user_detail_refid', $user_id);
        $this->db->update('user_details');
        return;
    }

}
