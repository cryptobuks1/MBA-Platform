<?php
/**
 * @version		$Id: step_3.php 4455 2016-10-04 09:51:37Z mic $
 * @package		Translation Deutsch Installation
 * @author		mic - http://osworx.net
 * @copyright	2016 OSWorX - https://osworx.net
 * @license		GPL - www.gnu.org/copyleft/gpl.html
 */

// Heading
$_['heading_title']				= 'Konfiguration';

// Text
$_['text_step_3']				= 'Datenbank- &amp; Admindetails';
$_['text_db_connection']		= '1. Datenbankverbindung';
$_['text_db_administration']	= '2. Admin Benutzername &amp; Passwort';
$_['text_mysqli']				= 'MySQLi';
$_['text_mysql']				= 'MySQL';
$_['text_mpdo']					= 'mPDO';

// Entry
$_['entry_db_driver']			= 'Datenbanktreiber';
$_['entry_db_hostname']			= 'Hostname';
$_['entry_db_username']			= 'Benutzername';
$_['entry_db_password']			= 'Passwort';
$_['entry_db_database']			= 'Datenbank';
$_['entry_db_prefix']			= 'Vorzeichen';
$_['entry_db_port']				= 'Anschluss';
$_['entry_username']			= 'Benutzername <small>(nicht admin udgl.)</small>';
$_['entry_password']			= 'Passwort';
$_['entry_email']				= 'Email';

// Error
$_['error_db_hostname']			= 'DB Hostname erforderlich!';
$_['error_db_username']			= 'DB Benutzername erforderlich!';
$_['error_db_database']			= 'Datenbankname erforderlich!';
$_['error_db_port']				= 'Datenbankportnr. erforderlich!';
$_['error_db_prefix']			= 'Datenbankvorzeichen darf nur Zeichen a-z, Zahlen 0-9 und Unterstrich enthalten';
$_['error_db_connect']			= 'Fehler! Keine Verbindung zur Datenbank möglich .. bitte Datenbank, Benutzername &amp; Passwort überpüfen!';
$_['error_username']			= 'Benutzername erforderlich!';
$_['error_password']			= 'Passwort erforderlich!';
$_['error_email']				= 'Ungültige Emailadresse!';
$_['error_config']				= 'Fehler: config.php kann nicht geschrieben werden, bitte Rechte überprüfen: ';