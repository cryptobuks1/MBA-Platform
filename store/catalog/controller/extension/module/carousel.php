<?php
class ControllerExtensionModuleCarousel extends Controller {
	public function index($setting) {
		$this->load->model('design/banner');
		$this->load->model('tool/image');
                
                /* options  */
                $this->load->model('catalog/category');
		$this->load->model('catalog/product');

                 $save_value = array(
                       'wg24themeoptionpanel_miniproducts_prallax',
                     'wg24themeoptionpanel_home1bestsaletext_prallax',
                     'wg24themeoptionpanel_home1toprattingtext_prallax',  
                      'wg24themeoptionpanel_home1Specialtext_prallax',  
                     'wg24themeoptionpanel_homepage123_prallax',
                     'wg24themeoptionpanel_home3minibanner_prallax'
                    ); 
                    $lang=$this->config->get('config_language_id'); 
                    foreach ($save_value as $loadvalue) {  
                    if ($this->config->get($loadvalue.'_'.$lang)) {
                    $data[$loadvalue] = $this->config->get($loadvalue.'_'.$lang);
                    }else{
                    $data[$loadvalue] = $this->config->get($loadvalue);
                    } 
                    } 
                    
                 /* mini product */
                    $this->load->model('design/wg24homebanner');
                       $sfilter_data = array(
			'sort'  => 'pd.name',
			'order' => 'ASC',
			'start' => 0,
			'limit' => 15
		);
                    
            for($clop=1;$clop<=3;++$clop){        
                if ($clop==1) {
                     $miniproducts='bestsales';
                      $miniproduct1 = $this->model_catalog_product->getBestSellerProducts(15);
               } 
               if ($clop==2) {
                      $miniproducts='toprated';
                       $miniproduct1 = $this->model_design_wg24homebanner->getTopRated(15);   
               }
              if ($clop==3) {
                      $miniproducts='specials';
                       $miniproduct1 = $this->model_catalog_product->getProductSpecials($sfilter_data); 
               } 
               
                 $data[$miniproducts] = array();
		if ($miniproduct1) {
			foreach ($miniproduct1 as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'],100,100);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', 100,100);
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}

				$data[$miniproducts][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id']),
				);
			}
                }
                else{
                 $data[$miniproducts]="test";   
                    
                }  
                  
                
                  }
                    
              /* end option */   
                    
                    
                    
                    
                
                static $module = 0;

		$data['banners'] = array();

		$results = $this->model_design_banner->getBanner($setting['banner_id']);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['banners'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
				);
			}
		}

		$data['module'] = $module++;

		return $this->load->view('extension/module/carousel', $data);
	}
}