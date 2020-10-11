<?php
/**
 * @version		$Id: maxmind.php 4457 2016-10-05 10:04:36Z mic $
 * @package		Translation German Installer
 * @author		mic - https://osworx.net
 * @copyright	2016 OSWorX - https://osworx.net
 * @license		GPL - www.gnu.org/copyleft/gpl.html
 */

// Heading
$_['heading_title']			= 'MaxMind';

$_['text_maxmind']			= 'Kostenpflichtiger Betrugserkennungsdienst';
$_['text_success']			= 'MaxMind erfolgreich installiert';
$_['text_signup']			= 'Wenn kein Linzenzschlüssel vorhanden ist, kann <a href="http://www.maxmind.com/" target="_blank">hier</a> einer angefordert werden (kostenpflichtig).';

// Entry
$_['entry_key']				= 'Lizenzschlüssel';
$_['entry_score']			= 'Risikopunkte';
$_['entry_order_status']	= 'Betruf Auftragsstatus';

// Help
$_['help_score']			= 'Je mehr Punkte desto höher wird der Auftrag wahrscheinlich in Betrugsabsicht erfolgt sein (Wert zwischen 0 - 100)';
$_['help_order_status']		= 'Aufträge über diesem Wert werden automatisch diesem Auftragsstatus zugewiesen und können nicht automatisch vom Kunden abgeschlossen werden';

// Error
$_['error_key']				= 'Maxmindlizenzschlüssel erforderlich';
$_['error_score']			= 'Ein Wert zwischen 0 ind 100 ist möglich';