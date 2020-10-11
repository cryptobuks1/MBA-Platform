<?php
class joining_class_model extends inf_model {

    public function __construct() {
        
    }

    public function getUserName($fatherId) {
        $this->load->model('validation_model');
        $username = $this->validation_model->IdToUserName($fatherId);
        return $username;
    }

    public function todaysJoining($today, $page = '', $limit = '',$table_prefix='') {

        
            $this->db->select('id,user_name,active,father_id,date_of_joining,first_pair,join_type');
            $this->db->from($table_prefix."ft_individual");            
            $this->db->not_like('active', 'terminated', 'after');
            $this->db->like('date_of_joining', $today);
            $this->db->order_by("date_of_joining", "asc");
        if ($page == "" and $limit == "") {
            $query = $this->db->get();
        } else {            
            $this->db->limit($limit, $page);
            $query = $this->db->get();
        }
        $cnt = $query->num_rows();
        
        $this->today_join = null;
        if ($cnt > 0) {
            $i = 0;
            foreach ($query->result_array() as $search_active) {
                $this->today_join["detail$i"]["id"] = $search_active['id'];
                $this->today_join["detail$i"]["user_name"] = $search_active['user_name'];
                $this->today_join["detail$i"]["active"] = $search_active['active'];
                $this->today_join["detail$i"]["father_id"] = $search_active['father_id'];
                $this->today_join["detail$i"]["date_of_joining"] = $search_active['date_of_joining'];
                $this->today_join["detail$i"]["first_pair"] = $search_active['first_pair'];
                $usr=$search_active['id'];
                $this->today_join["detail$i"]["user_full_name"]=$this->userFullName($usr);
                $this->today_join["detail$i"]["sponsor_name"]=$this->getSponsorId($search_active['user_name']);
                $this->today_join["detail$i"]["father_user"]=$this->getUserName($search_active['father_id']);
                $this->today_join["detail$i"]["join_type"] = $search_active['join_type'];
                $i++;
            }
        }
       
        return $this->today_join;
        
    }

    public function todaysJoiningCount($date, $user_id = '') {
        $count = 0;
        if ($user_id == "") {
	    $this->db->select('id');
            $this->db->from('ft_individual');
            $this->db->not_like('active', 'terminated', 'after');
            $this->db->like('date_of_joining', $date);
            $this->db->not_like('user_type', 'admin');
	    $numrows =  $this->db->count_all_results(); // Number of rows returned from above query.
        } else {
	    $this->db->select('id');
            $this->db->from("ft_individual");
            $this->db->where('sponsor_id', $user_id);
            //$this->db->where("date_of_joining LIKE '$date%'");
            $this->db->like('date_of_joining', $date);
	    $numrows =  $this->db->count_all_results(); // Number of rows returned from above query.
        }
        return $numrows;
    }

    public function weeklyJoining($from = '', $to = '', $page = '', $limit = '') {

                $this->db->select('id,user_name,active,father_id,date_of_joining,first_pair,join_type');
                $this->db->from("ft_individual");
                $this->db->not_like('active', 'terminated', 'after');
                $this->db->where('date_of_joining >=', $from);
                $this->db->where('date_of_joining <=', $to);
                $this->db->order_by("date_of_joining", "asc");
        if ($page == "" and $limit == "") {
                $query = $this->db->get(); 
        } else { 
                $this->db->limit($limit, $page);
                $query = $this->db->get();

        }        
        $this->weekly_join = null;
        $cnt = $query->num_rows();
        if ($cnt > 0) {
            $i = 0;
            foreach ($query->result_array() as $search_active) {

                $this->weekly_join["detail$i"]["id"] = $search_active['id'];
                $this->weekly_join["detail$i"]["user_name"] = $search_active['user_name'];
                $this->weekly_join["detail$i"]["active"] = $search_active['active'];
                $this->weekly_join["detail$i"]["father_id"] = $search_active['father_id'];
                $this->weekly_join["detail$i"]["date_of_joining"] = $search_active['date_of_joining'];
                $this->weekly_join["detail$i"]["first_pair"] = $search_active['first_pair'];
                $this->weekly_join["detail$i"]["user_full_name"]=$this->userFullName($search_active['id']);
                $this->weekly_join["detail$i"]["sponsor_name"]=$this->getSponsorId($search_active['user_name']);
                $this->weekly_join["detail$i"]["father_user"]=$this->getUserName($search_active['father_id']);
                $this->weekly_join["detail$i"]["join_type"]=$search_active['join_type'];
                $i++;
            }
        }
        return $this->weekly_join;
    }
    
 function getSponsorId($user_name)
    {
        $fathers='';
        $this->db->select('sponsor_id');
        $this->db->from('ft_individual');
        $this->db->where('user_name',"$user_name");
        $query = $this->db->get();
        foreach ($query->result() as $father_id) {
                $fathers = $father_id->sponsor_id;
        }
        return $this->getSponsorName($fathers);
        
    }
    public function getSponsorName($user_id)
    {
        $sponsor='';
        $this->db->select('user_name');
        $this->db->from('ft_individual');
        $this->db->where('id',"$user_id");
        $query = $this->db->get();
        foreach ($query->result() as $sponsor_name) {
                $sponsor = $sponsor_name->user_name;
        }
        return $sponsor;
    }
    
    
 public function userFullName($user_id)
    {
        $user_full_name='';
        $this->db->select('user_detail_name');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid',"$user_id");
        $query = $this->db->get();
        foreach ($query->result() as $user_name) {
                $user_full_name = $user_name->user_detail_name;
        }
        return $user_full_name;
        
    }
    public function allJoiningpage($from, $to) {
        if ($to == "") {
            $to = $from;
        }
        $from = $from . " 00:00:00";
        $to = $to . " 23:59:59";

        $this->db->select('*');
        $this->db->from("ft_individual");
        $this->db->not_like('active', 'terminated', 'after');
        $this->db->where('date_of_joining >=', $from);
        $this->db->where('date_of_joining <=', $to);
        $numrows = $this->db->count_all_results(); // Number of rows returned from above query.
        return $numrows;
    }

}

