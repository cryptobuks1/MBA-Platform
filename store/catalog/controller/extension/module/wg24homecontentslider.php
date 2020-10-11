<?php
class ControllerExtensionModuleWg24HomeContentSlider extends Controller {
	public function index($setting) {
                  $data['button_cart'] = $this->language->get('button_cart');
            $data['button_wishlist'] = $this->language->get('button_wishlist');
            $data['button_compare'] = $this->language->get('button_compare');
            
            static $module = 0;
             // options data
                    $save_value = array(
                        'wg24themeoptionpanel_homepage123_prallax',
                         'wg24themeoptionpanel_hometext_prallax',
                        'wg24themeoptionpanel_t_category_prallax',
                         'wg24themeoptionpanel_quicviewtext_prallax', 
                          'wg24themeoptionpanel_newtext_prallax',
                    'wg24themeoptionpanel_saletext_prallax',
                        'wg24themeoptionpanel_populartext_prallax',
                        'wg24themeoptionpanel_home1leftcollec_prallax',
                        'wg24themeoptionpanel_cateletbanner_prallax',
                        'wg24themeoptionpanel_home1bestsaletext_prallax',
                        'wg24themeoptionpanel_populartexttext_prallax',
                        'wg24themeoptionpanel_home1toprattingtext_prallax',
                        'wg24themeoptionpanel_home1Specialtext_prallax',
                        'wg24themeoptionpanel_mcostomblock_prallax',
                         'wg24themeoptionpanel_blogtoptext_prallax'
                        
                    ); 
                    $lang=$this->config->get('config_language_id'); 
                    foreach ($save_value as $loadvalue) {  
                    if ($this->config->get($loadvalue.'_'.$lang)) {
                    $data[$loadvalue] = $this->config->get($loadvalue.'_'.$lang);
                    }else{
                    $data[$loadvalue] = $this->config->get($loadvalue);
                    } 
                    } 
                    
                      // Menu
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
                $this->load->model('tool/image');
		$data['categories'] = array();
		$categories = $this->model_catalog_category->getCategories(0);
		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {
				

				$children_data3 = array();

				$children3 = $this->model_catalog_category->getCategories($child['category_id']);


					foreach ($children3 as $child3){
					$filter_data3 = array(
						'filter_category_id'  => $child3['category_id'],
						'filter_sub_category' => true
					);

					$children_data3[] = array(
						'name'  => $child3['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data3) . ')' : ''),
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'].'_'.$child3['category_id']),
						
					);
				}

					$filter_data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);

					$children_data[] = array(
						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id']),
						'children3' => $children_data3
					);

				}

				// Level 1
				$data['categories'][] = array(
					'name'     => $category['name'],
					'children' => $children_data,
					'category_id'=>$category['category_id'],
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);




			}
		}
                
            /*popular product */
                $data['pproducts'] = array();
                $data['tags'] = array();
                $results = $this->model_catalog_product->getPopularProducts(15);
                if (is_array($results) || is_object($results))
                {
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'],270,270);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', 270,270);
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
                              

                                if ($result['tag']) {
                                        $tags = explode(',', $result['tag']);
                                        foreach ($tags as $tag) {
                                                $data['tags'][] = array(
                                                        'tag'  => trim($tag),
                                                        'href' => $this->url->link('product/search', 'tag=' . trim($tag))
                                                );
                                        }
                                }


				$data['pproducts'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $result['rating'],
					'href'        => $this->url->link('product/product','product_id=' . $result['product_id']),
                                     'quickview'        => $this->url->link('product/product/quickview', 'product_id=' . $result['product_id'])
				);
			}
                        
                }
                          /*best sale product */
                          $data['bestsales'] = array();

                         $results1 = $this->model_catalog_product->getBestSellerProducts(15);
			foreach ($results1 as $result) {
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

				$data['bestsales'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $result['rating'],
					'href'        => $this->url->link('product/product','product_id=' . $result['product_id']),
                                     'quickview'        => $this->url->link('product/product/quickview', 'product_id=' . $result['product_id'])
				);
			}
                        
                        /* home 3 top menu prodcut  */
                $this->load->model('design/wg24homebanner');
               $sfilter_data = array(
                'sort'  => 'pd.name',
                'order' => 'ASC',
                'start' => 0,
                'limit' => 3
		);
                    
            for($clop=1;$clop<=4;++$clop){  
                 if ($clop==1) {
                     $miniproducts='mpopularproducts';
                      $miniproduct1 = $this->model_catalog_product->getPopularProducts(3);
               }
                if ($clop==2) {
                     $miniproducts='mbestsales';
                      $miniproduct1 = $this->model_catalog_product->getBestSellerProducts(3);
               } 
               if ($clop==3) {
                      $miniproducts='mtoprated';
                       $miniproduct1 = $this->model_design_wg24homebanner->getTopRated(3);   
               }
              if ($clop==4) {
                      $miniproducts='mspecials';
                       $miniproduct1 = $this->model_catalog_product->getProductSpecials($sfilter_data); 
               } 
               
                 $data[$miniproducts] = array();
		if ($miniproduct1) {
			foreach ($miniproduct1 as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'],270,270);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', 270,270);
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
                        


		$this->load->model('design/wg24homebanner');
		$this->load->model('tool/image');
		$data['banners'] = array();

		$results = $this->model_design_wg24homebanner->getBannerImages($setting['banner_id']);
		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['banners'][] = array(
					'description' => $result['description'],
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
				);
			}
		}
		 $data['module'] = $module++;
		return $this->load->view('extension/module/wg24homecontentslider', $data);
               
	}
}