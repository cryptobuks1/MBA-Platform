<?php
class ControllerCommonFooter1 extends Controller {
	public function index() {
            
            // options data
                    $save_value = array(
                    'wg24themeoptionpanel_home1testimonial_prallax', 
                        'wg24themeoptionpanel_footer_about_info_prallax',
                        'wg24themeoptionpanel_footer_copy_text_prallax',
                        'wg24themeoptionpanel_fot_paypla_id_prallax',
                        'wg24themeoptionpanel_fot_ccstripe_id_prallax',
                        'wg24themeoptionpanel_fot_visa_id_prallax',
                        'wg24themeoptionpanel_fot_mastercard_id_prallax',
                        'wg24themeoptionpanel_fot_americanexpress_id_prallax',
                        'wg24themeoptionpanel_fot_paycon_1_prallax_add',
                        'wg24themeoptionpanel_fot_cus_pay1_id_prallax',
                         'wg24themeoptionpanel_fot_paycon_2_prallax_add',
                        'wg24themeoptionpanel_fot_cus_pay2_id_prallax',
                        'wg24themeoptionpanel_face_b_icon_url_prallax',
                        'wg24themeoptionpanel_twitt_icon_url_prallax',
                        'wg24themeoptionpanel_google_icon_url_prallax',
                        'wg24themeoptionpanel_skype_icon_url_prallax',
                        'wg24themeoptionpanel_flowustext_prallax',
                        'wg24themeoptionpanel_newslettertext_prallax'
                    ); 
                    $lang=$this->config->get('config_language_id'); 
                    foreach ($save_value as $loadvalue) {  
                    if ($this->config->get($loadvalue.'_'.$lang)) {
                    $data[$loadvalue] = $this->config->get($loadvalue.'_'.$lang);
                    }else{
                    $data[$loadvalue] = $this->config->get($loadvalue);
                    } 
                    } 
            
            
            
		$this->load->language('common/footer');
		$data['scripts'] = $this->document->getScripts('footer');
		$data['text_information'] = $this->language->get('text_information');
		$data['text_service'] = $this->language->get('text_service');
		$data['text_extra'] = $this->language->get('text_extra');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_sitemap'] = $this->language->get('text_sitemap');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_special'] = $this->language->get('text_special');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_newsletter'] = $this->language->get('text_newsletter');

		$this->load->model('catalog/information');

		$data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}
		}

		$data['contact'] = $this->url->link('information/contact');
		$data['return'] = $this->url->link('account/return/add', '', true);
		$data['sitemap'] = $this->url->link('information/sitemap');
		$data['manufacturer'] = $this->url->link('product/manufacturer');
		$data['voucher'] = $this->url->link('account/voucher', '', true);
		$data['affiliate'] = $this->url->link('affiliate/account', '', true);
		$data['special'] = $this->url->link('product/special');
		$data['account'] = $this->url->link('account/account', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['newsletter'] = $this->url->link('account/newsletter', '', true);
                $data['fnewslatter'] = $this->load->controller('extension/module/advanced_newsletter');

		$data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer);
		}

		return $this->load->view('common/footer1', $data);
	}
}
