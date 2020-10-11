<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Core_Inf_Form_validation extends CI_Form_validation {
    
        protected $err_id	= 'id=form_err_';

            /**
             * Custom error id
             *
             * @var string
             */

	public function set_form_error($field, $error) {
		$this->_field_data[$field]['error'] = $error;
	}

	public function run_with_redirect($redirect_uri) {
		$result = $this->run();
		if ($result) {
			return TRUE;
		}
		$this->CI->session->set_flashdata('form_error_redirect', $this->error_array());
		$this->CI->redirect(null, $redirect_uri, null);
	}

	public function user_exists($str) {
		return $this->CI->validation_model->isUserNameAvailable($str);
	}

	public function valid_time($str) {
		return (bool)preg_match("/^(1[0-2]|0?[1-9]):[0-5][0-9] (AM|PM)$/i", $str);
	}

	public function valid_date($str) {
		$dt = DateTime::createFromFormat("Y-m-d", $str);
		return $dt !== false && !array_sum($dt->getLastErrors());
	}

	public function not_equals($str, $str2) {
		return $str !== $str2;
	}
        /**
	 * Get Error Message
	 *
	 * Gets the error message associated with a particular field
	 *
	 * @param	string	$field	Field name
	 * @param	string	$prefix	HTML start tag
	 * @param 	string	$suffix	HTML end tag
	 * @return	string
	 */
	public function error($field, $prefix = '', $suffix = '')
	{
		if (empty($this->_field_data[$field]['error']))
		{
			return '';
		}

		if ($prefix === '')
		{
			$prefix = $this->_error_prefix;
		}

		if ($suffix === '')
		{
			$suffix = $this->_error_suffix;
		}
                
                $id = $this->err_id.$field;
                
                $prefix = substr_replace($prefix,$id, -1, 0);

		return $prefix.$this->_field_data[$field]['error'].$suffix;
	}

}