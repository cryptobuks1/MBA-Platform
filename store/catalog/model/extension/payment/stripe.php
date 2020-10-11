<?php
class ModelExtensionPaymentStripe extends Model {
	public function getMethod($address, $total) {
		$this->load->language('extension/payment/stripe');

		$status = true;

		// stripe does not allow payment for 0 amount
		if($total <= 0) {
			$status = false; 
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'stripe',
				'title'      => $this->language->get('text_title'),
				'terms'      => '',
				'sort_order' => $this->config->get('stripe_sort_order')
			);
		}

		return $method_data;
	}

	public function log($file, $line, $caption, $message){

		if(!$this->config->get('payment_stripe_debug')){
			return;
		}

		$iso_time = date('c');
		$filename = 'stripe-'.strstr($iso_time, 'T', true).'.log';
	
		$log = new Log($filename);
		$msg = "[" . $iso_time . "] ";
		$msg .= "<" . $file . "> ";
		$msg .= "#" . $line . "# ";
		$msg .= "~" . $caption . "~ ";

		if(is_array($message)){
			$msg .= print_r($message, true);
		} else {
			$msg .= PHP_EOL . $message;
		}

		$msg .= PHP_EOL . PHP_EOL;		
		$log->write($msg);
	}
		public function addOrder($order_data) {
		/**
		 * 1 to 1 relationship with order table (extends order info)
		 */

		$this->db->query("INSERT INTO `" . MLM_DB_PREFIX . "stripe_order` SET
			`order_id` = '" . (int)$order_data['order_id'] . "',
			`date_added` = NOW(),
			`date_modified` = NOW(),
			`capture_status` = '" . $this->db->escape($order_data['capture_status']) . "',
			`currency_code` = '" . $this->db->escape($order_data['currency_code']) . "',
			`total` = '" . (float)$order_data['total'] . "',
			`authorization_id` = '" . $this->db->escape($order_data['authorization_id']) . "'");

		return $this->db->getLastId();
	}

	public function addTransaction($transaction_data) {
		/**
		 * 1 to many relationship with paypal order table, many transactions per 1 order
		 */

		$this->db->query("INSERT INTO `" . MLM_DB_PREFIX . "stripe_order_transaction` SET
			`stripe_order_id` = '" . (int)$transaction_data['stripe_order_id'] . "',
			`transaction_id` = '" . $this->db->escape($transaction_data['transaction_id']) . "',
			`cancell_reason` = '" . $this->db->escape($transaction_data['cancell_reason']) . "',
			`payment_type` = '" . $this->db->escape($transaction_data['payment_type']) . "',
			`payment_status` = '" . $this->db->escape($transaction_data['payment_status']) . "',
			`transaction_entity` = '" . $this->db->escape($transaction_data['transaction_entity']) . "',
			`amount` = '" . (float)$transaction_data['amount'] . "',
			`debug_data` = '" . $this->db->escape($transaction_data['debug_data']) . "'");
	}
}
