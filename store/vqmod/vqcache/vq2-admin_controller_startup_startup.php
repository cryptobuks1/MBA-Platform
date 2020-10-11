<?php
class ControllerStartupStartup extends Controller {
	public function index() {
		// Settings
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '0'");
		
		foreach ($query->rows as $setting) {
			if (!$setting['serialized']) {
				$this->config->set($setting['key'], $setting['value']);
			} else {
				$this->config->set($setting['key'], json_decode($setting['value'], true));
			}
		}
		
		// Language
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "language` WHERE code = '" . $this->db->escape($this->config->get('config_admin_language')) . "'");
		
		if ($query->num_rows) {
			$this->config->set('config_language_id', $query->row['language_id']);
		}
		
		// Language
		$language = new Language($this->config->get('config_admin_language'));
		$language->load($this->config->get('config_admin_language'));
		$this->registry->set('language', $language);
		
		// Customer
		$this->registry->set('customer', new Cart\Customer($this->registry));
		
		// Affiliate
		$this->registry->set('affiliate', new Cart\Affiliate($this->registry));

		// Currency
		$this->registry->set('currency', new Cart\Currency($this->registry));
	
		// Tax
		$this->registry->set('tax', new Cart\Tax($this->registry));
		
		if ($this->config->get('config_tax_default') == 'shipping') {
			$this->tax->setShippingAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));
		}

		if ($this->config->get('config_tax_default') == 'payment') {
			$this->tax->setPaymentAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));
		}

		$this->tax->setStoreAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));

		// Weight
		$this->registry->set('weight', new Cart\Weight($this->registry));
		
		// Length
		$this->registry->set('length', new Cart\Length($this->registry));
		
		// Cart
		$this->registry->set('cart', new Cart\Cart($this->registry));
		
		// Encryption
		$this->registry->set('encryption', new Encryption($this->config->get('config_encryption')));
		
		// OpenBay Pro
		$this->registry->set('openbay', new Openbay($this->registry));					

                
                    // Check whether opencart store enabled in MLM demo or not
                    $table_query = $this->db->query("SELECT count(*) AS table_count FROM information_schema.TABLES WHERE (TABLE_SCHEMA = '" . DB_DATABASE . "') AND (TABLE_NAME = '" . MLM_DB_PREFIX . "module_status')");
                    if ($table_query->num_rows) {
                        $table_count = $table_query->row['table_count'];
                        if ($table_count) {
                            $opencart_status_query = $this->db->query("SELECT opencart_status, opencart_status_demo FROM " . MLM_DB_PREFIX . "module_status WHERE id = 1");
                            foreach ($opencart_status_query->rows as $result) {
                                if (!($result['opencart_status_demo'] == "yes" && $result['opencart_status'] == "yes")) {
                                    echo "<script>alert('Store is not enabled in your demo');</script>";
                                    echo "<script>window.location = '" . ROOT_URL . "';</script>";
                                }
                            }
                        } else {
                            echo "<script>alert('Invalid Demo URL');</script>";
                            echo "<script>window.location = '" . ROOT_URL . "';</script>";
                        }
                    } else {
                        echo "<script>alert('Invalid Demo URL');</script>";
                        echo "<script>window.location = '" . ROOT_URL . "';</script>";
                    }
                    
                    if(DEMO_STATUS == 'yes') {
                        // Check whether demo blocked or not
                        $query = $this->db->query("SELECT account_status FROM " . MLM_DB_PREFIX . "project_info LIMIT 1");
                        if ($query->num_rows) {
                            $account_status = $query->row['account_status'];
                            if($account_status == 'blocked') {
                                echo "<script>alert('Your demo has been blocked.');</script>";
                                echo "<script>window.location = '" . ROOT_URL . "';</script>";
                            }
                        }
                    }
                    
                    $customer = $this->registry->get('customer');
                    
                    // Configure MLM data
                    $MLM_PLAN = $customer->getMLMPlan();
                    $MODULE_STATUS = $customer->getModuleStatus();
                    $USERNAME_CONFIG = $customer->getUsernameConfig();
                    $site_information = $customer->getSiteInformation();
                    $ADMIN_USER_ID = $customer->getAdminUserId();
                    $ADMIN_USER_NAME = $customer->idToUserName($ADMIN_USER_ID);
                    $maintenance_data = $customer->getMaintanenceData();
                    $block_ecommerce = $maintenance_data['block_ecommerce'];
                    $block_register = $maintenance_data['block_register'];

                    define('MLM_PLAN', $MLM_PLAN);
                    define('ADMIN_USER_ID', $ADMIN_USER_ID);
                    define('ADMIN_USER_NAME', $ADMIN_USER_NAME);
                    define('USERNAME_TYPE', isset($USERNAME_CONFIG['user_name_type']) ? $USERNAME_CONFIG['user_name_type'] : "");

                    $this->session->data['inf_site_information'] = $site_information;
                    $this->session->data['inf_module_status'] = $MODULE_STATUS;
                    define('referral_status', $MODULE_STATUS['referal_status']);
                
            
	}
}