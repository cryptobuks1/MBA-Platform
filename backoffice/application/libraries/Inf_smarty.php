<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Smarty Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Smarty
 * @author		Kepler Gelotte
 * @link		https://www.coolphptools.com/codeigniter-smarty
 */
require_once( APPPATH.'third_party/Smarty/Smarty.class.php' );

class Inf_smarty extends Smarty {

	function __construct()
	{
		parent::__construct();

		$this->compile_dir = VIEWPATH . "templates_c/";
		$this->template_dir = VIEWPATH;
		$this->assign('APPPATH' , APPPATH);
		$this->assign('BASEPATH', BASEPATH);
		$base_url = base_url();
		$site_url = SITE_URL;
		$this->assign('PATH_TO_ROOT_DOMAIN', $base_url);
		$this->assign('PATH_TO_ROOT', $base_url);
		$this->assign('PUBLIC_URL', $base_url . "public_html/");
		$this->assign('COMPANY_LOGO', $base_url . "public_html/images/ioss_logo.png");
		$this->assign('SITE_URL', $site_url);
		
		$ci =& get_instance();
		if (method_exists($this, 'assignByRef')) {
			$this->assignByRef("ci", $ci);
		}

		log_message('debug', "Smarty Class Initialized");
		header("Access-Control-Allow-Methods: GET,POST,HEAD");		
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die('Method is not allowed by Access-Control-Allow-Methods');
        }
	}

	/**
	 *  Parse a template using the Smarty engine
	 *
	 * This is a convenience method that combines assign() and
	 * display() into one step. 
	 *
	 * Values to assign are passed in an associative array of
	 * name => value pairs.
	 *
	 * If the output is to be returned as a string to the caller
	 * instead of being output, pass true as the third parameter.
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @param	bool
	 * @return	string
	 */
	function view($template, $data = array(), $return = FALSE)
	{
		foreach ($data as $key => $val)
		{
			$this->assign($key, $val);

		}
		$CI =& get_instance();
		$CI->load->helper('url');
		$base_template = 'layout/app.tpl';
		$content_block = 'content';

		$replica_pages = ['replica_preview','replica_blockchain','replica_bitgo_gateway','replica_bitcoin_payment','replica_authorizeNetPayment','replica_pay_now','replica_payeer','replica_sofort_payment','replica_sofort_register','replica_squareup_gateway'];

		if ($CI->LOG_USER_ID && (uri_string() != 'replica_register' && !in_array($CI->uri->segment(1),$replica_pages))) {
			$content_block = 'main';
			if (in_array($CI->LOG_USER_TYPE, ['admin', 'employee'])) {
				$base_template = 'layout/admin.tpl';
			} elseif (in_array($CI->LOG_USER_TYPE, ['user'])) {
				$base_template = 'layout/user.tpl';
			}
		}

        if($CI->CURRENT_CTRL == 'replica') {
            $base_template = 'replica/app.tpl';
            $content_block = 'content';
        } elseif($CI->CURRENT_CTRL == 'lcp') {
        	$base_template = 'lcp/app.tpl';
            $content_block = 'content';
        }
                
		$this->assign('BASE_TEMPLATE', $base_template);
		$this->assign('CONTENT_BLOCK', $content_block);

		$theme_setting = $CI->validation_model->getThemeSetting();
		$this->assign('THEME_SETTING', $theme_setting);

		if ($return == FALSE)
	{
			$default_src = "default-src 'self' https://*.cloudfront.net/ https://d3hb14vkzrxvla.cloudfront.net/ https://pci-connect.squareup.com/* https://va.tawk.to/ https://api.qrserver.com/ https://www.youtube.com/;";
			$connect_src = "connect-src 'self'  wss://ws-helpscout.pusher.com beaconapi.helpscout.net chatapi.helpscout.net wss://chatapi.helpscout.net https://*.cloudfront.net/ https://d3hb14vkzrxvla.cloudfront.net/ https://pci-connect.squareup.com/* wss://ws.blockchain.info/inv https://*.tawk.to/ wss://*.tawk.to/ https://api.qrserver.com/ ;";
			$script_src = "script-src *  'unsafe-inline' 'unsafe-eval' https://*.cloudfront.net/* https://d3hb14vkzrxvla.cloudfront.net/* https://cdnjs.cloudflare.com https://www.statcounter.com https://embed.tawk.to https://ajax.googleapis.com https://code.jquery.com; ";
			$style_src = "style-src 'self'  'unsafe-inline' 'unsafe-eval' https://*.cloudfront.net/* https://d3hb14vkzrxvla.cloudfront.net/* https://fonts.googleapis.com/ https://cdn.jsdelivr.net/ https://cdnjs.cloudflare.com;";
			$font_src = "font-src 'self' https://*.cloudfront.net/* https://d3hb14vkzrxvla.cloudfront.net/* https://fonts.gstatic.com https://*.tawk.to/ https://cdnjs.cloudflare.com;";
			$img_src = "img-src * data:;";
			$frame_src = "frame-src * data:;";
			$CI->output->set_header("Content-Security-Policy: {$default_src} {$connect_src} {$script_src} {$style_src} {$font_src} {$img_src} {$frame_src}"); 
            $CI->output->set_header('X-FRAME-OPTIONS: SAMEORIGIN');
            $this->setFormErrorFromFlashData($CI);

			if (method_exists( $CI->output, 'set_output' ))
			{
				$CI->output->set_output( $this->fetch($template) );
			}
			else
			{	
				$CI->output->final_output = $this->fetch($template);
			}
                return;
		}
		else
		{
			return $this->fetch($template);
		}
	}

	public function setFormErrorFromFlashData($CI)
	{
		if ($CI->session->flashdata('form_error_redirect')) {
            foreach ($CI->session->flashdata('form_error_redirect') as $field => $error) {
                $CI->form_validation->set_form_error($field, $error);
            }
            $CI->form_validation->set_error_delimiters("<div style='color:#b94a48;'>", "</div>");
        }
	}
    
}

// END Smarty Class
