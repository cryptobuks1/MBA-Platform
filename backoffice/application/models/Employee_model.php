<?php

class employee_model extends inf_model {

    public function __construct() {
        
    }

    public function confirmRegistration($reg_arr) {
        $result = "";
        $reg_arr1['ref_username'] = $reg_arr['ref_username'];
        $reg_arr1['pswd'] = $reg_arr['pswd'];
        $user_id = $this->updateEmployeeLogin($reg_arr1);

        if ($user_id != "") {
            $reg_arr['user_id'] = $user_id;
            $result = $this->updateEmployeeDetails($reg_arr);
        }
        return $result;
    }

    public function updateEmployeeLogin($reg_arr1) {
        $user_id = 0;
        $user_id1 = 0;
        $user_name = $reg_arr1['ref_username'];        
        $password = password_hash($reg_arr1['pswd'], PASSWORD_DEFAULT);
        $this->db->select_max('user_id');
        $result = $this->db->get('login_employee');  
        foreach ($result->result() AS $row) {
            $user_id1 = $row->user_id;
        }
        $this->db->set('user_id', $user_id1+1);
        $this->db->set('user_name', $user_name);
        $this->db->set('password', $password);
        $this->db->set('user_type', "employee");
        $this->db->set('addedby', "code");
        $this->db->set('module_status', "m#24,m#1");
        $this->db->set('dashboard_menu', "ewallet,sales,payout,mail,replica,lcp,country_graph,joinings,to_do,top_earners,social_media,new_members,top_recruiters,active_deposit,matured_deposit");
        $query1 = $this->db->insert('login_employee');

        if ($query1) {
            $this->db->select("user_id");
            $this->db->where("user_name", $user_name);
            $this->db->where("emp_status", 'yes');
            $this->db->from("login_employee");
            $query2 = $this->db->get();

            foreach ($query2->result() as $row) {
                return $user_id = $row->user_id;
            }
        }
        return $user_id;
    }

    public function updateEmployeeDetails($reg_arr) {
        $first_name = $reg_arr['first_name'];
        $last_name = $reg_arr['last_name'];
        $mobile = $reg_arr['mobile'];
        $email = $reg_arr['email'];
        $user_id = $reg_arr['user_id'];

        $this->db->set("user_detail_refid", $user_id);
        $this->db->set("user_detail_name", $first_name);
        $this->db->set("user_detail_second_name", $last_name);
        $this->db->set("user_detail_mobile", $mobile);
        $this->db->set("user_detail_email", $email);
        $query = $this->db->insert("employee_details");
        return $query;
    }

    public function insertIntoUserPermission($arr_post) {
        $len = max(array_keys($arr_post));
        if (!in_array("m#24", $arr_post)) {
            $arr_post[$len+1] = "m#24,m#1";
        }
        if (in_array("10#4", $arr_post)) { //set permission for sub tab of system settings 
            $arr_post[$len+2] = "10#102";
            $arr_post[$len+3] = "10#5";
            $arr_post[$len+4] = "10#16";
            $arr_post[$len+5] = "10#7";
            $arr_post[$len+6] = "10#8";
            $arr_post[$len+7] = "10#111";
            $arr_post[$len+8] = "10#9";
            $arr_post[$len+9] = "10#75";
            $arr_post[$len+10] = "10#74";
        }
        $rr = array_keys($arr_post);
        $module_permission = "";
        $user_name = $arr_post['user'];
        $cnt = count($arr_post);
        for ($i = 0; $i < $cnt; $i++) {
            if ($rr[$i] != "user" AND $rr[$i] != "permission") {
                $module_permission.= $arr_post[$rr[$i]] . ",";
            }
        }
        $module_permission = substr($module_permission, 0, strlen($module_permission) - 1);
        $this->db->set('module_status', $module_permission);
        $this->db->where('user_name', $user_name);
        $query = $this->db->update("login_employee");
        return $query;
    }

    public function viewPermission($user) {
        $permission = "";
        $this->db->select('module_status');
        $this->db->from("login_employee");
        $this->db->where('user_name', $user);
        $this->db->or_where('user_id', $user);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $permission = $row->module_status;
        }
        return $permission;
    }

    public function getEmployeeMenuId() {
        $this->db->select('id');
        $this->db->where('perm_emp', 1);
        $this->db->where('status', 'yes');
        $this->db->order_by("main_order_id");
        $this->db->from("infinite_mlm_menu");
        $query = $this->db->get();
        return $query;
    }

    public function getMenuTextId($menu_id) {
        $link = "";
        $this->db->select("IFNULL(link_ref_id, '#') link_ref_id");
        $this->db->where('id', $menu_id);
        $this->db->from("infinite_mlm_menu");
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $link = $row->link_ref_id;
        }
        return $link;
    }

    public function getEmployeeSubMenuId($id) {

        $this->db->select('sub_id,sub_refid');
        $this->db->where('sub_refid', $id);
        $this->db->where('perm_emp', 1);
        $this->db->where('sub_status', 'yes');
        $this->db->order_by("sub_order_id");
        $this->db->from("infinite_mlm_sub_menu");
        $query = $this->db->get();
        return $query;
    }

    public function getSubmenuText($menu_id) {
        $sub_link = "";

        $this->db->select('sub_link_ref_id');
        $this->db->where('sub_id', $menu_id);
        $this->db->from("infinite_mlm_sub_menu");
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $sub_link = $row->sub_link_ref_id;
        }
        return $sub_link;
    }

    public function getEmployeeDetails($letters) {
        $details = "";
        $letters = preg_replace("/[^a-z0-9 ]/si", "", $letters);

        $this->db->select('user_id,user_name');
        $this->db->from("login_employee");
        $this->db->like("user_name", $letters);
        $this->db->where("emp_status", "yes");
        $this->db->order_by("user_id");
        $qry = $this->db->get();
        foreach ($qry->result_array() as $row) {

            $details .= $row['user_id'] . "###" . $row['user_name'] . "|";
        }
          
        return $details;
    }

    public function isUserValid($user_name) {
        $flag = FALSE;
        $this->db->where('user_name', $user_name);
        $this->db->where('emp_status', 'yes');
        $this->db->from('login_employee');
        $count = $this->db->count_all_results();
        if ($count > 0) {
            $flag = TRUE;
        }
        return $flag;
    }

    public function getDetails($keyword, $limit = '', $page = '') {
        $i = 0;
        $page_no = $page + 1;
        $detail = array();

        $this->db->select('*');
        $this->db->select('l.user_name as user_name');
        $this->db->select('l.user_id as user_id');
        $this->db->select('ed.user_detail_name as user_detail_name');
        $this->db->select('ed.user_detail_mobile as user_detail_mobile');
        $this->db->select('ed.user_detail_second_name as user_detail_second_name');
        $this->db->select('ed.user_detail_email as user_detail_email');
        $this->db->from('login_employee as l');
        $this->db->join('employee_details as ed', 'ed.user_detail_id=l.user_id');
        $where = array('l.user_name' => $keyword, 'ed.user_detail_name' => $keyword ,'ed.user_detail_second_name' => $keyword,'ed.user_detail_email' => $keyword,'ed.user_detail_mobile' => $keyword);
        $this->db->group_start()
                    ->or_like($where)        
                    ->group_end();
        $this->db->where('l.emp_status','yes');   
        $this->db->limit($limit, $page);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() AS $row) {
                if ($row['emp_status'] == 'yes') {
                    $detail[$i]['page_no'] = $page_no;
                    $detail[$i]['user_name'] = $row['user_name'];
                    $detail[$i]['user_detail_name'] = $row['user_detail_name'];
                    $detail[$i]['user_detail_second_name'] = $row['user_detail_second_name'];
                    $detail[$i]['user_detail_email'] = $row['user_detail_email'];
                    $detail[$i]['user_id'] = $row['user_id'];
                    $detail[$i]['user_detail_mobile'] = $row['user_detail_mobile'];
                    $i++;
                    $page_no = $page_no + 1;
                }
            }
        }
        return $detail;
    }

    public function getCountMembers($keyword) {

        $this->db->select('*');
        $this->db->select('l.user_name as user_name');
        $this->db->select('l.user_id as user_id');
        $this->db->select('ed.user_detail_name as user_detail_name');
        $this->db->select('ed.user_detail_mobile as user_detail_mobile');
        $this->db->select('ed.user_detail_second_name as user_detail_second_name');
        $this->db->select('ed.user_detail_email as user_detail_email');
        $this->db->from('login_employee as l');
        $this->db->join('employee_details as ed', 'ed.user_detail_id=l.user_id');

        $where = array('l.user_name' => $keyword, 'ed.user_detail_name' => $keyword ,'ed.user_detail_second_name' => $keyword,'ed.user_detail_email' => $keyword,'ed.user_detail_mobile' => $keyword);
        $this->db->group_start()
                    ->or_like($where)        
                    ->group_end();
        $this->db->where('l.emp_status','yes');  
        $count = $this->db->count_all_results();
        return $count;
    }

    public function getEmployeDetails($limit = '', $page = '') {
        $detail = array();
        $i = 0;
        $page_no = $page + 1;

        $this->db->select('u.*');
        $this->db->select('l.user_name as user_name');
        $this->db->select('l.user_id as user_id');
        $this->db->from("employee_details as u");
        $this->db->join('login_employee as l', 'l.user_id=u.user_detail_id');
        $this->db->where("l.emp_status", 'yes');
        $this->db->limit($limit, $page);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $detail[$i]['page_no'] = $page_no;
                $detail[$i]['user_detail_name'] = $row['user_detail_name'];
                $detail[$i]['user_detail_second_name'] = $row['user_detail_second_name'];
                $detail[$i]['user_detail_mobile'] = $row['user_detail_mobile'];
                $detail[$i]['user_detail_email'] = $row['user_detail_email'];
                $detail[$i]['user_detail_id'] = $row['user_detail_id'];
                $detail[$i]['user_name'] = $row['user_name'];
                $detail[$i]['user_id'] = $row['user_id'];
                $i++;
                $page_no = $page_no + 1;
            }
        }
        return $detail;
    }

    public function getEmployeeDetailsCount() {
        $this->db->select('count(*) as cnt');
        $this->db->from("employee_details as u");
        $this->db->join('login_employee as l', 'l.user_id=u.user_detail_id');
        $this->db->where("l.emp_status", 'yes');
        $count = $this->db->count_all_results();
        return $count;
    }

    public function deleteEmployeeDetails($delete_id) {

        $this->db->set('emp_status', "no");
        $this->db->where('user_id', $delete_id);
        $query = $this->db->update('login_employee');
        return $query;
    }

    public function editEmployeeDetails($id) {
        $details = array();
        $i = 0;

        $this->db->select('u.*');
        $this->db->select('l.user_name as user_name');
        $this->db->from("employee_details as u");
        $this->db->join('login_employee as l', 'l.user_id=u.user_detail_id');
        $this->db->where("u.user_detail_id", $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $details[] = $row;
            }
        }
        return $details;
    }

    public function updateContent($editdetails_id, $first_name, $last_name, $emp_mob, $email) {
        $this->db->set('user_detail_name', $first_name);
        $this->db->set('user_detail_second_name', $last_name);
        $this->db->set('user_detail_mobile', $emp_mob);
        $this->db->set('user_detail_email', $email);
        $this->db->where('user_detail_id', $editdetails_id);
        $result = $this->db->update("employee_details");
        return $result;
    }

    function updatePassword($new_pswd, $user_name) {

        $this->db->set('password', password_hash($new_pswd, PASSWORD_DEFAULT));
        $this->db->where('user_name', $user_name);
        $query = $this->db->update('login_employee');
        return $query;
    }

    function isUserNameAvailable($user_name) {
        $flag = false;
        $count = 0;

        $this->db->select("COUNT(*) AS cnt");
        $this->db->from("login_employee");
        $this->db->where('user_name', $user_name);
        $this->db->where('emp_status', 'yes');
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $count = $row->cnt;
        }
        if ($count > 0) {
            $flag = true;
        }
        return $flag;
    }

    public function changeProfilePicture($id, $file_name) {
        $this->db->set('user_photo', $file_name);
        $this->db->where('user_detail_id', $id);
        $res = $this->db->update('employee_details');
        return $res;
    }

    public function getUserPhoto($id) {
        $this->db->select('user_photo');
        $this->db->from('employee_details');
        $this->db->where('user_detail_id', $id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            return $row->user_photo;
        }
    }
    
    public function getEmployeeActivity($employee_id = '', $offset = '', $limit = '') {
        $details = array();
        $this->db->select('e.*' );
        $this->db->from('employee_activity e');
        if($employee_id != '') {
            $this->db->where('e.employee_id', $employee_id);
        }
        $this->db->order_by('e.date', 'desc');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $i=0;
        foreach ($query->result_array() as $row) {
            $details[$i] = $row;
            $user_name = $this->validation_model->IdToUserName($row['user_id']);
            if($user_name == NULL){
                $user_name = $this->validation_model->EmployeeIdToUserName($row['user_id']);
            }
            $details[$i]['user_name'] = $user_name;
            $i++;
        }
        return $details;
    }
    
    public function getCountEmployeeActivity($employee_id = '') {
        $this->db->select('count(id) as count');
        if($employee_id != '') {
            $this->db->where('employee_id', $employee_id);
        }
        $query = $this->db->get('employee_activity');
        foreach($query->result_array() as $row) {
            return $row['count'];
        }
    }

    public function getRedirectPageOnLogin($employee_id)
    {
        $redirect_page = 'home';
        $this->db->select('module_status');
        $this->db->where('user_id', $employee_id);
        $query = $this->db->get('login_employee');
        $res = $query->row_array()['module_status'];
        $res = explode(',', $res);
        $res = array_diff($res, array('m#24,m#1'));
        if (count($res) === 1 && $res[0] == 'm#32') {
            $redirect_page = 'ticket_system/admin_home_page';
        }
        else {
            if (count($res) >= 1) {
                $res = array_map(function ($v) {
                    return substr($v, 0, strpos($v, '#'));
                }, $res);
                $res = array_unique($res);
                if (count($res) === 1 && $res[0] == '44') {
                    $redirect_page = 'crm/index';
                }
            }
        }
        return $redirect_page;
    }

    public function getEmployeesByKeyword($keyword) {
        $this->db->select('user_name');
        $this->db->like("user_name", $keyword);
        $this->db->where("emp_status", "yes");
        $this->db->order_by("user_id");
        $query = $this->db->get('login_employee');
        $response = [];
        foreach ($query->result_array() as $row) {
            $response[] = $row['user_name'];
        }
        return $response;
    }

    public function viewDashboardPermission($user) {
        $permission = "";
        $this->db->select('dashboard_menu');
        $this->db->from("login_employee");
        $this->db->where('user_name', $user);
        $this->db->or_where('user_id', $user);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $permission = $row->dashboard_menu;
        }
        return $permission;
    }

    public function insertIntodashboardPermission($arr_post) {

        $rr = array_keys($arr_post);
        $module_permission = "";
        $user_name = $arr_post['user'];
        $cnt = count($arr_post);
        for ($i = 0; $i < $cnt; $i++) {
            if ($rr[$i] != "user" AND $rr[$i] != "permission" && $rr[$i] != "user_name_submit") {
                $module_permission.= $arr_post[$rr[$i]] . ",";
            }
        }
        $module_permission = substr($module_permission, 0, strlen($module_permission) - 1);
        $this->db->set('dashboard_menu', $module_permission);
        $this->db->where('user_name', $user_name);
        $query = $this->db->update("login_employee");
        return $query;
    }

}
