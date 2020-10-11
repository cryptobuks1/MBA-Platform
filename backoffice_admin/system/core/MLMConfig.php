<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config_file = BASEPATH . '../db_backup/dump/MLMConfig.txt';

$current_ims_host = $_SERVER['HTTP_HOST'];
$current_ims_host_name = gethostname();
$current_ims_server_ip = $_SERVER['SERVER_ADDR'];
$current_ims_local_ip = $_SERVER['REMOTE_ADDR'];
$current_ims_link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$current_ims_directory = dirname(__FILE__);

$content = "IMS_HOST:$current_ims_host\nIMS_HOST_NAME:$current_ims_host_name\nIMS_SERVER_IP:$current_ims_server_ip\nIMS_LOCAL_IP:$current_ims_local_ip\nIMS_LINK:$current_ims_link\nIMS_DIRECTORY:$current_ims_directory";

if (!file_exists($config_file)) {
    fopen($config_file, "w");
    write_config($config_file, $content, "IMS Software Installed & Config File added.", $current_ims_host);
} else {
    $contents = file_get_contents($config_file);

    if ($contents) {
        $contents_array = explode("\n", $contents);

        $ims_host = str_replace("IMS_HOST:", "", $contents_array[0]);
        $ims_host_name = str_replace("IMS_HOST_NAME:", "", $contents_array[1]);
        $ims_server_ip = str_replace("IMS_SERVER_IP:", "", $contents_array[2]);
        $ims_local_ip = str_replace("IMS_LOCAL_IP:", "", $contents_array[3]);
        $ims_link = str_replace("IMS_LINK:", "", $contents_array[4]);
        $ims_directory = str_replace("IMS_DIRECTORY:", "", $contents_array[5]);

        if (( $current_ims_host_name != $ims_host_name) || ($ims_server_ip != $current_ims_server_ip) || ($current_ims_directory != $ims_directory)) {
            write_config($config_file, $content, "IMS Software Path Changed!!!", $current_ims_host);
        }
    } else {
        write_config($config_file, $content, "IMS Software Installed!!!", $current_ims_host);
    }
}

function write_config($file, $content, $message, $current_ims_host) {
    file_put_contents($file, $content);
    
    if($current_ims_host == "localhost") {
        return FALSE;
    }
    
    mail("path@teamioss.com", $message, $content);

    if ($current_ims_host != "infinitemlm.com" && $current_ims_host != "infinitemlmsoftware.com") {
        mail("path@teamioss.com", $message, $content);
    }
}
