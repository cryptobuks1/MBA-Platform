<?php
/**
 * @version		$Id: step_2.php 4455 2016-10-04 09:51:37Z mic $
 * @package		Translation Deutsch Installation
 * @author		mic - http://osworx.net
 * @copyright	2016 OSWorX - https://osworx.net
 * @license		GPL - www.gnu.org/copyleft/gpl.html
 */

// Heading
$_['heading_title']				= 'Servereinstellungen';

// Text
$_['text_step_2']				= 'Einstellungen sind genau zu prüfen und allenfalls anzupassen';
$_['text_install_php']			= '1. <b>PHP-Einstellungen</b><br />(wenn Status nicht <span class="text-success"><i class="fa fa-check-circle"></i></span>, bitte anpassen)';
$_['text_install_extension']	= '2. <b>PHP-Erweiterungen</b><br />(wenn nicht <span class="text-success"><i class="fa fa-check-circle"></i></span>, dann Servereinstellungen anpassen da Shop dann möglicherweise nicht voll funktionstüchtig!)';
$_['text_install_db']			= 'Mindestens 1 Datenbanktreiber muss verfügbar sein';
$_['text_install_file']			= '3. <b>Konfigurationsdateien</b><br />(falls noch nicht gemacht, beide Dateien müssen <b>config.php</b> heißen.<br />Wenn notwendig anpassen bzw. erstellen &amp; <a onclick="location.reload();">Seite neu laden</a>)';
$_['text_install_directory']	= '4. <b>Ordnerrechte</b><br />(wenn notwendig anpassen <b>0755</b> &amp; <a onclick="location.reload();">Seite neu laden</a>)';
$_['text_setting']				= 'PHP Einstellungen';
$_['text_current']				= 'Aktuell';
$_['text_required']				= 'Benötigt';
$_['text_extension']			= 'Erweiterungen';
$_['text_db']					= 'Datenbank';
$_['text_db_driver']			= 'Databanktreiber';
$_['text_file']					= 'Dateien';
$_['text_directory']			= 'Verzeichnisse';
$_['text_status']				= 'Status';
$_['text_version']				= 'PHP Version';
$_['text_global']				= 'Register Globals';
$_['text_magic']				= 'Magic Quotes GPC';
$_['text_file_upload']			= 'Dateiuploads';
$_['text_session']				= 'Session Auto Start';
$_['text_gd']					= 'GD';
$_['text_curl']					= 'cURL';
$_['text_mcrypt']				= 'mCrypt';
$_['text_zlib']					= 'ZLIB';
$_['text_zip']					= 'ZIP';
$_['text_mbstring']				= 'mbstring';
$_['text_on']					= '<b style="color:green;">An</b>';
$_['text_off']					= '<b style="color:red;">Aus</b>';
$_['text_writable']				= 'Beschreibbar';
$_['text_unwritable']			= 'Ni. Beschreibbar';
$_['text_missing']				= 'Fehlt';

// Error
$_['error_version']				= 'Es wird mindestens php-Version 5.3 benötigt';
$_['error_file_upload']			= 'Dateiuploads müssen aktiviert sein';
$_['error_session']				= 'session.auto_start muss deaktiviert sein';
$_['error_db']					= 'Mind. 1 Datenbankerweiterung in der php.ini muss aktiviert sein(z.B. MySQL)';
$_['error_gd']					= 'GD-Bibliothek wird benötigt';
$_['error_curl']				= 'CURL muss aktiviert sein';
$_['error_mcrypt']				= 'mCrypt muss aktiviert sein';
$_['error_zlib']				= 'ZLIB muss geladen sein';
$_['error_zip']					= 'ZIP muss geladens ein';
$_['error_mbstring']			= 'mbstring muss aktiviert sein';
$_['error_catalog_exist']		= '<b>config.php</b> ist nicht vorhanden, bitte config-dist.php in config.php umbenennen und Seite neu laden';
$_['error_catalog_writable']	= '<b>config.php</b> muss beschreibbar sein';
$_['error_admin_exist']			= '<b>admin/config.php</b> ist nicht vorhanden, bitte admin/config-dist.php in admin/config.php umbenennen und Seite neu laden';
$_['error_admin_writable']		= '<b>admin/config.php</b> muss beschreibbar sein';
$_['error_image']				= 'Bildordner muss beschreibbar sein';
$_['error_image_cache']			= 'Bildzwischenspeicher muss beschreibbar sein';
$_['error_image_catalog']		= 'Bildordner muss beschreibbar sein';
$_['error_cache']				= 'Cacheordner muss beschreibbar sein';
$_['error_log']					= 'Ordner für Berichte muss beschreibbar sein';
$_['error_download']			= 'Downloadordner muss beschreibbar sein';
$_['error_upload']				= 'Uploadordner muss beschreibbar sein';
$_['error_modification']		= 'Ordner modification muss beschreibbar sein';