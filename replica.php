<?php
ini_set('display_errors', 1);

//echo __DIR__ . '/store/system/storage/session';die;
session_save_path(__DIR__ . '/store/system/storage/session');
session_start();

require_once('class/validation.php');
$unique_id = "";
$unique = "";
$val = new Validation();
if (isset($_GET["id"])) {
    $unique = $_GET["id"];
    $unique_id = $_GET["id"];
}elseif(isset($_SESSION['replica'])){
    unset($_SESSION['replica']);
}else{
    $unique_id = "";
  //  $_SESSION['replica']['inf_replica_usertype'] = "normal";
}

$check = $val->checkUserValid($unique_id);

if (!$check && $unique_id != '') {
    $unique_id = $val->getAdminUsername();
    $check = $val->checkUserValid($unique_id);
}


if ($check) {
    $id = $val->getUserId($unique_id);
    $details = $val->getAllUserDetails($id);
    $photo = $val->getUserPhoto($id);
    $module_status = $val->getModuleStatus($id);
    if (!$details) {
        unset($_SESSION['replica']);
        header("location:index.php");
    } else {
        $_SESSION['replica']['user_id'] = $id;
        $_SESSION['replica']['user_type'] = $details['user_type'];
        $_SESSION['replica']['user_name'] = $details['user_name'];
        $_SESSION['replica']['sponsor_id'] = $details['sponsor_id'];
        $_SESSION['replica']['customer_id'] = $details['oc_customer_ref_id'];
        $_SESSION['replica']['user_photo'] = $photo['user_photo'];
        $_SESSION['replica']['inf_replica_username'] = $details['user_name'];
        $_SESSION['replica']['inf_site_name'] = $details['site_name'];
        $_SESSION['replica']['inf_replica_usertype'] = "normal";
        $_SESSION['replica']['inf_replica_userid'] = $id;
        $_SESSION['replica']['table_prefix'] = '1813_';
        $_SESSION['replica']['replicated'] = true;
       
        if ($unique) {
            echo "<script>document.location.href='store'</script>";
        } else {
            echo "<script>document.location.href='store/index.php?route=common/home'</script>";
        }
    }
} else {
    echo "<script>document.location.href='store/index.php?route=common/home'</script>";
}
?>
