<?php

class rank_model extends inf_model {

    public function __construct() {
        parent::__construct();
        $this->load->model('validation_model');
        $this->load->model('configuration_model');
        $this->load->model('calculation_model');
    }

//For repurchase & upgrade starts
    public function updateUplineRank($purchse_user_id) {

        $rank_configuration = $this->configuration_model->getRankConfiguration();
        $rank_commission_status = $this->validation_model->getCompensationConfig(['rank_commission_status']);
        if($rank_configuration['rank_expiry'] == 'fixed') {
            if ($rank_configuration['joinee_package']) {
                $old_rank = $this->validation_model->getUserRank($purchse_user_id);
                $new_rank = $this->checkNewRank(0, 0, 0, $purchse_user_id, $old_rank);
                if ($new_rank != $old_rank) {
                    $this->updateUserRank($purchse_user_id, $new_rank);
                    if($rank_commission_status == 'yes') {
                        $this->rankBonus($new_rank, $purchse_user_id, $purchse_user_id);
                    }
                }
                return true;
            } else {
                $father_upline =  $this->getAllUplineFatherId($purchse_user_id, 0);
                $sponsor_upline = $this->getAllUplineSponserId($purchse_user_id, 0, $father_upline);

                foreach($sponsor_upline as $uplines) {
                    $user_id        = $uplines["id"];
                    $personal_pv    = $uplines["personal_pv"];
                    $group_pv       = $uplines["gpv"];
                    $old_rank       = $uplines["user_rank_id"];
                    $user_status    = $uplines["active"];
                    $referal_count  = $this->validation_model->getReferalCount($user_id);
                    if ($user_status == 'yes') {
                            $new_rank = $this->checkNewRank($referal_count, $personal_pv, $group_pv, $user_id, $old_rank);
                        if ($new_rank != $old_rank) {
                            $this->updateUserRank($user_id, $new_rank);

                            if($rank_commission_status == 'yes') {
                                $this->rankBonus($new_rank, $user_id, $purchse_user_id);
                            }
                        }
                    }
                }
            }
        }
    }

    public function rankBonus($new_rank, $user_id, $purchse_user_id) {

        $rank_bonus     = $this->configuration_model->getActiveRankDetails($new_rank);
        $date_of_sub    = date("Y-m-d H:i:s");
        $amount_type    = "rank_bonus";
        $obj_arr        = $this->validation_model->getSettings();
        $tds_db         = $obj_arr["tds"];
        $service_charge = $obj_arr["service_charge"];
        $rank_amount    = $rank_bonus[0]['rank_bonus'];
        $tds_amount     = ($rank_amount * $tds_db) / 100;
        $service_charge = ($rank_amount * $service_charge) / 100;
        $amount_payable = $rank_amount - ($tds_amount + $service_charge);

        $this->calculation_model->insertRankBonus($user_id, $rank_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $amount_type, $purchse_user_id, 1);
    }

    public function getAllUplineSponserId($id, $i, $uplines = []) {
        $flag = FALSE;
        $this->db->select('sponsor_id, active, personal_pv, gpv,user_rank_id');
        $this->db->from('ft_individual');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res_arr = $query->row_array();
            $res_arr['id'] = $id;
            foreach($uplines as $upline_user) {
                if($upline_user['id'] == $id)
                   $flag = TRUE;
                   if($flag)
                    continue;
            }
            if(!$flag)
                $uplines[] = $res_arr;

           return $this->getAllUplineSponserId($res_arr['sponsor_id'], $i, $uplines);

        }
        return $uplines;
    }

    public function getAllUplineFatherId($id, $i, $uplines = []) {
        $flag = FALSE;        
        $this->db->select('father_id, active, personal_pv, gpv,user_rank_id');
        $this->db->from('ft_individual');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res_arr = $query->row_array();
            $res_arr['id'] = $id;
            $uplines[] = $res_arr;

           return $this->getAllUplineFatherId($res_arr['father_id'], $i, $uplines);

        }
        return $uplines;
    }
//For repurchase & upgrade ends

    public function checkNewRank($referal_count, $personal_pv, $group_pv, $user_id, $curent_rank)
    {
        if(empty($group_pv))
        {
            $group_pv = 0;
        }
        $criteria = [
            'referal_count' => FALSE,
            'joinee_package' => FALSE,
            'personal_pv' =>FALSE,
            'group_pv' =>FALSE,
            'downline_member_count' => FALSE,
            'downline_purchase_count' => FALSE,
            'downline_rank' => FALSE,
        ];

       $rank_configuration = $this->configuration_model->getRankConfiguration();
        if ($rank_configuration['referal_count']) {
            $criteria['referal_count'] = TRUE;
        }

        if ($rank_configuration['personal_pv']) {
            $criteria['personal_pv'] = TRUE;
        }
        if ($rank_configuration['group_pv']) {
            $criteria['group_pv'] = TRUE;
        }

        if ($rank_configuration['downline_member_count'] && in_array($this->MLM_PLAN, ['Binary', 'Matrix'])) {
            $total_downline_count =  $this->getLeftRightDownlineUsersCount($user_id,'father');
            $criteria['downline_member_count'] = TRUE;
        }

        if ($rank_configuration['downline_purchase_count']) {
            $criteria['downline_purchase_count'] = TRUE;
        }

        if ($rank_configuration['downline_rank']) {
            $criteria['downline_rank'] = TRUE;
        }

        if ($rank_configuration['joinee_package']) {

            $criteria = ['referal_count' => FALSE, 'personal_pv' =>FALSE, 'group_pv' =>FALSE, 'downline_member_count' => FALSE, 'downline_purchase_count' => FALSE, 'downline_rank' => FALSE];
            $criteria['joinee_package'] = TRUE;
            $user_package_id = $this->validation_model->getProductId($user_id);
            $joinee_rank_id = $this->getJoineeRankId($user_package_id);
            
        }

        if ($criteria['downline_purchase_count']) {
            $downline_package_details = $this->getLeftRightDownlinePackageCount($user_id, 'father');
            if ($downline_package_details) {
                $this->db->select('rd.rank_id');
                foreach ($downline_package_details as $v) {
                    $this->db->select("COALESCE(SUM(CASE WHEN package_id='{$v['package_id']}' THEN package_count END), 0) AS {$v['package_id']}", FALSE);
                    $package_columns[] = $v['package_id'];
                }
                $this->db->from('purchase_rank as r1');
                $this->db->where('rd.rank_status', 'active');
                $this->db->where('rd.delete_status', 'yes');
                $this->db->join("rank_details AS rd", 'rd.rank_id = r1.rank_id','right');
                $this->db->group_by('rd.rank_id');
                $downline_package_query = $this->db->get_compiled_select();
            }
        }

        if ($criteria['downline_rank']) {
            $downline_rank_details = $this->getLeftRightDownlineRankWiseCount($user_id, 'father');
            if ($downline_rank_details) {
                $this->db->select('rd.rank_id');
                foreach ($downline_rank_details as $v) {
                    $this->db->select("COALESCE(SUM(CASE WHEN r1.downline_rank_id='{$v['rank_id']}' THEN rank_count END), 0) AS {$v['rank_name']}", FALSE);
                    $rank_columns[] = $v['rank_name'];
                }
                $this->db->from('downline_rank as r1');
                $this->db->where('rd.rank_status', 'active');
                $this->db->where('rd.delete_status', 'yes');
                $this->db->join("rank_details AS rd", 'rd.rank_id = r1.rank_id','right');
                $this->db->group_by('rd.rank_id');
                $downline_rank_query = $this->db->get_compiled_select();
            }
        }

        $this->db->select('r.rank_id,r.rank_name');
        $this->db->from('rank_details r');

        if ($criteria['referal_count']) {
            $this->db->where('r.referal_count <=', $referal_count);
        }

        if ($criteria['joinee_package']) {
            $this->db->where('r.rank_id', $joinee_rank_id);
        }

        if ($criteria['personal_pv']) {
            $this->db->where('r.personal_pv <=', $personal_pv);
        }
        if ($criteria['group_pv']) {
            $this->db->where('r.gpv <=', $group_pv);
        }
        if($curent_rank != NULL) {
            $this->db->where('r.rank_id >', $curent_rank);
        }

        if ($criteria['downline_member_count']) {
            $this->db->where('r.downline_count <=', $total_downline_count);
        }

        if ($criteria['downline_purchase_count']) {
            $package_columns = implode(',', $package_columns);
            $this->db->select($package_columns);
            $this->db->join("({$downline_package_query}) AS p", 'p.rank_id=r.rank_id');
            foreach($downline_package_details as $d) {
                $this->db->where("p.{$d['package_id']} <=", $d['count']);
            }
        }

        if ($criteria['downline_rank']) {
            $rank_columns = implode(',', $rank_columns);
            $this->db->select($rank_columns);
            $this->db->join("({$downline_rank_query}) AS dwr", 'dwr.rank_id=r.rank_id');
            foreach($downline_rank_details as $d) {
               $this->db->where("dwr.{$d['rank_name']} <=", $d['count']);
            }
        }

        $this->db->where('r.rank_status', 'active');
        $this->db->where('r.delete_status', 'yes');
        $this->db->order_by('r.rank_id', 'ASC');
        $query = $this->db->get();
        $rank_id = $curent_rank;
        foreach ($query->result() as $row) {
            $rank_id = $row->rank_id;
            $this->insertIntoRankHistory($curent_rank, $rank_id, $user_id);
            $curent_rank = $rank_id;
        }
        return $rank_id;
    }

    public function getLeftRightDownlineUsersCount($user_id, $type, $user_level= '') {

        $arr = $this->validation_model->getUserLeftAndRight($user_id, $type);
        $this->db->select('f.id');
        $this->db->where("t.left_$type >", $arr["left_$type"]);
        $this->db->where("t.right_$type <", $arr["right_$type"]);

        if($user_level != "") {
            $this->db->where('f.user_level',$user_level);
        }
        $this->db->from("ft_individual f");
        $this->db->join('tree_parser t', "f.id=t.ft_id", 'LEFT');
        $numrows = $this->db->count_all_results(); // Number of rows returned from above query.
        return $numrows;
    }

    public function getIndirectDownlineCount($user_id, $type) {

        $arr = $this->validation_model->getUserLeftAndRight($user_id, $type);
        $this->db->select('f.id');
        $this->db->where("t.left_$type >", $arr["left_$type"]);
        $this->db->where("t.right_$type <", $arr["right_$type"]);
        $this->db->where("f.father_id !=", $user_id);
        $this->db->from("ft_individual f");
        $this->db->join('tree_parser t', "f.id=t.ft_id", 'LEFT');
        $numrows = $this->db->count_all_results();
        return $numrows;
    }

    public function getDirectDownlineCount($user_id, $type) {

        $arr = $this->validation_model->getUserLeftAndRight($user_id, $type);
        $this->db->select('f.id');
        $this->db->where("t.left_$type >", $arr["left_$type"]);
        $this->db->where("t.right_$type <", $arr["right_$type"]);
        $this->db->where("f.father_id =", $user_id);
        $this->db->from("ft_individual f");
        $this->db->join('tree_parser t', "f.id=t.ft_id", 'LEFT');
        $numrows = $this->db->count_all_results();
        return $numrows;
    }

    public function getLeftRightDownlinePackageCount($user_id, $type) {
        $rs    = [];
        $arr   = $this->validation_model->getUserLeftAndRight($user_id, $type);

        $this->db->select('f.id, f.product_id');
        $this->db->where("t.left_$type >", $arr["left_$type"]);
        $this->db->where("t.right_$type <", $arr["right_$type"]);
        $this->db->from("ft_individual f");
        $this->db->join('tree_parser t', "f.id = t.ft_id", 'LEFT');
        $downline_users = $this->db->get_compiled_select();

        if ( ($this->MODULE_STATUS['opencart_status'] == "yes" && $this->MODULE_STATUS['opencart_status_demo'] == "yes")) {
            $this->db->select('count( du.id ) AS count,op.package_id,op.product_id');
            $this->db->from("oc_product op");
            $this->db->join("({$downline_users}) AS du", 'op.package_id = du.product_id', 'LEFT');
            $this->db->where('op.package_type', 'registration');
            $this->db->where('op.status', 1);
            $this->db->group_by("op.package_id");
        } else {
            $this->db->select('count( du.id ) AS count,p.prod_id package_id,p.product_id');
            $this->db->from('package as p');
            $this->db->join("({$downline_users}) AS du", 'p.prod_id = du.product_id', 'LEFT');
            $this->db->where('p.type_of_package', 'registration');
            $this->db->group_by('p.prod_id');
        }
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $rs[] = $row;
        }
        return $rs;
    }

    public function updateUserRank($id, $rank) {
        $this->db->set('user_rank_id', $rank);
        $this->db->where('id', $id);
        $result = $this->db->update('ft_individual');
        return $result;
    }

    public function getJoineeRankId($prod_id) {
        $rank_id = '';
        $this->db->select('rd.rank_id');
        $this->db->from('joinee_rank as jr');
        $this->db->where('rd.rank_status', 'active');
        $this->db->where('rd.delete_status', 'yes');
        $this->db->where('jr.package_id', $prod_id);
        $this->db->join("rank_details AS rd", 'rd.rank_id=jr.rank_id','left');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
           $rank_id = $row->rank_id;
        }
        return $rank_id;
    }

    public function insertIntoRankHistory($old_rank, $new_rank, $user_id) {
        $date = date('Y-m-d H:i:s');
        $this->db->set('user_id', $user_id);
        $this->db->set('current_rank', $old_rank);
        $this->db->set('new_rank', $new_rank);
        $this->db->set('date', $date);
        $res = $this->db->insert('rank_history');
        return $res;
    }

    public function getPurchaseRank($rank_id) {
        $details = [];
        $this->db->where('rank_id', $rank_id);
        $query = $this->db->get('purchase_rank');
        foreach ($query->result_array() as $row) {
            $details[] = $row;
        }
        return $details;
    }

    public function getRankCriteria($user_id)
    {
        $criteria = [
            'referal_count' => FALSE,
            'joinee_package' => FALSE,
            'personal_pv' =>FALSE,
            'group_pv' =>FALSE,
            'downline_count' => FALSE,
            'downline_package_count' => FALSE,
            'downline_rank' => FALSE,
        ];

        $rank_configuration = $this->configuration_model->getRankConfiguration();
        if ($rank_configuration['referal_count']) {
            $criteria['referal_count'] = TRUE;
        }

        if ($rank_configuration['joinee_package']) {
            $criteria['joinee_package'] = TRUE;
        }

        if ($rank_configuration['personal_pv']) {
            $criteria['personal_pv'] = TRUE;
        }
        if ($rank_configuration['group_pv']) {
            $criteria['group_pv'] = TRUE;
        }

        if ($rank_configuration['downline_member_count'] && in_array($this->MLM_PLAN, ['Binary', 'Matrix'])) {
            $criteria['downline_count'] = TRUE;
        }

       if ($rank_configuration['downline_purchase_count']) {
            $criteria['downline_package_count'] = TRUE;
       }

        if ($rank_configuration['downline_rank']) {
            $criteria['downline_rank'] = TRUE;
        }

        if ($criteria['downline_count']) {
            $this->db->select('COUNT(f3.id) downline_count');
            $this->db->from('tree_parser f1');
            $this->db->join('tree_parser f3', 'f3.left_sponsor > f1.left_sponsor AND f3.right_sponsor < f1.right_sponsor', 'LEFT');
            $this->db->where('f1.ft_id', $user_id);
            $downline_count = $this->db->get()->row_array()['downline_count'];
        }

        $this->db->select('f1.user_rank_id rank_id,r.rank_name');
        $this->db->select('COUNT(f2.id) referral_count');
        $this->db->from('ft_individual f1');
        $this->db->join('tree_parser t', 't.ft_id = f1.id', 'LEFT');
        $this->db->join('rank_details r', 'f1.user_rank_id=r.rank_id', 'LEFT');
        $this->db->join('ft_individual f2', 'f2.sponsor_id=f1.id', 'LEFT');
        if ($criteria['personal_pv']) {
            $this->db->select('f1.personal_pv');
        }
        if ($criteria['group_pv']) {
            $this->db->select('f1.gpv group_pv');
        }

        if ($criteria['downline_package_count']) {
            $this->db->select('t.left_sponsor,t.right_sponsor');
        }
        $this->db->where('f1.id', $user_id);
        $query = $this->db->get();
        $current_rank_details = $query->row_array();
        if ($criteria['downline_count']) {
            $current_rank_details['downline_count'] = $downline_count;
        }
        $next_rank_criteria = [];

        if ($criteria['downline_package_count']) {
            if ($this->MODULE_STATUS['opencart_status'] == "yes" && $this->MODULE_STATUS['opencart_status_demo'] == "yes") {
                $this->db->select('COUNT(f.id) package_count,op.package_id,op.product_id,op.model product_name');
                $this->db->from("oc_product op");
                $this->db->join('ft_individual f', "op.package_id=f.product_id", 'LEFT');
                $this->db->join('tree_parser t', "t.ft_id = f.id AND t.left_sponsor > {$current_rank_details['left_sponsor']} AND t.right_sponsor < {$current_rank_details['right_sponsor']}", 'LEFT');
                $this->db->where('op.package_type', 'registration');
                $this->db->where('op.status', 1);
                $this->db->group_by("op.package_id");
                $query2 = $this->db->get();
            } else {
                $this->db->select('COUNT(f.id) package_count,p.prod_id package_id,p.product_id,p.product_name');
                $this->db->from('package p');
                $this->db->join('ft_individual f', "p.prod_id=f.product_id", 'LEFT');
                $this->db->join('tree_parser t', "t.ft_id = f.id AND t.left_sponsor > {$current_rank_details['left_sponsor']} AND t.right_sponsor < {$current_rank_details['right_sponsor']}", 'LEFT');
                $this->db->where('p.type_of_package', 'registration');
                $this->db->group_by('p.prod_id');
                $query2 = $this->db->get();
        }

            $downline_package_details = $query2->result_array();
            if ($downline_package_details) {
                $this->db->select('rd.rank_id');
                foreach ($downline_package_details as $v) {
                    $current_rank_details['downline_package_count']["{$v['package_id']}"] = $v['package_count'];
                    $current_rank_details['package_name']["{$v['package_id']}"] = $v['product_name'];
                    $this->db->select("COALESCE(SUM(CASE WHEN package_id='{$v['package_id']}' THEN package_count END), 0) AS '{$v['package_id']}'", FALSE);
                }
                $this->db->from('purchase_rank as r1');
                $this->db->where('rd.rank_status', 'active');
                $this->db->where('rd.delete_status', 'yes');
                $this->db->join("rank_details AS rd", 'rd.rank_id=r1.rank_id','right');
                $this->db->group_by('rd.rank_id');
                $downline_package_query = $this->db->get_compiled_select();
            }
        }

        if ($current_rank_details) {
            $this->db->select('r.rank_id,r.rank_name,r.referal_count referral_count');
            $this->db->from('rank_details r');
            if ($criteria['personal_pv']) {
                $this->db->select('r.personal_pv');
            }
            if ($criteria['group_pv']) {
                $this->db->select('r.gpv group_pv');
            }
            if ($criteria['downline_count']) {
                $this->db->select('r.downline_count');
            }
            if ($criteria['downline_package_count'] && isset($current_rank_details['downline_package_count'])) {  
                $package_columns = array_map(function ($value) {
                    return 'p.' . "`$value`";
                }, array_keys($current_rank_details['downline_package_count']));
                $package_columns = implode(',', $package_columns);              
                $this->db->select($package_columns);
                $this->db->join("({$downline_package_query}) AS p", 'p.rank_id=r.rank_id');
            }
            $this->db->where('r.rank_status', 'active');
            $this->db->where('r.delete_status', 'yes');
            if (!empty($current_rank_details['rank_id'])) {
                $this->db->where('r.rank_id >', $current_rank_details['rank_id']);
            }
            $this->db->order_by('r.rank_id', 'ASC');
            $this->db->limit(1);
            $query = $this->db->get();
            $next_rank_criteria = $query->row_array();
            if ($next_rank_criteria && isset($current_rank_details['downline_package_count'])) {
                
                foreach ($current_rank_details['downline_package_count'] as $package_id => $package_count) {
                    $next_rank_criteria['downline_package_count']["{$package_id}"] = $next_rank_criteria[$package_id];
                }
            }
        }

        return [
            'criteria' => $criteria,
            'current_rank' => $current_rank_details,
            'next_rank' => $next_rank_criteria,
        ];
    }

    public function getLeftRightDownlineRankWiseCount($user_id, $type) {
        $rs    = [];
        $arr   = $this->validation_model->getUserLeftAndRight($user_id, $type);

        $this->db->select('f.id, f.user_rank_id');
        $this->db->where("t.left_$type >", $arr["left_$type"]);
        $this->db->where("t.right_$type <", $arr["right_$type"]);
        $this->db->from("ft_individual f");
        $this->db->join('tree_parser t', "f.id = t.ft_id", 'LEFT');
        $downline_users = $this->db->get_compiled_select();

        $this->db->select('count( du.id ) AS count,r.rank_id,r.rank_name');
        $this->db->from("rank_details as r");
        $this->db->join("({$downline_users}) AS du", 'r.rank_id = du.user_rank_id', 'LEFT');
        $this->db->where('r.rank_status', 'active');
        $this->db->group_by('r.rank_id');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $rs[] = $row;
        }
        return $rs;
    }

    public function getProductWiseRank($package_id) {

        $this->db->select('rank_name');
        $this->db->from("package");
        $this->db->where('prod_id', $package_id);
        $this->db->where('active', 'yes');
        $this->db->where('type_of_package', 'registration');
        $query = $this->db->get();
        return $query->result_array();

    }

    public function updateDefaultRank($user_id, $rank_id) {
        $rank_commission_status = $this->validation_model->getCompensationConfig(['rank_commission_status']);
        $res = $this->rank_model->updateUserRank($user_id, $rank_id);
        if($res){
            $this->insertIntoRankHistory(0, $rank_id, $user_id);
            if($rank_commission_status == 'yes') {
                $this->rank_model->rankBonus($rank_id, $user_id, $user_id);
            }
        }
    }

    //Referance functions
    // public function updateRank($sponsor_id, $basic_demo_status, $user_id) {
        // $old_rank       = $this->validation_model->getUserRank($sponsor_id);
        // $user_status    = $this->validation_model->getUserStatus($sponsor_id);
        // $referal_count  = $this->validation_model->getReferalCount($sponsor_id);

        // if ($user_status == 'active') {
        //     if ($basic_demo_status == "yes") {
        //         $new_rank       = $this->checkNewRankforbasic($referal_count, $old_rank, $sponsor_id);
        //     } elseif ($basic_demo_status == "no") {
        //         $personal_pv    = (int) $this->validation_model->getPersnlPv($sponsor_id);
        //         $group_pv       = (int) $this->validation_model->getGrpPv($sponsor_id);
        //         $new_rank       = $this->checkNewRank($referal_count, $personal_pv, $group_pv, $sponsor_id, $old_rank);
        //     }
        //     if ($new_rank) {
        //         $this->updateUserRank($sponsor_id, $new_rank);

        //         $rank_bonus     = $this->configuration_model->getActiveRankDetails($new_rank);
        //         $date_of_sub    = date("Y-m-d H:i:s");
        //         $amount_type    = "rank_bonus";
        //         $obj_arr        = $this->validation_model->getSettings();
        //         $tds_db         = $obj_arr["tds"];
        //         $service_charge_db = $obj_arr["service_charge"];
        //         $rank_amount    = $rank_bonus[0]['rank_bonus'];
        //         $tds_amount     = ($rank_amount * $tds_db) / 100;
        //         $service_charge = ($rank_amount * $service_charge_db) / 100;
        //         $amount_payable = $rank_amount - ($tds_amount + $service_charge);

        //         $this->calculation_model->insertRankBonus($sponsor_id, $rank_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $amount_type, $user_id, 1);
        //     }
        // }
    // }


    // public function checkNewRank($referal_count, $personal_pv, $group_pv, $user_id, $curent_rank) {
    //     $rank_id = $curent_rank;
    //     $rs_arr  = [];
    //     $personal_pv_status = $this->MODULE_STATUS["personal_pv"];
    //     $group_pv_status    = $this->MODULE_STATUS["group_pv"];
    //     $downline_status    = $this->MODULE_STATUS["downline_count_rank"];
    //     $downline_member_status = $this->MODULE_STATUS["downline_purchase_rank"];

    //     if (($this->MLM_PLAN == "Binary" || $this->MLM_PLAN == "Matrix") && ($downline_status == 'yes')) {
    //         $downline_count = $this->getLeftRightDownlineUsersCount($user_id, 'sponsor');
    //         $this->db->where('downline_count <=', $downline_count);
    //     }

    //     $this->db->select('rank_id');
    //     if ($personal_pv_status == 'yes') {
    //         $this->db->where('personal_pv <=', $personal_pv);
    //     }
    //     if ($group_pv_status == 'yes') {
    //         $this->db->where('gpv <=', $group_pv);
    //     }
    //     $this->db->where('referal_count <=', $referal_count);
    //     $this->db->where('rank_status', 'active');
    //     if($curent_rank != NULL) {
    //         $this->db->where('rank_id >', $curent_rank);
    //     }
    //     $this->db->where('delete_status', 'yes');
    //     $this->db->order_by('rank_id', 'ASC');
    //     $res = $this->db->get('rank_details');

    //     if (($this->MLM_PLAN == "Binary" || $this->MLM_PLAN == "Matrix") && ($downline_member_status == 'yes')) {
    //         $downline_package = $this->getLeftRightDownlinePackageCount($user_id, 'sponsor');
    //         foreach ($res->result() as $row) {
    //             $rank_det = $this->getPurchaseRank($row->rank_id);
    //             $rs_arr = array_map(function($array1, $array2) {
    //                 return array_merge(isset($array1) ? $array1 : array(), isset($array2) ? $array2 : array());
    //             }, $downline_package, $rank_det);

    //             foreach ($rs_arr as $res) {
    //                 if (isset($res['count']) && isset($res['package_count'])) {
    //                     if($res['count'] >= $res['package_count']) {
    //                         $rank_id = $res['rank_id'];
    //                     } else {
    //                         $rank_id = NULL;
    //                     }
    //                 }
    //             }

    //             if($rank_id != NULL) {
    //                 $this->insertIntoRankHistory($curent_rank, $rank_id, $user_id);
    //                 $curent_rank = $rank_id;
    //             }
    //         }
    //     } else {
    //         foreach ($res->result() as $row) {
    //             $rank_id = $row->rank_id;
    //             $this->insertIntoRankHistory($curent_rank, $rank_id, $user_id);
    //             $curent_rank = $rank_id;
    //         }
    //     }
    //     return $rank_id;
    // }
    
        public function getDownlineInactivePV($user_id) {
        $in_amount = 0;
        $arr = $this->validation_model->getUserLeftAndRight($user_id, 'sponsor');
        $this->db->select_sum('personal_pv');
        $this->db->from('ft_individual f');
        $this->db->join('tree_parser t', 't.ft_id = f.id', 'LEFT');
        $this->db->where("t.left_sponsor >", $arr["left_sponsor"]);
        $this->db->where("t.right_sponsor <", $arr["right_sponsor"]);
        $this->db->where('f.active !=', 'yes');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            if ($row->personal_pv > 0) {
                $in_amount = $row->personal_pv;
            }
        }
        return $in_amount;
    }
    
    public function getHighestRankAchieved($user_id){
        
        $this->db->select_max('new_rank');
        $this->db->where('user_id',$user_id );
        $result = $this->db->get('rank_history');  
        foreach ($result->result() AS $row) {
            $highest_rank = $row->new_rank;
        }
        return $highest_rank;
    }
    
    public function getDownlineInactivePVGenology($user_id) {
        $in_amount = 0;
        $arr = $this->validation_model->getUserLeftAndRight($user_id, 'father');
        $this->db->select_sum('personal_pv');
        $this->db->from('ft_individual f');
        $this->db->join('tree_parser t', 't.ft_id = f.id', 'LEFT');
        $this->db->where("t.left_father >=", $arr["left_father"]);
        $this->db->where("t.right_father <=", $arr["right_father"]);
        $this->db->where('f.active !=', 'yes');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            if ($row->personal_pv > 0) {
                $in_amount = $row->personal_pv;
            }
        }
        return $in_amount;
    }
public function getMonthlyPV($user_id,$from_date='',$to_date=''){
        $month_pv=0;
        $cust_id = $this->validation_model->getOcCustomerId($user_id);
        if($to_date ==''){
            $from_date =  date('Y-m-d', strtotime('first day of previous month'))." 00:00:00";
            $to_date =  date('Y-m-d', strtotime('last day of previous month'))." 23:59:59";
        }
        $sales_pv = $this->getMonthlyPurchasePv($from_date,$to_date,$cust_id);
        $renewal_pv = $this->getMonthlyRenewalPv($from_date,$to_date,$user_id);
        $month_pv=$sales_pv+$renewal_pv;
        return $month_pv;
    }
    public function getMonthlyPurchasePv($from,$to,$cust_id){
        $sales_pv=0;
        $this->db->select('o.order_id,o.customer_id,o.confirm_date,op.pair_value,op.product_id,op.quantity');
        $this->db->from('oc_order o');
        $this->db->join('oc_order_product op', 'o.order_id = op.order_id', 'inner');
        $this->db->where("o.confirm_date >=",$from);
        $this->db->where("o.confirm_date <=", $to);
        $this->db->where('o.order_status_id', '5');
        $this->db->where('o.customer_id',$cust_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            if ($row->pair_value > 0) {
                $sales_pv =$sales_pv+($row->quantity*$row->pair_value);
            }
        }
    return $sales_pv;    
    }
    public function getMonthlyRenewalPv($from,$to,$user_id){
        $pv=0;
        $this->db->select('amount');
        $this->db->from('subscription_payment_detail');
        $this->db->where("paid_date >=",$from);
        $this->db->where("paid_date <=", $to);
        $this->db->where('user_id',$user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $pv= round($row->amount/2);
        }
      return $pv;  
    }
    public function getMonthlyGPV($user_id){
        $month_gpv=0;
        $cust_id = $this->validation_model->getOcCustomerId($user_id);
        $from =  date('Y-m-d', strtotime('first day of previous month'))." 00:00:00";
        $to =  date('Y-m-d', strtotime('last day of previous month'))." 23:59:59";
        $inactive_users=array();
        $this->db->select('id');
        $this->db->from('ft_individual');
        $this->db->where("active", 'no');
        $query = $this->db->get();//echo $this->db->last_query();die;
        $result = $query->result_array();
        
        $this->db->select('SUM(left_carry) + SUM(right_carry) as total');
        $this->db->from('business_volume');
        $this->db->where_not_in("from_id", array_column($result, 'id'));
        $this->db->where("date_of_submission >=",$from);
        $this->db->where("date_of_submission <=", $to);
        $this->db->where('user_id',$user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $month_gpv=$month_gpv+$row->total;
        }
        return $month_gpv;
    }
    public function getMonthlyActiveLeftGPV($user_id,$pos,$from='',$to=''){
        $month_gpv=0;
        $cust_id = $this->validation_model->getOcCustomerId($user_id);
        if($from==''){
            $from =  date('Y-m-d', strtotime('first day of previous month'))." 00:00:00";
            $to =  date('Y-m-d', strtotime('last day of previous month'))." 23:59:59";
        }
        $inactive_users=array();
        $this->db->select('id');
        $this->db->from('ft_individual');
        $this->db->where("active", 'no');
        $query = $this->db->get();//echo $this->db->last_query();die;
        $result = $query->result_array();
        if($pos=='L'){
            $this->db->select('SUM(left_carry) as total');
        }else{
            $this->db->select('SUM(right_carry) as total');
        }
        $this->db->from('business_volume');
        $this->db->where_not_in("from_id", array_column($result, 'id'));
        $this->db->where("date_of_submission >=",$from);
        $this->db->where("date_of_submission <=", $to);
        $this->db->where('user_id',$user_id);
        $this->db->where('action','added');
        $query = $this->db->get();//if($pos=='R'){echo $this->db->last_query();die;}
        foreach ($query->result() as $row) {
            $month_gpv=$month_gpv+$row->total;
        }
        return $month_gpv;
    }
    
    // current monthly
    
    public function getCurrentMonthlyPV($user_id,$from_date='',$to_date=''){
        $month_pv=0;
        $cust_id = $this->validation_model->getOcCustomerId($user_id);
        if($to_date ==''){
            $from_date =  date('Y-m-d', strtotime('first day of this month'))." 00:00:00";
            $to_date =  date('Y-m-d', strtotime('last day of this month'))." 23:59:59";
        }
        $sales_pv = $this->getMonthlyPurchasePv($from_date,$to_date,$cust_id);
        $renewal_pv = $this->getMonthlyRenewalPv($from_date,$to_date,$user_id);
        $month_pv=$sales_pv+$renewal_pv;
        return $month_pv;
    }
    
    public function getCurrentMonthlyActiveLeftGPV($user_id,$pos,$from='',$to=''){
        $month_gpv=0;
        $cust_id = $this->validation_model->getOcCustomerId($user_id);
        if($from==''){
            $from =  date('Y-m-d', strtotime('first day of this month'))." 00:00:00";
            $to =  date('Y-m-d', strtotime('last day of this month'))." 23:59:59";
        }
        $inactive_users=array();
        $this->db->select('id');
        $this->db->from('ft_individual');
        $this->db->where("active", 'no');
        $query = $this->db->get();//echo $this->db->last_query();die;
        $result = $query->result_array();
        if($pos=='L'){
            $this->db->select('SUM(left_carry) as total');
        }else{
            $this->db->select('SUM(right_carry) as total');
        }
        $this->db->from('business_volume');
        $this->db->where_not_in("from_id", array_column($result, 'id'));
        $this->db->where("date_of_submission >=",$from);
        $this->db->where("date_of_submission <=", $to);
        $this->db->where('user_id',$user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $month_gpv=$month_gpv+$row->total;
        }
        return $month_gpv;
    }
}
