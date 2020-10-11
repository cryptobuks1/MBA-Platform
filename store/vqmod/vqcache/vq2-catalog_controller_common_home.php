<?php
class ControllerCommonHome extends Controller {
	public function index() {
            // options data
            $data['button_cart'] = $this->language->get('button_cart');

                
                    $data['text_product_pv_value'] = (MLM_PLAN == "Binary") ? $this->language->get('text_product_pv_value') : $this->language->get('text_product_bv_value');
                
            
            $data['button_wishlist'] = $this->language->get('button_wishlist');
            $data['button_compare'] = $this->language->get('button_compare');
            
            
                    $save_value = array(
                        'wg24themeoptionpanel_hometext_prallax',
                        'wg24themeoptionpanel_t_category_prallax',
                         'wg24themeoptionpanel_quicviewtext_prallax', 
                    'wg24themeoptionpanel_newtext_prallax',
                    'wg24themeoptionpanel_saletext_prallax',
                        'wg24themeoptionpanel_populartext_prallax',
                        'wg24themeoptionpanel_home1leftcollec_prallax',
                        'wg24themeoptionpanel_home1megasale_prallax',
                        'wg24themeoptionpanel_home1ourpeocuttext_prallax',
                        'wg24themeoptionpanel_home1freedeliverymes_prallax',
                         'wg24themeoptionpanel_home2freedeliverymes_prallax',
                        'wg24themeoptionpanel_home2dealoftheday_prallax',
                        'wg24themeoptionpanel_home1latesttext_prallax',
                        'wg24themeoptionpanel_twit_id_prallax',
                        'wg24themeoptionpanel_count_twitter_prallax',
                        'wg24themeoptionpanel_homepage123_prallax',
                        'wg24themeoptionpanel_home3hotdealbanner_prallax'
                        
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
                   $filter_new = array(
			'sort'  => 'p.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' =>$this->config->get('wg24themeoptionpanel_newproductlimit_prallax')
		);
             $this->load->model('catalog/product');
            $newproducts = $this->model_catalog_product->getProducts($filter_new);
            if ($newproducts){
			foreach ($newproducts as $result) {
				$data['is_new'][] = array(
					'product_id'  => $result['product_id'],
				);
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
              
                $results = $this->model_catalog_product->getPopularProducts(5);
                 $results = array();
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
                /* category product showing */
                 $categories1 = $this->model_catalog_category->getCategories(0);
                 $catelop=1;
		foreach ($categories1 as $category2) {
			if ($category2['top']) {
                             if ($catelop<2) {
                                 $catid1=$category2['category_id'];
                            } 
                              if ($catelop<3) {
                                 $catid2=$category2['category_id'];
                            }
                            if ($catelop<4) {
                                 $catid3=$category2['category_id'];
                            } 
                             if ($catelop<5) {
                                 $catid4=$category2['category_id'];
                            } 
                              if ($catelop<6) {
                                 $catid5=$category2['category_id'];
                            } 
                         $catelop=$catelop+1; 
                          }    
		}
     if(isset($catid1)){ $catid1; }else{$catid1='';}
     if(isset($catid2)){ $catid2; }else{$catid2='';}
    if(isset($catid3)){ $catid3; }else{$catid3='';}
    if(isset($catid4)){ $catid4; }else{$catid4='';}
    if(isset($catid5)){ $catid5; }else{$catid5='';}
        for($clop=1;$clop<=5;++$clop){
               if ($clop==1) {
                     $filter_cpdata=$clop;
                     $catid=$catid1;
                     $catproducts='catproducts1';
               } 
               if ($clop==2) {
                    $filter_cpdata=$clop;
                     $catid=$catid2;
                      $catproducts='catproducts2';
                      
               }
                 if ($clop==3) {
                    $filter_cpdata=$clop;
                     $catid=$catid3;
                      $catproducts='catproducts3';
               } 
                 if ($clop==4) {
                    $filter_cpdata=$clop;
                     $catid=$catid4;
                      $catproducts='catproducts4';
               } 
               if ($clop==5) {
                    $filter_cpdata=$clop;
                     $catid=$catid5;
                      $catproducts='catproducts5';
               } 
            $filter_cpdata = array(
                         'filter_category_id' =>$catid,
                         'order' => 'ASC',
			'start' => 0,
			'limit' => 20
		);          
                 $data[$catproducts] = array();
                $catproducts1 = $this->model_catalog_product->getProducts($filter_cpdata);
			foreach ($catproducts1 as $result) {
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

				$data[$catproducts][] = array(
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
                
        /* mini prodctus */
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		if (isset($this->request->get['route'])) {
			$this->document->addLink($this->config->get('config_url'), 'canonical');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


                
                    if (isset($this->session->data['error_redirect']) && $this->session->data['error_redirect']) {
                        $data['error_redirect'] = $this->session->data['error_redirect'];
                        $this->session->data['error_redirect'] = '';
                    }
                    else {
                        $data['error_redirect'] = '';
                    }
                
            
		$this->response->setOutput($this->load->view('common/home', $data));
	}
        
        

}
