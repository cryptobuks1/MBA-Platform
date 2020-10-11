<?php

class Tree_updation_model extends inf_model {

    function __construct() {
        parent::__construct();
        $this->load->model('tree_model');
    }

    public function deleteUser($user_id, $mlm_plan, $opencart_status) {
        $this->startTransaction();
        $customer_id = $this->validation_model->getOcCustomerId($user_id);
        $tree_details = $this->getTreeDetailsToDelete($user_id);
        $sponsor_tree_details = $this->getTreeDetailsToDelete($user_id, 'sponsor_tree');
        $user_data = $this->getUserData($user_id, $mlm_plan, $opencart_status, $customer_id);
        $this->deleteUserData($user_id, $mlm_plan, $opencart_status, $customer_id);
        $this->deleteTreeNode($tree_details);
        $this->deleteTreeNode($sponsor_tree_details, 'sponsor_tree');
        $this->updateSiblingNodes($tree_details, $mlm_plan);
        $this->insertDeletedUserData($user_data);
        $this->finishTransaction();
        return $this->isTransactionSuccess();
    }

    public function insertDeletedUserData($user_data) {
        $this->db->insert('user_deletion_history', $user_data);
    }

    public function deleteUserData($user_id, $mlm_plan, $opencart_status, $customer_id) {
        $this->db->where('user_detail_refid', $user_id);
        $this->db->delete('user_details');

        $this->db->where('user_id', $user_id);
        $this->db->delete('infinite_user_registration_details');

        $this->db->where('user_id', $user_id);
        $this->db->delete('user_balance_amount');

        $this->db->where('user_id', $user_id);
        $this->db->delete('tran_password');

        if($mlm_plan == 'Binary') {
            $this->db->where('id', $user_id);
            $this->db->delete('leg_details');
        }
        elseif($mlm_plan == 'Party') {
            $this->db->where('added_by', $user_id);
            $this->db->delete('party');

            $this->db->where('added_by', $user_id);
            $this->db->delete('party_guest');

            $this->db->where('added_by', $user_id);
            $this->db->delete('party_guest_invited');

            $this->db->where('added_by', $user_id);
            $this->db->delete('party_host');
        }
        elseif($mlm_plan == 'Board') {
            $this->db->where('user_ref_id', $user_id);
            $this->db->delete('auto_board_1');

            $this->db->where('user_ref_id', $user_id);
            $this->db->delete('auto_board_2');

            $this->db->where('board_top_id', $user_id);
            $this->db->delete('board_view');

            $this->db->where('user_id', $user_id);
            $this->db->delete('board_user_detail');
        }
        elseif($mlm_plan == 'Stair_Step') {
            $this->db->where('user_id', $user_id);
            $this->db->delete('stair_step');
        }
        if($opencart_status == 'yes') {
            $this->db->where('customer_id', $customer_id);
            $this->db->delete('customer');

            $this->db->where('customer_id', $customer_id);
            $this->db->delete('address');
        }
    }

    public function getUserData($user_id, $mlm_plan, $opencart_status, $customer_id) {

        $user_name = $this->validation_model->IdToUserName($user_id);

        $this->db->where('id', $user_id);
        $ft_details = $this->db->get('ft_individual')->row_array();

        $this->db->where('user_detail_refid', $user_id);
        $user_details = $this->db->get('user_details')->row_array();

        $this->db->where('user_id', $user_id);
        $registration_details = $this->db->get('infinite_user_registration_details')->row_array();

        $leg_details = array();
        if($mlm_plan == 'Binary') {
            $this->db->where('id', $user_id);
            $leg_details = $this->db->get('leg_details')->row_array();
        }

        $this->db->select('balance_amount');
        $this->db->where('user_id', $user_id);
        $ewallet_balance = $this->db->get('user_balance_amount')->row_array()['balance_amount'];

        $this->db->select('tran_password');
        $this->db->where('user_id', $user_id);
        $tran_password = $this->db->get('tran_password')->row_array()['tran_password'];

        $customer_details = array();
        $customer_address = array();
        if($opencart_status == 'yes') {
            $this->db->where('customer_id', $customer_id);
            $customer_details = $this->db->get('oc_customer')->row_array();

            $this->db->where('customer_id', $customer_id);
            $customer_address = $this->db->get('oc_address')->row_array();
        }

        $user_data = array(
            'user_id' => $user_id,
            'user_name' => $user_name,
            'ewallet_balance' => $ewallet_balance,
            'tran_password' => $tran_password,
            'ft_details' => serialize($ft_details),
            'registration_details' => serialize($registration_details),
            'user_details' => serialize($user_details),
            'leg_details' => serialize($leg_details),
            'customer_details' => serialize($customer_details),
            'customer_address' => serialize($customer_address)
        );

        return $user_data;
    }

    public function updateSiblingNodes($tree_details, $mlm_plan) {
        $this->load->model('registersubmit_model');
        if($mlm_plan == 'Matrix' || $mlm_plan == 'Board' || $mlm_plan == "Unilevel" || $mlm_plan == "Stair_Step" || $mlm_plan == "Party" || $mlm_plan == "Donation") {
            $this->db->set('position', 'position - 1', FALSE);
            $this->db->where('position >', $tree_details['position']);
            $this->db->where('father_id', $tree_details['parent_id']);
            $this->db->update('ft_individual');

        }

    }

    public function deleteTreeNode($tree_details, $type = 'tree') {
        $left = $tree_details['left'];
        $right = $tree_details['right'];
        $width = $tree_details['width'];
        $has_leafs = $tree_details['has_leafs'];
        $parent_id = $tree_details['parent_id'];
        if($type == 'tree') {
            $this->db->where("left_father >=", $left);
            $this->db->where("left_father <=", $right);
            $this->db->delete('tree_parser');

            $this->db->set('right_father', "right_father - $width", FALSE);
            $this->db->where('right_father > ', $right);
            $this->db->update('tree_parser');

            $this->db->set('left_father', "left_father - $width", FALSE);
            $this->db->where('left_father > ', $right);
            $this->db->update('tree_parser');
        }
        elseif($type == 'sponsor_tree') {
            if($has_leafs == 1) {
                $this->db->where("left_sponsor BETWEEN $left AND $right");
                $this->db->delete('tree_parser');

                $this->db->set('right_sponsor', "right_sponsor - $width", FALSE);
                $this->db->where('right_sponsor > ', $right);
                $this->db->update('tree_parser');

                $this->db->set('left_sponsor', "left_sponsor - $width", FALSE);
                $this->db->where('left_sponsor > ', $right);
                $this->db->update('tree_parser');
            }
            else {
                $db_prefix  = $this->db->dbprefix;
                $this->db->where('left_sponsor', $left);
                $this->db->delete('tree_parser');

                // $this->db->set('ft.sponsor_id', $parent_id,FALSE);
                // $this->db->update('ft_individual as ft join tree_parser as t on ft.id = t.ft_id');
                // $this->db->where('t.left_sponsor',$left + 1);
                $this->db->query("UPDATE `{$db_prefix}ft_individual` Join `{$db_prefix}tree_parser` on `{$db_prefix}ft_individual`.id = `{$db_prefix}tree_parser`.ft_id  SET `{$db_prefix}ft_individual`.sponsor_id = {$parent_id} WHERE `{$db_prefix}tree_parser`.left_sponsor = $left+1 ;");
                // $this->db->set('t.right_sponsor', "t.right_sponsor - 1", FALSE);
                // $this->db->set('t.left_sponsor', "t.left_sponsor - 1", FALSE);
                // $this->db->set('f.sponsor_level', 'f.sponsor_level - 1', FALSE);
                // $this->db->where("t.left_sponsor BETWEEN $left AND $right");
                // $this->db->update('ft_individual as f join tree_parser as t  on f.id = t.ft_id');
                $this->db->query("UPDATE `{$db_prefix}ft_individual` Join `{$db_prefix}tree_parser` on `{$db_prefix}ft_individual`.id = `{$db_prefix}tree_parser`.ft_id  SET `{$db_prefix}ft_individual`.sponsor_level = `{$db_prefix}ft_individual`.sponsor_level - 1 ,`{$db_prefix}tree_parser`.right_sponsor = `{$db_prefix}tree_parser`.right_sponsor - 1 , `{$db_prefix}tree_parser`.left_sponsor = `{$db_prefix}tree_parser`.left_sponsor - 1  WHERE `{$db_prefix}tree_parser`.left_sponsor BETWEEN {$left} AND {$right} ;");

                $this->db->set('right_sponsor', "right_sponsor - 2", FALSE);
                $this->db->where('right_sponsor > ', $right);
                $this->db->update('tree_parser');

                $this->db->set('left_sponsor', "left_sponsor - 2", FALSE);
                $this->db->where('left_sponsor > ', $right);
                $this->db->update('tree_parser');
            }
        }
    }

    public function hasChildren($user_id, $tree_type = 'tree') {
        if($tree_type == 'tree') {
            $this->db->where('father_id', $user_id);
        }
        elseif($tree_type == 'sponsor_tree') {
            $this->db->where('sponsor_id', $user_id);
        }
        $count = $this->db->count_all_results('ft_individual');
        return ($count > 0);
    }

    public function getTreeDetailsToDelete($user_id, $tree_type = 'tree') {
        if($tree_type == 'tree') {
            $this->db->select('(t.right_father - t.left_father) has_leafs', FALSE);
            $this->db->select('(t.right_father - t.left_father + 1) width', FALSE);
            $this->db->select('t.left_father left,t.right_father right,f.position,f.father_id parent_id');
        }
        elseif($tree_type == 'sponsor_tree') {
            $this->db->select('(t.left_sponsor - t.right_sponsor) has_leafs', FALSE);
            $this->db->select('(t.left_sponsor - t.right_sponsor + 1) width', FALSE);
            $this->db->select('t.left_sponsor left,t.right_sponsor right,f.position,f.sponsor_id parent_id');
        }
        $this->db->from('ft_individual f');
        $this->db->join('tree_parser t', 't.ft_id = f.id', 'LEFT');
        $this->db->where('f.id', $user_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function isUserOutsideTeam($user_id, $parent_id, $tree_type = 'tree') {
        if($tree_type == 'tree') {
            $user_left_right = $this->tree_model->getUserLeftAndRight($user_id, 'father');
            $parent_left_right = $this->tree_model->getUserLeftAndRight($parent_id, 'father');
            $user_left = $user_left_right['left_father'];
            $user_right = $user_left_right['right_father'];
            $parent_left = $parent_left_right['left_father'];
            $parent_right = $parent_left_right['right_father'];
        }
        elseif($tree_type == 'sponsor_tree') {
            $user_left_right = $this->tree_model->getUserLeftAndRight($user_id, 'sponsor');
            $parent_left_right = $this->tree_model->getUserLeftAndRight($parent_id, 'sponsor');
            $user_left = $user_left_right['left_sponsor'];
            $user_right = $user_left_right['right_sponsor'];
            $parent_left = $parent_left_right['left_sponsor'];
            $parent_right = $parent_left_right['right_sponsor'];
        }
        return ($parent_left < $user_left || $parent_right > $user_right);
    }

    public function changeSponsor($user_id, $new_sponsor_id) {
        $this->startTransaction();

        // 1. initialize params
        $node = $this->tree_model->getUserLeftRightNode($user_id, 'sponsor_tree');
        $node_left = $node['left'];
        $node_right = $node['right'];
        $subtree_size = $node_right - $node_left + 1;
        $parent = $this->tree_model->getUserLeftRightNode($new_sponsor_id, 'sponsor_tree');
        $parent_right = $parent['right'];

        // 2. temporarily remove moving node
        $this->db->set('left_sponsor', "0 - left_sponsor", FALSE);
        $this->db->set('right_sponsor', "0 - right_sponsor", FALSE);
        $this->db->where('left_sponsor >=', $node_left);
        $this->db->where('right_sponsor <=', $node_right);
        $this->db->update('tree_parser');

        // 3. decrease left right values of current nodes
        $this->db->set('left_sponsor', "left_sponsor - $subtree_size", FALSE);
        $this->db->where('left_sponsor >', $node_right);
        $this->db->update('tree_parser');

        $this->db->set('right_sponsor', "right_sponsor - $subtree_size", FALSE);
        $this->db->where('right_sponsor >', $node_right);
        $this->db->update('tree_parser');

        // 4. increase left right values of current nodes
        $current_node_check = ($parent_right > $node_right) ? ($parent_right - $subtree_size) : ($parent_right);

        $this->db->set('left_sponsor', "left_sponsor + $subtree_size", FALSE);
        $this->db->where('left_sponsor >=', $current_node_check);
        $this->db->update('tree_parser');

        $this->db->set('right_sponsor', "right_sponsor + $subtree_size", FALSE);
        $this->db->where('right_sponsor >=', $current_node_check);
        $this->db->update('tree_parser');

        // 5. add removed node
        $new_node_value = ($parent_right > $node_right) ? ($parent_right - $node_right - 1) : ($parent_right - $node_right - 1 + $subtree_size);

        $this->db->set('left_sponsor', "0 - left_sponsor + $new_node_value", FALSE);
        $this->db->set('right_sponsor', "0 - right_sponsor + $new_node_value", FALSE);
        $this->db->where('left_sponsor <=', 0 - $node_left);
        $this->db->where('right_sponsor >=', 0 - $node_right);
        $this->db->update('tree_parser');

        // 6. update parent and level
        $this->changeSponsorId($user_id, $new_sponsor_id);

        $this->updateSubtreeLevel($user_id, $new_sponsor_id, 'sponsor_tree');

        $this->finishTransaction();
        return $this->isTransactionSuccess();
    }

    public function updateSubtreeLevel($user_id, $parent_id, $tree_type = 'tree') {
        $user_left_right = $this->tree_model->getUserLeftRightNode($user_id, $tree_type);
        $user_level = $this->validation_model->getUserTreeLevel($user_id, $tree_type);
        $parent_level = $this->validation_model->getUserTreeLevel($parent_id, $tree_type);
        $level_diff = $parent_level - $user_level + 1;
        $db_prefix  = $this->db->dbprefix;

        if($tree_type == 'tree') {
            // $this->db->set('user_level', "user_level + $level_diff", FALSE);
            // $this->db->where('left_father >=', $user_left_right['left']);
            // $this->db->where('right_father <=', $user_left_right['right']);
            $this->db->query("UPDATE `{$db_prefix}ft_individual` Join `{$db_prefix}tree_parser` on `{$db_prefix}ft_individual`.id = `{$db_prefix}tree_parser`.ft_id  SET `{$db_prefix}ft_individual`.user_level = `{$db_prefix}ft_individual`.user_level + {$level_diff}  WHERE `{$db_prefix}tree_parser`.left_father >= {$user_left_right['left']} AND `{$db_prefix}tree_parser`.right_father <= {$user_left_right['right']};");
        }
        elseif($tree_type == 'sponsor_tree') {
            // $this->db->set('sponsor_level', "sponsor_level + $level_diff", FALSE);
            // $this->db->where('left_sponsor >=', $user_left_right['left']);
            // $this->db->where('right_sponsor <=', $user_left_right['right']);
            $this->db->query("UPDATE `{$db_prefix}ft_individual` Join `{$db_prefix}tree_parser` on `{$db_prefix}ft_individual`.id = `{$db_prefix}tree_parser`.ft_id  SET `{$db_prefix}ft_individual`.sponsor_level = `{$db_prefix}ft_individual`.sponsor_level + {$level_diff}  WHERE `{$db_prefix}tree_parser`.left_sponsor >= {$user_left_right['left']} AND `{$db_prefix}tree_parser`.right_sponsor <= {$user_left_right['right']};");
        }
    }

    public function changeSponsorId($user_id, $new_sponsor_id) {
        $old_sponsor_id = $this->validation_model->getSponsorId($user_id);

        $this->db->set('sponsor_id', $new_sponsor_id);
        $this->db->where('id', $user_id);
        $this->db->update('ft_individual');

        $this->db->set('user_id', $user_id);
        $this->db->set('old_sponsor_id', $old_sponsor_id);
        $this->db->set('new_sponsor_id', $new_sponsor_id);
        $this->db->insert('sponsor_change_history');
    }

    public function changePlacementId($user_id, $new_placement_id, $new_position, $old_placement_id, $old_position) {
        $this->db->set('father_id', $new_placement_id);
        $this->db->set('position', $new_position);
        $this->db->where('id', $user_id);
        $this->db->update('ft_individual');

        $this->db->set('user_id', $user_id);
        $this->db->set('old_placement_id', $old_placement_id);
        $this->db->set('new_placement_id', $new_placement_id);
        $this->db->set('old_position', $old_position);
        $this->db->set('new_position', $new_position);
        $this->db->insert('placement_change_history');
    }

    public function isPositionAvailable($placement_id, $position, $mlm_plan) {
        if($mlm_plan == 'Binary') {
            $this->db->where('father_id', $placement_id);
            $this->db->where('position', $position);
            $count = $this->db->count_all_results('ft_individual');
            return !$count;
        }
        elseif($mlm_plan == 'Matrix') {
            $width_ceiling = $this->validation_model->getWidthCieling();

            $this->db->where('father_id', $placement_id);
            $count = $this->db->count_all_results('ft_individual');
            return ($count < $width_ceiling);
        }
        else {
            return TRUE;
        }
    }

    public function changePlacement($user_id, $new_placement_id, $current_placement_id, $mlm_plan, $new_position, $current_position) {
        $this->startTransaction();

        $this->load->model('registersubmit_model');

        // 1. initialize params
        $node = $this->tree_model->getUserLeftRightNode($user_id);
        $node_left = $node['left'];
        $node_right = $node['right'];
        $subtree_size = $node_right - $node_left + 1;
        $parent = $this->tree_model->getUserLeftRightNode($new_placement_id);
        $parent_right = $parent['right'];

        // 2. temporarily remove moving node
        $this->db->set('left_father', "0 - left_father", FALSE);
        $this->db->set('right_father', "0 - right_father", FALSE);
        $this->db->where('left_father >=', $node_left);
        $this->db->where('right_father <=', $node_right);
        $this->db->update('tree_parser');

        // 3. decrease left right values of current nodes
        $this->db->set('left_father', "left_father - $subtree_size", FALSE);
        $this->db->where('left_father >', $node_right);
        $this->db->update('tree_parser');

        $this->db->set('right_father', "right_father - $subtree_size", FALSE);
        $this->db->where('right_father >', $node_right);
        $this->db->update('tree_parser');

        // 4. increase left right values of current nodes
        $current_node_check = ($parent_right > $node_right) ? ($parent_right - $subtree_size) : ($parent_right);

        $this->db->set('left_father', "left_father + $subtree_size", FALSE);
        $this->db->where('left_father >=', $current_node_check);
        $this->db->update('tree_parser');

        $this->db->set('right_father', "right_father + $subtree_size", FALSE);
        $this->db->where('right_father >=', $current_node_check);
        $this->db->update('tree_parser');

        // 5. add removed node
        $new_node_value = ($parent_right > $node_right) ? ($parent_right - $node_right - 1) : ($parent_right - $node_right - 1 + $subtree_size);

        $this->db->set('left_father', "0 - left_father + $new_node_value", FALSE);
        $this->db->set('right_father', "0 - right_father + $new_node_value", FALSE);
        $this->db->where('left_father <=', 0 - $node_left);
        $this->db->where('right_father >=', 0 - $node_right);
        $this->db->update('tree_parser');

        // 6. update parent and level
        $this->changePlacementId($user_id, $new_placement_id, $new_position, $current_placement_id, $current_position);

        $this->updateSubtreeLevel($user_id, $new_placement_id);

        $this->finishTransaction();
        return $this->isTransactionSuccess();
    }

}
