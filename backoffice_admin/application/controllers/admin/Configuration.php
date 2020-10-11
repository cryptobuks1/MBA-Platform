<?php

require_once 'Inf_Controller.php';
set_time_limit(600);

class Configuration extends Inf_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->MODULE_STATUS['pin_status'] == 'yes') {
            $this->load->model('epin_model');
        }
        $this->load->model('profile_model');
    }

    function general_setting()
    {

        $title = lang('general_settings');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'network-configuration ';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('general_settings');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('general_settings');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        if ($this->input->post()) {

            if ($this->input->post('setting') && $this->validate_additional_config()) {

                $conf_post_array = $this->input->post(NULL, TRUE);
                $conf_post_array = $this->validation_model->stripTagsPostArray($conf_post_array);
                $time = $conf_post_array['logout_time'];

                $status = $this->check_numeric($conf_post_array);
                if (!$status) {
                    $msg = $this->lang->line('invalid_input');
                    $this->redirect($msg, "configuration/general_setting", false);
                }
                $res1 = $this->configuration_model->updateAdditionalSettings($conf_post_array, $this->MODULE_STATUS, $this->DEFAULT_CURRENCY_VALUE);

                $compression_commission = 'no';
                $skip_blocked_users_commission = 'no';

                if ($this->input->post('compression_commission')) {
                    $compression_commission = 'yes';
                }

                if ($this->input->post('skip_blocked_users_commission')) {
                    $skip_blocked_users_commission = 'yes';
                }

                $res2 = $this->configuration_model->updateSignupSettings('compression_commission', $compression_commission);

                $res3 = $this->configuration_model->updateConfiguration('skip_blocked_users_commission', $skip_blocked_users_commission);

                $res4 = $this->configuration_model->updateLogoutTime($time);

                if ($res1 && $res2 && $res3 && $res4) {
                    $login_id = $this->LOG_USER_ID;
                    $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'general_setting', 'General Settings Updated');
                    }

                    $msg = $this->lang->line('configuration_updated_successfully');
                    $this->redirect($msg, "configuration/general_setting", true);
                } else {
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $this->redirect($msg, "configuration/general_setting", false);
                }

            }

        }

        $signup_config = $this->configuration_model->getSignupConfiguration();
        $obj_arr = $this->configuration_model->getSettings();
        $prev_time = $this->validation_model->selectLogoutTime();
        $this->set("prev_time", $prev_time);

        $this->set('obj_arr', $obj_arr);
        $this->set('signup_config', $signup_config);
        $this->setView();

    }

    function configuration_view($arg = NULL)
    {
        //$this->redirect("", "configuration/general_setting", FALSE);
        $title = lang('system_settings');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'network-configuration ';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('system_settings');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('system_settings');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $mlm_plan = $this->MODULE_STATUS['mlm_plan'];
        $this->set('MLM_PLAN', $mlm_plan);

        $obj_arr = $this->configuration_model->getSettings();

        $obj_arr_board = array();
        $arr_level = array();
        $arr_donation = array();
        $arr_donation_level = array();

        $this->load->model('currency_model');
        if ($this->MLM_PLAN == "Board") {
            $obj_arr_board = $this->configuration_model->getBoardSettings();
        }

        $board_count = count($obj_arr_board);

        if ($this->MLM_PLAN == "Unilevel" || $this->MLM_PLAN == "Matrix" || $this->MODULE_STATUS['sponsor_commission_status'] == 'yes' && $this->MLM_PLAN != "Donation") {
            $arr_level = $this->configuration_model->getLevelSettings();
        }
        if ($this->MLM_PLAN == "Donation") {
            $this->load->model('donation_model');
            $arr_donation = $this->configuration_model->getDonationLevelSettings();
            $arr_donation_level = $this->donation_model->getLevelName();
        }

        $tab1 = $tab2 = $tab3 = $tab4 = $tab5 = NULL;
        if ($arg == 'level') {
            $tab2 = ' active';
            $active_tab = 'tab2';
        } else if ($arg == 'referal' && $this->MODULE_STATUS['referal_status'] == 'yes') {
            $tab3 = ' active';
            $active_tab = 'tab3';
        } else if (($this->MLM_PLAN == "Party" && $this->MODULE_STATUS['sponsor_commission_status'] == 'yes') || ($this->MLM_PLAN != "Party")) {
            $tab1 = ' active';
            $active_tab = 'tab1';
        } else if ($this->MODULE_STATUS['referal_status'] == 'yes') {
            $tab3 = ' active';
            $active_tab = 'tab3';
        } else {
            $tab1 = ' active';
            $active_tab = 'tab1';
        }

        $this->set('matching_bonus_status', $obj_arr['matching_bonus']);
        $this->set('pool_bonus_status', $obj_arr['pool_bonus']);
        $this->set('fast_start_bonus_status', $obj_arr['fast_start_bonus']);
        $this->set('performance_bonus_status', $obj_arr['performance_bonus']);
        if ($obj_arr['matching_bonus'] == 'yes') {
            $matching_bonus_config = $this->configuration_model->getMatchingBonusConfig();
            $this->set('matching_bonus_config', $matching_bonus_config);
        }
        if ($obj_arr['pool_bonus'] == 'yes') {
            $pool_bonus_config = $this->configuration_model->getPoolBonusConfig();
            $this->set('pool_bonus_config', $pool_bonus_config);
            $this->set('pool_bonus_percent', $obj_arr['pool_bonus_percent']);
        }
        if ($obj_arr['fast_start_bonus'] == 'yes') {
            $fast_start_bonus_config = $this->configuration_model->getFastStartBonusConfig();
            $this->set('fast_start_bonus_config', $fast_start_bonus_config);
        }
        if ($obj_arr['performance_bonus'] == 'yes') {
            $performance_bonus_config = $this->configuration_model->getPerformanceBonusConfig();
            $this->set('performance_bonus_config', $performance_bonus_config);
        }


        if ($this->input->post()) {
            if ($this->input->post('active_tab')) {
                $active_tab = $this->input->post('active_tab', TRUE);
                $this->set_active_tab_onupdate($active_tab);
            }

            $conf_post_array = $this->input->post(NULL, TRUE);
            $conf_post_array = $this->validation_model->stripTagsPostArray($conf_post_array);

            if ($active_tab == 'tab1') {
                $cleanup_required = FALSE;
                $result = FALSE;
                if ($this->MLM_PLAN == "Binary" && $this->input->post('binary_setting') && $this->validate_binary_setting()) {
                    if ($conf_post_array['pair_ceiling_type'] != 'none') {
                        $pair_celing = $conf_post_array['pair_ceiling'];
                        if ($pair_celing <= 0) {
                            $msg = $this->lang->line('pair_ceiling_must_be_greater_than_zero');
                            $this->redirect($msg, "configuration/configuration_view", FALSE);
                        }
                        if ($this->input->post('pair_ceiling_type') == 'monthly_with_daily') {
                            $pair_ceiling_daily = $conf_post_array['pair_ceiling'];
                            $pair_ceiling_monthly = $conf_post_array['pair_ceiling_monthly'];
                            if ($pair_ceiling_monthly < $pair_ceiling_daily) {
                                $msg = lang('daily_ceil_greater_than_equal_monthly_ceil');
                                $this->redirect($msg, "configuration/configuration_view", FALSE);
                            }
                        }
                    }
                    $result = $this->configuration_model->updateBinarySetting($conf_post_array);
                }
                if ($this->MLM_PLAN == "Board" && $this->input->post('board_setting') && $this->validate_board_setting()) {
                    $board_count = $conf_post_array['board_count'];
                    for ($i = 0; $i < $board_count; $i++) {
                        $board_depth = $conf_post_array["board" . $i . "_depth"];
                        $board_width = $conf_post_array["board" . $i . "_width"];
                        if ($board_width > 10) {
                            $msg = $this->lang->line('board_width_cannot_be_greater_than_three');
                            $this->redirect($msg, "configuration/configuration_view", FALSE);
                        }
                        if ($board_depth > 10) {
                            $msg = $this->lang->line('10');
                            $this->redirect($msg, "configuration/configuration_view", FALSE);
                        }
                    }
                    $cleanup_required = $this->check_plan_variables($conf_post_array);
                    $result = $this->configuration_model->updateBoardSetting($conf_post_array, $board_count);
                }
                if ($this->MLM_PLAN == "Matrix" && $this->input->post('matrix_setting') && $this->validate_matrix_setting()) {
                    $cleanup_required = $this->check_plan_variables($conf_post_array);
                    $result = $this->configuration_model->updateMatrixSetting($conf_post_array);
                    if ($result) {
                        $this->configuration_model->setLevel($conf_post_array['depth_ceiling'], $obj_arr['depth_ceiling']);
                    }
                }
                if ((in_array($this->MLM_PLAN, ['Unilevel', 'Donation', 'Stair_Step']) || $this->MODULE_STATUS['sponsor_commission_status'] == "yes") && $this->input->post('level_setting') && $this->validate_level_setting()) {
                    $cleanup_required = $this->check_plan_variables($conf_post_array);
                    $result = $this->configuration_model->updateLevelSetting($conf_post_array);
                    if ($result) {
                        $this->configuration_model->setLevel($conf_post_array['depth_ceiling'], $obj_arr['depth_ceiling']);
                    }
                }
                if ($this->MODULE_STATUS['referal_status'] == "yes" && $this->input->post('referral_setting') && $this->validate_referral_setting()) {
                    $result = $this->configuration_model->updateReferralSetting($conf_post_array);
                }

                if ($result) {
                    if (DEMO_STATUS == 'yes') {
                        $demo_id = $this->validation_model->getAdminId();
                        $plan_configured = $this->login_model->isPlanConfigured($demo_id);
                        if ($plan_configured == 'no') {
                            $this->login_model->setPlanConfigured($demo_id);
                        }
                    }
                    if ($conf_post_array['cleanup_flag'] == "do_clean" && $cleanup_required) {
                        $this->load->model('cleanup_model');
                        $this->cleanup_model->clean($this->MODULE_STATUS);
                    }
                    $login_id = $this->LOG_USER_ID;
                    $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'configuration_setting', 'Configuration Changed');
                    }
                    $msg = $this->lang->line('configuration_updated_successfully');
                    $this->redirect($msg, "configuration/configuration_view", true);
                } else {
                    if (empty($this->form_validation->error_array())) {
                        $msg = $this->lang->line('error_on_configuration_updation');
                        $this->redirect($msg, "configuration/configuration_view", FALSE);
                    }
                }
            }
            if ($active_tab == 'tab2') {
                $result = FALSE;
                if ($this->MLM_PLAN == "Binary" && $this->input->post('binary_commission') && $this->validate_binary_commission()) {
                    $result = $this->configuration_model->updateBinaryCommission($conf_post_array);
                }
                if ((in_array($this->MLM_PLAN, ['Matrix', 'Unilevel']) || $this->MODULE_STATUS['sponsor_commission_status'] == "yes")  && $this->MLM_PLAN != "Donation" && $this->input->post('level_commission') && $this->validate_level_commission()) {
                    $status = $this->check_numeric($conf_post_array);
                    if (!$status) {
                        $msg = $this->lang->line('invalid_input');
                        $this->redirect($msg, "configuration/configuration_view", false);
                    }
                    $result = $this->configuration_model->updateLevelCommission($conf_post_array, $this->DEFAULT_CURRENCY_VALUE);
                }
                if ($this->MLM_PLAN == "Donation" && $this->input->post('donation_level_commission')) {
                    $status = $this->check_numeric($conf_post_array);
                    if (!$status) {
                        $msg = $this->lang->line('invalid_input');
                        $this->redirect($msg, "configuration/configuration_view", false);
                    }
                    $result = $this->configuration_model->updateDonationLevelCommission($conf_post_array, $this->DEFAULT_CURRENCY_VALUE);
                }
                if ($this->MLM_PLAN == "Stair_Step" && $this->input->post('step_commission') && $this->validate_step_commission()) {
                    $result = $this->configuration_model->updateStairstepCommission($conf_post_array);
                }
                if ($result) {
                    $login_id = $this->LOG_USER_ID;
                    $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'commission_setting', 'Commission Settings Updated');
                    }
                    $msg = $this->lang->line('configuration_updated_successfully');
                    $this->redirect($msg, "configuration/configuration_view", true);
                } else {
                    if (empty($this->form_validation->error_array())) {
                        $msg = $this->lang->line('error_on_configuration_updation');
                        $this->redirect($msg, "configuration/configuration_view", false);
                    }
                }
            }
            if ($active_tab == 'tab4') {
                if ($this->input->post('setting') && $this->validate_xup_config()) {
                    if ($conf_post_array['xup_level'] < 1 || $conf_post_array['xup_level'] > 3) {
                        $msg = $this->lang->line('xup_level_must_be_between_1_3');
                        $this->redirect($msg, "configuration/configuration_view", false);
                    }
                    $result = $this->configuration_model->updateXupSettings($conf_post_array, $this->MODULE_STATUS, $this->DEFAULT_CURRENCY_VALUE);
                    if ($result) {
                        $login_id = $this->LOG_USER_ID;
                        $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                        if ($this->LOG_USER_TYPE == 'employee') {
                            $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'additional_setting', 'Additional Settings Updated');
                        }
                        $msg = $this->lang->line('configuration_updated_successfully');
                        $this->redirect($msg, "configuration/configuration_view", true);
                    } else {
                        $msg = $this->lang->line('error_on_configuration_updation');
                        $this->redirect($msg, "configuration/configuration_view", false);
                    }
                }
            }
            if ($active_tab == 'tab5') {
                $result = FALSE;
                if ($this->input->post('matching_bonus_setting') && $this->validate_matching_bonus()) {
                    $result = $this->configuration_model->updateMatchingBonus($conf_post_array);
                }
                if ($this->input->post('pool_bonus_setting') && $this->validate_pool_bonus()) {
                    $result = $this->configuration_model->updatePoolBonus($conf_post_array);
                }
                if ($this->input->post('fast_start_bonus_setting') && $this->validate_fast_start_bonus()) {
                    $result = $this->configuration_model->updateFastStartBonus($conf_post_array);
                }
                if ($this->input->post('performance_bonus_setting') && $this->validate_performance_bonus()) {
                    $result = $this->configuration_model->updatePerformanceBonus($conf_post_array);
                }
                if ($result) {
                    $login_id = $this->LOG_USER_ID;
                    $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'additional_bonus', 'Additional Bonus Updated');
                    }
                    $msg = $this->lang->line('configuration_updated_successfully');
                    $this->redirect($msg, "configuration/configuration_view", true);
                } else {
                    if (empty($this->form_validation->error_array())) {
                        $msg = $this->lang->line('error_on_configuration_updation');
                        $this->redirect($msg, "configuration/configuration_view", false);
                    }
                }
            }
        }

        if ($this->session->userdata('inf_config_tab_active_arr')) {
            $tab_array = $this->session->userdata('inf_config_tab_active_arr');
            $tab1 = $tab_array['tab1'];
            $tab2 = $tab_array['tab2'];
            $tab3 = $tab_array['tab3'];
            $tab4 = $tab_array['tab4'];
            $tab5 = $tab_array['tab5'];
            $this->session->unset_userdata('inf_config_tab_active_arr');
        }
        $project_default_currency = $this->currency_model->getProjectDefaultCurrencyDetails();

        // Theme Settings
        $def_admin_theme = $this->configuration_model->getAdminThemeFolder();
        $admin_themes = array();
        $admin_directories = glob(APPPATH . 'views/admin/layout/themes/*');
        foreach ($admin_directories as $directory) {
            $name = basename($directory);
            $admin_themes[] = array(
                "name" => $name,
                "default" => ($def_admin_theme == $name) ? 1 : 0,
                "icon" => $name . "/theme.png",
                "image" => $name . "/theme.png"
            );
        }
        rsort($admin_themes);
        $def_user_theme = $this->configuration_model->getUserThemeFolder();
        $user_themes = array();
        $user_directories = glob(APPPATH . 'views/user/layout/themes/*');
        foreach ($user_directories as $user_directory) {
            $name = basename($user_directory);
            $user_themes[] = array(
                "name" => $name,
                "default" => ($def_user_theme == $name) ? 1 : 0,
                "icon" => $name . "/theme.png",
                "image" => $name . "/theme.png"
            );
        }
        rsort($user_themes);

        $this->set('def_admin_theme_folder', $def_admin_theme);
        $this->set('admin_themes', $admin_themes);
        $this->set('def_user_theme_folder', $def_user_theme);
        $this->set('user_themes', $user_themes);

        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);
        $this->set('tab3', $tab3);
        $this->set('tab4', $tab4);
        $this->set('tab5', $tab5);

        $this->set('board_count', $board_count);
        $this->set('obj_arr', $obj_arr);
        $this->set('obj_arr_board', $obj_arr_board);
        $this->set('arr_level', $arr_level);
        $this->set('arr_donation', $arr_donation);
        $this->set('arr_donation_level', $arr_donation_level);
        $this->set('project_default_currency', $project_default_currency);

        $this->setView();
    }

    public function validate_binary_setting()
    {
        $pair_commission_type = $this->validation_model->getConfig('pair_commission_type');
        $this->form_validation->set_rules('pair_ceiling_type', strtolower(lang('pair_ceiling_type')), 'trim|required|in_list[none,daily,weekly,monthly,monthly_with_daily]', ['in_list' => 'You must select %s']);
        if (in_array($this->input->post('pair_ceiling_type'), ['daily', 'weekly', 'monthly', 'monthly_with_daily'])) {
            if ($pair_commission_type == 'flat') {
                $this->form_validation->set_rules('pair_ceiling', lang('pair_ceiling'), 'trim|required|integer|greater_than[0]|max_length[5]');
            } elseif ($pair_commission_type == 'percentage') {
                $this->form_validation->set_rules('pair_ceiling', lang('pair_ceiling'), 'trim|required|greater_than[0]|max_length[5]');
            }
            if ($this->input->post('pair_ceiling_type') == 'monthly_with_daily') {
                if ($pair_commission_type == 'flat') {
                    $this->form_validation->set_rules('pair_ceiling_monthly', lang('pair_ceiling'), 'trim|required|integer|greater_than[0]|max_length[5]');
                } elseif ($pair_commission_type == 'percentage') {
                    $this->form_validation->set_rules('pair_ceiling_monthly', lang('pair_ceiling'), 'trim|required|greater_than[0]|max_length[5]');
                }
            }
        }
        if ($pair_commission_type == 'flat') {
            $this->form_validation->set_rules('pair_value', lang('pair_value'), 'trim|required|greater_than[0]');
        }
        if ($this->MODULE_STATUS['product_status'] == 'no') {
            $this->form_validation->set_rules('product_point_value', lang('product_point_value'), 'trim|required|greater_than_equal_to[0]');
        }
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    public function validate_board_setting()
    {
        $obj_arr_board = $this->configuration_model->getBoardSettings();
        $board_count = count($obj_arr_board);
        for ($i = 0; $i < $board_count; $i++) {
            $this->form_validation->set_rules("board" . $i . "_name", lang('board_name'), 'trim|required|alpha_numeric_spaces');
            $this->form_validation->set_rules("board" . $i . "_width", lang('board_width'), 'trim|required|integer|greater_than_equal_to[2]');
            $this->form_validation->set_rules("board" . $i . "_depth", lang('board_depth'), 'trim|required|integer|greater_than[0]');
        }
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    public function validate_matrix_setting()
    {
        // $this->form_validation->set_rules('depth_ceiling', lang('depth_ceiling'), 'trim|required|integer|greater_than[0]|less_than[100]');
        $this->form_validation->set_rules('width_ceiling', lang('width_ceiling'), 'trim|required|integer|greater_than[0]|less_than[100]');
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    public function validate_level_setting()
    {
        $this->form_validation->set_rules('depth_ceiling', lang('depth_ceiling'), 'trim|required|integer|greater_than[0]|less_than[100]');
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    public function validate_referral_setting()
    {
        $this->form_validation->set_rules('sponsor_commission_type', strtolower(lang('sponsor_commission_type')), 'trim|required|in_list[sponsor_package,joinee_package,rank]', ['in_list' => 'You must select %s']);
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    public function validate_binary_commission()
    {
        if ($this->MODULE_STATUS['product_status'] == 'no') {
            $pair_commission_type = $this->input->post('pair_commission_type');
            if ($pair_commission_type == 'percentage') {
                $this->form_validation->set_rules('pair_price', lang('pair_price'), 'trim|required|greater_than[0]|less_than_equal_to[100]');
            } elseif ($pair_commission_type == 'flat') {
                $this->form_validation->set_rules('pair_price', lang('pair_price'), 'trim|required|greater_than[0]');
            }
            $res_val = $this->form_validation->run();
            return $res_val;
        }
        return TRUE;
    }

    public function validate_level_commission()
    {
        $depth_ceiling = $this->validation_model->getConfig('commission_upto_level');;
        if ($depth_ceiling > 0) {
            $level_commission_type = $this->validation_model->getConfig('level_commission_type');
            $commission_type = $this->validation_model->getConfig('commission_criteria');
            if($commission_type == 'genealogy'){
                for ($i = 1; $i <= $depth_ceiling; $i++) {
                    if ($level_commission_type == 'percentage') {
                        $this->form_validation->set_rules("level_percentage{$i}", lang('level_commission'), 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]');
                    } elseif ($level_commission_type == 'flat') {
                        $this->form_validation->set_rules("level_percentage{$i}", lang('level_commission'), 'trim|required|greater_than_equal_to[0]|max_length[5]');
                    }
                }
            }else{
                $arr_pck = $this->configuration_model->getLevelCommissionPackages();
                if($commission_type == 'reg_pck'){
                    $pck = 'reg';
                }else{
                    $pck = 'member';
                }
                for ($j = 1; $j <= $depth_ceiling; $j++) {
                    foreach ($arr_pck as $pack) {
                        $prod_id = $pack['prod_id'];
                        if ($level_commission_type == 'percentage') {
                            //$label = lang('level') . $j .  $prod_id . lang('commission_');
                            $this->form_validation->set_rules("level_" . $j . "_" . $prod_id . "_" . $pck, lang('level_commission') , 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]');
                        } elseif ($level_commission_type == 'flat') {
                            //$label = lang('level') . $j .  $prod_id . lang('commission_');
                            $this->form_validation->set_rules("level_" . $j . "_" . $prod_id . "_" . $pck, lang('level_commission'), 'trim|required|greater_than_equal_to[0]|max_length[5]');
                        }
                    }
                }
            }
            $res_val = $this->form_validation->run_with_redirect("configuration/level_commissions/$commission_type/$depth_ceiling");
            return $res_val;
        }
    }

    public function validate_board_commission()
    {
        $obj_arr_board = $this->configuration_model->getBoardSettings();
        $board_count = count($obj_arr_board);
        if ($board_count > 0) {
            for ($i = 0; $i < $board_count; $i++) {
                $this->form_validation->set_rules("board" . $i . "_commission", lang("board_commission"), 'trim|required|greater_than_equal_to[0]');
            }
            $res_val = $this->form_validation->run();
            return $res_val;
        }
    }

    public function validate_step_commission()
    {
        $this->form_validation->set_rules('override_commission', lang('override_commission'), 'trim|required|greater_than_equal_to[0]');
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    public function validate_xup_config()
    {
        $this->form_validation->set_rules('xup_level', lang('xup_level'), 'trim|required|numeric|greater_than[0]|less_than[4]');
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    public function validate_additional_config()
    {
        if ($this->MODULE_STATUS['referal_status'] == 'yes' && $this->MODULE_STATUS['product_status'] == 'no') {
            $this->form_validation->set_rules('referal_amount', lang('referal_amount'), 'trim|required|greater_than_equal_to[0]');
        }
        if ($this->MODULE_STATUS['opencart_status'] == 'no') {
            $this->form_validation->set_rules('reg_amount', lang('registration_amount'), 'trim|required|greater_than_equal_to[0]');
        }
        if ($this->MODULE_STATUS['purchase_wallet'] == 'yes') {
            $this->form_validation->set_rules('purchase_income_perc', lang('purchase_wallet_commission'), 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]');
        }
        $this->form_validation->set_rules('service_charge', lang('service_charge'), 'trim|required|greater_than_equal_to[0]');
        $this->form_validation->set_rules('logout_time', lang('logout_time'), 'trim|required|greater_than_equal_to[180]');
        $this->form_validation->set_rules('trans_fee', lang('transaction_fee'), 'trim|required|greater_than_equal_to[0]');
        $this->form_validation->set_rules('tds', lang('tds'), 'trim|required|greater_than_equal_to[0]|callback_check_sum_of_taxes');
        $this->form_validation->set_message('check_sum_of_taxes', lang('sum_of_tds_and_service_charge_should_be_less_equal_to_100'));
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    public function validate_matching_bonus()
    {
        $matching_bonus_status = $this->validation_model->getConfig('matching_bonus');
        $matching_bonus_levels = $this->configuration_model->getMatchingBonusLevels();
        if ($matching_bonus_status == 'yes' && $matching_bonus_levels > 0) {
            for ($i = 1; $i <= $matching_bonus_levels; $i++) {
                $label = sprintf(lang('level_n_bonus'), $i);
                $this->form_validation->set_rules("matching_level{$i}", $label, 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]', [
                    'required' => sprintf(lang('field_is_required'), $label),
                    'greater_than_equal_to' => sprintf(lang('field_must_be_between_0_100'), $label),
                    'less_than_equal_to' => sprintf(lang('field_must_be_between_0_100'), $label),
                ]);
            }
            $res_val = $this->form_validation->run();
            return $res_val;
        }
    }

    public function validate_pool_bonus()
    {
        $pool_bonus_status = $this->validation_model->getConfig('pool_bonus');
        $pool_bonus_levels = $this->configuration_model->getPoolBonusLevels();
        if ($pool_bonus_status == 'yes' && $pool_bonus_levels > 0) {
            $label = lang('bonus');
            $this->form_validation->set_rules("pool_bonus", $label, 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]', [
                'required' => sprintf(lang('field_is_required'), $label),
                'greater_than_equal_to' => sprintf(lang('field_must_be_between_0_100'), $label),
                'less_than_equal_to' => sprintf(lang('field_must_be_between_0_100'), $label),
            ]);
            for ($i = 1; $i <= $pool_bonus_levels; $i++) {
                $label = sprintf(lang('level_n_bonus'), $i);
                $this->form_validation->set_rules("pool_level{$i}", $label, 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]', [
                    'required' => sprintf(lang('field_is_required'), $label),
                    'greater_than_equal_to' => sprintf(lang('field_must_be_between_0_100'), $label),
                    'less_than_equal_to' => sprintf(lang('field_must_be_between_0_100'), $label),
                ]);
            }
            $res_val = $this->form_validation->run();
            return $res_val;
        }
    }

    public function validate_fast_start_bonus()
    {
        $fast_start_bonus_status = $this->validation_model->getCompensationConfig('fast_start_bonus');
        if ($fast_start_bonus_status == 'yes') {
            $label1 = lang('referral_count1');
            $label2 = lang('days');
            $label3 = lang('bonus_amount');
            $this->form_validation->set_rules("fast_start_referral_count", $label1, 'trim|required|integer|greater_than[0]', [
                'required' => sprintf(lang('field_is_required'), $label1),
                'integer' => sprintf(lang('field_must_be_digits'), $label1),
                'greater_than' => sprintf(lang('field_must_be_greater_than_0'), $label1),
            ]);
            $this->form_validation->set_rules("fast_start_days", $label2, 'trim|required|integer|greater_than[0]', [
                'required' => sprintf(lang('field_is_required'), $label2),
                'integer' => sprintf(lang('field_must_be_digits'), $label2),
                'greater_than' => sprintf(lang('field_must_be_greater_than_0'), $label2),
            ]);
            $this->form_validation->set_rules("fast_start_bonus", $label3, 'trim|required|greater_than_equal_to[0]', [
                'required' => sprintf(lang('field_is_required'), $label3),
                'greater_than_equal_to' => sprintf(lang('field_must_be_greater_than_equal_0'), $label3),
            ]);
            $res_val = $this->form_validation->run();
            return $res_val;
        }
    }

    public function validate_performance_bonus()
    {
        $performance_bonus_status = $this->validation_model->getConfig('performance_bonus');
        $performance_bonus_count = $this->configuration_model->getPerformanceBonusCount();
        if ($performance_bonus_status == 'yes' && $performance_bonus_count > 0) {
            $label1 = lang('personal_pv');
            $label2 = lang('group_pv');
            $label3 = lang('bonus');
            for ($i = 1; $i <= $performance_bonus_count; $i++) {
                $this->form_validation->set_rules("performance{$i}_personal_pv", $label1, 'trim|required|greater_than_equal_to[0]', [
                    'required' => sprintf(lang('field_is_required'), $label1),
                    'greater_than_equal_to' => sprintf(lang('field_must_be_greater_than_equal_0'), $label1),
                ]);
                $this->form_validation->set_rules("performance{$i}_group_pv", $label2, 'trim|required|greater_than_equal_to[0]', [
                    'required' => sprintf(lang('field_is_required'), $label2),
                    'greater_than_equal_to' => sprintf(lang('field_must_be_greater_than_equal_0'), $label2),
                ]);
                $this->form_validation->set_rules("performance{$i}_bonus_percent", $label3, 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]', [
                    'required' => sprintf(lang('field_is_required'), $label2),
                    'greater_than_equal_to' => sprintf(lang('field_must_be_between_0_100'), $label3),
                    'less_than_equal_to' => sprintf(lang('field_must_be_between_0_100'), $label3),
                ]);
            }
            $res_val = $this->form_validation->run();
            return $res_val;
        }
    }

    public function set_active_tab_onupdate($active_tab)
    {
        $tab1 = $tab2 = $tab3 = $tab4 = $tab5 = NULL;
        switch ($active_tab) {
            case 'tab1':
                $tab1 = ' active';
                break;
            case 'tab2':
                $tab2 = ' active';
                break;
            case 'tab3':
                $tab3 = ' active';
                break;
            case 'tab4':
                $tab4 = ' active';
                break;
            case 'tab5':
                $tab5 = ' active';
                break;
            default:
                $tab1 = ' active';
                break;
        }
        $this->session->set_userdata('inf_config_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3, 'tab4' => $tab4, 'tab5' => $tab5));
    }

    function payout_setting()
    {
        $title = lang('payout_settings');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('payout_settings');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('payout_settings');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $obj_arr = $this->configuration_model->getSettings();
        $kyc_docs = $this->configuration_model->getKycDocCategory();
        $this->set('kyc_docs', $kyc_docs);
        $this->set('obj_arr', $obj_arr);

        $this->session->unset_userdata("link_origin");

        if ($this->input->post('setting') && $this->validate_payout_setting($this->input->post())) {
            $payout_post_array = $this->input->post(NULL, TRUE);
            $payout_post_array = $this->validation_model->stripTagsPostArray($payout_post_array);

            $payout_status = $payout_post_array['payout_status'];
            $min_payout = round((floatval($payout_post_array['min_payout']) / $this->DEFAULT_CURRENCY_VALUE), 8);
            $max_payout = round((floatval($payout_post_array['max_payout']) / $this->DEFAULT_CURRENCY_VALUE), 8);
            $payout_validity = $payout_post_array['payout_validity'];

            if ($payout_validity == 0) {
                $payout_validity = 30;
            }

            $result = $this->configuration_model->updatePayoutSettng($min_payout, $payout_validity, $payout_status, $max_payout);
            if ($result) {
                $data = serialize($payout_post_array);
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'payout config updated', $login_id, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_payout_setting', 'Payout Settings Updated');
                }
                //
                //insert configuration_change_history
                $payout_history = "Updated the payout settings as Min Payout :" . $this->DEFAULT_SYMBOL_LEFT . $min_payout . $this->DEFAULT_SYMBOL_RIGHT . ", ";
                $payout_history .= "Max Payout :" . $this->DEFAULT_SYMBOL_LEFT . $max_payout . $this->DEFAULT_SYMBOL_RIGHT . ", ";
                $payout_history .= "Payout validity :" . $payout_validity . ", ";
                if ($payout_status == "from_ewallet") {
                    $payout_history .= "Payout Method: Manually by admin";
                } else if ($payout_status == "ewallet_request") {
                    $payout_history .= "Payout Method: By user request";
                }

                $this->configuration_model->insertConfigChangeHistory('payout settings', $payout_history);
                $payout_history = "";
                //
                $module_name = 'payout_release_status';
                $this->configuration_model->setModuleStatus($module_name, $payout_status);

                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, 'configuration/payout_setting', true);
            } else {
                $msg = $this->lang->line('error_on_configuration_updation');
                $this->redirect($msg, 'configuration/payout_setting', FALSE);
            }
        }

        /* Payment Gateway Configuration For Payout Begin */
        $update_array_check = array();
        $card_status = $this->configuration_model->getCreditCardStatus("payout");
        $this->set('card_status', $card_status);
        if ($this->input->post('update')) {
            $loop_count = $this->input->post('number', TRUE);
            for ($i = 1; $i <= $loop_count; $i++) {
                if ($this->input->post("sort_order$i") && $this->input->post("sort_order$i") > 0) {
                    $update_array_check["srt_order$i"] = $this->input->post("sort_order$i");
                    $update_array["srt_order$i"] = $this->input->post("sort_order$i");
                    $update_array["id$i"] = $this->input->post("id$i");
                } else {
                    $msg = $this->lang->line('error_on_sort_order_updation') . " ";
                    $msg .= $this->lang->line('sort_order_should_be_greater_than_0');
                    $this->redirect($msg, 'configuration/payout_setting', FALSE);
                }
            }
            if (!array_diff_key($update_array_check, array_unique($update_array_check))) {
                //insert configuration_change_history
                $gate_history = "Updated sort order:";
                for ($i = 1; $i <= $loop_count; $i++) {
                    $this->configuration_model->updateSortOrder($update_array["id$i"], $update_array["srt_order$i"], "payout");
                    $res1 = $this->configuration_model->getCreditCardDetails($update_array["id$i"], "payout");
                    $gate_history .= "Gateway : " . $res1['gateway_name'] . ",";
                    $gate_history .= "new position :" . $res1["sort_order"] . ";";
                }
                $this->configuration_model->insertConfigChangeHistory('payment gateway settings for payout', $gate_history);
                $gate_history = "";

                $msg = $this->lang->line('sort_order_updated_successfully');
                $this->redirect($msg, 'configuration/payout_setting', true);
            }
            $msg = $this->lang->line('error_on_sort_order_updation') . " ";
            $msg .= $this->lang->line('sort_order_should_be_different');
            $this->redirect($msg, 'configuration/payout_setting', FALSE);
        }
        /* Payment Gateway Configuration For Payout End */

        if ($this->input->post('delete_category')) {
            $catg_id = $this->input->post('delete_category', TRUE);
            $result = $this->configuration_model->deleteKycCategory($catg_id);
            if ($result) {
                $msg = $this->lang->line('kyc_category_deleted_successfully');
                $this->redirect($msg, "configuration/payout_setting", TRUE);
            } else {
                $msg = $this->lang->line('error_on_kyc_category_deleted');
                $this->redirect($msg, "configuration/payout_setting", FALSE);
            }
        }

        $help_link = 'network-configuration';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function validate_payout_setting($post)
    {

        $min_payout = $post['min_payout'];
        $this->form_validation->set_rules('min_payout', lang('min_payout'), 'trim|required|numeric|greater_than[0]');
        $this->form_validation->set_rules('max_payout', lang('max_payout'), "trim|required|numeric|greater_than[0]|callback_check_database_maximum[$min_payout]");
        $this->form_validation->set_rules('payout_validity', lang('payout_validity'), 'trim|required|integer|greater_than[0]|max_length[5]');
        $this->form_validation->set_rules('payout_status', lang('payout_method'), 'required|in_list[from_ewallet,ewallet_request,both]', ['in_list' => 'You must select %s']);

        $res_val = $this->form_validation->run();

        return $res_val;
    }

    function check_database_maximum($max_payout, $min_payout)
    {

        if ($min_payout < $max_payout) {
            $flag = true;
        } else {
            $msg = $this->lang->line('maximum_payout_bellow_minimum_payout');
            $this->redirect($msg, 'configuration/payout_setting', FALSE);
            $flag = false;
        }

        return $flag;
    }

    function my_referal($page_id = "")
    {

        $title = $this->lang->line('view_my_refferals');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'view-my-referrals';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('view_my_refferals');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('view_my_refferals');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $is_valid_username = false;
        if ($this->input->post('user_name')) {
            $user_name = ($this->input->post('user_name', TRUE));

            $is_valid_username = $this->validation_model->isUserNameAvailable($user_name);

            if (!$is_valid_username) {
                $this->session->unset_userdata("is_valid_username");
                $msg = lang('Username_not_Exists');
                $this->redirect($msg, 'configuration/my_referal', false);
            }
            if ($this->validate_my_referal()) {
                $this->session->set_userdata("is_valid_username", $user_name);
            } else {
                $this->session->unset_userdata("is_valid_username");
            }
        }
        $user_name = $this->session->userdata("is_valid_username");
        $user_id = $this->validation_model->userNameToID($user_name);
        $view = 'no';
        $basurl = base_url() . 'admin/configuration/my_referal';
        $config = $this->pagination->customize_style();
        $config['base_url'] = $basurl;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $config['num_links'] = 5;
        $config['uri_segment'] = 4;
        $total_rows = $this->configuration_model->getReferalDetailscount($user_id);

        $config['total_rows'] = $total_rows;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $res = $this->configuration_model->getReferalDetails($user_id, $config['per_page'], $page);
        $result_per_page = $this->pagination->create_links();
        $count = count($res);
        $is_valid_username = $user_name;
        $this->set('arr', $res);
        $this->set('count', $count);
        $this->set('user_name', $user_name);
        $this->set('result_per_page', $result_per_page);
        $this->set('view', $view);
        $this->set('is_valid_username', $is_valid_username);
        $this->set('page_id', $page_id);

        $this->setView();
    }

    function validate_my_referal()
    {
        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function set_module_status()
    {

        $title = lang('Set_Module_Status');
        $this->set("title", "$this->COMPANY_NAME | $title");

        $this->HEADER_LANG['page_top_header'] = lang('Set_Module_Status');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('Set_Module_Status');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $payout_release = $this->configuration_model->getPayOutTypes();

        if ($this->input->post('set_module_status')) {

            $module_name = $this->input->post('module_name', TRUE);
            $new_module_status = $this->input->post('module_status', TRUE);

            $res = $this->configuration_model->setModuleStatus($module_name, $new_module_status);

            if ($res) {
                $msg = $this->lang->line('Module_Status_Updated_Successfully');
                $this->redirect($msg, 'configuration/set_module_status', true);
            } else {
                $msg = $this->lang->line('Error_on_updating_Module_status_please_try_again');
                $this->redirect($msg, 'configuration/set_module_status', false);
            }
        }

        $help_link = 'module-status';
        $this->set('help_link', $help_link);


        $this->setView();
    }

    function pin_config($action = '', $epin_id = '')
    {

        $title = lang('epin_settings');
        $this->set("title", $this->COMPANY_NAME . " | $title ");
        $this->url_permission('pin_status');

        $this->HEADER_LANG['page_top_header'] = lang('epin_settings');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('epin_settings');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $pin_status = $this->MODULE_STATUS['pin_status'];

        if ($pin_status == 'yes') {
            $pin_config = $this->configuration_model->getPinConfig();
            $this->set('pin_config', $pin_config);

            if ($this->input->post('update') && ($this->validate_pin_config())) {

                $pin_post_array = $this->input->post(NULL, TRUE);
                $pin_post_array = $this->validation_model->stripTagsPostArray($pin_post_array);

                $pin_character_set = $pin_post_array['pin_character'];
                $pin_maxcount = $pin_post_array['pin_maxcount'];
                $pin_length = 10;
                if (is_numeric($pin_maxcount)) {
                    $res = $this->configuration_model->setPinConfig($pin_length, $pin_maxcount, $pin_character_set);
                }
                if ($res) {
                    $data = serialize($pin_post_array);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'epin configuration updated', $this->LOG_USER_ID, $data);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_epin_config', 'E-PIN Configuration Updated');
                    }
                    //
                    //insert configuration_change_history
                    $pin_history = "Updated E-Pin configuration as its Max Count:" . $pin_maxcount . ", ";
                    if (isset($pin_post_array['pin_value'])) {
                        $pin_history .= "Pin Value:" . $pin_value . ", ";
                    }
                    $pin_history .= "E-pin character :" . $pin_character_set;

                    $this->configuration_model->insertConfigChangeHistory('E-Pin settings', $pin_history);
                    $pin_history = "";
                    //
                    $msg = $this->lang->line('pin_configuration_updated_sucessfully');
                    $this->redirect($msg, 'configuration/pin_config', true);
                } else {
                    $msg = $this->lang->line('error_on_updating_configuration_please_try_again');
                    $this->redirect($msg, 'configuration/pin_config', false);
                }
            }
        }


        if ($this->input->post('add_amount') && $this->validate_add_new_epin_amount()) {

            $pin_post_array = $this->input->post(NULL, TRUE);
            $pin_post_array = $this->validation_model->stripTagsPostArray($pin_post_array);

            $res = $this->epin_model->addPinAmount($pin_post_array['pin_amount']);
            if ($res == true) {
                $data = serialize($pin_post_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'new epin added', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'add_epin_amount', 'E-PIN Amount Added');
                }
                //
                //insert configuration_change_history
                $pin_history = "Added new E-Pin with amount:" . $this->DEFAULT_SYMBOL_LEFT . $pin_post_array['pin_amount'] . $this->DEFAULT_SYMBOL_RIGHT;

                $this->configuration_model->insertConfigChangeHistory('E-Pin settings', $pin_history);
                $pin_history = "";
                //
                $msg = lang('pin_amount_added_sucess');
                $this->redirect($msg, 'configuration/pin_config', true);
            } else {
                $msg = lang('unable_to_add_pin_amount');
                $this->redirect($msg, 'configuration/pin_config', false);
            }
        }

        if ($action == 'delete') {
            $this->block_preset_demo_action('pin_config');
            $pin_post_array['pin_id'] = $epin_id;
            $pin_post_array['delete_amount'] = "delete_amount";
            $pin_post_array = $this->validation_model->stripTagsPostArray($pin_post_array);
            //insert configuration_change_history
            $this->load->model('epin_model');
            $amount = $this->epin_model->getPinbyId($pin_post_array['pin_id']);

            $pin_history = "Deleted an E-Pin with id :" . $pin_post_array['pin_id'] . ", ";
            $pin_history .= "E-pin Amount :" . $this->DEFAULT_SYMBOL_LEFT . $amount . $this->DEFAULT_SYMBOL_RIGHT;
            $this->configuration_model->insertConfigChangeHistory('E-Pin settings', $pin_history);
            $pin_history = "";
            //
            $res = $this->epin_model->deletePinAmount($pin_post_array['pin_id']);
            if ($res) {
                $data = serialize($pin_post_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'epin deleted', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'delete_epin', 'E-PIN Deleted');
                }
                //

                $msg = lang('pin_amount_deleted_sucess');
                $this->redirect($msg, 'configuration/pin_config', true);
            } else {
                $msg = lang('unable_to_delete_pin_amount');
                $this->redirect($msg, 'configuration/pin_config', false);
            }
        }

        $pin_amounts = $this->epin_model->getAllEwalletAmounts();
        $count = count($pin_amounts);
        $this->set('pin_amounts', $pin_amounts);
        $this->set('count', $count);

        $help_link = 'e-pin-configuration';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function validate_add_new_epin_amount()
    {
        if (!$this->input->post('pin_amount') && $this->input->post('pin_amount') != 0) {
            $msg = lang('add_new_epin_amount');
            $this->redirect($msg, 'configuration/pin_config', FALSE);
        } else {

            $pin_post_array = $this->input->post(NULL, TRUE);
            $pin_post_array = $this->validation_model->stripTagsPostArray($pin_post_array);

            if ($this->input->post('pin_amount') > 0) {
                $check = $this->epin_model->check_pin_amount($pin_post_array['pin_amount']);
                if ($check) {
                    $msg = lang('epin_amount_allready_available');
                    $this->redirect($msg, 'configuration/pin_config', false);
                } else {
                    $this->form_validation->set_rules('pin_amount', lang('epin_amount'), 'trim|required|numeric|greater_than[0]');
                    $res_val = $this->form_validation->run();

                    return $res_val;
                }
            } else {
                $msg = lang('values_greater_than_0');
                $this->redirect($msg, 'configuration/pin_config', FALSE);
            }
        }
    }

    function validate_pin_config()
    {
        $this->form_validation->set_rules('pin_maxcount', lang('maximun_active_e_pin'), 'trim|required|integer|greater_than[0]');
        $this->form_validation->set_rules('pin_character', lang('ein_character'), 'required|in_list[alphabet,numeral,alphanumeric]', ['in_list' => 'You must select %s']);
        $res_val = $this->form_validation->run();

        return $res_val;
    }

    function validate_username_config()
    {
        $res_val = FALSE;
        if ($this->input->post('user_name_type') == 'dynamic') {
            $this->form_validation->set_rules('length', lang('user_name_length'), 'trim|required|numeric');
            if ($this->input->post('prefix_status')) {
                $this->form_validation->set_rules('prefix', lang('prefix'), 'trim|required');
            }
            $this->form_validation->set_error_delimiters("<div style='color:#b94a48;'>", '</div>');
            $res_val = $this->form_validation->run();
        } elseif ($this->input->post('user_name_type') == 'static') {
            $res_val = TRUE;
        }
        return $res_val;
    }

    function validate_signup_config()
    {
        $res_val = true;
        if ($this->input->post('age_limit_status')) {
            $this->form_validation->set_rules('age_limit', lang('age'), 'trim|required|integer|greater_than[0]');
            $res_val = $this->form_validation->run();
        }
        return $res_val;
    }

    function validate_welcome_letter()
    {

        $this->form_validation->set_rules('txtDefaultHtmlArea', lang('main_matter'), 'trim|required');
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    function validate_terms()
    {
        $tab1 = $tab3 = $tab4 = $tab5 = "";
        $tab2 = ' active';
        $this->session->set_userdata('inf_content_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3, 'tab4' => $tab4, 'tab5' => $tab5));

        $this->form_validation->set_rules('txtDefaultHtmlArea1', lang('terms_and_conditions'), 'trim|required');
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    function content_management($lang_id = NULL, $tab = NULL)
    {

        $title = $this->lang->line('content_management');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('content_management');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('content_management');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        if ($lang_id == NULL)
            $lang_id = $this->LANG_ID;

        $this->set('lang_id', $lang_id);
        $terms = $this->configuration_model->getTermsConditionsSettings($lang_id);
        $this->set('terms', $terms);
        $tab1 = ' active';
        $tab2 = $tab3 = $tab4 = $tab5 = $tab6= "";
        if ($tab == "tabs-2") {
            $tab1 = $tab3 = $tab4 = $tab5 = "";
            $tab2 = ' active';
        }
         if ($tab == "tabs-3") {
            $tab1 = $tab2 = $tab4 = $tab5 = "";
            $tab3 = ' active';
        }
        $user_id = $this->LOG_USER_ID;

        $reg_mail = $this->configuration_model->getEmailManagementContent('registration');
        $reg_mail['content'] = str_replace("{banner_img}", $this->PUBLIC_URL . 'images/banners/banner.jpg', $reg_mail['content']);
        $this->set('reg_mail', $reg_mail);

        $payout_release = $this->configuration_model->getEmailManagementContent('payout_release');
        $payout_release['content'] = str_replace("{banner_img}", $this->PUBLIC_URL . 'images/banners/banner.jpg', $payout_release['content']);
        $this->set('payout_release', $payout_release);

        if ($this->MODULE_STATUS['replicated_site_status'] == 'yes') {
            $flag = TRUE;
            $type = array();
            $content = '';
            $banners = $this->configuration_model->selectBanner($user_id);
            $this->set("banners", $banners);
            $i = 0;
            foreach ($banners as $rows) {
                $type[$i] = $rows['subject'];
                $content[$rows['subject']] = $rows['content'];
                $i++;
            }
            if (in_array('content', $type)) {
                $val = json_decode($content['content'], TRUE);
                if ($val) {
                    $sub_title = $val['sub_title'];
                    $description = $val['content'];
                }
            } else {
                $sub_title = 'The Infinite MLM software';
                $description = 'The Infinite MLM software is an entire solution for all type of business plan like Binary,Matrix, Unilevel and many other compensation plans. This is developed by a leading MLM software development company Infinite Open Source Solutions LLP™. More over these we are keen to construct MLM software as per the business plan suggested by the clients.This MLM software is featured of with integrated with SMS, E-Wallet, Replicating Website, E-Pin, E-Commerce Shopping Cart,Web Design';
            }
            $this->set('subtitle', $sub_title);
            $this->set('description', $description);
            if ($banners == '') {
                $flag = FALSE;
            }
            $this->set('flag', $flag);
            $this->set('content', $content);
            $this->set('type', $type);
        }

        if ($this->input->post('content_submit') && $this->validate_terms()) {
            $tab1 = $tab3 = $tab4 = $tab5 = "";
            $tab2 = ' active';
            $post = $this->input->post(NULL, TRUE);
            $post = $this->validation_model->stripTagsPostArray($post);
            $post['txtDefaultHtmlArea1'] = $this->validation_model->stripTagTextArea($this->input->post('txtDefaultHtmlArea1'));
            $lang_id = $post['lang_id'];
            $this->session->set_userdata('inf_content_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3, 'tab4' => $tab4, 'tab5' => $tab5));
            $resu = $this->configuration_model->updateTermsConditionsSettings($post);
            if ($resu) {
                $data = serialize($post);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'terms and conditions updated', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_terms_conditions', 'Terms And Conditions Updated');
                }
                //

                $msg = $this->lang->line('terms_and_conditions_successfull');
                $this->redirect($msg, "configuration/content_management/$lang_id", TRUE);
            } else {
                $msg = $this->lang->line('error_on_terms_and_conditions_updation');
                $this->redirect($msg, "configuration/content_management/$lang_id", FALSE);
            }
        }

        if ($lang_id == NULL)
            $lang_id = $this->LANG_ID;
        $this->set('lang_id', $lang_id);

        $letter_arr = $this->configuration_model->getLetterSetting($lang_id);
        $this->set('letter_arr', $letter_arr);

        if ($this->MODULE_STATUS['lang_status'] == 'yes') {
            $lang_arr = $this->configuration_model->getLanguages();
            $this->set('lang_arr', $lang_arr);
        }
        if ($this->input->post('setting') && $this->validate_welcome_letter()) {
            $tab1 = ' active';
            $tab2 = $tab3 = $tab4 = $tab5 = $tab6 = "";
            $this->session->set_userdata('inf_content_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3, 'tab4' => $tab4, 'tab5' => $tab5, 'tab6' =>$tab6));
            $post = $this->input->post(NULL, TRUE);
            $post = $this->validation_model->stripTagsPostArray($post);
            $post['txtDefaultHtmlArea'] = $this->validation_model->stripTagTextArea($this->input->post('txtDefaultHtmlArea'));
            $post['product_matter'] = $this->validation_model->stripTagTextArea($this->input->post('product_matter'));
            $lang_id = $post['lang_id'];
            $site_info = $this->validation_model->getSiteInformation();
            $post['logo_name'] = $site_info['logo'];
            $res = $this->configuration_model->updateLetterSetting($post);
            if ($res) {
                $data = serialize($post);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'welcome letter updated', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_welcome_letter', 'Welcome Letter Updated');
                }
                //

                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/content_management/$lang_id", TRUE);
            } else {
                $msg = $this->lang->line('error_on_configuration_updation');
                $this->redirect($msg, "configuration/content_management/$lang_id", FALSE);
            }
        }

        if ($this->input->post('reg_update')) {
            $tab3 = ' active';
            $tab1 = $tab2 = $tab4 = $tab5 =$tab6= "";
            $this->session->set_userdata('inf_content_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3, 'tab4' => $tab4, 'tab5' => $tab5, 'tab6' => $tab6));
            
            $this->form_validation->set_rules('subject', lang('subject'), 'required');
            $this->form_validation->set_rules('mail_content', lang('mail_content'), 'required');
            $val = $this->form_validation->run();
            if ($val) {
                $reg_mail_arr = $this->input->post(NULL, TRUE);
                $reg_mail_arr['mail_content'] = $this->validation_model->stripTagTextArea($this->input->post('mail_content'));
                $res = $this->configuration_model->updateEmailManagement($reg_mail_arr, 'registration');
                if ($res) {
                    $data = serialize($reg_mail_arr);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'registration email updated', $this->LOG_USER_ID, $data);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_registration_mail', 'Registration Email Updated');
                    }
                    //

                    $msg = lang('registration_mail_updated');
                    $this->redirect($msg, 'configuration/content_management', TRUE);
                } else {
                    $msg = lang('registration_mail_not_updated');
                    $this->redirect($msg, 'configuration/content_management', FALSE);
                }
            }
        }

        if ($this->input->post('payout_release')) {
            $tab4 = ' active';
            $tab1 = $tab2 = $tab3 = $tab5 = $tab6= "";
            $this->session->set_userdata('inf_content_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3, 'tab4' => $tab4, 'tab5' => $tab5, 'tab6' => $tab6));
            
            $this->form_validation->set_rules('subject1', lang('subject'), 'required');
            $this->form_validation->set_rules('mail_content1', lang('mail_content'), 'required');
            $val = $this->form_validation->run();
            if ($val) {
                $payout_release_arr = $this->input->post(NULL, TRUE);
                $payout_release_arr = $this->validation_model->stripTagsPostArray($payout_release_arr);
                $payout_release_arr['subject'] = $payout_release_arr['subject1'];
                $payout_release_arr['mail_content'] = $this->validation_model->stripTagTextArea($this->input->post('mail_content1'));
                $res = $this->configuration_model->updateEmailManagement($payout_release_arr, 'payout_release');
                if ($res) {
                    $data = serialize($payout_release_arr);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'payout release email updated', $this->LOG_USER_ID, $data);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_payout_release_mail', 'Payout Release Email Updated');
                    }
                    //

                    $msg = lang('payout_release_mail_updated');
                    $this->redirect($msg, 'configuration/content_management', TRUE);
                } else {
                    $msg = lang('payout_release_mail_not_updated');
                    $this->redirect($msg, 'configuration/content_management', FALSE);
                }
            }
        }

        if ($this->input->post('submit_video')) {
            $tab5 = ' active';
            $tab1 = $tab2 = $tab3 = $tab4 =$tab6= "";
            $this->session->set_userdata('inf_content_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3, 'tab4' => $tab4, 'tab5' => $tab5, 'tab6' => $tab6));
            
            $link = $this->input->post('banner_link', TRUE);
            $res = FALSE;
            if ($this->validate_link($this->input->post('banner_link'))) {
                $res = $this->member_model->insertBannerforReplica('video', 'link', $link, $user_id);
                if ($res) {

                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Video updated for Replica', $this->LOG_USER_ID);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Video Banner updated', 'Video Banner Updated for Replica');
                    }
                    //

                    $msg = lang('video_banner_updated');
                    $this->redirect($msg, "configuration/content_management", TRUE);
                } else {
                    $msg = lang('error_on_updation');
                    $this->redirect($msg, "configuration/content_management", FALSE);
                }
            }
        }
        if ($this->input->post('submit_image')) {
            $tab5 = ' active';
            $tab1 = $tab2 = $tab3 = $tab4 = $tab6= "";
            $this->session->set_userdata('inf_content_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3, 'tab4' => $tab4, 'tab5' => $tab5, 'tab6' => $tab6));
            $details = array();

            $config['upload_path'] = IMG_DIR . 'banners';
            $config['allowed_types'] = 'png|jpeg|jpg';
            $config['max_size'] = '2048';
            $config['remove_spaces'] = true;
            $config['overwrite'] = FALSE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('banner_image')) {
                $error = array('error' => $this->upload->display_errors());
                $error = $this->validation_model->stripTagsPostArray($error);
                $error = $this->validation_model->escapeStringPostArray($error);
                if ($error['error'] == 'You did not select a file to upload.') {
                    $msg = lang('please_select_file');
                    $this->redirect($msg, "configuration/content_management", false);
                }
                if ($error['error'] == 'The file you are attempting to upload is larger than the permitted size.') {
                    $msg = lang('max_size_2MB');
                    $this->redirect($msg, "configuration/content_management/", false);
                }
                if ($error['error'] == 'The filetype you are attempting to upload is not allowed') {
                    $msg = lang('please_choose_a_png_file.');
                    $this->redirect($msg, "configuration/content_management", false);
                } else {
                    $msg = 'Error uploading file';
                    $this->redirect($msg, 'configuration/content_management', false);
                }
            } else {
                $banner_arr = array('upload_data' => $this->upload->data());
            }
            $details['product_url'] = $banner_arr['upload_data']['file_name'];

            $res = $this->member_model->insertBannerforReplica('top_banner', 'image', $banner_arr['upload_data']['file_name'], $user_id);

            if ($res) {

                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Top Banner updated for Replica', $this->LOG_USER_ID);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Top Banner Updated', 'Top Banner updated for Replica');
                }
                //

                $msg = lang('top_banner_updated');
                $this->redirect($msg, "configuration/content_management", TRUE);
            } else {
                $msg = lang('error_on_updation');
                $this->redirect($msg, "configuration/content_management", FALSE);
            }
        }
        if ($this->input->post('submit_movbanner')) {
            $tab5 = ' active';
            $tab1 = $tab2 = $tab3 = $tab4 = "";
            $this->session->set_userdata('inf_content_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3, 'tab4' => $tab4, 'tab5' => $tab5));
            $details = array();

            $config['upload_path'] = '../replica/public_html/images/banner';
            $config['allowed_types'] = 'png|jpeg|jpg';
            $config['max_size'] = '2048';
            $config['remove_spaces'] = true;
            $config['overwrite'] = FALSE;

            $this->load->library('upload', $config);
            $flag1 = FALSE;
            $flag2 = FALSE;
            $flag3 = FALSE;
            $flag4 = FALSE;
            if (in_array('moving_banner1', $type)) {
                $flag1 = TRUE;
            }
            if (in_array('moving_banner2', $type)) {
                $flag2 = TRUE;
            }
            if (in_array('moving_banner3', $type)) {
                $flag3 = TRUE;
            }
            if (in_array('moving_banner4', $type)) {
                $flag4 = TRUE;
            }
            if (($_FILES['moving_banner1']['name'] == '' && $flag1 == FALSE) || ($_FILES['moving_banner2']['name'] == '' && $flag2 == FALSE) || ($_FILES['moving_banner3']['name'] == '' && $flag3 == FALSE) || ($_FILES['moving_banner4']['name'] == '' && $flag4 == FALSE)) {
                $msg = lang('please_upload_four_banners');
                $this->redirect($msg, "configuration/content_management", false);
            }
            if (empty($_FILES['moving_banner1']['name']) && empty($_FILES['moving_banner2']['name']) && empty($_FILES['moving_banner3']['name']) && empty($_FILES['moving_banner4']['name'])) {
                $msg = lang('please_select_file');
                $this->redirect($msg, "configuration/content_management", false);
            }
            if ($_FILES['moving_banner1']['name'] != '') {

                if (!$this->upload->do_upload('moving_banner1')) {

                    $error = array('error' => $this->upload->display_errors());
                    $error = $this->validation_model->stripTagsPostArray($error);
                    $error = $this->validation_model->escapeStringPostArray($error);

                    if ($error['error'] == 'The file you are attempting to upload is larger than the permitted size.') {
                        $msg = lang('max_size_2MB');
                        $this->redirect($msg, "configuration/content_management/", false);
                    }
                    if ($error['error'] == 'The filetype you are attempting to upload is not allowed') {
                        $msg = lang('please_choose_a_png_file.');
                        $this->redirect($msg, "configuration/content_management", false);
                    } else {


                        $msg = 'Error uploading file';
                        $this->redirect($msg, 'configuration/content_management', false);
                    }
                } else {
                    $mvb1 = array('upload_data' => $this->upload->data());
                    $res = $this->member_model->insertBannerforReplica('moving_banner1', 'image', $mvb1['upload_data']['file_name'], $user_id);
                }
            }
            if ($_FILES['moving_banner2']['name'] != '') {

                if (!$this->upload->do_upload('moving_banner2')) {

                    $error = array('error' => $this->upload->display_errors());
                    $error = $this->validation_model->stripTagsPostArray($error);
                    $error = $this->validation_model->escapeStringPostArray($error);

                    if ($error['error'] == 'The file you are attempting to upload is larger than the permitted size.') {
                        $msg = lang('max_size_2MB');
                        $this->redirect($msg, "configuration/content_management/", false);
                    }
                    if ($error['error'] == 'The filetype you are attempting to upload is not allowed') {
                        $msg = lang('please_choose_a_png_file.');
                        $this->redirect($msg, "configuration/content_management", false);
                    } else {


                        $msg = 'Error uploading file';
                        $this->redirect($msg, 'configuration/content_management', false);
                    }
                } else {

                    $mvb2 = array('upload_data' => $this->upload->data());
                    $res = $this->member_model->insertBannerforReplica('moving_banner2', 'image', $mvb2['upload_data']['file_name'], $user_id);
                }
            }
            if ($_FILES['moving_banner3']['name'] != '') {

                if (!$this->upload->do_upload('moving_banner3')) {

                    $error = array('error' => $this->upload->display_errors());
                    $error = $this->validation_model->stripTagsPostArray($error);
                    $error = $this->validation_model->escapeStringPostArray($error);

                    if ($error['error'] == 'The file you are attempting to upload is larger than the permitted size.') {
                        $msg = lang('max_size_2MB');
                        $this->redirect($msg, "configuration/content_management/", false);
                    }
                    if ($error['error'] == 'The filetype you are attempting to upload is not allowed') {
                        $msg = lang('please_choose_a_png_file.');
                        $this->redirect($msg, "configuration/content_management", false);
                    } else {


                        $msg = 'Error uploading file';
                        $this->redirect($msg, 'configuration/content_management', false);
                    }
                } else {
                    $mvb3 = array('upload_data' => $this->upload->data());
                    $res = $this->member_model->insertBannerforReplica('moving_banner3', 'image', $mvb3['upload_data']['file_name'], $user_id);
                }
            }
            if ($_FILES['moving_banner4']['name'] != '') {

                if (!$this->upload->do_upload('moving_banner4')) {

                    $error = array('error' => $this->upload->display_errors());
                    $error = $this->validation_model->stripTagsPostArray($error);
                    $error = $this->validation_model->escapeStringPostArray($error);

                    if ($error['error'] == 'The file you are attempting to upload is larger than the permitted size.') {
                        $msg = lang('max_size_20MB');
                        $this->redirect($msg, "configuration/content_management/", false);
                    }
                    if ($error['error'] == 'The filetype you are attempting to upload is not allowed') {
                        $msg = lang('please_choose_a_png_file.');
                        $this->redirect($msg, "configuration/content_management", false);
                    } else {


                        $msg = 'Error uploading file';
                        $this->redirect($msg, 'configuration/content_management', false);
                    }
                } else {
                    $mvb4 = array('upload_data' => $this->upload->data());
                    $res = $this->member_model->insertBannerforReplica('moving_banner4', 'image', $mvb4['upload_data']['file_name'], $user_id);
                }
            }

            if ($res) {

                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Moving Banner updated for Replica', $this->LOG_USER_ID);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Moving banner Updated', 'Moving Banner updated for Replica');
                }
                //

                $msg = lang('moving_banner_updated');
                $this->redirect($msg, "configuration/content_management", TRUE);
            } else {
                $msg = lang('error_on_updation');
                $this->redirect($msg, "configuration/content_management", FALSE);
            }
        }

        if ($this->input->post('replica_content')) {
            $tab5 = ' active';
            $tab1 = $tab2 = $tab3 = $tab4 = $tab6= "";
            $this->session->set_userdata('inf_content_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3, 'tab4' => $tab4, 'tab5' => $tab5, 'tab6' => $tab6));
            $post = $this->input->post(NULL, TRUE);
            $post = $this->validation_model->stripTagsPostArray($post);
            $det = array();
            $det['content'] = $this->validation_model->stripTagTextArea($this->input->post('replica_content_main'));
            $det['sub_title'] = $this->validation_model->stripTagTextArea($this->input->post('subtitle'));
            $encode_data = json_encode($det);
            if ($this->validate_content()) {
                $resu = $this->member_model->insertBannerforReplica('content', 'text', $encode_data, $user_id);
                if ($resu) {
                    $data = serialize($post);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Content of replica updated', $this->LOG_USER_ID, $data);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Content of replication site updated', 'Content of replica updated');
                    }
                    //

                    $msg = $this->lang->line('content_updated_successfull');
                    $this->redirect($msg, "configuration/content_management/", TRUE);
                } else {
                    $msg = $this->lang->line('error_on_updation');
                    $this->redirect($msg, "configuration/content_management/", FALSE);
                }
            }
        }
        if ($this->input->post('submit_term')) {
            $tab5 = ' active';
            $tab1 = $tab2 = $tab3 = $tab4 =$tab6= "";
            $this->session->set_userdata('inf_content_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3, 'tab4' => $tab4, 'tab5' => $tab5, 'tab6' => $tab6));
            $post = $this->input->post(NULL, TRUE);
            $post = $this->validation_model->stripTagsPostArray($post);
            $det = array();
            $det['content'] = $this->validation_model->stripTagTextArea($this->input->post('content_terms'));
            if ($this->validate_content()) {
                $resu = $this->member_model->insertBannerforReplica('terms', 'text', $det['content'], $user_id);
                if ($resu) {
                    $data = serialize($post);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Terms And Conditions Updated for Replica', $this->LOG_USER_ID, $data);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Terms And Conditions Updated for Replica', 'Terms And Conditions Updated for Replica');
                    }
                    //

                    $msg = $this->lang->line('terms_conditions_updated_successfull');
                    $this->redirect($msg, "configuration/content_management/", TRUE);
                } else {
                    $msg = $this->lang->line('error_on_updation');
                    $this->redirect($msg, "configuration/content_management/", FALSE);
                }
            }
        }
        if ($this->input->post('submit_policy')) {
            $tab5 = ' active';
            $tab1 = $tab2 = $tab3 = $tab4=$tab6= "";
            $this->session->set_userdata('inf_content_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3, 'tab4' => $tab4, 'tab5' => $tab5, 'tab6' => $tab6));
            $post = $this->input->post(NULL, TRUE);
            $post = $this->validation_model->stripTagsPostArray($post);
            $det = array();
            $det['content'] = $this->validation_model->stripTagTextArea($this->input->post('content_policy'));
            if ($this->validate_content()) {
                $resu = $this->member_model->insertBannerforReplica('policy', 'text', $det['content'], $user_id);
                if ($resu) {
                    $data = serialize($post);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Privacy Policy Updated for Replica', $this->LOG_USER_ID, $data);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Privacy Policy Updated for Replica', 'Privacy Policy Updated for Replica');
                    }
                    //

                    $msg = $this->lang->line('privacy_policy_updated_successfull');
                    $this->redirect($msg, "configuration/content_management/", TRUE);
                } else {
                    $msg = $this->lang->line('error_on_updation');
                    $this->redirect($msg, "configuration/content_management/", FALSE);
                }
            }
        }
        if ($this->input->post('submit_about')) {
            $tab5 = ' active';
            $tab1 = $tab2 = $tab3 = $tab4 = $tab6= "";
            $this->session->set_userdata('inf_content_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3, 'tab4' => $tab4, 'tab5' => $tab5, 'tab6' => $tab6));
            $post = $this->input->post(NULL, TRUE);
            $post = $this->validation_model->stripTagsPostArray($post);
            $det = array();
            $det['about_us'] = $this->validation_model->stripTagTextArea($this->input->post('content_about'));
            if ($this->validate_content()) {
                $resu = $this->member_model->insertBannerforReplica('about_us', 'text', $det['about_us'], $user_id);
                if ($resu) {
                    $data = serialize($post);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'About Us updated for Replica', $this->LOG_USER_ID, $data);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'About Us updated for Replica', 'About us Updated for Replica');
                    }
                    //

                    $msg = $this->lang->line('about_us_updated_successfull');
                    $this->redirect($msg, "configuration/content_management/", TRUE);
                } else {
                    $msg = $this->lang->line('error_on_updation');
                    $this->redirect($msg, "configuration/content_management/", FALSE);
                }
            }
        }
        if ($this->input->post('submit_address')) {
            $tab5 = ' active';
            $tab1 = $tab2 = $tab3 = $tab4 =$tab6= "";
            $this->session->set_userdata('inf_content_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3, 'tab4' => $tab4, 'tab5' => $tab5, 'tab6' => $tab6));
              $post = $this->input->post(NULL, TRUE);
            $post = $this->validation_model->stripTagsPostArray($post);
            $det = array();
            $det['contact'] = $this->validation_model->stripTagTextArea($this->input->post('address'));
            if ($this->validate_content()) {
                $resu = $this->member_model->insertBannerforReplica('address', 'text', $det['contact'], $user_id);
                if ($resu) {
                    $data = serialize($post);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Address Updated for Replica', $this->LOG_USER_ID, $data);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Address Updated for Replica', 'Address us Updated for Replica');
                    }
                    //

                    $msg = $this->lang->line('contact_us_updated_successfull');
                    $this->redirect($msg, "configuration/content_management/", TRUE);
                } else {
                    $msg = $this->lang->line('error_on_updation');
                    $this->redirect($msg, "configuration/content_management/", FALSE);
                }
            }
        }
        if ($this->input->post('submit_social')) {
            $tab5 = ' active';
            $tab1 = $tab2 = $tab3 = $tab4 = $tab6= "";
            $this->session->set_userdata('inf_content_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3, 'tab4' => $tab4, 'tab5' => $tab5, 'tab6' => $tab6));
            if ($this->validate_social_profile()) {
                $post = $this->input->post(NULL, TRUE);
                $post = $this->validation_model->stripTagsPostArray($post);
                $det = array();
                $resu = TRUE;
                if ($this->input->post('facebook')) {
                    $resu = $this->member_model->insertBannerforReplica('facebook', 'text', $post['facebook'], $user_id);
                }
                if ($this->input->post('twitter')) {
                    $resu = $this->member_model->insertBannerforReplica('twitter', 'text', $post['twitter'], $user_id);
                }
                if ($this->input->post('linkedin')) {
                    $resu = $this->member_model->insertBannerforReplica('linkedin', 'text', $post['linkedin'], $user_id);
                }
                if ($this->input->post('youtube')) {
                    $resu = $this->member_model->insertBannerforReplica('youtube', 'text', $post['youtube'], $user_id);
                }

                if ($this->input->post('google_plus')) {
                    $resu = $this->member_model->insertBannerforReplica('google_plus', 'text', $post['google_plus'], $user_id);
                }

                if ($this->input->post('instagram')) {
                    $resu = $this->member_model->insertBannerforReplica('instagram', 'text', $post['instagram'], $user_id);
                }
                if ($resu) {
                    $data = serialize($post);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Social Profile Updated for Replica', $this->LOG_USER_ID, $data);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Social Profile Updated for Replica', 'Social Profile Updated for Replica');
                    }
                    //

                    $msg = $this->lang->line('socail_profile_updated_successfull');
                    $this->redirect($msg, "configuration/content_management/", TRUE);
                } else {
                    $msg = $this->lang->line('error_on_updation');
                    $this->redirect($msg, "configuration/content_management/", FALSE);
                }
            }
        }
        if ($this->input->post('submit_upgrade_term')) {
            
            $tab3 = ' active';
            $tab1 = $tab2 = $tab5 = $tab4 = $tab6= "";
           $this->session->set_userdata('inf_content_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3, 'tab4' => $tab4, 'tab5' => $tab5, 'tab6' => $tab6));
             $post = $this->input->post(NULL, TRUE);
            $post = $this->validation_model->stripTagsPostArray($post);
            $det = array();
            $det['content'] = $this->validation_model->stripTagTextArea($this->input->post('content_terms'));
            if ($this->validate_content()) {
                $resu = $this->member_model->insertBannerforReplica('upgrade_terms_cond', 'text', $det['content'], $user_id);
                $result = $this->member_model->UpdateIntoUpgradeTerms($det['content']);
                if ($resu && $result) {
                    $data = serialize($post);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Terms And Conditions Updated for Replica', $this->LOG_USER_ID, $data);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Terms And Conditions Updated for Replica', 'Terms And Conditions Updated for Replica');
                    }
                    //

                    $msg = $this->lang->line('terms_conditions_updated_successfull');
                    $this->redirect($msg, "configuration/content_management/", TRUE);
                } else {
                    $msg = $this->lang->line('error_on_updation');
                    $this->redirect($msg, "configuration/content_management/", FALSE);
                }
            }
        }
         if ($this->input->post('submit_upgrade_text')) {
             
            $tab6 = ' active';
            $tab1 = $tab2 = $tab3 = $tab4 = $tab5= "";
            $this->session->set_userdata('inf_content_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3, 'tab4' => $tab4, 'tab5' => $tab5, 'tab6' => $tab6));
            $post = $this->input->post(NULL, TRUE);
            $post = $this->validation_model->stripTagsPostArray($post);
            $det = array();
            $det['content'] = $this->validation_model->stripTagTextArea($this->input->post('content_terms'));
            if ($this->validate_content()) {
                $resu = $this->member_model->insertBannerforReplica('upgrade_note', 'text', $det['content'], $user_id);
                if ($resu) {
                    $data = serialize($post);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Note during Upgradation', $this->LOG_USER_ID, $data);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Note during Upgradation', 'Note during Upgradation');
                    }
                    //

                    $msg = $this->lang->line('text_updated');
                    $this->redirect($msg, "configuration/content_management/", TRUE);
                } else {
                    $msg = $this->lang->line('error_on_updatn_text');
                    $this->redirect($msg, "configuration/content_management/", FALSE);
                }
            }
        }

        if ($this->session->userdata('inf_content_tab_active_arr')) {
            $tab_array = $this->session->userdata('inf_content_tab_active_arr');
            $tab1 = $tab_array['tab1'];
            $tab2 = $tab_array['tab2'];
            $tab3 = $tab_array['tab3'];
            $tab4 = $tab_array['tab4'];
            $tab5 = $tab_array['tab5'];
           $tab6 = $tab_array['tab6'];
            $this->session->unset_userdata('inf_content_tab_active_arr');
        }
        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);
        $this->set('tab3', $tab3);
        $this->set('tab4', $tab4);
        $this->set('tab5', $tab5);
        $this->set('tab6', $tab6);

        $help_link = 'content-management';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function mail_content($lang_id = NULL, $tab = NULL)
    {

        $title = $this->lang->line('mail_content');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('mail_content');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('mail_content');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        if ($lang_id == NULL)
            $lang_id = $this->LANG_ID;

        $this->set('lang_id', $lang_id);
        $tab3 = ' active';
        $tab2 = $tab1 = $tab4 = $tab5 = "";
        if ($tab == "tabs-2") {
            $tab1 = $tab3 = $tab4 = $tab5 = "";
            $tab2 = ' active';
        }

        $reg_mail = $this->configuration_model->getEmailManagementContent('registration');
        $reg_mail['content'] = str_replace("{banner_img}", $this->PUBLIC_URL . 'images/banners/banner.jpg', $reg_mail['content']);
        $this->set('reg_mail', $reg_mail);

        $payout_release = $this->configuration_model->getEmailManagementContent('payout_release');
        $payout_release['content'] = str_replace("{banner_img}", $this->PUBLIC_URL . 'images/banners/banner.jpg', $payout_release['content']);
        $this->set('payout_release', $payout_release);

        if ($lang_id == NULL)
            $lang_id = $this->LANG_ID;
        $this->set('lang_id', $lang_id);

        if ($this->MODULE_STATUS['lang_status'] == 'yes') {
            $lang_arr = $this->configuration_model->getLanguages();
            $this->set('lang_arr', $lang_arr);
        }

        if ($this->input->post('reg_update')) {
            $tab3 = ' active';
            $tab1 = $tab2 = $tab4 = $tab5 = "";
            $this->session->set_userdata('inf_content_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3, 'tab4' => $tab4, 'tab5' => $tab5));

            $this->form_validation->set_rules('subject', lang('subject'), 'required');
            $this->form_validation->set_rules('mail_content', lang('mail_content'), 'required');
            $val = $this->form_validation->run();
            if ($val) {
                $reg_mail_arr = $this->input->post(NULL, TRUE);
                $reg_mail_arr['mail_content'] = $this->validation_model->stripTagTextArea($this->input->post('mail_content'));
                $res = $this->configuration_model->updateEmailManagement($reg_mail_arr, 'registration');
                if ($res) {
                    $data = serialize($reg_mail_arr);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'registration email updated', $this->LOG_USER_ID, $data);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_registration_mail', 'Registration Email Updated');
                    }
                    //

                    $msg = lang('registration_mail_updated');
                    $this->redirect($msg, 'mail_content', TRUE);
                } else {
                    $msg = lang('registration_mail_not_updated');
                    $this->redirect($msg, 'mail_content', FALSE);
                }
            }
        }

        if ($this->input->post('payout_release')) {
            $tab4 = ' active';
            $tab1 = $tab2 = $tab3 = $tab5 = "";
            $this->session->set_userdata('inf_content_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3, 'tab4' => $tab4, 'tab5' => $tab5));

            $this->form_validation->set_rules('subject1', lang('subject'), 'required');
            $this->form_validation->set_rules('mail_content1', lang('mail_content'), 'required');
            $val = $this->form_validation->run();
            if ($val) {
                $payout_release_arr = $this->input->post(NULL, TRUE);
                $payout_release_arr = $this->validation_model->stripTagsPostArray($payout_release_arr);
                $payout_release_arr['subject'] = $payout_release_arr['subject1'];
                $payout_release_arr['mail_content'] = $this->validation_model->stripTagTextArea($this->input->post('mail_content1'));
                $res = $this->configuration_model->updateEmailManagement($payout_release_arr, 'payout_release');
                if ($res) {
                    $data = serialize($payout_release_arr);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'payout release email updated', $this->LOG_USER_ID, $data);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_payout_release_mail', 'Payout Release Email Updated');
                    }
                    //

                    $msg = lang('payout_release_mail_updated');
                    $this->redirect($msg, 'mail_content', TRUE);
                } else {
                    $msg = lang('payout_release_mail_not_updated');
                    $this->redirect($msg, 'mail_content', FALSE);
                }
            }
        }
        

        if ($this->session->userdata('inf_content_tab_active_arr')) {
            $tab_array = $this->session->userdata('inf_content_tab_active_arr');
            $tab1 = $tab_array['tab1'];
            $tab2 = $tab_array['tab2'];
            $tab3 = $tab_array['tab3'];
            $tab4 = $tab_array['tab4'];
            $tab5 = $tab_array['tab5'];
            $this->session->unset_userdata('inf_content_tab_active_arr');
        }
        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);
        $this->set('tab3', $tab3);
        $this->set('tab4', $tab4);
        $this->set('tab5', $tab5);

        $help_link = 'content-management';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function validate_content_management($active_tab)
    {

        if ($active_tab == 'tab1') {
            $this->form_validation->set_rules('company_name', lang('company_name'), 'trim|required');
            $this->form_validation->set_rules('company_add', lang('company_address'), 'trim|required');
            $this->form_validation->set_rules('place', lang('place'), 'trim|required');
        } else if ($active_tab == 'tab2') {

            $this->form_validation->set_rules(' lang_selector', lang('Select_a_Language'), 'trim|required');
        }

        $res_val = $this->form_validation->run();
        return $res_val;
    }

    function site_information()
    {

        $title = lang('company_profile');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "site-information";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('company_profile');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('company_profile');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

        $tab1 = ' active';
        $tab3 = NULL;
        $active_tab = 'tab1';

        $def_admin_theme = $this->configuration_model->getAdminThemeFolder();
        $admin_themes = array();
        $admin_directories = glob(APPPATH . 'views/admin/layout/themes/*');
        foreach ($admin_directories as $directory) {
            $name = basename($directory);
            $admin_themes[] = array(
                "name" => $name,
                "default" => ($def_admin_theme == $name) ? 1 : 0,
                "icon" => $name . "/theme.png",
                "image" => $name . "/theme.png"
            );
        }
        rsort($admin_themes);

        $def_user_theme = $this->configuration_model->getUserThemeFolder();
        $user_themes = array();
        $user_directories = glob(APPPATH . 'views/user/layout/themes/*');
        foreach ($user_directories as $user_directory) {
            $name = basename($user_directory);
            $user_themes[] = array(
                "name" => $name,
                "default" => ($def_user_theme == $name) ? 1 : 0,
                "icon" => $name . "/theme.png",
                "image" => $name . "/theme.png"
            );
        }
        rsort($user_themes);

        if ($this->MODULE_STATUS['lang_status'] == 'yes') {
            $lang = $this->configuration_model->getLanguages();
            $this->set('lang', $lang);
        }

        $site_info_arr = $this->configuration_model->getSiteConfiguration();
        $def_lang = $site_info_arr['default_lang'];
        $thumbnail_logo = $site_info_arr["logo"];
        $thumbnail_favicon = $site_info_arr["favicon"];

        $social_follower_count_arr = $this->configuration_model->getSocialMediaFollowersCount();
        $social_profile_link_arr = $this->configuration_model->getSocialMediaLinks();

        if ($this->input->post('active_tab')) {
            $active_tab = $this->input->post('active_tab', TRUE);
        }

        if (($this->input->post('site')) && $this->validate_site_info()) {
            $site_post_array = $this->input->post(NULL, TRUE);
            $site_post_array = $this->validation_model->stripTagsPostArray($site_post_array);
            $nam = $site_post_array['co_name'];
            $address = $this->validation_model->textAreaLineBreaker($site_post_array['company_address']);
            $email = $site_post_array['email'];
            $phone = $site_post_array['phone'];

            if (!empty($_FILES['img_logo']) or !empty($_FILES['favicon'])) {
                $upload_config = $this->validation_model->getUploadConfig();

                $upload_count = $this->validation_model->getUploadCount($this->ADMIN_USER_ID);
                if ($upload_count >= $upload_config) {
                    $msg = lang('you_have_reached_max_upload_limit');
                    $this->redirect($msg, "configuration/site_information", FALSE);
                }
            }
            $admin_user_id = $this->ADMIN_USER_ID;
            $random_number = floor($admin_user_id * rand(1000, 9999));
            $config['file_name'] = "logo_" . $random_number;
            $config['upload_path'] = IMG_DIR . 'logos/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
            $config['max_size'] = '2048';
            $config['remove_spaces'] = true;
            $config['overwrite'] = false;

            $this->load->library('upload', $config);
            $msg = "";

            if (!$this->upload->do_upload('img_logo')) {
                $error = array('error' => $this->upload->display_errors());
                $error = $this->validation_model->stripTagsPostArray($error);
                $error = $this->validation_model->escapeStringPostArray($error);
                if ($error['error'] == 'The file you are attempting to upload is larger than the permitted size.' || $error['error'] == 'The uploaded file exceeds the maximum allowed size in your PHP configuration file') {
                    $msg = lang('max_size_2MB');
                    $this->redirect($msg, "configuration/site_information", FALSE);
                } else if ($error['error'] == 'The filetype you are attempting to upload is not allowed.') {
                    $msg = lang('filetype_not_allowed');
                    $this->redirect($msg, "configuration/site_information", FALSE);
                } else if ($error['error'] == 'Invalid file name.') {
                    $msg = lang('invalid_file_name');
                    $this->redirect($msg, "configuration/site_information", FALSE);
                }
            } else {
                $image_arr = array('upload_data' => $this->upload->data());
                $new_file_name = $image_arr['upload_data']['file_name'];
                $image = $image_arr['upload_data'];

                //thumbnail creation start
                $config1['image_library'] = 'gd2';
                $config1['source_image'] = $image['full_path'];
                $config1['create_thumb'] = TRUE;
                $config1['maintain_ratio'] = TRUE;
                $config1['width'] = 178;
                $config1['height'] = 73;

                $active_tab = $this->input->post('active_tab', TRUE);
                if ($active_tab == 'tab1') {
                    $tab1 = ' active';
                    $tab3 = NULL;
                } else if ($active_tab == 'tab3') {
                    $tab3 = ' active';
                    $tab1 = NULL;
                }
                $this->session->set_userdata('inf_config_tab_active_arr', array('tab1' => $tab1, 'tab3' => $tab3));
                $this->load->library('image_lib', $config1);
                $this->image_lib->initialize($config1);
                if (!$this->image_lib->resize()) {
                    $msg = $this->lang->line('image_cannot_be_uploaded');
                    $this->redirect($msg, "configuration/site_information", FALSE);
                } else {
                    // get file THUMBNAIL image name //
                    $thumbnail_logo = $image_arr['upload_data']['raw_name'] . '_thumb' . $image_arr['upload_data']['file_ext'];
                    $this->validation_model->updateUploadCount($this->ADMIN_USER_ID);
                }
                //THUMBNAIL ENDS
            }

            $config['file_name'] = "fav_" . $random_number;
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('favicon')) {
                $error = array('error' => $this->upload->display_errors());
                $error = $this->validation_model->stripTagsPostArray($error);
                $error = $this->validation_model->escapeStringPostArray($error);
                if ($error['error'] == 'The file you are attempting to upload is larger than the permitted size.' || $error['error'] == 'The uploaded file exceeds the maximum allowed size in your PHP configuration file') {
                    $msg = lang('max_size_2MB');
                    $this->redirect($msg, "configuration/site_information", FALSE);
                } else if ($error['error'] == 'The filetype you are attempting to upload is not allowed.') {
                    $msg = lang('filetype_not_allowed');
                    $this->redirect($msg, "configuration/site_information", FALSE);
                } else if ($error['error'] == 'Invalid file name.') {
                    $msg = lang('invalid_file_name');
                    $this->redirect($msg, "configuration/site_information", FALSE);
                }
            } else {
                $image_arr = array('upload_data' => $this->upload->data());
                $new_file_name = $image_arr['upload_data']['file_name'];
                $image = $image_arr['upload_data'];

                //thumbnail creation start
                $config1['image_library'] = 'gd2';
                $config1['source_image'] = $image['full_path'];
                $config1['create_thumb'] = TRUE;
                $config1['maintain_ratio'] = FALSE;
                $config1['width'] = 16;
                $config1['height'] = 16;

                $this->load->library('image_lib', $config1);
                $this->image_lib->initialize($config1);
                if (!$this->image_lib->resize()) {
                    $msg = $this->lang->line('image_cannot_be_uploaded');
                    $this->redirect($msg, "configuration/site_information", FALSE);
                } else {
                    // get file THUMBNAIL image name //
                    $thumbnail_favicon = $image_arr['upload_data']['raw_name'] . '_thumb' . $image_arr['upload_data']['file_ext'];
                    $this->validation_model->updateUploadCount($this->ADMIN_USER_ID);
                }
                //THUMBNAIL ENDS
            }

            $res = $this->configuration_model->siteConfiguration($nam, $address, $def_lang, $email, $phone, $thumbnail_logo, $thumbnail_favicon);
            if ($res) {
                $data = serialize($site_post_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'site information updated', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_site_information', 'Site Information Updated');
                }
                //

                $msg = $this->lang->line('site_configuration_completed');
                $this->redirect($msg, "configuration/site_information", TRUE);
            } else {
                $msg = $this->lang->line('error_on_site_configuration');
                $this->redirect($msg, "configuration/site_information", FALSE);
            }
        }

        if (($this->input->post('update_social_count')) && $this->validate_social_count()) {
            $flag = 'no';
            $active_tab = 'tab3';
            if ($active_tab == 'tab3') {
                $tab3 = ' active';
                $tab1 = NULL;
            }

            $this->session->set_userdata('inf_config_tab_active_arr', array('tab1' => $tab1, 'tab3' => $tab3));
            $social_count_arr = $this->input->post(NULL, TRUE);

            $res = $this->configuration_model->updateSocialProfileCountAndLink($social_count_arr, $flag);
            $active_tab = $this->input->post('active_tab', TRUE);
            if ($flag == 'yes') {
                $this->redirect($msg, "configuration/site_information", FALSE);
            }
            if ($res) {
                $data = serialize($social_count_arr);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Social profile count updated', $this->LOG_USER_ID, $data);
                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_social_profile_count', 'Social profile count updated');
                }
                //

                $msg = $this->lang->line('social_profile_updated');
                $this->redirect($msg, "configuration/site_information", TRUE);
            } else {

                $msg = $this->lang->line('error_on_social_count_updated');
                $this->redirect($msg, "configuration/site_information", FALSE);
            }
        } else {
            // $tab3 = ' active';
            // $tab1 = NULL;
        }

        if ($this->session->userdata('inf_config_tab_active_arr')) {
            $tab_arr = $this->session->userdata('inf_config_tab_active_arr');
            $tab1 = $tab_arr['tab1'];
            $tab3 = $tab_arr['tab3'];
            $this->session->unset_userdata('inf_config_tab_active_arr');
        }

        $this->set('default_lang', $def_lang);
        $this->set("site_info_arr", $site_info_arr);

        $this->set('def_admin_theme_folder', $def_admin_theme);
        $this->set('admin_themes', $admin_themes);
        $this->set('def_user_theme_folder', $def_user_theme);
        $this->set('user_themes', $user_themes);

        $this->set('social_count', $social_follower_count_arr);

        $this->set('social_link', $social_profile_link_arr);
        $this->set('baseurl', base_url());
        $this->set('tab1', $tab1);
        $this->set('tab3', $tab3);

        $this->setView();
    }

    public function validate_site_info()
    {
        $this->form_validation->set_rules('co_name', lang('company_name'), 'trim|required');
        $this->form_validation->set_rules('company_address', lang('company_address'), 'trim|required|max_length[100]');
        $this->form_validation->set_rules('email', lang('email'), 'trim|required|valid_email');
        $this->form_validation->set_rules('phone', lang('phone'), 'trim|required|regex_match[/^\d{5,10}$/]', ['regex_match' => lang('you_must_enter_phone')]);

        $res_val = $this->form_validation->run();
        return $res_val;
    }

    function validate_social_profile()
    {
        $this->form_validation->set_rules('facebook', lang('facebook'), 'trim|callback_facebook_checking');
        $this->form_validation->set_message('facebook_checking', lang('facebook_url_is_not_valid'));
        $this->form_validation->set_rules('youtube', lang('youtube'), 'trim|callback_youtube_checking');
        $this->form_validation->set_message('youtube_checking', lang('youtube_url_is_not_valid'));
        $this->form_validation->set_rules('twitter', lang('twitter'), 'trim|callback_twitter_checking');
        $this->form_validation->set_message('twitter_checking', lang('twitter_url_is_not_valid'));
        $this->form_validation->set_rules('google_plus', lang('google_plus'), 'trim|callback_google_checking');
        $this->form_validation->set_message('google_checking', lang('google_plus_url_is_not_valid'));
        $this->form_validation->set_rules('linkedin', lang('linkedin'), 'trim|callback_linkedin_checking');
        $this->form_validation->set_message('linkedin_checking', lang('linkedin_url_is_not_valid'));
        $this->form_validation->set_rules('instagram', lang('instagram'), 'trim|callback_instagram_checking');
        $this->form_validation->set_message('instagram_checking', lang('instagram_url_is_not_valid'));

        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->error_array();
            $this->session->set_userdata('error', $error);
        } else {
            return TRUE;
        }
    }

    function validate_social_count()
    {

        $this->form_validation->set_rules('fb_count', lang('fb_count'), 'trim|required|is_natural');
        $this->form_validation->set_message('required', 'You must enter facebook followers count');
        $this->form_validation->set_rules('twitter_count', lang('twitter_count'), 'trim|required|is_natural');
        $this->form_validation->set_rules('inst_count', lang('inst_count'), 'trim|required|is_natural');
        // $this->form_validation->set_rules('gplus_count', lang('gplus_count'), 'trim|required|is_natural');
        $this->form_validation->set_rules('fb_link', lang('fb_link'), 'trim|regex_match[/^http(s)?:\/\/(www[.])?facebook\.com\/([a-zA-Z0-9_]+)$/]', ['regex_match' => lang('facebook_url_is_not_valid')]);
        $this->form_validation->set_rules('twitter_link', lang('twitter_link'), 'trim|regex_match[/^http(s)?:\/\/(?:www\.)?twitter\.com\/([a-zA-Z0-9_]+)$/]', ['regex_match' => lang('twitter_url_is_not_valid')]);
        $this->form_validation->set_rules('inst_link', lang('inst_link'), 'trim|regex_match[/http(s)?:\/\/(www\.)?instagram\.com\/([a-zA-Z0-9_]+)$/]', ['regex_match' => lang('instagram_url_is_not_valid')]);
        // $this->form_validation->set_rules('gplus_link', lang('gplus_link'), 'trim|regex_match[/^http(s)?:\/\/(www[.])?plus\.google\.com\/([a-zA-Z0-9_]+)$/]', ['regex_match' => lang('google_plus_url_is_not_valid')]);
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    function mail_settings()
    {

        $title = $this->lang->line('mail_configuration');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('mail_configuration');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('mail_configuration');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $mail_details = $this->configuration_model->getMailDetails();
        $this->set('mail_details', $mail_details);
        if ($this->input->post('update') && $this->validate_mail_settings($mail_details)) {

            $settings_post_array = $this->input->post(NULL, TRUE);
            $settings_post_array = $this->validation_model->stripTagsPostArray($settings_post_array);

            $mail_setting['reg_mail_type'] = $settings_post_array['reg_mail_type'];
            $mail_setting['smtp_host'] = $settings_post_array['smtp_host'];
            $mail_setting['smtp_username'] = $settings_post_array['smtp_username'];
            $mail_setting['smtp_password'] = $settings_post_array['smtp_password'];
            $mail_setting['smtp_port'] = $settings_post_array['smtp_port'];
            $mail_setting['smtp_timeout'] = $settings_post_array['smtp_timeout'];
            $mail_setting['smtp_authentication'] = $settings_post_array['smtp_auth_type'];
            $mail_setting['smtp_protocol'] = $settings_post_array['smtp_protocol'];

            $res = $this->configuration_model->updateMailSettings($mail_setting);
            if ($res) {
                $login_id = $this->LOG_USER_ID;
                $data = serialize($mail_setting);
                $this->validation_model->insertUserActivity($login_id, 'mail config updated', $login_id, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_mail_config', 'Mail Configuration Updated');
                }
                //

                $msg = $this->lang->line('mail_settings_updated_successfully');
                $this->redirect($msg, 'configuration/mail_settings', true);
            } else {
                $msg = $this->lang->line('Error_on_mail_settings_updation');
                $this->redirect($msg, 'configuration/mail_settings', false);
            }
        }
        if ($this->MODULE_STATUS['mail_gun_status'] == 'yes') {

            $mailgun_details = $this->configuration_model->getMailGunConfig();
            $this->set('mailgun_details', $mailgun_details);

            if ($this->input->post('mail_gun') && $this->validate_mail_gun_settings()) {

                $settings_post_array = $this->input->post(NULL, TRUE);
                $settings_post_array = $this->validation_model->stripTagsPostArray($settings_post_array);

                $mail_setting['from_name'] = $settings_post_array['from_name'];
                $mail_setting['from_email'] = $settings_post_array['from_email'];
                $mail_setting['reply_to'] = $settings_post_array['reply_to'];
                $mail_setting['domain'] = $settings_post_array['domain'];
                $mail_setting['api_key'] = $settings_post_array['api_key'];

                $res = $this->configuration_model->updateMailGunSettings($mail_setting);
                if ($res) {
                    $login_id = $this->LOG_USER_ID;
                    $data = serialize($mail_setting);
                    $this->validation_model->insertUserActivity($login_id, 'mail config updated', $login_id, $data);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_mail_config', 'Mail Configuration Updated');
                    }
                    //

                    $msg = $this->lang->line('mail_settings_updated_successfully');
                    $this->redirect($msg, 'configuration/mail_settings', true);
                } else {
                    $msg = $this->lang->line('Error_on_mail_settings_updation');
                    $this->redirect($msg, 'configuration/mail_settings', false);
                }
            }
        }

        $help_link = 'rank-configuration';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function validate_mail_settings($mail_details)
    {
        $this->form_validation->set_rules('reg_mail_type', lang('registration_mail_type'), 'required');
        if ($mail_details["reg_mail_type"] == "smtp") {
            $this->form_validation->set_rules('smtp_host', lang('smtp_host'), 'required');
            $this->form_validation->set_rules('smtp_username', lang('smtp_username'), 'required');
            $this->form_validation->set_rules('smtp_password', lang('smtp_password'), 'required');
            $this->form_validation->set_rules('smtp_port', lang('smtp_port'), 'required');
            $this->form_validation->set_rules('smtp_timeout', lang('smtp_timeout'), 'required');
            $this->form_validation->set_rules('smtp_auth_type', lang('smtp_authentiction'), 'required');
            $this->form_validation->set_rules('smtp_protocol', lang('smtp_protocol'), 'required');
        }

        $res_val = $this->form_validation->run();

        return $res_val;
    }

    function validate_mail_gun_settings()
    {
        $this->form_validation->set_rules('from_name', lang('from_name'), 'trim|required|min_length[3]|max_length[32]');
        $this->form_validation->set_rules('from_email', lang('from_email'), 'trim|required|valid_email');
        $this->form_validation->set_rules('reply_to', lang('reply_to'), 'trim|required|valid_email');
        $this->form_validation->set_rules('domain', lang('domain'), 'trim|required|min_length[3]|max_length[32]');
        $this->form_validation->set_rules('api_key', lang('api_key'), 'trim|required|min_length[3]|max_length[32]');
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    function board_configuration($action = NULL, $edit_id = NULL)
    {

        $title = $this->lang->line('board_settings');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('board_settings');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('board_settings');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();
        $this->set('edit_id', null);
        $this->set('board_id', null);
        $this->set('board_width', null);
        $this->set('board_depth', null);
        $this->set('board_name', null);
        $this->set('board_commission', null);
        $this->set('sponser_follow_status', null);
        $this->set('re_entry_status', null);
        $this->set('re_entry_to_next_status', null);
        if ($action == 'edit') {

            $row = $this->configuration_model->selectBoardDetails($edit_id);
            $this->set('edit_id', $edit_id);
            $this->set('board_width', $row['board_width']);
            $this->set('board_depth', $row['board_depth']);
            $this->set('board_name', $row['board_name']);
            $this->set('board_commission', $row['board_commission']);
            $this->set('sponser_follow_status', $row['sponser_follow_status']);
            $this->set('re_entry_status', $row['re_entry_status']);
            $this->set('re_entry_to_next_status', $row['re_entry_to_next_status']);
        }

        if ($this->input->post('board_update') && $this->validate_board_configuration()) {
            $this->set('edit_id', $edit_id);

            $board_post_array = $this->input->post(NULL, TRUE);
            $board_post_array = $this->validation_model->stripTagsPostArray($board_post_array);

            $board_width = $board_post_array['board_width'];
            $board_depth = $board_post_array['board_depth'];
            $board_name = $board_post_array['board_name'];
            $board_commission = $board_post_array['board_commission'];
            $re_entry_status = $board_post_array['re_entry_status'];
            $sponser_follow_status = $board_post_array['sponser_follow_status'];
            $re_entry_to_next_status = $board_post_array['re_entry_to_next_status'];
            $res = $this->configuration_model->updateBoard($edit_id, $board_width, $board_depth, $board_name, $board_commission, $re_entry_status, $sponser_follow_status, $re_entry_to_next_status);
            if ($res) {
                $msg = $this->lang->line('board_updated_successfully');
                $this->redirect($msg, 'configuration/board_configuration', TRUE);
            } else {
                $msg = $this->lang->line('Error_On_Updating_board');
                $this->redirect($msg, 'configuration/board_configuration', FALSE);
            }
        }

        $board_details = $this->configuration_model->getAllBoardDetails();
        $count = count($board_details);
        $this->set('board_details', $board_details);
        $this->set('count', $count);

        $help_link = 'board-configuration';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function validate_board_configuration()
    {

        $this->form_validation->set_rules('board_commission', lang('board_commission'), 'trim|required');

        $this->form_validation->set_rules('board_width', lang('board_width'), 'trim|required');
        $this->form_validation->set_rules('board_depth', lang('board_depth'), 'trim|required');

        $this->form_validation->set_rules('board_name', lang('board_name'), 'trim|required');
        $this->form_validation->set_rules('re_entry_status', lang('re_entry_status'), 'trim|required');
        $this->form_validation->set_rules('sponser_follow_status', lang('sponser_follow_status'), 'trim|required');

        $this->form_validation->set_rules('re_entry_to_next_status', lang('re_entry_to_next_status'), 'trim|required');

        $res_val = $this->form_validation->run();

        return $res_val;
    }

    function rank_configuration($action = NULL, $edit_id = NULL)
    {

        $title = $this->lang->line('rank_settings');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->url_permission('rank_status');

        $this->HEADER_LANG['page_top_header'] = lang('rank_settings');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('rank_settings');
        $this->HEADER_LANG['page_small_header'] = lang('');
        $this->load_langauge_scripts();
        $commission_type = $this->validation_model->getConfig('sponsor_commission_type');
        if($this->input->post()) {
            $rank_post_array = $this->input->post(NULL, TRUE);
            $rank_post_array = $this->validation_model->stripTagsPostArray($rank_post_array);
            $result = FALSE;

               /* if($this->validate_rank_settings()) {
                    if (!array_key_exists('rank_criteria', $rank_post_array)) {
                        $msg = $this->lang->line('atleast_check_one_criteria');
                        $this->redirect($msg, "configuration/rank_configuration", false);
                    }*/
                    // if (array_key_exists('rank_criteria', $rank_post_array)) {
                    //     print_r($rank_post_array); die;
                    //     $this->redirect('error_on_configuration_updation', "configuration/rank_configuration", false);
                    // }
                   // $result = $this->configuration_model->updateRankConfig($rank_post_array, $this->DEFAULT_CURRENCY_VALUE);
               /* } else {
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $this->redirect($msg, "configuration/rank_configuration", false);
                }*/

            if ($result) {
                 //insert configuration_change_history
                $rank_maintain_day_history = "Updated rank maintain day limit: " . serialize($rank_post_array);
                $this->configuration_model->insertConfigChangeHistory('rank maintain day limit settings', $rank_maintain_day_history);
                
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'commission_setting', 'Commission Settings Updated');
                }
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/rank_configuration", true);
            } else {
                if (empty($this->form_validation->error_array())) {
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $this->redirect($msg, "configuration/rank_configuration", false);
                }
            }
        }

        $obj_arr = $this->configuration_model->getRankConfiguration();

        $rank_details = $this->configuration_model->getAllRankDetails();
        $commission_type = $this->validation_model->getConfig('sponsor_commission_type');
        $joined_package_details = $this->configuration_model->getjoinedPackageDetails();
        $count = count($rank_details);
        $active_rank_details = $this->configuration_model->getActiveRankDetails();
        $this->set('active_rank_details', $active_rank_details);
        $this->set('commission_type', $commission_type);
        $this->set('rank_details', $rank_details);
        $this->set('count', $count);
        $this->set('joined_package_details', $joined_package_details);
        $help_link = 'rank-configuration';
        $this->set('help_link', $help_link);
        $this->set('obj_arr', $obj_arr);
        
        $minimum_leg = $this->configuration_model->getConfiguration('minimum_leg');
        $this->set('minimum_leg', $minimum_leg);

        $this->setView();
    }
    
    
    
    function minimum_leg()
    {

       
        if($this->input->post()) {

            $rank_post_array = $this->input->post(NULL, TRUE);
            
            if (!is_numeric($rank_post_array['minimum_leg'])) {
                $msg = $this->lang->line('error_on_configuration_updation');
                $this->redirect($msg, "configuration/rank_configuration", false);  
             }
             
             
            $result = FALSE;

                if($this->validate_minimum_leg()) {
                   
                    $result = $this->configuration_model->updateConfiguration('minimum_leg',$rank_post_array['minimum_leg']);
                } else {
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $this->redirect($msg, "configuration/rank_configuration", false);
                }

            if ($result) {
               
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/rank_configuration", true);
            } else {
                
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $this->redirect($msg, "configuration/rank_configuration", false);  
            }
        }

    }


    public function validate_minimum_leg()
    {
        //$this->form_validation->set_rules("minimum_leg", lang('minimum_leg'), 'trim|required');
        $this->form_validation->set_rules('minimum_leg', 'minimum_leg', 'trim|required|greater_than[0]');
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    function inactivate_rank($rank_id = '')
    {
        $msg = '';
        $result = $this->configuration_model->inactivate_rank($rank_id);
        $rank_config = $this->configuration_model->getRankConfiguration();
        if($rank_config['default_rank_id'] == $rank_id) {
            $this->configuration_model->UpdateRankConfigurationByKey('default_rank_id', 0);
        }
        if ($result) {
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Rank Deactivated', $this->LOG_USER_ID, $data = '');
            // Employee Activity History
            if ($this->LOG_USER_TYPE == 'employee') {
                $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'inactivate_rank', 'Rank Deactivated');
            }
            //
            //insert configuration_change_history
            $row = $this->configuration_model->selectRankDetails($rank_id);
            $rank_history = "Inactivated the rank : " . serialize($row);
            $this->configuration_model->insertConfigChangeHistory('rank settings', $rank_history);
            //
            $msg = $this->lang->line('rank_inactivated_successfully');
            $this->redirect($msg, 'configuration/rank_configuration', TRUE);
        } else {
            $msg = $this->lang->line('error_on_inactivating_rank');
            $this->redirect($msg, 'configuration/rank_configuration', FALSE);
        }
    }

    function activate_rank($rank_id = '')
    {
        $msg = '';
        $result = $this->configuration_model->activate_rank($rank_id);
        if ($result) {
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Rank Activated', $this->LOG_USER_ID, $data = '');
            // Employee Activity History
            if ($this->LOG_USER_TYPE == 'employee') {
                $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'activate_rank', 'Rank Activated');
            }
            //
            //insert configuration_change_history
            $row = $this->configuration_model->selectRankDetails($rank_id);
            $rank_history = "Activated the rank : " . serialize($row);
            $this->configuration_model->insertConfigChangeHistory('rank settings', $rank_history);
            //
            $msg = $this->lang->line('rank_activated_successfully');
            $this->redirect($msg, 'configuration/rank_configuration', TRUE);
        } else {
            $msg = $this->lang->line('error_on_inactivating_rank');
            $this->redirect($msg, 'configuration/rank_configuration', FALSE);
        }
    }

    function validate_rank_configuration()
    {
        $rank_config = $this->configuration_model->getRankConfiguration();

        $this->form_validation->set_rules('rank_name', lang('rank_name'), 'trim|required|strip_tags|max_length[32]|callback__alpha_dash_space');
        $this->form_validation->set_rules('rank_achievers_bonus', lang('rank_achieved_bonus'), 'trim|required|greater_than_equal_to[0]');
        $this->form_validation->set_rules("rank_color", lang('rank_color'), 'trim|required');
        // $this->form_validation->set_rules('ref_count', lang('referal_count'), 'trim|required|max_length[5]|greater_than[0]|integer');
        // $this->form_validation->set_message('valid_referal_count', lang('referal_count_not_available'));
        if ($rank_config['referal_count']) {
            $this->form_validation->set_rules('ref_count', lang('referal_count'), 'trim|required|greater_than_equal_to[0]|integer|max_length[5]');
        }
        if ($rank_config['personal_pv']) {
            $this->form_validation->set_rules('personal_pv', lang('personal_pv'), 'trim|required|greater_than_equal_to[0]|max_length[5]');
        }
        if ($rank_config['group_pv']) {
            $this->form_validation->set_rules('gpv', lang('gpv'), 'trim|required|greater_than_equal_to[0]|max_length[5]');
        }
        if ($this->MLM_PLAN == "Binary" || $this->MLM_PLAN == "Matrix") {
            if ($rank_config['downline_member_count']) {
                $this->form_validation->set_rules('downline_count', lang('downline_count'), 'trim|required|max_length[5]|greater_than[0]|integer');
            }
            if ($rank_config['downline_purchase_count']) {
                $this->form_validation->set_rules('package_count[]', lang('package_count'), 'trim|required|max_length[5]|greater_than[0]|integer');
            }
            if ($rank_config['downline_rank']) {
                if($this->input->post('downline_rank_count'))
                    $this->form_validation->set_rules('downline_rank_count[]', lang('downline_rank_count'), 'trim|required|max_length[5]|greater_than[0]|integer');
            }
        }
        if ($this->MODULE_STATUS['referal_status'] == 'yes') {
            $commission_type = $this->validation_model->getConfig('sponsor_commission_type');
            if ($commission_type == "rank") {
                $this->form_validation->set_rules('ref_commission', lang('referal_commission'), 'trim|required|greater_than_equal_to[0]|max_length[5]');
            }
        }
        return $this->form_validation->run();
    }

    function _alpha_dash_space($str)
    {
        if ($str != '' && !preg_match("/^([-a-z_0-9 ])+$/i", $str)) {
            $this->form_validation->set_message('_alpha_dash_space', lang('the_%s_field_may_only_contain_alpha-numeric_characters'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function paypal_config()
    {

        $title = $this->lang->line('paypal_configuration');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('paypal_configuration');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('paypal_configuration');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $paypal_details = array();
        $paypal_details = $this->configuration_model->getPaypalConfigDetails();
        $this->set('paypal_details', $paypal_details);

        //to set redirection of back buttons
        $link_origin = $_SESSION['link_origin'] ?? 0;
        if ($this->input->get('from') == 'payout_settings') {
            $link_origin = 1;
            $this->session->set_userdata("link_origin", $link_origin);
        }

        if (!empty($this->session->userdata('link_origin'))) {
            $link_origin = $this->session->userdata('link_origin');
        }

        $this->set('link_origin', $link_origin);
        if ($this->input->post('update_paypal') && $this->validate_paypal_config()) {
            if (!empty($this->session->userdata('link_origin'))) {
                $link_origin = $this->session->userdata('link_origin');
            }
            $update_post_array = $this->input->post(NULL, TRUE);
            $update_post_array = $this->validation_model->stripTagsPostArray($update_post_array);

            $api_username = $update_post_array['api_username'];
            $api_password = $update_post_array['api_password'];
            $api_signature = $update_post_array['api_signature'];
            $mode = $update_post_array['mode'];
            $currency = $update_post_array['currency'];
            $return_url = $update_post_array['return_url'];
            $cancel_url = $update_post_array['cancel_url'];

            $res = $this->configuration_model->updatePaypalConfig($api_username, $api_password, $api_signature, $mode, $currency, $return_url, $cancel_url);

            if ($res) {
                $msg = $this->lang->line('paypal_configuration_updated_successfully');
                if ($link_origin == 1) {
                    $this->redirect($msg, 'configuration/paypal_config?from=payout_settings', true);
                } else {
                    $this->redirect($msg, 'configuration/paypal_config', true);
                }
            } else {
                $msg = $this->lang->line('Error_on_updating_paypal_status_please_try_again');
                if ($link_origin == 1) {
                    $this->redirect($msg, 'configuration/paypal_config?from=payout_settings', false);
                } else {
                    $this->redirect($msg, 'configuration/paypal_config', false);
                }
            }
        }

        $help_link = 'paypal-settings';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function validate_paypal_config()
    {

        $this->form_validation->set_rules('api_username', lang('api_username'), 'trim|required');
        $this->form_validation->set_rules('api_password', lang('api_password'), 'trim|required');
        $this->form_validation->set_rules('api_signature', lang('api_signature'), 'trim|required');
        $this->form_validation->set_rules('mode', lang('mode'), 'trim|required');
        $this->form_validation->set_rules('currency', lang('currency'), 'trim|required');
        $this->form_validation->set_rules('return_url', lang('return_url'), 'trim|required');
        $this->form_validation->set_rules('cancel_url', lang('cancel_url'), 'trim|required');

        $res_val = $this->form_validation->run();

        return $res_val;
    }

    function payment_gateway_configuration()
    {

        $title = lang('payment_gateway_configuration');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('payment_gateway_configuration');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('payment_gateway_configuration');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();
        if (!empty($this->session->userdata('link_origin'))) {
            $this->session->unset_userdata('link_origin');
        }

        $update_array_check = array();
        $card_status = $this->configuration_model->getCreditCardStatus();
        $this->set('card_status', $card_status);
        if ($this->input->post('update')) {

            $loop_count = $this->input->post('number', TRUE);
            for ($i = 1; $i <= $loop_count; $i++) {
                if ($this->input->post("sort_order$i")) {
                    $update_array_check["srt_order$i"] = $this->input->post("sort_order$i");
                    $update_array["srt_order$i"] = $this->input->post("sort_order$i");
                    $update_array["id$i"] = $this->input->post("id$i");
                }
            }
            if (!array_diff_key($update_array_check, array_unique($update_array_check))) {
                //insert configuration_change_history
                $gate_history = "Updated sort order:";
                for ($i = 1; $i <= $loop_count; $i++) {
                    $update_sort = $this->configuration_model->updateSortOrder($update_array["id$i"], $update_array["srt_order$i"]);
                    $res1 = $this->configuration_model->getCreditCardDetails($update_array["id$i"]);
                    $gate_history .= "Gateway : " . $res1['gateway_name'] . ",";
                    $gate_history .= "new position :" . $res1["sort_order"] . ";";
                }
                $card_status = $this->configuration_model->getCreditCardStatus();
                $this->set('card_status', $card_status);
                $this->configuration_model->insertConfigChangeHistory('payment gateway settings', $gate_history);
                $gate_history = "";
                //
            }
            if (isset($update_sort)) {
                $msg = $this->lang->line('sort_order_updated_successfully');
                $this->redirect($msg, 'configuration/payment_gateway_configuration', true);
            } else {
                $msg = $this->lang->line('Sort order should be unique');
                $this->redirect($msg, 'configuration/payment_gateway_configuration', false);
            }
        }
        $help_link = 'credit-card-settings';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function payment_view()
    {

        $title = $this->lang->line('payment_view');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('payment_view');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('payment_view');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $payment_methods = $this->configuration_model->getPaymentMethods();
        $this->set('payment_methods', $payment_methods);
        $card_status = $this->configuration_model->getPayoutGateways();
        $this->set('card_status', $card_status);

        $help_link = 'payment-settings';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function change_module_status()
    {
        $login_id = $this->LOG_USER_ID;
        $module_name = $this->input->post('module_name', TRUE);
        $new_status = $this->input->post('module_status', TRUE);
        if ($module_name == "google_auth_status")
            $new_status = ($new_status == 'yes') ? 'no' : 'yes';
        if ($new_status == 'no') {
            $payment_active_count = 1;
            if ($module_name == 'ewallet_status') {
                $payment_active_count = $this->configuration_model->checkAtleastOnePaymentActive(3);
                if ($payment_active_count) {
                    $this->configuration_model->setPaymentStatus(3, $new_status);
                }
            }
            if ($module_name == 'pin_status') {
                $payment_active_count = $this->configuration_model->checkAtleastOnePaymentActive(2);
                if ($payment_active_count) {
                    $this->configuration_model->setPaymentStatus(2, $new_status);
                }
            }
            if (!$payment_active_count) {
                $this->redirect('Atleast one payment method should be active. Please select one option', 'configuration/payment_view', false);
            }
        }

        $res = $this->configuration_model->setModuleStatus($module_name, $new_status);
        if ($res) {
            $login_id = $this->LOG_USER_ID;
            $data_array = array();
            $data_array['module_name'] = $module_name;
            $data_array['new_module_status'] = $new_status;
            $data = serialize($data_array);
            $this->validation_model->insertUserActivity($login_id, 'module status changed', $login_id, $data);

            // Employee Activity History
            if ($this->LOG_USER_TYPE == 'employee') {
                $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'set_module_status', 'Module Status Changed');
            }
            //
            echo json_encode(array('response' => TRUE));
            //            $msg = $this->lang->line('Module_Status_Updated_Successfully');
            //            $this->redirect($msg, 'configuration/set_module_status', true);
        } else {
            echo json_encode(array('response' => FALSE));
            //            $msg = $this->lang->line('error_on_updation');
            //            $this->redirect($msg, 'configuration/set_module_status', false);
        }
    }

    function change_language_status()
    {
        $lang_id = $this->input->post('lang_id', TRUE);
        $new_status = $this->input->post('status', TRUE);
        $this->configuration_model->setLanguageStatus($lang_id, $new_status);
    }

    function sms_settings()
    {

        $title = $this->lang->line('sms_setting');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->url_permission('sms_status');

        $this->HEADER_LANG['page_top_header'] = lang('sms_settings');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('sms_settings');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $result = $this->configuration_model->getSmsConfigDetails();

        if ($this->input->post('sms_config') && $this->validate_sms_settings()) {

            $sms_post_array = $this->input->post(NULL, TRUE);
            $sms_post_array = $this->validation_model->stripTagsPostArray($sms_post_array);

            $details['sender_id'] = $sms_post_array['sender_id'];
            $details['user_name'] = $sms_post_array['user_name'];
            $details['password'] = $sms_post_array['password'];

            $rec = $this->configuration_model->setSmsConfig($details);

            if ($rec) {
                $data = serialize($details);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'sms config updated', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_sms_setting', 'SMS Settings Updated');
                }
                //

                $msg = $this->lang->line('successfully_inserted');
                $this->redirect($msg, 'configuration/sms_settings', true);
            } else {

                $msg = $this->lang->line('insertion_failed');
                $this->redirect($msg, 'configuration/sms_settings', false);
            }
        }

        $help_link = 'sms_setting';
        $this->set('help_link', $help_link);
        $this->setView();
    }

    function validate_sms_settings()
    {

        $this->form_validation->set_rules('sender_id', lang('sender_id'), 'trim|required');
        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required');
        $this->form_validation->set_rules('password', lang('password'), 'trim|required');

        $res_val = $this->form_validation->run();

        return $res_val;
    }

    function language_settings()
    {

        $title = lang('set_language_status');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->url_permission('lang_status');

        $this->HEADER_LANG['page_top_header'] = lang('set_language_status');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('set_language_status');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $help_link = 'multi_language';
        $this->set('help_link', $help_link);

        $language_array = $this->configuration_model->getLanguageStatus();
        $this->set('language_array', $language_array);

        $this->set('tran_yes', $this->lang->line('yes'));
        $this->set('tran_no', $this->lang->line('no'));

        $this->setView();
    }

    function authorize_config()
    {

        $title = $this->lang->line('authorize_configuration');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('authorize_configuration');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('authorize_configuration');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $authorize_details = $this->configuration_model->getAuthorizeConfigDetails();
        $this->set('authorize_details', $authorize_details);

        //to set redirection of back buttons
        $link_origin = $_SESSION['link_origin'] ?? 0;
        if ($this->input->get('from') == 'payout_settings') {
            $link_origin = 1;
            $this->session->set_userdata("link_origin", $link_origin);
        }
        $this->set('link_origin', $link_origin);

        if ($this->input->post('update_authorize') && $this->validate_authorize_config()) {
            if (!empty($this->session->userdata('link_origin'))) {
                $link_origin = $this->session->userdata('link_origin');
            }
            $settings_post_array = $this->input->post(NULL, TRUE);
            $settings_post_array = $this->validation_model->stripTagsPostArray($settings_post_array);

            if ($this->input->post('merchant_log_id')) {
                $merchant_id = $settings_post_array['merchant_log_id'];
            } else {
                $msg = $this->lang->line('you_must_enter_merchant_id');
                if ($link_origin == 1) {
                    $this->redirect($msg, 'configuration/authorize_config?from=payout_settings', false);
                } else {
                    $this->redirect($msg, 'configuration/authorize_config', false);
                }
            }
            if ($this->input->post('transaction_key')) {

                $transaction_key = $settings_post_array['transaction_key'];
            } else {
                $msg = $this->lang->line('you_must_enter_transaction_password');
                if ($link_origin == 1) {
                    $this->redirect($msg, 'configuration/authorize_config?from=payout_settings', false);
                } else {
                    $this->redirect($msg, 'configuration/authorize_config', false);
                }
            }
            $res = $this->configuration_model->updateAuthorizeConfig($merchant_id, $transaction_key);

            if ($res) {
                $msg = $this->lang->line('paypal_configuration_updated_successfully');
                if ($link_origin == 1) {
                    $this->redirect($msg, 'configuration/authorize_config?from=payout_settings', true);
                } else {
                    $this->redirect($msg, 'configuration/authorize_config', true);
                }
            } else {
                $msg = $this->lang->line('Error_on_updating_paypal_status_please_try_again');
                if ($link_origin == 1) {
                    $this->redirect($msg, 'configuration/authorize_config?from=payout_settings', false);
                } else {
                    $this->redirect($msg, 'configuration/authorize_config', false);
                }
            }
        }

        $help_link = NULL;
        $this->set('help_link', $help_link);
        $this->setView();
    }

    function validate_authorize_config()
    {

        $this->form_validation->set_rules('transaction_key', lang('cancel_url'), 'trim|required');
        $this->form_validation->set_rules('merchant_log_id', lang('api_url'), 'trim|required');

        $res_val = $this->form_validation->run();
        return $res_val;
    }

    function delete_message($redirect, $id)
    {

        $res = $this->configuration_model->deleteMessage($id);
        if ($res) {
            $msg = $this->lang->line('message_deleted_successfully');
            $this->redirect($msg, 'configuration/$redirect', TRUE);
        } else {
            $msg = $this->lang->line('error_on_deletion');
            $this->redirect($msg, 'configuration/$redirect', TRUE);
        }
    }

    function change_credit_card_status()
    {

        $id = $this->input->post('id', TRUE);
        $new_status = $this->input->post('module_status', TRUE);
        $new_status = ($new_status == 'yes') ? 'no' : 'yes';
        if ($new_status == 'no') {
            $payment_active_count = $this->configuration_model->checkAtleastOneCreditCardActive($id);
            if (!$payment_active_count) {
                $this->redirect('Atleast one payment method should be active. Please select one option', 'configuration/payment_view', false);
            }
        }

        $res = $this->configuration_model->setCreditCardStatus($id, $new_status);
        //insert configuration_change_history
        $res1 = $this->configuration_model->getCreditCardDetails($id);
        if ($new_status == 'no') {
            $gate_history = "Uninstalled the gateway ";
        } else {
            $gate_history = "Installed the gateway ";
        }
        $gate_history .= "named " . $res1['gateway_name'];

        $this->configuration_model->insertConfigChangeHistory('payment gateway settings', $gate_history);
        $gate_history = "";
        //
    }

    function change_payment_status()
    {

        $id = $this->input->post('id', TRUE);
        $new_status = $this->input->post('module_status', TRUE);
        $new_status = ($new_status == 'yes') ? 'no' : 'yes';
        if ($new_status == 'no') {
            $payment_active_count = $this->configuration_model->checkAtleastOnePaymentActive($id);
            if (!$payment_active_count) {
                $this->redirect('Atleast one payment method should be active. Please select one option', 'configuration/payment_view', false);
            }
        }

        $res = $this->configuration_model->setPaymentStatus($id, $new_status);
        if ($res) {
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Payment Settings Updated', $this->LOG_USER_ID, $data = '');
            // Employee Activity History
            if ($this->LOG_USER_TYPE == 'employee') {
                $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'change_payment_setting', 'Payment Settings Updated');
            }
            //
            echo json_encode(array('response' => TRUE));
            //            $msg = lang('Payment_Status_Updated_Successfully');
            //            $this->redirect($msg, 'configuration/payment_view', TRUE);
        } else {
            echo json_encode(array('response' => FALSE));
            //            $msg = lang('Error_on_updating_payment_status_please_try_again');
            //            $this->redirect($msg, 'configuration/payment_view', FALSE);
        }
        exit();
    }

    function getUsernamePrefix()
    {

        $prefix = $this->configuration_model->getUsernamePrefix();
        if ($prefix != NULL) {
            echo $prefix;
        }
        exit();
    }

    function get_product_value()
    {
        $product_point_value = $this->input->post('reg_mail_type', TRUE);
        echo $product_point_value;
    }

    function board_view_config()
    {

        $title = lang('board_view_config');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('board_view_config');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('board_view_config');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $board_config = $this->configuration_model->getBoardViewConfig();
        $this->set('board_config', $board_config);

        for ($i = 0; $i < count($board_config); $i++) {
            if ($this->input->post("update$i")) {
                $depth[$i] = $this->input->post("depth$i");
                $width[$i] = $this->input->post("width$i");
                $amount[$i] = $this->input->post("amount$i");

                if ($depth[$i] != "" && is_numeric($depth[$i]) && $width[$i] != "" && is_numeric($width[$i]) && $amount[$i] != "" && is_numeric($amount[$i])) {

                    $res = $this->configuration_model->updateBoardConfig($i + 1, $depth[$i], $width[$i], $amount[$i]);
                } else {
                    $msg = $this->lang->line('invalid');
                    $this->redirect($msg, 'configuration/board_view_config', true);
                }

                if ($res) {
                    $msg = $this->lang->line('board_configuration_updated_succesfully');
                    $this->redirect($msg, 'configuration/board_view_config', true);
                } else {
                    $msg = $this->lang->line('error_on_updating_board_configuration_please_try_again');
                    $this->redirect($msg, 'configuration/board_view_config', false);
                }
            }
        }

        $help_link = 'board_view_config';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function check_plan_variables($post_array)
    {
        $flag = false;
        if ($this->MLM_PLAN == "Matrix") {
            // $depth_ceiling = $post_array['depth_ceiling'];
            $width_ceiling = $post_array['width_ceiling'];
            $obj_arr = $this->configuration_model->getSettings();
            if (/* $depth_ceiling != $obj_arr['depth_ceiling'] ||  */$width_ceiling != $obj_arr['width_ceiling']) {
                $flag = true;
            }
        } else if ($this->MLM_PLAN == "Board") {
            $board_array = $this->configuration_model->getBoardSettings();
            $board_count = count($board_array);
            for ($i = 0; $i < $board_count; $i++) {
                $board_width = $post_array["board" . $i . "_width"];
                $board_depth = $post_array["board" . $i . "_depth"];
                $board_re_entry_status = $post_array["board" . $i . "_reentry_status"];
                $board_reentry_to_next_status = $post_array["board" . $i . "_reentry_to_next_status"];

                if ($board_width != $board_array[$i]['board_width'] || $board_depth != $board_array[$i]['board_depth']) {
                    $flag = true;
                } else if ($board_re_entry_status != $board_array[$i]['re_entry_status']) {
                    $flag = true;
                } else if ($board_reentry_to_next_status != $board_array[$i]['re_entry_to_next_status']) {
                    $flag = true;
                }
            }
        } else if ($this->MLM_PLAN == "Unilevel" || $this->MLM_PLAN == "Donation" || $this->MODULE_STATUS['sponsor_commission_status'] == "yes") {
            $depth_ceiling = $post_array['depth_ceiling'];
            $obj_arr = $this->configuration_model->getSettings();
            if ($depth_ceiling != $obj_arr['depth_ceiling']) {
                $flag = true;
            }
        }
        return $flag;
    }

    function opencart()
    {
        $table_prefix = str_replace("_", "", $this->table_prefix);
        $store_url = STORE_URL . "/?id=$table_prefix";
        if (DEMO_STATUS == "no") {
            $store_url = STORE_URL;
        }
        header("location:$store_url");
    }

    function store()
    {
        $table_prefix = str_replace("_", "", $this->table_prefix);
        $store_url = STORE_URL . "/?id=$table_prefix";
        if (DEMO_STATUS == "no") {
            $store_url = STORE_URL;
        }
        header("location:$store_url");
    }

    function bitcoin_configuration()
    {

        $title = $this->lang->line('blocktrail_configuration');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('blocktrail_configuration');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('blocktrail_configuration');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $bitcoin_details = $this->configuration_model->getBitcoinConfigurationDetails();
        $this->set('bitcoin_details', $bitcoin_details);

        //to set redirection of back buttons
        $link_origin = $_SESSION['link_origin'] ?? 0;
        if ($this->input->get('from') == 'payout_settings') {
            $link_origin = 1;
            $this->session->set_userdata("link_origin", $link_origin);
        }
        $this->set('link_origin', $link_origin);

        if ($this->input->post('update_bitcoin') && $this->validate_bitcoin_configuration()) {
            if (!empty($this->session->userdata('link_origin'))) {
                $link_origin = $this->session->userdata('link_origin');
            }
            $post_array = $this->input->post(NULL, TRUE);
            $post_array = $this->validation_model->stripTagsPostArray($post_array);
            $post_array = $this->validation_model->escapeStringPostArray($post_array);
            $result = $this->configuration_model->updateBitcoinConfiguration($post_array);

            if ($result) {
                $msg = $this->lang->line('blocktrail_configuration_updated_successfully');
                if ($link_origin == 1) {
                    $this->redirect($msg, 'configuration/bitcoin_configuration?from=payout_settings', true);
                } else {
                    $this->redirect($msg, 'configuration/bitcoin_configuration', true);
                }
            } else {
                $msg = $this->lang->line('blocktrail_configuration_updated_failed');
                if ($link_origin == 1) {
                    $this->redirect($msg, 'configuration/bitcoin_configuration?from=payout_settings', false);
                } else {
                    $this->redirect($msg, 'configuration/bitcoin_configuration', false);
                }
            }
        }

        $help_link = 'blocktrail-settings';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function validate_bitcoin_configuration()
    {
        $this->form_validation->set_rules('api_key', lang('api_key'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('api_secret_key', lang('api_secret_key'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('mode', lang('mode'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('live_wallet_name', lang('live_wallet_name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('live_wallet_password', lang('live_wallet_password'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('test_wallet_name', lang('test_wallet_name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('test_wallet_password', lang('test_wallet_password'), 'trim|required|xss_clean');
        $validation_result = $this->form_validation->run();

        return $validation_result;
    }

    function stairstep_configuration($action = NULL, $edit_id = NULL)
    {

        $title = $this->lang->line('stairstep_settings');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('stairstep_settings');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('stairstep_settings');
        $this->HEADER_LANG['page_small_header'] = lang('');
        $this->load_langauge_scripts();

        $this->set('edit_id', null);
        $this->set('step_name', null);
        $this->set('personal_pv', null);
        $this->set('group_pv', null);
        $this->set('step_commission', null);

        $override_commission = $this->validation_model->getConfig('override_commission');

        if ($action == 'edit') {
            $row = $this->configuration_model->getAllStairStepDetails($edit_id);
            $row = $row[0];
            $this->set('edit_id', $edit_id);
            $this->set('step_name', $row['step_name']);
            $this->set('personal_pv', $row['personal_pv']);
            $this->set('group_pv', $row['group_pv']);
            $this->set('step_commission', $row['step_commission']);
        }
        if ($action == 'inactivate') {
            $msg = '';
            $result = $this->configuration_model->changeStairStepStatus($edit_id, "inactive");
            if ($result) {
                $msg = $this->lang->line('stair_step_inactivated_successfully');
                $this->redirect($msg, 'configuration/stairstep_configuration', TRUE);
            } else {
                $msg = $this->lang->line('error_on_inactivating_stair_step');
                $this->redirect($msg, 'configuration/stairstep_configuration', FALSE);
            }
        }
        if ($action == 'activate') {
            $msg = '';
            $result = $this->configuration_model->changeStairStepStatus($edit_id, "active");
            if ($result) {
                $msg = $this->lang->line('stair_step_activated_successfully');
                $this->redirect($msg, 'configuration/stairstep_configuration', TRUE);
            } else {
                $msg = $this->lang->line('stair_step_inactivated_successfully');
                $this->redirect($msg, 'configuration/stairstep_configuration', FALSE);
            }
        }
        if ($action == 'delete') {
            $result = $this->configuration_model->changeStairStepStatus($edit_id, "deleted");
            if ($result) {
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Rank Deleted', $this->LOG_USER_ID, $data = '');
                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'delete_rank', 'Rank Deleted');
                }
                //

                $msg = $this->lang->line('stair_step_deted_sucessfully');
                $this->redirect($msg, 'configuration/stairstep_configuration', TRUE);
            } else {
                $msg = $this->lang->line('error_stair_step_deletion');
                $this->redirect($msg, 'configuration/stairstep_configuration', FALSE);
            }
        }

        if ($this->input->post('step_update') && $this->validate_step_configuration()) {
            $step_post_array = $this->input->post(NULL, TRUE);
            $step_post_array = $this->validation_model->stripTagsPostArray($step_post_array);

            $step_name = $step_post_array['step_name'];
            $personal_pv = $step_post_array['personal_pv'];
            $group_pv = $step_post_array['group_pv'];
            $step_commission = $step_post_array['step_commission'];

            $res = $this->configuration_model->updateStairStep($edit_id, $step_name, $personal_pv, $group_pv, $step_commission);
            if ($res) {
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Stair Step Updated', $this->LOG_USER_ID, $data = '');
                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_stair_step', 'Stair Step Updated');
                }
                //
                //insert configuration_change_history
                $stair_history = "Edit a step as Name:";
                $stair_history .= "" . $step_name . ", ";
                $stair_history .= "Personal PV:" . $personal_pv . ", ";
                $stair_history .= "Group PV:" . $group_pv . ", ";
                $stair_history .= "Step Commission:" . $this->DEFAULT_SYMBOL_LEFT . $step_commission . $this->DEFAULT_SYMBOL_RIGHT;
                $this->configuration_model->insertConfigChangeHistory('Stair step settings', $stair_history);
                $stair_history = "";
                //

                $msg = $this->lang->line('stair_step_updated_successfully');
                $this->redirect($msg, 'configuration/stairstep_configuration', TRUE);
            } else {
                $msg = $this->lang->line('Error_On_Updating_stair_step');
                $this->redirect($msg, 'configuration/stairstep_configuration', FALSE);
            }
        }
        if ($this->input->post('step_submit') && $this->validate_step_configuration()) {
            $step_post_array = $this->input->post(NULL, TRUE);
            $step_post_array = $this->validation_model->stripTagsPostArray($step_post_array);

            $step_name = $step_post_array['step_name'];
            $personal_pv = $step_post_array['personal_pv'];
            $group_pv = $step_post_array['group_pv'];
            $step_commission = $step_post_array['step_commission'];

            if ($step_name == NULL) {
                $this->redirect('Enter All Details', 'configuration/stairstep_configuration', false);
            } else {

                $res = $this->configuration_model->insertStairStepDetails($step_name, $personal_pv, $group_pv, $step_commission);
                if ($res) {
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Stair Step Added', $this->LOG_USER_ID, $data = '');
                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'add_stair_step', 'Stair Step Added');
                    }
                    //
                    //insert configuration_change_history
                    $stair_history = "Added a ";
                    $stair_history .= "" . $step_name . ", ";
                    $stair_history .= "Personal PV:" . $personal_pv . ", ";
                    $stair_history .= "Group PV:" . $group_pv . ", ";
                    $stair_history .= "Step Commission:" . $this->DEFAULT_SYMBOL_LEFT . $step_commission . $this->DEFAULT_SYMBOL_RIGHT;
                    $this->configuration_model->insertConfigChangeHistory('Stair step settings', $stair_history);
                    $stair_history = "";
                    //

                    $msg = $this->lang->line('stair_step_Details_Inserted_Successfully');
                    $this->redirect($msg, 'configuration/stairstep_configuration', true);
                } else {
                    $msg = $this->lang->line('error_on_adding_stair_step_details');
                    $this->redirect($msg, 'configuration/stairstep_configuration', false);
                }
            }
        }
        if ($this->MLM_PLAN == "Stair_Step" && $this->input->post('step_commission') && $this->validate_step_commission()) {
            $conf_post_array = $this->input->post(NULL, TRUE);
            $conf_post_array = $this->validation_model->stripTagsPostArray($conf_post_array);
            $result = $this->configuration_model->updateStairstepCommission($conf_post_array);
            if ($result) {
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'commission_setting', 'Commission Settings Updated');
                }
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/stairstep_configuration", true);
            } else {
                if (empty($this->form_validation->error_array())) {
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $this->redirect($msg, "configuration/stairstep_configuration", false);
                }
            }
        }

        $step_details = $this->configuration_model->getAllStairStepDetails();
        $count = count($step_details);
        $this->set('step_details', $step_details);
        $this->set('count', $count);

        $help_link = 'step-configuration';
        $this->set('help_link', $help_link);
        $this->set('override_commission', $override_commission);

        $this->setView();
    }

    function validate_step_configuration()
    {
        $this->form_validation->set_rules('step_name', lang('step_name'), 'trim|required|strip_tags|max_length[30]');
        $this->form_validation->set_rules('personal_pv', lang('personal_pv'), 'trim|required|greater_than_equal_to[0]');
        $this->form_validation->set_rules('group_pv', lang('group_pv'), 'trim|required|greater_than_equal_to[0]');
        $this->form_validation->set_rules('step_commission', lang('step_commission'), 'trim|required|greater_than_equal_to[0]');

        $this->form_validation->set_message('alpha_dash_space', lang('characters_only'));
        $res_val = $this->form_validation->run();

        return $res_val;
    }

    function clear_cache()
    {

        $title = $this->lang->line('clear_cache');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('clear_cache');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('clear_cache');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();
        $current_directory = getcwd();
        $directory = $current_directory . '/application/views';
        $files = glob($directory . '/templates_c/*'); // get all file name

        if ($files !== false) {
            $filecount = count($files);
        } else {
            $filecount = 0;
        }

        if ($this->input->post('flush_cache')) {
            foreach ($files as $file) { // iterate files
                if (is_file($file))
                    unlink($file); // delete file
            }
            $msg = $this->lang->line('flushed_cache_files_sucessfully');
            $this->redirect($msg, 'configuration/clear_cache', TRUE);
        }

        $this->set('filecount', $filecount);
        $help_link = 'flush_cache';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    public function add_new_rank($action = NULL, $edit_id = NULL)
    {
        $title = $this->lang->line('rank_settings');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('rank_settings');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('rank_settings');
        $this->HEADER_LANG['page_small_header'] = lang('');
        $this->load_langauge_scripts();

        $obj_arr = $this->configuration_model->getRankConfiguration();
        $this->set('obj_arr', $obj_arr);

        $rank_details = $this->configuration_model->getAllRankDetails();

        $this->set('edit_id', null);
        $this->set('rank_id', null);
        $this->set('rank_name', null);
        $this->set('referal_count', null);
        $this->set('ref_commission', null);
        $this->set('rank_bonus', null);
        $this->set('personal_pv', null);
        $this->set('gpv', null);
        $this->set('downline_count', null);
        $this->set('downline_rank_id', null);
        $this->set('downline_rank_count', null);
        $this->set('rank_color', null);
        $this->set('rank_incentive_reward',null);
        $this->set('rank_incentive_bonus',null);    
        $this->set('binary_bonus_percentage', null);
        $this->set('binary_monthly_cap', null);

        $package_rank = $this->configuration_model->selectPackageRankConfig();
        $dow_rank = $this->configuration_model->selectDownlineRankConfig();
        $commission_type = $this->validation_model->getConfig('sponsor_commission_type');
        if ($action == 'edit') {
            $row = $this->configuration_model->selectRankDetails($edit_id);
            $package_rank = $this->configuration_model->selectPackageRankConfig($edit_id);
            $rank_details = $this->configuration_model->getAllRankDetails($edit_id);
            $dow_rank = $this->configuration_model->selectDownlineRankConfig($edit_id);

            $this->set('edit_id', $edit_id);
            $this->set('rank_id', $row['rank_id']);
            $this->set('rank_name', $row['rank_name']);
            $this->set('referal_count', $row['referal_count']);
            $this->set('ref_commission', $row['referal_commission']);
            $this->set('rank_bonus', $row['rank_bonus']);
            $this->set('personal_pv', $row['personal_pv']);
            $this->set('gpv', $row['gpv']);
            $this->set('downline_count', $row['downline_count']);
            $this->set('downline_rank_id', $row['downline_rank_id']);
            $this->set('downline_rank_count', $row['downline_rank_count']);
            $this->set('rank_color', $row['rank_color']);
            $this->set('rank_incentive_bonus',$row['rank_incentive_bonus']);
            $this->set('rank_incentive_reward',$row['rank_incentive_reward']);
            $this->set('binary_bonus_percentage',$row['binary_bonus_percentage']);
            $this->set('binary_monthly_cap',$row['binary_monthly_cap']);
        }

        if ($this->input->post('rank_update') /*&& $this->validate_rank_configuration()*/) {
            $gpv = 0;
            $personal_pv = 0;
            $rank_post_array = $this->input->post(NULL, TRUE);
            $rank_post_array = $this->validation_model->stripTagsPostArray($rank_post_array);
            $res = $this->configuration_model->updateRank($rank_post_array, $commission_type, $this->DEFAULT_CURRENCY_VALUE);
            if ($res) {
                if (($this->MLM_PLAN == "Binary" || $this->MLM_PLAN == "Matrix")) {
                    if($obj_arr['downline_purchase_count'])
                        $this->configuration_model->updatePackageRankTable($rank_post_array['package_count'], $rank_post_array['rank_id']);
                    if($obj_arr['downline_rank'] && $this->input->post('downline_rank_count', TRUE))
                        $this->configuration_model->updateDownlineRankTable($rank_post_array['downline_rank_count'], $rank_post_array['rank_id']);
                }

                if($obj_arr['joinee_package'] && $this->MODULE_STATUS['product_status'] == "yes") {
                    $this->configuration_model->updateJoineeRankPckTable($rank_post_array['joinee_pck'], $rank_post_array['rank_id']);
                }
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Rank Updated', $this->LOG_USER_ID, $data = '');
                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_rank', 'Rank Updated');
                }
                //
                //insert configuration_change_history
                $rank_history = "Edited the rank : " . serialize($rank_post_array);
                $this->configuration_model->insertConfigChangeHistory('rank settings', $rank_history);
                //
                $msg = $this->lang->line('rank_updated_successfully');
                $this->redirect($msg, 'configuration/rank_configuration', TRUE);
            } else {
                $msg = $this->lang->line('Error_On_Updating_Rank');
                $this->redirect($msg, 'configuration/rank_configuration', FALSE);
            }
        }
        if ($this->input->post('rank_submit') /*&& $this->validate_rank_configuration()*/) {
            $rank_post_array = $this->input->post(NULL, TRUE);
            $rank_post_array = $this->validation_model->stripTagsPostArray($rank_post_array);
           // $rank_post_array['rank_achievers_bonus'] = str_replace(",", "", $rank_post_array['rank_achievers_bonus']);

            if ($rank_post_array['rank_name'] == NULL) {
                $this->redirect('Enter All Details', 'configuration/rank_configuration', false);
            } else {
                $res = $this->configuration_model->insertRankDetails($rank_post_array, $commission_type, $this->DEFAULT_CURRENCY_VALUE);
                if ($res) {
                    if ($this->MLM_PLAN == "Binary" || $this->MLM_PLAN == "Matrix") {
                        if($obj_arr['downline_purchase_count'])
                            $this->configuration_model->updatePackageRankTable($rank_post_array['package_count'], $res);
                        if($obj_arr['downline_rank'] && $this->input->post('downline_rank_count', TRUE))
                            $this->configuration_model->updateDownlineRankTable($rank_post_array['downline_rank_count'], $res);
                    }
                    if($obj_arr['joinee_package'] && $this->MODULE_STATUS['product_status'] == "yes") {
                        $this->configuration_model->insertJoineeRankPckTable($rank_post_array['joinee_pck'], $res);
                    }
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Rank Added', $this->LOG_USER_ID, $data = '');
                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'add_rank', 'Rank Added');
                    }
                    //
                    //insert configuration_change_history
                    $rank_history = "Added the rank : " . serialize($rank_post_array);
                    $this->configuration_model->insertConfigChangeHistory('rank settings', $rank_history);
                    //
                    $msg = $this->lang->line('Rank_Details_Inserted_Successfully..');
                    $this->redirect($msg, 'configuration/rank_configuration', true);
                } else {
                    $msg = $this->lang->line('error_on_adding_rank_details');
                    $this->redirect($msg, 'configuration/rank_configuration', false);
                }
            }
        }

        $this->set('dow_rank', $dow_rank);
        $this->set('commission_type', $commission_type);
        $this->set('package_rank', $package_rank);
        $this->set('rank_details', $rank_details);
        $this->set('action', $action);
        $this->setView();
    }

    public function signup_settings()
    {
        $this->url_permission('signup_config');

        $title = lang('signup_settings');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('signup_settings');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('signup_settings');
        $this->HEADER_LANG['page_small_header'] = lang('');
        $this->load_langauge_scripts();

        $signup_config = $this->configuration_model->getSignupConfiguration();
        $signup_fields = $this->configuration_model->getSignupFields();
        $country_status = $this->configuration_model->getSignUpFieldStatus('country');
        $countries = $this->country_state_model->viewCountry($signup_config['general_signup_config']['default_country']);

        $this->set('signup_config', $signup_config);
        $this->set('signup_fields', $signup_fields);
        $this->set('country_status', $country_status);
        $this->set('countries', $countries);

        $username_config = $this->configuration_model->getUsernameConfig();
        $this->set('username_config', $username_config);
        $is_preset_demo = 0;
        if (DEMO_STATUS == 'yes') {
            $is_preset_demo = $this->validation_model->isPresetDemo($this->ADMIN_USER_ID);
        }
        $help_link = 'signup-settings';
        $this->set('help_link', $help_link);
        $this->set('is_preset_demo', $is_preset_demo);

        if ($this->input->post('update') && $this->validate_username_config()) {
            $name_post_array = $this->input->post(NULL, TRUE);
            $name_post_array = $this->validation_model->stripTagsPostArray($name_post_array);
            $user_name_type = $name_post_array['user_name_type'];
            if ($name_post_array['user_name_type'] == 'static') {
                $res = $this->configuration_model->setUserNameType($user_name_type);
                if ($res) {
                    $data = serialize($name_post_array);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'username config changed to static', $this->LOG_USER_ID, $data);
                    //insert configuration_change_history
                    $username_history = "";
                    $username_history .= " Username Type :" . $name_post_array['user_name_type'] . ",";
                    $username_history .= " Length :" . $name_post_array['length'];



                    $this->configuration_model->insertConfigChangeHistory('username settings', $username_history);
                    //
                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_username_config', 'Username Configuration Updated');
                    }
                    //

                    $msg = $this->lang->line('user_name_configuration_updated_succesfully');
                    $this->redirect($msg, 'configuration/signup_settings', true);
                } else {
                    $msg = $this->lang->line('error_on_updating_user_name_configuration_please_try_again');
                    $this->redirect($msg, 'configuration/signup_settings', false);
                }
            } else {
                $length = $name_post_array['length'];
                $prefix_status = 'no';
                if (isset($name_post_array['prefix_status'])) {
                    $prefix_status = 'yes';
                }
                if ($prefix_status == 'yes') {
                    $prefix = $name_post_array['prefix'];
                } else {
                    $prefix = NULL;
                }
                if ($length != NULL && is_numeric($length) && $length >= 6 && $length <= 10) {
                    if ($prefix_status == 'yes') {
                        if (strlen($prefix) >= 2 && strlen($prefix) <= 5) {
                            $res = $this->configuration_model->setUsernameConfig($length, $prefix_status, $prefix, $user_name_type);
                        } else {
                            $msg = $this->lang->line('username_prefix_must_be_2_to_5_characters_long');
                            $this->redirect($msg, 'configuration/signup_settings', false);
                        }
                    } else {
                        $res = $this->configuration_model->setUsernameConfig($length, $prefix_status, $prefix, $user_name_type);
                    }
                    if ($res) {
                        $data = serialize($name_post_array);
                        $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'username config changed to dynamic', $this->LOG_USER_ID, $data);
                        //insert configuration_change_history
                        $username_history = "";
                        $username_history .= " Username Type :" . $name_post_array['user_name_type'] . ",";
                        $username_history .= " Length :" . $name_post_array['length'] . ",";
                        if ($prefix_status == 'yes') {
                            if ($name_post_array['prefix']) {
                                $username_history .= " Prefix :" . $name_post_array['prefix'];
                            }
                        } else {
                            $username_history .= " No Prefix set";
                        }
                        $this->configuration_model->insertConfigChangeHistory('signup settings', $username_history);
                        //
                        // Employee Activity History
                        if ($this->LOG_USER_TYPE == 'employee') {
                            $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_username_config', 'Username Configuration Updated');
                        }
                        //

                        $msg = $this->lang->line('user_name_configuration_updated_succesfully');
                        $this->redirect($msg, 'configuration/signup_settings', true);
                    } else {
                        $msg = $this->lang->line('error_on_updating_user_name_configuration_please_try_again');
                        $this->redirect($msg, 'configuration/signup_settings', false);
                    }
                } else {
                    $msg = $this->lang->line('username_must_be_at_least_6_characters_long');
                    $this->redirect($msg, 'configuration/signup_settings', false);
                }
            }
        }

        if ($this->input->post('save')) {
            $post_array = $this->input->post(NULL, TRUE);
            $loop_count = $post_array['number'];
            $sort_ordr = 0;
            for ($i = 1; $i <= $loop_count; $i++) {
                $sort_ordr = $this->input->post("sort_order$i");
                if ($sort_ordr && $sort_ordr > 0 && is_numeric($sort_ordr)) {
                    if($sort_ordr > 99 ) {
                        $msg = $this->lang->line('error_on_sort_order_updation') . " ";
                        $msg .= $this->lang->line('sort_order_should_be_less_than_99');
                        $this->redirect($msg, 'configuration/signup_settings', FALSE);
                    }
                    $update_array_check["srt_order$i"] = $sort_ordr;
                    $update_array["srt_order$i"] = $sort_ordr;
                    $update_array["id$i"] = $this->input->post("id$i");
                } else {
                    $msg = $this->lang->line('error_on_sort_order_updation') . " ";
                    $msg .= $this->lang->line('sort_order_should_be_greater_than_0');
                    $this->redirect($msg, 'configuration/signup_settings', FALSE);
                }
            }
            if (!array_diff_key($update_array_check, array_unique($update_array_check))) {
                //insert configuration_change_history
                $gate_history = "Updated sort order:";
                for ($i = 1; $i <= $loop_count; $i++) {
                    $this->configuration_model->updateSignUpSortOrder($update_array["id$i"], $update_array["srt_order$i"], "payout");
                    $config_history = '';
                }
                $this->configuration_model->insertConfigChangeHistory('Signup form field order changes', $config_history);
                $gate_history = "";

                $msg = $this->lang->line('sort_order_updated_successfully');
                $this->redirect($msg, 'configuration/signup_settings', true);
            }
            $msg = $this->lang->line('error_on_sort_order_updation') . " ";
            $msg .= $this->lang->line('sort_order_should_be_different');
            $this->redirect($msg, 'configuration/signup_settings', FALSE);
        }

        if ($this->input->post('update_signup') && $this->validate_signup_config()) {
            $post_array = $this->input->post(NULL, TRUE);
            $post_array = $this->validation_model->stripTagsPostArray($post_array);
            $update_data = [];
            $update_data['registration_allowed'] = 'yes';
            $update_data['sponsor_required'] = 'yes';
            $update_data['mail_notification'] = 'no';
            $update_data['binary_leg'] = 'any';
            $update_data['age_limit'] = 0;
            $update_data['default_country'] = 99;
            if ($this->input->post('registration_allowed')) {
                $update_data['registration_allowed'] = 'no';
            }
            if ($this->input->post('sponsor_required')) {
                $update_data['sponsor_required'] = 'no';
            }
            if ($this->input->post('mail_notification')) {
                $update_data['mail_notification'] = 'yes';
            }
            if ($this->input->post('binary_leg_status') && $this->MLM_PLAN == 'Binary') {
                $binary_leg = $this->input->post('binary_leg');
                if (in_array($binary_leg, ['left', 'right'])) {
                    $update_data['binary_leg'] = $binary_leg;
                }
            }
            if ($this->input->post('age_limit_status')) {
                $age_limit = $this->input->post('age_limit');
                if (filter_var($age_limit, FILTER_VALIDATE_INT) && $age_limit > 0) {
                    $update_data['age_limit'] = $age_limit;
                }
            }
            if ($this->input->post('country')) {
                $country = $this->input->post('country');
                $update_data['default_country'] = $country;
            }
            $res = $this->configuration_model->updateSignupConfig($update_data);
            if ($res) {
                $msg = lang('configuration_updated_successfully');
                $this->redirect($msg, 'signup_settings', TRUE);
            } else {
                $msg = lang('error_on_configuration_updation');
                $this->redirect($msg, 'signup_settings', FALSE);
            }
        }

        $this->setView();
    }

    public function update_pending_signup_option()
    {
        $this->url_permission('signup_config');

        if ($this->input->post('id')) {
            $id = $this->input->post('id', TRUE);
            $status = $this->input->post('status', TRUE);
            $status = ($status == 'true') ? TRUE : FALSE;
            $res = $this->configuration_model->updatePendingSignupConfig($id, $status);
            //insert configuration_change_history
            $gateway_name = $this->configuration_model->getPaymentGatewayName($id);
            //
            if ($res) {
                //insert configuration_change_history
                $history = "";
                if ($status == 1) {
                    $history .= $gateway_name . " : ON";
                } else {
                    $history .= $gateway_name . " : OFF";
                }

                $this->configuration_model->insertConfigChangeHistory('signup settings', $history);
                //
                echo json_encode(array('response' => TRUE));
                //                $msg = lang('configuration_updated_successfully');
                //                $this->redirect($msg, 'configuration/payment_view', TRUE);
            } else {
                echo json_encode(array('response' => FALSE));
                //                $msg = lang('error_on_configuration_updation');
                //                $this->redirect($msg, 'configuration/payment_view', FALSE);
            }
            exit();
        }
    }

    public function update_signup_settings()
    {
        $this->url_permission('signup_config');

        $res = FALSE;
        if ($this->input->post('registration_allowed')) {
            $value = $this->input->post('registration_allowed', TRUE);
            $res = $this->configuration_model->updateSignupSettings('registration_allowed', $value);
            //insert configuration_change_history
            $username_history = "";
            $username_history .= "Registration allowed :" . $value;
        }
        if ($this->input->post('sponsor_required')) {
            $value = $this->input->post('sponsor_required', TRUE);
            $res = $this->configuration_model->updateSignupSettings('sponsor_required', $value);
            //ewallet payment method changes
            $update_ewallet_payment = $this->configuration_model->setPaymentStatus(3, $value);
            //insert configuration_change_history
            $username_history = "";
            $username_history .= " Sponsor required :" . $value;
        }
        if ($this->input->post('bank_info_required')) {
            $value = $this->input->post('bank_info_required', TRUE);
            $res = $this->configuration_model->updateSignupSettings('bank_info_required', $value);
            $username_history = "";
            $username_history .= " Bank info required :" . $value;
        }
        if ($this->input->post('referral_status')) {
            $value = $this->input->post('referral_status', TRUE);
            $res = $this->configuration_model->setModuleStatus('referal_status', $value);
            $username_history = "";
            $username_history .= " Referral Income :" . $value;
        }
        if ($this->input->post('mail_notification')) {
            $value = $this->input->post('mail_notification', TRUE);
            $res = $this->configuration_model->updateSignupSettings('mail_notification', $value);
            $username_history = "";
            $username_history .= " Mail notification :" . $value . ",";
        }
        if ($this->input->post('binary_leg')) {
            $value = $this->input->post('binary_leg', TRUE);
            if (in_array($value, ['left', 'right', 'any'])) {
                $res = $this->configuration_model->updateSignupSettings('binary_leg', $value);
            }
            $username_history = "";
            $username_history .= " Binary Leg :" . $value;
        }
        if ($this->input->post('age_limit') || isset($_POST['age_limit'])) {
            $value = $this->input->post('age_limit', TRUE);
            if ((filter_var($value, FILTER_VALIDATE_INT) && $value > 0) || $value == '0') {
                $res = $this->configuration_model->updateSignupSettings('age_limit', $value);
            }
            $username_history = "";
            $username_history .= " Age Limit :" . $value;
        }  if ($this->input->post('country')) {
            $value = $this->input->post('country', TRUE);
                $res = $this->configuration_model->updateSignupSettings('default_country', $value);
            $username_history = "";
            $username_history .= " Default Country :" . $value;
        }
        if ($this->input->post('compression_commission')) {
            $value = $this->input->post('compression_commission', TRUE);
            $res = $this->configuration_model->updateSignupSettings('compression_commission', $value);
            $username_history = "";
            $username_history .= " Compression Commission :" . $value . ",";
        }
        if ($res) {
            echo json_encode(array('response' => TRUE));
        } else {
            echo json_encode(array('response' => FALSE));
        }
        $this->configuration_model->insertConfigChangeHistory('signup settings', $username_history);
        $username_history = '';
        //
        exit();
    }

    public function validate_link($url)
    {
        $this->form_validation->set_rules('banner_link', lang('banner_link'), 'trim|required|callback_youtube_validation');
        $this->form_validation->set_message('youtube_validation', lang('youtube_url_is_not_valid'));
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->error_array();
            $this->session->set_userdata('error', $error);
        } else {
            return TRUE;
        }
    }

    public function youtube_validation($url)
    {
        $youtube_regexp = "/^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/";

        if (preg_match($youtube_regexp, $url) == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function delete_banner()
    {
        $banner_id = $this->input->post('banner_id', TRUE);

        function change_credit_card_status()
        {

            $id = $this->input->post('id', TRUE);
            $new_status = $this->input->post('module_status', TRUE);

            if ($new_status == 'no') {
                $payment_active_count = $this->configuration_model->checkAtleastOneCreditCardActive($id);
                if (!$payment_active_count) {
                    $this->redirect('Atleast one payment method should be active. Please select one option', 'configuration/payment_view', false);
                }
            }

            $res = $this->configuration_model->setCreditCardStatus($id, $new_status);
            //insert configuration_change_history
            $res1 = $this->configuration_model->getCreditCardDetails($id);
            if ($new_status == 'no') {
                $gate_history = "Uninstalled the gateway ";
            } else {
                $gate_history = "Installed the gateway ";
            }
            $gate_history .= "named " . $res1['gateway_name'];

            $this->configuration_model->insertConfigChangeHistory('payment gateway settings', $gate_history);
            $gate_history = "";
            //
        }

        $res = $this->member_model->deleteReplicaBanner($banner_id);
        if ($res) {
            $data_array['banner_id'] = $banner_id;
            $data = serialize($data_array);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'banner invite deleted', $this->LOG_USER_ID, $data);

            // Employee Activity History
            if ($this->LOG_USER_TYPE == 'employee') {
                $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'delete_banner_invite', 'Banner Invite Deleted');
            }
            //

            $msg = lang('replication_banner_deleted');
            $this->redirect($msg, "configuration/add_banner", true);
        } else {
            $msg = lang('replication_banner_not_deleted');
            $this->redirect($msg, "configuration/add_banner", false);
        }
    }

    // replication site config  ends
    //inactiviy logout setting
    public function inactivity_logout()
    {
        $title = lang('inactiivity_logout_settings');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('inactiivity_logout_settings');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('inactiivity_logout_settings');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $this->load->model('member_model');
        $help_link = 'banner';
        $this->set("help_link", $help_link);

        $post_array = array(
            'logout_time' => ''
        );
        $prev_time = $this->validation_model->selectLogoutTime();
        $this->set("prev_time", $prev_time);
        if ($this->input->post('submit')) {
            $post_array = $this->input->post(NULL, TRUE);
            $time = $post_array['logout_time'];
            if (!$time) {
                $msg = lang('please_select_logout_time');
                $this->redirect($msg, "configuration/inactivity_logout", false);
            } else {
                $result = $this->configuration_model->updateLogoutTime($time);
                if ($result) {
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Inactivity Logout Time set to' . $time . ' sec', $this->LOG_USER_ID);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Inactivity Logout Time', 'Set to ' . $time . ' sec');
                    }
                    //
                    $msg = lang('logout_time_updated_successfully');
                    $this->redirect($msg, "configuration/inactivity_logout", TRUE);
                }
            }
        }
        $this->set("post_array", $post_array);

        $this->setView();
    }

    //

    function blockchain_configuration()
    {

        $title = $this->lang->line('blockchain_configuration');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('blockchain_configuration');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('blockchain_configuration');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $blockchain_details = $this->configuration_model->getBlockchainConfigurationDetails();
        $this->set('blockchain_details', $blockchain_details);

        //to set redirection of back buttons
        $link_origin = $_SESSION['link_origin'] ?? 0;
        if ($this->input->get('from') == 'payout_settings') {
            $link_origin = 1;
            $this->session->set_userdata("link_origin", $link_origin);
        }
        $this->set('link_origin', $link_origin);

        if ($this->input->post('update_blockchain') && $this->validate_blockchain_configuration()) {
            if (!empty($this->session->userdata('link_origin'))) {
                $link_origin = $this->session->userdata('link_origin');
            }
            $post_array = $this->input->post(NULL, TRUE);
            $post_array = $this->validation_model->stripTagsPostArray($post_array);
            $post_array = $this->validation_model->escapeStringPostArray($post_array);
            $result = $this->configuration_model->updateBlockchainConfiguration($post_array);

            if ($result) {
                $msg = $this->lang->line('blockchain_configuration_updated_successfully');
                if ($link_origin == 1) {
                    $this->redirect($msg, 'configuration/blockchain_configuration?from=payout_settings', true);
                } else {
                    $this->redirect($msg, 'configuration/blockchain_configuration', true);
                }
            } else {
                $msg = $this->lang->line('blockchain_configuration_updated_failed');
                if ($link_origin == 1) {
                    $this->redirect($msg, 'configuration/blockchain_configuration?from=payout_settings', false);
                } else {
                    $this->redirect($msg, 'configuration/blockchain_configuration', false);
                }
            }
        }

        $help_link = 'blockchain-settings';
        $this->set('help_link', $help_link);
        $this->setView();
    }

    function validate_blockchain_configuration()
    {
        $this->form_validation->set_rules('my_api_key', lang('api_key'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('main_password', lang('main_password'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('second_password', lang('second_password'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('secret', lang('secret'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('fee', lang('fee'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('my_xpub', lang('xpub'), 'trim|required|xss_clean');
        $validation_result = $this->form_validation->run();
        return $validation_result;
    }

    /* Bitgo Payement Method Starts */

    function bitgo_configuration()
    {

        $title = $this->lang->line('bitgo_configuration');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('bitgo_configuration');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('bitgo_configuration');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();
        $mode = $this->configuration_model->getPaymentGatewayMode("Bitgo");
        $bitgo_details = $this->configuration_model->getBitgoConfigurationDetails($mode);
        $this->set('bitgo_details', $bitgo_details);

        //to set redirection of back buttons
        $link_origin = $_SESSION['link_origin'] ?? 0;
        if ($this->input->get('from') == 'payout_settings') {
            $link_origin = 1;
            $this->session->set_userdata("link_origin", $link_origin);
        }
        $this->set('link_origin', $link_origin);

        if ($this->input->post('update_bitgo') && $this->validate_bitgo_configuration()) {
            if (!empty($this->session->userdata('link_origin'))) {
                $link_origin = $this->session->userdata('link_origin');
            }
            $post_array = $this->input->post(NULL, TRUE);
            $post_array = $this->validation_model->stripTagsPostArray($post_array);
            $post_array = $this->validation_model->escapeStringPostArray($post_array);
            $result = $this->configuration_model->updateBitgoConfiguration($post_array);

            if ($result) {
                $msg = $this->lang->line('bitgo_configuration_updated_successfully');
                if ($link_origin == 1) {
                    $this->redirect($msg, 'configuration/bitgo_configuration?from=payout_settings', true);
                } else {
                    $this->redirect($msg, 'configuration/bitgo_configuration', true);
                }
            } else {
                $msg = $this->lang->line('bitgo_configuration_updated_failed');
                if ($link_origin == 1) {
                    $this->redirect($msg, 'configuration/bitgo_configuration?from=payout_settings', false);
                } else {
                    $this->redirect($msg, 'configuration/bitgo_configuration', false);
                }
            }
        }

        $help_link = 'bitgo-settings';
        $this->set('help_link', $help_link);
        $this->setView();
    }

    function validate_bitgo_configuration()
    {
        $this->form_validation->set_rules('wallet_id', lang('wallet_id'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('token', lang('token'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('mode', lang('mode'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('passphrase', lang('passphrase'), 'trim|required|xss_clean');
        $validation_result = $this->form_validation->run();

        return $validation_result;
    }

    function ajax_bitgo_config($mode = '')
    {
        $bitgo_details = "";
        if ($mode) {
            $bitgo_details = $this->configuration_model->getBitgoConfigurationDetails($mode);
            echo json_encode($bitgo_details);
        } else {
            echo json_encode($bitgo_details);
        }
    }

    /* Bitgo Payement Method End */

    /* Payment Gateway Payout Config Begin */

    function change_credit_card_status_for_payout()
    {

        $id = $this->input->post('id', TRUE);
        $new_status = $this->input->post('module_status', TRUE);
        $new_status = ($new_status == 'yes') ? 'no' : 'yes';

        if ($new_status == 'no') {
            $payment_active_count = $this->configuration_model->checkAtleastOneCreditCardActive($id, "payout");
            if (!$payment_active_count) {
                $this->redirect(lang('atleast_one_payment_method_should_active'), 'configuration/payout_setting', false);
            }
        }

        $res = $this->configuration_model->setCreditCardStatus($id, $new_status, "payout");
        //insert configuration_change_history
        $res1 = $this->configuration_model->getCreditCardDetails($id, "payout");
        if ($new_status == 'no') {
            $gate_history = "Uninstalled the gateway ";
        } else {
            $gate_history = "Installed the gateway ";
        }
        $gate_history .= "named " . $res1['gateway_name'];

        $this->configuration_model->insertConfigChangeHistory('payment gateway settings for payout', $gate_history);
        $gate_history = "";
        //
    }

    /* Payment Gateway Payout Config End */

    function validate_content()
    {
        $res_val = FALSE;
        if ($this->input->post('submit_term')) {
            $this->form_validation->set_rules('content_terms', lang('content_terms'), 'trim|required');
        }
        if ($this->input->post('submit_policy')) {
            $this->form_validation->set_rules('content_policy', lang('content_policy'), 'trim|required');
        }
        if (($this->input->post('submit_about'))) {
            $this->form_validation->set_rules('content_about', lang('content_about'), 'trim|required');
        }
        if (($this->input->post('submit_address'))) {
            $this->form_validation->set_rules('address', lang('address'), 'trim|required');
        }
        if (($this->input->post('replica_content'))) {
            $this->form_validation->set_rules('subtitle', lang('subtitle'), 'trim|required');
            $this->form_validation->set_rules('replica_content_main', lang('txtDefaultHtmlArea'), 'trim|required');
        }if ($this->input->post('submit_upgrade_term')) {
            $this->form_validation->set_rules('content_terms', lang('content_terms'), 'trim|required');
        }
        if ($this->input->post('submit_upgrade_text')) {
            $this->form_validation->set_rules('content_terms', lang('content_terms'), 'trim|required');
        }
        $res_val = $this->form_validation->run();
        if ($res_val == FALSE) {
            $error = $this->form_validation->error_array();
            $this->session->set_userdata('error', $error);
        }
        return $res_val;
    }

    function valid_url($url)
    {
        if ($this->input->post('facebook')) {
            $this->form_validation->set_rules('facebook', lang('facebook'), 'trim|xss_clean|callback_facebook_checking');
            $this->form_validation->set_message('facebook_checking', lang('facebook_url_is_not_valid'));
        }
        if ($this->input->post('youtube')) {
            $this->form_validation->set_rules('youtube', lang('youtube'), 'trim|xss_clean|callback_youtube_checking');

            $this->form_validation->set_message('youtube_checking', lang('youtube_url_is_not_valid'));
        }
        if ($this->input->post('twitter')) {
            $this->form_validation->set_rules('twitter', lang('twitter'), 'trim|xss_clean|callback_twitter_checking');

            $this->form_validation->set_message('twitter_checking', lang('twitter_url_is_not_valid'));
        }
        if ($this->input->post('google_plus')) {
            $this->form_validation->set_rules('google_plus', lang('google_plus'), 'trim|xss_clean|callback_google_checking');

            $this->form_validation->set_message('google_checking', lang('google_plus_url_is_not_valid'));
        }
        if ($this->input->post('linkedin')) {
            $this->form_validation->set_rules('linkedin', lang('linkedin'), 'trim|xss_clean|callback_linkedin_checking');

            $this->form_validation->set_message('linkedin_checking', lang('linkedin_url_is_not_valid'));
        }
        if ($this->input->post('instagram')) {
            $this->form_validation->set_rules('instagram', lang('instagram'), 'trim|xss_clean|callback_instagram_checking');

            $this->form_validation->set_message('instagram_checking', lang('instagram_url_is_not_valid'));
        }

        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->error_array();
            $this->session->set_userdata('error', $error);
        } else {
            return TRUE;
        }
    }

    function facebook_checking($url)
    {
        $fbUrlCheck = '/^$|http(s)?:\/\/(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/';

        if (preg_match($fbUrlCheck, $url) == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function youtube_checking($url)
    {
        $youtube_regexp = "/^$|http(s)?:\/\/(www\.)?(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/";

        if (preg_match($youtube_regexp, $url) == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function twitter_checking($url)
    {
        $tw_regexp = "/^$|http(s)?:\/\/(?:www\.)?twitter\.com\/([a-zA-Z0-9_]+)/";

        if (preg_match($tw_regexp, $url) == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function google_checking($url)
    {
        $tw_regexp = "/^$|http(s)?:\/\/(www[.])?plus\.google\.com\/.?\/?.?\/?([0-9]*)/";

        if (preg_match($tw_regexp, $url) == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function linkedin_checking($url)
    {
        $tw_regexp = "/^$|http(s)?:\/\/((www|\w\w)\.)?linkedin.com(\w+:{0,1}\w*@)?(\S+)(:([0-9])+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/";

        if (preg_match($tw_regexp, $url) == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function instagram_checking($url)
    {
        $tw_regexp = "/^$|http(s)?:\/\/(www\.)?instagram\.com\/([A-Za-z0-9_](?:(?:[A-Za-z0-9_]|(?:\.(?!\.))){0,28}(?:[A-Za-z0-9_]))?)/";

        if (preg_match($tw_regexp, $url) == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //Replication site home page ends

    public function theme_setting()
    {
        if (DEMO_STATUS == 'no') {
            $this->redirect('', 'configuration/configuration_view', FALSE);
        }
        $title = lang('theme');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'theme';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('theme');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('theme');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        // Theme Settings
        $def_admin_theme = $this->configuration_model->getAdminThemeFolder();
        $admin_themes = array();
        $admin_directories = glob(APPPATH . 'views/admin/layout/themes/*');
        foreach ($admin_directories as $directory) {
            $name = basename($directory);
            $admin_themes[] = array(
                "name" => $name,
                "default" => ($def_admin_theme == $name) ? 1 : 0,
                "icon" => $name . "/theme.png",
                "image" => $name . "/theme.png"
            );
        }
        rsort($admin_themes);
        array_unshift($admin_themes, $admin_themes[1]);
        array_splice($admin_themes, 2, 1);
        $def_user_theme = $this->configuration_model->getUserThemeFolder();
        $user_themes = array();
        $user_directories = glob(APPPATH . 'views/user/layout/themes/*');
        foreach ($user_directories as $user_directory) {
            $name = basename($user_directory);
            $user_themes[] = array(
                "name" => $name,
                "default" => ($def_user_theme == $name) ? 1 : 0,
                "icon" => $name . "/theme.png",
                "image" => $name . "/theme.png"
            );
        }
        rsort($user_themes);
        array_unshift($user_themes, $user_themes[1]);
        array_splice($user_themes, 2, 1);
        //        $i = 0;
        //        foreach ($admin_themes as $a) {
        //            if ($a['name'] == 'white') {
        //                $admin_themes[$i]['name'] = 'TrueWhite';
        //            }
        //            $i++;
        //        }
        //        $j = 0;
        //        foreach ($user_themes as $u) {
        //            if ($u['name'] == 'white') {
        //                $user_themes[$j]['name'] = 'TrueWhite';
        //            }
        //            $j++;
        //        }
        if ($this->input->post()) {
            $admin_folder = $this->input->post('admin_def_theme', TRUE);
            $user_folder = $this->input->post('user_def_theme', TRUE);

            $res = $this->configuration_model->updateThemeFolder($admin_folder, $user_folder);

            if ($res) {
                if (DEMO_STATUS == 'yes') {
                    $is_preset_demo = $this->validation_model->isPresetDemo($this->ADMIN_USER_ID);
                    if ($is_preset_demo) {
                        $this->session->set_userdata('inf_theme_folder', $admin_folder);
                        $admin_folder = $user_folder = 'default';
                        $this->configuration_model->updateThemeFolder($admin_folder, $user_folder);
                    }
                }
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Site Theme Updated', $this->LOG_USER_ID, $data = '');
                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_site_theme', 'Site Theme Updated');
                }
                //

                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/theme_setting", TRUE);
            } else {

                $msg = $this->lang->line('error_on_configuration_updation');
                $this->redirect($msg, "configuration/theme_setting", FALSE);
            }
        }

        $this->set('def_admin_theme_folder', $def_admin_theme);
        $this->set('admin_themes', $admin_themes);
        $this->set('def_user_theme_folder', $def_user_theme);
        $this->set('user_themes', $user_themes);

        $this->setView();
    }

    public function check_numeric($conf_post_array)
    {
        if ($this->MLM_PLAN == "Matrix" || $this->MLM_PLAN == "Unilevel" || $this->MODULE_STATUS['sponsor_commission_status'] == "yes") {
            if (isset($conf_post_array['depth_ceiling']) && $conf_post_array['active_tab'] == "tab1") {
                for ($i = 1; $i <= $conf_post_array['depth_ceiling']; $i++) {
                    if (!is_numeric($conf_post_array["level_percentage" . $i])) {
                        return false;
                    }
                }
            }
        }
        if ($this->MLM_PLAN == "Board" && isset($conf_post_array['board_count'])) {
            if ($conf_post_array['board_count'] && $conf_post_array['active_tab'] == "tab2") {
                for ($i = 0; $i < $conf_post_array['board_count']; $i++) {
                    if (!is_numeric($conf_post_array["board" . $i . "_commission"])) {
                        return false;
                    }
                }
            }
        }
        if ($this->MLM_PLAN == "Donation" && $conf_post_array['active_tab'] == "tab2") {

            $commission_type = $conf_post_array['level_commission_type'];
            $levels_count = $conf_post_array['donation_count'];
            $depth_ceiling = $conf_post_array['commission_upto_level'];
            for ($j = 1; $j <= $depth_ceiling; $j++) {
                for ($k = 1; $k <= $levels_count; $k++) {
                    if ($conf_post_array['level_' . $j . '_donation_' . $k] < 0) {
                        return FALSE;
                    }
                    if ($commission_type == 'percentage') {
                        if (!is_numeric($conf_post_array['level_' . $j . '_donation_' . $k]) || ($conf_post_array['level_' . $j . '_donation_' . $k] > 100)) {
                            return false;
                        }
                    } else {
                        if (!is_numeric($conf_post_array['level_' . $j . '_donation_' . $k])) {
                            return false;
                        }
                    }
                }
            }
        }
        if (isset($conf_post_array['service_charge'])) {
            if (!is_numeric($conf_post_array['service_charge'])) {
                return false;
            }
        }
        if (isset($conf_post_array['trans_fee'])) {
            if (!is_numeric($conf_post_array['trans_fee'])) {
                return false;
            }
        }
        if (isset($conf_post_array['tds'])) {
            if (!is_numeric($conf_post_array['tds'])) {
                return false;
            }
        }

        return true;
    }

    function menu_permission()
    {
        // THIS_VERSION_ONLY
        $title = lang('set_menu_permission');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('set_menu_permission');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('set_menu_permission');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $menu_id = $this->configuration_model->getUserMenuId();
        $menus = array();
        $i = 0;
        $j = 0;
        $k = 0;

        foreach ($menu_id->result_array() as $row) {
            $menu_id = $row['id'];
            $link = $this->configuration_model->getMenuTextId($menu_id);
            $menu_text = lang($menu_id . "_" . $link);
            $menus[$k]['name'] = $menu_text;
            $menus[$k]['id'] = $menu_id;
            $menus[$k]['sub_menu'] = $link;
            if ($row['status'] == 'yes') {
                $menus[$k]['check'] = 1;
            } else {
                $menus[$k]['check'] = 0;
            }
            if ($row['perm_admin'] == 1) {
                $menus[$k]['perm_admin'] = 1;
            } else {
                $menus[$k]['perm_admin'] = 0;
            }
            if ($row['perm_dist'] == 1) {
                $menus[$k]['perm_dist'] = 1;
            } else {
                $menus[$k]['perm_dist'] = 0;
            }
            if ($row['perm_emp'] == 1) {
                $menus[$k]['perm_emp'] = 1;
            } else {
                $menus[$k]['perm_emp'] = 0;
            }
            $menus[$k]['type'] = "";

            $admin_only = array(8, 9, 10, 17, 18, 35, 43, 52, 55, 56, 61,32);
            $user_only = array(7, 34, 53,66);

            $bank_status = $this->configuration_model->getPaymentStatus('Bank Transfer');
            if ($bank_status == 'yes') {
                $user_only[] =  46;
            }
            if (in_array($menu_id, $user_only)) {
                $menus[$k]['type'] = "user";
            }
            if (in_array($menu_id, $admin_only)) {
                $menus[$k]['type'] = "admin";
            }
            $k++;
            $sub_row = $this->configuration_model->getUserSubMenuId($menu_id);

            foreach ($sub_row->result_array() as $row1) {
                $sub_menu_id = $row1['sub_id'];
                $sub_link = $this->configuration_model->getSubmenuText($sub_menu_id);
                $sub_text = lang($menu_id . "_" . $sub_menu_id . "_" . $sub_link);
                $sub_menu[$j]['sub_id'] = $sub_menu_id;
                $sub_menu[$j]['menu_id'] = $menu_id;
                $sub_menu[$j]['sub_name'] = $sub_text;
                if ($row1['sub_status'] == 'yes') {
                    $sub_menu[$j]['check'] = 1;
                } else {
                    $sub_menu[$j]['check'] = 0;
                }
                if ($row1['perm_admin'] == 1) {
                    $sub_menu[$j]['perm_admin'] = 1;
                } else {
                    $sub_menu[$j]['perm_admin'] = 0;
                }
                if ($row1['perm_dist'] == 1) {
                    $sub_menu[$j]['perm_dist'] = 1;
                } else {
                    $sub_menu[$j]['perm_dist'] = 0;
                }
                if ($row1['perm_emp'] == 1) {
                    $sub_menu[$j]['perm_emp'] = 1;
                } else {
                    $sub_menu[$j]['perm_emp'] = 0;
                }

                $sub_menu[$j]['type'] = "";

                $admin_only = array(13, 14, 17, 20, 21, 24, 31, 32, 33, 34, 35, 38, 45, 46, 56, 57, 67, 78, 79, 80, 89, 90, 101, 104, 117, 131, 133, 136, 137, 148, 150, 153, 154, 155, 149);
                $user_only = array(18, 19, 28, 49, 52, 64, 105, 124, 126, 147, 151, 156);

                if (in_array($sub_menu_id, $admin_only)) {
                    $sub_menu[$j]['type'] = "admin";
                }
                if (in_array($sub_menu_id, $user_only)) {
                    $sub_menu[$j]['type'] = "user";
                }
                $j++;
            }
        }
        //                foreach ($menus as $a) {
        //                    if ($a['id'] == 50 || $a['id'] == 5 || $a['id'] == 36) {  // hiding employee management from permission list
        //                        unset($menus[$i]);
        //                    }
        //                    $i++;
        //                }
        //                foreach ($sub_menu as $a) {
        //                    if ($a['sub_id'] == 125) {  // hiding employee management from permission list
        //                        unset($sub_menu[$i]);
        //                    }
        //                }
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $this->set('sub_menu', $sub_menu);
        $this->set('menus', $menus);

        $help_link = 'set-employee-permission';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    public function update_menu_permission()
    {
        if ($this->input->post('id')) {
            $id = $this->input->post('id', TRUE);
            $attr = $this->input->post('attr', TRUE);
            $status = $this->input->post('status', TRUE);
            $status = ($status == 'true') ? TRUE : FALSE; //echo json_encode($this->input->post('id'));exit;
            if ($attr == "status") {
                if ($status) {
                    $status = "yes";
                } else {
                    $status = "no";
                }
            }
            $res = $this->configuration_model->updateMenuConfig($id, $status, $attr);
            //insert configuration_change_history
            if ($res) {
                //insert configuration_change_history
                $history = "";
                if ($status == 1) {
                    $history .= $id . " " . $attr . " : SET";
                } else {
                    $history .= $id . " " . $attr . " : UNSET";
                }

                $this->configuration_model->insertConfigChangeHistory('menu permission settings', $history);
                //
                echo json_encode(array('response' => TRUE));
                //                $msg = lang('configuration_updated_successfully');
                //                $this->redirect($msg, 'configuration/payment_view', TRUE);
            } else {
                echo json_encode(array('response' => FALSE));
                //                $msg = lang('error_on_configuration_updation');
                //                $this->redirect($msg, 'configuration/payment_view', FALSE);
            }
            exit();
        }
    }

    public function update_sub_menu_permission()
    {
        if ($this->input->post('id')) {
            $id = $this->input->post('id', TRUE);
            $attr = $this->input->post('attr', TRUE);
            $status = $this->input->post('status', TRUE);
            $status = ($status == 'true') ? TRUE : FALSE;
            if ($attr == "sub_status") {
                if ($status) {
                    $status = "yes";
                } else {
                    $status = "no";
                }
            }
            $res = $this->configuration_model->updateSubMenuConfig($id, $status, $attr);
            //insert configuration_change_history
            if ($res) {

                //Update menu stand alone
                $menu_flag = true;
                $menu_id = $this->configuration_model->getMenuIdFromSub($id);
                $sub_menu = $this->configuration_model->getUserSubMenuId($menu_id);
                foreach ($sub_menu->result_array() as $row1) {
                    if ($attr == "sub_status") {
                        $status = "no";
                    } else {
                        $status = 0;
                    }
                    if ($row1[$attr] == $status) {
                        continue;
                    } else {
                        $menu_flag = false;
                    }
                }
                if ($menu_flag) {
                    if ($attr == "sub_status")
                        $res2 = $this->configuration_model->updateMenuConfig($menu_id, 'no', 'status');
                    else
                        $res2 = $this->configuration_model->updateMenuConfig($menu_id, 0, $attr);
                }
                //insert configuration_change_history
                $history = "";
                if ($status == 1) {
                    $history .= $id . " " . $attr . " : SET";
                } else {
                    $history .= $id . " " . $attr . " : UNSET";
                }

                $this->configuration_model->insertConfigChangeHistory('sub menu settings', $history);
                //
                echo json_encode(array('response' => TRUE));
                //                $msg = lang('configuration_updated_successfully');
                //                $this->redirect($msg, 'configuration/payment_view', TRUE);
            } else {
                echo json_encode(array('response' => FALSE));
                //                $msg = lang('error_on_configuration_updation');
                //                $this->redirect($msg, 'configuration/payment_view', FALSE);
            }
            exit();
        }
    }

    function donation_configuration($action = NULL, $edit_id = NULL)
    {

        $title = $this->lang->line('donation_settings');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('donation_settings');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('donation_settings');
        $this->HEADER_LANG['page_small_header'] = lang('');
        $this->load_langauge_scripts();

        //donation config

        $donation_arr = $this->configuration_model->getDonationConfig();
        $donation_type = $this->validation_model->getColoumnFromTable("configuration", "donation_type");

        $donation_count = count($donation_arr);

        if ($this->input->post('donation_submit') && $this->checkDonationNumeric($donation_count)) {

            $conf_post_array = $this->input->post(NULL, TRUE);
            $res = $this->configuration_model->updageDonationConfig($conf_post_array, $donation_count);

            if ($res) {
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Donation Change', $this->LOG_USER_ID, $data = '');
                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Donation Change', 'Donation Change');
                }

                //insert configuration_change_history
                $stair_history = serialize($conf_post_array);
                $this->configuration_model->insertConfigChangeHistory('Donation settings', $stair_history);
                $stair_history = "";


                $msg = $this->lang->line('Donation_settings_Successfully');
                $this->redirect($msg, 'configuration/donation_configuration', true);
            } else {
                $msg = $this->lang->line('error_on_adding_donation_settings');
                $this->redirect($msg, 'configuration/donation_configuration', false);
            }
        }

        $this->set('donation_array', $donation_arr);
        $this->set('count', $donation_count);
        $this->set('donation_type', $donation_type);

        $help_link = 'donation_settings';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function change_payment_available()
    {
        $id = $this->input->post('id', TRUE);
        $attr = $this->input->post('attr', TRUE);
        $status = $this->input->post('status', TRUE);
        $status = ($status == 'true') ? TRUE : FALSE;

        $res = $this->configuration_model->setPaymentStatusAvailable($id, $status, $attr);
        if (!$status) {
            $active = $this->configuration_model->getAvailableAny($id);
            if (!$active)
                $this->configuration_model->setPaymentStatusAvailable($id, "no", "status");
        } else {
            $this->configuration_model->setPaymentStatusAvailable($id, "yes", "status");
        }
        if ($res) {
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Payment Settings Updated', $this->LOG_USER_ID, $data = '');
            // Employee Activity History
            if ($this->LOG_USER_TYPE == 'employee') {
                $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'change_payment_setting', 'Payment Settings Updated');
            }
            //
            echo json_encode(array('response' => TRUE));
            //            $msg = lang('Payment_Status_Updated_Successfully');
            //            $this->redirect($msg, 'configuration/payment_view', TRUE);
        } else {
            echo json_encode(array('response' => FALSE));
            //            $msg = lang('Error_on_updating_payment_status_please_try_again');
            //            $this->redirect($msg, 'configuration/payment_view', FALSE);
        }
        exit();
    }

    //holiday configuration

    function holidays_settings($id = "", $action = "")
    {

        $title = lang('holidays_settings');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('holidays_settings');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('holidays_settings');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $help_link = 'multi_language';
        $this->set('help_link', $help_link);

        if (($this->input->post()) && ($this->validate_holidays_settings())) {

            $details = $this->input->post(NULL, TRUE);
            $date = $details['week_date2'];
            $reason = $details['reason'];

            $result = $this->configuration_model->insertHolidays($date, $reason);

            if ($result) {
                $this->configuration_model->insertConfigChangeHistory('update holiday settings', 'holiday settings updated');

                $msg = $this->lang->line('holiday_added_successfully');
                $this->redirect($msg, "configuration/holidays_settings", TRUE);
            } else {

                $msg = $this->lang->line('error_on_configuration_updation');
                $this->redirect($msg, "configuration/holidays_settings", FALSE);
            }
        }

        if (($id != "") && ($action == "delete")) {
            $this->block_preset_demo_action('holidays_settings');
            $res = $this->configuration_model->deleteHolidays($id);

            if ($res) {
                $this->configuration_model->insertConfigChangeHistory('delete holiday settings', 'holiday settings deleted');
                $msg = $this->lang->line('holiday_deleted_successfully');

                $this->redirect($msg, "configuration/holidays_settings", TRUE);
            } else {
                $msg = $this->lang->line('error_on_configuration_updation');
                $this->redirect($msg, "configuration/holidays_settings", FALSE);
            }
        }


        $holidays_array = $this->configuration_model->getPublicHolidays();
        $this->set('holidays_array', $this->security->xss_clean($holidays_array));

        $this->setView();
    }

    function validate_holidays_settings()
    {
        $this->form_validation->set_rules('week_date2', lang('week_date2'), 'trim|required|callback_is_date_available');
        $this->form_validation->set_rules('reason', lang('reason'), 'trim|required');
        $this->form_validation->set_message('is_date_available', lang('the_date_is_not_available'));
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    function cron_status()
    {
        $this->url_permission('roi_status');

        $title = lang('Hyip');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('Hyip');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('Hyip');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $this->setView();
    }

    public function ajax_is_date_available()
    {

        $date = $this->input->post('week_date2', TRUE);
        if (!$date) {
            echo 'no';
            exit();
        }
        $is_date_exists = $this->configuration_model->isdateAvailable($date);
        if ($is_date_exists) {
            echo 'no';
            exit();
        } else {
            echo 'yes';
            exit();
        }
    }

    public function is_date_available()
    {
        $date = $this->input->post('week_date2', TRUE);
        if (!$date) {
            return FALSE;
        }
        $is_date_exists = $this->configuration_model->isdateAvailable($date);
        if ($is_date_exists) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function checkDonationNumeric($donation_count)
    {
        if ($this->MLM_PLAN == "Donation") {

            for ($i = 1; $i <= $donation_count; $i++) {
                $level_name = $this->input->post["level_name$i"];
                $this->form_validation->set_rules("level_name$i", lang('level'), "trim|required|callback_notMatch[$level_name $donation_count]");
                $this->form_validation->set_rules("don_rate_pm$i", lang('rate'), 'trim|required|numeric|greater_than[0]');
                $this->form_validation->set_rules("don_count$i", lang('referral_count'), 'trim|required|numeric|greater_than[0]');
            }
            $this->form_validation->set_rules('donation_type', lang('donation_type'), 'required');
        }
        $res_val = $this->form_validation->run();

        return $res_val;
    }

    function notMatch($level, $donation_count)
    {
        $level_array = array();
        for ($i = 1; $i <= $donation_count; $i++) {
            $level_array[] = $this->input->post("level_name$i");
        }
        $key = array_search($level, $level_array);
        unset($level_array[$key]);
        if (in_array("$level", $level_array)) {
            $msg = $this->lang->line('enter_unique_level');
            $this->form_validation->set_message('notMatch', $msg);
            return false;
        }
        return true;
    }

    function opencartAdmin()
    {
        $table_prefix = str_replace("_", "", $this->table_prefix);
        $store_url = STORE_URL . "/admin/?id=$table_prefix";
        if (DEMO_STATUS == "no") {
            $store_url = STORE_URL . "/admin";
        }
        header("location:$store_url");
    }

    public function check_sum_of_taxes()
    {
        $post_array = $this->input->post(NULL, TRUE);
        if ($post_array['service_charge'] + $post_array['tds'] <= 100) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function validate_rankname($rankname = '', $rank_id = '')
    {
        if ($rankname != '' && $rank_id != '') {
            $flag = FALSE;
            if ($this->configuration_model->isRankNameAvailable($rankname, $rank_id)) {
                $flag = TRUE;
            }
            return $flag;
        } else {
            $echo = 'no';
            $rankname = $this->input->post('rankname', TRUE);
            $rank_id = $this->input->post('rank_id', TRUE);
            if ($this->configuration_model->isRankNameAvailable($rankname, $rank_id)) {
                $echo = 'yes';
            }
            echo $echo;
            exit();
        }
    }

    public function update_rank_pv_option()
    {

        $res = FALSE;
        $desc_history = "";
        if ($this->input->post('group_pv')) {
            $value = $this->input->post('group_pv', TRUE);
            $res = $this->configuration_model->updateModuleStatus('group_pv', $value);
            //insert configuration_change_history
            $desc_history .= "Group PV :" . $value;
        }
        if ($this->input->post('personal_pv')) {
            $value = $this->input->post('personal_pv', TRUE);
            $res = $this->configuration_model->updateModuleStatus('personal_pv', $value);
            //insert configuration_change_history
            $desc_history .= " Personal PV :" . $value;
        }
        if ($this->input->post('downline_count')) {
            $value = $this->input->post('downline_count', TRUE);
            $res = $this->configuration_model->updateModuleStatus('downline_count_rank', $value);
            //insert configuration_change_history
            $desc_history .= " Downline Count Rank :" . $value;
        }
        if ($this->input->post('downline_purchase')) {
            $value = $this->input->post('downline_purchase', TRUE);
            $res = $this->configuration_model->updateModuleStatus('downline_purchase_rank', $value);
            //insert configuration_change_history
            $desc_history .= " Downline Purchase Rank :" . $value;
        }
        if ($res) {
            echo json_encode(array('response' => TRUE));
        } else {
            echo json_encode(array('response' => FALSE));
        }
        $this->configuration_model->insertConfigChangeHistory('signup settings', $desc_history);
        exit();
    }

    public function kyc_configuration()
    {
        $title = $this->lang->line('kyc_view');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('kyc_view');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('kyc_view');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();
        $this->url_permission('kyc_status');
        $catg_id = '';
        $catg = '';
        if ($this->input->get('id') != '') {
            $catg_id = $this->input->get('id');
            $result = $this->configuration_model->getKycDocCategory($catg_id);;
            $catg = $result[0]['category'];
        }
        if ($this->input->post('add_category') && $this->validate_category()) {
            $new_catg = $this->input->post('new_catg', TRUE);
            $result = $this->configuration_model->insertKycCategory($new_catg);
            if ($result) {
                $msg = $this->lang->line('kyc_category_added_successfully');
                $this->redirect($msg, "configuration/kyc_configuration", TRUE);
            } else {
                $msg = $this->lang->line('error_on_kyc_category_insertion');
                $this->redirect($msg, "configuration/kyc_configuration", FALSE);
            }
        }
        if ($this->input->post('update_category') && $this->validate_category()) {
            $new_catg = $this->input->post('new_catg', TRUE);
            $id = $this->input->post('catg_id', TRUE);

            $result = $this->configuration_model->updateKycCategory($id, $new_catg);
            if ($result) {
                $msg = $this->lang->line('kyc_category_updated_successfully');
                $this->redirect($msg, "configuration/kyc_configuration/?id=$id", TRUE);
            } else {
                $msg = $this->lang->line('error_on_kyc_category_updated');
                $this->redirect($msg, "configuration/kyc_configuration/?id=$id", FALSE);
            }
        }

        $help_link = 'kyc-settings';
        $this->set('catg', $catg);
        $this->set('catg_id', $catg_id);
        $this->set('help_link', $help_link);
        $this->setView();
    }

    function validate_category()
    {
        $this->form_validation->set_rules("new_catg", lang('category'), 'trim|required|max_length[32]|alpha_numeric_spaces|callback_is_unique|xss_clean');
        $res_val = $this->form_validation->run();
        if ($this->input->post('catg_id')) {
            $id = $this->input->post('catg_id');
            $res_val = $this->form_validation->run_with_redirect("configuration/kyc_configuration/?id={$id}");
        }
        return $res_val;
    }

    function is_unique($category)
    {
        $result = $this->configuration_model->isKycCategoryNameAvailable($category);
        return $result;
    }

    public function tooltip_settings()
    {
        $title = $this->lang->line('tooltip_settings');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('tooltip_settings');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('tooltip_settings');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $tooltip = $this->configuration_model->getTooltipDetails();
        if ($this->input->post('update')) {
            $post_arr = $this->input->post(null, true);
            unset($post_arr['update']);
            $result = $this->configuration_model->updateTooltipSettings($post_arr);

            if ($result) {
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Tooltip settings updated', $this->LOG_USER_ID, serialize($post_arr));

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Tooltip settings updated');
                }

                $msg = $this->lang->line('tooltip_settings_updated_successfully');
                $this->redirect($msg, "configuration/tooltip_settings", TRUE);
            } else {
                $msg = $this->lang->line('error_on_tooltip_settings_updation');
                $this->redirect($msg, "configuration/tooltip_settings", FALSE);
            }
        }

        $help_link = 'tooltip-settings';
        $this->set('tooltip', $tooltip);
        $this->set('help_link', $help_link);
        $this->setView();
    }

    function payeer_configuration()
    {

        $title = $this->lang->line('payeer_configuration');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('payeer_configuration');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('payeer_configuration');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();
        $mode = $this->configuration_model->getPaymentGatewayMode("Payeer");
        $payeer_details = $this->configuration_model->getPayeerConfigurationDetails();
        $this->set('payeer_details', $payeer_details);

        //to set redirection of back buttons
        $link_origin = $_SESSION['link_origin'] ?? 0;

        $this->set('link_origin', $link_origin);

        if ($this->input->post('update_payeer') && $this->validate_payeer_configuration()) {
            if (!empty($this->session->userdata('link_origin'))) {
                $link_origin = $this->session->userdata('link_origin');
            }
            $post_array = $this->input->post(NULL, TRUE);
            $post_array = $this->validation_model->stripTagsPostArray($post_array);
            $post_array = $this->validation_model->escapeStringPostArray($post_array);
            $user_id = $this->LOG_USER_ID;

            $pass = $this->ewallet_model->getUserPassword($user_id);

            $tran_pass = $post_array['pswd1'];
           /* $result = $this->configuration_model->updatePayeerConfiguration($post_array);
            if ($result) {
                $msg = $this->lang->line('payeer_configuration_updated_successfully');
                $this->redirect($msg, 'configuration/payeer_configuration', true);
            } else {
                $msg = $this->lang->line('payeer_configuration_updation_failed');
                $this->redirect($msg, 'configuration/payeer_configuration', false);
            }*/
            if (password_verify($tran_pass, $pass) && $this->LOG_USER_TYPE == 'admin') {
                $result = $this->configuration_model->updatePayeerConfiguration($post_array);
                if ($result) {
                 $payeer_config_change_history = "Updated Payeer configuration: " . serialize($post_array);
                 $this->configuration_model->insertConfigChangeHistory('payeer configuration changes', $payeer_config_change_history);


                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'payeer configuration change', $login_id);
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'payeer configuration changes', 'Payeer configuration changes Updated');
                }
                    $msg = $this->lang->line('payeer_configuration_updated_successfully');
                    $this->redirect($msg, 'configuration/payeer_configuration', true);
                } else {
                    $msg = $this->lang->line('payeer_configuration_updation_failed');
                    $this->redirect($msg, 'configuration/payeer_configuration', false);
                }
            } else {
                $msg = lang('invalid_transaction_password');
                $this->redirect($msg, 'configuration/payeer_configuration', false);
            }
        }

        $help_link = 'payeer-settings';
        $this->set('help_link', $help_link);
        $this->setView();
    }

    function validate_payeer_configuration()
    {
        /* $this->form_validation->set_rules('merchant_id', lang('merchant_id'), 'trim|required|xss_clean');
          $this->form_validation->set_rules('merchant_key', lang('merchant_key'), 'trim|required|xss_clean');
          $this->form_validation->set_rules('encryption_key', lang('encryption_key'), 'trim|required|xss_clean'); */
        $this->form_validation->set_rules('account', lang('account'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('pswd1', lang('transaction_password'), 'trim|required');
        $this->form_validation->set_rules('api_key', lang('api_key'), 'trim|required|alpha_numeric');
        $this->form_validation->set_rules('api_id', lang('api_id'), 'trim|required|numeric');
        $validation_result = $this->form_validation->run();

        return $validation_result;
    }

    function sofort_configuration()
    {

        $title = $this->lang->line('sofort_configuration');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('sofort_configuration');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('sofort_configuration');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $sofort_details = $this->configuration_model->getSofortConfigDetails();
        $this->set('sofort_details', $sofort_details);

        //to set redirection of back buttons
        $link_origin = $_SESSION['link_origin'] ?? 0;
        if ($this->input->get('from') == 'payout_settings') {
            $link_origin = 1;
            $this->session->set_userdata("link_origin", $link_origin);
        }
        $this->set('link_origin', $link_origin);

        if ($this->input->post('update_sofort') && $this->validate_sofort_config()) {
            if (!empty($this->session->userdata('link_origin'))) {
                $link_origin = $this->session->userdata('link_origin');
            }
            $settings_post_array = $this->input->post(NULL, TRUE);
            $settings_post_array = $this->validation_model->stripTagsPostArray($settings_post_array);

            if ($this->input->post('project_id')) {
                $project_id = $settings_post_array['project_id'];
            } else {
                $msg = $this->lang->line('you_must_enter_project_id');
                if ($link_origin == 1) {
                    $this->redirect($msg, 'configuration/sofort_configuration?from=payout_settings', false);
                } else {
                    $this->redirect($msg, 'configuration/sofort_configuration', false);
                }
            }
            if ($this->input->post('customer_id')) {

                $customer_id = $settings_post_array['customer_id'];
            } else {
                $msg = $this->lang->line('you_must_enter_customer_id');
                if ($link_origin == 1) {
                    $this->redirect($msg, 'configuration/sofort_configuration?from=payout_settings', false);
                } else {
                    $this->redirect($msg, 'configuration/sofort_configuration', false);
                }
            }
            if ($this->input->post('project_pass')) {

                $project_pass = $settings_post_array['project_pass'];
            } else {
                $msg = $this->lang->line('you_must_enter_project_pass');
                if ($link_origin == 1) {
                    $this->redirect($msg, 'configuration/sofort_configuration?from=payout_settings', false);
                } else {
                    $this->redirect($msg, 'configuration/sofort_configuration', false);
                }
            }
            $res = $this->configuration_model->updateSofortConfig($project_id, $customer_id, $project_pass);

            if ($res) {
                $msg = $this->lang->line('sofort_configuration_updated_successfully');
                if ($link_origin == 1) {
                    $this->redirect($msg, 'configuration/sofort_configuration?from=payout_settings', true);
                } else {
                    $this->redirect($msg, 'configuration/sofort_configuration', true);
                }
            } else {
                $msg = $this->lang->line('Error_on_updating_sofort_status_please_try_again');
                if ($link_origin == 1) {
                    $this->redirect($msg, 'configuration/sofort_configuration?from=payout_settings', false);
                } else {
                    $this->redirect($msg, 'configuration/sofort_configuration', false);
                }
            }
        }

        $help_link = NULL;
        $this->set('help_link', $help_link);
        $this->setView();
    }

    function validate_sofort_config()
    {

        $this->form_validation->set_rules('project_id', lang('project_id'), 'trim|required');
        $this->form_validation->set_rules('customer_id', lang('customer_id'), 'trim|required');
        $this->form_validation->set_rules('project_pass', lang('project_pass'), 'trim|required');

        $res_val = $this->form_validation->run();
        return $res_val;
    }

    public function update_additional_bonus()
    {
        $res = [];
        $res['response'] = false;
        if ($this->input->is_ajax_request() && $this->input->post()) {
            $bonus_name = $this->input->post('bonus_name', true);
            $status = $this->input->post('status', true);
            $status = ($status == 'true') ? 'yes' : 'no';
            $res['response'] = $this->configuration_model->updateAdditionalBonusStatus($bonus_name, $status);
            if ($res['response']) {
                $this->session->set_userdata('inf_config_tab_active_arr', array('tab1' => '', 'tab2' => '', 'tab3' => '', 'tab4' => '', 'tab5' => ' active'));
            }
            echo json_encode($res);
            exit();
        }
    }

    function squareup_configuration()
    {

        $title = $this->lang->line('squareup_configuration');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('squareup_configuration');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('squareup_configuration');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $squareup_details = $this->configuration_model->getSquareUpConfigDetails();
        $this->set('squareup_details', $squareup_details);

        //to set redirection of back buttons
        $link_origin = $_SESSION['link_origin'] ?? 0;
        if ($this->input->get('from') == 'payout_settings') {
            $link_origin = 1;
            $this->session->set_userdata("link_origin", $link_origin);
        }
        $this->set('link_origin', $link_origin);

        if ($this->input->post('update_squareup') && $this->validate_squareup_config()) {
            if (!empty($this->session->userdata('link_origin'))) {
                $link_origin = $this->session->userdata('link_origin');
            }
            $settings_post_array = $this->input->post(NULL, TRUE);
            $settings_post_array = $this->validation_model->stripTagsPostArray($settings_post_array);

            $access_token = $settings_post_array['access_token'];
            $application_id = $settings_post_array['application_id'];
            $location_id = $settings_post_array['location_id'];

            $res = $this->configuration_model->updateSquareUpConfig($access_token, $application_id, $location_id);

            if ($res) {
                $msg = $this->lang->line('squareup_configuration_updated_successfully');
                if ($link_origin == 1) {
                    $this->redirect($msg, 'configuration/squareup_configuration?from=payout_settings', true);
                } else {
                    $this->redirect($msg, 'configuration/squareup_configuration', true);
                }
            } else {
                $msg = $this->lang->line('Error_on_updating_squareup_status_please_try_again');
                if ($link_origin == 1) {
                    $this->redirect($msg, 'configuration/squareup_configuration?from=payout_settings', false);
                } else {
                    $this->redirect($msg, 'configuration/squareup_configuration', false);
                }
            }
        }

        $help_link = NULL;
        $this->set('help_link', $help_link);
        $this->setView();
    }

    function validate_squareup_config()
    {

        $this->form_validation->set_rules('access_token', lang('access_token'), 'trim|required');
        $this->form_validation->set_rules('application_id', lang('application_id'), 'trim|required');
        $this->form_validation->set_rules('location_id', lang('location_id'), 'trim|required');
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    public function update_cart_menu_perm()
    {

        if ($this->input->post('id')) {
            $id = $this->input->post('id', TRUE);
            $attr = $this->input->post('attr', TRUE);
            $status = $this->input->post('status', TRUE);
            $status = ($status == 'true') ? TRUE : FALSE;
            if ($attr == "status") {
                if ($status) {
                    $status = "yes";
                } else {
                    $status = "no";
                }
            }
            if ($this->MODULE_STATUS['repurchase_status'] == 'yes' && $this->MODULE_STATUS['repurchase_status_demo'] == 'yes') {
                $res = $this->configuration_model->updateMenuConfig($id, $status, $attr);
            }
            exit();
        }
    }
    function pin_settings($action = '', $epin_id = '')
    {

        $title = lang('epin_settings');
        $this->set("title", $this->COMPANY_NAME . " | $title ");
        $this->url_permission('pin_status');

        $this->HEADER_LANG['page_top_header'] = lang('epin_settings');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('epin_settings');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $pin_status = $this->MODULE_STATUS['pin_status'];

        if ($pin_status == 'yes') {
            $pin_config = $this->configuration_model->getPinConfig();
            $this->set('pin_config', $pin_config);

            if ($this->input->post('update') && ($this->validate_pin_config())) {

                $pin_post_array = $this->input->post(NULL, TRUE);
                $pin_post_array = $this->validation_model->stripTagsPostArray($pin_post_array);

                $pin_character_set = $pin_post_array['pin_character'];
                $pin_maxcount = $pin_post_array['pin_maxcount'];
                $pin_length = 10;
                if (is_numeric($pin_maxcount)) {
                    $res = $this->configuration_model->setPinConfig($pin_length, $pin_maxcount, $pin_character_set);
                }
                if ($res) {
                    $data = serialize($pin_post_array);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'epin configuration updated', $this->LOG_USER_ID, $data);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_epin_config', 'E-PIN Configuration Updated');
                    }
                    //
                    //insert configuration_change_history
                    $pin_history = "Updated E-Pin configuration as its Max Count:" . $pin_maxcount . ", ";
                    if (isset($pin_post_array['pin_value'])) {
                        $pin_history .= "Pin Value:" . $pin_value . ", ";
                    }
                    $pin_history .= "E-pin character :" . $pin_character_set;

                    $this->configuration_model->insertConfigChangeHistory('E-Pin settings', $pin_history);
                    $pin_history = "";
                    //
                    $msg = $this->lang->line('pin_configuration_updated_sucessfully');
                    $this->redirect($msg, 'configuration/pin_settings', true);
                } else {
                    $msg = $this->lang->line('error_on_updating_configuration_please_try_again');
                    $this->redirect($msg, 'configuration/pin_settings', false);
                }
            }
        }


        if ($this->input->post('add_amount') && $this->validate_add_new_epin_amount()) {

            $pin_post_array = $this->input->post(NULL, TRUE);
            $pin_post_array = $this->validation_model->stripTagsPostArray($pin_post_array);

            $res = $this->epin_model->addPinAmount($pin_post_array['pin_amount']);
            if ($res == true) {
                $data = serialize($pin_post_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'new epin added', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'add_epin_amount', 'E-PIN Amount Added');
                }
                //
                //insert configuration_change_history
                $pin_history = "Added new E-Pin with amount:" . $this->DEFAULT_SYMBOL_LEFT . $pin_post_array['pin_amount'] . $this->DEFAULT_SYMBOL_RIGHT;

                $this->configuration_model->insertConfigChangeHistory('E-Pin settings', $pin_history);
                $pin_history = "";
                //
                $msg = lang('pin_amount_added_sucess');
                $this->redirect($msg, 'configuration/pin_settings', true);
            } else {
                $msg = lang('unable_to_add_pin_amount');
                $this->redirect($msg, 'configuration/pin_settings', false);
            }
        }

        if ($action == 'delete') {
            $this->block_preset_demo_action('pin_config');
            $pin_post_array['pin_id'] = $epin_id;
            $pin_post_array['delete_amount'] = "delete_amount";
            $pin_post_array = $this->validation_model->stripTagsPostArray($pin_post_array);
            //insert configuration_change_history
            $this->load->model('epin_model');
            $amount = $this->epin_model->getPinbyId($pin_post_array['pin_id']);

            $pin_history = "Deleted an E-Pin with id :" . $pin_post_array['pin_id'] . ", ";
            $pin_history .= "E-pin Amount :" . $this->DEFAULT_SYMBOL_LEFT . $amount . $this->DEFAULT_SYMBOL_RIGHT;
            $this->configuration_model->insertConfigChangeHistory('E-Pin settings', $pin_history);
            $pin_history = "";
            //
            $res = $this->epin_model->deletePinAmount($pin_post_array['pin_id']);
            if ($res) {
                $data = serialize($pin_post_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'epin deleted', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'delete_epin', 'E-PIN Deleted');
                }
                //

                $msg = lang('pin_amount_deleted_sucess');
                $this->redirect($msg, 'configuration/pin_settings', true);
            } else {
                $msg = lang('unable_to_delete_pin_amount');
                $this->redirect($msg, 'configuration/pin_settings', false);
            }
        }

        $pin_amounts = $this->epin_model->getAllEwalletAmounts();
        $count = count($pin_amounts);
        $this->set('pin_amounts', $pin_amounts);
        $this->set('count', $count);

        $help_link = 'e-pin-configuration';
        $this->set('help_link', $help_link);

        $this->setView();
    }
    function level_commissions($arg = NULL,$level = NULL)
    {
        $level_commission_status = $this->validation_model->getCompensationConfig('sponsor_commission_status');
        if ($level_commission_status != 'yes') {
            $this->deny_permission();
        }
        $text_comm = lang('level_commissions');
        if ($this->MODULE_STATUS['xup_status'] == 'yes') {
            $text_comm = lang('xup_commission');
            $xup_level = $this->validation_model->getConfig('xup_level');
            $this->set('xup_level', $xup_level);
        }

        $title = $text_comm;
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'level-commissionsn ';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = $text_comm;
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = $text_comm;
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $mlm_plan = $this->MODULE_STATUS['mlm_plan'];
        $this->set('MLM_PLAN', $mlm_plan);

        $obj_arr = $this->configuration_model->getSettings();

        $this->load->model('currency_model');

        if($arg){
            $active_commission = $arg;
        }else{
            $active_commission = $obj_arr['commission_criteria'];
        }
        if($level){
            $active_level = $level;
        }else{
            $active_level = $obj_arr['commission_upto_level'];
        }

        if ($this->input->post('level_commission_common')) {
            $conf_post_array = $this->input->post(NULL, TRUE);
            $conf_post_array = $this->validation_model->stripTagsPostArray($conf_post_array);
            $result = FALSE;
            if ((in_array($this->MLM_PLAN, ['Matrix', 'Unillevel']) || $this->MODULE_STATUS['sponsor_commission_status'] == "yes") && ($this->input->post('level_commission_common') || $this->input->post('donation_level_commission'))) {
                if($this->validate_level_commission_common()){
                    $status = $this->check_numeric($conf_post_array);
                    if (!$status) {
                        $msg = $this->lang->line('invalid_input');
                        $this->redirect($msg, "configuration/level_commissions", false);
                    }
                    $result = $this->configuration_model->updatePackageLevelCommissionCommon($conf_post_array);
                }else{
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $type = $conf_post_array['level_commission_criteria'];
                    $this->redirect($msg, "configuration/level_commissions/$type", false);
                }
            }
            if ($result) {
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'commission_setting', 'Commission Settings Updated');
                }
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/level_commissions", true);
            } else {
                if (empty($this->form_validation->error_array())) {
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $this->redirect($msg, "configuration/level_commissions", false);
                }
            }
        }
        if ($this->input->post('level_commission')) {
            $conf_post_array = $this->input->post(NULL, TRUE);
            $conf_post_array = $this->validation_model->stripTagsPostArray($conf_post_array);
            $result = FALSE;
            if ((in_array($this->MLM_PLAN, ['Matrix', 'Unilevel']) || $this->MODULE_STATUS['sponsor_commission_status'] == "yes") && ($this->input->post('level_commission') || $this->input->post('donation_level_commission'))) {
                if($this->validate_level_commission()){
                    $status = $this->check_numeric($conf_post_array);
                    if (!$status) {
                        $msg = $this->lang->line('invalid_input');
                        $this->redirect($msg, "configuration/level_commissions", false);
                    }
                    $result = $this->configuration_model->updatePackageLevelCommission($conf_post_array, $this->DEFAULT_CURRENCY_VALUE);
                }else{
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $type = $conf_post_array['level_commission_criteria'];
                    $this->redirect($msg, "configuration/level_commissions/$type", false);
                }
            }
            if ($result) {
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'commission_setting', 'Commission Settings Updated');
                }
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/level_commissions", true);
            } else {
                if (empty($this->form_validation->error_array())) {
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $this->redirect($msg, "configuration/level_commissions", false);
                }
            }
        }
        if($this->session->flashdata('form_error_redirect')){
            $err_msg = $this->session->flashdata('form_error_redirect');
            $this->session->set_userdata('cmsn_err',$err_msg);
        }

        $project_default_currency = $this->currency_model->getProjectDefaultCurrencyDetails();

        $this->set('obj_arr', $obj_arr);
        $this->set('project_default_currency', $project_default_currency);
        $this->set('active_commission', $active_commission);
        $this->set('active_level', $active_level);

        $this->setView();
    }
    function level_commissions_view($arg = NULL)
    {
        if($this->session->userdata('cmsn_err')){
            foreach ($this->session->userdata('cmsn_err') as $field => $error) {
                $this->form_validation->set_form_error($field, $error);
            }
            $this->form_validation->set_error_delimiters("<div style='color:#b94a48;'>", "</div>");
            $this->session->unset_userdata('cmsn_err');
        }
        $this->load_langauge_scripts();

        $mlm_plan = $this->MODULE_STATUS['mlm_plan'];
        $this->set('MLM_PLAN', $mlm_plan);

        $obj_arr = $this->configuration_model->getSettings();

        $arr_level = [];
        $arr_donation = [];
        $arr_donation_level = [];
        $arr_level_reg_pack = [];
        $pck_array = [];

        $this->load->model('currency_model');

        if ($this->MLM_PLAN == "Unilevel" || $this->MLM_PLAN == "Matrix" || $this->MODULE_STATUS['sponsor_commission_status'] == 'yes') {
            if($this->MLM_PLAN != "Donation"){
                $arr_level = $this->configuration_model->getLevelSettings();
            }
            if ($this->MODULE_STATUS['product_status'] == "yes" || ($this->MODULE_STATUS['opencart_status'] == "yes" && $this->MODULE_STATUS['opencart_status_demo'] == "yes")) {
                $pck_array = $this->configuration_model->getLevelCommissionPackages();
                $arr_level_reg_pack = $this->configuration_model->getLevelSettingsRegPck();
                $this->set('arr_pck', $pck_array );
            }
        }
        if ($this->MLM_PLAN == "Donation") {
            $this->load->model('donation_model');
            $arr_donation = $this->configuration_model->getDonationLevelSettings();
            $arr_donation_level = $this->donation_model->getLevelName();
        }
        $prev_level = $this->validation_model->getMaxLevel();
        if($this->input->post('level') && $this->input->post('level') != $prev_level){
            if($this->input->post('level') < $prev_level){
                $level_flag = !empty($arr_level)?true:false;
                $donation_flag = !empty($arr_donation)?true:false;
                $pck_flag = !empty($arr_level_reg_pack)?true:false;
                $count = $prev_level - $this->input->post('level');
                for($i = 0;$i < $count;$i++){
                    if($level_flag)
                        array_pop($arr_level);
                    if($donation_flag)
                        array_pop($arr_donation);
                    if($pck_flag)
                        array_pop($arr_level_reg_pack);
                }
            }else{
                $level_flag = !empty($arr_level)?true:false;
                $donation_flag = !empty($arr_donation)?true:false;
                $pck_flag = !empty($arr_level_reg_pack)?true:false;
                $low = $prev_level;
                $high = $this->input->post('level');
                for($i = ++$low;$i <= $high;$i++){
                    if($level_flag)
                        array_push($arr_level,0);
                    if($donation_flag){
                        $arr_donation[$i] = ['id' => $i,'level_no'=>$i,'level_percentage'=>0];
                        for ($k=1;$k <= count($arr_donation_level);$k++) {
                            $arr_donation[$i]["donation_" . $k] = 0;
                        }
                    }
                    if($pck_flag){
                        $arr_level_reg_pack[$i] = ['level' => $i];
                        foreach ($pck_array as $pack) {
                            $arr_level_reg_pack[$i][$pack['prod_id'] . "reg"] = 0;
                            $arr_level_reg_pack[$i][$pack['prod_id'] . "member"] = 0;
                        }
                    }
                }
            }
        }

        $project_default_currency = $this->currency_model->getProjectDefaultCurrencyDetails();

        $this->set('obj_arr', $obj_arr);
        $this->set('arr_level', $arr_level);
        $this->set('arr_donation', $arr_donation);
        $this->set('arr_donation_level', $arr_donation_level);
        $this->set('arr_level_pck', $arr_level_reg_pack);
        $this->set('project_default_currency', $project_default_currency);

        $this->setView();
    }

    public function update_signup_field_config()
    {
        $res = [];
        $res['response'] = false;
        if ($this->input->is_ajax_request() && $this->input->post()) {
            $attr = $this->input->post('attr', true);
            $id = $this->input->post('id', true);
            $status = $this->input->post('status', true);
            $status = ($status == 'true') ? 'yes' : 'no';
            $res['response'] = $this->configuration_model->updateSignUpFieldStatus($id, $status, $attr);
            if($attr=='status' && $status== 'no') { // off required field
                $this->configuration_model->updateSignUpFieldStatus($id, $status, 'required');
            }
            if($id == '7' && $status =='no') {   // Country
                $this->configuration_model->updateSignUpFieldStatus(8, $status, 'status');
                $this->configuration_model->updateSignUpFieldStatus(8, $status, 'required');
            }
            if(($this->configuration_model->getSignUpFieldStatus('country') == 'no') && ($this->configuration_model->getSignUpFieldStatus('state') == 'yes')) {
                $this->configuration_model->updateSignUpFieldStatus(8, "no", 'status');
            }
            echo json_encode($res);
            exit();
        }
    }
    function plan_settings($arg = NULL)
    {
        $text_plan = lang('plan_settings');
        if ($this->MLM_PLAN == 'Matrix') {
            $text_plan = lang('genealogy_tree_settings');
        } elseif ($this->MLM_PLAN == 'Board') {
            if ($this->MODULE_STATUS['table_status'] == 'yes') {
                $text_plan = lang('table_settings');
            } else {
                $text_plan = lang('board_settings');
            }

        }
        $title = $text_plan;
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'network-configuration ';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = $text_plan;
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = $text_plan;
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $mlm_plan = $this->MODULE_STATUS['mlm_plan'];
        $this->set('MLM_PLAN', $mlm_plan);

        $obj_arr = $this->configuration_model->getSettings();

        $obj_arr_board = array();

        $this->load->model('currency_model');
        if ($this->MLM_PLAN == "Board") {
            $obj_arr_board = $this->configuration_model->getBoardSettings();
        }
        if ($this->MLM_PLAN == "Binary") {
            $binary_bonus_config = $this->configuration_model->getBinaryBonusConfig();
            $this->set('binary_bonus_config', $binary_bonus_config);
        }
        $board_count = count($obj_arr_board);

        if ($this->input->post()) {
            $conf_post_array = $this->input->post(NULL, TRUE);
            $conf_post_array = $this->validation_model->stripTagsPostArray($conf_post_array);

                $cleanup_required = FALSE;
                $result = FALSE;
                if ($this->MLM_PLAN == "Board" && $this->input->post('board_setting') && $this->validate_board_setting()) {
                    $board_count = $conf_post_array['board_count'];
                    for ($i = 0; $i < $board_count; $i++) {
                        $board_depth = $conf_post_array["board" . $i . "_depth"];
                        $board_width = $conf_post_array["board" . $i . "_width"];
                        if ($board_width > 10) {
                            $msg = $this->lang->line('board_width_cannot_be_greater_than_three');
                            $this->redirect($msg, "configuration/configuration_view", FALSE);
                        }
                        if ($board_depth > 10) {
                            $msg = $this->lang->line('10');
                            $this->redirect($msg, "configuration/plan_settings", FALSE);
                        }
                    }
                    $cleanup_required = $this->check_plan_variables($conf_post_array);
                    $result = $this->configuration_model->updateBoardSetting($conf_post_array, $board_count);
                }
                if ($this->MLM_PLAN == "Matrix" && $this->input->post('matrix_setting') && $this->validate_matrix_setting()) {
                    $cleanup_required = $this->check_plan_variables($conf_post_array);
                    $result = $this->configuration_model->updateMatrixSetting($conf_post_array);
                    if ($result) {
                        // $this->configuration_model->setLevel($conf_post_array['depth_ceiling'], $obj_arr['depth_ceiling']);
                    }
                }
                /* if ((in_array($this->MLM_PLAN, ['Unilevel', 'Donation', 'Stair_Step']) || $this->MODULE_STATUS['sponsor_commission_status'] == "yes") && $this->input->post('level_setting') && $this->validate_level_setting()) {
                    $cleanup_required = $this->check_plan_variables($conf_post_array);
                    $result = $this->configuration_model->updateLevelSetting($conf_post_array);
                    if ($result) {
                        $this->configuration_model->setLevel($conf_post_array['depth_ceiling'], $obj_arr['depth_ceiling']);
                    }
                }

                if ($this->MLM_PLAN == "Binary" && $this->input->post('binary_bonus_setting') && $this->validate_binary_bonus_common()) {
                    $conf_post_array = $this->input->post(NULL, TRUE);
                    $conf_post_array = $this->validation_model->stripTagsPostArray($conf_post_array);
                    $result = $this->configuration_model->updateBinaryBonusConfigCommon($conf_post_array);
                } */

                if ($result) {
                    if (DEMO_STATUS == 'yes') {
                        $demo_id = $this->validation_model->getAdminId();
                        $plan_configured = $this->login_model->isPlanConfigured($demo_id);
                        if ($plan_configured == 'no') {
                            $this->login_model->setPlanConfigured($demo_id);
                        }
                    }
                    if ($conf_post_array['cleanup_flag'] == "do_clean" && $cleanup_required) {
                        $this->load->model('cleanup_model');
                        $this->cleanup_model->clean($this->MODULE_STATUS);
                    }
                    $login_id = $this->LOG_USER_ID;
                    $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'configuration_setting', 'Configuration Changed');
                    }
                    $msg = $this->lang->line('configuration_updated_successfully');
                    $this->redirect($msg, "configuration/plan_settings", true);
                } else {
                    if (empty($this->form_validation->error_array())) {
                        $msg = $this->lang->line('error_on_configuration_updation');
                        $this->redirect($msg, "configuration/plan_settings", FALSE);
                    }
                }
        }

        $this->set('board_count', $board_count);
        $this->set('obj_arr', $obj_arr);
        $this->set('obj_arr_board', $obj_arr_board);
        $this->setView();
    }

    function compensation_settings()
    {
        $title = lang('compensation_settings');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'network-configuration ';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('compensation_settings');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('compensation_settings');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $mlm_plan = $this->MODULE_STATUS['mlm_plan'];
        $this->set('MLM_PLAN', $mlm_plan);

        $obj_arr = $this->configuration_model->getCompensationSettings();
        $bonus = $this->validation_model->getConfig(['matching_bonus','pool_bonus','fast_start_bonus','performance_bonus']);

        $this->set('bonus', $bonus);
        $this->set('plan_commission', $obj_arr['plan_commission_status']);
        $this->set('rank_commission', $obj_arr['rank_commission_status']);
        $this->set('referal_commission', $obj_arr['referal_commission_status']);
        $this->set('sponsor_commission', $obj_arr['sponsor_commission_status']);
        $this->set('roi_commission', $obj_arr['roi_commission_status']);
        $this->set('matching_bonus_status', $obj_arr['matching_bonus']);
        $this->set('pool_bonus_status', $obj_arr['pool_bonus']);
        $this->set('fast_start_bonus_status', $obj_arr['fast_start_bonus']);
        $this->set('performance_bonus_status', $obj_arr['performance_bonus']);
        $this->set('sales_commission_status', $obj_arr['sales_commission']);
        $this->set('car_bonus_status', $obj_arr['car_bonus']);
        $this->set('global_bonus_status', $obj_arr['global_bonus']);

        $this->setView();
    }

    public function update_compensations()
    {
        $res = [];
        $res['response'] = false;
        if ($this->input->is_ajax_request() && $this->input->post()) {
            $bonus_name = $this->input->post('bonus_name', true);
            $status = $this->input->post('status', true);
            $status = ($status == 'true') ? 'yes' : 'no';
            $res['response'] = $this->configuration_model->updateCompensationStatus($bonus_name, $status);
            echo json_encode($res);
            exit();
        }
    }
    public function referal_commissions($arg = null)
    {
        $referal_commission_status = $this->validation_model->getCompensationConfig('referal_commission_status');
        if ($referal_commission_status != 'yes') {
            $this->deny_permission();
        }

        $title = lang('referal_commission');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'referal-commissionsn ';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('referal_commission');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('referal_commission');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $mlm_plan = $this->MODULE_STATUS['mlm_plan'];
        $this->set('MLM_PLAN', $mlm_plan);

        $obj_arr = $this->configuration_model->getSettings();
        $commission_type = $this->validation_model->getConfig('sponsor_commission_type');
        $this->set('commission_type', $commission_type);

        if ($this->input->post() && $this->validate_referal_commission()) {
            $conf_post_array = $this->input->post(NULL, TRUE);
            $conf_post_array = $this->validation_model->stripTagsPostArray($conf_post_array);
            $result = FALSE;
            if ($this->MODULE_STATUS['sponsor_commission_status'] == "yes") {
                    $result = $this->configuration_model->updateReferalCommission($conf_post_array, $this->DEFAULT_CURRENCY_VALUE);
            }
            if ($result) {
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'commission_setting', 'Commission Settings Updated');
                }
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/referal_commissions", true);
            } else {
                if (empty($this->form_validation->error_array())) {
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $this->redirect($msg, "configuration/referal_commissions", false);
                }
            }
        }

        if($this->MODULE_STATUS['rank_status'] == "yes"){
            $rank_details = $this->configuration_model->getActiveRankDetails();
            $count = count($rank_details);
            $this->set('rank_details', $rank_details);
            $this->set('count', $count);
        }

        if($this->MODULE_STATUS['product_status'] == "yes"  || ($this->MODULE_STATUS['opencart_status'] == "yes" && $this->MODULE_STATUS['opencart_status_demo'] == "yes")){
            $product_details = $this->configuration_model->getCommissionProductDetails();
            $this->set('product_details', $product_details);
        }
        if($arg){
            $active = $arg;
        }else{
            $active = $obj_arr['sponsor_commission_type'];
        }
        $this->load->model('currency_model');

        $project_default_currency = $this->currency_model->getProjectDefaultCurrencyDetails();

        $this->set('obj_arr', $obj_arr);
        $this->set('project_default_currency', $project_default_currency);
        $this->set('active', $active);

        $this->setView();
    }
    public function validate_referal_commission()
    {
        $level_commission_type = $this->input->post('referal_commission_type');
        $commission_type = $this->input->post('sponsor_commission_type');
        if($commission_type == 'rank'){
            $rank_details = $this->configuration_model->getActiveRankDetails();
            foreach ($rank_details as $rank) {
                if ($level_commission_type == 'percentage') {
                    $this->form_validation->set_rules("rank_referal{$rank['rank_id']}", lang('referal_commission'), 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]');
                } elseif ($level_commission_type == 'flat') {
                    $this->form_validation->set_rules("rank_referal{$rank['rank_id']}", lang('referal_commission'), 'trim|required|greater_than_equal_to[0]|max_length[5]');
                }
            }
        }elseif($commission_type == 'sponsor_package' || $commission_type == 'joinee_package'){
            $product_details = $this->configuration_model->getCommissionProductDetails();
            foreach ($product_details as $u) {
                if ($level_commission_type == 'percentage') {
                    $this->form_validation->set_rules("pck_referal{$u['product_id']}", lang('referal_commission') , 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]');
                } elseif ($level_commission_type == 'flat') {
                    $this->form_validation->set_rules("pck_referal{$u['product_id']}", lang('referal_commission'), 'trim|required|greater_than_equal_to[0]|max_length[5]');
                }
            }
        }
        if ($this->MODULE_STATUS['product_status'] == 'yes' || $this->MODULE_STATUS['rank_status'] == 'yes') {
            $this->form_validation->set_rules("referal_commission_type", lang('type_of_commission'), 'trim|required');
            $this->form_validation->set_rules("sponsor_commission_type", lang('commission_criteria'), 'trim|required');
        } else {
            $this->form_validation->set_rules("referal_amount", lang('referal_commission'), 'trim|required|greater_than_equal_to[0]|max_length[5]');

        }
        $res_val = $this->form_validation->run_with_redirect("configuration/referal_commissions/$commission_type");
        return $res_val;
    }
    public function rank_commissions()
    {

        $title = lang('rank_achieved_bonus');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'rank-configuration';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('rank_achieved_bonus');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('rank_achieved_bonus');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        if ($this->input->post() && $this->validate_rank_commission()) {
            $conf_post_array = $this->input->post(NULL, TRUE);
            $conf_post_array = $this->validation_model->stripTagsPostArray($conf_post_array);
            $result = FALSE;
            if ($this->MODULE_STATUS['rank_status'] == "yes") {
                    $result = $this->configuration_model->updateRankCommission($conf_post_array, $this->DEFAULT_CURRENCY_VALUE);
            }
            if ($result) {
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'commission_setting', 'Commission Settings Updated');
                }
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/rank_commissions", true);
            } else {
                if (empty($this->form_validation->error_array())) {
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $this->redirect($msg, "configuration/rank_commissions", false);
                }
            }
        }

        if($this->MODULE_STATUS['rank_status'] == "yes"){
            $rank_details = $this->configuration_model->getActiveRankDetails();
            $this->set('rank_details', $rank_details);
        }

        $this->setView();
    }
    public function validate_rank_commission()
    {
        $rank_details = $this->configuration_model->getActiveRankDetails();
        foreach ($rank_details as $rank) {
            $this->form_validation->set_rules("rank{$rank['rank_id']}", strtolower(lang('rank_achieved_bonus')), 'trim|required|greater_than_equal_to[0]|max_length[5]');
        }
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    public function rank_level()
    {
        $obj_arr = $this->configuration_model->getRankConfiguration();
        $rank_details = $all_rank_details =  $this->configuration_model->getAllRankDetails();
        $joined_package_details = $this->configuration_model->getjoinedPackageDetails();
        $pck_count = count($joined_package_details);
        if($this->input->post('level') && $this->input->post('level') != $obj_arr['maximum_rank']) {
            if($this->input->post('level') < $obj_arr['maximum_rank']){
                $level_flag = !empty($rank_details)?true:false;
                $count = $obj_arr['maximum_rank'] - $this->input->post('level');
                for($i = 0;$i < $count;$i++) {
                    if($level_flag)
                        array_pop($rank_details);
                }
            } else {
                $level_flag = !empty($rank_details)?true:false;
                $low = $obj_arr['maximum_rank'];
                $high = $this->input->post('level');
                $count = $obj_arr['maximum_rank'] - $this->input->post('level');
                $arr = [ 'rank_id' =>'', 'rank_name' =>'', 'referal_count' =>'','personal_pv' =>'', 'gpv' =>'','downline_count' =>'','team_member_count' =>'','rank_color' =>'', 'downline_rank_id' =>'', 'downline_rank_count' =>''];
                for($l = 0;$l < $pck_count;$l++) {
                    $arr['package_rank'][$l] = ['product_id' => $joined_package_details[$l]['product_id'],'product_name' => $joined_package_details[$l]['product_name'],'package_count' =>''];
                }
                for($i = ++$low;$i <= $high;$i++) {
                    if($level_flag) {
                        array_push($rank_details,$arr);
                    }
                }
            }
        }

        $commission_type = $this->validation_model->getConfig('sponsor_commission_type');

        $this->set('joined_package_details', $joined_package_details);
        $count = count($rank_details);
        $this->set('commission_type', $commission_type);
        $this->set('rank_details', $rank_details);
        $this->set('all_rank_details', $all_rank_details);
        $this->set('count', $count);

        $this->setView();
    }

    public function validate_rank_settings()
    {
        $this->form_validation->set_rules("rank_expiry", lang('rank_expiry'), 'trim|required');
       // $this->form_validation->set_rules("default_rank", lang('default_rank'), 'trim|required');
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    public function fast_start_bonus()
    {
        $fast_start_bonus_status = $this->validation_model->getCompensationConfig('fast_start_bonus');
        if ($fast_start_bonus_status != 'yes') {
            $this->deny_permission();
        }
        $title = lang('fast_start_bonus');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'fast-start-bonus';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('fast_start_bonus');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('fast_start_bonus');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        if ($this->input->post() && $this->validate_fast_start_bonus()) {
            $conf_post_array = $this->input->post(NULL, TRUE);
            $conf_post_array = $this->validation_model->stripTagsPostArray($conf_post_array);
            $result = $this->configuration_model->updateFastStartBonus($conf_post_array);
            if ($result) {
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'additional_bonus', 'Additional Bonus Updated');
                }
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/fast_start_bonus_config", true);
            } else {
                if (empty($this->form_validation->error_array())) {
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $this->redirect($msg, "configuration/fast_start_bonus_config", false);
                }
            }
        }

        $fast_start_bonus_config = $this->configuration_model->getFastStartBonusConfig();
        $this->set('fast_start_bonus_config', $fast_start_bonus_config);
        
       

        $this->setView();
    }
    public function pool_bonus()
    {
        $pool_bonus = $this->validation_model->getCompensationConfig('pool_bonus');
        if ($pool_bonus != 'yes') {
            $this->deny_permission();
        }

        $pool_bonus_status = $this->validation_model->getCompensationConfig('pool_bonus');
        if ($pool_bonus_status != 'yes') {
            $this->deny_permission();
        }
        $title = lang('pool_bonus');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'pool_bonus';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('pool_bonus');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('pool_bonus');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $obj_arr = $this->configuration_model->getSettings();

        if ($this->input->post() && $this->validate_pool_commission()) {
            $conf_post_array = $this->input->post(NULL, TRUE);
            $conf_post_array = $this->validation_model->stripTagsPostArray($conf_post_array);
            $result = FALSE;
            if ($this->MODULE_STATUS['rank_status'] == "yes") {
                    $result = $this->configuration_model->updatePoolCommission($conf_post_array, $this->DEFAULT_CURRENCY_VALUE);
            }
            if ($result) {
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'commission_setting', 'Commission Settings Updated');
                }
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "pool_bonus_config", true);
            } else {
                if (empty($this->form_validation->error_array())) {
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $this->redirect($msg, "pool_bonus_config", false);
                }
            }
        }

        $pool_bonus_config = $this->configuration_model->getActiveRankDetails();
        $this->set('pool_bonus_config', $pool_bonus_config);
        $this->set('pool_bonus_percent', $obj_arr['pool_bonus_percent']);
        $project_default_currency = $this->currency_model->getProjectDefaultCurrencyDetails();

        $this->set('obj_arr', $obj_arr);
        $this->set('project_default_currency', $project_default_currency);

        $this->setView();
    }
    public function validate_pool_commission()
    {
        $pool_arr =  $this->input->post(NULL, TRUE);
        $rank_details = $this->configuration_model->getActiveRankDetails();
        foreach ($rank_details as $rank) {
            if(array_key_exists("pool_rank{$rank['rank_id']}",$pool_arr)){
                $this->form_validation->set_rules("pool_level{$rank['rank_id']}", lang('pool_percentage'), 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]');
            }
        }
        $this->form_validation->set_rules("pool_bonus", lang('bonus'), 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]');
        $this->form_validation->set_rules("pool_bonus_period", lang('pool_bonus_period'), 'trim|required');
        $this->form_validation->set_rules("pool_bonus_criteria", lang('pool_bonus_criteria'), 'trim|required');
        $this->form_validation->set_rules("pool_distribution_criteria", lang('pool_distribution_criteria'), 'trim|required');
        $res_val = $this->form_validation->run();
        return $res_val;
    }
    public function binary_bonus()
    {
        $binary_bonus_status = $this->validation_model->getCompensationConfig('plan_commission_status');
        if ($binary_bonus_status != 'yes') {
            $this->deny_permission();
        }
        $this->load->model('product_model');
        $title = lang('binary_commission');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'binary-bonus';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('binary_commission');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('binary_commission');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        if ($this->input->post() && $this->validate_binary_bonus()) {
            $conf_post_array = $this->input->post(NULL, TRUE);
            $conf_post_array = $this->validation_model->stripTagsPostArray($conf_post_array);
            $result = $this->configuration_model->updateBinaryBonusConfig($conf_post_array);
            if ($result) {
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'binary_bonus', 'Additional Bonus Updated');
                }
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/binary_bonus_config", true);
            } else {
                if (empty($this->form_validation->error_array())) {
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $this->redirect($msg, "configuration/binary_bonus_config", false);
                }
            }
        }

        $binary_bonus_config = $this->configuration_model->getBinaryBonusConfig();
        $this->set('binary_bonus_config', $binary_bonus_config);
        $package_list =[];
        if ($this->MODULE_STATUS['opencart_status'] == 'yes') {
            $package_list = $this->product_model->getMembershipPackageListByColumns('model as product_name,pair_price,product_id');
        }
        elseif ($this->MODULE_STATUS['product_status'] == 'yes') {
            $package_list = $this->product_model->getMembershipPackageListByColumns('product_name,pair_price,product_id');
        }
        $this->set('package_list', $package_list);

        $this->setView();
    }

    public function board_bonus()
    {
        $title = $this->MODULE_STATUS['table_status'] == 'no' ? lang('board_commission') : lang('table_commission');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'board-bonus';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = $this->MODULE_STATUS['table_status'] == 'no' ? lang('board_commission') : lang('table_commission');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = $this->MODULE_STATUS['table_status'] == 'no' ? lang('board_commission') : lang('table_commission');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        if ($this->input->post('board_commission') && $this->validate_board_commission()) {
            $conf_post_array = $this->input->post(NULL, TRUE);
            $conf_post_array = $this->validation_model->stripTagsPostArray($conf_post_array);

            $status = true;//$this->check_numeric($conf_post_array);
            if (!$status) {
                $msg = $this->lang->line('invalid_input');
                $this->redirect($msg, "compensation_settings", false);
            }
            $result = $this->configuration_model->updateBoardCommission($conf_post_array, $conf_post_array['board_count']);

            if ($result) {
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'board_bonus', 'Additional Bonus Updated');
                }
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/board_bonus_config", true);
            } else {
                if (empty($this->form_validation->error_array())) {
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $this->redirect($msg, "configuration/board_bonus_config", false);
                }
            }
        }

        $board_bonus_config = $this->configuration_model->getBoardSettings();
        $board_count = count($board_bonus_config);

        $this->set('board_bonus_config', $board_bonus_config);
        $this->set('board_count', $board_count);
        $this->setView();
    }

    public function stairstep_bonus()
    {
        $title = lang('step_commission');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'step-bonus';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('step_commission');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('step_commission');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $this->setView();
    }

    public function validate_binary_bonus()
    {
        $binary_bonus_status = $this->validation_model->getCompensationConfig('plan_commission_status');
        $commission_type = $this->input->post('commission_type');
        if ($binary_bonus_status == 'yes') {
            $this->load->model('product_model');
            /*$this->form_validation->set_rules('calculation_criteria', strtolower(lang('calculation_criteria')), 'trim|required|in_list[sales_volume,sales_price,fixed]', ['in_list' => 'You must select %s']);
            $this->form_validation->set_rules('calculation_period', strtolower(lang('calculation_period')), 'trim|required|in_list[instant,daily,weekly,monthly]', ['in_list' => 'You must select %s']);
            $this->form_validation->set_rules('pair_type', strtolower(lang('pair_type')), 'trim|required|in_list[11,21]', ['in_list' => 'You must select %s']);
            $this->form_validation->set_rules('commission_type', strtolower(lang('commission_type')), 'trim|required|in_list[flat,percentage]', ['in_list' => 'You must select %s']);
            if ($commission_type == 'flat') {
                $this->form_validation->set_rules('pair_value', lang('pair_value'), 'trim|required|greater_than[0]');
            }*/
            if ($this->MODULE_STATUS['product_status'] == 'no') {
                // $this->form_validation->set_rules('point_value', lang('point_value'), 'trim|required|greater_than_equal_to[0]');
                if ($commission_type == 'percentage') {
                    $this->form_validation->set_rules('pair_commission', lang('pair_commission'), 'trim|required|greater_than[0]|less_than_equal_to[100]');
                } elseif ($commission_type == 'flat') {
                    $this->form_validation->set_rules('pair_commission', lang('pair_commission'), 'trim|required|greater_than[0]');
                }
            }
            else {
                if ($this->MODULE_STATUS['opencart_status'] == 'yes') {
                    $package_list = $this->product_model->getMembershipPackageListByColumns('model as product_name,pair_price,product_id');
                } else {
                    $package_list = $this->product_model->getMembershipPackageListByColumns('product_name,pair_price,product_id');
                }
                foreach ($package_list as $pack) {
                    if ($commission_type == 'percentage') {
                        $this->form_validation->set_rules("pair_commission_{$pack['product_id']}", lang('pair_commission'), 'trim|required|greater_than[0]|less_than_equal_to[100]');
                    } elseif ($commission_type == 'flat') {
                        $this->form_validation->set_rules("pair_commission_{$pack['product_id']}", lang('pair_commission'), 'trim|required|greater_than[0]');
                    }
                }
            }
            /*if ($this->input->post('flush_out')) {
                if ($commission_type == 'flat') {
                    $this->form_validation->set_rules('flush_out_limit', lang('max_pair_for_flush_out'), 'trim|required|integer|greater_than[0]|max_length[5]');
                } elseif ($commission_type == 'percentage') {
                    $this->form_validation->set_rules('flush_out_limit', lang('max_pair_for_flush_out'), 'trim|required|greater_than[0]|max_length[5]');
                }
                $calculation_period = $this->input->post('calculation_period');
                if ($calculation_period == 'instant') {
                    $this->form_validation->set_rules('flush_out_period', strtolower(lang('flush_out_period')), 'trim|required|in_list[daily,weekly,monthly]', ['in_list' => 'You must select %s']);
                }
            }*/
            $res_val = $this->form_validation->run();
            return $res_val;
        }
    }

    public function roi_commission()
    {
        $this->url_permission('roi_status');
        $title = lang('roi_commissions');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'roi-configuration';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('roi_commissions');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('roi_commissions');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $obj_arr = $this->configuration_model->getSettings();
        $skip_days = explode(',',$obj_arr['roi_days_skip']);

        if ($this->input->post() && $this->validate_roi_commission()) {
            $roi_post_array = $this->input->post(NULL, TRUE);
            $roi_post_array = $this->validation_model->stripTagsPostArray($roi_post_array);
            $result = FALSE;
            if ($this->MODULE_STATUS['roi_status'] == "yes") {
                    $result = $this->configuration_model->updateRoiCommission($roi_post_array);
            }
            if ($result) {
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'commission_setting', 'Commission Settings Updated');
                }
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/roi_commission", true);
            } else {
                if (empty($this->form_validation->error_array())) {
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $this->redirect($msg, "configuration/roi_commission", false);
                }
            }
        }
        if($this->MODULE_STATUS['product_status'] == "yes"  || ($this->MODULE_STATUS['opencart_status'] == "yes" && $this->MODULE_STATUS['opencart_status_demo'] == "yes")){
            $product_details = $this->configuration_model->getProductRoiDetails();
            $this->set('product_details', $product_details);
        }

        $this->set('obj_arr', $obj_arr);
        $this->set('skip_days', $skip_days);
        $this->setView();
    }

    function validate_roi_commission()
    {
        $this->form_validation->set_rules('roi_criteria', lang('roi_criteria'), 'trim|required');
        $this->form_validation->set_rules('period', lang('period'), 'trim|required');
        $product_details = $this->configuration_model->getProductRoiDetails();
        foreach ($product_details as $u) {
                $this->form_validation->set_rules("pck_roi{$u['product_id']}", strtolower(lang('roi')) , 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]|max_length[5]');
                $this->form_validation->set_rules("pck_days{$u['product_id']}", strtolower(lang('days')) , 'trim|required|integer|greater_than_equal_to[0]|max_length[5]');
        }

        $res_val = $this->form_validation->run();
        return $res_val;
    }
    public function validate_binary_bonus_common()
    {
        $binary_bonus_status = $this->validation_model->getCompensationConfig('plan_commission_status');
        $commission_type = $this->input->post('commission_type');
        if ($binary_bonus_status == 'yes') {
            $this->load->model('product_model');
            $this->form_validation->set_rules('calculation_criteria', strtolower(lang('calculation_criteria')), 'trim|required|in_list[sales_volume,sales_price,fixed]', ['in_list' => 'You must select %s']);
            $this->form_validation->set_rules('calculation_period', strtolower(lang('calculation_period')), 'trim|required|in_list[instant,daily,weekly,monthly]', ['in_list' => 'You must select %s']);
            $this->form_validation->set_rules('pair_type', strtolower(lang('pair_type')), 'trim|required|in_list[11,21]', ['in_list' => 'You must select %s']);
            $this->form_validation->set_rules('commission_type', strtolower(lang('commission_type')), 'trim|required|in_list[flat,percentage]', ['in_list' => 'You must select %s']);
            if ($commission_type == 'flat') {
                $this->form_validation->set_rules('pair_value', lang('pair_value'), 'trim|required|greater_than[0]');
            }
            if ($this->MODULE_STATUS['product_status'] == 'no') {
                $this->form_validation->set_rules('point_value', lang('point_value'), 'trim|required|greater_than_equal_to[0]');
            }
            if ($this->input->post('flush_out')) {
                if ($commission_type == 'flat') {
                    $this->form_validation->set_rules('flush_out_limit', lang('max_pair_for_flush_out'), 'trim|required|integer|greater_than[0]|max_length[5]');
                } elseif ($commission_type == 'percentage') {
                    $this->form_validation->set_rules('flush_out_limit', lang('max_pair_for_flush_out'), 'trim|required|greater_than[0]|max_length[5]');
                }
                $calculation_period = $this->input->post('calculation_period');
                if ($calculation_period == 'instant') {
                    $this->form_validation->set_rules('flush_out_period', strtolower(lang('flush_out_period')), 'trim|required|in_list[daily,weekly,monthly]', ['in_list' => 'You must select %s']);
                }
            }
            $res_val = $this->form_validation->run();
            return $res_val;
        }
    }
    public function validate_level_commission_common()
    {
        $depth_ceiling = $this->input->post('commission_upto_level');
        $commission_type = $this->input->post('level_commission_criteria');

        if ($this->MODULE_STATUS['xup_status'] == 'yes') {
            $this->form_validation->set_rules('xup_level', lang('xup_level'), 'trim|required|numeric|greater_than[0]|less_than[4]');
        }

        $this->form_validation->set_rules("level_commission_type", lang('level_commission_type'), 'trim|required');
        $this->form_validation->set_rules("level_commission_criteria", lang('commission_criteria'), 'trim|required');
        $this->form_validation->set_rules("commission_upto_level", lang('level_commission_upto_level'), 'trim|required|numeric|greater_than[0]|less_than[100]');
        $res_val = $this->form_validation->run_with_redirect("configuration/level_commissions/$commission_type/$depth_ceiling");
        return $res_val;
    }
    function matching_bonus($arg = NULL,$level = NULL)
    {

        $matching_bonus = $this->validation_model->getCompensationConfig('matching_bonus');
        if ($matching_bonus != 'yes') {
            $this->deny_permission();
        }

        $title = lang('matching_bonus');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'Matching-bonus';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('matching_bonus');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('matching_bonus');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();
        $this->load->model('currency_model');

        $mlm_plan = $this->MODULE_STATUS['mlm_plan'];
        $this->set('MLM_PLAN', $mlm_plan);

        $arr_level = [];
        $arr_level_reg_pack = [];
        $pck_array = [];

        $obj_arr = $this->configuration_model->getSettings();
        $arr_level = $this->configuration_model->getMatchLevelSettings();
        if ($this->MODULE_STATUS['product_status'] == "yes" || ($this->MODULE_STATUS['opencart_status'] == "yes" && $this->MODULE_STATUS['opencart_status_demo'] == "yes")) {
            $pck_array = $this->configuration_model->getLevelCommissionPackages();
            $arr_level_reg_pack = $this->configuration_model->getMatchingCommission();
            $this->set('arr_pck', $pck_array );
        }

        if($arg){
            $active_commission = $arg;
        }else{
            $active_commission = $obj_arr['matching_criteria'];
        }
        if($level){
            $active_level = $level;
        }else{
            $active_level = $obj_arr['matching_upto_level'];
        }

        if ($this->input->post('matching_commission_common')) {
            $conf_post_array = $this->input->post(NULL, TRUE);
            $conf_post_array = $this->validation_model->stripTagsPostArray($conf_post_array);
            $result = FALSE;
            if($this->validate_matching_commission_common()){
                $result = $this->configuration_model->updateMatchingCommissionCommon($conf_post_array);
            }else{
                $msg = $this->lang->line('error_on_configuration_updation');
                $type = $conf_post_array['commission_criteria'];
                $this->redirect($msg, "configuration/matching_bonus/$type", false);
            }
            if ($result) {
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'commission_setting', 'Commission Settings Updated');
                }
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/matching_bonus", true);
            } else {
                if (empty($this->form_validation->error_array())) {
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $this->redirect($msg, "configuration/matching_bonus", false);
                }
            }
        }
        if ($this->input->post('matching_commission')) {
            $conf_post_array = $this->input->post(NULL, TRUE);
            $conf_post_array = $this->validation_model->stripTagsPostArray($conf_post_array);
            $result = FALSE;
            if($this->validate_matching_commission()){
                $result = $this->configuration_model->updateMatchingCommission($conf_post_array, $this->DEFAULT_CURRENCY_VALUE);
            }else{
                $msg = $this->lang->line('error_on_configuration_updation');
                $type = $conf_post_array['commission_criteria'];
                $this->redirect($msg, "configuration/matching_bonus/$type", false);
            }
            if ($result) {
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'commission_setting', 'Commission Settings Updated');
                }
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/matching_bonus", true);
            } else {
                if (empty($this->form_validation->error_array())) {
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $this->redirect($msg, "configuration/matching_bonus", false);
                }
            }
        }

        $project_default_currency = $this->currency_model->getProjectDefaultCurrencyDetails();

        $this->set('obj_arr', $obj_arr);
        $this->set('arr_level', $arr_level);
        $this->set('arr_level_pck', $arr_level_reg_pack);
        $this->set('project_default_currency', $project_default_currency);
        $this->set('active_commission', $active_commission);
        $this->set('active_level', $active_level);

        $this->setView();
    }
    public function validate_matching_commission_common()
    {
        $depth_ceiling = $this->input->post('commission_upto_level');
        $commission_type = $this->input->post('commission_criteria');

        $this->form_validation->set_rules("commission_criteria", lang('matching_commission_criteria'), 'trim|required');
        $this->form_validation->set_rules("commission_upto_level", lang('matching_commission_upto_level'), 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
        $res_val = $this->form_validation->run_with_redirect("configuration/matching_bonus/$commission_type/$depth_ceiling");
        return $res_val;
    }
    public function validate_matching_commission()
    {
        $depth_ceiling = $this->validation_model->getConfig('matching_upto_level');
        if ($depth_ceiling > 0) {
            $commission_type = $this->validation_model->getConfig('matching_criteria');
            if($commission_type == 'genealogy'){
                for ($i = 1; $i <= $depth_ceiling; $i++) {
                    $this->form_validation->set_rules("level_percentage{$i}", lang('bonus_'), 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]');
                }
            }else{
                $arr_pck = $this->configuration_model->getLevelCommissionPackages();
                for ($j = 1; $j <= $depth_ceiling; $j++) {
                    foreach ($arr_pck as $pack) {
                        $prod_id = $pack['prod_id'];
                        $this->form_validation->set_rules("level_" . $j . "_" . $prod_id . "_member", lang('bonus_') , 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]');
                    }
                }
            }
            $res_val = $this->form_validation->run_with_redirect("configuration/matching_bonus");
            return $res_val;
        }
    }
    function performance_bonus()
    {

        $performance_bonus = $this->validation_model->getCompensationConfig('performance_bonus');
        if ($performance_bonus != 'yes') {
            $this->deny_permission();
        }

        $title = lang('performance_bonus');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'Performance-bonus';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('performance_bonus');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('performance_bonus');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();
        $this->load->model('currency_model');

        $mlm_plan = $this->MODULE_STATUS['mlm_plan'];
        $this->set('MLM_PLAN', $mlm_plan);

        $obj_arr = $this->configuration_model->getSettings();
        $performance_bonus_config = $this->configuration_model->getPerformanceBonusConfig();

        if ($this->input->post('performance_bonus_setting') && $this->validate_performance_bonus()) {
            $conf_post_array = $this->input->post(NULL, TRUE);
            $conf_post_array = $this->validation_model->stripTagsPostArray($conf_post_array);
            $result = $this->configuration_model->updatePerformanceBonus($conf_post_array);
            if ($result) {
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'commission_setting', 'Commission Settings Updated');
                }
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/performance_bonus", true);
            } else {
                if (empty($this->form_validation->error_array())) {
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $this->redirect($msg, "configuration/performance_bonus", false);
                }
            }
        }

        $project_default_currency = $this->currency_model->getProjectDefaultCurrencyDetails();

        $this->set('obj_arr', $obj_arr);
        $this->set('project_default_currency', $project_default_currency);
        $this->set('performance_bonus_status', $obj_arr['performance_bonus']);
        $this->set('performance_bonus_config', $performance_bonus_config);
        $this->setView();
    }
    function sales_commission($arg = NULL,$level = NULL,$arg1 = NULL)
    {

        $sales_commission = $this->validation_model->getCompensationConfig('sales_commission');
        if ($sales_commission != 'yes') {
            $this->deny_permission();
        }

        $title = lang('sales_commission');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'Sales-commission';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('sales_commission');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('sales_commission');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();
        $this->load->model('currency_model');

        $mlm_plan = $this->MODULE_STATUS['mlm_plan'];
        $this->set('MLM_PLAN', $mlm_plan);

        $arr_level = [];
        $arr_level_pck = [];
        $arr_level_rank = [];
        $pck_array = [];

        $obj_arr = $this->configuration_model->getSettings();
        $arr_level = $this->configuration_model->getSalesLevelSettings();
        if ($this->MODULE_STATUS['product_status'] == "yes" || ($this->MODULE_STATUS['opencart_status'] == "yes" && $this->MODULE_STATUS['opencart_status_demo'] == "yes")) {
            $pck_array = $this->configuration_model->getLevelCommissionPackages();
            $arr_level_pck = $this->configuration_model->getSalesCommission();
            $this->set('arr_pck', $pck_array );
            $this->set('arr_level_pck', $arr_level_pck );
        }
        if ($this->MODULE_STATUS['rank_status'] == "yes") {
            $rank_array = $this->configuration_model->getSalesRankDetails();
            $arr_level_rank = $this->configuration_model->getSalesRankCommission();
            $this->set('rank_array', $rank_array );
            $this->set('arr_level_rank', $arr_level_rank);
        }

        if($arg){
            $active_criteria = $arg;
        }else{
            $active_criteria = $obj_arr['sales_criteria'];
        }
        if($level){
            $active_level = $level;
        }else{
            $active_level = $obj_arr['sales_level'];
        }
        if($arg1){
            $active_type = $arg1;
        }else{
            $active_type = $obj_arr['sales_type'];
        }

        if ($this->input->post('sales_commission_common')) {
            $conf_post_array = $this->input->post(NULL, TRUE);
            $conf_post_array = $this->validation_model->stripTagsPostArray($conf_post_array);
            $result = FALSE;
            if($this->validate_sales_commission_common()){
                $result = $this->configuration_model->updateSalesCommissionCommon($conf_post_array);
            }else{
                $msg = $this->lang->line('error_on_configuration_updation');
                $type = $conf_post_array['commission_criteria'];
                $level = $conf_post_array['sales_type'];
                $type1 = $conf_post_array['commission_upto_level'];
                $this->redirect($msg, "configuration/matching_bonus/$type/$level/$type1", false);
            }
            if ($result) {
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'commission_setting', 'Commission Settings Updated');
                }
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/sales_commission", true);
            } else {
                if (empty($this->form_validation->error_array())) {
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $this->redirect($msg, "configuration/sales_commission", false);
                }
            }
        }
        if ($this->input->post('sales_commission')) {
            $conf_post_array = $this->input->post(NULL, TRUE);
            $conf_post_array = $this->validation_model->stripTagsPostArray($conf_post_array);
            $result = FALSE;
            if($this->validate_sales_commission()){
                $result = $this->configuration_model->updateSalesCommission($conf_post_array, $this->DEFAULT_CURRENCY_VALUE);
            }
            if ($result) {
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'commission_setting', 'Commission Settings Updated');
                }
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/sales_commission", true);
            } else {
                if (empty($this->form_validation->error_array())) {
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $this->redirect($msg, "configuration/sales_commission", false);
                }
            }
        }

        $project_default_currency = $this->currency_model->getProjectDefaultCurrencyDetails();

        $this->set('obj_arr', $obj_arr);
        $this->set('arr_level', $arr_level);
        $this->set('project_default_currency', $project_default_currency);
        $this->set('active_criteria', $active_criteria);
        $this->set('active_type', $active_type);
        $this->set('active_level', $active_level);

        $this->setView();
    }
    public function validate_sales_commission_common()
    {
        $depth_ceiling = $this->input->post('commission_upto_level');
        $commission_type = $this->input->post('commission_criteria');
        $commission_type1 = $this->input->post('sales_type');

        $this->form_validation->set_rules("commission_criteria", lang('sales_commission_criteria'), 'trim|required');
        $this->form_validation->set_rules("sales_type", lang('sales_commission_distribution'), 'trim|required');
        $this->form_validation->set_rules("commission_upto_level", lang('distribution_upto_level'), 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
        $res_val = $this->form_validation->run_with_redirect("configuration/sales_commission/$commission_type/$depth_ceiling/$commission_type1");
        return $res_val;
    }
    public function validate_sales_commission()
    {
        $depth_ceiling = $this->validation_model->getConfig('sales_level');
        if ($depth_ceiling > 0) {
            $commission_type = $this->validation_model->getConfig('sales_type');
            if ($commission_type == 'genealogy') {
                for ($i = 1; $i <= $depth_ceiling; $i++) {
                    $this->form_validation->set_rules("level_percentage{$i}", lang('sales_perc'), 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]');
                }
            } elseif($commission_type == "package") {
                $arr_pck = $this->configuration_model->getLevelCommissionPackages();
                for ($j = 1; $j <= $depth_ceiling; $j++) {
                    foreach ($arr_pck as $pack) {
                        $prod_id = $pack['prod_id'];
                        $this->form_validation->set_rules("level_" . $j . "_" . $prod_id . "_sales", lang('sales_perc'), 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]');
                    }
                }
            }else{
                $arr_rank = $this->configuration_model->getSalesRankDetails();
                for ($j = 1; $j <= $depth_ceiling; $j++) {
                    foreach ($arr_rank as $pack) {
                        $rank_id = $pack['rank_id'];
                        $this->form_validation->set_rules("level_" . $j . "_" . $rank_id . "_rank", lang('sales_perc') , 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]');
                    }
                }
            }
        }
        $res_val = $this->form_validation->run();
        return $res_val;
    }
    
    public function fast_start_bonus_config()
    {
        $fast_start_bonus_status = $this->validation_model->getCompensationConfig('fast_start_bonus');
        if ($fast_start_bonus_status != 'yes') {
            $this->deny_permission();
        }
        $title = lang('fast_start_bonus');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'fast-start-bonus';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('fast_start_bonus');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('fast_start_bonus');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        if ($this->input->post() && $this->validate_fast_start_bonus()) {
            $conf_post_array = $this->input->post(NULL, TRUE);
            $conf_post_array = $this->validation_model->stripTagsPostArray($conf_post_array);
            $result = $this->configuration_model->updateFastStartBonus($conf_post_array);
            if ($result) {
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'additional_bonus', 'Additional Bonus Updated');
                }
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/fast_start_bonus", true);
            } else {
                if (empty($this->form_validation->error_array())) {
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $this->redirect($msg, "configuration/fast_start_bonus", false);
                }
            }
        }

        
        $fast_start_bonus = $this->configuration_model->getFastStartBonus();
        $this->set('fast_start_bonus', $fast_start_bonus);
        $this->setView();
    }
    
    function edit_fast_start_bonus($id=''){
    $title = lang('edit_fast_start_bonus');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'edit_fast_start_bonus';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('edit_fast_start_bonus');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('edit_fast_start_bonus');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        if ($this->input->method() == 'post') {
            $id = $this->input->post('id', true);//echo $id;  
        }
        $fast_bonus_details= $this->configuration_model->selectfastbonusDetails($id);
        //print_r($fast_bonus_details); die;
        $this->set('id', $fast_bonus_details['rank_id']);
        $this->set('rank_id', $fast_bonus_details['rank_id']);
        $this->set('rank_name', $fast_bonus_details['rank_name']);
        $this->set('level_1', $fast_bonus_details['level1']);
        $this->set('level_2', $fast_bonus_details['level2']);
        $this->set('level_3', $fast_bonus_details['level3']);
        $this->set('level_4', $fast_bonus_details['level4']);
        $this->set('level_5', $fast_bonus_details['level5']);
        $this->set('level_6', $fast_bonus_details['level6']);
        $this->set('level_7', $fast_bonus_details['level7']);
        $this->set('level_8', $fast_bonus_details['level8']);
        $this->set('level_9', $fast_bonus_details['level9']);
        $this->set('level_10', $fast_bonus_details['level10']);
       
        if (!$fast_bonus_details) {
            $redirect_msg = lang('package_not_available');
            $this->redirect($redirect_msg, 'configuration/fast_start_bonus', false);
        }
        if (($this->input->post('update_fast_bonus')) && ($this->validate_all_level_commission())) {
            $post_arr = $this->input->post(null, true);
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            //print_r($post_arr);die;
            $id = $post_arr['id'];
            $rank_id = $post_arr['rank_id']; //print($product_id);
            $rank_name = $post_arr['rank_name'];
            $level_1 = $post_arr['level_1'];
            $level_2 = $post_arr['level_2'];
            $level_3 = $post_arr['level_3'];
            $level_4 = $post_arr['level_4'];
            $level_5 = $post_arr['level_5'];
            $level_6 = $post_arr['level_6'];
            $level_7 = $post_arr['level_7'];
            $level_8 = $post_arr['level_8'];
            $level_9 = $post_arr['level_9'];
            $level_10 = $post_arr['level_10'];

            //print($week_84);//die;
            $result = $this->configuration_model->updatefastBonus($rank_id,$rank_name, $level_1, $level_2, $level_3, $level_4, $level_5,$level_6,$level_7,$level_8,$level_9,$level_10);
            if ($result) {
                $redirect_msg = lang('Level_commission_updated_succesfully');
                $this->redirect($redirect_msg, 'configuration/fast_start_bonus_config', true);
            } else {
                $redirect_msg = lang('error_on_updating_level');
                $this->redirect($redirect_msg, 'configuration/fast_start_bonus_config', false);
            }
        }
        
        $this->setView();
}       
    function validate_all_level_commission() {
        $this->form_validation->set_rules('level_1', lang('level_1'), 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
        $this->form_validation->set_rules('level_2', lang('level_2'), 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
        $this->form_validation->set_rules('level_3', lang('level_3'), 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
        $this->form_validation->set_rules('level_4', lang('level_4'), 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
        $this->form_validation->set_rules('level_5', lang('level_5'), 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
        $this->form_validation->set_rules('level_6', lang('level_6'), 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
        $this->form_validation->set_rules('level_7', lang('level_7'), 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
        $this->form_validation->set_rules('level_8', lang('level_8'), 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
        $this->form_validation->set_rules('level_9', lang('level_9'), 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
        $this->form_validation->set_rules('level_10', lang('level_10'), 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');

        $res_val = $this->form_validation->run();

        return $res_val;
    }    
    
    public function car_bonus_config(){
        
        $title = lang('car_bonus_config');
        $this->set("title", $this->COMPANY_NAME . " | $title");


        $this->HEADER_LANG['page_top_header'] = lang('car_bonus_config');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('car_bonus_config');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();
      
        
        if($this->input->post()){
            $rank_post_array = $this->input->post(NULL, TRUE);//print_r($rank_post_array); die;
            $rank_post_array = $this->validation_model->stripTagsPostArray($rank_post_array);
            $result = FALSE;
             $result = $this->configuration_model->updateCarBonusConfig($rank_post_array);
             
             if ($result) {
                
                 //insert configuration_change_history
                $car_bonus_amount = "Updated car bonus amount: " . serialize($rank_post_array);
                $this->configuration_model->insertConfigChangeHistory('car bonus settings', $car_bonus_amount);
                
                
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'car bonus setting', 'car bonus settings Updated');
                }
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/car_bonus_config", true);
            } else {
                if (empty($this->form_validation->error_array())) {
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $this->redirect($msg, "configuration/car_bonus_config", false);
                }
            }
        }
        $obj_arr = $this->configuration_model->getCarBonusConfig();
        $this->set('obj_arr', $obj_arr);
        $this->setView();
    }
    
    function cron_button()
    {
        

        $title = lang('cron');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('cron');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('cron');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $this->setView();
    }
    
    public function global_bonus_config(){
        
        $title = lang('global_bonus_config');
        $this->set("title", $this->COMPANY_NAME . " | $title");


        $this->HEADER_LANG['page_top_header'] = lang('global_bonus_config');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('global_bonus_config');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();
        
        if($this->input->post()){
            $rank_post_array = $this->input->post(NULL, TRUE);
            $rank_post_array = $this->validation_model->stripTagsPostArray($rank_post_array);
            $result = FALSE;
             $result = $this->configuration_model->updateGlobalBonus($rank_post_array);
             
             if ($result) {
                
                 //insert configuration_change_history
                $global_bonus_percentage = "Updated global bonus percentage: " . serialize($rank_post_array);
                $this->configuration_model->insertConfigChangeHistory('global bonus settings', $global_bonus_percentage);
                
                
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'global bonus setting', 'global bonus settings Updated');
                }
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/global_bonus_config", true);
            } else {
                if (empty($this->form_validation->error_array())) {
                    $msg = $this->lang->line('error_on_configuration_updation');
                    $this->redirect($msg, "configuration/global_bonus_config", false);
                }
            }
        }
        $obj_arr = $this->configuration_model->getGlobalBonusConfig();
        $this->set('obj_arr', $obj_arr);
        
        $this->setView();
      
    }
    
    //stripe configuration  --sahla
    public function stripe_configuration(){
        
         $title = lang('stripe_configuration');
        $this->set("title", $this->COMPANY_NAME . " | $title");


        $this->HEADER_LANG['page_top_header'] = lang('stripe_configuration');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('stripe_configuration');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();
        
        $stripe_details = $this->configuration_model->getStripeConfigurationDetails();
        //print_r($stripe_details); die;
        
         //to set redirection of back buttons
        $link_origin = $_SESSION['link_origin'] ?? 0;

        $this->set('link_origin', $link_origin);
        
         if ($this->input->post('update_stripe') && $this->validate_stripe_configuration()) {
            if (!empty($this->session->userdata('link_origin'))) {
                $link_origin = $this->session->userdata('link_origin');
            }
            $post_array = $this->input->post(NULL, TRUE);
            $post_array = $this->validation_model->stripTagsPostArray($post_array);
            $post_array = $this->validation_model->escapeStringPostArray($post_array);
            $user_id = $this->LOG_USER_ID;

            $pass = $this->ewallet_model->getUserPassword($user_id);

            $tran_pass = $post_array['pswd1'];
          
            if (password_verify($tran_pass, $pass) && $this->LOG_USER_TYPE == 'admin') {
                $result = $this->configuration_model->updateStripeConfiguration($post_array);
                if ($result) {
                 $stripe_config_change_history = "Updated Stripe configuration: " . serialize($post_array);
                 $this->configuration_model->insertConfigChangeHistory('Stripe configuration changes', $stripe_config_change_history);


                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'Stripe configuration change', $login_id);
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Stripe configuration changes', 'Stripe configuration changes Updated');
                }
                    $msg = $this->lang->line('stripe_configuration_updated_successfully');
                    $this->redirect($msg, 'configuration/stripe_configuration', true);
                } else {
                    $msg = $this->lang->line('stripe_configuration_updation_failed');
                    $this->redirect($msg, 'configuration/stripe_configuration', false);
                }
            } else {
                $msg = lang('invalid_transaction_password');
                $this->redirect($msg, 'configuration/stripe_configuration', false);
            }
        }
        
        $this->set('stripe_details',$stripe_details);
        $this->setView();
    }
    
     function validate_stripe_configuration()
    {
        
        
        $this->form_validation->set_rules('pswd1', lang('transaction_password'), 'trim|required');
        $this->form_validation->set_rules('stripe_key', lang('stripe_key'), 'trim|required');
        $this->form_validation->set_rules('stripe_secret', lang('stripe_secret'), 'trim|required');
        $validation_result = $this->form_validation->run();

        return $validation_result;
    }

    //stripe configuration  --sahla

    
}
