<?php

/**
 * Decode session data
 */
if (!function_exists('decode_session_data')) {

    function decode_session_data($session_data) {
        $return_data = array();
        $offset = 0;
        while ($offset < strlen($session_data)) {
            if (!strstr(substr($session_data, $offset), "|")) {
                return $return_data;
            }
            $pos = strpos($session_data, "|", $offset);
            $num = $pos - $offset;
            $varname = substr($session_data, $offset, $num);
            $offset += $num + 1;
            $data = unserialize(substr($session_data, $offset));
            $return_data[$varname] = $data;
            $offset += strlen(serialize($data));
        }
        return $return_data;
    }

}
if (!function_exists('encode_session_data')) {

    function encode_session_data($session_data) {
        $temp = $_SESSION;
        $_SESSION = $session_data;
        $return_data = session_encode();
        $_SESSION = $temp;
        return $return_data;
    }

}