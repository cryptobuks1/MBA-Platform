<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://mbatradingacademy.com/office/backoffice_admin/admin/cron/test_cron');
$store = curl_exec($ch);
curl_close($ch);
?>