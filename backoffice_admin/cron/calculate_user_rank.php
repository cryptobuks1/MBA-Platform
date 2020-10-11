<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://mbatradingacademy.com/office/backoffice_admin/admin/cron/calculate_user_rank');
$store = curl_exec($ch);
curl_close($ch);
?>