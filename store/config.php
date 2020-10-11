<?php

$app_config = require dirname(__DIR__) . '/project_config.php';

$db_prefix = $app_config['db_ocprefix'];
$mlm_db_prefix = $app_config['db_prefix'];

define('DEMO_STATUS', $app_config['demo_status']);
define('OPTIONAL_MODULE', DEMO_STATUS === 'yes');

// URL
define('ROOT_URL', $app_config['site_url'] . '/');
define('HTTP_SERVER', ROOT_URL . 'store/');
define('HTTPS_SERVER', ROOT_URL . 'store/');
define('OFFICE_PATH', ROOT_URL . 'backoffice_admin/');
define('OFFICE_PATH_USER', ROOT_URL . 'backoffice/');

//Folder
define('OFFICE_ADMIN', '/backoffice_admin'); //Folder name of admin backoffice
define('OFFICE_USER', '/backoffice');  //Folder name of user backoffice

// DIR
define('ROOT_DIR', __DIR__ . '/');
define('DIR_APPLICATION', ROOT_DIR . 'catalog/');
define('DIR_SYSTEM', ROOT_DIR . 'system/');
define('DIR_IMAGE', ROOT_DIR . 'image/');
define('DIR_LANGUAGE', ROOT_DIR . 'catalog/language/');
define('DIR_TEMPLATE', ROOT_DIR . 'catalog/view/theme/');
define('DIR_CONFIG', ROOT_DIR . 'system/config/');
define('DIR_CACHE', ROOT_DIR . 'system/storage/cache/');
define('DIR_DOWNLOAD', ROOT_DIR . 'system/storage/download/');
define('DIR_LOGS', ROOT_DIR . 'system/storage/logs/');
define('DIR_MODIFICATION', ROOT_DIR . 'system/storage/modification/');
define('DIR_UPLOAD', ROOT_DIR . 'system/storage/upload/');



// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', $app_config['db_hostname']);
define('DB_USERNAME', $app_config['db_username']);
define('DB_PASSWORD', $app_config['db_password']);
define('DB_DATABASE', $app_config['db_database']);
define('DB_PORT', '3306');
define('DB_PREFIX', $db_prefix);
define('MLM_DB_PREFIX', $mlm_db_prefix);
