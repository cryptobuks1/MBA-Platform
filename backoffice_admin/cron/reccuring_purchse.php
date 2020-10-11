<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://mbatradingacademy.com/office/backoffice_admin/admin/cron/reccuring_purchse');
$store = curl_exec($ch);
curl_close($ch);
?>