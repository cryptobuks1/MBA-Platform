<?php
class ModelExtensionTotalBackofficeFee extends Model {
	public function getTotal($total) { 
		$this->load->language('extension/total/sub_total');
                $this->load->model('checkout/order');
		 if(isset($this->session->data['inf_reg_data']['reg_type'])){
                if($this->session->data['inf_reg_data']['reg_type']=='business'){ 
                    $reg_amount = $this->model_checkout_order->getRegAmount();
                    
                }
             }else{
                 $reg_amount=0;
             }

		
		$total['totals'][] = array(
			'code'       => 'backoffice_fee',
			'title'      => 'Backoffice-Fee',
			'value'      => $reg_amount,
			'sort_order' => 7
		);

		$total['total'] += $reg_amount;
	}
}
