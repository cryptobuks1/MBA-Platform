<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://mbatradingacademy.com/office/backoffice_admin/admin/cron/binary_commission_monthly');
$store = curl_exec($ch);
curl_close($ch);
?>