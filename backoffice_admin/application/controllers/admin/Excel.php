<?php

require_once 'Inf_Controller.php';

class Excel extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function user_profiles_excel() {
        $this->session->userdata('inf_profile_type');
        if ($this->session->userdata('inf_profile_type') == "one_count") {
            $cnt = $this->session->userdata('inf_profile_count');
            $arr = $this->excel_model->getProfiles($cnt);
            $date = date("Y-m-d H:i:s");
            $this->excel_model->writeToExcel($arr, lang('profile_report') . " ($date)");
        } else if ($this->session->userdata('inf_profile_type') == "two_count") {
            $count_from = $this->session->userdata('inf_count_from');
            $count_to = $this->session->userdata('inf_count_to');
            $date = date("Y-m-d H:i:s");
            $arr = $this->excel_model->getProfilesFrom($count_from, $count_to);
            $this->excel_model->writeToExcel($arr, lang('profile_report') . " ($date)");
        }
    }

    function create_excel_joining_report_daily() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata('inf_total_joining_daily'))) {
            $report_date = $this->session->userdata('inf_total_joining_daily');
            $excel_array = $this->excel_model->getJoiningReportDaily($report_date);
            $this->excel_model->writeToExcel($excel_array, lang('user_joining_report') . " ($date)");
        }
    }

    function create_excel_joining_report_weekly() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata('inf_week_date1')) && !empty($this->session->userdata('inf_week_date2'))) {
            $from_date = $this->session->userdata('inf_week_date1');
            $to_date = $this->session->userdata('inf_week_date2');
            $excel_array = $this->excel_model->getJoiningReportWeekly($from_date, $to_date);
            $this->excel_model->writeToExcel($excel_array, lang('user_joining_report') . " ($date)");
        }
    }

    function create_excel_total_payout_report() {
        $date = date("Y-m-d H:i:s");
        $excel_array = $this->excel_model->getTotalPayoutReport();
        $this->excel_model->writeToExcel($excel_array, lang('total_bonus_report') . " ($date)");
    }

    function create_excel_weekly_payout_report() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata("inf_week_date1"))) {
            $from_date = $this->session->userdata("inf_week_date1");
            $to_date = $this->session->userdata("inf_week_date2");
            $excel_array = $this->excel_model->getTotalPayoutReport($from_date, $to_date);
            $this->excel_model->writeToExcel($excel_array, lang('week_wise_bonus_report') . " ($date)");
        }
    }

    function create_excel_rank_achievers_report() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata("inf_rank_week_date1"))) {
            $from_date = $this->session->userdata("inf_rank_week_date1");
            $to_date = $this->session->userdata("inf_rank_week_date2");
            $ranks = $this->session->userdata("inf_ranks");
            $excel_array = $this->excel_model->getRankAchieversReport($from_date, $to_date, $ranks);
            $this->excel_model->writeToExcel($excel_array, lang('rank_achievers_report') . " ($date)");
        }
    }

    function create_excel_commission_report($user_name = '') {
        $user_id = $this->validation_model->userNameToID($user_name);
        if ($user_name && !$user_id) {
            $msg = lang('invalid_username');
            $this->redirect($msg, 'select_report/commission_report', FALSE);
        }
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata("inf_commision_type"))) {
            $from_date = $this->session->userdata("inf_commision_week_date1");
            $to_date = $this->session->userdata("inf_commision_week_date2");
            $type = $this->session->userdata("inf_commision_type");
            $excel_array = $this->excel_model->getCommissionReport($from_date, $to_date, $type, $user_id);
            $this->excel_model->writeToExcel($excel_array, lang('commission_report') . " ($date)");
        }
    }

    function create_excel_epin_report() {
        $date = date("Y-m-d H:i:s");
        $excel_array = $this->excel_model->getEpinReport();
        $this->excel_model->writeToExcel($excel_array, lang('epin_report') . " ($date)");
    }

    function create_excel_top_earners_report() {
        $date = date("Y-m-d H:i:s");
        $excel_array = $this->excel_model->getTopEarnersReport();
        $this->excel_model->writeToExcel($excel_array, lang('top_earners_report') . " ($date)");
    }

    function create_excel_profile_view_report() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata("inf_profile_report_view_user_name"))) {
            $user_name = $this->session->userdata("inf_profile_report_view_user_name");
            $excel_array = $this->excel_model->getProfileViewReport($user_name);
            $this->excel_model->writeToExcel($excel_array, lang('profile_report') . " ($date)");
    }
    }

    function create_excel_sales_report($product_type="") {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata('inf_week_date1')) && !empty($this->session->userdata('inf_week_date2'))) {
            $from_date = $this->session->userdata('inf_week_date1');
            $to_date = $this->session->userdata('inf_week_date2');
            $excel_array = $this->excel_model->getSalesReport($from_date, $to_date,$product_type);
            $this->excel_model->writeToExcel($excel_array, lang('sales_report') . " ($date)");
        }
    }

    function create_excel_product_sales_report($product_type="") {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata("inf_product_sales_id"))) {
            $prod_id = $this->session->userdata("inf_product_sales_id");
            $excel_array = $this->excel_model->productSalesReport($prod_id,$product_type);
            $this->excel_model->writeToExcel($excel_array, lang('tran_product_wise_sales_report') . " ($date)");
        }
    }

    function create_excel_member_wise_payout_report() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata("inf_user_name_payout"))) {
            $user_name = $this->session->userdata("inf_user_name_payout");
            $excel_array = $this->excel_model->getMemberPayoutReport($user_name);
            $this->excel_model->writeToExcel($excel_array, lang('member_wise_bonus_report') . " ($date)");
        }
    }

    function create_excel_activate_deactivate_report_view() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata('inf_week_date1')) && !empty($this->session->userdata('inf_week_date2'))) {
            $from_date = $this->session->userdata('inf_week_date1');
            $to_date = $this->session->userdata('inf_week_date2');
            $excel_array = $this->excel_model->getActiveInactiveReport($from_date, $to_date);
            $this->excel_model->writeToExcel($excel_array, lang('user_joining_report') . " ($date)");
        }
    }

    function create_excel_activate_deactivate_report_view_daily() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata('inf_date1'))) {
            $report_date = $this->session->userdata('inf_date1');
            $from_date = $report_date . " 00:00:00";
            $to_date = $report_date . " 23:59:59";
            $excel_array = $this->excel_model->getActiveInactiveReport($from_date, $to_date);
            $this->excel_model->writeToExcel($excel_array, lang('user_joining_report') . " ($date)");
        }
    }

    function create_excel_repurchase_report() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata("inf_date1")) &&!empty($this->session->userdata("inf_date2"))) {

            $user_name = $this->session->userdata("inf_user_name");
            $user_id = $this->report_model->userNameToID($user_name);

            $from_date = $this->session->userdata('inf_date1');
            $to_date = $this->session->userdata('inf_date2');
            $excel_array = $this->excel_model->getRepurchaseReport($from_date, $to_date, $user_id);
            $this->excel_model->writeToExcel($excel_array, lang('repurchase_report') . " ($date)");
        }
    }

    function create_excel_stairstep_report() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata("inf_date1")) &&!empty($this->session->userdata("inf_date2"))) {

            $user_name = $this->session->userdata("inf_user_name");
            $leader_id = $this->report_model->userNameToID($user_name);

            $week_date1 = $this->session->userdata("inf_date1");
            $week_date2 = $this->session->userdata("inf_date2");

            $purcahse_details = $this->excel_model->getStairStepDetails($week_date1, $week_date2, $leader_id);
            $this->excel_model->writeToExcel($purcahse_details, lang('stairstep_report') . " ($date)");
        }
    }

    function create_excel_override_report() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata("inf_date1")) &&!empty($this->session->userdata("inf_date2"))) {

            $user_name = $this->session->userdata("inf_user_name");
            $leader_id = $this->report_model->userNameToID($user_name);

            $week_date1 = $this->session->userdata("inf_date1");
            $week_date2 = $this->session->userdata("inf_date2");

            $purcahse_details = $this->excel_model->getOverRideDetails($week_date1, $week_date2, $leader_id);
            $this->excel_model->writeToExcel($purcahse_details, lang('override_report') . " ($date)");
        }
    }

    function create_excel_payout_released_report_daily() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata('inf_released_report_daily'))) {
            $report_date = $this->session->userdata('inf_released_report_daily');
            $excel_array = $this->excel_model->getReleasedPayoutReport($report_date);
            $this->excel_model->writeToExcel($excel_array, lang('payout_released_report_daily') . " ($date)");
        }
    }
   function create_excel_payout_released_report_weekly() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata('inf_released_report_from_date')) && !empty($this->session->userdata('inf_released_report_to_date'))) {
            $from_date = $this->session->userdata("inf_released_report_from_date");
            $to_date = $this->session->userdata("inf_released_report_to_date");
            $excel_array = $this->excel_model->getReleasedPayoutReport($from_date, $to_date);
            $this->excel_model->writeToExcel($excel_array, lang('payout_released_report_weekly') . " ($date)");
        }
    }

    function create_excel_payout_pending_report() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata('inf_pending_report_from_date')) && !empty($this->session->userdata('inf_pending_report_to_date'))) {
            $from_date = $this->session->userdata("inf_pending_report_from_date");
            $to_date = $this->session->userdata("inf_pending_report_to_date");
            $excel_array = $this->excel_model->getPendingPayoutReport($from_date, $to_date);
            $this->excel_model->writeToExcel($excel_array, lang('payout_pending_report') . " ($date)");
        }
    }

    function create_excel_epin_transfer_report() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata("inf_date1")) &&!empty($this->session->userdata("inf_date2"))) {

            $user_name = $this->session->userdata("inf_user_name");
            $user_id = $this->report_model->userNameToID($user_name);

            $from_date = $this->session->userdata('inf_date1');
            $to_date = $this->session->userdata('inf_date2');
            $excel_array = $this->excel_model->getEpinTransferDetails($from_date, $to_date, $user_id);
            $this->excel_model->writeToExcel($excel_array, lang('epin_transfer_report') . " ($date)");
        }
    }
    //CREATE CSV FILE
    function create_csv_joining_report_weekly(){
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata('inf_week_date1')) && !empty($this->session->userdata('inf_week_date2'))) {

            $from_date = $this->session->userdata('inf_week_date1');
            $to_date = $this->session->userdata('inf_week_date2');

            $csv_array = $this->excel_model->getJoiningReportWeekly($from_date, $to_date);
            $this->create_csv($csv_array, lang('user_joining_report_nw'));
        }

    }

    function create_csv_joining_report_daily(){
         $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata('inf_total_joining_daily'))) {
            $report_date = $this->session->userdata('inf_total_joining_daily');

            $csv_array = $this->excel_model->getJoiningReportDaily($report_date);
            $this->create_csv($csv_array,lang('user_joining_report_nw') );
        }
    }
    function create_csv_total_payout_report() {
        $date = date("Y-m-d");
        $csv_array = $this->excel_model->getTotalPayoutReport();
        $this->create_csv($csv_array,lang('total_bonus_report'));

    }

    function create_csv_weekly_payout_report() {
        $date = date("Y-m-d H:i:s");
        $name = lang('week_wise_bonus_report');
        if (!empty($this->session->userdata("inf_week_date1"))) {
            $from_date = $this->session->userdata("inf_week_date1");
            $to_date = $this->session->userdata("inf_week_date2");
            $csv_array = $this->excel_model->getTotalPayoutReport($from_date, $to_date);
            $this->create_csv($csv_array, $name);
        }
    }

    function create_csv_top_earners_report() {
        $date = date("Y-m-d");
        $csv_array = $this->excel_model->getTopEarnersReport();
        $this->create_csv($csv_array,lang('top_earners_report_nw') );
    }

    function create_csv_member_wise_payout_report() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata("inf_user_name_payout"))) {
            $user_name = $this->session->userdata("inf_user_name_payout");
            $csv_array = $this->excel_model->getMemberPayoutReport($user_name);
            $this->create_csv($csv_array, lang('member_wise_bonus_report') );
        }
    }

    function create_csv_sales_report($product_type="") {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata('inf_week_date1')) && !empty($this->session->userdata('inf_week_date2'))) {
            $from_date = $this->session->userdata('inf_week_date1');
            $to_date = $this->session->userdata('inf_week_date2');
            $csv_array = $this->excel_model->getSalesReport($from_date, $to_date,$product_type);
            $this->create_csv($csv_array, lang('sales_report_nw'));
        }
    }

    function create_csv_product_sales_report($product_type="") {
        $date = date("Y-m-d");
        if (!empty($this->session->userdata("inf_product_sales_id"))) {
            $prod_id = $this->session->userdata("inf_product_sales_id");
            $csv_array = $this->excel_model->productSalesReport($prod_id,$product_type);
            $this->create_csv($csv_array, lang('tran_product_wise_sales_report_nw'));
        }
    }

    function create_csv_rank_achievers_report() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata("inf_rank_week_date1"))) {
            $from_date = $this->session->userdata("inf_rank_week_date1");
            $to_date = $this->session->userdata("inf_rank_week_date2");
            $ranks = $this->session->userdata("inf_ranks");
            $csv_array = $this->excel_model->getRankAchieversReport($from_date, $to_date, $ranks);
            $this->create_csv($csv_array, lang('rank_achievers_report_nw') );
        }
    }

    function create_csv_profile_view_report() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata("inf_profile_report_view_user_name"))) {
            $user_name = $this->session->userdata("inf_profile_report_view_user_name");
            $csv_array = $this->excel_model->getProfileViewReport($user_name);
            $this->create_csv($csv_array,lang('profile_report_nw'));

        }
    }

    function user_profiles_csv() {
        $this->session->userdata('inf_profile_type');
        if ($this->session->userdata('inf_profile_type') == "one_count") {
            $cnt = $this->session->userdata('inf_profile_count');
            $arr = $this->excel_model->getProfiles($cnt);
            $date = date("Y-m-d H:i:s");
            $this->create_csv($arr,lang('profile_report_nw'));

        } else if ($this->session->userdata('inf_profile_type') == "two_count") {
            $count_from = $this->session->userdata('inf_count_from');
            $count_to = $this->session->userdata('inf_count_to');
            $date = date("Y-m-d H:i:s");
            $arr = $this->excel_model->getProfilesFrom($count_from, $count_to);
            $this->create_csv($arr,lang('profile_report_nw'));

        }
    }


    function create_csv_epin_report() {
        $date = date("Y-m-d H:i:s");
        $csv_array = $this->excel_model->getEpinReport();
        $this->create_csv($csv_array,lang('epin_report_nw'));
    }

    function create_csv_commission_report($user_name = '') {
        $user_id = $this->validation_model->userNameToID($user_name);
        if ($user_name && !$user_id) {
            $msg = lang('invalid_username');
            $this->redirect($msg, 'select_report/commission_report', FALSE);
        }
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata("inf_commision_type"))) {
            $from_date = $this->session->userdata("inf_commision_week_date1");
            $to_date = $this->session->userdata("inf_commision_week_date2");
            $type = $this->session->userdata("inf_commision_type");
            $csv_array = $this->excel_model->getCommissionReport($from_date, $to_date, $type, $user_id);
            $this->create_csv($csv_array,lang('commission_report_nw') );

        }
    }

    function create_csv_repurchase_report() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata("inf_date1")) &&!empty($this->session->userdata("inf_date2"))) {

            $user_name = $this->session->userdata("inf_user_name");
            $user_id = $this->report_model->userNameToID($user_name);

            $from_date = $this->session->userdata('inf_date1');
            $to_date = $this->session->userdata('inf_date2');
            $csv_array = $this->excel_model->getRepurchaseReport($from_date, $to_date, $user_id);
            $this->create_csv($csv_array,lang('repurchase_report_nw'));

        }
    }


    function create_csv_payout_released_report_daily() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata('inf_released_report_daily'))) {
            $report_date = $this->session->userdata('inf_released_report_daily');
            $csv_array = $this->excel_model->getReleasedPayoutReport($report_date);
            $this->create_csv($csv_array,lang('payout_released_report_daily_nw'));
        }
    }

    function create_csv_payout_released_report_weekly() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata('inf_released_report_from_date')) && !empty($this->session->userdata('inf_released_report_to_date'))) {
            $from_date = $this->session->userdata("inf_released_report_from_date");
            $to_date = $this->session->userdata("inf_released_report_to_date");
            $csv_array = $this->excel_model->getReleasedPayoutReport($from_date, $to_date);
            $this->create_csv($csv_array,lang('payout_released_report_weekly_nw') );
        }
    }

    function create_csv_payout_pending_report() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata('inf_pending_report_from_date')) && !empty($this->session->userdata('inf_pending_report_to_date'))) {
            $from_date = $this->session->userdata("inf_pending_report_from_date");
            $to_date = $this->session->userdata("inf_pending_report_to_date");
            $csv_array = $this->excel_model->getPendingPayoutReport($from_date, $to_date);
            $this->create_csv($csv_array, lang('payout_pending_report_nw'));
        }
    }

    function create_csv($csv_array,$file_name= '') {

            $header = "Content-Disposition: attachment; filename=$file_name.csv";
            header("Content-type: application/csv");
            header($header);
            header("Pragma: no-cache");
            header("Expires: 0");

            $handle = fopen('php://output', 'w');
            foreach ( $csv_array as $line) {

            fputcsv($handle,$line );
            }
            fclose($handle);
    }

    function create_csv_epin_transfer_report() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata("inf_date1")) &&!empty($this->session->userdata("inf_date2"))) {

            $user_name = $this->session->userdata("inf_user_name");
            $user_id = $this->report_model->userNameToID($user_name);

            $from_date = $this->session->userdata('inf_date1');
            $to_date = $this->session->userdata('inf_date2');
            $csv_array = $this->excel_model->getEpinTransferDetails($from_date, $to_date, $user_id);
            $this->create_csv($csv_array,lang('epin_transfer_report'));
        }
    }

    function create_config_changes_report() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata("from_date")) &&!empty($this->session->userdata("to_date")))     {
            $from_date = $this->session->userdata("from_date");
            $to_date = $this->session->userdata("to_date");

            $excel_array = $this->excel_model->getConfigChangesReport($from_date,$to_date);


            $this->excel_model->writeToExcel($excel_array, lang('config_change_report') . " ($date)");

        }
    }

    function create_csv_config_changes_report() {
        if (!empty($this->session->userdata("from_date")) &&!empty($this->session->userdata("to_date"))) {
            $from_date = $this->session->userdata("from_date");
            $to_date = $this->session->userdata("to_date");
            $csv_array = $this->excel_model->getConfigChangesReport($from_date,$to_date);

            $this->create_csv($csv_array,lang('config_change_report'));
        }
    }

    function create_excel_roi_report() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata("inf_roi_week_date1")) &&!empty($this->session->userdata("inf_roi_week_date2"))) {

            $user_id = $this->session->userdata("inf_user_id");
            $from_date = $this->session->userdata('inf_roi_week_date1');
            $to_date = $this->session->userdata('inf_roi_week_date2');
            $excel_array = $this->excel_model->getroiReport($from_date, $to_date, $user_id);
            $this->excel_model->writeToExcel($excel_array, lang('roi_report') . " ($date)");
        }
    }

    function create_csv_roi_report() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata("inf_roi_week_date1")) &&!empty($this->session->userdata("inf_roi_week_date2"))) {

            $user_id = $this->session->userdata("inf_user_id");
            $from_date = $this->session->userdata('inf_roi_week_date1');
            $to_date = $this->session->userdata('inf_roi_week_date2');
            $csv_array = $this->excel_model->getroiReport($from_date, $to_date, $user_id);
            $this->create_csv($csv_array,lang('roi_report_nw'));

        }
    }
    function personalDtaExport() {
        $date = date("Y-m-d H:i:s");
            $csv_array = $this->excel_model->getPersonalDta($this->LOG_USER_NAME);
            $this->create_csv($csv_array,lang('personal_data_report'));
    }
    function exelPersonalDtaExport() {
        $date = date("Y-m-d H:i:s");
        $excel_array = $this->excel_model->getPersonalDta($this->LOG_USER_NAME);
        $this->excel_model->writeToExcel($excel_array, lang('personal_data_report') . " ($date)");
    }
     function create_excel_reward_report() {
        $date = date("Y-m-d H:i:s");
        $user_id = 0;
        if (isset($this->session->userdata["inf_user_id"])) {
            $user_id = $this->session->userdata["inf_user_id"];
        }
        if (isset($this->session->userdata["inf_commision_week_date1"])) {
            $from_date = $this->session->userdata["inf_commision_week_date1"];
        }
        if (isset($this->session->userdata["inf_commision_week_date2"])) {
            $to_date = $this->session->userdata["inf_commision_week_date2"];
        }
        $excel_array = $this->excel_model->getRankDetails($user_id, $from_date, $to_date); //print_r($excel_array); die;
        $this->excel_model->writeToExcel($excel_array, lang('reward_report') . " ($date)");
    }

    function create_csv_reward_report() {


        $date = date("Y-m-d");

        if (isset($this->session->userdata["inf_user_id"])) {
            $user_id = $this->session->userdata["inf_user_id"];
        }
        if (isset($this->session->userdata["inf_commision_week_date1"])) {
            $from_date = $this->session->userdata["inf_commision_week_date1"];
        }
        if (isset($this->session->userdata["inf_commision_week_date2"])) {
            $to_date = $this->session->userdata["inf_commision_week_date2"];
        }
        $csv_array = $this->excel_model->getRankDetails($user_id, $from_date, $to_date);
        $this->create_csv($csv_array, lang('reward_report'));
    }
    
    function create_excel_monthly_payment_report(){
        
        $date = date("Y-m-d H:i:s");
        $user_id = 0;
        if (isset($this->session->userdata["inf_user_id"])) {
            $user_id = $this->session->userdata["inf_user_id"];
        }
        if (isset($this->session->userdata["inf_commision_week_date1"])) {
            $from_date = $this->session->userdata["inf_commision_week_date1"];
        }
        if (isset($this->session->userdata["inf_commision_week_date2"])) {
            $to_date = $this->session->userdata["inf_commision_week_date2"];
        }
        if(isset($this->session->userdata["inf_subscription_mode"])){
            $type = $this->session->userdata["inf_subscription_mode"];
        }
        $excel_array = $this->excel_model->getPaymentDetails($from_date, $to_date, $user_id, $type); //print_r($excel_array); die;
        $this->excel_model->writeToExcel($excel_array, lang('payment_report') . " ($date)");
    }
    
     function create_csv_monthly_payment_report() {


        $date = date("Y-m-d");

        if (isset($this->session->userdata["inf_user_id"])) {
            $user_id = $this->session->userdata["inf_user_id"];
        }
        if (isset($this->session->userdata["inf_commision_week_date1"])) {
            $from_date = $this->session->userdata["inf_commision_week_date1"];
        }
        if (isset($this->session->userdata["inf_commision_week_date2"])) {
            $to_date = $this->session->userdata["inf_commision_week_date2"];
        }
        if(isset($this->session->userdata["inf_subscription_mode"])){
            $type = $this->session->userdata["inf_subscription_mode"];
        }
        $csv_array = $this->excel_model->getPaymentDetails($from_date, $to_date, $user_id, $type);
        $this->create_csv($csv_array, lang('payment_report'));
    }
    
    function create_excel_summary_report(){
        
        $date = date("Y-m-d");

       $from_date='';
       $to_date='';
        if (isset($this->session->userdata["inf_commision_week_date1"])) {
            $from_date = $this->session->userdata["inf_commision_week_date1"];
        }
        if (isset($this->session->userdata["inf_commision_week_date2"])) {
            $to_date = $this->session->userdata["inf_commision_week_date2"];
        }
        
        $excel_array = $this->excel_model->getBusinessWalletDetails($from_date, $to_date);
        
        $this->excel_model->writeToExcel($excel_array, lang('business_summary') . " ($date)");
    }
    
    function create_csv_summary_report(){
        
       $from_date='';
       $to_date='';
      
        if (isset($this->session->userdata["inf_commision_week_date1"])) {
            $from_date = $this->session->userdata["inf_commision_week_date1"];
        }
        if (isset($this->session->userdata["inf_commision_week_date2"])) {
            $to_date = $this->session->userdata["inf_commision_week_date2"];
        }
      
        $csv_array = $this->excel_model->getBusinessWalletDetails($from_date, $to_date);
       $this->create_csv($csv_array, lang('business_summary'));
    }
    
    function create_excel_earnings_report(){
        $date = date("Y-m-d");
         $user_id='';
         $amount_type='';
         $filter_date='';
        
        if (isset($this->session->userdata["inf_all_trans_date"])) {
            $filter_date = $this->session->userdata["inf_all_trans_date"];
        }
        if (isset($this->session->userdata["amountType"])) {
            $amount_type = $this->session->userdata["amountType"];
        }
        if (isset($this->session->userdata["inf_is_valid_username"])) {
            $user_name = $this->session->userdata["inf_is_valid_username"];
            $user_id = $this->validation_model->userNameToID($user_name);
        }
        
        $excel_array = $this->excel_model->add_income($user_id, '','',$amount_type, $filter_date);
        
        $this->excel_model->writeToExcel($excel_array, lang('earning_report') . " ($date)");
    }
    
     function create_csv_earnings_report(){
        
      
        $user_id='';
         $amount_type='';
         $filter_date='';
        
        if (isset($this->session->userdata["inf_all_trans_date"])) {
            $filter_date = $this->session->userdata["inf_all_trans_date"];
        }
        if (isset($this->session->userdata["amountType"])) {
            $amount_type = $this->session->userdata["amountType"];
        }
        if (isset($this->session->userdata["inf_is_valid_username"])) {
            $user_name = $this->session->userdata["inf_is_valid_username"];
            $user_id = $this->validation_model->userNameToID($user_name);
        }
      
        $csv_array = $this->excel_model->add_income($user_id, '','',$amount_type, $filter_date);
       $this->create_csv($csv_array, lang('earning_report'));
    }
    
    function create_excel_transaction_report(){
        
        $user_id='';
        $filter_debit_credit='';
        $filter_category= '';
        $filter_date='';
        $config['per_page']='';
        $page='';
        $date = date("Y-m-d");
       if (isset($this->session->userdata["inf_business_trans_user"])) {
            $user_id = $this->session->userdata["inf_business_trans_user"];
        } 
        
        if (isset($this->session->userdata["inf_business_trans_debit_credit"])) {
            $filter_debit_credit = $this->session->userdata["inf_business_trans_debit_credit"];
        } 
        if (isset($this->session->userdata["inf_business_trans_category"])) {
            $filter_category = $this->session->userdata["inf_business_trans_category"];
        } 
        
         if (isset($this->session->userdata["inf_business_trans_date"])) {
            $filter_date = $this->session->userdata["inf_business_trans_date"];
        } 
        if(isset($this->session->userdata['inf_pagination'])){
            $config['per_page']=$this->session->userdata["inf_pagination"];
        }
        
       $config = $this->pagination->customize_style();
       
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        // $config['per_page'] = 50;
        $page = $this->uri->segment(4) ?: 0;
         $excel_array = $this->excel_model->getAllTransaction($user_id, $filter_debit_credit, $filter_category, $filter_date) ;
        
        $this->excel_model->writeToExcel($excel_array, lang('transaction_report') . " ($date)");
        
    }
    
    function create_csv_transaction_report(){
        
        $user_id='';
        $filter_debit_credit='';
        $filter_category= '';
        $filter_date='';
        $date = date("Y-m-d");
       if (isset($this->session->userdata["inf_business_trans_user"])) {
            $user_id = $this->session->userdata["inf_business_trans_user"];
        } 
        
        if (isset($this->session->userdata["inf_business_trans_debit_credit"])) {
            $filter_debit_credit = $this->session->userdata["inf_business_trans_debit_credit"];
        } 
        if (isset($this->session->userdata["inf_business_trans_category"])) {
            $filter_category = $this->session->userdata["inf_business_trans_category"];
        } 
        
         if (isset($this->session->userdata["inf_business_trans_date"])) {
            $filter_date = $this->session->userdata["inf_business_trans_date"];
        } 
        
        $csv_array = $this->excel_model->getAllTransaction($user_id, $filter_debit_credit, $filter_category, $filter_date);
       $this->create_csv($csv_array, lang('transaction_report'));
    }
    
   function create_excel_stripe_monhtly_recurring_report($user_name = '') {
        $user_id = $this->validation_model->userNameToID($user_name);
        if ($user_name && !$user_id) {
            $msg = lang('invalid_username');
            $this->redirect($msg, 'select_report/stripe_monhtly_recurring_report', FALSE);
        }
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata("inf_commision_type"))) {
            $from_date = $this->session->userdata("inf_commision_week_date1");
            $to_date = $this->session->userdata("inf_commision_week_date2");
            $type = $this->session->userdata("inf_commision_type");
            $excel_array = $this->excel_model->getStripeMonhtlyRecurringDetails($from_date, $to_date, $type, $user_id);
            $this->excel_model->writeToExcel($excel_array, lang('stripe_monhtly_recurring_report') . " ($date)");
        }
    }
    
    function create_csv_stripe_monhtly_recurring_report($user_name = '') {
        $user_id = $this->validation_model->userNameToID($user_name);
        if ($user_name && !$user_id) {
            $msg = lang('invalid_username');
            $this->redirect($msg, 'select_report/stripe_monhtly_recurring_report', FALSE);
        }
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata("inf_commision_type"))) {
            $from_date = $this->session->userdata("inf_commision_week_date1");
            $to_date = $this->session->userdata("inf_commision_week_date2");
            $type = $this->session->userdata("inf_commision_type");
            $csv_array = $this->excel_model->getStripeMonhtlyRecurringDetails($from_date, $to_date, $type, $user_id);
            $this->create_csv($csv_array,lang('stripe_monhtly_recurring_report_nw') );

        }
    }

}
