<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['post_controller_constructor'] = function() {

    $CI = &get_instance();

    $join_type = $CI->validation_model->getUserJoinType($CI->LOG_USER_ID);

   //  print_r($join_type); die;

    $url = $CI->CURRENT_CTRL . '/' . $CI->CURRENT_MTD;
    $CI->db->select("im.id, im.link_ref_id");
    $CI->db->from("infinite_mlm_menu as im");
    $CI->db->join("infinite_urls as iu", "iu.id=im.link_ref_id", "inner");
    $CI->db->where('iu.link', $url);
    $query = $CI->db->get();

    foreach ($query->result() as $row) {
    //print_r($row); die;
        if ($join_type == 'customer') {

            if (!in_array($row->id, array('1','19','52','53','73','34','35','42','69','23','24'))) {//disabling all menus other than Dashboard, downlines, Logout
               
            $msg = lang("you_not_have_permission_to_access_this_page");
                $CI->redirect($msg, 'user/index', false);
            }

         if (!in_array($row->link_ref_id, array('7','19','89','98','289','95','4'))) {
           
            $msg = lang("you_not_have_permission_to_access_this_page");
            $CI->redirect($msg, 'user/index', false);
        }
    }
        /*if($kyc_status == 'yes'){
            if (in_array($row->id, array('59'))) {//disabling all menus other than Dashboard, downlines Logout
                $msg = "you don't have permission to access this page";
                $CI->redirect($msg, 'home', false);
        }
        if (in_array($row->link_ref_id, array('223'))) {
            $msg = "you don't have permission to access this page";
            $CI->redirect($msg, 'home', false);
        }
        }*/
    }
    
    $CI->db->select("is.sub_id,is.sub_link_ref_id");
    $CI->db->from("infinite_mlm_sub_menu as is");
    $CI->db->join("infinite_urls as iu", "iu.id=is.sub_link_ref_id", "inner");
    $CI->db->where('iu.link', $url);
    $query = $CI->db->get();
    
    foreach ($query->result() as $row) {
        if ($join_type == 'customer') {
            if (!in_array($row->sub_link_ref_id, array('4','7','58','59','61','19','226','289','287'))) {
                $msg = lang("you_not_have_permission_to_access_this_page");
                $CI->redirect($msg, 'user/index', false);
            }
        }
    }

    return true;
};