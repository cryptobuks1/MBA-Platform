<?php

class epin_model extends inf_model
{

    public $OBJ_PIN;

    function __construct($product_status = '11')
    {
        parent::__construct();
        if (isset($this->uri->segments[1]) && $this->uri->segments[1] != 'mobile' && isset($this->inf_model->MODULE_STATUS['product_status'])) {
            $this->MODULE_STATUS = $this->inf_model->MODULE_STATUS;
            $product_status = $this->MODULE_STATUS['product_status'];
        }
        $this->load->model('misc_model');

        require_once 'Pin_model.php';

        $this->OBJ_PIN = new pin_model();

        if ($product_status == "yes") {
            $this->load->model('product_model');
        }
        $this->load->model('validation_model');
    }

    public function generatePasscode($cnt, $status, $uploded_date, $pin_amount, $expiry_date, $pin_alloc_date, $purchase_status = '')
    {
        for ($i = 0; $i < $cnt; $i++) {
            $passcode = $this->misc_model->getRandStr(9, 9);

            $generated_user = $this->LOG_USER_ID;
            $user_type = $this->LOG_USER_TYPE;
            if ($user_type == 'employee') {
                $this->load->model('validation_model');
                $generated_user = $this->validation_model->getAdminId();
            }
            if ($this->LOG_USER_TYPE == 'admin' || $this->LOG_USER_TYPE == 'employee') {
                $allocated_user = "NULL";
            } else {
                $allocated_user = $generated_user;
            }
            $res = $this->OBJ_PIN->insertPasscode($passcode, $status, $uploded_date, $generated_user, $allocated_user, $pin_amount, $expiry_date, $pin_alloc_date, $purchase_status = '');
        }
        return $res;
    }

    public function pinSelector($page, $limit, $pages_selection, $keyword = "", $keyword1 = "")
    {
        $arr = array();

        switch ($pages_selection) {
            case 'generate':
                $arr['pin_numbers'] = $this->OBJ_PIN->getFreePins($page, $limit);
                break;
            case 'search':
                if ($keyword == "") {
                    $arr['pin_numbers'] = "";
                    $arr['numrows'] = "";
                }
                if ($keyword) {
                    $arr['pin_numbers'] = $this->OBJ_PIN->getAllPinsearch($keyword, $page, $limit);
                    $arr['numrows'] = $this->OBJ_PIN->getAllPinsearchpage($keyword);
                }
                if ($keyword1) {
                    $limit = $page + $limit;
                    $arr['pin_numbers'] = $this->OBJ_PIN->getAllPinsearchProd($keyword1, $page, $limit);
                    $arr['numrows'] = $this->OBJ_PIN->getAllPinsearchProdpage($keyword1);
                }
                break;
            case 'active':
                $arr['pin_numbers'] = $this->OBJ_PIN->getActivePins($page, $limit);
                $arr['numrows'] = $this->OBJ_PIN->getAllActivePinspage();
                break;
            case 'inactive':
                $arr['pin_numbers'] = $this->OBJ_PIN->getInactivePins($page, $limit);
                $arr['numrows'] = $this->OBJ_PIN->getAllInactivePinspage();
                break;
            case 'delete':
                $arr['pin_numbers'] = $this->OBJ_PIN->getAllPins($page, $limit);
                $arr['numrows'] = $this->OBJ_PIN->getAllPinspage();
                break;
            case 'defualt':
                $arr['pin_numbers'] = $this->OBJ_PIN->getActivePinsDefualt($page, $limit);
                $arr['numrows'] = $this->OBJ_PIN->getAllActivePinspageDefualt();
                break;
        }
        return $arr;
    }

    public function getUserFreePinCount()
    {
        $user_id = $this->LOG_USER_ID;
        $this->db->select("count(*) as cnt");
        $this->db->from("pin_numbers");
        $this->db->where("allocated_user_id", $user_id);
        $this->db->where_in("status", ['yes', 'no']);

        $search_my_active = $this->db->get();
        foreach ($search_my_active->result() as $row) {
            return $row->cnt;
        }
    }

    public function updateEPin($delete_id, $status)
    {
        return $this->OBJ_PIN->updatePasscode($delete_id, $status);
    }

    public function deleteEpin($delete_id, $action = '')
    {
        return $this->OBJ_PIN->deletePasscode($delete_id, $action);
    }

    public function deleteAllEPin($pin_status, $page, $limit)
    {
        if ($pin_status != 'Active') {
            $pin_status = 'Blocked';
        }
        $result = false;
        switch ($pin_status) {
            case 'Active':
                $result = $this->OBJ_PIN->deleteActivePins($page, $limit);
                break;
            case 'Blocked':
                $result = $this->OBJ_PIN->deleteInactivePins($page, $limit);
                break;
            default:
                $result = false;
        }
        return $result;
    }

    public function ifChecked($id, $pin_count, $pin_alloc_date, $status, $uploded_date, $admin_id, $allocate_id, $rem_count, $amount, $expiry_date)
    {

        for ($m = 0; $m < $pin_count; $m++) {
            $passcode = $this->misc_model->getRandStr(9, 9);
            $res = $this->OBJ_PIN->insertPasscode($passcode, $status, $uploded_date, $admin_id, $allocate_id, $amount, $expiry_date, $pin_alloc_date);
        }
        $res = $this->OBJ_PIN->updatePinRequest($id, $rem_count, $pin_count);
        return $res;
    }

    public function viewEpinRequest($pro_status, $limit = '', $page = '')
    {

        $pin_detail_arr = $this->getAllPinRequest($limit, $page);
        $arr_length = count($pin_detail_arr);
        for ($i = 0; $i < $arr_length; $i++) {

            $user_id = $pin_detail_arr["detail$i"]["user_id"];
            $pin_detail_arr["detail$i"]["user_name"] = $this->validation_model->IdToUserName($user_id);
        }
        return $pin_detail_arr;
    }

    public function getAllPinRequestCount($read_status = '')
    {
        $this->db->select('count(*) as cnt');
        $this->db->from("pin_request");
        $this->db->where("status", "yes");
        if ($read_status)
            $this->db->where('read_status', $read_status);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function setEpinViewed($to_read_status)
    {
        $this->db->set('read_status', $to_read_status++);
        $this->db->where('read_status', $to_read_status);
        $this->db->update('pin_request');
        return;
    }
    public function insertPinRequest($req_user, $cnt, $request_date, $expiry_date, $pin_amount)
    {


        return $res = $this->OBJ_PIN->insertPinRequest($req_user, $cnt, $request_date, $expiry_date, $pin_amount);
    }

    public function getAllProducts($status)
    {
        return $this->product_model->getAllProducts('yes');
    }

    public function generateEpin($user_name, $amount, $count, $expiry_date)
    {
        $user_id = $this->userNameToId($user_name);
        $user = $this->session->userdata("inf_logged_in");
        $user_type = $user["user_type"];
        $gen_user_id = $user["user_id"];
        if ($user_type == 'employee') {
            $this->load->model('validation_model');
            $gen_user_id = $this->validation_model->getAdminId();
        }
        $status = "yes";
        $uploded_date = date('Y-m-d h:m:s');
        $pin_alloc_date = date('Y-m-d h:m:s');
        if ($user_name != "" && $count != "") {
            for ($i = 0; $i < $count; $i++) {
                $passcode = $this->misc_model->getRandStr(9, 9);
                $res = $this->insertPasscode($passcode, $status, $uploded_date, $gen_user_id, $user_id, $amount, $expiry_date, $pin_alloc_date);
            }
            return $res;
        }
    }

    public function userNameToId($user_name)
    {

        $this->db->select("id");
        $this->db->from("ft_individual");
        $this->db->where("user_name", $user_name);
        $result = $this->db->get();

        foreach ($result->result() as $row) {

            return $row->id;
        }
    }

    public function getProductId($product_id)
    {

        $this->db->select("prod_id");
        $this->db->from("product");
        $this->db->where("product_id", $product_id);
        $result = $this->db->get();


        foreach ($result->result() as $row) {
            return $row->prod_id;
        }
    }

    public function insertPasscode($passcode, $status, $pin_uploded_date, $generated_user, $allocate_id, $amount, $expiry_date, $pin_alloc_date = "")
    {

        $array = array('pin_numbers' => $passcode, 'pin_alloc_date' => $pin_alloc_date, 'status' => $status, 'pin_uploded_date' => $pin_uploded_date, 'generated_user_id' => $generated_user, 'allocated_user_id' => $allocate_id, 'pin_amount' => $amount, 'pin_expiry_date' => $expiry_date, 'pin_balance_amount' => $amount);
        $this->db->set($array);
        $res = $this->db->insert('pin_numbers');
        return $res;
    }

    public function getAllActivePinspage()
    {
        $num = $this->OBJ_PIN->getAllActivePinspage();
        return $num;
    }

    public function getMaxPinCount()
    {
        $maxpincount = $this->OBJ_PIN->getMaxPinCount();
        return $maxpincount;
    }

    public function getPinDetailsForUser11($user_name, $limit, $page)
    {
        $arr = array();
        if ($user_name != "") {
            $user_id = $this->userNameToId($user_name);

            $this->db->select("*");
            $this->db->from("pin_numbers");
            $this->db->where("allocated_user_id", $user_id);
            $this->db->where("status", 'yes');
            $this->db->limit($limit, $page);
            $result = $this->db->get();
            $i = 0;
            foreach ($result->result_array() as $row) {

                $arr[$i]["pin_numbers"] = $row['pin_numbers'];
                $arr[$i]["pin_uploded_date"] = $row['pin_uploded_date'];
                $arr[$i]["id"] = $row['pin_id'];
                $arr[$i]["expiry_date"] = $row['pin_expiry_date'];
                $arr[$i]["amount"] = $row['pin_amount'];
                $arr[$i]["pin_balance_amount"] = $row['pin_balance_amount'];
                $i++;
            }


            return $arr;
        }
    }

    public function getPinDetailsForUser11Count($user_name)
    {
        $user_id = $this->userNameToId($user_name);
        $this->db->select('count(*) as cnt');
        $this->db->from('pin_numbers');
        $this->db->where("allocated_user_id", $user_id);
        $this->db->where("status", 'yes');
        $result = $this->db->get();
        foreach ($result->result() as $row) {
            return $row->cnt;
        }
    }

    public function getUnallocatedPinCount()
    {
        $user_id = $this->LOG_USER_ID;
        $user_type = $this->LOG_USER_TYPE;
        if ($user_type == 'employee') {
            $this->load->model('validation_model');
            $user_id = $this->validation_model->getAdminId();
        }
        $date = date("Y-m-d");
        $this->db->select("COUNT(*) AS count");
        $this->db->from("pin_numbers");
        $this->db->where("allocated_user_id", "NA");
        $this->db->where("generated_user_id", $user_id);
        $this->db->where("status", "yes");
        $this->db->where('pin_expiry_date >=', $date);
        $this->db->where('pin_balance_amount >', 0);
        $this->db->like("status", "yes");
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            return $row->count;
        }
    }

    public function getPinDetails($pin_number, $check_status = '')
    {

        $details = array();
        $i = 0;
        $this->db->select('f.user_name allocated_user_name,p.pin_numbers pin_number,p.status,p.allocated_user_id,p.pin_uploded_date pin_uploaded_date,p.pin_expiry_date,p.pin_amount,p.pin_balance_amount,p.used_user,p.pin_id,p.purchase_status');
        $this->db->from('pin_numbers p');
        $this->db->join('ft_individual f', 'f.id = p.allocated_user_id', 'left');
        $this->db->where('p.pin_numbers', $pin_number);
        if ($check_status != '') {
            $this->db->where('p.status !=', 'delete');
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getPinSearch($amount = '', $check_status = '', $page, $limit)
    {
        $this->db->select('f.user_name allocated_user_id,p.used_user,p.status,p.pin_numbers pin_number,p.pin_uploded_date pin_uploaded_date,p.pin_expiry_date,p.pin_balance_amount,p.pin_amount,p.pin_id,p.purchase_status');
        $this->db->from('pin_numbers p');
        $this->db->join('ft_individual f', 'f.id = p.allocated_user_id', 'left');
        if ($amount != '')
            $this->db->where('p.pin_amount', $amount);
        if ($check_status != '') {
            $this->db->where('p.status !=', 'delete');
        }
        $this->db->limit($limit, $page);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getPinSearchCount($amount = '', $check_status = '')
    {
        if ($amount != '')
            $this->db->where('pin_amount', $amount);
        if ($check_status != '') {
            $this->db->where('status !=', 'delete');
        }
        return $this->db->count_all_results('pin_numbers');
    }

    public function getAllEwalletAmounts()
    {
        $i = 0;
        $amount_detail = array();
        $this->db->select('id');
        $this->db->select('amount');
        $this->db->from('pin_amount_details');
        $this->db->order_by("amount", "asc");
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $amount_detail["details$i"]["id"] = $row['id'];
            $amount_detail["details$i"]["amount"] = $row['amount'];
            $i++;
        }
        return $amount_detail;
    }

    public function addPinAmount($amount)
    {
        $this->db->set('amount', $amount);
        $res = $this->db->insert('pin_amount_details');
        return $res;
    }

    public function deletePinAmount($id)
    {
        $this->db->where('id', $id);
        $res = $this->db->delete('pin_amount_details');
        return $res;
    }

    public function check_pin_amount($amount)
    {
        $flag = false;
        $this->db->select('id');
        $this->db->from('pin_amount_details');
        $this->db->where('amount', $amount);
        $this->db->limit(1);
        $res = $this->db->get();
        $amount_avilable = $res->num_rows();
        if ($amount_avilable > 0) {
            $flag = true;
        }
        return $flag;
    }

    public function getUserPinRequestCount($user_id, $status = "no", $read_status = '')
    {
        $this->db->select('count(*) as cnt');
        $this->db->from("pin_request");
        $this->db->where("req_user_id", $user_id);
        $this->db->where("status", $status);
        if ($read_status) {
            $this->db->where("read_status", $read_status);
        }
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }
    public function deleteRequestedEpin($req_id, $remark)
    {
        $this->db->set('status', 'deleted');
        $this->db->set('remark', $remark);
        $this->db->where("req_id", $req_id);
        $result = $this->db->update("pin_request");
        return $result;
    }
    //insert configuration_change_history
    public function getPinbyId($id)
    {
        $amount = '';
        $this->db->select('amount');

        $this->db->where("id =", $id);
        $this->db->from('pin_amount_details');
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $amount = $row['amount'];
        }
        return $amount;
    }
    //

    public function epinAllocation($user_id, $epin_id)
    {
        $this->db->set('allocated_user_id', $user_id);
        $this->db->where('pin_id', $epin_id);
        return $this->db->update('pin_numbers');
    }

    public function insertEpinTransferHistory($login_id, $activity, $user_id, $from_user_id, $epin_id, $data = '', $user_type = '')
    {
        $ip_adress = $this->IP_ADDR;
        //Code to convert Ipv6 address to Ipv4
        if (!filter_var($ip_adress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false) {
            $ip_adress = hexdec(substr($ip_adress, 0, 2)) . "." . hexdec(substr($ip_adress, 2, 2)) . "." . hexdec(substr($ip_adress, 5, 2)) . "." . hexdec(substr($ip_adress, 7, 2));
        }
        $this->db->set('done_by', $login_id);
        if ($user_type != '') {
            $this->db->set('done_by_type', $user_type);
        } else {
            $this->db->set('done_by_type', $this->LOG_USER_TYPE);
        }
        $this->db->set('ip', $ip_adress);
        $this->db->set('user_id', $user_id);
        $this->db->set('from_user_id', $from_user_id);
        $this->db->set('epin_id', $epin_id);
        $this->db->set('activity', $activity);
        $this->db->set('date', date("Y-m-d H:i:s"));
        $this->db->set('data', $data);
        $result = $this->db->insert('epin_transfer_history');

        return $result;
    }

    public function getEpinList($user_id)
    {
        $i = 0;
        $date = date("Y-m-d");
        $epin_detail = array();

        $this->db->select("pin_id,pin_numbers");
        $this->db->from("pin_numbers");
        $this->db->where("status", "yes");
        $this->db->where("allocated_user_id", $user_id);
        $this->db->where('pin_expiry_date >=', $date);
        $this->db->where('pin_balance_amount >', 0);
        $this->db->where('pin_balance_amount = pin_amount');
        $this->db->order_by("pin_id", "DESC");
        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            $epin_detail["details$i"]["pin_id"] = $row['pin_id'];
            $epin_detail["details$i"]["pin_numbers"] = $row['pin_numbers'];
            $i++;
        }
        return $epin_detail;
    }
    public function EpinIdtoName($id)
    {
        $name = '';
        $this->db->select('pin_numbers');
        $this->db->where("pin_id =", $id);
        $this->db->from('pin_numbers');
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $name = $row['pin_numbers'];
        }
        return $name;
    }

    public function validateAllEpins($epin_details, $total_amount, $user_id, $upgrade_user_id = '')
    {
        $epin_valid = true;
        $epin_array = [];
        $i = 0;
        foreach ($epin_details as $v) {
            $epin_array[$i]['pin'] = $v;
            $epin_array[$i]['pin_amount'] = 0;
            $i++;
        }
        $result = [];
        foreach ($epin_array as $key => $value) {
            $epin = $value['pin'];
            $epin_details = $this->getEpinDetails($epin, $user_id, $upgrade_user_id);
            if ($epin_details) {
                $epin_amount = $epin_details['pin_amount'];
                $epin_used_amount = min($epin_amount, $total_amount);
                $epin_balance_amount = $epin_amount - $epin_used_amount;
                $total_amount = $total_amount - $epin_used_amount;
                $result[$key] = array(
                    'pin' => $epin,
                    'amount' => $epin_amount,
                    'balance_amount' => $epin_balance_amount,
                    'reg_balance_amount' => $total_amount,
                    'epin_used_amount' => $epin_used_amount
                );
            } else {
                $epin_valid = false;
                $result[$key] = array(
                    'pin' => 'nopin',
                    'amount' => 0,
                    'balance_amount' => 0,
                    'reg_balance_amount' => 0,
                    'epin_used_amount' => 0
                );
            }
        }
        $result['valid'] = $epin_valid;
        $result['amount_reached'] = $total_amount;
        return $result;
    }

    public function getEpinDetails($epin, $user_id, $upgrade_user_id = '')
    {
        $date = date('Y-m-d');
        $admin_userid = $this->validation_model->getAdminId();
        $this->db->select('pin_numbers,pin_balance_amount pin_amount,allocated_user_id');
        //$this->db->where('pin_numbers', $epin);
        $this->db->where("pin_numbers LIKE BINARY '$epin'", NULL, true);
        if ($this->LOG_USER_TYPE == 'admin' || $this->LOG_USER_TYPE == 'employee') {
            if ($upgrade_user_id != '') {
                $whr = '(allocated_user_id=' . $user_id . '  or allocated_user_id=' . $admin_userid . '  or allocated_user_id=' . $upgrade_user_id . ' or allocated_user_id="NA" )';
            } else {
                $whr = '(allocated_user_id=' . $user_id . ' or allocated_user_id="NA" )';
            }
        } else {
            $whr = '(allocated_user_id=' . $user_id . ')';
        }
        $this->db->where($whr);
        $this->db->where('pin_amount >', 0);
        $this->db->where('status', 'yes');
        $this->db->where('pin_expiry_date >=', $date);
        $this->db->limit(1);
        $query = $this->db->get('pin_numbers');
        $res = $query->row_array();
        if ($res) {
            if ($res['allocated_user_id'] == 'NA' || $res['allocated_user_id'] == $user_id  || $res['allocated_user_id'] == $upgrade_user_id || $res['allocated_user_id'] == $admin_userid) {
                return $res;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function epinPayment($pin_array, $user_id)
    {
        if (isset($pin_array['valid'])) {
            unset($pin_array['valid']);
        }
        if (isset($pin_array['amount_reached'])) {
            unset($pin_array['amount_reached']);
        }
        $date = date('Y-m-d H:i:s');
        foreach ($pin_array as $key => $value) {
            $pin_no = $value['pin'];
            $pin_balance = $value['balance_amount'];
            $pin_amount = $value['amount'];
            $status = 'yes';
            if ($pin_balance == 0) {
                $status = 'no';
            }
            $pin_balance = round($pin_balance, 8);
            $this->db->set('used_user', $user_id);
            $this->db->set('status', $status);
            $this->db->set('pin_balance_amount', round($pin_balance, 8));
            $this->db->where('pin_numbers', $pin_no);
            $this->db->where('status', 'yes');
            $res1 = $this->db->update('pin_numbers');

            $this->db->set('status', $status);
            $this->db->set('pin_number', $pin_no);
            $this->db->set('used_user', $user_id);
            $this->db->set('pin_alloc_date', $date);
            $this->db->set('pin_amount', round($pin_amount, 8));
            $this->db->set('pin_balance_amount', round($pin_balance, 8));
            $res2 = $this->db->insert('pin_used');
            if (!$res1 || !$res2) {
                return false;
            }
        }
        return true;
    }

    public function allocateEPinToUser($pin_id, $user_id)
    {
        $this->db->set('allocated_user_id', $user_id);
        $this->db->where('pin_id', $pin_id);
        $res = $this->db->update('pin_numbers');
        return $res;
    }

    public function getAllPinRequest($limit = '', $page = '')
    {
        $pin_detail_arr = array();
        $this->db->select("*");
        $this->db->from("pin_request");
        $this->db->where("status", "yes");
        $this->db->limit($limit, $page);
        $qr_pin_req = $this->db->get();

        $cnt = $qr_pin_req->num_rows();
        if ($cnt > 0) {
            $i = 0;
            foreach ($qr_pin_req->result_array() as $row_search) {
                $pin_detail_arr["detail$i"]["req_id"] = $row_search['req_id'];
                $pin_detail_arr["detail$i"]["user_id"] = $row_search['req_user_id'];
                $pin_detail_arr["detail$i"]["full_name"] = $this->validation_model->getUserFullName($row_search['req_user_id']);
                $pin_detail_arr["detail$i"]["phone_number"] = $this->validation_model->getUserPhoneNumber($row_search['req_user_id']);
                $pin_detail_arr["detail$i"]["pin_count"] = $row_search['req_pin_count'];
                $pin_detail_arr["detail$i"]["rem_count"] = $row_search['req_rec_pin_count'];
                $pin_detail_arr["detail$i"]["req_date"] = $row_search['req_date'];
                $pin_detail_arr["detail$i"]["expiry_date"] = $row_search['pin_expiry_date'];
                $pin_detail_arr["detail$i"]["amount"] = $row_search['pin_amount'];
                $i++;
            }
        }
        return $pin_detail_arr;
    }

    public function getEPinsByKeyword($letters)
    {
        $this->db->select('pin_numbers');
        $this->db->where('status !=', 'delete');
        $this->db->like('pin_numbers', $letters, 'after');
        $this->db->order_by('pin_id');
        $this->db->limit(500);
        $query = $this->db->get('pin_numbers');
        $response = [];
        foreach ($query->result_array() as $row) {
            $response[] = $row['pin_numbers'];
        }
        return $response;
    }

    public function isActivePin($pin_number)
    {

        $this->db->where('pin_id', $pin_number);
        $this->db->where('status', 'yes');
        $this->db->where('purchase_status', 'yes');
        return $this->db->count_all_results('pin_numbers');
    }

    public function CheckEpinBelongsTouser( $user_id, $pin_id)
    {
        $flag = FALSE;
        $this->db->where('allocated_user_id', $user_id);
        $this->db->where('pin_id', $pin_id);
        $count = $this->db->count_all_results('pin_numbers');
        if ($count) {
            $flag = TRUE;
        }
        return $flag;
    }
}
