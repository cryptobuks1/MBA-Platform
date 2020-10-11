<?php

require_once 'Inf_Controller.php';

class Home extends Inf_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('ewallet_model');
        $this->load->model('rank_model');

    }

    function index()
    {
        $title = $this->lang->line('dashboard');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "dashboard";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('dashboard');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('dashboard');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;
        $session_data = $this->session->userdata('inf_logged_in');
        $table_prefix = $session_data['table_prefix'];
        $prefix = str_replace('_', '', $table_prefix);
        $site_url = SITE_URL;

        //returnofinvestment
        if ($this->MODULE_STATUS['roi_status'] == 'yes' || ($this->MODULE_STATUS['mlm_plan'] == 'Unilevel' && $this->MODULE_STATUS['hyip_status'] == 'yes')) {
            $roi_details = array();
            $roi_details = $this->home_model->getHyipTotalLegamount($user_id);
            $this->set("roi_details", $roi_details);
        }
        if ($this->MODULE_STATUS['mlm_plan'] == 'Unilevel' && $this->MODULE_STATUS['hyip_status'] == 'yes') {
            $total_active_deposit = $this->home_model->getActiveDeposit($user_id);
            $total_matured_deposit = $roi_details - $total_active_deposit;
            $this->set("total_active_deposit", $total_active_deposit);
            $this->set("total_matured_deposit", $total_matured_deposit);
        }

        //joining
        $total_payout = $this->home_model->getPayoutDetails('', '', $user_id);
        $total_payout = $this->DEFAULT_CURRENCY_VALUE * $total_payout;
        $total_payout = $this->niceNumberCommission($total_payout);
        $total_payout = $this->DEFAULT_SYMBOL_LEFT . $total_payout . $this->DEFAULT_SYMBOL_RIGHT;
        $todays_payout = $this->home_model->getPayoutDetails(date('Y-m-d') . " 00:00:00", date('Y-m-d') . " 23:59:59", $user_id);

        $placement_joinig = $this->home_model->placementJoiningUsers($user_id);
        $todays_placement_joining = $this->home_model->todaysPlacementJoiningCount($user_id);
        //ewallet
        $ewallet_status = $this->MODULE_STATUS['ewallet_status'];

        $total_amount = 0;
        $requested_amount = 0;
        $total_request = 0;
        $total_released = 0;
        $commission = 0;
        $donation = 0;
        $given_donation = 0;
        $recieved_commission = 0;
        $donation_type = '';
        if ($ewallet_status == 'yes') {
            //$total_amount = $this->home_model->getGrandTotalEwallet($user_id);
            $total_amount = $this->home_model->getTotalAmountPayable($user_id);//echo $total_amount; die;
            $total_amount = $this->DEFAULT_CURRENCY_VALUE * $total_amount;
            $total_amount = $this->niceNumberCommission($total_amount);
            $total_amount = $this->DEFAULT_SYMBOL_LEFT . $total_amount . $this->DEFAULT_SYMBOL_RIGHT;
            $requested_amount = $this->home_model->getTotalRequestAmount($user_id);
            $requested_amount = $this->DEFAULT_CURRENCY_VALUE * $requested_amount;
            $requested_amount = $this->niceNumberCommission($requested_amount);
            $requested_amount = $this->DEFAULT_SYMBOL_LEFT . $requested_amount . $this->DEFAULT_SYMBOL_RIGHT;
            $total_request = $this->home_model->getGrandTotalEwallet($user_id);
            $total_released = $this->home_model->getTotalReleasedAmount($user_id);
            if ($this->MODULE_STATUS['mlm_plan'] == 'Donation') {
                $commission = $this->home_model->getTotalCommission($user_id);
                $commission = $this->DEFAULT_CURRENCY_VALUE * $commission;
                $commission = $this->niceNumberCommission($commission);
                $donation_type = $this->validation_model->getColoumnFromTable("configuration", "donation_type");

                $donation = $this->home_model->getTotalDonation($user_id);
                $donation = $this->DEFAULT_CURRENCY_VALUE * $donation;
                $recieved_commission = $donation;
                $donation = $this->niceNumber($donation);
                $this->load->model('donation_model');
                $given_commission = $this->donation_model->givenDonation($user_id);
                $given_commission *= $this->DEFAULT_CURRENCY_VALUE;
                $donation_level = $this->donation_model->getLevelName($this->donation_model->getCurrentLevel($user_id));
            }
        }

        //for sales
        $total_sales = $this->home_model->getSalesCount('', '', $user_id);
        $total_sales = $this->niceNumber($total_sales);
        $today_sales = $this->home_model->getSalesCount(date('Y-m-d') . " 00:00:00", date('Y-m-d') . " 23:59:59", $user_id);
        $today_sales = $this->niceNumber($today_sales);

        //mail
        $read_mail = $this->home_model->getTotaMailCount('user', '', '', $read_status = '', 'all');
        $read_mail = $this->niceNumber($read_mail);
        $mail_today = $this->home_model->getAllTodayMessages('user');
        $mail_today = $this->niceNumber($mail_today);

        $package_validity_date = $this->validation_model->getUserProductValidity($user_id);
        $product_id = $this->validation_model->getProductId($user_id);
        if ($product_id === 0) {
            $this->validation_model->hideReactivationMenu();
        }
        $show_package_validity_date = "no";
        $today = date("Y-m-d H:i:s");
        $last_month = $package_validity_date;
        if ($product_id != 0 && $today < $last_month && $this->MODULE_STATUS['product_validity'] == 'yes' && $this->MODULE_STATUS['product_status'] == 'yes') {
            $show_package_validity_date = "yes";
        }
        $package_validity_date = date("F j, Y, g:i a", strtotime($package_validity_date));
        $this->set("show_package_validity_date", $show_package_validity_date);
        $this->set("package_validity_date", $package_validity_date);
        $this->set("product_id", $product_id);

        //Social Media
        $social_media_info = $this->home_model->getSocialMediaInfo();
        //top 5 recruters
        $top_recruters = $this->home_model->getTopRecruters(6, $this->LOG_USER_ID);
        $j = 0;
        foreach ($top_recruters as $v) {
            if (file_exists(IMG_DIR . "profile_picture/" . $top_recruters[$j]['profile_picture'])) {
                $top_recruters[$j]['profile_picture_full'] = dirname($this->BASE_URL) . "/uploads/images/profile_picture/" . $top_recruters[$j]['profile_picture'];
            } else {
                $top_recruters[$j]['profile_picture_full'] = dirname($this->BASE_URL) . "/uploads/images/profile_picture/nophoto.jpg";
            }
            $j++;
        }
        //top 5 Earners
        $top_earners = $this->home_model->getTopEarners(10, $this->LOG_USER_ID);

        $i = 0;
         $place_arr=array('1st','2nd','3rd','4th','5th','6th','7th','8th','9th','10th');
        foreach ($top_earners as $v) {
            $top_earners[$i]['balance_amount'] = $this->DEFAULT_SYMBOL_LEFT . number_format($v['balance_amount'] * $this->DEFAULT_CURRENCY_VALUE, 2) . $this->DEFAULT_SYMBOL_RIGHT;
            $top_earners[$i]['profile_picture'] = $this->validation_model->getProfilePicture($v['id']);
            if (file_exists(IMG_DIR . "profile_picture/" . $top_earners[$i]['profile_picture'])) {
                $top_earners[$i]['profile_picture_full'] = dirname($this->BASE_URL) . "/uploads/images/profile_picture/" . $top_earners[$i]['profile_picture'];
            } else {
                $top_earners[$i]['profile_picture_full'] = dirname($this->BASE_URL) . "/uploads/images/profile_picture/nophoto.jpg";
            }
            $top_earners[$i]['place'] =$place_arr[$i];
            $i++;
        }
        //logged User details
        $user_details = $this->validation_model->getUserDetails($this->LOG_USER_ID, $this->LOG_USER_TYPE);
        $user_details['user_name'] = $this->LOG_USER_NAME;
        $user_details['membership'] = $this->validation_model->getProductNameFromUserID($this->LOG_USER_ID);

        //News Details

        $this->load->model('news_model');
        $news_arr = $this->news_model->getLatestNews();
        $this->set("news_arr", count($news_arr));

        /////////////////////////////////////////////////////////////////////////////////////
        //to_do_list
        $todo_list = $this->home_model->getToDoList($this->LOG_USER_ID);
        $count_todo = $this->home_model->getCountToDoList($this->LOG_USER_ID);
        for ($i = 0; $i < $count_todo; $i++) {
            $timestamp = $todo_list[$i]['time'];

            if ($todo_list[$i]['days'] == 0) {
                $todo_list[$i]['time'] = 'Today ' . date('g:i a', strtotime($todo_list[$i]['time']));
            } else if ($todo_list[$i]['days'] == -1) {
                $todo_list[$i]['time'] = 'Tommorrow ' . date('g:i a', strtotime($todo_list[$i]['time']));
            } else if ($todo_list[$i]['days'] == 1) {
                $todo_list[$i]['time'] = 'Yesterday ' . date('g:i a', strtotime($todo_list[$i]['time']));
            } else {
                $todo_list[$i]['time'] = date('d/m/y g:i a', strtotime($todo_list[$i]['time']));
            }
        }

        //Data For World Map
        $map_data = $this->home_model->getCountryMapdata($this->LOG_USER_ID);
        //Data For Progress bar
        $prgrsbar_data = $this->home_model->getPackageProgressData(4, $this->LOG_USER_ID);


        if ($this->MODULE_STATUS['mlm_plan'] == 'Binary') {
            $date = date('Y-m-d');
            $rs = $this->joining_model->getJoiningDetailsForBinaryLeftRight($this->LOG_USER_ID);
            $daily_joining = $this->joining_model->getJoiningDetailsForBinaryLeftRight($this->LOG_USER_ID, $date . " 00:00:00", $date . " 23:59:59");
            $joining["joinings_data2"] = $rs['joining'];
            $joining["joinings_data4"] = $rs['joining_right'];
            $joining["joinings_data1"] = $daily_joining['joining'];
            $joining["joinings_data3"] = $daily_joining['joining_right'];
        } else {
            $start_date = date('Y-m-01') . " 00:00:00";
            $end_date = date('Y-m-31') . " 23:59:59";
            $week_end_date = date('Y-m-d') . " 23:59:59";
            $week_start_date = date('Y-m-d', strtotime('last sunday')) . " 00:00:00";

            $joining["joinings_data2"] = $this->home_model->totalJoiningUsers($this->LOG_USER_ID);
            $joining["joinings_data1"] = $this->home_model->todaysJoiningCount($this->LOG_USER_ID);
            $joining["joinings_data4"] = $this->joining_model->getJoiningCountPerMonth($start_date, $end_date, $this->LOG_USER_ID);
            $joining["joinings_data3"] = $this->tree_model->getDownlineUsersCount($this->LOG_USER_ID, 'father', $week_start_date, $week_end_date);
        }

        //////////////////////////////////////////////////////////////////////////////

        $latest_joinees = $this->home_model->getLatestJoinees('user');
        $j = 0;
        foreach ($latest_joinees as $v) {
            if (file_exists(IMG_DIR . "profile_picture/" . $latest_joinees[$j]['profile_pic'])) {
                $latest_joinees[$j]['profile_picture_full'] = dirname($this->BASE_URL) . "/uploads/images/profile_picture/" . $latest_joinees[$j]['profile_pic'];
            } else {
                $latest_joinees[$j]['profile_picture_full'] = dirname($this->BASE_URL) . "/uploads/images/profile_picture/nophoto.jpg";
            }
            $j++;
        }
        $userid = $this->LOG_USER_ID;
        $current_date= date('Y-m-d H:i:s');
        $date_details= $this->ewallet_model->getSubscriptionEndDate($userid);
        
        $monthly_fee= $this->ewallet_model->getMonthlyFee();
        $join_type = $this->validation_model->getJoinType($userid);
        $product_id = $this->validation_model->getProductId($this->LOG_USER_ID);
        $current_product = $this->validation_model->getProductDescriptionFromProdID($product_id);
        $personal_pv = $this->validation_model->getPersnlPv($userid);
        $left_volume = $this->validation_model->getTotalLeftLeg($userid);
        $right_volume = $this->validation_model->getTotalRightLeg($userid);
        $last_week_earnings = $this->home_model->getLastWeekEarnedIncome($userid);
        $last_week_earnings = $this->DEFAULT_CURRENCY_VALUE * $last_week_earnings;
        $last_week_earnings = $this->niceNumberCommission($last_week_earnings);
        $last_week_earnings = $this->DEFAULT_SYMBOL_LEFT . $last_week_earnings . $this->DEFAULT_SYMBOL_RIGHT;
        
        $last_month_earnings = $this->home_model->getLastMonthEarnedIncome($userid);
        $last_month_earnings = $this->DEFAULT_CURRENCY_VALUE * $last_month_earnings;
        $last_month_earnings = $this->niceNumberCommission($last_month_earnings);
        $last_month_earnings = $this->DEFAULT_SYMBOL_LEFT . $last_month_earnings . $this->DEFAULT_SYMBOL_RIGHT;
        
        $avg_earnings = $this->home_model->getAverageEarnings($user_id);
        $avg_earnings = $this->DEFAULT_CURRENCY_VALUE * $avg_earnings;
        $avg_earnings = $this->niceNumberCommission($avg_earnings);
        $avg_earnings = $this->DEFAULT_SYMBOL_LEFT . $avg_earnings . $this->DEFAULT_SYMBOL_RIGHT;
        
        $year_earnings = $this->home_model->getYearEarnings($user_id);
        $year_earnings = $this->DEFAULT_CURRENCY_VALUE * $year_earnings;
        $year_earnings = $this->niceNumberCommission($year_earnings);
        $year_earnings = $this->DEFAULT_SYMBOL_LEFT . $year_earnings . $this->DEFAULT_SYMBOL_RIGHT;
        
        $sponsor_id = $this->validation_model->getSponsorId($user_id);
        $sponsor_name=$this->validation_model->IdToUserName($sponsor_id);
        $father_id = $this->validation_model->getFatherId($user_id);
        $placement_name=$this->validation_model->IdToUserName($father_id);
        $group_pv = $this->validation_model->getGrpPv($userid);
        //$total_right_user_count=$this->home_model->getLeftUSerCount($userid);
        if ($this->MODULE_STATUS['rank_status'] == 'yes') {
            $this->load->model('rank_model');
            $rank_achievement = $this->rank_model->getRankCriteria($this->LOG_USER_ID);//print_R($rank_achievement);
            $rank_name = $rank_achievement['current_rank']['rank_name'];
            
            // $rank_name = $rank_achievement['current_rank']['rank_name'];
            $this->set("rank_achievement", $rank_achievement);
            $highest_rankId = $this->rank_model->getHighestRankAchieved($this->LOG_USER_ID);
            $highest_rank = $this->validation_model->getRankName($highest_rankId);
            $current_rankId = $this->validation_model->getRankId($this->LOG_USER_ID);
            $next_rankId = $current_rankId+1;
            $next_rank = $this->validation_model->getRankName($next_rankId);
            $next_bv=0;
            $next_left_volume=0;
            if($rank_achievement['next_rank']['personal_pv']>=$personal_pv){
                $next_bv= $rank_achievement['next_rank']['personal_pv']-$personal_pv;
            }
            if($rank_achievement['next_rank']['group_pv'] >= $group_pv){
                $next_left_volume=$rank_achievement['next_rank']['group_pv']-$group_pv;
            }
        }
        
       
        
        $total_right_user_count=0;
        $total_right_user_pv=0;
        $total_left_user_count=0;
        $total_left_user_pv=0;
        $downlines_left = $this->home_model->getLeftRightCountPV($this->LOG_USER_ID, 'L');
        $total_left_user_count = $downlines_left['count'];
        $total_left_user_pv = $downlines_left['total_pv'];


        $downlines_right = $this->home_model->getLeftRightCountPV($this->LOG_USER_ID, 'R'); 
        $total_right_user_count = $downlines_right['count'];
        $total_right_user_pv = $downlines_right['total_pv'];
        $join_type = $this->validation_model->getUserJoinType($userid);
        if($join_type=='affiliate'){
            $is_upgraded = $this->validation_model->isUpgradedUser($userid);
            if($is_upgraded){
                $this->load->model('register_model');
                $upgrade_fee = $this->register_model->getRegisterAmount();
                $monthly_fee=$monthly_fee+$upgrade_fee;
            }
        }
       
        $this->set("next_bv", $next_bv); 
        $this->set("next_left_volume", $next_left_volume); 
        $this->set("total_right_user_count", $total_right_user_count); 
        $this->set("total_right_user_pv", $total_right_user_pv);
        $this->set("total_left_user_count", $total_left_user_count); 
        $this->set("total_left_user_pv", $total_left_user_pv);
        $this->set("current_product", $current_product); 
        $this->set("join_type", $join_type); 
       
        $this->set("monthly_fee", $monthly_fee);
        $this->set("subscription_end_date", $date_details);
        $this->set("current_date", $current_date);
        
        $this->set("rank_name", $rank_name);
        $this->set("joining_data", $joining);
        $this->set("prgrsbar_data", $this->security->xss_clean($prgrsbar_data));
        $this->set("map_data", $map_data);
        $this->set("todo_list", $this->security->xss_clean($todo_list));
        $this->set("total_payout", $total_payout);
        $this->set("todays_payout", $todays_payout);
        $this->set("placement_joining", $placement_joinig);
        $this->set("todays_placement_joining", $todays_placement_joining);
        $this->set("donation_type", $donation_type);

        $this->set("total_amount", $total_amount);
        $this->set("requested_amount", $requested_amount);
        $this->set("total_request", $total_request);
        $this->set("total_released", $total_released);
        $this->set("commission", $commission);
        $this->set("donation", $donation);

        $this->set("total_sales", $total_sales);
        $this->set("today_sales", $today_sales);
        $this->set("read_mail", $read_mail);
        $this->set("mail_today", $mail_today);

        $this->set("pinstatus", "NO");
        $this->set("user_id", $user_id);
        $this->set("table_prefix", $prefix);
        $this->set("site_url", $site_url);
        $this->set("top_recruters", $top_recruters);
        $this->set("top_earners", $top_earners);
        $this->set("user_details", $user_details);

        $this->set('social_media_info', $social_media_info);
        $this->set("latest_joinees", $latest_joinees);

        //WORK
        $this->set("rankCriteria", $this->rank_model->getRankCriteria($user_id));
        
        $this->set('personal_pv',$personal_pv);
        $this->set('highest_rank',$highest_rank);
        $this->set('next_rank',$next_rank);
        $this->set('left_volume',$left_volume);
        $this->set('right_volume',$right_volume);
        $this->set('last_week_earnings',$last_week_earnings);
        $this->set('last_month_earnings',$last_month_earnings);
        $this->set('avg_earnings',$avg_earnings);
        $this->set('year_earnings',$year_earnings);
        $this->set('sponsor_name', $sponsor_name);
        $this->set('placement_name', $placement_name);
        $this->set('group_pv', $group_pv);
        
        $total_users = $this->validation_model->getUserActiveReferralCount($this->LOG_USER_ID);
        $this->set("total_users", $total_users);
        
        if ($this->MODULE_STATUS['mlm_plan'] == 'Donation') {
            $this->set('recieved_commission', $recieved_commission);
            $this->set('given_commission', $given_commission);
            $this->set('level_name', $donation_level);
        }

        if (DEMO_STATUS == 'yes') {
            $is_preset_demo = $this->validation_model->isPresetDemo($this->ADMIN_USER_ID);
            $this->set('is_preset_demo', $is_preset_demo);
        }

        $this->setView();
    }
    public function news()
    {
        $this->load->model('news_model');
        $news_arr = $this->news_model->getLatestNews();
        $this->set("news_list", $this->security->xss_clean($news_arr));
        $this->setView();
    }


    /* Ajax Functon For Payout Tile */
    function ajax_payout($range)
    {
        $total_amount = 0;
        $user_id = $this->LOG_USER_ID;
        if ($range == 'monthly_payout') {
            $start_date = date('Y-m-01', strtotime('this month')) . " 00:00:00";
            $end_date = date('Y-m-t', strtotime('this month')) . " 23:59:59";
        }
        if ($range == 'yearly_payout') {
            $start_date = date('Y-01-01') . " 00:00:00";
            $end_date = date('Y-12-31') . " 23:59:59";
        }
        if ($range == 'weekly_payout') {
            $tomorrow = date("Y-m-d", time() + 86400);
            $start_date = date('Y-m-d', strtotime('last Sunday', strtotime($tomorrow))) . " 00:00:00";
            $end_date = date('Y-m-d') . " 23:59:59";
        }
        if ($range == 'all_payout') {
            $start_date = '';
            $end_date = '';
        }
        $total_amount = $this->home_model->getPayoutDetails($start_date, $end_date, $user_id);
        $total_amount = $total_amount * $this->DEFAULT_CURRENCY_VALUE;
        $total_amount = $this->niceNumberCommission($total_amount);
        $total_amount = $this->DEFAULT_SYMBOL_LEFT . $total_amount . $this->DEFAULT_SYMBOL_RIGHT;
        echo $total_amount;
    }


    /* Ajax Functon For Sales  Tile*/

    function ajax_sales($range)
    {
        $total_sales = 0;
        $user_id = $this->LOG_USER_ID;

        if ($range == 'monthly_sales') {
            $start_date = date('Y-m-01', strtotime('this month')) . " 00:00:00";
            $end_date = date('Y-m-t', strtotime('this month')) . " 23:59:59";
        }
        if ($range == 'yearly_sales') {
            $start_date = date('Y-01-01') . " 00:00:00";
            $end_date = date('Y-12-31') . " 23:59:59";
        }
        if ($range == 'weekly_sales') {
            $tomorrow = date("Y-m-d", time() + 86400);
            $start_date = date('Y-m-d', strtotime('last Sunday', strtotime($tomorrow))) . " 00:00:00";
            $end_date = date('Y-m-d') . " 23:59:59";
        }
        if ($range == 'all_sales') {
            $start_date = '';
            $end_date = '';
        }
        $total_sales = $this->home_model->getSalesCount($start_date, $end_date, $user_id);
        $total_sales = $this->niceNumber($total_sales);
        echo $total_sales;
    }

    /* Ajax Functon For Mail Tile*/

    function ajax_mail($range)
    {
        $count_mail_read = 0;
        $count_mail_unread = 0;
        $start_date = '';
        $end_date = '';
        if ($range == 'monthly_mail') {
            $start_date = date('Y-m-01', strtotime('this month')) . " 00:00:00";
            $end_date = date('Y-m-t', strtotime('this month')) . " 23:59:59";
        }
        if ($range == 'yearly_mail') {
            $start_date = date('Y-01-01') . " 00:00:00";
            $end_date = date('Y-12-31') . " 23:59:59";
        }
        if ($range == 'weekly_mail') {
            $tomorrow = date("Y-m-d", time() + 86400);
            $start_date = date('Y-m-d', strtotime('last Sunday', strtotime($tomorrow))) . " 00:00:00";
            $end_date = date('Y-m-d') . " 23:59:59";
        }
        $count_mail_total = $this->home_model->getMailCount('user', $start_date, $end_date, $read_status = '');
        $count_mail_unread = $this->home_model->getMailCount('user', $start_date, $end_date, $read_status = 'no');

        if ($range == 'all_mail') {
            $count_mail_total = $this->home_model->getMailCount('user', $start_date, $end_date, $read_status = '', 'all');
            $count_mail_unread = $this->home_model->getAllUnreadMessages('user');
        }
        $count_mail_total = $this->niceNumber($count_mail_total);
        $count_mail_unread = $this->niceNumber($count_mail_unread);
        $result = array('mail_total' => $count_mail_total, 'mail_unread' => $count_mail_unread);
        echo json_encode($result);
    }


    /* Ajax Functon For Joining In Chart */

    function ajax_joinings_chart($range)
    {
        $this->load->model('joining_model');
        $rs = [];
        $i = 0;
        if ($range == 'monthly_joining_graph') {
            $monthly_joining = $this->home_model->getJoiningDetailsperMonth($this->LOG_USER_ID);

            if ($this->MODULE_STATUS['mlm_plan'] == 'Binary') {
                $monthly_joining = $this->joining_model->getJoiningDetailsperMonthLeftRight($this->LOG_USER_ID);
            }
            foreach ($monthly_joining as $value) {
                $rs[$i]["x"] = $i;
                $rs[$i]["x_label"] = $value['month'];
                $rs[$i]["y"] = $value['joining'];
                if ($this->MODULE_STATUS['mlm_plan'] == 'Binary') {
                    $rs[$i]["z"] = $value['joining_right'];
                }
                $i++;
            }
        }
        if ($range == 'yearly_joining_graph') {
            while ($i <= 5) {
                $j = 5 - $i;
                $start_date = date('Y-01-01', strtotime("-$j year")) . " 00:00:00";
                $end_date = date('Y-12-31', strtotime("-$j year")) . " 23:59:59";
                $rs[$i]["x"] = $i;
                $rs[$i]["x_label"] = intval($start_date);
                if ($this->MODULE_STATUS['mlm_plan'] == 'Binary') {
                    $yearly_joining = $this->joining_model->getJoiningDetailsForBinaryLeftRight($this->LOG_USER_ID, $start_date, $end_date);
                    $rs[$i]["y"] = $yearly_joining['joining'];
                    $rs[$i]["z"] = $yearly_joining['joining_right'];
                } else {
                    $rs[$i]["y"] = $this->joining_model->getJoiningCountPerMonth($start_date, $end_date, $this->LOG_USER_ID);
                }
                $i++;
            }
        }
        if ($range == 'daily_joining_graph') {
            $start_date = date('Y-m-01');
            $end_date = date('Y-m-t', strtotime('this month'));
            while ($start_date <= $end_date) {
                $rs[$i]["x"] = $i;
                $rs[$i]["x_label"] = date('d', strtotime($start_date));

                if ($this->MODULE_STATUS['mlm_plan'] == 'Binary') {
                    $daily_joining = $this->joining_model->getJoiningDetailsForBinaryLeftRight($this->LOG_USER_ID, $start_date . " 00:00:00", $start_date . " 23:59:59");
                    $rs[$i]["y"] = $daily_joining['joining'];
                    $rs[$i]["z"] = $daily_joining['joining_right'];
                } else {
                    $rs[$i]["y"] = $this->joining_model->getJoiningCountPerMonth($start_date . " 00:00:00", $start_date . " 23:59:59", $this->LOG_USER_ID);
                }
                $start_date = date('Y-m-d', strtotime($start_date . ' +1 day'));
                $i++;
            }
        }
        echo json_encode($rs);
    }

    public function add_todo()
    {
        $title = lang('configure_todo');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "dashboard";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $todo_list = $this->home_model->getToDoList($this->LOG_USER_ID);

        $this->setView();
    }
    public function edit_todo()
    {
        $title = lang('configure_todo');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "dashboard";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();


        $id = $this->input->post('id', true);
        $todo_list = $this->home_model->getToDoList($this->LOG_USER_ID, $id);

        $date = date('Y-m-d', strtotime($todo_list[0]['time']));
        $time = date('g:i a', strtotime($todo_list[0]['time']));
        $task = $todo_list[0]['task'];

        $this->set('date', $date);
        $this->set('task_id', $id);
        $this->set('time', $time);
        $this->set('task', $task);
        $this->set('todo_list', $todo_list);
        $this->setView();
    }

    public function delete_todo()
    {
        $id = $this->input->post('tsk_id', true);
        $res = $this->home_model->deleteToDoList($this->LOG_USER_ID, $id);
        if ($res) {
            $data_array['details'] = $res;
            $data = serialize($data_array);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Deleted Task in To-do list', $this->LOG_USER_ID, $data);
            $this->redirect(lang('deleted_task_successfully'), 'home/index', true);
        } else {
            $this->redirect(lang('failed_to_delete'), 'home/index', false);
        }
    }

    public function change_todo()
    {
        $id = $this->input->post('id', true);
        $status = $this->input->post('status', true);
        $res = $this->home_model->ChangeToDoStatus($this->LOG_USER_ID, $id, $status);
        if ($res) {
            $data_array['details'] = $res;
            $data = serialize($data_array);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Status Changed for Task in To-do list', $this->LOG_USER_ID, $data);
        }
    }

    public function validate_todo_list()
    {
        $this->form_validation->set_rules('task', lang("task"), 'trim|required');
        $this->form_validation->set_rules('task_time', lang("time"), 'trim|required|valid_time');
        $this->form_validation->set_rules('task_date', lang("date"), 'trim|required|valid_date|callback_validate_date');
        $validation_result = $this->form_validation->run();
        return $validation_result;
    }

    public function validate_addlist()
    {
        $json = array();
        if ($this->validate_todo_list()) {
            $post_arr = $this->validation_model->stripTagsPostArray($this->input->post(null, true));
            $user_id = $this->LOG_USER_ID;

            $time = date("H:i:s", strtotime($post_arr['task_time']));
            $date = date('y-m-d', strtotime($post_arr['task_date']));
            $start_time = ($date . ' ' . $time);

            $res = $this->home_model->addToDoList($post_arr['task'], $start_time, $user_id);

            if ($res) {
                $json['success'] = lang("task_added_to_to_do_list_successfully");
                $data = serialize($json);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, lang("task_added_to_to_do_list_successfully"), $this->LOG_USER_ID, $data);
            } else {
                $json['error']['warning'] = lang("an_error_occurred");
            }
        } else {
            $json['error'] = $this->form_validation->error_array();
        }

        echo json_encode($json);
        exit();
    }
    public function validate_edit_todo()
    {
        $json = array();
        if ($this->validate_todo_list()) {
            $post_arr = $this->validation_model->stripTagsPostArray($this->input->post(null, true));
            $user_id = $this->LOG_USER_ID;

            $time = date("H:i:s", strtotime($post_arr['task_time']));
            $date = date('y-m-d', strtotime($post_arr['task_date']));
            $start_time = ($date . ' ' . $time);

            $res = $this->home_model->updateToDoList($post_arr['task'], $start_time, $user_id, $post_arr['task_id']);

            if ($res) {
                $json['success'] = lang("task_edited_to_to_do_list_successfully");
            } else {
                $json['error']['warning'] = lang("an_error_occurred");
            }
        } else {
            $json['error'] = $this->form_validation->error_array();
        }

        echo json_encode($json);
        exit();
    }

    public function validate_date()
    {
        $post_arr = $this->validation_model->stripTagsPostArray($this->input->post(null, true));
        $date = strtotime($post_arr['task_date'] . ' ' . $post_arr['task_time']);
        $current_date = strtotime(date('Y-m-d H:i:s'));
        if ($date < $current_date) {
            $this->form_validation->set_message('validate_date', lang("task_date_cannot_be_less_than_the_current_date"));
            return false;
        } else {
            return true;
        }
    }

 /*Package List - Progressbar Starts*/
    public function package_list()
    {
        $title = lang('package_list');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'package_list';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('package_list');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('package_list');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $this->load->model("product_model");

        $package_type = 'registration';
        $pro_status = 'yes';

        $config = $this->pagination->customize_style();
        $base_url = base_url() . 'user/home/package_list';
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $tot_rows = $this->product_model->getPackageCountForProgressbar($package_type, $pro_status);

        $config['total_rows'] = $tot_rows;
        $config['uri_segment'] = 4;

        $this->pagination->initialize($config);
        $page = 0;
        if ($this->uri->segment(4) != '') {
            $page = $this->uri->segment(4);
        }

        $i = 0;
        $total_count = $this->home_model->getTotalPackageCount($this->LOG_USER_ID);
        $product_details = $this->product_model->getPackageListForProgressbar($package_type, "", $config['per_page'], $page);
        foreach ($product_details as $v) {
            $product_details[$i]['perc'] = ($total_count * (int)$this->home_model->getPackageCount($v['prod_id'], $this->LOG_USER_ID));
            $i++;
        }

        $result_per_page = $this->pagination->create_links();
        $this->set('product_details', $this->security->xss_clean($product_details));
        $this->set('result_per_page', $result_per_page);
        $this->set('page', $page);
        $this->setView();
    }
 /*Package List - Progressbar Ends*/
    function niceNumber($n)
    {
        // first strip any formatting;
        $n = (0 + str_replace(",", "", $n));

        // is this a number?
        if (!is_numeric($n)) return false;

        // now filter it;
        if ($n > 1000000000000) return round(($n / 1000000000000), 2) . ' T';
        elseif ($n > 1000000000) return round(($n / 1000000000), 2) . ' B';
        elseif ($n > 1000000) return round(($n / 1000000), 2) . ' M';

        return number_format($n);
    }
    function niceNumberCommission($n)
    {
        // first strip any formatting;
        $n = (0 + str_replace(",", "", $n));

        // is this a number?
        if (!is_numeric($n)) return false;

        // now filter it;
        if ($n > 1000000000000) return round(($n / 1000000000000), 2) . ' T';
        elseif ($n > 1000000000) return round(($n / 1000000000), 2) . ' B';
        elseif ($n > 1000000) return round(($n / 1000000), 2) . ' M';
    //  elseif ($n > 1000) return round(($n / 1000), 2) . ' K';

        return number_format($n, 2);
    }

    public function roi_details()
    {
        $help_link = 'roi';
        $this->set('help_link', $help_link);

        if ($this->MLM_PLAN == 'Unilevel' && $this->MODULE_STATUS['hyip_status'] == 'yes') {
            $title = lang('roi');
        } else {
            $title = lang('total_deposit');
        }
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $this->HEADER_LANG['page_top_header'] = lang('roi');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('roi');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $config = $this->pagination->customize_style();
        $base_url = base_url() . "user/home/roi_details";
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(4);
        } else {
            $page = 0;
        }

        $user_id = $this->LOG_USER_ID;

        $total_amount = $this->home_model->getHyipTotalLegamount($user_id);
        $roi_details = array();
        $roi_details = $this->home_model->getHyipTotalLegAmountDetails($page, $config['per_page'], $user_id);
        $total_rows = $this->home_model->getReturnInvestmentDetailsCount($user_id);
        $this->set("roi_details", $this->security->xss_clean($roi_details));
        $config['total_rows'] = $total_rows;
        $this->set('details_count', $total_rows);
        $this->pagination->initialize($config);
        $this->set("total_amount", $total_amount);
        $result_per_page = $this->pagination->create_links();
        $this->set('result_per_page', $result_per_page);
        $this->set('page_id', $page);
        $this->setView();
    }

    public function active_deposit()
    {
        $title = lang('active_deposit');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'active_deposit';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('active_deposit');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('active_deposit');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $user_id = $this->LOG_USER_ID;

        $total_active_amount = $this->home_model->getActiveDeposit($user_id);
        $active_deposit = array();
        $active_deposit = $this->home_model->getActiveDepositDetails($user_id);
        $total_rows = count($active_deposit);
        $this->set("active_deposit", $active_deposit);
        $this->set('details_count', $total_rows);
        $this->set("total_amount", $total_active_amount);

        $this->setView();
    }

    public function matured_deposit()
    {

        $title = lang('matured_deposit');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'matured_deposit';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('matured_deposit');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('matured_deposit');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $user_id = $this->LOG_USER_ID;

        $total_deposit = $this->home_model->getHyipTotalLegAmount($user_id);
        $total_active_deposit = $this->home_model->getActiveDeposit($user_id);
        $total_matured_deposit = $total_deposit - $total_active_deposit;
        $matured_deposit = array();
        $matured_deposit = $this->home_model->getMaturedDepositDetails($user_id);
        $total_rows = count($matured_deposit);

        $this->set("matured_deposit", $matured_deposit);
        $this->set('details_count', $total_rows);
        $this->set("total_matured_deposit", $total_matured_deposit);
        $this->setView();
    }

    public function change_default_language() {
        if ($this->input->is_ajax_request()) {
            $this->load->model('multi_language_model');
            $language = $this->input->post('language', TRUE);
            $res = $this->multi_language_model->setUserDefaultLanguage($language, $this->LOG_USER_ID);
            if ($res) {
                echo 'yes';
            }
            else {
                echo 'no';
            }
            exit();
        }
    }

    public function ajax_user_downline_autolist() {
        if ($this->input->is_ajax_request()) {
            $keyword = $this->input->post('keyword', TRUE);
            $data = $this->home_model->getDownlineUsersByKeyword($this->LOG_USER_ID, $keyword);
            echo json_encode($data);
            exit();
        }
    }

    public function update_theme_setting()
    {
        if ($this->input->is_ajax_request()) {
            $data = $this->input->post(null, true);
            $response = $this->validation_model->updateThemeSetting($data);
            echo $response;
            exit();
        }
    }
          public function redirection(){
         $message=$this->input->get('Message');
         $this->redirect($message, 'latest_updates', true);
        $title = lang('latest_updates');
      }
     public function latest_updates(){
        
        $title = lang('latest_updates');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'latest_updates';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('latest_updates');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('latest_updates');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        
        $count = $this->home_model->getLatestUploadsCount();
        $bannercount=$this->home_model->getBannerCount();
        $image_det = $this->home_model->getImages();
         $banner = $this->home_model->getBanner();
      
        $this->set('count', $count);
        $this->set('banner_count',$bannercount);
         $this->set('image_det',$image_det);
        $this->set('banner',$banner);
        $this->setView();
        
    }
    
     public function replication_link(){
        
       $title = lang('replication_link');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'replication_link';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('Your_Replicated_Website_Link');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('Your_Replicated_Website_Link');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $site_url = SITE_URL;
        
        $this->set('site_url',$site_url);
        $this->setView(); 
    }
    


}
