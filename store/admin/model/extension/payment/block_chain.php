<?php
class ModelExtensionPaymentBlockChain extends Model {

	public function install() {
		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "block_chain_order` (
				`block_chain_order_id` INT(11) NOT NULL AUTO_INCREMENT,
				`order_id` int(11) NOT NULL,
				`amazon_order_reference_id` varchar(255) NOT NULL,
				`amazon_authorization_id` varchar(255) NOT NULL,
				`free_shipping`  tinyint NOT NULL DEFAULT 0,
				`date_added` DATETIME NOT NULL,
				`modified` DATETIME NOT NULL,
				`capture_status` INT(1) DEFAULT NULL,
				`cancel_status` INT(1) DEFAULT NULL,
				`refund_status` INT(1) DEFAULT NULL,
				`currency_code` CHAR(3) NOT NULL,
				`total` DECIMAL( 10, 2 ) NOT NULL,
				KEY `amazon_order_reference_id` (`amazon_order_reference_id`),
				PRIMARY KEY `amazon_login_pay_order_id` (`amazon_login_pay_order_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
		");
	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "block_chain_order`;");
	}
}
