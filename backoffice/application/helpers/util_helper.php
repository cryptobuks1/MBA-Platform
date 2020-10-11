<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('datetime_compare')) {
	function datetime_compare($datetime, $compare = 'eq', $compare_with = '') {
		if (empty($compare_with)) {
			$compare_with = date('Y-m-d H:i:s');
		}
		$dt = new DateTime($datetime);
		$now = new DateTime($compare_with);
		$res = ($dt <=> $now);
		return compare_return($compare, $res);
	}
}

if (!function_exists('date_compare')) {
	function date_compare($date, $compare = 'eq', $compare_with = '') {
		if (empty($compare_with)) {
			$compare_with = date('Y-m-d');
		}
		$dt = new DateTime($date);
		$dt->setTime(0, 0, 0);
		$now = new DateTime($compare_with);
		$now->setTime(0, 0, 0);
		$res = ($dt <=> $now);
		return compare_return($compare, $res);
	}
}

function compare_return($compare, $res) {
	if ($compare == 'eq') {
		return ($res === 0);
	}
	elseif ($compare == 'neq') {
		return ($res !== 0);
	}
	elseif ($compare == 'lt') {
		return ($res === -1);
	}
	elseif ($compare == 'gt') {
		return ($res === 1);
	}
	elseif ($compare == 'lteq') {
		return ($res === 0 || $res === -1);
	}
	elseif ($compare == 'gteq') {
		return ($res === 0 || $res === 1);
	}
}
