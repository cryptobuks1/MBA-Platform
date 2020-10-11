<?php
class ControllerCommonHeader extends Controller {
	public function index() {
		// Analytics
		$this->load->model('extension/extension');
                
                // options data
                        $data['button_cart'] = $this->language->get('button_cart');
            $data['button_wishlist'] = $this->language->get('button_wishlist');
            $data['button_compare'] = $this->language->get('button_compare');
                $data['blogs'] = $this->url->link('extension/module/wg24blog');
                    $save_value = array(
                    'wg24themeoptionpanel_ret_mheader_prallax',
                    'wg24themeoptionpanel_megamenushow_prallax',
                   'wg24themeoptionpanel_firstmegamenu1_prallax',
                   'wg24themeoptionpanel_firstmegamenu2_prallax',
                    'wg24themeoptionpanel_firstmegamenu12_prallax',
                   'wg24themeoptionpanel_firstmegamenu22_prallax' ,
                        'wg24themeoptionpanel_hometext_prallax',
                        'wg24themeoptionpanel_t_category_prallax',
                        'wg24themeoptionpanel_homepage123_prallax',
                        'wg24themeoptionpanel_blogtoptext_prallax',
                         'wg24themeoptionpanel_quicviewtext_prallax', 
                          'wg24themeoptionpanel_newtext_prallax',
                    'wg24themeoptionpanel_saletext_prallax',
                         'wg24themeoptionpanel_populartext_prallax',
                          'wg24themeoptionpanel_home1bestsaletext_prallax',
                        'wg24themeoptionpanel_populartexttext_prallax',
                        'wg24themeoptionpanel_home1toprattingtext_prallax',
                        'wg24themeoptionpanel_home1Specialtext_prallax',
                        'wg24themeoptionpanel_mcostomblock_prallax'
                        
                    ); 
                    $lang=$this->config->get('config_language_id'); 
                    foreach ($save_value as $loadvalue) {  
                    if ($this->config->get($loadvalue.'_'.$lang)) {
                    $data[$loadvalue] = $this->config->get($loadvalue.'_'.$lang);
                    }else{
                    $data[$loadvalue] = $this->config->get($loadvalue);
                    } 
                    } 
                
                
                
                
                

		$data['analytics'] = array();
		$analytics = $this->model_extension_extension->getExtensions('analytics');
		foreach ($analytics as $analytic) {
			if ($this->config->get($analytic['code'] . '_status')) {
				$data['analytics'][] = $this->load->controller('extension/analytics/' . $analytic['code'], $this->config->get($analytic['code'] . '_status'));
			}
		}

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->document->addLink($server . 'image/' . $this->config->get('config_icon'), 'icon');
		}

		$data['title'] = $this->document->getTitle();

		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$this->load->language('common/header');

		$data['text_home'] = $this->language->get('text_home');

		// Wishlist
		if ($this->customer->isLogged()) {
			$this->load->model('account/wishlist');

			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());
		} else {
			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}

		$data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', true), $this->customer->getFirstName(), $this->url->link('account/logout', '', true));

		$data['text_account'] = $this->language->get('text_account');
		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_all'] = $this->language->get('text_all');

		$data['home'] = $this->url->link('common/home');
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['logged'] = $this->customer->isLogged();
		$data['account'] = $this->url->link('account/account', '', true);
		$data['register'] = $this->url->link('register/packages', '', true);
		$data['login'] = $this->url->link('account/login', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['transaction'] = $this->url->link('account/transaction', '', true);
		$data['download'] = $this->url->link('account/download', '', true);
		$data['logout'] = $this->url->link('account/logout', '', true);
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', true);
		$data['contact'] = $this->url->link('information/contact');
		$data['telephone'] = $this->config->get('config_telephone');
                
                
                
                
                

		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

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
					
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);




			}
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
			$this->load->model('tool/image');
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
                
                
                
                
                 $data['custommenulink'] = $this->load->controller('extension/module/wg24custommenu');
                $data['customstyle'] = $this->load->controller('common/customstyle');
		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = $this->load->controller('common/cart');

		// For page specific css
		if (isset($this->request->get['route'])) {
			if (isset($this->request->get['product_id'])) {
				$class = '-' . $this->request->get['product_id'];
			} elseif (isset($this->request->get['path'])) {
				$class = '-' . $this->request->get['path'];
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$class = '-' . $this->request->get['manufacturer_id'];
			} elseif (isset($this->request->get['information_id'])) {
				$class = '-' . $this->request->get['information_id'];
			} else {
				$class = '';
			}

			$data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
		} else {
			$data['class'] = 'common-home';
		}

		return $this->load->view('common/header', $data);
	}
}
