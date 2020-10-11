<?php

class table_model extends inf_model {

    public function __construct() {
        parent::__construct();
        $this->load->model('calculation_model');
        $this->load->model('validation_model');
    }

    public function getPlacementAndPosition($placement_id) {
        
        $placement_array = [];
        $this->db->where('father_id', $placement_id);
        $count = $this->db->count_all_results('ft_individual');
        $position = $count + 1;
        $placement_array['id'] = $placement_id;
        $placement_array['position'] = $position;
        return $placement_array;
    }
    
    public function addBySpecificPlan() { 
       
        return TRUE; 
    }

    public function runCalculation($action, $user_id, $product_id, $product_pv, $product_amount, $oc_order_id, $upline_id, $quantity, $position, $data) {  
        
        $sponsor_commission_status = $this->validation_model->getCompensationConfig(['sponsor_commission_status']);

        if ($sponsor_commission_status == 'yes') {
            $this->calculation_model->calculateLevelCommission($action, $user_id, $data['sponsor_id'], $product_id, $product_pv, $product_amount, $oc_order_id, $quantity);
        }

        $this->calculation_model->updatePersonalPV($user_id, $product_pv);
        $this->calculation_model->updateGroupPV($data['sponsor_id'], $product_pv);

        $this->calculation_model->calculatePerformanceBonus($user_id, $product_pv);
        
        return TRUE;
      }
}
