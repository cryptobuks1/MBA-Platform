<?php

Class validation_model extends inf_model {

    public function __construct() {
        parent::__construct();
    }

    public function stripTagsPostArray($post_arr = array()) {
        $temp_arr = array();
        if (is_array($post_arr) && count($post_arr)) {
            foreach ($post_arr AS $key => $value) {
                if (is_string($value)) {
                    $temp_arr["$key"] = strip_tags($value);
                } else {
                    $temp_arr["$key"] = $value;
                }
            }
        }
        return $temp_arr;
    }

    public function escapeStringPostArray($post_arr = array()) {
        return $post_arr;
        /* $temp_arr = array();
        if (is_array($post_arr) && count($post_arr)) {
            foreach ($post_arr AS $key => $value) {
                if (is_string($value)) {
                    $temp_arr["$key"] = mysql_real_escape_string($value);
                } else {
                    $temp_arr["$key"] = $value;
                }
            }
        }
        return $temp_arr; */
    }

    public function stripSlashResultArray($result_arr = array()) {
        $temp_arr = array();
        if (is_array($result_arr) && count($result_arr)) {
            foreach ($result_arr AS $key => $value) {
                if (is_string($value)) {
                    $temp_arr["$key"] = stripslashes($value);
                } else {
                    $temp_arr["$key"] = $value;
                }
            }
        }
        return $temp_arr;
    }

    public function stripTagTextArea($text = '') {
        $allowable_tags = '<b></b><i></i><u></u><strong></strong><em></em><p></p><s></s><sub></sub><sup></sup><ol></ol><ul></ul><li></li><blockquote></blockquote><a><img><table></table><tbody></tbody><tr></tr><td></td><h1></h1><h2></h2><h3></h3><h4></h4><h5></h5><h6></h6><pre></pre><address></address><div></div>';
        return strip_tags($text, $allowable_tags);
    }

    public function userNameToID($username) {
        $user_id = 0;
        $this->db->select('id');
        $this->db->from('ft_individual');
        $this->db->where('user_name', $username);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_id = $row->id;
        }
        return $user_id;
    }

    public function IdToUserName($user_id) {
        $user_name = NULL;
        $this->db->select('user_name');
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 0)
        {
        $this->db->select('user_name');
        $this->db->from('user_deletion_history');
        $this->db->where('user_id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        }
        foreach ($query->result() as $row) {
            $user_name = $row->user_name;
        }
        return $user_name;
    }

    public function getFatherId($user_id) {
        $father_id = NULL;
        $this->db->select('father_id');
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $father_id = $row->father_id;
        }
        return $father_id;
    }

    public function getSponsorId($user_id) {
        $sponsor_id = NULL;
        $this->db->select('sponsor_id');
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $sponsor_id = $row->sponsor_id;
        }
        return $sponsor_id;
    }

    public function IdToUserNameBoard($board_user_id, $board_no) {
        if ($board_user_id > 0) {
            $user_name = NULL;
            $query = $this->db->select("user_name")->where("id", $board_user_id)->get("auto_board_$board_no");
            foreach ($query->result() as $row) {
                $user_name = $row->user_name;
            }
            return $user_name;
        } else {
            return "NA";
        }
    }

    public function getProfilePicture($user_id) {
        $img = 'nophoto.jpg';
        $this->db->select('user_photo');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $this->db->limit(1);
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $img = $row['user_photo'];
            if (!file_exists(IMG_DIR.'profile_picture/' . $row['user_photo'])) {
                $img = 'nophoto.jpg';
            }
        }

        return $img;
    }

    public function getLeftNodeId($father_id) {
        $user_id_left = NULL;
        $this->db->select("id");
        $this->db->from("ft_individual");
        $this->db->where("father_id", $father_id);
        $this->db->where("position", 'L');
        $this->db->where("active", 'yes');
        $rs = $this->db->get();
        foreach ($rs->result() as $id_left) {

            $user_id_left = $id_left->id;
        }
        return $user_id_left;
    }

    public function isUserAvailableinBoard($user_id, $board_no) {
        $flag = false;
        $board_table = "auto_board_" . $board_no;

        $this->db->select("*")->where("id", $user_id)->from("$board_table");
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $flag = true;
        }
        return $flag;
    }

    public function getUserFullName($user_id) {
        $user_name = NULL;
        $this->db->select('user_detail_name,user_detail_second_name');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            if($row->user_detail_second_name !=''){
              $user_name = $row->user_detail_name . " " . $row->user_detail_second_name;
            }else{
              $user_name = $row->user_detail_name;
            }
        }
        return $user_name;
    }

    public function getUserEmailId($user_id) {
        $email_id = NULL;
        $this->db->select("user_detail_email");
        $this->db->from("user_details");
        $this->db->where("user_detail_refid", $user_id);
        $this->db->limit(1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $email_id = $row->user_detail_email;
        }
        return $email_id;
    }

    public function geRighttNodeId($father_id) {
        $user_id_right = NULL;
        $this->db->select("id");
        $this->db->from("ft_individual");
        $this->db->where("father_id", $father_id);
        $this->db->where("position", 'R');
        $this->db->where("active", 'yes');
        $rs = $this->db->get();
        foreach ($rs->result() as $id_right) {
            $user_id_right = $id_right->id;
        }
        return $user_id_right;
    }

    public function getChildNodeId($father_id, $postion, $active = 'server') {
        $id_child = NULL;
        $this->db->select("id");
        $this->db->from("ft_individual");
        $this->db->where('father_id', $father_id);
        if ($postion && $postion != "") {
            $this->db->where('position', $postion);
        }
        $this->db->where('active', $active);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $id_child = $row->id;
        }
        return $id_child;
    }

    public function getSponserIdName($user_id, $table_prefix = '') {
        $row_data = array();
        $row = array();
        $id = "";
        $this->db->select("sponsor_id");
        $this->db->from("ft_individual");
        $this->db->where("id", $user_id);
        $qr = $this->db->get();
        foreach ($qr->result_array()as $row) {

            $id = $row['sponsor_id'];

            if ($id == 0) {
                $row_data['id'] = $row['sponsor_id'];
                $row_data['name'] = "NA";
            } else {

                $this->db->select("user_detail_name");
                $this->db->from($table_prefix . "user_details");
                $this->db->where("user_detail_refid", $id);
                $sql = $this->db->get();
                foreach ($sql->result()as $spncr) {
                    $row_data['id'] = $id;
                    $row_data['name'] = $spncr->user_detail_name;
                }
            }
        }

        return $row_data;
    }

    public function isLegAvailable($placement_id, $placement_leg, $check_position = false) {
        $flag = false;
        $placement_available = $this->isUserAvailable($placement_id);
        if ($placement_available) {
            if ($check_position) {
                $this->db->where('father_id', $placement_id);
                $this->db->where('position', $placement_leg);
                $count = $this->db->count_all_results('ft_individual');
                $flag = !($count > 0);
            }
            else {
                $flag = true;
            }
        }
        return $flag;
    }

    public function isUserNameAvailable($user_name) {
        $this->db->where('user_name', "$user_name");
        $count = $this->db->count_all_results('ft_individual');
        $flag = ($count > 0);
        return $flag;
    }

    public function isUserAvailable($user_id) {
        $this->db->where('id', $user_id);
        $count = $this->db->count_all_results('ft_individual');
        $flag = ($count > 0);
        return $flag;
    }

    public function getEmployeeStatus($user_id) {
        $status = NULL;
        $this->db->select("emp_status");
        $this->db->from("login_employee");
        $this->db->where("user_id", $user_id);
        $this->db->limit(1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $status = $row->emp_status;
        }
        return $status;
    }

    public function getProductNameFromUserID($user_id, $table_prefix = '') {
        $product_name = NULL;
        $this->db->select("product_name");
        $this->db->from("package as pr");
        $this->db->join("ft_individual as ft", "pr.prod_id = ft.product_id", "INNER");
        $this->db->where("ft.id", $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $product_name = $row->product_name;
        }
        return $product_name;
    }

    public function getProductId($user_id) {
        $product_id = '';
        $this->db->select("product_id");
        $this->db->where('id', $user_id);
        $query = $this->db->get("ft_individual");
        foreach ($query->result() as $row) {
            $product_id = $row->product_id;
        }
        return $product_id;
    }

    public function getFullName($user_id) {
        $det_name = NULL;
        $this->db->select("user_detail_name,user_detail_second_name");
        $this->db->from("user_details");
        $this->db->where("user_detail_refid", $user_id);
        $this->db->limit(1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $det_name = $row->user_detail_name;
            $det_name .= " " . $row->user_detail_second_name;
        }
        return $det_name;
    }

    public function getAdminId() {
        $user_id = NULL;
        $this->db->select('id');
        $this->db->from('ft_individual');
        $this->db->where('user_type', 'admin');
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_id = $row->id;
        }
        return $user_id;
    }

    public function getAdminUsername() {
        $user_name = NULL;
        $this->db->select('user_name');
        $this->db->from('ft_individual');
        $this->db->where('user_type', "admin");
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_name = $row->user_name;
        }
        return $user_name;
    }

    public function getAdminPassword() {
        $password = NULL;
        $this->db->select("password");
        $this->db->from("ft_individual");
        $this->db->where("user_type", 'admin');
        $this->db->limit(1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $password = $row->password;
        }
        return $password;
    }

    public function getJoiningData($user_id) {
        $this->db->select('date_of_joining');
        $this->db->where('id', $user_id);
        $res = $this->db->get('ft_individual');
        return $res->row_array()['date_of_joining'];
    }

    public function getSiteInformation() {
        $details = array();
        $this->db->select("*");
        $this->db->from("site_information");
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $row = $this->stripSlashResultArray($row);
            $details = $row;
            if (!file_exists(IMG_DIR.'logos/' . $row['logo'])) {
                $details['logo'] = 'logo_'.$this->ADMIN_THEME_FOLDER.'.png';
            }
            if (!file_exists(IMG_DIR.'logos/' . $row['favicon'])) {
                $details['favicon'] = 'favicon.ico';
            }
        }
        return $details;
    }

    public function getUserRank($id) {
        $rank = NULL;
        $this->db->select('user_rank_id');
        $this->db->from('ft_individual');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $rank = $row->user_rank_id;
        }
        return $rank;
    }

    public function getReferalCount($id) {
        $this->db->where('sponsor_id', $id);
        $count = $this->db->count_all_results('ft_individual');
        return $count;
    }

    public function getGrpPv($id) {
        $this->db->select("gpv");
        $this->db->from("ft_individual");
        $this->db->where('id', $id);
        $qr = $this->db->get();
        return $qr->row_array()['gpv'];
    }

    public function getPersnlPv($id) {
        $this->db->select("personal_pv");
        $this->db->from("ft_individual");
        $this->db->where('id', $id);
        $qr = $this->db->get();
        return $qr->row_array()['personal_pv'];
    }
    
    //newcode
     public function getLeftSponsorStatus($id) {
        $this->db->select("left_sponsor_status");
        $this->db->from("ft_individual");
        $this->db->where('id', $id);
        $qr = $this->db->get();
        return $qr->row_array()['left_sponsor_status'];
    }
    
     public function getRightSponsorStatus($id) {
        $this->db->select("right_sponsor_status");
        $this->db->from("ft_individual");
        $this->db->where('id', $id);
        $qr = $this->db->get();
        return $qr->row_array()['right_sponsor_status'];
    }
    //end

    public function isUserActive($id) {
        $flag = false;

        $this->db->select('active');
        $this->db->from("ft_individual");
        $this->db->where('id', $id);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $active = $row->active;
        }


        if ($active == 'yes') {
            $flag = true;
        } else {
            $flag = false;
        }
        return $flag;
    }

    public function getRefferalCount($num) {
        $count = 0;
        $this->db->select_max('referal_count');
        $this->db->where('referal_count <=', $num);
        $this->db->where('rank_status', 'active');
        $this->db->limit(1);
        $res = $this->db->get('rank_details');

        foreach ($res->result() as $row) {
            $count = $row->referal_count;
        }
        return $count;
    }

    public function getPrdocutName($product_id) {
        $prod_name = NULL;
        $MODULE_STATUS = $this->trackModule();
        if ($MODULE_STATUS['opencart_status'] != "yes" || $MODULE_STATUS['opencart_status_demo'] != "yes") {
            $this->db->select('product_name');
            $this->db->from('package');
            $this->db->where('product_id', $product_id);
            $query = $this->db->get();
            foreach ($query->result_array() as $row) {
                $prod_name = $row['product_name'];
            }
        } else {
            $this->db->select('model AS product_name');
            $this->db->where('product_id', $product_id);
            $query = $this->db->get('oc_product');
            foreach ($query->result_array() as $row) {
                $prod_name = $row['product_name'];
            }
        }
        return $prod_name;
    }

    public function insertUserActivity($login_id, $activity, $user_id = '', $data = '', $user_type = '') {
        $ip_adress = $this->IP_ADDR;
        //Code to convert Ipv6 address to Ipv4
        if (!filter_var($ip_adress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false) {
            $ip_adress = hexdec(substr($ip_adress, 0, 2)). "." . hexdec(substr($ip_adress, 2, 2)). "." . hexdec(substr($ip_adress, 5, 2)). "." . hexdec(substr($ip_adress, 7, 2));
         }
        $this->db->set('done_by', $login_id);
        if ($user_type != '') {
            $this->db->set('done_by_type', $user_type);
        } else {
            $this->db->set('done_by_type', $this->LOG_USER_TYPE);
        }
        $this->db->set('ip', $ip_adress);
        $this->db->set('user_id', $user_id);
        $this->db->set('activity', $activity);
        $this->db->set('date', date("Y-m-d H:i:s"));
        $this->db->set('data', $data);
        $result = $this->db->insert('activity_history');

        return $result;
    }

    public function getCompanyEmail() {
        $email_details = array();
        $this->db->select('from_name');
        $this->db->select('from_email');
        $this->db->from('mail_settings');
        $this->db->where('id', 1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $email_details["from_name"] = $row->from_name;
            $email_details["from_email"] = $row->from_email;
        }
        return $email_details;
    }

    public function getUserName($user_id) {
        $this->db->select('user_name');
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $res = $this->db->get();
        $row = $res->result_array();
        $user_name = $row[0]['user_name'];
        return $user_name;
    }

    public function getViewAmountType($amount_type = NULL) {
        $view_type = NULL;
        $this->db->select('view_amt_type');
        $this->db->from('amount_type');
        if ($amount_type != NULL)
        $this->db->where("db_amt_type", $amount_type);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $view_type = $row->view_amt_type;
        }
        return $view_type;
    }

    public function sentPassword($user_id, $password, $user_name) {
        $this->load->model('mail_model');
      /*  $letter_arr = $this->getLetterSetting();
        $subject = "Password Change";
        $message = "Dear $user_name,<br /> Your current password is : <br /><b> Password : " . $password . "</b>";
        $dt = date('Y-m-d h:m:s');

        $mailBodyDetails = "<html>
        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            
        </head>
        <body >
            <table id='Table_01' width='600'   border='0' cellpadding='0' cellspacing='0'>
             <tr><td COLSPAN='3'></td></tr>

             <td width='50px'></td>
             <td   width='520px'  >
              Dear $user_name<br>
              <p>
               <table border='0' cellpadding='0' width='60%' >
                   <tr>
                    <td colspan='2' align='center'><b>Your current password is : " . $password . "</b></td>
                </tr>
                <tr>
                    <td colspan='2'>Thanking you,</td>
                </tr>

                <tr>
                    <td colspan='2'><p align='left'>" . $letter_arr['company_name'] . "<br />Date:" . $dt . "<br />Place : " . $letter_arr['place'] . "</p></td>
                </tr>
            </table>
            <tr>
               <td COLSPAN='3'>
               </td>
           </tr>
       </table>
   </body>
   </html>";

   $email = $this->mail_model->getEmailId($user_id);

   if ($email)
    $this->mail_model->sendEmail($mailBodyDetails, $email, $subject);
*/
return true;
}

public function getLatestBoardIDFromFTUsername($username) {
    $board_user_arr = array();
    $res = $this->db->select("id")->where("user_name", $username)->get("ft_individual");
    foreach ($res->result_array() as $row) {
        $ft_id = $row['id'];
    }
    if ($ft_id != '') {
        $board_id1 = $this->getBoardIDByUserRefId($ft_id, 1);

        if ($board_id1) {

            $board_no = 1;
            $board_user_id = $board_id1;
        }
        $board_username = $this->IdToUserNameBoard($board_user_id, 1);
        $board_user_arr = array("board_id" => $board_user_id, "board_username" => $board_username, "board_table_no" => $board_no);
    }

    return $board_user_arr;
}

public function getBoardIDByUserRefId($id, $board_table_no) {
    $user_id = 0;
    $goc_table_name = "auto_board_" . $board_table_no;
    $res = $this->db->select("id")->where("user_ref_id", $id)->order_by("date_of_joining", "DESC")->limit(1)->get("$goc_table_name");

    foreach ($res->result() as $row) {
        $user_id = $row->id;
    }
    return $user_id;
}

public function getUserIDByBoardID($id, $board_table_no) {
    $user_id = 0;
    $goc_table_name = "auto_board_" . $board_table_no;
    $res = $this->db->select("user_ref_id")->where("id", $id)->limit(1)->get("$goc_table_name");

    foreach ($res->result() as $row) {
        $user_id = $row->user_ref_id;
    }
    return $user_id;
}

public function getRankName($rank) {
    $rank_name = NULL;
    $this->db->select('rank_name');
    $this->db->from('rank_details');
    $this->db->where('rank_id', $rank);
    $res = $this->db->get();
    foreach ($res->result() as $row) {
        $rank_name = $row->rank_name;
    }
    return $rank_name;
}

public function getUserType($user_id) {
    $user_type = "";
    $this->db->select('user_type');
    $this->db->where('id', $user_id);
    $res = $this->db->get('ft_individual');
    foreach ($res->result_array() as $row) {
        $user_type = $row['user_type'];
    }
    return $user_type;
}

public function getUserDetails($user_id, $type = 'user') {
    $user_details = array();
    if ($type == "employee") {
        $this->db->select('*');
        $this->db->from("employee_details");
        $this->db->where("user_detail_refid", $user_id);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $user_details = $row;
        }
        $user_details["affiliates_count"] = 0;
        $user_details["status"] = "active";
        $user_details["rank"] = 0;
        $user_details["rank_status"] = "no";
        $user_details["rank_name"] = "NA";
        } else if ($type == "super_admin") {//for super admin
            $user_details["affiliates_count"] = 0;
            $user_details["status"] = "active";
            $user_details["rank"] = 0;
            $user_details["rank_status"] = "no";
            $user_details["rank_name"] = "NA";
            $user_details['user_detail_email'] = "sasaa@sss.lkj";
            $user_details['user_photo'] = "nonphoto.png";
        } else {

            $this->db->select('*');
            $this->db->from("user_details");
            $this->db->where("user_detail_refid", $user_id);
            $query = $this->db->get();
            foreach ($query->result_array() as $row) {
                if (!file_exists(IMG_DIR.'profile_picture/' . $row['user_photo'])) {
                    $row['user_photo'] = 'nophoto.jpg';
                }
                $user_details = $row;
            }
            $user_details["affiliates_count"] = $this->getAffiliatesCount($user_id);
            $user_details["status"] = $this->getUserStatus($user_id);
            $user_details["rank"] = $this->getUserRank($user_id);
            $rank_status = 'yes';
            $rank_name = 'NA';
            if ($user_details["rank"] == 0) {
                $rank_status = "no";
            } else {
                $rank_name = $this->validation_model->getRankName($user_details["rank"]);
            }
            $user_details["rank_status"] = $rank_status;
            $user_details["rank_name"] = $rank_name;
        }
        return $user_details;
    }

    public function getAffiliatesCount($user_id) {
        $this->db->select('*');
        $this->db->from("ft_individual");
        $this->db->where("sponsor_id", $user_id);
        $count = $this->db->count_all_results();

        return $count;
    }

    public function getUserStatus($user_id) {
        $status = "0";

        $this->db->select('active');
        $this->db->from("ft_individual");
        $this->db->where("id", $user_id);
        $qry = $this->db->get();
        foreach ($qry->result() as $row) {
            if ($row->active == "yes")
                $status = "active";
            else
                $status = "inactive";
        }

        return $status;
    }

    public function getUserRankStatus() {
        $rank_status = "";
        $this->db->select('rank_status');
        $this->db->from("module_status");
        $qry = $this->db->get();
        foreach ($qry->result() as $row) {
            $rank_status = $row->rank_status;
        }
        return $rank_status;
    }

    public function getUserPhoneNumber($user_id) {
        $email_id = NULL;
        $this->db->select("user_detail_mobile");
        $this->db->from("user_details");
        $this->db->where("user_detail_refid", $user_id);
        $this->db->limit(1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $phone_num = $row->user_detail_mobile;
        }
        return $phone_num;
    }

    public function getUserAddress($user_id) {
        $this->db->select("user_detail_address");
        $this->db->from("user_details");
        $this->db->where("user_detail_refid", $user_id);
        $this->db->limit(1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $address = $row->user_detail_address;
        }
        return $address;
    }

    public function IdToUserNameWitoutLogin($user_id, $prefix) {
        $db_prefix_old = $this->db->dbprefix;
        $this->db->set_dbprefix('');
        $table = $prefix . '_ft_individual';
        $user_name = NULL;
        $this->db->select('user_name');
        $this->db->from($table);
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_name = $row->user_name;
        }
        $this->db->set_dbprefix($db_prefix_old);
        return $user_name;
    }

    public function getUserBalanceAmount($user_id) {
        $balance_amount=0;
        $this->db->select('balance_amount');
        $this->db->from('user_balance_amount');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $balance_amount = $row->balance_amount;
        }
        return $balance_amount;
    }

    public function getUserFTDetails($user_id) {
        $user_detail = array();
        $this->db->select("*");
        $this->db->from("ft_individual");
        $this->db->where("id", $user_id);
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $user_detail = $row;
        }
        return $user_detail;
    }

    public function getWidthCieling() {
        $obj_arr = $this->getSettings();
        $width_cieling = $obj_arr["width_ceiling"];
        return $width_cieling;
    }

    public function getSettings() {
        $obj_arr = array();
        $this->db->select("*");
        $this->db->from("configuration");
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $obj_arr["id"] = $row['id'];
            $obj_arr["tds"] = $row['tds'];
            $obj_arr["pair_price"] = $row['pair_price'];
            $obj_arr["pair_ceiling"] = $row['pair_ceiling'];
            $obj_arr["service_charge"] = $row['service_charge'];
            $obj_arr["product_point_value"] = $row['product_point_value'];
            $obj_arr["pair_value"] = $row['pair_value'];
            $obj_arr["startDate"] = $row['start_date'];
            $obj_arr["endDate"] = $row['end_date'];
            $obj_arr["sms_status"] = $row['sms_status'];
            $obj_arr["payout_release"] = $row['payout_release'];
            $obj_arr["referal_amount"] = $row['referal_amount'];
            $obj_arr["level_commission_type"] = $row['level_commission_type'];
            $obj_arr["pair_commission_type"] = $row['pair_commission_type'];
            $obj_arr["depth_ceiling"] = $row['depth_ceiling'];
            $obj_arr["width_ceiling"] = $row['width_ceiling'];
        }

        return $obj_arr;
    }

    public function userNameToIDBoard($username, $board_id) {
        $user_id = 0;
        $this->db->select('id');
        $this->db->from("auto_board_$board_id");
        $this->db->where('user_name', $username);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_id = $row->id;
        }

        return $user_id;
    }

    public function getRankId($user_id) {
        $rank_id = 0;
        $this->db->select('user_rank_id');
        $this->db->where('id', $user_id);
        $query = $this->db->get('ft_individual');

        foreach ($query->result() as $row) {
            $rank_id = $row->user_rank_id;
        }

        return $rank_id;
    }

    public function getUserLevel($user_id) {
        $level = "NA";
        $this->db->select('user_level');
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $level = $row->user_level;
        }

        return $level;
    }

    public function getUserData($user_id, $field_name = "") {
        $data = null;
        if ($field_name != "") {
            $this->db->select($field_name);
            $this->db->from('user_details');
            $this->db->where('user_detail_refid', $user_id);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $data = $row->$field_name;
            }
        }
        return $data;
    }

    public function getMLMPlan() {
        $mlm_plan = "NA";
        $this->db->select('mlm_plan');
        $this->db->from('module_status');
        $this->db->where('id', 1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $mlm_plan = $row->mlm_plan;
        }
        return $mlm_plan;
    }

    public function getUserIDFromCustomerID($customer_id) {
        $user_id = 0;
        $this->db->select('id');
        $this->db->from('ft_individual');
        $this->db->where('oc_customer_ref_id', $customer_id);
        $this->db->limit(1);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $user_id = $row->id;
        }
        return $user_id;
    }

    function getOcCustomerId($user_id) {
        $oc_customer_ref_id = 0;
        $this->db->select('oc_customer_ref_id');
        $this->db->where('id', $user_id);
        $res = $this->db->get('ft_individual');
        foreach ($res->result() as $row) {
            $oc_customer_ref_id = $row->oc_customer_ref_id;
        }
        return $oc_customer_ref_id;
    }

    public function getAllUserDetails($user_id) {
        $user_details = array();
        $this->db->select('*');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $user_details = $row;
            if (!file_exists(IMG_DIR.'profile_picture/' . $row['user_photo'])) {
                $user_details['user_photo'] = 'nophoto.jpg';
            }
        }

        return $user_details;
    }

    public function getUserReferralCount($user_id) {
        $this->db->where('sponsor_id', $user_id);
        $count = $this->db->count_all_results('ft_individual');
        return $count;
    }

    public function sendGoogleCloudMessage($data, $id) {
        $apiKey = 'AIzaSyCOTQbMZvegMBzOkmWpf4dtu6rYVBFFl7g';
        $url = 'https://gcm-http.googleapis.com/gcm/send';

        $post = array(
            'to' => $id,
            'data' => $data,
            );

        $headers = array(
            "Authorization: key=$apiKey",
            'Content-Type: application/json'
            );

        $json_data = json_encode($post);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            log_message('error', curl_error($ch), false);
        }
        curl_close($ch);

        return $result;
    }

    function getUserApiKey($user_id) {
        $this->db->select("api_key");
        $this->db->from("ft_individual");
        $this->db->where("id", $user_id);
        $query = $this->db->get();
        return $query->row()->api_key;
    }

    function getInsertIndividualApiKey($user_id, $api_key) {
        $this->db->set('api_key', $api_key);
        $this->db->where('id', $user_id);
        $result = $this->db->update('ft_individual');
        return $result;
    }

    public function textAreaLineBreaker($text_area_data) {
        $str1 = str_replace(array('\r\n', '\r', '\n'), "<br/>", $text_area_data);
        $str2 = str_replace(array('\t'), "&nbsp;", $str1);
        return $str2;
    }

    public function getVisitordetails() {
        $result = NULL;
        $this->db->select("*");
        $this->db->from("crm_leads");
//        $where1="status = 'pending' OR status = 'following'";
//        $this->db->where($where1);
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $result[$i]['name'] = $row['first_name'] . $row['last_name'];
            $result[$i]['id'] = $row['id'];
            $result[$i]['email'] = $row['email_id'];
            $result[$i]['lead_id'] = $row['lead_id'];
            $date = strtotime($row['date']);
            $newformat = date('d-m-Y', $date);
            $result[$i]['date'] = $newformat;
            $i++;
        }

        return $result;
    }

    function convertNumberToWords($number) {
        $hyphen = ' ';
        $conjunction = ' and ';
        $separator = ' ';
        $negative = 'negative ';
        $decimal = ' point ';
        $dictionary = array(
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'fourty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            1000000 => 'million',
            1000000000 => 'billion',
            1000000000000 => 'trillion',
            1000000000000000 => 'quadrillion',
            1000000000000000000 => 'quintillion'
            );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
                );
            return false;
        }

        if ($number < 0) {
            return $negative . $this->convertNumberToWords(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
            $string = $dictionary[$number];
            break;
            case $number < 100:
            $tens = ((int) ($number / 10)) * 10;
            $units = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
            case $number < 1000:
            $hundreds = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . $this->convertNumberToWords($remainder);
            }
            break;
            default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = $this->convertNumberToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= $this->convertNumberToWords($remainder);
            }
            break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }

    public function employeeNameToID($user_name) {
        $user_id = 0;
        $this->db->select("user_id");
        $this->db->where('user_name', $user_name);
        $this->db->where('emp_status','yes');
        $this->db->limit(1);
        $query = $this->db->get('login_employee');
        foreach ($query->result() as $row) {
            $user_id = $row->user_id;
        }
        return $user_id;
    }

    public function EmployeeIdToUserName($user_id) {
        $user_name = 0;
        $this->db->select("user_name");
        $this->db->where('user_id', $user_id);
	    $this->db->where('emp_status','yes');
        $this->db->limit(1);
        $query = $this->db->get('login_employee');
        foreach ($query->result() as $row) {
            $user_name = $row->user_name;
        }
        return $user_name;
    }

    public function stripSlashArray($post_arr = array()) {
        $temp_arr = array();
        if (is_array($post_arr) && count($post_arr)) {
            foreach ($post_arr AS $key => $value) {
                if (is_string($value)) {
                    $value = str_replace(array('\r\n', '\r', '\n'), "<br />", $value);
                    $value = str_replace(array('\t'), "&nbsp", $value);
                    $temp_arr["$key"] = stripslashes($value);
                } else {
                    $temp_arr["$key"] = $value;
                }
            }
        }
        return $temp_arr;
    }

    public function getUserPurchaseDefaultAddressId($user_id) {
        $address_id = 0;
        $this->db->select('id');
        $this->db->from('repurchase_address');
        $this->db->where('user_id', $user_id);
        $this->db->where('default_address', "1");
        $this->db->where('delete_status', "yes");
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $address_id = $row->id;
        }
        return $address_id;
    }

    public function getDownlines($next_lines, $down_lines) {
        $this->db->select('id,user_name');
        $this->db->from('ft_individual');
        $this->db->where_in('father_id', $next_lines);
        $query = $this->db->get();
        $next_lines = array();
        foreach ($query->result_array() as $row) {
            array_push($next_lines, $row['id']);
            array_push($down_lines, $row);
        }
        if (empty($next_lines)) {
            return $down_lines;
        } else {
            return $this->getDownlines($next_lines, $down_lines);
        }
    }

    public function encrypt($string) {
        $result = '';
        $key = "IOSS#z0!6";
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) + ord($keychar));
            $result.=$char;
        }
        $result =  base64_encode($result);
        return str_replace("=", "_", $result);
    }

    public function decrypt($string) {
        $result = '';
        $key = "IOSS#z0!6";

        $string = base64_decode($string);

        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) - ord($keychar));
            $result.=$char;
        }

        return $result;
    }


    public function insertEmployeeActivity($employee_id, $user_id, $activity, $description, $pending_status = false) {
        $this->db->set('employee_id', $employee_id);
        if($user_id) {
            $this->db->set('user_id', $user_id);
        }
        $this->db->set('activity', $activity);
        $this->db->set('description', $description);
        $this->db->set('pending_status', $pending_status);
        return $this->db->insert('employee_activity');
    }

    public function getUserStairStepId($user_id) {
        $step_id = 0;
        $this->db->select('step_id');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('stair_step');

        foreach ($query->result() as $row) {
            $step_id = $row->step_id;
        }
        return $step_id;
    }

    public function userBreakAwayStatus($user_id) {
        $status = "no";
        $this->db->select('breakaway_status');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('stair_step');

        foreach ($query->result() as $row) {
            $status = $row->breakaway_status;
        }
        return $status;
    }

    public function getStairStepName($step_id) {
        $step_name = NULL;
        $this->db->select('step_name');
        $this->db->from('stair_step_config');
        $this->db->where('step_id', $step_id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $step_name = $row->step_name;
        }
        return $step_name;
    }

    public function getAllStairStepDetails() {
        $details = array();
        $this->db->where('status', 'active');
        $query = $this->db->get('stair_step_config');
        foreach ($query->result_array() as $row) {
            $details[$row['step_id']] = $row;
        }
        return $details;
    }

    public function getUserStepDetails() {
        $details = array();
        $this->db->select('*');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('stair_step');

        foreach ($query->result() as $row) {
            $details['user_id'] = $row['user_id'];
            $details['step_id'] = $row['step_id'];
            $details['breakaway_status'] = $row['breakaway_status'];
        }
        return $details;
    }

    public function getPersonalPV($user_id) {
        $total_pv = 0;
        $this->db->select('total_pv');
        $this->db->from('user_pv_details');
        $this->db->where('user_id', $user_id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $total_pv = $row->total_pv;
        }
        return $total_pv;
    }

    public function getGroupPV($user_id) {
        $total_pv = 0;
        $this->db->select('total_gpv');
        $this->db->from('user_pv_details');
        $this->db->where('user_id', $user_id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $total_pv = $row->total_gpv;
        }
        return $total_pv;
    }

    public function getUserImage($user_id) {
        $user_photo = "nophoto.jpg";
        $this->db->select('user_photo');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $user_photo = $row['user_photo'];
            if (!file_exists(IMG_DIR.'profile_picture/' . $row['user_photo'])) {
                $user_photo = 'nophoto.jpg';
            }
        }

        return $user_photo;
    }

    public function getUserLeaderId($user_id) {
        $leader_id = NULL;
        $this->db->select('leader_id');
        $this->db->where("user_id", $user_id);
        $this->db->limit(1);
        $result = $this->db->get('stair_step');
        $result = $result->result_array();

        foreach ($result as $value) {
            $leader_id = ( $value['leader_id'] ) ? $value['leader_id'] : $this->validation_model->getAdminId();
        }
        return $leader_id;
    }

    public function getStairStepMaxId(){
        $step_id = 0;
        $this->db->select_max("step_id");
        $this->db->where('status', "active");
        $this->db->limit(1);
        $res = $this->db->get("stair_step_config");
        foreach ($res->result() as $row) {
            $step_id = $row->step_id;
        }
        return $step_id;
    }

    public function getUserProductValidity($user_id){
        $date = 0;
        $this->db->select("product_validity");
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $res = $this->db->get("ft_individual");
        foreach ($res->result() as $row) {
            $date = $row->product_validity;
        }
        return $date;
    }

    public function isUserExists($user_id) {
        $this->db->where('id', $user_id);
        return $this->db->count_all_results('ft_individual');
    }

    public function isUsernameExists($user_name) {
        $this->db->where('user_name', $user_name);
        $res = $this->db->count_all_results('ft_individual');
        if (!$res) {
            $this->db->where('user_name', $user_name);
            $this->db->where('status', 'pending');
            $res = $this->db->count_all_results('pending_registration');
        }
        return $res;
    }

    public function getUserTreeLevel($user_id, $tree_type = 'tree') {
        if($tree_type == 'tree') {
            $this->db->select('user_level level');
        } elseif($tree_type == 'sponsor_tree') {
            $this->db->select('sponsor_level level');
        }
        $this->db->where('id', $user_id);
        $query = $this->db->get('ft_individual');
        $level = $query->row_array()['level'];
        return $level;
    }

    public function getUserLeftAndRight($user_id, $type) {
        $this->db->select("left_$type, right_$type");
        $this->db->where('ft_id', $user_id);
        $result = $this->db->get('tree_parser');

        $result = $result->result_array();
        return $result[0];
    }

    public function getDownlineUsers($left_no, $right_no, $type) {
        $child_nodes = array();

        $this->db->select('f.id');
        $this->db->from('ft_individual f');
        $this->db->join('tree_parser t', 't.ft_id = f.id', 'LEFT');
        $this->db->where("t.left_$type >", $left_no);
        $this->db->where("t.right_$type <", $right_no);

        if ($this->MLM_PLAN != "Binary") {
            $this->db->order_by("f.order_id", "ASC");
        } else {
            $this->db->order_by("f.position", "ASC");
        }
        $query = $this->db->get();

        foreach ($query->result_array() AS $rows) {
            $child_nodes[] = $rows['id'];
        }
        return $child_nodes;
    }

    public function getUserPosition($user_id) {
        $this->db->select('position');
        $this->db->where('id', $user_id);
        $query = $this->db->get('ft_individual');
        return $query->row_array()['position'];
    }

    public function hideReactivationMenu()
    {
        $this->db->set('sub_status', 'no');
        $this->db->where('sub_id' ,93);
        $query = $this->db->update('infinite_mlm_sub_menu');
    }

    public function isPresetDemo($admin_id) {
        $dbprefix = $this->db->dbprefix;
        $this->db->set_dbprefix('');
        $this->db->where('admin_id', $admin_id);
        $count = $this->db->count_all_results('inf_preset_demo_users');
        $this->db->set_dbprefix($dbprefix);
        return $count !== NULL && $count > 0;
    }

    public function getPresetUser($admin_id){
        $dbprefix = $this->db->dbprefix;
        $this->db->set_dbprefix('');
        $this->db->select('user_name');
        $this->db->where('admin_id', $admin_id);
        $query = $this->db->get('inf_preset_demo_users');
        $this->db->set_dbprefix($dbprefix);
        return $query->row_array()['user_name'];
    }

    public function getAllAmountType() {
        $view_type = NULL;
        $MODULE_STATUS = $this->trackModule();
        $i = 0;
        $this->db->distinct();
        $this->db->select('amount_type');
        $this->db->from('leg_amount');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            if( $MODULE_STATUS['table_status'] == 'yes' && $MODULE_STATUS['mlm_plan'] == 'Board' ) {
                if ( $row->amount_type == 'board_commission' ) {
                    $view_amt_type = 'table_commission';
                } else {
                    $view_amt_type = $row->amount_type;
                }
            } else {
                $view_amt_type = $row->amount_type;
            }
            $view_type[$i]['db_amount_type'] = $row->amount_type;
            $view_type[$i]['view_amt_type'] = $view_amt_type;
            $i++;
        }
        return $view_type;
    }

    public function isPendingUserRegistration($user_name)
    {
        $this->db->where('status', 'pending');
        $this->db->where('user_name', $user_name);
        return $this->db->count_all_results('pending_registration');
    }
    //inactiviy logout setting
     public function selectLogoutTime() {

        $this->db->select('logout_time');
        $this->db->from('common_settings');
        $this->db->where('active', 'yes');
        $res = $this->db->get();
        return $res->row_array()['logout_time'];
    }
    public function UserNameToIdWitoutLogin($user_name, $prefix) {
        $db_prefix_old = $this->db->dbprefix;
        $this->db->set_dbprefix('');
        $table = $prefix . '_ft_individual';
        $user_id = 0;
        $this->db->select('id');
        $this->db->from($table);
        $this->db->where('user_name', $user_name);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_id = $row->id;
        }
        $this->db->set_dbprefix($db_prefix_old);
        return $user_id;
    }
    //
    public function getProdIDFromProductid($product_id) {
        $prod_id = '';
        $this->db->select("prod_id");
        $this->db->from("package");
        $this->db->where("product_id", $product_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $prod_id = $row->prod_id;
        }
        return $prod_id;
    }

    public function getModuleStatusByKey($key) {
        $module_status = NULL;
        $this->db->select("$key");
        $this->db->from("module_status");
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $module_status = $row->$key;
        }
        return $module_status;
    }
    public function getAutoUserDetails(){
        $db_prefix_old = $this->db->dbprefix;
        $this->db->set_dbprefix('');
        $table = 'auto_register_data';
        $details = array();
        $this->db->select('*');
        $this->db->from($table);
        $query = $this->db->get();
        foreach ($query->result_array() AS $row) {
            $details[] = $row;
        }
        $this->db->set_dbprefix($db_prefix_old);
        return $details;
    }
     public function getUserPassword($username) {
        $password = NULL;
        $this->db->select('password');
        $this->db->from('ft_individual');
        $this->db->where('user_name',$username);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $password = $row->password;
        }
        return $password;
    }
    public function getUserDefaultCurrency($user_id) {

        $currency = NULL;
        $this->db->select('code as c_code,value as c_value,symbol_left as c_symbol,title');
        $this->db->from('ft_individual as f');
        $this->db->join('currency_details c','f.default_currency = c.id');
        $this->db->where('f.id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $currency = $row;
        }
        return $currency;
    }
    public function getAllCurrency(){
        $detail = array();
        $this->db->select('code as c_code,value as c_value,symbol_left as c_symbol,title');
        $this->db->from('currency_details');
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $detail[] = $row;
        }
        return $detail;
    }
    public function checkCurrencyCode($c_code){
        $detail = array();
        $this->db->from('currency_details');
        $this->db->select('id,code as c_code,value as c_value,symbol_left as c_symbol,title');
        $this->db->where('code', $c_code);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $detail = $row;
        }
        return $detail;
    }
    public function changeDefaultCurrency($user_id , $c_id){
        $this->db->set('default_currency', $c_id);
        $this->db->where('id', $user_id);
        $result = $this->db->update('ft_individual');
        return $result;
    }
    public function getUploadCategory($category = '') {
        $detail = array();
        $id = '';
        if ($category != '') {
            $this->db->select('c_id');
            $this->db->from('upload_categorys');
            $this->db->where('type', $category);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $id = $row->c_id;
            }
            return $id;
        } else {
            $this->db->select('*');
            $this->db->from('upload_categorys');
            $query = $this->db->get();
            foreach ($query->result_array() as $row) {
                $detail[] = $row;
            }
            return $detail;
        }
    }
    public function getUrlPerm($url,$user_type){

        $status = 0;
        $url_id = $this->inf_model->getURLID($url);
        if ($user_type == "admin") {
            $perm_type = "perm_admin";
        } elseif ($user_type == "user") {
            $perm_type = "perm_dist";
        } elseif ($user_type == "emp") {
            $perm_type = "perm_emp";
        }

        $this->db->select($perm_type);
        $this->db->from("infinite_mlm_sub_menu");
        $this->db->where("sub_link_ref_id", $url_id);
        $this->db->limit(1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $status = $row->$perm_type;
        }
        return $status;
    }

    public function addEwalletHistory($user_id, $from_id, $ewallet_id, $ewallet_type, $amount, $amount_type, $type, $transaction_id = '', $transaction_note = '', $transaction_fee = 0, $pending_id = FALSE) {
        $date = date('Y-m-d H:i:s');
        if (empty($pending_id)) {
            $pending_id = 'NULL';
        }
        if (empty($from_id)) {
            $from_id = 'NULL';
        }
        $this->db->set('user_id', $user_id);
        $this->db->set('from_id', $from_id, FALSE);
        $this->db->set('ewallet_id', $ewallet_id);
        $this->db->set('ewallet_type', $ewallet_type);
        $this->db->set('amount', $amount);
        $this->db->set('amount_type', $amount_type);
        $this->db->set('type', $type);
        $this->db->set('pending_id', $pending_id, FALSE);
        $this->db->set('transaction_id', $transaction_id);
        $this->db->set('transaction_note', $transaction_note);
        $this->db->set('transaction_fee', $transaction_fee);
        $this->db->set('date_added', $date);
        $rs = $this->db->insert('ewallet_history');

        if ($type == "credit" && $this->MLM_PLAN == "Donation") {
            $this->load->model('donation_model');
            $this->donation_model->checkdonation($user_id);
        }

        if($ewallet_type == 'commission' && $this->MODULE_STATUS['purchase_wallet'] == "yes" && $rs) {
            $inserted_id = $this->db->insert_id();
            $purchase_amount = $this->updatePurchaseWallet($user_id,$from_id, $amount, $amount_type,$ewallet_id, $inserted_id);
        }

        return $rs;
    }

    function get_language_name($code = '') {//new
        $lang = 'english';
        $this->db->select('lang_name_in_english');
        $this->db->from('infinite_languages');
        $this->db->where("lang_code", $code);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $lang = $row->lang_name_in_english;
        }
        return $lang;
    }
    public function getCurrentLevelDonation($user_id) {
        $lvl = 0;
        $this->db->select('current_level');
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $lvl = $row->current_level;
        }
        return $lvl;
    }
    public function getDonationLevelName($level = '') {
        if ($level != '') {
            $level_name = "NA";
            $this->db->select('*');
            $this->db->where("id", $level);
            $this->db->from('donation_rate');
            $query = $this->db->get();
            if ($query->result_array()) {
                $level_name = $query->row()->level_name;
            }
        }else{
            $level_name = array();
            $this->db->select('level_name');
            $this->db->from('donation_rate');
            $query = $this->db->get();
            $level_name = $query->result_array();
        }
        return $level_name;
    }

    public function getColoumnFromTable($table, $key) {
        $this->db->select("$key");
        $query = $this->db->get($table);
        return $query->row_array()[$key];
    }

    public function verifyBcrypt($query,$password) {
        if ($query->num_rows() == 1) {
            $db_pass = $query->result()[0]->password;
            if (password_verify($password, $db_pass)) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function getSponserIdUserName($user_id, $table_prefix = '') {
        $row_data = array();
        $row = array();
        $id = "";
        $this->db->select("sponsor_id");
        $this->db->from("ft_individual");
        $this->db->where("id", $user_id);
        $qr = $this->db->get();

        foreach ($qr->result_array()as $row) {

            $id = $row['sponsor_id'];

            if ($id == 0) {
                $row_data['id'] = $row['sponsor_id'];
                $row_data['name'] = "NA";
            } else {
                $this->db->select("user_name");
                $this->db->from($table_prefix . "ft_individual");
                $this->db->where("id", $id);
                $sql = $this->db->get();
                foreach ($sql->result()as $spncr) {
                    $row_data['id'] = $id;
                    $row_data['name'] = $spncr->user_name;
                }
            }
        }

        return $row_data;
    }
    public function getConfig($key) {
        if (is_array($key)) {
            $key = implode(',', $key);
        }
        $this->db->select($key);
        $query = $this->db->get('configuration');
        if ($query->num_fields() > 1) {
            return $query->row_array();
        }
        else {
            return $query->row_array()[$key];
        }
    }

    public function getUploadCount($user_id) {

        $this->db->select('upload_count');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $res = $this->db->get();
        return $res->row_array()['upload_count'];
    }
    public function getUploadConfig() {

        $this->db->select('upload_config');
        $this->db->from('configuration');
        $res = $this->db->get();
        return $res->row_array()['upload_config'];
    }
    public function updateUploadCount($user_id) {

        $this->db->set('upload_count', 'upload_count + 1',FALSE);
        $this->db->where('user_detail_refid', $user_id);
        $result = $this->db->update('user_details');
        return $result;
    }

    public function checkKycUpload($user_id) {
        $this->db->select('kyc_status');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $res = $this->db->get();
        return $res->row_array()['kyc_status'];
    }

    public function getTooltipConfig() {
        $details = [];
//        $this->db->where('view_status', 'yes');
        $query = $this->db->get('tooltip_config');
        foreach ($query->result() as $row) {
            $details["$row->label"] = $row->status;
        }
        return $details;
    }

    public function checkBitcoinStatus() {
        $flag="no";
        $bitcoin_name = array('Bitcoin','Blockchain','Bitgo');
        $this->db->select('COUNT(*) AS count');
        $this->db->where('status',"yes");
        $this->db->where_in('gateway_name',$bitcoin_name);
        $query = $this->db->get('payment_gateway_config');
        $cnt = $query->row('count');
        if ($cnt > 0) {
            $flag = "yes";
        }
        return $flag;
    }

    public function getAuthStatus() {
        $this->db->select('google_auth_status');
        $this->db->limit(1);
        $query = $this->db->get('module_status');
        return $query->row('google_auth_status');
    }

    public function loginForQr($username, $password,$login_type=null) {
        if ($username && $password) {
            if($login_type == 'employee'){
                $this->db->select('user_id AS id, user_name, password,user_type');
                $this->db->from('login_employee');
                $this->db->where('addedby', "code");
                $this->db->where('emp_status', "yes");
            }else{
                $this->db->select('id, user_name, password,user_type');
                $this->db->from('ft_individual');
            }
            $this->db->where('user_name = ' . "'" . $username . "'");
            $this->db->limit(1);
            $query = $this->db->get();
        } else {
            return false;
        }
        $flag = $this->verifyBcrypt($query,$password);
        if ($flag) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getGocKey($user_id) {
        $this->db->select('goc_key');
        $this->db->where('id',$user_id);
        $query = $this->db->get('ft_individual');
        return $query->row('goc_key');

    }

    public function checkEmail($user_id, $e_mail) {
        $mail_db = '';
        $flag = FALSE;
        if ($user_id != "" && $e_mail != "") {
            $this->db->select("user_detail_email");
            $this->db->from("user_details");
            $this->db->where("user_detail_refid", $user_id);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $mail_db = $row->user_detail_email;
            }

            if ($e_mail == $mail_db) {
                $flag = TRUE;
            }
        }
        return $flag;
    }

    public function sendEmail($user_id, $e_mail) {
        $send_details = array();
        $send_details['user_id'] = $user_id;
        $type = 'forgot_password';
        $email = $this->validation_model->getUserEmailId($user_id);
        $send_details['full_name'] = $this->validation_model->getUserFullName($user_id);
        $send_details['email'] = $e_mail;
        $send_details['first_name'] = $this->validation_model->getUserData($user_id, "user_detail_name");
        $send_details['last_name'] = $this->validation_model->getUserData($user_id, "user_detail_second_name");
        return $this->mail_model->sendAllEmails($type, $send_details);
    }
    public function sendEmailforRestGoogleAuth($user_id, $e_mail){
        $send_details = array();
        $send_details['user_id'] = $user_id;
        $type = 'reset_googleAuth';
        $email = $this->validation_model->getUserEmailId($user_id);
        $send_details['full_name'] = $this->validation_model->getUserFullName($user_id);
        $send_details['email'] = $e_mail;
        $send_details['first_name'] = $this->validation_model->getUserData($user_id, "user_detail_name");
        $send_details['last_name'] = $this->validation_model->getUserData($user_id, "user_detail_second_name");
        return $this->mail_model->sendAllEmails($type, $send_details, $user_id);
    }

    public function updatePasswordOut($user_id, $pass_word, $key) {
        $this->db->select('keyword');
        $this->db->where('user_id', $user_id);
        $this->db->where('reset_status', 'no');
        $this->db->order_by('password_reset_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('password_reset_table');
        $db_key = $query->row_array()['keyword'];

        $keyword_decode = urldecode($key);
        $keyword_decode = str_replace("_", "/", $keyword_decode);
        $keyword_decode = $this->encrypt->decode($keyword_decode);

        if ($db_key != $keyword_decode) {
            return 0;
        }

        $encrypted_password = password_hash($pass_word, PASSWORD_DEFAULT);
        $this->db->set("password", $encrypted_password);
        $this->db->where("id", $user_id);
        $result_1 = $this->db->update("ft_individual");
        $this->db->set("reset_status", 'yes');
        $this->db->where("keyword", $keyword_decode);
        $result_2 = $this->db->update("password_reset_table");

        if ($result_1 && $result_2) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getUserDetailFromKey($resetkey) {
        $id = NULL;
        $this->db->select("user_id");
        $this->db->from("password_reset_table");
        $this->db->where("keyword", $resetkey);
        $this->db->where("reset_status", "no");
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $id = $row->user_id;
        }
        if ($id != "") {
            $username = $this->idFromToUserNameOut($id);
            $arr[] = $id;
            $arr[] = $username;

            return $arr;
        } else {

            $arr[] = "";
            return $arr;
        }
    }

    public function setGocKey($user_id,$secret_key) {
        $this->db->set('goc_key',$secret_key);
        $this->db->where('id',$user_id);
        $this->db->update('ft_individual');
    }
    public function idFromToUserNameOut($user_id) {
        $this->db->select("user_name");
        $this->db->from("ft_individual");
        $this->db->where("id", $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row)
            return $row->user_name;
    }

    public function updatePurchaseWallet($user_id, $from_id, $total_amount, $amount_type, $leg_id, $ewallet_id, $type='credit', $date = '') {
        $perc            = $this->getPurchaseIncomeConfig();
        $purchase_amount = ($total_amount * $perc)/100;
        if($purchase_amount > 0) {
            $this->db->set('purchase_wallet', "purchase_wallet + $purchase_amount",FALSE);
            $this->db->set('balance_amount', "balance_amount - $purchase_amount", FALSE);
            $this->db->where('user_id', $user_id);
            $this->db->limit(1);
            $res = $this->db->update('user_balance_amount');
            if($res) {
                $this->insertPurchasewalletHistory($user_id, $from_id, $total_amount, $purchase_amount, $amount_type, $type, $ewallet_id, 0, $date);
                $this->updateLegamount($user_id, $purchase_amount, $leg_id);
                $this->updateEwallethistory($user_id, $purchase_amount, $ewallet_id);
            }
        }
        return $purchase_amount;
    }

    public function getPurchaseIncomeConfig() {
        if($this->MODULE_STATUS['purchase_wallet'] == "yes") {
            $this->db->select('purchase_income_perc');
            $this->db->from('configuration');
            $res = $this->db->get();
            return $res->row_array()['purchase_income_perc'];
        } else {
            return 0;
        }
    }

    public function insertPurchasewalletHistory($user_id, $from_id, $total_amount, $purchase_amount, $amount_type, $type, $ewallet_id, $trans_id=0, $date = '',$tds='0') {
        $this->db->set('user_id', $user_id);
        $this->db->set('from_user_id', $from_id,FALSE);
        $this->db->set('ewallet_refid', $ewallet_id);
        $this->db->set('transaction_id', $trans_id);
        $this->db->set('amount', $total_amount);
        $this->db->set('purchase_wallet', $purchase_amount);
        $this->db->set('amount_type', $amount_type);
        $this->db->set('type', $type);
        $this->db->set('tds', $tds);
        if($date != '') {
            $this->db->set('date', $date);
        }
        $rs = $this->db->insert('purchase_wallet_history');
        return $rs;
    }

    public function updateLegamount($user_id, $purchase_amount, $id) {
        $this->db->set('purchase_wallet', round($purchase_amount, 8));
        $this->db->where('id',$id);
        $this->db->where('user_id',$user_id);
        $this->db->update('leg_amount');
    }

    public function updateEwallethistory($user_id, $purchase_amount, $id) {
        $this->db->set('purchase_wallet', round($purchase_amount, 8));
        $this->db->where('id',$id);
        $this->db->where('user_id',$user_id);
        $this->db->update('ewallet_history');
    }

    public function getPurchaseWalletAmount($user_id) {
        $this->db->select('purchase_wallet');
        $this->db->from('user_balance_amount');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row)
            return $row->purchase_wallet;
    }

    public function getThemeSetting()
    {
        $theme_setting = [];
        $user_type = $this->LOG_USER_TYPE;
        if ($user_type == 'employee') {
            $user_type = 'admin';
        }
        if (DEMO_STATUS == 'yes' && $this->isPresetDemo($this->getAdminId()) && $this->session->has_userdata('inf_theme_setting')) {
            $theme_setting = $this->session->userdata('inf_theme_setting');
        }
        else {
            if ($this->db->table_exists('theme_setting')) {
                $this->db->where('user_type', $user_type);
                $query = $this->db->get('theme_setting');
                $theme_setting = $query->row_array();
            }
        }

        return json_encode($theme_setting);
    }

    public function updateThemeSetting($data)
    {
        $res = false;
        $user_type = $this->LOG_USER_TYPE;
        if ($user_type == 'employee') {
            $user_type = 'admin';
        }
        if (DEMO_STATUS == 'yes' && $this->isPresetDemo($this->getAdminId())) {
            $theme_setting = [
                'theme_id' => $data['themeID'],
                'navbar_header_color' => $data['navbarHeaderColor'],
                'navbar_collapse_color' => $data['navbarCollapseColor'],
                'aside_color' => $data['asideColor'],
                'header_fixed' => $data['headerFixed'],
                'aside_fixed' => $data['asideFixed'],
                'aside_folded' => $data['asideFolded'],
                'aside_dock' => $data['asideDock'],
                'container' => $data['container'],
            ];
            $this->session->set_userdata('inf_theme_setting', $theme_setting);
        }
        else {
            if ($this->db->table_exists('theme_setting')) {
                $this->db->set('theme_id', $data['themeID']);
                $this->db->set('navbar_header_color', $data['navbarHeaderColor']);
                $this->db->set('navbar_collapse_color', $data['navbarCollapseColor']);
                $this->db->set('aside_color', $data['asideColor']);
                $this->db->set('header_fixed', $data['headerFixed']);
                $this->db->set('aside_fixed', $data['asideFixed']);
                $this->db->set('aside_folded', $data['asideFolded']);
                $this->db->set('aside_dock', $data['asideDock']);
                $this->db->set('container', $data['container']);
                $this->db->where('user_type', $user_type);
                $res = $this->db->update('theme_setting');
            }
        }
        return $res;
    }
    public function resetGoogleAuthentication($user_id)
    {
        $this->db->set('goc_key', NULL);
        $this->db->where('id', $user_id);
        $result = $this->db->update('ft_individual');
        return $result;
    }
    public function updateGocKey($user_id , $secret_key)
    {
        $this->db->set('goc_key', $secret_key);
        $this->db->where('id', $user_id);
        $result = $this->db->update('ft_individual');
        return $result;
    }

    public function checkkeyAvailability($user_id, $key) {
        $this->db->select('reset_status');
        $this->db->where('user_id', $user_id);
        $this->db->where('keyword', $key);
        $this->db->order_by('password_reset_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('googleAuth_reset_table');
        return $query->row('reset_status');
    }

    public function updateForceLogout($user_id, $value) {

        $this->db->set('force_logout' , $value);
        $this->db->where('id', $user_id);
        $result = $this->db->update("ft_individual");
        return $result;
    }

    public function forceLogout($id) {

        $flag = false;
        $this->db->select('force_logout');
        $this->db->from("ft_individual");
        $this->db->where('id', $id);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $force_logout = $row->force_logout;
        }

        if ($force_logout == 1) {
            $flag = true;
        } else {
            $flag = false;
        }
        return $flag;
    }

    public function getProductidFromProdID($prod_id) {
        $MODULE_STATUS = $this->trackModule();
        if ($MODULE_STATUS['opencart_status'] != "yes" || $MODULE_STATUS['opencart_status_demo'] != "yes") {
            $this->db->select("product_id");
            $this->db->from("package");
            $this->db->where("prod_id", $prod_id);
            $query = $this->db->get();
        } else {
            $this->db->select('package_id AS product_id');
            $this->db->where('package_id', $prod_id);
            $query = $this->db->get('oc_product'); 
        }
        foreach ($query->result() as $row) {
            $product_id = $row->product_id;
        }
        return $product_id;
    }

    public function getCompensationConfig($key) {
        if (is_array($key)) {
            $key = implode(',', $key);
        }
        $this->db->select($key);
        $query = $this->db->get('compensations');
        if ($query->num_fields() > 1) {
            return $query->row_array();
        }
        else {
            return $query->row_array()[$key];
        }
    }
    public function getMaxLevel() {
        $this->db->select_max('level_no');
        $result = $this->db->get('level_commision')->row();
        return $result->level_no;
    }

    public function getRankColor($rank) {
        $rank_color = NULL;
        $this->db->select('rank_color');
        $this->db->from('rank_details');
        $this->db->where('rank_id', $rank);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $rank_color = $row->rank_color;
        }
        return $rank_color;
    }
    
    public function getUserActiveReferralCount($user_id) {
        $this->db->where('sponsor_id', $user_id);
        $this->db->where('active', 'yes');
        $count = $this->db->count_all_results('ft_individual');
        return $count;
    }
    
    public function getUserJoinType($user_id) {
        $join_type = "";
        $this->db->select('join_type');
        $this->db->where('id', $user_id);
        $res = $this->db->get('ft_individual');
        foreach ($res->result_array() as $row) {
            $join_type = $row['join_type'];
        }
        return $join_type;
    }
    
    public function getRankConfig($key) {
        if (is_array($key)) {
            $key = implode(',', $key);
        }
        $this->db->select($key);
        $query = $this->db->get('rank_configuration');
        if ($query->num_fields() > 1) {
            return $query->row_array();
        } else {
            return $query->row_array()[$key];
        }
    }
     public function getUserID($user_name) {
       /* $this->db->select('id');
        $this->db->from('ft_individual');
        $this->db->where('user_name', $user_name);
        $res = $this->db->get();
        $row = $res->result_array();
       
        $user_id = $row[0]['id'];
        return $user_id;*/
        
         $user_id = 0;
        $this->db->select('id');
        $this->db->from('ft_individual');
        $this->db->where('user_name', $user_name);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_id = $row->id;
        }
        return $user_id;
    }
           public function getAllModules(){
        $packages = array();
        $i=0;
        $this->db->select('name,ocp.product_id');
        $this->db->from('oc_product as pd');
        $this->db->where('language_id','1');
        $this->db->where('(ocp.product_id = 28 or ocp.product_id = 29)');
        $this->db->join("oc_product_description as ocp", "pd.product_id = ocp.product_id", "INNER");
        $query = $this->db->get();
         //print_r($query->result_array()); exit();
        foreach($query->result_array() as $row){
            $packages[$i]['video_module_name'] = $row['name'];
             $packages[$i]['module_id'] = $row['product_id'];
            $i++;
        }

        return $packages;
         //print_r($packages); exit();
    }
    
    public function getRankIdFromRankname($rank_name=''){
        $rank_id = 0;
        $this->db->select('rank_id');
        $this->db->from('rank_details');
        $this->db->where('rank_name',$rank_name);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $rank_id = $row->rank_id;
        }
        return $rank_id;
    }
    
    public function getUserLegDetails($user_id){
        $data = array();
        $this->db->select('total_left_count,total_right_count');
        $this->db->from('leg_details');
        $this->db->where('id',$user_id);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $data = $row;
        }
        return $data;
    }
    
    public function getUserChildCount($user_id) {
        $this->db->where('father_id', $user_id);
        $count = $this->db->count_all_results('ft_individual');
        return $count;
    }
    
    public function getPositionUser($father_id, $postion) {
        $id_child = 0;
        $this->db->select("id");
        $this->db->from("ft_individual");
        $this->db->where('father_id', $father_id);
        $this->db->where('position', $postion);
        $this->db->where('active !=', 'server');
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $id_child = $row->id;
        }
        return $id_child;
    }
    
    //code added by aiswaryaj
     public function getDownlineUsersCount($left_no, $right_no, $type, $pv) {

        $child_nodes = array();
        $count = 0;

        $this->db->select('f.id,f.personal_pv');
        $this->db->from('ft_individual f');
        $this->db->join('tree_parser t', 't.ft_id = f.id', 'LEFT');
        $this->db->where("t.left_$type >", $left_no);
        $this->db->where("t.right_$type <", $right_no);

        if ($this->MLM_PLAN != "Binary") {
            $this->db->order_by("f.order_id", "ASC");
        } else {
            $this->db->order_by("f.position", "ASC");
        }
        $query = $this->db->get();

        foreach ($query->result_array() AS $rows) {

            $count++;
            $pv += $rows['personal_pv'];
        }
        $child_nodes['count'] = $count + 1;
        $child_nodes['total_pv'] = $pv;
     
        return $child_nodes;
    }
    
}
