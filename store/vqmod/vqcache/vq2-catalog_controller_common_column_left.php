<?php
class ControllerCommonColumnLeft extends Controller {
	public function index() {
            
            // options data
                    $data['button_cart'] = $this->language->get('button_cart');

                
                    $data['text_product_pv_value'] = (MLM_PLAN == "Binary") ? $this->language->get('text_product_pv_value') : $this->language->get('text_product_bv_value');
                
            
            $data['button_wishlist'] = $this->language->get('button_wishlist');
            $data['button_compare'] = $this->language->get('button_compare');
        
                    $save_value = array(
                         'wg24themeoptionpanel_quicviewtext_prallax', 
                          'wg24themeoptionpanel_newtext_prallax',
                    'wg24themeoptionpanel_saletext_prallax',
                        'wg24themeoptionpanel_populartext_prallax',
                        'wg24themeoptionpanel_cateletbanner_prallax'
                        
                    ); 
                    $lang=$this->config->get('config_language_id'); 
                    foreach ($save_value as $loadvalue) {  
                    if ($this->config->get($loadvalue.'_'.$lang)) {
                    $data[$loadvalue] = $this->config->get($loadvalue.'_'.$lang);
                    }else{
                    $data[$loadvalue] = $this->config->get($loadvalue);
                    } 
                    } 
                    
                    	$this->load->model('catalog/category');
		$this->load->model('catalog/product');
                $this->load->model('tool/image');
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

                
                    'pair_value'        => $result['pair_value'],
                
            
                                         'quickview'        => $this->url->link('product/product/quickview', 'product_id=' . $result['product_id'])
				);
			}
                    
                 }
                    
                    
            
            
		$this->load->model('design/layout');
                
                

		if (isset($this->request->get['route'])) {
			$route = (string)$this->request->get['route'];
		} else {
			$route = 'common/home';
		}

		$layout_id = 0;

		if ($route == 'product/category' && isset($this->request->get['path'])) {
			$this->load->model('catalog/category');

			$path = explode('_', (string)$this->request->get['path']);

			$layout_id = $this->model_catalog_category->getCategoryLayoutId(end($path));
		}

		if ($route == 'product/product' && isset($this->request->get['product_id'])) {
			$this->load->model('catalog/product');

			$layout_id = $this->model_catalog_product->getProductLayoutId($this->request->get['product_id']);
		}

		if ($route == 'information/information' && isset($this->request->get['information_id'])) {
			$this->load->model('catalog/information');

			$layout_id = $this->model_catalog_information->getInformationLayoutId($this->request->get['information_id']);
		}

		if (!$layout_id) {
			$layout_id = $this->model_design_layout->getLayout($route);
		}

		if (!$layout_id) {
			$layout_id = $this->config->get('config_layout_id');
		}

		$this->load->model('extension/module');

		$data['modules'] = array();

		$modules = $this->model_design_layout->getLayoutModules($layout_id, 'column_left');

		foreach ($modules as $module) {
			$part = explode('.', $module['code']);

			if (isset($part[0]) && $this->config->get($part[0] . '_status')) {
				$module_data = $this->load->controller('extension/module/' . $part[0]);

				if ($module_data) {
					$data['modules'][] = $module_data;
				}
			}

			if (isset($part[1])) {
				$setting_info = $this->model_extension_module->getModule($part[1]);

				if ($setting_info && $setting_info['status']) {
					$output = $this->load->controller('extension/module/' . $part[0], $setting_info);

					if ($output) {
						$data['modules'][] = $output;
					}
				}
			}
		}

		return $this->load->view('common/column_left', $data);
	}
}
