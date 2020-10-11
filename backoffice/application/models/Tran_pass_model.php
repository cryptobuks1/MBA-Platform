<?php

class tran_pass_model extends inf_model
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('validation_model');
    }

    public function getUserPasscode($user_id)
    {
        $tran_password = '';
        $this->db->select('tran_password');
        $this->db->where('user_id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get('tran_password');

        foreach ($query->result_array() as $rows) {
            $tran_password = $rows['tran_password'];
        }
        return $tran_password;
    }

    public function sentTransactionPasscode($user_id, $passcode, $user_name)
    {
        $type = "send_tranpass";
        $email = $this->validation_model->getUserData($user_id, "user_detail_email");
        $first_name = $this->validation_model->getUserData($user_id, "user_detail_name");
        $last_name = $this->validation_model->getUserData($user_id, "user_detail_name");
        $send_details = array("email" => $email, "tranpass" => $passcode, "first_name" => $first_name, "last_name" => $last_name);
        $mail_gun_stat = $this->validation_model->getModuleStatusByKey('mail_gun_status');
        $res = $this->mail_model->sendAllEmails($type, $send_details);
        return $res;
    }

    public function updatePasscode($user_id, $new, $old = '')
    {
        $new_hash = password_hash($new, PASSWORD_DEFAULT);
        if ($old != '') {
            // $old_hash = password_hash($old, PASSWORD_DEFAULT);
            $this->db->set('tran_password', $new_hash);
            $this->db->where('user_id', $user_id);
            // $this->db->where('tran_password', $old_hash);
            $query = $this->db->update('tran_password');
        } else {
            $this->db->set('tran_password', $new_hash);
            $this->db->where('user_id', $user_id);
            $query = $this->db->update('tran_password');
        }
        return $query;
    }
    public function sendEmail($user_id, $e_mail)
    {

        $send_details = array();
        $send_details['user_id'] = $user_id;
        $type = 'forgot_transaction_password';
        $send_details['full_name'] = $this->validation_model->getUserFullName($user_id);
        $send_details['email'] = $e_mail;
        $send_details['first_name'] = $this->validation_model->getUserData($user_id, "user_detail_name");
        $send_details['last_name'] = $this->validation_model->getUserData($user_id, "user_detail_second_name");
        $mail_gun_stat = $this->validation_model->getModuleStatusByKey('mail_gun_status');
        return $this->mail_model->sendAllEmails($type, $send_details);
    }
    public function getKeyWord($user_id)
    {
        $row = null;

        do {
            $keyword = rand(1000000000, 9999999999);
        } while ($this->keywordAvailable($keyword));

        $this->db->set('keyword', $keyword);
        $this->db->set('user_id', $user_id);
        $this->db->set('reset_status', 'no');
        $result = $this->db->insert("tran_password_reset_table");

        if ($result) {
            return $keyword;
        }
    }
    public function keywordAvailable($keyword)
    {
        $flag = false;
        $this->db->select('COUNT(*) AS count');
        $this->db->from('tran_password_reset_table');
        $this->db->where('keyword', $keyword);
        $this->db->where('reset_status', 'no');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $cnt = $row['count'];
            if ($cnt > 0) {
                $flag = true;
            }
            return $flag;
        }
    }

    public function updatePasswordOut($user_id, $pass_word, $key, $prefix)
    {
        $db_prefix_old = $this->db->dbprefix;
        $this->db->set_dbprefix('');
        $table = $prefix . '_tran_password_reset_table';
        $table1 = $prefix . '_tran_password';
        $encrypted_password = password_hash($pass_word, PASSWORD_DEFAULT);

        $this->db->select('keyword');
        $this->db->where('user_id', $user_id);
        $this->db->where('reset_status', 'no');
        $this->db->order_by('password_reset_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get($table);
        $db_key = $query->row_array()['keyword'];

        if ($db_key != $key) {
            return 0;
        }

        $this->db->set("tran_password", $encrypted_password);
        $this->db->where("user_id", $user_id);
        $result_1 = $this->db->update($table1);
        $this->db->set("reset_status", 'yes');
        $this->db->where("keyword", $key);
        $result_2 = $this->db->update($table);
        $this->db->set_dbprefix($db_prefix_old);
        if ($result_1 && $result_2) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getUserDetailFromKey($resetkey, $prefix)
    {
        $db_prefix_old = $this->db->dbprefix;
        $this->db->set_dbprefix('');
        $table = $prefix . '_tran_password_reset_table';
        $this->load->model('validation_model');
        $id = null;
        $this->db->select("user_id");
        $this->db->from($table);
        $this->db->where("keyword", $resetkey);
        $this->db->where("reset_status", "no");
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $id = $row->user_id;
        }
        if ($id != "") {
            $username = $this->validation_model->IdToUserNameWitoutLogin($id, $prefix);
            $arr[] = $id;
            $arr[] = $username;
            $this->db->set_dbprefix($db_prefix_old);
            return $arr;
        } else {

            $arr[] = "";
            $this->db->set_dbprefix($db_prefix_old);
            return $arr;
        }
    }
    public function getTablePrefix($admin_user_name)
    {
        if (DEMO_STATUS == 'no') {
            $prefix = str_replace('_', '', $this->db->dbprefix);
            return $prefix;
        }
        $prefix = '';
        $db_prefix_old = $this->db->dbprefix;
        $this->db->set_dbprefix('');
        $table = 'infinite_mlm_user_detail';
        $this->db->select('id');
        $this->db->where('user_name', $admin_user_name);
        $this->db->where('account_status !=', 'deleted');
        $this->db->limit(1);
        $query = $this->db->get($table);

        foreach ($query->result_array() as $rows) {
            $prefix = $rows['id'];
        }
        $this->db->set_dbprefix($db_prefix_old);
        return $prefix;
    }


}
