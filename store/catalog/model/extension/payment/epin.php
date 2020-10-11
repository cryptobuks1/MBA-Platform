<?php

class ModelExtensionPaymentEpin extends Model {

    public function getPinDetails($epin) {
        $log_user_id = $this->customer->getUserId();
        $log_user_type = $this->customer->getUserType();
        $admin_user_id = $this->customer->getAdminUserId();
        $where = "";
        if ($log_user_type == 'admin' || $log_user_type == 'employee') {
            $where .= "(allocated_user_id = '$log_user_id' OR allocated_user_id IS NULL)";
        }
        else {
            $where .= "(allocated_user_id = '$log_user_id')";
        }
        $date = date('Y-m-d');
        $query = $this->db->query("SELECT * FROM `" . MLM_DB_PREFIX . "pin_numbers` WHERE pin_numbers LIKE BINARY '" . $this->db->escape($epin) . "' AND status = 'yes' AND pin_expiry_date >= '$date' AND pin_amount > 0 AND $where");
        if(count($query->row) == 0)
        {
            return 0;
        }
        $query = $query->row;
        return $query;
    }

    public function getEvoucherAmount($evoucher) {

        $query = $this->db->query("SELECT pin_balance_amount FROM `" . MLM_DB_PREFIX . "pin_numbers` WHERE pin_numbers = '" . $this->db->escape(utf8_strtolower($evoucher)) . "' and status = 'yes' ");
        if ($query->num_rows) {
            return array(
                'epin_amount' => $query->row['pin_balance_amount'],
            );
        } else {
            return false;
        }
    }

    public function getMethod() {
        $this->load->language('extension/payment/epin');
        $method_data = array(
            'code' => 'epin',
            'title' => $this->language->get('text_title'),
            'terms' => '',
            'sort_order' => $this->config->get('epin_sort_order')
        );
        return $method_data;
    }

    public function getExpressMethod() {
        $this->load->language('extension/payment/epin');
        $method_data = array(
            'code' => 'epin',
            'title' => $this->language->get('text_title'),
            'terms' => '',
            'sort_order' => $this->config->get('epin_sort_order')
        );
        return $method_data;
    }

    public function checkAllEpins($pin_details, $total_amount) {
        $is_pin_ok = false;
        $pin_array = array();
        $required_amount = $total_amount;
        $arr_length = count($pin_details);

        if ($arr_length) {
            for ($i = 0; $i < $arr_length; $i++) {
                if (isset($pin_details[$i])) {
                    $epin_value = $pin_details[$i]['pin'];
                    $epin_details = $this->getPinDetails($epin_value);
                    if ($epin_details && $this->checkEPinValidity($epin_value)) {
                        $epin_amount = $epin_details['pin_balance_amount'];
                        $epin_balance_amount = $epin_details['pin_balance_amount'];
                        $epin_used_amount = '0';
                        if ($required_amount) {
                            if ($epin_balance_amount == $required_amount) {
                                $epin_balance_amount = 0;
                                $required_amount = 0;
                            } else {
                                if ($epin_balance_amount > $required_amount) {
                                    $epin_balance_amount = $epin_balance_amount - $required_amount;
                                    $epin_used_amount = $required_amount;
                                    $required_amount = 0;
                                } else {
                                    $reg_balance = $required_amount - $epin_balance_amount;
                                    $required_amount = ($reg_balance >= 0) ? $reg_balance : 0;
                                    $epin_balance_amount = 0;
                                }
                            }
                            if ($required_amount == 0) {
                                $is_pin_ok = true;
                            }
                        } else {
                            $epin_used_amount = 0;
                        }
                        $pin_array["$i"]['pin'] = $epin_details['pin_numbers'];
                        $pin_array["$i"]['amount'] = $epin_amount;
                        $pin_array["$i"]['balance_amount'] = $epin_balance_amount;
                        $pin_array["$i"]['reg_balance_amount'] = $required_amount;
                        $pin_array["$i"]['epin_used_amount'] = $epin_used_amount;
                    } else {
                        $pin_array['error'] = true;
                        $pin_array["$i"]['pin'] = 'nopin';
                        $pin_array["$i"]['amount'] = '0';
                        $pin_array["$i"]['balance_amount'] = '0';
                        $pin_array["$i"]['reg_balance_amount'] = '0';
                        $pin_array["$i"]['epin_used_amount'] = '0';
                    }
                }
            }
        } else {
            $pin_array['error'] = true;
            $pin_array["0"]['pin'] = 'nopin';
            $pin_array["0"]['amount'] = '0';
            $pin_array["0"]['balance_amount'] = '0';
            $pin_array["0"]['reg_balance_amount'] = '0';
            $pin_array["0"]['epin_used_amount'] = '0';
        }
        return $pin_array;
    }

    public function checkEPinValidity($epin) {
        $date = date('Y-m-d');
        $query = $this->db->query("SELECT pin_id FROM `" . MLM_DB_PREFIX . "pin_numbers` WHERE pin_numbers = '" . $this->db->escape(utf8_strtolower($epin)) . "' and status = 'yes' AND pin_expiry_date > '" . $date . "' AND status = 'yes' AND pin_amount > 0");
        if (count($query->row) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUsedEpin($pin_details, $pin_count, $user_id) {
        for ($i = 0; $i < $pin_count; $i++) {
            $pin_no = $pin_details["$i"]['pin'];
            $pin_balance = round($pin_details["$i"]['balance_amount'], 2);
            $status = "yes";
            if ($pin_balance == 0) {
                $status = "no";
            }
            $res = $this->db->query("UPDATE `" . MLM_DB_PREFIX . "pin_numbers` SET used_user = '" . $user_id . "', pin_balance_amount = '" . $pin_balance . "', status = '" . $status . "' WHERE pin_numbers = '" . $pin_no . "' AND status = 'yes' ");
        }
        return $res;
    }

    public function insertToUsedPin($pin_details, $pin_count, $user_id) {
        $date = date('Y-m-d H:m:s');

        for ($i = 0; $i < $pin_count; $i++) {
            $pin_no = $pin_details["$i"]['pin'];
            $pin_balance = $pin_details["$i"]['balance_amount'];
            $pin_amount = $pin_details["$i"]['amount'];
            $status = "yes";
            if ($pin_balance == 0) {
                $status = "no";
            }
            $res = $this->db->query("INSERT INTO `" . MLM_DB_PREFIX . "pin_used` (status, pin_number, used_user, pin_alloc_date, pin_amount, pin_balance_amount) VALUES ('" . $status . "', '" . $pin_no . "', '" . $user_id . "', '" . $date . "', '" . $pin_amount . "', '" . $pin_balance . "') ");
        }
        return $res;
    }

    public function getOrderTotal($order_id) {
        $query = $this->db->query("SELECT value FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int) $order_id . "' AND code = 'total'");

        return $query->row['value'];
    }

}
