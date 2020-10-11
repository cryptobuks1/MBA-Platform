<?php
namespace Cart;
class Customer {
	private $customer_id;
	private $firstname;
	private $lastname;
	private $customer_group_id;
	private $email;
	private $telephone;
	private $fax;
	private $newsletter;
	private $address_id;

                
                    private $user_id;
                    private $user_name;
                    private $user_type;
                    private $admin_user_id;
                    private $admin_user_name;
                
            

	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');

		if (isset($this->session->data['customer_id'])) {
			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$this->session->data['customer_id'] . "' AND status = '1'");

			if ($customer_query->num_rows) {
				$this->customer_id = $customer_query->row['customer_id'];
				$this->firstname = $customer_query->row['firstname'];
				$this->lastname = $customer_query->row['lastname'];
				$this->customer_group_id = $customer_query->row['customer_group_id'];
				$this->email = $customer_query->row['email'];
				$this->telephone = $customer_query->row['telephone'];
				$this->fax = $customer_query->row['fax'];
				$this->newsletter = $customer_query->row['newsletter'];
				$this->address_id = $customer_query->row['address_id'];


                
                    $ADMIN_USER_ID = $this->getAdminUserId();
                    $ADMIN_USER_NAME = $this->idToUserName($ADMIN_USER_ID);
                    $this->admin_user_id =  $ADMIN_USER_ID;
                    $this->admin_user_name =  $ADMIN_USER_NAME;
                    if (isset($this->session->data['inf_logged_in'])) {
                        $this->user_id =  $this->session->data['inf_logged_in']['user_id'];
                        $this->user_name =  $this->session->data['inf_logged_in']['user_name'];
                        $this->user_type = $this->session->data['inf_logged_in']["user_type"];
                    } else {
                        $customer_login_query = $this->db->query("SELECT id,user_name,user_type FROM " . MLM_DB_PREFIX . "ft_individual WHERE oc_customer_ref_id = '" . (int) $customer_query->row['customer_id'] . "'");
                        if ($customer_login_query->num_rows) {
                            $this->session->data['inf_logged_in']["admin_user_id"] = $ADMIN_USER_ID;
                            $this->session->data['inf_logged_in']["admin_user_name"] = $ADMIN_USER_NAME;
                            $this->session->data['inf_logged_in']["user_id"] = $customer_login_query->row["id"];
                            $this->session->data['inf_logged_in']["user_name"] = $customer_login_query->row["user_name"];
                            $this->session->data['inf_logged_in']["user_type"] = $customer_login_query->row["user_type"];
                            $this->session->data['inf_logged_in']["table_prefix"] = MLM_DB_PREFIX;
                            $this->session->data['inf_logged_in']["is_logged_in"] = true;
                            $this->session->data['inf_logged_in']["mlm_plan"] = $this->getMLMPlan();
                            $this->user_id =  $customer_login_query->row["id"];
                            $this->user_name =  $customer_login_query->row["user_name"];
                            $this->user_type = $customer_login_query->row["user_type"];
                        } else {
                            $this->logout();
                        }

                
                    $ADMIN_USER_ID = $this->getAdminUserId();
                    $ADMIN_USER_NAME = $this->idToUserName($ADMIN_USER_ID);
                    $this->admin_user_id =  $ADMIN_USER_ID;
                    $this->admin_user_name =  $ADMIN_USER_NAME;

                if (isset($this->session->data['inf_logged_in'])) {
                    $this->user_id =  $this->session->data['inf_logged_in']['user_id'];
                    $this->user_name =  $this->session->data['inf_logged_in']['user_name'];
                    $this->user_type = $this->session->data['inf_logged_in']["user_type"];
                    } else {
                        $customer_login_query = $this->db->query("SELECT id,user_name,user_type FROM " . MLM_DB_PREFIX . "ft_individual WHERE oc_customer_ref_id = '" . (int) $customer_query->row['customer_id'] . "'");
                        if ($customer_login_query->num_rows) {
                            $this->session->data['inf_logged_in']["admin_user_id"] = $ADMIN_USER_ID;
                            $this->session->data['inf_logged_in']["admin_user_name"] = $ADMIN_USER_NAME;
                            $this->session->data['inf_logged_in']["user_id"] = $customer_login_query->row["id"];
                            $this->session->data['inf_logged_in']["user_name"] = $customer_login_query->row["user_name"];
                            $this->session->data['inf_logged_in']["user_type"] = $customer_login_query->row["user_type"];
                            $this->session->data['inf_logged_in']["table_prefix"] = MLM_DB_PREFIX;
                            $this->session->data['inf_logged_in']["is_logged_in"] = true;
                            $this->session->data['inf_logged_in']["mlm_plan"] = $this->getMLMPlan();
                            $this->user_id =  $customer_login_query->row["id"];
                            $this->user_name =  $customer_login_query->row["user_name"];
                            $this->user_type = $customer_login_query->row["user_type"];
                        } else {
                            $this->logout();
                        }
                    }
                
            
                    }
                
            
				$this->db->query("UPDATE " . DB_PREFIX . "customer SET language_id = '" . (int)$this->config->get('config_language_id') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");

				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_ip WHERE customer_id = '" . (int)$this->session->data['customer_id'] . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");

				if (!$query->num_rows) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "customer_ip SET customer_id = '" . (int)$this->session->data['customer_id'] . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', date_added = NOW()");
				}
			} else {
				$this->logout();
			}

                
                    $ADMIN_USER_ID = $this->getAdminUserId();
                    $ADMIN_USER_NAME = $this->idToUserName($ADMIN_USER_ID);
                    $this->admin_user_id =  $ADMIN_USER_ID;
                    $this->admin_user_name =  $ADMIN_USER_NAME;

                if (isset($this->session->data['inf_logged_in'])) {
                    $this->user_id =  $this->session->data['inf_logged_in']['user_id'];
                    $this->user_name =  $this->session->data['inf_logged_in']['user_name'];
                    $this->user_type = $this->session->data['inf_logged_in']["user_type"];
                    } else {
                        $customer_login_query = $this->db->query("SELECT id,user_name,user_type FROM " . MLM_DB_PREFIX . "ft_individual WHERE oc_customer_ref_id = '" . (int) $customer_query->row['customer_id'] . "'");
                        if ($customer_login_query->num_rows) {
                            $this->session->data['inf_logged_in']["admin_user_id"] = $ADMIN_USER_ID;
                            $this->session->data['inf_logged_in']["admin_user_name"] = $ADMIN_USER_NAME;
                            $this->session->data['inf_logged_in']["user_id"] = $customer_login_query->row["id"];
                            $this->session->data['inf_logged_in']["user_name"] = $customer_login_query->row["user_name"];
                            $this->session->data['inf_logged_in']["user_type"] = $customer_login_query->row["user_type"];
                            $this->session->data['inf_logged_in']["table_prefix"] = MLM_DB_PREFIX;
                            $this->session->data['inf_logged_in']["is_logged_in"] = true;
                            $this->session->data['inf_logged_in']["mlm_plan"] = $this->getMLMPlan();
                            $this->user_id =  $customer_login_query->row["id"];
                            $this->user_name =  $customer_login_query->row["user_name"];
                            $this->user_type = $customer_login_query->row["user_type"];
                        } else {
                            $this->logout();
                        }
                    }
                
            
		}
	}

	public function login($email, $password, $override = false) {
		if ($override) {
			
                
                    $customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer AS cust INNER JOIN " . MLM_DB_PREFIX . "ft_individual AS ft ON cust.customer_id = ft.oc_customer_ref_id WHERE (LOWER(cust.email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND cust.status = '1') OR (LOWER(ft.user_name) = '" . $this->db->escape(utf8_strtolower($email)) . "')");
                
            
		} else {
			
                
                    $customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer AS cust INNER JOIN " . MLM_DB_PREFIX . "ft_individual AS ft ON cust.customer_id = ft.oc_customer_ref_id  WHERE (LOWER(ft.user_name) = '" . $this->db->escape(utf8_strtolower($email)) . "' OR LOWER(cust.email) = '" . $this->db->escape(utf8_strtolower($email)) . "') AND (cust.password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR cust.password = '" . $this->db->escape(md5($password)) . "') AND cust.status = '1' AND cust.approved = '1'");
                
            
		}

		if ($customer_query->num_rows) {
			$this->session->data['customer_id'] = $customer_query->row['customer_id'];

			$this->customer_id = $customer_query->row['customer_id'];
			$this->firstname = $customer_query->row['firstname'];
			$this->lastname = $customer_query->row['lastname'];
			$this->customer_group_id = $customer_query->row['customer_group_id'];
			$this->email = $customer_query->row['email'];
			$this->telephone = $customer_query->row['telephone'];
			$this->fax = $customer_query->row['fax'];
			$this->newsletter = $customer_query->row['newsletter'];
			$this->address_id = $customer_query->row['address_id'];


                
                    $ADMIN_USER_ID = $this->getAdminUserId();
                    $ADMIN_USER_NAME = $this->idToUserName($ADMIN_USER_ID);
                    $this->admin_user_id =  $ADMIN_USER_ID;
                    $this->admin_user_name =  $ADMIN_USER_NAME;
                    if (isset($this->session->data['inf_logged_in'])) {
                        $this->user_id =  $this->session->data['inf_logged_in']['user_id'];
                        $this->user_name =  $this->session->data['inf_logged_in']['user_name'];
                        $this->user_type = $this->session->data['inf_logged_in']["user_type"];
                    } else {
                        $customer_login_query = $this->db->query("SELECT id,user_name,user_type FROM " . MLM_DB_PREFIX . "ft_individual WHERE oc_customer_ref_id = '" . (int) $customer_query->row['customer_id'] . "'");
                        if ($customer_login_query->num_rows) {
                            $this->session->data['inf_logged_in']["admin_user_id"] = $ADMIN_USER_ID;
                            $this->session->data['inf_logged_in']["admin_user_name"] = $ADMIN_USER_NAME;
                            $this->session->data['inf_logged_in']["user_id"] = $customer_login_query->row["id"];
                            $this->session->data['inf_logged_in']["user_name"] = $customer_login_query->row["user_name"];
                            $this->session->data['inf_logged_in']["user_type"] = $customer_login_query->row["user_type"];
                            $this->session->data['inf_logged_in']["table_prefix"] = MLM_DB_PREFIX;
                            $this->session->data['inf_logged_in']["is_logged_in"] = true;
                            $this->session->data['inf_logged_in']["mlm_plan"] = $this->getMLMPlan();
                            $this->user_id =  $customer_login_query->row["id"];
                            $this->user_name =  $customer_login_query->row["user_name"];
                            $this->user_type = $customer_login_query->row["user_type"];
                        } else {
                            $this->logout();
                        }

                
                    $ADMIN_USER_ID = $this->getAdminUserId();
                    $ADMIN_USER_NAME = $this->idToUserName($ADMIN_USER_ID);
                    $this->admin_user_id =  $ADMIN_USER_ID;
                    $this->admin_user_name =  $ADMIN_USER_NAME;

                if (isset($this->session->data['inf_logged_in'])) {
                    $this->user_id =  $this->session->data['inf_logged_in']['user_id'];
                    $this->user_name =  $this->session->data['inf_logged_in']['user_name'];
                    $this->user_type = $this->session->data['inf_logged_in']["user_type"];
                    } else {
                        $customer_login_query = $this->db->query("SELECT id,user_name,user_type FROM " . MLM_DB_PREFIX . "ft_individual WHERE oc_customer_ref_id = '" . (int) $customer_query->row['customer_id'] . "'");
                        if ($customer_login_query->num_rows) {
                            $this->session->data['inf_logged_in']["admin_user_id"] = $ADMIN_USER_ID;
                            $this->session->data['inf_logged_in']["admin_user_name"] = $ADMIN_USER_NAME;
                            $this->session->data['inf_logged_in']["user_id"] = $customer_login_query->row["id"];
                            $this->session->data['inf_logged_in']["user_name"] = $customer_login_query->row["user_name"];
                            $this->session->data['inf_logged_in']["user_type"] = $customer_login_query->row["user_type"];
                            $this->session->data['inf_logged_in']["table_prefix"] = MLM_DB_PREFIX;
                            $this->session->data['inf_logged_in']["is_logged_in"] = true;
                            $this->session->data['inf_logged_in']["mlm_plan"] = $this->getMLMPlan();
                            $this->user_id =  $customer_login_query->row["id"];
                            $this->user_name =  $customer_login_query->row["user_name"];
                            $this->user_type = $customer_login_query->row["user_type"];
                        } else {
                            $this->logout();
                        }
                    }
                
            
                    }
                
            
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET language_id = '" . (int)$this->config->get('config_language_id') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");

			return true;
		} else {
			return false;
		}
	}

	public function logout() {
		unset($this->session->data['customer_id']);

                
                    foreach($this->session->data as $key => $value) {
                        if (strpos($key, 'inf_') === 0)
                        {
                            unset($this->session->data[$key]);
                        }
                    }
                    $cisess_data = $this->getMlmSessionFromFile();
                    if(isset($cisess_data['inf_logged_in'])) {
                        $user_type = $this->getUserType();
                        unset($cisess_data['inf_logged_in']);
                        $cisess_data = encode_session_data($cisess_data);
                        $cisess_cookie = $_COOKIE['ci_session'];
                        if($user_type == "admin"){
                            $cisess_file = dirname(ROOT_DIR) .OFFICE_ADMIN. '/application/sessions/ci_session' . $cisess_cookie;
                        }else{
                            $cisess_file = dirname(ROOT_DIR) .OFFICE_USER. '/application/sessions/ci_session' . $cisess_cookie;
                        }
                        $handle = fopen($cisess_file, 'w');
                        flock($handle, LOCK_EX);
                        fwrite($handle, $cisess_data);
                        fflush($handle);
                        flock($handle, LOCK_UN);
                        fclose($handle);
                    }
                
            

		$this->customer_id = '';
		$this->firstname = '';
		$this->lastname = '';
		$this->customer_group_id = '';
		$this->email = '';
		$this->telephone = '';
		$this->fax = '';
		$this->newsletter = '';
		$this->address_id = '';
	}

	public function isLogged() {
		return $this->customer_id;
	}

	public function getId() {
		return $this->customer_id;
	}

	public function getFirstName() {
		return $this->firstname;
	}

	public function getLastName() {
		return $this->lastname;
	}

	public function getGroupId() {
		return $this->customer_group_id;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getTelephone() {
		return $this->telephone;
	}

	public function getFax() {
		return $this->fax;
	}

	public function getNewsletter() {
		return $this->newsletter;
	}

	public function getAddressId() {
		return $this->address_id;
	}

	public function getBalance() {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int)$this->customer_id . "'");

		return $query->row['total'];
	}


                
                    public function getSiteMaintenanceStatus() {
                        $query = $this->db->query("SELECT maintenance_status FROM (`" . MLM_DB_PREFIX."module_status`)");
                        if($query->num_rows){
                            $data =  $query->row['maintenance_status'];
                        }
                        return $data;
                    }

                    public function getMaintanenceData() {
                        $data = array();
                        $site_maintenance_status = $this->getSiteMaintenanceStatus();
                        if ($site_maintenance_status == 'no') {
                            $data['block_login'] = FALSE;
                            $data['block_register'] = FALSE;
                            $data['block_ecommerce'] = FALSE;
                            $data['status'] = FALSE;
                            return $data;
                        }
                        $query = $this->db->query("SELECT * FROM (`" . MLM_DB_PREFIX."site_maintenance`) WHERE `id` = '1'");
                        if($query->num_rows){
                            $data =  $query->row;
                        }
                        return $data;
                    }
                    public function getUserId() {
                        return $this->user_id;
                    }
                    public function getUserName() {
                        return $this->user_name;
                    }
                    public function getUserType() {
                        return $this->user_type;
                    }
                    public function getAdminUserId() {
                        $admin_user_id = NULL;
                        $admin_id_query = $this->db->query("SELECT id FROM " . MLM_DB_PREFIX . "ft_individual WHERE user_type=  'admin'");
                        if ($admin_id_query->num_rows) {
                           $admin_user_id = $admin_id_query->row['id'];
                        }
                        return $admin_user_id;
                    }
                    public function getAdminUserName() {
                        return $this->admin_user_name;
                    }
                    public function isMLMUserLogged() {
                        if(isset($this->session->data['inf_logged_in'])){
                            $user_id = $this->session->data['inf_logged_in']['user_id'];
                            $user_name = $this->session->data['inf_logged_in']['user_name'];
                            $password = '';
                            $override = true;
                            if (!isset($this->session->data['cart']) || !is_array($this->session->data['cart'])) {
                                $this->session->data['cart'] = array();
                            }
                            $this->login($user_name, $password, $override);
                        }
                    }
                    public function getMlmSession() {
                        $cisess_data = array();
                        if(isset($_COOKIE['ci_session'])) {
                            $cisess_cookie = $_COOKIE['ci_session'];
                            $cisess_table = (DEMO_STATUS == 'yes') ? "inf_ci_sessions" : MLM_DB_PREFIX . "ci_sessions";
                            $query = $this->db->query("SELECT data FROM `{$cisess_table}` WHERE id = '$cisess_cookie' LIMIT 1");
                            if ($query->num_rows > 0) {
                                $cisess_data = $query->row['data'];
                                $cisess_data = decode_session_data($cisess_data);
                            }
                        }
                        return $cisess_data;
                    }
                    public function getMlmSessionFromFile() {
                        $cisess_data = array();
                        if(isset($_COOKIE['ci_session'])) {
                            $cisess_cookie = $_COOKIE['ci_session'];
                            $cisess_file = dirname(ROOT_DIR) .OFFICE_USER. '/application/sessions/ci_session' . $cisess_cookie;
                            $cisess_data = $this->checkMlmfilexist($cisess_file);

                            if(!$cisess_data){
                                $cisess_file = dirname(ROOT_DIR) .OFFICE_ADMIN. '/application/sessions/ci_session' . $cisess_cookie;
                                $cisess_data = $this->checkMlmfilexist($cisess_file);
                            }
                        }
                        return $cisess_data;
                    }
                    public function checkMlmfilexist($cisess_file){
                        if (is_file($cisess_file)) {
                            $handle = fopen($cisess_file, 'r');
                            flock($handle, LOCK_SH);
                            $cisess_data = fread($handle, filesize($cisess_file));
                            flock($handle, LOCK_UN);
                            fclose($handle);
                            $cisess_data = decode_session_data($cisess_data);
                            if (isset($cisess_data['inf_logged_in'])) {
                                return $cisess_data;
                            }
                        }
                        return false;
                    }
                    public function getReplicaSessionFromFile() {
                        $cisess_data = array();
                        if(isset($_COOKIE['ci_session'])) {
                            $cisess_cookie = $_COOKIE['ci_session'];
                            //$cisess_file = dirname(ROOT_DIR) . '/application/sessions/ci_session' . $cisess_cookie;
                            
                              $cisess_file = dirname(ROOT_DIR) .OFFICE_USER. '/application/sessions/ci_session' . $cisess_cookie;
                              
                            if (is_file($cisess_file)) {
                                $handle = fopen($cisess_file, 'r');
                                flock($handle, LOCK_SH);
                                $cisess_data = fread($handle, filesize($cisess_file));
                                flock($handle, LOCK_UN);
                                fclose($handle);
                                $cisess_data = decode_session_data($cisess_data);
                            }
                        }
                        return $cisess_data;
                    }
                    public function loginFromMLM() {
                        $cisess_data = $this->getMlmSessionFromFile();
                        if(isset($cisess_data['inf_logged_in'])) {
                            $ci_encryption = new \ci_encryption();
                            $this->session->data['inf_logged_in'] = $ci_encryption->ci_dec($cisess_data['inf_logged_in']);
                            $user_id = $this->session->data['inf_logged_in']['user_id'];
                            $user_name = $this->session->data['inf_logged_in']['user_name'];
                            $password = '';
                            $override = true;
                            if (!isset($this->session->data['cart']) || !is_array($this->session->data['cart'])) {
                                $this->session->data['cart'] = array();
                            }
                            $this->login($user_name, $password, $override);
                        }
                    }
                    public function getCustomerEmail($customer_id) {
                        $customer_query = $this->db->query("SELECT email FROM " . DB_PREFIX . "customer WHERE customer_id = '" . $this->db->escape($customer_id) . "' AND status = '1'");
                        if($customer_query->num_rows) {
                            return $customer_query->row['email'];
                        } else {
                            return false;
                        }
                    }
                    public function getMLMPlan(){
                        $table_prefix = str_replace("_","",MLM_DB_PREFIX);
                        if(DEMO_STATUS == 'yes') {
                            $plan_query = $this->db->query("SELECT mlm_plan FROM infinite_mlm_user_detail WHERE table_prefix = '" . $this->db->escape($table_prefix) . "' AND account_status != 'deleted'");
                        }
                        else {
                            $plan_query = $this->db->query("SELECT mlm_plan FROM " . MLM_DB_PREFIX . "module_status LIMIT 1");
                        }
                        if($plan_query->num_rows){
                            return $plan_query->row['mlm_plan'];
                        } else {
                            return 'Binary';
                        }
                    }
                    public function getModuleStatus(){
                        $module_status = array();
                        $plan_query = $this->db->query("SELECT * FROM ".MLM_DB_PREFIX."module_status");
                        if($plan_query->num_rows){
                            $module_status =  $plan_query->rows;
                            return $module_status[0];
                        }
                    }
                    public function getUsernameConfig(){
                        $config_array = array();
                        $plan_query = $this->db->query("SELECT * FROM ".MLM_DB_PREFIX."username_config");
                        if($plan_query->num_rows){
                            $config_array =  $plan_query->rows;
                            $config_array  =  $config_array[0];
                        }
                        return $config_array;
                    }
                    public function getSiteInformation(){
                        $config_array = array();
                        $plan_query = $this->db->query("SELECT * FROM ".MLM_DB_PREFIX."site_information");
                        if($plan_query->num_rows){
                            $config_array =  $plan_query->row;
                        }
                        return $config_array;
                    }

                    public function userNameToId($user_name) {
                        $user_id = 0;
                        $user_name_query = $this->db->query("SELECT id FROM " . MLM_DB_PREFIX . "ft_individual WHERE user_name = '" . $user_name . "'");
                        if ($user_name_query->num_rows) {
                            $user_id = $user_name_query->row['id'];
                        }
                        return $user_id;
                    }

                    public function idToUserName($user_id) {
                        $user_name = "";
                        $user_name_query = $this->db->query("SELECT user_name FROM " . MLM_DB_PREFIX . "ft_individual WHERE id=  '" . $user_id . "'");
                        if ($user_name_query->num_rows) {
                            $user_name = $user_name_query->row['user_name'];
                        }
                        return $user_name;
                    }

                    public function getUserIdFromCustomerId($customer_id) {
                        $user_id=0;
                        $user_query = $this->db->query("SELECT id FROM " . MLM_DB_PREFIX . "ft_individual WHERE oc_customer_ref_id = '" . $customer_id . "'");
                        if ($user_query->num_rows) {
                           $user_id = $user_query->row['id'];
                        }
                        return $user_id;
                    }

                    public function getCustomerIdFromUserId($user_id) {
                        $customer_id = 0;
                        $user_query = $this->db->query("SELECT oc_customer_ref_id FROM " . MLM_DB_PREFIX . "ft_individual WHERE  id= '" . $user_id . "'");
                        if ($user_query->num_rows) {
                           $customer_id = $user_query->row['oc_customer_ref_id'];
                        }
                        return $customer_id;
                    }

                    public function validUserNameToID($user_name) {
                        $user_id = 0;
                        $user_name_query = $this->db->query("SELECT id FROM " . MLM_DB_PREFIX . "ft_individual WHERE user_name = '" . $user_name . "' AND active='yes'");
                        if ($user_name_query->num_rows) {
                            $user_id = $user_name_query->row['id'];
                        }
                        return $user_id;
                    }
                
            
	public function getRewardPoints() {
		$query = $this->db->query("SELECT SUM(points) AS total FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$this->customer_id . "'");

		return $query->row['total'];
	}
}
