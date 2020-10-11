<?php

class password_model extends inf_model {

    public $mail;

    public function __construct() {
        parent::__construct();
        $this->load->model('validation_model');
    }

    public function isUserNameAvailable($user_name) {
        $res = $this->validation_model->isUserNameAvailable($user_name);
        return $res;
    }

    public function selectPassword($id) {
        $dbpassword = '';
        $this->db->select('password');
        $this->db->from('ft_individual');
        $this->db->where('id', $id);
        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            $dbpassword = $row['password'];
        }
        return $dbpassword;
    }

    public function updatePassword($new_pwd, $id = '', $user_type = '', $user_ref_id = '') {
        $this->db->set('password', $new_pwd);
        $this->db->where('id', $id);

        $res = $this->db->update('ft_individual');
        if ($user_type == 'admin' && DEMO_STATUS == 'yes') {
            $dbprefix = $this->db->dbprefix;
            $this->db->set_dbprefix('');

            $this->db->set('pswd', $new_pwd);
            $this->db->where('id', $user_ref_id);
            $this->db->update('infinite_mlm_user_detail');
            
            $this->db->set_dbprefix($dbprefix);
        }
        return $res;
    }

    function validatePswd($password) {
        if (!preg_match('/^[0-9a-zA-Z\s\r\n@!#\$\^%&*()+=\-\[\]\\\';,\.\/\{\}\|\":<>\?\_\`\~]+$/i', $password)) {

            return false;
        } else
            return true;
    }
    
    public function getUsersList($letters) {

        $this->db->select('id,user_name');
        $this->db->from("ft_individual");
        $this->db->where('active !=', 'terminated');
        $this->db->where('user_type !=', 'admin');
        $this->db->like('user_name', $letters, 'after');
        $this->db->order_by('id');
        $this->db->limit(500);
        $query = $this->db->get();
        $user_detail = "";
        foreach ($query->result() as $row) {
            $user_detail .= $row->id . "###" . $row->user_name . "|";
        }
        
        return $user_detail;
    }
    
    public function updateStorePassword($password, $customer_id) {
        $salt = $this->token(9);
        $query = $this->db->query("UPDATE " . $this->db->ocprefix . "customer SET salt = " . $this->db->escape($salt) . ", password = " . $this->db->escape(sha1($salt . sha1($salt . sha1($password)))) . " WHERE customer_id = '" . (int) $customer_id . "'");
       
        return $query;
    }
    
    function token($length = 32) {
        // Create random token
        $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	
	$max = strlen($string) - 1;
	$token = '';
	for ($i = 0; $i < $length; $i++) {
		$token .= $string[mt_rand(0, $max)];
	}
	return $token;
    }

}
