<?php

require_once 'Inf_Controller.php';

class Excel extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function create_excel_repurchase_report() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata("inf_date1")) && !empty($this->session->userdata("inf_date2"))) {
            $from_date = $this->session->userdata('inf_date1');
            $to_date = $this->session->userdata('inf_date2');
            $excel_array = $this->excel_model->getRepurchaseReport($from_date, $to_date , $this->LOG_USER_ID);
            $this->excel_model->writeToExcel($excel_array, lang('repurchase_report') . " ($date)");
        }
    }

    function create_excel_epin_transfer_report() {
        $date = date("Y-m-d H:i:s");
        if (!empty($this->session->userdata("inf_date1")) &&!empty($this->session->userdata("inf_date2"))) {

            $user_name = $this->session->userdata("inf_user_name");
            $user_id = $this->report_model->userNameToID($user_name);

            $from_date = $this->session->userdata('inf_date1');
            $to_date = $this->session->userdata('inf_date2');
            $excel_array = $this->excel_model->getEpinTransferDetailsForUser($from_date, $to_date, $user_id);
            $this->excel_model->writeToExcel($excel_array, lang('epin_transfer_report') . " ($date)");
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
        if (!empty($this->session->userdata("inf_date1")) && !empty($this->session->userdata("inf_date2"))) {

            $user_name = $this->session->userdata("inf_user_name");
            $user_id = $this->report_model->userNameToID($user_name);

            $from_date = $this->session->userdata('inf_date1');
            $to_date = $this->session->userdata('inf_date2');
            $csv_array = $this->excel_model->getEpinTransferDetailsForUser($from_date, $to_date, $user_id);
            $this->create_csv($csv_array,lang('epin_transfer_report'));
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

    function create_excel_sales_report($product_type="") {
        $date = date("Y-m-d H:i:s");
        if (isset($this->session->userdata['inf_week_date1']) && isset($this->session->userdata['inf_week_date2'])) {
            $from_date = $this->session->userdata['inf_week_date1'];
            $to_date = $this->session->userdata['inf_week_date2'];
            $excel_array = $this->excel_model->getSalesReport($from_date, $to_date,$product_type);
            $this->excel_model->writeToExcel($excel_array, lang('sales_report') . " ($date)");
        }
    }

    function create_excel_product_sales_report($product_type="") {
        $date = date("Y-m-d H:i:s");
        if (isset($this->session->userdata["inf_product_sales_id"])) {
            $prod_id = $this->session->userdata["inf_product_sales_id"];
            $excel_array = $this->excel_model->productSalesReport($prod_id,$product_type);
            $this->excel_model->writeToExcel($excel_array, lang('tran_product_wise_sales_report') . " ($date)");
        }
    }

    function create_csv_sales_report($product_type="") {
        $date = date("Y-m-d H:i:s");
        if (isset($this->session->userdata['inf_week_date1']) && isset($this->session->userdata['inf_week_date2'])) {
            $from_date = $this->session->userdata['inf_week_date1'];
            $to_date = $this->session->userdata['inf_week_date2'];
            $csv_array = $this->excel_model->getSalesReport($from_date, $to_date,$product_type);
            $this->create_csv($csv_array, lang('sales_report_nw'));
        }
    }
    
    function create_csv_product_sales_report($product_type="") {
        $date = date("Y-m-d");
        if (isset($this->session->userdata["inf_product_sales_id"])) {
            $prod_id = $this->session->userdata["inf_product_sales_id"];
            $csv_array = $this->excel_model->productSalesReport($prod_id,$product_type);
            $this->create_csv($csv_array, lang('tran_product_wise_sales_report_nw'));
        }
    }

    function create_excel_payout_released_report_daily() {
        $date = date("Y-m-d H:i:s");        
        if (isset($this->session->userdata['inf_released_report_daily'])) {
            $report_date = $this->session->userdata['inf_released_report_daily'];            
            $excel_array = $this->excel_model->getReleasedPayoutReport($report_date);
            $this->excel_model->writeToExcel($excel_array, lang('payout_released_report_daily') . " ($date)");
        }
    } 
   function create_excel_payout_released_report_weekly() {
        $date = date("Y-m-d H:i:s");        
        if (isset($this->session->userdata['inf_released_report_from_date']) && isset($this->session->userdata['inf_released_report_to_date'])) {
            $from_date = $this->session->userdata["inf_released_report_from_date"];
            $to_date = $this->session->userdata["inf_released_report_to_date"];            
            $excel_array = $this->excel_model->getReleasedPayoutReport($from_date, $to_date);
            $this->excel_model->writeToExcel($excel_array, lang('payout_released_report_weekly') . " ($date)");
        }
    }
    
    function create_excel_payout_pending_report() {
        $date = date("Y-m-d H:i:s");        
        if (isset($this->session->userdata['inf_pending_report_from_date']) && isset($this->session->userdata['inf_pending_report_to_date'])) {
            $from_date = $this->session->userdata["inf_pending_report_from_date"];
            $to_date = $this->session->userdata["inf_pending_report_to_date"];            
            $excel_array = $this->excel_model->getPendingPayoutReport($from_date, $to_date);
            $this->excel_model->writeToExcel($excel_array, lang('payout_pending_report') . " ($date)");
        }
    }

    function create_csv_payout_released_report_daily() {
        $date = date("Y-m-d H:i:s");        
        if (isset($this->session->userdata['inf_released_report_daily'])) {
            $report_date = $this->session->userdata['inf_released_report_daily'];            
            $csv_array = $this->excel_model->getReleasedPayoutReport($report_date);
            $this->create_csv($csv_array,lang('payout_released_report_daily_nw'));
        }
    }
    
    function create_csv_payout_released_report_weekly() {
        $date = date("Y-m-d H:i:s");        
        if (isset($this->session->userdata['inf_released_report_from_date']) && isset($this->session->userdata['inf_released_report_to_date'])) {
            $from_date = $this->session->userdata["inf_released_report_from_date"];
            $to_date = $this->session->userdata["inf_released_report_to_date"];            
            $csv_array = $this->excel_model->getReleasedPayoutReport($from_date, $to_date);
            $this->create_csv($csv_array,lang('payout_released_report_weekly_nw') );
        }
    }
    
    function create_csv_payout_pending_report() {
        $date = date("Y-m-d H:i:s");        
        if (isset($this->session->userdata['inf_pending_report_from_date']) && isset($this->session->userdata['inf_pending_report_to_date'])) {
            $from_date = $this->session->userdata["inf_pending_report_from_date"];
            $to_date = $this->session->userdata["inf_pending_report_to_date"];            
            $csv_array = $this->excel_model->getPendingPayoutReport($from_date, $to_date);
            $this->create_csv($csv_array, lang('payout_pending_report_nw'));
        }
    }

    function create_excel_commission_report($user_name = '') {
        $user_id = $this->validation_model->userNameToID($user_name);
        if ($user_name && !$user_id) {
            $msg = lang('invalid_username');
            $this->redirect($msg, 'select_report/commission_report', FALSE);
        }
        $date = date("Y-m-d H:i:s");
        if (isset($this->session->userdata["inf_commision_type"])) {
            $from_date = $this->session->userdata["inf_commision_week_date1"];
            $to_date = $this->session->userdata["inf_commision_week_date2"];
            $type = $this->session->userdata["inf_commision_type"];
            $excel_array = $this->excel_model->getCommissionReport($from_date, $to_date, $type, $user_id);
            $this->excel_model->writeToExcel($excel_array, lang('commission_report') . " ($date)");
        }
    }

    function create_csv_commission_report($user_name = '') {
        $user_id = $this->validation_model->userNameToID($user_name);
        if ($user_name && !$user_id) {
            $msg = lang('invalid_username');
            $this->redirect($msg, 'select_report/commission_report', FALSE);
        }
        $date = date("Y-m-d H:i:s");
        if (isset($this->session->userdata["inf_commision_type"])) {
            $from_date = $this->session->userdata["inf_commision_week_date1"];
            $to_date = $this->session->userdata["inf_commision_week_date2"];
            $type = $this->session->userdata["inf_commision_type"];
            $csv_array = $this->excel_model->getCommissionReport($from_date, $to_date, $type, $user_id);
            $this->create_csv($csv_array,lang('commission_report_nw') );
            
        }
    }
    
    function create_excel_reward_report($user_name = '') {
        $date = date("Y-m-d H:i:s");
        $user_id = $this->validation_model->userNameToID($user_name);

        if (isset($this->session->userdata["inf_commision_week_date1"])) {
            $from_date = $this->session->userdata["inf_commision_week_date1"];
        }
        if (isset($this->session->userdata["inf_commision_week_date2"])) {
            $to_date = $this->session->userdata["inf_commision_week_date2"];
        }
        $excel_array = $this->excel_model->getRankDetails($user_id, $from_date, $to_date); //print_r($excel_array); die;
        $this->excel_model->writeToExcel($excel_array, lang('reward_report') . " ($date)");
    }

    function create_csv_reward_report($user_name = '') {

        $user_id = $this->validation_model->userNameToID($user_name);
        if (isset($this->session->userdata["inf_commision_week_date1"])) {
            $from_date = $this->session->userdata["inf_commision_week_date1"];
        }
        if (isset($this->session->userdata["inf_commision_week_date2"])) {
            $to_date = $this->session->userdata["inf_commision_week_date2"];
        }
        $csv_array = $this->excel_model->getRankDetails($user_id, $from_date, $to_date);
        $this->create_csv($csv_array, lang('reward_report'));
    }

}
