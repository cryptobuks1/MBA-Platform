<?php

class profile_model extends inf_model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('registersubmit_model');
        $this->load->model('validation_model');
        $this->load->model('member_model');
    }

    public function getProfileDetails($user_id, $product_status = '')
    {
        $module_status = $this->trackModule();
        $this->db->select('*');
        $this->db->from('user_details AS u');
        $this->db->join('ft_individual AS f', 'u.user_detail_refid = f.id', 'INNER');
        $this->db->where('user_detail_refid', $user_id);
        $result = $this->db->get();
        $result_array = $result->result_array();

        $profile_details = $this->getUserDetails($result_array);
        $profile_arr['details'] = $profile_details['detail1'];
        $profile_arr['sponser'] = $this->validation_model->getSponserIdName($user_id);
        if ($product_status == "yes") {
            $profile_arr['product_name'] = $this->product_model->getPackageNameFromPackageId($profile_arr['details']['product_id'], $module_status, 'registration');
            $profile_arr['product_validity'] = $profile_details['detail1']['product_validity'];
        }
       //print_r($profile_arr); die;
        return $profile_arr;
    }

    public function getUserDetails($result_array)
    {
        //print_r($result_array); die;
        $this->load->model('country_state_model');
        $user_detail = array();

        $i = 1;
        foreach ($result_array as $row) {
            $user_detail["detail$i"]["id"] = $row["user_detail_refid"];
            $user_detail["detail$i"]["name"] = $row["user_detail_name"];
            $user_detail["detail$i"]["second_name"] = $row["user_detail_second_name"];
            $user_detail["detail$i"]["address"] = $row["user_detail_address"];
            $user_detail["detail$i"]["position"] = $row["position"];
            $user_detail["detail$i"]["country_id"] = $row["user_detail_country"];
            $user_detail["detail$i"]["state_id"] = $row["user_detail_state"];
            $user_detail["detail$i"]["pincode"] = $row["user_detail_pin"];
            $user_detail["detail$i"]["mobile"] = $row["user_detail_mobile"];
            $user_detail["detail$i"]["land"] = $row["user_detail_land"];
            $user_detail["detail$i"]["user_detail_second_name"] = $row["user_detail_second_name"];
            $user_detail["detail$i"]["user_detail_address2"] = $row["user_detail_address2"];
            $user_detail["detail$i"]["user_detail_city"] = $row["user_detail_city"];
            $user_detail["detail$i"]["email"] = $row["user_detail_email"];
            $user_detail["detail$i"]["dob"] = $row["user_detail_dob"];
            $user_detail["detail$i"]["gender"] = $row["user_detail_gender"];
            $user_detail["detail$i"]["acnumber"] = $row["user_detail_acnumber"];
            $user_detail["detail$i"]["ifsc"] = $row["user_detail_ifsc"];
            $user_detail["detail$i"]["nbank"] = $row["user_detail_nbank"];
            $user_detail["detail$i"]["user_detail_nacct_holder"] = $row["user_detail_nacct_holder"];
            $user_detail["detail$i"]["acnumber_australian"] = $row["user_detail_acnumber_australian"];
            $user_detail["detail$i"]["nacct_australian_holder"] = $row["user_detail_nacct_australian_holder"];
            $user_detail["detail$i"]["bsb"] = $row["user_detail_bsb"];
            
            $user_detail["detail$i"]["nbranch"] = $row["user_detail_nbranch"];
            $user_detail["detail$i"]["pan"] = $row["user_detail_pan"];
            $user_detail["detail$i"]["level"] = $row["user_level"];
            $user_detail["detail$i"]["date"] = $row["join_date"];
            $user_detail["detail$i"]["referral"] = $row["sponsor_id"];
            $user_detail["detail$i"]["acnumber"] = $row["user_detail_acnumber"];
            $user_detail["detail$i"]["ifsc"] = $row["user_detail_ifsc"];
            $user_detail["detail$i"]["nbank"] = $row["user_detail_nbank"];
            $user_detail["detail$i"]["user_detail_nacct_holder"] = $row["user_detail_nacct_holder"];
            $user_detail["detail$i"]["nbranch"] = $row["user_detail_nbranch"];
            $user_detail["detail$i"]["pan"] = $row["user_detail_pan"];
            $user_detail["detail$i"]["swift_code"] = $row["user_detail_swift_code"];
            
            $user_detail["detail$i"]["blocktrail_account"] = $this->encryptDecrypt($row['bitcoin_address'], "decryption");
            $user_detail["detail$i"]["paypal_account"] = $this->encryptDecrypt($row['user_detail_paypal'], "decryption");
            $user_detail["detail$i"]["blockchain_account"] = $this->encryptDecrypt($row['user_detail_blockchain_wallet_id'], "decryption");
            $user_detail["detail$i"]["bitgo_account"] = $this->encryptDecrypt($row['user_detail_bitgo_wallet_id'], "decryption");

            $user_detail["detail$i"]["facebook"] = $row["user_detail_facebook"];
            $user_detail["detail$i"]["twitter"] = $row["user_detail_twitter"];
            $user_detail["detail$i"]["product_id"] = $row["product_id"];
            $user_detail["detail$i"]["product_validity"] = $row["product_validity"];
            $user_detail["detail$i"]["country"] = $this->country_state_model->getCountryNameFromId($row['user_detail_country']);
            $user_detail["detail$i"]["state"] = $this->country_state_model->getStateNameFromId($row["user_detail_state"]);
            $user_detail["detail$i"]["father_name"] = $this->validation_model->getFullName($row["father_id"]);
            $user_detail["detail$i"]["sponsor_name"] = $this->validation_model->getFullName($row["sponsor_id"]);

            $file_name = $this->getUserPhoto($row["user_detail_refid"]);
            if (!file_exists(IMG_DIR . 'profile_picture/' . $file_name)) {
                $file_name = 'nophoto.jpg';
            }
            $banner_name = $row['user_banner'];
            if (!file_exists(IMG_DIR . 'banners/' . $row['user_banner'])) {
                $banner_name = 'banner-tchnoly.jpg';
            }
            $user_detail["detail$i"]["profile_photo"] = $file_name;
            $user_detail["detail$i"]["banner_name"] = $banner_name;
            $user_detail["detail$i"]["bank_info_required"] = $row["bank_info_required"];
            $user_detail["detail$i"]["lang_id"] = $row["default_lang"];
            $user_detail["detail$i"]["lang_name"] = $this->inf_model->getLanguageName($row['default_lang']);
            $user_detail["detail$i"]["payout_type"] = $row["payout_type"];
            $user_detail["detail$i"]["rank_name"] = $this->validation_model->getRankName($row['user_rank_id']);
            
            $user_detail["detail$i"]["join_type"] = $row["join_type"];
            $user_detail["detail$i"]["bitcoin_address"] = $row["bitcoin_address"];
            $user_detail["detail$i"]["payeer_address"] = $row["payeer_address"];

            $i++;
        }
//print_r($user_detail); die;
        return $this->replaceNullFromArray($user_detail, "NA");
    }

    public function replaceNullFromArray($user_detail, $replace = '')
    {
        if ($replace == '') {
            $replace = "NA";
        }
        $len = count($user_detail);
        $key_up_arr = array_keys($user_detail);
        for ($i = 1; $i <= $len; $i++) {
            $k = $i - 1;
            $fild = $key_up_arr[$k];
            $arr_key = array_keys($user_detail["$fild"]);
            $key_len = count($arr_key);
            for ($j = 0; $j < $key_len; $j++) {
                $key_field = $arr_key[$j];
                if ($user_detail["$fild"]["$key_field"] == "") {
                    $user_detail["$fild"]["$key_field"] = $replace;
                }
            }
        }
        return $user_detail;
    }

    public function getUserPhoto($user_id)
    {
        $this->db->select('user_photo');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            return $row->user_photo;
        }
    }

    public function changeProfilePicture($user_id, $file_name)
    {
        $arr = array(
            'user_photo' => $file_name
        );
        $this->db->where('user_detail_refid', $user_id);
        $res = $this->db->update('user_details', $arr);
        return $res;
    }

    public function getAllBoards()
    {
        $board_array = array();
        $res = $this->db->select("board_id")->get("board_configuration");
        foreach ($res->result() as $row) {
            $board_array[] = $row->board_id;
        }
        return $board_array;
    }

    public function isUserNameAvailable($user_name)
    {
        $res = $this->validation_model->isUserNameAvailable($user_name);
        return $res;
    }

    public function isUserAvailable($user_name)
    {
        $this->db->select("COUNT(id) as count");
        $this->db->from("ft_individual");
        $this->db->where('user_name', $user_name);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $count = $row->count;
        }

        return $count;
    }

    public function getBusinessVolumeDetails($limit = '', $page = '', $user_id = '')
    {
        $details = array();
        $this->db->select('*');

        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        if ($limit) {
            $this->db->limit($limit, $page);
        }
        $query = $this->db->get('business_volume');
        $i = 0;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $details[$i]['user_name'] = $this->validation_model->IdToUserName($row->user_id);
                $details[$i]['from_name'] = $this->validation_model->IdToUserName($row->from_id);
                $details[$i]['left_leg'] = $row->left_leg;
                $details[$i]['left_leg_carry'] = $row->left_carry;
                $details[$i]['right_leg'] = $row->right_leg;
                $details[$i]['right_leg_carry'] = $row->right_carry;
                $details[$i]['amount_type'] = $row->amount_type;
                $details[$i]['date'] = $row->date_of_submission;
                $details[$i]['action'] = $row->action;
                $i++;
            }
        }
        return $details;
    }

    public function getTotalBusinessVolumeCount($user_id = '')
    {
        $count = 0;
        $this->db->select('COUNT(*) AS cnt');
        $this->db->from('business_volume');
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $count = ($row->cnt > 0) ? $row->cnt : 0;
        }
        return $count;
    }

    public function updatePersonalInfo($user_id, $data, $opencart_status)
    {
        $this->db->set('user_detail_name', $data['first_name']);
        $this->db->set('user_detail_second_name', $data['last_name']);
        $this->db->set('user_detail_gender', $data['gender']);
        $this->db->set('user_detail_dob', $data['dob']);
        $this->db->where('user_detail_refid', $user_id);
        $res1 = $this->db->update('user_details');

        if ($opencart_status) {
            $oc_customer_id = $this->validation_model->getOcCustomerId($user_id);

            $this->db->set('firstname', $data['first_name']);
            $this->db->set('lastname', $data['last_name']);
            $this->db->where('customer_id', $oc_customer_id);
            $res2 = $this->db->update('oc_customer');

            $this->db->set('firstname', $data['first_name']);
            $this->db->set('lastname', $data['last_name']);
            $this->db->where('customer_id', $oc_customer_id);
            $res3 = $this->db->update('oc_address');

            return $res1 && $res2 && $res3;
        }

        return $res1;
    }

    public function updateContactInfo($user_id, $data, $opencart_status)
    {
        $this->db->set('user_detail_address', $data['address']);
        $this->db->set('user_detail_address2', $data['address2']);
        $this->db->set('user_detail_country', $data['country']);
        if (!empty($data['state'])) {
            $this->db->set('user_detail_state', $data['state']);
        }
        $this->db->set('user_detail_city', $data['city']);
        $this->db->set('user_detail_mobile', $data['mobile']);
        $this->db->set('user_detail_land', $data['land_line']);
        $this->db->set('user_detail_email', $data['email']);
        $this->db->set('user_detail_pin', $data['pincode']);
        $this->db->where('user_detail_refid', $user_id);
        $res1 = $this->db->update('user_details');

        if ($opencart_status) {
            $oc_customer_id = $this->validation_model->getOcCustomerId($user_id);

            $this->db->set('email', $data['email']);
            $this->db->set('telephone', $data['mobile']);
            $this->db->where('customer_id', $oc_customer_id);
            $res2 = $this->db->update('oc_customer');

            $this->db->set('address_1', $data['address']);
            $this->db->set('address_2', $data['address2']);
            $this->db->set('city', $data['city']);
            $this->db->set('postcode', $data['pincode']);
            $this->db->set('country_id', $data['country']);
            $this->db->set('zone_id', $data['state']);
            $this->db->where('customer_id', $oc_customer_id);
            $res3 = $this->db->update('oc_address');

            return $res1 && $res2 && $res3;
        }

        return $res1;
    }

    public function updateBankInfo($user_id, $data)
    {
       // print_r($data); die;
        $this->db->set('user_detail_acnumber', $data['account_no']);
        $this->db->set('user_detail_ifsc', $data['ifsc']);
        $this->db->set('user_detail_nbank', trim($data['bank_name']));
        $this->db->set('user_detail_nacct_holder', trim($data['account_holder']));
        $this->db->set('user_detail_acnumber_australian', trim($data['acnumber_australian']));
        $this->db->set('user_detail_nacct_australian_holder', trim($data['australian_account_holder']));
        $this->db->set('user_detail_bsb', trim($data['bsb']));
        $this->db->set('user_detail_nbranch', trim($data['branch_name']));
        
        //$this->db->set('user_detail_pan', $data['pan']);
        $this->db->where('user_detail_refid', $user_id);
        $this->db->where('bank_info_required', 'yes');
        $res1 = $this->db->update('user_details');

        return $res1;
    }

    public function updateSocialProfile($user_id, $data)
    {
        $this->db->set('user_detail_facebook', $data['facebook']);
        $this->db->set('user_detail_twitter', $data['twitter']);
        $this->db->where('user_detail_refid', $user_id);
        $res1 = $this->db->update('user_details');

        return $res1;
    }

    public function updatePaymentDetails($user_id, $data)
    {
        if (isset($data['paypal_account'])) {
            $paypal_account = $this->encryptDecrypt($data['paypal_account'], "encryption");
            $this->db->set('user_detail_paypal', $paypal_account);
        }
        if (isset($data['blockchain_account'])) {
            $blockchain_account = $this->encryptDecrypt($data['blockchain_account'], "encryption");
            $this->db->set('user_detail_blockchain_wallet_id', $blockchain_account);
        }
        if (isset($data['bitgo_account'])) {
            $bitgo_account = $this->encryptDecrypt($data['bitgo_account'], "encryption");
            $this->db->set('user_detail_bitgo_wallet_id', $bitgo_account);
        }
        if (isset($data['blocktrail_account'])) {
            $blocktrail_account = $this->encryptDecrypt($data['blocktrail_account'], "encryption");
            $this->db->set('bitcoin_address', $blocktrail_account);
        }
        if (isset($data['payment_method'])) {
            $this->db->set('payout_type', $data['payment_method']);
        }
        $this->db->where('user_detail_refid', $user_id);
        $res1 = $this->db->update('user_details');

        return $res1;
    }

    public function encryptDecrypt($value, $type)
    {
        $key = $this->config->item('encryption_key');
        $rs = null;
        if (!empty($value)) {
            if ($type == "encryption") {
                $rs = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $value, MCRYPT_MODE_CBC, md5(md5($key))));
            }
            if ($type == "decryption") {
                $rs = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($value), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
            }
        }
        return $rs;
    }

    public function getActivePaymentGateway()
    {
        $details = array();
        $this->db->select('gateway_name,payout_status');
        $this->db->from('payment_gateway_config');
        $this->db->where('payout_status', 'yes');
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result() as $row) {
            $details[$i]['gateway_name'] = $row->gateway_name;
            $i++;
        }
        return $details;
    }


    //GDPR Functions Starts
    public function addForgetRequest($user_id)
    {
        $this->db->set('user_id', $user_id);
        $this->db->set('status', 'yes');
        $res = $this->db->insert('forget_request');
        return $res;
    }

    public function checkForgetRequest($user_id = '')
    {
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        $this->db->where('status', 'yes');
        $count = $this->db->count_all_results('forget_request');
        return $count;
    }

    public function getForgetRequests()
    {
        $this->db->select('fr.*,f.user_name');
        $this->db->from('forget_request as fr');
        $this->db->join('ft_individual AS f', 'fr.user_id = f.id', 'INNER');
        $this->db->where('fr.status', 'yes');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function approveForgetRequest($id, $user_id)
    {
        $res = false;
        $result = $this->backup_user_details($user_id);
        if ($result) {
            $this->db->where('user_id', $user_id);
            // $this->db->where('id', $id);
            $this->db->set('status', 'forget');
            $res = $this->db->update('forget_request');
        }
        return $res;
    }

    public function backup_user_details($user_id)
    {
        $this->db->select('*');
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        $ft_result = base64_encode(json_encode($query->result_array()));

        $this->db->select('*');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $query1 = $this->db->get();
        $user_result = base64_encode(json_encode($query1->result_array()));

        $this->db->set('ft_details', $ft_result);
        $this->db->set('user_details', $user_result);
        $res = $this->db->insert('user_forget_history');

        return $res;
    }

    public function rejectForgetRequest($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->set('status', 'rejected');
        $res = $this->db->update('forget_request');
        return $res;
    }
    //GDPR Functions Ends

    //KYC Upload Functions Starts
    public function getMyKycDoc($user_id)
    {
        $details = [];
        $this->db->select('k.*,c.category');
        $this->db->from('kyc_docs as k');
        $this->db->join('kyc_category AS c', 'k.type = c.id', 'INNER');
        $this->db->where('user_id', $user_id);
        $this->db->where('k.status !=', 'deleted');
        $query = $this->db->get();

        $i = 0;
        foreach ($query->result_array() as $row) {
            $details[$i] = $row;
            $details[$i]['file_name'] = unserialize($row['file_name']);
            switch ($row['status']) {
                case "pending":
                    $details[$i]['font_class'] = 'warning';
                    break;
                case "rejected":
                    $details[$i]['font_class'] = 'danger';
                    break;
                default:
                    $details[$i]['font_class'] = 'success';
            }
            $i++;
        }
        return $details;
    }

    public function InsertIdentityProof($insert_array, $user_id, $category)
    {
        $ins = serialize($insert_array);
        $this->db->set('file_name', $ins);
        $this->db->set('status', 'pending');
        $this->db->set('type', $category);
        $this->db->set('user_id', $user_id);
        $result = $this->db->insert('kyc_docs');
        return $result;
    }

    public function checkKycDocs($user_id, $category = '')
    {
        $this->db->select("COUNT(id) as count");
        $this->db->from('kyc_docs');
        $this->db->where('user_id', $user_id);
        if ($category) {
            $this->db->where('type', $category);
        }
        $this->db->group_start()
            ->where('status', 'approved')
            ->or_where('status', 'pending')
            ->group_end();
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $count = $row->count;
        }
        if ($count > 0) {
            return true;
        }
        return false;
    }

    public function checkKycDocsExist($user_id)
    {
        $this->db->select("COUNT(id) as count");
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 'approved');
        $query = $this->db->get('kyc_docs');
        $count = $this->db->count_all_results();
          if ($count > 0) {
                    return false;
                }
       

    }

    //KYC Upload Functions Ends

    //KYC Verify Functions Starts
    public function getPendingKyc($user_id = '', $type = '', $status = '')
    {
        $i = 0;
        $details = array();
        $this->db->select('kyc.*,ft.user_name, ud.user_detail_name, ud.user_detail_second_name,c.category');
        $this->db->from('kyc_docs as kyc');
        $this->db->join('ft_individual as ft', 'ft.id=kyc.user_id', 'inner');
        $this->db->join('user_details as ud', 'ft.id=ud.user_detail_refid', 'inner');
        $this->db->join('kyc_category AS c', 'kyc.type = c.id', 'INNER');
        if ($user_id) {
            $this->db->where('kyc.user_id', $user_id);
        }
        if ($status) {
            $this->db->where('kyc.status', $status);
        }
        if ($type) {
            $this->db->where('kyc.type', $type);
        }
        $this->db->where('kyc.status !=', 'deleted');
        $this->db->order_by('kyc.date', 'asc');
        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            $details[$i]['user_name']   = $row['user_name'];
            $details[$i]['category']    = $row['category'];
            $details[$i]['type']        = $row['type'];
            $details[$i]['status']      = $row['status'];
            $details[$i]['reason']      = $row['reason'];
            $details[$i]['file_name']   = unserialize($row['file_name']);
            $details[$i]['full_name']   = $row['user_detail_name'] . " " . $row['user_detail_second_name'];
            switch ($row['status']) {
                case "pending":
                    $details[$i]['font_class'] = 'warning';
                    break;
                case "rejected":
                    $details[$i]['font_class'] = 'danger';
                    break;
                default:
                    $details[$i]['font_class'] = 'success';
            }
            $i++;
        }

        return $details;
    }

    public function verifyKyc($user_id, $type)
    {
        $this->db->set('status', 'approved');
        $this->db->set('reason', '');
        $this->db->where('user_id', $user_id);
        $this->db->where('type', $type);
        $this->db->where('status', 'pending');
        $result = $this->db->update('kyc_docs');

        if ($result) {
            $this->db->set('kyc_status', 'yes');
            $this->db->where('user_detail_refid', $user_id);
            $this->db->update('user_details');
        }
        return $result;
    }

    public function rejectKyc($user_id, $type, $reason)
    {
        $this->db->set('status', 'rejected');
        $this->db->set('reason', $reason);
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 'pending');
        $this->db->where('type', $type);
        $result = $this->db->update('kyc_docs');
        return $result;
    }

    public function deletetKyc($id, $user_id)
    {
        $this->db->set('status', 'deleted');
        $this->db->where('id', $id);
        $result = $this->db->update('kyc_docs');
        if ($result) {
            $exist  = $this->checkKycDocsExist($user_id);
            if (!$exist) {
                $this->db->set('kyc_status', 'no');
                $this->db->where('user_detail_refid', $user_id);
                $this->db->update('user_details');
            }
        }
        return $result;
    }
    //KYC Verify Functions Ends
    public function changeBannerImage($user_id, $file_name)
    {
        $arr = array(
            'user_banner' => $file_name
        );
        $this->db->where('user_detail_refid', $user_id);
        $res = $this->db->update('user_details', $arr);
        return $res;
    }
    public function getBannerPic($user_id)
    {

        $file_name = $this->getUserPhoto($user_id);
        if (!file_exists(IMG_DIR . 'profile_picture/' . $file_name)) {
            $file_name = 'na';
        }
        $this->db->select('user_banner');
        $this->db->where('user_detail_refid', $user_id);
        $banner_name = $this->db->get('user_details')->row()->user_banner;
        if (!file_exists(IMG_DIR . 'banners/' . $banner_name)) {
            $banner_name = 'banner-tchnoly.jpg';
        }
        return [
            'user_banner' => $banner_name,
            'user_image' => $file_name,
        ];
    }
    
    public function getTotalRankCount($user_id='') {
        $count = 0;
        $this->db->select('COUNT(*) AS cnt');
        $this->db->from('user_rewards');
        if($user_id){
            $this->db->where('user_id', $user_id);
        }
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $count = ($row->cnt > 0) ? $row->cnt : 0;
        }
        return $count;
    }
    
    public function getRankDetails($limit= '', $page= '', $user_id= ''){
        
        $details = array();
        $this->db->select('*');
        
        if($user_id){
            $this->db->where('user_id', $user_id);
        }
        if($limit){
            $this->db->limit($limit, $page);
        }
        $query = $this->db->get('user_rewards');
        $i = 0 ;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $details[$i]['user_name'] = $this->validation_model->IdToUserName($row->user_id);
                $details[$i]['rank_name'] = $this->validation_model->getRankName($row->rank_id);
                
                $details[$i]['reward'] = $row->reward;
                
                $details[$i]['date'] = $row->date;
                $i++;
            }
        }
        return $details;
    }
    
     public function updateWalletInfo($user_id, $data) {

        $this->db->set('bitcoin_address', $data['bitcoin_address']);
        $this->db->set('payeer_address', $data['payeer_address']);
        $this->db->where('user_detail_refid', $user_id);
        $res1 = $this->db->update('user_details');

        return $res1;
    }
}
