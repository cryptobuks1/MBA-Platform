<?php

Class calculation_model extends Inf_Model {

    public function __construct() {

        $this->load->model('settings_model');
        $this->load->model('validation_model');
        $this->load->model('configuration_model');
        $this->load->model('ewallet_model');
    }
    
    
      //new fast start bonus
    public function calculateFastStartBonusCommission($action, $from_user, $sponsor_id, $product_id, $product_pair_value, $product_amount, $oc_order_id = 0, $quantity = 0) {

        if ($action == 'repurchase') {
            $amount_type = 'repurchase_fast_start_bonus';
        }
        elseif ($action == 'upgrade') {
            $amount_type = 'upgrade_fast_start_bonus';
        }elseif ($action == 'renewal') {
            $amount_type = 'renewal_fast_start_bonus';
        }
        else {
            $amount_type = 'fast_start_bonus';
        }

        $module_status=$this->MODULE_STATUS;
        $mlm_plan = $module_status['mlm_plan'];
        $xup_status = $module_status['xup_status'];
        $config_details = $this->validation_model->getConfig(['depth_ceiling', 'tds', 'service_charge', 'level_commission_type','commission_criteria','commission_upto_level','matching_criteria']);
        $tds_db = $config_details["tds"];
        $service_charge_db = $config_details["service_charge"];
        $depth_ceiling = $config_details['commission_upto_level'];
       
        if ($depth_ceiling > 0) {
            if ($xup_status == 'yes') {
                $xup_level = $this->validation_model->getConfig('xup_level');
                if ($xup_level > 0) {
                    $depth_ceiling = $depth_ceiling * ($xup_level + 1);
                    if ($amount_type == 'level_commission') {
                        $amount_type = 'xup_commission';
                    }
                    else {
                        $amount_type = "xup_" . $amount_type;
                    }
                }
                else {
                    return TRUE;
                }
                $upline_users = $this->getUnilevelUplinesForXUP($sponsor_id, $depth_ceiling, $xup_level);
            }
            else {
                $upline_users = $this->getUnilevelUplines($sponsor_id, $depth_ceiling);
            }
            $date_of_sub = date("Y-m-d H:i:s");
            
            foreach ($upline_users as $upline) {
                $user_id = $upline['id'];
                $level = $upline['user_level'];
                $status = $upline['active'];
                $level_amount = 0;

               $user_rank_id = $this->validation_model->getUserRank($user_id);
               $level_percent = $this->getFastStartConfig($level,$user_rank_id);
               $level_amount = $product_pair_value * ($level_percent / 100);
                
               
                if ($level_amount) {
                    $tds_amount = ($level_amount * $tds_db) / 100;
                    $service_charge = ($level_amount * $service_charge_db) / 100;
                    $amount_payable = $level_amount - ($tds_amount + $service_charge);
                    if ($status == 'yes') {
                        
                        $result = $this->insertInToLegAmount($user_id, $level_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $level, $amount_type, $from_user, $product_id, $product_pair_value, $product_amount, $oc_order_id);
                       
                        if (!$result) {
                            return FALSE;
                        }
                    }
                    
                }
            }
        }
        return TRUE;
    }


     public function getFastStartConfig($level,$rank_id) {
        
        if($level > 10){
            return 0; 
        }
        
        $level_per = 0;
        $this->db->select('level'.$level.' as level');
        $this->db->from('fast_start_bonus_config');
        $this->db->where('rank_id',$rank_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $level_per = $row->level;
        }
        return $level_per;
    }

    //end

    public function calculateLevelCommission($action, $from_user, $sponsor_id, $product_id, $product_pair_value, $product_amount, $oc_order_id = 0, $quantity = 0) {

        if ($action == 'repurchase') {
            $amount_type = 'repurchase_level_commission';
        }
        elseif ($action == 'upgrade') {
            $amount_type = 'upgrade_level_commission';
        }
        else {
            $amount_type = 'level_commission';
        }

        $module_status=$this->MODULE_STATUS;
        $mlm_plan = $module_status['mlm_plan'];
        $xup_status = $module_status['xup_status'];
        $config_details = $this->validation_model->getConfig(['depth_ceiling', 'tds', 'service_charge', 'level_commission_type','commission_criteria','commission_upto_level','matching_criteria']);
        $tds_db = $config_details["tds"];
        $service_charge_db = $config_details["service_charge"];
        $type_levelcomission = $config_details["level_commission_type"];
        $depth_ceiling = $config_details['commission_upto_level'];
        $commission_criteria = $config_details['commission_criteria'];
        $matching_bonus_status = $this->validation_model->getCompensationConfig(['matching_bonus']);
        $matching_criteria = $config_details['matching_criteria'];
        if ($matching_bonus_status == 'yes') {
            if($matching_criteria == 'genealogy')
                $matching_bonus_config = $this->settings_model->getMatchingBonusConfig();
            else
                $matching_bonus_config = [];
        }

        if($commission_criteria == 'genealogy'){
            if ($mlm_plan == 'Donation') {
                $level_config = $this->settings_model->getDonationLevelConfig();
            }
            else {
                $level_config = $this->settings_model->getLevelConfig();
            }
        }

        if ($depth_ceiling > 0) {
            if ($xup_status == 'yes') {
                $xup_level = $this->validation_model->getConfig('xup_level');
                if ($xup_level > 0) {
                    $depth_ceiling = $depth_ceiling * ($xup_level + 1);
                    if ($amount_type == 'level_commission') {
                        $amount_type = 'xup_commission';
                    }
                    else {
                        $amount_type = "xup_" . $amount_type;
                    }
                }
                else {
                    return TRUE;
                }
                $upline_users = $this->getUnilevelUplinesForXUP($sponsor_id, $depth_ceiling, $xup_level);
            }
            else {
                $upline_users = $this->getUnilevelUplines($sponsor_id, $depth_ceiling);
            }
            $date_of_sub = date("Y-m-d H:i:s");
            $compressed_commission = 0;
            $compressed_commission_status = $this->configuration_model->getCompressedCommissionStatus();

            foreach ($upline_users as $upline) {
                $user_id = $upline['id'];
                $level = $upline['user_level'];
                $status = $upline['active'];
                $level_amount = 0;

                if($commission_criteria == 'reg_pck'){
                    $level_percent = $this->settings_model->getPackageLevelConfig($level,$this->validation_model->getProductId($from_user),"cmsn_reg_pck");
                }elseif($commission_criteria == 'member_pck'){
                    $level_percent = $this->settings_model->getPackageLevelConfig($level,$this->validation_model->getProductId($user_id),"cmsn_member_pck");
                }else{
                    if ($mlm_plan == 'Donation') {
                        $donation_level = $upline['current_level'];
                        if (empty($donation_level)) {
                            continue;
                        }
                        $level_percent = $level_config[$level]["donation_{$donation_level}"];
                    } else {
                        $level_percent = $level_config[$level];
                    }
                }

                if ($type_levelcomission == "percentage") {
                    $level_amount = $product_pair_value * ($level_percent / 100);
                } else {
                    if (empty($quantity)) {
                        $level_amount = $level_percent;
                    } else {
                        $level_amount = $quantity * $level_percent;
                    }
                }

                if ($level_amount) {
                    $tds_amount = ($level_amount * $tds_db) / 100;
                    $service_charge = ($level_amount * $service_charge_db) / 100;
                    $amount_payable = $level_amount - ($tds_amount + $service_charge);
                    if ($status == 'yes') {
                        if ($compressed_commission > 0 && $compressed_commission_status == "yes") {
                            $amount_payable += $compressed_commission;
                            $compressed_commission = 0;
                        }
                        $result = $this->insertInToLegAmount($user_id, $level_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $level, $amount_type, $from_user, $product_id, $product_pair_value, $product_amount, $oc_order_id);
                        if ($result && $amount_payable > 0 && $matching_bonus_status == 'yes' && !in_array($mlm_plan, ['Binary', 'Board'])) {
                            $this->calculateMatchingBonus($action, $user_id, $amount_payable, $date_of_sub, $tds_db, $service_charge_db, $matching_bonus_config);
                        }
                        if (!$result) {
                            return FALSE;
                        }
                    }
                    else {
                        $compressed_commission += $amount_payable;
                    }
                }
            }
        }
        return TRUE;
    }

    public function getUnilevelUplines($user_id, $depth_ceiling, $level = 1, $uplines = []) {
        $this->db->select('ft.sponsor_id,ft.active');
        $this->db->from('ft_individual as ft');
        $this->db->where('ft.id', $user_id);
        if ($this->MODULE_STATUS['mlm_plan'] == 'Donation') {
            $this->db->select('ft.current_level');
        }
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $res_arr = $query->row_array();
            $res_arr['id'] = $user_id;
            $res_arr['user_level'] = $level;
            $uplines[] = $res_arr;

            if ($level < $depth_ceiling) {
                return $this->getUnilevelUplines($res_arr['sponsor_id'], $depth_ceiling, $level + 1, $uplines);
            }
        }
        return $uplines;
    }
    
    
      public function getUnilevelUplineForBinary($user_id, $sponsor_id) {
        $this->db->select('ft.father_id,ft.position');
        $this->db->from('ft_individual as ft');
        $this->db->where('ft.id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $res_arr = $query->row_array();
            $position = $res_arr['position'];
            if ($res_arr['father_id'] != $sponsor_id) {
                return $this->getUnilevelUplineForBinary($res_arr['father_id'], $sponsor_id);
            }
        }
        return $position;
    }

    public function getUnilevelUplinesForXUP($user_id, $depth_ceiling, $xup_level, $level = 1, $uplines = []) {
        $this->db->select('sponsor_id,active');
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get('ft_individual');

        if ($query->num_rows() > 0) {
            $res_arr = $query->row_array();
            if (($level % ($xup_level + 1)) === 0) {
                $res_arr['id'] = $user_id;
                $res_arr['user_level'] = ($level / ($xup_level + 1));
                $uplines[] = $res_arr;
            }

            if ($level < $depth_ceiling) {
                return $this->getUnilevelUplinesForXUP($res_arr['sponsor_id'], $depth_ceiling, $xup_level, $level + 1, $uplines);
            }
        }
        return $uplines;
    }

    public function insertInToLegAmount($user_id, $total_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $level, $amount_type, $from_user = '', $product_id = 0, $product_pair_value = 0, $product_amount = 0, $oc_order_id = 0, $left_leg = 0, $right_leg = 0, $total_leg = 0,$rank_id = 0,$b_id = 0,$binary_per = 0,$binary_cap = 0) {

        $skip_blocked_users_commission = $this->configuration_model->getConfiguration('skip_blocked_users_commission');
        $is_user_active = $this->validation_model->isUserActive($user_id);

        if ($this->validation_model->getUserJoinType($user_id) == 'customer') {
            return true;
        }
        
        if(!$is_user_active && $skip_blocked_users_commission == 'yes') {
            return true;
        }
        
        $date = date('Y-m-d H:i:s');
        /*$subscription_end_date = $this->ewallet_model->getSubscriptionEndDate($user_id);
        if(!empty($subscription_end_date)){
         if($date >= $subscription_end_date) {
            return true;
         }
        } */  

        $result = false;

        if ($total_amount) {
            $date_of_sub = strtotime($date_of_sub);
            $date_of_sub += 1;
            $date_of_sub = date("Y-m-d H:i:s", $date_of_sub);

            $this->db->set('user_id', $user_id);
	    if (!empty($from_user)) {
	            $this->db->set('from_id', $from_user);
	    }
            $this->db->set('total_amount', round($total_amount, 8));
            $this->db->set('amount_payable', round($amount_payable, 8));
            $this->db->set('tds', round($tds_amount, 8));
            $this->db->set('service_charge', round($service_charge, 8));
            $this->db->set('date_of_submission', $date_of_sub);
            $this->db->set('user_level', $level);
            $this->db->set('amount_type', $amount_type);
            $this->db->set('product_id', $product_id);
            $this->db->set('pair_value', $product_pair_value);
            $this->db->set('product_value', $product_amount);
            $this->db->set('left_leg', $left_leg);
            $this->db->set('right_leg', $right_leg);
            $this->db->set('total_leg', $total_leg);
            $this->db->set('rank_id', $rank_id);
            
            
            
            //binary commission 
            $this->db->set('b_id', $b_id);
            $this->db->set('binary_per', $binary_per);
            $this->db->set('binary_cap', $binary_cap);
            //end 

            $MODULE_STATUS = $this->trackModule();
            if ($MODULE_STATUS['opencart_status_demo'] == "yes" && $MODULE_STATUS['opencart_status'] == "yes") {
                $this->db->set('oc_order_id', $oc_order_id);
            }

            $result = $this->db->insert('leg_amount');

            if ($result) {
                $ewallet_id = $this->db->insert_id();
                $this->validation_model->addEwalletHistory($user_id, $from_user, $ewallet_id, 'commission', $amount_payable, $amount_type, 'credit');
                $this->updateBalanceAmount($user_id, $amount_payable);

                if (ANDROID_APP_STATUS == "yes") {

                    $subfolder = 'admin';
                    if ($this->LOG_USER_TYPE != 'admin' && $this->LOG_USER_TYPE != 'employee') {
                        $subfolder = 'user';
                    }
                    $this->lang->load('ewallet', $this->LANG_NAME . "/$subfolder");

                    if ($amount_type == "leg") {
                        $amount_type = lang('binary_commission');
                    } elseif ($amount_type == "level_commission") {
                        $amount_type = lang("level_commission");
                    } else if ($amount_type == "auto_board_1") {
                        $amount_type = lang('auto_board_1');
                    } else if ($amount_type == "board_fill_commission") {
                        $amount_type = lang("board_fill_commission");
                    } elseif ($amount_type == "rank_commission") {
                        $amount_type = lang('rank_commission');
                    } else if ($amount_type == "referral") {
                        $amount_type = lang('referal_commission');
                    }

                    $from_username = $this->validation_model->IdToUserName($from_user);
                    $data = array("message" => sprintf(lang('you_received_commission_from_user'), $amount_type, $amount_payable, $from_username));

                    $api_key = $this->validation_model->getUserApiKey($user_id);
                    $this->validation_model->sendGoogleCloudMessage($data, $api_key);
                }
            }
        }
        return $result;
    }

    public function updateBalanceAmount($user_id, $total_amount) {
        $this->db->set('balance_amount', 'ROUND(balance_amount +' . $total_amount . ',8)', FALSE);
        $this->db->where('user_id', $user_id);
        $this->db->limit(1);
        $res = $this->db->update('user_balance_amount');

        return $res;
    }

    public function insertReferalAmount($referal_id, $referal_amount, $from_user, $from_level = 0) {

        $res = "";
        if ($referal_id != "") {
            $this->load->model('settings_model');
            $config_details = $this->settings_model->getSettings();

            $amount_type        = "referral";
            $date_of_sub        = date("Y-m-d H:i:s");
            $total_amount       = $referal_amount;
            $tds_db             = $config_details["tds"];
            $service_charge_db  = $config_details["service_charge"];
            $tds_amount         = ($total_amount * $tds_db ) / 100;
            $service_charge     = ($total_amount * $service_charge_db ) / 100;
            $amount_payable     = $total_amount - ($tds_amount + $service_charge);

            $res = $this->insertInToLegAmount($referal_id, $total_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $from_level, $amount_type, $from_user);
        }
        return $res;
    }

    public function insertRankBonus($user_id, $total_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $amount_type = "leg", $from_id = '', $from_level = 0) {
        $result = FALSE;
        if ($total_amount) {
            $result = $this->insertInToLegAmount($user_id, $total_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $from_level, $amount_type, $from_id);
        }
        return $result;
    }

    public function updatePersonalPV($user_id, $pv) {
        
        if($this->MODULE_STATUS['product_status'] == 'yes') {
            $this->db->set('personal_pv', "personal_pv + {$pv}", FALSE);
            $this->db->where('id', $user_id);
            $this->db->update('ft_individual');
        }
         
       //newcode    
     //  $personal_pv = $this->validation_model->getPersnlPv($user_id);
       $sponsor_id = $this->validation_model->getSponsorId($user_id);
       
       $left_sponsor_status = $this->validation_model->getLeftSponsorStatus($sponsor_id);
       $right_sponsor_status = $this->validation_model->getRightSponsorStatus($sponsor_id);
       
      // if($personal_pv >= 100 && ($left_sponsor_status !='yes' || $right_sponsor_status != 'yes')) {
           if($left_sponsor_status !='yes' || $right_sponsor_status != 'yes') {
        $position = $this->getUnilevelUplineForBinary($user_id,$sponsor_id);
        
        if($position == 'L') {
            $this->db->set('left_sponsor_status', 'yes');
            $this->db->where('id', $sponsor_id);
            $this->db->update('ft_individual');
          
        }elseif($position == 'R') {
            $this->db->set('right_sponsor_status', 'yes');
            $this->db->where('id', $sponsor_id);
            $this->db->update('ft_individual');
       }
        
      }
       //end
        
        return true;
          
    }

    public function updateGroupPV($user_id, $pv) {
        if($this->MODULE_STATUS['product_status'] == 'yes') {
            $date = date("Y-m-d H:i:s");
            $this->db->select('sponsor_id,active,subs_end_date');
            $this->db->where('id', $user_id);
           
            $this->db->limit(1);
            $query = $this->db->get('ft_individual');

            if ($query->num_rows() > 0) {
                $sponsor_id = $query->row_array()['sponsor_id'];
                $active = $query->row_array()['active'];
                $subs_date = $query->row_array()['subs_end_date'];
               
                //if($active == 'yes' && ($subs_date >= $date ||$subs_date==NULL)){
                $this->db->set('gpv', "gpv + {$pv}", FALSE);
                $this->db->where('id', $user_id);
                $this->db->update('ft_individual');
               // }
                

                return $this->updateGroupPV($sponsor_id, $pv);
            }
        }
    }


    public function calculateReferralCommission($referal_id, $user_id) {
        $referal_amount = 0;
        $type = $this->getSponsorCommissionType();
        if($type == "rank" && $this->MODULE_STATUS['rank_status'] == 'yes'){
            $referal_amount = $this->getRankWiseReferalAmount($referal_id);
        } elseif ($this->MODULE_STATUS['opencart_status'] == 'yes' && $this->MODULE_STATUS['opencart_status_demo'] == 'yes') {
            $referal_amount = $this->getOCPackageWiseReferalAmount($referal_id, $type, $user_id);
        } elseif ($this->MODULE_STATUS['product_status'] == 'yes') {
            $referal_amount = $this->getPackageWiseReferalAmount($referal_id, $type, $user_id);
        } else {
            $referal_amount = $this->getReferalAmount();
        }

        if ($referal_amount > 0) {
            $this->insertReferalAmount($referal_id, $referal_amount, $user_id, 1);
        }
    }

    public function getPackageWiseReferalAmount($referral_id, $type, $user_id) {
        if($type == 'joinee_package') {
            $referral_id = $user_id;
        }
        $this->db->select('p.referral_commission as commission');
        $this->db->from('ft_individual f');
        $this->db->join('package p', 'f.product_id = p.prod_id');
        $this->db->where('f.id', $referral_id);
        $this->db->where('p.type_of_package', 'registration');
        $this->db->where('p.active !=', 'deleted');
        $query = $this->db->get();
        return $query->row_array()['commission'];
    }

    public function getOCPackageWiseReferalAmount($referral_id, $type, $user_id) {
        if($type == 'joinee_package') {
            $referral_id = $user_id;
        }
        $this->db->select('p.referral_commission');
        $this->db->from('ft_individual f');
        $this->db->join('oc_product p', 'f.product_id = p.package_id');
        $this->db->where('f.id', $referral_id);
        $this->db->where('p.package_type', 'registration');
        $query = $this->db->get();
        return $query->row_array()['referral_commission'];
    }

    public function getReferalAmount() {
        $referal_amount = 0;
        $this->db->select('referal_amount');
        $this->db->from('configuration');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $referal_amount = $row->referal_amount;
        }
        return $referal_amount;
    }
    public function getSponsorCommissionType() {
        $sponsor_commission_type = 'NA';
        $this->db->select('sponsor_commission_type');
        $this->db->from('configuration');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $sponsor_commission_type = $row->sponsor_commission_type;
        }
        return $sponsor_commission_type;
    }

    public function getRankWiseReferalAmount($referral_id) {
        $this->db->select('r.referal_commission');
        $this->db->from('rank_details r');
        $this->db->join('ft_individual f', 'r.rank_id = f.user_rank_id');
        $this->db->where('f.id', $referral_id);
        $this->db->where('r.rank_status', 'active');
        $query = $this->db->get();
        return isset($query->row_array()['referal_commission']) ? $query->row_array()['referal_commission'] : 0;
    }

    public function deductPersonalPV($user_id, $pv) {
        if($this->MODULE_STATUS['product_status'] == 'yes') {
            $this->db->set('personal_pv', "personal_pv - {$pv}", FALSE);
            $this->db->where('id', $user_id);
            return $this->db->update('ft_individual');
        }
    }

    public function deductGroupPV($user_id, $pv) {
        if($this->MODULE_STATUS['product_status'] == 'yes') {
            $this->db->select('sponsor_id');
            $this->db->where('id', $user_id);
            $this->db->limit(1);
            $query = $this->db->get('ft_individual');

            if ($query->num_rows() > 0) {
                $sponsor_id = $query->row_array()['sponsor_id'];

                $this->db->set('gpv', "gpv - {$pv}", FALSE);
                $this->db->where('id', $user_id);
                $this->db->update('ft_individual');

                return $this->deductGroupPV($sponsor_id, $pv);
            }
        }
    }

////////////////////Addon bonus///////////////////////start/////////////////////////////////////////////


    public function calculateMatchingBonus($action, $from_id, $commission_amount, $date_of_sub, $tds_db, $service_charge_db, $matching_bonus_config) {
        $matching_bonus_levels = $this->validation_model->getConfig('matching_upto_level');
        $bonus_criteria = $this->validation_model->getConfig('matching_criteria');
        if ($action == 'repurchase') {
            $amount_type = 'matching_bonus_purchase';
        }
        elseif ($action == 'upgrade') {
            $amount_type = 'matching_bonus_upgrade';
        }
        else {
            $amount_type = 'matching_bonus';
        }
        $sponsor_id = $this->validation_model->getSponsorId($from_id);
        $upline_users = $this->getUnilevelUplines($sponsor_id, $matching_bonus_levels);
        foreach ($upline_users as $upline) {
            $user_id = $upline['id'];
            $level = $upline['user_level'];
            $status = $upline['active'];
            if($bonus_criteria == "genealogy"){
                $level_percent = $matching_bonus_config[$level];
            }else{
                $level_percent = $this->settings_model->getMatchingLevelConfig($level,$this->validation_model->getProductId($user_id),"cmsn_member_pck");
            }
            $level_amount = $commission_amount * ($level_percent / 100);
            $tds = ($level_amount * $tds_db) / 100;
            $service_charge = ($level_amount * $service_charge_db) / 100;
            $amount_payable = $level_amount - ($tds + $service_charge);
            if ($amount_payable > 0) {
                $this->insertInToLegAmount($user_id, $level_amount, $amount_payable, $tds, $service_charge, $date_of_sub, $level, $amount_type, $from_id);
            }
        }
    }

    public function calculateFastStartBonus($user_id) {
        $fast_start_bonus_status = $this->validation_model->getCompensationConfig('fast_start_bonus');
        if ($fast_start_bonus_status == 'yes') {
            $bonus_recieved = $this->isFastStartBonusRecieved($user_id);
            if (!$bonus_recieved) {
                $join_date = $this->validation_model->getJoiningData($user_id);
                $referral_count = $this->validation_model->getReferalCount($user_id);
                $fast_start_bonus_config = $this->configuration_model->getFastStartBonusConfig();
                $total_amount = $fast_start_bonus_config['bonus_amount'];
                if ($total_amount > 0) {
                    $end_date = date('Y-m-d', strtotime("{$join_date} +{$fast_start_bonus_config['days_count']} days"));
                    $current_date = date('Y-m-d');
                    if ($current_date < $end_date && $referral_count >= $fast_start_bonus_config['referral_count']) {
                        $date = date('Y-m-d H:i:s');
                        $config_details = $this->validation_model->getConfig(['tds', 'service_charge']);
                        $tds_db = $config_details["tds"];
                        $service_charge_db = $config_details["service_charge"];
                        $tds = ($total_amount * $tds_db) / 100;
                        $service_charge = ($total_amount * $service_charge_db) / 100;
                        $amount_payable = $total_amount - ($tds + $service_charge);
                        $this->insertInToLegAmount($user_id, $total_amount, $amount_payable, $tds, $service_charge, $date, 0, 'fast_start_bonus');
                    }
                }
            }
        }
    }

    public function isFastStartBonusRecieved($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('amount_type', 'fast_start_bonus');
        $count = $this->db->count_all_results('leg_amount');
        return ($count == 1);
    }

    public function calculatePerformanceBonus($user_id, $pv) {
        if ($pv > 0) {
            $performance_bonus_status = $this->validation_model->getCompensationConfig('performance_bonus');
            if ($performance_bonus_status == 'yes') {
                $performance_bonus_config = $this->configuration_model->getPerformanceBonusConfig();
                if (count($performance_bonus_config)) {
                    $date = date('Y-m-d H:i:s');
                    $config_details = $this->validation_model->getConfig(['tds', 'service_charge']);
                    $tds_db = $config_details["tds"];
                    $service_charge_db = $config_details["service_charge"];
                    $bonus_amount_types = array_keys($performance_bonus_config);
                    $upline_users = $this->getUnilevelUplinesForPerformanceBonus($user_id);
                    foreach ($upline_users as $u) {
                        if ($u['active'] == 'yes') {
                            $received_bonus = $this->getReceivedPerformanceBonus($u['id'], $bonus_amount_types);
                            $not_received_bonus = array_diff($bonus_amount_types, $received_bonus);
                            foreach ($not_received_bonus as $bonus) {
                                if ($u['personal_pv'] >= $performance_bonus_config[$bonus]['personal_pv'] && $u['group_pv'] >= $performance_bonus_config[$bonus]['group_pv']) {
                                    $total_amount = ($u['personal_pv'] * $performance_bonus_config[$bonus]['bonus_percent']) / 100;
                                    $tds = ($total_amount * $tds_db) / 100;
                                    $service_charge = ($total_amount * $service_charge_db) / 100;
                                    $amount_payable = $total_amount - ($tds + $service_charge);
                                    $this->insertInToLegAmount($u['id'], $total_amount, $amount_payable, $tds, $service_charge, $date, 0, $bonus);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function getUnilevelUplinesForPerformanceBonus($user_id, $uplines = [])
    {
        $this->db->select('active,personal_pv,gpv group_pv,sponsor_id');
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get('ft_individual');
        if ($query->num_rows() > 0) {
            $res_arr = $query->row_array();
            $res_arr['id'] = $user_id;
            $uplines[] = $res_arr;
            return $this->getUnilevelUplinesForPerformanceBonus($res_arr['sponsor_id'], $uplines);
        }
        return $uplines;
    }

    public function getReceivedPerformanceBonus($user_id, $bonus_amount_types)
    {
        $this->db->select('amount_type');
        $this->db->where('user_id', $user_id);
        $this->db->where_in('amount_type', $bonus_amount_types);
        $this->db->order_by('date_of_submission', 'DESC');
        $query = $this->db->get('leg_amount');
        $amount_types = [];
        foreach ($query->result_array() as $row) {
            $amount_types[] = $row['amount_type'];
        }
        return $amount_types;
    }


////////////////////Addon bonus///////////////////////end/////////////////////////////////////////////

public function calculateSaleCommission($action, $from_user, $sponsor_id, $product_id, $product_pair_value, $product_amount, $oc_order_id = 0, $quantity = 0) {

    if ($action == 'repurchase') {
        $amount_type = 'sales_commission';
    }

    $config_details = $this->validation_model->getConfig(['sales_level', 'tds', 'service_charge', 'sales_type','sales_criteria']);
    $tds_db = $config_details["tds"];
    $service_charge_db = $config_details["service_charge"];
    $type_comission = $config_details["sales_criteria"];
    $depth_ceiling = $config_details['sales_level'];
    $commission_criteria = $config_details['sales_type'];


    if($commission_criteria == 'genealogy'){

        $level_config = $this->settings_model->getSalesLevelConfig();
    }

    if ($depth_ceiling > 0) {

        $upline_users = $this->getUnilevelUplines($sponsor_id, $depth_ceiling);
        $date_of_sub = date("Y-m-d H:i:s");

        foreach ($upline_users as $upline) {
            $user_id = $upline['id'];
            $level = $upline['user_level'];
            $status = $upline['active'];
            $level_amount = 0;

            if($commission_criteria == 'package'){
                $level_percent = $this->settings_model->getSalesPackConfig($level,$this->validation_model->getProductId($user_id),"sales");
            }elseif($commission_criteria == 'rank'){
                $level_percent = $this->settings_model->getSalesRankConfig($level,$this->validation_model->getUserRank($user_id),"sales");
            }else{
                $level_percent = $level_config[$level];
            }

            if ($type_comission == "cv") {
                $level_amount = $product_pair_value * ($level_percent / 100);
            } elseif($type_comission == "sp") {
                $level_amount = $product_amount * ($level_percent / 100);
            }

            if ($level_amount) {
                $tds_amount = ($level_amount * $tds_db) / 100;
                $service_charge = ($level_amount * $service_charge_db) / 100;
                $amount_payable = $level_amount - ($tds_amount + $service_charge);
                if ($status == 'yes') {
                    $result = $this->insertInToLegAmount($user_id, $level_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $level, $amount_type, $from_user, $product_id, $product_pair_value, $product_amount, $oc_order_id);

                    if (!$result) {
                        return FALSE;
                    }
                }
            }
        }
    }
    return TRUE;
}

    public function insertRankIncentive($user_id, $total_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $amount_type = "leg", $from_id = '', $from_level = 0,$rank_id = 0) {
        $result = FALSE;
        if ($total_amount) {
            $result = $this->insertInToLegAmount($user_id, $total_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $from_level, $amount_type, $from_id,0,0,0,0,0,0,0,$rank_id);
        }
        return $result;
    }
    
    public function calculateGlobalBonus($user, $global_bv, $total_share, $one_share, $spon_limit) {
        if (!empty($user)) {
            $this->load->model('settings_model');
            $config_details = $this->settings_model->getSettings();
            $amount_type = "global_bonus";
          //  $date_of_sub = date("Y-m-d H:i:s");
            $date_of_sub = date('Y-m-d', strtotime('last day of previous month'))." 23:50:50";
            $total_amount = $user['share'] * $one_share;
            $tds_db = $config_details["tds"];
            $service_charge_db = $config_details["service_charge"];
            $tds_amount = ($total_amount * $tds_db ) / 100;
            $service_charge = ($total_amount * $service_charge_db ) / 100;
            $amount_payable = $total_amount - ($tds_amount + $service_charge);
            $res = $this->insertInToLegAmount($user['user_id'], $total_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, 0, $amount_type, 0, $global_bv, $total_share, $spon_limit);
        }
        return true;
    }
    
    public function calculateCarBonus($user_id, $total_amount) {
        if ($user_id) {
            $this->load->model('settings_model');
            $config_details = $this->settings_model->getSettings();
            $amount_type = "car_bonus";
           // $date_of_sub = date("Y-m-d H:i:s");
            $date_of_sub = date('Y-m-d', strtotime('last day of previous month'))." 23:50:50";
            $tds_db = $config_details["tds"];
            $service_charge_db = $config_details["service_charge"];
            $tds_amount = ($total_amount * $tds_db ) / 100;
            $service_charge = ($total_amount * $service_charge_db ) / 100;
            $amount_payable = $total_amount - ($tds_amount + $service_charge);
            $res = $this->insertInToLegAmount($user_id, $total_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, 0, $amount_type);
        }
        return true;
    }

}
