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

        $order_details = array();
        $shipping_details = array();
        $check_date='';
       
        $base_url = base_url() . "order/order/order_history";
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $page = 0;
        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(4);
        } else {
            $page = 0;
        }

        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;
        $customer_id = $this->validation_model->getOcCustomerId($user_id);
        $this->set("page", $page);
        $total_count = $this->order_model->getOrderHistoryCount($customer_id, $check_date);
        $config['total_rows'] = $total_count;
        $this->pagination->initialize($config);

        $order_details = $this->order_model->getOrderDetails($page, $config['per_page'], $customer_id, $check_date);
      
        $result_per_page = $this->pagination->create_links();
        $this->set("result_per_page", $result_per_page);

        $count = count($order_details);
        $this->set("count", $count);
        $this->set("order_details", $order_details);
        $this->set("shipping_details", $shipping_details);
        $this->set("user_name", $user_name);

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

        $this->load_langauge_scripts();

        $help_link = lang('order_details');
        $this->set("help_link", $help_link);

        $user_id = $this->LOG_USER_ID;
        $flag = TRUE;
        $is_order = $this->order_model->checkOrderExist($order_id);
        if (!is_numeric($order_id) || (!$is_order)) {
            $flag = FALSE;
            $msg = lang('invalid_order_id');
            $this->redirect($msg, "order/my_order", FALSE);
        }
        $customer_id = $this->order_model->getCustomerIdFromOrder($order_id);
        $current_user = $this->validation_model->IdToUserName($user_id);
        $order_details = $this->order_model->getCurrentOrderHistoryDetails($customer_id, $order_id);
        $this->set("order_details", $order_details);
        $count = count($order_details);
        $this->set("count", $count);
        $this->set("current_user", $current_user);
        $this->set("flag", $flag);
        $this->set("order_id", $order_id);
        $this->setView();
    }
    
}
