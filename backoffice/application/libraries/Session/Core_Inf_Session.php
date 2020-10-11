<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Core_Inf_Session extends CI_Session
{

    /**
     * Set userdata
     *
     * Legacy CI_Session compatibility method
     *
     * @param	mixed	$data	Session data key or an associative array
     * @param	mixed	$value	Value to store
     * @return	void
     */
    public function set_userdata($data, $value = NULL)
    {

        if (is_array($data)) {
            foreach ($data as $key => &$value) {
                $_SESSION[$key] = $this->_enc($value);
            }

            return;
        }

        $_SESSION[$data] = $this->_enc($value);
    }
    // ------------------------------------------------------------------------

    /**
     * Userdata (fetch)
     *
     * Legacy CI_Session compatibility method
     *
     * @param	string	$key	Session data key
     * @return	mixed	Session data value or NULL if not found
     */
    public function userdata($key = NULL)
    {
        if (isset($key)) {
            return isset($_SESSION[$key]) ? $this->_dec($_SESSION[$key]) : NULL;
        } elseif (empty($_SESSION)) {
            return array();
        }

        $userdata = array();
        $_exclude = array_merge(
            array('__ci_vars'),
            $this->get_flash_keys(),
            $this->get_temp_keys()
        );

        foreach (array_keys($_SESSION) as $key) {
            if (!in_array($key, $_exclude, TRUE)) {
                $userdata[$key] = $this->_dec($_SESSION[$key]);
            }
        }
        return $userdata;
    }
    // ------------------------------------------------------------------------

    /**
     * Encrypt function
     *
     * @return	array
     */
    public function _enc($value)
    {
        $CI = &get_instance();
        if (is_array($value)) {
            array_walk_recursive($value, array($this, 'get_encrypt'));
            return $value;
        } else {
            $value = $CI->encryption->encrypt($value);
            return $value;
        }
    }
    // ------------------------------------------------------------------------

    /**
     * Decrypt function
     *
     * @return	array
     */
    public function _dec($value)
    {
        $CI = &get_instance();
        if (is_array($value)) {
            array_walk_recursive($value, array($this, 'get_decrypt'));
            return $value;
        } else {
            $value = $CI->encryption->decrypt($value);
            return $value;
        }
    }
    // ------------------------------------------------------------------------

    /**
     * Get encrypt values
     *
     * @return	array
     */
    public function get_encrypt(&$item)
    {
        $CI = &get_instance();
        $item = $CI->encryption->encrypt($item);
    }
    // ------------------------------------------------------------------------

    /**
     * Get decrypt values
     *
     * @return	array
     */
    public function get_decrypt(&$item)
    {
        $CI = &get_instance();
        $item = $CI->encryption->decrypt($item);
    }
    // ------------------------------------------------------------------------

    /**
     * Handle temporary variables
     *
     * Clears old "flash" data, marks the new one for deletion and handles
     * "temp" data deletion.
     *
     * @return	void
     */
    protected function _ci_init_vars()
    {
        if (!empty($_SESSION['__ci_vars'])) {
            $current_time = time();

            foreach ($_SESSION['__ci_vars'] as $key => &$value) {
                if ($value === 'new') {
                    $_SESSION['__ci_vars'][$key] = 'old';
                }
                // Hacky, but 'old' will (implicitly) always be less than time() ;)
                // DO NOT move this above the 'new' check!
                elseif ($value < $current_time) {
                    unset($_SESSION[$key], $_SESSION['__ci_vars'][$key]);
                }
            }

            if (empty($_SESSION['__ci_vars'])) {
                unset($_SESSION['__ci_vars']);
            }
        }

        $dec_session = $this->glob_session();
        $this->userdata = &$dec_session;
    }

    // ------------------------------------------------------------------------

    /**
     * Flashdata (fetch)
     *
     * Legacy CI_Session compatibility method
     *
     * @param	string	$key	Session data key
     * @return	mixed	Session data value or NULL if not found
     */
    public function flashdata($key = NULL)
    {
        if (isset($key)) {
            return (isset($_SESSION['__ci_vars'], $_SESSION['__ci_vars'][$key], $_SESSION[$key]) && !is_int($_SESSION['__ci_vars'][$key]))
                ? $this->_dec($_SESSION[$key])
                : NULL;
        }

        $flashdata = array();

        if (!empty($_SESSION['__ci_vars'])) {
            foreach ($_SESSION['__ci_vars'] as $key => &$value) {
                is_int($this->_dec($value)) or $flashdata[$key] = $this->_dec($_SESSION[$key]);
            }
        }

        return $flashdata;
    }
    // ------------------------------------------------------------------------

    /**
     * Userdata (fetch)
     *
     * Legacy CI_Session compatibility method
     *
     * @param	string	$key	Session data key
     * @return	mixed	Session data value or NULL if not found
     */
    public function glob_session($key = NULL)
    {
        $userdata = array();
        $_exclude = array_merge(
            array('__ci_vars'),
            $this->get_flash_keys(),
            $this->get_temp_keys()
        );

        foreach (array_keys($_SESSION) as $key) {
            if (!in_array($key, $_exclude, TRUE)) {
                $userdata[$key] = $this->_dec($_SESSION[$key]);
            } else {
                $userdata[$key] = $_SESSION[$key];
            }
        }
        return $userdata;
    }
}
