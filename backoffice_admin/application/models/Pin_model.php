<?php

class pin_model extends inf_model
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('validation_model');
    }

    var $active_pin = array();
    var $all_pin = array();
    var $used_pin = array();
    var $active_search = array();

    public function getActivePins($page, $limit)
    {
        $date = date("Y-m-d");
        $this->db->select("*");
        $this->db->from("pin_numbers");
        $this->db->where("status", "yes");
        $this->db->where('pin_expiry_date >=', $date);
        $this->db->where('pin_balance_amount >', 0);
        $this->db->order_by("pin_id", "DESC");
        $this->db->limit($limit, $page);
        $search_my_active = $this->db->get();

        $i = 0;

        $cnt = $search_my_active->num_rows();
        if ($cnt > 0) {
            foreach ($search_my_active->result_array() as $search_active) {
                $this->active_pin["detail$i"]["pin_id"] = $search_active['pin_id'];
                $this->active_pin["detail$i"]["pin"] = $search_active['pin_numbers'];
                $this->active_pin["detail$i"]["pin_alloc_date"] = $search_active['pin_alloc_date'];
                $this->active_pin["detail$i"]["used_user"] = $search_active['used_user'];
                $this->active_pin["detail$i"]["pin_uploded_date"] = $search_active['pin_uploded_date'];
                $this->active_pin["detail$i"]["status"] = $search_active['status'];
                $this->active_pin["detail$i"]["pin_amount"] = $search_active["pin_amount"];
                $this->active_pin["detail$i"]["pin_bal_amount"] = $search_active["pin_balance_amount"];
                $this->active_pin["detail$i"]["pin_expiry_date"] = $search_active["pin_expiry_date"];
                if ($search_active['allocated_user_id'] != "NA") {
                    $this->active_pin["detail$i"]["allocated_user"] = $this->validation_model->IdToUserName($search_active['allocated_user_id']);
                } else
                    $this->active_pin["detail$i"]["allocated_user"] = "NULL";

                $i++;
            }
        }

        return $this->active_pin;
    }

    public function deleteActivePins($page, $limit)
    {
        $date = date("Y-m-d");
        $this->db->select("pin_id,pin_numbers");
        $this->db->from("pin_numbers");
        $this->db->where("status", "yes");
        $this->db->where('pin_expiry_date >=', $date);
        $this->db->where('pin_balance_amount >', 0);
        $this->db->order_by("pin_id", "DESC");
        $this->db->limit($limit, $page);
        $search_my_active = $this->db->get();
        $cnt = $search_my_active->num_rows();
        if ($cnt > 0) {
            $this->load->model('ewallet_model');
            foreach ($search_my_active->result_array() as $search_active) {
                $this->db->set('status', 'delete');
                $this->db->where('pin_id', $search_active['pin_id']);
                $this->db->update('pin_numbers');

                $this->db->set('status', 'delete');
                $this->db->where('pin_numbers', $search_active['pin_numbers']);
                $this->db->update('pin_purchases');

                $pin_id = $search_active['pin_id'];
                if ($this->isPurchasedPin($pin_id) && $this->isNotExpiredPin($pin_id)) {
                    $pin_detail = $this->getPinInfo($pin_id);
                    $this->ewallet_model->updateBalanceAmountDetailsTo($pin_detail['allocated_user_id'], $pin_detail['pin_balance_amount']);

                    $ewallet_id = $pin_id;
                    $this->validation_model->addEwalletHistory($pin_detail['allocated_user_id'], 0, $ewallet_id, 'pin_purchase', $pin_detail['pin_balance_amount'], 'pin_purchase_delete', 'credit', $pin_detail['transaction_id']);
                }
            }
        }
        return TRUE;
    }

    public function deleteInactivePins($page, $limit)
    {
        $date = date("Y-m-d");
        $this->db->select('pin_id,pin_numbers');
        $this->db->where('status !=', 'delete');
        $this->db->group_start();
        $this->db->where('status', 'no');
        $this->db->or_where('pin_expiry_date <', $date);
        $this->db->or_where('pin_balance_amount', 0);
        $this->db->group_end();
        $this->db->order_by('pin_alloc_date', 'DESC');
        $this->db->limit($limit, $page);
        $search_my_active = $this->db->get('pin_numbers');

        $cnt = $search_my_active->num_rows();
        if ($cnt > 0) {
            $this->load->model('ewallet_model');
            foreach ($search_my_active->result_array() as $search_active) {
                $this->db->set('status', 'delete');
                $this->db->where('pin_id', $search_active['pin_id']);
                $this->db->update('pin_numbers');

                $this->db->set('status', 'delete');
                $this->db->where('pin_numbers', $search_active['pin_numbers']);
                $this->db->update('pin_purchases');

                $pin_id = $search_active['pin_id'];
                if ($this->isPurchasedPin($pin_id) && $this->isNotExpiredPin($pin_id)) {
                    $pin_detail = $this->getPinInfo($pin_id);
                    $this->ewallet_model->updateBalanceAmountDetailsTo($pin_detail['allocated_user_id'], $pin_detail['pin_balance_amount']);

                    $ewallet_id = $pin_id;
                    $this->validation_model->addEwalletHistory($pin_detail['allocated_user_id'], 0, $ewallet_id, 'pin_purchase', $pin_detail['pin_balance_amount'], 'pin_purchase_delete', 'credit', $pin_detail['transaction_id']);
                }
            }
        }
        return TRUE;
    }

    public function insertPinRequest($req_user, $cnt, $request_date, $expiry_date, $pin_amount)
    {

        $array = array('req_user_id' => $req_user, 'req_pin_count' => $cnt, 'req_rec_pin_count' => $cnt, 'req_date' => $request_date, 'status' => 'yes', 'pin_amount' => $pin_amount, 'pin_expiry_date' => $expiry_date);
        $this->db->set($array);
        $res = $this->db->insert('pin_request');
        return $res;
    }

    public function getInactivePins($page, $limit)
    {
        $date = date("Y-m-d");
        $this->inactive_pin = array();

        $this->db->where('status !=', 'delete');
        $this->db->group_start();
        $this->db->where('status', 'no');
        $this->db->or_where('pin_expiry_date <', $date);
        $this->db->or_where('pin_balance_amount', 0);
        $this->db->group_end();
        $this->db->order_by('pin_id', 'DESC');
        $this->db->limit($limit, $page);
        $search_my_active = $this->db->get('pin_numbers');

        $i = 0;
        $cnt = $search_my_active->num_rows();
        if ($cnt > 0) {
            foreach ($search_my_active->result_array() as $search_active) {
                $this->inactive_pin["detail$i"]["pin_id"] = $search_active['pin_id'];
                $this->inactive_pin["detail$i"]["pin"] = $search_active['pin_numbers'];
                $this->inactive_pin["detail$i"]["pin_alloc_date"] = $search_active['pin_alloc_date'];
                $this->inactive_pin["detail$i"]["used_user"] = $search_active['used_user'];
                $this->inactive_pin["detail$i"]["pin_uploded_date"] = $search_active['pin_uploded_date'];
                $this->inactive_pin["detail$i"]["status"] = $search_active['status'];
                $this->inactive_pin["detail$i"]["pin_amount"] = $search_active["pin_amount"];
                $this->inactive_pin["detail$i"]["pin_bal_amount"] = $search_active["pin_balance_amount"];
                $this->inactive_pin["detail$i"]["pin_expiry_date"] = $search_active["pin_expiry_date"];
                if ($search_active['allocated_user_id'] != "NA") {
                    $this->inactive_pin["detail$i"]["allocated_user"] = $this->validation_model->IdToUserName($search_active['allocated_user_id']);
                } else
                    $this->inactive_pin["detail$i"]["allocated_user"] = "NULL";


                $i++;
            }
        }

        return $this->inactive_pin;
    }

    public function getAllActivePinspage($purchase_status = '')
    {
        $date = date("Y-m-d");
        $this->db->select("*");
        $this->db->from("pin_numbers");
        $this->db->where('status', 'yes');
        $this->db->where('pin_expiry_date >=', $date);
        $this->db->where('pin_balance_amount >', 0);
        if ($purchase_status != '') {
            $this->db->where('purchase_status', 'yes');
        }
        $numrows = $this->db->count_all_results();
        return $numrows;
    }

    public function getAllInactivePinspage()
    {
        $date = date("Y-m-d");

        $this->db->where('status !=', 'delete');
        $this->db->group_start();
        $this->db->where('status', 'no');
        $this->db->or_where('pin_expiry_date <', $date);
        $this->db->or_where('pin_balance_amount', 0);
        $this->db->group_end();
        $cnt = $this->db->count_all_results('pin_numbers');

        return $cnt;
    }

    public function insertPasscode($passcode, $status, $pin_uploded_date, $generated_user, $allocate_id, $pin_amount, $expiry_date, $pin_alloc_date, $purchase_status = "")
    {
        $used_user = "";
        $this->db->set('pin_numbers', $passcode);
        $this->db->set('pin_alloc_date', $pin_alloc_date);
        $this->db->set('status', $status);
        $this->db->set('used_user', $used_user);
        $this->db->set('pin_uploded_date', $pin_uploded_date);
        $this->db->set('generated_user_id', $generated_user);
        $this->db->set('allocated_user_id', $allocate_id, FALSE);
        $this->db->set('pin_expiry_date', $expiry_date);
        $this->db->set('pin_amount', $pin_amount);
        $this->db->set('pin_balance_amount', $pin_amount);
        if ($purchase_status) {
            $this->db->set('purchase_status', 'yes');
        }

        $res = $this->db->insert('pin_numbers');
        return $res;
    }

    public function deletePasscode($pin_id, $action)
    {

        if ($action == 'refund')
            $type  = 'pin_purchase_refund';
        else
            $type  = 'pin_purchase_delete';

        $this->db->set('status', 'delete');
        $this->db->where('pin_id', $pin_id);
        $res = $this->db->update('pin_numbers');

        if ($res) {
            if ($this->isPurchasedPin($pin_id) && $this->isNotExpiredPin($pin_id)) {
                $this->load->model('ewallet_model');
                $pin_detail = $this->getPinInfo($pin_id);
                $this->ewallet_model->updateBalanceAmountDetailsTo($pin_detail['allocated_user_id'], $pin_detail['pin_balance_amount']);

                $ewallet_id = $pin_id;
                $this->validation_model->addEwalletHistory($pin_detail['allocated_user_id'], 0, $ewallet_id, 'pin_purchase', $pin_detail['pin_balance_amount'], $type, 'credit', $pin_detail['transaction_id']);
            }
        }

        return $res;
    }

    public function getPinInfo($pin_id)
    {
        $this->db->select('allocated_user_id,pin_balance_amount,transaction_id');
        $this->db->where('pin_id', $pin_id);
        $res = $this->db->get('pin_numbers');
        return $res->row_array();
    }

    public function isNotExpiredPin($pin_id)
    {
        $this->db->from('pin_numbers pn');
        $this->db->where('pn.pin_id', $pin_id);
        $this->db->where('DATE(pn.pin_expiry_date) >', 'DATE(NOW())', FALSE);
        return $this->db->count_all_results();
    }

    public function isPurchasedPin($pin_id)
    {
        $this->db->from('pin_numbers pn');
        $this->db->join('pin_purchases pp', 'pn.pin_numbers = pp.pin_numbers');
        $this->db->where('pn.pin_id', $pin_id);
        return $this->db->count_all_results();
    }

    public function updatePasscode($pin_id, $status)
    {
        $this->db->set("status", $status);
        $this->db->where("pin_id", $pin_id);

        $res = $this->db->update("pin_numbers");

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

    public function updatePinRequest($id, $rem_count, $pin_count)
    {
        $date = date('Y-m-d');
        if ($pin_count == $rem_count) {
            $this->db->where('req_id', $id);
            $this->db->set('status', 'no');
            $res = $this->db->update('pin_request');
        } else {
            $pin_count = $rem_count - $pin_count;

            $data = array('req_pin_count' => $pin_count, 'req_rec_pin_count' => $pin_count);
            $this->db->where('req_id', $id);
            $res = $this->db->update('pin_request', $data);
        }

        return $res;
    }

    public function getMaxPinCount()
    {
        $this->db->select('pin_maxcount');
        $query = $this->db->get('pin_config');
        foreach ($query->result_array() as $row) {
            $maxpincount = $row['pin_maxcount'];
        }
        return $maxpincount;
    }

    public function getFreePins($page, $limit)
    {
        $date = date('Y-m-d');
        $user_type = $this->LOG_USER_TYPE;
        $user_id = $this->LOG_USER_ID;
        if ($user_type == "admin") {
            $this->db->select("*");
            $this->db->from("pin_numbers");
            $this->db->where("allocated_user_id", "NA");
            $this->db->where("status", "yes");
            $this->db->limit($limit, $page);
            $search_my_active = $this->db->get();
        } else {
            $this->db->select("*");
            $this->db->from("pin_numbers");
            $this->db->where("allocated_user_id", $user_id);
            $this->db->where_in("status", ['yes', 'no']);
            $this->db->limit($limit, $page);
            $search_my_active = $this->db->get();
        }

        $i = 0;
        $cnt = $search_my_active->num_rows();
        if ($cnt > 0) {
            $date = date('Y-m-d');
            foreach ($search_my_active->result_array() as $search_active) {
                $this->active_pin["detail$i"]["pin_id"] = $search_active["pin_id"];
                $this->active_pin["detail$i"]["pin_amount"] = $search_active["pin_amount"];
                $this->active_pin["detail$i"]["pin"] = $search_active["pin_numbers"];
                $this->active_pin["detail$i"]["pin_balance_amount"] = $search_active["pin_balance_amount"];
                $this->active_pin["detail$i"]["pin_alloc_date"] = $search_active["pin_alloc_date"];
                if ($search_active["used_user"] == "")
                    $this->active_pin["detail$i"]["used_user"] = "NULL";
                else
                    $this->active_pin["detail$i"]["used_user"] = $this->validation_model->IdToUserName($search_active["used_user"]);
                if ($search_active["allocated_user_id"] == "" || $search_active["allocated_user_id"] == "NA")
                    $this->active_pin["detail$i"]["allocated_user"] = "NULL";
                else
                    $this->active_pin["detail$i"]["allocated_user"] = $this->validation_model->IdToUserName($search_active['allocated_user_id']);
                $this->active_pin["detail$i"]["pin_uploded_date"] = $search_active["pin_uploded_date"];
                $this->active_pin["detail$i"]["pin_expiry_date"] = $search_active["pin_expiry_date"];
                if ($date > $search_active["pin_expiry_date"] && $search_active["status"] == 'yes')
                    $this->active_pin["detail$i"]["status"] = 'expired';
                else
                    $this->active_pin["detail$i"]["status"] = $search_active["status"];
                $this->active_pin["detail$i"]["purchase_status"] = $search_active["purchase_status"];
                $i++;
            }
        }

        return $this->active_pin;
    }
    public function getActivePinsDefualt($page, $limit)
    {
        $user_id = $this->LOG_USER_ID;
        $date = date("Y-m-d");
        $this->db->select("*");
        $this->db->from("pin_numbers");
        $this->db->where("status", "yes");
        $this->db->where('pin_expiry_date >=', $date);
        $this->db->where('pin_balance_amount >', 0);
        $this->db->where("allocated_user_id", $user_id);
        $this->db->order_by("pin_id", "DESC");
        $this->db->limit($limit, $page);
        $search_my_active = $this->db->get();

        $i = 0;

        $cnt = $search_my_active->num_rows();
        if ($cnt > 0) {
            foreach ($search_my_active->result_array() as $search_active) {
                $this->active_pin["detail$i"]["pin_id"] = $search_active['pin_id'];
                $this->active_pin["detail$i"]["pin"] = $search_active['pin_numbers'];
                $this->active_pin["detail$i"]["pin_alloc_date"] = $search_active['pin_alloc_date'];
                $this->active_pin["detail$i"]["used_user"] = $search_active['used_user'];
                $this->active_pin["detail$i"]["pin_uploded_date"] = $search_active['pin_uploded_date'];
                $this->active_pin["detail$i"]["status"] = $search_active['status'];
                $this->active_pin["detail$i"]["pin_amount"] = $search_active["pin_amount"];
                $this->active_pin["detail$i"]["pin_balance_amount"] = $search_active["pin_balance_amount"];
                $this->active_pin["detail$i"]["pin_expiry_date"] = $search_active["pin_expiry_date"];
                if ($search_active['allocated_user_id'] != "NA") {
                    $this->active_pin["detail$i"]["allocated_user"] = $this->validation_model->IdToUserName($search_active['allocated_user_id']);
                } else
                    $this->active_pin["detail$i"]["allocated_user"] = "NULL";
                $this->active_pin["detail$i"]["purchase_status"] = $search_active["purchase_status"];
                $i++;
            }
        }

        return $this->active_pin;
    }
    public function getAllActivePinspageDefualt()
    {
        $user_id = $this->LOG_USER_ID;
        $date = date("Y-m-d");
        $this->db->select("*");
        $this->db->from("pin_numbers");
        $this->db->where('status', 'yes');
        $this->db->where('pin_expiry_date >=', $date);
        $this->db->where('pin_balance_amount >', 0);
        $this->db->where("allocated_user_id", $user_id);

        $numrows = $this->db->count_all_results();
        return $numrows;
    }
}
