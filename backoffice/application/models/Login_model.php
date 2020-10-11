<?php

Class login_model extends inf_model {

    public function __construct() {
        parent::__construct();
    }

    public function login($username, $password) {

        if ($username && $password) {
            $password = base64_decode(urldecode($password));
            $this->db->select('id, user_name, password,user_type');
            $this->db->from('ft_individual');
            $this->db->where('user_name', $username);
	        $this->db->where('user_type', 'user');
            $this->db->where('active', "yes");
            $this->db->limit(1);
            $query = $this->db->get();
        } else {
            return false;
        }
        $flag = $this->validation_model->verifyBcrypt($query, $password);
        if ($flag) {
            $login_id = $this->validation_model->userNameToID($username);
                if($login_id == 0){
                    $login_id = $this->validation_model->employeeNameToID($username);
                }
                $user_type = $this->validation_model->getUserType($login_id);                            
                $this->validation_model->insertUserActivity($login_id, 'login', $login_id, $data = '', $user_type);
           
                if($user_type == "employee"){
                $login_id = $this->validation_model->employeeNameToID($username);                
                    $this->validation_model->insertEmployeeActivity($login_id, $login_id, 'login', 'logged in');
                }
            return $query->result();
        } else {
            return false;
        }
    }

    public function setUserSessionDatas($login_result) {
        $sess_array = array();
        $table_prefix = $this->db->dbprefix;
        $admin_username = $this->validation_model->getAdminUsername();
        $admin_userid = $this->validation_model->userNameToID($admin_username);
        foreach ($login_result as $row) {
            $sess_array = array(
                'user_id' => $row->id,
                'user_name' => $row->user_name,
                'user_type' => $row->user_type,
                'admin_user_name' => $admin_username,
                'admin_user_id' => $admin_userid,
                'table_prefix' => $table_prefix,
                'is_logged_in' => true
            );
        }

        $this->inf_model->trackModule();
        $sess_array['mlm_plan'] = $this->inf_model->MODULE_STATUS['mlm_plan'];
        $this->session->set_userdata('inf_logged_in', $sess_array);
    }

    public function isValidEmployee($user_name) {
        $flag = FALSE;

        $this->db->where('user_name', $user_name);
        $this->db->where('emp_status !=', 'terminated');
        $this->db->from('login_employee');
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $flag = TRUE;
        }
        return $flag;
    }

    public function login_employee($username, $password) {

        $username = ($username);
        $password = ($password);

        $this->db->select('*');
        $this->db->from('login_employee');
        $this->db->where('user_name', $username);
        $this->db->where('addedby', "code");
        $this->db->where('emp_status', "yes");
        $this->db->limit(1);
        $query = $this->db->get();

        $flag = $this->validation_model->verifyBcrypt($query, $password);

        if ($flag) {
            $login_id = $this->validation_model->userNameToID($username);
            $user_type = $this->validation_model->getUserType($login_id);
            $this->validation_model->insertUserActivity($login_id, 'login', $login_id, $data = '', $user_type);
            return $query->result();
        } else {
            return false;
        }
    }

    public function setUserSessionDatasEmployee($login_result) {

        $sess_array = array();
        $module_status = "";
        $admin_username = $this->validation_model->getAdminUsername();
        $admin_userid = $this->validation_model->userNameToID($admin_username);
        foreach ($login_result as $row) {
            $sess_array = array(
                'user_id' => $row->user_id,
                'user_name' => $row->user_name,
                'user_type' => $row->user_type,
                'admin_user_name' => $admin_username,
                'admin_user_id' => $admin_userid,
                'table_prefix' => $this->db->dbprefix,
                'is_logged_in' => true
            );
            $module_status = $row->module_status;
        }
        $this->session->set_userdata('inf_module_status', $module_status);

        $this->inf_model->trackModule();
        $sess_array['mlm_plan'] = $this->inf_model->MODULE_STATUS['mlm_plan'];
        $this->session->set_userdata('inf_logged_in', $sess_array);
    }

    public function isUsernameValid($user_name) {
        $this->db->select('id');
        $this->db->from('ft_individual');
        $this->db->where('user_name', $user_name);
	$this->db->where('user_type', 'user');
        $count = $this->db->count_all_results();
        $flag = ($count > 0);
        return $flag;
    }

    public function getUserId($user_name, $table_prefix) {
        $dbprefix = $this->db->dbprefix;
        $this->db->set_dbprefix($table_prefix . '_');
        $id = '';        
        $this->db->select('id');
        $this->db->from('ft_individual');
        $this->db->where('user_name', $user_name);
        $query = $this->db->get();
        $this->db->set_dbprefix($dbprefix);
        foreach ($query->result() as $row) {
            $id = $row->id;
        }
        return $id;
    }

    public function getUserPhoto($table_prefix, $user_id) {
        $dbprefix = $this->db->dbprefix;
        $this->db->set_dbprefix($table_prefix . '_');
        $file_name = NULL;
        $this->db->select('user_photo');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $query = $this->db->get();
        $this->db->set_dbprefix($dbprefix);

        foreach ($query->result() as $row) {
            $file_name = $row->user_photo;
            if (!file_exists(IMG_DIR.'profile_picture/' . $file_name)) {
                $file_name = 'nophoto.jpg';
            }
        }
        return $file_name;
    }
    
    public function getKeyWord($user_id) {
        $row = NULL;

        do {
            $keyword = rand(1000000000, 9999999999);
        } while ($this->keywordAvailable($keyword));

        $this->db->set('keyword', $keyword);
        $this->db->set('user_id', $user_id);
        $result = $this->db->insert("password_reset_table");

        if ($result) {
            return $keyword;
        }
    }

    public function keywordAvailable($keyword) {
        $flag = FALSE;
        $this->db->select('COUNT(*) AS count');
        $this->db->from('password_reset_table');
        $this->db->where('keyword', $keyword);
        $this->db->where('reset_status', 'no');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $cnt = $row['count'];
            if ($cnt > 0) {
                $flag = TRUE;
            }
            return $flag;
        }
    }

}
