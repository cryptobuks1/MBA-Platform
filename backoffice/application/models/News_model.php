<?php

class news_model extends inf_model
{

    function __construct()
    {
        parent::__construct();
    }

    public function editNews($id)
    {
        $this->db->where('news_id', $id);
        $query = $this->db->get('news');
        foreach ($query->result_array() as $rows) {
            $obj_arr["news_id"] = $rows['news_id'];
            $obj_arr["news_title"] = $rows['news_title'];
            $obj_arr["news_desc"] = $rows['news_desc'];
            $obj_arr["news_date"] = $rows['news_date'];
        }
        return $obj_arr;
    }

    public function deleteNews($id)
    {
        $this->db->where('news_id', $id);
        $result = $this->db->delete('news');
        return $result;
    }

    public function addNews($news_title, $news_desc)
    {
        $date = date('Y-m-d H:i:s');
        $this->db->set('news_title', $news_title);
        $this->db->set('news_desc', $news_desc);
        $this->db->set('news_date', $date);
        $result = $this->db->insert('news');
        return $result;
    }

    public function updateNews($news_id, $news_title, $news_desc)
    {
        $date = date('Y-m-d H:i:s');
        $this->db->set('news_title', $news_title);
        $this->db->set('news_desc', $news_desc);
        $this->db->set('news_date', $date);
        $this->db->where('news_id', $news_id);
        $result = $this->db->update('news');
        return $result;
    }

    public function getAllNews($limit, $offset)
    {
        $this->db->order_by("news_date", "desc");
        $this->db->limit($limit, $offset);
        $query = $this->db->get('news');
        return $query->result_array();
    }

    public function getAllNewsCount()
    {
        return $this->db->count_all_results('news');
    }

    public function addDocuments($file_title, $file_desc, $doc_file_name, $file_cat)
    {
        $date = date('Y-m-d H:i:s');
        $this->db->set('file_title', $file_title);
        $this->db->set('doc_desc', $file_desc);
        $this->db->set('doc_file_name', $doc_file_name);
        $this->db->set('uploaded_date', $date);
        // THIS_VERSION_ONLY
        // $this->db->set('ctgry', 0);
        // NEXT_VERSION_ONLY
        $this->db->set('ctgry', $file_cat);
        $result = $this->db->insert('documents');
        return $result;
    }

    public function getAllDocuments($limit, $offset)
    {
        $this->db->order_by("uploaded_date", "desc");
        $this->db->limit($limit, $offset);
        $query = $this->db->get('documents');
        return $query->result_array();
    }

    public function getAllDocumentsCount()
    {
        return $this->db->count_all_results('documents');
    }

    public function deleteDocument($delete_id)
    {
        $this->db->where('id', $delete_id);
        $result = $this->db->delete('documents');
        return $result;
    }

    public function getLatestNews()
    {
        $date = strtotime("-7 day", strtotime(date('Y-m-d')));
        $this->db->select('news_id,news_title,news_desc');
        $this->db->where("news_date>=", $date);
        $this->db->order_by("news_date", "desc");
        $this->db->limit(5);
        $query = $this->db->get('news');
        return $query->result_array();
    }
    public function getBackFAQDetails()
    {
        $data = array();
        $this->db->select('*');
        $this->db->order_by('sort_order');
        $res = $this->db->get('back_faq');
        $i = 0;
        foreach ($res->result() as $row) {
            $data[$i]['id'] = $row->id;
            $data[$i]['question'] = htmlspecialchars($row->question);
            $data[$i]['answer'] = htmlspecialchars($row->answer);
            $data[$i]['status'] = $row->status;
            $data[$i]['order'] = $row->sort_order;
            $data[$i] = $this->validation_model->stripSlashArray($data[$i]);
            $data[$i]['question'] = $this->validation_model->textAreaLineBreaker(($row->question));
            $data[$i]['answer'] = $this->validation_model->textAreaLineBreaker(($row->answer));
            $i++;
        }
        return $data;
    }
    public function insertBackFAQ($question, $answer, $sort_order)
    {

        $this->db->set('question', $question);
        $this->db->set('answer', $answer);
        $this->db->set('sort_order', $sort_order);
        $this->db->set('status', 1);
        $this->db->insert('back_faq');
        return $this->db->insert_id();
    }
    public function deleteBackFAQ($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('back_faq');
        return $this->db->affected_rows();
    }

    public function isSortOrderAvailable($order)
    {
        $this->db->where('sort_order', $order);
        $this->db->where('status !=', 0);
        $this->db->from('back_faq');
        $res = $this->db->get();
        $row_count = $res->num_rows();
        return $row_count;
    }
    public function getUnreadNewsCount($user_id)
    {
        $count = 0;
        $this->db->select("read_news_count");
        $this->db->where("user_detail_refid", $user_id);
        $r_count = $this->db->get('user_details')->row()->read_news_count;
        $d_count = $this->getAllNewsCount();
        if ($d_count > $r_count) {
            $count = $d_count - $r_count;
        }
        return $count;
    }
    public function setNewsViewed($user_id)
    {
        $this->db->set('read_news_count', $this->getAllNewsCount());
        $this->db->where('user_detail_refid', $user_id);
        $this->db->update('user_details');
        return;
    }
}
