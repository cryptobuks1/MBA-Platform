<?php

class ModelExtensionPaymentEwallet extends Model {

    public function getMethod($address, $total) {
        $this->load->language('extension/payment/ewallet');

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int) $this->config->get('ewallet_geo_zone_id') . "' AND country_id = '" . (int) $address['country_id'] . "' AND (zone_id = '" . (int) $address['zone_id'] . "' OR zone_id = '0')");

        if ($this->config->get('ewallet_total') > 0 && $this->config->get('ewallet_total') > $total) {
            $status = false;
        } elseif (!$this->config->get('ewallet_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }

        $method_data = array();

        if ($status) {
            $method_data = array(
                'code' => 'ewallet',
                'title' => $this->language->get('text_title'),
                'terms' => '',
                'sort_order' => $this->config->get('ewallet_sort_order')
            );
        }

        return $method_data;
    }

    function updateUserbalanceAmount($user_id, $amount) {
        $res = $this->db->query("UPDATE `" . MLM_DB_PREFIX . "user_balance_amount` SET balance_amount=	balance_amount - '" . $amount . "' WHERE user_id='" . $user_id . "'");
        return $res;
    }

    function insertUsedEwallet($used_user_id, $user_id, $total_amount, $used_for, $pending_id = 0) {
        $date = date('Y-m-d H:i:s');
        if (empty($user_id)) {
            $user_id = 'NULL';
        }
        $transaction_id = $this->getUniqueTransactionId();
        
        $res = $this->db->query("INSERT INTO `" . MLM_DB_PREFIX . "ewallet_payment_details` (used_user_id, used_amount, user_id, used_for, pending_id, date) VALUES ('" . $used_user_id . "', '" . $total_amount . "', " . $user_id . ", '" . $used_for . "', '" . $pending_id . "', '" . $date . "')");
        $ewallet_id = $this->db->getLastId();
        $this->addEwalletHistory($used_user_id, $user_id, $ewallet_id, 'ewallet_payment', $total_amount, $used_for, 'debit', $transaction_id, '', 0, $pending_id);
        return $res;
    }

    function amountTypeToId($amount_type) {
        $query = $this->db->query("SELECT `id` FROM `" . MLM_DB_PREFIX . "amount_type` WHERE `db_amt_type` = '$amount_type'");
        if ($query->row)
            return $query->row['id'];
    }

    function getUserBalanceAmount($user_id) {
        $query = $this->db->query("SELECT `balance_amount` FROM `" . MLM_DB_PREFIX . "user_balance_amount` WHERE user_id = '$user_id'");
        if ($query->row)
            return $query->row['balance_amount'];
    }

    function validateUsername($username) {
        $query = $this->db->query("SELECT id FROM `" . MLM_DB_PREFIX . "ft_individual` WHERE user_name='" . $username . "' AND active = 'yes'");
        if (count($query->row) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function validateTranPassword($user_id, $tran_password) {
        $query = $this->db->query("SELECT tran_password FROM `" . MLM_DB_PREFIX . "tran_password` WHERE user_id='" . $user_id . "' LIMIT 1");
        if (count($query->row) > 0) {
            $password_hash = $query->row['tran_password'];
            $password_matched = password_verify($tran_password, $password_hash);
            if ($password_hash && $password_matched) {
                return true;
            }
            else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getOrderTotal($order_id) {
        $query = $this->db->query("SELECT value FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int) $order_id . "' AND code = 'total'");

        return $query->row['value'];
    }
    
    public function addEwalletHistory($user_id, $from_id, $ewallet_id, $ewallet_type, $amount, $amount_type, $type, $transaction_id = '', $transaction_note = '', $transaction_fee = 0, $pending_id = FALSE) {
        $date = date('Y-m-d H:i:s');
        if (empty($pending_id)) {
            $pending_id = 'NULL';
        }
        if (empty($from_id)) {
            $from_id = 'NULL';
        }
        $res = $this->db->query("INSERT INTO `" . MLM_DB_PREFIX . "ewallet_history` (user_id, from_id, ewallet_id, ewallet_type, amount, amount_type, type, pending_id, transaction_id, transaction_note, transaction_fee, date_added) VALUES ('" . $user_id . "', " . $from_id . ", '" . $ewallet_id . "', '" . $ewallet_type . "', '" . $amount . "', '" . $amount_type . "', '" . $type . "', " . $pending_id . ", '" . $transaction_id . "', '" . $transaction_note . "', '" . $transaction_fee . "', '" . $date . "')");
        return $res;
    }
    public function getUniqueTransactionId() {
        $date = date('Y-m-d H:i:s');
        $code = $this->getRandStr(9, 9);
        $res = $this->db->query("INSERT INTO `" . MLM_DB_PREFIX . "transaction_id` (transaction_id) VALUES ('" . $code . "')");
        return $code;
    }

    public function getRandStr() {
        $key = "";
        $charset = "0123456789";
        $length = 10;
        for ($i = 0; $i < $length; $i++)
            $key .= $charset[(mt_rand(0, (strlen($charset) - 1)))];

        $randum_number = $key;
        $query = $this->db->query("SELECT id FROM `" . MLM_DB_PREFIX . "transaction_id` WHERE transaction_id = '$randum_number'");
        if (count($query->row) > 0) {
            $this->getRandStr();
        } else {
           return $key;
        }
    }

}
