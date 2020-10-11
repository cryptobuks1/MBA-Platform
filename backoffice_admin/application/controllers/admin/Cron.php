<?php

require_once 'Inf_Controller.php';

class cron extends Inf_Controller {

    function __construct() {
        parent::__construct();
        $this->cron_model = new cron_model();
    }

    function generate_backup() {
        $cron_id = $this->cron_model->insertCronHistory('backup');
        $status = $this->cron_model->backupDatabase();
        if (1) {
            $this->cron_model->updateCronHistory($cron_id, "finished");
        } else {
            $this->cron_model->updateCronHistory($cron_id, "failed");
        }
    }

    public function autoresponder_mail() {//sending mail to pending and following LCP users depend on date
        $cron_id = $this->cron_model->insertIntoCronHistory('autoresponder_mail');
        if ($this->MODULE_STATUS['autoresponder_status'] == "yes" && DEMO_STATUS == "no") {
            $autorespond = $this->cron_model->sentAutoresponderMail();
        } else if (DEMO_STATUS == "yes") { 
            $all_table_prifix = $this->cron_model->getAllTablePrifix();
            for ($i = 0; $i <= count($all_table_prifix); $i++) {
                $this->session->set_userdata('inf_table_prefix', $all_table_prifix[$i]);
                $autorespond = $this->cron_model->sentAutoresponderMail();
            }
        } else {
            echo "error";
            die();
        }
        if ($autorespond) {
            $this->cron_model->updateCronHistory('success', $cron_id);
            echo "mails are Successfully Delivered";
        } else {

            $this->cron_model->updateCronHistory('failed', $cron_id);
            echo "Unable To Send Mail";
        }
    }

    function auto_cache_clear() {

        $cron_id = $this->cron_model->insertCronHistory('clear_cache');
        $status = $this->cron_model->clearCache();

        if ($status) {
            $this->cron_model->updateCronHistory($cron_id, "finished");
        } else {
            $this->cron_model->updateCronHistory($cron_id, "failed");
        }
    }

    function daily_investment() {

        $flag = TRUE;
        $date = $date1 = date('Y-m-d');
        $date = strtotime($date);

        $roi_configuration = $this->validation_model->getConfig(['roi_period,roi_days_skip']);
        $roi_period = $roi_configuration['roi_period'];
        $roi_days = explode(',', $roi_configuration['roi_days_skip']);

        if ($roi_period == "yearly") {
            $from_date = date('Y-m-d', strtotime('this year January 1st')) . " 00:00:00";
            $to_date = date('Y-m-d', strtotime('this year December 31st')) . " 23:59:59";
        }
        elseif ($roi_period == "monthly") {
            $from_date = date('Y-m-d', strtotime('first day of this month')) . " 00:00:00";
            $to_date = date('Y-m-d', strtotime('last day of this month')) . " 23:59:59";
           
        } elseif ($roi_period == "weekly") {
            $week_arr = $this->getWeekDateRange('sunday');
            $from_date = $week_arr["start"] . " 00:00:00";
            $to_date = $week_arr["end"] . " 23:59:59";
        } elseif ($roi_period == "daily") {
            $from_date = date("Y-m-d") . " 00:00:00";
            $to_date = date("Y-m-d") . " 23:59:59";
            if (in_array(date("D", $date),$roi_days)) {
                $flag = FALSE;
            }
        }

        $result = $this->cron_model->isCronCalculated($from_date, $to_date, $roi_period, 'daily_investment');

        if ($result && $flag) {
            $cron_id = $this->cron_model->insertCronHistory('daily_investment');
            $status = $this->cron_model->calculateDailyInvestment();
            if ($status) {
                $this->cron_model->updateCronHistory($cron_id, "finished");
            } else {
                $this->cron_model->updateCronHistory($cron_id, "failed");
            }
        }
        $msg = lang("Cron executed successfully");
        $this->redirect($msg, 'configuration/cron_status', TRUE);
    }

    public function getWeekDateRange($start_day)
    {
        $start = strtotime("last $start_day");
        $start = date('w', $start) == date('w') ? $start + 7 * 86400 : $start;

        $end = strtotime(date("Y-m-d", $start) . " +6 days");

        $this_week_sd = date("Y-m-d", $start);
        $this_week_ed = date("Y-m-d", $end);

        return [
            'start' => $this_week_sd,
            'end' => $this_week_ed
        ];
    }

    function pool_bonus() {
        $date = date('Y-m-d H:i:s');
        $cron_id = $this->cron_model->insertCronHistory('pool_bonus');
        $status = $this->cron_model->calculatePoolBonus();
        if ($status) {
            $this->cron_model->updateCronHistory($cron_id, "finished");
            echo "finished";
        } else {
            $this->cron_model->updateCronHistory($cron_id, "failed");
            echo "failed";
        }
    }

    function auto_ship() {
        if ($this->MODULE_STATUS['auto_ship_status'] == "yes") {
            $cron_id = $this->cron_model->insertCronHistory('auto_ship');
            $status = $this->cron_model->autoShipReactivation();
            if ($status) {
                $this->cron_model->updateCronHistory($cron_id, "finished");
                echo "finished";
            } else {
                $this->cron_model->updateCronHistory($cron_id, "failed");
                echo "failed";
            }
        } else {
            echo "Autoship module is disabled";
        }
    }

    function binary_commission() {

        $result = FALSE;
        $binary_config = $this->configuration_model->getBinaryBonusConfig();
        $calculation_period = $binary_config['calculation_period'];

        if ($calculation_period == "yearly") {
            $from_date = date('Y-m-d', strtotime('this year January 1st')) . " 00:00:00";
            $to_date = date('Y-m-d', strtotime('this year December 31st')) . " 23:59:59";
        }
        elseif ($calculation_period == "monthly") {
            $from_date = date('Y-m-d', strtotime('first day of this month')) . " 00:00:00";
            $to_date = date('Y-m-d', strtotime('last day of this month')) . " 23:59:59";
        } elseif ($calculation_period == "weekly") {
            $week_arr = $this->getWeekDateRange('sunday');
            $from_date = $week_arr["start"] . " 00:00:00";
            $to_date = $week_arr["end"] . " 23:59:59";
        } elseif ($calculation_period == "daily") {
            $from_date = date("Y-m-d") . " 00:00:00";
            $to_date = date("Y-m-d") . " 23:59:59";
        }

        if($calculation_period != "instant") { 
            $result = $this->cron_model->isCronCalculated($from_date, $to_date, $calculation_period, 'binary_commission');
        }

        if($result) { 
            $cron_id = $this->cron_model->insertCronHistory('binary_commission');
            $status =  $this->cron_model->calculateBinaryCommission();
            if ($status) {
                $this->cron_model->updateCronHistory($cron_id, "finished");
                echo "finished";
            } else {
                $this->cron_model->updateCronHistory($cron_id, "failed");
                echo "failed";
            }

        } else {
            echo "Cron Can't set";
        }
    }
    function rank_expiry() {

        $result = FALSE;
        $rank_configuration = $this->configuration_model->getRankConfiguration();
            $rank_period = $rank_configuration['rank_expiry'];

        if ($rank_period == "yearly") {
            $from_date = date('Y-m-d', strtotime('this year January 1st')) . " 00:00:00";
            $to_date = date('Y-m-d', strtotime('this year December 31st')) . " 23:59:59";
        }
        elseif ($rank_period == "monthly") {
            $from_date = date('Y-m-d', strtotime('first day of this month')) . " 00:00:00";
            $to_date = date('Y-m-d', strtotime('last day of this month')) . " 23:59:59";
        } elseif ($rank_period == "weekly") {
            $week_arr = $this->getWeekDateRange('sunday');
            $from_date = $week_arr["start"] . " 00:00:00";
            $to_date = $week_arr["end"] . " 23:59:59";
        } elseif ($rank_period == "daily") {
            $from_date = date("Y-m-d") . " 00:00:00";
            $to_date = date("Y-m-d") . " 23:59:59";
        }

        if($rank_period != "instant") { 
            $result = $this->cron_model->isCronCalculated($from_date, $to_date, $rank_period, 'rank_bonus_expiry');
        }

        if($result) { 
            $cron_id = $this->cron_model->insertCronHistory('rank_bonus_expiry');
            $status = $this->cron_model->calculateRank();
            if ($status) {
                $this->cron_model->updateCronHistory($cron_id, "finished");
                echo "finished";
            } else {
                $this->cron_model->updateCronHistory($cron_id, "failed");
                echo "failed";
            }

        } else {
            echo "Cron Can't set";
        }
    }
    
        /**
     * Rank calculation by akhil
     */
        public function calculate_user_rank() {
        $monthly_status = $this->cron_model->getRankCalcStatus();
        if ($monthly_status) {
            $change_status = $this->cron_model->changeRankCalcStatus('no');
            if ($change_status) {
                $cron_id = $this->cron_model->insertCronHistory('calculate_user_rank');
                $users_list = $this->cron_model->getRankUsersList($limit = 500);
                while ($users_list) {
                    foreach ($users_list as $user) {
                        $result1 = $result = true;
                        $this->cron_model->begin();
                        if($user['child_count'] > 1){
                             $result = $this->cron_model->calculateUserRank($user);
                        }
                        if ($result) {
                            $result1 = $this->cron_model->setRankCalcStatus($user['id'], 'yes');
                        }
                        if ($result && $result1) {
                            $this->cron_model->commit();
                        } else {
                            $this->cron_model->rollBack();
                        }
                    }
                    $users_list = $this->cron_model->getRankUsersList($limit = 500);
                }
                echo "success";
                $this->cron_model->updateCronHistory($cron_id, 'success');
            }
        }
        return true;
    }

    /**
     * Rank calculation by akhil ends
     */
     
     
       //binary_commission
     function binary_commission_monthly() {

            $date = date('Y-m');
            $day_checking = $this->cron_model->CronStatusCheck($date, 'binary_commission_matching');
            if ($day_checking) {
                echo "already run cron in this month";
                die;
            }


            $cron_id = $this->cron_model->insertCronHistory('binary_commission_matching');
            $this->cron_model->begin();
            $status = $this->cron_model->runBinaryCommissionMatchingCron();
            if ($status) {

             //   echo "Matching Success.</br>";
                $this->cron_model->updateCronHistory($cron_id, "finished");
                $this->cron_model->changeStatusAll();
                $final = $this->runBinaryCommissionAllocate();
                if ($final) {
                    echo "finally success.</br>";
                    $this->cron_model->commit();
                } else {
                    $this->cron_model->rollback();
                }
            } else {
             //   echo "failed";
                $this->cron_model->rollback();
                $this->cron_model->updateCronHistory($cron_id, "failed");
            }
            return true;
       
    }

    public function runBinaryCommissionAllocate() {
        $cron_id = $this->cron_model->insertCronHistory('binary_commission_allocate');
        $status = $this->cron_model->runBinaryCommissionAllocateCron();
        if ($status) {
           // echo "Daily Commission Success.</br>";
            $this->cron_model->updateCronHistory($cron_id, "finished");
            return TRUE;
        } else {
            echo "Failed";
            return FALSE;
        }
    }
    
        /**
     * Global bonus calculation by akhil
     */
    public function calculate_global_bonus() {
        $monthly_status = $this->cron_model->getGlobalBonusCalcStatus();
        $obj_arr = $this->configuration_model->getCompensationSettings();
        $bonus_status=$obj_arr['global_bonus'];
         if (($monthly_status)&&($bonus_status=='yes')){
            $cron_id = $this->cron_model->insertCronHistory('calculate_global_bonus');
            $start_date = date('Y-m-d', strtotime('first day of last month')) . " 00:00:00";
            $end_date = date('Y-m-d', strtotime('last day of last month')) . " 23:59:59";
            $total_bv = $this->cron_model->getMonthlyTotalBv($start_date, $end_date);
            $global_config = $this->cron_model->getGlobalBonusConfig();
            $global_bv = ($total_bv * $global_config['bonus_perc']) / 100;
            if ($global_bv > 0) {
                $users_list = $this->cron_model->getGlobalBonusUsersList($start_date, $end_date, $global_config['pool_spon_user']);
                if (!empty($users_list)) {
                    $total_share = array_sum(array_column($users_list, 'share'));
                    if ($total_share > 0) {
                        $one_share = $global_bv / $total_share;
                        foreach ($users_list as $user) {
                            $this->cron_model->begin();
                            $result = $this->calculation_model->calculateGlobalBonus($user, $global_bv, $total_share, $one_share,$global_config['pool_spon_user'],$global_config['bonus_perc']);
                            if ($result) {
                                $this->cron_model->commit();
                            } else {
                                $this->cron_model->rollBack();
                            }
                        }
                    }
                }
            }
            echo "success";
            $this->cron_model->updateCronHistory($cron_id, 'success');
        }
        
    }

    /**
     * Global bonus calculation by akhil ends
     */
     
     /**
     * Car bonus calculation by akhil
     */
    public function calculate_car_bonus() {
        $monthly_status = $this->cron_model->getCarBonusStatus();
        $obj_arr = $this->configuration_model->getCompensationSettings();
        $bonus_status=$obj_arr['car_bonus'];
        if (($monthly_status)&&($bonus_status=='yes')){
            $change_status = $this->cron_model->changeCarBonusCalcStatus('no');
            $start_date = date('Y-m-d', strtotime('first day of last month')) . " 00:00:00";
            $end_date = date('Y-m-d', strtotime('last day of last month')) . " 23:59:59";
            $car_config = $this->cron_model->getCarBonusConfig();
            if ($change_status) {
                $cron_id = $this->cron_model->insertCronHistory('calculate_car_bonus');
                if ($car_config['amount'] > 0) {
                    $users_list = $this->cron_model->getCarBonusUsersList($limit = 500);
                    while ($users_list) {
                        foreach ($users_list as $user) {
                            $result1 = true;
                            $this->cron_model->begin();
                            $result = $this->cron_model->calculateCarBonus($user, $car_config, $start_date, $end_date);
                            if ($result) {
                                $result1 = $this->cron_model->setCarBonusCalcStatus($user['id'], 'yes');
                            }
                            if ($result && $result1) {
                                $this->cron_model->commit();
                            } else {
                                $this->cron_model->rollBack();
                            }
                        }
                        $users_list = $this->cron_model->getCarBonusUsersList($limit = 500);
                    }
                }
                echo "success";
                $this->cron_model->updateCronHistory($cron_id, 'success');
            }
        }
    }

    /**
     * Car bonus calculation by akhil ends
     */
    // stripe recuring subsctription  by neenu
    function reccuring_purchse() {
        $cron_id = $this->cron_model->insertCronHistory('reccuring');
        $status = $this->cron_model->reccuring_purchse();
        if ($status) {
            $this->cron_model->updateCronHistory($cron_id, "finished");
            echo "finished";
        } else {
            $this->cron_model->updateCronHistory($cron_id, "failed");
            echo "failed";
        }
    }
    // stripe recuring subsctription  by neenu ends
    
    function run_cron($type = ''){
        if($type == 'rank'){
        $res = $this->calculate_user_rank();
        if($res){
            $msg = 'Calculation completed';
            $this->redirect($msg, 'configuration/cron_button', TRUE);
        }
        }
        elseif($type == 'binary_bonus'){
        $res = $this->binary_commission_monthly();
        if($res){
            $msg = 'Calculation completed';
            $this->redirect($msg, 'configuration/cron_button', TRUE);
        }
        }
        elseif($type == 'global_bonus'){
        $start_date = date('Y-m-01')." 00:00:00";
        $end_date = date('Y-m-t')." 23:59:59";
        $res = $this->calculate_global_bonus_copy($start_date,$end_date);
        if($res){
            $msg = 'Calculation completed';
            $this->redirect($msg, 'configuration/cron_button', TRUE);
        }
        }
        elseif($type == 'car_bonus'){
        $start_date = date('Y-m-01')." 00:00:00";
        $end_date = date('Y-m-t')." 23:59:59";
        $res = $this->calculate_car_bonus_copy($start_date,$end_date);
        if($res){
            $msg = 'Calculation completed';
            $this->redirect($msg, 'configuration/cron_button', TRUE);
        }
        }
    }
    
    public function calculate_global_bonus_copy($start_date,$end_date) {
        $monthly_status = $this->cron_model->getGlobalBonusCalcStatus();
        $obj_arr = $this->configuration_model->getCompensationSettings();
        $bonus_status=$obj_arr['global_bonus'];
        if ((true)&&($bonus_status=='yes')){
            $cron_id = $this->cron_model->insertCronHistory('calculate_global_bonus');
            $total_bv = $this->cron_model->getMonthlyTotalBv($start_date, $end_date);
            $global_config = $this->cron_model->getGlobalBonusConfig();
            $global_bv = ($total_bv * $global_config['bonus_perc']) / 100;
            if ($global_bv > 0) {
                $users_list = $this->cron_model->getGlobalBonusUsersList($start_date, $end_date, $global_config['pool_spon_user']);
                if (!empty($users_list)) {
                    $total_share = array_sum(array_column($users_list, 'share'));
                    if ($total_share > 0) {
                        $one_share = $global_bv / $total_share;
                        foreach ($users_list as $user) {
                            $this->cron_model->begin();
                            $result = $this->calculation_model->calculateGlobalBonus($user, $global_bv, $total_share, $one_share,$global_config['pool_spon_user'],$global_config['bonus_perc']);
                            if ($result) {
                                $this->cron_model->commit();
                            } else {
                                $this->cron_model->rollBack();
                            }
                        }
                    }
                }
            }
            $this->cron_model->updateCronHistory($cron_id, 'success');
           
        }
         
        
        return true;
    }
    
    public function calculate_car_bonus_copy($start_date,$end_date) {
        $monthly_status = $this->cron_model->getCarBonusStatus();
        if (true) {
            $change_status = $this->cron_model->changeCarBonusCalcStatus('no');
            $car_config = $this->cron_model->getCarBonusConfig();
            if ($change_status) {
                $cron_id = $this->cron_model->insertCronHistory('calculate_car_bonus');
                if ($car_config['amount'] > 0) {
                    $users_list = $this->cron_model->getCarBonusUsersList($limit = 500);
                    while ($users_list) {
                        foreach ($users_list as $user) {
                            $result1 = true;
                            $this->cron_model->begin();
                            $result = $this->cron_model->calculateCarBonus($user, $car_config, $start_date, $end_date);
                            if ($result) {
                                $result1 = $this->cron_model->setCarBonusCalcStatus($user['id'], 'yes');
                            }
                            if ($result && $result1) {
                                $this->cron_model->commit();
                            } else {
                                $this->cron_model->rollBack();
                            }
                        }
                        $users_list = $this->cron_model->getCarBonusUsersList($limit = 500);
                    }
                }
                //echo "success";
                $this->cron_model->updateCronHistory($cron_id, 'success');
            }
        }
        return true;
    }
    
    public function calc_fast(){ die;
        $this->cron_model->calculateFastStartBonus();
        echo "success";
    }
    
    
    public function test123(){
        die;
      $position =  $this->validation_model->getRightSponsorStatus(23320); 
      //$this->cron_model->getUnilevelUplineForBinary(23326,23320);
       print_r($position);die;
    }
    
     public function testing_curl(){
        //echo phpinfo();die;
        ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://mbatradingacademy.com/office/backoffice_admin/admin/cron/test_cron');
        $store = curl_exec($ch);print_r($store);die;
        curl_close($ch);
    }
    public function test_cron(){
        //echo phpinfo();die;
        
        $cron_id = $this->cron_model->insertCronHistory('test_cron');
    }
    
    public function test_mail(){
$msg = "First line of text\nSecond line of text";
//echo phpinfo();
echo mail("neenua41@gmail.com","My subject",$msg);
    }
    public function testing_stripe(){
        $this->cron_model->test_stripe();
    }
public function test(){
        $amount=149;
        $product_pv=round($amount/2);
        echo $product_pv;die;
    }
    
    public function test_spon(){ die;
        $this->cron_model->updateSponStatus();
    }
     public function update_oc_time(){
        $this->cron_model->changeOcTime();
    }
}
