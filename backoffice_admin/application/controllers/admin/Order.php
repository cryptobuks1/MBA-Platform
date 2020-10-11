<?php

require_once 'Inf_Controller.php';

class order extends Inf_Controller {

    function order_history() {
        $title = lang('order_history');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('order_history');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('order_history');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = lang('order_history');
        $this->set("help_link", $help_link);
        $this->set('action_page', $this->CURRENT_URL);

        $shipping_details = array();
        $user_name = '';
        $customer_id = '';
        $from_date='';
        $to_date='';
        $config = $this->pagination->customize_style();
        $base_url = base_url() . "admin/order/order_history";
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(4);
        } else {
            $page = 0;
        }

        if ($this->input->post('search_member_submit')) {
         if ($this->input->post('user_name')) {
            $order_post_array = $this->input->post(NULL, TRUE);//print_r($order_post_array); die;
            $order_post_array = $this->validation_model->stripTagsPostArray($order_post_array);
            $user_name = $order_post_array['user_name'];
            $user_id = $this->validation_model->userNameToID($user_name);
            $is_exist = $this->validation_model->isUserAvailable($user_id);
            if (!$is_exist) {
                $this->session->unset_userdata('search_user_id');
                $msg = lang('user_name_does_not_exist');
                $this->redirect($msg, "order/order_history", FALSE);
            }
           // $this->session->set_userdata('search_user_id', $user_id);
            //$this->redirect("", "order/order_history_search", FALSE);
         
            $from_date = $order_post_array['week_date1'];
            $to_date =  $order_post_array['week_date2'];
             if (($from_date != '') && ($to_date != '')) {
                if ($from_date > $to_date) {
                    $msg = lang('To-Date should be greater than From-Date');
                    $this->redirect($msg, 'report/subscription_payment_report', FALSE);
                }
            }
            
            
            if ($from_date != '' && $to_date != '') {
                $report_date = lang('from') . "\t" . $from_date . "\t" . lang('to') . "\t" . $to_date;
            } else if ($from_date != '') {
                $report_date = lang('from') . "\t" . $from_date;
            } else if ($to_date != '') {
                $report_date = lang('to') . "\t" . $to_date;
            } else {
                $report_date = '';
            }
            $this->session->set_userdata("inf_commision_week_date1", $from_date);
            
            $this->session->set_userdata("inf_commision_week_date2", $to_date);
            $this->session->set_userdata('search_user_id', $user_id);
            $this->redirect("", "order/order_history_search", FALSE);
         
          
                 }
    
     }
        
        
        $total_count = $this->order_model->getOrderHistoryCount($customer_id);

        $config['total_rows'] = $total_count;
        $this->pagination->initialize($config);
//print_r($config); die;
        $order_details = $this->order_model->getOrderDetails($page, $config['per_page'], $customer_id, $from_date,$to_date);

        $result_per_page = $this->pagination->create_links();
        $this->set("result_per_page", $result_per_page);

        $count = count($order_details);
        $this->set("count", $count);
        $this->set("order_details", $order_details);
        $this->set("shipping_details", $shipping_details);
        $this->set("user_name", $user_name);
        $this->set("page_id", $page);

        $this->set("tran_errors_check", $this->lang->line('errors_check'));

        $this->setView();
    }

    function order_details($order_id) {

        $title = lang('order_details');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('order_details');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('order_details');
        $this->HEADER_LANG['page_small_header'] = '';

        $help_link = lang('order_history');
        $this->set("help_link", $help_link);
        
        $this->load_langauge_scripts();

        $flag1 = TRUE;
        $is_order = $this->order_model->checkOrderExist($order_id);
        if (!is_numeric($order_id) || (!$is_order)) {
            $flag1 = FALSE;
            $msg = lang('invalid_order_id');
            $this->redirect($msg, "order/order_history", FALSE);
        }

        $customer_id = $this->order_model->getCustomerIdFromOrder($order_id);
        $user_id = $this->validation_model->getUserIDFromCustomerID($customer_id);
        $current_user = $this->validation_model->IdToUserName($user_id);
        $order_details = $this->order_model->getCurrentOrderHistoryDetails($customer_id, $order_id);
        $this->set("order_details", $order_details);

        $count = count($order_details);
        $this->set("flag1", $flag1);
        $this->set("count", $count);
        $this->set("current_user", $current_user);
        $this->set("order_id", $order_id);

        $this->set("tran_errors_check", $this->lang->line('errors_check'));

        $this->setView();
    }
    
    function order_activation_pending() {
        $title = lang('order_activation');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('order_activation');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('order_activation');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = lang('order_activation');
        $this->set("help_link", $help_link);
        $this->set('action_page', $this->CURRENT_URL);

        $user_name = '';
        $user_id = '';

        $base_url = base_url() . "admin/order/order_activation_pending";
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(4);
        } else {
            $page = 0;
        }

        if ($this->input->post('view_order')) {
            $order_post_array = $this->input->post(NULL, TRUE);
            $order_post_array = $this->validation_model->stripTagsPostArray($order_post_array);
            $user_name = $order_post_array['user_name'];
            $user_id = $this->validation_model->userNameToID($user_name);
            $is_exist = $this->validation_model->isUserAvailable($user_id);

            if (!$is_exist) {
                $msg = lang('user_name_does_not_exist');
                $this->redirect($msg, "order/order_activation_pending", FALSE);
            }
            $page = 0;
        }

        $this->set("page", $page);
        $total_count = $this->order_model->getPendingRegDetailsCount($user_id);

        $config['total_rows'] = $total_count;
        $this->pagination->initialize($config);

        $reg_details = $this->order_model->getPendingRegDetails($page, $config['per_page'], $user_id); 
        $result_per_page = $this->pagination->create_links();
        $this->set("result_per_page", $result_per_page);

        $count = count($reg_details);
        $this->set("count", $count);
        $this->set("reg_details", $reg_details); 
        $this->set("user_name", $user_name);

        $this->set("tran_errors_check", $this->lang->line('errors_check'));

        $this->setView();
    }

    function order_activation() {
        if ($this->input->post('order_id')) {

            $order_details = array();
            $order_id = $this->input->post('order_id', TRUE);
            $order_status = $this->order_model->getPendingRegStatus($order_id);

            if($order_status =="pending") {
                $this->order_model->begin();
                $reg_details = $this->order_model->getPendingRegDetails(0, 0, 0, $order_id); 
                $reg_details = $reg_details[0];
                $reg_details['customer_id'] = 0;

                $this->load->model("register_model");

                $product_id = 0;
                $product_name = 'NA';
                $product_pv = '0';
                $product_amount = '0';
                $product_validity = date('Y-m-d H:i:s', strtotime('+12 months'));
                $product_status = $this->MODULE_STATUS['product_status'];
                $module_status = $this->MODULE_STATUS;

                if ($product_status == "yes") {
                    $product_id = ($reg_details['product_id']);
                    $this->load->model('product_model');
                    $product_details = $this->product_model->getProductDetails($product_id, 'yes');
                    $product_name = $product_details[0]['product_name'];
                    $product_pv = $product_details[0]['pair_value'];
                    $product_amount = $product_details[0]['product_value'];
                }

                $reg_details['product_status'] = $product_status;
                $reg_details['product_id'] = $product_id;
                $reg_details['product_name'] = $product_name;
                $reg_details['product_pv'] = $product_pv;
                $reg_details['product_amount'] = $product_amount;
                $reg_details['product_validity'] = $product_validity;
                $reg_details['total_amount'] = $reg_details['reg_amount'];

                $reg_details['user_name_type'] = 'static';
                $reg_details['joining_date'] = $reg_details['date_added'];
                $reg_details['payment_type'] = $reg_details['payment_type'];
                $reg_details['registration_fee'] = $this->register_model->getRegisterAmount();
                //$reg_details['reg_from_tree'] = false;
                $reg_details['placement_id']=$this->validation_model->getUserID($reg_details['placement_user_name']);
                $reg_order_updated = false;
//print_r($reg_details);die;
                $status = $this->register_model->confirmRegister($reg_details, $module_status);
                
                if($status['status']) {
                    // Add to customer
                    $customer_id = $this->order_model->addCustomer($reg_details, $module_status['sms_status']);

                    // Update order customer
                    $this->order_model->updateOrderCustomer($reg_details['order_id'], $customer_id);

                    // Add to activity log
                    $activity_data = array(
                        'customer_id' => $customer_id,
                        'ip' => $reg_details['ip'],
                        'date_added' => $reg_details['date_added'],
                        'name' => $reg_details['firstname'] . ' ' . $reg_details['lastname']
                        );
                    $this->order_model->addActivity('register', $activity_data);

                    $reg_details['customer_id'] = $customer_id;

                    $this->order_model->addOrderHistory($reg_details['order_id'], $reg_details['cod_order_status_id']); 
                     $this->order_model->setConfirmOrder($reg_details['order_id']);
                    
                    // Update customer Id
                    $customer_user_id = $this->validation_model->userNameToID($status['user']);
                    $this->order_model->updateCustomerId($customer_user_id, $customer_id);

                    $reg_order_updated = $this->order_model->updateRegOrdeStatus($reg_details['row_id'],'activated');
                }
                if($status['status'] && $reg_order_updated) {
                    $user = $status['user'];
                    $pass = $status['pwd'];
                    $encr_id = $status['id'];
                    $tran_code = $status['tran'];
                    $user_id = $this->validation_model->userNameToID($user);
                    $this->order_model->updateRegPending($reg_details['row_id'], $user_id, $reg_details['payment_type']);

                    if ($product_status == "yes") {
                        $insert_into_sales = $this->register_model->insertIntoSalesOrder($user_id, $reg_details['product_id'], "cod");
                    }
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'New User Registered', $this->LOG_USER_ID, $data = '');
                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $user_id, 'user_register', 'New User Registered');
                    }

                    $serialized_data = serialize($reg_details);
                    $this->order_model->regOrderActivationHistory($user_id, $serialized_data,'user_register');

                    $this->order_model->commit();

                    $msg=  $user . " - ".lang('order_successfully_updated');
                    $this->redirect($msg , "order/order_activation_pending", TRUE);

                }else{
                    $this->order_model->rollback();
                    $msg=  $user . " - ".lang('error_on_order_updation');
                    $this->redirect($msg , "order/order_activation_pending", FALSE);
                } 

            }else{
                $msg = lang('order_already_processed');
                $this->redirect($msg, "order/order_activation_pending", FALSE);
            }
        } else {
            show_404();
        }
    }  
 
    function order_notification($order_id = '') {
        $set_status = $this->order_model->setViewStatus($order_id);
            $this->redirect("", "order/order_history", TRUE);
    }
    function order_history_search() {
        
        $title = lang('order_history');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('order_history');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('order_history');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = lang('order_history');
        $this->set("help_link", $help_link);
        $this->set('action_page', $this->CURRENT_URL);

        $shipping_details = array();
        $user_name = '';
        $customer_id = '';
        $from_date='';
        $to_date='';
        $config = $this->pagination->customize_style();
        $base_url = base_url() . "admin/order/order_history_search";
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(4);
        } else {
            $page = 0;
        }

       if ($this->input->post('search_member_submit')) {
     if ($this->input->post('user_name')) {
            $order_post_array = $this->input->post(NULL, TRUE);
            $order_post_array = $this->validation_model->stripTagsPostArray($order_post_array);
            $user_name = $order_post_array['user_name'];
            $user_id = $this->validation_model->userNameToID($user_name);
            $is_exist = $this->validation_model->isUserAvailable($user_id);
            if (!$is_exist) {
                $this->session->unset_userdata('search_user_id');
                $msg = lang('user_name_does_not_exist');
                $this->redirect($msg, "order/order_history", FALSE);
            }
            $this->session->set_userdata('search_user_id', $user_id);
        }
        
        $from_date = $order_post_array['week_date1'];
            $to_date =  $order_post_array['week_date2'];
             if (($from_date != '') && ($to_date != '')) {
                if ($from_date > $to_date) {
                    $msg = lang('To-Date should be greater than From-Date');
                    $this->redirect($msg, 'report/subscription_payment_report', FALSE);
                }
            }
            
            
            if ($from_date != '' && $to_date != '') {
                $report_date = lang('from') . "\t" . $from_date . "\t" . lang('to') . "\t" . $to_date;
            } else if ($from_date != '') {
                $report_date = lang('from') . "\t" . $from_date;
            } else if ($to_date != '') {
                $report_date = lang('to') . "\t" . $to_date;
            } else {
                $report_date = '';
            }
        
 }

        if($this->session->has_userdata('search_user_id')) {
            $customer_id = $this->validation_model->getOcCustomerId($this->session->userdata('search_user_id'));
            $user_name = $this->validation_model->IdToUserName($this->session->userdata('search_user_id'));
        }
        /*if($this->session->has_userdata('inf_commision_week_date1')) {
            $from_date= $this->session->userdata('inf_commision_week_date1');
            
        }if($this->session->has_userdata('inf_commision_week_date2')) {
            $to_date= $this->session->userdata('inf_commision_week_date2');
            
        }*/
        $total_count = $this->order_model->getOrderHistoryCount($customer_id);

        $config['total_rows'] = $total_count;
        $this->pagination->initialize($config);

        $order_details = $this->order_model->getOrderDetails($page, $config['per_page'], $customer_id,$from_date,$to_date);

        $result_per_page = $this->pagination->create_links();
        $this->set("result_per_page", $result_per_page);

        $count = count($order_details);
        $this->set("count", $count);
        $this->set("order_details", $order_details);
        $this->set("shipping_details", $shipping_details);
        $this->set("user_name", $user_name);
        $this->set("page_id", $page);

        $this->set("tran_errors_check", $this->lang->line('errors_check'));

        $this->setView('admin/order/order_history');
    }
//by neenu
    function purchase_activation_pending() {
        $title = lang('order_activation');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('purchase_activation_pending');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('purchase_activation_pending');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = lang('purchase_activation_pending');
        $this->set("help_link", $help_link);
        $this->set('action_page', $this->CURRENT_URL);

        $user_name = '';
        $user_id = '';

        $base_url = base_url() . "admin/order/purchase_activation_pending";
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(4);
        } else {
            $page = 0;
        }

        if ($this->input->post('view_order')) {
            $order_post_array = $this->input->post(NULL, TRUE);
            $order_post_array = $this->validation_model->stripTagsPostArray($order_post_array);
            $user_name = $order_post_array['user_name'];
            $user_id = $this->validation_model->userNameToID($user_name);
            $is_exist = $this->validation_model->isUserAvailable($user_id);

            if (!$is_exist) {
                $msg = lang('user_name_does_not_exist');
                $this->redirect($msg, "order/order_activation_pending", FALSE);
            }
            $page = 0;
        }

        $this->set("page", $page);
        $total_count = $this->order_model->getPendingPurchaseDetailsCount();

        $config['total_rows'] = $total_count;
        $this->pagination->initialize($config);

        $reg_details = $this->order_model->getPendingPurchaseDetails($page, $config['per_page']); 
        $result_per_page = $this->pagination->create_links();
        $this->set("result_per_page", $result_per_page);

        $count = count($reg_details);
        $this->set("count", $count);
        $this->set("reg_details", $reg_details); 
        $this->set("user_name", $user_name);

        $this->set("tran_errors_check", $this->lang->line('errors_check'));

        $this->setView();
    }
    function purchase_activation() {   
        if ($this->input->post('order_id')) {

            $order_details = array(); 
            $sms_status = $this->MODULE_STATUS['sms_status'];

            $order_id = $this->input->post('order_id', TRUE);
            $obj_arr = $this->configuration_model->getSettings();
            $order_status = $this->order_model->getPendingPurchaseStatus($order_id);
            if($order_status ==1){
                $reg_details = $this->order_model->getPendingPurchaseDetails('', '', $order_id); 

                $module_status = $this->MODULE_STATUS;
                $res = $this->configuration_model->activateOrder($reg_details,$module_status);
               
           
                $this->order_model->setConfirmOrder($order_id);
               $msg = lang('Order Confirmed Successfully');
               $this->redirect($msg, "order/purchase_activation_pending", TRUE);
           }else{
                $msg = lang('order_already_processed');
                $this->redirect($msg, "order/purchase_activation_pending", FALSE);
            }
        } else {
            show_404();
        }
    }
}
