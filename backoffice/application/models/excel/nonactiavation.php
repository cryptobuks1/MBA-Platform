<?php

require_once '../../class/Auth.php';
$sess_obj = new Auth();
require (dirname(__FILE__) . "/class-excel-xml.inc.php");
require_once '../../class/Payout.php';
require_once '../../class/ToolTip.php';
$obj_payout = new Payout();
$get_profile = new ToolTip();
require_once '../../class/Validation.php';
$obj_sponser = new Validation();

if ($_GET["from"] and $_GET["to"]) {

    $from_date = $_GET["from"];

    $to_date = $_GET["to"];
    $from_date = $_GET["from"] . " 00:00:00";
    $to_date = $_GET["to"] . " 23:59:59";
    $obj_payout->getActivation($from_date, $to_date, 'no');

    $count = count($obj_payout->actiavtion_details);
//echo "From: $from_date To: $to_date";


    if ($count >= 1) {

        $doc[1][0] = "No";

        $doc[1][1] = "Username";

        $doc[1][2] = "Name";

        $doc[1][3] = "Referral UserID";
        $doc[1][4] = "Referral Full Name";
        $doc[1][5] = "Mobile No";
        $doc[1][6] = "Email";





        $count = $count + 2;

        $j = 0;
        $k = 0;


        for ($i = 2; $i < $count; $i++) {

            $user_name = $obj_payout->actiavtion_details["detail$k"]["user_name"];
            $user_id = $obj_sponser->userNameToID($user_name);
            $table_prefix = $_SESSION['table_prefix'];
            $user_details = $table_prefix . "user_details";
            $qr = "select* from $user_details where user_detail_refid='" . $user_id . "'";

            $details = $get_profile->getUserData($qr);

            $name = $details["detail1"]["name"];
            $address = $details["detail1"]["address"];
            $land = $details["detail1"]["land"];
            $country = $details["detail1"]["country"];
            $state = $details["detail1"]["state"];
            $mobile = $details["detail1"]["mobile"];
            $email = $details["detail1"]["email"];
            $acnumber = $details["detail1"]["acnumber"];
            $nbank = $details["detail1"]["nbank"];
            $nbranch = $details["detail1"]["nbranch"];
            $ifsc = $details["detail1"]["ifsc"];
            $pan = $details["detail1"]["pan"];
            $referral_id = $details["detail1"]["referral"];
            $ref_user_name = $obj_sponser->IdToUserName($referral_id);
            $ref_full_name = $obj_sponser->getFullName($referral_id);


            $doc[$i][0] = $j + 1;

            $doc[$i][1] = $user_name;

            $doc[$i][2] = $name;

            $doc[$i][3] = $ref_user_name;
            $doc[$i][4] = $ref_full_name;

            $doc[$i][5] = $mobile;

            $doc[$i][6] = $email;





            $j = $j + 1;

            $k = $k + 1;
        } // For loop ends



        $now = date("Y-W");

        $xls = new Excel_XML;

        $xls->addArray($doc);

        $xls->generateXML("weekly_report-$now");
    } // End of if
// generate excel file
}
?>