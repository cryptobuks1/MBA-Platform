<?php
class ControllerExtensionModuleFeatured extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/featured');
                
                 // options data
                    $save_value = array(
                    'wg24themeoptionpanel_quicviewtext_prallax', 
                    'wg24themeoptionpanel_newtext_prallax',
                    'wg24themeoptionpanel_saletext_prallax',
                     'wg24themeoptionpanel_home1ourpeocuttext_prallax',
                      'wg24themeoptionpanel_home1bestsaletext_prallax',
                     'wg24themeoptionpanel_home1newproducttext_prallax',  
                      'wg24themeoptionpanel_home1Specialtext_prallax',    
                    'wg24themeoptionpanel_homepage123_prallax',
                        'wg24themeoptionpanel_home2parrallaxtheme_prallax'
                    ); 
                    $lang=$this->config->get('config_language_id'); 
                    foreach ($save_value as $loadvalue) {  
                    if ($this->config->get($loadvalue.'_'.$lang)) {
                    $data[$loadvalue] = $this->config->get($loadvalue.'_'.$lang);
                    }else{
                    $data[$loadvalue] = $this->config->get($loadvalue);
                    } 
                    } 
                /* new product  */
                   $filter_data = array(
			'sort'  => 'p.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' =>$this->config->get('wg24themeoptionpanel_newproductlimit_prallax')
		);
             $this->load->model('catalog/product');
            $results = $this->model_catalog_product->getProducts($filter_data);
            if ($results){
			foreach ($results as $result) {
				$data['is_new'][] = array(
					'product_id'  => $result['product_id'],
				);
			}

			
		}
                    

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_tax'] = $this->language->get('text_tax');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');
                /* custom all prodctu */
                /* mini product */
                       $sfilter_data = array(
			'sort'  => 'pd.name',
			'order' => 'ASC',
			'start' => 0,
			'limit' => 15
		);
                $nfilter_data = array(
			'sort'  => 'p.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' =>15
		);       
                       
                    
            for($clop=1;$clop<=3;++$clop){        
                if ($clop==1) {
                     $miniproducts='newproducts';
                      $miniproduct1 = $this->model_catalog_product->getProducts($nfilter_data);
               } 
               if ($clop==2) {
                      $miniproducts='bestsales';
                       $miniproduct1 = $this->model_catalog_product->getBestSellerProducts(15); 
               }
              if ($clop==3) {
                      $miniproducts='specials';
                       $miniproduct1 = $this->model_catalog_product->getProductSpecials($sfilter_data); 
               } 
               
                 $data[$miniproducts] = array();
		if ($miniproduct1) {
			foreach ($miniproduct1 as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'],200,200);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png',200,200);
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
                                        'quickview'        => $this->url->link('product/product/quickview', 'product_id=' . $result['product_id'])
				);
			}
                }
                 
                  
                
                  }
                
                
                
                
                
                
                
                
                
                /* featured product  */

		$data['products'] = array();

		if (!$setting['limit']) {
			$setting['limit'] = 4;
		}

		if (!empty($setting['product'])) {
			$products = array_slice($setting['product'], 0, (int)$setting['limit']);

			foreach ($products as $product_id) {
				$product_info = $this->model_catalog_product->getProduct($product_id);

				if ($product_info) {
					if ($product_info['image']) {
						$image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					}

					if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$price = false;
					}

					if ((float)$product_info['special']) {
						$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$special = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = $product_info['rating'];
					} else {
						$rating = false;
					}

					$data['products'][] = array(
						'product_id'  => $product_info['product_id'],
						'thumb'       => $image,
						'name'        => $product_info['name'],
						'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
						'price'       => $price,
						'special'     => $special,
						'tax'         => $tax,
						'rating'      => $rating,
						'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
                                            'quickview'        => $this->url->link('product/product/quickview', 'product_id=' . $product_info['product_id'])
					);
				}
			}
		}

		if ($data['products']) {
			return $this->load->view('extension/module/featured', $data);
		}
	}
}