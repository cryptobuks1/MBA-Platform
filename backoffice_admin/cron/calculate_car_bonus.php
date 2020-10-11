<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://mbatradingacademy.com/office/backoffice_admin/admin/cron/calculate_car_bonus');
$store = curl_exec($ch);
curl_close($ch);
?>