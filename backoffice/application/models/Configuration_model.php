<?php

class configuration_model extends inf_model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getSettings()
    {
        $query = $this->db->get('configuration');
        foreach ($query->result_array() as $row) {
            $obj_arr = $row;
        }

        return $obj_arr;
    }

    public function getBoardSettings($board_no = '')
    {
        if ($board_no != '') {
            $this->db->where('board_id', $board_no);
        }
        $query = $this->db->get('board_configuration');
        return $query->result_array();
    }

    function setLevel($depth, $depth_no)
    {

        $query = null;
        if ($depth_no != $depth) {

            $this->db->truncate('level_commision');
            if ($this->MLM_PLAN == "Donation") {
                for ($j = 1, $i = $depth; $j <= $depth; $j++, $i--) {
                    $this->db->set('level_no', $j);
                    $query = $this->db->insert('level_commision');
                }
            } else {
                for ($j = 1, $i = $depth; $j <= $depth; $j++, $i--) {
                    $this->db->set('level_no', $j);
                    $this->db->set('level_percentage', $i);
                    $query = $this->db->insert('level_commision');
                }
            }
        }
        return $query;
    }

    public function getPayOutTypes()
    {
        $payout_release = null;
        $this->db->select('payout_release');
        $query = $this->db->get('configuration');
        foreach ($query->result() as $row) {
            $payout_release = $row->payout_release;
        }

        return $payout_release;
    }

    public function getLetterSetting($lang_id = 1)
    {
        $letter_array = null;
        if ($lang_id != null) {
            $this->db->where('lang_ref_id', $lang_id);
        }
        $query = $this->db->get('letter_config');

        foreach ($query->result_array() as $row) {
            $letter_array = $row;
        }

        return $letter_array;
    }

    public function updateLetterSetting($post)
    {

        $lang_id = $post['lang_id'];
        $main_matter = addslashes($post['txtDefaultHtmlArea']);
        $product_matter = $post['product_matter'];

        if (array_key_exists('logo_name', $post)) {
            $file_name = $post['logo_name'];
            $this->db->set('logo', $file_name);
        }
        $this->db->set('main_matter', $main_matter);
        if ($lang_id != null) {
            $this->db->where('lang_ref_id', $lang_id);
        }

        $query = $this->db->update('letter_config');
        return $query;
    }

    public function updateBinaryCommission($post_data)
    {
        $data = [];
        $history = "MLM Plan: {$this->MLM_PLAN}, ";

        $data['pair_commission_type'] = $post_data['pair_commission_type'];
        if ($this->MODULE_STATUS['product_status'] == 'yes') {
            $post_data['pair_price'] = 0;
        } else {
            $post_data['pair_price'] = round((floatval($post_data['pair_price'])), 8);
        }
        $data['pair_price'] = $post_data['pair_price'];
        $history .= " Pair commission type: {$data['pair_commission_type']}, ";
        $history .= " Pair price: {$data['pair_price']}";

        $query = $this->db->update('configuration', $data);
        if ($query) {
            // configuration history
            $res = $this->insertConfigChangeHistory('commission settings', $history);
        }

        return $query;
    }

    public function updateLevelCommission($post_data, $default_currency_value)
    {
        $data = [];
        $level_data = [];
        $depth_ceiling = $this->validation_model->getConfig('depth_ceiling');

        $history = "MLM Plan: {$this->MLM_PLAN}, ";
        $data['level_commission_type'] = $post_data['level_commission_type'];
        $history .= "Level commission type: {$data['level_commission_type']}, ";

        $query = $this->db->update('configuration', $data);

        $res = false;
        for ($j = 1; $j <= $depth_ceiling; $j++) {
            if (array_key_exists('level_percentage' . $j, $post_data)) {
                $level_data[$j] = round($post_data['level_percentage' . $j] / $default_currency_value, 8);
                $history .= " Level percentage({$j}): {$level_data[$j]}, ";

                $this->db->set('level_percentage', $level_data[$j]);
                $this->db->where('level_no', $j);
                $res = $this->db->update('level_commision');
                if (!$res) {
                    break;
                }
            }
        }

        if ($query && $res) {
            // configuration history
            $res = $this->insertConfigChangeHistory('commission settings', $history);
        }

        return $query && $res;
    }

    public function updateDonationLevelCommission($post_data, $default_currency_value)
    {
        $data = [];
        $level_data = [];
        $depth_ceiling = $this->validation_model->getConfig('depth_ceiling');
        $history = "MLM Plan: {$this->MLM_PLAN}, ";
        $data['level_commission_type'] = $post_data['level_commission_type'];
        $history .= "Level commission type: {$data['level_commission_type']}, ";
        $levels_count = $post_data['donation_count'];

        $query = $this->db->update('configuration', $data);

        $result = false;
        for ($j = 1; $j <= $depth_ceiling; $j++) {
            for ($k = 1; $k <= $levels_count; $k++) {
                $level_data[$j]['donation_' . $k] = round($post_data['level_' . $j . '_donation_' . $k] / $default_currency_value, 8);
                $history .= "Level({$j}) ({$k}): " . $post_data['level_' . $j . '_donation_' . $k];

                $this->db->where('level_no', $j);
                $result = $this->db->update('level_commision', $level_data[$j]);
                if (!$result) {
                    break;
                }
            }
        }

        if ($query && $result) {
            // configuration history
            $res = $this->insertConfigChangeHistory('commission settings', $history);
        }

        return $query && $result;
    }

    public function updateBoardCommission($post_data, $board_count)
    {
        $data = [];
        $history = "MLM Plan: {$this->MLM_PLAN}, ";

        for ($i = 0; $i < $board_count; $i++) {
            $data[$i]["board_commission"] = $post_data["board" . $i . "_commission"];
            $history .= " Board Commission({$i}): {$this->DEFAULT_SYMBOL_LEFT}{$data[$i]["board_commission"]}{$this->DEFAULT_SYMBOL_RIGHT}, ";
        }

        $result = false;
        if ($data) {
            for ($i = 0; $i < $board_count; $i++) {
                $this->db->where('board_id', $i + 1);
                $result = $this->db->update('board_configuration', $data[$i]);
                if (!$result) {
                    break;
                }
            }
        }

        if ($result) {
            // configuration history
            $res = $this->insertConfigChangeHistory('commission settings', $history);
        }

        return $result;
    }

    public function updateStairstepCommission($post_data)
    {
        $data = [];
        $history = "MLM Plan: {$this->MLM_PLAN}, ";
        $data['override_commission'] = $post_data['override_commission'];
        $history .= "Override commission: {$this->DEFAULT_SYMBOL_LEFT}{$data['override_commission']}{$this->DEFAULT_SYMBOL_RIGHT}";

        $query = $this->db->update('configuration', $data);

        if ($query) {
            // configuration history
            $res = $this->insertConfigChangeHistory('commission settings', $history);
        }

        return $query;
    }

    public function updateAdditionalSettings($post_array, $module_status, $default_currency_value)
    {

        $settings_array = array();
        //insert configuration_change_history
        $additional_history = '';
        //

        if ($module_status['opencart_status'] == 'no') {
            $post_array['reg_amount'] = round($post_array['reg_amount'] / $default_currency_value, 8);
            $settings_array['reg_amount'] = $post_array['reg_amount'];
            $additional_history .= " Registration amount changed to: " . $this->DEFAULT_SYMBOL_LEFT . "{$post_array['reg_amount']}" . $this->DEFAULT_SYMBOL_RIGHT;
        }

        if ($module_status['purchase_wallet'] == 'yes') {
            $settings_array['purchase_income_perc'] = $post_array['purchase_income_perc'];
            $additional_history .= " Purchase Wallet Commission changed to: " . "{$post_array['purchase_income_perc']}";
        }

        if ($module_status['referal_status'] == 'yes') {
            if ($module_status['product_status'] == 'yes') {
                $post_array['referal_amount'] = 0;
            } else {
                $post_array['referal_amount'] = round((floatval($post_array['referal_amount'])), 8);
            }
            $settings_array['referal_amount'] = $post_array['referal_amount'];
            $additional_history .= " Referal amount:" . $this->DEFAULT_SYMBOL_LEFT . $settings_array['referal_amount'] . $this->DEFAULT_SYMBOL_RIGHT;
        }

        $post_array['service_charge'] = round((floatval($post_array['service_charge'])), 8);
        $post_array['tds'] = round((floatval($post_array['tds'])), 8);
        $post_array['trans_fee'] = round((floatval($post_array['trans_fee'] / $default_currency_value)), 8);
        $settings_array['tds'] = $post_array['tds'];
        $settings_array['service_charge'] = $post_array['service_charge'];
        $settings_array['trans_fee'] = $post_array['trans_fee'];

        //insert configuration_change_history
        $additional_history .= "Service charge: " . $this->DEFAULT_SYMBOL_LEFT . $settings_array['service_charge'] . $this->DEFAULT_SYMBOL_RIGHT . "," . " TDS: " . $this->DEFAULT_SYMBOL_LEFT . $settings_array['tds'] . $this->DEFAULT_SYMBOL_RIGHT;
        $additional_history .= "Transaction fee: " . $this->DEFAULT_SYMBOL_LEFT . $settings_array['trans_fee'] . $this->DEFAULT_SYMBOL_RIGHT;
        //

        $query = $this->db->update('configuration', $settings_array);

        $this->insertConfigChangeHistory('additional settings', $additional_history);

        //
        return $query;
    }

    public function updatLevelSettings($level_settings_array)
    {
        $c = count($level_settings_array);
        for ($j = 1; $j <= $c; $j++) {
            $this->db->set('level_percentage', $level_settings_array[$j]);
            $this->db->where('level_no', $j);
            $rec = $this->db->update('level_commision');
        }
        return $rec;
    }

    public function updateDonationLevelSettings($level_settings_array)
    {
        $c = count($level_settings_array);
        for ($i = 0; $i < $c; $i++) {
            $this->db->where('level_no', $i + 1);
            $result = $this->db->update('level_commision', $level_settings_array[$i + 1]);
        }
        return ($result);
    }

    public function updatBoardSettings($board_settings, $board_count = '1')
    {
        for ($i = 0; $i < $board_count; $i++) {
            $this->db->where('board_id', $i + 1);
            $result = $this->db->update('board_configuration', $board_settings[$i]);
        }
        return ($result);
    }

    public function updatePayoutSettng($min_payout, $payout_validity, $payout_status, $max_payout)
    {
        $this->db->set('min_payout', $min_payout);
        $this->db->set('max_payout', $max_payout);
        $this->db->set('payout_request_validity', $payout_validity);
        $this->db->set('payout_release', $payout_status);
        $query = $this->db->update('configuration');
        if ($query) {
            $ewallet_request_status = "no";
            if ($payout_status == 'ewallet_request') {
                $ewallet_request_status = 'yes';
            }
            if ($payout_status == 'both') {
                $ewallet_request_status = 'yes';
            }
            $this->db->set('sub_status', $ewallet_request_status);
            $this->db->where('sub_id', 49);
            $query1 = $this->db->update('infinite_mlm_sub_menu');
            return $query1;
        }
    }

    public function getReferalDetails($user_id, $limit, $offset, $table_prefix = null)
    {

        $this->load->model('country_state_model');

        $session_data = $this->session->userdata('inf_logged_in');
        $arr = array();

        if ($session_data['user_type'] == 'admin' || $table_prefix != null || $session_data['user_type'] == 'employee') {
            $id = $user_id;
        } else {
            $id = $session_data['user_id'];
        }
        if ($id != null) {

            $this->db->select("fi.date_of_joining, ud.user_detail_refid,ud.user_detail_name,ud.user_detail_second_name,ud.user_detail_email,ud.user_detail_country");
            $this->db->from("ft_individual as fi");
            $this->db->join("user_details as ud", "ud.user_detail_refid = fi.id", "INNER");
            $this->db->where('sponsor_id', $id);
            $this->db->limit($limit, $offset);
            $query = $this->db->get();

            $i = 0;
            foreach ($query->result_array() as $row) {
                $user_id = $row['user_detail_refid'];
                $arr[$i]['user_name'] = $this->validation_model->IdToUserName($user_id);
                $arr[$i]['name'] = $row['user_detail_name'];
                $arr[$i]['name'] .= " " . $row['user_detail_second_name'];
                $arr[$i]['join_date'] = $row['date_of_joining'];
                $arr[$i]['email'] = $row['user_detail_email'];
                $arr[$i]['country'] = $this->country_state_model->getCountryNameFromId($row['user_detail_country']);
                $i++;
            }

            for ($j = 0; $j < count($arr); $j++) {
                if ($arr[$j]['email'] == null)
                    $arr[$j]['email'] = 'NA';
                if ($arr[$j]['country'] == null)
                    $arr[$j]['country'] = 'NA';
            }
            return $arr;
        }
    }

    public function getReferalDetailscount($user_id)
    {
        $this->db->select('count(*) as cnt');
        $this->db->from('user_details');
        $this->db->where('user_details_ref_user_id', $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function setCreditCardStatus($id, $status, $payout = "")
    {
        if ($payout == "payout")
            $this->db->set('payout_status', $status);
        else
            $this->db->set('status', $status);
        $this->db->where('id', $id);
        $query = $this->db->update('payment_gateway_config');
        if ($id == 5) {
            $this->setModuleStatus('bitcoin_status', $status);
        }
    }

    public function getCreditCardStatus($payout = "")
    {

        $this->db->select('*');
        $this->db->from('payment_gateway_config');
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get();
        $details = array();
        $i = 0;
        foreach ($query->result() as $row) {
            if ($payout == 'payout') {
                $condition = $row->gateway_name != 'Creditcard' && $row->gateway_name != 'EPDQ' && $row->gateway_name != 'Payeer' && $row->gateway_name != 'Sofort' && $row->gateway_name != 'SquareUp';
            } else {
                $condition = $row->gateway_name != 'Creditcard' && $row->gateway_name != 'EPDQ';
            }
            if ($condition) {
                $details[$i]['id'] = $row->id;
                $details[$i]['gateway_name'] = $row->gateway_name;
                if ($payout == "payout") {
                    $details[$i]['status'] = $row->payout_status;
                    $details[$i]['sort_order'] = $row->payout_sort_order;
                } else {
                    $details[$i]['status'] = $row->status;
                    $details[$i]['sort_order'] = $row->sort_order;
                }
                $details[$i]['logo'] = $row->logo;
                $details[$i]['mode'] = $row->mode;
                $details[$i]['registration'] = $row->registration;
                $details[$i]['repurchase'] = $row->repurchase;
                $details[$i]['membership_renewal'] = $row->membership_renewal;
                $details[$i]['upgradation'] = $row->upgradation;
                $i++;
            }
        }
        return $details;
    }

    public function setLanguageStatus($lang_id, $status)
    {
        $this->db->set('status', $status);
        $this->db->where('lang_id', $lang_id);
        $query = $this->db->update('infinite_languages');
        if ($query && $status == "no") {
            $this->load->model("multi_language_model");
            $default_lang_id = $this->getDefaultLangID($lang_id);

            if ($lang_id == $default_lang_id) {
                $user_id = $this->LOG_USER_ID;
                $default_lang_id = $this->multi_language_model->getActiveLangaugeID();
                $this->multi_language_model->setDefaultLanguage($default_lang_id, $user_id);
            }
            $this->multi_language_model->updateAllUserDefaultLanguage($lang_id, $default_lang_id);
        }
        return $query;
    }

    public function getDefaultLangID()
    {
        $lang_id = 1;
        $this->db->select('lang_id');
        $this->db->where('default_id', 1);
        $query = $this->db->get('infinite_languages');
        foreach ($query->result_array() as $row) {
            $lang_id = $row['lang_id'];
        }
        return $lang_id;
    }

    public function setModuleStatus($module_name, $status)
    {
        $this->db->set($module_name, $status);
        $query = $this->db->update('module_status');
        if (($module_name == 'google_auth_status') && ($status == 'no')) {
            $this->db->set('perm_admin', 0);
            $this->db->where('sub_id', 162);
            $this->db->where('sub_link_ref_id', 243);
            $this->db->where('sub_status', 'yes');
            $this->db->update('infinite_mlm_sub_menu');
        }
        if (($module_name == 'google_auth_status') && ($status == 'yes')) {
            $this->db->set('perm_admin', 1);
            $this->db->where('sub_id', 162);
            $this->db->where('sub_link_ref_id', 243);
            $this->db->where('sub_status', 'yes');
            $this->db->update('infinite_mlm_sub_menu');
        }
        if ($query) {
            $this->updateLeftMenus($module_name, $status);
        }

        if ($module_name == 'opencart_status') {
            if ($status == 'yes') {
                $this->db->set('product_status', $status);
                $this->db->set('repurchase_status', "no");
                $this->db->set('product_validity', "no");
                $query = $this->db->update('module_status');
                $this->updateLeftMenus('repurchase_status', "no");
                $this->updateLeftMenus('product_validity', "no");
                $this->updateLeftMenus('package_upgrade', "no");
            } else {
                $this->updateLeftMenus('product_status', 'yes');
            }
        }
        if ($module_name == 'product_status') {
            if ($status == 'no') {
                $this->db->set('product_validity', $status);
                $this->db->set('repurchase_status', $status);
                $this->db->set('package_upgrade', $status);
                $this->db->set('roi_status', $status);
                $query = $this->db->update('module_status');
                $this->updateLeftMenus('repurchase_status', $status);
                $this->updateLeftMenus('product_validity', $status);
                $this->updateLeftMenus('package_upgrade', $status);
                $this->updateLeftMenus('roi_status', $status);
            }
        }
        if ($module_name == 'lead_capture_status') {
            if ($status == 'no') {
                $this->db->set('autoresponder_status', $status);
                $query = $this->db->update('module_status');
                $this->updateLeftMenus('autoresponder_status', $status);
            }
        }
        if ($module_name == 'sponsor_commission_status') {
            if ($status == 'no') {
                $this->db->set('xup_status', $status);
                $query = $this->db->update('module_status');
            }
        }
        return $query;
    }

    public function updateLeftMenus($module_name, $status)
    {
        $MODULE_STATUS = $this->trackModule();
        if ($module_name == 'ewallet_status') {
            $this->setPaymentStatus(3, $status);
            $this->db->set('status', $status);
            $this->db->where('id', 14);
            $query = $this->db->update('infinite_mlm_menu');
            if ($query) {
                $this->setSubMenuStatus(14, $status);
            }
        } else if ($module_name == 'sponsor_tree_status') {
            $this->db->set('sub_status', $status);
            $this->db->where('sub_id', 3);
            $query = $this->db->update('infinite_mlm_sub_menu');
        } else if ($module_name == 'sponsor_commission_status') {
            $this->db->set('sub_status', $status);
            $this->db->where('sub_id', 54);
            $query = $this->db->update('infinite_mlm_sub_menu');
            $this->db->set('status', $status);
            $this->db->where_in('db_amt_type', array("level_commission", "repurchase_level_commission"));
            $query = $this->db->update('amount_type');
        } else if ($module_name == 'rank_status') {
            $this->db->set('sub_status', $status);
            $this->db->where_in('sub_id', array(34, 103));
            $query = $this->db->update('infinite_mlm_sub_menu');
        } else if ($module_name == 'sms_status') {
            $this->db->set('status', $status);
            $this->db->where('id', 18);
            $query = $this->db->update('infinite_mlm_menu');
        } else if ($module_name == 'employee_status') {
            $this->db->set('status', $status);
            $this->db->where('id', 17);
            $query = $this->db->update('infinite_mlm_menu');
            if ($query) {
                $this->setSubMenuStatus(17, $status);
            }
        } else if ($module_name == 'upload_status') {
            $this->db->set('sub_status', $status);
            $this->db->where_in('sub_id', array(13, 64));
            $query = $this->db->update('infinite_mlm_sub_menu');
        } else if ($module_name == 'lead_capture_status') {
            $lcp_type = $this->validation_model->getModuleStatusByKey('lcp_type');
            if ($lcp_type == 'lcp') {
                $this->db->set('sub_status', $status);
                $this->db->where('sub_id', 122);
                $query = $this->db->update('infinite_mlm_sub_menu');
            }
            if ($lcp_type == 'lcp_crm') {
                $this->db->set('status', $status);
                $this->db->where('id', 44);
                $query = $this->db->update('infinite_mlm_menu');
                if ($query) {
                    $this->setSubMenuStatus(44, $status);
                }
            }
        } else if ($module_name == "replicated_site_status") {
            $this->db->set('sub_status', $status);
            $this->db->where('sub_id', 105);
            $query = $this->db->update('infinite_mlm_sub_menu');
        } else if ($module_name == 'multy_currency_status') {
            $this->db->set('status', $status);
            $this->db->where('id', 27);
            $query = $this->db->update('infinite_mlm_menu');
        } else if ($module_name == 'ticket_system_status') {
            $this->db->set('status', $status);
            $this->db->where('id', 32);
            $query = $this->db->update('infinite_mlm_menu');

            $this->db->set('status', $status);
            $this->db->where('id', 66);
            $query1 = $this->db->update('infinite_mlm_menu');
            if ($query) {
                $this->db->set('sub_status', $status);
                $this->db->or_where("sub_refid", '32');
                $query = $this->db->update('infinite_mlm_sub_menu');
            }
        } else if ($module_name == 'autoresponder_status') {
            $this->db->set('sub_status', $status);
            $this->db->where('sub_id', 56);
            $query = $this->db->update('infinite_mlm_sub_menu');
        } else if ($module_name == 'pin_status') {
            $this->setPaymentStatus(2, $status);
            $this->db->set('status', $status);
            $this->db->where('id', 13);
            $query1 = $this->db->update('infinite_mlm_menu');
            if ($query1) {
                $this->db->set('sub_status', $status);
                $this->db->where_in("sub_id", array('27', '36'));
                $this->db->or_where("sub_refid", '13');
                $query = $this->db->update('infinite_mlm_sub_menu');
            }
        } else if ($module_name == 'product_status') {
            $this->db->set('status', $status);
            $this->db->where('id', 12);
            $query = $this->db->update('infinite_mlm_menu');

            $this->db->set('sub_status', $status);
            $this->db->where('sub_id', '38');
            $query = $this->db->update('infinite_mlm_sub_menu');

            $this->db->set('sub_status', $status);
            $this->db->where_in('sub_id', [108, 109]);
            $query = $this->db->update('infinite_mlm_sub_menu');
            $this->db->set('status', $status);
            $this->db->where_in('db_amt_type', array("repurchase_level_commission", "repurchase", "repurchase_leg"));
            $query = $this->db->update('amount_type');

            if ($MODULE_STATUS['package_upgrade'] != 'no') {
                $this->db->set('status', 'yes');
                $this->db->where('db_amt_type', 'upgrade_level_commission');
                $this->db->update('amount_type');
            } else {
                $this->db->set('status', 'no');
                $this->db->where('db_amt_type', 'upgrade_level_commission');
                $this->db->update('amount_type');
            }

            if ($MODULE_STATUS['product_status'] != "yes") {
                $this->db->set('referal_count', 1);
                $this->db->set('personal_pv', 0);
                $this->db->set('group_pv', 0);
                $this->db->set('downline_purchase_count', 0);
                $this->db->set('joinee_package', 0);
                $this->db->update('rank_configuration');
            }

            $MODULE_STATUS = $this->trackModule();
            if ($MODULE_STATUS['product_status'] != "no" && $MODULE_STATUS['xup_status'] != "no") {
                $this->db->set('status', 'yes');
                $this->db->where_in('db_amt_type', array("xup_repurchase_level_commission", "xup_upgrade_level_commission"));
                $this->db->update('amount_type');
            } else {
                $this->db->set('status', 'no');
                $this->db->where_in('db_amt_type', array("xup_repurchase_level_commission", "xup_upgrade_level_commission"));
                $this->db->update('amount_type');
            }
        } else if ($module_name == "sponsor_commission_status") {
            if ($status == "yes") {
                $this->db->set('db_amt_type', 'level_commission');
                $this->db->set('view_amt_type', 'Level Commission');
                $query = $this->db->insert('amount_type');
            } else {
                $this->db->where('db_amt_type', 'level_commission');
                $query = $this->db->delete('amount_type');
            }
        } else if ($module_name == 'multy_currency_status') {
            $this->db->set('status', $status);
            $this->db->where('id', 27);
            $query = $this->db->update('infinite_mlm_menu');
        } else if ($module_name == 'opencart_status') {
            if ($status == 'yes') {
                $stat = 'no';
            } else {
                $stat = 'yes';
            }
            $this->db->set('status', $status);
            $this->db->where('id', 37);
            $query1 = $this->db->update('infinite_mlm_menu');

            $this->db->set('status', $stat);
            $this->db->where('id', 12);
            $query2 = $this->db->update('infinite_mlm_menu');

            $this->db->set('status', $status);
            $this->db->where('id', 38);
            $query3 = $this->db->update('infinite_mlm_menu');

            $this->db->set('status', $status);
            $this->db->where('id', 42);
            $query3 = $this->db->update('infinite_mlm_menu');
        } else if ($module_name == 'repurchase_status') {
            $this->db->set('status', $status);
            $this->db->where('id', 46);
            $query = $this->db->update('infinite_mlm_menu');

            $this->db->set('sub_status', $status);
            $this->db->where('sub_id', 87);
            $query = $this->db->update('infinite_mlm_sub_menu');

            $this->db->set('sub_status', $status);
            $this->db->where('sub_id', 109);
            $query = $this->db->update('infinite_mlm_sub_menu');

            if ($status == 'no') {
                $this->db->set('perm_dist', 0);
                $this->db->where('id', 16);
                $query = $this->db->update('infinite_mlm_menu');
            } else {
                $this->db->set('perm_dist', 1);
                $this->db->where('id', 16);
                $query = $this->db->update('infinite_mlm_menu');
            }
        } else if ($module_name == 'product_validity') {
            $this->db->set('sub_status', $status);
            $this->db->where_in("sub_id", array('92', '93'));
            $query = $this->db->update('infinite_mlm_sub_menu');
        } else if ($module_name == 'package_upgrade') {
            $this->db->set('sub_status', $status);
            $this->db->where_in("sub_id", array('119'));
            $query = $this->db->update('infinite_mlm_sub_menu');

            $this->db->set('sub_status', $status);
            $this->db->where_in("sub_id", array('149'));
            $query1 = $this->db->update('infinite_mlm_sub_menu');

            $this->db->set('status', $status);
            $this->db->where('db_amt_type', 'upgrade_level_commission');
            $query2 = $this->db->update('amount_type');

            if ($MODULE_STATUS['xup_status'] != 'no') {
                $this->db->set('status', $status);
                $this->db->where('db_amt_type', 'xup_upgrade_level_commission');
                $query2 = $this->db->update('amount_type');
                $this->db->set('status', 'no');
                $this->db->where('db_amt_type', 'upgrade_level_commission');
                $query3 = $this->db->update('amount_type');
            }
        } else if ($module_name == 'maintenance_status') {
            $this->db->set('sub_status', $status);
            $this->db->where_in("sub_id", array('123'));
            $query = $this->db->update('infinite_mlm_sub_menu');
        } else if ($module_name == 'roi_status') {
            $this->db->set('status', $status);
            $this->db->where('id', 55);
            $query = $this->db->update('infinite_mlm_menu');
            if ($query) {
                $this->db->set('sub_status', $status);
                $this->db->where('sub_id', 136);
                $query = $this->db->update('infinite_mlm_sub_menu');

                $this->db->set('status', $status);
                $this->db->where('db_amt_type', 'daily_investment');
                $query1 = $this->db->update('amount_type');
            }
        } else if ($module_name == 'gdpr') {
            $this->db->set('sub_status', $status);
            $this->db->where('sub_id', 147);
            $query = $this->db->update('infinite_mlm_sub_menu');

            $this->db->set('sub_status', $status);
            $this->db->where('sub_id', 148);
            $query = $this->db->update('infinite_mlm_sub_menu');
        } else if ($module_name == 'kyc_status') {
            $this->db->set('sub_status', $status);
            $this->db->where('sub_id', 150);
            $query = $this->db->update('infinite_mlm_sub_menu');

            $this->db->set('sub_status', $status);
            $this->db->where('sub_id', 151);
            $query = $this->db->update('infinite_mlm_sub_menu');
        } else if ($module_name == 'purchase_wallet') {
            $this->db->set('status', $status);
            $this->db->where('id', 64);
            $query = $this->db->update('infinite_mlm_menu');
        } else if ($module_name == 'xup_status') {
            $this->db->set('status', $status);
            $this->db->where('db_amt_type', 'xup_commission');
            $this->db->update('amount_type');

            if ($MODULE_STATUS['product_status'] != "no" && $MODULE_STATUS['xup_status'] != "no") {
                $this->db->set('status', 'yes');
                $this->db->where('db_amt_type', 'xup_repurchase_level_commission');
                $this->db->update('amount_type');
                if ($MODULE_STATUS['package_upgrade'] != 'no') {
                    $this->db->set('status', 'yes');
                    $this->db->where('db_amt_type', 'xup_upgrade_level_commission');
                    $this->db->update('amount_type');
                }
            } else {
                $this->db->set('status', 'no');
                $this->db->where_in('db_amt_type', array("xup_repurchase_level_commission", "xup_upgrade_level_commission"));
                $this->db->update('amount_type');
            }
            if ($status == "yes") {
                $this->db->set('status', 'no');
                $this->db->where_in('db_amt_type', array("level_commission", "repurchase_level_commission", "upgrade_level_commission"));
                $this->db->update('amount_type');
            } else {
                $this->db->set('status', 'yes');
                $this->db->where_in('db_amt_type', array("level_commission", "repurchase_level_commission"));
                $this->db->update('amount_type');
                if ($MODULE_STATUS['package_upgrade'] != 'no') {
                    $this->db->set('status', 'yes');
                    $this->db->where('db_amt_type', 'upgrade_level_commission');
                    $this->db->update('amount_type');
                }
            }
        }
        $MODULE_STATUS = $this->trackModule();
        if (in_array($module_name, ['product_status', 'repurchase_status'])) {
            $this->db->set('status', $MODULE_STATUS['repurchase_status']);
            $this->db->where('db_amt_type', 'matching_bonus_purchase');
            $this->db->update('amount_type');
        }
        if (in_array($module_name, ['product_status', 'package_upgrade'])) {
            $this->db->set('status', $MODULE_STATUS['package_upgrade']);
            $this->db->where('db_amt_type', 'matching_bonus_upgrade');
            $this->db->update('amount_type');
        }
    }

    public function setSubMenuStatus($sub_refid, $status)
    {
        $this->db->set('sub_status', $status);
        $this->db->where('sub_refid', $sub_refid);
        $query = $this->db->update('infinite_mlm_sub_menu');
    }

    public function getTermsConditionsSettings($lang_id = null)
    {
        $TermsConditions = "";
        if ($lang_id != null) {
            $this->db->where('lang_ref_id', $lang_id);
        }
        $query = $this->db->get('terms_conditions');

        foreach ($query->result() as $row) {
            $TermsConditions = $row->terms_conditions;
        }
        return stripslashes($TermsConditions);
    }

    public function updateTermsConditionsSettings($post)
    {

        $newone = addslashes($post['txtDefaultHtmlArea1']);
        $lang_id = $post['lang_id'];
        $this->db->set('terms_conditions', $newone);
        if ($lang_id != null)
            $this->db->where('lang_ref_id', $lang_id);
        $query = $this->db->update('terms_conditions');
        return $query;
    }

    public function getPinConfig()
    {
        $arr = null;

        $query = $this->db->get('pin_config');

        foreach ($query->result() as $row) {
            $arr['pin_amount'] = $row->pin_amount;
            $arr['pin_length'] = $row->pin_length;
            $arr['pin_maxcount'] = $row->pin_maxcount;
            $arr['pin_character_set'] = $row->pin_character_set;
        }

        return $arr;
    }

    public function setPinConfig($pin_length, $pin_maxcount, $pin_character_set)
    {
        $this->db->set('pin_maxcount', $pin_maxcount);
        $this->db->set('pin_length', $pin_length);
        $this->db->set('pin_character_set', $pin_character_set);
        $query = $this->db->update('pin_config');

        return $query;
    }

    public function getUsernameConfig()
    {

        $query = $this->db->get('username_config');
        foreach ($query->result() as $row) {
            $config['length'] = $row->length;
            $config['prefix_status'] = $row->prefix_status;
            $config['prefix'] = $row->prefix;
            $config['type'] = $row->user_name_type;
        }

        return $config;
    }

    public function setUsernameConfig($length, $prefix_status, $prefix = null, $type)
    {
        $this->db->set('length', $length);
        $this->db->set('prefix_status', $prefix_status);
        $this->db->set('prefix', $prefix);
        $this->db->set('user_name_type', $type);
        $query = $this->db->update('username_config');

        return $query;
    }

    public function setUserNameType($type)
    {

        $length = 6;
        $prefix_status = 'no';
        $prefix = null;
        $this->db->set('length', $length);
        $this->db->set('prefix_status', $prefix_status);
        $this->db->set('prefix', $prefix);
        $this->db->set('user_name_type', $type);
        $query = $this->db->update('username_config');
        return $query;
    }

    public function getUsernamePrefix()
    {
        $this->db->select('prefix');
        $this->db->from('username_config');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $prefix = $row->prefix;
        }
        return $prefix;
    }

    public function siteConfiguration($nam, $address, $lang, $em, $ph, $thumbnail_logo, $thumbnail_favicon)
    {

        $this->db->set('company_name', $nam);
        $this->db->set('company_address', $address);
        $this->db->set('default_lang', $lang);
        $this->db->set('logo', $thumbnail_logo);
        $this->db->set('email', $em);
        $this->db->set('phone', $ph);
        $this->db->set('favicon', $thumbnail_favicon);
        $this->db->where('id', '1');
        $query = $this->db->update('site_information');

        $this->db->set('logo', $thumbnail_logo);
        $this->db->update('letter_config');

        return $query;
    }

    public function getSiteConfiguration()
    {
        $this->db->select('*');
        $this->db->from('site_information');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $row = $this->validation_model->stripSlashResultArray($row);
            $site_info_arr['co_name'] = $row['company_name'];
            $site_info_arr['company_address'] = htmlspecialchars($row['company_address']);
            $site_info_arr['logo'] = $row['logo'];
            if (!file_exists(IMG_DIR . 'logos/' . $row['logo'])) {
                $site_info_arr['logo'] = 'logo_' . $this->ADMIN_THEME_FOLDER . '.png';
            }
            $site_info_arr['email'] = $row['email'];
            $site_info_arr['phone'] = $row['phone'];
            $site_info_arr['favicon'] = $row['favicon'];
            if ((!file_exists(IMG_DIR . 'logos/' . $row['favicon']))) {
                $site_info_arr['favicon'] = 'favicon.ico';
            }
            $site_info_arr['default_lang'] = $row['default_lang'];
        }
        return $site_info_arr;
    }

    public function getLanguages()
    {
        $lang = array();
        $this->db->select('*');
        $this->db->from('infinite_languages');
        $this->db->where('status', 'yes');
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $lang[$i]['lang_id'] = $row['lang_id'];
            $lang[$i]['lang_code'] = $row['lang_code'];
            $lang[$i]['lang_name'] = $row['lang_name'];
            $lang[$i]['lang_name_in_english'] = $row['lang_name_in_english'];
            $lang[$i]['status'] = $row['status'];
            $i++;
        }
        return $lang;
    }

    public function getMailDetails()
    {
        $mail_details = array();
        $this->db->select('*');
        $this->db->where('id', 1);
        $this->db->from('mail_settings');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $mail_details = $row;
        }
        return $mail_details;
    }

    public function updateMailSettings($mail_setting)
    {

        $this->db->set('reg_mail_type', $mail_setting['reg_mail_type']);
        $this->db->set('smtp_host', $mail_setting['smtp_host']);
        $this->db->set('smtp_username', $mail_setting['smtp_username']);
        $this->db->set('smtp_password', $mail_setting['smtp_password']);
        $this->db->set('smtp_port', $mail_setting['smtp_port']);
        $this->db->set('smtp_timeout', $mail_setting['smtp_timeout']);
        $this->db->set('smtp_authentication', $mail_setting['smtp_authentication']);
        $this->db->set('smtp_protocol', $mail_setting['smtp_protocol']);
        $this->db->where('id', '1');
        $query = $this->db->update('mail_settings');
        return $query;
    }

    public function insertRankDetails($rank_post_array, $commission_type, $default_currency_value)
    {
        $MODULE_STATUS = $this->trackModule();
        $rank_config = $this->getRankConfiguration();
        $this->db->set('rank_name', $rank_post_array['rank_name']);
        $this->db->set('rank_bonus', round($rank_post_array['rank_achievers_bonus'] / $default_currency_value, 8));
        $this->db->set('rank_color', $rank_post_array['rank_color']);

        if($rank_config['referal_count']){
            $this->db->set('referal_count', $rank_post_array['ref_count']);
        }
        if($rank_config['personal_pv']){
            $this->db->set('personal_pv', $rank_post_array['personal_pv']);
        }
        if($rank_config['group_pv']){
            $this->db->set('gpv', $rank_post_array['gpv']);
        }
        if($rank_config['downline_member_count']) {
            $this->db->set('downline_count', $rank_post_array['downline_count']);
        }

        if ($MODULE_STATUS['referal_status'] == 'yes' && $commission_type == 'rank') {
            $this->db->set('referal_commission', round($rank_post_array['ref_commission'] / $default_currency_value, 8));
        }
        $this->db->set('rank_status', 'active');
        $this->db->insert('rank_details');
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function insertPackageRankTable($rank, $rank_id)
    {
        foreach ($rank as $key => $value) {
            $this->db->set('rank_id', $rank_id);
            $this->db->set('package_id', $key);
            $this->db->set('package_count', $value);
            $this->db->insert('purchase_rank');
        }
    }

    public function updatePackageRankTable($rank, $rank_id)
    {
        foreach ($rank as $key => $value) {
            if ($this->isPackageRankExists($key, $rank_id)) {
                $this->db->set('package_count', $value);
                $this->db->where('package_id', $key);
                $this->db->where('rank_id', $rank_id);
                $this->db->update('purchase_rank');
            } else {
                $this->db->set('rank_id', $rank_id);
                $this->db->set('package_id', $key);
                $this->db->set('package_count', $value);
                $this->db->insert('purchase_rank');
            }
        }
    }

    public function insertJoineeRankPckTable($product_id, $rank_id)
    {

        $this->db->set('rank_id', $rank_id);
        $this->db->set('package_id', $product_id);
        $this->db->insert('joinee_rank');
    }

    public function updateJoineeRankPckTable($product_id, $rank_id)
    {
        if ($this->isJoineePckRankExists($rank_id)) {
            $this->db->set('package_id', $product_id);
            $this->db->where('rank_id', $rank_id);
            $this->db->update('joinee_rank');
        } else {
            $this->db->set('rank_id', $rank_id);
            $this->db->set('package_id', $product_id);
            $this->db->insert('joinee_rank');
        }
    }

    public function isJoineePckRankExists($rank_id)
    {
        $this->db->where('rank_id', $rank_id);
        return $this->db->count_all_results('joinee_rank');
    }

    public function isPackageRankExists($key, $rank_id)
    {
        $this->db->where('package_id', $key);
        $this->db->where('rank_id', $rank_id);
        return $this->db->count_all_results('purchase_rank');
    }

    public function selectPackageRankConfig($id = 0)
    {
        $MODULE_STATUS = $this->trackModule();
        if ($MODULE_STATUS['opencart_status'] != "yes" || $MODULE_STATUS['opencart_status_demo'] != "yes") {
        $this->db->select("p.prod_id as product_id, p.product_name, IFNULL(pr.package_count,0) AS package_count");
        $this->db->from("package as p");
        $this->db->join("purchase_rank as pr", "p.prod_id = pr.package_id and pr.rank_id = $id", "LEFT");
        $this->db->where('p.type_of_package', 'registration');
        $this->db->where('p.active', 'yes');
        $query = $this->db->get();
        } else {
            $this->db->select('op.model product_name,op.package_id as product_id, IFNULL(pr.package_count,0) AS package_count');
            $this->db->from("oc_product op");
            $this->db->join("purchase_rank as pr", "op.package_id = pr.package_id and pr.rank_id = $id", "LEFT");
            $this->db->where('op.package_type', 'registration');
            $this->db->where('op.status', 1);
            $this->db->order_by("op.product_id", "asc");
            $query = $this->db->get();
        }

        return $query->result_array();
    }

    public function selectRankDetails($edit_id)
    {
        $this->db->where('rank_id', $edit_id);
        $query = $this->db->get('rank_details');
        foreach ($query->result_array() as $row) {
            $obj_arr['rank_id'] = $row['rank_id'];
            $obj_arr['rank_name'] = $row['rank_name'];
            $obj_arr['referal_count'] = $row['referal_count'];
            $obj_arr['rank_bonus'] = $row['rank_bonus'];
            $obj_arr['personal_pv'] = $row['personal_pv'];
            $obj_arr['gpv'] = $row['gpv'];
            $obj_arr['downline_count'] = $row['downline_count'];
        //  $obj_arr['team_member_count'] = $row['team_member_count'];
            $obj_arr['downline_rank_id'] = $row['downline_rank_id'];
            $obj_arr['downline_rank_count'] = $row['downline_rank_count'];
            $obj_arr['referal_commission'] = $row['referal_commission'];
            $obj_arr['rank_color'] = $row['rank_color'];
        }
        return $obj_arr;
    }

    public function selectBoardDetails($edit_id)
    {

        $this->db->where('board_id', $edit_id);

        $query = $this->db->get('board_configuration');

        foreach ($query->result_array() as $row) {
            $obj_arr['board_id'] = $row['board_id'];
            $obj_arr['board_width'] = $row['board_width'];
            $obj_arr['board_depth'] = $row['board_depth'];
            $obj_arr['board_name'] = $row['board_name'];
            $obj_arr['board_commission'] = $row['board_commission'];
            $obj_arr['sponser_follow_status'] = $row['sponser_follow_status'];
            $obj_arr['re_entry_status'] = $row['re_entry_status'];
            $obj_arr['re_entry_to_next_status'] = $row['re_entry_to_next_status'];
        }
        return $obj_arr;
    }

    public function updateRank($rank_post_array, $commission_type, $default_currency_value)
    {
        $MODULE_STATUS = $this->trackModule();
        $rank_config = $this->getRankConfiguration();
        $this->db->set('rank_name', $rank_post_array['rank_name']);
        $this->db->set('rank_bonus', round($rank_post_array['rank_achievers_bonus'] / $default_currency_value, 8));
        $this->db->set('rank_color', $rank_post_array['rank_color']);
        if($rank_config['referal_count']) {
            $this->db->set('referal_count', $rank_post_array['ref_count']);
        }
        if($rank_config['personal_pv']) {
            $this->db->set('personal_pv', $rank_post_array['personal_pv']);
        }
        if($rank_config['group_pv']){
            $this->db->set('gpv', $rank_post_array['gpv']);
        }
        if($rank_config['downline_member_count']){
            $this->db->set('downline_count', $rank_post_array['downline_count']);
        }

        if ($MODULE_STATUS['referal_status'] == 'yes' && $commission_type == 'rank') {
            $this->db->set('referal_commission', round($rank_post_array['ref_commission'] / $default_currency_value, 8));
        }
        $this->db->where('rank_id', $rank_post_array['rank_id']);
        $query = $this->db->update('rank_details');
        return $query;
    }

    public function updateBoard($edit_id, $board_width, $board_depth, $board_name, $board_commission, $re_entry_status, $sponser_follow_status, $re_entry_to_next_status)
    {
        $this->db->set('board_width', $board_width);
        $this->db->set('board_depth', $board_depth);
        $this->db->set('board_name', $board_name);
        $this->db->set('board_commission', $board_commission);
        $this->db->set('re_entry_status', $re_entry_status);
        $this->db->set('sponser_follow_status', $sponser_follow_status);
        $this->db->set('re_entry_to_next_status', $re_entry_to_next_status);
        $this->db->where('board_id', $edit_id);
        $query = $this->db->update('board_configuration');
        return $query;
    }

    public function inactivate_rank($rank_id)
    {
        $this->db->set('rank_status', 'inactive');
        $this->db->where('rank_id', $rank_id);
        $query = $this->db->update('rank_details');
        return $query;
    }

    public function activate_rank($rank_id)
    {
        $this->db->set('rank_status', 'active');
        $this->db->where('rank_id', $rank_id);
        $query = $this->db->update('rank_details');
        return $query;
    }

    public function getActiveRankDetails($rank_id = null)
    {
        $arr = array();
        if ($rank_id != null) {
            $this->db->where('rank_id', $rank_id);
        }
        $this->db->where('rank_status', 'active');
        $this->db->where('delete_status', 'yes');
        $query = $this->db->get('rank_details');
        foreach ($query->result_array() as $row) {
            $arr[] = $row;
        }

        return $arr;
    }

    public function getAllRankDetails($rank_id = null)
    {
        $i = 0;
        $arr = array();
        if ($rank_id != null) {
            $this->db->where('rank_id', $rank_id);
        }
        $this->db->where('delete_status', 'yes');
        $query = $this->db->get('rank_details');
        foreach ($query->result_array() as $row) {
            $arr[$i] = $row;
            $arr[$i]['package_rank'] = $this->selectPackageRankConfig($row['rank_id']);
            $arr[$i]['joinee_package'] = $this->getjoinedPackageDetails($row['rank_id']);
            $i++;
        }
        return $arr;
    }

    public function getAllBoardDetails()
    {
        $arr = array();
        $query = $this->db->get('board_configuration');
        $i = 0;
        foreach ($query->result() as $row) {
            $arr[$i]['board_id'] = $row->board_id;
            $arr[$i]['board_width'] = $row->board_width;
            $arr[$i]['board_depth'] = $row->board_depth;
            $arr[$i]['board_name'] = $row->board_name;
            $arr[$i]['board_commission'] = $row->board_commission;
            $arr[$i]['sponser_follow_status'] = $row->sponser_follow_status;
            $arr[$i]['re_entry_status'] = $row->re_entry_status;
            $arr[$i]['re_entry_to_next_status'] = $row->re_entry_to_next_status;

            $i++;
        }

        return $arr;
    }

    public function deleteMessage($id)
    {
        $query = $this->db->delete('mail_history', array('id' => $id));
        return $query;
    }

    public function setSmsConfig($details)
    {

        $this->db->set('sender_id', $details['sender_id']);
        $this->db->set('username', $details['user_name']);
        $this->db->set('password', $details['password']);
        $query = $this->db->insert('sms_config');
        return $query;
    }

    public function getSmsConfigDetails()
    {

        $details = array();
        $this->db->select('sender_id,username,password');
        $this->db->from('sms_config');
        $query = $this->db->get();

        foreach ($query->result() as $row) {

            $details['sender_id'] = $row->sender_id;
            $details['username'] = $row->username;
            $details['password'] = $row->password;
        }
        return $details;
    }

    public function updatePaypalConfig($api_username, $api_password, $api_signature, $mode, $currency, $return_url, $cancel_url)
    {
        $this->db->select('id');
        $this->db->from('paypal_config');
        $query = $this->db->get();
        $data = array(
            'api_username' => $api_username,
            'api_password' => $api_password,
            'api_signature' => $api_signature,
            'mode' => $mode,
            'currency' => $currency,
            'return_url' => $return_url,
            'cancel_url' => $cancel_url
        );
        if ($query->num_rows()) {
            $query = $this->db->update('paypal_config', $data);
        } else {
            $query = $this->db->insert('paypal_config', $data);
        }
        return $query;
    }

    public function getPaypalConfigDetails()
    {

        $this->db->select('*');
        $this->db->from('paypal_config');
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $details['api_username'] = $row->api_username;
            $details['api_password'] = $row->api_password;
            $details['api_signature'] = $row->api_signature;
            $details['mode'] = $row->mode;
            $details['currency'] = $row->currency;
            $details['return_url'] = $row->return_url;
            $details['cancel_url'] = $row->cancel_url;
            $details['repurchase_return_url'] = $row->repurchase_return_url;
            $details['repurchase_cancel_url'] = $row->repurchase_cancel_url;
            $details['package_validity_return_url'] = $row->package_validity_return_url;
            $details['package_validity_cancel_url'] = $row->package_validity_cancel_url;
        }
        if ($query->num_rows()) {
            return $details;
        }
    }

    public function getPaymentMethods()
    {

        $this->db->select('*');
        $this->db->from('payment_methods');
        $query = $this->db->get();
        $details = array();
        $i = 0;

        foreach ($query->result() as $row) {
            $details[$i]['id'] = $row->id;
            $details[$i]['payment_type'] = $row->payment_type;
            $details[$i]['status'] = $row->status;
            $i++;
        }
        return $details;
    }

    public function setPaymentStatus($id, $status)
    {
        $this->db->set('status', $status);
        $this->db->where('id', $id);
        $query = $this->db->update('payment_methods');
        //insert configuration_change_history
        $payment_history = '';
        if ($id == "1") {
            $payment_history = "Changed the Payment Gateway status to ";
        } else if ($id == "2") {
            $payment_history = "Changed the E-pin status to ";
        } else if ($id == "3") {
            $payment_history = "Changed the E-wallet status to ";
        } else if ($id == "4") {
            $payment_history = "Changed the Free joining status to ";
        }
        if ($status == "yes") {
            $payment_history .= "yes";
        } else if ($status == "no") {
            $payment_history .= "no";
        }

        $this->insertConfigChangeHistory('payment settings', $payment_history);
        //
        if ($id == 1 && $status == 'no') {
            $this->setGatewayStatusFalse();
        }
        $this->setModuleStatus('payment_gateway_status', $status);
        if ($status == 'no') {
            $this->setModuleStatus('bitcoin_status', $status);
        }
        return $query;
    }

    public function checkAtleastOnePaymentActive($id)
    {
        $this->db->select('status');
        $this->db->where('id !=', $id);
        $this->db->where('status', 'yes');
        $this->db->from('payment_methods');
        $count = $this->db->count_all_results();
        return $count;
    }

    public function checkAtleastOneCreditCardActive($id, $payout = "")
    {
        if ($payout == "payout") {
            $this->db->select('payout_status');
            $this->db->where('payout_status', 'yes');
        } else {
            $this->db->select('status');
            $this->db->where('status', 'yes');
        }
        $this->db->where('id !=', $id);
        $this->db->from('payment_gateway_config');
        $count = $this->db->count_all_results();
        return $count;
    }

    public function getLevelSettings()
    {
        $arr_comm = array();
        $this->db->select('*');
        $this->db->from('level_commision');
        $query = $this->db->get();
        $l = 0;
        foreach ($query->result_array() as $row) {
            $arr_comm[$l] = $row['level_percentage'];
            $l++;
        }
        return $arr_comm;
    }

    public function setGatewayStatusFalse()
    {
        $this->db->set('status', 'no');
        return $this->db->update('payment_gateway_config');
    }

    public function getAuthorizeConfigDetails()
    {
        $details = array();
        $this->db->select('*');
        $this->db->from('authorize_config');
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $details['merchant_id'] = $row->merchant_id;
            $details['transaction_key'] = $row->transaction_key;
        }
        return $details;
    }

    public function updateAuthorizeConfig($merchant_id, $transaction_key)
    {

        $data = array(
            'merchant_id' => $merchant_id,
            'transaction_key' => $transaction_key,
        );
        $query = $this->db->update('authorize_config', $data);
        return $query;
    }

    public function getLanguageStatus()
    {
        $language_array = array();
        $this->db->select('*');
        $this->db->from('infinite_languages');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $language_array[] = $row;
        }
        return $language_array;
    }

    function getEmailManagementContent($mail_type)
    {
        $mail = array();
        $this->db->select('*')
            ->from('common_mail_settings')
            ->where('mail_type', $mail_type);
        $qry = $this->db->get();
        foreach ($qry->result() as $row) {
            $mail['content'] = $row->mail_content;
            $mail['subject'] = $row->subject;
            $mail['mail_status'] = $row->mail_status;
        }
        return $mail;
    }

    function updateEmailManagement($arr, $mail_type = '')
    {
        $data = array(
            'subject' => $arr['subject'],
            'mail_content' => $arr['mail_content'],
            'mail_status' => $arr['mail_status'],
            'date' => date('Y-m-d h:i:s')
        );
        $this->db->where('mail_type', $mail_type);
        return $this->db->update('common_mail_settings', $data);
    }

    public function updateSortOrder($id, $order, $payout = "")
    {
        if ($payout == "payout")
            $this->db->set('payout_sort_order', $order);
        else
            $this->db->set('sort_order', $order);
        $this->db->where('id', $id);
        $query = $this->db->update('payment_gateway_config');
        return $query;
    }

    public function getBoardViewConfig()
    {

        $board_config = array();
        $i = 0;
        $this->db->from('board_configuration');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $board_config[$i]['board_id'] = $row->board_id;
            $board_config[$i]['board_name'] = $row->board_name;
            $board_config[$i]['board_depth'] = $row->board_depth;
            $board_config[$i]['board_width'] = $row->board_width;
            $board_config[$i]['amount'] = $row->amount;
            $i++;
        }
        return $board_config;
    }

    public function updateBoardConfig($i, $depth, $width, $amount)
    {
        $this->db->set('board_width', $width);
        $this->db->set('board_depth', $depth);
        $this->db->set('amount', $amount);
        $this->db->where('board_id', $i);
        return $this->db->update('board_configuration');
    }

    public function delete_rank($rank_id)
    {
        $this->db->set('delete_status', 'no');
        $this->db->set('rank_status', 'inactive');
        $this->db->where('rank_id', $rank_id);
        $result = $this->db->update('rank_details');
        return $result;
    }

    public function updateThemeFolder($admin_folder, $user_folder)
    {
        $this->db->set('admin_theme_folder', $admin_folder);
        $this->db->set('user_theme_folder', $user_folder);
        $res = $this->db->update('site_information');
        if ($res) {
            $this->admin_theme_folder = $admin_folder;
            return $res;
        }
    }

    public function getAdminThemeFolder()
    {
        $this->db->select('admin_theme_folder');
        $res = $this->db->get('site_information');
        foreach ($res->result() as $row) {
            $data = $row->admin_theme_folder;
        }
        return $data;
    }

    public function getUserThemeFolder()
    {
        $this->db->select('user_theme_folder');
        $res = $this->db->get('site_information');
        foreach ($res->result() as $row) {
            $user_data = $row->user_theme_folder;
        }
        return $user_data;
    }

    public function updateReferralSetting($post_data)
    {
        $data = [];

        $history = "MLM Plan: {$this->MLM_PLAN}, ";
        $data['sponsor_commission_type'] = $post_data['sponsor_commission_type'];
        $history .= "Referral commission type: {$post_data['sponsor_commission_type']}";

        $query = $this->db->update('configuration', $data);
        if ($query) {
            // configuration history
            $this->insertConfigChangeHistory('compensation setting', $history);
        }

        return $query;
    }

    public function updateLevelSetting($post_data)
    {
        $data = [];

        $history = "MLM Plan: {$this->MLM_PLAN}, ";
        $data['depth_ceiling'] = $post_data['depth_ceiling'];
        $history .= " Depth ceiling: {$post_data['depth_ceiling']}";

        $query = $this->db->update('configuration', $data);
        if ($data) {
            // configuration history
            $this->insertConfigChangeHistory('compensation setting', $history);
        }

        return $query;
    }

    public function updateMatrixSetting($post_data)
    {
        $data = [];

        $history = "MLM Plan: {$this->MLM_PLAN}, ";
        $data['width_ceiling'] = $post_data['width_ceiling'];
        // $data['depth_ceiling'] = $post_data['depth_ceiling'];
        $history .= "Width ceiling: {$post_data['width_ceiling']}, ";
        // $history .= "Depth ceiling: {$post_data['depth_ceiling']}";

        $query = $this->db->update('configuration', $data);
        if ($query) {
            // configuration history
            $this->insertConfigChangeHistory('compensation setting', $history);
        }

        return $query;
    }

    public function updateBinarySetting($post_data)
    {
        $data = [];

        $history = "MLM Plan: {$this->MLM_PLAN}, ";
        $data['pair_ceiling_type'] = $post_data['pair_ceiling_type'];
        $history .= "Pair ceiling type: {$data['pair_ceiling_type']}, ";
        if ($post_data['pair_ceiling_type'] != 'none') {
            $data['pair_ceiling'] = $post_data['pair_ceiling'];
            if ($post_data['pair_ceiling_type'] == 'monthly_with_daily') {
                $data['pair_ceiling_monthly'] = $post_data['pair_ceiling_monthly'];
                $history .= " Pair ceiling daily: {$data['pair_ceiling']}, ";
                $history .= " Pair ceiling monthly: {$data['pair_ceiling_monthly']}";
            } else {
                $history .= " Pair ceiling: {$data['pair_ceiling']}, ";
            }
        }
        $data['pair_value'] = $post_data['pair_value'];
        $history .= "Pair value: {$data['pair_value']}, ";
        if ($this->MODULE_STATUS['product_status'] == 'no') {
            $data['product_point_value'] = $post_data['product_point_value'];
            $history .= "Product point value: {$data['product_point_value']}, ";
        }

        $query = $this->db->update('configuration', $data);
        if ($query) {
            // configuration history
            $this->insertConfigChangeHistory('compensation setting', $history);
        }

        return $query;
    }

    public function updateBoardSetting($post_data, $board_count)
    {
        $data = [];
        $result = false;
        $history = "MLM Plan: {$this->MLM_PLAN}, ";
        $reentry_flag = false;
        for ($i = 0; $i < $board_count; $i++) {
            $data[$i]["board_width"] = $post_data["board" . $i . "_width"];
            $data[$i]["board_depth"] = $post_data["board" . $i . "_depth"];
            $data[$i]["board_name"] = $post_data["board" . $i . "_name"];
            $data[$i]["sponser_follow_status"] = $post_data["board" . $i . "_sponsor_follow_status"];
            $data[$i]["re_entry_status"] = $post_data["board" . $i . "_reentry_status"];
            $data[$i]["re_entry_to_next_status"] = ($reentry_flag) ? "no" : $post_data["board" . $i . "_reentry_to_next_status"];

            $history .= "Board width({$i}): {$data[$i]["board_width"]}, ";
            $history .= "Board depth({$i}): {$data[$i]["board_depth"]}, ";
            $history .= "Board name({$i}): {$data[$i]["board_name"]}, ";
            $history .= "Sponsor follow status({$i}): {$data[$i]["sponser_follow_status"]}, ";
            $history .= "Re-entry next({$i}): {$data[$i]["re_entry_to_next_status"]}, ";

            if ($data[$i]["re_entry_to_next_status"] == "no") {
                $reentry_flag = true;
            }

            $this->db->where('board_id', $i + 1);
            $result = $this->db->update('board_configuration', $data[$i]);
            if (!$result) {
                break;
            }
        }

        if ($result) {
            // configuration history
            $this->insertConfigChangeHistory('compensation setting', $history);
        }

        return $result;
    }

    //insert configuration_change_history
    public function insertConfigChangeHistory($activity, $desc)
    {

        $login_id = $this->LOG_USER_ID;
        $ip = $_SERVER['REMOTE_ADDR'];
        //Code to convert Ipv6 address to Ipv4
        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false) {
            $ip = hexdec(substr($ip, 0, 2)) . "." . hexdec(substr($ip, 2, 2)) . "." . hexdec(substr($ip, 5, 2)) . "." . hexdec(substr($ip, 7, 2));
        }

        $user_type = $this->LOG_USER_TYPE;
        $this->db->set('done_by', $login_id);
        $this->db->set('done_by_type', $user_type);
        $this->db->set('ip', $ip);
        $this->db->set('description', $desc);
        $this->db->set('activity', $activity);
        $this->db->set('date', date("Y-m-d H:i:s"));
        $query = $this->db->insert('configuration_change_history');
        return $query;
    }

    //

    public function getBitcoinConfigurationDetails()
    {
        $details = array();
        $this->db->select('*');
        $this->db->from('bitcoin_configuration');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $details = $query->result_array()[0];
        }
        return $details;
    }

    public function updateBitcoinConfiguration($post_array)
    {
        unset($post_array['update_bitcoin']);
        $result = $this->db->update('bitcoin_configuration', $post_array);
        if ($post_array['mode'] == 0) {
            $mode = 'test';
        } else {
            $mode = 'live';
        }
        if ($result) {
            $this->db->set('mode', $mode);
            $this->db->where('gateway_name', 'Bitcoin');
            $result = $this->db->update('payment_gateway_config');
        }
        return $result;
    }

    public function getAllStairStepDetails($step_id = null)
    {
        $arr = array();
        if ($step_id != null) {
            $this->db->where('step_id', $step_id);
        }
        $this->db->where_in('status', array('active', 'inactive'));
        $query = $this->db->get('stair_step_config');
        foreach ($query->result_array() as $row) {
            $arr[] = $row;
        }

        return $arr;
    }

    public function insertStairStepDetails($step_name, $personal_pv, $group_pv, $step_commission)
    {
        $this->db->set('step_name', $step_name);
        $this->db->set('personal_pv', $personal_pv);
        $this->db->set('group_pv', $group_pv);
        $this->db->set('step_commission', $step_commission);
        $this->db->set('status', 'active');
        $query = $this->db->insert('stair_step_config');
        return $query;
    }

    public function updateStairStep($step_id, $step_name, $personal_pv, $group_pv, $step_commission)
    {
        $this->db->set('step_name', $step_name);
        $this->db->set('personal_pv', $personal_pv);
        $this->db->set('group_pv', $group_pv);
        $this->db->set('step_commission', $step_commission);
        $this->db->where('step_id', $step_id);
        $query = $this->db->update('stair_step_config');
        return $query;
    }

    public function changeStairStepStatus($rank_id, $status)
    {
        $this->db->set('status', $status);
        $this->db->where('step_id', $rank_id);
        $result = $this->db->update('stair_step_config');
        return $result;
    }

    public function getSignupConfiguration()
    {
        $signup_config = array();

        // Pending Signup Options
        $signup_config['pending_signup_config'] = $this->getPendingSignupConfig();
        // Signup Options
        $signup_config['general_signup_config'] = $this->getGeneralSignupConfig();

        return $signup_config;
    }

    public function getGeneralSignupConfig()
    {
        $res = $this->db->get('signup_settings');
        return $res->row_array();
    }

    public function getBankInfoStatus()
    {
        $this->db->select('bank_info_required');
        $res = $this->db->get('signup_settings');
        return $res->row_array()['bank_info_required'];
    }

    public function getCompressedCommissionStatus()
    {
        $this->db->select('compression_commission');
        $res = $this->db->get('signup_settings');
        return $res->row_array()['compression_commission'];
    }

    public function getSignupMailSendStatus()
    {
        $this->db->select('mail_notification');
        $res = $this->db->get('signup_settings');
        return $res->row_array()['mail_notification'];
    }

    public function getPendingSignupConfig()
    {
        $this->db->select('gateway_name as payment_method');
        $this->db->from('payment_gateway_config');
        $this->db->where('gateway_name !=', 'EPDQ');
        $this->db->where('status', 'yes');
        $query1 = $this->db->get_compiled_select();

        $this->db->select('payment_type as payment_method');
        $this->db->from('payment_methods');
        $this->db->where('payment_type !=', 'Payment Gateway');
        $this->db->where('payment_type !=', 'Bank Transfer');
        $this->db->where('status', 'yes');
        $query2 = $this->db->get_compiled_select();

        if (DEMO_STATUS == 'yes' && $this->MODULE_STATUS['basic_demo_status'] == 'yes' && $this->validation_model->isPresetDemo($this->validation_model->getAdminId())) {
            $query3 = $this->db->get_compiled_select("({$query2}) as p");
        } else {
            $query3 = $this->db->get_compiled_select("({$query1} UNION {$query2}) as p");
        }

        $this->db->select('p1.*');
        $this->db->from('pending_signup_config as p1');
        $this->db->join("($query3) as p2", 'p1.payment_method = p2.payment_method', 'inner');
        $res = $this->db->get();
        return $res->result_array();
    }

    public function updatePendingSignupConfig($id, $status)
    {
        $this->db->set('status', $status);
        $this->db->where('id', $id);
        return $this->db->update('pending_signup_config');
    }

    public function getPendingSignupStatus($payment_type)
    {
        if ($payment_type == 'bank_transfer') {
            return 1;
        }

        switch ($payment_type) {
            case 'ewallet':
                $payment_method = 'E-wallet';
                break;
            case 'epin':
                $payment_method = 'E-pin';
                break;
            case 'free_join':
                $payment_method = 'Free Joining';
                break;
            case 'paypal':
                $payment_method = 'Paypal';
                break;
            case 'authorize.net':
                $payment_method = 'Authorize.Net';
                break;
            case 'bitcoin':
                $payment_method = 'Bitcoin';
                break;
            case 'bank_transfer':
                $payment_method = 'Bank Transfer';
                break;
            case 'bitgo':
                $payment_method = 'BitGo';
                break;
            case 'blockchain':
                $payment_method = 'Blockchain';
                break;
            case 'payeer':
                $payment_method = 'Payeer';
                break;
            default:
                $payment_method = $payment_type;
                break;
        }

        $this->db->select('status');
        $this->db->where('payment_method', $payment_method);
        $query = $this->db->get('pending_signup_config');
        return $query->row_array()['status'];
    }

    public function updateSignupSettings($key, $value)
    {
        $this->db->set($key, $value);
        $res = $this->db->update('signup_settings');
        return $res;
    }

    public function updateSignupConfig($data)
    {
        $res = $this->db->update('signup_settings', $data);
        return $res;
    }

    public function updateModuleStatus($key, $value)
    {
        $this->db->set($key, $value);
        $res = $this->db->update('module_status');
        return $res;
    }

    public function getPaymentGatewayStatus()
    {

        $status = null;
        $this->db->select('payment_gateway_status');
        $this->db->from("module_status");
        $this->db->limit(1);
        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            $status = $row['payment_gateway_status'];
        }
        return $status;
    }

    //insert configuration_change_history
    public function getPaymentGatewayName($id)
    {

        $this->db->select('payment_method');
        $this->db->from('pending_signup_config');
        $this->db->where('id', $id);

        $res = $this->db->get();
        return $res->row_array()['payment_method'];
    }

    public function getCreditCardDetails($id, $payout = "")
    {

        $this->db->select('*');
        $this->db->from('payment_gateway_config');
        $this->db->where('id', $id);

        $query = $this->db->get();
        $details = array();
        $i = 0;
        foreach ($query->result() as $row) {
            if ($row->gateway_name != 'Creditcard') {
                $details['id'] = $row->id;
                $details['gateway_name'] = $row->gateway_name;
                if ($payout == "payout") {
                    $details['status'] = $row->status;
                    $details['sort_order'] = $row->sort_order;
                } else {
                    $details['status'] = $row->payout_status;
                    $details['sort_order'] = $row->payout_sort_order;
                }
                $details['logo'] = $row->logo;
                $details['mode'] = $row->mode;
            }
        }

        return $details;
    }

    public function isRegistrationAllowed()
    {
        if ($this->session->has_userdata('inf_logged_in')) {
            $log_user_type = $this->session->userdata('inf_logged_in')['user_type'];
            if ($log_user_type == 'admin' || $log_user_type == 'employee') {
                return true;
            }
        }
        $this->db->select('registration_allowed');
        $query = $this->db->get('signup_settings');
        $status = $query->row_array()['registration_allowed'];
        return ($status == 'yes');
    }

    public function isSponsorRequired()
    {
        if ($this->session->has_userdata('inf_logged_in')) {
            $log_user_type = $this->session->userdata('inf_logged_in')['user_type'];
            if ($log_user_type == 'admin' || $log_user_type == 'employee') {
                return true;
            }
        }
        $this->db->select('sponsor_required');
        $query = $this->db->get('signup_settings');
        $status = $query->row_array()['sponsor_required'];
        return ($status == 'yes');
    }

    public function getSignupBinaryLeg()
    {
        $this->db->select('binary_leg');
        $query = $this->db->get('signup_settings');
        $res = $query->row_array()['binary_leg'];
        if ($res == 'left') {
            $res = 'L';
        } elseif ($res == 'right') {
            $res = 'R';
        } else {
            $res = 'any';
        }
        return $res;
    }

    public function getAgeLimitSetting()
    {
        $this->db->select('age_limit');
        $query = $this->db->get('signup_settings');
        return $query->row_array()['age_limit'];
    }

    //replication site config
    public function selectBanner($prefix)
    {
        $det = array();

        $this->db->select('id,type,content,subject,user_id');
        $this->db->from('replica_banners');
        $this->db->where('user_id', $prefix);
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $det[$i]['id'] = $row['id'];
            $det[$i]['content'] = $row['content'];
            $det[$i]['user_id'] = $row['user_id'];
            $det[$i]['subject'] = $row['subject'];
            $i++;
        }
        return $det;
    }

    //
    //inactiviy logout setting
    public function selectLogoutTime()
    {
        $this->db->select('logout_time');
        $this->db->from('common_settings');
        $this->db->where('active', 'yes');
        $res = $this->db->get();
        return $res->row_array()['logout_time'];
    }

    public function updateLogoutTime($time)
    {
        $this->db->set('logout_time', $time);
        $this->db->set('active', 'yes');
        $query = $this->db->update('common_settings');
        return $query;
    }

    public function getBlockchainConfigurationDetails()
    {
        $details = array();
        $this->db->select('*');
        $this->db->from('blockchain_config');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $details = $query->result_array()[0];
        }
        $details['my_xpub'] = $this->encrypt->decode($details['my_xpub']);
        $details['my_api_key'] = $this->encrypt->decode($details['my_api_key']);
        $details['main_password'] = $this->encrypt->decode($details['main_password']);
        $details['second_password'] = $this->encrypt->decode($details['second_password']);
        return $details;
    }

    public function updateBlockchainConfiguration($post_array)
    {
        unset($post_array['update_blockchain']);
        $post_array['my_xpub'] = $this->encrypt->encode($post_array['my_xpub']);
        $post_array['my_api_key'] = $this->encrypt->encode($post_array['my_api_key']);
        $post_array['main_password'] = $this->encrypt->encode($post_array['main_password']);
        $post_array['second_password'] = $this->encrypt->encode($post_array['second_password']);
        $result = $this->db->update('blockchain_config', $post_array);
        return $result;
    }

    //Bitgo Configuration details starts
    public function getBitgoConfigurationDetails($mode = 'test')
    {
        $details = array();
        $this->db->select('*');
        $this->db->from('bitgo_configuration');
        $this->db->where('mode', $mode);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $details = $query->result_array()[0];
        }
        $details['wallet_passphrase'] = $this->encryptDecrypt($details['wallet_passphrase'], "decryption");

        return $details;
    }

    public function updateBitgoConfiguration($post_array)
    {
        $passphrase = $this->encryptDecrypt($post_array['passphrase'], "encryption");
        $this->db->set('wallet_id', $post_array['wallet_id']);
        $this->db->set('token', $post_array['token']);
        $this->db->set('wallet_passphrase', $passphrase);
        $this->db->where('mode', $post_array['mode']);
        $result = $this->db->update('bitgo_configuration');

        if ($result) {
            $this->db->set('mode', $post_array['mode']);
            $this->db->where('gateway_name', 'Bitgo');
            $result = $this->db->update('payment_gateway_config');
        }
        return $result;
    }

    public function getPaymentGatewayMode($payment_gateway = "")
    {

        $query = $this->db->select('mode')->where('gateway_name', $payment_gateway)->get('payment_gateway_config');
        foreach ($query->result() as $row) {
            return $row->mode;
        }
    }

    public function encryptDecrypt($value, $type)
    {
        $key = $this->config->item('encryption_key');
        if ($type == "encryption") {
            $rs = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $value, MCRYPT_MODE_CBC, md5(md5($key))));
        }
        if ($type == "decryption") {
            $rs = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($value), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
        }
        return $rs;
    }

    //Bitgo Configuration details  ends

    public function getMinPayout()
    {
        $this->db->select('min_payout');
        $query = $this->db->get('configuration');
        return $query->row_array()['min_payout'];
    }

    //Social profile count updation
    public function getSocialMediaFollowersCount()
    {
        $this->db->select('fb_count,twitter_count,inst_count,gplus_count');
        $res = $this->db->get('site_information');
        return $res->result_array();
    }

    public function updateSocialProfileCountAndLink($social_arr, $flag = 'no')
    {
        $this->db->set('fb_count', $social_arr['fb_count']);
        $this->db->set('twitter_count', $social_arr['twitter_count']);
        $this->db->set('inst_count', $social_arr['inst_count']);
        // $this->db->set('gplus_count', $social_arr['gplus_count']);
        if ($flag == 'no') {
            $this->db->set('fb_link', $social_arr['fb_link']);
            $this->db->set('twitter_link', $social_arr['twitter_link']);
            $this->db->set('inst_link', $social_arr['inst_link']);
            // $this->db->set('gplus_link', $social_arr['gplus_link']);
        }
        $result = $this->db->update('site_information');
        return $result;
    }

    public function getUserWiseSignupBinaryLeg($user_id)
    {
        $this->db->select('binary_leg');
        $this->db->where('id', $user_id);
        $query = $this->db->get('ft_individual');
        $res = $query->row_array()['binary_leg'];
        if ($res == 'left') {
            $res = 'L';
        } elseif ($res == 'right') {
            $res = 'R';
        } elseif ($res == 'weak_leg') {
            $this->db->select('total_left_count left,total_right_count right');
            $this->db->where('id', $user_id);
            $query = $this->db->get('leg_details');
            $leg_details = $query->row_array();
            if ($leg_details['left'] == $leg_details['right']) {
                $res = 'any';
            } elseif ($leg_details['left'] < $leg_details['right']) {
                $res = 'L';
            } elseif ($leg_details['left'] > $leg_details['right']) {
                $res = 'R';
            }
        } else {
            $res = 'any';
        }
        return $res;
    }

    //Social profile Link updation
    public function getSocialMediaLinks()
    {
        $this->db->select('fb_link,twitter_link,inst_link,gplus_link');
        $res = $this->db->get('site_information');
        return $res->result_array();
    }

    public function updateSocialProfileLink($social_arr)
    {
        $this->db->set('fb_link', $social_arr['fb_link']);
        $this->db->set('twitter_link', $social_arr['twitter_link']);
        $this->db->set('inst_link', $social_arr['inst_link']);
        $this->db->set('gplus_link', $social_arr['gplus_link']);
        $result = $this->db->update('site_information');
        return $result;
    }

    public function getUserMenuId()
    {

        $menu = $this->getOuterPlanMenus("menu");
        $this->db->select('*');
        $this->db->where_not_in('id', $menu);
        //$this->db->where('status', 'yes');
        $this->db->order_by("main_order_id");
        $this->db->from("infinite_mlm_menu");
        $query = $this->db->get();
        return $query;
    }

    public function getUserSubMenuId($id)
    {

        $menu = $this->getOuterPlanMenus("sub_menu");
        $this->db->select('*');
        $this->db->where('sub_refid', $id);
        $this->db->where_not_in('sub_link_ref_id', $menu);
        //$this->db->where('perm_dist', 1);
        //$this->db->where('sub_status', 'yes');
        $this->db->order_by("sub_order_id");
        $this->db->from("infinite_mlm_sub_menu");
        $query = $this->db->get();
        return $query;
    }

    public function updateMenuConfig($id, $status, $attr)
    {
        $this->db->set($attr, $status);
        $this->db->where('id', $id);
        return $this->db->update('infinite_mlm_menu');
    }

    public function updateSubMenuConfig($id, $status, $attr)
    {
        $this->db->set($attr, $status);
        $this->db->where('sub_id', $id);
        return $this->db->update('infinite_mlm_sub_menu');
    }

    public function getOuterPlanMenus($menu)
    {
        $module_status = $this->db->get('module_status')->row_array();

        $mlm_plan = $module_status['mlm_plan'];
        $epin = $module_status['pin_status'];
        $package = $module_status['product_status'];
        $employee = $module_status['employee_status'];
        $sms = $module_status['sms_status'];
        $language = $module_status['lang_status'];
        $currency = $module_status['multy_currency_status'];
        $lcp = $module_status['lead_capture_status'];
        $lcp_type = $module_status['lcp_type'];
        $ticket_system = $module_status['ticket_system_status'];
        $store = $module_status['opencart_status'];
        $auto_responder = $module_status['autoresponder_status'];
        $replica = $module_status['replicated_site_status'];
        $purchase = $module_status['repurchase_status'];
        $package_validity = $module_status['product_validity'];
        $maintenance = $module_status['maintenance_status'];
        $upgrade = $module_status['package_upgrade'];
        $roi_status = $module_status['roi_status'];
        $kyc_status = $module_status['kyc_status'];
        $gdpr_status = $module_status['gdpr'];
        $purchase_wallet = $module_status['purchase_wallet'];

        $crm = 'no';
        if ($lcp_type == 'lcp_crm') {
            $crm = 'yes';
        }
        if ($lcp == 'no') {
            $auto_responder = 'no';
            $crm = 'no';
        }

        $menu_show = [];
        $menu_hide = [];
        $submenu_show = [];
        $submenu_hide = [];

        $submenu_hide = array(204, 126, 181, 13, 18, 158, 10, 14, 194, 70, 17, 81, 102, 121, 208, 209, 210, 211);
        $menu_hide = array(1, 4, 50, 36, 41, 3, 5, 40, 26, 45, 6, 49, 20, 22, 38);

        if ($mlm_plan == 'Board' || $mlm_plan == 'Table')
            $submenu_hide[] = 58;
        else
            $submenu_hide[] = 101;
        if ($mlm_plan != 'Party') {
            $menu_hide[] = 39;
            $submenu_hide[] = 103;
            $submenu_hide[] = 105;
            $submenu_hide[] = 112;
            $submenu_hide[] = 114;
        }
        if ($mlm_plan != 'Stair_Step') {
            $submenu_hide[] = 161;
            $submenu_hide[] = 159;
            $submenu_hide[] = 160;
        }
        if ($mlm_plan != 'Donation') {
            $menu_hide[] = 54;
        }

        if ($store == 'no') {
            $menu_hide[] = 37;
            $menu_hide[] = 42;
            $menu_hide[] = 56;
            $submenu_hide[] = 125;
            $submenu_hide[] = 167;
        } else {
            $package = 'no';
            $purchase = 'no';
            $upgrade = 'no';
            $package_validity = 'no';
            $submenu_hide[] = 182;
        }


        if ($package == 'no') {
            $menu_hide[] = 12;
            $submenu_hide[] = 187;
            $submenu_hide[] = 50;
        }
        if ($upgrade == 'no') {
            $menu_hide[] = 51;
        }
        if ($package_validity == 'no') {
            $submenu_hide[] = 162;
            $submenu_hide[] = 163;
        }
        if ($purchase == 'no') {
            $menu_hide[] = 46;
            $submenu_hide[] = 188;
            $submenu_hide[] = 155;
        }
        if ($upgrade == 'no') {
            $submenu_hide[] = 196;
            $submenu_hide[] = 224;
        }

        if ($epin == 'no') {
            $menu_hide[] = 13;
            $submenu_hide[] = 27;
            $submenu_hide[] = 30;
            $submenu_hide[] = 26;
            $submenu_hide[] = 180;
            $submenu_hide[] = 193;
            $submenu_hide[] = 47;
            $submenu_hide[] = 29;
            $submenu_hide[] = 28;
        }

        if ($employee == 'no') {
            $menu_hide[] = 17;
            $submenu_hide[] = 42;
            $submenu_hide[] = 41;
            $submenu_hide[] = 43;
            $submenu_hide[] = 44;
            $submenu_hide[] = 156;
        }

        if ($sms == 'no') {
            $menu_hide[] = 18;
        }

        if ($ticket_system == 'no') {
            $menu_hide[] = 32;
        }

        if ($replica == 'no') {
            $submenu_hide[] = 185;
        }

        if ($lcp == 'no' && $crm == 'no') {
            $submenu_hide[] = 77;
        }

        if ($crm == 'no') {
            $menu_hide[] = 44;
            $submenu_hide[] = 135;
            $submenu_hide[] = 136;
            $submenu_hide[] = 137;
            $submenu_hide[] = 138;
        }

        if ($auto_responder == 'no') {
            $submenu_hide[] = 200;
        }

        if ($maintenance == 'no') {
            $submenu_hide[] = 129;
        }
        if ($roi_status == "no") {
            $menu_hide[] = 55;
            $submenu_hide[] = 207;
        }
        if ($kyc_status == "no") {
            $submenu_hide[] = 225;
            $submenu_hide[] = 226;
        }
        if ($gdpr_status == 'no') {
            $submenu_hide[] = 220;
            $submenu_hide[] = 221;
        }
        if ($purchase_wallet == 'no') {
            $submenu_hide[] = 242;
        }
        $bank_status = $this->getPaymentStatus('Bank Transfer');
        if ($bank_status == 'no') {
            $menu_hide[] = 61;
            $submenu_hide[] = 252;
        }
        if ($menu == "menu") {
            return $menu_hide;
        } else if ($menu == "sub_menu") {
            return $submenu_hide;
        }
    }

    public function getMenuIdFromSub($id)
    {
        $menu_id = "";

        $this->db->select('sub_refid');
        $this->db->where('sub_id', $id);
        $this->db->from("infinite_mlm_sub_menu");
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $menu_id = $row->sub_refid;
        }
        return $menu_id;
    }

    public function getDonationConfig()
    {

        $this->db->select('*');
        $this->db->from('donation_rate');
        $res = $this->db->get();

        return $res->result_array();
    }

    public function updageDonationConfig($conf_post_array, $donation_count)
    {

        $this->db->set('donation_type', $conf_post_array["donation_type"]);
        $this->db->update('configuration');

        for ($i = 1; $i <= $donation_count; $i++) {

            if (array_key_exists('don_rate_pm' . $i, $conf_post_array) || array_key_exists('level_name' . $i, $conf_post_array) || array_key_exists('don_count' . $i, $conf_post_array)) {

                $this->db->set('pm_rate', $conf_post_array["don_rate_pm$i"]);
                $this->db->set('level_name', $conf_post_array["level_name$i"]);
                $this->db->set('referral_count', $conf_post_array["don_count$i"]);
                $this->db->where('id', $i);
                $res = $this->db->update('donation_rate');
            }
        }
        return $res;
    }

    public function getDonationLevelSettings()
    {
        $this->load->model('donation_model');
        $arr_comm = array();
        $this->db->select('*');
        $this->db->from('level_commision');
        $query = $this->db->get();
        $l = 0;
        foreach ($query->result_array() as $row) {
            $row['level_name'] = $this->donation_model->getLevelName($row['id']);
            $arr_comm[$l] = $row;
            $l++;
        }
        return $arr_comm;
    }

    public function setPaymentStatusAvailable($id, $status, $attr)
    {
        $this->db->set($attr, $status);
        $this->db->where('id', $id);
        $query = $this->db->update('payment_gateway_config');
        return $query;
    }

    public function insertHolidays($date, $reason)
    {
        $this->db->set('date', $date);
        $this->db->set('reason', $reason);
        $this->db->set('status', 1);
        $query = $this->db->insert('public_holidays');
        return $query;
    }

    public function getPublicHolidays()
    {
        $this->db->select('*');
        $this->db->where("status", 1);
        $res = $this->db->get('public_holidays');
        return $res->result_array();
    }

    public function deleteHolidays($id)
    {
        $this->db->set('status', 0);
        $this->db->where("id", $id);
        $query = $this->db->update('public_holidays');
        return $query;
    }

    public function isdateAvailable($date = '')
    {
        $flag = false;
        $this->db->select("COUNT(*) AS cnt");
        $this->db->from("public_holidays");
        $this->db->where('status ', '1');
        $this->db->where('date', $date);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $count = $row->cnt;
        }
        if ($count > 0) {
            $flag = true;
        } else {
            $flag = false;
        }
        return $flag;
    }

    public function getAvailableAny($id)
    {
        $flag = false;
        $this->db->select('*');
        $this->db->where("id", $id);
        $query = $this->db->get('payment_gateway_config');
        foreach ($query->result_array() as $row) {
            if ($row['registration'] == 1 || $row['repurchase'] == 1 || $row['membership_renewal'] == 1 || $row['upgradation'] == 1)
                $flag = true;
        }
        return $flag;
    }

    public function updateXupSettings($post_array, $module_status, $default_currency_value)
    {

        $settings_array = array();
        $level = (int)$post_array['xup_level'];
        $settings_array['xup_level'] = $level;
        $additional_history = "X-UP level changed to $level";
        $query = $this->db->update('configuration', $settings_array);

        $this->insertConfigChangeHistory('additional settings', $additional_history);
        return $query;
    }

    public function ReferalCountAvailable($ref_count)
    {
        $this->db->where('referal_count', $ref_count);
        $this->db->where('delete_status !=', 'no');
        $count = $this->db->count_all_results('rank_details');
        return ($count === 0);
    }

    public function isRankNameAvailable($rankname, $rank_id = '')
    {
        $flag = false;
        $this->db->select("COUNT(*) AS cnt");
        $this->db->from("rank_details");
        $this->db->where('rank_name', "$rankname");
        if ($rank_id != '') {
            $this->db->where('rank_id !=', $rank_id);
        }
        $this->db->where('delete_status !=', 'no');
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $count = $row->cnt;
        }
        if ($count > 0) {
            $flag = true;
        } else {
            $flag = false;
        }
        return $flag;
    }

    public function getKycDocCategory($id = '')
    {
        $this->db->select('*');
        $this->db->where('status', 'active');
        if ($id) {
            $this->db->where('id', $id);
        }
        $this->db->from('kyc_category');
        $query = $this->db->get();
        $details = array();
        $i = 0;

        foreach ($query->result() as $row) {
            $details[$i]['id'] = $row->id;
            $details[$i]['category'] = $row->category;
            $i++;
        }
        return $details;
    }

    public function insertKycCategory($catg)
    {
        $this->db->set('category', $catg);
        $this->db->set('status', 'active');
        $query = $this->db->insert('kyc_category');
        return $query;
    }

    public function updateKycCategory($id, $catg)
    {
        $this->db->set('category', $catg);
        $this->db->where('status', 'active');
        $this->db->where('id', $id);
        $query = $this->db->update('kyc_category');
        return $query;
    }

    public function deleteKycCategory($id)
    {
        $this->db->set('status', 'deleted');
        $this->db->where('id', $id);
        $query = $this->db->update('kyc_category');
        return $query;
    }

    public function isKycCategoryNameAvailable($name, $id = '')
    {
        $flag = true;
        $this->db->select("COUNT(*) AS cnt");
        $this->db->from("kyc_category");
        $this->db->where('category', "$name");
        if ($id != '') {
            $this->db->where('id', $id);
        }
        $this->db->where('status !=', 'deleted');
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $count = $row->cnt;
        }
        if ($count > 0) {
            $flag = false;
        }
        return $flag;
    }

    public function getMatchingBonusConfig()
    {
        $config = [];
        $this->db->select('level_no,bonus_percent');
        $this->db->order_by('level_no');
        $query = $this->db->get('matching_bonus');
        foreach ($query->result_array() as $row) {
            $config[$row['level_no']] = $row['bonus_percent'];
        }
        return $config;
    }

    public function getPoolBonusConfig()
    {
        $config = [];
        $this->db->select('level_no,bonus_percent');
        $this->db->order_by('level_no');
        $query = $this->db->get('pool_bonus');
        foreach ($query->result_array() as $row) {
            $config[$row['level_no']] = $row['bonus_percent'];
        }
        return $config;
    }

    public function getPerformanceBonusConfig()
    {
        $config = [];
        $this->db->select('bonus_name,personal_pv,group_pv,bonus_percent');
        $query = $this->db->get('performance_bonus');
        foreach ($query->result_array() as $row) {
            $config[$row['bonus_name']] = [
                'personal_pv' => $row['personal_pv'],
                'group_pv' => $row['group_pv'],
                'bonus_percent' => $row['bonus_percent']
            ];
        }
        return $config;
    }

    public function getFastStartBonusConfig()
    {
        $this->db->select('referral_count,days_count,bonus_amount');
        $query = $this->db->get('fast_start_bonus');
        return $query->row_array();
    }

    public function getMatchingBonusLevels()
    {
        $query = $this->db->count_all_results('matching_bonus');
        return $query;
    }

    public function getPerformanceBonusCount()
    {
        $query = $this->db->count_all_results('performance_bonus');
        return $query;
    }

    public function getPoolBonusLevels()
    {
        $query = $this->db->count_all_results('pool_bonus');
        return $query;
    }

    public function updateMatchingBonus($data)
    {
        $res = false;
        $history = '';
        $matching_bonus_status = $this->validation_model->getConfig('matching_bonus');
        $matching_bonus_levels = $this->getMatchingBonusLevels();
        if ($matching_bonus_status == 'yes' && $matching_bonus_levels > 0) {
            for ($i = 1; $i <= $matching_bonus_levels; $i++) {
                $history .= "Level {$i} bonus: {$data["matching_level{$i}"]}, ";
                $this->db->set('bonus_percent', $data["matching_level{$i}"]);
                $this->db->where('level_no', $i);
                $res = $this->db->update('matching_bonus');
                if (!$res) {
                    break;
                }
            }
        }

        if ($res) {
            // configuration history
            $res = $this->insertConfigChangeHistory('matching bonus', $history);
        }

        return $res;
    }

    public function updatePoolBonus($data)
    {
        $res = false;
        $history = '';
        $pool_bonus_status = $this->validation_model->getConfig('pool_bonus');
        $pool_bonus_levels = $this->getPoolBonusLevels();
        if ($pool_bonus_status == 'yes' && $pool_bonus_levels > 0) {
            $history .= "Bonus(%): {$data['pool_bonus']}, ";
            $this->db->set('pool_bonus_percent', $data['pool_bonus']);
            $res = $this->db->update('configuration');

            for ($i = 1; $i <= $pool_bonus_levels; $i++) {
                $history .= "Level {$i} bonus: {$data["pool_level{$i}"]}, ";
                $this->db->set('bonus_percent', $data["pool_level{$i}"]);
                $this->db->where('level_no', $i);
                $res = $this->db->update('pool_bonus');
                if (!$res) {
                    break;
                }
            }
        }

        if ($res) {
            // configuration history
            $res = $this->insertConfigChangeHistory('matching bonus', $history);
        }

        return $res;
    }

    public function updateFastStartBonus($data)
    {
        $res = false;
        $history = '';
        $fast_start_bonus_status = $this->validation_model->getConfig('fast_start_bonus');
        if ($fast_start_bonus_status == 'yes') {
            $history .= "Referral count: {$data['fast_start_referral_count']}, ";
            $history .= "No.of Days (from date of join): {$data['fast_start_days']}, ";
            $history .= "Bonus amount: {$data['fast_start_bonus']}, ";
            $this->db->set('referral_count', $data['fast_start_referral_count']);
            $this->db->set('days_count', $data['fast_start_days']);
            $this->db->set('bonus_amount', $data['fast_start_bonus']);
            $res = $this->db->update('fast_start_bonus');
        }

        if ($res) {
            // configuration history
            $res = $this->insertConfigChangeHistory('matching bonus', $history);
        }

        return $res;
    }

    public function updatePerformanceBonus($data)
    {
        $res = false;
        $history = '';
        $performance_bonus_status = $this->validation_model->getConfig('performance_bonus');
        if ($performance_bonus_status == 'yes') {
            $performance_bonus_count = $this->getPerformanceBonusCount();
            for ($i = 1; $i <= $performance_bonus_count; $i++) {
                $history .= "Bonus ({$i})- ";
                $history .= "Personal PV: {$data["performance{$i}_personal_pv"]}, ";
                $history .= "Group PV: {$data["performance{$i}_group_pv"]}, ";
                $history .= "Bonus(%): {$data["performance{$i}_bonus_percent"]} | ";
                $this->db->set('personal_pv', $data["performance{$i}_personal_pv"]);
                $this->db->set('group_pv', $data["performance{$i}_group_pv"]);
                $this->db->set('bonus_percent', $data["performance{$i}_bonus_percent"]);
                $this->db->where('id', $i);
                $res = $this->db->update('performance_bonus');
                if (!$res) {
                    break;
                }
            }
        }

        if ($res) {
            // configuration history
            $res = $this->insertConfigChangeHistory('matching bonus', $history);
        }

        return $res;
    }

    public function getTooltipDetails()
    {
        $details = [];
        $this->db->where('view_status', 'yes');
        $query = $this->db->get('tooltip_config');
        $i = 0;
        foreach ($query->result() as $row) {
            $details[$i]['id'] = $row->id;
            $details[$i]['label'] = $row->label;
            $details[$i]['status'] = $row->status;
            $i++;
        }
        return $details;
    }

    public function updateTooltipSettings($data)
    {
        $res = false;
        $this->db->set('status', 'no');
        $this->db->where('view_status', 'yes');
        $res = $this->db->update('tooltip_config');

        foreach ($data as $v) {
            $this->db->set('status', 'yes');
            $this->db->where('id', $v);
            $res = $this->db->update('tooltip_config');
        }
        return $res;
    }

    public function getMenuTextId($menu_id)
    {
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

    public function getSubmenuText($menu_id)
    {
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

    public function getPaymentStatus($type)
    {
        $status = '';
        $this->db->select('status');
        $this->db->like('payment_type', $type);
        $this->db->from('payment_methods');
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $status = $row->status;
        }
        return $status;
    }

    public function getPayeerConfigurationDetails()
    {
        $details = array();
        $this->db->select('*');
        $this->db->from('payeer_settings');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $details = $query->result_array()[0];
        }

        return $details;
    }

    public function updatePayeerConfiguration($post_array)
    {
        $this->db->set('merchant_id', $post_array['merchant_id']);
        $this->db->set('merchant_key', $post_array['merchant_key']);
        $this->db->set('encryption_key', $post_array['encryption_key']);
        $this->db->set('account', $post_array['account']);
        $result = $this->db->update('payeer_settings');
        return $result;
    }

    public function getSofortConfigDetails()
    {
        $details = array();
        $this->db->select('*');
        $this->db->from('sofort_configuration');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $details['project_id'] = $row->project_id;
            $details['customer_id'] = $row->customer_id;
            $details['project_pass'] = $row->project_pass;
        }
        return $details;
    }

    public function updateSofortConfig($project_id, $customer_id, $project_pass)
    {
        $data = array(
            'project_id' => $project_id,
            'customer_id' => $customer_id,
            'project_pass' => $project_pass,
        );
        $query = $this->db->update('sofort_configuration', $data);
        return $query;
    }

    public function updateMailGunSettings($mail_setting)
    {

        $this->db->set('from_name', $mail_setting['from_name']);
        $this->db->set('from_email', $mail_setting['from_email']);
        $this->db->set('reply_to', $mail_setting['reply_to']);
        $this->db->set('domain', $mail_setting['domain']);
        $this->db->set('api_key', $mail_setting['api_key']);
        $this->db->where('id', '1');
        $query = $this->db->update('mailgun_configuration');
        return $query;
    }

    public function getMailGunConfig()
    {
        $details = array();
        $this->db->select('*');
        $this->db->from('mailgun_configuration');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $details = $row;
        }
        return $details;
    }

    public function updateAdditionalBonusStatus($bonus_name, $status)
    {
        $res = false;
        if (in_array($bonus_name, ['matching_bonus', 'pool_bonus', 'fast_start_bonus', 'performance_bonus'])) {
            $this->db->set($bonus_name, $status);
            $res = $this->db->update('configuration');
        }
        return $res;
    }

    public function getSquareUpConfigDetails()
    {
        $details = array();
        $this->db->select('*');
        $this->db->from('squareup_config');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $details = $row;
        }
        return $details;
    }

    public function updateSquareUpConfig($access_token, $application_id, $location_id)
    {
        $data = array(
            'access_token' => $access_token,
            'location_id' => $location_id,
            'application_id' => $application_id
        );
        $query = $this->db->update('squareup_config', $data);
        return $query;
    }

    public function getSiteName()
    {
        $company_name = "";
        $this->db->select('company_name');
        $this->db->from('site_information');
        $query = $this->db->get();
        $company_name = $query->row('company_name');
        return $company_name;
    }

    public function getPayeerSettings($type = '')
    {
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
    public function getLevelSettingsRegPck()
    {
        $arr_comm = [];
        $this->db->select('*');
        $this->db->from('level_commission_reg_pck');
        $this->db->order_by("level", "asc");
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            if (array_key_exists($row->level, $arr_comm)) {
                $arr_comm[$row->level][$row->pck_id . "reg"] = $row->cmsn_reg_pck;
                $arr_comm[$row->level][$row->pck_id . "member"] = $row->cmsn_member_pck;
            } else {
                $arr_comm[$row->level] = ['level' => $row->level, $row->pck_id . "reg" => $row->cmsn_reg_pck, $row->pck_id . "member" => $row->cmsn_member_pck];
            }
        }
        return $arr_comm;
    }
    public function getLevelCommissionPackages()
    {
        $MODULE_STATUS = $this->trackModule();
        if ($MODULE_STATUS['opencart_status'] != "yes" || $MODULE_STATUS['opencart_status_demo'] != "yes") {
            $this->db->select('product_name,prod_id');
            $this->db->from('package');
            $this->db->where('type_of_package', 'registration');
            $this->db->where('active', 'yes');
            $this->db->order_by("product_id", "asc");
            $query = $this->db->get();
        }else{
            $this->db->select('op.model product_name,op.package_id as prod_id');
            $this->db->from("oc_product op");
            $this->db->where('op.package_type', 'registration');
            $this->db->where('op.status', 1);
            $this->db->order_by("op.product_id", "asc");
            $query = $this->db->get();
        }
        return $query->result_array();
    }
    public function updatePackageLevelCommission($post_data, $default_currency_value)
    {

        $current_level = $this->validation_model->getMaxLevel();
        $new_level = $this->validation_model->getConfig('commission_upto_level');
        $commission_type = $this->validation_model->getConfig('commission_criteria');
        $history = "";
        $result = false;
        if ($commission_type == 'genealogy') {
            if ($new_level == $current_level) {
                if($this->MLM_PLAN != 'Donation'){
                    for ($j = 1; $j <= $current_level; $j++) {
                        if (array_key_exists('level_percentage' . $j, $post_data)) {
                            $level_data[$j] = round($post_data['level_percentage' . $j] / $default_currency_value, 8);
                            $history .= " Level percentage({$j}): {$level_data[$j]}, ";

                            $this->db->set('level_percentage', $level_data[$j]);
                            $this->db->where('level_no', $j);
                            $result = $this->db->update('level_commision');
                            if (!$result) {
                                break;
                            }
                        }
                    }
                }else{
                    $donaion_count = $post_data['donation_count'];
                    for ($j = 1; $j <= $current_level; $j++) {
                        for ($k = 1; $k <= $donaion_count; $k++) {
                            $level_data[$j]['donation_' . $k] = round($post_data['level_' . $j . '_donation_' . $k] / $default_currency_value, 8);
                            $history .= "Level({$j}) ({$k}): " . $post_data['level_' . $j . '_donation_' . $k];

                            $this->db->where('level_no', $j);
                            $result = $this->db->update('level_commision', $level_data[$j]);
                            if (!$result) {
                                break;
                            }
                        }
                    }
                }
            } elseif ($new_level > $current_level) {
                if($this->MLM_PLAN != 'Donation'){
                    for ($j = 1; $j <= $new_level; $j++) {
                        if (array_key_exists('level_percentage' . $j, $post_data)) {
                            $level_data[$j] = round($post_data['level_percentage' . $j] / $default_currency_value, 8);
                            $history .= " Level percentage({$j}): {$level_data[$j]}, ";

                            $this->db->set('level_percentage', $level_data[$j]);
                            if ($j <= $current_level) {
                                $this->db->where('level_no', $j);
                                $result = $this->db->update('level_commision');
                            } else {
                                $this->db->set('level_no', $j);
                                $result = $this->db->insert('level_commision');
                            }
                            if (!$result) {
                                break;
                            }
                        }
                    }
                }else {
                    $donaion_count = $post_data['donation_count'];
                    for ($j = 1; $j <= $new_level; $j++) {
                        $flag = false;
                        for ($k = 1; $k <= $donaion_count; $k++) {
                            $level_data[$j]['donation_' . $k] = round($post_data['level_' . $j . '_donation_' . $k] / $default_currency_value, 8);
                            $history .= "Level({$j}) ({$k}): " . $post_data['level_' . $j . '_donation_' . $k];

                            if ($j <= $current_level || $flag) {
                                $this->db->where('level_no', $j);
                                $result = $this->db->update('level_commision', $level_data[$j]);
                            } else {
                                $flag = true;
                                $this->db->set('level_no', $j);
                                $this->db->set('donation_' . $k, $level_data[$j]['donation_' . $k]);
                                $result = $this->db->insert('level_commision');
                            }
                            if (!$result) {
                                break;
                            }
                        }
                    }
                }

            } else {
                if($this->MLM_PLAN != 'Donation'){
                    for ($j = 1; $j <= $current_level; $j++) {
                        if (array_key_exists('level_percentage' . $j, $post_data)) {
                            $level_data[$j] = round($post_data['level_percentage' . $j] / $default_currency_value, 8);
                            $history .= " Level percentage({$j}): {$level_data[$j]}, ";
                            $this->db->set('level_percentage', $level_data[$j]);
                        }
                        $this->db->where('level_no', $j);
                        if ($j <= $new_level) {
                            $result = $this->db->update('level_commision');
                        } else {
                            $result = $this->db->delete('level_commision');
                        }
                        if (!$result) {
                            break;
                        }
                    }
                }else {
                    $donaion_count = $post_data['donation_count'];
                    for ($j = 1; $j <= $current_level; $j++) {
                        for ($k = 1; $k <= $donaion_count; $k++) {
                            if (array_key_exists('level_' . $j .'_donation_' . $k, $post_data)) {
                                $level_data[$j]['donation_' . $k] = round($post_data['level_' . $j .'_donation_' . $k] / $default_currency_value, 8);
                                $history .= "Level({$j}) ({$k}): " . $post_data['level_' . $j . '_donation_' . $k];
                            }
                            $this->db->where('level_no', $j);
                            if ($j <= $new_level) {
                                $result = $this->db->update('level_commision', $level_data[$j]);
                            } else {
                                $result = $this->db->delete('level_commision');
                            }
                            if (!$result) {
                                break;
                            }
                        }
                    }
                }
            }
            if ($this->MODULE_STATUS['product_status'] == "yes" || ($this->MODULE_STATUS['opencart_status'] == "yes" && $this->MODULE_STATUS['opencart_status_demo'] == "yes")) {
                $arr_pck = $this->getLevelCommissionPackages();
                if ($new_level > $current_level) {
                    for ($j = 1; $j <= $new_level; $j++) {
                        foreach ($arr_pck as $pack) {
                            if ($j > $current_level) {
                                $this->db->set('cmsn_reg_pck', 0);
                                $this->db->set('cmsn_member_pck', 0);
                                $this->db->set('level', $j);
                                $this->db->set('pck_id', $pack['prod_id']);
                                $result = $this->db->insert('level_commission_reg_pck');
                            }
                        }
                    }
                } elseif ($new_level < $current_level) {
                    for ($j = 1; $j <= $current_level; $j++) {
                        foreach ($arr_pck as $pack) {
                            $this->db->where('level >', $new_level);
                            $result = $this->db->delete('level_commission_reg_pck');
                        }
                    }
                }
            }
        } else {
            $arr_pck = $this->getLevelCommissionPackages();
            if($commission_type == 'reg_pck'){
                $pck = 'reg';
                $type = 'cmsn_reg_pck';
            }elseif($commission_type == 'member_pck'){
                $pck = 'member';
                $type = 'cmsn_member_pck';
            }
            if ($new_level == $current_level) {
                for ($j = 1; $j <= $current_level; $j++) {
                    foreach ($arr_pck as $pack) {
                        $level_data[$j] = round($post_data['level_' . $j . '_' . $pack['prod_id'] . '_' . $pck] / $default_currency_value, 8);
                        $history .= "Level({$j}) ({$pack['prod_id']}): " . $post_data['level_' . $j . '_' . $pack['prod_id'] . '_' . $pck];

                        $this->db->set($type, $level_data[$j]);
                        $this->db->where('level', $j);
                        $this->db->where('pck_id', $pack['prod_id']);
                        $result = $this->db->update('level_commission_reg_pck');
                        if (!$result) {
                            break;
                        }
                    }
                }
            } elseif ($new_level > $current_level) {
                for ($j = 1; $j <= $new_level; $j++) {
                    foreach ($arr_pck as $pack) {
                        if ($j <= $new_level) {
                            $level_data[$j] = round($post_data['level_' . $j . '_' . $pack['prod_id'] . '_' . $pck] / $default_currency_value, 8);
                            $history .= "Level({$j}) ({$pack['prod_id']}): " . $post_data['level_' . $j . '_' . $pack['prod_id'] . '_' . $pck];
                            $this->db->set($type, $level_data[$j]);
                        }
                        if ($j <= $current_level) {
                            $this->db->where('level', $j);
                            $this->db->where('pck_id', $pack['prod_id']);
                            $result = $this->db->update('level_commission_reg_pck');
                        } else {
                            $this->db->set('level', $j);
                            $this->db->set('pck_id', $pack['prod_id']);
                            $result = $this->db->insert('level_commission_reg_pck');
                        }
                        if (!$result) {
                            break;
                        }
                    }
                }
            } else {
                for ($j = 1; $j <= $current_level; $j++) {
                    foreach ($arr_pck as $pack) {
                        if ($j <= $new_level) {
                            $level_data[$j] = round($post_data['level_' . $j . '_' . $pack['prod_id'] . '_' . $pck] / $default_currency_value, 8);
                            $history .= "Level({$j}) ({$pack['prod_id']}): " . $post_data['level_' . $j . '_' . $pack['prod_id'] . '_' . $pck];
                            $this->db->set($type, $level_data[$j]);
                        }
                        $this->db->where('level', $j);
                        $this->db->where('pck_id', $pack['prod_id']);
                        if ($j <= $new_level) {
                            $result = $this->db->update('level_commission_reg_pck');
                        } else {
                            $result = $this->db->delete('level_commission_reg_pck');
                        }
                        if (!$result) {
                            break;
                        }
                    }
                }
            }
            if ($new_level > $current_level) {
                for ($j = 1; $j <= $new_level; $j++) {
                    if ($j > $current_level) {
                        $this->db->set('level_percentage', 0);
                        $this->db->set('level_no', $j);
                        $result = $this->db->insert('level_commision');
                    }
                }
            } elseif ($new_level < $current_level) {
                for ($j = 1; $j <= $current_level; $j++) {
                    if ($j > $new_level){
                        $this->db->where('level_no >', $new_level);
                        $result = $this->db->delete('level_commision');
                    }
                }
            }
        }

        if ($result) {
            // configuration history
            $this->insertConfigChangeHistory('commission settings', $history);
        }

        return $result;
    }
    public function updateLevelTables($level)
    {
        $data = [];
        $current_level = $this->validation_model->getConfig('commission_upto_level');
        $arr_pck = $this->getLevelCommissionPackages();
        $result = false;
        if ($current_level < $level) {
            for ($j = 1, $k = $level; $j <= $level; $j++, $k--) {
                foreach ($arr_pck as $pack) {
                    $data[] = ['level' => $j, 'pck_id' => $pack['prod_id'], 'cmsn_reg_pck' => $k, 'cmsn_member_pck' => $k];
                }
            }
            $this->db->empty_table('level_commission_reg_pck');
            $result = $this->db->insert_batch('level_commission_reg_pck', $data);
            $this->db->truncate('level_commision');
            if ($this->MLM_PLAN == "Donation") {
                for ($j = 1, $i = $level; $j <= $level; $j++, $i--) {
                    $this->db->set('level_no', $j);
                    $query = $this->db->insert('level_commision');
                }
            } else {
                for ($j = 1, $i = $level; $j <= $level; $j++, $i--) {
                    $this->db->set('level_no', $j);
                    $this->db->set('level_percentage', $i);
                    $query = $this->db->insert('level_commision');
                }
            }
            $this->db->set('commission_upto_level', $level);
            $this->db->update('configuration');
        } else if ($current_level > $level) {
            $this->db->where('level >', $level);
            $result = $this->db->delete('level_commission_reg_pck');
            $this->db->where('level_no >', $level);
            $result = $this->db->delete('level_commision');
            $this->db->set('commission_upto_level', $level);
            $this->db->update('configuration');
        }
        return $result;
    }
    public function getSignupFields()
    {
        $query = $this->db->select('*')
            ->from('signup_fields')
            ->order_by('sort_order')
            ->get();
        return $query->result_array();
    }

    public function updateSignUpFieldStatus($id, $status, $attr)
    {
        $this->db->set($attr, $status);
        $this->db->where('id', $id);
        $query = $this->db->update('signup_fields');
        return $query;
    }

    public function updateSignUpSortOrder($id, $order)
    {
        $this->db->set('sort_order', $order);
        $this->db->where('id', $id);
        $query = $this->db->update('signup_fields');
        return $query;
    }

    public function getSignUpFieldStatus($type)
    {
        $status = '';
        $this->db->select('status');
        $this->db->where('field_name', $type);
        $this->db->from('signup_fields');
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $status = $row->status;
        }
        return $status;
    }
    public function getCommissionProductDetails($product_id = '', $status = 'yes')
    {
        $product_details = array();

        $MODULE_STATUS = $this->trackModule();

        if ($MODULE_STATUS['opencart_status'] != "yes" || $MODULE_STATUS['opencart_status_demo'] != "yes") {
            $this->db->select('product_id,product_name,prod_id,referral_commission');
            if ($product_id != '') {
                $this->db->where('product_id', $product_id);
            }
            if ($status != '') {
                $this->db->where('active', $status);
            }
            $this->db->where('type_of_package', 'registration');
            $query = $this->db->get('package');

            foreach ($query->result_array() as $row) {
                $product_details[] = $row;
            }
        } else {
            $this->db->select('product_id,model AS product_name,package_id as prod_id,referral_commission');
            if ($product_id != '') {
                $this->db->where('product_id', $product_id);
            }
            $this->db->where('status', 1);
            $this->db->where('package_type', 'registration');
            $query = $this->db->get('oc_product');
            foreach ($query->result_array() as $row) {
                $product_details[] = $row;
            }
        }

        return $product_details;
    }
    public function getCompensationSettings()
    {
        $query = $this->db->get('compensations');
        foreach ($query->result_array() as $row) {
            $obj_arr = $row;
        }

        return $obj_arr;
    }

    public function updateCompensationStatus($bonus_name, $status)
    {
        $res = false;
        if (in_array($bonus_name, ['plan_commission_status', 'rank_commission_status', 'referal_commission_status', 'sponsor_commission_status', 'roi_commission_status', 'matching_bonus', 'pool_bonus', 'fast_start_bonus', 'performance_bonus','sales_commission'])) {
            $this->db->set($bonus_name, $status);
            $res = $this->db->update('compensations');
        }
        return $res;
    }

    public function updateRankConfiguration($post_array)
    {
        $this->db->set('rank_expiry', $post_array['rank_expiry']);
        $this->db->set('default_rank_id', $post_array['default_rank']);
        $this->db->set('rank_criteria', $post_array['rank_criteria']);
        $this->db->set('maximum_rank', $post_array['maximum_rank']);
        $result = $this->db->update('rank_configuration');
        return $result;
    }

    public function getRankConfiguration()
    {
        $query = $this->db->get('rank_configuration');
        foreach ($query->result_array() as $row) {
            $obj_arr = $row;
        }
        return $obj_arr;
    }
    public function updateReferalCommission($post_data, $default_currency_value)
    {
        $data = [];
        $history = "MLM Plan: {$this->MLM_PLAN}, ";
        if ($this->MODULE_STATUS['product_status'] == 'yes' || $this->MODULE_STATUS['rank_status'] == 'yes') {
            $commission_type = $post_data['sponsor_commission_type'];
            $data['referal_commission_type'] = $post_data['referal_commission_type'];
            $history .= "Referal commission type: {$data['referal_commission_type']}, ";
            $data['sponsor_commission_type'] = $post_data['sponsor_commission_type'];
            $history .= "Referal commission criteria: {$data['sponsor_commission_type']}, ";
        } else {
            $data['referal_amount'] = $post_data['referal_amount'];
        }

        $query = $this->db->update('configuration', $data);
        $result = true;

        if ($commission_type == 'rank') {
            $rank_details = $this->configuration_model->getActiveRankDetails();
            foreach ($rank_details as $rank) {
                $level_data = round($post_data["rank_referal{$rank['rank_id']}"] / $default_currency_value, 8);
                $history .= "Referral Commission({$rank['rank_name']}): " . $post_data['rank_referal' . $rank['rank_id']];

                $this->db->set('referal_commission', $level_data);
                $this->db->where('rank_id', $rank['rank_id']);
                $result = $this->db->update('rank_details');
                if (!$result) {
                    break;
                }
            }
        } elseif($commission_type == 'sponsor_package' || $commission_type == 'joinee_package') {
            $product_details = $this->configuration_model->getCommissionProductDetails();
            foreach ($product_details as $u) {
                $level_data = round($post_data["pck_referal{$u['product_id']}"] / $default_currency_value, 8);
                $history .= "Referal Commission({$u['prod_id']}): " . $post_data['pck_referal' . $u['product_id']];

                $this->db->set('referral_commission', $level_data);
                $this->db->where('product_id', $u['product_id']);
                if($this->MODULE_STATUS['opencart_status'] == "yes" && $this->MODULE_STATUS['opencart_status_demo'] == "yes"){
                    $result = $this->db->update('oc_product');
                }else{
                    $result = $this->db->update('package');
                }
                if (!$result) {
                    break;
                }
            }
        }

        if ($query && $result) {
            // configuration history
            $res = $this->insertConfigChangeHistory('commission settings', $history);
        }

        return $query && $result;
    }
    public function updateRankCommission($post_data, $default_currency_value)
    {
        $res = true;
        $rank_details = $this->configuration_model->getActiveRankDetails();
        foreach ($rank_details as $rank) {
            if (array_key_exists('rank' . $rank['rank_id'], $post_data)) {
                $rank_bonus = round($post_data['rank' . $rank['rank_id']] / $default_currency_value, 8);
                $this->db->set('rank_bonus', $rank_bonus);
                $this->db->where('rank_id', $rank['rank_id']);
                $res = $this->db->update('rank_details');
                if(!$res){
                    break;
                }
            }
        }
        return $res;
    }

    public function updateRankConfig($post_array)
    {
        $joinee = FALSE;
        $criteria = ['referal_count','personal_pv','group_pv','downline_member_count','downline_purchase_count','downline_rank','joinee_package'];
        $this->db->set('rank_expiry', $post_array['rank_expiry']);
        //$this->db->set('default_rank_id', $post_array['default_rank']);
        $result = $this->db->update('rank_configuration');
        if (array_key_exists('rank_criteria', $post_array)) {
            foreach($criteria as $cri) {
                if (in_array($cri, $post_array['rank_criteria']))
                    $flag = 1;
                else
                    $flag = 0;
                $this->db->set("{$cri}", $flag);
                $this->db->update('rank_configuration');
            }
        }
        return $result;
    }

    public function getjoinedPackageDetails($id = 0)
    {
        $MODULE_STATUS = $this->trackModule();
        if ($MODULE_STATUS['opencart_status'] != "yes" || $MODULE_STATUS['opencart_status_demo'] != "yes") {
            $this->db->select("p.prod_id as product_id, p.product_name");
            $this->db->from("package as p");
            $this->db->join("joinee_rank as jr", "p.prod_id = jr.package_id and jr.rank_id = $id", "RIGHT");
            $this->db->where('p.type_of_package', 'registration');
            $this->db->where('p.active', 'yes');
            $query = $this->db->get();
        } else {
            $this->db->select('op.model product_name,op.package_id as product_id');
            $this->db->from("oc_product op");
            $this->db->join("joinee_rank as jr", "op.package_id = jr.package_id and jr.rank_id = $id", "RIGHT");
            $this->db->where('op.package_type', 'registration');
            $this->db->where('op.status', 1);
            $this->db->order_by("op.product_id", "asc");
            $query = $this->db->get();
        }
        return $query->result_array();
    }

    public function getBinaryBonusConfig()
    {
        $config = $this->db->get('binary_bonus_config')->row_array();
        if ($this->MODULE_STATUS['product_status'] == 'no') {
            $config['calculation_criteria'] = 'fixed';
        }
        return $config;
    }

    public function updateBinaryBonusConfig($data)
    {
        if (isset($data['carry_forward'])) {
            $data['carry_forward'] = 'yes';
        }
        else {
            $data['carry_forward'] = 'no';
        }
        if (isset($data['flush_out'])) {
            $data['flush_out'] = 'yes';
            $this->db->set('flush_out_limit', $data['flush_out_limit']);
            if ($data['calculation_period'] == 'instant') {
                $this->db->set('flush_out_period', $data['flush_out_period']);
            }
        }
        else {
            $data['flush_out'] = 'no';
        }
        if ($this->MODULE_STATUS['product_status'] == 'yes') {
            $this->db->set('calculation_criteria', $data['calculation_criteria']);
        }
        else {
            $this->db->set('point_value', $data['point_value']);
            $this->db->set('pair_commission', $data['pair_commission']);
        }
        $this->db->set('calculation_period', $data['calculation_period']);
        $this->db->set('commission_type', $data['commission_type']);
        $this->db->set('pair_type', $data['pair_type']);
        if ($data['commission_type'] == 'flat') {
            $this->db->set('pair_value', $data['pair_value']);
        }
        $this->db->set('carry_forward', $data['carry_forward']);
        $this->db->set('flush_out', $data['flush_out']);
        $res = $this->db->update('binary_bonus_config');
        if ($res) {
            $package_list = [];
            if ($this->MODULE_STATUS['opencart_status'] == 'yes') {
                $table = 'oc_product';
                $package_list = $this->product_model->getMembershipPackageListByColumns('product_id');
            } elseif ($this->MODULE_STATUS['product_status'] == 'yes') {
                $table = 'package';
                $package_list = $this->product_model->getMembershipPackageListByColumns('product_id');
            }
            foreach ($package_list as $pack) {
                $this->db->set('pair_price', $data["pair_commission_{$pack['product_id']}"]);
                $this->db->where('product_id', $pack['product_id']);
                $this->db->update($table);
            }
        }
        return $res;
    }

    public function getProductRoiDetails($product_id = '', $status = 'yes')
    {
        $product_details = array();
        $MODULE_STATUS = $this->trackModule();
        if ($MODULE_STATUS['opencart_status'] != "yes" || $MODULE_STATUS['opencart_status_demo'] != "yes") {
            $this->db->select('product_id,product_name,prod_id,roi,days');
            if ($product_id != '') {
                $this->db->where('product_id', $product_id);
            }
            if ($status != '') {
                $this->db->where('active', $status);
            }
            $this->db->where('type_of_package', 'registration');
            $query = $this->db->get('package');

            foreach ($query->result_array() as $row) {
                $product_details[] = $row;
            }
        }
        return $product_details;
    }
    public function updateRoiCommission($post_data)
    {
        $res = true;
        $days = '';
        $this->db->set('roi_criteria', $post_data['roi_criteria']);
        $this->db->set('roi_period', $post_data['period']);
        if (array_key_exists('days', $post_data)) {
            $days = implode(",", $post_data['days']);
        }
        $this->db->set('roi_days_skip', $days);
        $this->db->update('configuration');

        $product_details = $this->getProductRoiDetails();
        foreach ($product_details as $product) {
            if (array_key_exists('pck_roi' . $product['product_id'], $post_data)) {
                $roi = $post_data['pck_roi' . $product['product_id']];
                $days = $post_data['pck_days' . $product['product_id']];
                $this->db->set('roi', $roi);
                $this->db->set('days', $days);
                $this->db->where('product_id',$product['product_id']);
                $res = $this->db->update('package');
                if(!$res){
                    break;
                }
            }
        }
        return $res;
    }

    public function updatePoolCommission($post_data, $default_currency_value)
    {
        $data = [];
        $data['pool_bonus_percent'] = $post_data['pool_bonus'];
        $data['pool_bonus_period'] = $post_data['pool_bonus_period'];
        $data['pool_bonus_criteria'] = $post_data['pool_bonus_criteria'];
        $data['pool_distribution_criteria'] = $post_data['pool_distribution_criteria'];
        $res = false;
        $rank_details = $this->configuration_model->getActiveRankDetails();
        foreach ($rank_details as $rank) {
            if (array_key_exists("pool_rank{$rank['rank_id']}",$post_data)) {
                $rank_bonus = round($post_data['pool_level' . $rank['rank_id']] / $default_currency_value, 8);
                $this->db->set('pool_bonus_perc', $rank_bonus);
                $this->db->set('pool_status', "yes");
                $this->db->where('rank_id', $rank['rank_id']);
                $res = $this->db->update('rank_details');
                if(!$res){
                    break;
                }
            }else{
                $this->db->set('pool_status', "no");
                $this->db->where('rank_id', $rank['rank_id']);
                $res = $this->db->update('rank_details');
            }
        }
        $this->db->update('configuration', $data);
        return $res;
    }

    public function getConfiguration($key)
    {
        return $this->db->get('configuration')->row()->{$key};
    }

    public function updateConfiguration($key, $value)
    {
        $this->db->set("$key", $value);
        return $this->db->update('configuration');
    }

    public function UpdateRankConfigurationByKey($key, $value)
    {
        $this->db->set("$key", $value);
        return $this->db->update('rank_configuration');
    }
    public function updateBinaryBonusConfigCommon($data)
    {
        if (isset($data['carry_forward'])) {
            $data['carry_forward'] = 'yes';
        }
        else {
            $data['carry_forward'] = 'no';
        }
        if (isset($data['flush_out'])) {
            $data['flush_out'] = 'yes';
            $this->db->set('flush_out_limit', $data['flush_out_limit']);
            if ($data['calculation_period'] == 'instant') {
                $this->db->set('flush_out_period', $data['flush_out_period']);
            }
        }
        else {
            $data['flush_out'] = 'no';
        }
        if ($this->MODULE_STATUS['product_status'] == 'yes') {
            $this->db->set('calculation_criteria', $data['calculation_criteria']);
        }
        else {
            $this->db->set('point_value', $data['point_value']);
        }
        $this->db->set('calculation_period', $data['calculation_period']);
        $this->db->set('commission_type', $data['commission_type']);
        $this->db->set('pair_type', $data['pair_type']);
        if ($data['commission_type'] == 'flat') {
            $this->db->set('pair_value', $data['pair_value']);
        }
        $this->db->set('carry_forward', $data['carry_forward']);
        $this->db->set('flush_out', $data['flush_out']);
        $res = $this->db->update('binary_bonus_config');
        return $res;
    }
    public function updatePackageLevelCommissionCommon($post_data)
    {
        $data = [];
        $history = "MLM Plan: {$this->MLM_PLAN}, ";
        $data['level_commission_type'] = $post_data['level_commission_type'];
        $history .= "Level commission type: {$data['level_commission_type']}, ";
        $data['commission_criteria'] = $post_data['level_commission_criteria'];
        $history .= "Level commission criteria: {$data['commission_criteria']}, ";
        $data['commission_upto_level'] = $post_data['commission_upto_level'];
        $history .= "Level commission upto-level: {$data['commission_upto_level']}, ";
        $data['depth_ceiling'] = $post_data['commission_upto_level'];
        $history .= "Depth Ceiling: {$data['depth_ceiling']}, ";
        $query = $this->db->update('configuration', $data);

        if ($query) {
            // configuration history
            $this->insertConfigChangeHistory('commission settings', $history);
        }
        return $query;
    }
    public function getMatchLevelSettings()
    {
        $arr_comm = array();
        $this->db->select('*');
        $this->db->from('matching_level_commision');
        $query = $this->db->get();
        $l = 0;
        foreach ($query->result_array() as $row) {
            $arr_comm[$l] = $row['level_percentage'];
            $l++;
        }
        return $arr_comm;
    }
    public function getMatchingCommission()
    {
        $arr_comm = [];
        $this->db->select('*');
        $this->db->from('matching_commissions');
        $this->db->order_by("level", "asc");
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            if (array_key_exists($row->level, $arr_comm)) {
                $arr_comm[$row->level][$row->pck_id . "member"] = $row->cmsn_member_pck;
            } else {
                $arr_comm[$row->level] = ['level' => $row->level,$row->pck_id . "member" => $row->cmsn_member_pck];
            }
        }
        return $arr_comm;
    }
    public function updateMatchingCommissionCommon($post_data)
    {
        $data = [];
        $current_level = $this->validation_model->getConfig('matching_upto_level');
        $result = false;
        $history = "MLM Plan: {$this->MLM_PLAN}, ";
        $data['matching_criteria'] = $post_data['commission_criteria'];
        $history .= "Matching bonus criteria: {$data['matching_criteria']}, ";
        $data['matching_upto_level'] = $post_data['commission_upto_level'];
        $history .= "Matching bonus upto-level: {$data['matching_upto_level']}, ";
        $query = $this->db->update('configuration', $data);

        if ($query) {
            $new_level = $post_data['commission_upto_level'];
            $history = "";

            if ($new_level != $current_level) {
                if ($new_level > $current_level) {
                    for ($j = $current_level+1; $j <= $new_level; $j++) {
                        $this->db->set('level_no', $j);
                        $result = $this->db->insert('matching_level_commision');
                        if (!$result) {
                            break;
                        }
                    }
                } elseif ($new_level < $current_level){
                    $this->db->where('level_no >', $new_level);
                    $result = $this->db->delete('matching_level_commision');
                }
                if ($this->MODULE_STATUS['product_status'] == "yes" || ($this->MODULE_STATUS['opencart_status'] == "yes" && $this->MODULE_STATUS['opencart_status_demo'] == "yes")) {
                    $arr_pck = $this->getLevelCommissionPackages();
                    if ($new_level > $current_level) {
                        for ($j = $current_level+1; $j <= $new_level; $j++) {
                            foreach ($arr_pck as $pack) {
                                $this->db->set('level', $j);
                                $this->db->set('pck_id', $pack['prod_id']);
                                $result = $this->db->insert('matching_commissions');
                            }
                        }
                    } elseif ($new_level < $current_level) {
                        $this->db->where('level >', $new_level);
                        $result = $this->db->delete('matching_commissions');
                    }
                }
            }

            // configuration history
            $this->insertConfigChangeHistory('commission settings', $history);
        }
        return $query;
    }
    public function updateMatchingCommission($post_data,$default_currency_value)
    {
        $current_level = $this->validation_model->getConfig('matching_upto_level');
        $criteria = $this->validation_model->getConfig('matching_criteria');
        $history = "";
        $result = false;

        if ($criteria == 'genealogy') {
            for ($j = 1; $j <= $current_level; $j++) {
                if (array_key_exists('level_percentage' . $j, $post_data)) {
                    $level_data[$j] = round($post_data['level_percentage' . $j] / $default_currency_value, 8);
                    $history .= " Level percentage({$j}): {$level_data[$j]}, ";

                    $this->db->set('level_percentage', $level_data[$j]);
                    $this->db->where('level_no', $j);
                    $result = $this->db->update('matching_level_commision');
                    if (!$result) {
                        break;
                    }
                }
            }
        } else {
            $arr_pck = $this->getLevelCommissionPackages();
            $pck = 'member';
            for ($j = 1; $j <= $current_level; $j++) {
                foreach ($arr_pck as $pack) {
                    $level_data[$j] = round($post_data['level_' . $j . '_' . $pack['prod_id'] . '_' . $pck] / $default_currency_value, 8);
                    $history .= "Level({$j}) ({$pack['prod_id']}): " . $post_data['level_' . $j . '_' . $pack['prod_id'] . '_' . $pck];

                    $this->db->set('cmsn_member_pck', $level_data[$j]);
                    $this->db->where('level', $j);
                    $this->db->where('pck_id', $pack['prod_id']);
                    $result = $this->db->update('matching_commissions');
                    if (!$result) {
                        break;
                    }
                }
            }
        }

        if ($result) {
            // configuration history
            $this->insertConfigChangeHistory('commission settings', $history);
        }
        return $result;
    }
    public function getSalesRankDetails($rank_id = null)
    {
        $this->db->select('rank_id,rank_name');
        if ($rank_id != null) {
            $this->db->where('rank_id', $rank_id);
        }
        $this->db->where('rank_status', 'active');
        $this->db->where('delete_status', 'yes');
        $query = $this->db->get('rank_details');

        return $query->result_array();
    }
    public function getSalesLevelSettings()
    {
        $arr_comm = array();
        $this->db->select('*');
        $this->db->from('sales_level_commision');
        $query = $this->db->get();
        $l = 0;
        foreach ($query->result_array() as $row) {
            $arr_comm[$l] = $row['level_percentage'];
            $l++;
        }
        return $arr_comm;
    }
    public function getSalesCommission()
    {
        $arr_comm = [];
        $this->db->select('*');
        $this->db->from('sales_commissions');
        $this->db->order_by("level", "asc");
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            if (array_key_exists($row->level, $arr_comm)) {
                $arr_comm[$row->level][$row->pck_id . "sales"] = $row->sales;
            } else {
                $arr_comm[$row->level] = ['level' => $row->level,$row->pck_id . "sales" => $row->sales];
            }
        }
        return $arr_comm;
    }
    public function getSalesRankCommission()
    {
        $arr_comm = [];
        $this->db->select('*');
        $this->db->from('sales_rank_commissions');
        $this->db->order_by("level", "asc");
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            if (array_key_exists($row->level, $arr_comm)) {
                $arr_comm[$row->level][$row->rank_id . "rank"] = $row->sales;
            } else {
                $arr_comm[$row->level] = ['level' => $row->level,$row->rank_id . "rank" => $row->sales];
            }
        }
        return $arr_comm;
    }
    public function updateSalesCommissionCommon($post_data)
    {
        $data = [];
        $current_level = $this->validation_model->getConfig('sales_level');
        $result = false;
        $history = "MLM Plan: {$this->MLM_PLAN}, ";
        $data['sales_criteria'] = $post_data['commission_criteria'];
        $history .= "Sales commission criteria: {$data['sales_criteria']}, ";
        $data['sales_level'] = $post_data['commission_upto_level'];
        $history .= "Sales commission upto-level: {$data['sales_level']}, ";
        $data['sales_type'] = $post_data['sales_type'];
        $history .= "Sales commission type: {$data['sales_type']}, ";
        $query = $this->db->update('configuration', $data);

        if ($query) {
            $new_level = $post_data['commission_upto_level'];
            $history = "";

            if ($new_level != $current_level) {
                if ($new_level > $current_level) {
                    for ($j = $current_level+1; $j <= $new_level; $j++) {
                        $this->db->set('level_no', $j);
                        $result = $this->db->insert('sales_level_commision');
                        if (!$result) {
                            break;
                        }
                    }
                } elseif ($new_level < $current_level){
                    $this->db->where('level_no >', $new_level);
                    $result = $this->db->delete('sales_level_commision');
                }
                if ($this->MODULE_STATUS['product_status'] == "yes" || ($this->MODULE_STATUS['opencart_status'] == "yes" && $this->MODULE_STATUS['opencart_status_demo'] == "yes")) {
                    $arr_pck = $this->getLevelCommissionPackages();
                    if ($new_level > $current_level) {
                        for ($j = $current_level+1; $j <= $new_level; $j++) {
                            foreach ($arr_pck as $pack) {
                                $this->db->set('level', $j);
                                $this->db->set('pck_id', $pack['prod_id']);
                                $result = $this->db->insert('sales_commissions');
                            }
                        }
                    } elseif ($new_level < $current_level) {
                        $this->db->where('level >', $new_level);
                        $result = $this->db->delete('sales_commissions');
                    }
                }
                if ($this->MODULE_STATUS['rank_status'] == "yes") {
                    $arr_rank = $this->getSalesRankDetails();
                    if ($new_level > $current_level) {
                        for ($j = $current_level+1; $j <= $new_level; $j++) {
                            foreach ($arr_rank as $rank) {
                                $this->db->set('level', $j);
                                $this->db->set('rank_id', $rank['rank_id']);
                                $result = $this->db->insert('sales_rank_commissions');
                            }
                        }
                    } elseif ($new_level < $current_level) {
                        $this->db->where('level >', $new_level);
                        $result = $this->db->delete('sales_rank_commissions');
                    }
                }
            }

            // configuration history
            $this->insertConfigChangeHistory('commission settings', $history);
        }
        return $query;
    }
    public function updateSalesCommission($post_data,$default_currency_value)
    {
        $current_level = $this->validation_model->getConfig('sales_level');
        $criteria = $this->validation_model->getConfig('sales_type');
        $history = "";
        $result = false;

        if ($criteria == 'genealogy') {
            for ($j = 1; $j <= $current_level; $j++) {
                if (array_key_exists('level_percentage' . $j, $post_data)) {
                    $level_data[$j] = round($post_data['level_percentage' . $j] / $default_currency_value, 8);
                    $history .= " Level percentage({$j}): {$level_data[$j]}, ";

                    $this->db->set('level_percentage', $level_data[$j]);
                    $this->db->where('level_no', $j);
                    $result = $this->db->update('sales_level_commision');
                    if (!$result) {
                        break;
                    }
                }
            }
        } elseif($criteria == 'package') {
            $arr_pck = $this->getLevelCommissionPackages();
            $pck = 'sales';
            for ($j = 1; $j <= $current_level; $j++) {
                foreach ($arr_pck as $pack) {
                    $level_data[$j] = round($post_data['level_' . $j . '_' . $pack['prod_id'] . '_' . $pck] / $default_currency_value, 8);
                    $history .= "Level({$j}) ({$pack['prod_id']}): " . $post_data['level_' . $j . '_' . $pack['prod_id'] . '_' . $pck];

                    $this->db->set('sales', $level_data[$j]);
                    $this->db->where('level', $j);
                    $this->db->where('pck_id', $pack['prod_id']);
                    $result = $this->db->update('sales_commissions');
                    if (!$result) {
                        break;
                    }
                }
            }
        }elseif($criteria == 'rank') {
            $arr_rank = $this->getSalesRankDetails();
            $pck = 'rank';
            for ($j = 1; $j <= $current_level; $j++) {
                foreach ($arr_rank as $pack) {
                    $level_data[$j] = round($post_data['level_' . $j . '_' . $pack['rank_id'] . '_' . $pck] / $default_currency_value, 8);
                    $history .= "Level({$j}) ({$pack['rank_id']}): " . $post_data['level_' . $j . '_' . $pack['rank_id'] . '_' . $pck];

                    $this->db->set('sales', $level_data[$j]);
                    $this->db->where('level', $j);
                    $this->db->where('rank_id', $pack['rank_id']);
                    $result = $this->db->update('sales_rank_commissions');
                    if (!$result) {
                        break;
                    }
                }
            }
        }

        if ($result) {
            // configuration history
            $this->insertConfigChangeHistory('commission settings', $history);
        }
        return $result;
    }

    public function selectDownlineRankConfig($id = 0)
    {
        $this->db->select("rd.rank_id, rd.rank_name, IFNULL(dr.rank_count,0) AS rank_count");
        $this->db->from("rank_details as rd");
        $this->db->join("downline_rank as dr", "dr.rank_id = $id and rd.rank_id = dr.downline_rank_id", "LEFT");
        if($id != 0)
            $this->db->where('rd.rank_id <', $id);
        $this->db->where('delete_status', 'yes');
        $this->db->where('rank_status', 'active');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function updateDownlineRankTable($rank, $rank_id)
    {
        foreach ($rank as $key => $value) {
            if ($this->isDownlineRankExists($key, $rank_id)) {
                $this->db->set('rank_count', $value);
                $this->db->where('downline_rank_id', $key);
                $this->db->where('rank_id', $rank_id);
                $this->db->update('downline_rank');
            } else {
                $this->db->set('rank_id', $rank_id);
                $this->db->set('downline_rank_id', $key);
                $this->db->set('rank_count', $value);
                $this->db->insert('downline_rank');
            }
        }
    }

    public function isDownlineRankExists($key, $rank_id)
    {
        $this->db->where('downline_rank_id', $key);
        $this->db->where('rank_id', $rank_id);
        return $this->db->count_all_results('downline_rank');
    }
}
