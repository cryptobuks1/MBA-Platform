<?php
class ControllerStartupStartup extends Controller {
	public function index() {
		// Store
		if ($this->request->server['HTTPS']) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "store WHERE REPLACE(`ssl`, 'www.', '') = '" . $this->db->escape('https://' . str_replace('www.', '', $_SERVER['HTTP_HOST']) . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/') . "'");
		} else {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "store WHERE REPLACE(`url`, 'www.', '') = '" . $this->db->escape('http://' . str_replace('www.', '', $_SERVER['HTTP_HOST']) . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/') . "'");
		}
		
		if (isset($this->request->get['store_id'])) {
			$this->config->set('config_store_id', (int)$this->request->get['store_id']);
		} else if ($query->num_rows) {
			$this->config->set('config_store_id', $query->row['store_id']);
		} else {
			$this->config->set('config_store_id', 0);
		}
		
		if (!$query->num_rows) {
			$this->config->set('config_url', HTTP_SERVER);
			$this->config->set('config_ssl', HTTPS_SERVER);
		}
		
		// Settings
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE store_id = '0' OR store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY store_id ASC");
		
		foreach ($query->rows as $result) {
			if (!$result['serialized']) {
				$this->config->set($result['key'], $result['value']);
			} else {
				$this->config->set($result['key'], json_decode($result['value'], true));
			}
		}

		// Url
		$this->registry->set('url', new Url($this->config->get('config_url'), $this->config->get('config_ssl')));
		
		// Language
		$code = '';
		
		$this->load->model('localisation/language');
		
		$languages = $this->model_localisation_language->getLanguages();
		
		if (isset($this->session->data['language'])) {
			$code = $this->session->data['language'];
		}
				
		if (isset($this->request->cookie['language']) && !array_key_exists($code, $languages)) {
			$code = $this->request->cookie['language'];
		}
		
		// Language Detection
		if (!empty($this->request->server['HTTP_ACCEPT_LANGUAGE']) && !array_key_exists($code, $languages)) {
			$detect = '';
			
			$browser_languages = explode(',', $this->request->server['HTTP_ACCEPT_LANGUAGE']);
			
			// Try using local to detect the language
			foreach ($browser_languages as $browser_language) {
				foreach ($languages as $key => $value) {
					if ($value['status']) {
						$locale = explode(',', $value['locale']);
						
						if (in_array($browser_language, $locale)) {
							$detect = $key;
							break 2;
						}
					}
				}	
			}			
			
			if (!$detect) { 
				// Try using language folder to detect the language
				foreach ($browser_languages as $browser_language) {
					if (array_key_exists(strtolower($browser_language), $languages)) {
						$detect = strtolower($browser_language);
						
						break;
					}
				}
			}
			
			$code = $detect ? $detect : '';
		}
		
		if (!array_key_exists($code, $languages)) {
			$code = $this->config->get('config_language');
		}
		
		if (!isset($this->session->data['language']) || $this->session->data['language'] != $code) {
			$this->session->data['language'] = $code;
		}
				
		if (!isset($this->request->cookie['language']) || $this->request->cookie['language'] != $code) {
			setcookie('language', $code, time() + 60 * 60 * 24 * 30, '/', $this->request->server['HTTP_HOST']);
		}
				
		// Overwrite the default language object
		$language = new Language($code);
		$language->load($code);
		
		$this->registry->set('language', $language);
		
		// Set the config language_id
		$this->config->set('config_language_id', $languages[$code]['language_id']);	

		// Customer
		$customer = new Cart\Customer($this->registry);
		$this->registry->set('customer', $customer);
		
		// Customer Group
		if ($this->customer->isLogged()) {
			$this->config->set('config_customer_group_id', $this->customer->getGroupId());
		} elseif (isset($this->session->data['customer']) && isset($this->session->data['customer']['customer_group_id'])) {
			// For API calls
			$this->config->set('config_customer_group_id', $this->session->data['customer']['customer_group_id']);
		} elseif (isset($this->session->data['guest']) && isset($this->session->data['guest']['customer_group_id'])) {
			$this->config->set('config_customer_group_id', $this->session->data['guest']['customer_group_id']);
		}
		
		// Tracking Code

                
                    
                    if (!$this->customer->isLogged() && isset($_COOKIE['ci_session']) && (!isset($this->request->get['route']) || $this->request->get['route'] != 'account/logout')) {
                        $this->customer->loginFromMLM();
                    }
                
            
		if (isset($this->request->get['tracking'])) {
			setcookie('tracking', $this->request->get['tracking'], time() + 3600 * 24 * 1000, '/');
		
			$this->db->query("UPDATE `" . DB_PREFIX . "marketing` SET clicks = (clicks + 1) WHERE code = '" . $this->db->escape($this->request->get['tracking']) . "'");
		}		
		
		// Affiliate
		$this->registry->set('affiliate', new Cart\Affiliate($this->registry));
		
		// Currency
		$code = '';
		
		$this->load->model('localisation/currency');
		
		$currencies = $this->model_localisation_currency->getCurrencies();
		
		if (isset($this->session->data['currency'])) {
			$code = $this->session->data['currency'];
		}
		
		if (isset($this->request->cookie['currency']) && !array_key_exists($code, $currencies)) {
			$code = $this->request->cookie['currency'];
		}
		
		if (!array_key_exists($code, $currencies)) {
			$code = $this->config->get('config_currency');
		}
		
		if (!isset($this->session->data['currency']) || $this->session->data['currency'] != $code) {
			$this->session->data['currency'] = $code;
		}
		
		if (!isset($this->request->cookie['currency']) || $this->request->cookie['currency'] != $code) {
			setcookie('currency', $code, time() + 60 * 60 * 24 * 30, '/', $this->request->server['HTTP_HOST']);
		}		
		
		$this->registry->set('currency', new Cart\Currency($this->registry));
		
		// Tax
		$this->registry->set('tax', new Cart\Tax($this->registry));
		
		if (isset($this->session->data['shipping_address'])) {
			$this->tax->setShippingAddress($this->session->data['shipping_address']['country_id'], $this->session->data['shipping_address']['zone_id']);
		} elseif ($this->config->get('config_tax_default') == 'shipping') {
			$this->tax->setShippingAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));
		}

		if (isset($this->session->data['payment_address'])) {
			$this->tax->setPaymentAddress($this->session->data['payment_address']['country_id'], $this->session->data['payment_address']['zone_id']);
		} elseif ($this->config->get('config_tax_default') == 'payment') {
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
                                if ($this->customer->isLogged()) {
                                    $this->customer->logout();
                                }
                                echo "<script>alert('Your demo has been blocked.');</script>";
                                echo "<script>window.location = '" . ROOT_URL . "';</script>";
                            }
                        }
                    }
                    
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

                    define('BLOCK_ECOMMERCE', $block_ecommerce);
                    define('BLOCK_REGISTER', $block_register);
                    define('MLM_PLAN', $MLM_PLAN);
                    define('ADMIN_USER_ID', $ADMIN_USER_ID);
                    define('ADMIN_USER_NAME', $ADMIN_USER_NAME);
                    define('USERNAME_TYPE', isset($USERNAME_CONFIG['user_name_type']) ? $USERNAME_CONFIG['user_name_type'] : "");

                    $this->session->data['inf_site_information'] = $site_information;
                    $this->session->data['inf_module_status'] = $MODULE_STATUS;

                    if ($this->customer->getUserType() != 'admin' && !$maintenance_data['status'] && $maintenance_data['block_login'] && $this->request->get['route'] != 'account/logout') {
                        if ($this->customer->isLogged()) {
                            if (is_ajax_request()) {
                                if (in_array($this->request->get['route'], array('extension/regpayment/bank_transfer/confirm', extension/regpayment/cod/confirm))) {
                                    echo $this->url->link('account/logout', '', true);
                                }
                                else {
                                    echo json_encode(array('redirect' => $this->url->link('account/logout', '', true)));
                                }
                                exit();
                            }
                            else {
                                $this->response->redirect($this->url->link('account/logout', '', true));
                            }
                        }
                    }
                    if ($this->customer->getUserType() != 'admin' && !$maintenance_data['status'] && $maintenance_data['block_ecommerce']) {
                        if (strpos($this->request->get['route'], 'checkout') === 0 && strpos($this->request->get['route'], 'checkout/cart') === false) {
                            $this->session->data['error_redirect'] = $this->language->get('error_repurchase_blocked');
                            if (is_ajax_request()) {
                                echo json_encode(array('redirect' => $this->url->link('common/home')));
                                exit();
                            }
                            else {
                                $this->response->redirect($this->url->link('common/home'));
                            }
                        }
                        if (strpos($this->request->get['route'], 'extension/payment') === 0) {
                            $this->session->data['error_redirect'] = $this->language->get('error_repurchase_blocked');
                            if (is_ajax_request()) {
                                echo json_encode(array('redirect' => $this->url->link('common/home')));
                                exit();
                            }
                            else {
                                $this->response->redirect($this->url->link('common/home'));
                            }
                        }
                    }
                
            
	}
}
