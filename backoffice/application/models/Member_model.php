<?php

class member_model extends inf_model {

    public function __construct() {
        $this->load->library('inf_phpmailer', NULL, 'phpmailer');

        $this->load->model('validation_model');
    }

    public function searchMembers($keyword, $page, $limit) {

        $this->load->model('country_state_model');
        $this->db->select("fi.*, ud.*");
        $this->db->from("ft_individual as fi");
        $this->db->join("user_details as ud", "ud.user_detail_refid = fi.id", "INNER");
        $where = array('fi.user_name' => $keyword, 'ud.user_detail_name' => $keyword, 'ud.user_detail_address' => $keyword, 'ud.user_detail_mobile' => $keyword);
        $this->db->group_start()
                ->or_like($where)
                ->or_like("CONCAT( ud.user_detail_name,' ',ud.user_detail_second_name)", $keyword)
                ->group_end();
        $this->db->order_by("fi.id");
        $this->db->limit($limit, $page);
        $query = $this->db->get();

        $cnt = $query->num_rows();
        $this->search_user = null;
        if ($cnt > 0) {
            $i = 0;

            foreach ($query->result_array() as $row) {

                $this->search_user["detail$i"]["user_id"] = $row['id'];
                $id_encode = $this->encrypt->encode($row['user_name']);
                $id_encode = str_replace("/", "_", $id_encode);
                $this->search_user["detail$i"]["user_id_en"] = $encrypt_id;

                $this->search_user["detail$i"]["user_name"] = $row['user_name'];
                $this->search_user["detail$i"]["active"] = $row['active'];
                $this->search_user["detail$i"]["father_id"] = $row['father_id'];
                $this->search_user["detail$i"]["sponser_name"] = $this->validation_model->IdToUserName($row['sponsor_id']);
                if (!$this->search_user["detail$i"]["sponser_name"]) {
                    $this->search_user["detail$i"]["sponser_name"] = "NA";
                }
                $this->search_user["detail$i"]["user_detail_name"] = $row['user_detail_name'];
                $this->search_user["detail$i"]["user_detail_name"] .= " " . $row['user_detail_second_name'];
                if ($row['user_detail_address'] != "")
                    $this->search_user["detail$i"]["user_detail_address"] = $row['user_detail_address'];
                else
                    $this->search_user["detail$i"]["user_detail_address"] = "NA";
                if ($row['user_detail_mobile'])
                    $this->search_user["detail$i"]["user_detail_mobile"] = $row['user_detail_mobile'];
                else
                    $this->search_user["detail$i"]["user_detail_mobile"] = "NA";
                if ($row['user_detail_country'])
                    $this->search_user["detail$i"]["user_detail_country"] = $this->country_state_model->getCountryNameFromId($row['user_detail_country']);
                else
                    $this->search_user["detail$i"]["user_detail_country"] = "NA";
                $this->search_user["detail$i"]["date_of_joining"] = $row['date_of_joining'];
                $this->search_user["detail$i"]["rank"] = $this->validation_model->getRankName($row['user_rank_id']);
                $this->search_user["detail$i"]["rank_color"] = $this->validation_model->getRankColor($row['user_rank_id']);
                $i++;
            }
        }

        return $this->search_user;
    }

    public function getCountMembers($keyword) {
        $this->db->select("fi.id, ud.user_detail_refid");
        $this->db->from("ft_individual as fi");
        $this->db->join("user_details as ud", "ud.user_detail_refid = fi.id", "INNER");
        $where = array('fi.user_name' => $keyword, 'ud.user_detail_name' => $keyword, 'ud.user_detail_address' => $keyword, 'ud.user_detail_mobile' => $keyword);
        $this->db->group_start()
                ->or_like($where)
                ->or_like("CONCAT( ud.user_detail_name,' ',ud.user_detail_second_name)", $keyword)
                ->group_end();
        $count = $this->db->count_all_results();

        return $count;
    }

    public function activateAccount($user_id, $type = 'auto') {
        $result = FALSE;
        $this->db->set('active', 'yes');
        $this->db->where('id', $user_id);
        $res = $this->db->update('ft_individual');
        if ($res) {
            $result = $this->usertActivationDeactivationHistory($user_id, $type, 'activated');
        }
        return $result;
    }

    public function usertActivationDeactivationHistory($user_id, $type, $status = '') {
        $this->db->set('user_id', $user_id);
        $this->db->set('type', $type);
        $this->db->set('status', $status);
        $result = $this->db->insert('user_activation_deactivation_history');
        return $result;
    }

    public function inactivateAccount($user_id, $type = 'auto') {
        $result = FALSE;
        $this->db->set('active', 'no');
        $this->db->where('id', $user_id);
        $res = $this->db->update('ft_individual');
        if ($res) {
            $result = $this->usertActivationDeactivationHistory($user_id, $type, 'deactivated');
        }
        return $result;
    }

    public function getLeadDetails($user_id = '', $keyword = '', $limit = '', $offset = '') {
        $this->db->select('l.id,f.user_name sponser_name,l.first_name,l.last_name,l.email_id email,l.skype_id,l.country,l.mobile_no phone,l.date,l.lead_status status');
        $this->db->from('crm_leads l');
        $this->db->join('ft_individual f', 'l.added_by = f.id');
        if ($keyword != '') {
            $where = array('l.first_name' => $keyword, 'l.last_name ' => $keyword, 'l.email_id' => $keyword, 'l.mobile_no' => $keyword, 'l.country' => $keyword, 'l.skype_id' => $keyword);
            $this->db->group_start()
                    ->or_like($where)
                    ->group_end();
        }
        if ($user_id) {
            $this->db->where('l.added_by', $user_id);
        }
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $res = $this->db->get();
        return $res->result_array();
    }

    public function getLeadDetailsCount($user_id = '', $keyword = '') {
        $this->db->from('crm_leads l');
        if ($keyword != '') {
            $where = array('l.first_name' => $keyword, 'l.last_name ' => $keyword, 'l.email_id' => $keyword, 'l.mobile_no' => $keyword, 'l.country' => $keyword, 'l.skype_id' => $keyword);
            $this->db->or_group_start()
                    ->or_like($where)
                    ->group_end();
        }
        if ($user_id) {
            $this->db->where('l.added_by', $user_id);
        }
        return $this->db->count_all_results();
    }

    public function getLeadDetailsById($id) {
        $this->load->model('country_state_model');
        $leads = array();
        $this->db->select('*');
        $this->db->from('crm_leads');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $res = $query = $this->db->get();
        foreach ($res->result_array() as $row) {
            $row['sponser_name'] = $this->validation_model->IdToUserName($row['added_by']);
            $row['country'] = $this->country_state_model->getCountryNameFromId($row['country']);
            $leads = $row;
        }

        return $leads;
    }

    public function addFollowup($det) {
        if ($det['admin_comment']) {
            $this->db->set('description', $det['admin_comment']);
            $this->db->set('lead_id', $det['lead_id']);
            $this->db->set('followup_entered_by', $this->LOG_USER_ID);
            $this->db->set('date', date('Y-m-d H:i:s'));
            return $this->db->insert('crm_followups');
        }
    }

    public function updateCRM($det) {
        $this->db->set('lead_status', $det['status']);
        $this->db->where('id', $det['lead_id']);
        return $this->db->update('crm_leads');
    }

    public function IdToUserName($user_id) {
        $user_name = NULL;
        $this->db->select('user_name');
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_name = $row->user_name;
        }
        return $user_name;
    }

    public function getadmin_name() {
        return $this->validation_model->getAdminUsername();
    }

    public function sendInvites($invite_details, $user_id) {
        $flag = 0;
        $myArray = explode(',', $invite_details['to_mail_id']);
        foreach ($myArray as $row) {
            $result = $this->sendInviteMails($invite_details['subject'], $invite_details['message'], $row);
            if ($result) {
                $flag = 1;
                $date = date('Y-m-d H:i:s');
                $this->db->set('user_id', $user_id);
                $this->db->set('mail_id', $row);
                $this->db->set('subject', $invite_details['subject']);
                $this->db->set('message', $invite_details['message']);
                $this->db->set('date', $date);
                $this->db->insert('invite_history');
            }
        }
        return $flag;
    }

    public function sendInviteMails($subject, $message, $email) {
        $regr = array();
        $mailBodyDetails = '<table border="1" width="100%" align="center">            
                             <tr>
                               <td><b>Name: </b>' . $subject . '</td>
                             </tr>
                             <tr>
                               <td><b>Membership ID #: </b>USA' . $message . '</td>
                             </tr>
                            </table>';
//        $result = $this->sendMail($mailBodyDetails, $subject, $email);
        $regr['mail_content'] = $mailBodyDetails;
        $regr['email'] = $email;
        $regr['first_name'] = '';
        $regr['last_name'] = '';

        $result = $this->mail_model->sendAllEmails('invaite_mail', $regr, array());
        return $result;
    }

    public function getInviteHistory($user_id, $limit, $offset) {
        $this->db->select('mail_id,subject,message,date');
        $this->db->from('invite_history');
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        $this->db->limit($limit, $offset);
        $res = $this->db->get();
        return $res->result_array();
    }

    public function getInviteHistoryCount($user_id) {
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        return $this->db->count_all_results('invite_history');
    }

    public function insertTextInvites($details) {
        $date = date('Y-m-d');
        $this->db->set('subject', $details['subject']);
        $this->db->set('content', $details['mail_content']);
        $this->db->set('uploaded_date', $date);
        $this->db->set('type', 'text');
        $res = $this->db->insert('invites_configuration');

        return $res;
    }

    public function getTextInvitesData($limit, $offset) {
        $this->db->select('id,subject,content,uploaded_date');
        $this->db->from('invites_configuration');
        $this->db->where('type', 'text');
        $this->db->order_by('id');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getTextInvitesDataCount() {
        $this->db->where('type', 'text');
        return $this->db->count_all_results('invites_configuration');
    }

    public function getAdminComent($lead_id) {
        $i = 0;
        $mail_details = array();
        $this->db->select('*');
        $this->db->from('crm_followups');
        $this->db->where('lead_id', $lead_id);
        $this->db->order_by('date', 'desc');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $leads["detail$i"]['id'] = $row->description;
            $i++;
        }
        return $query->result_array();
    }

    public function getTextInvitesDataById($id) {
        $mail_details = array();
        $this->db->select('*');
        $this->db->from('invites_configuration');
        $this->db->where('type', 'text');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $this->db->order_by('id');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $mail_details = $row;
        }
        return $mail_details;
    }

    public function editTextInvites($details) {
        $this->db->set('subject', $details['subject']);
        $this->db->set('content', $details['mail_content']);
        $this->db->where('id', $details['id']);
        $res = $this->db->update('invites_configuration');

        return $res;
    }

    public function deleteInviteText($id) {
        $this->db->where('id', $id);
        return $this->db->delete('invites_configuration');
    }

    public function insertsocialInvites($details, $type) {
        $this->db->set('subject', $details['subject']);
        $this->db->set('content', $details['message']);
        $this->db->set('type', $type);
        $res = $this->db->insert('invites_configuration');

        return $res;
    }

    public function getSocialInviteDataCount($type) {
        $this->db->where('type', $type);
        return $this->db->count_all_results('invites_configuration');
    }

    public function getSocialInviteData($type, $limit, $offset) {
        $social_details = array();
        $this->db->select('*');
        $this->db->from('invites_configuration');
        $this->db->where('type', $type);
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $social_details[$i]['id'] = $row['id'];
            $social_details[$i]['type'] = $row['type'];
            $subject = stripslashes($row['subject']);
            $content = stripslashes($row['content']);
            $subject1 = trim($subject);
            $content1 = trim($content);
            $subject2 = str_replace("\n", '', $subject1);
            $content2 = str_replace("\n", '', $content1);
            $social_details[$i]['subject'] = html_entity_decode($subject2);
            $social_details[$i]['content'] = html_entity_decode($content2);
            $i++;
        }
        return $social_details;
    }

    public function insertBanner($file_name, $target_url, $name) {
        $date = date('Y-m-d');
        $this->db->set('subject', $name);
        $this->db->set('target_url', $target_url);
        $this->db->set('content', $file_name);
        $this->db->set('type', 'banner');
        $this->db->set('uploaded_date', $date);
        return $res = $this->db->insert('invites_configuration');
    }

    public function getBanners($limit, $offset) {
        $this->db->select('id,subject,content,target_url,uploaded_date');
        $this->db->from('invites_configuration');
        $this->db->where('type', 'banner');
        $this->db->order_by('id');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getBannersCount() {
        $this->db->where('type', 'banner');
        return $this->db->count_all_results('invites_configuration');
    }

    public function deleteBanner($id) {
        $this->db->where('id', $id);
        return $this->db->delete('invites_configuration');
    }

    public function getPackageExpiredUsers($admin_id, $user_id, $page = '', $limit = '') {
        $user_details = array();
        $today = date("Y-m-d 23:59:59");

        $this->db->select('id,user_name,product_validity,sponsor_id,ft.active,p.active');
        $this->db->select('ft.product_id');
        $this->db->from('ft_individual ft');
        $this->db->join("package as p", "p.prod_id = ft.product_id", "LEFT");
//        if($user_id ==''){
//        $this->db->where("product_validity <", $today);
//        }
        $this->db->where('id !=', $admin_id);
        $this->db->where('ft.product_id !=', '');
        $this->db->where('p.active !=', 'deleted');
        if ($user_id) {
            $this->db->where('id', $user_id);
        }
        if ($limit) {
            $this->db->limit($limit, $page);
        }

        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $user_details[$i]['user_id'] = $row['id'];

            $id_encode = $this->encrypt->encode($row['user_name']);
            $id_encode = str_replace("/", "_", $id_encode);
            $encrypt_id = urlencode($id_encode);

            $user_details[$i]['user_name'] = $row['user_name'];
            $user_details[$i]['product_validity'] = $row['product_validity'];
            $user_details[$i]['sponsor_name'] = $this->validation_model->IdToUserName($row['sponsor_id']);
            $user_details[$i]['encrypt_id'] = $encrypt_id;
            $user_details[$i]['product_id'] = $row['product_id'];
            $user_details[$i]['user_img'] = $this->validation_model->getUserImage($row['id']);
            $i++;
        }
        return $user_details;
    }

    public function getPackageExpiredUsersCount($admin_id, $user_id = '') {
        $count = 0;
        $today = date("Y-m-d H:i:s");

        $this->db->select('id,p.active');
        $this->db->from('ft_individual ft');
        $this->db->join("package as p", "p.prod_id = ft.product_id", "LEFT");
        //   $this->db->where('product_validity <', $today);
        $this->db->where('id !=', $admin_id);
        $this->db->where('p.active !=', 'deleted');
        if ($user_id) {
            $this->db->where('id', $user_id);
        }

        $query = $this->db->get();
        $count = $query->num_rows();
        return $count;
    }

    public function packageValidityUpgrade($package_details, $purchase, $by_upgrade = FALSE, $pay_type = "manual") {
        $this->load->model('product_model');
        $today = date("Y-m-d H:i:s");
        $result = FALSE;

        $last_inserted_id = $this->getMaxPackageValidityOrderId();
        $invoice_no = 1000 + $last_inserted_id;
        $invoice_no = "VLDPCK" . $invoice_no;

        if ($by_upgrade) {
            $result = TRUE;
        } else {
            $product_pv = $this->product_model->getProductPvByPackageId($package_details[0]['id']);
            $this->db->set('user_id', $purchase['user_id']);
            $this->db->set('invoice_id', $invoice_no);
            $this->db->set('package_id', $package_details[0]['id']);
            $this->db->set('payment_type_used', $purchase['by_using']);
            $this->db->set('total_amount', $purchase['total_amount']);
            $this->db->set('product_pv', $product_pv);
            $this->db->set('date_submitted', $today);
            $this->db->set('pay_type', $pay_type);
            $result = $this->db->insert('package_validity_extend_history');
        }

        if ($result) {
            $result = $invoice_no;
            $validity_date = $this->getValidityDate($purchase['user_id']);
            if ($validity_date < $today) {
                $expiry_date = $this->product_model->getPackageValidityDate($package_details[0]['id']);
            } else {
                $expiry_date = $this->product_model->getPackageValidityDate($package_details[0]['id'], $validity_date);
            }
            $this->db->set("product_validity", $expiry_date);
            $this->db->where('id', $purchase['user_id']);
            $update_ft = $this->db->update('ft_individual');
            if (!$update_ft) {
                return FALSE;
            }
        }

        return $result;
    }

    public function getMaxPackageValidityOrderId() {
        $max_id = 0;
        $this->db->select_max('id');
        $this->db->from('package_validity_extend_history');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $max_id = $row->id;
        }
        return $max_id;
    }

    public function getValidityDate($user_id) {
        $validity_date = 0;
        $this->db->select('product_validity');
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $validity_date = $row->product_validity;
        }
        return $validity_date;
    }

    public function getSocialInvitesDataById($id, $type) {
        $mail_details = array();
        $this->db->select('*');
        $this->db->from('invites_configuration');
        $this->db->where('type', $type);
        $this->db->where('id', $id);
        $this->db->limit(1);
        $this->db->order_by('id');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $mail_details = $row;
        }
        return $mail_details;
    }

    //Replication site home page 
    public function insertBannerforReplica($subject, $type, $file_name, $user_id) {
        $this->db->where('subject', $subject);
        $this->db->where('user_id', $user_id);
        $this->db->from("replica_banners");
        $count = $this->db->count_all_results();

        $this->db->set('subject', $subject);
        $this->db->set('content', $file_name);
        $this->db->set('type', $type);
        $this->db->set('user_id', $user_id);

        if ($count != '') {
            $this->db->where('subject', $subject);
            $this->db->where('user_id', $user_id);
            return $res = $this->db->update('replica_banners');
        } else {
            return $res = $this->db->insert('replica_banners');
        }
    }

    //Replication site home page ends
    public function deleteReplicaBanner($id) {
        $this->db->where('id', $id);
        return $this->db->delete('replica_banners');
    }

    public function getStatus($id) {
        $status = "no";
        $this->db->select("status");
        $this->db->from("infinite_mlm_menu");
        $this->db->where('id', $id);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $status = $row->status;
        }
        return $status;
    }

    public function upgradePackageDetails($user_id, $current_package_id, $new_package_id, $payment_type, $done_by, $module_status) {

        $this->load->model('upgrade_model');

        $this->db->set('product_id', $new_package_id);
        $this->db->where('id', $user_id);
        $res1 = $this->db->update('ft_individual');

        $data = [
            'user_id' => $user_id,
            'current_package_id' => $current_package_id,
            'new_package_id' => $new_package_id,
            'payment_type' => $payment_type,
            'done_by' => $done_by
        ];
        $res2 = $this->db->insert('package_upgrade_history', $data);

        $data2 = [
            'user_id' => $user_id,
            'package_id' => $new_package_id,
            'payment_method' => $payment_type
        ];
        $res3 = $this->db->insert('upgrade_sales_order', $data2);

        $res4 = TRUE;

        if ($module_status['roi_status'] == "yes") {
            $product_details = $this->upgrade_model->getProduct($new_package_id);
            $roi = $product_details['roi'];
            $days = $product_details['days'];
            $pack_amount = $product_details['product_value'];
            $data5 = [
                'user_id' => $user_id,
                'prod_id' => $new_package_id,
                'amount' => $pack_amount,
                'payment_method' => $payment_type,
                'roi' => $roi,
                'days' => $days
            ];

            $res4 = $this->db->insert('roi_order', $data5);
        }

        if ($module_status['product_validity'] == 'yes') {
            $package_details = [];
            $package_details[0]['id'] = $new_package_id;
            $purchase = [];
            $purchase['by_using'] = $payment_type;
            $purchase['user_id'] = $user_id;
            $purchase['total_amount'] = 0;
            $res4 = $this->packageValidityUpgrade($package_details, $purchase);
        }
        return $res1 && $res2 && $res3 && $res4;
    }

    public function getSocialInvitesTypeById($id) {

        $type = NULL;
        $this->db->select('*');
        $this->db->from('invites_configuration');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $this->db->order_by('id');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $type = $row['type'];
        }
        return $type;
    }

    public function getSocialInvitesById($id) {

        $mail_details = array();
        $this->db->select('*');
        $this->db->from('invites_configuration');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $this->db->order_by('id');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $mail_details = $row;
        }
        return $mail_details;
    }

    public function insertManualPVUpdateHistory($user_id, $new_pv, $total_pv, $old_pv, $action) {
        $date = date('Y-m-d H:i:s');
        $this->db->set('user_id', $user_id);
        $this->db->set('pv_added', $new_pv);
        $this->db->set('new_pv', $total_pv);
        $this->db->set('old_pv', $old_pv);
        $this->db->set('type', $action);
        $this->db->set('date', $date);
        $res = $this->db->insert('manual_pv_update_history');
        return $res;
    }

    public function getProductPV($product_id) {
        $pair_value = 0;
        $this->db->select("pair_value");
        $this->db->from("package");
        $this->db->where("product_id", $product_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $pair_value = $row->pair_value;
        }
        return $pair_value;
    }

    public function getCurrentProduct($user_id) {
        $product_id = NULL;
        $this->db->select("product_id");
        $this->db->from("ft_individual");
        $this->db->where("id", $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $product_id = $row->product_id;
        }
        return $product_id;
    }

    public function getPayeerSettings($type = '') {
        $details = array();
        $this->db->select('*');
        $this->db->from('payeer_settings');
        if ($type)
            $this->db->where('account', $type);
        $this->db->order_by('id', 'DESC');
        $result = $this->db->get();
        foreach ($result->result() as $row) {
            $details['merchant_id'] = $row->merchant_id;
            $details['merchant_key'] = $row->merchant_key;
            $details['encryption_key'] = $row->encryption_key;
        }
        return $details;
    }
    public function getMemberDetails($page = '', $limit = ''){
      $this->db->select('fi.*, ud.*');
      $this->db->from("ft_individual as fi");
      $this->db->join("user_details as ud", "ud.user_detail_refid = fi.id", "INNER");
      $this->db->order_by('fi.date_of_joining' , 'desc');
      $this->db->limit($limit, $page);
      $result = $this->db->get();
      
      return $result->result_array();
    }
    public function getMemberDetailsPOfUser($user_id){
      $this->db->select('fi.*, ud.*');
      $this->db->from("ft_individual as fi");
      $this->db->join("user_details as ud", "ud.user_detail_refid = fi.id", "INNER");
      $this->db->where('fi.id',$user_id);
      $result = $this->db->get();
      
      return $result->result_array();
    }
public function updateDefaultLegs($user_id,$left_leg) {
        $this->db->set('default_leg', $left_leg);
            $this->db->where('id',$user_id);
        return $this->db->update('ft_individual');
        
    }
    public function getDefaultLegs($user_id){
        $this->db->select('default_leg');
        $this->db->from("ft_individual");
        $this->db->where('id',$user_id);
        $query = $this->db->get();
        return $query->result_array();
 }
     public function getcalender(){
      $this->db->select('*');
      $this->db->from("calender_events");
      $result = $this->db->get();      
      return $result->result_array();
    }
    public function getallcalender($limit = '', $page = '',$from='',$to=''){
             $date = date("Y-m-d H:i:s");

        if (!isset($to) || trim($to) === '') {
            $to = $date;
        }
          if(!$from)
          {
            $this->db->select('*');
            $this->db->from("calender_events");       
            $this->db->limit($limit, $page);
            $this->db->order_by('start', 'asc');
            $result = $this->db->get();
          }
          else
          {
            $this->db->select('*');
            $this->db->from("calender_events");       
            $this->db->limit($limit, $page);
            $this->db->where('start >=', $from);
            $this->db->where('start <=', $to);
            $this->db->order_by('start', 'asc');
            $result = $this->db->get();
          }

      
      return $result->result_array();
    }
            public function getcountcalender($from='',$to=''){
             $date = date("Y-m-d H:i:s");

        if (!isset($to) || trim($to) === '') {
            $to = $date;
        }
          if(!$from)
          {
            $this->db->select('*');
            $this->db->from("calender_events");       
            //$this->db->limit($limit, $page);
            $this->db->order_by('start', 'asc');
            $result = $this->db->get();
          }
          else
          {
            $this->db->select('*');
            $this->db->from("calender_events");       
           // $this->db->limit($limit, $page);
            //$this->db->where('start', $date);
            $this->db->where('start >=', $from);
            $this->db->where('start <=', $to);
            $this->db->order_by('start', 'asc');
            $result = $this->db->get();
          }

      
      return $result->result_array();
    }

}
