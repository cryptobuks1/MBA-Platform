<?php

class inf_model extends Core_inf_model {

    public $COMMON_PAGE_REF_ID;

    function __construct() {
        parent::__construct();
        $this->COMMON_PAGE_REF_ID = [
            19, //register/user_register
            143, //auto_register/user_register
            4, //login/logout/
            153, //repurchase/repurchase_product
            154, //repurchase/checkout_product
            196         //upgrade/package_upgrade
        ];
    }

    public function trackModule() {

        $this->db->from('module_status');
        $query1 = $this->db->get();
        foreach ($query1->result_array() as $rows1) {
            $this->MODULE_STATUS = $rows1;
        }

        $payment_status = array();
        $i = 0;
        $this->db->select('status');
        $this->db->from("payment_methods");
        $query2 = $this->db->get();

        foreach ($query2->result_array() as $rows2) {
            $payment_status[$i] = $rows2['status'];
            $i++;
        }

        $this->MODULE_STATUS['credit_card'] = $payment_status[0];
        $this->MODULE_STATUS['free_joining_status'] = $payment_status[3];
        return $this->MODULE_STATUS;
    }

    public function getAllLanguages() {
        $lang_arr = array();

        $this->db->select('lang_status,lang_status_demo');
        $query1 = $this->db->get('module_status');
        $multi_lang_status = $query1->row_array();

        if ($multi_lang_status['lang_status'] == 'yes' && $multi_lang_status['lang_status_demo'] == 'yes') {
            $query2 = $this->db->where("status", "yes")->get("infinite_languages");
            foreach ($query2->result_array() as $rows) {
                $lang_arr[] = $rows;
            }
        } else {
            $lang_arr[] = [
                'lang_id' => '1',
                'lang_code' => 'en',
                'lang_name' => 'English',
                'lang_name_in_english' => 'english',
                'flag_image' => '',
                'status' => 'yes',
                'default_id' => '1'
            ];
        }

        return $lang_arr;
    }

    public function getProjectDefaultLang() {
        $lang_arr = array();

        $this->db->select('lang_status,lang_status_demo');
        $query1 = $this->db->get('module_status');
        $multi_lang_status = $query1->row_array();

        if ($multi_lang_status['lang_status'] == 'yes' && $multi_lang_status['lang_status_demo'] == 'yes') {
            $query2 = $this->db->where("status", "yes")->where("default_id", 1)->get("infinite_languages");
            foreach ($query2->result_array() as $rows) {
                $lang_arr = $rows;
            }
        } else {
            $lang_arr = [
                'lang_id' => '1',
                'lang_code' => 'en',
                'lang_name' => 'English',
                'lang_name_in_english' => 'english',
                'flag_image' => '',
                'status' => 'yes',
                'default_id' => '1'
            ];
        }

        return $lang_arr;
    }

    public function checkUpgrade($user_ref_id) {
        $dbprefix = $this->db->dbprefix;
        $this->db->set_dbprefix('');
        $account_status = 'inactive';
        $this->db->select('account_status');
        $this->db->from("infinite_mlm_user_detail");
        $this->db->where('id', $user_ref_id);
        $res = $this->db->get();
        $this->db->set_dbprefix($dbprefix);
        foreach ($res->result() as $row) {
            $account_status = $row->account_status;
        }
        return $account_status;
    }

    public function getURLScripts($url_link) {
        $script_arr = array();
        $url_ref_id = $this->getURLID($url_link);
        if ($url_ref_id) {
            $this->load->model('url_scripts_model');
            $script_arr = $this->url_scripts_model->getURLScripts($url_ref_id);
        }
        return $script_arr;
    }

    public function getURLID($url_link) {
        $id = 0;

        switch ($url_link) {
            case "auto_register/user_register":
                $id = 143; //register/user_register
                break;
            case "report/total_joining_daily":
                $id = 51; //select_report/total_joining_report
                break;
            case "report/total_joining_weekly":
                $id = 51; //select_report/total_joining_report
                break;
            case "report/total_payout_report_view":
                $id = 52; //select_report/total_payout_report
                break;
            case "report/weekly_payout_report":
                $id = 52; //select_report/total_payout_report
                break;
            case "report/member_payout_report":
                $id = 52; //select_report/total_payout_report
                break;

            case "report/sales_report_view":
                $id = 50; //select_report/sales_report
                break;
            case "report/product_sales_report":
                $id = 50; //select_report/sales_report
                break;

            case "report/rank_achievers_report_view":
                $id = 49; //select_report/rank_achievers_report
                break;

            case "report/commission_report_view":
                $id = 46; //select_report/commission_report
                break;

            case "report/epin_report_view":
                $id = 47; //select_report/epin_report report/profile_report_view
                break;
            case "report/profile_report_view":
                $id = 45; //select_report/admin_profile_report
                break;

            case "report/stair_step_report_view":
                $id = 45; //select_report/admin_profile_report
                break;

            case "report/override_report_view":
                $id = 45; //select_report/admin_profile_report
                break;

            case "report/profile_report_multiple_count":
                $id = 45; //select_report/admin_profile_report
                break;

            case "ticket/view_ticket_details":
                $id = 87; //ticket/ticket_system
                break;

            case "ticket_system/tickets":
                $id = 87; //ticket/ticket_system
                break;

            case "repurchase/product_details":
                $id = 154; //repurchase/repurchase_product
                break;

            // case "select_report/stair_step_report":
            //     $id = 155; //repurchase/repurchase_product
            //     break;

            case "select_report/override_report":
                $id = 155; //repurchase/repurchase_product
                break;

            case "member/package_validity":
                if ($this->LOG_USER_TYPE == "admin" || $this->LOG_USER_TYPE == "employee")
                    $id = 163;
                else
                    $id = 162;
                break;

            default:
                $this->db->select('id');
                $this->db->from('infinite_urls');
                $this->db->where('link', $url_link);
                $this->db->where('status', 'yes');
                $this->db->limit(1);
                $query = $this->db->get();

                foreach ($query->result_array() as $row) {
                    $id = $row['id'];
                }
                break;
        }
        return $id;
    }

    public function getURLName($url_id) {
        $id = "";
        $this->db->select('link');
        $this->db->from('infinite_urls');
        $this->db->where('id', $url_id);
        $this->db->where('status', 'yes');
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            if ($url_id == '135') {
                $id = $row['link'];
            } else {
                $id = preg_replace("/(.*)\//i", "", $row['link']);
            }
        }
        return $id;
    }

    public function getURLTarget($url_id) {
        $target = 'none';
        $this->db->select('target');
        $this->db->from('infinite_urls');
        $this->db->where('id', $url_id);
        $this->db->where('status', 'yes');
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $target = $row['target'];
        }
        return $target;
    }

    public function getThemeFolder($field = 'user_theme_folder') {
        $this->db->select($field);
        $res = $this->db->get('site_information');
        foreach ($res->result() as $row) {
            $data = $row->$field;
        }
        return $data;
    }

    public function getLeftMenu($user_id, $user_type, $current_url, $plan) {
        $this->MODULE_STATUS = $this->trackModule();
        $assigned_menus = "";
        $permission_type = 'perm_dist';
        if ($user_type == 'admin') {
            $permission_type = 'perm_admin';
        } else if ($user_type == 'employee') {
            $permission_type = 'perm_emp';
            $assigned_menus = $this->getAllAssignedMenus($user_id);
        }
// print_r($assigned_menus);die;
        // package validity expired users have only some menu permitted
        $product_id = $this->validation_model->getProductId($user_id);
        $package_validity_date = $this->validation_model->getUserProductValidity($user_id);
        $today = date("Y-m-d H:i:s");
        if ($this->MODULE_STATUS['product_validity'] == 'yes' && $this->MODULE_STATUS['product_status'] == 'yes' && $today > $package_validity_date && $user_type == 'user' && $product_id != 0) {

            $assigned_menus = $this->getPackageExpiredUserMenus();
        }

        $path_root_reg = base_url();
        $path_root = base_url() . "user/";

        if ($user_type == "admin" || $user_type == "employee") {
            $path_root = base_url() . "admin/";
        }

        $menu_array = $this->getMenuArray($permission_type, $current_url, $path_root, $path_root_reg, $assigned_menus);

        return $menu_array;
    }

    public function getMenuArrayOld($permission_type, $current_url, $path_root, $path_root_reg, $assigned_menus = "") {
        $registration_allowed = $this->configuration_model->isRegistrationAllowed();
        $current_url_id = $this->getURLID($current_url);
        $menu_array = array();
        $this->db->select('*');
        $this->db->from('infinite_mlm_menu');
        $this->db->where("status", "yes");
        $this->db->where($permission_type, "1");
        $this->db->order_by("main_order_id");
        $qry = $this->db->get();

        $i = 0;
        foreach ($qry->result_array() as $row) {
            $menu_flag = true;
            $is_selected = false;
            $menu_id = $row['id'];
            if ($menu_id == 36) {
                continue;
            }
            $link_ref_id = $row['link_ref_id'];
            if (!$link_ref_id) {
                $link_ref_id = $row['link_ref_id'] = '#';
            }
            if (($link_ref_id == 19 || $link_ref_id == 143) && !$registration_allowed) {
                continue;
            }
            if ($permission_type == 'perm_emp') {
                $menu_flag = $this->checkMenuPermitted($link_ref_id, $permission_type, $menu_id, $assigned_menus);
            }

            // package validity expired users have only some menu permitted
            if ($assigned_menus != null && $permission_type == 'perm_dist') {
                $menu_flag = $this->checkMenuPermitted($link_ref_id, $permission_type, $menu_id, $assigned_menus);
            }

            if (DEMO_STATUS != "yes" && $link_ref_id == 143) {
                $menu_flag = false;
            }
            if ($menu_flag) {
                $is_selected = $this->isMenuSelected($menu_id, $link_ref_id, $current_url_id);
                $menu_link = $this->getURLName($link_ref_id);
                $menu_target = $this->getURLTarget($link_ref_id);

                if (in_array($link_ref_id, $this->COMMON_PAGE_REF_ID)) {
                    $menu_link = $path_root_reg . $menu_link;
                } else if ($link_ref_id != '#') {
                    $menu_link = $path_root . $menu_link;
                } elseif ($link_ref_id == "#") {
                    $menu_link = 'javascript:void(0);';
                }
                $menu_array[$i]["link"] = $menu_link;
                $menu_array[$i]["target"] = $menu_target;
                $menu_array[$i]["icon"] = $row['icon'];
                $menu_array[$i]["link_ref_id"] = $row['link_ref_id'];
                if ($this->MODULE_STATUS['hyip_status'] == 'yes' && $this->MLM_PLAN == 'Unilevel') {
                    if ($menu_id == '12' && $row['link_ref_id'] == '#') {
                        $menu_array[$i]["text"] = lang('12_12');
                    } else if ($menu_id == '14' && $row['link_ref_id'] == '#') {
                        $menu_array[$i]["text"] = lang('14_14');
                    } else if ($menu_id == '46' && $row['link_ref_id'] == '153') {
                        $menu_array[$i]["text"] = lang('12_109_12');
                    } else {
                        $menu_array[$i]["text"] = lang($menu_id . '_' . $row['link_ref_id']);
                    }
                } else {
                    $menu_array[$i]["text"] = lang($menu_id . '_' . $row['link_ref_id']);
                }
                $menu_array[$i]["sub_menu"] = $this->getSubMenuArray($menu_id, $permission_type, $current_url, $path_root, $assigned_menus);
                $menu_array[$i]["is_selected"] = $is_selected;
                $i++;
            }
        }

        return $menu_array;
    }

    public function getMenuArray($permission_type, $current_url, $path_root, $path_root_reg, $assigned_menus = "") {
        $registration_allowed = $this->configuration_model->isRegistrationAllowed();
        $current_url_id = $this->getURLID($current_url);
        
        $subs_date = $this->ewallet_model->getSubscriptionEndDate($this->LOG_USER_ID);//get subscription date for menu restriction --Aiswarya
        $today = date('Y-m-d H:i:s');
        $i = 0;
        $menu_array = array();
        $this->db->select('m.id menu_id,s.sub_id submenu_id,m.icon,m.status menu_status,s.sub_status submenu_status,u1.link menu_url,u2.link submenu_url,u1.id menu_url_id,u2.id submenu_url_id,u1.target menu_target,u2.target submenu_target,m.perm_admin menu_admin,m.perm_dist menu_dist,m.perm_emp menu_emp,s.perm_admin submenu_admin,s.perm_dist submenu_dist,s.perm_emp submenu_emp,m.main_order_id menu_order,s.sub_order_id submenu_order');
        $this->db->from('infinite_mlm_menu m');
        $this->db->join('infinite_mlm_sub_menu s', 'm.id=s.sub_refid','left');
        $this->db->join('infinite_urls u1', 'u1.id=m.link_ref_id','left');
        $this->db->join('infinite_urls u2', 'u2.id=s.sub_link_ref_id','left');
        $this->db->where("m.status", "yes");
        $this->db->group_start()
                 ->where("s.sub_status", NULL )
                 ->or_where("s.sub_status", 'yes')
                 ->group_end();
        $this->db->where("m.{$permission_type}", "1");
        $this->db-> group_start()
                 ->where("s.{$permission_type}", "1")
                 ->or_where("s.sub_status", NULL)
                 ->group_end();
        $this->db->order_by("menu_order",'asc');
        $this->db->order_by("submenu_order",'asc');
        $this->db->order_by("menu_id",'asc');
        $qry = $this->db->get();//echo $this->db->last_query();die;
//print_r($qry->result_array());die;
    foreach ($qry->result_array() as $row) {
        if (empty($row['menu_url']) && empty($row['submenu_url'])) {
            continue;
        }
        $menu_flag = true;
        $submenu_flag = true;
        if ($row['menu_url_id'] == 19 && !$registration_allowed) { // Blocked Registration
            continue;
        }
        if ($row['menu_id'] == 32 && $row['submenu_id'] != 138) { // Ticket System
            continue;
        }
        $join_type = $this->validation_model->getJoinType($this->LOG_USER_ID);
        $user_account_links = array(68,71);
        if (in_array($row['menu_id'], $user_account_links) && $join_type !='customer') { 
            continue;
        }
        $user_account_links = array(7, 14, 67, 15,16,2,67,71,23,1,34);
        if (in_array($row['menu_id'], $user_account_links) && $join_type =='customer') { 
            continue;
        }
        
                //// menu restriction based on subscription --Aiswarya
         if($subs_date<= $today){
             $subscription='inactive';
             
         }
         else
         {
              $subscription='active';
         }
        
        $user_account_links = array(73,72,37,42,7,14);
        if (in_array($row['menu_id'], $user_account_links) && $subscription =='inactive') { 
            continue;
       
         }
         $user_account_links = array(76);
         if (in_array($row['menu_id'], $user_account_links) && $subscription =='active') { 
            continue;
       
         }
        if ($permission_type == 'perm_emp') {
            $menu_flag = $this->checkMenuPermitted($row['menu_url_id'], $permission_type, $row['menu_id'], $assigned_menus);
            if(empty($row['menu_url'])) {
                $submenu_flag = $this->checkSubMenuPermitted($assigned_menus, $row['menu_id'], $permission_type, $row['submenu_id']);
            }
        }

        if ($assigned_menus != null && $permission_type == 'perm_dist') {
            $menu_flag = $this->checkMenuPermitted($row['menu_url_id'], $permission_type, $row['menu_id'], $assigned_menus);
        }
        if (!$menu_flag || !$submenu_flag) {
            continue;
        }
        $menu_array[] = $row;
        if($row['menu_url_id'] != '') {
            $menu_array[$i]['is_menu_selected'] = $this->isMenuSelected($row['menu_id'], $row['menu_url_id'], $current_url_id);
            if($menu_array[$i]['is_menu_selected'])
                $menu_array[$i]['is_submenu_selected'] = 1;
            else
                $menu_array[$i]['is_submenu_selected'] = "";
        } else {
            $menu_array[$i]['is_submenu_selected'] = $this->isMenuSelected($row['menu_id'], $row['submenu_url_id'], $current_url_id);
            if($menu_array[$i]['is_submenu_selected'])
                $menu_array[$i]['is_menu_selected'] = 1;
            else
                $menu_array[$i]['is_menu_selected'] = "";
        }
        $i++;
    }//print_r($menu_array);die;
        return $menu_array;
    }

    public function isMenuSelected($menu_id, $menu_link, $current_url_id) {
        $flag = false;

        if ($menu_link == "#") {
            $current_menu_id = $this->getMainMenuIdFromSubLink($current_url_id);
            if ($current_menu_id == $menu_id) {
                $flag = true;
            }
        } else {
            if ($current_url_id == $menu_link) {
                $flag = true;
            }
        }
        return $flag;
    }

    public function getMainMenuIdFromSubLink($menu_link) {
        $sub_refid = 0;
        $this->db->select('sub_refid');
        $this->db->from('infinite_mlm_sub_menu');
        $this->db->where('sub_link_ref_id', $menu_link);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $sub_refid = $row->sub_refid;
        }
        return $sub_refid;
    }

    public function getSubMenuArray($menu_id, $permission_type, $current_url, $path_root, $assigned_menus = "") {
        $sub_menu = array();
        if ($menu_id == '32') {  //Ticket System : Hide Submenu
            return $sub_menu;
        }
        $current_url_id = $this->getURLID($current_url);

        $this->db->select('*');
        $this->db->from('infinite_mlm_sub_menu');
        $this->db->where("sub_refid", $menu_id);
        $this->db->where("sub_status", "yes");
        $this->db->where($permission_type, "1");
        $this->db->order_by("sub_order_id");
        $qry = $this->db->get();

        $i = 0;
        foreach ($qry->result_array() as $row) {

            $menu_flag = true;
            $sub_menu_id = $row['sub_id'];
            $sub_link_ref_id = $row['sub_link_ref_id'];
            $sub_menu_link = $this->getURLName($sub_link_ref_id);
            if ($permission_type == 'perm_emp') {
                $menu_flag = $this->checkSubMenuPermitted($assigned_menus, $menu_id, $permission_type, $sub_menu_id);
            }

            if ($menu_flag) {
                $is_selected = $this->isMenuSelected($menu_id, $sub_link_ref_id, $current_url_id);

                if ($menu_id == 44) {//crm submenus
                    $sub_menu_link = base_url() . $sub_menu_link;
                } elseif (in_array($sub_link_ref_id, $this->COMMON_PAGE_REF_ID)) {
                    $sub_menu_link = base_url() . $sub_menu_link;
                } else {
                    $sub_menu_link = $path_root . $sub_menu_link;
                }

                $sub_menu[$i]["link"] = $sub_menu_link;
                $sub_menu[$i]["icon"] = $row['icon'];
                if ($this->validation_model->getMLMPlan() == "Board" && $this->validation_model->getModuleStatusByKey("table_status") == "yes" && $sub_link_ref_id == 101)
                    $sub_menu[$i]["text"] = lang('2_77_101');
                elseif ($this->MODULE_STATUS['hyip_status'] == 'yes' && $this->MLM_PLAN == 'Unilevel' && $sub_link_ref_id == 188) {
                    $sub_menu[$i]["text"] = lang('12_109_12');
                } elseif ($this->MODULE_STATUS['hyip_status'] == 'yes' && $this->MLM_PLAN == 'Unilevel' && $sub_link_ref_id == 35) {
                    $sub_menu[$i]["text"] = lang('14_28_14');
                } else
                    $sub_menu[$i]["text"] = lang($menu_id . '_' . $sub_menu_id . '_' . $sub_link_ref_id);
                $sub_menu[$i]["is_selected"] = $is_selected;
                $i++;
            }
        }
        return $sub_menu;
    }

    public function isValidMenu($link_id) {
        $menu_id = $this->getMenuID($link_id);
        if (!$menu_id) {
            $menu_id = $this->getSubMenuID($link_id);
        }
        return $menu_id;
    }

    public function getMenuID($link_id, $perm_type = '') {
        $menu_id = 0;
        $this->db->select("id");
        $this->db->from("infinite_mlm_menu");
        $this->db->where('link_ref_id', $link_id);
        $this->db->where('status', 'yes');
        if ($perm_type != '') {
            $this->db->where($perm_type, 1);
        }
        $this->db->limit(1);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $menu_id = $row->id;
        }
        return $menu_id;
    }

    public function getSubMenuID($link_id, $perm_type = '') {
        $submenu_id = 0;
        $this->db->select("sub_id");
        $this->db->from("infinite_mlm_sub_menu");
        $this->db->where('sub_link_ref_id', $link_id);
        if ($perm_type != '') {
            $this->db->where($perm_type, 1);
        }
        $this->db->limit(1);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $submenu_id = $row->sub_id;
        }
        return $submenu_id;
    }

    public function getMenuIDFromSubMenu($link_id, $perm_type = '') {
        $menu_id = 0;
        $this->db->select("sub_refid");
        $this->db->from("infinite_mlm_sub_menu");
        $this->db->where("sub_status", "yes");
        $this->db->where('sub_link_ref_id', $link_id);
        if ($perm_type != '') {
            $this->db->where($perm_type, 1);
        }
        $this->db->limit(1);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $menu_id = $row->sub_refid;
        }
        return $menu_id;
    }

    public function checkMenuPermitted($link_id, $perm_type = '', $menu_id = '', $assigned_menus = '') {

        $flag = false;
        if ($link_id == 85 || $link_id == 84) {
            $this->db->select("perm_emp");
            $this->db->from("infinite_mlm_menu");
            $this->db->where("link_ref_id", 95);
            $this->db->where("perm_emp", 1);
            $result = $this->db->get();
            if (count($result) > 0) {
                $flag = true;
            }
        }
        $module_status_arr = explode(",", $assigned_menus);
        // Get the Sub menu Reference Id from the link id
        $sub_ref_id = $this->getSubRefIdFromLink($link_id);
        // If sub menu reference id exists, Get the menu id from sub menu id
        if ($sub_ref_id != 0) {
            $menu_ref_id = $this->getMenuIDFromSubMenuID($sub_ref_id);
        }
        $user_account_links = array(22, 11, 56, 63, 35, 69, 38, 157,11);
        if (in_array($link_id, $user_account_links) && in_array("m#8", $module_status_arr)) {
            $flag = true;
        } else {

            if ($menu_id) {
                $menu_check = 'm#' . $menu_id;
                if (in_array($menu_check, $module_status_arr)) {
                    $flag = true;
                }
                if (!$flag) {
                    $flag = $this->checkSubMenuPermitted($assigned_menus, $menu_id, $perm_type);
                }
            } else {
                if ($link_id != '#') {
                    $menu_id = $this->getMenuID($link_id, $perm_type);

                    if (!$menu_id) {
                        // This condition is added for employee permission
                        // Here the link id is converted to menu_id#sub_meu_id format to check whether this link is permitted to employee or not.
                        if ($menu_id == 0 && $sub_ref_id != 0 && $menu_ref_id) {
                            $menu_check = $menu_ref_id . '#' . $sub_ref_id;
                        } else {
                            $submenu_id = $this->getSubMenuID($link_id, $perm_type);
                            $menu_id = $this->getMainMenuIdFromSubLink($link_id);
                            $menu_check = $menu_id . "#" . $submenu_id;
                        }
                    } else {
                        $menu_check = 'm#' . $menu_id;
                    }
                    if (in_array($menu_check, $module_status_arr)) {
                        $flag = true;
                    }
                } else {
                    $flag = true;
                }
            }
        }
        return $flag;
    }

    public function checkSubMenuPermitted($assigned_menus, $menu_id, $perm_type, $submenu_id = '') {
        $flag = false;
        $module_status_arr = explode(",", $assigned_menus);
        if ($submenu_id) {
            $menu_check = $menu_id . "#" . $submenu_id;
            if (in_array($menu_check, $module_status_arr)) {
                $flag = true;
            }
        } else {
            $menu_arr = $this->getAllSubMenus($menu_id, $perm_type);
            foreach ($menu_arr as $menu_check) {
                if (in_array($menu_check, $module_status_arr)) {
                    $flag = true;
                    break;
                }
            }
        }
        
        return $flag;
    }

    public function isValidDemoID($demo_id) {
        $flag = false;
        $count = 0;
        $dbprefix = $this->db->dbprefix;
        $this->db->set_dbprefix('');
        $this->db->select("COUNT(*) AS numrows");
        $this->db->from("infinite_mlm_user_detail");
        $this->db->where('id', $demo_id);
        $this->db->where('account_status !=', 'deleted');
        $query = $this->db->get();
        $this->db->set_dbprefix($dbprefix);
        foreach ($query->result() as $row) {
            $count = $row->numrows;
        }
        if ($count) {
            $flag = true;
        }
        return $flag;
    }

    public function getAllAssignedMenus($user_id) {
        $user_menus = '';
        $this->db->select("module_status");
        $this->db->from("login_employee");
        $this->db->where('user_id', $user_id);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $user_menus = $row->module_status;
        }
        return $user_menus;
    }

    public function getAllSubMenus($menu_id, $perm_type) {
        $menu_arr = array();
        $this->db->select('sub_id');
        $this->db->from('infinite_mlm_sub_menu');
        $this->db->where("sub_refid", $menu_id);
        $this->db->where("sub_status", "yes");
        $this->db->where($perm_type, "1");
        $this->db->order_by("sub_order_id");
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $menu_arr[] = $menu_id . "#" . $row['sub_id'];
        }
        return $menu_arr;
    }

    public function setDefaultLang($lang_code) {
        $user_id = $this->LOG_USER_ID;
        if ($this->LOG_USER_TYPE == "employee")
            $user_id = $this->ADMIN_USER_ID;
        if ($user_id) {
            $this->db->set('default_lang', $lang_code);
            $this->db->where('id', $user_id);
            $this->db->update("ft_individual");
        }
    }

    public function getLanguageName($id) {
        $lang = "english";

        $this->db->select('lang_status,lang_status_demo');
        $query1 = $this->db->get('module_status');
        $multi_lang_status = $query1->row_array();

        if ($multi_lang_status['lang_status'] == 'yes' && $multi_lang_status['lang_status_demo'] == 'yes') {
            $this->db->select('lang_name_in_english');
            $this->db->from('infinite_languages');
            $this->db->where('lang_id', $id);
            $query2 = $this->db->get();
            foreach ($query2->result() as $row) {
                $lang = $row->lang_name_in_english;
            }
        }

        return $lang;
    }

    public function getDefaultLang($user) {
        $lang = 1;
        $this->db->select('default_lang');
        $this->db->from('ft_individual');
        $this->db->where('id', $user);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $lang = $row['default_lang'];
        }
        return $lang;
    }

    public function checkMaintanenceMode() {
        $status = false;

        $site_maintenance_status = $this->validation_model->getModuleStatusByKey('maintenance_status');
        if ($site_maintenance_status == 'no') {
            return false;
        }

        $this->db->from('site_maintenance');
        $this->db->where('id', '1');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            if ($row->status) {
                $to_date = $row->date_of_availability;
                $current_date = date('Y-m-d H:i:s');
                $status = ($current_date < $to_date);
            }
        }
        return $status;
    }

    public function updateMaintenanceMode($status) {
        $this->db->set('status', $status);
        $this->db->where('id', '1');
        $query = $this->db->update('site_maintenance');
        return $query;
    }

    public function getMaintanenceData($table_prefix = '') {
        if ($table_prefix == '') {
            $table_prefix = $this->db->dbprefix;
        }
        $data = array();

        $dbprefix = $this->db->dbprefix;
        $this->db->set_dbprefix($table_prefix);
        $site_maintenance_status = $this->validation_model->getModuleStatusByKey('maintenance_status');
        $this->db->set_dbprefix($dbprefix);
        if ($site_maintenance_status == 'no') {
            $data['block_login'] = false;
            $data['block_register'] = false;
            $data['block_ecommerce'] = false;
            return $data;
        }
        $this->db->select('*');
        $this->db->from('site_maintenance');
        $this->db->where('id', 1);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $data = $row;
        }
        return $data;
    }

    public function enableRepurchaseFromBackoffice() {
        $this->db->set('repurchase_status', 'yes');
        $query = $this->db->update('module_status');
        return $query;
    }

    public function disableRepurchaseFromBackoffice() {
        $this->db->set('repurchase_status', 'no');
        $query = $this->db->update('module_status');
        return $query;
    }

    public function getTicketSystemLeftMenu($loggged_user_type, $current_url) {

        $permission_type = "perm_dist";
        if ($loggged_user_type == "admin") {
            $permission_type = "perm_admin";
        } elseif ($loggged_user_type == "employee") {
            $permission_type = "perm_admin";
        }

        $this->db->select('"32" menu_id,s.sub_id submenu_id,s.icon,s.sub_status menu_status,s.sub_status submenu_status,u1.link menu_url,u1.link submenu_url,u1.id menu_url_id,u1.id submenu_url_id,u1.target menu_target,u1.target submenu_target,s.perm_admin menu_admin,s.perm_dist menu_dist,s.perm_emp menu_emp,s.perm_admin submenu_admin,s.perm_dist submenu_dist,s.perm_emp submenu_emp,s.sub_order_id menu_order,s.sub_order_id submenu_order');
        $this->db->from('infinite_mlm_sub_menu s');
        $this->db->join('infinite_urls u1', 'u1.id=s.sub_link_ref_id','left');
        $this->db->where("s.sub_status", 'yes');
        $this->db->where("s.sub_refid", 32);
        $this->db->where("s.{$permission_type}", "1");
        $this->db->order_by("sub_order_id",'asc');
        $qry = $this->db->get();
        $i = 0;
        foreach ($qry->result_array() as $row) {
            $menu_array[] = $row;
            $menu_array[$i]["is_menu_selected"] = ($current_url == $row['submenu_url']) ? true : false;
            $menu_array[$i]["is_submenu_selected"] = ($current_url == $row['submenu_url']) ? true : false;
            $i++;
        }
        return $menu_array;
    }

    public function getTicketSystemLeftMenuOld($loggged_user_type, $current_url) {

        $permission_type = "perm_dist";
        if ($loggged_user_type == "admin") {
            $permission_type = "perm_admin";
        } elseif ($loggged_user_type == "employee") {
            $permission_type = "perm_admin";
        }

        $i = 1;
        $menu_array = array();
        $base_path = base_url() . "admin/";
        $this->db->select('sub_link_ref_id,icon');
        $this->db->from('infinite_mlm_sub_menu');
        $this->db->where("sub_status", "yes");
        $this->db->where("sub_refid", 32);
        $this->db->where($permission_type, "1");
        $this->db->order_by("sub_order_id");
        $qry = $this->db->get();

        foreach ($qry->result_array() as $row) {
            $menu_flag = true;
            if ($menu_flag) {
                $link_ref_id = $row['sub_link_ref_id'];
                $menu_link = $this->getURLName($link_ref_id);
                $menu_target = $this->getURLTarget($link_ref_id);

                $menu_array[$i]["link"] = $base_path . $menu_link;
                if ($link_ref_id == 4) {
                    $menu_array[$i]["link"] = base_url() . $menu_link;
                }
                $menu_array[$i]["target"] = $menu_target;
                $menu_array[$i]["icon"] = ''; //$row['icon'];
                $menu_array[$i]["link_ref_id"] = $link_ref_id;
                $menu_array[$i]["text"] = lang('32_' . $link_ref_id);
                $menu_array[$i]["sub_menu"] = array();
                $menu_array[$i]["is_selected"] = ($current_url == $menu_link) ? true : false;
                $i++;
            }
        }
        return $menu_array;
    }

    public function getPackageExpiredUserMenus() {

        $assigned_menus = "m#1,2#1,2#2,2#3,m#7,m#63,19#43,m#24,m#41,19#44,m#26,m#76,19#93";

        return $assigned_menus;
    }

    public function getOpencartStatus($db_prefix) {
        $dbprefix1 = $this->db->dbprefix;
        $this->db->set_dbprefix($db_prefix . '_');
        $this->db->select('opencart_status,opencart_status_demo');
        $this->db->from('module_status');
        $this->db->limit(1);
        $query = $this->db->get();
        $this->db->set_dbprefix($dbprefix1);
        return $query->row_array();
    }

    public function getDemoActiveStatus() {
        $this->db->select('account_status');
        $this->db->limit(1);
        $query = $this->db->get('project_info');
        return $query->row_array()['account_status'];
    }

    public function getReplicaSession() {
        $dbprefix = $this->db->dbprefix;
        $this->db->set_dbprefix('');
        $cisess_data = array();
        if (isset($_COOKIE['ci_session'])) {
            $cisess_cookie = $_COOKIE['ci_session'];
            $cisess_table = (DEMO_STATUS == 'yes') ? "inf_ci_sessions" : $this->db->dbprefix . "ci_sessions";
            $this->db->select('data');
            $this->db->from($cisess_table);
            $this->db->where('id', $cisess_cookie);
            $this->db->limit(1);
            $query = $this->db->get();
            $cisess_data = $query->row_array()['data'];
            $cisess_data = $this->decode_session_data($cisess_data);
        }
        $this->db->set_dbprefix($dbprefix);
        return $cisess_data;
    }

    public function getReplicaSessionFromFile() {
        $cisess_data = array();
        if (isset($_COOKIE['ci_session'])) {
            $cisess_cookie = $_COOKIE['ci_session'];
            $cisess_file = APPPATH . 'sessions/ci_session' . $cisess_cookie;
            if (is_file($cisess_file)) {
                $handle = fopen($cisess_file, 'r');
                // flock($handle, LOCK_SH);
                $cisess_data = fread($handle, filesize($cisess_file));
                // flock($handle, LOCK_UN);
                fclose($handle);
                $cisess_data = $this->decode_session_data($cisess_data);
            }
        }
        return $cisess_data;
    }

    function decode_session_data($session_data) {
        $return_data = array();
        $offset = 0;
        while ($offset < strlen($session_data)) {
            if (!strstr(substr($session_data, $offset), "|")) {
                return $return_data;
            }
            $pos = strpos($session_data, "|", $offset);
            $num = $pos - $offset;
            $varname = substr($session_data, $offset, $num);
            $offset += $num + 1;
            $data = unserialize(substr($session_data, $offset));
            $return_data[$varname] = $data;
            $offset += strlen(serialize($data));
        }
        return $return_data;
    }

    public function getSubRefIdFromLink($link_id) {
        $this->db->select('sub_menu_ref_id');
        $this->db->where('id', $link_id);
        $this->db->limit(1);
        $query = $this->db->get('infinite_urls');
        return $query->row_array()['sub_menu_ref_id'];
    }

    public function getMenuIDFromSubMenuID($sub_id) {
        $this->db->select('sub_refid');
        $this->db->where('sub_id', $sub_id);
        $this->db->limit(1);
        $query = $this->db->get('infinite_mlm_sub_menu');
        return $query->row_array()['sub_refid'];
    }

    public function checkUrlPermitted($link_id, $perm_type) {

        $menu_status = false;
        $sub_menu_status = false;
        $menu_not_avail = false;
        $sub_menu_not_avail = false;

        $this->db->select('*');
        $this->db->from('infinite_mlm_menu');
        $this->db->where("link_ref_id", $link_id);
        $query = $this->db->get();
        if (count($query->result_array()) > 0) {
            if ($query->row('status') == "yes" && $query->row($perm_type) == "1") {
                $menu_status = true;
            }
        } else {
            $menu_not_avail = true;
        }
        if (in_array($link_id, array(24, 35, 38, 63)) && $this->LOG_USER_TYPE == "admin") {
            return true;
        }

        $this->db->select('*');
        $this->db->from('infinite_mlm_sub_menu');
        $this->db->where("sub_link_ref_id", $link_id);
        $query1 = $this->db->get();
        if (count($query1->result_array()) > 0) {
            $menu_ok = $this->checkMenuStatus($query1->row('sub_refid'), $perm_type, $link_id);
            if ($query1->row('sub_status') == "yes" && $query1->row($perm_type) == "1" && $menu_ok) {
                $sub_menu_status = true;
            }
        } else {
            $sub_menu_not_avail = true;
        }
        if ($menu_not_avail && $sub_menu_not_avail) {
            return true;
        } elseif ($menu_status || $sub_menu_status) {
            return true;
        } else {
            return false;
        }
    }

    public function checkMenuStatus($id, $perm_type, $link_id) {
        $this->db->select('id');
        $this->db->from('infinite_mlm_menu');
        $this->db->where("id", $id);
        $this->db->where("status", "yes");
        $this->db->where("$perm_type", 1);
        $query = $this->db->get();
        return $query->row('id');
    }

    public function isValidDemoUser($demo_user, $admin_user_id) {
        $flag = FALSE;
        $table_prefix = NULL;
        $this->load->model('login_model');
        if($admin_user_id) {
        	$table_prefix = $this->login_model->getTablePrefix($admin_user_id);
            $query1 = $this->db->query("SELECT COUNT(*) AS `count` FROM (`infinite_mlm_user_detail`) WHERE `id` = '$admin_user_id' AND `account_status` != 'deleted'");
            $demo_count = $query1->row_array()['count'];
            if($demo_count) {
                $query2 = $this->db->query("SELECT COUNT(*) AS `count` FROM `{$table_prefix}_ft_individual` WHERE `user_name` = '{$demo_user}' AND `active` != 'server'");
                $user_count = $query2->row_array()['count'];
                if($user_count) {
                    $flag = TRUE;
                }
            }
        }
        else {
            $query1 = $this->db->query("SELECT `id` FROM (`infinite_mlm_user_detail`) WHERE `user_name` = '$demo_user' AND `account_status` != 'deleted'");
            $admin_user_id = $query1->row_array()['id'];
            if($admin_user_id) {
            	$table_prefix = $this->login_model->getTablePrefix($admin_user_id);
                $query2 = $this->db->query("SELECT COUNT(*) AS `count` FROM `{$table_prefix}_ft_individual` WHERE `user_name` = '{$demo_user}' AND `active` != 'server'");
                $user_count = $query2->row_array()['count'];
                if($user_count) {
                    $flag = TRUE;
                }
            }
        }
        return array('status' => $flag, 'demo_id' => $admin_user_id, 'table_prefix' => $table_prefix);
    }

    public function getDemoId($demo_user) {
        $flag = FALSE;
        $demo_id = 0;

        $query = $this->db->query("SELECT id FROM (`infinite_mlm_user_detail`) WHERE `user_name` = '$demo_user' AND `account_status` != 'deleted'");
        foreach ($query->result() AS $row) {
            $demo_id = $row->id;
        }

        return $demo_id;
    }

    public function checkLCPStatus($table_prefix) {
        $res = $this->db->query("SELECT `lead_capture_status`, `lead_capture_status_demo` FROM (`" . $table_prefix . "module_status`)");
        foreach ($res->result_array() as $row) {
            return ($row['lead_capture_status'] == 'yes' && $row['lead_capture_status_demo'] == 'yes');
        }
    }

    public function getAllUserDetails($user_id) {
        $details = array();
        $this->db->select('*');
        $this->db->from('user_details AS ud');
        $this->db->join('ft_individual AS ft', 'ft.id = ud.user_detail_refid');
        $this->db->where('user_detail_refid', $user_id);
        $res = $this->db->get();

        foreach ($res->result_array() as $row) {
            $details['id'] = $row['id'];
            $details['user_name'] = $row['user_name'];
            $details['mlm_plan'] = $this->validation_model->getMLMPlan();
            $details['full_name'] = $row['user_detail_name'] . " " . $row['user_detail_second_name'];
            $details['phone'] = $row['user_detail_mobile'];
            $details['email'] = $row['user_detail_email'];
            $this->load->model("country_state_model");
            $details['country'] = $this->country_state_model->getCountryNameFromId($row['user_detail_country']);
            $details['location'] = $row['user_detail_state'];
            $details['reg_date'] = $row['join_date'];
            $details['user_photo'] = $row['user_photo'];
            //replication site config
            $details['facebook'] = $row['user_detail_facebook'];
            $details['twitter'] = $row['user_detail_twitter'];
            //
            if (!file_exists('../backoffice/public_html/images/profile_picture/' . $row['user_photo'])) {
                $details['user_photo'] = 'nophoto.jpg';
            }
        }
        return $details;
    }
    
    public function getBackofficeSession() {
        $cisess_data = array();
        if (isset($_COOKIE['ci_session'])) {
            $cisess_cookie = $_COOKIE['ci_session'];
            $cisess_table = (DEMO_STATUS == 'yes') ? "inf_ci_sessions" : $this->db->dbprefix . "ci_sessions";
            $query = $this->db->query("SELECT data FROM `{$cisess_table}` WHERE id = '$cisess_cookie' LIMIT 1");
            $cisess_data = $query->row_array()['data'];
            $cisess_data = $this->decode_session_data($cisess_data);
        }
        return $cisess_data;
    }

    public function getBackofficeSessionFromFile() {
        $cisess_data = array();
        if (isset($_COOKIE['ci_session'])) {
            $cisess_cookie = $_COOKIE['ci_session'];
            $cisess_file = dirname(FCPATH) . '/backoffice/application/sessions/ci_session' . $cisess_cookie;
            if (is_file($cisess_file)) {
                $handle = fopen($cisess_file, 'r');
                //flock($handle, LOCK_SH);
                $cisess_data = fread($handle, filesize($cisess_file));
                //flock($handle, LOCK_UN);
                fclose($handle);
                $cisess_data = $this->decode_session_data($cisess_data);
            }
        }
        return $cisess_data;
    }
    
    public function checkReplicaStatus($table_prefix) {

        $res = $this->db->query('SELECT replicated_site_status, replicated_site_status_demo FROM ' . $table_prefix . 'module_status WHERE id = 1');
        foreach ($res->result_array() as $row) {
            return ($row['replicated_site_status'] == 'yes' && $row['replicated_site_status_demo'] == 'yes');
        }
    }
    
}
