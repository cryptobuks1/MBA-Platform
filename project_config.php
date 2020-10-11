<?php
if (isset($_SERVER['HTTPS'])) {
	$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
}
else {
	$protocol = 'http';
}
$host = $protocol . "://" . $_SERVER['HTTP_HOST'];
if (isset($_SERVER['DOCUMENT_ROOT'])) {
	$web_root = $_SERVER['DOCUMENT_ROOT'];
	$dir = __DIR__;
	$path = str_replace($web_root, '', $dir);
}
else {
	$path = '/jason';
}
$site_url = $host . $path;

return [
	// 'db_hostname' => $_ENV["db_hostname"],
	// 'db_username' => $_ENV["db_username"],
	// 'db_password' => $_ENV["db_password"],
	// 'db_database' => $_ENV["db_database"],
	// 'db_hostname' => 'mba-platform-production.ckah2cqgu9kx.ap-southeast-2.rds.amazonaws.com',
	// 'db_username' => 'admin',
	// 'db_password' => 'gRVj1#u3$H11vD6ES1WC29$zfQBsuM4Hn3rE^#b6',
	// 'db_database' => 'mba_platform_development',
	'db_hostname' => '72.167.20.57',
	'db_username' => 'mbatradi_henry',
	'db_password' => '1DcxZPQNlCRWG6RmZhZv3GZeE63nRdUcy9JV',
	'db_database' => 'mbatradi_jason',
	'db_prefix' => '23326_',
	'db_ocprefix' => '23326_oc_',
	'pagination' => '20',
	'precision' => '2',
	'demo_status' => 'no',
	'site_url' => $site_url,
	'public_vars' => [
		'ADMIN_URL'    => $site_url . '/backoffice_admin',
		'USER_URL'     => $site_url . '/backoffice'
	]
];
