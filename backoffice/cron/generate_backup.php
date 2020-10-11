<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/WC/Revamp_Responsive/backoffice/admin/cron/generate_backup');
$store = curl_exec($ch);
curl_close($ch);
?>