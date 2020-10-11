<?php

// Version
define('VERSION', '2.3.0.2');

// Configuration
if (is_file('config.php')) {
	require_once('config.php');
}

// Install
if (!defined('DIR_APPLICATION')) {
	header('Location: ../install/index.php');
	exit;
}

// VQMOD
require_once('../vqmod/vqmod.php');
VQMod::bootup();

// VQMOD Startup
require_once(VQMod::modCheck(DIR_SYSTEM . 'startup.php'));

start('admin');