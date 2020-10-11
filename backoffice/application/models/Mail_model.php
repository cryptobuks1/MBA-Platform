<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mail
 *
 * @author pavanan
 */
class mail_model extends inf_model
{

    public $MEMBER_DETAILS;
    public $user_downlines;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('validation_model');
        $this->load->model('configuration_model');
    }

    public function getUsers()
    {

        $user_arr = array();
        $this->db->select('id');
        $this->db->from('ft_individual');
        $this->db->where('user_type !=', 'admin');
        $this->db->order_by('id', 'asc');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_arr[] = $row->id;
        }
        return $user_arr;
    }

    public function userNameToId($user_name)
    {

        return $this->validation_model->userNameToID($user_name);
    }

    public function sendMessageToUser($user_id, $subject, $message, $dt, $from_user = 'admin', $thread = '')
    {
        // THIS_VERSION_ONLY
        $thread = '';
        if ($thread == '') {
            $thread = $this->selectMaxThreadNumber() + 1;
        } else {
            $thread = $thread;
        }
        $data = array(
            'mailtoususer' => $user_id,
            'mailfromuser' => $from_user,
            'mailtoussub' => $subject,
            'mailtousmsg' => $message,
            'mailtousdate' => $dt,
            'thread' => $thread,
            //'thread_from' => $from_user,
        );
        $res = $this->db->insert('mailtouser', $data);
        return $res;
    }

    public function sendMessageToUserCumulative($user_id, $subject, $message, $dt, $type)
    {
        $data = array(
            'mailtoususer' => $user_id,
            'mailtoussub' => $subject,
            'mailtousmsg' => $message,
            'mailtousdate' => $dt,
            'type' => $type
        );
        $res = $this->db->insert('mailtouser_cumulativ', $data);
        return $res;
    }

    public function sendMesageToAdmin($from, $message, $subject, $dt, $table_prefix = '', $thread = '')
    {

        // THIS_VERSION_ONLY
        $thread = '';
        if ($thread == '') {
            $thread = $this->selectMaxThreadNumber() + 1;
        } else {
            $thread = $thread;
        }

        $data = array(
            'mailaduser' => $from,
            'mailadsubject' => $subject,
            'mailadidmsg' => $message,
            'status' => 'yes',
            'mailadiddate' => $dt,
            'thread' => $thread,
            //'thread_from' => $from

        );
        $res = $this->db->insert($table_prefix . 'mailtoadmin', $data);
        return $res;
    }

    public function getAdminMessages($page, $limit)
    {
        $message = array();
        $this->db->select('*');
        $this->db->from('mailtoadmin');
        $this->db->where('status', 'yes');
        $where = array('status' => 'no', 'deleted_by != ' => $this->LOG_USER_ID, 'deleted_by !=' => 'both');
        $this->db->or_group_start()
            ->where($where);
        $this->db->group_end();
        $this->db->group_by('mailtoadmin.thread');
        $this->db->order_by('mailadiddate', 'desc');
        $this->db->limit($limit, $page);
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $message[$i]['id'] = $row['mailadid'];
            $message[$i]['mailaduser'] = $row['mailaduser'];
            $message[$i]['mailadsubject'] = $row['mailadsubject'];
            $message[$i]['mailadiddate'] = $row['mailadiddate'];
            $message[$i]['status'] = $row['status'];
            $message[$i]['mailadidmsg'] = stripslashes($row['mailadidmsg']);
            $message[$i]['read_msg'] = $row['read_msg'];
            $message[$i]['type'] = "admin";
            $message[$i]['flag'] = 1;
            $message[$i]['thread'] = $row['thread'];;

            $message[$i]['user_name'] = $this->validation_model->idToUserName($row['mailaduser']);

            $i++;
        }
        return $message;
    }

    public function getContactMessages($page, $limit, $logged_id)
    {
        $message = array();
        $this->db->select('*');
        $this->db->from('contacts');
        $this->db->where('owner_id', $logged_id);
        $this->db->where('status', 'yes');
        $this->db->order_by('mailadiddate', 'desc');
        $this->db->limit($limit, $page);
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $message[$i]['id'] = $row['id'];
            $message[$i]['mailaduser'] = $row['contact_name'];
            $message[$i]['mailadsubject'] = $row['contact_name'] . " Contacted You";
            $message[$i]['mailadiddate'] = $row['mailadiddate'];
            $message[$i]['status'] = $row['status'];
            if ($row['contact_info'] == '') {
                $message[$i]['mailadidmsg'] = "Name:" . $row['contact_name'] . "<br>Email:" . $row['contact_email'] . "<br>Address:" . $row['contact_address'] . "<br>Phone:" . $row['contact_phone'] . "<br>Describtion:NA";
            } else {
                $message[$i]['mailadidmsg'] = "Name:" . $row['contact_name'] . "<br>Email:" . $row['contact_email'] . "<br>Address:" . $row['contact_address'] . "<br>Phone:" . $row['contact_phone'] . "<br>Describtion:" . $row['contact_info'];
            }
            $message[$i]['read_msg'] = $row['read_msg'];
            $message[$i]['type'] = "contact";
            $message[$i]['flag'] = '';
            $message[$i]['user_name'] = $row['contact_name'];
            $i++;
        }
        return $message;
    }

    public function getAdminMessagesSent($page, $limit)
    {
        $user_id = $this->LOG_USER_ID;
        $message = array();
        $this->db->select('*');
        $this->db->from('mailtouser');
        $where1 = array('status' => 'yes', 'mailfromuser' => $user_id);
        $where2 = array('status' => 'no', 'deleted_by != ' => $user_id, 'mailfromuser' => $user_id, 'deleted_by !=' => 'both');
        $this->db->group_start()
            ->where($where1)
            ->or_group_start()
            ->where($where2)
            ->group_end()
            ->group_end();
        $this->db->group_by('thread');
        $this->db->order_by('mailtousdate', 'desc');
        $this->db->limit($limit, $page);
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $row = $this->validation_model->stripSlashResultArray($row);
            $message[$i]['id'] = $row['mailtousid'];
            $message[$i]['mailtoususer'] = $row['mailtoususer'];
            $message[$i]['mailtoussub'] = $row['mailtoussub'];
            $message[$i]['mailtousdate'] = $row['mailtousdate'];
            $message[$i]['status'] = $row['status'];
            $message[$i]['type'] = "user";
            $message[$i]['mailtousmsg'] = html_entity_decode($row['mailtousmsg']);
            $message[$i]['user_name'] = $this->validation_model->idToUserName($row['mailtoususer']);
            $message[$i]['thread'] = $row['thread'];

            $i++;
        }
        $this->db->select('*');
        $this->db->from('mailtouser_cumulativ');
        $this->db->where('type', 'ext_mail');
        $this->db->where('status', 'yes');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $row = $this->validation_model->stripSlashResultArray($row);
            $message[$i]['id'] = $row['mailtousid'];
            $message[$i]['mailtoususer'] = $row['mailtoususer'];
            $message[$i]['mailtoussub'] = $row['mailtoussub'];
            $message[$i]['mailtousdate'] = $row['mailtousdate'];
            $message[$i]['status'] = $row['status'];
            $message[$i]['type'] = $row['type'];
            $message[$i]['mailtousmsg'] = html_entity_decode($row['mailtousmsg']);
            $message[$i]['user_name'] = $row['mailtoususer'];

            $i++;
        }
        function cmp($a, $b)
        {
            $a["date"] = strtotime($a["mailtousdate"]);
            $b["date"] = strtotime($b["mailtousdate"]);
            return ($a["date"] < $b["date"]) ? 1 : -1;
        }

        usort($message, "cmp");
        return $message;
    }

    public function getCountAdminMessages()
    {
        $this->db->select('*');
        $this->db->from('mailtoadmin');
        $this->db->where('status', 'yes');
        $count = $this->db->count_all_results();
        return $count;
    }

    public function getCountContactMessages($user_id)
    {
        $this->db->select('*');
        $this->db->from('contacts');
        $this->db->where('owner_id', $user_id);
        $this->db->where('status', 'yes');

        $count = $this->db->count_all_results();
        return $count;
    }

    public function getCountAdminMessagesSent($user_id)
    {

        $this->db->select('*');
        $this->db->from('mailtouser');
        $where1 = array('status' => 'yes', 'mailfromuser' => $user_id);
        $where2 = array('status' => 'no', 'deleted_by != ' => $user_id, 'mailfromuser' => $user_id, 'deleted_by !=' => 'both');
        $this->db->group_start()
            ->where($where1)
            ->or_group_start()
            ->where($where2)
            ->group_end()
            ->group_end();
        $this->db->group_by('thread');

        $count = $this->db->count_all_results();
        return $count;
    }

    public function getCountUserMessages($user_id)
    {

        $this->db->select('*');
        $this->db->from('mailtouser');
        $this->db->where('status', 'yes');
        $this->db->where('mailtoususer', $user_id);
        $count = $this->db->count_all_results();
        return $count;
    }

    public function getAdminOneMessage($id)
    {
        $this->db->select('*');
        $this->db->from('mailtoadmin');
        $this->db->where('mailadid', $id);
        //$this->db->where('status', 'yes');
        $res = $this->db->get();
        return $res;
    }

    public function updateAdminOneMessage($msg_id)
    {
        $data = array(
            'read_msg' => 'yes',
        );
        $this->db->where('mailadid', $msg_id);
        $this->db->where('status', 'yes');
        $this->db->update('mailtoadmin', $data);
    }

    public function updateUserOneMessage($msg_id, $this_prefix = '')
    {
        $data = array(
            'read_msg' => 'yes',
        );
        $this->db->where('mailtousid', $msg_id);
        $this->db->where('status', 'yes');
        $this->db->update($this_prefix . 'mailtouser', $data);
    }

    public function getUserOneMessage($id, $user_id)
    {
        $this->db->select('*');
        $this->db->from('mailtouser');
        $this->db->where('mailtousid', $id);
        $this->db->where('mailtoususer', $user_id);
        //$this->db->where('status', 'yes');
        $res = $this->db->get();
        return $res;
    }

    public function getUserMessages($user_id, $page, $limit = '', $table_prefix = '')
    {
        $message = array();

        $this->db->select('*');
        $this->db->from($table_prefix . 'mailtouser');
        $where1 = array('status' => 'yes', 'mailtoususer' => $user_id);
        $where2 = array('status' => 'no', 'deleted_by != ' => $user_id, 'mailtoususer' => $user_id, 'deleted_by !=' => 'both');
        $this->db->group_start()
            ->where($where1)
            ->or_group_start()
            ->where($where2)
            ->group_end()
            ->group_end();
        $this->db->group_by($table_prefix . 'mailtouser.thread');
        $this->db->order_by('mailtousdate', 'desc');
        if ($limit != '') {
            $this->db->limit($limit, $page);
        }
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $row = $this->validation_model->stripSlashResultArray($row);
            $message[$i]['mailtousid'] = $row['mailtousid'];
            $message[$i]['mailtoususer'] = $row['mailtoususer'];
            $message[$i]['mailtoussub'] = $row['mailtoussub'];
            $message[$i]['mailtousmsg'] = $row['mailtousmsg'];
            $message[$i]['mailtousdate'] = $row['mailtousdate'];
            $message[$i]['status'] = $row['status'];
            $message[$i]['read_msg'] = $row['read_msg'];
            $message[$i]['type'] = "user";
            $message[$i]['flag'] = 1;
            $message[$i]['user_name'] = $this->validation_model->idToUserName($row['mailtoususer']);
            if ($row['mailfromuser'] != 'admin') {
                $message[$i]['from_user_name'] = $this->validation_model->idToUserName($row['mailfromuser']);
            } else {
                $message[$i]['from_user_name'] = $this->ADMIN_USER_NAME;
            }
            $message[$i]['thread'] = $row['thread'];
            $i++;
        }
        return $message;
    }

    public function getUserContactMessages($user_id, $page, $limit = '', $table_prefix = '')
    {
        $message = array();
        $this->db->select('*');
        $this->db->from('contacts');
        $this->db->where('owner_id', $user_id);
        $this->db->where('status', 'yes');
        $this->db->order_by('mailadiddate', 'desc');
        $this->db->limit($limit, $page);
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $message[$i]['mailtousid'] = $row['id'];
            $message[$i]['mailtoususer'] = $row['contact_name'];
            $message[$i]['mailtoussub'] = $row['contact_name'] . " Contacted You";
            if ($row['contact_info'] == '') {
                $message[$i]['mailtousmsg'] = "Name:" . $row['contact_name'] . "<br>Email:" . $row['contact_email'] . "<br>Address:" . $row['contact_address'] . "<br>Phone:" . $row['contact_phone']
                    . "<br>Describtion:NA";
            } else {
                $message[$i]['mailtousmsg'] = "Name:" . $row['contact_name'] . "<br>Email:" . $row['contact_email'] . "<br>Address:" . $row['contact_address'] . "<br>Phone:" . $row['contact_phone']
                    . "<br>Describtion:" . $row['contact_info'];
            }
            $message[$i]['mailtousdate'] = $row['mailadiddate'];
            $message[$i]['status'] = $row['status'];
            $message[$i]['read_msg'] = $row['read_msg'];
            $message[$i]['type'] = "contact";
            $message[$i]['flag'] = '';
            $message[$i]['user_name'] = $row['contact_name'] . " Contacted You";
            $message[$i]['from_user_name'] = $row['contact_name'];
            $i++;
        }
        return $message;
    }

    public function getCountUserContactMessages($user_id)
    {

        $this->db->select('*');
        $this->db->from('contacts');
        $this->db->where('status', 'yes');
        $this->db->where('owner_id', $user_id);
        $count = $this->db->count_all_results();
        return $count;
    }

    public function getUserMessagesSent($user_id, $page, $limit = '', $table_prefix = '')
    {
        $mails = array();
        $this->db->select('*');
        $this->db->from('mailtoadmin');
        $where1 = array('status' => 'yes', 'mailaduser' => $user_id);
        $where2 = array('status' => 'no', 'deleted_by != ' => $user_id, 'mailaduser' => $user_id, 'deleted_by !=' => 'both');
        $this->db->group_start()
            ->where($where1)
            ->or_group_start()
            ->where($where2)
            ->group_end()
            ->group_end();
        $this->db->group_by('thread');
        $this->db->order_by('mailadiddate', 'desc');
        if ($limit != '') {
            $this->db->limit($limit, $page);
        }
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $row['mailadidmsg'] = stripslashes($row['mailadidmsg']);
            $row['user_name'] = $this->validation_model->getAdminUsername();
            $row['type'] = 'to_admin';
            $mails[] = $row;
        }
        $this->db->select('*');
        $this->db->from('mailtouser');
        $where1 = array('status' => 'yes', 'mailfromuser' => $user_id);
        $where2 = array('status' => 'no', 'deleted_by != ' => $user_id, 'mailfromuser' => $user_id, 'deleted_by !=' => 'both');
        $this->db->group_start()
            ->where($where1)
            ->or_group_start()
            ->where($where2)
            ->group_end()
            ->group_end();
        $this->db->group_by('thread');
        $this->db->order_by('mailtousdate', 'desc');
        if ($limit != '') {
            $this->db->limit($limit, $page);
        }
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $row['mailadidmsg'] = html_entity_decode($row['mailtousmsg']);
            $row['user_name'] = $this->validation_model->idToUserName($row['mailtoususer']);
            $row['mailadid'] = $row['mailtousid'];
            $row['mailadmsg'] = $row['mailtousmsg'];
            $row['mailadsubject'] = $row['mailtoussub'];
            $row['mailadiddate'] = $row['mailtousdate'];
            $row['type'] = 'to_user';
            $mails[] = $row;
        }
        $this->db->select('*');
        $this->db->from('mailtouser_cumulativ');
        $this->db->where('type', 'ext_mail_user');
//      $this->db->where('mailfromuser', $user_id);
        $this->db->where('status', 'yes');
        $this->db->order_by('mailtousdate', 'desc');
        if ($limit != '') {
            $this->db->limit($limit, $page);
        }
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $row['mailadidmsg'] = html_entity_decode($row['mailtousmsg']);
            $row['user_name'] = $row['mailtoususer'];
            $row['mailadid'] = $row['mailtousid'];
            $row['mailadmsg'] = $row['mailtousmsg'];
            $row['mailadsubject'] = $row['mailtoussub'];
            $row['mailadiddate'] = $row['mailtousdate'];
            $row['type'] = 'ext_mail_user';
            $mails[] = $row;
        }

        return $mails;
    }

    public function updateAdminMessage($msg_id, $flag = '')
    {
        $this->db->select('deleted_by');
        $this->db->from('mailtoadmin');
        if ($flag != '') {
            $this->db->where('thread', $msg_id);
        } else {
            $this->db->where('mailadid', $msg_id);
        }
        $query = $this->db->get();
        $result = $query->row_array()['deleted_by'];
        if ($result == 0 || $result == $this->LOG_USER_ID) {
            $data = array(
                'status' => 'no',
                'deleted_by' => $this->LOG_USER_ID
            );
        } else {
            $data = array(
                'status' => 'no',
                'deleted_by' => 'both'
            );
        }
        if ($flag != '') {
            $this->db->where('thread', $msg_id);
        } else {
            $this->db->where('mailadid', $msg_id);
        }
        $res = $this->db->update('mailtoadmin', $data);
        return $res;
    }

    public function updateContactMessage($msg_id)
    {
        $data = array(
            'status' => 'no'
        );
        $this->db->where('id', $msg_id);
        $res = $this->db->update('contacts', $data);
        return $res;
    }

    public function updateAdminSentMessage($msg_id)
    {
        $data = array(
            'status' => 'no'
        );
        $this->db->where('mailtousid', $msg_id);
        $res = $this->db->update('mailtouser_cumulativ', $data);
        return $res;
    }

    public function updateUserMessage($msg_id, $flag = '')
    {
        $this->db->select('deleted_by');
        $this->db->from('mailtouser');
        if ($flag != '') {
            $this->db->where('thread', $msg_id);
        } else {
            $this->db->where('mailtousid', $msg_id);
        }
        $query = $this->db->get();
        $result = $query->row_array()['deleted_by'];

        if ($result == 0 || $result == $this->LOG_USER_ID) {
            $data = array(
                'status' => 'no',
                'deleted_by' => $this->LOG_USER_ID
            );
        } else {
            $data = array(
                'status' => 'no',
                'deleted_by' => 'both'
            );
        }
        if ($flag != '') {
            $this->db->where('thread', $msg_id);
        } else {
            $this->db->where('mailtousid', $msg_id);
        }
        $res = $this->db->update('mailtouser', $data);
        return $res;
    }

    public function updateDownlineSendMessage($msg_id)
    {
        $data = array(
            'status' => 'deleted'
        );
        $this->db->where('mail_id', $msg_id);
        $res = $this->db->update('mail_from_lead_cumulative', $data);
        return $res;
    }

    public function updateDownlineFromMessage($msg_id)
    {

        $data = array(
            'status' => 'deleted'
        );
        $this->db->where('mail_id', $msg_id);
        $res = $this->db->update('mail_from_lead', $data);
        return $res;
    }

    public function updateuserContactMessage($msg_id)
    {
        $data = array(
            'status' => 'no'
        );
        $this->db->where('id', $msg_id);
        $res = $this->db->update('contacts', $data);
        return $res;
    }

    public function updateUserMessageSent($msg_id, $type = '')
    {
        if ($type == 'to_user' || $type == 'user') {
            $this->db->select('deleted_by');
            $this->db->from('mailtouser');
            $this->db->where('thread', $msg_id);
            $query = $this->db->get();
            $result = $query->row_array()['deleted_by'];
            if ($result == 0 || $result == $this->LOG_USER_ID) {
                $data = array(
                    'status' => 'no',
                    'deleted_by' => $this->LOG_USER_ID
                );
            } else {
                $data = array(
                    'status' => 'no',
                    'deleted_by' => 'both'
                );
            }
            $this->db->where('thread', $msg_id);
            $res = $this->db->update('mailtouser', $data);
        } elseif ($type == 'to_admin') {
            $this->db->select('deleted_by');
            $this->db->from('mailtoadmin');
            $this->db->where('thread', $msg_id);
            $query = $this->db->get();
            $result = $query->row_array()['deleted_by'];
            if ($result == 0 || $result == $this->LOG_USER_ID) {
                $data2 = array(
                    'status' => 'no',
                    'deleted_by' => $this->LOG_USER_ID
                );
            } else {
                $data2 = array(
                    'status' => 'no',
                    'deleted_by' => 'both'
                );
            }
            $this->db->where('thread', $msg_id);
            $res = $this->db->update('mailtoadmin', $data2);
        }
        return $res;
    }

    public function updateMsgStatus($msg_id, $thread = '')
    {
        $count = "";
        $user_name = $this->LOG_USER_NAME;
        $user_type = $this->LOG_USER_TYPE;
        $user_id = $this->LOG_USER_ID;
        $reslt_admin_read = "";
        $reslt_user_read = "";
        if ($user_type == 'admin' || $user_type == "employee") {
            $data = array(
                'read_msg' => 'yes'
            );

            if ($thread != '') {
                $this->db->where('thread', $thread);
            } else {
                $this->db->where('mailadid', $msg_id);
            }

            $reslt_admin_read = $this->db->update('mailtoadmin', $data);
        } else {
            $data = array(
                'read_msg' => 'yes'
            );
            if ($thread != '') {
                $this->db->where('thread', $thread);
            } else {
                $this->db->where('mailtousid', $msg_id);
            }
            $reslt_user_read = $this->db->update('mailtouser', $data);
        }
        if ($reslt_admin_read) {
            $this->db->select('mailaduser');
            $this->db->where('read_msg', 'no');
            $this->db->from('mailtoadmin');
            $count = $this->db->count_all_results();
            return $count;
        }
        if ($reslt_user_read) {
            $this->db->select('mailtoususer');
            $this->db->where('read_msg', 'no');
            $this->db->where('mailtoususer', $user_id);
            $this->db->from('mailtouser');
            $count = $this->db->count_all_results();
            return $count;
        }
    }

    public function getAdminId()
    {
        return $this->validation_model->getAdminId();
    }

    public function getEmailId($user_id, $mailBodyDetails = '', $subject = '')
    {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $user_details = $this->table_prefix . "user_details";
        $dbprefix = $this->db->dbprefix;
        $this->db->set_dbprefix('');
        $this->db->select('user_detail_email');
        $this->db->where('user_detail_refid', $user_id);
        $query = $this->db->get($user_details);
        $this->db->set_dbprefix($dbprefix);

        $email = $query->row_array()['user_detail_email'];
        if ($email) {
            $this->sendEmail($mailBodyDetails, $email, $subject);
        }
    }

    public function sendEmail($mailBodyDetails, $email, $mail_subject = '', $attachments = array())
    {

        //$attachments = array(BASEPATH . "../public_html/images/logos/logo.png");

        $this->load->library('inf_phpmailer', null, 'phpmailer');

        $site_info = $this->validation_model->getSiteInformation();
        $common_mail_settings = $this->configuration_model->getMailDetails();

        //$mail_type = $common_mail_settings['reg_mail_type']; //normal/smtp
        $mail_type = 'normal'; //normal/smtp
        $smtp_data = array();
        if ($mail_type == "smtp") {
            $smtp_data = array(
                "SMTPAuth" => $common_mail_settings['smtp_authentication'],
                "SMTPSecure" => ($common_mail_settings['smtp_protocol'] == "none") ? "" : $common_mail_settings['smtp_protocol'],
                "Host" => $common_mail_settings['smtp_host'],
                "Port" => $common_mail_settings['smtp_port'],
                "Username" => $common_mail_settings['smtp_username'],
                "Password" => $common_mail_settings['smtp_password'],
                "Timeout" => $common_mail_settings['smtp_timeout'],
                    //"SMTPDebug" => 3 //uncomment this line to check for any errors
            );
        }
        $mail_to = array("email" => $email, "name" => $email);
        $mail_from = array("email" => $site_info['email'], "name" => $site_info['company_name']);
        $mail_reply_to = $mail_from;

        $send_mail = $this->phpmailer->send_mail($mail_from, $mail_to, $mail_reply_to, $mail_subject, $mailBodyDetails, $mailBodyDetails, $mail_type, $smtp_data, $attachments);

        if (!$send_mail['status']) {
            $data["message"] = "Error: " . $send_mail['ErrorInfo'];
        } else {
            $data["message"] = "Message sent correctly!";
        }

        return $send_mail;
    }

    /////////////////______________________________|\


    public function getAllReadMessages($type)
    {
        $inf_sess = $this->session->userdata('inf_logged_in');
        $user_name = $inf_sess['user_name'];
        $id = $this->userNameToId($user_name);
        if ($type == "admin") {
            $mail = 'mailtoadmin';
            $this->db->select('mailadid');
            $this->db->from($mail);
            $this->db->where('status', 'yes');
            $this->db->where('read_msg', 'yes');
        } else if ($type == "user") {
            $mail = 'mailtouser';
            $this->db->select('mailtousid');
            $this->db->from($mail);
            $this->db->where('mailtoususer', $id);
            $this->db->where('status', 'yes');
            $this->db->where('read_msg', 'yes');
        }
        $numrows = $this->db->count_all_results(); // Number of rows returned from above query.
        return $numrows;
    }

    public function getAllUnreadMessages($type)
    {
        $inf_sess = $this->session->userdata('inf_logged_in');
        $user_name = $inf_sess['user_name'];
        $id = $this->userNameToId($user_name);

        if ($type == "admin") {
            $mail = 'mailtoadmin';
            $this->db->select('mailadid');
            $this->db->where('status', 'yes');
            $this->db->where('read_msg', 'no');
            $this->db->from($mail);
        } else {
            $mail = 'mailtouser';
            $this->db->select('mailtousid');
            $this->db->where('mailtoususer', $id);
            $this->db->where('status', 'yes');
            $this->db->where('read_msg', 'no');
            $this->db->from($mail);
        }
        $numrows = $this->db->count_all_results(); // Number of rows returned from above query.
        return $numrows;
    }

    public function getCountUserUnreadMessages($type, $id)
    {

        $this->db->select('*');
        $this->db->where('status', 'yes');
        $this->db->where('read_msg', 'no');
        $this->db->where('mailtoususer', $id);
        $this->db->from('mailtouser');

        $count = $this->db->count_all_results();
        return $count;
    }

    public function getUnreadMessages($type)
    {

        $this->db->select('*');
        $this->db->from('mailtouser');
        $this->db->where('status', 'yes');
        $this->db->where('read_msg', 'no');
        $this->db->where('mailtoususer', $type);
        $count = $this->db->count_all_results();

        return $count;
    }

    public function getAllMessagesToday($type)
    {
        $count = 0;
        $date = date("Y-m-d");

        if ($type == "admin") {
            $mail = 'mailtoadmin';
            $this->db->select('mailadid');
            $this->db->from($mail);
            $this->db->where('status', 'yes');
            $this->db->like('mailadiddate', $date);
        } else if ($type == "user") {
            $inf_sess = $this->session->userdata('inf_logged_in');
            $user_name = $inf_sess['user_name'];
            $id = $this->userNameToId($user_name);
            $mail = 'mailtouser';
            $this->db->select('mailtousid');
            $this->db->from($mail);
            $this->db->where('status', 'yes');
            $this->db->where('mailtoususer', $id);
            $this->db->like('mailtousdate', $date);
        }
        $query = $this->db->get();
        $numrows = $query->num_rows(); // Number of rows returned from above query.
        return $numrows;
    }

    public function getAdminUsername()
    {

        $this->db->select('user_name');
        $this->db->from('ft_individual');
        $this->db->where('user_type', 'admin');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_name = $row->user_name;
        }
        return $user_name;
    }

    function getUserDownlinesAll($user_id)
    {
        $arr1[] = $user_id;
        $this->referals = null;
        //$limit = $this->getDepthCeiling();
        $i = 0;
        $level_arr = $this->getAllReferrals($arr1, $i);

        return $level_arr;
    }

    public function getAllReferrals($user_id_arr, $i)
    {
        $temp_user_id_arr = array();
        $temp = 0;
        if (count($user_id_arr)) {
            $qr = $this->createQuery($user_id_arr);
            $res = $this->db->query("$qr");
            foreach ($res->result_array() as $row) {
                $user_array = array(
                    "user_id" => $row['id'],
                    //"customer_id" => $row['oc_customer_ref_id'],
                    "user_name" => $row['user_name'],
                );
                $this->user_downlines[$i][] = $user_array;
                $temp_user_id_arr[] = $row['id'];
                $temp = $row['id'];
            }
        }
        $i = $i + 1;

        if ($temp) {
            $this->getAllReferrals($temp_user_id_arr, $i);
        }

        return $this->user_downlines;
    }

    public function createQuery($user_id_arr)
    {
        $this->load->database();
        $db_prefix = $this->db->dbprefix;
        $ft_individual = $db_prefix . "ft_individual";
        $arr_len = count($user_id_arr);
        for ($i = 0; $i < $arr_len; $i++) {
            $user_id = $user_id_arr[$i];
            if ($i == 0) {
                $where_qr = "father_id = '$user_id'";
            } else {
                $where_qr .= " OR father_id = '$user_id'";
            }
        }
        $qr = "Select id, user_name from $ft_individual where ($where_qr)";

        return $qr;
    }

    function sendMessageToAllDownlines($mailBodyDetails, $from_user_id, $user_downlines, $subject)
    {
        foreach ($user_downlines as $levels) {
            foreach ($levels as $users) {
                $to_user_id = $users['user_id'];
                //$user_name = $this->validation_model->IdToUserName($to_user_id);
                //$email = $this->getUserEmail($user_name);
                //$this->sendMailUser($email, $mailBodyDetails, $subject);
                $this->sendMessageToDownlines($subject, $from_user_id, $to_user_id, $mailBodyDetails);
            }
        }
        return true;
    }

    public function sendMessageToDownlines($subject, $from_id, $to_id, $message)
    {
        $date = date("Y-m-d H:i:s");
        $data = array(
            'mail_sub' => $subject,
            'mail_from' => $from_id,
            'mail_to' => $to_id,
            'message' => $message,
            'mail_date' => $date
        );
        $res = $this->db->insert('mail_from_lead', $data);
        if ($res) {
            $thread = $this->selectMaxThreadNumber() + 1;
            $this->sendMessageToUser($to_id, $subject, $message, $date, $from_id, $thread);
        }
        return $res;
    }

    public function sendMessageToDownlinesCumulative($subject, $from_id, $to_id, $message, $type)
    {
        $data = array(
            'mail_sub' => $subject,
            'mail_from' => $from_id,
            'mail_to' => $to_id,
            'message' => $message,
            'type' => $type,
            'mail_date' => date("Y-m-d H:i:s")
        );
        $res = $this->db->insert('mail_from_lead_cumulative', $data);
        return $res;
    }

    public function sendAllEmails($type = 'notification', $regr = array(), $attachments = array(), $user_id = '')
    {

        if ($regr['email'] == "iossmlm@gmail.com") {
            //return true;
        }

        //$attachments = array(BASEPATH . "../public_html/images/logos/logo.png");

        $this->load->library('inf_phpmailer', null, 'phpmailer');

        $site_info = $this->validation_model->getSiteInformation();
        $common_mail_settings = $this->configuration_model->getMailDetails();

        //$mail_type = $common_mail_settings['reg_mail_type']; //normal/smtp
        $mail_type = 'normal'; //normal/smtp
        $smtp_data = array();
        if ($mail_type == "smtp") {
            $smtp_data = array(
                "SMTPAuth" => $common_mail_settings['smtp_authentication'],
                "SMTPSecure" => ($common_mail_settings['smtp_protocol'] == "none") ? "" : $common_mail_settings['smtp_protocol'],
                "Host" => $common_mail_settings['smtp_host'],
                "Port" => $common_mail_settings['smtp_port'],
                "Username" => $common_mail_settings['smtp_username'],
                "Password" => $common_mail_settings['smtp_password'],
                "Timeout" => $common_mail_settings['smtp_timeout'],
                    //"SMTPDebug" => 3 //uncomment this line to check for any errors
            );
        }
        $mail_to = array("email" => $regr['email'], "name" => $regr['first_name'] . " " . $regr['last_name']);
        if ($type == "ext_mail") {
            $mail_from = array("email" => $regr['email_from'], "name" => $regr['full_name']);
        } else {
            $mail_from = array("email" => $site_info['email'], "name" => $site_info['company_name']);
        }
        $mail_reply_to = $mail_from;
        $mail_subject = "Notification";

        $mailBodyHeaderDetails = $this->getHeaderDetails($site_info);
        if ($type == "registration") {
            $content = $this->configuration_model->getEmailManagementContent($type);
            $mail_altbody = html_entity_decode($content['content']);
            $mailBodyDetails = $this->getRegisterationMailDetails($mail_altbody, $regr);
            $mailBodyDetails = str_replace("{fullname}", $regr['first_name'] . " " . $regr['last_name'], $mailBodyDetails);
            $mailBodyDetails = str_replace("{username}", $regr['user_name_entry'], $mailBodyDetails);
            $mailBodyDetails = str_replace("{company_name}", $site_info['company_name'], $mailBodyDetails);
            $mailBodyDetails = str_replace("{company_address}", $site_info['company_address'], $mailBodyDetails);
            $mailBodyDetails = str_replace("{sponsor_username}", $regr['sponsor_user_name'], $mailBodyDetails);
            $mailBodyDetails = str_replace("{payment_type}", $regr['payment_type'], $mailBodyDetails);
            $mail_subject = $content['subject'] . ' ' . $site_info['company_name'];
        } else if ($type == "payout_release") {
            $content = $this->configuration_model->getEmailManagementContent($type);
            $mail_altbody = html_entity_decode($content['content']);
            $mailBodyDetails = $mail_altbody;
            $mailBodyDetails = str_replace("{fullname}", $regr['first_name'] . " " . $regr['last_name'], $mailBodyDetails);
            $mailBodyDetails = str_replace("{company_name}", $site_info['company_name'], $mailBodyDetails);
            $mailBodyDetails = str_replace("{company_address}", $site_info['company_address'], $mailBodyDetails);
            $mail_subject = $content['subject'];
        } else if ($type == "autoresponder") {
            $mail_content = html_entity_decode($regr['mail_content']);
            $mailBodyDetails = $mail_content;
            $mail_subject = $regr['subject'];
            $mailBodyDetails = str_replace("{visitor_name}", $regr['user_name'], $mail_content);
            $mailBodyDetails = str_replace("{member_name}", $regr['sponser_name'], $mail_content);
            $mailBodyDetails = str_replace("{member_email}", $regr['sponser_email'], $mail_content);
        } else if ($type == "change_password") {
            $content = "Your password has been sucessfully changed, Your new password is";
            $mail_altbody = $content;
            $mailBodyDetails = $this->getPasswordDetails($content, $regr);
            $mail_subject = 'Change Password';
        } else if ($type == "send_tranpass") {
            $content = "Your new Transaction Password is ";
            $mail_altbody = $content;
            $mailBodyDetails = $this->getTransactionPasswordDetails($content, $regr);
            $mail_subject = 'Transaction Password';
        } else if ($type == 'payout_request') {
            $mail_subject = "User Requested Payout";
            $mail_altbody = "User Requested Payout";
            $mailBodyDetails = $this->getPayoutRequestDetails($regr);
        } else if ($type == 'invaite_mail') {

            $mail_subject = "Invite Email";
            $mail_altbody = "Invite Email";
            $mailBodyDetails = $regr['mail_content'];
        } else if ($type == 'forgot_password') {
            $mail_subject = "Forgot Password";
            $mail_altbody = "Forgot Password";
            $this->load->model('login_model');
            $keyword = $this->login_model->getKeyWord($regr['user_id']);
            $keyword_encode = $this->encrypt->encode($keyword);
            $keyword_encode = str_replace("/", "_", $keyword_encode);
            $keyword_encode = urlencode($keyword_encode);
            $link = base_url() . "login/reset_password/$keyword_encode";

            $mailBodyDetails = '<body>
<table border="0" width="800" height="700" align="center">
<tr>
<td    colspan="4"valign="top" ><br><br><br>
<br>
<font size="3" face="Trebuchet MS">
Dear  Customer,</b><br>
     <p syte="pading-left:20px;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;you are recently requested  reset password for that please follow the below link:<p>
  <a href="' . $link . '">' . $link . '</a>
  <br><br><br>
  </td>
</tr>
</font>
</table>
</body>';
        } elseif ($type == 'reset_googleAuth') {
            $mail_subject = "Reset Google Authentication";
            $mail_altbody = "Reset Google Authentication";
            $keyword = $regr['user_id'];
            $keyword_encode = $this->encrypt->encode($keyword);
            $keyword_encode = str_replace("/", "_", $keyword_encode);
            $keyword_encode = urlencode($keyword_encode);
            $this->load->model('login_model');
            $random_key = $this->login_model->getAuthKeyWord($regr['user_id']);
            $random_key = $this->encrypt->encode($random_key);
            $random_key = str_replace("/", "_", $random_key);
            $random_key = urlencode($random_key);

            $link = base_url() . "login/one_tme_password_generate/$keyword_encode/$random_key";

            $mailBodyDetails = '<body>
<table border="0" width="800" height="700" align="center">
<tr>
<td    colspan="4"valign="top" ><br><br><br>
<br>
<font size="3" face="Trebuchet MS">
Dear  Customer,</b><br>
     <p syte="pading-left:20px;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;you are recently requested  reset Google Authentication for that please follow the below link:<p>
  <a href="' . $link . '">' . $link . '</a>
  <br><br><br>
  </td>
</tr>
</font>
</table>
</body>';

        } else if ($type == 'lcp_reply') {
            $mail_subject = "Your Lead Reply";
            $mail_altbody = "User updated your query..";
            $mailBodyDetails = $this->getLCPMailBody($regr);
        } else if ($type == 'forgot_transaction_password') {
            $mail_subject = "Forgot Transaction Password";
            $mail_altbody = "Forgot Transaction Password";
            $this->load->model('tran_pass_model');
            $admin_username = $this->validation_model->getAdminUsername();
            $keyword = $this->tran_pass_model->getKeyWord($regr['user_id']);
            $keyword_encode = $this->encrypt->encode($keyword);
            $keyword_encode = str_replace("/", "_", $keyword_encode);
            $keyword_encode = urlencode($keyword_encode);

            $link = base_url() . "login/reset_tran_password/$keyword_encode/$admin_username";

            $mailBodyDetails = '<body>
<table border="0" width="800" height="700" align="center">
<tr>
<td    colspan="4"valign="top" ><br><br><br>
<br>
<font size="3" face="Trebuchet MS">
Dear  Customer,</b><br>
     <p syte="pading-left:20px;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You have recently requested to change your Transaction password. Follow the link below to reset the Transaction password:<p>
  <a href="' . $link . '">' . $link . '</a>
  <br><br><br>
  </td>
</tr>
</font>
</table>
</body>';
        } else if ($type == 'external_mail') {
            $mail_subject = $regr['subject'];
            $mail_altbody = $regr['subject'];
            $mailBodyDetails = $this->getExtMail($regr);
        }

        $mailBodyDetails = str_replace("{banner_img}", $this->PUBLIC_URL . 'images/banners/banner.jpg', $mailBodyDetails);
        $mailBodyFooterDetails = $this->getFooterDetails($site_info);
        $mail_body = $mailBodyHeaderDetails . $mailBodyDetails . $mailBodyFooterDetails . "</br></br></br></br></br>";
        if ($this->validation_model->getModuleStatusByKey('mail_gun_status') == 'yes') {
            $this->load->model('mail_gun_model');
            return $this->mail_gun_model->sendEmail($mailBodyDetails, $mail_to['email'], $mail_subject);
        } else {
            $send_mail = $this->phpmailer->send_mail($mail_from, $mail_to, $mail_reply_to, $mail_subject, $mail_body, $mail_altbody, $mail_type, $smtp_data, $attachments);
        }
        if (!$send_mail['status']) {
            $data["message"] = "Error: " . $send_mail['ErrorInfo'];
        } else {
            $data["message"] = "Message sent correctly!";
        }
        return $send_mail;
    }

    public function getHeaderDetails($site_info)
    {
        $current_date = date('M d,Y H:i:s');
        $company_address = $site_info['company_address'];
        $company_name = $site_info['company_name'];
        $site_logo = $site_info['logo'];

        $mailBodyHeaderDetails = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <title>' . $company_name . '</title>
        </head>
        <body style="margin:0px;">
            <div class="container" style="font-family: roboto;width:830px;margin-left:auto;margin-right:auto;background:#f9f9f9;border-top:20px solid #ed0000;">

                <div class="header" style="height:117px;">
                    <div style="float: left;">
                        <img src="' . SITE_URL . 'images/logos/' . $site_logo . '" style="margin: 15px 0px 10px 19px;"/>
                    </div>
                </div>
                <div>
                    <p style="font-size: 17px; line-height: 27px; color: ##353535;">' . $site_info["company_name"] . ', ' . $site_info["company_address"] . '
                    </p>
                </div>';
        return $mailBodyHeaderDetails;
    }

    public function getFooterDetails($site_info)
    {
        $company_name = $site_info['company_name'];
        $company_mail = $site_info['email'];
        $company_phone = $site_info['phone'];
        $mailBodyFooterDetails = '<br><br>
                <div class="footer" style="text-align:center;padding: 13px 0px 13px 0px;background: #0A0A0A;color:white;border-top:1px solid #ed0000;  font-size:13px;">
                    Please do not reply to this email. This mailbox is not monitored and you will not receive a response. For all other    questions please contact our member support department by email <a href="mailto:' . $company_mail . '">' . $company_mail . '</a    >     or by phone at ' . $company_phone . '.</br>

                </div>

            </div>
        </body>
        </html>';

        return $mailBodyFooterDetails;
    }

    public function getRegisterationMailDetails($mailDetails, $regr)
    {
        $date = date('Y M d');
        $username = $regr['username'];
        $user_id = $regr['userid'];
        $site_url = $this->BASE_URL . "../";
        $table_prefix = substr($this->db->dbprefix, 0, 4);
        $MODULE_STATUS = $this->trackModule();
        $mailBodyDetails = '<div class="table_inner" style="width:600px;border:1px solid #eaeaea;margin-left:auto;margin-right:auto;">
        <div class="table_top_head" style="height:28px;background:#dc3c30;text-align:center;color:white;padding: 6px 0px 0px 0px;text-transform:uppercase;font-size:15px;">
            LOGIN DETAILS
        </div>
        <div class="table_icon" style="height:40px;padding-top: 22px;text-align:center;color:#fff;padding: 15px 0px 0px 0px;font-size: 20px;background:#f54337;">' . $username . '</div>
        <table style="width: 100%;padding-left: auto; padding-right: auto;">
            <tr style="background:#f8f8f8; height:31px; font-size: 15px;font-weight: 300;padding: 8px 0px 0px 0px;border-bottom:1px solid #eaeaea;">
                <td style="font-family: roboto !important; text-align: right;padding-right: 10px;width:50%;">Username</td>
                <td style="font-family: roboto !important; text-align: left;padding-left: 10px;width:50%;">' . $username . '</td>
            </tr>
            <tr style="background:#fff; height:31px;font-size: 15px;font-weight: 300;padding: 8px 0px 0px 0px;border-bottom:1px solid #eaeaea;">
                <td style="font-family: roboto !important; text-align: right;padding-right: 10px;">Password</td>
                <td style="font-family: roboto !important; text-align: left;padding-left: 10px;">' . $regr["pswd"] . '</td>
            </tr>
            <tr style="background:#fff; height:31px;font-size: 15px;font-weight: 300;padding: 8px 0px 0px 0px;border-bottom:1px solid #eaeaea;">
                <td style="font-family: roboto !important; text-align: right;padding-right: 10px;">Transaction Password</td>
                <td style="font-family: roboto !important; text-align: left;padding-left: 10px;">' . $regr["tran_password"] . '</td>
            </tr>
            <tr style="background:#f8f8f8; height:31px; font-size: 15px;font-weight: 300;padding: 8px 0px 0px 0px;border-bottom:1px solid #eaeaea;">
                <td style="font-family: roboto !important; text-align: right;padding-right: 10px;width:50%;">For Login</td>
                <td style="font-family: roboto !important; text-align: left;padding-left: 10px;width:50%;">
                    <a style="text-decoration:none; color: #F7763D; text-decoration: underline;" href="' . $this->PUBLIC_VARS['USER_URL'] . '/login/index/user/' . $this->ADMIN_USER_NAME . '/' . $username . '" target="_blank">Click Here</a>
                </td>
            </tr>';
        if ($MODULE_STATUS["replicated_site_status"] == 'yes' && $MODULE_STATUS["replicated_site_status_demo"] == 'yes')
            $mailBodyDetails .= '
            <tr style="background:#fff; height:31px;font-size: 15px;font-weight: 300;padding: 8px 0px 0px 0px;border-bottom:1px solid #eaeaea;">
                <td style="font-family: roboto !important; text-align: right;padding-right: 10px;width:50%;">For Replicated Website Link</td>
                <td style="text-align: left;padding-left: 10px;width:50%;">
                    <a style="font-family: roboto !important; text-decoration:none; color: #F7763D; text-decoration: underline;" href="' . $site_url . 'replica/' . $username . '" target="_blank">Click Here
                    </a>
                </td>
            </tr>';

        if ($MODULE_STATUS["lead_capture_status"] == "yes" && $MODULE_STATUS["lead_capture_status_demo"] == "yes") {
            $mailBodyDetails .= '
                <tr style="background:#f8f8f8; height:31px;font-size: 15px;font-weight: 300;padding: 8px 0px 0px 0px;border-bottom:1px solid #eaeaea;">
                    <td style="font-family: roboto !important; text-align: right;padding-right: 10px;">For LCP Link</td>
                    <td style="font-family: roboto !important;text-align:left;padding-left: 10px;">
                     <a style="text-decoration:none; color: #F7763D; text-decoration: underline;" href="' . $site_url . 'LCP/home?prefix=' . $table_prefix . '&id=' . $user_id . '" target="_blank">Click Here</a>
                 </td>
             </tr>';
        }
        if (ANDROID_APP_STATUS == "yes") {
            $mailBodyDetails .= '
            <tr style="background:#fff; height:31px; font-size: 15px;font-weight: 300;padding: 8px 0px 0px 0px;border-bottom:1px solid #eaeaea;">
                <td style="font-family: roboto !important; text-align:right;padding-right: 10px;width:50%;">For APP Download Link</td>
                <td style="font-family: roboto !important; text-align: left;padding-left: 10px;width:50%;">
                    <a style="text-decoration:none; color: #F7763D; text-decoration: underline;" href="https://play.google.com/store/apps/details?id=com.ioss.infinite" target="_blank">Click Here</a>
                    -- * <font color="red">Not included in Basic Software</font>
                </td>
            </tr>';
        }
        $mailBodyDetails .= '
    </table>
</div>';
        $mailBodyDetails = $mailDetails . $mailBodyDetails;
        return $mailBodyDetails;
    }

    public function checkMailStatus($type)
    {
        $mail_status = 'no';
        $this->db->select('mail_status');
        $this->db->from('common_mail_settings');
        $this->db->where('mail_type', $type);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $mail_status = $row->mail_status;
        }
        return $mail_status;
    }

    public function getPasswordDetails($mailDetails, $regr)
    {
        $mailBodyDetails = '<div class="banner" style="background: url({banner_img});
    height: 58px;
    color: #fff;
    font-size: 21px;
    padding: 43px 20px 20px 40px;">
    Password changed successfully!!!
</div>
<div class="body_text" style="padding:25px 65px 25px 45px; color:#333333;">
    <h1 style="font-size:18px; color:#333333; font-weight: normal; font-weight: 300;">Dear <span style="font-weight:bold;">' . $regr["full_name"] . ',</span></h1>
    <p style="font-size: 14px; line-height: 27px;">&emsp; &emsp; ' . $mailDetails . ' ' . $regr["new_password"] . '</p>
</div>';
        return $mailBodyDetails;
    }

    public function getTransactionPasswordDetails($content, $regr)
    {

        $mailBodyDetails = '<div class="banner" style="background: url({banner_img});
    height: 58px;
    color: #fff;
    font-size: 21px;
    padding: 43px 20px 20px 40px;">
    Transaction password changed successfully!!!
</div>
<div class="body_text" style="padding:25px 65px 25px 45px; color:#333333;">
    <h1 style="font-size:18px; color:#333333; font-weight: normal; font-weight: 300;">Dear <span style="font-weight:bold;">' . $regr["first_name"] . ',</span></h1>
    <p style="font-size: 14px; line-height: 27px;">&emsp; &emsp; ' . $content . ' ' . $regr["tranpass"] . '</p>
</div>';
        return $mailBodyDetails;
    }

    public function getPayoutRequestDetails($details)
    {
        $mailBodyDetails = '<div class="banner" style="background: url({banner_img});
    height: 58px;
    color: #fff;
    font-size: 21px;
    padding: 43px 20px 20px 40px;">
    User requested payout
</div>
<div class="body_text" style="padding:25px 65px 25px 45px; color:#333333;">
    <h1 style="font-size:18px; color:#333333; font-weight: normal; font-weight: 300;">Dear <span style="font-weight:bold;">' . $this->ADMIN_USER_NAME . ',</span></h1>
    <p style="font-size: 14px; line-height: 27px;">&emsp; &emsp;' . $details['username'] . ' requested payout of ' . $details['payout_amount'] . '</p>
</div>';
        return $mailBodyDetails;
    }

    public function getLCPMailBody($details)
    {
        $mailBodyDetails = '<div class="banner" style="background: url({banner_img});
    height: 58px;
    color: #fff;
    font-size: 21px;
    padding: 43px 20px 20px 40px;">
    Your Lead Capture is updated
</div>
<div class="body_text" style="padding:25px 65px 25px 45px; color:#333333;">
<h1 style="font-size:18px; color:#333333; font-weight: normal; font-weight: 300;">Dear <span style="font-weight:bold;">' . $details['first_name'] . " " . $details['last_name'] . ',</span></h1>';
        if (isset($details['admin_comment']) && ($details['admin_comment'] != "")) {

            $mailBodyDetails .= '<p style="font-size: 14px; line-height: 27px;">&emsp; &emsp; The user ' . $this->LOG_USER_NAME . ' commented as ' . $details['admin_comment'] . ',</p>';
        }
        if ($details['new_status'] == $details['lead_status']) {

            $mailBodyDetails .= '<p style="font-size: 14px; line-height: 27px;">&emsp; &emsp; Your Leads Status updated to ' . $details['new_status'] . '....</p>';
        }

        $mailBodyDetails .= '
    </div>';
        return $mailBodyDetails;
    }
    public function getMailDetails($id, $type, $thread = "")
    {
        if ($type == 'admin') {
            $result = array();
            $arr = array();
            $this->db->select('*');
            $this->db->from('mailtoadmin');
        //$this->db->where('mailadid', $id);
            if ($thread != '') {
                $this->db->where('thread', $thread);
            }
            $query = $this->db->get();
            $i = 0;
            foreach ($query->result_array() as $row) {
                $arr[$i]["id"] = $row["mailadid"];
                $arr[$i]["to_user"] = "admin";
                $arr[$i]["subject"] = $row["mailadsubject"];
                $arr[$i]["message"] = $row["mailadidmsg"];
                $arr[$i]["date"] = $row["mailadiddate"];
                $arr[$i]["status"] = $row["status"];
                $arr[$i]["from"] = $row["mailaduser"];
                $arr[$i]['user_name'] = $this->validation_model->idToUserName($row['mailaduser']);
                $arr[$i]["read_msg"] = $row["read_msg"];
                $arr[$i]["delete_status"] = $row["deleted_by"];
                $arr[$i]["thread"] = $row["thread"];

                $i++;
            }
            $this->db->select('*');
            $this->db->from('mailtouser');
            $this->db->where('thread', $thread);
            $query = $this->db->get();
            foreach ($query->result_array() as $row) {
                $arr[$i]["id"] = $row["mailtousid"];
                $arr[$i]["to_user"] = $row["mailtoususer"];
                $arr[$i]['user_name'] = $this->validation_model->idToUserName($row['mailfromuser']);
                $arr[$i]["subject"] = $row["mailtoussub"];
                $arr[$i]["message"] = $row["mailtousmsg"];
                $arr[$i]["date"] = $row["mailtousdate"];
                $arr[$i]["status"] = $row["status"];
                $arr[$i]["from"] = $row["mailfromuser"];
                $arr[$i]["read_msg"] = $row["read_msg"];
                $arr[$i]["delete_status"] = $row["deleted_by"];
                $arr[$i]["thread"] = $row["thread"];

                $i++;
            }
            function cmp($a, $b)
            {
                $a["date"] = strtotime($a["date"]);
                $b["date"] = strtotime($b["date"]);
                return ($a["date"] < $b["date"]) ? -1 : 1;
            }

            usort($arr, "cmp");
            return $arr;
        } else {
            $result = array();
            $this->db->select('*');
            $this->db->from('contacts');
            $this->db->where('id', $id);
            $query = $this->db->get();
            foreach ($query->result_array() as $row) {
                $result = $row;
            }
            return $result;

        }

    }
    public function updateContactMsgStatus($msg_id)
    {
        $data = array(
            'read_msg' => 'yes'
        );
        $this->db->where('id', $msg_id);
        $res = $this->db->update('contacts', $data);
        return $res;
    }
    public function getSentMailDetails($msg_id)
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('mailtouser');
        $this->db->where('thread', $msg_id);
        $this->db->where('status', 'yes');
      //  $where = array('status' => 'no', 'deleted_by != ' => $this->LOG_USER_ID, 'deleted_by !=' => 'both');
      $where = array('deleted_by != ' => $this->LOG_USER_ID, 'deleted_by !=' => 'both');
       // $this->db->or_group_start()
            $this->db->where($where);
        //    ->group_end();
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $row['type'] = "individual";
            $row['to'] = $this->validation_model->idToUserName($row['mailtoususer']);
            $result[] = $row;
        }
        return $result;
    }
    public function getSentMailDetailsExt($msg_id)
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('mailtouser_cumulativ');
        $this->db->where('mailtousid', $msg_id);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $row['type'] = "individual";
            $row['to'] = $row['mailtoususer'];
            $result[] = $row;
        }
        return $result;
    }
    public function getUserMailDetails($id, $type, $thread = '')
    {
        if ($type == 'user') {
            $result = array();
            $arr = array();
            $this->db->select('*');
            $this->db->from('mailtouser');
        //$this->db->join('mailtoadmin AS ma', 'mu.thread = ma.thread');
        //$this->db->where('mailtousid', $id);
            $this->db->where('thread', $thread);
            $query = $this->db->get();
//        foreach ($query->result() as $row) {
//            $result = $row;
//        }
            $i = 0;
            foreach ($query->result_array() as $row) {
                $arr[$i]["id"] = $row["mailtousid"];
                $arr[$i]["to_user"] = $row["mailtoususer"];
                $arr[$i]['user_name'] = $this->validation_model->idToUserName($row['mailfromuser']);
                $arr[$i]["subject"] = $row["mailtoussub"];
                $arr[$i]["message"] = $row["mailtousmsg"];
                $arr[$i]["date"] = $row["mailtousdate"];
                $arr[$i]["status"] = $row["status"];
                $arr[$i]["from"] = $row["mailfromuser"];
                $arr[$i]["read_msg"] = $row["read_msg"];
                $arr[$i]["delete_status"] = $row["deleted_by"];
                $arr[$i]["thread"] = $row["thread"];

                $i++;
            }
            $this->db->select('*');
            $this->db->from('mailtoadmin');
            $this->db->where('thread', $thread);
            $query = $this->db->get();
            foreach ($query->result_array() as $row) {
                $arr[$i]["id"] = $row["mailadid"];
                $arr[$i]["to_user"] = "admin";
                $arr[$i]["subject"] = $row["mailadsubject"];
                $arr[$i]["message"] = $row["mailadidmsg"];
                $arr[$i]["date"] = $row["mailadiddate"];
                $arr[$i]["status"] = $row["status"];
                $arr[$i]["from"] = $row["mailaduser"];
                $arr[$i]['user_name'] = $this->validation_model->idToUserName($row['mailaduser']);
                $arr[$i]["read_msg"] = $row["read_msg"];
                $arr[$i]["delete_status"] = $row["deleted_by"];
                $arr[$i]["thread"] = $row["thread"];

                $i++;
            }
            function cmp($a, $b)
            {
                $a["date"] = strtotime($a["date"]);
                $b["date"] = strtotime($b["date"]);
                return ($a["date"] < $b["date"]) ? -1 : 1;
            }

            usort($arr, "cmp");
            return $arr;
        } else {
            $result = array();
            $this->db->select('*');
            $this->db->from('contacts');
            $this->db->where('id', $id);
            $query = $this->db->get();
            foreach ($query->result_array() as $row) {
                $result = $row;
            }
            return $result;

        }
    }
    public function getUserSentMailDetails($msg_id, $type, $user_id = '')
    {
        if ($type == 'to_admin') {
            $result = array();
            $this->db->select('*');
            $this->db->from('mailtoadmin');
            $this->db->where('thread', $msg_id);
            $this->db->where('status', 'yes');
            $where = array('status' => 'no', 'deleted_by != ' => $this->LOG_USER_ID, 'deleted_by !=' => 'both');
            $this->db->or_group_start()
                ->where($where)
                ->group_end();
            $query = $this->db->get();
            foreach ($query->result_array() as $row) {
                $row['to'] = $this->validation_model->getAdminUsername();
                $result[] = $row;
            }
            return $result;
        } else if ($type == 'ext_mail_user') {
            $result = array();
            $this->db->select('*');
            $this->db->from('mailtouser_cumulativ');
            $this->db->where('mailtousid', $msg_id);
            $query = $this->db->get();
            foreach ($query->result_array() as $row) {
                $row['to'] = $row['mailtoususer'];
                $result[] = $row;
            }
            return $result;
        } else {
            $result = array();
            $this->db->select('*');
            $this->db->from('mailtouser');
            $this->db->where('thread', $msg_id);
            if ($user_id != '')
                $this->db->where('mailfromuser', $user_id);
            $this->db->where('status', 'yes');
            $where = array('status' => 'no', 'deleted_by != ' => $this->LOG_USER_ID, 'deleted_by !=' => 'both');
            $this->db->or_group_start()
                ->where($where)
                ->group_end();
            $query = $this->db->get();
            foreach ($query->result_array() as $row) {
                $row['to'] = $this->validation_model->idToUserName($row['mailtoususer']);
                $result[] = $row;
            }
            return $result;

        }
    }
    public function selectMaxThreadNumber()
    {
        $max_id = 0;
        $this->db->select('MAX(thread) as number');
        $query = $this->db->get('mailtoadmin');

        foreach ($query->result_array() as $row) {

            $max_id = $row['number'];
        }
        $user_thread = $this->selectMaxThreadNumberUser();
        if ($user_thread >= $max_id) {
            $max_id = $user_thread;
        }

        return $max_id;
    }
    public function selectMaxThreadNumberUser()
    {
        $max_id = 0;
        $this->db->select('MAX(thread) as number');
        $query = $this->db->get('mailtouser');

        foreach ($query->result_array() as $row) {

            $max_id = $row['number'];
        }
        return $max_id;
    }
    public function getExtMail($regr)
    {

        $mailBodyDetails = '<div class="banner" style="background: url({banner_img});
    height: 58px;
    color: #fff;
    font-size: 21px;
    padding: 43px 20px 20px 40px;">
</div>
<div class="body_text" style="padding:25px 65px 25px 45px;">
    <h1 style="font-size:18px; color:#333333; font-weight: normal; font-weight: 300;">Subject: <span style="font-weight:bold;">' . $regr['subject'] . '</span></h1>

<table border="0" width="800" align="center">
<tr>
<td    colspan="4"valign="top" >
<br>
<font size="3" face="Trebuchet MS">
<p syte="pading-left:20px;"><b>Message,</b></p>
     <p syte="pading-left:40px;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $regr['content'] . '.</p>
  <br>
  </td>
</tr>
</font>
</table>
</div>';
        return $mailBodyDetails;
    }
    public function sendSingleEmail($details, $user_id, $mail_subject, $attachments = array())
    {

        $regr = $this->getUserEmailDetails($user_id);
        $mailBodyDetails = $this->getDonationMailDetails($details);
        $this->load->library('Inf_PHPMailer');
        $mail = new Inf_PHPMailer();

        $site_info = $this->validation_model->getSiteInformation();
        $common_mail_settings = $this->configuration_model->getMailDetails();

        //$mail_type = $common_mail_settings['reg_mail_type']; //normal/smtp
        $mail_type = 'normal'; //normal/smtp
        $smtp_data = array();
        if ($mail_type == "smtp") {
            $smtp_data = array(
                "SMTPAuth" => $common_mail_settings['smtp_authentication'],
                "SMTPSecure" => ($common_mail_settings['smtp_protocol'] == "none") ? "" : $common_mail_settings['smtp_protocol'],
                "Host" => $common_mail_settings['smtp_host'],
                "Port" => $common_mail_settings['smtp_port'],
                "Username" => $common_mail_settings['smtp_username'],
                "Password" => $common_mail_settings['smtp_password'],
                "Timeout" => $common_mail_settings['smtp_timeout'],
                    //"SMTPDebug" => 3 //uncomment this line to check for any errors
            );
        }
        $mail_to = array("email" => $regr['email'], "name" => $regr['first_name'] . " " . $regr['last_name']);
        $mail_from = array("email" => $site_info['email'], "name" => $site_info['company_name']);
        $mail_reply_to = $mail_from;

        $mailBodyHeaderDetails = $this->getHeaderDetails($site_info);

        $mail_altbody = $mail_subject;

        $mailBodyFooterDetails = $this->getFooterDetails($site_info);

        $mail_body = $mailBodyHeaderDetails . $mailBodyDetails . $mailBodyFooterDetails . "</br></br></br></br></br>";

        $send_mail = $mail->send_mail($mail_from, $mail_to, $mail_reply_to, $mail_subject, $mail_body, $mail_altbody, $mail_type, $smtp_data, $attachments);

        if (!$send_mail['status']) {
            $data["message"] = "Error: " . $send_mail['ErrorInfo'];
        } else {
            $data["message"] = "Message sent correctly!";
        }

        return $send_mail;
    }

    public function sendSingleEmailMissed($details, $user_id, $mail_subject, $attachments = array())
    {

        $regr = $this->getUserEmailDetails($user_id);
        $mailBodyDetails = $details;
        $this->load->library('Inf_PHPMailer');
        $mail = new Inf_PHPMailer();

        $site_info = $this->validation_model->getSiteInformation();
        $common_mail_settings = $this->configuration_model->getMailDetails();

        //$mail_type = $common_mail_settings['reg_mail_type']; //normal/smtp
        $mail_type = 'normal'; //normal/smtp
        $smtp_data = array();
        if ($mail_type == "smtp") {
            $smtp_data = array(
                "SMTPAuth" => $common_mail_settings['smtp_authentication'],
                "SMTPSecure" => ($common_mail_settings['smtp_protocol'] == "none") ? "" : $common_mail_settings['smtp_protocol'],
                "Host" => $common_mail_settings['smtp_host'],
                "Port" => $common_mail_settings['smtp_port'],
                "Username" => $common_mail_settings['smtp_username'],
                "Password" => $common_mail_settings['smtp_password'],
                "Timeout" => $common_mail_settings['smtp_timeout'],
                    //"SMTPDebug" => 3 //uncomment this line to check for any errors
            );
        }
        $mail_to = array("email" => $regr['email'], "name" => $regr['first_name'] . " " . $regr['last_name']);
        $mail_from = array("email" => $site_info['email'], "name" => $site_info['company_name']);
        $mail_reply_to = $mail_from;

        $mailBodyHeaderDetails = $this->getHeaderDetails($site_info);

        $mail_altbody = $mail_subject;

        $mailBodyFooterDetails = $this->getFooterDetails($site_info);

        $mail_body = $mailBodyHeaderDetails . $mailBodyDetails . $mailBodyFooterDetails . "</br></br></br></br></br>";

        $send_mail = $mail->send_mail($mail_from, $mail_to, $mail_reply_to, $mail_subject, $mail_body, $mail_altbody, $mail_type, $smtp_data, $attachments);

        if (!$send_mail['status']) {
            $data["message"] = "Error: " . $send_mail['ErrorInfo'];
        } else {
            $data["message"] = "Message sent correctly!";
        }

        return $send_mail;
    }

    public function getDonationMailDetails($regr)
    {

        $mailBodyDetails = "<div class='banner' style='background: url({banner_img});
height: 58px;
color: #000000;
font-size: 21px;
padding: 43px 20px 20px 40px;'>
<strong>Congratulations!!!You are now eligible to upgrade to the next level!</strong>
</div>
<div class='body_text' style='padding: 25px 65px 25px 45px;'><strong>Hello " . $regr['user_name'] . "!</strong><br><br><br>A donation you submitted has been approved!<br>----
<br><br><br><table style='color: #222222; font-family: arial, sans-serif; font-size: 12.8px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: normal; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;'>
<tbody>
<tr>
<td style='font-family: arial, sans-serif; margin: 0px;'>Submitted:</td>
<td style='font-family: arial, sans-serif; margin: 0px;'>" . $regr['submitted_date'] . "</td>
</tr>
<tr>
<td style='font-family: arial, sans-serif; margin: 0px;'>Approved:</td>
<td style='font-family: arial, sans-serif; margin: 0px;'>" . $regr['approved_date'] . "</td>
</tr>
<tr>
<td style='font-family: arial, sans-serif; margin: 0px;'>Donation payment method:</td>
<td style='font-family: arial, sans-serif; margin: 0px;'>" . $regr['payment_method'] . "</td>
</tr>
<tr>
<td style='font-family: arial, sans-serif; margin: 0px;'>Transaction ID:</td>
<td style='font-family: arial, sans-serif; margin: 0px;'>" . $regr['trasaction_id'] . "</td>
</tr>
<tr>
<td style='font-family: arial, sans-serif; margin: 0px;'>Description:</td>
<td style='font-family: arial, sans-serif; margin: 0px;'>Level " . $regr['level'] . "</td>
</tr>
<tr>
<td style='font-family: arial, sans-serif; margin: 0px;'>Amount:</td>
<td style='font-family: arial, sans-serif; margin: 0px;'>Ƀ" . $regr['amount'] . "</td>
</tr>
</tbody>
</table><br><br><br>
--- <br><br>Congratulations! You are now eligible to upgrade to the next level. Thank you for your continued support. <br><br><br><br>The STREAMSPLUS Team</div>";

        return $mailBodyDetails;
    }
    public function getUserEmailDetails($user_id)
    {
        $email_details = array();
        $this->db->select("user_detail_email,user_detail_name,user_detail_second_name");
        $this->db->from("user_details");
        $this->db->where("user_detail_refid", $user_id);
        $this->db->limit(1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $email_details['email'] = $row->user_detail_email;
            $email_details['first_name'] = $row->user_detail_name;
            $email_details['last_name'] = $row->user_detail_second_name;
        }
        return $email_details;
    }
    public function sendOtpMail($otp, $email, $type = "")
    {
        $site_info = $this->validation_model->getSiteInformation();
        $subject = $type . " authentication OTP";
        $dt = date('Y-m-d h:i:s');

        $mailBodyDetails = "<html>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
        </head>
        <body >
            <table id='Table_01' width='600'   border='0' cellpadding='0' cellspacing='0'>
             <tr><td COLSPAN='3'></td></tr>

             <td width='50px'></td>
             <td   width='520px'  > <br>
              <p>
               <table border='0' cellpadding='0' width='60%' >
                   <tr>
                    <td colspan='2' align='center'><b>Your authentication OTP is : " . $otp . "</b></td>
                </tr>
                <tr>
                    <td colspan='2'>Thanking you,</td>
                </tr>

                <tr>
                    <td colspan='2'><p align='left'>" . $site_info['company_name'] . "<br />Date:" . $dt . "<br /></p></td>
                </tr>
            </table>
            <tr>
               <td COLSPAN='3'>
               </td>
           </tr>
       </table>
   </body>
   </html>";

        if ($this->validation_model->getModuleStatusByKey('mail_gun_status') == 'yes') {
            $this->load->model('mail_gun_model');
            return $this->mail_gun_model->sendEmail($mailBodyDetails, $email, $subject);
        } else {
            return $this->sendEmail($mailBodyDetails, $email, $subject);
        }
    }

    public function getCountUserMessagesSent($user_id) {

        $this->db->from('mailtoadmin');
        $where1 = array('status' => 'yes', 'mailaduser' => $user_id);
        $where2 = array('status' => 'no', 'deleted_by != ' => $user_id, 'mailaduser' => $user_id, 'deleted_by !=' => 'both');
        $this->db->group_start()
            ->where($where1)
            ->or_group_start()
            ->where($where2)
            ->group_end()
            ->group_end();
        $this->db->group_by('thread');
        $count1 = $this->db->count_all_results();

        $this->db->from('mailtouser');
        $where3 = array('status' => 'yes', 'mailfromuser' => $user_id);
        $where4 = array('status' => 'no', 'deleted_by != ' => $user_id, 'mailfromuser' => $user_id, 'deleted_by !=' => 'both');
        $this->db->group_start()
            ->where($where3)
            ->or_group_start()
            ->where($where4)
            ->group_end()
            ->group_end();
        $this->db->group_by('thread');
        $count2 = $this->db->count_all_results();

        $this->db->from('mailtouser_cumulativ');
        $this->db->where('type', 'ext_mail_user');
        $this->db->where('status', 'yes');
        $count3 = $this->db->count_all_results();

        return ($count1+$count2+$count3);
    }

}
