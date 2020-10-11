<?php

require_once 'Inf_Controller.php';

class Product extends Inf_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->url_permission('product_status');
    }

    public function membership_package()
    {
        $title = lang('membership_package');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'product-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('membership_package');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('membership_package');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $package_type = 'registration';
        $pro_status = 'yes';
        if ($this->input->post('refine')) {
            $pro_status = $this->input->post('pro_status', true);
            $this->session->set_userdata('inf_pro_status', $pro_status);
        } else if ($this->session->userdata('inf_pro_status')) {
            $pro_status = $this->session->userdata('inf_pro_status');
        }

        $pv_visible = 'no';
        $bv_visible = 'no';
        if ($this->MLM_PLAN == 'Binary') {
            $pv_visible = 'yes';
        }
        if ($this->MLM_PLAN == 'Unilevel' || $this->MLM_PLAN == 'Matrix' || $this->MLM_PLAN == 'Stair_Step' || ($this->MODULE_STATUS['sponsor_commission_status'] == 'yes' && $this->MLM_PLAN != 'Binary')) {
            $bv_visible = 'yes';
        }

        $config = $this->pagination->customize_style();
        $base_url = base_url() . 'admin/product/membership_package';
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $tot_rows = $this->product_model->getPackageCount($package_type, $pro_status);

        $config['total_rows'] = $tot_rows;
        $config['uri_segment'] = 4;

        $this->pagination->initialize($config);
        $page = 0;
        if ($this->uri->segment(4) != '') {
            $page = $this->uri->segment(4);
        }

        $product_details = $this->product_model->getPackageList($package_type, $pro_status, $config['per_page'], $page);

        $commission_type = $this->validation_model->getConfig('sponsor_commission_type');
        $this->set('commission_type', $commission_type);
        $this->set('product_details', $this->security->xss_clean($product_details));
        $this->set('sub_status', $pro_status);

        $result_per_page = $this->pagination->create_links();
        $this->set('result_per_page', $result_per_page);
        $this->set('page', $page);
        $this->set('pv_visible', $pv_visible);
        $this->set('bv_visible', $bv_visible);
        $this->set('mlm_plan', $this->MLM_PLAN);

        $this->setView();
    }

    public function add_membership_package()
    {
        $title = lang('add_membership_package');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'product-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('add_membership_package');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('add_membership_package');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        
        $package_type = 'registration';
        $pv_visible = 'no';
        $bv_visible = 'no';
        $roi = 0;
        $days = 0;

        if ($this->MLM_PLAN == 'Binary') {
            $pv_visible = 'yes';
        }
        if ($this->MLM_PLAN == 'Unilevel' || $this->MLM_PLAN == 'Matrix' || $this->MLM_PLAN == 'Stair_Step' || ($this->MODULE_STATUS['sponsor_commission_status'] == 'yes' && $this->MLM_PLAN != 'Binary')) {
            $bv_visible = 'yes';
        }
        $obj_arr = $this->validation_model->getConfig(['commission_upto_level','commission_criteria','level_commission_type','matching_upto_level','sales_level']);
        $rank_configuration = $this->configuration_model->getRankConfiguration();
        $commission_type = $this->validation_model->getConfig('sponsor_commission_type');

        $rank_details = $this->configuration_model->getAllRankDetails();
        
        $compensation_status = $this->validation_model->getCompensationConfig(['plan_commission_status,sponsor_commission_status,rank_commission_status,referal_commission_status,roi_commission_status,matching_bonus,sales_commission']);
        $this->set('compensation_status', $compensation_status);

        $this->set('obj_arr', $obj_arr);
        $this->set('rank_configuration', $rank_configuration);
        $this->set('rank_details', $rank_details);

        if ($this->MODULE_STATUS['product_status'] == "yes" || ($this->MODULE_STATUS['opencart_status'] == "yes" && $this->MODULE_STATUS['opencart_status_demo'] == "yes")) {
            $pck_array = $this->configuration_model->getLevelCommissionPackages();
        }

        if ($this->input->post() && $this->validate_add_membership_package()) {
            $post_arr = $this->input->post(null, true);
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $prod_name = $post_arr['prod_name'];
            $commission_level = $obj_arr['commission_upto_level'];
            $sales_level = $obj_arr['sales_level'];
            $product_amount = round((floatval($post_arr['product_amount']) / $this->DEFAULT_CURRENCY_VALUE), 8);
            $pair_value = $pair_price = $bv_value = $referral_commission = $joinee_commission = 0;
            
            if ($pv_visible == 'yes') {
                $pair_value = $bv_value = $post_arr['pair_value'];
            }
            if ($bv_visible == 'yes') {
                $pair_value = $bv_value = $post_arr['bv_value'];
            }
            if ($this->MLM_PLAN == 'Binary' && $compensation_status['plan_commission_status'] =='yes') {
                $pair_price = $post_arr['pair_price'];
            }
            if ($this->MODULE_STATUS['referal_status'] == 'yes' && $compensation_status['referal_commission_status'] =='yes') {
                if ($commission_type == 'sponsor_package' || $commission_type == 'joinee_package') {
                    $referral_commission = $post_arr['referral_commission'];
                }
            }
            $package_id = $post_arr['package_id'];
            if ($this->MODULE_STATUS['product_validity'] == 'yes') {
                $package_validity = $post_arr['package_validity'];
                if ($package_validity <= 0) {
                    $redirect_msg = lang('package_validity_should_be_a_positive_number');
                    $this->redirect($redirect_msg, 'product/add_membership_package', false);
                }
            } else {
                $package_validity = "0";
            }

            if ($this->MODULE_STATUS['roi_status'] == 'yes' && $compensation_status['roi_commission_status'] =='yes') {
                $roi = $post_arr['roi'];
                $days = $post_arr['days'];
            }

            $result = $this->product_model->addProduct($prod_name, $product_amount, $pair_value, $bv_value, $package_type, $package_validity, $package_id, $referral_commission, $pair_price, $roi, $days);
            if ($result) {
                $this->product_model->insertPackageLevelCommissions($package_id, $post_arr, $commission_level);
                $this->product_model->insertPackageSalesCommissions($package_id, $post_arr, $sales_level);
                $this->product_model->insertMatchingBonus($package_id, $post_arr,$obj_arr['matching_upto_level']);

                if($this->MODULE_STATUS['rank_status'] == 'yes' && $rank_configuration['joinee_package'] || $rank_configuration['downline_purchase_count']) {
                    $this->product_model->insertRankCommissions($package_id, $post_arr, $rank_configuration['downline_purchase_count'], $rank_configuration['joinee_package']);
                }

                $data = serialize($post_arr);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'membership package added', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'add_membership_package', 'Membership Package Added');
                }
                //

                $redirect_msg = lang('product_added_successfully');
                $this->redirect($redirect_msg, 'product/membership_package', true);
            } else {
                $redirect_msg = lang('error_on_adding_product');
                $this->redirect($redirect_msg, 'product/add_membership_package', false);
            }
        }

        // print_r($count); die;
        $this->set('commission_type', $commission_type);
        $this->set('pv_visible', $pv_visible);
        $this->set('bv_visible', $bv_visible);
        $this->set('mlm_plan', $this->MLM_PLAN);
        $this->setView();
    }

    public function edit_membership_package($id = '')
    {
        $title = lang('update_membership_package');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'product-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('update_membership_package');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('update_membership_package');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $package_type = 'registration';
        if ($this->input->method() == 'post') {
            $id = $this->input->post('product_id', true);
        }
        $package_details = $this->product_model->getPackageDetails($id, $package_type);
        if (!$package_details) {
            $redirect_msg = lang('package_not_available');
            $this->redirect($redirect_msg, 'product/membership_package', false);
        }
        $commission_type = $this->validation_model->getConfig('sponsor_commission_type');

        $pv_visible = 'no';
        $bv_visible = 'no';
        $roi = 0;
        $days = 0;

        if ($this->MLM_PLAN == 'Binary') {
            $pv_visible = 'yes';
        }
        if ($this->MLM_PLAN == 'Unilevel' || $this->MLM_PLAN == 'Matrix' || $this->MLM_PLAN == 'Stair_Step' || ($this->MODULE_STATUS['sponsor_commission_status'] == 'yes' && $this->MLM_PLAN != 'Binary')) {
            $bv_visible = 'yes';
        }

        if ($this->input->post('update_prod') && $this->validate_add_membership_package()) {
            $post_arr = $this->input->post(null, true);
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $prod_name = $post_arr['prod_name'];
            $product_amount = round((floatval($post_arr['product_amount']) / $this->DEFAULT_CURRENCY_VALUE), 8);
            $pair_value = $bv_value = $referral_commission = $joinee_commission = 0;
            if ($pv_visible == 'yes') {
                $pair_value = $bv_value = $post_arr['pair_value'];
            }
            if ($bv_visible == 'yes') {
                $pair_value = $bv_value = $post_arr['bv_value'];
            }
            $package_id = $post_arr['package_id'];
            $product_id = $post_arr['product_id'];
            if ($this->MODULE_STATUS['product_validity'] == 'yes') {
                $package_validity = $post_arr['package_validity'];
                if ($package_validity <= 0) {
                    $redirect_msg = lang('package_validity_should_be_a_positive_number');
                    $this->redirect($redirect_msg, 'product/edit_membership_package/' . $id, false);
                }
            } else {
                $package_validity = "0";
            }

            $result = $this->product_model->updateProduct($product_id, $prod_name, $product_amount, $pair_value, $bv_value, $package_type, $package_validity, $package_id);
            if ($result) {
                $data = serialize($post_arr);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'membership package updated', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_membership_package', 'Membership Package Updated');
                }
                //
                //insert configuration_change_history

                $package_history = "Updated Package configuration as its ";
                $flag = false;
                if ($package_details['product_name'] != $prod_name) {
                    $package_history .= lang('product_name') . " : " . $prod_name;
                    $flag = true;
                }
                if ($package_details['product_value'] != $product_amount) {
                    if ($flag)
                        $package_history .= " , ";
                    $package_history .= lang('amount') . " : " . $product_amount;
                    $flag = true;
                }
                if ($pv_visible == 'yes') {
                    if ($package_details['pair_value'] != $pair_value) {
                        if ($flag)
                            $package_history .= " , ";
                        $package_history .= lang('pair_value') . " : " . $pair_value;
                        $flag = true;
                    }
                }
                if ($bv_visible == 'yes') {
                    if ($package_details['bv_value'] != $pair_value) {
                        if ($flag)
                            $package_history .= " , ";
                        $package_history .= lang('bv_value') . " : " . $pair_value;
                        $flag = true;
                    }
                }
                if ($this->MODULE_STATUS['product_validity'] == 'yes') {
                    if ($package_details['package_validity'] != $package_validity) {
                        if ($flag)
                            $package_history .= " , ";
                        $package_history .= lang('package_validity') . " : " . $package_validity;
                        $flag = true;
                    }
                }
                if ($flag)
                    $this->configuration_model->insertConfigChangeHistory('Package settings', $package_history);
                $package_history = "";
                //

                $redirect_msg = lang('product_updated_successfully');
                $this->redirect($redirect_msg, 'product/membership_package', true);
            } else {
                $redirect_msg = lang('error_on_updating_product');
                $this->redirect($redirect_msg, 'product/edit_membership_package', false);
            }
        }

        $this->set('commission_type', $commission_type);
        $this->set('package_details', $package_details);
        $this->set('pv_visible', $pv_visible);
        $this->set('bv_visible', $bv_visible);
        $this->set('mlm_plan', $this->MLM_PLAN);
        $this->setView();
    }

    public function activate_membership_package()
    {
        if ($this->input->post('product_id')) {
            $product_id = $this->input->post('product_id', true);
            $result = $this->product_model->activateProduct($product_id);
            if ($result) {
                $data_array = array();
                $data_array['product_id'] = $product_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'membership package activated', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'activate_membership_package', 'Membership Package Activated');
                }
                //

                $package_history = sprintf(lang('activate_register_package_n'), $this->product_model->getPackageId($product_id, "registration"));
                $this->configuration_model->insertConfigChangeHistory('Package settings', $package_history);

                $redirect_msg = lang('product_activated_successfully');
                $this->redirect($redirect_msg, 'product/membership_package', true);
            } else {
                $redirect_msg = lang('error_on_activating_product');
                $this->redirect($redirect_msg, 'product/membership_package', false);
            }
        }
    }

    public function inactivate_membership_package()
    {
        if ($this->input->post('product_id')) {
            $product_id = $this->input->post('product_id', true);
            $result = $this->product_model->inactivateProduct($product_id);
            if ($result) {
                $data_array = array();
                $data_array['product_id'] = $product_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'membership package deactivated', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'inactivate_membership_package', 'Membership Package Deactivated');
                }
                //
                $package_history = sprintf(lang('inactivate_register_package_n'), $this->product_model->getPackageId($product_id, "registration"));
                $this->configuration_model->insertConfigChangeHistory('Package settings', $package_history);

                $redirect_msg = lang('product_inactivated_successfully');
                $this->redirect($redirect_msg, 'product/membership_package', true);
            } else {
                $redirect_msg = lang('error_on_inactivating_product');
                $this->redirect($redirect_msg, 'product/membership_package', false);
            }
        }
    }

    public function delete_membership_package()
    {
        if ($this->input->post('product_id')) {
            $product_id = $this->input->post('product_id', true);
            $result = $this->product_model->deleteProduct($product_id);
            if ($result) {
                $data_array = array();
                $data_array['product_id'] = $product_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'membership package deleted', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'delete_membership_package', 'Membership Package Deleted');
                }
                //

                $redirect_msg = lang('product_deleted_successfully');
                $this->redirect($redirect_msg, 'product/membership_package', true);
            } else {
                $redirect_msg = lang('error_on_delete_product');
                $this->redirect($redirect_msg, 'product/membership_package', false);
            }
        }
    }

    function validate_membership_package()
    {
        $this->form_validation->set_rules('prod_name', lang('product_name'), 'trim|required|callback_valid_package_name[registration]');
        $this->form_validation->set_rules('product_amount', lang('product_amount'), 'trim|required|greater_than[0]|max_length[5]');
        $this->form_validation->set_rules('package_id', lang('package_id'), 'trim|required|alpha_numeric|callback_valid_package_id[registration]');
        if ($this->MODULE_STATUS['product_validity'] == 'yes') {
            $this->form_validation->set_rules('package_validity', lang('package_validity'), 'trim|required|integer|greater_than[0]|max_length[5]');
        }
        if ($this->MODULE_STATUS['referal_status'] == "yes") {
            $commission_type = $this->validation_model->getConfig('sponsor_commission_type');
            if ($commission_type == 'sponsor_package' || $commission_type == 'joinee_package') {
                $this->form_validation->set_rules('referral_commission', lang('referral_commission'), 'trim|required|greater_than_equal_to[0]');
            }
        }
        if ($this->MODULE_STATUS['mlm_plan'] == "Binary") {
            $this->form_validation->set_rules('pair_value', lang('pair_value'), 'trim|required|greater_than_equal_to[0]|max_length[5]');
        }
        if ($this->MODULE_STATUS['mlm_plan'] == 'Unilevel' || $this->MODULE_STATUS['mlm_plan'] == 'Matrix' || $this->MODULE_STATUS['mlm_plan'] == 'Stair_Step' || ($this->MODULE_STATUS['sponsor_commission_status'] == 'yes' && $this->MODULE_STATUS['mlm_plan'] != 'Binary')) {
            $this->form_validation->set_rules('bv_value', lang('bv_value'), 'trim|required|greater_than_equal_to[0]|max_length[5]');
        }
        if ($this->MODULE_STATUS['roi_status'] == "yes") {
            $this->form_validation->set_rules('roi', lang('roi'), 'trim|required|greater_than[0]|max_length[5]');
            $this->form_validation->set_rules('days', lang('days'), 'trim|required|integer|greater_than[0]|max_length[5]');
        }

        return $this->form_validation->run();
    }

    function validate_add_membership_package()
    {

        $this->form_validation->set_rules('prod_name', lang('product_name'), 'trim|required|callback_valid_package_name[registration]');
        $this->form_validation->set_rules('product_amount', lang('product_amount'), 'trim|required|greater_than[0]|max_length[5]');
        $this->form_validation->set_rules('package_id', lang('package_id'), 'trim|required|alpha_numeric|callback_valid_package_id[registration]');
        if ($this->MODULE_STATUS['product_validity'] == 'yes') {
            $this->form_validation->set_rules('package_validity', lang('package_validity'), 'trim|required|integer|greater_than[0]|max_length[5]');
        }
        if ($this->MODULE_STATUS['mlm_plan'] == "Binary") {
            $this->form_validation->set_rules('pair_value', lang('pair_value'), 'trim|required|greater_than_equal_to[0]|max_length[5]');
        }
        if ($this->MODULE_STATUS['mlm_plan'] == 'Unilevel' || $this->MODULE_STATUS['mlm_plan'] == 'Matrix' || $this->MODULE_STATUS['mlm_plan'] == 'Stair_Step' || ($this->MODULE_STATUS['sponsor_commission_status'] == 'yes' && $this->MODULE_STATUS['mlm_plan'] != 'Binary')) {
            $this->form_validation->set_rules('bv_value', lang('bv_value'), 'trim|required|greater_than_equal_to[0]|max_length[5]');
        }

        if($this->input->post('advanced_package')) {
            $obj_arr = $this->validation_model->getConfig(['commission_upto_level','commission_criteria','level_commission_type','matching_upto_level','sales_level']);
            $rank_configuration = $this->configuration_model->getRankConfiguration();
            $compensation_status = $this->validation_model->getCompensationConfig(['plan_commission_status,sponsor_commission_status,rank_commission_status,referal_commission_status,roi_commission_status,matching_bonus','sales_commission']);

            if ($this->MODULE_STATUS['mlm_plan'] == "Binary" && $compensation_status['plan_commission_status'] == "yes") {
                $this->form_validation->set_rules('pair_price', lang('pair_price'), 'trim|required|greater_than_equal_to[0]|max_length[5]');
            }

            if ($this->MODULE_STATUS['sponsor_commission_status'] == "yes" && $compensation_status['sponsor_commission_status'] == "yes") {
                $level = $obj_arr['commission_upto_level'];
                $level_commission_type = $obj_arr['level_commission_type'];
                for ($i = 1; $i <= $level; $i++) {
                    if ($level_commission_type == 'percentage') {
                        $this->form_validation->set_rules("level{$i}", lang('level_commission'), 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]');
                    } elseif ($level_commission_type == 'flat') {
                        $this->form_validation->set_rules("level{$i}", lang('level_commission'), 'trim|required|greater_than_equal_to[0]|max_length[5]');
                    }
                }
            }

            if ($this->MODULE_STATUS['rank_status'] == "yes" && $compensation_status['rank_commission_status'] == "yes" && $rank_configuration['downline_purchase_count'] || $rank_configuration['joinee_package']) {
                //$this->form_validation->set_rules('rank_name', lang('rank_name'), 'trim|required');
                if($rank_configuration['downline_purchase_count']) {
                    $rank_details = $this->configuration_model->getAllRankDetails();
                    foreach ($rank_details as $rank) {
                        $rank_id = $rank['rank_id'];
                        $this->form_validation->set_rules("rank_count" . $rank_id, lang('minimum_count_dwn_pck'), 'trim|required|greater_than[0]|less_than_equal_to[100]');
                    }
                }
            }
            
            if ($this->MODULE_STATUS['referal_status'] == "yes" && $compensation_status['rank_commission_status'] == "yes") {
                $commission_type = $this->validation_model->getConfig('sponsor_commission_type');
                if ($commission_type == 'sponsor_package' || $commission_type == 'joinee_package') {
                    $this->form_validation->set_rules('referral_commission', lang('referral_commission'), 'trim|required|greater_than_equal_to[0]');
                }
            }
            if ($this->MODULE_STATUS['roi_status'] == "yes" && $compensation_status['roi_commission_status'] == "yes") {
                $this->form_validation->set_rules('roi', lang('roi'), 'trim|required|greater_than[0]|max_length[5]');
                $this->form_validation->set_rules('days', lang('days'), 'trim|required|integer|greater_than[0]|max_length[5]');
            }
            if ($compensation_status['matching_bonus'] == "yes") {
                $level = $obj_arr['matching_upto_level'];
                for ($j = 1; $j <= $level; $j++) {
                    $this->form_validation->set_rules("matching_bonus" . $j, lang('matching_bonus') , 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]');
                }
            }
            if ($compensation_status['sales_commission'] == "yes") {
                $level = $obj_arr['sales_level'];
                for ($j = 1; $j <= $level; $j++) {
                    $this->form_validation->set_rules("sales_commission" . $j, lang('sales_commission') , 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]');
                }
            }
        }
        return $this->form_validation->run();
    }

    public function repurchase_package()
    {
        $title = lang('repurchase_package');
        $hyip_title = lang('deposit');
        $help_link = 'product-management';
        $this->set('help_link', $help_link);

        if ($this->MLM_PLAN == 'Unilevel' && $this->MODULE_STATUS['hyip_status'] == 'yes') {
            $this->set("title", $this->COMPANY_NAME . " | $hyip_title");

            $this->HEADER_LANG['page_top_header'] = $hyip_title;
            $this->HEADER_LANG['page_top_small_header'] = '';
            $this->HEADER_LANG['page_header'] = $hyip_title;
            $this->HEADER_LANG['page_small_header'] = '';
        } else {
            $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

            $this->HEADER_LANG['page_top_header'] = lang('cart');
            $this->HEADER_LANG['page_top_small_header'] = '';
            $this->HEADER_LANG['page_header'] = lang('repurchase_package');
            $this->HEADER_LANG['page_small_header'] = '';
        }
        $this->load_langauge_scripts();

        $package_type = 'repurchase';
        $pro_status = 'yes';
        if ($this->input->post('refine')) {
            $pro_status = $this->input->post('pro_status', true);
            $this->session->set_userdata('inf_pro_status', $pro_status);
        } else if ($this->session->userdata('inf_pro_status')) {
            $pro_status = $this->session->userdata('inf_pro_status');
        }

        $pv_visible = 'no';
        $bv_visible = 'no';
        if ($this->MLM_PLAN == 'Binary') {
            $pv_visible = 'yes';
        }
        if ($this->MLM_PLAN == 'Unilevel' || $this->MLM_PLAN == 'Matrix' || $this->MLM_PLAN == 'Stair_Step' || ($this->MODULE_STATUS['sponsor_commission_status'] == 'yes' && $this->MLM_PLAN != 'Binary')) {
            $bv_visible = 'yes';
        }

        $config = $this->pagination->customize_style();
        $base_url = base_url() . 'admin/product/repurchase_package';
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $tot_rows = $this->product_model->getPackageCount($package_type, $pro_status);

        $config['total_rows'] = $tot_rows;
        $config['uri_segment'] = 4;

        $this->pagination->initialize($config);
        $page = 0;
        if ($this->uri->segment(4) != '') {
            $page = $this->uri->segment(4);
        }

        $product_details = $this->product_model->getPackageList($package_type, $pro_status, $config['per_page'], $page);
        for ($i = 0; $i < count($product_details); $i++) {
            $category_name = $this->product_model->getCategoryName($product_details[$i]['category_id']);
            $product_details[$i]['category_name'] = $category_name;
            if (!file_exists(IMG_DIR . 'product_img/' . $product_details[$i]['prod_img'])) {
                $product_details[$i]['prod_img'] = null;
            }
        }
        $this->set('product_details', $this->security->xss_clean($product_details));
        $this->set('sub_status', $pro_status);

        $result_per_page = $this->pagination->create_links();
        $this->set('result_per_page', $result_per_page);
        $this->set('page', $page);
        $this->set('pv_visible', $pv_visible);
        $this->set('bv_visible', $bv_visible);
        $this->set('mlm_plan', $this->MLM_PLAN);
        $this->set('pro_status', $pro_status);

        $this->setView();
    }

    public function add_repurchase_package()
    {
        $title = lang('add_repurchase_package');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'product-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('add_repurchase_package');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('add_repurchase_package');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $package_type = 'repurchase';
        $pv_visible = 'no';
        $bv_visible = 'no';
        if ($this->MLM_PLAN == 'Binary') {
            $pv_visible = 'yes';
        }
        if ($this->MLM_PLAN == 'Unilevel' || $this->MLM_PLAN == 'Matrix' || $this->MLM_PLAN == 'Stair_Step' || ($this->MODULE_STATUS['sponsor_commission_status'] == 'yes' && $this->MLM_PLAN != 'Binary')) {
            $bv_visible = 'yes';
        }
        $categories = $this->product_model->getCategories();
        if ($this->input->post('submit_prod') && $this->validate_repurchase_package()) {
            $post_arr = $this->input->post(null, true);
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $img_name = '';
            // upload product image
            if ($_FILES['upload_doc']['error'] != 4) {
                if (!empty($_FILES['upload_doc'])) {
                    $upload_config = $this->validation_model->getUploadConfig();
                    $upload_count = $this->validation_model->getUploadCount($this->LOG_USER_ID);
                    if ($upload_count >= $upload_config) {
                        $msg = lang('you_have_reached_max_upload_limit');
                        $this->redirect($msg, "product/add_repurchase_package", false);
                    }
                }
                $this->load->library('upload');
                $random_number = floor($this->LOG_USER_ID * rand(1000, 9999));
                $config['file_name'] = "doc_" . $random_number;
                $config['upload_path'] = IMG_DIR . 'product_img';
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = '2048';
                $config['max_width'] = '3000';
                $config['max_height'] = '3000';

                $this->upload->initialize($config);
                $result = '';
                if (!$this->upload->do_upload('upload_doc')) {
                    $msg = $this->upload->display_errors();
                    $this->redirect($msg, 'product/add_repurchase_package', false);
                } else {
                    $data = array('upload_data' => $this->upload->data());
                    $img_name = $data['upload_data']['file_name'];
                    $this->validation_model->updateUploadCount($this->LOG_USER_ID);
                }
            }

            $prod_name = $post_arr['prod_name'];
            $product_amount = round((floatval($post_arr['product_amount']) / $this->DEFAULT_CURRENCY_VALUE), 8);
            $pair_value = $bv_value = 0;
            if ($pv_visible == 'yes') {
                $pair_value = $bv_value = $post_arr['pair_value'];
            }
            if ($bv_visible == 'yes') {
                $pair_value = $bv_value = $post_arr['bv_value'];
            }
            $package_id = $post_arr['package_id'];
            // if ($this->MODULE_STATUS['product_validity'] == 'yes') {
            //     $package_validity = $post_arr['package_validity'];
            //     if ($package_validity <= 0) {
            //         $redirect_msg = lang('package_validity_should_be_a_positive_number');
            //         $this->redirect($redirect_msg, 'product/add_repurchase_package', false);
            //     }
            // } else {
            //     $package_validity = "0";
            // }
            $package_validity = "0";
            $description = $post_arr['description'];
            $category_id = $post_arr['category'];

            $result = $this->product_model->addProduct($prod_name, $product_amount, $pair_value, $bv_value, $package_type, $package_validity, $package_id, 0, 0, 0, 0, $img_name, $description, $category_id);
            if ($result) {
                $data = serialize($post_arr);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Purchase package added', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'add_repurchase_package', 'Purchase Package Added');
                }
                //

                $redirect_msg = lang('product_added_successfully');
                $this->redirect($redirect_msg, 'product/repurchase_package', true);
            } else {
                $redirect_msg = lang('error_on_adding_product');
                $this->redirect($redirect_msg, 'product/add_repurchase_package', false);
            }
        }

        $this->set('pv_visible', $pv_visible);
        $this->set('bv_visible', $bv_visible);
        $this->set('categories', $categories);
        $this->set('mlm_plan', $this->MLM_PLAN);
        $this->setView();
    }

    public function edit_repurchase_package($id = '')
    {
        $title = lang('update_repurchase_package');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'product-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('update_repurchase_package');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('update_repurchase_package');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $package_type = 'repurchase';
        if ($this->input->method() == 'post') {
            $id = $this->input->post('product_id', true);
        }
        $categories = $this->product_model->getCategories();
        $package_details = $this->product_model->getPackageDetails($id, $package_type);
        if (!$package_details) {
            $redirect_msg = lang('package_not_available');
            $this->redirect($redirect_msg, 'product/repurchase_package', false);
        }
        $this->set('package_details', $package_details);

        $pv_visible = 'no';
        $bv_visible = 'no';
        if ($this->MLM_PLAN == 'Binary') {
            $pv_visible = 'yes';
        }
        if ($this->MLM_PLAN == 'Unilevel' || $this->MLM_PLAN == 'Matrix' || $this->MLM_PLAN == 'Stair_Step' || ($this->MODULE_STATUS['sponsor_commission_status'] == 'yes' && $this->MLM_PLAN != 'Binary')) {
            $bv_visible = 'yes';
        }

        if ($this->input->post('update_prod') && $this->validate_repurchase_package()) {
            $post_arr = $this->input->post(null, true);
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);

            $img_name = $package_details['prod_img'];
            // upload product image

            if ($_FILES) {
                if ($_FILES['upload_doc']['name'] != '') {
                    $upload_config = $this->validation_model->getUploadConfig();
                    $upload_count = $this->validation_model->getUploadCount($this->LOG_USER_ID);
                    // if ($upload_count >= $upload_config) {
                    //     $msg = lang('you_have_reached_max_upload_limit');
                    //     $this->redirect($msg, "product/add_repurchase_package", false);
                    // }
                    $this->load->library('upload');
                    $random_number = floor($this->LOG_USER_ID * rand(1000, 9999));
                    $config['file_name'] = "pro_" . $random_number;
                    $config['upload_path'] = IMG_DIR . 'product_img';
                    $config['allowed_types'] = 'jpg|png|jpeg|gif';
                    $config['max_size'] = '2048';
                    $config['max_width'] = '3000';
                    $config['max_height'] = '3000';

                    $this->upload->initialize($config);
                    $result = '';
                    if (!$this->upload->do_upload('upload_doc')) {
                        $msg = $this->upload->display_errors();
                        $this->redirect($msg, 'product/add_repurchase_package', false);
                    } else {
                        $data = array('upload_data' => $this->upload->data());
                        $img_name = $data['upload_data']['file_name'];
                        $this->validation_model->updateUploadCount($this->LOG_USER_ID);
                    }
                }
            }
            $prod_name = $post_arr['prod_name'];
            $product_amount = round((floatval($post_arr['product_amount']) / $this->DEFAULT_CURRENCY_VALUE), 8);
            $pair_value = $bv_value = 0;
            if ($pv_visible == 'yes') {
                $pair_value = $bv_value = $post_arr['pair_value'];
            }
            if ($bv_visible == 'yes') {
                $pair_value = $bv_value = $post_arr['bv_value'];
            }
            $package_id = $post_arr['package_id'];
            $product_id = $post_arr['product_id'];
            // if ($this->MODULE_STATUS['product_validity'] == 'yes') {
            //     $package_validity = $post_arr['package_validity'];
            //     if ($package_validity <= 0) {
            //         $redirect_msg = lang('package_validity_should_be_a_positive_number');
            //         $this->redirect($redirect_msg, 'product/edit_repurchase_package/' . $id, false);
            //     }
            // } else {
            //     $package_validity = "0";
            // }

            $package_validity = "0";
            $description = $post_arr['description'];
            $category_id = $post_arr['category'];

            $result = $this->product_model->updateProduct($product_id, $prod_name, $product_amount, $pair_value, $bv_value, $package_type, $package_validity, $package_id, $img_name, $description, $category_id);
            if ($result) {
                $data = serialize($post_arr);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Purchase package updated', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_repurchase_package', 'Purchase Package Updated');
                }
                //
                //insert configuration_change_history

                $package_history = "Updated Purchase Package configuration as its ";
                $flag = false;
                if ($package_details['product_name'] != $prod_name) {
                    $package_history .= lang('product_name') . " : " . $prod_name;
                    $flag = true;
                }
                if ($package_details['product_value'] != $product_amount) {
                    if ($flag)
                        $package_history .= " , ";
                    $package_history .= lang('amount') . " : " . $product_amount;
                    $flag = true;
                }
                if ($pv_visible == 'yes') {
                    if ($package_details['pair_value'] != $pair_value) {
                        if ($flag)
                            $package_history .= " , ";
                        $package_history .= lang('pair_value') . " : " . $pair_value;
                        $flag = true;
                    }
                }
                if ($bv_visible == 'yes') {
                    if ($package_details['bv_value'] != $pair_value) {
                        if ($flag)
                            $package_history .= " , ";
                        $package_history .= lang('bv_value') . " : " . $pair_value;
                        $flag = true;
                    }
                }
                if ($package_details['description'] != $description) {
                    if ($flag)
                        $package_history .= " , ";
                    $package_history .= lang('description') . " : " . $description;
                    $flag = true;
                }
                if ($package_details['category_id'] != $category_id) {
                    if ($flag)
                        $package_history .= " , ";
                    $package_history .= lang('category') . " : " . $this->product_model->getCategoryName($category_id);
                    $flag = true;
                }
                if ($package_details['prod_img'] != $img_name) {
                    if ($flag)
                        $package_history .= " , ";
                    $package_history .= lang('Product_img') . " : " . $img_name;
                    $flag = true;
                }
                if ($flag)
                    $this->configuration_model->insertConfigChangeHistory('Purchase settings', $package_history);
                $package_history = "";
                //

                $redirect_msg = lang('product_updated_successfully');
                $this->redirect($redirect_msg, 'product/repurchase_package', true);
            } else {
                $redirect_msg = lang('error_on_updating_product');
                $this->redirect($redirect_msg, 'product/edit_repurchase_package', false);
            }
        }
        $this->set('categories', $categories);
        $this->set('pv_visible', $pv_visible);
        $this->set('bv_visible', $bv_visible);
        $this->set('mlm_plan', $this->MLM_PLAN);
        $this->setView();
    }

    public function activate_repurchase_package()
    {
        if ($this->input->post('product_id')) {
            $product_id = $this->input->post('product_id', true);
            $result = $this->product_model->activateProduct($product_id);
            if ($result) {
                $data_array = array();
                $data_array['product_id'] = $product_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Purchase package activated', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'activate_repurchase_package', 'Purchase Package Activated');
                }
                //
                $package_history = sprintf(lang('activate_repurchase_package_n'), $this->product_model->getPackageId($product_id, "repurchase"));
                $this->configuration_model->insertConfigChangeHistory('Package settings', $package_history);

                $redirect_msg = lang('product_activated_successfully');
                $this->redirect($redirect_msg, 'product/repurchase_package', true);
            } else {
                $redirect_msg = lang('error_on_activating_product');
                $this->redirect($redirect_msg, 'product/repurchase_package', false);
            }
        }
    }

    public function inactivate_repurchase_package()
    {
        if ($this->input->post('product_id')) {
            $product_id = $this->input->post('product_id', true);
            $result = $this->product_model->inactivateProduct($product_id);
            if ($result) {
                $data_array = array();
                $data_array['product_id'] = $product_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Purchase package deactivated', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'inactivate_repurchase_package', 'Purchase Package Deactivated');
                }
                //

                $package_history = sprintf(lang('inactivate_repurchase_package_n'), $this->product_model->getPackageId($product_id, "repurchase"));
                $this->configuration_model->insertConfigChangeHistory('Package settings', $package_history);

                $redirect_msg = lang('product_inactivated_successfully');
                $this->redirect($redirect_msg, 'product/repurchase_package', true);
            } else {
                $redirect_msg = lang('error_on_inactivating_product');
                $this->redirect($redirect_msg, 'product/repurchase_package', false);
            }
        }
    }

    public function delete_repurchase_package()
    {
        if ($this->input->post('product_id')) {
            $product_id = $this->input->post('product_id', true);
            $result = $this->product_model->deleteProduct($product_id);
            if ($result) {
                $data_array = array();
                $data_array['product_id'] = $product_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Purchase package deleted', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'delete_repurchase_package', 'Purchase Package Deleted');
                }
                //

                $redirect_msg = lang('product_deleted_successfully');
                $this->redirect($redirect_msg, 'product/repurchase_package', true);
            } else {
                $redirect_msg = lang('error_on_delete_product');
                $this->redirect($redirect_msg, 'product/repurchase_package', false);
            }
        }
    }

    function validate_repurchase_package()
    {
        $this->form_validation->set_rules('prod_name', lang('product_name'), 'trim|required|callback_valid_package_name[repurchase]');
        $this->form_validation->set_rules('product_amount', lang('product_amount'), 'trim|required|greater_than[0]|max_length[5]');
        $this->form_validation->set_rules('package_id', lang('package_id'), 'trim|required|alpha_numeric|callback_valid_package_id[repurchase]');
        // if ($this->MODULE_STATUS['product_validity'] == 'yes') {
        //     $this->form_validation->set_rules('package_validity', lang('package_validity'), 'trim|required|greater_than[0],max_length[5]');
        // }
        if ($this->MODULE_STATUS['mlm_plan'] == "Binary") {
            $this->form_validation->set_rules('pair_value', lang('pair_value'), 'trim|required|greater_than_equal_to[0],max_length[5]');
        }
        if ($this->MODULE_STATUS['mlm_plan'] == 'Unilevel' || $this->MODULE_STATUS['mlm_plan'] == 'Matrix' || $this->MODULE_STATUS['mlm_plan'] == 'Stair_Step' || ($this->MODULE_STATUS['sponsor_commission_status'] == 'yes' && $this->MODULE_STATUS['mlm_plan'] != 'Binary')) {
            $this->form_validation->set_rules('bv_value', lang('bv_value'), 'trim|required|greater_than_equal_to[0],max_length[5]');
        }
        $this->form_validation->set_rules('category', lang('category'), 'trim|required|callback_valid_category|callback_is_active_category');
        $this->form_validation->set_rules('description', lang('description'), 'trim|required');
        return $this->form_validation->run();
    }

    public function valid_package_id($package_id, $package_type)
    {
        if ($this->input->post('product_id')) {
            $db_package_id = $this->product_model->getPackageId($this->input->post('product_id'), $package_type);
            if ($db_package_id == $package_id) {
                $res = true;
            } else {
                $res = $this->product_model->packageIdAvailable($package_id, $package_type);
            }
        } else {
            $res = $this->product_model->packageIdAvailable($package_id, $package_type);
        }

        if (!$res) {
            $this->form_validation->set_message('valid_package_id', lang('package_id_not_available'));
        }
        return $res;
    }

    public function valid_package_name($package_name, $package_type)
    {
        if ($this->input->post('product_id')) {
            $db_package_name = $this->product_model->getPackageName($this->input->post('product_id'), $package_type);
            if ($db_package_name == $package_name) {
                $res = true;
            } else {
                $res = $this->product_model->packageNameAvailable($package_name, $package_type);
            }
        } else {
            $res = $this->product_model->packageNameAvailable($package_name, $package_type);
        }

        if (!$res) {
            $this->form_validation->set_message('valid_package_name', lang('package_name_not_available'));
        }
        return $res;
    }

    public function add_repurchase_category()
    {
        $title = lang('add_repurchase_category');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'product-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('add_repurchase_category');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('add_repurchase_category');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if ($this->input->post('submit_category') && $this->validate_repurchase_category()) {
            $post_arr = $this->input->post(null, true);
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);

            $category_name = $post_arr['category_name'];

            $result = $this->product_model->addCategory($category_name);
            if ($result) {
                $data = serialize($post_arr);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Purchase Category added', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'add_repurchase_category', 'Purchase Category Added');
                }
                //

                $redirect_msg = lang('category_added_successfully');
                $this->redirect($redirect_msg, 'product/repurchase_category', true);
            } else {
                $redirect_msg = lang('error_on_adding_category');
                $this->redirect($redirect_msg, 'product/add_repurchase_category', false);
            }
        }

        $this->set('mlm_plan', $this->MLM_PLAN);
        $this->setView();
    }

    function validate_repurchase_category()
    {
        $this->form_validation->set_rules('category_name', lang('category_name'), 'trim|required|callback_valid_category_name');
        return $this->form_validation->run();
    }

    function is_active_category()
    {
        if ($this->input->post('category')) {
            $res = $this->product_model->isActiveCategory($this->input->post('category'));
            $this->form_validation->set_message('is_active_category', lang('you_must_select_valid_category'));
            return ($res > 0);
        }
    }

    public function valid_category_name($category_name)
    {

        if ($this->input->post('category_id')) {
            $db_category_name = $this->product_model->getCategoryName($this->input->post('category_id'));
            if ($db_category_name == $category_name) {
                $res = true;
            } else {
                $res = $this->product_model->categoryNameAvailable($category_name);
            }
        } else {
            $res = $this->product_model->categoryNameAvailable($category_name);
        }

        if (!$res) {
            $this->form_validation->set_message('valid_category_name', lang('category_name_not_available'));
        }
        return $res;
    }

    public function repurchase_category()
    {
        $help_link = 'product-management';
        $this->set('help_link', $help_link);

        if ($this->MLM_PLAN == 'Unilevel' && $this->MODULE_STATUS['hyip_status'] == 'yes') {
            $title = lang('deposit');
            $sub_title = lang('deposit_category');
        } else {
            $title = lang('manage_category');
            $sub_title = lang('manage_category');
        }

        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $pro_status = 'yes';
        if ($this->input->post('refine')) {
            $pro_status = $this->input->post('pro_status', true);
            $this->session->set_userdata('inf_pro_status', $pro_status);
        } else if ($this->session->userdata('inf_pro_status')) {
            $pro_status = $this->session->userdata('inf_pro_status');
        }


        $config = $this->pagination->customize_style();
        $base_url = base_url() . 'admin/product/repurchase_category';
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $tot_rows = $this->product_model->getPackageCount($pro_status);

        $config['total_rows'] = $tot_rows;
        $config['uri_segment'] = 4;

        $this->pagination->initialize($config);
        $page = 0;
        if ($this->uri->segment(4) != '') {
            $page = $this->uri->segment(4);
        }

        $categories = $this->product_model->getCategoryList($pro_status, $config['per_page'], $page);

        $this->set('categories', $this->security->xss_clean($categories));
        $this->set('sub_status', $pro_status);

        $result_per_page = $this->pagination->create_links();
        $this->set('result_per_page', $result_per_page);
        $this->set('page', $page);
        $this->set('mlm_plan', $this->MLM_PLAN);
        $this->set('pro_status', $pro_status);
        $this->setView();
    }

    public function activate_repurchase_category()
    {
        if ($this->input->post('category_id')) {
            $category_id = $this->input->post('category_id', true);
            $result = $this->product_model->categoryChanges($category_id, 'yes');
            if ($result) {
                $data_array = array();
                $data_array['category_id'] = $category_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Purchase category activated', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'activate_repurchase_category', 'Purchase Category Activated');
                }
                //
                $redirect_msg = lang('category_activated_successfully');
                $this->redirect($redirect_msg, 'product/repurchase_category', true);
            } else {
                $redirect_msg = lang('error_on_activating_category');
                $this->redirect($redirect_msg, 'product/repurchase_category', false);
            }
        }
    }

    public function inactivate_repurchase_category()
    {
        if ($this->input->post('category_id')) {
            $category_id = $this->input->post('category_id', true);
            $result = $this->product_model->categoryChanges($category_id, 'no');
            if ($result) {
                $data_array = array();
                $data_array['category_id'] = $category_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Purchase category deactivated', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'inactivate_repurchase_category', 'Purchase Category Deactivated');
                }
                //
                $redirect_msg = lang('category_inactivated_successfully');
                $this->redirect($redirect_msg, 'product/repurchase_category', true);
            } else {
                $redirect_msg = lang('error_on_inactivating_category');
                $this->redirect($redirect_msg, 'product/repurchase_category', false);
            }
        }
    }

    public function delete_repurchase_category()
    {
        if ($this->input->post('category_id')) {
            $category_id = $this->input->post('category_id', true);
            $result = $this->product_model->categoryChanges($category_id, 'deleted');
            if ($result) {
                $data_array = array();
                $data_array['category_id'] = $category_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Purchase category deleted', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'delete_repurchase_category', 'Purchase Category Deleted');
                }
                //
                $redirect_msg = lang('category_deleted_successfully');
                $this->redirect($redirect_msg, 'product/repurchase_category', true);
            } else {
                $redirect_msg = lang('error_on_delete_category');
                $this->redirect($redirect_msg, 'product/repurchase_category', false);
            }
        }
    }

    function valid_category($category)
    {
        if ($category == 'default') {
            $this->form_validation->set_message('valid_category', lang('you_must_select_category'));
            return false;
        }
        return true;
    }
    public function edit_repurchase_category($id = '')
    {
        $title = lang('edit_repurchase_category');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'product-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('edit_repurchase_category');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('edit_repurchase_category');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if ($this->input->method() == 'post') {
            $id = $this->input->post('category_id', true);
        }

        $category_details = $this->product_model->getCategoryDetails($id);
        if (!$category_details) {
            $redirect_msg = lang('category_not_available');
            $this->redirect($redirect_msg, 'product/repurchase_category', false);
        }
        $this->set('category_details', $category_details);

        if ($this->input->post('update_cat') && $this->validate_repurchase_category()) {
            $post_arr = $this->input->post(null, true);
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);

            $category_name = $post_arr['category_name'];

            $result = $this->product_model->updateCategory($id, $category_name);
            if ($result) {
                $data = serialize($post_arr);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Repurchase category updated', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_repurchase_package', 'Purchase Package Updated');
                }
                //

                $redirect_msg = lang('category_updated_successfully');
                $this->redirect($redirect_msg, 'product/repurchase_category', true);
            } else {
                $redirect_msg = lang('error_on_updating_category');
                $this->redirect($redirect_msg, 'product/edit_repurchase_category', false);
            }
        }
        $this->setView();
    }
}
